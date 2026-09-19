<?php
$page_title = "Add Item";
include __DIR__ . '/../includes/header.php';

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
                <option value="Electronic Components">Electronic Components</option>
                <option value="IT Devices">IT Devices</option>
                <option value="Office Supplies">Office Supplies</option>
                <option value="Furniture">Furniture</option>
            </select>
        </div>

        <div class="form-group">
            <label for="jumlah">Item Quantity (Count)</label>
            <input type="number" id="jumlah" name="jumlah" min="0" placeholder="0" required>
        </div>

        <div class="form-group">
            <label for="harga">Purchase Price</label>
            <input type="text" id="harga" name="harga" placeholder="Rp 0" required>
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
