<?php
include_once( "admin_inc.php" );
$awardsUrl = 'https://awards.' . $_SERVER['HTTP_HOST'] . '/';

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php include_once("includes/style.php"); ?>
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
                            <h4 class="mb-0 font-size-18">User Story</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Story</a></li>
                                    <li class="breadcrumb-item active">Update</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-4 mx-auto">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Story</h4>
                                <?php
                                $select=mysqli_query($conn,"Select * from nominated_users_list where id={$_GET['s_id']}");
                                $row=mysqli_fetch_assoc($select);
                                ?>
                                <form method="POST" id="updateStory" enctype="multipart/form-data">
                                    <input type="hidden" name="sid" value="<?php echo $_GET['s_id'] ?>">
                                    <div class="form-group row mb-4">
                                        <div class="col-md-6 pl-0">


                                            <label for="Categoryname" class="col-form-label col-lg-12">Title</label>
                                            <div class="col-lg-12">
                                                <input id="title" name="n[title]" type="text" class="form-control"
                                                       placeholder="Enter Title"
                                                       title="Only letters, chars & whitespaces" required value="<?php echo $row['title'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Image</label>
                                            <div class="col-lg-12">
                                                <input type="file" style="color: #fff !important; text-align: left;" name="winner_photo" class="btn btn-success w-100" accept="image/*">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <div class="col-md-12 pl-0">

                                        <label for="Categoryname" class="col-form-label col-lg-12">Description</label>
                                        <div class="col-lg-12">
                                            <textarea id="description" name="n[description]" type="text" rows="5"
                                                      class="form-control" placeholder="Enter Description"
                                                      title="Only letters, chars & whitespaces" required><?php echo $row['description'] ?></textarea>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        
                                        <div class="col-md-6">
                                            <?php  if($row['file']!='') { ?>
                                            <div class="card" id="imgDiv">
                                                <i class="fa fa-times" id="imgClose"></i>
                                           <img id="storyImage" class="card-img-top img-fluid" src="<?php echo $awardsUrl ?>nomination/<?php echo $row['file'] ?>">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-12">
                                            <button id="addLoader" type="submit" class="btn btn-primary">Update
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="imgCheck" name="imgCheck">
                                </form>

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
    <div id="smallModal" class="modal fade">
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
<?php include_once("includes/script.php"); ?>
<script>
    $(document).ready(function() {
        $('#imgClose').click(function () {
            $('#smallModal').modal()
        })
        $('#delBtn').click(function () {
            $('#storyImage').fadeOut()
            $('#imgClose').hide()
            $('#cancel').click()
            $('#imgCheck').val(1)
        })

        $( '#updateStory' ).validate( {
            submitHandler: function () {
                $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                $("#addLoader").prop('disabled',true)

                'use strict';

                var form = $('#updateStory')[0];
                var fd = new FormData(form);
                var files = $('input[type="file"]')[0].files[0];
                fd.append('image',files);

                $.ajax( {
                    dataType: 'json',
                    url: "ajax.php?h=updateStory",
                    type: 'POST',
                    data: fd,
                    contentType: false,
                    processData: false,
                    cache: false,
                    mimeType: "multipart/form-data",
                    success: function ( data ) {
                        $("#addLoader").prop('disabled',false)
                        $( "#addLoader" ).html('Update')

                        if ( data.Success == 'true' )
                        {
                            $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                            setTimeout(function() {window.location = "nomination-listing.php?n_id=<?php echo $_GET['p_id'] ?>";}, 500);
                        } else
                        {
                            $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                        }
                    }
                } );
                return false;
            }
        } );

    });
</script>

</body>
</html>
