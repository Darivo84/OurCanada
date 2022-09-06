<?php
include_once( "global.php" );
$query = "SELECT * FROM `news` WHERE `status` = 1 ORDER BY id DESC LIMIT 5";
$result = mysqli_query( $conn, $query );

$querycount = "SELECT count(id) as count FROM `news` where status=1";
$result2 = mysqli_query( $conn, $querycount );
$row1 = mysqli_fetch_assoc( $result2 );
$newscount = $row1[ 'count' ];

$query1 = "SELECT * FROM `content-uploads` ORDER BY id DESC LIMIT 5";
$result1 = mysqli_query( $conn, $query1 );

$querycount1 = "SELECT count(id) as count FROM `content-uploads`";
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
	<meta name="author" content="">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<!-- Title-->
	<title>Our Canada - Home</title>
	<!-- Favicon-->
	<?php include("includes/style.php"); ?>
	<!-- end head -->
</head>

<body class="mobile_nav_class jl-has-sidebar">
	<div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
		<div class="options_layout_container full_layout_enable_front">
			<!-- Start header -->
			<?php include("includes/header.php"); ?>
			<!-- end header -->

			<!-- slider section -->
			<div class="jl_home_section jl_home_slider">
            <div class="container">
               <div class="row">
                  <div class="col-md-12 jl_mid_main_3col">
                        <div class="page_builder_slider jelly_homepage_builder">
                                    <div class="jl_slider_nav_tab large_center_slider_container">
                                       <div class="row header-main-slider-large">
                                          <div class="col-md-12">
                                             <div class="large_center_slider_wrapper">
                                                <div class="home_slider_header_tab jelly_loading_pro">
                                                   <div class="item">
                                                      <div class="banner-carousel-item"> <span class="image_grid_header_absolute" style="background-image: url('assets/img/banner-images/irina-iriser-654436-unsplash-1920x982.jpg');"></span>
                                                         <a href="#" class="link_grid_header_absolute"></a>
                                                         <div class="banner-container">
                                                            <div class="container">
                                                               <div class="row">
                                                                  <div class="col-md-12">
                                                                     <div class="banner-inside-wrapper"> <span class="meta-category-small"><a class="post-category-color-text" style="background:#0015ff" href="#">Business</a></span> 
                                                                        <h5><a href="#">People are enjoy the job that they love</a></h5>
                                                                        <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" width="30" height="30" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" /><a href="#" title="Posts by Anna Nikova" rel="author">Anna Nikova</a></span><span class="post-date"><i class="fa fa-clock-o"></i>Dec 24, 2016</span></span>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="item">
                                                      <div class="banner-carousel-item"> <span class="image_grid_header_absolute" style="background-image: url('assets/img/banner-images/vincent-branciforti-797823-unsplash-1920x982.jpg')"></span>
                                                         <a href="#" class="link_grid_header_absolute"></a>
                                                         <div class="banner-container">
                                                            <div class="container">
                                                               <div class="row">
                                                                  <div class="col-md-12">
                                                                     <div class="banner-inside-wrapper"> <span class="meta-category-small"><a class="post-category-color-text" style="background:#6b34ba" href="#">Gaming</a></span> 
                                                                        <h5><a href="#">Every photographer needs to shoot this photo</a></h5>
                                                                        <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" width="30" height="30" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" /><a href="#" title="Posts by Anna Nikova" rel="author">Anna Nikova</a></span><span class="post-date"><i class="fa fa-clock-o"></i>Dec 24, 2016</span></span>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="item">
                                                      <div class="banner-carousel-item"> <span class="image_grid_header_absolute" style="background-image: url('assets/img/banner-images/daniel-olah-1079449-unsplash-1920x982.jpg')"></span>
                                                         <a href="#" class="link_grid_header_absolute"></a>
                                                         <div class="banner-container">
                                                            <div class="container">
                                                               <div class="row">
                                                                  <div class="col-md-12">
                                                                     <div class="banner-inside-wrapper"> <span class="meta-category-small"><a class="post-category-color-text" style="background:#ed1c1c" href="#">Active</a></span> 
                                                                        <h5><a href="#">Have a good time with my friend and enjoyed</a></h5>
                                                                        <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" width="30" height="30" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" /><a href="#" title="Posts by Anna Nikova" rel="author">Anna Nikova</a></span><span class="post-date"><i class="fa fa-clock-o"></i>Dec 24, 2016</span></span>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="item">
                                                      <div class="banner-carousel-item"> <span class="image_grid_header_absolute" style="background-image: url('assets/img/banner-images/daniel-korpai-1236913-unsplash-1920x982.jpg')"></span>
                                                         <a href="#" class="link_grid_header_absolute"></a>
                                                         <div class="banner-container">
                                                            <div class="container">
                                                               <div class="row">
                                                                  <div class="col-md-12">
                                                                     <div class="banner-inside-wrapper"> <span class="meta-category-small"><a class="post-category-color-text" style="background:#d66300" href="#">Science</a></span> 
                                                                        <h5><a href="#">This is a great photo and nice for shooting</a></h5>
                                                                        <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" width="30" height="30" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" /><a href="#" title="Posts by Anna Nikova" rel="author">Anna Nikova</a></span><span class="post-date"><i class="fa fa-clock-o"></i>Dec 24, 2016</span></span>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                                <div class="jlslide_tab_nav_container">
                                                   <div class="jlslide_tab_nav_row">
                                                      <div class="home_slider_header_tab_nav news_tiker_loading_pro">
                                                         <div class="item">
                                                            <div class="banner-carousel-item"> <span class="image_small_nav" style="background-image: url('assets/img/banner-images/irina-iriser-654436-unsplash-120x120.jpg')"></span>
                                                               <h5>
                                                                        People are enjoy the job that they love                                        
                                                                     </h5>
                                                            </div>
                                                         </div>
                                                         <div class="item">
                                                            <div class="banner-carousel-item"> <span class="image_small_nav" style="background-image: url('assets/img/banner-images/vincent-branciforti-797823-unsplash-120x120.jpg')"></span>
                                                               <h5>
                                                                        Every photographer needs to shoot this photo                                        
                                                                     </h5>
                                                            </div>
                                                         </div>
                                                         <div class="item">
                                                            <div class="banner-carousel-item"> <span class="image_small_nav" style="background-image: url('assets/img/banner-images/daniel-olah-1079449-unsplash-120x120.jpg')"></span>
                                                               <h5>
                                                                        Have a good time with my friend and enjoyed                                        
                                                                     </h5>
                                                            </div>
                                                         </div>
                                                         <div class="item">
                                                            <div class="banner-carousel-item"> <span class="image_small_nav" style="background-image: url('assets/img/banner-images/daniel-korpai-1236913-unsplash-120x120.jpg')"></span>
                                                               <h5>
                                                                        This is a great photo and nice for shooting                                        
                                                                     </h5>
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

			<div class="jl_home_section jl_home_mbg">
				<div class="container">
					<div class="row">
						<div class="col-md-12 jl_mid_main_3col">
							<div class="jl_3col_wrapin">
								<div class="jl_main_with_right_post jelly_homepage_builder">
									<div class="homepage_builder_title">
										<h2 class="builder_title_home_page">
                                                   Latest News  
                                                </h2>
									</div>
									<?php $row = mysqli_fetch_assoc($result);
									if($row["id"]!=""){
									 $image = explode(',', $row['images']);
										$queryauthor = "SELECT * FROM `users` WHERE id={$row['user_id']}";
$fetch1 = mysqli_fetch_assoc( mysqli_query( $conn, $queryauthor ) );
$author = $fetch1[ 'username' ];
									 ?>
									<div class="jl_main_post_style_padding">
										<div class="jl_main_post_style"> <span class="image_grid_header_absolute" style="background-image: url('<?php echo 'https://cms.ourcanadadev.site/uploads/images/'.$image[0]; ?>')"></span>
											<a href="<?php echo $url."news/".$row["slug"];?>" class="link_grid_header_absolute" title="It’s always fun time and smile in the summer"></a>
											<div class="post-entry-content"> <span class="meta-category-small">
											    
											    <!--<a class="post-category-color-text" style="background:#ed1c1c" href="#"><?php echo $row["type"];?></a>-->
											    
											    
											</span>
												<h3 class="image-post-title"><a href="<?php echo $url."news/".$row["slug"]; ?>">
                                                         <?php echo $row["title"]; ?></a>
                                                      </h3>
											

												<span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="#" title="Posts by Anna Nikova" rel="author"><?php echo $author;?></a></span><span class="post-date"><i class="fa fa-clock-o"></i><?php echo $row["created_date"];?></span></span>
											</div>
										</div>
									</div>
									<?php
									while ( $row = mysqli_fetch_assoc( $result ) ) {
										$image = explode( ',', $row[ 'images' ] );
										?>
									<div class="jl_list_post_wrapper">
										<a href="<?php echo $url."news/".$row["slug"]; ?>" class="jl_small_format feature-image-link image_post featured-thumbnail">
                                             <img src="<?php if ( $row[ "type" ] == "video-image-news" or $row["type"]=="image-slider-news" ) {
						echo 'https://cms.ourcanadadev.site/uploads/images/' . $image[ 0 ];
					} else if ( $row[ "type" ] == "video-news" ) {
						echo 'https://cms.ourcanadadev.site/assets/img/videonews.png';
					} else if($row["type"]=="simplenews"){
						echo 'https://cms.ourcanadadev.site/assets/img/simplenews.png';}?>" alt="" width="120" height="120">
                                             <div class="background_over_image"></div>
                                          </a>
									

										<div class="item-details"> <span class="meta-category-small">
										    
										    <!--<a class="post-category-color-text" style="background:#d1783c" href=""><?php echo $row["type"];?></a>-->
										    
										    
										    </span>
											<h3 class="feature-post-title"><a href="<?php echo $url."news/".$row["slug"]; ?>">
                                                      <?php echo $row["title"];?></a>
                                                   </h3>
										

											<span class="post-meta meta-main-img auto_image_with_date">                             <span class="post-date"><i class="fa fa-clock-o"></i><?php echo $row["created_date"];?></span></span>
										</div>
									</div>
									<?php }}
									else{?>
									
									<div class="col-12 text-center"><h3>No News Found</h3></div>
									
									<?php }?>
								</div>
								<!---->
							</div>
						</div>
					</div>
               <div class="jelly_homepage_builder jl_nonav_margin homepage_builder_3grid_post jl_cus_grid_overlay jl_fontsize20 jl_cus_grid3    ">
                                       <div class="jl_wrapper_row jl-post-block-314983">
                                          <h2 class="builder_title_home_page">
                                                   Featured News  
                                                </h2>
                                          <div class="row">
                                             <?php 
                                                $query_featured_news = "SELECT * FROM `news` ORDER BY `id` DESC LIMIT 3";
                                                $featured_news_result = mysqli_query($conn, $query_featured_news);
                                                if(mysqli_num_rows($featured_news_result) > 0){
                                                while($featured_news = mysqli_fetch_assoc($featured_news_result)){
                                                   $image = explode(',', $featured_news['images']);
                                                   $queryauthor1 = "SELECT * FROM `users` WHERE id={$fetched_feature_news['user_id']}";
                                                   $fetch2 = mysqli_fetch_assoc( mysqli_query( $conn, $queryauthor1 ) );
                                                   $author1 = $fetch2[ 'username' ];
                                                   if($featured_news['type'] == 'simplenews'){
                                              ?>
                                             <div class="col-md-4 blog_grid_post_style jl_row_1">
                                                <div class="jl_grid_box_wrapper"> <span class="image_grid_header_absolute" style="background-image: url('https://cms.ourcanadadev.site/assets/img/simplenews.png')"></span>
                                                   <a href="<?php echo $url."news/".$featured_news["slug"];?>" class="link_grid_header_absolute" title="This is a great toy and beautiful for short"></a> 
                                                   <div class="post-entry-content">
                                                      <h3 class="image-post-title"><a href="#">
                                                               <?= $featured_news['title'] ?></a>
                                                            </h3>
                                                      <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="#" title="Posts by Anna Nikova" rel="author"><?php echo $author;?></a></span><span class="post-date"><i class="fa fa-clock-o"></i><?php echo $featured_news["created_date"];?></span></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } else if($featured_news['type'] == 'video-news'){ ?>
                                                <div class="col-md-4 blog_grid_post_style jl_row_1">
                                                <div class="jl_grid_box_wrapper"> <span class="image_grid_header_absolute" style="background-image: url('https://cms.ourcanadadev.site/assets/img/videonews.png')"></span>
                                                   <a href="<?php echo $url."news/".$featured_news["slug"];?>" class="link_grid_header_absolute" title="This is a great toy and beautiful for short"></a> 
                                                   <div class="post-entry-content">
                                                      <h3 class="image-post-title"><a href="#">
                                                               <?= $featured_news['title'] ?></a>
                                                            </h3>
                                                      <span class="jl_post_meta"><span class="jl_author_img_w"> <img src="assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="#" title="Posts by Anna Nikova" rel="author"><?php echo $author;?></a></span><span class="post-date"><i class="fa fa-clock-o"></i><?php echo $featured_news["created_date"];?></span></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } else { ?>
                                                <div class="col-md-4 blog_grid_post_style jl_row_1">
                                                <div class="jl_grid_box_wrapper"> <span class="image_grid_header_absolute" style="background-image: url('<?php echo 'https://cms.ourcanadadev.site/uploads/images/'.$image[0]; ?>')"></span>
                                                   <a href="<?php echo $url."news/".$featured_news["slug"];?>" class="link_grid_header_absolute" title="This is a great toy and beautiful for short"></a> 
                                                   <div class="post-entry-content">
                                                      <h3 class="image-post-title"><a href="#">
                                                               <?= $featured_news['title'] ?></a>
                                                            </h3>
                                                      <span class="jl_post_meta"><span class="jl_author_img_w"> <img style="margin: 0; padding-right: 4px;" src="assets/img/favicon.jpg" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30"><a href="#" title="Posts by Anna Nikova" rel="author"><?php echo $author;?></a></span><span class="post-date"><i class="fa fa-clock-o"></i><?php echo $featured_news["created_date"];?></span></span>
                                                   </div>
                                                </div>
                                             </div>
                                             <?php } ?>
                                             <?php } } else{?>
                           
                                                <div class="col-12 text-center"><h3>No News Found</h3></div>
                                                
                                                <?php }?>
                                          </div>
                                       </div>
                                    </div>
				</div>
			</div>

			<div class="jl_home_section">
				<div class="container">
					<div class="row">
						<div class="col-md-8" id="content">
							<div class="homepage_builder_title mb-50">
								<h2 class="builder_title_home_page">
                                                   Latest Blogs  
                                                </h2>
							

							</div>
							<div class="post_list_medium_widget jl_nonav_margin page_builder_listpost jelly_homepage_builder jl-post-block-725291">
								<?php 
								while($row = mysqli_fetch_assoc($result1)){
									 $image = explode(',', $row['images']);
								
			  $tags = explode( ",", $row[ 'category' ] );?>
								<div class="blog_list_post_style">
									<div class="image-post-thumb featured-thumbnail home_page_builder_thumbnial">
										<div class="jl_img_container"> <span class="image_grid_header_absolute" style="background-image: url('<?php	if($row["type"]=="video-image-blog" or $row["type"]=="image-slider-blog")
																	{
																		echo 'https://ourcanadadev.site/superadmin/uploads/images/'.$image[0];
																	} else if($row["type"]=="simpleblog")
																	{
																		echo 'https://cms.ourcanadadev.site/assets/img/simpleblog.png';
																	} else if($row["type"]=="video-blog")
																	{
																		echo 'https://cms.ourcanadadev.site/assets/img/videoblog.png';
																	}?>')"></span>
											<a href="<?php echo $url."blog/".$row["slug"]; ?>" class="link_grid_header_absolute"></a>
										</div>
									</div>
									<div class="post-entry-content">
										<span class="meta-category-small">

											<?php foreach ($tags as $key => $value): 
													if($value!=null){?>
											<a class="post-category-color-text" style="background:#FE0000" href="<?php echo $url."blog/".$blog_info['slug']; ?>">
												<?php echo $value ?>
											</a>
											<?php }endforeach ?>


										</span> <span class="post-meta meta-main-img auto_image_with_date"><span class="post-date"><i class="fa fa-clock-o"></i><?php echo $row["created_date"];?></span><span class="meta-comment"><a href=""><i class="fa fa-comment"></i>0</a></span></span>
										<h3 class="image-post-title"><a href="<?php echo $url."blog/".$row["slug"]; ?>">
                                                      <?php echo $row["title"];?></a>
                                                   </h3>
									

										<div class="large_post_content">
											<p>
												<?php 

	if(strlen($row["content"])<=280)
	{echo $row["content"];}
												else
												{
													echo substr($row["content"],0,170)."....";
												}?>
											</p>
										</div>
									</div>
								</div>
								<?php }?>
							</div>
						</div>
						
						<?php include_once("sidebar.php"); ?>
					</div>


				</div>
			</div>
			<!-- end content -->
			<!-- Start footer -->
			<?php include("includes/footer.php"); ?>
			<!-- End footer -->
		</div>
	</div>
	<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a>
	</div>
	<?php include("includes/script.php"); ?>
</body>
</html>