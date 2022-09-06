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
echo 'total Records: '.$totRec;
for ( $i = 1; $i <= $totRec - 1; $i++ ) {

    echo $excelData[$i][0].'<br>';
    $n['label']=$excelData[$i][0];

    if($n['label']=='')
    {
        continue;
    }

    $select=mysqli_query($conn,"select * from static_labels where label='{$n['label']}'");

    $T = db_pair_str2($n);

    if(mysqli_num_rows($select) > 0 )
    {
        echo 'exists => '.$n['label'];
continue;

    }
    else
    {
       $insert=mysqli_query($conn,"insert into static_labels set $T");
        if($insert)
        {
            echo 'success-'.$i.'<br>';
        }
        else
        {
            print_r(mysqli_error($conn));
        }
    }


}
?>