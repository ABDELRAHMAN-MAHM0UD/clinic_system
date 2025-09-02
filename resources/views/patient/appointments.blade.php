<!-- This page should let doctors:
✔ View all appointments with patient name & time
✔ Edit or Delete them -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
    </x-slot>

    <div class="p-6">

<div class="container">
    <h2 class="mb-3">Book an Appointment</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('patient.appointments.store') }}" class="row g-3">
        @csrf
        <div class="col-md-4">
            <label class="form-label">Doctor</label>
            <select id="doctor_id" name="doctor_id" class="form-select" required>
                <option value="">-- Choose --</option>
                @foreach($doctors as $d)
                    <option value="{{ $d->id }}" @selected(old('doctor_id')==$d->id)>{{ $d->name }}</option>
                @endforeach
            </select>
            @error('doctor_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Date</label>
            <input id="appointment_date" type="date" name="appointment_date" class="form-control"
                   min="{{ now()->toDateString() }}" value="{{ old('appointment_date') }}" required>
            @error('appointment_date') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
            <label class="form-label">Time</label>
            <select id="appointment_time" name="appointment_time" class="form-select" required>
                <option value="">-- Select a date & doctor first --</option>
            </select>
            @error('appointment_time') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12">
            <button class="btn btn-success">Book</button>
        </div>
    </form>

    <hr class="my-4">

    <h3 class="mb-3">My Appointments</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th style="width:130px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($myAppointments as $a)
            <tr>
                <td>{{ $a->doctor->name }}</td>
                <td>{{ $a->appointment_date }}</td>
                <td>{{ \Carbon\Carbon::parse($a->appointment_time)->format('H:i') }}</td>
                <td>{{ ucfirst($a->status) }}</td>
                <td>
                    @if($a->status !== 'cancelled')
                    <form action="{{ route('patient.appointments.cancel', $a) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm"
                                onclick="return confirm('Cancel this appointment?')">Cancel</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5">No appointments yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Tiny JS to load available time slots --}}
<script>
async function loadSlots() {
    const doctorId = document.getElementById('doctor_id').value;
    const date = document.getElementById('appointment_date').value;
    const select = document.getElementById('appointment_time');
    select.innerHTML = '<option value="">-- Select time --</option>';
    if (!doctorId || !date) return;

    const url = `{{ route('patient.appointments.available') }}?doctor_id=${doctorId}&date=${date}`;
    const res = await fetch(url);
    const slots = await res.json();
    slots.forEach(t => {
        const opt = document.createElement('option');
        opt.value = t;
        opt.textContent = t;
        select.appendChild(opt);
    });
}

document.getElementById('doctor_id').addEventListener('change', loadSlots);
document.getElementById('appointment_date').addEventListener('change', loadSlots);
</script>

    </div>
</x-app-layout>
