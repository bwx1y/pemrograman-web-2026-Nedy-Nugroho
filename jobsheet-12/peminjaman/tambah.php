<?php
require __DIR__ . '/../includes/auth.php';
global $pdo;
$page_title = "Peminjaman Baru";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$daftarUser = $pdo->query('SELECT id, name, username FROM "user" ORDER BY name ASC')->fetchAll(PDO::FETCH_ASSOC);
$daftarItemTersedia = $pdo->query("SELECT id, name, code, count FROM item WHERE count > 0 ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Peminjaman Baru</h1>
<br/>
<div class="form-container">
    <h2>Catat Peminjaman Barang</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo e($flash['type']); ?>"><?php echo e($flash['pesan']); ?></p>
    <?php endif; ?>

    <?php if (empty($daftarUser)): ?>
        <p class="flash flash-error">Belum ada data anggota. Tambahkan anggota terlebih dahulu.</p>
    <?php elseif (empty($daftarItemTersedia)): ?>
        <p class="flash flash-error">Tidak ada barang dengan stok tersedia saat ini.</p>
    <?php else: ?>
        <form id="form-peminjaman" method="POST" action="proses_tambah.php">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="user_id">Pilih Anggota</label>
                <select id="user_id" name="user_id" required>
                    <option value="" disabled selected>-- Pilih Anggota --</option>
                    <?php foreach ($daftarUser as $user): ?>
                        <option value="<?php echo (int) $user['id']; ?>">
                            <?php echo e($user['name']); ?> (<?php echo e($user['username']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="item_id">Pilih Barang (Stok > 0)</label>
                <select id="item_id" name="item_id" required>
                    <option value="" disabled selected>-- Pilih Barang --</option>
                    <?php foreach ($daftarItemTersedia as $item): ?>
                        <option value="<?php echo (int) $item['id']; ?>">
                            <?php echo e($item['name']); ?> (Kode: <?php echo e($item['code']); ?> | Stok: <?php echo e((string) $item['count']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan Peminjaman</button>
                <a href="../index.php" class="btn-cancel">Batal</a>
            </div>
        </form>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
