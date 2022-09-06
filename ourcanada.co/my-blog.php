<?php
require_once 'cms_error.php';

$page = 'inner';

include_once( "community/user_inc.php" );
if(!isset($_SESSION['user_id'])){
  header("location: ".$currentTheme.'/login');
}

function neat_trim($str, $n, $delim='...')
{
    $len = mb_detect_encoding($str) == "UTF-8" ? mb_strlen($str, "UTF-8") : strlen($str);
    if ($len > $n)
    {
        preg_match('/(.{' . $n . '}.*?)\b/us', $str, $matches);
        return rtrim($matches[1]) . $delim;
    }
    return $str;
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
    <?php
    if($environment)
    {
    ?>
    <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/my-blog" />

        <?php
    }
    ?>
<!-- Title-->
<title><?= $allLabelsArray[596] ?></title>
<!-- Favicon--> 

<!-- Stylesheets-->
<?php include("community/includes/style.php") ?>
<!-- end head -->
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_none_box_styles jl_border_radiuss">
  <div class="options_layout_container full_layout_enable_front"> 
    <!-- Start header -->
    
    <?php include("community/includes/header.php") ?>
    <!-- end header -->
    <div class="jl_home_section">
  <div class="container">
  <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && ($_SESSION['role'] == 'user')){ ?>
  
        <br>
        
      <?php } ?>
    <div class="row">
      <div class="col-md-12" id="content" style="padding-right: 0px !important;"> 
        <!-- start grid sidebar -->
        <div class="jelly_homepage_builder jl_nonav_margin homepage_builder_3grid_post jl_fontsize22  jl_cus_grid2 colstyle1" style="padding-right: 15px !important; padding-left: 15px !important;">
          <div class="homepage_builder_title">
              <?php if($displayType == 'Right to Left'){ ?>
                  <?php if(!empty($_SESSION['user_id'])){?>
                      <div class="col-sm-4 mt-15" style="padding-right: 0px !important;"><a class="btn btn-login" style="float: left" href="<?php echo $cms_url ?>create-blog<?= $langURL ?>"><?= $allLabelsArray[484] ?></a></div>
                  <?php }?>
                  <div class="col-sm-8" style="padding-left: 0px !important;">
                      <h2 style="float: right"> <?= $allLabelsArray[481] ?> </h2>
                      <span class="jl_hsubt"><?= $allLabelsArray[483] ?></span> </div>

              <?php } else { ?>
                  <div class="col-sm-8" style="padding-left: 0px !important;">
                      <h2> <?= $allLabelsArray[481] ?> </h2>
                      <span class="jl_hsubt"><?= $allLabelsArray[483] ?></span> </div>
                  <?php if(!empty($_SESSION['user_id'])){?>
                      <div class="col-sm-4 text-right mt-15" style="padding-right: 0px !important;"><a class="btn btn-login pull-right" href="<?php echo $cms_url ?>create-blog<?= $langURL ?>"><?= $allLabelsArray[484] ?></a></div>
                  <?php }?>
              <?php } ?>
       
      </div>
      
          <div class="jl_wrapper_row jl-post-block-108832">
            <div class="row">
                <?php 
                if(isset($_SESSION['newsstatus'])){
                $status_news = $_SESSION['newsstatus'];
                unset($_SESSION['newsstatus']);
                if($status_news == "Yes")
                {
                ?>
                
                <div class="alert alert-success">
                    <?= $allLabelsArray[537] ?>
                </div>
                <?php }
                else
                {
                    ?>
                    
                         <div class="alert alert-danger">
                    <?= $allLabelsArray[444] ?>
                </div>
                    <?php
                    
                }  } ?>
                
                
                
              <?php 
                $page = 0;
                if(isset($_GET['page']) && $_GET['page'] > 0){
                  $page = $_GET['page'];
                }
                if($page > 1){
                  $query = "SELECT * FROM `".$blog_table."` WHERE creator_id = '{$_SESSION['user_id']}' LIMIT ".( 12 * ($page - 1)).",12";
                }else{
                  $query = "SELECT * FROM `".$blog_table."` WHERE creator_id = '{$_SESSION['user_id']}' LIMIT 0,12";
                }
                $result = mysqli_query($conn, $query);
                $count = 0;
                while($row = mysqli_fetch_assoc($result)){
                  if(!empty(getCurLang($langURL,true))){
                    $row['slug'] = rand(10,1000000).'-'.$row['id'];
                  }
                  $image = explode(',', $row['slider_images']);
              ?>
              <div class="box blog_grid_post_style  jl_row_1 col-sm-12">
                <div class="jl_grid_box_wrapper">
                  <?php 
                   $img_path = getContentMedia('image',$image[0]);

                  ?>
                  <div class="image-post-thumb" style="border-radius: 10px; height: 300px; background-position: center center; background-size: cover; background-image: url(<?php if ( $row[ "type" ] == "video-image-news" or $row[ "type" ] == "video-image-blog" or $row["type"]=="image-slider-news" or $row["type"]=="image-slider-blog" ) {
            echo "'".$img_path."'";
          } elseif ( $row[ "type" ] == "video-news" || $row[ "type" ] == "video-blog" ) {
            if(!empty($row['embed'])){
              echo 'http://img.youtube.com/vi/'.explode('embed/', $row['embed'])[1].'/mqdefault.jpg';
            }else{
              echo getContentMedia('image',$row['single_image']);
            }
          } else if(in_array($row['type'], ['simpleblog','simplenews','pdf-blog','pdf-news'])){
            echo getContentMedia('image',$row['content_thumbnail'],true);
          } ?>);"> <a href="<?= cleanURL('blog/'.$row['slug']); ?>" class="link_image featured-thumbnail" title="">
            
             
            
            
            
                    <div class="background_over_image"></div>
                    </a> <span class="meta-category-small">
          
            
            </span> </div>
                  <div class="post-entry-content">
                    <h3 class="image-post-title"><a href="<?= cleanURL('blog/'.$row['slug']) ?>" title="<?= $row['title']; ?>" class="text-doted"><?php echo $row['title'] ?></a></h3>
                    <span class="jl_post_meta">
                      <span class="post-date" style="width: 100%;">
                        <span class="jl_author_img_w">
                          <img src="<?= $cms_url ?>assets/img/favicon.jpg" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" width="30" height="30">
                          <a href="javascript:void(0)" rel="author">
                          <?php if(!empty($get_user)){
                            ?><a href="<?= cleanURL('user/'.$get_user['id']) ?>"><?= $get_user['username'] ?></a><?php
                          } ?>
                          </a></span>
                      </span>
                      <span class="post-date"><i class="fa fa-clock-o"></i>
                        <?php 
                        echo time_ago($row['created_at']); 
                        ?>
                        <br><span style="margin-left: 30px;">UTC-08:00</span></span></span>
                    
                  </div>
          <a>
            
          <a class="edit" href="<?php echo $cms_url."edit-content/".$row['slug'].$langURL; ?>?blog"><i class="fa fa-pencil-square-o"></i></a>
          </a>
          <span class="edit" style="cursor: pointer;" onclick="deleteContent(<?= $row['id'] ?>);"><i class="fa fa-trash" style="color: red;"></i></span>

          <?php if($row['status'] == '0') { ?>
          <button type="" class="post-category-color-text userStatus" style="background:#FE0000; cursor: default;"><?= $allLabelsArray[593] ?></button>
          <?php } else { ?>
          <button type="" class="post-category-color-text userStatus" style="background:#0E7506; cursor: default;"><?= $allLabelsArray[594] ?></button>
          <?php } ?>
          
          
                </div>
              </div>
              <?php $count++;} 
                  if($count%2==0){
              ?>
                <br>
              <?php }
                if(mysqli_num_rows($result) < 1){
                  echo '<h1 align="center">'.$allLabelsArray[512].'</h1>';
                }
              ?>
          
              <div class="col-lg-12">
                <?php 
                  $query1 = "SELECT COUNT(*) as total FROM `".$blog_table."` WHERE creator_id = '{$_SESSION['user_id']}'";
                  $getTotalRow = mysqli_query($conn,$query1);
                  $total = mysqli_fetch_assoc($getTotalRow)['total'];
                  $total_pages = ceil($total / 12);
                  if($total_pages > 1){
                ?>
                <ul class="pagination">
                  <?php for ($i=0; $i < $total_pages; $i++) { ?>
                  <li <?php if(isset($_GET['page']) && $_GET['page'] == ($i + 1)){echo 'class="disabled"';} ?> style="cursor: pointer;">
                    <a <?php if(isset($_GET['page']) && $_GET['page'] == ($i + 1)){}else{?>href="<?= $cms_url.'my-blog?page='.($i + 1) ?>"<?php } ?>><?= $i + 1 ?></a>
                  </li>
                <?php } ?>
                </ul>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
        
      </div>
      
    </div>
  </div>
</div>
    <!-- start carousel -->
    <div class="jelly_homepage_builder jl_car_home jl_nonav_margin"> 
      
    </div>
    
  </div>
</div>

<div class="modal" id="del_conf_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[176] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="editor-error"></div>
              <p><?= $allLabelsArray[683] ?></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><i class="fa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i> <?= $allLabelsArray[40] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[41] ?></button>
            </div>
          </div>
        </div>
      </div>

<!-- end content --> 
<!-- Start footer -->
<?php include("community/includes/footer.php") ?>
<!-- End footer -->
<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include("community/includes/script.php") ?>
<script type="text/javascript">
  function deleteContent(id){
    var content_id = id; 
    $("#editor-error").attr("class","");
    $("#editor-error").text("");
    $("#del_conf_modal").modal();
    $("#del_conf_modal .btn-primary").click(function(){
      var sel = $(this);
      $.ajax({
        type: "POST",
        url: "<?= $cms_url ?>ajax.php?h=deleteContent&lang=<?= getCurLang($langURL,true); ?>",
        data:{id:content_id,table:"<?= $blog_table ?>"},
        dataType: "json",
        beforeSend: function(){
          sel.children("i").show();
        },success: function(res){
          sel.children("i").hide();
          console.log(res)
          if(res.success){
            window.location.reload();
          }else{
            $("#editor-error").attr("class","alert alert-danger");
            $("#editor-error").text("<?= $allLabelsArray[684] ?>");
          }
        },error: function(e){
          sel.children("i").hide();
          console.log(e);
        }
      });
    });
  }
</script>
</body>

</html>