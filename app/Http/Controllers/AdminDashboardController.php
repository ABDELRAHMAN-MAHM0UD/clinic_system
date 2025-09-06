<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="bg-white w-64 min-h-screen shadow-lg">
            <!-- Logo Header -->
            <div class="h-16 flex items-center justify-center bg-gradient-to-r from-blue-600 to-blue-400">
                <i class="fas fa-hospital-alt text-white text-2xl"></i>
            </div>
            
            <!-- Admin Info -->
            <div class="p-4 border-b">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                        <i class="fas fa-user-md text-white"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700">Admin Panel</h3>
                        <p class="text-xs text-gray-500">Welcome back</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="px-4 pt-4">
                <div class="space-y-2">
                    <a href="{{ route('adminDashboard') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('adminDashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <i class="fas fa-chart-pie w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.doctors') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.doctors') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <i class="fas fa-user-md w-5"></i>
                        <span>Doctors</span>
                    </a>

                    <a href="{{ route('admin.patients') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.patients') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <i class="fas fa-users w-5"></i>
                        <span>Patients</span>
                    </a>

                    <a href="{{ route('admin.appointments') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.appointments') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <i class="fas fa-calendar-check w-5"></i>
                        <span>Appointments</span>
                    </a>

                    <a href="{{ route('admin.invoices') }}" 
                       class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('admin.invoices') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }} transition-colors">
                        <i class="fas fa-file-invoice-dollar w-5"></i>
                        <span>Invoices</span>
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 overflow-auto">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-8 py-5">
                    <h1 class="text-2xl font-semibold text-gray-800">Clinical Dashboard</h1>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-bell"></i>
                        </button>
                        <!-- Logout button removed -->
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="p-8">
                <!-- Statistics Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Total Patients Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Total Patients</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $totalPatients }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center">
                                <i class="fas fa-users text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Today's Appointments -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Today's Appointments</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $todayAppointments }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center">
                                <i class="fas fa-calendar-check text-green-500 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Available Doctors -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-500">Available Doctors</p>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $availableDoctors }}</h3>
                            </div>
                            <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center">
                                <i class="fas fa-user-md text-purple-500 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Appointments Section -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <th class="p-4">Patient</th>
                                        <th class="p-4">Doctor</th>
                                        <th class="p-4">Date & Time</th>
                                        <th class="p-4">Status</th>
                                        <th class="p-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($upcomingAppointments as $appointment)
                                    <tr class="text-sm text-gray-800">
                                        <td class="p-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-blue-500"></i>
                                                </div>
                                                <span>{{ $appointment->patient->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                    <i class="fas fa-user-md text-green-500"></i>
                                                </div>
                                                <!-- Removed "Dr." prefix -->
                                                <span>{{ $appointment->doctor->name }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex flex-col">
                                                <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</span>
                                                <span class="text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('h:i A') }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            @if($appointment->status == 'confirmed')
                                                <span class="px-3 py-1 rounded-full text-xs bg-green-50 text-green-600">
                                                    Confirmed
                                                </span>
                                            @elseif($appointment->status == 'pending')
                                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-50 text-yellow-600">
                                                    Pending
                                                </span>
                                            @elseif($appointment->status == 'cancelled')
                                                <span class="px-3 py-1 rounded-full text-xs bg-red-50 text-red-600">
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>
                                        <td class="p-4">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.appointments.edit', $appointment->id) }}" 
                                                   class="p-2 text-gray-600 hover:text-gray-800">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.appointments.destroy', $appointment->id) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:text-red-800" 
                                                            onclick="return confirm('Are you sure you want to delete this appointment?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-gray-500">
                                            No upcoming appointments found
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
