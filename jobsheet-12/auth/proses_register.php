<?php
global $pdo;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$username      = trim($_POST['username'] ?? '');
$fullname      = trim($_POST['fullname'] ?? '');
$role          = trim($_POST['role'] ?? '');
$tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
$nomor_hp      = trim($_POST['nomor_hp'] ?? '');
$password      = $_POST['password'] ?? '';

$errors = [];
if ($username === '') {
    $errors[] = "Username wajib diisi.";
}
if ($fullname === '') {
    $errors[] = "Full Name wajib diisi.";
}
if ($tanggal_lahir === '') {
    $errors[] = "Tanggal Lahir wajib diisi.";
}
if ($nomor_hp === '') {
    $errors[] = "Nomor HP wajib diisi.";
}
if (strlen($password) < 6) {
    $errors[] = "Password minimal 6 karakter.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: register.php');
    exit;
}

$cek = $pdo->prepare('SELECT id FROM "user" WHERE username = :username');
$cek->execute(['username' => $username]);
if ($cek->fetch()) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah digunakan.'];
    header('Location: register.php');
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

$stmt = $pdo->prepare(
    'INSERT INTO "user" (username, name,  birth_date, age, phone, password)
     VALUES (:username, :name, :birth_date, :age, :phone, :password)'
);
$stmt->execute([
    'username'   => $username,
    'name'       => $fullname,
    'birth_date' => $tanggal_lahir,
    'age'        => $age,
    'phone'      => $nomor_hp,
    'password'   => password_hash($password, PASSWORD_DEFAULT),
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Registrasi berhasil. Silakan login.'];
header('Location: login.php');
exit;
