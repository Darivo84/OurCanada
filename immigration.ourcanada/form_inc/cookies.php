<?php

$requestBaseUrl = explode("/",$_SERVER['REQUEST_URI']);
$formID = 10;
if(strpos($requestBaseUrl[2],'?')!==false)
{
    $urlCheck=explode('?',$requestBaseUrl[2]);
    $requestBaseUrl[2]=$urlCheck[0];
}
$langType = $requestBaseUrl[2];
if($langType == '' || empty($langType)){
	$trans='';
	$langParam = '&Lang=english';
}else{
    if(is_numeric($langType))
    {
        $trans='';
	    $langParam = '&Lang=english';
    }
    else
    {
        if($langType == 'francais'){
            $trans = 'french';
            $langParam = '&Lang=french';
        }else{
            $trans = $langType;
            $langParam = '&Lang='.$langType;
        }
    }
}

$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


?>