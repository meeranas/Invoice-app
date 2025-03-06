<?php

namespace App\Repositories\Interface;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Invoice;

interface InvoiceRepositoryInterface
{
    public function getAll(?string $status = null, int $perPage = 10): LengthAwarePaginator;

    public function get(int $invoiceId): Invoice;

    public function create(array $data): Invoice;

    public function update(Invoice $invoice, array $data): bool;

    public function delete(Invoice $invoice): bool;
}
