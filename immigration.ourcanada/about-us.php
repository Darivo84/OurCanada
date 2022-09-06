<?php
include_once("user_inc.php");
//header("Location:https://ourcanada".$ext."/about-us".$langURL);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $allLabelsArray[8] ?> | OurCanada</title>


    <?php include_once "style.php" ?>

</head>
<body>


<!--header section start-->
<?php include_once "header.php" ?>
<!--header section end-->

<!--body content wrap start-->
<div class="main">




    <!--about us section start-->
    <section class="about-us-section ptb-100">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-12 col-lg-5">
                    <div class="video-promo-content mb-md-4 mb-lg-0 specifiedUrduElm">
                        <h2 class="static_label" data-org="<?php echo $allLabelsEnglishArray[8] ?>"><?php echo $allLabelsArray[8] ?></h2>
                        <p class="static_label" data-org="<?php echo $allLabelsEnglishArray[127] ?>"><?php echo $allLabelsArray[127] ?></p>
                        <p class="static_label" data-org="<?php echo $allLabelsEnglishArray[128] ?>"><?php echo $allLabelsArray[128] ?></p>
                        <ul class="list-unstyled tech-feature-list">
                            <li class="py-1"><i class="fa fa-check"></i>
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[129] ?>"><?php echo $allLabelsArray[129] ?></span>
                            </li>
                            <li class="py-1"><i class="fa fa-check"></i>
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[130] ?>"><?php echo $allLabelsArray[130] ?></span>
                            </li>
                            <li class="py-1"><i class="fa fa-check"></i>
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[131] ?>"><?php echo $allLabelsArray[131] ?></span>
                            </li>
                            <li class="py-1"><i class="fa fa-check"></i>
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[132] ?>"><?php echo $allLabelsArray[132] ?></span>
                            </li>
                            <li class="py-1"><i class="fa fa-check"></i>
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[133] ?>"><?php echo $allLabelsArray[133] ?></span>
                            </li>

                        </ul>
                        <br>

                        <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[134] ?>"><?php echo $allLabelsArray[134] ?></span>
                        <?php
                        if(isset($_SESSION['user_id']))
                        {
                            ?>
                            <a href="<?php echo $baseURL; ?>/form<?php echo $langURL; ?>"  data-toggle="modal" data-target="#exampleModal"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[267] ?>"><?php echo $allLabelsArray[267] ?></span></a>

                            <?php
                        }
                        else {
                            ?>
                            <a href="javascript:void(0)"  data-toggle="modal" data-target="#exampleModal"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[267] ?>"><?php echo $allLabelsArray[267] ?></span></a>

                        <?php } ?>
                        <br>
                        <a href="<?php echo $baseURL; ?>/signup<?php echo $langURL; ?>" class="btn secondary-solid-btn border-radius mt-4 mb-3 static_label" data-org="<?php echo $allLabelsEnglishArray[135] ?>"><?php echo $allLabelsArray[135] ?></a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card border-0 shadow-sm text-white">
                        <img src="<?php echo $baseURL; ?>/img/parallax-3.jpg" alt="video" class="img-fluid rounded shadow-sm">

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--about us section end-->



</div>
<!--body content wrap end-->


<!--footer section start-->
<?php include_once "footer.php" ?>

<!--footer section end-->



<?php include_once "script.php" ?>

</body>

</html>