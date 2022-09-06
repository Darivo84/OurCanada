<?php
require_once  'user_inc.php';
if(!isset($_SESSION['user_id']))
{
    header("Location: /");
}


$getURL = ($_SERVER['REQUEST_URI']);
//echo $getURL;
$chckPar = explode("/",$getURL);
//print_r($chckPar);
$_GET['id'] = $chckPar[2];
//die();
$row = "";
$getQuestionsf = mysqli_query($conn, "SELECT * FROM user_form WHERE id = '{$_GET['id']}' AND user_id = '{$_SESSION['user_id']}'");

if(mysqli_num_rows($getQuestionsf) > 0) {
    $frow = mysqli_fetch_assoc($getQuestionsf);
}


?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <!--title-->
    <title>Form | OurCanada</title>


    <?php include_once("style.php"); ?>

</head>

<body>

<?php include_once("header.php"); ?>

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
                            if(!empty($frow))
                                {
                            echo $frow['form_data'];
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


<?php include_once("footer.php"); ?>


<?php include_once("script.php"); ?>

<script>

   // setTimeout(function () {
   //
   //     $('#formLoader').hide()
   // },1000)

</script>
</body>
</html>