<?php

session_start();

//error_reporting(0);


date_default_timezone_set('Asia/Karachi');

$CurrentDate = date('m/d/Y');



$currentTheme = "https://".$_SERVER['HTTP_HOST'].'/';

//Admin Logout
if( $_GET['action'] == 'logout' ){
	session_unset();
}
//User Logout
if( $_GET['method'] == 'logout' ){
	session_unset();
}



$global_host_name = "localhost";

$global_user_name = "powbid5_appal";

$global_pwd = "?#M(}r6I~HYc"; // 7vh6yIxAug6A

$global_database = "powbid5_appal";





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





?>
