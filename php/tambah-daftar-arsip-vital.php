<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';

// Fitur CRUD hanya untuk admin dan super admin
if ($role !== 'admin') {
    header('Location: daftar-arsip-vital.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Daftar Arsip Vital - DPPKBPM</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/kepala-dinas.css">
    <link rel="stylesheet" href="../css/surat-masuk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <div class="hover-trigger"></div>
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <img src="../assets/img/LOGO.png" alt="Logo DPPKBPM" class="logo-img">
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
                    <div class="nav-item-wrapper ">
                        <a href="surat-masuk.php" class="nav-item" title="Surat Masuk" style="flex: 1; border-radius: 8px 0 0 8px; margin: 0;">
                            <i class="fas fa-inbox"></i>
                            <span class="sidebar-text">Surat Masuk</span>
                        </a>
                        <button class="dropdown-toggle" onclick="toggleDropdown(event, 'suratMasukSubmenu')" style="border-radius: 0 8px 8px 0; padding: 0 15px; background: transparent; border: none; color: inherit; cursor: pointer;">
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>
                    <div class="nav-submenu" id="suratMasukSubmenu">
                        <a href="surat-masuk.php?status=sudah" class="nav-item submenu-item" title="Sudah Disposisi">
                            <i class="fas fa-check-circle" style="font-size: 0.9em;"></i>
                            <span class="sidebar-text">Sudah Disposisi</span>
                        </a>
                        <a href="surat-masuk.php?status=belum" class="nav-item submenu-item" title="Belum Disposisi">
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
                <a href="surat-cuti.php" class="nav-item" title="Surat Cuti">
                    <i class="fas fa-calendar-check"></i>
                    <span class="sidebar-text">Surat Cuti</span>
                </a>
                <?php if ($role !== 'user'): ?>
                <a href="berita-acara.php" class="nav-item" title="Berita Acara">
                    <i class="fas fa-file-contract"></i>
                    <span class="sidebar-text">Berita Acara</span>
                </a>
                <?php endif; ?>
                <?php if ($role !== 'user'): ?>
                <a href="daftar-arsip-vital.php" class="nav-item active" title="Daftar Arsip Vital">
                    <i class="fas fa-archive"></i>
                    <span class="sidebar-text">Daftar Arsip Vital</span>
                </a>
                <?php endif; ?>
                <?php if ($role !== 'user'): ?>
                <a href="pernyataan-verifikasi-bmd.php" class="nav-item" title="Pernyataan Verifikasi BMD">
                    <i class="fas fa-file-signature"></i>
                    <span class="sidebar-text">Perny. Verifikasi BMD</span>
                </a>
                <?php endif; ?>
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
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <div class="header-left">
                    <button class="menu-toggle" id="mobileMenuToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="header-menu-btn" id="headerMenuBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="header-title">Tambah Daftar Arsip Vital</h1>
                </div>
                <div class="header-right">
                    <div class="user-info" id="userInfoToggle">
                        <span class="user-name"><?= htmlspecialchars($nama) ?></span>
                        <span class="user-role"><?= ucfirst(htmlspecialchars($role)) ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="user-dropdown" id="userDropdown">
                        <a href="edit-akun.php">
                            <i class="fas fa-user-edit"></i> Edit Akun
                        </a>
                        <a href="logout.php" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content">
                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <a href="dashboard.php">Dashboard</a>
                    <span class="separator">/</span>
                    <a href="daftar-arsip-vital.php">Daftar Arsip Vital</a>
                    <span class="separator">/</span>
                    <span class="current">Tambah</span>
                </div>

                <!-- Form Box -->
                <div class="content-box">
                    <div class="box-header">
                        <h2><i class="fas fa-archive"></i> Form Tambah Daftar Arsip Vital</h2>
                    </div>

                    <div class="form-container">
                        <form id="formArsipVital" method="POST" action="proses-daftar-arsip-vital.php">
                            <input type="hidden" name="action" value="add">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="jenis_arsip">
                                        <i class="fas fa-file"></i> Jenis Arsip <span class="required">*</span>
                                    </label>
                                    <input type="text" id="jenis_arsip" name="jenis_arsip" placeholder="Contoh: Surat Keputusan" required>
                                </div>
                                <div class="form-group">
                                    <label for="tingkat_perkembangan">
                                        <i class="fas fa-layer-group"></i> Tingkat Perkembangan <span class="required">*</span>
                                    </label>
                                    <input type="text" id="tingkat_perkembangan" name="tingkat_perkembangan" placeholder="Contoh: Asli" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="kurun_waktu">
                                        <i class="fas fa-calendar-alt"></i> Kurun Waktu <span class="required">*</span>
                                    </label>
                                    <input type="text" id="kurun_waktu" name="kurun_waktu" placeholder="Contoh: Januari 2025" required>
                                </div>
                                <div class="form-group">
                                    <label for="media">
                                        <i class="fas fa-compact-disc"></i> Media <span class="required">*</span>
                                    </label>
                                    <input type="text" id="media" name="media" placeholder="Contoh: Kertas" required>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="jumlah">
                                        <i class="fas fa-boxes"></i> Jumlah <span class="required">*</span>
                                    </label>
                                    <input type="text" id="jumlah" name="jumlah" placeholder="Contoh: 1 Berkas" required>
                                </div>
                                <div class="form-group">
                                    <label for="jangka_simpan">
                                        <i class="fas fa-clock"></i> Jangka Simpan <span class="required">*</span>
                                    </label>
                                    <input type="text" id="jangka_simpan" name="jangka_simpan" placeholder="Contoh: 5 tahun" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="lokasi_simpan">
                                        <i class="fas fa-map-marker-alt"></i> Lokasi Simpan <span class="required">*</span>
                                    </label>
                                    <input type="text" id="lokasi_simpan" name="lokasi_simpan" placeholder="Contoh: Filling Cabinet" required>
                                </div>
                                <div class="form-group">
                                    <label for="metode_perlindungan">
                                        <i class="fas fa-shield-alt"></i> Metode Perlindungan <span class="required">*</span>
                                    </label>
                                    <input type="text" id="metode_perlindungan" name="metode_perlindungan" placeholder="Contoh: Duplikasi" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="keterangan">
                                    <i class="fas fa-align-left"></i> Keterangan
                                </label>
                                <textarea id="keterangan" name="keterangan" rows="3" placeholder="Masukkan keterangan (opsional)"></textarea>
                            </div>

                            <div class="form-footer">
                                <a href="daftar-arsip-vital.php" class="btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <p>&copy; <?php echo date('Y'); ?> <strong>DPPKBPM</strong></p>
            </footer>
        </main>
    </div>

    <script src="../js/dashboard.js"></script>
    <script>
        document.getElementById('formArsipVital').addEventListener('submit', function(e) {
            const requiredFields = ['jenis_arsip', 'tingkat_perkembangan', 'kurun_waktu', 'media', 'jumlah', 'jangka_simpan', 'lokasi_simpan', 'metode_perlindungan'];
            let isValid = true;
            
            requiredFields.forEach(function(field) {
                if (document.getElementById(field).value.trim() === '') {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Semua field yang bertanda * wajib diisi!');
                return false;
            }
            return true;
        });
    </script>
</body>

</html>

