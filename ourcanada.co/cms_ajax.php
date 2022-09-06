<?php

include 'user_inc.php';
require 'sendGrid/vendor/autoload.php';
mysqli_set_charset('utf8',$conn);

$sendGridAPIKey='';
if($ext=='.app')
{
    $sendGridAPIKey="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";

}
else
{
    $sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada

}
function defaultMail($email, $subject, $body)
{
    global $sendGridAPIKey,$align_class,$currentTheme,$ext;
    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$currentTheme.'/assets/img/logo.png" height="120" alt=""></th>
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
//
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
        return true;

    } catch (Exception $e) {
        // echo 'Caught exception: ' . $e->getMessage() . "\n";
        return false;
    }

}


function removedupfromcommasepratestring($dep) {
    return implode(',', array_keys(array_flip(explode(',', $dep))));
}

function PHP_MAILER($to,$sub,$body){
    return defaultMail($to,$sub,$body);

}


$allowTypesIMG = array('jpg','png','PNG','JPG','jpeg','ICO','ico');

// login module



if($_GET[ 'h' ] == 'forgot_password'){
    if(isset($_POST['email'])){
        $find = mysqli_query($conn,"SELECT * FROM users WHERE email = '".$_POST['email']."'");
        $row = mysqli_fetch_assoc($find);
        if(mysqli_num_rows($find) > 0){
            $_SESSION['recover_email'] = $_POST['email'];
            $randNum = rand(111111,999999).'';
            $_SESSION['recover_code'] = $randNum;
            $body = '
        <table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width:60%;margin:0 auto;border:1px solid #ccc">
                  <thead>
                      <tr style="background-color:#f7f7f7">
                          <th scope="col"><img src="'.$currentTheme.'/assets/img/logo.png" alt="" class="CToWUd" height="120"></th>
                      </tr>
                  </thead>

                  <tbody>
                     
                      <tr>
                          <td style="padding:0 24px 15px;color:#000;letter-spacing:0.03em;line-height:25px">
                               <h3>Dear User,</h3>
                               Use this code <b>'.$randNum.'</b> to change your password.<b>Please do not share this code with anyone.</b><br>If you did not request to change password, ignore this E-mail
                          </td>
                      </tr>
                      <tr>
                          <td style="padding:15px 24px 15px;color:#8492a6">
                              OurCanada.com <br> Support Team
                          </td>
                      </tr>

                      <tr>
                          <td style="padding:16px 8px;color:#ffffff;background-color:#e50606;text-align:center">
                              © 2019-20 OurCanada.com
                          </td>
                      </tr>
                  </tbody></table>
        ';
            //PHP_MAILER($_POST['email'],"Confermation Code",$body);

            $body='  <h3>Dear User,</h3><br>Use this code <b>'.$randNum.'</b> to change your password.<b>Please do not share this code with anyone.</b><br>If you did not request to change password, ignore this E-mail';

            //defaultMail($_POST['email'],'Confirmation code',$body);


            $_SESSION['one_time_msg'] = $allLabelsArray[575];
            echo json_encode(['Success'=>'true','s'=>$_SESSION,'Msg'=>$allLabelsArray[575]]);
        }else{
            echo json_encode(['Success'=>'false','s'=>$_SESSION,'Msg'=>$allLabelsArray[619]]);
        }
    }else{
        echo json_encode(['Msg'=>$allLabelsArray[621]]);
    }
}

if($_GET[ 'h' ] == 'verify'){
    session_start();
    print_r($_POST);
    echo '<br><br>';
    print_r($_SESSION);
    if(isset($_POST['code'])){
        if($_POST['code'] == $_SESSION['recover_code']){
            $_SESSION['change_password'] = true;
            echo json_encode(['Success'=>'true']);
        }else{
            echo json_encode(['Success'=>'false','Msg'=>$allLabelsArray[620]]);
        }
    }else{
        echo json_encode(['Msg'=>$allLabelsArray[618]]);
    }
}

if($_GET[ 'h' ] == 're_send_code'){

    if(isset($_SESSION['recover_code']) && isset($_SESSION['recover_email'])){
        $randNum = rand(111111,999999);
        $_SESSION['recover_code'] = $randNum;
        $body = '
      <table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width:60%;margin:0 auto;border:1px solid #ccc">
                <thead>
                    <tr style="background-color:#f7f7f7">
                        <th scope="col"><img src="'.$currentTheme.'/assets/img/logo.png" alt="" class="CToWUd" height="120"></th>
                    </tr>
                </thead>

                <tbody>
                   
                    <tr>
                        <td style="padding:0 24px 15px;color:#000;letter-spacing:0.03em;line-height:25px">
                             <h3>Dear User,</h3>
                             Use this code <b>'.$randNum.'</b> to change your password.<b>Please do not share this code with anyone.</b><br>If you did not request to change password, ignore this E-mail
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px 24px 15px;color:#8492a6">
                            OurCanada.com <br> Support Team
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 8px;color:#ffffff;background-color:#e50606;text-align:center">
                            © 2019-20 OurCanada.com
                        </td>
                    </tr>
                </tbody></table>
      ';
        $body='  <h3>Dear User,</h3><br>Use this code <b>'.$randNum.'</b> to change your password.<b>Please do not share this code with anyone.</b><br>If you did not request to change password, ignore this E-mail';
        $check = defaultMail($_SESSION['recover_email'],'Confirmation code',$body);
        // $check = PHP_MAILER($_SESSION['recover_email'],"Confermation Code",$body);
        if($check){
            echo json_encode(['Success'=>'true']);
        }else{
            echo json_encode(['Success'=>'false']);
        }
    }else{
        echo json_encode(['Success'=>'false']);
    }
}


if($_GET[ 'h' ] == 'change_password'){
    if(isset($_POST['password'])){
        $getuser = mysqli_query($conn,"SELECT * FROM users WHERE email = '".$_SESSION['recover_email']."'");
        $pas = mysqli_fetch_assoc($getuser)['password'];
        $verify = password_verify($_POST['password'], $pas);
        if($verify){
            echo json_encode(['Success'=>'false','Msg'=>$allLabelsArray[622]]);
        }else{
            $new_pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $update = mysqli_query($conn,"UPDATE users SET password = '".$new_pass."' WHERE email = '".$_SESSION['recover_email']."'");
            if($update){
                unset($_SESSION['recover_email']);
                unset($_SESSION['change_password']);
                unset($_SESSION['recover_code']);
                echo json_encode(['Success'=>'true','Msg'=>$allLabelsArray[266]]);
            }else{
                echo json_encode(['Success'=>'false','Msg'=>$allLabelsArray[623]]);
            }
        }
    }else{
        echo json_encode(['Success'=>'false','Msg'=>$allLabelsArray[624]]);
    }
}


if ( $_GET[ 'h' ] == 'changePassword' ) {
    // die(json_encode($_POST));
    if(isset($_POST['password']) && isset($_POST['old_password'])){
        $check = mysqli_query($conn,"SELECT * FROM users WHERE id = '".$_SESSION['user_id']."'");
        if(mysqli_num_rows($check) > 0 ){
            $row = mysqli_fetch_assoc($check);
            $verify = password_verify($_POST['old_password'], $row['password']);
            if ($verify) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $update = mysqli_query($conn, "UPDATE users SET password = '" . $password . "' WHERE id = " . $_SESSION['user_id']);
                if($update){
                    echo json_encode(['Success'=>$allLabelsArray[647]]);
                }else{
                    echo json_encode(['Msg'=>$allLabelsArray[648]]);
                }
            }else{
                echo json_encode(['Msg'=>$allLabelsArray[649]]);
            }
        }else{
            echo json_encode(['Msg'=>$allLabelsArray[649]]);
        }
    }else{
        echo json_encode(['Msg'=>$allLabelsArray[624]]);
    }
}




?>
