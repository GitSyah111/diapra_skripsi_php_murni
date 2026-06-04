-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 24 Feb 2026 pada 07.02
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_diapra_2026`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `disposisi`
--

CREATE TABLE `disposisi` (
  `id` int NOT NULL,
  `id_surat_masuk` int NOT NULL,
  `tujuan_bidang` varchar(100) NOT NULL,
  `isi_disposisi` text NOT NULL,
  `sifat` varchar(50) NOT NULL,
  `batas_waktu` date DEFAULT NULL,
  `catatan` text,
  `file_disposisi` varchar(255) DEFAULT NULL,
  `status_baca` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `disposisi`
--

INSERT INTO `disposisi` (`id`, `id_surat_masuk`, `tujuan_bidang`, `isi_disposisi`, `sifat`, `batas_waktu`, `catatan`, `file_disposisi`, `status_baca`) VALUES
(8, 18, 'Bidang Pemberdayaan Masyarakat', 'kirimkan ke ibu..', 'Biasa', '2026-02-19', 'segera dilaksanakan', 'disposisi_1771394551_699555f7cd9ed.pdf', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kadis`
--

CREATE TABLE `kadis` (
  `no` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `pangkat` varchar(255) NOT NULL,
  `NIP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kadis`
--

INSERT INTO `kadis` (`no`, `nama`, `pangkat`, `NIP`) VALUES
(1, 'Drs. M. HELFIANNOOR, M.Si', 'Pembina Utama Muda', '19730719 199302 1 002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `spj_umpeg`
--

CREATE TABLE `spj_umpeg` (
  `id` int NOT NULL,
  `nomor_urut` int NOT NULL,
  `nomor_spj` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `dibuat_oleh` varchar(100) NOT NULL,
  `file_spj` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `spj_umpeg`
--

INSERT INTO `spj_umpeg` (`id`, `nomor_urut`, `nomor_spj`, `tanggal`, `nama_kegiatan`, `dibuat_oleh`, `file_spj`) VALUES
(4, 1, 'SPJ/001/UMPEG/2026', '2026-01-01', 'Permohonan Persetujuan Pelaksanaan Pembayaran Belanja Surat Kaba', 'Super Admin', 'spj_1770524871_698810c7a9275.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_cuti`
--

CREATE TABLE `surat_cuti` (
  `id` int NOT NULL,
  `id_user` bigint DEFAULT NULL,
  `Nama/NIP` varchar(100) NOT NULL,
  `Pangkat/GOL RUANG` varchar(25) NOT NULL,
  `Jabatan` varchar(255) DEFAULT NULL,
  `Jenis Cuti` varchar(20) NOT NULL,
  `Lamanya` varchar(11) NOT NULL,
  `Dilaksanakan DI` varchar(20) NOT NULL,
  `Mulai Cuti` int NOT NULL,
  `Sampai Dengan` int NOT NULL,
  `Sisa Cuti` varchar(11) NOT NULL,
  `file_surat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `surat_cuti`
--

INSERT INTO `surat_cuti` (`id`, `id_user`, `Nama/NIP`, `Pangkat/GOL RUANG`, `Jabatan`, `Jenis Cuti`, `Lamanya`, `Dilaksanakan DI`, `Mulai Cuti`, `Sampai Dengan`, `Sisa Cuti`, `file_surat`) VALUES
(4, NULL, 'NOVA PUSPITA SARI, S.Kom ', 'penata III', 'Penyusun Bahan Kebijakan Pengabdian Masyarakat ', 'Cuti Tahunan', '5 hari', 'Banjarmasin', 1769385600, 1769731200, '2 Hari', 'surat_cuti_1770451950_6986f3eeaa133.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_keluar`
--

CREATE TABLE `surat_keluar` (
  `id` int NOT NULL,
  `id_user` bigint DEFAULT NULL,
  `nomor_urut` int NOT NULL,
  `nomor_surat` varchar(255) NOT NULL,
  `tujuan_surat` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `perihal` text NOT NULL,
  `dibuat_oleh` varchar(100) NOT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `surat_keluar`
--

INSERT INTO `surat_keluar` (`id`, `id_user`, `nomor_urut`, `nomor_surat`, `tujuan_surat`, `tanggal_surat`, `perihal`, `dibuat_oleh`, `file_surat`, `created_at`) VALUES
(9, NULL, 1, '800.1.4.1/100-Sekr/DPPKBPM', 'Koordinator PKB Banjarmasin Tengah', '2026-01-19', 'Pemberitahuan Peralihan Penempatan Peserta Magang Fresh Graduated Batch 2 Sebagai PКВ', 'Admin', '69880f0a26774_1770524426.pdf', '2026-02-08 04:20:26'),
(10, NULL, 2, '800.1.11.1/101 /DPPKBPM/2026', 'AFIFAH, AM.Keb', '2026-01-20', 'SURAT PERINTAH PELAKSANA TUGAS', 'Admin', '69881474727d4_1770525812.pdf', '2026-02-08 04:43:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `surat_masuk`
--

CREATE TABLE `surat_masuk` (
  `id` int NOT NULL,
  `id_user` bigint DEFAULT NULL,
  `nomor_agenda` varchar(100) NOT NULL,
  `tanggal_terima` date NOT NULL,
  `alamat_pengirim` varchar(255) NOT NULL,
  `tanggal_surat` date NOT NULL,
  `nomor_surat` varchar(255) NOT NULL,
  `perihal` text NOT NULL,
  `file_surat` varchar(255) DEFAULT NULL,
  `sifat_surat` varchar(100) DEFAULT NULL,
  `tujuan_disposisi` text,
  `instruksi_disposisi` text,
  `catatan_disposisi` text,
  `status_disposisi` varchar(50) NOT NULL DEFAULT 'Belum diproses',
  `dilihat_oleh` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `file_disposisi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `surat_masuk`
--

INSERT INTO `surat_masuk` (`id`, `id_user`, `nomor_agenda`, `tanggal_terima`, `alamat_pengirim`, `tanggal_surat`, `nomor_surat`, `perihal`, `file_surat`, `sifat_surat`, `tujuan_disposisi`, `instruksi_disposisi`, `catatan_disposisi`, `status_disposisi`, `dilihat_oleh`, `created_at`, `file_disposisi`) VALUES
(18, 5, '1', '2026-02-18', 'Sekretariat Daerah Kota Banjarmasin', '2026-02-01', '000.2.5/2534-PBMD/BPKPAD/XII/2025', 'Usulan Penunjukan Pejabat Pengelolaan BMD Satuan Kerja Perangkat Daerah (SKPD) Pemerintah Kota Banjarmasin Tahun Anggaran 2026', 'surat_1771394423_69955577647d2.pdf', NULL, NULL, NULL, NULL, 'Sudah didisposisi', '', '2026-02-18 06:00:23', NULL),
(19, 1, '2', '2026-02-19', 'WALI KОТА ВANJARMASIN', '2025-10-20', 'NOMOR 1003.4.4/643/BAG.UMUM/XII/2025', 'NOMOR 1003.4.4/643/BAG.UMUM/XII/2025', '', NULL, NULL, NULL, NULL, 'Belum diproses', '', '2026-02-19 01:03:02', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `no` bigint NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('super_admin','admin','user') NOT NULL DEFAULT 'user',
  `nama_bidang` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`no`, `nama`, `username`, `password`, `role`, `nama_bidang`) VALUES
(1, 'Super Admin', 'Super Admin', '727dfbdc1a4ee249f3f08c247a5669d5', 'super_admin', NULL),
(2, 'Bidang Dalduk', 'bidangdalduk', '9b9263edc30ea713fa1575ad88d89e4e', 'user', 'Bidang Pengendalian Penduduk'),
(3, 'Bidang Keluarga Berencana', 'bidangKB', 'f71bb154b18c43349a35e1628e348785', 'user', 'Bidang Keluarga Berencana'),
(4, 'Bidang Keluarga Sejahtera', 'bidangKS', '52a3394027792ce0744be8106133550c', 'user', 'Bidang Keluarga Sejahtera'),
(5, 'Bidang Pemberdayaan Masyarakat', 'bidangPM', 'b655e7469e74cb9ba7147f180f714bb5', 'user', 'Bidang Pemberdayaan Masyarakat'),
(10, 'Admin', 'Admin', '214dcff5c31c1a56bed1cb56614722ce', 'admin', NULL);

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_surat_masuk` (`id_surat_masuk`);

--
-- Indeks untuk tabel `kadis`
--
ALTER TABLE `kadis`
  ADD PRIMARY KEY (`no`);

--
-- Indeks untuk tabel `spj_umpeg`
--
ALTER TABLE `spj_umpeg`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `surat_cuti`
--
ALTER TABLE `surat_cuti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_surat_cuti_user` (`id_user`);

--
-- Indeks untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_surat_keluar_user` (`id_user`);

--
-- Indeks untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_surat_masuk_user` (`id_user`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `kadis`
--
ALTER TABLE `kadis`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `spj_umpeg`
--
ALTER TABLE `spj_umpeg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `surat_cuti`
--
ALTER TABLE `surat_cuti`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `no` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `fk_disposisi_surat` FOREIGN KEY (`id_surat_masuk`) REFERENCES `surat_masuk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_cuti`
--
ALTER TABLE `surat_cuti`
  ADD CONSTRAINT `fk_surat_cuti_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`no`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_keluar`
--
ALTER TABLE `surat_keluar`
  ADD CONSTRAINT `fk_surat_keluar_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`no`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `surat_masuk`
--
ALTER TABLE `surat_masuk`
  ADD CONSTRAINT `fk_surat_masuk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`no`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
