<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita Acara - DPPKBPM</title>
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
                <a href="surat-cuti.php" class="nav-item" title="Surat Cuti">
                    <i class="fas fa-calendar-check"></i>
                    <span class="sidebar-text">Surat Cuti</span>
                </a>
                <?php if ($role !== 'user'): ?>
                <a href="berita-acara.php" class="nav-item active" title="Berita Acara">
                    <i class="fas fa-file-contract"></i>
                    <span class="sidebar-text">Berita Acara</span>
                </a>
                <?php endif; ?>
                <?php if ($role !== 'user'): ?>
                <a href="daftar-arsip-vital.php" class="nav-item" title="Daftar Arsip Vital">
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
                <div style="margin-top: 10px; font-size: 0.8rem; color: #a1a1aa;">
                    Data Tahun: <strong><?= htmlspecialchars($tahun_aktif) ?></strong>
                    <br>
                    <a href="pilih_tahun.php" style="color: #60a5fa; text-decoration: none;">(Ganti Tahun)</a>
                </div>
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
                    <h1 class="header-title">Tambah Berita Acara</h1>
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
                    <a href="berita-acara.php">Berita Acara</a>
                    <span class="separator">/</span>
                    <span class="current">Tambah Berita Acara</span>
                </div>

                <!-- Form Box -->
                <div class="content-box">
                    <div class="box-header">
                        <h2><i class="fas fa-file-contract"></i> Form Tambah Berita Acara</h2>
                    </div>

                    <div class="form-container">
                        <form id="formBeritaAcara" method="POST" action="proses-berita-acara.php">
                            <input type="hidden" name="action" value="add">

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="no_agenda">
                                        <i class="fas fa-hashtag"></i> No Agenda
                                    </label>
                                    <input type="text" id="no_agenda" name="no_agenda" placeholder="Masukkan No Agenda">
                                </div>
                                <div class="form-group">
                                    <label for="no_berita_acara">
                                        <i class="fas fa-file-invoice"></i> No Berita Acara
                                    </label>
                                    <input type="text" id="no_berita_acara" name="no_berita_acara" placeholder="Masukkan No Berita Acara">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="tanggal">
                                        <i class="fas fa-calendar-check"></i> Tanggal Berita Acara (Tgl BA) <span class="required">*</span>
                                    </label>
                                    <input type="date" id="tanggal" name="tanggal" required>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_serah_terima">
                                        <i class="fas fa-calendar-alt"></i> Tanggal Serah Terima <span class="required">*</span>
                                    </label>
                                    <input type="date" id="tanggal_serah_terima" name="tanggal_serah_terima" required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="nama_perusahaan">
                                    <i class="fas fa-building"></i> Nama Penyedia <span class="required">*</span>
                                </label>
                                <input type="text" id="nama_perusahaan" name="nama_perusahaan"
                                    placeholder="Masukkan nama penyedia" required>
                            </div>

                            <div class="form-group">
                                <label for="uraian">
                                    <i class="fas fa-align-left"></i> Uraian <span class="required">*</span>
                                </label>
                                <textarea id="uraian" name="uraian" rows="4"
                                    placeholder="Masukkan uraian" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="nilai_pengadaan">
                                    <i class="fas fa-money-bill-wave"></i> Nilai Pengadaan
                                </label>
                                <input type="text" id="nilai_pengadaan" name="nilai_pengadaan"
                                    placeholder="Masukkan nilai pengadaan">
                            </div>

                            <div class="form-footer">
                                <a href="berita-acara.php" class="btn-secondary">
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
                <p>&copy; 2025 <strong>DPPKBPM</strong> - Dinas Pengendalian Penduduk dan Keluarga Berencana Pemberdayaan Masyarakat</p>
            </footer>
        </main>
    </div>

    <script src="../js/dashboard.js"></script>
    <script>
        // Set tanggal hari ini sebagai default
        document.getElementById('tanggal').valueAsDate = new Date();
        document.getElementById('tanggal_serah_terima').valueAsDate = new Date();

        // Form validation
        document.getElementById('formBeritaAcara').addEventListener('submit', function(e) {
            const nama_perusahaan = document.getElementById('nama_perusahaan').value.trim();
            const uraian = document.getElementById('uraian').value.trim();

            if (nama_perusahaan === '' || uraian === '') {
                e.preventDefault();
                alert('Semua field yang bertanda * wajib diisi!');
                return false;
            }

            return true;
        });
    </script>
</body>

</html>
