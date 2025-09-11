<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\Models\Invoice; 


class AdminController extends Controller
{
    public function index()
    {
        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->take(3)
            ->get();

        $totalPatients = DB::table('users')
            ->where('is_admin', '=', 0)
            ->count();

        $todayAppointments = Appointment::whereDate('appointment_date', today())->count();
        
        $upcomingTodayAppointments = Appointment::whereDate('appointment_date', today())
            ->where('appointment_time', '>', now()->format('H:i:s'))
            ->where('status', '!=', 'cancelled')
            ->count();

        // Get available doctors (all active doctors)
        $availableDoctors = Doctor::where('status', 'active')->count();

        // Calculate today's revenue from completed appointments
        $todayRevenue = DB::table('invoices')
            ->whereDate('created_at', today())
            ->sum('amount');

        // Get previous day's revenue for comparison
        $yesterdayRevenue = DB::table('invoices')
            ->whereDate('created_at', today()->subDay())
            ->sum('amount');

        // Calculate percentage increase
        $revenueIncrease = $yesterdayRevenue > 0 
            ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100)
            : 0;

        return view('adminDashboard', compact(
            'upcomingAppointments', 
            'totalPatients', 
            'todayAppointments', 
            'upcomingTodayAppointments',
            'availableDoctors',
            'todayRevenue',
            'revenueIncrease'
        ));
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
        return view('patient.medical_history', compact('appointments', 'patient'));
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
    $doctors = Doctor::all();
    return view('admin.appointments.edit', compact('appointment', 'doctors'));
}

public function appointmentsUpdate(Request $request, Appointment $appointment)
{
    $data = $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
        'status' => 'required|in:pending,confirmed,completed,cancelled',
    ]);

    // prevent collision with another appointment
    $exists = Appointment::where('doctor_id', $data['doctor_id'])
        ->where('appointment_date', $data['appointment_date'])
        ->where('appointment_time', $data['appointment_time'])
        ->where('id', '!=', $appointment->id)
        ->where('status', '!=', 'cancelled')
        ->exists();

    if ($exists) {
        return back()->withErrors(['appointment_time' => 'This slot is already booked.'])->withInput();
    }

    $appointment->update($data);

    return redirect()->route('adminDashboard')->with('success', 'Appointment updated successfully');
}

public function appointmentsDestroy(Appointment $appointment)
{
    $appointment->delete();
    return redirect()->route('adminDashboard')->with('success', 'Appointment cancelled successfully');
}

// Confirm appointment
public function appointmentsConfirm(Appointment $appointment)
{
    \DB::transaction(function () use ($appointment) {
        
        $appointment->update(['status' => 'confirmed']);

        // update invoice
        Invoice::where('appointment_id', $appointment->id)
            ->update(['status' => 'paid']);
    });

    return redirect()->route('admin.appointments')
        ->with('success', 'Appointment confirmed and invoice marked as paid.');
}

// Cancel appointment
public function appointmentsCancel(Appointment $appointment)
{
    \DB::transaction(function () use ($appointment) {
        // update appointment
        $appointment->update(['status' => 'cancelled']);

        // update invoice
        Invoice::where('appointment_id', $appointment->id)
            ->update(['status' => 'cancelled']);
    });

    return redirect()->route('admin.appointments')
        ->with('success', 'Appointment cancelled and invoice marked as cancelled.');
}


}
