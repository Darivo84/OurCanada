<?php
include 'global.php';

require_once 'excelClass/PHPExcel.php';

$filePath = $_SERVER[ 'DOCUMENT_ROOT' ]."/superadmin/uploads/static_labels.xlsx";
$objPHPExcel = new PHPExcel();
$objPHPExcel = PHPExcel_IOFactory::load( $filePath );
$worksheetList = $objPHPExcel->getSheetNames();

$objPHPExcel->setActiveSheetIndex( 0 );
$excelData = $objPHPExcel->getActiveSheet( 0 )->toArray();

$totRec = sizeof( $excelData );
$sheet = $objPHPExcel->getSheet( 0 );
$highest_column = $sheet->getHighestColumn();
mysqli_set_charset('utf8',$conn);

for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    if($excelData[$i][0]=='')
    {
        continue;
    }
    $n['label']='';
    $n['label_spanish']='';
    $n['label_hindi']='';
    $n['label_punjabi']='';
    $n['label_french']='';
    $n['label_urdu']='';
    $n['label_chinese']='';
    if($excelData[$i][1]!='')
    {
        $n['label']=mysqli_real_escape_string($conn,$excelData[$i][1]);
    }
    else
    {
        $n['label']=mysqli_real_escape_string($conn,$excelData[$i][0]);
    }

    $select=mysqli_query($conn,"select * from static_labels where label='{$n['label']}'");


    $n['label_spanish']=mysqli_real_escape_string($conn,$excelData[$i][2]);
    $n['label_french']=mysqli_real_escape_string($conn,$excelData[$i][3]);
    $n['label_urdu']=mysqli_real_escape_string($conn,$excelData[$i][4]);
    $n['label_chinese']=mysqli_real_escape_string($conn,$excelData[$i][5]);
    $n['label_hindi']=mysqli_real_escape_string($conn,$excelData[$i][6]);
    $n['label_punjabi']=mysqli_real_escape_string($conn,$excelData[$i][7]);
    $T = db_pair_str2($n);

    if(mysqli_num_rows($select) > 0 )
    {
        $row=mysqli_fetch_assoc($select);
        $id=$row['id'];
//        $insert=mysqli_query($conn,"update static_labels set $T where id=$id");

    }
    else
    {
//        $insert=mysqli_query($conn,"insert into static_labels set $T");
    }
    if($insert)
    {
        echo 'success-'.$i.'<br>';
    }
    else
    {
        print_r(mysqli_error($conn));
    }

}
?>