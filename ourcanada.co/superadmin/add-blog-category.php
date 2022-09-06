  <?php
  include_once( "admin_inc.php" );
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
                <h4 class="mb-0 font-size-18">Add Category</h4>
                <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Categories</a></li>
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
                  <h4 class="card-title mb-4">Add Category</h4>
                  <div class="prompt"></div>
                  <form method="POST" id="add_blog_category" >
             
                    <div class="form-group row mb-4">

  					           <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (English)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title" type="text" class="form-control" required>
                        </div>
  					           </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Chinese)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_chinese" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Francais)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_french" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Hindi)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_hindi" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Punjabi)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_punjabi" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Spanish)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_spanish" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0">
                        <label for="Categoryname" class="col-form-label col-lg-12">Category Name (Urdu)</label>
                        <div class="col-lg-12">
                          <input id="title" name="title_urdu" type="text" class="form-control" required>
                        </div>
                       </div>

                       <div class="col-md-6 pl-0 pr-0">
                        <label for="status" class="col-form-label col-lg-12">Status</label>
                        <div class="col-lg-12">
                          <select id="statu" name="status"  class="form-control" title="Please select a status" required>
                            <option value="1">Enable</option>
                            <option value="0">Disable</option>
                          </select>
                        </div>
                      </div>

                    </div>

  					         <div class="form-group row mb-4">
                      <label for="Categoryname" class="col-form-label col-lg-12">Slug</label>
                      <div class="col-lg-12">
                        <input id="slug" name="slug" class="form-control" placeholder="Slug will be generated here" readonly>
                      </div>
                    </div>
                    <div class="row justify-content-end">
                      <div class="col-lg-12">
                        <button id="addLoader" type="submit" class="btn btn-primary">Add Blog Category</button>
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
  $(document).ready(function() {
     $( '#add_blog_category' ).validate( {
          submitHandler: function () {
         
         var type = $('#type').val();
                  var name = $('#title').val();
                  if( (name.match(/^[a-zA-Z0-9&\s]+$/))  ){
                    $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                      $("#addLoader").prop('disabled',true)

                      'use strict';
                    $.ajax( {
                      dataType: 'json',
                      url: "ajax.php?h=add_blog_category",
                      type: 'POST',
                      data: $("#add_blog_category").serialize(),
                      success: function ( data ) {
                          $('#addLoader').html('Add Blog Category')
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
