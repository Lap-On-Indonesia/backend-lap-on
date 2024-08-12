<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Sukses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f8f9fa;
            margin: 0;
        }

        .card {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            /* Memusatkan konten di dalam card */
        }

        .logo {
            width: 100px;
            height: auto;
            margin: 0 auto 20px;
            /* Memusatkan logo dan memberi jarak bawah */
        }

        .success-message {
            color: #28a745;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .details {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }
    </style>
</head>

<body>
    <div class="card">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Perusahaan" class="logo">
        <div class="success-message">Pembayaran Berhasil!</div>
        <div class="details">
            Terima kasih telah melakukan pembayaran. Pesanan Anda akan segera diproses.
        </div>
        {{-- <a href="" class="btn btn-primary">Kembali ke Beranda</a> --}}
    </div>
</body>

</html>
