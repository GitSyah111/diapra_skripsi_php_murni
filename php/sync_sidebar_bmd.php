<?php
$dashboard = file_get_contents(__DIR__ . '/dashboard.php');
// Extract the <aside class="sidebar" id="sidebar"> ... </aside>
preg_match('/<aside class="sidebar" id="sidebar">.*?<\/aside>/is', $dashboard, $matches);
$full_sidebar = $matches[0];

// Replace 'active' in dashboard menu
$full_sidebar = str_replace('class="nav-item active"', 'class="nav-item"', $full_sidebar);
// and add active to pernyataan
$target = '<a href="pernyataan-verifikasi-bmd.php" class="nav-item" title="Pernyataan Verifikasi BMD">';
$replacement = '<a href="pernyataan-verifikasi-bmd.php" class="nav-item active" title="Pernyataan Verifikasi BMD">';
$full_sidebar = str_replace($target, $replacement, $full_sidebar);

$files_to_sync = ['pernyataan-verifikasi-bmd.php', 'tambah-pernyataan-bmd.php', 'edit-pernyataan-bmd.php'];

foreach ($files_to_sync as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $content = preg_replace('/<aside class="sidebar" id="sidebar">.*?<\/aside>/is', $full_sidebar, $content);
        file_put_contents($file, $content);
        echo "Synced sidebar for: $file\n";
    }
}
?>
