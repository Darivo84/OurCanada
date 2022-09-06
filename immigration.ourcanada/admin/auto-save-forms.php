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

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <select class="form-control" id="filterSearch">
                                                <option value="All">All</option>
                                                <option value="Professional">Professional</option>
                                                <option value="Signed">Signed</option>
                                                <option value="Guest">Guest</option>
                                                <option value="pending">Pending</option>
                                                <option value="viewed">Viewed</option>
                                                <option value="archived">Archived</option>


                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table id="datatable2" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th style="width: 12px">#</th>
                                        <th>Account</th>
                                        <th>Account Email</th>
                                        <th style="width: 20px;">Email</th>
                                        <th>Form ID</th>
                                        <th>Session ID</th>
                                        <th>IP Address</th>
                                        <th>Language</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th class="view_status_th" ></th>
                                        <th style="width: 150px !important;">Status</th>
                                        <th>Action</th>


                                        <!--                                        <th>Action</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM auto_save_form order by updated_date desc");
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
                                            <td><?php echo $Row['email'] ?></td>
                                            <td><?php echo $form_id ?></td>
                                            <td><?php echo $Row['session_id']; ?></td>
                                            <td><?php echo $Row['ip_address']; ?></td>
                                            <td><?php echo ucfirst($Row['lang']=='french'?'francais':$Row['lang']); ?></td>

                                            <td><?php echo $Row['created_date']; ?></td>
                                            <td><?php echo $Row['updated_date']; ?></td>
                                            <td class="view_status"><?php echo $Row['status']; ?></td>

                                            <td style="width: 150px !important;">
                                                <select style="width: 150px !important;" class="form-control" onchange="statusChange(this,'<?php echo $Row['id'] ?>')">
                                                    <option value="pending" <?php if($Row['status']=='pending') { echo 'selected';} ?>>Pending</option>
                                                    <option value="viewed" <?php if($Row['status']=='viewed') { echo 'selected';} ?>>Viewed</option>
                                                    <option value="archived" <?php if($Row['status']=='archived') { echo 'selected';} ?>>Archived</option>

                                                </select>
                                            </td>
                                            <td>
                                                <a href="view-auto-save-form?id=<?php echo $Row['id']; ?>" target="_blank" class="btn btn-sm btn-info waves-effect waves-light" title="View Form"><i class="fas fa-eye"></i></a>
                                                <a href="auto-save-forms-details?id=<?php echo $Row['id']; ?>" target="_blank" class="btn btn-sm btn-primary waves-effect waves-light" title="View Form Logs"><i class="fas fa-list"></i></a>

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

    $('#filterSearch').change(function () {
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

    function statusChange(e,id)
    {
        let val=$(e).val()
        $(e).parent('td').append('<span class="spinner-border spinner-border-sm" role="status"></span>')
        $(e).prop('disabled',true)
        $.ajax({
            dataType: 'json',
            url: '/admin/ajax.php?h=autoFormStatus',
            type: 'POST',
            data: {'id':id,'status':val},
            success: function (data) {

                console.log(data)
                $(e).prop('disabled',false)
                $(e).parent('td').children('.spinner-border').remove()
                $(e).parent('td').parent('tr').children('.view_status').html(val)
                if (data.success === 'false') {

                } else {

                }

            },
            error: function (data) {
                console.log(data)
                $(e).prop('disabled',false)
                $(e).parent('td').children('.spinner-border').remove()
            }
        });
    }





</script>

</body>

</html>