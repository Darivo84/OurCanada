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
              <h4 class="mb-0 font-size-18">Add Moderator</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">Moderator</a></li>
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
                <h4 class="card-title mb-4">Add Moderator</h4>
                <form method="POST" id="addmoderator" >
           <div class="prompt"></div>
                  <div class="row">
					  <div class="col-md-6 pl-0">
                    <label for="Categoryname" class="col-form-label col-lg-12">First Name</label>
                    <div class="col-lg-12">
                      <input id="fname" name="firstName" type="text" class="form-control" placeholder="Enter first Name" title="Only whitespaces & letters" required>
                    </div></div>
					  
					  <div class="col-md-6 pl-0">
					   <label for="Categorydesc" class="col-form-label col-lg-12">Last Name</label>
                    <div class="col-lg-12">
                      <input id="lname" name="lastName" type="text" class="form-control" placeholder="Enter last Name" title="Only whitespaces & letters" required>
                    </div>
					  </div>
                  </div>
                  
                      <div class="form-group row mb-4">
						  <div class="col-md-6 pl-0">
							  
						   <label for="Categorydesc" class="col-form-label col-lg-6">Email</label>
						   
                    <div class="col-lg-12">
                      <input id="eemail" name="email" type="email" title="exm@something.com" class="form-control" placeholder="Enter email" required>
						<div class="emailerror"></div>
                    </div>
						  </div>
						  
						  <div class="col-md-6 pl-0">
						   <label for="Categorydesc" class="col-form-label col-lg-12">Password</label>
                    <div class="col-lg-12">
                      <input id="ppassword" name="password" type="password" class="form-control" placeholder="Enter password" required>
                    </div>
						  
						  </div>
                   
                  </div>
          
                  <div class="row justify-content-end">
                    <div class="col-lg-12">
                      <button id="addLoader" type="submit" class="btn btn-primary">Add Moderator</button>
                    </div>
                  </div>
                </form>
                  <!-- <div class="row mb-4">
                                            <label class="col-form-label col-lg-2">Attached Files</label>
                                            <div class="col-lg-10">
                                                <form action="https://themesbrand.com/" method="post" class="dropzone">
                                                    <div class="fallback">
                                                        <input id="multiupload" name="file" type="file" multiple />
                                                    </div>
                    
                                                    <div class="dz-message needsclick">
                                                        <div class="mb-3">
                                                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                                                        </div>
                                                        
                                                        <h4>Drop files here or click to upload.</h4>
                                                    </div>
                                                </form>
                                            </div>
                                        </div> -->
                
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
   $( '#addmoderator' ).validate( {
        submitHandler: function () {
                  var fname = $('#fname').val();
                  var lname = $('#lname').val();
                  var password = $('#ppassword').val();
                if( (fname.match(/^[a-zA-Z\s]*$/)) && (lname.match(/^[a-zA-Z\s]*$/)) && password != "" ){
                    $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                    $("#addLoader").prop('disabled',true)

                    'use strict';
                    $.ajax( {
                        dataType: 'json',
                        url: "ajax.php?h=addnewM",
                        type: 'POST',
                        data: $("#addmoderator").serialize(),
                        success: function ( data ) {
                            $( "#addLoader" ).html('Add Moderator')
                            $("#addLoader").prop('disabled',false)

                            if ( data.Success == 'true' ) {
                               $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                                setTimeout(function() {window.location = "moderators.php";}, 500);
                            } else if(data.Success == 'false'){
                                $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-times></i>"'+data.Msg+'</div>');
                            }
                             else{
                                $(".prompt").html('<div class="alert alert-danger">'+data.Msg+'</div>');
                                $( "#addLoader" ).html( 'Add Moderator' );
                             }
                        }
                    } );
                    return false;
                } else{
                    $(window).scrollTop(0);
                    $( "div.prompt" ).show();
                            $( "div.prompt" ).html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some fields missing</div>');
                            setTimeout( function () {
                                $( "div.prompt" ).hide();
                            }, 1500 );  
                }
        }
    } );
  
});
</script>
  <!--
  <script>

    function uploadajax(ttl,cl){

    var fileList = $('#multiupload').prop("files");
    $('#prog'+cl).removeClass('loading-prep').addClass('upload-image');

    var form_data =  "";

    form_data = new FormData();
    form_data.append("upload_image", fileList[cl]);


    var request = $.ajax({
              url: "upload.php",
              cache: false,
              contentType: false,
              processData: false,
              async: true,
              data: form_data,
              type: 'POST', 
              xhr: function() {  
                  var xhr = $.ajaxSettings.xhr();
                  if(xhr.upload){ 
                  xhr.upload.addEventListener('progress', function(event){
                      var percent = 0;
                      if (event.lengthComputable) {
                          percent = Math.ceil(event.loaded / event.total * 100);
                      }
                      $('#prog'+cl).text(percent+'%') 
                   }, false);
                 }
                 return xhr;
              },
              success: function (res, status) {
                  if (status == 'success') {
                      percent = 0;
                      $('#prog' + cl).text('');
                      $('#prog' + cl).text('--Success: ');
                      if (cl < ttl) {
                          uploadajax(ttl, cl + 1);
                      } else {
                          alert('Done');
                      }
                  }
              },
              fail: function (res) {
                  alert('Failed');
              }    
          })
    }

    $('#upcvr').click(function(){
        var fileList = $('#multiupload').prop("files");
        $('#uploadsts').html('');
        var i;
        for ( i = 0; i < fileList.length; i++) {
            $('#uploadsts').append('<p class="upload-page">'+fileList[i].name+'<span class="loading-prep" id="prog'+i+'"></span></p>');
            if(i == fileList.length-1){
                uploadajax(fileList.length-1,0);
            }
         }
    });
    </script>
-->
  

</body>
</html>
