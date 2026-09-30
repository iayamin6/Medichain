<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicalTravelController extends Controller
{
    public function index()
    {
        return view('medical_travel.index');
    }
}