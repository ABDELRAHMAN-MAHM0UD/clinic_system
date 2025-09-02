<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;


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
  
    //Appointments
public function appointments()
{
    $appointments = Appointment::with(['doctor', 'patient'])
        //->where('doctor_id', Auth::id())   // ensures doctor only sees their own appointments
        ->orderBy('appointment_date')
        ->orderBy('appointment_time')
        ->paginate(10);

    return view('admin.appointments', compact('appointments'));
}


public function appointmentsEdit(Appointment $appointment)
{
    abort_unless($appointment->doctor_id === Auth::id(), 403);
    return view('admin.appointments_edit', compact('appointment'));
}

public function appointmentsUpdate(Request $request, Appointment $appointment)
{
    abort_unless($appointment->doctor_id === Auth::id(), 403);

    $data = $request->validate([
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
        'status'           => 'required|in:pending,confirmed,completed,cancelled',
    ]);

    // prevent collision with another appointment
    $exists = Appointment::where('doctor_id', $appointment->doctor_id)
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->where('id', '!=', $appointment->id)
        ->where('status', '!=', 'cancelled')
        ->exists();

    if ($exists) {
        return back()->withErrors(['appointment_time' => 'This slot is already booked.'])->withInput();
    }

    $appointment->update($data);

    return redirect()->route('admin.appointments')->with('success', 'Appointment updated!');
}

public function appointmentsDestroy(Appointment $appointment)
{
    abort_unless($appointment->doctor_id === Auth::id(), 403);
    $appointment->delete();
    return back()->with('success', 'Appointment deleted!');
}


}
