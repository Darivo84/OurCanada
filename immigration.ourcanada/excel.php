<?php
	include_once("global.php");
	require_once 'excelClass/PHPExcel.php';

	$questArr = array();
	$currentDir = getcwd();

	$objPHPExcel = new PHPExcel();
	$objPHPExcelLoad = new PHPExcel();

	// Load File to Compare
	$objPHPExcelLoad = PHPExcel_IOFactory::load( 'trans/FrenchFinal.xlsx' );
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



	$objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A1", "Questions Not Matched");

	
	$valTrans = '';
	$arrQues = array();
$arrQues2 = array();

$quesFound = array();

	$mainQuestions = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '10' and question !=''");
	$subQuestions = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id where form_id='10'");
	if($_GET['h'] == 'db' && $_GET['type']=='question'){
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
            }

        }
		echo 'Total Number of Questions not found in excel:'.sizeof($arrQues).'<br>';
		print_r($arrQues);
//        print_r(array_diff($arrQues,$quesFound));
echo '<br><br>';
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
				}
                
            }
		}
		echo 'Total Number of Sub Questions not found in excel:'.sizeof($arrQues2).'<br>';
        print_r($arrQues2);
			die();
		
	}
	else if($_GET['type']=='question')
	    {
		$count=2;
		if($totRec > 0){
			for ( $i = 1; $i <= $totRec - 1; $i++ ) {
				$translation = rtrim($excelData[$i][0]);

				$valTrans = '';
				$getQuestioVal = mysqli_query($conn , "SELECT * FROM questions WHERE (question LIKE '%$translation%' AND form_id = '10')");
				if(mysqli_num_rows($getQuestioVal) > 0){
					$valTrans = 'Found';
				}else{
					$getSubQuestioVal = mysqli_query($conn , "SELECT * FROM sub_questions WHERE question LIKE '%$translation%' ");
					if(mysqli_num_rows($getSubQuestioVal) > 0){
						$valTrans = 'Found';
					}else{
						if(!in_array($translation,$arrQues)){
							$objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$count, $translation );
							$count++;
						}
					}


				}
				if($valTrans != 'Found'){
					if(!in_array($translation,$arrQues)){
						$arrQues[] = $translation;
					}
				}
			}
//			print_r($arrQues);
//			die();
		}else
		{
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A2', 'No data found in system!');

		}	
	}
	else if($_GET['h'] == 'db' && $_GET['type']=='notes'){
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
                if(!in_array($row['notes'],$arrQues))
                    $arrQues[$row['id']]=$row['notes'];
            }

        }
//        echo 'Total Number of Questions not found in excel:'.sizeof($arrQues).'<br>';
//        print_r($arrQues);
////        print_r(array_diff($arrQues,$quesFound));
//        echo '<br><br>';
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
                if(!in_array($row['notes'],$arrQues2)){
                    $arrQues2[$row['id']]=$row['notes'];
                }

            }
        }
//        echo 'Total Number of Sub Questions not found in excel:'.sizeof($arrQues2).'<br>';
//        print_r($arrQues2);
//        die();

    }
    else if($_GET['type']=='notes')
    {
        $count=2;
        if($totRec > 0){
            for ( $i = 1; $i <= $totRec - 1; $i++ ) {
                $translation = rtrim($excelData[$i][2]);

                $valTrans = '';
                $getQuestioVal = mysqli_query($conn , "SELECT * FROM questions WHERE (notes LIKE '%$translation%' AND form_id = '10')");
                if(mysqli_num_rows($getQuestioVal) > 0){
                    $valTrans = 'Found';
                }else{
                    $getSubQuestioVal = mysqli_query($conn , "SELECT * FROM sub_questions WHERE notes LIKE '%$translation%' ");
                    if(mysqli_num_rows($getSubQuestioVal) > 0){
                        $valTrans = 'Found';
                    }else{
                        if(!in_array($translation,$arrQues)){
                            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$count, $translation );
                            $count++;
                        }
                    }


                }
                if($valTrans != 'Found'){
                    if(!in_array($translation,$arrQues)){
                        $arrQues[] = $translation;
                    }
                }
            }
//            print_r($arrQues);
//            die();
        }else
        {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'No data found in system!');

        }
    }

    else if($_GET['h'] == 'db' && $_GET['type']=='options'){
        $count=2;
        
		$s=mysqli_query($conn,"select * from level1");
		while($r=mysqli_fetch_assoc($s)) {
			$c = 0;
			$ques = strtolower(rtrim($r['value']));
			$valTrans = '';
			
			for ($i = 1; $i <= $totRec - 1; $i++) {
				$updated = false;
				for($k=5;$k<17;$k+=2) {
					$tr = strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][$k]))));
					if (preg_replace('!\s+!', ' ', $ques) == $tr) {
						$c++;
						$updated = true;
					} else if (preg_replace('!\s+!', ' ', strtolower($r['value'])) == $tr) {
						$c++;
						$updated = true;
					} else if (preg_replace('!\s+!', ' ', ltrim($ques)) == $tr) {
						$c++;
						$updated = true;
					}
					
					if($updated){
						break;
					}
				}
				if ($c == 0) {
					if (!in_array($r['value'], $arrQues))
						$arrQues[$r['id']] = $r['value'];
				}
				

			}
		}
       
//        echo 'Total Number of Questions not found in excel:'.sizeof($arrQues).'<br>';
//        print_r($arrQues);
////        print_r(array_diff($arrQues,$quesFound));
//        echo '<br><br>';
//        while($row = mysqli_fetch_assoc($subQuestions)){
//            $c=0;
//            $ques=strtolower(rtrim($row['notes']));
//            for ( $i = 1; $i <= $totRec - 1; $i++ ) {
//                $tr= strtolower(ltrim(preg_replace('!\s+!', ' ', rtrim($excelData[$i][2]))));
//                if(preg_replace('!\s+!', ' ',$ques) == $tr ){
//                    $c++;
//                }else if(preg_replace('!\s+!', ' ',strtolower($row['notes'])) == $tr){
//                    $c++;
//                }
//                else if(preg_replace('!\s+!', ' ',ltrim($ques)) == $tr) {
//                    $c++;
//                }
//            }
//            if($c==0)
//            {
//                if(!in_array($row['notes'],$arrQues2)){
//                    $arrQues2[$row['id']]=$row['notes'];
//                }
//
//            }
//        }
//        echo 'Total Number of Sub Questions not found in excel:'.sizeof($arrQues2).'<br>';
//        print_r($arrQues2);
//        die();

    }
    else if($_GET['type']=='options')
    {
        $count=2;
        if($totRec > 0){
            for ( $i = 1; $i <= $totRec - 1; $i++ ) {
                $translation = rtrim($excelData[$i][2]);

                $valTrans = '';
                $getQuestioVal = mysqli_query($conn , "SELECT * FROM questions WHERE (notes LIKE '%$translation%' AND form_id = '10')");
                if(mysqli_num_rows($getQuestioVal) > 0){
                    $valTrans = 'Found';
                }else{
                    $getSubQuestioVal = mysqli_query($conn , "SELECT * FROM sub_questions WHERE notes LIKE '%$translation%' ");
                    if(mysqli_num_rows($getSubQuestioVal) > 0){
                        $valTrans = 'Found';
                    }else{
                        if(!in_array($translation,$arrQues)){
                            $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A".$count, $translation );
                            $count++;
                        }
                    }


                }
                if($valTrans != 'Found'){
                    if(!in_array($translation,$arrQues)){
                        $arrQues[] = $translation;
                    }
                }
            }
//            print_r($arrQues);
//            die();
        }else
        {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A2', 'No data found in system!');

        }
    }





$objPHPExcel->setActiveSheetIndex(0);


	$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, "Excel2007" );

	ob_end_clean();



	header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );

	header( "Content-Disposition: attachment;filename=OurCanadaQuestions.xlsx" );

	header( "Cache-Control: max-age=0" );

	$objWriter->save('php://output');



	exit;
?>