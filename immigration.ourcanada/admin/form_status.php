<?php
include_once( "admin_inc.php" );

?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>
<style>
    th.view_status_th {
        display: none;
    }
    td.view_status {
        display: none;
    }
</style>
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

                                <div class="table-responsive">
                                    <table id="datatable2" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th style="width: 12px">#</th>
                                            <th>Account</th>
                                            <th>Account Email</th>
                                            <th>Session ID</th>
                                            <th>IP Address</th>
                                            <th>Created Date</th>
                                            <th>Updated Date</th>
                                            <th>Submit Button Show</th>
                                            <th>Submit Button Click</th>
                                            <th>After Form Questions</th>
                                            <th>Form Submitted</th>
                                            <th>Email Sent</th>


                                            <!--                                        <th>Action</th>-->
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $getQuery = mysqli_query($conn , "SELECT * FROM user_logs order by updated_date desc");
                                        $count = 1;
                                        while($Row = mysqli_fetch_assoc($getQuery)){

                                            $account='Guest';
                                            $account_email='N/A';
                                            $form_id=$Row['form_id']==0?'N/A':$Row['form_id'];

                                            $userId = $Row['user_id'];

                                            if($userId!=0)
                                            {
                                                $getQuery3 = mysqli_query($conn , "SELECT * FROM users where `id`='$userId'");
                                                if(mysqli_num_rows($getQuery3)>0)
                                                {
                                                    $row3=mysqli_fetch_assoc($getQuery3);
                                                    if($row3['role']==1 || $row3['role']=='1')
                                                    {
                                                        $account='Professional';
                                                    }
                                                    else
                                                    {
                                                        $account='Signed';
                                                    }
                                                    $account_email=$row3['email'];
                                                }
                                            }



                                            ?>

                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $account ?></td>
                                                <td><?php echo $account_email ?></td>
                                                <td><?php echo $Row['session_id']; ?></td>
                                                <td><?php echo $Row['ip_address']; ?></td>
                                                <td><?php echo $Row['created_date']; ?></td>
                                                <td><?php echo $Row['updated_date']; ?></td>
                                                <td><?php echo $Row['submit_button_view']==0?'No':'Yes' ?></td>
                                                <td><?php echo $Row['submit_button_click']==0?'No':'Yes' ?></td>
                                                <td><?php echo $Row['after_form_questions']==0?'No':'Yes' ?></td>
                                                <td><?php echo $Row['form_submitted']==0?'No':'Yes' ?></td>
                                                <td><?php echo $Row['email_sent']==0?'No':'Yes' ?></td>


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

<script>
    var dt= $('#datatable2').DataTable()

    $('#filterSearchh').change(function () {
        let val=$(this).val()
        if(val=='All')
        {
            console.log(3)

            dt.column(1).search('').draw()
            dt.column(9).search('').draw()

        }
        if(val=='pending' || val=='viewed' || val=='archived')
        {
            console.log(1)
            dt.column(9).search('').draw()
            dt.column(1).search('').draw()

            dt.column(9).search(val).draw()

        }
        if(val=='Professional' || val=='Signed' || val=='Guest')
        {
            console.log(2)
            dt.column(1).search('').draw()
            dt.column(9).search('').draw()

            dt.column(1).search(val).draw()
        }
    })


</script>

</body>

</html>