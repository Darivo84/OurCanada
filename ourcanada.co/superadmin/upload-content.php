<?php
include_once("admin_inc.php");
if(($_SESSION[ 'role' ] == 'admin')||($_SESSION[ 'role' ] == 'moderator')){

}else{
    header("location:login.php");
}

$category_list = mysqli_query($conn,"SELECT * FROM category_blog");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php include_once("includes/style.php"); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .old_img{
            height: 150px;
            position: relative;
        }
        .old_img img,.old_img video,.old_img iframe{
            width: 100%;
            height: 100%;
            object-fit: fill;
            cursor: pointer;
        }
        .old_img input{
            position: absolute;
            top: 5px;
            left: 20px;
        }
        .bootstrap-tagsinput{
            width: 100% !important;
        }
        .bootstrap-tagsinput .tag {
          background: red;
          padding: 3px 10px;
          border-radius: 5px;
        }
        .bootstrap-tagsinput .tag [data-role="remove"]:after {
           content: " x";
           padding: 0px 2px;
        }
        .gallery-item{
            float: left;
            margin: 10px 0;
        }
        .gallery-item video,.gallery-item img{
            max-width: 100%;
            height: 200px;
            background: #000;
            position: relative;
        }
        .image .gallery-item i{
            position: absolute;
            width: 30px;
            text-align: center;
            line-height: 30px;
            background: rgba(0,0,0,.5);
            z-index: 111;
            cursor: pointer;
            color: transparent;
        }
        .image  .gallery-item i.active{
            color: #fff;
        }
        .video .gallery-item i{
            position: absolute;
            width: 30px;
            text-align: center;
            line-height: 30px;
            background: rgba(255,255,255,.5);
            z-index: 111;
            cursor: pointer;
            color: transparent;
        }
        .video  .gallery-item i.active{
            color: #fff;
        }
        .dz-error-message{
            display: none !important;
        }
        .dz-preview{
            background: transparent !important;
        }
        .old_img{
            margin-bottom: 15px;
        }
        .pdf-box {
            text-align: center;
            padding-top: 15px;
            background: #f7f7f7;
            padding-bottom: 15px;
            margin-top: 15px;
            margin-left: 15px;
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
            <div class="page-content" style="background: #e1e1e1;">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18">Create New Content</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Content</a></li>
                                        <li class="breadcrumb-item active">Add Content</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Create New Content</h4>
                                    <div>
                                        <div class="prompt"></div>
                                        <div class="row" style="padding: 0;">
                                            <div class="form-group row mb-4 col-lg-6">
                                                <div class="col-lg-9">
                                                <label for="title" class="col-form-label">Content</label>
                                                    <select class="form-control" id="content_type">
                                                        <option value="0">Blog</option>
                                                        <option value="1">News</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-4 col-lg-6">
                                                <div class="col-lg-9">
                                                    <label class="col-form-label">Content Type</label>
                                                    <select onchange="SetContentCategory($(this).val());" id="content_category" class="form-control">
                                                        <option value="0">Simple</option>
                                                        <option value="4">PDF Content</option>
                                                        <option value="1">Video</option>
                                                        <option value="2">Image Slider</option>
                                                        <option value="3">Video With Image Slider</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-4 col-lg-6">
                                                <div class="col-lg-9">
                                                    <label class="col-form-label">Select Language</label>
                                                    <select id="content_lang" class="form-control">
                                                        <option value="">English</option>
                                                        <option value="chinese">Chinese</option>
                                                        <option value="francais">Francais</option>
                                                        <option value="hindi">Hindi</option>
                                                        <option value="punjabi">punjabi</option>
                                                        <option value="spanish">Spanish</option>
                                                        <option value="urdu">Urdu</option>
                                                        <option value="arabic">Arabic</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-4 col-lg-6">
                                                <div class="col-lg-9">
                                                    <label class="col-form-label">Add translation of existing blogs.</label>
                                                    <select id="old_content" class="form-control">
                                                        <option value="">Select Content</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="title" class="col-form-label">Content Category</label>
                                                <select id="category" class="form-control" multiple="" name="category[]">
                                                    <?php 
                                                    while($category_row = mysqli_fetch_assoc($category_list)){
                                                    ?>
                                                    <option value="<?= $category_row['id'] ?>"><?= $category_row['title'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="title" class="col-form-label">Title</label>
                                                <input id="title" name="title" type="text" class="form-control" placeholder="Content Title...">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="description" class="col-form-label">Description</label>
                                                <textarea id="description" name="description" class="form-control" placeholder="Content description..."></textarea>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="quote" class="col-form-label">Block Quote</label>
                                                <textarea name="quote" id="quote" class="form-control" placeholder="Block Quote...">
                                                </textarea>
                                                <!-- <input type="text" id="quote" name="quote" class="form-control" placeholder="Block Quote..."> -->
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="content_one" class="col-form-label">Content One</label>
                                                <textarea id="content_one" name="content_one" class="form-control" placeholder="Content One..."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="content_two" class="col-form-label">Content Two</label>
                                                <textarea id="content_two" name="content_two" class="form-control" placeholder="Content Two..."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="content_three" class="col-form-label">Content Three</label>
                                                <textarea id="content_three" name="content_three" class="form-control" placeholder="Content Three..."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="content_four" class="col-form-label">Content Four</label>
                                                <textarea id="content_four" name="content_four" class="form-control" placeholder="Content Four..."></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4" id="video-content" style="display: none;">
                                            <div class="col-lg-12" style="text-align: center; margin-bottom: 10px;">
                                                <label style="width: 100%; text-align: left;" class="col-form-label">Video</label>
                                                <button class="btn btn-info" onclick="$('#video-gallery').modal();">Gallery Video</button>
                                                <button class="btn btn-success" onclick="SelectVideo($(this));"><i class="fa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i>Upload Video</button>
                                                <button class="btn btn-danger" style="display: none;" onclick="RemoveVideo();">Remove Video</button>
                                                <input type="file" hidden style="display: none;" accept="video/*">
                                                <video id="blogvideo" width="80%" height="400" style="display: none; background: #000; margin-top: 10px;" src="<?= $cms_url ?>uploads/videos/26102020181251Countdown1.mp4" controls></video>
                                            </div>
                                            <div class="col-lg-12" style="text-align: center; margin-bottom: 10px; margin-top: 10px;">
                                                <div class="row" style="padding: 0 15px;">
                                                    <input type="url" style="margin-bottom: 10px;" name="embed" class="form-control col-lg-10" placeholder="Add embed video link...">
                                                    <button onclick="EmbedVideo($(this));" class="btn btn-success btn-sm" style="height: 37px; margin-left: 10px; float: right;">Preview</button> 
                                                    <button onclick="EmbedVideo($(this));" class="btn btn-danger btn-sm" style="height: 37px; margin-left: 10px; float: right;">Remove</button> 
                                                    <span class="embedvideo-error text-danger"></span>
                                                </div>
                                                <iframe width="80%" height="400" src="" style="display: none; margin-top: 10px;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                            <div class="old-single-video-content w-100 text-left" style="display: none;">
                                                <label style="padding: 9px;">Select previously uploaded videos</label>
                                                <div class="row">
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div id="image-slider-content" style="display: none; text-align: center;">
                                            <label for="content_two" class="col-form-label" style="width: 100%; text-align: left;">Upload Images</label>
                                            <form class="modal-body dropzone" action="<?= $cms_url ?>ajax.php?h=DropzoneImageSlider" id="image-slider" style="background: rgba(0,0,0,.1); border: 0; max-height: 300px; overflow: auto; border-radius: 20px;">
                                            </form>
                                            <br>
                                            <button class="btn btn-info" onclick="$('#image-gallery').modal();">Gallery Images</button>
                                            <button class="btn btn-success" onclick="$('#image-slider-content .dropzone').click();">Upload Images</button>
                                            <div class="old-slider-content col-lg-12 text-left" style="display: none; padding-left: 0px;">
                                                <label style="padding: 9px;">Select previously uploaded images</label>
                                                <div class="row">
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div id="image-video-content" style="display: none; text-align: center;">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label for="content_two" class="col-form-label" style="width: 100%; text-align: left;">Upload Images</label>
                                                    <form class="modal-body dropzone" action="<?= $cms_url ?>ajax.php?h=DropzoneImageSlider" id="video-image-slider" style="background: rgba(0,0,0,.1); border: 0; max-height: 300px; overflow: auto; border-radius: 20px;">
                                                    </form>
                                                    <br>
                                                    <button class="btn btn-info" onclick="$('#content-image-gallery').modal();">Gallery Images</button>
                                                    <button class="btn btn-success" onclick="$('#image-video-content .dropzone').click();">Upload Images</button>
                                                </div>
                                                <div class="old-video-image-content col-lg-12 text-left" style="display: none;">
                                                    <label style="padding: 9px;">Select previously uploaded images</label>
                                                    <div class="row">
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-lg-12" style="text-align: center; padding: 10px 0;">
                                                    <label for="content_two" class="col-form-label" style="width: 100%; text-align: left; padding-left: 15px;">Upload Video</label>
                                                    <video style="display:none; width: 80%; height: 400px; background: #000;" src="<?= $cms_url ?>uploads/videos/26102020181251Countdown1.mp4" controls></video>
                                                    <br>
                                                    <input type="file" hidden accept="video/*">
                                                    <button class="btn btn-info" onclick="$('#video-gallery-content').modal();">Gallery Video</button>
                                                    <button class="btn btn-success" onclick="VideoContentUpload($(this));"><i class="faa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i>Upload Video</button>
                                                    <button class="btn btn-danger" onclick="RemoveVideoContentUpload($(this));" style="display: none;">Remove Video</button>
                                                </div>
                                            
                                                <div id="video-image" class="col-lg-12" style="text-align: center; margin-bottom: 10px; margin-top: 10px;">
                                                    <div class="row" style="padding: 0 15px;">
                                                        <input type="url" style="margin-bottom: 10px;" name="youtube_embed" class="form-control col-lg-10" placeholder="Add embed video link...">
                                                        <button onclick="EmbedVideoSecond($(this));" class="btn btn-success btn-sm" style="height: 37px; margin-left: 10px; float: right;">Preview</button> 
                                                        <button onclick="EmbedVideoSecond($(this));" class="btn btn-danger btn-sm" style="height: 37px; margin-left: 10px; float: right;">Remove</button> 
                                                        <span class="embedvideo-error text-danger"></span>
                                                    </div>
                                                    <iframe width="80%" height="400" src="" style="display: none; margin-top: 10px;" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>

                                                <div class="old-video-video-content w-100 text-left" style="display: none;">
                                                    <label style="padding: 9px;">Select previously uploaded videos</label>
                                                    <div class="row">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" name="pdf_file" id="pdf_file" onchange="if($(this)[0].files[0].type == 'application/pdf'){$('#pdfBTN').text($(this)[0].files[0].name)}else{$(this).val()='';} $(document).find('#load_old_pdf').find('input[type=radio]').prop('checked',false);" accept="application/pdf" style="display: none;">
                                        <button class="btn btn-success d-none" onclick="$('input[name=pdf_file]').click();" id="pdfBTN">Select PDF</button>
                                        <div class="row" id="load_old_pdf">
                                            
                                        </div>
                                        <br><br>
                                        <button class="btn btn-primary" id="thumbnail_btn" onclick="$('#thumbnail-image-gallery').modal();">Select Thumbnail</button>
                                        <br>
                                        <span class="thumbnail_error text-danger"></span>
                                        <br><br>

                                        <label class="col-form-label">Tags</label>
                                        <input type="text" id="blog_tages" class="form-control" data-role="tagsinput" placeholder="tag1,tag2,tag3...">
                                        <span class="text-danger tag_error"></span>
                                        <br><br><button type="button" onclick="CreateContent($(this));" class="btn btn-success"><i style="display: none; margin-right: 5px;" class="fa fa-spin fa-spinner"></i> Create Content</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>   
                </div> <!-- container-fluid -->
            </div>
        </div>
    </div>

    <div class="modal image" id="thumbnail-image-gallery" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Thumbnail</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow: auto;">
            <?php 
            $img_dir = $cms_url.'uploads/gallery/';
            $imgs = array();
        
            $g = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
            while ($r = mysqli_fetch_assoc($g)) {
                $imgs[] = $r['image'];
            }
            ?>
            <?php for ($i=0; $i < count($imgs); $i++) { ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check"></i>
                <img file-path="uploads/gallery/<?= $imgs[$i] ?>" img-name="<?= $imgs[$i] ?>" src="<?= $img_dir.$imgs[$i] ?>">
            </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal video" id="video-gallery" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Gallery Videos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow: auto;">
            <?php 
            $video_dir = '../community/uploads/gallery/';
            $video_array = scandir($video_dir);
            $videos = array();
            $video_ext = array('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi');
            foreach ($video_array as $path) {
              if (in_array(pathinfo($path,  PATHINFO_EXTENSION), $video_ext)) {
                $videos[] = $path;
              }
            }
            ?>
            <?php for ($i=0; $i < count($videos); $i++) { ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check"></i>
                <video file-path="uploads/gallery/<?= $videos[$i] ?>" src="<?= $video_dir.$videos[$i] ?>" controls></video>
            </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal image" id="image-gallery" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Gallery Images</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow: auto;">
            <?php 
            $img_dir = $cms_url.'uploads/gallery/';
            // $img_array = scandir($img_dir);
            $imgs = array();
            // $img_ext = array('jpg', 'png', 'PNG', 'JPG', 'jpeg', 'gif', 'jpe', 'bmp', 'ico', 'svg', 'svgz', 'tif', 'tiff', 'ai', 'drw', 'pct', 'psp', 'xcf', 'psd', 'raw', 'webp');
            // foreach ($img_array as $path) {
            //   if (in_array(pathinfo($path,  PATHINFO_EXTENSION), $img_ext)) {
            //     $imgs[] = $path;
            //   }
            // }
            $g = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
            while ($r = mysqli_fetch_assoc($g)) {
                $imgs[] = $r['image'];
            }
            ?>
            <?php for ($i=0; $i < count($imgs); $i++) { ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check"></i>
                <img file-path="uploads/gallery/<?= $imgs[$i] ?>" src="<?= $img_dir.$imgs[$i] ?>">
            </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal image" id="content-image-gallery" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Gallery Videos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow: auto;">
            <?php 
            $img_dir = $cms_url.'uploads/gallery/';
            // $img_array = scandir($img_dir);
            $imgs = array();
            // $img_ext = array('jpg', 'png', 'PNG', 'JPG', 'jpeg', 'gif', 'jpe', 'bmp', 'ico', 'svg', 'svgz', 'tif', 'tiff', 'ai', 'drw', 'pct', 'psp', 'xcf', 'psd', 'raw', 'webp');
            // foreach ($img_array as $path) {
            //   if (in_array(pathinfo($path,  PATHINFO_EXTENSION), $img_ext)) {
            //     $imgs[] = $path;
            //   }
            // }
            $g = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
        while ($r = mysqli_fetch_assoc($g)) {
            $imgs[] = $r['image'];
        }
            ?>
            <?php for ($i=0; $i < count($imgs); $i++) { ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check"></i>
                <img file-path="uploads/gallery/<?= $imgs[$i] ?>" src="<?= $img_dir.$imgs[$i] ?>">
            </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal video" id="video-gallery-content" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Gallery Videos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow: auto;">
            <?php 
            $video_dir = '../community/uploads/gallery/';
            $video_array = scandir($video_dir);
            $videos = array();
            $video_ext = array('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi');
            foreach ($video_array as $path) {
              if (in_array(pathinfo($path,  PATHINFO_EXTENSION), $video_ext)) {
                $videos[] = $path;
              }
            }
            ?>
            <?php for ($i=0; $i < count($videos); $i++) { ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check"></i>
                <video file-path="uploads/gallery/<?= $videos[$i] ?>" src="<?= $video_dir.$videos[$i] ?>" controls></video>
            </div>
            <?php } ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <template id="image-item">
        <div class="old_img col-lg-2">
            <input type="checkbox">
            <img onclick="$(this).siblings('input').prop('checked',!$(this).siblings('input').prop('checked'))" src="">
        </div>
    </template>

    <template id="video-item">
        <div class="old_img col-lg-3">
            <input type="radio" name="old_video">
            <video controls src="" onclick="$(this).siblings('input').prop('checked',!$(this).siblings('input').prop('checked'))"></video>
        </div>
    </template>

    <template id="embed-item">
        <div class="old_img col-lg-2">
            <input type="radio" name="old_embed">
            <iframe src="" onclick="$(this).siblings('input').prop('checked',!$(this).siblings('input').prop('checked'))"></iframe>
        </div>
    </template>

    <canvas id="thecanvas" style="display: none;">
    </canvas>
    <!-- End Page-content -->
    <?php include_once("includes/script.php"); ?>
    <script src="assets/libs/dropzone/min/dropzone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

    <script type="text/javascript">

    function select_old_pdf(){
        $("#pdf_file").val("");
        $("#pdfBTN").text("Select PDF");
    }

    $("#thumbnail-image-gallery .gallery-item i").click(function(){
        $("#thumbnail-image-gallery .gallery-item i").removeClass("active");
        $(this).toggleClass('active');
    });    

    var content_one = CKEDITOR.replace( 'content_one' );
    var content_two = CKEDITOR.replace( 'content_two' );
    var content_three = CKEDITOR.replace( 'content_three' );
    var content_four = CKEDITOR.replace( 'content_four' );
    var quote = CKEDITOR.replace( 'quote' );



    var VideoThumbnail = null;

    function draw( video, thecanvas ){
          var context = thecanvas.getContext('2d');
          context.drawImage( video, 0, 0, thecanvas.width, thecanvas.height);
          var dataURL = thecanvas.toDataURL();
          var ImageURL = dataURL;
          // Split the base64 string in data and contentType
          var block = ImageURL.split(";");
          // Get the content type
          var contentType = block[0].split(":")[1];// In this case "image/gif"
          // get the real base64 content of the file
          var realData = block[1].split(",")[1];// In this case "iVBORw0KGg...."
          // Convert to blob
          VideoThumbnail = b64toBlob(realData, contentType);

    }

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

            var blob = new Blob(byteArrays, {type: contentType});
            return blob;
    }

    function getThumbnail(){
        var video = document.getElementById('blogvideo');
        video.currentTime = 1;
        var thecanvas = document.getElementById('thecanvas');
        video.preload = 'metadata';
        video.muted = true;
        video.playsInline = true;
        video.play();
        setTimeout(function(){
            video.pause();
        },500);
        video.addEventListener('pause', function(){
            draw( video, thecanvas);
        }, false);
    }
    $("#content_category").change();
    $("#category,#old_content,#content_type,#content_category,#content_lang").select2();
    var c_type = '';
    function SetContentCategory(val){
        if(val == 0 || val == 4){
            c_type = 'simple';
            $("#thumbnail_btn").show();
            if(val == 4){
                c_type = 'pdf-content';
                $("#pdfBTN").removeClass("d-none");
            }else{
                $("#pdfBTN").addClass("d-none");
            }
            $("#video-content,#image-slider-content,#image-video-content").hide();
        }else{
            $(".thumbnail_error").hide();
            $("#thumbnail_btn").hide();
            $("#pdfBTN").addClass("d-none");
        }

        if(val == 1){
            c_type = 'video-';
            $("#image-slider-content,#image-video-content").hide();
            $("#video-content").show();
        }
        if(val == 2){
            c_type = 'image-slider-';
            $("#video-content,#image-video-content").hide();
            $("#image-slider-content").show();
        }
        if(val == 3){
            c_type = 'video-image-';
            $("#video-content,#image-slider-content").hide();
            $("#image-video-content").show();
        }
        updateTitleDropdown($("#content_type").val(),c_type);
    }

    $("#content_type").change(function(){
        updateTitleDropdown($(this).val(),c_type);
    });

    function updateTitleDropdown(content,type){
        if(type == "pdf-content"){
            type = 'pdf-';
        }
        $.ajax({
            type: "POST",
            url: "ajax.php?h=getContentTitleList",
            dataType: "JSON",
            data: {
                type: type,
                content: content
            },success: function(res){
                $("#old_content").html('<option value="">Select Content</option>');
                for (var i = 0; i < res.length; i++) {
                    $("#old_content").append('<option value="'+res[i].slug+'" data-id="'+res[i].id+'" data-t="'+res[i].content_data+'">'+res[i].title+'</option>');
                }
                $("#old_content").select2();
            }
        });
    }

    $("#old_content").change(function(){
        if($(this).val() != ""){
            var t = $(this).find(':selected').attr('data-t');
            var id = $(this).find(':selected').attr('data-id');
            $.ajax({
                type: "POST",
                url: "ajax.php?h=getContentData",
                data: {
                    content: $("#content_type").val(),
                    type: c_type,
                    slug: $(this).val(),
                    table: t,
                    data_id: id
                },
                dataType: "JSON",
                success: function(res){
                    $(".old-single-video-content .old_img").remove();
                    var img_len = Object.keys(res.images).length;
                    var div_class = '';
                    var vid_div = '';
                    var single_vid_div = '';
                    if(c_type == 'video-image-'){
                        div_class = 'old-video-image-content';
                        vid_div = 'old-video-video-content';
                    }
                    if(c_type == 'image-slider-'){
                        div_class = 'old-slider-content';
                    }
                    if(c_type == 'video-'){
                        single_vid_div = 'old-single-video-content';
                    }

                    if(div_class != ""){
                        $("."+div_class).show();
                        $("."+div_class+" .row div").remove();
                        if(img_len > 0){
                            for (var i = 0; i < img_len; i++) {
                                var p = "<?= $cms_url ?>"+res.images[i];
                                $("."+div_class+" .row")
                                .append($("#image-item").html());
                                $("."+div_class+" .row img:last").attr("src",p);
                            }
                        }

                        if(res.video.length > 0){
                            $("."+vid_div+" .row div").remove();
                            for (var i = 0; i < res.video.length; i++) {
                                var p = "<?= $cms_url ?>"+res.video[i];
                                $("."+vid_div).show();
                                $("."+vid_div+" .row")
                                .append($("#video-item").html());
                                $("."+vid_div+" .row video:last").attr("src",p);
                            }
                        }
                    }

                    if((c_type != 'video-' || c_type != 'video-image-slider-') && single_vid_div != ""){
                        $("."+single_vid_div+" .row div").remove();
                        if(res.video.length > 0){
                            for (var i = 0; i < res.video.length; i++) {
                                if(res.video[i] != ""){
                                    var p = "<?= $cms_url ?>"+res.video[i];
                                    $("."+single_vid_div).show();
                                    $("."+single_vid_div+" .row")
                                    .append($("#video-item").html());
                                    $("."+single_vid_div+" .row video:last").attr("src",p);
                                }
                            }
                            
                        }

                        if(c_type != 'video-' && res.embed.length > 0){
                            for (var i = 0; i < res.embed.length; i++) {
                                var p = res.embed[i];
                                $("."+single_vid_div).show();
                                $("."+single_vid_div+" .row")
                                .append($("#embed-item").html());
                                $("."+single_vid_div+" .row iframe:last").attr("src",p);
                            }
                        }
                    }

                    if(c_type == 'pdf-content'){
                        $("#load_old_pdf").html("");
                        for(var i = 0; i < res.pdf.length; i++){
                            $(document).find("#load_old_pdf").append(
                                '<div class="col-lg-2 pdf-box">'+
                                    '<i class="fa fa-file fa-5x"></i> <br><br>'+
                                    '<a href="<?= $cms_url ?>uploads/pdf_files/'+res.pdf[i]+'" target="_blank">Preview PDF</a> <br>'+
                                    '<input type="radio" onchange="select_old_pdf();" value="'+res.pdf[i]+'" name="old_pdf">'+    
                                '</div>');                        
                        }
                    }else{
                        $("#load_old_pdf").html("");
                    }
                }
            });
        }else{

        }
    });

    // For Video Blog/News
    var video = null;
    var gallery = "";
    var embed = "";

    function SelectVideo(sel){
        $("#video-content input[type=file]").click();
        $("#video-content input[type=file]").change(function(){
            var input = this;
            if (input.files && input.files[0]) {
                if(input.files[0].size > 100000000){
                    $(".prompt").attr("class","prompt alert alert-danger");
                    $(".prompt").text("Video size can not be grater then 100 MB.");
                    $(".prompt").show();
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }else{
                    sel.children("i").show();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#video-content #blogvideo").attr("src",e.target.result);
                        sel.children("i").hide();
                        getThumbnail();
                    }
                    $("#video-content #blogvideo").show();
                    reader.readAsDataURL(input.files[0]);
                    video = input;
                    $("#video-gallery i").removeClass("active");
                    gallery = "";
                    $("#video-content .btn-danger").show();
                    
                }
            }
        });
    }

    function RemoveVideo(){
        video = null;
        gallery = "";
        $("#video-gallery i").removeClass("active");
        $("#video-content input[type=file]").val("");
        $("#video-content video").attr("src","");
        $("#video-content video").hide();
        $("#video-content .btn-danger").hide();
    }

    function EmbedVideo(sel){
        if(sel.hasClass("btn-success") && $("#video-content input[type=url]").val() != ""){
            var videoURL = $("#video-content input[type=url]").val();
            
            var urlParts = videoURL.split("/");
            if(urlParts[0] == "https:" && urlParts[2] == "www.youtube.com" && urlParts[3] == "embed"){
                $("#video-content iframe").attr("src",$("#video-content input[type=url]").val());
                $("#video-content iframe").show();
                embed = $("#video-content input[type=url]").val();
                $(".embedvideo-error").text("");
            }else{
                $(".embedvideo-error").text("Invalid youtube video.");
            }
        }
        if(sel.hasClass("btn-danger")){
            $("#video-content iframe").hide();
            embed = "";
            $("#video-content input[type=url]").val("");
        }
    }

    function EmbedVideoSecond(sel){
        if(sel.hasClass("btn-success") && $("input[name=youtube_embed]").val() != ""){
            var videoURL = $("input[name=youtube_embed]").val();
            
            var urlParts = videoURL.split("/");
            if(urlParts[0] == "https:" && urlParts[2] == "www.youtube.com" && urlParts[3] == "embed"){
                $("#video-image iframe").attr("src",$("input[name=youtube_embed]").val());
                $("#video-image iframe").show();
                $("input[name=youtube_embed]").siblings('.embedvideo-error').text("");
            }else{
                $("input[name=youtube_embed]").siblings('.embedvideo-error').text("Invalid youtube video.");
            }
        }
        if(sel.hasClass("btn-danger")){
            $("#video-image iframe").hide();
            $("input[name=youtube_embed]").val("");
        }
    }

    $("#video-gallery i").click(function(){
        $(this).toggleClass("active");
        $("#video-gallery i").not($(this)).removeClass("active");
    });

    $("#video-gallery .btn-primary").click(function(){
        if($("#video-gallery .active").length == 1){
            $("#video-content .btn-danger").show();
            gallery = $("#video-gallery .active").siblings("video").attr("file-path");
            $("#video-content #blogvideo").attr("src",$("#video-gallery .active").siblings("video").attr("src"));
            $("#video-content #blogvideo").show();
            $("#video-content input[name=file]").val("");
            video = null;
            $("#video-gallery .close").click();
            getThumbnail();
        }else{
            gallery = "";
            $("#video-gallery .close").click();
        }
    });

    // For Image Slider Blog/News
    var slider_images = [];
    var upload_slider = null;

    $("#image-slider").dropzone({ 
        addRemoveLinks: true,
        acceptedFiles:'image/*',
        uploadMultiple: true,
        init: function(){
            var myDropzone = this;

            this.on('addedfile', function (file, xhr, formData) {
                upload_slider = myDropzone;
            });

            this.on('removedfile', function (file, xhr, formData){
                upload_slider = myDropzone;
                
            });

        }
    });

    $("#image-gallery i").click(function(){
        $(this).toggleClass("active");
    });

    $("#image-gallery .btn-primary").click(function(){
        slider_images = [];
        $("#image-gallery .active").each(function(){
            slider_images.push($(this).siblings("img").attr("file-path"));
        });
        $("#image-gallery .close").click();
    });

    // Video Image Content
    var upload_video = null;
    var upload_gallery = "";

    function VideoContentUpload(sel){
        $("#image-video-content input[type=file]").click();
        $("#image-video-content input[type=file]").change(function(){
            var input = this;
            if (input.files && input.files[0]) {
                if(input.files[0].size > 100000000){
                    $(".prompt").attr("class","prompt alert alert-danger");
                    $(".prompt").text("Video size can not be grater then 100 MB.");
                    $(".prompt").show();
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }else{
                    sel.children("i").show();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#image-video-content video").attr("src",e.target.result);
                        sel.children("i").hide();
                    }
                    $("#image-video-content video").show();
                    reader.readAsDataURL(input.files[0]);
                    upload_video = input;
                    $("#video-gallery-content i").removeClass("active");
                    upload_gallery = "";
                    $("#image-video-content .btn-danger").show();
                }
            }
        });
    }

    function RemoveVideoContentUpload(sel){
        $("#image-video-content video").attr("src","");
        $("#image-video-content video").hide();
        upload_gallery = "";
        upload_video = null;
        sel.hide();
    }

    $("#video-gallery-content i").click(function(){
        $(this).toggleClass("active");
        $("#video-gallery-content i").not($(this)).removeClass("active");
    });

    $("#video-gallery-content .btn-primary").click(function(){
        if($("#video-gallery-content .active").length == 1){
            $("#image-video-content .btn-danger").show();
            upload_gallery = $("#video-gallery-content .active").siblings("video").attr("file-path");
            $("#image-video-content video").attr("src",$("#video-gallery-content .active").siblings("video").attr("src"));
            $("#image-video-content video").show();
            $("#image-video-content input[name=file]").val("");
            upload_video = null;
            $("#video-gallery-content .close").click();
        }else{
            upload_gallery = "";
            $("#video-gallery-content .close").click();
        }
    });

    var content_images = [];
    var upload_images = null;

    $("#video-image-slider").dropzone({ 
        addRemoveLinks: true,
        acceptedFiles:'image/*',
        uploadMultiple: true,
        init: function(){
            var myDropzone = this;

            this.on('addedfile', function (file, xhr, formData) {
                upload_images = myDropzone;
            });

            this.on('removedfile', function (file, xhr, formData){
                upload_images = myDropzone;
                
            });
        }
    });

    $("#content-image-gallery i").click(function(){
        $(this).toggleClass("active");
    });

    $("#content-image-gallery .btn-primary").click(function(){
        content_images = [];
        $("#content-image-gallery .active").each(function(){
            content_images.push($(this).siblings("img").attr("file-path"));
        });
        $("#content-image-gallery .close").click();
    });

    function CreateContent(sel){

        $("#video-content input[type=url]").siblings(".btn-success").click();
        // Set Table
        var type = 'blog_content';
        if($("#content_type").val() == 0){
            type = "blog_content";
        }else{
            type = "news_content";
        }
        // $("#description").val(tinyMCE.get('description').getContent());
        $("#content_one").val(CKEDITOR.instances.content_one.getData());
        $("#content_two").val(CKEDITOR.instances.content_two.getData());
        $("#content_three").val(CKEDITOR.instances.content_three.getData());
        $("#content_four").val(CKEDITOR.instances.content_four.getData());

        var content_type = "";
        if($("#content_category").val() == 0){
            content_type = "simple"+type.split("_")[0];
        }else if($("#content_category").val() == 1){
            content_type = "video-"+type.split("_")[0];
        }else if($("#content_category").val() == 2){
            content_type = "image-slider-"+type.split("_")[0];
        }else if($("#content_category").val() == 3){
            content_type = "video-image-"+type.split("_")[0];
        }else if($("#content_category").val() == 4){
            content_type = "pdf-"+type.split("_")[0];
        }

        if(Validate()){
            // Create Slug
            var link = $("#title").val();
            var slug = '';
            if($("#content_lang").val() == ''){
                link = link.toLowerCase();
                link = link.replace(/[^a-zA-Z0-9\s+]/g, '');
                slug = link.replace(/\s+/g, '-');
            }else{
                slug = link.replace(/\s+/g, '-');
                slug = slug.replace('?', '');
            }
            
            var form = new FormData();
            
            form.append('table',type);
            form.append('type',content_type);
            form.append('title',$("#title").val());
            form.append('slug',slug);
            form.append('description',$("#description").val());
            form.append('content_one',$("#content_one").val());
            form.append('content_two',$("#content_two").val());
            form.append('content_three',$("#content_three").val());
            form.append('content_four',$("#content_four").val());
            form.append('quote',CKEDITOR.instances.quote.getData());
            form.append('category',$("#category").val().join(","));
            form.append('tages',$("#blog_tages").val());
            form.append('created_by',1);
            form.append('status',1);

            if(typeof $("#thumbnail-image-gallery .active").siblings("img").attr("img-name") === "undefined"){

            }else{
                form.append('content_thumbnail',$("#thumbnail-image-gallery .active").siblings("img").attr("img-name"));
            }

            if($("#content_category").val() == 1){
                if(video != null){
                    form.append("single_video",video.files[0]);
                }else{
                    form.append('video',gallery);
                }
                if(embed != ""){
                    form.append("embed",embed);
                }
                if(video != null || gallery != ""){
                    if(VideoThumbnail.size < 500){
                        getThumbnail();
                    }
                    form.append("thumbnail",VideoThumbnail);
                }
            }else if($("#content_category").val() == 2){
                if(slider_images.length > 0){
                    form.append('slider_images',slider_images.join(","));
                }
                if(upload_slider != null){
                    for (var i = 0; i < upload_slider.files.length; i++) {
                        form.append('multi_images[]',upload_slider.files[i]);
                    }
                }
            }else if($("#content_category").val() == 3){
                if(content_images.length > 0){
                    form.append('slider_images',content_images.join(","));
                }
                if(upload_images != null && upload_images.files.length > 0){
                    for (var i = 0; i < upload_images.files.length; i++) {
                        form.append('multi_images[]',upload_images.files[i]);
                    }
                }
                if(upload_video != null){
                    form.append('single_video',upload_video.files[0]);
                }

                if(upload_gallery.length > 0){
                    form.append('video',upload_gallery);
                }
            }

            if($("input[name=youtube_embed]").val() != ""){
                form.append("youtube_embed",$("input[name=youtube_embed]").val());
            }

            form.append('lang',$("#content_lang").val());
            form.append('selected_slug',$("#old_content").val());
            // form simple image slider
            $(".old-slider-content input[type=checkbox]:checked").each(function(){
            	form.append('old_slider_images[]',$(this).siblings("img").attr("src").replace("<?php echo $currentTheme ?>community/",""));
            });
            // form video with image slider
            $(".old-video-image-content input[type=checkbox]:checked").each(function(){
            	form.append('old_vid_slider_images[]',$(this).siblings("img").attr("src").replace("<?php echo $currentTheme ?>community/",""));
            });

            if(typeof $(".old-video-video-content input[name=old_video]:checked").siblings("video").attr("src") === "undefined"){
                
            }else{
                form.append('old_video',$(".old-video-video-content input[name=old_video]:checked").siblings("video").attr("src").replace("<?php echo $currentTheme ?>community/",""));
            }

            // for single video
            if(typeof $(".old-single-video-content input[name=old_video]:checked").siblings("video").attr("src") === "undefined"){
                
            }else{
                form.append('old_single_video',$(".old-single-video-content input[name=old_video]:checked").siblings("video").attr("src").replace("<?php echo $currentTheme ?>community/",""));
            }
            if(typeof $(".old-single-video-content input[name=old_embed]:checked").siblings("iframe").attr("src") === "undefined"){
                
            }else{
                form.append('old_single_embed',$(".old-single-video-content input[name=old_embed]:checked").siblings("iframe").attr("src").replace("<?php echo $currentTheme ?>community/",""));
            }
            

            let oldPDF = $(document).find("#load_old_pdf").find("input[type=radio]:checked").val();
            
            if((c_type == 'pdf-content' || c_type == 'pdf-')){
                if(typeof oldPDF !== 'undefined'){
                    form.append("old_pdf",oldPDF);
                }else if($("#pdf_file").val() != ""){
                    form.append("pdf_file",$("#pdf_file")[0].files[0]);
                }
            }

            $.ajax({
                type: "POST",
                url: "ajax.php?h=addContent",
                data: form,
                dataType: 'json',
                enctype: 'multipart/form-data',
                dataType: "json",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    sel.children("i").show();
                },
                success: function(res){
                    sel.children("i").hide();
                    console.log(res);
                    if(res.error){
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        $(".prompt").attr("class","prompt alert alert-danger");
                        $(".prompt").text(res.error);
                    }else{
                        $(".prompt").attr("class","prompt alert alert-success");
                        $(".prompt").text("Content upload successfully."); 
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        setTimeout(function(){
                            window.open('<?= $super_admin ?>admin-'+type.split("_")[0]+'-listing','_SELF');
                        },5000);
                    }
                },
                error: function(e){
                    sel.children("i").hide();
                    console.log(e)
                }
            });
        }
    }

    function Validate(){
        var check = true;
        
        $(".prompt").attr("class","prompt");
        $(".prompt").text("");
        
        $("#category").change(function(){
            if($(this).val() != ""){
                $(this).siblings(".text-danger").text("");
            }
        });

        $("#title,#description").on("keyup",function(){
            if($(this).val() != ""){
                $(this).siblings(".text-danger").text("");
            }
        });

        if($("#thumbnail-image-gallery .active").length < 1 && ($("#content_category").val() == 0 || $("#content_category").val() == 4)){
            $(".thumbnail_error").text("Please select thumbnail.");
            $(".thumbnail_error").show();
            check = false;
        }else{
            $(".thumbnail_error").text("");
        }

        if($("#category").val() == ""){
            $("#category").siblings(".text-danger").text("Category is required.");
            $('html, body').animate({
                scrollTop: 0
            }, 500);
            check = false;
        }else{
            $("#category").siblings(".text-danger").text("");
        }

        if($("#title").val() == ""){
            $("#title").siblings(".text-danger").text("Title is required.");
            $('html, body').animate({
                scrollTop: 0
            }, 500);
            check = false;
        }else{
            $("#title").siblings(".text-danger").text("");
        }

        if($("#description").val() == ""){
            $("#description").siblings(".text-danger").text("Description is required.");
            $('html, body').animate({
                scrollTop: 0
            }, 500);
            check = false;
        }else{
            $("#description").siblings(".text-danger").text("");
        }

        if(c_type == 'pdf-content' || c_type == 'pdf-'){
            
            let oldPDF = $(document).find("#load_old_pdf").find("input[type=radio]:checked").val();
            if($("#pdf_file").val() == "" && (typeof oldPDF === 'undefined' || oldPDF === 'undefined')){
                $(".prompt").attr("class","prompt alert alert-danger");
                $(".prompt").text("Please select pdf file.");
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                check = false;
            }else if($("#pdf_file").val() != "" && $("#pdf_file")[0].files[0].type != 'application/pdf'){
                $(".prompt").attr("class","prompt alert alert-danger");
                $(".prompt").text("Please select pdf file.");
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                check = false;
            }
        }

        if(check){
            if($("#content_one").val() == "" && $("#content_two").val() == "" && $("#content_three").val() == "" && $("#content_four").val() == ""){
                $(".prompt").attr("class","prompt alert alert-danger");
                $(".prompt").text("Please fill at least one content.");
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                check = false;
            }else{
                if($("#content_category").val() == 1 && (video == null || video.files.length < 1) && embed == "" && gallery == ""){
                    if($(".old-single-video-content input[name=old_video]:checked").length < 1 && $(".old-single-video-content input[name=old_embed]:checked").length < 1){
                    	$(".prompt").attr("class","prompt alert alert-danger");
	                    $(".prompt").text("Please add or uploads video.");
	                    $('html, body').animate({
	                        scrollTop: 0
	                    }, 500);
	                    check = false;
                    }
                }

                if($("#content_category").val() == 2){
                    if(slider_images.length < 1 && (upload_slider == null || upload_slider.files.length <1)){
                        if($(".old-slider-content input[type=checkbox]:checked").length < 1){
                        	$(".prompt").attr("class","prompt alert alert-danger");
	                        $(".prompt").text("Please add or uploads at least one image.");
	                        $('html, body').animate({
	                            scrollTop: 0
	                        }, 500);
	                        check = false;
                        }
                    }
                }

                if($("#content_category").val() == 3){
                    if(upload_gallery == "" && (upload_video == null || upload_video.files.length < 1) && $("input[name=youtube_embed]").val() == ""){
                        if($(".old-video-video-content input[name=old_video]:checked").length < 1){
                        	$(".prompt").attr("class","prompt alert alert-danger");
	                        $(".prompt").text("Please add video.");
	                        $('html, body').animate({
	                            scrollTop: 0
	                        }, 500);
	                        check = false;
                        }
                    }
                    else if(content_images.length < 1 && (upload_images == null || upload_images.files.length < 1)){
                        if($(".old-single-video-content input[type=checkbox]:checked").length < 1){
                        	$(".prompt").attr("class","prompt alert alert-danger");
	                        $(".prompt").text("Please add or uploads al least one image.");
	                        $('html, body').animate({
	                            scrollTop: 0
	                        }, 500);
	                        check = false;
                        }
                    }
                }

            }
        }

        if($("#blog_tages").val() == ""){
            $(".tag_error").text("Tags are required.");
            check = false;
        }else{
            $(".tag_error").text("");
        }
        
        return check;
    }
</script>
</body>
</html>
