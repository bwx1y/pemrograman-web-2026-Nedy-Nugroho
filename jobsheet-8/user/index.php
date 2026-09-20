<?php
global $pdo;
$page_title = "List of Members";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarUser = $pdo->query('SELECT * FROM "user" ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-header">
    <h1>List of Members</h1>
    <a href="add.php" class="btn-add">+ Add Member</a>
</div>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
<?php endif; ?>

<div class="search-box">
    <label for="search-input">Cari Member</label>
    <input type="text" id="search-input" placeholder="Ketik kata kunci...">

    <label for="role-filter">Filter Role</label>
    <select id="role-filter">
        <option value="">Semua Role</option>
        <option value="Admin">Admin</option>
        <option value="Staff">Staff</option>
        <option value="Member">Member</option>
    </select>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
        <tr>
            <th>Username</th>
            <th>Full Name</th>
            <th>Role</th>
            <th>Tanggal Lahir</th>
            <th>Umur</th>
            <th>Nomor HP</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($daftarUser)): ?>
        <tr>
            <td colspan="8">Belum ada data member. Silakan tambah lewat menu "Add Member".</td>
        </tr>
        <?php else: ?>
            <?php foreach ($daftarUser as $u): ?>
            <tr>
                <td><?php echo htmlspecialchars($u['username'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($u['name'] ?? $u['nama'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($u['role'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($u['birth_date'] ?? $u['tanggal_lahir'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($u['age'] ?? $u['umur'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($u['phone'] ?? $u['hp'] ?? '-'); ?></td>
                <td>
                    <button type="button" class="btn-edit">Edit</button>
                    <button type="button" class="btn-delete">Hapus</button>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
