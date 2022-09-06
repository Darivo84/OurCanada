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
              <h4 class="mb-0 font-size-18">Create New FAQ</h4>
             
            </div>
          </div>
        </div>
        <!-- end page title -->
        <div class="row">
          <div class="col-lg-4 mx-auto">
            <div class="prompt"></div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title mb-4">Create New FAQ</h4>
                <form method="POST" id="addFaq" >
					
                  <div class="form-group row mb-4">
                    <label for="Categoryname" class="col-form-label col-lg-2">FAQ Title</label>
                    <div class="col-lg-10">
                      <input id="title" name="title" type="text" class="form-control" placeholder="Enter FAQ Title..." required>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label for="Categorydesc" class="col-form-label col-lg-2">FAQ Description</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter FAQ Description..." required></textarea>
                    </div>
                  </div>
				
                  <div class="row justify-content-end">
                    <div class="col-lg-10">
                      <button type="submit" id="addLoader" class="btn btn-primary">Create FAQ</button>
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
	 $( '#addFaq' ).validate( {
        submitHandler: function () {
			
            'use strict';
			 $( "#addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> Processing' );
            $("#addLoader").prop('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=addFaq",
                type: 'POST',
                data: $("#addFaq").serialize(),
                success: function ( data ) {
                    $( "#addLoader" ).html('Create Faq')
                    $("#addLoader").prop('disabled',false)

                    if ( data.Success == 'true' ) 
					{
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
						setTimeout(function() {window.location = "faq.php";}, 300);
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
