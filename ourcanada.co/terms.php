<?php
include("user_inc.php");
?>
<html lang="en">
<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--====== Title ======-->
    <?php if($environment == true){ ?>
        <title><?php echo $allLabelsArray[299]; ?></title>
        <meta name="author" content="<?php echo $allLabelsArray[283]; ?>">
        <meta name="keywords" content="<?php echo $allLabelsArray[300]; ?>">
        <meta name="description" content="<?php echo $allLabelsArray[301]; ?>" />
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/terms" />

    <?php } else { ?>
        <title><?php echo $allLabelsEnglishArray[299] ?></title>
    <?php } ?>
    <!--====== Favicon Icon ======-->
    <!------------------------>
    <?php include("includes/style.php") ?>
    <style>
        .terms p {
            margin-top: 20px;
            line-height: 25px;
        }
        .terms ul li {
            list-style: inside;
            line-height: 30px;
        }
        .terms ul {
            margin-top: 30px;
        }
    </style>
</head>

<body>
<?php include("includes/header.php") ?>



<?php

if($language!=='english' && !empty($language))
{
    //require_once 'terms_conditions/'.$language.'.php';
    $select =mysqli_query($conn,"select t.* from terms_conditions as t join `multi-lingual` as m on t.lang_id=m.id where m.lang_slug='$language' and t.status='1'");
    if(mysqli_num_rows($select)>0)
    {
        $row=mysqli_fetch_assoc($select);

        ?>
<section class="contact-section pt-130 pb-50 terms" id="contact">
    <div class="container">
        <div class="row">
                            <?php
                            echo htmlspecialchars_decode(stripslashes($row['content']));
                            ?>
        </div>
    </div>
</section>

        <?php
    }
    else
    {
        require_once 'terms_conditions/terms.php';
    }
    ?>

    <?php
}
else
{
    require_once 'terms_conditions/terms.php';

}

?>






<div class="go-top-area">
    <div class="go-top-wrap">
        <div class="go-top-btn-wrap">
            <div class="go-top go-top-btn"> <i class="fal fa-angle-double-up"></i> <i class="fal fa-angle-double-up"></i> </div>
        </div>
    </div>
</div>
<!--====== GO TO TOP PART ENDS ======-->
<?php include("includes/footer.php") ?>
<!--====== jquery js ======-->
<?php include("includes/script.php") ?>
</body>
</html>