<?php 

function PHP_MAILER($to,$sub,$body){
    // return [$to,$sub,$body];
    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "mail.ourcanadadev.site ";
    $mail->SMTPAuth = true;
    $mail->Username = "support@ourcanadadev.site";  // Client's mail username
    $mail->Password = "wIvN9J,;D;zn";                   // Client's mail password
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->isHTML(true);
    $mail->addAddress($to);
    $mail->Subject = $sub;

    $mail->Body = $body;

    return $mail->send();
}