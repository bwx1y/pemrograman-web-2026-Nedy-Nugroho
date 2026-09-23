<?php
global $pdo;
$page_title = "Edit Item";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM item WHERE id = :id");
$stmt->execute(['id' => $id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    header('Location: index.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM category ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Edit Item</h1>
<br/>
<div class="form-container">
    <h2>Edit Item Data</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="POST" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">

        <div class="form-group">
            <label for="kode">Item Code</label>
            <input type="text" id="kode" name="kode" value="<?php echo htmlspecialchars($item['code'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="nama">Item Name</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($item['name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="" disabled>-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat['id']); ?>" <?php echo ((string)$cat['id'] === (string)($item['category_id'] ?? '') || $cat['name'] === ($item['category'] ?? '')) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah">Item Quantity (Count)</label>
            <input type="number" id="jumlah" name="jumlah" min="0" value="<?php echo htmlspecialchars($item['count'] ?? 0); ?>" required>
        </div>

        <div class="form-group">
            <label for="harga">Purchase Price</label>
            <input type="text" id="harga" name="harga" value="<?php echo htmlspecialchars($item['price'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="" disabled>-- Select Status --</option>
                <option value="Good" <?php echo ($item['status'] ?? '') === 'Good' ? 'selected' : ''; ?>>Good</option>
                <option value="Damaged" <?php echo ($item['status'] ?? '') === 'Damaged' ? 'selected' : ''; ?>>Damaged</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
