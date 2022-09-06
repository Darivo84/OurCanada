<?php
require_once 'cms_error.php';

include_once 'community/user_inc.php';
$page = 'inner';
$request = explode( "/", $_SERVER[ 'REQUEST_URI' ] );
$news_slug = $request[ 3 ];
$query = "SELECT * FROM `news` WHERE  slug='$news_slug' AND (status = 1 OR user_id = '{$_SESSION['user_id']}' )";
$row = mysqli_fetch_assoc( mysqli_query( $conn, $query ) );
$id = $row[ "id" ];
if ( $id == "" ) {
	header( "Location:" . $url . "404" );
}
$images = explode( ',', $row[ 'images' ] );
$tags = explode( ",", $row[ 'type' ] );
$tages_col = explode( ",", $row[ 'tages' ] );
$video = '';
// $video_local = explode( ",", $row[ 'video_local' ] );
// $video_url = explode( ",", $row[ 'video_url' ] );
if ( !empty( $row[ 'videos' ] ) ) {

	$video_local = explode( ",", $row[ 'videos' ] );
} 
$query = "SELECT * FROM `users` WHERE id={$row['user_id']}";
$fetch = mysqli_fetch_assoc( mysqli_query( $conn, $query ) );

$author_row = mysqli_fetch_assoc($fetch);
if(!empty($author_row) && $author_row['role'] == 0){
	$author = $author_row['firstname'].' '.$author_row['lastname'];
}else{
	$author = 'Admin';
}


$querycount1 = "SELECT count(id) as count FROM `news`";
$result21 = mysqli_query( $conn, $querycount1 );
$row11 = mysqli_fetch_assoc( $result21 );
$blogcount = $row11[ 'count' ];

$querycount = "SELECT count(id) as count FROM `news` where status=1";
$result2 = mysqli_query( $conn, $querycount );
$row1 = mysqli_fetch_assoc( $result2 );
$newscount = $row1[ 'count' ];

$prev = mysqli_query( $conn, "SELECT title,slug FROM `news` WHERE id<'$id' ORDER BY id DESC LIMIT 1" );
$prevpost= mysqli_fetch_assoc( $prev );

$next = mysqli_query( $conn, "SELECT title,slug FROM `news` WHERE id>'$id' ORDER BY id ASC LIMIT 1" );
$nextpost= mysqli_fetch_assoc( $next );

$ip = $_SERVER['REMOTE_ADDR'];
$likeCheck = mysqli_query($conn,"SELECT * FROM news_likes WHERE content_id = ".$id." && (visitor_id = ".$_SESSION['user_id']." || visitor_ip = '".$ip."')");
$liked = false;
if(mysqli_num_rows($likeCheck) > 0){
	$liked = true;
}else{
	$liked = false;
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
	<title>Our Canada - Blog Details</title>
	<!-- Favicon-->

	<!-- Stylesheets-->
	<?php include("community/includes/style.php") ?>
	<style type="text/css">
		@keyframes shake {
		  0% { transform: translate(1px, 1px) rotate(0deg); }
		  10% { transform: translate(-1px, -2px) rotate(-1deg); }
		  20% { transform: translate(-3px, 0px) rotate(1deg); }
		  30% { transform: translate(3px, 2px) rotate(0deg); }
		  40% { transform: translate(1px, -1px) rotate(1deg); }
		  50% { transform: translate(-1px, 2px) rotate(-1deg); }
		  60% { transform: translate(-3px, 1px) rotate(0deg); }
		  70% { transform: translate(3px, 1px) rotate(-1deg); }
		  80% { transform: translate(-1px, -1px) rotate(1deg); }
		  90% { transform: translate(1px, 2px) rotate(0deg); }
		  100% { transform: translate(1px, -2px) rotate(-1deg); }
		}
		video {
	width: 100%;
	max-height: 350px;
	object-fit: revert;
	background-color: black;
}
	</style>
	<!-- end head -->
	<style >
	    .post_content p
	    {
	        text-align: justify !important;
	    }
	</style>
</head>

<body class="mobile_nav_class jl-has-sidebar">
	<div class="options_layout_wrapper jl_none_box_styles jl_border_radiuss">
		<div class="options_layout_container full_layout_enable_front">
			<!-- Start header -->
			<?php include("community/includes/header.php") ?>
			<!-- end header -->
			<?php if ($row['type']=='simplenews' || $row['type']=='simpleblog'): ?>
			<div class="jl_home_section">
				<div class="container">
					<div class="row">
						<div class="col-md-8  loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small single_meta_category">
													<?php foreach ($tages_col as $key => $value): 
													if($value!=null){?>
												
												<a class="post-category-color-text" style="background:#FE0000" href="#"><?php echo $value ?></a>
												<?php }endforeach ?>
												
												</span>
												<h1 class="single_post_title_main">
													<?php echo $row['title']; ?>
												</h1>
												
												<span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="#" title="Posts by Admin" rel="author"><?php echo $author;?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo $row['created_date']; ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a style="margin-right: 20px;" class="com_count">0 Comment</a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span>0</span></span></span>
											</div>
										</div>
										<div class="post_content" style="margin-top: 20px;">
											<p>
												<?php echo $row['description']; ?><span id="more-2808"></span>
											</p>
											<p>
												<?php echo $row['content_one']; ?>
											</p>
											<?php if(!empty($row["quote"]) && $row["quote"] != null){ ?>
											<blockquote>
												<p align="center"><?php echo $row["quote"];?></p>
											</blockquote>
											<?php } ?>
											<p>
												<?php echo $row['content_two']; ?>
											</p>
											<p>
												<?php echo $row['content_three']; ?>
											</p>
											<p>
												<?php echo $row['content_four']; ?>
											</p>
											<p>
												<?php echo $row['content_five']; ?>
											</p>
											<p>
												<?php echo $row['content_six']; ?>
											</p>
										</div>
										<div class="clearfix"></div>
										<div class="single_tag_share">
											<div class="tag-cat">
												<ul class="single_post_tag_layout">
													<?php foreach ($tages_col as $key => $value): 
													if($value!=null){?>
													<li>
														
														<a href="#" rel="tag">
															<?php echo $value; ?>
														</a>
														
													</li>
													<?php }endforeach ?>
												</ul>
											</div>
											<div class="single_post_share_icons"> Share<i class="fa fa-share-alt"></i>
											</div>
										</div>
										<div class="single_post_share_wrapper">
											<div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
											</div>
											<ul class="single_post_share_icon_post">
												<li class="single_post_share_facebook"><a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
												</li>
												<li class="single_post_share_twitter"><a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
												</li>
												<li class="single_post_share_pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
												</li>
												<li class="single_post_share_linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
												</li>
												<li class="single_post_share_ftumblr"><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a>
												</li>
											</ul>
										</div>
											<?php 

													if($prevpost["title"]!=null){
											?>
<!--										<div class="postnav_left">-->
<!--											-->
<!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."news/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
<!--										</div>-->
											<?php }

											if($nextpost["title"]!=null){
											?>
										<div class="postnav_right">
											
											<div class="single_post_arrow_content"> <a href="<?php echo $url."news/".$nextpost['slug']; ?>" id="nextpost"><?php echo $nextpost["title"];?><span class="jl_post_nav_left"> Next post</span></a> </div>
										</div><?php }?>
<!--										<div class="auth">-->
<!--											<div class="author-info">-->
<!--												<div class="author-avatar"> <img src="--><?php //echo $url?><!--assets/img/favicon.jpg" width="165" height="165" alt="Admin" class="avatar avatar-165 wp-user-avatar wp-user-avatar-165 alignnone photo"/> </div>-->
<!--												<div class="author-description">-->
<!--													<h5><a href="#"> --><?php //echo $author;?><!--</a></h5>-->
<!--													<p> welcome Mauris mattis auctor cursus. Phasellus tellus tellus, imperdiet ut imperdiet eu, iaculis a sem. Donec vehicula luctus nunc in laoreet. Aliquam erat volutpat. Suspendisse vulputate porttitor condimentum. </p>-->
<!--												</div>-->
<!--											</div>-->
<!--										</div>-->
										<!-- Comments -->
										<div id="respond" class="comment-respond">
											<div class="comment-area">
												<div class="content_title">
													<!-- Panding Comments -->
												
													<!-- Panding Comments End -->
													<h5 class="com_count">(0) Comments</h5>
												</div>
												<ul class="list_none comment_list">
												</ul>

											</div>
										   <h3 id="reply-title" class="comment-reply-title">Leave a Reply <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Cancel reply</a></small></h3>
										   <form id="commentform" class="comment-form">
												  <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
												  </p>
												  <p class="comment-form-comment">
													 <textarea class="u-full-width" maxlength="1000" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Comment" required></textarea>
												  	<p class="text-danger" align="right" id="com_error"></p>
												  </p>
												  
												  <p class="form-submit">
													 <input type="submit" id="submit" class="submit" value="Post Comment">
												  </p>
											   </form>
										</div>
									</div>
								</div>
								<!-- end post -->
								<div class="brack_space"></div>
									
									
							</div>
						</div>
						<!-- start sidebar -->
						<?php include_once("sidebar.php"); ?>
						<!-- end sidebar -->
					</div>
				</div>
			</div>
			<?php endif ?>
			<?php if ($row['type']=='image-slider-news' || $row['type']=='image-slider-blog'): ?>
			<div class="jl_home_section jl_home_slider">
				<div class="container">
					<div class="row">
						<div class="col-md-8  loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small single_meta_category"><a class="post-category-color-text" style="background:#FE0000" href="#"><?php echo $row['type']; ?></a></span>
												<h1 class="single_post_title_main">
													<?php echo $row['title']; ?>
												</h1>
												<p class="post_subtitle_text">
													<?php echo $row['sub_title']; ?>
												</p>
												<span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="#" title="Posts by Admin" rel="author"><?php echo $author;?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo $row['created_date']; ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a class="com_count" style="margin-right: 20px;">0 Comment</a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span>0</span></span></span>
											</div>
											<div class="col-md-12 jl_mid_main_3col" style="padding: 0;">
						                        <div class="single_content_header jl_single_feature_below">
									                <div class="image-post-thumb jlsingle-title-above">
									                  <div class="justified-gallery-post justified-gallery" id="image_list" style="height: 510.762px;">
									                    <?php for($i = 0; $i < count($images); $i++){ if($images[$i] != ''){ 
									                    	if(count(explode('uploads/gallery/', $images[$i])) > 1){
											          $img_path = 'https://cms.ourcanadadev.site/'.$images[$i];
											        }else{
											          $img_path = "https://cms.ourcanadadev.site/uploads/images/".$images[$i];
											        }
									                    	?>
									                    <a class="featured-thumbnail jg-entry entry-visible" href="<?= $img_path ?>" style="width: 380px; height: 253.127px; top: 1px; left: 1px;">
									                      <img src="<?= $img_path ?>" alt="" style="width: 380px; height: 254px; margin-left: -190px; margin-top: -127px;">
									                      <div class="background_over_image"></div>
									                    </a>
									                    <?php }} ?>
									                  </div>
									                </div>
									              </div>
						                        
                                 			</div>
										</div>
										<div class="post_content">
											<p>
												<?php echo $row['description']; ?><span id="more-2808"></span>
											</p>
											<?php if(!empty($row["quote"]) && $row["quote"] != null){ ?>
											<blockquote>
												<p><?php echo $row['quote']; ?></p>
											</blockquote>
										<?php } ?>
											<p>
												<?php echo $row['content_two']; ?>
											</p>
											<?php 
											if(count(explode('uploads/gallery/', $images[0])) > 1){
											          $img_path = 'https://cms.ourcanadadev.site/'.$images[0];
											        }else{
											          $img_path = "https://cms.ourcanadadev.site/uploads/images/".$images[0];
											        }
											?>
											<p>
												<?php echo $row['content_three']; ?>
											</p>
											<p><img onclick="showFullIMG($(this));" class="size-full wp-image-4866 alignnone" src="<?php echo $img_path ?>" alt="" width="1920" height="1080"/>
											</p>
											<p>
												<?php echo $row['content_four']; ?>
											</p>
											<p>
												<?php echo $row['content_five']; ?>
											</p>
											<p>
												<?php echo $row['content_six']; ?>
											</p>
										</div>
										<div class="clearfix"></div>
										<div class="single_tag_share">
											<div class="tag-cat">
												<ul class="single_post_tag_layout">
													<?php foreach ($tages_col as $key => $value): 
													if($value!=null){?>
													<li>
														
														<a href="#" rel="tag">
															<?php echo $value; ?>
														</a>
														
													</li>
													<?php }endforeach ?>
												</ul>
											</div>
											<div class="single_post_share_icons"> Share<i class="fa fa-share-alt"></i>
											</div>
										</div>
										<div class="single_post_share_wrapper">
											<div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
											</div>
											<ul class="single_post_share_icon_post">
												<li class="single_post_share_facebook"><a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
												</li>
												<li class="single_post_share_twitter"><a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
												</li>
												<li class="single_post_share_pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
												</li>
												<li class="single_post_share_linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
												</li>
												<li class="single_post_share_ftumblr"><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a>
												</li>
											</ul>
										</div>
										<?php 

													if($prevpost["title"]!=null){
											?>
<!--										<div class="postnav_left">-->
<!--											-->
<!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."news/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
<!--										</div>-->
											<?php }

											if($nextpost["title"]!=null){
											?>
										<div class="postnav_right">
											
											<div class="single_post_arrow_content"> <a href="<?php echo $url."news/".$nextpost['slug']; ?>" id="nextpost"><?php echo $nextpost["title"];?><span class="jl_post_nav_left"> Next post</span></a> </div>
										</div><?php }?>
<!--										<div class="auth">-->
<!--											<div class="author-info">-->
<!--												<div class="author-avatar"> <img src="--><?php //echo $url?><!--assets/img/favicon.jpg" width="165" height="165" alt="Admin" class="avatar avatar-165 wp-user-avatar wp-user-avatar-165 alignnone photo"/> </div>-->
<!--												<div class="author-description">-->
<!--													<h5><a href="#"> --><?php //echo $author;?><!--</a></h5>-->
<!--													<p> welcome Mauris mattis auctor cursus. Phasellus tellus tellus, imperdiet ut imperdiet eu, iaculis a sem. Donec vehicula luctus nunc in laoreet. Aliquam erat volutpat. Suspendisse vulputate porttitor condimentum. </p>-->
<!--												</div>-->
<!--											</div>-->
<!--										</div>-->
										<!-- Comments -->
										<div id="respond" class="comment-respond">
											<div class="comment-area">
												<div class="content_title">
													<!-- Panding Comments -->
												
													<!-- Panding Comments End -->
													<h5 class="com_count">(0) Comments</h5>
												</div>
												<ul class="list_none comment_list">
												</ul>

											</div>
										   <h3 id="reply-title" class="comment-reply-title">Leave a Reply <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Cancel reply</a></small></h3>
										   <form id="commentform" class="comment-form">
												  <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
												  </p>
												  <p class="comment-form-comment">
													 <textarea maxlength="1000" class="u-full-width" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Comment" required></textarea>
												  </p>
												  
												  <p class="form-submit">
													 <input type="submit" id="submit" class="submit" value="Post Comment">
												  </p>
											   </form>
										</div>
									</div>
								</div>
								<!-- end post -->
								<div class="brack_space"></div>
							</div>
							<!-- widget-container content page -->
						</div>
						<!-- col -->
						<!-- start sidebar -->
						<?php include_once("sidebar.php"); ?>
						<!-- end sidebar -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- jl-home-section -->
			<?php endif ?>
				<?php if ($row['type']=='video-news' || $row['type']=='video-blog'): ?>
			<div class="jl_home_section">
				<div class="container">
					<div class="row">
						<div class="col-md-8  loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small single_meta_category"><a class="post-category-color-text" style="background:#FE0000" href="#"><?php echo $row['type']; ?></a></span>
												<h1 class="single_post_title_main">
													<?php echo $row['title']; ?> </h1>
												
												<span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="#" title="Posts by Admin" rel="author">Admin</a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo $row['created_date']; ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a class="com_count" style="margin-right: 20px">0 Comment</a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span>0</span></span></span>
											</div>
											<?php if(!empty($video_local[0])){ ?>
											<div class="single_content_header jl_single_feature_below">
												<div class="image-post-thumb jlsingle-title-above">
													<?php 
													if(count(explode('uploads/gallery/', $video_local[0])) > 1){
											          $img_path = 'https://cms.ourcanadadev.site/'.$video_local[0];
											        }else{
											          $img_path = "https://cms.ourcanadadev.site/uploads/videos/".$video_local[0];
											        }
													?>
													<video class="blogvideo" src="<?php echo $img_path ?>" width="750" height="400" controls></video>
												</div>
											</div>
											<?php } ?>
										</div>
										<div class="post_content">
											<p>
												<?php echo $row['description']; ?><span id="more-2808"></span>
											</p>
											<?php if(!empty($row["quote"]) && $row["quote"] != null){ ?>
											<blockquote>
												<p><?php echo $row["quote"];?></p>
											</blockquote>
										<?php } ?>
											<p>
												<?php echo $row['content_two']; ?>
											</p>
											<p>
												<?php echo $row['content_three']; ?>
											</p>
											<p>
												<div class="single_content_header jl_single_feature_below">
												<?php if(!empty($row['embed'])){ ?>
												<div class="image-post-thumb jlsingle-title-above">
													<iframe id="video_iframe" src="<?= $row['embed']; ?>" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" data-fluidvids="loaded" width="100%" height="400" frameborder="0"></iframe>
													<!-- <video class="blogvideo" src="<?php echo "https://cms.ourcanadadev.site/uploads/videos/".$video_local[1]?>" width="750" height="400" controls></video> -->
												</div>
												<?php } ?>
											</div>
											</p>
											
												<p>
													<?php echo $row['content_four']; ?>
												</p>
											<p>
													<?php echo $row['content_five']; ?>
												</p>
											<p>
													<?php echo $row['content_six']; ?>
												</p>
											
										</div>
										<div class="clearfix"></div>
										<div class="single_tag_share">
											<div class="tag-cat">
												<ul class="single_post_tag_layout">
													<?php foreach ($tages_col as $key => $value): 
													if($value!=null){?>
													<li>
														
														<a href="#" rel="tag">
															<?php echo $value; ?>
														</a>
														
													</li>
													<?php }endforeach ?>
												</ul>
											</div>
											<div class="single_post_share_icons"> Share<i class="fa fa-share-alt"></i>
											</div>
										</div>
										<div class="single_post_share_wrapper">
											<div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
											</div>
											<ul class="single_post_share_icon_post">
												<li class="single_post_share_facebook"><a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
												</li>
												<li class="single_post_share_twitter"><a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
												</li>
												<li class="single_post_share_pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
												</li>
												<li class="single_post_share_linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
												</li>
												<li class="single_post_share_ftumblr"><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a>
												</li>
											</ul>
										</div>
										<?php 

													if($prevpost["title"]!=null){
											?>
<!--										<div class="postnav_left">-->
<!--											-->
<!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."news/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
<!--										</div>-->
											<?php }

											if($nextpost["title"]!=null){
											?>
										<div class="postnav_right">
											
											<div class="single_post_arrow_content"> <a href="<?php echo $url."news/".$nextpost['slug']; ?>" id="nextpost"><?php echo $nextpost["title"];?><span class="jl_post_nav_left"> Next post</span></a> </div>
										</div><?php }?>
<!--										<div class="auth">-->
<!--											<div class="author-info">-->
<!--												<div class="author-avatar"> <img src="--><?php //echo $url?><!--assets/img/favicon.jpg" width="165" height="165" alt="Admin" class="avatar avatar-165 wp-user-avatar wp-user-avatar-165 alignnone photo"/> </div>-->
<!--												<div class="author-description">-->
<!--													<h5><a href="#"> --><?php //echo $author;?><!--</a></h5>-->
<!--													<p> welcome Mauris mattis auctor cursus. Phasellus tellus tellus, imperdiet ut imperdiet eu, iaculis a sem. Donec vehicula luctus nunc in laoreet. Aliquam erat volutpat. Suspendisse vulputate porttitor condimentum. </p>-->
<!--												</div>-->
<!--											</div>-->
<!--										</div>-->
										<!-- Comments -->
										<div id="respond" class="comment-respond">
											<div class="comment-area">
												<div class="content_title">
													<!-- Panding Comments -->
													
													<!-- Panding Comments End -->
													<h5 class="com_count">(0) Comments</h5>
												</div>
												<ul class="list_none comment_list">
												</ul>

											</div>
										   <h3 id="reply-title" class="comment-reply-title">Leave a Reply <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Cancel reply</a></small></h3>
										   <form id="commentform" class="comment-form">
												  <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
												  </p>
												  <p class="comment-form-comment">
													 <textarea class="u-full-width" maxlength="1000" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Comment" required></textarea>
												  </p>
												 
												  <p class="form-submit">
													 <input type="submit" id="submit" class="submit" value="Post Comment">
												  </p>
											   </form>
										</div>
									</div>
								</div>
								<!-- end post -->
								<div class="brack_space"></div>
							</div>
						</div>
						<!-- start sidebar -->
						<?php include_once("sidebar.php"); ?>
					<!-- end sidebar -->
				</div>
			</div>
			<?php endif ?>
				<?php if ($row['type']=='video-image-news' || $row['type']=='video-image-blog'): ?>
			<div class="jl_home_section">
				<div class="container">
					<div class="row">
						<div class="col-md-8  loop-large-post" id="content">
							<div class="widget_container content_page">
								<!-- start post -->
								<div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
									<div class="single_section_content box blog_large_post_style">
										<div class="jl_single_style2">
											<div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small single_meta_category"><a class="post-category-color-text" style="background:#FE0000" href="#"><?php echo $row['type']; ?></a></span>
												<h1 class="single_post_title_main">
													<?php echo $row['title']; ?> </h1>
												<span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="#" title="Posts by Admin" rel="author"><?php echo $author;?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo $row['created_date']; ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a class="com_count" style="margin-right: 20px">0 Comment</a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span>0</span></span></span>
											</div>
											<?php if(!empty($video_local[0])){ ?>
											<div class="single_content_header jl_single_feature_below">
												<div class="image-post-thumb jlsingle-title-above">
													<?php 
													if(count(explode('uploads/gallery/', $video_local[0])) > 1){
											          $img_path = 'https://cms.ourcanadadev.site/'.$video_local[0];
											        }else{
											          $img_path = "https://cms.ourcanadadev.site/uploads/videos/".$video_local[0];
											        }
													?>
													<video class="blogvideo" src="<?php echo $img_path ?>" width="750" height="400" controls></video>
												</div>
											</div>
											<?php } ?>
										</div>
										<div class="post_content">
											<p>
												<?php echo $row['description']; ?><span id="more-2808"></span>
											</p>
											<?php if(!empty($row["quote"]) && $row["quote"] != null){ ?>
											<blockquote>
												<p><?php echo $row["quote"];?></p>
											</blockquote>
										<?php } ?>
											<p>
												<?php echo $row['content_two']; ?>
											</p>
											<p>
												<?php echo $row['content_three']; ?>
											</p>
											<div class="col-md-12 jl_mid_main_3col" style="padding: 0;">
						                        <div class="single_content_header jl_single_feature_below">
									                <div class="image-post-thumb jlsingle-title-above">
									                  <div class="justified-gallery-post justified-gallery" id="image_list" style="height: 510.762px;">
									                    <?php for($i = 0; $i < count($images); $i++){ if($images[$i] != ""){ 
									                    	if(count(explode('uploads/gallery/', $images[$i])) > 1){
													          $img_path = 'https://cms.ourcanadadev.site/'.$images[$i];
													        }else{
													          $img_path = "https://cms.ourcanadadev.site/uploads/images/".$images[$i];
													        }
									                   	?>
									                    <a class="featured-thumbnail jg-entry entry-visible" href="<?= $img_path ?>" style="width: 380px; height: 253.127px; top: 1px; left: 1px;">
									                      <img src="<?= $img_path ?>" alt="" style="width: 380px; height: 254px; margin-left: -190px; margin-top: -127px;">
									                      <div class="background_over_image"></div>
									                    </a>
									                    <?php }} ?>
									                  </div>
									                </div>
									              </div>
                                 			</div>
											<p>
												<?php echo $row['content_four']; ?>
											</p>
											<p>
												<?php echo $row['content_five']; ?>
											</p>
											<p>
												<?php echo $row['content_six']; ?>
											</p>
											</p>
										</div>
										<div class="clearfix"></div>
										<div class="single_tag_share">
											<div class="tag-cat">
												<ul class="single_post_tag_layout">
													<?php foreach ($tages_col as $key => $value): 
													if($value!=null){?>
													<li>
														
														<a href="#" rel="tag">
															<?php echo $value; ?>
														</a>
														
													</li>
													<?php }endforeach ?>
												</ul>
											</div>
											<div class="single_post_share_icons"> Share<i class="fa fa-share-alt"></i>
											</div>
										</div>
										<div class="single_post_share_wrapper">
											<div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
											</div>
											<ul class="single_post_share_icon_post">
												<li class="single_post_share_facebook"><a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
												</li>
												<li class="single_post_share_twitter"><a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
												</li>
												<li class="single_post_share_pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
												</li>
												<li class="single_post_share_linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin"></i></a>
												</li>
												<li class="single_post_share_ftumblr"><a href="#" target="_blank"><i class="fa fa-tumblr"></i></a>
												</li>
											</ul>
										</div>
										<?php 

													if($prevpost["title"]!=null){
											?>
<!--										<div class="postnav_left">-->
<!--											-->
<!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."news/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
<!--										</div>-->
											<?php }

											if($nextpost["title"]!=null){
											?>
										<div class="postnav_right">
											
											<div class="single_post_arrow_content"> <a href="<?php echo $url."news/".$nextpost['slug']; ?>" id="nextpost"><?php echo $nextpost["title"];?><span class="jl_post_nav_left"> Next post</span></a> </div>
										</div><?php }?>
<!--										<div class="auth">-->
<!--											<div class="author-info">-->
<!--												<div class="author-avatar"> <img src="--><?php //echo $url?><!--assets/img/favicon.jpg" width="165" height="165" alt="Admin" class="avatar avatar-165 wp-user-avatar wp-user-avatar-165 alignnone photo"/> </div>-->
<!--												<div class="author-description">-->
<!--													<h5><a href="#"> Admin</a></h5>-->
<!--													<p> welcome Mauris mattis auctor cursus. Phasellus tellus tellus, imperdiet ut imperdiet eu, iaculis a sem. Donec vehicula luctus nunc in laoreet. Aliquam erat volutpat. Suspendisse vulputate porttitor condimentum. </p>-->
<!--												</div>-->
<!--											</div>-->
<!--										</div>-->
										
										<div id="respond" class="comment-respond">
											<div class="comment-area">
												<div class="content_title">
													<!-- Panding Comments -->
												
													<!-- Panding Comments End -->
													<h5 class="com_count">(0) Comments</h5>
												</div>
												<ul class="list_none comment_list">
												</ul>

											</div>
										   <h3 id="reply-title" class="comment-reply-title">Leave a Reply <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;">Cancel reply</a></small></h3>
										   <form id="commentform" class="comment-form">
												  <p class="comment-notes"><span id="email-notes">Your email address will not be published.</span>
												  </p>
												  <p class="comment-form-comment">
													 <textarea class="u-full-width" maxlength="1000" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="Comment" required></textarea>
												  </p>
												 
												  <p class="form-submit">
													 <input type="submit" id="submit" class="submit" value="Post Comment">
												  </p>
											   </form>
											</div>
									</div>
								</div>

								<!-- end post -->
								<div class="brack_space"></div>
							</div>
						</div>
						<!-- start sidebar -->
						<?php include_once("sidebar.php"); ?>
					<!-- end sidebar -->
				</div>
			</div>
			<?php endif ?>
		</div>
	</div>

	<!-- end content -->
	<!-- Start footer -->
	<?php include("community/includes/footer.php") ?>
	<!-- End footer -->

	<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
	<!-- login model -->
			<div class="modal fade" style="background: rgba(0,0,0,.5);" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <form class="modal-content">
			      <div class="modal-header" style="background: #8d633a;">
			        <h5 class="modal-title" id="exampleModalLabel" style="color: #fff; text-align: center;">Login</h5>
			        <button style="position: absolute; top: 20px; right: 15px; color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#loginModel form')[0].reset(); $('#loginModel').attr('class','modal fade'); $('#loginModel .log_err i').hide(); $('#loginModel .log_err span').text(''); $('#loginModel .modal-dialog').css('animation','shakes 0.5s');">
			          <span aria-hidden="true" style="color: #fff;">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			      	<div class="col-lg-10 col-lg-offset-1">
			      		<div class="text-danger log_err" style="color: red; width: 100%; text-align: center;">
			      			<i class="fa fa-frown-o" style="display:none; font-size: 36px;"></i><br>
							<span style="font-weight: bold;"></span>			      			
			      		</div>
				      	<input type="hidden" name="comment" hidden>
				      	<input type="hidden" name="content_id" hidden value="<?= $id ?>">
				      	<div class="form-group" style="position: relative;">
				      		<label>Email</label>
				      		<i class="fa fa-envelope" style="color: #8d633a; position: absolute; left: 12px; top: 41px;"></i>
				      		<input type="email" placeholder="abc@gmail.com" placeholder="abc@gmail.com" name="email" class="form-control" required style="padding-left: 35px;">
				      	</div>
				      	<div class="form-group" style="position: relative;">
				      		<label>Password</label>
				      		<i class="fa fa-key" style="color: #8d633a; position: absolute; left: 12px; top: 41px;"></i>
				      		<i class="fa fa-eye-slash" onclick="show_hide($(this));" style="color: #8d633a; position: absolute; right: 12px; top: 41px;"></i>
				      		<input type="password" placeholder="Password" name="password" class="form-control" required style="padding-left: 35px;">
				      	</div>
				      	<div style="position: relative;" class="form-group text-right">
		                    <a href="<?= $cms_url ?>forgot-password" style="font-weight: bold;color: #8d633a;">Forgot Password ?</a>     
		                </div>
			      	</div>
			      </div>
			      <div class="modal-footer" style="text-align: center; border: 0;">
			        <button type="submit" class="btn btn-primary" style="width: 200px; background: #8d633a; border: 0; margin-bottom: 5px;">Login</button>
			      	<br>
			      	<a href="<?= $cms_url ?>register">Not a member? <b style="color: #8d633a; margin-left: 10px;">Register</b></a>
			      </div>
			  </form>
			    </div>
			  </div>
			</div>
			<!-- end model -->
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
			        <p style="text-align: center;font-size: 36px;color: green;font-style: italic;">Comment Posted!</p><p style="text-align: center;font-size: 15px;color: #484848;/*! font-style: italic; */">Waiting Admin for Approval</p>
			      </div>
			      <div class="modal-footer" style="/*! border-top: 0; */border: 0;text-align: center;">
			        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').slideUp();" style="width: 150px;background: #92683e;color: #fff;">OK</button>
			      </div>
			    </div>
			  </div>
			</div>
			<div class="modal login_like" tabindex="-1" role="dialog" style="display: none;">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title">Notification</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.com_not').hide();">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        <p></p>
			      </div>
			      <div class="modal-footer">
			        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').hide();">Close</button>
			      </div>
			    </div>
			  </div>
			</div>
	<div class="modal fade" id="reply_comment" role="dialog" style="background: rgba(0,0,0,.5);">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	      	<form>
	        <div class="modal-header">
	          <button onclick="closeReplyForm();" type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Post your reply</h4>
	        </div>
	        <div class="modal-body">
	        	<div class="error_msg"></div>
	        	<input type="hidden" hidden name="content_id">
	        	<input type="hidden" hidden name="comment_id">
	         	<textarea required name="reply_comment" placeholder="Type your reply..." class="form-control"></textarea>
	        </div>
	        <div class="modal-footer">
	          <button type="submit" class="btn btn-success" data-dismiss="modal">Post Comment</button>
	          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeReplyForm();">Close</button>
	        </div>
	        </form>
	      </div>
	    </div>
  	</div>
  	<div class="modal fade" style="background: rgba(0,0,0,.5);" id="loginModelLike" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form class="modal-content">
            <div class="modal-header" style="background: #8d633a;">
              <h5 class="modal-title" id="exampleModalLabel" style="color: #fff; text-align: center;">Login</h5>
              <button style="position: absolute; top: 20px; right: 15px; color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#loginModelLike form')[0].reset(); $('#loginModelLike').modal(); $('#loginModelLike .log_err i').hide(); $('#loginModelLike .log_err span').text(''); $('#loginModelLike .modal-dialog').css('animation','shakes 0.5s');">
                <span style="color: #fff;" aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            	<div class="col-lg-10 col-lg-offset-1">
              	<div class="text-danger log_err" style="color: red; width: 100%; text-align: center;">
			      	<i class="fa fa-frown-o" style="display:none; font-size: 36px;"></i><br>
					<span style="font-weight: bold;"></span>			      			
			    </div>
              <div class="form-group" style="position: relative;">
                <label>Email</label>
                <i class="fa fa-envelope" style="color: #8d633a; position: absolute; left: 12px; top: 41px;"></i>
                <input type="email" name="email" placeholder="abc@gmail.com" class="form-control" required style="padding-left: 35px;">
              </div>
              <div class="form-group" style="position: relative;">
                <label>Password</label>
                <i class="fa fa-key" style="color: #8d633a; position: absolute; left: 12px; top: 41px;"></i>
				<i class="fa fa-eye-slash" onclick="show_hide($(this));" style="color: #8d633a; position: absolute; right: 12px; top: 41px;"></i>
                <input type="password" placeholder="Password" name="password" class="form-control" required style="padding-left: 35px;">
              </div>
              <div style="position: relative;" class="form-group text-right">
		                    <a href="<?= $cms_url ?>forgot-password" style="font-weight: bold;color: #8d633a;">Forgot Password ?</a>       
		                </div>
              </div>
            </div>
            <div class="modal-footer" style="text-align: center; border: 0;">
			  <button type="submit" class="btn btn-primary" style="width: 200px; background: #8d633a; border: 0; margin-bottom: 5px;">Login</button>
				<br>
				<a href="<?= $cms_url ?>register">Not a member? <b style="color: #8d633a; margin-left: 10px;">Register</b></a>
			</div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#loginModelLike form')[0].reset(); $('#loginModelLike').modal();">Close</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-spin fa-spinner" style="display: none;"></i> Login</button>
            </div> -->
        </form>
          </div>
        </div>
        <style type="text/css">
        	.com_del{
        		position: absolute; right: 50px; background: transparent; border: 0;
        	}
        	.com_del:hover{
        		color: red;
        	}
        	.com_edit{
        		position: absolute; right: 75px; background: transparent; border: 0;
        	}
        	.com_edit:hover{
        		color: green;
        	}
        	.snackbar{
        		display: none;
        		position: fixed;
        		width: 100%;
        		height: 100%;
        		left: 0;
        		top: 0;
        		z-index: 1111;
        	}
        	.snackbar .box{
        		width: 350px;
        		position: absolute;
        		top: 10px;
        		left: -webkit-calc(50% - 175px);
        		left: -moz-calc(50% - 175px);
        		left: -o-calc(50% - 175px);
        		left: calc(50% - 175px);
        	}
        </style>
        <div class="snackbar main_snackbar">
        	<div class="box" style="text-align: center; background: #fff; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0,0,0,2); padding-bottom: 15px;">
        		<div style="width: 100%; background: #855b32; line-height: 40px;border-top-left-radius: 5px;border-top-right-radius: 5px; color: #fff;font-size: 18px;font-weight: bold;">Confirmation</div>
        		<p style="padding: 5px 15px; color: #bd0303; font-size: 20px; text-align:left; font-weight:bold !important;"><i class="fa fa-trash" style="margin-right: 10px;"></i>Delete Comment?</p>
        		<button class="btn btn-danger" style="marpxn-right: 10px; border: 0;"><i class="fa fa-spinner fa-spin" style="margin-right: 10px; display: none;"></i>Yes</button>
        		<button class="btn btn-warning" style="border: 0; background: #855b32;">No</button>
        	</div>
        </div>
        <div class="snackbar reply">
        	<div class="box" style="text-align: center; background: #fff; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0,0,0,2); padding-bottom: 15px;">
        		<div style="width: 100%; background: #855b32; line-height: 40px;border-top-left-radius: 5px;border-top-right-radius: 5px; color: #fff;font-size: 18px;font-weight: bold;">Confirmation</div>
        		<p style="padding: 5px 15px; color: #bd0303; font-size: 20px; text-align:left; font-weight:bold !important;"><i class="fa fa-trash" style="margin-right: 10px;"></i>Delete Comment?</p>
        		<button class="btn btn-danger" style="marpxn-right: 10px; border: 0;"><i class="fa fa-spinner fa-spin" style="margin-right: 10px; display: none;"></i>Yes</button>
        		<button class="btn btn-warning" style="border: 0; background: #855b32;">No</button>
        	</div>
        </div>
	<?php include("community/includes/script.php") ?>
	<script type="text/javascript">
		function show_hide(sel){
			if(sel.siblings("input").attr("type") == "text"){
				sel.siblings("input").attr("type","password");
				sel.attr("class","fa fa-eye-slash");
			}else{
				sel.siblings("input").attr("type","text");
				sel.attr("class","fa fa-eye");
			}
		}
		$(document).ready(function(){
				$.ajax({
					type: "POST",
					url: "<?= $cms_url ?>ajax.php?h=AddNewsView",
					data: {content_id: <?= $id ?>},
					dataType: "json",
					success: function(res){
						$(".fa-eye").siblings("span").text(res.views)
					},error: function(e){
					}
				});

				$.ajax({
					type: "POST",
					url: "<?= $cms_url ?>ajax.php?h=GetNewsLikes",
					data: {content_id: <?= $id ?>},
					dataType: "json",
					success: function(res){
						console.log(res)
						$(".fa-heart-o").siblings("span").text(res.likes)
						$(".fa-heart").siblings("span").text(res.likes)
					},error: function(e){
						console.log(e)
					}
				});
			});

			function addLike(sel){
				<?php if(isset($_SESSION['user_id'])){ ?>
				$.ajax({
					type: "POST",
					url: "<?= $cms_url ?>ajax.php?h=AddNewsLike",
					data: {content_id: <?= $id ?>},
					dataType: "json",
					success: function(res){
						$(".fa-heart-o,.fa-heart").siblings("span").text(res.likes)

						$(".fa-heart-o,.fa-heart").toggleClass("fa-heart-o fa-heart")
						if($(".fa-heart-o,.fa-heart").attr("style")){
							$(".fa-heart-o,.fa-heart").removeAttr("style")
							$(".fa-heart-o,.fa-heart").siblings("span").removeAttr("style")
						}else{
							$(".fa-heart-o,.fa-heart").attr("style","color: red !important;");
							$(".fa-heart-o,.fa-heart").siblings("span").attr("style","color: red !important;");
						}
					},error: function(e){
						console.log(e)
					}
				});
				<?php }else{ ?>
					$("#loginModelLike").modal();
					$("#loginModelLike form").validate({
		                errorClass: 'text-danger',
		                  submitHandler: function(form){
		                    $.ajax({
		                      type: "POST",
		                      url: "<?= $cms_url ?>ajax.php?h=refer_friend_login_modal",
		                      data: $("#loginModelLike form").serialize(),
		                      dataType: "json",
		                      beforeSend: function(){
		                        $("#loginModelLike form .fa-spin").show();
		                        $("#loginModelLike .log_err i").hide();
		                          $("#loginModelLike .log_err span").text("");
		                          $("#loginModelLike .modal-dialog").css("animation","shakes 0.5s");
		                      	$("#loginModelLike .btn-primary").prop("disabled",true);
		                      },
		                      success: function(res){
		                      	$("#loginModelLike .btn-primary").prop("disabled",false);
		                        $("#loginModelLike form .fa-spin").hide();
		                        console.log(res)
		                        if(res.login_err){
		                          $("#loginModelLike .log_err i").show()
		                          $("#loginModelLike .log_err span").text(res.login_err)
		                          $("#loginModelLike .modal-dialog").css("animation","shake 0.5s");
	              					$("#loginModelLike .modal-dialog").css("animation-iteration-count","2"); 
		                        }else{
		                          window.location.reload();
		                        }
		                      },error: function(e){
		                      	$("#loginModelLike .btn-primary").prop("disabled",false);
		                        $("#loginModelLike form .fa-spin").hide();
		                        console.log(e)
		                      }
		                    });
		                    return false;
		                  }
      				});
					// $(".login_like").modal();
					// $(".login_like .modal-body p").attr("class","alert alert-danger");
					// $(".login_like .modal-body p").text("Please login to like.");
				<?php } ?>
			}

		$().ready(function() {
			$("#comment").on("keyup",function(){
				$("#com_error").text($(this).val().length+"/1000");
			});
			
          // $.validator.addMethod('comment', function (value) { 
          //   return /^[a-zA-Z\s]*$/i.test(value); 
          // }, 'Format: Whitespaces & Alphabets Only');
          
        });
        
        $("#commentform").validate({
              // rules: {
              //     comment: "required comment",
              // },
              submitHandler: function(form){
              	<?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){?>
              	$.ajax({
              		type: "POST",
              		url: "<?= $cms_url ?>ajax.php?h=news_comments&c_id=<?= $id ?>",
              		data: $("#commentform").serialize(),
              		dataType: "json",
              		success: function(res){
              			console.log(res)
              			if(res.success){
              				$("#commentform")[0].reset();
              				
              			}else{
              				$(".com_not .fa").attr("class","fa fa-frown-o");
              				$(".com_not .modal-body p:first").css("color","red");
              				$(".com_not .modal-body p:first").text("Failed to Post Comment!");
              				$(".com_not .modal-body p:last").text("");
              				$(".com_not").slideDown();
              			}
              			setTimeout(function(){
              				$(".com_not .close").click();
              			},3000);
              			getComments();
              			getCommentCount();
              		},error: function(e){
              			console.log(e)
              		}
              	});
              	<?php }else{ ?>
              		$("#loginModel form input[name=comment]").val($("#commentform textarea[name=comment]").val());
              		
              		$("#loginModel").attr("class","modal show");
              		$("#loginModel form").validate({
		        	  errorClass: 'text-danger',
		              submitHandler: function(form){
		              	$.ajax({
		              		type: "POST",
		              		url: "<?= $cms_url ?>ajax.php?h=news_model_login",
		              		data: $("#loginModel form").serialize(),
		              		dataType: "json",
		              		beforeSend: function(){
		              			$("#loginModel .log_err i").hide();
		              			$("#loginModel .log_err span").text("");
		              			$("#loginModel .modal-dialog").css("animation","shakes 0.5s");
		                      	$("#loginModel .btn-primary").prop("disabled",true);
		              		},
		              		success: function(res){
		                      	$("#loginModel .btn-primary").prop("disabled",false);
		              			console.log(res)
		              			if(res.success){
		              				// $("#loginModel form")[0].reset();
		              				// $("#loginModel").attr("class","modal fade");
		              				// $(".com_not .modal-body p").text("Comment post successfully.Wait for the admin aprovel.");
              						// $(".com_not").show();
              						// setTimeout(function(){
              							window.location.reload();
              						// },1000);
		              			}else{
		              				$(".log_err i").show();
		              				$(".log_err span").text("Failed to login");
	              					$("#loginModel .modal-dialog").css("animation","shake 0.5s");
	              					$("#loginModel .modal-dialog").css("animation-iteration-count","2"); 
		              			}
		              		},error: function(e){
		                      	$("#loginModel .btn-primary").prop("disabled",false);
		              			console.log(e)
		              		}
		              	});
		                return false;
		              }
		          });
		        <?php } ?>
                return false;
              }
          });

       

        function getComments(){
        	$.ajax({
        		type: "POST",
        		url: "<?= $cms_url ?>ajax.php?h=news_getComments",
        		data: {id:<?= $id ?>},
        		dataType: "json",
        		success: function(res){
        			// console.log(res)
        			// console.log(res.comments[0].replies);
        			var html = '';
        			for (var i = 0; i < res.comments.length; i++) {
        				var setHTML = "";
        				<?php if(isset($_SESSION['user_id'])){ ?>
        				if(res.comments[i].status == 1){
        					setHTML = '<a style="margin-top: 80px; width: 100px;" comment="'+res.comments[i].c_id+'" onclick="AddCommentReply(<?= $id ?>,$(this));" class="comment-reply"><i class="fa fa-share" style="transform: scaleX(-1) !important; margin-right: 5px;"></i> Reply</a>';
        				}else{
        					setHTML = '<a style="font-style: italic;" comment="'+res.comments[i].c_id+'" class="comment-reply pending_com">Pending</a>';
        				}
        				<?php } ?>
        				// $(".comment_list").append(
        				html +='<li class="comment_info">'+
								'<div class="d-flex">';
									<?php if(isset($_SESSION['user_id'])){ ?>
										console.log(res.comments[i].user_id);
										if(res.comments[i].user_id == <?= $_SESSION['user_id'] ?>){
											html += '<button onclick="del_conf_snackbar('+res.comments[i].c_id+');" class="text-danger fa fa-trash com_del"></button>';
											html += '<button onclick="EditComment('+res.comments[i].c_id+',$(this))" class="text-success fa fa-edit com_edit"></button>';
										}
									<?php } ?>
									html += '<div class="comment_user">'+
										'<img style="width: 50px; height: 50px;" class="rounded-circle" src="'+(res.comments[i].profile)+'" alt="user2">'+
									'</div>'+
									'<div class="comment_content">'+
										'<div class="d-flex">'+
											'<div class="meta_data">'+
												'<h6><a href="#">'+res.comments[i].u_name+'</a></h6>'+
												'<div class="comment-time">'+res.comments[i].c_date+'</div>'+
											'</div>'+
											
										'</div>'+
										'<p><span>'+res.comments[i].comment.substring(0,160)+'</span>'; if(res.comments[i].comment.length > 160){ html += '<a comments="'+res.comments[i].comment+'" style="margin-left: 15px; font-size: 14px;text-decoration: underline;" onclick="showLessMore($(this));">Show More</a>';} html += '</p>'+
										'<div class="ml-auto" style="position: absolute; right: 60px; margin-top: -15px;">'+
												setHTML+
											'</div>'+
									'</div>'+
								'</div>'+
								'<div class="com_reply" id="edit_reply_id'+res.comments[i].c_id+'" style="position: relative; display: none; margin-top: 35px; margin-bottom: 50px;">'+
								'<button class="btn btn-success" comment_id="'+res.comments[i].c_id+'" style="position: absolute; right: 4px; top: 86px;"><i class="fa fa-spin fa-spinner" style="display: none;"></i> Update</button>'+
								'<textarea type="text" placeholder="Type your reply..." maxlength="1000">'+res.comments[i].comment+'</textarea><p class="text-danger">'+res.comments[i].comment.length+'/1000</p>'+
								'</div>'+
								'<div class="com_reply" id="reply_id'+res.comments[i].c_id+'" style="position: relative; display: none; margin-top: 35px; margin-bottom: 50px;">'+
								'<button class="btn btn-success" comment_id="'+res.comments[i].c_id+'" onclick="postComment($(this));" style="position: absolute; right: 4px; top: 86px;"><i class="fa fa-spin fa-spinner" style="display: none;"></i> Post</button>'+
								'<textarea type="text" placeholder="Type your reply..." maxlength="1000"></textarea><p class="text-danger"></p>'+
								'</div>';
								if(res.comments[i].replies && res.comments[i].status == 1){
									for (var j = 0; j < res.comments[i].replies.length; j++) {
										html += '<ul class="children">'+
											'<li class="comment_info">'+
												'<div class="d-flex">';
												<?php if(isset($_SESSION['user_id'])){ ?>
													if(res.comments[i].replies[j].user_id == <?= $_SESSION['user_id'] ?>){
														html += '<button onclick="reply_del_conf_snackbar('+res.comments[i].replies[j].c_id+');" class="text-danger fa fa-trash com_del"></button>';
														html += '<button onclick="reply_EditComment('+res.comments[i].replies[j].c_id+',$(this))" class="text-success fa fa-edit com_edit"></button>';
													}
												<?php } ?>
													html += '<div class="comment_user">'+
														'<img class="rounded-circle" style="width: 50px; height: 50px;" src="'+(res.comments[i].replies[j].profile)+'" alt="user3">'+
													'</div>'+
													'<div class="comment_content">'+
														'<div class="d-flex align-items-md-center">'+
															'<div class="meta_data">'+
																'<h6><a href="#">'+res.comments[i].replies[j].u_name+'</a></h6>'+
																'<div class="comment-time">'+res.comments[i].replies[j].c_date+'</div>'+
															'</div>'+
														'</div>'+
														'<p><span>'+res.comments[i].replies[j].comment.substring(0,160)+'</span>'; if(res.comments[i].replies[j].comment.length > 160){ html += '<a comments="'+res.comments[i].replies[j].comment+'" style="margin-left: 15px; font-size: 14px;text-decoration: underline;" onclick="showLessMore($(this));">Show More</a>';} html += '</p>'+
													'</div>'+
												'</div>'+
												'<div class="com_reply" id="edit_r_reply_id'+res.comments[i].replies[j].c_id+'" style="position: relative; display: none; margin-top: 35px; margin-bottom: 50px;">'+
												'<button class="btn btn-success" comment_id="'+res.comments[i].replies[j].c_id+'" style="position: absolute; right: 4px; top: 86px;"><i class="fa fa-spin fa-spinner" style="display: none;"></i> Update</button>'+
												'<textarea type="text" placeholder="Type your reply..." maxlength="1000">'+res.comments[i].replies[j].comment+'</textarea><p class="text-danger">'+res.comments[i].replies[j].comment.length+'/1000</p>'+
												'</div>'+
											'</li>'+
										'</ul>';
									}
								}
							html += '</li>';

        				// );
        			}
        			
        			$(".comment_list").html(html);
        			 $(".pending_com").mouseenter(function(){
			        	$(this).text("Waiting for admin approval!");
			        });

        			 $(".com_reply textarea").on("keyup",function(){
					 	$(this).siblings("p").text($(this).val().length+"/1000");
					 });

			        $(".pending_com").mouseout(function(){
			        	$(this).text("Pending");
			        });
        		},error: function(e){
        			console.log(e)
        		}
        	});
        } getComments();

        // main
        function EditComment(id,sel){
        	$("#edit_reply_id"+id).stop().slideToggle();
        	$("#edit_reply_id"+id).children("textarea").focus();
        	$("#reply_id"+id).slideUp();
        	
        	$("#edit_reply_id"+id).children("button[comment_id="+id+"]").click(function(){
        		var click = $(this);
        		$.ajax({
        			type: "POST",
        			url: "<?= $cms_url ?>ajax.php?h=update_comment",
        			data: {id:id,comment:$("#edit_reply_id"+id).children("textarea").val()},
        			dataType: "json",
        			beforeSend: function(){
        				click.children("i").show();
        			},
        			success: function(res){
        				click.children("i").hide();
        				console.log(res);
        				if(res.success){
        					getComments();
        				}
        			},error: function(e){
        				click.children("i").hide();
        				console.log(e);
        			}
        		});
        	});
        }



        var globalDelID = 0;

        function del_conf_snackbar(id){
        	$(".main_snackbar").slideDown();
        	globalDelID = id;
        }

        $(".main_snackbar .btn-danger").click(function(){
        	var sel = $(".btn-danger");
        	$.ajax({
        		type: "POST",
        		url: "<?= $cms_url ?>ajax.php?h=delete_my_comment",
        		data: {id:globalDelID},
        		beforeSend: function(){
        			sel.children("i").show();
        		},success: function(res){
        			getCommentCount();
        			getComments();
        			sel.children("i").hide();
        			console.log(res)
        		},error: function(e){
        			sel.children("i").hide();
        			console.log(e)
        		}
        	});
        	$(".snackbar").slideUp();
        });

        $(".main_snackbar .btn-warning").click(function(){
        	globalDelID = 0
        	$(".main_snackbar").slideUp();
        });

        // reply

        function reply_EditComment(id,sel){
        	$("#edit_r_reply_id"+id).stop().slideToggle();
        	$("#edit_r_reply_id"+id).children("textarea").focus();
        	
        	$("#edit_r_reply_id"+id).children("button[comment_id="+id+"]").click(function(){
        		var click = $(this);
        		$.ajax({
        			type: "POST",
        			url: "<?= $cms_url ?>ajax.php?h=reply_update_comment",
        			data: {id:id,comment:$("#edit_r_reply_id"+id).children("textarea").val()},
        			dataType: "json",
        			beforeSend: function(){
        				click.children("i").show();
        			},
        			success: function(res){
        				click.children("i").hide();
        				console.log(res);
        				if(res.success){
        					getComments();
        				}
        			},error: function(e){
        				click.children("i").hide();
        				console.log(e);
        			}
        		});
        	});

        }



        var reply_globalDelID = 0;

        function reply_del_conf_snackbar(id){
        	$(".snackbar.reply").slideDown();
        	reply_globalDelID = id;
        }

        $(".snackbar.reply .btn-danger").click(function(){
        	var sel = $(this);
        	$.ajax({
        		type: "POST",
        		url: "<?= $cms_url ?>ajax.php?h=reply_delete_my_comment",
        		data: {id:reply_globalDelID},
        		beforeSend: function(){
        			sel.children("i").show();
        		},success: function(res){
        			getCommentCount();
        			getComments();
        			sel.children("i").hide();
        			console.log(res)
        		},error: function(e){
        			sel.children("i").hide();
        			console.log(e)
        		}
        	});
        	$(".snackbar.reply").slideUp();
        });

        $(".snackbar.reply .btn-warning").click(function(){
        	reply_globalDelID = 0
        	$(".snackbar.reply").slideUp();
        });

        function showLessMore(sel){
        	sel.toggleClass("active_msg");
        	if(sel.hasClass("active_msg")){
        		sel.text("Show Less");
        		sel.siblings("span").text(sel.attr("comments"));
        	}else{
        		sel.text("Show More");
        		sel.siblings("span").text(sel.attr("comments").substring(0,160));
        	}
        }

        function postComment(sel){
        	var content_id = '<?= $id ?>';
        	var comment = sel.siblings('textarea').val();
        	var comment_id = sel.attr("comment_id");
        	if(comment != ""){
        		<?php 
	        	if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
	        	?>
        		$.ajax({
	              	type: "POST",
	              	url: "<?= $cms_url ?>ajax.php?h=news_CommentReply",
	              	data: {content_id:content_id,comment_id:comment_id,reply_comment:comment},
	              	dataType: "json",
	              	beforeSend: function(){
	              		sel.children("i").show();
	              	},
	              	success: function(res){
	              		sel.children("i").hide();
	              		console.log(res)
	              		if(res.success){
	              			$("#commentform")[0].reset();
	              			sel.siblings().val('');
	              			sel.parent().hide();
	              		}else{
	              			$(".com_not i.fa").attr("class","fa fa-frown-o");
	              			$(".com_not .modal-body p:first").css("color","red");
	              			$(".com_not .modal-body p:last").text("");
	              			$(".com_not .modal-body p:first").text("Failed to post comment");
	              			$(".com_not").show();
	              		}
	              		getComments();
	              		getCommentCount();
	              	},error: function(e){
	              		console.log(e)
	              		sel.children("i").hide();
	              	}
	            });
	            <?php } else{ ?>
        		$("#loginModel").attr("class","modal show");
              		$("#loginModel form").validate({
		        	  errorClass: 'text-danger',
		              submitHandler: function(form){
		              	$.ajax({
		              		type: "POST",
		              		url: "<?= $cms_url ?>ajax.php?h=model_login_reply",
		              		data: $("#loginModel form").serialize(),
		              		dataType: "json",
		              		success: function(res){
		              			console.log(res)
		              			if(res.login_err){
		              				$("#loginModel .log_err i").show();
		              				$("#loginModel .log_err span").text("Failed to login");
	              					$("#loginModel .modal-dialog").css("animation","shake 0.5s");
	              					$("#loginModel .modal-dialog").css("animation-iteration-count","2"); 
		              			}else{
		              				$("#loginModel form")[0].reset();
			              			$("#loginModel").attr("class","modal fade");
			              			$.ajax({
						              	type: "POST",
						              	url: "<?= $cms_url ?>ajax.php?h=news_CommentReply",
						              	data: {content_id:content_id,comment_id:comment_id,reply_comment:comment},
						              	dataType: "json",
						              	success: function(res){
						              		console.log(res)
						              		if(res.success){
						              			// $(".com_not .modal-body p:first").text("Comment post successfully.");
						              			// $(".com_not").show();
						              			// setTimeout(function(){
						              				window.location.reload();
						              			// },2000);
						              		}else{
						              			$(".com_not .modal-body p:first").text("Failed to post comment");
						              			$(".com_not").show();
						              		}
						              		getComments();
						              		getCommentCount();
						              	},error: function(e){
						              		console.log(e)
						              	}
						            });
		              			}
		              		},error: function(e){
		              			console.log(e)
		              		}
		              	});
		                return false;
		              }
		          });
        		<?php } ?>
        		getComments();
        	}
        }

        function AddCommentReply(content,comment){
        	var c_id = comment.attr("comment");
        	$("#reply_id"+c_id).stop().fadeToggle();
        	$("#reply_id"+c_id).children("textarea").focus();
        	$("#edit_reply_id"+c_id).slideUp();
        }

        function closeReplyForm(){
        	$("#reply_comment").attr("class","modal fade")
        	$("#reply_comment input[name=content_id]").val('')
        	$("#reply_comment input[name=comment_id]").val('')
        }

        $().ready(function() {
            // $.validator.addMethod('reply_comment', function (value) { 
            // 	return /^[a-zA-Z\s]*$/i.test(value); 
            // }, 	'Format: Whitespaces & Alphabets Only');

          	$("#reply_comment form").validate({
			    errorClass: 'text-danger',
			    // rules: {
	      //           reply_comment: "required reply_comment",
	      //       },
			    submitHandler: function(form){
			        $.ajax({
			        	type: "POST",
			        	url: "<?= $cms_url ?>ajax.php?h=news_CommentReply",
			        	data: $("#reply_comment form").serialize(),
			        	dataType: "json",
			        	success: function(res){
			        		console.log(res)
			        		if(res.success){
			        			$("#reply_comment").attr("class","model fade").hide();
			        		}else{
								$("#reply_comment .error_msg").attr("class","error_msg alert alert-danger");
			        			$("#reply_comment .error_msg").text(res.error);
			        		}
			        		getComments();
			        		getCommentCount();
			        	},error: function(e){
			        		console.log(e)
			        	}
			        });
					return false;
			    }
		   	});
        });

        function getCommentCount(){
        	$.ajax({
        		type: "POST",
        		url: "<?= $cms_url ?>ajax.php?h=news_CommentsCount",
        		data: {content_id:<?= $id ?>},
        		dataType: "json",
        		success: function(res){
        			if(res.total==0){
        				$(".com_count").text("No Comments")
        			}else{
        				$(".com_count").text("("+res.total+") Comments")
        			}
        			$(".fa-comment").siblings("a:first").text(res.total);
        		},error: function(e){
        			console.log(e)
        		}
        	});
        } getCommentCount();
        <?php 
        $getuser = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$_SESSION['user_id']);
		$UserName = '';
        if(mysqli_num_rows($getuser) > 0){
        	$UserName = mysqli_fetch_assoc($getuser)['username'];
        }
        ?>
function showFullIMG(sel){
          $(".full_img img").attr("src",sel.attr("src"));
          $(window).resize(function(){
            $('.full_img img').css("margin-top",$(".full_img").height() / 2 - ($(".full_img img").height() / 2));
          }).resize();
          setInterval(function(){
            $('.full_img img').css("margin-top",$(".full_img").height() / 2 - ($(".full_img img").height() / 2));
          },500);
          $(".full_img").slideDown();

          $(document).on('keydown', function(event) {
           if (event.key == "Escape") {
               $(".full_img").slideUp();
           }
        });
      $(".full_img").bind("click",function(event){
        if($(event.target).attr('class') != 'img'){
          $(".full_img").slideUp();
        }
      });
    }
         
  </script>
  <style type="text/css">
    .full_img{
      position: fixed;
      display: none;
      z-index: 9999;
      text-align: center;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background: rgba(0,0,0,.5);
    }
    .img{
      max-width: 80%;
      max-height: 80%;
    }
  </style>
  <div class="full_img">
    <i class="fa fa-close" style="position: absolute; top: 10px; right: 10px; color: #fff; cursor: pointer;" onclick="$('.full_img').slideUp();"></i>
    <img class="img">
  </div>

</body>
</html>