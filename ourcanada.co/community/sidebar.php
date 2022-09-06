<?php

$request = explode( "/", $_SERVER[ 'REQUEST_URI' ] );
$result_blog = "";
$result_news = "";
$recent_post_check = "";
if($request[1] == ""){
    $recent_post_check = "base";
    $blog_select = "SELECT * FROM `".$blog_table."` WHERE status = 1 ORDER BY `id` DESC LIMIT 3";
    $result_blog = mysqli_query($conn, $blog_select);
} else{
    $check = $request[ 1 ];
    if($check == "news"){
        $recent_post_check = "news";
        $news_select = "SELECT * FROM `".$news_table."` WHERE status = 1 ORDER BY `id` DESC LIMIT 3";
        $result_news = mysqli_query($conn, $news_select);
    } else{
        $recent_post_check = "blog";
        $blog_select = "SELECT * FROM `".$blog_table."` WHERE status = 1 ORDER BY `id` DESC LIMIT 3";
        $result_blog = mysqli_query($conn, $blog_select);
    }
}
$blog_rows = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$blog_table." WHERE status = 1");
$blogcount = mysqli_fetch_assoc($blog_rows)['total'];

$news_rows = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$news_table." WHERE status = 1");
$newscount = mysqli_fetch_assoc($news_rows)['total'];
if(empty($newscount) || $newscount < 1){
    $newscount = '0';
}

?>
<div class="col-md-4" id="sidebar">
    <!---->
    <span class="jl_none_space"></span>
    <div id="panel-4212-2-1-1" class="so-panel widget widget_disto_category_image_widget_register jellywp_cat_image" data-index="6">
        <div class="wrapper_category_image">
            <div class="category_image_wrapper_main">
                <div class="category_image_bg_image" style="border-radius: 10px; background-image: url('<?= $cms_url ?>assets/img/banner-images/soroush-karimi-253940-unsplash-400x280.jpg');"> <a class="category_image_link" id="category_color_3" href="<?= $cms_url ?>blogs/<?= $langURL ?>"><span class="jl_cm_overlay"><span class="jl_cm_name"><?= $allLabelsArray[803] ?></span><span class="jl_cm_count" style="color: #000 !important;"><?php echo $blogcount;?></span></span></a>
                    <div class="category_image_bg_overlay" style="background: #0015ff;"></div>
                </div>
                <div class="category_image_bg_image" style="border-radius: 10px; background-image: url('<?= $cms_url ?>assets/img/banner-images/pexels-photo-1003816-400x280.jpg');"> <a class="category_image_link" id="category_color_4" href="<?= $cms_url ?>news/<?= $langURL ?>"><span class="jl_cm_overlay"><span class="jl_cm_name"><?= $allLabelsArray[416] ?></span><span class="jl_cm_count" style="color: #000 !important;"><?php echo $newscount;?></span></span></a>
                    <div class="category_image_bg_overlay" style="background: #d1783c;"></div>
                </div>
            </div>
            <span class="jl_none_space"></span> </div>
    </div>
    <span class="jl_none_space"></span>
    <div id="disto_recent_post_widget-7" class="widget post_list_widget">
        <div class="widget_jl_wrapper"><span class="jl_none_space"></span>
            <div class="widget-title">
                <h2><?= $allLabelsArray[425] ?></h2>
            </div>
            <div>
                <ul class="feature-post-list recent-post-widget">
                    <?php
                    if($recent_post_check == "base"){
                        while($row = mysqli_fetch_assoc($result_blog)){
                            if(!empty(getCurLang($langURL,true))){
                                $row['slug'] = rand(10,1000000).'-'.$row['id'];
                            }
                            $images = explode(',', $row['slider_images']);
                            ?>
                            <li>
                                <?php
                                if($row['type'] == "video-blog" || $row['type'] == "video-news"){
                                    if(!empty($row['embed'])){
                                        $vid_thumb = 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
                                    }else{
                                        $vid_thumb = getContentMedia('image',$row['single_image']);
                                    }
                                    ?>
                                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $vid_thumb ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news'])){
                                    $img11 = getContentMedia('image',$row['content_thumbnail'],true);
                                    ?>
                                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $img11 ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php } else{
                                    $img_path = getContentMedia('image',$images[0]);
                                 
                                    ?>
                                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $img_path ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php }?>
                                <div class="item-details">
              <span class="meta-category-small"><?php foreach ($tags as $key => $value):
                      if($value!=null){ ?>
                          <a class="post-category-color-text" style="background:red; margin-bottom: 5px;" href="javascript:void(0)">
                        <span> <?php echo $value; ?></span>

                      </a>
                      <?php }endforeach ?></span>
                                    <h3 class="feature-post-title"><a class="text-doted" href="<?php echo cleanURL("blog/".$row["slug"]) ?>" title="<?= $row['title']; ?>"> <?php  echo $row['title']; ?></a></h3>
                                    <label>
                                        <img src="assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                                        <?php if($row['created_by'] == 0){
                                            $u = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$row['creator_id']);
                                            $u_data = mysqli_fetch_assoc($u);

                                            ?><a href="<?= cleanURL('user/'.$u_data['id']) ?>"><?= $u_data['username'] ?></a><?php
                                        }else{
                                            echo "Our Canada Services";
                                        } ?>
                                    </label>
                                </div>
                            </li>
                        <?php } } else if($recent_post_check == "news"){
                        while($row = mysqli_fetch_assoc($result_news)){
                            if(!empty(getCurLang($langURL,true))){
                                $row['slug'] = rand(10,1000000).'-'.$row['id'];
                            }
                            $images = explode(',', $row['slider_images']);
                            ?>
                            <li>
                                <?php
                                if($row['type'] == "video-news" || $row['type'] == "video-blog"){
                                    if(!empty($row['embed'])){
                                        $vid_thumb = 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
                                    }else{
                                        $vid_thumb = getContentMedia('image',$row['single_image']);
                                    }
                                    ?>
                                    <a href="<?php echo cleanURL("news/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $vid_thumb ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news'])){
                                    $img12 = getContentMedia('image',$row['content_thumbnail'],true);
                                    ?>
                                    <a href="<?php echo cleanURL("news/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $img12 ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php } else{
                                    $img_path = getContentMedia('image',$images[0]);
                                
                                    ?>
                                    <a href="<?php echo cleanURL("news/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $img_path ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php }?>
                                <div class="item-details">
                                    <span class="meta-category-small"><a class="post-category-color-text" style="background:red;" href="javascript:void(0);"><?= $allLabelsArray[416] ?></a></span>
                                    <h3 class="feature-post-title"><a class="text-doted" href="<?php echo cleanURL("news/".$row["slug"]) ?>"> <?= $row['title']; ?></a></h3>
                                    <?php
                                    $queryauthor = "SELECT * FROM `users` WHERE id={$row['creator_id']}";
                                    $fetch1 = mysqli_fetch_assoc( mysqli_query( $conn, $queryauthor ) );

                                    if($row['created_by'] == 0) {
                                        $authorID = $fetch1['id'];
                                        $author = $fetch1[ 'username' ];
                                    }else{
                                        $authorID = 0;
                                        $author = "Our Canada Services";
                                    }
                                    ?>
                                    <label class="sidebarUsername">
                                        <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                                        <?php if($authorID == 0){
                                            echo $author;
                                        }else{
                                            ?><a href="<?= cleanURL('user/'.$authorID) ?>"><?= $author ?></a><?php
                                        } ?>

                                    </label>

                                    <span class="post-meta meta-main-img auto_image_with_date"> <span class="post-date "><i class="fa fa-clock-o"></i><?= time_ago($row['created_at']) ?></span></span> </div>
                            </li>
                        <?php } } else{
                        while($row = mysqli_fetch_assoc($result_blog)){
                            if(!empty(getCurLang($langURL,true))){
                                $row['slug'] = rand(10,1000000).'-'.$row['id'];
                            }
                            $images = explode(',', $row['slider_images']);
                            ?>
                            <li>
                                <?php
                                if($row['type'] == "video-blog" || $row['type'] == 'video-news'){
                                    if(!empty($row['embed'])){
                                        $vid_thumb =  'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
                                    }else{
                                        $vid_thumb = getContentMedia('image',$row['single_image']);
                                    }
                                    ?>
                                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $vid_thumb ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news'])){
                                    $img13= getContentMedia('image',$row['content_thumbnail'],true);
                                    ?>
                                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $img13 ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php } else{
                                    $img_path = getContentMedia('image',$images[0]);

                                    ?>
                                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title=""> <div style="height: 100px; background: url('<?= $img_path ?>'); background-size: cover; background-position: center; border-radius: 10px;" class="attachment-disto_small_feature size-disto_small_feature wp-post-image"></div>
                                        <div class="background_over_image"></div>
                                    </a>
                                <?php }?>
                                <div class="item-details">
              <span class="meta-category-small"><?php foreach ($tags as $key => $value):
                  if($value!=null){?>
                      <a class="post-category-color-text" style="background:red;" href="javascript:void(0);">
                       <span><?php echo $value; ?></span>
                      </a>
                  <?php }endforeach ?></a></span>
                                    <h3 class="feature-post-title"><a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="text-doted"><?= $row['title']; ?></a></h3>
                                    <?php
                                    $queryauthor = "SELECT * FROM `users` WHERE id={$row['creator_id']}";
                                    $fetch1 = mysqli_fetch_assoc( mysqli_query( $conn, $queryauthor ) );

                                    if($row['created_by'] == 0) {
                                        $authorID = $fetch1['id'];
                                        $author = $fetch1[ 'username' ];
                                    }else{
                                        $authorID = 0;
                                        $author = "Our Canada Services";
                                    }
                                    ?>
                                    <label class="sidebarUsername">
                                        <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                                        <?php if($authorID == 0){
                                            echo $author;
                                        }else{
                                            ?><a href="<?= cleanURL('user/'.$authorID) ?>"><?= $author ?></a><?php
                                        } ?>
                                    </label>
                                    <span class="post-meta meta-main-img auto_image_with_date"> <span class="post-date"><i class="fa fa-clock-o"></i><?= time_ago($row['created_at']) ?></span></span> </div>
                            </li>
                        <?php } } ?>

                </ul>
            </div>
            <span class="jl_none_space"></span> </div>
    </div>
    <div id="panel-4212-2-1-3" class="so-panel widget widget_disto_recent_large_slider_widgets jl_widget_slider panel-last-child" data-index="8">
        <div class="slider_widget_post jelly_loading_pro">
            <?php
            $date = date( "d M, yy" );
            $query21 = "SELECT * FROM `".$blog_table."` where LEFT(created_at,12)='$date' && status = 1";
            $result21 = mysqli_query( $conn, $query21 );
            while ( $row = mysqli_fetch_assoc( $result21 ) ) {
                $image = explode( ',', $row[ 'slider_images' ] );
                $img_path = getContentMedia('image',$images[0]);

                ?>
                <div class="recent_post_large_widget">
                    <span class="image_grid_header_absolute" style="background-image: url('<?php echo $img_path; ?>')"></span>
                    <a href="<?php echo cleanURL("blog/".$row["slug"]) ?>" class="link_grid_header_absolute" title="Standing right here and singing until the mid"></a> <span class="meta-category-small"><a class="post-category-color-text" style="background:red;" href="javascript:void(0);"><span><?php echo $row["category"];?></span></a></span>
                    <div class="wrap_box_style_main image-post-title">
                        <h3 class="image-post-title"><a href="<?php echo cleanURL("blog/".$row["slug"]) ?>">
                                <?php $row["title"];?>
                            </a> </h3>
                        <span class="jl_post_meta">
            <span class="jl_author_img_w">
              <?php
              $queryauthor = "SELECT * FROM `users` WHERE id={$row['creator_id']}";
              $fetch1 = mysqli_fetch_assoc( mysqli_query( $conn, $queryauthor ) );

              if($row['created_by'] == 0) {
                  // $fetch1[ 'username' ] = $fetch1[ 'firstname' ].' '.$fetch1[ 'lastname' ];
                  $authorID = $fetch1['id'];
                  $author = $fetch1[ 'username' ];
              }else{
                  $authorID = 0;
                  $author = "Our Canada Services";
              }
              ?>
                  <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                <?php if($authorID == 0){
                    echo $author;
                }else{
                    ?><a href="<?= cleanURL('user/'.$authorID) ?>"><?= $author ?></a><?php
                } ?>
            </span>
            <span class="post-date">
              <i class="fa fa-clock-o"></i>
              <?php echo time_ago($row["created_at"]); ?>
            </span>
          </span>
                    </div>
                </div>
            <?php }?>
        </div>
        <span class="jl_none_space"></span> </div>
</div>




