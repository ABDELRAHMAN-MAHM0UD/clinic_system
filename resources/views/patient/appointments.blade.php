<!-- This page should let doctors:
✔ View all appointments with patient name & time
✔ Edit or Delete them -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Appointments</h2>
    </x-slot>

    <div class="container">

        {{-- BOOKING FORM --}}
        <div class="table-container">
            <h2 class="section-title">Book an Appointment</h2>

            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('patient.appointments.store') }}">
                @csrf

                <div class="form-group">
                    <label>Doctor</label>
                    <select id="doctor_id" name="doctor_id" required>
                        <option value="">-- Choose --</option>
                        @foreach($doctors as $d)
                            <option value="{{ $d->id }}" @selected(old('doctor_id')==$d->id)>{{ $d->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input id="appointment_date" type="date" name="appointment_date"
                           min="{{ now()->toDateString() }}" value="{{ old('appointment_date') }}" required>
                    @error('appointment_date') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label>Time</label>
                    <select id="appointment_time" name="appointment_time" required>
                        <option value="">-- Select a date & doctor first --</option>
                    </select>
                    @error('appointment_time') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <div class="form-actions">
                    <button class="btn btn-success">Bok Appointment</button>
                </div>
            </form>
        </div>

        {{-- MY APPOINTMENTS --}}
        <div class="table-container mt-8">
            <h3 class="section-title">My Appointments</h3>

            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($myAppointments as $a)
                    <tr>
                        <td>{{ $a->doctor->name }}</td>
                        <td>{{ $a->appointment_date }}</td>
                        <td>{{ \Carbon\Carbon::parse($a->appointment_time)->format('H:i') }}</td>
                        <td>
                            @if($a->status === 'pending')
                                <span class="status-badge status-pending">Pending</span>
                            @elseif($a->status === 'confirmed')
                                <span class="status-badge status-confirmed">Confirmed</span>
                            @elseif($a->status === 'cancelled')
                                <span class="status-badge status-cancelled">Cancelled</span>
                            @else
                                <span class="status-badge">{{ ucfirst($a->status) }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($a->status !== 'cancelled')
                            <form action="{{ route('patient.appointments.cancel', $a) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger"
                                        onclick="return confirm('Cancel this appointment?')">Cancel</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No appointments yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- JS to load available time slots --}}
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
</x-app-layout>
