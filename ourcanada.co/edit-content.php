<?php

require_once 'cms_error.php';

include_once( $basePath."user_inc.php" );
$page = 'inner';

$request = explode( "/", $_SERVER[ 'REQUEST_URI' ] );

$idd=0;
if(count($request) > 4){
    $blog_slug = $request[ 4 ];
    $id=$request[3];
}else{
    $blog_slug = $request[ 3 ];
    $page_url2 = explode('?', $blog_slug);
    $id=$page_url2[0];

}
$page_url = explode('?', $blog_slug);
$db_table = '';
;
if($page_url[1] == 'news'){
    $db_table = $news_table;
}else if($page_url[1] == 'blog'){
    $db_table = $blog_table;
}else{
    // echo 1;
    echo "<script>window.open('".$cms_url.getCurLang($langURL,true)."','_self');</script>";
}


if(empty(getCurLang($langURL,true)) || getCurLang($langURL,true) == 'english'){
$get_blog = mysqli_query($conn,"SELECT * FROM ".$db_table." WHERE slug = '".$id."' && creator_id = ".$_SESSION['user_id']);
}else{
$get_blog = mysqli_query($conn,"SELECT * FROM ".$db_table." WHERE id = '".explode('-', $id)[1]."' && creator_id = ".$_SESSION['user_id']);
}

$demoContent = $allLabelsArray[559];

if(mysqli_num_rows($get_blog) > 0){
	
	$getRow = mysqli_fetch_assoc($get_blog);

	$get_type = $getRow['type'];

	if($get_type == 'simplenews' || $get_type == 'simpleblog'){

        include_once 'simple-content.php';

    }else if($get_type == 'video-news' || $get_type == 'video-blog'){

        include_once 'video-content.php';

    }else if($get_type == 'image-slider-news' || $get_type == 'image-slider-blog'){

        include_once 'image-slider-content.php';

    }else if($get_type == 'video-image-news' || $get_type == 'video-image-blog'){

        include_once 'video-image-content.php';
    
    }
    else if($get_type == 'pdf-blog' || $get_type == 'pdf-news'){

        include_once 'pdf-content.php';
    
    }
}else{
    // echo 2;
    if($page_url[1] == 'news'){
        echo "<script>window.open('".cleanURL('my-news')."','_self');</script>";
    }else if($page_url[1] == 'blog'){
        echo "<script>window.open('".cleanURL('my-blogs')."','_self');</script>";
    }else{
        echo "<script>window.open('".$cms_url.getCurLang($langURL,true)."','_self');</script>";
    }
}

?>