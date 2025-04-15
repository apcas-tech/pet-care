<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Pet;
use App\Models\PetOwner;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use App\Models\Appointment;
use App\Models\VetContact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pets = $user->pets->map(function ($pet) {
            $pet->profile_pic_url = $pet->profile_pic ? asset('storage/' . $pet->profile_pic) : asset('imgs/default_pet.jpg');
            return $pet;
        });

        $branches = VetContact::all(); // Fetch all branches
        $services = Service::all();

        return view('bfc_animalclinic.book.book', compact('pets', 'services', 'branches'));
    }


    public function searchServices(Request $request)
    {
        $query = $request->get('query', '');


        $services = Service::where('service', 'like', '%' . $query . '%')
            ->get();

        return response()->json($services);
    }

    public function showAppointments()
    {
        // Ensure the user is a PetOwner
        $user = auth()->user();

        // Check if the authenticated user is indeed a PetOwner
        if ($user instanceof PetOwner) {
            // Retrieve only appointments with status 'Scheduled'
            $appointments = $user->appointments()->where('status', 'Scheduled')->with('pet', 'service')->get();

            return view('bfc_animalclinic.book.appointments', compact('appointments'));
        }

        // Handle the case where the authenticated user is not a PetOwner
        return redirect()->route('home.page')->with('error', 'User is not authorized to view appointments.');
    }

    public function store(Request $request)
    {
        Log::info('Request Data:', $request->all());

        $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'service_id' => 'required|exists:services,id',
            'branch_id' => 'required|exists:vet_contacts,id',
            'appt_date' => 'required|date_format:m-d-Y',
            'appt_time' => 'required|date_format:H:i:s',
            'notes' => 'nullable|string|max:500',
        ]);

        $appointmentId = Str::random(16);
        $user = auth()->user();
        $pet = Pet::find($request->input('pet_id'));

        $formattedDate = Carbon::createFromFormat('m-d-Y', $request->input('appt_date'))->format('Y-m-d');
        $formattedTime = $request->input('appt_time');

        if (Carbon::parse($formattedDate)->isBefore(Carbon::today())) {
            session()->flash('error', 'Booking date is invalid.');
            return redirect()->back();
        }

        $appointmentData = [
            'id' => $appointmentId,
            'owner_id' => $user->id,
            'pet_id' => $request->input('pet_id'),
            'service_id' => $request->input('service_id'),
            'branch_id' => $request->input('branch_id'), // Ensure this line is present
            'appt_date' => $formattedDate,
            'appt_time' => $formattedTime,
            'status' => 'Pending',
            'notes' => $request->input('notes'),
        ];

        Log::info('Appointment Data:', $appointmentData); // Log the appointment data

        Appointment::create($appointmentData);

        session()->flash('status', 'Booked for ' . $pet->name);
        return redirect()->route('home.page')->with('success', 'Appointment successfully booked.');
    }

    public function fetchAppointments(Request $request)
    {
        $serviceId = $request->input('service_id');
        $date = $request->input('date');
        $branchId = $request->input('branch_id'); // Get the branch ID from the request

        // Fetch appointments for the given service, date, and branch with status 'Scheduled'
        $appointments = Appointment::where('service_id', $serviceId)
            ->where('branch_id', $branchId) // Filter by branch ID
            ->where('appt_date', Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d'))
            ->where('status', 'Scheduled')
            ->get();

        return response()->json($appointments);
    }
}
