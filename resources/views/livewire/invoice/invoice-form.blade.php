<div class="p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-4">{{ $editing ? 'Edit Invoice' : 'Create Invoice' }}</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600 font-semibold">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">

        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
            <input type="number" id="amount" wire:model="amount" step="0.01"
                class="mt-1 block w-full max-h-[48px] border border-gray-300 rounded-lg shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-3 py-2">
            @error('amount') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" wire:model="status"
                class="mt-1 block w-full max-h-[48px] border border-gray-300 rounded-lg shadow-sm 
                    focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none px-3 py-2 bg-white">
                <option value="Draft">Draft</option>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
                <option value="Outstanding">Outstanding</option>
                <option value="Past_due">Past Due</option>
            </select>
            @error('status') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror
        </div>


        <div class="flex justify-end">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                {{ $editing ? 'Update Invoice' : 'Save' }}
            </button>
        </div>
    </form>
</div>
