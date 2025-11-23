<?php
// File: dashboard.php
// Dashboard untuk Sistem Informasi Universitas setelah login dengan layout baru, sidebar lengkap, create user untuk admin, view berdasarkan role, statistik sebagai section, dan tampilan card

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];
$role = $_SESSION['role'] ?? 'dosen';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="role" content="<?php echo $role; ?>">
    <title>Dashboard - Sistem Informasi Universitas</title>
    <link rel="stylesheet" href="/css/dashboard.css">
</head>

<body>
    <header>
        <div class="logo">SIU</div>
        <nav>
            <span>Welcome, <?php echo htmlspecialchars($user); ?> (<?php echo htmlspecialchars($role); ?>)</span>
            <a href="#" onclick="logout()">Logout</a>
        </nav>
    </header>

    <div class="dashboard-container">
        <aside class="sidebar">
            <h3>Dashboard</h3>
            <ul>
                <li><a href="#statistics" onclick="showSection('statistics')">Statistik</a></li>
                <li><a href="#students" onclick="showSection('students')">Mahasiswa</a></li>
                <li><a href="#teachers" onclick="showSection('teachers')">Dosen</a></li>
                <?php if ($role === 'admin'): ?>
                    <li><a href="#users" onclick="showSection('users')">User</a></li>
                <?php endif; ?>
            </ul>
        </aside>

        <main class="main-content">
            <section id="statistics" class="dashboard-section active">
                <h2>Statistik</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3 id="studentsCount">0</h3>
                        <p>Mahasiswa</p>
                    </div>
                    <div class="stat-card">
                        <h3 id="teachersCount">0</h3>
                        <p>Dosen</p>
                    </div>
                    <?php if ($role === 'admin'): ?>
                        <div class="stat-card">
                            <h3 id="usersCount">0</h3>
                            <p>User</p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <section id="students" class="dashboard-section">
                <h2>Manajemen Mahasiswa</h2>
                <?php if ($role === 'admin'): ?>
                    <button onclick="showModal('addStudent')">Tambah Mahasiswa</button>
                <?php endif; ?>
                <div id="studentsCards" class="cards-container"></div>
            </section>

            <section id="teachers" class="dashboard-section">
                <h2>Manajemen Dosen</h2>
                <?php if ($role === 'admin'): ?>
                    <button onclick="showModal('addTeacher')">Tambah Dosen</button>
                <?php endif; ?>
                <div id="teachersCards" class="cards-container"></div>
            </section>

            <?php if ($role === 'admin'): ?>
                <section id="users" class="dashboard-section">
                    <h2>Manajemen User</h2>
                    <button onclick="showModal('addUser')">Tambah User</button>
                    <div id="usersCards" class="cards-container"></div>
                </section>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modal for Add/Edit -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Tambah/Edit</h2>
            <form id="modalForm">
                <input type="hidden" id="itemId">
                <input type="text" id="name" placeholder="Nama">
                <input type="text" id="nim" placeholder="NIM">
                <input type="text" id="major" placeholder="Jurusan">
                <input type="email" id="email" placeholder="Email">
                <input type="text" id="phone" placeholder="Telepon">
                <textarea id="address" placeholder="Alamat"></textarea>
                <input type="date" id="date" placeholder="Tanggal">
                <select id="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <!-- Fields for User -->
                <input type="text" id="username" placeholder="Username" style="display: none;">
                <input type="password" id="password" placeholder="Password" style="display: none;">
                <select id="userRole" style="display: none;">
                    <option value="dosen">Dosen</option>
                    <option value="admin">Admin</option>
                </select>
                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>

    <script src="/js/dashboard.js"></script>
</body>

</html>