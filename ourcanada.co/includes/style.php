
<link rel="icon" href="<?php echo $baseURL ?>/assets/img/logo.png">
<link rel="shortcut icon" href="<?php echo $baseURL ?>/assets/img/logo.png">


<style>
    <?php

        echo file_get_contents("https://fonts.googleapis.com/css2?family=Open+Sans&display=swap");
        echo file_get_contents($baseURL."/assets/css/animate.min.css");
        echo file_get_contents($baseURL."/assets/css/bootstrap.min.css");
        echo file_get_contents($baseURL."/assets/css/font-awesome.min.css");
        echo file_get_contents($baseURL."/assets/css/meanmenu.min.css");
        echo file_get_contents($baseURL."/assets/css/default.css");
        echo file_get_contents($baseURL."/assets/css/select2.min.css");
        echo file_get_contents($baseURL."/assets/css/style.min.css");

    ?>

    .footer-section1 {
        flex-shrink: 0;
    }
    body {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .banner-section {
        flex: 1 0 auto;
    }
    .contact-section {
        flex: 1 0 auto;
    }
    .logo img {
        width: 40%;
    }
    @media only screen and (min-width: 992px) and (max-width: 1200px) {
        header .nav .main-mneu ul li a {
            padding: 0px 8px;
            font-size: 10px !important;
        }
        .logo {
            width: 16%;
        }
    }
    @media only screen and (max-width: 600px) {
        .logo {
            margin-right: -50px;
        }
    }
    header .nav .main-mneu ul li a
    {
        font-size: 10px;
    }
</style>
<?php if($displayType == 'Right to Left'){ ?>
    <style>
        body{
            text-align: right;
            direction: rtl;
        }
        a[type="button"] {
            margin: 0px 2px;
        }
        .modal-header .close {
            padding: 1rem 1rem;
            margin: -1rem -1rem -1rem 0;
        }

        .mean-container a.meanmenu-reveal
        {
            left:0;
        }
        .modal-footer > :not(:first-child) {
            margin-right: .25rem;
        }
        .modal-footer > :not(:last-child) {
            margin-left: .25rem;
        }
        .meanmenu-reveal
        {
            left: 0 !important;
            right: auto !important;
        }
        .custom-control-label::before
        {
            left: auto;
            right: 0;
        }
        .custom-control-label span {
            margin-right: 20px;
        }
        .custom-control-label::after
        {
            right: 0;
        }
    </style>
<?php } ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<?php
if($ext=='.co') {

    echo '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-185835714-1"> </script>';
    echo file_get_contents($baseURL."/assets/js/googletag.js");
}

?>
