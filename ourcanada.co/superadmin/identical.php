<?php

include_once("../global.php");
require_once 'excelClass/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);
$objPHPExcel->getProperties()->setCreator("microBeck")
    ->setLastModifiedBy("microBeck")
    ->setTitle("Multi Lingual List")
    ->setSubject("Multi Lingual List")
    ->setDescription("Multi Lingual list stored in microBeck CMS")
    ->setKeywords("Multi Lingual List from Database")
    ->setCategory("Admin Panel");
$char = 'D';

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Question');
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('B1', 'Pages/Qid/Sid');
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C1', 'Count');


$quesArray=[];
$options = 'F';
$min = 35;
$op = 1;

// Questions Column
$mainQues=mysqli_query($conn,"SELECT * FROM questions WHERE form_id = '10' and question !='' and submission_type = 'after'");
$count = mysqli_num_rows($mainQues);
$quesArr = array();
$quesArr2 = array();
$quesArr3 = array();
$qTotal=0;
$sTotal=0;
$qsCount = 0;

$id = 1;

if(mysqli_num_rows($mainQues) > 0)
{

    while($row = mysqli_fetch_array($mainQues))
    {

//        if(!in_array($row['question'], $quesArr2))
        {

            $p['question']=$row['question'];
            $p['type']='main';
            $quesArr3[] =$row['question'] . ' ** ' . $row['notes'];
            $quesArr2[$id]['quest/notes'] =$row['question'] . ' ** ' . $row['notes'];
			$quesArr2[$id]['page/qid/sid'] = '{'.$row['page'] . ' , ' . $row['id'] . ' , 0 }';
			
			$id++;

        }

    }
}
$subQues = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' AND s.question != '' and s.grade=0 and s.submission_type = 'after'");

if(mysqli_num_rows($subQues) > 0)
{
    while($row = mysqli_fetch_array($subQues))
    {

//        if(!in_array($row['question'], $quesArr2))
        {

            $p['question']=$row['question'];
            $p['type']='sub';
            $quesArr3[] =$row['question'] . ' ** ' . $row['notes'];
            $quesArr2[$id]['quest/notes'] =$row['question'] . ' ** ' . $row['notes'];
			$quesArr2[$id]['page/qid/sid'] = '{'.$row['page'] . ' , ' . $row['question_id'] . ' , '. $row['id'] . '}';
			
			$id++;

        }



    }
}
$vals = array_count_values($quesArr3);
$countr=3;
$c = 3;

$idenArr = array();

foreach ($vals as $k=>$v)
{
    $charc = 'A';
    $charc2 = 'B';

    $charN = 'C';
	$arrQuest = '';

	if($v > 1){
		$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($charc.$countr, $k);
		
		foreach($quesArr2 as $kQ => $kV){
			if($k == $kV['quest/notes']){
				$arrQuest .= $kV['page/qid/sid'].' ';
			}
		}
		
		$idenArr[] = $arrQuest;
		
		$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($charc2.$countr, $arrQuest);
		$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue($charN.$countr, $v);
		
		$c++;
		$countr++;
		$qsCount++;
		$sTotal+=$v;
		
	}
    
}

foreach($idenArr as $k => $v){
	$strRep = '';
	$strRep = str_replace(array("{","}") , array("","| "),$v);

	$getIndex = explode("|",$strRep);
	foreach($getIndex as $qK => $qV){
		if($qV !== ''){
			$q = explode(",",$qV);
			$quesID = $q[1];
			$subID = $q[2];
			
			if($subID == 0){
				$getQuesScore = mysqli_query($conn , "SELECT * FROM score_questions WHERE move_qid = '{$quesID}' ");
			}else{
				$getQuesScore = mysqli_query($conn , "SELECT * FROM score_questions WHERE move_qid = '{$subID}' ");
			}
			
			$scoreID = '';
			while($row = mysqli_fetch_assoc($getQuesScore)){
				$scoreID .= $row['score_id'].' * ';
			}
			
			if($subID == 0){
				echo 'Qid - '.$quesID.' - {'.$scoreID.'}';
			}else{
				echo 'Sid - '.$subID.' - {'.$scoreID.'}';
			}
			
			
			
		}
		
	}
	
}


die();


header('Content-Disposition: attachment;filename="OurCanada_Questions_Duplications.xlsx"');

$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setBold(true);


$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


$objPHPExcel->setActiveSheetIndex(0)->setTitle('Question\'s Duplication');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;




?>