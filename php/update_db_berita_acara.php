<?php
// Script untuk menambahkan kolom baru pada berita_acara di semua database db_diapra_%
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
        
        // Cek apakah tabel berita_acara ada
        $check_table = $pdo->query("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = '$db' AND table_name = 'berita_acara'");
        if ($check_table->fetchColumn() == 0) {
            echo "  [SKIPPED] Table berita_acara does not exist.\n";
            continue;
        }

        // Cek dan Tambah kolom no_agenda
        $check_col = $pdo->query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = '$db' AND table_name = 'berita_acara' AND column_name = 'no_agenda'");
        if ($check_col->fetchColumn() == 0) {
            $pdo->exec("ALTER TABLE `$db`.`berita_acara` ADD COLUMN `no_agenda` VARCHAR(100) NULL AFTER `id`");
            echo "  [ADDED] `no_agenda` column.\n";
        } else {
            echo "  [EXISTS] `no_agenda` column already exists.\n";
        }

        // Cek dan Tambah kolom no_berita_acara
        $check_col = $pdo->query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = '$db' AND table_name = 'berita_acara' AND column_name = 'no_berita_acara'");
        if ($check_col->fetchColumn() == 0) {
            $pdo->exec("ALTER TABLE `$db`.`berita_acara` ADD COLUMN `no_berita_acara` VARCHAR(100) NULL AFTER `tanggal`");
            echo "  [ADDED] `no_berita_acara` column.\n";
        } else {
            echo "  [EXISTS] `no_berita_acara` column already exists.\n";
        }

        // Cek dan Tambah kolom nilai_pengadaan
        $check_col = $pdo->query("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = '$db' AND table_name = 'berita_acara' AND column_name = 'nilai_pengadaan'");
        if ($check_col->fetchColumn() == 0) {
            $pdo->exec("ALTER TABLE `$db`.`berita_acara` ADD COLUMN `nilai_pengadaan` VARCHAR(255) NULL AFTER `uraian`");
            echo "  [ADDED] `nilai_pengadaan` column.\n";
        } else {
            echo "  [EXISTS] `nilai_pengadaan` column already exists.\n";
        }
    }
    
    echo "Migration completed successfully.\n";
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
