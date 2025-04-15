<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\VetContact;
use Illuminate\Http\Request;

class PatrolController extends Controller
{
    /**
     * Display a listing of the vet contacts.
     */
    public function index()
    {
        $vetContacts = VetContact::all(); // Retrieve all vet contacts
        return view('bfc_animalclinic.paw-patrol.vet_contact', compact('vetContacts'));
    }
}
