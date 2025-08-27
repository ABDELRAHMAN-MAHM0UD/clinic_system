<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientController extends Controller
{

        public function index()
    {
        return view('dashboard'); 
    }
    public function medicalHis()
    {
        return view('patient.medical_history');
    }
    
    public function invoices()
    {
        return view('patient.invoices');
    }

    public function appointments()
    {
        return view('patient.appointments');
    }

    public function doctors()
{
    $doctors = Doctor::all(); 
    return view('patient.doctors', compact('doctors'));   
}
    public function doctorShow($id)
{
    $doctor = Doctor::with('appointments')->findOrFail($id);
    return view('patient.showDoctorsDetails', compact('doctor'));
}

    }

