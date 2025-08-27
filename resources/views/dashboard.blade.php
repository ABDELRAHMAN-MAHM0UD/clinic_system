<x-app-layout>
    <x-slot name="header">
<h2 class="w-full text-left font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Dashboard') }}
</h2>


    </x-slot>

    <div class="py-12">

          
    
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-2 grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Doctors -->
            <a href="{{ route('patient.doctors') }}" 
               class="block border border-blue-200 rounded-xl shadow hover:shadow-lg transition p-4 text-center h-48">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="w-10 h-10 text--grey  mb-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M12 14c-3.866 0-7 1.343-7 3v2h14v-2c0-1.657-3.134-3-7-3z"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    <h3 class="text-lg font-bold text-grey ">Doctors</h3>
                    <p class="text-white-600 text-sm">Manage doctors info</p>
                </div>
            </a>


            <!-- Invoices -->
            <a href="{{ route('patient.invoices') }}" 
               class="block border border-blue-200 rounded-xl shadow hover:shadow-lg transition p-4 text-center h-48">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="w-10 h-10 text-grey  mb-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M9 14l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-grey ">Invoices</h3>
                    <p class="text-white-600 text-sm">View and manage invoices</p>
                </div>
            </a>

            <!-- Appointments -->
            <a href="{{ route('patient.appointments') }}" 
               class="block border border-blue-200 rounded-xl shadow hover:shadow-lg transition p-4 text-center h-48">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="w-10 h-10 text-grey mb-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 
                                 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-grey-600">Appointments</h3>
                    <p class="text-white-600 text-sm">Schedule and view appointments</p>
                </div>
            </a>

            
               <!-- medical history -->
            <a href="{{ route('patient.medical_history') }}" 
               class="block border border-blue-200 rounded-xl shadow hover:shadow-lg transition p-4 text-center h-48">
                <div class="flex flex-col items-center justify-center h-full">
                    <svg class="w-10 h-10 text-grey  mb-2" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 
                                 00-2-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-bold text-grey">Medical History</h3>
                    <p class="text-white-600  text-sm">View Your Medical History</p>
                </div>
            </a>

        </div>
        
    </div>
</x-app-layout>
