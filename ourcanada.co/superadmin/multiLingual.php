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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Linguals</a></li>
                                    <li class="breadcrumb-item active">All Listing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if($_GET['method'] == 'edit'){
                    $query = "SELECT * FROM `multi-lingual` WHERE id={$_GET['id']}";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $filename = $row['file_name'];
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Update Multi Lingual</h4>
                                    <form method="POST" id="update_lingual">
                                        <div class="prompt"></div>
                                        <div class="form-group row mb-4">
                                            <label for="Categoryname" class="col-form-label col-lg-2">Language</label>
                                            <div class="col-lg-10">
                                                <input id="" name="language" type="text" class="form-control" placeholder="Enter Language" value="<?php echo $row['language']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label for="Categoryname" class="col-form-label col-lg-2">Display Name</label>
                                            <div class="col-lg-10">
                                                <input id="" name="display_name" type="text" class="form-control" placeholder="Enter Display Name" value="<?php echo $row['display_name']; ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label for="Categoryname" class="col-form-label col-lg-2">Language Code</label>
                                            <div class="col-lg-10">
                                                <input id="" name="language_code" type="text" class="form-control" placeholder="Enter Language Code" value="<?php echo $row['language_code']; ?>" required>
                                            </div>
                                        </div>
                                        <!--                                        <div class="form-group row mb-4">-->
                                        <!--                                            <label for="Categoryname" class="col-form-label col-lg-2">Flag</label>-->
                                        <!--                                            <div class="col-lg-10">-->
                                        <!--                                                <input  name="flag_image" id="flag_image" type="file" class="form-control"value="--><?php //echo $row['flag_image']; ?><!--" accept="image/*">-->
                                        <!--                                            </div>-->
                                        <!--                                            <img style="width: 50px" src="--><?php //echo $baseURL.'/superadmin/uploads/flags/'.$row['flag_image'] ?><!--">-->
                                        <!--                                        </div>-->
                                        <?php if($row['file_name'] != ""){ ?>
                                            <div class="form-group row mb-4">
                                                <label class="col-form-label col-lg-2">Editable File</label>
                                                <div class="col-lg-10 main-div">
                                                    <div class="col-lg-12" style="">
                                                        <div class="row">
                                                            <div class='col-sm-3'><div style='float: left; margin-bottom: 20px; text-align: center; display: inline-block; width: 100%; height: 100px;' class='box-setup'><span><i class="fa fa-3x fa-file-excel"></i></span><span class='cross-button'><a href="javascript:void(0);" onclick='delete_files("<?php echo $row['id']?>" , "<?php echo $filename; ?>");'><i class="fa fa-2x fa-window-close text-danger"></i></a></span><p><?php echo $filename; ?></p></div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label col-lg-2">File</label>
                                            <div class="col-lg-10">
                                                <div class="dropzone" id="div1"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label for="Categorydesc" class="col-form-label col-lg-2">Display</label>
                                            <div class="col-lg-10">
                                                <select class="form-control" name="display_type" required>
                                                    <option value="">Select Display Type...</option>
                                                    <option value="Left to Right" <?php if($row['display_type'] == 'Left to Right') echo "selected"; ?>>Left to Right</option>
                                                    <option value="Right to Left" <?php if($row['display_type'] == 'Right to Left') echo "selected"; ?>>Right to Left</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input name="id" type="text" value="<?php echo $row['id']; ?>" hidden>
                                        <div class="row justify-content-end">
                                            <div class="col-lg-10">

                                                <button id="update" type="submit" class="btn btn-primary">Update Multi Lingual</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                else{
                    ?>
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <a href="add-multi.php" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Multi Linguals</a>
                                    <a href="downloadcount.php" style="padding: 7px; margin-bottom: 15px;margin-right:7px; float: right" class="btn btn-warning waves-effect waves-light btn-sm">Download Question's Count</a>
                                    <a href="download.php" style="padding: 7px; margin-bottom: 15px;margin-right:7px; float: right" class="btn btn-success waves-effect waves-light btn-sm">Download Latest Excel</a>
                                    <a href="downloadfull.php" style="padding: 7px; margin-bottom: 15px;margin-right:7px; float: right" class="btn btn-primary waves-effect waves-light btn-sm">Download Full Excel</a>

                                    <a href="uploads/multi_lingual/format/Translation-format.xlsx" style="padding: 7px;     margin-right: 7px; margin-bottom: 15px; float: right;" class="btn btn-info waves-effect waves-light btn-sm">Download Format</a>

                                    <br><br>
                                    <div class="table-responsive">
                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100px">#</th>
                                                <th scope="col">Language</th>
                                                <th scope="col">Display Name</th>
                                                <th scope="col">File</th>
                                                <th scope="col">Display</th>
                                                <th scope="col">Code</th>
                                                <th scope="col">Comparison</th>
                                                <th scope="col">Process</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query = "SELECT * FROM `multi-lingual` ORDER BY id DESC";
                                            $result = mysqli_query($conn, $query);
                                            $count = 1;
                                            while($row = mysqli_fetch_assoc($result)){ ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo $row['language']; ?></td>
                                                    <td><?php echo $row['display_name']; ?></td>

                                                    <td><a href="uploads/multi_lingual/<?php echo $row['file_name']; ?>" download=""><?php echo $row['file_name']; ?></a></td>
                                                    <td><?php echo $row['display_type']; ?></td>
                                                    <td><?php echo $row['language_code']; ?></td>

                                                    <td><a download="" href="excel.php?file=<?php echo $row['file_name'] ?>"  type="button" title="Compare Old Format" class="btn btn-icon btn-info table-button"><i class="fas fa-file-download"></i> </a>
                                                        <a download="" href="newexcel.php?file=<?php echo $row['lang_slug'] ?>"  type="button" title="Compare New Format" class="btn btn-icon btn-success table-button"><i class="fas fa-file-download"></i> </a>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="processTran(<?php echo $row['id']; ?>);" class="text-warning" title="Process Translation"><i class="fa fa-edt"></i> Process</a>
                                                    </td>
                                                    <td><label class=""><input type="checkbox"  name="custom-switch-checkbox" class="get_value custom-switch-input" <?php if($row['status'] == 1){echo "checked";} ?> onChange="aprove($(this),<?= $row['id'] ?>);"><span class="custom-switch-indicator"></span></label></td>
                                                    <td>
                                                        <a href="multi_lingual_history.php?id=<?php echo $row['id']; ?>" class="text-warning"><i class="fa fa-plus"></i> History</a>

                                                        <a href="?method=edit&id=<?php echo $row['id']; ?>" class="text-success"> <i class="fa fa-edit"></i>&nbsp;Edit&nbsp;&nbsp;</a><a href="javascript:void(0);" onclick="del_ling(<?php echo $row['id']; ?>);" class="text-danger"><i class="fa fa-trash"></i>&nbsp;Delete</a></td>
                                                </tr>
                                                <?php $count++; } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
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
            <div class="modal-body"> Are you sure, you want to delete this Lingual Entry?
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
            <div class="modal-body"> Are you sure, you want to delete this file ?
                <input id="user_id" type="hidden">
                <input id="filename" type="hidden">
            </div>
            <div class="modal-footer"> <a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a> <a type="button" class="btn btn-success" style="color: white;" id="del_file">Yes</a> </div>
        </div>
    </div>
</div>
<div class="modal fade" id="processModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Process Translation</h5>
            </div>
            <div class="modal-body">
                <div class="prompt"></div>
                Are you sure, you want to update translation ?
                <input id="fileid" type="hidden">

            </div>
            <div class="modal-footer"> <a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a> <a type="button" class="btn btn-success" style="color: white;" id="processChanges">Yes</a> </div>
        </div>
    </div>
</div>
<?php include_once("includes/script.php"); ?>
<script>

    function del_ling(id) {
        $('#delete_lingual_modal').modal();
        $('#user_id').val(id);
    }

    function processTran(id){
        $('#processModal').modal();
        $('#fileid').val(id);
    }


    function delete_files(id, filename) {
        $('#del_files_modal').modal()
        $('#user_id').val(id)
        $('#filename').val(filename)
    }

    $(document).ready( function () {

        $('#categoryTable').dataTable();

        $("#processChanges").on('click',function(){
            $( "#processChanges" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $("#processChanges").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=processTrans",
                data: {'id':$( "#fileid" ).val()},
                type: 'POST',
                success: function ( data ) {
                    $( "#processChanges" ).html('Yes')
                    $("#processChanges").prop('Yes',false)

                    $( ".closee" ).click()
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );

                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );
                    }
                },
                error:function(data)
                {
                    $( window ).scrollTop( 0 );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>500 Internal Server Error</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            });

        })

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
                //$("#update").prop('disabled',true)
                var fd = new FormData();
                var data = $('#update_lingual').serializeArray();
                $.each(data, function(key, el) {
                    fd.append(el.name, el.value);
                });
                // var files = $('#flag_image')[0].files;
                //
                // // Check file selected or not
                // if(files.length > 0 ) {
                //     fd.append('flag_image', files[0]);
                // }
                $.ajax( {
                    dataType: 'json',
                    url: "ajax.php?h=update_lingual",
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
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
                // var files = $('#flag_image')[0].files;
                //
                // // Check file selected or not
                // if(files.length > 0 ) {
                //     formData.append('flag_image', files[0]);
                // }
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

    function aprove(sel,id){
        console.log(id);
        $.ajax({
            type: "POST",
            url: "<?= $super_admin ?>ajax.php?h=lingual_status",
            data: {id:id},
            dataType: "json",
            success:function(res){
                console.log(res)
            },error: function(e){
                console.log(e)
            }
        });
    }


</script>

</body>
</html>
