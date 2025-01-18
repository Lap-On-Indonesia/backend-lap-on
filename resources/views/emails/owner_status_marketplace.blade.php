<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Update</title>
</head>

<body>
    <h1>Status Penjualan Diperbarui</h1>
    <p>Halo, {{ $ownerMarketplace->name ?? 'Pemilik Marketplace' }},</p>
    <p>Status akun penjualan Anda telah diperbarui menjadi:
        <strong>{{ $ownerMarketplace->status ?? 'Diterima' }}</strong>.
    </p>

    <p>Silakan login ke dashboard admin Anda untuk melihat detail lebih lanjut:</p>

    <p>
        <a href="{{ env('APP_URL') }}/admin/login" style="color: #007bff; text-decoration: none;">
            Klik di sini untuk Login
        </a>
    </p>

    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
