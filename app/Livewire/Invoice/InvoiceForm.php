<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use App\Services\InvoiceService;
use App\Http\Requests\Invoice\InvoiceRequest;
use App\Models\Invoice;
use App\Services\Interface\InvoiceServiceInterface;

class InvoiceForm extends Component
{
    // Invoice properties
    public $invoice_id; // Stores the ID of the invoice (for editing)
    public $invoice_number; // Stores the invoice number
    public $amount; // Stores the invoice amount
    public $status = 'Draft'; // Default status for a new invoice
    public $editing = false; // Flag to determine if the form is in edit mode

    protected $rules; // Validation rules (to be defined dynamically)

    private InvoiceServiceInterface $invoiceService; // Invoice service for handling business logic

    /**
     * Livewire's boot method to inject InvoiceService dependency.
     */
    public function boot(InvoiceServiceInterface $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Save or update an invoice.
     */
    public function save()
    {
        $request = new InvoiceRequest(); // Create a new invoice request instance
        $validatedData = $this->validate($request->rules()); // Validate form input based on rules

        if ($this->editing) {
            // If editing, update the existing invoice
            $this->invoiceService->updateInvoice($this->invoice_id, $validatedData);
            session()->flash('message', 'Invoice updated successfully.');
        } else {
            // If not editing, create a new invoice
            $this->invoiceService->createInvoice($validatedData);
            session()->flash('message', 'Invoice created successfully.');
        }

        // Reset form fields after saving
        $this->reset(['invoice_id', 'amount', 'status', 'editing']);
        
        // Dispatch an event to refresh invoice list
        $this->dispatch('invoice');
    }

    /**
     * Render the invoice form component.
     */
    public function render()
    {
        return view('livewire.invoice.invoice-form');
    }
}
