<?php

session_start();
$environment=false;
$ext='';

$url = 'https://'.$_SERVER['HTTP_HOST'];
$parsedUrl = parse_url($url);
$host = explode('.', $parsedUrl['host']);
$main_domain = 'https://'.$host[1].'.'.$host[2];
$baseURL = 'https://'.$_SERVER['HTTP_HOST'].'/';

$global_host_name = "";
$global_user_name = "";
$global_pwd = "";
$global_database = "ocs";

$immigrationUrl = "https://immigration.ourcanada".$ext;

if($host[1]=='app' || $host[2]=='app')
{
    $environment=false;
    $global_host_name = "ocs-stg-database01.cotobd1mvnph.ca-central-1.rds.amazonaws.com";
    $global_user_name = "administrator";
    $global_pwd = "s6Hw3769afUSwtk";
    $ext = '.app';
}
else
{
    $environment=true;
    $global_host_name = "ocs-prd-database01.cotobd1mvnph.ca-central-1.rds.amazonaws.com";
    $global_user_name = "administrator";
    $global_pwd = "N2p%tWr2H5xr#3dm";
    $ext = '.co';
}


$profileURL = $baseURL."profiles/";
$conn = mysqli_connect($global_host_name, $global_user_name, $global_pwd);
mysqli_select_db($conn, $global_database) or die(mysqli_error());

$settingsQuery = "SELECT * FROM `ecom_settings` WHERE `id` = '1'";
$settingsResult = mysqli_query($conn, $settingsQuery);
$ecomsettings = mysqli_fetch_assoc($settingsResult);


function db_pair_str2($arVals, $arNoq = array())
{
	global $conn;
	$ret = '';
	foreach ($arVals as $k => $v) {
		if (is_array($arNoq) && in_array($k, $arNoq)) {
			$ret .= sprintf(', %s = %s', $k, $v);
		} else
			$ret .= sprintf(', %s = \'%s\'', $k, mysqli_real_escape_string($conn, $v));
	}
	return substr($ret, 1);
}

