<?php

require "global.php";

$my=mysqli_query($conn,"update ocs.static_labels set label_urdu='نہیں' where id=41");
$my=mysqli_query($conn,"update ocs.static_labels set label_urdu='ہاں' where id=40");
die();

//include_once("function.php");

//use PHPMailer\PHPMailer\PHPMailer;

include('pdf_maker/tcpdf_include.php');
require 'send-grid-email/vendor/autoload.php';
$sendGridAPIKey = "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"; #account:support@ourcanadadev.site #pass:123456789ourcanada


//function sendEmail($questions, $answers, $assistance, $name, $email, $fname)
{
    $email='ahmadalshtiwi45@gmail.com';
    $fname='ahmadalshtiwi45@gmail.com_2021-01-04 05:50:01pm';

    // Recipient
    $to = 'fnsheikh29@gmail.com';
    $to1 = 'maryumakhter1@gmail.com';
    $to2 = 'haider.mustafa581@gmail.com';
    $to3 = 'fnsheikh29@outlook.com';
    $to4 = 'info@ourcanada.co';
    $to5 = 'shawna@immigrationcanada.app';


    $subject = $email . ' has submitted the form.';

    // Email body content

    $htmlContent = "<html>
		<body>
			<table width='100%' cellspacing='50' cellpadding='50' border='0' bgcolor='#E7E7E7' class='wrapper'>
				<tbody>
					<tr>
						<td>
							<table bgcolor='#ffffff' cellpadding='0' cellspacing='0' align='center' style='border:1px solid #acacac; border-radius:4px; padding:20px 50px 100px; width:632px;'>
								<tr>
									<td>
										<table style='width:100%'>
											<tr style='text-align:center'>
												<td><h1 style='font-weight:normal; color:#2e2e2e; font-size:40px; margin:0px; padding-top:30px; '><img style='width: 200px' src='http://ourcanadadev.site/superadmin/assets/images/Logo-Canada.png'></h1></td>
											</tr>
											<tr style='text-align:left'>
												<td style='text-align:left'><h1 style='font-weight:normal; color:#2e2e2e; font-size:20px; margin:0px; padding-top:30px; '>Dear Admin!</h1></td>
											</tr>
											<tr>
											<p>Following User has submitted the form.</p>
												<td></td>
											</tr>
											<tr style='text-align:left'>
											   <td>
													<p style='font-size:16px; color:#2e2e2e; line-height:25px; margin:0px; padding-top:20px;'>
														Name: Ahmad<br>
														Email Address: ahmadalshtiwi45@gmail.com
														<br><br>
														<b>User needs assistance:</b><br>
														<ul>
														<li>
														requesting assistance with a child sponsorship

</li>
</ul><br><br>

														Regards,<br>
														Our Canada Team.
													</p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</body>
	</html>";

    // Sender
    $from = 'support@ourcanada.co';
    $fromName = 'OurCanada';


    // Attachment file
    $file = $_SERVER['DOCUMENT_ROOT'] . "/pdf_files/" . $fname . '.pdf';
    $name = $fname . '.pdf';


    // Header for sender info
    $headers = "From: $fromName" . " <" . $from . ">";

    // Boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // Headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // Multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    // Preparing attachment
    if (!empty($file) > 0) {
        if (is_file($file)) {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($file, "rb");
            $data = @fread($fp, filesize($file));

            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                "Content-Description: " . basename($file) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($name) . "\"; size=" . filesize($file) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;


    // Send email

//    $output1 = sendGridemail($to, $subject, $htmlContent, $file, $fname . ".pdf");

}
function sendGridemail($to, $subject, $message, $file, $filename)
{
    global $sendGridAPIKey;
    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("support@ourcanadadev.site", "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($to);
    // $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
    $emailObj->addContent(
        "text/html",
        $message # html:body
    );


    $attachment = $file;
    $content    = file_get_contents($attachment);
    $content    = (base64_encode($content));

    $attachment = new \SendGrid\Mail\Attachment();
    $attachment->setContent($content);
    $attachment->setType("application/pdf");
    $attachment->setFilename($filename);
    $attachment->setDisposition("attachment");
    $emailObj->addAttachment($attachment);




    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);


        //  $response->body();
        return array('sg_status' => json_encode($response->statusCode()), 'sg_heasders' => json_encode($response->headers()));
    } catch (Exception $e) {
        return 'Caught exception: ' . $e->getMessage() . "\n";
    }
}


?>