<!DOCTYPE html>
<html>
<head>
    <title>Billing Statement</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: 0 auto; }
        .header, .footer { text-align: start; margin-bottom: 20px; }
        .header h1 { margin: 0; }
        .header p { margin: 5px 0; }
        .bill-to, .remittance-details { width: 48%; display: inline-block; vertical-align: top; }
        .bill-to { margin-right: 4%; }
        .container-bill { display: flex; justify-content: space-between; }
        .details-table, .balance-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th, .details-table td, .balance-table th, .balance-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .details-table th, .balance-table th { background-color: #f2f2f2; }
        .balance-table { margin-top: 10px; }
        .balance-table td { text-align: right; }
        .balance-table .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $company_name }}</h1>
            <p>Address: 123 Street Avenue, Cityville, State, 12333</p>
        </div>
        <div class="container-bill">
            <div class="bill-to">
                <p><strong>Bill to:</strong></p>
                <p>{{ $client_name }}</p>
                <p>{{ $client_address }}</p>
                <p>{{ $client_phone }}</p>
            </div>
            <div class="remittance-details">
                <p><strong>Statement Date:</strong> {{ $statement_date }}</p>
                <p>Statement #{{ $statement_number }}</p>
                <p>Customer ID: {{ $customer_id }}</p>
                <p><strong>Balance Due</strong> ${{ number_format($balance_due, 2) }}</p>
            </div>
        </div>
        <table class="details-table">
            <thead>
                <tr>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                    <th>Description</th>
                    <th>Reference #</th>
                    <th>Type</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction['issue_date'] }}</td>
                    <td>{{ $transaction['due_date'] }}</td>
                    <td>{{ $transaction['description'] }}</td>
                    <td>{{ $transaction['reference_no'] }}</td>
                    <td>{{ $transaction['type'] }}</td>
                    <td>${{ number_format($transaction['total'], 2) }}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="total">Current Balance</td>
                    <td>${{ number_format($balance_due, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>