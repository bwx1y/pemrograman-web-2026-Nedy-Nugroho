<?php
session_start();

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
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>
<body>

<div class="container">
    <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
    <aside class="sidebar">
        <h2>Goods Office</h2>
        <ul>
            <li><a href="<?php echo $base; ?>index.php">Home</a></li>
            <li><a href="<?php echo $base; ?>item/index.php">List of Items</a></li>
            <li><a href="<?php echo $base; ?>category/index.php">Categories</a></li>
            <li><a href="<?php echo $base; ?>user/index.php">Members</a></li>
        </ul>
    </aside>

    <main class="content">
