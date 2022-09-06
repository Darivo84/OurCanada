<!doctype html>
<html lang="en">

<?php
error_reporting(0);
$pageSlug = "travel";
include_once("user_inc.php");

$travales_info_result = mysqli_query($conn, "SELECT * FROM `travel_info` WHERE `active` = '1'");
$travales_infos = mysqli_fetch_all($travales_info_result, MYSQLI_ASSOC);
?>

<head>
    <meta charset="utf-8" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php if($environment == true){ ?>
        <title><?php echo $allLabelsArray[293]; ?></title>
        <meta name="author" content="<?php echo $allLabelsArray[283]; ?>">
        <meta name="keywords" content="<?php echo $allLabelsArray[294]; ?>">
        <meta name="description" content="<?php echo $allLabelsArray[295]; ?>" />

    <?php } else { ?>
        <title><?php echo $allLabelsEnglishArray[293] ?></title>
    <?php } ?>


    <?php include_once("includes/style.php"); ?>
</head>

<body data-sidebar="dark">
    <style>
        .hide {
            display: none !important;
        }

        section {
            margin-top: 10px !important;
            padding-top: 10px !important;
        }
    </style>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?php include_once("includes/header.php"); ?>

        <!-- breadcrumb start -->
        <div class="breadcrumb-section">
            <div class="container-fluid custom-container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h2> </h2>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="breadcrumb" class="theme-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a  class="static_label" data-org="<?php echo $allLabelsEnglishArray[7] ?>"><?php echo $allLabelsArray[7] ?></a></li>
                                <li class="breadcrumb-item active"><a data-org="<?php echo $allLabelsEnglishArray[204] ?>" class="static_label"><?php echo $allLabelsArray[204] ?></a></li>
                                <!-- <li class="breadcrumb-item active" aria-current="page">Product Listing</li> -->
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumb End -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <style>
            .vcenter {
                display: flex;
                /* vertical-align: middle; */
                /* float: none; */
                align-items: center;
            }
        </style>
        <section class="ratio_asos">

            <div class="page-content">
                <div class="container custom-container">
                    <div class="row">
                        <div class="col-md-4">
                            <ins class="bookingaff vcenter" style="height: 300px !important;" data-aid="2069328" data-target_aid="2069328" data-prod="nsb" data-width="100%" data-height="auto" data-lang="en" data-currency="CAD" data-df_num_properties="3">

                                <!-- Anything inside will go away once widget is loaded. -->

                                <a href="//www.booking.com?aid=2069328">Booking.com</a>

                            </ins>
                            <br>
                            <div style="height: 200px;" class="title2 vcenter">
                                <a href="//www.booking.com?aid=2069328">
                                    <h3 class=""> Please click here for travel options and deals from Booking.com</h3>
                                </a>
                            </div>
                            <script type="text/javascript">
                                (function(d, sc, u) {

                                    var s = d.createElement(sc),
                                        p = d.getElementsByTagName(sc)[0];

                                    s.type = 'text/javascript';

                                    s.async = true;

                                    s.src = u + '?v=' + (+new Date());

                                    p.parentNode.insertBefore(s, p);

                                })(document, 'script', '//aff.bstatic.com/static/affiliate_base/js/flexiproduct.js');
                            </script>
                        </div>
                        <?php
                        if (count($travales_infos) > 0) {
                            $rowcount = 0;
                            foreach ($travales_infos as $travales_info) {
                                $img_src = $travales_info['img_src'];

                                if ($travales_info['img_src_type'] == "internal") {

                                    $imgInfo = getimagesize($img_src);
                                    $imgWidth =  $imgInfo[0];
                                    $imgHeight =  $imgInfo[1];
                                    if ($imgWidth < 2 || $imgHeight < 2) {
                                        $img_src = $baseURL."assets/img/not-found.png";
                                    }
                                } else {
                                    $img_src = '/assets/p_images/' . $travales_info['img_src'];
                                }


                                $web_link = $travales_info['web_link'];
                                $info_text = $travales_info['info_text'];
                        ?>
                                <div class="col-md-4">
                                    <a style="height: 300px;" class="vcenter" target="blank_" href="<?php echo $web_link; ?>">
                                        <img style="max-height:300px;width: 100%;" src="<?php echo $img_src; ?>" alt="<?php echo $info_text; ?>">
                                    </a>
                                    <br>
                                    <div class="title2 vcenter" style="height: 200px;">
                                        <a target="blank_" href="<?php echo $web_link; ?>">
                                            <h3 class=""><?php echo $info_text; ?></h3>
                                        </a>
                                    </div>

                                </div>
                        <?php


                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <hr>

        <?php
        // if (count($travales_infos) > 0) 
        if (false) {
            $rowcount = 0;
            foreach ($travales_infos as $travales_info) {
                $img_src = $travales_info['img_src'];
                $web_link = $travales_info['web_link'];
                $info_text = $travales_info['info_text'];

        ?>
                <section class="ratio_asos ">

                    <div class="page-content">
                        <div class="container custom-container">
                            <div class="row">
                                <?php if ($rowcount % 2 == 0) { ?>
                                    <div class="col-md-6">
                                        <a target="blank_" href="<?php echo $web_link; ?>">
                                            <img style="max-height:300px;width: 100%;" src="<?php echo $img_src; ?>" alt="<?php echo $info_text; ?>">
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="col-md-6 vcenter">
                                    <div class="title2">
                                        <a target="blank_" href="<?php echo $web_link; ?>">
                                            <h3 class=""><?php echo $info_text; ?></h3>
                                        </a>
                                    </div>
                                </div>
                                <?php if ($rowcount % 2 != 0) { ?>
                                    <div class="col-md-6">
                                        <a target="blank_" href="<?php echo $web_link; ?>">
                                            <img style="width: 100%;" src="<?php echo $img_src; ?>" alt="<?php echo $info_text; ?>">
                                        </a>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
                </section>
                <hr>
        <?php
                $rowcount++;
            }
        }


        ?>





    </div>
    <?php include_once("includes/footer.php"); ?>


    <?php include_once("includes/script.php"); ?>
</body>


</html>