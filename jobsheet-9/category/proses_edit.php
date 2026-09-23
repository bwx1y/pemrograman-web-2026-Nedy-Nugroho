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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE category SET name = :name, description = :description WHERE id = :id");
    $stmt->execute([
        'name' => $nama_kategori,
        'description' => $keterangan,
        'id' => $id,
    ]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kategori berhasil diubah.'];
    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengubah kategori. Nama kategori sudah digunakan.'];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mengubah kategori: ' . $e->getMessage()];
    }
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}
