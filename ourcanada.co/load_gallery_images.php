<?php include_once 'user_inc.php';  $page = 'inner';
	$img_table = "";
	if(isset($_GET['lang']) && !empty($_GET['lang'])){
		$img_table = "_".$_GET['lang'];
	}
?>
<p class="gallery_error"></p>
			        <?php 
			        $video_dir    = 'uploads/gallery/';
			        $videos = array();
			        $used_img_db_name = '';
			        if($_GET['content_type'] == 'blog' || $_GET['content_type'] == 'Blog'){
			        	$used_img_db_name = 'used_blog_images'.$img_table;
			        }else{
			        	$used_img_db_name = 'used_news_images'.$img_table;
			        }
			        $g = mysqli_query($conn,"SELECT * FROM gallery_images WHERE image NOT IN (SELECT image FROM ".$used_img_db_name.")");
			        while ($r = mysqli_fetch_assoc($g)) {
			            $videos[] = $r['image'];
			        }
			        ?>
			        <div class="row">
			        	<?php if(isset($_GET['edit']) && isset($_GET['cur'])){ ?>
			        		<div class="video_item col-lg-4">
				            <i class="fa fa-check <?php if($_GET['edit'] == $_GET['cur']){echo'active';} ?>"></i>
				            <img img-name="<?= $_GET['edit'] ?>" file-name="uploads/gallery/<?= $_GET['edit'] ?>" src="<?= $cms_url.$video_dir.$_GET['edit'] ?>" />
				          </div>
			        	<?php } ?>
			          <?php for ($i=0; $i < count($videos); $i++) { ?>
			          	<?php if(isset($_GET['edit'])){ 
			          		if($_GET['edit'] != $videos[$i]){ ?>
			          <div class="video_item col-lg-4">
			            <i class="fa fa-check <?php if(isset($_GET['cur']) && $_GET['cur'] == $videos[$i]){echo'active';} ?>"></i>
			            <img img-name="<?= $videos[$i] ?>" file-name="uploads/gallery/<?= $videos[$i] ?>" src="<?= utf8_decode($cms_url.$video_dir.$videos[$i]) ?>" />
			          </div>
			          <?php } }else{ ?>
			          	<div class="video_item col-lg-4">
			            <i class="fa fa-check <?php if(isset($_GET['cur']) && $_GET['cur'] == $videos[$i]){echo'active';} ?>"></i>
			            <img img-name="<?= $videos[$i] ?>" file-name="uploads/gallery/<?= $videos[$i] ?>" src="<?= utf8_decode($cms_url.$video_dir.$videos[$i]) ?>" />
			          </div>
			          <?php } } ?>
			        </div>