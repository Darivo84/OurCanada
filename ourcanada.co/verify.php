<?php
require_once 'cms_error.php';
include_once( "community/user_inc.php" );
if(!isset($_SESSION['recover_code'])){ ?>
<script type="text/javascript">
	window.open("<?= $cms_url ?>login<?= $langURL ?>","_SELF");
</script>
<?php } ?>
<?php

$query = "SELECT * FROM `news` WHERE `status` = 1 && display_type = 'news' ORDER BY id DESC LIMIT 5";
$result = mysqli_query( $conn, $query );

$querycount = "SELECT count(id) as count FROM `news` where status=1";
$result2 = mysqli_query( $conn, $querycount );
$row1 = mysqli_fetch_assoc( $result2 );
$newscount = $row1[ 'count' ];

$query1 = "SELECT * FROM `content-uploads` ORDER BY id DESC LIMIT 5";
$result1 = mysqli_query( $conn, $query1 );

$querycount1 = "SELECT count(id) as count FROM `content-uploads`";
$result21 = mysqli_query( $conn, $querycount1 );
$row11 = mysqli_fetch_assoc( $result21 );
$blogcount = $row11[ 'count' ];
?>
<!DOCTYPE html>

<html lang="en-US">

<!-- Mirrored from jellywp.com/disto-preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2020 07:26:51 GMT -->
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="">
<meta name="description" content="">
<meta name="keywords" content="">
    <?php
    if($environment)
    {
        ?>
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/verify" />

        <?php
    }
    ?>
<!-- Title-->
<title><?= $allLabelsArray[689] ?></title>
<!-- Favicon-->
<?php include("community/includes/style.php"); ?>
	<link rel="stylesheet" href="assets/css/shop.css" type="text/css" media="all" />
<!-- end head -->
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
	<div class="options_layout_container full_layout_enable_front"> 
	  <!-- Start header -->
	  <?php include("community/includes/header.php"); ?>
	  <!-- end header -->
	  <div class="main_title_wrapper category_title_section">
		<div class="container">
		  <div class="row">
			<div class="col-md-12 main_title_col">
			  <div class="jl_cat_mid_title">
				<h3 class="categories-title title"><?= $allLabelsArray[558] ?></h3>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
	  <section id="content_main" class="clearfix">
		<div class="container">
		  <div class="row main_content"> 
			<!-- begin content -->
			<div class="col-md-4"></div>
			<div class="page-full col-md-4 post-3938 page type-page status-publish hentry" id="content">
			  <div class="content_single_page post-3938 page type-page status-publish hentry">
				<div class="content_page_padding">
				  <div class="woocommerce">
					<div class="woocommerce-notices-wrapper"></div>
					<!--<h2>Login</h2>-->
					<form id="login" class="woocommerce-form woocommerce-form-login login" method="post">
					  <?php if(isset($_SESSION['one_time_msg'])){ ?>
					  <div class="prompt1 alert alert-success" style="color: #000;">
					  	<?php 
					  		echo $_SESSION['one_time_msg'];
					  		unset($_SESSION['one_time_msg']);
					  	?>
					  </div>
					<?php } ?>
					  <div class="prompt"></div>
					  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="code"><?= $allLabelsArray[552] ?> &nbsp;<span class="required">*</span> </label>
						<input type="text" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="code" id="code" placeholder="<?= $allLabelsArray[468] ?>" title="<?= $allLabelsArray[618] ?>" required>
					  </p>
						
					  <p class="form-row" style="text-align: left">
					  	<button type="button" onclick="reSendCode();" class="woocommerce-button button woocommerce-form-login__submit mt-15" id="re_send_code" style="width: auto;"><?= $allLabelsArray[659] ?></button>
						<button type="submit" class="woocommerce-button button woocommerce-form-login__submit mt-15" name="login" value="Log in" id="addLoader" style="width: auto;float: right;"><?= $allLabelsArray[538] ?></button>
					  </p>
					</form>
				  </div>
				</div>
				<div class="brack_space"></div>
			  </div>
			</div>
			
		  </div>
		</div>
	  </section>
		<?php include("community/includes/footer.php"); ?>
	  
	</div>
</div>
<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include("community/includes/script.php"); ?>
<script>
  $(document).ready(function() {
  	setTimeout(function() {
  		$(".prompt1").remove();	
  	},3000);

    $( '#login' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>' );
            //$( "div.prompt" ).html('');
            $.ajax({
                dataType: 'json',
                url: "<?= $cms_url ?>ajax.php?h=verify&lang=<?= getCurLang($langURL,true) ?>",
                type: 'POST',
                data: $("#login").serialize(),
                beforeSend: function(){
                	$(".prompt").html("");
                	$("#re_send_code").prop("disabled",true);
                },
                success: function ( data ) {
                	$("#re_send_code").prop("disabled",false);
                    if ( data.Success == 'true' ) {
	                    // $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
	              		window.location = "<?= $cms_url ?>change-password<?= $langURL ?>";
	                }else {
	               		$( "#addLoader" ).html( '<?= $allLabelsArray[538] ?>' );
	               		$(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning" style="margin-right: 10px;"></i>'+data.Msg+'</div>');
	            	}
                }
            });
            return false;
        }
    });
  });

  function reSendCode(){
  	$.ajax({
  		url: "<?= $cms_url ?>ajax.php?h=re_send_code&lang=<?= getCurLang($langURL,true) ?>",
  		dataType: "json",
  		beforeSend: function(){
  			$("#re_send_code").html('<i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>');
  			$("#re_send_code").prop("disabled",true);
  			$("#addLoader").prop("disabled",true);
  		},
  		success: function(res){
  			$("#addLoader").prop("disabled",false);
  			$("#re_send_code").prop("disabled",false);
  			$("#re_send_code").html('<?= $allLabelsArray[659] ?>');
  			if(res.Success == 'true'){
	            $(".prompt").html('<div class="alert alert-success" style="color: #000;">'+res.Msg+'</div>');
  				setTimeout(function(){
  					$(".prompt").html("");
  				},3000);

  			}else{
	            $(".prompt").html('<div class="alert alert-danger"><i class="fa fa-warning"></i> '+res.Msg+'</div>');
  			}
  		},error: function(e){
  			console.log(e)
  		}
  	});
  }

</script>
</body>

</html>