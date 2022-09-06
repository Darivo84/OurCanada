<?php

require_once  'user_inc.php';
header("Location:https://ourcanada".$ext."/contact-us".$langURL);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!--title-->
    <title><?php echo $allLabelsArray[10] ?> | OurCanada</title>


    <?php include_once "style.php" ?>

</head>
<body>

<!--header section start-->
<?php include_once "header.php" ?>
<!--header section end-->

<!--body content wrap start-->
<div class="main">

    <!--header section start-->
    <section class="hero-section ptb-100 gradient-overlay"
             style="background: url('img/header-bg-5.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">
                    <div class="page-header-content text-white text-center pt-sm-5 pt-md-5 pt-lg-0">
                        <h1 class="text-white mb-0"><?php echo $allLabelsArray[10] ?></h1>
                        <div class="custom-breadcrumb">
                            <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0">
                                <li class="list-inline-item breadcrumb-item "><a class="static_label" data-org="<?php echo $allLabelsEnglishArray[7] ?>" href="<?php echo $baseURL.$langURL; ?>"><?php echo $allLabelsArray[7] ?></a></li>
                                <li class="list-inline-item breadcrumb-item active static_label " data-org="<?php echo $allLabelsEnglishArray[10] ?>"><<?php echo $allLabelsArray[10] ?>/li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--header section end-->


    <!--contact us section start-->
    <section class="contact-us-section ptb-100">
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-md-12">
                    <div class="contact-us-form gray-light-bg rounded p-5">
                        <h4 class="static_label" data-org="<?php echo $allLabelsEnglishArray[137] ?>"><?php echo $allLabelsArray[137] ?></h4>
                        <form action="#" method="POST" id="contact_form" class="contact-us-form" novalidate="novalidate">
                            <div class="prompt"></div>
                            <div class="form-row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[116] ?>"><?php echo $allLabelsArray[116] ?></label>
                                        <input type="text" class="form-control" name="name"  required="required">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[117] ?>"><?php echo $allLabelsArray[117] ?></label>
                                        <input type="email" class="form-control" name="email"  required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[140] ?>"><?php echo $allLabelsArray[140] ?></label>
                                        <textarea name="message" id="message" class="form-control" rows="5" cols="25" required></textarea>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="g-recaptcha" data-sitekey="6LdnEwYaAAAAAI8r7VuqWnhPtTOCZQmw5OIjA6zY"></div>

                                </div>
                                <div class="col-sm-12 mt-3">
                                    <button type="submit" class="btn secondary-solid-btn static_label" id="submitBtn" data-org="<?php echo $allLabelsEnglishArray[141] ?>"><?php echo $allLabelsArray[141] ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--contact us section end-->

</div>
<!--body content wrap end-->

<!--footer section start-->
<?php include_once "footer.php" ?>
<!--footer section end-->

<?php include_once "script.php" ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>
<script>
    $('#submitBtn').click(function () {
        $( '#contact_form' ).submit()
    })
    $( '#contact_form' ).validate( {
        submitHandler: function (e) {
            'use strict';
            if(grecaptcha.getResponse().length !== 0)
            {
                $( "#submitBtn" ).html( '  <i class="fa fa-spinner fa-spin"></i> ' + static_label_changer('Processing') );
                $( "#submitBtn" ).prop('disabled',true)
                $.ajax( {
                    dataType: 'json',
                    url: "<?php echo $baseURL; ?>/ajax?h=contact&Lang=<?php echo (empty($language)?"english":$language) ?>",
                    type: 'POST',
                    data: $("#contact_form").serialize(),
                    success: function ( data ) {
                        grecaptcha.reset();
                        $( "#submitBtn" ).html(static_label_changer('Send Message'))
                        $( "#submitBtn" ).prop('disabled',false)
                        $(window).scrollTop(0)
                        if ( data.Success == 'true' ) {
                            $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i> '+static_label_changer(data.Msg)+'</div>');
                            $('#contact_form').trigger('reset')
                            setTimeout(function() {
                                $(".prompt").html('');
                            }, 3000);
                        }
                        else {
                            $(".prompt").html('<div class="alert danger"><i class="fa fa-trash"></i> '+static_label_changer(data.Msg)+'</div>');
                        }
                    }
                } );
                return false;
            }
            else
            {
                $( window ).scrollTop( 0 );
                $( "#btnLoader" ).html( static_label_changer('Send Message') );
                $( '.prompt' ).html( '<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> '+static_label_changer("Invalid Captcha")+'</div>' );
                setTimeout( function () {
                    $( "div.prompt" ).html('');
                }, 5000 );
            }


        }
    } );

</script>

</body>
</html>