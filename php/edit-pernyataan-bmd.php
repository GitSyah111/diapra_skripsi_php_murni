<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';

// Cek ID 
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = 'ID Pernyataan tidak ditemukan';
    header('Location: pernyataan-verifikasi-bmd.php');
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM pernyataan_verifikasi_bmd WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    $_SESSION['error'] = 'Data tidak ditemukan';
    header('Location: pernyataan-verifikasi-bmd.php');
    exit;
}

$data = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pernyataan Verifikasi BMD - DPPKBPM</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/kepala-dinas.css">
    <link rel="stylesheet" href="../css/surat-masuk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar disingkat sementara -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="../assets/img/LOGO.png" alt="Logo Pemko" class="logo-img">
                </div>
                <h2 class="sidebar-text">DIAPRA DPPKBPM</h2>
            </div>

            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item" title="Dashboard">
                    <i class="fas fa-home"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                                <?php if ($role !== 'user'): ?>
                <div class="nav-item-dropdown-container">
                    <div class="nav-item-wrapper \">
                        <a href="surat-masuk.php" class="nav-item" title="Surat Masuk" style="flex: 1; border-radius: 8px 0 0 8px; margin: 0;">
                            <i class="fas fa-inbox"></i>
                            <span class="sidebar-text">Surat Masuk</span>
                        </a>
                        <button class="dropdown-toggle" onclick="toggleDropdown(event, 'suratMasukSubmenu')" style="border-radius: 0 8px 8px 0; padding: 0 15px; background: transparent; border: none; color: inherit; cursor: pointer;">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="nav-submenu" id="suratMasukSubmenu">
                        <a href="surat-masuk-terdisposisi.php" class="nav-item submenu-item" title="Sudah Disposisi">
                            <i class="fas fa-check-circle" style="font-size: 0.9em;"></i>
                            <span class="sidebar-text">Sudah Disposisi</span>
                        </a>
                        <a href="surat-masuk-belum-disposisi.php" class="nav-item submenu-item" title="Belum Disposisi">
                            <i class="fas fa-clock" style="font-size: 0.9em;"></i>
                            <span class="sidebar-text">Belum Disposisi</span>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                <a href="surat-keluar.php" class="nav-item" title="Surat Keluar">
                    <i class="fas fa-paper-plane"></i>
                    <span class="sidebar-text">Surat Keluar</span>
                </a>

                <?php if ($role !== 'user' && $role !== 'bidang'): ?>
                <a href="spj-umpeg.php" class="nav-item" title="SPJ UMPEG">
                    <i class="fas fa-file-invoice"></i>
                    <span class="sidebar-text">SPJ UMPEG</span>
                </a>
                <?php endif; ?>
                <?php if ($role !== 'user'): ?>
                <a href="surat-cuti.php" class="nav-item" title="Surat Cuti">
                    <i class="fas fa-calendar-check"></i>
                    <span class="sidebar-text">Surat Cuti</span>
                </a>
                <?php endif; ?>
                <a href="berita-acara.php" class="nav-item" title="Berita Acara">
                    <i class="fas fa-file-contract"></i>
                    <span class="sidebar-text">Berita Acara</span>
                </a>
                <a href="daftar-arsip-vital.php" class="nav-item" title="Daftar Arsip Vital">
                    <i class="fas fa-archive"></i>
                    <span class="sidebar-text">Daftar Arsip Vital</span>
                </a>
                <a href="pernyataan-verifikasi-bmd.php" class="nav-item active" title="Pernyataan Verifikasi BMD">
                    <i class="fas fa-file-signature"></i>
                    <span class="sidebar-text">Perny. Verifikasi BMD</span>
                </a>
                <?php if ($role !== 'user' && $role !== 'bidang'): ?>
                <a href="data-pengguna.php" class="nav-item" title="Data Pengguna">
                    <i class="fas fa-users"></i>
                    <span class="sidebar-text">Data Pengguna</span>
                </a>
                <a href="data-kepala-dinas.php" class="nav-item" title="Data Kepala Dinas">
                    <i class="fas fa-user-tie"></i>
                    <span class="sidebar-text">Data Kepala Dinas</span>
                </a>
                <?php endif; ?>
            </nav>

            <div class="sidebar-footer sidebar-text">
                <p><i class="fas fa-info-circle"></i> Versi 1.0.0</p>
                <!-- Indikator Tahun Aktif -->
                <div style="margin-top: 10px; font-size: 0.8rem; color: #a1a1aa;">
                    Data Tahun: <strong><?= htmlspecialchars($tahun_aktif) ?></strong>
                    <br>
                    <a href="pilih_tahun.php" style="color: #60a5fa; text-decoration: none;">(Ganti Tahun)</a>
                </div>
            </div>


        </aside>

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <h1 class="header-title">Edit Pernyataan Verifikasi BMD</h1>
                </div>
            </header>

            <div class="content">
                <div class="breadcrumb">
                    <a href="dashboard.php">Dashboard</a> <span class="separator">/</span>
                    <a href="pernyataan-verifikasi-bmd.php">Pernyataan Verifikasi BMD</a> <span class="separator">/</span>
                    <span class="current">Edit Data</span>
                </div>

                <div class="content-box">
                    <div class="form-container">
                        <form id="formPernyataan" method="POST" action="proses-pernyataan-bmd.php">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= $id ?>">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="no_surat_pernyataan"><i class="fas fa-hashtag"></i> No Surat Pernyataan</label>
                                    <input type="text" id="no_surat_pernyataan" name="no_surat_pernyataan" value="<?= htmlspecialchars($data['no_surat_pernyataan'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="tgl"><i class="fas fa-calendar"></i> Tanggal</label>
                                    <input type="date" id="tgl" name="tgl" value="<?= htmlspecialchars($data['tgl'] ?? '') ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="no_pesanan_kontrak"><i class="fas fa-file-contract"></i> No Pesanan/Kontrak</label>
                                    <input type="text" id="no_pesanan_kontrak" name="no_pesanan_kontrak" value="<?= htmlspecialchars($data['no_pesanan_kontrak'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_pesan_kontrak"><i class="fas fa-calendar-alt"></i> Tgl Pesan/Kontrak</label>
                                    <input type="date" id="tgl_pesan_kontrak" name="tgl_pesan_kontrak" value="<?= htmlspecialchars($data['tgl_pesan_kontrak'] ?? '') ?>">
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nilai_pesanan_kontrak"><i class="fas fa-money-bill"></i> Nilai Pesan/Kontrak</label>
                                    <input type="text" id="nilai_pesanan_kontrak" name="nilai_pesanan_kontrak" value="<?= htmlspecialchars($data['nilai_pesanan_kontrak'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="nama_perusahaan"><i class="fas fa-building"></i> Nama Perusahaan</label>
                                    <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan'] ?? '') ?>" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="no_bast"><i class="fas fa-check-double"></i> No BAST</label>
                                    <input type="text" id="no_bast" name="no_bast" value="<?= htmlspecialchars($data['no_bast'] ?? '') ?>">
                                </div>
                                <div class="form-group">
                                    <label for="tgl_bast"><i class="fas fa-calendar-check"></i> Tgl BAST</label>
                                    <input type="date" id="tgl_bast" name="tgl_bast" value="<?= htmlspecialchars($data['tgl_bast'] ?? '') ?>">
                                </div>
                            </div>

                            <div class="form-footer">
                                <a href="pernyataan-verifikasi-bmd.php" class="btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
