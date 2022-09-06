<?php
include_once 'community/user_inc.php';
date_default_timezone_set('America/Los_Angeles');
    
$environment=false;

$CurrentDate = date('m/d/Y');
$dueDatePST = date('Y-m-d H:i:s');
$dueDatePST = date( 'Y-m-d H:i:s', strtotime( $dueDatePST . '- 1 hour' ) );

$getUserProfile = mysqli_query($conn,"SELECT * FROM users WHERE id = {$_POST['user']}");
$userRow = mysqli_fetch_assoc($getUserProfile);

$page = 0;
if(isset($_POST['page']) && is_numeric($_POST['page']) && $_POST['page'] > 0){
  $page = $_POST['page'];
}


$table = 'blog_content';



if(isset($_POST['content']) && !empty($_POST['content'])){
  $table = $_POST['content'];
}

if(isset($_POST['lang']) && !empty($_POST['lang'])){
  $table = $table.'_'.$_POST['lang'];
}else if(isset($_GET['lang']) && !empty($_GET['lang'])){
  $table = $table.'_'.$_GET['lang'];
}
$content_type = explode('_', $table)[0];
$query = "SELECT * FROM ".$table." WHERE status = 1 && creator_id = ".$userRow['id']." ";

if($page > 1){
  $query .= ' LIMIT '.( 6 * ($page - 1)).',6 ';
}else{
  $query .= ' LIMIT 0,6 ';
}

$blogsList = mysqli_query($conn,$query);
  
$getTotalRow = mysqli_query($conn,"SELECT COUNT(*) as total FROM ".$table." WHERE status = 1 && creator_id = ".$userRow['id']." ");
$total = mysqli_fetch_assoc($getTotalRow)['total'];
$total_pages = ceil($total / 6);

?>

<?php while($row = mysqli_fetch_assoc($blogsList)){ 
  if(!empty(getCurLang($langURL,true))){
    $row['slug'] = rand(10,1000000).'-'.$row['id'];
  }


$image = explode(',', $row['slider_images']);

$img_path = getContentMedia('image',$image[0]);

// if(count(explode('uploads/gallery/', $image[0])) > 1){
//   $img_path = $cms_url.$image[0];
// }else{
//   if(count(explode('uploads/images/', $image[0])) > 1){
//     $img_path = $cms_url.$image[0];
//   }else{
//     $img_path = $cms_url."uploads/images/".$image[0];
//   }
// }


if ( $row[ "type" ] == "video-image-news" or $row[ "type" ] == "video-image-blog" or $row["type"]=="image-slider-news" or $row["type"]=="image-slider-blog" ) {
    $thumbnail_pic = $img_path;
  } elseif ( $row[ "type" ] == "video-news" || $row[ "type" ] == "video-blog" ) {
    if(!empty($row['embed'])){
      $thumbnail_pic = 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/hqdefault.jpg';
    }else{
      $thumbnail_pic = getContentMedia('image',$row['single_image']);
      // $thumbnail_pic = $cms_url.'uploads/images/'.$row['single_image'];
    }
  } else if($row["type"]=="simplenews" || $row["type"]=="simpleblog"){
  $thumbnail_pic = getContentMedia('image',$row['content_thumbnail'],true);
    // $thumbnail_pic = $cms_url.'uploads/gallery/'.$row['content_thumbnail']; 
	}


 //  	$thumbnail_pic = $cms_url;
	// if(!empty(str_replace('undefined', '', $row['content_thumbnail']))){
 //  		$thumbnail_pic = $thumbnail_pic.'uploads/gallery/'.$row['content_thumbnail'];
	// }

?>
<div class="box jl_grid_layout1 blog_grid_post_style post-4761 post type-post status-publish format-standard has-post-thumbnail hentry category-sports" data-aos="fade-up">
  <div class="post_grid_content_wrapper">
    <div class="image-post-thumb">
      <a href="javascript:void(0);" class="link_image featured-thumbnail" title="Round white dining table on brown hardwood">
        <img width="780" height="450" src="<?= $thumbnail_pic ?>" class="attachment-disto_large_feature_image size-disto_large_feature_image wp-post-image" alt="" />
        <div class="background_over_image"></div>
      </a> 
    </div>
    <div class="post-entry-content">
      <div class="post-entry-content-wrapper">
        <div class="large_post_content">
         
          <h3 class="image-post-title"><a href="<?= cleanURL($content_type.'/'.$row['slug']); ?>"><?= $row['title'] ?></a></h3>
          <span class="jl_post_meta" >
            
            <span class="post-date">
              <i class="fa fa-clock-o"></i><?= time_ago($row['created_at']); ?>
            </span>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } 
  if(mysqli_num_rows($blogsList) < 1){ ?>
    <h3 align="center"><?= $allLabelsArray[512] ?></h3>
  <?php } ?>
<div class="col-lg-12">
  <?= get_pagination_links($page == 0 ? 1 : $page,$total_pages); ?>
</div>