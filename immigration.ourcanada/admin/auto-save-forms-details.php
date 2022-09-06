<?php
include_once( "admin_inc.php" );

?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

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

                        </div>
                    </div>
                </div>


                <!-- /.modal -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
<!--                                        <th>Account</th>-->
<!--                                        <th>Account Email</th>-->
<!--                                        <th>Email</th>-->
<!--                                        <th>Form ID</th>-->
<!--                                        <th>Session ID</th>-->
<!--                                        <th>IP Address</th>-->
                                        <th>Created Date</th>
<!--                                        <th>Updated Date</th>-->
                                        <th>Action</th>


                                        <!--                                        <th>Action</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM auto_save_form_logs where auto_save_id={$_GET['id']} order by id desc");
                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){

//                                        $account='Guest';
//                                        $account_email='N/A';
//                                        $form_id=$Row['form_id']==0?'N/A':$Row['form_id'];
//
//                                        $userId = $Row['user_id'];
//
//                                        if($userId!=0)
//                                        {
//                                            $getQuery3 = mysqli_query($conn , "SELECT * FROM users where `id`='$userId'");
//                                            if(mysqli_num_rows($getQuery3)>0)
//                                            {
//                                                $row3=mysqli_fetch_assoc($getQuery3);
//                                                if($row3['role']==1 || $row3['role']=='1')
//                                                {
//                                                    $account='Professional';
//                                                }
//                                                else
//                                                {
//                                                    $account='Signed';
//                                                }
//                                                $account_email=$row3['email'];
//                                            }
//                                        }



                                        ?>

                                        <tr>
                                            <td><?php echo $count; ?></td>
<!--                                            <td>--><?php //echo $account ?><!--</td>-->
<!--                                            <td>--><?php //echo $account_email ?><!--</td>-->
<!--                                            <td>--><?php //echo $Row['email'] ?><!--</td>-->
<!--                                            <td>--><?php //echo $form_id ?><!--</td>-->
<!--                                            <td>--><?php //echo $Row['session_id']; ?><!--</td>-->
<!--                                            <td>--><?php //echo $Row['ip_address']; ?><!--</td>-->

                                            <td><?php echo $Row['created_date']; ?></td>
<!--                                            <td>--><?php //echo $Row['updated_date']; ?><!--</td>-->

                                            <td>
                                                <a href="view-auto-save-form?id=<?php echo $Row['id']; ?>&log=1" target="_blank" class="btn btn-sm btn-info waves-effect waves-light" title="View Form"><i class="fas fa-eye"></i></a>

                                            </td>
                                        </tr>
                                        <?php $count++; } ?>
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

<script>



</script>

</body>

</html>