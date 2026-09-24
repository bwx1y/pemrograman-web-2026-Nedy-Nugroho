<?php
$page_title = "Categories";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarCategory = $pdo->query("SELECT * FROM category ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
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
                    <a href="/category/edit.php?id=<?php echo $cat['id'] ?>" class="btn-edit">Edit</a>
                    <form class="form-hapus" method="post" action="/category/hapus.php">
                        <input type="hidden" name="id" value="<?php echo $cat['id']; ?>">
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
