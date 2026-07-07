# Scope Aplikasi & Analisis Laporan DIAPRA (Skripsi 1 Semester)

## 1. Analisis Ketersediaan Laporan Saat Ini (Current State)
Berdasarkan hasil penelusuran kode sumber pada sistem DIAPRA saat ini, ketersediaan fitur pelaporan (*reporting*) dan pencetakan masih sangat minim dan bersifat individual (per dokumen). 
Fitur pelaporan yang tersedia saat ini hanya:
1. **Cetak Lembar Disposisi** (`cetak-disposisi-final.php`): Mencetak satu lembar disposisi spesifik untuk sebuah surat masuk.
2. **Cetak Detail SPJ UMPEG** & **Surat Cuti**: Mencetak detail satu pengajuan.
3. **Dashboard Statistik Dasar**: Menampilkan jumlah surat dan grafik garis (*line chart*) pergerakan surat masuk/keluar, SPJ, dan cuti per bulan, yang di-*filter* berdasarkan session tahun aktif.

**Kesimpulan Saat Ini**: Sistem belum memiliki fitur **Report Generator** (Rekapitulasi) yang memadai (misalnya laporan bulanan/tahunan yang bisa diekspor ke PDF/Excel) yang menjadi syarat wajib dan krusial bagi sebuah sistem administrasi e-Office di tingkat instansi pemerintahan.

---

## 2. Scope Skripsi (1 Semester yang Realistis)
Untuk memenuhi kelayakan sebagai tugas akhir skripsi dalam waktu pengerjaan 1 semester, *scope* pengembangan akan difokuskan pada:
1. **Pengembangan Modul Pengelolaan Lanjutan (Kompleksitas Bisnis)**: Penambahan fitur pelacakan tindak lanjut disposisi (balasan/bukti dari bidang) dan filter dinamis multi-parameter (Tanggal, Kategori, Status, Tahun Anggaran).
2. **Pembangunan Sistem Pelaporan Komprehensif (Report Generator)**: Mencakup ekspor data (*PDF, Print, Excel*) dan visualisasi data (*Dashboard Charts*).

### Modul Pengelolaan Kompleks (Target Pengembangan)
- **Modul Pelaporan Dinamis (Dynamic Report Builder)**: Antarmuka terpusat di mana Admin/Bidang dapat memilih jenis laporan, memasukkan rentang tanggal (*Date Range Picker*), memilih format ekspor (PDF/Excel), dan sistem akan melakukan *query* dinamis untuk *generate* laporannya.
- **Feedback Tindak Lanjut Disposisi**: Pengembangan modul disposisi agar Bidang tidak hanya sekadar "menerima", tetapi bisa mengunggah progres/bukti tindak lanjut, sehingga Admin bisa memantau *SLA (Service Level Agreement)* penyelesaian tugas.

---

## 3. Rincian 13 Jenis Laporan (Pembagian Berdasarkan Role)

Untuk memenuhi target **minimal 13 jenis laporan** dengan variasi format (Cetak/PDF, Excel, Grafik/Dashboard), berikut adalah *scope* laporannya yang dibagi ke dalam 2 Role:

### A. Role Admin / Super Admin (Manajemen Pusat)
Role ini memiliki kewenangan melihat seluruh rekapitulasi data institusi. Laporan yang akan dikembangkan:

1. **Laporan Rekapitulasi Surat Masuk (PDF/Cetak)**: Laporan tabular yang memuat seluruh surat masuk berdasarkan filter rentang tanggal dan status disposisi.
2. **Laporan Rekapitulasi Surat Masuk (Excel)**: Ekspor format `.xlsx` / `.csv` dari rekap surat masuk untuk keperluan pengolahan data lanjutan atau arsip fisik kepegawaian pusat.
3. **Laporan Rekapitulasi Surat Keluar (PDF/Cetak)**: Laporan register surat keluar instansi per bulan/tahun anggaran.
4. **Laporan Rekapitulasi Surat Keluar (Excel)**: Format *spreadsheet* untuk mempermudah pencarian log nomor seri surat keluar secara manual oleh staf.
5. **Laporan Kinerja Disposisi Instansi (PDF/Cetak)**: Laporan yang memperlihatkan daftar surat yang didisposisikan ke berbagai bidang, lengkap dengan status tindak lanjut (Selesai/Proses/Belum), untuk dipresentasikan kepada Kepala Dinas.
6. **Laporan Daftar SPJ UMPEG (PDF/Cetak)**: Rekapitulasi pengajuan SPJ UMPEG berdasarkan filter bulan/tahun.
7. **Laporan Rekapitulasi Surat Cuti Pegawai (PDF/Cetak)**: Laporan yang memuat daftar nama pegawai yang mengambil cuti, jenis cuti, rentang waktu, dan sisa cuti.
8. **Laporan Aset & Kearsipan (Arsip Vital & BMD) (Excel)**: Laporan rekap total aset barang milik daerah dan daftar arsip vital ke dalam format *spreadsheet* sebagai lampiran akhir tahun instansi.
9. **Dashboard Analitik Eksekutif Admin (Grafik Interaktif)**: 
   - *Bar Chart*: Perbandingan beban disposisi antar bidang (Bidang mana yang mendapat tugas paling banyak).
   - *Pie Chart*: Rasio penyelesaian tindak lanjut disposisi (Selesai vs Belum Selesai) secara instansi.

### B. Role Bidang (User Spesifik Bidang)
Role ini hanya memiliki akses ke laporan yang terkait dengan tugas pokok dan fungsi (Tupoksi) bidangnya masing-masing.

10. **Laporan Historis Disposisi Diterima (PDF/Cetak)**: Rekapitulasi seluruh tugas/surat masuk yang dilimpahkan khusus ke bidang tersebut dalam rentang tanggal tertentu, berguna sebagai laporan kinerja bidang.
11. **Laporan Historis Disposisi Diterima (Excel)**: Ekspor *spreadsheet* untuk pengarsipan lokal di internal bidang.
12. **Laporan Rekapitulasi Berita Acara Bidang (PDF/Cetak)**: Laporan daftar Berita Acara kegiatan atau serah terima yang melibatkan bidang bersangkutan.
13. **Dashboard Kinerja Bidang (Grafik Interaktif)**: 
    - *Doughnut Chart*: Persentase status tindak lanjut disposisi pada bidang tersebut (Menunjukkan *compliance* bidang dalam menyelesaikan instruksi).
    - *Line Chart*: Tren intensitas surat disposisi yang masuk ke bidang tersebut setiap bulannya.

---

## 4. Kesimpulan Kelayakan (Feasibility)
*Scope* di atas sangat realistis untuk dieksekusi dalam **1 semester (4-6 bulan)** pengerjaan Skripsi. 
- **Bulan 1-2**: Analisis kebutuhan lanjutan, perancangan database tambahan (untuk tabel *feedback* disposisi), dan perombakan arsitektur *query* pelaporan.
- **Bulan 3-4**: Implementasi koding (Pembuatan UI/UX Report Builder, implementasi *library* pembuat PDF seperti FPDF/TCPDF/Dompdf, dan library Excel seperti PhpSpreadsheet).
- **Bulan 5-6**: Pembuatan visualisasi Grafik Dashboard (*Chart.js*), *Testing* fungsional (UAT), pencarian bug, dan penyusunan buku laporan skripsi.
