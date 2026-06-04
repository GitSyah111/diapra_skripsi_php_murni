<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';

// Fitur CRUD hanya untuk admin dan super admin
if ($role !== 'admin' && $role !== 'super_admin') {
    $_SESSION['error'] = 'Anda tidak memiliki akses untuk melakukan aksi ini.';
    header('Location: daftar-arsip-vital.php');
    exit;
}

// Cek apakah ada request action
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

// Ambil data yang login untuk diinput_oleh
$user_id = $_SESSION['user_id'] ?? 0;

if ($action === 'add') {
    // Ambil data dari form
    $jenis_arsip = mysqli_real_escape_string($conn, $_POST['jenis_arsip']);
    $tingkat_perkembangan = mysqli_real_escape_string($conn, $_POST['tingkat_perkembangan']);
    $kurun_waktu = mysqli_real_escape_string($conn, $_POST['kurun_waktu']);
    $media = mysqli_real_escape_string($conn, $_POST['media']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $jangka_simpan = mysqli_real_escape_string($conn, $_POST['jangka_simpan']);
    $lokasi_simpan = mysqli_real_escape_string($conn, $_POST['lokasi_simpan']);
    $metode_perlindungan = mysqli_real_escape_string($conn, $_POST['metode_perlindungan']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $query = "INSERT INTO daftar_arsip_vital (jenis_arsip, tingkat_perkembangan, kurun_waktu, media, jumlah, jangka_simpan, lokasi_simpan, metode_perlindungan, keterangan, diinput_oleh) 
              VALUES ('$jenis_arsip', '$tingkat_perkembangan', '$kurun_waktu', '$media', '$jumlah', '$jangka_simpan', '$lokasi_simpan', '$metode_perlindungan', '$keterangan', $user_id)";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = 'Data arsip vital berhasil ditambahkan!';
    } else {
        $_SESSION['error'] = 'Gagal menambahkan data: ' . mysqli_error($conn);
    }
    
    header('Location: daftar-arsip-vital.php');
    exit;

} elseif ($action === 'edit') {
    // Ambil data dari form
    $id = (int)$_POST['id'];
    $jenis_arsip = mysqli_real_escape_string($conn, $_POST['jenis_arsip']);
    $tingkat_perkembangan = mysqli_real_escape_string($conn, $_POST['tingkat_perkembangan']);
    $kurun_waktu = mysqli_real_escape_string($conn, $_POST['kurun_waktu']);
    $media = mysqli_real_escape_string($conn, $_POST['media']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $jangka_simpan = mysqli_real_escape_string($conn, $_POST['jangka_simpan']);
    $lokasi_simpan = mysqli_real_escape_string($conn, $_POST['lokasi_simpan']);
    $metode_perlindungan = mysqli_real_escape_string($conn, $_POST['metode_perlindungan']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $query = "UPDATE daftar_arsip_vital SET 
              jenis_arsip = '$jenis_arsip', 
              tingkat_perkembangan = '$tingkat_perkembangan', 
              kurun_waktu = '$kurun_waktu', 
              media = '$media', 
              jumlah = '$jumlah', 
              jangka_simpan = '$jangka_simpan', 
              lokasi_simpan = '$lokasi_simpan', 
              metode_perlindungan = '$metode_perlindungan', 
              keterangan = '$keterangan' 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = 'Data arsip vital berhasil diperbarui!';
    } else {
        $_SESSION['error'] = 'Gagal memperbarui data: ' . mysqli_error($conn);
    }
    
    header('Location: daftar-arsip-vital.php');
    exit;

} elseif ($action === 'delete') {
    // Ambil ID dari GET
    $id = (int)$_GET['id'];
    
    if ($id > 0) {
        $query = "DELETE FROM daftar_arsip_vital WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['status' => 'success', 'message' => 'Data arsip vital berhasil dihapus!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID tidak valid!']);
    }
    exit;
} else {
    // Jika action tidak valid
    $_SESSION['error'] = 'Aksi tidak valid!';
    header('Location: daftar-arsip-vital.php');
    exit;
}
?>
