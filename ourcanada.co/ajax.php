<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include 'user_inc.php';
mysqli_set_charset('utf8',$conn);

require 'sendGrid/vendor/autoload.php';
$current_time=date('Y-m-d H:i:s');

$sendGridAPIKey='';
if($ext=='.app')
{
    $sendGridAPIKey="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";

}
else
{
    $sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada

}


if ( $_GET[ 'h' ] == 'createUser' )
{
    $_POST['created_at']=date('Y-m-d h:i:sa');
    $T = db_pair_str2( $_POST );
    $sql = "INSERT INTO `users` SET $T";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true','Msg' => 'Registed Successfully' ) ));
    } else {
        die( json_encode( array( 'Success' => 'false','Msg' => 'That email is taken. Try another.') ) );
    }
}

if ($_GET['h'] == 'login') {

    $T = db_pair_str2($_POST['n']);
    $select = mysqli_query($conn, "SELECT * FROM users where email = '{$_POST['email']}'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);



        $verify = password_verify($_POST['password'], $row['password']);

        if ($verify) {
            $sameCrashed = false; # used to check if system was crashed and same user is trying to login

            if(!empty($_POST['loc_session_id']))
            {
                // its measns browser was closed without logout aur browser goes to bad shutdown
                if($row['id'] == $_POST['loc_user_id'])
                {
                    $sameCrashed = true;
                }
            }
            $loggedUserId = $row['id'];


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

                die(json_encode(array('Success' => 'true','role' => $row['role'] ,'Msg' => $allLabelsArray[167])));


        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[152])));
        }
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[770])));
    }
}
if ($_GET['h'] == 'signup') {
//    if($_POST['g-recaptcha-response']=='')
//    {
//        die(json_encode(array('Success' => 'false', 'Msg' => 'Please select captcha.')));
//    }

    $_POST['n']['created_at'] = $current_time;
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


if ( $_GET[ 'h' ] == 'contact' ) {
    $msg='<strong>Name:</strong> '.$_POST['name'];
    $msg.='<br><strong>Email:</strong> '.$_POST['email'];
    $msg.='<br><strong>Message:</strong> '.$_POST['message'];

    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$main_domain.'superadmin/assets/images/our_canada.png" height="120" alt=""></th>
                     </tr>
                 </thead>

                 <tbody>
                 
                     <tr>
                         <td style="padding:0 24px 15px;color:#000;letter-spacing: 0.03em;line-height: 25px;">
                              <h3 sty;e="margin-top:!5px"></h3>
                               ' . $msg . '
                             
                         </td>
                     </tr>
                   
                   
                     <tr>
                         <td style="padding:16px 8px; color: #ffffff; background-color: #E50606; text-align: center;">
                             © 2021 OurCanada.co
                         </td>
                     </tr>
                 </tbody></table></body>
                                 </html>';
    $s['name']=$_POST['name'];
    $s['email']=$_POST['email'];
    $s['message']=$_POST['message'];
    $subject=$s['name'].' has contacted OurCanada Services';


    $T = db_pair_str2($s);

    $to='maryumakhter1@gmail.com';
    $to1='info@ourcanada.co';
    $to2='fnsheikh29@gmail.com';
    $to4='shahmutbahir@gmail.com';

    if(isset($_POST['name']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['email']) && isset($_POST['message']) && !empty($_POST['message']))
    {
        // sendgrid

        $emailObj = new \SendGrid\Mail\Mail();
        $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
        $emailObj->setSubject($subject);
        $emailObj->addTo($to4);
        $emailObj->addBcc($to);

//	$emailObj->addTo('fnsheikh29@gmail.com');


        // $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $emailObj->addContent(
            "text/html",
            $emailBody # html:body
        );

        $sendgrid = new \SendGrid($sendGridAPIKey);
        try {
            $response = $sendgrid->send($emailObj);
            $insert = mysqli_query($conn , "INSERT into contact SET $T");

            die(json_encode(array('Success' => 'true', 'Msg' =>$allLabelsArray[38])));

        } catch (Exception $e) {
            die(json_encode(array('Success' => 'false', 'Msg' =>$allLabelsArray[39])));

            // echo 'Caught exception: ' . $e->getMessage() . "\n";
        }

    }


}

?>