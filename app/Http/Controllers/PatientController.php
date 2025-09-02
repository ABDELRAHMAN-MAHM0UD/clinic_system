<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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

    //Appointments

public function appointments()
{
    $doctors = User::where('is_admin', 1)->get();

    $myAppointments = Appointment::with('doctor')
        ->where('patient_id', Auth::id())
        ->orderBy('appointment_date')
        ->orderBy('appointment_time')
        ->get();

    return view('patient.appointments', compact('doctors', 'myAppointments'));
}

// JSON endpoint: available slots for a doctor on a date
public function availableSlots(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:users,id',
        'date'      => 'required|date|after_or_equal:today',
    ]);

    $open  = Carbon::createFromTimeString('09:00:00');
    $close = Carbon::createFromTimeString('17:00:00');
    $step  = 30; // minutes

    $booked = Appointment::where('doctor_id', $request->doctor_id)
        ->where('appointment_date', $request->date)
        ->where('status', '!=', 'cancelled')
        ->pluck('appointment_time')
        ->map(fn($t) => Carbon::parse($t)->format('H:i'))
        ->toArray();

    $slots = [];
    for ($t = $open->copy(); $t < $close; $t->addMinutes($step)) {
        $time = $t->format('H:i');
        if (!in_array($time, $booked)) {
            $slots[] = $time;
        }
    }
    return response()->json($slots);
}

public function appointmentsStore(Request $request)
{
    $data = $request->validate([
        'doctor_id'        => 'required|exists:users,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
    ]);

    // block double booking of this doctor/time
    $exists = Appointment::where('doctor_id', $data['doctor_id'])
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->where('status', '!=', 'cancelled')
        ->exists();

    if ($exists) {
        return back()->withErrors(['appointment_time' => 'That slot is already booked.'])->withInput();
    }

    Appointment::create([
        'patient_id'       => Auth::id(),
        'doctor_id'        => $data['doctor_id'],
        'appointment_date' => $data['appointment_date'],
        'appointment_time' => $data['appointment_time'],
        'status'           => 'pending',
    ]);

    return redirect()->route('patient.appointments')->with('success', 'Appointment booked!');
}

public function appointmentsCancel(Appointment $appointment)
{
    abort_unless($appointment->patient_id === Auth::id(), 403);
    $appointment->update(['status' => 'cancelled']);
    return back()->with('success', 'Appointment cancelled.');
}


    }

