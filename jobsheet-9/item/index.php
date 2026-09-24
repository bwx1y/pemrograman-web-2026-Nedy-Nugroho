<?php
$page_title = "List of Items";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarItem = $pdo->query("SELECT * FROM item ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="content-header">
    <h1>List of Items</h1>
    <a href="add.php" class="btn-add">+ Add Item</a>
</div>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
<?php endif; ?>

<div class="search-box">
    <label for="search-input">Cari Items</label>
    <input type="text" id="search-input" placeholder="Ketik kata kunci...">

    <label for="category-filter">Filter Kategori</label>
    <select id="category-filter">
        <option value="">Semua Kategori</option>
        <option value="Electronic Components">Electronic Components</option>
        <option value="IT Devices">IT Devices</option>
        <option value="Office Supplies">Office Supplies</option>
        <option value="Furniture">Furniture</option>
    </select>

    <label for="status-filter">Filter Status</label>
    <select id="status-filter">
        <option value="">Semua Status</option>
        <option value="Good">Good</option>
        <option value="Damaged">Damaged</option>
    </select>
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
            <td colspan="7">Belum ada data barang. Silakan tambah lewat menu "Add Item".</td>
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
                    <a href="/item/edit.php?id=<?php echo $item['id'] ?>" class="btn-edit">Edit</a>
                    <form class="form-hapus" method="post" action="/item/hapus.php">
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
