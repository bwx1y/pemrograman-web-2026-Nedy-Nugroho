<?php
global $pdo;
$page_title = "Edit Category";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM category WHERE id = :id");
$stmt->execute(['id' => $id]);
$category = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$category) {
    header('Location: index.php');
    exit;
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Edit Category</h1>
<br/>
<div class="form-container">
    <h2>Edit Category Data</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="POST" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($category['id']); ?>">

        <div class="form-group">
            <label for="nama_kategori">Category Name</label>
            <input type="text" id="nama_kategori" name="nama_kategori" value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Description</label>
            <input type="text" id="keterangan" name="keterangan" value="<?php echo htmlspecialchars($category['description'] ?? ''); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
