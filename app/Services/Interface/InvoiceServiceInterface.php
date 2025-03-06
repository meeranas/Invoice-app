<?php

namespace App\Services\Interface;

use App\Repositories\InvoiceRepository;
use App\Models\Invoice;

interface InvoiceServiceInterface
{
    public function getInvoices(string $status = null);

    public function getInvoice(int $invoiceId);

    public function createInvoice(array $data): Invoice;

    public function updateInvoice(Invoice $invoice, array $data): bool;

    public function deleteInvoice(Invoice $invoice): bool;
    
}
