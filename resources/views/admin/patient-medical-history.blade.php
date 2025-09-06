<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $patient->name }}'s Medical History
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('admin.patient.appointments', $patient->id) }}" 
                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                    View All Appointments
                </a>
                <a href="{{ route('admin.patients') }}" 
                   class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                    Back to Patients List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Patient Information</h3>
                        <div class="mt-2 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $patient->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $patient->email }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Medical History</h3>
                        @if($appointments->isEmpty())
                            <p class="mt-4 text-center text-gray-500 dark:text-gray-400">No completed appointments found in medical history.</p>
                        @else
                            <div class="mt-4 space-y-6">
                                @foreach($appointments as $appointment)
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Date</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->appointment_date }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->appointment_time }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Doctor</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->doctor->name ?? 'N/A' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Specialization</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->doctor->specialization ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        @if($appointment->diagnosis)
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Diagnosis</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->diagnosis }}</p>
                                            </div>
                                        @endif
                                        @if($appointment->treatment)
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Treatment</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->treatment }}</p>
                                            </div>
                                        @endif
                                        @if($appointment->notes)
                                            <div class="mt-4">
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                                                <p class="text-base text-gray-900 dark:text-gray-100">{{ $appointment->notes }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
