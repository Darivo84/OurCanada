<?php
//echo phpinfo();
//die();

require 'global.php';
$s=mysqli_query($conn,"select * from user_form where id=1713");
$r=mysqli_fetch_assoc($s);
print_r(json_decode($r['localStorage']));
die();
$notes='यदि आपके पास सस्केचेवान द्वारा सत्यापित अपनी नौकरी की पेशकश थी, तो आप निवास के लिए सस्केचेवान द्वारा नामांकन की आवश्यकताओं को पूरा कर सकते हैं';
//
//$query=mysqli_query($conn,"update ocs.questions set notes_hindi='$notes' where id=154");
//if($query)
//{
//echo 'success';
//}
//else
//{
//    echo 'error';
//}
$label='Congratulations! Your professional account request has been approved. Please complete the signup process.';
$urdu='فارم جمع کروانے کا عمل جاری ہے۔';
$hindi='कुछ त्रुटि हुई। कृपया पुन: प्रयास करें।';
$punjabi='ਕੁਝ ਗਲਤੀ ਆਈ ਹੈ. ਮੁੜ ਕੋਸ਼ਿਸ ਕਰੋ ਜੀ.';
$spanish='Ocurrió algún error. Inténtalo de nuevo.';
$french="Une erreur s'est produite. Veuillez réessayer.";
$chinese='发生了一些错误。请再试一遍。';
//$query=mysqli_query($conn,"insert into ocs.static_labels (label,label_urdu,label_hindi,label_punjabi,label_chinese,label_spanish,label_french) values ('$label','$urdu','$hindi','$punjabi','$chinese','$spanish','$french')");
//$query=mysqli_query($conn,"update ocs.static_labels set label_french='$french' where id='323'");
//$s=mysqli_query($conn,"select * from ocs.questions where id=151");
//$r=mysqli_fetch_row($s);
mysqli_set_charset('utf8',$conn);
$french=mysqli_real_escape_string($conn,$french);
$spanish=mysqli_real_escape_string($conn,$spanish);

//$query=mysqli_query($conn,"update ocs.static_labels set label_french='$french',label_spanish='$spanish' where id=432");

//$query=mysqli_query($conn,"update ocs.static_labels set label_spanish='$spanish',label_french='$french',label_urdu='$urdu',label_chinese='$chinese',label_punjabi='$punjabi',label_hindi='$hindi' where id='434'");
//$query=mysqli_query($conn,"update ocs.static_labels set label_chinese='$chinese',label_punjabi='$punjabi',label_hindi='$hindi' where id='432'");

if($query)
{
echo 'success';
}
else
{
    echo mysqli_error($conn);
    echo 'error';
}

if ((((4==4 ))||(("3 years"=="2 years" || "3 years"=="3 years" || "3 years"=="4 years" || "3 years"=="5 years" ) ))&&((10>=4 ) && ( 10>=4 ) && ( 9>=4 ) && ( 9>=4 ) && ( "cad $500,001-$550,000"=="cad $350,001 - $400,000" || "cad $500,001-$550,000"=="cad $400,001 - $450,000" || "cad $500,001-$550,000"=="cad $450,001 - $500,000" || "cad $500,001-$550,000"=="cad $500,001-$550,000" || "cad $500,001-$550,000"=="cad $550,001- $600,000" || "cad $500,001-$550,000"=="cad $600,001-$650,000" || "cad $500,001-$550,000"=="cad $650,001-$700,000" || "cad $500,001-$550,000"=="cad $700,001-$750,000" || "cad $500,001-$550,000"=="cad $750,001-$800,000" || "cad $500,001-$550,000"=="cad $800,001 - $850,000" || "cad $500,001-$550,000"=="cad $850,001- $900,000" || "cad $500,001-$550,000"=="cad $900,001- $950,000" || "cad $500,001-$550,000"=="cad $950,001- $1,000,000" || "cad $500,001-$550,000"=="cad $1,000,001-$1,200,000" || "cad $500,001-$550,000"=="cad $1,200,001-$1,400,000" || "cad $500,001-$550,000"=="cad $1,400,001-$1,500,000" || "cad $500,001-$550,000"=="cad $1,500,001 - $1,999,999" || "cad $500,001-$550,000"=="cad $2,000,000- $2,499,999" || "cad $500,001-$550,000"=="cad $2,500,000- $4,999,999" || "cad $500,001-$550,000"=="cad $5,000,000 or above" ) && ( 0>=112 ) ))
{
    echo 11;
}
else
{
    echo 0;
}
?>