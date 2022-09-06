<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once "user_inc.php";
//echo $_SESSION['user_id'];
//die();
if (isset($_SESSION['user_id'])) {
    $currentSession = $cuurentUser['session_id'];
    $userId = $_SESSION['user_id'];
    if (!empty($currentSession) && $currentSession == session_id() && ($cuurentUser['role'] == "0" || $cuurentUser['role'] == 0)) {

        mysqli_query($conn, "UPDATE users SET `is_logged` = '0' WHERE id = '$userId'");
    }
    if($cuurentUser['role'] == "1" || $cuurentUser['role'] == 1)
    {
        mysqli_query($conn, "UPDATE users SET `is_logged` = '0' WHERE id = '$userId'");
    }
    mysqli_query($conn,"delete from user_sessions where session_id='{$_COOKIE['PHPSESSID']}' and is_logged=1");

}
session_unset();
session_destroy();
$_COOKIE['AgreeCheck']='0';


echo '<script> localStorage.clear(); window.location.assign('."'".$baseURL.'/'.$langURL."'".');</script>';
