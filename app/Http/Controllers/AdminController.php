<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('adminDashboard'); // موجود مباشرة في views
    }

    public function doctors()
    {
        $doctors = Doctor::all(); 
        return view('admin.doctors', compact('doctors'));   
     }



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
}
