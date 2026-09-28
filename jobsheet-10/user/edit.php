<?php
global $pdo;
$page_title = "Edit Member";
require __DIR__ . '/../includes/koneksi.php';
include __DIR__ . '/../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM "user" WHERE id = :id');
$stmt->execute(['id' => $id]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$u) {
    header('Location: index.php');
    exit;
}

$birthDateVal = '';
if (!empty($u['birth_date'])) {
    $ts = strtotime($u['birth_date']);
    $birthDateVal = $ts ? date('Y-m-d', $ts) : $u['birth_date'];
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Edit Member</h1>
<br/>
<div class="form-container">
    <h2>Edit Member Data</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="POST" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($u['id']); ?>">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($u['username'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($u['name'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="" disabled>Pilih role</option>
                <option value="Admin" <?php echo ($u['role'] ?? '') === 'Admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="Staff" <?php echo ($u['role'] ?? '') === 'Staff' ? 'selected' : ''; ?>>Staff</option>
                <option value="Member" <?php echo ($u['role'] ?? '') === 'Member' ? 'selected' : ''; ?>>Member</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo htmlspecialchars($birthDateVal); ?>" required>
        </div>

        <div class="form-group">
            <label for="nomor_hp">Nomor HP</label>
            <input type="tel" id="nomor_hp" name="nomor_hp" value="<?php echo htmlspecialchars($u['phone'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Changes</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
