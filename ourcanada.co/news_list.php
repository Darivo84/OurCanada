<?php
// require_once 'cms_error.php';

include_once 'community/user_inc.php'; $page = 'inner';
date_default_timezone_set('America/Los_Angeles');
    
$environment=false;

$CurrentDate = date('m/d/Y');
$dueDatePST = date('Y-m-d H:i:s');
$dueDatePST = date( 'Y-m-d H:i:s', strtotime( $dueDatePST . '- 1 hour' ) );

?>
<div class="row">
              <?php
                $query = "SELECT * FROM `".$news_table."` WHERE ";
                $page = 0;
                if(isset($_POST['page']) && $_POST['page'] > 0){
                  $page = $_POST['page'];
                }

                $que = '';
                if(isset($_POST['q']) && !empty($_POST['q'])){
                  $que .= ' title LIKE "%'.$_POST['q'].'%" && ';
                  $query .= $que;
                }

                if(isset($_POST['value']) && count($_POST['value']) > 0){
                  for ($i=0; $i < count($_POST['value']); $i++) { 
                    $que .= " FIND_IN_SET('".$_POST['value'][$i]."',category) && status = 1 ||";
                  }
                  $query .= substr($que, 0, -2)." ORDER BY id DESC";
                }else{
                  $query .= " status = 1 ORDER BY id DESC ";
                }

                if($page > 1){
                  $query .= ' LIMIT '.( 12 * ($page - 1)).',12 ';
                }else{
                  $query .= ' LIMIT 0,12 ';
                }
                $result = mysqli_query($conn, $query);
                $count = 0;
                while($row = mysqli_fetch_assoc($result)){
                  if(!empty(getCurLang($langURL,true))){
                    $row['slug'] = rand(10,1000000).'-'.$row['id'];
                  }
                  $image = explode(',', $row['slider_images']);
          
       
                $video = '';
                if ( !empty( $row[ 'video' ] ) ) {
                  $video = 'local';
                  $video_local = explode( ",", $row[ 'video' ] );
                }
              ?>
              <div data-status-num="<?php echo $row['status']; ?>" class="box blog_grid_post_style  jl_row_1 col-md-3" style="height: 469px !important;">
                <div class="jl_grid_box_wrapper">
                  <?php 
                  $img_path = getContentMedia('image',$image[0]);
                
                  ?>
                  <div class="image-post-thumb" style="border-radius: 10px; height: 300px; background-position: center center; background-size: cover; background-image: url(<?php if ( $row[ "type" ] == "video-image-news" or $row[ "type" ] == "video-image-blog" or $row["type"]=="image-slider-news" or $row["type"]=="image-slider-blog" ) {
            echo "'".$img_path."'";
          } elseif ( $row[ "type" ] == "video-news" || $row[ "type" ] == "video-blog" ) {
            if(!empty($row['embed'])){
              echo 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/hqdefault.jpg';
            }else{
              echo getContentMedia('image',$row['single_image']);
            }
          } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news'])){
            echo getContentMedia('image',$row['content_thumbnail'],true);  
          } ?>);"> <a href="<?= cleanURL('news/'.$row['slug']) ?>" class="link_image featured-thumbnail" title="">
       
          
                    <div class="background_over_image"></div>
                    </a> <span class="meta-category-small">
           
           
            </span> </div>
                  <div class="post-entry-content" >
                    <h3 class="image-post-title"><a class="text-doted" href="<?= cleanURL('news/'.$row['slug']) ?>" title="<?= $row['title'] ?>"><?php echo $row['title'] ?></a></h3>
                     
                    <span class="jl_post_meta"><span class="jl_author_img_w"><img src="<?= $cms_url ?>assets/img/favicon.jpg" width="30" height="30" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" /><a href="#" title="Posts by Anna Nikova" rel="author">
                      <?php
                      $query = "SELECT * FROM `users` WHERE id={$row['creator_id']}";
                      $fetch = mysqli_fetch_assoc(mysqli_query($conn, $query));
                      
                      if($row['created_by'] == 0) {
                          ?><a href="<?= cleanURL('user/'.$fetch['id']) ?>"><?= $fetch['username'] ?></a><?php
                      }else{
                        echo $allLabelsArray[283];
                      }
                     ?>
                     </a></span><span class="post-date w-100"><i class="fa fa-clock-o"></i>
                      <?php echo time_ago($row['created_at']); ?>
                      <br><span style="margin-left: 30px;">UTC-08:00</span></span></span>
                     
                    
                  </div>
                </div>
              </div>
              <?php $count++;}

                  if($count%2==0){
              ?>
              <?php if(mysqli_num_rows($result) < 1){
                  echo "<h1 align='center'>".$allLabelsArray[512]."...</h1>";
                } ?>
                <br>
              <?php }?>
        
            </div>
             <div class="container-fluid" style="text-align: right; padding: 0;">

                <?php
                $query1 = "SELECT COUNT(*) as total FROM `".$news_table."` WHERE ";
                if(isset($_POST['value']) && count($_POST['value']) > 0){
                  $que = '';
                  for ($i=0; $i < count($_POST['value']); $i++) { 
                    $que .= " FIND_IN_SET('".$_POST['value'][$i]."',category) && status = 1 ||";
                  }
                  $query1 .= substr($que, 0, -2)." ORDER BY id DESC";
                }else{
                  $query1 .= " status = 1 ORDER BY id DESC ";
                }
                $getTotalRow = mysqli_query($conn,$query1);
                $total = mysqli_fetch_assoc($getTotalRow)['total'];
                $total_pages = ceil($total / 12); 
                echo get_pagination_links($_POST['page'],$total_pages);
                ?>
          
             </div>
            </div>