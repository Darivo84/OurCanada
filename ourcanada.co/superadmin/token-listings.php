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
                <!-- end page title -->
               <?php

                    $query = "SELECT * FROM referral ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);
                    ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <?php if($_GET['h'] != 'modify') { ?>
                                    <a href="?h=modify" style="padding: 7px; margin-bottom: 15px; float: right;"
                                       class="btn btn-primary waves-effect waves-light btn-sm">Modify Token Threshold</a>
                                    <br>
                                    <br>
                                    <?php } ?>

                                    <?php if(isset($_GET['h']) && !empty($_GET['h']) && $_GET['h'] == 'modify') {
                                            $getThresHold = mysqli_query($conn , "SELECT * FROM referral_threshold WHERE id = '1'");
                                            $row = mysqli_fetch_assoc($getThresHold);
                                        ?>

                                        <form method="POST" id="updateThreshold">
                                        <div class="prompt"></div>

                                        <div class="row">
                                            <div class="col-sm-12" style="width: 100%">
                                                <div class="form-group row mb-4">
                                                    <div class="col-md-6 pl-0">
                                                        <label for="fna" class="col-form-label col-lg-12">Assigned Token/s per referral</label>
                                                        <div class="col-lg-12">
                                                            <input id="token" name="n[token]" type="text" class="form-control"
                                                                   value="<?php echo $row["token"] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 pl-0">
                                                        <label for="lnamea" class="col-form-label col-lg-12">Worth Per Token</label>
                                                        <div class="col-lg-12">
                                                            <input class="form-control" type="text" id="worth"
                                                                   name="n[worth]" value="<?php echo $row["worth"] ?>"
                                                                   required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-4">
                                                    <div class="col-md-6 pl-0">
                                                        <label for="fna" class="col-form-label col-lg-12">Minimum Tokens Threshold</label>
                                                        <div class="col-lg-12">
                                                            <input id="threshold" name="n[threshold]" type="text" class="form-control"
                                                                   value="<?php echo $row["threshold"] ?>" required>
                                                        </div>
                                                    </div>

                                                </div>


                                                <div class="row justify-content-end">
                                                    <div class="col-lg-12">
                                                        <button id="updateLoader" type="submit"
                                                                class="btn btn-primary edit-form-button">Update Threshold
                                                        </button>
                                                        <a type="button" href="token-listing.php"
                                                           class="btn btn-light">Cancel</a></div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                    <?php } else { ?>

                                    <div class="table-responsive">
                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100px">#</th>

                                                <th scope="col">Refered By</th>
                                                <th scope="col">Refered To</th>
                                                <th scope="col">Referral Token</th>
                                                <th scope="col">Created Date</th>
                                                <th scope="col">Signup Status</th>
                                                <th scope="col">Submission</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $count = 1;
                                            while ($row = mysqli_fetch_array($result)) {
                                                $r='';
                                                $s2='';
                                                $sign_up='Not Signed Up';
                                                $sign_up_class='text-danger';
                                                $s=mysqli_query($conn,"select * from users where email='{$row["refered_to"]}'");
                                                if(mysqli_num_rows($s) > 0)
                                                {
                                                    $sign_up='Signed Up';
                                                    $sign_up_class='text-success';

                                                    $r=mysqli_fetch_assoc($s);
                                                    $s2=mysqli_query($conn,"select * from user_form where user_id='{$r['id']}'");
                                                }

                                                ?>
                                                <tr>
                                                    <td><span><?php echo $count ?></span></td>
                                                    <td class="font-weight-bold"><?php echo $row["refered_by"] ?></td>

                                                    <td><?php echo $row["refered_to"]?></td>
                                                    <td><?php echo $row["refered_code"] ?></td>

                                                    <td><?php echo $row["refered_date"] ?></td>
                                                    <td><span class="<?php echo $sign_up_class ?>"><?php echo $sign_up ?></span></td>
                                                    <td>
                                                        <?php if(mysqli_num_rows($s2) > 0 ){ echo 'Done'; } else { echo 'N/A'; } ?>
                                                    </td>
                                                    <td>
                                                        <?php if(mysqli_num_rows($s2) > 0){ ?>
                                                        <?php if($row["status"] == 0 ) { ?>
                                                        <label class="">
                                                            <input value="<?php echo $row["status"]; ?>" type="checkbox"
                                                                   name="custom-switch-checkbox"
                                                                   class="get_value custom-switch-input"
                                                                   onChange="changeStatus('<?php echo $row['id']; ?>')"
                                                                <?php if($row["status"] == 1) { echo 'checked'; } ?>
                                                            >
                                                            <span class="custom-switch-indicator"></span> </label>
                                                        <?php } else { ?>
                                                            <button class="btn btn-success btn-sm" title="Approved"><i class="fa fa-check"></i></button>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    </td>

                                                    <td>
                                                        <?php if($row['user_form_id'] > 0){ ?>
                                                        <a href="view.php?user_form_id=<?php echo $row['user_form_id']; ?>" target="_blank"
                                                           class="btn btn-sm btn-icon btn-warning table-button"><i
                                                                class="fas fa-eye"></i> </a>
                                                        <?php } ?>
                                                        <button id="deletebtn"
                                                                class="btn btn-sm btn-icon btn-danger table-button"
                                                                onclick="$('#d_id').val('<?php echo $row['id']; ?>')"
                                                                data-toggle="modal" data-target="#smallModal"><i
                                                                class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <?php $count++;
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <?php } ?>
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
    <div id="smallModal2" class="modal fade">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Image</h6>
                </div>
                <div class="modal-body">
                    <div class="prompt"></div>
                    <p>Are you sure you want to delete this image?</p>
                </div>
                <!-- MODAL-BODY -->
                <div class="modal-footer">
                    <input type="hidden" name="id" id="d_id">
                    <button type="button" id="cancel" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button id="delBtn" type="button" class="btn btn-danger">Delete
                    </button>
                </div>
            </div>
        </div>
        <!-- MODAL-DIALOG -->
    </div>

</div>
<!-- END layout-wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- Delete Modal -->
<div id="smallModal" class="modal fade">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete</h6>
            </div>
            <div class="modal-body">
                <div class="prompt"></div>
                <p>Are you sure you want to delete ?</p>
            </div>
            <!-- MODAL-BODY -->
            <div class="modal-footer">
                <input type="hidden" name="id" id="d_id">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button id="addLoader" type="button" class="btn btn-danger"
                        onClick="deleteCategory(document.getElementById('d_id').value)">Delete
                </button>
            </div>
        </div>
    </div>
    <!-- MODAL-DIALOG -->
</div>
<?php include_once("includes/script.php"); ?>
<script src="assets/js/bootstrap-tagsinput.js"></script>

<script>
    $(document).ready(function () {
        $("input.tags").tagsinput();
        $('#categoryTable').dataTable();
    });
    $('#imgClose').click(function () {
        $('#smallModal2').modal()
    })
    $('#delBtn').click(function () {
        $('#storyImage').fadeOut()
        $('#imgClose').hide()
        $('#cancel').click()
        $('#imgCheck').val(1)
    })


</script>

<script>
    function deleteCategory(id) {
        $("#addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
        $("#addLoader").prop('disabled',true)

        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=deleteA",
            type: 'POST',
            data: {id: id},
            success: function (data) {
                $( "#addLoader" ).html('Delete')
                $("#addLoader").prop('disabled',false)

                if (data.Success == 'true') {
                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"' + data.Msg + '</div>');
                }
            }
        });
    }

    function changeStatus(id) {

        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=changeRstatus",
            method: "POST",
            data: {id: id},
            success: function (data) {
                if (data.Success === 'true') {
                    window.location.reload();
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"' + data.Msg + '</div>');
                }
            }
        });
    };

    $( '#updateThreshold' ).validate( {
        submitHandler: function () {

            'use strict';
            $( "#updateLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> Processing' );
            $("#updateLoader").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=updateThreshold",
                type: 'POST',
                data: $("#updateThreshold").serialize(),
                success: function ( data ) {
                    $( "#updateLoader" ).html('Update')
                    $("#updateLoader").prop('disabled',false)

                    if ( data.Success == 'true' )
                    {
                        $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                        setTimeout(function(){
                        	window.location.href = '<?= $currentTheme ?>superadmin/token-listings';
                        },3000);		
                    } else
                    {
                        $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                    }
                }
            } );
            return false;
        }
    } );
</script>
</body>
</html>
