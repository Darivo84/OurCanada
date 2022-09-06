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
              <h4 class="mb-0 font-size-18">Create New</h4>
              <div class="page-title-right">
                <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="javascript: void(0);">News</a></li>
                  <li class="breadcrumb-item active">Create New</li>
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
                <h4 class="card-title mb-4">Create New News</h4>
                <form method="POST" id="addnews" >
					 <div class="prompt"></div>
                  <div class="form-group row mb-4">
                    <label for="Categoryname" class="col-form-label col-lg-2">News</label>
                    <div class="col-lg-10">
                      <input id="ntitle" name="title" type="text" class="form-control" placeholder="Enter News Title..." required>
                    </div>
                  </div>
                  <div class="form-group row mb-4">
                    <label for="Categorydesc" class="col-form-label col-lg-2">News Description</label>
                    <div class="col-lg-10">
                      <textarea class="form-control" id="ndescription" name="description" rows="3" placeholder="Enter News Description..." required></textarea>
                    </div>
                  </div>
                  <div class="form-group row mb-4"  style="display:none" >
                    <label for="Categoryname" class="col-form-label col-lg-2">ckeditor</label>
                    <div class="col-lg-10">
                      <input id="neditor" name="" type="text" class="form-control" placeholder="..">
                    </div>
                  </div>
					
                  <div class="row justify-content-end">
                    <div class="col-lg-10">
                      <button id="addLoader" type="submit" class="btn btn-primary">Create News</button>
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
	 $( '#addnews' ).validate( {
        submitHandler: function () {
			 $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            'use strict';
            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=addnew",
                type: 'POST',
                data: $("#addnews").serialize(),
                success: function ( data ) {
                    if ( data.Success == 'true' ) 
					{
                       $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
						setTimeout(function() {window.location = "news.php";}, 500);
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
	
	<script>
$(document).ready(function() {
	$("#name").change(function(){
	  var link=$("#name").val();
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
