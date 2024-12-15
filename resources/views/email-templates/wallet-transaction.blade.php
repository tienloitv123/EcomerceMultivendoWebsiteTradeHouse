<!DOCTYPE html>
<html>
<head>
    <title>Wallet Transaction Notification</title>
</head>
<body>
    <h3>{{ $type }} Transaction</h3>
    <p>Dear {{ $user_name }},</p>
    <p>Your wallet has been updated with the following details:</p>
    <ul>
        <li>Transaction Type: {{ $type }}</li>
        <li>Amount: {{ number_format($amount, 2) }} USD</li>
        <li>New Balance: {{ number_format($balance, 2) }} USD</li>
    </ul>
    <p>Thank you for using our service!</p>
</body>
</html>
