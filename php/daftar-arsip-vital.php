<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';

// Tentukan role yang bisa CRUD
$can_crud = ($role === 'admin');

// Query untuk mengambil data daftar arsip vital
$query = "SELECT daftar_arsip_vital.*, user.nama, user.username
          FROM daftar_arsip_vital 
          LEFT JOIN user ON daftar_arsip_vital.diinput_oleh = user.no 
          ORDER BY daftar_arsip_vital.id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Arsip Vital - DPPKBPM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/kepala-dinas.css">
    <link rel="stylesheet" href="../css/surat-masuk.css?v=<?php echo time(); ?>">
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
                    <div class="nav-item-wrapper">
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
                    <h1 class="header-title">Daftar Arsip Vital</h1>
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
                        <button class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="content">
                <!-- Action Buttons -->
                <?php if ($can_crud): ?>
                <div class="action-buttons">
                    <a href="tambah-daftar-arsip-vital.php" class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Data
                    </a>
                </div>
                <?php endif; ?>

                <!-- SweetAlert Logic for Session Messages -->
                <?php if (isset($_SESSION['success'])): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: '<?php echo $_SESSION['success']; ?>',
                                icon: 'success',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        });
                    </script>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Gagal!',
                                text: '<?php echo $_SESSION['error']; ?>',
                                icon: 'error',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'OK'
                            });
                        });
                    </script>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Data Table -->
                <div class="content-box">
                    <div class="box-header">
                        <h2><i class="fas fa-archive"></i> Daftar Arsip Vital</h2>
                    </div>

                    <div class="table-container">
                        <table id="arsipVitalTable" class="data-table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="no-export text-center">No</th>
                                    <th>Jenis Arsip</th>
                                    <th>Tingkat Perkembangan</th>
                                    <th>Kurun Waktu</th>
                                    <th>Media</th>
                                    <th>Jumlah</th>
                                    <th>Jangka Simpan</th>
                                    <th>Lokasi Simpan</th>
                                    <th>Metode Perlindungan</th>
                                    <th>Ket</th>
                                    <?php if ($can_crud): ?>
                                    <th class="no-export">Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                        <tr>
                                            <td class="text-center no-export"></td>
                                            <td><?php echo htmlspecialchars($row['jenis_arsip']); ?></td>
                                            <td><?php echo htmlspecialchars($row['tingkat_perkembangan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['kurun_waktu']); ?></td>
                                            <td><?php echo htmlspecialchars($row['media']); ?></td>
                                            <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                                            <td><?php echo htmlspecialchars($row['jangka_simpan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['lokasi_simpan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['metode_perlindungan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
                                            <?php if ($can_crud): ?>
                                            <td class="text-center no-export">
                                                <div class="action-buttons-wrapper">
                                                    <a href="edit-daftar-arsip-vital.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn-action btn-delete" onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <p>&copy; <?php echo date('Y'); ?> <strong>DPPKBPM</strong> - Dinas Pengendalian Penduduk dan Keluarga Berencana Pemberdayaan Masyarakat</p>
            </footer>
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/dashboard.js"></script>
    <script src="../js/logo-base64.js"></script>
    <script src="../js/daftar-arsip-vital.js"></script>
</body>

</html>
