<?php

require_once  'user_inc.php';

if(isset($_SESSION['user_id']))
{

}
else
{
    header("Location:".$baseURL."/login".$langURL);

}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php
    if($environment)
    {
        ?>
        <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/settings" />

        <?php
    }
    ?>

    <!--title-->
    <title><?php echo $allLabelsArray[308] ?> | OurCanada</title>


    <?php include_once "style.php" ?>
    <style>
        .contact-us-form.gray-light-bg.rounded.p-5 {
            border: 1px solid #ccc;
            box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%) !important;
            background: #fff;
        }

    </style>

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
                <div class="col-md-6">
                    <div class="contact-us-form gray-light-bg rounded p-5">
                        <h4 class="static_label" data-org="<?php echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[246] ?></h4>
                        <form action="#" method="POST" id="contact_form" class="contact-us-form" novalidate="novalidate">
                            <div class="prompt"></div>
                            <div class="form-row">
                                <input type="hidden" name="id" value="<?php echo $_SESSION['user_id'] ?>">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[307] ?>"><?php echo $allLabelsArray[307] ?></label>
                                        <input type="password" class="form-control" name="old_password" id="oldpass"  required="required">
                                        <i class="far fa-eye-slash eyeIcon" id="toggleOldPassword"></i>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[248] ?>"><?php echo $allLabelsArray[248] ?></label>
                                        <input type="password" class="form-control" name="password" id="pass" required="required">
                                        <i class="far fa-eye-slash eyeIcon" id="toggleNewPassword"></i>

                                    </div>
                                    <label class="error" id="passError4" style="display: none"><span><i class="fa fa-exclamation-triangle"></i></span> <?php echo  $allLabelsArray[743] ?></label>

                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[249] ?>"><?php echo  $allLabelsArray[249] ?></label>
                                        <input type="password" class="form-control" name="conf_password" id="cpass"  required="required">
                                        <i class="far fa-eye-slash eyeIcon" id="toggleConfPassword"></i>

                                    </div>
                                    <label class="error" id="passError" style="display: none"><?php echo $allLabelsArray[523] ?></label>

                                </div>
                                <div class="col-sm-12 mt-3">
                                    <button type="submit" class="btn secondary-solid-btn static_label" id="submitBtn" data-org="<?php echo $allLabelsEnglishArray[22] ?>"><?php echo $allLabelsArray[22] ?></button>
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

<script>
    const toggleOldPassword = document.querySelector('#toggleOldPassword');
    const Oldpassword = document.querySelector('#oldpass');
    toggleOldPassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = Oldpassword.getAttribute('type') === 'password' ? 'text' : 'password';
        Oldpassword.setAttribute('type', type);
        // toggle the eye slash icon
        // this.classList.toggle('fa-eye-slash');
        if($(this).hasClass("fa-eye"))
        {
            $(this).removeClass("fa-eye")
            $(this).addClass("fa-eye-slash")
        }
        else
        {
            $(this).removeClass("fa-eye-slash")
            $(this).addClass("fa-eye")
        }
    });


    const toggleNewPassword = document.querySelector('#toggleNewPassword');
    const newpassword = document.querySelector('#pass');
    toggleNewPassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = newpassword.getAttribute('type') === 'password' ? 'text' : 'password';
        newpassword.setAttribute('type', type);
        // toggle the eye slash icon
        // this.classList.toggle('fa-eye-slash');

        if($(this).hasClass("fa-eye"))
        {
            $(this).removeClass("fa-eye")
            $(this).addClass("fa-eye-slash")
        }
        else
        {
            $(this).removeClass("fa-eye-slash")
            $(this).addClass("fa-eye")
        }
    });




    const toggleConfPassword = document.querySelector('#toggleConfPassword');
    const confpassword = document.querySelector('#cpass');
    toggleConfPassword.addEventListener('click', function (e) {
        // toggle the type attribute
        const type = confpassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confpassword.setAttribute('type', type);
        // toggle the eye slash icon
        // this.classList.toggle('fa-eye-slash');

        if($(this).hasClass("fa-eye"))
        {
            $(this).removeClass("fa-eye")
            $(this).addClass("fa-eye-slash")
        }
        else
        {
            $(this).removeClass("fa-eye-slash")
            $(this).addClass("fa-eye")
        }
    });
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

    $('#cpass').on('keyup',function () {
        let pass=$('#pass').val()
        let cpass=$(this).val()
        console.log(123+'-'+cpass)


        if(cpass!=pass)
        {
            $('#passError').show()
        }
        else
        {
            $('#passError').hide()
        }
        if(cpass=='' || cpass==null)
        {
            console.log(00)

            $('#passError').hide()
        }
    })
    $('#submitBtn').click(function () {
        $( '#contact_form' ).submit()
    })
    $( '#contact_form' ).validate( {
        submitHandler: function (e) {
            'use strict';
            let pass=$('#pass').val()
            let cpass=$('#cpass').val()
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
                       if(cpass!=pass)
            {
                $('#passError').show()
                return false;
            }
            else
            {
                $('#passError').hide()
            }
            $( "#submitBtn" ).html( '  <i class="fa fa-spinner fa-spin"></i> ' + static_label_changer('Processing') );
            $( "#submitBtn" ).prop('disabled',true)
            $.ajax( {
                dataType: 'json',
                url: "<?php echo $baseURL; ?>/ajax?h=changePassword&Lang=<?php echo (empty($language)?"english":$language) ?>",
                type: 'POST',
                data: $("#contact_form").serialize(),
                success: function ( data ) {
                    console.log(data)
                    $( "#submitBtn" ).html(static_label_changer('Submit'))
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
                        $(".prompt").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i> '+static_label_changer(data.Msg)+'</div>');
                        setTimeout(function() {
                            $(".prompt").html('');
                        }, 3000);
                    }
                },
                error: function ( data ) {
                    $( "#submitBtn" ).html(static_label_changer('Submit'))
                    $( "#submitBtn" ).prop('disabled',false)
                    console.log(data)
                }
            } );
            return false;
        }
    } );



</script>

</body>
</html>