<?php
global $pdo;
session_start();
require __DIR__ . '/../includes/koneksi.php';

$kode = trim($_POST['kode'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$kategori = trim($_POST['kategori'] ?? '');
$jumlah = $_POST['jumlah'] ?? '';
$harga = trim($_POST['harga'] ?? '');
$status = trim($_POST['status'] ?? '');

$errors = [];
if ($kode === '') {
    $errors[] = "Item Code wajib diisi.";
}
if ($nama === '') {
    $errors[] = "Item Name wajib diisi.";
}
if ($kategori === '') {
    $errors[] = "Kategori wajib dipilih.";
}
if (!is_numeric($jumlah) || (int)$jumlah < 0) {
    $errors[] = "Jumlah item harus berupa angka tidak negatif.";
}
if ($harga === '') {
    $errors[] = "Harga pembelian wajib diisi.";
}
if ($status === '') {
    $errors[] = "Status wajib dipilih.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if (is_numeric($harga)) {
    $harga = 'Rp ' . number_format((float)$harga, 0, ',', '.');
}

try {
    $stmtCat = $pdo->prepare("SELECT id FROM category WHERE name = :name");
    $stmtCat->execute(['name' => $kategori]);
    $catRow = $stmtCat->fetch(PDO::FETCH_ASSOC);
    $categoryId = $catRow ? $catRow['id'] : null;

    $stmt = $pdo->prepare(
        "INSERT INTO item (code, name, category_id, category, count, price, status)
         VALUES (:code, :name, :category_id, :category, :count, :price, :status)
         RETURNING id"
    );
    $stmt->execute([
        'code' => $kode,
        'name' => $nama,
        'category_id' => $categoryId,
        'category' => $kategori,
        'count' => (int) $jumlah,
        'price' => $harga,
        'status' => $status,
    ]);
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data item berhasil ditambahkan.'];
} catch (PDOException $e) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan item. Kode item mungkin sudah digunakan.'];
}

header('Location: index.php');
exit;
