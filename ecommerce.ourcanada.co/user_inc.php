<?php

include_once("global.php");

$urlRediecrtion = preg_replace('~//+~', '/', $_SERVER['REQUEST_URI']);
if($_SERVER['REQUEST_URI'] !== $urlRediecrtion){
    header("Location:".$urlRediecrtion);
}
$getLangUrl = explode("/",$_SERVER['REQUEST_URI']);
$labelArray=array();
$labelTransArray=array();

$displayType = 'Left to Right';
$pages_array=['travel'];

// Checking language if user has open an inner page or if its home page with a different language
if(isset($getLangUrl[2])){
    if(strpos($getLangUrl[2],'?')!==false)
    {
        $urlCheck=explode('?',$getLangUrl[2]);
        $getLangUrl[2]=$urlCheck[0];
    }
    if(is_numeric($getLangUrl[2]))
    {
        $pagee = $getLangUrl[2];
        $language = $getLangUrl[1];
        // This line was added for pagination urls for e commerce
        $langParam = explode("?",$language);
        $language = $langParam[0];
        $langURL  = '/'.$language;
    }
    else
    {
        $language = $getLangUrl[2];
        // This line was added for pagination urls for e commerce
        $langParam = explode("?",$language);
        $language = $langParam[0];
        $langURL  = '/'.$language;
    }


}
else{
    if(strpos($getLangUrl[1],'?')!==false)
    {
        $urlCheck=explode('?',$getLangUrl[1]);
        $getLangUrl[1]=$urlCheck[0];
    }
    if(is_numeric($getLangUrl[1]))
    {
        $pagee = $getLangUrl[1];
        $language = "";
        $langURL  = '/'.$language;
    }
    else
    {
        $language = $getLangUrl[1];
        // This line was added for pagination urls for e commerce
        $langParam = explode("?",$language);
        $language = $langParam[0];
        $langURL  = '/'.$language;
    }

}


$checkError = false;

if($language=='francais')
{
    $language='french';
}

if(isset($language) && !empty($language)){
    // Check if Language exist in system other wise return a 404 page
    $columnName = 'label_'.$language;
    $checkLanguage = mysqli_query($conn , "SELECT * FROM `multi-lingual` WHERE lang_slug = '$language'");
    $checkRows=mysqli_num_rows($checkLanguage);
    if($checkRows > 0){
        $fetchLanguage = mysqli_fetch_assoc($checkLanguage);
        $displayType = $fetchLanguage['display_type'];

    }else{
        $index = array_search($language, $pages_array);
        if( $index > -1 )
        {
            $checkError = false;
        }
        else
        {
            $checkError = true;
        }
    }
}else{
//    $checkError = true;

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
//            $allLabelsArray[$result['id']]=addslashes($result['label_'.$language]);//str_replace("'","\'",$result['label_'.$language]);
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
?>