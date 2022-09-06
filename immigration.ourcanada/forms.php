<?php
	include_once("global.php");
    $getForms = mysqli_query($conn , "SELECT * FROM categories WHERE status = 1 order by id ASC");
    
?>
<!doctype html>
<html lang="en">

<!-- Mirrored from corporx.themetags.com/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Apr 2020 10:51:13 GMT -->
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
    <title>Canadian Immigration Tool | Consultation</title>

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
                <div class="col-md-12">
                    <div class="page-header-content text-white text-center pt-sm-5 pt-md-5 pt-lg-0">
                        <h1 class="text-white mb-0">Canadian Immigration Tool</h1>
                        <div class="custom-breadcrumb">
                            <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0">
                                <li class="list-inline-item breadcrumb-item"><a href="#">Home</a></li>
                                <li class="list-inline-item breadcrumb-item"><a href="#">Pages</a></li>
                                <li class="list-inline-item breadcrumb-item active">Canadian Immigration Tool</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--header section end-->

    <!--promo block with hover effect start-->
    <section class="promo-block ptb-100">
        <div class="container">
            <div class="row">
                <?php
                while($row = mysqli_fetch_assoc($getForms)) { ?>
                <div class="col-md-4 col-lg-4">
                    <div class="single-promo-block promo-hover-bg-1 hover-image shadow-lg p-5 rounded">
                        <div class="promo-block-icon mb-3">
                            <span class="ti-vector icon-md color-primary"></span>
                        </div>
                        <div class="promo-block-content">
                            <h5><a href="form?id=<?php echo $row['id']; ?><?php if(isset($_GET['code']) && !empty($_GET['code'])) { echo '&code='.$_GET['code']; }?>"><?php echo $row['name']; ?></a></h5>
                            <p>Compellingly promote collaborative products without synergistic schemas. </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
                
            </div>
        </div>
        
    </section>
    <!--promo block with hover effect end-->

</div>
<!--body content wrap end-->

<?php include_once("footer.php"); ?>

<!--bottom to top button start-->
<button class="scroll-top scroll-to-target" data-target="html">
    <span class="ti-angle-up"></span>
</button>
<!--bottom to top button end-->

<!--jQuery-->
<script src="js/jquery-3.4.1.min.js"></script>
<!--Popper js-->
<script src="js/popper.min.js"></script>
<!--Bootstrap js-->
<script src="js/bootstrap.min.js"></script>
<!--Magnific popup js-->
<script src="js/jquery.magnific-popup.min.js"></script>
<!--jquery easing js-->
<script src="js/jquery.easing.min.js"></script>
<!--jquery ytplayer js-->
<script src="js/jquery.mb.YTPlayer.min.js"></script>
<!--Isotope filter js-->
<script src="js/mixitup.min.js"></script>
<!--wow js-->
<script src="js/wow.min.js"></script>
<!--owl carousel js-->
<script src="js/owl.carousel.min.js"></script>
<!--countdown js-->
<script src="js/jquery.countdown.min.js"></script>
<!--custom js-->
<script src="js/scripts.js"></script>
</body>

<!-- Mirrored from corporx.themetags.com/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Apr 2020 10:51:13 GMT -->
</html>