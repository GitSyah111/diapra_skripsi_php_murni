<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

$surat_cuti_regex = '/(\s*<\?php if \(\$role !== \'user\'\): \?>\s*<a href="surat-cuti\.php" class="nav-item[^"]*" title="Surat Cuti">\s*<i class="fas fa-calendar-check"><\/i>\s*<span class="sidebar-text">Surat Cuti<\/span>\s*<\/a>\s*<\?php endif; \?>)/i';

$berita_acara_menu = "
                <a href=\"berita-acara.php\" class=\"nav-item\" title=\"Berita Acara\">
                    <i class=\"fas fa-file-contract\"></i>
                    <span class=\"sidebar-text\">Berita Acara</span>
                </a>";

foreach ($files as $file) {
    // Skip if it is the script itself or files generated recently that already have it
    if (basename($file) === 'dashboard.php' || basename($file) === 'update_sidebar.php' || basename($file) === 'add_berita_acara_menu.php' || basename($file) === 'berita-acara.php' || basename($file) === 'tambah-berita-acara.php' || basename($file) === 'edit-berita-acara.php' || basename($file) === 'proses-berita-acara.php') continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    // Check if the file has a sidebar
    if (strpos($content, '<nav class="sidebar-nav">') !== false) {
        // Skip if already modified
        if (strpos($content, 'href="berita-acara.php"') === false) {
            
            $content = preg_replace($surat_cuti_regex, '$1' . $berita_acara_menu, $content);
            
            if ($content !== $original) {
                file_put_contents($file, $content);
                echo "Updated: " . basename($file) . "\n";
            }
        }
    }
}

// Special case for dashboard.php which might not have the php role checks in the exact same format
$dashboard_file = $dir . '/dashboard.php';
if (file_exists($dashboard_file)) {
    $content = file_get_contents($dashboard_file);
    $original = $content;
    if (strpos($content, 'href="berita-acara.php"') === false) {
        $dashboard_cuti_regex = '/(\s*<\?php if \(\$role !== \'user\'\): \?>\s*<a href="surat-cuti\.php" class="nav-item[^"]*" title="Surat Cuti">\s*<i class="fas fa-calendar-check"><\/i>\s*<span class="sidebar-text">Surat Cuti<\/span>\s*<\/a>\s*<\?php endif; \?>)/i';
        $content = preg_replace($dashboard_cuti_regex, '$1' . $berita_acara_menu, $content);
        if ($content !== $original) {
            file_put_contents($dashboard_file, $content);
            echo "Updated: dashboard.php\n";
        }
    }
}

echo "Done.\n";
