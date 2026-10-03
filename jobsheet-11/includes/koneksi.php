<?php
$host = "localhost";
$port = "5432";
$db   = "pemerogaman_web_db";
$user = "postgres";
$pass = "nedy_888";

$remote_host = "ep-crimson-frost-b5zx97xe-pooler.c-7.us-east-2.aws.neon.tech";
$remote_port = "5432";
$remote_db   = "neondb";
$remote_user = "neondb_owner";
$remote_pass = "npg_RmIoi1NQth4A";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e_local) {
    try {

        $dsn_remote = "pgsql:host=$remote_host;port=$remote_port;dbname=$remote_db;sslmode=require";
        $pdo = new PDO($dsn_remote, $remote_user, $remote_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e_remote) {
        die("Semua koneksi database gagal!<br>" .
            "Error Lokal: " . $e_local->getMessage() . "<br>" .
            "Error Remote: " . $e_remote->getMessage());
    }
}
