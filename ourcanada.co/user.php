<?php 
	require_once 'cms_error.php';
	include_once 'community/user_inc.php';

  $userProfile = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$userProfile = explode('/', $userProfile);
	$userProfileSegment = $userProfile[5];
	
  $notFound = false;
	if(count($userProfile) < 6){ $notFound = true; }
	if($userProfile[4] != 'user'){ $notFound = true; }
	$getUserProfile = mysqli_query($conn,"SELECT * FROM users WHERE id = {$userProfileSegment}");
	$userRow = mysqli_fetch_assoc($getUserProfile);

  if(mysqli_num_rows($getUserProfile) < 1){
    $notFound = true;
  }

$userPic = '';
if(empty($userRow['profileimg'])){
    $userPic = $default_profile;
}else{
    $userPic = $cms_url.'profiles/'.$userRow['profileimg'];
}
?>





<!DOCTYPE html>
<!--[if IE 9 ]>
<html class="ie ie9" lang="en-US">
   <![endif]-->
<html lang="en-US">

<head>
   <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="<?= $userRow['username'] ?>" />
    <meta property="og:description" content="<?= $userRow['description'] ?>" />
    <meta property="og:image" content="<?= $userPic ?>" />
   <!-- Title-->
   <title><?= $allLabelsArray[418] ?></title>
   <?php include("community/includes/style.php"); ?>
</head>

<body class="mobile_nav_class jl-has-sidebar">
   <div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
      <div class="options_layout_container full_layout_enable_front">
        <!-- Start header -->
		<?php include("community/includes/header.php") ?>
      <div class="main_title_wrapper">
        <div class="container">
          <div class="row">
            <div class="col-md-12 main_title_col">
              <div class="jl_cat_mid_title userProfile">
                <?php if(!$notFound){ ?>
                
                <div class="row">
                  <div class="col-sm-6 col-lg-4">

                    <div id="userLeftBlock">
					 	          <img alt="<?= $userRow['username'] ?>" src="<?= $userPic ?>">
					  
					            <p class="text-center"><b><?= $userRow['username'] ?></b></p>
                      <?php if(!empty($userRow['firstname'])){ ?>
                      <p><b style="font-size: 16px;"><?= $allLabelsArray[447] ?>: </b><?= $userRow['firstname'] ?></p>
                      <?php if(!empty($userRow['lastname'])){ ?>
                     	<p><b style="font-size: 16px;"><?= $allLabelsArray[448] ?>: </b><?= $userRow['lastname'] ?></p>
					             <?php } ?>
                     <?php } ?>
                    </div>
                 	  <br>
                    <?php if(!empty(str_replace(' ', '',$userRow['description']))){ ?>
                    <p>
                      <label><b><?= $allLabelsArray[451] ?>: </b></label> 
                      <span class="limited-content"><?= displayTitle($userRow['description'],330); ?></span>
                      <span class="full-content" style="display: none;"><?= $userRow['description'] ?></span>
                      <?php if(strlen($userRow['description']) > 330){ ?>
                      <a href="javascript:void(0);" class="show_more" onclick="toggleContent($(this));"><?= $allLabelsArray[730] ?></a>
                      <?php } ?>
                    </p>
                    <?php } ?>

                  </div>
        					 <div class="col-md-8 grid-sidebar" id="content">
                      <div class="jl_wrapper_cat UserBlogs">
                        <div id="content_masonry" class="pagination_infinite_style_cat ">
                            <div class="row" style="margin: 0;">
                              <button class="currentContent btn btn-warning getBlogs"><?= $allLabelsArray[590] ?></button>
                              <button class="currentContent btn btn-default getNews"><?= $allLabelsArray[416] ?></button>
                            </div>
                  					<hr>
                      
                            <div id="loadContent">
                              
                            </div>
                        </div>
                      </div>
                    </div>
                </div>
                <?php }else{ ?>
                  <h1 align="center"><?= $allLabelsArray[784] ?></h1>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
     
      <!-- end content -->
      <!-- Start footer -->
      <?php include("community/includes/footer.php"); ?>
         <!-- End footer -->
      </div>
   </div>
      <div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a>
   </div>

   <?php include("community/includes/script.php"); ?>


   <script type="text/javascript">

    function toggleContent(sel){
      if(sel.hasClass('show_more')){
        $(".limited-content").hide();
        $(".full-content").show();
        sel.attr("class","show_less");
        sel.text("<?= $allLabelsArray[795] ?>");
      }else{
        $(".limited-content").show();
        $(".full-content").hide();
        sel.attr("class","show_more");
        sel.text("<?= $allLabelsArray[730] ?>");
      }
    } 

     $(document).ready(function(){
      $.ajax({
        type: "POST",
        url: "<?php echo $main_domain ?>user_content.php?lang=<?= getCurLang($langURL,true) ?>",
        data:{
          user: <?= $userRow['id'] ?>
        },beforeSend: function(){
          $(".getBlogs").html('<i class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[417] ?>');
          $(".getBlogs").prop("disabled",true);
          $(".getNews").prop("disabled",true);
        },success: function(res){
          
          $(".getBlogs").html('<?= $allLabelsArray[590] ?>');
          $(".getNews").html('<?= $allLabelsArray[416] ?>');
          $(".getBlogs").prop("disabled",false);
          $(".getNews").prop("disabled",false);

          $("#loadContent").html(res);
        }
      });

      $(".getBlogs,.getNews").click(function(){
        var content = "";
        if($(this).hasClass("getBlogs")){
          content = "blog_content";
        }else{
          content = "news_content";
        }

        $.ajax({
          type: "POST",
          url: "<?php echo $main_domain ?>user_content.php?lang=<?= getCurLang($langURL,true) ?>",
          data:{
            user: <?= $userRow['id'] ?>,
            content: content
          },beforeSend: function(){
            if(content == 'blog_content'){
              $(".getBlogs").html('<i class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[590] ?>');
              $(".getBlogs").prop("disabled",true);
              $(".getNews").prop("disabled",true);
            }else{
              $(".getNews").html('<i class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[416] ?>');
              $(".getNews").prop("disabled",true);
              $(".getBlogs").prop("disabled",true);
            }
          },success: function(res){
            if(content == "blog_content"){
              if(!$(".getBlogs").hasClass("btn-warning")){
                $(".getBlogs").addClass("btn-warning");
              }
              $(".getNews").removeClass("btn-warning");
            }else{
              if(!$(".getNews").hasClass("btn-warning")){
                $(".getNews").addClass("btn-warning");
              }
              $(".getBlogs").removeClass("btn-warning");
            }
            $(".getBlogs").html('<?= $allLabelsArray[590] ?>');
            $(".getNews").html('<?= $allLabelsArray[416] ?>');
            $(".getBlogs").prop("disabled",false);
            $(".getNews").prop("disabled",false);

            $("#loadContent").html(res);
          }
        });

      });

     });

    function page(sel,active = ''){
      var content = "";
      if($(".currentContent.btn-warning").hasClass("getBlogs")){
        content = "blog_content";
      }else{
        content = "news_content";
      }

      if(!sel.hasClass("active") && !sel.hasClass("disabled")){
        $.ajax({
          type: "POST",
          url: "<?php echo $main_domain ?>user_content.php?lang=<?= getCurLang($langURL,true); ?>",
          data:{
            user: <?= $userRow['id'] ?>,
            page: active,
            content: content,
            lang: "<?= getCurLang($langURL,true) ?>"
          },beforeSend: function(){
            sel.children('a').html('<i class="fa fa-spin fa-spinner"></i>');
            if(content == "blog_content"){
              $(".getBlogs").html('<i class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[590] ?>');
              $(".getBlogs").prop("disabled",true);
              $(".getNews").prop("disabled",true);
            }else{
              $(".getNews").html('<i class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[416] ?>');
              $(".getNews").prop("disabled",true);
              $(".getBlogs").prop("disabled",true);
            }

          },success: function(res){

            $(".getBlogs").html('<?= $allLabelsArray[590] ?>');
            $(".getNews").html('<?= $allLabelsArray[416] ?>');
            $(".getBlogs").prop("disabled",false);
            $(".getNews").prop("disabled",false);

            $("#loadContent").html(res);
          }
        });
      }
    }
   </script>

</body>

</html>