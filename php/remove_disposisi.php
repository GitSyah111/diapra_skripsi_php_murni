<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

$disposisi_regex = '/\s*<\?php if \(\$role == \'bidang\'\): \?>\s*<a href="disposisi-masuk\.php" (.*)\s*<i class="fas fa-inbox"><\/i>\s*<span class="sidebar-text">Disposisi Masuk<\/span>\s*<\/a>\s*<\?php endif; \?>/';

foreach ($files as $file) {
    if (basename($file) === 'update_sidebar.php' || basename($file) === 'update_restrictions.php' || basename($file) === 'remove_disposisi.php') continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    if (strpos($content, 'disposisi-masuk.php') !== false) {
        $content = preg_replace($disposisi_regex, '', $content);
        
        if ($content !== $original) {
            file_put_contents($file, $content);
            echo "Removed Disposisi menu from: " . basename($file) . "\n";
        }
    }
}
echo "Done.\n";
