<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Update</title>
</head>

<body>
    <h1>Status Marketplace Diperbarui</h1>
    <p>Halo, {{ $ownerMarketplace->name ?? 'Pemilik Marketplace' }},</p>
    <p>Status akun marketplace Anda telah diperbarui menjadi:
        <strong>{{ $ownerMarketplace->status ?? 'Tidak Tersedia' }}</strong>.
    </p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
