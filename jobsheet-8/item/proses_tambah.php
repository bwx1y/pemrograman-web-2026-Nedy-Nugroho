<?php
session_start();

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

if (!isset($_SESSION['item'])) {
    $dataFile = __DIR__ . '/../data/item.json';
    if (file_exists($dataFile)) {
        $_SESSION['item'] = json_decode(file_get_contents($dataFile), true) ?? [];
    } else {
        $_SESSION['item'] = [];
    }
}

if (is_numeric($harga)) {
    $harga = 'Rp ' . number_format((float)$harga, 0, ',', '.');
}

$_SESSION['item'][] = [
    'code' => $kode,
    'name' => $nama,
    'category' => $kategori,
    'count' => (int) $jumlah,
    'price' => $harga,
    'status' => $status,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data item berhasil ditambahkan.'];
header('Location: index.php');
exit;
