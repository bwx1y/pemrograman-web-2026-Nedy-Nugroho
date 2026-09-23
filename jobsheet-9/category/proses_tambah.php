<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

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

try {
    $stmt = $pdo->prepare("INSERT INTO category (name, description) VALUES (:name, :description) RETURNING id");
    $stmt->execute([
        'name' => $nama_kategori,
        'description' => $keterangan,
    ]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kategori berhasil ditambahkan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan kategori. Nama kategori mungkin sudah ada.'];
}

header('Location: index.php');
exit;
