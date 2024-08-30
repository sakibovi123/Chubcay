<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Records Summary</h2>

<table>
    <thead>
    <tr>
        <th>Date</th>
        <th>Action</th>
        <th>Total Amount</th>
        <th>Paid Amount</th>
        <th>Due Amount</th>
    </tr>
    </thead>
    <tbody>
    <!-- Loop through the records and display each record -->
    @foreach($records as $record)
        <tr>
            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d') }}</td>
            <td>{{ ucfirst($record->action) }}</td>
            <td>${{ number_format($record->total_amount, 2) }}</td>
            <td>${{ number_format($record->paid_amount, 2) }}</td>
            <td>${{ number_format($record->due_amount, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="total">
        <td colspan="2">Total</td>
        <td>${{ number_format($records->sum('total_amount'), 2) }}</td>
        <td>${{ number_format($records->sum('paid_amount'), 2) }}</td>
        <td>${{ number_format($records->sum('due_amount'), 2) }}</td>
    </tr>
    </tfoot>
</table>

</body>
</html>
