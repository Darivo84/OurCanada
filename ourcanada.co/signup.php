<?php
require_once 'cms_error.php';

	header("Location:/");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!--====== Required meta tags ======-->
	<meta charset="utf-8" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<!--====== Title ======-->
	<title>Our Canada || Home Page</title>
	<!--====== Favicon Icon ======-->
<!------------------------>
<?php include("includes/style.php") ?>
</head>

<body>
	<!--[if lte IE 9]>
		<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
	<![endif]-->

	
	<?php include("includes/header.php") ?>

	<section class="contact-section pb-130 pt-130 " id="contact">
		<div class="container">
			<div class="row">
			
				<div class="col-lg-6 wow fadeInRight" data-wow-delay=".3s">
					<div class="contact-form">
						<h4 class="title mb-20 " style="font-size: 3rem;font-weight: 700;">Sign Up</h4>
						<form  id="register-form" method="post">
							<div class="prompt"></div>
							<div class="row">
								<div class="col-12">
								<p>Please sign-up here so you can save your information from the immigration assessment tool and contribute content to our platform and earn tokens that can be used in our online store.  It will also allow you to get personalized updates as Canadian immigration rules and requirements change.</p>
								</div>
								<!--<div class="col-12">
									<textarea name="message" id="message" placeholder="Your Comment"></textarea>
								</div>-->
								<div class="col-md-12 mt-30">
									<input type="text" placeholder="Enter Your Username Here" name="username" id="username" required>
								</div>
								
								<div class="col-md-12 mt-30">
									<input type="email" placeholder="Enter Your Email Here" name="email" id="email" required>
								</div>
								<div class="col-md-12 mt-30">
									<input type="password" placeholder="Enter Your Password Here" name="password" id="password" required>
								</div>
								<div class="col-12 mt-30">
									<button type="submit" id="addLoader" value="Send Message">SUBMIT</button>
								</div>
							</div>
						</form>
					</div>
				</div>
					<div class="col-lg-6 wow fadeInLeft" data-wow-delay=".3s">
					<img style="margin-top: 26px;
    width: 109%;" src="assets/img/canadian-flag.jpg" alt="signup image" >
				</div>
			</div>
		</div>
	</section>
	<!--====== CONTACT SECTION END ======-->
	<!--====== GO TO TOP PART START ======-->
	<div class="go-top-area">
		<div class="go-top-wrap">
			<div class="go-top-btn-wrap">
				<div class="go-top go-top-btn">
					<i class="fal fa-angle-double-up"></i>
					<i class="fal fa-angle-double-up"></i>
				</div>
			</div>
		</div>
	</div>
	<!--====== GO TO TOP PART ENDS ======-->
	<?php include("includes/footer.php") ?>
	<!--====== jquery js ======-->
<?php include("includes/script.php") ?>

<script>
		$(document).ready(function() {
			
			$( '#register-form' ).validate( {
				
				submitHandler: function () {
					'use strict';
					$( "#addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> Processing' );
                    $("#addLoader").prop('disabled',true)

                    $.ajax( {
                        dataType: 'json',
                        url: "ajax.php?h=createUser",
                        type: 'POST',
                        data: $( "#register-form" ).serialize(),
                        success: function ( data ) {
                            if ( data.Success === 'true' )
                            {
                                $(window).scrollTop(0);
                                $( "#addLoader" ).html('Submit');
                                $("#addLoader").prop('disabled',false)
                                $(".prompt").html('<div class="alert alert-success"><i style="margin-right:4px;" class="fa fa-check"></i> User Registered Successfully.</div>');
                            } else
                            {
                                $(window).scrollTop(0);
                                $( "#addLoader" ).html('Submit');
                                $("#addLoader").prop('disabled',false)
                                $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning"></i>Something went wrong while creating user.</div>');
                            }
                        }
                    } );
                    return false;
                }
            } );
		});
		
	</script>
</body>

</html>