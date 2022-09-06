<?php
// include_once( "admin_inc.php" );
include_once("global.php");

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

                                <button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Yes</button>
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


                                <table id="dtTable"  class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>User Email</th>
                                        <th>Total Score</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                   
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



<?php include_once("includes/script.php"); ?>


<script type="text/javascript" language="javascript" >  
 $(document).ready(function(){  
      var dataTable = $('#dtTable').DataTable({  
           "processing":true,  
           "serverSide":true,  
             
           "ajax":{  
                url:"ajax3.php?h=submittedforms3",  
                type:"POST"  
           },  
           'columns': [
         { data: 'id' },
         { data: 'user_name' },
         { data: 'user_email' },
         { data: 'scoree' },
         { data: 'created_date' },
         { data: 'action' },
      ],
           "columnDefs":[  
                {  
                     "targets":[5],  
                     "orderable":false,  
                },  
           ],  
      });  
 });  
 </script>  


<script>



    $("#delLoader").on('click',function(){
        var id = $("#id").val();
        $( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $( "#delLoader" ).prop('disabled',true)
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=resend_email",
            type: 'POST',
            data: {'id' : id},
            success: function ( data ) {
                $( "#delLoader" ).html( 'Yes' );
                $( "#delLoader" ).prop('disabled',false)
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
    // mailsend-btn

    $(document).on("click",".mailsend-btn",function(){
       var  id =  ($(this).attr("data-form-id"));

        $("#id").val(id);
        $("#mailModal").modal();
    });

   

</script>

</body>

</html>