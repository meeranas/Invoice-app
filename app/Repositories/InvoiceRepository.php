<?php

namespace App\Repositories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interface\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct(){
        $this->model = new Invoice();
    }

    public function getAll(string $status = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->when($status, fn ($query) => $query->where('status', $status))->paginate($perPage);
    }

    public function get(int $invoiceId): Invoice
    {
        return $this->model->find($invoiceId);
    }

    public function create(array $data): Invoice
    {
        $data['user_id'] = 1;
        $data['invoice_number'] = time();
        return $this->model->create($data);
    }

    public function update(Invoice $invoice, array $data): bool
    {
        return $invoice->update($data);
    }

    public function delete(Invoice $invoice): bool
    {
        return $invoice->delete();
    }
}
