<?php

require_once 'cms_error.php';

include_once( "community/user_inc.php" );
$page = 'inner';

?>
<!DOCTYPE html>

<html lang="en-US">

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
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/forgot-password" />

        <?php
    }
    ?>
<!-- Title-->
<title><?= $allLabelsArray[524] ?></title>
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
				<h3 class="categories-title title"><?= $allLabelsArray[525] ?></h3>
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
						<input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="email" autocomplete="email" placeholder="<?= $allLabelsArray[528] ?>" value="" title="<?= $allLabelsArray[527] ?>" required>
					  </p>
						
					  <p class="form-row">
						<button type="submit" class="woocommerce-button button woocommerce-form-login__submit mt-15" name="login" value="<?= $allLabelsArray[11] ?>" id="addLoader"><?= $allLabelsArray[526] ?></button>
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
    $( '#login' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>' );
            //$( "div.prompt" ).html('');
            $.ajax({
                dataType: 'json',
                url: "<?= $cms_url ?>ajax.php?h=forgot_password&lang=<?= getCurLang($langURL,true) ?>",
                type: 'POST',
                data: $("#login").serialize(),
                success: function ( data ) {
                	console.log(data)
                    if ( data.Success == 'true' ) {
	                     $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
	              		 window.location = "<?= $cms_url ?>verify<?= $langURL ?>";
	                }else {
	               		$( "#addLoader" ).html( 'Next' );
	               		$(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning" style="margin-right: 10px;"></i>'+data.Msg+'</div>');
	            	}
                }
            });
            return false;
        }
    });
  });

</script>
</body>

<!-- Mirrored from jellywp.com/disto-preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2020 07:28:44 GMT -->
</html>