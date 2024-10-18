<!-- resources/views/register.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .form-section,
        .info-section {
            padding: 40px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .form-section {
            background-color: #fff;
            flex: 1;
        }

        .info-section {
            background-color: #46b2e0;
            color: white;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .info-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .info-section img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

    <div class="container register-container">
        <div class="row w-100">
            <!-- Left section - Form -->
            <div class="col-md-6 form-section">
                <h3>Buat Akun mu</h3>
                <form>
                    <div class="mb-3">
                        <label for="email" class="form-label">Work email</label>
                        <input type="email" class="form-control" id="email" placeholder="Work email">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-3">Continue with email →</button>
                    <p class="text-center">OR</p>
                    <button type="button" class="btn btn-outline-secondary w-100 mb-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png"
                            alt="Google" style="width: 20px; margin-right: 10px;">
                        Continue with Google
                    </button>
                    <p class="text-center mt-3">Already have an account? <a href="#">Log in</a></p>
                </form>
            </div>

            <!-- Right section - Info -->
            <div class="col-md-6 info-section">
                <h2>Apa itu LAP.ON?</h2>
                <img src="your-image-url-here" alt="Illustration">
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
