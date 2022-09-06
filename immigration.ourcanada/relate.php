<?php
include_once "global.php";

$mainQuesArray=array();

$select = mysqli_query($conn,"select * from score_questions where relate=0");
while($row=mysqli_fetch_assoc($select))
{
    $select2=mysqli_query($conn,"select * from score_questions where move_qid={$row['id']} and move_qtype='m_question'");
    if(mysqli_num_rows($select2)<=0)
    {
        $s['question_type']='main_question';
        $s['id']=$row['id'];
        $s['question']=$row['question'];
        $mainQuesArray[]=$s;
    }
}



$select = mysqli_query($conn,"select s.* from sub_questions as s join questions as q on s.question_id=q.id where q.form_id=10");
while($row=mysqli_fetch_assoc($select))
{
    $select2=mysqli_query($conn,"select * from score_questions where move_qid={$row['id']} and move_qtype='s_question'");
    if(mysqli_num_rows($select2)<=0)
    {
        $s['question_type']='sub_question';
        $s['id']=$row['id'];
        $s['question_id']=$row['question_id'];
        $s['question']=$row['question'];

        $mainQuesArray[]=$s;
    }
}



print_r($mainQuesArray);
?>