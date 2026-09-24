<?php
$page_title = "List of Items";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$keyword = trim($_GET['q'] ?? '');
$selectedCategory = trim($_GET['category'] ?? '');
$selectedStatus = trim($_GET['status'] ?? '');

$conditions = [];
$params = [];

if ($keyword !== '') {
    $conditions[] = '(code ILIKE :kw OR name ILIKE :kw)';
    $params['kw'] = '%' . $keyword . '%';
}

if ($selectedCategory !== '') {
    $conditions[] = 'category = :category';
    $params['category'] = $selectedCategory;
}

if ($selectedStatus !== '') {
    $conditions[] = 'status = :status';
    $params['status'] = $selectedStatus;
}

$whereClause = !empty($conditions) ? 'WHERE ' . implode(' AND ', $conditions) : '';

$stmt = $pdo->prepare("SELECT * FROM item $whereClause ORDER BY id DESC");
$stmt->execute($params);
$daftarItem = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT * FROM category ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-header">
    <h1>List of Items</h1>
    <a href="add.php" class="btn-add">+ Add Item</a>
</div>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
<?php endif; ?>

<div class="search-box">
    <form method="get" action="index.php">
        <div>
            <label for="search-input">Cari Items</label>
            <input type="text" id="search-input" name="q" value="<?php echo htmlspecialchars($keyword); ?>" placeholder="Ketik kata kunci...">
        </div>

        <div>
            <label for="category-filter">Filter Kategori</label>
            <select id="category-filter" name="category" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat['name']); ?>" <?php echo $selectedCategory === $cat['name'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="status-filter">Filter Status</label>
            <select id="status-filter" name="status" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="Good" <?php echo $selectedStatus === 'Good' ? 'selected' : ''; ?>>Good</option>
                <option value="Damaged" <?php echo $selectedStatus === 'Damaged' ? 'selected' : ''; ?>>Damaged</option>
            </select>
        </div>

        <button type="submit">Cari</button>
    </form>
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Category</th>
            <th>Count</th>
            <th>Purchase Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($daftarItem)): ?>
        <tr>
            <td colspan="7"><?php echo ($keyword !== '' || $selectedCategory !== '' || $selectedStatus !== '') ? 'Tidak ada data item yang sesuai dengan filter/pencarian.' : 'Belum ada data barang. Silakan tambah lewat menu "Add Item".'; ?></td>
        </tr>
        <?php else: ?>
            <?php foreach ($daftarItem as $item): ?>
            <tr>
                <td><?php echo htmlspecialchars($item['code'] ?? $item['kode'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($item['name'] ?? $item['nama'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($item['category'] ?? $item['kategori'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($item['count'] ?? $item['jumlah'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($item['price'] ?? $item['harga'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($item['status'] ?? ''); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $item['id']; ?>" class="btn-edit">Edit</a>
                    <form class="form-hapus" method="post" action="hapus.php">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <button type="submit" class="btn-delete btn-hapus">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
