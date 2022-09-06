<?php
include 'global.php';
mysqli_set_charset('utf8',$conn);

$blog_content_list = [
    'blog_content',
    'blog_content_chinese',
    'blog_content_francais',
    'blog_content_hindi',
    'blog_content_punjabi',
    'blog_content_spanish',
    'blog_content_urdu',
    'blog_content_arabic'
];

$news_content_list = [
    'news_content',
    'news_content_chinese',
    'news_content_francais',
    'news_content_hindi',
    'news_content_punjabi',
    'news_content_spanish',
    'news_content_urdu',
    'news_content_arabic'
];
require_once 'excelClass/PHPExcel.php';
require '/var/www/html/immigration.ourcanada'.$ext.'/send-grid-email/vendor/autoload.php';
$sendGridAPIKey='';
if($ext=='.app')
{
    $sendGridAPIKey="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";

}
else
{
    $sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada

}

$default_url = $_SERVER['HTTP_HOST'];
function removedupfromcommasepratestring($dep) {
    return implode(',', array_keys(array_flip(explode(',', $dep))));
}
$awardsUrl = 'https://awards.' . $_SERVER['HTTP_HOST'] . '/';
$adminUrl = 'https://'.$_SERVER['HTTP_HOST'] . '/superadmin/';

$current_date=date('Y-m-d h:i:s');

$allowTypesIMG = array('jpg','png','PNG','JPG','jpeg','ICO','ico');


if ( $_GET[ 'h' ] == 'login' ) {
    $T = db_pair_str2( $_POST );
    $sql = "select * from `admin` WHERE email='{$_POST['username']}' and password='{$_POST['password']}'  ";
    $get_admin = mysqli_query( $conn, $sql );
    if ( mysqli_num_rows( $get_admin ) > 0 ) {
        $admin_row = mysqli_fetch_assoc( $get_admin );
        $_SESSION[ 'userID' ] = $admin_row[ 'id' ];
        $_SESSION[ 'role' ] = 'admin';
        mysqli_query($conn,"UPDATE admin SET cookie='{$_COOKIE['PHPSESSID']}', is_logged = 1 WHERE id  = {$_SESSION[ 'userID' ]}");

        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Login Successfully' ) ) );
    } elseif( mysqli_num_rows( $get_admin ) == 0){
        $moderator_query = "select * from `moderator` WHERE email='{$_POST['username']}' and password='{$_POST['password']}'  ";
        $get_moderator = mysqli_query( $conn, $moderator_query );
        if(mysqli_num_rows($get_moderator) > 0){
            $moderator_row = mysqli_fetch_assoc( $get_moderator );
            $_SESSION[ 'userID' ] = $moderator_row[ 'mod_id' ];
            $_SESSION[ 'role' ] = 'moderator';
            mysqli_query($conn,"UPDATE moderator SET cookie='{$_COOKIE['PHPSESSID']}', is_logged = 1 WHERE mod_id  = {$_SESSION[ 'userID' ]}");
            die( json_encode( array( 'Success' => 'true', 'Msg' => ' Login Successfully' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => ' Wrong Username or Password. Please Try Again' ) ) );
        }

    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Wrong Username or Password. Please Try Again' ) ) );
    }
}
if($_GET['h'] == 'approveRequest'){
    $id=$_POST['id'];
    $sql =  mysqli_query($conn,"select * from accounts WHERE id=$id");
    if(mysqli_num_rows($sql)>0){
        $fetched_row = mysqli_fetch_assoc($sql);
        $sql =  mysqli_query($conn,"update accounts set status=1 WHERE id=$id");
        $link=$fetched_row['link'];
        $to=$fetched_row['email'];
        $from='no-reply@ourcanada.co';
        $subject='Approval for a professional account';

        $temps = mysqli_query($conn, "SELECT * FROM email_templates WHERE type = 'request approval'");
        $get_temps = mysqli_fetch_assoc($temps);
        $column=$fetched_row['language']=='_francais'?'_french':'_'.$fetched_row['language'];
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
        $s=mysqli_query($conn,"select * from static_labels where label='Click here'");
        $r=mysqli_fetch_assoc($s);
        $click=$r['label'.$column];
        if($click=='' || $click==null)
        {
            $click='Click here';
        }
        $anchor='<a href="'.$link.'">'.$click.'</a>';
        $body='<h3>'.$greeting.'</h3>'.$msg.'<br><strong>'.$anchor.'</strong>';
        checkAlignment($fetched_row['language']);
        $mail_response = defaultMail($to, $subject, $from, $body);

        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Request Approved.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No record exists' ) ) );
    }

}
if($_GET['h'] == 'rejectRequest'){
    $id=$_POST['id'];
    $sql =  mysqli_query($conn,"select * from accounts WHERE id=$id");
    if(mysqli_num_rows($sql)>0) {
        $fetched_row = mysqli_fetch_assoc($sql);
        $sql = mysqli_query($conn, "update accounts set status=2 WHERE id=$id");
        $to = $fetched_row['email'];
        $from = 'no-reply@ourcanada.co';
        $subject = 'Rejection for a professional account';

        $temps = mysqli_query($conn, "SELECT * FROM email_templates WHERE type = 'request rejection'");
        $get_temps = mysqli_fetch_assoc($temps);
        $column=$fetched_row['language']=='_francais'?'_french':'_'.$fetched_row['language'];
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
        $body='<h3>'.$greeting.'</h3>'.$msg;
        checkAlignment($fetched_row['language']);

        $mail_response = defaultMail($to, $subject, $from, $body);
    }
    if($mail_response)
    {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Request rejected.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No record exists' ) ) );
    }

}
if ($_GET['h'] == 'add_professional_account') {
    $str=generate_string(8);
    $email=$_POST['email'];
    $_POST['n']['email'] = $email;
    $_POST['n']['status'] = 1;
    $link='https://immigration.'.$default_url.'/activation/'.$str;
    $_POST['n']['link'] = $link;

    $T = db_pair_str2($_POST['n']);
    $select = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '$email'");
    if (mysqli_num_rows($select) > 0) {
        $row = mysqli_fetch_assoc($select);
        die(json_encode(array('Success' => 'false', 'Msg' => 'Email address already exists.')));
    } else {

        $insert = mysqli_query($conn, "INSERT into accounts SET $T");
        if ($insert) {

            $body='<h3>Dear User</h3><br>Your email has been added for a professional account.Please click the link below.<br><strong>'.$link.'</strong>';
            $to='fnsheikh29@gmail.com';
            $from='no-reply@ourcanada.co';
            $subject='Request for a professional account';

            defaultMail($email,$subject,$from,$body);


            die(json_encode(array('Success' => 'true', 'Msg' => 'Account has been added.')));
        } else {
            die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong.')));
        }
    }
}

if($_GET['h'] == 'previewImg'){
    $sql =  mysqli_query($conn,"SELECT * FROM `content-uploads` WHERE id={$_POST['id']}");
    if($sql){
        $fetched_row = mysqli_fetch_assoc($sql);
        $imgArr = explode (",", $fetched_row['images']);
        die( json_encode( array( 'Success' => 'true', 'data' => $imgArr ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No image exist' ) ) );
    }

}

if($_GET['h'] == 'previewVid'){
    $sql =  mysqli_query($conn,"SELECT * FROM `content-uploads` WHERE id={$_POST['id']}");
    if($sql){
        $fetched_row = mysqli_fetch_assoc($sql);
        $vidArr = explode (",", $fetched_row['video_local']);
        die( json_encode( array( 'Success' => 'true', 'data' => $vidArr ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No image exist' ) ) );
    }

}

if ( $_GET[ 'h' ] == 'add_blog_category' ) {
    $date = date("d M, yy h:i:sa");
    $_POST[ 'created_date' ] = $date;
    $T = db_pair_str2( $_POST );
    $sql = "INSERT INTO `category_blog` SET $T";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Blog Category Added Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' An Unexpected Error occurred !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'status_change_category' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM category_blog WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);
    if($Row['status'] == 0){
        $status = 1;
    }else{
        $status = 0;
    }
    $sql = "UPDATE `category_blog` SET status = '$status' WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Category Edited Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'delete_blog_category' ) {
    $sql = mysqli_query( $conn, "DELETE  FROM `category_blog` WHERE id ='{$_POST['id']}'" );
    if ( $sql  ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Category Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No news exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'edit_blog_category' ) {
    $T = db_pair_str2( $_POST );
    $sql = "UPDATE `category_blog` SET $T WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Blog Category Updated Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Something went wrong while updating Categories of Blog !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'addnew' ) {
    $date = date("d M, yy h:i:sa");
    $_POST[ 'created_date' ] = $date;
    $_POST[ 'status' ] = 0;
    $_POST[ 'ckeditor' ] = '';
    $T = db_pair_str2( $_POST );
    $sql = "INSERT INTO `news` SET $T";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' News Added Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' An Unexpected Error occurred !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'del_file' ) {
    // getting filename & fetching db row
    $filename = $_POST['filename'];
    $select_line = "SELECT * FROM `content-uploads` WHERE id = {$_POST['id']}";
    $res = mysqli_query($conn, $select_line);
    $fileType = pathinfo($filename, PATHINFO_EXTENSION);
    $updated_names = "";
    $row = mysqli_fetch_assoc($res);

    if(in_array($fileType, $allowTypesIMG)){
        $to_be_del_img = "uploads/images/".$filename;
        if(unlink($to_be_del_img)){
            $imageNames = explode (",", $row['images']);
            $count = 0;
            while($count != (sizeof($imageNames)-1)){
                if($imageNames[$count] != $filename){
                    $updated_names .= $imageNames[$count].",";
                }
                $count++;
            }
            $query = "UPDATE `content-uploads` SET images = '{$updated_names}' WHERE id = {$_POST['id']}";
            $img_update = mysqli_query($conn, $query);
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'File Deleted Successfully', 'filepath' => $to_be_del_img, 'sql' => $query, 'filename' => $filename, 'type' => 'IMG') ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'File was not found', 'filepath' => $to_be_del_img, 'sql' => $query, 'filename' => $filename, 'type' => 'IMG') ) );
        }
    } else{
        $to_be_del_vid = "uploads/videos/".$filename;
        if(unlink($to_be_del_vid)){
            $videoNames = explode (",", $row['video_local']);
            $count = 0;
            while($count != (sizeof($videoNames)-1)){
                if($videoNames[$count] != $filename){
                    $updated_names .= $videoNames[$count].",";
                }
                $count++;
            }
            $query = "UPDATE `content-uploads` SET video_local = '{$updated_names}' WHERE id = {$_POST['id']}";
            $vid_update = mysqli_query($conn, $query);
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'File Deleted Successfully', 'filepath' => $to_be_del_vid, 'sql' => $query, 'filename' => $filename, 'type' => 'VID') ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'File was not found', 'filepath' => $to_be_del_vid, 'sql' => $query, 'filename' => $filename, 'type' => 'VID') ) );
        }
    }
}

// multi lingual code
if ( $_GET[ 'h' ] == 'del_file_lingual' ) {
    $filename = $_POST['filename'];
    $file_to_be_deleted = "uploads/multi_lingual/".$filename;
    if($filename != ""){
        unlink($file_to_be_deleted);
        $query = "UPDATE `multi-lingual` SET `file_name` = '' WHERE id={$_POST['id']}";
        $result = mysqli_query($conn, $query);
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'File Deleted Successfully', 'sql' => $query, 'filepath' => $file_to_be_deleted ) ) );
    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'An Unexpected Error occurred', 'sql' => $query, 'filepath' => $file_to_be_deleted ) ) );
    }
}

// multi lingual code
if ( $_GET[ 'h' ] == 'del_lingual_entry' ) {
    $query = "SELECT * FROM `multi-lingual` WHERE id={$_POST['id']}";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $filename = $row['file_name'];
    $file_to_be_deleted = "uploads/multi_lingual/".$filename;
    if($filename != ""){
        unlink($file_to_be_deleted);
        $query = "DELETE FROM `multi-lingual` WHERE id={$_POST['id']}";
        $result = mysqli_query($conn, $query);
        if($result){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Lingual Entry Deleted Successfully', 'sql' => $query, 'filepath' => $file_to_be_deleted ) ) );
        } else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'An Unexpected Error occurred', 'sql' => $query, 'filepath' => $file_to_be_deleted ) ) );
        }
    } else{
        $query = "DELETE FROM `multi-lingual` WHERE id={$_POST['id']}";
        $result = mysqli_query($conn, $query);
        if($result){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Lingual Entry Deleted Successfully', 'sql' => $query, 'filepath' => $file_to_be_deleted ) ) );
        } else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'An Unexpected Error occurred', 'sql' => $query, 'filepath' => $file_to_be_deleted ) ) );
        }
    }
}

// multi lingual code
if ( $_GET[ 'h' ] == 'add_lingual' ) {
    $lang_slug = strtolower(str_replace(" ", "-", $_POST['language']));
    $validate = 1;

    // Create column dynamically Questions
    mysqli_query($conn , "ALTER TABLE questions ADD question_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE questions ADD notes_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE sub_questions ADD question_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE sub_questions ADD notes_$lang_slug TEXT NULL");

    // Create column dynamically Notes
    mysqli_query($conn , "ALTER TABLE level2_sub_questions ADD question_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE level2_sub_questions ADD notes_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE score_questions ADD comments_$col TEXT NULL");
    mysqli_query($conn , "ALTER TABLE score_questions2 ADD comments_$col TEXT NULL");
    mysqli_query($conn , "ALTER TABLE score_questions ADD comments_$col TEXT NULL");

    // Create column dynamically countries
    mysqli_query($conn , "ALTER TABLE countries ADD name_$lang_slug TEXT NULL");

    // Create column dynamically education
    mysqli_query($conn , "ALTER TABLE education ADD name_$lang_slug TEXT NULL");

    // Create column dynamically static_labels
    mysqli_query($conn , "ALTER TABLE static_labels ADD label_$lang_slug TEXT NULL");

    // Create column dynamically Question Options
    mysqli_query($conn , "ALTER TABLE question_labels ADD label_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE level1 ADD label_$lang_slug TEXT NULL");

    // Create column dynamically NOC Translation
    mysqli_query($conn , "ALTER TABLE noc_translation ADD job_position_$lang_slug TEXT NULL");
    mysqli_query($conn , "ALTER TABLE noc_translation ADD job_duty_$lang_slug TEXT NULL");


    $query = "SELECT * FROM `multi-lingual`";
    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_assoc($result)){
        if($row['language'] == $_POST['language']){
            $validate = 0;
            break;
        } else{
            $validate = 1;
        }
    }
    if($validate == 1){
        $date = date("d M, yy h:i:sa");
        $_POST[ 'created_date' ] = $date;
        $allowTypes = array('xls','xlsx','csv');
        if(!empty($_FILES)){
            $fileName = basename($_FILES['file']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            if(in_array($fileType, $allowTypes)){
                $targetDir = "uploads/multi_lingual/";
                $targetFilePath = $targetDir . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
                $_POST['file_name'] = $_FILES['file']['name'];
            }
            $fileName = basename($_FILES['flag_image']['name']);
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $targetDir = "/var/www/html/ourcanada".$ext."/superadmin/uploads/flags/";
            $targetFilePath = $targetDir . $fileName;
            $delete_file = $targetDir . $row['flag_image'];
            move_uploaded_file($_FILES["flag_image"]["tmp_name"], $targetFilePath);
            unlink($delete_file);
            $_POST['flag_image'] = $_FILES['flag_image']['name'];
        }
        $_POST['lang_slug'] = $lang_slug;
        $T = db_pair_str2( $_POST );
        $sql = "INSERT INTO `multi-lingual` SET $T";
        if ( mysqli_query( $conn, $sql ) ) {
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Lingual Added Successfully', 'sql' => $sql, 'filepath' => $targetFilePath ) ) );
        } else {
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'An Unexpected Error occurred', 'sql' => $sql, 'filepath' => $targetFilePath ) ) );
        }
    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Language already inserted') ) );
    }
}

// multi lingual code
if ( $_GET[ 'h' ] == 'update_lingual' ) {
    $query = "SELECT * FROM `multi-lingual` WHERE id={$_POST['id']}";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $date = date("d M, yy h:i:sa");
    $_POST[ 'created_date' ] = $date;
    $allowTypes = array('xls','xlsx','csv');
    if(!empty($_FILES)) {

        $fileName = basename($_FILES['file']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        if (in_array($fileType, $allowTypes)) {
            $targetDir = "/var/www/html/ourcanada".$ext."/superadmin/uploads/multi_lingual/";
            $targetFilePath = $targetDir . $fileName;
//            $delete_file = $targetDir . $row['file_name'];
            move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath);
//            unlink($delete_file);
            $old_file = $targetDir . $row['file_name'];
            $_POST['file_name'] = $_FILES['file']['name'];
            $sql2 = "INSERT into multi_lingual_history (file_id,file_name) values ({$_POST['id']},'{$row['file_name']}')";
            mysqli_query($conn, $sql2);

        }
        $fileName = basename($_FILES['flag_image']['name']);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $targetDir = "/var/www/html/ourcanada".$ext."/superadmin/uploads/flags/";
        $targetFilePath = $targetDir . $fileName;
        //$delete_file = $targetDir . $row['flag_image'];
        move_uploaded_file($_FILES["flag_image"]["tmp_name"], $targetFilePath);
        //unlink($delete_file);
        $_POST['flag_image'] = $_FILES['flag_image']['name'];
    }
    $_POST['lang_slug']=strtolower($_POST['language']);
    $T = db_pair_str2( $_POST );
    $sql = "UPDATE `multi-lingual` SET $T WHERE id={$_POST['id']}";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Lingual Updated Successfully', 'sql' => $sql, 'filepath' => $targetFilePath ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'An Unexpected Error occurred', 'sql' => $sql, 'filepath' => $targetFilePath ) ) );
    }
}

if ( $_GET[ 'h' ] == 'addBlog' ) {




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
            $_POST['video_local'] .= $fileName.",";
            copy("uploads/gallery/".$imgfgall[$i],"uploads/videos/".$fileName);
        }


    }

    $_POST['slug'] = date("Ymdhis")."-".$_POST['slug'];


    $date = date("d M, yy h:i:sa");
    $_POST[ 'created_date' ] = $date;



    if(!empty($_FILES))
    {
        $file_counter = 0;
        foreach($_FILES['file']['name'] as $key=>$val){
            $filebaseName = basename($_FILES['file']['name'][$key]);
            $fileType = pathinfo($filebaseName, PATHINFO_EXTENSION);

            $fileName = "";

            if(in_array($fileType, $allowTypesIMG)){

                $fileName = "img-".date("jS-YhisA").$file_counter.".".$fileType;

                $targetDir = "uploads/images/";
                $targetFilePath = $targetDir . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                $_POST['images'] .= $fileName.",";
            } else{

                $fileName = "vid-".date("jS-YhisA").$file_counter.".".$fileType;
                $targetDir = "uploads/videos/";
                $targetFilePath = $targetDir . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                $_POST['video_local'] .= $fileName.",";
            }
            $file_counter++;
        }
    }

// $categories_arr = explode(",", $_POST['category']);
//         foreach ( $categories_arr as $names){
//             $categories .= $names.",";
//         }

    unset($_POST['galleryimgschecks']);

    $T = db_pair_str2( $_POST );
    $sql = "INSERT INTO `content-uploads` SET $T";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Blog Added Successfully', 'sql' => $sql ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'An Unexpected Error occurred', 'sql' => mysqli_error($conn) ) ) );
    }
}


if ( $_GET[ 'h' ] == 'update_blog' ) {





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
            $_POST['video_local'] .= $fileName.",";
            copy("uploads/gallery/".$imgfgall[$i],"uploads/videos/".$fileName);
        }


    }


    $sql = mysqli_query( $conn, "SELECT *  FROM `content-uploads` WHERE id ='{$_POST['id']}'" );
    $fetch = mysqli_fetch_assoc($sql);
    $updated_images = $fetch['images'];
    $updated_videos = $fetch['video_local'];



    if(!empty($_FILES)){
        $file_counter = 0;
        foreach($_FILES['file']['name'] as $key=>$val){

            $basefilename = basename($_FILES['file']['name'][$key]);
            $fileType = pathinfo($basefilename, PATHINFO_EXTENSION);

            $fileName = "";


            if(in_array($fileType, $allowTypesIMG)){
                $targetDir = "uploads/images/";

                $fileName = "img-".date("jS-YhisA").$file_counter.".".$fileType;

                $targetFilePath = $targetDir . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                $updated_images .= $fileName.",";
            } else{

                $fileName = "vid-".date("jS-YhisA").$file_counter.".".$fileType;
                $targetDir = "uploads/videos/";
                $targetFilePath = $targetDir . $fileName;
                move_uploaded_file($_FILES["file"]["tmp_name"][$key], $targetFilePath);
                $updated_videos .= $fileName.",";
            }
            $file_counter++;
        }
    }


    $_POST['images'] = $updated_images.$_POST['images'];
    $_POST['video_local'] = $updated_videos. $_POST['video_local'];

    unset($_POST['galleryimgschecks']);
    $_POST['slug'] = date("Ymdhis")."-".$_POST['slug'];
    $T = db_pair_str2( $_POST );
    $sql = "UPDATE `content-uploads` SET $T WHERE id={$_POST['id']}";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Blogs Updated Successfully', 'sql' => $sql ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Some uncaught update error', 'sql' => $sql ) ) );
    }
}


if($_GET['h'] == 'delete_comment'){
    $del = mysqli_query($conn,"DELETE FROM ".$_POST['table']." WHERE id = ".$_POST['id']);
    if($_POST['table'] == "comments"){
        $del_sub = mysqli_query($conn,"DELETE FROM comments_reply WHERE comment_id = ".$_POST['id']);
    }

    if($del){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}

if($_GET['h'] == 'update_comment'){
    $update = mysqli_query($conn,"UPDATE ".$_POST['table']." SET comment = '".$_POST['comment']."' WHERE id = ".$_POST['id']);
    if($update){
        echo json_encode(['success'=>'success']);
    }else{
        echo json_encode(['error'=>'error']);
    }
}


if ( $_GET[ 'h' ] == 'del_blog' ) {
    $sql = mysqli_query( $conn, "DELETE  FROM `content-uploads` WHERE id ='{$_POST['id']}'" );
    mysqli_query($conn,"DELETE FROM comments WHERE content_id = ".$_POST['id']);
    mysqli_query($conn,"DELETE FROM comments_reply WHERE content_id = ".$_POST['id']);
    $select = mysqli_query($conn, "SELECT * FROM `content-uploads` WHERE id ='{$_POST['id']}'");
    $row = mysqli_fetch_assoc($select);
    $imagesNames = explode (",", $row['images']);
    $videoNames = explode (",", $row['video_local']);
    $countIMG = 0;
    $countVID = 0;
    while($countIMG != (sizeof($imagesNames)-1)){
        unlink("uploads/images/".$imagesNames[$countIMG]);
        $countIMG++;
    }
    while($countVID != (sizeof($videoNames)-1)){
        unlink("uploads/videos/".$videoNames[$countVID]);
        $countVID++;
    }
    if ( $sql  ) {

        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Blog Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Some uncaught error exists' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'delete_all_blogs' ) {
    $select = mysqli_query($conn, "SELECT * FROM `content-uploads`");
    while($row = mysqli_fetch_assoc($select)){
        $imagesNames = explode (",", $row['images']);
        $videoNames = explode (",", $row['video_local']);
        $countIMG = 0;
        $countVID = 0;
        while($countIMG != (sizeof($imagesNames)-1)){
            unlink("uploads/images/".$imagesNames[$countIMG]);
            $countIMG++;
        }
        while($countVID != (sizeof($videoNames)-1)){
            unlink("uploads/videos/".$videoNames[$countVID]);
            $countVID++;
        }
    }
    $sql = mysqli_query( $conn, "TRUNCATE TABLE `content-uploads`" );
    if ( $sql  ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Blogs Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Some uncaught error exists' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'update_status' ) {
    $T = db_pair_str2( $_POST );
    $sql = mysqli_query( $conn, "SELECT *  FROM `content-uploads` WHERE id ='{$_POST['id']}'" );
    $fetch = mysqli_fetch_assoc($sql);
    if($fetch['status'] == 1){
        $update = mysqli_query( $conn, "UPDATE `content-uploads` SET `status` = '0' WHERE id='{$_POST['id']}'" );
    } else{
        $update = mysqli_query( $conn, "UPDATE `content-uploads` SET `status` = '1' WHERE id='{$_POST['id']}'" );
    }

    if ($update) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Status Updated Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Something went wrong while updating' ) ) );
    }

}

if ( $_GET[ 'h' ] == 'getN' ) {
    $sql = mysqli_query( $conn, "SELECT * FROM  `user` WHERE id ='{$_POST['id']}'" );
    if ( $sql ) {
        $row = mysqli_fetch_assoc( $sql );
        die( json_encode( array( 'Success' => 'true', 'data' => $row ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'No news exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'getAN' ) {
    $sql = mysqli_query( $conn, "SELECT * FROM  `nominations` WHERE id ='{$_POST['id']}'" );
    if ( $sql ) {
        $row = mysqli_fetch_assoc( $sql );
        die( json_encode( array( 'Success' => 'true', 'data' => $row ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'No news exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'editN' ) {
    $T = db_pair_str2( $_POST );
    $sql = "UPDATE `users` SET $T WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' User Updated Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Something went wrong while updating News !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'editAN' ) {

    $select=mysqli_query($conn,"select * from nominations where slug='{$_POST['slug']}' and id!={$_POST['id']}");
    if(mysqli_num_rows($select) > 0)
    {
        die(json_encode(array('Success' => 'false' , 'Msg' => 'Award already exists')));
    }
    unset($_POST['image']);

    if(isset($_FILES)) {
        $photo=ImageUpload($_FILES['image'],'./uploads/awardPhoto/');
        if($photo['Msg']!=='false')
        {
            $_POST['n']['award_image']=$photo['path'];
        }
        else if($_POST['imgCheck']==1 && $photo['Msg']=='false')
        {
            $_POST['n']['award_image'] ='';
        }
    }

    $T = db_pair_str2( $_POST['n'] );
    $sql = "UPDATE `nominations` SET $T WHERE id={$_POST['id']}";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Award Updated Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Something went wrong while updating News !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'deleteN' ) {
    $sql = mysqli_query( $conn, "DELETE FROM `users` WHERE id ='{$_POST['id']}'" );
    if ( $sql  ) {
        mysqli_query($conn,"DELETE FROM news_content WHERE creator_id = ".$_POST['id']);
        mysqli_query($conn,"DELETE FROM blog_content WHERE creator_id = ".$_POST['id']);
        mysqli_query($conn,"DELETE FROM news_comments WHERE user_id = ".$_POST['id']);
        mysqli_query($conn,"DELETE FROM news_comments_reply WHERE user_id = ".$_POST['id']);
        mysqli_query($conn,"DELETE FROM comments WHERE user_id = ".$_POST['id']);
        mysqli_query($conn,"DELETE FROM comments_reply WHERE user_id = ".$_POST['id']);
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' User Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No news exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'deleteA' ) {
    $sql = mysqli_query( $conn, "DELETE  FROM `referral` WHERE id ='{$_POST['id']}'" );


    if ( $sql  ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' User Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' something went wrong' ) ) );
    }
}

///////////////////////////MODERATORS//////////////////////////////

if ( $_GET[ 'h' ] == 'getM' ) {
    $sql = mysqli_query( $conn, "SELECT * FROM  `moderator` WHERE mod_id ='{$_POST['id']}'" );
    if ( $sql ) {
        $row = mysqli_fetch_assoc( $sql );
        die( json_encode( array( 'Success' => 'true', 'data' => $row ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'No moderator exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'editM' ) {
    $T = db_pair_str2( $_POST );
    $sql = "UPDATE `moderator` SET $T WHERE mod_id='{$_POST['mod_id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Moderator Updated Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Something went wrong while moderator News !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'deleteM' ) {
    $sql = mysqli_query( $conn, "DELETE FROM `moderator` WHERE mod_id ='{$_POST['id']}'" );
    if ( $sql ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Moderator Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No moderator exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'addnewM' ) {

    $q="SELECT * FROM moderator WHERE email ='{$_POST['email']}'";
    $check=mysqli_query( $conn,$q);

    if(mysqli_num_rows( $check ) > 0)

    {
        die( json_encode( array( 'Success' => 'emailerror', 'Msg' => 'Email already exist' ) ) );

    }else
    {
        $date = date("d M, yy h:i:sa");
        $_POST[ 'created_date' ] = $date;
        $T = db_pair_str2( $_POST );
        $sql = "INSERT INTO `moderator` SET $T";
        if ( mysqli_query( $conn, $sql ) ) {
            die( json_encode( array( 'Success' => 'true', 'Msg' => ' Moderator Added Successfully.' ) ) );
        } else {
            die( json_encode( array( 'Success' => 'false', 'Msg' => ' An Unexpected Error occurred !' ) ) );
        }
    }
}

if($_GET['h'] == 'addnewA'){

    $_POST['status'] = 1;
    $select=mysqli_query($conn,"select * from nominations where slug='{$_POST['slug']}'");
    if(mysqli_num_rows($select) > 0)
    {
        die(json_encode(array('Success' => 'false' , 'Msg' => 'Award already exists')));
    }
    unset($_POST['image']);
    if(isset($_FILES))
    {
        $photo=ImageUpload($_FILES['image'],'./uploads/awardPhoto/');
        if($photo['Msg']!=='false')
        {
            $_POST['award_image']=$photo['path'];
        }
    }

    $date = date("yy-m-d ");
    $_POST['createdDate'] = $date;
    $T = db_pair_str2( $_POST);

    $sql = "INSERT INTO `nominations` SET $T";
    if (mysqli_query($conn, $sql)) {
        die(json_encode(array('Success' => 'true' , 'Msg' => 'Award Added Successfully')));
    }
    else {
        die(json_encode(array('Success' => 'false' , 'Msg' => 'Something went wrong while adding award.')));
    }
}

if ( $_GET[ 'h' ] == 'status_change' ) {
    $table = $_POST['table'];
    unset($_POST['table']);
    $lang = "";
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $lang = $_GET['lang'];
        $table = $table.'_'.$lang;
    }
    $getStatus = mysqli_query($conn , "SELECT * FROM ".$table." WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);
    if($Row['status'] == 0){
        $status = 1;
    }else{
        $status = 0;
    }
    $sql = "UPDATE `".$table."` SET status = '$status' WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'News Edited Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'status_changeU' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM user WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);
    if($Row['status'] == 0){
        $status = 1;
    }else{
        $status = 0;
    }
    $sql = "UPDATE `user` SET status = '$status' WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'News Edited Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'status_changeN' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM nominations WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);
    if($Row['status'] == 0){
        $status = 1;
    }else{
        $status = 0;
    }
    $sql = "UPDATE `nominations` SET status = '$status' WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'News Edited Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}


if ( $_GET[ 'h' ] == 'storyStatus' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM nominated_users_list WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);



    $getUser = mysqli_query($conn , "SELECT * FROM users WHERE id = '{$Row['user_id']}'");
    $uRow = mysqli_fetch_assoc($getUser);

    if($Row['status'] == 0){
        $status = 1;

        $msg = 'Your story <b>'.$Row['title'].'</b> has been approved by admin. Please click here to view your story<br><br><a href="https://awards.ourcanadadev.site/story-detail/'.$Row['id'].'" class="btn-primary" style="background:#E50606; color:#fff; padding: 8px 20px; outline: none; text-decoration: none; font-size: 14pxpx; letter-spacing: 0.5px; transition: all 0.3s; border-radius: 6px;">View Story</a>';

        if($Row['email'] !== NULL){
//            notifyEmail($Row['email'],'User',$msg , 'Story Posted - Our Canada');
        }else{
//            notifyEmail($uRow['email'],'User',$msg , 'Story Posted - Our Canada');
        }


    }else{
        $status = 0;
    }
    $sql = "UPDATE `nominated_users_list` SET status = '$status' WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Status Edited Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}
if ( $_GET[ 'h' ] == 'likeStory' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM nominated_users_list WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);
    if($Row['liked'] == 0){
        $like = 1;
        $msg='You have liked the story.';
    }else{
        $like = 0;
        $msg='You have disliked the story.';

    }
    $sql = "UPDATE `nominated_users_list` SET liked = $like WHERE id='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => $msg,'s'=>$like ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}


///////////////NEWS///////////////////

if ( $_GET[ 'h' ] == 'getNews' ) {
    $table = $_POST['table'];
    unset($_POST['table']);
    $sql = mysqli_query( $conn, "SELECT * FROM  `".$table."` WHERE id ='{$_POST['id']}'" );
    if ( $sql ) {
        $row = mysqli_fetch_assoc( $sql );
        die( json_encode( array( 'Success' => 'true', 'data' => $row ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'No moderator exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'editnews' ) {
    $table = $_POST['table'];
    unset($_POST['table']);
    $T = db_pair_str2( $_POST );
    $sql = "UPDATE `".$table."` SET $T WHERE id='{$_POST['id']}'";
    die($sql);
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' News Updated Successfully.' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' Something went wrong while updating News !' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'deleteNews' ) {
    $table = $_POST['table'];
    unset($_POST['table']);
    $com_table = ["",""];
    $lang = "";
    if(isset($_GET['lang']) && !empty($_GET['lang'])){
        $lang = "_".$_GET['lang'];
    }
    $table = $table.$lang;
    if($table == "news_content".$lang){
        $com_table[0] = "news_comments";
        $com_table[1] = "news_comments_reply";
    }else{
        $com_table[0] = "comments";
        $com_table[1] = "comments_reply";
    }
    $sql = mysqli_query( $conn, "DELETE FROM `".$table."` WHERE id ='{$_POST['id']}'" );
    mysqli_query($conn,"DELETE FROM ".$com_table[0]." WHERE content_id = ".$_POST['id']);
    mysqli_query($conn,"DELETE FROM ".$com_table[1]." WHERE content_id = ".$_POST['id']);
    if ( $sql ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Record Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No news exist' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'deleteNomination' ) {
    $check = mysqli_query($conn,"DELETE FROM nominated_users_list WHERE id = ".$_POST['id']);
    if($check){
        echo json_encode(['success'=>'Nomination delete successfully.']);
    }else{
        echo json_encode(['error'=>'Failed to delete nomination.']);
    }
}

if ( $_GET[ 'h' ] == 'getNiminations' ) {
    $getList = mysqli_query($conn,"SELECT * FROM nominated_users_list WHERE award_id = ".$_POST['id']);
    $row = mysqli_fetch_assoc($getList);
    $user_list = explode(',', $row['user_email']);
    $html = '';
    for ($i=0; $i < count($user_list); $i++) {
        $html .= '<option value="'.$user_list[$i].'">'.$user_list[$i].'</option>';
    }
    // $users = mysqli_query($conn,"SELECT * FROM users WHERE id IN(".$row['user_id'].")");
    // $html = '';
    // while ($u_row = mysqli_fetch_assoc($users)) {
    // $html .= '<option value="'.$u_row['id'].'">'.$u_row['username'].'</option>';
    // }
    if(count($user_list) > 0){
        echo json_encode(['success'=>$html]);
    }else{
        echo json_encode(['error'=>'']);
    }
}

if ( $_GET[ 'h' ] == 'addWinner' ) {

    $set_winner = mysqli_query($conn,"SELECT * FROM award_winner WHERE award_id = ".$_POST['award']);
    if(mysqli_num_rows($set_winner) > 0)
    {

        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
    $insert=mysqli_query($conn,"insert into award_winner (award_id,winner_email,winner_name,story_id) values ({$_POST['award']},'{$_POST['winner']}','{$_POST['name']}','{$_POST['url_id']}')");
    if($insert)
    {
        $set_winner = mysqli_query($conn,"SELECT * FROM nominations WHERE id = {$_POST['award']}");
        $row=mysqli_fetch_assoc($set_winner);
//        sendMail($_POST['winner'],$_POST['name'],$row['title'],$_POST['url_id']);
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Winner has been declared Successfully.' ) ) );
    }
    else
    {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );

    }

}
function PhotoUpload($file){
    $_FILES['winner_photo'] = $file;
    if(isset($_FILES['winner_photo'])){
        if(count($_FILES['winner_photo']) > 1){
            if(in_array($_FILES['winner_photo']['type'], ['image/jpeg','image/jpg','image/png'])){
                if($_FILES['winner_photo']['size'] >= 2097152){
                    return ['Msg'=>"File must be less than 2 MB"];
                }else{
                    $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["winner_photo"]["name"]));
                    $check = move_uploaded_file($_FILES["winner_photo"]["tmp_name"], "./uploads/WinnersPhotos/" . $newfilename);
                    if($check){
                        return ['path'=>"/uploads/WinnersPhotos/" . $newfilename];
                    }else{
                        return ['Msg'=>'Failed to upload photo.'];
                    }
                }
            }else{
                return ['Msg'=>'Please select a valid image.'];
            }
        }else{
            return ['Msg'=>"Please select only one image."];
        }
    }else{
        return ['Msg'=>'Photo is not found.'];
    }
}
function ImageUpload($file,$path){
    $_FILES['image'] = $file;
    if(isset($_FILES['image'])){
        if(count($_FILES['image']) > 1){
            if(in_array($_FILES['image']['type'], ['image/jpeg','image/jpg','image/png'])){
                if($_FILES['image']['size'] >= 2097152){
                    return ['Msg'=>"File must be less than 2 MB"];
                }else{
                    $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["image"]["name"]));
                    $check = move_uploaded_file($_FILES["image"]["tmp_name"],  $path. $newfilename);
                    if($check){
                        return ['path'=>$newfilename];
                    }else{
                        return ['Msg'=>'Failed to upload photo.'];
                    }
                }
            }else{
                return ['Msg'=>'Please select a valid image.'];
            }
        }else{
            return ['Msg'=>"Please select only one image."];
        }
    }else{
        return ['Msg'=>'false'];
    }
}


if ( $_GET[ 'h' ] == 'deleteNominationWinner' ) {
    $check = mysqli_query($conn,"DELETE FROM award_winner WHERE id = ".$_POST['id']);
    if($check){
        echo json_encode(['success'=>'Winner delete from the selected award.']);
    }else{
        echo json_encode(['error'=>'Failed to delete.']);
    }
}

if ( $_GET[ 'h' ] == 'lingual_status' ) {
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $update = mysqli_query($conn,"UPDATE `multi-lingual` SET status = !status WHERE id = '{$_POST['id']}'");
        if($update){
            echo json_encode(['success'=>'success']);
        }else{
            echo json_encode(['error'=>'Enable to perform this acction.']);
        }
    }else{
        echo json_encode(['error'=>'Enable to perform this acction.']);
    }
}


if ( $_GET[ 'h' ] == 'comment_satus' ) {
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $update = mysqli_query($conn,"UPDATE comments SET status = !status WHERE id = ".$_POST['id']);
        if($update){
            echo json_encode(['success'=>'success']);
        }else{
            echo json_encode(['error'=>'Enable to perform this acction.']);
        }
    }else{
        echo json_encode(['error'=>'Enable to perform this acction.']);
    }
}

if ( $_GET[ 'h' ] == 'new_comment_satus' ) {
    if(isset($_POST['id']) && !empty($_POST['id'])){
        $update = mysqli_query($conn,"UPDATE news_comments SET status = !status WHERE id = ".$_POST['id']);
        if($update){
            echo json_encode(['success'=>'success']);
        }else{
            echo json_encode(['error'=>'Enable to perform this acction.']);
        }
    }else{
        echo json_encode(['error'=>'Enable to perform this acction.']);
    }
}


if ( $_GET[ 'h' ] == 'updateStory' ) {
    if(isset($_POST['sid']) && !empty($_POST['sid'])){

        if(isset($_FILES)) {
            $imagePath = "/home/ourcanadadev/public_html/awards/nomination/";

            $image = ImageUpload($_FILES['image'],  $imagePath);
            $_POST['n']['file'] = $image['path'];
        }
        if($_POST['imageCheck']==1 && !isset($_FILES))
        {
            $_POST['n']['file'] ='';
        }
        $T = db_pair_str2( $_POST['n']);
        $update = mysqli_query($conn,"UPDATE nominated_users_list SET $T WHERE id = {$_POST['sid']}");
        if($update){
            die( json_encode( array( 'Success' => 'true', 'Msg' => ' Updated Successfully.' ) ) );
        } else {
            die( json_encode( array( 'Success' => 'false', 'Msg' => ' An Unexpected Error occurred !' ) ) );
        }
    }else{
        echo json_encode(['error'=>'Unable to perform this action.']);
    }
}



if ( $_GET[ 'h' ] == 'updateThreshold' ) {
    $T = db_pair_str2( $_POST['n'] );
    $update = mysqli_query($conn,"UPDATE referral_threshold SET $T WHERE id = '1'");
    if($update){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Referral Threshold updated successfully.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Something went wrong while updating Referral Threshold.' ) ) );
    }

}

// CHange Refer Status
if ( $_GET[ 'h' ] == 'changeRstatus' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM referral WHERE id = '{$_POST['id']}'");
    $Row = mysqli_fetch_assoc($getStatus);

    $getUser = mysqli_query($conn , "SELECT * FROM users WHERE email = '{$Row['refered_by']}'");
    $user = mysqli_fetch_assoc($getUser);

    $getUser_ref_by = mysqli_query($conn , "SELECT * FROM users WHERE email = '{$Row['refered_to']}'");
    $user_ref_by = mysqli_fetch_assoc($getUser_ref_by);

    $checkPoints = mysqli_query($conn , "SELECT * FROM referral_threshold WHERE id = '1'");
    $pntRow = mysqli_fetch_assoc($checkPoints);

    $points = $user['points'];
    $points_ref_by = $user_ref_by['points'];
    if($Row['status'] == 0){
        $status = 1;
        $points = $points+$pntRow['token'];
        $points_ref_by = $points_ref_by+$pntRow['token'];
    }else{
        $status = 0;
    }
    $sql = "UPDATE `referral` SET status = '$status',token = '{$pntRow['token']}' WHERE ID='{$_POST['id']}'";

    if ( mysqli_query( $conn, $sql ) ) {
        mysqli_query($conn , "UPDATE `users` SET points = '$points' WHERE email='{$user['email']}'");
        mysqli_query($conn , "UPDATE `users` SET points = '$points_ref_by' WHERE email='{$user_ref_by['email']}'");
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'News Edited Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}

// Assign Token to the story
if ( $_GET[ 'h' ] == 'assignToken' ) {

    $sql = "UPDATE `nominated_users_list` SET token = '{$_POST['token']}' WHERE id='{$_POST['id']}'";
    $select=mysqli_query($conn,"select * from nominated_users_list where id='{$_POST['id']}'");
    $row=mysqli_fetch_assoc($select);
    $s=mysqli_query($conn,"select * from users where id={$row['nominated_by']}");
    $r=mysqli_fetch_assoc($s);
    $points=(int)$r['points']+$_POST['token'];
    $u=mysqli_query($conn,"UPDATE users set points=$points where id={$r['id']}");

    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Token Assigned Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while assigning token.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'assign_news_points' ) {
    if(
        isset($_POST['id']) && $_POST['id'] > 0 &&
        isset($_POST['user_id']) && $_POST['user_id'] > 0 &&
        isset($_POST['points']) &&
        isset($_POST['val'])
    ){
        $table = $_POST['table'];
        $lang = "";
        if(isset($_GET['lang']) && !empty($_GET['lang'])){
            $lang = "_".$_GET['lang'];
        }
        $table = $table.$lang;
        unset($_POST['table']);
        $setPoints = mysqli_query($conn,"UPDATE ".$table." SET points = '".$_POST['val']."' WHERE id = ".$_POST['id']);

        if(empty($_POST['points'])){
            $_POST['points'] = 0;
        }

        $getUserData = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$_POST['user_id']);
        $userRow = mysqli_fetch_assoc($getUserData);
        $up = 0;
        if(empty($userRow['points']) || $userRow['points'] < 1){
            $up = 0;
        }else{
            $up = $userRow['points'];
        }
        if($_POST['points'] == 0){
            $updateUserPoints = mysqli_query($conn,"UPDATE users SET points = ".($up+$_POST['val'])." WHERE id = ".$_POST['user_id']);
        }else{
            if($_POST['val'] > $_POST['points']){
                $newPoints = $_POST['val'] - $_POST['points'];
                $newPoints = "+".$newPoints;
            }else if($_POST['val'] < $_POST['points']){
                $newPoints = $_POST['points'] - $_POST['val'];
                $newPoints = "-".$newPoints;
            }
            $updateUserPoints = mysqli_query($conn,"UPDATE users SET points = ".$newPoints." WHERE id = ".$_POST['user_id']);
        }
        die(json_encode(['success'=>'success']));
    }else{
        die(json_encode(['error'=>'Something is missing.Refresh and try again.']));
    }
}
if ( $_GET[ 'h' ] == 'delComment' ) {
    $sql = mysqli_query( $conn, "DELETE  FROM `awards_comments` WHERE id ='{$_POST['id']}'" );
    if ( $sql  ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Comment has been Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No news exist' ) ) );
    }
}
if ( $_GET[ 'h' ] == 'approveComment' ) {
    $getStatus = mysqli_query($conn , "SELECT * FROM awards_comments WHERE id = '{$_POST['id']}'");
    $row = mysqli_fetch_assoc($getStatus);
    if($row['status'] == 0){
        $status = 1;
        $select='';
        if($row['item_type']=='award')
        {
            $select=mysqli_query($conn,"select * from nominations where id={$row['item_id']}");
        }
        else
        {
            $select=mysqli_query($conn,"select * from nominated_users_list where id={$row['item_id']}");
        }

        $arow=mysqli_fetch_assoc($select);
        $select2=mysqli_query($conn,"select * from users where id={$row['user_id']}");
        $urow=mysqli_fetch_assoc($select2);

//        sendMail2($urow['email'],$urow['firstname'],$arow['title'],$row['comment']);

    }else{
        $status = 0;
    }
    $sql = "UPDATE `awards_comments` SET status = '$status' WHERE ID='{$_POST['id']}'";
    if ( mysqli_query( $conn, $sql ) ) {
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Comment approved Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while editing news.' ) ) );
    }
}

function VideoUpload($file){
    $_FILES['videos'] = $file;
    if(isset($_FILES['videos'])){
        $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["videos"]["name"]));
        $check = move_uploaded_file($_FILES["videos"]["tmp_name"], "../community/uploads/videos/" . $newfilename);
        if($check){
            return ['path'=>$newfilename];
        }else{
            return ['Msg'=>'Failed to upload video.'];
        }
    }else{
        return ['Msg'=>'Video not found.'];
    }
}

function MultiPhotoUpload($type,$name,$size,$tmp){
    if(in_array($type, ['image/jpeg','image/jpg','image/png'])){
        $newfilename = date('dmYHis').str_replace(" ", "", basename($name));
        $check = move_uploaded_file($tmp, "../community/uploads/images/" . $newfilename);
        if($check){
            return ['path'=>$newfilename];
        }else{
            return ['Msg'=>'Failed to upload photo.'];
        }
    }else{
        return ['Msg'=>'Please select a valid image.image type should be jpg,png,jpeg'];
    }
}

function CheckTitle($conn,$title,$table,$update,$slug){
    if($update){
        if($title[0] != $title[1]){
            $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE slug = '".$slug."'");

            // $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE replace(title,' ','') = '".str_replace(' ', '', str_repeat('_', '',$title[0]))."'");
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

        // $check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE replace(title,' ','') = '".str_replace(' ', '', str_replace('_', '', $title))."'");
        if(mysqli_num_rows($check) > 0){
            return false;
        }else{
            return true;
        }
    }
}

function PhotoThumbnail($file){
    $_FILES['winner_photo'] = $file;
    if(isset($_FILES['winner_photo'])){
        if(count($_FILES['winner_photo']) > 1){
            if(in_array($_FILES['winner_photo']['type'], ['image/jpeg','image/jpg','image/png'])){
                $ext = explode("/", $_FILES['winner_photo']['type']);
                $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["winner_photo"]["name"])).".".$ext[1];
                $check = move_uploaded_file($_FILES["winner_photo"]["tmp_name"], "../community/uploads/images/" . $newfilename);
                if($check){
                    return ['path'=>$newfilename];
                }else{
                    return ['Msg'=>'Failed to upload photo.'];
                }
            }else{
                return ['Msg'=>'Please select a valid image.'];
            }
        }else{
            return ['Msg'=>"Please select only one image."];
        }
    }else{
        return ['Msg'=>'Photo is not found.'];
    }
}

function PDFUpload($file){
    $_FILES['pdf_file'] = $file;
    if(isset($_FILES['pdf_file'])){
        if(count($_FILES['pdf_file']) > 1){
            if(in_array($_FILES['pdf_file']['type'], ['application/pdf']) || $_FILES['pdf_file']['name'] == 'application/pdf'){
                $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["pdf_file"]["name"]));
                $check = move_uploaded_file($_FILES["pdf_file"]["tmp_name"], "../community/uploads/pdf_files/" . $newfilename);
                if($check){
                    return ['path'=>$newfilename];
                }else{
                    return ['Msg'=>"Failed to upload pdf."];
                }
            }else{
                return ['Msg'=>"Please select a pdf file."];
            }
        }else{
            return ['Msg'=>"You can upload only 1 pdf."];
        }
    }else{
        return ['Msg'=>'Failed to upload pdf.'];
    }
}

if($_GET['h'] == 'addContent'){
    // foreach ($_POST as $key => $value) {
    //     if($_POST[$key] == 'undefined'){
    //         $_POST[$key] = '';
    //     }
    // }
    if(isset($_POST['selected_slug']) && !empty($_POST['selected_slug'])){
        $_PSOT['slug'] = $_POST['selected_slug'];
        $unique = true;
    }else{
        $title = $_POST['title'];
        $old_title  = $_POST['old_title'];
        unset($_POST['old_title']);
        $unique = true;
        if(!isset($_POST['lang']) || empty($_POST['lang']) || $_POST['lang'] == 'english'){
            if(isset($_POST['id'])){
                $unique = CheckTitle($conn,[$title,$old_title],$_POST['table'],true,$_POST['slug']);
            }else{
                $unique = CheckTitle($conn,$title,$_POST['table'],false,$_POST['slug']);
            }
        }else{

        }
    }

    if(isset($_POST['youtube_embed']) && str_replace(' ','',$_POST['youtube_embed']) == 'undefined'){
        unset($_POST['youtube_embed']);
        $_POST['embed'] = '';
    }

    if($unique == false){
        die(json_encode(['error'=>'Title is already exist.Try with some diffrent title.']));
    }else{
        $_POST['creator_id'] = $_SESSION['userID'];
        $table = $_POST['table'];
        unset($_POST['table']);
        if(isset($_POST['lang']) && !empty($_POST['lang'])){
            $table = $table.'_'.$_POST['lang'];
        }
        if(!isset($_POST['id']) || empty($_POST['id'])){
            $existing_check = mysqli_query($conn,"SELECT * FROM ".$table." WHERE slug = '".$_POST['slug']."'");
            if(mysqli_num_rows($existing_check) > 0){
                die(json_encode(['error'=>'Selected blog is already exist in this language.']));
            }
        }
        $vid_err = "";
        if(isset($_FILES['single_video'])){
            if(isset($_POST['youtube_embed']) && !empty($_POST['youtube_embed'])){
                $vid_err = ['You are allowed to upload only 1 video.'];
            }else{ 
                $vid = VideoUpload($_FILES['single_video']);
                if(array_key_exists('path', $vid)){
                    $_POST['video'] = $vid['path'];
                }else{
                    $vid_err = $vid['Msg'];
                }
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

        unset($_POST['thumbnail']);
        unset($_FILES['thumbnail']);

        unset($_POST['single_video']);
        unset($_POST['creator_id']);
        $img_err = [];
        $images = [];
        if(count(array_filter($_FILES['multi_images']['name'])) > 0){
            for ($i = 0; $i < count($_FILES['multi_images']['name']); $i++) {
                $img = MultiPhotoUpload($_FILES['multi_images']['type'][$i],$_FILES['multi_images']['name'][$i],$_FILES['multi_images']['size'][$i],$_FILES['multi_images']['tmp_name'][$i]);
                if(array_key_exists('Msg',$img)){
                    array_push($img_err,$img['Msg']);
                }else{
                    array_push($images,$img['path']);
                }
            }
        }

        unset($_POST['multi_images']);

        $pdfPath = '';
        if(isset($_POST['id']) && !empty($_POST['id'])){
            if(isset($_FILES['pdf_file']) && !empty($_FILES['pdf_file']['name'])){
                $pdf_path = PDFUpload($_FILES['pdf_file']);
                if(array_key_exists('Msg', $pdf_path)){
                    die(json_encode(['error'=>$pdf_path['Msg']]));
                }else{
                    $pdfPath = $pdf_path['path'];
                }
            }
        }else{
            if($_POST['type'] == 'pdf-blog' || $_POST['type'] == 'pdf-news'){
                if(isset($_POST['old_pdf']) && !empty($_POST['old_pdf'])){
                    $pdf_path = $_POST['old_pdf'];
                    $_POST['pdf_path'] = $_POST['old_pdf'];
                    unset($_POST['old_pdf']);
                }else{
                    if(!isset($_FILES['pdf_file']) || empty($_FILES['pdf_file']['name'])){
                        die(json_encode(['error'=>'Please select pdf file.']));
                    }else{
                        
                        $pdf_path = PDFUpload($_FILES['pdf_file']);
                        if(array_key_exists('Msg', $pdf_path)){
                            die(json_encode(['error'=>$pdf_path['Msg']]));
                        }else{
                            $pdfPath = $pdf_path['path'];
                        }
                    }
                }
            }
        }

        if(!empty($vid_err)){
            if(isset($_POST['youtube_embed']) && !empty($_POST['youtube_embed'])){
                die(json_encode(['error'=>$vid_err]));
            }else{
                die(json_encode(['error'=>'Failed to upload video.']));
            }
        }
        if(count($img_err) > 0){
            die(json_encode(['error'=>$img_err[0]]));
        }else{
            if(empty($_POST['slider_images'])){
                $_POST['slider_images'] = implode(',', $images);
            }else{
                $_POST['slider_images'] .= ','.implode(',', $images);
            }
            $_POST['updated_at'] = $dueDatePST;
            if(isset($_POST['id'])){
                $_date = $_POST['date'];
                $_time = $_POST['time'];
                unset($_POST['date']);
                unset($_POST['time']);
                if(!empty($_date) && !empty($_time)){
                    $_POST['created_at'] = $_date.' '.$_time;
                }
            }else{

                $_POST['created_at'] = $dueDatePST;
            }

            unset($_POST['time_zone']);

            if(in_array($_POST['type'], ['simpleblog','simplenews'])){

            }
            if(in_array($_POST['type'], ['video-blog','video-news'])){
                $_POST['content_thumbnail'] = $_POST['thumbnail'];
            }
            $remove_string = $main_domain.'community/';

            if(in_array($_POST['type'], ['video-blog','video-news'])){
                if(isset($_POST['old_single_video']) && !empty($_POST['old_single_video']) && $_POST['old_single_video'] != 'undefined'){
                    $_POST['video'] = str_replace($remove_string, '', $_POST['old_single_video']);
                }

                if(isset($_POST['old_single_embed']) && !empty($_POST['old_single_embed']) && $_POST['old_single_embed'] != 'undefined'){
                    $_POST['embed'] = str_replace($remove_string, '', $_POST['old_single_embed']);
                }
            }

            if(in_array($_POST['type'], ['image-slider-blog','image-slider-news'])){
                if(isset($_POST['old_slider_images']) && !empty($_POST['old_slider_images']) && $_POST['old_slider_images'] != 'undefined'){
                    $_POST['old_slider_images'] = str_replace($remove_string.'uploads/images/', '', $_POST['old_slider_images']);
                    $img_list = explode(',', $_POST['slider_images']);
                    $img_list = array_values(array_filter($img_list));
                    $new_list = array_merge($img_list,$_POST['old_slider_images']);
                    $_POST['slider_images'] = implode(',', array_values(array_filter($new_list)));
                }
            }

            if(in_array($_POST['type'], ['video-image-blog','video-image-news'])){
                if(isset($_POST['old_vid_slider_images']) && !empty($_POST['old_vid_slider_images']) && $_POST['old_vid_slider_images'] != 'undefined'){
                    $img_list = explode(',', $_POST['slider_images']);
                    $img_list = array_values(array_filter($img_list));
                    $new_list = array_merge($img_list,$_POST['old_vid_slider_images']);
                    $_POST['slider_images'] = implode(',', array_values(array_filter($new_list)));
                }
                if(isset($_POST['old_video']) && !empty($_POST['old_video'])){
                    $_POST['video'] = $_POST['old_video'];
                }
            }

            if(isset($_POST['youtube_embed']) && !empty($_POST['youtube_embed'])){
                $_POST['embed'] = $_POST['youtube_embed'];
                unset($_POST['youtube_embed']);
            }

            if(isset($_POST['selected_slug']) && !empty($_POST['selected_slug'])){
                $_POST['slug'] = $_POST['selected_slug'];
            }
            
            unset($_POST['lang']);
            unset($_POST['selected_slug']);
            unset($_POST['old_slider_images']);
            unset($_POST['old_vid_slider_images']);
            unset($_POST['old_video']);
            unset($_POST['old_single_video']);
            unset($_POST['old_single_embed']);

            $checkVID = explode('/', $_POST['video']);
            if($checkVID[count($checkVID) - 1] == 'Wild animals name and sound.mp4'){
                $_POST['single_image'] = 'video_thumbnail.png';
                $_POST['content_thumbnail'] = 'video_thumbnail.png';
            }
          
            $_POST['slider_images'] = str_replace(',,', ',', $_POST['slider_images']);
            $_POST['slider_images'] = rtrim($_POST['slider_images'],',');
            
            if($_POST['type'] == 'video-image-blog' || $_POST['type'] == 'video-image-news'){
                if(count(explode(',', $_POST['slider_images'])) > 4){
                    die(json_encode(['error'=>'Please upload only 4 images.']));
                }
            }
            if(!empty($pdfPath)){
                $_POST['pdf_path'] = $pdfPath;
            }
            
            $getContentById = mysqli_query($conn,"SELECT * FROM ".$table.' WHERE id = '.$_POST['id']);
            $contentRow = mysqli_fetch_assoc($getContentById);
            if(isset($_POST['id']) && !empty($_POST['id'])){
                $_POST['type'] = $contentRow['type'];
            }

            if(in_array($_POST['type'],['video-image-blog','video-image-news','video-blog','video-news'])){
                if(!isset($_POST['video']) || empty($_POST['video'])){
                    $validateYoutubeURL = $_POST['embed'];
                    $urlParts = explode('/',$validateYoutubeURL);
                    if($urlParts[0] == "https:" && $urlParts[2] == "www.youtube.com" && $urlParts[3] == "embed"){
                    }else{
                        die(json_encode(['error'=>'Video url is invalid.']));
                    }
                }
            }

            if(isset($_POST['embed']) && !empty($_POST['embed'])){
                $_POST['video'] = '';
            }
            // die(json_encode($_POST));
            $T = db_pair_str2( $_POST);

            if(isset($_POST['id'])){
                $sql = "UPDATE `".$table."` SET ".$T." WHERE id = ".$_POST['id'];
            }else{
                $sql = "INSERT INTO `".$table."` SET ".$T;
            }
            $check = mysqli_query($conn,$sql);
            
            if($check){
                die(json_encode(['success'=>'success']));
            }else{
                die(json_encode(['error'=>'Failed to post.']));
            }
        }
    }
}

if($_GET['h'] == 'deleteBlog'){
    if(isset($_POST['cur_lang'])){
        $data = mysqli_query($conn,"SELECT * FROM blog_content".$_POST['cur_lang']." WHERE id = ".$_POST['id']);
        $row = mysqli_fetch_assoc($data);
        if(!empty($row)){
            $slug = $row['slug'];
            if(isset($_POST['lang'])){
                if($_POST['lang'] == "delete_all"){
                    for($i = 0; $i < count($blog_content_list); $i++){
                        mysqli_query($conn,"DELETE FROM ".$blog_content_list[$i]." WHERE slug = '".$slug."'");
                    }
                }else{
                    mysqli_query($conn,"DELETE FROM blog_content".$_POST['cur_lang']." WHERE id = '".$_POST['id']."'");
                }
                die(json_encode(['success'=>'success']));
            }
        }else{
            die(json_encode(['error'=>'Failed to delete.']));
        }
    }else{
        die(json_encode(['error'=>'Failed to delete.']));
    }

    // $check = mysqli_query($conn,"DELETE FROM blog_content WHERE id = ".$_POST['id']);
    // mysqli_query($conn,"DELETE FROM comments WHERE content_id = ".$_POST['id']);
    // mysqli_query($conn,"DELETE FROM comments_reply WHERE content_id = ".$_POST['id']);
    // if($check){
    //     echo json_encode(['success'=>'success']);
    // }else{
    //     echo json_encode(['error'=>'error']);
    // }

}

if($_GET['h'] == 'deleteAdminNews'){
    if(isset($_POST['cur_lang'])){
        $data = mysqli_query($conn,"SELECT * FROM news_content".$_POST['cur_lang']." WHERE id = ".$_POST['id']);
        $row = mysqli_fetch_assoc($data);
        if(!empty($row)){
            $slug = $row['slug'];
            if(isset($_POST['lang'])){
                if($_POST['lang'] == "delete_all"){
                    for($i = 0; $i < count($news_content_list); $i++){
                        mysqli_query($conn,"DELETE FROM ".$news_content_list[$i]." WHERE slug = '".$slug."'");
                    }
                }else{
                    mysqli_query($conn,"DELETE FROM news_content".$_POST['cur_lang']." WHERE id = '".$_POST['id']."'");
                }
                die(json_encode(['success'=>'success']));
            }
        }else{
            die(json_encode(['error'=>'Failed to delete.']));
        }
    }else{
        die(json_encode(['error'=>'Failed to delete.']));
    }
    // $check = mysqli_query($conn,"DELETE FROM news_content WHERE id = ".$_POST['id']);
    // mysqli_query($conn,"DELETE FROM news_comments WHERE content_id = ".$_POST['id']);
    // mysqli_query($conn,"DELETE FROM news_comments_reply WHERE content_id = ".$_POST['id']);
    // if($check){
    //     echo json_encode(['success'=>'success']);
    // }else{
    //     echo json_encode(['error'=>'error']);
    // }
}


if ( $_GET[ 'h' ] == 'del_form' ) {
    $sql = mysqli_query( $conn, "DELETE  FROM `user_form` WHERE id ='{$_POST['id']}'" );
    if ( $sql  ) {
        $sql1 = mysqli_query( $conn, "DELETE  FROM `score_calculation` WHERE user ='{$_POST['id']}'" );
        $sql2 = mysqli_query( $conn, "DELETE  FROM `score_calculation2` WHERE user ='{$_POST['id']}'" );

        die( json_encode( array( 'Success' => 'true', 'Msg' => ' Submission Deleted Successfully' ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => ' No submission exist' ) ) );
    }
}



// Process Multi Lingual Translation Files in DB 
if ( $_GET[ 'h' ] == 'processTrans' ) {
    $getFile = mysqli_query($conn , "SELECT * FROM `multi-lingual` WHERE id = '{$_POST['id']}'");
    $row = mysqli_fetch_assoc($getFile);
    $filePath = $_SERVER[ 'DOCUMENT_ROOT' ]."/superadmin/uploads/multi_lingual/" . $row[ 'file_name' ];

    $col=$row['lang_slug'];
    if($col=='francais')
    {
        $col='french';
    }

    $objPHPExcel = new PHPExcel();
    $objPHPExcel = PHPExcel_IOFactory::load( $filePath );
    $worksheetList = $objPHPExcel->getSheetNames();

    $objPHPExcel->setActiveSheetIndex( 0 );
    $excelData = $objPHPExcel->getActiveSheet( 0 )->toArray();

    $totRec = sizeof( $excelData );
    $sheet = $objPHPExcel->getSheet( 0 );
    $highest_column = $sheet->getHighestColumn();

    // Loop to update translation questions/sub question
    for ( $i = 1; $i <= $totRec - 1; $i++ ) {
        if($excelData[$i][2]=='1' || $excelData[$i][2]==1)
        {
            $question = str_replace("'","\'",$excelData[$i][0]);
            $trans = mysqli_real_escape_string($conn , $excelData[$i][1]);

            $getQues = mysqli_query($conn , "SELECT * FROM questions WHERE question = '$question' AND form_id = '10'");
            if(mysqli_num_rows($getQues) > 0){

                $query = mysqli_query($conn , "UPDATE questions SET question_$col = '$trans' WHERE question = '$question'");
            }

            $getQues = mysqli_query($conn , "SELECT * FROM sub_questions WHERE question = '$question'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE sub_questions SET question_$col = '$trans' WHERE question = '$question'");
            }

            $getQues = mysqli_query($conn , "SELECT * FROM level2_sub_questions WHERE question = '$question'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE level2_sub_questions SET question_$col = '$trans' WHERE question = '$question'");
            }
        }




    }

    // Loop to update translation questions/sub question

    $objPHPExcel->setActiveSheetIndex( 1 );
    $excelDataNotes = $objPHPExcel->getActiveSheet( 1 )->toArray();

    $totRecNotes = sizeof( $excelDataNotes );
    $sheetNotes = $objPHPExcel->getSheet( 1 );
    $highest_column = $sheetNotes->getHighestColumn();

    for ( $i = 1; $i <= $totRecNotes - 1; $i++ ) {
        if($excelDataNotes[$i][2]=='1' || $excelDataNotes[$i][2]==1)
        {
            $notes = str_replace("'","\'",$excelDataNotes[$i][0]);

            $trans = mysqli_real_escape_string($conn , $excelDataNotes[$i][1]);

            $getQues = mysqli_query($conn , "SELECT * FROM questions WHERE notes = '$notes' AND form_id = '10'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE questions SET notes_$col = '$trans' WHERE notes = '$notes'");
            }

            $getQues = mysqli_query($conn , "SELECT * FROM sub_questions WHERE notes = '$notes'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE sub_questions SET notes_$col = '$trans' WHERE notes = '$notes'");
            }
            $getQues = mysqli_query($conn , "SELECT * FROM level2_sub_questions WHERE notes = '$notes'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE level2_sub_questions SET notes_$col = '$trans' WHERE notes = '$notes'");
            }
            $getQues = mysqli_query($conn , "SELECT * FROM score_questions WHERE comments = '$notes'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE score_questions SET comments_$col = '$trans' WHERE comments = '$notes'");
            }
            $getQues = mysqli_query($conn , "SELECT * FROM score_questions2 WHERE comments = '$notes'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE score_questions2 SET comments_$col = '$trans' WHERE comments = '$notes'");
            }
        }

    }

    // Loop to update translation countries

    $objPHPExcel->setActiveSheetIndex( 6 );
    $excelDataCoun = $objPHPExcel->getActiveSheet( 6 )->toArray();

    $totRecCoun = sizeof( $excelDataCoun );
    $sheetCoun = $objPHPExcel->getSheet( 6 );
    $highest_column = $sheetCoun->getHighestColumn();

    for ( $i = 1; $i <= $totRecCoun - 1; $i++ ) {
        if($excelDataCoun[$i][2]=='1' || $excelDataCoun[$i][2]==1)
        {
            $country = $excelDataCoun[$i][0];
            $trans = mysqli_real_escape_string($conn , $excelDataCoun[$i][1]);

            $getQues = mysqli_query($conn , "SELECT * FROM countries WHERE name = '$country'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE countries SET name_$col = '$trans' WHERE name = '$country'");
            }else{
                $query = mysqli_query($conn , "INSERT into countries (name , name_$col) VALUES ('$country' , '$trans')");

            }
        }

    }


    // Loop to update translation education options

    $objPHPExcel->setActiveSheetIndex( 4 );
    $excelDataEdu = $objPHPExcel->getActiveSheet( 4 )->toArray();

    $totRecEdu = sizeof( $excelDataEdu );


    for ( $i = 1; $i <= $totRecEdu - 1; $i++ ) {
        if($excelDataEdu[$i][2]=='1' || $excelDataEdu[$i][2]==1)
        {
            $education = $excelDataEdu[$i][0];
            $trans = mysqli_real_escape_string($conn , $excelDataEdu[$i][1]);

            $getQues = mysqli_query($conn , "SELECT * FROM education WHERE name = '$education'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE education SET name_$col = '$trans' WHERE name = '$education'");
            }else{
                $query = mysqli_query($conn , "INSERT into education (name , name_$col) VALUES ('$education' , '$trans')");

            }
        }

    }


    // Loop to update translation static labels

    $objPHPExcel->setActiveSheetIndex( 3 );
    $excelDataLabel = $objPHPExcel->getActiveSheet( 3 )->toArray();

    $totRecLabel = sizeof( $excelDataLabel );


    for ( $i = 1; $i <= $totRecLabel - 1; $i++ ) {
        if($excelDataLabel[$i][2]=='1' || $excelDataLabel[$i][2]==1)
        {
            $label = $excelDataLabel[$i][0];
            $trans = mysqli_real_escape_string($conn , $excelDataLabel[$i][1]);

            $getQues = mysqli_query($conn , "SELECT * FROM static_labels WHERE label = '$label'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE static_labels SET label_$col = '$trans' WHERE label = '$label'");
            }else{
                $query = mysqli_query($conn , "INSERT into static_labels (label , label_$col) VALUES ('$label' , '$trans')");

            }
        }

    }


    // Loop to update translation options

    $objPHPExcel->setActiveSheetIndex( 2 );
    $excelDataOption = $objPHPExcel->getActiveSheet( 2 )->toArray();

    $totRecOption = sizeof( $excelDataOption );


    for ( $i = 1; $i <= $totRecOption - 1; $i++ ) {
        if($excelDataOption[$i][2]==1 || $excelDataOption[$i][2]=='1')
        {
            $Option = str_replace("'","\'",$excelDataOption[$i][0]);
            $trans = mysqli_real_escape_string($conn , $excelDataOption[$i][1]);

            $getQues = mysqli_query($conn , "SELECT * FROM question_labels WHERE label = '$Option'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE question_labels SET label_$col = '$trans' WHERE label = '$Option'");
            }

            $getQues = mysqli_query($conn , "SELECT * FROM level1 WHERE label = '$Option'");
            if(mysqli_num_rows($getQues) > 0){
                $query = mysqli_query($conn , "UPDATE level1 SET label_$col = '$trans' WHERE label = '$Option'");
            }
        }


    }


    // Loop to update noc

    $objPHPExcel->setActiveSheetIndex( 5 );
    $excelDataNoc = $objPHPExcel->getActiveSheet( 5 )->toArray();

    $totRecNoc = sizeof( $excelDataNoc );


    for ( $i = 1; $i <= $totRecNoc - 1; $i++ ) {
        if($excelDataNoc[$i][2]!=='1' && $excelDataNoc[$i][2]!==1)
        {
            continue;
        }
        $label = $excelDataNoc[$i][0];
        $trans = mysqli_real_escape_string($conn , $excelDataNoc[$i][1]);

        $label1 = $excelDataNoc[$i][2];
        $trans1 = mysqli_real_escape_string($conn , $excelDataNoc[$i][3]);

        $getQues = mysqli_query($conn , "SELECT * FROM noc_translation WHERE job_position = '$label'");
        if(mysqli_num_rows($getQues) > 0){
            $query = mysqli_query($conn , "UPDATE noc_translation SET job_position_$col = '$trans' WHERE job_position = '$label'");
            $query = mysqli_query($conn , "UPDATE noc_translation SET job_duty_$col = '$trans1' WHERE job_duty = '$label1'");
        }else{
            $query = mysqli_query($conn , "INSERT into noc_translation (job_position , job_position_$col , job_duty , job_duty_$col) VALUES ('$label' , '$trans' , '$label1' , '$trans1')");

        }
    }

    die( json_encode( array( 'Success' => 'true', 'Msg' => ' Translation Updated Successfully' , 'Questions' => $ntQues) ) );

}



if($_GET['h'] == 'loadLabels'){
    $data=array();
    $select = mysqli_query($conn,"select * from static_labels");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        if($row['id']!=815 && ($row['label']==='' || $row['label']===null || $row['label_french']==='' || $row['label_french']===null ||$row['label_spanish']==='' || $row['label_spanish']===null ||$row['label_urdu']==='' || $row['label_urdu']===null ||$row['label_chinese']==='' || $row['label_chinese']===null ||$row['label_hindi']==='' || $row['label_hindi']===null ||$row['label_punjabi']==='' || $row['label_punjabi']===null))
        {
            $row['status']='Pending';
        }
        if($row['status']=='Pending')
        {
            $class='badge-soft-warning';
        }
        if($row['status']=='Done')
        {
            $class='badge-soft-success';
        }
        if($row['status']=='Will do later')
        {
            $class='badge-soft-secondary';
        }
        $row['status']='<span style="width: 100%;" class="badge rounded-pill '.$class.' font-size-12">'.$row['status'].'</span>';

        $row['count']=$count;
        $row['action']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $row['action2']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a> <a href="javascript:void(0)" onClick="DeleteModal('.$row['id'].')" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'addStaticLabel'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"insert into static_labels set $T");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Label has been added successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'updateStaticLabel'){
    mysqli_set_charset('utf8',$conn);

    $sql = "select * from `admin` WHERE id='{$_SESSION[ 'userID' ]}'  ";
    $get_admin = mysqli_query( $conn, $sql );
    $get_admin_row=mysqli_fetch_assoc($get_admin);
    $_POST['n']['updated_date']=$current_date;
    $_POST['n']['updated_by']=$get_admin_row['email'];
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"update static_labels set $T where id={$_POST['id']} ");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Label has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'deleteStaticLabel'){
    $delete = mysqli_query($conn,"DELETE FROM static_labels WHERE id = '{$_POST['id']}'");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Label has been deleted successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}

if($_GET['h'] == 'loadCountries'){
    $data=array();
    $select = mysqli_query($conn,"select * from countries");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['count']=$count;
        $row['action']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $row['action'].='<a href="javascript:void(0)" onClick="DeleteModal('.$row['id'].')" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'addCountry'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"insert into countries set $T");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Country has been added successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'updateCountry'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"update countries set $T where id={$_POST['id']} ");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Country has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'deleteCountry'){
    $delete = mysqli_query($conn,"DELETE FROM countries WHERE id = '{$_POST['id']}'");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Country has been deleted successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}


if($_GET['h'] == 'loadEducation'){
    $data=array();
    $select = mysqli_query($conn,"select * from education");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['count']=$count;
        $row['action']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $row['action'].='<a href="javascript:void(0)" onClick="DeleteModal('.$row['id'].')" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'addEducation'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"insert into education set $T");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Education Option has been added successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'updateEducation'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"update education set $T where id={$_POST['id']} ");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Education Option has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'deleteEducation'){
    $delete = mysqli_query($conn,"DELETE FROM education WHERE id = '{$_POST['id']}'");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Education Option has been deleted successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}

if($_GET['h'] == 'loadblogCategory'){
    $data=array();
    $select = mysqli_query($conn,"select * from category_blog");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['count']=$count;
        $row['action']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $row['action'].='<a href="javascript:void(0)" onClick="DeleteModal('.$row['id'].')" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'addblogCategory'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"insert into category_blog set $T");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Blog Category Option has been added successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'updateblogCategory'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"update category_blog set $T where id={$_POST['id']} ");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Blog Category Option has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'deleteblogCategory'){
    $delete = mysqli_query($conn,"DELETE FROM category_blog WHERE id = '{$_POST['id']}'");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Blog Category Option has been deleted successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}

if($_GET['h'] == 'loadQuestions'){
    $data=array();
    $select = mysqli_query($conn,"SELECT * FROM questions WHERE form_id = '10' and question!='' and question is not null");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['action']='<a href="?method=edit&type=ques&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadSubQuestions'){
    $data=array();
    $select = mysqli_query($conn,"SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id WHERE q.form_id = '10' and s.question!='' and s.question is not null");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['action']='<a href="?method=edit&type=subques&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadNotes'){
    $data=array();
    $select = mysqli_query($conn,"SELECT *  FROM questions  WHERE form_id = '10' and notes!='' and notes is not null");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['action']='<a href="?method=edit&type=notes&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $data[]=$row;
        $count++;
    }
    $select = mysqli_query($conn,"SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id WHERE q.form_id = '10' and s.notes!='' and s.notes is not null");
    while($row=mysqli_fetch_assoc($select))
    {
        $row['action']='<a href="?method=edit&type=subnotes&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $data[]=$row;
        $count++;
    }
    $select = mysqli_query($conn , "SELECT *  FROM score_questions  WHERE comments!='' and comments is not null");
    while($row=mysqli_fetch_assoc($select))
    {
        $row['id']=$row['id'].'-scoring' ;
        $row['notes']=$row['comments'] ;
        $row['notes_french']=$row['comments_french'] ;
        $row['notes_urdu']=$row['comments_urdu'] ;
        $row['notes_spanish']=$row['comments_spanish'] ;
        $row['notes_chinese']=$row['comments_chinese'];
        $row['notes_hindi']=$row['comments_hindi'] ;
        $row['notes_punjabi']=$row['comments_punjabi'] ;
        $row['action']='';
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}

if($_GET['h'] == 'updateQues_Notes'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);
    $table=$_POST['table'];
    $id=$_POST['id'];

    $update = mysqli_query($conn,"update $table set $T where id=$id ");

    if($update){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Record has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}

if($_GET['h'] == 'loadEmailTemplate'){
    $data=array();
    $select = mysqli_query($conn,"select * from email_templates");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $type=explode(' ',$row['type']);
        $row['type']=ucfirst($type[0]).' '.ucfirst($type[1]);
        $row['count']=$count;
        $row['action']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>';
        $row['action2']='<a href="?method=edit&id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a> <a href="javascript:void(0)" onClick="DeleteModal('.$row['id'].')" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>';
        $data[]=$row;
        $count++;
    }


    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'addEmailTemplate'){
    mysqli_set_charset('utf8',$conn);
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"insert into email_templates set $T");
    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Record has been added successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'updateEmailTemplate'){
    mysqli_set_charset('utf8',$conn);
    $sql = "select * from `admin` WHERE id='{$_SESSION[ 'userID' ]}'  ";
    $get_admin = mysqli_query( $conn, $sql );
    $get_admin_row=mysqli_fetch_assoc($get_admin);
    $_POST['n']['updated_date']=$current_date;
    $_POST['n']['updated_by']=$get_admin_row['email'];
    $T = db_pair_str2( $_POST['n']);

    $delete = mysqli_query($conn,"update email_templates set $T where id={$_POST['id']} ");
    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Record has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'deleteEmailTemplate'){
    $delete = mysqli_query($conn,"DELETE FROM email_templates WHERE id = '{$_POST['id']}'");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Record has been deleted successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'addPage'){
    $T = db_pair_str2( $_POST);

    $delete = mysqli_query($conn,"insert into pages set $T");
    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Record has been added successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
function defaultMail($email, $subject,$from, $body)
{
    global $sendGridAPIKey,$align_class,$currentTheme,$ext;
    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$currentTheme.'superadmin/assets/images/our_canada.png" height="120" alt=""></th>
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
$display_class= '';
$align_class = '';

function checkAlignment($lang_slug)
{
    global $display_class,$align_class,$dir,$conn;
    $getDisp = mysqli_query($conn, "SELECT * FROM `multi-lingual` where lang_slug='$lang_slug'");
    $dispRow = mysqli_fetch_assoc($getDisp);
    if ($dispRow['display_type'] == 'Right to Left') {
        $display_class = 'urduField';
        $align_class = 'text-align: right;';

        $dir = 'rtl';
    }
}

if($_GET['h'] == 'gallery_image'){
    $res = [];
    if(isset($_FILES['file'])){
        if(count($_FILES['file']) > 1){
            if(in_array($_FILES['file']['type'], ['image/jpeg','image/jpg','image/png'])){
                if($_FILES['file']['size'] >= 2097152){
                    $res = ['Msg'=>"File must be less than 2 MB"];
                }else{
                    $newfilename = date('dmYHis').str_replace(" ", "", basename($_FILES["file"]["name"]));
                    $check = move_uploaded_file($_FILES["file"]["tmp_name"], "../community/uploads/gallery/" . $newfilename);
                    if($check){
                        $res = ['path'=>$newfilename];
                    }else{
                        $res = ['Msg'=>'Failed to upload photo.'];
                    }
                }
            }else{
                $res = ['Msg'=>'Please select a valid image.'];
            }
        }else{
            $res = ['Msg'=>"Please select only one image."];
        }
    }else{
        $res = ['Msg'=>'Photo is not found.'];
    }
    if(array_key_exists('path',$res)){
        if(mysqli_query($conn,"INSERT INTO gallery_images (image) VALUES('".$res['path']."')")){
        }else{
            unset($res['path']);
            $res['Msg'] = 'Failed to upload try again';
        }
    }
    die(json_encode($res));
}

if($_GET['h'] == 'loadGalleryContent'){
    $data=array();
    $select = mysqli_query($conn,"SELECT * FROM `gallery_images` ORDER BY id DESC");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $row['count']=$count;
        $row['image']='<img src="https://ourcanada'.$ext.'/community/uploads/gallery/'.$row['image'].'" style="width: 150px;">';
        $row['action']='<a href="javascript:void(0)" onClick="del_ling('.$row['id'].')" class="text-danger"><i class="fas fa-trash"></i> Delete</a>';
        $data[]=$row;
        $count++;
    }


    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}

if($_GET['h'] == 'terms_conditions'){
    if(!isset($_POST['lang_id']) || empty($_POST['lang_id'])){
        die(json_encode(['error'=>'Language is required.']));
    }else if(!isset($_POST['content']) || empty($_POST['content'])){
        die(json_encode(['error'=>'Terms & Condition is empty.']));
    }else{
        $add = true;
        $get_lang = mysqli_query($conn,"SELECT * FROM `terms_conditions` WHERE lang_id = ".$_POST['lang_id']);
        if(mysqli_num_rows($get_lang) > 0){
            if(mysqli_fetch_assoc($get_lang)['status'] != 1){
                $add = false;
            }
        }
        if($add){
            $_POST['created_at'] = date('Y-m-d h:i:s');
            $_POST['updated_at'] = date('Y-m-d h:i:s');
            $_POST['status'] = 1;
            $T = db_pair_str2( $_POST );
            mysqli_query($conn,"INSERT INTO terms_conditions SET ".$T);
            die(json_encode(['success'=>'Record save successfully.']));
        }else{
            die(json_encode(['error'=>'The language you tried to add already exist. Please change language or disable previous one.']));
        }
    }
}

if($_GET['h'] == 'update_terms_conditions'){
    if(!isset($_POST['lang_id']) || empty($_POST['lang_id'])){
        die(json_encode(['error'=>'Language is required.']));
    }else if(!isset($_POST['content']) || empty($_POST['content'])){
        die(json_encode(['error'=>'Terms & Condition is empty.']));
    }else{
        $_POST['created_at'] = date('Y-m-d h:i:s');
        $_POST['updated_at'] = date('Y-m-d h:i:s');
        $_POST['status'] = 1;
        $T = db_pair_str2( $_POST );
        mysqli_query($conn,"UPDATE terms_conditions SET ".$T." WHERE id = ".$_POST['id']);
        die(json_encode(['success'=>'Record update successfully.']));
    }
}


if($_GET['h'] == 'delete_terms_conditions'){
    mysqli_query($conn,"DELETE FROM terms_conditions WHERE id = ".$_POST['id']);
    die(json_encode(['success'=>true]));
}

if($_GET['h'] == 'update_status_terms_conditions'){
    mysqli_query($conn,"UPDATE terms_conditions SET status = !status WHERE id = ".$_POST['id']);
    die(json_encode(['success'=>true]));
}
if($_GET['h'] == 'loadAccounts'){
    $data=array();
    $select = mysqli_query($conn,"select * from accounts order by last_request desc");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        if($row['status']==1)
        {
            $row['action']='Approved';
        }
        else if($row['status']==2)
        {
            $row['action']='Rejected';
        }
        else
        {
            $row['action']=' <a href="javascript:void(0)" onclick="approve(this,\''.$row['id'].'\')" id="editbtn" type="button" class="btn btn-icon btn-success table-button">Approve </a>';
            $row['action'].=' <button id="deletebtn" class="btn btn-icon btn-danger table-button" onclick="reject(\''.$row['id'].'\')" data-toggle="modal" data-target="#smallModal"> Reject </button>';
        }
        $row['created_date']=date('Y-m-d',strtotime($row['created_date']));
        $row['count']=$count;
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}


if($_GET['h'] == 'loadContactUsEmails'){
    $data=array();
    $select = mysqli_query($conn,"select * from contact order by id desc");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {

        $row['action']=' <a href="javascript:void(0)" onclick="sendEmail(this,\''.$row['id'].'\')" id="mailBtn" type="button" class="btn btn-icon btn-success table-button"><i class="fa fa-envelope"></i> </a>';

        $row['created_date']=date('Y-m-d',strtotime($row['created_date']));
        if($row['status']==0)
        {
            $row['status']='Pending';
        }
        else
        {
            $row['status']='Sent';
        }
        $row['count']=$count;
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'sendContactEmail' ) {
    $select = mysqli_query($conn,"select * from contact where id={$_POST['id']}");
    $row=mysqli_fetch_assoc($select);

    $msg='<strong>Name:</strong> '.$row['name'];
    $msg.='<br><strong>Email:</strong> '.$row['email'];
    $msg.='<br><strong>Message:</strong> '.$row['message'];
    $subject=$row['name'].' has contacted OurCanada Services';

    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$currentTheme.'superadmin/assets/images/our_canada.png" height="120" alt=""></th>
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

    $to='maryumakhter1@gmail.com';
    $to1='info@ourcanada.co';
    $to2='fnsheikh29@gmail.com';
    $to4='tanzeel.tecbeck@gmail.com';

    // sendgrid

    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($to1);
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
        $select = mysqli_query($conn,"update contact set status=1 where id={$_POST['id']}");

        die(json_encode(array('Success' => 'true', 'Msg' => 'Email has been sent')));

    } catch (Exception $e) {
        // echo 'Caught exception: ' . $e->getMessage() . "\n";
    }




}


if($_GET['h'] == 'getContentTitleList'){
    if($_POST['content'] == 0){
        $content = $blog_content_list;
    }else{
        $content = $news_content_list;
    }
    $list = [];
    for ($i=0; $i < count($content); $i++) {
        $sql = "SELECT id,slug,title FROM ".$content[$i]." WHERE (type = '".$_POST["type"]."blog' OR type = '".$_POST["type"]."news') && created_by = 1";
        $result = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $row['content_data'] = $content[$i];
            $list[] = $row;
        }
    }
    die(json_encode($list));
}

if($_GET['h'] == 'getContentData'){

    $type = $_POST['type'];
    if($type == 'pdf-content'){
        $type = 'pdf-';
    }
    if($_POST['content'] == 0){
        $content = $blog_content_list;
    }else{
        $content = $news_content_list;
    }

    $select = 'slider_images,single_image,video,embed,pdf_path';
    $images_list = [];
    $video = [];
    $embed = [];
    $pdf = [];
    for ($i=0; $i < count($content); $i++) {
        // $_POST['table']
        $sql = "SELECT ".$select." FROM ".$content[$i]." WHERE (type = '".$type."blog' OR type = '".$type."news') && id = ".$_POST['data_id']." && created_by = 1";
        $result = mysqli_query($conn,$sql);
        while ($row = mysqli_fetch_assoc($result)) {
          
            if(!empty(str_replace(',', '', $row['slider_images']))){
                $getImages = explode(",", $row['slider_images']);
                for ($i=0; $i < count($getImages); $i++) { 
                    array_push($images_list, $getImages[$i]);
                }
            }

            if(!empty($row['single_image'])){
                array_push($images_list, $row['single_image']);
            }

            if(!empty($row['video'])){
                array_push($video, $row['video']);
            }

            if(!empty($row['embed'])){
                array_push($embed, $row['embed']);
            }

            if(!empty($row['pdf_path'])){
                array_push($pdf, $row['pdf_path']);
            }

        }
    }

    for ($i=0; $i < count($images_list); $i++) { 
        $imgPath = explode('/', $images_list[$i]);
        if(count($imgPath) == 1 && !empty(str_replace(' ', '', $images_list[$i]))){
            $images_list[$i] = 'uploads/images/'.$images_list[$i];
        }
    }

    for ($i=0; $i < count($video); $i++) { 
        $vidPath = explode('/', $video[$i]);
        if(count($vidPath) == 1 && !empty(str_replace(' ', '', $video[$i]))){
            $video[$i] = 'uploads/videos/'.$video[$i];
        }
    }

    for ($i=0; $i < count($pdf); $i++) { 
        $pdfPath = explode('/', $pdf[$i]);
        if(count($pdfPath) == 1 && !empty(str_replace(' ', '', $pdf[$i]))){
            $pdf[$i] = $pdf[$i];
        }
    }

    die(json_encode([
        'images' => array_values(array_filter(array_unique($images_list))),
        'video' => array_values(array_filter(array_unique($video))),
        'embed' => array_values(array_filter(array_unique($embed))),
        'pdf' => array_values(array_filter(array_unique($pdf)))
    ]));
}
if($_GET['h'] == 'updateOptions'){
    mysqli_set_charset('utf8',$conn);

    
    $table=$_POST['table'];
    $qid=$_POST['id'];
    $T = db_pair_str2( $_POST['n']);
    $delete = mysqli_query($conn,"update $table set $T where id=$qid ");

    if($delete){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Option has been updated successfully' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong' ) ) );
    }
}
if($_GET['h'] == 'getPos'){
    $data=array();
    $select = mysqli_query($conn,"select * from noc_translation");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {

//        $row['action']=' <a href="javascript:void(0)" onclick="sendEmail(this,\''.$row['id'].'\')" id="mailBtn" type="button" class="btn btn-icon btn-success table-button"><i class="fa fa-envelope"></i> </a>';
        $row['count']=$count;
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}

?>