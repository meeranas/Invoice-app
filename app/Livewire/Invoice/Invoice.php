<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\InvoiceService;

class Invoice extends Component
{
    use WithPagination;

    public string $status = 'all';
    public bool $showForm = false;
    public $showMenu = null; // Store which menu is open

    protected $listeners = ['invoice' => '$refresh'];

    protected InvoiceService $invoiceService;

    public function boot(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function toggleMenu($invoiceId)
    {
        $this->showMenu = ($this->showMenu === $invoiceId) ? null : $invoiceId;
    }

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
                $this->dispatch('invoiceUpdated'); // Refresh invoice list
            } else {
                session()->flash('error', 'Failed to delete the draft invoice.');
            }
        } else {
            session()->flash('error', 'Only draft invoices can be deleted.');
        }
    }  

    public function downloadInvoice(int $invoiceId)
    {
        $invoice = $this->invoiceService->getInvoice($invoiceId);

        if (!$invoice) {
            session()->flash('error', 'Invoice not found.');
            return;
        }

        return $this->invoiceService->generateInvoicePdf($invoice);
    }

    public function duplicateInvoice(int $invoiceId)
    {
        $invoice = $this->invoiceService->getInvoice($invoiceId);
        $newInvoice = $this->invoiceService->createInvoice($invoice->toArray());

        if ($newInvoice) {
            session()->flash('message', 'Invoice duplicated successfully.');
            $this->dispatch('invoiceUpdated'); // Refresh invoice list
        } else {
            session()->flash('error', 'Failed to duplicate invoice.');
        }
    }

    public function render()
    {
        return view('livewire.invoice.invoice', [
            'invoices' => $this->invoiceService->getInvoices(
                $this->status === 'all' ? null : $this->status
            ),
        ]);
    }
}
