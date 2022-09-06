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
                <h4 class="mb-0 font-size-18">Add Award Winner</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Award Winner</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- end page title -->
          <div class="row">
            <div class="col-lg-4 mx-auto">
             
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title mb-4">Add Award Winner</h4>
                  <div class="prompt"></div>
                  <form id="add_winner">
             
                    <div class="form-group row mb-4">
                      <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Select Award</label>
                        <div class="col-lg-12">
                          <select class="form-control" name="award" required onchange="getNomination($(this).val());">
                            <?php
                            if(isset($_GET['update']) && $_GET['update'] > 0){
                              $award = mysqli_query($conn,"SELECT * FROM award_winner LEFT JOIN nominations ON award_winner.award_id = nominations.id WHERE award_winner.id = ".$_GET['update']);
                              if(mysqli_num_rows($award)){
                                $award_row = mysqli_fetch_assoc($award);
                                echo "<option value='".$award_row['id']."'>".$award_row['title']."</option>";
                              }
                            }else{
                              $award = mysqli_query($conn,"SELECT nominations.title,nominations.id FROM nominations");
                              while ($award_row = mysqli_fetch_assoc($award)) {
                                echo "<option value='".$award_row['id']."'>".$award_row['title']."</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                    </div>

                      <div class="col-md-6 pl-0" id="winnder_dropdown">
                        <label for="Categoryname" class="col-form-label col-lg-12">Select Winner</label>
                        <div class="col-lg-12">
                          <select class="form-control" name="user" required>
                            <?php 
                            $winnerName = '';
                            if(isset($_GET['update']) && $_GET['update'] > 0){
                              $award = mysqli_query($conn,"SELECT *,nominated_users_list.user_email as u_email FROM award_winner LEFT JOIN nominated_users_list ON award_winner.award_id = nominated_users_list.award_id WHERE award_winner.id = ".$_GET['update']);
                              if(mysqli_num_rows($award) > 0){
                                $award_row = mysqli_fetch_assoc($award);
                                $user_list = explode(',', $award_row['user_email']);
                                $winnerName = $award_row['winner_name'];
                                for ($i=0; $i < count($user_list); $i++) {
                                    if($user_list[$i] == $award_row['winner_email']){
                                     echo "<option value='".$user_list[$i]."' selected>".$user_list[$i]."</option>";
                                    }else{
                                      echo "<option value='".$user_list[$i]."'>".$user_list[$i]."</option>";
                                    }
                                }

                              }
                            }
                            ?>
                          </select>
                        </div>
                    </div>
                    <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Winner Name</label>
                        <div class="col-lg-12">
                          <input type="text" class="form-control" name="name" value="<?= $winnerName; ?>">
                        </div>
                    </div>
                    <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Winner Photo</label>
                        <div class="col-lg-12">
                          <!-- <button class="btn btn-success" type="button" onclick="$('input[name=winner_photo]').click();">Upload Photo</button> -->
                          <input type="file" style="color: #fff !important; text-align: left;" name="winner_photo" class="btn btn-success w-100" <?php if(isset($_GET['update']) && $_GET['update'] > 0){echo "";}else{echo "required";} ?>>
                        </div>
                    </div>
                      <div class="col-lg-12 pt-4">
                        <?php 
                        if(isset($_GET['update']) && $_GET['update'] > 0){
                          echo '<button id="addLoader" type="submit" class="btn btn-primary">Update Winner</button>';
                        }else{
                          echo '<button id="addLoader" type="submit" class="btn btn-primary">Save Winner</button>';
                        }
                        ?>
                        
                      </div>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
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
  <?php include_once("includes/script.php"); ?>
  <script>

    function getNomination(val){
      $.ajax({
        type: "POST",
        url: "http://ourcanadadev.site/superadmin/ajax.php?h=getNiminations",
        data: {id:val},
        dataType: "json",
        beforeSend: function(){
          $("#winnder_dropdown .col-form-label").text('Please wait...');
        },
        success: function(res){
          $("#winnder_dropdown .col-form-label").text('Select Winner');
          if(res.success){
            $("#winnder_dropdown select").html(res.success);
          }else{
            $("#winnder_dropdown select").html("<option value=''>No Nomination Found</option>");
          }
        },error: function(e){
          $("#winnder_dropdown .col-form-label").text('Select Winner');
          console.log(e)
        }
      });
    }

     // $().ready(function() {
     //      $.validator.addMethod('winner_photo', function (value) { 
     //        return value.files[0].size < 10000
     //      }, 'Format: Image size is large.');
     //    });

  $(document).ready(function(){
    
    $("input[name=winner_photo]").change(function(){
      var ext = $(this).val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['png','jpg','jpeg']) == -1) {
        $("input[name=winner_photo]").after('<label for="winner_photo" class="error">Please select valid image.</label>');
        $("input[name=winner_photo]").val('');
      }else{
        $("input[name=winner_photo]").siblings("label[for=winner_photo]").remove();
      }
    });

    $("#add_winner").validate({
      submitHandler: function(){
        $( "#add_winner #addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
          'use strict';
          // $.ajax({
          //   type: "POST",
          //   url: "http://ourcanadadev.site/superadmin/ajax.php?h=addWinner",
          //   enctype: 'multipart/form-data',
          //   data: new FormData($('#add_winner')[0]),
          //   contentType: false,
          //   cache: false,
          //   processData:false,
          //   dataType: "json",
          //   success: function(res){
          //     console.log(res)
          //     $( "#add_winner #addLoader" ).html( 'Save Winner' );
          //     if(res.Success){
          //       $(".prompt").html('<div class="alert alert-success">'+res.Success+'</div>');
          //       setTimeout(function(){
          //         window.location.reload();
          //       },1000);
          //     }else if(res.Update){
          //       $(".prompt").html('<div class="alert alert-success">'+res.Update+'</div>');
          //       setTimeout(function(){
          //         window.open('winner-listing.php','_self');
          //       },1000);
          //     }else{
          //       $(".prompt").html('<div class="alert alert-warning">'+res.Msg+'</div>');
          //       setTimeout(function(){
          //         $(".prompt").html("");
          //       },3000);
          //     }
          //   },error: function(e){
          //     setTimeout(function(){
          //         $(".prompt").html("");
          //       },3000);
          //     $( "#add_winner #addLoader" ).html( 'Save Winner' );
          //     console.log(e)
          //   }
          // });
          return false;
      }
    });
  });
  </script>

</body>
</html>