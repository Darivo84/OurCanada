<?php

include_once( $basePath."user_inc.php" );
$select=mysqli_query($conn,"select * from users where cookie='{$_COOKIE['PHPSESSID']}' and is_logged=1");
if(mysqli_num_rows($select)>0)
{
    $row=mysqli_fetch_assoc($select);
    $_SESSION['user_id']=$row['id'];
    $_SESSION['role'] = 'user';
    echo '<script>window.location.href = "'.$cms_url.getCurLang($langURL,true).'";</script>';
}
else
{
    session_unset();
    session_destroy();
}
?>
<!DOCTYPE html>

<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if($environment==true)
    {
?>
        <meta name="author" content="<?= $allLabelsArray[283] ?>">
        <meta name="description" content="<?= $allLabelsArray[783] ?>">
        <meta name="keywords" content="<?= $allLabelsArray[782] ?>">
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/login" />

        <?php
    }
    ?>


    <meta property="og:title" content="<?= $allLabelsArray[769] ?>" />
    <meta property="og:description" content="<?= $allLabelsArray[783] ?>" />
    <meta property="og:image" content="<?= ''  ?>" />
    <meta property="og:url" content="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
    <!-- Title-->
    <title><?= $allLabelsArray[688] ?></title>
    <!-- Favicon-->
    <?php include("community/includes/style.php"); ?>
    <link rel="stylesheet" href="assets/css/shop.css" type="text/css" media="all" />
    <!-- end head -->
    <style type="text/css">
        form.login{
            padding-bottom: 35px !important;
        }
    </style>
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
    <div class="options_layout_container full_layout_enable_front">
        <!-- Start header -->
        <?php include($basePath."includes/header.php"); ?>
        <!-- end header -->
        <div class="main_title_wrapper category_title_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 main_title_col">
                        <div class="jl_cat_mid_title">
                            <h3 class="categories-title title"><?= $allLabelsArray[681] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section id="content_main" class="clearfix">
            <div class="container">
                <div class="row main_content">
                    <!-- begin content -->
                    <div class="col-md-4"></div>
                    <div class="page-full col-md-4 post-3938 page type-page status-publish hentry" id="content">
                        <div class="content_single_page post-3938 page type-page status-publish hentry">
                            <div class="content_page_padding">
                                <div class="woocommerce">
                                    <div class="woocommerce-notices-wrapper"></div>
                                    <!--<h2>Login</h2>-->
                                    <form id="login" class="woocommerce-form woocommerce-form-login login" method="post">
                                        <div class="prompt"></div>
                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <label for="email"><?= $allLabelsArray[145] ?>&nbsp;<span class="required">*</span> </label>
                                            <input type="email" class="woocommerce-Input woocommerce-Input--text input-text form-control" name="email" id="email" autocomplete="email" placeholder="<?= $allLabelsArray[145] ?>" value="" title="<?= $allLabelsArray[48] ?>" required>
                                        </p>
                                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                            <label for="password"><?= $allLabelsArray[146] ?>&nbsp;<span class="required">*</span> </label>
                                            <input class="woocommerce-Input woocommerce-Input--text input-text form-control" type="password" name="password" id="password" autocomplete="current-password"  placeholder="<?= $allLabelsArray[146] ?>" title="<?= $allLabelsArray[48] ?>" required>
                                        </p>

                                        <p class="form-row">
                                            <!--<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                              <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever">
                                              <span>Remember me</span> </label> -->
                                            <button type="submit" class="woocommerce-button button woocommerce-form-login__submit mt-15" name="login" value="Log in" id="addLoader"><?= $allLabelsArray[11] ?></button>
                                        <div class="col-lg-12" style="text-align: center;">
                                            <a href="<?= $cms_url ?>forgot-password<?php echo $langURL ?>" style="color: #000;"><?= $allLabelsArray[147] ?></a>
                                        </div>
                                        </p>
                                    </form>
                                </div>
                            </div>
                            <div class="brack_space"></div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <?php include($basePath."includes/footer.php"); ?>

    </div>
</div>
<!-- Continue Login Modal -->
<!-- Modal -->

<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include($basePath."includes/script.php"); ?>
<script>
    $(document).ready(function() {


        $(document).on("click","#close_continueLoginmodal",function(){
            $( "#addLoader" ).html( '   <?= $allLabelsArray[11] ?>' );
        });

        $(document).on("click","#continueLoginbtn",function(){
            $( "#continueLoginbtn" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> <?php echo $allLabelsArray[43] ?>' );
            $.ajax( {
                dataType: 'json',
                url: "<?php echo $cms_url; ?>ajax?h=continue_login<?php echo '&lang='.str_replace('/','',$langURL);?>",
                type: 'POST',
                data: $( "#validateform" ).serialize(),
                success: function ( data ) {
                    $( "#continueLoginbtn" ).text( '<?php echo $allLabelsArray[28] ?>' );
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        // document.getElementById( "validateform" ).reset();

                        $("#continueLoginbtn").hide();

                        $( '#continueAlert' ).html( '<div class="alert alert-success" style=""><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );


                        // $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                        setTimeout(function() {
                            window.location = "<?= $cms_url.getCurLang($langURL,true) ?>";
                        }, 1000);

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

        $( '#login' ).validate( {
            submitHandler: function () {
                'use strict';
                $( "#addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>' );
                //$( "div.prompt" ).html('');

                $.ajax( {
                    dataType: 'json',
                    url: "<?= $cms_url ?>ajax.php?h=login<?php echo '&lang='.str_replace('/','',$langURL);?>",
                    type: 'POST',
                    data: $("#login").serialize(),
                    success: function ( data ) {
                        console.log(data)
                        if ( data.Success == 'true' )
                        {
                            $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                            setTimeout(function() {
                                window.location = "<?= $cms_url.getCurLang($langURL,true) ?>";
                            }, 1000);
                        }
                        else
                        {
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
                                $( "#addLoader" ).html( '<?= $allLabelsArray[11] ?>' );
                                $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning"></i>'+data.Msg+'</div>');
                            }

                        }
                    }
                } );
                return false;
            }
        } );

    });

</script>
</body>

</html>