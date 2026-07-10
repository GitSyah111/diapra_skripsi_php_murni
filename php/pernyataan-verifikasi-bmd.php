<?php
// Koneksi database
include 'database.php';
require_once 'auth_check.php';

// Query untuk mengambil data pernyataan verifikasi bmd
$query = "SELECT pernyataan_verifikasi_bmd.*, user.nama, user.username
          FROM pernyataan_verifikasi_bmd 
          LEFT JOIN user ON pernyataan_verifikasi_bmd.diinput_oleh = user.no 
          ORDER BY pernyataan_verifikasi_bmd.id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pernyataan Verifikasi BMD - DPPKBPM</title>
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
                    <h1 class="header-title">Pernyataan Verifikasi BMD</h1>
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
                    <a href="tambah-pernyataan-bmd.php" class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Tambah Pernyataan
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
                        <h2><i class="fas fa-file-signature"></i> Daftar Pernyataan Verifikasi BMD</h2>
                    </div>

                    <div class="table-container">
                        <table id="pernyataanTable" class="data-table display nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="no-export">#</th>
                                    <th>No</th>
                                    <th>No Surat Pernyataan</th>
                                    <th>Tanggal</th>
                                    <th>No Pesanan/Kontrak</th>
                                    <th>Tgl Pesan/Kontrak</th>
                                    <th>Nilai Pesan/Kontrak</th>
                                    <th>Nama Perusahaan</th>
                                    <th>No BAST</th>
                                    <th>Tgl BAST</th>
                                    <th class="no-export">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        // Indonesian month names
                                        $bulan = array (
                                            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                        );
                                        
                                        $tgl_indo = '-';
                                        if (!empty($row['tgl'])) {
                                            $tgl_arr = explode('-', $row['tgl']);
                                            $tgl_indo = $tgl_arr[2] . ' ' . $bulan[(int)$tgl_arr[1]] . ' ' . $tgl_arr[0];
                                        }

                                        $tgl_pesan_indo = '-';
                                        if (!empty($row['tgl_pesan_kontrak'])) {
                                            $tst_arr = explode('-', $row['tgl_pesan_kontrak']);
                                            $tgl_pesan_indo = $tst_arr[2] . ' ' . $bulan[(int)$tst_arr[1]] . ' ' . $tst_arr[0];
                                        }
                                        
                                        $tgl_bast_indo = '-';
                                        if (!empty($row['tgl_bast'])) {
                                            $tb_arr = explode('-', $row['tgl_bast']);
                                            $tgl_bast_indo = $tb_arr[2] . ' ' . $bulan[(int)$tb_arr[1]] . ' ' . $tb_arr[0];
                                        }

                                ?>
                                        <tr>
                                            <td class="text-center no-export"></td>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['no_surat_pernyataan'] ?? '-'); ?></td>
                                            <td data-sort="<?=$row['tgl']?>"><?php echo htmlspecialchars($tgl_indo); ?></td>
                                            <td><?php echo htmlspecialchars($row['no_pesanan_kontrak'] ?? '-'); ?></td>
                                            <td data-sort="<?=$row['tgl_pesan_kontrak']?>"><?php echo htmlspecialchars($tgl_pesan_indo); ?></td>
                                            <td><?php echo htmlspecialchars($row['nilai_pesanan_kontrak'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($row['nama_perusahaan'] ?? '-'); ?></td>
                                            <td><?php echo htmlspecialchars($row['no_bast'] ?? '-'); ?></td>
                                            <td data-sort="<?=$row['tgl_bast']?>"><?php echo htmlspecialchars($tgl_bast_indo); ?></td>
                                            <td class="text-center no-export">
                                                <div class="action-buttons-wrapper">
                                                    <a href="edit-pernyataan-bmd.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit" title="Edit">
                                                        <i class="fas fa-edit"></i> Edit
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
    <script>
        // DataTables Initialization sama seperti js/berita-acara.js namun inline sementara
        $(document.ready(function() {
            var table = $('#pernyataanTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
                },
                "responsive": {
                    "details": {
                        "type": 'column',
                        "target": 0
                    }
                },
                "columnDefs": [
                    {
                        "className": 'control',
                        "orderable": false,
                        "targets": 0
                    },
                    {
                        "orderable": false,
                        "targets": "no-export"
                    }
                ],
                "dom": '<"top"fB>rt<"bottom"lip><"clear">',
                "buttons": [
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn-secondary',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn-secondary',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':not(.no-export)'
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 10;
                            doc.styles.tableHeader.fontSize = 11;
                            
                            if (typeof logoBase64 !== 'undefined') {
                                doc.content.splice(0, 0, {
                                    alignment: 'center',
                                    image: logoBase64,
                                    width: 50,
                                    margin: [0, 0, 0, 10]
                                });
                            }
                            
                            doc.content.splice(1, 0, {
                                text: 'DAFTAR PERNYATAAN VERIFIKASI BMD',
                                style: 'header',
                                alignment: 'center',
                                margin: [0, 0, 0, 20]
                            });
                        }
                    }
                ]
            });
        }));

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat form untuk POST request
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'proses-pernyataan-bmd.php';
                    
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = 'delete';
                    
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    idInput.value = id;
                    
                    form.appendChild(actionInput);
                    form.appendChild(idInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
</body>
</html>
