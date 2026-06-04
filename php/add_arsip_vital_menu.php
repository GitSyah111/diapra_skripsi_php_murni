<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

$berita_acara_regex = '/(\s*<a href="berita-acara\.php" class="nav-item[^"]*" title="Berita Acara">\s*<i class="fas fa-file-contract"><\/i>\s*<span class="sidebar-text">Berita Acara<\/span>\s*<\/a>)/i';

$arsip_vital_menu = "
                <a href=\"daftar-arsip-vital.php\" class=\"nav-item\" title=\"Daftar Arsip Vital\">
                    <i class=\"fas fa-archive\"></i>
                    <span class=\"sidebar-text\">Daftar Arsip Vital</span>
                </a>";

foreach ($files as $file) {
    // Skip if it is the script itself or files generated recently that already have it
    $basename = basename($file);
    $skip_files = [
        'update_sidebar.php', 
        'add_berita_acara_menu.php', 
        'add_arsip_vital_menu.php', 
        'daftar-arsip-vital.php', 
        'tambah-daftar-arsip-vital.php', 
        'edit-daftar-arsip-vital.php', 
        'proses-daftar-arsip-vital.php'
    ];
    
    if (in_array($basename, $skip_files)) continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    // Check if the file has a sidebar
    if (strpos($content, '<nav class="sidebar-nav">') !== false) {
        // Skip if already modified
        if (strpos($content, 'href="daftar-arsip-vital.php"') === false) {
            
            $content = preg_replace($berita_acara_regex, '$1' . $arsip_vital_menu, $content);
            
            if ($content !== $original) {
                file_put_contents($file, $content);
                echo "Updated: " . basename($file) . "\n";
            }
        }
    }
}

echo "Done.\n";
