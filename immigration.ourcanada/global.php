<?php
ini_set('memory_limit', '-1');
session_set_cookie_params(0, '/', '.ourcanada.co');

session_start();
//date_default_timezone_set('Asia/Karachi');
$environment=false;
$CurrentDate = date('m/d/Y');
$url = 'https://'.$_SERVER['HTTP_HOST'];
$parsedUrl = parse_url($url);
$host = explode('.', $parsedUrl['host']);
$domain = 'https://'.$host[1].'.'.$host[2];
$currentTheme = "https://".$_SERVER['HTTP_HOST'].'/';


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

$conn = mysqli_connect( $global_host_name, $global_user_name, $global_pwd );
mysqli_select_db( $conn, $global_database )or die( mysqli_error() );


$currenTloggedUserId = "";
$conn = mysqli_connect($global_host_name, $global_user_name, $global_pwd);
mysqli_select_db($conn, $global_database) or die(mysqli_error());

if(isset($_SESSION['user_id']))
{
    $currenTloggedUserId = $_SESSION['user_id'];
    mysqli_query($conn,"UPDATE users SET `last_activity_time` = '".date('Y-m-d H:i:s', time())."' WHERE `id` = '$currenTloggedUserId' ");


    $currentUserResult = mysqli_query($conn,"SELECT * FROM users WHERE id ='$currenTloggedUserId'");
    $cuurentUser = mysqli_fetch_assoc($currentUserResult);


}
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

function checkIPAddress()
{
    global $conn;
    $ip_address = getIPAddress();
    $getIP_blocked = mysqli_query($conn, "SELECT * FROM blocked_ip WHERE ip_address = '$ip_address'");
    if(mysqli_num_rows($getIP_blocked)>0)
    {
        $blocked_ipData = mysqli_fetch_assoc($getIP_blocked);
        // $ip_blocked=true;
        return false;
    }
    return true;
}

?>