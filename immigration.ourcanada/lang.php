<?php
require_once ( "user_inc.php" );




// Get Translation for Local Storage

    $quesArr = array() ; $orgQuesArr=array();
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





?>