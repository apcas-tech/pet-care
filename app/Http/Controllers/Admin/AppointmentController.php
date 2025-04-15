<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pet;
use App\Models\PetOwner;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\VetContact;
use App\Mail\AppointmentQRCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendAppointmentQRCodeMailJob;
use App\Jobs\SendSmsNotificationJob;

class AppointmentController extends Controller
{
    /**
     * Display the appointment page with filters.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the authenticated admin
        $admin = auth('admins')->user();

        $query = Appointment::with(['pet', 'pet.owner', 'service', 'branch'])
            ->select('appointments.*') // Ensure you are selecting all columns from appointments
            ->join('pets', 'pets.id', '=', 'appointments.pet_id') // Join pets table
            ->whereHas('pet')
            ->whereHas('pet.owner');

        // Apply branch filtering if the admin is not a 'Super Admin'
        if ($admin->role !== 'Super Admin') {
            $query->where('appointments.branch_id', $admin->branch_id); // Use appointments.branch_id after the join
        }

        // Apply branch filter if selected
        if ($request->filled('branch')) {
            $query->where('appointments.branch_id', $request->input('branch')); // Filter by selected branch
        }

        // Apply filters
        if ($request->filled('date')) {
            $query->whereDate('appt_date', $request->input('date'));
        }
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('pet', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('pet.owner', function ($query) use ($search) {
                        $query->where(function ($ownerQuery) use ($search) {
                            $ownerQuery->where('Fname', 'like', '%' . $search . '%')
                                ->orWhere('Lname', 'like', '%' . $search . '%')
                                ->orWhere('Mname', 'like', '%' . $search . '%');
                        });
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply sorting logic: First prioritize pending appointments, then apply sorting by pet name
        $query->orderByRaw("
        CASE 
            WHEN status = 'Pending' THEN 1
            WHEN status = 'Scheduled' THEN 2
            WHEN status = 'Completed' THEN 3
            WHEN status = 'Cancelled' THEN 4
        END
    ");

        // Apply sorting by pet name in ascending or descending order based on the request
        if ($request->filled('sort')) {
            $sort = $request->input('sort') === 'desc' ? 'desc' : 'asc';
            $query->orderBy('pets.name', $sort);  // Now using pets.name after the join
        }

        // Fetch appointments and services
        $appointments = $query->paginate(30);
        $services = Service::all();
        $branches = VetContact::all(); // Fetch all branches

        $appointments->each(function ($appointment) {
            $owner = $appointment->pet->owner;
            $middleNameInitial = $owner->Mname ? strtoupper(substr($owner->Mname, 0, 1)) . '.' : '';
            $appointment->setAttribute('ownerName', trim("{$owner->Fname} {$middleNameInitial} {$owner->Lname}"));

            // Check if the branch exists before accessing its name
            if ($appointment->branch) {
                $appointment->setAttribute('branchName', $appointment->branch->name);
            } else {
                $appointment->setAttribute('branchName', 'N/A');
            }
        });

        return view('bfc-animalclinic-inner-system.appointment.appointment', compact('appointments', 'services', 'branches'));
    }

    public function store(Request $request)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('create', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        $validatedData = $request->validate([
            'owner_id' => 'required|exists:pet_owners,id',
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'appt_date' => 'required|date',
            'appt_time' => 'required|date_format:H:i',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'branch_id' => 'required|exists:vet_contacts,id', // Validate branch
        ]);

        try {
            $existingAppointment = Appointment::where('owner_id', $validatedData['owner_id'])
                ->where('pet_id', $validatedData['pet_id'])
                ->where('service_id', $validatedData['service_id'])
                ->where('appt_date', $validatedData['appt_date'])
                ->where('appt_time', $validatedData['appt_time'])
                ->first();

            if ($existingAppointment) {
                return back()->withErrors(['error' => 'Appointment Already Exists.']);
            }

            // Create the appointment
            $appointment = Appointment::create([
                'id' => Str::random(16),
                'owner_id' => $validatedData['owner_id'],
                'pet_id' => $validatedData['pet_id'],
                'service_id' => $validatedData['service_id'],
                'appt_date' => $validatedData['appt_date'],
                'appt_time' => $validatedData['appt_time'],
                'status' => $validatedData['status'],
                'notes' => $validatedData['notes'],
                'branch_id' => $validatedData['branch_id'], // Store branch ID
            ]);

            if ($appointment->status === 'Scheduled') {
                $owner = $appointment->pet->owner;
                $phoneNumber = $owner->phone; // Assuming the 'phone' field exists in the pet_owners table
                $petName = $appointment->pet->name;
                $service = $appointment->service; // Getting service related to appointment
                $serviceName = $service->service; // Service name from the 'service' column
                $serviceDescription = $service->description; // Service description
                $appointmentTime = $appointment->appt_time;
                $appointmentDate = $appointment->appt_date;

                // Get branch information
                $branch = $appointment->branch; // This will give you the associated VetContact
                $branchName = $branch->name; // Branch name
                $branchPhone = $branch->phone_number; // Branch phone number

                // Combine first and last name for the owner's full name
                $ownerFullName = $owner->Fname . ' ' . $owner->Lname;

                // Define the message for SMS, including the service description and branch info
                $message = "Appointment Confirmation: Dear " . $ownerFullName . ", your appointment for " . $petName . " has been confirmed for the service: " . $serviceName . " at " . $appointmentTime . " on " . $appointmentDate . ". If you have any concern, contact us at: " . $branchName . " - " . $branchPhone . ". Thank you!";

                // Send the SMS notification
                $smsSent = SendSmsNotificationJob::dispatch($phoneNumber, $message);
                $this->generateAndSendQrCode($appointment);
                if ($smsSent) {
                    return redirect()->back()->with('status', 'Appointment Added and SMS Sent Successfully!');
                } else {
                    return redirect()->back()->with('error', 'Appointment Added, but SMS Sending Failed.');
                }
            }

            return redirect()->back()->with('status', 'Appointment Added Successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to Create Appointment.']);
        }
    }

    public function fetchOwners()
    {
        $owners = PetOwner::select('id', 'Fname', 'Lname', 'Mname')->get();
        return response()->json($owners);
    }

    public function fetchPets($owner_id)
    {
        $pets = Pet::where('owner_id', $owner_id)->select('id', 'name')->get();
        return response()->json($pets);
    }

    public function show($id)
    {
        $appointment = Appointment::with(['pet.owner', 'service', 'branch'])->findOrFail($id);

        return response()->json([
            'id' => $appointment->id,
            'owner_name' => trim("{$appointment->pet->owner->Fname} " . ($appointment->pet->owner->Mname ? "{$appointment->pet->owner->Mname}. " : "") . "{$appointment->pet->owner->Lname}"),
            'pet_name' => $appointment->pet->name,
            'service_id' => $appointment->service->id,
            'branch_id' => $appointment->branch ? $appointment->branch->id : null, // Return branch ID, not name
            'appt_date' => $appointment->appt_date,
            'appt_time' => $appointment->appt_time,
            'status' => $appointment->status,
            'notes' => $appointment->notes,
        ]);
    }

    public function update(Request $request, $id)
    {
        $adminCapabilities = auth('admins')->user()->capabilities;
        $adminCapabilities = is_string($adminCapabilities) ? json_decode($adminCapabilities, true) : ($adminCapabilities ?? []);

        if (!in_array('edit', $adminCapabilities)) {
            session()->flash('error', 'Unauthorized action. You do not have permission to create appointments.');
            return redirect()->back();
        }

        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Validate the request, ensuring the branch is included
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'branch_id' => 'required|exists:vet_contacts,id', // Validate branch
            'appt_date' => 'required|date',
            'appt_time' => 'required',
            'status' => 'required|in:Pending,Scheduled,Completed,Cancelled',
            'notes' => 'nullable|string',
        ]);

        // Store the previous status to compare with the new status
        $previousStatus = $appointment->status;

        // Update the appointment with validated data
        $appointment->update($validated);

        // Check if the status has changed to 'Scheduled' and send an SMS if necessary
        if ($appointment->status === 'Scheduled' && $previousStatus !== 'Scheduled') {
            // Get the pet owner details
            $owner = $appointment->pet->owner;
            $phoneNumber = $owner->phone; // Assuming the 'phone' field exists in the pet_owners table
            $petName = $appointment->pet->name;
            $serviceName = $appointment->service->service; // Assuming service is related to appointment
            $serviceDescription = $appointment->service->description; // Service description
            $appointmentTime = $appointment->appt_time;
            $appointmentDate = $appointment->appt_date;

            // Get branch information
            $branch = $appointment->branch; // This will give you the associated VetContact
            $branchName = $branch->name; // Branch name
            $branchPhone = $branch->phone_number; // Branch phone number

            // Combine first and last name for the owner's full name
            $ownerFullName = $owner->Fname . ' ' . $owner->Lname;

            // Define the message for SMS, including the service description and branch info
            $message = "Appointment Confirmation: Dear " . $ownerFullName . ", your appointment for " . $petName . " has been confirmed for the service: " . $serviceName . " at " . $appointmentTime . " on " . $appointmentDate . ". If you have any concern, contact us at: " . $branchName . " - " . $branchPhone . ". Thank you!";

            // Send the SMS notification
            $smsSent = SendSmsNotificationJob::dispatch($phoneNumber, $message);
            $this->generateAndSendQrCode($appointment);
            if ($smsSent) {
                return redirect()->back()->with('status', 'Appointment Updated and SMS Sent Successfully!');
            } else {
                return redirect()->back()->with('error', 'Appointment Updated, but SMS Sending Failed.');
            }
        }

        return redirect()->back()->with('status', 'Appointment Updated Successfully!');
    }

    public function generateAndSendQrCode(Appointment $appointment)
    {
        // Define the path for the generated QR code
        $qrCodePath = storage_path('app/public/qr_codes/' . $appointment->id . '_qr.png');

        // Check if the QR code already exists
        if (file_exists($qrCodePath)) {
            return redirect()->route('admin.appointments')->with('status', 'QR Code has already been sent!');
        }

        // Generate QR Code as PNG (size 300px)
        $qrCode = QrCode::format('png')->size(300)->generate($appointment->id);

        // Save the generated QR code image
        file_put_contents($qrCodePath, $qrCode);

        // Path to your logo image
        $logoPath = public_path('imgs/logo.png');

        // Load the generated QR code and logo image
        $qrImage = imagecreatefrompng($qrCodePath);
        $logoImage = imagecreatefrompng($logoPath);

        // Get dimensions of QR code and logo
        $qrWidth = imagesx($qrImage);
        $qrHeight = imagesy($qrImage);
        $logoWidth = imagesx($logoImage);
        $logoHeight = imagesy($logoImage);

        // Resize the logo to fit within the QR code (reduce to 20% of the QR code's width)
        $logoResizeWidth = $qrWidth * 0.20; // Resize to 20% of the QR code width
        $logoResizeHeight = ($logoResizeWidth / $logoWidth) * $logoHeight;

        // Create a white background container for the QR code
        $containerWidth = $qrWidth + 40; // Add 20px padding on each side
        $containerHeight = $qrHeight + 40; // Add 20px padding on each side
        $container = imagecreatetruecolor($containerWidth, $containerHeight);

        // Allocate a white color for the background
        $white = imagecolorallocate($container, 255, 255, 255); // White color
        imagefill($container, 0, 0, $white); // Fill the background with white

        // Copy the QR code image onto the white container
        imagecopy($container, $qrImage, 20, 20, 0, 0, $qrWidth, $qrHeight);

        // Resize the logo and copy it onto the QR code
        $logoResized = imagescale($logoImage, $logoResizeWidth, $logoResizeHeight);
        imagecopy($container, $logoResized, ($containerWidth / 2) - ($logoResizeWidth / 2), ($containerHeight / 2) - ($logoResizeHeight / 2), 0, 0, $logoResizeWidth, $logoResizeHeight);

        // Save the final QR code with logo
        imagepng($container, $qrCodePath);

        // Send the email with the QR code as an attachment
        $owner = $appointment->pet->owner;

        try {
            Mail::to($owner->email)->send(new AppointmentQRCodeMail($appointment, $qrCodePath));

            // ✅ Clean up memory
            imagedestroy($qrImage);
            imagedestroy($logoImage);
            imagedestroy($logoResized);
            imagedestroy($container);

            return redirect()->back()->with('status', 'Appointment QR Code Sent!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email.');
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|string|exists:appointments,id',
        ]);

        $appointment = Appointment::where('id', $request->appointment_id)->first();

        if (!$appointment) {
            return response()->json(['success' => false, 'message' => 'Invalid QR Code! Appointment not found.'], 404);
        }

        if ($appointment->status === 'Completed') {
            return response()->json(['success' => false, 'message' => 'Appointment is already Completed.'], 400);
        }

        // Update appointment status to 'Completed'
        $appointment->update(['status' => 'Completed']);

        // Delete the QR code if it exists after the status is set to 'Completed'
        $qrCodePath = storage_path('app/public/qr_codes/' . $appointment->id . '_qr.png');
        if (file_exists($qrCodePath)) {
            unlink($qrCodePath);
        }

        return response()->json(['success' => true, 'message' => 'Appointment is Completed and QR code deleted!']);
    }

    public function sendSmsNotification($phoneNumber, $message)
    {
        // Check if the phone number already includes a country code, if not, prepend the default country code
        $countryCode = '+63'; // Default to Philippines country code
        if (substr($phoneNumber, 0, strlen($countryCode)) !== $countryCode) {
            $phoneNumber = $countryCode . ltrim($phoneNumber, '0'); // Remove any leading zero and add the country code
        }

        // Prepare the phone number in international format
        $recipient = $phoneNumber; // Phone is now in correct format (e.g., +63...)

        // Get PhilSMS credentials
        $apiUrl = env('PHILSMS_URL');
        $apiKey = env('PHILSMS_API_KEY');
        $sender = env('PHILSMS_SENDER'); // Max 11 characters, no spaces

        // Validate API settings
        if (empty($apiUrl) || empty($apiKey)) {
            return false;
        }

        // Prepare the message payload
        $messageData = [
            'recipient' => $recipient,
            'sender_id' => $sender,
            'type' => 'plain',
            'message' => $message,
        ];

        // Send SMS via PhilSMS
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json',
            ])->post($apiUrl, $messageData);

            if ($response->successful() && $response->json()['status'] === 'success') {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
        return redirect()->route('admin.appointments')->with('status', 'Appointment Deleted Successfully!');
    }
}
