
<!--<script src="https://www.google.com/recaptcha/api.js?hl=--><?php //echo $language_code ?><!--" async defer></script>-->

<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>&render=explicit" async defer></script>

<?php if($displayType == 'Right to Left'){ ?>
    <script>
        $(document).on('ready',function (){
            $("body").addClass("RightToLeft")
            localStorage.setItem('display','<?php echo $displayType ?>')

        });
    </script>
<?php } ?>

<script>

    $('#sign_up').click(function () {
        $( '.signupForm' ).submit()
    })

    $('#signupBtn').click(function () {
        $('#signupModal').modal('show')
        $('#loginModal').modal('toggle')
    })

    $(document).on('ready',function (){
        localStorage.setItem('display','<?php echo $displayType ?>')
    });
    $(document).on('change','#language-picker-select',function(){
        console.log('dropdown changed')
        let val = $(this).val() ;
        let display = $(this).attr('data-id')
        if(val == 'english'){
            val = '';
        }
        localStorage.setItem('display','<?php echo $displayType ?>')
        console.log('<?php echo $getLangUrl[0] ?>')
        console.log('<?php echo $getLangUrl[1] ?>')
        console.log('<?php echo $getLangUrl[2] ?>')

        <?php

        if(isset($getLangUrl[2])){
            $pageURL = "/".$getLangUrl[1]."/";
        }else{
            if(isset($getLangUrl[1]))
            {
                $s=mysqli_query($conn,"select * from `multi-lingual` where lang_slug='$getLangUrl[1]'");
                if(mysqli_num_rows($s)>0 || $getLangUrl[1]=='francais')
                {
                    $pageURL = "/";
                }
                else
                {
                    $pageURL = "/".$getLangUrl[1]."/";
                }
            }
        }

        ?>
        console.log("<?php echo $pageURL; ?>")
        window.location.assign("<?php echo $baseURL; ?><?php echo $pageURL; ?>"+val);
    });



    $( '.login' ).validate( {
        messages: {
            email: {
                required: '<?= $allLabelsArray[48] ?>',
                email: '<?= $allLabelsArray[32] ?>',
            },
            password: {
                required: '<?= $allLabelsArray[48] ?>',
            }},
        submitHandler: function () {
            'use strict';
            $( "#loginModal #signIn" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?php echo $allLabelsArray[43] ?>' );

            $.ajax( {
                dataType: 'json',
                url: "<?php echo $baseURL; ?>/ajax.php?h=login&Lang=<?php echo $language?>",
                type: 'POST',
                data: $(".login").serialize(),
                success: function ( data ) {
                    if ( data.Success == 'true' ) {
                        $('#loginModal .prompt').html('<div class="alert alert-success" ><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');

                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                    else {
                        if(data.status != undefined)
                        {
                            if(data.status == '1' || data.status == 1)
                            {
                                $("#continueAlert").html('<div class="alert alert-info" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');
                                $("#continueLoginModal").modal('show');
                                $('#loginModal').modal('toggle')
                                setTimeout(function() {
                                    $("#loginModal .prompt").html('')
                                }, 1500);

                            }

                        }
                        $( "#loginModal #signIn" ).html( 'Login' );
                        $("#loginModal .prompt").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>'+data.Msg+'</div>');
                        setTimeout(function() {
                            $("#loginModal .prompt").html('')
                        }, 1500);
                    }
                }
            } );
            return false;
        }
    } );
    $( '.signupForm' ).validate( {

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

                if(grecaptcha.getResponse(0).length !== 0)
                {
                    $("#sign_up").html('<span class="spinner-border spinner-border-sm" role="status"></span> '+static_label_changer('Processing'));
                    $("#sign_up").prop('disabled',true)
                    $.ajax({
                        dataType: 'json',
                        url: "<?php echo $baseURL; ?>/ajax?h=signup&Lang=<?php echo (empty($language)?"english":$language) ?>",
                        type: 'POST',
                        data: $(".signupForm").serialize(),
                        success: function (data) {
                            $("#sign_up").html(static_label_changer('Sign up'));
                            $("#sign_up").prop('disabled',false)

                            $("div.signup_prompt").html('');
                            $("div.signup_prompt").show();
                            console.log(data)
                            grecaptcha.reset(0);

                            if (data.Success === 'true') {
                                $(window).scrollTop(0);
                                $(".signupForm").trigger('reset');
                                $('.signup_prompt').html('<div class="alert alert-success" ><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');
                                setTimeout(function () {
                                    $('.loginBtn').click()
                                }, 2000);
                            } else {
                                $(window).scrollTop(0);
                                $('.signup_prompt').html('<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>');
                                setTimeout(function () {
                                    $("div.signup_prompt").html('');
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
                    $( '.signup_prompt' ).html( '<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> '+static_label_changer("Invalid Captcha")+'</div>' );
                    setTimeout( function () {
                        $( "div.signup_prompt" ).html('');
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

    $('.loginBtn').click(function () {
        $('#signupModal').modal('toggle')
        $('#loginModal').modal('show')
    })

    $( '#referFriend' ).validate({
        messages: {
            email: {
                required: '<?= $allLabelsArray[48] ?>',
                email: '<?= $allLabelsArray[32] ?>',
            },
        },
        submitHandler: function () {
            'use strict';
            $("#referProcess").html('  <i class="fa fa-spinner fa-spin"></i> <?php echo $allLabelsArray[43] ?>');

            $.ajax({
                dataType: 'json',
                url: "<?php echo $baseURL; ?>/refer.php?h=referFriend&Lang=<?php echo $language ?>",
                type: 'POST',
                data: $("#referFriend").serialize(),
                success: function (data) {
                    if (data.Success == 'true') {
                        $("#referProcess").html('<?php echo $allLabelsArray[709] ?>');
                        $("#referEmail").val('');

                        $(".alertRefer").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $(".alertRefer").html('');
                            $('#referAfriend').modal('toggle')

                        }, 15000);

                    }
                    else if (data.Success == 'false2') {
                        $("#referProcess").html('<?php echo $allLabelsArray[709] ?>');
                        $(".alertRefer").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' + data.Msg + '</div>');

                        setTimeout(function () {
                            $(".alertRefer").html('');
                            window.location.reload()
                        }, 15000);

                    }
                    else {

                        $("#referProcess").html('<?php echo $allLabelsArray[709] ?>');
                        $(".alertRefer").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' + data.Msg + '</div>');

                        setTimeout(function () {
                            $(".alertRefer").html('');
                        }, 15000);
                    }
                }
            });
            return false;
        }
    });

    $( '.contact_form' ).validate( {

        errorPlacement: function (error, element) {
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
        }
        ,
        messages: {
            name: {
                required: '<?= $allLabelsArray[48] ?>',
            },
            email: {
                required: '<?= $allLabelsArray[48] ?>',
            },
            message: {
                required: '<?= $allLabelsArray[48] ?>',
            },
        },
        submitHandler: function (e) {
            'use strict';


            if(grecaptcha.getResponse(1).length !== 0)
            {
                $("#submitBtn").html('  <i class="fa fa-spinner fa-spin"></i> <?php echo $allLabelsArray[43] ?>' );
                $( "#submitBtn" ).prop('disabled',true)
                $.ajax({
                    dataType: 'json',
                    url: "<?php echo $baseURL; ?>/ajax.php?h=contact&Lang=<?php echo $language?>",
                    type: 'POST',
                    data: $(".contact_form").serialize(),
                    success: function (data) {
                        grecaptcha.reset(1);
                        $("#submitBtn").html('<?php echo $allLabelsArray[22] ?>')
                        $("#submitBtn").prop('disabled', false)
                        $(window).scrollTop(0)
                        if (data.Success == 'true') {
                            $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + static_label_changer(data.Msg) + '</div>');
                            $('.contact_form').trigger('reset')
                            setTimeout(function () {
                                // window.location.reload();
                                $(".prompt").html('');
                            }, 3000);
                        } else {
                            $(".prompt").html('<div class="alert alert-danger"><i class="fa fa-exclamation-triangle"></i>' + static_label_changer(data.Msg) + '</div>');
                        }
                    }
                });
                return false;
            }else
            {
                $( window ).scrollTop( 0 );
                $( "#submitBtn" ).html( '<?php echo $allLabelsArray[22] ?>' );
                $( '.prompt' ).html( '<div class="alert alert-danger" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i> <?php echo $allLabelsArray[260] ?></div>' );
                setTimeout( function () {
                    $( "div.prompt" ).html('');
                }, 5000 );
            }

        }

    } );
</script>