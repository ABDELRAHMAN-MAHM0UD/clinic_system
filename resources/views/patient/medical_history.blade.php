<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medical History') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse($appointments as $appointment)
                <div class="bg-white shadow-md rounded-lg p-6">
                    <p class="text-gray-700 mb-2">
                        <strong>Date:</strong> {{ $appointment->appointment_date }}
                    </p>
                    <p class="text-gray-700 mb-2">
                        <strong>Doctor:</strong> {{ $appointment->doctor->name }}
                        ({{ $appointment->doctor->specialization }})
                    </p>
                    <p class="text-gray-800 leading-relaxed">
                        You had an appointment with a {{ $appointment->doctor->specialization }} specialist
                        on {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}.
                        This consultation was part of the your ongoing medical history.
                    </p>
                </div>
            @empty
                <p class="text-gray-500">No medical history found.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
