<?php
session_start();

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
if ($password === '') {
    $errors[] = "Password wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if (!isset($_SESSION['user'])) {
    $dataFile = __DIR__ . '/../data/user.json';
    if (file_exists($dataFile)) {
        $_SESSION['user'] = json_decode(file_get_contents($dataFile), true) ?? [];
    } else {
        $_SESSION['user'] = [];
    }
}

$age = '-';
if ($tanggal_lahir !== '') {
    try {
        $birthDate = new DateTime($tanggal_lahir);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
    } catch (Exception $e) {
        $age = '-';
    }
}

$_SESSION['user'][] = [
    'username' => $username,
    'name' => $fullname,
    'role' => ucfirst($role),
    'birth_date' => $tanggal_lahir,
    'age' => $age,
    'phone' => $nomor_hp,
    'password' => '********',
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data member berhasil ditambahkan.'];
header('Location: index.php');
exit;
