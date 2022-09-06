<?php
include("user_inc.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--====== Title ======-->
    <?php if($environment == true){ ?>
        <title><?php echo $allLabelsArray[296]; ?></title>
        <meta name="author" content="<?php echo $allLabelsArray[283]; ?>">
        <meta name="keywords" content="<?php echo $allLabelsArray[297]; ?>">
        <meta name="description" content="<?php echo $allLabelsArray[298]; ?>" />
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/contact-us" />

    <?php } else { ?>
        <title><?php echo $allLabelsEnglishArray[296] ?></title>
    <?php } ?>
    <?php include("includes/style.php") ?>
</head>

<body>


<?php include("includes/header.php") ?>

<!--====== HEADER PART END ======-->
<!--====== CONTACT SECTION START ======-->
<section class="contact-section pt-130 pb-50" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center woww fadeInLeft" data-wow-delay=".3s">
                <div class="section-title
					 mb-60">
                    <h2 class="static_label" data-org="<?php echo $allLabelsEnglishArray[110] ?>"><?php echo $allLabelsArray[110] ?> </h2>

                </div>

            </div>
            <?php if($langURL!=='/chinese') {
                ?>
                <div class="col-sm-2">
                </div>
                <?php
            } ?>

            <div class="col-lg-8 woww fadeInRight" data-wow-delay=".3s">
                <div class="contact-form">

                    <form class="contact_form" method="post">
                        <div class="prompt"></div>
                        <div class="row">

                            <div class="col-md-6 mb-30">
                                <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[116] ?>"><?php echo $allLabelsArray[116] ?></label>
                                <input type="text"  name="name" id="name" required>
                            </div>
                            <div class="col-md-6 mb-30">
                                <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[117] ?>"><?php echo $allLabelsArray[117] ?></label>
                                <input type="email"  name="email" id="email" required>
                            </div>
                            <div class="col-12">
                                <label class="static_label" data-org="<?php echo $allLabelsEnglishArray[118] ?>"><?php echo $allLabelsArray[118] ?></label>
                                <textarea name="message" id="message"  required></textarea>
                            </div>

                            <div class="col-6">
                                <div style="margin-top: 15px;">
                                    <div class="g-recaptcha" data-sitekey="6LdnEwYaAAAAAI8r7VuqWnhPtTOCZQmw5OIjA6zY"></div>
                                </div>

                            </div>
                            <div class="col-12 mt-30 text-left">
                                <div class="form-group">
                                    <button type="submit" style="background-color: #FE0000" class="btn btn-primary static_label" value="Submit" id="submitBtn" data-org="<?php echo $allLabelsEnglishArray[22] ?>"><?php echo $allLabelsArray[22] ?></button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php if($langURL=='/chinese') {
                ?>
                <div class="col-sm-4">
                    <img style="max-width: 65%;margin-top: 10px;" src="<?php echo $baseURL.'/assets/img/qr-code.jpg' ?>">
                    <p style="font-size: 14px;
    margin-left: 13%;
    margin-top: -10px;"><?php echo $allLabelsArray[815] ?></p>
                </div>
                <?php
            } ?>
        </div>
    </div>
</section>
<!--====== CONTACT SECTION END ======-->



<!--====== GO TO TOP PART START ======-->
<div class="go-top-area">
    <div class="go-top-wrap">
        <div class="go-top-btn-wrap">
            <div class="go-top go-top-btn">
                <i class="fal fa-angle-double-up"></i>
                <i class="fal fa-angle-double-up"></i>
            </div>
        </div>
    </div>
</div>
<!--====== GO TO TOP PART ENDS ======-->
<?php include("includes/footer.php") ?>
<!--====== jquery js ======-->
<?php include("includes/script.php") ?>
<script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>" async defer></script>

</body>
</html>