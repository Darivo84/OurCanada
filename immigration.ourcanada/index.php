<?php
    include_once("user_inc.php");

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta property="og:title" data-rh="true" content="<?= $allLabelsArray[105] ?>" />
    <meta property="og:description" data-rh="true" content="<?php echo $allLabelsArray[106]; ?>" />
    <meta property="og:image:" data-rh="true" content="<?= $currentTheme ?>img/ourcanada-old.png" />
    <meta property="og:url" data-rh="true" content="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
    <?php
    if($environment==true)
    {
        ?>
        <meta name="author" content="<?= $allLabelsArray[283] ?>">
        <meta name="description" content="<?= $allLabelsArray[286] ?>">
        <meta name="keywords" content="<?= $allLabelsArray[285] ?>">

        <?php
    }
    ?>
    <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?><?php echo $langURL ?>" />

    <!--title-->
    <title><?php echo $allLabelsArray[7] ?> | OurCanada</title>

    <?php include_once("style.php"); ?>

</head>
<body id="home">

	<?php include_once("header.php"); ?>

<!--body content wrap start-->
<div class="main">

    <!--hero background image with content slider start-->
    <section class="hero-equal-height gradient-overlay pt-165 pb-100 overflow-hidden" style="background: url('img/hero-bg8.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row justify-content-center mt-sm-5 mt-md-5 my-lg-5">
                <div class="col-md-10 col-lg-10">
                    <div class="hero-slider-content text-white text-center position-relative z-index">
                        <h1 class="text-white static_label" data-org="<?php echo $allLabelsEnglishArray[105] ?>"><?php echo $allLabelsArray[105] ?></h1>
                        <p class="lead static_label" data-org="<?php echo $allLabelsEnglishArray[106] ?>"><?php echo $allLabelsArray[106] ?></p>

                        <div class="action-btns">
							<?php if(!isset($_SESSION['user_id'])) { ?>
                            <a href="<?php echo $currentTheme ?>form<?php echo $langURL ?>" data-toggle="modal" data-target="#exampleModal" class="btn solid-white-btn static_label" data-org="<?php echo $allLabelsEnglishArray[190] ?>"><?php echo $allLabelsArray[190] ?></a>
							<?php } else { ?>
							<a href="<?php echo $currentTheme ?>form<?php echo $langURL ?>" class="btn solid-white-btn static_label" data-org="<?php echo $allLabelsEnglishArray[123] ?>"><?php echo $allLabelsArray[123] ?></a>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--hero background image with content slider end-->




</div>

<!-- Modal -->
<!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--  <div class="modal-dialog" role="document">-->
<!--    <div class="modal-content">-->
<!--      <div class="modal-header">-->
<!--        <h5 class="modal-title" id="exampleModalLabel">--><?php //echo $allLabelsArray[176] ?><!--</h5>-->
<!--        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--          <span aria-hidden="true">&times;</span>-->
<!--        </button>-->
<!--      </div>-->
<!--      <div class="modal-body">-->
<!--          --><?php //echo $allLabelsArray[177] ?>
<!--      </div>-->
<!--      <div class="modal-footer">-->
<!--        <button type="button" class="btn btn-secondary"><a href="/form?id=10" style="color:white">--><?php //echo $allLabelsArray[233] ?><!--</a></button>-->
<!--        <button type="button" class="btn btn-primary"><a href="/login" style="color:white">--><?php //echo $allLabelsArray[11] ?><!--</a></button>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<!--body content wrap end-->

    <?php include_once("footer.php"); ?>

<?php include_once("script.php"); ?>


    <div class="modal fade" id="with_notify" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?= $allLabelsArray[563] ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <?= $allLabelsArray[767] ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
        </div>
      </div>
    </div>
  </div>



</body>

</html>