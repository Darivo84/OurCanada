<?php
require_once("global.php");

$labels=array();
$query = mysqli_query($conn,"SELECT * FROM `static_labels`");
while ($result = mysqli_fetch_assoc($query ))
{

    $labels[$result['id']]['francais']=htmlspecialchars($result['label_french'], ENT_QUOTES);
    $labels[$result['id']]['spanish']=htmlspecialchars($result['label_spanish'], ENT_QUOTES);
    $labels[$result['id']]['urdu']=htmlspecialchars($result['label_urdu'], ENT_QUOTES);
    $labels[$result['id']]['punjabi']=htmlspecialchars($result['label_punjabi'], ENT_QUOTES);
    $labels[$result['id']]['hindi']=htmlspecialchars($result['label_hindi'], ENT_QUOTES);
    $labels[$result['id']]['chinese']=htmlspecialchars($result['label_chinese'], ENT_QUOTES);
    $labels[$result['id']]['arabic']=htmlspecialchars($result['label_arabic'], ENT_QUOTES);

    $labels[$result['id']]['english']=$result['label'];

}

?>