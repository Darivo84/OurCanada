<?php
ini_set('memory_limit', '-1');
session_set_cookie_params(0, '/', '.ourcanada.co');
session_start();
// date_default_timezone_set('Asia/Karachi');
//date_default_timezone_set('America/Los_Angeles');
    
$environment=false;
$CurrentDate = date('m/d/Y');
$dueDatePST = date('Y-m-d H:i:s');
$dueDatePST = date( 'Y-m-d H:i:s', strtotime( $dueDatePST . '- 1 hour' ) );

$url = 'https://'.$_SERVER['HTTP_HOST'];
$parsedUrl = parse_url($url);
$host = explode('.', $parsedUrl['host']);


$global_host_name = "";
$global_user_name = "";
$global_pwd = "";
$global_database = "ocs3";

if($host[1]=='app' || $host[2]=='app')
{
    $environment=false;
    $global_host_name = "ocs-stg-database01.cotobd1mvnph.ca-central-1.rds.amazonaws.com";
    $global_user_name = "administrator";
    $global_pwd = "s6Hw3769afUSwtk";
}
else
{
    $environment=true;
    $global_host_name = "ocs-prd-database01.cotobd1mvnph.ca-central-1.rds.amazonaws.com";
    $global_user_name = "administrator";
    $global_pwd = "N2p%tWr2H5xr#3dm";
}
if($environment == false){
    $ext = '.app';
}else{
    $ext = '.co';
}

$domain = 'https://'.$host[1].'.'.$host[2];
$main_domain = "https://ourcanada".$ext."/";

$currentTheme = "https://ourcanada".$ext."/community";
$cms_url = $currentTheme.'/';
$img_url = 'https://ourcanada'.$ext.'/';
$default_profile = $cms_url.'uploads/images/profile_thumbnail.png';
$ourcanada_app = $img_url;
if(isset($_GET['url']) && $_GET['url'] == 'community'){
    header('location: '.$cms_url);
}
$conn = mysqli_connect( $global_host_name, $global_user_name, $global_pwd );
mysqli_select_db( $conn, $global_database )or die( mysqli_error() );




function db_pair_str2( $arVals, $arNoq = array() ){
    global $conn;
    $ret = '';
    foreach( $arVals as $k => $v ){
        if( is_array($arNoq) && in_array($k, $arNoq)){
            $ret .= sprintf(', %s = %s', $k, $v );
        }else
            $ret .= sprintf(', %s = \'%s\'', $k, mysqli_real_escape_string( $conn, $v) );
    }
    return substr( $ret, 1 );
}


function simpleBlogThumbnail($index = 0){
    $images = 'uploads/gallery/Alberta.jpg,uploads/gallery/BC.jpg,uploads/gallery/Canada compass.jpg,uploads/gallery/Canada luggage.jpg,uploads/gallery/Canada puzzle.jpg,uploads/gallery/CanadaFlag.jpg,uploads/gallery/Canadian immigration image.jpg,uploads/gallery/Girl Canada documents.jpg,uploads/gallery/Globe travellers.jpg,uploads/gallery/Manitoba.jpg,uploads/gallery/New Brunswick.jpg,uploads/gallery/Newfoundland and Labrador.jpg,uploads/gallery/Northwest Territories.jpg,uploads/gallery/Nova Scotia.jpg,uploads/gallery/Ontario.jpg,uploads/gallery/Quebec.jpg,uploads/gallery/Saskatchewan.jpg,uploads/gallery/Yukon.jpg';
    $imaegsData = explode(',', $images);
    if(isset($imaegsData[$index]) && !empty($imaegsData[$index])){
        return [count($imaegsData),'https://cms.ourcanada.co/'.$imaegsData[$index]];
    }else{
        return [count($imaegsData),'https://cms.ourcanada.co/uploads/gallery/Alberta.jpg'];
    }
}
function getIPAddress()
{
    //whether ip is from the share internet
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } //whether ip is from the remote address
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$main_app = 'https://ourcanada'.$ext.'/';
$cms_url = $main_app.'community/';

$default_profile = $cms_url.'uploads/images/profile_thumbnail.png';
//$environment=true;

?>