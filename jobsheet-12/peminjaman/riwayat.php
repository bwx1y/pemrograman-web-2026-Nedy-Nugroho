<?php
require __DIR__ . '/../includes/auth.php';
global $pdo;
$page_title = "Riwayat Peminjaman";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$daftarUser = $pdo->query('SELECT id, name, username FROM "user" ORDER BY name ASC')->fetchAll(PDO::FETCH_ASSOC);

$userId = $_GET['user_id'] ?? $_GET['anggota_id'] ?? '';
$riwayat = [];
$selectedUser = null;

if ($userId !== '') {
    $stmtUser = $pdo->prepare('SELECT id, name, username FROM "user" WHERE id = :id');
    $stmtUser->execute(['id' => $userId]);
    $selectedUser = $stmtUser->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare(
        "SELECT i.name AS nama_barang, i.code AS kode_barang, p.tanggal_pinjam, p.tanggal_kembali, p.status
         FROM peminjaman p
         JOIN item i ON i.id = p.item_id
         WHERE p.user_id = :id
         ORDER BY p.tanggal_pinjam DESC, p.id DESC"
    );
    $stmt->execute(['id' => $userId]);
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="content-header">
    <h1>Riwayat Peminjaman</h1>
</div>

<div class="search-box">
    <form method="get" action="riwayat.php">
        <div>
            <label for="user_id">Pilih Anggota:</label>
            <select id="user_id" name="user_id" required>
                <option value="" disabled <?php echo $userId === '' ? 'selected' : ''; ?>>-- Pilih Anggota --</option>
                <?php foreach ($daftarUser as $user): ?>
                    <option value="<?php echo $user['id']; ?>" <?php echo (string) $userId === (string) $user['id'] ? 'selected' : ''; ?>>
                        <?php echo e($user['name']); ?> (<?php echo e($user['username']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit">Tampilkan</button>
        <?php if ($userId !== ''): ?>
            <a href="riwayat.php" style="margin-left: 8px; text-decoration: none; color: #7f8c8d;">Reset</a>
        <?php endif; ?>
    </form>
</div>

<?php if ($userId !== ''): ?>
    <h2>Riwayat Peminjaman — <?php echo e($selectedUser['name'] ?? 'Anggota'); ?></h2>
    <br>

    <?php if (empty($riwayat)): ?>
        <p>Belum ada riwayat transaksi peminjaman untuk anggota ini.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo e($r['kode_barang']); ?></td>
                            <td><?php echo e($r['nama_barang']); ?></td>
                            <td><?php echo e($r['tanggal_pinjam']); ?></td>
                            <td><?php echo $r['tanggal_kembali'] ? e($r['tanggal_kembali']) : '-'; ?></td>
                            <td>
                                <strong>
                                    <?php echo $r['status'] === 'dipinjam' ? 'Dipinjam' : 'Selesai'; ?>
                                </strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
