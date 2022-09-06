<?php
	include_once("global.php");

	if(isset($_SESSION['adminid']) && !empty($_SESSION['adminid'])){
		
	}else{
		header("location:login.php");
	}

	function getUserDetail($userId)
	{
		global $conn;

		$userDeatilQuery = "SELECT * FROM `users` WHERE id = '$userId' ";
		$outPutResult  = mysqli_query($conn,$userDeatilQuery);
		if(mysqli_num_rows($outPutResult) > 0)
		{
			return mysqli_fetch_assoc($outPutResult);
		}
		
		return "";
	}

?>