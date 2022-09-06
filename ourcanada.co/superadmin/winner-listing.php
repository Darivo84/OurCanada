<?php
include_once( "admin_inc.php" );

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
              <h4 class="mb-0 font-size-18">Winners</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Winners</a></li>
                  <li class="breadcrumb-item active">All Listing</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--  <div class="row justify-content-end">
                <div class="col-lg-12 text-right mb-3">
                      <a href="add-users-listing.php" class="btn btn-primary">Add News</a>
                    </div>
                  </div>-->
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
             <!-- <a href="add-award.php" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Award & Nomination</a> -->
                                      <br>
                                      <br>
                <div class="table-responsive">
                  <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" style="width: 100px">#</th>
                        <th scope="col">Award Title</th>
                        <th scope="col">Award Winner</th>
                        <th scope="col">Update</th>
                        <th scope="col">Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php 
                     $list = mysqli_query($conn,"SELECT *,award_winner.id as a_id FROM award_winner LEFT JOIN nominations ON award_winner.award_id = nominations.id");
                      $count_row = 0;
                      while ($rowList = mysqli_fetch_assoc($list)) { $count_row++;?>
                      <tr>
                        <td>#<?= $count_row ?></td>
                        <td><?= $rowList['title'] ?></td>
                        <td><?= $rowList['winner_email'] ?></td>
                        <td><button class="btn btn-sm btn-success" onclick="window.open('award-winner.php?update=<?= $rowList['a_id'] ?>','_self');"><i class="fa fa-edit"></i></button></td>
                        <td><button class="btn btn-sm btn-danger" onclick="showConfDialog(<?= $rowList['a_id'] ?>);"><i class="fa fa-trash"></i></button></td>
                      </tr>
                      <?php }
                     ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
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
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Award</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete this award?</p>
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

<div id="NominationModal" class="modal">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Nomination</h6>
      </div>
      <div class="modal-body">
        <div class="prompt"></div>
        <p>Are you sure you want to delete winner for this award?</p>
      </div>
      <!-- MODAL-BODY -->
      <div class="modal-footer">
        <input type="hidden" name="id" id="n_id">
        <button type="button" class="btn btn-light" data-dismiss="modal" onclick="$('#NominationModal').hide(); $('#n_id').val('');">Cancel</button>
        <button id="addLoader" type="button" class="btn btn-danger" onClick="delNomiation()">Delete</button>
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

  function showConfDialog(id){
    $("#NominationModal").show();
    $("#n_id").val(id);
  }

  function delNomiation(){
    $.ajax({
      type: "POST",
      url: "http://ourcanadadev.site/superadmin/ajax.php?h=deleteNominationWinner",
      data: {id:$("#n_id").val()},
      dataType: 'json',
      beforeSend: function(){
        $( "#NominationModal #addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
          $("#NominationModal #addLoader").prop('disabled',true)

      },
      success: function(res){
          $( "#NominationModal #addLoader" ).html('Delete')
          $("#NominationModal #addLoader").prop('disabled',false)

          if(res.success){
          $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check pr-2"> </i>'+res.success+'</div>');
            setTimeout(function() {location.reload();}, 500);
          }else{
            $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning pr-2"> </i>"'+res.error+'</div>');
          }
      },error: function(e){
        console.log(e);
      }
    });
  }
  
  </script> 
</body>
</html>
