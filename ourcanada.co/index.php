<?php

require_once ("user_inc.php");

$page = 'home';
$u = explode('?fbclid', $_SERVER['REQUEST_URI']);
$getURL = explode("/",$u[0]);
$langURL = $getURL[2];

$basePath = 'community/';

$currentTheme = "https://ourcanada.co/community";
$cms_url = $currentTheme.'/';
if($getURL[1] == 'community')
{
	if($langURL == 'francais'){
		$langURL = 'french';
	}
	$checkLang = mysqli_query($conn , "SELECT * FROM `multi-lingual` where lang_slug = '{$langURL}'");
	if(mysqli_num_rows($checkLang) > 0){
		$setPage = true;
		require_once "cms_index.php";
		exit();
	}else{
		$setPage = true;
		$langUrlPar = explode("?",$langURL);
		if($langUrlPar[1] !== ''){
			$langURL = $langUrlPar[0];
		}
		if($getURL['2'] == 'blog'){
            if(isset($getURL[4])){
                $data_id = explode('-', $getURL['3'])[1];
                $blog_select = mysqli_query( $conn, "SELECT * FROM `".$blog_table."` WHERE id='{$data_id}'" );
            }else{
    			$blog_select = mysqli_query( $conn, "SELECT * FROM `".$blog_table."` WHERE slug='{$getURL['3']}'" );
            }
            $blog_content = mysqli_fetch_assoc( $blog_select );
            // $id = $blog_content[ 'id' ];
            // if ( $id == null ) {
            //     header( "Location:" . $cms_url . "blogs/".$getURL[4] );
            // }
			if(mysqli_num_rows($blog_select) > 0){
                require_once "blog-details.php";
				
			}
            else{
                header( "Location:" . $cms_url . "blogs/".$getURL[4] );
            }
		}else if($getURL['2'] == 'news'){
            $data_id = explode('-', $getURL[3])[1];
            $lngChk=$getURL[3]=='francais'?'french':$getURL[3];
            $check_lang=mysqli_query($conn,"select * from `multi-lingual` where lang_slug='$lngChk'");
            if(sizeof($getURL)>=4 && $getURL[3]!=='' && (is_numeric($getURL[3]) || mysqli_num_rows($check_lang) < 1))
            {
                require_once "news-details.php";
            }
            else
            {
                require_once $langURL.".php";
            }

        } else if($getURL['2'] == 'edit-content'){
		    $otherLang=false;
		    if(sizeof($getURL)>4)
            {
                $slug=$getURL['3'];
                $otherLang=true;

            }
		    else
            {
                $slug=explode('?',$getURL['3']);

            }

		    if($otherLang)
            {
                $new_slug=explode('-',$slug);
                $slug[0]=$slug[1];
            }

            $c_lang = "";
            if(count($slug) > 1){

            }else{
                $c_lang = '_'.explode('?', $getURL[4])[0];
            }

            if($slug[1]=='blog')
            {
                $blog_select = mysqli_query( $conn, "SELECT * FROM `".$blog_table.$c_lang."` WHERE id='{$slug[0]}'" );
                if(mysqli_num_rows($blog_select) > 0){
                   require_once "edit-content.php";
                }
                else
                {
                    // echo "222";
                    require_once str_replace('.php', '', $langURL).".php";
                }

            }
		    else
            {

                $blog_select = mysqli_query( $conn, "SELECT * FROM `".$news_table.$c_lang."` WHERE id='{$slug[0]}'" );
                if(mysqli_num_rows($blog_select) > 0){
                
                    require_once "edit-content.php";
                }
                else
                {
                   
                    require_once $langURL.".php";
                }
            }

        }else{
            $pages_array=[
                'my-blog',
                'blogs',
                'my-news',
                'news',
                'create-blog',
                'profile',
                'login',
                'forgot-password',
                'verify',
                'change-password',
                'user',
                'register',
                'blog',
                'create-news'
            ];
            $checkLanguage = mysqli_query($conn , "SELECT * FROM `multi-lingual` WHERE lang_slug = '$langURL'");

            if(array_search($langURL,$pages_array) > -1 || mysqli_num_rows($checkLanguage) > 0)
            {
                require_once $langURL.".php";

            }
            else
            {
				
                require_once 'community/includes/style.php';
//                require_once 'community/includes/header.php';
                require_once "community/404.php";
                require_once 'community/includes/scripts.php';
                require_once 'community/includes/footer.php';


                $checkError = true;
            }
		}
		
		

		exit();
	}
}else{
	
}

unset($_SESSION['onetime']);
?>
<!DOCTYPE html>
<html lang="en">



<head>
   
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <?php if($environment == true){ ?>
        <title><?php echo $allLabelsArray[284]; ?></title>
        <meta name="author" content="<?php echo $allLabelsArray[283]; ?>">
        <meta name="keywords" content="<?php echo $allLabelsArray[285]; ?>">
        <meta name="description" content="<?php echo $allLabelsArray[286]; ?>" />

    <?php } else { ?>
        <title><?php echo $allLabelsEnglishArray[284] ?></title>
    <?php } ?>

	




    <?php include("includes/style.php") ?>
</head>

<body id="home">


<?php include("includes/header.php");

if($checkError !== true){
?>


    <section class="banner-section" >
    <div class="container-fluid container-extra">
        <div class="row">
            <div class="col-lg-7 col-md-8">
                <div class="banner-text">

                    <h1 class="banner-promo wow slideInLeft static_label" data-wow-delay=".3s" data-org="<?php echo $allLabelsEnglishArray[105] ?>"><?php echo $allLabelsArray[105] ?></h1>

              
					<p class="wow slideInLeft static_label" data-wow-delay=".4s" data-org="<?php echo $allLabelsEnglishArray[106] ?>"><?php echo $allLabelsArray[106] ?></p>
                    <?php
                    if(isset($_SESSION['user_id']))
                    {
                        ?>
                        <a href="https://immigration.ourcanada<?php echo $ext; ?>/form<?php echo $newLangUrl; ?>" id="getStarted" class="static_label" data-org="<?php echo $allLabelsEnglishArray[245] ?>" target="_blank" style="text-decoration: underline"><?php echo $allLabelsArray[245] ?></a>
                        <?php
                    }
                    else {
                        ?>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModal"  id="getStarted" class="static_label" data-org="<?php echo $allLabelsEnglishArray[245] ?>" target="_blank" style="text-decoration: underline"><?php echo $allLabelsArray[245] ?></a>

                    <?php } ?>

                </div>
            </div>
            <div class="col-md-4 col-lg-5">
               <div class="banner-img">
                   <img  src="assets/img/hands-waving-flags-canada.jpg" alt="Our canada">
               </div>
            </div>
        </div>
    </div>
     <div id="bannerImgOverlay">
        <img  src="assets/img/ourcanada.png" alt="OurCanada.app">
    </div>
    

</section>


<?php } else {

    include("404.php");
    exit();
    ?>


<?php } include("includes/footer.php") ?>

<?php include("includes/script.php") ?>

</body>

</html>