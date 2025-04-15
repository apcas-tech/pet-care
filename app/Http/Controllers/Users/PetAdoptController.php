<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdoptablePet;

class PetAdoptController extends Controller
{
    public function index()
    {
        $adoptablePets = AdoptablePet::paginate(10);
        return view('bfc_animalclinic.pet-listing.pet-adopt', compact('adoptablePets'));
    }

    public function show($id)
    {
        $pet = AdoptablePet::findOrFail($id);
        return view('bfc_animalclinic.pet-listing.pet-details', compact('pet'));
    }
}
