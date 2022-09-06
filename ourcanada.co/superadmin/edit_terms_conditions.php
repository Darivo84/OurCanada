<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include_once( "admin_inc.php" );
if ( $_SESSION[ 'role' ] == 'admin' ) {

} else {
  header( "location:login.php" );
}
?>
<?php
$languages = mysqli_query($conn,"SELECT * FROM `multi-lingual`");
if(isset($_GET['id'])){
  $terms = mysqli_query($conn,"SELECT * FROM terms_conditions WHERE id = ".$_GET['id']);
}
$data = mysqli_fetch_assoc($terms);
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
                  <li class="breadcrumb-item"><a href="#">Update</a></li>
                  <li class="breadcrumb-item active">Terms & Conditions</li>
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
                <div class="res_msg"></div>
                <div class="form-group">
                  <label>Select Language</label>
                  <select disabled class="form-control" id="lang_id" name="lang_id">
                    <?php while($row = mysqli_fetch_assoc($languages)){ ?>
                      <option value="<?= $row['id'] ?>" <?php if($data['lang_id'] == $row['id']){echo "selected";} ?>><?= $row['language'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Terms & Condition Content</label>
                  <textarea id="content_one" name="content_one"><?= $data['content'] ?></textarea>
                </div>
                <div class="form-group">
                  <button type="button" id="submit_form" class="btn btn-success">Submit</button>
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
<?php include_once("includes/script.php"); ?>
<script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
<script type="text/javascript">
  var content_one = CKEDITOR.replace( 'content_one' );
  
  $("#submit_form").click(function(){
    var sel = $(this);
    $.ajax({
      type: "POST",
      url: "ajax.php?h=update_terms_conditions",
      data:{
        id: "<?= $data['id'] ?>",
        lang_id:$("#lang_id").val(),
        content: CKEDITOR.instances.content_one.getData()
      },
      dataType: "JSON",
      beforeSend: function(){
        sel.prop("disabled",true);
        sel.text("Please wait...");
      },
      success: function(res){
        console.log(res);
        if(res.success){
          $(".res_msg").attr("class","alert alert-success res_msg");
          $(".res_msg").text(res.success);
          setTimeout(function(){
            window.location.href = 'terms_and_conditions.php';
          },3000);
        }
        if(res.error){
          sel.prop("disabled",false);
          sel.text("Submit");
          $(".res_msg").attr("class","alert alert-danger res_msg");
          $(".res_msg").text(res.error);

        }
          var body = $("html, body");
          body.stop().animate({scrollTop:0}, 500, 'swing', function() { 
          });
      }
    });
  });

</script>
</body>
</html>
