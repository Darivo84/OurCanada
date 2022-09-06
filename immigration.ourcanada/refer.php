<?php 
	session_start();
	if(isset($_SESSION['user_id'])){
		$_SESSION['with_notify'] = 'You are already logged in.';
		$url='https://immigration.ourcanada.co/'.$_GET['lang'];
	}else{
		$_SESSION['refer_code'] = $_GET['code'];
		$url='https://immigration.ourcanada.co/signup/'.$_GET['lang'];
	}
?>
<script type="text/javascript">
	window.location.href = "<?php echo $url; ?>";
</script>