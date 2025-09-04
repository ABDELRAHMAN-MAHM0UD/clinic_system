@extends('layouts.app')

@section('content')
<div class="container" style="max-width:520px;">
    <h2 class="mb-3">Edit Appointment</h2>

    <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="appointment_date" class="form-control"
                   value="{{ old('appointment_date', $appointment->appointment_date) }}" required>
            @error('appointment_date') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Time</label>
            <input type="time" name="appointment_time" class="form-control"
                   value="{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}" required>
            @error('appointment_time') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                @foreach(['pending','confirmed','completed','cancelled'] as $st)
                    <option value="{{ $st }}" @selected(old('status', $appointment->status)==$st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
            @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('admin.appointments') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
