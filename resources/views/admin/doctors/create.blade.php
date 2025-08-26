<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Doctor
        </h2>
    </x-slot>

    <div class="p-6">
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

            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Save Doctor
            </button>
        </form>
    </div>
</x-app-layout>
