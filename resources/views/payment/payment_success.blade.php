<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .container h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .container p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .container a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .container a:hover {
            background-color: #218838;
        }
        @media (max-width: 480px) {
            .container {
                padding: 15px;
            }
            .container h1 {
                font-size: 20px;
            }
            .container p {
                font-size: 14px;
            }
            .container a {
                padding: 8px 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://example.com/success-icon.png" alt="Success Icon">
        <h1>Pembayaran Berhasil!</h1>
        <p>Terima kasih atas pembayaran Anda. Pesanan Anda sedang diproses.</p>
        <a href="/">Kembali ke Beranda</a>
    </div>
</body>
</html>
