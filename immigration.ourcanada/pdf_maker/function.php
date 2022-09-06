<?php
include_once( "global.php" );
require_once 'excelClass/PHPExcel.php';

countryDropdown();

 
	 
function loadExcelSheet( $param ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath;

  if ( $param == 'conversion' ) {
    $newLang = $_COOKIE[ 'oldLang' ];
  } else if ( $param == 'transConversion' ) {
    $newLang = $_COOKIE[ 'Lang' ];
  } else {
    if ( $_COOKIE[ 'Lang' ] !== 'english' && $_COOKIE[ 'oldLang' ] !== 'english' && $param == 'NewConversion' ) {
      $newLang = $_COOKIE[ 'Lang' ];
    } else if ( $_COOKIE[ 'Lang' ] !== 'english' && $_COOKIE[ 'oldLang' ] !== 'english' ) {
      $newLang = 'english';
    } else if ( $_COOKIE[ 'Lang' ] == 'english' ) {
      $newLang = $_COOKIE[ 'oldLang' ];
    } else {
      $newLang = $_COOKIE[ 'Lang' ];
    }
  }
  $filePath = '';
  $query = mysqli_query( $conn, "SELECT * FROM `multi-lingual` WHERE lang_slug = '{$newLang}'" );
  $row = mysqli_fetch_assoc( $query );
  $filePath = "../superadmin/uploads/multi_lingual/" . $row[ 'file_name' ];

  $_COOKIE[ 'DISPLAY' ] = $row[ 'display_type' ];
  $objPHPExcel = new PHPExcel();
  $objPHPExcel = PHPExcel_IOFactory::load( $filePath );
  $worksheetList = $objPHPExcel->getSheetNames();

  $objPHPExcel->setActiveSheetIndex( 0 );
  $excelData = $objPHPExcel->getActiveSheet( 0 )->toArray();

  $totRec = sizeof( $excelData );
  $sheet = $objPHPExcel->getSheet( 0 );
  $highest_column = $sheet->getHighestColumn();


}

function countryDropdown() {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  if ( $_COOKIE[ 'Lang' ] !== 'english' ) {
    $countryArray = array();
    $newLang = $_COOKIE[ 'Lang' ];

    $filePath = '';
    $query = mysqli_query( $conn, "SELECT * FROM `multi-lingual` WHERE lang_slug = '{$newLang}'" );
    $row = mysqli_fetch_assoc( $query );
    $filePath = "../superadmin/uploads/multi_lingual/" . $row[ 'file_name' ];

    $_COOKIE[ 'DISPLAY' ] = $row[ 'display_type' ];
    $objPHPExcel = new PHPExcel();
    $objPHPExcel = PHPExcel_IOFactory::load( $filePath );
    $worksheetList = $objPHPExcel->getSheetNames();

    $objPHPExcel->setActiveSheetIndex( 1 );
    $excelData = $objPHPExcel->getActiveSheet( 1 )->toArray();

    $totRec = sizeof( $excelData );
    $sheet = $objPHPExcel->getSheet( 1 );
    $highest_column = $sheet->getHighestColumn();

    $count = 0;
    for ( $i = 2; $i <= $totRec - 1; $i++ ) {
      $countryArray[ $count ][ 'name' ] = $excelData[ $i ][ 1 ];
      $count++;
    }

    // COuntries 
    $countries = mysqli_query( $conn, "select * from countries" );
    $count = 0;
    while ( $getCountries = mysqli_fetch_assoc( $countries ) ) {
      $countryArray[ $count ][ 'value' ] = $getCountries[ 'name' ];
      $count++;
    }

  } else {
    // COuntries 
    $countries = mysqli_query( $conn, "select * from countries" );
    $count = 0;
    while ( $getCountries = mysqli_fetch_assoc( $countries ) ) {
      $countryArray[ $count ][ 'name' ] = $getCountries[ 'name' ];
      $countryArray[ $count ][ 'value' ] = $getCountries[ 'name' ];
      $count++;
    }
  }
}


// Fields Values Conversion From one language to other

if ( $_GET[ 'h' ] == 'valueConversion' ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'conversion' );

  $valTrans = '';
  $title = $_POST[ 'title' ];
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $translation = $excelData[ $i ][ 1 ];
    if ( $title == $translation ) {
      $valTrans = $excelData[ $i ][ 0 ];
    } else {
      if ( $title == $translation . ' ' ) {
        $valTrans = $excelData[ $i ][ 0 ];
      }
    }

    if ( $valTrans != '' ) {
      break;
    }
  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' ) ) );
  }
}

if ( $_GET[ 'h' ] == 'getTranslationConversion' ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'transConversion' );

  $valTrans = $valNotes = '';
  $title = $_POST[ 'title' ];
  $notes = $_POST[ 'notes' ];

  //echo $title;

  $ques = strtolower( rtrim( $_POST[ 'title' ] ) );
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 0 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $_POST[ 'title' ] ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    }

    if ( $valTrans != '' ) {
      break;
    }
  }
  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' ) ) );
  }
}

// Options from one language to other 

if ( $_GET[ 'h' ] == 'optionsConversion' ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'conversion' );

  $valTrans = '';
  $title = rtrim( $_POST[ 'title' ] );
  $fieldType = $_POST[ 'fieldType' ];

  for ( $i = 1; $i <= $totRec - 1; $i++ ) {

    for ( $j = 6; $j < 100; $j += 2 ) {
      $translation = $excelData[ $i ][ $j ];
      if ( $title == $translation ) {
        $valTrans = $excelData[ $i ][ $j - 1 ];
      } else {
        if ( $title == $translation . ' ' ) {
          $valTrans = $excelData[ $i ][ $j - 1 ];
        }
      }

      if ( $valTrans !== '' ) {
        break;
      }

    }
	  
	  if($valTrans !== ''){
		  break;
	  }

  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans, 'File' => $filePath ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file', 'File' => $filePath ) ) );
  }
}

if ( $_GET[ 'h' ] == 'getoptionsConversion' ) {
 global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'transConversion' );

  $valTrans = '';
  $title = rtrim( $_POST[ 'title' ] );
  $fieldType = $_POST[ 'fieldType' ];


  for ( $i = 1; $i <= $totRec - 1; $i++ ) {

    for ( $j = 5; $j < 100; $j += 2 ) {
      $translation = $excelData[ $i ][ $j ];
      if ( $title == $translation ) {
        $valTrans = $excelData[ $i ][ $j + 1 ];
      } else {
        if ( $title == $translation . ' ' ) {
          $valTrans = $excelData[ $i ][ $j + 1 ];
        }
      }
		if($valTrans !== ''){
			  break;
		  }
    }

    if ( $valTrans !== '' ) {
      break;
    }
  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans, 'File' => $filePath ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file', 'File' => $filePath ) ) );
  }
}

if ( $_GET[ 'h' ] == 'getTranslation' ) {

 global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'NewConversion' );

  $valTrans = $valNotes = '';
  $title = $_POST[ 'title' ];

  $ques = strtolower( rtrim( $_POST[ 'title' ] ) );

  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 0 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $_POST[ 'title' ] ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    }

    if ( $valTrans != '' ) {
      break;
    }
  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans, 'File' => $filePath ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file', 'File' => $filePath ) ) );
  }
}

if ( $_GET[ 'h' ] == 'getTranslationOrg' ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( '' );

  $valTrans = '';
  $title = $_POST[ 'title' ];
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $translation = $excelData[ $i ][ 1 ];
    if ( $title == $translation ) {
      $valTrans = $excelData[ $i ][ 0 ];
    } else {
      if ( $title == $translation . ' ' ) {
        $valTrans = $excelData[ $i ][ 0 ];
      }
    }

    if ( $valTrans != '' ) {
      break;
    }
  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' ) ) );
  }
}

if ( $_GET[ 'h' ] == 'customLabel' ) {

  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'NewConversion' );

  $valTrans = '';
  $title = rtrim( $_POST[ 'title' ] );
  $fieldType = $_POST[ 'fieldType' ];

  if ( $_POST[ 'type' ] == 'conversion' ) {
    $cIndex = 5;
    $tIntdex = 6;
	  
	  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
		for ( $j = $cIndex; $j < 100; $j += 2 ) {
			$tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ $j ] ) ) ) );
			if ( preg_replace( '!\s+!', ' ', $title ) == $tr ) {
			  $valTrans = $excelData[ $i ][  $j + 1 ];
			} else if ( preg_replace( '!\s+!', ' ', strtolower( $_POST[ 'title' ] ) ) == $tr ) {
			  $valTrans = $excelData[ $i ][  $j + 1 ];
			} else if ( preg_replace( '!\s+!', ' ', ltrim( $title ) ) == $tr ) {
			  $valTrans = $excelData[ $i ][  $j + 1 ];
			}

			if ( $valTrans != '' ) {
			  break;
			}
		}
		if ( $valTrans != '' ) {
		  break;
		}
	  }
	  
  } else {
    $cIndex = 6;
    $tIntdex = 5;
	  
	  for ( $i = 1; $i <= $totRec - 1; $i++ ) {

    for ( $j = $cIndex ; $j < 100; $j += 2 ) {
      $translation = $excelData[ $i ][ $j ];
      if ( $title == $translation ) {
        $valTrans = $excelData[ $i ][ $j - 1 ];
      } else {
        if ( $title == $translation . ' ' ) {
          $valTrans = $excelData[ $i ][ $j - 1 ];
        }
      }

      if ( $valTrans !== '' ) {
        break;
      }

    }
	  
	  if($valTrans !== ''){
		  break;
	  }

  }
  }

  


  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' ) ) );
  }
}

if ( $_GET[ 'h' ] == 'countryDropdown' ) {
  countryDropdown();
  die( json_encode( array( 'Success' => 'true', 'ArrCountry' => $countryArray ) ) );
}


if ( $_GET[ 'h' ] == 'getNotes' ) {
  
  global $excelData;
  loadExcelSheet( 'NewConversion' );
	

  $ques = strtolower( rtrim( $_POST[ 'title' ] ) );
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 2 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $_POST[ 'title' ] ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    }

    if ( $valTrans != '' ) {
      break;
    }
  }

  /*$title = rtrim($_POST['title']);
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
      $translation = $excelData[$i][2];
      if($title == $translation){
          $valTrans = $excelData[$i][3];
      }else{
          if($title == $translation.' '){
              $valTrans = $excelData[$i][3];
          }else{

          }
      }
  }*/
  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  } else {
    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' ) ) );
  }
}


if ( $_GET[ 'h' ] == 'notesConversion' ) {
  global $excelData;
  loadExcelSheet( 'conversion' );

  $valTrans = '';
  $ques = strtolower( rtrim( $_POST[ 'title' ] ) );
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 3 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
      $valTrans = $excelData[ $i ][ 2 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $_POST[ 'title' ] ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 2 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 2 ];
    }

    if ( $valTrans != '' ) {
      break;
    }
  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  }
  //    else{
  //        die(json_encode(array('Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' , 'File' => $filePath)));
  //    }
}

if ( $_GET[ 'h' ] == 'getnotesConversion' ) {
  global $excelData;
  loadExcelSheet( 'transConversion' );

  $valTrans = '';
  $ques = strtolower( rtrim( $_POST[ 'title' ] ) );
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 2 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $_POST[ 'title' ] ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    }

    if ( $valTrans != '' ) {
      break;
    }
  }

  if ( $valTrans != '' ) {
    die( json_encode( array( 'Success' => 'true', 'Question' => $valTrans ) ) );
  }
  //    else{
  //        die(json_encode(array('Success' => 'false', 'Msg' => 'Translation against this data is not saved in the system. Please double check your translation file' , 'File' => $filePath)));
  //    }
}


function translateVal( $title ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'NewConversion' );
  //$title = trim($title);

    $ques = strtolower( rtrim( $title ) );
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 0 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $title ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 1 ];
    }
    if ( $valTrans != '' ) {
      break;
    }
  }

  return $valTrans;
}

function notesVal( $title ) {
  
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  loadExcelSheet( 'NewConversion' );
	
  $ques = strtolower( rtrim( $title ) );
  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
    $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ 2 ] ) ) ) );
    if ( preg_replace( '!\s+!', ' ', $title ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    } else if ( preg_replace( '!\s+!', ' ', strtolower( $title ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    } else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
      $valTrans = $excelData[ $i ][ 3 ];
    }

    if ( $valTrans != '' ) {
      break;
    }
  }
	
	
 
  return $valTrans;
}

function customLabel( $title, $type ) {
  global $conn, $excelData, $totRec, $objPHPExcel, $worksheetList, $filePath, $countryArray;
  
  loadExcelSheet( 'NewConversion' );
  $totRec = sizeof( $excelData );
  $valTrans = '';
  $title = rtrim( $title );

  if ( $type == 'conversion' ) {
    $cIndex = 5;
    $tIntdex = 6;
  } else {
    $cIndex = 6;
    $tIntdex = 5;
  }

  $ques = strtolower( rtrim( $title ) );

  for ( $i = 1; $i <= $totRec - 1; $i++ ) {
	  for ( $j = $cIndex; $j < 100; $j += 2 ) {
		  $tr = strtolower( ltrim( preg_replace( '!\s+!', ' ', rtrim( $excelData[ $i ][ $j ] ) ) ) );
		if ( preg_replace( '!\s+!', ' ', $ques ) == $tr ) {
		  $valTrans = $excelData[ $i ][ $j + 1  ];
		} else if ( preg_replace( '!\s+!', ' ', strtolower( $title ) ) == $tr ) {
		  $valTrans = $excelData[ $i ][ $j + 1  ];
		} else if ( preg_replace( '!\s+!', ' ', ltrim( $ques ) ) == $tr ) {
		  $valTrans = $excelData[ $i ][ $j + 1  ];
		}
		  
		  if($valTrans !== ''){
			  break;
		  }

	  }
	   if($valTrans !== ''){
		  break;
	  }
    
  }


   return $valTrans;


}

?>