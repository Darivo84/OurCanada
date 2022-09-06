<?php
	include_once( "user_inc.php" );
	if(isset($_SESSION['user_id'])){
		
	}else{
        echo '<script>window.location.href = "'.$cms_url.'login'.$langURL.'";</script>';
	}

	if(isset($_GET['method']) && $_GET['method'] == 'logout'){
        mysqli_query($conn, "UPDATE users SET `is_logged` = '0' WHERE id = '{$_SESSION['user_id']}'");
        mysqli_query($conn,"delete from user_sessions where session_id='{$_COOKIE['PHPSESSID']}' and is_logged=1");

        session_destroy();
        echo '<script>window.location.href = "'.$cms_url.'login'.$langURL.'";</script>';
	}else{
		
	}
?>