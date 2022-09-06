<?php
//require_once 'user_inc.php';
$mainQues = mysqli_query($conn, "SELECT * FROM questions WHERE form_id = '10' and question !='' and submission_type = 'after'");
$count = mysqli_num_rows($mainQues);
$quesArr = array();
$quesArr2 = array();
$quesArr3 = array();
$qTotal = 0;
$sTotal = 0;
$qsCount = 0;

$identical_score_ids=array();
$id = 1;

if (mysqli_num_rows($mainQues) > 0) {

    while ($row = mysqli_fetch_array($mainQues)) {

//        if(!in_array($row['question'], $quesArr2))
        {

            $p['question'] = $row['question'];
            $p['type'] = 'main';
            $quesArr3[] = $row['question'] . ' ** ' . $row['notes'];

            $quesArr2[$id]['quest'] = $row['question'];
            $quesArr2[$id]['notes'] = $row['notes'];
            $quesArr2[$id]['quest/notes'] = $row['question'] . ' ** ' . $row['notes'];
            $quesArr2[$id]['page/qid/sid'] = '{' . $row['page'] . ' , ' . $row['id'] . ' , 0 }';

            $id++;

        }

    }
}
$subQues = mysqli_query($conn, "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' AND s.question != '' and s.grade=0 and s.submission_type = 'after'");

if (mysqli_num_rows($subQues) > 0) {
    while ($row = mysqli_fetch_array($subQues)) {

//        if(!in_array($row['question'], $quesArr2))
        {

            $p['question'] = $row['question'];
            $p['type'] = 'sub';
            $quesArr2[$id]['quest'] = $row['question'];
            $quesArr2[$id]['notes'] = $row['notes'];
            $quesArr3[] = $row['question'] . ' ** ' . $row['notes'];
            $quesArr2[$id]['quest/notes'] = $row['question'] . ' ** ' . $row['notes'];
            $quesArr2[$id]['page/qid/sid'] = '{' . $row['page'] . ' , ' . $row['question_id'] . ' , ' . $row['id'] . '}';

            $id++;

        }


    }
}
$vals = array_count_values($quesArr3);
$countr = 3;
$c = 3;

$inD = 0;

$idenArr = array();
foreach ($vals as $k => $v) {

    $arrQuest = '';

    if ($v > 1) {

        foreach ($quesArr2 as $kQ => $kV) {
            if ($k == $kV['quest/notes']) {
                $arrQuest .= $kV['page/qid/sid'] . ' ';

                $idenArr[$inD]['quest'] = $kV['quest'];
                $idenArr[$inD]['notes'] = $kV['notes'];

            }
        }

        $idenArr[$inD]['count'] = $arrQuest;

        $c++;
        $countr++;
        $qsCount++;
        $sTotal += $v;

        $inD++;

    }

}


$c = 1;

foreach ($idenArr as $k => $v) {
    $strRep = '';
    $strRep = str_replace(array("{", "}"), array("", "| "), $v['count']);
    $getIndex = explode("|", $strRep);

    $iden = '';
    $scoreID = '';
    foreach ($getIndex as $qK => $qV) {
        if ($qV !== '') {
            $q = explode(",", $qV);
            $quesID = $q[1];
            $subID = $q[2];


            if ($subID == 0) {
                $getQuesScore = mysqli_query($conn, "SELECT * FROM score_questions WHERE move_qid = '{$quesID}' ");
            } else {
                $getQuesScore = mysqli_query($conn, "SELECT * FROM score_questions WHERE move_qid = '{$subID}' ");
            }


            while ($row = mysqli_fetch_assoc($getQuesScore)) {
                $scoreID .= $row['score_id'] . ',';
            }


        }

    }

    $iden .= $scoreID;
    if ($scoreID !== '') {

        $identical_score_ids[]=$iden;

    }
}

//print_r($identical_score_ids);
?>

