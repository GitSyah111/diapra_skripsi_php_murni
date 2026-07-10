<?php
// Script untuk membuat tabel pernyataan_verifikasi_bmd di semua database db_diapra_%
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
        
        $create_table_sql = "CREATE TABLE IF NOT EXISTS `$db`.`pernyataan_verifikasi_bmd` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `no_surat_pernyataan` varchar(100) DEFAULT NULL,
            `tgl` date DEFAULT NULL,
            `no_pesanan_kontrak` varchar(100) DEFAULT NULL,
            `tgl_pesan_kontrak` date DEFAULT NULL,
            `nilai_pesanan_kontrak` varchar(255) DEFAULT NULL,
            `nama_perusahaan` varchar(255) DEFAULT NULL,
            `no_bast` varchar(100) DEFAULT NULL,
            `tgl_bast` date DEFAULT NULL,
            `diinput_oleh` bigint(20) NOT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `fk_pernyataan_diinput_oleh` (`diinput_oleh`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        
        $pdo->exec($create_table_sql);
        echo "  [CREATED/EXISTS] Table pernyataan_verifikasi_bmd in $db.\n";
    }
    
    echo "Migration completed successfully.\n";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
