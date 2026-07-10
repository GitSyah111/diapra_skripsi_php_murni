# Analisis Tambahan & Pembaruan Aplikasi DIAPRA

Berdasarkan permintaan untuk menganalisis kembali sistem dan menambahkan fitur **Absen** serta halaman **Riwayat Aktivitas**, berikut adalah hasil analisis kelayakan dan rancangan implementasinya ke dalam ekosistem sistem DIAPRA.

## 1. Analisis Fitur Absensi (Kehadiran Pegawai)
**Status Kelayakan:** Sangat Memungkinkan (Sangat Layak)

**Deskripsi:**
Aplikasi DIAPRA yang tadinya berfokus pada Tata Naskah Dinas dan Kearsipan akan diperluas fungsinya mencakup sebagian kecil modul *Human Resource Information System* (HRIS). Dengan fitur ini, instansi tidak hanya melacak dokumen, tetapi juga kehadiran pegawai.

**Rancangan Implementasi:**
- **Kebutuhan Database:** Diperlukan 1 tabel baru (misal: `absensi`) yang berelasi langsung dengan tabel `user` atau data kepegawaian. Field yang dibutuhkan mencakup: `id_absen`, `id_user` (FK), `tanggal`, `jam_masuk`, `jam_pulang`, `status_kehadiran` (Hadir/Sakit/Izin/Cuti/Tugas Luar), dan `keterangan`.
- **Sisi Antarmuka (UI):** 
  - **Untuk Bidang/User:** Terdapat menu atau tombol cepat di Dashboard untuk melakukan *Clock In* (Absen Masuk) dan *Clock Out* (Absen Pulang).
  - **Untuk Admin:** Tersedia halaman Rekapitulasi Absensi untuk memonitor kehadiran seluruh bidang/pegawai per hari atau per bulan, yang nantinya dapat diekspor ke PDF/Excel.

## 2. Analisis Halaman "Riwayat Aktivitas"
**Status Kelayakan:** Sangat Memungkinkan (Sangat Layak)

**Deskripsi:**
Fitur ini merupakan penyempurnaan dari alur "Disposisi Surat". Ketika ada Surat Masuk berupa "Undangan" dan didisposisikan ke sebuah Bidang, sistem saat ini belum melacak siapa yang akhirnya pergi menghadiri undangan tersebut. Halaman Riwayat Aktivitas ini akan menutup celah tersebut dengan menyediakan laporan *feedback* dari Bidang ke Admin.

**Rancangan Implementasi:**
- **Kebutuhan Database:** Diperlukan tabel baru (misal: `riwayat_aktivitas`) yang berfungsi sebagai laporan tindak lanjut. Field utamanya meliputi:
  - `id_aktivitas` (Primary Key)
  - `id_surat` (Foreign Key mengarah ke `surat_masuk` atau `surat_keluar` sebagai sumber dokumen dasar kegiatan)
  - `id_bidang` (Bidang mana yang menghadiri)
  - `jumlah_peserta` (Berapa orang yang hadir - tipe *integer*)
  - `nama_peserta` (Siapa saja yang hadir - tipe *text*, dipisahkan dengan koma atau newline)
  - `dokumentasi_foto` (Opsional untuk bukti kehadiran fisik)
- **Sisi Antarmuka (UI):**
  - **Input oleh Bidang:** Bidang yang menerima disposisi undangan akan mengisi form berisi "Jumlah Peserta" dan "Nama-nama Peserta".
  - **Halaman Riwayat Aktivitas (Admin/Pimpinan):** Halaman tabel (*DataTables*) yang memuat daftar seluruh kegiatan. Saat di-klik detailnya, sistem akan memunculkan:
    1. Informasi kegiatan (kapan, bidang apa yang hadir, nama orangnya).
    2. **Preview Dokumen Surat:** Sistem akan otomatis menarik nama file PDF dari tabel `surat_masuk` atau `surat_keluar` menggunakan *Foreign Key*, lalu menampilkannya secara langsung di halaman tersebut menggunakan `<iframe src="uploads/file_surat.pdf">` tanpa perlu mengunduhnya ulang. Admin dapat membaca langsung undangan aslinya di sebelah laporan kehadiran.

## 3. Rangkuman Dampak Pengembangan (Skema Database)
Menambahkan kedua fitur ini membutuhkan penambahan **2 Tabel Baru** pada *database* (MySQL) saat ini:
1. `tabel_absensi` (Log harian kehadiran).
2. `tabel_riwayat_aktivitas` (Log laporan kehadiran acara berdasarkan surat).

*(Tidak ada perubahan mayor pada struktur yang sudah ada, melainkan hanya penambahan fitur yang dapat berjalan berdampingan (side-by-side) dengan fitur persuratan lama).*

## Kesimpulan
Permintaan penambahan **Fitur Absen** dan **Halaman Riwayat Aktivitas** dapat diintegrasikan dengan mulus ke dalam aplikasi DIAPRA. Fitur ini akan menjadikan DIAPRA sebuah aplikasi *e-Office* yang jauh lebih komprehensif, karena berhasil menghubungkan siklus: **"Terima Surat Undangan -> Disposisi -> Laporan Kehadiran (Riwayat Aktivitas) -> Pencatatan Absensi Tugas Luar"**.
