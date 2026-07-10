<?php
$dir = __DIR__;
$files_to_restrict = [
    'surat-masuk.php',
    'surat-cuti.php',
    'tambah-surat-masuk.php',
    'tambah-surat-cuti.php',
    'edit-surat-masuk.php',
    'edit-surat-cuti.php',
    'detail-surat-cuti.php'
];

$restrict_code = "\nif (\$role == 'user') {\n    header('Location: dashboard.php');\n    exit;\n}\n";

foreach ($files_to_restrict as $filename) {
    $file = $dir . '/' . $filename;
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Cek apakah sudah ada restriction
        if (strpos($content, "if (\$role == 'user') {") === false && strpos($content, 'header(\'Location: dashboard.php\')') === false) {
            
            // Insert setelah require_once 'auth_check.php';
            $pattern = '/require_once \'auth_check\.php\';/';
            $content = preg_replace($pattern, "require_once 'auth_check.php';" . $restrict_code, $content, 1);
            
            file_put_contents($file, $content);
            echo "Restricted: $filename\n";
        }
    }
}
echo "Restriction Done.\n";
