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
        $patients = DB::table('users')
            ->where('is_admin', '=', 0)
            ->get();
        return view('admin.patients', compact('patients'));
    }

    public function patientAppointments($id)
    {
        $appointments = Appointment::where('patient_id', $id)
            ->with(['doctor', 'patient'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        $patient = DB::table('users')->find($id);
        return view('admin.patient-appointments', compact('appointments', 'patient'));
    }

    public function patientMedicalHistory($id)
    {
        $appointments = Appointment::where('patient_id', $id)
            ->where('status', 'completed')
            ->with(['doctor'])
            ->orderBy('appointment_date', 'desc')
            ->get();
        $patient = DB::table('users')->find($id);
        return view('admin.patient-medical-history', compact('appointments', 'patient'));
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
        ->orderBy('appointment_date')
        ->orderBy('appointment_time')
        ->paginate(10);

    $doctors = Doctor::all(); // ✅ fetch real doctors for the dropdown

    return view('admin.appointments', compact('appointments', 'doctors'));
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
