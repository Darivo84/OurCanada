<?php
include_once( "admin_inc.php" );
if ( $_SESSION[ 'role' ] == 'admin' ) {

} else {
  header( "location:login.php" );
}
?>
<?php
$listing = mysqli_query($conn,"SELECT * FROM `terms_conditions`");
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
              <h4 class="mb-0 font-size-18">Terms & Conditions</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="#">Listing</a></li>
                  <!-- <li class="breadcrumb-item active">Professional Accounts</li> -->
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
                <div class="table-responsive">
                    <div class="w-100 text-right">
                        <a href="add_terms_conditions.php" class="btn btn-primary">Add More</a>
                    </div>
                    <br>
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Language</th>
                        <th scope="col">Content</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($listing) < 1){
                            echo "<tr><td colspan='10'><h1 align='center'>No Record found.</h1></td></tr>";
                        } ?>
                    <?php
                    $count = 1;
                    while ( $row = mysqli_fetch_array( $listing ) ) {
                      $lang = mysqli_query($conn,"SELECT * FROM `multi-lingual` WHERE id = ".$row['lang_id']);
                    ?>
                      <tr>
                        <td><span><?php echo $count++ ?></span></td>
                        <td><?php echo mysqli_fetch_assoc($lang)['language']; ?></td>
                        <td><button onclick="$('#exampleModal<?= $row['id'] ?>').modal();" class="btn btn-sm btn-info">Preview</button></td>
                        <td><?php echo date('Y-m-d',strtotime($row['created_at'])); ?></td>
                        <td>
                            <a href="edit_terms_conditions.php?id=<?= $row['id'] ?>" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button onclick="confirmation('<?= $row['id'] ?>');" class="btn btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                            <button class="btn btn-<?php if($row['status'] == 1){echo "primary";}else{echo "success";} ?>" onclick="toggleAction($(this),'<?= $row['id'] ?>');"><?php if($row['status'] == 1){echo "Disable";}else{echo "Enable";} ?></button>
                        </td>
                        <div class="modal fade" id="exampleModal<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Terms & Conditions</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <?= $row['content'] ?>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      </tr>
                      <?php  } ?>

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
    
<!-- Delete Modal -->
<div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Terms & Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Yes</button>
      </div>
    </div>
  </div>
</div>

<?php include_once("includes/script.php"); ?>
<script>
    $(document).ready( function () {
    
         $('#categoryTable').dataTable(); 
    } );
    
    </script> 

<script>

    function confirmation(id){
      $("#confirmation").modal();
      $("#confirmation .btn-danger").click(function(){
        var sel = $(this);
        $.ajax({
          type: "POST",
          url: "ajax.php?h=delete_terms_conditions",
          data:{id:id},
          beforeSend: function(){
            sel.prop("disabled",true);
            sel.text("Please wait...");
          },success: function(res){
            window.location.reload();
          }
        });
      });
    }
    
    function toggleAction(sel,id){
        $.ajax({
          type: "POST",
          url: "ajax.php?h=update_status_terms_conditions",
          data:{id:id},
          dataType: "JSON",
          beforeSend: function(){
            sel.prop("disabled",true);
            sel.text("Please wait...");
          },success: function(res){
            window.location.reload();
          }
        });
    }
 
</script>
</body>
</html>
