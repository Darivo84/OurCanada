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
								<h4 class="mb-0 font-size-18">Field Types</h4>

								<div class="page-title-right">
									<a href="" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addModal">Add Field</a>
								</div>

							</div>
						</div>
					</div>
					
					 <!-- sample modal content -->
						<div id="addModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title mt-0" id="myModalLabel">Add Field</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" id="validateForm">
											<div class="prompt"></div>
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" class="form-control" name="n[label]" placeholder="Title" required="">

											</div>
											<div class="form-group">
												<label for="title">Type</label>
												<select name="n[type]" class="form-control" required>
													<option value="text">Text Field</option>
													<option value="radio">Radio Buttons</option>
													<option value="multi-select">Multi Select</option>
													<option value="dropdown">Dropdown</option>
													<option value="calender">Calendar</option>
													<option value="age">Date Of Birth</option>
													<option value="number">Number</option>
													<option value="range">Range</option>
													<option value="currentrange">Range With Present Checkbox</option>
													<option value="email">Email Address</option>
													<option value="phone">Phone Number</option>
													<option value="country">Country</option>
												</select>
											</div>
											<div class="form-group">
												<label for="title">Character Length Status</label><br>
												<input type="radio" name="n[char_status]" value="1"><span class="radioLabels">Yes</span>
												<input type="radio" name="n[char_status]" value="0"><span class="radioLabels">No</span>
											</div>
											<div class="form-group">
												<label for="title">Character Length</label>
												<input type="text" class="form-control" name="n[char_length]" placeholder="Character Length">

											</div>
											
											<div class="form-group">
												<label for="title">Status</label>
												<select name="n[status]" class="form-control" required>
													<option value="1">Enable</option>
													<option value="0">Disable</option>

												</select>
											</div>
										
											<div class="form-group">
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Add Field</button>
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
										<h5 class="modal-title mt-0" id="myModalLabel">Edit Field</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" id="EvalidateForm">
											<div class="prompt"></div>
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" class="form-control" name="n[label]" id="eLabel" placeholder="Title" required="">

											</div>
											<div class="form-group">
												<label for="title">Type</label>
												<input class="form-control" id="eType" readonly>
													
											</div>
											<div class="form-group">
												<label for="title">Character Length Status</label><br>
												<input type="radio" name="n[char_status]" id="char_status1" value="1"><span class="radioLabels">Yes</span>
												<input type="radio" name="n[char_status]" id="char_status0" value="0"><span class="radioLabels">No</span>
											</div>
											<div class="form-group">
												<label for="title">Character Length</label>
												<input type="text" class="form-control" id="char_length" name="n[char_length]" placeholder="Character Length">

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
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update Field</button>
											</div>
										</form>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->
					
					
					<div id="viewModel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title mt-0" id="myModalLabel">View Field</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<form method="post" id="EvalidateForm">
											<div class="prompt"></div>
											<div class="form-group">
												<label for="title">Title</label>
												<input type="text" class="form-control" id="vLabel" readonly>

											</div>
											<div class="form-group">
												<label for="title">Type</label>
												<input type="text" class="form-control" id="vType" readonly>

											</div>
											<div class="form-group">
												<label for="title">Status</label>
												<input type="text" class="form-control" id="vStatus" readonly>

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
										<h5 class="modal-title mt-0" id="myModalLabel">Delete Field</h5>
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
										
										<button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Delete Field</button>
										<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div><!-- /.modal -->

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr>
												<th>#</th>
												<th>Title</th>
												<th>Type</th>
												<th>Status</th>
												<th>Action</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
												$count = 1;
												$getQuery = mysqli_query($conn , "SELECT * FROM field_types");
												while($Row = mysqli_fetch_assoc($getQuery)){
											?>
											
											<tr>
												<td><?php echo $count ?></td>
												<td><?php echo $Row['label']; ?></td>
												<td><?php echo $Row['type']; ?></td>
												<td><?php if($Row['status'] == 1) { echo '<span class="badge badge-warning">Enable</span>'; } else { echo '<span class="badge badge-danger">Disable</span>'; } ?></td>
												<td>
													<a href="javascript:void(0)" onClick="EditModel(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>
													<a href="javascript:void(0)" onClick="ViewModel(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-warning waves-effect waves-light"><i class="far fa-eye"></i></a>
													<a href="javascript:void(0)" onClick="DeleteModal(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>
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
					url: "ajax.php?h=addFields",
					type: 'POST',
					data: $( "#validateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoader" ).html( 'Submit' );
						$( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/fields" );
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
					url: "ajax.php?h=updateFields",
					type: 'POST',
					data: $( "#EvalidateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoaderE" ).html( 'Submit' );
						$( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/fields" );
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
				url: "ajax.php?h=getFields",
				type: 'POST',
				data: {'id' : id},
				success: function ( data ) {
					$("#eLabel").val(data.data.label);
					$("#id").val(data.data.id);
					$("#eType").val(data.data.type);
					$("#eStatus").val(data.data.status);
					$("#char_length").val(data.data.char_length);
					if(data.data.char_status == 0){
						$("#char_status0").prop("checked",true);
					}else{
						$("#char_status1").prop("checked",true);
					}
					$("#editModal").modal();
				}
			} );
		}
		
		function ViewModel(id){
			$.ajax( {
				dataType: 'json',
				url: "ajax.php?h=getFields",
				type: 'POST',
				data: {'id' : id},
				success: function ( data ) {
					$("#vLabel").val(data.data.label);
					$("#vType").val(data.data.type);
					$("#vStatus").val(data.data.status);
					$("#viewModel").modal();
				}
			} );
		}
		
		$("#delLoader").on('click',function(){
			var id = $("#did").val();
			$( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
			$.ajax( {
				dataType: 'json',
				url: "ajax.php?h=deleteField",
				type: 'POST',
				data: {'id' : id},
				success: function ( data ) {
					if(data.Success == 'true'){
						$( "#delLoader" ).html( 'Delete Field' );
						window.location.assign( "/admin/fields" );
					}else{
						$( "#delLoader" ).html( 'Delete Field' );
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