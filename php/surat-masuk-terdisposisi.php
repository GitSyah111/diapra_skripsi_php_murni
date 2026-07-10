<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';
if ($role == 'user') {
    header('Location: dashboard.php');
    exit;
}


// Query untuk mengambil data surat masuk
// Query untuk mengambil data surat masuk
$query = "SELECT surat_masuk.*, user.nama_bidang, user.username,
          (SELECT file_disposisi FROM disposisi WHERE disposisi.id_surat_masuk = surat_masuk.id ORDER BY id DESC LIMIT 1) as file_disposisi_final, (SELECT tujuan_bidang FROM disposisi WHERE disposisi.id_surat_masuk = surat_masuk.id ORDER BY id DESC LIMIT 1) as tujuan_bidang_final 
          FROM surat_masuk 
          LEFT JOIN user ON surat_masuk.id_user = user.no 
          WHERE surat_masuk.status_disposisi = 'Sudah didisposisi'
          ORDER BY surat_masuk.id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk Terdisposisi - DPPKBPM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <!-- Custom CSS (Loaded after libraries to override styles) -->
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/kepala-dinas.css">
    <link rel="stylesheet" href="../css/surat-masuk.css">

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
                    <div class="nav-item-wrapper active-dropdown\">
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
                    <h1 class="header-title">Surat Masuk Terdisposisi</h1>
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
                <div class="action-buttons">
                    <a href="tambah-surat-masuk.php" class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Surat Masuk
                    </a>
                </div>

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
                        <h2><i class="fas fa-check-circle"></i> Daftar Surat Masuk Terdisposisi</h2>
                        <div class="filter-container" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-top:10px;">
                            <div class="filter-group">
                                <label for="filterDari">Dari Tanggal:</label>
                                <input type="date" id="filterDari" class="form-control">
                            </div>
                            <div class="filter-group">
                                <label for="filterSampai">Sampai Tanggal:</label>
                                <input type="date" id="filterSampai" class="form-control">
                            </div>
                            <div class="filter-actions" style="display: flex; gap: 10px; align-items: flex-end;">
                                <button type="button" class="btn-primary" id="btnFilter" style="padding:6px 12px; height: 38px;"><i class="fas fa-filter"></i> Filter</button>
                                <button type="button" class="btn-secondary" id="btnReset" style="padding:6px 12px; height: 38px;"><i class="fas fa-times"></i> Reset</button>
                            </div>
                        </div>
                    </div>

                    <div class="table-container">
                        <table id="suratMasukTable" class="data-table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Agenda</th>
                                    <th>Tanggal Terima</th>
                                    <th>Alamat Pengirim</th>
                                    <th>Tanggal Surat</th>
                                    <th>Nomor Surat</th>
                                    <th>Perihal</th>
                                    <th class="no-export">Diinput Oleh</th>
                                    <th>Tujuan Disposisi</th>
                                    <th class="no-export">Status Disposisi</th>
                                    <th class="no-export">Dapat Dilihat</th>
                                    <th class="no-export">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Status badge
                                        $statusClass = '';
                                        $statusText = '';
                                        if ($row['status_disposisi'] == 'Belum diproses') {
                                            $statusClass = 'badge-warning';
                                            $statusText = 'Belum diproses';
                                        } elseif ($row['status_disposisi'] == 'Sudah didisposisi') {
                                            $statusClass = 'badge-success';
                                            $statusText = 'Sudah didisposisi';
                                        } else {
                                            $statusClass = 'badge-info';
                                            $statusText = $row['status_disposisi'];
                                        }

                                        // Format tanggal
                                        $tgl_terima = date('d/m/Y', strtotime($row['tanggal_terima']));
                                        $tgl_surat = date('d/m/Y', strtotime($row['tanggal_surat']));

                                        // Dilihat oleh
                                        $dilihat = !empty($row['dilihat_oleh']) ? $row['dilihat_oleh'] : '-';

                                        // Diinput oleh
                                        $diinput_oleh = !empty($row['nama_bidang']) ? $row['nama_bidang'] : (!empty($row['username']) ? $row['username'] : '-');
                                ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($row['nomor_agenda']); ?></td>
                                            <td data-date="<?= date('Y-m-d', strtotime($row['tanggal_terima'])) ?>"><?php echo $tgl_terima; ?></td>
                                            <td><?php echo htmlspecialchars($row['alamat_pengirim']); ?></td>
                                            <td><?php echo $tgl_surat; ?></td>
                                            <td><?php echo htmlspecialchars($row['nomor_surat']); ?></td>
                                            <td><?php echo htmlspecialchars($row['perihal']); ?></td>
                                                                                        <td class="no-export"><?php echo htmlspecialchars($diinput_oleh); ?></td>
                                            <td><?php echo !empty($row['tujuan_bidang_final']) ? htmlspecialchars($row['tujuan_bidang_final']) : '-'; ?></td>
                                            <td class="text-center no-export">
                                                <span class="badge <?php echo $statusClass; ?>">
                                                    <?php echo $statusText; ?>
                                                </span>
                                            </td>
                                            <td class="no-export"><?php echo htmlspecialchars($dilihat); ?></td>
                                            <td class="text-center no-export">
                                                <div class="action-buttons-wrapper">
                                                    <?php if (!empty($row['file_surat'])): ?>
                                                        <a href="../uploads/surat_masuk/<?php echo $row['file_surat']; ?>" class="btn-action btn-view" title="Lihat Surat" target="_blank">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <button class="btn-action btn-disabled" title="Belum ada file" disabled>
                                                            <i class="fas fa-file-pdf"></i>
                                                        </button>
                                                    <?php endif; ?>

                                                    <?php if (!empty($row['file_disposisi'])): ?>
                                                        <a href="../uploads/disposisi/<?php echo $row['file_disposisi']; ?>" target="_blank" class="btn-action btn-view-disposisi" title="Lihat File Disposisi">
                                                            <i class="fas fa-file-invoice"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($role == 'admin'): ?>
                                                        <!-- Tombol Preview Disposisi (PDF Generated) -->
                                                        <a href="cetak-disposisi-final.php?id=<?php echo $row['id']; ?>" class="btn-action btn-print-disposisi" title="Preview Disposisi" target="_blank">
                                                            <i class="fas fa-print"></i>
                                                        </a>

                                                        <!-- Tombol Unggah/Edit Disposisi -->
                                                        <a href="disposisi-surat.php?id=<?php echo $row['id']; ?>" class="btn-action btn-disposisi" title="Unggah/Edit Disposisi">
                                                            <i class="fas fa-share-square"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="edit-surat-masuk.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <button class="btn-action btn-delete" onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
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
                <p>&copy; 2025 <strong>DPPKBPM</strong> - Dinas Pengendalian Penduduk dan Keluarga Berencana Pemberdayaan Masyarakat</p>
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
    <script src="../js/surat-masuk.js"></script>
</body>

</html>
