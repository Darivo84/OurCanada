<?php
include("user_inc.php");

?>
<!DOCTYPE html>
<html lang="en">



<head>

    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <?php
    if($environment)
    {
        ?>
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/about-us" />

        <?php
    }
    ?>
    <title>Our Canada Services - <?php echo $allLabelsArray[8] ?></title>





    <?php include("includes/style.php") ?>
</head>

<body id="home">


<?php include("includes/header.php"); ?>

    <section class="banner-section aboutUs" id="home">
        <div class="container-fluid container-extra">
            <div class="row">

                <div class="col-lg-6">
                    <div class="banner-text">
                        <h1 class="static_label" data-org="<?php echo $allLabelsEnglishArray[8] ?>"><?php echo $allLabelsArray[8] ?></h1><br>
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
                        <p><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[134] ?>"><?php echo $allLabelsArray[134] ?></span>
                            <?php if(isset($_SESSION['user_id'])) { ?>
                            <a href="<?php echo 'https://immigration.ourcanada'.$ext; ?>/form<?php echo $newLangUrl; ?>" style="font-size: 15px;">&nbsp;

                                <?php } else { ?>
                            <a href="<?php echo 'https://immigration.ourcanada'.$ext; ?>/form<?php echo $newLangUrl; ?>" data-toggle="modal" data-target="#exampleModal" style="font-size: 15px;">&nbsp;

                                <?php } ?>
                                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[267] ?>"><?php echo $allLabelsArray[267] ?></span></a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="<?php echo $baseURL; ?>/assets/img/parallax-3.jpg" alt="About Us">
                </div>
            </div>
        </div>

    </section>

<?php  include("includes/footer.php") ?>

<?php include("includes/script.php") ?>

</body>

</html>