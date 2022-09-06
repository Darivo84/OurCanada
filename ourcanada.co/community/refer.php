<?php
include 'user_inc.php';
if($page=='main')
{
    require 'sendGrid/vendor/autoload.php';

}
else
{
    require '../sendGrid/vendor/autoload.php';

}

$sendGridAPIKey='';
if($ext=='.app')
{
    $sendGridAPIKey="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";

}
else
{
    $sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada

}

function defaultMail($referedTo , $body )
{
    global $sendGridAPIKey,$align_class,$currentTheme,$ext;
    $emailBody = '<html>
                                    <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                <thead>
                    <tr style="background-color: #f7f7f7;">
                        <th scope="col"><img src="https://ourcanadadev.site/awards/assets/images/logo.png" height="120" alt=""></th>
                    </tr>
                </thead>

                <tbody>
                   
                    <tr>
                        <td style="padding:0 24px 15px;color:#000;letter-spacing: 0.03em;line-height: 25px;">
                             '.$body.'
                        </td>
                    </tr>
                   

                    <tr>
                        <td style="padding:16px 8px; color: #ffffff; background-color: #E50606; text-align: center;">
                            OurCanada © 2021
                        </td>
                    </tr>
                    </tbody>
                    </table>
                    </body>
                                </html>';


    // sendgrid

    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject("Invitation To Canadian Immigration Process");
    $emailObj->addTo($referedTo);



    $emailObj->addContent(
        "text/html",
        $emailBody # html:body
    );

    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);
        return true;

    } catch (Exception $e) {
        // echo 'Caught exception: ' . $e->getMessage() . "\n";
        return false;
    }

}

$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
$referedCode = substr(str_shuffle($permitted_chars), 0, 10);
if(isset($_GET['Lang']))
{
    $_GET['lang']=$_GET['Lang'];
}
if ( $_GET[ 'h' ] == 'referFriend' ) {
    if(!isset($_SESSION['user_id']))
    {
        die(json_encode(array('Success' => 'false2', 'Msg' => $allLabelsArray[772])));
    }


    $getReferedUser = mysqli_query($conn , "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}'");
    $row = mysqli_fetch_assoc($getReferedUser);

    $userName = $row['username'];

    $_POST['n']['refered_by'] = $row['email'];
    $_POST['n']['refered_to'] = $_POST['email'];
    $_POST['n']['refered_code'] = $referedCode;

    

    $referStatus = mysqli_query($conn , "SELECT * FROM referral WHERE ( refered_to = '{$_POST['email']}' OR refered_by = '{$_POST['email']}') AND refered_by = '{$row['email']}' ");
    if(mysqli_num_rows($referStatus) > 0){
        die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[749])));
    }else{
        $exist_check = mysqli_query($conn,"SELECT * FROM users WHERE email = '".$_POST['email']."'");
        if(mysqli_num_rows($exist_check) > 0){
            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[752])));
        }else{
            $exist_check = mysqli_query($conn,"SELECT * FROM users WHERE email = '".$_POST['email']."'");
            $user_row=mysqli_fetch_assoc($exist_check);

//            $checkProfile = mysqli_query($conn , "SELECT * FROM user_form WHERE user_email = '{$_POST['n']['refered_by']}' ");
            $checkProfile = mysqli_query($conn , "SELECT * FROM user_form WHERE user_id = '{$_SESSION['user_id']}' ");

            if(mysqli_num_rows($checkProfile) > 0){
                $getRefer = mysqli_query($conn , "SELECT * FROM user_form WHERE user_email = '{$_POST['n']['refered_to']}' ");

                $_POST['n']['status'] = 0;
                $temps = mysqli_query($conn, "SELECT * FROM email_templates WHERE type = 'refer code'");
                $get_temps = mysqli_fetch_assoc($temps);

                $lang=$_GET['lang']==''?'':'_'.$_GET['lang'];
                $column=$lang=='_francais'?'_french':$lang;
                $msg=$get_temps['main_text'.$column];
                $greeting=$get_temps['greeting_text'.$column];
                if($msg=='' || $msg==null)
                {
                    $msg=$get_temps['main_text'];
                }
                if($greeting=='' || $greeting==null)
                {
                    $greeting=$get_temps['greeting_text'];
                }
                $s=mysqli_query($conn,"select * from static_labels where label='Click here to view Canadian immigration process'");
                $r=mysqli_fetch_assoc($s);
                $click=$r['label'.$column];
                if($click=='' || $click==null)
                {
                    $click='Click here to view Canadian immigration process';
                }

                $link='https://immigration.ourcanada'.$ext.'/refer?code='.$referedCode.'&lang='.$_GET['lang'];
                $anchor='<a href="'.$link.'">'.$click.'</a>';
                $body='<h3>'.$greeting.'</h3><strong>'.$userName.'</strong> '.$msg.'<br><strong>'.$anchor.'</strong>';
                //checkAlignment($fetched_row['language']);
//                $mail_response = defaultMail($to, $subject, $from, $body);
                defaultMail($_POST['n']['refered_to'], $body );

                $T = db_pair_str2($_POST['n']);

                $insertRefer = mysqli_query($conn , "INSERT into referral SET $T");
                
                if($insertRefer){
                    die(json_encode(array('Success' => 'true', 'Msg' => $allLabelsArray[744])));
                }else{
                    die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[745])));
                }

            }else{
                die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[746].'<br><span style="color: #8e643a;">'.$allLabelsArray[747].' <a href="https://immigration.ourcanada'.$ext.'/form" target="_blank">'.$allLabelsArray[442].'</a> '.$allLabelsArray[441].'</span>')));
            }
        }
    }
}





?>