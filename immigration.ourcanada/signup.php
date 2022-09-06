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

        <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/signup<?php echo $langURL ?>" />



    <!--title-->
    <title><?php echo $allLabelsArray[135] ?> | OurCanada</title>

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
                        <h1 data-org="<?php echo $allLabelsEnglishArray[165] ?>" class="static_label"><?php echo $allLabelsArray[165] ?></h1>
                        <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[166] ?>"><?php echo $allLabelsArray[166] ?>

                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-6" style="padding-bottom: 0px !important">

                            <div class="prompt specifiedUrduElm"></div>
                            <form class="login-signup-form" id="validateform" method="post">

                                <div class="form-group">
                                    <!-- Label -->
                                    <label class="pb-1 static_label" data-org="<?php echo $allLabelsEnglishArray[145] ?>"><?php echo $allLabelsArray[145] ?></label>
                                    <!-- Input group -->
                                    <div class="input-group input-group-merge">

                                        <input type="email" class="form-control"  name="n[email]" required autocomplete="randomstring">
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group">
                                    <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[146] ?>"><?php echo $allLabelsArray[146] ?></label>
                                    <div class="input-group input-group-merge">

                                        <input type="password" class="form-control" id="pass"
                                               name="n[password]" required autocomplete="new-password">
                                    </div>
                                    <label class="error" id="passError4" style="display: none"><span><i class="fa fa-exclamation-triangle"></i></span> <?= $allLabelsArray[743] ?></label>

                                </div>

                                <div class="my-4">


                                    <div data-l="<?php echo $language ?>" class="custom-control custom-checkbox mb-1 specifiedUrduElm">
                                        <input type="checkbox" class="custom-control-input" id="check-terms" onchange="$('#rerror').hide()">
                                        <label class="custom-control-label <?php if($language=="urdu") { echo 'urduCheckBoxAlign'; } ?> " for="check-terms"> <span><a href="<?php echo $mainURL; ?>/terms<?php echo $langURL; ?>"  target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[243] ?>"><?php echo $allLabelsArray[243] ?></a></span></label>
                                        <p id="rerror" style="color:darkred;display:none" class="static_label" data-org="<?php echo $allLabelsEnglishArray[163] ?>"><?php echo $allLabelsArray[163] ?></p>

                                    </div>
                                </div>
                                <div class="my-4">
                                    <div class="g-recaptcha"  data-sitekey="6LdnEwYaAAAAAI8r7VuqWnhPtTOCZQmw5OIjA6zY" ></div>

                                </div>
                                <!-- Submit -->
                                <button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3" id="btnLoader">
                                    <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[135] ?>"><?php echo $allLabelsArray[135] ?></span>
                                </button>
                            </form>

                        </div>

                        <div class="card-footer bg-transparent border-top px-md-5 text-center">
                            <a href="<?php echo $baseURL; ?>/login<?php echo $langURL; ?>" class="btn secondary-solid-btn border-radius mt-2 mb-2" style="background: #000; border:none">
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[11] ?>"><?php echo $allLabelsArray[11] ?></span>
                            </a>
                            <button href="javascript:void(0)" onclick="$('#account_prompt').modal('show'); return false;" class="btn secondary-solid-btn border-radius mt-2 mb-2" style="background: #683e17; border:none">
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[162] ?>"><?php echo $allLabelsArray[162] ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--hero background image with content slider end-->


</div>

<div class="modal fade" id="account_prompt" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalCenterTitle" data-org="<?php echo $allLabelsEnglishArray[168] ?>"><?php echo $allLabelsArray[168] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="static_label" data-org="<?php echo $allLabelsEnglishArray[169] ?>"><?php echo $allLabelsArray[169] ?></p>
            </div>
            <div class="modal-footer pl-0">
                <button id="closeModa" class="btn btn-danger static_label" data-dismiss="modal" data-org="<?php echo $allLabelsEnglishArray[103] ?>"><?php echo $allLabelsArray[103] ?></button>
                <button id="closeModal" class="btn btn-primary static_label" data-dismiss="modal" data-toggle="modal" data-target="#account" data-org="<?php echo $allLabelsEnglishArray[5] ?>"><?php echo $allLabelsArray[5] ?></button>


            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="account" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="exampleModalCenterTitle" data-org="<?php echo $allLabelsEnglishArray[168] ?>"><?php echo $allLabelsArray[168] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="login-form mt-2" method="post" id="validateform2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="prompt2"></div>
                            <div class="form-group position-relative">
                                <label><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[117] ?>"><?php echo $allLabelsArray[117] ?></span> <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"  required="">
                            </div>
                        </div>


                        <div class="col-lg-12 mb-0">
                            <button class="btn btn-primary btn-block static_label" type="submit" id="btnLoader2" data-org="<?php echo $allLabelsEnglishArray[150] ?>"><?php echo $allLabelsArray[150] ?></button>
                        </div>

                        <div class="col-12 text-center">
                            <p class="mb-0 mt-3"><small class="text-dark mr-2"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[172] ?>"><?php echo $allLabelsArray[172] ?></span> </small> <a href="<?php echo $baseURL; ?>/login<?php echo $langURL; ?>" class="text-dark font-weight-bold static_label"  data-org="<?php echo $allLabelsEnglishArray[11] ?>"><?php echo $allLabelsArray[11] ?></a></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer pl-0">
                <button id="closeModal" class="btn btn-primary static_label" data-dismiss="modal" data-org="<?php echo $allLabelsEnglishArray[174] ?>"><?php echo $allLabelsArray[174] ?></button>

            </div>
        </div>
    </div>
</div>



<!--body content wrap end-->
<?php include_once("script.php"); ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>" async defer></script>

<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>&onload=onloadCallback&render=explicit"
        async defer>
</script>

<script>

    $('#pass').on('keyup',function () {
        let pass=$('#pass').val()
       
        if(pass=='' || pass==null)
        {
                     
$('#passError4').hide()
           
            return false
        }
 else
            {
                $('#passError4').hide()

            }

       
    })

     

    $( '#validateform' ).validate( {

        submitHandler: function () {
            'use strict';
            let pass=$('#pass').val()


            if(pass.length < 4)
            {
                $('#passError4').show()
                return false;
            }
            else
            {
                $('#passError4').hide()

            }
            
            if($('#check-terms').is(':checked'))
            {
                if(grecaptcha.getResponse().length !== 0) {
                    $("#btnLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer('Processing'));
                    $("#btnLoader").prop('disabled',true)
                    $.ajax({
                        dataType: 'json',
                        url: "<?php echo $currentTheme; ?>ajax?h=signup&Lang=<?php echo (empty($language)?"english":$language) ?>",
                        type: 'POST',
                        data: $("#validateform").serialize(),
                        success: function (data) {
                            $("#btnLoader").html(static_label_changer('Sign up'));
                            $("div.prompt").html('');
                            $("div.prompt").show();
                            $("#btnLoader").prop('disabled',false)
                            console.log(data)

                            if (data.Success === 'true') {
                                $(window).scrollTop(0);
                                document.getElementById("validateform").reset();
                                $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');
                                setTimeout(function () {
                                    window.location.assign("<?php echo $baseURL."/login".$langURL ?>")

                                }, 2000);
                            } else {
                                $(window).scrollTop(0);
                                $('.prompt').html('<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');
                                setTimeout(function () {
                                    $("div.prompt").html('');
                                }, 5000);

                            }

                        }
                    });


                    return false;
                }
                else
                {
                    $( window ).scrollTop( 0 );
                    $( "#btnLoader" ).html( static_label_changer('Sign up') );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> '+static_label_changer("Invalid Captcha")+'</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).html('');
                    }, 5000 );
                }
            }
            else
            {
                $('#rerror').show()
            }
        } ,error:function (data)
        {
            console.log(data)

        }


    } );

    $( '#validateform2' ).validate( {
        submitHandler: function () {
            'use strict';

            {
                $( "#btnLoader2" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer('Processing') );
                $( "#btnLoader2" ).prop('disabled',true);
                $( "div.prompt2" ).html( '' );
                $.ajax( {
                    dataType: 'json',
                    url: "<?php echo $currentTheme; ?>ajax?h=professional_account_request&Lang=<?php echo (empty($language)?"english":$language) ?>",
                    type: 'POST',
                    data: $( "#validateform2" ).serialize(),
                    success: function ( data ) {
                        console.log(data)

                        $( "#btnLoader2" ).html( static_label_changer('Create Account') );

                        $( "div.prompt2" ).show();
                        if ( data.Success === 'true' ) {
                            $( window ).scrollTop( 0 );
                            document.getElementById( "validateform2" ).reset();
                            $( '.prompt2' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i> '+static_label_changer(data.Msg)+'</div>' );
                            setTimeout( function () {
                                $( "#btnLoader2" ).html(static_label_changer('Create Account'))
                                $('#closeModal').click()
                                $( "#btnLoader2" ).prop('disabled',false)
                                $( "div.prompt2" ).html( '' );
                                $( "div.prompt2" ).html('');

                            }, 2000 );
                        } else {
                            $( window ).scrollTop( 0 );
                            $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                            setTimeout( function () {
                                $( "div.prompt2" ).html( '' );
                                $( "#btnLoader2" ).prop('disabled',false);
                                $( "#btnLoader2" ).html(static_label_changer('Create Account'))

                                $( "div.prompt2" ).html('');
                            }, 2000 );
                        }

                    }
                    ,error:function (data)
                    {
                        console.log(data)

                    }
                } );


                return false;

            }
            // else
            // {
            //     $('#rerror').show()
            // }
        }


    } );


</script>
</body>

</html>