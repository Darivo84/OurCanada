<?php
	include_once("global.php");
	if(isset($_SESSION['userID']) && !empty($_SESSION['userID']) && (($_SESSION['role'] == 'admin')||($_SESSION['role'] == 'moderator'))){

	}else{
		header("location:login.php");
	}

if(isset($_GET['method']) && $_GET['method'] == 'logout'){
    if($_SESSION['role']=='admin')
    {
        mysqli_query($conn,"UPDATE admin SET cookie='', is_logged = 0 WHERE id  = {$_SESSION[ 'userID' ]}");

    }
    else
    {
        mysqli_query($conn,"UPDATE moderator SET cookie='', is_logged = 0 WHERE id  = {$_SESSION[ 'userID' ]}");

    }

    session_destroy();
		header(("location: login.php"));
	}else{

	}
?>