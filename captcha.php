<?php
session_start();

// Generate CAPTCHA code
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$captcha_code = '';
for ($i = 0; $i < 6; $i++) {
    $captcha_code .= $characters[rand(0, strlen($characters) - 1)];
}
$_SESSION['captcha'] = $captcha_code;

// Create image
$width = 120;
$height = 60;
$captcha_image = imagecreate($width, $height);

// Background color (light gray)
$background_color = imagecolorallocate($captcha_image, 220, 220, 220);

// Text color (dark gray)
$text_color = imagecolorallocate($captcha_image, 50, 50, 50);

// Noise color (gray lines)
$noise_color = imagecolorallocate($captcha_image, 160, 160, 160);

// Add noise (lines)
for ($i = 0; $i < 8; $i++) {
    imageline($captcha_image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $noise_color);
}

// Font settings
$font_size = 26;  // Increased font size
$font_path = __DIR__ . '/monofont.ttf';  // Path to TTF font
$x = 20;
$y = 40;

// Add text to image (using TTF font)
imagettftext($captcha_image, $font_size, rand(-10, 10), $x, $y, $text_color, $font_path, $captcha_code);

// Output image
ob_clean();
header('Content-Type: image/png');
imagepng($captcha_image);
imagedestroy($captcha_image);
?>
