<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<p>Dear {{ $refund->booking->user->name }},</p>

<p>Your refund request for booking ID {{ $refund->booking->booking_id }} has been approved. The refunded amount of {{ $refund->total_payment }} will be processed shortly.</p>

<p>Thank you.</p>

</body>
</html>