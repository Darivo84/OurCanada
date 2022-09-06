<?php
include_once 'community/user_inc.php';
$page = 'inner';
?>

<?php 
  $defaultVideo = $ourcanada_app.'superadmin/uploads/videos/vid-25th-2020023858PM.MP4';
  $defaultEmbed = 'https://www.youtube.com/embed/wnfWhoQHWOE';
?>
<style type="text/css">
.fa-check{
    z-index: 1111;
  }
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
  :root { --ck-z-default: 100; --ck-z-modal: calc( var(--ck-z-default) + 999 ); }
  .bootstrap-tagsinput .tag [data-role="remove"]:after {
       content: " x";
       padding: 0px 2px;
    }
    .video_item{
                position: relative;
                height: 200px;
                margin: 15px 0;
              }
              .video_item i{
                position: absolute;
                top: 15px;
                left: 15px;
                background: #ddd;
                padding: 5px;
                color: #ddd;
                font-size: 18px;
                cursor: pointer;  
              }
              .video_item i:hover{
                opacity: .8;
              }
              .video_item img{
                height: 100%;
                margin: 15px 0;
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
              } #image_list{
                margin-bottom: 30px;
                      background: black;
                      height: 548px;
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
                      position: absolute;
                      left: 0;
                      bottom: 0;
                      height: 100%;
                      width: 100%;
                      max-width: 100% !important;
                      max-height: 100% !important;
                    }
                    <?php if(getCurLang($langURL,true) == 'arabic'){ ?>
                      .editSpan{
                        float: none !important;
                      }
                    <?php } ?>
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= $cms_url ?>/assets/dropzone/dropzone.min.css">
<div class="col-md-8 col-lg-offset-2  loop-large-post" id="content">
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
                $getCate = mysqli_query($conn,"SELECT *,title_french as title_francais FROM category_blog WHERE status = 1 ORDER BY title");
                while($row = mysqli_fetch_assoc($getCate)){
                  $cate_title = $cate_title = empty($_GET['lang']) ? '' : '_'.$_GET['lang'];

                ?>
                <li data-id="<?= $row['id'] ?>"><?= $row['title'.$cate_title] ?></li>
                <?php } ?>
              </ul>
            </div>
                  </div>
                  <!-- <input type="text" class="form-control" style="height: 39.75px; margin-top: 20px;" placeholder="Blog Description..." id="blog_desc"> -->
              </div>
              <h1 class="single_post_title_main title"> <span><?= $allLabelsArray[490] ?> </span>
                <span class="editSpan" >
                            <a class="btn btn-sm editButton" onclick="content_header($('#content_header').text())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
                          </span>
              </h1>
            <p class="post_subtitle_text"> <?= $allLabelsArray[559] ?></p>
            </span></div>
          <div class="single_content_header jl_single_feature_below"> <span class="editSpan"> 
                            <a class="btn btn-sm editButton" onclick="$('#gallery_video').modal();" style="margin: 7px;"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[492] ?></a>
            <a class="btn btn-sm" onclick="videoModel();" style="float: right; text-decoration: none; margin-top: 8px; background: #C49A6C; color: white;"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> </span>
            <div class="image-post-thumb jlsingle-title-above">
              <video id="sibgle_video_preview" class="blogvideo" src="<?= $main_domain ?>/superadmin/uploads/videos/vid-25th-2020065502PM2.MP4" controls="" __idm_id__="834033665" width="750" height="548"></video>
            </div>
          </div>
        </div>
        <div class="post_content">
          <div style="margin-top: 40px;"> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="content_one($('#content_one').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <p style="text-align: justify;" id="content_one"></p>
          </div>
          <div> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="quote($('#blockquote').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <blockquote>
              <p style="text-align: center;" id="blockquote"><b></b></p>
            </blockquote>
          </div>
          <div> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="content_two($('#content_two').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <p style="text-align: justify;" id="content_two"></p>
          </div>
          <div> <span class="editSpan"> <a class="btn btn-sm editButton" onclick="content_three($('#content_three').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 

          </span>
            <p style="text-align: justify;" id="content_three"></p>
          </div>
            <!--  -->
            <span class="editSpan"> 
                            <a class="btn btn-sm editButton" onclick="$('#gallery_image').modal();"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[542] ?></a>
                <a class="btn btn-sm editButton" onclick="$('#dropzoneModel').modal()"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> </span>
            <div id="image_list">
                <img class="full_size" src="<?= $cms_url ?>uploads/samel-slider/toa-heftiba-686278-unsplash-1000x667.jpg">
                <div class="img_btn">
                    <img onclick="ChangePhoto($(this));" src="<?= $cms_url ?>uploads/samel-slider/toa-heftiba-686278-unsplash-1000x667.jpg">
                    <img onclick="ChangePhoto($(this));" src="<?= $cms_url ?>uploads/samel-slider/nadia-valkouskaya-694805-unsplash-1000x667.jpg">
                    <img onclick="ChangePhoto($(this));" src="<?= $cms_url ?>uploads/samel-slider/thought-catalog-462302-unsplash-1000x667.jpg">
                    <img onclick="ChangePhoto($(this));" src="<?= $cms_url ?>uploads/samel-slider/fuyong-hua-274676-unsplash-1000x675.jpg">
                </div>
              </div>
          </div>
          <div style="text-align: right;"> 
            <span class="my-span" style="width: 100% !important;"> 
              <a class="btn btn-sm editButton" onclick="content_four($('#content_four').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a> 
            </span>
            <p style="text-align: justify;" id="content_four"></p>
          </div>
          <div style="width: 100%; height: 50px;"></div>
          <div style="width: 100%; margin-bottom: 15px;">
            <input type="text" data-role="tagsinput" class="form-control" id="blog_tages" placeholder="<?= $allLabelsArray[561] ?>">
          </div>
        <div style="float: right; margin-bottom: 25px;">
          <button class="btn btn-sm" style="background: #C49A6C; color: white;" onclick="CreateBlog($(this))"> <i class="fa fa-spin fa-spinner" style="display: none;"></i><?= $allLabelsArray[498] ?></button>
        </div>
      </div>
    </div>
    
    <!-- end post -->
    <div class="brack_space"></div>
  </div>
</div>
<div class="modal" id="content_video_changer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[497] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="vid"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
        <input type="file" onchange="$(this).siblings('button').text($(this)[0].files[0].name);" style="display: none;" name="video" accept="video/*" id="single_video" class="btn btn-success">
        <button type="button" class="btn btn-success" style="max-width: 100%; overflow: hidden;" onclick="$(this).siblings('input[type=file]').click();"><?= $allLabelsArray[786] ?></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick=" previewIT($('#single_video'));"><i class="fa fa-spinner fa-spin" id="vid_pre" style="display: none;"></i> <?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="content_one_changer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
              <div class="error"></div>
        <textarea id="modal_content_one" class="form-control" style="height: 500px;"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_one_changer'),$('#content_one'),$('#btn_close1'));"><?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#content_one_changer').modal('toggle')"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="quote_changer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[562] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close2"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
              <div class="error"></div>
        <textarea id="modal_quote" class="form-control" style="height: 200px;"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#quote_changer'),$('#blockquote'),$('#btn_close2'));"><?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="content_two_changer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close3"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
              <div class="error"></div>
        <textarea id="modal_content_two" class="form-control" style="height: 500px;"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_two_changer'),$('#content_two'),$('#btn_close3'));"><?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="content_three_changer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close4"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
              <div class="error"></div>
        <textarea id="modal_content_three" class="form-control" style="height: 500px;"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_three_changer'),$('#content_three'),$('#btn_close4'));"><?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="content_four_changer" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close5"> <span aria-hidden="true">&times;</span> </button>
      </div>
      <div class="modal-body">
              <div class="error"></div>
        <textarea id="modal_content_four" class="form-control" style="height: 500px;"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_four_changer'),$('#content_four'),$('#btn_close5'));"><?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="dropzoneModel" tabindex="-1" style="background: rgba(0,0,0,.5);" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;" id="exampleModalLabel"><?= $allLabelsArray[548] ?></h5>
        <button type="button" style="margin-top: -27px;" class="close reset_drop_zone" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="error_drop"></div>
      <form class="modal-body dropzone" style="background: rgba(0,0,0,.1); border: 0; max-height: 300px; overflow: auto; border-radius: 20px;" action="<?= $cms_url ?>/ajax.php" id="my-awesome-dropzone">
      </form>
      <div class="modal-footer" style="border: 0; text-align: center; position: relative;">
        <!-- <button type="button" class="btn btn-secondary reset_drop_zone" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn btn-primary"  style="background: #8c6238; border: 0;" onclick="$('.dropzone').click();"><i class="fa fa-plus"></i> <?= $allLabelsArray[657] ?></button>
        <button type="button" class="btn btn-success" onclick="displayImages();"><?= $allLabelsArray[452] ?></button>
      </div>
    </div>
  </div>
</div>
  
  <div class="modal" id="gallery_video" tabindex="-1" role="dialog">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header" style="background: #8c6238;">
                    <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[497] ?></h5>
                    <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" onclick="$('input[name=videos]').val('');">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p class="gallery_error"></p>
                    <?php 
                     $video_dir1    = 'community/uploads/gallery/';
                    $video_dir    = 'uploads/gallery/';
                    $video_array = scandir($video_dir1);
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
                          <form id="single_video_f">
                          <video file-name="uploads/gallery/<?= $videos[$i] ?>" class="blogvideo" src="<?= $cms_url.$video_dir.$videos[$i] ?>" controls="" __idm_id__="720368641" width="750" height="548"></video>
                          </form>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="$('#sibgle_video_preview').attr('src',$('#gallery_video .video_item .active').siblings('form').children('video').attr('src')); $(this).siblings('button').click(); $('input[name=video]').val($('#gallery_video .video_item .active').siblings('form').children('video').attr('file-name')); $('#single_video').val(); $('#single_video_f')[0].reset(); $('#remove_vid_btn').hide();"><?= $allLabelsArray[452] ?></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('input[name=videos]').val('');"><?= $allLabelsArray[174] ?></button>
                  </div>
                </div>
              </div>
            </div>

<div class="modal" id="content_header" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[493] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="header_content_close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label><?= $allLabelsArray[494] ?></label>
                <input type="text" name="blog_title" class="form-control">
              </div>
              <div class="form-group">
                <label><?= $allLabelsArray[495] ?></label>
                <textarea name="blog_desc" class="form-control"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="saveHeadContent();"><?= $allLabelsArray[452] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
          </div>
        </div>
      </div>

<div class="modal" id="error_model" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $allLabelsArray[563] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="gallery_image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #8c6238;">
        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[540] ?></h5>
        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height: 300px !important; overflow: auto;">
        <p class="gallery_error"></p>
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
          <?php for ($i=0; $i < count($videos); $i++) { ?>
          <div class="video_item col-lg-4">
            <i class="fa fa-check"></i>
            <img file-name="uploads/gallery/<?= $videos[$i] ?>" src="<?= $cms_url.$video_dir.$videos[$i] ?>" />
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="GalleryImagesForImageSlider();"><?= $allLabelsArray[452] ?></button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal com_not" tabindex="-1" role="dialog" style="background: rgba(0,0,0,.3);">
        <div role="document" class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header text-center" style="background: #92683e;">
                    <i aria-hidden="true" style="font-size: 128px;color: #fff;" class="fa fa-smile-o"></i>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.com_not').slideUp();">
                <span aria-hidden="true">×</span>
              </button>
            <div></div></div>
            <div class="modal-body">
              <p style="text-align: center;font-size: 36px;color: green;font-style: italic;"><?= $allLabelsArray[417] ?></p><p style="text-align: center;font-size: 15px;color: #484848;/*! font-style: italic; */"><?= $allLabelsArray[418] ?></p>
            </div>
            <div class="modal-footer" style="/*! border-top: 0; */border: 0;text-align: center;">
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').slideUp();" style="width: 150px;background: #92683e;color: #fff;"><?= $allLabelsArray[5] ?></button>
            </div>
          </div>
        </div>
      </div>

<form id="create_blog">
    <input type="hidden" name="title">
    <input type="hidden" name="description">
    <input type="hidden" name="content_one" class="content_one" hidden>
    <input type="hidden" name="content_two" class="content_two" hidden>
    <input type="hidden" name="quote" class="blockquote" hidden>
    <input type="hidden" name="content_three" class="content_three" hidden>
    <input type="hidden" name="content_four" class="content_four" hidden>
    <input type="hidden" name="slider_images" value="" hidden>
    <input type="hidden" name="video" value="" hidden>
    <input type="hidden" name="slug" value="" hidden>
    <input type="hidden" name="type" hidden value="">
    <input type="hidden" name="display_type" hidden value="">
    <input type="hidden" name="tages" hidden>
    <input type="hidden" name="lang" value="<?= $_GET['lang'] ?>">
    <input type="hidden" name="category" hidden>
</form>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="<?= $cms_url ?>/assets/dropzone/dropzone.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.0/tinymce.min.js" integrity="sha512-GVA/pyUF3G/N6U2o0AdSx02izOM963T6wsJPrJpGLApeIVWtaGDeN7eV/bmlkg2CC1Z+pHt3nQmaXic79mkHwg==" crossorigin="anonymous"></script> -->
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
  function ChangePhoto(sel){
    $("#image_list .full_size").fadeOut(function(){
      $(this).attr("src",sel.attr("src"));
      var img = $("#image_list .full_size").height();
      if(img < 548){
        $("#image_list .full_size").css("margin-top",(200 - (img / 2)));
      }else{
        $("#image_list .full_size").css("margin-top",0);
      }
      $(this).fadeIn();
    });
  }
  function SelectCategory(){
    $(".multi-select .tag").each(function(){
      var getItem = $.trim($(this).children("span").text());
      $("#category-form li").each(function(){
        if($.trim($(this).children("span").text()) == getItem){
          $(this).attr("class","active");
        }
      });
    });
    $("#category-form").modal();
  }

$(".tages_list li").click(function(){
    $(this).toggleClass("active");
});
var upload_photo = null;
var total_images = null;
    var images_path = [];

    $("#gallery_video .video_item i").click(function(){
          $("#gallery_video .video_item i").removeClass("active");
          $("#gallery_video .video_item i").css("color","#ddd");
          $(this).addClass("active");
          $(this).css("color","#000");
        });

  $("#gallery_image .video_item i").click(function(){
        var gallery = 0;
        var upload = 0;
        $("#gallery_image .video_item").each(function(){
          if($(this).children("i").hasClass("active")){
            gallery++;
          }
        });
        if(total_images != null){
          upload = total_images.files.length;
        }
        if(!$(this).hasClass('active') && (gallery + upload) >= 4){
          $("#gallery_image .gallery_error").attr("class","gallery_error alert alert-danger");
          $("#gallery_image .gallery_error").html("<?= $allLabelsArray[585] ?>");
          $("#gallery_image .modal-body").scrollTop(0);
          setTimeout(function(){
            $("#gallery_image .gallery_error").attr("class","gallery_error");
            $("#gallery_image .gallery_error").html("");
          },5000);
        }else{
          if($(this).hasClass("active")){
            $(this).removeClass("active");
              $(this).css("color","#ddd");
          }else{
              if($("#gallery_image .video_item .active").length >= 4){
                  $("#gallery_image .gallery_error").attr("class","gallery_error alert alert-danger");
                  $("#gallery_image .gallery_error").text("<?= $allLabelsArray[586] ?>");
                  setTimeout(function(){
                    $("#gallery_image .gallery_error").attr("class","gallery_error");
                    $("#gallery_image .gallery_error").text("");
                  },3000);
              }else{
                  $("#gallery_image .gallery_error").attr("class","gallery_error");
                  $("#gallery_image .gallery_error").text("");
                  $(this).addClass("active");
                  $(this).css("color","#000");
              }
          }
      }
    });

  setTimeout(function (){
          $('.js-example-basic-multiple').select2({
            placeholder: "<?= $allLabelsArray[567] ?>",
          });

          $("#my-awesome-dropzone").dropzone({
          maxFiles: 4,
          addRemoveLinks: true,
          acceptedFiles:'image/*',
          timeout: 180000,
          init: function () {
              var myDropzone = this;

              var defaultImages = [
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/toa-heftiba-686278-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/nadia-valkouskaya-694805-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/thought-catalog-462302-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/fuyong-hua-274676-unsplash-1000x675.jpg'
              ];
              // Update selector to match your button
              this.on('addedfile', function (file, xhr, formData) {
                  total_images = myDropzone;
              });
              this.on('removedfile', function (file, xhr, formData){
                  total_images = myDropzone;
              });

              $("button.reset_drop_zone").click(function() {
                // myDropzone.removeAllFiles();
                // for (var i = 0; i < defaultImages.length; i++) {
                //   $("#image_list a:eq("+i+") img").attr("src",defaultImages[i]);
                // }
              });
          }
        });
        },1000);

  $('.js-example-basic-multiple').select2({
          placeholder: "Select blog category.",
        });
        function videoModel(){
          $('#content_video_changer').modal();
        }

        function content_header(value){
          $("#content_header").modal();
          $("#content_header input[name=blog_title]").val($("h1.title span:first").text());
          $("#content_header textarea[name=blog_desc]").val($(".post_subtitle_text").text());
        }

        function saveHeadContent(){
          $("#header_content_close").click();

          $("h1.title span:first").text($("#content_header input[name=blog_title]").val());
          $("input[name=title]").val($("#content_header input[name=blog_title]").val());
          
          $(".post_subtitle_text").text($("#content_header textarea[name=blog_desc]").val());
          $("input[name=description]").val($("#content_header textarea[name=blog_desc]").val());
          
        }

        function previewIT(select) {
        var reader = new FileReader();
        if(select.val() == ""){
          $("#vid_pre").hide();
        }else{
          $("#vid_pre").show();
        }
        reader.onload = function(){
          var output = document.getElementById('sibgle_video_preview');
          output.src = reader.result;
          $("#vid_pre").hide();
          $("#vid").click();
          $('#btn_close7').click();
          $("#remove_vid_btn").show();
          $("input[name=videos]").val("");
          $(".video_item i").removeClass("active").css("color","#ddd");
        };
        reader.readAsDataURL(select[0].files[0]);

      };

      function RemoveVideo(){
              $("#blogvideo").attr("src","<?= $defaultVideo ?>");
              $("#remove_vid_btn").hide();
              $("#btn_close6").click();
              $("#sibgle_video_preview").val();
            }

        function quote(value){
             $("#quote_changer .error").attr("class","error");
          $("#quote_changer .error").text("");

            $('#quote_changer').modal();
            $('#modal_quote').val(value);
            if (editor_content_quote) { editor_content_quote.destroy(true); }
            editor_content_quote = CKEDITOR.replace('modal_quote');

              $("#quote_changer .btn-primary").click(function(){
                $("#quote_changer .close").click();
                $("#blockquote").html(editor_content_quote.getData());
                $("#create_blog input[name=quote]").val(editor_content_quote.getData());
              });
          }

            $('#dropzoneModel').on('hidden.bs.modal', function () {
              displayImages();
            });
          function displayImages(){
            images_path = [];
            if(total_images != null && total_images.files.length > 0){
              var defaultImages = [
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/toa-heftiba-686278-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/nadia-valkouskaya-694805-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/thought-catalog-462302-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/fuyong-hua-274676-unsplash-1000x675.jpg'
              ];

              var gallery_img_len = $("#gallery_image .active").length;
              var file_img_len = 0;
              if(total_images != null){
                file_img_len = total_images.files.length;
              }
              var total_len = gallery_img_len + file_img_len;

              if(total_len > 4){
                $("#dropzoneModel .error_drop").attr("class","error_drop alert alert-danger");
                if(gallery_img_len > 0){
                  $("#dropzoneModel .error_drop").html("<?= $allLabelsArray[690] ?>.<br><?= $allLabelsArray[790] ?> "+gallery_img_len+" <?= $allLabelsArray[791] ?> "+file_img_len+" <?= $allLabelsArray[792] ?>.");
                }else{
                  $("#dropzoneModel .error_drop").html("<?= $allLabelsArray[690] ?>");
                }
                $("#dropzoneModel .modal-body").scrollTop(0);
                setTimeout(function(){
                  $("#dropzoneModel .error_drop").attr("class","error_drop");
                  $("#dropzoneModel .error_drop").html("");
                },5000);
              }else{
                $("#dropzoneModel .error_drop").attr("class","error_drop");
                $("#dropzoneModel .error_drop").html("");
                if(file_img_len > 0){
                  upload_photo = total_images;
                  for (var i = 0; i < file_img_len; i++) {
                    images_path.push(total_images.files[i].dataURL);
                  }
                }
                if(gallery_img_len > 0){
                  var index = 0;
                  for (var i = file_img_len; i < 4; i++) {
                    images_path.push($("#gallery_image .active:eq("+index+")").siblings("img").attr("src"));
                    index++;
                  }
              }
              // if(images_path.length < 4){
              //   for (var i = images_path.length; i < 4; i++) {
              //     images_path.push(defaultImages[i]);
              //   }
              // }
              $("#image_list .img_btn").html("");
          for (var i = 0; i < images_path.length; i++) {
            if(typeof images_path[i] != 'undefined'){
                  $("#image_list .img_btn").append('<img onclick="ChangePhoto($(this));" src="'+images_path[i]+'">');

          }}
          if($("#image_list .img_btn").html() != ""){
            $("#image_list .img_btn img:first").click();
          }else{
            $("#image_list .full_size").attr("src","");
          }
              $("#dropzoneModel .close").click();
              }
              
          }
          }

          function GalleryImagesForImageSlider(){
            images_path = [];
            var defaultImages = [
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/toa-heftiba-686278-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/nadia-valkouskaya-694805-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/thought-catalog-462302-unsplash-1000x667.jpg',
                'https://jellywp.com/theme/disto/demo/wp-content/uploads/2018/11/fuyong-hua-274676-unsplash-1000x675.jpg'
              ];

              var gallery_img_len = $("#gallery_image .active").length;
              var file_img_len = 0;
              if(total_images != null){
                file_img_len = total_images.files.length;
              }
              var total_len = gallery_img_len + file_img_len;

              if(total_len > 4){
                $("#gallery_image .gallery_error").attr("class","gallery_error alert alert-danger");
                if(file_img_len > 0){
                  $("#gallery_image .gallery_error").html("<?= $allLabelsArray[690] ?>.<br><?= $allLabelsArray[790] ?> "+gallery_img_len+" <?= $allLabelsArray[791] ?> "+file_img_len+" <?= $$allLabelsArray[792] ?>.");
                }else{
                  $("#gallery_image .gallery_error").html("<?= $allLabelsArray[690] ?>");
                }
                $("#gallery_image .gallery_error").html("<?= $allLabelsArray[690] ?><br><?= $allLabelsArray[790] ?> "+gallery_img_len+" <?= $allLabelsArray[791] ?> "+file_img_len+" <?= $allLabelsArray[792] ?>.");
                $("#gallery_image .modal-body").scrollTop(0);
                setTimeout(function(){
                  $("#gallery_image .gallery_error").attr("class","gallery_error");
                  $("#gallery_image .gallery_error").html("");
                },5000);
              }else{
                $("#gallery_image .gallery_error").attr("class","gallery_error");
                $("#gallery_image .gallery_error").html("");
                if(gallery_img_len > 0){
                $("#gallery_image .active").each(function(index){
                  images_path.push($(this).siblings("img").attr("src"));
                });
              }
              if(file_img_len > 0){
                var index = 0;
                for (var i = gallery_img_len; i < 4; i++) {
                  if(total_images.files[index]){
                    images_path.push(total_images.files[index].dataURL);
                  }
                  index++;
                }
              }
              // if(images_path.length < 4){
              //   for (var i = images_path.length; i < 4; i++) {
              //     images_path.push(defaultImages[i]);
              //   }
              // }

              $("#image_list .img_btn").html("");
          for (var i = 0; i < images_path.length; i++) {
            if(typeof images_path[i] != 'undefined'){
                  $("#image_list .img_btn").append('<img onclick="ChangePhoto($(this));" src="'+images_path[i]+'">');

          }}
           if($("#image_list .img_btn").html() != ""){
            $("#image_list .img_btn img:first").click();
          }else{
            $("#image_list .full_size").attr("src","");
          }
              $("#gallery_image .close").click();
              }
          }

          $("#gallery_image .video_item i").click(function(){
            var gallery = $("#gallery_image .video_item .active").length;
            var upload = 0;
            if(total_images != null){
              upload = total_images.files.length;
            }
            
            if($(this).hasClass("active") && (gallery + upload) >= 4){
              $("#gallery_image .gallery_error").attr("class","gallery_error");
              $("#gallery_image .gallery_error").text("<?= $allLabelsArray[691] ?>");
              $(this).removeClass("active");
              $(this).css("color","#ddd");
            }else{
              $("#gallery_image .gallery_error").attr("class","gallery_error");
              $("#gallery_image .gallery_error").text("");
              if($(this).hasClass("active")){
                console.log('active');
                $(this).removeClass("active");
                $(this).css("color","#ddd");
              }else{
                console.log('in active');
                $(this).addClass("active");
                $(this).css("color","#000");
              }
            }
        });

        function content_one(value){
            $("#content_one_changer .error").attr("class","error");
          $("#content_one_changer .error").text("");

            $('#content_one_changer').modal();
            $('#modal_content_one').val(value);
            if (editor_content_one) { editor_content_one.destroy(true); }
            editor_content_one = CKEDITOR.replace( 'modal_content_one' );

              $("#content_one_changer .btn-primary").click(function(){
                $("#content_one_changer .close").click();
                $("#content_one").html(editor_content_one.getData());
                $("#create_blog input[name=content_one]").val(editor_content_one.getData());
              });
        }

          function content_two(value){
            $("#content_two_changer .error").attr("class","error");
          $("#content_two_changer .error").text("");

            $('#content_two_changer').modal();
            $('#modal_content_two').val(value);
           if (editor_content_two) { editor_content_two.destroy(true); }
            editor_content_two = CKEDITOR.replace('modal_content_two');

              $("#content_two_changer .btn-primary").click(function(){
                $("#content_two_changer .close").click();
                $("#content_two").html(editor_content_two.getData());
                $("#create_blog input[name=content_two]").val(editor_content_two.getData());
              });
          }

          function content_three(value){
            $("#content_three_changer .error").attr("class","error");
          $("#content_three_changer .error").text("");

            $('#content_three_changer').modal();
            $('#modal_content_three').val(value);
            if (editor_content_three) { editor_content_three.destroy(true); }

            editor_content_three = CKEDITOR.replace('modal_content_three');
          

              $("#content_three_changer .btn-primary").click(function(){
                $("#content_three_changer .close").click();
                $("#content_three").html(editor_content_three.getData());
                $("#create_blog input[name=content_three]").val(editor_content_three.getData());
              });
          }

          function content_four(value){
            $("#content_four_changer .error").attr("class","error");
          $("#content_four_changer .error").text("");

            $('#content_four_changer').modal();
            $('#modal_content_four').val(value);
            if (editor_content_four) { editor_content_four.destroy(true); }
            editor_content_four = CKEDITOR.replace('modal_content_four');

              $("#content_four_changer .btn-primary").click(function(){
                $("#content_four_changer .close").click();
                $("#content_four").html(editor_content_four.getData());
                $("#create_blog input[name=content_four]").val(editor_content_four.getData());
              });
          }

          function get_from_tinymce(modal,sel1, sel2){
            if(tinyMCE.activeEditor.getContent().includes("<img")){
            modal.find(".error").attr("class","error alert alert-danger");
            modal.find(".error").text("<?= $allLabelsArray[568] ?>");
            modal.scrollTop(0);
            setTimeout(function(){
              modal.find(".error").attr("class","error");
              modal.find(".error").text("")
            },3000);
          }else{
            sel1.html(tinyMCE.activeEditor.getContent());
            $("."+$(sel1).attr("id")).val(tinyMCE.activeEditor.getContent());
            $("."+$(sel1).attr("id")).val($("."+$(sel1).attr("id")).val().replace("'",""));
            $("."+$(sel1).attr("id")).val($("."+$(sel1).attr("id")).val().replace('"',""));
            sel2.click();
          }
        }

        function ShowMessage(type,msg,icon){
          if(type == "error"){
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

          setTimeout(function(){
            $("#display_error").html("");
            $("#display_error").hide();
          },5000);
          
        }

        function CreateBlog(sel){
          var value = [];
          $(".tages_list .active").each(function(){
            value.push($(this).attr("data-id"));
          });

          $("#create_blog input[name=category]").val(value.join(","));
          $("#create_blog input[name=tages]").val($("#blog_tages").val());
          $("#create_blog input[name=display_type]").val($("input[name=getType]").val());
          $("#create_blog input[name=type]").val("video-image-"+$("input[name=getType]").val());
          $("#create_blog input[name=video]").val($("#gallery_video .active").siblings("form").children("video").attr("file-name"));
          var link = $("input[name=title]").val();
          var final = '';
          link = link.toLowerCase();
          if($("#create_blog input[name=lang]").val() == "" || $("#create_blog input[name=lang]").val() == "english"){
            link = link.replace(/[^a-zA-Z0-9\s+]/g, '');
            final = link.replace(/\s+/g, '-');
          }else{
            final = link.replace(" ","-");
            final = link.replace("?","");
          }

          $("#create_blog input[name=slug]").val(final);

          var total = 0;
          if(upload_photo != null && upload_photo.files.length > 0){
            for (var i = 0; i < upload_photo.files.length; i++) {
              total += upload_photo.files[i].size;
            }
          }

          var images = [];

          $("#gallery_image .active").each(function(){
            images.push($(this).siblings("img").attr("file-name")); 
          });

          $("input[name=slider_images]").val(images.join(","));

          var FileSize = 0;
          if($("#single_video").val() != ""){
            FileSize = document.getElementById("single_video").files[0].size / 1024 / 1024;
          }
          var totalSize = total / 1024 / 1024;
          if($("input[name=display_type]").val() == ""){

            ShowMessage("error","<?= $allLabelsArray[569] ?>","");

          }else if($.inArray($("input[name=display_type]").val(),["news","blog"]) == -1){

            ShowMessage("error","<?= $allLabelsArray[570] ?>","");

          }else if($("input[name=category]").val() == ""){

            ShowMessage("error","<?= $allLabelsArray[609] ?>","");

          }else if($("input[name=title]").val() == ""){

            ShowMessage("error","<?= $allLabelsArray[610] ?>","");

          }else if($("input[name=description]").val() == ""){

            ShowMessage("error","<?= $allLabelsArray[611] ?>","");

          }else if($("#create_blog input[name=video]").val() == "" && $("#single_video").val() == ""){

            ShowMessage("error","Video is required!","");

          }else if($("#single_video").val() != "" && FileSize > 100){
            
            ShowMessage("error","<?= $allLabelsArray[546] ?>","");

          }else if((upload_photo == null || upload_photo.files.length < 1) && $("#gallery_image .active").length < 1){
            
            ShowMessage("error","<?= $allLabelsArray[576] ?>","");

          }else if((upload_photo == null || upload_photo.files.length > 4) && $("#gallery_image .active").length > 4){
            
            ShowMessage("error","<?= $allLabelsArray[690] ?>","");

          }else if(upload_photo != null && totalSize > 100){

            ShowMessage("error","<?= $allLabelsArray[765] ?>","");

          }else if($("input[name=content_one]").val().includes("<img")){

            ShowMessage("error","<?= $allLabelsArray[577] ?>","");

          }else if($("input[name=quote]").val().includes("<img")){

            ShowMessage("error","<?= $allLabelsArray[578] ?>","");

          }else if($("input[name=content_two]").val().includes("<img")){

            ShowMessage("error","<?= $allLabelsArray[579] ?>","");
         
          }else if($("input[name=content_three]").val().includes("<img")){
           
            ShowMessage("error","<?= $allLabelsArray[580] ?>","");
          
          }else if($("input[name=content_four]").val().includes("<img")){

            ShowMessage("error","<?= $allLabelsArray[581] ?>","");
          
          }else if($("input[name=content_one]").val() == "" && $("input[name=content_two]").val() == "" && $("input[name=content_three]").val() == "" && $("input[name=content_four]").val() == ""){

            ShowMessage("error","<?= $allLabelsArray[583] ?>","");
            
          }else if($("input[name=tages]").val() == ""){

            ShowMessage("error","<?= $allLabelsArray[587] ?>","");
         
          }else{
              var form = $('#create_blog')[0];
              var formData = new FormData(form);
              if($("#single_video").val() != ""){
                formData.append('single_video',document.getElementById("single_video").files[0]);
              }

              if(upload_photo != null && upload_photo.files.length > 0){
                for (let i = 0; i < upload_photo.files.length; i++) {
                    formData.append('multi_images[]',upload_photo.files[i]);
                }
              }

              $.ajax({
                  type: "POST",
                  url: "<?= $cms_url ?>ajax.php?h=CreateUpdateImageVideoBlog&lang="+$("input[name=lang]").val(),
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
                      if(res.error){

                        ShowMessage("error",res.error,"");
                      
                      }else if(res.success){

                        ShowMessage("","<?= $allLabelsArray[634] ?>","fa fa-smile-o");

                        setTimeout(function(){
                          if($("input[name=display_type]").val() == "news"){
                                    window.location.href = '<?= $cms_url ?>my-news/<?= $_GET['lang'] ?>';
                                }else{
                                    window.location.href = '<?= $cms_url ?>my-blog/<?= $_GET['lang'] ?>';
                                }
                
                        },2000);

                      }else{

                        ShowMessage("error","<?= $allLabelsArray[588] ?>","");

                      }
                  },error: function(e){
                      sel.children("i").hide();
                      console.log(e)
                  }
              });
          }
        }
      </script>