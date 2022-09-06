<?php
include_once("user_inc.php");
?>
<?php
$resetcode = "";
$code_is_expire=false;
if(count($getLangUrl) > 3)
{
    $resetcode = $getLangUrl[3];
}
else if(count($getLangUrl) > 2)
{

    $resetcode = $getLangUrl[2];
}

if(empty($resetcode))
{
    header("Location: ".$baseURL."/login".$langURL);
}


$codeCheckQuery = "SELECT * FROM users WHERE  reset_code = '$resetcode'";
$codeCheckResult = mysqli_query($conn,$codeCheckQuery);
if(mysqli_num_rows($codeCheckResult) < 1)
{
    $code_is_expire=true;
//    header("Location: ".$baseURL."/login".$langURL);
}
?>
<!doctype html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/change-password<?php echo $langURL ?>" />


    <!--title-->
    <title><?php echo $allLabelsArray[155] ?> | OurCanada</title>

    <?php include_once("style.php"); ?>

</head>
<body>
<?php include_once("header.php"); ?>

<!--body content wrap start-->
<div class="main">

    <section class="hero-section hero-bg-2 ptb-100 full-screen" <?php if($code_is_expire) { ?> style="opacity: 30%" <?php } ?>>
        <div class="container">
            <div class="row align-items-center justify-content-between pt-5 pt-sm-5 pt-md-5 pt-lg-0">

                <div class="col-md-6 col-lg-6">
                    <div class="hero-content-left text-white">
                        <h1 class="static_label" data-org="<?php echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[246] ?></h1>
                        <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[144] ?>"><?php echo $allLabelsArray[144] ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-5">
                            <div class="mb-5">


                                <h5 class="h3 static_label" data-org="<?php echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[246] ?></h5>
                                <p class="text-muted mb-0 static_label" data-org="<?php echo $allLabelsEnglishArray[247] ?>"><?php echo $allLabelsArray[247] ?></p>
                            </div>
                            <div class="prompt"></div>
                            <!--login form-->
                            <form class="login-signup-form" id="validateform">
                                <input type="hidden" name="code" value="<?php echo $resetcode ?>">
                                <div class="form-group">
                                    <label class="pb-1 static_label" data-org="<?php echo $allLabelsEnglishArray[248] ?>"><?php echo $allLabelsArray[248] ?></label>
                                    <div class="input-group input-group-merge">

                                        <input type="password" class="form-control" name="password" required id="pass">
                                    </div>
                                    <label class="error" id="passError4" style="display: none"><span><i class="fa fa-exclamation-triangle"></i> <?php echo $allLabelsArray[743] ?></span></label>

                                </div>
                                <div class="form-group">
                                    <label class="pb-1 static_label" data-org="<?php echo $allLabelsEnglishArray[249] ?>"><?php echo $allLabelsArray[249] ?></label>
                                    <div class="input-group input-group-merge">

                                        <input type="password" class="form-control" name="cpassword" required>
                                    </div>
                                </div>
                                <!-- Submit -->
                                <button class="static_label btn btn-block secondary-solid-btn border-radius mt-4 mb-3" id="btnLoader" data-org="<?php echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[246] ?></button>

                                <!-- Link -->
                                <div class="text-center">
                                    <small class="text-muted text-center "><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[263] ?>"><?php echo $allLabelsArray[263] ?></span><a href="<?php echo $baseURL; ?>/login<?php echo $langURL; ?>" data-org="<?php echo $allLabelsEnglishArray[11] ?>" class="static_label"><?php echo $allLabelsArray[11] ?></a>.</small>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="expireModal" tabindex="-1" role="dialog" aria-labelledby="expireModalTitle" data-backdrop="static" data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">OurCanada</h5>
                </div>
                <div class="modal-body">
                    <p><?php echo $allLabelsArray[303] ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="secondary-solid-btn" id="okayBtn"><?php echo $allLabelsArray[5] ?></button>
                </div>
            </div>
        </div>
    </div>

</div>
<!--body content wrap end-->

<?php include_once("script.php"); ?>
</body>
<script>
    $('#pass').on('keyup',function () {
        let pass=$('#pass').val()


        if(pass=='' || pass==null)
        {

            $('#passError4').hide()
            return false
        }
        if(pass.length < 4)
        {
            $('#passError4').show()

        }
        else
        {
            $('#passError4').hide()

        }


    })

    $(document).ready(function () {
        <?php if($code_is_expire) { ?>
        $('#expireModal').modal('show')
        <?php } ?>
    })
    $('#okayBtn').click(function () {
        window.location.assign('<?php echo $baseURL.'/login/'.$language ?>')
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

            $( "#btnLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer('Processing') );
            $.ajax( {
                dataType: 'json',
                url: "<?php echo $baseURL; ?>/ajax?h=reset&Lang=<?php echo $language ?>",
                type: 'POST',
                data: $( "#validateform" ).serialize(),
                success: function ( data ) {
                    $( "#btnLoader" ).html( static_label_changer('Change Password') );
                    $( "div.prompt" ).html( '' );
                    $( "div.prompt" ).show();
                    // $( "#validateform" ).trigger('reset')
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        document.getElementById( "validateform" ).reset();
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i> ' + static_label_changer(data.Msg) + '</div>' );
                        setTimeout( function () {
                            window.location.assign("<?php echo $baseURL.'/login/'.$language ?>");
                        }, 1000 );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> ' + static_label_changer(data.Msg) + '</div>' );
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

</html>