<?php
$databases = ['db_diapra_2025', 'db_diapra_2026'];
$host = 'localhost';
$user = 'root';
$pass = '';

foreach ($databases as $db) {
    echo "Processing database: $db...\n";
    $conn = new mysqli($host, $user, $pass);
    
    $db_selected = $conn->select_db($db);
    if (!$db_selected) {
        echo " - Database $db not found, skipping.\n";
        continue;
    }
    
    // 1. Temporarily change ENUM to VARCHAR to allow safe update
    $conn->query("ALTER TABLE `user` MODIFY COLUMN `role` VARCHAR(255)");
    
    // 2. Update rows
    $conn->query("UPDATE `user` SET `role` = 'admin' WHERE `role` = 'super_admin'");
    $affected = $conn->affected_rows;
    echo " - Updated $affected rows from 'super_admin' to 'admin'.\n";
    
    // 3. Change back to new ENUM
    if ($conn->query("ALTER TABLE `user` MODIFY COLUMN `role` ENUM('admin','user') NOT NULL DEFAULT 'user'")) {
         echo " - ENUM schema updated successfully.\n";
    } else {
         echo " - Failed to update ENUM: " . $conn->error . "\n";
    }
    
    $conn->close();
}
