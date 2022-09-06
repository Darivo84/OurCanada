<?php

include 'user_inc.php';
require '../sendGrid/vendor/autoload.php';
mysqli_set_charset('utf8',$conn);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
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
    // return [$to,$sub,$body];
}


$allowTypesIMG = array('jpg','png','PNG','JPG','jpeg','ICO','ico');

// login module
if ( $_GET[ 'h' ] == 'checkemail' ) {

    $email =$_POST['email'];

    $checkQuery = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = mysqli_query($conn,$checkQuery);
    $outArr =  array();
    if(mysqli_num_rows($result) > 0)
    {
        $outArr['success'] = false;
        $outArr['msg'] = "$allLabelsArray[694]";

    }
    else
    {
        $outArr['success'] = true;
        $outArr['msg'] = "$allLabelsArray[695]";
    }
    echo json_encode($outArr);
}

if ( $_GET[ 'h' ] == 'signup' ) {
    unset($_POST['login']);
    $_POST['username'] = explode('@', $_POST['email'])[0];
    $_POST['created_at'] =date("M j,Y");

    $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $T = db_pair_str2( $_POST );




    $query = "INSERT INTO `users` SET $T";

    $result = mysqli_query($conn, $query);
    if($result)
    {
        die( json_encode( array( 'Success' => 'true', 'Msg' => $allLabelsArray[614] ) ) );
    }
    else
    {
        die( json_encode( array( 'Success' => 'false', 'Msg' => $allLabelsArray[218] ) ) );
    }
}
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
        die(json_encode(array('Success' => 'true','role'=>$row['role'], 'Msg' =>  $allLabelsArray[167])));
    }


}
if ($_GET['h'] == 'login') {

    $select = mysqli_query($conn, "SELECT * FROM users where email = '{$_POST['email']}'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);

        $verify = password_verify($_POST['password'], $row['password']);

        if ($verify) {

            $loggedUserId = $row['id'];

           // if( $row['is_logged'] == "0" || $row['is_logged'] == 0 || $row['role'] == "1" || $row['session_id'] == session_id() ||   empty($row['session_id'])  )
            {
                $_SESSION['user_id'] = $loggedUserId;
                $_SESSION['email'] = $row['email'];

                $_SESSION[ 'role' ] = 'user';
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

                die( json_encode( array( 'Success' => 'true', 'Msg' => $allLabelsArray[167] ) ) );
            }
//            else
//            {
//
//                $_SESSION['email'] = $row['email'];
//                die(json_encode(array('Success' => 'false', 'status' =>'1' ,'Msg' => $allLabelsArray[182])));
//            }

        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[152])));
        }
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[152])));
    }
}



if($_GET[ 'h' ] == 'forgot_password'){
    if(isset($_POST['email'])){
        $find = mysqli_query($conn,"SELECT * FROM users WHERE email = '".$_POST['email']."'");
        $row = mysqli_fetch_assoc($find);
        if(mysqli_num_rows($find) > 0){
            $_SESSION['recover_email'] = $_POST['email'];
            $randNum = rand(111111,999999).'';
            $_SESSION['recover_code'] = $randNum;


            $temps = mysqli_query($conn, "SELECT * FROM email_templates WHERE type = 'reset code'");
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
            $body='<h3>'.$greeting.'</h3> '.$msg.'<br><strong>'.$randNum.'</strong>';

            defaultMail($_POST['email'],'Confirmation code',$body);


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
//      print_r($_POST);
//      echo '<br><br>';
//      print_r($_SESSION);
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

        $temps = mysqli_query($conn, "SELECT * FROM email_templates WHERE type = 'reset code'");
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
        $body='<h3>'.$greeting.'</h3> '.$msg.'<br><strong>'.$randNum.'</strong>';

        defaultMail($_POST['email'],'Confirmation code',$body);

        // $body = '
        // <table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width:60%;margin:0 auto;border:1px solid #ccc">
        //           <thead>
        //               <tr style="background-color:#f7f7f7">
        //                   <th scope="col"><img src="'.$currentTheme.'/assets/img/logo.png" alt="" class="CToWUd" height="120"></th>
        //               </tr>
        //           </thead>

        //           <tbody>

        //               <tr>
        //                   <td style="padding:0 24px 15px;color:#000;letter-spacing:0.03em;line-height:25px">
        //                        <h3>Dear User,</h3>
        //                        Use this code <b>'.$randNum.'</b> to change your password.<b>Please do not share this code with anyone.</b><br>If you did not request to change password, ignore this E-mail
        //                   </td>
        //               </tr>
        //               <tr>
        //                   <td style="padding:15px 24px 15px;color:#8492a6">
        //                       OurCanada.com <br> Support Team
        //                   </td>
        //               </tr>

        //               <tr>
        //                   <td style="padding:16px 8px;color:#ffffff;background-color:#e50606;text-align:center">
        //                       © 2019-20 OurCanada.com
        //                   </td>
        //               </tr>
        //           </tbody></table>
        // ';
        // $body='  <h3>Dear User,</h3><br>Use this code <b>'.$randNum.'</b> to change your password.<b>Please do not share this code with anyone.</b><br>If you did not request to change password, ignore this E-mail';

        $check = defaultMail($_SESSION['recover_email'],'Confirmation code',$body);
        // $check = PHP_MAILER($_SESSION['recover_email'],"Confermation Code",$body);
        if($check){
            echo json_encode(['Success'=>'true','s'=>$_SESSION,'Msg'=>$allLabelsArray[575]]);
        }else{
            echo json_encode(['Success'=>'false','s'=>$_SESSION,'Msg'=>$allLabelsArray[571]]);
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
//      if($verify){
//          echo json_encode(['Success'=>'false','Msg'=>$allLabelsArray[771]]);
//      }else
        {


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



if ( $_GET[ 'h' ] == 'add_news' ) {






    $date = date("d M, yy h:i:sa");
    $_POST['user_id'] = $_SESSION['user_id'];
    $_POST[ 'created_date' ] = $date;
    $_POST['status'] = 0;
    $check_video = "";


    if($_POST['type'] != "simplenews")
    {



        $imgfgall =array();
        if(isset($_POST['galleryimgschecks']))
        {
            $imgfgall = $_POST['galleryimgschecks'];
        }

        for($i=0;$i<count($imgfgall);$i++)
        {
            $randpres = date("jS-YhisA");
            $fileName = $randpres.$imgfgall[$i];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

            if(in_array($fileExt,$allowTypesIMG))
            {
                $_POST['images'] .= $fileName.",";
                copy("uploads/gallery/".$imgfgall[$i],"uploads/images/".$fileName);
            }
            else
            {
                $_POST['videos'] .= $fileName.",";
                copy("uploads/gallery/".$imgfgall[$i],"uploads/videos/".$fileName);
            }
        }








        if(!empty($_FILES)){
            $file_counter = 0;
            foreach($_FILES['file']['name'] as $key=>$val){

                $filebaseName = basename($_FILES['file']['name'][$key]);
                $fileName = "";
                $fileType = pathinfo($filebaseName, PATHINFO_EXTENSION);

                if(in_array($fileType, $allowTypesIMG)){
                    $targetDir = $_SERVER['DOCUMENT_ROOT']."/uploads/images/";
                    $fileName = "img-".date("jS-YhisA").$file_counter.".".$fileType;


                    $targetFilePath = $targetDir . $fileName;
                    move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                    $_POST['images'] .= $fileName.",";
                } else{
                    $fileName = "vid-".date("jS-YhisA").$file_counter.".".$fileType;
                    $targetDir = $_SERVER['DOCUMENT_ROOT']."/uploads/videos/";
                    $targetFilePath = $targetDir . $fileName;
                    $check_video .= $targetFilePath.",";
                    move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                    $_POST['videos'] .= $fileName.",";
                }
                $file_counter++;
            }
        }
    }

    unset($_POST['galleryimgschecks']);
    $T = db_pair_str2( $_POST );
    $query = "INSERT INTO `news` SET $T";
    $result = mysqli_query($conn, $query);
    if ( $result ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => $allLabelsArray[477], 'vid' => $check_video ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => $allLabelsArray[469], 'vid' => $check_video ) ) );
    }
}


if ( $_GET[ 'h' ] == 'edit_news' )
{

    //   die( json_encode( array( 'Success' => 'false', 'Msg' => ' Some uncaught error exists', 'sql' => "", 'vid' => ""  ) ) );


    $sql = mysqli_query( $conn, "SELECT *  FROM `news` WHERE id ='{$_POST['id']}'" );
    $fetch = mysqli_fetch_assoc($sql);
    $check_video = "";
    $updated_images = $fetch['images'];
    $updated_videos = $fetch['videos'];



    if($_POST['type'] != "simplenews")
    {
        $imgfgall =array();
        if(isset($_POST['galleryimgschecks']))
        {
            $imgfgall = $_POST['galleryimgschecks'];
        }

        for($i=0;$i<count($imgfgall);$i++)
        {
            $randpres = date("jS-YhisA");
            $fileName = $randpres.$imgfgall[$i];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

            if(in_array($fileExt,$allowTypesIMG))
            {

                $_POST['images'] .= $fileName.",";
                copy("uploads/gallery/".$imgfgall[$i],"uploads/images/".$fileName);
            }
            else
            {
                $_POST['videos'] .= $fileName.",";
                copy("uploads/gallery/".$imgfgall[$i],"uploads/videos/".$fileName);
            }
        }








        if(!empty($_FILES)){
            $file_counter = 0;
            foreach($_FILES['file']['name'] as $key=>$val){




                $basefilename = basename($_FILES['file']['name'][$key]);
                $fileType = pathinfo($basefilename, PATHINFO_EXTENSION);

                $fileName = "";


                if(in_array($fileType, $allowTypesIMG)){

                    $fileName = "img-".date("jS-YhisA").$file_counter.".".$fileType;

                    $targetDir = $_SERVER['DOCUMENT_ROOT']."/uploads/images/";
                    $targetFilePath = $targetDir . $fileName;
                    move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                    $updated_images .= $fileName.",";
                } else{

                    $fileName = "vid-".date("jS-YhisA").$file_counter.".".$fileType;


                    $targetDir = $_SERVER['DOCUMENT_ROOT']."/uploads/videos/";
                    $targetFilePath = $targetDir . $fileName;
                    $check_video .= $targetFilePath.",";
                    move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                    $updated_videos .= $fileName.",";
                }
                $file_counter++;
            }
        }

    }

    $_POST['images'] = $updated_images.$_POST['images'];
    $_POST['videos'] = $updated_videos.$_POST['videos'];

    unset($_POST['galleryimgschecks']);

    $T = db_pair_str2( $_POST );
    $query = "UPDATE `news` SET $T where id='{$_POST['id']}'";

    $result = mysqli_query($conn, $query);
    if ( $result ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => $allLabelsArray[696], 'vid' => $check_video  ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => $allLabelsArray[632], 'vid' => $check_video  ) ) );
    }
}




if ( $_GET[ 'h' ] == 'del_file' ) {
    $filename = $_POST['filename'];
    $select_line = "SELECT * FROM `news` WHERE id = {$_POST['id']}";
    $res = mysqli_query($conn, $select_line);
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $updated_names = "";
    $row = mysqli_fetch_assoc($res);

    if(in_array($fileType, $allowTypesIMG)){
        $to_be_del_img = $_SERVER['DOCUMENT_ROOT']."/uploads/images/".$filename;
        if(unlink($to_be_del_img)){
            $imageNames = explode (",", $row['images']);
            $count = 0;
            while($count != (sizeof($imageNames)-1)){
                if($imageNames[$count] != $filename){
                    $updated_names .= $imageNames[$count].",";
                }
                $count++;
            }
            $query = "UPDATE `news` SET images = '{$updated_names}' WHERE id = {$_POST['id']}";
            $img_update = mysqli_query($conn, $query);
            die( json_encode( array( 'Success' => 'true', 'Msg' => $allLabelsArray[628], 'filepath' => $to_be_del_img, 'sql' => $query, 'filename' => $filename, 'type' => 'IMG') ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => $allLabelsArray[629], 'filepath' => $to_be_del_img, 'sql' => $query, 'filename' => $filename, 'type' => 'IMG') ) );
        }
    } else{
        $to_be_del_vid = $_SERVER['DOCUMENT_ROOT']."/uploads/videos/".$filename;
        if(unlink($to_be_del_vid)){
            $videoNames = explode (",", $row['videos']);
            $count = 0;
            while($count != (sizeof($videoNames)-1)){
                if($videoNames[$count] != $filename){
                    $updated_names .= $videoNames[$count].",";
                }
                $count++;
            }
            $query = "UPDATE `news` SET videos = '{$updated_names}' WHERE id = {$_POST['id']}";
            $vid_update = mysqli_query($conn, $query);
            die( json_encode( array( 'Success' => 'true', 'Msg' => $allLabelsArray[628], 'filepath' => $to_be_del_vid, 'filename' => $filename, 'type' => 'VID') ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => $allLabelsArray[629], 'filepath' => $to_be_del_vid, 'filename' => $filename, 'type' => 'VID') ) );
        }
    }
}


if ( $_GET[ 'h' ] == 'endsiable_news' )
{
    $newsId = $_GET[ 'news_id' ];
    $status = $_GET['status'];
    if(mysqli_query($conn,"UPDATE `news` SET `status` = '$status' WHERE `news`.`id` = '$newsId'"))
    {
        $_SESSION['newsstatus'] = "Yes";
    }
    else
    {
        $_SESSION['newsstatus'] = "No";
    }
    header("location:my-news");
}




if ( $_GET[ 'h' ] == 'AddView' ){
    if(isset($_POST['content_id'])){
        $content_id = $_POST['content_id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $check = mysqli_query($conn,"SELECT * FROM views WHERE (content_id = ".$content_id." && visitor_id = ".$_SESSION['user_id'].") || (content_id = ".$content_id." && visitor_ip = '".$ip."')");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO views (content_id,visitor_id,visitor_ip) VALUES(".$content_id.",".$_SESSION['user_id'].",'".$ip."')");
            }
        }else{
            $check = mysqli_query($conn,"SELECT * FROM views WHERE content_id = ".$content_id." && visitor_ip = '".$ip."'");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO views (content_id,visitor_ip) VALUES(".$content_id.",'".$ip."')");
            }
        }
        $getViews = mysqli_query($conn,"SELECT COUNT(*) as total FROM views WHERE content_id = ".$content_id);
        $views = mysqli_fetch_assoc($getViews);
        if(mysqli_num_rows($getViews) > 0){
            echo json_encode(['views'=>$views['total']]);
        }else{
            echo json_encode(['views'=>"0"]);
        }
    }
}

if ( $_GET[ 'h' ] == 'AddLike' ){
    if(isset($_POST['content_id'])){
        $content_id = $_POST['content_id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $check = mysqli_query($conn,"SELECT * FROM likes WHERE (content_id = ".$content_id." && visitor_id = ".$_SESSION['user_id'].") || (content_id = ".$content_id." && visitor_ip = '".$ip."')");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO likes (content_id,visitor_id) VALUES(".$content_id.",".$_SESSION['user_id'].")");
            }else{
                mysqli_query($conn,"DELETE FROM likes WHERE content_id = ".$content_id." && visitor_id = ".$_SESSION['user_id']);
            }
        }else{
            $check = mysqli_query($conn,"SELECT * FROM likes WHERE content_id = ".$content_id." && visitor_ip = '".$ip."'");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO likes (content_id,visitor_ip) VALUES(".$content_id.",'".$ip."')");
            }else{
                mysqli_query($conn,"DELETE FROM likes WHERE content_id = ".$content_id." && visitor_ip = '".$ip."'");
            }
        }
        $getViews = mysqli_query($conn,"SELECT COUNT(*) as total FROM likes WHERE content_id = ".$content_id);
        $views = mysqli_fetch_assoc($getViews);
        if(mysqli_num_rows($getViews) > 0){
            echo json_encode(['likes'=>$views['total']]);
        }else{
            echo json_encode(['likes'=>"SELECT COUNT(*) as total FROM likes WHERE content_id = ".$content_id]);
        }
    }
}

if( $_GET['h'] == 'GetLikes'){
    $content_id = $_POST['content_id'];
    $getViews = mysqli_query($conn,"SELECT COUNT(*) as total FROM likes WHERE content_id = ".$content_id);
    $views = mysqli_fetch_assoc($getViews);
    if(mysqli_num_rows($getViews) > 0){
        echo json_encode(['likes'=>$views['total']]);
    }else{
        echo json_encode(['likes'=>'0']);
    }
}

if($_GET['h'] == 'video_edit'){
    $filename = basename($_FILES["video_file_name"]["name"]);
    $targetDir = "uploads/images/";
    $targetFilePath = $targetDir . $filename;
    move_uploaded_file($_FILES["video_file_name"]["tmp_name"], $targetFilePath);
    echo json_encode(['file_path'=>$targetFilePath]);
}

if ( $_GET[ 'h' ] == 'comments' ){
    $saveLang = 'english';
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $saveLang = $_GET['lang'];
    }
    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && isset($_POST['comment']) && !empty($_POST['comment'])){
        $save = mysqli_query($conn,"INSERT INTO comments (user_id,content_id,comment,created_at,lang) VALUES(".$_SESSION['user_id'].",".$_GET['c_id'].",'".$_POST['comment']."','".$dueDatePST."','".$saveLang."')");
        if($save){
            $mail = CheckAndSendMail($conn,$_GET['c_id'],'content-uploads',$_POST['comment']);
            echo json_encode(['success'=>'success']);
        }else{
            echo json_encode(['error'=>'error']);
        }
    }else{
        echo json_encode(['error'=>$allLabelsArray[627]]);
    }
}

if ( $_GET[ 'h' ] == 'model_login' ) {

    $T = db_pair_str2( $_POST );
    $sql = "select * from `users` WHERE email='{$_POST['email']}'  ";
    $saveLang = 'english';
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $saveLang = $_GET['lang'];
    }
    $get_user = mysqli_query( $conn, $sql );

    if ( mysqli_num_rows( $get_user ) > 0 ) {
        $row = mysqli_fetch_assoc($get_user);
        $verify = password_verify($_POST['password'], $row['password']);
        if ($verify) {
            $_SESSION[ 'user_id' ] = $row['id'];
            $_SESSION[ 'role' ] = 'user';
            $loggedUserId=$_SESSION['user_id'];
            $select=mysqli_query($conn,"select * from user_sessions where user_id=$loggedUserId and session_id='".session_id()."'");
            if(mysqli_num_rows($select)>0)
            {

                mysqli_query($conn,"update user_sessions set ip_address='".getIPAddress()."',login_time='$current_time', is_logged=1 where user_id=$loggedUserId and session_id='".session_id()."'");
            }
            else
            {
                mysqli_query($conn,"insert into user_sessions (user_id,session_id,login_time,is_logged,ip_address) values ($loggedUserId,'".session_id()."','$current_time',1,'".getIPAddress()."')");
            }
            mysqli_query($conn,"UPDATE users SET last_login_time='$current_time',cookie='{$_COOKIE['PHPSESSID']}',is_logged = '1', `session_id` = '".session_id()."' WHERE id  = '{$row['id']}'");

            if(isset($_POST['comment']) && !empty($_POST['comment'])){
                $save = mysqli_query($conn,"INSERT INTO comments (user_id,content_id,comment,created_at,lang) VALUES(".$_SESSION['user_id'].",".$_POST['content_id'].",'".$_POST['comment']."','".$dueDatePST."','".$saveLang."')");
                $mail = CheckAndSendMail($conn,$_GET['c_id'],'news_content',$_POST['comment']);
                echo json_encode(['Success'=>'true','Msg' =>$allLabelsArray[539],'com'=>$save]);
            } else {
                echo json_encode(['Success'=>'false','Msg' =>$allLabelsArray[152],'com'=>$save]);
            }
        }else{
            echo json_encode(['Success'=>'false','Msg' =>$allLabelsArray[152]]);
        }

    }

}

if ( $_GET[ 'h' ] == 'model_login_reply' ) {

    $T = db_pair_str2( $_POST );
    $sql = "select * from `users` WHERE email='{$_POST['email']}' and password='{$_POST['password']}'  ";

    $get_user = mysqli_query( $conn, $sql );

    if ( mysqli_num_rows( $get_user ) > 0 ) {
        $user_row = mysqli_fetch_assoc( $get_user );
        $_SESSION[ 'user_id' ] = $user_row['id'];
        $_SESSION[ 'role' ] = 'user';
        $loggedUserId=$_SESSION['user_id'];
        $select=mysqli_query($conn,"select * from user_sessions where user_id=$loggedUserId and session_id='".session_id()."'");
        if(mysqli_num_rows($select)>0)
        {

            mysqli_query($conn,"update user_sessions set ip_address='".getIPAddress()."',login_time='$current_time', is_logged=1 where user_id=$loggedUserId and session_id='".session_id()."'");
        }
        else
        {
            mysqli_query($conn,"insert into user_sessions (user_id,session_id,login_time,is_logged,ip_address) values ($loggedUserId,'".session_id()."','$current_time',1,'".getIPAddress()."')");
        }
        mysqli_query($conn,"UPDATE users SET last_login_time='$current_time',cookie='{$_COOKIE['PHPSESSID']}',is_logged = '1', `session_id` = '".session_id()."' WHERE id  = '{$user_row['id']}'");

        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['login_err'=>'Failed to login']);
    }
}

if ( $_GET[ 'h' ] == 'getComments' ) {
    $select = "comments.id as c_id,comments.content_id as cont_id,comments.status as c_status,comments.comment as comment,DATE_FORMAT(comments.created_at,'%Y-%m-%d %H:%i:%s') as c_date,users.username as u_name,users.firstname as f_name,users.lastname as l_name,users.profileimg as profile,users.id as user_id";
    if(isset($_SESSION['user_id'])){
        $query1 = "SELECT ".$select." FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE content_id = ".$_POST['id']." && (comments.user_id = ".$_SESSION['user_id']." || comments.status = 1) ORDER BY comments.id ASC";
    }else{
        $query1 = "SELECT ".$select." FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE content_id = ".$_POST['id']." && status = 1 ORDER BY comments.id DESC";
    }
    $comments = mysqli_query($conn,$query1);
    $CommentsArray = [];
    while ($GetComment = mysqli_fetch_assoc($comments)) {

        $profilePIC = '';
        if(!empty($GetComment['profile'])){
            if(file_exists('profiles/'.$GetComment['profile'])){
                $profilePIC = $cms_url.'profiles/'.$GetComment['profile'];
            }else {
                $profilePIC = $default_profile;
                // $profilePIC = 'https://awards.ourcanadadev.site/profiles/'.$GetComment['profile'];
            }
        }else{
            $profilePIC = $default_profile;
        }

        $r_select = "comments_reply.id as c_id,comments_reply.content_id as cont_id,comments_reply.comment as comment,DATE_FORMAT(comments_reply.created_at,'%Y-%m-%d %H:%i:%s') as c_date,users.username as u_name,users.firstname as f_name,users.lastname as l_name,users.profileimg as profile,users.id as user_id";
        $reply = mysqli_query($conn,"SELECT ".$r_select." FROM comments_reply LEFT JOIN users ON comments_reply.user_id = users.id WHERE content_id = ".$GetComment['cont_id']." && comment_id = ".$GetComment['c_id']." ORDER BY comments_reply.id ASC");
        if(mysqli_num_rows($reply) > 0){
            $RepliesArray = [];
            while ($replies = mysqli_fetch_assoc($reply)) {
                $profilePicture = '';
                if(!empty($replies['profile'])){
                    if(file_exists('profiles/'.$replies['profile'])){
                        $profilePicture = $cms_url.'profiles/'.$replies['profile'];
                    }else {
                        $profilePicture = $default_profile;
                        // $profilePicture = 'https://awards.ourcanadadev.site/profiles/'.$replies['profile'];
                    }
                }else{
                    $profilePicture = $default_profile;
                }
                array_push($RepliesArray, [
                    'user_id' => $replies['user_id'],
                    'c_id' => $replies['c_id'],
                    'comment' => preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n",$replies['comment']),
                    'c_date' => time_ago($replies['c_date']),
                    'u_name' => $replies['u_name'],
                    'profile' => $profilePicture
                ]);
            }
            array_push($CommentsArray, [
                'user_id' => $GetComment['user_id'],
                'c_id' => $GetComment['c_id'],
                'comment' => preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n", $GetComment['comment']),
                'c_date' => time_ago($GetComment['c_date']),
                'u_name' => $GetComment['u_name'],
                'profile' => $profilePIC,
                'replies' => $RepliesArray,
                'status' => $GetComment['c_status']
            ]);
        }else{
            array_push($CommentsArray, [
                'user_id' => $GetComment['user_id'],
                'c_id' => $GetComment['c_id'],
                'comment' => preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n", $GetComment['comment']),
                'c_date' => time_ago($GetComment['c_date']),
                'u_name' => $GetComment['u_name'],
                'profile' => $profilePIC,
                'status' => $GetComment['c_status']
            ]);
        }
    }
    echo json_encode(['comments'=>$CommentsArray]);
}

if ( $_GET[ 'h' ] == 'CommentReply' ) {
    $saveLang = 'english';
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $saveLang = $_GET['lang'];
    }
    if(
        isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) &&
        isset($_POST['content_id']) && !empty($_POST['content_id']) &&
        isset($_POST['comment_id']) && !empty($_POST['comment_id']) &&
        isset($_POST['reply_comment']) && !empty($_POST['reply_comment'])
    ){
        $saveCom = mysqli_query($conn,"INSERT INTO comments_reply (content_id,comment_id,user_id,comment,created_at,lang) VALUES(".$_POST['content_id'].",".$_POST['comment_id'].",".$_SESSION['user_id'].",'".$_POST['reply_comment']."','".$dueDatePST."','".$saveLang."')");
        if($saveCom){
            echo json_encode(['success'=>$allLabelsArray[699]]);
        }else{
            echo json_encode(['error'=>$allLabelsArray[678]]);
        }
    }else{
        echo json_encode(['error'=>$allLabelsArray[701]]);
    }
}

if ( $_GET[ 'h' ] == 'CommentsCount' ) {
    $main = mysqli_query($conn,"SELECT COUNT(*) as main_total FROM comments WHERE content_id = ".$_POST['content_id']." && status = 1");
    $getCount = mysqli_fetch_assoc($main);
    $total = $getCount['main_total'];
    $reply = mysqli_query($conn,"SELECT COUNT(*) as reply_total FROM comments_reply WHERE content_id = ".$_POST['content_id']);
    $replyCount = mysqli_fetch_assoc($reply);
    $total += $replyCount['reply_total'];
    echo json_encode(['total'=>$total]);
}

if ( $_GET[ 'h' ] == 'PandingComments' ) {
    if(isset($_POST['content_id']) && !empty($_POST['content_id']) && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
        $getCom = mysqli_query($conn,"SELECT *,DATE_FORMAT(created_at,'%Y-%m-%d %H:%i:%s') as created_at FROM comments WHERE content_id = ".$_POST['content_id']." && user_id = ".$_SESSION['user_id']." && status = 0");
        $ComArray = [];
        while ($comRow = mysqli_fetch_assoc($getCom)) {
            array_push($ComArray, [
                'created_at' => $comRow['created_at'],
                'comment' => $comRow['comment'],
            ]);
        }
        if(count($ComArray) > 0){
            echo json_encode(['comments'=>$ComArray]);
        }else{
            echo json_encode(['error'=>$allLabelsArray[41]]);
        }
    }else{
        echo json_encode(['error'=>$allLabelsArray[41]]);
    }
}

function CheckTitle($conn,$id,$title,$table,$update,$slug){

    if($update){
        if($title[0] != $title[1]){
            $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE slug = '".$slug."'");
            // $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE replace(replace(title,'_',''),' ','') = '".str_replace(' ', '', str_repeat('_', '',$title[0]))."'");
            if(mysqli_num_rows($check) > 0){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }else{
        $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE slug = '".$slug."'");
        // $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE replace(replace(title,'_',''),' ','') = '".str_replace(' ', '', str_repeat('_', '',$title))."'");
        if(mysqli_num_rows($check) > 0){
            return false;
        }else{
            return true;
        }
    }
}

function GetTable($type){
    if(!empty($type)){
        if($type == 'news'){
            return ['table'=>'news_content'];
        }else if($type == 'blog'){
            return ['table'=>'blog_content'];
        }else{
            return ['error'=>$allLabelsArray[702]];
        }
    }else{
        return ['error'=>$allLabelsArray[703]];
    }
}

if ( $_GET[ 'h' ] == 'CreateUpdateSimpleBlog' ) {
    $table = GetTable($_POST['display_type']);

    $pars_lang = "";
    if(array_key_exists('table', $table)){
        if(isset($_POST['lang']) && !empty($_POST['lang'])){
            if($_POST['lang'] == 'french'){
                $_POST['lang'] = 'francais';
            }
            $pars_lang = '_'.$_POST['lang'];
            $table['table'] = $table['table'].'_'.$_POST['lang'];
        }
        unset($_POST['lang']);
        $reqStatus = false;
        $id = 0;
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
            $reqStatus = true;
        }
        $title = $_POST['title'];
        if(isset($_POST['old_title']) && !empty($_POST['old_title'])){
            $title = [$_POST['title'],$_POST['old_title']];
            unset($_POST['old_title']);
        }
        unset($_POST['id']);
        if(in_array($table['table'], ['blog_content','news_content']) && CheckTitle($conn,$id,$title,$table['table'],$reqStatus,$_POST['slug']) == false){
            echo json_encode(['error'=>$allLabelsArray[631]]);
        }else{
            $_POST['creator_id'] = $_SESSION['user_id'];
            $_POST['status'] = 0;
            $_POST['created_by'] = 0;
            $_POST['content_thumbnail'] = $_POST['thumbnail'];
            unset($_POST['display_type']);
            unset($_POST['thumbnail']);
            $_POST['video'] = str_replace('community/', '', $_POST['video']);
            $_POST['updated_at'] = $dueDatePST;
            if($reqStatus){
                unset($_POST['created_at']);
            }
            $T = db_pair_str2( $_POST );

            $used_images_table = '';
            if($table['table'] == 'news_content'.$pars_lang){
                $used_images_table = 'used_news_images'.$pars_lang;
            }
            if($table['table'] == 'blog_content'.$pars_lang){
                $used_images_table = 'used_blog_images'.$pars_lang;
            }


            if($reqStatus){
                $run = mysqli_query($conn,"UPDATE ".$table['table']." SET ".$T." WHERE id =".$id);

                $old_check = mysqli_query($conn,"SELECT * FROM ".$used_images_table." WHERE image = '".$_POST['content_thumbnail']."'");
                if(mysqli_num_rows($old_check) < 1){
                    $used_count = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$used_images_table);
                    $used_count_row = mysqli_fetch_assoc($used_count);
                    if($used_count_row['total'] >= 4){
                        mysqli_query($conn,"DELETE FROM ".$used_images_table." ORDER BY id ASC LIMIT 1");
                    }
                    mysqli_query($conn,"INSERT INTO ".$used_images_table." (image) VALUES('".$_POST['content_thumbnail']."')");
                }
            }else{
                $_POST['created_at'] = $dueDatePST;
                $T = db_pair_str2( $_POST );
                $used_count = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$used_images_table);
                $used_count_row = mysqli_fetch_assoc($used_count);
                if($used_count_row['total'] >= 4){
                    mysqli_query($conn,"DELETE FROM ".$used_images_table." ORDER BY id ASC LIMIT 1");
                }
                mysqli_query($conn,"INSERT INTO ".$used_images_table." (image) VALUES('".$_POST['content_thumbnail']."')");

                $run = mysqli_query($conn,"INSERT INTO ".$table['table']." SET ".$T);
            }

            if($run){
                if($reqStatus){
                    echo json_encode(['success'=>$allLabelsArray[633]]);
                }else{
                    echo json_encode(['success'=>$allLabelsArray[634]]);
                }
            }else{
                if($reqStatus){
                    echo json_encode(['error'=>$allLabelsArray[632]]);
                }else{
                    echo json_encode(['error'=>$allLabelsArray[704]]);
                }
            }
        }
    }else{
        echo json_encode(['error'=>$table['error']]);
    }
}

if ( $_GET[ 'h' ] == 'CreateUpdatePdfBlog' ) {
    $table = GetTable($_POST['display_type']);

    $pars_lang = "";
    if(array_key_exists('table', $table)){
        if(isset($_POST['lang']) && !empty($_POST['lang'])){
            if($_POST['lang'] == 'french'){
                $_POST['lang'] = 'francais';
            }
            $pars_lang = '_'.$_POST['lang'];
            $table['table'] = $table['table'].'_'.$_POST['lang'];
        }
        unset($_POST['lang']);
        $reqStatus = false;
        $id = 0;
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
            $reqStatus = true;
        }
        $title = $_POST['title'];
        if(isset($_POST['old_title']) && !empty($_POST['old_title'])){
            $title = [$_POST['title'],$_POST['old_title']];
            unset($_POST['old_title']);
        }
        unset($_POST['id']);
        if(in_array($table['table'], ['blog_content','news_content']) && CheckTitle($conn,$id,$title,$table['table'],$reqStatus,$_POST['slug']) == false){
            die(json_encode(['error'=>$allLabelsArray[631]]));
        }else{
            $_POST['creator_id'] = $_SESSION['user_id'];
            $_POST['status'] = 0;
            $_POST['created_by'] = 0;
            $_POST['content_thumbnail'] = $_POST['thumbnail'];
            unset($_POST['display_type']);
            unset($_POST['thumbnail']);
            $_POST['video'] = str_replace('community/', '', $_POST['video']);
            $_POST['updated_at'] = $dueDatePST;
            if($reqStatus){
                unset($_POST['created_at']);
            }
            if($id > 0){
                $pdfPath = '';
                if(isset($_FILES['pdf_file']) && !empty($_FILES['pdf_file']['name'])){
                    $pdf = PDFUpload($_FILES['pdf_file']);
                    if(array_key_exists('path', $pdf)){
                        $pdfPath = $pdf['path'];
                    }else{
                        die(json_encode(['error'=>$pdf['Msg']]));
                    }
                }
                if(!empty($pdfPath)){
                    $_POST['pdf_path'] = $pdfPath;
                }
            }else{ 
                $pdfPath = '';
                if(isset($_FILES['pdf_file']) && !empty($_FILES['pdf_file']['name'])){
                    $pdf = PDFUpload($_FILES['pdf_file']);
                    if(array_key_exists('path', $pdf)){
                        $pdfPath = $pdf['path'];
                    }else{
                        die(json_encode(['error'=>$pdf['Msg']]));
                    }
                }else{
                    die(json_encode(['error'=>$allLabelsArray[807]]));
                }

                $_POST['pdf_path'] = $pdfPath;
            }


            $T = db_pair_str2( $_POST );

            $used_images_table = '';
            if($table['table'] == 'news_content'.$pars_lang){
                $used_images_table = 'used_news_images'.$pars_lang;
            }
            if($table['table'] == 'blog_content'.$pars_lang){
                $used_images_table = 'used_blog_images'.$pars_lang;
            }


            if($reqStatus){
                $run = mysqli_query($conn,"UPDATE ".$table['table']." SET ".$T." WHERE id =".$id);

                $old_check = mysqli_query($conn,"SELECT * FROM ".$used_images_table." WHERE image = '".$_POST['content_thumbnail']."'");
                if(mysqli_num_rows($old_check) < 1){
                    $used_count = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$used_images_table);
                    $used_count_row = mysqli_fetch_assoc($used_count);
                    if($used_count_row['total'] >= 4){
                        mysqli_query($conn,"DELETE FROM ".$used_images_table." ORDER BY id ASC LIMIT 1");
                    }
                    mysqli_query($conn,"INSERT INTO ".$used_images_table." (image) VALUES('".$_POST['content_thumbnail']."')");
                }
            }else{
                $_POST['created_at'] = $dueDatePST;
                $T = db_pair_str2( $_POST );
                $used_count = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$used_images_table);
                $used_count_row = mysqli_fetch_assoc($used_count);
                if($used_count_row['total'] >= 4){
                    mysqli_query($conn,"DELETE FROM ".$used_images_table." ORDER BY id ASC LIMIT 1");
                }
                mysqli_query($conn,"INSERT INTO ".$used_images_table." (image) VALUES('".$_POST['content_thumbnail']."')");

                $run = mysqli_query($conn,"INSERT INTO ".$table['table']." SET ".$T);
            }

            if($run){
                if($reqStatus){
                    echo json_encode(['success'=>$allLabelsArray[633]]);
                }else{
                    echo json_encode(['success'=>$allLabelsArray[634]]);
                }
            }else{
                if($reqStatus){
                    echo json_encode(['error'=>$allLabelsArray[632]]);
                }else{
                    echo json_encode(['error'=>$allLabelsArray[704]]);
                }
            }
        }
    }else{
        echo json_encode(['error'=>$table['error']]);
    }
}


if ( $_GET[ 'h' ] == 'CreateUpdateVideoBlog' ) {
    $table = GetTable($_POST['display_type']);
    if(array_key_exists('table', $table)){
        if(isset($_POST['lang']) && !empty($_POST['lang'])){
            if($_POST['lang'] == 'french'){
                $_POST['lang'] = 'francais';
            }
            $table['table'] = $table['table'].'_'.$_POST['lang'];
        }
        unset($_POST['lang']);
        $reqStatus = false;
        $id = 0;
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
            $reqStatus = true;
        }

        $title = $_POST['title'];
        if(isset($_POST['old_title']) && !empty($_POST['old_title'])){
            $title = [$_POST['title'],$_POST['old_title']];
            unset($_POST['old_title']);
        }

        unset($_POST['id']);
        if(CheckTitle($conn,$id,$title,$table['table'],$reqStatus,$_POST['slug']) == false){
            echo json_encode(['error'=>$allLabelsArray[631]]);
        }else{
            $vid_err = '';
            $vid_path = '';
            if(isset($_FILES['videos'])){
                $video = VideoUpload($_FILES['videos']);
                if(array_key_exists('Msg', $video)){
                    $vid_err = $video['Msg'];
                }else{
                    $vid_path = $video['path'];
                }
            }

            if(isset($_FILES['thumbnail'])){
                $img = PhotoThumbnail($_FILES['thumbnail']);
                if(array_key_exists('Msg', $img)){
                    array_push($img_err,$img['Msg'].' Single IMG');
                }else{
                    $_POST['single_image'] = $img['path'];
                }
            }

            if(empty($vid_err)){
                $_POST['creator_id'] = $_SESSION['user_id'];
                $_POST['status'] = 0;
                $_POST['created_by'] = 0;
                if(isset($_FILES['videos'])){
                    $_POST['video'] = $vid_path;
                    unset($_POST['videos']);
                }else{
                    if(isset($_POST['videos']) && !empty($_POST['videos'])){
                        $_POST['video'] = $_POST['videos'];
                    }
                    unset($_POST['videos']);
                }

                unset($_POST['display_type']);
                $_POST['updated_at'] = $dueDatePST;
                if($reqStatus){
                    unset($_POST['created_at']);
                }
                $_POST['video'] = str_replace('community/', '', $_POST['video']);
                $T = db_pair_str2( $_POST );
                if($reqStatus){
                    $run = mysqli_query($conn,"UPDATE ".$table['table']." SET ".$T." WHERE id =".$id);
                }else{
                    $_POST['created_at'] = $dueDatePST;

                    $checkVID = explode('/', $_POST['video']);
                    if($checkVID[count($checkVID) - 1] == 'Wild animals name and sound.mp4'){
                        $_POST['single_image'] = 'video_thumbnail.png';
                        $_POST['content_thumbnail'] = 'video_thumbnail.png';
                    }

                    $T = db_pair_str2( $_POST );
                    $run = mysqli_query($conn,"INSERT INTO ".$table['table']." SET ".$T);
                }
                if($run){
                    if($reqStatus){
                        echo json_encode(['success'=>$allLabelsArray[633]]);
                    }else{
                        echo json_encode(['success'=>$allLabelsArray[634]]);
                    }
                }else{
                    if($reqStatus){
                        echo json_encode(['error'=>$allLabelsArray[632]]);
                    }else{
                        echo json_encode(['error'=>$allLabelsArray[704]]);
                    }
                }
            }else{
                echo json_encode(['error'=>$allLabelsArray[626]]);
            }
        }
    }else{
        echo json_encode(['error'=>$table['error']]);
    }
}


if ( $_GET[ 'h' ] == 'CreateUpdateImageSlider' ) {
    $table = GetTable($_POST['display_type']);
    if(array_key_exists('table', $table)){
        if(isset($_POST['lang']) && !empty($_POST['lang'])){
            if($_POST['lang'] == 'french'){
                $_POST['lang'] = 'francais';
            }
            $table['table'] = $table['table'].'_'.$_POST['lang'];
        }

        unset($_POST['lang']);
        $reqStatus = false;
        $id = 0;
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
            $reqStatus = true;
        }

        $title = $_POST['title'];
        if(isset($_POST['old_title']) && !empty($_POST['old_title'])){
            $title = [$_POST['title'],$_POST['old_title']];
            unset($_POST['old_title']);
        }

        unset($_POST['id']);
        if(CheckTitle($conn,$id,$title,$table['table'],$reqStatus,$_POST['slug']) == false){
            echo json_encode(['error'=>$allLabelsArray[631]]);
        }else{
            $img_err = [];
            $images = [];
            for ($i = 0; $i < count($_FILES['multi_images']['name']); $i++) {
                $img = MultiPhotoUpload($_FILES['multi_images']['type'][$i],$_FILES['multi_images']['name'][$i],$_FILES['multi_images']['size'][$i],$_FILES['multi_images']['tmp_name'][$i]);
                if(array_key_exists('Msg',$img)){
                    array_push($img_err,$img['Msg'].' IMG '.$i);
                }else{
                    array_push($images,$img['path']);
                }
            }

            if(isset($_FILES['image_single'])){
                $img = PhotoUpload($_FILES['image_single']);
                if(array_key_exists('Msg', $img)){
                    array_push($img_err,$img['Msg'].' Single IMG');
                }else{
                    $_POST['single_image'] = $img['path'];
                }
            }

            if(empty($_POST['slider_images'])){
                $_POST['slider_images'] = implode(',', $images);
            }else{
                $_POST['slider_images'] .= ",".implode(',', $images);
            }

            if(count($img_err) > 0){
                echo json_encode(['error'=>$allLabelsArray[635]]);
            }else{
                $_POST['creator_id'] = $_SESSION['user_id'];
                $_POST['status'] = 0;
                $_POST['created_by'] = 0;
                unset($_POST['display_type']);
                $_POST['updated_at'] = $dueDatePST;
                if($reqStatus){
                    unset($_POST['created_at']);
                }
                $T = db_pair_str2( $_POST );
                if($reqStatus){
                    $check_img = str_replace(' ', '', $_POST['slider_images']);
                    if(empty(str_replace(',', '', $check_img))){
                        die(json_encode(['error' => $allLabelsArray[576]]));
                        $run = false;
                    }else{
                        $run = mysqli_query($conn,"UPDATE ".$table['table']." SET ".$T." WHERE id =".$id);
                    }
                }else{
                    $_POST['created_at'] = $dueDatePST;
                    $T = db_pair_str2( $_POST );
                    $run = mysqli_query($conn,"INSERT INTO ".$table['table']." SET ".$T);
                }
                if($run){
                    if($reqStatus){
                        echo json_encode(['success'=>$allLabelsArray[633]]);
                    }else{
                        echo json_encode(['success'=>$allLabelsArray[634]]);
                    }
                }else{
                    if($reqStatus){
                        echo json_encode(['error'=>$allLabelsArray[632]]);
                    }else{
                        echo json_encode(['error'=>$allLabelsArray[704]]);
                    }
                }
            }
        }
    }else{
        echo json_encode(['error'=>$table['error']]);
    }
}


if ( $_GET[ 'h' ] == 'CreateUpdateImageVideoBlog' ) {
    $table = GetTable($_POST['display_type']);
    if(array_key_exists('table', $table)){
        if(isset($_POST['lang']) && !empty($_POST['lang'])){
            if($_POST['lang'] == 'french'){
                $_POST['lang'] = 'francais';
            }
            $table['table'] = $table['table'].'_'.$_POST['lang'];
        }
        unset($_POST['lang']);
        $reqStatus = false;
        $id = 0;
        if(isset($_POST['id']) && $_POST['id'] > 0){
            $id = $_POST['id'];
            $reqStatus = true;
        }

        $title = $_POST['title'];
        if(isset($_POST['old_title']) && !empty($_POST['old_title'])){
            $title = [$_POST['title'],$_POST['old_title']];
            unset($_POST['old_title']);
        }

        unset($_POST['id']);
        if(CheckTitle($conn,$id,$title,$table['table'],$reqStatus,$_POST['slug']) == false){
            echo json_encode(['error'=>$allLabelsArray[631]]);
        }else{
            $img_err = [];
            $images = [];
            for ($i = 0; $i < count($_FILES['multi_images']['name']); $i++) {
                $img = MultiPhotoUpload($_FILES['multi_images']['type'][$i],$_FILES['multi_images']['name'][$i],$_FILES['multi_images']['size'][$i],$_FILES['multi_images']['tmp_name'][$i]);
                if(array_key_exists('Msg',$img)){
                    array_push($img_err,$img['Msg'].' IMG '.$i);
                }else{
                    array_push($images,$img['path']);
                }
            }

            $vid_err = '';
            $embedVid = null;
            if(empty($_POST['video'])){
                if(!empty($_POST['embed'])){
                    $embedVid = $_POST['embed'];
                    unset($_POST['embed']);
                }else{
                    $video = VideoUpload($_FILES['single_video']);
                    if(array_key_exists('Msg',$video)){
                        $vid_err = $video['Msg'];
                    }else{
                        $_POST['video'] = $video['path'];
                    }
                }
            }


            if(empty($_POST['slider_images'])){
                $_POST['slider_images'] = implode(',', $images);
            }else{
                $_POST['slider_images'] .= ",".implode(',', $images);
            }

            if(count($img_err) > 0){
                echo json_encode(['error'=>$allLabelsArray[635]]);
            }else if(!empty($vid_err)){
                echo json_encode(['error'=>$allLabelsArray[626]]);
            }else{
                $_POST['creator_id'] = $_SESSION['user_id'];
                $_POST['status'] = 0;
                $_POST['created_by'] = 0;
                unset($_POST['display_type']);
                $_POST['updated_at'] = $dueDatePST;
                if($reqStatus){
                    unset($_POST['created_at']);
                }
                $_POST['embed'] = $embedVid;
                $T = db_pair_str2( $_POST );
                if($reqStatus){
                    $check_img = str_replace(' ', '', $_POST['slider_images']);
                    if(empty(str_replace(',', '', $check_img))){
                        die(json_encode(['error' => $allLabelsArray[576]]));
                        $run = false;
                    }else{

                        $run = mysqli_query($conn,"UPDATE ".$table['table']." SET ".$T." WHERE id = ".$id);
                    }
                }else{
                    $_POST['created_at'] = $dueDatePST;
                    $T = db_pair_str2( $_POST );
                    $run = mysqli_query($conn,"INSERT INTO ".$table['table']." SET ".$T);
                }
                if($run){
                    if($reqStatus){
                        echo json_encode(['success'=>$allLabelsArray[633]]);
                    }else{
                        echo json_encode(['success'=>$allLabelsArray[634]]);
                    }
                }else{
                    if($reqStatus){
                        echo json_encode(['error'=>$allLabelsArray[632]]);
                    }else{
                        echo json_encode(['error'=>$allLabelsArray[704]]);
                    }
                }
            }
        }
    }else{
        echo json_encode(['error'=>$table['error']]);
    }
}


function MultiPhotoUpload($type,$name,$size,$tmp){
    if(in_array($type, ['image/jpeg','image/jpg','image/png'])){
        $newfilename = date('dmYHis').str_replace(" ", "", basename($name));
        $check = move_uploaded_file($tmp, "./uploads/images/" . $newfilename);
        if($check){
            imageOptimizer('/uploads/images/' . $newfilename);
            return ['path'=>$newfilename];
        }else{
            return ['Msg'=>$allLabelsArray[637]];
        }
    }else{
        return ['Msg'=>$allLabelsArray[638]];
    }
}

function PhotoUpload($file){
    $_FILES['winner_photo'] = $file;
    if(isset($_FILES['winner_photo'])){
        if(count($_FILES['winner_photo']) > 1){
            if(in_array($_FILES['winner_photo']['type'], ['image/jpeg','image/jpg','image/png'])){
                // if($_FILES['winner_photo']['size'] >= 2097152){
                //     return ['Msg'=>"File must be less than 2 MB"];
                // }else{
                $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["winner_photo"]["name"]));
                $check = move_uploaded_file($_FILES["winner_photo"]["tmp_name"], "./uploads/images/" . $newfilename);
                if($check){
                    imageOptimizer('/uploads/images/' . $newfilename);

                    return ['path'=>$newfilename];
                }else{
                    return ['Msg'=>$allLabelsArray[637]];
                }
                // }
            }else{
                return ['Msg'=>$allLabelsArray[638]];
            }
        }else{
            return ['Msg'=>$allLabelsArray[636]];
        }
    }else{
        return ['Msg'=>$allLabelsArray[639]];
    }
}

function PDFUpload($file){
    $_FILES['pdf_file'] = $file;
    if(isset($_FILES['pdf_file'])){
        if(count($_FILES['pdf_file']) > 1){
            if(in_array($_FILES['pdf_file']['type'], ['application/pdf']) || $_FILES['pdf_file']['name'] == 'application/pdf'){
                $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["pdf_file"]["name"]));
                $check = move_uploaded_file($_FILES["pdf_file"]["tmp_name"], "./uploads/pdf_files/" . $newfilename);
                if($check){
                    return ['path'=>$newfilename];
                }else{
                    return ['Msg'=>$allLabelsArray[809]];
                }
            }else{
                return ['Msg'=>$allLabelsArray[810]];
            }
        }else{
            return ['Msg'=>$allLabelsArray[811]];
        }
    }else{
        return ['Msg'=>$allLabelsArray[809]];
    }
}

function PhotoThumbnail($file){
    $_FILES['winner_photo'] = $file;
    if(isset($_FILES['winner_photo'])){
        if(count($_FILES['winner_photo']) > 1){
            if(in_array($_FILES['winner_photo']['type'], ['image/jpeg','image/jpg','image/png'])){
                $ext = explode("/", $_FILES['winner_photo']['type']);
                $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["winner_photo"]["name"])).".".$ext[1];
                $check = move_uploaded_file($_FILES["winner_photo"]["tmp_name"], "./uploads/images/" . $newfilename);
                if($check){
                    imageOptimizer('/uploads/images/' . $newfilename);

                    return ['path'=>$newfilename];
                }else{
                    return ['Msg'=>$allLabelsArray[637]];
                }
            }else{
                return ['Msg'=>$allLabelsArray[638]];
            }
        }else{
            return ['Msg'=>$allLabelsArray[636]];
        }
    }else{
        return ['Msg'=>$allLabelsArray[639]];
    }
}

function PhotoUpload2($file){
    $imagePath = "profiles/";

    $_FILES['winner_photo'] = $file;
    if(isset($_FILES['winner_photo'])){

        if(count($_FILES['winner_photo']) > 0){

            if(in_array($_FILES['winner_photo']['type'], ['image/jpeg','image/jpg','image/png'])){
                // if($_FILES['winner_photo']['size'] >= 2097152){
                //     return ['Msg'=>"File must be less than 2 MB"];
                // }else
                $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["winner_photo"]["name"]));
                $check = move_uploaded_file($_FILES["winner_photo"]["tmp_name"], $imagePath . $newfilename);
                if($check){
                    imageOptimizer('/'.$imagePath . $newfilename);

                    return ['path'=>$newfilename];
                }else{
                    return ['Msg'=>$allLabelsArray[637]];
                }
                // }
            }else{
                return ['Msg'=>$allLabelsArray[638]];
            }
        }else{
            return ['Msg'=>$allLabelsArray[636]];
        }
    }else{
        return ['Msg'=>$allLabelsArray[639]];
    }
}

function VideoUpload($file){
    $_FILES['videos'] = $file;
    if(isset($_FILES['videos'])){
        if(count($_FILES['videos']) > 1){

            $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["videos"]["name"]));
            $check = move_uploaded_file($_FILES["videos"]["tmp_name"], "./uploads/videos/" . $newfilename);
            if($check){
//                            imageOptimizer('/uploads/videos/' . $newfilename);

                return ['path'=>$newfilename];
            }else{
                return ['Msg'=>$allLabelsArray[626]];
            }
        }else{
            return ['Msg'=>$allLabelsArray[641]];
        }
    }else{
        return ['Msg'=>$allLabelsArray[640]];
    }
}

if ( $_GET[ 'h' ] == 'AddNewsView' ){
    if(isset($_POST['content_id'])){
        $content_id = $_POST['content_id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $check = mysqli_query($conn,"SELECT * FROM news_views WHERE (content_id = ".$content_id." && visitor_id = ".$_SESSION['user_id'].") || (content_id = ".$content_id." && visitor_ip = '".$ip."')");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO news_views (content_id,visitor_id,visitor_ip) VALUES(".$content_id.",".$_SESSION['user_id'].",'".$ip."')");
            }
        }else{
            $check = mysqli_query($conn,"SELECT * FROM news_views WHERE content_id = ".$content_id." && visitor_ip = '".$ip."'");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO news_views (content_id,visitor_ip) VALUES(".$content_id.",'".$ip."')");
            }
        }

        $getViews = mysqli_query($conn,"SELECT COUNT(*) as total FROM news_views WHERE content_id = ".$content_id);
        $views = mysqli_fetch_assoc($getViews);
        if(mysqli_num_rows($getViews) > 0){
            $getUser = mysqli_query($conn,"SELECT * FROM news WHERE id = ".$content_id);
            $user_id = mysqli_fetch_assoc($getUser)['user_id'];

            $likes_limit = [10000000,7500000,5000000,2500000,1000000,100000,50000,25000,10000,5000,1000];
            $load = [];
            for ($i=0; $i < count($likes_limit); $i++) {
                // $views['total'] = 1000;
                if($views['total'] >= $likes_limit[$i]){
                    $check = mysqli_query($conn,"SELECT * FROM news_view_notify WHERE content_id = ".$content_id." && user_id = ".$user_id." && views >= ".$likes_limit[$i]);
                    if(mysqli_num_rows($check) < 1){
                        $res = mysqli_query($conn,"INSERT INTO news_view_notify (user_id,content_id,views) VALUES(".$user_id.",".$content_id.",'".$views['total']."')");
                        if($res){
                            array_push($load, SendViewMail($conn,$user_id,$views['total'],$content_id));
                        }
                    }
                }
            }

            echo json_encode(['views'=>$views['total'],'data'=>$load]);
        }else{
            echo json_encode(['views'=>"SELECT COUNT(*) as total FROM news_views WHERE content_id = ".$content_id]);
        }
    }
}

if ( $_GET[ 'h' ] == 'AddNewsLike' ){
    if(isset($_POST['content_id'])){
        $content_id = $_POST['content_id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
            $check = mysqli_query($conn,"SELECT * FROM news_likes WHERE (content_id = ".$content_id." && visitor_id = ".$_SESSION['user_id'].") || (content_id = ".$content_id." && visitor_ip = '".$ip."')");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO news_likes (content_id,visitor_id) VALUES(".$content_id.",".$_SESSION['user_id'].")");
            }else{
                mysqli_query($conn,"DELETE FROM news_likes WHERE content_id = ".$content_id." && visitor_id = ".$_SESSION['user_id']);
            }
        }else{
            $check = mysqli_query($conn,"SELECT * FROM news_likes WHERE content_id = ".$content_id." && visitor_ip = '".$ip."'");
            if(mysqli_num_rows($check) < 1){
                mysqli_query($conn,"INSERT INTO news_likes (content_id,visitor_ip) VALUES(".$content_id.",'".$ip."')");
            }else{
                mysqli_query($conn,"DELETE FROM news_likes WHERE content_id = ".$content_id." && visitor_ip = '".$ip."'");
            }
        }
        $getViews = mysqli_query($conn,"SELECT COUNT(*) as total FROM news_likes WHERE content_id = ".$content_id);
        $views = mysqli_fetch_assoc($getViews);
        if(mysqli_num_rows($getViews) > 0){
            echo json_encode(['likes'=>$views['total']]);
        }else{
            echo json_encode(['likes'=>"SELECT COUNT(*) as total FROM news_likes WHERE content_id = ".$content_id]);
        }
    }
}

if( $_GET['h'] == 'GetNewsLikes'){
    $content_id = $_POST['content_id'];
    $getViews = mysqli_query($conn,"SELECT COUNT(*) as total FROM news_likes WHERE content_id = ".$content_id);
    $views = mysqli_fetch_assoc($getViews);
    if(mysqli_num_rows($getViews) > 0){
        $getUser = mysqli_query($conn,"SELECT * FROM news WHERE id = ".$content_id);
        $user_id = mysqli_fetch_assoc($getUser)['user_id'];

        $likes_limit = [10000000,7500000,5000000,2500000,1000000,100000,50000,25000,10000,5000,1000];
        $load = [];
        for ($i=0; $i < count($likes_limit); $i++) {
            // $views['total'] = 1000;
            if($views['total'] >= $likes_limit[$i]){
                $check = mysqli_query($conn,"SELECT * FROM news_like_notify WHERE content_id = ".$content_id." && user_id = ".$user_id." && likes >= ".$likes_limit[$i]);
                if(mysqli_num_rows($check) < 1){
                    $res = mysqli_query($conn,"INSERT INTO news_like_notify (user_id,content_id,likes) VALUES(".$user_id.",".$content_id.",'".$views['total']."')");
                    if($res){
                        array_push($load, SendLikeMail($conn,$user_id,$views['total'],$content_id));
                    }
                }
            }
        }

        echo json_encode(['likes'=>$views['total'],'data'=>$load]);
    }else{
        echo json_encode(['likes'=>'0']);
    }
}

function SendLikeMail($conn,$id,$total,$content_id){
    $data = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$id);
    $res = mysqli_fetch_assoc($data);
    // return ['name'=>$res['username'],'email'=>$res['email'],'likes'=>$total];

    $postLink = mysqli_query($conn,"SELECT * FROM news_content WHERE id = ".$content_id);
    if(mysqli_num_rows($postLink) == 1){
        $to = $res['email'];
        $sub = "Likes Notification";
        $body = '<h1>Welcome '.$res['firstname'].' '.$res['lastname'].'</h1>';
        $body .= '<p>You got '.$total.' likes on your post.<br><a href="'.$cms_url.'news/'.$postLink['slug'].'">View Post</a></p>';
        $send_mail = PHP_MAILER($to,$sub,$body);
        // $send_mail = mail($to, $sub, $body, $headers);
        if (isset($send_mail)) {
            return true;
        } else {
            return false;
        }
    }
}

function SendViewMail($conn,$id,$total,$content_id){
    $data = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$id);
    $res = mysqli_fetch_assoc($data);
    // return ['name'=>$res['username'],'email'=>$res['email'],'likes'=>$total];
    $postLink = mysqli_query($conn,"SELECT * FROM news_content WHERE id = ".$content_id);
    if(mysqli_num_rows($postLink) == 1){
        $to = $res['email'];
        $sub = "Views Notification";
        $body = '<h1>Welcome '.$res['firstname'].' '.$res['lastname'].'</h1>';
        $body .= '<p>You got '.$total.' likes on your post.<br><a href="'.$cms_url.'news/'.$postLink['slug'].'">View Post</a></p>';
        $send_mail = PHP_MAILER($to,$sub,$body);
        // $send_mail = mail($to, $sub, $body, $headers);
        if (isset($send_mail)) {
            return true;
        } else {
            return false;
        }
    }
}


if ( $_GET[ 'h' ] == 'news_comments' ){
    $saveLang = 'english';
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $saveLang = $_GET['lang'];
    }
    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && isset($_POST['comment']) && !empty($_POST['comment'])){
        $save = mysqli_query($conn,"INSERT INTO news_comments (user_id,content_id,comment,created_at,lang) VALUES(".$_SESSION['user_id'].",".$_GET['c_id'].",'".$_POST['comment']."','".$dueDatePST."','".$saveLang."')");
        if($save){
            $mail = CheckAndSendMail($conn,$_GET['c_id'],'news_content',$_POST['comment']);
            echo json_encode(['success'=>'success','mail'=>$mail]);
        }else{
            echo json_encode(['error'=>'error']);
        }
    }else{
        echo json_encode(['error'=>$allLabelsArray[627]]);
    }
}

if ( $_GET[ 'h' ] == 'news_model_login' ) {

    $T = db_pair_str2( $_POST );
    $sql = "select * from `users` WHERE email='{$_POST['email']}'  ";
    $saveLang = 'english';
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $saveLang = $_GET['lang'];
    }
    $get_user = mysqli_query( $conn, $sql );

    if ( mysqli_num_rows( $get_user ) > 0 ) {
        $row = mysqli_fetch_assoc($get_user);
        $verify = password_verify($_POST['password'], $row['password']);
        if ($verify) {
            $_SESSION[ 'user_id' ] = $row['id'];
            $_SESSION[ 'role' ] = 'user';
            $loggedUserId=$_SESSION['user_id'];
            $select=mysqli_query($conn,"select * from user_sessions where user_id=$loggedUserId and session_id='".session_id()."'");
            if(mysqli_num_rows($select)>0)
            {

                mysqli_query($conn,"update user_sessions set ip_address='".getIPAddress()."',login_time='$current_time', is_logged=1 where user_id=$loggedUserId and session_id='".session_id()."'");
            }
            else
            {
                mysqli_query($conn,"insert into user_sessions (user_id,session_id,login_time,is_logged,ip_address) values ($loggedUserId,'".session_id()."','$current_time',1,'".getIPAddress()."')");
            }
            mysqli_query($conn,"UPDATE users SET last_login_time='$current_time',cookie='{$_COOKIE['PHPSESSID']}',is_logged = '1', `session_id` = '".session_id()."' WHERE id  = '{$row['id']}'");

            if(isset($_POST['comment']) && !empty($_POST['comment'])){
                $save = mysqli_query($conn,"INSERT INTO news_comments (user_id,content_id,comment,created_at,lang) VALUES(".$_SESSION['user_id'].",".$_POST['content_id'].",'".$_POST['comment']."','".$dueDatePST."','".$saveLang."')");
                $mail = CheckAndSendMail($conn,$_GET['c_id'],'news_content',$_POST['comment']);
                echo json_encode(['Success'=>'true','Msg' =>$allLabelsArray[539],'com'=>$save]);
            } else {
                echo json_encode(['Success'=>'false','Msg' =>$allLabelsArray[152],'com'=>$save]);
            }
        }else{
            echo json_encode(['Success'=>'false','Msg' =>$allLabelsArray[152]]);
        }

    }

    //
// $saveLang = 'english';
//       if(isset($_GET['lang']) && !empty($_GET['lang'])){
//         $saveLang = $_GET['lang'];
//       }
//       $T = db_pair_str2( $_POST );
//       $sql = "select * from `users` WHERE email='{$_POST['email']}' and password='{$_POST['password']}'  ";

//       $get_user = mysqli_query( $conn, $sql );

//       if ( mysqli_num_rows( $get_user ) > 0 ) {
//       $user_row = mysqli_fetch_assoc( $get_user );
//       $_SESSION[ 'user_id' ] = $user_row['id'];
//       $_SESSION[ 'role' ] = 'user';



//       if(isset($_POST['comment']) && !empty($_POST['comment'])){
//         $save = mysqli_query($conn,"INSERT INTO news_comments (user_id,content_id,comment,created_at,lang) VALUES(".$_SESSION['user_id'].",".$_POST['content_id'].",'".$_POST['comment']."','".$dueDatePST."','".$saveLang."')");
//           $mail = CheckAndSendMail($conn,$_POST['content_id'],'news_content',$_POST['comment']);
//           echo json_encode(['success' =>$allLabelsArray[539],'com'=>$save]);
//         } else {
//           echo json_encode(['error' =>$allLabelsArray[630],'com'=>$save]);
//         }
//       }else{
//         echo json_encode(['login_err'=>$allLabelsArray[698]]);
//       }

    //
}

if ( $_GET[ 'h' ] == 'news_getComments' ) {
    $select = "news_comments.id as c_id,news_comments.status as c_status,news_comments.content_id as cont_id,news_comments.comment as comment,DATE_FORMAT(news_comments.created_at,'%Y-%m-%d %H:%i:%s') as c_date,users.username as u_name,users.firstname as f_name,users.lastname as l_name,users.profileimg as profile,users.id as user_id";
    if(isset($_SESSION['user_id'])){
        $query1 = "SELECT ".$select." FROM news_comments LEFT JOIN users ON news_comments.user_id = users.id WHERE news_comments.content_id = ".$_POST['id']." && (news_comments.user_id = ".$_SESSION['user_id']." || news_comments.status = 1) ORDER BY news_comments.id ASC";
    }else{
        $query1 = "SELECT ".$select." FROM news_comments LEFT JOIN users ON news_comments.user_id = users.id WHERE news_comments.content_id = ".$_POST['id']." && news_comments.status = 1 ORDER BY news_comments.id DESC";
    }
    $comments = mysqli_query($conn,$query1);
    $CommentsArray = [];
    while ($GetComment = mysqli_fetch_assoc($comments)) {
        $profilePIC = '';
        if(!empty($GetComment['profile'])){
            if(file_exists('profiles/'.$GetComment['profile'])){
                $profilePIC = $cms_url.'profiles/'.$GetComment['profile'];
            }else {
                $profilePIC = $default_profile;
                // $profilePIC = 'https://awards.ourcanadadev.site/profiles/'.$GetComment['profile'];
            }
        }else{
            $profilePIC = $default_profile;
        }

        $r_select = "news_comments_reply.id as c_id,news_comments_reply.content_id as cont_id,news_comments_reply.comment as comment,DATE_FORMAT(news_comments_reply.created_at,'%Y-%m-%d %H:%i:%s') as c_date,users.username as u_name,users.firstname as f_name,users.lastname as l_name,users.profileimg as profile,users.id as user_id";
        $reply = mysqli_query($conn,"SELECT ".$r_select." FROM news_comments_reply LEFT JOIN users ON news_comments_reply.user_id = users.id WHERE news_comments_reply.content_id = ".$GetComment['cont_id']." && news_comments_reply.comment_id = ".$GetComment['c_id']." ORDER BY news_comments_reply.id ASC");
        if(mysqli_num_rows($reply) > 0){
            $RepliesArray = [];

            while ($replies = mysqli_fetch_assoc($reply)) {
                $profilePicture = '';
                if(!empty($GetComment['profile'])){
                    if(file_exists('profiles/'.$GetComment['profile'])){
                        $profilePicture = $cms_url.'profiles/'.$GetComment['profile'];
                    }else {
                        $profilePicture = $default_profile;
                        // $profilePicture = 'https://awards.ourcanadadev.site/profiles/'.$GetComment['profile'];
                    }
                }else{
                    $profilePicture = $default_profile;
                }
                array_push($RepliesArray, [
                    'user_id' => $replies['user_id'],
                    'c_id' => $replies['c_id'],
                    'comment' => preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n",$replies['comment']),
                    'c_date' => time_ago($replies['c_date']),
                    'u_name' => $replies['u_name'],
                    'profile' => $profilePicture,
                ]);
            }

            array_push($CommentsArray, [
                'user_id' => $GetComment['user_id'],
                'c_id' => $GetComment['c_id'],
                'comment' => preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n",$GetComment['comment']),
                'c_date' => time_ago($GetComment['c_date']),
                'u_name' => $GetComment['u_name'],
                'profile' => $profilePicture,
                'replies' => $RepliesArray,
                'status' => $GetComment['c_status']
            ]);
        }else{
            array_push($CommentsArray, [
                'user_id' => $GetComment['user_id'],
                'c_id' => $GetComment['c_id'],
                'comment' => preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n",$GetComment['comment']),
                'c_date' => time_ago($GetComment['c_date']),
                'u_name' => $GetComment['u_name'],
                'profile' => $profilePIC,
                'status' => $GetComment['c_status']
            ]);
        }
    }
    echo json_encode(['comments'=>$CommentsArray]);
}

if ( $_GET[ 'h' ] == 'news_CommentReply' ) {
    $saveLang = 'english';
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $saveLang = $_GET['lang'];
    }
    if(
        isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) &&
        isset($_POST['content_id']) && !empty($_POST['content_id']) &&
        isset($_POST['comment_id']) && !empty($_POST['comment_id']) &&
        isset($_POST['reply_comment']) && !empty($_POST['reply_comment'])
    ){
        $saveCom = mysqli_query($conn,"INSERT INTO news_comments_reply (content_id,comment_id,user_id,comment,created_at,lang) VALUES(".$_POST['content_id'].",".$_POST['comment_id'].",".$_SESSION['user_id'].",'".$_POST['reply_comment']."','".$dueDatePST."','".$saveLang."')");
        if($saveCom){
            echo json_encode(['success'=>$allLabelsArray[699]]);
        }else{
            echo json_encode(['error'=>$allLabelsArray[678]]);
        }
    }else{
        echo json_encode(['error'=>$allLabelsArray[701]]);
    }
}

if ( $_GET[ 'h' ] == 'news_CommentsCount' ) {
    $main = mysqli_query($conn,"SELECT COUNT(*) as main_total FROM news_comments WHERE content_id = ".$_POST['content_id']." && status = 1");
    $getCount = mysqli_fetch_assoc($main);
    $total = $getCount['main_total'];
    $reply = mysqli_query($conn,"SELECT COUNT(*) as reply_total FROM news_comments_reply WHERE content_id = ".$_POST['content_id']);
    $replyCount = mysqli_fetch_assoc($reply);
    $total += $replyCount['reply_total'];
    echo json_encode(['total'=>$total]);
}

if ( $_GET[ 'h' ] == 'news_PandingComments' ) {
    if(isset($_POST['content_id']) && !empty($_POST['content_id']) && isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
        $getCom = mysqli_query($conn,"SELECT *,DATE_FORMAT(created_at,'%Y-%m-%d %H:%i:%s') as created_at FROM news_comments WHERE content_id = ".$_POST['content_id']." && user_id = ".$_SESSION['user_id']." && status = 0");
        $ComArray = [];
        while ($comRow = mysqli_fetch_assoc($getCom)) {
            array_push($ComArray, [
                'created_at' => $comRow['created_at'],
                'comment' => $comRow['comment'],
            ]);
        }
        if(count($ComArray) > 0){
            echo json_encode(['comments'=>$ComArray]);
        }else{
            echo json_encode(['error'=>'no']);
        }
    }else{
        echo json_encode(['error'=>'no']);
    }
}

if ( $_GET[ 'h' ] == 'update_profile_pic' ) {
    if(isset($_FILES['user_profile_pic'])){
        $check = PhotoUpload2($_FILES['user_profile_pic']);
        if(array_key_exists('Msg', $check)){
            echo json_encode(['Msg'=>$check['Msg']]);
        }else{
            $updateUser = mysqli_query($conn,"UPDATE users SET profileimg = '".$check['path']."' WHERE id = ".$_SESSION['user_id']);
            if($updateUser){
                echo json_encode(['Success'=>$allLabelsArray[643]]);
            }else{
                echo json_encode(['Msg'=>$allLabelsArray[645]]);
            }
        }
    }else{
        echo json_encode(['Msg'=>$allLabelsArray[705]]);
    }
}

if ( $_GET[ 'h' ] == 'updateProfile' ) {
    unset($_POST['send']);
    $c = mysqli_query($conn,"SELECT * FROM users WHERE id != ".$_SESSION['user_id']." && username = '".$_POST['username']."'");
    if(mysqli_num_rows($c) > 0){
        echo json_encode(['Msg'=>$allLabelsArray[727]]);
    }else{
        $T = db_pair_str2( $_POST );
        $query = "UPDATE users SET $T WHERE id = ".$_SESSION['user_id'];
        $check = mysqli_query($conn,$query);
        if($check){
            echo json_encode(['Success'=>$allLabelsArray[644]]);
        }else{
            echo json_encode(['Msg'=>$allLabelsArray[646]]);
        }
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
                $verify_newPass = password_verify($_POST['password'], $row['password']);

//                if($verify_newPass)
//                {
//                    die(json_encode(array('Success' => 'false', 'Msg' => $allLabelsArray[771])));
//                }

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

if ( $_GET[ 'h' ] == 'deletePhoto' ) {
    $res = mysqli_query($conn,"UPDATE users SET profileimg = null WHERE id = ".$_SESSION['user_id']);
    if($res){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}


function SendMail($res) {

    $to = $res['creator_email'];

    $sub = "Notification";

    $body = '<h1>Welcome '.$res['creator_name'].'</h1>';
    $body .= '<p>'.$res['user_name'].' Comment on your post.<br><b>Comment:</b> '.$res['user_comment'].'</p>';

    $send_mail = PHP_MAILER($to,$sub,$body);
    // $send_mail = mail($to, $sub, $body, $headers);

    if (isset($send_mail)) {

        return true;

    } else {

        return false;

    }

}

function CheckAndSendMail($conn,$content_id,$table,$comment){
    // return [$content_id,$table,$comment];
    // Fetch post(blog / news)
    $post = mysqli_query($conn,"SELECT * FROM `".$table."` WHERE id = ".$content_id);
    // If post exists
    if(mysqli_num_rows($post) > 0){

        // Storing post data
        $postRow = mysqli_fetch_assoc($post);
        // Check if post creator & commment user id is not same
        if($postRow['creator_id'] != $_SESSION['user_id']){

            // Fetch creator info
            $creatorInfo = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$postRow['creator_id']);
            // If Creator exist
            if(mysqli_num_rows($creatorInfo) > 0){

                // Storing creator info
                $creatorRow = mysqli_fetch_assoc($creatorInfo);
                // Fetech commented user info
                $userInfo = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$_SESSION['user_id']);
                // If commented user exist
                if(mysqli_num_rows($userInfo) > 0){

                    // Storing user info
                    $userRow = mysqli_fetch_assoc($userInfo);
                    // Setting the required values for sending email

                    $res = [
                        'creator_name' => $creatorRow['firstname'].' '.$creatorRow['lastname'],
                        'creator_email' => $creatorRow['email'],
                        'user_name' => $userRow['firstname'].' '.$userRow['lastname'],
                        'user_email' => $userRow['email'],
                        'user_comment' => $comment
                    ];
                    // Sending Email
                    return SendMail($res);
                }
            }
        }
    }
}

if ( $_GET[ 'h' ] == 'refer_friend_login_modal' ) {

    $T = db_pair_str2( $_POST );
    $sql = "select * from `users` WHERE email='{$_POST['email']}' and password='{$_POST['password']}'  ";

    $get_user = mysqli_query( $conn, $sql );

    if ( mysqli_num_rows( $get_user ) > 0 ) {
        $user_row = mysqli_fetch_assoc( $get_user );
        $_SESSION[ 'user_id' ] = $user_row['id'];
        $_SESSION[ 'role' ] = 'user';
        mysqli_query($conn,"UPDATE users SET last_login_time='$current_time','{$_COOKIE['PHPSESSID']}',is_logged = '1' WHERE id  = '{$user_row['id']}'");
        mysqli_query($conn,"UPDATE users SET last_login_time='$current_time',cookie='{$_COOKIE['PHPSESSID']}',is_logged = '1', `session_id` = '".session_id()."' WHERE id  = '{$user_row['id']}'");

        die(json_encode($user_row['id']));
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['login_err'=>$allLabelsArray[698]]);
    }
}

if ( $_GET[ 'h' ] == 'UpdateSimpleContent' ) {
    $old_slug = $_POST['old_slug'];
    unset($_POST['old_slug']);
    $T = db_pair_str2( $_POST );
    $update = mysqli_query($conn,"UPDATE news SET ".$T." WHERE slug = '".$old_slug."'");
    if($update){
        echo json_encode(["success"=>$allLabelsArray[633]]);
    }else{
        echo json_encode(["error"=>$allLabelsArray[632]]);
    }
}

if ( $_GET[ 'h' ] == 'UpdateVideoContent' ) {

    $go = true;

    if(isset($_FILES['single_video'])){
        $vid = VideoUpload($_FILES['single_video']);
        if(array_key_exists('path', $vid)){
            $_POST['videos'] = $vid['path'];
        }else{
            $go = false;
        }
    }
    if($go){
        $old_slug = $_POST['old_slug'];
        unset($_POST['old_slug']);
        unset($_FILES['single_video']);

        $T = db_pair_str2( $_POST );
        $update = mysqli_query($conn,"UPDATE news SET ".$T." WHERE slug = '".$old_slug."'");
        if($update){
            echo json_encode(["success"=>"Content updated."]);
        }else{
            echo json_encode(["error"=>"UPDATE news SET ".$T." WHERE slug = '".$old_slug."'"]);
        }
    }
}

if ( $_GET[ 'h' ] == 'delete_my_comment' ) {
    $check = mysqli_query($conn,"DELETE FROM news_comments WHERE id = ".$_POST['id']);
    if($check){
        mysqli_query($conn,"DELETE FROM news_comments_reply WHERE comment_id = ".$_POST['id']);
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error'."DELETE FROM news_comments WHERE id = ".$_POST['id']]);
    }
}

if ( $_GET[ 'h' ] == 'update_comment' ) {
    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $check = mysqli_query($conn,"UPDATE news_comments SET comment = '".$comment."',status = 0 WHERE id = ".$id);
    if($check){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}

if ( $_GET[ 'h' ] == 'reply_delete_my_comment' ) {
    $check = mysqli_query($conn,"DELETE FROM news_comments_reply WHERE id = ".$_POST['id']);
    if($check){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error'."DELETE FROM news_comments WHERE id = ".$_POST['id']]);
    }
}

if ( $_GET[ 'h' ] == 'reply_update_comment' ) {
    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $check = mysqli_query($conn,"UPDATE news_comments_reply SET comment = '".$comment."' WHERE id = ".$id);
    if($check){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}


//
if ( $_GET[ 'h' ] == 'delete_my_comment_blog' ) {
    $check = mysqli_query($conn,"DELETE FROM comments WHERE id = ".$_POST['id']);
    if($check){
        mysqli_query($conn,"DELETE FROM comments_reply WHERE comment_id = ".$_POST['id']);
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error'."DELETE FROM comments WHERE id = ".$_POST['id']]);
    }
}

if ( $_GET[ 'h' ] == 'update_comment_blog' ) {
    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $check = mysqli_query($conn,"UPDATE comments SET comment = '".$comment."',status = 0 WHERE id = ".$id);
    if($check){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}

if ( $_GET[ 'h' ] == 'reply_delete_my_comment_blog' ) {
    $check = mysqli_query($conn,"DELETE FROM comments_reply WHERE id = ".$_POST['id']);
    if($check){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error'."DELETE FROM comments WHERE id = ".$_POST['id']]);
    }
}

if ( $_GET[ 'h' ] == 'reply_update_comment_blog' ) {
    $id = $_POST['id'];
    $comment = $_POST['comment'];
    $check = mysqli_query($conn,"UPDATE comments_reply SET comment = '".$comment."' WHERE id = ".$id);
    if($check){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}

if($_GET['h'] == 'deleteContent'){
    $table = $_POST['table'];
    $pars_lang = "";
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $pars_lang = "_".$_GET['lang'];
    }
    unset($_POST['table']);

    $q = mysqli_query($conn,"SELECT * FROM ".$table." WHERE id = ".$_POST['id']);
    $r = mysqli_fetch_assoc($q);
    if($table == 'news_content'){
        mysqli_query($conn,"DELETE FROM used_news_images".$pars_lang." WHERE image = '".$r['content_thumbnail']."'");
    }else{
        mysqli_query($conn,"DELETE FROM used_blog_images".$pars_lang." WHERE image = '".$r['content_thumbnail']."'");
    }

    $del = mysqli_query($conn,"DELETE FROM ".$table." WHERE id = ".$_POST['id']);
    if($del){
        if($table == 'news_content'){
            mysqli_query($conn,"DELETE FROM news_comments WHERE content_id = ".$_POST['id']);
            mysqli_query($conn,"DELETE FROM news_comments_reply WHERE content_id = ".$_POST['id']);
        }else{
            mysqli_query($conn,"DELETE FROM comments WHERE content_id = ".$_POST['id']);
            mysqli_query($conn,"DELETE FROM comments_reply WHERE content_id = ".$_POST['id']);
        }
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}

function imageOptimizer($path)
{
    $quality=70;
    global $base_dir,$base_url;
    $path='/var/www/html/ourcanada.co/community'.$path;

    $source_url=$destination_url=urldecode($path);
    $originalSize=filesize($source_url);
    //echo "not working"; exit();
    $info = getimagesize($source_url);
    $fileName=basename($source_url);
//    echo $source_url;
//			print_r($info);
//        exit();
    if ($info['mime'] == 'image/jpeg')
    {
        $image = imagecreatefromjpeg($source_url);
        //save file
        imagejpeg($image, $destination_url, $quality);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
        //Free up memory
        imagedestroy($image);
    }elseif ($info['mime'] == 'image/png')
    {

//               file_put_contents($destination_url, compress_png($source_url));

        $image = imagecreatefrompng($source_url);
        //save file
        imagepng($image, $destination_url, 9);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
//                //Free up memory
        imagedestroy($image);

    }

    //return destination file
    if(file_exists($destination_url))
    {
        clearstatcache();
        $reduceSize=filesize($destination_url);
        $reduced=(100-($reduceSize/$originalSize*100));
        $reduced=number_format($reduced, 2, '.', '');
        $info=array("error"=>0,"originalFile"=>$path,"destinationFile"=>str_replace($base_dir,"",$destination_url),"originalSize"=>human_filesize($originalSize),"reduceSize"=>human_filesize($reduceSize),"reduced"=>$reduced,"name"=>$fileName);
    }else
    {
        $info=array("error"=>1,"system failed to optimize file!");
    }

//   echo json_encode($info);
    // exit;
}
function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

?>
