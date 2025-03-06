<div class="p-6 bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Invoices</h2>
        <button wire:click="toggleForm" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">Create Invoice</button>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    @if ($showForm)
        <livewire:invoice.invoice-form />
    @endif

    {{-- Status Tabs --}}
    <div class="flex space-x-6 border-b">
        @php
            $tabs = [
                'all' => 'All invoices',
                'draft' => 'Draft',
                'outstanding' => 'Outstanding',
                'past_due' => 'Past due',
                'paid' => 'Paid',
            ];
        @endphp

        @foreach ($tabs as $statusValue => $displayLabel)
            <a href="#" wire:click.prevent="setStatus('{{ $statusValue }}')"
                class="py-2 px-4 text-gray-600 border-b-2 cursor-pointer 
                {{ $status === $statusValue ? 'border-indigo-500 text-indigo-600 font-semibold' : 'border-transparent' }}">
                {{ $displayLabel }}
            </a>
        @endforeach
    </div>

    {{-- Invoice Table --}}
    <div class="mt-4 bg-white shadow rounded-lg">
        <table class="w-full text-left">
            <thead class="bg-gray-100 text-gray-600 text-sm">
                <tr>
                    <th class="p-3">Amount</th>
                    <th class="p-3">Invoice Number</th>
                    <th class="p-3">Customer</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Created</th>
                    <th class="p-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr class="border-b">
                        <td class="p-3"><span class='font-semibold'>${{ number_format($invoice->amount, 2) }} </span>USD</td>
                        <td class="p-3">{{ $invoice->invoice_number }}</td>
                        <td class="p-3">{{ $invoice->user->email }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-lg text-xs font-semibold {{ $invoice->status == 'draft' ? 'bg-gray-200 text-gray-600' : 
                                ($invoice->status == 'paid' ? 'bg-green-200 text-green-600' :
                                ($invoice->status == 'outstanding' ? 'bg-yellow-200 text-yellow-600' :
                                ($invoice->status == 'past_due' ? 'bg-blue-200 text-blue-600' : 'bg-red-200 text-red-600'))) }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $invoice->created_at->format('M j, g:i A') }}</td>
                        <td class="p-3 relative leading-8">
                            <button wire:click="toggleMenu({{ $invoice->id }})">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h.01M12 12h.01M18 12h.01" />
                                </svg>
                            </button>

                            @if ($showMenu === $invoice->id)
                                <div class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-10">
                                    <div class="p-2 text-gray-700">
                                        <p class="text-xs font-semibold uppercase mb-1">Actions</p>
                                        <a href="#" wire:click.prevent="downloadInvoice({{ $invoice->id }})" class="block text-blue-600 hover:underline">
                                            Download PDF
                                        </a>
                                        <a href="#" wire:click="duplicateInvoice({{ $invoice->id }})" class="block text-blue-600 hover:underline">
                                            Duplicate Invoice
                                        </a>
                                        @if ($invoice->status === 'draft')
                                            <a href="#" wire:click="deleteDraft({{ $invoice->id }})" class="block text-red-600 hover:underline">
                                                Delete Draft
                                            </a>
                                        @endif

                                        <hr class="my-2">
                                        <p class="text-xs font-semibold uppercase mb-1">Connections</p>
                                        <a href="#" class="block text-blue-600 hover:underline">View customer →</a>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
