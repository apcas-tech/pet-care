<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    public function index()
    {
        return view('services.services');
    }
}
