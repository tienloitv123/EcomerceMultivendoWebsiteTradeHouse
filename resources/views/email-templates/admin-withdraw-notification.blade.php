<!DOCTYPE html>
<html>
<head>
    <title>Withdraw Confirmation</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <p>Your withdrawal request has been processed successfully. Here are the details:</p>
    <ul>
        <li><strong>Withdrawn Amount:</strong> ${{ number_format($withdrawAmount, 2) }}</li>
        <li><strong>Remaining Wallet Balance:</strong> ${{ number_format($remainingBalance, 2) }}</li>
    </ul>
    <p>Thank you for using our service!</p>
</body>
</html>
