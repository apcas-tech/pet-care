<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\PetOwner;
use App\Models\Appointment;

class HomeController extends Controller
{
    public function index()
    {
        // Assuming the user is logged in, retrieve their pets
        $user = auth()->user();
        $pets = $user->pets; // Get the pets of the logged-in user

        // Count only appointments with status 'Scheduled'
        $appointmentCount = Appointment::where('owner_id', $user->id)
            ->where('status', 'Scheduled') // Filter by status 'Scheduled'
            ->count();

        return view('bfc_animalclinic.home.home', compact('pets', 'appointmentCount'));
    }
}
