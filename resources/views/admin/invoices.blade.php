<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Invoices') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg p-6">
<table class="table-auto w-full border-collapse shadow-md rounded-lg overflow-hidden">
    <thead>
        <tr class="bg-gray-100 text-left">
            <th class="p-3 border">#</th>
            <th class="p-3 border">Patient</th>
            <th class="p-3 border">Date</th>
            <th class="p-3 border">Amount</th>
            <th class="p-3 border">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($invoices as $invoice)
            <tr class="hover:bg-gray-50">
                <td class="p-3 border">{{ $invoice->id }}</td>
                <td class="p-3 border">{{ $invoice->appointment->patient->name }}</td>
                <td class="p-3 border">{{ $invoice->appointment->appointment_date }}</td>
                <td class="p-3 border">${{ $invoice->amount }}</td>
                <td class="p-3 border">
                    @if($invoice->status === 'paid')
                        <span class="inline-block bg-green-100 text-green-700 font-semibold px-3 py-1 rounded-full">
                            Paid
                        </span>
                    @elseif($invoice->status === 'unpaid')
                        <span class="inline-block bg-red-100 text-red-700 font-semibold px-3 py-1 rounded-full">
                            Unpaid
                        </span>
                    @else
                        <span class="inline-block bg-gray-200 text-gray-700 font-semibold px-3 py-1 rounded-full">
                            Cancelled
                        </span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="p-3 text-center text-gray-500">No invoices found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                <div class="mt-4 space-y-2">
    <div class="inline-block border px-4 py-2 rounded text-green-600 font-bold">
        Total Paid: ${{ $totalPaid }}
    </div>
    <br>
    <div class="inline-block border px-4 py-2 rounded text-red-600 font-bold">
        Total Unpaid: ${{ $totalUnpaid }}
    </div>
    <br>
    <div class="inline-block border px-4 py-2 rounded text-gray-500 font-bold">
        Total Cancelled: ${{ $totalCanceled }}
    </div>
</div>
            </div>
        </div>
    </div>
</x-app-layout>
