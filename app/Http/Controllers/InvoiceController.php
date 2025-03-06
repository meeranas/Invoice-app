<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\InvoiceService;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function download(Invoice $invoice)
    {
        $pdf = Pdf::loadView('livewire.invoice.pdf', compact('invoice'));
        return $pdf->download("invoice_{$invoice->invoice_number}.pdf");
    }
}
