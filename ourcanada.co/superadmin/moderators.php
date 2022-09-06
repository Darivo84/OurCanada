<?php
include_once("admin_inc.php");
if($_SESSION[ 'role' ] == 'admin'){

}else{
	header("location:login.php");
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
                                    <h4 class="mb-0 font-size-18">Moderators</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Moderators</a></li>
                                            <li class="breadcrumb-item active">Update Moderators</li>
                                        </ol>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->
						<?php if(isset($_GET['method']) && ($_GET['method'] == 'update')) {
						$moderatorID=$_GET['n_id'];
	
	$query = "SELECT * FROM moderator where mod_id='".$moderatorID."'";
			$row = mysqli_fetch_array(  mysqli_query( $conn, $query ) );
						?>
							<div class="row">
							 <div class="col-lg-12">
								<div class="card">
									
									 <div class="card-body">
					<h4 class="card-title mb-4">Update User</h4>
					<form method="POST" id="editmoderator" >
						<div class="prompt"></div>
					  <div class="form-group row mb-4">
						  <div class="col-md-6 pl-0">
						<label for="fna" class="col-form-label col-lg-12">First Name</label>
						<div class="col-lg-12">
						  <input id="fname" name="firstName" type="text" class="form-control" title="Only whitespaces & letters" value="<?php echo $row["firstName"]?>" required>
						</div></div>
						  
						  <div class="col-md-6 pl-0">
						  <label for="lname" class="col-form-label col-lg-12">Last Name</label>
						<div class="col-lg-12">
						  <input class="form-control" id="lname" name="lastName" title="Only whitespaces & letters" value="<?php echo $row["lastName"]?>" required></input>
						</div>
						  
						  </div>
						  
						  
					  </div>
					 
					
					
					

						 <input type="hidden" id="eId" name="mod_id" value="<?php echo $row["mod_id"]?>">

						
					  <div class="row justify-content-end">
						<div class="col-lg-12">
						  <button id="updateLoader" type="submit" class="btn btn-primary edit-form-button">Update</button>
			<a type="button" href="moderators.php" class="btn btn-light">Cancel</a>
						</div>
					  </div>
					</form>                
				  </div>
				</div>
								</div>
                        </div>
						<?php } else { 
					
$query ="SELECT * FROM moderator ORDER BY mod_id DESC";  
$result = mysqli_query($conn, $query);
					?>
   <!--  <div class="row justify-content-end">
                <div class="col-lg-12 text-right mb-3">
                      <a href="add-moderators.php" class="btn btn-primary">Add News</a>
                    </div>
                  </div>-->
                        <div class="row">

                            <div class="col-lg-12">
                                <div class="card">
									<div class="card-body">
                                      <a href="add-moderator.php" style="padding: 7px;margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Moderator</a>
                                      <br>
                                      <br>
                                    <div class="table-responsive">

                                       
                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                            <thead class="thead-light">
												
                                                <tr>
                                                    <th scope="col" style="width: 100px">#</th>

                                                    <th scope="col">First Name</th>
                                                    <th scope="col">Last Name</th>
                                                    <th scope="col">Email</th>
                                                  
                                                   <!-- <th scope="col">Products</th>-->
                                               <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
												<?php
			$count=1;
          while ( $row = mysqli_fetch_array( $result ) ) {
			 ?>
                                                <tr>
                                                    <td><span><?php echo $count ?></span></td>
                                                  <!-- <td>
                                                        <h5 class="text-truncate font-size-14"><a href="#" class="text-dark"><?php echo $row[ "title" ]?></a></h5></td>-->
                                                     <!--   <p class="text-muted mb-0"><?php 
				 $slen=strlen($row["description"]);
			  
			  if($slen>50){
				 echo substr($row["description"],0,50)."...";}
															else
															{
																echo $row["description"];
															}
															?></p>
                                                    </td>-->
                                                  
                                                      <td><?php echo $row[ "firstName" ]?></td>
                                                    <td><?php echo $row[ "lastName" ]?></td>
                                                    <td><?php echo $row[ "email" ]?></td>
                      <!--                              <td>
														<label class="custom-switch">
                                                                            <input value="<?php echo $row["status"]; ?>" type="checkbox" name="custom-switch-checkbox" class="get_value custom-switch-input" onChange="changeStatus('<?php echo $row['id']; ?>')">
                                                                            <span class="custom-switch-indicator"></span>
                                                                        </label>								
														
														</td>-->
                                               <!--      <td>
                                                       <div class="team">
                                                            <a href="javascript: void(0);" class="team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="T-Shirts">
                                                                <img src="assets/images/product/img-1.png" class="rounded-circle avatar-xs m-1" alt="">
                                                            </a>
															<a href="javascript: void(0);" class="team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" data-original-title="T-Shirts">
                                                                <img src="assets/images/product/img-4.png" class="rounded-circle avatar-xs m-1" alt="">
                                                            </a>
        
                                                        </div>
                                                    </td>-->
                                               <td>
                                                       <a href="moderators.php?method=update&n_id=<?php echo $row['mod_id']; ?>" id="editbtn" type="button" class="btn btn-icon btn-success table-button"><i class="fas fa-pencil-alt" ></i>
                                                       </a>
										                                   <button id="deletebtn" class="btn btn-icon btn-danger table-button" onclick="sendid('<?php echo $row['mod_id']; ?>')" data-toggle="modal" data-target="#smallModal">
                                                        <i class="fa fa-trash"></i>
                                                       </button>
                                                    </td>
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

                    <!--    <div class="row">
                            <div class="col-12">
                                <div class="text-center my-3">
                                    <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>
                                </div>
                            </div> 
                        </div>
                         end row -->
                        
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
		<!-- Delete Modal -->
<div id="smallModal" class="modal fade">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Moderator</h6>
        
      </div>
      <div class="modal-body">
		  
		  <div class="prompt"></div>
        <p>Are you sure you want to delete this moderator?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="mod_id" id="d_id">
		<button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger" onClick="deletemdoerator(document.getElementById('d_id').value)">Delete</button>
        
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
	function deletemdoerator(id){
		 $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $("#addLoader").prop('disabled',true)

        $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=deleteM",
                type: 'POST',
                data: {id : id},
                success: function ( data ) {
                    $("#addLoader").prop('disabled',false)
                    $( "#addLoader" ).html('Delete')

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
	 $( '#editmoderator' ).validate( {
        submitHandler: function () {
          var fname = $('#fname').val();
          var lname = $('#lname').val();
          if( (fname.match(/^[a-zA-Z\s]*$/)) && (lname.match(/^[a-zA-Z\s]*$/)) ){
            'use strict';
            $( "#updateLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Updating' );
              $("#updateLoader").prop('disabled',true)


              $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=editM",
                type: 'POST',
                data: $("#editmoderator").serialize(),
                success: function ( data ) {
                    $( "#updateLoader" ).html('Update')
                    $("#updateLoader").prop('disabled',false)

                    if ( data.Success == 'true' ) {
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                        setTimeout(function() {window.location="moderators.php";}, 1500);
                    } else {
                        $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
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
		
		
</body>

</html>
