<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendResetMail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // 設定 SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'wilson20040626@gmail.com';   
        $mail->Password = 'cppi zfmm nnvv djuy';          
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // 寄件人
        $mail->setFrom('wilson20040626@gmail.com', '網站管理員');
        $mail->addAddress($to);

        // 內容
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';   // 設定編碼
        $mail->Subject = $subject;  // 標題
        $mail->Body    = $body;     // 內容

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}
?>
