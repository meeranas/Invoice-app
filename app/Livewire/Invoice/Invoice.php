<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\InvoiceService;
use App\Services\Interface\InvoiceServiceInterface;


class Invoice extends Component
{
    use WithPagination; // Enables pagination for Livewire components

    public string $status = 'all'; // Stores the selected invoice status
    public bool $showForm = false; // Controls the visibility of the invoice form
    public $showMenu = null; // Stores which menu is currently open

    protected $listeners = ['invoice' => '$refresh']; // Listens for invoice updates and refreshes the component

    protected InvoiceServiceInterface $invoiceService; // Dependency Injection for InvoiceService

    /**
     * Livewire's boot method to inject the InvoiceService dependency.
     */
    public function boot(InvoiceServiceInterface $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Set the invoice status filter and reset pagination.
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
        $this->resetPage(); // Reset pagination when filtering invoices
    }

    /**
     * Toggle the visibility of the invoice form.
     */
    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    /**
     * Toggle the visibility of the action menu for a specific invoice.
     */
    public function toggleMenu($invoiceId)
    {
        $this->showMenu = ($this->showMenu === $invoiceId) ? null : $invoiceId;
    }

    /**
     * Delete a draft invoice if it exists and is in draft status.
     */
    public function deleteDraft(int $invoiceId)
    {
        $invoice = $this->invoiceService->getInvoice($invoiceId);
        
        if (!$invoice) {
            session()->flash('error', 'Invoice not found.');
            return;
        }
    
        if (strtolower($invoice->status) === 'draft') {
            if ($this->invoiceService->deleteInvoice($invoice)) {
                session()->flash('message', 'Draft invoice deleted successfully.');
                $this->dispatch('invoiceUpdated'); // Notify the frontend to refresh the invoice list
            } else {
                session()->flash('error', 'Failed to delete the draft invoice.');
            }
        } else {
            session()->flash('error', 'Only draft invoices can be deleted.');
        }
    }  

    /**
     * Generate and download a PDF version of the invoice.
     */
    public function downloadInvoice(int $invoiceId)
    {
        $invoice = $this->invoiceService->getInvoice($invoiceId);

        if (!$invoice) {
            session()->flash('error', 'Invoice not found.');
            return;
        }

        return $this->invoiceService->generateInvoicePdf($invoice);
    }

    /**
     * Duplicate an existing invoice and create a new one with the same data.
     */
    public function duplicateInvoice(int $invoiceId)
    {
        $invoice = $this->invoiceService->getInvoice($invoiceId);
        $newInvoice = $this->invoiceService->createInvoice($invoice->toArray());

        if ($newInvoice) {
            session()->flash('message', 'Invoice duplicated successfully.');
            $this->dispatch('invoiceUpdated'); // Notify the frontend to refresh the invoice list
        } else {
            session()->flash('error', 'Failed to duplicate invoice.');
        }
    }

    /**
     * Render the Livewire component with a filtered list of invoices.
     */
    public function render()
    {
        return view('livewire.invoice.invoice', [
            'invoices' => $this->invoiceService->getInvoices(
                $this->status === 'all' ? null : $this->status
            ),
        ]);
    }
}
