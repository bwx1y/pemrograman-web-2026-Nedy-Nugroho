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
if (!preg_match('/^\d+$/', (string)$jumlah)) {
    $errors[] = "Jumlah item harus berupa angka dan tidak boleh di bawah 0.";
}
$cleanHarga = preg_replace('/[^0-9]/', '', $harga);
if ($harga === '' || !preg_match('/^\d+$/', $cleanHarga)) {
    $errors[] = "Harga pembelian harus berupa angka dan tidak boleh di bawah 0.";
}
if ($status === '') {
    $errors[] = "Status wajib dipilih.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

if ($cleanHarga !== '') {
    $harga = 'Rp ' . number_format((float)$cleanHarga, 0, ',', '.');
}

try {
    $stmtCat = $pdo->prepare("SELECT id, name FROM category WHERE name = :name OR name ILIKE :name");
    $stmtCat->execute(['name' => $kategori]);
    $catRow = $stmtCat->fetch(PDO::FETCH_ASSOC);

    if ($catRow) {
        $categoryId = $catRow['id'];
        $kategori = $catRow['name'];
    } else {
        $stmtNewCat = $pdo->prepare("INSERT INTO category (name, description) VALUES (:name, :desc) RETURNING id");
        $stmtNewCat->execute(['name' => $kategori, 'desc' => $kategori]);
        $categoryId = $stmtNewCat->fetchColumn();
    }

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
    if ($e->getCode() === '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Gagal menambahkan item. Kode item '$kode' sudah digunakan."];
    } elseif ($e->getCode() === '23503') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => "Gagal menambahkan item. Kategori '$kategori' tidak valid di database."];
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menambahkan item: ' . $e->getMessage()];
    }
}

header('Location: index.php');
exit;
