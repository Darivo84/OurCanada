<?php
	include_once("user_inc.php");

	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && ($_SESSION['role'] == 'user')){
		
	}else{
	    // echo 123;
		//header("location:login".getCurLang($langURL));
	}

	if(isset($_GET['method']) && $_GET['method'] == 'logout'){

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $currentUserLoggedResult = mysqli_query($conn,"SELECT * FROM `users` WHERE id = '$userId'");

            $cuurentLoggeddUser  = mysqli_fetch_assoc($currentUserLoggedResult);
            $currentSession = $cuurentLoggeddUser['session_id'];

            if (!empty($currentSession) && $currentSession == session_id() && ($cuurentLoggeddUser['role'] == "0" || $cuurentLoggeddUser['role'] == 0)) {

                mysqli_query($conn, "UPDATE users SET `is_logged` = '0' WHERE id = '$userId'");
            }
            if($cuurentLoggeddUser['role'] == "1" || $cuurentLoggeddUser['role'] == 1)
            {
                mysqli_query($conn, "UPDATE users SET `is_logged` = '0' WHERE id = '$userId'");
            }
        }
	    
	    
		session_destroy();
		header(("location: login".getCurLang($langURL)));
	}else{
		
	}
?>