<?php
include_once("user_inc.php");
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


        <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/password-reset<?php echo $langURL ?>" />

    <!--title-->
    <title><?php echo $allLabelsArray[275] ?> | OurCanada</title>

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
                        <h1 class="static_label" data-org="<?php echo $allLabelsEnglishArray[227] ?>"><?php echo $allLabelsArray[227] ?></h1>
                        <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[144] ?>" ><?php echo $allLabelsArray[144] ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-5">
                            <div class="mb-5">


                                <h5 class="h3 static_label" data-org="<?php echo $allLabelsEnglishArray[153] ?>"><?php echo $allLabelsArray[153] ?></h5>
                                <p class="text-muted mb-0 static_label" data-org="<?php echo $allLabelsEnglishArray[154] ?>"><?php echo $allLabelsArray[154] ?></p>
                            </div>
                            <div class="prompt"></div>
                            <!--login form-->
                            <form class="login-signup-form" id="validateform">
                                <div class="form-group">
                                    <div class="input-group input-group-merge">
                                        <input type="email" class="form-control" placeholder="name@address.com" name="email" required>
                                    </div>
                                </div>
                                <!-- Submit -->
                                <button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3 static_label" data-org="<?php echo $allLabelsEnglishArray[155] ?>" id="btnLoader"><?php echo $allLabelsArray[155] ?></button>

                                <!-- Link -->
                                <div class="text-center">
                                    <small class="text-muted text-center " ><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[263] ?>"><?php echo $allLabelsArray[263] ?></span>
                                        <a class="static_label" data-org="<?php echo $allLabelsEnglishArray[11] ?>" href="<?php echo $baseURL; ?>/login<?php echo $langURL; ?>"><?php echo $allLabelsArray[11] ?></a>
                                    </small>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--hero background image with content slider end-->


</div>
<!--body content wrap end-->

<?php include_once("script.php"); ?>
</body>
<script>


    $( '#validateform' ).validate( {

        errorPlacement: function(error, element) {
            if (element.attr("type") == "radio") {
                error.appendTo(element.parent('div.input-group'));
            } else if (element.attr("data-type") == "date") {
                error.appendTo(element.parent('div.input-group'));
            } else {
                error.insertAfter(element);

            }
            let v = error[0].innerHTML

            if (localStorage.getItem('Lang') !== 'english') {
                v = static_label_changer(v)
            }
            error[0].innerHTML = v
        },
        invalidHandler: function(event, validator) {
            // 'this' refers to the form

            var errors = validator.numberOfInvalids();

            if (errors) {

                setTimeout(function() {
                    $("label.error").each(function() {
                        let target = $(this)
                        if ($(this).css('display') == 'block') {

                            target = $(this)
                            let v = target[0].innerHTML

                            if (localStorage.getItem('Lang') !== 'english') {
                                v = static_label_changer(v)
                            }
                            target[0].innerHTML = v
                        }
                    });
                }, 1000)

            }

        },


        submitHandler: function () {
            'use strict';


            $( "#btnLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer("Processing") );
            $.ajax( {
                dataType: 'json',
                url: "<?php echo $baseURL; ?>/ajax?h=forget&Lang=<?php echo $language;?>",
                type: 'POST',
                data: $( "#validateform" ).serialize(),
                success: function ( data ) {
                    console.log(data)
                    $( "#btnLoader" ).html( static_label_changer('Reset Password') );
                    $( "div.prompt" ).html( '' );
                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        document.getElementById( "validateform" ).reset();
                        $( '.prompt' ).html( '<div class="alert alert-success" ><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                            window.location.assign('<?php echo $currentTheme ?>login<?php echo $langURL ?>')
                        }, 2000 );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger"><i class="fa fa-warning" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                },error:function(data)
                {
                    console.log(data)

                }
            } );


            return false;



        }


    } );

</script>

</html>