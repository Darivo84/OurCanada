<?php
include_once( "admin_inc.php" );

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php include_once("includes/style.php"); ?>
    <link href="assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/dropzone/min/dropzone.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
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
                            <h4 class="mb-0 font-size-18">Emails</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Lingual</a></li>
                                    <li class="breadcrumb-item active">Email Templates</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mx-auto"></div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">


                            <div class="card-body">
                                <?php if($_GET['method'] == 'add'){ ?>
                                    <form method="post" id="validateForm">
                                        <div class="prompt"></div>
                                        <h4>Greeting Text</h4>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">English</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text]" placeholder="Dear User" required="">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Francais/French</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_french]" placeholder="Francais/French" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Spanish</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_spanish]" placeholder="Spanish" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Urdu</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_urdu]" placeholder="Urdu" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Chinese</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_chinese]" placeholder="Chinese" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Hindi</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_hindi]" placeholder="Hindi" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Punjabi</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_punjabi]" placeholder="Punjabi" >

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Arabic</label>
                                                    <input type="text" class="form-control ques" name="n[greeting_text_arabic]" placeholder="Arabic" >

                                                </div>
                                            </div>
                                        </div>
                                        <h4>Body Message</h4>
                                        <hr>

                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">English</label>
                                                    <textarea class="form-control" placeholder="English" name="n[main_text]" rows="4" required></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Francais/French</label>
                                                    <textarea class="form-control" placeholder="Francais/French" name="n[main_text_french]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Spanish</label>
                                                    <textarea class="form-control" placeholder="Spanish" name="n[main_text_spanish]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Urdu</label>
                                                    <textarea class="form-control" placeholder="Urdu" name="n[main_text_urdu]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Chinese</label>
                                                    <textarea class="form-control" placeholder="Chinese" name="n[main_text_chinese]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Hindi</label>
                                                    <textarea class="form-control" placeholder="Hindi" name="n[main_text_hindi]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Punjabi</label>
                                                    <textarea class="form-control" placeholder="Punjabi" name="n[main_text_punjabi]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Arabic</label>
                                                    <textarea class="form-control" placeholder="Arabic" name="n[main_text_arabic]" rows="4" ></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Type</label>
                                                    <select name="n[type]" class="form-control" required>
                                                        <option value="" disabled selected>--Select--</option>
                                                        <option value="request approval">Professional Account Request Approval</option>
                                                        <option value="request rejection">Professional Account Request Rejection</option>
                                                        <option value="upgrade account">Upgrade User to Professional Account</option>
                                                        <option value="reset password">Password Reset Request</option>
                                                        <option value="refer code">Referral Mail</option>
                                                        <option value="reset code">CMS Password Reset</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Submit</button>
                                        </div>
                                    </form>



                                <?php }
                                else if($_GET['method'] == 'edit'){
                                $getID = $_GET['id'];
                                $getLabels = mysqli_query($conn , "SELECT * FROM email_templates WHERE id = '$getID'");
                                $fetchLabels = mysqli_fetch_assoc($getLabels);

                                ?>
                                <form method="post" id="EvalidateForm">
                                    <div class="prompt"></div>
                                    <h4>Greeting Text</h4>
                                    <hr>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">English</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text]" value="<?php echo $fetchLabels['greeting_text']; ?>" placeholder="Dear User" required="">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Francais/French</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text_french]" value="<?php echo $fetchLabels['greeting_text_french']; ?>" placeholder="Francais/French" >

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Spanish</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text_spanish]" value="<?php echo $fetchLabels['greeting_text_spanish']; ?>" placeholder="Spanish" >

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Urdu</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text_urdu]" value="<?php echo $fetchLabels['greeting_text_urdu']; ?>" placeholder="Urdu" >

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Chinese</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text_chinese]" value="<?php echo $fetchLabels['greeting_text_chinese']; ?>" placeholder="Chinese" >

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Hindi</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text_hindi]" value="<?php echo $fetchLabels['greeting_text_hindi']; ?>" placeholder="Hindi" >

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="title">Punjabi</label>
                                                <input type="text" class="form-control ques" name="n[greeting_text_punjabi]" placeholder="Punjabi" value="<?php echo $fetchLabels['greeting_text_punjabi']; ?>" >

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="title">Arabic</label>
                                            <input type="text" class="form-control ques" name="n[greeting_text_arabic]" placeholder="Arabic" value="<?php echo $fetchLabels['greeting_text_arabic']; ?>" >

                                        </div>
                                    </div>
                            </div>
                            <h4>Body Message</h4>
                            <hr>

                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">English</label>
                                        <textarea class="form-control" placeholder="English" name="n[main_text]" rows="4" required><?php echo $fetchLabels['main_text']; ?></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Francais/French</label>
                                        <textarea class="form-control" placeholder="Francais/French" name="n[main_text_french]" rows="4" ><?php echo $fetchLabels['main_text_french']; ?></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Spanish</label>
                                        <textarea class="form-control" placeholder="Spanish" name="n[main_text_spanish]" rows="4" ><?php echo $fetchLabels['main_text_spanish']; ?></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Urdu</label>
                                        <textarea class="form-control" placeholder="Urdu" name="n[main_text_urdu]" rows="4" ><?php echo $fetchLabels['main_text_urdu']; ?></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Chinese</label>
                                        <textarea class="form-control" placeholder="Chinese" name="n[main_text_chinese]" rows="4" ><?php echo $fetchLabels['main_text_chinese']; ?></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Hindi</label>
                                        <textarea class="form-control" placeholder="Hindi" name="n[main_text_hindi]" rows="4" ><?php echo $fetchLabels['main_text_hindi']; ?></textarea>

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="title">Punjabi</label>
                                        <textarea class="form-control" placeholder="Punjabi" name="n[main_text_punjabi]" rows="4" ><?php echo $fetchLabels['main_text_punjabi']; ?></textarea>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Arabic</label>
                                    <textarea class="form-control" placeholder="Arabic" name="n[main_text_arabic]" rows="4" ><?php echo $fetchLabels['main_text_arabic']; ?></textarea>

                                </div>
                            </div>

                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Type</label>
                                    <select name="n[type]" class="form-control" required disabled>
                                        <option value="" disabled selected>--Select--</option>
                                        <option value="request approval" <?php if($fetchLabels['type']=='request approval') echo 'selected'; ?>>Professional Account Request Approval</option>
                                        <option value="request rejection" <?php if($fetchLabels['type']=='request rejection') echo 'selected'; ?>>Professional Account Request Rejection</option>
                                        <option value="upgrade account" <?php if($fetchLabels['type']=='upgrade account') echo 'selected'; ?>>Upgrade User to Professional Account</option>
                                        <option value="reset password" <?php if($fetchLabels['type']=='reset password') echo 'selected'; ?>>Password Reset Request</option>
                                        <option value="refer code" <?php if($fetchLabels['type']=='refer code') echo 'selected'; ?>>Referral Mail</option>
                                        <option value="reset code" <?php if($fetchLabels['type']=='reset code') echo 'selected'; ?>>CMS Password Reset</option>

                                    </select>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="id" value="<?php echo $getID; ?>">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update</button>
                        </div>
                        </form>

                        <?php }
                        else {  ?>
                            <!--                                        <div class="row">-->
                            <!--                                            <div class="col-sm-12">-->
                            <!--                                                <a href="?method=add" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add New</a>-->
                            <!---->
                            <!--                                            </div>-->
                            <!--                                        </div>-->

                            <div class="table-responsive">

                                <table id="datatable" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Created Date</th>
                                        <th>Updated By</th>
                                        <th>Updated Date</th>
                                        <th>Action</th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>

                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("includes/footer.php"); ?>
</div>
</div>
<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="prompt2"></div>
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

<div class="rightbar-overlay"></div>
<?php include_once("includes/script.php"); ?><br>
<script>
    $(document).ready( function () {


        var table =  $('#datatable').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadEmailTemplate',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "count" },
                { data: "type" },
                { data: "created_date" },
                { data: "updated_by" },
                { data: "updated_date" },
                <?php if($_GET['method']=='delete') { ?>
                { data: "action2" },
                <?php } else { ?>
                { data: "action" },

                <?php } ?>

                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );

        $('#filter').on('change', function () {
            if(this.value=='All')
            {
                table.columns(8).search('').draw();

            }
            else
            {
                table.columns(8).search( this.value ).draw();
            }
        } );

    });

    $( '#EvalidateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoaderE').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=updateEmailTemplate",
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
                            window.location.assign('/superadmin/email_templates')

                        }, 1500 );
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
                url: "ajax.php?h=addEmailTemplate",
                type: 'POST',
                data: $( "#validateForm" ).serialize(),
                success: function ( data ) {
                    $( "#AddLoader" ).html( 'Submit' );
                    $('#AddLoader').attr('disabled',false)

                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            window.location.assign('/superadmin/email_templates')
                        }, 2000 );
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
            url: "ajax.php?h=deleteEmailTemplate",
            type: 'POST',
            data: {'id' : id},
            success: function ( data ) {
                $( "#delLoader" ).html( 'Delete' );

                if(data.Success == 'true'){
                    $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                        window.location.reload()

                    }, 2000 );
                }else{
                    $( window ).scrollTop( 0 );
                    $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
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
    $(document).ready(function() {
        $(window).keydown(function(event){
            if( (event.keyCode == 13)) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
</body>
</html>


