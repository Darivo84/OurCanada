<?php

include_once("../global.php");
require_once 'excelClass/PHPExcel.php';

ini_set('memory_limit', '3200M');
ini_set('max_execution_time', 500000);


$file_name=$_GET['file'];
$questArr = array();
$currentDir = getcwd();

$objPHPExcel = new PHPExcel();
$objPHPExcelLoad = new PHPExcel();

// Load File to Compare



//$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();


// File For downloading
$objPHPExcel->getDefaultStyle()->getFont()->setName( "Arial" )->setSize( 10 );
$objPHPExcel->getProperties()->setCreator( "Our Canada Questions" )
    ->setLastModifiedBy( "Form Questions" )
    ->setTitle( "Form Questions" )
    ->setSubject( "Form Questions" )
    ->setDescription( "Form Questions" )
    ->setKeywords( "" )
    ->setCategory( "Our Canada" );




for($i = 0 ; $i <= 6 ; $i++){
    $objPHPExcel->getActiveSheet($i)->getStyle( "A1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
    $objPHPExcel->getActiveSheet($i)->getStyle( "A1" )->applyFromArray(
        array(
            "fill" => array(
                "type" => PHPExcel_Style_Fill::FILL_SOLID,
                "color" => array( "rgb" => "000000" )
            )
        )
    )->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );

    $objPHPExcel->getActiveSheet($i)->getStyle( "B1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
    $objPHPExcel->getActiveSheet($i)->getStyle( "B1" )->applyFromArray(
        array(
            "fill" => array(
                "type" => PHPExcel_Style_Fill::FILL_SOLID,
                "color" => array( "rgb" => "000000" )
            )
        )
    )->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );

    $objPHPExcel->setActiveSheetIndex( $i )->setCellValue( "A1", "Orignal");
    $objPHPExcel->setActiveSheetIndex( $i )->setCellValue( "B1", "Translation");
}
$objPHPExcel->getActiveSheet(5)->getStyle( "C1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet(5)->getStyle( "C1" )->applyFromArray(
    array(
        "fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID,
            "color" => array( "rgb" => "000000" )
        )
    )
)->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );

$objPHPExcel->getActiveSheet(5)->getStyle( "D1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
$objPHPExcel->getActiveSheet(5)->getStyle( "D1" )->applyFromArray(
    array(
        "fill" => array(
            "type" => PHPExcel_Style_Fill::FILL_SOLID,
            "color" => array( "rgb" => "000000" )
        )
    )
)->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );
$lang='';
if($_GET['file']){

    $lang=$_GET['file'];
    if($lang=='francais')
    {
        $lang='french';
    }
    // Load Main Question and Sub Questions
    $mainQuestions = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '10' and question !=''");
    $subQuestions = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' and s.question != ''");
    $subQuestions2 = mysqli_query($conn , "SELECT * FROM sub_questions where question_id='51'");

    $quesArray = $subArray = array();
    $quesFound = array();

    $objPHPExcel->setActiveSheetIndex(0)->setTitle('Questions');

    $rCount = 2; $count = 2;

    while($row = mysqli_fetch_assoc($mainQuestions)){

        $c=0;
        $match = 0;

        if(!in_array($row['question'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$rCount, $row['question']);
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "B".$rCount, $row['question_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['question'];
            $rCount++;
        }



    }

    while($row = mysqli_fetch_assoc($subQuestions)){

        if($row['grade']==1)
        {
            continue;
        }
        if(!in_array($row['question'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$rCount, $row['question']);
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "B".$rCount, $row['question_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['question'];
            $rCount++;
        }

    }
    while($row = mysqli_fetch_assoc($subQuestions2)){

        if($row['grade']==1)
        {
            continue;
        }
        if(!in_array($row['question'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$rCount, $row['question']);
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "B".$rCount, $row['question_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['question'];
            $rCount++;
        }

    }
    // Notes

    $objPHPExcel->setActiveSheetIndex(1)->setTitle('Notes');
    $mainQuestions = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '10' and notes !=''");
    $subQuestions = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' and s.notes != ''");

    $scoringNotes = mysqli_query($conn , "select * from score_questions WHERE comments != ''");
    $scoringNotes2 = mysqli_query($conn , "select * from score_questions2 WHERE comments != ''");

    $quesArray = $subArray = array();
    $quesFound = array();

    $rCount = 2; $count = 2;


    while($row = mysqli_fetch_assoc($mainQuestions)){

        if(!in_array($row['notes'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['notes']);

            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $row['notes_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['notes'];
            $rCount++;
        }

    }

    while($row = mysqli_fetch_assoc($subQuestions)){
        if(!in_array($row['notes'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['notes']);

            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $row['notes_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['notes'];
            $rCount++;
        }
    }

    while($row = mysqli_fetch_assoc($scoringNotes)){
        $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['comments']);

        $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $row['comments_'.$lang]);
        $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "C".$rCount, 0);

        $rCount++;

    }


    /************** Options ***************/


    $objPHPExcel->setActiveSheetIndex(2)->setTitle('Options');
    $quesArray = $subArray = array();
    $quesFound = array();

    $rCount = 2; $count = 2;

    $option = mysqli_query($conn,"select l.* from ocs.question_labels as l join ocs.questions as q on q.id=l.question_id where l.value !='' and q.form_id=10");
    while($row = mysqli_fetch_assoc($option)){

        if(!in_array($row['label'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "A".$rCount, $row['label']);
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "B".$rCount, $row['label_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['label'];
            $rCount++;
        }
    }

    $option = mysqli_query($conn,"select l.* from level1 as l join sub_questions as q on l.question_id=q.id join questions as mq on q.question_id=mq.id where l.value !='' and mq.form_id=10");
    while($row = mysqli_fetch_assoc($option)){
        if(!in_array($row['label'],$quesArray))
        {
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "A".$rCount, $row['label']);
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "B".$rCount, $row['label_'.$lang]);
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "C".$rCount, 0);

            $quesArray[]=$row['label'];
            $rCount++;
        }
    }





    /*********** Static Labels ***********/



    $quesArray = $subArray = array();

    $countr=2;
    $objPHPExcel->setActiveSheetIndex(3)->setTitle('Static Labels');

    $objPHPExcel->setActiveSheetIndex(3)
        ->setCellValue('A1', 'Static Labels in English');
    $objPHPExcel->setActiveSheetIndex(3)
        ->setCellValue('B1', 'Static Label\'s Translation');



    $static_labels = mysqli_query($conn,"select * from static_labels");
    while($row = mysqli_fetch_assoc($static_labels)){
        $objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( "A".$countr, $row['label']);
        $objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( "B".$countr, $row['label_'.$lang]);
        $objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( "C".$countr, 0);

        $countr++;
    }

}

//--------------Education Options-----------------
$counte=3;
$quesArray = $subArray = array();

$objPHPExcel->setActiveSheetIndex(4)->setTitle('Education Options');

$objPHPExcel->setActiveSheetIndex(4)
    ->setCellValue('A1', 'Options in English');
$objPHPExcel->setActiveSheetIndex(4)
    ->setCellValue('B1', 'Options Translation');



$getNOC = mysqli_query($conn , "SELECT * FROM education");
while($noc = mysqli_fetch_assoc($getNOC)){
    $objPHPExcel->setActiveSheetIndex( 4 )->setCellValue( "A".$counte, $noc['name']);
    $objPHPExcel->setActiveSheetIndex( 4 )->setCellValue( "B".$counte, $noc['name_'.$lang]);
    $objPHPExcel->setActiveSheetIndex( 4 )->setCellValue( "C".$counte, 0);

    $counte++;



}



//--------------NOC-----------------



$objPHPExcel->setActiveSheetIndex(5)
    ->setCellValue('A1', 'Positions in English');
$objPHPExcel->setActiveSheetIndex(5)
    ->setCellValue('B1', 'Position\'s Translation');


$objPHPExcel->setActiveSheetIndex(5)
    ->setCellValue('C1', 'Duties in English');
$objPHPExcel->setActiveSheetIndex(5)
    ->setCellValue('D1', 'Duties\'s Translation');

$objPHPExcel->setActiveSheetIndex(5)->setTitle('NOC');



$quesArray = $subArray = array();
$quesFound = array();

$rCount = 2; $count = 2;



$option = mysqli_query($conn,"select * from noc_translation");
while($row = mysqli_fetch_assoc($option)){


    $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "A".$rCount, $row['job_position']);
    $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "B".$rCount, $row['job_position_'.$lang]);


    $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "C".$rCount, $row['job_duty']);
    $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "D".$rCount, $row['job_duty_'.$lang]);

    $rCount++;
}


//--------------Country-----------------




$objPHPExcel->setActiveSheetIndex(6)->setTitle('Countries');

$objPHPExcel->setActiveSheetIndex(6)
    ->setCellValue('A1', 'Countries in English');
$objPHPExcel->setActiveSheetIndex(6)
    ->setCellValue('B1', 'Country\'s Translation');

$quesArray = $subArray = array();
$quesFound = array();

$rCount = 2; $count = 2;



$option = mysqli_query($conn,"select * from countries");
while($row = mysqli_fetch_assoc($option)){
    $objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( "A".$rCount, $row['name']);
    $objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( "B".$rCount, $row['name_'.$lang]);
    $objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( "C".$rCount, 0);

    $rCount++;
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
header( "Content-Disposition: attachment;filename=TranslationFullComparison(".$lang.").xlsx" );

header( "Cache-Control: max-age=0" );

$objWriter->save('php://output');

exit;

?>