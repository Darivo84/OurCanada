<?php
include_once( "admin_inc.php" );
?>
<!doctype html>
<html lang="en">


<head>

    <?php include_once("includes/style.php"); ?>

</head>

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

                            <?php if($_GET['method'] !== 'group'){ ?>
                                <h4 class="mb-0 font-size-18">Questions</h4>
                            <?php } else { ?>
                                <h4 class="mb-0 font-size-18">Questions Group</h4>
                            <?php } ?>

                            <?php if($_GET['method'] !== 'add' && $_GET['method'] !== 'edit' && $_GET['method'] !== 'group'){ ?>
                                <div class="page-title-right">
                                    <div class="form-group" style="float: left;    padding-right: 5px;">
                                        <select class="form-control selectBox getPage" name="pageNo" id="pageNo">
                                            <option value="">-- Select Page No--</option>
                                            <?php for($i = 1 ; $i <= 700 ; $i++){ ?>
                                                <option value="<?php echo $i; ?>" <?php if(isset($_GET['page']) && $_GET['page']==$i) { echo 'selected'; } ?>><?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <a href="?id=<?php echo $_GET['id'];?>&method=group" class="btn btn-info waves-effect waves-light" >Add Group</a>
                                    <a href="?id=<?php echo $_GET['id'];?>&method=add" class="btn btn-primary waves-effect waves-light" >Add Question</a>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#duplicateModal" class="btn btn-secondary waves-effect waves-light" >Duplicate Question</a>

                                    <a href="preview?id=<?php echo $_GET['id'];?>" class="btn btn-warning waves-effect waves-light"  target="_blank">Preview Form</a>
                                    <a href="subques_list?id=<?php echo $_GET['id'];?>" class="btn btn-danger waves-effect waves-light"  target="_blank">All Sub Questions</a>

                                </div>
                            <?php } else { ?>
                                <a href="javascript:history.go(-1)" class="btn btn-warning waves-effect waves-light">Back To Listing</a>

                            <?php } ?>
                        </div>
                    </div>
                </div>


                <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Delete Question</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="prompt"></div>
                                <div id="deleteBox">
                                    <i class="mdi mdi-alert-outline mr-2"></i>
                                    <h3>Are you sure?</h3>
                                    <p>You won't be able to revert this!</p>
                                </div>
                                <input type="hidden" name="id" id="did">

                                <button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Delete</button>
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <!-- /.modal -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <?php if($_GET['method'] == 'add'){ ?>
                                    <form method="post" id="validateForm">
                                        <div class="prompt"></div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">English</label>
                                                    <input type="text" class="form-control ques" name="n[label]" placeholder="English" required="">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Francais/French</label>
                                                    <input type="text" class="form-control ques" name="n[label_french]" placeholder="Francais/French" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Spanish</label>
                                                    <input type="text" class="form-control ques" name="n[label_spanish]" placeholder="Spanish" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Urdu</label>
                                                    <input type="text" class="form-control ques" name="n[label_urdu]" placeholder="Urdu" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Chinese</label>
                                                    <input type="text" class="form-control ques" name="n[label_chinese]" placeholder="Chinese" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Hindi</label>
                                                    <input type="text" class="form-control ques" name="n[label_hindi]" placeholder="Hindi" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Punjabi</label>
                                                    <input type="text" class="form-control ques" name="n[label_punjabi]" placeholder="Punjabi" >

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Submit</button>
                                        </div>
                                    </form>



                                <?php } else if($_GET['method'] == 'edit'){
                                    $getID = $_GET['id'];
                                    $getLabels = mysqli_query($conn , "SELECT * FROM static_labels WHERE id = '$getID'");
                                    $fetchLabels = mysqli_fetch_assoc($getLabels);

                                    ?>
                                    <form method="post" id="EvalidateForm">
                                        <div class="prompt"></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">English</label>
                                                    <input type="text" class="form-control ques" name="n[label]" placeholder="English" value="<?php echo $fetchLabels['label']; ?>" required="">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Francais/French</label>
                                                    <input type="text" class="form-control ques" name="n[label_french]" placeholder="Francais/French" value="<?php echo $fetchLabels['label_french']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Spanish</label>
                                                    <input type="text" class="form-control ques" name="n[label_spanish]" placeholder="Spanish" value="<?php echo $fetchLabels['label_spanish']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Urdu</label>
                                                    <input type="text" class="form-control ques" name="n[label_urdu]" placeholder="Urdu" value="<?php echo $fetchLabels['label_urdu']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Chinese</label>
                                                    <input type="text" class="form-control ques" name="n[label_chinese]" placeholder="Chinese" value="<?php echo $fetchLabels['label_chinese']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Hindi</label>
                                                    <input type="text" class="form-control ques" name="n[label_hindi]" placeholder="Hindi" value="<?php echo $fetchLabels['label_hindi']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Punjabi</label>
                                                    <input type="text" class="form-control ques" name="n[label_punjabi]" placeholder="Punjabi" value="<?php echo $fetchLabels['label_punjabi']; ?>">

                                                </div>
                                            </div>
                                        </div>



                                        <input type="hidden" name="id" value="<?php echo $getID; ?>">

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update</button>
                                        </div>
                                    </form>

                                <?php }
                                else { ?>
                                    <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>English</th>
                                            <th>Francais/French</th>
                                            <th>Spanish</th>
                                            <th>Urdu</th>
                                            <th>Chinese</th>
                                            <th>Hindi</th>
                                            <th>Punjabi</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $getQuery = mysqli_query($conn , "SELECT * FROM static_labels ");


                                        $count = 1;
                                        while($Row = mysqli_fetch_assoc($getQuery)){
                                            ?>

                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $Row['label']; ?></td>
                                                <td><?php echo $Row['label_french']; ?></td>
                                                <td><?php echo $Row['label_spanish']; ?></td>
                                                <td><?php echo $Row['label_urdu']; ?></td>
                                                <td><?php echo $Row['label_chinese']; ?></td>
                                                <td><?php echo $Row['label_hindi']; ?></td>
                                                <td><?php echo $Row['label_punjabi']; ?></td>

                                                <td>
                                                    <a href="?method=edit&id=<?php echo $Row['id']; ?>"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>

                                                    <a href="javascript:void(0)" onClick="DeleteModal(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php $count++; } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
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

    $( '#EvalidateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoaderE').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=updateQuestion",
                type: 'POST',
                data: $( "#EvalidateForm" ).serialize(),
                success: function ( data ) {
                    $( "#AddLoaderE" ).html( 'Submit' );
                    $('#AddLoaderE').attr('disabled',false)

                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                }
            } );

            return false;
        }
    } );

    $( '#validateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoader').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=addQuestion",
                type: 'POST',
                data: $( "#validateForm" ).serialize(),
                success: function ( data ) {
                    $( "#AddLoader" ).html( 'Submit' );
                    $('#AddLoader').attr('disabled',false)

                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        window.location.assign( "/admin/questions?id=<?php echo $_GET['id']; ?>" );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                }
            } );

            return false;
        }
    } );

    $("#delLoader").on('click',function(){
        var id = $("#did").val();
        $( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=deleteQuestion",
            type: 'POST',
            data: {'id' : id},
            success: function ( data ) {
                if(data.Success == 'true'){
                    $( "#delLoader" ).html( 'Delete Question' );
                    window.location.assign( "/admin/questions?id=<?php echo $_GET['id']; ?>" );
                }else{
                    $( "#delLoader" ).html( 'Delete Question' );
                    $( window ).scrollTop( 0 );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            }
        } );
    });

    function DeleteModal(id){
        $("#did").val(id);
        $("#deleteModal").modal();
    }
</script>

</body>

</html>