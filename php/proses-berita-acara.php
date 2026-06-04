<?php
session_start();
require_once 'database.php';
require_once 'auth_check.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        // Tentukan ID user yang login
        $id_user = $_SESSION['user_id'];

        if ($_POST['action'] == 'add') {
            $tanggal              = mysqli_real_escape_string($conn, $_POST['tanggal']);
            $nama_perusahaan      = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
            $tanggal_serah_terima = mysqli_real_escape_string($conn, $_POST['tanggal_serah_terima']);
            $uraian               = mysqli_real_escape_string($conn, $_POST['uraian']);
            $no_agenda            = mysqli_real_escape_string($conn, $_POST['no_agenda']);
            $no_berita_acara      = mysqli_real_escape_string($conn, $_POST['no_berita_acara']);
            $nilai_pengadaan      = mysqli_real_escape_string($conn, $_POST['nilai_pengadaan']);
            
            $query = "INSERT INTO berita_acara (no_agenda, no_berita_acara, tanggal, nama_perusahaan, tanggal_serah_terima, uraian, nilai_pengadaan, diinput_oleh) 
                      VALUES ('$no_agenda', '$no_berita_acara', '$tanggal', '$nama_perusahaan', '$tanggal_serah_terima', '$uraian', '$nilai_pengadaan', '$id_user')";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Berita Acara berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan Berita Acara: " . mysqli_error($conn);
            }
            
            header("Location: berita-acara.php");
            exit();
        } 
        elseif ($_POST['action'] == 'edit') {
            $id                   = mysqli_real_escape_string($conn, $_POST['id']);
            $tanggal              = mysqli_real_escape_string($conn, $_POST['tanggal']);
            $nama_perusahaan      = mysqli_real_escape_string($conn, $_POST['nama_perusahaan']);
            $tanggal_serah_terima = mysqli_real_escape_string($conn, $_POST['tanggal_serah_terima']);
            $uraian               = mysqli_real_escape_string($conn, $_POST['uraian']);
            $no_agenda            = mysqli_real_escape_string($conn, $_POST['no_agenda']);
            $no_berita_acara      = mysqli_real_escape_string($conn, $_POST['no_berita_acara']);
            $nilai_pengadaan      = mysqli_real_escape_string($conn, $_POST['nilai_pengadaan']);

            $query = "UPDATE berita_acara 
                      SET no_agenda = '$no_agenda',
                          no_berita_acara = '$no_berita_acara',
                          tanggal = '$tanggal', 
                          nama_perusahaan = '$nama_perusahaan', 
                          tanggal_serah_terima = '$tanggal_serah_terima', 
                          uraian = '$uraian',
                          nilai_pengadaan = '$nilai_pengadaan'
                      WHERE id = '$id'";

            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Berita Acara berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Gagal memperbarui Berita Acara: " . mysqli_error($conn);
            }
            header("Location: berita-acara.php");
            exit();
        } 
        elseif ($_POST['action'] == 'delete') {
            // Action delete bisa dikirim via POST fetch atau AJAX (tergantung implementasi JS)
            // Di sini kita siap handle method form POST atau direct PHP post
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            
            $query = "DELETE FROM berita_acara WHERE id = '$id'";
            if (mysqli_query($conn, $query)) {
                $_SESSION['success'] = "Berita Acara berhasil dihapus!";
                echo json_encode(['status' => 'success']);
            } else {
                $_SESSION['error'] = "Gagal menghapus Berita Acara: " . mysqli_error($conn);
                echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
            }
            exit();
        }
    }
}
// Delete handler jika dikirim lewat AJAX GET... tapi idealnya POST.
// Mengacu ke template lain, bisanya confirmDelete mengirim POST fetch.
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM berita_acara WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        $_SESSION['success'] = "Berita Acara berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus Berita Acara: " . mysqli_error($conn);
    }
    
    header("Location: berita-acara.php");
    exit();
}
?>
