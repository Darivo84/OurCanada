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
				->setCellValue('A1', 'Original Question in English');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B1', 'Translation in French');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C1', 'User notes in English');
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('D1', 'User notes in French');
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('E1', 'Field Type');

    $objPHPExcel->createSheet();
    $objPHPExcel->createSheet();

    $objPHPExcel->setActiveSheetIndex(2)
        ->setCellValue('A1', 'Job Positions in English');
    $objPHPExcel->setActiveSheetIndex(2)
        ->setCellValue('B1', 'Job Positions (Translation)');
    $objPHPExcel->setActiveSheetIndex(2)
        ->setCellValue('C1', 'Job Duties in English');
    $objPHPExcel->setActiveSheetIndex(2)
        ->setCellValue('D1', 'Job Duties (Translation)');



$options = 'F';
	$min = 35;
	$op = 1;
	for ($i =0; $i <= $min; $i++){

        $objPHPExcel->getActiveSheet()->getColumnDimension($options)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle($options.'1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($options.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($options.'1', 'Option '.$op.' (English)');
        $options++;

        $objPHPExcel->getActiveSheet()->getColumnDimension($options)->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle($options.'1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle($options.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($options.'1', 'Option '.$op.' (Translation)');
        $options++;
        $op++;
    }

	// Questions Column
	$mainQues=mysqli_query($conn,"SELECT question , notes , id , labeltype , fieldtype FROM questions WHERE form_id = '10' and question !=''");
	$count = mysqli_num_rows($mainQues);
	$quesArr = array();
	$qsCount = 0;

	if(mysqli_num_rows($mainQues) > 0)
	{
		$countr=3;
        $c = 3;
		while($row = mysqli_fetch_array($mainQues))
		{
			$charc = 'A';
            $charN = 'C';
            $id = $row['id'];
				$quesArr[$qsCount]['question'] = $row['question'];
				$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue($charc.$countr, $row['question']);
				if($row['notes'] !== ''){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($charN.$countr, $row['notes']);
                }
				if($row['fieldtype'] == 1 && $row['labeltype'] == 0){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('F'.$countr, 'Yes');
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('H'.$countr, 'No');
                }else{
                    $options = 'F';
                    $getOptions = mysqli_query($conn , "SELECT * FROM question_labels where question_id = $id");
                    if(mysqli_num_rows($getOptions) > 0 ){
                        while($o = mysqli_fetch_assoc($getOptions)){
                            if($o['label'] !== '' || $o['label'] !== NULL){
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue($options.$countr, $o['label']);
                                $options++;
                                $options++;
                            }
                        }
                    }else{
                        for ($i =0; $i <= $min; $i++){
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue($options.$countr, '');
                            $options++;
                            $options++;
                        }
                    }

                }

                $c++;
				$countr++;
				$qsCount++;
			
		}
	}

    $subQues = mysqli_query($conn , "SELECT s.question , s.notes , s.id ,  s.labeltype , s.fieldtype FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' AND s.question != '' and s.grade=0");

    if(mysqli_num_rows($subQues) > 0)
    {
        $c = 3;
        while($row = mysqli_fetch_array($subQues))
        {
            $sID = $row['id'];
            $charc = 'A';
            $charN = 'C';

            
                $quesArr[$qsCount]['question'] = $row['question'];
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($charc.$countr, $row['question']);
                if($row['notes'] !== ''){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue($charN.$countr, $row['notes']);
                }

                if($row['fieldtype'] == 1 && $row['labeltype'] == 0){
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('F'.$countr, 'Yes');
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('H'.$countr, 'No');
                }else{
                    $options = 'F';
                    $getOptions = mysqli_query($conn , "SELECT * FROM level1 where question_id = $sID");
                    if(mysqli_num_rows($getOptions) > 0 ){
                        while($o = mysqli_fetch_assoc($getOptions)){
                            if($o['label'] !== '' || $o['label'] !== NULL){
                                $objPHPExcel->setActiveSheetIndex(0)
                                    ->setCellValue($options.$countr, $o['label']);
                                $options++;
                                $options++;
                            }
                        }
                    }else{
                        for ($i =0; $i <= $min; $i++){
                            $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue($options.$countr, '');
                            $options++;
                            $options++;
                        }
                    }

                }
                $c++;
                $countr++;
                $qsCount++;

            




        }
    }




$objPHPExcel->setActiveSheetIndex(1)
        ->setCellValue('A1', 'Orignal Counrty');
    $objPHPExcel->setActiveSheetIndex(1)
        ->setCellValue('B1', 'Country Translation');

    $cChar = 'A';
    $countr = 3;
	$getCountries = mysqli_query($conn , "SELECT * FROM countries");
	while($c = mysqli_fetch_assoc($getCountries)){
        $objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue($charc.$countr, $c['name']);
        $countr++;
        $cChar++;
    }

    $cChar = 'A';
	$nChar = 'C';
    $countr = 3;
    $countn = 3;

    $getNOC = mysqli_query($conn , "SELECT * FROM noc2");
	while($noc = mysqli_fetch_assoc($getNOC)){
	    $jobPosition = explode("*",$noc['job_position']);
	    foreach ($jobPosition as $k => $v){
            $objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue($cChar.$countr, $v);
            $countr++;

        }

        $jobDuty = explode("*",$noc['job_duty']);
        foreach ($jobDuty as $dk => $dv){
            $objPHPExcel->setActiveSheetIndex(2)
                ->setCellValue($nChar.$countn, $dv);
            $countn++;

        }

    }


    ///---------Static Labels---------------
$countr=3;
$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(3)
    ->setCellValue('A1', 'Labels in English');
$objPHPExcel->setActiveSheetIndex(3)
    ->setCellValue('B1', 'Label\'s Translation');

    $static_labels=['Do you have any comments?','Terms & Conditions','I agree','Thankyou for your interest in Canada','Ok','Okay','Home','About Us','Canadian Immigration Tool','Contact Us',
    'Login','English','Copyrights','Urdu','French','Privacy & Terms of Use',
    'Please start completing our dynamic form and find out which Canadian immigration programs you may qualify for',
    'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.','Continue'];

foreach ($static_labels as $label)
{
    $objPHPExcel->setActiveSheetIndex(3)->setCellValue('A'.$countr,$label );
    $countr++;
}


//--------------Education Options-----------------
$counte=3;

$objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(4)
    ->setCellValue('A1', 'Options in English');
$objPHPExcel->setActiveSheetIndex(4)
    ->setCellValue('B1', 'Options Translation');
$getNOC = mysqli_query($conn , "SELECT * FROM education");
while($noc = mysqli_fetch_assoc($getNOC)){

    $objPHPExcel->setActiveSheetIndex(4)
        ->setCellValue( 'A'.$counte, $noc['value']);
    $counte++;

}

	header('Content-Disposition: attachment;filename="OurCanada_Translation_FullData.xlsx"');

	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);

	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1')->getFont()->setBold(true);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1')->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(2)->getColumnDimension('A')->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(2)->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(2)->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(2)->getColumnDimension('D')->setAutoSize(true);

    $objPHPExcel->setActiveSheetIndex(2)->getStyle('A1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(2)->getStyle('B1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(2)->getStyle('C1')->getFont()->setBold(true);
    $objPHPExcel->setActiveSheetIndex(2)->getStyle('D1')->getFont()->setBold(true);

    $objPHPExcel->setActiveSheetIndex(2)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->setActiveSheetIndex(2)->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->setActiveSheetIndex(2)->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->setActiveSheetIndex(2)->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(4)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(4)->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(4)->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(4)->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(3)->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(3)->getStyle('D1')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(4)->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(4)->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(4)->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->setActiveSheetIndex(4)->getStyle('D1')->getFont()->setBold(true);

	$objPHPExcel->setActiveSheetIndex(0)->setTitle('Translation');
    $objPHPExcel->setActiveSheetIndex(1)->setTitle('Countries');
    $objPHPExcel->setActiveSheetIndex(2)->setTitle('NOC');
$objPHPExcel->setActiveSheetIndex(3)->setTitle('Static Labels');
$objPHPExcel->setActiveSheetIndex(4)->setTitle('Education Options');


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

	exit;



?>