<?php
include_once("global.php");
//require_once ('compressor.php');
$baseURL = $cms_url;

$urlRediecrtion = preg_replace('~//+~', '/', $_SERVER['REQUEST_URI']);
if($_SERVER['REQUEST_URI'] !== $urlRediecrtion){
    header("Location:".$baseURL.$urlRediecrtion);
}
$getLangUrl = explode("/",$_SERVER['REQUEST_URI']);
$labelArray=array();
$labelTransArray=array();

$displayType = 'Left to Right';
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
    'change-password'
];
$language_code='';

// Checking language if user has open an inner page or if its home page with a different language
if(sizeof($getLangUrl) > 2){
    if(strpos($getLangUrl[3],'?')!==false)
    {
        $urlCheck=explode('?',$getLangUrl[3]);
        $getLangUrl[3]=$urlCheck[0];
    }
    $language = $getLangUrl[3];
    $langURL  = '/'.$language;
}else{
    if(strpos($getLangUrl[2],'?')!==false)
    {
        $urlCheck=explode('?',$getLangUrl[2]);
        $getLangUrl[2]=$urlCheck[0];
    }
    $language = $getLangUrl[2];
    $langURL  = '/'.$language;
}
if(sizeof($getLangUrl) > 4 && ($getLangUrl[2]=='edit-content' || $getLangUrl[2]=='blog' || $getLangUrl[2]=='news' ||  $getLangUrl[2]=='user')){
    $language = $getLangUrl[4];
    $langURL  = '/'.$language;
}
$baseURL = 'https://'.$_SERVER['HTTP_HOST'];


$checkError = false;
if(isset($_GET['lang']) && $_GET['lang']!=='' && $_GET['lang']!=='english')
{
    $language=$_GET['lang'];
    $langURL='/'.$language;

}
if(strpos($language,'?')!==false)
{
    $new_language=explode('?',$language);
    $language=$new_language[0];
    $langURL='/'.$language;

}
if($language=='francais')
{
    $language='french';
}
if(isset($language) && !empty($language)){
    // Check if Language exist in system other wise return a 404 page
    $columnName = 'label_'.$language;
    $checkLanguage = mysqli_query($conn , "SELECT * FROM `multi-lingual` WHERE lang_slug = '$language'");

    if(mysqli_num_rows($checkLanguage) > 0){
        $fetchLanguage = mysqli_fetch_assoc($checkLanguage);
        $displayType = $fetchLanguage['display_type'];
        $language_code=$fetchLanguage['language_code'];

//        $labels = mysqli_query( $conn, "select label,$columnName from static_labels" );
//        while ( $getLabels = mysqli_fetch_assoc( $labels ) ) {
//            $labelTransArray[] = $getLabels[ $columnName ];
//            $labelArray[]= $getLabels[ 'label' ];
//        }
    }else{
        $langURL='';
        foreach ($pages_array as $p)
        {

            if(strpos($language,$p)!==false)
            {
                $checkError = false;
                break;
            }
            else
            {
                $checkError = true;
            }
        }

    }
}else{
//    $labels = mysqli_query( $conn, "select label from static_labels" );
//    while ( $getLabels = mysqli_fetch_assoc( $labels ) ) {
//
//        $labelTransArray[] = $getLabels[ 'label' ];
//        $labelArray[]= $getLabels[ 'label' ];
//
//    }
    $langURL='';
}


$allLabelsArray=array();
$allLabelsEnglishArray=array();

$query = mysqli_query($conn,"SELECT * FROM `static_labels`");
while ($result = mysqli_fetch_assoc($query ))
{
    $allLabelsEnglishArray[$result['id']]=$result['label'];
    if(isset($language) && !empty($language))
    {
        if($result['label_'.$language]!=='' && $result['label_'.$language]!==null)
        {
            $allLabelsArray[$result['id']]=htmlspecialchars($result['label_'.$language], ENT_QUOTES);
        }
        else
        {
            $allLabelsArray[$result['id']]=$result['label'];

        }
    }
    else
    {
        $allLabelsArray[$result['id']]=$result['label'];

    }
}
if(isset($_SESSION['user_id'])){
    $user = mysqli_query($conn,"SELECT * FROM users WHERE id =".$_SESSION['user_id']);
    $get_user = mysqli_fetch_assoc($user);
}

$news_table = 'news_content';
$blog_table = 'blog_content';

$table_lang = str_replace(' ', '', $langURL);
$table_lang = str_replace('//', '', $table_lang);
$table_lang = str_replace('/', '', $table_lang);
if(!empty($table_lang)){
    $news_table = $news_table.'_'.$table_lang;
    $blog_table = $blog_table.'_'.$table_lang;
}

if(!function_exists('getCurLang')){
    function getCurLang($curLang = '',$onlyText = false){
        $lang = str_replace('//', '', $curLang);
        $lang = str_replace('/', '', $curLang);
        if(!$onlyText){
            return '/'.$lang;
        }else{
            return $lang;
        }
    }
}


if(!function_exists('cleanURL')){
    function cleanURL($path = ''){
        global $langURL;
        global $cms_url;

        $curlang = str_replace('/', '', getCurLang($langURL));
        $create_url = '';
        if(empty($path)){
            $create_url = $cms_url.$curlang;
        }else{
            if(substr($path, -1) == '/'){
                $create_url = $cms_url.$path.$curlang;
            }else{
                $create_url = $cms_url.$path.'/'.$curlang;
            }
        }    
        return rtrim($create_url,'/');
    }
}

if (!function_exists('time_ago')) {
    function time_ago($timestamp)
    {
        global $allLabelsArray;
        $time_ago = strtotime($timestamp.'+ 1 hour');
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);           // value 60 is seconds
        $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks = round($seconds / 604800);          // 7*24*60*60;
        $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
        if ($seconds <= 60) {
            return $allLabelsArray[753];
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "1 ".$allLabelsArray[754];
            } else {
                return "$minutes ".$allLabelsArray[755];
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "1 ".$allLabelsArray[756];
            } else {
                return "$hours ".$allLabelsArray[757];
            }
        } else if ($days <= 30) {
            if ($days == 1) {
                return "1 ".$allLabelsArray[758];
            } else {
                return "$days ".$allLabelsArray[759];
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "1 ".$allLabelsArray[760];
            } else {
                return "$months ".$allLabelsArray[761];
            }
        } else {
            if ($years == 1) {
                return "1 ".$allLabelsArray[762];
            } else {
                return "$years ".$allLabelsArray[763];
            }
        }
    }
}


if(!function_exists('get_pagination_links')){
    function get_pagination_links($current_page, $total_pages)
    {

        $firstPage = '';
        if($current_page == 1){
            $firstPage = 'class="active"';
        }

        $lastPage = '';
        if($current_page == $total_pages){
            $lastPage = 'class="active"';
        }

        $nextPageDisable = '';
        if($current_page == $total_pages){
            $nextPageDisable = 'class="disabled"';
        }

        $prevPageDisable = '';
        if($current_page == 1){
            $prevPageDisable = 'class="disabled"';
        }

        echo '<ul class="pagination">';
        $links = "<li ".$prevPageDisable." onclick=\"page($(this),".($current_page - 1).");\"><a href='javascript:void(0);'><</a></li>";
        if ($total_pages >= 1 && $current_page <= $total_pages) {
            $links .= "<li ".$firstPage." onclick=\"page($(this),1);\"><a path=\"1\" href='javascript:void(0);'>1</a></li>";
            $i = max(2, $current_page - 5);
            if ($i > 2)
                $links .= " <li><a href='javascript:void(0);'>...</a></li> ";
            for (; $i < min($current_page + 6, $total_pages); $i++) {

                $currentPageActive = '';
                if($i == $current_page){
                    $currentPageActive = 'class="active"';
                }

                $links .= "<li ".$currentPageActive." onclick=\"page($(this),{$i});\"><a path=\"{$i}\" href='javascript:void(0);'>{$i}</a></li>";
            }
            if($total_pages > 1){
                if ($i != $total_pages)
                    $links .= " <li><a href='javascript:void(0);'>...</a></li> ";
                    $links .= "<li ".$lastPage." onclick=\"page($(this),{$total_pages});\"><a path=\"{$total_pages}\" href='javascript:void(0);'>{$total_pages}</a></li>";
            }
        }
        $links .= "<li ".$nextPageDisable." onclick=\"page($(this),".($current_page + 1).");\"><a href='javascript:void(0);'>></a></li>";
        if($total_pages < 1){
            return '';
        }else{
            return $links.'</ul>';
        }
    }
}
mysqli_set_charset('utf8',$conn);
//$select = mysqli_query($conn, "select * from users where cookie='{$_COOKIE['PHPSESSID']}' and is_logged=1");
$select = mysqli_query($conn, "select * from user_sessions where session_id='{$_COOKIE['PHPSESSID']}' and is_logged=1");

if (mysqli_num_rows($select) > 0) {
    $row1 = mysqli_fetch_assoc($select);

    $select = mysqli_query($conn, "select * from users where id={$row1['user_id']}");
    $row = mysqli_fetch_assoc($select);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = 'user';

    $current_time=date('Y-m-d H:i:s');
    $last_login_time=date('Y-m-d H:i:s',strtotime($row['last_login_time']));
    $logged_in_time=strtotime($current_time)-strtotime($last_login_time);
//    if(($logged_in_time/60) > 180)
//    {
//        unset($_SESSION['user_id']);
//    }
} else {
    unset($_SESSION['user_id']);

//        session_unset();
//        session_destroy();
//        if($page != 'login.php'){
//          echo '<script>window.location.href = "'.$cms_url.'login";</script>';
//        }
}


if(!function_exists('displayTitle')){
    function displayTitle($title,$length = 20){
        global $langURL;
        if(empty(getCurLang($langURL,true))){
            if(strlen($title) > $length){
                return substr($title, 0,$length).'...';
            }else{
                return $title;
            }
        }else{
              if(mb_strlen($title,'UTF-8')>$length){
                  $content= str_replace('\n', '', mb_substr(strip_tags($title), 
                                        0, $length,'UTF-8'));
                  return $content.'…';
              }else{
                  return str_replace('\n', '', strip_tags($title));
              }
        }
    }
 }

if(!function_exists('getContentMedia')){
    function getContentMedia($media,$value,$is_thumbnail = false){

        global $cms_url;
        $file_path = '';
        
        if($media == 'image'){
            $path = str_replace($cms_url, '', $value);
            if(count(explode('uploads/gallery/', $path)) > 1){
                $file_path = $path;
            }else{
                if(count(explode('uploads/images/', $path)) > 1){
                  $file_path = $path;
                }else{
                  $file_path = "uploads/images/".$path;
                }
            }
        }

        if($media == 'image' && $is_thumbnail){
            $file_path = str_replace('uploads/images/', 'uploads/gallery/', $file_path);
        }

        if($media == 'video'){
            $path = str_replace($cms_url, '', $value);
            if(count(explode('uploads/gallery/', $path)) > 1){
                $file_path = $path;
            }else{
                if(count(explode('uploads/videos/', $path)) > 1){
                  $file_path = $path;
                }else{
                  $file_path = "uploads/videos/".$path;
                }
            }
        }

            return $cms_url.$file_path;
        // if($media == 'video'){
        // }else{
        //     $p = $cms_url.$file_path;
        //     $pp = explode('.', $p);
        //     $p_ext = $pp[count($pp)-1];
        //     return str_replace('.'.$p_ext, '.webp', $p);
        // }

    }
}

?>