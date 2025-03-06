<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use App\Services\InvoiceService;
use App\Http\Requests\Invoice\InvoiceRequest;
use App\Models\Invoice;

class InvoiceForm extends Component
{
    public $invoice_id;
    public $invoice_number;
    public $amount;
    public $status = 'Draft';
    public $editing = false;

    protected $rules;

    private InvoiceService $invoiceService;

    public function boot(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function save()
    {
        $request = new InvoiceRequest();
        $validatedData = $this->validate($request->rules());

        if ($this->editing) {
            $this->invoiceService->updateInvoice($this->invoice_id, $validatedData);
            session()->flash('message', 'Invoice updated successfully.');
        } else {
            $this->invoiceService->createInvoice($validatedData);
            session()->flash('message', 'Invoice created successfully.');
        }

        $this->reset(['invoice_id', 'amount', 'status', 'editing']);
        $this->dispatch('invoice');
    }

    public function render()
    {
        return view('livewire.invoice.invoice-form');
    }
}
