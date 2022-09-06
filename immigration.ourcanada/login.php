<?php
include_once("user_inc.php");
if(isset($_SESSION['user_id']))
{
    echo '<script> window.location.assign("'.$currentTheme.$langURL.'")</script>';
}
?>
<!doctype html>
<html lang="en">


<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/login<?php echo $langURL ?>" />


    <!--title-->
    <title><?php echo $allLabelsArray[11] ?> | OurCanada</title>

    <?php include_once("style.php"); ?>

</head>
<body>
<?php include_once("header.php"); ?>

<!--body content wrap start-->
<div class="main">

    <!--hero background image with content slider start-->
    <section class="hero-section hero-bg-2 ptb-100 full-screen">
        <div class="container">
            <div class="row align-items-center justify-content-between pt-5 pt-sm-5 pt-md-5 pt-lg-0">

                <div class="col-md-6 col-lg-6">
                    <div class="hero-content-left text-white">
                        <h1 class="static_label" data-org="<?php echo $allLabelsEnglishArray[143] ?>"><?php echo $allLabelsArray[143] ?></h1>
                        <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[144] ?>"><?php echo $allLabelsArray[144] ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-5">
                            <div class="mb-5">


                                <?php if(isset($_GET['proactive'])){
                                    ?>
<!--                                    <div class="alert alert-info static_label" data-org="--><?php //echo $allLabelsEnglishArray[274] ?><!--">--><?php //echo $allLabelsArray[274] ?><!--</div>-->

                                    <?php

                                }

                                if(isset($_SESSION['tmp_pro_approved']))

                                {
                                    unset($_SESSION['tmp_pro_approved']);
                                    ?>
<!--                                    <div class="alert alert-info static_label" data-org="--><?php //echo $allLabelsEnglishArray[166] ?><!--">--><?php //echo $allLabelsArray[166] ?><!--</div>-->
                                    <?php
                                }

                                ?>

                                <h5 class="h3 static_label" data-org="Login"></h5>
                                <h5 class="text-muted mb-0 static_label" data-org="<?php echo $allLabelsEnglishArray[142] ?>"><?php echo $allLabelsArray[142] ?></h5>
                            </div>
                            <div class="prompt specifiedUrduElm"></div>
                            <!--login form-->
                            <form class="login-signup-form" id="validateform">
                                <div class="form-group">
                                    <label class="pb-1 static_label" data-org="<?php echo $allLabelsEnglishArray[145] ?>"><?php echo $allLabelsArray[145] ?></label>
                                    <div class="input-group input-group-merge">

                                        <input type="email" class="form-control" name="n[email]" required>
                                    </div>
                                </div>
                                <!-- Password -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col">
                                            <label class="pb-1 static_label" data-org="<?php echo $allLabelsEnglishArray[146] ?>"><?php echo $allLabelsArray[146] ?></label>
                                        </div>

                                    </div>
                                    <div class="input-group input-group-merge">

                                        <input type="password" class="form-control" name="n[password]" required>
                                    </div>
                                    <div class="col-auto" style="text-align: right;">
                                        <a href="<?php echo $baseURL; ?>/password-reset<?php echo $langURL; ?>" class="form-text small text-muted static_label" data-org="<?php echo $allLabelsEnglishArray[147] ?>"><?php echo $allLabelsArray[147] ?></a>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <button class="btn secondary-solid-btn border-radius mt-4 mb-3" id="btnLoader">
                                    <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[242] ?>"><?php echo $allLabelsArray[242] ?></span>
                                </button>

                            </form>
                        </div>
                        <div class="card-footer bg-transparent border-top px-md-5 text-center">
                            <a href="<?php echo $baseURL; ?>/signup<?php echo $langURL; ?>" class="btn secondary-solid-btn border-radius mt-2 mb-2" style="background: #000; border:none">
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[210] ?>"><?php echo $allLabelsArray[210] ?></span>
                            </a>
                            <a href="<?php echo $baseURL; ?>/form<?php echo $langURL; ?>" class="btn secondary-solid-btn border-radius mt-2 mb-2" style="background: #683e17; border:none">
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[151] ?>"><?php echo $allLabelsArray[151] ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--hero background image with content slider end-->

    <!-- Continue Login Modal -->
    <!-- Modal -->
    <div class="modal fade" id="continueLoginModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="continueLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title static_label" id="continueLoginModalLabel" data-org="<?php echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[264] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="width: 100%;" id="continueAlert">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary static_label" data-dismiss="modal" data-org="<?php echo $allLabelsEnglishArray[103] ?>"><?php echo $allLabelsArray[103] ?></button>
                    <button type="button" id="continueLoginbtn" class="btn btn-success static_label" data-org="<?php echo $allLabelsEnglishArray[28] ?>"><?php echo $allLabelsArray[28] ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Continue Login Modal -->

</div>
<!--body content wrap end-->

<?php include_once("script.php"); ?>
</body>
<script>

    $(document).on("click","#continueLoginbtn",function(){
        $( "#continueLoginbtn" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer("Processing") );
        $.ajax( {
            dataType: 'json',
            url: "<?php echo $currentTheme; ?>ajax?h=continue_login&Lang=<?php echo (empty($language)?"english":$language) ?>",
            type: 'POST',
            data: $( "#validateform" ).serialize(),
            success: function ( data ) {
                $( "#continueLoginbtn" ).text( static_label_changer('Continue') );
                if ( data.Success === 'true' ) {
                    $( window ).scrollTop( 0 );
                    document.getElementById( "validateform" ).reset();

                    $("#continueLoginbtn").hide();

                    $( '#continueAlert' ).html( '<div class="alert alert-success" style=""><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                    setTimeout( function () {
                        if(data.role == 1)
                        {

                            window.location.assign("<?php echo $baseURL; ?>/myforms<?php echo $langURL ?>")
                        }
                        else
                        {
                            if(localStorage.getItem("guest_in_process"))
                            {
                                if(localStorage.getItem("guest_in_process") == "yes")
                                {
                                    if(localStorage.getItem('Lang') != "English" && localStorage.getItem('Lang') != "english")
                                    {

                                        window.location.assign("<?php echo $baseURL; ?>/form/"+localStorage.getItem('Lang'))

                                    }
                                    else
                                    {
                                        window.location.assign("<?php echo $baseURL; ?>/form<?php echo $langURL ?>")
                                    }
                                }
                                else
                                {
                                    window.location.assign("<?php echo $baseURL; ?>/form<?php echo $langURL ?>")
                                }
                            }
                            else
                            {
                                window.location.assign("<?php echo $baseURL; ?>/form<?php echo $langURL ?>")
                            }

                        }
                    }, 500 );

                }
                else
                {

                }


            },
            error:function(){
                $( "#continueLoginbtn" ).text( static_label_changer('Continue') );
            }
        } );
    })


    $( '#validateform' ).validate( {
        submitHandler: function () {
            'use strict';


            $( "#btnLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer('Processing') );

            var loc_session_id = "";
            var loc_user_id = "";

            if(localStorage.getItem('session_id'))
            {
                loc_session_id = localStorage.getItem('session_id');
                loc_user_id = localStorage.getItem('user_id');
            }


            $.ajax( {
                dataType: 'json',
                url: "<?php echo $currentTheme; ?>ajax?h=login&Lang=<?php echo (empty($language)?"english":$language) ?>",
                type: 'POST',
                data: $( "#validateform" ).serialize()+"&loc_session_id="+loc_session_id+"&loc_user_id="+loc_user_id,
                success: function ( data ) {
                    $( "#btnLoader" ).html( static_label_changer('Sign in') );
                    $( "div.prompt" ).html( '' );
                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        document.getElementById( "validateform" ).reset();
                        $( '.prompt' ).html( '<div class="alert alert-success" style=""><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                        setTimeout( function () {
                            if(data.role == 1)
                            {

                                window.location.assign("<?php echo $baseURL; ?>/myforms<?php echo $langURL ?>")
                            }
                            else
                            {
                                if(localStorage.getItem("guest_in_process"))
                                {
                                    if(localStorage.getItem("guest_in_process") == "yes")
                                    {
                                        if(localStorage.getItem('Lang') != "English" && localStorage.getItem('Lang') != "english")
                                        {

                                            window.location.assign("<?php echo $baseURL; ?>/form/"+localStorage.getItem('Lang'))


                                        }
                                        else
                                        {
                                            window.location.assign("<?php echo $baseURL; ?>/form<?php echo $langURL ?>")
                                        }
                                    }
                                    else
                                    {
                                        window.location.assign("<?php echo $baseURL; ?>/form<?php echo $langURL ?>")
                                    }
                                }
                                else
                                {
                                    window.location.assign("<?php echo $baseURL; ?>/form<?php echo $langURL ?>")
                                }
                            }

                        }, 500 );
                    } else {

                        if(data.status != undefined)
                        {
                            if(data.status == '1' || data.status == 1)
                            {
                                $("#continueAlert").html('<div class="alert alert-info" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');
                                $("#continueLoginModal").modal('show');

                            }
                        }
                        else
                        {
                            $( window ).scrollTop( 0 );
                            $( '.prompt' ).html( '<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                            setTimeout( function () {
                                $( "div.prompt" ).html('');
                            }, 5000 );
                        }



                    }

                }
            } );


            return false;



        }


    } );

</script>

</html>