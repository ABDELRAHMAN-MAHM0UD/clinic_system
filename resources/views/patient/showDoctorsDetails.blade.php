<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $doctor->name }} - Details
        </h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg font-bold mb-4">Doctor Info</h3>
        <p><strong>Name:</strong> {{ $doctor->name }}</p>
        <p><strong>Email:</strong> {{ $doctor->email }}</p>
        <p><strong>Specialization:</strong> {{ $doctor->specialization }}</p>

        <h3 class="text-lg font-bold mt-6 mb-4">Appointments</h3>
        @if($doctor->appointments->count() > 0)
            <ul class="list-disc pl-5">
                @foreach($doctor->appointments as $appointment)
                    <li>
                        Patient: {{ $appointment->patient->name ?? 'N/A' }} -
                        Date: {{ $appointment->appointment_date }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>No appointments yet.</p>
        @endif
    </div>
</x-app-layout>
