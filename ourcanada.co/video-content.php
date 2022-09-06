<?php

$page = 'inner';
include_once( "user_inc.php" );
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

        <!-- Favicon-->

        <?php include("community/includes/style.php"); ?>

        <link href="<?= $cms_url ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= $cms_url ?>assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />
		<style>
    	.modal-header .close{
			margin-top: unset !important;
		}
		</style>
        <style type="text/css">
        .fa-check{
		z-index: 1111;
	}
        	.bootstrap-tagsinput .tag {
			  background: red;
			  
			}
			.bootstrap-tagsinput .tag [data-role="remove"]:after {
		       content: " x";
		       padding: 0px 2px;
		    }
        	.multi-select{
        		position: relative;
        		height: 50px;
        		border: 1px solid #92683E;
        		border-radius: 5px;
        		overflow: auto;
        	}
        	.multi-select .tag{
        		float: left;
        		margin-top: 9px;
        		padding: 0 10px;
        		background: red;
        		margin-right: 10px;
        		border-radius: 5px;
        	}
        	.multi-select .tag i,.multi-select .tag span{
        		color: #fff;
        	}
        	#category-form ul{
					list-style: none;
					padding: 0;
				}
				#category-form li{
					padding: 10px;
					cursor: pointer;
					transition: all .30s;
				}
				#category-form i{
					margin-right: 10px;
				}
				#category-form li:hover{
					background: rgba(0,0,0,.1);
				}
				#category-form .active{
					background: rgba(0,0,0,.1);
					font-weight: bold;
				}
				#category-form .active i{
					color: green;
				}
				.video_item{
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
				.video_item video{
					width: 100%;
					height: 100%;
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
        </style>

    </head>
<?php 
	$defaultVideo = $main_domain.'/superadmin/uploads/videos/vid-25th-2020023858PM.MP4';
	$defaultEmbed = 'https://www.youtube.com/embed/wnfWhoQHWOE';
?>


<body class="mobile_nav_class jl-has-sidebar">

    <div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">

        <div class="options_layout_container full_layout_enable_front"> 


<?php include("community/includes/header.php"); ?>
<div class="jl_home_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8  loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
									<div id="display_error"></div>
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> 
												
												<div class="form-group" style="margin-top: 60px;">
										    	<div class="row">
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
										    </div>
										    <h1 class="single_post_title_main title">
													<span id="title_display"><?= $getRow['title'] ?></span>
													<span class="editSpan">
														<a class="btn btn-sm editButton" onclick="ShowHeader($('#title_display'),$('#description_display'));"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
												</h1>
												<p class="post_subtitle_text" id="description_display"><?= $getRow['description'] ?></p>
											</span></div>
											<div class="single_content_header jl_single_feature_below">
												<div>
													<span class="editSpan">
														<a class="btn btn-sm editButton" onclick="$('#video-gallery-form').modal()"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[492] ?></a>
														<a class="btn btn-sm editButton" onclick="ShowVideo();"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
													<div class="image-post-thumb jlsingle-title-above">
														<?php 
														$video_local = $getRow['video'];
														if(count(explode('uploads/gallery/', $video_local)) > 1){
												          $img_path = $cms_url.'/'.$video_local;
												        }else{
												          $img_path = $cms_url."/uploads/videos/".$video_local;
											        	}
														?>
														<video class="blogvideo" id="blogvideo" src="<?php if(empty($video_local)){echo $defaultVideo;}else{echo $img_path;} ?>" controls="" __idm_id__="720368641" width="750" height="400"></video>
													</div>
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
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Quote',$('#blockquote'),'quote');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<blockquote>
													<div style="text-align: center; color: #000;" id="blockquote"><b><?php if(empty($getRow['blockquote'])){}else{echo $getRow['blockquote'];} ?></b></div>
												</blockquote>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_two'),'content_two');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_two"><?php if(empty($getRow['content_two'])){}else{echo $getRow['content_two'];} ?></div>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_three'),'content_three');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_three"><?php if(empty($getRow['content_three'])){}else{echo $getRow['content_three'];} ?></div>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEbmedVideo();"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p>
													<div class="fluidvids" style="padding-top: 56.25%;"><iframe id="video_iframe" src="<?php if(empty($getRow['embed'])){echo $defaultEmbed;}else{echo $getRow['embed'];} ?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" data-fluidvids="loaded" width="560" height="315" frameborder="0"></iframe></div>
												</p>
											</div>
											
											<div style="margin-top: 45px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="ShowEditor('Content',$('#content_four'),'content_four');"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<div style="text-align: justify;" id="content_four"><?php if(empty($getRow['content_four'])){}else{echo $getRow['content_four'];} ?></div>
											</div>
										</div>
										<div style="width: 100%; height: 50px;"></div>
          								<div style="width: 100%; margin-bottom: 15px;">
								            <input type="text" data-role="tagsinput" id="blog_tages" value="<?= $getRow['tages'] ?>" class="form-control" placeholder="<?= $allLabelsArray[561] ?>">
								          </div>
										<div style="float: right; margin-bottom: 25px;">
											<button class="btn btn-sm" style="background: #C49A6C; color: white;" onclick="UpdateContent($(this));"><i class="fa fa-spin fa-spinner" style="margin-right: 5px; display: none;"></i><?= $allLabelsArray[536] ?></button>
										</div>
									</div>
								</div>
								<!-- end post -->
								<div class="brack_space"></div>
							</div>
						</div>
						<?php include_once 'sidebar.php'; ?>

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
		      		<button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
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
			      		<input type="file" name="video" accept="video/*" style="display: none;">
			      		<button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><i style="display: none;" class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[543] ?></button>
			      	</form>
		      	</div>
		      	<div class="modal-footer" style="border: 0;"></div>
		    </div>
	  	</div>
	</div>

	<!-- Embed Form -->
	<div class="modal" id="embed-form" tabindex="-1" role="dialog">
	  	<div class="modal-dialog modal-md" role="document">
		    <div class="modal-content">
		      	<div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[547] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
			          	<span aria-hidden="true">×</span>
			        </button>
		      	</div>
		      	<div class="modal-body">
		      		<div id="embed-error"></div>
		      		<form class="form-group">
		      			<label><?= $allLabelsArray[547] ?></label>
		      			<input type="url" name="embed" value="<?= $getRow['embed'] ?>" class="form-control" required>
		      		</form>
		      	</div>
		      	<div class="modal-footer" style="border: 0;">
		      		<button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
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
		        	<button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
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
		        	<button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
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
		        	<button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
		        	<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
		      	</div>
		    </div>
		</div>
	</div>

	<form id="blog-form">
		<div class="c_one" style="display: none;"><?= $getRow['content_one'] ?></div>
	    <div class="c_two" style="display: none;"><?= $getRow['content_two'] ?></div>
	    <div class="c_three" style="display: none;"><?= $getRow['content_three'] ?></div>
	    <div class="c_four" style="display: none;"><?= $getRow['content_four'] ?></div>
	    <div class="c_quote" style="display: none;"><?= $getRow['quote'] ?></div>
		<input type="hidden" hidden name="id" value="<?= $getRow['id'] ?>">
		<input type="hidden" hidden name="category" value="<?= $getRow['category'] ?>">
		<input type="hidden" hidden name="title" value="<?= $getRow['title'] ?>">
		<input type="hidden" hidden name="old_title" value="<?= $getRow['title'] ?>">
		<input type="hidden" hidden name="slug" value="<?= $getRow['slug'] ?>">
		<input type="hidden" hidden name="description" value="<?= $getRow['description'] ?>">
		<input type="hidden" hidden name="content_one">
		<input type="hidden" hidden name="quote">
		<input type="hidden" hidden name="content_two">
		<input type="hidden" hidden name="content_three">
		<input type="hidden" hidden name="content_four">
		<input type="hidden" hidden name="lang" value="<?= getCurLang($langURL,true); ?>">
		<input type="hidden" hidden name="video" value="<?= $getRow['video'] ?>">
		<input type="hidden" hidden name="display_type" value="<?= $page_url[1] ?>">
		<input type="hidden" hidden name="embed" value="<?= $getRow['embed'] ?>">
		<input type="hidden" hidden name="tages" value="<?= $getRow['tages'] ?>">
	</form>
    <canvas id="thecanvas" style="display: none;">
    </canvas>
<?php include("community/includes/footer.php"); ?>

<?php include("community/includes/script.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
<!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.0/tinymce.min.js" integrity="sha512-GVA/pyUF3G/N6U2o0AdSx02izOM963T6wsJPrJpGLApeIVWtaGDeN7eV/bmlkg2CC1Z+pHt3nQmaXic79mkHwg==" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>


<script type="text/javascript">
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
    $("#blog-form input[name=content_one]").val($(".c_one").html());
    $("#blog-form input[name=content_two]").val($(".c_two").html());
    $("#blog-form input[name=content_three]").val($(".c_three").html());
    $("#blog-form input[name=content_four]").val($(".c_four").html());
    $("#blog-form input[name=quote]").val($(".c_quote").html());
  	setTimeout(function(){
  		getThumbnail();
  	},1000);
  });



	// window.onload = function (){
 //   getThumbnail();
 //  };

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

	  console.log(VideoThumbnail);
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
	    var img = document.getElementById('thumbnail_img');
	    video.preload = 'metadata';
	    video.muted = true;
	    video.playsInline = true;
	    video.play();
	    setTimeout(function(){
	    	video.pause();
	    },500);
	    video.addEventListener('pause', function(){
	        draw( video, thecanvas);
	        video.currentTime = 0;
	    }, false);
	}

$(".tages_list li").click(function(){
    $(this).toggleClass("active");
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
			        	$("#blogvideo").attr("src",e.target.result);
			        	$("#video-gallery-form .video_item").removeClass("active_item");
			        	$("#video-form .close").click();
			        	getThumbnail();
			        }

			        reader.readAsDataURL(input.files[0]);
				}

	    	}
		});

	}

	function ShowEbmedVideo(){
		$("#embed-form").modal();

		$("#embed-form .btn-primary").click(function(){
			var value = $("#embed-form input[type=url]").val();

			var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;

			if(value == ""){
				$("#blog-form input[name=embed]").val("");
				$("#embed-form .close").click();
				// $("#embed-error").attr("class","alert alert-danger");
				// $("#embed-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> URL is required!");
			}else if(pattern.test(value) == false){
				$("#embed-error").attr("class","alert alert-danger");
				$("#embed-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[545] ?>");
			}else{
				$("#embed-error").attr("class","");
				$("#embed-error").html("");
				$("iframe").attr("src",value);
				$("#blog-form input[name=embed]").val(value);
				$("#embed-form .close").click();
			}
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
				$("#blog-form input[name="+input+"]").val("");
				$("#"+$(this).attr("content")).html("");
				$("#editor-modal .close").click();
				// $("#editor-error").attr("class","alert alert-danger");
				// $("#editor-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> Content can not be empty!");
			}
			// else if(contant.includes("<img")){
			// 	$("#editor-error").attr("class","alert alert-danger");
			// 	$("#editor-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> Image is not allowed!");
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
				$("#blogvideo").attr("src",$("#video-gallery-form .active_item video").attr("src"));
				$("#blog-form input[name=video]").val($("#video-gallery-form .active_item video").attr("file-name"));
				$("#video-gallery-form .close").click();
				getThumbnail();
			}
		});

		$('#category-form,#editor-modal,#header-modal,#embed-form,#video-form').on('hidden.bs.modal', function () {
			$("#category-error,#editor-error,#header-error,#embed-error,#video-error").attr("class","");
			$("#category-error,#editor-error,#header-error,#embed-error,#video-error").html("");
		});

		$("#category-form li").click(function(){
			$(this).toggleClass("active");
		});

		$("#category-form .btn-primary").click(function(){			
			if($("#category-form .active").length < 1){
				$("#category-error").attr("class","alert alert-danger");
				$("#category-error").html("<i class='fa fa-exclamation-triangle' style='margin-right: 10px;'></i> <?= $allLabelsArray[554] ?>");
			}else{
				$(".multi-select").html("");
				var active_cate_list = [];
				$("#category-form .active").each(function(){
					active_cate_list.push($(this).text());
					$(".multi-select").append(
						'<div class="tag">'+
							// '<i class="fa fa-close"></i>'+
							'<span>'+$(this).text()+'</span>'+
						'</div>'
					);
				});
				$("#category-error").attr("class","");
				$("#category-error").html("");

				$("#blog-form input[name=category]").val(active_cate_list.join(","));

				$("#category-form .close").click();
			}
		});

	});

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

	function UpdateContent(sel){
		getThumbnail();
		var value = [];
			
			$(".tages_list .active").each(function(){
			  value.push($(this).attr("data-id"));
			});


			
			$("#blog-form input[name=category]").val(value.join(","));
			
		$("#blog-form input[name=tages]").val($("#blog_tages").val());

		if($("#blog_tages").val() != '<?= $getRow['tages'] ?>'){
	        updateCheck = 1;
	      }

	      if(value.join(",") != '<?= $getRow['category'] ?>'){
	        updateCheck = 1;
	      }  

		if(updateCheck == 0){
			ShowMessage("","<?= $allLabelsArray[553] ?>","");
		}
		else if($("#blog-form input[name=category]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[554] ?>","");

		}else if($("#blog-form input[name=title]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[549] ?>","");

		}
		// else if(/^[a-zA-Z\s]*$/i.test($("#blog-form input[name=title]").val()) == false){
			
		// 	ShowMessage("","Only whitespaces & alphabets are allowed in title!","");
		
		// }
		else if($("#blog-form input[name=description]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[550] ?>","");

		}
		// else if($("#blog-form input[name=content_one]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=quote]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=content_two]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=content_three]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }else if($("#blog-form input[name=content_four]").val().includes("<img")){
			
		// 	ShowMessage("","Image is not allowed in content one!","");

		// }
		else if($("#blog-form input[name=content_one]").val() == "" && $("#blog-form input[name=content_two]").val() == "" && $("#blog-form input[name=content_three]").val() == "" && $("#blog-form input[name=content_four]").val() == ""){
			
			ShowMessage("","<?= $allLabelsArray[613] ?>","");

		}else if($("#blog-form input[name=embed]").val() == "" && $("#blog-form input[name=video]").val() == "" && $("#video-form input[type=file]").val() == ""){

			ShowMessage("","<?= $allLabelsArray[658] ?>","");

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
            if($("#video-form input[type=file]").val() != ""){
            	formData.append("videos",$("#video-form input[type=file]")[0].files[0]);
            }

            if(VideoThumbnail != null){
           		formData.append('thumbnail',VideoThumbnail);
            }

			$.ajax({
				type: "POST",
				url: "<?= $cms_url ?>ajax.php?h=CreateUpdateVideoBlog&lang=<?= getCurLang($langURL) ?>",
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