<?php
require_once 'cms_error.php';

include_once $basePath.'user_inc.php';
include_once $basePath.'admin_inc.php';
$_GET['type'] = 'News';
$blog_select = mysqli_query( $conn, "SELECT * FROM `content-uploads` Order By id DESC" );

$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

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
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/create-news" />

        <?php
    }
    ?>
    
<!-- Title-->
<title><?= $allLabelsArray[420] ?></title>
<!-- Favicon-->
<?php include($basePath."includes/style.php"); ?>
<link rel="stylesheet" type="text/css" href=<?php echo $basePath ?>"assets/dropzone/dropzone.min.css">
<!-- end head -->
<style type="text/css">
.modal-header .close{
  margin-top: unset !important;
}
  .count-facebook:hover .fa{
    color: red !important;
  }
  .count-facebook:hover .label{
    color: red !important;
  }
   .social-count-plus .default li{
      width: 20% !important;
    }
   @media only screen and (max-width: 860px) {
    .social-count-plus .default li{
      width: 50% !important;
    }
  }

  @media only screen and (max-width: 470px) {
    .social-count-plus .default li{
      width: 100% !important;
    }
  }
</style>
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_none_box_styles jl_border_radiuss">
  <div class="options_layout_container full_layout_enable_front"> 
    <!-- Start header -->
    <?php include($basePath."includes/header.php"); ?>
    <!-- end header -->
    
    <div class="col-sm-12">
        <h3 class="blogType"><?= $allLabelsArray[721] ?></h3>
      <div id="socialcountplus-2" class="widget widget_socialcountplus">
      <div class="social-count-plus">
        <ul class="default">
        <li class="count-facebook" onClick="changeType('simpleblog')">
          <a class="icon" ><i class="fa fa-file"></i></a><span class="items"><span class="label"><?= $allLabelsArray[422] ?></span></span>
        </li>
        <li class="count-facebook" onClick="changeType('pdf-blog')">
          <a class="icon" ><i class="fa fa-file"></i></a><span class="items"><span class="label"><?= $allLabelsArray[813] ?></span></span>
        </li>
        <li class="count-facebook" onClick="changeType('video-blog')">
          <a class="icon" ><i class="fa fa-youtube"></i></a><span class="items"><span class="label"><?= $allLabelsArray[712] ?></span></span>
        </li>
        <li class="count-facebook" onClick="changeType('image-slider-blog')">
          <a class="icon" ><i class="fa fa-image"></i></a><span class="items"><span class="label"><?= $allLabelsArray[713] ?></span></span>
        </li>
        <li class="count-facebook" onClick="changeType('video-image-blog')">
          <a class="icon" ><i class="fa fa-images"></i></a><span class="items"><span class="label"><?= $allLabelsArray[714]  ?></span></span>
        </li>

        </ul>
      </div>
      </div>
    </div> 
    
      <div class="container">
      <div class="row">
        <div id="to_be_changed" class="col-sm-12" style="height: auto; margin-top: 10px;">
        
      </div>  
        
      </div>
    </div>
      <!--div class="col-sm-2 col-sm-offset-2" style="height: auto;">
        <div style="width: 78%;  margin-left: 11%;">
          <select class="form-control" style="margin-top: 10px; margin-bottom: 10px;" onchange="change_content($(this).val());">
            <option>Select Blog Type</option>
            <option value="simpleblog">Simple Blog</option>
            <option value="video-blog">Blog with Video</option>
            <option value="image-slider-blog">Blog with Image Slider</option>
            <option value="video-image-blog">Blog with Image/Video</option>
          </select>
        </div>
      </div>-->
    </div>
  </div>
  <!-- end content --> 
  <!-- Start footer -->
  <?php include($basePath."includes/footer.php"); ?>
  <!-- End footer --> 
</div>
<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>

<input type="hidden" name="getType" hidden value="news">
<?php include($basePath."includes/script.php"); ?>
<script src="https://cdn.tiny.cloud/1/lm5vtl04eubl3jl24ookla4j0mmxhoa1nq5iwnfq0cd9lujb/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src=<?php echo $basePath ?>"assets/dropzone/dropzone.min.js"></script>
<script>

  // function content_one(value){
  //   $('#content_one_changer').modal();
  //   var content_one = value;
  //   $('#modal_content_one').val(content_one);
  // }
  

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

  function changeType(val){
    if(val == "simpleblog"){
      $('#to_be_changed').load('<?php echo $main_domain ?>simpleblog.php?content_type=<?= $_GET['type'].'&lang='.getCurLang($langURL,true) ?>')
    } else if(val == "video-blog"){
     $('#to_be_changed').load('<?php echo $main_domain ?>videoblog.php?content_type=<?= $_GET['type'].'&lang='.getCurLang($langURL,true) ?>')
    } else if(val == "image-slider-blog"){
      $('#to_be_changed').load('<?php echo $main_domain ?>imagesliderblog.php?content_type=<?= $_GET['type'].'&lang='.getCurLang($langURL,true) ?>')
    } else if(val == "video-image-blog"){
      $('#to_be_changed').load('<?php echo $main_domain ?>imgvidblog.php?content_type=<?= $_GET['type'].'&lang='.getCurLang($langURL,true) ?>')
    } else if(val == "pdf-blog"){
      $('#to_be_changed').load('<?php echo $main_domain ?>pdf_blog.php?content_type=<?= $_GET['type'].'&lang='.getCurLang($langURL,true) ?>')
    }
  }

  $(".count-facebook").click(function(){
    $(".blogType").text("<?= $allLabelsArray[710] ?>");

    $(".count-facebook .fa").css("color","#45629f");
    $(".count-facebook .label").css("color","#000");

    $(this).find(".fa").css("color","red");
    $(this).find(".label").css("color","red");
    
  });

</script>
</body>

</html>