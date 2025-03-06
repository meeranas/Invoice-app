<?php

namespace App\Services;

use App\Repositories\InvoiceRepository;
use App\Models\Invoice;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Services\Interface\InvoiceServiceInterface;
use App\Repositories\Interface\InvoiceRepositoryInterface;

class InvoiceService implements InvoiceServiceInterface
{ 
    protected InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository)
    {
        $this->invoiceRepository = $invoiceRepository;
    }

    public function getInvoices(string $status = null)
    {
        return $this->invoiceRepository->getAll($status);
    }

    public function getInvoice(int $invoiceId): Invoice
    {
        return $this->invoiceRepository->get($invoiceId);
    }

    public function createInvoice(array $data): Invoice
    {
        return $this->invoiceRepository->create($data);
    }

    public function updateInvoice(Invoice $invoice, array $data): bool
    {
        return $this->invoiceRepository->update($invoice, $data);
    }

    public function deleteInvoice(Invoice $invoice): bool
    {
        return $this->invoiceRepository->delete($invoice);
    }

    public function generateInvoicePdf(Invoice $invoice)
    {
        return redirect()->route('invoices.download', ['invoice' => $invoice]);
    }
}
