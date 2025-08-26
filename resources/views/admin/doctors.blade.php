<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Doctors
        </h2>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg font-bold mb-4">Doctors List</h3>

        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($doctors as $doctor)
                <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 text-center">
                    <h4 class="text-xl font-bold text-gray-800">{{ $doctor->name }}</h4>
                    <p class="text-gray-600 mt-2">{{ $doctor->specialization }}</p>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
