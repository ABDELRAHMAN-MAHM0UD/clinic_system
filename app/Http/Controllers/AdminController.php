<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('adminDashboard');
    }

    // Duplicate doctors() method removed to fix redeclaration error.



    public function patients()
    {
        return view('admin.patients');
    }

    public function invoices()
    {
        return view('admin.invoices');
    }

    public function appointments()
    {
        return view('admin.appointments');
    }

    public function doctors()
{
    $doctors = Doctor::all(); 
    return view('admin.doctors', compact('doctors'));   
}

public function createDoctor()
{
    return view('admin.doctors.create');
}

public function doctorShow($id)
{
    $doctor = Doctor::with('appointments')->findOrFail($id);
    return view('admin.doctors.show', compact('doctor'));
}



public function storeDoctor(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:doctors,email',
        'specialization' => 'required|string|max:255',
    ]);

    DB::table('doctors')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'specialization' => $request->specialization,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('admin.doctors')->with('success', 'Doctor added successfully.');
}

}
