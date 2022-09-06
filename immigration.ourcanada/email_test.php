<?php
use PHPMailer\PHPMailer\PHPMailer;


require 'send-grid-email/vendor/autoload.php';
$sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada
$body='<html>
                                 <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
             <thead>
                 <tr style="background-color: #f7f7f7;">
                     <th scope="col"><img src="https://ourcanadadev.site/awards/assets/images/logo.png" height="120" alt=""></th>
                 </tr>
             </thead>

             <tbody>

                 <tr>
                     <td style="padding:0 24px 15px;color:#000;letter-spacing: 0.03em;line-height: 25px;">
                          <h3 sty;e="margin-top:!5px"></h3>
                        Hi Richard,<br>
This is programmatically sent email. <br>
Thank\'s for your time to read it. No need to reply this email.

                     </td>
                 </tr>

                 <tr>
                     <td style="padding: 15px 24px 15px; color: #8492a6;">
                         OurCanada.com <br> Support Team
                     </td>
                 </tr>

                 <tr>
                     <td style="padding:16px 8px; color: #ffffff; background-color: #E50606; text-align: center;">
                         © 2019-20 OurCanada.com
                     </td>
                 </tr>
             </tbody></body>
                             </html>';

// require_once "PHPMailer/PHPMailer.php";
// require_once "PHPMailer/SMTP.php";
// require_once "PHPMailer/Exception.php";
// $mail = new PHPMailer();
//// $mail->isSMTP();
// $mail->Host = "mail.ourcanada.co";
//// $mail->SMTPAuth = true;
// $mail->Username = "ocsadmin@mail.ourcanada.co";  // Client's mail username
// $mail->Password = "Xw84D@5VaQ8jEUCg";                   // Client's mail password
// $mail->Port = 587;
//// $mail->SMTPSecure = "tls";
// $mail->isHTML(true);
// $mail->From  = "ocsadmin@mail.ourcanada.co";
// $mail->addAddress('fnsheikh29@gmail.com');
//
// $mail->Subject = 'Testing on Production server for sendGrid Mail';
//
// $mail->Body = $body;

//if(!$mail->Send())
//{
//    echo "Error sending: " . $mail->ErrorInfo;
//}
//else
//{
//    echo "E-mail sent";
//}



$emailObj = new \SendGrid\Mail\Mail();
$emailObj->setFrom("no-reply@ourcanada.co", "OurCanada");
$emailObj->setSubject('Testing Email Configurations on Production server');
$emailObj->addTo('fnsheikh29@gmail.com');
$emailObj->addBcc('haider.mustafa581@gmail.com');

// $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$emailObj->addContent(
    "text/html",
    $body # html:body
);



$sendgrid = new \SendGrid($sendGridAPIKey);
try {
    $response = $sendgrid->send($emailObj);


    //  $response->body();
    return array('sg_status' => json_encode($response->statusCode()), 'sg_heasders' => json_encode($response->headers()));
} catch (Exception $e) {
    return 'Caught exception: ' . $e->getMessage() . "\n";
}
?>