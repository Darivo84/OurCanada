<?php
include_once( "admin_inc.php" );

if($_GET['method']=='edit')
{
    $qid=$_GET['qid'];
}
else
{
    $qid=$_GET['id'];
}
$getScore = mysqli_query( $conn, "SELECT * FROM score" );

$getQuestion = mysqli_query( $conn, "SELECT * FROM sub_questions WHERE id = $qid" );
$row = mysqli_fetch_assoc( $getQuestion );
$question_id=$row['question_id'];
$sqID=$row['id'];

$getQuestion2 = mysqli_query( $conn, "SELECT * FROM questions WHERE id = $question_id" );
$quesrow = mysqli_fetch_assoc( $getQuestion2 );


$formFields = mysqli_query( $conn, "SELECT * FROM field_types order by label ASC" );
$fArr = array();
while ( $FRow = mysqli_fetch_assoc( $formFields ) ) {
    $fArr[ $FRow[ 'id' ] ] = $FRow;
}

$getAllQuestions=mysqli_query($conn, "SELECT * FROM sub_questions WHERE question_id = $question_id");
$quesArr = array();
while($Row = mysqli_fetch_assoc($getAllQuestions)){
    $quesArr[] = $Row;
}


$getAllForms=mysqli_query($conn, "SELECT * FROM form_group where form_id={$quesrow['form_id']}");


$getAllSubQuestions=mysqli_query($conn, "SELECT * FROM level2_sub_questions WHERE (casetype = 'subquestion' OR casetype = 'existingcheck' OR casetype = 'multicondition') and question_id=$qid");

$squesArr = array();
while($RowS = mysqli_fetch_assoc($getAllSubQuestions)){
    $squesArr[] = $RowS;
}


$getAllMainQuestions=mysqli_query($conn, "SELECT * FROM questions where form_id={$quesrow['form_id']}");

$mainQuesArr = array();
while($RowM = mysqli_fetch_assoc($getAllMainQuestions)){
    $mainQuesArr[] = $RowM;
}
?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>
    <style>
        .customSelect
        {
            display: block;
            width: 100%;
            height: calc(1.5em + .94rem + 2px);
            /*padding: .47rem .75rem;*/
            padding: 3px 0px;
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .
        }
    </style>


</head>

<body data-topbar="dark" data-layout="horizontal">

<!-- Begin page -->
<div id="layout-wrapper">

    <?php include_once("includes/header.php"); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Question</h4>

                            <div class="page-title-right">
                                <?php if($_GET['method'] == 'add' || $_GET['method'] == 'edit') {
                                    ?>
                                    <a href="level2_subques?id=<?php echo $_GET['id'];?>" class="btn btn-warning waves-effect waves-light">Back To Listing</a>

                                    <?php
                                } else {
                                    ?>
                                    <a href="?id=<?php echo $_GET['id'];?>&method=add" class="btn btn-primary waves-effect waves-light" >Add Question/Condition</a>
                                    <a href="javascript:history.go(-1)" class="btn btn-warning waves-effect waves-light">Back To Listing</a>

                                    <?php
                                }?>
                            </div>
                        </div>
                    </div>
                </div>



                <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Delete </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div>
                            <div class="modal-body text-center">
                                <div class="prompt"></div>
                                <div id="deleteBox">
                                    <i class="mdi mdi-alert-outline mr-2"></i>
                                    <h3>Are you sure?</h3>
                                    <p>You won't be able to revert this!</p>
                                </div>
                                <input type="hidden" name="id" id="did">

                                <button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Delete Field</button>
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                            </div>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->


                <div id="questionBlock">
                    <h3>
                        <?php echo $row['question']; ?>
                    </h3>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php if($_GET['method'] == 'add') { ?>
                                    <form method="post" id="validateForm">
                                        <input type="hidden" name="n[question_id]" value="<?php echo $_GET['id'] ?>">

                                        <div class="prompt"></div>
                                        <h4>Logical Condition</h4>
                                        <table class="table table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th>Operator</th>
                                                <th>Value</th>
                                                <th>Case</th>
                                            </tr>
                                            </thead>
                                            <tbody id="appendLabelOld">
                                            <tr>
                                                <td>
                                                    <select name="s[operator]" class="form-control" required>
                                                        <option value="=">=</option>
                                                        <option value="!=">!=</option>
                                                        <option value="<">&lt;</option>
                                                        <option value=">">&gt;</option>
                                                        <option value="<=">&lt;=</option>
                                                        <option value=">=">&gt;=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <?php
                                                    if($fArr[$row[ 'fieldtype' ] ]['type'] == 'radio' && $row['labeltype'] == 0){

                                                        ?>
                                                        <select class="form-control" name="s[value]" required>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
                                                            <option value="None">None</option>
                                                        </select>

                                                    <?php } else{

                                                        $query=mysqli_query($conn,"select * from level1 where question_id=$sqID");
                                                        if ( mysqli_num_rows( $query ) > 0 ) {
                                                            ?>
                                                            <select class="form-control" name="s[value]" required>
                                                                <?php while($r=mysqli_fetch_assoc($query)) { ?>
                                                                    <option value="<?php echo $r['value'] ?>"><?php echo $r['value'] ?></option>
                                                                <?php } ?>
                                                                <option value="None">None</option>
                                                            </select>
                                                            <?php
                                                        }else { ?>
                                                            <input type="text" name="s[value]" class="form-control" required>
                                                        <?php } } ?>
                                                </td>

                                                <td>
                                                    <select class="form-control selectBox" name="s[casetype]" id="casetype" required onchange="changeOption()">
                                                        <option value="" selected disabled>-- Select --</option>
                                                        <option value="existing">Move To Existing Question</option>
                                                        <option value="group">Select Group of Questions</option>
                                                        <option value="groupques">Move To Group Question</option>
                                                        <option value="movegroup">Move To Group With New Condition</option>
                                                        <option value="movescore">Back to Scoring</option>
                                                        <option value="age">Age Limit</option>
                                                        <option value="email">Send Email</option>
                                                        <option value="exit">Exit</option>
                                                        <option value="none">None</option>
                                                        <option value="end">End Only</option>
														<option value="endwt">End with Thank you for your interest in Canada </option>
														<option value="endwc">End with Congratulations and Thank you for your interest in Canada</option>
														<option value="endwa">End with Assistance Message</option>
                                                    </select>
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>

                                        <div id="movescore" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Score ID</label>
                                                        <select class="form-control" name="n[score_id]" required>
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            foreach($getScore as $k=>$v)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $v['id']?>"><?php echo $v['scoreID'].' - '.$v['type'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="existing" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="n[questiontype]" class="form-control"onchange="question_type2('mQues1','sQues1','smQues1',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="sm_question">Super Main Question</option>
                                                            <option value="m_question">Main Question</option>
                                                            <option value="s_question">Sub Question</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="q_lbl" style="display: none">Question</label>
                                                        <div id="smQues1" style="display: none">
                                                            <select name="n[existing_sqid]" class="form-control selectBox questionEx" data-val="sqid" required id=""  onchange="checkAnswer2(this,'sm_question')">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach($mainQuesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>"><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div id="mQues1" style="display: none">
                                                            <select name="n[existing_qid]" class="form-control selectBox" required id="" >
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach($quesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>"><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues1" style="display: none">

                                                            <select name="n[existing_sid]" class="form-control selectBox" id="" required >
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach($squesArr as $kV=>$Vv)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $Vv['id']?>"><?php echo $Vv['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="movegroup" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="n[questiontype]" class="form-control" onchange="question_type2('mQues3','sQues3','smQues3',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="sm_question">Super Main Question</option>

                                                            <option value="m_question">Main Question</option>
                                                            <option value="s_question">Sub Question</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="q_lbl" style="display: none">Question</label>
                                                        <div id="smQues3" style="display: none">
                                                            <select name="n[existing_sqid]" class="form-control selectBox questionEx" data-val="sqid" required id=""  onchange="checkAnswer2(this,'sm_question')">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach($mainQuesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>"><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>

                                                        <div id="mQues3" style="display: none">
                                                            <select name="n[existing_qid]" class="form-control selectBox questionEx" data-val="qid" required id=""  onchange="checkAnswer2(this,'m_question')">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach($quesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>"><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues3" style="display: none">
                                                            <select name="n[existing_sid]" class="form-control selectBox questionEx" data-val="sid" id="" required  onchange="checkAnswer2(this,'s_question')">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach($squesArr as $kV=>$Vv)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $Vv['id']?>"><?php echo $Vv['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck2" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="">Operator</label>
                                                        <select name="n[group_operator]" class="form-control groupInputs" required>
                                                            <option value="=">=</option>
                                                            <option value="!=">!=</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="<=">&lt;=</option>
                                                            <option value=">=">&gt;=</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-sm-6 groupCheck2" style="display: none;">-->
                                                <!--                                                    <div class="form-group" id="groupQuestLabel">-->
                                                <!--                                                        <label>Value</label>-->
                                                <!---->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="col-sm-6 groupCheck2" id="newValue2" style="display: none">
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" name="n[value]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck2" id="existValue2" style="display: none">
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <select name="n[value]" class="form-control">

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck" style="display: none;">
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <select name="n[group_id]" class="form-control groupSelect" required="">
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            $getAllForms2=mysqli_query($conn, "SELECT * FROM form_group where form_id={$quesrow['form_id']}");

                                                            while($gRow = mysqli_fetch_assoc( $getAllForms2 ))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $gRow['id']?>"><?php echo $gRow['title'] ?></option>
                                                                <?php
                                                            }

                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck1" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="">Question</label>
                                                        <select name="n[group_ques_id]" id="groupQuest" class="form-control groupInputs" required >
                                                            <option value="" selected disabled>-- Select --</option>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div id="groupques" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6 groupCheck" >
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <select name="n[group_id]" class="form-control groupSelect" required="">
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            while($gRow = mysqli_fetch_assoc( $getAllForms ))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $gRow['id']?>"><?php echo $gRow['title'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck1" style="display: none">
                                                    <div class="form-group">
                                                        <label class="">Question</label>
                                                        <select name="n[group_ques_id]" id="groupQuest2" class="form-control groupInputs" required >
                                                            <option value="" selected disabled>-- Select --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="group" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <select name="n[group_id]" class="form-control" required="">
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            $getAllForms2=mysqli_query($conn, "SELECT * FROM form_group where form_id={$quesrow['form_id']}");

                                                            while($gRow = mysqli_fetch_assoc( $getAllForms2 ))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $gRow['id']?>"><?php echo $gRow['title'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="email" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" readonly placeholder="info@ourcanada.co" name="n[email]" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea rows="4"  name="n[content]" class="form-control"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Automation Scripts</label>
                                                        <br><br>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="more_ops1" name="n[more_ops]" value="0" checked>
                                                            <label class="custom-control-label" for="more_ops1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="more_ops2" name="n[more_ops]" value="1">
                                                            <label class="custom-control-label" for="more_ops2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="em_more_ops" style="display: none;">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Popup Message for Applicant</label>
                                                        <textarea rows="4" name="n[popup_message]" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Automation Script Email</label>
                                                        <input type="text" name="n[automation_email]" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>CC Email</label>
                                                        <input type="text" name="n[cc]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Email Subject</label>
                                                        <input type="text" name="n[automation_subject]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select name="n[automation_country]" class="form-control">
                                                            <option value="" disabled selected> Select</option>
                                                            <?php

                                                            $countryQuery = "SELECT * FROM countries";
                                                            $queryResultt = mysqli_query($conn, $countryQuery);
                                                            while ($row4 = mysqli_fetch_array($queryResultt)) {
                                                                ?>
                                                                <option value="<?php echo $row4['name']; ?>"><?php echo $row4['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Include User Info</label>
                                                        <br><br>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="user_info1" name="n[user_info]" value="0" checked>
                                                            <label class="custom-control-label" for="user_info1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="user_info2" name="n[user_info]" value="1">
                                                            <label class="custom-control-label" for="user_info2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Send Email to Both ?</label>
                                                        <br><br>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="send_both1" name="n[send_both]" value="0" checked>
                                                            <label class="custom-control-label" for="send_both1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="send_both2" name="n[send_both]" value="1">
                                                            <label class="custom-control-label" for="send_both2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Automation script Email Body</label>
                                                        <textarea rows="4" name="n[content2]" class="form-control"></textarea>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>

                                        <div id="age" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="">Operator</label>
                                                        <select name="n[group_operator]" class="form-control groupInputs" required>
                                                            <option value="=">=</option>
                                                            <option value="!=">!=</option>
                                                            <option value="<">&lt;</option>
                                                            <option value=">">&gt;</option>
                                                            <option value="<=">&lt;=</option>
                                                            <option value=">=">&gt;=</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 " id="" >
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" name="n[value]" class="form-control" required>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Validation Checks</label>
                                                    <select name="n[validation]" class="form-control" required>
                                                        <option value="required">Required</option>
                                                        <option value="optional">Optional</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="radioCheck" name="radioCheck">

                                        <input type="hidden" name="n[status]" value="1">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Add Question/Condition</button>
                                        </div>
                                    </form>
                                <?php }

                                elseif($_GET['method'] == 'edit')
                                {
                                $true=false;
                                $getQues = mysqli_query( $conn, "SELECT * FROM level2_sub_questions WHERE id = '{$_GET['id']}'" );
                                $row1=mysqli_fetch_assoc($getQues);

                                $getLogic = mysqli_query( $conn, "SELECT * FROM level2_ques_logics WHERE s_id = '{$_GET['id']}'" );
                                $row2=mysqli_fetch_assoc($getLogic);

                                $getLevel = mysqli_query( $conn, "SELECT * FROM level2 WHERE question_id = '{$row1['id']}'" );
                                if(mysqli_num_rows($getLevel) > 0)
                                {
//                                    $true=true;
                                }
                                $row3=mysqli_fetch_assoc($getLevel);

                                $getLevel2 = mysqli_query( $conn, "SELECT * FROM level1 WHERE question_id = '{$row1['question_id']}'" );
                                if(mysqli_num_rows($getLevel2) > 0)
                                {
                                    $true=true;
                                }
                                ?>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

                                    <script>
                                        function checkAnswer3(type,id,val) {


                                            if(type == 'm_question' || type == 0){
                                                var url =  "ajax.php?h=getSubQuestion";
                                            }else{
                                                var url =  "ajax.php?h=getSubQuestion2";
                                            }

                                            $.ajax( {
                                                dataType: 'json',
                                                url: url,
                                                type: 'POST',
                                                data: {
                                                    'id': id
                                                },
                                                success: function ( data ) {
                                                    var fieldHTML = '';

                                                    $("#existValue2 select").empty();
                                                    if(data.data.field == 'radio' && data.data.labeltype == 0){
                                                        $("#newValue2").hide();
                                                        var y,n,o;
                                                        if(val=='Yes')
                                                        {
                                                            y='selected'
                                                        }
                                                        else if(val=='No')
                                                        {
                                                            n='selected'
                                                        }
                                                        else
                                                        {
                                                            o='selected'
                                                        }
                                                        fieldHTML += '<option value="Yes"'+y+'>Yes</option><option value="No" '+n+'>No</option><option value="None" '+o+'>None</option>';
                                                        $("#existValue2 select").append(fieldHTML); //Add field html
                                                        $("#existValue2").show();
                                                    }else if(data.Options.length > 0){
                                                        $("#newValue2").hide();

                                                        for(var i=0; i<data.Options.length; i++){
                                                            if(data.Options[i].value !== ''){
                                                                if(data.Options[i].value==val)
                                                                {
                                                                    fieldHTML += '<option value="'+data.Options[i].value+'" selected>'+data.Options[i].value+'</option>';

                                                                }
                                                                else
                                                                {
                                                                    fieldHTML += '<option value="'+data.Options[i].value+'">'+data.Options[i].value+'</option>';

                                                                }
                                                            }
                                                        }
                                                        fieldHTML += '<option value="None">None</option>';
                                                        $("#existValue2 select").append(fieldHTML); //Add field html
                                                        $("#existValue2").show();
                                                    }else{
                                                        fieldHTML += '<option value="#NO#">No Value Assigned</option>';
                                                        // $("#existValue2 select").append(fieldHTML); //Add field html
                                                        $("#existValue2").hide();
                                                        $("#newValue2").show();
                                                    }
                                                }
                                            });

                                        }
                                        function checkAnswer4(type,id,val,row){

                                            var trID = row;

                                            if(type == 'm_question' || type == 0){
                                                var url =  "ajax.php?h=getSubQuestion";
                                            }else{
                                                var url =  "ajax.php?h=getSubQuestion2";
                                            }

                                            $("#"+trID+" #loaderAns").html('<span class="spinner-border spinner-border-sm" role="status"></span>');
                                            $.ajax( {
                                                dataType: 'json',
                                                url: url,
                                                type: 'POST',
                                                data: {
                                                    'id': id
                                                },
                                                success: function ( data ) {
                                                    $("#"+trID+" #loaderAns").html('');
                                                    var fieldHTML = '';

                                                    $("#"+trID+" #existValue select").empty();
                                                    if(data.data.field == 'radio' && data.data.labeltype == 0){
                                                        $("#"+trID+" #newValue").hide();

                                                        var y,n,o;
                                                        if(val=='Yes')
                                                        {
                                                            y='selected'
                                                        }
                                                        else if(val=='No')
                                                        {
                                                            n='selected'
                                                        }
                                                        else
                                                        {
                                                            o='selected'
                                                        }
                                                        fieldHTML += '<option value="Yes"'+y+'>Yes</option><option value="No" '+n+'>No</option><option value="None" '+o+'>None</option>';

                                                        $("#"+trID+" #existValue select").append(fieldHTML); //Add field html
                                                        $("#"+trID+" #existValue").show();
                                                    }else if(data.Options.length > 0){
                                                        $("#"+trID+" #newValue").hide();

                                                        for(var i=0; i<data.Options.length; i++){
                                                            if(data.Options[i].value !== ''){
                                                                if(data.Options[i].value==val)
                                                                {
                                                                    fieldHTML += '<option value="'+data.Options[i].value+'" selected>'+data.Options[i].value+'</option>';

                                                                }
                                                                else
                                                                {
                                                                    fieldHTML += '<option value="'+data.Options[i].value+'">'+data.Options[i].value+'</option>';

                                                                }
                                                            }
                                                        }
                                                        // fieldHTML += '<option value="None">None</option>';
                                                        $("#"+trID+" #existValue select").append(fieldHTML); //Add field html
                                                        $("#"+trID+" #existValue").show();
                                                    }else{
                                                        fieldHTML += '<option value="#NO#">No Value Assigned</option>';
                                                        $("#"+trID+" #existValue select").append(fieldHTML); //Add field html
                                                        $("#"+trID+" #existValue").hide();
                                                        $("#"+trID+" #newValue").show();
                                                    }
                                                }
                                            });
                                        }

                                    </script>

                                    <form method="post" id="validateForm2">
                                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                                        <input type="hidden" name="qid" value="<?php echo $row1['question_id'] ?>">

                                        <div class="prompt"></div>
                                        <h4>Logical Condition</h4>
                                        <table class="table table-bordered dt-responsive nowrap">
                                            <thead>
                                            <tr>
                                                <th>Operator</th>
                                                <th>Value</th>
                                                <th>Case</th>
                                            </tr>
                                            </thead>
                                            <tbody id="appendLabelOld">
                                            <tr>
                                                <td>
                                                    <select name="s[operator]" class="form-control" required>
                                                        <option value="=" <?php if($row1['operator']=='=') echo 'selected';?>>=</option>
                                                        <option value="<" <?php if($row1['operator']=='<') echo 'selected';?>>&lt;</option>
                                                        <option value=">" <?php if($row1['operator']=='>') echo 'selected';?>>&gt;</option>
                                                        <option value="<=" <?php if($row1['operator']=='<=') echo 'selected';?>>&lt;=</option>
                                                        <option value=">=" <?php if($row1['operator']=='>=') echo 'selected';?>>&gt;=</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control" name="s[value]" required>
                                                        <?php
                                                        $t=false;
                                                        if($true==true)
                                                        {
                                                            while($r=mysqli_fetch_assoc($getLevel2))
                                                            {
                                                                if($row1['value']==$r['value'] || $row2['value']==$r['value']) {$t=true; }
                                                                ?>
                                                                <option <?php echo $row1['value'] ?> value="<?php echo $r['value'] ?>" <?php if($row1['value']==$r['value'] || $row2['value']==$r['value']) { echo 'selected'; } ?>><?php echo $r['value'] ?></option>

                                                                <?php
                                                            }
                                                            ?>
                                                            <option value="None" <?php if(!$t) { echo 'selected'; } ?>>None</option>

                                                            <?php
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <option value="Yes" <?php if($row2['value']=='Yes') { echo 'selected'; } ?>>Yes</option>
                                                            <option value="No" <?php if($row2['value']=='No') { echo 'selected'; } ?>>No</option>
                                                            <option value="None" <?php if($row2['value']=='None') { echo 'selected'; } ?>>None</option>
                                                        <?php } ?>
                                                    </select>
                                                </td>

                                                <td>
                                                    <select class="form-control selectBox" name="s[casetype]" id="casetype" required onchange="changeOption()">
                                                        <option value="existing" <?php if($row1['casetype']=='existing') echo 'selected';?>>Move To Existing Question</option>
                                                        <option value="group" <?php if($row1['casetype']=='group') echo 'selected';?>>Select Group of Questions</option>
                                                        <option value="groupques" <?php if($row1['casetype']=='groupques') echo 'selected';?>>Move to a Group Question</option>

                                                        <option value="movegroup" <?php if($row1['casetype']=='movegroup') echo 'selected';?>>Move to a Group with New Conditon</option>
                                                        <option value="age" <?php if($row1['casetype']=='age') echo 'selected';?>>Age Limit</option>
                                                        <option value="movescore" <?php if($row1['casetype']=='movescore') echo 'selected';?>>Back to Scoring</option>

                                                        <option value="email" <?php if($row1['casetype']=='email') echo 'selected';?>>Send Email</option>
                                                        <option value="exit" <?php if($row1['casetype']=='exit') echo 'selected';?>>Exit</option>
                                                        <option value="none" <?php if($row1['casetype']=='none') echo 'selected';?>>None</option>
                                                    
														<option value="end" <?php if ($row1['casetype'] == 'end') echo 'selected'; ?>>End Only</option>
														
														<option value="endwt" <?php if ($row1['casetype'] == 'endwt') echo 'selected'; ?>>End with Thank you for your interest in Canada </option>
														<option value="endwc" <?php if ($row1['casetype'] == 'endwc') echo 'selected'; ?>>End with Congratulations and Thank you for your interest in Canada 

</option>
														<option value="endwa" <?php if ($row1['casetype'] == 'endwa') echo 'selected'; ?>>End with Assistance Message</option>
														
                                                    </select>
                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                        <div id="movescore" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Score ID</label>
                                                        <select class="form-control" name="n[score_id]" required>
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            foreach($getScore as $k=>$v)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $v['id']?>" <?php if($row1['score_id']==$v['id']) echo 'selected';?>><?php echo $v['scoreID'].' - '.$v['type'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="age" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="">Operator</label>
                                                        <select name="n[group_operator]" class="form-control groupInputs" required>
                                                            <option value="=" <?php if($row1['group_operator']=='=') echo 'selected';?>>=</option>
                                                            <option value="!=" <?php if($row1['group_operator']=='!=') echo 'selected';?>>=</option>
                                                            <option value="<" <?php if($row1['group_operator']=='<') echo 'selected';?>>&lt;</option>
                                                            <option value=">" <?php if($row1['group_operator']=='>') echo 'selected';?>>&gt;</option>
                                                            <option value="<=" <?php if($row1['group_operator']=='<=') echo 'selected';?>>&lt;=</option>
                                                            <option value=">=" <?php if($row1['group_operator']=='>=') echo 'selected';?>>&gt;=</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 " id="" >
                                                    <div class="form-group">
                                                        <label>Value</label>
                                                        <input type="text" name="n[value]" class="form-control" value="<?php echo $row1['value'] ?>" required>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>


                                        <div id="existing" class="optionsDiv">

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="n[questiontype]" class="form-control" onchange="question_type2('mQues2','sQues2','smQues2',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="sm_question" <?php if($row1['questiontype']=='sm_question') echo 'selected' ?>>Super Main Question</option>

                                                            <option value="m_question" <?php if($row1['questiontype']=='m_question') echo 'selected' ?>>Main Question</option>
                                                            <option value="s_question" <?php if($row1['questiontype']=='s_question') echo 'selected' ?>>Sub Question</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="q_lbl">Question</label>

                                                        <div id="smQues2"  <?php if($row1['existing_sqid']!='' && $row1['casetype']=='existing') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                            <select name="n[existing_sqid]" class="form-control selectBox" required id="" onchange="checkAnswer2(this,'sm_question')">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach($mainQuesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['existing_sqid']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>


                                                        <div id="mQues2"  <?php if($row1['existing_qid']!='' && $row1['casetype']=='existing') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                            <select name="n[existing_qid]" class="form-control selectBox" required id="" onchange="checkAnswer2(this,'m_question')">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach($quesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['existing_qid']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <?php

                                                        if($row1['existing_sid']!='' && $row1['casetype']=='existing') {
                                                            echo '<script> checkAnswer3("s_question","'.$row1['existing_sid'].'","'.$row1['value'].'")</script>';
                                                        }
                                                        elseif($row1['existing_qid']!='' && $row1['casetype']=='existing') {
                                                            echo '<script> checkAnswer3("m_question","'.$row1['existing_qid'].'","'.$row1['value'].'")</script>';
                                                        }
                                                        ?>
                                                        <div id="sQues2" <?php if($row1['existing_sid']!='' && $row1['casetype']=='existing') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                            <select name="n[existing_sid]" class="form-control selectBox" id="" required onchange="checkAnswer2(this,'s_question')">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach($squesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['existing_sid']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div id="groupques" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6 groupCheck" >
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <select name="n[group_id]" class="form-control groupSelect" required="">
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            while($gRow = mysqli_fetch_assoc( $getAllForms ))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $gRow['id']?>" <?php if($row1['group_id']==$gRow['id']) echo 'selected' ?>><?php echo $gRow['title'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck1" >
                                                    <div class="form-group">
                                                        <label class="">Question</label>
                                                        <select name="n[group_ques_id]" id="groupQuest2" class="form-control groupInputs" required >
                                                            <?php
                                                            foreach($mainQuesArr as $k=>$v)
                                                            {
                                                                if($v['group_id']==$row1['group_id'])
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['group_ques_id']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="movegroup" class="optionsDiv">

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="n[questiontype]" class="form-control" onchange="question_type2('mQues3','sQues3','smQues3',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="sm_question" <?php if($row1['questiontype']=='sm_question') echo 'selected' ?>>Super Main Question</option>

                                                            <option value="m_question" <?php if($row1['questiontype']=='m_question') echo 'selected' ?>>Main Question</option>
                                                            <option value="s_question" <?php if($row1['questiontype']=='s_question') echo 'selected' ?>>Sub Question</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck2">
                                                    <div class="form-group">
                                                        <label class="q_lbl">Question</label>
                                                        <div id="smQues3"  <?php if($row1['existing_sqid']!='' && $row1['casetype']=='movegroup') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                            <select name="n[existing_sqid]" class="form-control selectBox questionEx" data-val="sqid" required id="" onchange="checkAnswer2(this,'sm_question')">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach($mainQuesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['existing_sqid']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="mQues3"  <?php if($row1['existing_qid']!='' && $row1['casetype']=='movegroup') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                            <select name="n[existing_qid]" class="form-control selectBox questionEx" data-val="qid" required id="" onchange="checkAnswer2(this,'m_question')">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach($quesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['existing_qid']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues3" <?php if($row1['existing_sid']!='' && $row1['casetype']=='movegroup') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                            <select name="n[existing_sid]" class="form-control selectBox questionEx" data-val="sid" id="" required  onchange="checkAnswer2(this,'s_question')">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach($squesArr as $k=>$v)
                                                                {
                                                                    ?>
                                                                    <option value="<?php echo $v['id']?>" <?php if($row1['existing_sid']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck2" >
                                                    <div class="form-group">
                                                        <label class="">Operator</label>
                                                        <select name="n[group_operator]" class="form-control groupInputs" required>
                                                            <option value="=" <?php if($row1['group_operator']=='=') echo 'selected';?>>=</option>
                                                            <option value="!=" <?php if($row1['group_operator']=='!=') echo 'selected';?>>=</option>
                                                            <option value="<" <?php if($row1['group_operator']=='<') echo 'selected';?>>&lt;</option>
                                                            <option value=">" <?php if($row1['group_operator']=='>') echo 'selected';?>>&gt;</option>
                                                            <option value="<=" <?php if($row1['group_operator']=='<=') echo 'selected';?>>&lt;=</option>
                                                            <option value=">=" <?php if($row1['group_operator']=='>=') echo 'selected';?>>&gt;=</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck2" >
                                                    <div class="form-group" id="groupQuestLabel">
                                                        <label>Value</label>
                                                        <?php
                                                        $ques_lbl_id=0;
                                                        $checkQues='';
                                                        $insert='';
                                                        if($row1['questiontype']=='m_question')
                                                        {
                                                            $ques_lbl_id=$row1['existing_qid'];
                                                            $checkQues=mysqli_query($conn,"select * from sub_questions where id=$ques_lbl_id");
                                                            $insert = mysqli_query($conn, "select * from level1 where question_id=$ques_lbl_id and value!=''");
                                                        }
                                                        else if($row1['questiontype']=='sm_question')
                                                        {
                                                            $ques_lbl_id=$row1['existing_sqid'];
                                                            $checkQues=mysqli_query($conn,"select * from questions where id=$ques_lbl_id");
                                                            $insert = mysqli_query($conn, "select * from question_labels where question_id=$ques_lbl_id and value!=''");
                                                        }
                                                        else
                                                        {
                                                            $ques_lbl_id=$row1['existing_sid'];
                                                            $checkQues=mysqli_query($conn,"select * from level2_sub_questions where id=$ques_lbl_id");
                                                            $insert = mysqli_query($conn, "select * from level2 where question_id=$ques_lbl_id and value!=''");

                                                        }
                                                        $getq=mysqli_fetch_assoc($checkQues);

                                                        if(($getq['labeltype']==1 && $getq['fieldtype']==1) || $getq['fieldtype']==7)
                                                        {

                                                            if(mysqli_num_rows($insert)>0)
                                                            {
                                                                $html .='<select class="form-control groupInputs" name="n[value]" required>';

                                                                while ($rowww = mysqli_fetch_assoc($insert)) {
                                                                    if($row1['value']==$rowww['value'])
                                                                    {
                                                                        $html .= '<option value="'.$rowww['value'].'" selected>'.$rowww['label'].'</option>';
                                                                    }
                                                                    else
                                                                    {
                                                                        $html .= '<option value="'.$rowww['value'].'">'.$rowww['label'].'</option>';

                                                                    }
                                                                }
                                                                $html .='</select>';
                                                                echo $html;
                                                            }
                                                        }
                                                        else if($getq['fieldtype']==1 && $getq['labeltype']==0)
                                                        {
                                                            $html .='<select class="form-control groupInputs" name="n[value]" required>';
                                                            if($row1['value']=='Yes')
                                                            {
                                                                $y='selected';
                                                            }
                                                            else
                                                            {
                                                                $n='selected';
                                                            }
                                                            $html .= '<option value="Yes" '.$y.'>Yes</option>';
                                                            $html .= '<option value="No" '.$n.'>No</option>';
                                                            $html .='</select>';
                                                            echo $html;

                                                        }
                                                        else
                                                        {
                                                            $html.='<input required type="text" name="n[value]" class="form-control groupInputs" value="'.$row1['value'].'">';
                                                            echo $html;

                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 groupCheck">
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <select name="n[group_id]" class="form-control groupSelect" required="">

                                                            <?php
                                                            $getAllForms2=mysqli_query($conn, "SELECT * FROM form_group where form_id={$quesrow['form_id']}");

                                                            while($gRow = mysqli_fetch_assoc( $getAllForms2 ))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $gRow['id']?>" <?php if($row1['group_id']==$gRow['id']) echo 'selected' ?>><?php echo $gRow['title'] ?></option>
                                                                <?php
                                                            }

                                                            ?>

                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 groupCheck1" >
                                                    <div class="form-group">
                                                        <label class="">Question</label>
                                                        <select name="n[group_ques_id]" id="groupQuest" class="form-control groupInputs" required >
                                                            <?php
                                                            $getAllQuestions2=mysqli_query($conn, "SELECT * FROM questions WHERE group_id = '{$row1['group_id']}'");
                                                            $quesArr2 = array();
                                                            while($Row2 = mysqli_fetch_assoc($getAllQuestions2)){
                                                                $quesArr2[] = $Row2;
                                                            }
                                                            foreach($quesArr2 as $k=>$v)
                                                            {
                                                                ?>
                                                                <option value="<?php echo $v['id']?>" <?php if($row1['group_ques_id']==$v['id']) echo 'selected' ?>><?php echo $v['question'] ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>

                                        <div id="group" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Group</label>
                                                        <select name="n[group_id]" class="form-control" required="">
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            $getAllForms2=mysqli_query($conn, "SELECT * FROM form_group where form_id={$quesrow['form_id']}");

                                                            while($gRow = mysqli_fetch_assoc( $getAllForms2 ))
                                                            {
                                                                ?>
                                                                <option value="<?php echo $gRow['id']?>" <?php if($row1['group_id']==$gRow['id']) echo 'selected' ?>><?php echo $gRow['title'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="email" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" readonly placeholder="info@ourcanada.co" name="n[email]" class="form-control" value="<?php echo $row1['email'] ?>">
                                                    </div>
                                                </div>

                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea rows="4" name="n[content]" class="form-control"><?php echo $row1['content'] ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Automation Scripts</label>
                                                        <br><br>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="more_ops1" name="n[more_ops]" value="0" checked>
                                                            <label class="custom-control-label" for="more_ops1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="more_ops2" name="n[more_ops]" <?php if ($row1['more_ops'] == "1") {
                                                                echo "checked";
                                                            } ?> value="1">
                                                            <label class="custom-control-label" for="more_ops2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row" id="em_more_ops" style="display: none;">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Popup Message for Applicant</label>
                                                        <textarea rows="4" name="n[popup_message]" class="form-control"><?php echo $row1['popup_message']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Automation Script Email</label>
                                                        <input type="text" value="<?php echo $row1['automation_email']; ?>" name="n[automation_email]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>CC Email</label>
                                                        <input type="text" value="<?php echo $row1['cc']; ?>" name="n[cc]" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Email Subject</label>
                                                        <input type="text" name="n[automation_subject]" value="<?php echo $row1['automation_subject']; ?>" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Country</label>
                                                        <select name="n[automation_country]" class="form-control">
                                                            <option value="" disabled selected> Select</option>
                                                            <?php

                                                            $countryQuery = "SELECT * FROM countries";
                                                            $queryResultt = mysqli_query($conn, $countryQuery);
                                                            while ($row4 = mysqli_fetch_array($queryResultt)) {
                                                                ?>
                                                                <option <?php if ($row1['automation_country'] == $row4['name']) {
                                                                    echo "selected";
                                                                }  ?> value="<?php echo $row4['name']; ?>"><?php echo $row4['name']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Include User Info</label>
                                                        <br><br>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="user_info1" name="n[user_info]" value="0" <?php if ($row1['user_info'] == 0) {echo "checked"; } ?>>
                                                            <label class="custom-control-label" for="user_info1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="user_info2" name="n[user_info]" value="1" <?php if ($row1['user_info'] == 1) {echo "checked"; } ?>>
                                                            <label class="custom-control-label" for="user_info2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Send Email to Both ?</label>
                                                        <br><br>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="send_both1" name="n[send_both]" value="0" <?php if ($row1['send_both'] == 0) {echo "checked"; } ?>>
                                                            <label class="custom-control-label" for="send_both1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input more_pos" id="send_both2" name="n[send_both]" value="1" <?php if ($row1['send_both'] == 1) {echo "checked"; } ?>>
                                                            <label class="custom-control-label" for="send_both2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Automation script Email body</label>
                                                        <textarea rows="4"  name="n[content2]" class="form-control"><?php echo $row1['content2']; ?></textarea>
                                                    </div>
                                                </div>





                                            </div>
                                        </div>

                                        <div id="multicondition" class="optionsDiv">
                                            <table class="table table-bordered dt-responsive nowrap">
                                                <thead>
                                                <tr>
                                                    <th style="width: 28%">Question Type</th>
                                                    <th style="width: 28%">Question</th>
                                                    <th style="width: 16%">Operator</th>
                                                    <th style="width: 28%">Value</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="appendQuesType">
                                                <?php
                                                $i=0;
                                                $getLabels = mysqli_query($conn , "SELECT * FROM level2_multi_conditions WHERE s_id = '{$_GET['id']}'");
                                                while($fLabel = mysqli_fetch_assoc($getLabels)){
                                                    ?>
                                                    <tr <?php if($i==0) { ?> id="trCount" <?php } else { echo 'id="trCount'.$i.'"';  } ?>>
                                                        <td>
                                                            <select name="c[question_type][]" class="form-control question_type">
                                                                <option value="">-- Select Question Type --</option>
                                                                <option value="m_question" <?php if($fLabel['question_type']=='m_question') echo 'selected' ?>>Main Question</option>
                                                                <option value="s_question" <?php if($fLabel['question_type']=='s_question') echo 'selected' ?>>Sub Question</option>
                                                            </select>
                                                        </td>
                                                        <?php

                                                        if($fLabel['existing_sid']!=0 && $row1['casetype']=='multicondition') {
                                                            echo '<script> checkAnswer4("s_question","'.$fLabel['existing_sid'].'","'.$fLabel['value'].'","trCount'.$i.'")</script>';
                                                        }
                                                        elseif($fLabel['existing_qid']!=0 && $row1['casetype']=='multicondition') {
                                                            echo '<script> checkAnswer4("m_question","'.$fLabel['existing_qid'].'","'.$fLabel['value'].'")</script>';
                                                        }
                                                        ?>
                                                        <td>
                                                            <div class="m_question" <?php if($fLabel['existing_qid']!=0 && $row1['casetype']=='multicondition') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                                <select name="d[existing_qid][]" class="form-control" id="existing_qid" required="" onChange="checkAnswer(this,'m_question')" data-type="m_question">
                                                                    <option value="" selected disabled>-- Select --</option>
                                                                    <?php
                                                                    foreach($quesArr as $k=>$v)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $v['id']?>" <?php if($v['id']==$fLabel['existing_qid']) { echo 'selected' ;} ?>><?php echo $v['question'] ?></option>
                                                                        <?php
                                                                    }

                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <div class="s_question" <?php if($fLabel['existing_sid']!=0 && $row1['casetype']=='multicondition') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                                <select name="c[existing_sid][]" class="form-control" id="existing_sid" required="" onChange="checkAnswer(this,'s_question')" data-type="s_question">
                                                                    <option value="" selected disabled>-- Select --</option>
                                                                    <?php
                                                                    foreach($squesArr as $k=>$v)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo $v['id']?>" <?php if($v['id']==$fLabel['existing_sid']) { echo 'selected' ;} ?>><?php echo $v['question'] ?></option>
                                                                        <?php
                                                                    }

                                                                    ?>
                                                                </select>

                                                            </div>
                                                            <p id="loaderAns"></p>
                                                        </td>
                                                        <td>
                                                            <select name="c[operator][]" class="form-control" required>
                                                                <option value="=" <?php if($fLabel['operator']=='=') echo 'selected';?>>=</option>
                                                                <option value="<" <?php if($fLabel['operator']=='<') echo 'selected';?>>&lt;</option>
                                                                <option value=">" <?php if($fLabel['operator']=='>') echo 'selected';?>>&gt;</option>
                                                                <option value="<=" <?php if($fLabel['operator']=='<=') echo 'selected';?>>&lt;=</option>
                                                                <option value=">=" <?php if($fLabel['operator']=='>=') echo 'selected';?>>&gt;=</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div id="newValue" >
                                                                <input type="text" name="c[value][]" class="form-control" value="<?php echo $fLabel['value']; ?>">
                                                            </div>
                                                            <div id="existValue" style="display: none">

                                                                <select name="d[value][]" class="form-control">

                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                    </tr>

                                                    <?php $i++; } ?>
                                                </tbody>
                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="button" class="btn btn-info btn-sm" id="addMoreMulti">Add More</button>
                                                </div>
                                            </div>
                                        </div>


                                        <div id="subquestion" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="title">Question</label>
                                                        <input type="text" class="form-control" name="n[question]" placeholder="Title" required="" value="<?php echo $row1['question']?>">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Field Type</label>
                                                        <select class="form-control" name="n[fieldtype]" id="fieldtype" onChange="GenLabel('edit')">
                                                            <?php foreach($fArr as $k=>$V){ ?>
                                                                <option value="<?php echo $V['id']; ?>" <?php if($row1['fieldtype'] == $V['id']) { echo 'selected'; } ?>><?php echo $V['label']; ?></option>


                                                            <?php } ?>
                                                        </select>
                                                        <p id="loader"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="radioFields" <?php if($row1['fieldtype'] == 1) { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
                                                <div class="form-group">
                                                    <label for="title">Select Label Type</label><br>
                                                    <input type="radio" name="n[labeltype]" class="labelType" value="0" <?php if($row1['labeltype']==0) echo 'checked' ?>><span class="radioLabels">Use Default Labels</span>
                                                    <input type="radio" name="n[labeltype]" class="labelType" value="1" <?php if($row1['labeltype']==1) echo 'checked' ?>><span class="radioLabels">Create Custom Labels</span>
                                                </div>
                                            </div>
                                            <div id="labelDefaultBox" <?php if($row1['fieldtype'] == 1 && $row1['labeltype'] == 0) { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>

                                                <table class="table table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Label</th>
                                                        <th>Value</th>
                                                        <th>Status</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" value="Yes" name="k[label][]" class="form-control" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" value="Yes" name="k[value][]"  class="form-control" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" value="Enable" name="k[status][]" class="form-control" readonly>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="text" value="No" name="k[label][]" class="form-control" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" value="No" name="k[value][]" class="form-control" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" value="Enable"  name="k[status][]" class="form-control" readonly>
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                </table>

                                            </div>
                                            <div id="labelTypeBox" <?php if($row1['fieldtype'] == 1 && $row1['labeltype'] == 1 || $row1['fieldtype'] == 4 || $row1['fieldtype'] == 7) { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>  class="egenLabels">
                                                <table class="table table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Label</th>
                                                        <th>Value</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="appendLabel" class="EappendLabel">
                                                    <?php
                                                    $getLabels = mysqli_query($conn , "SELECT * FROM level2 WHERE question_id = '{$_GET['id']}'");
                                                    while($fLabel = mysqli_fetch_assoc($getLabels)){
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="m[label][]" value="<?php echo $fLabel['label']; ?>" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="m[value][]" value="<?php echo $fLabel['value']; ?>" class="form-control">
                                                            </td>
                                                            <td>
                                                                <select name="m[status][]" class="form-control" required>
                                                                    <option value="1" <?php if($fLabel['status'] == 1) { echo 'selected'; } ?>>Enable</option>
                                                                    <option value="0" <?php if($fLabel['status'] == 0) { echo 'selected'; } ?>>Disable</option>

                                                                </select>
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a>

                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>

                                                <div class="row">
                                                    <div class="col-sm-12 text-right">
                                                        <button type="button" class="btn btn-info btn-sm" id="addMoreLabel">Add More</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!--										<div class="row">-->
                                        <!--											<div class="col-sm-12">-->
                                        <!--												<div class="form-group">-->
                                        <!--													<label for="title">Notes</label>-->
                                        <!--													<input type="text" name="n[notes]" class="form-control" value="--><?php //echo $row1['notes']; ?><!--">-->
                                        <!--												</div>-->
                                        <!--											</div>-->
                                        <!--										</div>-->

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Status</label>
                                                    <select name="n[status]" class="form-control" required>
                                                        <option value="1" <?php if($row1['status']==1) echo 'selected' ?>>Enable</option>
                                                        <option value="0" <?php if($row1['status']==0) echo 'selected' ?>>Disable</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Validation Checks</label>
                                                    <select name="n[validation]" class="form-control" required>
                                                        <option value="required" <?php if($row1['validation']=='required') echo 'selected'; ?>>Required</option>
                                                        <option value="optional" <?php if($row1['validation']=='optional') echo 'selected'; ?>>Optional</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Update Question/Condtion</button>

                                            <input type="hidden" id="radioCheck" name="radioCheck">
                                        </div>
                                    </form>


                                <?php }
                                else { ?>
                                    <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Value</th>
                                            <th>Case Type</th>
                                            <th style="width: 45% !important">Title</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $getQuery = mysqli_query( $conn, "SELECT * FROM level2_sub_questions WHERE question_id = {$_GET['id']}" );
                                        $count = 1;
                                        while ( $Row = mysqli_fetch_assoc( $getQuery ) ) {
                                            ?>

                                            <tr>
                                                <td>
                                                    <?php echo $count; ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $query=mysqli_query($conn,"select * from level2_ques_logics where s_id={$Row['id']}");
                                                    $r=mysqli_fetch_assoc($query);
                                                    echo $r['value'];
                                                    ?>
                                                </td>
                                                <td style="text-transform: capitalize">
                                                    <?php echo $Row['casetype']; ?>

                                                </td>
                                                <td>
                                                    <?php
                                                    $c=$Row['casetype'];

                                                    if($c=='existing')
                                                    {
                                                        $query=mysqli_query($conn,"select * from sub_questions where id={$Row['existing_qid']}");
                                                        $r=mysqli_fetch_assoc($query);
                                                        echo $r['question'];
                                                    }
                                                    if($c=='group' || $c=='movegroup')
                                                    {
                                                        $query=mysqli_query($conn,"select * from sub_questions where id={$Row['question_id']}");
                                                        $r=mysqli_fetch_assoc($query);
                                                        $q=$r['question_id'];
                                                        $query=mysqli_query($conn,"select * from questions where id=$q");
                                                        $r=mysqli_fetch_assoc($query);
                                                        $query2=mysqli_query($conn,"select * from form_group where id={$Row['group_id']}");
                                                        $r2=mysqli_fetch_assoc($query2);
                                                        $form=$r['form_id'];
                                                        $group=$r2['id'];
                                                        echo '<a style="color:black" href="/admin/questions?id='.$form.'&group_id='.$group.'">'.$r2['title'].'</a>';
                                                    }
                                                    if($c=='subquestion' || $c=='existingcheck' || $c=='multicondition')
                                                    {
                                                        echo $Row['question'];
                                                    }

                                                    else
                                                    {
                                                        echo '';
                                                    }


                                                    ?>
                                                </td>

                                                <td>
                                                    <?php if($Row['status'] == 1) { echo '<span class="badge badge-warning">Enable</span>'; } else { echo '<span class="badge badge-danger">Disable</span>'; } ?>
                                                </td>
                                                <td>
                                                    <?php echo $Row['created_date']; ?>
                                                </td>
                                                <td>
                                                    <a href="?method=edit&id=<?php echo $Row['id']; ?>&qid=<?php echo $Row['question_id'] ?>"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>

                                                    <a href="javascript:void(0)" onClick="DeleteModal(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                            <?php $count++; } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



        <?php include_once("includes/footer.php"); ?>

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->


<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Add Logical Condition</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body">
                <form method="post" id="EvalidateForm">
                    <table class="table table-bordered dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>Operator</th>
                            <th>Value</th>
                            <th>Question</th>
                            <th>Field Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody id="appendLabel12">

                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-info btn-sm" id="addMoreLabel">Add More</button>
                        </div>
                    </div>

                    <input type="hidden" name="s_id" id="s_id">

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update Field</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php include_once("includes/script.php"); ?>
<script>


    $( document ).on( 'click', '.question_type', function ( e ) {
        var question_type = $(this).val();
        var $row = $(this).parent().parent();
        var $tds = $row.find("td:nth-child(2)");

        if(question_type == 'm_question'){
            $tds.children(".m_question").show();
            $tds.children(".s_question").hide();
            $tds.children(".sm_question").hide();

        }
        else  if(question_type == 'sm_question'){
            $tds.children(".sm_question").show();
            $tds.children(".s_question").hide();
            $tds.children(".m_question").hide();
        }
        else{
            $tds.children(".s_question").hide();
            $tds.children(".m_question").hide();
            $tds.children(".s_question").show();
        }
    });
    function question_type(main,sub,value)
    {
        $('.q_lbl').show()
        if($(value).val() == 'm_question'){
            $("#"+main).show();
            $("#"+sub).hide();
            $("#"+sub).attr('disabled',true);
            $("#"+main).attr('disabled',false);


        }else{
            $("#"+main).hide();
            $("#"+sub).show();
            $("#"+sub).attr('disabled',false);
            $("#"+main).attr('disabled',true);
        }
    }
    function question_type2(main,sub,smain,value)
    {
        $('.q_lbl').show()
        if($(value).val() == 'm_question'){
            $("#"+main).show();
            $("#"+main).attr('disabled',false);

            $("#"+sub).hide();
            $("#"+sub).attr('disabled',true);

            $("#"+smain).hide();
            $("#"+smain).attr('disabled',true);

        }
        else if($(value).val() == 'sm_question'){
            $("#"+smain).show();
            $("#"+smain).attr('disabled',false);

            $("#"+sub).hide();
            $("#"+sub).attr('disabled',true);

            $("#"+main).hide();
            $("#"+main).attr('disabled',true);

        }
        else{
            $("#"+main).hide();
            $("#"+sub).show();
            $("#"+sub).attr('disabled',false);
            $("#"+main).attr('disabled',true);

            $("#"+smain).hide();
            $("#"+smain).attr('disabled',true);
        }
    }

    function changeOption() {
        let type=$('#casetype').val();
        $('.optionsDiv').hide();

        $('.optionsDiv').find('input, textarea, button, select').attr('disabled','disabled');
        $('#'+type).show();
        if(type=='multicondition' || type=='existingcheck')
        {
            $('#subquestion').show();
            $('#subquestion').find('input, textarea, button, select').attr('disabled',false);
        }
        $('#'+type).find('input, textarea, button, select').attr('disabled',false);

    }
    $(document).ready(function () {
        $('.optionsDiv').hide();
        changeOption();

    });

    function checkAnswer(val,type){
        var existing_qid = $(val).val();
        var trID = $(val).closest('tr').prop('id');
        if(type == 'm_question' || type == 0){
            var url =  "ajax.php?h=getSubQuestion";
        }else{
            var url =  "ajax.php?h=getSubQuestion2";
        }

        $("#"+trID+" #loaderAns").html('<span class="spinner-border spinner-border-sm" role="status"></span>');
        $.ajax( {
            dataType: 'json',
            url: url,
            type: 'POST',
            data: {
                'id': existing_qid
            },
            success: function ( data ) {
                $("#"+trID+" #loaderAns").html('');
                var fieldHTML = '';

                $("#"+trID+" #existValue select").empty();
                if(data.data.field == 'radio' && data.data.labeltype == 0){
                    $("#"+trID+" #newValue").hide();

                    fieldHTML += '<option value="Yes">Yes</option><option value="No">No</option><option value="None">None</option>';
                    $("#"+trID+" #existValue select").append(fieldHTML); //Add field html
                    $("#"+trID+" #existValue").show();
                }else if(data.Options.length > 0){
                    $("#"+trID+" #newValue").hide();

                    for(var i=0; i<data.Options.length; i++){
                        if(data.Options[i].value !== ''){
                            fieldHTML += '<option value="'+data.Options[i].value+'">'+data.Options[i].value+'</option>';
                        }
                    }
                    // fieldHTML += '<option value="None">None</option>';
                    $("#"+trID+" #existValue select").append(fieldHTML); //Add field html
                    $("#"+trID+" #existValue").show();
                }else{
                    fieldHTML += '<option value="#NO#">No Value Assigned</option>';
                    $("#"+trID+" #existValue select").append(fieldHTML); //Add field html
                    $("#"+trID+" #existValue").hide();
                    $("#"+trID+" #newValue").show();
                }
            }
        });
    }
    function checkAnswer2(val,type){
        var existing_qid = $(val).val();
        console.log(existing_qid)
        var loader = $(val).next('p').prop('id');

        if(type == 'm_question' || type == 0){
            var url =  "ajax.php?h=getSubQuestion";
        }
        else if(type=='sm_question')
        {
            var url =  "ajax.php?h=getQuestion";
        }
        else{
            var url =  "ajax.php?h=getSubQuestion2";
        }

        $($(val).next('p')).html('<span class="spinner-border spinner-border-sm" role="status"></span>');
        $.ajax( {
            dataType: 'json',
            url: url,
            type: 'POST',
            data: {
                'id': existing_qid
            },
            success: function ( data ) {
                $($(val).next('p')).html('');
                var fieldHTML = '';
                console.log(data)
                $('.groupCheck2').show()
                $('.groupCheck').show()
                $("#existValue2 select").empty();
                if(data.data.field == 'radio' && data.data.labeltype == 0){
                    $("#newValue2").hide();
                    fieldHTML += '<option value="Yes">Yes</option><option value="No">No</option><option value="None">None</option>';
                    $("#existValue2 select").append(fieldHTML); //Add field html
                    $("#existValue2").show();
                }else if(data.data.field == 'radio' && data.data.labeltype == 1){
                    $("#newValue2").hide();

                    for(var i=0; i<data.Options.length; i++){
                        if(data.Options[i].value !== ''){
                            fieldHTML += '<option value="'+data.Options[i].value+'">'+data.Options[i].value+'</option>';
                        }
                    }
                    fieldHTML += '<option value="None">None</option>';
                    $("#existValue2 select").append(fieldHTML); //Add field html
                    $("#existValue2").show();
                }else{
                    fieldHTML += '<option value="#NO#">No Value Assigned</option>';
                    // $("#existValue2 select").append(fieldHTML); //Add field html
                    $("#existValue2").hide();
                    $("#newValue2").show();
                }
            }
        });

    }

    function GenLabel( label ) {
        var fieldtype = $("#fieldtype" ).val();
        $('#loader').html('<span class="spinner-border spinner-border-sm" role="status"></span>');
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getFields",
            type: 'POST',
            data: {
                'id': fieldtype
            },
            success: function ( data ) {
                $('#loader').html('')
                var labelType = $( "input.labelType:checked" ).val();
                if ( data.data.type == 'radio' ) {
                    $( "#radioFields" ).show();
                    $( "#multiSelectBox" ).hide();
                    if ( label == 'edit' && labelType == 1 ) {
                        $( "#labelTypeBox" ).show();
                    } else if ( label == 'edit' && labelType == 0 ) {
                        ( "#labelDefaultBox" ).show();
                    }
                } else if ( data.data.type == 'multi-select' ) {
                    $( "#multiSelectBox" ).show();
                    $( "#radioFields" ).hide();
                    $( "#labelTypeBox" ).hide();
                    $( "#labelDefaultBox" ).hide();

                    if ( label == 'edit' ) {
                        $( "#labelTypeBox" ).show();
                    }
                } else if ( data.data.type == 'dropdown' ) {
                    $( "#multiSelectBox" ).show();
                    $( "#radioFields" ).hide();
                    $( "#labelTypeBox" ).hide();
                    $( "#labelDefaultBox" ).hide();

                    if ( label == 'edit' ) {
                        $( "#labelTypeBox" ).show();
                    }
                } else if ( data.data.type == 'email' || data.data.type == 'phone' || data.data.type == 'text' ) {
                    $( "#multiSelectBox" ).hide();
                    $( "#radioFields" ).hide();
                    if ( label == 'edit' ) {
                        $( "#labelTypeBox" ).hide();
                    }
                    $( "#labelDefaultBox" ).hide();
                } else {
                    $( "#multiSelectBox" ).hide();
                    $( "#radioFields" ).hide();
                    if ( label == 'edit' ) {
                        $( "#labelTypeBox" ).hide();
                    }
                    $( "#labelDefaultBox" ).hide();
                    $( ".EappendLabel" ).empty();
                }
            }
        } );
    }

    $( ".labelType" ).on( 'click', function () {
        var labelType = $( this ).val();
        if ( labelType == 1 ) {
            $( "#labelTypeBox" ).show();
            $( "#labelDefaultBox" ).hide();
            $('#radioCheck').val(1)
        } else {
            $( "#labelTypeBox" ).hide();
            $( "#labelDefaultBox" ).show();
            $('#radioCheck').val(0)

        }
    } );

    $( ".eLabelType" ).on( 'click', function () {
        var labelType = $( this ).val();
        if ( labelType == 1 ) {
            $( "#labelTypeBox" ).show();
            $( "#labelDefaultBox" ).hide();
        } else {
            $( "#labelTypeBox" ).hide();
            $( "#labelDefaultBox" ).show();
        }
    } );

    $( '#validateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoader').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=addSubQuestion2",
                type: 'POST',
                data: $( "#validateForm" ).serialize(),
                success: function ( data ) {
                    console.log(JSON.stringify(data))
                    $( "#AddLoader" ).html( 'Add Question/Condition' );
                    $('#AddLoader').attr('disabled',false)

                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        window.location.assign( "/admin/level2_subques?id=<?php echo $_GET['id']; ?>" );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                }
            } );

            return false;
        }
    } );

    $( '#validateForm2' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoader').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=editSubQuestion2",
                type: 'POST',
                data: $( "#validateForm2" ).serialize(),
                success: function ( data ) {
                    console.log(JSON.stringify(data))
                    $( "#AddLoader" ).html( 'Update Question/Condtion' );
                    $('#AddLoader').attr('disabled',false)
                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );                        }
                    else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                },
                error: function ( data ) {
                    console.log(JSON.stringify(data))
                }
            } );

            return false;
        }
    } );


    $( '#EvalidateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=addLogics",
                type: 'POST',
                data: $( "#EvalidateForm" ).serialize(),
                success: function ( data ) {
                    $( "#AddLoaderE" ).html( 'Submit' );
                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        window.location.assign( "/admin/subques?id=<?php echo $_GET['id']; ?>" );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                }
            } );

            return false;
        }
    } );



    $( "#delLoader" ).on( 'click', function () {
        var id = $( "#did" ).val();
        $( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=deleteSubques2",
            type: 'POST',
            data: {
                'id': id
            },
            success: function ( data ) {
                if ( data.Success == 'true' ) {
                    $( "#delLoader" ).html( 'Delete' );
                    window.location.assign( "/admin/level2_subques?id=<?php echo $_GET['id']; ?>" );
                } else {
                    $( "#delLoader" ).html( 'Delete' );
                    $( window ).scrollTop( 0 );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            }
        } );
    } );


    function DeleteModal( id ) {
        $( "#did" ).val( id );
        $( "#deleteModal" ).modal();
    }

    var fieldHTML = '<tr><td><input type="text" name="m[label][]" class="form-control" required></td><td><input type="text" name="m[value][]" class="form-control"></td><td><select name="m[status][]" class="form-control" required><option value="1">Enable</option><option value="0">Disable</option></select></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>'; //New input field html




    $( "#addMoreLabel" ).on( 'click', function () {
        $( "#appendLabel" ).append( fieldHTML ); //Add field html
    } );
    $( "#addMoreDrop" ).on( 'click', function () {
        $( "#appendLabelMulti" ).append( fieldHTML ); //Add field html
    } );

    $( document ).on( 'click', '.remove_button', function ( e ) {
        e.preventDefault();
        $( this ).closest( "tr" ).remove();
        //x--; //Decrement field counter
    } );


    //$("#addMoreMulti").on('click',function(){
    //    var totalRowCount = $("#appendQuesType tr").length;
    //
    //    var QuesHTML = '<tr id="trCount'+totalRowCount+'"><td><select name="c[question_type][]" class="form-control question_type"><option value="">-- Select Question Type --</option><option value="m_question">Main Question</option><option value="s_question">Sub Question</option></select></td><td><div class="m_question" style="display: none"><select name="d[existing_qid][]" class="form-control" id="existing_qid" required="" onChange="checkAnswer(this,0)"><option value="" selected disabled>-- Select --</option><?php //foreach($quesArr as $k=>$v) {?>// <option value="<?php //echo $v['id']?>//"><?php //echo str_replace('\'','',$v['question']) ?>//</option><?php //} ?>// </select></div><div class="s_question" style="display: none"><select name="c[existing_sid][]" class="form-control" id="existing_sid" required="" onChange="checkAnswer(this,1)" data-type="s_question"><option value="" selected disabled>-- Select --</option><?php //foreach($squesArr as $kv=>$Vv){ ?>// <option value="<?php //echo $Vv['id']?>//"><?php //echostr_replace('\'','',$Vv['question']) ?>//</option><?php //} ?>//</select></div><p id="loaderAns"></p></td><td><select name="c[operator][]" class="form-control valid" required=""><option value="=">=</option><option value="!=">!=</option><option value="<">&lt;</option><option value=">">&gt;</option><option value="<=">&lt;=</option><option value=">=">&gt;=</option> </select></td><td><div id="newValue" style="display: none"><input type="text" name="c[value][]" class="form-control"></div><div id="existValue" style="display: none"><select name="d[value][]" class="form-control"></select></div></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>';
    //    $("#appendQuesType").append( QuesHTML );
    //});

    $('.groupSelect').change(function () {
        let c=$('#casetype').val()
        let id=$(this).val()
        if(c=='movegroup' || c=='groupques')
        {

            if(c=='movegroup')
            {
                var divID='groupQuest'
            }
            else
            {
                var divID='groupQuest2'
            }

            $('#'+divID).html('')
            $('#'+divID).html('<option value="" disabled selected>--Select--</option>')
            $(this).parent().append('<span class="spinner-border spinner-border-sm temp" role="status"></span>')
            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=getGroupQuest",
                type: 'POST',
                data: {id:id},
                success: function ( data ) {

                    $('.groupSelect').parent().find('.temp').remove()

                    if ( data.Success === 'true' ) {
                        var html='';
                        for(let i=0;i<data.questions.length;i++)
                        {
                            html+='<option value="'+data.questions[i].id+'">'+data.questions[i].question+'</option>';
                        }

                        $('#'+divID).append(html)
                        $('.groupCheck1').show()


                    }
                },
                error: function ( data ) {
                    console.log(JSON.stringify(data))
                }
            } );

        }

    })
    $('.questionEx1').change(function () {
        let id=$(this).val()
        let type=$(this).attr('data-val')
        // $('#groupQuestLabel').html('')
        // $('#groupQuestLabel').append('<label>Value</label>')
        $(this).parent().append('<span class="spinner-border spinner-border-sm temp" role="status"></span>')
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getGroupQuestLabel2",
            type: 'POST',
            data: {id:id,type:type},
            success: function ( data ) {

                $('.questionEx').parent().find('.temp').remove()

                if ( data.Success === 'true' ) {

                    // $('#groupQuestLabel').append(data.questions)
                    $('.groupCheck2').show()
                    $('.groupCheck').show()


                }
            },
            error: function ( data ) {
                console.log(JSON.stringify(data))
            }
        } );


    })
    $(document).ready(function() {
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color','transparent')
        $('.select2-container .select2-selection--single').css('border',0)
    });
    $(".more_pos").change(function() {
        more_ops_check_change();
    });

    more_ops_check_change();

    function more_ops_check_change() {
        if ($(".more_pos:checked").val() == '1') {
            $("#em_more_ops").show();
        } else {
            $("#em_more_ops").hide();
        }
    }
</script>
<link href="assets/css/select2.min.css" rel="stylesheet">
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/select2-init.js"></script>

</body>

</html>