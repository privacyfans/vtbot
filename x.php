

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (function_exists('shell_exec')) {
    echo 'shell_exec() is available.';
} else {
    echo 'shell_exec() is not available.';
}

// Jalankan skrip di latar belakang menggunakan perintah shell_exec atau exec.
// Misalnya:
shell_exec('/usr/local/bin/php /home/cbnb9676/public_html/vt/all.php > /dev/null 2>&1 &');

// Respon ke browser jika perlu
echo "VT-Bot Running.";
?>
