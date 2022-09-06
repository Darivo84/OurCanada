<?php
include_once( "admin_inc.php" );


$getForm = mysqli_query($conn , "SELECT * FROM categories WHERE id  = '{$_GET['id']}'");
$form = mysqli_fetch_assoc($getForm);

$getFormGroups = mysqli_query($conn , "SELECT * FROM form_group");
$frmArr = array();
while($row = mysqli_fetch_assoc($getFormGroups)){
    $frmArr[$row['id']] = $row;
}
$getSubQuestions = mysqli_query($conn , "SELECT * FROM sub_questions");
$squArr = array();
while($row = mysqli_fetch_assoc($getSubQuestions)){
    $squArr[$row['id']] = $row;
}

$getSubQuestions2 = mysqli_query($conn , "SELECT * FROM level2_sub_questions");
$squArr2 = array();
while($row = mysqli_fetch_assoc($getSubQuestions2)){
    $squArr2[$row['id']] = $row;
}

$getFieldType = mysqli_query($conn , "SELECT * FROM field_types");
$sField = array();
while($row = mysqli_fetch_assoc($getFieldType)){
    $sField[$row['id']] = $row;
}
?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

</head>

<body data-topbar="dark" data-layout="horizontal">

<div id="quesPrev">
    <h3><?php echo $form['name']; ?> Form Preview</h3>
    <ul>
        <?php

        $i=0;$j=$k=0;

        $getQuestions = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '{$_GET['id']}' ");
        while($qrow = mysqli_fetch_assoc($getQuestions)) {
            $i++;
            ?>
            <li><b><?php echo $i ?></b><br><?php echo $qrow['question']; ?></li>
            <?php
            $checkCondition = mysqli_query($conn , "SELECT * FROM sub_questions WHERE question_id = '{$qrow['id']}'");
            if(mysqli_num_rows($checkCondition) > 0){

                ?>
                <ul>
                    <?php
                    while($row = mysqli_fetch_assoc($checkCondition)) {
                        $j++;
                        $k=0;
                        $getSubLogics = mysqli_query($conn , "SELECT * FROM ques_logics WHERE s_id = '{$row['id']}'");
                        $fetchLogic = mysqli_fetch_assoc($getSubLogics);
                        $caseType = $row['casetype'];

                        $labelVal = '';
                        if($caseType == 'group'){
                            $labelVal = 'then Move To Group <b>'.$frmArr[$row['group_id']]['title'].'</b>';
                        }
                        else if($caseType == 'movegroup'){
                            $get=mysqli_query($conn,"select * from questions where id={$row['group_ques_id']}");
                            $r=mysqli_fetch_assoc($get);
                            $hidequestion=$r['question'];

                            if($row['questiontype']=='m_question')
                            {
                                $get=mysqli_query($conn,"select * from questions where id={$row['existing_qid']}");
                            }
                            else
                            {
                                $get=mysqli_query($conn,"select * from sub_questions where id={$row['existing_sid']}");
                            }
                            $r=mysqli_fetch_assoc($get);

                            $labelVal = 'then Move To Group <b>'.$frmArr[$row['group_id']]['title'].'</b>';
                            $labelVal.= '<br> but <b>'.$hidequestion.'</b> will be asked if <b>'. $r['question'].'</b> '.$row['group_operator'].' '.$row['value'];
                        }
                        else if($caseType == 'subquestion') {
                            $labelVal = 'then ask question <b>'.$row['question'].'</b>';
                        }
                        else if($caseType == 'existing') {

                            $get='';
                            if($row['questiontype']=='m_question')
                            {
                                $get=mysqli_query($conn,"select * from questions where id={$row['existing_qid']}");
                            }
                            else
                            {
                                $get=mysqli_query($conn,"select * from sub_questions where id={$row['existing_sid']}");
                            }
                            $r=mysqli_fetch_assoc($get);

                            $labelVal = 'then ask question <b>'.$r['question'].'</b>';
                        }
                        else if($caseType == 'existingcheck') {

                            $get='';
                            if($row['questiontype']=='m_question')
                            {
                                $get=mysqli_query($conn,"select * from questions where id={$row['existing_qid']}");
                            }
                            else
                            {
                                $get=mysqli_query($conn,"select * from sub_questions where id={$row['existing_sid']}");
                            }
                            $r=mysqli_fetch_assoc($get);

                            $labelVal = '<br>and if <b>'.$r['question'].'</b> '.$row['group_operator'].' '.$row['value']. '<br> then ask <b>'.$row['question'].'</b>';

                        }
                        else if($caseType == 'multicondition') {

                            $multi = mysqli_query($conn , "SELECT * FROM multi_conditions WHERE s_id = {$row['id']}");
                            $qId=0;
                            while($multiRow = mysqli_fetch_assoc($multi)) {
                                $get = '';
                                if ($multiRow['question_type'] == 'm_question') {
                                    $get = mysqli_query($conn, "select * from questions where id={$multiRow['existing_qid']}");
                                } else {
                                    $get = mysqli_query($conn, "select * from sub_questions where id={$multiRow['existing_sid']}");
                                }
                                $r = mysqli_fetch_assoc($get);

                                $labelVal .= '<br>and if <b>' . $r['question'] . '</b> ' . $multiRow['operator'] . ' ' . $multiRow['value'] ;
                            }
                            $labelVal.='<br>then ask <b>' . $row['question'] . '</b>';
                        }

                            ?>
                            <li><b><?php echo $i.'.'.$j ?></b><br>If <b><?php echo $i ?></b> is <?php echo $fetchLogic['operator']; ?> <?php echo $fetchLogic['value']; ?> <?php echo $labelVal; ?></li>
                        <?php
                        $level2 = mysqli_query($conn , "SELECT * FROM level2_sub_questions WHERE question_id = '{$row['id']}'");
                        if(mysqli_num_rows($level2) > 0) {

                            ?>
                            <ul>
                                <?php
                                while ($row2 = mysqli_fetch_assoc($level2)) {
                                    $k++;
                                    $getSubLogics2 = mysqli_query($conn, "SELECT * FROM level2_ques_logics WHERE s_id = '{$row2['id']}'");
                                    $fetchLogic2 = mysqli_fetch_assoc($getSubLogics2);
                                    $caseType2 = $row2['casetype'];

                                    $labelVal2 = '';
                                    if ($caseType2 == 'group' ) {
                                        $labelVal2 = 'then Move To Group <b>' . $frmArr[$row2['group_id']]['title'] . '</b>';
                                    }
                                    else if($caseType2 == 'movegroup'){
                                        $get=mysqli_query($conn,"select * from questions where id={$row2['group_ques_id']}");
                                        $r=mysqli_fetch_assoc($get);
                                        $hidequestion=$r['question'];

                                        if($row2['questiontype']=='m_question')
                                        {
                                            $get=mysqli_query($conn,"select * from sub_questions where id={$row2['existing_qid']}");
                                        }
                                        else if($row2['questiontype']=='sm_question')
                                        {
                                            $get=mysqli_query($conn,"select * from questions where id={$row2['existing_sqid']}");
                                        }
                                        else
                                        {
                                            $get=mysqli_query($conn,"select * from level2_sub_questions where id={$row2['existing_sid']}");
                                        }
                                        $r=mysqli_fetch_assoc($get);

                                        $labelVal2 = 'then Move To Group <b>'.$frmArr[$row2['group_id']]['title'].'</b>';
                                        $labelVal2.= '<br> but <b>'.$hidequestion.'</b> will be asked if <b>'. $r['question'].'</b> '.$row2['group_operator'].' '.$row2['value'];
                                    }

                                    else if ($caseType2 == 'subquestion') {
                                        $labelVal2 = 'then ask question <b>' . $row2['question'] . '</b>';
                                    }
                                    else if ($caseType2 == 'existing') {

                                        $get = '';
                                        if ($row2['questiontype'] == 'm_question') {
                                            $get = mysqli_query($conn, "select * from sub_questions where id={$row2['existing_qid']}");
                                        }
                                        else  if ($row2['questiontype'] == 'sm_question') {
                                            $get = mysqli_query($conn, "select * from questions where id={$row2['existing_sqid']}");
                                        }
                                        else {
                                            $get = mysqli_query($conn, "select * from level2_sub_questions where id={$row2['existing_sid']}");
                                        }
                                        $r = mysqli_fetch_assoc($get);

                                        $labelVal2 = 'then ask question <b>' . $r['question'] . '</b>';
                                    }
                                    else if ($caseType2 == 'email') {
                                        $labelVal2 = 'then send email. ';
                                    }
                                    else if ($caseType2 == 'end') {
                                        $labelVal2 = 'then end script. ';
                                    }
                                    else if ($caseType2 == 'age') {
                                        $labelVal2 = '<br> and if <b>age</b> '.$row2['group_operator'].' '.$row2['value'].' then end script';
                                    }
                                        ?>

                                    <li><b><?php echo $i.'.'.$j.'.'.$k ?></b><br>If <b><?php echo $i.'.'.$j?></b> is <?php echo $fetchLogic2['operator']; ?> <?php echo $fetchLogic2['value']; ?> <?php echo $labelVal2; ?></li>
                                    <?php
                                }
                                ?>
                            </ul>
                            <?php
                        }
                    }?>
                </ul>
            <?php } ?>
        <?php } ?>
    </ul>
</div>

<?php include_once("includes/script.php"); ?>

</body>
</html>