<?php
global $pdo;
$page_title = "Inventory Dashboard";
require __DIR__ . '/includes/koneksi.php';
include __DIR__ . '/includes/header.php';

$totalItems = (int) $pdo->query("SELECT COUNT(*) FROM item")->fetchColumn();
$totalMembers = (int) $pdo->query('SELECT COUNT(*) FROM "user"')->fetchColumn();
$damagedCount = (int) $pdo->query("SELECT COUNT(*) FROM item WHERE status = 'Damaged'")->fetchColumn();

$totalAssetValue = 0;
$totalDamagedValue = 0;
$stmt = $pdo->query("SELECT price, count, status FROM item");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $price = (int) preg_replace('/[^0-9]/', '', $row['price'] ?? '0');
    $qty = (int) ($row['count'] ?? 0);
    $itemTotal = ($price * $qty);
    $status = strtolower(trim($row['status'] ?? ''));
    if ($status === 'good') {
        $totalAssetValue += $itemTotal;
    } elseif ($status === 'damaged') {
        $totalDamagedValue += $itemTotal;
    }
}
?>

<h1>Inventory Dashboard</h1>
<p>Welcome to the inventory management information system.</p>
<br>

<div class="dashboard-cards">

    <div class="card barang">
        <h3>Total Items</h3>
        <div class="value"><?php echo $totalItems; ?></div>
        <p class="desc">Total recorded items</p>
    </div>

    <div class="card pengguna">
        <h3>Total Members</h3>
        <div class="value"><?php echo $totalMembers; ?></div>
        <p class="desc">Registered members</p>
    </div>

    <div class="card barang">
        <h3>Total Asset Value</h3>
        <div class="value">Rp <?php echo number_format($totalAssetValue, 0, ',', '.'); ?></div>
        <p class="desc">Total value of items in good condition</p>
    </div>

    <div class="card rusak">
        <h3>Total Damaged Items</h3>
        <div class="value"><?php echo $damagedCount; ?></div>
        <p class="desc">Items with damaged status</p>
    </div>

    <div class="card rusak">
        <h3>Total Damaged Value</h3>
        <div class="value">Rp <?php echo number_format($totalDamagedValue, 0, ',', '.'); ?></div>
        <p class="desc">Total value of damaged items</p>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
