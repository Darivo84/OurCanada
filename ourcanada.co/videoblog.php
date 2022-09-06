<?php
$page = 'inner'; ?>
<?php include_once( "community/user_inc.php" ); ?>
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
    :root { --ck-z-default: 100; --ck-z-modal: calc( var(--ck-z-default) + 999 ); }
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
			  .editSpan{
				  float: unset !important;
			  }
</style>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<?php 
	$defaultVideo = $main_domain.'/superadmin/uploads/videos/vid-25th-2020023858PM.MP4';
	$defaultEmbed = 'https://www.youtube.com/embed/wnfWhoQHWOE';
?>
<div class="col-md-8 col-lg-offset-2  loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> 
												
												<div class="form-group" style="margin-top: 60px;">
										    	<div class="row">
									<div id="display_error"></div>
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
										    	<!-- <input type="text" class="form-control" style="height: 39.75px;" placeholder="Blog Description..." id="blog_desc"> -->
										    </div>
										    <h1 class="single_post_title_main title">
													<span><?= $allLabelsArray[500] ?></span>
													<span class="editSpan">
														<a class="btn btn-sm editButton" onclick="content_header($('#content_header').text())" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
												</h1>
												<p class="post_subtitle_text"><?= $allLabelsArray[559]; ?></p>
											</span></div>
											<div class="single_content_header jl_single_feature_below">
												<div>
													<span class="editSpan">
														<a class="btn btn-sm editButton" onclick="$('#gallery_video').modal();"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[492] ?></a>
														<a class="btn btn-sm editButton" onclick="$('#vid_file_uploader1').modal();" ><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
													</span>
													<div class="image-post-thumb jlsingle-title-above">
														<video class="blogvideo" id="blogvideo" src="<?= $defaultVideo ?>" controls="" __idm_id__="720368641" width="750" height="400"></video>
													</div>
												</div>
												
											</div>
										</div>
										<div class="post_content">
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_one($('#content_one').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_one"><?= $allLabelsArray[529] ?></p>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="quote($('#blockquote').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<blockquote>
													<p style="text-align: center;" id="blockquote"><b></b></p>
												</blockquote>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_two($('#content_two').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_two"></p>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_three($('#content_three').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_three"></p>
											</div>
											
											<div>
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="$('#vid_file_url').modal();"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p>
													<div class="fluidvids" style="padding-top: 56.25%;"><iframe id="video_iframe" src="<?= $defaultEmbed ?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" data-fluidvids="loaded" width="560" height="315" frameborder="0"></iframe></div>
												</p>
											</div>
											
											<div style="margin-top: 45px;">
												<span class="editSpan">
													<a class="btn btn-sm editButton" onclick="content_four($('#content_four').html())"><i class="fa fa-edit"></i>&nbsp;<?= $allLabelsArray[35] ?></a>
												</span>
												<p style="text-align: justify;" id="content_four"></p>
											</div>
										</div>
										<div style="width: 100%; height: 50px;"></div>
          								<div style="width: 100%; margin-bottom: 15px;">
								            <input type="text" data-role="tagsinput" id="blog_tages" class="form-control" placeholder="<?= $allLabelsArray[561] ?>">
								          </div>
										<div style="float: right; margin-bottom: 25px;">
											<button class="btn btn-sm" style="background: #C49A6C; color: white;" onclick="CreateBlog($(this));"><i class="fa fa-spin fa-spinner" style="margin-right: 5px; display: none;"></i><?= $allLabelsArray[498] ?></button>
										</div>
									</div>
								</div>
								<!-- end post -->
								<div class="brack_space"></div>
							</div>
						</div>
						<style type="text/css">
							.video_item{
								position: relative;
							}
							.video_item i{
								position: absolute;
								top: 0;
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
						</style>
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
						        		<video file-name="community/uploads/gallery/<?= $videos[$i] ?>" class="blogvideo" src="<?= $cms_url.$video_dir.$videos[$i] ?>" controls="" __idm_id__="720368641" width="750" height="400"></video>
							        </div>
						        	<?php } ?>
						        </div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="$('#blogvideo').attr('src',$('.video_item .active').siblings('video').attr('src')); $(this).siblings('button').click(); $('input[name=videos]').val($('.video_item .active').siblings('video').attr('file-name')); $('#video_upload_form')[0].reset(); $('#remove_vid_btn').hide(); getThumbnail();"><?= $allLabelsArray[452] ?></button>
						        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('input[name=videos]').val('');"><?= $allLabelsArray[174] ?></button>
						      </div>
						    </div>
						  </div>
						</div>

						<div class="modal" id="content_one_changer" tabindex="-1" role="dialog">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header" style="background: #8c6238;">
						        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[544] ?></h5>
						        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
        						<div class="error"></div>
						        <textarea id="modal_content_one" class="form-control" style="height: 500px;"></textarea>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_one_changer'),$('#content_one'), $('#btn_close1'));"><?= $allLabelsArray[452] ?></button>
						        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
						      </div>
						    </div>
						  </div>
						</div>

			<div class="modal" id="quote_changer" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[562] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close2">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
        			<div class="error"></div>
			        <textarea id="modal_quote" class="form-control" style="height: 200px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#quote_changer'),$('#blockquote'), $('#btn_close2'));"><?= $allLabelsArray[452] ?></button>
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
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close3">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
        			<div class="error"></div>
			        <textarea id="modal_content_two" class="form-control" style="height: 500px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_two_changer'),$('#content_two'), $('#btn_close3'));"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="content_three_changer" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;" >
			        <h5 class="modal-title" style="color: #fff; text-align: center;" ><?= $allLabelsArray[544] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;"  data-dismiss="modal" aria-label="Close" id="btn_close4">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
        			<div class="error"></div>
			        <textarea id="modal_content_three" class="form-control" style="height: 500px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"  onclick="get_from_tinymce($('#content_three_changer'),$('#content_three'),$('#btn_close4'));"><?= $allLabelsArray[452] ?></button>
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
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close5">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
        			<div class="error"></div>
			        <textarea id="modal_content_four" class="form-control" style="height: 500px;"></textarea>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="get_from_tinymce($('#content_four_changer'),$('#content_four'), $('#btn_close5'));"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="video_changer1" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[543] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close6">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <p><?= $allLabelsArray[62] ?></p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" id="remove_vid_btn" class="btn btn-danger" style="display: none; float: left;" onclick="RemoveVideo();">Remove Video</button>
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="$('#btn_close6').click(); $('#vid_file_uploader1').modal();"><?= $allLabelsArray[40] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[41] ?></button>
			      </div>
			    </div>
			  </div>
			</div>

			<div class="modal" id="vid_file_uploader1" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[543] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close7">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<form id="video_upload_form">
			      		<button type="button" class="btn btn-success" style="max-width: 100%; overflow: hidden;" onclick="$(this).siblings('input[type=file]').click();"><?= $allLabelsArray[786] ?></button>
			      		<input type="file" id="vid_name" onchange="$(this).siblings('button').text($(this)[0].files[0].name);" style="display: none;" class="btn btn-success" name="video_file_name" accept="video/*">
			      	</form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="setView($(this));"> <i class="fa fa-spin fa-spinner" style="display: none;"></i> <?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="modal" id="video_changer2" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[653] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close8">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <p><?= $allLabelsArray[62] ?></p>
			      </div>
			      <div class="modal-footer">
			        <button type="button" id="remove_embed_btn" class="btn btn-danger" style="display: none; float: left;" onclick="RemoveEbmed();">Remove Video</button>
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="$('#btn_close8').click(); $('#vid_file_url').modal();"><?= $allLabelsArray[40] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[41] ?></button>
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

			<div class="modal" id="vid_file_url" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header" style="background: #8c6238;">
			        <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[654] ?></h5>
			        <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close9">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<form id="embed_upload_form">
			      		<input type="text" id="vid_url" placeholder="Add video url" class="form-control">
			      		<span class="text-danger embedvideo-error"></span>
			      	</form>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;" onclick="embedd_upload();"><?= $allLabelsArray[452] ?></button>
			        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="modal" id="error_model" tabindex="-1" role="dialog">
			  <div class="modal-dialog modal-md" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title"><?= $allLabelsArray[415] ?></h5>
			        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
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
			        <!-- <button type="button" class="btn btn-primary"><?= $allLabelsArray[452] ?></button> -->
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
                <input type="hidden" name="embed" value="" hidden>
                <input type="hidden" name="videos" value="" hidden>
				<input type="hidden" name="slug" value="" hidden>
				<input type="hidden" name="display_type" hidden value="">
				<input type="hidden" name="type" hidden value="">
				<input type="hidden" name="lang" value="<?= $_GET['lang'] ?>">
				<input type="hidden" name="tages" hidden>
				<input type="hidden" name="category" hidden>
			</form>

			<canvas id="thecanvas" style="display: none;">
    </canvas>
			<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- <script src="https://cdn.ckeditor.com/ckeditor5/27.0.0/classic/ckeditor.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>

			<!-- <script src="https://cdn.tiny.cloud/1/0ocxmkvboxs6d2rytc74wz9cbl1a3wuivi9mjiy5gtcgev78/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.5.0/tinymce.min.js" integrity="sha512-GVA/pyUF3G/N6U2o0AdSx02izOM963T6wsJPrJpGLApeIVWtaGDeN7eV/bmlkg2CC1Z+pHt3nQmaXic79mkHwg==" crossorigin="anonymous"></script> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
			
			<script type="text/javascript">

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

window.onload = function (){
	getThumbnail();
  };

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
	        // video.currentTime = 0;
	    }, false);
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

				$(".video_item i").click(function(){
					$(".video_item i").removeClass("active");
					$(".video_item i").css("color","#ddd");
					$(this).addClass("active");
					$(this).css("color","#000");
				});

				setTimeout(function (){
		          $('.js-example-basic-multiple').select2({
		            placeholder: "<?= $allLabelsArray[567] ?>",
		          });
		        },1000);

				$('.js-example-basic-multiple').select2({
					placeholder: "<?= $allLabelsArray[567] ?>",
				});

		      	function setView(sel){
		      		if($("#vid_name").val() != ""){
				      	sel.children('i').show();
				      	var oFReader = new FileReader();
				        oFReader.readAsDataURL(document.getElementById("vid_name").files[0]);

				        oFReader.onload = function (oFREvent) {
				            document.getElementById("blogvideo").src = oFREvent.target.result;
				      		sel.children('i').hide();
				            $('#btn_close7').click();
				            $("#remove_vid_btn").show();
				            $("input[name=videos]").val("");
				            $(".video_item i").removeClass("active").css("color","#ddd");
							getThumbnail();
							setTimeout(function(){
								getThumbnail();
							},1000);
				        };
			    	}
		      	}

		      	function RemoveVideo(){
		      		$("#blogvideo").attr("src","<?= $defaultVideo ?>");
		      		$("#remove_vid_btn").hide();
		      		$("#btn_close6").click();
		      		$("#video_upload_form")[0].reset();
		      	}

		      	function RemoveEbmed(){
		      		$("#video_iframe").attr("src","<?= $defaultEmbed ?>");
		      		$("#remove_embed_btn").hide();
		      		$("#btn_close8").click();
		      		$("input[name=embed]").val("");
		      		$("#embed_upload_form input").val("");
		      		$(".embedvideo-error").text("");
		      	}

				function embedd_upload(){
					if($("#vid_url").val() != ""){
						var videoURL = $("#vid_url").val();
			            var urlParts = videoURL.split("/");
			            if(urlParts[0] == "https:" && urlParts[2] == "www.youtube.com" && urlParts[3] == "embed"){
							$('#video_iframe').attr('src', $('#vid_url').val());
			            	$(".embedvideo-error").text("");
			            	$('#btn_close9').click(); $('#remove_embed_btn').show();
			            }else{
			            	$(".embedvideo-error").text("<?= $allLabelsArray[785] ?>");
			            }
					}
				}

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

				  function video_changer1(value){
				    $('#video_changer1').modal();
				  }

				  function url_changer(value){
				    $('#video_changer2').modal();
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
					getThumbnail();
					var value = [];
					$(".tages_list .active").each(function(){
					  value.push($(this).attr("data-id"));
					});
					$("#create_blog input[name=category]").val(value.join(","));
					$("#create_blog input[name=tages]").val($("#blog_tages").val());
                    $("#create_blog input[name=display_type]").val($("input[name=getType]").val());
                    $("#create_blog input[name=embed]").val($("#vid_url").val());
                    $("#create_blog input[name=type]").val("video-"+$("input[name=getType]").val());

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
                    
                    var FileSize = 0;
                    if($("#vid_name").val() != ""){
                    	FileSize = document.getElementById("vid_name").files[0].size / 1024 / 1024;
                    }
                    $("#create_blog input[name=slug]").val(final);

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

                    }else if($("#vid_name").val() == "" && $("input[name=embed]").val() == "" && $("input[name=videos]").val() == ""){
                       	
                       	ShowMessage("error","<?= $allLabelsArray[655] ?>","");

                    }else if($("#vid_name").val() != "" && FileSize > 100){
                        
                        ShowMessage("error","<?= $allLabelsArray[546] ?>","");

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

                    }else if($("input[name=tages]").val() == ""){

                    	ShowMessage("error","<?= $allLabelsArray[587] ?>","");
                    
                    }else{
                        var form = $('#create_blog')[0];
                    	var formData = new FormData(form);
                    	if($("#vid_name").val() != ""){
                    		formData.append('videos',document.getElementById("vid_name").files[0]);
                    	}

                    	if(VideoThumbnail != null){
			           		formData.append('thumbnail',VideoThumbnail);
			            }

                    	$.ajax({
							type: "POST",
							url: "<?= $cms_url ?>ajax.php?h=CreateUpdateVideoBlog&lang="+$("input[name=lang]").val(),
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