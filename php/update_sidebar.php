<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

$surat_masuk_regex = '/(\s*)<a href="surat-masuk\.php" class="nav-item[^"]*" title="Surat Masuk">\s*<i class="fas fa-inbox"><\/i>\s*<span class="sidebar-text">Surat Masuk<\/span>\s*<\/a>/';

$surat_cuti_regex = '/(\s*)<a href="surat-cuti\.php" class="nav-item[^"]*" title="Surat Cuti">\s*<i class="fas fa-calendar-check"><\/i>\s*<span class="sidebar-text">Surat Cuti<\/span>\s*<\/a>/';

foreach ($files as $file) {
    if (basename($file) === 'dashboard.php' || basename($file) === 'update_sidebar.php') continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    // Check if the file has a sidebar (look for sidebar-nav)
    if (strpos($content, '<nav class="sidebar-nav">') !== false) {
        // Skip if already modified
        if (strpos($content, '<?php if ($role !== \'user\'): ?>' . "\n" . '                <a href="surat-masuk.php"') === false) {
            
            $content = preg_replace($surat_masuk_regex, '$1<?php if ($role !== \'user\'): ?>$0$1<?php endif; ?>', $content);
            $content = preg_replace($surat_cuti_regex, '$1<?php if ($role !== \'user\'): ?>$0$1<?php endif; ?>', $content);
            
            if ($content !== $original) {
                file_put_contents($file, $content);
                echo "Updated: " . basename($file) . "\n";
            }
        }
    }
}
echo "Done.\n";
