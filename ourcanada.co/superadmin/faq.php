<?php
include_once( "admin_inc.php" );
$query = "SELECT * FROM faq ";
$result = mysqli_query( $conn, $query );
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
              <h4 class="mb-0 font-size-18">FAQ List</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">FAQ</a></li>
                  <li class="breadcrumb-item active">FAQ  List</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <?php
        if ( isset( $_GET[ 'method' ] ) && ( $_GET[ 'method' ] == 'update' ) ) {
          $faqTitle = $_GET[ 'faq_title' ];
          ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="prompt"></div>
              <div class="card-body">
                <h4 class="card-title mb-4">Update FAQ</h4>
                <form method="POST" id="editFaq" >
                  <div class="form-group row mb-4">
                    <label for="ename" class="col-form-label col-lg-2">FAQ Title</label>
                    <div class="col-lg-10">
                      <input id="etitle" name="title" type="text" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label for="edescription" class="col-form-label col-lg-2">FAQ Description</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" id="edescription" name="description" rows="3" required></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label for="estatus" class="col-form-label col-lg-2">Status</label>
                    <div class="col-lg-10">
                      <select name="status" id="estatus" class="form-control">
                        <option value="Enable">Enable</option>
                        <option value="Disable">Disable</option>
                      </select>
                    </div>
                  </div>
                  <input type="hidden" id="ecdate" name="createdDate">
                  <div class="row justify-content-end">
                    <div class="col-lg-10">
                      <button id="updateLoader" type="submit" class="btn btn-primary">Update</button>
                      <a type="button" href="faq.php" class="btn btn-light">Cancel</a> </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php } else { ?>
        <div class="row justify-content-end">
          <div class="col-lg-12 text-right mb-3"> <a href="add-faq.php" class="btn btn-primary">Add FAQ</a> </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <div class="table-responsive">
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $count = 1;
                      while ( $row = mysqli_fetch_array( $result ) ) {
                        ?>
                      <?php if ( $row[ 'status' ] == 'Enable' ) { ?>
                      <tr>
                        <td><span><?php echo $count ?></span></td>
                        <td><h5 class="text-truncate font-size-14"><a href="#" class="text-dark"><?php echo $row[ "title" ]?></a></h5></td>
                        <td><p class="text-muted mb-0">
                            <?php
                            $slen = strlen( $row[ "description" ] );

                            if ( $slen > 30 ) {
                              echo substr( $row[ "description" ], 0, 30 ) . "...";
                            } else {
                              echo $row[ "description" ];
                            }
                            ?>
                          </p></td>
                        <td><?php echo $row[ "createdDate" ]?></td>
                        <td><a href="faq.php?method=update&faq_title=<?php echo $row['title']; ?>" id="editbtn" type="button" class="btn btn-icon btn-success" ><i class="fas fa-pencil-alt" ></i></a>
                          <button id="deletebtn" class="btn btn-icon btn-danger" onclick="sendtitle('<?php echo $row['title']; ?>')" data-toggle="modal" data-target="#smallModal"><i class="fa fa-trash"></i></button></td>
                      </tr>
                      <?php
                      $count++;
                      }
                      }
                      ?>
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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete FAQ</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this FAQ?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="d_id">
        <button id="addLoader" type="button" class="btn btn-danger" onClick="deleteFaq(document.getElementById('d_id').value)">Delete</button>
        <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
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
		function sendtitle(name)
	{
		 $('#d_id').val(name); 
	}
	</script> 
<script>
	function deleteFaq(id){
		 $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $("#addLoader").prop('disabled',true)

        $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=deleteFaq",
                type: 'POST',
                data: {title : id},
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
  var faqT="<?php echo "$faqTitle" ?>";
		 $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=getFaq",
                type: 'POST',
                data: {title : faqT},
                success: function ( data ) {
                    if ( data.Success == 'true' ) 
					{
						debugger
						$("#etitle").val(data.data.title);
						$("#edescription").val(data.data.description);
						$("#estatus").val(data.data.status);
						$("#ecdate").val(data.data.createdDate);
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
	 $( '#editFaq' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#updateLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Updating' );
            $("#updateLoader").prop('disabled',true)

            //$( "div.prompt" ).html('');
			
            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=editFaq",
                type: 'POST',
                data: $("#editFaq").serialize(),
                success: function ( data ) {
                    $( "#updateLoader" ).html('Update')
                    $("#updateLoader").prop('disabled',false)

                    if ( data.Success == 'true' ) 
					{
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
						setTimeout(function() {window.location="faq.php";}, 300);
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
