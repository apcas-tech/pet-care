<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\AdoptablePet; // Import the AdoptablePet model
use App\Models\Vaccinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VaccineController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Vaccination Form Data:', $request->all());

        // Validate incoming data
        try {
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
                'pet_type' => 'required|in:Pet,AdoptablePet', // Validate pet_type
                'vaccine_name' => 'nullable|string|max:255',
                'custom_vaccine_name' => 'nullable|string|max:255',
                'date_administered' => 'required|date',
                'next_due_date' => 'nullable|date|after_or_equal:date_administered',
                'administered_by' => 'required|string|max:255',
                'notes' => 'nullable|string|max:500',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error:', $e->errors());
            return redirect()->back()->withErrors($e->errors());
        }

        // Check if a custom vaccine name is provided, use it, otherwise fallback to the selected vaccine
        $vaccineName = $request->custom_vaccine_name ?: $request->vaccine_name;

        try {
            // Create a new vaccination record
            $vaccine = Vaccinations::create([
                'id' => Str::uuid(),
                'pet_id' => $request->pet_id,
                'pet_type' => $request->pet_type, // Store the pet_type
                'vaccine_name' => $vaccineName,
                'date_administered' => $request->date_administered,
                'next_due_date' => $request->next_due_date,
                'administered_by' => $request->administered_by,
                'notes' => $request->notes,
            ]);

            Log::info('Vaccine Inserted:', $vaccine->toArray());

            // Redirect back with a success message
            return redirect()->back()->with('status', 'Vaccination record added successfully.');
        } catch (\Exception $e) {
            Log::error('Error saving vaccination record: ' . $e->getMessage());
            return redirect()->back()->withErrors('Failed to add vaccination record. Please try again.');
        }
    }
}
