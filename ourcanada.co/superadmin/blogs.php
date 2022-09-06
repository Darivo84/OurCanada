<?php
include_once("admin_inc.php");
if(($_SESSION[ 'role' ] == 'admin')||($_SESSION[ 'role' ] == 'moderator')){

}else{
	header("location:login.php");
}

$cur_lang = '';
$view_lang = '';
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $cur_lang = "_".$_GET['lang'];
    $view_lang = '/'.$_GET['lang'];
}

?>
<!doctype html>
<html lang="en">

<head>
        
        <meta charset="utf-8" />
        
		<?php include_once("includes/style.php"); ?>
    <style>
        .descSpan
        {

        }
    </style>
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
                                    <h4 class="mb-0 font-size-18">Review Blogs</h4>

                                    <div class="page-title-right">

                                      <select onchange="getContent(this.value);" class="form-control">
                                        <option <?php if(str_replace('_', '', $cur_lang) == ""){echo "selected";} ?> value="">English Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "chinese"){echo "selected";} ?> value="chinese">Chinese Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "francais"){echo "selected";} ?> value="francais">Francais Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "hindi"){echo "selected";} ?> value="hindi">Hindi Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "spanish"){echo "selected";} ?> value="spanish">Spanish Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "urdu"){echo "selected";} ?> value="urdu">Urdu Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "punjabi"){echo "selected";} ?> value="punjabi">Punjabi Blogs</option>
                                        <option <?php if(str_replace('_', '', $cur_lang) == "arabic"){echo "selected";} ?> value="arabic">Arabic Blogs</option>
                                      </select>

                                        <!-- <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Blogs</a></li>
                                            <li class="breadcrumb-item active">Review Blogs</li>
                                        </ol> -->
                                    </div>
                                    
                                </div>
                            </div>
                        </div>     
                        <!-- end page title -->
						<?php if(isset($_GET['method']) && ($_GET['method'] == 'update')) {
						$newsID=$_GET['n_id'];
	$query = "SELECT * FROM blog_content".$cur_lang." where id='".$newsID."' && created_by = 0 ORDER BY id DESC";
			$row = mysqli_fetch_array(  mysqli_query( $conn, $query ) );
						?>
							<div class="row">
							 <div class="col-lg-12">
								<div class="card">
									
									 <div class="card-body">
					<h4 class="card-title mb-4">Update News</h4>
          <div class="prompt"></div>
					<form method="POST" id="editnews">
						<input type="hidden" name="table" value="blog_content<?php if(isset($_GET['lang']) && !empty($_GET['lang'])){echo '_'.$_GET['lang'];} ?>">
					  <div class="form-group row mb-4">
						<label for="ename" class="col-form-label col-lg-2">News Title</label>
						<div class="col-lg-10">
						  <input id="ename" name="title" type="text" class="form-control" value="<?php echo $row["title"]?>" title="Only letters, whitespaces & some special chars" required>
						</div>
					  </div>
					  <div class="form-group row mb-4">
						<label for="edescription" class="col-form-label col-lg-2">News Description</label>
						<div class="col-lg-10">
						  <textarea class="form-control" id="edescription" name="description" title="Only letters, whitespaces & some special chars" rows="3" required><?php echo $row["description"]?></textarea>
						</div>
					  </div>

						 <input type="hidden" id="eId" name="id" value="<?php echo $row["id"]?>">

						
					  <div class="row justify-content-end">
						<div class="col-lg-10">
						  <button id="updateLoader" type="submit" class="btn btn-primary edit-form-button">Update</button>
			<a type="button" href="blogs.php" class="btn btn-light">Cancel</a>
						</div>
					  </div>
					</form>                
				  </div>
				</div>
								</div>
                        </div>
						<?php } else { 
						
$query ="SELECT * FROM blog_content".$cur_lang." WHERE created_by = 0 ORDER BY id DESC";
$result = mysqli_query($conn, $query);
						?>
   <!--  <div class="row justify-content-end">
                <div class="col-lg-12 text-right mb-3">
                      <a href="add-news.php" class="btn btn-primary">Add News</a>
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
                                                    <th scope="col">Title</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Published By</th>
                                                    
                                                    <th scope="col">Created Date</th>
                                                    <th scope="col">Updated At</th>
                                                    <th scope="col">Status</th>
                                                    <!-- <th scope="col">Type</th> -->
                                                   <!-- <th scope="col">Products</th>-->
                                                <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <?php if(mysqli_num_rows($result) < 1){
                                                    echo "<tr><td colspan='10'><h1 align='center'>No Record found.</h1></td></tr>";
                                                } ?>
												<?php
			$count=1;
          while ( $row = mysqli_fetch_array( $result ) ) {
			 ?>
                                                <tr>
                                                    <td><span><?php echo $count ?></span></td>
                                                   <td class="font-weight-bold">
                                                        <?php echo displayTitle($row['title'],20,isset($_GET['lang']) ? $_GET['lang'] : ''); ?>
                                                  </td><td>
                                                    <?php echo displayTitle($row['description'],30,isset($_GET['lang']) ? $_GET['lang'] : ''); ?>
                                                    </td>
                                                    <?php    
                                                          if($row['created_by'] == 0){
                                                          $querygetusername ="SELECT * FROM users WHERE id=".$row['creator_id'];  
                                                          $result1 = mysqli_query($conn, $querygetusername);
                                                          $row1 = mysqli_fetch_array( $result1 );
                                                          $creator_name = $row1[ "username" ];
                                                        }else{
                                                          $creator_name = "Admin";
                                                        }
                                                         ?>
                                                      <td><?php echo $creator_name; ?></td>
                                                    <td><?php echo $row[ "created_at" ]?></td>
                                                    <td><?php echo $row[ "updated_at" ]?></td>
                                                    <td>
														<label class="custom-switch">
                                                                            <input value="<?php echo $row["status"]; ?>" <?php if($row["status"] == 1){echo "checked";} ?> type="checkbox" name="custom-switch-checkbox" class="get_value custom-switch-input" onChange="changeStatus('<?php echo $row['id']; ?>')">
                                                                            <span class="custom-switch-indicator"></span>
                                                                        </label>								
														
														</td>
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
                                              <!-- <td><?= $getType = str_replace('-', ' ', $row['type']); ?></td> -->
                                             <td>
                                              <?php if(empty($view_lang) || $view_lang == 'english'){}else{$row['slug'] = rand(10,1000000).'-'.$row['id'];} ?>
                                              <a type="button" href="<?= $currentTheme.'community/blog/'.$row['slug'].$view_lang ?>" class="btn btn-icon btn-info table-button"><i class="fas fa-info" ></i></a>
                                              <a onclick="$('#AssignPoints input[name=id]').val('<?= $row['id'] ?>'); $('#AssignPoints input[name=user_id]').val('<?= $row['creator_id'] ?>'); $('#AssignPoints input[name=points]').val('<?= $row['points'] ?>'); $('#AssignPoints').modal();" id="editbtn" type="button" class="btn btn-icon btn-secondary table-button"><i class="fas fa-award" ></i></a>
                                              <a href="update-user-content.php?id=<?= $row['id'] ?>&type=blog&lang=<?= str_replace('_', '', $cur_lang) ?>" id="editbtn" type="button" class="btn btn-icon btn-success table-button"><i class="fas fa-pencil-alt" ></i></a>
                          <button id="deletebtn" class="btn btn-icon btn-danger table-button" onclick="sendid('<?php echo $row['id']; ?>')" data-toggle="modal" data-target="#smallModal"><i class="fa fa-trash"></i></button></td>
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

                <div id="AssignPoints" class="modal">
                  <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Assign Token/s</h6>
                          </div>
                          <div class="modal-body">
                              <div class="prompt"></div>
                              <p>Please give points according to the news posted by the user.</p>
                              <input type="hidden" name="id" hidden>
                              <input type="hidden" name="user_id" hidden>
                              <input type="hidden" name="points" hidden>
                              <select class="form-control" name="rating" id="rating">
                                  <option value="">-- Select Points --</option>
                                  <option value="0">0</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                              </select>
                          </div>
                          <!-- MODAL-BODY -->
                          <div class="modal-footer">
                              <input type="hidden" name="id" id="s_id" value="2">
                              <button type="button" class="btn btn-light" data-dismiss="modal" onclick="$('#AssignPoints input[name=id]').val(''); $('#AssignPoints input[name=user_id]').val(''); $('#AssignPoints input[name=points]').val(''); $('#rating option:eq(0)').prop('selected',true);">Cancel</button>
                              <button id="addLoader" type="button" class="btn btn-danger" onclick="AssignPoints($('#rating').val(),$(this));"><i class="fa fa-spin fa-spinner" style="display: none;"></i> Assign Token
                              </button>
                          </div>
                      </div>
                  </div>
                  <!-- MODAL-DIALOG -->
              </div>
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
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete News</h6>
        
      </div>
      <div class="modal-body">
		  
		  <div class="prompt"></div>
        <p>Are you sure you want to delete this news?</p>
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
function getContent(value){
        if(value != ""){
            window.location.href = "<?php echo $currentTheme ?>superadmin/blogs?lang="+value;
        }else{
            window.location.href = "<?php echo $currentTheme ?>superadmin/blogs";
        }
    }
  function AssignPoints(val,sel){
    var id = $("#AssignPoints input[name=id]").val();
    var user_id = $("#AssignPoints input[name=user_id]").val();
    var points = $("#AssignPoints input[name=points]").val();
    if(id != "" && id > 0){
      if(val != ""){
        $.ajax({
          type: "POST",
          url: "ajax.php?h=assign_news_points&lang=<?= @$_GET['lang'] ?>",
          data:{id:id,user_id:user_id,val:val,points:points,table:"blog_content"},
            dataType: "json",
          beforeSend: function(){
            sel.children("i").show();
            sel.prop("disabled",true);
          },success: function(res){
            if(res.success){
              $("#AssignPoints .prompt").addClass("alert alert-success");
              $("#AssignPoints .prompt").text("Points added successfully.");
              setTimeout(function(){
                window.location.reload();
              },1500);
            }
            if(res.error){
              $("#AssignPoints .prompt").addClass("alert alert-danger");
              $("#AssignPoints .prompt").text(res.error);
              setTimeout(function(){
                $("#AssignPoints .prompt").removeClass("alert alert-danger");
                $("#AssignPoints .prompt").text("");
              },3000);
            }
            sel.children("i").hide()
            sel.prop("disabled",false)
          },error: function(e){
            sel.children("i").hide()
            sel.prop("disabled",false)
            console.log(e)
          }
        });
      }else{
        $("#AssignPoints .prompt").addClass("alert alert-danger");
        $("#AssignPoints .prompt").text("Please select points.");
        setTimeout(function(){
          $("#AssignPoints .prompt").removeClass("alert alert-danger");
          $("#AssignPoints .prompt").text("");
        },3000);
      }
    }else{
      $("#AssignPoints .prompt").addClass("alert alert-danger");
      $("#AssignPoints .prompt").text("Something is missing.Please refresh and try again.");
      setTimeout(function(){
        $("#AssignPoints .prompt").removeClass("alert alert-danger");
        $("#AssignPoints .prompt").text("");
      },3000);
    }
  }

	$(document).ready( function () {
 	
		 $('#categoryTable').dataTable(); 
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
		url:"ajax.php?h=status_change&lang=<?= @$_GET['lang'] ?>",  
		method:"POST",  
		data:{id:id,table:"blog_content"},  
		success: function ( data ) {
      console.log(data)
				if ( data.Success === 'true' ) 
				{
				   //$(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
					//setTimeout(function() {location.reload();}, 300);
				} else 
				{
					 $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
				}
			},error: function(e){
        console.log(e)
      }
   		});  
           
		};
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
                url: "ajax.php?h=deleteNews&lang=<?= @$_GET['lang'] ?>",
                type: 'POST',
                data: {id : id,table:"blog_content"},
                success: function ( data ) {
                  console.log(data);
                    $( "#addLoader" ).html('Delete')
                    $("#addLoader").prop('disabled',false)

                    if ( data.Success == 'true' )
					{
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
						setTimeout(function() {
              location.reload();
            }, 500);
                    } else 
					{
						 $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                    }
                }
            } );
	}
	</script>
<script>
  <?php if(isset($newsID)){ ?>
$(document).ready( function () {
  var cid=<?php echo $newsID ?>;
		 $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=getNews",
                type: 'POST',
                data: {id : cid,table:"blog_content"},
                success: function ( data ) {
                    if ( data.Success == 'true' ) 
					{
						$("#ename").val(data.data.title);
						$("#edescription").val(data.data.description);
					
						
			
						$("#eckeditor").val(data.data.ckeditor);
					
						$("#eId").val(data.data.id);
						
						
                    } else 
					{
						$(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                    }
                }
            } );
});
<?php } ?>
</script>
<script>
$(document).ready(function() {
	 $( '#editnews' ).validate( {
        submitHandler: function () {
              var title = $('#ename').val();
              var desc = $('#edescription').val();
              // if( (title.match(/^(?!\d+$)\w+\S+/)) && (desc.match(/^(?!\d+$)\w+\S+/)) ){
              if( (title != "") && (desc != "") ){
                   'use strict';
                  $( "#updateLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Updating' );
                  $("#updateLoader").prop('disabled',true)


                  $.ajax( {
                      dataType: 'json',
                      url: "ajax.php?h=editnews",
                      type: 'POST',
                      data: $("#editnews").serialize(),
                      success: function ( data ) {
                          $("#updateLoader").prop('disabled',false)
                          $( "#updateLoader" ).html('Update')

                          if ( data.Success == 'true' ) {
                             $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                              setTimeout(function() {
                                // window.location="blogs.php";
                              }, 1500);
                          } else {
                            $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');
                          }
                      }
                  } );
                  return false;
              } else{
                  $(window).scrollTop(0);
                  $( "div.prompt" ).show();
                  $( "div.prompt" ).html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>Invalid Data or some fields are empty</div>');
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
