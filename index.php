<?php
// File: landing_page.php
// Landing page untuk Sistem Informasi Universitas dalam bentuk PHP
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Universitas - Landing Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            color: #000000;
            background-color: #FFFFFF;
            line-height: 1.6;
        }
        header {
            background-color: #000000;
            color: #FFFFFF;
            padding: 20px 10px; /* Padding atas/bawah 20px, kiri/kanan 10px */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo {
            font-size: 2em;
            font-weight: bold;
            margin-left: 10px; /* Jarak 10px dari kiri */
        }
        nav {
            margin-right: 10px; /* Jarak 10px dari kanan */
        }
        nav a {
            color: #FFFFFF;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px; /* Padding untuk efek hover */
            transition: all 0.3s ease; /* Transisi halus */
        }
        nav a:hover {
            background-color: #FFFFFF;
            color: #000000;
            border-radius: 5px;
            text-decoration: none;
        }
        .hero {
            padding: 100px 20px;
            text-align: center;
            background-color: #F5F5F5; /* Light gray for subtle contrast */
        }
        .hero h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #000000;
            color: #FFFFFF;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .btn:hover {
            background-color: #333333;
        }
        section {
            padding: 60px 20px;
            text-align: center;
        }
        .features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .feature {
            width: 30%;
            margin: 20px;
            padding: 20px;
            border: 1px solid #CCCCCC;
            border-radius: 5px;
        }
        footer {
            background-color: #000000;
            color: #FFFFFF;
            text-align: center;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .features {
                flex-direction: column;
            }
            .feature {
                width: 100%;
            }
            header {
                flex-direction: column;
                text-align: center;
            }
            .logo {
                margin-left: 0;
                margin-bottom: 10px;
            }
            nav {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">SIU</div>
        <nav>
            <a href="#home">Beranda</a>
            <a href="#features">Fitur</a>
            <a href="#about">Tentang</a>
            <a href="#contact">Kontak</a>
        </nav>
    </header>

    <section id="home" class="hero">
        <h1>Selamat Datang di Sistem Informasi Universitas</h1>
        <p>Kelola data akademik, mahasiswa, dan administrasi dengan mudah dan efisien.</p>
        <a href="#" class="btn">Mulai Sekarang</a>
    </section>

    <section id="features">
        <h2>Fitur Utama</h2>
        <div class="features">
            <div class="feature">
                <h3>Manajemen Mahasiswa</h3>
                <p>Kelola data mahasiswa, nilai, dan jadwal kuliah secara terintegrasi.</p>
            </div>
            <div class="feature">
                <h3>Laporan Akademik</h3>
                <p>Hasilkan laporan otomatis untuk analisis dan keputusan strategis.</p>
            </div>
            <div class="feature">
                <h3>Portal Online</h3>
                <p>Akses mudah melalui web untuk mahasiswa, dosen, dan staf.</p>
            </div>
            <div class="feature">
                <h3>Manajemen Dosen</h3>
                <p>Kelola data dosen, jadwal mengajar, dan evaluasi kinerja.</p>
            </div>
            <div class="feature">
                <h3>Sistem Keuangan</h3>
                <p>Pantau pembayaran SPP, beasiswa, dan anggaran universitas.</p>
            </div>
            <div class="feature">
                <h3>Integrasi Data</h3>
                <p>Hubungkan dengan sistem eksternal untuk sinkronisasi data yang mulus.</p>
            </div>
        </div>
    </section>

    <section id="about">
        <h2>Tentang Kami</h2>
        <p>Sistem Informasi Universitas dirancang untuk mendukung operasional universitas dengan teknologi modern, memastikan efisiensi dan akurasi data.</p>
    </section>

    <section id="contact">
        <h2>Kontak</h2>
        <p>Hubungi kami di: info@universitas.edu | Telepon: (021) 123-4567</p>
    </section>

    <footer>
        <p>&copy; 2025 Sistem Informasi Universitas. Semua hak dilindungi.</p>
    </footer>
</body>
</html>
