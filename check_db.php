<?php
session_start();
$_SESSION['tahun_aktif'] = '2025'; // Default year or you can test 2025
require 'database/koneksi.php';

$query = "SHOW COLUMNS FROM surat_keluar LIKE 'jenis_arsip'";
$result = $conn->query($query);
if($result->num_rows == 0) {
    echo "Column jenis_arsip does not exist. Adding it...\n";
    $alter = "ALTER TABLE surat_keluar ADD COLUMN jenis_arsip VARCHAR(100) NULL AFTER nomor_urut";
    if($conn->query($alter)) {
        echo "Column added successfully.\n";
    } else {
        echo "Error adding column: " . $conn->error . "\n";
    }
} else {
    echo "Column jenis_arsip already exists.\n";
}
?>
