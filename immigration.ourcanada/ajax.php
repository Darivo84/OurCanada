<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require "user_inc.php";
require 'send-grid-email/vendor/autoload.php'; // send grid API file for emails
$sendGridAPIKey='';
if($ext=='.app')
{
    $sendGridAPIKey="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";

}
else
{
    $sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada

}

$date = date("Y-m-d h:i:s A");
$current_time=date('Y-m-d H:i:s');

$default_url = $baseURL;
$lang_slug = $_GET['Lang'];

if($_GET['h'] == 'continue_login')
{
    if(isset($_SESSION['user_id']))
    {
        die(json_encode(array('Success' => 'false','already'=>'1')));
    }
    else
    {

        $email = $_SESSION['email'];
        $select = mysqli_query($conn, "SELECT * FROM users where email = '$email'");
        $row = mysqli_fetch_assoc($select);
        $loggedUserId = $row['id'];
        $_SESSION['user_id'] = $loggedUserId;
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['loggedin_time'] = time();

        mysqli_query($conn,"UPDATE users SET last_login_time='$current_time',cookie='{$_COOKIE['PHPSESSID']}', is_logged = '1', `session_id` = '".session_id()."' WHERE id  = '$loggedUserId'");
        die(json_encode(array('Success' => 'true','role'=>$row['role'], 'Msg' => 'Login Successful. Redirecting...')));
    }


}
if ($_GET['h'] == 'login') {

    $T = db_pair_str2($_POST['n']);
    $select = mysqli_query($conn, "SELECT * FROM users where email = '{$_POST['n']['email']}'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);



        $verify = password_verify($_POST['n']['password'], $row['password']);

        if ($verify) {
            $sameCrashed = false; # used to check if system was crashed and same user is trying to login

            if(!empty($_POST['loc_session_id']))
            {
                // its means browser was closed without logout aur browser goes to bad shutdown
                if($row['id'] == $_POST['loc_user_id'])
                {
                    $sameCrashed = true;
                }
            }
            $loggedUserId = $row['id'];

            // echo $loggedUserId;

           // if( $row['is_logged'] == "0" || $row['is_logged'] == 0 || $row['role'] == "1" || $row['session_id'] == session_id() ||   empty($row['session_id'])  )
            {
                
                $_SESSION['user_id'] = $loggedUserId;
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['loggedin_time'] = time();
				
				$userIDSession = $loggedUserId;
				$select=mysqli_query($conn,"select * from user_sessions where user_id=$loggedUserId and session_id='".session_id()."'");
				if(mysqli_num_rows($select)>0)
                {

                    mysqli_query($conn,"update user_sessions set ip_address='".getIPAddress()."',login_time='$current_time', is_logged=1 where user_id=$loggedUserId and session_id='".session_id()."'");
                }
				else
                {
                    mysqli_query($conn,"insert into user_sessions (user_id,session_id,login_time,is_logged,ip_address) values ($loggedUserId,'".session_id()."','$current_time',1,'".getIPAddress()."')");
                }

                mysqli_query($conn,"UPDATE users SET last_login_time='$current_time',cookie='{$_COOKIE['PHPSESSID']}',is_logged = '1', `session_id` = '".session_id()."' WHERE id  = '$loggedUserId'");

                die(json_encode(array('Success' => 'true','role' => $row['role'] ,'Msg' => 'Login Successful. Redirecting...')));
            }
//            else
//            {
//
//                $_SESSION['email'] = $row['email'];
//                die(json_encode(array('Success' => 'false', 'status' =>'1' ,'Msg' => 'You are logging in on a second device. Any unsaved information from the first device may be lost. To avoid data loss, please be sure to save any information on the first device before logging in on the second device.')));
//            }
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[152])));
        }
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[770])));
    }
}
if ($_GET['h'] == 'signup') {
    if($_POST['g-recaptcha-response']=='')
    {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Please select captcha.')));
    }

    $_POST['n']['created_at'] = $date;
    $_POST['n']['password'] = password_hash($_POST['n']['password'], PASSWORD_DEFAULT);
    $_POST['n']['username'] = explode('@', $_POST['n']['email'])[0];
    $T = db_pair_str2($_POST['n']);
    
    $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$_POST['n']['email']}'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        die(json_encode(array('Success' => 'false', 'Msg' => 'Email address already exists.')));
    } else {

        $insert = mysqli_query($conn, "INSERT into users SET $T");
        if ($insert) {


            if(isset($_SESSION['refer_code']) && $_SESSION['refer_code']!=='')
            {
                $check=mysqli_query($conn,"select * from referral where refered_to='{$_POST['n']['email']}' and refered_code='{$_SESSION['refer_code']}'");
                // $checkRow=mysqli_fetch_assoc($check);
                // if(mysqli_num_rows($check) > 0)
                // {
                //     $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$checkRow['refered_by']}'");
                //     $row=mysqli_fetch_assoc($select);
                //     $points=(int)$row['points'] + 2;
                //     $update=mysqli_query($conn,"update users set points = ".$points." where email='{$checkRow['refered_by']}'");
                //     $update=mysqli_query($conn,"update referral set status=1 where refered_to='{$_POST['n']['email']}' and refered_code='{$_SESSION['refer_code']}'");

                // }
            }

            die(json_encode(array('Success' => 'true', 'Msg' => 'Signup Completed.')));
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding user.')));
        }
    }
}
if ($_GET['h'] == 'professionalAccount') {

    // $select = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '{$_POST['n']['email']}'");


    $url='https://'.$_SERVER['HTTP_HOST'].$_POST['url'] ;
    $select = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '{$_POST['n']['email']}' and link='$url'");
    if (mysqli_num_rows($select) > 0) {

        $checkUserReult = mysqli_query($conn,"SELECT * FROM users WHERE email = '{$_POST['n']['email']}'");
        if(mysqli_num_rows($checkUserReult) > 0)
        {
            die(json_encode(array('Success' => 'false', 'Msg' => 'This user already exists please goto login.')));
        }
        else

        {



            $_POST['n']['created_at'] = $date;
            $_POST['n']['role'] = 1;
            $_POST['n']['password'] = password_hash($_POST['n']['password'], PASSWORD_DEFAULT);
            $_POST['n']['username'] = explode('@', $_POST['n']['email'])[0];

            $T = db_pair_str2($_POST['n']);
            mysqli_query($conn , "UPDATE accounts set expire = 1 WHERE link='$url'");
            $insert = mysqli_query($conn, "INSERT into users SET $T");
            if ($insert) {
                $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$_POST['n']['email']}'");
                $row = mysqli_fetch_assoc($select);

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type'];

                die(json_encode(array('Success' => 'true', 'Msg' => 'Signup Completed.')));
            } else {
                die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding user.')));
            }
        }
    }
    else {
        die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[770])));
    }



}
if ($_GET['h'] == 'forget') {
    $select = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$_POST['email']}'");
    if (mysqli_num_rows($select) <= 0) {

        die(json_encode(array('Success' => 'false', 'Msg' => 'Email address not found!')));
    } else {
        $colum=$_GET['Lang']==''?'':'_'.$_GET['Lang'];
        $column=$colum=='_francais'?'_french':$colum;
        $temps = mysqli_query($conn, "SELECT * FROM email_templates WHERE type = 'reset password'");
        $label = mysqli_query($conn, "SELECT * FROM static_labels WHERE label = 'Click here'");
        $get_labels=mysqli_fetch_assoc($label);
        $click_msg=$get_labels['label'.$column];
        $get_temps = mysqli_fetch_assoc($temps);
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
        $msg='<h3>'.$greeting.'</h3>'.$msg.'<br>';

        $row = mysqli_fetch_assoc($select);
        $to = $_POST['email'];
        $subject = "Forgot Password";
        $code = generate_string(10);
        $click_msg=$click_msg==''?'Click here':$click_msg;

        $body_text = $msg.'<a href="' . $currentTheme . 'change-password'.(!empty($lang_slug)?"/".$lang_slug:"").'/' . $code . '">'.$click_msg.'</a>';
        checkAlignment();

        $mail_response=defaultMail($to,$subject,'',$body_text);

        if ($mail_response) {
            $update = mysqli_query($conn, "update users set reset_code='$code' where email = '{$_POST['email']}' ");

            die(json_encode(array('Success' => 'true', 'Msg' => 'Reset password link has been sent to your email.')));
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding user.')));
        }
    }
}
if ($_GET['h'] == 'reset') {



    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $code = $_POST['code'];

    $select = mysqli_query($conn, "SELECT * FROM users where reset_code = '$code'");
    $row = mysqli_fetch_assoc($select);
    if ($pass != $cpass) {
        die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[313])));
    } else {

        $verify_newPass = password_verify($pass, $row['password']);

//        if($verify_newPass)
//        {
//            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[771])));
//        }

        $pass  = password_hash($pass, PASSWORD_DEFAULT);
        $update = mysqli_query($conn, "update users set password='$pass' where reset_code='$code'");
        if ($update) {
            die(json_encode(array('Success' => 'true', 'Msg' => 'Password has been changed successfully.')));
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding user.')));
        }
    }
}
if ($_GET['h'] == 'professional_account_request') {
    $str=generate_string(8);
    $email=$_POST['email'];
    $_POST['n']['email'] = $email;
    $_POST['n']['status'] = 0;
    $_POST['n']['language'] = $lang_slug;


    $link=$default_url.'/activation/'.(($lang_slug == "english")?"":$lang_slug."/").$str;
    $_POST['n']['link'] = $link;
    $T = db_pair_str2($_POST['n']);


    $select = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '$email' ");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        $status  = $row['status'];
        $id = $row['id'];
//        date_default_timezone_set('America/Los_Angeles');

        $time = date('Y-m-d H:i:s');
        $updateQuery = "UPDATE `accounts` SET `last_request` = '$time' WHERE `id` = '$id'";
        mysqli_query($conn,$updateQuery);
        if($status == 0)
        {

            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[739])));
        } else
        if($status == 1)
        {

            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[271])));
        }
        else
        {
//            $updateQuery = "UPDATE `accounts` SET `status` = '0' WHERE `id` = '$id'";
//            mysqli_query($conn,$updateQuery);

            die(json_encode(array('Success' => 'true', 'Msg' => $allLabelsArray[799])));
        }

    } else {

        $insert = mysqli_query($conn, "INSERT into accounts SET $T");
//        $insert = mysqli_query($conn, "INSERT into users SET $T");

        if ($insert) {
            $body='<h3>Dear Admin</h3><br>User with below email address has requested for a professional account.<br><strong>'.$email.'</strong>';
            $to='fnsheikh29@gmail.com';
            $to1='info@ourcanada.co';
            $from='no-reply@ourcanada.co';
            $subject='Request for a professional account';

            defaultMail($to1,$subject,$from,$body);

            die(json_encode(array('Success' => 'true', 'Msg' => $allLabelsArray[798])));
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[39])));
        }
    }
}
if ($_GET['h'] == 'changePassword') {

    $new_pass=password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id=$_POST['id'];
    $select = mysqli_query($conn, "SELECT * FROM users where id = '{$_POST['id']}'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);

        $verify = password_verify($_POST['old_password'], $row['password']);
        $verify_newPass = password_verify($_POST['password'], $row['password']);

        
        if ($verify) {
//            if($verify_newPass)
//            {
//                die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[771])));
//            }
            $update=mysqli_query($conn,"UPDATE users SET password='$new_pass' where id  = '$id'");
            if($update)
            {
                die(json_encode(array('Success' => 'true','Msg' => $allLabelsArray[311])));//'Password has been updated'
            }
            else
            {
                die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[39])));
            }
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' =>$allLabelsArray[310] ))); //'Old Password doesn\'t match'
        }
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Invalid User')));
    }
}


function checkAlignment()
{
    global $display_class,$align_class,$dir,$conn,$lang_slug;
    $getDisp = mysqli_query($conn, "SELECT * FROM `multi-lingual` where lang_slug='$lang_slug'");
    $dispRow = mysqli_fetch_assoc($getDisp);
    if ($dispRow['display_type'] == 'Right to Left') {
        $display_class = 'urduField';
        $align_class = 'text-align: right;';

        $dir = 'rtl';
    }
}
function generate_string($strength = 16)
{
    $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    $input_length = strlen($input);
    $random_string = '';
    for ($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}
function search_assoc($value, $array)
{
    $result = false;
    foreach ($array as $el) {
        if (!is_array($el)) {
            $result = $result || ($el == $value);
        } else if (in_array($value, $el))
            $result = $result || true;
        else $result = $result || false;
    }
    return $result;
}
function defaultMail($email, $subject,$from, $body)
{
    global $sendGridAPIKey,$align_class,$currentTheme,$ext;

    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$currentTheme.'img/ourcanada.png" height="120" alt=""></th>
                     </tr>
                 </thead>

                 <tbody>
                 
                     <tr>
                         <td style="padding:0 24px 15px;color:#000;letter-spacing: 0.03em;line-height: 25px;'.$align_class.'" class="">
                              <h3 sty;e="margin-top:!5px"></h3>
                               ' . $body . '
                             
                         </td>
                     </tr>
                   
                    
                     <tr>
                         <td style="padding:16px 8px; color: #ffffff; background-color: #E50606; text-align: center;">
                             OurCanada © 2021
                         </td>
                         
                     </tr>
                     
                 </tbody></table></body>
                                 </html>';
    
//    $headers = "MIME-Version: 1.0" . "\r\n";
//    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//    $headers .= 'From: OurCanada <no-reply@ourcanada.co>';
//    $restMail =  mail($email, $subject, $emailBody, $headers);

//    if ($restMail) {
//        return true;
//    } else {
//        return false;
//    }
    // sendgrid
    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($email);



    $emailObj->addContent(
        "text/html",
        $emailBody # html:body
    );

    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);
       // print $response->body() . "\n";

        return true;

    } catch (Exception $e) {
       //echo 'Caught exception: ' . $e->getMessage() . "\n";
        return false;
    }

}



