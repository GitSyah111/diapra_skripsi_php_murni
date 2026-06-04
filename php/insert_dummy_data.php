<?php
// Koneksi manual khusus buat insert dummy data
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; 
$DB_NAME = 'db_diapra_2026'; // Gunakan DB 2026

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_user = 1; // Anggap user id 1 (Super Admin)

    // Data Berita Acara
    $berita_acara_data = [
        ['001/AGENDA', 'BA-001/II/2026', '2026-02-10', 'PT. Maju Bersama', '2026-02-15', 'Pengadaan Komputer Kantor', 'Rp 50.000.000'],
        ['002/AGENDA', 'BA-002/II/2026', '2026-02-12', 'CV. Makmur Jaya', '2026-02-18', 'Pembelian Alat Tulis Kantor', 'Rp 5.500.000'],
        ['003/AGENDA', 'BA-003/III/2026', '2026-03-01', 'PT. Sejahtera Indah', '2026-03-05', 'Pengadaan Kursi Rapat', 'Rp 15.000.000'],
        ['004/AGENDA', 'BA-004/III/2026', '2026-03-10', 'Toko Elektronik Sentosa', '2026-03-12', 'Pembelian Proyektor', 'Rp 8.000.000'],
        ['005/AGENDA', 'BA-005/IV/2026', '2026-04-05', 'CV. Sukses Selalu', '2026-04-10', 'Renovasi Ruang Kerja', 'Rp 35.000.000']
    ];

    $stmt = $pdo->prepare("INSERT INTO berita_acara (no_agenda, no_berita_acara, tanggal, nama_perusahaan, tanggal_serah_terima, uraian, nilai_pengadaan, diinput_oleh) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($berita_acara_data as $row) {
        $stmt->execute([$row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $id_user]);
    }
    echo "5 Dummy Data Berita Acara berhasil diinsert.\n";

    // Data Pernyataan Verifikasi BMD
    $pernyataan_bmd_data = [
        ['SP-BMD-01/2026', '2026-01-20', 'KONTRAK-01/I/2026', '2026-01-15', 'Rp 45.000.000', 'PT. Teknologi Masa Depan', 'BAST-01/2026', '2026-01-25'],
        ['SP-BMD-02/2026', '2026-02-25', 'KONTRAK-02/II/2026', '2026-02-20', 'Rp 20.000.000', 'CV. Kertas Nusantara', 'BAST-02/2026', '2026-02-28'],
        ['SP-BMD-03/2026', '2026-03-15', 'KONTRAK-03/III/2026', '2026-03-10', 'Rp 75.000.000', 'PT. Bangun Graha', 'BAST-03/2026', '2026-03-20'],
        ['SP-BMD-04/2026', '2026-04-10', 'PESANAN-04/IV/2026', '2026-04-05', 'Rp 12.000.000', 'Toko Sumber Rejeki', 'BAST-04/2026', '2026-04-12'],
        ['SP-BMD-05/2026', '2026-04-18', 'PESANAN-05/IV/2026', '2026-04-15', 'Rp 6.500.000', 'CV. Karya Mandiri', 'BAST-05/2026', '2026-04-20']
    ];

    $stmt2 = $pdo->prepare("INSERT INTO pernyataan_verifikasi_bmd (no_surat_pernyataan, tgl, no_pesanan_kontrak, tgl_pesan_kontrak, nilai_pesanan_kontrak, nama_perusahaan, no_bast, tgl_bast, diinput_oleh) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($pernyataan_bmd_data as $row) {
        $stmt2->execute([$row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7], $id_user]);
    }
    echo "5 Dummy Data Pernyataan Verifikasi BMD berhasil diinsert.\n";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
