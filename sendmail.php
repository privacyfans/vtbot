<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Pengaturan Server
    $mail->isSMTP(); // Menggunakan SMTP
    $mail->Host = 'mail.cbnbandung.com'; // Server SMTP, ganti dengan server SMTP Anda
    $mail->SMTPAuth = true; // Aktifkan autentikasi SMTP
    $mail->Username = 'admin@cbnbandung.com'; // SMTP username
    $mail->Password = 'Arkan@199003'; // SMTP password
    //$mail->SMTPSecure = 'ssl'; // Aktifkan enkripsi TLS, `ssl` juga diterima
    $mail->Port = 465; // Port TCP untuk terhubung, gunakan 465 untuk `ssl`

    // Penerima
    $mail->setFrom('admin@cbnbandung.com', 'Admin CBN Bandung'); // Siapa pengirim email
    $mail->addAddress('privacyfans@gmail.com', 'Irfan Luthfi Irawan'); // Tambahkan penerima

    // Konten
    $mail->isHTML(true); // Mengatur format email ke HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
