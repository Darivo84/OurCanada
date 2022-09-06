<?php

if($basePath=='')
{
    require_once( $basePath."user_inc.php" );
}
require_once 'compressor.php';

$query = "SELECT * FROM `".$news_table."` WHERE `status` = 1 ORDER BY id DESC LIMIT 5";

$result_news = mysqli_query( $conn, $query );

$querycount = "SELECT count(id) as count FROM `".$news_table."` where status = 1";
$result2 = mysqli_query( $conn, $querycount );
$row1 = mysqli_fetch_assoc( $result2 );
$newscount = $row1[ 'count' ];

$query1 = "SELECT * FROM `".$blog_table."` WHERE status = 1 ORDER BY id DESC LIMIT 5";
$result1 = mysqli_query( $conn, $query1 );

$querycount1 = "SELECT count(id) as count FROM `".$blog_table."` WHERE status = 1";
$result21 = mysqli_query( $conn, $querycount1 );
$row11 = mysqli_fetch_assoc( $result21 );
$blogcount = $row11[ 'count' ];



?>
<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if($environment==true)
    {
        ?>
        <meta name="author" content="<?= $allLabelsArray[283] ?>">
        <meta name="description" content="<?= $allLabelsArray[775] ?>">
        <meta name="keywords" content="<?= $allLabelsArray[774] ?>">
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community" />


        <?php
    }
    ?>


    <meta property="og:title" content="<?= $allLabelsArray[769] ?>" />
    <meta property="og:description" content="<?php echo $allLabelsArray[286]; ?>" />
    <meta property="og:image" content="<?= $cms_url ?>assets/images/blog-banner2.webp" />
    <meta property="og:url" content="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />

    <!-- Title-->
    <title><?= $allLabelsArray[769] ?></title>

    <!-- Favicon-->
    <?php include($basePath."includes/style.php"); ?>
    <style type="text/css">
        .slick-track{
            position: absolute !important;
        }
        .image_grid_header_absolute{
        	height: 100% !important;
        	object-fit: cover !important;
        }
        @media screen and (max-width: 950px) {
			.jl_main_post_style_padding{
				width: 100% !important;
	        }
	        .jl_list_post_wrapper{
	        	width: 100%;
	        }
	        #sidebar{
	        	width: 100%;
	        }
		}
		@media screen and (max-width: 650px){
			.blog_list_post_style .image-post-thumb.featured-thumbnail.home_page_builder_thumbnial{
				width: 100% !important;
			}
			.page_builder_listpost.jelly_homepage_builder .post-entry-content{
				width: 100% !important;
			}
		}
    </style>
    <!-- end head -->
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
    <div class="options_layout_container full_layout_enable_front">
        <!-- Start header -->
        <?php include($basePath."includes/header.php"); ?>
        <!-- end header -->

        <!-- slider section -->
        <div class="jl_home_section jl_home_slider">
            <div class="jl_mid_main_3col">
                <div class="page_builder_slider jelly_homepage_builder">
                    <div class="jl_slider_nav_tab large_center_slider_container">
                        <div class="row header-main-slider-large">
                            <div class="col-md-12">
                                <div class="large_center_slider_wrapper">
                                    <div class="home_slider_header_tab jelly_loading_pro">
                                        <div class="item">
                                            <div class="banner-carousel-item"> <img class="image_grid_header_absolute" src="" data-src="<?= $cms_url ?>assets/images/blog-banner2.webp">

                                                <a  class="link_grid_header_absolute"></a>
                                                <div class="banner-container">
                                                    <div class="row">
                                                        <div class="w-100">
                                                            <h5><a  style="width: auto !important; padding: 0 15px !important;"><?= $allLabelsArray[514] ?></a></h5>
                                                            <div class="jl-loadmore-btn-w"><a style="width: auto !important; padding: 0 15px !important;" href="<?= $cms_url ?>create-blog/<?= $langURL ?>" class="jl_btn_load"><?= $allLabelsArray[513] ?></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $query_featured_news = "SELECT * FROM `".$news_table."` WHERE status = 1 ORDER BY `id` DESC LIMIT 3";
        $featured_news_result = mysqli_query( $conn, $query_featured_news );

        if(mysqli_num_rows($featured_news_result) > 0 || mysqli_num_rows($result_news) > 0){

            ?>

            <div class="jl_home_section jl_home_mbg">
                <div class="container">
                    <?php if(mysqli_num_rows($result_news) > 0){ ?>
                        <div class="row">
                            <div class="col-md-12 jl_mid_main_3col">
                                <div class="jl_3col_wrapin">
                                    <div class="jl_main_with_right_post jelly_homepage_builder">
                                        <div class="homepage_builder_title">
                                            <h2 class="builder_title_home_page"> <?= $allLabelsArray[421] ?></h2>
                                        </div>
                                        <?php
                                        $row = mysqli_fetch_assoc( $result_news);
                                        if(!empty(getCurLang($langURL,true))){
                                            $row['slug'] = rand(0,1000000).'-'.$row['id'];
                                        }
                                        if ( $row[ "id" ] != "" ) {
                                            $image = explode( ',', $row[ 'slider_images' ] );
                                            $queryauthor = "SELECT * FROM `users` WHERE id={$row['creator_id']}";
                                            $fetch1 = mysqli_fetch_assoc( mysqli_query( $conn, $queryauthor ) );
                                            $authorID = $fetch1['id'];
                                            if($row['created_by'] == 0) {
                                                // $fetch1[ 'username' ] = $fetch1[ 'firstname' ].' '.$fetch1[ 'lastname' ];
                                                $author = $fetch1[ 'username' ];
                                            }else{
                                                $author = "Our Canada Services";
                                            }
                                            ?>
                                            <div class="jl_main_post_style_padding">

                                                <?php
                                                $img_path = getContentMedia('image',$row['single_image']);

                                                ?>
                                                <?php
                                                if($row["type"]=="video-image-blog" or $row["type"]=="video-image-news" or $row["type"]=="image-slider-blog" or $row["type"]=="image-slider-news")
                                                {
                                                    $img_path = getContentMedia('image',$image[0]);


                                                } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news']))
                                                {
                                                    $img_path = getContentMedia('image',$row['content_thumbnail'],true);

                                                } else if($row["type"]=="video-blog" or $row["type"]=="video-news")
                                                {
                                                    if(!empty($row['embed'])){
                                                        $img_path = 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
                                                    }else{
                                                        $img_path = getContentMedia('image',$row['single_image']);

                                                    }
                                                }
                                                ?>
                                                <div class="jl_main_post_style">
                                                    <img class="image_grid_header_absolute lazy" style="height: 100%;" src="" data-src="<?= $img_path ?>">
                                                    <a href="<?= cleanURL('news/'.$row['slug']) ?>" class="link_grid_header_absolute" title=""></a>
                                                    <div class="post-entry-content"> <span class="meta-category-small">


                      </span>
                                                        <h3 class="image-post-title"><a href="<?= cleanURL('news/'.$row['slug']); ?>" title="<?= $row['title'] ?>" class="text-doted"><?php echo $row['title']; ?></a> </h3>
                                                        <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                                                                <a href="<?php if($authorID!=0) { cleanURL('user/'.$authorID);} else { echo '';} ?>" rel="author"><?php echo $author;?></a>
                                                            </span><span class="post-date "><i class="fa fa-clock-o"></i><?php echo time_ago($row["created_at"]); ?></span></span> </div>
                                                </div>
                                            </div>
                                            <?php
                                            while ( $row = mysqli_fetch_assoc( $result_news ) ) {
                                                if(!empty(getCurLang($langURL,true))){
                                                    $row['slug'] = rand(10,1000000).'-'.$row['id'];
                                                }
                                                $image = explode( ',', $row[ 'slider_images' ] );

                                                $image = getContentMedia('image',$row['slider_images']);


                                                ?>
                                                <div class="jl_list_post_wrapper"> <a href="<?= cleanURL('news/'.$row['slug']); ?> ?>" class="jl_small_format feature-image-link image_post featured-thumbnail"> <img class="lazy" style="height: 91px !important;" src="" data-src="<?php if ( $row[ "type" ] == "video-image-news" or $row[ "type" ] == "video-image-blog" or $row["type"]=="image-slider-news" or $row["type"]=="image-slider-blog" ) {
                                                            echo $img_path;
                                                        } else if ( $row[ "type" ] == "video-news" or $row[ "type" ] == "video-blog" ) {
                                                            if(!empty($row['embed'])){
                                                                echo 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
                                                            }else{
                                                                echo getContentMedia('image',$row['single_image']);
                                                                // echo $cms_url.'uploads/images/'.$row['single_image'];
                                                            }
                                                        } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news'])){
                                                            // "'".$cms_url."assets/images/simple_news.jpg'"
                                                            $img_path1 = getContentMedia('image',$row['content_thumbnail'],true);
                                                            // $img_path1 = $cms_url.'uploads/gallery/'.$row['content_thumbnail'];
                                                            echo $img_path1;}?>" alt="" width="120" height="120">
                                                        <div class="background_over_image"></div>
                                                    </a>
                                                    <div class="item-details"> <span class="meta-category-small">


                    </span>
                                                        <h3 class="feature-post-title"><a class="text-doted" href="<?= cleanURL('news/'.$row['slug']); ?>" title="<?= $row['title'] ?>"> <?= $row['title']; ?></a> </h3>
                                                        <label>
                                                            <img src="assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                                                            <?php if($row['created_by'] == 0){
                                                                $u = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$row['creator_id']);
                                                                $u_data = mysqli_fetch_assoc($u);
                                                                echo $u_data['username'];
                                                            }else{
                                                                echo "Our Canada Services";
                                                            } ?>
                                                        </label>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="col-12 text-center">
                                                <h3><?= $allLabelsArray[367] ?></h3>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!---->
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php
                    $query_featured_news = "SELECT * FROM `".$news_table."` WHERE status = 1 ORDER BY `id` DESC LIMIT 3";
                    $featured_news_result = mysqli_query( $conn, $query_featured_news );
                    if(mysqli_num_rows($featured_news_result) > 0){
                        ?>
                        <div class="jelly_homepage_builder jl_nonav_margin homepage_builder_3grid_post jl_cus_grid_overlay jl_fontsize20 jl_cus_grid3    ">
                            <div class="jl_wrapper_row jl-post-block-314983">
                                <h2 class="builder_title_home_page"> <?= $allLabelsArray[423] ?> </h2>
                                <div class="row">
                                    <?php

                                    if ( mysqli_num_rows( $featured_news_result ) > 0 ) {
                                        while ( $featured_news = mysqli_fetch_assoc( $featured_news_result ) ) {
                                            if(!empty(getCurLang($langURL,true))){
                                                $featured_news['slug'] = rand(10,1000000).'-'.$featured_news['id'];
                                            }
                                            $image = explode( ',', $featured_news[ 'slider_images' ] );
                                            $queryauthor1 = "SELECT * FROM `users` WHERE id={$featured_news['creator_id']}";

                                            $r = mysqli_query( $conn, $queryauthor1 );
                                            $fetch2 = mysqli_fetch_assoc( $r );
                                            $authorID = $fetch2['id'];
                                            if($featured_news['created_by'] == 0) {
                                                $author1 = $fetch2[ 'username' ];
                                            }else{
                                                $authorID = 0;
                                                $author1 = "Our Canada Services";
                                            }

                                            if ( $featured_news[ 'type' ] == 'simplenews' || $featured_news[ 'type' ] == 'pdf-news' ) {

                                                $img_path4 = getContentMedia('image','uploads/gallery/'.$featured_news['content_thumbnail']);

//                                                $img_path4 = $cms_url.'uploads/gallery/'.$featured_news['content_thumbnail'];
                                                ?>
                                                <div class="col-md-4 blog_grid_post_style jl_row_1">
                                                    <div class="jl_grid_box_wrapper">

                                                        <img class="image_grid_header_absolute lazy" src="" data-src="<?= $img_path4 ?>">

                                                        <a href="<?= cleanURL('news/'.$featured_news['slug']) ?>" class="link_grid_header_absolute"></a>
                                                        <div class="post-entry-content">
                                                            <?php if(!empty(getCurLang($langURL,true))){$featured_news['slug'] = rand(10,1000000).'-'.$featured_news['id'];} ?>
                                                            <h3 class="image-post-title"><a class="text-doted" href="<?= cleanURL('news/'.$featured_news['slug']); ?>" title="<?= $featured_news['title'] ?>">
                                                                    <?php echo $featured_news['title']; ?>
                                                                </a> </h3><br>
                                                            <span class="jl_post_meta"><span class="jl_author_img_w" style="widows: 100%;"> <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="<?php if($authorID != 0){ echo cleanURL('user/'.$authorID); }else{ echo '';} ?>" rel="author"><?php echo $author1.' &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;'; ?></a></span><span class="post-date "><i class="fa fa-clock-o"></i><?php echo time_ago($featured_news["created_at"]); ?></span></span> </div>
                                                    </div>
                                                </div>
                                            <?php } else if($featured_news['type'] == 'video-news'){
                                                $img_path = getContentMedia('image',$featured_news['single_image']);

                                                ?>
                                                <div class="col-md-4 blog_grid_post_style jl_row_1">
                                                    <div class="jl_grid_box_wrapper">
                                                        <img class="image_grid_header_absolute lazy" src="" data-src="<?php if(empty($featured_news['embed'])){echo $img_path; }else{ echo 'http://img.youtube.com/vi/'.explode('embed/', $featured_news['embed'])[1].'/hqdefault.jpg';} ?>">

                                                        <a href="<?= cleanURL('news/'.$featured_news['slug']); ?>" class="link_grid_header_absolute"></a>
                                                        <div class="post-entry-content">
                                                            <h3 class="image-post-title"><a class="text-doted" href="<?= cleanURL('news/'.$featured_news['slug']) ?>">
                                                                    <?php echo $featured_news['title']; ?>
                                                                </a> </h3>
                                                            <span class="jl_post_meta"><span class="jl_author_img_w" style="widows: 100%;"> <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="<?php  if($authorID != 0){ echo cleanURL('user/'.$authorID); }else{ echo ''; } ?>" rel="author"><?php echo $author1;?></a></span><span class="post-date "><i class="fa fa-clock-o"></i><?php echo time_ago($featured_news["created_at"]); ?></span></span> </div>
                                                    </div>
                                                </div>
                                            <?php } else { ?>
                                                <div class="col-md-4 blog_grid_post_style jl_row_1">
                                                    <div class="jl_grid_box_wrapper">
                                                        <img class="image_grid_header_absolute lazy" src="" data-src="<?php if(empty($image[0])){echo $cms_url.'assets/img/videonews.png';}else{ if(count(explode('uploads/gallery/', $image[0])) > 1){echo $cms_url.$image[0];}else{ echo $cms_url.'uploads/images/'.$image[0];}} ?>">

                                                        <a href="<?= cleanURL('news/'.$featured_news['slug']) ?>" class="link_grid_header_absolute"></a>
                                                        <div class="post-entry-content">
                                                            <?php if(!empty(getCurLang($langURL,true))){$featured_news['slug'] = rand(10,1000000).'-'.$featured_news['id'];} ?>
                                                            <h3 class="image-post-title"><a class="text-doted" href="<?= cleanURL('news/'.$featured_news['slug']); ?>" title="<?= $featured_news['title'] ?>">
                                                                    <?php echo $featured_news['title']; ?>
                                                                </a> </h3>
                                                            <span class="jl_post_meta"><span class="jl_author_img_w" style="widows: 100%;"> <img style="margin: 0; padding-right: 4px;" src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="<?php  if($authorID != 0){ echo cleanURL('user/'.$authorID); }else{ echo ''; } ?>" rel="author"><?php echo $author1; ?></a></span><span class="post-date "><i class="fa fa-clock-o"></i><?php echo time_ago($featured_news["created_at"]); ?></span></span> </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } } else{ ?>
                                        <div class="col-12 text-center">
                                            <h3><?= $allLabelsArray[367] ?></h3>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <div class="jl_home_section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8" id="content">
                        <div class="homepage_builder_title mb-50">
                            <h2 class="builder_title_home_page"> <?= $allLabelsArray[424] ?> </h2>
                        </div>
                        <div class="post_list_medium_widget jl_nonav_margin page_builder_listpost jelly_homepage_builder jl-post-block-725291">
                            <?php
                            while ( $row = mysqli_fetch_assoc( $result1 ) ) {
                                if(!empty(getCurLang($langURL,true))){
                                    $row['slug'] = rand(10,1000000).'-'.$row['id'];
                                }
                                $image = explode( ',', $row[ 'slider_images' ] );
                                $cate_list = mysqli_query($conn,"SELECT * FROM category_blog WHERE id IN(".$row['category'].")");
                                $cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
                                $tags = [];
                                while ($cate_row = mysqli_fetch_assoc($cate_list)) {
                                    array_push($tags, $cate_row['title'.$cate_title]);
                                }
                                ?>
                                <div class="blog_list_post_style">
                                    <div class="image-post-thumb featured-thumbnail home_page_builder_thumbnial">
                                        <div class="jl_img_container">

                                            <img class="image_grid_header_absolute lazy" src="" data-src="<?php if($row["type"]=="video-image-blog" or $row["type"]=="video-image-news" or $row["type"]=="image-slider-blog" or $row["type"]=="image-slider-news")
                                            {
                                                echo getContentMedia('image',$image[0]);

                                            } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news']))
                                            {
                                                $img_path2 = getContentMedia('image',$row['content_thumbnail'],true);
                                                echo $img_path2;
                                            } else if($row["type"]=="video-blog" or $row["type"]=="video-news")
                                            {
                                                if(!empty($row['embed'])){
                                                    echo 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
                                                }else{
                                                    echo getContentMedia('image',$row['single_image']);
                                                }
                                            }?>">

                                            <a href="<?= cleanURL('blog/'.$row['slug']); ?>" class="link_grid_header_absolute"></a> </div>
                                    </div>
                                    <div class="post-entry-content"> <span class="meta-category-small">
                  <?php
                  if(!empty(getCurLang($langURL,true))){$row['slug'] = rand(10,1000000).'-'.$row['id'];}
                  foreach ( $tags as $key => $value ):
                      if ( $value != null ) {
                          ?>
                          <a class="post-category-color-text" style="background: red;" href="<?= cleanURL('blog/'.$row['slug']); ?>" title="<?= $value ?>"> <?php if(strlen($value) > 10){echo '<span>'.$value.'</span>...';}else{echo $value;}  ?> </a>
                      <?php }endforeach ?>
                  </span>
                                        <h3 class="image-post-title" style="margin-bottom: 0;"><a href="<?= cleanURL('blog/'.$row['slug']); ?>" title="<?= $row["title"] ?>" class="text-doted"><?php echo $row['title']; ?></a> </h3>
                                        <label style="float: left; widows: 100%;">
                                            <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                                            <?php if($row['created_by'] == 0){
                                                $u = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$row['creator_id']);
                                                $u_data = mysqli_fetch_assoc($u);
                                                ?> <a href="<?= cleanURL('user/'.$u_data['id']) ?>"><?= $u_data['username'] ?></a> <?php
                                            }else{
                                                echo "Our Canada Services";
                                            } ?>
                                        </label>
                                        <div class="large_post_content">
                                            <p>
                                                <?php

                                                if ( strlen( $row[ "description" ] ) <= 270 ) {
                                                    echo $row[ "description" ];
                                                } else {
                                                    echo substr( $row[ "description" ], 0, 150 ) . "....";
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php
                    include_once("sidebar.php");
                    ?>
                </div>
            </div>
        </div>
        <?php include($basePath."includes/footer.php"); ?>
    </div>
</div>
<div id="go-top"><a href="javascript:void(0);go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include($basePath."includes/script.php"); ?>
<script>
    function init() {
        var imgDefer = document.getElementsByTagName('img');
        for (var i=0; i<imgDefer.length; i++) {
            if(imgDefer[i].getAttribute('data-src')) {
                imgDefer[i].setAttribute('src',imgDefer[i].getAttribute('data-src'));
            } } }
    window.onload = init;
</script>
</body>
</html>