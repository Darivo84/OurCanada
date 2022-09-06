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

                                <?php $query = "SELECT * FROM users ORDER BY id DESC";
                                $result = mysqli_query( $conn, $query ); ?>

                                <div class="table-responsive">
                                    <table id="datatable" class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="width: 100px">#</th>
                                            <th scope="col">Email</th>

                                            <th scope="col">Account Type</th>
<!--                                            <th scope="col">Action</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $count = 1;
                                        while ( $row = mysqli_fetch_array( $result ) ) {
                                            $account='';
                                            if($row['role']==0)
                                            {
                                                $account = 'Signed';
                                            }
                                            else {
                                                $account = 'Professional';
                                            }
                                            ?>
                                            <tr>
                                                <td><span><?php echo $count ?></span></td>
                                                <td><?php echo $row[ "email" ]?></td>
                                                <td><?php echo $account?></td>
<!--                                                <td><a href="users-listing.php?method=update&n_id=--><?php ////echo $row['id']; ?><!--" id="editbtn" type="button" class="btn btn-icon btn-success table-button"><i class="fas fa-pencil-alt" ></i> </a>-->
<!--                                                    <button id="deletebtn" class="btn btn-icon btn-danger table-button" onclick="" data-toggle="modal" data-target="#smallModal"> <i class="fa fa-trash"></i> </button>-->
<!--                                                </td>-->
                                            </tr>
                                            <?php $count++; } ?>
                                        </tbody>
                                    </table>
                                </div>


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

<?php include_once("getSubmittedFormsFunctions.php"); ?>

</body>

</html>