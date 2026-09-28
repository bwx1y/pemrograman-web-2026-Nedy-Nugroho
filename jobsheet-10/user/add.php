<?php
$page_title = "Add Member";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<h1>Add Member</h1>
<br/>
<div class="form-container">
    <h2>Add Member Data</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['pesan']); ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="POST" action="proses_tambah.php">

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="Enter full name" required>
        </div>

        <div class="form-group">
            <label for="role">Role</label>
            <select id="role" name="role" required>
                <option value="" disabled selected>Pilih role</option>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
                <option value="Member">Member</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal_lahir">Tanggal Lahir</label>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
        </div>

        <div class="form-group">
            <label for="nomor_hp">Nomor HP</label>
            <input type="tel" id="nomor_hp" name="nomor_hp" placeholder="Masukkan nomor HP" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-save">Save Data</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>

    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
