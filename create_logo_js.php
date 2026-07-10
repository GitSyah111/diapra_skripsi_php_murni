<?php
$imagePath = 'c:/laragon/www/si_surat/assets/img/LOGO.png';
$outputPath = 'c:/laragon/www/si_surat/js/logo-base64.js';

if (file_exists($imagePath)) {
    $imageData = base64_encode(file_get_contents($imagePath));
    $jsContent = "const logoBase64 = 'data:image/png;base64," . $imageData . "';";
    file_put_contents($outputPath, $jsContent);
    echo "Successfully created " . $outputPath;
} else {
    echo "Error: Image file not found at " . $imagePath;
}
?>
