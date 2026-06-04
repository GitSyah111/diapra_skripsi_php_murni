<?php
session_start();
require_once 'database.php';
require_once 'auth_check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $id_user = $_SESSION['user_id'];

        if ($_POST['action'] == 'add') {
            $no_surat_pernyataan   = mysqli_real_escape_string($conn, $_POST['no_surat_pernyataan']);
            $tgl                   = mysqli_real_escape_string($conn, $_POST['tgl']);
            $no_pesanan_kontrak    = mysqli_real_escape_string($conn, $_POST['no_pesanan_kontrak']);
            $tgl_pesan_kontrak     = mysqli_real_escape_string($conn, $_POST['tgl_pesan_kontrak']);
            $nilai_pesanan_kontrak = mysqli_real_escape_string($conn, $_POST['nilai_pesanan_kontrak']);
            $nama_perusahaan       = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
            $no_bast               = mysqli_real_escape_string($conn, $_POST['no_bast']);
            $tgl_bast              = mysqli_real_escape_string($conn, $_POST['tgl_bast']);
            
            $query = "INSERT INTO pernyataan_verifikasi_bmd (no_surat_pernyataan, tgl, no_pesanan_kontrak, tgl_pesan_kontrak, nilai_pesanan_kontrak, nama_perusahaan, no_bast, tgl_bast, diinput_oleh) 
                      VALUES ('$no_surat_pernyataan', '$tgl', '$no_pesanan_kontrak', '$tgl_pesan_kontrak', '$nilai_pesanan_kontrak', '$nama_perusahaan', '$no_bast', '$tgl_bast', '$id_user')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Pernyataan berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan data: " . mysqli_error($conn);
            }
            
            header("Location: pernyataan-verifikasi-bmd.php");
            exit();
        } 
        elseif ($_POST['action'] == 'edit') {
            $id                    = mysqli_real_escape_string($conn, $_POST['id']);
            $no_surat_pernyataan   = mysqli_real_escape_string($conn, $_POST['no_surat_pernyataan']);
            $tgl                   = mysqli_real_escape_string($conn, $_POST['tgl']);
            $no_pesanan_kontrak    = mysqli_real_escape_string($conn, $_POST['no_pesanan_kontrak']);
            $tgl_pesan_kontrak     = mysqli_real_escape_string($conn, $_POST['tgl_pesan_kontrak']);
            $nilai_pesanan_kontrak = mysqli_real_escape_string($conn, $_POST['nilai_pesanan_kontrak']);
            $nama_perusahaan       = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
            $no_bast               = mysqli_real_escape_string($conn, $_POST['no_bast']);
            $tgl_bast              = mysqli_real_escape_string($conn, $_POST['tgl_bast']);

            $query = "UPDATE pernyataan_verifikasi_bmd 
                      SET no_surat_pernyataan = '$no_surat_pernyataan',
                          tgl = '$tgl', 
                          no_pesanan_kontrak = '$no_pesanan_kontrak', 
                          tgl_pesan_kontrak = '$tgl_pesan_kontrak', 
                          nilai_pesanan_kontrak = '$nilai_pesanan_kontrak',
                          nama_perusahaan = '$nama_perusahaan',
                          no_bast = '$no_bast',
                          tgl_bast = '$tgl_bast'
                      WHERE id = '$id'";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Pernyataan berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Gagal memperbarui data: " . mysqli_error($conn);
            }
            header("Location: pernyataan-verifikasi-bmd.php");
            exit();
        } 
        elseif ($_POST['action'] == 'delete') {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            
            $query = "DELETE FROM pernyataan_verifikasi_bmd WHERE id = '$id'";
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Pernyataan berhasil dihapus!";
                echo json_encode(['status' => 'success']);
            } else {
                $_SESSION['error'] = "Gagal menghapus data: " . mysqli_error($conn);
                echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
            }
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM pernyataan_verifikasi_bmd WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Pernyataan berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus data: " . mysqli_error($conn);
    }
    
    header("Location: pernyataan-verifikasi-bmd.php");
    exit();
}
?>
