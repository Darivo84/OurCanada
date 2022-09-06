<?php
require_once 'global.php';
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Login | Consultation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="icon" href="https://ecommerce.ourcanada.co/assets/images/favicon/1.ico" type="image/x-icon">
    <link rel="shortcut icon" href="https://ecommerce.ourcanada.co/assets/images/favicon/1.ico" type="image/x-icon">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
<!--    <div class="home-btn d-none d-sm-block">-->
<!--        <a href="index-2.html" class="text-dark"><i class="fas fa-home h2"></i></a>-->
<!--    </div>-->
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Sign in to continue.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="https://ourcanada<?php echo $ext ?>">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="assets/images/logo.png" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form method="POST" id="login" class="form-horizontal" action="https://themesbrand.com/skote/layouts/vertical/index.html">
                                    <div class="prompt"></div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                    </div>



                                    <div class="mt-3">
                                        <button id="addLoader" class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
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
        $(document).ready(function() {
            $('#login').validate({
                submitHandler: function() {
                    'use strict';
                    $("#addLoader").html('  <i class="fa fa-spinner fa-spin"></i> Processing');
                    //$( "div.prompt" ).html('');

                    $.ajax({
                        dataType: 'json',
                        url: "ajax.php?h=login",
                        type: 'POST',
                        data: $("#login").serialize(),
                        success: function(data) {
                            if (data.Success == 'true') {
                                $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');
                                setTimeout(function() {
                                    window.location = "index.php";
                                }, 500);
                            } else {
                                $("#addLoader").html('Login');
                                $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning"></i>' + data.Msg + '</div>');

                            }
                        }
                    });
                    return false;
                }
            });

        });
    </script>

</body>

<!-- Mirrored from themesbrand.com/skote/layouts/vertical/auth-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 20 Jun 2020 14:05:50 GMT -->

</html>