<?php
// File: api.php
// API responsive dengan auth dan CRUD untuk Sistem Informasi Universitas, akses database langsung, tanpa finances dan integration

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

session_start();

require_once 'connection.php';

// Fungsi auth sederhana
function isAuthenticated()
{
    return isset($_SESSION['user']);
}

// Fungsi untuk generate response
function sendResponse($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

// Parse request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$endpoint = $request[2] ?? '';

// Routing
switch ($endpoint) {
    case 'login':
        if ($method !== 'POST')
            sendResponse(['error' => 'Method not allowed'], 405);
        $input = json_decode(file_get_contents('php://input'), true);
        $username = $input['username'] ?? '';
        $password = $input['password'] ?? '';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password == $user["password"]) {
            $_SESSION["user"] = $username;
            $_SESSION['role'] = $user['role'];
            sendResponse(['success' => true, 'message' => 'berhasil']);
        } else if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            $_SESSION['role'] = $user['role'];
            sendResponse(['success' => true, 'message' => 'Login berhasil']);
        } else {
            sendResponse(['error' => 'Invalid credentials'], 401);
        }
        break;

    case 'logout':
        if ($method !== 'POST')
            sendResponse(['error' => 'Method not allowed'], 405);
        session_destroy();
        sendResponse(['success' => true, 'message' => 'Logout berhasil']);
        break;

    case 'students':
        // if (!isAuthenticated())
        //     sendResponse(['error' => 'Unauthorized'], 401);
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM students");
            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendResponse($students);
        } elseif ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO students (name, nim, major, email, phone, address, enrollment_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$input['name'], $input['nim'], $input['major'], $input['email'], $input['phone'], $input['address'], $input['enrollment_date'], $input['status'] ?? 'active']);
            $input['id'] = $pdo->lastInsertId();
            sendResponse(['success' => true, 'message' => 'Mahasiswa ditambahkan', 'data' => $input]);
        } elseif ($method === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $stmt = $pdo->prepare("UPDATE students SET name=?, nim=?, major=?, email=?, phone=?, address=?, enrollment_date=?, status=? WHERE id=?");
            $stmt->execute([$input['name'], $input['nim'], $input['major'], $input['email'], $input['phone'], $input['address'], $input['enrollment_date'], $input['status'], $id]);
            sendResponse(['success' => true, 'message' => 'Mahasiswa diperbarui']);
        } elseif ($method === 'DELETE') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
            $stmt->execute([$id]);
            sendResponse(['success' => true, 'message' => 'Mahasiswa dihapus']);
        } else {
            sendResponse(['error' => 'Method not allowed'], 405);
        }
        break;

    case 'teachers':
        // if (!isAuthenticated())
        //     sendResponse(['error' => 'Unauthorized'], 401);
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM teachers");
            $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendResponse($teachers);
        } elseif ($method === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO teachers (name, nip, subject, email, phone, address, hire_date, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$input['name'], $input['nip'], $input['subject'], $input['email'], $input['phone'], $input['address'], $input['hire_date'], $input['status'] ?? 'active']);
            $input['id'] = $pdo->lastInsertId();
            sendResponse(['success' => true, 'message' => 'Dosen ditambahkan', 'data' => $input]);
        } elseif ($method === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $stmt = $pdo->prepare("UPDATE teachers SET name=?, nip=?, subject=?, email=?, phone=?, address=?, hire_date=?, status=? WHERE id=?");
            $stmt->execute([$input['name'], $input['nip'], $input['subject'], $input['email'], $input['phone'], $input['address'], $input['hire_date'], $input['status'], $id]);
            sendResponse(['success' => true, 'message' => 'Dosen diperbarui']);
        } elseif ($method === 'DELETE') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $stmt = $pdo->prepare("DELETE FROM teachers WHERE id=?");
            $stmt->execute([$id]);
            sendResponse(['success' => true, 'message' => 'Dosen dihapus']);
        } else {
            sendResponse(['error' => 'Method not allowed'], 405);
        }
        break;

    case 'reports':
        // if (!isAuthenticated())
        //     sendResponse(['error' => 'Unauthorized'], 401);
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM reports");
            $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendResponse($reports);
        } else {
            sendResponse(['error' => 'Method not allowed'], 405);
        }
        break;

    case 'users':
        // if (!isAuthenticated() || $_SESSION['role'] !== 'admin')
        //     sendResponse(['error' => 'Unauthorized'], 401);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $stmt = $pdo->query("SELECT id, username, role, created_at FROM users");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            sendResponse($users);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $hashedPassword = password_hash($input['password'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$input['username'], $hashedPassword, $input['role']]);
            $input['id'] = $pdo->lastInsertId();
            sendResponse(['success' => true, 'message' => 'User ditambahkan', 'data' => $input]);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $updateFields = [];
            $params = [];
            if (!empty($input['username'])) {
                $updateFields[] = "username = ?";
                $params[] = $input['username'];
            }
            if (!empty($input['password'])) {
                $updateFields[] = "password = ?";
                $params[] = password_hash($input['password'], PASSWORD_DEFAULT);
            }
            if (!empty($input['role'])) {
                $updateFields[] = "role = ?";
                $params[] = $input['role'];
            }
            $params[] = $id;
            $stmt = $pdo->prepare("UPDATE users SET " . implode(', ', $updateFields) . " WHERE id = ?");
            $stmt->execute($params);
            sendResponse(['success' => true, 'message' => 'User diperbarui']);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['id'] ?? null;
            $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
            $stmt->execute([$id]);
            sendResponse(['success' => true, 'message' => 'User dihapus']);
        } else {
            sendResponse(['error' => 'Method not allowed'], 405);
        }
        break;

    default:
        sendResponse(['error' => 'Endpoint not found'], 404);
}
?>