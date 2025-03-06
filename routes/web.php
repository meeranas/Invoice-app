<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Invoice\Invoice;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

/** Invoices route */
Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');

Route::get('/invoices', Invoice::class)->name('invoices.index');
