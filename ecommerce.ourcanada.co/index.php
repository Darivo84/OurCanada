<?php
$pagee = 1;

$pageSlug = "products";

include("user_inc.php");
$limit = 24;


$start_from = ($pagee - 1) * $limit;
$pQuery = "SELECT * FROM amazon_products ORDER BY id DESC LIMIT $start_from," . ($limit);
$result = mysqli_query($conn, $pQuery);

$filteredrecords = mysqli_num_rows($result);

$result_db = mysqli_query($conn, "SELECT COUNT(id) FROM amazon_products");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);

?>

<html lang="en">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <?php if($environment == true){ ?>
        <title><?php echo $allLabelsArray[290]; ?></title>
        <meta name="author" content="<?php echo $allLabelsArray[283]; ?>">
        <meta name="keywords" content="<?php echo $allLabelsArray[291]; ?>">
        <meta name="description" content="<?php echo $allLabelsArray[292]; ?>" />

    <?php } else { ?>
        <title><?php echo $allLabelsEnglishArray[290] ?></title>
    <?php } ?>

    <?php include_once("includes/style.php"); ?>
    
</head>


<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php
        if ($pagee > $total_pages || $pagee < 1) {
            header("Location: " . $baseURL);
        }
        include_once("includes/header.php");

        ?>

        <!-- breadcrumb start -->
        <div class="breadcrumb-section">
            <div class="container-fluid custom-container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="page-title">
                            <h2 class="static_label" data-org="PRODUCTS"></h2>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <nav aria-label="breadcrumb" class="theme-breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a data-org="<?php echo $allLabelsEnglishArray[7] ?>" class="static_label"><?php echo $allLabelsArray[7] ?></a></li>
                                <li class="breadcrumb-item active"><a  class="static_label" data-org="<?php echo $allLabelsEnglishArray[193] ?>"><?php echo $allLabelsArray[193] ?></a></li>
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
        <section class=" ratio_asos">
            <div class="title2">
                <h4 data-org="<?php echo $allLabelsEnglishArray[195] ?>" class="static_label"><?php echo $allLabelsArray[195] ?></h4>
                <p class="static_label" data-org="<?php echo $allLabelsEnglishArray[179] ?>"><?php echo $allLabelsArray[179] ?></p>
                <p data-org="<?php echo $allLabelsEnglishArray[197] ?>" class="static_label"> <?php echo $allLabelsArray[197] ?></p>
                <p data-org="T<?php echo $allLabelsEnglishArray[198] ?>" class="static_label"><?php echo $allLabelsArray[198] ?> </p>
            </div>
            <div class="page-content">
                <div class="container custom-container">

                    <div class="row">

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {

                            if ($row['item_type'] == "amazon_product") {

                        ?>
                                <div class="col-md-3 mt-3 mb-3">
                                    <h5 data-toggle="popover" title="Product Name" data-content="<?php echo $row['name']; ?>"><?php
                                                                                                                                $string = (strlen($row['name']) > 22) ? substr(trim($row['name']), 0, 22) . '...' : trim($row['name']);
                                                                                                                                echo $string;
                                                                                                                                ?>

                                    </h5>
                                    <br>



                                    <div style="margin-top:5px"> <?php echo $row['product']; ?></div>


                                </div>
                            <?php
                            } else { ?>
                                <div class="col-md-3 mt-3 mb-3">
                                    <h5 data-toggle="popover" title="Product Name" data-content="<?php echo $row['name']; ?>"><?php
                                                                                                                                $string = (strlen($row['name']) > 22) ? substr(trim($row['name']), 0, 22) . '...' : trim($row['name']);
                                                                                                                                echo $string;
                                                                                                                                ?>

                                    </h5>
                                    <br>



                                    <div style="margin-top:5px">
                                        <?php $img_src = "";
                                         if (!empty($row['product'])) {
                                             $img=explode('.',$row['product']);
                                            $img_src = 'assets/p_images/' . $row['product'];
                                            $imgInfo = getimagesize($img_src);
                                            $imgWidth =  $imgInfo[0];
                                            $imgHeight =  $imgInfo[1];
                                            if ($imgWidth < 2 || $imgHeight < 2) {
                                                $img_src = "assets/img/not-found.png";
                                            }
                                        } else {
                                            $img_src = "assets/img/not-found.png";
                                        } ?>
                                        <a  target="blank_" href="<?php echo $row['link']; ?>"><img src="<?php echo  $baseURL.'/'.$img_src; ?>" style="width:120px;height:240px;"></a>
                                    </div>


                                </div> <?php
                                    }
                                }
                                        ?>
                    </div>
                    <div class="row">
                        <div class="product-pagination" style="width: 100%;">
                            <div class="theme-paggination-block">
                                <div class="row">
                                    <div class="col-xl-6 col-md-6 col-sm-12">

                                        <nav aria-label="Page navigation">
                                            <ul class="pagination">
                                                <?php
                                                $middle_count = 2;
                                                $ends_count = 1;
                                                $dots = false;
                                                ?>
                                                <li class="page-item  <?php if ($pagee < 2) { ?>  disabled <?php } ?>"><a class="page-link" href="<?php echo $baseURL.$langURL; ?><?php if(substr($langURL, -1) == "/"){ }else{ echo "/";} ?><?php echo ($pagee  - 1) ?>" aria-label="Previous"><span aria-hidden="true"><i class="fa fa-chevron-left" aria-hidden="true"></i></span> <span class="sr-only">Previous</span></a></li>

                                                <?php
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    if ($i == $pagee) {
                                                ?>

                                                        <li class="page-item active"><a class="page-link"><?php echo $i; ?></a></li>
                                                        <?php
                                                        $dots = true;
                                                    } else {
                                                        if ($i <= $ends_count || ($pagee && $i >= $pagee - $middle_count && $i <= $pagee + $middle_count) || $i > $total_pages - $ends_count) {
                                                        ?>
                                                            <li class="page-item"><a class="page-link" href="<?php echo $baseURL.$langURL; ?><?php if(substr($langURL, -1) == "/"){ }else{ echo "/";} ?><?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                        <?php
                                                            $dots = true;
                                                        } elseif ($dots) {
                                                        ?><li class="page-item disabled"><a class="page-link">&hellip;</a></li><?php
                                                                                                                                $dots = false;
                                                                                                                            }
                                                                                                                        }
                                                                                                                    } ?>





                                                <li class="page-item <?php if ($pagee == $total_pages) { ?>  disabled <?php } ?>"><a class="page-link" href="<?php echo $baseURL.$langURL; ?><?php if(substr($langURL, -1) == "/"){ }else{ echo "/";} ?><?php echo ($pagee  + 1) ?>" aria-label="Next"><span aria-hidden="true"><i class="fa fa-chevron-right" aria-hidden="true"></i></span> <span class="sr-only">Next</span></a></li>

                                            </ul>

                                        </nav>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                        <div class="product-search-count-bottom">
                                            <h5><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[234]; ?>"><?php echo $allLabelsArray[234]; ?></span> <?php echo ((($pagee - 1) * $limit) + 1) ?>-<?php echo (($filteredrecords) + (($pagee - 1) * $limit)); ?> <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[235]; ?>"><?php echo $allLabelsArray[235]; ?></span> <?php echo $total_records; ?> <span class="static_label" data-org="Result"></span> </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </section>


    </div>
    <?php include_once("includes/footer.php"); ?>

    <?php

    include_once("includes/script.php");


    ?>

</body>


</html>