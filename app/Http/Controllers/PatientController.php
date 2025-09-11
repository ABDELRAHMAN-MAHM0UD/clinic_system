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
    protected $totalPaid;
    protected $totalUnpaid;
    protected $totalCanceled;

    /**
     * Dashboard
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * عرض الأطباء
     */
    public function doctors()
    {
        $doctors = Doctor::all();
        return view('patient.doctors', compact('doctors'));
    }

    /**
     * عرض تفاصيل دكتور
     */
    public function doctorShow($id)
    {
        $doctor = Doctor::with('appointments')->findOrFail($id);
        return view('patient.showDoctorsDetails', compact('doctor'));
    }

    /**
     * عرض المواعيد الخاصة بالمستخدم
     */
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
        $invoices = Invoice::with('appointment.doctor')
            ->whereHas('appointment', function ($q) {
                $q->where('patient_id', Auth::id());
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

        $open = Carbon::createFromTimeString('09:00:00');
        $close = Carbon::createFromTimeString('17:00:00');
        $step = 30; // minutes

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

    /**
     * حجز موعد جديد مع إرسال الإيميل
     */
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

        // Determine invoice status based on appointment status
        switch ($appointment->status) {
            case 'confirmed':
            case 'completed':
                $invoiceStatus = 'paid';
                break;
            case 'cancelled':
                $invoiceStatus = 'cancelled';
                break;
            default:
                $invoiceStatus = 'unpaid';
        }

        // إنشاء فاتورة
        Invoice::create([
            'appointment_id' => $appointment->id,
            'amount' => 200,
            'status' => $invoiceStatus
        ]);

        // Send email with error handling
        try {
            $appointment->load('patient', 'doctor'); // Ensure relationships are loaded

            Mail::to($appointment->patient->email)
                ->send(new AppointmentBookedMail($appointment));

            return redirect()
                ->route('patient.appointments')
                ->with('success', 'Appointment booked successfully! A confirmation email has been sent.');
        } catch (\Exception $e) {
            Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());

            return redirect()
                ->route('patient.appointments')
                ->with('success', 'Appointment booked successfully!')
                ->with('warning', 'Could not send confirmation email. Please check your email address or contact support.');
        }
    }

    /**
     * Cancel an appointment
     */
    public function appointmentsCancel(Appointment $appointment)
    {
        abort_unless($appointment->patient_id === Auth::id(), 403);
        $appointment->update(['status' => 'cancelled']);
        return back()->with('success', 'Appointment cancelled.');
    }

    //////// ADMIN ONLY ////////

    public function AdminInvoices()
    {
        $invoices = Invoice::with('appointment.patient')->get();

        $totalPaid = $invoices->where('status', 'paid')->sum('amount');
        $totalUnpaid = $invoices->where('status', 'unpaid')->sum('amount');
        $totalCanceled = $invoices->where('status', 'cancelled')->sum('amount');

        return view('admin.invoices', compact('invoices', 'totalPaid', 'totalUnpaid', 'totalCanceled'));
    }
}
