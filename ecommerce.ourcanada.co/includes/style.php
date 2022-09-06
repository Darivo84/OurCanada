<!--Google font-->

<link rel="shortcut icon" href="<?php echo $baseURL; ?>assets/images/favicon/favicon.ico" type="image/x-icon">
<style>
<?php

echo file_get_contents($baseURL."/assets/css/fontawesome.css");
echo file_get_contents($baseURL."/assets/css/slick.css");
echo file_get_contents($baseURL."/assets/css/slick-theme.css");
echo file_get_contents($baseURL."/assets/css/animate.css");
echo file_get_contents($baseURL."/assets/css/prettify.css");
echo file_get_contents($baseURL."/assets/css/themify-icons.css");
echo file_get_contents($baseURL."/assets/css/bootstrap.css");
echo file_get_contents($baseURL."/assets/css/color19.css");
echo file_get_contents($baseURL."/assets/css/custom.css");


?>
</style>

<style>
    .modal-btn {
        border-color: #E50606 !important;
        padding: 10px 12px;
        outline: none;
        text-decoration: none;
        font-size: 16px;
        letter-spacing: 0.5px;
        -webkit-transition: all 0.3s;
        transition: all 0.3s;
        font-weight: 600;
        border-radius: 6px;

        background-color: #E50606 !important;
        border: 1px solid #E50606 !important;
        color: #ffffff !important;
        -webkit-box-shadow: 0 3px 5px 0 rgba(47, 85, 212, 0.3);
        box-shadow: 0 3px 5px 0 rgba(47, 85, 212, 0.3);
    }

    .modal-btn:hover {
        border-color: #92481C !important;
        background-color: #92481C !important;
    }

    .modal-btn:focus {
        border-color: #92481C !important;
        background-color: #92481C !important;
    }

    .form-group .icons {
        position: absolute;
        top: 43px;
        left: 18px;
    }

    .fea.icon-sm {
        height: 16px;
        width: 16px;
    }

    .icons {
        color: #E50606;
    }

    .fea {
        stroke-width: 1.8;
    }

    svg {
        overflow: hidden;
        vertical-align: middle;
    }

    .modal-form-control {
        border: 1px solid #dee2e6 !important;
        color: #3c4858 !important;
        height: 42px !important;
        font-size: 13px !important;
        border-radius: 6px !important;
    }

    .modal-form-control:hover {
        border: 1px solid #E50606 !important;

    }

    .modal-form-control:focus {
        border: 1px solid #E50606 !important;

    }

    .modal-open {
        overflow: auto;
        padding-right: 0 !important;
    }

    .modal-header-custom {
        background-color: #E50606 !important;
        border-color: #E50606 !important;
        color: white !important;
    }

    .modal-header-custom h5 {
        color: white !important;
    }

    .modal-header-custom button {
        color: white !important;
        opacity: 1 !important;
    }
    .tokens-modal-table th,
    .tokens-modal-table td {
        padding: .75rem;
        color: black;
        font-weight: bold;
        font-size: 16px;
    }
    .tokens-modal-table tbody {
        border: 1px solid #ccc;
        background: #f7f7f7;
        padding: 5px;
    }
    .cart-wrap button, .cart-wrap a i {
        border: none;

        background-color: #eacccce6 !important;
        border-radius: 70px !important;
        border: 2px solid white !important;
    }
    .brand-logo img
    {
        width: 40%;
    }
</style>

<style>

    @-webkit-keyframes sk-bounce {

        0%,
        100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        50% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes sk-bounce {

        0%,
        100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        50% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    .content-desktop {
        display: block;
    }

    .content-mobile {
        display: none;
    }

    @media screen and (max-width: 768px) {

        .content-desktop {
            display: none;
        }

        .content-mobile {
            display: block;
        }

    }

    @media screen and (max-width: 1199px) {

        .mobile-search {
            padding-left: 15px;
            padding-right: 15px;
        }

    }
</style>
