<?php
require __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
global $pdo;
require __DIR__ . '/../includes/koneksi.php';

csrf_verify();

$userId = $_POST['user_id'] ?? $_POST['anggota_id'] ?? '';
$itemId = $_POST['item_id'] ?? $_POST['buku_id'] ?? '';

if ($userId === '' || $itemId === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota dan barang wajib dipilih.'];
    header('Location: tambah.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $cek = $pdo->prepare("SELECT count FROM item WHERE id = :id FOR UPDATE");
    $cek->execute(['id' => $itemId]);
    $item = $cek->fetch(PDO::FETCH_ASSOC);

    if (!$item || (int) $item['count'] < 1) {
        throw new Exception('Stok barang tidak tersedia.');
    }

    $insert = $pdo->prepare(
        "INSERT INTO peminjaman (item_id, user_id, tanggal_pinjam, status)
         VALUES (:item_id, :user_id, CURRENT_DATE, 'dipinjam')"
    );
    $insert->execute([
        'item_id' => $itemId,
        'user_id' => $userId
    ]);

    $update = $pdo->prepare("UPDATE item SET count = count - 1 WHERE id = :id");
    $update->execute(['id' => $itemId]);

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Peminjaman berhasil dicatat.'];
    header('Location: ../index.php');
    exit;
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mencatat peminjaman: ' . $e->getMessage()];
    header('Location: tambah.php');
    exit;
}
