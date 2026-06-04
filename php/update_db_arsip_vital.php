<?php
// Script untuk menambahkan tabel daftar_arsip_vital di semua database db_diapra_%
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; 

try {
    $pdo = new PDO("mysql:host=$DB_HOST", $DB_USER, $DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all databases
    $stmt = $pdo->query("SHOW DATABASES LIKE 'db_diapra_%'");
    $databases = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($databases as $db) {
        echo "Processing database: $db\n";
        
        $sql = "CREATE TABLE IF NOT EXISTS `$db`.`daftar_arsip_vital` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `jenis_arsip` varchar(255) NOT NULL,
            `tingkat_perkembangan` varchar(255) NOT NULL,
            `kurun_waktu` varchar(100) NOT NULL,
            `media` varchar(100) NOT NULL,
            `jumlah` varchar(100) NOT NULL,
            `jangka_simpan` varchar(100) NOT NULL,
            `lokasi_simpan` varchar(255) NOT NULL,
            `metode_perlindungan` varchar(255) NOT NULL,
            `keterangan` text DEFAULT NULL,
            `diinput_oleh` int(11) DEFAULT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

        $pdo->exec($sql);
        echo "  [SUCCESS] Tabel daftar_arsip_vital dipastikan ada.\n";
    }
    
    echo "Migration completed successfully.\n";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
