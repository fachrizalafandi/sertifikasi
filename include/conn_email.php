<?
  require 'phpmailer/PHPMailerAutoload.php';
  $mail = new PHPMailer;

  // Konfigurasi SMTP
  $mail->isSMTP();
  $mail->Host = 'smtp.hostinger.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'notifikasi@lsp-ipi.id';
  $mail->Password = 'Lspipi123#';
  $mail->SMTPSecure = 'ssl';
  $mail->Port = 465;
?>
