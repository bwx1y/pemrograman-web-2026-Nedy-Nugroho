<?php
$page_title = "Categories";
include __DIR__ . '/../includes/header.php';

if (!isset($_SESSION['category'])) {
    $dataFile = __DIR__ . '/../data/category.json';
    if (file_exists($dataFile)) {
        $_SESSION['category'] = json_decode(file_get_contents($dataFile), true) ?? [];
    } else {
        $_SESSION['category'] = [];
    }
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$daftarCategory = $_SESSION['category'] ?? [];
?>

<div class="content-header">
    <h1>Categories</h1>
    <a href="add.php" class="btn-add">+ Add Category</a>
</div>

<?php if ($flash): ?>
    <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
<?php endif; ?>

<div class="search-box">
    <label for="search-input">Cari Kategori</label>
    <input type="text" id="search-input" placeholder="Ketik kata kunci...">
</div>

<div class="table-responsive">
    <table class="data-table">
        <thead>
        <tr>
            <th>No</th>
            <th>Category Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($daftarCategory)): ?>
        <tr>
            <td colspan="4">Belum ada data kategori. Silakan tambah lewat menu "Add Category".</td>
        </tr>
        <?php else: ?>
            <?php $no = 1; foreach ($daftarCategory as $cat): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($cat['name'] ?? $cat['nama'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($cat['description'] ?? $cat['deskripsi'] ?? ''); ?></td>
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
