<!doctype html>
<html lang="en">
<head>
       <?php
       include_once("includes/style.php");
       $currentTheme = "https://".$_SERVER['HTTP_HOST'].'/';
       ?>

    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome !</h5>
                                            <p>Sign in to continue to Consultation.</p>
                                        </div>
                                    </div>
                                    <div class="col-4 align-self-end">
                                        <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div>
                                    <a href="<?php echo $currentTheme ?>">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="assets/images/logo.png" alt="" class="rounded-circle" height="34">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form class="form-horizontal" method="post" id="validateForm">
        								<div class="prompt"></div>
                                        <div class="form-group">
                                            <label for="username">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="n[email]" placeholder="Enter Email Address" required>
                                        </div>
                
                                        <div class="form-group">
                                            <label for="userpassword">Password</label>
                                            <input type="password" class="form-control" id="password" name="n[password]" placeholder="Enter password" required>
                                        </div>
                
                                        <div class="mt-3">
                                            <button class="btn btn-primary btn-block waves-effect waves-light" type="submit" id="AddLoader">Log In</button>
                                        </div>
            
                                        <div class="mt-4 text-center">
                                            <a href="auth-recoverpw.html" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your password?</a>
                                        </div>
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div>
        </div>

		<?php include_once("includes/script.php"); ?>
		
		
		<script>
		$( '#validateForm' ).validate( {
			submitHandler: function () {
				'use strict';
				$( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Submit' );
				$.ajax( {
					dataType: 'json',
					url: "ajax.php?h=AdminLogin",
					type: 'POST',
					data: $( "#validateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoader" ).html( 'Submit' );
						$( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/index" );
						} else {
							$( window ).scrollTop( 0 );
							$( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
							setTimeout( function () {
								$( "div.prompt" ).hide();
							}, 5000 );

						}

					}
				} );

				return false;
			}
		} );
	</script>
		
    </body>

</html>
