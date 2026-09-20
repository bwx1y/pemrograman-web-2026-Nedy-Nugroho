<?php
session_start();

$nama_kategori = trim($_POST['nama_kategori'] ?? '');
$keterangan = trim($_POST['keterangan'] ?? '');

$errors = [];
if ($nama_kategori === '') {
    $errors[] = "Category Name wajib diisi.";
}
if ($keterangan === '') {
    $errors[] = "Description wajib diisi.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if (!isset($_SESSION['category'])) {
    $dataFile = __DIR__ . '/../data/category.json';
    if (file_exists($dataFile)) {
        $_SESSION['category'] = json_decode(file_get_contents($dataFile), true) ?? [];
    } else {
        $_SESSION['category'] = [];
    }
}

$newId = count($_SESSION['category']) + 1;

$_SESSION['category'][] = [
    'id' => $newId,
    'name' => $nama_kategori,
    'description' => $keterangan,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kategori berhasil ditambahkan.'];
header('Location: index.php');
exit;
