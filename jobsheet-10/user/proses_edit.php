<?php
global $pdo;
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$fullname = trim($_POST['fullname'] ?? '');
$role = trim($_POST['role'] ?? '');
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
$nomor_hp = trim($_POST['nomor_hp'] ?? '');
$password = trim($_POST['password'] ?? '');

$errors = [];
if ($username === '') {
    $errors[] = "Username wajib diisi.";
}
if ($fullname === '') {
    $errors[] = "Full Name wajib diisi.";
}
if ($role === '') {
    $errors[] = "Role wajib dipilih.";
}
if ($tanggal_lahir === '') {
    $errors[] = "Tanggal Lahir wajib diisi.";
}
if ($nomor_hp === '') {
    $errors[] = "Nomor HP wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$age = null;
if ($tanggal_lahir !== '') {
    try {
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
    } catch (Exception $e) {
        $age = null;
    }
}

try {
    if ($password !== '') {
        $stmt = $pdo->prepare(
            'UPDATE "user"
             SET username = :username, name = :name, role = :role,
                 birth_date = :birth_date, age = :age, phone = :phone, password = :password
             WHERE id = :id'
        );
        $params = [
            'username' => $username,
            'name' => $fullname,
            'role' => ucfirst($role),
            'birth_date' => $tanggal_lahir,
            'age' => $age,
            'phone' => $nomor_hp,
            'password' => $password,
            'id' => $id,
        ];
    } else {
        $stmt = $pdo->prepare(
            'UPDATE "user"
             SET username = :username, name = :name, role = :role,
                 birth_date = :birth_date, age = :age, phone = :phone
             WHERE id = :id'
        );
        $params = [
            'username' => $username,
            'name' => $fullname,
            'role' => ucfirst($role),
            'birth_date' => $tanggal_lahir,
            'age' => $age,
            'phone' => $nomor_hp,
            'id' => $id,
        ];
    }
    $stmt->execute($params);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data member berhasil diubah.'];
    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengubah member. Username sudah digunakan.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengubah member: ' . $e->getMessage()];
    }
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}
