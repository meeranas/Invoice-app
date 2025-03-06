<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\InvoiceService;
use App\Models\Invoice;
use App\Services\Interface\InvoiceServiceInterface;

class InvoiceController extends Controller
{
    protected InvoiceServiceInterface $invoiceService;

    public function __construct(InvoiceServiceInterface $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function download(Invoice $invoice)
    {
        $pdf = Pdf::loadView('livewire.invoice.pdf', compact('invoice'));
        return $pdf->download("invoice_{$invoice->invoice_number}.pdf");
    }
}
