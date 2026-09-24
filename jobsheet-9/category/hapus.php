<?php
global $pdo;
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = $_POST['id'] ?? null;
if ($id) {
    try {
        $cek = $pdo->prepare("SELECT COUNT(*) FROM item WHERE category_id = :id");
        $cek->execute(['id' => $id]);
        if ($cek->fetchColumn() > 0) {
            $_SESSION['flash'] = [
                'type' => 'error',
                'pesan' => 'Kategori tidak dapat dihapus karena masih digunakan oleh data item.'
            ];
            header('Location: index.php');
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM category WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data kategori berhasil dihapus.'];
    } catch (PDOException $e) {
        if ($e->getCode() === '23503') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'pesan' => 'Kategori tidak dapat dihapus karena masih terhubung dengan data barang.'
            ];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus kategori: ' . $e->getMessage()];
        }
    }
}

header('Location: index.php');
exit;
