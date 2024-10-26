<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Register Owner</title>
</head>

<body>
    <section class="vh-100">
        <div class="container h-100 p-5">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 20px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Register Owner</p>

                                    <form class="mx-1 mx-md-4" method="POST" action="{{ route('register-owner') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-outline mb-3">
                                            <label for="name" class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="Nama lengkap" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Email" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="phone" class="form-label">Nomor Telepon</label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                placeholder="Nomor telepon" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="store_name" class="form-label">Nama Toko</label>
                                            <input type="text" class="form-control" name="store_name" id="store_name"
                                                placeholder="Nama toko" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="store_address" class="form-label">Alamat Toko</label>
                                            <input type="text" class="form-control" name="store_address"
                                                id="store_address" placeholder="Alamat toko" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="photo_store" class="form-label">Foto Venue/Lapangan</label>
                                            <input type="file" class="form-control" name="photo_store"
                                                id="photo_store" accept="image/*" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="link_maps" class="form-label">Link Google Maps</label>
                                            <input type="url" class="form-control" name="link_maps" id="link_maps"
                                                placeholder="Link Google Maps toko" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password" required>
                                        </div>

                                        <div class="form-outline mb-3">
                                            <label for="password_confirmation" class="form-label">Konfirmasi
                                                Password</label>
                                            <input type="password" class="form-control" name="password_confirmation"
                                                id="password_confirmation" placeholder="Konfirmasi password" required>
                                        </div>

                                        <div class="d-flex justify-content-center mt-5">
                                            <button type="submit"
                                                class="btn btn-primary btn-md w-100">Register</button>
                                        </div>

                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-registration/draw1.webp"
                                        class="img-fluid" alt="Sample image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
