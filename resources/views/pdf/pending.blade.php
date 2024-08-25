<!DOCTYPE html>
<html>
<head>
    <title>Pending Payments</title>
    <style>
        /* Add your custom styles here */
    </style>
</head>
<body>
    <h1>Pending Payments</h1>
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Country</th>
                <th>City</th>
                <th>Phone</th>
                <th>Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingPayments as $payment)
            <tr>
                <td>{{ $payment->user->first_name }}</td>
                <td>{{ $payment->user->email }}</td>
                <td>{{ $payment->user->country }}</td>
                <td>{{ $payment->user->city }}</td>
                <td>{{ $payment->user->phone }}</td>
                <td>{{ $payment->total_charge }}</td>
                <td>{{ $payment->payment_status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
