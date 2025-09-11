<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function about()
    {
        return view('static.about');
    }

    public function mission()
    {
        return view('static.mission');
    }

    public function team()
    {
        return view('static.team');
    }

    public function careers()
    {
        return view('static.careers');
    }

    public function services()
    {
        return view('static.services');
    }

    public function emergency()
    {
        return view('static.emergency');
    }

    public function specialties()
    {
        return view('static.specialties');
    }

    public function insurance()
    {
        return view('static.insurance');
    }

    public function patientPortal()
    {
        return view('static.patient-portal');
    }

    public function faq()
    {
        return view('static.faq');
    }

    public function privacy()
    {
        return view('static.privacy');
    }

    public function terms()
    {
        return view('static.terms');
    }

    public function contact()
    {
        return view('static.contact');
    }
}
