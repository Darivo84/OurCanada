<?php
include_once("admin_inc.php");
$query ="SELECT * FROM user ORDER BY id ASC";  
$result = mysqli_query($conn, $query);
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
                                    <h4 class="mb-0 font-size-18">Users List</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Contacts</a></li>
                                            <li class="breadcrumb-item active">Users List</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
  <?php if(isset($_GET['method']) && ($_GET['method'] == 'update')) {
						$categoryID=$_GET['c_id'];
						?>
        <div class="row">
                         <div class="col-lg-12">
                                <div class="card">
									<div class="prompt"></div>
              <div class="card-body">
                <h4 class="card-title mb-4">Update User</h4>
                <form method="POST" id="editUser" >
                  <div class="form-group row mb-4">
                    <label for="eFName" class="col-form-label col-lg-2">First Name</label>
                    <div class="col-lg-10">
                      <input id="eFName" name="firstName" type="text" class="form-control" required>
                    </div>
                  </div>
					 <div class="form-group row mb-4">
                    <label for="eLName" class="col-form-label col-lg-2">Last Name</label>
                    <div class="col-lg-10">
                      <input id="eLName" name="lastName" type="text" class="form-control" required>
                    </div>
                  </div>
					 <input type="hidden" id="eId" name="id">
                  <div class="row justify-content-end">
                    <div class="col-lg-10">
                      <button id="updateAddLoader" type="submit" class="btn btn-primary">Update</button>
        <a type="button" href="categories.php" class="btn btn-light">Cancel</a>
                    </div>
                  </div>
                </form>
				  <div class="row justify-content-end">
                    <div class="col-lg-10">
                      <button id="updateAddLoader" type="submit" class="btn btn-primary">Update</button>
        <a type="button" href="categories.php" class="btn btn-light">Cancel</a>
                    </div>
                  </div>
                  <!-- <div class="row mb-4">
                                            <label class="col-form-label col-lg-2">Attached Files</label>
                                            <div class="col-lg-10">
                                                <form action="https://themesbrand.com/" method="post" class="dropzone">
                                                    <div class="fallback">
                                                        <input id="multiupload" name="file" type="file" multiple />
                                                    </div>
                    
                                                    <div class="dz-message needsclick">
                                                        <div class="mb-3">
                                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                        </div>
                                                        
                                                        <h4>Drop files here or click to upload.</h4>
                                                    </div>
                                                </form>
                                            </div>
                                        </div> -->
                
              </div>
            </div>
                            </div>
                        </div>
        <?php } else { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="userTable" class="table table-centered table-nowrap table-hover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col" style="width: 70px;">#</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Email</th>
                                                       
                                                        <th scope="col">Password</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
          while ( $row = mysqli_fetch_array( $result ) ) {
			 ?>
                                                    <tr>
                                                        <td>
                                                            <div class="avatar-xs">
                                                                <span class="avatar-title rounded-circle">
                                                                    <?php echo strtoupper(substr($row[ "firstName" ],0,1))?>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <h5 class="font-size-14 mb-1"><a href="#" class="text-dark"><?php echo $row[ "firstName" ]." ".$row[ "lastName" ]?></a></h5>
                                                           <!-- <p class="text-muted mb-0">UI/UX Designer</p> -->
                                                        </td>
                                                        <td><?php echo $row[ "email" ] ?></td>
                                                        
                                                        <td>
                                                            <?php 
				 												$len=strlen($row["password"]);
															$count=0;
			  while($count<$len)
			  {
				  echo "*";
				  $count++;
			  }
															?>
                                                        </td>
                                                        <td>
                                                           <a id="editbtn" type="button" href="contacts-list.php?method=update&u_id=<?php echo $row['id']; ?>" class="btn btn-icon btn-success"><i class="fas fa-pencil-alt"></i></a>
										<button id="deletebtn" class="btn btn-icon btn-danger" onclick="sendid('<?php echo $row['id']; ?>')" data-toggle="modal" data-target="#smallModal"><i class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                   <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php } ?>
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                 <?php include_once("includes/footer.php"); ?>
				
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>
<div id="smallModal" class="modal fade">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Category</h6>
        
      </div>
      <div class="modal-body">
		  
		  <div class="prompt"></div>
        <p>Are you sure you want to delete this category?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="d_id">
        <button id="addLoader" type="button" class="btn btn-danger" onClick="deleteUser(document.getElementById('d_id').value)">Delete</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
  <!-- MODAL-DIALOG --> 
</div>
		
	     <?php include_once("includes/script.php"); ?>
<script>
	$(document).ready( function () {
 	
     $('#userTable').dataTable(); 
} );
	
	</script>
		<script>
		function sendid(id)
	{
		 $('#d_id').val(id); 
	}
	</script>
		<script>
	function deleteUser(id){
		$( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $("#addLoader").prop('disabled',true)


        $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=deleteU",
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
						  $(document).ready( function () {
  var uid=<?php echo $userID ?>;
		 $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=getU",
                type: 'POST',
                data: {id : uid},
                success: function ( data ) {
                    if ( data.Success == 'true' ) 
					{
						$("#eFName").val(data.data.firstName);
						$("#eLName").val(data.data.lastName);
						$("#eId").val(data.data.id);
                    } else 
					{
						$(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                    }
                }
            } );
});
</script>
		
		<script>
$(document).ready(function() {
	 $( '#editUser' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#updateAddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Updating' );
            //$( "div.prompt" ).html('');
			
            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=editU",
                type: 'POST',
                data: $("#editUser").serialize(),
                success: function ( data ) {
                    if ( data.Success == 'true' ) 
					{
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
						setTimeout(function() {window.location="contacts-list.php";}, 300);
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
