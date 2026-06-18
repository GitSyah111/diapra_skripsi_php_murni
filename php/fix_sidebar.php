<?php
$dir = __DIR__;
$files = glob($dir . '/*.php');

foreach ($files as $file) {
    if (basename($file) === 'dashboard.php' || basename($file) === 'fix_sidebar.php' || basename($file) === 'update_sidebar.php' || basename($file) === 'update_restrictions.php') continue;
    
    $content = file_get_contents($file);
    $original = $content;
    
    if (strpos($content, '<nav class="sidebar-nav">') !== false) {
        
        // 1. Remove user restriction from Surat Cuti
        $pattern_cuti = "/<\?php if \(\\\$role !== 'user'\): \?>\s*<a href=\"surat-cuti\.php\" class=\"nav-item(.*?)\" title=\"Surat Cuti\">\s*<i class=\"fas fa-calendar-check\"><\/i>\s*<span class=\"sidebar-text\">Surat Cuti<\/span>\s*<\/a>\s*<\?php endif; \?>/s";
        $replacement_cuti = '<a href="surat-cuti.php" class="nav-item$1" title="Surat Cuti">
                    <i class="fas fa-calendar-check"></i>
                    <span class="sidebar-text">Surat Cuti</span>
                </a>';
        $content = preg_replace($pattern_cuti, $replacement_cuti, $content);
        
        // 2. Add user restriction to Dashboard, Surat Keluar, Berita Acara, Daftar Arsip Vital, Pernyataan Verifikasi BMD if not already restricted
        
        // Dashboard
        $pattern_dashboard = '/<!-- Menu Dashboard -->\s*<a href="dashboard\.php" class="nav-item(.*?)" title="Dashboard">\s*<i class="fas fa-home"><\/i>\s*<span class="sidebar-text">Dashboard<\/span>\s*<\/a>/s';
        if (strpos($content, '<?php if ($role !== \'user\'): ?>' . "\n" . '                <!-- Menu Dashboard -->') === false) {
            $content = preg_replace($pattern_dashboard, "<!-- Menu Dashboard -->\n                <?php if (\$role !== 'user'): ?>\n                <a href=\"dashboard.php\" class=\"nav-item$1\" title=\"Dashboard\">\n                    <i class=\"fas fa-home\"></i>\n                    <span class=\"sidebar-text\">Dashboard</span>\n                </a>\n                <?php endif; ?>", $content);
        }

        // Surat Keluar
        $pattern_keluar = '/<!-- Menu Surat Keluar -->\s*<a href="surat-keluar\.php" class="nav-item(.*?)" title="Surat Keluar">\s*<i class="fas fa-paper-plane"><\/i>\s*<span class="sidebar-text">Surat Keluar<\/span>\s*<\/a>/s';
        if (strpos($content, '<?php if ($role !== \'user\'): ?>' . "\n" . '                <!-- Menu Surat Keluar -->') === false) {
            $content = preg_replace($pattern_keluar, "<!-- Menu Surat Keluar -->\n                <?php if (\$role !== 'user'): ?>\n                <a href=\"surat-keluar.php\" class=\"nav-item$1\" title=\"Surat Keluar\">\n                    <i class=\"fas fa-paper-plane\"></i>\n                    <span class=\"sidebar-text\">Surat Keluar</span>\n                </a>\n                <?php endif; ?>", $content);
        }

        // Berita Acara
        $pattern_ba = '/<a href="berita-acara\.php" class="nav-item(.*?)" title="Berita Acara">\s*<i class="fas fa-file-contract"><\/i>\s*<span class="sidebar-text">Berita Acara<\/span>\s*<\/a>/s';
        if (strpos($content, '<?php if ($role !== \'user\'): ?>' . "\n" . '                <a href="berita-acara.php"') === false) {
            $content = preg_replace($pattern_ba, "<?php if (\$role !== 'user'): ?>\n                <a href=\"berita-acara.php\" class=\"nav-item$1\" title=\"Berita Acara\">\n                    <i class=\"fas fa-file-contract\"></i>\n                    <span class=\"sidebar-text\">Berita Acara</span>\n                </a>\n                <?php endif; ?>", $content);
        }

        // Daftar Arsip Vital
        $pattern_dav = '/<a href="daftar-arsip-vital\.php" class="nav-item(.*?)" title="Daftar Arsip Vital">\s*<i class="fas fa-archive"><\/i>\s*<span class="sidebar-text">Daftar Arsip Vital<\/span>\s*<\/a>/s';
        if (strpos($content, '<?php if ($role !== \'user\'): ?>' . "\n" . '                <a href="daftar-arsip-vital.php"') === false) {
            $content = preg_replace($pattern_dav, "<?php if (\$role !== 'user'): ?>\n                <a href=\"daftar-arsip-vital.php\" class=\"nav-item$1\" title=\"Daftar Arsip Vital\">\n                    <i class=\"fas fa-archive\"></i>\n                    <span class=\"sidebar-text\">Daftar Arsip Vital</span>\n                </a>\n                <?php endif; ?>", $content);
        }

        // Pernyataan Verifikasi BMD
        $pattern_bmd = '/<a href="pernyataan-verifikasi-bmd\.php" class="nav-item(.*?)" title="Pernyataan Verifikasi BMD">\s*<i class="fas fa-file-signature"><\/i>\s*<span class="sidebar-text">Perny\. Verifikasi BMD<\/span>\s*<\/a>/s';
        if (strpos($content, '<?php if ($role !== \'user\'): ?>' . "\n" . '                <a href="pernyataan-verifikasi-bmd.php"') === false) {
            $content = preg_replace($pattern_bmd, "<?php if (\$role !== 'user'): ?>\n                <a href=\"pernyataan-verifikasi-bmd.php\" class=\"nav-item$1\" title=\"Pernyataan Verifikasi BMD\">\n                    <i class=\"fas fa-file-signature\"></i>\n                    <span class=\"sidebar-text\">Perny. Verifikasi BMD</span>\n                </a>\n                <?php endif; ?>", $content);
        }
        
        if ($content !== $original) {
            file_put_contents($file, $content);
            echo "Updated sidebar in: " . basename($file) . "\n";
        }
    }
}
echo "Sidebar fix Done.\n";
