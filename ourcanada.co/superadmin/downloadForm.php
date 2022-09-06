<?php 

	include_once("global.php");
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

$row = 'A';
$col=1;

	$select=mysqli_query($conn,"Select * from user_form where status='1'");
	while($r=mysqli_fetch_assoc($select))
    {

        $row = 'A';

        $questions=json_decode($r['questions']);
        $answers=json_decode($r['answers']);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($row.$col, 'Name');
        $row++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($row.$col, 'Email');
        $row++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($row.$col, 'Phone');
        $row++;

        foreach ($questions as $q)
        {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($row.$col, $q);
            $row++;
        }
        $row = 'A';
        $col++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($row.$col, $r['user_name']);
        $row++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($row.$col, $r['user_email']);
        $row++;
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($row.$col, $r['user_phone']);
        $row++;
        foreach ($answers as $a)
        {
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue($row.$col, $a);
            $row++;
        }

        $col++;
        $col++;

    }






	header('Content-Disposition: attachment;filename="OurCanada_Immigration_Forms.xlsx"');

	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setAutoSize(true);


	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


	$objPHPExcel->setActiveSheetIndex(0)->setTitle('Submission Form');



	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');

	exit;



?>