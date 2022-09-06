<?php
session_start();
include_once("global.php");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if ($_GET['h'] == "updateclientInfo") {
    $browser = $_POST['browser'];
    $ipAddress = getIPAddress();
    $timezone = $_POST['timezone'];
    $cdatetime = $_POST['cdatetime'];
    $_SESSION['client_browser'] = $browser;
    $_SESSION['client_ip'] = $ipAddress;
    $_SESSION['client_timezone'] = $timezone;
    $_SESSION['client_datetime'] = $cdatetime;
}
if ($_GET['h'] == "markasresolved") {
    $logId = $_POST['logId'];
    $updateQuery = "UPDATE `form_error_logs` SET resolved = '1' WHERE `id` = '$logId' ";

    if(mysqli_query($conn,$updateQuery))
    {
        echo json_encode(array("status"=>"1"));
    }
    else
    {
        echo json_encode(array("status"=>"0"));
    }


    
}

