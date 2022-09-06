<?php
require_once 'cms_error.php';

$basePath = 'community/';
include_once 'community/user_inc.php';
$page = 'inner';
if($news_table=='news_content_french')
{
    $news_table='news_content_francais';
}

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
        <meta name="description" content="<?= $allLabelsArray[779] ?>">
        <meta name="keywords" content="<?= $allLabelsArray[778] ?>">
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/news" />

        <?php

    }
    ?>


    <meta property="og:title" content="<?= $allLabelsArray[769] ?>" />
    <meta property="og:description" content="<?= $allLabelsArray[779] ?>" />
    <meta property="og:image" content="<?= ''  ?>" />
    <meta property="og:url" content="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>" />
<!-- Title-->
<title><?= $allLabelsArray[664] ?></title>
<!-- Favicon-->
<?php include("community/includes/style.php");?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- end head -->
<style type="text/css">
  .select2-selection__choice{
    background: #f4f4f4 !important;
  }
  .select2-selection__choice__display{
    color: #956D41 !important;
  }
  .select2-selection__choice__remove span{
    color: #db4a4a !important;
  }
  .multi-select{
      position: relative;
      height: 50px;
      border: 1px solid #92683E;
      border-radius: 5px;
      overflow: auto;
    }
    .multi-select .tag{
      float: left;
      margin-top: 9px;
      padding: 0 10px;
      background: red;
      margin-right: 10px;
      border-radius: 5px;
    }
    .multi-select .tag i,.multi-select .tag span{
      color: #fff;
    }
    #category-form ul{
    list-style: none;
    padding: 0;
  }
  #category-form li{
    padding: 10px;
    cursor: pointer;
    transition: all .30s;
  }
  #category-form i{
    margin-right: 10px;
  }
  #category-form li:hover{
    background: rgba(0,0,0,.1);
  }
  #category-form .active{
    background: rgba(0,0,0,.1);
    font-weight: bold;
  }
  #category-form .active i{
    color: green;
  }
  .tages_list{
    width: 100%;
  }
  .tages_list ul{
    width: 100%;
    text-align: center;
    list-style: none;
    display: inline-block;
    padding-left: 0;
    margin-bottom: 15px;
  }
  .tages_list ul li{
    border-radius: 4px;
    display: inline-block;
    background: #986e44;
    color: #fff;
    padding: 5px 10px;
    margin: 5px 0;
    cursor: pointer;
    font-size: 14px;
  }
  .tages_list ul .active:hover{
    background: red;
  }
  .tages_list ul li:hover{
    background: #6e441d;
  }
  .tages_list ul .active{
    background: red;
  }
    .search-content{
    position: relative;
    margin: 15px;
  }
  .search-content input{
    border: 1px solid #986e44;
    color: #986e44;
    margin-bottom: 15px;
    float: right;
    width: auto;
    padding-right: 30px;
  }

  .search-content input:focus{
    border: 1px solid #986e44;
    color: #986e44;
    margin-bottom: 15px;
  }
  .search-content i{
    position: absolute;
    right: 15px;
    bottom: 24px;
    color: #986e44;
  }
</style>
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_none_box_styles jl_border_radiuss">
  <div class="options_layout_container full_layout_enable_front"> 
    <!-- Start header -->
    <?php include("community/includes/header.php"); ?>
    <!-- end header -->
    <div class="jl_home_section jl_car_h5"> 
      <div class="container">
      <div class="row">
        <div class="col-md-12">
      <!-- start carousel -->
      <div class="jelly_homepage_builder jl_car_home jl_nonav_margin">
        <div class="homepage_builder_title">
          <h2> <?= $allLabelsArray[508] ?> </h2>
          <span class="jl_hsubt" style="margin-bottom: 30px;"><?= $allLabelsArray[505] ?></span> 
        </div>
        <div class="row search-content">
          <i class="fa fa-search"></i>
          <input type="search" class="form-control search_input" placeholder="<?= $allLabelsArray[802] ?>">
        </div>
        <div class="tages_list">
              <ul>
                <?php 
                $getCate = mysqli_query($conn,"SELECT *,title_french as title_francais FROM category_blog ORDER BY title");
                while($row = mysqli_fetch_assoc($getCate)){
                  $cate_title = empty(getCurLang($langURL,true)) ? '' : '_'.getCurLang($langURL,true);
                ?>
                <li data-id="<?= $row['id'] ?>"><?= $row['title'.$cate_title] ?></li>
                <?php } ?>
              </ul>
            </div>
        <h1 id="loder" align="center" style="display: none;"><?= $allLabelsArray[371] ?> <i class="fa fa-spin fa-spinner"></i></h1>
        <div id="load_list">
          <div class="jl_wrapper_row jl-post-block-108832">
            <h1 align="center" id="loder" style="display: none;"><?= $allLabelsArray[371] ?> <i class="fa fa-spin fa-spinner"></i></h1>
            <div id="load_list">
              <div class="row">
              <?php
                $query = "SELECT * FROM `".$news_table."` WHERE ";
                $page = 0;
                if(isset($_POST['page']) && $_POST['page'] > 0){
                  $page = $_POST['page'];
                }

                if(isset($_POST['value']) && count($_POST['value']) > 0){
                  $que = '';
                  for ($i=0; $i < count($_POST['value']); $i++) {
                    $que .= " FIND_IN_SET('".$_POST['value'][$i]."',category) && status = 1 ||";
                  }
                  $query .= substr($que, 0, -2)." ORDER BY id DESC";
                }else{
                  $query .= " status = 1 ORDER BY id DESC ";
                }

                if($page > 1){
                  $query .= ' LIMIT '.( 12 * ($page + 1)).',12 ';
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
          } ?>);"> <a href="<?= cleanURL('news/'.$row['slug']); ?>" class="link_image featured-thumbnail" title="">
            
          
            
        
        
            
            
          
                    <div class="background_over_image"></div>
                    </a> <span class="meta-category-small">
           
           
            </span> </div>
                  <div class="post-entry-content" >
                    <h3 class="image-post-title"><a class="text-doted" href="<?= cleanURL('news/'.$row['slug']); ?>" title="<?= $row['title'] ?>"><?php echo $row['title']; ?></a></h3>
                         
                    <span class="jl_post_meta"><span class="jl_author_img_w"><img src="<?php echo $cms_url ?>assets/img/favicon.jpg" width="30" height="30" alt="Anna Nikova" class="avatar avatar-30 wp-user-avatar wp-user-avatar-30 alignnone photo" /><a style="cursor:pointer" onclick="return false"  rel="author">
                      <?php
                      $query = "SELECT * FROM `users` WHERE id={$row['creator_id']}";
                      $fetch = mysqli_fetch_assoc(mysqli_query($conn, $query));
                     
                      if($row['created_by'] == 0) {
                          if($fetch['role'] == 0 && !empty($fetch)){
                           
                              ?><a href="<?= cleanURL('user/'.$fetch['id']) ?>"><?= $fetch['username'] ?></a><?php
                          }
                      }
                      else{
                        echo $allLabelsArray[283];
                      }
                     ?>
                     </a></span>
                     <span class="post-date w-100"><i class="fa fa-clock-o"></i><?php echo time_ago($row['created_at']); ?><br><span style="margin-left: 30px;">UTC-08:00</span></span></span>
                    
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
        </div>
      </div>


      <!-- end carousel --> 
          </div>
        </div>
        
  <div class="main_title_wrapper category_title_section jl_cat_img_bg" style="margin: 10px 0px 40px;">
        <div class="category_image_bg_image bgImage"></div>
        <div class="category_image_bg_ov"></div>
        <div class="jl_cat_title_wrapper">
          <div class="container">
            <div class="row">
              <div class="col-md-12 main_title_col">
                <div class="jl_cat_mid_title">
                  <h3 class="categories-title title" style="font-size: 26px;"><?= $allLabelsArray[506] ?></h3>
                  <a class="btn btn-md" href="<?= $cms_url ?>create-news<?= getCurLang($langURL) ?>" style="border-radius: 15px; background: #FE0000; color: white; display: inline-block; margin-top: 15px"><?= $allLabelsArray[507] ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
        
      </div>
    </div>
  </div>


  <!-- category -->
  <div class="modal" id="category-form" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #8c6238;">
              <h5 class="modal-title" style="color: #fff; text-align: center;"><?= $allLabelsArray[419] ?></h5>
              <button type="button" class="close" style="margin-top: -27px;" data-dismiss="modal" aria-label="Close" id="btn_close1">
                  <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <div id="category-error"></div>
              <ul>
                <?php
                $getCate = mysqli_query($conn,"SELECT * FROM category_blog");
            while($row = mysqli_fetch_assoc($getCate)){
                $list = explode(",", $getRow['category']); 
                ?>
                <li <?php if(in_array($row['title'], explode(',', $getRow['category']))){echo 'class="active"';} ?>><i class="fa fa-check-circle"></i> <span><?= $row['title'] ?></span></li>
                <?php } ?>
              </ul>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" style="background: #8c6238; border: 0;"><?= $allLabelsArray[452] ?></button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
      </div>
  </div>
  <form id="blog-form">
    <input type="hidden" hidden name="category">
  </form>
  <!-- end content --> 
  <!-- Start footer -->
  <?php include("community/includes/footer.php"); ?>
  <!-- End footer --> 
</div>
<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include("community/includes/script.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  
  function SelectCategory(){
    $(".multi-select .tag").each(function(){
      var getItem = $.trim($(this).children("span").text());
      $("#category-form li").each(function(){
        if($.trim($(this).children("span").text()) == getItem){
          $(this).attr("class","active");
        }
      });
    });
    $("#category-form").modal();
  }




  $(".search-content input").on("keyup",function(){
    var value = [];
    $(".tages_list .active").each(function(){
      value.push($(this).attr("data-id"));
    });
    var p = $(".active_page a").attr("path");
    $.ajax({
        type: "POST",
        url: "<?= $main_app ?>news_list.php?lang=<?= getCurLang($langURL,true) ?>",
        data: {value:value,page:p,q:$('.search-content input').val()},
        beforeSend: function(){
          $(".search-content i").attr("class","fa fa-spin fa-spinner");
        },
        success: function(res){
          $(".search-content i").attr("class","fa fa-search");
          $("#load_list").html(res);
        },error: function(e){
          $(".search-content i").attr("class","fa fa-search");
        }
      });
  })




  $(document).ready(function(){
    $(".pagination li:first").addClass("active_page");
    $(".tages_list li").click(function(){
    $(this).toggleClass("active");
    var value = [];
    $(".tages_list .active").each(function(){
      value.push($(this).attr("data-id"));
    });
    var sel = $(this);
    var txt = sel.text();
    var p = $(".active_page a").attr("path");
    $.ajax({
        type: "POST",
        url: "<?= $main_app ?>news_list.php?lang=<?= getCurLang($langURL,true) ?>",
        data: {value:value,page:p},
        beforeSend: function(){
          sel.html("<i class='fa fa-spin fa-spinner' style='margin-right: 5px;'></i> "+sel.text());
        },
        success: function(res){
          sel.html(txt);
          $("#load_list").html(res);
        },error: function(e){
          sel.html(txt);
        }
      });
    });

  });

  function page(sel,active){
    var sel = sel;

       // $(".ajax-pages li").removeClass("current_page");
      // sel.addClass("active_page");
      if(!sel.hasClass("active") && !sel.hasClass("disabled")){

      var value = [];
      $(".tages_list .active").each(function(){
        value.push($(this).attr("data-id"));
      });


      $.ajax({
        type: "POST",
        url: "<?= $main_app ?>news_list.php?lang=<?= str_replace('/', '', $langURL) ?>",
        data: {value:value,page:active},
        beforeSend: function(){
          sel.children("a").html("<i class='fa fa-spin fa-spinner' style='margin-right: 5px;'></i> ");
        },
        success: function(res){
          $("#load_list").html(res);
        },error: function(e){
        }
      });

      }

  }

  $('.js-example-basic-multiple').select2({
            placeholder: "<?= $allLabelsArray[373] ?>",
          });
  const slider = $(".slick-list");
  slider
    .slick({
      dots: true
    });//Implementing navigation of slides using mouse scroll
  slider.on('wheel', (function(e) {
    e.preventDefault();  if (e.originalEvent.deltaY < 0) {
      $(this).slick('slickNext');
    } else {
      $(this).slick('slickPrev');
    }
  }));

  function searchNews(value) {
    $.ajax({
      type: "POST",
      url: "<?= $main_app ?>news_list.php?lang=<?= str_replace('/', '', $langURL) ?>",
      data: {value:value},
      beforeSend: function(){
        $("#loder").show();
      },
      success: function(res){
        $("#loder").hide();
        $("#load_list").html(res);
      },error: function(e){
        $("#loder").hide();
      }
    });
   }
</script>
</body>

</html>