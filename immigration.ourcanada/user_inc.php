<?php

//if(substr($_SERVER['HTTP_HOST'],-1)!=='/')
//{
//    header("Location :".$_SERVER['HTTP_HOST'].'/');
//}
require_once("global.php");

$baseURL = 'https://'.$_SERVER['HTTP_HOST'];

$urlRediecrtion = preg_replace('~//+~', '/', $_SERVER['REQUEST_URI']);
if($_SERVER['REQUEST_URI'] !== $urlRediecrtion){
	header("Location:".$baseURL.$urlRediecrtion);
}	


$getLangUrl = explode("/",$_SERVER['REQUEST_URI']);
$labelArray=array();
$labelTransArray=array();
$webConversion = true;
$displayType = 'Left to Right';
$pages_array=['view_form','settings','about-us','contact-us','form','test','login','signup','password-reset','change-password','terms','activation','english','forms','myforms','test','formapi'];
$language_code='';
// Checking language if user has open an inner page or if its home page with a different language
if(isset($getLangUrl[2])){
    if(strpos($getLangUrl[2],'?')!==false)
    {
        $urlCheck=explode('?',$getLangUrl[2]);
        if($urlCheck[0]=='formapi') // for mobile url
        {
            $getLangUrl[2]=$urlCheck[0];

        }    }
    $language = $getLangUrl[2];
    $langURL  = '/'.$language;
}else{
    if(strpos($getLangUrl[1],'?')!==false)
    {
        $urlCheck=explode('?',$getLangUrl[1]);
        if($urlCheck[0]=='formapi') // for mobile url
        {
            $getLangUrl[1]=$urlCheck[0];

        }
    }
    $language = $getLangUrl[1];
    $langURL  = '/'.$language;
}

//echo $language;
$mainURL = 'https://ourcanada'.$ext;
$checkError = false;

if($language=='francais')
{
    $language='french';
}
if(isset($language) && !empty($language)){
    // Check if Language exist in system other wise return a 404 page
    $columnName = 'label_'.$language;
    $checkLanguage = mysqli_query($conn , "SELECT * FROM `multi-lingual` WHERE lang_slug = '$language'");

    if(mysqli_num_rows($checkLanguage) > 0){
        $fetchLanguage = mysqli_fetch_assoc($checkLanguage);
        $displayType = $fetchLanguage['display_type'];
        $language_code=$fetchLanguage['language_code'];
        $labels = mysqli_query( $conn, "select label,$columnName from static_labels" );
        while ( $getLabels = mysqli_fetch_assoc( $labels ) ) {
            $labelTransArray[] = $getLabels[ $columnName ];
            $labelArray[]= $getLabels[ 'label' ];
        }
    }else{
        $checkError = true;
        $index = array_search($language, $pages_array);

        if(( $index > -1) || (strpos($_SERVER['REQUEST_URI'],'activation')!==false || strpos($_SERVER['REQUEST_URI'],'change-password')!==false) || ($getLangUrl[1]=='form' && is_numeric($language)) || ($getLangUrl[1]=='test' && is_numeric($language)) || ($getLangUrl[1]=='view_form' && is_numeric($language)))
            {
                $checkError = false;
            }
            else
            {
                $checkError = true;
            }
        $langURL='';
        $language='';

    }
}else{
    $labels = mysqli_query( $conn, "select label from static_labels" );
    while ( $getLabels = mysqli_fetch_assoc( $labels ) ) {

        $labelTransArray[] = $getLabels[ 'label' ];
        $labelArray[]= $getLabels[ 'label' ];

    }
    $langURL='';
    $language='';

}

$allLabelsArray=array();
$allLabelsEnglishArray=array();

$query = mysqli_query($conn,"SELECT * FROM `static_labels`");
while ($result = mysqli_fetch_assoc($query ))
{
    $allLabelsEnglishArray[$result['id']]=$result['label'];
    if(isset($language) && !empty($language))
    {
        if($result['label_'.$language]!=='' && $result['label_'.$language]!==null)
        {
//            $allLabelsArray[$result['id']]=addslashes($result['label_'.$language]);
//            $allLabelsArray[$result['id']]=str_replace('\'','\\\'',$result['label_'.$language]);
              $allLabelsArray[$result['id']]=htmlspecialchars($result['label_'.$language], ENT_QUOTES);

        }
        else
        {
            $allLabelsArray[$result['id']]=$result['label'];

        }
    }
    else
    {
        $allLabelsArray[$result['id']]=$result['label'];

    }
}
$newURL = $langURL;
//$select = mysqli_query($conn, "select * from users where cookie='{$_COOKIE['PHPSESSID']}' and is_logged=1");
$select = mysqli_query($conn, "select * from user_sessions where session_id='{$_COOKIE['PHPSESSID']}' and is_logged=1");

if (mysqli_num_rows($select) > 0) {
    $row1 = mysqli_fetch_assoc($select);

    $select = mysqli_query($conn, "select * from users where id={$row1['user_id']}");

    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = 'user';
    $_SESSION['email']=$row['email'];
    $current_time=date('Y-m-d H:i:s');
    $last_login_time=date('Y-m-d H:i:s',strtotime($row['last_login_time']));
    $logged_in_time=strtotime($current_time)-strtotime($last_login_time);
//    if(($logged_in_time/60) > 180)
//    {
//        unset($_SESSION['user_id']);
//    }
} else {
    unset($_SESSION['user_id']);
//    unset($_SESSION['email']);
    unset($_SESSION['role']);

//        session_unset();
//        session_destroy();
}
?>