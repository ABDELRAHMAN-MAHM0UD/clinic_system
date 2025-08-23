<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
       public function index()
    {
        return view('adminDashboard'); // أو أي view عاملها
    }
}
