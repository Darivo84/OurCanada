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
              <h4 class="mb-0 font-size-18">Blog Categories</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">add_blog_category</a></li>
                  <li class="breadcrumb-item active">All Listing</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <?php
        if ( isset( $_GET[ 'method' ] ) && ( $_GET[ 'method' ] == 'update' ) ) {
          $cat_id = $_GET[ 'n_id' ];
			
	$query = "SELECT * FROM category_blog where id='".$cat_id."'";
			$row = mysqli_fetch_array(  mysqli_query( $conn, $query ) );
          ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title mb-4">Update Category</h4>
                <form method="POST" id="edit_blog_category" >
             
                    <div class="form-group row mb-4">

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (English)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title" type="text" class="form-control" value="<?= $row['title'] ?>" placeholder="Enter Category Name" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Chinese)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_chinese" type="text" value="<?= $row['title_chinese'] ?>" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Francais)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_french" type="text" value="<?= $row['title_french'] ?>" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Hindi)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_hindi" value="<?= $row['title_hindi'] ?>" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Punjabi)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_punjabi" value="<?= $row['title_punjabi'] ?>" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Spanish)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_spanish" value="<?= $row['title_spanish'] ?>" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Urdu)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_urdu" value="<?= $row['title_urdu'] ?>" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0 pr-0">
                        <label for="status" class="col-form-label col-lg-12">Status</label>
                        <div class="col-lg-12">
                          <select id="statu" name="status"  class="form-control" title="Please select a status" required>
                            <option value="1" <?php if($row['status'] == '1'){echo "selected";} ?>>Enable</option>
                            <option value="0" <?php if($row['status'] == '0'){echo "selected";} ?>>Disable</option>
                          </select>
                        </div>
                      </div>

                    </div>

                     <div class="form-group row mb-4">
                      <label for="Categoryname" class="col-form-label col-lg-12">Slug</label>
                      <div class="col-lg-12">
                        <input id="slug" name="slug" class="form-control" value="<?= $row['slug'] ?>" placeholder="Slug will be generated here" readonly>
                      </div>
                    </div>
                    <div class="row justify-content-end">
                      <div class="col-lg-12">
                        <input type="hidden" hidden name="id" value="<?= $row['id'] ?>">
                        <button id="addLoader" type="submit" class="btn btn-primary">Update Blog Category</button>
                      </div>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
        <?php } else { 
	
$query = "SELECT * FROM category_blog ORDER BY id DESC";
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
				     <a href="add-blog-category.php" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Category</a>
                                      <br>
                                      <br>
                <div class="table-responsive">
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        
                        <th scope="col">Title</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Status</th>
						<th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $count = 1;
                      while ( $row = mysqli_fetch_array( $result ) ) {
                        ?>
                      <tr>
                        <td><span><?php echo $count ?></span></td>
                        <td class="font-weight-bold"><?php echo $row[ "title" ]?></td>
                        
						  <td><?php echo $row[ "created_date" ]?></td>
						  <td><label class="">
                            <input value="<?php echo $row["status"]; ?>" type="checkbox" name="custom-switch-checkbox" class="get_value custom-switch-input" onChange="changeStatus('<?php echo $row['id']; ?>')">
                            <span class="custom-switch-indicator"></span> </label></td>
                        <td><a href="blog-category-listing.php?method=update&n_id=<?php echo $row['id']; ?>" id="editbtn" type="button" class="btn btn-icon btn-success table-button"><i class="fas fa-pencil-alt" ></i> </a>
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
        
        <!--    <div class="row">
                            <div class="col-12">
                                <div class="text-center my-3">
                                    <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>
                                </div>
                            </div> 
                        </div>
                         end row --> 
        
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
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Category</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this Category?</p>
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
                url: "ajax.php?h=delete_blog_category",
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
	 $( '#edit_blog_category' ).validate( {
        submitHandler: function () {
                  var name = $('#title').val();
                  if( (name.match(/^[a-zA-Z0-9&\s]+$/))  ){
                    $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                      $("#addLoader").prop('disabled',true)

                      'use strict';
                    $.ajax( {
                      dataType: 'json',
                      url: "ajax.php?h=edit_blog_category",
                      type: 'POST',
                      data: $("#edit_blog_category").serialize(),
                      success: function ( data ) {
                          $( "#addLoader" ).html('Update Blog Category')
                          $("#addLoader").prop('disabled',false)

                          if ( data.Success == 'true' ){
                          $( "div.prompt" ).show();
                          $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                          setTimeout(function() {window.location = "blog-category-listing.php";}, 1000);
                        } else {
                          $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                        }
                      }
                    });
                    return false;
                  } else{
                    $(window).scrollTop(0);
                    $( "div.prompt" ).show();
                    $( "div.prompt" ).html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some field is missing</div>');
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
  var cid=<?php echo $newsID ?>;
		 $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=getAN",
                type: 'POST',
                data: {id : cid},
                success: function ( data ) {
                    if ( data.Success == 'true' ) 
					{
						$("#etitle").val(data.data.title);
						$("#edescription").val(data.data.description);
						$("#elastDate").val(data.data.lastDate);
						$("#eannouncementDate").val(data.data.announcementDate);
						$("#ecreatedDate").val(data.data.createdDate);
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
		url:"ajax.php?h=status_change_category",  
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

  <script>
   $(document).ready(function(){

        $("#title").change(function(){
          var link=$("#title").val();
          var sluglink=link.toLowerCase();
          var final=sluglink.replace(/\s+/g, '-')
          $("#slug").val(final);
        });
        $("#slug").change(function(){
          var link=$("#slug").val();
          var sluglink=link.toLowerCase();
          var final=sluglink.replace(/\s+/g, '-')
          $("#slug").val(final);
        });
    
   });




</script>
</body>
</html>
