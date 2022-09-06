<?php
include_once("admin_inc.php");
$adminUrl = 'https://'.$_SERVER['HTTP_HOST'] . '/superadmin/';

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <?php include_once("includes/style.php"); ?>
    <link rel="stylesheet" href="assets/css/bootstrap-tagsinput.css">

</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">
    <?php include_once("includes/header.php"); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Referral Users</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Referral Users</a>
                                    </li>
                                    <li class="breadcrumb-item active">All Listing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">

                                <?php include_once("http://scoring.ourcanadadev.site/admin/user_form?id=".$_GET['user_form_id']); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- end row -->


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include_once("includes/footer.php"); ?>
    </div>

</div>
<!-- END layout-wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<?php include_once("includes/script.php"); ?>
<script src="assets/js/bootstrap-tagsinput.js"></script>


</body>
</html>
