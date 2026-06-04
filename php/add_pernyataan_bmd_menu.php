<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

$berita_acara_regex = '/(<a\s+href="berita-acara\.php"\s+class="nav-item(?:\s+active)?"\s+title="Berita Acara">\s*<i\s+class="fas\s+fa-file-contract"><\/i>\s*<span\s+class="sidebar-text">Berita Acara<\/span>\s*<\/a>)/is';

$pernyataan_menu = "\n                <a href=\"pernyataan-verifikasi-bmd.php\" class=\"nav-item\" title=\"Pernyataan Verifikasi BMD\">\n                    <i class=\"fas fa-file-signature\"></i>\n                    <span class=\"sidebar-text\">Perny. Verifikasi BMD</span>\n                </a>";

foreach ($files as $file) {
    if (in_array(basename($file), ['database.php', 'auth_check.php', 'pernyataan-verifikasi-bmd.php', 'tambah-pernyataan-bmd.php', 'edit-pernyataan-bmd.php', 'proses-pernyataan-bmd.php'])) continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    if (strpos($content, '<nav class="sidebar-nav">') !== false) {
        if (strpos($content, 'href="pernyataan-verifikasi-bmd.php"') === false) {
            $content = preg_replace($berita_acara_regex, '$1' . $pernyataan_menu, $content);
            
            if ($content !== $original) {
                file_put_contents($file, $content);
                echo "Added missing menu to: " . basename($file) . "\n";
            }
        }
    }
}
echo "Done inserting menu.\n";
