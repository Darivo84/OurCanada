<?php
include_once("admin_inc.php");



$allForms = mysqli_query($conn, "SELECT * FROM user_form");
$formsToday = mysqli_query($conn, "SELECT * FROM user_form where DATE(`created_date`) = CURDATE()");
$formsWeek = mysqli_query($conn, "SELECT * FROM user_form where created_date >= DATE(NOW()) - INTERVAL 7 DAY");
$formsMonth = mysqli_query($conn, "SELECT * FROM user_form where MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())");


$allUsers = mysqli_query($conn, "SELECT * FROM users where role=0");
$usersToday = mysqli_query($conn, "SELECT * FROM users where role=0 and DATE(`createdat`) = CURDATE()");
$usersWeek = mysqli_query($conn, "SELECT * FROM users where role=0 and createdat >= DATE(NOW()) - INTERVAL 7 DAY");
$usersMonth = mysqli_query($conn, "SELECT * FROM users where role=0 and MONTH(createdat) = MONTH(CURRENT_DATE())AND YEAR(createdat) = YEAR(CURRENT_DATE())");


$allUsersPro = mysqli_query($conn, "SELECT * FROM users where role=1");
$usersProToday = mysqli_query($conn, "SELECT * FROM users where role=1 and DATE(`createdat`) = CURDATE()");
$usersProWeek = mysqli_query($conn, "SELECT * FROM users where role=1 and createdat >= DATE(NOW()) - INTERVAL 7 DAY");
$usersProMonth = mysqli_query($conn, "SELECT * FROM users where role=1 and MONTH(createdat) = MONTH(CURRENT_DATE())AND YEAR(createdat) = YEAR(CURRENT_DATE())");

$allGuest = mysqli_query($conn, "SELECT * FROM user_form where user_id=0");
$GuestToday = mysqli_query($conn, "SELECT * FROM user_form where user_id=0 and DATE(`created_date`) = CURDATE()");
$GuestWeek = mysqli_query($conn, "SELECT * FROM user_form where user_id=0 and created_date >= DATE(NOW()) - INTERVAL 7 DAY");
$GuestMonth = mysqli_query($conn, "SELECT * FROM user_form where user_id=0 and MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())");

$allAutoForms = mysqli_query($conn, "SELECT * FROM auto_save_form");
$formsAutoToday = mysqli_query($conn, "SELECT * FROM auto_save_form where DATE(`created_date`) = CURDATE()");
$formsAutoWeek = mysqli_query($conn, "SELECT * FROM auto_save_form where created_date >= DATE(NOW()) - INTERVAL 7 DAY");
$formsAutoMonth = mysqli_query($conn, "SELECT * FROM auto_save_form where MONTH(created_date) = MONTH(CURRENT_DATE())AND YEAR(created_date) = YEAR(CURRENT_DATE())");

?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>

    <style>
        .alignEnd {
            text-align: end;
        }

        .mb-30 {
            margin-bottom: 30px;
        }
    </style>
</head>

<body data-topbar="dark" data-layout="horizontal">

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
                            <h4 class="mb-0 font-size-18">Dashboard</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item active">Welcome to Dashboard</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">

                    <div class="col-xl-12">
                        <div class="row cardAny">
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="cardAnyaltics">
                                            <h4><b>Forms Submitted</b> <span><?php echo mysqli_num_rows($allForms) == '' ? 0 : mysqli_num_rows($allForms); ?></span></h4>

                                            <p>Today<span><?php echo mysqli_num_rows($formsToday) == '' ? 0 : mysqli_num_rows($formsToday); ?></span></p>
                                            <p>This Week<span><?php echo mysqli_num_rows($formsWeek) == '' ? 0 : mysqli_num_rows($formsWeek); ?></span></p>
                                            <p>This Month<span><?php echo mysqli_num_rows($formsMonth) == '' ? 0 : mysqli_num_rows($formsMonth); ?></span></p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="cardAnyaltics">
                                            <h4><b>Professional Users</b> <span><?php echo mysqli_num_rows($allUsersPro) == '' ? 0 : mysqli_num_rows($allUsersPro); ?></span></h4>

                                            <p>Today<span><?php echo mysqli_num_rows($usersProToday) == '' ? 0 : mysqli_num_rows($usersProToday); ?></span></p>
                                            <p>This Week<span><?php echo mysqli_num_rows($usersProWeek) == '' ? 0 : mysqli_num_rows($usersProWeek); ?></span></p>
                                            <p>This Month<span><?php echo mysqli_num_rows($usersProMonth) == '' ? 0 : mysqli_num_rows($usersProMonth); ?></span></p>
                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="cardAnyaltics">
                                            <h4><b>Signed Users</b> <span><?php echo mysqli_num_rows($allUsers) == '' ? 0 : mysqli_num_rows($allUsers); ?></span></h4>

                                            <p>Today<span><?php echo mysqli_num_rows($usersToday) == '' ? 0 : mysqli_num_rows($usersToday); ?></span></p>
                                            <p>This Week<span><?php echo mysqli_num_rows($usersWeek) == '' ? 0 : mysqli_num_rows($usersWeek); ?></span></p>
                                            <p>This Month<span><?php echo mysqli_num_rows($usersMonth) == '' ? 0 : mysqli_num_rows($usersMonth); ?></span></p>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="cardAnyaltics">
                                            <h4><b>Guest Users</b> <span><?php echo mysqli_num_rows($allGuest) == '' ? 0 : mysqli_num_rows($allGuest); ?></span></h4>

                                            <p>Today<span><?php echo mysqli_num_rows($GuestToday) == '' ? 0 : mysqli_num_rows($GuestToday); ?></span></p>
                                            <p>This Week<span><?php echo mysqli_num_rows($GuestWeek) == '' ? 0 : mysqli_num_rows($GuestWeek); ?></span></p>
                                            <p>This Month<span><?php echo mysqli_num_rows($GuestMonth) == '' ? 0 : mysqli_num_rows($GuestMonth); ?></span></p>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="cardAnyaltics">
                                            <h4><b>Auto Saved Forms</b> <span><?php echo mysqli_num_rows($allAutoForms) == '' ? 0 : mysqli_num_rows($allAutoForms); ?></span></h4>

                                            <p>Today<span><?php echo mysqli_num_rows($formsAutoToday) == '' ? 0 : mysqli_num_rows($formsAutoToday); ?></span></p>
                                            <p>This Week<span><?php echo mysqli_num_rows($formsAutoWeek) == '' ? 0 : mysqli_num_rows($formsAutoWeek); ?></span></p>
                                            <p>This Month<span><?php echo mysqli_num_rows($formsAutoMonth) == '' ? 0 : mysqli_num_rows($formsAutoMonth); ?></span></p>
                                        </div>


                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- end row -->


                    </div>
                </div>
                <!-- end row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3>Submitted Forms</h3>
                                <?php include_once("getSubmittedForms.php"); ?>
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
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<?php include_once("includes/script.php"); ?>

<?php include_once("getSubmittedFormsFunctions.php"); ?>

</body>


</html>