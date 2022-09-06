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


                <div id="mailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Resend Email</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="prompt"></div>
                                <div id="deleteBox">
                                    <i class="mdi mdi-alert-outline mr-2"></i>
                                    <h3>Are you sure?</h3>
                                    <p>You want to send email again ?</p>
                                </div>
                                <input type="hidden" name="id" id="id">

                                <button type="button" class="btn btn-danger waves-effect waves-light" id="resendLoader">Yes</button>
                                <button type="button" class="btn btn-secondary waves-effect" id="close" data-dismiss="modal">No</button>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
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
                                        <th>First Name</th>
                                        <th>User Email</th>
                                        <th>Total Score</th>
                                        <th>Created Date</th>
                                        <th>User Type</th>
                                        <th>IP Address</th>
                                        <th>Access</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM user_form where `status`='0' order by id desc");
                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        $blocked='';
                                        $block=false;
                                        $userId = $Row['user_id'];

                                        $userInfo = getUserDetail($userId);

                                        $getQuery3 = mysqli_query($conn , "SELECT * FROM blocked_ip where `ip_address`='{$Row['ip_address']}'");
                                        if(mysqli_num_rows($getQuery3)>0)
                                        {
                                            $row3=mysqli_fetch_assoc($getQuery3);
                                            $blocked='Blocked';
                                            $block=true;

                                        }


                                        if(!empty($userInfo))
                                        {
                                            $blocked='';
                                            $block=false;
                                        }

                                        $getQuery2 = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$Row['id']} order by id desc");
                                        $total_score=0;
                                        while($srow = mysqli_fetch_assoc($getQuery2)) {
                                            if(ctype_digit($srow['score']))
                                                $total_score += $srow['score'];
                                        }

                                        ?>

                                        <tr>
                                            <td><?php echo $count; ?></td>
                                            <td><?php echo $Row['user_name'] ?></td>
                                            <td><?php echo $Row['user_email'] ?></td>
                                            <td><?php echo $total_score ?></td>
                                            <td><?php echo $Row['created_date']; ?></td>
                                            <td><?php if(!empty($userInfo)){ if($userInfo['role'] == "1" || $userInfo['role'] == 1) { echo "Professional"; } else { echo "Signed"; } } else { echo "Guest"; } ?></td>
                                            <td><?php echo $Row['ip_address']; ?></td>
                                            <td><?php echo $blocked; ?></td>
                                            <td>
                                                <a href="view_form?id=<?php echo $Row['id']; ?>" class="btn btn-sm btn-info waves-effect waves-light" title="View Form"><i class="fas fa-eye"></i></a>
                                                <a href="scores?id=<?php echo $Row['id']; ?>"  class="btn btn-sm btn-primary waves-effect waves-light" title="Check Score"><i class="fa fa-calculator"></i></a>
                                                <a target="_blank" href="<?php echo $currentTheme ?>/view_form2?id=<?php echo $Row['id']; ?>" class="btn btn-sm btn-success waves-effect waves-light" title="View Form from user side"><i class="fas fa-list"></i></a>

                                                <a href="javascript:void(0)" onClick="resendMail('<?php echo $Row['id']; ?>')" class="btn btn-sm btn-warning waves-effect waves-light" title="Resend Email"><i class="fas fa-envelope"></i></a>
                                                <?php if(empty($userInfo)) { if($block) { ?>
                                                    <a href="javascript:void(0)" onClick="DeleteModal('<?php echo $Row['ip_address']; ?>',1)" class="btn btn-sm btn-success waves-effect waves-light"><i class="fas fa-unlock"></i></a>

                                                <?php } else { ?>
                                                    <a href="javascript:void(0)" onClick="DeleteModal('<?php echo $Row['ip_address']; ?>',0)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-ban"></i></a>

                                                <?php }
                                    }
                                                ?>
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

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Block IP Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="prompt"></div>
                <div id="deleteBox">
                    <i class="mdi mdi-alert-outline mr-2"></i>
                    <h3>Are you sure?</h3>
                    <p >You want to <strong id="blockP">block</strong> this IP Address!</p>
                </div>
                <input type="hidden" name="id" id="did">
                <input type="hidden" name="ban" id="ban">

                <button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Yes</button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<?php include_once("includes/script.php"); ?>

<script>



    $("#resendLoader").on('click',function(){
        var id = $("#id").val();
        $( "#resendLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $( "#resendLoader" ).prop('disabled',true)
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=resend_email",
            type: 'POST',
            data: {'id' : id},
            success: function ( data ) {
                $( "#resendLoader" ).html( 'Yes' );
                $( "#resendLoader" ).prop('disabled',false)
                if(data.Success == 'true'){

                    $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $('#close').click()
                        $( "div.prompt" ).html('');
                        $( "div.prompt" ).hide();
                    }, 3000 );
                }else{
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).html('');
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            }
        } );
    });

    function resendMail(id){
        $("#id").val(id);
        $("#mailModal").modal();
    }
    function DeleteModal(ip,ban){
        if(ip!=='' && ip!==null)
        {
            if(ban==1)
            {
                $('#blockP').html('unblock')
            }
            else
            {
                $('#blockP').html('block')
            }
            $("#did").val(ip);
            $("#ban").val(ban);

            $("#deleteModal").modal();
        }
        else
        {
            alert('No Ip Registered')
        }

    }
    $("#delLoader").on('click',function(){
        var ip = $("#did").val();
        var ban = $("#ban").val();

        $( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=blockIP",
            type: 'POST',
            data: {'ip' : ip , 'ban':ban},
            success: function ( data ) {
                $( "#delLoader" ).html( 'Yes' );

                if(data.Success == 'true'){
                    window.location.reload()
                }else{
                    $( window ).scrollTop( 0 );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            }
        } );
    });

</script>

</body>

</html>