<!DOCTYPE html>
<html>
<head>
    <title>Permintaan Refund Baru</title>
</head>
<body>
    <h1>Permintaan Refund Baru</h1>
    <p>Detail Refund:</p>
    <ul>
        <li>ID Booking: {{ $refund->booking_id }}</li>
        <li>Tanggal Permintaan Refund: {{ $refund->refund_date_time }}</li>
        <li>Total Pengembalian: {{ $refund->total_payment }}</li>
        <li>Status: {{ $refund->status }}</li>
    </ul>
</body>
</html>
