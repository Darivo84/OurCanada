<footer id="footer-container" class=" enable_footer_columns_dark">
            <div class="footer-columns">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12 col-md-6 col-lg-4"> <span class="jl_none_space"></span>
                        <div id="disto_about_us_widget-3" class="widget jellywp_about_us_widget">
                           <div class="widget_jl_wrapper about_widget_content"> <span class="jl_none_space"></span>
                              <div class="widget-title">
                                 <h2><?= $allLabelsArray[8] ?></h2>
                              </div>
                              <div class="jellywp_about_us_widget_wrapper">
                                 <p style="text-align: justify; font-size: 13px;"><?= $allLabelsArray[426] ?></p>
                                 
                              </div> <span class="jl_none_space"></span>
                           </div>
                        </div>
                        <div id="disto_about_us_widget-3" style="margin-top: -45px;" class="widget jellywp_about_us_widget">
                           <div class="widget_jl_wrapper about_widget_content"> <span class="jl_none_space"></span>
                              <div class="widget-title" style="margin-top: -17px;">
                                 <h2><?= $allLabelsArray[427] ?></h2>
                              </div>
                              <div class="jellywp_about_us_widget_wrapper">
                                 <ul style="list-style: none; text-align: left;">
                                    <li style="display: inline-block; margin-right: 15px;"><a target="_new" href="https://www.facebook.com/ourcanadaservices/"><i class="fa fa-facebook" style="width: 25px;margin-bottom: 15px;background: #3b5999;text-align: center;line-height: 40px;width: 40px;border-radius: 100%;"></i></a></li>
                                    <li style="display: inline-block; margin-right: 15px;"><a target="_new" href="https://twitter.com/OurCanadaInfo"><i class="fa fa-twitter" style="width: 25px;margin-bottom: 15px;background: #55acee;text-align: center;line-height: 40px;width: 40px;border-radius: 100%;"></i></a></li>
                                    <li style="display: inline-block;margin-right: 15px;"><a target="_new" href="https://www.instagram.com/ourcanadaservices/"><i class="fa fa-instagram" style="width: 25px;margin-bottom: 15px;background: #ae1c35;text-align: center;line-height: 40px;width: 40px;border-radius: 100%;"></i></a></li>
                                 </ul>
                              </div> <span class="jl_none_space"></span>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-6 col-lg-4"> <span class="jl_none_space"></span>
                        <div id="disto_recent_post_widget-3" class="widget post_list_widget">
                           <div class="widget_jl_wrapper"> <span class="jl_none_space"></span>
                              <div class="widget-title">
                                 <h2><?= $allLabelsArray[707] ?></h2>
                              </div>
                              <div>
                                 <ul class="feature-post-list recent-post-widget">
									 <?php
									 
$footerquery = "SELECT * FROM `".$blog_table."` WHERE status = 1 ORDER BY id DESC LIMIT 2";
$footerresult = mysqli_query( $conn, $footerquery );
if(mysqli_num_rows($footerresult) < 1){
  echo $allLabelsArray[512];
}
									while($row = mysqli_fetch_assoc($footerresult)){
                    if(!empty(getCurLang($langURL,true))){
                      $row['slug'] = rand(10,1000000).'-'.$row['id'];
                    }
                  $cate_list = mysqli_query($conn,"SELECT * FROM category_blog WHERE id IN(".$row['category'].")");
									 $cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
                   $tags = [];
                   while ($cate_row = mysqli_fetch_assoc($cate_list)) {
                     array_push($tags, $cate_row['title'.$cate_title]);
                   }
                   $image = explode(',', $row['slider_images']);
										// $tags = explode( ",", $row[ 'category' ] );
										?>
                                    <li>
                                       <a href="<?= cleanURL('blog/'.$row['slug']) ?>" class="jl_small_format feature-image-link image_post featured-thumbnail" title="">
                                          <?php  $img = '';  if($row["type"]=="video-image-blog" or $row["type"]=="image-slider-blog")
                                                   {
                                                    $img = getContentMedia('image',$image[0]);

                                                    // if(count(explode('uploads/gallery/', $image[0])) > 1){
                                                    //   $img = $cms_url.$image[0];
                                                    // }else{
                                                    //   if(count(explode('uploads/images/', $image[0])) > 1){
                                                    //     $img = $cms_url.$image[0];
                                                    //   }else{
                                                    //       $img = $cms_url."uploads/images/".$image[0];
                                                    //   }
                                                      
                                                    // }
                                                      
                                                   } else if($row["type"]=="simpleblog")
                                                   {
                                                    $img_path5 = getContentMedia('image',$row['content_thumbnail'],true);
                                                      
            // $img_path5 = $cms_url.'uploads/gallery/'.$row['content_thumbnail'];
                                                      $img = $img_path5;
                                                   } else if($row["type"]=="video-blog")
                                                   {
                                                    if($row['embed']){
                                                      $img = 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/hqdefault.jpg';
                                                    }else{
                                                      $img = getContentMedia('image',$row['single_image']);
                                                    // $img = $cms_url.'uploads/images/'.$row['single_image'];
                                                      
                                                    }
                                                      // $img = $cms_url.'assets/img/videoblog.png';
                                                   } ?>
                                          <div class="attachment-disto_small_feature size-disto_small_feature wp-post-image" alt="" style="width: 100px; height: 100px !important; border-radius: 10px; background: url('<?= $img ?>'); background-size: cover; background-position: center;"></div>
                                          <div class="background_over_image"></div>
                                       </a>
                                       <div class="item-details"> <span class="meta-category-small"><?php foreach ($tags as $key => $value): 
													if($value!=null){?>
					<a class="post-category-color-text" style="background:#FE0000" href="<?= cleanURL('blog/'.$row['slug']); ?>" title="<?= $value ?>"><?php if(strlen($value)>6){echo substr($value, 0, 6).'...';}else{echo $value;} ?></a>
					<?php }endforeach ?></span> 
                                          <h3 class="feature-post-title"><a href="<?= cleanURL('blog/'.$row['slug']); ?>">
                                                  <?php echo $row["title"];?></a>
                                                </h3>
                                          <label>
                    <img src="<?= $cms_url ?>assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                    <?php if($row['created_by'] == 0){
                      $u = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$row['creator_id']);
                      $u_data = mysqli_fetch_assoc($u);
                      ?><a href="<?= cleanURL('user/'.$u_data['id']) ?>"><?php echo $u_data['username']; ?></a><?php
                    }else{
                      echo "Our Canada Services";
                    } ?>
                  </label>
                                       </div>
                                    </li>
                                    <?php }?>
                                 </ul>
                              </div> <span class="jl_none_space"></span>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-6 col-lg-4">
                        <div id="categories-4" class="widget widget_categories">
                           <div class="widget-title">
                              <h2><?= $allLabelsArray[428]?> </h2>
                              <?php 
                                 $query = "SELECT *,title_french as title_francais FROM `category_blog` ORDER BY `id` DESC LIMIT 6";
                                 $result = mysqli_query($conn, $query);
                              ?>
                           </div>
                           <ul>
                              <?php 
                                 while($row = mysqli_fetch_assoc($result)){
                                  if(!empty(getCurLang($langURL,true))){
                                    $row['slug'] = rand(10,1000000).'-'.$row['id'];
                                  }
                                     $cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
                              ?>
                              <li class="cat-item cat-item-<?= $row['id']+1 ?>">
                                 <a style="text-decoration: none !important;"><?= $row['title'.$cate_title] ?></a>
                                 <span style="<?php if($displayType == 'Right to Left'){ ?> float:left; <?php } ?>background: <?= $get_color[str_replace(' ','',strtolower($row['title']))] ?>">
                                    <?php 
                                       $query1 = "SELECT COUNT(*) as blog_count FROM `".$blog_table."` WHERE FIND_IN_SET('{$row['id']}', `category`) && status = 1";
                                       $result1 = mysqli_query($conn, $query1);
                                       $row1 = mysqli_fetch_assoc($result1);

                                       $query2 = "SELECT COUNT(*) as news_count FROM ".$news_table." WHERE FIND_IN_SET('{$row['id']}', `category`) && status = 1";
                                       $result2 = mysqli_query($conn, $query2);
                                       $row2 = mysqli_fetch_assoc($result2);
                                       echo $row1['blog_count'] + $row2['news_count'];
                                    ?>
                                 </span>
                              </li>
                              <?php } ?>                             
                           </ul>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer-bottom enable_footer_copyright_dark">
               <div class="container">
                  <div class="row bottom_footer_menu_text ">
                     <div class="col-md-5 footer-left-copyright text-left">
                     <p class="copyright-text pb-0 mb-0 "><span class="">OurCanada</span> © 2021</p>
                     <!-- © Copyright 2021 Our Canada Services Inc. All Rights Reserved Powered by Our Canada Services Inc. -->
                     </div>
                     <div class="col-md-7 col-lg-7  d-md-block d-lg-block">
                    <div class="social-nav ">
                        <ul class="list-unstyled social-list mb-0">
                            <li class="list-inline-item tooltip-hover">
                                <a target="_blank" href="https://ourcanada<?php echo $ext; ?>/terms<?= getCurLang($langURL) ?>" class="rounded static_label" data-org="Privacy &amp; Terms Of Use"><?= $allLabelsArray[16] ?></a>

                            </li>

                        </ul>
                    </div>
                </div>

                  </div>
                  <div class="row">
                <div class="col-sm-12 text-left">
                    <!-- <p class="copyright-text"><span class="static_label" data-org="Please">Please</span> <a style="color: #FE0000" target="_blank" href="<?= $ourcanada_app ?>contact-us/"><span class="static_label" data-org="contact us">contact us</span> </a> <span class="static_label" data-org="if you have feedback for us or if you want to create a professional account."><?= $allLabelsArray[113] ?></span> </p> -->
                    <p class="copyright-text"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[238] ?>"><?php echo $allLabelsArray[238] ?></span> <a style="color: red;" href="https://ourcanada<?php echo $ext; ?>/contact-us<?php echo getCurLang($langURL) ?>" target="blank"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[110] ?>"><?php echo $allLabelsArray[110] ?></span> </a> <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[239] ?>"><?php echo $allLabelsArray[239] ?></span> </p>

                </div>
            </div>
               </div>
            </div>
         </footer>