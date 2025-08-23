<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('adminDashboard'); // موجود مباشرة في views
    }

    public function doctors()
    {
        return view('admin.doctors');
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
