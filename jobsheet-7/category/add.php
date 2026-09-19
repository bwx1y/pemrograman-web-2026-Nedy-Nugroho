<?php
$page_title = "Add Category";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Add Category</h1>
<br/>
<div class="form-container">
    <h2>Add Category Data</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="POST" action="proses_tambah.php">

        <div class="form-group">
            <label for="nama_kategori">Category Name</label>
            <input type="text" id="nama_kategori" name="nama_kategori" placeholder="Enter category name" required>
        </div>

        <div class="form-group">
            <label for="keterangan">Description</label>
            <input type="text" id="keterangan" name="keterangan" placeholder="Enter category description" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Data</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>

    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
