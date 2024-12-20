<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 6px 30px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            overflow: hidden;
            animation: fadeIn 1s ease-in-out;
        }

        .card-header {
            background-color: #28a745;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            padding: 1.5rem;
        }

        .card-header .card-icon {
            font-size: 3rem;
        }

        .card-body {
            padding: 2rem;
            text-align: center;
        }

        .card-title {
            font-size: 1.75rem;
            margin-bottom: 1rem;
        }

        .card-text {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-check-email {
            background-color: #007bff;
            color: #fff;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            border-radius: 50px;
            transition: transform 0.3s;
        }

        .btn-check-email:hover {
            background-color: #0056b3;
            color: #fff;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <div class="card-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            Registrasi Berhasil
        </div>
        <div class="card-body">
            <h3 class="card-title text-success">Terima kasih telah mendaftar!</h3>
            <p class="card-text">
                Kami sedang meninjau pendaftaran Anda.
                <br> Silakan cek email Anda untuk mengetahui status registrasi Anda.
            </p>
            <a href="https://mail.google.com/" target="_blank" class="btn btn-check-email">Cek Email Sekarang</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
