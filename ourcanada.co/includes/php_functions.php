<?php
ini_set('memory_limit', '-1');
session_set_cookie_params(0, '/', '.ourcanada.app');
session_start();

//date_default_timezone_set('America/Los_Angeles');


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
$global_database = "ocs";

?>