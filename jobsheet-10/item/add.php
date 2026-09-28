<?php
global $pdo;
$page_title = "Add Item";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$categories = $pdo->query("SELECT * FROM category ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Add Item</h1>
<br/>
<div class="form-container">
    <h2>Add Item Data</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="POST" action="proses_tambah.php">

        <div class="form-group">
            <label for="kode">Item Code</label>
            <input type="text" id="kode" name="kode" placeholder="e.g. ELK-003" required>
        </div>

        <div class="form-group">
            <label for="nama">Item Name</label>
            <input type="text" id="nama" name="nama" placeholder="Enter item name" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori</label>
            <select id="kategori" name="kategori" required>
                <option value="" disabled selected>-- Select Category --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo htmlspecialchars($cat['id']); ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah">Item Quantity (Count)</label>
            <input type="number" id="jumlah" name="jumlah" min="0" placeholder="0" pattern="^[0-9]+$" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
        </div>

        <div class="form-group">
            <label for="harga">Purchase Price</label>
            <div class="input-group">
                <span class="input-addon">Rp</span>
                <input type="text" id="harga" name="harga" placeholder="0" pattern="^[0-9]+$" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="" disabled selected>-- Select Status --</option>
                <option value="Good">Good</option>
                <option value="Damaged">Damaged</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Data</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>

    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
