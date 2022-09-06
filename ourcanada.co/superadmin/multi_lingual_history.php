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
                            <h4 class="mb-0 font-size-18">Multi Linguals</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Linguals History</a></li>
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
                                    <a href="/superadmin/multiLingual.php" style="padding: 7px; margin-bottom: 15px;margin-right:7px; float: right" class="btn btn-primary waves-effect waves-light btn-sm">Back to Listing</a>
<br><br>
                                    <div class="table-responsive">
                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100px">#</th>
                                                <th scope="col">Language</th>
                                                <th scope="col">File</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query = "SELECT h.*,m.language FROM `multi_lingual_history` as h join `multi-lingual` as m on h.file_id=m.id where h.file_id={$_GET['id']}  ORDER BY h.id DESC ";
                                            $result = mysqli_query($conn, $query);
                                            $count = 1;
                                            while($row = mysqli_fetch_assoc($result)){ ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $row['language']; ?></td>
                                                    <td><?php echo $row['file_name']; ?></td>
                                                    <td><?php echo date("Y-m-d",strtotime($row['crated_at'])); ?></td>
                                                    <td><a download="" href="/superadmin/uploads/multi_lingual/<?php echo $row['file_name'] ?>"  type="button" class="btn btn-icon btn-info table-button"><i class="fas fa-file-download"></i> </a></td>
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
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Multi-Lingual</h5>
            </div>
            <div class="modal-body"> Are you sure, you wan't to delete this Lingual Entry?
                <input id="user_id" type="hidden">
            </div>
            <div class="modal-footer"> <a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a> <a type="button" class="btn btn-success" style="color: white;" id="delBtn">Yes</a> </div>
        </div>
    </div>
</div>
<div class="modal fade" id="del_files_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete File</h5>
            </div>
            <div class="modal-body"> Are you sure, you wan't to delete this file ?
                <input id="user_id" type="hidden">
                <input id="filename" type="hidden">
            </div>
            <div class="modal-footer"> <a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a> <a type="button" class="btn btn-success" style="color: white;" id="del_file">Yes</a> </div>
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

        $('#del_lingual').click(function () {
            $( "#del_lingual" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $("#del_lingual").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=del_lingual",
                type: 'POST',
                success: function ( data ) {
                    $( "#del_lingual" ).html('Delete')
                    $("#del_lingual").prop('disabled',false)

                    $( ".closee" ).click()
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            window.location.reload()
                        }, 3000 );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );
                    }
                }
            });
        });

        $('#del_file').click(function () {
            $( "#del_file" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $("#del_file").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=del_file_lingual",
                type: 'POST',
                data: {'id':$( "#user_id" ).val(), 'filename':$("#filename").val()},
                success: function ( data ) {
                    $( "#del_file" ).html('Delete')
                    $("#del_file").prop('disabled',false)

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

        $('#delBtn').click(function () {
            $( "#delBtn" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $("#delBtn").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=del_lingual_entry",
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

        $( '#update_lingual' ).validate( {
            submitHandler: function () {
                'use strict';
                $( "#update" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Updating' );
                $("#update").prop('disabled',true)

                $.ajax( {
                    dataType: 'json',
                    url: "ajax.php?h=update_lingual",
                    type: 'POST',
                    data: $("#update_lingual").serialize(),
                    success: function ( data ) {
                        $( "#update" ).html('Update')
                        $("#update").prop('disabled',false)

                        if ( data.Success == 'true' ){
                            $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                            setTimeout(function() {window.location="multiLingual.php";}, 500);
                        } else{
                            $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                        }
                    }
                } );
                return false;
            }
        } );

    });

    Dropzone.autoDiscover = false;
    var updateDropzone = new Dropzone("#div1", {
        addRemoveLinks: true,
        autoProcessQueue: false,
        timeout: 1000000, /*milliseconds*/
        acceptedFiles: '.xls, .xlsx, .csv',
        url: 'ajax.php?h=update_lingual',
        init: function () {
            var myDropzone = this;
            // Update selector to match your button
            $("#update").click(function (e) {
                if (myDropzone.getQueuedFiles().length > 0) {
                    e.preventDefault();
                    myDropzone.processQueue();
                } else{
                    $("#update_lingual").submit();
                }
            });
            this.on('sending', function(file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                var data = $('#update_lingual').serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
            });
            this.on('complete', function(file) {
                var response = JSON.parse(file.xhr.responseText);
                if(response.Success == 'true'){
                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+response.Msg+'</div>');
                    setTimeout(function() {window.location="multiLingual.php";}, 500);
                } else{
                    $( "div.prompt" ).show();
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + response.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                        myDropzone.removeAllFiles(true);
                        $('#update_lingual').reset();
                    }, 3000 );
                }
            });
        }
    });

</script>

</body>
</html>
