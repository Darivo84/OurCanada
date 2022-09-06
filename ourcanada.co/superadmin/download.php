<?php

include_once( "../global.php" );
require_once 'excelClass/PHPExcel.php';

ini_set( 'memory_limit', '3200M' );
$questArr = array();
$objPHPExcel = new PHPExcel();

//$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();
$objPHPExcel->createSheet();


// File For downloading
$objPHPExcel->getDefaultStyle()->getFont()->setName( "Arial" )->setSize( 10 );
$objPHPExcel->getProperties()->setCreator( "Our Canada Questions" )->setLastModifiedBy( "Form Questions" )->setTitle( "Form Questions" )->setSubject( "Form Questions" )->setDescription( "Form Questions" )->setKeywords( "" )->setCategory( "Our Canada" );


for ( $i = 0; $i <= 6; $i++ ) {
  $objPHPExcel->getActiveSheet( $i )->getStyle( "A1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
  $objPHPExcel->getActiveSheet( $i )->getStyle( "A1" )->applyFromArray(
    array(
      "fill" => array(
        "type" => PHPExcel_Style_Fill::FILL_SOLID,
        "color" => array( "rgb" => "000000" )
      )
    )
  )->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );

  $objPHPExcel->getActiveSheet( $i )->getStyle( "B1" )->getAlignment()->setHorizontal( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
  $objPHPExcel->getActiveSheet( $i )->getStyle( "B1" )->applyFromArray(
    array(
      "fill" => array(
        "type" => PHPExcel_Style_Fill::FILL_SOLID,
        "color" => array( "rgb" => "000000" )
      )
    )
  )->getFont()->setBold( true )->getColor()->setRGB( "FFFFFF" );

  $objPHPExcel->setActiveSheetIndex( $i )->setCellValue( "A1", "Orignal" );
  $objPHPExcel->setActiveSheetIndex( $i )->setCellValue( "B1", "Translation" );
}



// Load Main Question and Sub Questions
$mainQuestions = mysqli_query( $conn, "SELECT question,id FROM questions WHERE form_id = '10' and question !=''" );
$subQuestions = mysqli_query( $conn, "SELECT s.question,s.id,s.grade FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' and s.question != ''" );

$quesArray = $subArray = array();
$quesFound = array();

$objPHPExcel->setActiveSheetIndex( 0 )->setTitle( 'Questions' );

$rCount = 2;
$count = 2;

while ( $row = mysqli_fetch_assoc( $mainQuestions ) ) {

  $c = 0;
  $match = 0;
  $ques = strtolower( rtrim( $row[ 'question' ] ) );

  if ( !in_array( $row[ 'question' ], $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = $row[ 'question' ];
    $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A" . $rCount, $row[ 'question' ] );
    $rCount++;
  }


}

while ( $row = mysqli_fetch_assoc( $subQuestions ) ) {

  if ( $row[ 'grade' ] == 1 ) {
    continue;
  }

  $c = 0;
  $match = 0;
  $ques = strtolower( rtrim( $row[ 'question' ] ) );
  if ( !in_array( $row[ 'question' ], $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = $row[ 'question' ];
    $objPHPExcel->setActiveSheetIndex( 0 )->setCellValue( "A" . $rCount, $row[ 'question' ] );

    $rCount++;
  }


}

// Notes

$objPHPExcel->setActiveSheetIndex( 1 )->setTitle( 'Notes' );
$mainQuestions = mysqli_query( $conn, "SELECT notes,id FROM questions WHERE form_id = '10' and notes !=''" );
$subQuestions = mysqli_query( $conn, "SELECT s.notes,s.id FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' and s.notes != ''" );

$scoringNotes = mysqli_query( $conn, "select * from score_questions WHERE comments != ''" );
$scoringNotes2 = mysqli_query( $conn, "select * from score_questions2 WHERE comments != ''" );

$quesArray = $subArray = array();
$quesFound = array();

$rCount = 2;
$count = 2;

while ( $row = mysqli_fetch_assoc( $mainQuestions ) ) {
  $c = 0;
  $match = 0;
  $ques = strtolower( rtrim( $row[ 'notes' ] ) );


  if ( !in_array( $row[ 'notes' ], $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = $row[ 'notes' ];
    $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A" . $rCount, $row[ 'notes' ] );
    $rCount++;
  }


}

while ( $row = mysqli_fetch_assoc( $subQuestions ) ) {
  $c = 0;
  $match = 0;
  $ques = strtolower( rtrim( $row[ 'notes' ] ) );

  if ( !in_array( $row[ 'notes' ], $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = $row[ 'notes' ];
    $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A" . $rCount, $row[ 'notes' ] );
    $rCount++;
  }


}

while ( $row = mysqli_fetch_assoc( $scoringNotes ) ) {
  $c = 0;
  $match = 0;
  $ques = strtolower( rtrim( $row[ 'comments' ] ) );


  if ( !in_array( $row[ 'comments' ], $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = $row[ 'comments' ];
    $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A" . $rCount, $row[ 'comments' ] );

    $rCount++;
  }


}

while ( $row = mysqli_fetch_assoc( $scoringNotes2 ) ) {
  $c = 0;
  $match = 0;
  $ques = strtolower( rtrim( $row[ 'comments' ] ) );


  if ( !in_array( $row[ 'comments' ], $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = $row[ 'comments' ];
    $objPHPExcel->setActiveSheetIndex( 1 )->setCellValue( "A" . $rCount, $row[ 'comments' ] );

    $rCount++;
  }


}

// Options

$objPHPExcel->setActiveSheetIndex( 2 )->setTitle( 'Options' );
$quesArray = $subArray = array();
$quesFound = array();

$rCount = 2;
$count = 2;

$option = mysqli_query( $conn, "select l.* from ocs.question_labels as l join ocs.questions as q on q.id=l.question_id where l.value !='' and q.form_id=10" );
while ( $row = mysqli_fetch_assoc( $option ) ) {
  $c = 0;
  $match = 0;
  $matchC = 0;

  $ques = strtolower( rtrim( $row[ 'label' ] ) );


  if ( !in_array( rtrim(ltrim($row['label'])), $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = rtrim(ltrim($row['label']));
    $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "A" . $rCount, rtrim(ltrim($row['label'])) );
      $quesArray[]=rtrim(ltrim($row['label']));

    $rCount++;
  }


}

$option = mysqli_query( $conn, "select l.* from level1 as l join sub_questions as q on l.question_id=q.id join questions as mq on q.question_id=mq.id where l.value !='' and mq.form_id=10" );
while ( $row = mysqli_fetch_assoc( $option ) ) {
  $c = 0;
  $match = 0;
  $matchC = 0;

  $ques = strtolower( rtrim( $row[ 'label' ] ) );


  if ( !in_array( rtrim(ltrim($row['label'])), $quesArray ) ) {
    $quesArray[ $row[ 'id' ] ] = rtrim(ltrim($row['label']));
    $objPHPExcel->setActiveSheetIndex( 2 )->setCellValue( "A" . $rCount, rtrim(ltrim($row['label'])) );
      $quesArray[]=rtrim(ltrim($row['label']));

    $rCount++;
  }


}


$quesArray = $subArray = array();

$countr = 2;
$objPHPExcel->setActiveSheetIndex( 3 )->setTitle( 'Static Labels' );

$objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( 'A1', 'Static Labels in English' );
$objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( 'B1', 'Static Label\'s Translation' );


$getStaticLabels = mysqli_query($conn , "SELECT * FROM static_labels");
$static_labels = array();

while($Row = mysqli_fetch_assoc($getStaticLabels)){
	$static_labels[] = $Row['label'];
}

foreach ( $static_labels as $label ) {
  if ( !in_array( $label, $quesArray ) ) {
    $quesArray[] = $label;
    $objPHPExcel->setActiveSheetIndex( 3 )->setCellValue( "A" . $countr, $label );
    $countr++;
  }
}


//--------------Education Options-----------------
$counte = 3;
$quesArray = $subArray = array();

$objPHPExcel->setActiveSheetIndex( 4 )->setTitle( 'Education Options' );

$objPHPExcel->setActiveSheetIndex( 4 )->setCellValue( 'A1', 'Options in English' );
$objPHPExcel->setActiveSheetIndex( 4 )->setCellValue( 'B1', 'Options Translation' );
$getNOC = mysqli_query( $conn, "SELECT * FROM education" );
while ( $noc = mysqli_fetch_assoc( $getNOC ) ) {


  if ( !in_array( $noc[ 'value' ], $quesArray ) ) {
    $quesArray[] = $noc[ 'value' ];
    $objPHPExcel->setActiveSheetIndex( 4 )->setCellValue( 'A' . $counte, $noc[ 'value' ] );
    $counte++;
  }


}



//--------------NOC-----------------

$objPHPExcel->setActiveSheetIndex( 5 )->setTitle( 'Education Options' );

$objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( 'A1', 'Positions in English' );
$objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( 'B1', 'Position\'s Translation' );


$objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( 'C1', 'Duties in English' );
$objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( 'D1', 'Duties\'s Translation' );

$objPHPExcel->setActiveSheetIndex( 5 )->setTitle( 'NOC' );
$quesArray = $subArray = array();
$quesFound = array();

$rCount = 2;
$count = 2;


$option = mysqli_query( $conn, "select * from noc2" );
while ( $row = mysqli_fetch_assoc( $option ) ) {
  $c = 0;
  $match = 0;
  $matchC = 0;

  $duties = explode( '*', $row[ 'job_duty' ] );
  $positions = explode( '*', $row[ 'job_position' ] );

  foreach ( $duties as $d ) {
    $ques = strtolower( rtrim( ltrim( $d ) ) );

    if ( !in_array( $d, $quesArray ) ) {
      $quesArray[] = $d;
      $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "C" . $rCount, $d );

      $rCount++;
    }

  }
  $c = 0;
  $match = 0;
  $matchC = 0;
  foreach ( $positions as $p ) {
    $ques = strtolower( rtrim( ltrim( $p ) ) );

    if ( !in_array( $p, $subArray ) ) {
      $subArray[] = $p;
      $objPHPExcel->setActiveSheetIndex( 5 )->setCellValue( "A" . $count, $p );

      $count++;
    }
  }


}

//--------------Country-----------------

$objPHPExcel->setActiveSheetIndex( 6 )->setTitle( 'Countries' );

$objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( 'A1', 'Countries in English' );
$objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( 'B1', 'Country\'s Translation' );

$quesArray = $subArray = array();
$quesFound = array();

$rCount = 2;
$count = 2;


$option = mysqli_query( $conn, "select * from countries" );
while ( $row = mysqli_fetch_assoc( $option ) ) {
  $c = 0;
  $match = 0;
  $matchC = 0;

  $d = $row[ 'name' ];
  $ques = strtolower( rtrim( ltrim( $d ) ) );

  if ( !in_array( $d, $quesArray ) ) {
    $quesArray[] = $d;
    $objPHPExcel->setActiveSheetIndex( 6 )->setCellValue( "A" . $rCount, $d );

    $rCount++;
  }


}


function checkValue( $array, $key, $val ) {
  foreach ( $array as $item )
    if ( isset( $item[ $key ] ) && $item[ $key ] == $val )
      return true;
  return false;
}

$objPHPExcel->setActiveSheetIndex( 0 );
$objWriter = PHPExcel_IOFactory::createWriter( $objPHPExcel, "Excel2007" );
ob_end_clean();

header( "Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" );
header( "Content-Disposition: attachment;filename=LatestExcelFile.xlsx" );

header( "Cache-Control: max-age=0" );

$objWriter->save( 'php://output' );

exit;

?>