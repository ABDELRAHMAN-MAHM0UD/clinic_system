<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentBookedMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller 
{
    // Dashboard
    public function index()
    {
        return view('dashboard'); 
    }

    // عرض الأطباء
    public function doctors()
    {
        $doctors = Doctor::all(); 
        return view('patient.doctors', compact('doctors'));
    }

    // عرض تفاصيل دكتور
    public function doctorShow($id)
    {
        $doctor = Doctor::with('appointments')->findOrFail($id);
        return view('patient.showDoctorsDetails', compact('doctor'));
    }

    // عرض المواعيد الخاصة بالمستخدم
    public function appointments()
    {
        $doctors = Doctor::all();
        $myAppointments = Appointment::with('doctor')
            ->where('patient_id', Auth::id())
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('patient.appointments', compact('doctors', 'myAppointments'));
    }

    /**
     * Display the user's invoices
     */
    public function userInvoices()
    {
        $invoices = Invoice::whereHas('appointment', function($query) {
            $query->where('patient_id', Auth::id());
        })->get();

        $totalPaid = $invoices->where('status', 'paid')->sum('amount');
        $totalUnpaid = $invoices->where('status', 'unpaid')->sum('amount');
        $totalCanceled = $invoices->where('status', 'cancelled')->sum('amount');

        return view('patient.invoices', compact('invoices', 'totalPaid', 'totalUnpaid', 'totalCanceled'));
    }

    /**
     * Display the user's medical history
     */
    public function medicalHis()
    {
        $appointments = Appointment::with(['doctor'])
            ->where('patient_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('patient.medical_history', compact('appointments'));
    }

    /**
     * Get available time slots for a doctor on a specific date
     */
    public function availableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'date' => 'required|date|after_or_equal:today',
        ]);

        Log::info('Fetching available slots', [
            'doctor_id' => $request->doctor_id,
            'date' => $request->date
        ]);

        // Define available time slots (9 AM to 5 PM, hourly slots)
        $availableSlots = [
            '09:00', '10:00', '11:00', '12:00',
            '13:00', '14:00', '15:00', '16:00', '17:00'
        ];

        // Get booked appointments for the doctor on the selected date
        $bookedSlots = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->date)
            ->where('status', '!=', 'cancelled')
            ->pluck('appointment_time')
            ->map(function($time) {
                return Carbon::parse($time)->format('H:i');
            })
            ->toArray();

        Log::info('Booked slots:', ['slots' => $bookedSlots]);

        // Remove booked slots from available slots
        $availableSlots = array_diff($availableSlots, $bookedSlots);

        Log::info('Available slots:', ['slots' => $availableSlots]);

        // Return available slots
        return response()->json(array_values($availableSlots));
    }

    // حجز موعد جديد مع إرسال الإيميل
    public function appointmentsStore(Request $request)
    {
        $data = $request->validate([
            'doctor_id'        => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);

        $exists = Appointment::where('doctor_id', $data['doctor_id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where('appointment_time', $data['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($exists) {
            return back()->withErrors(['appointment_time' => 'This slot is already booked.'])->withInput();
        }

        $appointment = Appointment::create([
            'patient_id'       => Auth::id(),
            'doctor_id'        => $data['doctor_id'],
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'status'           => 'pending',
        ]);

        // إنشاء فاتورة بسيطة
        Invoice::create([
            'appointment_id' => $appointment->id,
            'amount' => 200,
            'status' => 'unpaid'
        ]);

            // Send email with error handling
        try {
            $appointment->load('patient', 'doctor'); // Ensure relationships are loaded

            // Send confirmation email
            Mail::to($appointment->patient->email)
                ->send(new AppointmentBookedMail($appointment));            return redirect()
                ->route('patient.appointments')
                ->with('success', 'Appointment booked successfully! A confirmation email has been sent to ' . $appointment->patient->email);
        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
            Log::error('Error details:', ['exception' => $e]);
            
            return redirect()
                ->route('patient.appointments')
                ->with('success', 'Appointment booked successfully!')
                ->with('warning', 'Could not send confirmation email. Please check your email address or contact support.');
        }
    }
}
