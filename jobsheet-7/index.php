<?php
$page_title = "Inventory Dashboard";
include __DIR__ . '/includes/header.php';

$items = $_SESSION['item'] ?? [];
$users = $_SESSION['user'] ?? [];

$totalItems = count($items);
$totalMembers = count($users);

$totalAssetValue = 0;
$damagedCount = 0;
foreach ($items as $item) {
    $price = (int) preg_replace('/[^0-9]/', '', $item['harga'] ?? '0');
    $qty = (int) ($item['jumlah'] ?? 0);
    $totalAssetValue += ($price * $qty);
    if (($item['status'] ?? '') === 'Damaged') {
        $damagedCount++;
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
        <p class="desc">Total value of all items</p>
    </div>

    <div class="card rusak">
        <h3>Total Damaged Items</h3>
        <div class="value"><?php echo $damagedCount; ?></div>
        <p class="desc">Items with damaged status</p>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
