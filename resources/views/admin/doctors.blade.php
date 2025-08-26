<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Doctors
            </h2>
            <button 
                onclick="document.getElementById('addDoctorModal').classList.remove('hidden')"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
            >
                Add Doctor
            </button>
        </div>
    </x-slot>

    <div class="p-6">
        <h3 class="text-lg font-bold mb-4">Doctors List</h3>
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($doctors as $doctor)
                <a href="{{ route('admin.doctor.show', $doctor->id) }}">
                    <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 text-center hover:bg-gray-100 transition cursor-pointer">
                        <h4 class="text-xl font-bold text-gray-800">{{ $doctor->name }}</h4>
                        <p class="text-gray-600 mt-2">{{ $doctor->specialization }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Modal for adding doctor -->
    <div id="addDoctorModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h3 class="text-lg font-bold mb-4">Add New Doctor</h3>
            <form method="POST" action="{{ route('admin.doctors.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700">Name</label>
                    <input type="text" name="name" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Specialization</label>
                    <input type="text" name="specialization" class="w-full border rounded p-2" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="document.getElementById('addDoctorModal').classList.add('hidden')" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
