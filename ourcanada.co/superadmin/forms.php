<?php
include_once( "admin_inc.php" );
if ( $_SESSION[ 'role' ] == 'admin' ) {

} else {
    header( "location:login.php" );
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php include_once("includes/style.php"); ?>
    <link href="assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/dropzone/min/dropzone.js"></script>
    <style>
        .box-setup{
            border: 1px dotted silver;
            padding: 10px;
            position: relative;
        }
        .cross-button{
            position: absolute;
            display: inline-block;
            top: -10px;
            right: -7px;
            border-radius: 35%;
            overflow: hidden;
        }
    </style>
</head>

<body data-sidebar="dark">
<div id="layout-wrapper">
    <?php include_once("includes/header.php"); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">User Forms</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
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
                                    <a href="downloadForm.php" style="padding: 7px; margin-bottom: 15px;margin-right:7px; float: right" class="btn btn-success waves-effect waves-light btn-sm">Export</a>
                                    <br><br>
                                    <div class="table-responsive">
                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100px">#</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Account Type</th>
                                                <th scope="col">Account Email</th>
                                                <th scope="col">Submission Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query = "SELECT * FROM `user_form` where `status` = '0' ORDER BY id DESC";
                                            $result = mysqli_query($conn, $query);
                                            $count = 1;
                                            
                                            while($row = mysqli_fetch_assoc($result)){
                                                $account='';
                                                $account_email='N/A';
                                                if($row['user_id']==0)
                                                {
                                                    $account='Guest';
                                                }
                                                else
                                                {
                                                    $query2 = mysqli_query($conn,"SELECT * FROM `users` where `id` ={$row['user_id']} ");
                                                    $result2 = mysqli_fetch_assoc( $query2);
                                                    if($result2['role']==1)
                                                    {
                                                        $account='Professional';
                                                    }
                                                    else
                                                    {
                                                        $account='Signed';

                                                    }
                                                    $account_email=$result2['email'];
                                                }
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $row['user_name']; ?></td>
                                                    <td><?php echo $row['user_email']; ?></td>
                                                    <td><?php echo $row['user_phone']; ?></td>
                                                    <td><?php echo $account; ?></td>
                                                    <td><?php echo $account_email; ?></td>

                                                    <td><?php echo $row['created_date']; ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="del_ling(<?php echo $row['id']; ?>);" class="text-danger"><i class="fa fa-trash"></i>&nbsp;Delete</a></td>
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
        </div>
        <?php include_once("includes/footer.php"); ?>
    </div>
</div>
<div class="rightbar-overlay"></div>
<div class="modal fade" id="delete_lingual_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Form</h5>
            </div>
            <div class="modal-body"> Are you sure, you wan't to delete this Submission?
                <input id="user_id" type="hidden">
            </div>
            <div class="modal-footer"> <a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a> <a type="button" class="btn btn-success" style="color: white;" id="delBtn">Yes</a> </div>
        </div>
    </div>
</div>

<?php include_once("includes/script.php"); ?>
<script>

    function del_ling(id) {
        $('#delete_lingual_modal').modal();
        $('#user_id').val(id);
    }

    function delete_files(id, filename) {
        $('#del_files_modal').modal()
        $('#user_id').val(id)
        $('#filename').val(filename)
    }

    $(document).ready( function () {

        $('#categoryTable').dataTable();



        $('#delBtn').click(function () {
            $( "#delBtn" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $("#delBtn").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=del_form",
                type: 'POST',
                data: {'id':$( "#user_id" ).val()},
                success: function ( data ) {
                    $( "#delBtn" ).html('Delete')
                    $("#delBtn").prop('disabled',false)

                    $( ".closee" ).click()
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            window.location.reload()
                        }, 1000 );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 1000 );
                    }
                }
            });
        });


    });


</script>

</body>
</html>
