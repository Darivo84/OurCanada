<?php
require_once 'cms_error.php';

include_once $basePath.'user_inc.php';
$admin=mysqli_query($conn,"select * from admin where cookie='{$_COOKIE['PHPSESSID']}' and is_logged='1'");
$admin_rows=mysqli_num_rows($admin);
$moderator=mysqli_query($conn,"select * from moderator where cookie='{$_COOKIE['PHPSESSID']}' and is_logged='1'");
$moderator_rows=mysqli_num_rows($moderator);$page = 'inner';

$request = explode( "/", $_SERVER[ 'REQUEST_URI' ] );
$blog_slug = $request[ 3 ];

// 
$slug = explode('?', $blog_slug );
if(count($slug) > 0){
    $blog_slug = $slug[0];
}
//if(explode('_', $news_table)[0] != 'news_content'){
//    $news_table = 'news_content_'.explode('_', $news_table)[1];
//}
if(empty(getCurLang($langURL,true)) || getCurLang($langURL,true) == 'english'){
    $blog_select = mysqli_query( $conn, "SELECT * FROM `".$news_table."` WHERE slug='$blog_slug'" );
}else{
    $blog_select = mysqli_query( $conn, "SELECT * FROM `".$news_table."` WHERE id='$data_id'" );
}
//
$blog_content = mysqli_fetch_assoc( $blog_select );
$id = $blog_content[ 'id' ];
if ( mysqli_num_rows($blog_select) < 1 ) {
    // echo cleanURL('news') ;
    // exit();
    $_SESSION['onetime'] = true;
    //echo false;
    header( "Location:" . cleanURL('news') );
}

if($blog_content['status'] == 0){

    if(isset($_SESSION['user_id'])){
        if($_SESSION['user_id'] != $blog_content['creator_id']){
            if($moderator_rows<1 && $admin_rows<1){
                header( "Location:" . $cms_url . "blogs".getCurLang($langURL) );
                exit();
            }else{
                header( "Location:" . $cms_url . "blogs".getCurLang($langURL) );
                exit();
            }
        }
    }else{
        if(($moderator_rows<1 && $admin_rows<1) || isset($_SESSION['user_id'])){
            header( "Location:" . $cms_url . "blogs".getCurLang($langURL) );
            exit();
        }
    }
}

if($blog_content['created_by'] == 0){
    $fetch = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$blog_content['creator_id']);
    $author_row = mysqli_fetch_assoc($fetch);

    if(!empty($author_row) && $author_row['role'] == 0){
        $author = $author_row['username'];
    }else{
        $author = 'Our Canada Services';
    }
}else{
    $author = 'Our Canada Services';
}


$cate_list = mysqli_query($conn,"SELECT * FROM category_blog WHERE id IN(".$blog_content['category'].")");
$cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
$tags = [];
while ($cate_row = mysqli_fetch_assoc($cate_list)) {
    array_push($tags, $cate_row['title'.$cate_title]);
}
// $tags = explode( ",", $blog_content[ 'category' ] );
$images = explode( ",", $blog_content[ 'slider_images' ] );
$video = '';
$video_local = explode( ",", $blog_content[ 'video' ] );
$video_url = explode( ",", $blog_content[ 'embed' ] );

$querycount1="SELECT count(id) as count FROM `".$news_table."`";
$result21 = mysqli_query( $conn, $querycount1 );
$row11 = mysqli_fetch_assoc($result21);
$blogcount=$row11['count'];

$querycount="SELECT count(id) as count FROM `news_content` where status=1";
$result2 = mysqli_query( $conn, $querycount );
$row1 = mysqli_fetch_assoc($result2);
$newscount=$row1['count'];

$prev = mysqli_query( $conn, "SELECT title,slug,id FROM `".$news_table."` ORDER BY RAND() DESC LIMIT 1" );
$prevpost= mysqli_fetch_assoc( $prev );

$nextCount = mysqli_query( $conn, "SELECT COUNT(*) as total FROM ".$news_table );
$getNextCount = mysqli_num_rows($nextCount);
$next = mysqli_query( $conn, "SELECT title,slug,id FROM `".$news_table."` WHERE id != ".$blog_content['id']." && status = 1 ORDER BY RAND() ASC LIMIT 1" );
$nextpost= mysqli_fetch_assoc( $next );
if(!empty(getCurLang($langURL,true))){
    $nextpost['slug'] = rand(10,999999).'-'.$nextpost['id'];
}
$ip = $_SERVER['REMOTE_ADDR'];
$likeCheck = mysqli_query($conn,"SELECT * FROM likes WHERE content_id = ".$id." && (visitor_id = ".$_SESSION['user_id']." || visitor_ip = '".$ip."')");
$liked = false;
if(mysqli_num_rows($likeCheck) > 0){
    $liked = true;
}else{
    $liked = false;
}

$social_image = explode(',', $blog_content['slider_images']);

$img_path = getContentMedia('image',$social_image[0]);

if ( $blog_content[ "type" ] == "video-image-news" or
    $blog_content[ "type" ] == "video-image-blog" or
    $blog_content["type"]=="image-slider-news" or
    $blog_content["type"]=="image-slider-blog" )
{
    $photo = $img_path;
} elseif ( $blog_content[ "type" ] == "video-news" || $blog_content[ "type" ] == "video-blog" ) {

    if(!empty($blog_content['embed'])){
        $photo = 'http://img.youtube.com/vi/'.explode('embed/', $blog_content['embed'])[1].'/hqdefault.jpg';
    }else{
        // $photo = $cms_url.'uploads/images/'.$blog_content['single_image'];
        $photo = getContentMedia('image',$blog_content['single_image']);
    }


} else if($blog_content["type"]=="simplenews" || $blog_content["type"]=="simpleblog"){
    // $photo = $cms_url.'uploads/gallery/'.$blog_content['content_thumbnail'];
    $photo = getContentMedia('image',$blog_content['content_thumbnail'],true);
}

// echo date_format(date_create($blog_content['created_at']),'Y-m-d H:i a');
?>
<!DOCTYPE html>
<!--[if IE 9 ]>
<html class="ie ie9" lang="en-US">
<![endif]-->
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <meta property="og:title" content="<?= $blog_content['title'] ?>" />
    <meta property="og:description" content="<?= $blog_content['description'] ?>" />
    <meta property="og:image" content="<?=$photo  ?>" />
    <?php
    if($environment)
    {
    ?>
    <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/news-details" />

        <?php
    }
    ?>
    <!-- Title-->
    <title><?= $allLabelsArray[665] ?></title>
    <!-- Favicon-->

    <!-- Stylesheets-->
    <?php include($basePath."includes/style.php") ?>
    <!-- end head -->
    <style type="text/css">
        .post_content p{
            word-wrap: break-word !important;
        }
    </style>
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div id="snackbarMSG" class="col-lg-4">
    <p></p>
</div>
<div class="options_layout_wrapper jl_none_box_styles jl_border_radiuss">
    <div class="options_layout_container full_layout_enable_front">
        <!-- Start header -->
        <?php include($basePath."includes/header.php") ?>

        <?php if ($blog_content['type']=='simplenews' || $blog_content['type'] == 'pdf-news'): ?>
            <div class="jl_home_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8  loop-large-post" id="content">
                            <div class="widget_container content_page">
                                <!-- start post -->
                                <div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
                                    <div class="single_section_content box blog_large_post_style">
                                        <div class="jl_single_style2">
                                            <div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small" style="z-index: 999; display: block !important;">

									          <?php foreach ($tags as $key => $value):
                                                  if($value!=null){?>
                                                      <a class="post-category-color-text" style="background:#FE0000; margin-right: 10px;">
									                        <?php echo $value ?>
									                      </a>
                                                  <?php }endforeach ?>

									          </span>
                                                <h1 class="single_post_title_main">
                                                    <?php echo $blog_content['title']; ?>
                                                </h1>
                                                <p class="post_subtitle_text">
                                                    <?php echo $blog_content['description']; ?>
                                                </p>
                                                <span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="<?php if($author_row['id'] != 0){echo cleanURL('user/'.$author_row['id']);}else{echo '';} ?>" rel="author"><?php echo $author; ?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo time_ago($blog_content['created_at']); ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a style="margin-right: 20px;">0 <?= $allLabelsArray[672]?></a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span></span></span></span>
                                            </div>
                                        </div>
                                        <div class="post_content" style="margin-top: 20px;">
                                            <?php if(!empty($blog_content["quote"]) && $blog_content["quote"] != null){ ?>
                                                <blockquote>
                                                    <p style="text-align: center;"><?php echo $blog_content['quote']; ?></p>
                                                </blockquote>
                                            <?php } ?>
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_one']; ?>
                                            </p>
                                            <?php if($blog_content['type'] == 'pdf-news'){ ?>
                                                <embed src="<?= $cms_url ?>uploads/pdf_files/<?= $blog_content['pdf_path'] ?>" width="100%" height="600px" />
                                            <?php } ?>
                                            
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_two']; ?>
                                            </p>
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_three']; ?>
                                            </p style="text-align: justify;">
                                            <p>
                                                <?php echo $blog_content['content_four']; ?>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="single_tag_share">
                                            <div class="tag-cat">
                                                <ul class="single_post_tag_layout">
                                                    <?php $t = explode(',', $blog_content['tages']); for ($i=0; $i < count($t); $i++) { ?>
                                                        <li>
                                                            <span class="tag label label-danger mr-2">#<?php echo $t[$i]; ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="single_post_share_icons"> <?= $allLabelsArray[667] ?><i class="fa fa-share-alt"></i>
                                            </div>
                                        </div>
                                        <div class="single_post_share_wrapper">
                                            <div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
                                            </div>
                                            <ul class="single_post_share_icon_post">
                                                <li class="single_post_share_facebook"><a href="https://www.facebook.com/sharer/sharer.php?u=<?= $cms_url.'news/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                                </li>
                                                <li class="single_post_share_twitter"><a href="http://twitter.com/share?text=&url=<?= $cms_url.'news/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                                </li>
                                                <li class="single_post_share_pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?= $cms_url.'news/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                                                </li>
                                                <li class="single_post_share_linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $cms_url.'news/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                                </li>
                                                <li class="single_post_share_ftumblr"><a href="https://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=<?= $cms_url.'news/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <?php

                                        if($prevpost["title"]!=null){
                                            ?>
                                            <!--										<div class="postnav_left">-->
                                            <!--											-->
                                            <!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."blog/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
                                            <!--										</div>-->
                                        <?php }

                                        if($getNextCount > 1 && !empty($nextpost["title"]) && $nextpost['id']!==$blog_content['id']){
                                            ?>
                                            <div class="postnav_right">

                                            <div class="single_post_arrow_content"> <a href="<?php echo cleanURL('news/'.$nextpost['slug']) ?>" id="nextpost"><?php echo displayTitle($nextpost["title"],50);?><span class="jl_post_nav_left">  <?= $allLabelsArray[666] ?></span></a> </div>
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



                                            <h3 id="reply-title" class="comment-reply-title"><?= $allLabelsArray[669] ?> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;"><?= $allLabelsArray[671] ?></a></small></h3>
                                            <form id="commentform" class="comment-form">
                                                <p class="comment-notes"><span id="email-notes"><?= $allLabelsArray[670] ?></span>
                                                </p>
                                                <p class="comment-form-comment">
                                                    <textarea maxlength="1000" class="u-full-width" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="<?= $allLabelsArray[672] ?>" required></textarea>
                                                <p class="text-danger" id="com_error"></p>
                                                </p>
                                                <!-- <div class="form-fields row">
                                                    <span class="comment-form-author col-md-4">
                                                        <input id="author" name="author" type="text"  size="30" placeholder="Fullname" required>
                                                    </span>
                                                   <span class="comment-form-email col-md-4">
                                                       <input id="email" name="email" type="email" size="30" placeholder="Email Address" required>
                                                   </span>
                                                   <span class="comment-form-url col-md-4">
                                                       <input id="url" name="url" type="url" size="30" placeholder="Web URL" required>
                                                   </span>
                                                </div> -->
                                                <p class="form-submit">
                                                    <input type="submit" id="submit" class="submit" value="<?= $allLabelsArray[728] ?>">
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- end post -->



                            </div>
                        </div>
                        <!-- start sidebar -->
                        <?php include_once("sidebar.php"); ?>
                        <!-- end sidebar -->
                    </div>
                </div>
            </div>
        <?php endif ?>
        <!-- end if of simple blog -->
        <!-- if of image-slider-blog -->
        <?php if ($blog_content['type']=='image-slider-blog' || $blog_content['type']=='image-slider-news'): ?>
            <div class="jl_home_section jl_home_slider">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8  loop-large-post" id="content">
                            <div class="widget_container content_page">
                                <!-- start post -->
                                <div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
                                    <div class="single_section_content box blog_large_post_style">
                                        <div class="jl_single_style2">
                                            <div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small" style="z-index: 999; display: block !important;">

									          <?php foreach ($tags as $key => $value):
                                                  if($value!=null){?>
                                                      <a class="post-category-color-text" style="background:#FE0000; margin-right: 10px;">
									                        <?php echo $value ?>
									                      </a>
                                                  <?php }endforeach ?>

									          </span>
                                                <h1 class="single_post_title_main">
                                                    <?php echo $blog_content['title']; ?>
                                                </h1>
                                                <p class="post_subtitle_text">
                                                    <?php echo $blog_content['description']; ?>
                                                </p>
                                                <span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="<?php if($author_row['id'] != 0){echo cleanURL('user/'.$author_row['id']);}else{echo '';} ?>" rel="author"><?php echo $author; ?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo time_ago($blog_content['created_at']); ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a style="margin-right: 20px;">0 <?= $allLabelsArray[672]?></a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span></span></span></span>
                                            </div>
                                            <div class="col-md-12 jl_mid_main_3col" style="padding: 0;">
                                                <div class="single_content_header jl_single_feature_below">
                                                    <div class="image-post-thumb jlsingle-title-above">
                                                        <div class="justified-gallery-post justified-gallery" id="image_list" style="height: 510.762px;">
                                                            <?php for($i = 0; $i < count($images); $i++){ if(!empty($images[$i])){
                                                                $img_path = getContentMedia('image',$images[$i]);

                                                                //              	if(count(explode('uploads/gallery/', $images[$i])) > 1){
                                                                //   $img_path = $cms_url.$images[$i];
                                                                // }else{
                                                                // 	if(count(explode('uploads/images/', $images[$i])) > 1){
                                                                // 	  $img_path = $cms_url.$images[$i];
                                                                // 	}else{
                                                                // 		$img_path = $cms_url."uploads/images/".$images[$i];
                                                                // 	}
                                                                // }

                                                                ?>
                                                                <a class="featured-thumbnail jg-entry entry-visible" href="<?= $img_path ?>" style="width: 380px; height: 253.127px; top: 1px; left: 1px;">
                                                                    <img src="<?= $img_path ?>" alt="" style="width: 380px; height: 254px; margin-left: -190px; margin-top: -127px;">
                                                                    <div class="background_over_image"></div>
                                                                </a>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="page_builder_slider jelly_homepage_builder">
						                                    <div class="jl_slider_nav_tab large_center_slider_container">
						                                       <div class="row header-main-slider-large">
						                                          <div class="col-md-12">
						                                             <div class="large_center_slider_wrapper">
						                                                <div class="home_slider_header_tab jelly_loading_pro">
																			<?php foreach ($images as $value){
                                                    if($value!=""){?>

						                                                   <div class="item">
						                                                      <div class="banner-carousel-item"> <span class="image_grid_header_absolute" style="background-image: url('<?php echo 'https://ourcanadadev.site/superadmin/uploads/images/'.$value?>')"></span>


						                                                      </div>
						                                                   </div>
																			<?php }}?>
						                                                </div>
						                                                <div class="jlslide_tab_nav_container">
						                                                   <div class="jlslide_tab_nav_row">
						                                                      <div class="home_slider_header_tab_nav news_tiker_loading_pro">
																				  <?php foreach ($images as $value){
                                                    if($value!=""){?>
						                                                         <div class="item">
						                                                            <div class="banner-carousel-item"> <span class="image_small_nav" style="background-image: url('<?php echo 'https://ourcanadadev.site/superadmin/uploads/images/'.$value?>')"></span>

						                                                            </div>
						                                                         </div>
																			<?php }}?>
						                                                      </div>
						                                                   </div>
						                                                </div>
						                                             </div>
						                                          </div>
						                                       </div>
						                                    </div>
						                                 </div> -->
                                            </div>
                                        </div>
                                        <div class="post_content">

                                            <?php if(!empty($blog_content["quote"]) && $blog_content["quote"] != null){ ?>
                                                <blockquote>
                                                    <p style="text-align: center;"><?php echo $blog_content['quote']; ?></p>
                                                </blockquote>
                                            <?php } ?>                                                        

                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_one']; ?><span id="more-2808"></span>
                                            </p>
                                            
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_two']; ?>
                                            </p>
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_three']; ?>
                                            </p>
                                            <?php if($blog_content['single_image'] !== '') { ?>
                                                <?php
                                                if(count(explode('uploads/gallery/', $blog_content['single_image'])) > 1){
                                                    $img_path = $cms_url.$blog_content['single_image'];
                                                }else{
                                                    $img_path = $cms_url."uploads/images/".$blog_content['single_image'];
                                                }
                                                ?>
                                                <?php if(!empty($blog_content['single_image'])){ ?>
                                                    <p><img onclick="showFullIMG($(this));" class="size-full wp-image-4866 alignnone" src="<?php echo $img_path ?>" alt="" width="1920" height="1080"/>
                                                    </p>
                                                <?php } ?>
                                            <?php } ?>
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_four']; ?>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="single_tag_share">
                                            <div class="tag-cat">
                                                <ul class="single_post_tag_layout">
                                                    <?php $t = explode(',', $blog_content['tages']); for ($i=0; $i < count($t); $i++) { ?>
                                                        <li>
                                                            <span class="tag label label-danger mr-2">#<?php echo $t[$i]; ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="single_post_share_icons"> <?= $allLabelsArray[667] ?><i class="fa fa-share-alt"></i>
                                            </div>
                                        </div>
                                        <div class="single_post_share_wrapper">
                                            <div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
                                            </div>
                                            <ul class="single_post_share_icon_post">
                                                <li class="single_post_share_facebook"><a href="https://www.facebook.com/sharer.php?u=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                                </li>
                                                <li class="single_post_share_twitter"><a href="http://twitter.com/share?text=&url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                                </li>
                                                <li class="single_post_share_pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                                                </li>
                                                <li class="single_post_share_linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                                </li>
                                                <li class="single_post_share_ftumblr"><a href="https://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php
                                        if($prevpost["title"]!=null){
                                            ?>
                                            <!--										<div class="postnav_left">-->
                                            <!--											-->
                                            <!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."blog/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
                                            <!--										</div>-->
                                        <?php }

                                        if(!empty($nextpost["title"]) && $nextpost['id']!==$blog_content['id']){
                                            ?>
                                            <div class="postnav_right">

                                            <div class="single_post_arrow_content"> <a href="<?php echo cleanURL('news/'.$nextpost['slug']) ?>" id="nextpost"><?php echo displayTitle($nextpost["title"],50);?><span class="jl_post_nav_left">  <?= $allLabelsArray[666] ?></span></a> </div>
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

                                        <!-- Comments -->
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



                                            <h3 id="reply-title" class="comment-reply-title"><?= $allLabelsArray[669] ?> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;"><?= $allLabelsArray[671] ?></a></small></h3>
                                            <form id="commentform" class="comment-form">
                                                <p class="comment-notes"><span id="email-notes"><?= $allLabelsArray[670] ?></span>
                                                </p>
                                                <p class="comment-form-comment">
                                                    <textarea maxlength="1000" class="u-full-width" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="<?= $allLabelsArray[672]?>" required></textarea>
                                                <p class="text-danger" id="com_error"></p>

                                                </p>
                                                <!-- <div class="form-fields row">
                                                    <span class="comment-form-author col-md-4">
                                                        <input id="author" name="author" type="text"  size="30" placeholder="Fullname" required>
                                                    </span>
                                                   <span class="comment-form-email col-md-4">
                                                       <input id="email" name="email" type="email" size="30" placeholder="Email Address" required>
                                                   </span>
                                                   <span class="comment-form-url col-md-4">
                                                       <input id="url" name="url" type="url" size="30" placeholder="Web URL" required>
                                                   </span>
                                                </div> -->
                                                <p class="form-submit">
                                                    <input type="submit" id="submit" class="submit" value="<?= $allLabelsArray[728] ?>">
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
                        <?php include_once("sidebar.php"); ?>
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- jl-home-section -->
        <?php endif ?>
        <!-- end if of image-slider-blog -->
        <!-- if of video-blog -->
        <?php if ($blog_content['type']=='video-news'): ?>
        <div class="jl_home_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8  loop-large-post" id="content">
                        <div class="widget_container content_page">
                            <!-- start post -->
                            <div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
                                <div class="single_section_content box blog_large_post_style">
                                    <div class="jl_single_style2">
                                        <div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small" style="z-index: 999; display: block !important;">

									          <?php foreach ($tags as $key => $value):
                                                  if($value!=null){?>
                                                      <a class="post-category-color-text" style="background:#FE0000; margin-right: 10px;">
									                        <?php echo $value ?>
									                      </a>
                                                  <?php }endforeach ?>

									          </span>
                                            <h1 class="single_post_title_main">
                                                <?php echo $blog_content['title']; ?> </h1>
                                            <p class="post_subtitle_text">
                                                <?php echo $blog_content['description']; ?> </p>
                                            <span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="<?php if($author_row['id'] != 0){echo cleanURL('user/'.$author_row['id']);}else{echo '';} ?>"  rel="author"><?php echo $author; ?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo time_ago($blog_content['created_at']); ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a style="margin-right: 20px;">0 <?= $allLabelsArray[672]?></a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span></span></span></span>
                                        </div>
                                        <?php if(!empty($blog_content['video'])){

                                            $img_path = getContentMedia('video',$blog_content['video']);


                                            // if(count(explode('uploads/gallery/', $blog_content['video'])) > 1){
                                            //                     $img_path = $cms_url.$blog_content['video'];
                                            //                   }else{
                                            //                     $img_path = $cms_url."uploads/videos/".$blog_content['video'];
                                            //                   }
                                            ?>
                                            <div class="single_content_header jl_single_feature_below">
                                                <div class="image-post-thumb jlsingle-title-above">
                                                    <video class="blogvideo" src="<?php echo $img_path ?>" width="750" height="400" controls></video>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="post_content">

                                        <?php if(!empty($blog_content["quote"]) && $blog_content["quote"] != null){ ?>
                                            <blockquote>
                                                <p style="text-align: center;"><?php echo $blog_content['quote']; ?></p>
                                            </blockquote>
                                        <?php } ?>

                                        <p style="text-align: justify;">
                                            <?php echo $blog_content['content_one']; ?><span id="more-2808"></span>
                                        </p>
                                        
                                        <p style="text-align: justify;">
                                            <?php echo $blog_content['content_two']; ?>
                                        </p>
                                        <p style="text-align: justify;">
                                            <?php echo $blog_content['content_three']; ?>
                                        </p>
                                        <?php if(!empty($blog_content['embed'])){ ?>
                                            <p style="float: left; width: 100%;">
                                                <iframe width="560" height="315" src="<?= $blog_content['embed'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </p>
                                        <?php } ?>
                                        <p>
                                        <p style="text-align: justify;">
                                            <?php echo $blog_content['content_four']; ?>
                                        </p>
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="single_tag_share">
                                        <div class="tag-cat">
                                            <ul class="single_post_tag_layout">
                                                <?php $t = explode(',', $blog_content['tages']); for ($i=0; $i < count($t); $i++) { ?>
                                                    <li >
                                                        <span class="tag label label-danger mr-2">#<?php echo $t[$i]; ?></span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="single_post_share_icons">  <?= $allLabelsArray[667] ?><i class="fa fa-share-alt"></i>
                                        </div>
                                    </div>
                                    <div class="single_post_share_wrapper">
                                        <div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
                                        </div>
                                        <ul class="single_post_share_icon_post">
                                            <li class="single_post_share_facebook"><a href="https://www.facebook.com/sharer.php?u=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                            </li>
                                            <li class="single_post_share_twitter"><a href="http://twitter.com/share?text=&url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                            </li>
                                            <li class="single_post_share_pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                                            </li>
                                            <li class="single_post_share_linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                            </li>
                                            <li class="single_post_share_ftumblr"><a href="https://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php

                                    if($prevpost["title"]!=null){
                                        ?>
                                        <!--										<div class="postnav_left">-->
                                        <!--											-->
                                        <!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."blog/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
                                        <!--										</div>-->
                                    <?php }

                                    if(!empty($nextpost["title"]) && $nextpost['id']!==$blog_content['id']){
                                        ?>
                                        <div class="postnav_right">

                                        <div class="single_post_arrow_content"> <a href="<?php echo cleanURL('news/'.$nextpost['slug']) ?>" id="nextpost"><?php echo displayTitle($nextpost["title"],50);?><span class="jl_post_nav_left">  <?= $allLabelsArray[666] ?></span></a> </div>
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
                                    <!-- Comments -->
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



                                        <h3 id="reply-title" class="comment-reply-title"><?= $allLabelsArray[669] ?> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;"><?= $allLabelsArray[671] ?></a></small></h3>
                                        <form id="commentform" class="comment-form">
                                            <p class="comment-notes"><span id="email-notes"><?= $allLabelsArray[670] ?></span>
                                            </p>
                                            <p class="comment-form-comment">
                                                <textarea maxlength="1000" class="u-full-width" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="<?= $allLabelsArray[672]?>" required></textarea>
                                            <p class="text-danger" id="com_error"></p>

                                            </p>

                                            <p class="form-submit">
                                                <input type="submit" id="submit" class="submit" value="<?= $allLabelsArray[728] ?>">
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
            <!-- end if of video-blog -->
            <!-- if of video-image-blog -->
            <?php if ($blog_content['type']=='video-image-news'): ?>
            <div class="jl_home_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8  loop-large-post" id="content">
                            <div class="widget_container content_page">
                                <!-- start post -->
                                <div class="post-2808 post type-post status-publish format-standard has-post-thumbnail hentry category-business tag-gaming tag-morning tag-relaxing" id="post-2808">
                                    <div class="single_section_content box blog_large_post_style">
                                        <div class="jl_single_style2">
                                            <div class="single_post_entry_content single_bellow_left_align jl_top_single_title jl_top_title_feature"> <span class="meta-category-small" style="z-index: 999; display: block !important;">

									          <?php foreach ($tags as $key => $value):
                                                  if($value!=null){?>
                                                      <a class="post-category-color-text" style="background:#FE0000; margin-right: 10px;">
									                        <?php echo $value ?>
									                      </a>
                                                  <?php }endforeach ?>

									          </span>
                                                <h1 class="single_post_title_main">
                                                    <?php echo $blog_content['title']; ?> </h1>
                                                <p class="post_subtitle_text">
                                                    <?php echo $blog_content['description']; ?> </p>
                                                <span class="single-post-meta-wrapper"><span class="post-author"><span><img src="<?php echo $url?>assets/img/favicon.jpg" width="50" height="50" alt="Admin" class="avatar avatar-50 wp-user-avatar wp-user-avatar-50 alignnone photo" /><a href="<?php if($author_row['id'] != 0){echo cleanURL('user/'.$author_row['id']);}else{echo '';} ?>" rel="author"><?php echo $author; ?></a></span></span><span class="post-date updated"><i class="fa fa-clock-o"></i><?php echo time_ago($blog_content['created_at']); ?></span><span class="meta-comment"><i class="fa fa-comment" onclick='$("html, body").animate({ scrollTop: $(".comment-respond").offset().top }, 1000);'></i><a style="margin-right: 20px;">0 <?= $allLabelsArray[672]?></a><a class="jm-post-like" data-post_id="2965" title="Like" onclick="addLike($(this));"><i <?php if($liked){echo 'style="color: red !important;"';} ?> class="fa <?php if($liked){echo 'fa-heart';}else{ echo 'fa-heart-o'; } ?>"></i><span <?php if($liked){echo 'style="color: red !important;"';} ?>>0</span></a><span class="view_options"><i class="fa fa-eye"></i><span></span></span></span>
                                            </div>
                                            <?php if(!empty($video_local[0]) || !empty($blog_content['embed'])){
                                                if(empty($blog_content['embed'])){
                                                    $vid_path = getContentMedia('video',$video_local[0]);
                                                }
                                                // $d = explode('/', $video_local[0]);
                                                // if($d[1] == 'gallery'){
                                                // 	$vid_path = $cms_url.$video_local[0];
                                                // }else{
                                                // 	$vid_path = $cms_url."uploads/videos/".$video_local[0];
                                                // }
                                                ?>
                                                <div class="single_content_header jl_single_feature_below">
                                                    <div class="image-post-thumb jlsingle-title-above">
                                                        <?php if(empty($blog_content['embed'])){ ?>
                                                        <video class="blogvideo" src="<?php echo $vid_path ?>" width="750" height="400" controls></video>
                                                        <?php }else{ ?>
                                                        <iframe src="<?= $blog_content['embed'] ?>" style="min-width: 100%; max-width: 750px; height: 400px;"></iframe>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="post_content">

                                            <?php if(!empty($blog_content["quote"]) && $blog_content["quote"] != null){ ?>
                                                <blockquote>
                                                    <p style="text-align: center;"><?php echo $blog_content['quote']; ?></p>
                                                </blockquote>
                                            <?php } ?>

                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_one']; ?><span id="more-2808"></span>
                                            </p>
                                            
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_two']; ?>
                                            </p>
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_three']; ?>
                                            </p>
                                            <div class="col-md-12 jl_mid_main_3col" style="padding: 0;">
                                                <div class="single_content_header jl_single_feature_below">
                                                    <div class="image-post-thumb jlsingle-title-above">
                                                        <div class="justified-gallery-post justified-gallery" id="image_list" style="height: 510.762px;">
                                                            <?php for($i = 0; $i < count($images); $i++){ if(!empty($images[$i])){
                                                                $img_path = getContentMedia('image',$images[$i]);
                                                                //  if(count(explode('uploads/gallery/', $images[$i])) > 1){
                                                                //   $img_path = $cms_url.$images[$i];
                                                                // }else{
                                                                // 	if(count(explode('uploads/images/', $images[$i])) > 1){
                                                                // 		$img_path = $cms_url.$images[$i];
                                                                // 	}else{
                                                                // 		$img_path = $cms_url."uploads/images/".$images[$i];
                                                                // 	}
                                                                // }
                                                                ?>

                                                                <a class="featured-thumbnail jg-entry entry-visible" href="<?=  $img_path; ?>" style="width: 380px; height: 253.127px; top: 1px; left: 1px;">
                                                                    <img src="<?= $img_path ?>" alt="" style="width: 380px; height: 254px; margin-left: -190px; margin-top: -127px;">
                                                                    <div class="background_over_image"></div>
                                                                </a>
                                                            <?php }} ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="page_builder_slider jelly_homepage_builder">
                                    <div class="jl_slider_nav_tab large_center_slider_container">
                                       <div class="row header-main-slider-large">
                                          <div class="col-md-12">
                                             <div class="large_center_slider_wrapper">
                                                <div class="home_slider_header_tab jelly_loading_pro">
													<?php foreach ($images as $value){
                                                    if($value!=""){?>

                                                   <div class="item">
                                                      <div class="banner-carousel-item"> <span class="image_grid_header_absolute" style="background-image: url('<?php echo 'https://ourcanadadev.site/superadmin/uploads/images/'.$value?>')"></span>


                                                      </div>
                                                   </div>
													<?php }}?>
                                                </div>
                                                <div class="jlslide_tab_nav_container">
                                                   <div class="jlslide_tab_nav_row">
                                                      <div class="home_slider_header_tab_nav news_tiker_loading_pro">
														  <?php foreach ($images as $value){
                                                    if($value!=""){?>
                                                         <div class="item">
                                                            <div class="banner-carousel-item"> <span class="image_small_nav" style="background-image: url('<?php echo 'https://ourcanadadev.site/superadmin/uploads/images/'.$value?>')"></span>

                                                            </div>
                                                         </div>
													<?php }}?>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div> -->
                                            </div>
                                            <p style="text-align: justify;">
                                                <?php echo $blog_content['content_four']; ?>
                                            </p>
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="single_tag_share">
                                            <div class="tag-cat">
                                                <ul class="single_post_tag_layout">
                                                    <?php $t = explode(',', $blog_content['tages']); for ($i=0; $i < count($t); $i++) { ?>
                                                        <li>
                                                            <span class="tag label label-danger mr-2">#<?php echo $t[$i]; ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <div class="single_post_share_icons">  <?= $allLabelsArray[667] ?><i class="fa fa-share-alt"></i>
                                            </div>
                                        </div>
                                        <div class="single_post_share_wrapper">
                                            <div class="single_post_share_icons social_popup_close"><i class="fa fa-close"></i>
                                            </div>
                                            <ul class="single_post_share_icon_post">
                                                <li class="single_post_share_facebook"><a href="https://www.facebook.com/sharer.php?u=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                                                </li>
                                                <li class="single_post_share_twitter"><a href="http://twitter.com/share?text=&url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                                                </li>
                                                <li class="single_post_share_pinterest"><a href="http://pinterest.com/pin/create/button/?url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-pinterest"></i></a>
                                                </li>
                                                <li class="single_post_share_linkedin"><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-linkedin"></i></a>
                                                </li>
                                                <li class="single_post_share_ftumblr"><a href="https://www.tumblr.com/widgets/share/tool?shareSource=legacy&canonicalUrl=<?= $cms_url.'blog/'.$blog_content['slug'] ?>" target="_blank"><i class="fa fa-tumblr"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php

                                        if($prevpost["title"]!=null){
                                            ?>
                                            <!--										<div class="postnav_left">-->
                                            <!--											-->
                                            <!--											<div class="single_post_arrow_content"> <a href="--><?php //echo $url."blog/".$prevpost['slug']; ?><!--" id="prepost"> --><?php //echo $prevpost["title"];?><!-- <span class="jl_post_nav_left"> Previous post</span></a> </div>-->
                                            <!--										</div>-->
                                        <?php }

                                        if(!empty($nextpost["title"]) && $nextpost['id']!==$blog_content['id']){
                                            ?>
                                            <div class="postnav_right">

                                            <div class="single_post_arrow_content"> <a href="<?php echo cleanURL('news/'.$nextpost['slug']) ?>" id="nextpost"><?php echo displayTitle($nextpost["title"],50);?><span class="jl_post_nav_left">  <?= $allLabelsArray[666] ?></span></a> </div>
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
                                        <!-- Comments -->
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



                                            <h3 id="reply-title" class="comment-reply-title"><?= $allLabelsArray[669] ?> <small><a rel="nofollow" id="cancel-comment-reply-link" href="#" style="display:none;"><?= $allLabelsArray[671] ?></a></small></h3>
                                            <form id="commentform" class="comment-form">
                                                <p class="comment-notes"><span id="email-notes"><?= $allLabelsArray[670] ?></span>
                                                </p>
                                                <p class="comment-form-comment">
                                                    <textarea maxlength="1000" class="u-full-width" id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="<?= $allLabelsArray[672]?>" required></textarea>
                                                <p class="text-danger" id="com_error"></p>

                                                </p>
                                                <!-- <div class="form-fields row">
                                                    <span class="comment-form-author col-md-4">
                                                        <input id="author" name="author" type="text"  size="30" placeholder="Fullname" required>
                                                    </span>
                                                   <span class="comment-form-email col-md-4">
                                                       <input id="email" name="email" type="email" size="30" placeholder="Email Address" required>
                                                   </span>
                                                   <span class="comment-form-url col-md-4">
                                                       <input id="url" name="url" type="url" size="30" placeholder="Web URL" required>
                                                   </span>
                                                </div> -->
                                                <p class="form-submit">
                                                    <input type="submit" id="submit" class="submit" value="<?= $allLabelsArray[728] ?>">
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

                <!-- login model -->
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
                            <p style="text-align: center;font-size: 36px;color: green;font-style: italic;"> <?= $allLabelsArray[565] ?></p><p style="text-align: center;font-size: 15px;color: #484848;/*! font-style: italic; */">Waiting Admin for Approval</p>
                        </div>
                        <div class="modal-footer" style="/*! border-top: 0; */border: 0;text-align: center;">
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').slideUp();" style="width: 150px;background: #92683e;color: #fff;">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php include($basePath."includes/footer.php") ?>
        </div>
    </div>
    <div class="modal fade" id="reply_comment" role="dialog" style="background: rgba(0,0,0,.5);">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button onclick="closeReplyForm();" type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> <?= $allLabelsArray[676] ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="error_msg"></div>
                        <input type="hidden" hidden name="content_id">
                        <input type="hidden" hidden name="comment_id">
                        <textarea required name="reply_comment" placeholder=" <?= $allLabelsArray[682] ?>" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" data-dismiss="modal"><?= $allLabelsArray[728] ?></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="closeReplyForm();"><?= $allLabelsArray[174] ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" style="background: rgba(0,0,0,.5);" id="loginModelLike" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content">
                <div class="modal-header" style="background: #8d633a;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff; text-align: center;"><?= $allLabelsArray[11] ?></h5>
                    <button style="position: absolute; top: 20px; right: 15px; color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#loginModelLike form')[0].reset(); $('#loginModelLike').modal(); $('#loginModelLike .log_err i').hide(); $('#loginModelLike .log_err span').text('');">
                        <span style="color: #fff;" aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="text-danger log_err" style="color: red; width: 100%; text-align: center;">

                            <span style="font-weight: bold;"></span>
                        </div>
                        <div class="form-group" style="position: relative;">
                            <label><?= $allLabelsArray[173] ?></label>
                            <i class="fa fa-envelope inputIcon"></i>
                            <input type="email" placeholder="abc@gmail.com" name="email" class="form-control loginInput" required>
                        </div>
                        <div class="form-group" style="position: relative;">
                            <label><?= $allLabelsArray[146] ?></label>
                            <i class="fa fa-key inputIcon" ></i>
                            <i class="fa fa-eye-slash" onclick="show_hide($(this));" style="color: #8d633a; position: absolute; right: 12px; top: 41px;"></i>
                            <input type="password" placeholder="<?= $allLabelsArray[146] ?>" name="password" class="form-control loginInput" required>
                        </div>
                        <div style="position: relative;" class="form-group text-right">
                            <a href="<?= $cms_url ?>forgot-password<?= $langURL ?>" style="font-weight: bold;color: #8d633a;"><?= $allLabelsArray[220] ?></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center; border: 0;">
                    <button type="submit" class="btn btn-primary" style="width: 200px; background: #8d633a; border: 0; margin-bottom: 5px;"><?= $allLabelsArray[11] ?></button>
                    <br>
                    <?= $allLabelsArray[675] ?><a href="<?= $cms_url ?>register"><b style="color: #8d633a; margin-left: 10px;"><?= $allLabelsArray[203] ?></b></a>

                </div>
                <!-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('#loginModelLike form')[0].reset(); $('#loginModelLike').modal();">Close</button>
                  <button type="submit" class="btn btn-primary"><i class="fa fa-spin fa-spinner" style="display: none;"></i> Login</button>
                </div> -->
            </form>
        </div>
    </div>
    <div class="modal login_like" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $allLabelsArray[563] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.com_not').hide();">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').hide();"><?= $allLabelsArray[174] ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" style="background: rgba(0,0,0,.5);" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content">
                <div class="modal-header" style="background: #8d633a;">
                    <h5 class="modal-title" id="exampleModalLabel" style="color: #fff; text-align: center;"><?= $allLabelsArray[11] ?></h5>

                    <button style="position: absolute; top: 20px; right: 15px; color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#loginModel form')[0].reset(); $('#loginModel').attr('class','modal fade'); $('#loginModel .log_err i').hide(); $('#loginModel .log_err span').text(''); ">
                        <span aria-hidden="true" style="color: #fff;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="login_prompt"></div>
                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="text-danger log_err" style="color: red; width: 100%; text-align: center;">

                            <span style="font-weight: bold;"></span>
                        </div>
                        <input type="hidden" name="comment" hidden>
                        <input type="hidden" name="content_id" hidden value="<?= $id ?>">
                        <div class="form-group" style="position: relative;">
                            <label><?= $allLabelsArray[173] ?></label>
                            <i class="fa fa-envelope inputIcon" ></i>
                            <input type="email" placeholder="abc@gmail.com" name="email" class="form-control loginInput" required>
                        </div>
                        <div class="form-group" style="position: relative;">
                            <label><?= $allLabelsArray[146] ?></label>
                            <i class="fa fa-key inputIcon" ></i>
                            <i class="fa fa-eye-slash eyeIcon" onclick="show_hide($(this));" ></i>
                            <input type="password" placeholder="<?= $allLabelsArray[146] ?>" name="password" class="form-control loginInput" required >
                        </div>
                        <div style="position: relative;" class="form-group text-right">
                            <a href="<?= $cms_url ?>forgot-password<?= $langURL ?>" style="font-weight: bold;color: #8d633a;"><?= $allLabelsArray[220] ?></a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center; border: 0;">
                    <button type="submit" class="btn btn-primary" style="width: 200px; background: #8d633a; border: 0; margin-bottom: 5px;"><?= $allLabelsArray[11] ?></button>
                    <br>
                    <?= $allLabelsArray[675] ?><a href="<?= $cms_url ?>register"><b style="color: #8d633a; margin-left: 10px;"><?= $allLabelsArray[203] ?></b></a>

                </div>
            </form>
        </div>
    </div>
    <div class="snackbar main_snackbar">
        <div class="box" style="text-align: center; background: #fff; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0,0,0,2); padding-bottom: 15px;">
            <div style="width: 100%; background: #855b32; line-height: 40px;border-top-left-radius: 5px;border-top-right-radius: 5px; color: #fff;font-size: 18px;font-weight: bold;"><?= $allLabelsArray[176] ?></div>
            <p class="comment_del_modal"><i class="fa fa-trash" style="margin-right: 10px;"></i><?= $allLabelsArray[677] ?></p>
            <button class="btn btn-danger" style="marpxn-right: 10px; border: 0;"><i class="fa fa-spinner fa-spin" style="margin-right: 10px; display: none;"></i><?= $allLabelsArray[40] ?></button>
            <button class="btn btn-warning" style="border: 0; background: #855b32;"><?= $allLabelsArray[41] ?></button>
        </div>
    </div>
    <div class="snackbar reply">
        <div class="box" style="text-align: center; background: #fff; border-radius: 5px; box-shadow: 0px 0px 20px rgba(0,0,0,2); padding-bottom: 15px;">
            <div style="width: 100%; background: #855b32; line-height: 40px;border-top-left-radius: 5px;border-top-right-radius: 5px; color: #fff;font-size: 18px;font-weight: bold;"><?= $allLabelsArray[176] ?></div>
            <p class="comment_del_modal"><i class="fa fa-trash" style="margin-right: 10px;"></i><?= $allLabelsArray[677] ?></p>
            <button class="btn btn-danger" style="marpxn-right: 10px; border: 0;"><i class="fa fa-spinner fa-spin" style="margin-right: 10px; display: none;"></i><?= $allLabelsArray[40] ?></button>
            <button class="btn btn-warning" style="border: 0; background: #855b32;"><?= $allLabelsArray[41] ?></button>
        </div>
    </div>
    <?php include($basePath."includes/script.php") ?>
    <script type="text/javascript">

        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "<?= $cms_url ?>ajax.php?h=AddView&lang=<?= getCurLang($langURL,true)?>",
                data: {content_id: <?= $id ?>},
                dataType: "json",
                success: function(res){
                    $(".fa-eye").siblings("span").text(res.views)
                },error: function(e){
                }
            });

            $.ajax({
                type: "POST",
                url: "<?= $cms_url ?>ajax.php?h=GetLikes&lang=<?= getCurLang($langURL,true)?>",
                data: {content_id: <?= $id ?>},
                dataType: "json",
                success: function(res){
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
                url: "<?= $cms_url ?>ajax.php?h=AddLike&lang=<?= getCurLang($langURL,true)?>",
                data: {content_id: <?= $id ?>},
                dataType: "json",
                success: function(res){
                    console.log(res)
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
                messages: {
                    email: {
                        required: '<?= $allLabelsArray[48] ?>',
                        email: '<?= $allLabelsArray[32] ?>',
                    },
                    password: {
                        required: '<?= $allLabelsArray[48] ?>',
                    }},
                submitHandler: function(form){
                    $.ajax({
                        type: "POST",
                        url: "<?= $cms_url ?>ajax.php?h=login&lang=<?= getCurLang($langURL,true)?>",
                        data: $("#loginModelLike form").serialize(),
                        dataType: "json",
                        beforeSend: function(){
                            $("#loginModelLike form .fa-spin").show();
                            $("#loginModelLike .log_err i").hide();
                            $("#loginModelLike .log_err span").text("");
                            $("#loginModelLike .btn-primary").prop("disabled",true);
                        },
                        success: function(res){
                            $("#loginModelLike .btn-primary").prop("disabled",false);
                            $("#loginModelLike form .fa-spin").hide();
                            console.log(res)
                            if(res.Success == 'false'){
                                $("#loginModelLike .log_err i").show()
                                $("#loginModelLike .log_err span").text(res.Msg)
                            }else{
                                window.location.reload();
                            }
                        },error: function(e){
                            $("#loginModelLike .btn-primary").prop("disabled",true);
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
            });          // $.validator.addMethod('comment', function (value) {
            //   return /^[a-zA-Z\s]*$/i.test(value);
            // }, 'Format: Whitespaces & Alphabets Only');
        });

        $("#commentform").validate({
            // rules: {
            //     comment: "required comment",
            // },
            messages: {
                comment: {
                    required: '<?= $allLabelsArray[48] ?>',
                },
            },
            submitHandler: function(form){
                <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){?>
                $.ajax({
                    type: "POST",
                    url: "<?= $cms_url ?>ajax.php?h=news_comments&c_id=<?= $id ?>&lang=<?= getCurLang($langURL,true)?>",
                    data: $("#commentform").serialize(),
                    dataType: "json",
                    success: function(res){
                        console.log(res)
                        if(res.success){
                            $("#commentform")[0].reset();
                            // $(".com_not .fa").attr("class","fa fa-smile-o");
                            // $(".com_not .modal-body p:first").text(" <?= $allLabelsArray[565] ?>");
                            // $(".com_not .modal-body p:first").css("color","green");
                            // $(".com_not .modal-body p:last").text("Wait for Admin Approval.");
                            // $(".com_not").slideDown();
                        }else{

                            $("#snackbarMSG").slideDown();
                            $("#snackbarMSG p").html("<?= $allLabelsArray[678] ?>");
                            setTimeout(function(){
                                $("#snackbarMSG").slideUp();
                            },3000);
                            // $(".com_not .fa").attr("class","fa fa-frown-o");
                            // $(".com_not .modal-body p:first").css("color","red");
                            // $(".com_not .modal-body p:first").text("<?= $allLabelsArray[678] ?>");
                            // $(".com_not .modal-body p:last").text("");
                            // $(".com_not").slideDown();
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
                    messages: {
                        email: {
                            required: '<?= $allLabelsArray[48] ?>',
                            email: '<?= $allLabelsArray[32] ?>',
                        },
                        password: {
                            required: '<?= $allLabelsArray[48] ?>',
                        }},
                    submitHandler: function(form){
                        $.ajax({
                            type: "POST",
                            url: "<?= $cms_url ?>ajax.php?h=news_model_login&lang=<?= getCurLang($langURL,true)?>",
                            data: $("#loginModel form").serialize(),
                            dataType: "json",
                            beforeSend: function(){
                                $("#loginModel .log_err i").hide();
                                $("#loginModel .log_err span").text("");
                                $("#loginModel .btn-primary").prop("disabled",true);
                            },
                            success: function(res){
                                $("#loginModel .btn-primary").prop("disabled",false);
                                console.log(res)
                                if(res.Success == 'true'){
                                    // $("#loginModel form")[0].reset();
                                    // $("#loginModel").attr("class","modal fade");
                                    // $(".com_not .modal-body p").text("Comment post successfully.Wait for the admin aprovel.");
                                    // $(".com_not").show();
                                    // setTimeout(function(){
                                    window.location.reload();
                                    // },1000);
                                }else{
                                    $('.login_prompt').html('<div class="alert alert-danger"><i class="fas fa-times" style="margin-right:10px;"></i>' + res.Msg + '</div>');
                                    setTimeout(function () {
                                        $("div.login_prompt").html('');
                                    }, 3000);
                                    // $("#loginModel .modal-dialog").css("animation","shake 0.5s");
                                    // $("#loginModel .modal-dialog").css("animation-iteration-count","2");
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
                url: "<?= $cms_url ?>ajax.php?h=news_getComments&lang=<?= getCurLang($langURL,true)?>",
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
                            setHTML = '<a style="right: 0; margin-top: 80px; width: 100px;" comment="'+res.comments[i].c_id+'" onclick="AddCommentReply(<?= $id ?>,$(this));" class="comment-reply"><i class="fa fa-share" style="transform: scaleX(-1) !important; margin-right: 5px;"></i>  <?= $allLabelsArray[731] ?></a>';
                        }else{
                            setHTML = '<a  style="font-style: italic;" comment="'+res.comments[i].c_id+'" class="comment-reply pending_com"> <?= $allLabelsArray[660] ?></a>';
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
                            '<h6><a href="javascript:void(0);">'+res.comments[i].u_name+'</a></h6>'+
                            '<div class="comment-time">'+res.comments[i].c_date+'</div>'+
                            '</div>'+

                            '</div>'+
                            '<p><span>'+res.comments[i].comment.substring(0,160).replace(/(?:\r\n|\r|\n)/g, '<br>')+'</span>'; if(res.comments[i].comment.length > 160){ html += '<a comments="'+res.comments[i].comment.replace(/(?:\r\n|\r|\n)/g, '<br>')+'" style="float:right; font-size: 14px;text-decoration: underline;" onclick="showLessMore($(this));"> <?= $allLabelsArray[730] ?></a>';} html += '</p>'+
                            '<div class="ml-auto pendingComment">'+
                            setHTML+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="com_reply" id="edit_reply_id'+res.comments[i].c_id+'" style="position: relative; display: none; margin-top: 35px; margin-bottom: 50px;">'+
                            '<button class="btn btn-success editCommentBtn" comment_id="'+res.comments[i].c_id+'" ><i class="fa fa-spin fa-spinner" style="display: none;"></i> <?= $allLabelsArray[679] ?></button>'+
                            '<textarea type="text" placeholder=" <?= $allLabelsArray[682] ?>" maxlength="1000">'+res.comments[i].comment+'</textarea><p class="text-danger">'+res.comments[i].comment.length+'/1000</p>'+
                            '</div>'+
                            '<div class="com_reply" id="reply_id'+res.comments[i].c_id+'" style="position: relative; display: none; margin-top: 35px; margin-bottom: 50px;">'+
                            '<button class="btn btn-success editCommentBtn" comment_id="'+res.comments[i].c_id+'" onclick="postComment($(this));"><i class="fa fa-spin fa-spinner" style="display: none;"></i>  <?= $allLabelsArray[680] ?></button>'+
                            '<textarea type="text" placeholder=" <?= $allLabelsArray[682] ?>" maxlength="1000"></textarea><p class="text-danger"></p>'+
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
                                    '<h6><a href="javascript:void(0);">'+res.comments[i].replies[j].u_name+'</a></h6>'+
                                    '<div class="comment-time">'+res.comments[i].replies[j].c_date+'</div>'+
                                    '</div>'+
                                    '</div>'+
                                    '<p><span>'+res.comments[i].replies[j].comment.substring(0,160).replace(/(?:\r\n|\r|\n)/g, '<br>')+'</span>'; if(res.comments[i].replies[j].comment.length > 160){ html += '<a comments="'+res.comments[i].replies[j].comment+'" style="font-size: 14px;text-decoration: underline; float: right;" onclick="showLessMore($(this));"> <?= $allLabelsArray[730] ?></a>';} html += '</p>'+
                                    '</div>'+
                                    '</div>'+
                                    '<div class="com_reply" id="edit_r_reply_id'+res.comments[i].replies[j].c_id+'" style="position: relative; display: none; margin-top: 35px; margin-bottom: 50px;">'+
                                    '<button class="btn btn-success editCommentBtn" comment_id="'+res.comments[i].replies[j].c_id+'" ><i class="fa fa-spin fa-spinner" style="display: none;"></i> Update</button>'+
                                    '<textarea type="text" placeholder=" <?= $allLabelsArray[682] ?>" maxlength="1000">'+res.comments[i].replies[j].comment+'</textarea><p class="text-danger">'+res.comments[i].replies[j].comment.length+'/1000</p>'+
                                    '</div>'+
                                    '</li>'+
                                    '</ul>';
                            }
                        }
                        html += '</li>';
                        // );
                    }
                    $(".comment_list").html(html);

                    $(".com_reply textarea").on("keyup",function(){
                        $(this).siblings("p").text($(this).val().length+"/1000");
                    });

                    $(".pending_com").mouseenter(function(){
                        $(this).text(" <?= $allLabelsArray[566] ?>");
                    });

                    $(".pending_com").mouseout(function(){
                        $(this).text(" <?= $allLabelsArray[660] ?>");
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
                    url: "<?= $cms_url ?>ajax.php?h=update_comment&lang=<?= getCurLang($langURL,true)?>",
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
                url: "<?= $cms_url ?>ajax.php?h=delete_my_comment&lang=<?= getCurLang($langURL,true)?>",
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
                    url: "<?= $cms_url ?>ajax.php?h=reply_update_comment&lang=<?= getCurLang($langURL,true)?>",
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
                url: "<?= $cms_url ?>ajax.php?h=reply_delete_my_comment&lang=<?= getCurLang($langURL,true)?>",
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


        //       <?php
        //       $getuser = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$_SESSION['user_id']);
        // $UserName = '';
        //       if(mysqli_num_rows($getuser) > 0){
        //       	$UserName = mysqli_fetch_assoc($getuser)['username'];
        //       }
        //       ?>

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
                    url: "<?= $cms_url ?>ajax.php?h=news_CommentReply&lang=<?= getCurLang($langURL,true)?>",
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
                            $("#snackbarMSG").slideDown();
                            $("#snackbarMSG p").html("<?= $allLabelsArray[678] ?>");
                            setTimeout(function(){
                                $("#snackbarMSG").slideUp();
                            },3000);
                            // $(".com_not i.fa").attr("class","fa fa-frown-o");
                            // $(".com_not .modal-body p:first").css("color","red");
                            // $(".com_not .modal-body p:last").text("");
                            // $(".com_not .modal-body p:first").text("Failed to post comment");
                            // $(".com_not").show();
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
                            url: "<?= $cms_url ?>ajax.php?h=model_login_reply&lang=<?= getCurLang($langURL,true)?>",
                            data: $("#loginModel form").serialize(),
                            dataType: "json",
                            success: function(res){
                                console.log(res)
                                if(res.login_err){
                                    $("#loginModel .log_err i").show();
                                    $("#loginModel .log_err span").text("<?= $allLabelsArray[152] ?>");
                                    // $("#loginModel .modal-dialog").css("animation","shake 0.5s");
                                    // $("#loginModel .modal-dialog").css("animation-iteration-count","2");
                                }else{
                                    $("#loginModel form")[0].reset();
                                    $("#loginModel").attr("class","modal fade");
                                    $.ajax({
                                        type: "POST",
                                        url: "<?= $cms_url ?>ajax.php?h=CommentReply&lang=<?= getCurLang($langURL,true)?>",
                                        data: {content_id:content_id,comment_id:comment_id,reply_comment:comment},
                                        dataType: "json",
                                        success: function(res){
                                            console.log(res)
                                            if(res.success){
                                                // $(".com_not .modal-body p").text("Comment post successfully.");
                                                // $(".com_not").show();
                                                // setTimeout(function(){
                                                window.location.reload();
                                                // },2000);
                                            }else{
                                                $("#snackbarMSG").slideDown();
                                                $("#snackbarMSG p").html("<?= $allLabelsArray[678] ?>");
                                                setTimeout(function(){
                                                    $("#snackbarMSG").slideUp();
                                                },3000);
                                                // $(".com_not .modal-body p").text("Failed to post comment");
                                                // $(".com_not").show();
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
                        url: "<?= $cms_url ?>ajax.php?h=news_CommentReply&lang=<?= getCurLang($langURL,true)?>",
                        data: $("#reply_comment form").serialize(),
                        dataType: "json",
                        success: function(res){
                            console.log(res)
                            if(res.success){
                                $("#reply_comment .error_msg").attr("class","error_msg alert alert-success");
                                $("#reply_comment .error_msg").text(res.success);
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

        function showLessMore(sel){
            sel.toggleClass("active_msg");
            if(sel.hasClass("active_msg")){
                sel.text("Show Less");
                sel.siblings("span").html(sel.attr("comments"));
            }else{
                sel.text(" <?= $allLabelsArray[730] ?>");
                sel.siblings("span").html(sel.attr("comments").substring(0,160));
            }
        }

        function getCommentCount(){
            $.ajax({
                type: "POST",
                url: "<?= $cms_url ?>ajax.php?h=CommentsCount&lang=<?= getCurLang($langURL,true)?>",
                data: {content_id:<?= $id ?>},
                dataType: "json",
                success: function(res){
                    if(res.total==0){
                        $(".com_count").text("<?= $allLabelsArray[729] ?>")
                    }else{
                        $(".com_count").text("("+res.total+") <?= $allLabelsArray[668] ?>")
                    }
                    $(".fa-comment").siblings("a:first").text(res.total);
                },error: function(e){
                    console.log(e)
                }
            });
        } getCommentCount();

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

        $('p').each(function() {
            var $this = $(this);
            if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
                $this.remove();
        });

    </script>
    <div class="full_img">
        <i class="fa fa-close" style="position: absolute; top: 10px; right: 10px; color: #fff; cursor: pointer;" onclick="$('.full_img').slideUp();"></i>
        <img class="img">
    </div>
</body>

</html>