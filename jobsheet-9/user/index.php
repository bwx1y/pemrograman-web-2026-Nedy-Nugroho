<?php
global $pdo;
$page_title = "List of Members";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page - 1) * $perPage;
$keyword = trim($_GET['q'] ?? '');
$role = trim($_GET['role'] ?? '');

$conditions = [];
$params = [];

if ($keyword !== '') {
    $conditions[] = '(username ILIKE :kw OR name ILIKE :kw)';
    $params['kw'] = $keyword . '%';
}

if ($role !== '') {
    $conditions[] = 'role = :role';
    $params['role'] = $role;
}

$whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

$hitung = $pdo->prepare('SELECT COUNT(*) FROM "user" ' . $whereClause);
$hitung->execute($params);
$totalRows = (int)$hitung->fetchColumn();

$stmt = $pdo->prepare('SELECT * FROM "user" ' . $whereClause . ' ORDER BY id DESC LIMIT :limit OFFSET :offset');
foreach ($params as $key => $val) {
    $stmt->bindValue($key, $val);
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$daftarUser = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int)ceil($totalRows / $perPage));
?>

<div class="content-header">
    <h1>List of Members</h1>
    <a href="add.php" class="btn-add">+ Add Member</a>
</div>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
<?php endif; ?>

<div class="search-box">
    <form method="get" action="index.php">
        <div>
            <label for="search-input">Cari Member</label>
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>"
                   placeholder="Cari username atau nama...">
        </div>

        <div>
            <label for="role-filter">Filter Role</label>
            <select id="role-filter" name="role" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="Admin" <?php echo $role === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="Staff" <?php echo $role === 'Staff' ? 'selected' : ''; ?>>Staff</option>
                <option value="Member" <?php echo $role === 'Member' ? 'selected' : ''; ?>>Member</option>
            </select>
        </div>

        <button type="submit">Cari</button>
    </form>
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
                        <a href="edit.php?id=<?php echo $u['id']; ?>" class="btn-edit">Edit</a>
                        <form class="form-hapus" method="post" action="hapus.php">
                            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                            <button type="submit" class="btn-delete btn-hapus">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<nav class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <?php
        $queryParams = ['page' => $i];
        if ($keyword !== '') {
            $queryParams['q'] = $keyword;
        }
        if ($role !== '') {
            $queryParams['role'] = $role;
        }
        ?>
        <a href="index.php?<?php echo http_build_query($queryParams); ?>"
           class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</nav>

<?php include __DIR__ . '/../includes/footer.php'; ?>
