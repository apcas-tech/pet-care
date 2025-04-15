<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\AdoptablePet;
use Illuminate\Http\Request;
use App\Models\Prescription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'pet_id' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Check if pet_id exists in either pets or adoptable_pets
                    if (!Pet::where('id', $value)->exists() && !AdoptablePet::where('id', $value)->exists()) {
                        $fail('The selected pet does not exist.');
                    }
                },
            ],
            'vet_id' => 'required|exists:admin_users,id',
            'description' => 'required|string',
            'tx_given' => 'required|string',
            'medication' => 'required|array|min:1',
            'medication.*' => 'required|string',
            'dosage' => 'required|array|min:1',
            'dosage.*' => 'required|string',
            'frequency' => 'required|array|min:1',
            'frequency.*' => 'required|string',
            'duration' => 'required|array|min:1',
            'duration.*' => 'required|string',
            'record_date' => 'required|date',
        ]);

        $prescription = [];
        foreach ($request->medication as $index => $med) {
            $prescription[] = [
                'name' => $med,
                'dosage' => $request->dosage[$index],
                'frequency' => $request->frequency[$index],
                'duration' => $request->duration[$index],
            ];
        }

        Prescription::create([
            'id' => Str::uuid(), // Generate UUID for prescription ID
            'pet_id' => $request->pet_id,
            'pet_type' => $request->pet_type,
            'record_date' => $request->record_date,
            'description' => $request->description,
            'tx_given' => $request->tx_given,
            'prescription' => $prescription,
            'vet_id' => $request->vet_id,
        ]);

        return back()->with('status', 'Prescription added successfully!');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:png|max:2048',
            'prescription_id' => 'required|exists:prescriptions,id',
        ]);

        // Define the exact path inside public/storage/signatures
        $fileName = 'signature_' . time() . '.png';
        $destinationPath = public_path('storage/signatures');

        // Ensure the directory exists
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Move the file manually
        $request->file('signature')->move($destinationPath, $fileName);

        // Save the public path (relative to public)
        $path = "storage/signatures/$fileName";

        // Store path in session (Temporary Storage)
        Session::put('vet_signature', $path);

        return response()->json([
            'success' => true,
            'redirect' => route('prescription.download', $request->prescription_id)
        ]);
    }

    public function download($id)
    {
        $prescription = Prescription::findOrFail($id);

        // Find pet details in either Pet or AdoptablePet
        $pet = Pet::find($prescription->pet_id) ?? AdoptablePet::find($prescription->pet_id);

        $petName = $pet->name ?? 'Unknown_Pet';
        $formattedDate = \Carbon\Carbon::parse($prescription->record_date)->format('Ymd'); // YYYYMMDD format

        // Generate a unique filename
        $filename = 'prescription_' . str_replace(' ', '_', $petName) . '_' . $formattedDate . '.pdf';

        // Retrieve signature path from session
        $signaturePath = session('vet_signature');

        // Generate PDF
        $pdf = Pdf::loadView('prescriptions.pdf', compact('prescription', 'pet', 'signaturePath'));

        // Schedule signature deletion after response is sent
        if ($signaturePath) {
            app()->terminating(function () use ($signaturePath) {
                $fullPath = public_path($signaturePath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
            });
        }

        // Clear session data
        Session::forget('vet_signature');

        return $pdf->download($filename);
    }
}
