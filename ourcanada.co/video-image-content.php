<?php

include_once( "user_inc.php" );
$page = 'inner';
  $request = explode( "/", $_SERVER[ 'REQUEST_URI' ] );
  $result_blog = "";
  $result_news = "";
  $recent_post_check = "";
  if($request[1] == ""){
    $recent_post_check = "base";
    $blog_select = "SELECT * FROM `".$blog_table."` ORDER BY `id` DESC LIMIT 3";
    $result_blog = mysqli_query($conn, $blog_select);
  } else{
    $check = $request[ 1 ];
    if($check == "news"){
      $recent_post_check = "news";
      $news_select = "SELECT * FROM `".$news_table."` ORDER BY `id` DESC LIMIT 3";
      $result_news = mysqli_query($conn, $news_select);
    } else{
      $recent_post_check = "blog";
      $blog_select = "SELECT * FROM `".$blog_table."` ORDER BY `id` DESC LIMIT 3";
      $result_blog = mysqli_query($conn, $blog_select);
    }
  }
  
?>
<!DOCTYPE html>

<html lang="en-US">

    <head>

        <meta charset="UTF-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="">

        <meta name="description" content="">

        <meta name="keywords" content="">

        <!-- Title-->

        <title><?= $allLabelsArray[535] ?></title>
        <style>
            .modal-header .close{
          margin-top: unset !important;
        }
        </style>
        <!-- Favicon-->

        <?php include("community/includes/style.php"); ?>

        <link href="<?= $cms_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= $cms_url ?>assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= $cms_url ?>assets/dropzone/dropzone.min.css">
<style type="text/css">
  .fa-check{
    z-index: 1111;
  }
  <?php if(getCurLang($langURL,true) == 'arabic'){ ?>
    .editSpan{
      float: none !important;
    }
  <?php } ?>
</style>

    </head>



<body class="mobile_nav_class jl-has-sidebar">

    <div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">

        <div class="options_layout_container full_layout_enable_front"> 


<?php include("community/includes/header.php"); ?>
<?php 
  $defaultVideo = $ourcanada_app.'/superadmin/uploads/videos/vid-25th-2020023858PM.MP4';
  $defaultEmbed = 'https://www.youtube.com/embed/wnfWhoQHWOE';
?>
<style>
:root { --ck-z-default: 100; --ck-z-modal: calc( var(--ck-z-default) + 999 ); }
                 .select2-selection__choice{
                                  background: #f4f4f4 !important;
                                }
                                .select2-selection__choice__display{
                                  color: #956D41 !important;
                                }
                                .select2-selection__choice__remove span{
                                  color: #db4a4a !important;
                                }
                              </style>
<style type="text/css">
.bootstrap-tagsinput .tag {
    background: red;
    
  }
  .bootstrap-tagsinput .tag [data-role="remove"]:after {
       content: " x";
       padding: 0px 2px;
    }
    .video_item{
          height: 250px;
          position: relative;
        }
        .active_item i{
          color: #fff !important;
        }
        .video_item i{
          cursor: pointer;
          position: absolute;
          top: 0;
          left: 15px;
          background: #8c6238;
          color: #8c6238;
          padding: 5px;
        }
        .video_item video,.video_item img{
          width: 100%;
          height: 100%;
          background: #000;
        }
              #gallery_video .video_item i{
                top: 0 !important;
              }
              .dz-preview{
                background: transparent !important;
              }
              .dz-remove{
                color: red !important;
              }
              .dz-error-message{
                top: 150px !important;
              }
    .tages_list{

                width: 100%;
              }
              .tages_list ul{
                width: 100%;
                text-align: center;
                list-style: none;
                display: inline-block;
                padding-left: 0;
                margin-bottom: 15px;
              }
              .tages_list ul li{
                border-radius: 4px;
                display: inline-block;
                background: #986e44;
                color: #fff;
                padding: 5px 10px;
                margin: 5px 0;
                cursor: pointer;
                font-size: 14px;
              }
              .tages_list ul .active:hover{
                background: red;
              }
              .tages_list ul li:hover{
                background: #6e441d;
              }
              .tages_list ul .active{
                background: red;
              }
              #image_list{
                      background: black;
                      height: 400px;
                      position: relative;
                      text-align: center;
                    }
                    #image_list .img_btn{
                      width: 100%;
                      position: absolute;
                      bottom: -5px;
                      padding: 5px 0;
                      text-align: center;
                      margin-bottom: 5px;
                      background: rgba(0,0,0,.5);
                    }
                    #image_list .img_btn img{
                      border-radius: 0 !important;
                      width: 70px;
                      height: 40px;
                      border: 1px solid #fff;
                      opacity: .5;
                      margin: 2px;
                      transition: all .30s;
                      cursor: pointer;
                      object-fit: cover;
                    }
                    #image_list .img_btn img:hover{
                      opacity: 1;
                    }
                    #image_list .full_size{
                      max-width: 100%;
                      max-height: 100%;
                      border-radius: 0 !important;
                    }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="/assets/dropzone/dropzone.min.css">
<div class="jl_home_section jl_home_slider">
<div class="container">
  <div class="row">
<div class="col-md-8 loop-large-post" id="content">
  <div class="widget_container content_page"> 
    <!-- start post -->
    <div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
      
      <div class="single_section_content box blog_large_post_style">
        <div class="jl_single_style2">
          <div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature">
            
              <div class="form-group" style="margin-top: 80px;">
                  <div class="row"><div id="display_error"></div>
                      <div class="tages_list">
              <ul>
                <?php 
                $getCate = mysqli_query($conn,"SELECT *,title_french as title_francais FROM category_blog ORDER BY title");
                while($row = mysqli_fetch_assoc($getCate)){
                  $cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
                  $categoryList = explode(',', $getRow['category']);
                  $active_item = '';
                  for ($i=0; $i < count($categoryList); $i++) {
                    if(str_replace(' ', '', $row['id']) == str_replace(' ', '', $categoryList[$i])){
                      $active_item = 'class="active"';
                    }
                  }
                ?>
                <li data-id="<?= $row['id'] ?>" <?= $active_item ?>><?= $row['title'.$cate_title] ?></li>
                <?php } ?>
              </ul>
            </div>
                  </div>
                  <!-- <input type="text" class="form-control" style="height: 39.75px; margin-top: 20px;" placeholder="Blog Description..." id="blog_desc"> -->
              </div>
              <h1 class="single_post_title_main title"> <span id="title_display"><?= $getRow['title'] ?></span>
                <span class="editSpan" >
                            <a class="btn btn-sm editButton" onclick="ShowHeader($('#title_display'),$('#description_display'));" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
                          </span>
              </h1>
            <p class="post_subtitle_text" id="description_display"><?= $getRow['description'] ?></p>
            </span></div>
          <div class="single_content_header jl_single_feature_below"> <span class="editSpan"> 
                            <a class="btn btn-sm editButton" onclick="$('#video-gallery-form').modal()" style="margin: 7px;"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[492] ?></a>
            <a class="btn btn-sm" onclick="ShowVideo();" style="float: right; text-decoration: none; margin-top: 8px; background: #C49A6C; color: white;"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> </span>
            <div class="image-post-thumb jlsingle-title-above">
              <?php 
                            $video_local = $getRow['video'];
                            if(count(explode('uploads/gallery/', $video_local)) > 1){
                                  $img_path = $cms_url.$video_local;
                                }else{
                                  $img_path = $cms_url."uploads/videos/".$video_local;
                                }
                            ?>
              <video id="sibgle_video_preview" class="blogvideo" src="<?= $img_path ?>" controls="" __idm_id__="834033665" width="750" height="400"></video>
            </div>
          </div>
        </div>
        <div class="post_content">
          <div>
                        <span class="editSpan">
                          <a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_one'),'content_one');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
                        </span>
                        <div style="text-align: justify;" id="content_one"><?php if(empty($getRow['content_one'])){}else{echo $getRow['content_one'];} ?></div>
                      </div>
          <div> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="ShowEditor('Add Quote',$('#blockquote'),'quote');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <blockquote>
              <p style="text-align: center;" id="blockquote"><b><?php if(empty($getRow['quote'])){}else{echo $getRow['quote'];} ?></b></p>
            </blockquote>
          </div>
          <div> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_two'),'content_two');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <p style="text-align: justify;" id="content_two"><?php if(empty($getRow['content_two'])){}else{echo $getRow['content_two'];} ?></p>
          </div>
          <div> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_three'),'content_three');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <p style="text-align: justify;" id="content_three"><?php if(empty($getRow['content_three'])){}else{echo $getRow['content_three'];} ?></p>
          </div>
            <!--  -->
            <span class="editSpan"> 
                <a class="btn btn-sm editButton" onclick="$('#image-gallery-form').modal();"><i class="fa fa-edit"></i>&nbsp;Gallery</a>
                <a class="btn btn-sm editButton" onclick="$('#dropzone-form').modal();"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> </span>
            <div id="image_list">
                <img class="full_size" src="<?= $cms_url ?>uploads/images/2610202017011269965663f1231b946cd69ce89fd0f5d6.jpg">
                    <div class="img_btn">
                     <?php 
                    $images = explode(',', $getRow['slider_images']);
                    for($i = 0; $i < count($images); $i++){ if(!empty($images[$i])){ 
                      if(count(explode('uploads/gallery/', $images[$i])) > 1){
                        $img_path = $cms_url.$images[$i];
                      }else{
                        $img_path = $cms_url."uploads/images/".$images[$i];
                      }
                    ?>
                        <img onclick="ChangePhoto($(this));" src="<?= $img_path ?>">
                    <?php }} ?> 
                    </div>
              </div>
          </div>
          <div style="text-align: right;"> 
            <span class="my-span" style="width: 100% !important;"> 
              <a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_four'),'content_four');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 
            </span>
            <p style="text-align: justify;" id="content_four"><?php if(empty($getRow['content_four'])){}else{echo $getRow['content_four'];} ?></p>
          </div>
          <div style="width: 100%; height: 50px;"></div>
          <div style="width: 100%; margin-bottom: 15px;">
            <input type="text" data-role="tagsinput" value="<?= $getRow['tages'] ?>" class="form-control" id="blog_tages" placeholder="<?= $allLabelsArray[561] ?>">
          </div>
        <div style="float: right; margin-bottom: 25px;">
          <button class="btn btn-sm" style="background: #C49A6C; color: white;" onclick="UpdateBlog($(this))"> <i class="fa fa-spin fa-spinner" style="display: none;"></i> <?= $allLabelsArray[536] ?></button>
        </div>
      </div>
    </div>
    <!-- sidebar -->

    <!-- end post -->
    <div class="brack_space"></div>
  </div>
</div>
   <?php include_once 'sidebar.php'; ?>
</div>
<!-- Dropzone Modal -->
  <div class="modal" id="dropzone-form" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[520] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="dropzone-error"></div>
              <form class="modal-body dropzone" action="<?= $cms_url ?>ajax.php?h=DropzoneImageSlider" id="dropzone" style="background: rgba(0,0,0,.1); border: 0; max-height: 300px; overflow: auto; border-radius: 20px;">
            </form>
            </div>
            <div class="modal-footer" style="text-align: center;">
              <button type="button" class="btn btn-danger" onclick="$('#dropzone').click();" style="background: #8c6238; border: 0;"><i class="fa fa-plus"></i> Add More</button>
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?=$allLabelsArray[452] ?></button>
            </div>
        </div>
      </div>
  </div>

  <!-- Gallery Form -->
  <div class="modal" id="image-gallery-form" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[540] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow: auto;">
              
              <div id="image-error"></div>
              <div class="row">
                <h2 align="center"><?= $allLabelsArray[541] ?></h2><hr>
                <?php 
                      $images = explode(',', $getRow['slider_images']);
                      $img_arr = [];
                      for($i = 0; $i < count($images); $i++){ if(!empty($images[$i])){ 
              if(count(explode('uploads/gallery/', $images[$i])) > 1){
                $img_path = $cms_url.$images[$i];
              }else{
                $img_path = $cms_url."uploads/images/".$images[$i];
              }
              array_push($img_arr, $img_path);
            ?>
            <div class="video_item col-lg-4 active_item" style="margin-bottom: 15px;">
                <i class="fa fa-check"></i>
                <img class="blogvideo" file-name="<?= $images[$i] ?>" src="<?= $img_path ?>">
            </div>
                      <?php }} ?>
              </div>
              <?php 
          $video_dir    = 'uploads/gallery/';
          // $video_array = scandir($video_dir);
          $videos = array();
          // $video_ext = array('jpg', 'png', 'PNG', 'JPG', 'jpeg', 'gif', 'jpe', 'bmp', 'ico', 'svg', 'svgz', 'tif', 'tiff', 'ai', 'drw', 'pct', 'psp', 'xcf', 'psd', 'raw', 'webp');
          // foreach ($video_array as $path) {
          //   if (in_array(pathinfo($path,  PATHINFO_EXTENSION), $video_ext)) {
          //     $videos[] = $path;
          //   }
          // }
          $g = mysqli_query($conn,"SELECT * FROM gallery_images ORDER BY id DESC");
        while ($r = mysqli_fetch_assoc($g)) {
            $videos[] = $r['image'];
        }
          ?>
          <div class="row">
                <h2 align="center"><?= $allLabelsArray[542] ?></h2>
                <hr>
            <?php for ($i=0; $i < count($videos); $i++) { 
              if(in_array($cms_url.$video_dir.$videos[$i], $img_arr) == false){
            ?>
            <div class="video_item col-lg-4" style="margin-bottom: 15px;">
                <i class="fa fa-check"></i>
                <img file-name="uploads/gallery/<?= $videos[$i] ?>" class="blogvideo" src="<?= $cms_url.$video_dir.$videos[$i] ?>">
            </div>
            <?php } } ?>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?=$allLabelsArray[452] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
      </div>
  </div>  

  <!-- category -->
  <div class="modal" id="category-form" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[520] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="category-error"></div>
              <ul>
                <?php
                $getCate = mysqli_query($conn,"SELECT * FROM category_blog WHERE status = 1");
                while($row = mysqli_fetch_assoc($getCate)){
                $list = explode(",", $getRow['category']); 
                ?>
                <li <?php if(in_array($row['title'], explode(',', $getRow['category']))){echo 'class="active"';} ?>><i class="fa fa-check-circle"></i> <span><?= $row['title'] ?></span></li>
                <?php } ?>
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?=$allLabelsArray[452] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
      </div>
  </div>
      
  <!-- header -->
  <div class="modal" id="header-modal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[493] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="header-error"></div>
              <div class="form-group">
                <label><?= $allLabelsArray[494] ?></label>
                <input type="text" id="content-title" class="form-control">
              </div>
              <div class="form-group">
                <label><?= $allLabelsArray[495] ?></label>
                <textarea id="content-description" class="form-control" rows="10"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?=$allLabelsArray[452] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
      </div>
  </div>  

  <!-- edirot -->
  <div class="modal" id="editor-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
                <h5 class="modal-title" style="color: #fff; text-align: center;"></h5>
                <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="editor-error"></div>
                <textarea id="text-editor" class="form-control" style="height: 350px;" aria-hidden="true"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?=$allLabelsArray[452] ?></button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
    </div>
  </div>

   <!-- Gallery Form -->
  <div class="modal" id="video-gallery-form" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[497] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="video-error"></div>
              <?php 
          $video_dir    = 'uploads/gallery/';
          $video_array = scandir('community/'.$video_dir);
          $videos = array();
          $video_ext = array('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi');
          foreach ($video_array as $path) {
            if (in_array(pathinfo($path,  PATHINFO_EXTENSION), $video_ext)) {
              $videos[] = $path;
            }
          }
          ?>
          <div class="row">
            <?php for ($i=0; $i < count($videos); $i++) { ?>
            <div class="video_item col-lg-4">
                <i class="fa fa-check"></i>
                <video file-name="uploads/gallery/<?= $videos[$i] ?>" class="blogvideo" src="<?= $cms_url.$video_dir.$videos[$i] ?>" controls="" __idm_id__="720368641" width="750" height="400"></video>
            </div>
            <?php } ?>
          </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?=$allLabelsArray[452] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
      </div>
  </div>

    <!-- Video Form -->
  <div class="modal" id="video-form" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[543] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="video-error"></div>
              <form class="col-lg-12" style="text-align: center;">
                <input type="file" name="video" id="single_video" accept="video/*" style="display: none;">
                <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><i style="display: none;" class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[543] ?></button>
              </form>
            </div>
            <div class="modal-footer" style="border: 0;"></div>
        </div>
      </div>
  </div>
 
<form id="blog-form">
    <div class="c_one" style="display: none;"><?= $getRow['content_one'] ?></div>
    <div class="c_two" style="display: none;"><?= $getRow['content_two'] ?></div>
    <div class="c_three" style="display: none;"><?= $getRow['content_three'] ?></div>
    <div class="c_four" style="display: none;"><?= $getRow['content_four'] ?></div>
    <div class="c_quote" style="display: none;"><?= $getRow['quote'] ?></div>
    <input type="hidden" name="id" value="<?= $getRow['id'] ?>">
    <input type="hidden" name="title" value="<?= $getRow['title'] ?>">
    <input type="hidden" name="old_title" value="<?= $getRow['title'] ?>">
    <input type="hidden" name="description" value="<?= $getRow['description'] ?>">
    <input type="hidden" name="content_one" class="content_one" hidden>
    <input type="hidden" name="content_two" class="content_two" hidden>
    <input type="hidden" name="quote" class="blockquote" hidden>
    <input type="hidden" name="content_three" class="content_three" hidden>
    <input type="hidden" name="content_four" class="content_four" hidden>
    <input type="hidden" name="slider_images" value="<?= $getRow['slider_images'] ?>" hidden>
    <input type="hidden" name="video" value="<?= $getRow['video'] ?>" hidden>
    <input type="hidden" name="slug" value="<?= $getRow['slug'] ?>" hidden>
    <input type="hidden" name="lang" value="<?= str_replace('_', '', $c_lang) ?>">
    <input type="hidden" name="type" hidden value="<?= $getRow['type'] ?>">
    <input type="hidden" name="display_type" hidden value="<?= $page_url[1] ?>">
    <input type="hidden" name="tages" hidden value="<?= $getRow['tages'] ?>">
    <input type="hidden" name="category" value="<?= $getRow['category'] ?>" hidden>
</form>

</div>
    </div>
<?php include("community/includes/footer.php"); ?>
        
<?php include("community/includes/script.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?= $cms_url ?>assets/dropzone/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.0/tinymce.min.js" integrity="sha512-GVA/pyUF3G/N6U2o0AdSx02izOM963T6wsJPrJpGLApeIVWtaGDeN7eV/bmlkg2CC1Z+pHt3nQmaXic79mkHwg==" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>


<script type="text/javascript">
Dropzone.prototype.defaultOptions.dictDefaultMessage = "<?= $allLabelsArray[766] ?>";
Dropzone.prototype.defaultOptions.dictRemoveFile = "<?= $allLabelsArray[788] ?>";
Dropzone.prototype.defaultOptions.dictCancelUpload = "<?= $allLabelsArray[789] ?>";
Dropzone.prototype.defaultOptions.dictMaxFilesExceeded = "<?= $allLabelsArray[793] ?>";

$.fn.modal.Constructor.prototype.enforceFocus = function () {
    var $modalElement = this.$element;
    $(document).on('focusin.modal', function (e) {
        var $parent = $(e.target.parentNode);
        if ($modalElement[0] !== e.target && !$modalElement.has(e.target).length &&
            !$parent.hasClass('cke_dialog_ui_input_select') && !$parent.hasClass('cke_dialog_ui_input_text')) {
            e.target.focus()
        }
    })
};
  
    var editor_content_one;
var editor_content_two;
var editor_content_three;
var editor_content_four;
var editor_content_quote;
  var updateCheck = 0;
  $(document).ready(function(){
    $(".btn-primary").click(function(){
    updateCheck = 1;
  });
    $("#image_list .img_btn img:first").click();
    $("#blog-form input[name=content_one]").val($(".c_one").html());
    $("#blog-form input[name=content_two]").val($(".c_two").html());
    $("#blog-form input[name=content_three]").val($(".c_three").html());
    $("#blog-form input[name=content_four]").val($(".c_four").html());
    $("#blog-form input[name=quote]").val($(".c_quote").html());
  });
   function ChangePhoto(sel){
    $("#image_list .full_size").fadeOut(function(){
      $(this).attr("src",sel.attr("src"));
      var img = $("#image_list .full_size").height();
      if(img < 400){
        $("#image_list .full_size").css("margin-top",(200 - (img / 2)));
      }else{
        $("#image_list .full_size").css("margin-top",0);
      }
      $(this).fadeIn();
    });
  }
  var total_images = null;
  var gallery_images = [];

  $(".tages_list li").click(function(){
    $(this).toggleClass("active");
  });

    $("#dropzone").dropzone({
        addRemoveLinks: true,
        acceptedFiles:'image/*',
        timeout: 180000,
        init: function () {
            var myDropzone = this;
                
            this.on('addedfile', function (file, xhr, formData) {
                total_images = myDropzone;
            });

            this.on('removedfile', function (file, xhr, formData){
                total_images = myDropzone;
                
            });

            this.on("complete", function (file) {
              total_images = myDropzone;
            });

        }
    });

    function ShowHeader(title,description){
      $("#header-modal #content-title").val(title.text());
      $("#header-modal #content-description").val(description.text());
      $("#header-modal").modal();

      $("#header-modal .btn-primary").click(function(){
        if($("#content-title").val() == ""){

          $("#header-error").attr("class","alert alert-danger");
          $("#header-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[549] ?>");

        }else if($("#content-description").val() == ""){

          $("#header-error").attr("class","alert alert-danger");
          $("#header-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[550] ?>");

        }else{
          $("#header-error").attr("class","");
          $("#header-error").html("");
          title.text($("#content-title").val());
          description.text($("#content-description").val());
          $("#blog-form input[name=title]").val($("#content-title").val());
          $("#blog-form input[name=description]").val($("#content-description").val());
          $("#header-modal .close").click();
        }
      });
    }

    function ShowEditor(title,pic,input){
      $("#editor-modal .modal-title").text(title);
      
      $('#text-editor').val(pic.html());
      if (editor_content_one) { editor_content_one.destroy(true); }
            editor_content_one = CKEDITOR.replace( 'text-editor' );
           
      
      $("#editor-modal").modal();
      
      $("#editor-modal .btn-primary").attr("input",input);
      $("#editor-modal .btn-primary").attr("content",pic.attr("id"));

      $("#editor-modal .btn-primary").click(function(){
        var input = $(this).attr("input");
        var contant = editor_content_one.getData();
        if(contant == ""){
           $("#"+$(this).attr("content")).html("");
          $("#blog-form input[name="+input+"]").val("");
          $("#editor-modal .close").click();
          // $("#editor-error").attr("class","alert alert-danger");
          // $("#editor-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> Content can not be empty!");
        }
        // else if(contant.includes("<img")){
        //   $("#editor-error").attr("class","alert alert-danger");
        //   $("#editor-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> Image is not allowed!");
        // }
        else{
          $("#editor-error").attr("class","");
          $("#editor-error").html("");
          $("#"+$(this).attr("content")).html(contant);
          $("#blog-form input[name="+input+"]").val(contant);
          $("#editor-modal .close").click();
        }
        
      });
    }

    $(document).ready(function(){
      $("#video-gallery-form .video_item i").click(function(){
        $("#video-gallery-form .video_item").removeClass("active_item");
        $(this).parent().toggleClass("active_item");
      });

      $("#video-gallery-form .btn-primary").click(function(){
        if($("#video-gallery-form .active_item").length > 0){
          $("#video-form form")[0].reset();
          $("#sibgle_video_preview").attr("src",$("#video-gallery-form .active_item video").attr("src"));
          $("#blog-form input[name=video]").val($("#video-gallery-form .active_item video").attr("file-name"));
          $("#video-gallery-form .close").click();
        }
      });

      $("#image-gallery-form .active_item").each(function(){
        gallery_images.push($(this).children("img").attr("file-name"));
      });

      $("#image-gallery-form .video_item i").click(function(){
        var gallery_count = $("#image-gallery-form .active_item").length;
        var total_count = gallery_count;
        if(total_images != null){
          total_count += total_images.files.length;
        }
        if(total_count >= 4 && !$(this).parent().hasClass("active_item")){
          $("#image-error").attr("class","alert alert-danger");
          $("#image-error").html("<?= $allLabelsArray[585] ?>");
          $("#image-gallery-form .modal-body").animate({
            scrollTop: 0
          }, 500);
        }else{
          $("#image-error").attr("class","");
          $("#image-error").html("");
          $(this).parent().toggleClass("active_item");
        }
    });

      $("#image-gallery-form .btn-primary").click(function(){
        gallery_images = [];
        $("#image-gallery-form .active_item").each(function(){
          gallery_images.push($(this).children("img").attr("file-name"));
        });

        console.log(gallery_images);

        $("#image-error").attr("class","");
        $("#image-error").html("");
        $("#image_list .img_btn").html("");
        for (var i = 0; i < gallery_images.length; i++) {
          path = '<?= $cms_url ?>uploads/images/'+gallery_images[i];
          if(path.split("uploads/gallery/").length > 1){
            path = path.replace("uploads/images/","");
          }
          $("#image_list .img_btn").append('<img onclick="ChangePhoto($(this));" src="'+path+'">');
        }
        if(total_images != null && total_images.files.length > 0){
          for (var i = 0; i < total_images.files.length; i++) {
           $("#image_list .img_btn").append('<img onclick="ChangePhoto($(this));" src="'+total_images.files[i].dataURL+'">');
          }
        }
        if($("#image_list .img_btn").html() != ""){
            $("#image_list .img_btn img:first").click();
          }else{
            $("#image_list .full_size").attr("src","");
          }
        $("#image-gallery-form .close").click();

      });

      $("#dropzone-form .btn-primary").click(function(){
        var gallery_count = $("#image-gallery-form .active_item").length;
        var total_count = gallery_count;
        if(total_images != null){
          total_count += total_images.files.length;
        }

        $("#dropzone-error").attr("class","");
        $("#dropzone-error").html("");

        if(total_count > 4){
          $("#dropzone-error").attr("class","alert alert-danger");
          $("#dropzone-error").html("<?= $allLabelsArray[585] ?>");
          $("#dropzone-form .modal-body").animate({
            scrollTop: 0
          },500);
        }else{
          $("#image_list .img_btn").html("");
          for (var i = 0; i < gallery_images.length; i++) {
            path = '<?= $cms_url ?>uploads/images/'+gallery_images[i];
            if(path.split("uploads/gallery/").length > 1){
              path = path.replace("uploads/images/","");
            }
          $("#image_list .img_btn").append('<img onclick="ChangePhoto($(this));" src="'+path+'">');
          }
          for (var i = 0; i < total_images.files.length; i++) {
          $("#image_list .img_btn").append('<img onclick="ChangePhoto($(this));" src="'+total_images.files[i].dataURL+'">');

          }
          if($("#image_list .img_btn").html() != ""){
            $("#image_list .img_btn img:first").click();
          }else{
            $("#image_list .full_size").attr("src","");
          }
          
          $("#dropzone-form .close").click();
        }  
      });

    });

    function ShowVideo(){

    $("#video-error").attr("class","");
    $("#video-error").html("");

    $("#video-form").modal();

    $("#video-form .btn-primary").click(function(){
      $("#video-form input[type=file]").click();
    });

    $("#video-form input[type=file]").change(function(){
      var input = this;
      if (input.files && input.files[0]) {
        // var ext = $(this).val().split('.').pop();
        if(input.files[0].size > 8000000){
          $("#video-error").attr("class","alert alert-danger");
          $("#video-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[546] ?>");
        }else{
          $("#video-form .btn-primary").children("i").show();
              var reader = new FileReader();

              reader.onload = function (e) {
            $("#video-form .btn-primary").children("i").hide();
                $("#sibgle_video_preview").attr("src",e.target.result);
                $("#video-gallery-form .video_item").removeClass("active_item");
                $("#blog-form input[name=video]").val("");
                $("#video-form .close").click();
              }

              reader.readAsDataURL(input.files[0]);
        }

        }
    });

  }

    function ShowMessage(type,msg,icon){
      if(type == ""){
        type = "alert alert-danger";
      }else{
        type = "alert alert-success";
      }
      if(icon == ""){
        icon = "fa fa-exclamation-triangle";
      }
      $("#display_error").attr("class",type);
      $("#display_error").html("<i class='"+icon+"' style='margin-right: 10px;'></i> "+msg);
      $("#display_error").show();
      $('html, body').animate({
        scrollTop: $("#display_error").offset().top - 100
      }, 500);
    }

    function UpdateBlog(sel){
var value = [];
      
      $(".tages_list .active").each(function(){
        value.push($(this).attr("data-id"));
      });
        
      if($("#blog_tages").val() != '<?= $getRow['tages'] ?>'){
        updateCheck = 1;
      }

      if(value.join(",") != '<?= $getRow['category'] ?>'){
        updateCheck = 1;
      }  

      $("#blog-form input[name=category]").val(value.join(","));
      console.log(gallery_images);
      var images = [];

      for (var i = 0; i < gallery_images.length; i++) {
        images.push(gallery_images[i]);
      }
      console.log(images.join(","));
      $("#blog-form input[name=slider_images]").val(images.join(","));

      $("#blog-form input[name=tages]").val($("#blog_tages").val());

      if(updateCheck == 0){
      ShowMessage("","<?= $allLabelsArray[553] ?>","");
    }
      else if($("#blog-form input[name=category]").val() == ""){

        ShowMessage("","<?= $allLabelsArray[554] ?>","");

      }else if($("#blog-form input[name=title]").val() == ""){

        ShowMessage("","<?= $allLabelsArray[549] ?>","");

      }
      // else if(/^[a-zA-Z\s]*$/i.test($("#blog-form input[name=title]").val()) == false){
        
      //   ShowMessage("","Only whitespaces & alphabets are allowed in title!","");
      
      // }
      else if($("#blog-form input[name=description]").val() == ""){

        ShowMessage("","<?= $allLabelsArray[550] ?>","");

      }
      // else if($("#blog-form input[name=content_one]").val().includes("<img")){
        
      //   ShowMessage("","Image is not allowed in content one!","");

      // }else if($("#blog-form input[name=quote]").val().includes("<img")){
        
      //   ShowMessage("","Image is not allowed in content one!","");

      // }else if($("#blog-form input[name=content_two]").val().includes("<img")){
        
      //   ShowMessage("","Image is not allowed in content one!","");

      // }else if($("#blog-form input[name=content_three]").val().includes("<img")){
        
      //   ShowMessage("","Image is not allowed in content one!","");

      // }else if($("#blog-form input[name=content_four]").val().includes("<img")){
        
      //   ShowMessage("","Image is not allowed in content one!","");

      // }
      else if($("#blog-form input[name=content_one]").val() == "" && $("#blog-form input[name=content_two]").val() == "" && $("#blog-form input[name=content_three]").val() == "" && $("#blog-form input[name=content_four]").val() == ""){
        
        ShowMessage("","<?= $allLabelsArray[613] ?>","");

      }else if($("#blog-form input[name=tages]").val() == ""){
        
        ShowMessage("","<?= $allLabelsArray[556] ?>","");
      
      }else{

        var link = $("input[name=title]").val();
        var final = '';
        link = link.toLowerCase();
        if($("#blog-form input[name=lang]").val() == "" || $("#blog-form input[name=lang]").val() == "english"){
          link = link.replace(/[^a-zA-Z0-9\s+]/g, '');
          final = link.replace(/\s+/g, '-');
        }else{
          final = link.replace(" ","-");
          final = link.replace("?","");
        }
        $("#blog-form input[name=slug]").val(final);

        var form = $('#blog-form')[0];
        var formData = new FormData(form);
        if($("#single_video").val() != ""){
            formData.append('single_video',document.getElementById("single_video").files[0]);
        }
       
        if(total_images != null && total_images.files.length > 0){
          for (let i = 0; i < total_images.files.length; i++) {
            formData.append('multi_images[]',total_images.files[i]);
          }
        }

        $.ajax({
          type: "POST",
          url: "<?= $cms_url ?>ajax.php?h=CreateUpdateImageVideoBlog&lang=<?= getCurLang($langURL,true) ?>",
          data: formData,
          enctype: 'multipart/form-data',
          dataType: "json",
          contentType: false,
          cache: false,
          processData:false,
          beforeSend: function(){
            sel.children("i").show();
          },success: function(res){
            sel.children("i").hide();
            console.log(res)
            if(res.success){
              ShowMessage("alert alert-success","<?= $allLabelsArray[557] ?>");
              setTimeout(function(){
                <?php if($page_url[1] == 'news'){?>
                window.open('<?= $cms_url ?>my-news<?= $langURL ?>','_self');
                <?php }else{ ?>
                window.open('<?= $cms_url ?>my-blog<?= $langURL ?>','_self');
                <?php } ?>
              },3000);
            }else{
              ShowMessage("",res.error,"");
            }
          },error: function(e){
            sel.children("i").hide();
            console.log(e)
          }
        });

      }
    
    }
$('p').each(function() {
      var $this = $(this);
      if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
          $this.remove();
  });
</script>
</body>
</html>