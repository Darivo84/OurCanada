<link rel="icon" href="<?php echo $mainURL ?>/assets/img/logo.png">
<link rel="shortcut icon" href="<?php echo $mainURL ?>/assets/img/logo.png">

<!--google fonts-->
<!--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700%7COpen+Sans:400,600&amp;display=swap" rel="stylesheet">-->

<style>
	<?php
	echo file_get_contents($currentTheme."css/bootstrap.min.css");
	echo file_get_contents($currentTheme."css/themify-icons.css");
	echo file_get_contents($currentTheme."css/all.min.css");
	echo file_get_contents($currentTheme."css/animate.min.css");
	echo file_get_contents($currentTheme."css/datepicker.css");
	echo file_get_contents($currentTheme."css/bootstrap.tagsinput.css");
	echo file_get_contents($currentTheme."css/select2-bootstrap.min.css");
	echo file_get_contents($currentTheme."css/select2.min.css");
	echo file_get_contents($currentTheme."css/style.css");
	echo file_get_contents($currentTheme."css/responsive.css");
	?>
    .navbar-brand img {
        width: 40%;
    }
    .footer-section1 {
        flex-shrink: 0;
    }
    body {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .main {
        flex: 1 0 auto;
    }
</style>
<?php

if($displayType == 'Right to Left'){ ?>
    <style>
        body{
            text-align: right;
            direction: rtl;
        }
        a[type="button"], button {
            margin: 0px 2px;
        }
        .modal-header .close {
            padding: 1rem 1rem;
            margin: -1rem -1rem -1rem 0;
        }
        .navbar-nav
        {
            float: left;
        }
        .custom-control
        {
            text-align: right;
            direction: rtl;
        }
        .eyeIcon
        {
            position: absolute;
            left: 15px;
            top: 45px;
        }
        @media (min-width: 992px)
        {
            .navbar-expand-lg .navbar-collapse
            {
                display: block !important;
            }
        }
        .social-nav
        {
            text-align: left;
        }
        .prompt, .copyright-text
        {
            text-align: right;
        }
        .modal-footer > :not(:first-child) {
            margin-right: .25rem;
        }
        .modal-footer > :not(:last-child) {
            margin-left: .25rem;
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
<?php } else { ?>
    <style>
        .social-nav{
            text-align: right;
        }
        .eyeIcon {
            position: absolute;
            right: 15px;
            top: 45px;
        }
    </style>
<?php } ?>
<!-- Global site tag (gtag.js) - Google Analytics --> 
<!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-185835714-1"> </script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'UA-185835714-1'); </script>-->
<!-- 900 for 15 minutes 10800 for 3 hours -->


