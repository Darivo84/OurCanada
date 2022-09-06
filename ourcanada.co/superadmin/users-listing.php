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
              <h4 class="mb-0 font-size-18">Users</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="index.php">Users</a></li>
                  <li class="breadcrumb-item active">Update Users</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <?php
        if ( isset( $_GET[ 'method' ] ) && ( $_GET[ 'method' ] == 'update' ) ) {
          $userID = $_GET[ 'n_id' ];
			
$query = "SELECT * FROM users where id='".$userID."'";
			$row = mysqli_fetch_array(  mysqli_query( $conn, $query ) );
          ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title mb-4">Update User</h4>
                <form method="POST" id="edituser" >
                  <div class="prompt"></div>
                  <div class="form-group row mb-4">
					  
					  <div class="col-md-6 pl-0">
                    <label for="fna" class="col-form-label col-lg-12">Username</label>
                    <div class="col-lg-12">
                      <input id="name" name="username" type="text" class="form-control" value="<?php echo $row["username"]?>" title="Only letters & whitespaces" required>
                    </div></div>
					  
					  <div class="col-md-6 pl-0">
					   <label for="lnamea" class="col-form-label col-lg-12">Password</label>
                    <div class="col-lg-12">
                      <input class="form-control" type="text" id="pass" name="password" title="Atleast one digit, one lowercase, uppercase, one special character & 8 to 32 length" value="<?php echo $row["password"]?>" required>
                      </input>
                    </div>
					  </div>
                  </div>
        <div class="form-group row mb-4">
			<div class="col-md-6 pl-0">
                    <label for="lnamea" class="col-form-label col-lg-12">Email</label>
                    <div class="col-lg-12">
                      <input class="form-control" id="eemail" name="email" title="exm@something.com" value="<?php echo $row["email"]?>" readonly>
                      </input>
			</div></div>
				  
                  </div>            <input type="hidden" id="eId" name="id" value="<?php echo $row["id"]?>">
                  <div class="row justify-content-end">
                    <div class="col-lg-12">
                      <button id="updateLoader" type="submit" class="btn btn-primary edit-form-button">Update</button>
                      <a type="button" href="users-listing.php" class="btn btn-light">Cancel</a> </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php } else { 
	  
$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query( $conn, $query );
	  ?>
        <!--  <div class="row justify-content-end">
                <div class="col-lg-12 text-right mb-3">
                      <a href="add-users-listing.php" class="btn btn-primary">Add News</a>
                    </div>
                  </div>-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Email</th>

                          <th scope="col">Account Type</th>
                          <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $count = 1;
                      while ( $row = mysqli_fetch_array( $result ) ) {
                      $account='';
                      if($row['role']==0)
                      {
                          $account = 'Signed';
                      }
                      else {
                          $account = 'Professional';
                      }
                        ?>
                      <tr>
                        <td><span><?php echo $count ?></span></td>
                          <td><?php echo $row[ "email" ]?></td>
                          <td><?php echo $account?></td>
                        <td><a href="users-listing.php?method=update&n_id=<?php echo $row['id']; ?>" id="editbtn" type="button" class="btn btn-icon btn-success table-button"><i class="fas fa-pencil-alt" ></i> </a>
                          <button id="deletebtn" class="btn btn-icon btn-danger table-button" onclick="sendid('<?php echo $row['id']; ?>')" data-toggle="modal" data-target="#smallModal"> <i class="fa fa-trash"></i> </button></td>
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
        <!-- end row --> 

        
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
<!-- Delete Modal -->
<div id="smallModal" class="modal fade">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete User</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this user?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="d_id">
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger" onClick="deleteCategory(document.getElementById('d_id').value)">Delete</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>
<?php include_once("includes/script.php"); ?>
<script>
	$(document).ready( function () {
 	
     $('#categoryTable').dataTable(); 
} );
	
	</script> 
<script>
		function sendid(id)
	{
		 $('#d_id').val(id); 
	}
	</script> 
<script>
	function deleteCategory(id){
		 $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $("#addLoader").prop('disabled',true)

        $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=deleteN",
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
