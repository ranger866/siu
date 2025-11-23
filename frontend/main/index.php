<?php
// File: landing_page.php
// Landing page untuk Sistem Informasi Universitas dalam bentuk PHP dengan styling dan JS terpisah
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Universitas - Landing Page</title>
    <link rel="stylesheet" href="/css/index.css">
</head>
<body>
    <header>
        <div class="logo">SIU</div>
        <div class="hamburger" onclick="toggleSidebar()">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <nav>
            <a href="#home">Beranda</a>
            <a href="#features">Fitur</a>
            <a href="#about">Tentang</a>
            <a href="#contact">Kontak</a>
            <a href="#" onclick="openModal()">Login</a>
        </nav>
    </header>

    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
        <a href="#home">Beranda</a>
        <a href="#features">Fitur</a>
        <a href="#about">Tentang</a>
        <a href="#contact">Kontak</a>
        <a href="#" onclick="openModal()">Login</a>
    </div>

    <!-- Modal Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Login</h2>
            <div id="errorMessage" style="color: red; display: none;"></div>
            <form id="loginForm">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <section id="home" class="hero">
        <h1>Selamat Datang di Sistem Informasi Universitas</h1>
        <p>Kelola data akademik, mahasiswa, dan administrasi dengan mudah dan efisien.</p>
        <a href="#" class="btn" onclick="openModal()">Mulai Sekarang</a>
    </section>

    <section id="features">
        <h2>Fitur Utama</h2>
        <div class="features">
            <div class="feature">
                <h3>Manajemen Mahasiswa</h3>
                <p>Kelola data mahasiswa</p>
            </div>
            <div class="feature">
                <h3>Manajemen Dosen</h3>
                <p>Kelola data dosen</p>
            </div>
            <div class="feature">
                <h3>Portal Online</h3>
                <p>Akses mudah melalui web</p>
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

    <script src="/js/index.js"></script>
</body>
</html>