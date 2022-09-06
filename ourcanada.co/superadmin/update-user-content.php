<?php
include_once("admin_inc.php");
if(($_SESSION[ 'role' ] == 'admin') || ($_SESSION[ 'role' ] == 'moderator')){

}else{
    header("location:login.php");
}

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $server_req = "https";
} else{
    $server_req = "http";
}

$content_id = 0;
if(isset($_GET['id']) && $_GET['id'] > 0){
    $content_id = $_GET['id'];
}else{
    echo '<script>window.open("'.$super_admin.'","_SELF")</script>';
}

if(isset($_GET['type']) && in_array($_GET['type'], ["news","blog"])){

}else{
    echo '<script>window.open("'.$super_admin.'","_SELF")</script>';
}

$lang = '';
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $lang = '_'.$_GET['lang'];
}
$getContent = mysqli_query($conn,"SELECT * FROM ".$_GET['type']."_content".$lang." WHERE id = ".$_GET['id']." && created_by = 0");
if(mysqli_num_rows($getContent) < 1){
    echo '<script>window.open("'.$super_admin.'","_SELF")</script>';
}

$contentRow = mysqli_fetch_assoc($getContent);
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
    <canvas id="thecanvas" style="display: none; position: fixed; top: 10px; left: 50%; z-index: 1111111111;">
    </canvas>
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
                                <h4 class="mb-0 font-size-18">Update Content</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin Content</a></li>
                                        <li class="breadcrumb-item active">Update Form</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Update Content</h4>
                                    <div>
                                        <div class="prompt"></div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="title" class="col-form-label">Content Category</label>
                                                <select id="category" class="form-control" multiple="" name="category[]">
                                                    <?php 
                                                    while($category_row = mysqli_fetch_assoc($category_list)){
                                                    $sel_cate = explode(',', $contentRow['category']);
                                                    ?>
                                                    <option value="<?= $category_row['id'] ?>" <?php if(in_array($category_row['id'], $sel_cate)){echo "selected";} ?>><?= $category_row['title'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="title" class="col-form-label">Title</label>
                                                <input id="title" name="title" type="text" value="<?= $contentRow['title'] ?>" class="form-control" placeholder="Content Title...">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <div class="col-lg-12">
                                                <label for="description" class="col-form-label">Description</label>
                                                <textarea id="description" name="description" class="form-control" placeholder="Content description..."><?= $contentRow['description'] ?></textarea>
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4 editor">
                                            <div class="col-lg-12">
                                                <label for="quote" class="col-form-label">Block Quote</label>
                                                <textarea type="text" id="quote" name="quote" class="form-control" placeholder="Block Quote..."><?= $contentRow['quote'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4 editor">
                                            <div class="col-lg-12">
                                                <label for="content_one" class="col-form-label">Content One</label>
                                                <textarea id="content_one" name="content_one" class="form-control" placeholder="Content One..."><?= $contentRow['content_one'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4 editor">
                                            <div class="col-lg-12">
                                                <label for="content_two" class="col-form-label">Content Two</label>
                                                <textarea id="content_two" name="content_two" class="form-control" placeholder="Content Two..."><?= $contentRow['content_two'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4 editor">
                                            <div class="col-lg-12">
                                                <label for="content_three" class="col-form-label">Content Three</label>
                                                <textarea id="content_three" name="content_three" class="form-control" placeholder="Content Three..."><?= $contentRow['content_three'] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4 editor">
                                            <div class="col-lg-12">
                                                <label for="content_four" class="col-form-label">Content Four</label>
                                                <textarea id="content_four" name="content_four" class="form-control" placeholder="Content Four..."><?= $contentRow['content_four'] ?></textarea>
                                            </div>
                                        </div>
                                        <?php if($contentRow['type'] == 'video-'.$_GET['type']){ ?>
                                        <div class="form-group row mb-4" id="video-content">
                                            <div class="col-lg-12" style="text-align: center; margin-bottom: 10px;">
                                                <label style="width: 100%; text-align: left;" class="col-form-label">Video</label>
                                                <button class="btn btn-info" onclick="$('#video-gallery').modal();">Gallery Video</button>
                                                <button class="btn btn-success" onclick="SelectVideo($(this));"><i class="fa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i>Upload Video</button>
                                                <button class="btn btn-danger" style="display: none;" onclick="RemoveVideo();">Remove Video</button>
                                                <input type="file" hidden style="display: none;" accept="video/*">
                                                <?php
                                                if(!empty($contentRow['video'])){
                                                    if(count(explode('uploads/gallery/', $contentRow['video'])) > 1){
                                                      $img_path = $cms_url.$contentRow['video'];
                                                    }else{
                                                      $img_path = $cms_url."uploads/videos/".$contentRow['video'];
                                                    }
                                                }
                                                ?>
                                                <video id="blogvideo" width="80%" height="400" style="margin-top: 10px; <?php if(empty($contentRow['video'])){echo "display: none;";} ?>background: #000;" height="300" src="<?= $img_path ?>" controls></video>
                                            </div>
                                            <div class="col-lg-12" style="text-align: center; margin-bottom: 10px;">
                                                <div class="row" style="padding: 0 15px;">
                                                    <input type="url" value="<?= $contentRow['embed'] ?>" style="margin-bottom: 10px;" name="embed" class="form-control col-lg-10" placeholder="Add embed video link...">
                                                    <button onclick="EmbedVideo($(this));" class="btn btn-success btn-sm" style="height: 37px; margin-left: 10px; float: right;">Preview</button> 
                                                    <button onclick="EmbedVideo($(this));" class="btn btn-danger btn-sm" style="height: 37px; margin-left: 10px; float: right;">Remove</button> 
                                                    <span class="text-danger embed-video-error"></span>
                                                </div>
                                                <iframe width="80%" height="400" src="<?= $contentRow['embed'] ?>" style="margin-top: 10px; <?php if(empty($contentRow['embed'])){echo "display: none;";} ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <?php } else if($contentRow['type'] == 'image-slider-'.$_GET['type']){ ?>
                                        <div id="image-slider-content" style="text-align: center;">
                                            <label for="content_two" style="width: 100%; text-align: left;" class="col-form-label">Upload Images</label>
                                            <form class="modal-body dropzone" action="https://cms.ourcanadadev.site/ajax.php?h=DropzoneImageSlider" id="image-slider" style="background: rgba(0,0,0,.1); border: 0; max-height: 300px; overflow: auto; border-radius: 20px;">
                                            </form>
                                            <br>
                                            <button class="btn btn-info" onclick="$('#image-gallery').modal();">Gallery Images</button>
                                            <button class="btn btn-success" onclick="$('#image-slider-content .dropzone').click();">Upload Images</button>
                                        </div>
                                        <?php } else if($contentRow['type'] == 'video-image-'.$_GET['type']){ ?>
                                        <br>
                                        <div id="image-video-content">
                                            <div class="row">
                                                <div class="col-lg-12" style="text-align: center;">
                                                    <label for="content_two" class="col-form-label" style="width: 100%; text-align: left; padding-left: 15px;">Upload Images</label>
                                                    <form class="modal-body dropzone" action="https://cms.ourcanadadev.site/ajax.php?h=DropzoneImageSlider" id="video-image-slider" style="background: rgba(0,0,0,.1); border: 0; max-height: 300px; overflow: auto; border-radius: 20px;">
                                                    </form>
                                                    <br>
                                                    <button class="btn btn-info" onclick="$('#content-image-gallery').modal();">Gallery Images</button>
                                                    <button class="btn btn-success" onclick="$('#image-video-content .dropzone').click();">Upload Images</button>
                                                </div>
                                                <div class="col-lg-12" style="text-align: center; padding: 10px 0;">
                                                    <label for="content_two" class="col-form-label" style="width: 100%; text-align: left; padding-left: 15px;">Upload Video</label>
                                                    <?php 
                                                    $img_list = $contentRow['video'];
                                                    if(count(explode('uploads/gallery/', $img_list)) > 1){
                                                        $img_path = $cms_url.$img_list;
                                                    }else{
                                                        $img_path = $cms_url."uploads/videos/".$img_list;
                                                    }
                                                    ?>
                                                    <video style="width: 80%; height: 400px; background: #000; <?php if(empty($contentRow['video'])){echo "display: none;";} ?>" src="<?= $img_path ?>" controls></video>
                                                    <br>
                                                    <input type="file" hidden accept="video/*">
                                                    <button class="btn btn-info" onclick="$('#video-gallery-content').modal();">Gallery Video</button>
                                                    <button class="btn btn-success" onclick="VideoContentUpload($(this));"><i class="faa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i>Upload Video</button>
                                                    <button class="btn btn-danger" onclick="RemoveVideoContentUpload($(this));" style="display: none;">Remove Video</button>
                                                </div>

                                                <div class="col-lg-12" id="video-image" style="text-align: center; margin-bottom: 10px;">
                                                    <div class="row" style="padding: 0 15px;">
                                                        <input type="url" value="<?= $contentRow['embed'] ?>" style="margin-bottom: 10px;" name="youtube_embed" class="form-control col-lg-10" placeholder="Add embed video link...">
                                                        <button onclick="EmbedVideoSecond($(this));" class="btn btn-success btn-sm" style="height: 37px; margin-left: 10px; float: right;">Preview</button> 
                                                        <button onclick="EmbedVideoSecond($(this));" class="btn btn-danger btn-sm" style="height: 37px; margin-left: 10px; float: right;">Remove</button> 
                                                        <span class="text-danger embed-video-error"></span>
                                                    </div>
                                                    <iframe width="80%" height="400" src="<?= $contentRow['embed'] ?>" style="margin-top: 10px; <?php if(empty($contentRow['embed'])){echo "display: none;";} ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                </div>

                                            </div>
                                        </div>
                                        <?php } ?>
                                        <br>
                                        
                                        <?php if($contentRow['type'] == 'pdf-blog' || $contentRow['type'] == 'pdf-news'){ ?>
                                        <input type="file" name="pdf_file" onchange="if($(this)[0].files[0].type == 'application/pdf'){$('#pdfBTN').text($(this)[0].files[0].name)}else{$(this).val()='';}" accept="application/pdf" id="pdf_file" style="display: none;">
                                        <button class="btn btn-success" onclick="$('input[name=pdf_file]').click();" id="pdfBTN">Select PDF</button>
                                        <div class="row">
                                            <div class="col-lg-2 pdf-box">
                                                <i class="fa fa-file fa-5x"></i> <br><br>
                                                <a href="<?= $cms_url ?>uploads/pdf_files/<?= $contentRow['pdf_path'] ?>" target="_blank">Preview PDF</a> <br>
                                            </div>
                                        </div>
                                        <br><br>
                                        <?php } ?>

                                        <?php if($contentRow['type'] == 'pdf-blog' || $contentRow['type'] == 'pdf-news' || $contentRow['type'] == 'simpleblog' || $contentRow['type'] == 'simplenews'){ ?>
                                        <button class="btn btn-primary" onclick="$('#thumbnail-image-gallery').modal();">Select Thumbnail</button>
                                        <?php } ?>
                                        <br>
                                        <span class="thumbnail_error text-danger"></span>

                                        <br>
                                        <label class="col-form-label">Tags</label>
                                        <input type="text" id="blog_tages" value="<?= $contentRow['tages'] ?>" class="form-control" data-role="tagsinput" placeholder="tag1,tag2,tag3...">
                                        <span class="text-danger"></span>
                                        <br><br>
                                        <div class="row mt-3">
                                            <div class="form-group col-lg-4">
                                                <label>Date</label>
                                                <input type="date" name="date" value="<?= date_format(date_create($contentRow['created_at']),'Y-m-d'); ?>" class="form-control">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label>Time</label>
                                                <input type="time" name="time" value="<?= date_format(date_create($contentRow['created_at']),'H:i:s'); ?>" class="form-control">
                                            </div>
                                        </div>
                                        <button type="button" onclick="CreateContent($(this));" class="btn btn-success"><i style="display: none; margin-right: 5px;" class="fa fa-spin fa-spinner"></i> Update Content</button>
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
                <i class="fa fa-check <?php if($imgs[$i] == $contentRow['content_thumbnail']){echo 'active';} ?>"></i>
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
            if(!empty($contentRow['video'])){
                echo '<h3 align="center">Current Video</h3>';
            $img_list = $contentRow['video'];
            if(count(explode('uploads/gallery/', $img_list)) > 1){
                $file_path = 'uploads/gallery/'.$img_list;
                $img_path = $cms_url.$img_list;
                $file_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $file_path);
                    $img_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $img_path);
            }else{
                $file_path = $img_list;
                $img_path = $cms_url."uploads/videos/".$img_list;
            }
            ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check active"></i>
                <video file-path="<?= $file_path ?>" src="<?= $img_path ?>" controls></video>
            </div>
        <?php } ?>
            <div style="float: left;width: 100%;">
                <h3 align="center">Gallery Videos</h3>
            </div>
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
            <h3 align="center">Current Images</h3>
            <?php 
            $img_list = explode(',', $contentRow['slider_images']);
            for ($i=0; $i < count($img_list); $i++) {
                if(count(explode('uploads/gallery/', $img_list[$i])) > 1){
                    $file_path = 'uploads/gallery/'.$img_list[$i];
                    $img_path = $cms_url.$img_list[$i];
                    $file_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $file_path);
                    $img_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $img_path);
                }else{
                    $file_path = $img_list[$i];
                    $img_path = $cms_url."uploads/images/".$img_list[$i];
                }
            ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check active"></i>
                <img file-path="<?= $file_path ?>" src="<?= $img_path ?>">
            </div>
            <?php } ?>
            <div style="float: left;width: 100%;">
                <h3 align="center">Gallery Images</h3>
            </div>
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
            <h5 class="modal-title">Gallery Images</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" style="max-height: 400px; overflow: auto;">
            <h3 align="center">Current Images</h3>
            <?php 
            $img_list = explode(',', $contentRow['slider_images']);
            for ($i=0; $i < count($img_list); $i++) {
                if(!empty($img_list[$i]) || $img_list[$i]  != null){
                if(count(explode('uploads/gallery/', $img_list[$i])) > 1){
                    $file_path = 'uploads/gallery/'.$img_list[$i];
                    $img_path = $cms_url.$img_list[$i];
                    $file_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $file_path);
                    $img_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $img_path);
                }else{
                    $file_path = $img_list[$i];
                    $img_path = $cms_url."uploads/images/".$img_list[$i];
                }
            ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check active"></i>
                <img file-path="<?= $file_path ?>" src="<?= $img_path ?>">
            </div>
            <?php } } ?>
            <div style="float: left;width: 100%;">
                <h3 align="center">Gallery Images</h3>
            </div>
            <?php 
            $img_dir = '../community/uploads/gallery/';
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
            <h3 align="center">Current Video</h3>
            <?php 
            $img_list = $contentRow['video'];
            if(count(explode('uploads/gallery/', $img_list)) > 1){
                $file_path = 'uploads/gallery/'.$img_list;
                $img_path = $cms_url.$img_list;
                $file_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $file_path);
                    $img_path = str_replace('uploads/gallery/uploads/gallery/', 'uploads/gallery/', $img_path);
            }else{
                $file_path = $img_list;
                $img_path = $cms_url."uploads/videos/".$img_list;
            }
            ?>
            <div class="gallery-item col-lg-4">
                <i class="fa fa-check active"></i>
                <video file-path="<?= $file_path ?>" src="<?= $img_path ?>" controls></video>
            </div>
            <div style="float: left;width: 100%;">
                <h3 align="center">Gallery Videos</h3>
            </div>
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
    <!-- End Page-content -->
    <?php include_once("includes/script.php"); ?>
    <script src="assets/libs/dropzone/min/dropzone.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.1/tinymce.min.js" integrity="sha512-rCSG4Ab3y6N79xYzoaCqt9gMHR0T9US5O5iBuB25LtIQ1Hsv3jKjREwEMeud8q7KRgPtxhmJesa1c9pl6upZvg==" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
    <script type="text/javascript">

    function EmbedVideoSecond(sel){
        if(sel.hasClass("btn-success") && $("input[name=youtube_embed]").val() != ""){
            var videoURL = $("input[name=youtube_embed]").val();
            
            var urlParts = videoURL.split("/");
            if(urlParts[0] == "https:" && urlParts[2] == "www.youtube.com" && urlParts[3] == "embed"){
                $("#video-image iframe").attr("src",$("input[name=youtube_embed]").val());
                $("#video-image iframe").show();
                $("input[name=youtube_embed]").siblings('.embed-video-error').text("");
            }else{
                $("input[name=youtube_embed]").siblings('.embed-video-error').text("Invalid youtube video.");
            }
        }
        if(sel.hasClass("btn-danger")){
            $("#video-image iframe").hide();
            $("input[name=youtube_embed]").val("");
        }
    }    

    $(document).ready(function(){

        var quote = CKEDITOR.replace( 'quote' );
        var content_one = CKEDITOR.replace( 'content_one' );
        var content_two = CKEDITOR.replace( 'content_two' );
        var content_three = CKEDITOR.replace( 'content_three' );
        var content_four = CKEDITOR.replace( 'content_four' );
        // tinymce.init({
            // selector: '.editor textarea'
        // });

    	var vid = document.getElementById('blogvideo');
    	vid.currentTime = 1;
    	vid.play();
    	setTimeout(function(){
    		vid.pause();
    	},500);
    });

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

        //   console.log(VideoThumbnail);
    }

    $("#thumbnail-image-gallery .gallery-item i").click(function(){
        $("#thumbnail-image-gallery .gallery-item i").removeClass("active");
        $(this).toggleClass('active');
    });    

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

    $("#category").select2();

    function SetContentCategory(val){
        if(val == 0){
            $("#video-content,#image-slider-content,#image-video-content").hide();
        }
        if(val == 1){
            $("#image-slider-content,#image-video-content").hide();
            $("#video-content").show();
        }
        if(val == 2){
            $("#video-content,#image-video-content").hide();
            $("#image-slider-content").show();
        }
        if(val == 3){
            $("#video-content,#image-slider-content").hide();
            $("#image-video-content").show();
        }
    }

    // For Video Blog/News
    var video = null;
    <?php 
    if($contentRow['type'] == 'video-'.$_GET['type'] && !empty($contentRow['video'])){ ?>   
    var gallery = "<?= $contentRow['video']; ?>";
    <?php }else { ?> 
    var gallery = "";
    <?php } ?>

    <?php 
    if($contentRow['type'] == 'video-'.$_GET['type'] && !empty($contentRow['embed'])){ ?>   
    var embed = "<?= $contentRow['embed']; ?>";
    <?php }else { ?> 
    var embed = "";
    <?php } ?>

    function SelectVideo(sel){
        $("#video-content input[type=file]").click();
        $("#video-content input[type=file]").change(function(){
            var input = this;
            if (input.files && input.files[0]) {
                if(input.files[0].size > 8000000){
                    $(".prompt").attr("class","prompt alert alert-danger");
                    $(".prompt").text("Video size can not be grater then 8 MB.");
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }else{
                    sel.children("i").show();
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#video-content video").attr("src",e.target.result);
                        sel.children("i").hide();
                    }
                    $("#video-content video").show();
                    reader.readAsDataURL(input.files[0]);
                    video = input;
                    $("#video-gallery i").removeClass("active");
                    gallery = "";
                    $("#video-content .btn-danger").show();
                    getThumbnail();
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
        let video_url=$("#video-content input[type=url]").val()

        if(sel.hasClass("btn-success") && video_url != ""){
            var videoURL = video_url;
            var urlParts = videoURL.split("/");
            if(urlParts[0] == "https:" && urlParts[2] == "www.youtube.com" && urlParts[3] == "embed"){
                $("#video-content iframe").attr("src",video_url);
                $("#video-content iframe").show();
                embed = video_url;
                $(".embed-video-error").text("");
            }else{
                $(".embed-video-error").text("Invalid youtube video.");
            }
            
        }
        if(sel.hasClass("btn-danger")){
            $("#video-content iframe").hide();
            embed = "";
            $("#video-content input[type=url]").val("");
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
            $("#video-content video").attr("src",$("#video-gallery .active").siblings("video").attr("src"));
            $("#video-content video").show();
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
    var upload_slider = null;
    var slider_images = [];
    <?php if($contentRow['type'] == 'image-slider-'.$_GET['type'] && !empty($contentRow['slider_images'])){ ?>   
    var cur_img = "<?= $contentRow['slider_images'] ?>".split(",");
    for (var i = 0; i < cur_img.length; i++) {
        slider_images.push(cur_img[i]);
    }
    <?php } ?>


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
    <?php 
    if($contentRow['type'] == 'video-image-'.$_GET['type'] && !empty($contentRow['video'])){ ?>   
    var upload_gallery = "<?= $contentRow['video']; ?>";
    <?php }else { ?> 
    var upload_gallery = "";
    <?php } ?>

    function VideoContentUpload(sel){
        $("#image-video-content input[type=file]").click();
        $("#image-video-content input[type=file]").change(function(){
            var input = this;
            if (input.files && input.files[0]) {
                if(input.files[0].size > 8000000){
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

    var upload_images = null;
    var content_images = [];

    <?php if($contentRow['type'] == 'video-image-'.$_GET['type'] && !empty($contentRow['slider_images'])){ ?>   
    var cur_vid_img = "<?= $contentRow['slider_images'] ?>".split(",");
    for (var i = 0; i < cur_vid_img.length; i++) {
        content_images.push(cur_vid_img[i]);
    }
    <?php } ?>

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
        if(Validate()){
            // Create Slug
            var link = $("#title").val();
            link = link.toLowerCase();
            link = link.replace(/[^a-zA-Z0-9\s+]/g, '');
            var slug = link.replace(/\s+/g, '-');

            var form = new FormData();
            
            form.append('id','<?= $contentRow['id'] ?>');
            form.append('table',"<?= $_GET['type'] ?>_content");
            form.append('title',$("#title").val());
            form.append('old_title',"<?= $contentRow['title'] ?>");
            form.append('slug',slug);
            form.append('description',$("#description").val());
            form.append('content_one',CKEDITOR.instances.content_one.getData());
            form.append('content_two',CKEDITOR.instances.content_two.getData());
            form.append('content_three',CKEDITOR.instances.content_three.getData());
            form.append('content_four',CKEDITOR.instances.content_four.getData());
            form.append('quote',CKEDITOR.instances.quote.getData());
            form.append('category',$("#category").val().join(","));
            form.append('tages',$("#blog_tages").val());
            form.append('time_zone',user_time_zone);
            if($("input[name=date]").val() != "" && $("input[name=time]").val() != ""){
                form.append("date",$("input[name=date]").val());
                form.append("time",$("input[name=time]").val());
            }
            if("<?= $contentRow['type'] ?>" == "video-<?= $_GET['type'] ?>"){
                if(video != null){
                    form.append("single_video",video.files[0]);
                }else{
                    form.append('video',gallery);
                }
                form.append("embed",embed);
                if(video != null || gallery != ""){
                    getThumbnail();
                    form.append("thumbnail",VideoThumbnail);
                }
            }else if("<?= $contentRow['type'] ?>" == "image-slider-<?= $_GET['type'] ?>"){
                if(slider_images.length > 0){
                    form.append('slider_images',slider_images.join(","));
                }
                if(upload_slider != null){
                    for (var i = 0; i < upload_slider.files.length; i++) {
                        form.append('multi_images[]',upload_slider.files[i]);
                    }
                }
            }else if("<?= $contentRow['type'] ?>" == "video-image-<?= $_GET['type'] ?>"){
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
            <?php if($contentRow['type'] == 'video-blog' || $contentRow['type'] == 'video-news'){ ?>
            if($("#video-content input[type=url]").val() != ""){
                form.append("youtube_embed",$("#video-content input[type=url]").val());
            }
            <?php } ?>

            <?php if($contentRow['type'] == 'video-image-blog' || $contentRow['type'] == 'video-image-news'){ ?>
            if( $("input[name=youtube_embed]").val() != ""){
                form.append("youtube_embed", $("input[name=youtube_embed]").val());
            }
            <?php } ?>

            <?php if($contentRow['type'] == 'simpleblog' || $contentRow['type'] == 'simplenews'){ ?>
            form.append('content_thumbnail',$("#thumbnail-image-gallery .active").siblings("img").attr("img-name"));
            <?php } ?>

            if($("#pdf_file").val() != "" && typeof $("#pdf_file").val() !== "undefined"){
                form.append("pdf_file",$("#pdf_file")[0].files[0]);
            }

            form.append("lang","<?= @$_GET['lang'] ?>");
            // console.log(content_images.length)
            if(upload_images != null){
                // console.log(upload_images.files.length);
            }


            $.ajax({
                type: "POST",
                url: "ajax.php?h=addContent&created_by=0",
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
                    // console.log(res);
                    if(res.error){
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        if(res.error != "Failed to update."){
                            $(".prompt").attr("class","prompt alert alert-danger");
                            $(".prompt").text(res.error); 
                        }else{
                            $(".prompt").attr("class","prompt alert alert-danger");
                            $(".prompt").text("Failed to update.");
                        }
                       
                    }else{
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        $(".prompt").attr("class","prompt alert alert-success");
                            $(".prompt").text("Record Update Successfully.");
                            setTimeout(function(){
                                window.open('<?= $super_admin.str_replace('blog', 'blogs', $_GET['type']); ?>','_SELF');
                            },3000);
                    }
                },
                error: function(e){
                    sel.children("i").hide();
                    // console.log(e)
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

        if('<?= $contentRow['type'] ?>' == 'pdf-news' || '<?= $contentRow['type'] ?>' == 'pdf-blog'){
            if($("#pdf_file").val() != "" && $("#pdf_file")[0].files[0].type != 'application/pdf'){
                $(".prompt").attr("class","prompt alert alert-danger");
                $(".prompt").text("Please select pdf file.");
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                check = false;
            }
        }

        // var q = tinyMCE.get('quote').getContent();
        // var o = tinyMCE.get('content_one').getContent();
        // var t = tinyMCE.get('content_two').getContent();
        // var tt = tinyMCE.get('content_three').getContent();
        // var f = tinyMCE.get('content_four').getContent();

        var q = CKEDITOR.instances.quote.getData();
        var o = CKEDITOR.instances.content_one.getData();
        var t = CKEDITOR.instances.content_two.getData();
        var tt = CKEDITOR.instances.content_three.getData();
        var f = CKEDITOR.instances.content_four.getData();

        if(check){
            if(CKEDITOR.instances.content_one.getData() == "" && CKEDITOR.instances.content_two.getData() == "" && CKEDITOR.instances.content_three.getData() == "" && CKEDITOR.instances.content_four.getData() == ""){
                $(".prompt").attr("class","prompt alert alert-danger");
                $(".prompt").text("Please fill at least one content.");
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                check = false;
            }else if(q.includes("<p>&lt;img</p>") || q.includes("<img") || o.includes("<p>&lt;img</p>") || o.includes("<img") || t.includes("<p>&lt;img</p>") || t.includes("<img") || tt.includes("<p>&lt;img</p>") || t.includes("<img") || f.includes("<p>&lt;img</p>") || f.includes("<img")){
                $(".prompt").attr("class","prompt alert alert-danger");
                $(".prompt").text("Image is not allowed in any content.");
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
                check = false;
            }else{
                if("<?= $contentRow['type'] ?>" == "video-<?= $_GET['type'] ?>" && (video == null || video.files.length < 1) && embed == "" && gallery == ""){
                    $(".prompt").attr("class","prompt alert alert-danger");
                    $(".prompt").text("Please add or uploads video.");
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                    check = false;
                }

                if("<?= $contentRow['type'] ?>" == "image-slider-<?= $_GET['type'] ?>"){
                    if(slider_images.length < 1 && (upload_slider == null || upload_slider.files.length <1)){
                        $(".prompt").attr("class","prompt alert alert-danger");
                        $(".prompt").text("Please add or uploads al least one image.");
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        check = false;
                    }
                }

                if("<?= $contentRow['type'] ?>" == "video-image-<?= $_GET['type'] ?>"){
                    if(upload_gallery == "" && (upload_video == null || upload_video.files.length < 1) && $("input[name=youtube_embed]").val() == ""){
                        $(".prompt").attr("class","prompt alert alert-danger");
                        $(".prompt").text("Please add video.");
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        check = false;
                    }
                    else if(content_images.length < 1 && (upload_images == null || upload_images.files.length < 1)){
                        $(".prompt").attr("class","prompt alert alert-danger");
                        $(".prompt").text("Please add or uploads al least one image.");
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        check = false;
                    }else if(upload_images != null && content_images.length + upload_images.files.length > 4 || content_images.length > 4){
                        $(".prompt").attr("class","prompt alert alert-danger");
                        $(".prompt").text("You can not add mote then 4 images.");
                        $('html, body').animate({
                            scrollTop: 0
                        }, 500);
                        check = false;
                    }
                }
            }
        }

        if($("#blog_tages").val() == ""){
            $("#blog_tages").siblings(".text-danger").text("Tags are required.");
            check = false;
        }else{
            $("#blog_tages").siblings(".text-danger").text("");
        }
        
        return check;
    }
</script>
</body>
</html>
