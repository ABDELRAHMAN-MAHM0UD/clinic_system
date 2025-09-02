<!-- This page should let doctors:
✔ View all appointments with patient name & time
✔ Edit or Delete them -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
    </x-slot>

    <div class="p-6">

<div class="container">
    <h2 class="mb-3">My Appointments</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Doctor</th>
                <th>Patient</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th style="width:180px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
            <tr>
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->patient->name }}</td>
                <td>{{ $appointment->appointment_date }}</td>
                <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                <td>{{ ucfirst($appointment->status) }}</td>
                <td>
                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this appointment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">No appointments yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>

    </div>
</x-app-layout>
