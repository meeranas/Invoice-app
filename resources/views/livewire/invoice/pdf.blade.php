<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <!-- <title>Invoice #{{ $invoice->invoice_number }}</title> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { padding: 20px; border: 1px solid #ddd; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Invoice #: {{ mb_convert_encoding($invoice->invoice_number, 'UTF-8', 'UTF-8') }}</h1>
        <p><strong>Date:</strong> {{ $invoice->created_at->format('d M, Y') }}</p>
        <p><strong>Amount:</strong> {{ number_format($invoice->amount, 2) }} USD</p>
        <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>

        <h2>Customer Details</h2>
        <p><strong>Name:</strong> {{ $invoice->user->name ?? 'N/A' }}</p>

        <h2>Items</h2>
        <table>
            <tr>
                <th>Item</th>
                <th>Price</th>
            </tr>
            <!-- Example items (modify based on your data structure) -->
            <tr>
                <td>Example Item 1</td>
                <td>${{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
