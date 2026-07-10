<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

$regex = '/\s*<\?php\s+if\s*\(\$role\s*!==\s*\'user\'\):\s*\?>\s*(<a\s+href="berita-acara\.php".*?<\/a>)\s*<\?php\s+endif;\s*\?>/is';

foreach ($files as $file) {
    if (in_array(basename($file), ['database.php', 'auth_check.php'])) continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    // Replace if condition around berita acara menu
    $content = preg_replace($regex, "\n                $1", $content);
    
    if ($content !== $original) {
        file_put_contents($file, $content);
        echo "Updated menu lock in: " . basename($file) . "\n";
    }
}
echo "Done.\n";
