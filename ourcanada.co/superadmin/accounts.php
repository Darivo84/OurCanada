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
              <h4 class="mb-0 font-size-18">Accounts</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="index.php">Accounts</a></li>
                  <li class="breadcrumb-item active">Professional Accounts</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
				<div class="linkHeader text-right">
					<a href="javasctipt:void(0)" data-toggle="modal" data-target="#account" class="btn btn-primary">Provide Account Access</a>  
				</div>
				<br>
                <div class="table-responsive">
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Email Address</th>
                        <th scope="col">Activation Link</th>
						<th scope="col">Created Date</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>

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

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
	
<div class="modal fade" id="account" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Request Professional Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="login-form mt-2" method="post" id="validateform2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="prompt2"></div>
                            <div class="form-group position-relative">
                                <label>Your Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" placeholder="Email" name="email" required="">
                            </div>
                        </div>


                        <div class="col-lg-12 mb-0">
                            <button class="btn btn-primary btn-block" id="btnLoader2">Provide Access</button>
                        </div>

                       
                    </div>
                </form>

            </div>
            <div class="modal-footer pl-0">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
	
<!-- Delete Modal -->
<div id="smallModal" class="modal fade">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Professional Account</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to reject request of professional account for this user? You will not be able to revert the changes</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="d_id">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger" onClick="rejectRequest(document.getElementById('d_id').value)">Reject</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>
<?php include_once("includes/script.php"); ?>
<script>
	$(document).ready( function () {

        var table= $('#categoryTable').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadAccounts',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "count" },
                { data: "email" },
                { data: "link" },
                { data: "created_date" },
                { data: "action" },


                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
} );
	
	</script> 
<script>
		function reject(id)
	{
		 $('#d_id').val(id); 
	}
	</script> 
<script>
	
	function approve(e,id){
		$(e).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $(e).prop('disabled',true)

			$.ajax( {
					dataType: 'json',
					url: "ajax.php?h=approveRequest",
					type: 'POST',
					data: {id : id},
					success: function ( data ) {
						$( e ).html('Appreved')
						$(e).prop('disabled',false)

						if ( data.Success == 'true' )
						{
						   $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
							setTimeout(function() {location.reload();}, 500);
						} else 
						{
							 $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
						}
					}
				} );
		
	}
	function rejectRequest(id){
		$( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        // $("#addLoader").prop('disabled',true)

        $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=rejectRequest",
                type: 'POST',
                data: {id : id},
                success: function ( data ) {
                    $( "#addLoader" ).html('Delete')
                    $("#addLoader").prop('disabled',false)

                    if ( data.Success == 'true' )
					{
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
						setTimeout(function() {location.reload();}, 500);
                    } else 
					{
						 $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                    }
                }
            } );
	}

    $( '#validateform2' ).validate( {
        submitHandler: function () {
            'use strict';

            {
                $( "#btnLoader2" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                $( "#btnLoader2" ).prop('disabled',true)
                $.ajax( {
                    dataType: 'json',
                    url: "ajax.php?h=add_professional_account",
                    type: 'POST',
                    data: $( "#validateform2" ).serialize(),
                    success: function ( data ) {
                        $( "#btnLoader2" ).html( 'Provide Access' );
                        $( "div.prompt2" ).html( '' );
                        $( "div.prompt2" ).show();
                        if ( data.Success === 'true' ) {
                            $( window ).scrollTop( 0 );
                            document.getElementById( "validateform2" ).reset();
                            $( '.prompt2' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i> '+data.Msg+'</div>' );
                            setTimeout( function () {
                                $('#closeModal').click()
                                $( "#btnLoader2" ).prop('disabled',false)
                                $( "div.prompt2" ).html( '' );

                            }, 5000 );
                        } else {
                            $( window ).scrollTop( 0 );
                            $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                            setTimeout( function () {
                                $( "div.prompt2" ).html( '' );
                                $( "#btnLoader2" ).prop('disabled',false)
                            }, 5000 );
                        }

                    }
                } );


                return false;

            }
            // else
            // {
            //     $('#rerror').show()
            // }
        }


    } );

</script>
<script>
$(document).ready(function() {


    $( '#edituser' ).validate( {
        submitHandler: function () {
                  var username = $('#name').val();
                  var password = $('#pass').val();
                if( (username.match(/^[a-zA-Z\s]*$/)) && (password.match(/^(?!\d+$)\w+\S+/)) ){
                  'use strict';
                  $( "#updateLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Updating' );
                    $("#updateLoader").prop('disabled',true)

                    $.ajax( {
                        dataType: 'json',
                        url: "ajax.php?h=editN",
                        type: 'POST',
                        data: $("#edituser").serialize(),
                        success: function ( data ) {
                            $( "#updateLoader" ).html('Update')
                            $("#updateLoader").prop('disabled',false)

                            if ( data.Success == 'true' ) {
                               $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                    setTimeout(function() {
                      window.location="users-listing.php";
                  }, 1500);
                            } else {
                              $(window).scrollTop(0);
                              $( "div.prompt" ).show();
                               $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-times></i>"'+data.Msg+'</div>');
                                setTimeout(function() {
                                    $( "div.prompt" ).hide();
                                }, 1500);
                            }
                        }
                    } );
                    return false;
                } else{
                    $(window).scrollTop(0);
                    $( "div.prompt" ).show();
                            $( "div.prompt" ).html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some fields missing (Hover over the password field)</div>');
                            setTimeout( function () {
                                $( "div.prompt" ).hide();
                            }, 1500 );  
                }
        }
    } );
	
});
</script> 
 
<script>
			$(document).ready( function () {
 	
		 
		 $('.get_value').each(function(){  
					if($(this).val()==1)  
					{  
						 $(this).attr('checked', 'checked');  
					}else{
						$(this).removeAttr('checked');
					} 
		  });
	
	} );
			function changeStatus(id){
				
		$.ajax({ 
		dataType: 'json',
		url:"ajax.php?h=status_changeU",  
		method:"POST",  
		data:{id:id},  
		success: function ( data ) {
				if ( data.Success === 'true' ) 
				{
				   //$(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
					//setTimeout(function() {location.reload();}, 300);
				} else 
				{
					 $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
				}
			}
   		});  
           
		};
	</script>


</body>
</html>
