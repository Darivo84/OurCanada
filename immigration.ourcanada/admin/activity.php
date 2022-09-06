<?php
include_once( "admin_inc.php" );
//if($_SESSION['adminid']!=1 || $_SESSION['adminid']!=2)
//{
//    header("Location: index");
//}
?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>
    <style>
        .form-control
        {
            border: none;
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

                <!-- /.modal -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Admin</th>
                                        <th>Note</th>
                                        <th>Form ID</th>
                                        <th>Question ID</th>
                                        <th>Sub Question ID</th>
                                        <th>Sub Question ID (level 2)</th>
                                        <th>Score ID</th>
                                        <th>Date Time</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT a.*,ad.email,s.scoreID,s.id as sid FROM activities as a join admin as ad on a.admin_id=ad.id left join score as s on a.score_id=s.id  order by a.id desc");

                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        ?>

                                        <tr>
                                            <td><?php echo $count; ?></td>

                                            <td><?php echo $Row['email'];; ?></td>
                                            <td><?php echo $Row['note'] ?></td>
                                            <td><?php echo $Row['form_id']; ?></td>
                                            <td><?php echo $Row['question_id']; ?></td>
                                            <td><?php echo $Row['sub_question_id']; ?></td>
                                            <td><?php echo $Row['sub_question_id_2']; ?></td>
                                            <td><a href="/admin/scoring?method=edit&id=<?php echo $Row['sid']; ?>"><?php echo $Row['scoreID']; ?></a></td>
                                            <td><?php echo $Row['date']; ?></td>


                                        </tr>
                                        <?php
                                        $count++;
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

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
<link href="assets/css/select2.min.css" rel="stylesheet">
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/select2-init.js"></script>

</body>

</html>