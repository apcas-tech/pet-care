<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PetOwner;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch real data from the database
        $totalPetOwners = PetOwner::count();
        $totalPets = Pet::count();
        $totalServices = Service::count();

        // Count appointments by status with correct case
        $pendingAppointments = Appointment::where('status', 'Pending')->count();
        $scheduledAppointments = Appointment::where('status', 'Scheduled')->count();
        $confirmedAppointments = Appointment::where('status', 'Completed')->count();
        $cancelledAppointments = Appointment::where('status', 'Cancelled')->count();

        // Fetch scheduled appointments for the calendar
        $appointments = Appointment::where('status', 'Scheduled')
            ->get()
            ->map(function ($appointment) {
                return [
                    'title' => $appointment->pet->name . ' - ' . $appointment->service->service,
                    'start' => $appointment->appt_date . 'T' . $appointment->appt_time,
                    'description' => $appointment->service->service,
                    'status' => 'Scheduled',
                    'notes' => $appointment->notes,
                    'totalAppointments' => 1
                ];
            });

        // Fetch PhilSMS balance
        // Fetch PhilSMS balance
        $philsmsBalance = null;
        try {
            $response = Http::withToken(env('PHILSMS_API_KEY'))
                ->accept('application/json')
                ->get('https://app.philsms.com/api/v3/balance');

            if ($response->successful()) {
                $data = $response->json();
                $philsmsBalance = $data['data']['remaining_balance'] ?? 'N/A';
            } else {
                $philsmsBalance = 'Error fetching balance';
            }
        } catch (\Exception $e) {
            $philsmsBalance = 'Exception occurred';
        }


        return view('bfc-animalclinic-inner-system.dashboard.dashboard', compact(
            'totalPetOwners',
            'totalPets',
            'totalServices',
            'pendingAppointments',
            'scheduledAppointments',
            'confirmedAppointments',
            'cancelledAppointments',
            'appointments',
            'philsmsBalance' // Pass the balance to the view
        ));
    }


    public function backup(Request $request)
    {
        $tables = $request->input('tables', []);

        if (empty($tables)) {
            return redirect()->back()->with('error', 'No tables selected.');
        }

        // Create a zip file to store all Excel backups
        $zipFileName = 'database_backup_' . now()->format('Ymd_His') . '.zip';
        $zipPath = storage_path('app/' . $zipFileName);
        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Could not create zip file.');
        }

        foreach ($tables as $table) {
            $data = DB::table($table)->get();
            $fileName = $table . '_' . now()->format('Ymd_His') . '.csv';
            $filePath = storage_path('app/' . $fileName);

            // Write data to CSV
            $handle = fopen($filePath, 'w');
            fputcsv($handle, array_keys((array) $data->first())); // Headers
            foreach ($data as $row) {
                fputcsv($handle, (array) $row);
            }
            fclose($handle);

            // Add to zip
            $zip->addFile($filePath, $fileName);
        }

        $zip->close();

        // Return zip file as download
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
