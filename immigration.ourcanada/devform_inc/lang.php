<?php
require_once ( "../global.php" );

// Get Translation for Local Storage
if($_GET['h'] == 'getTranslationArr')
{
    $quesArr = array() ; $optionsArr = array() ; $notesArr = array(); $optionsArr = array() ; $valuesArr = array() ; $oldValues = array();
    $col=$col2='';
    if ( $_GET[ 'Lang' ] == 'english'){
        $col=$col2='';
    }
    else {
        $col='_'.$_GET[ 'Lang' ];
    }

    if($col=='_francais')
    {
        $col='_french';
    }
    else if($col=='_english')
    {
        $col='';
    }

    $arrCount = 0 ; $ntCount = 0 ; $opCount = 0;


    // Labels
    $getQues = mysqli_query($conn , "SELECT * FROM questions where question!='' and question is not null");

    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $quesArr[$arrCount]['label'] = trim($r['question']);
            $quesArr[$arrCount]['label_translation'] = trim($r['question'.$col]);
            $arrCount++;
        }

    }
    $getQues = mysqli_query($conn , "SELECT *  FROM sub_questions  where   question!='' and question is not null");
    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $quesArr[$arrCount]['label'] = trim($r['question']);
            $quesArr[$arrCount]['label_translation'] = trim($r['question'.$col]);
            $arrCount++;
        }

    }
    $getQues = mysqli_query($conn , "SELECT * FROM level2_sub_questions where question!='' and question is not null");

    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $quesArr[$arrCount]['label'] = trim($r['question']);
            $quesArr[$arrCount]['label_translation'] = trim($r['question'.$col]);
            $arrCount++;
        }

    }

    // Notes
    $getQues = mysqli_query($conn , "SELECT * FROM questions where notes!='' and notes is not null");

    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $notesArr[$ntCount]['notes'] = trim($r['notes']);
            $notesArr[$ntCount]['notes_translation'] = trim($r['notes'.$col]);
            $ntCount++;
        }

    }
    $getQues = mysqli_query($conn , "SELECT * FROM sub_questions where notes!='' and notes is not null");

    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $notesArr[$ntCount]['notes'] = trim($r['notes']);
            $notesArr[$ntCount]['notes_translation'] = trim($r['notes'.$col]);
            $ntCount++;
        }

    }
    $getQues = mysqli_query($conn , "SELECT * FROM level2_sub_questions where notes!='' and notes is not null");

    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $notesArr[$ntCount]['notes'] = trim($r['notes']);
            $notesArr[$ntCount]['notes_translation'] = trim($r['notes'.$col]);
            $ntCount++;
        }

    }


    $arrCount = 0 ; $ntCount = 0 ; $opCount = 0;

    // Options
    $getQues = mysqli_query($conn , "SELECT * FROM question_labels where label!='' and label is not null");


    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $optionsArr[] = trim($r['label']);
            $valuesArr[]  = trim($r['label'.$col]);
            $opCount++;
        }

    }
    $getQues = mysqli_query($conn , "SELECT * FROM level1 where label!='' and label is not null");

    if(mysqli_num_rows($getQues) > 0){
        while($r=mysqli_fetch_assoc($getQues))
        {
            $optionsArr[] = trim($r['label']);
            $valuesArr[]  = trim($r['label'.$col]);
            $opCount++;
        }

    }

    //print_r($quesArr);

    countryDropdown();
    educationDropdown();
    die( json_encode( array( 'Success' => 'true', 'questArr' => $quesArr , 'notesArr' => $notesArr,  'ArrCountry' => $countryArray,'ArrEducation'=>$educationArray,'ArrLabels'=>$ArrLabels, 'optionsArr' => $optionsArr ,'oldValues' => $oldValues , 'valuesArr' => $valuesArr ) ) );
}


function checkValue($array, $key, $val) {
    foreach ($array as $item)
        if (isset($item[$key]) && $item[$key] == $val)
            return true;
    return false;
}


function countryDropdown() {
    global $conn,$countryArray;
    $col='_'.$_GET['Lang'];

    if($col=='_francais')
    {
        $col='_french';
    }
    else if($col=='_english')
    {
        $col='';
    }

    $countries = mysqli_query( $conn, "select * from countries" );
    $count = 0;
    while ( $getCountries = mysqli_fetch_assoc( $countries ) ) {
        if($_COOKIE['Lang'] !== 'english' && $_COOKIE['Lang'] !== ''){
            if($getCountries[ 'name'.$col ] !== '' && $getCountries[ 'name'.$col ] !== null)
                $countryArray[ $count ][ 'name' ] = $getCountries[ 'name'.$col ];
        }else{
            $countryArray[ $count ][ 'name' ] = $getCountries[ 'name' ];
        }

        $countryArray[ $count ][ 'value' ] = $getCountries[ 'name' ];
        $count++;
    }
}

function educationDropdown() {
    $col='_'.$_GET['Lang'];

    if($col=='_francais')
    {
        $col='_french';
    }
    else if($col=='_english')
    {
        $col='';
    }
    global $conn,$educationArray;
    $countries = mysqli_query( $conn, "select * from education" );
    $count = 0;
    while ( $getCountries = mysqli_fetch_assoc( $countries ) ) {
        if($_COOKIE['Lang'] !== 'english' && $_COOKIE['Lang'] !== ''){
            if($getCountries[ 'name'.$col ] !== '' && $getCountries[ 'name'.$col ] !== null)
                $educationArray[ $count ][ 'name' ] = $getCountries[ 'name'.$col ];
        }else{
            $educationArray[ $count ][ 'name' ] = $getCountries[ 'name' ];
        }
        $educationArray[ $count ][ 'value' ] = $getCountries[ 'name' ];
        $count++;
    }
}



?>