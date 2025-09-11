<!-- This page should let doctors:
✔ View all appointments with patient name & time
✔ Confirm or Delete them -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-6xl mx-auto">
            <h2 class="mb-4 text-lg font-semibold">Manage Appointments</h2>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Patient</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4">{{ $appointment->doctor->name }}</td>
                                <td class="px-6 py-4">{{ $appointment->patient->name }}</td>
                                <td class="px-6 py-4">{{ $appointment->appointment_date }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>

                                <!-- Status Badges -->
                                <td class="px-6 py-4">
                                    @if($appointment->status === 'pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @elseif($appointment->status === 'confirmed')
                                        <span class="status-badge status-confirmed">Confirmed</span>
                                    @elseif($appointment->status === 'cancelled')
                                        <span class="status-badge status-cancelled">Cancelled</span>
                                    @elseif($appointment->status === 'completed')
                                        <span class="status-badge">Completed</span>
                                    @endif
                                </td>

                                <!-- Action Buttons -->
                                <td class="px-6 py-4 flex gap-2 justify-center">
                                    @if($appointment->status === 'pending')
                                        <!-- Confirm button -->
                                        <form action="{{ route('admin.appointments.confirm', $appointment->id) }}" method="POST">
                                            @csrf
                                            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md"
                                                onclick="return confirm('Confirm this appointment?')">
                                                Confirm
                                            </button>
                                        </form>



                                        <!-- Cancel button -->
                                        <form action="{{ route('admin.appointments.cancel', $appointment) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md"
                                                onclick="return confirm('Cancel this appointment?')">
                                                Cancel
                                            </button>
                                        </form>


                                    @endif

                                    <!-- Edit button -->
                                    <a href="{{ route('admin.appointments.edit', $appointment) }}" class="btn btn-warning">
                                        Edit
                                    </a>

                                    <!-- Delete button -->
                                    <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-secondary"
                                            onclick="return confirm('Delete this appointment?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No appointments yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
</x-app-layout>