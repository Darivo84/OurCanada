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

$objPHPExcelLoad = PHPExcel_IOFactory::load( 'uploads/multi_lingual/'.$file_name );
$worksheetList = $objPHPExcelLoad->getSheetNames();

$objPHPExcelLoad->setActiveSheetIndex( 0 );
$excelData = $objPHPExcelLoad->getActiveSheet( 0 )->toArray();


$totRec = sizeof( $excelData );
$sheet = $objPHPExcelLoad->getSheet( 0 );
$highest_column = $sheet->getHighestColumn();

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



if($_GET['file']){

    // Load Main Question and Sub Questions
    $mainQuestions = mysqli_query($conn , "SELECT question,id,grade FROM questions WHERE form_id = '10' and question !=''");
    $subQuestions = mysqli_query($conn , "SELECT s.question,s.id,s.grade FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' and s.question != ''");

    $quesArray = $subArray = array();
    $quesFound = array();

    $objPHPExcel->setActiveSheetIndex(0)->setTitle('Questions');

    $rCount = 2; $count = 2;

    while($row = mysqli_fetch_assoc($mainQuestions)){

        if($row['grade']==1)
        {
            continue;
        }

        $c=0;
        $match = 0;
        $ques=strtolower(rtrim($row['question']));

        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][0]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['question'])) == $tr){
                $c++;
                $match = $i;
                break;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
                $match = $i;
                break;
            }
        }

        if(!in_array($row['question'],$quesArray)){
            $quesArray[$row['id']]=$row['question'];
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$rCount, $row['question']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "B".$rCount, $excelData[$match][1]);
            }
            $rCount++;
        }



    }

    while($row = mysqli_fetch_assoc($subQuestions)){

        if($row['grade']==1)
        {
            continue;
        }

        $c=0;
        $match = 0;
        $ques=strtolower(rtrim($row['question']));

        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][0]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['question'])) == $tr){
                $c++;
                $match = $i;
                break;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
                $match = $i;
                break;
            }
        }

        if(!in_array($row['question'],$quesArray)){
            $quesArray[$row['id']]=$row['question'];
            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$rCount, $row['question']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "B".$rCount, $excelData[$match][1]);
            }
            $rCount++;
        }



    }

    // Notes

    $objPHPExcel->setActiveSheetIndex(1)->setTitle('Notes');
    $mainQuestions = mysqli_query($conn , "SELECT notes,id FROM questions WHERE form_id = '10' and notes !=''");
    $subQuestions = mysqli_query($conn , "SELECT s.notes,s.id FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' and s.notes != ''");
	
	$scoringNotes = mysqli_query($conn , "select * from score_questions WHERE comments != ''");
	$scoringNotes2 = mysqli_query($conn , "select * from score_questions2 WHERE comments != ''");

    $quesArray = $subArray = array();
    $quesFound = array();

    $rCount = 2; $count = 2;

    while($row = mysqli_fetch_assoc($mainQuestions)){
        $c=0;
        $match = 0;
        $ques=strtolower(rtrim($row['notes']));

        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['notes'])) == $tr){
                $c++;
                $match = $i;
                break;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
                $match = $i;
                break;
            }
        }

        if(!in_array($row['notes'],$quesArray)){
            $quesArray[$row['id']]=$row['notes'];
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['notes']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $excelData[$match][3]);
            }
            $rCount++;
        }



    }

    while($row = mysqli_fetch_assoc($subQuestions)){
        $c=0;
        $match = 0;
        $ques=strtolower(rtrim($row['notes']));

        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['notes'])) == $tr){
                $c++;
                $match = $i;
                break;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
                $match = $i;
                break;
            }
        }

        if(!in_array($row['notes'],$quesArray)){
            $quesArray[$row['id']]=$row['notes'];
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['notes']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $excelData[$match][3]);
            }
            $rCount++;
        }



    }
	
	while($row = mysqli_fetch_assoc($scoringNotes)){
        $c=0;
        $match = 0;
        $ques=strtolower(rtrim($row['comments']));

        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['comments'])) == $tr){
                $c++;
                $match = $i;
                break;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
                $match = $i;
                break;
            }
        }

        if(!in_array($row['comments'],$quesArray)){
            $quesArray[$row['id']]=$row['comments'];
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['comments']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $excelData[$match][3]);
            }
            $rCount++;
        }



    }
	
	while($row = mysqli_fetch_assoc($scoringNotes2)){
        $c=0;
        $match = 0;
        $ques=strtolower(rtrim($row['comments']));

        for ( $i = 1; $i <= $totRec - 1; $i++ ) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($row['comments'])) == $tr){
                $c++;
                $match = $i;
                break;
            }
            else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                $c++;
                $match = $i;
                break;
            }
        }

        if(!in_array($row['comments'],$quesArray)){
            $quesArray[$row['id']]=$row['comments'];
            $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A".$rCount, $row['comments']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "B".$rCount, $excelData[$match][3]);
            }
            $rCount++;
        }



    }

    // Options

    $objPHPExcel->setActiveSheetIndex(2)->setTitle('Options');
    $quesArray = $subArray = array();
    $quesFound = array();

    $rCount = 2; $count = 2;

    $option = mysqli_query($conn,"select l.* from ocs.question_labels as l join ocs.questions as q on q.id=l.question_id where l.value !='' and q.form_id=10");
    while($row = mysqli_fetch_assoc($option)){
        $c=0;
        $match = 0;
        $matchC = 0;

        $ques=strtolower(rtrim($row['label']));



        for ($i = 1; $i <= $totRec - 1; $i++) {
            for ($k = 5; $k < 70; $k+=2) {
                $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][$k]))));
                if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                    $c++;
                    $match = $i;
                    $matchC = $k;
                    break;
                }else if(preg_replace('!\s+!', ' ',strtolower($row['label'])) == $tr){
                    $c++;
                    $match = $i;
                    $matchC = $k;
                    break;
                }
                else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                    $c++;
                    $match = $i;
                    $matchC = $k;
                    break;
                }

            }
        }



        if(!in_array($row['label'],$quesArray)){
            $quesArray[$row['id']]=$row['label'];
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "A".$rCount, $row['label']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "B".$rCount, $excelData[$match][$matchC+1]);
            }
            $rCount++;
        }



    }

    $option = mysqli_query($conn,"select l.* from level1 as l join sub_questions as q on l.question_id=q.id join questions as mq on q.question_id=mq.id where l.value !='' and mq.form_id=10");
    while($row = mysqli_fetch_assoc($option)){
        $c=0;
        $match = 0;
        $matchC = 0;

        $ques=strtolower(rtrim($row['label']));



        for ($i = 1; $i <= $totRec - 1; $i++) {
            for ($k = 5; $k < 70; $k+=2) {
                $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][$k]))));
                if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                    $c++;
                    $match = $i;
                    $matchC = $k;
                    break;
                }else if(preg_replace('!\s+!', ' ',strtolower($row['label'])) == $tr){
                    $c++;
                    $match = $i;
                    $matchC = $k;
                    break;
                }
                else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr){
                    $c++;
                    $match = $i;
                    $matchC = $k;
                    break;
                }

            }
        }



        if(!in_array($row['label'],$quesArray)){
            $quesArray[$row['id']]=$row['label'];
            $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "A".$rCount, $row['label']);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "B".$rCount, $excelData[$match][$matchC+1]);
            }
            $rCount++;
        }



    }



    $quesArray = $subArray = array();

    $countr=2;
    $objPHPExcel->setActiveSheetIndex(3)->setTitle('Static Labels');

    $objPHPExcel->setActiveSheetIndex(3)
        ->setCellValue('A1', 'Static Labels in English');
    $objPHPExcel->setActiveSheetIndex(3)
        ->setCellValue('B1', 'Static Label\'s Translation');


     $static_labels=['Do you have any comments?','Terms & Conditions','I agree','Thank You for your interest in Canada','Ok','Okay','Home','About Us','Canadian Immigration Tool','Contact Us',
        'Login','English','Copyright','Urdu','French','Privacy & Terms of Use',
        'Please start completing our dynamic form and find out which Canadian immigration programs you may qualify for',
        'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.' , 'From' , 'To' , 'Present' , 'Submit' , 'Congratulations' , 'This date is smaller than previous' , 'There was an error handling your request please try again.' , 'Warning' , 'says','Continue' , 'This field is required' , 'Form has been submitted' , 'Welcome' , 'Please enter a valid email address.' , 'Please select from date first' , 'Please enter at least 6 characters.' , 'Edit', 'Are you sure you want to edit ? Once you edit, scoring will reinitiate' , 'Would you like to send this question\'s answer via email?' , 'Congratulations and thank you for your interest in Canada' , 'Thank you for contacting us. Your request has been generated. We will get back to you as soon as possible.' , 'Something went wrong' ];


    foreach ($static_labels as $label)
    {
        if(!in_array($label,$quesArray)){
            $quesArray[]=$label;
            $objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( "A".$countr, $label);
            $countr++;
        }
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


    if(!in_array($noc['value'],$quesArray)){
        $quesArray[]=$noc['value'];
        $objPHPExcel->setActiveSheetIndex(4)->setCellValue( 'A'.$counte, $noc['value']);
        $counte++;
    }


}

//--------------NOC-----------------
$sheet = $objPHPExcelLoad->getSheet( 2 )->toArray();
$totRec = sizeof( $sheet );

$objPHPExcel->setActiveSheetIndex(5)->setTitle('Education Options');

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



$option = mysqli_query($conn,"select * from noc2");
while($row = mysqli_fetch_assoc($option)){
    $c=0;
    $match = 0;
    $matchC = 0;

    $duties=explode('*',$row['job_duty']);
    $positions=explode('*',$row['job_position']);

    foreach ($duties as $d)
    {
        $ques=strtolower(rtrim(ltrim($d)));

        for ($i = 1; $i <= $totRec - 1; $i++) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($sheet[$i][2]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                $matchC = $k;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($d)) == $tr){
                $c++;
                $match = $i;
                $matchC = $k;
                break;
            }
            else if(preg_replace('!\s+!', ' ',($ques)) == $tr){
                $c++;
                $match = $i;
                $matchC = $k;
                break;
            }


        }
        if(!in_array($d,$quesArray)){
            $quesArray[]=$d;
            $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "C".$rCount, $d);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "D".$rCount, $sheet[$match][3]);
            }
            $rCount++;
        }

    }
    $c=0;
    $match = 0;
    $matchC = 0;
    foreach ($positions as $p)
    {
        $ques=strtolower(rtrim(ltrim($p)));

        for ($i = 1; $i <= $totRec - 1; $i++) {
            $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($sheet[$i][0]))));
            if(preg_replace('!\s+!', ' ',$ques) == $tr ){
                $c++;
                $match = $i;
                $matchC = $k;
                break;
            }else if(preg_replace('!\s+!', ' ',strtolower($p)) == $tr){
                $c++;
                $match = $i;
                $matchC = $k;
                break;
            }
            else if(preg_replace('!\s+!', ' ',($ques)) == $tr){
                $c++;
                $match = $i;
                $matchC = $k;
                break;
            }


        }
        if(!in_array($p,$subArray)){
            $subArray[]=$p;
            $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "A".$count, $p);
            if($c==0)
            {

            }else{
                $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "B".$count, $sheet[$match][1]);
            }
            $count++;
        }
    }


}

//--------------Country-----------------

$sheet = $objPHPExcelLoad->getSheet( 1 )->toArray();
$totRec = sizeof( $sheet );


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
    $c=0;
    $match = 0;
    $matchC = 0;

    $d=$row['name'];
    $ques=strtolower(rtrim(ltrim($d)));

    for ($i = 1; $i <= $totRec - 1; $i++) {
        $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($sheet[$i][0]))));
        if(preg_replace('!\s+!', ' ',$ques) == $tr ){
            $c++;
            $match = $i;
            $matchC = $k;
            break;
        }else if(preg_replace('!\s+!', ' ',strtolower($d)) == $tr){
            $c++;
            $match = $i;
            $matchC = $k;
            break;
        }
        else if(preg_replace('!\s+!', ' ',($ques)) == $tr){
            $c++;
            $match = $i;
            $matchC = $k;
            break;
        }


    }
    if(!in_array($d,$quesArray)){
        $quesArray[]=$d;
        $objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( "A".$rCount, $d);
        if($c==0)
        {

        }else{
            $objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( "B".$rCount, $sheet[$match][1]);
        }
        $rCount++;
    }


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
header( "Content-Disposition: attachment;filename=TranslationFullComparison.xlsx" );

header( "Cache-Control: max-age=0" );

$objWriter->save('php://output');

exit;

?>