<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first(); // Ensure a user exists
        if (!$user) {
            $user = User::factory()->create(); // Create a default user if none exists
        }

        $invoices = [
            ['invoice_number' => 'INV-1001', 'user_id' => $user->id, 'amount' => 1200.00, 'status' => 'paid'],
            ['invoice_number' => 'INV-1002', 'user_id' => $user->id, 'amount' => 850.50, 'status' => 'outstanding'],
            ['invoice_number' => 'INV-1003', 'user_id' => $user->id, 'amount' => 430.75, 'status' => 'draft'],
            ['invoice_number' => 'INV-1004', 'user_id' => $user->id, 'amount' => 980.00, 'status' => 'past_due'],
            ['invoice_number' => 'INV-1005', 'user_id' => $user->id, 'amount' => 1500.00, 'status' => 'paid'],
        ];

        foreach ($invoices as $invoice) {
            Invoice::create($invoice);
        }
    }
}
