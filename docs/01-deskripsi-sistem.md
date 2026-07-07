# Analisis Sistem DIAPRA (Digitalisasi Administrasi Persuratan)

## 1. Pendahuluan
**DIAPRA** (Digitalisasi Administrasi Persuratan) adalah sistem informasi berbasis web yang dikembangkan untuk mendigitalkan proses administrasi persuratan, pengarsipan dokumen krusial, pelacakan disposisi, serta tata kelola kepegawaian. 
Berdasarkan data dan struktur yang ada, sistem ini diperuntukkan bagi **DPPKBPM** (Dinas Pengendalian Penduduk, Keluarga Berencana, dan Pemberdayaan Masyarakat) khususnya di wilayah Kota Banjarmasin.

## 2. Aktor dan Hak Akses (Role)
Sistem ini menggunakan mekanisme autentikasi dan otorisasi berbasis peran (Role-Based Access Control) dengan tingkat akses sebagai berikut:

1. **Super Admin / Admin**:
   - Memiliki akses penuh (Full Access) ke seluruh modul di dalam sistem.
   - Dapat mengelola master data (Data Pengguna dan Data Kepala Dinas).
   - Bertanggung jawab melakukan pencatatan Surat Masuk, mendisposisikan surat ke berbagai bidang, serta mengunggah file-file persuratan dan kepegawaian.
2. **User (Level Bidang)**:
   - Mewakili bagian/bidang spesifik di dalam instansi (contoh: Bidang Pengendalian Penduduk, Bidang Keluarga Berencana, Bidang Keluarga Sejahtera, Bidang Pemberdayaan Masyarakat).
   - Hanya dapat melihat informasi yang relevan dengan bidangnya (misalnya, mengakses halaman "Disposisi Masuk").
   - Akses terbatas pada pembuatan dan pengarsipan modul-modul turunan, tanpa akses ke manajemen pengguna dan master data.

## 3. Fitur dan Modul Utama
Secara keseluruhan, sistem dibangun menggunakan arsitektur monolitik (PHP Native) dan mengelola beberapa modul proses bisnis:

### A. Modul Persuratan (Inti)
- **Surat Masuk**: Pencatatan detail surat yang diterima (No. Agenda, Tanggal Terima, Pengirim, Perihal), serta pengunggahan file scan (PDF). Terintegrasi dengan fitur pencatatan status disposisi (Sudah/Belum didisposisi).
- **Disposisi Surat**: Fasilitas bagi Admin untuk mendistribusikan tindak lanjut Surat Masuk ke Bidang tertentu, lengkap dengan instruksi, sifat penyelesaian (biasa/segera/rahasia), dan batas waktu pengerjaan.
- **Surat Keluar**: Pencatatan penomoran seri surat keluar instansi ke pihak luar beserta arsip salinan file-nya.

### B. Modul Kepegawaian & Keuangan
- **Surat Cuti**: Mendokumentasikan pengajuan cuti pegawai, mencakup jenis cuti, durasi (Mulai s.d. Selesai), sisa cuti, dan jabatan/pangkat pegawai.
- **SPJ UMPEG (Surat Pertanggungjawaban Urusan Kepegawaian)**: Sistem pengarsipan dokumen fisik pelaporan keuangan kegiatan/tugas spesifik untuk keperluan administrasi kepegawaian.

### C. Modul Kearsipan dan Aset (BMD)
- **Berita Acara**: Modul pencatatan surat Berita Acara, termasuk detail pelaksana/perusahaan, tanggal serah terima, uraian kegiatan, dan nilai pengadaan barang/jasa.
- **Daftar Arsip Vital**: Sistem penyimpanan digital untuk aset-aset arsip dokumen instansi yang bernilai vital/permanen.
- **Pernyataan Verifikasi BMD (Barang Milik Daerah)**: Modul untuk mengelola dan menyimpan riwayat dokumen pernyataan inventarisasi barang milik daerah.

### D. Modul Dashboard & Laporan
- **Dashboard Analitik**: Menyajikan visualisasi data (menggunakan *Chart.js*) berupa grafik garis dan panel angka akumulatif untuk jumlah Surat Masuk, Surat Keluar, SPJ, dan Surat Cuti secara *real-time*.
- **Filter Tahun Aktif**: Fitur manajemen *session* unik, yang memungkinkan pengguna memilah dan meninjau kumpulan data atau rekap laporan arsip berdasarkan Tahun Anggaran tertentu.

## 4. Struktur Database (Skema)
Sistem memiliki arsitektur *database* relasional dengan tabel-tabel utama berikut:
1. `user`: Menyimpan kredensial autentikasi (username, password MD5) dan role (admin/user).
2. `kadis`: Master data rujukan Kepala Dinas (Nama, NIP, Pangkat).
3. `surat_masuk` dan `surat_keluar`: Inti data *tracking* persuratan.
4. `disposisi`: Memiliki foreign key ke `surat_masuk` dan menyimpan detail pendelegasian tugas ke suatu bidang.
5. `surat_cuti`, `spj_umpeg`, `berita_acara`, `arsip_vital`, `pernyataan_bmd`: Menyimpan metadata arsip spesifik berdasarkan tupoksi instansi pemerintahan.

## 5. Tumpukan Teknologi (Tech Stack)
- **Backend / Logika Sistem**: PHP 8.x Native (Procedural).
- **Frontend / Antarmuka**: HTML5, CSS3 murni (Custom styling tanpa *framework* berat), Vanilla JavaScript. Font & ikon menggunakan FontAwesome.
- **Database Engine**: MySQL / MariaDB (Driver koneksi: `mysqli`).
- **Penyimpanan Berkas**: Sistem berkas lokal di folder `uploads/` untuk melampirkan berkas fisik berformat PDF.
