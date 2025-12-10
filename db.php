<?php
// db.php - sambungan ke MySQL
require_once 'config.php';
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    die("Gagal sambung ke database: " . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');
?>