<?php
include_once( "admin_inc.php" );


?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>


<head>


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
								<h4 class="mb-0 font-size-18">Form Types</h4>

								<div class="page-title-right">
									<a href="" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addModal">Add Form</a>
								</div>

							</div>
						</div>
					</div>
					
					 <!-- sample modal content -->
						<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title mt-0" id="myModalLabel">Add Form</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" id="validateForm">
											<div class="prompt"></div>
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" class="form-control" name="n[name]" placeholder="Title" required="">

											</div>
											
											<div class="form-group">
												<label for="title">Status</label>
												<select name="n[status]" class="form-control" required>
													<option value="1">Enable</option>
													<option value="0">Disable</option>

												</select>
											</div>
										
											<div class="form-group">
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Add Form</button>
											</div>
										</form>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					
						<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title mt-0" id="myModalLabel">Edit Form</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" id="EvalidateForm">
											<div class="prompt"></div>
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" class="form-control" name="n[name]" id="eLabel" placeholder="Title" required="">

											</div>
											
											<div class="form-group">
												<label for="title">Status</label>
												<select name="n[status]" class="form-control" id="eStatus" required>
													<option value="1">Enable</option>
													<option value="0">Disable</option>

												</select>
											</div>
											<input type="hidden" name="id" id="id">
										
											<div class="form-group">
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update Form</button>
											</div>
										</form>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					
					
					
					<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title mt-0" id="myModalLabel">Delete Form</h5>
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
										
										<button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Delete Form</button>
										<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr>
												<th>#</th>
												<th>Name</th>
												<th>Created Date</th>
												<th>Status</th>
												<th>Action</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
												$getQuery = mysqli_query($conn , "SELECT * FROM categories");
												while($Row = mysqli_fetch_assoc($getQuery)){
											?>
											
											<tr onclick="window.location.assign('/admin/questions?id=<?php echo $Row['id']; ?>')" style="cursor: pointer">
												<td><?php echo $Row['id']; ?></td>
												<td><?php echo $Row['name']; ?></td>
												<td><?php echo $Row['created_date']; ?></td>
												<td><?php if($Row['status'] == 1) { echo '<span class="badge badge-warning">Enable</span>'; } else { echo '<span class="badge badge-danger">Disable</span>'; } ?></td>
												<td>
													<a href="/admin/questions?id=<?php echo $Row['id']; ?>" class="btn btn-sm btn-info waves-effect waves-light"><i class="fas fa-plus"></i></a>
													<a href="javascript:void(0)" onClick="EditModel(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>
													<a href="javascript:void(0)" onClick="DeleteModal(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>
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
		$( '#validateForm' ).validate( {
			submitHandler: function () {
				'use strict';
				$( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
				$.ajax( {
					dataType: 'json',
					url: "ajax.php?h=addForms",
					type: 'POST',
					data: $( "#validateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoader" ).html( 'Submit' );
						$( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/forms" );
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
		
		$( '#EvalidateForm' ).validate( {
			submitHandler: function () {
				'use strict';
				$( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
				$.ajax( {
					dataType: 'json',
					url: "ajax.php?h=updateForms",
					type: 'POST',
					data: $( "#EvalidateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoaderE" ).html( 'Submit' );
						$( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/forms" );
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
		
		
		
		
		function EditModel(id){
			$.ajax( {
				dataType: 'json',
				url: "ajax.php?h=getForms",
				type: 'POST',
				data: {'id' : id},
				success: function ( data ) {
					$("#eLabel").val(data.data.name);
					$("#id").val(data.data.id);
					$("#eStatus").val(data.data.status);
					$("#editModal").modal();
				}
			} );
		}
		
		
		$("#delLoader").on('click',function(){
			var id = $("#did").val();
			$( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
			$.ajax( {
				dataType: 'json',
				url: "ajax.php?h=deleteForm",
				type: 'POST',
				data: {'id' : id},
				success: function ( data ) {
					if(data.Success == 'true'){
						$( "#delLoader" ).html( 'Delete Form' );
						window.location.assign( "/admin/forms" );
					}else{
						$( "#delLoader" ).html( 'Delete Form' );
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