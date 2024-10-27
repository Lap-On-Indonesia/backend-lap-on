<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lap.On Indonesia</title>

    <!--====== Favicon Icon ======-->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo-ijo.png') }}">

    <!-- ===== All CSS files ===== -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
</head>

<body>
    <!-- ====== Header Start ====== -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="navbar-wrapper">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container">
                                <div class="row mx-auto">
                                    <div class="col d-flex align-items-center">
                                        <a class="navbar-brand" href="#">
                                            <img src="{{ asset('images/logo/logo-putih.png') }}" alt="Logo"
                                                width="60" />
                                        </a>
                                        {{-- <h3 class="textLogo">Lap.On</h3> --}}
                                        <img src="{{ asset('images/logo/text-logo-white.png') }}" alt="Logo"
                                            width="100" class="textLogo" />
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mx-auto">
                                    <div class="col">
                                        <button class="navbar-toggler">
                                            <span class="toggler-icon"> </span>
                                            <span class="toggler-icon"> </span>
                                            <span class="toggler-icon"> </span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="navbar-collapse">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="menu-scroll" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="menu-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="menu-scroll" href="#features">Features</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="menu-scroll" href="#faq">FAQ</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="menu-scroll" href="#team">Team</a>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a class="" href="#contact">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ====== Header End ====== -->

    <!-- ====== Hero Start ====== -->
    <section class="hero" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-10 col-lg-6 col-xl-6">
                    <div class="hero-content wow fadeInUp" data-wow-delay=".2s">
                        <h1 class="hero-title">Welcome to Lap.On</h1>
                        <p class="hero-desc">
                            Tempat dimana passion bertemu lapangan! Temukan pengalaman
                            bermain yang tak terlupakan dengan booking lapangan olahraga
                            secara online
                        </p>
                        <a href="#contact" class="main-btn">Contact Us</a>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-6">
                    <div class="hero-image wow fadeInUp" data-wow-delay=".25s">
                        <!-- <div class="video-btn-wrapper">
                <a href="javascript:void(0)" class="video-btn glightbox">
                  <i class="lni lni-play"></i>
                </a>
              </div> -->
                        <img src="{{ asset('images/hero/mockup_ui.png') }}" alt="hero-image"
                            class="image img-fluid w-auto" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Hero End ====== -->

    <!-- ====== Features Start ====== -->
    <section id="features" class="features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title mx-auto text-center">
                        <span>Fitur</span>
                        <h2>Fitur Unggulan Kami</h2>
                        <p>
                            Mulai Explore Melalui Inovasi dan Keunggulan di Setiap Detail
                            dan Jelajahi Fitur Unggulan Kami!
                        </p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-4 col-md-6 col-sm-9">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".1s">
                        <div class="feature-icon">
                            <i class="lni lni-hand"></i>
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Komunitas Tim</h3>
                            <p class="feature-desc">
                                Membuat tim dengan teman atau komunitas untuk bermain atau
                                berolahraga
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-9">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".15s">
                        <div class="feature-icon">
                            <i class="lni lni-lock"></i>
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Booking Lapangan Online</h3>
                            <p class="feature-desc">
                                Booking lapangan melalui platform kami dengan sangat mudah
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 col-sm-9">
                    <div class="single-feature wow fadeInUp" data-wow-delay=".2s">
                        <div class="feature-icon">
                            <i class="lni lni-layout"></i>
                        </div>
                        <div class="feature-content">
                            <h3 class="feature-title">Versus</h3>
                            <p class="feature-desc">
                                Memudahkan tim untuk mencari lawan untuk bermain atau
                                berolahraga bersama
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Features End ====== -->

    <!--  ======== About Us Start ======== -->

    <section id="about" class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 my-3">
                    <div class="about-content">
                        <div class="section-title">
                            <span>About Us</span>
                            <h2>
                                The Best Partner For Easily Booking Sports Fields Online.
                            </h2>
                        </div>
                        <p>
                            Selamat datang di Lap. On, Di sini, kami mengubah cara kalian
                            menikmati kegiatan olahraga favorit. Booking lapangan jadi lebih
                            mudah dan seru! Bersama Lap. On, tiap langkah kalian menuju
                            lapangan impian bakal penuh kegembiraan. Ayo, main bareng Lap.
                            On, di mana setiap detik adalah petualangan olahraga keren!
                        </p>

                        <p>
                            Ayo, main bareng Lap. On, di mana setiap detik adalah
                            petualangan olahraga keren! #MainBarengLapOn
                        </p>

                        {{-- <a class="main-btn" href="#team">Meet Our Team</a> --}}
                    </div>
                </div>
                <div class="col-lg-6 my-3">
                    <div class="about-image-wrapper">
                        <div class="about-image text-center text-lg-center">
                            <img src="{{ asset('images/about/vecvecvec.png') }}" alt="about" class="image" />
                            <img src="{{ asset('images/about/dotted-shape.svg') }}" alt="shape"
                                class="shape shape-1 img-fluid" />
                            <img src="{{ asset('images/about/dotted-shape.svg') }}" alt="shape"
                                class="shape shape-2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End About Section -->

    <!--  ======== About Us End ======== -->

    <!-- ======= Gallery Section ======= -->
    <!-- <section id="gallery" class="gallery">
      <div class="container">

        <div class="section-title" data-aos="fade-up">
          <h2>Gallery</h2>
          <p>Check our Gallery</p>
        </div>

        <div class="row g-0" data-aos="fade-left">

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
              <a href="assets/img/gallery/gallery-1.jpg" class="gallery-lightbox">
                <img src="assets/images/gallery/gallery-1.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="150">
              <a href="assets/img/gallery/gallery-2.jpg" class="gallery-lightbox">
                <img src="assets/images/gallery/gallery-2.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
              <a href="assets/img/gallery/gallery-3.jpg" class="gallery-lightbox">
                <img src="assets/images/gallery/gallery-3.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>

          <div class="col-lg-3 col-md-4">
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="250">
              <a href="assets/img/gallery/gallery-4.jpg" class="gallery-lightbox">
                <img src="assets/images/gallery/gallery-4.jpg" alt="" class="img-fluid">
              </a>
            </div>
          </div>


        </div>

      </div>
    </section> -->
    <!-- End Gallery Section -->

    <!-- ====== FAQ Start ====== -->
    <section id="faq" class="faq">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center mx-auto">
                        <span>FAQ</span>
                        <h2>Any Questions? Answered</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="single-faq wow fadeInUp" data-wow-delay=".1s">
                        <div class="faq-icon">
                            <i class="lni lni-question-circle"></i>
                        </div>
                        <div class="faq-content">
                            <h4>Apa itu Lap. On dan bagaimana cara kerjanya?</h4>
                            <p>
                                Lap. On adalah aplikasi keren yang memudahkan kamu untuk
                                booking lapangan olahraga favoritmu secara online. Cukup pilih
                                lapangan, tentukan waktu, dan voila! Lapangan siap buat
                                petualangan olahragamu!
                            </p>
                        </div>
                    </div>
                    <div class="single-faq wow fadeInUp" data-wow-delay=".15s">
                        <div class="faq-icon">
                            <i class="lni lni-question-circle"></i>
                        </div>
                        <div class="faq-content">
                            <h4>
                                Apa saja jenis lapangan yang bisa saya booking di Lap. On?
                            </h4>
                            <p>
                                Di Lap. On, pilihan lapanganmu tanpa batas! Mulai dari
                                lapangan futsal, basket, hingga lapangan bola, semuanya bisa
                                kamu temukan dan booking dengan mudah. Variety is the spice of
                                sports life!
                            </p>
                        </div>
                    </div>
                    <div class="single-faq wow fadeInUp" data-wow-delay=".2s">
                        <div class="faq-icon">
                            <i class="lni lni-question-circle"></i>
                        </div>
                        <div class="faq-content">
                            <h4>Bagaimana cara pembayaran di Lap. On?</h4>
                            <p>
                                Pembayaran di Lap. On nggak ribet! Kamu bisa pilih metode
                                pembayaran yang nyaman, mulai dari transfer bank hingga
                                e-wallet favoritmu. Cepat, simpel, dan pastinya aman!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="single-faq wow fadeInUp" data-wow-delay=".1s">
                        <div class="faq-icon">
                            <i class="lni lni-question-circle"></i>
                        </div>
                        <div class="faq-content">
                            <h4>Apakah saya bisa membatalkan booking lapangan?</h4>
                            <p>
                                Tentu saja! Kehidupan kita sering berubah, dan di Lap. On,
                                kami nggak mau bikin ribet. Kamu bisa membatalkan booking
                                lapanganmu dengan mudah, tapi jangan lupa cek ketentuan
                                pembatalannya, ya!
                            </p>
                        </div>
                    </div>
                    <div class="single-faq wow fadeInUp" data-wow-delay=".15s">
                        <div class="faq-icon">
                            <i class="lni lni-question-circle"></i>
                        </div>
                        <div class="faq-content">
                            <h4>
                                Bagaimana jika saya mengalami masalah saat menggunakan Lap.
                                On?
                            </h4>
                            <p>
                                Don't worry, be happy! Kalau ada masalah, tim customer support
                                kami siap membantu 24/7. Kamu bisa chat atau telepon, pasti
                                akan dijawab dengan senyum. Kepuasan kamu adalah prioritas
                                kami!
                            </p>
                        </div>
                    </div>
                    <div class="single-faq wow fadeInUp" data-wow-delay=".2s">
                        <div class="faq-icon">
                            <i class="lni lni-question-circle"></i>
                        </div>
                        <div class="faq-content">
                            <h4>Apa keuntungan gabung di Lap. On?</h4>
                            <p>
                                Bergabung di Lap. On bukan cuma soal booking lapangan, tapi
                                juga tentang komunitas olahraga seru! Dapatkan promo
                                eksklusif, jadi bagian dari event spesial, dan temukan teman
                                olahraga baru. Mari ramaikan Lap. On community!
                            </p>
                        </div>
                    </div>
                    <!-- <div class="single-faq wow fadeInUp" data-wow-delay=".2s">
              <div class="faq-icon">
                <i class="lni lni-question-circle"></i>
              </div>
              <div class="faq-content">
                <h4>Kapan Aplikasi Lap. On bisa didownload?</h4>
                <p>Jangan khawatir ya, Aplikasi kami sedang dalam pembuatan, percaya deh pasti bikin kalian seneng nantinya, jangan lupa untuk follow social media Lap. On yang untuk update mengenai aplikasi kami. Hehe</p>
              </div>
            </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- ====== FAQ End ====== -->

    <!-- ====== Team Start ====== -->
    {{-- <section id="team" class="team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title mx-auto text-center">
                        <span>Our Team</span>
                        <h2>Meet The Team</h2>
                        <p>
                            There are many variations of passages of Lorem Ipsum available
                            but the majority have suffered alteration in some form.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".1s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/vindo.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Vindo Raidansyah Basuki</h5>
                            <h6>CMO</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="lni lni-github-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/vindo_raidan/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".15s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/vatra.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Vatra Kusumah Khanza</h5>
                            <h6>CEO</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="">
                                    <img src="{{ asset('images/team/ic_linkedin.png') }}" alt="icon linkedin"
                                        width="24">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="{{ asset('images/team/ic_github.png') }}" alt="icon github"
                                        width="24">
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/antarariiq/">
                                    <img src="{{ asset('images/team/ic_instagram.png') }}" alt="icon instagram"
                                        width="24">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="{{ asset('images/team/ic_twitter.png') }}" alt="icon twitter"
                                        width="20">
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <img src="{{ asset('images/team/ic_behance.png') }}" alt="icon behance"
                                        width="24">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".2s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/reo.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Reonaldi Saputro</h5>
                            <h6>CTO</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/reonaldi-saputro-bb5014207/">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/reonaldi152">
                                    <i class="lni lni-github-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/reonaldi_saputro/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".1s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/nanda.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Nanda Putri Ramadhani</h5>
                            <h6>Business Analyst</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/nanda-putri-ramadhani-b4a6b422b">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <!-- <li>
                  <a href="javascript:void(0)">
                    <i class="lni lni-github-original"></i>
                  </a>
                </li> -->
                            <li>
                                <a href="https://www.instagram.com/nandaputttri?igsh=NWFmMmc1ZHVvbmE0">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".15s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/alwan.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Alwan Alkautsar. P</h5>
                            <h6>Graphic Designer</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/alwan-alkautsar-pribadi-855700224/">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.behance.net/alwanpribadi/projects">
                                    <i class="lni lni-behance-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/alwanalkautsar/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".2s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/fardi.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Fardi Khalik Ramadhan</h5>
                            <h6>Software Engineer</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/fardi-khalik-ramadhan/">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/Fardi18">
                                    <i class="lni lni-github-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/fardi_nasution/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".25s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/nurhadi.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Nurhadi Ghifari Ramadhan</h5>
                            <h6>Front-End Developer</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/nurhadi-ghifari-ramadhan-27b507207/">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://github.com/nurhadighi24">
                                    <i class="lni lni-github-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/nurhadighifari/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".2s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/rofid.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Rofid Nasif Annafie</h5>
                            <h6>Back-End Developer</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/rofid/">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="lni lni-github-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/piddddz/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-sm-6">
                    <div class="single-team wow fadeInUp" data-wow-delay=".25s">
                        <div class="team-image-wrapper">
                            <div class="team-image">
                                <img src="{{ asset('images/team/yoga.jpg') }}" alt="team" />
                            </div>
                        </div>
                        <div class="team-info">
                            <h5>Yoga Pratama</h5>
                            <h6>UIUX Designer</h6>
                        </div>
                        <ul class="team-socials">
                            <li>
                                <a href="https://www.linkedin.com/in/yoga-pratama-770a1b2b8/">
                                    <i class="lni lni-linkedin-original"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/rvyoug/">
                                    <i class="lni lni-instagram-filled"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- ====== Team End ====== -->

    <!-- ======= Contact Section ======= -->
    {{-- <section id="contact" class="contact">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Contact Us</p>
            </div>

            <div class="row">
                <div class="col-lg-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Lokasi:</h4>
                            <p>Tangerang Selatan, Banten</p>
                        </div>

                        <div class="email">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p>lap.on.indonesia@gmail.com</p>
                        </div>

                        <div class="phone">
                            <i class="bi bi-phone"></i>
                            <h4>Telepon:</h4>
                            <p>+62 89537 5873 744</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">
                    <form action="{{ route('inquiry.store') }}" method="POST" role="form"
                        class="php-email-form">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Nama" required />
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email" required />
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Judul" required />
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center">
                            <button type="submit">Kirim Pesan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section> --}}
    <!-- End Contact Section -->

    <!-- ====== Footer Start ====== -->
    <footer class="footer wow fadeInUp" data-wow-delay=".15s">
        <div class="footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="widget">
                            <a href="#" class="footer-logo">
                                <img src="{{ asset('images/logo/logo.jpg') }}" alt="logo" width="60"
                                    style="border-radius: 8px" />
                            </a>
                            <p class="widget-desc">
                                We create experiences using technology.
                            </p>
                            <ul class="widget-socials">
                                <!-- <li>
                    <a href="javascript:void(0)">
                      <i class="lni lni-facebook-filled"></i>
                    </a>
                  </li> -->
                                <!-- <li>
                    <a href="javascript:void(0)">
                      <i class="lni lni-twitter-filled"></i>
                    </a>
                  </li> -->
                                <li>
                                    <a href="https://www.instagram.com/lap.on_id/">
                                        <i class="lni lni-instagram-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/lap-on">
                                        <i class="lni lni-linkedin-original"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                        <div class="widget">
                            <h5 class="widget-title">About Us</h5>
                            <ul class="widget-links">
                                <li>
                                    <a href="#">Home</a>
                                </li>
                                <li>
                                    <a href="#features">Features</a>
                                </li>
                                <li>
                                    <a href="#about">About</a>
                                </li>
                                <li>
                                    <a href="#faq">FAQ</a>
                                </li>
                                <li>
                                    <a href="#team">Team</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget">
                            <h5 class="widget-title">Features</h5>
                            <ul class="widget-links">
                                <li>
                                    <a href="javascript:void(0)">How it works</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Privacy policy</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Terms of service</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">Refund policy</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                        <div class="widget">
                            <h5 class="widget-title">Our Products</h5>
                            <ul class="widget-links">
                                <li>
                                    <a href="#features" rel="nofollow noopner">Komunitas Tim
                                    </a>
                                </li>
                                <li>
                                    <a href="#features" rel="nofollow noopner">Booking Lapangan</a>
                                </li>
                                <li>
                                    <a href="#features" rel="nofollow noopner">versus</a>
                                </li>
                                <!-- <li>
                    <a href="https://graygrids.com/" rel="nofollow noopner" target="_blank">Plain Admin</a>
                  </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ====== Footer End ====== -->

    <!-- ====== Back To Top Start ====== -->
    {{-- <a href="javascript:void(0)" class="back-to-top">
        <i class="lni lni-chevron-up"> </i>
    </a> --}}
    <!-- ====== Back To Top End ====== -->

    <!-- ====== All Javascript Files ====== -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/glightbox.min.js') }}s"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
