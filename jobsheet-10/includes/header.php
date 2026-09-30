<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goods Office<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<div class="container">
    <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
    <aside class="sidebar">
        <h2>Goods Office</h2>
        <ul>
            <li><a href="/index.php">Home</a></li>
            <li><a href="/item/index.php">List of Items</a></li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                <li><a href="/category/index.php">Categories</a></li>
                <li><a href="/user/index.php">Members</a></li>
            <?php endif; ?>
        </ul>

        <div class="sidebar-footer">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-info">
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></span>
                    <span class="user-role"><?php echo htmlspecialchars($_SESSION['role'] ?? ''); ?></span>
                </div>
                <a href="/auth/logout.php" class="btn-logout">Logout</a>
            <?php else: ?>
                <a href="/auth/login.php" class="btn-login-sidebar">Login</a>
            <?php endif; ?>
        </div>
    </aside>

    <main class="content">
