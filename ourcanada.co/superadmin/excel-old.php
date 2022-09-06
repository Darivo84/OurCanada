<?php

include_once("../global.php");
require_once 'excelClass/PHPExcel.php';

ini_set('memory_limit', '3200M');

$file_name=$_GET['file'];
$questArr = array();
$currentDir = getcwd();

$objPHPExcel = new PHPExcel();
$objPHPExcelLoad = new PHPExcel();

// Load File to Compare

$objPHPExcelLoad = PHPExcel_IOFactory::load( '/var/www/html/ourcanada.app/superadmin/uploads/multi_lingual/'.$file_name );
$worksheetList = $objPHPExcelLoad->getSheetNames();

$objPHPExcelLoad->setActiveSheetIndex( 0 );
$excelData = $objPHPExcelLoad->getActiveSheet( 0 )->toArray();


$totRec = sizeof( $excelData );
$sheet = $objPHPExcelLoad->getSheet( 0 );
$highest_column = $sheet->getHighestColumn();


// File For downloading
$objPHPExcel->getDefaultStyle()->getFont()->setName( "Arial" )->setSize( 10 );
$objPHPExcel->getProperties()->setCreator( "Our Canada Questions" )
    ->setLastModifiedBy( "Form Questions" )
    ->setTitle( "Form Questions" )
    ->setSubject( "Form Questions" )
    ->setDescription( "Form Questions" )
    ->setKeywords( "" )
    ->setCategory( "Our Canada" );


$objPHPExcel->getActiveSheet()->getStyle( "A1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet()->getStyle( "A1" )->applyFromArray(
    array(
        "fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID,
            "color" => array( "rgb" => "000000" )
        )
    )
)->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );





$row_count2=2;
$row_count3=2;

$valTrans = '';

if($_GET['h'] == 'quest'){
	
	$mainQuestions = mysqli_query($conn , "SELECT question,id FROM questions WHERE form_id = '10' and question !=''");
	$subQuestions = mysqli_query($conn , "SELECT s.question,s.id FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10'");
	
	$arrQues = array();
	$arrQues2 = array();

	$quesFound = array();
	
	$objPHPExcel->setActiveSheetIndex(0)->setTitle('Questions');
	$row_count1=2;
	
    ///-----------------Questions---------------------
    $count=2;
    while($row = mysqli_fetch_assoc($mainQuestions))
    {
        $c=0;
        $ques=strtolower(rtrim($row['question']));
        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][0]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['question'])) == $tr){
                $c++;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
            }
        }

        if($c==0)
        {
            if(!in_array($row['question'],$arrQues))
                $arrQues[$row['id']]=$row['question'];

            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$row_count1, $row['question']);
            $row_count1++;

        }

    }

    while($row = mysqli_fetch_assoc($subQuestions)){
        $c=0;
        $ques=strtolower(rtrim($row['question']));
        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][0]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['question'])) == $tr){
                $c++;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr) {
                $c++;
            }
        }
        if($c==0)
        {
            if(!in_array($row['question'],$arrQues2)){
                $arrQues2[$row['id']]=$row['question'];
                $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$row_count1, $row['question']);
                $row_count1++;
            }

        }
    }
	
	$DownloadFileName = 'OurCanadaQuestions';
}
    ///-----------------Questions---------------------
else if($_GET['h'] == 'notes'){
	///-----------------notes---------------------
	
	$mainQuestions = mysqli_query($conn , "SELECT notes,id FROM questions WHERE form_id = '10' and notes !=''");
	$subQuestions = mysqli_query($conn , "SELECT s.notes,s.id FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10'");
	
	$arrQues = array();
	$arrQues2 = array();

	$quesFound = array();
    $qsCount=0;
	$objPHPExcel->setActiveSheetIndex(0)->setTitle('Notes');
    $count=2;
    while($row = mysqli_fetch_assoc($mainQuestions))
    {

        $c=0;
        $ques=strtolower(rtrim($row['notes']));
        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['notes'])) == $tr){
                $c++;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
            }
        }

        if($c==0)
        {
            if(checkValue($arrQues , 'notes' , $row['notes']) == true){

            }else{
                $arrQues[$qsCount]['notes'] = $row['notes'];
                $objPHPExcel->setActiveSheetIndex( 0)->setCellValue( "A".$row_count2, $row['notes']);
                $row_count2++;
                $qsCount++;
            }
//            if(!in_array($row['notes'],$arrQues))
//                $arrQues[$row['id']]=$row['notes'];
//            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$row_count2, $row['notes']);
//            $row_count2++;
        }

    }
	
    while($row = mysqli_fetch_assoc($subQuestions)){
        $c=0;
        $ques=strtolower(rtrim($row['notes']));
        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['notes'])) == $tr){
                $c++;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr) {
                $c++;
            }
        }
        if($c==0)
        {
            if(checkValue($arrQues , 'notes' , $row['notes']) == true){

            }else{
                $arrQues[$qsCount]['notes'] = $row['notes'];
                $objPHPExcel->setActiveSheetIndex( 0)->setCellValue( "A".$row_count2, $row['notes']);
                $row_count2++;
                $qsCount++;
            }
//            if(!in_array($row['notes'],$arrQues)){
//                $arrQues[$row['id']]=$row['notes'];
//
//                $objPHPExcel->setActiveSheetIndex( 0)->setCellValue( "A".$row_count2, $row['notes']);
//                $row_count2++;
//            }

        }
    }
    ///-----------------notes---------------------

	$DownloadFileName = 'OurCanadaNotes';
}
else{
	$objPHPExcel->setActiveSheetIndex(0)->setTitle('Options');

    ///-----------------options---------------------

    $count=2;
    $arrQues = array();
    $arrQues2 = array();

    $s=mysqli_query($conn,"select * from question_labels where value !=''");
    while($r=mysqli_fetch_assoc($s)) {

        $c = 0;
        $op=0;
        $ques = strtolower(rtrim(ltrim($r['label'])));

        $valTrans = '';
        for ($i = 1; $i <= $totRec - 1; $i++) {
            for ($k = 5; $k < 35; $k += 2) {
                $tr = strtolower(ltrim(rtrim($excelData[$i][$k])));
                if (preg_replace('!\s+!', '', $ques) == preg_replace('!\s+!', '', $tr)) {
                    $c++;
                }else if (preg_replace('!\s+!', '', $ques) == $tr) {
                    $c++;
                }else if (preg_replace('!\s+!', '', $tr) == $ques) {
                    $c++;
                }else if ($ques == $tr) {
                    $c++;
                }else if(rtrim(preg_replace('!\s+!', '', $r['label'])) == $excelData[$i][$k]){
                    $c++;
                }else if(rtrim($r['label']) == $excelData[$i][$k]){
                    $c++;
                }else if(ltrim(preg_replace('!\s+!', '', $r['label'])) == $excelData[$i][$k]){
                    $c++;
                }
                else if ($r['label'] == $excelData[$i][$k]) {
                    $c++;
                }
            }
        }
        if ($c == 0) {
            if (!in_array($r['label'], $arrQues))
            {
                $arrQues[$r['id']] = $r['label'];
                $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$row_count3, $r['label']);
                $row_count3++;

            }
        }
        else
        {
            if (!in_array($r['label'], $arrQues2))
            {
                $arrQues2[$r['id']] = $r['label'];

            }
        }
    }

//    $count=2;
//    $arrQues = array();
//    $arrQues2 = array();

    $s=mysqli_query($conn,"select * from level1 where value !=''");
    while($r=mysqli_fetch_assoc($s)) {

        $c = 0;
        $op=0;
        $ques = strtolower(rtrim(ltrim($r['label'])));
        $valTrans = '';
        for ($i = 1; $i <= $totRec - 1; $i++) {
            for ($k = 5; $k < 35; $k += 2) {
                $tr = strtolower(ltrim(rtrim($excelData[$i][$k])));
                if (preg_replace('!\s+!', '', $ques) == preg_replace('!\s+!', '', $tr)) {
                    $c++;
                } else if (preg_replace('!\s+!', '', $ques) == $tr) {
                    $c++;
                } else if (preg_replace('!\s+!', '', $tr) == $ques) {
                    $c++;
                }else if ($ques == $tr) {
                    $c++;
                }
                else if(rtrim(preg_replace('!\s+!', '', $r['label'])) == $excelData[$i][$k]){
                    $c++;
                }else if(rtrim($r['label']) == $excelData[$i][$k]){
                    $c++;
                }else if(ltrim(preg_replace('!\s+!', '', $r['label'])) == $excelData[$i][$k]){
                    $c++;
                }
                else if ($r['label'] == $excelData[$i][$k]) {
                    $c++;
                }
            }
        }
        if ($c == 0) {
            if (!in_array($r['label'], $arrQues))
            {
                $arrQues[$r['id']] = $r['label'];
                $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$row_count3, $r['label']);
                $row_count3++;
            }
        }
        else
        {
            if (!in_array($r['label'], $arrQues2))
            {
                $arrQues2[$r['id']] = $r['label'];

            }
        }
    }

//    print_r($arrQues);
//    die();
    ///-----------------options---------------------//
	
	$DownloadFileName = 'OurCanadaOptions';
}
function checkValue($array, $key, $val) {
    foreach ($array as $item)
        if (isset($item[$key]) && $item[$key] == $val)
            return true;
    return false;
}
$objPHPExcel->setActiveSheetIndex(0);
$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, "Excel2007" );
ob_end_clean();

header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
header( "Content-Disposition: attachment;filename=".$DownloadFileName.".xlsx" );

header( "Cache-Control: max-age=0" );

$objWriter->save('php://output');



exit;
?>