<?php
require_once  'global.php';

$row = "";

$getQuestions = mysqli_query($conn, "SELECT * FROM user_form WHERE id = '{$_GET['id']}'");

if(mysqli_num_rows($getQuestions) > 0) {
    $row = mysqli_fetch_assoc($getQuestions);
}
//$json_data=str_replace('n[','',$row['json_data']);
//$json_data=str_replace(']','',$json_data);


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta description -->
    <meta name="description"
          content="BizBite corporate business template or agency and marketing template helps you easily create websites for your business.">
    <meta name="author" content="ThemeTags">


    <meta property="og:type" content="article"/>

    <!--title-->
    <title>Form | OurCanada</title>


    <?php include_once("../style.php"); ?>

</head>

<body>
<div id="formLoader" style="display: block">
    <span class="loader"><span class="loader-inner"></span></span>
</div>
<div id="preloader" style="display: none">
    <label class="score_loading"></label>
    <div class="loader1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<!--body content wrap start-->

<div class="main">

    <!--header section start-->
    <section class="hero-section ptb-100 gradient-overlay"
             style="background: url('img/header-bg-5.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">

                </div>
            </div>
        </div>
    </section>
    <!--header section end-->
    <!--header section end-->

    <!--promo block with hover effect start-->
    <section class="promo-block ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-md-2 col-lg-3"></div>
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-5">
                            <?php
                            if(!empty($row))
                            {
                                echo $row['form_data'];
                            }
                            else
                            { ?>
                                <div class="mb-5">
                                    <h5 class="h3"><?php $frmData['name']; ?></h5>
                                    <p class="text-muted mb-0 static_label">This is form is not exists or removed!</p>
                                </div>
                            <?php }
                            ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--promo block with hover effect end-->


</div>
<!--body content wrap end-->

<?php include_once("../script.php"); ?>

<script>

    setTimeout(function () {

        $('#formLoader').hide()
    },1000)

</script>
</body>
</html>