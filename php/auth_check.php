<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['user_id']) || empty($_SESSION['role'])) {
    $_SESSION['login_error'] = 'Silakan login terlebih dahulu.';
    header('Location: login.php');
    exit;
}
$role = $_SESSION['role'];
$nama = $_SESSION['nama'] ?? '';
$tahun_aktif = $_SESSION['tahun_aktif'] ?? date('Y');

// Restrict 'user' role to only access surat-cuti related pages and account pages
$current_file = basename($_SERVER['PHP_SELF']);
$allowed_for_user = [
    'surat-cuti.php',
    'tambah-surat-cuti.php',
    'edit-surat-cuti.php',
    'detail-surat-cuti.php',
    'proses-surat-cuti.php',
    'edit-akun.php',
    'proses-edit-akun.php',
    'logout.php',
    'pilih_tahun.php',
    'auth_check.php',
    'database.php'
];

if ($role === 'user' && !in_array($current_file, $allowed_for_user)) {
    header('Location: surat-cuti.php');
    exit;
}
