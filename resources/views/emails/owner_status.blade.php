<html>

<body>
    <h1>Status Diperbarui</h1>
    <p>Halo, {{ $owner->name }}</p>
    <p>Status akun Anda telah berubah menjadi: <strong>{{ $owner->status }}</strong>.</p>

    <p>Silakan login ke dashboard admin Anda untuk melihat detail lebih lanjut:</p>

    <p>
        <a href="{{ env('APP_URL') }}/admin/login" style="color: #007bff; text-decoration: none;">
            Klik di sini untuk Login
        </a>
    </p>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>

</html>
