<?php
require_once 'cms_error.php';

include_once( $basePath."user_inc.php" );

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

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if($environment==true)
    {
        ?>
        <meta name="author" content="<?= $allLabelsArray[283] ?>">
        <meta name="description" content="<?= $allLabelsArray[781] ?>">
        <meta name="keywords" content="<?= $allLabelsArray[780] ?>">
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/register" />

        <?php

    }
    ?>


    <meta property="og:title" content="<?= $allLabelsArray[769] ?>" />
    <meta property="og:description" content="<?= $allLabelsArray[781] ?>" />
    <meta property="og:image" content="<?= ''  ?>" />
    <meta property="og:url" content="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<!-- Title-->
<title><?= $allLabelsArray[606] ?></title>
<!-- Favicon-->
<?php include($basePath."includes/style.php"); ?>
	<link rel="stylesheet" href="assets/css/shop.css" type="text/css" media="all" />
<!-- end head -->
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
	<div class="options_layout_container full_layout_enable_front"> 
	  <!-- Start header -->
	  <?php include($basePath."includes/header.php"); ?>
	  <!-- end header -->
	  <div class="main_title_wrapper category_title_section">
		<div class="container">
		  <div class="row">
			<div class="col-md-12 main_title_col">
			  <div class="jl_cat_mid_title">
				<h3 class="categories-title title"><?= $allLabelsArray[607] ?></h3>
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
					  <div class="prompt"></div>

					  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="email"><?= $allLabelsArray[145] ?>&nbsp;<span class="required">*</span> </label>
						<input  type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="email" autocomplete="email" placeholder="<?= $allLabelsArray[145] ?>" value="" title="<?= $allLabelsArray[527] ?>" required>
								<span id="emailcheckerror"></span>
					  </p>
					  <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
						<label for="password"><?= $allLabelsArray[146] ?>&nbsp;<span class="required">*</span> </label>
						<input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password" autocomplete="current-password"  placeholder="<?= $allLabelsArray[146] ?>" title="<?= $allLabelsArray[589] ?>" required>
					  </p>
						
					  <p class="form-row">
						<!--<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
						  <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
						  <span>Remember me</span> </label> -->
						<button type="submit" class="woocommerce-button button woocommerce-form-login__submit mt-15" name="login" value="Log in" id="addLoader"><?= $allLabelsArray[203] ?></button>
					  </p>
						<!--<p class="woocommerce-LostPassword lost_password"> <a href="#">Lost your password?</a> </p> -->
					</form>
				  </div>
				</div>
				<div class="brack_space"></div>
			  </div>
			</div>
			
		  </div>
		</div>
	  </section>
		<?php include($basePath."includes/footer.php"); ?>
	  
	</div>
</div>
<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include($basePath."includes/script.php"); ?>
<script>
  $(document).ready(function() {
      var EmailFlag = false;
      $("#email").change(function()
      
      {
         $.ajax({url: "<?= $cms_url ?>ajax.php?h=checkemail&lang=<?php echo getCurLang($langURL,true) ?>",
         method:"POST",
         data:{email:$(this).val()},
         success: function(dataa){

            var output = JSON.parse(dataa);     

     EmailFlag = output.success;
     $("#emailcheckerror").text("");
    if(!output.success)
    {
       $("#emailcheckerror").text(output.msg);
    }
   
    
    
  }});
  
  
      });
      
      
      
     $( '#login' ).validate( {
          submitHandler: function () {
              'use strict';
           
              //$( "div.prompt" ).html('');
        if(EmailFlag)
        {
               $( "#addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>' );
              $.ajax( {
                  dataType: 'json',
                  url: "<?= $cms_url ?>ajax.php?h=signup&lang=<?php echo getCurLang($langURL,true) ?>",
                  type: 'POST',
                  data: $("#login").serialize(),
                  success: function ( data ) {
                      if ( data.Success == 'true' ) 
            {
                        $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
              			setTimeout(function() {
              				window.location.href = "<?= $cms_url.'login'.$langURL ?>";
              		}, 1000);
                      } 
            else 
            {
               $( "#addLoader" ).html( '<?= $allLabelsArray[203] ?>' );
               $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning"></i>'+data.Msg+'</div>');
              
            }
                  }
              } );
              
        }
        else
        {
            
            $("#emailcheckerror").hide();
            
            setTimeout(function(){
                $("#emailcheckerror").show();
            },300);
            
        }
        
          }
      } );
    
  });

</script>
</body>

</html>