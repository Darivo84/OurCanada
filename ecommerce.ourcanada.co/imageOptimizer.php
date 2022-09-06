<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$fileList = glob('assets/p_images/*');
foreach($fileList as $filename) {
    if (is_file($filename)) {
//        echo $filename, '<br>';
        $f_name=explode('/',$filename);
        imageOptimizer($filename,$f_name[2]);
        //delete($filename,$f_name[2]);
    }
}
function delete($path,$f)
{
    $f_name=explode('.',$f);
    $path='/var/www/html/ecommerce.ourcanada.co/'.$path;
    $final_file_name='/var/www/html/ecommerce.ourcanada.co/assets/p_images/'.$f_name[0].'.webp';
    $del=unlink($final_file_name);
    echo $del;

}
    function imageOptimizer($path,$f)
{
    $quality=70;
    global $base_dir,$base_url;
    $f_name=explode('.',$f);
    $path='/var/www/html/ecommerce.ourcanada.co/'.$path;
    $final_file_name='/var/www/html/ecommerce.ourcanada.co/assets/p_images/'.$f_name[0].'.webp';

    $source_url=$destination_url=urldecode($path);
    $originalSize=filesize($source_url);
    //echo "not working"; exit();
    $info = getimagesize($source_url);
    $fileName=basename($source_url);
//    echo $source_url;
//        echo $originalSize;
//
//			print_r($info);
//			echo '<br><br>';
//        exit();
    if ($info['mime'] == 'image/jpeg')
    {
        if($originalSize/1024 > 100)
        {
            $image = imagecreatefromjpeg($source_url);
            imagejpeg($image, $destination_url, $quality);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
            imagedestroy($image);
        }
        $image = imagecreatefromjpeg($source_url);
        ob_start();
        imagejpeg($image, null, $quality);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
        $cont=  ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        $content =  imagecreatefromstring($cont);
        imagewebp($content,$final_file_name);
        imagedestroy($destination_url);
    }elseif ($info['mime'] == 'image/png')
    {
        if($originalSize/1024 > 100)
        {
            $image = imagecreatefrompng($source_url);
            imagepng($image, $destination_url, 9);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
            imagedestroy($image);
        }
        $image = imagecreatefrompng($source_url);
        ob_start();
        imagepng($image, null, 9);//ranges from 0 (worst quality, smaller file) to 100 (best quality, biggest file). The default is the default IJG quality value (about 75).
        $cont=  ob_get_contents();
        ob_end_clean();
        imagedestroy($image);
        $content =  imagecreatefromstring($cont);
        imagewebp($content,$final_file_name);
        imagedestroy($destination_url);

    }

    //return destination file
    if(file_exists($destination_url))
    {
        clearstatcache();
        $reduceSize=filesize($destination_url);
        $reduced=(100-($reduceSize/$originalSize*100));
        $reduced=number_format($reduced, 2, '.', '');
        $info=array("error"=>0,"originalFile"=>$path,"destinationFile"=>str_replace($base_dir,"",$destination_url),"originalSize"=>human_filesize($originalSize),"reduceSize"=>human_filesize($reduceSize),"reduced"=>$reduced,"name"=>$fileName);
    }else
    {
        $info=array("error"=>1,"system failed to optimize file!");
    }

   echo json_encode($info).'<br>';
    // exit;
}
function human_filesize($bytes, $decimals = 2) {
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}
?>