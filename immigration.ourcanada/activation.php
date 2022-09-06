<?php

require_once 'user_inc.php';
$url='https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] ;
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);


$approved = false;
$rejected=false;
$pending=false;
$email = "";
$select=mysqli_query($conn,"select * from accounts where link='$url'");
if(mysqli_num_rows($select)>0)
{
    $row=mysqli_fetch_assoc($select);
    if($row['status']==1 || $row['status']=='1')
    {
        if($row['expire'] == 1){
            $activation = 2;
        }
        else{
            $activation = 0;
            $email = $row['email'];




            $checkUserResult = mysqli_query($conn,"SELECT * FROM `users` WHERE `email` = '$email' ");
            if(mysqli_num_rows($checkUserResult) > 0)
            {
                $update=mysqli_query($conn,"UPDATE `accounts` SET `expire` = '1' WHERE `id` = '".$row['id']."'");
                mysqli_query($conn,"UPDATE `users` SET `role` = '1' WHERE `email` = '$email'");
                $approved = true;
                $_SESSION['tmp_pro_approved'] = "yes";
                echo '<script>window.location.assign("'.$currentTheme.'/login'.$langURL.'")</script>';
            }
        }
    }
    else if($row['status']==2 || $row['status']=='2')
    {
        $rejected = true;
    }
    else
    {
        $pending=true;
    }

}
else
{
    $activation = 1;
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/activation<?php echo $langURL ?>" />


    <!--title-->
    <title><?php echo $allLabelsArray[276] ?> | OurCanada</title>

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

                <?php
                if($pending)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="hero-content-left text-white text-center" style="margin-top: 15%">
                            <h1 style="font-size: 90px !important;">404</h1>
                            <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[262] ?>" ><?php echo $allLabelsArray[262] ?></p>
                        </div>
                    </div>
                        <?php
                }
                else if($rejected)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="hero-content-left text-white text-center" style="margin-top: 15%">
                            <h1 style="font-size: 90px !important;">404</h1>
                                <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[312] ?>" ><?php echo $allLabelsArray[312] ?></p>
                        </div>
                    </div>
                    <?php
                }
               else if($activation == 0 || $approved) { ?>
                    <div class="col-md-6 col-lg-6">
                        <div class="hero-content-left text-white">
                            <h1 class="static_label" data-org="<?php echo $allLabelsEnglishArray[165] ?>"><?php echo $allLabelsArray[165] ?></h1>
                            <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[166] ?>"><?php echo $allLabelsArray[166] ?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <div class="card login-signup-card shadow-lg mb-0">
                            <div class="card-body px-md-5 py-6" style="padding-bottom: 0px !important">

                                <div class="prompt">
                                    <div class="alert alert-info static_label" data-org="<?php echo $allLabelsEnglishArray[223] ?>"><?php echo $allLabelsArray[223] ?></div>
                                </div>
                                <form class="login-signup-form" id="validateform" method="post">


                                    <input type="hidden" name="pro_req_id" value="<?php echo $row['id']; ?>">

                                    <div class="form-group">
                                        <!-- Label -->
                                        <label class="pb-1 static_label " data-org="<?php echo $allLabelsEnglishArray[145] ?>"><?php echo $allLabelsArray[145] ?></label>
                                        <!-- Input group -->
                                        <div class="input-group input-group-merge">

                                            <input type="email" readonly class="form-control" placeholder="name@address.com" name="n[email]" required value="<?php echo $email; ?>">
                                        </div>
                                    </div>


                                    <!-- Password -->
                                    <div class="form-group">
                                        <label class="static_label " data-org="<?php echo $allLabelsEnglishArray[146] ?>"><?php echo $allLabelsArray[146] ?></label>
                                        <div class="input-group input-group-merge">

                                            <input type="password" class="form-control"
                                                   placeholder="Enter your password" name="n[password]" required id="pass">
                                        </div>
                                        <label class="error" id="passError4" style="display: none"><span><i class="fa fa-exclamation-triangle"></i></span> Minimum length 4 characters</label>

                                    </div>


                                    <div class="my-4">

                                        <div class="custom-control custom-checkbox mb-1">
                                            <input type="checkbox" class="custom-control-input" id="check-terms" onchange="$('#rerror').hide()">
                                            <label class="custom-control-label" for="check-terms"><span> <a  href="<?php echo $mainURL; ?>/terms<?php echo $langURL; ?>"  target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[243] ?>"><?php echo $allLabelsArray[243] ?></a></span></label>
                                            <p class="static_label" data-org="<?php echo $allLabelsEnglishArray[163] ?>" id="rerror" style="color:darkred;display:none"><?php echo $allLabelsArray[163] ?></p>

                                        </div>
                                    </div>
                                    <div class="g-recaptcha" data-sitekey="6LdnEwYaAAAAAI8r7VuqWnhPtTOCZQmw5OIjA6zY"></div>
                                    <input type="hidden" class="form-control" name="n[role]" value="1">
                                    <input type="hidden" class="form-control" name="url" value="<?php echo $_SERVER['REQUEST_URI'] ?>">

                                    <!-- Submit -->
                                    <button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3 static_label" id="btnLoader" data-org="<?php echo $allLabelsEnglishArray[165] ?>"><?php echo $allLabelsArray[165] ?></button>
                                </form>

                            </div>

                            <div class="card-footer bg-transparent border-top px-md-5 text-center">
                                <a href="<?php echo $base_url ?>login<?php echo $langURL; ?>" class="btn secondary-solid-btn border-radius mt-2 mb-2 static_label" data-org="<?php echo $allLabelsEnglishArray[11] ?>" style="background: #000; border:none"><?php echo $allLabelsArray[11] ?></a>

                            </div>
                        </div>
                    </div>
                <?php } else {



                    ?>
                    <div class="col-md-12">
                        <div class="hero-content-left text-white text-center" style="margin-top: 15%">
                            <h1 style="font-size: 90px !important;">404</h1>
                            <?php if($activation == 2) { ?>
                                <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[261] ?>" ><?php echo $allLabelsArray[261] ?></p>
                            <?php } else { ?>
                                <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[739] ?>"><?php echo $allLabelsArray[262] ?></p>
                            <?php } ?>
                        </div>
                    </div>
                    <?php

                } ?>
            </div>
        </div>
    </section>
    <!--hero background image with content slider end-->


</div>




<!--body content wrap end-->
<?php include_once("script.php"); ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>" async defer></script>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>&onload=onloadCallback&render=explicit"

<!--<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"-->
<!--        async defer>-->
<!--</script>-->

<script>
    $('#pass').on('keyup',function () {
        let pass=$('#pass').val()
        var format1 = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        var format2 = /[0-9]/;
        var format3 = /[A-Z]/;
        var format4 = /[a-z]/;

        if(pass=='' || pass==null)
        {
            $('#passError1').hide()
            $('#passError2').hide()
            $('#passError3').hide()
            $('#passError4').hide()
            $('#passError5').hide()
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




    $( '#validateform' ).validate( {
        submitHandler: function () {
            'use strict';
            let pass=$('#pass').val()
            var format1 = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
            var format2 = /[0-9]/;
            var format3 = /[A-Z]/;
            var format4 = /[a-z]/;

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
                $( "#btnLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> '+ static_label_changer('Processing') );
                if(grecaptcha.getResponse().length !== 0){
                    $.ajax( {
                        dataType: 'json',
                        url: "<?php echo $baseURL; ?>/ajax?h=professionalAccount&Lang=<?php echo (empty($language)?"english":$language) ?>",
                        type: 'POST',
                        data: $( "#validateform" ).serialize(),
                        success: function ( data ) {
                            console.log(data)
                            $( "#btnLoader" ).html( static_label_changer('Create Account') );
                            $( "div.prompt" ).html( '' );
                            $( "div.prompt" ).show();
                            if ( data.Success === 'true' ) {
                                window.location.assign("<?php echo $baseURL."/login".$langURL ?>")
                            } else {
                                $( window ).scrollTop( 0 );
                                $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );
                                setTimeout( function () {
                                    $( "div.prompt" ).hide();
                                }, 5000 );

                            }

                        }
                        ,error:function (data)
                        {
                            console.log(data)

                        }
                    } );


                    return false;
                }else{
                    $( window ).scrollTop( 0 );
                    $( "#btnLoader" ).html( static_label_changer('Create Account') );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> '+static_label_changer('Invalid Captcha')+'</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 5000 );

                }


            }
            else
            {
                $('#rerror').show()
            }
        }


    } );


    <?php if(strpos($url,'urdu')!==false){
    ?>
    $('.static_label').css('direction', 'rtl')

    <?php
    } ?>
</script>
</body>

</html>