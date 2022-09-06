<?php

require "global.php";// file that include database connection
require_once 'crash_logs.php'; // crash log error file
include('pdf_maker/tcpdf_include.php'); // tcpdf library for making pdf files
require 'send-grid-email/vendor/autoload.php'; // send grid API file for emails

//-------send grid email API key-----------------------
$sendGridAPIKey='';
if($ext=='.app')
{
    $sendGridAPIKey="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";

}
else
{
    $sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada

}
//-------------------------------------------------------


$date = date("Y-m-d h:i:s A"); // default current date
$default_url = 'https://'.$_SERVER['HTTP_HOST']; // default current url
$is_pro  = 'no';// by default professional account is no
$lang_slug = $_GET['Lang'];



//------------Checks on every request if user's IP is bocked by admin-----------------------------------
if (!isset($_SESSION['user_id'])) {
    if (!checkIPAddress()) {
        die(json_encode(array('Success' => 'false1','logout'=>'no', 'Msg' => 'Your IP Address has been blocked by Admin')));
    }
}
if($_GET['h'] =='continueFormRequest')
{
    $updateQuery = "UPDATE `users` SET `form_session_id` = '".session_id()."' WHERE id = '".$_SESSION['user_id']."'";

    mysqli_query($conn,$updateQuery);

    die(["error"=>mysqli_error($conn)]);
}
//------------------------------------------------------------------

//--------------checks if current account is logged in form somewhere else-------------------------------
if(isset($_SESSION['user_id']))
{
    $loggedSessionId = $cuurentUser['form_session_id'];
    if(!empty($loggedSessionId) && $loggedSessionId != session_id() &&  ($cuurentUser['role'] == "0" || $cuurentUser['role'] = 0 ) )
    {
        // Can't do anyhing if logged in session Id and current session Id is not same.
        die(json_encode(array('Success' => 'false1','logout'=>'yes', 'Msg' => 'Your IP Address has been blocked by Admin')));
    }
//    echo $loggedSessionId." ===== " . session_id();
//    die();
}
else
{
    if(isset($_POST['prev_userId']))
    {
        if(!empty($_POST['prev_userId']))
        {
            die(json_encode(array('Success' => 'false1','logout'=>'yes', 'Msg' => 'Your IP Address has been blocked by Admin')));
        }
    }

}
unset($_POST['prev_userId']);
unset($_POST['prev_userSes']);
//------------------------------------------------------------------

//-------checking if current user is logged in with professional account-----------------------
if (isset($cuurentUser)) {
    if ($cuurentUser['role'] == "1" || $cuurentUser['role'] == 1) {
        $is_pro = "yes";
    }
}
//------------------------------------------------------------------



//-------getting all the field types used in form-----------------------

$getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
$fieldArr = array();
while ($f = mysqli_fetch_assoc($getFieldTypes)) {
    $fieldArr[$f['id']] = $f;
}
//------------------------------------------------------------------


//---------extra function for now----------
if($_GET['h'] == "continueFormEditing")
{
    $form_id = $_POST['formId'];
    if(mysqli_query($conn,"UPDATE user_form SET `editing_from` = '".session_id()."'  WHERE `id` = '$form_id' "))
    {
        die(json_encode(array('Success' => 'true')));
    }
    else
    {
        die(json_encode(array('Success' => 'false')));
    }
}
//------------------------------------------------------------------


//---- to get the display of selected language ---------------

$display_class= '';
$align_class = '';

$getDisp = mysqli_query($conn, "SELECT * FROM `multi-lingual` where lang_slug='$lang_slug'");
$dispRow = mysqli_fetch_assoc($getDisp);
if ($dispRow['display_type'] == 'Right to Left') {
    $display_class = 'urduField';
    $align_class = 'text-align: right;';
}

//------------------------------------------------------------------

$col = $_GET['Lang'];// column name to get labels/questions in selected language

//---- because we have column name "french" in all the tables for "francais" language----------------
if ($col == 'francais') {
    $col = 'french';
}

$order_column='label_'.$col;
if($col=='' || $col=='english')
{
    $order_column='label';
}
//--------------Education array---------------------
$countries='';
if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
    $column_name='name_'.$col;
    $countries = mysqli_query($conn, "select * from education order by $column_name asc");
}
else
{
    $countries = mysqli_query($conn, "select * from education order by name asc");

}

// $countries = mysqli_query($conn, "select * from education");
$count = 0;
while ($getCountries = mysqli_fetch_assoc($countries)) {
    if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
        if ($getCountries['name_' . $col] !== '' && $getCountries['name_' . $col] !== null)
            $educationArray[$count]['name'] = $getCountries['name_' . $col];
    } else {
        $educationArray[$count]['name'] = $getCountries['name'];
    }
    if ($getCountries['name'] !== '')
        $educationArray[$count]['value'] = $getCountries['name'];

    $count++;
}
//------------------------------------------------------------------


//--------------Countries array---------------------
$countries='';
if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
    $column_name='name_'.$col;
    $countries = mysqli_query($conn, "select * from countries order by $column_name asc");
}
else
{
    $countries = mysqli_query($conn, "select * from countries order by name asc");

}
$count = 0;
while ($getCountries = mysqli_fetch_assoc($countries)) {
    if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
        if ($getCountries['name_' . $col] !== '' && $getCountries['name_' . $col] !== null)
            $countryArray[$count]['name'] = $getCountries['name_' . $col];
    } else {
        $countryArray[$count]['name'] = $getCountries['name'];
    }
    if ($getCountries['name'] !== '')
        $countryArray[$count]['value'] = $getCountries['name'];

    $count++;
}
//------------------------------------------------------------------


$dutyArr = [];// current language array for NOC duties
$posArr = [];//current language array for NOC duties
$dutyArrOrg = [];//current language array for NOC duties
$posArrOrg = [];//current language array for NOC duties


//--------------function that returns all the NOC duties and positions---------------------
if ($_GET['h'] == 'getNocJobs') {
    $getJobduty = mysqli_query($conn, "select * from noc_translation ");
    while ($row_job = mysqli_fetch_assoc($getJobduty)) {

        if ($_GET['Lang'] !== 'english') {


            if($row_job['job_position']!=='' && $row_job['job_position']!==null)
            {
                $posArr[] = $row_job['job_position_' . $col];
                $posArrOrg[] = $row_job['job_position'];


            }


            if($row_job['job_duty']!=='' && $row_job['job_duty']!==null)
            {
                $dutyArr[] = $row_job['job_duty_' . $col];
                $dutyArrOrg[] = $row_job['job_duty'];
            }
        } else {
            if($row_job['job_position']!=='' && $row_job['job_position']!==null)
            {
                $posArr[] = $row_job['job_position'];
                $posArrOrg[] = $row_job['job_position'];
            }


            if($row_job['job_duty']!=='' && $row_job['job_duty']!==null)
            {
                $dutyArr[] = $row_job['job_duty'];
                $dutyArrOrg[] = $row_job['job_duty'];
            }

        }
    }
    $posArr=array_map('trim',$posArr);
    $posArrOrg=array_map('trim',$posArrOrg);
    $dutyArrOrg=array_map('trim',$dutyArrOrg);
    $dutyArr=array_map('trim',$dutyArr);
    function custom_replace( &$item, $key ) {
        $item = str_replace('.', '', $item);
    }
    array_walk($dutyArrOrg, 'custom_replace');
    array_walk($dutyArr, 'custom_replace');
    array_walk($posArr, 'custom_replace');
    array_walk($posArrOrg, 'custom_replace');

    $posArr=array_unique($posArr);
    $posArrOrg=array_unique($posArrOrg);
    $dutyArrOrg=array_unique($dutyArrOrg);
    $dutyArr=array_unique($dutyArr);

    $posArr=array_filter($posArr,'strlen');
    $posArrOrg=array_filter($posArrOrg,'strlen');
    $dutyArrOrg=array_filter($dutyArrOrg,'strlen');
    $dutyArr=array_filter($dutyArr,'strlen');

    sort($posArrOrg);
    sort($posArr);
    sort($dutyArrOrg);
    sort($dutyArr);

    die(json_encode(array('Success' => 'true', 'jobsArr' => $posArr, 'jobsLength' => sizeof($posArr), 'dutyArr' => $dutyArr, 'dutyLen' => sizeof($dutyArr), 'dutyArrOrg' => $dutyArrOrg, 'jobsArrOrg' => $posArrOrg)));
}
//------------------------------------------------------------------


//-------function that returns the array [ index=question id, value=question's value ]----------
function getQA($post_data)
{
    global $mainQuestionsArray,$subQuestionsArray,$conn;
    foreach ($post_data['form_data'] as $k => $v) {

        $quest = explode('_', $v['name']);
        if($quest[0]=='show')
        {
            $ansArray[$q] = $v['value']; // all answers
            $quesArray[$q]=$v['name'];// all names
            $q++;
            continue;
        }
        if (sizeof($quest) > 2) {
            $qID = substr($quest[2], 0, -1);
            if (strpos($qID, ']') == true) {
                $new_id = substr($qID, 0, -1);
                $qID = '1000_' . $new_id;
                $quesArray[$q] = 'Please Describe';
            } else {
                $ques = mysqli_query($conn, "select question from sub_questions where id='$qID'");
                $rques = mysqli_fetch_assoc($ques);
                $quesArray[$q] = $rques['question']; // all questions
            }

            $ansArray[$q] = $v['value']; // all answers
            $quesArray2[$q] = $v['name']; // all names

            $q++;
            $subQuestionsArray[$qID] = $v['value']; // values of sub questions
        } else {
            $qID = substr($quest[1], 0, -1);
            if (strpos($qID, ']') == true) {
                $new_id = substr($qID, 0, -1);
                $qID = '1000_' . $new_id;
                $quesArray[$q] = 'Please Describe';
            } else {
                $ques = mysqli_query($conn, "select question from questions where id='$qID'");
                $rques = mysqli_fetch_assoc($ques);
                $quesArray[$q] = $rques['question']; // all questions
            }

            $ansArray[$q] = $v['value']; // all answers
            $quesArray2[$q] = $v['name']; // all names

            $q++;
            $mainQuestionsArray[$qID] = $v['value']; // values of main questions
        }
        $newArray[$qID] = $v['value']; //temporary
    }

}
//------------------------------------------------------------------


//-------function that returns the checks if the multi condition is true/false----------
function getMultiCondition($post_data,$s_id)
{
    global $mainQuestionsArray,$subQuestionsArray,$conn;
    $mainQuestionsArray=Array();
    $subQuestionsArray=Array();
    getQA($post_data);
    $get_multicondition=mysqli_query($conn,"select * from multi_conditions where s_id=$s_id");
    $total_rows=mysqli_num_rows($get_multicondition);
    $satisfy=0;
    $operator='';
    $value1='';
    $value2='';
    $case_operator='';

    while($row=mysqli_fetch_assoc($get_multicondition))
    {
        if($row['question_type']=='s_question')
        {
            $value1=$subQuestionsArray[$row['existing_sid']];
        }
        else
        {
            $value1=$mainQuestionsArray[$row['existing_qid']];
        }
        $value2=$row['value'];
        $operator=$row['operator'];
        $case_operator=$row['op'];

        if($value2=='None')
        {
            if($value1=='Yes' || $value1=='No')
            {
                $satisfy++;
            }
        }
        else
        {
            if(check_cond2($value1,$operator,$value2) )
            {
                $satisfy++;
            }
        }

    }
    if($case_operator=='' || $case_operator=='and')
    {
        if($total_rows==$satisfy)
        {
            return 'true';
        }
    }
    else
    {
        if($satisfy>0)
        {
            return 'true';
        }
    }
    return false;
}
//------------------------------------------------------------------


//-------function that returns the question if the multi condition is true----------
function getMultiConditionQuestion($id,$level)
{
    global $col,$conn,$educationArray,$countryArray,$display_class,$order_column;
    if($level==0)
    {
        $pid=$_POST['id'];
    }
    else
    {
        $pid = $_POST['qid'];

    }
    $noc_attr = '';
    $html='';
    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
    $fldArr = array();
    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
        $fldArr[$fld['id']] = $fld;
    }

    $select = mysqli_query($conn, "SELECT * FROM sub_questions where id = $id");

    if (mysqli_num_rows($select) > 0) {
        $row2 = mysqli_fetch_assoc($select);
        $name='n[sub_question_' . $row2['id'] . ']';
        $function='getQuestion3(this,' . $row2['id'] . ',' . $pid . ')';
        $row2['org_question'] = $row2['question'];
        $row2['org_notes'] = $row2['notes'];
        // Translation Check
        if ($_GET['Lang'] !== 'english') {
            if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                $row2['question'] = $row2['question_' . $col];
            }
            if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                $row2['notes'] = $row2['notes_' . $col];
            }
        }

        $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';
        $permission = '';
        if ($row2['permission'] == 1) {
            $permission = 'permitted';
        } else {
            $permission = 'forbidden';
        }
        $getLabels = mysqli_query($conn, "select * from level1 where question_id={$row2['id']}");

        if ($_COOKIE['AgreeCheck'] == 0) {
            $html .= '<div class="multi unChecked parent_' . $row2['id'] . '">';
        } else {
            $html .= '<div class="multi parent_' . $row2['id'] . '">';
        }

        $html .= '<div class="form-group sub_question_div sques_' . $id . '" id="question_div_' . $row2['id'] . '">';

        if ($row2['notes'] != '') {
            $notes = $row2['notes'];


            $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';;
        }
        $ques_label = $row2['question'];


        $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';


        $html .= '<div class="input-group input-group-merge ' . $permission . '  ' . $display_class . '">';
        if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
            $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="'.$name.'" ' . $noc_attr . '>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
            $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker age" name="'.$name.'" ' . $noc_attr . '>';
            $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
            $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="'.$name.'" ' . $noc_attr . '>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {

            $yes = 'Yes';
            $no = 'No';

            // Translation Check
            if ($_GET['Lang'] !== 'english') {
                $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                if (mysqli_num_rows($getLabels) > 0) {
                    $label_row = mysqli_fetch_assoc($getLabels);
                    $yes = $label_row['label_' . $col];
                }
                $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                if (mysqli_num_rows($getLabels) > 0) {
                    $label_row = mysqli_fetch_assoc($getLabels);
                    $no = $label_row['label_' . $col];
                }
            }

            $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row2['validation'] . ' type="radio" class="radioButton" name="'.$name.'" onClick="'.$function.'" value="Yes" ' . $noc_attr . '><span class="customLabel" data-org="Yes">' . $yes . '</span>';
            $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="'.$name.'" onClick="'.$function.'" value="No" ' . $noc_attr . '><span class="customLabel" data-org="No">' . $no . '</span>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
            while ($row_label = mysqli_fetch_assoc($getLabels)) {
                $op = $row_label['label'];
                //  Translation Check
                if ($_GET['Lang'] !== 'english') {
                    if ($row_label['label_' . $col] != '') {
                        $op = $row_label['label_' . $col];
                    }
                }
                $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="'.$name.'" onClick="'.$function.'" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
            }
        }

        else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {

            $html .= '<select ' . $row2['validation'] . ' name="'.$name.'" class="form-control" onchange="'.$function.'" ' . $noc_attr . '>';
            $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

            while ($row_label = mysqli_fetch_assoc($getLabels)) {
                $op = $row_label['label'];
                //  Translation Check
                if ($_GET['Lang'] !== 'english') {
                    if ($row_label['label_' . $col] != '') {
                        $op = $row_label['label_' . $col];
                    }
                }
                $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
            }
            $html .= '</select>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
            $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="'.$name.'" ' . $noc_attr . '>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {

            $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" onchange="'.$function.'"  name="'.$name.'" ' . $noc_attr . '>';
            $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
            foreach ($countryArray as $getCountries) {
                $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
            }
            $html .= '</select>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
            $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="'.$function.'" name="'.$name.'" ' . $noc_attr . '>';
            $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
            foreach ($educationArray as $getEducation) {
                $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
            }
            $html .= '</select>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'number') {
            $html .= '<input ' . $row2['validation'] . ' type="number"  class="form-control" name="'.$name.'" ' . $noc_attr . '>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'currentrange') {
            $html .= '<label class="pb-date static_label">From</label>';
            $html .= '<label class="pb-date static_label">To</label>';
            $html .= '<input autocomplete="off" ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="from"  type="text" class="form-control datepicker nocPicker" name="'.$name.'" ' . $noc_attr . '>';
            $html .= '<input autocomplete="off" required data-date="YYYY-MM-DD" data-id="to"  type="text" onchange="position_date(this,' . $row2['id'] . ',' . $pid . ',2' . ')" class="form-control datepicker nocPicker" name="'.$name.'" ' . $noc_attr . '>';
            $html .= '<div class="presCheck"><input  type="checkbox" class="present_checkbox" onchange="if(presentBox(this)==false){return false;}'.$function.'"><span class="presentCheckbox static_label">Present</span></div>';
        } else {
            $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="'.$function.'" class="form-control" name="'.$name.'" ' . $noc_attr . '>';
            if($row2['id']==127)
            {
                $html.='<br><em style="font-size: 12px; font-style: italic;width: 100%;" class="static_label" data-org="Press tab to continue">Press tab to continue</em>';
            }
        }
        $html .= '</div></div></div>';

        return $html;
    }
}
//------------------------------------------------------------------


//-------function that returns the existing check question ----------
function getExistingCheckQuestion($row2)
{
    global $col,$conn,$educationArray,$countryArray,$display_class,$order_column;

    $noc_attr = '';
    $html='';
    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
    $fldArr = array();
    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
        $fldArr[$fld['id']] = $fld;
    }
    if (($_POST['id'] === '595' && $_POST['qid'] === '107' && $_POST['value'] === 'No') || ($_POST['id'] === '195' && $_POST['qid'] === '77' && $_POST['value'] === 'No')) {
        return false;
    }
    else
    {
        $select = mysqli_query($conn, "SELECT * FROM sub_questions where existing_sid = '{$_POST['id']}' and question_id={$_POST['qid']} and casetype='existingcheck'");
        $grade = '';


        //if (mysqli_num_rows($select) > 0)
        {
            //while($row2 = mysqli_fetch_assoc($select))
            {
                $name='n[sub_question_' . $row2['id'] . ']';
                $function='getQuestion3(this,' . $row2['id'] . ',' . $_POST['qid'] . ')';
                $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';

                $row2['org_question'] = $row2['question'];
                $row2['org_notes'] = $row2['notes'];

                // Translation Check
                if ($_GET['Lang'] !== 'english') {
                    if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                        $row2['question'] = $row2['question_' . $col];
                    }
                    if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                        $row2['notes'] = $row2['notes_' . $col];
                    }
                }

                $permission = '';
                if ($row2['permission'] == 1) {
                    $permission = 'permitted';
                } else {
                    $permission = 'forbidden';
                }

                $getLabels = mysqli_query($conn, "select * from level1 where question_id={$row2['id']}");

                if ($_COOKIE['AgreeCheck'] == 0) {
                    $html .= '<div class="unChecked parent_' . $row2['id'] . '">';
                } else {
                    $html .= '<div class="parent_' . $row2['id'] . '">';
                }

                $html .= '<div class="form-group sub_question_div sques_' . $row2['id'] . '" id="question_div_' . $row2['id'] . '">';

                if ($row2['notes'] != '') {
                    $notes = $row2['notes'];


                    $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';;
                }
                $ques_label = $row2['question'];


                $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';


                $html .= '<div class="input-group input-group-merge ' . $permission . '  ' . $display_class . '">';
                if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
                    $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="'.$name.'" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
                    $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker age" name="'.$name.'" ' . $noc_attr . ' onchange="'.$function.'">';
                    $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
                    $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="'.$name.'" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'number') {
                    $html .= '<input ' . $row2['validation'] . ' type="number"  class="form-control" name="'.$name.'" ' . $noc_attr . '>';
                }else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
                    $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="'.$name.'" ' . $noc_attr . '>';
                }
                else if ($fldArr[$row2['fieldtype']]['type'] == 'nocjob') {
                    $html .= '<input ' . $row2['validation'] . ' class="' . $row2['validation'] . ' form-control nocJobs" name="'.$name.'" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'nocduty') {
                    $html .= '<input ' . $row2['validation'] . ' class="' . $row2['validation'] . ' form-control nocPos" name="'.$name.'" ' . $noc_attr . '>';
                }
                else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {

                    $yes = 'Yes';
                    $no = 'No';

                    // Translation Check
                    if ($_GET['Lang'] !== 'english') {
                        $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                        if (mysqli_num_rows($getLabels) > 0) {
                            $label_row = mysqli_fetch_assoc($getLabels);
                            $yes = $label_row['label_' . $col];
                        }
                        $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                        if (mysqli_num_rows($getLabels) > 0) {
                            $label_row = mysqli_fetch_assoc($getLabels);
                            $no = $label_row['label_' . $col];
                        }
                    }

                    $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row2['validation'] . ' type="radio" class="radioButton" name="'.$name.'" onClick="'.$function.'" value="Yes" ' . $noc_attr . '><span class="customLabel" data-org="Yes">' . $yes . '</span>';
                    $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="'.$name.'" onClick="'.$function.'" value="No" ' . $noc_attr . '><span class="customLabel" data-org="No">' . $no . '</span>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                        $op = $row_label['label'];
                        //  Translation Check
                        if ($_GET['Lang'] !== 'english') {
                            if ($row_label['label_' . $col] != '') {
                                $op = $row_label['label_' . $col];
                            }
                        }
                        $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="'.$name.'" onClick="'.$function.'" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                    }
                }

                else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {

                    $html .= '<select ' . $row2['validation'] . ' name="'.$name.'" class="form-control" onchange="'.$function.'" ' . $noc_attr . '>';
                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                        $op = $row_label['label'];
                        //  Translation Check
                        if ($_GET['Lang'] !== 'english') {
                            if ($row_label['label_' . $col] != '') {
                                $op = $row_label['label_' . $col];
                            }
                        }
                        $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                    }
                    $html .= '</select>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {
                    $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" onchange="'.$function.'"  name="'.$name.'" ' . $noc_attr . '>';
                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                    foreach ($countryArray as $getCountries) {
                        $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
                    }
                    $html .= '</select>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
                    $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="'.$function.'" name="'.$name.'" ' . $noc_attr . '>';
                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                    foreach ($educationArray as $getEducation) {
                        $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
                    }
                    $html .= '</select>';
                }  else if ($fldArr[$row2['fieldtype']]['type'] == 'currentrange') {
                    $html .= '<label class="pb-date static_label">From</label>';
                    $html .= '<label class="pb-date static_label">To</label>';
                    $html .= '<input autocomplete="off" ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="from"  type="text" class="form-control datepicker nocPicker" name="'.$name.'" ' . $noc_attr . '>';
                    $html .= '<input autocomplete="off" ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="to"  type="text" onchange="position_date(this,' . $row2['id'] . ',' . $_POST['qid'] . ',3' . ')" class="form-control datepicker nocPicker" name="'.$name.'" ' . $noc_attr . '>';
                    $html .= '<div class="presCheck"><input  type="checkbox" class="present_checkbox" onchange="if(presentBox(this)==false){return false;}'.$function.'"><span class="presentCheckbox static_label">Present</span></div>';
                } else {
                    $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="'.$function.'" class="form-control" name="'.$name.'" ' . $noc_attr . '>';
                }
                $html .= '</div></div></div>';

            }
            return $html;

        }
    }

}
//------------------------------------------------------------------



//------------returns the questions for level 0-----------------------------
if ($_GET['h'] == 'getQuestion') {

    $arrQuestion = array();
    $arrMulti = $arrMultiN = array();
    $multArray = array();
    $multi = '';
    $gDataCheck = 0;
    $arrCheck = array();



    //-------existing check case type----------
    $select = mysqli_query($conn, "SELECT * FROM sub_questions where existing_qid = '{$_POST['id']}' and question_id='{$_POST['pid']}' and casetype='existingcheck' and submission_type='before'");

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {

            // Translation Check
            if ($_GET['Lang'] !== 'english') {
                if ($row['question_' . $col] !== '' && $row['question_' . $col] !== null) {
                    $row['question'] = $row['question_' . $col];
                }
                if ($row['notes_' . $col] !== '' && $row['notes_' . $col] !== null) {
                    $row['notes'] = $row['notes_' . $col];
                }
            }

            $getLogic = mysqli_query($conn, "SELECT * FROM ques_logics WHERE s_id = '{$row['id']}'");
            $fetLogic = mysqli_fetch_assoc($getLogic);


            $variable = $row['group_operator'];
            $value = $row['value'];
            $postValue = $_POST['value'];
            if ($variable == '=') {
                $variable = '==';
            }
            $check = $postValue . $variable . $value;
            $p = eval('return ' . $check . ';');
            if ($p == 1) {

                if ($row['casetype'] == 'existingcheck') {

                    if ($row['questiontype'] == 'm_question') {

                        $row['other'] = $row['question'];
                        $row['check'] = 1;
                        $row['field'] = $fieldArr[$row['fieldtype']]['type'];
                        $arrQuestion[] = $row;
                    }
                }
            }
        }


        die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'country' => $countryArray, 'education' => $educationArray, 'MultiCondition' => $multArray)));
    }
    else {
        $moveScoreCheck = false;
        $quesCheck = mysqli_query($conn, "select * from sub_questions where question_id={$_POST['id']} and casetype='movescore'");
        if (mysqli_num_rows($quesCheck) > 0) {
            $quesCheck = mysqli_query($conn, "select * from sub_questions where question_id={$_POST['id']}");
            $fetLogic = '';
            while ($quesRow = mysqli_fetch_assoc($quesCheck)) {
                $getLogic = mysqli_query($conn, "SELECT * FROM ques_logics WHERE s_id = '{$quesRow['id']}'");
                if (mysqli_num_rows($getLogic) > 0) {
                    $fetLogic = mysqli_fetch_assoc($getLogic);
                    if ($_POST['value'] == $fetLogic['value'] || $fetLogic['value'] == 'None') {
                        if ($quesRow['casetype'] == 'movescore') {
                            $moveScoreCheck = true;
                            $s = mysqli_query($conn, "select * from score where id ={$quesRow['score_type']}");
                            $r = mysqli_fetch_assoc($s);
                            $row['ques_case'] = $quesRow['casetype'];
                            $row['scoreID'] = $r['scoreID'];
                            $arrQuestion[] = $row;
                        } else if ($quesRow['casetype'] == 'email') {
                            $moveScoreCheck = true;
                            $arrQuestion[] = $quesRow;
                        }
                    }
                }
            }
            if ($moveScoreCheck) {
                die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'country' => $countryArray, 'education' => $educationArray, 'MultiCondition' => $multArray)));
            }
        }
        $select = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['id']}' ");
        if (mysqli_num_rows($select) <= 0) {

            $sel = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['id']}'"); {
                while ($rrr = mysqli_fetch_assoc($sel)) {

                    $sel2 = mysqli_query($conn, "SELECT * FROM level2_sub_questions where question_id = '{$rrr['id']}'");

                    while ($rr = mysqli_fetch_assoc($sel2)) {

                        if ($rr['casetype'] == 'movescore') {

                            $select = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['id']}' ");

                            break;
                        }
                    }
                }
            }
        }
        $selectRow = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['id']}' AND casetype = 'movegroup'");
        $grpArrcount = mysqli_num_rows($selectRow);

        $countI = 0;
        $html = '';


        if (mysqli_num_rows($select) > 0) {

            while ($row = mysqli_fetch_assoc($select)) {
                $getLogic = mysqli_query($conn, "SELECT * FROM ques_logics WHERE s_id = '{$row['id']}'");
                $fetLogic = mysqli_fetch_assoc($getLogic);
                $getLabels = mysqli_query($conn, "select * from level1 where question_id={$row['id']} ");
                $noc_attr = 'data-noc="' . $row['noc_flag'] . '" data-position="' . $row['position_no'] . '" data-type="' . $row['noc_type'] . '" data-label="' . $row['user_type'] . '"';
                $row['org_question'] = $row['question'];
                $row['org_notes'] = $row['notes'];

                if ($row['casetype'] == 'multicondition') {

                    $get = mysqli_query($conn, "SELECT * FROM multi_conditions where s_id = '{$row['id']}'  ");
                    $row['questionValue'] = $fetLogic['value'];
                    $row['questionOperator'] = $fetLogic['operator'];
                    $row['field'] = $fieldArr[$row['fieldtype']]['type'];
                    $row['noOfCondition'] = mysqli_num_rows($get);
                    $row['operator'] = $row['group_operator'];

                    while ($row3 = mysqli_fetch_assoc($get)) {
                        $row3['mques'] = $_POST['id'];

                        $multArray[] = $row3;
                    }
                    $row['other'] = $row['casetype'];
                    $row['check'] = 3;
                    //$arrQuestion[] = $row;
                }
                if ($_POST['value'] == $fetLogic['value'] || $fetLogic['value'] == 'None') {

                    // Translation Check
                    if ($_GET['Lang'] !== 'english') {
                        if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                            $row2['question'] = $row2['question_' . $col];
                        }
                        if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                            $row2['notes'] = $row2['notes_' . $col];
                        }
                    }

                    $permission = '';
                    if ($row['permission'] == 1) {
                        $permission = 'permitted';
                    } else {
                        $permission = 'forbidden';
                    }
                    $row['questionValue'] = $fetLogic['value'];
                    $row['questionOperator'] = $fetLogic['operator'];
                    $row['field'] = $fieldArr[$row['fieldtype']]['type'];
                    $row['noOfCondition'] = 0;
                    if ($row['casetype'] == 'multicondition' || $row['casetype'] == 'existingcheck') {
                        continue;
                    } else if ($row['casetype'] == 'group') {
                        $row['group_data'] = getData($conn, 'group', $row, $_POST['id'], $_POST['pid']);
                    } else if ($row['casetype'] == 'groupques') {
                        $row['group_data2'] = getData($conn, 'groupques', $row, $_POST['id'], $_POST['pid']);
                    } else if ($row['casetype'] == 'movegroup') {
                        $grpArr =
                        $questionID = 0;
                        if ($row['questiontype'] == 'm_question') {
                            $questionID = $row['existing_qid'];
                        } else {
                            $questionID = $row['existing_sid'];
                        }

                        $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
                        $fldArr = array();
                        while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
                            $fldArr[$fld['id']] = $fld;
                        }

                        $row['check'] = 4;
                        $row['checkQuesID'] = $questionID;
                        $row['hideQuesID'] = $row['group_ques_id'];


                        $row['checkVal'] = $row['value'];
                        $row['checkOp'] = $row['group_operator'];
                        $getQuestion = mysqli_query($conn, "SELECT * FROM questions WHERE id = '$questionID'");
                        $ques = mysqli_fetch_assoc($getQuestion);
                        $row['checkQuestField'] = $fieldArr[$ques['fieldtype']]['type'];

                        $get = mysqli_query($conn, "SELECT * FROM questions where group_id = '{$row['group_id']}' and submission_type='before'");

                        if (mysqli_num_rows($get) > 0) {
                            while ($row2 = mysqli_fetch_assoc($get)) {
                                $row2['org_question'] = $row2['question'];
                                $row2['org_notes'] = $row2['notes'];
                                // Translation Check
                                if ($_GET['Lang'] !== 'english') {
                                    if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                                        $row2['question'] = $row2['question_' . $col];
                                    }
                                    if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                                        $row2['notes'] = $row2['notes_' . $col];
                                    }
                                }

                                $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';
                                $permission = '';
                                if ($row2['permission'] == 1) {
                                    $permission = 'permitted';
                                } else {
                                    $permission = 'forbidden';
                                }
                                if ($row['group_ques_id'] == $row2['id'] && $count == $countI) {

                                    $html .= '<div style="display:none" class="main_parent_' . $row2['id'] . ' m' . $row2['id'] . '">';
                                } else {

                                    if ($count == $countI) {
                                        $row['checkQuestField'] = '';
                                        if ($_COOKIE['AgreeCheck'] == 0) {
                                            $html .= '<div class="unchecked main_parent_' . $row2['id'] . '">';
                                        } else {
                                            $html .= '<div class="main_parent_' . $row2['id'] . '">';
                                        }
                                    } else {
                                        $html .= '<div class="displayNone' . $row2['id'] . ' main_parent_' . $row2['id'] . '">';
                                    }
                                }
                                $countI++;
                                $html .= '<div class="form-group sub_question_div sques_' . $_POST['id'] . '" id="question_div_2_' . $row2['id'] . '">';


                                if ($row2['notes'] != '') {
                                    $notes = $row2['notes'];

                                    $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';;
                                }
                                $ques_label = $row2['question'];


                                $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';

                                $html .= '<div class="input-group input-group-merge ' . $permission . '  ' . $display_class . '">';
                                if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
                                    $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
                                    $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker age" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                    $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
                                    $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {
                                    $yes = 'Yes';
                                    $no = 'No';
                                    // Translation Check
                                    if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
                                        $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                                        if (mysqli_num_rows($getLabels) > 0) {
                                            $label_row = mysqli_fetch_assoc($getLabels);
                                            $yes = $label_row['label_' . $col];
                                        }
                                        $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                                        if (mysqli_num_rows($getLabels) > 0) {
                                            $label_row = mysqli_fetch_assoc($getLabels);
                                            $no = $label_row['label_' . $col];
                                        }
                                    }

                                    $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row2['validation'] . '  type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" value="Yes" ' . $noc_attr . '><span class="customLabel" data-org="Yes">' . $yes . '</span>';
                                    $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" value="No" ' . $noc_attr . '><span class="customLabel" data-org="No">' . $no . '</span>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
                                    $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row2['id']} ");
                                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                                        $op = $row_label['label'];
                                        //  Translation Check
                                        if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
                                            if ($row_label['label_' . $col] != '') {
                                                $op = $row_label['label_' . $col];
                                            }
                                        }
                                        $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                                    }
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {
                                    $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row2['id']} ");
                                    $html .= '<select ' . $row2['validation'] . ' name="n[question_' . $row2['id'] . ']" class="form-control" onchange="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" ' . $noc_attr . '>';
                                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

                                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                                        $op = $row_label['label'];
                                        //  Translation Check
                                        if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
                                            if ($row_label['label_' . $col] != '') {
                                                $op = $row_label['label_' . $col];
                                            }
                                        }
                                        $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                                    }
                                    $html .= '</select>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
                                    $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {
                                    $onchange = 'onchange="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')"';
                                    $namesArray = [68, 69, 70, 71];

                                    if ($row2['id'] == 68 || $row2['id'] == 69 || $row2['id'] == 70 || $row2['id'] == 71) {
                                        $onchange = 'onchange="check_country_change(this,' . $row2['id'] . ',' . $_POST['pid'] . ')"';
                                    }
                                    $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" ' . $onchange . ' name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                                    foreach ($countryArray as $getCountries) {
                                        $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
                                    }
                                    $html .= '</select>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
                                    $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                                    foreach ($educationArray as $getEducation) {
                                        $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
                                    }
                                    $html .= '</select>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'number') {
                                    $html .= '<input ' . $row2['validation'] . ' type="number" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                } else if ($fldArr[$row2['fieldtype']]['type'] == 'currentrange') {
                                    $html .= '<label class="pb-date static_label">From</label>';
                                    $html .= '<label class="pb-date static_label">To</label>';
                                    $html .= '<input autocomplete="off" ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="from"  type="text" class="form-control datepicker nocPicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                    $html .= '<input autocomplete="off"  ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="to"  type="text" onchange="position_date(this,' . $row2['id'] . ',' . $_POST['pid'] . ',2' . ')" class="form-control datepicker nocPicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                    $html .= '<div class="presCheck"><input type="checkbox" class="present_checkbox" onchange="if(presentBox(this)==false){return false;}getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')"><span class="presentCheckbox static_label">Present</span></div>';
                                } else {
                                    $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                }
                                $html .= '</div></div></div>';


                                $arrCheck[$row2['id']] = $row2['id'];
                            }

                            for ($i = 0; $i <= $grpArrcount; $i++) {
                                $count++;
                            }


                            $row['gData'] = $html;
                        } else {
                            continue;
                        }
                    } else if ($row['casetype'] == 'existing') {
                        if ($row['questiontype'] == 'm_question') {
                            $row['questiontype'] = 'sm_question';
                            $row['existing_sqid'] = $row['existing_qid'];
                        } else if ($row['questiontype'] == 's_question') {
                            $row['questiontype'] = 'm_question';
                            $row['existing_qid'] = $row['existing_sid'];
                        }
                        $row['existing_data'] = getData($conn, 'existing', $row, $_POST['id'], $_POST['pid']);
                    } else if ($row['fieldtype'] == 1 && $row['labeltype'] == 1) {
                        while ($row_label = mysqli_fetch_assoc($getLabels)) {

                            $op = $row_label['label'];
                            //  Translation Check
                            if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
                                if ($row_label['label_' . $col] != '') {
                                    $op = $row_label['label_' . $col];
                                }
                            }
                            $radio .= '<input id="' . $row_label['label'] . '_' . $row['id'] . '" ' . $row['validation'] . '  type="radio" class="radioButton" id="' . $row_label['value'] . '_' . $row['id'] . '" name="n[sub_question_' . $row['id'] . ']" onClick="getQuestion3(this,' . $row['id'] . ' , ' . $row['question_id'] . ')" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                        }
                        $row['radios'] = $radio;
                        $radio = '';
                    } else if ($row['fieldtype'] == 7) {
                        while ($row_label = mysqli_fetch_assoc($getLabels)) {
                            $op = $row_label['label'];
                            //  Translation Check
                            if ($_GET['Lang'] !== 'english' && $_GET['Lang'] !== '') {
                                if ($row_label['label_' . $col] != '') {
                                    $op = $row_label['label_' . $col];
                                }
                            }
                            $radio .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                        }
                        $row['dropdown'] = $radio;
                        $radio = '';
                    } else {
                        $row['other'] = $row['casetype'];
                        $row['check'] = 0;
                    }

                    // Translation Check
                    if ($_GET['Lang'] !== 'english') {
                        if ($row['question_' . $col] !== '' && $row['question_' . $col] !== null) {
                            $row['question'] = $row['question_' . $col];
                        }
                        if ($row['notes_' . $col] !== '' && $row['notes_' . $col] !== null) {
                            $row['notes'] = $row['notes_' . $col];
                        }
                    }
                    $arrQuestion[] = $row;
                }
            }

            //-------multi condition case type----------
            $select = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['id']}' and casetype = 'multicondition'");
            if (mysqli_num_rows($select) > 0) {
                while($r=mysqli_fetch_assoc($select))
                {
                    if(getMultiCondition($_POST,$r['id'])=='true')
                    {
                        $t['casetype']='multicondition';
                        $t['question_id']=$r['id'];
                        $t['satisfy']='true';
                        $t['parent_id']=$_POST['id'];
                        $t['html']=getMultiConditionQuestion($r['id'],0);
                        $arrQuestion[] =$t;
                    }
                    else
                    {
                        $t['casetype']='multicondition';
                        $t['question_id']=$r['id'];
                        $t['satisfy']='false';
                        $t['parent_id']=$_POST['id'];
                        $arrQuestion[]=$t;
                    }
                }
            }

            die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'country' => $countryArray, 'education' => $educationArray, 'MultiCondition' => $multArray)));
        }
        else {
            die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'a' => $quesRow['casetype'], 'country' => $countryArray, 'education' => $educationArray, 'MultiCondition' => $multArray)));
        }
    }
}
//------------------------------------------------------------------

//------------returns the questions for level 1 and level 2-----------------------------
if ($_GET['h'] == 'getQuestion3') {

    $arrQuestion = array();
    $arrCheck = array();


    //------ checking multi condition case type-----------------
    $select = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['qid']}' and casetype = 'multicondition'");
    if (mysqli_num_rows($select) > 0) {
        while($r=mysqli_fetch_assoc($select))
        {
            if(getMultiCondition($_POST,$r['id'])=='true')
            {
                $t['casetype']='multicondition';
                $t['question_id']=$r['id'];
                $t['satisfy']='true';
                $t['parent_id']=$_POST['qid'];
                $t['html']=getMultiConditionQuestion($r['id'],1);
                $arrQuestion[] =$t;
            }
            else
            {
                $t['casetype']='multicondition';
                $t['question_id']=$r['id'];
                $t['satisfy']='false';
                $t['parent_id']=$_POST['qid'];
                $arrQuestion[]=$t;
            }
        }
    }
    //------ checking existing check case type-----------------
    $select = mysqli_query($conn, "SELECT * FROM sub_questions where question_id = '{$_POST['qid']}' and existing_sid='{$_POST['id']}'");
    if (mysqli_num_rows($select) > 0) {

        while($row=mysqli_fetch_assoc($select))
        {
            $ans = check_cond2(ltrim(rtrim($_POST['value'])), $row['group_operator'], ltrim(rtrim($row['value'])));
            if ($row['val_separator'] == 1) {
                $ans = false;
                $value = explode(';', $row['value']);
                foreach ($value as $v) {
                    $ans = check_cond2($_POST['value'], $row['group_operator'], ltrim(rtrim($v)));
                    if ($ans == true) {
                        break;
                    }
                }
            }
            if ($row['value'] == 'None' || $ans == true) {
                if ($row['grade'] == 0) {
                    if(getExistingCheckQuestion($row)!==false)
                    {
                        $t['casetype']='existingcheck';
                        $t['html']=getExistingCheckQuestion($row);
                        $arrQuestion[] =$t;
                    }
                }
                else {
                    $grade = $row['question'];
                    $type = $row['user_type'];
                }
            }

        }


    }

    //------ checking other case types-----------------
    $quesCheck = mysqli_query($conn, "select * from level2_sub_questions where question_id={$_POST['id']} and casetype='movescore'");
    if (mysqli_num_rows($quesCheck) > 0) {

        $quesRow = mysqli_fetch_assoc($quesCheck);
        $fetLogic = '';
        $getLogic = mysqli_query($conn, "SELECT * FROM level2_ques_logics WHERE s_id = '{$quesRow['id']}'");
        if (mysqli_num_rows($getLogic) > 0) {
            $fetLogic = mysqli_fetch_assoc($getLogic);

            if ($_POST['value'] == $fetLogic['value'] || $fetLogic['value'] == 'None') {
                $s = mysqli_query($conn, "select * from score where id ={$quesRow['score_id']}");
                $r = mysqli_fetch_assoc($s);
                $row['ques_case'] = $quesRow['casetype'];
                $row['scoreID'] = $r['scoreID'];
                $arrQuestion[] = $row;
                die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'country' => $countryArray, 'education' => $educationArray, 'MultiCondition' => $multArray)));
            }
        }
    }
    $countI = 0;
    $html = '';
    $select = mysqli_query($conn, "SELECT * FROM level2_sub_questions where question_id = '{$_POST['id']}' ");
    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $row['org_question'] = $row['question'];
            $row['org_notes'] = $row['notes'];
            $getLogic = mysqli_query($conn, "SELECT * FROM level2_ques_logics WHERE s_id = '{$row['id']}'");
            $fetLogic = mysqli_fetch_assoc($getLogic);
            $getLabels = mysqli_query($conn, "select * from level2 where question_id={$row['question_id']} ");
            $noc_attr = 'data-noc="' . $row['noc_flag'] . '" data-position="' . $row['position_no'] . '" data-type="' . $row['noc_type'] . '" data-label="' . $row['user_type'] . '"';
            $permission = '';
            if ($row['permission'] == 1) {
                $permission = 'permitted';
            } else {
                $permission = 'forbidden';
            }
            if (check_cond2($_POST['value'], $fetLogic['operator'], $fetLogic['value']) || $fetLogic['value'] == 'None') {
                $row['questionValue'] = $fetLogic['value'];
                $row['questionOperator'] = $fetLogic['operator'];
                $row['field'] = $fieldArr[$row['fieldtype']]['type'];
                if ($row['casetype'] == 'multicondition' || $row['casetype'] == 'existingcheck') {
                    continue;
                } else if ($row['casetype'] == 'group') {
                    $row['group_data'] = getData($conn, 'group', $row, $_POST['id'], $_POST['pid']);
                } else if ($row['casetype'] == 'groupques') {
                    $row['group_data2'] = getData($conn, 'groupques', $row, $_POST['id'], $_POST['pid']);
                } else if ($row['casetype'] == 'movegroup') {
                    $grpArr =
                    $questionID = 0;
                    if ($row['questiontype'] == 'm_question') {
                        $questionID = $row['existing_qid'];
                    } else if ($row['questiontype'] == 'sm_question') {
                        $questionID = $row['existing_sqid'];
                    } else {
                        $questionID = $row['existing_sid'];
                    }

                    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
                    $fldArr = array();
                    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
                        $fldArr[$fld['id']] = $fld;
                    }

                    $row['check'] = 4;
                    $row['checkQuesID'] = $questionID;
                    $row['hideQuesID'] = $row['group_ques_id'];


                    $row['checkVal'] = $row['value'];
                    $row['checkOp'] = $row['group_operator'];
                    $getQuestion = mysqli_query($conn, "SELECT * FROM questions WHERE id = '$questionID'");
                    $ques = mysqli_fetch_assoc($getQuestion);
                    $row['checkQuestField'] = $fieldArr[$ques['fieldtype']]['type'];

                    $get = mysqli_query($conn, "SELECT * FROM questions where group_id = '{$row['group_id']}' and submission_type='before'");

                    if (mysqli_num_rows($get) > 0) {
                        while ($row2 = mysqli_fetch_assoc($get)) {
                            $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';
                            $row2['org_question'] = $row2['question'];
                            $row2['org_notes'] = $row2['notes'];
                            // Translation Check
                            if ($_GET['Lang'] !== 'english') {
                                if ($row2['question_' . $row2] !== '' && $row2['question_' . $col] !== null) {
                                    $row2['question'] = $row2['question_' . $col];
                                }
                                if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                                    $row2['notes'] = $row2['notes_' . $col];
                                }
                            }

                            $permission = '';
                            if ($row2['permission'] == 1) {
                                $permission = 'permitted';
                            } else {
                                $permission = 'forbidden';
                            }
                            if ($row['group_ques_id'] == $row2['id'] && $count == $countI) {

                                $html .= '<div style="display:none" class="main_parent_' . $row2['id'] . '">';
                            } else {

                                if ($count == $countI) {
                                    $row['checkQuestField'] = '';
                                    $html .= '<div class="main_parent_' . $row2['id'] . '">';
                                } else {
                                    $html .= '<div class="displayNone' . $row2['id'] . ' main_parent_' . $row2['id'] . '">';
                                }
                            }
                            $countI++;
                            $html .= '<div class="form-group sub_question_div sques_' . $_POST['id'] . '" id="question_div_2_' . $row2['id'] . '">';


                            if ($row2['notes'] != '') {
                                $notes = $row2['notes'];

                                $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';
                            }
                            $ques_label = $row2['question'];


                            $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';

                            $html .= '<div class="input-group input-group-merge ' . $permission . '  ' . $display_class . '">';
                            if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
                                $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
                                $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker age" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
                                $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {
                                $yes = 'Yes';
                                $no = 'No';

                                // Translation Check
                                if ($_GET['Lang'] !== 'english') {
                                    $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                                    if (mysqli_num_rows($getLabels) > 0) {
                                        $label_row = mysqli_fetch_assoc($getLabels);
                                        $yes = $label_row['label_' . $col];
                                    }
                                    $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                                    if (mysqli_num_rows($getLabels) > 0) {
                                        $label_row = mysqli_fetch_assoc($getLabels);
                                        $no = $label_row['label_' . $col];
                                    }
                                }

                                $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row['validation'] . ' type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" value="Yes" ' . $noc_attr . '><span class="customLabel" data-org="Yes">' . $yes . '</span>';
                                $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" value="No" ' . $noc_attr . '><span class="customLabel" data-org="No">' . $no . '</span>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
                                $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row2['id']} ");
                                while ($row_label = mysqli_fetch_assoc($getLabels)) {
                                    $op = $row_label['label'];
                                    //  Translation Check
                                    if ($_GET['Lang'] !== 'english') {
                                        if ($row_label['label_' . $col] != '') {
                                            $op = $row_label['label_' . $col];
                                        }
                                    }
                                    $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                                }
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {
                                $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row2['id']} ");
                                $html .= '<select ' . $row2['validation'] . ' name="n[question_' . $row2['id'] . ']" class="form-control" onchange="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" ' . $noc_attr . '>';
                                $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

                                while ($row_label = mysqli_fetch_assoc($getLabels)) {
                                    $op = $row_label['label'];
                                    //  Translation Check
                                    if ($_GET['Lang'] !== 'english') {
                                        if ($row_label['label_' . $col] != '') {
                                            $op = $row_label['label_' . $col];
                                        }
                                    }
                                    $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                                }
                                $html .= '</select>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
                                $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {
                                $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" onchange="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                                foreach ($countryArray as $getCountries) {
                                    $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
                                }
                                $html .= '</select>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
                                $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                                foreach ($educationArray as $getEducation) {
                                    $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
                                }
                                $html .= '</select>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'number') {
                                $html .= '<input ' . $row2['validation'] . ' type="number" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                            } else if ($fldArr[$row2['fieldtype']]['type'] == 'currentrange') {
                                $html .= '<label class="pb-date static_label">From</label>';
                                $html .= '<label class="pb-date static_label">To</label>';
                                $html .= '<input autocomplete="off"  data-date="YYYY-MM-DD" data-id="from"  type="text" class="form-control datepicker nocPicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                $html .= '<input autocomplete="off"  data-date="YYYY-MM-DD" data-id="to"  type="text" onchange="position_date(this,' . $row2['id'] . ',' . $_POST['pid'] . ',2' . ')" class="form-control datepicker nocPicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                                $html .= '<div class="presCheck"><input type="checkbox" class="present_checkbox" onchange="if(presentBox(this)==false){return false;}getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')"><span class="presentCheckbox static_label">Present</span></div>';
                            } else {
                                $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="getQuestion(this,' . $row2['id'] . ',' . $_POST['pid'] . ')" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                            }
                            $html .= '</div></div></div>';


                            $arrCheck[$row2['id']] = $row2['id'];
                        }

                        for ($i = 0; $i <= $grpArrcount; $i++) {
                            $count++;
                        }


                        $row['gData'] = $html;
                    } else {
                        continue;
                    }
                } else if ($row['casetype'] == 'existing') {
                    $row['existing_data'] = getData($conn, 'existing', $row, $_POST['id'], $_POST['pid']);
                } else if ($row['fieldtype'] == 1 && $row['labeltype'] == 1) {
                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                        $op = $row_label['label'];
                        //  Translation Check
                        if ($_GET['Lang'] !== 'english') {
                            if ($row_label['label_' . $col] != '') {
                                $op = $row_label['label_' . $col];
                            }
                        }
                        $radio .= '<input id="' . $row_label['label'] . '_' . $row['id'] . '" ' . $row['validation'] . ' type="radio" class="radioButton" name="n[question_' . $row['id'] . ']" onClick="getQuestion(this,' . $row['id'] . ',' . $_POST['pid'] . ')" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                    }
                    $row['radios'] = $radio;
                } else if ($row['fieldtype'] == 7) {
                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                        $op = $row_label['label'];
                        //  Translation Check
                        if ($_GET['Lang'] !== 'english') {
                            if ($row_label['label_' . $col] != '') {
                                $op = $row_label['label_' . $col];
                            }
                        }
                        $radio .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                    }
                    $row['dropdown'] = $radio;
                    $row['other'] = $row['casetype'];
                    $row['check'] = 1;
                } else {
                    $row['other'] = $row['casetype'];
                    $row['check'] = 0;
                }

                $arrQuestion[] = $row;
            }
        }
        die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'country' => $countryArray, 'education' => $educationArray,'grade'=>$grade,'type'=>$type)));
    } else {
        die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'country' => $countryArray, 'education' => $educationArray,'grade'=>$grade,'type'=>$type)));
    }
}
//------------------------------------------------------------------

//------------returns the after form submission questions-----------------------------
if ($_GET['h'] == 'getQuestion6') {
    $arrQuestion = array();
    $html = '';
    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
    $fldArr = array();
    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
        $fldArr[$fld['id']] = $fld;
    }

    $html = '';
    if ($_POST['questiontype'] == 'm_question') {
        $get = mysqli_query($conn, "SELECT * FROM questions where id = '{$_POST['id']}'");
        $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$_POST['id']} ");
        $row2 = mysqli_fetch_assoc($get);

        $class = 'main_parent_' . $row2['id'] . ' afterSub';
        $name = 'n[question_' . $row2['id'] . ']';
        $q = 'getQuestion(this,' . $row2['id'] . ',' . $_POST['id'] . ')';
    } else {
        $get = mysqli_query($conn, "SELECT * FROM sub_questions where id = '{$_POST['id']}' ");
        $getLabels = mysqli_query($conn, "select * from level1 where question_id={$_POST['id']}");
        $row2 = mysqli_fetch_assoc($get);


        $class = 'parent_' . $row2['id'] . ' afterSub';
        $name = 'n[sub_question_' . $row2['id'] . ']';
        $q = 'getQuestion3(this,' . $row2['id'] . ',' . $row2['question_id'] . ')';
    }

    if (mysqli_num_rows($get) > 0) { {
        $permission = '';
        if ($row2['permission'] == 1) {
            $permission = 'permitted';
        } else {
            $permission = 'forbidden';
        }
        $row2['org_question'] = $row2['question'];
        $row2['org_notes'] = $row2['notes'];
        // Translation Check
        if ($_GET['Lang'] !== 'english') {
            if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                $row2['question'] = $row2['question_' . $col];
            }
            if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                $row2['notes'] = $row2['notes_' . $col];
            }
        }
        $html .= '<div class="' . $class . '">';
        $html .= '<div class="form-group sub_question_div sub_question_div2 sques_' . $_POST['id'] . '" id="question_div_' . $row2['id'] . '">';

        if ($row2['notes'] != '') {
            $notes = $row2['notes'];

            $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';
        }
        $ques_label = $row2['question'];


        $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';

        $html .= '<div class="input-group input-group-merge  ' . $permission . ' ' . $display_class . '">';
        if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
            $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="' . $name . '">';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
            $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker age" name="' . $name . '">';
            $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
            $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="n[sub_question_' . $row2['id'] . ']">';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {


            $yes = 'Yes';
            $no = 'No';
            // Translation Check
            if ($_GET['Lang'] !== 'english') {
                $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                if (mysqli_num_rows($getLabels) > 0) {
                    $label_row = mysqli_fetch_assoc($getLabels);
                    $yes = $label_row['label_' . $col];
                }
                $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                if (mysqli_num_rows($getLabels) > 0) {
                    $label_row = mysqli_fetch_assoc($getLabels);
                    $no = $label_row['label_' . $col];
                }
            }

            $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row2['validation'] . ' type="radio" class="radioButton" name="' . $name . '" onClick="' . $q . '" value="Yes"><span class="customLabel" data-org="Yes">' . $yes . '</span>';
            $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="' . $name . '" onClick="' . $q . '" value="No"><span class="customLabel" data-org="No">' . $no . '</span>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
            while ($row_label = mysqli_fetch_assoc($getLabels)) {
                $op = $row_label['label'];
                //  Translation Check
                if ($_GET['Lang'] !== 'english') {
                    if ($row_label['label_' . $col] != '') {
                        $op = $row_label['label_' . $col];
                    }
                }
                $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="' . $name . '" onClick="' . $q . '" value="' . $row_label['value'] . '"><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
            }
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {
            $html .= '<select ' . $row2['validation'] . ' name="n[sub_question_' . $row2['id'] . ']" class="form-control" onchange="' . $q . '">';
            $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

            while ($row_label = mysqli_fetch_assoc($getLabels)) {
                $op = $row_label['label'];
                //  Translation Check
                if ($_GET['Lang'] !== 'english') {
                    if ($row_label['label_' . $col] != '') {
                        $op = $row_label['label_' . $col];
                    }
                }
                $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
            }
            $html .= '</select>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
            $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="' . $q . '">';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {
            $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" onchange="' . $q . '" name="' . $name . '">';
            $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
            foreach ($countryArray as $getCountries) {
                $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
            }
            $html .= '</select>';
        } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
            $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="' . $q . '" name="' . $name . '">';
            $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
            foreach ($educationArray as $getEducation) {
                $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
            }
            $html .= '</select>';
        } else {
            $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="' . $q . '" class="form-control" name="' . $name . '">';
        }
        $html .= '</div></div></div>';
    }
        $row['html'] = $html;


        $arrQuestion[] = $row;


        die(json_encode(array('Success' => 'true', 'data' => $arrQuestion, 'class' => $class)));
    } else {
        die(json_encode(array('Success' => 'true', 'data' => $arrQuestion)));
    }
}
//------------------------------------------------------------------



$userExperience = 0; // sum the experience of all the positions of user
$spouseExperience = 0; // sum the experience of all the positions of spouse
$userEmployment = 0; // user is currently employed or not
$spouseEmployment = 0; // spouse is currently employed or not
$final_score = 0; //temp


$scoreArray = array(); // stores the validated values/rows of scores for user
$nocScore = array(); // stores the validated NOC values/NOC rows of scores for user
$scoreArray2 = array(); // stores the validated moving conditions (move to score/question/comment) of scores for user

$spouseScoreArray2 = array(); // stores the validated moving conditions (move to score/question/comment) of scores for spouse
$spouseScoreArray = array(); // stores the validated values/rows of scores for spouse
$spouseNocScore = array(); // stores the validated NOC values/NOC rows of scores for spouse
$casesArray = array(); // using to store cases in DB
$removeIdentical = array(); // using to store identical IDs and save loop from running these
$globalArray = array();// using to store score IDs which are set in global rules

$user_noc=array();
$spouse_noc=array();



////----------To save form as a draft for signed and professional account users-----------------------------------
if ($_GET['h'] == "saveAsDraft") {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $outArr = array();
    $q = 0;
    foreach (json_decode($_POST['formData'], true) as $k => $v) {

        $quest = explode('_', $v['name']);
        if (sizeof($quest) > 2) {

            $qID = substr($quest[2], 0, -1);
            $ques = mysqli_query($conn, "select question from sub_questions where id=$qID");
            $rques = mysqli_fetch_assoc($ques);
            $draftquesArray[$q] = $rques['question']; // all questions
            $draftansArray[$q] = $v['value']; // all answers

            $q++;
        } else {
            if (sizeof($quest) > 1) {
                $qID = substr($quest[1], 0, -1);
                $ques = mysqli_query($conn, "select question,fieldtype from questions where id=$qID");
                $rques = mysqli_fetch_assoc($ques);
                $draftquesArray[$q] = $rques['question']; // all questions
                $draftansArray[$q] = $v['value']; // all answers


                $q++;
            }
        }
    }
    $_POST['questions']  = json_encode($draftquesArray);
    $_POST['answers'] =  json_encode($draftansArray);

    unset($_POST['formData']);



    $prevIdUserId = $_POST['userId'];

    $is_pro = $_POST['is_pro'];
    unset($_POST['is_pro']);
    $outArr['fflag'] = "";
    $is_overwrite = 'no';
    if (isset($_POST['is_overwrite'])) {
        $is_overwrite = $_POST['is_overwrite'];
        unset($_POST['is_overwrite']);
        $outArr['fflag'] .= "15,";
    }
    $is_overwrite = "yes"; // automatically overwrite
    $sfrom_id = "";
    if (isset($_POST['sformId'])) {
        $sfrom_id = $_POST['sformId'];
        unset($_POST['sformId']);
    }
    $sdraftId = "";
    if (isset($_POST['sdraftId'])) {
        $sdraftId = $_POST['sdraftId'];
        unset($_POST['sdraftId']);
    }


    //   sfrom_id
    $checkDraftQueryResult = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE `userId` = '$prevIdUserId' ");

    if (mysqli_num_rows($checkDraftQueryResult) > 0) {

        $outArr['fflag'] .= "1,";
        if ($is_pro == 'no') {
            $outArr['fflag'] .= "2,";

            $drftrow = mysqli_fetch_assoc($checkDraftQueryResult);


            $draftId = $drftrow['id'];

            unset($_POST['id']);
            $ReqT = db_pair_str2($_POST);


            if (mysqli_query($conn, "UPDATE accounts_form_drafts SET $ReqT WHERE `id` = '$draftId'")) {
                $outArr['fflag'] .= "3,";
                mysqli_query($conn, "UPDATE accounts_form_drafts SET `is_draft` = '1', `priority` = '1' , `prof_priority` = 1 WHERE `id` = '$draftId'");

                $outArr['status'] = '1';
                $outArr['show_modal'] = '0';
            } else {
                $outArr['fflag'] .= "4,";
                $outArr['status'] = '0';
                $outArr['err'] = mysqli_error($conn);
            }
        }
        else {

            if(!empty($sfrom_id))
            {
                $checkDraftQueryResult = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE `form_id` = '$sfrom_id' AND `id` = '$sdraftId'  ");
            }
            else
            {
                $checkDraftQueryResult = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE `id` = '$sdraftId'  ");
            }


            if (mysqli_num_rows($checkDraftQueryResult) > 0)
            {
                $outArr['fflag'] .= "5,";
                if ($is_overwrite == 'no') {
                    $getDraftFromFormRow = mysqli_fetch_assoc($checkDraftQueryResult);
                    $outArr['fflag'] .= "6,";
                    $outArr['show_modal'] = '1';
                    $outArr['status'] = '1';
                    $outArr['s_draft_id'] = $getDraftFromFormRow['id'];
                    $sdraftId = $outArr['s_draft_id'];
                } else {
                    $outArr['fflag'] .= "7,";
                    $drftrow = mysqli_fetch_assoc($checkDraftQueryResult);


                    $draftId = $drftrow['id'];

                    unset($_POST['id']);
                    unset($_POST['is_overwrite']);
                    $ReqT = db_pair_str2($_POST);


                    if (mysqli_query($conn, "UPDATE accounts_form_drafts SET $ReqT WHERE `id` = '$draftId'")) {
                        $outArr['fflag'] .= "8,";

                        mysqli_query($conn, "UPDATE accounts_form_drafts SET `is_draft` = '1' , `prof_priority` = 1 WHERE `id` = '$draftId'");


                        $outArr['status'] = '1';
                        $outArr['show_modal'] = '0';
                    } else {
                        $outArr['fflag'] .= "9,-" . mysqli_error($conn);
                        $outArr['status'] = '0';
                        $outArr['err'] = mysqli_error($conn);
                    }
                }
            } else
            {
                if(!empty($sfrom_id))
                {
                    $getDraftFromFormQuery = mysqli_query($conn,"SELECT * FROM `accounts_form_drafts` WHERE `form_id` = '$sfrom_id'");
                    if(mysqli_num_rows($getDraftFromFormQuery) > 0)
                    {
                        $getDraftFromFormRow  = mysqli_fetch_assoc($getDraftFromFormQuery);
                        if ($is_overwrite == 'no') {
                            $outArr['fflag'] .= "6,";
                            $outArr['show_modal'] = '1';
                            $outArr['status'] = '1';
                            $outArr['s_draft_id'] = $getDraftFromFormRow['id'];
                        }
                        else
                        {
                            $outArr['fflag'] .= "7,";
                            $drftrow = mysqli_fetch_assoc($checkDraftQueryResult);


                            $draftId = $drftrow['id'];

                            unset($_POST['id']);
                            unset($_POST['is_overwrite']);
                            $ReqT = db_pair_str2($_POST);


                            if (mysqli_query($conn, "UPDATE accounts_form_drafts SET $ReqT WHERE `id` = '$draftId'")) {
                                $outArr['fflag'] .= "8,";
                                mysqli_query($conn, "UPDATE accounts_form_drafts SET `prof_priority` = 1 WHERE `id` = '$draftId' or form_id='$sfrom_id'");




                                $outArr['status'] = '1';
                                $outArr['show_modal'] = '0';
                            } else {
                                $outArr['fflag'] .= "9,-" . mysqli_error($conn);
                                $outArr['status'] = '0';
                                $outArr['err'] = mysqli_error($conn);
                            }
                        }

                    }
                    else
                    {
                        $_POST['form_id'] = $sfrom_id;
                        $ReqT = db_pair_str2($_POST);
                        if (mysqli_query($conn, "INSERT into accounts_form_drafts SET $ReqT")) {
                            $outArr['fflag'] .= "10-,";

                            $outArr['status'] = '1';
                            $outArr['s_draft_id'] = mysqli_insert_id($conn);
                            $sdraftId = $outArr['s_draft_id'];
                            $outArr['show_modal'] = '0';
                        } else {
                            $outArr['fflag'] .= "11";
                            $outArr['status'] = '0';
                            $outArr['err'] = mysqli_error($conn);
                        }
                    }
                }
                else
                {
                    $ReqT = db_pair_str2($_POST);
                    if (mysqli_query($conn, "INSERT into accounts_form_drafts SET $ReqT")) {
                        $outArr['fflag'] .= "10^,";

                        $outArr['status'] = '1';
                        $outArr['s_draft_id'] = mysqli_insert_id($conn);
                        $sdraftId = $outArr['s_draft_id'];
                        $outArr['show_modal'] = '0';
                    } else {
                        $outArr['fflag'] .= "11";
                        $outArr['status'] = '0';
                        $outArr['err'] = mysqli_error($conn);
                    }
                }





            }
        }

    }
    else {

        if ($is_pro == 'no') {

            $ReqT = db_pair_str2($_POST);
            $insertionQuery =  "INSERT into accounts_form_drafts SET $ReqT";

            if (mysqli_query($conn, $insertionQuery)) {

                $outArr['fflag'] .= "10*,";

                $outArr['status'] = '1';
                $outArr['s_draft_id'] = mysqli_insert_id($conn);
                $sdraftId = $outArr['s_draft_id'];
                $outArr['show_modal'] = '0';


            } else {

                $outArr['fflag'] .= "11";
                $outArr['status'] = '0';
                $outArr['err'] = mysqli_error($conn);
            }


        }
        else {

//            agr pehly form submit kiya hua hai aur save as draft kr rehy hain aur pehly draft majood nahi hai to draft save ho ga but usky saath form  ki id b jaye ge
            if(empty($sfrom_id))
            {
                $sfrom_id = 0;
            }
            $_POST['form_id'] = $sfrom_id;
            $ReqT = db_pair_str2($_POST);
            if (mysqli_query($conn, "INSERT into accounts_form_drafts SET $ReqT")) {
                $outArr['fflag'] .= "10#,";

                $outArr['status'] = '1';
                $outArr['s_draft_id'] = mysqli_insert_id($conn);
                $sdraftId = $outArr['s_draft_id'];
                $outArr['show_modal'] = '0';
            } else {
                $outArr['fflag'] .= "11";
                $outArr['status'] = '0';
                $outArr['err'] = mysqli_error($conn);
            }
        }


    }

    autoSave($sdraftId);

    echo json_encode($outArr);
    die();
}
//------------------------------------------------------------------





if($_GET['h'] == 'assignFormToSigned')
{
    // this block of if is use to assigned guest user submitted form to signed user which not have any submitted form
    // you can find all related code by searching  #code_123

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $sformId =  $_POST['sformId'];
    $userId =  $_POST['userId'];

    mysqli_query($conn,"UPDATE `user_form` SET `user_id` = '$userId'  WHERE `id` = '$sformId' ");
    die();
}
// end assign guest form to signed user




////----------complete form submission wih or without running score IDs-----------------------------------
if ($_GET['h'] == 'submitForm') {






    if (!isset($_POST) || sizeof($_POST) <= 0) {
        die(json_encode(array('Success' => 'false', 'Msg' => 'No post data found')));
    }
    if ($_POST['email'] == '' || $_POST['phone'] == '' || $_POST['name'] == '') {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Required fields are empty')));
    }


    $newArray = array(); // temporary
    $dobArray = array(); // temporary
    $gradesArray = array(); // temporary

    $mainQuesArray = array(); // stores the posted values/answer of main question with their ID as index
    $subQuesArray = array(); // stores the posted values/answer of sub question with their ID as index
    $quesArray = array(); // stores the posted labels of all questions
    $ansArray = array(); // stores the posted answers of all questions
    $userGradesArray = $_POST['userGrades']; // stores the posted grades array of user
    $spouseGradesArray = $_POST['spouseGrades']; // stores the posted grades array of spouse

    $sID = 0;
    $q = 0;


    //---array to check labels----------
    $labelArray = ['0s', '1s', '2s', '3s', '4s', '5s', '6s', '7s', '8s', '9s', '10s', '0w', '1w', '2w', '3w', '4w', '5w', '6w', '7w', '8w', '9w', '10w', '0r', '1r', '2r', '3r', '4r', '5r', '6r', '7r', '8r', '9r', '10r', '0l', '1l', '2l', '3l', '4l', '5l', '6l', '7l', '8l', '9l', '10l'];



    //-----------stores the values/answers of questions with their ID as Index.... and questions/answers arrays are being created here
    foreach ($_POST['form'] as $k => $v) {

        $quest = explode('_', $v['name']);
        if($quest[0]=='show')
        {
            $ansArray[$q] = $v['value']; // all answers
            $quesArray[$q]=$v['name'];// all names
            $q++;
            continue;
        }
        if (sizeof($quest) > 2) {
            $qID = substr($quest[2], 0, -1);
            if (strpos($qID, ']') == true) {
                $new_id = substr($qID, 0, -1);
                $qID = '1000_' . $new_id;
                $quesArray[$q] = 'Please Describe';
            } else {
                $ques = mysqli_query($conn, "select question from sub_questions where id='$qID'");
                $rques = mysqli_fetch_assoc($ques);
                $quesArray[$q] = $rques['question']; // all questions
            }

            $ansArray[$q] = $v['value']; // all answers
            $quesArray2[$q] = $v['name']; // all names

            $q++;
            $subQuesArray[$qID] = $v['value']; // values of sub questions
        } else {
            $qID = substr($quest[1], 0, -1);
            if (strpos($qID, ']') == true) {
                $new_id = substr($qID, 0, -1);
                $qID = '1000_' . $new_id;
                $quesArray[$q] = 'Please Describe';
            } else {
                $ques = mysqli_query($conn, "select question from questions where id='$qID'");
                $rques = mysqli_fetch_assoc($ques);
                $quesArray[$q] = $rques['question']; // all questions
            }

            $ansArray[$q] = $v['value']; // all answers
            $quesArray2[$q] = $v['name']; // all names

            $q++;
            $mainQuesArray[$qID] = $v['value']; // values of main questions
        }
        $newArray[$qID] = $v['value']; //temporary
    }
    $_POST['dob'] = array_filter($_POST['dob'], 'strlen');

    $married = $mainQuesArray[50];
    $relationship = $subQuesArray[106];

    if ($_POST['endCase'] === false || $_POST['endCase'] === 'false') {


        //---------------global rule----------------------
        $global = mysqli_query($conn, "select * from global_rule order by ruleID asc");
        if (mysqli_num_rows($global) > 0) {
            $array1 = array();
            $array2 = array();
            $or = $and = $andCheck = $i = $g = 0;
            $ob = '';
            $cb = '';
            $outer_start_bracket = '';
            $outer_end_bracket = '';
            $lbk_check = false;
            $lbk_check2 = false;
            while ($row = mysqli_fetch_assoc($global)) {
                $rule_id = $row['id'];
                $select1 = mysqli_query($conn, "select * from global_rule_questions where rule_id=$rule_id");
                while ($row1 = mysqli_fetch_assoc($select1)) {

                    $get_ques = '';
                    $check_ques = '';
                    $value = '';
                    if ($row1['question_type'] == 'm_question') {
                        $check_ques = mysqli_query($conn, "select * from questions where id='{$row1['question_id']}'");
                        $value = $mainQuesArray[$row1['question_id']] == '' ? 'aa' : $mainQuesArray[$row1['question_id']];
                    } else {
                        $check_ques = mysqli_query($conn, "select * from sub_questions where id='{$row1['question_id']}'");
                        $value = $subQuesArray[$row1['question_id']] == '' ? 'aa' : $subQuesArray[$row1['question_id']];
                    }

                    if (mysqli_num_rows($check_ques) > 0) {
                        $get_ques = mysqli_fetch_assoc($check_ques);
                        $select2 = mysqli_query($conn, "select * from global_rule_questions where rule_id='$score_id' and id>'{$row1['id']}' limit 1");
                        $getRow = mysqli_fetch_assoc($select2);
                        if ($getRow['question_type'] == 'm_question') {
                            $check_ques2 = mysqli_query($conn, "select * from questions where id='{$getRow['question_id']}'");
                        } else {
                            $check_ques2 = mysqli_query($conn, "select * from sub_questions where id='{$getRow['question_id']}'");
                        }
                        if (mysqli_num_rows($check_ques2) > 0) {
                            $get_ques2 = mysqli_fetch_assoc($check_ques2);
                        }
                    }
                    $sc = 0;
                    //                $value = $newArray[$row1['question_id']] == '' ? 'aa' : $newArray[$row1['question_id']];
                    $value = strtolower(ltrim(rtrim($value)));
                    $dbValue = explode('*', $row1['value']);
                    $dbValue = array_map('trim', $dbValue);
                    $dbValue = array_map('strtolower', $dbValue);

                    $operator = $row1['operator'];
                    $operator2 = $row1['operator'];

                    $condition = $row1['condition2'];
                    $score = $row1['score_number'];
                    $other_case = $row1['other_case'];
                    $row1['uvalue'] = $value;
                    $row['questions'] .= $row1['question_id'] . ',';
                    $row['q_id'] .= $row1['question_id'];
                    $row['question_type'] .= $row1['question_type'];
                    $max = $row['max_score'];
                    $test = $row1['tests'];
                    $user_type = $row1['label_type'];
                    if ($brk_op == '') {
                        $ob = $row1['open_bracket'];
                        $cb = $row1['close_bracket'];
                        $outer_start_bracket = $row1['start_bracket'];
                        $outer_end_bracket = $row1['end_bracket'];
                    }
                    $eb = '';
                    $sb = '';


                    if ($value == 'aa' && $operator == '!=') {
                        $operator = '=';
                    }

                    if ($condition == 'or') {
                        $cond = '||';
                    } else if ($condition == 'and') {
                        $cond = "&&";
                    }
                    $condition = $cond;
                    $other_case2 = $other_case;
                    $ob1 = $ob;
                    $cb1 = $cb;
                    $outer_start_bracket1 = $outer_start_bracket;
                    $outer_end_bracket1 = $outer_end_bracket;
                    for ($d = 0; $d < sizeof($dbValue) - 1; $d++) {

                        if (sizeof($dbValue) > 2) {
                            if ($d == (sizeof($dbValue) - 2)) {
                                $condition = $cond;
                                $other_case2 = $other_case;
                                if ($brk_op == '') {
                                    $ob1 = $ob;
                                    $cb1 = $cb;
                                }
                            } else {
                                $condition = '||';
                                $other_case2 = 'condition';
                                if ($brk_op == '') {
                                    $ob1 = '';
                                    $cb1 = $cb;
                                }
                            }
                        }

                        if ($brk_op == '') {
                            if ($d == 0) {
                                $ob1 = $ob;
                                $outer_start_bracket1 = $outer_start_bracket;
                            } else if ($d == sizeof($dbValue) - 2) {
                                $ob1 = '';
                                $cb1 = $cb;
                                $outer_end_bracket1 = '';
                                $outer_end_bracket1 = $outer_end_bracket;
                            } else {

                                $cb1 = '';
                                $ob1 = '';
                                $outer_start_bracket1 = '';
                                $outer_end_bracket1 = '';
                            }

                            if ($d == 0 && sizeof($dbValue) > 2) {
                                $sb = '(';
                                $cb1 = '';
                                $outer_end_bracket1 = '';
                            } else {
                                $sb = '';
                            }
                            if ($d != 0 && $d == sizeof($dbValue) - 2) {
                                $eb = ')';
                                $outer_start_bracket1 = '';
                            } else {
                                $eb = '';
                            }
                        }

                        if (array_search($dbValue[$d], $labelArray) > -1) {
                            $lbk_check = true;

                            for ($p = 0; $p < 16; $p++) {
                                if (!array_key_exists($p, $scoreArray) || $scoreArray[$p]['for'] != $user_type) {
                                    continue;
                                }
                                if (array_search($scoreArray[$p]['score'], $scoreArray) > -1) {

                                    $lbk_check2 = true;
                                }
                                $s = '';
                                $dd = '';



                                if ($operator2 == '=') {
                                    $operator2 = '==';
                                }


                                if (strlen($scoreArray[$p]['score']) == 2) {
                                    $s = substr($scoreArray[$p]['score'], 1);
                                } else {
                                    $s = $scoreArray[$p]['score'];
                                    $s = substr($s, 2);
                                }

                                if (strlen($dbValue[$d]) == 2) {
                                    $dd = substr($dbValue[$d], 1);
                                } else {
                                    $dd = substr($dbValue[$d], 2);
                                }

                                if ($lang != '') {
                                    if ($s == $dd && $lang == $scoreArray[$p]['lang']) {

                                        if ($test != '') {
                                            if ($test == $scoreArray[$p]['test']) {
                                                $array2[$g] .= $outer_start_bracket1 . $ob1;
                                                $array2[$g] .= $sb;
                                                $array2[$g] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                $array2[$g] .= $eb;
                                                $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                            } else {
                                                continue;
                                            }
                                        } else {
                                            $array2[$g] .= $outer_start_bracket1 . $ob1;
                                            $array2[$g] .= $sb;
                                            $array2[$g] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                            $array2[$g] .= $eb;
                                            $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                        }
                                    } else {
                                        continue;
                                    }
                                } else {
                                    if ($s == $dd) {

                                        if ($test != '') {

                                            if ($test == $scoreArray[$p]['test']) {
                                                $array2[$g] .= $outer_start_bracket1 . $ob1;
                                                $array2[$g] .= $sb;
                                                $array2[$g] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                $array2[$g] .= $eb;
                                                $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                            } else
                                                continue;
                                        } else {
                                            $array2[$g] .= $outer_start_bracket1 . $ob1;
                                            $array2[$g] .= $sb;
                                            $array2[$g] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                            $array2[$g] .= $eb;
                                            $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                        }
                                    } else {
                                        continue;
                                    }
                                }


                                if ($other_case2 != 'condition') {


                                    $array1[$g] = $row;
                                    $row['questions'] = '';
                                    $g++;
                                }
                            }
                            continue;
                        }
                        if ($row1['score_case'] == 2) {
                            if ($operator == '=') {
                                $operator = '==';
                            }

                            if ($row1['label_type'] == 'user' || $row1['label_type'] == '') {
                                for ($p = 0; $p < sizeof($userGradesArray); $p++) {
                                    $array2[$g] .= '"' . $userGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                }
                            } else {
                                for ($p = 0; $p < sizeof($spouseGradesArray); $p++) {
                                    $array2[$g] .= '"' . $spouseGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                }
                            }


                            if ($other_case2 != 'condition') {

                                $array1[$g] = $row;
                                $row['questions'] = '';
                                $g++;
                            }
                            continue;
                        }


                        if ($row1['question_type'] == 'score_type') {
                            if ($operator == '=') {
                                $operator = '==';
                            }
                            $sc = 0;
                            for ($p = 0; $p <= end(array_keys($scoreArray)); $p++) {

                                if ($scoreArray[$p]['type'] == $row1['question_id']) {
                                    $sc += $scoreArray[$p]['score'];
                                }
                            }
                            for ($p = 0; $p < sizeof($nocScore); $p++) {

                                if ($nocScore[$p]['type'] == $row1['question_id']) {
                                    $sc += $nocScore[$p]['score'];
                                }
                            }

                            if ($operator == '-') {
                                $dv = explode('-', $dbValue[$d]);
                                $array2[$g] .= '(' . $sc . '>=' . $dv[0] . ' && ' . $sc . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                            } else {
                                $array2[$g] .= $outer_start_bracket1 . $ob1;
                                $array2[$g] .= $sb;
                                $array2[$g] .= $sc . $operator . $dbValue[$d];
                                $array2[$g] .= $eb;
                                $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                            }
                            if ($other_case2 != 'condition') {


                                $array1[$g] = $row;
                                $row['questions'] = '';
                                $g++;
                            }
                            continue;
                        }

                        if ($operator == '=') {
                            $operator = '==';
                        }

                        if (ctype_digit($value)) {
                            if ($operator == '-') {
                                $dv = explode('-', $dbValue[$d]);
                                $array2[$g] .= '(' . $value . '>=' . $dv[0] . ' && ' . $value . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                            } else {
                                $array2[$g] .= $outer_start_bracket1 . $ob1;
                                $array2[$g] .= $sb;
                                $array2[$g] .= $value . $operator . $dbValue[$d];
                                $array2[$g] .= $eb;
                                $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                            }
                        } else {
                            //                            if ($value == 'aa' && (strpos($get_ques['question'], 'citizenship') !== false || strpos($get_ques['question'], 'Citizenship') !== false)) {
                            //                                if ((strpos($get_ques2['question'], 'citizenship') !== false || strpos($get_ques['question2'], 'Citizenship') !== false) || strpos($get_ques2['question'], 'Country') !== false) {
                            //                                    $condition = '||';
                            //                                }
                            //                            }
                            $array2[$g] .= $outer_start_bracket1 . $ob1;
                            $array2[$g] .= $sb;
                            $array2[$g] .= '"' . $value . '"' . $operator . '"' . $dbValue[$d] . '"';
                            $array2[$g] .= $eb;
                            $array2[$g] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                        }


                        if (($row1['noc_or'] == 1 || $row1['noc_or'] == '1') && (($d != 0 && $d == sizeof($dbValue) - 2) || ($d == 0 && $d == sizeof($dbValue) - 2))) {

                            $s = mysqli_query($conn, "select * from score_questions where score_id=$score_id and other_case!='condition'");
                            $r = mysqli_fetch_assoc($s);
                            $row['score'] = $r['score_number'];
                            $row['other_case'] = $r['other_case'];
                            $row['move_qtype'] = $r['move_qtype'];
                            $row['move_qid'] = $r['move_qid'];
                            $row['move_scoreType'] = $r['move_scoreType'];
                            $row['comments'] = $r['comments'];
                            $row['email'] = $row1['email'];
                            $row['subject'] = $row1['subject'];
                            $row['message'] = $row1['message'];
                            $row['cc'] = $row1['cc'];

                            if ($condition == '&&') {

                                $row['and_check'] = 1;
                                for ($o = 0; $o < sizeof($nocScore); $o++) {
                                    if ($nocScore[$o]['scoreID'] == $row['scoreID']) {
                                        //                                            if($nocScore[$o]['or_check2']==1)
                                        //                                            {
                                        //                                                $row['noc_true']=1;
                                        //                                                break;
                                        //                                            }
                                        //                                            else
                                        //                                            {
                                        //                                                $row['noc_true']=0;
                                        //                                            }
                                        $row['noc_true'] = $nocScore[$o]['noc_verify'];
                                        $row['noc_case'] = $nocScore[$o]['noc_case'];
                                    }
                                }
                            }
                            //                        $selectt = mysqli_query($conn, "select * from global_rule_conditions where rule_id=$rule_id");
                            //                        while($rule=mysqli_fetch_assoc($selectt))
                            //                        {
                            //                            $l['op']=$rule['operator'];
                            //                            $l['rule_id']=$row['ruleID'];
                            //                            $l['score_id']=$rule['value'];
                            //
                            //                            $globalArray[]=$l;
                            //                        }
                            $array1[$g] = $row;
                            $row['questions'] = '';
                            $g++;
                        } else if ($other_case2 != 'condition') {



                            $array1[$g] = $row;
                            $row['questions'] = '';
                            $g++;
                        }
                    }
                }
            }
            $da = '';
            $dd = '';


            for ($j = 0; $j < sizeof($array2); $j++) {

                if ($brk_op != '') {
                    $b = explode($brk_op, $array2[$j]);
                    $d = '';

                    foreach ($b as $a) {
                        if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                            if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                                $a = substr($a, 0, -3);
                            }
                            $d .= '(' . $a . ') ' . $brk_op . ' ';
                        }
                    }
                } else {

                    $d = $array2[$j];
                }
                if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
                    $d = substr($d, 0, -3);
                }
                $d = '(' . $d . ')';
                $orCheck = false;
                $noc_or = false;
                $cc = '||';
                $nb1 = '(';
                $nb2 = ')';
                $ad = '';
                $eeb = '';
                for ($o = 0; $o < sizeof($nocScore); $o++) {
                    if ($nocScore[$o]['scoreID'] == $array1[$j]['scoreID']) {
                        if ($nocScore[$o]['or_check'] == 1 && $nocScore[$o]['or_check2'] != 1) {
                            $orCheck = true;
                            break;
                        }
                    }
                }
                $check = false;


                if ($array1[$j]['and_check'] == 1) {
                    if ($array1[$j]['ruleID'] == $da || $da == '') {

                        $noc_true = $array1[$j]['noc_case'];
                        if (strpos($noc_true, '&&') !== false) {

                            $b = explode('&&', $noc_true);
                            $noc_true = '';
                            for ($u = 0; $u < sizeof($b) - 1; $u++) {
                                if ($b[$u] != '' && $b[$u] != ' ' && $b[$u] != null && $b[$u] != NULL) {
                                    if (substr($b[$u], -3) == '&& ' || substr($b[$u], -3) == '|| ') {
                                        $b[$u] = substr($b[$u], 0, -3);
                                    }
                                    $noc_true .= '(' . $b[$u] . ')&& ';
                                }
                            }
                            $noc_true .= '(' . $b[sizeof($b) - 1];
                            $eeb = ')';
                        }

                        if ($bool == true) {
                            $cc = $eeb . '&&';
                            $noc_true = '';
                            $nb1 = '';
                            $nb2 = '';
                        }
                        $dd .= $nb1 . $noc_true . $cc . $d . $nb2;

                        $check = true;
                        if ($array1[$j]['ruleID'] == $array1[$j + 1]['ruleID']) {
                            $bool = true;
                            continue;
                        }
                        $bool = false;
                    }
                }
                $da = $array1[$j]['ruleID'];




                if ($check == true) {
                    $d = $dd;
                    $d = '(' . $d . ')';
                }
                // echo '<br> AND-OR-case (gr)==>' . $d . '--' . $array1[$j]['ruleID'] . '--' . $array1[$j]['score'];


                $c = eval('return ' . $d . ';');
                if (($c == 1 || $orCheck == true) && ($lbk_check == $lbk_check2)) {
                    $gg = mysqli_query($conn, "select * from global_rule_conditions where rule_id={$array1[$j]['id']}");
                    while ($gr = mysqli_fetch_assoc($gg)) {
                        $l['score_id'] = $gr['value'];
                        $l['op'] = $gr['operator'];
                        $globalArray[] = $l;
                    }
                }
            }
        }
        //---------------global rule---------------------

        $select = '';
        $label_check = false;

        if ($_POST['scoreID'] != '') {
            //---------- calls on submit (after form submission) -------------

            if ($_POST['rType'] == 'scoring') {
                $s = mysqli_query($conn, "select * from score where id ='{$_POST['scoreID']}'");
                $r = mysqli_fetch_assoc($s);
                $select = mysqli_query($conn, "select * from score where scoreID >= {$r['scoreID']}  order by cast(scoreID as DECIMAL(8,3)) asc");
            } else if ($_POST['rType'] == 'comment') {
                $select = mysqli_query($conn, "select * from score where scoreID > {$_POST['scoreID']} order by cast(scoreID as DECIMAL(8,3)) asc");
            } else {
                $select = mysqli_query($conn, "select * from score where scoreID >= {$_POST['scoreID']}  order by cast(scoreID as DECIMAL(8,3)) asc");
            }

            if ($_POST['scoreArray'] != '') {
                $scoreArray = $_POST['scoreArray'];
            }
            if ($_POST['nocArray'] != '') {
                $nocScore = $_POST['nocArray'];
            }
            if ($_POST['scoreArray2'] != '') {
                $scoreArray2 = $_POST['scoreArray2'];
            }
            if ($_POST['spouseScoreArray'] != '') {
                $spouseScoreArray = $_POST['spouseScoreArray'];
            }
            if ($_POST['spouseScoreArray2'] != '') {
                $spouseScoreArray2 = $_POST['spouseScoreArray2'];
            }
            if ($_POST['userGrades'] != '') {
                $userGradesArray = $_POST['userGrades'];
            }
            if ($_POST['spouseGrades'] != '') {
                $spouseGradesArray = $_POST['spouseGrades'];
            }
            if ($_POST['spouseNocScore'] != '') {
                $spouseNocScore = $_POST['spouseNocScore'];
            }
            if ($_POST['casesArray'] != '') {
                $casesArray = $_POST['casesArray'];
            }
            if ($_POST['removeIdentical'] != '') {
                $removeIdentical = $_POST['removeIdentical'];
            }
            if ($_POST['user_noc'] != '') {
                $user_noc = $_POST['user_noc'];
            }
            if ($_POST['spouse_noc'] != '') {
                $spouse_noc = $_POST['spouse_noc'];
            }
            $label_check = true;
        } else {
            //---------- calls on first submit-------------
            $select = mysqli_query($conn, "select * from score where  scoreID >=1  order by cast(scoreID as DECIMAL(8,3)) asc");
            require_once "identical.php";
            $removeIdentical=$identical_score_ids;

            $user_noc = $_POST['nocUser'];
            $spouse_noc = $_POST['spouseUser'];


            ///----------------Noc Array for User to set noc number against jobs/duties----------------------------
            $positions = array();
            $positions_org = array();
            $duties = array();
            $duties_org = array();

            $pos = array();
            $p = 0;
            $col = $_GET['Lang'];

            if ($col != 'english' && $col != '') {
                $get = mysqli_query($conn, "Select job_position_$col,job_position,job_duty,job_duty_$col from noc_translation ");
                while ($r = mysqli_fetch_assoc($get)) {
                    $positions[] = $r['job_position_' . $col];
                    $positions_org[] = $r['job_position'];

                    $duties_org[] = $r['job_duty'];
                    $duties[] = $r['job_duty_' . $col];
                }
            }
            else {
                $get = mysqli_query($conn, "Select job_position,job_duty from noc_translation ");
                while ($r = mysqli_fetch_assoc($get)) {
                    $positions[] = $r['job_position'];
                    $positions_org[] = $r['job_position'];

                    $duties_org[] = $r['job_duty'];
                    $duties[] = $r['job_duty'];
                }
            }

            for ($i = 0; $i < sizeof($user_noc); $i++) {
                $user_noc[$i]['experience'] = (float)$user_noc[$i]['experience'];
                if ($user_noc[$i]['experience'] < 0) {
                    $user_noc[$i]['experience'] = 0;
                }
                if ($col != 'english' && $col != '') {

                    $allNOCs = explode('^', $user_noc[$i]['noc']);
                    $allNOCs = array_map('trim', $allNOCs);
                    $user_noc[$i]['noc'] = '';
                    $cur_noc = '';
                    foreach ($allNOCs as $a) {
                        if ($a !== '' && $a !== null && $a !== '^') {
                            $index = array_search($a, $positions);
                            if ($index > -1) {
                                $user_noc[$i]['noc'] = $user_noc[$i]['noc'] . $positions_org[$index] . '^';
                                $pos[$p]['org'] = $positions_org[$index];
                                $pos[$p]['trans'] = $positions[$index];
                                $pos[$p]['pos'] = $i + 1;


                            } else {
                                $index = array_search($a, $duties);

                                if ($index > -1) {
                                    $user_noc[$i]['noc'] = $user_noc[$i]['noc'] . $duties_org[$index] . '^';
                                    $pos[$p]['org'] = $duties_org[$index];
                                    $pos[$p]['trans'] = $duties[$index];
                                    $pos[$p]['pos'] = $i + 1;

                                }
                            }
                            $p++;
                        }
                    }
                }

                $job = explode('^', $user_noc[$i]['noc']);
                $job = array_filter($job);

                $user_noc[$i]['noc'] = '';
                $duty_count = 0;

                $job_pos = '';
                $job_duty = '';


                if (sizeof($job) > 0 && $job[0] != '') {

                    $count = 0;
                    foreach ($job as $j) {

                        $noc = mysqli_query($conn, "select * from noc2 where job_position like '%$j%'");
                        if (mysqli_num_rows($noc) > 0 && $count == 0) {

                            while ($nr = mysqli_fetch_assoc($noc)) {
                                $jp = explode('*', $nr['job_position']);
                                $jp=array_map('trim',$jp);
                                $j=trim($j);

                                if (array_search($j, $jp) > -1) {
                                    $job_pos = $nr['noc_number'] . ',';
                                    break;
                                }
                            }
                        } else {
                            $noc = mysqli_query($conn, "select * from noc2 where job_duty like '%$j%'");
                            if (mysqli_num_rows($noc) > 0) {

                                while ($nr = mysqli_fetch_assoc($noc)) {
                                    $jd = explode('*', $nr['job_duty']);

                                    if (array_search($j, $jd) > -1) {
                                        $job_duty .= $nr['noc_number'] . ',';
                                        //break;
                                    } else {
                                        $jd = array_map('trim', $jd);
                                        if (array_search($j, $jd) > -1) {
                                            $job_duty .= $nr['noc_number'] . ',';
                                            // break;
                                        } else {
                                            $j = $j . trim();
                                            if (array_search($j, $jd) > -1) {
                                                $job_duty .= $nr['noc_number'] . ',';
                                                // break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $count++;
                    }
                    $counts = array_count_values(explode(',', $job_duty));
                    foreach ($counts as $k => $v) {
                        if ($v > 1) {
                            $user_noc[$i]['noc'] .= $k . ',';
                        }
                    }
                    $user_noc[$i]['noc'] = $user_noc[$i]['noc'] . $job_pos;
                }

                $unique_noc = explode(',', $user_noc[$i]['noc']);
                $unique_noc = array_unique($unique_noc);
                $new_noc = '';
                foreach ($unique_noc as $un) {
                    $new_noc .= $un . ',';
                }
                $user_noc[$i]['noc'] = $new_noc;
                $userExperience = (float)$userExperience + (float)$user_noc[$i]['experience'];
            }
//        print_r($user_noc);
//        die();
            ///----------------Noc Array for Spouse to set noc number against jobs/duties----------------------------
            $pos = array();
            $p = 0;
            for ($i = 0; $i < sizeof($spouse_noc); $i++) {
                $spouse_noc[$i]['experience'] = (float)$spouse_noc[$i]['experience'];
                if ($spouse_noc[$i]['experience'] < 0) {
                    $spouse_noc[$i]['experience'] = 0;
                }
                if ($_GET['Lang'] != 'english') {

                    $allNOCs = explode('^', $spouse_noc[$i]['noc']);
                    $spouse_noc[$i]['noc'] = '';
                    $cur_noc = '';
                    foreach ($allNOCs as $a) {
                        if ($a !== '' && $a !== null && $a !== '^') {
                            $index = array_search($a, $positions);
                            if ($index > -1) {
                                $spouse_noc[$i]['noc'] = $spouse_noc[$i]['noc'] . $positions_org[$index] . '^';
                                $pos[$p]['org'] = $positions_org[$index];
                                $pos[$p]['trans'] = $positions[$index];
                                $pos[$p]['pos'] = $i + 1;
                            } else {
                                $index = array_search($a, $duties);

                                if ($index > -1) {
                                    $spouse_noc[$i]['noc'] = $spouse_noc[$i]['noc'] . $duties_org[$index] . '^';
                                    $pos[$p]['org'] = $duties_org[$index];
                                    $pos[$p]['trans'] = $duties[$index];
                                    $pos[$p]['pos'] = $i + 1;
                                }
                            }
                            $p++;
                        }
                    }
                }
                $job = explode('^', $spouse_noc[$i]['noc']);
                $job = array_filter($job);
                $spouse_noc[$i]['noc'] = '';
                $duty_count = 0;
                $job_pos = '';
                $job_duty = '';
                $count = 0;
                if (sizeof($job) > 0 && $job[0] != '') {

                    foreach ($job as $j) {
                        $noc = mysqli_query($conn, "select * from noc2 where job_position like '%$j%'");
                        if (mysqli_num_rows($noc) > 0 && $count == 0) {
                            while ($nr = mysqli_fetch_assoc($noc)) {
                                $jp = explode('*', $nr['job_position']);
                                if (array_search($j, $jp) > -1) {
                                    $job_pos = $nr['noc_number'] . ',';
                                    break;
                                }
                            }
                        } else {
                            $noc = mysqli_query($conn, "select * from noc2 where job_duty like '%$j%'");
                            if (mysqli_num_rows($noc) > 0) {

                                while ($nr = mysqli_fetch_assoc($noc)) {
                                    $jd = explode('*', $nr['job_duty']);

                                    if (array_search($j, $jd) > -1) {
                                        $job_duty .= $nr['noc_number'] . ',';
                                        //break;
                                    } else {
                                        $jd = array_map('trim', $jd);
                                        if (array_search($j, $jd) > -1) {
                                            $job_duty .= $nr['noc_number'] . ',';
                                            // break;
                                        } else {
                                            $j = $j . trim();
                                            if (array_search($j, $jd) > -1) {
                                                $job_duty .= $nr['noc_number'] . ',';
                                                //break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $count++;
                    }
                    $counts = array_count_values(explode(',', $job_duty));
                    foreach ($counts as $k => $v) {
                        if ($v > 1) {
                            $spouse_noc[$i]['noc'] .= $k . ',';
                        }
                    }
                    $spouse_noc[$i]['noc'] = $spouse_noc[$i]['noc'] . $job_pos;
                }


                $unique_noc = explode(',', $spouse_noc[$i]['noc']);
                $unique_noc = array_unique($unique_noc);
                $new_noc = '';
                foreach ($unique_noc as $un) {
                    $new_noc .= $un . ',';
                }
                $spouse_noc[$i]['noc'] = $new_noc;
                $spouseExperience = (float)$spouseExperience + (float)$spouse_noc[$i]['experience'];
            }

            array_push($casesArray, $user_noc);
            array_push($casesArray, $spouse_noc);

        }
        $cc = '';

        $userGradesArray = array_map('strtolower', $userGradesArray);
        $spouseGradesArray = array_map('strtolower', $spouseGradesArray);

        $userGradesArray = array_filter($userGradesArray);
        $spouseGradesArray = array_filter($spouseGradesArray);

        $userGradesArray = array_values($userGradesArray);
        $spouseGradesArray = array_values($spouseGradesArray);

        $userGradesArray = array_unique($userGradesArray);
        $spouseGradesArray = array_unique($spouseGradesArray);

        // identical file

        if (mysqli_num_rows($select) > 0) {
            while ($row = mysqli_fetch_assoc($select)) {

                $score_id = $row['id'];
                foreach ($removeIdentical as $identical) {
                    $identical1 = explode(',', $identical);
                    $index = array_search($score_id, $identical1);
                    if ($index > -1) {
                        for ($i_index=0;$i_index<sizeof($identical1);$i_index++)
                        {

                            if($identical1[$i_index]!=='' && $identical1[$i_index]!==null)
                            {
                                if(searchForId($identical1[$i_index],$scoreArray) || searchForId($identical1[$i_index],$scoreArray2) || searchForId($identical1[$i_index],$spouseScoreArray) || searchForId($identical1[$i_index],$spouseScoreArray2))
                                {
                                    continue 3;
                                }
                            }
                        }
                    }

                }



                //------excluding the score IDs got from global rule array----------
                foreach ($globalArray as $k => $v) {
                    if ($score_id === $v['score_id']) {
                        if ($v['op'] == '!=') {

                            continue 2;
                        }
                    }
                }



                $sel = mysqli_query($conn, "select * from sub_groups where id='{$row['sub_group']}'");
                $ro = mysqli_fetch_assoc($sel);
                $row['sub_group'] = $ro['name'];

                $row['lang'] = '';
                $case = $row['casetype']; // main conditions => grouped, and-or, or, and
                $lang = $row['language'];
                $flag = $row['flags']; // brackets flag

                if ($flag == 1) {
                    $brk_op = '||'; // with or
                } else if ($flag == 0) {
                    $brk_op = '&&'; // with and
                } else if ($flag == 2) {
                    $brk_op = ''; //custom
                }

                // ---------- storing the labels in scoreArray of user and spouse both, assigned from scoreIDs ---------
                if ($row['scoreID'] > 16 && $label_check == false) {
                    $s1 = 0;
                    $s2 = 0;
                    $ids_check = false;

                    // assigning test names
                    for ($p = 0; $p < sizeof($scoreArray); $p++) { {

                        if ($scoreArray[$p]['scoreID'] >= 1 && $scoreArray[$p]['scoreID'] <= 8) {
                            $ids_check = true;
                            $s1 += ($scoreArray[$p]['score']);
                            if ($scoreArray[$p]['scoreID'] >= 1 && $scoreArray[$p]['scoreID'] <= 4) {
                                $scoreArray[$p]['test'] = 'ielts';
                                continue;
                            }
                            if ($scoreArray[$p]['scoreID'] >= 5 && $scoreArray[$p]['scoreID'] <= 8) {
                                $scoreArray[$p]['test'] = 'celpip';
                                continue;
                            }
                        } else if ($scoreArray[$p]['scoreID'] >= 9 && $scoreArray[$p]['scoreID'] <= 16) {
                            $s2 += ($scoreArray[$p]['score']);

                            if ($scoreArray[$p]['scoreID'] >= 9 && $scoreArray[$p]['scoreID'] <= 12) {
                                $scoreArray[$p]['test'] = 'tef';
                                continue;
                            }
                            if ($scoreArray[$p]['scoreID'] >= 13 && $scoreArray[$p]['scoreID'] <= 16) {
                                $scoreArray[$p]['test'] = 'tcf';
                                continue;
                            }
                        }
                    }
                    }

                    // assigning language position
                    for ($p = 0; $p < sizeof($scoreArray); $p++) {

                        if (($s1 > $s2 || $s1 == $s2) && $ids_check == true) {
                            for ($p = 0; $p < sizeof($scoreArray); $p++) {
                                if ($scoreArray[$p]['scoreID'] >= 1 && $scoreArray[$p]['scoreID'] <= 8) {
                                    $scoreArray[$p]['lang'] = 'first';
                                } else if ($scoreArray[$p]['scoreID'] >= 9 && $scoreArray[$p]['scoreID'] <= 16) {
                                    $scoreArray[$p]['lang'] = 'second';
                                }
                            }
                        } else {
                            for ($p = 0; $p < sizeof($scoreArray); $p++) {
                                if ($scoreArray[$p]['scoreID'] >= 1 && $scoreArray[$p]['scoreID'] <= 8) {
                                    $scoreArray[$p]['lang'] = 'second';
                                } else if ($scoreArray[$p]['scoreID'] >= 9 && $scoreArray[$p]['scoreID'] <= 16) {
                                    $scoreArray[$p]['lang'] = 'first';
                                }
                            }
                        }
                    }

                    if ($married == 'Yes' || $relationship == 'Yes') {
                        $spouseScoreArray = $scoreArray; // copying same 16 scoreIDs to spouse Array
                        for ($p = 0; $p < sizeof($spouseScoreArray); $p++) {
                            if ($spouseScoreArray[$p]['for'] == 'user') {
                                $spouseScoreArray[$p]['for'] = 'spouse';
                            } else if ($spouseScoreArray[$p]['for'] == 'spouse') {
                                $spouseScoreArray[$p]['for'] = 'user';
                            }
                        }
                    }
                    $label_check = true;
                }


                //-------------- score calculation with GROUP condition/case--------------
                if ($case == 'grouped') {
                    $nc = false;
                    if ($row['noc'] == 1) {
                        $noc_check = noc_check($score_id, $conn, $user_noc, $spouse_noc, 1, $row['type']);
                        if ($noc_check) {
                            $nc = true;
                        }
                    }
                    if ($sID != $score_id) {
                        $array1 = array(); // when other_case/Option != condition , breaks the if cases and save the row data....for user
                        $array2 = array(); // stores the cases ==> "if cases"........for user
                        $array3 = array();

                        $sarray1 = array(); // when other_case/Option != condition , breaks the if cases and save the row data....for spouse
                        $sarray2 = array(); // stores the cases ==> "if cases"........for spouse
                        $sarray3 = array();

                        $sc = 0; // sum the score of score type
                        $lbk_check = false; // checks if label lies in scoreArray....user
                        $lbk_check2 = false; // checks if label lies in scoreArray and condition is satisfied....user

                        $slbk_check = false; // checks if label lies in scoreArray....spouse
                        $slbk_check2 = false; // checks if label lies in scoreArray and condition is satisfied....spouse

                        $or = $and = $andCheck = $i = 0; // temp
                        $k = $k2 = 0;

                        //-------user-------------

                        if (($row['noc'] == 1 && $nc == true) || $row['noc'] == 0) {
                            $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                            while ($row1 = mysqli_fetch_assoc($select1)) {
                                $value = '';
                                if ($row1['question_type'] == 'm_question') {
                                    $value = $mainQuesArray[$row1['question_id']] == '' ? 'aa' : $mainQuesArray[$row1['question_id']];
                                } else {
                                    $value = $subQuesArray[$row1['question_id']] == '' ? 'aa' : $subQuesArray[$row1['question_id']];
                                }
                                //                        $value = $newArray[$row1['question_id']] == '' ? 'aa' : $newArray[$row1['question_id']];


                                $value = strtolower(ltrim(rtrim($value)));
                                $dbValue = explode('*', $row1['value']);
                                $dbValue = array_map('trim', $dbValue);
                                $dbValue = array_map('strtolower', $dbValue);
                                $operator = $row1['operator'];
                                $condition = $row1['condition2'];
                                $other_case = $row1['other_case'];
                                $test = $row1['tests'];
                                $user_type = $row1['label_type'] == '' ? 'user' : $row1['label_type']; // label type

                                $score = $row1['score_number'];
                                $row1['uvalue'] = $value; //temp
                                $row1['questions'] .= $row1['id'] . ','; //temp


                                if ($value == 'aa' && $operator == '!=') {
                                    $operator = '=';
                                }


                                if ($condition == 'or') {
                                    $cond = '||';
                                } else if ($condition == 'and') {
                                    $cond = "&&";
                                }
                                $condition = $cond;
                                $other_case2 = $other_case;

                                for ($d = 0; $d < sizeof($dbValue) - 1; $d++) {

                                    if (sizeof($dbValue) > 2) {
                                        if ($d == (sizeof($dbValue) - 2)) {
                                            $condition = $cond;
                                            $other_case2 = $other_case;
                                        } else {
                                            $condition = '||';
                                            $other_case2 = 'condition';
                                        }
                                    }
                                    if (sizeof($dbValue) > 2 && $other_case2 != 'condition') {
                                        $condition = '||';
                                    }

                                    // to check if score_case/case is LABEL
                                    if (array_search($dbValue[$d], $labelArray) > -1) {
                                        $lbk_check = true;
                                        for ($p = 0; $p < 16; $p++) {
                                            if (!array_key_exists($p, $scoreArray) || $scoreArray[$p]['for'] != $user_type) {
                                                continue;
                                            }
                                            if (array_search($scoreArray[$p]['score'], $labelArray) > -1) {
                                                $lbk_check2 = true;
                                            }
                                            $s = '';
                                            $dd = '';


                                            if ($operator == '=') {
                                                $operator = '==';
                                            }

                                            $check_d = $d;

                                            //------taking last character of value from scoreArray
                                            if (strlen($scoreArray[$p]['score']) == 2) {
                                                $s = substr($scoreArray[$p]['score'], 1);
                                            } else {
                                                $s = $scoreArray[$p]['score'];
                                                $s = substr($s, 2);
                                            }
                                            //------taking last character of value from Db Value
                                            if (strlen($dbValue[$d]) == 2) {
                                                $dd = substr($dbValue[$d], 1);
                                            } else {
                                                $dd = substr($dbValue[$d], 2);
                                            }

                                            $lhs = substr($scoreArray[$p]['score'], 0, -1);
                                            $rhs = substr($dbValue[$d], 0, -1);
                                            if ($lang != '') {
                                                if ($s == $dd && $lang == $scoreArray[$p]['lang']) {

                                                    if ($test != '') {
                                                        if ($test == $scoreArray[$p]['test']) {
                                                            // substr is being used to remove the last character
                                                            $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                        } else {
                                                            continue;
                                                        }
                                                    } else {
                                                        $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                    }
                                                } else {
                                                    continue;
                                                }
                                            } else {

                                                if ($s == $dd) {

                                                    if ($test != '') {
                                                        if ($test == $scoreArray[$p]['test']) {
                                                            $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                        } else {
                                                            continue;
                                                        }
                                                    } else {

                                                        $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                    }
                                                } else {
                                                    continue;
                                                }
                                            }
                                        }
                                        if ($other_case2 != 'condition') {


                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $array1[$k] = $row;
                                            $row['questions'] = '';
                                            $k++;
                                        }
                                        continue;
                                    }
                                    // to check if score_case/case is Grade
                                    if ($row1['score_case'] == 2) {
                                        if ($operator == '=') {
                                            $operator = '==';
                                        }
                                        if ($row1['label_type'] == 'user' || $row1['label_type'] == '') {
                                            for ($p = 0; $p < sizeof($userGradesArray); $p++) {
                                                $array2[$k] .= '"' . $userGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                            }
                                        } else {
                                            for ($p = 0; $p < sizeof($spouseGradesArray); $p++) {
                                                $array2[$k] .= '"' . $spouseGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                            }
                                        }


                                        if ($other_case2 != 'condition') {
                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $array1[$k] = $row;
                                            $row['questions'] = '';
                                            $k++;
                                        }
                                        continue;
                                    }

                                    // to check if score_case/case is Value but Question type is SCORE TYPE
                                    if ($row1['question_type'] == 'score_type') {
                                        if ($operator == '=') {
                                            $operator = '==';
                                        }

                                        for ($p = 0; $p <= end(array_keys($scoreArray)); $p++) {
                                            if ($scoreArray[$p]['type'] == $row1['question_id'])
                                                $sc += $scoreArray[$p]['score'];
                                        }
                                        for ($p = 0; $p < sizeof($nocScore); $p++) {

                                            if ($nocScore[$p]['type'] == $row1['question_id']) {
                                                $sc += $nocScore[$p]['score'];
                                            }
                                        }
                                        if ($operator == '-') {
                                            $dv = explode('-', $dbValue[$d]);
                                            $array2[$k] .= '(' . $sc . '>=' . $dv[0] . ' && ' . $sc . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                                        } else {
                                            $array2[$k] .= $sc . $operator . $dbValue[$d] . ' ' . $condition . ' ';
                                        }

                                        if ($other_case2 != 'condition') {
                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $array1[$k] = $row;
                                            $row['questions'] = '';
                                            $k++;
                                        }
                                        continue;
                                    }
                                    // to check if score_case/case is Value and question type is sub/main question

                                    if ($operator == '=') {
                                        $operator = '==';
                                    }

                                    if ($operator == '-') {
                                        $dval = explode('-', $dbValue[$d]);
                                        $array2[$k] .= '' . $value . ' >= ' . $dval[0] . ' && ' . $value . ' <= ' . $dval[1] . '' . $condition . ' ';
                                    } else {
                                        $array2[$k] .= '"' . $value . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                    }
                                    if ($other_case2 != 'condition') {
                                        $row['score'] = $score;
                                        $row['other_case'] = $row1['other_case'];
                                        $row['move_qtype'] = $row1['move_qtype'];
                                        $row['move_qid'] = $row1['move_qid'];
                                        $row['move_scoreType'] = $row1['move_scoreType'];
                                        $row['comments'] = $row1['comments'];
                                        $row['comments_' . $col] = $row1['comments_' . $col];

                                        $array1[$k] = $row;
                                        $row['questions'] = '';
                                        $k++;
                                    }
                                }
                            }
                        }
                        //-------spouse-------------
                        if ($married == 'Yes' || $relationship == 'Yes') {
                            $nc2 = false;
                            if ($row['noc'] == 1) {
                                $noc_check2 = noc_check2($score_id, $conn, $user_noc, $spouse_noc, 1, $row['type']);
                                if ($noc_check2) {
                                    $nc2 = true;
                                }
                            }

                            if (($row['noc'] == 1 && $nc2 == true) || $row['noc'] == 0) {
                                $select1 = mysqli_query($conn, "select * from score_questions2 where score_id=$score_id");
                                while ($row1 = mysqli_fetch_assoc($select1)) {
                                    $value = '';
                                    if ($row1['question_type'] == 'm_question') {
                                        $value = $mainQuesArray[$row1['question_id']] == '' ? 'aa' : $mainQuesArray[$row1['question_id']];
                                    } else {
                                        $value = $subQuesArray[$row1['question_id']] == '' ? 'aa' : $subQuesArray[$row1['question_id']];
                                    }
                                    //                        $value = $newArray[$row1['question_id']] == '' ? 'aa' : $newArray[$row1['question_id']];
                                    $value = strtolower(ltrim(rtrim($value)));
                                    $dbValue = explode('*', $row1['value']);
                                    $dbValue = array_map('trim', $dbValue);
                                    $dbValue = array_map('strtolower', $dbValue);
                                    $operator = $row1['operator'];
                                    $condition = $row1['condition2'];
                                    $other_case = $row1['other_case'];
                                    $test = $row1['tests'];
                                    $user_type = $row1['label_type'] == '' ? 'user' : $row1['label_type'];

                                    $score = $row1['score_number'];
                                    $row1['uvalue'] = $value;
                                    $row1['questions'] .= $row1['id'] . ',';


                                    if ($value == 'aa' && $operator == '!=') {
                                        $operator = '=';
                                    }


                                    if ($condition == 'or') {
                                        $cond = '||';
                                    } else if ($condition == 'and') {
                                        $cond = "&&";
                                    }
                                    $condition = $cond;
                                    $other_case2 = $other_case;

                                    for ($d = 0; $d < sizeof($dbValue) - 1; $d++) {
                                        if (sizeof($dbValue) > 2) {
                                            if ($d == (sizeof($dbValue) - 2)) {
                                                $condition = $cond;
                                                $other_case2 = $other_case;
                                            } else {
                                                $condition = '||';
                                                $other_case2 = 'condition';
                                            }
                                        }
                                        if (sizeof($dbValue) > 2 && $other_case2 != 'condition') {
                                            $condition = '||';
                                        }
                                        if (array_search($dbValue[$d], $labelArray) > -1) {
                                            $slbk_check = true;
                                            for ($p = 0; $p < sizeof($spouseScoreArray); $p++) {
                                                if (!array_key_exists($p, $spouseScoreArray) || $spouseScoreArray[$p]['for'] != $user_type) {
                                                    continue;
                                                }
                                                if (array_search($spouseScoreArray[$p]['score'], $labelArray) > -1) {
                                                    $slbk_check2 = true;
                                                }
                                                $s = '';
                                                $dd = '';


                                                if ($operator == '=') {
                                                    $operator = '==';
                                                }
                                                if (strlen($spouseScoreArray[$p]['score']) == 2) {
                                                    $s = substr($spouseScoreArray[$p]['score'], 1);
                                                } else {
                                                    $s = $spouseScoreArray[$p]['score'];
                                                    $s = substr($s, 2);
                                                }

                                                if (strlen($dbValue[$d]) == 2) {
                                                    $dd = substr($dbValue[$d], 1);
                                                } else {
                                                    $dd = substr($dbValue[$d], 2);
                                                }

                                                if ($lang != '') {
                                                    if ($s == $dd && $lang == $spouseScoreArray[$p]['lang']) {

                                                        if ($test != '') {
                                                            if ($test == $spouseScoreArray[$p]['test']) {
                                                                $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                            } else {
                                                                continue;
                                                            }
                                                        } else {
                                                            $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                        }
                                                    } else {
                                                        continue;
                                                    }
                                                } else {

                                                    if ($s == $dd) {

                                                        if ($test != '') {
                                                            if ($test == $spouseScoreArray[$p]['test']) {
                                                                $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                            } else
                                                                continue;
                                                        } else {
                                                            $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator . substr($dbValue[$d], 0, -1) . $condition . ' ';
                                                        }
                                                    } else {
                                                        continue;
                                                    }
                                                }
                                            }
                                            if ($other_case2 != 'condition') {
                                                $row['score'] = $score;
                                                $row['other_case'] = $row1['other_case'];
                                                $row['move_qtype'] = $row1['move_qtype'];
                                                $row['move_qid'] = $row1['move_qid'];
                                                $row['move_scoreType'] = $row1['move_scoreType'];
                                                $row['comments'] = $row1['comments'];
                                                $row['comments_' . $col] = $row1['comments_' . $col];

                                                $sarray1[$k2] = $row;
                                                $row['questions'] = '';
                                                $k2++;
                                            }
                                            continue;
                                        }
                                        if ($row1['score_case'] == 2) {
                                            if ($operator == '=') {
                                                $operator = '==';
                                            }
                                            if ($row1['label_type'] == 'user' || $row1['label_type'] == '') {
                                                for ($p = 0; $p < sizeof($spouseGradesArray); $p++) {
                                                    $sarray2[$k2] .= '"' . $spouseGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                                }
                                            } else {
                                                for ($p = 0; $p < sizeof($userGradesArray); $p++) {
                                                    $sarray2[$k2] .= '"' . $userGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                                }
                                            }


                                            if ($other_case2 != 'condition') {
                                                $row['score'] = $score;
                                                $row['other_case'] = $row1['other_case'];
                                                $row['move_qtype'] = $row1['move_qtype'];
                                                $row['move_qid'] = $row1['move_qid'];
                                                $row['move_scoreType'] = $row1['move_scoreType'];
                                                $row['comments'] = $row1['comments'];
                                                $row['comments_' . $col] = $row1['comments_' . $col];

                                                $sarray1[$k2] = $row;
                                                $row['questions'] = '';
                                                $k2++;
                                            }
                                            continue;
                                        }


                                        if ($row1['question_type'] == 'score_type') {
                                            if ($operator == '=') {
                                                $operator = '==';
                                            }

                                            for ($p = 0; $p <= end(array_keys($spouseScoreArray)); $p++) {
                                                if ($spouseScoreArray[$p]['type'] == $row1['question_id'])
                                                    $sc += $spouseScoreArray[$p]['score'];
                                            }
                                            for ($p = 0; $p < sizeof($nocScore); $p++) {

                                                if ($nocScore[$p]['type'] == $row1['question_id']) {
                                                    $sc += $nocScore[$p]['score'];
                                                }
                                            }
                                            if ($operator == '-') {
                                                $dv = explode('-', $dbValue[$d]);
                                                $sarray2[$k2] .= '(' . $sc . '>=' . $dv[0] . ' && ' . $sc . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                                            } else {
                                                $sarray2[$k2] .= $sc . $operator . $dbValue[$d] . ' ' . $condition . ' ';
                                            }


                                            if ($other_case2 != 'condition') {
                                                $row['score'] = $score;
                                                $row['other_case'] = $row1['other_case'];
                                                $row['move_qtype'] = $row1['move_qtype'];
                                                $row['move_qid'] = $row1['move_qid'];
                                                $row['move_scoreType'] = $row1['move_scoreType'];
                                                $row['comments'] = $row1['comments'];
                                                $row['comments_' . $col] = $row1['comments_' . $col];

                                                $sarray1[$k2] = $row;
                                                $row['questions'] = '';
                                                $k2++;
                                            }
                                            continue;
                                        }


                                        if ($operator == '=') {
                                            $operator = '==';
                                        }

                                        if ($operator == '-') {
                                            $dval = explode('-', $dbValue[$d]);
                                            $sarray2[$k2] .= '' . $value . ' >= ' . $dval[0] . ' && ' . $value . ' <= ' . $dval[1] . '' . $condition . ' ';
                                        } else {
                                            $sarray2[$k2] .= '"' . $value . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                        }
                                        if ($other_case2 != 'condition') {
                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $sarray1[$k2] = $row;
                                            $row['questions'] = '';
                                            $k2++;
                                        }
                                    }
                                }
                            }
                        }
                        //-------evalution of above cases----user---------
                        $array2 = array_values($array2);

                        for ($j = 0; $j < sizeof($array2); $j++) {

                            $bb = explode($brk_op, $array2[$j]);
                            $d = '';

                            foreach ($bb as $a) {
                                if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                                    if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                                        $a = substr($a, 0, -3);
                                    }
                                    $d .= '(' . $a . ') ' . $brk_op . ' ';
                                }
                            }
                            if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
                                $d = substr($d, 0, -3);
                            }
                            // echo '<br> group-case==>' . $d . '--' . $array1[$j]['scoreID'].'-'.$array1[$j]['score'];

                            array_push($casesArray, 'group-case==>' . $d . '--' . $array1[$j]['scoreID'] . '-' . $array1[$j]['score']);

                            $c = eval('return ' . $d . ';');

                            if ($c == 1) {
                                $array3[$j] = $array1[$j]['score'];
                            } else {
                                foreach ($nocScore as $k => $v) {
                                    if ($array1[$j]['scoreID'] == $v['scoreID']) {
                                        if ($v['condition'] == '' || $v['condition'] == 'and' || $v['condition'] == '&&') {
                                            unset($nocScore[$k]);
                                        }
                                    }
                                }
                            }
                        }
                        $b = array_keys($array3, max($array3));
                        $scoreArray[] = $array1[$b[0]];

                        //-------evaluation of above cases----spouse---------
                        if ($married == 'Yes' || $relationship == 'Yes') {
                            $sarray2 = array_values($sarray2);

                            for ($j = 0; $j < sizeof($sarray2); $j++) {

                                $bb = explode($brk_op, $sarray2[$j]);
                                $d = '';

                                foreach ($bb as $a) {
                                    if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                                        if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                                            $a = substr($a, 0, -3);
                                        }
                                        $d .= '(' . $a . ') ' . $brk_op . ' ';
                                    }
                                }
                                if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
                                    $d = substr($d, 0, -3);
                                }
                                // echo '<br> group-case (spouse)==>' . $d . '--' . $sarray1[$j]['scoreID'].'-'.$sarray1[$j]['score'];
                                array_push($casesArray, 'group-case (spouse)==>' . $d . '--' . $sarray1[$j]['scoreID'] . '-' . $sarray1[$j]['score']);

                                $c = eval('return ' . $d . ';');
                                if ($c == 1) {
                                    $sarray3[$j] = $sarray1[$j]['score'];
                                } else {
                                    foreach ($spouseNocScore as $k => $v) {
                                        if ($sarray1[$j]['scoreID'] == $v['scoreID']) {
                                            if ($v['condition'] == '' || $v['condition'] == 'and' || $v['condition'] == '&&') {
                                                unset($spouseNocScore[$k]);
                                            }
                                        }
                                    }
                                }
                            }
                            $b = array_keys($sarray3, max($sarray3));
                            $spouseScoreArray[] = $sarray1[$b[0]];
                        }
                    }
                }

                //-------------- score calculation with AND condition/case--------------
                else if ($case == 'and') {
                    if ($row['noc'] == 1) {
                        $noc_check = noc_check($score_id, $conn, $user_noc, $spouse_noc, 1, $row['type']);
                        if (!$noc_check) {
                            continue;
                        }
                    }
                    if ($sID != $score_id) {
                        $andCount = 0;
                        $andCheck = 0;
                        $s = mysqli_query($conn, "select * from score_conditions where score_id=$score_id");
                        $r = mysqli_fetch_assoc($s);
                        $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                        while ($row1 = mysqli_fetch_assoc($select1)) {
                            if (!array_key_exists($row1['question_id'], $newArray)) {
                                continue;
                            }
                            $andCheck++;
                            $value = $newArray[$row1['question_id']];
                            $dbValue = $row1['value']; //substr($row1['value'],0,-1);
                            $operator = $row1['operator'];
                            if (check_cond($value, $operator, $dbValue)) {
                                $andCount++;
                            }
                        }
                        if ($andCheck == $andCount) {
                            $row['score'] = $r['score_number'];
                            $scoreArray[] = $row;
                        }
                    }
                }

                //-------------- score calculation with OR condition/case--------------
                else if ($case == 'or') {
                    if ($row['noc'] == 1) {
                        $noc_check = noc_check($score_id, $conn, $user_noc, $spouse_noc, 1, $row['type']);
                        if (!$noc_check) {
                            continue;
                        }
                    }
                    if ($sID != $score_id) {

                        $bool = false;
                        $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                        while ($row1 = mysqli_fetch_assoc($select1)) {
                            //                        if (!$bool)
                            {
                                if (!array_key_exists($row1['question_id'], $newArray)) {
                                    continue;
                                }
                                $for = '';
                                $s = mysqli_query($conn, "select * from sub_questions where id='{$row1['question_id']}'");
                                $r = mysqli_fetch_assoc($s);
                                $ss = mysqli_query($conn, "select * from questions where id='{$r['question_id']}'");
                                $rr = mysqli_fetch_assoc($ss);
                                if (strpos($rr['question'], 'spouse') !== false) {
                                    $for = 'spouse';
                                } else {
                                    $for = 'user';
                                }
                                $select2 = mysqli_query($conn, "select * from score_conditions where score_id=$score_id");
                                while ($row2 = mysqli_fetch_assoc($select2)) {
                                    //                                $valuee = rtrim($newArray[$row1['question_id']]);
                                    //                                $value= ($valuee==''?'aa':$valuee);
                                    $value = rtrim($newArray[$row1['question_id']]);

                                    $dbValue = rtrim($row2['value']);
                                    $operator = $row2['operator'];
                                    if (strpos($value, 'or') !== false) {
                                        $val = explode('or', $value);
                                        $value = $val[0];
                                    }
                                    $c = 'or-case-->' . $value . ' ' . $operator . ' ' . $dbValue . '--' . $row['scoreID'] . '<br>';
                                    //                                if($value!='aa')
                                    {
                                        if ($value == 'Other' || $value == 'other') {
                                            $co = '"' . $value . '"=="' . $dbValue . '" ';
                                            $cc = eval('return ' . $co . ';');

                                            if ($cc == 1) {
                                                //                                                                                          echo $c;

                                                $row['score'] = $row2['score_number'];
                                                $row['for'] = $for;
                                                $scoreArray[] = $row;
                                                $bool = true;
                                                break;
                                            }
                                        } else {
                                            if (check_cond($value, $operator, $dbValue)) {
                                                //                                                                                        echo $c;

                                                $row['score'] = $row2['score_number'];
                                                $row['for'] = $for;
                                                $scoreArray[] = $row;
                                                $bool = true;
                                                break;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


                //-------------- score calculation with AND-OR condition/case--------------
                else if ($case == 'both') {

                    $nc = false;
                    if ($row['noc'] == 1) {

                        $noc_check = noc_check($score_id, $conn, $user_noc, $spouse_noc, 1, $row['type']);

                        if ($noc_check) {
                            $nc = true;
                        }
                    }
                    if ($sID != $score_id) {

                        $array1 = array();
                        $array2 = array();
                        $sarray1 = array();
                        $sarray2 = array();
                        $lbk_check = false;
                        $lbk_check2 = false;
                        $slbk_check = false;
                        $slbk_check2 = false;
                        $or = $and = $andCheck = $i = $k = $k2 = 0;

                        $ob = '';
                        $cb = '';
                        $outer_start_bracket = '';
                        $outer_end_bracket = '';


                        if (($row['noc'] == 1 && $nc == true) || $row['noc'] == 0) {
                            $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                            while ($row1 = mysqli_fetch_assoc($select1)) {

                                $value = '';
                                $get_ques = '';
                                $check_ques = '';
                                if ($row1['question_type'] == 'm_question') {
                                    $check_ques = mysqli_query($conn, "select * from questions where id='{$row1['question_id']}'");
                                    $value = $mainQuesArray[$row1['question_id']] == '' ? 'aa' : $mainQuesArray[$row1['question_id']];
                                } else {
                                    $check_ques = mysqli_query($conn, "select * from sub_questions where id='{$row1['question_id']}'");
                                    $value = $subQuesArray[$row1['question_id']] == '' ? 'aa' : $subQuesArray[$row1['question_id']];
                                }
                                if ($value == 'aa' && $row1['value'] == '*' && ($row1['operator'] == '=' || $row1['operator'] == '==')) {
                                    $value = '';
                                }

                                if ($value == 'aa') {
                                    if ($row1['skip_question'] == 1 || $row1['skip_question'] == '1') {
                                        continue;
                                    }
                                }



                                if (mysqli_num_rows($check_ques) > 0) {
                                    $get_ques = mysqli_fetch_assoc($check_ques);
                                    $select2 = mysqli_query($conn, "select * from score_questions where score_id=$score_id and id>{$row1['id']} limit 1");
                                    $getRow = mysqli_fetch_assoc($select2);
                                    if ($getRow['question_type'] == 'm_question') {
                                        $check_ques2 = mysqli_query($conn, "select * from questions where id='{$getRow['question_id']}'");
                                    } else {
                                        $check_ques2 = mysqli_query($conn, "select * from sub_questions where id='{$getRow['question_id']}'");
                                    }
                                    if (mysqli_num_rows($check_ques2) > 0) {
                                        $get_ques2 = mysqli_fetch_assoc($check_ques2);
                                    }
                                }
                                $sc = 0;
                                //                            $value = $newArray[$row1['question_id']] == '' ? 'aa' : $newArray[$row1['question_id']];
                                $value = strtolower(ltrim(rtrim($value)));
                                $dbValue = explode('*', $row1['value']);
                                $dbValue = array_map('trim', $dbValue);
                                $dbValue = array_map('strtolower', $dbValue);
                                $operator = $row1['operator'];
                                $operator2 = $row1['operator'];

                                $condition = $row1['condition2'];
                                $score = $row1['score_number'];
                                $other_case = $row1['other_case'];
                                $row1['uvalue'] = $value;
                                $row['questions'] .= $row1['question_id'] . ',';
                                $row['q_id'] .= $row1['question_id'];
                                $row['question_type'] .= $row1['question_type'];
                                $max = $row['max_score'];
                                $test = $row1['tests'];
                                $user_type = $row1['label_type'];
                                if ($brk_op == '') {
                                    $ob = $row1['open_bracket'];
                                    $cb = $row1['close_bracket'];
                                    $outer_start_bracket = $row1['start_bracket'];
                                    $outer_end_bracket = $row1['end_bracket'];
                                }
                                $eb = '';
                                $sb = '';




                                if ($condition == 'or') {
                                    $cond = '||';
                                } else if ($condition == 'and') {
                                    $cond = "&&";
                                }
                                $condition = $cond;
                                $other_case2 = $other_case;
                                $ob1 = $ob;
                                $cb1 = $cb;
                                $outer_start_bracket1 = $outer_start_bracket;
                                $outer_end_bracket1 = $outer_end_bracket;
                                for ($d = 0; $d < sizeof($dbValue) - 1; $d++) {

                                    if (sizeof($dbValue) > 2) {
                                        if ($d == (sizeof($dbValue) - 2)) {
                                            $condition = $cond;
                                            $other_case2 = $other_case;
                                            if ($brk_op == '') {
                                                $ob1 = $ob;
                                                $cb1 = $cb;
                                            }
                                        } else {
                                            $condition = '||';
                                            $other_case2 = 'condition';
                                            if ($brk_op == '') {
                                                $ob1 = '';
                                                $cb1 = $cb;
                                            }
                                        }
                                    }

                                    if ($brk_op == '') {
                                        if ($d == 0) {
                                            $ob1 = $ob;
                                            $outer_start_bracket1 = $outer_start_bracket;
                                        } else if ($d == sizeof($dbValue) - 2) {
                                            $ob1 = '';
                                            $cb1 = $cb;
                                            $outer_end_bracket1 = '';
                                            $outer_end_bracket1 = $outer_end_bracket;
                                        } else {

                                            $cb1 = '';
                                            $ob1 = '';
                                            $outer_start_bracket1 = '';
                                            $outer_end_bracket1 = '';
                                        }

                                        if ($d == 0 && sizeof($dbValue) > 2) {
                                            $sb = '(';
                                            $cb1 = '';
                                            $outer_end_bracket1 = '';
                                        } else {
                                            $sb = '';
                                        }
                                        if ($d != 0 && $d == sizeof($dbValue) - 2) {
                                            $eb = ')';
                                            $outer_start_bracket1 = '';
                                        } else {
                                            $eb = '';
                                        }
                                    }
                                    if (sizeof($dbValue) > 2 && $other_case2 != 'condition') {
                                        $condition = '||';
                                    }

                                    // checking for labels
                                    if (array_search($dbValue[$d], $labelArray) > -1) {

                                        $lbk_check = true;

                                        for ($p = 0; $p < 16; $p++) {
                                            if (!array_key_exists($p, $scoreArray) || $scoreArray[$p]['for'] != $user_type) {

                                                continue;
                                            }
                                            if (array_search($scoreArray[$p]['score'], $labelArray) > -1) {
                                                $lbk_check2 = true;
                                            }
                                            $s = '';
                                            $dd = '';



                                            if ($operator2 == '=') {
                                                $operator2 = '==';
                                            }


                                            if (strlen($scoreArray[$p]['score']) == 2) {
                                                $s = substr($scoreArray[$p]['score'], 1);
                                            } else {
                                                $s = $scoreArray[$p]['score'];
                                                $s = substr($s, 2);
                                            }

                                            if (strlen($dbValue[$d]) == 2) {
                                                $dd = substr($dbValue[$d], 1);
                                            } else {
                                                $dd = substr($dbValue[$d], 2);
                                            }

                                            if ($lang != '') {
                                                if ($s == $dd && $lang == $scoreArray[$p]['lang']) {

                                                    if ($test != '') {
                                                        if ($test == $scoreArray[$p]['test']) {
                                                            $array2[$k] .= $outer_start_bracket1 . $ob1;
                                                            $array2[$k] .= $sb;
                                                            $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                            $array2[$k] .= $eb;
                                                            $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                        } else {
                                                            continue;
                                                        }
                                                    } else {
                                                        $array2[$k] .= $outer_start_bracket1 . $ob1;
                                                        $array2[$k] .= $sb;
                                                        $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                        $array2[$k] .= $eb;
                                                        $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                    }
                                                } else {
                                                    continue;
                                                }
                                            } else {
                                                if ($s == $dd) {

                                                    if ($test != '') {

                                                        if ($test == $scoreArray[$p]['test']) {
                                                            $array2[$k] .= $outer_start_bracket1 . $ob1;
                                                            $array2[$k] .= $sb;
                                                            $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                            $array2[$k] .= $eb;
                                                            $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                        } else
                                                            continue;
                                                    } else {
                                                        $array2[$k] .= $outer_start_bracket1 . $ob1;
                                                        $array2[$k] .= $sb;
                                                        $array2[$k] .= substr($scoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                        $array2[$k] .= $eb;
                                                        $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                    }
                                                } else {
                                                    continue;
                                                }
                                            }
                                        }
                                        if ($other_case2 != 'condition') {

                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $row['email'] = $row1['email'];
                                            $row['subject'] = $row1['subject'];
                                            $row['message'] = $row1['message'];
                                            $row['cc'] = $row1['cc'];

                                            $array1[$k] = $row;
                                            $row['questions'] = '';
                                            $k++;
                                        }
                                        continue;
                                    }
                                    if ($row1['score_case'] == 2) {
                                        if ($operator == '=') {
                                            $operator = '==';
                                        }

                                        if ($row1['label_type'] == 'user' || $row1['label_type'] == '') {
                                            for ($p = 0; $p < sizeof($userGradesArray); $p++) {
                                                $array2[$k] .= '"' . $userGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                            }
                                        } else {
                                            for ($p = 0; $p < sizeof($spouseGradesArray); $p++) {
                                                $array2[$k] .= '"' . $spouseGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                            }
                                        }


                                        if ($other_case2 != 'condition') {
                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['email'] = $row1['email'];
                                            $row['subject'] = $row1['subject'];
                                            $row['message'] = $row1['message'];
                                            $row['cc'] = $row1['cc'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $array1[$k] = $row;
                                            $row['questions'] = '';
                                            $k++;
                                        }
                                        continue;
                                    }

                                    // checking score_type
                                    if ($row1['question_type'] == 'score_type') {
                                        if ($operator == '=') {
                                            $operator = '==';
                                        }
                                        $sc = 0; // score_count

                                        for ($p = 0; $p <= end(array_keys($scoreArray)); $p++) {

                                            if ($scoreArray[$p]['type'] == $row1['question_id']) {
                                                $sc += $scoreArray[$p]['score'];
                                            }
                                        }
                                        for ($p = 0; $p < sizeof($nocScore); $p++) {

                                            if ($nocScore[$p]['type'] == $row1['question_id']) {
                                                $sc += $nocScore[$p]['score'];
                                            }
                                        }
                                        if ($operator == '-') {
                                            $dv = explode('-', $dbValue[$d]);
                                            $array2[$k] .= '(' . $sc . '>=' . $dv[0] . ' && ' . $sc . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                                        } else {

                                            $array2[$k] .= $outer_start_bracket1 . $ob1;
                                            $array2[$k] .= $sb;
                                            $array2[$k] .= $sc . $operator . $dbValue[$d];
                                            $array2[$k] .= $eb;
                                            $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                        }
                                        if ($other_case2 != 'condition') {

                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['email'] = $row1['email'];
                                            $row['subject'] = $row1['subject'];
                                            $row['message'] = $row1['message'];
                                            $row['cc'] = $row1['cc'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $array1[$k] = $row;
                                            $row['questions'] = '';
                                            $k++;
                                        }
                                        continue;
                                    }

                                    if ($operator == '=') {
                                        $operator = '==';
                                    }

                                    // checkin questions values
                                    if (ctype_digit($value)) {
                                        if ($operator == '-') {
                                            $dv = explode('-', $dbValue[$d]);
                                            $array2[$k] .= '(' . $value . '>=' . $dv[0] . ' && ' . $value . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                                        } else {

                                            $array2[$k] .= $outer_start_bracket1 . $ob1;
                                            $array2[$k] .= $sb;
                                            $array2[$k] .= $value . $operator . $dbValue[$d];
                                            $array2[$k] .= $eb;
                                            $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                        }
                                    } else {

                                        //                                        if ($operator == '!=' && $condition=='&&' && (strpos($get_ques['question'], 'citizenship') !== false || strpos($get_ques['question'], 'Citizenship') !== false)) {
                                        //
                                        //                                            if($getRow['operator']=='!=')
                                        //                                            {
                                        //                                                $condition = '||';
                                        //                                            }
                                        //                                        }
                                        if ($value == 'aa' && $operator == '!=') {
                                            $operator = '==';
                                        }
                                        $array2[$k] .= $outer_start_bracket1 . $ob1;
                                        $array2[$k] .= $sb;
                                        $array2[$k] .= '"' . $value . '"' . $operator . '"' . $dbValue[$d] . '"';
                                        $array2[$k] .= $eb;
                                        $array2[$k] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                    }


                                    if (($row1['noc_or'] == 1 || $row1['noc_or'] == '1') && (($d != 0 && $d == sizeof($dbValue) - 2) || ($d == 0 && $d == sizeof($dbValue) - 2))) {

                                        $s = mysqli_query($conn, "select * from score_questions where score_id=$score_id and other_case!='condition'");
                                        $r = mysqli_fetch_assoc($s);
                                        $row['score'] = $r['score_number'];
                                        $row['other_case'] = $r['other_case'];
                                        $row['move_qtype'] = $r['move_qtype'];
                                        $row['move_qid'] = $r['move_qid'];
                                        $row['move_scoreType'] = $r['move_scoreType'];
                                        $row['comments'] = $r['comments'];
                                        $row['email'] = $row1['email'];
                                        $row['subject'] = $row1['subject'];
                                        $row['message'] = $row1['message'];
                                        $row['cc'] = $row1['cc'];

                                        if ($condition == '&&') {
                                            end($nocScore);
                                            $key = key($nocScore);
                                            $row['and_check'] = 1;

                                            for ($o = 0; $o <= $key; $o++) {
                                                if ($nocScore[$o]['scoreID'] == $row['scoreID']) {
                                                    $row['noc_true'] = $nocScore[$o]['noc_verify'];
                                                    $row['noc_case'] = $nocScore[$o]['noc_case'];
                                                }
                                            }
                                        }

                                        $array1[$k] = $row;
                                        $row['questions'] = '';
                                        $k++;
                                    } else if ($other_case2 != 'condition') {


                                        $row['score'] = $score;
                                        $row['other_case'] = $row1['other_case'];
                                        $row['move_qtype'] = $row1['move_qtype'];
                                        $row['move_qid'] = $row1['move_qid'];
                                        $row['move_scoreType'] = $row1['move_scoreType'];
                                        $row['comments'] = $row1['comments'];
                                        $row['email'] = $row1['email'];
                                        $row['subject'] = $row1['subject'];
                                        $row['message'] = $row1['message'];
                                        $row['cc'] = $row1['cc'];
                                        $row['comments_' . $col] = $row1['comments_' . $col];

                                        $array1[$k] = $row;
                                        $row['questions'] = '';
                                        $k++;
                                    }

                                    $check_id = $d;
                                }
                            }
                        }


                        // spouse scoring
                        if ($married == 'Yes' || $relationship == 'Yes') {
                            $ob = '';
                            $cb = '';
                            $outer_start_bracket = '';
                            $outer_end_bracket = '';

                            $nc2 = false;
                            if ($row['noc'] == 1) {
                                $noc_check2 = noc_check2($score_id, $conn, $user_noc, $spouse_noc, 1, $row['type']);
                                if ($noc_check2) {
                                    $nc2 = true;
                                }
                            }
                            if (($row['noc'] == 1 && $nc2 == true) || $row['noc'] == 0) {

                                $select1 = mysqli_query($conn, "select * from score_questions2 where score_id=$score_id");
                                while ($row1 = mysqli_fetch_assoc($select1)) {

                                    $get_ques = '';
                                    $check_ques = '';
                                    $value = '';
                                    if ($row1['question_type'] == 'm_question') {
                                        $check_ques = mysqli_query($conn, "select * from questions where id='{$row1['question_id']}'");
                                        $value = $mainQuesArray[$row1['question_id']] == '' ? 'aa' : $mainQuesArray[$row1['question_id']];
                                    } else {
                                        $check_ques = mysqli_query($conn, "select * from sub_questions where id='{$row1['question_id']}'");
                                        $value = $subQuesArray[$row1['question_id']] == '' ? 'aa' : $subQuesArray[$row1['question_id']];
                                    }
                                    if ($value == 'aa' && $row1['value'] == '*' && ($row1['operator'] == '=' || $row1['operator'] == '==')) {
                                        $value = '';
                                    }
                                    if ($value == 'aa') {
                                        if ($row1['skip_question'] == 1 || $row1['skip_question'] == '1') {
                                            continue;
                                        }
                                    }
                                    if (mysqli_num_rows($check_ques) > 0) {
                                        $get_ques = mysqli_fetch_assoc($check_ques);
                                        $select2 = mysqli_query($conn, "select * from score_questions2 where score_id=$score_id and id>{$row1['id']} limit 1");
                                        $getRow = mysqli_fetch_assoc($select2);
                                        if ($getRow['question_type'] == 'm_question') {
                                            $check_ques2 = mysqli_query($conn, "select * from questions where id='{$getRow['question_id']}'");
                                        } else {
                                            $check_ques2 = mysqli_query($conn, "select * from sub_questions where id='{$getRow['question_id']}'");
                                        }
                                        if (mysqli_num_rows($check_ques2) > 0) {
                                            $get_ques2 = mysqli_fetch_assoc($check_ques2);
                                        }
                                    }
                                    $sc = 0;
                                    //                                $value = $newArray[$row1['question_id']] == '' ? 'aa' : $newArray[$row1['question_id']];
                                    $value = strtolower(ltrim(rtrim($value)));
                                    $dbValue = explode('*', $row1['value']);
                                    $dbValue = array_map('trim', $dbValue);
                                    $dbValue = array_map('strtolower', $dbValue);
                                    $operator = $row1['operator'];
                                    $operator2 = $row1['operator'];

                                    $condition = $row1['condition2'];
                                    $score = $row1['score_number'];
                                    $other_case = $row1['other_case'];
                                    $row1['uvalue'] = $value;
                                    $row['questions'] .= $row1['question_id'] . ',';
                                    $row['q_id'] .= $row1['question_id'];
                                    $row['question_type'] .= $row1['question_type'];
                                    $max = $row['max_score'];
                                    $test = $row1['tests'];
                                    $user_type = $row1['label_type'];
                                    if ($brk_op == '') {
                                        $ob = $row1['open_bracket'];
                                        $cb = $row1['close_bracket'];
                                        $outer_start_bracket = $row1['start_bracket'];
                                        $outer_end_bracket = $row1['end_bracket'];
                                    }
                                    $eb = '';
                                    $sb = '';


                                    if ($condition == 'or') {
                                        $cond = '||';
                                    } else if ($condition == 'and') {
                                        $cond = "&&";
                                    }
                                    $condition = $cond;
                                    $other_case2 = $other_case;
                                    $ob1 = $ob;
                                    $cb1 = $cb;
                                    $outer_start_bracket1 = $outer_start_bracket;
                                    $outer_end_bracket1 = $outer_end_bracket;
                                    for ($d = 0; $d < sizeof($dbValue) - 1; $d++) {

                                        if (sizeof($dbValue) > 2) {
                                            if ($d == (sizeof($dbValue) - 2)) {
                                                $condition = $cond;
                                                $other_case2 = $other_case;
                                                if ($brk_op == '') {
                                                    $ob1 = $ob;
                                                    $cb1 = $cb;
                                                }
                                            } else {
                                                $condition = '||';
                                                $other_case2 = 'condition';
                                                if ($brk_op == '') {
                                                    $ob1 = '';
                                                    $cb1 = $cb;
                                                }
                                            }
                                        }

                                        if ($brk_op == '') {
                                            if ($d == 0) {
                                                $ob1 = $ob;
                                                $outer_start_bracket1 = $outer_start_bracket;
                                            } else if ($d == sizeof($dbValue) - 2) {
                                                $ob1 = '';
                                                $cb1 = $cb;
                                                $outer_end_bracket1 = '';
                                                $outer_end_bracket1 = $outer_end_bracket;
                                            } else {

                                                $cb1 = '';
                                                $ob1 = '';
                                                $outer_start_bracket1 = '';
                                                $outer_end_bracket1 = '';
                                            }

                                            if ($d == 0 && sizeof($dbValue) > 2) {
                                                $sb = '(';
                                                $cb1 = '';
                                                $outer_end_bracket1 = '';
                                            } else {
                                                $sb = '';
                                            }
                                            if ($d != 0 && $d == sizeof($dbValue) - 2) {
                                                $eb = ')';
                                                $outer_start_bracket1 = '';
                                            } else {
                                                $eb = '';
                                            }
                                        }
                                        if (sizeof($dbValue) > 2 && $other_case2 != 'condition') {
                                            $condition = '||';
                                        }
                                        if (array_search($dbValue[$d], $labelArray) > -1) {
                                            $slbk_check = true;
                                            for ($p = 0; $p < 16; $p++) {
                                                if (!array_key_exists($p, $spouseScoreArray) || $spouseScoreArray[$p]['for'] != $user_type) {
                                                    continue;
                                                }
                                                if (array_search($spouseScoreArray[$p]['score'], $labelArray) > -1) {

                                                    $slbk_check2 = true;
                                                }
                                                $s = '';
                                                $dd = '';



                                                if ($operator2 == '=') {
                                                    $operator2 = '==';
                                                }


                                                if (strlen($spouseScoreArray[$p]['score']) == 2) {
                                                    $s = substr($spouseScoreArray[$p]['score'], 1);
                                                } else {
                                                    $s = $spouseScoreArray[$p]['score'];
                                                    $s = substr($s, 2);
                                                }

                                                if (strlen($dbValue[$d]) == 2) {
                                                    $dd = substr($dbValue[$d], 1);
                                                } else {
                                                    $dd = substr($dbValue[$d], 2);
                                                }

                                                if ($lang != '') {
                                                    if ($s == $dd && $lang == $spouseScoreArray[$p]['lang']) {

                                                        if ($test != '') {
                                                            if ($test == $spouseScoreArray[$p]['test']) {
                                                                $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                                                $sarray2[$k2] .= $sb;
                                                                $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                                $sarray2[$k2] .= $eb;
                                                                $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                            } else {
                                                                continue;
                                                            }
                                                        } else {
                                                            $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                                            $sarray2[$k2] .= $sb;
                                                            $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                            $sarray2[$k2] .= $eb;
                                                            $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                        }
                                                    } else {
                                                        continue;
                                                    }
                                                } else {
                                                    if ($s == $dd) {

                                                        if ($test != '') {

                                                            if ($test == $spouseScoreArray[$p]['test']) {
                                                                $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                                                $sarray2[$k2] .= $sb;
                                                                $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                                $sarray2[$k2] .= $eb;
                                                                $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                            } else
                                                                continue;
                                                        } else {
                                                            $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                                            $sarray2[$k2] .= $sb;
                                                            $sarray2[$k2] .= substr($spouseScoreArray[$p]['score'], 0, -1) . $operator2 . substr($dbValue[$d], 0, -1);
                                                            $sarray2[$k2] .= $eb;
                                                            $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                                        }
                                                    } else {
                                                        continue;
                                                    }
                                                }
                                            }
                                            if ($other_case2 != 'condition') {
                                                $row['score'] = $score;
                                                $row['other_case'] = $row1['other_case'];
                                                $row['move_qtype'] = $row1['move_qtype'];
                                                $row['move_qid'] = $row1['move_qid'];
                                                $row['move_scoreType'] = $row1['move_scoreType'];
                                                $row['comments'] = $row1['comments'];
                                                $row['email'] = $row1['email'];
                                                $row['subject'] = $row1['subject'];
                                                $row['message'] = $row1['message'];
                                                $row['cc'] = $row1['cc'];
                                                $row['comments_' . $col] = $row1['comments_' . $col];

                                                $sarray1[$k2] = $row;
                                                $row['questions'] = '';
                                                $k2++;
                                            }
                                            continue;
                                        }
                                        if ($row1['score_case'] == 2) {
                                            if ($operator == '=') {
                                                $operator = '==';
                                            }

                                            if ($row1['label_type'] == 'user' || $row1['label_type'] == '') {
                                                for ($p = 0; $p < sizeof($spouseGradesArray); $p++) {
                                                    $sarray2[$k2] .= '"' . $spouseGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                                }
                                            } else {
                                                for ($p = 0; $p < sizeof($userGradesArray); $p++) {
                                                    $sarray2[$k2] .= '"' . $userGradesArray[$p] . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                                                }
                                            }


                                            if ($other_case2 != 'condition') {
                                                $row['score'] = $score;
                                                $row['other_case'] = $row1['other_case'];
                                                $row['move_qtype'] = $row1['move_qtype'];
                                                $row['move_qid'] = $row1['move_qid'];
                                                $row['move_scoreType'] = $row1['move_scoreType'];
                                                $row['comments'] = $row1['comments'];
                                                $row['email'] = $row1['email'];
                                                $row['subject'] = $row1['subject'];
                                                $row['message'] = $row1['message'];
                                                $row['cc'] = $row1['cc'];
                                                $row['comments_' . $col] = $row1['comments_' . $col];

                                                $sarray1[$k2] = $row;
                                                $row['questions'] = '';
                                                $k2++;
                                            }
                                            continue;
                                        }


                                        if ($row1['question_type'] == 'score_type') {
                                            if ($operator == '=') {
                                                $operator = '==';
                                            }
                                            $sc = 0;
                                            for ($p = 0; $p <= end(array_keys($spouseScoreArray)); $p++) {

                                                if ($spouseScoreArray[$p]['type'] == $row1['question_id']) {
                                                    $sc += $spouseScoreArray[$p]['score'];
                                                }
                                            }
                                            for ($p = 0; $p < sizeof($spouseNocScore); $p++) {

                                                if ($spouseNocScore[$p]['type'] == $row1['question_id']) {
                                                    $sc += $spouseNocScore[$p]['score'];
                                                }
                                            }

                                            if ($operator == '-') {
                                                $dv = explode('-', $dbValue[$d]);
                                                $sarray2[$k2] .= '(' . $sc . '>=' . $dv[0] . ' && ' . $sc . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                                            } else {
                                                $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                                $sarray2[$k2] .= $sb;
                                                $sarray2[$k2] .= $sc . $operator . $dbValue[$d];
                                                $sarray2[$k2] .= $eb;
                                                $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                            }
                                            if ($other_case2 != 'condition') {

                                                $row['score'] = $score;
                                                $row['other_case'] = $row1['other_case'];
                                                $row['move_qtype'] = $row1['move_qtype'];
                                                $row['move_qid'] = $row1['move_qid'];
                                                $row['move_scoreType'] = $row1['move_scoreType'];
                                                $row['comments'] = $row1['comments'];
                                                $row['email'] = $row1['email'];
                                                $row['subject'] = $row1['subject'];
                                                $row['message'] = $row1['message'];
                                                $row['cc'] = $row1['cc'];
                                                $row['comments_' . $col] = $row1['comments_' . $col];

                                                $sarray1[$k2] = $row;
                                                $row['questions'] = '';
                                                $k2++;
                                            }
                                            continue;
                                        }

                                        if ($operator == '=') {
                                            $operator = '==';
                                        }

                                        if (ctype_digit($value)) {
                                            if ($operator == '-') {
                                                $dv = explode('-', $dbValue[$d]);
                                                $sarray2[$k2] .= '(' . $value . '>=' . $dv[0] . ' && ' . $value . '<=' . $dv[1] . ')' . ' ' . $condition . ' ';
                                            } else {
                                                $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                                $sarray2[$k2] .= $sb;
                                                $sarray2[$k2] .= $value . $operator . $dbValue[$d];
                                                $sarray2[$k2] .= $eb;
                                                $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                            }
                                        } else {

                                            if ($value == 'aa' && $operator == '!=') {
                                                $operator = '==';
                                            }
                                            $sarray2[$k2] .= $outer_start_bracket1 . $ob1;
                                            $sarray2[$k2] .= $sb;
                                            $sarray2[$k2] .= '"' . $value . '"' . $operator . '"' . $dbValue[$d] . '"';
                                            $sarray2[$k2] .= $eb;
                                            $sarray2[$k2] .= $cb1 . $outer_end_bracket1 . ' ' . $condition . ' ';
                                        }


                                        if (($row1['noc_or'] == 1 || $row1['noc_or'] == '1') && (($d != 0 && $d == sizeof($dbValue) - 2) || ($d == 0 && $d == sizeof($dbValue) - 2))) {

                                            $s = mysqli_query($conn, "select * from score_questions where score_id=$score_id and other_case!='condition'");
                                            $r = mysqli_fetch_assoc($s);
                                            $row['score'] = $r['score_number'];
                                            $row['other_case'] = $r['other_case'];
                                            $row['move_qtype'] = $r['move_qtype'];
                                            $row['move_qid'] = $r['move_qid'];
                                            $row['move_scoreType'] = $r['move_scoreType'];
                                            $row['comments'] = $r['comments'];
                                            $row['email'] = $row1['email'];
                                            $row['subject'] = $row1['subject'];
                                            $row['message'] = $row1['message'];
                                            $row['cc'] = $row1['cc'];

                                            if ($condition == '&&') {

                                                end($spouseNocScore);
                                                $key = key($spouseNocScore);
                                                $row['and_check'] = 1;
                                                $row['and_check'] = 1;
                                                for ($o = 0; $o <= $key; $o++) {
                                                    if ($spouseNocScore[$o]['scoreID'] == $row['scoreID']) {
                                                        $row['noc_true'] = $spouseNocScore[$o]['noc_verify'];
                                                        $row['noc_case'] = $spouseNocScore[$o]['noc_case'];
                                                    }
                                                }
                                            }

                                            $sarray1[$k2] = $row;
                                            $row['questions'] = '';
                                            $k2++;
                                        } else if ($other_case2 != 'condition') {


                                            $row['score'] = $score;
                                            $row['other_case'] = $row1['other_case'];
                                            $row['move_qtype'] = $row1['move_qtype'];
                                            $row['move_qid'] = $row1['move_qid'];
                                            $row['move_scoreType'] = $row1['move_scoreType'];
                                            $row['comments'] = $row1['comments'];
                                            $row['comments_' . $col] = $row1['comments_' . $col];

                                            $row['email'] = $row1['email'];
                                            $row['subject'] = $row1['subject'];
                                            $row['message'] = $row1['message'];
                                            $row['cc'] = $row1['cc'];

                                            $sarray1[$k2] = $row;
                                            $row['questions'] = '';
                                            $k2++;
                                        }

                                        $check_id = $d;
                                    }
                                }
                            }
                        }
                    }

                    // for spouse case check
                    $sarray2 = array_values($sarray2);

                    if ($married == 'Yes' || $relationship == 'Yes') {
                        $da = '';
                        $dd = '';
                        $bool = false;
                        for ($j = 0; $j < sizeof($sarray2); $j++) {

                            if ($brk_op != '') {
                                $b = explode($brk_op, $sarray2[$j]);
                                $d = '';

                                foreach ($b as $a) {
                                    if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                                        if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                                            $a = substr($a, 0, -3);
                                        }
                                        $d .= '(' . $a . ') ' . $brk_op . ' ';
                                    }
                                }
                            } else {

                                $d = $sarray2[$j];
                            }
                            if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
                                $d = substr($d, 0, -3);
                            }
                            $d = '(' . $d . ')';
                            $orCheck = false;
                            $noc_or = false;
                            $cc = '||';
                            $nb1 = '(';
                            $nb2 = ')';
                            $ad = '';
                            $eeb = '';
                            end($spouseNocScore);
                            $key = key($spouseNocScore);
                            $row['and_check'] = 1;
                            for ($o = 0; $o <= $key; $o++) {
                                if ($spouseNocScore[$o]['scoreID'] == $sarray1[$j]['scoreID']) {
                                    if ($spouseNocScore[$o]['or_check'] == 1 && $spouseNocScore[$o]['or_check2'] != 1) {
                                        $orCheck = true;
                                        break;
                                    }
                                }
                            }
                            $check = false;


                            if ($sarray1[$j]['and_check'] == 1) {
                                if ($sarray1[$j]['scoreID'] == $da || $da == '') {

                                    $noc_true = $sarray1[$j]['noc_case'];
                                    if (strpos($noc_true, '&&') !== false) {

                                        $b = explode('&&', $noc_true);
                                        $noc_true = '';
                                        for ($u = 0; $u < sizeof($b) - 1; $u++) {
                                            if ($b[$u] != '' && $b[$u] != ' ' && $b[$u] != null && $b[$u] != NULL) {
                                                if (substr($b[$u], -3) == '&& ' || substr($b[$u], -3) == '|| ') {
                                                    $b[$u] = substr($b[$u], 0, -3);
                                                }
                                                $noc_true .= '(' . $b[$u] . ')&& ';
                                            }
                                        }
                                        $noc_true .= '(' . $b[sizeof($b) - 1];
                                        $eeb = ')';
                                    }

                                    if ($bool == true) {
                                        $cc = $eeb . '&&';
                                        $noc_true = '';
                                        $nb1 = '';
                                        $nb2 = '';
                                    }
                                    $dd .= $nb1 . $noc_true . $cc . $d . $nb2;
                                    $check = true;
                                    if ($sarray1[$j]['scoreID'] == $sarray1[$j + 1]['scoreID']) {
                                        $bool = true;
                                        continue;
                                    }
                                    $bool = false;
                                }
                            }
                            $da = $sarray1[$j]['scoreID'];


                            if ($check == true) {
                                $d = $dd;
                                $d = '(' . $d . ')';
                            }

//                              echo '<br> AND-OR-case (spouse)==>' . $d . '--' . $sarray1[$j]['scoreID'] . '--' . $sarray1[$j]['score'];
                            array_push($casesArray, 'AND-OR-case (spouse)==>' . $d . '--' . $sarray1[$j]['scoreID'] . '-' . $sarray1[$j]['score']);

                            $c = eval('return ' . $d . ';');


                            if (($c == 1 || $orCheck == true) && ($slbk_check == $slbk_check2)) {
                                if ($c == 1) {
                                    foreach ($spouseNocScore as $k => $v) {
                                        if ($v['scoreID'] == $sarray1[$j]['scoreID'] && $v['condition'] == 'or') {
                                            unset($spouseNocScore[$k]);
                                        }
                                    }
                                }

                                $sarray1[$j]['true'] = 1;
                                if ($sarray1[$j]['other_case'] == 'question') {
                                    $sarray1[$j]['otherCase'] = 'Move to Question - ' . $sarray1[$j]['move_qid'];
                                    $spouseScoreArray2[] = $sarray1[$j];
                                    //                            die(json_encode(array('Success' => 'ques','question'=>$sarray1[$j],'scoreArray'=>$scoreArray,'nocArray'=>$nocScore,'scoreArray2'=>$scoreArray2,'spouseScoreArray'=>$spouseScoreArray,'spouseScoreArray2'=>$spouseScoreArray2 ,'userGrades'=>$userGradesArray,'spouseGrades'=>$spouseGradesArray,'spouseNocScore'=>$spouseNocScore)));
                                } else if ($sarray1[$j]['other_case'] == 'scoring') {
                                    $s = mysqli_query($conn, "select * from score where id ='{$sarray1[$j]['move_scoreType']}'");
                                    $r = mysqli_fetch_assoc($s);
                                    $sarray1[$j]['otherCase'] = 'Move to Score - ' . $r['scoreID'];

                                    $spouseScoreArray2[] = $sarray1[$j];

                                    //                            die(json_encode(array('Success' => 'scoring','question'=>$sarray1[$j],'scoreArray'=>$scoreArray,'nocArray'=>$nocScore,'scoreArray2'=>$scoreArray2,'spouseScoreArray'=>$spouseScoreArray,'spouseScoreArray2'=>$spouseScoreArray2,'userGrades'=>$userGradesArray,'spouseGrades'=>$spouseGradesArray,'spouseNocScore'=>$spouseNocScore)));
                                } else if ($sarray1[$j]['other_case'] == 'comment') {
                                    $sarray1[$j]['otherCase'] = 'Show Comment';

                                    $spouseScoreArray2[] = $sarray1[$j];

                                    //                            die(json_encode(array('Success' => 'comment','question'=>$sarray1[$j],'scoreArray'=>$scoreArray,'nocArray'=>$nocScore,'scoreArray2'=>$scoreArray2,'spouseScoreArray'=>$spouseScoreArray,'spouseScoreArray2'=>$spouseScoreArray2,'userGrades'=>$userGradesArray,'spouseGrades'=>$spouseGradesArray,'spouseNocScore'=>$spouseNocScore)));
                                } else if ($sarray1[$j]['other_case'] == 'email') {

                                    $usr = '<br><strong>Name:</strong> ' . $_POST['name'];
                                    $usr .= '<br><strong>Email:</strong> ' . $_POST['email'];
                                    $usr .= '<br><strong>Phone:</strong> ' . $_POST['phone'];

                                    sendEmail2($sarray1[$j]['email'], $sarray1[$j]['subject'], $array1[$j]['cc'], $sarray1[$j]['message'], $usr);
                                    $sarray1[$j]['otherCase'] = 'Send Email';
                                    $spouseScoreArray2[] = $sarray1[$j];
                                } else {
                                    $spouseScoreArray[] = $sarray1[$j];
                                }
                            }
                        }
                    }
                    // for user case check
                    $da = '';
                    $dd = '';
                    $bool = false;
                    $array2 = array_values($array2);

                    for ($j = 0; $j < sizeof($array2); $j++) {

                        if ($brk_op != '') {
                            $b = explode($brk_op, $array2[$j]);
                            $d = '';

                            foreach ($b as $a) {
                                if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                                    if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                                        $a = substr($a, 0, -3);
                                    }
                                    $d .= '(' . $a . ') ' . $brk_op . ' ';
                                }
                            }
                        } else {

                            $d = $array2[$j];
                        }
                        if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
                            $d = substr($d, 0, -3);
                        }
                        $d = '(' . $d . ')';
                        $orCheck = false;
                        $noc_or = false;
                        $cc = '||';
                        $nb1 = '(';
                        $nb2 = ')';
                        $ad = '';
                        $eeb = '';
                        end($nocScore);
                        $key = key($nocScore);
                        $row['and_check'] = 1;
                        for ($o = 0; $o <= $key; $o++) {
                            if ($nocScore[$o]['scoreID'] == $array1[$j]['scoreID']) {
                                if ($nocScore[$o]['or_check'] == 1 && $nocScore[$o]['or_check2'] != 1) {
                                    $orCheck = true;
                                    break;
                                }
                            }
                        }
                        $check = false;


                        if ($array1[$j]['and_check'] == 1) {
                            if ($array1[$j]['scoreID'] == $da || $da == '') {

                                $noc_true = $array1[$j]['noc_case'];

                                if (strpos($noc_true, '&&') !== false) {

                                    $b = explode('&&', $noc_true);
                                    $noc_true = '';
                                    for ($u = 0; $u < sizeof($b) - 1; $u++) {
                                        if ($b[$u] != '' && $b[$u] != ' ' && $b[$u] != null && $b[$u] != NULL) {
                                            if (substr($b[$u], -3) == '&& ' || substr($b[$u], -3) == '|| ') {
                                                $b[$u] = substr($b[$u], 0, -3);
                                            }
                                            $noc_true .= '(' . $b[$u] . ')&& ';
                                        }
                                    }
                                    $noc_true .= '(' . $b[sizeof($b) - 1];
                                    $eeb = ')';
                                }

                                if ($bool == true) {
                                    $cc = $eeb . '&&';
                                    $noc_true = '';
                                    $nb1 = '';
                                    $nb2 = '';
                                }
                                $dd .= $nb1 . $noc_true . $cc . $d . $nb2;

                                $check = true;
                                if ($array1[$j]['scoreID'] == $array1[$j + 1]['scoreID']) {
                                    $bool = true;
                                    continue;
                                }
                                $bool = false;
                            }
                        }
                        $da = $array1[$j]['scoreID'];




                        if ($check == true) {
                            $d = $dd;
                            $d = '(' . $d . ')';
                        }

                        // echo   '<br> AND-OR-case==>' . $d . '--' . $array1[$j]['scoreID'] . '--' . $array1[$j]['score'];
                        array_push($casesArray, "AND-OR-case==>" . $d . '--' . $array1[$j]['scoreID'] . '--' . $array1[$j]['score']);
                        $c = eval('return ' . $d . ';');


                        if (($c == 1 || $orCheck == true) && ($lbk_check == $lbk_check2)) {

                            if ($c == 1) {
                                foreach ($nocScore as $k => $v) {
                                    if ($v['scoreID'] == $array1[$j]['scoreID'] && $v['condition'] == 'or') {
                                        unset($nocScore[$k]);
                                    }
                                }
                            } else if ($orCheck && $c !== 1) {
                                foreach ($nocScore as $k => $v) {
                                    if ($v['scoreID'] == $array1[$j]['scoreID'] && $v['condition'] == 'or') {
                                        if ($v['score'] == '') {
                                            $nocScore[$k]['score'] = $array1[$j]['score'];
                                        }
                                        continue 2;
                                    }
                                }
                            }
                            if ($array1[$j]['other_case'] == 'question') {
                                $array1[$j]['otherCase'] = 'Move to Question - ' . $array1[$j]['move_qid'];
                                $scoreArray2[] = $array1[$j];
                                die(json_encode(array('Success' => 'ques', 'question' => $array1[$j], 'scoreArray' => $scoreArray, 'nocArray' => $nocScore, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc)));
                            } else if ($array1[$j]['other_case'] == 'scoring') {
                                $s = mysqli_query($conn, "select * from score where id ='{$array1[$j]['move_scoreType']}'");
                                $r = mysqli_fetch_assoc($s);
                                $array1[$j]['otherCase'] = 'Move to Score - ' . $r['scoreID'];

                                $scoreArray2[] = $array1[$j];

                                die(json_encode(array('Success' => 'scoring', 'question' => $array1[$j], 'scoreArray' => $scoreArray, 'nocArray' => $nocScore, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc)));
                            } else if ($array1[$j]['other_case'] == 'comment') {
                                $array1[$j]['otherCase'] = 'Show Comment';

                                $scoreArray2[] = $array1[$j];

                                die(json_encode(array('Success' => 'comment', 'question' => $array1[$j], 'scoreArray' => $scoreArray, 'nocArray' => $nocScore, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc )));
                            } else if ($array1[$j]['other_case'] == 'email') {
                                $usr = '<br><strong>Name:</strong> ' . $_POST['name'];
                                $usr .= '<br><strong>Email:</strong> ' . $_POST['email'];
                                $usr .= '<br><strong>Phone:</strong> ' . $_POST['phone'];

                                sendEmail2($array1[$j]['email'], $array1[$j]['subject'], $array1[$j]['cc'], $array1[$j]['message'], $usr);

                                //                            mail($array1[$j]['email'],$array1[$j]['subject'],$array1[$j]['message']);
                                $array1[$j]['otherCase'] = 'Send Email';
                                $scoreArray2[] = $array1[$j];
                            } else {
                                $scoreArray[] = $array1[$j];
                            }
                        } else {
                            if ($married == 'Yes' || $relationship == 'Yes') {
                                if ($sarray1[$j]['true'] == 1) {
                                    if ($sarray1[$j]['other_case'] == 'question') {
                                        die(json_encode(array('Success' => 'ques', 'question' => $sarray1[$j], 'scoreArray' => $scoreArray, 'nocArray' => $nocScore, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc)));
                                    } else if ($sarray1[$j]['other_case'] == 'scoring') {

                                        die(json_encode(array('Success' => 'scoring', 'question' => $sarray1[$j], 'scoreArray' => $scoreArray, 'nocArray' => $nocScore, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc)));
                                    } else if ($sarray1[$j]['other_case'] == 'comment') {

                                        die(json_encode(array('Success' => 'comment', 'question' => $sarray1[$j], 'scoreArray' => $scoreArray, 'nocArray' => $nocScore, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc)));
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if ($row['noc'] == 1) {
                        $noc_check = noc_check($score_id, $conn, $user_noc, $spouse_noc, 0, $row['type']);
                        if ($married == 'Yes' || $relationship == 'Yes') {
                            $noc_check2 = noc_check2($score_id, $conn, $user_noc, $spouse_noc, 0, $row['type']);
                        }
                        if (is_array($noc_check) && sizeof($noc_check) > 6) {
                            $noc_check['scoreID'] = $row['scoreID'];
                            die(json_encode(array('Success' => 'noc_ques', 'question' => $noc_check, 'scoreArray' => $scoreArray, 'scoreArray2' => $scoreArray2, 'spouseScoreArray' => $spouseScoreArray, 'spouseScoreArray2' => $spouseScoreArray2, 'nocArray' => $nocScore, 'userGrades' => $userGradesArray, 'spouseGrades' => $spouseGradesArray, 'spouseNocScore' => $spouseNocScore, 'casesArray' => $casesArray, 'removeIdentical' => $removeIdentical, 'user_noc'=>$user_noc,'spouse_noc'=>$spouse_noc)));
                        } else {
                            $nocScore[] = $noc_check;
                        }
                    } else {
                        continue;
                    }
                }
                check_subGroups();
                max_score();

            }
            $sID = $score_id;

        }
    }


    //------------submission - pdf making - email sending-------------------------

    if ($_POST['comment'] != '') {
        array_push($quesArray, 'Comments');
        array_push($ansArray, $_POST['comment']);
    }
    if ($_GET['Lang'] != 'english') {
        for ($o = 0; $o < sizeof($quesArray); $o++) {
            if (strpos($quesArray[$o], ' job duties') !== false) {
                $index = array_search($ansArray[$o], $duties);
                if ($index > -1) {
                    $ansArray[$o] = $duties_org[$index];
                }
                //                $getEngNoc=mysqli_query($conn,"Select * from noc_translation where job_duty_$col ='$ansArray[$o]'");
                //                if(mysqli_num_rows($getEngNoc) >0)
                //                {
                //                    $rowNoc=mysqli_fetch_assoc($getEngNoc);
                //                    $ansArray[$o]=$rowNoc['job_duty'];
                //                }
            }
            if (strpos($quesArray[$o], 'describe the position') !== false) {
                //                $getEngNoc=mysqli_query($conn,"Select * from noc_translation where job_position_$col ='$ansArray[$o]'");
                //                if(mysqli_num_rows($getEngNoc) >0)
                //                {
                //                    $rowNoc=mysqli_fetch_assoc($getEngNoc);
                //                    $ansArray[$o]=$rowNoc['job_position'];
                //                }
                $index = array_search($ansArray[$o], $positions);
                if ($index > -1) {
                    $ansArray[$o] = $positions_org[$index];
                }
            }
        }
    }

    $email = $_POST['email'];
    $questions = explode(',', $_POST['assistance']);
    $phone = $_POST['phone'];
    $name = $_POST['name'];
    $form = '<form>' . $_POST['formHtml'] . '</form>';
    $_POST['n']['user_email'] = $email;
    $_POST['n']['form_data'] = $form;
    $_POST['n']['user_name'] = $name;
    $_POST['n']['user_phone'] = $phone;
    $_POST['n']['questions'] = json_encode($quesArray);
    $_POST['n']['answers'] = json_encode($ansArray);
    $_POST['n']['json_data'] = json_encode($quesArray2);
    $_POST['n']['ip_address'] = getIPAddress();
    $_POST['n']['language'] = ucfirst($_GET['Lang']);
    $_POST['n']['localStorage'] = (json_decode($_POST['localStorage']));

    $x = new StdClass();

    $x->Submission = 'true';
    array_push($_POST['n']['localStorage'],$x);
    $_POST['n']['localStorage'] = json_encode($_POST['n']['localStorage']);

    $_POST['n']['status'] = 0;
    if (isset($_SESSION['user_id'])) {
        $_POST['n']['user_id'] = $_SESSION['user_id'];
    }



    $T = db_pair_str2($_POST['n']);

    $questions = explode(',', $_POST['assistance']);
    $automationScriptEmails = array();
    $assist_content = '<ul>';
    $automationScriptContent = '<ul>';
    $automationScriptEmail = '';
    $automationScriptCcEmail = '';
    $automationScriptSubject = '';
    $automationScriptEmailBody = '';
    $user_info = '';
    // automation script
    foreach ($questions as $qa) {
        $qa = explode('-', $qa);
        $q = (int)$qa[0];
        $s = '';
        if ($qa[1] === '1' || $qa[1] === 1) {
            $s = mysqli_query($conn, "select * from sub_questions where question_id=$q and casetype='email'");
        } else {
            $s = mysqli_query($conn, "select * from level2_sub_questions where question_id=$q and casetype='email'");
        }
        if (mysqli_num_rows($s) > 0) {
            while ($r = mysqli_fetch_assoc($s)) {
                $temp['email'] = $r['automation_email'];
                $temp['content'] = '<li>' . $r['content'] . '</li>';
                $temp['country'] = $r['automation_country'];
                $temp['question_id'] = $qa;
                $temp['cc'] = $r['cc'];
                $temp['subject'] = $r['automation_subject'];
                $temp['user_info'] = $r['user_info'];
                $temp['email_body'] = $r['content2'];
                $temp['automation'] = $r['more_ops'];
                $temp['send_both'] = $r['send_both'];
                $temp['more_ops'] = $r['more_ops'];

                $automationScriptEmails[] = $temp;
            }
        }
    }
    $automationScript = false;
    $is_assist_content = false;
    foreach ($automationScriptEmails as $k => $v) {
        $temp = '';
        if ($v['country'] == $mainQuesArray[571] || $v['country'] == $mainQuesArray[43] || $v['country'] == $mainQuesArray[45] || $v['country'] == $subQuesArray[70] || $v['country'] == $subQuesArray[71] || $v['country'] == $subQuesArray[11622]) {
            $automationScript = true;

            $automationScriptContent .= $v['content'];
            $automationScriptEmail = $v['email'];
            $automationScriptCcEmail = $v['cc'];
            $automationScriptSubject = $v['subject'];
            $automationScriptEmailBody = $v['email_body'];
            if ($v['user_info'] == 1) {
                $user_info .= '<strong>Name:</strong> ' . $name;
                $user_info .= '<br><strong>Email:</strong> ' . $email;
                $user_info .= '<br><strong>Phone:</strong> ' . $phone;
            }
            if ($v['automation'] == 1) {
                $temp = ' (automation script has sent the email to concerned person successfully)';
            }
        }
        if ($v['send_both'] == 1) {
            $is_assist_content = true;
            $assist_content .= $v['content'] . $temp;
        }
        if ($v['more_ops'] == 0) {
            $is_assist_content = true;
            $assist_content .= $v['content'];
        }
    }

    if ($is_assist_content) {
        $GLOBALS['ass_label'] = 'User needs assistance:';
    }
    $assist_content .= '</ul>';
    $automationScriptContent .= '</ul>';
    if ($automationScript && $automationScriptSubject != '') {
        sendEmail3($automationScriptEmailBody, $automationScriptEmail, $automationScriptCcEmail, $automationScriptSubject, $user_info);
    }
    // automation script-------------------


    //-------pdf file generation and email sending-----------

    $sdraftId = "";

    if (empty($_POST['sformId']) || !isset($_SESSION['user_id'])) {




        if(!empty($_POST['sdraftId']))
        {
            $sdraftId = $_POST['sdraftId'];

            $formCheck  = mysqli_query($conn,"SELECT * FROM `accounts_form_drafts`  WHERE `id` = '$sdraftId'");
            $formCheckRow = mysqli_fetch_assoc($formCheck);

            if($formCheckRow['form_id'] != '0')
            {
                $insert = mysqli_query($conn, "UPDATE  user_form set $T WHERE `id` = '{$formCheckRow['form_id']}'");
                $last_id = $formCheckRow['form_id'];
                mysqli_query($conn,"UPDATE `accounts_form_drafts` SET `prof_priority` = 0 WHERE `form_id` = '$last_id'");


            }
            else
            {
                $insert = mysqli_query($conn, "INSERT into user_form set $T");
                $last_id = mysqli_insert_id($conn);
            }


            // agr pehly save as draft tha aur phr form submit kiya hai to draft remove ho jaye ga
            mysqli_query($conn,"DELETE FROM `accounts_form_drafts`  WHERE `id` = '$sdraftId'");
            $sdraftId = "";
        }
        else
        {
            $insert = mysqli_query($conn, "INSERT into user_form set $T");
            $last_id = mysqli_insert_id($conn);
        }


    } else {
        $insert = mysqli_query($conn, "UPDATE  user_form set $T WHERE `id` = '{$_POST['sformId']}'");
        $last_id = $_POST['sformId'];
        mysqli_query($conn,"UPDATE `accounts_form_drafts` SET `prof_priority` = 0 WHERE `form_id` = '$last_id'");

    }
    if(isset($cuurentUser))
    {
        if(!empty($cuurentUser))
        {
            if($cuurentUser['role'] != "1" && $cuurentUser['role'] != 1)
            {
                mysqli_query($conn,"UPDATE `accounts_form_drafts` SET `priority` = '0' WHERE `userId` = '$currenTloggedUserId'");
            }
        }
    }



    pdf_maker($quesArray, $ansArray, $assist_content, $name, $email, $last_id);


    $casess = json_encode($casesArray);
    $casess = mysqli_real_escape_string($conn, $casess);

    $getQuery = mysqli_query($conn, "SELECT * FROM form_submission_cases where form_id=$last_id");
    if(mysqli_num_rows($getQuery)>0)
    {
        $getQuery = mysqli_query($conn, "DELETE FROM form_submission_cases where form_id=$last_id");

    }
    mysqli_query($conn, "INSERT INTO `form_submission_cases` (`id`, `form_id`, `case_array`, `created_at`) VALUES (NULL, '$last_id', '$casess', CURRENT_TIMESTAMP)");

    $token = $_POST['token'];
    $insert = mysqli_query($conn, "UPDATE referral set user_form_id=$last_id where refered_code='$token'");


    //------------score savings for user----------------
    $finalScore = saveScore($conn, $scoreArray, $nocScore, $last_id, $scoreArray2, 'user');

    //------------score savings for spouse----------------
    if ($married == 'Yes' || $relationship == 'Yes') {
        saveScore2($conn, $spouseScoreArray, $spouseNocScore, $last_id, $spouseScoreArray2, 'user');
    }
    if (true) {

        $_SESSION['msg'] = 'Thankyou for contacting. Your request has been generated. We will get back to you as soon as possible';
        $_SESSION['class'] = 'success';

        die(json_encode(array('Success' => 'true', 'Msg' => 'Form has been submitted.', 'score' => $finalScore,'s_draft_id'=>$sdraftId, 'sfrom_id' => $last_id)));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong')));
    }
}
//------------------------------------------------------------------



//---------Get Questions for three cases [group, groupques, move to exisisting---------------------------
function getData($conn, $case, $row, $id, $pid)
{
    if ($pid == '') {
        $pid = 0;
    }
    global $display_class, $countryArray, $educationArray, $col,$order_column;
    $html = '';
    $noc_attr = '';

    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
    $fldArr = array();
    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
        $fldArr[$fld['id']] = $fld;
    }


    if ($case == 'group' || $case == 'groupques') {
        $get = '';

        if ($case == 'group') {
            $get = mysqli_query($conn, "SELECT * FROM questions where group_id = '{$row['group_id']}' and submission_type='before'");
        } else {
            $get = mysqli_query($conn, "SELECT * FROM questions where id='{$row['group_ques_id']}' and submission_type='before'");
        }
        if (mysqli_num_rows($get) > 0) {
            while ($row2 = mysqli_fetch_assoc($get)) {
                $row2['org_question'] = $row2['question'];
                $row2['org_notes'] = $row2['notes'];
                // Translation Check
                if ($_GET['Lang'] !== 'english') {
                    if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                        $row2['question'] = $row2['question_' . $col];
                    }
                    if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                        $row2['notes'] = $row2['notes_' . $col];
                    }
                }

                $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';
                $permission = '';
                if ($row2['permission'] == 1) {
                    $permission = 'permitted';
                } else {
                    $permission = 'forbidden';
                }
                $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row2['id']} ");

                if ($_COOKIE['AgreeCheck'] == 0) {
                    $html .= '<div class="unChecked main_parent_' . $row2['id'] . '">';
                } else {
                    $html .= '<div class="main_parent_' . $row2['id'] . '">';
                }

                $html .= '<div class="form-group sub_question_div sques_' . $id . '" id="question_div_' . $row2['id'] . '">';

                if ($row2['notes'] != '') {
                    $notes = $row2['notes'];


                    $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';;
                }
                $ques_label = $row2['question'];


                $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';


                $html .= '<div class="input-group input-group-merge ' . $permission . '  ' . $display_class . '">';
                if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
                    $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
                    $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker age" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                    $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
                    $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {

                    $yes = 'Yes';
                    $no = 'No';

                    // Translation Check
                    if ($_GET['Lang'] !== 'english') {
                        $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                        if (mysqli_num_rows($getLabels) > 0) {
                            $label_row = mysqli_fetch_assoc($getLabels);
                            $yes = $label_row['label_' . $col];
                        }
                        $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                        if (mysqli_num_rows($getLabels) > 0) {
                            $label_row = mysqli_fetch_assoc($getLabels);
                            $no = $label_row['label_' . $col];
                        }
                    }

                    $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row2['validation'] . ' type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $pid . ')" value="Yes" ' . $noc_attr . '><span class="customLabel" data-org="Yes">' . $yes . '</span>';
                    $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $pid . ')" value="No" ' . $noc_attr . '><span class="customLabel" data-org="No">' . $no . '</span>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                        $op = $row_label['label'];
                        //  Translation Check
                        if ($_GET['Lang'] !== 'english') {
                            if ($row_label['label_' . $col] != '') {
                                $op = $row_label['label_' . $col];
                            }
                        }
                        $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="n[question_' . $row2['id'] . ']" onClick="getQuestion(this,' . $row2['id'] . ',' . $pid . ')" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                    }
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {

                    $html .= '<select ' . $row2['validation'] . ' name="n[question_' . $row2['id'] . ']" class="form-control" onchange="getQuestion(this,' . $row2['id'] . ',' . $pid . ')" ' . $noc_attr . '>';
                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

                    while ($row_label = mysqli_fetch_assoc($getLabels)) {
                        $op = $row_label['label'];
                        //  Translation Check
                        if ($_GET['Lang'] !== 'english') {
                            if ($row_label['label_' . $col] != '') {
                                $op = $row_label['label_' . $col];
                            }
                        }
                        $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                    }
                    $html .= '</select>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
                    $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="n[sub_question_2' . $row2['id'] . ']" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {

                    $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" onchange="getQuestion(this,' . $row2['id'] . ',' . $pid . ')"  name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                    foreach ($countryArray as $getCountries) {
                        $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
                    }
                    $html .= '</select>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
                    $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="getQuestion(this,' . $row2['id'] . ',' . $pid . ')" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                    $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                    foreach ($educationArray as $getEducation) {
                        $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
                    }
                    $html .= '</select>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'number') {
                    $html .= '<input ' . $row2['validation'] . ' type="number"  class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                } else if ($fldArr[$row2['fieldtype']]['type'] == 'currentrange') {
                    $html .= '<label class="pb-date static_label">From</label>';
                    $html .= '<label class="pb-date static_label">To</label>';
                    $html .= '<input autocomplete="off" ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="from"  type="text" class="form-control datepicker nocPicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                    $html .= '<input autocomplete="off" ' . $row2['validation'] . ' data-date="YYYY-MM-DD" data-id="to"  type="text" onchange="position_date(this,' . $row2['id'] . ',' . $pid . ',2' . ')" class="form-control datepicker nocPicker" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                    $html .= '<div class="presCheck"><input  type="checkbox" class="present_checkbox" onchange="if(presentBox(this)==false){return false;}getQuestion(this,' . $row2['id'] . ',' . $pid . ')"><span class="presentCheckbox static_label">Present</span></div>';
                } else {
                    $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="getQuestion(this,' . $row2['id'] . ',' . $pid . ')" class="form-control" name="n[question_' . $row2['id'] . ']" ' . $noc_attr . '>';
                }
                $html .= '</div></div></div>';
            }
            return $html;
        }
    } else if ($case == 'existing') {

        if ($row['questiontype'] == 's_question') {

            $get = mysqli_query($conn, "SELECT * FROM level2_sub_questions where id = '{$row['existing_sid']}' ");
            $getLabels = mysqli_query($conn, "select * from level2 where question_id={$row['existing_sid']} ");
            $row2 = mysqli_fetch_assoc($get);
            $class = 'parent_' . $row2['id'];
            $name = 'n[sub_question_2' . $row2['id'] . ']';
            $q = 'getQuestion3(this,' . $row2['id'] . ',' . $row2['question_id'] . ')';
            $v = 'checkKey(this,' . $row2['id'] . ',' . $row2['question_id'] . ')';
        } else if ($row['questiontype'] == 'sm_question') {

            //            $get = mysqli_query($conn, "SELECT * FROM questions where id = '{$row['existing_sqid']}' and submission_type='before'");
            $get = mysqli_query($conn, "SELECT * FROM questions where id = '{$row['existing_sqid']}'");

            $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row['existing_sqid']} ");
            $row2 = mysqli_fetch_assoc($get);

            $class = 'main_parent_' . $row2['id'];
            $name = 'n[question_' . $row2['id'] . ']';
            $q = 'getQuestion(this,' . $row2['id'] . ',' . $id . ')';
            $v = 'checkKey(this,' . $row2['id'] . ',' . $id . ')';

            $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';
        } else {

            $get = mysqli_query($conn, "SELECT * FROM sub_questions where id = '{$row['existing_qid']}' ");
            $getLabels = mysqli_query($conn, "select * from level1 where question_id={$row['existing_qid']} ");
            $row2 = mysqli_fetch_assoc($get);


            $class = 'parent_' . $row2['id'];
            $name = 'n[sub_question_' . $row2['id'] . ']';
            $q = 'getQuestion3(this,' . $row2['id'] . ',' . $row2['question_id'] . ')';
            $v = 'checkKey(this,' . $row2['id'] . ',' . $row2['question_id'] . ')';
            $noc_attr = 'data-noc="' . $row2['noc_flag'] . '" data-position="' . $row2['position_no'] . '" data-type="' . $row2['noc_type'] . '" data-label="' . $row2['user_type'] . '"';
        }

        if (mysqli_num_rows($get) > 0) { {
            $row2['org_question'] = $row2['question'];
            $row2['org_notes'] = $row2['notes'];
            // Translation Check
            if ($_GET['Lang'] !== 'english') {
                if ($row2['question_' . $col] !== '' && $row2['question_' . $col] !== null) {
                    $row2['question'] = $row2['question_' . $col];
                }
                if ($row2['notes_' . $col] !== '' && $row2['notes_' . $col] !== null) {
                    $row2['notes'] = $row2['notes_' . $col];
                }
            }
            $permission = '';
            if ($row2['permission'] == 1) {
                $permission = 'permitted';
            } else {
                $permission = 'forbidden';
            }
            $html .= '<div class="' . $class . '">';
            $html .= '<div class="form-group sub_question_div sques_' . $id . '" id="question_div_' . $row2['id'] . '">';

            if ($row2['notes'] != '') {
                $notes = $row2['notes'];


                $html .= '<p class="notesPara" data-org="' . $row2['org_notes'] . '">' . $notes . '</p>';
            }
            $ques_label = $row2['question'];


            $html .= '<label class="pb-1" data-org="' . $row2['org_question'] . '">' . $ques_label . '</label>';

            $html .= '<div class="input-group input-group-merge ' . $permission . '  ' . $display_class . '">';
            if ($fldArr[$row2['fieldtype']]['type'] == 'calender') {
                $html .= '<input ' . $row2['validation'] . ' type="text" class="form-control datepicker" name="' . $name . '" ' . $noc_attr . '>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'age') {
                $html .= '<input ' . $row2['validation'] . ' onchange="' . $q . '" type="text" class="form-control datepicker age" name="' . $name . '" ' . $noc_attr . '>';
                $html .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row2['id'] . '">';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'email') {
                $html .= '<input ' . $row2['validation'] . ' type="email" class="form-control" name="' . $name . '" ' . $noc_attr . '>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 0) {
                $yes = 'Yes';
                $no = 'No';

                // Translation Check
                if ($_GET['Lang'] !== 'english') {
                    $getLabels = mysqli_query($conn, "select * from static_labels where label='$yes' ");
                    if (mysqli_num_rows($getLabels) > 0) {
                        $label_row = mysqli_fetch_assoc($getLabels);
                        $yes = $label_row['label_' . $col];
                    }
                    $getLabels = mysqli_query($conn, "select * from static_labels where label='$no' ");
                    if (mysqli_num_rows($getLabels) > 0) {
                        $label_row = mysqli_fetch_assoc($getLabels);
                        $no = $label_row['label_' . $col];
                    }
                }

                $html .= '<input id="Yes_' . $row2['id'] . '" ' . $row['validation'] . ' type="radio" class="radioButton" name="' . $name . '" onClick="' . $q . '" value="Yes" ' . $noc_attr . '><span class="customLabel" data-org="Yes">' . $yes . '</span>';
                $html .= '<input id="No_' . $row2['id'] . '" type="radio" class="radioButton" name="' . $name . '" onClick="' . $q . '" value="No" ' . $noc_attr . '><span class="customLabel" data-org="No">' . $no . '</span>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'radio' && $row2['labeltype'] == 1) {
                while ($row_label = mysqli_fetch_assoc($getLabels)) {
                    $op = $row_label['label'];
                    //  Translation Check
                    if ($_GET['Lang'] !== 'english') {
                        if ($row_label['label_' . $col] != '') {
                            $op = $row_label['label_' . $col];
                        }
                    }
                    $html .= '<input id="' . $row_label['label'] . '_' . $row2['id'] . '" required type="radio" class="radioButton" name="' . $name . '" onClick="' . $q . '" value="' . $row_label['value'] . '" ' . $noc_attr . '><span class="customLabel" data-org="' . $row_label['label'] . '">' . $op . ' </span>';
                }
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'dropdown') {
                $html .= '<select ' . $row2['validation'] . ' name="n[sub_question_' . $row2['id'] . ']" class="form-control" onchange="' . $q . '" ' . $noc_attr . '>';
                $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';

                while ($row_label = mysqli_fetch_assoc($getLabels)) {
                    $op = $row_label['label'];
                    //  Translation Check
                    if ($_GET['Lang'] !== 'english') {
                        if ($row_label['label_' . $col] != '') {
                            $op = $row_label['label_' . $col];
                        }
                    }
                    $html .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $op . '</option>';
                }
                $html .= '</select>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'phone') {
                $html .= '<input ' . $row2['validation'] . ' type="tel"   minlength="6" maxlength="15" class="form-control" name="' . $q . '" ' . $noc_attr . '>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'country') {
                $html .= '<select ' . $row2['validation'] . '  class="form-control countryCheck" onchange="' . $q . '" name="' . $name . '" ' . $noc_attr . '>';
                $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                foreach ($countryArray as $getCountries) {
                    $html .= '<option value="' . $getCountries['value'] . '">' . $getCountries['name'] . '</option>';
                }
                $html .= '</select>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'education') {
                $html .= '<select ' . $row2['validation'] . '  class="education form-control" onchange="' . $q . '" name="' . $name . '" ' . $noc_attr . '>';
                $html .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
                foreach ($educationArray as $getEducation) {
                    $html .= '<option value="' . $getEducation['value'] . '">' . $getEducation['name'] . '</option>';
                }
                $html .= '</select>';
            } else if ($fldArr[$row2['fieldtype']]['type'] == 'number') {
                $html .= '<input ' . $row2['validation'] . ' type="number"  class="form-control" name="' . $q . '" ' . $noc_attr . '>';
            } else {

                $html .= '<input ' . $row2['validation'] . ' type="text" onfocusout="' . $q . '" class="form-control" name="' . $name . '" ' . $noc_attr . '>';
            }
            $html .= '</div>';
            if ($row2['id'] == 127) {
                $html .= '<em class="static_label" style=" font-size: 12px;font-style: italic;">Press tab to continue</em>';
            }
            $html .= '</div></div>';
        }
            return $html;
        }
    }


    return '';
}
//------------------------------------------------------------------


////-----------NOC Array checker for user-----------------------------------------
function noc_check($score_id, $conn, $nocUser_array, $nocSpouse_array, $case, $type)
{
    if (sizeof($nocUser_array) == 0 && sizeof($nocSpouse_array) == 0) {
        return false;
    }


    global $scoreArray2, $nocScore, $casesArray;
    $main_colCount = 0;
    $main_valCount = 0;

    $colCount = 0;
    $valCount = 0;
    $caseArray = [];
    $or_check = 0;
    $sArray = [];
    $rArray = array();
    $myArray = array();
    $cc = [];
    $k = 0;
    $exp = 0;
    $noc = false;
    $province = false;
    $authorization = false;
    $region = false;
    $country = false;
    $value = false;
    $experience = false;
    $job_offer = false;
    $same_noc = false;
    $job_noc = 0;
    $rowCount1 = 0;
    $rowCount2 = 0;


    $high_skill = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '11', '12', '13', '21', '22', '30', '31', '32', '40', '41', '42', '43', '51', '52', '62', '63', '72', '73', '82', '92'];
    $low_skill = ['14', '15', '34', '44', '64', '65', '66', '67', '74', '75', '76', '84', '86', '94', '95', '96'];


    $select = mysqli_query($conn, "select * from score where id='$score_id'");
    $row = mysqli_fetch_assoc($select);
    $bracket_flag = $row['flags'];
    if ($bracket_flag == 1) {
        $brk_op = '||';
    } else if ($bracket_flag == 0) {

        $brk_op = '&&';
    } else if ($bracket_flag == 2) {

        $brk_op = '';
    }

    $select = mysqli_query($conn, "select * from score_noc where score_id=$score_id");
    $nc_row = false;
    $se = mysqli_query($conn, "select * from score_noc where score_id=$score_id and noc_or!=''");
    if (mysqli_num_rows($se) > 0) {
        $nc_row = true;
    }

    $r = '';
    $mCond = '';
    while ($r = mysqli_fetch_assoc($select)) {
        $rowCount2 = mysqli_num_rows($select);
        $rowCount1++;

        $sel = mysqli_query($conn, "select * from score where id='$score_id'");
        $ro = mysqli_fetch_assoc($sel);
        $sel = mysqli_query($conn, "select * from sub_groups where id='{$ro['sub_group']}'");
        $ro = mysqli_fetch_assoc($sel);
        $s['sub_group'] = $ro['name'];

        $open_bracket = $r['open_bracket'];
        $close_bracket = $r['close_bracket'];
        $noc = false;
        $skill = false;
        $province = false;
        $authorization = false;
        $region = false;
        $country = false;
        $experience = false;
        $colCheck = false;
        $notEqualsNoc = false;
        $notEqualsNocCount = 0;
        $job = false;
        $same = false;
        $e = 0;
        $index_value=0;


        if ($r['noc_type'] == 'user') {
            $myArray = $nocUser_array;
            $exp = $GLOBALS['userExperience'];
        }
        else {
            $myArray = $nocSpouse_array;
            $exp = $GLOBALS['spouseExperience'];
        }



        if ($r['job_offer'] != '') {
            $main_colCount++;
            if ($myArray[6]['job'] == $r['job_offer']) {
                $job = true;
                $job_offer = true;
                if ($r['same'] != '') {
                    $same_noc = true;
                }
                $main_valCount++;
            }
        }




        for ($i = 0; $i < sizeof($myArray); $i++)
        {
            $colCount=0;
            $valCount=0;
            if ($r['noc_number'] != '')
            {
                $colCount++;
                $snoc = explode(',', $r['noc_number']);
                if ($job == true) {
                    $i = 6;
                }

                if ($r['same_job'] != '') {
                    if (!$colCheck) {
                        $colCount++;
                        $colCheck = true;
                    }
                    if (check_cond($myArray[$i]['experience'], $r['operator'], $r['value']) && !$experience) {
                        $experience = true;
                        $valCount++;
                    }
                } else {
                    foreach ($snoc as $j) {
                        $j = ltrim(rtrim($j));
                        $skillNOC = explode(',', $myArray[$i]['noc']);

                        if (preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $j)) {
                            $n = preg_match_all("/[0-9]/", $j);
                            $a = 0;
                            if ($n == 1) {
                                $a = -3;
                            } else {
                                $a = -2;
                            }

                            $j = mb_substr($j, 0, $a);

                            foreach ($skillNOC as $sn) {
                                if (substr($sn, 0, $a) == '' || substr($sn, 0, $a) == null) {
                                    continue;
                                }
                                if ($j == substr($sn, 0, $a)) {
                                    $e += (float)$myArray[$i]['experience'];
                                    break 2;
                                }
                            }
                        } else {
                            foreach ($skillNOC as $sn) {

                                if ($j == $sn) {
                                    $e += (float)$myArray[$i]['experience'];
                                    break 2;
                                }
                            }
                        }
                    }

                    $exp = $e;


                }
                foreach ($snoc as $j) {
                    $j = rtrim(ltrim($j));

                    if ($r['noc_operator'] == '=') {

                        if (preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $j)) {
                            $n = preg_match_all("/[0-9]/", $j);
                            $a = 0;
                            if ($n == 1) {
                                $a = -3;
                            } else {
                                $a = -2;
                            }

                            $j = mb_substr($j, 0, $a);

                            $skillNOC = explode(',', $myArray[$i]['noc']);
                            foreach ($skillNOC as $sn) {
                                if (substr($sn, 0, $a) == '' || substr($sn, 0, $a) == null) {
                                    continue;
                                }
                                if ($j == substr($sn, 0, $a) && $noc != true) {
                                    if ($job && $r['same'] != '') {
                                        $job_noc = $j;
                                    }
                                    if ($job == false && $r['same'] != '') {
                                        if ($job_noc !== $j) {
                                            $colCount++;
                                        }
                                    }
                                    $noc = true;
                                    $index_value=$i;
                                    $valCount++;
                                    break;
                                }
                            }
                        } else {
                            $nn = explode(',', $myArray[$i]['noc']);
                            $n = array_search($j, $nn);
                            if ($noc != true) {
                                if ($n > -1) {
                                    if ($job && $r['same'] != '') {
                                        $job_noc = $j;
                                    }
                                    if ($job == false && $r['same'] != '') {
                                        if ($job_noc !== $j) {
                                            $colCount++;
                                        }
                                    }
                                    $noc = true;
                                    $index_value=$i;
                                    $valCount++;
                                    break;
                                }
                            }
                        }
                    } else {
                        $notEqualsNoc = true;
                        $ncA = explode(',', $myArray[$i]['noc']);
                        $ncA = array_filter($ncA, 'strlen');
                        if (array_search($j, $ncA) > -1) {
                            $notEqualsNocCount++;
                            break;
                        }
                    }
                }
                if ($notEqualsNoc) {
                    if ($notEqualsNocCount == 0) {
                        $noc = true;
                        $valCount++;
                        $index_value=$i;
                        break;
                    }
                }
            }
            if ($r['skill'] != '') {
                $colCount++;

                if ($r['skill'] == 'high') {
                    $snoc = $high_skill;
                } else {
                    $snoc = $low_skill;
                }

                $skillNOC = explode(',', $myArray[$i]['noc']);
                $skillNOC=array_filter($skillNOC);
                foreach ($skillNOC as $sn) {
                    if(array_search(substr($sn, 0, 2),$snoc) > -1 && $skill != true)
                    {
                        $skill = true;
                        $valCount++;
                        $index_value=$i;
                        break;
                    }
                }
                for ($i = 0; $i < sizeof($myArray); $i++) {

                    if ($r['same_job'] != '') {
                        if (!$colCheck) {

                            $colCount++;
                            $colCheck = true;
                        }
                        if (check_cond($myArray[$i]['experience'], $r['operator'], $r['value']) && !$experience) {
                            $experience = true;
                            $valCount++;
                        }
                    } else {
                        // copy above else
                        $skillNOC = explode(',', $myArray[$i]['noc']);
                        $skillNOC=array_filter($skillNOC);
                        foreach ($skillNOC as $sn) {
                            if(array_search(substr($sn, 0, 2),$snoc) > -1)
                            {
                                $e += (float)$myArray[$i]['experience'];
                                break;
                            }
                        }
                        $exp = $e;
                    }
                }
            }
            if ($r['country'] != '') {
                $colCount++;

                if ($myArray[$i]['country'] != '' && $myArray[$i]['country'] != ',') {
                    if (check_cond($myArray[$i]['country'], $r['country_operator'], $r['country']) && $country != true) {
                        $country = true;
                        $valCount++;
                    }
                }
            }
            if ($r['employment'] != '') {
                $colCount++;
                if ($r['employment'] == $myArray[$i]['employment']) {
                    $emp = true;
                    $valCount++;
                }

            }
            if ($r['province'] != '' && $r['province'] != ',') {
                $colCount++;
                $snoc = explode(',', $r['province']);
                if ($job == true) {
                    foreach ($snoc as $j) {
                        $j = rtrim(ltrim($j));
                        $myArray[6]['province'] = ltrim(rtrim($myArray[6]['province']));

                        if ($j != '' && $myArray[6]['province'] != '') {
                            if ($r['province_operator'] == '=') {
                                if ($j == $myArray[6]['province'] && $province != true) {
                                    $valCount++;
                                    $province = true;
                                    break;
                                }
                            } else {
                                if ($j != $myArray[6]['province'] && $province != true) {
                                    $valCount++;
                                    $province = true;
                                    break;
                                }
                            }
                        }
                    }
                } else {

                    foreach ($snoc as $j) {
                        $j = rtrim(ltrim($j));
                        $myArray[$i]['province'] = ltrim(rtrim($myArray[$i]['province']));

                        if ($j != '' && $myArray[$i]['province'] != '') {
                            if ($r['province_operator'] == '=') {

                                if ($j == $myArray[$i]['province'] && $province != true) {
                                    if ($r['employment'] != '') {
                                        if ($myArray[$i]['employment'] == 1) {
                                            $valCount++;
                                            $province = true;

                                            break;
                                        }
                                    } else {
                                        $valCount++;
                                        $province = true;

                                        break;
                                    }
                                }
                            } else {
                                if ($j != $myArray[$i]['province'] && $province != true) {
                                    if ($r['employment'] != '') {
                                        if ($myArray[$i]['employment'] == 1) {
                                            $valCount++;
                                            $province = true;
                                            break;
                                        }
                                    } else {
                                        $valCount++;
                                        $province = true;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($r['region'] != '' && $r['region'] != ',') {
                $colCount++;
                $snoc = explode(',', $r['region']);
                if (!$region) {
                    $rrr = explode('(', $myArray[$i]['region']);
                    $rr = rtrim($rrr[0]);
                    foreach ($snoc as $j) {

                        if ($j != '' && $rr != '') {

                            if ($j == $rr && $region != true) {

                                $region = true;
                                $valCount++;
                                break;
                            }
                        }
                    }
                }
            }
            if ($r['wage'] != '') {
                $colCount++;
                if (check_cond($myArray[$i]['wage'], $r['wage_operator'], $r['wage'])) {
                    $wage = true;
                    $valCount++;
                }
            }
            if ($r['hours'] != '') {
                $colCount++;

                if (check_cond($myArray[$i]['hours'], $r['hours_operator'], $r['hours'])) {
                    $hours = true;
                    $valCount++;
                }
            }
            if ($r['authorization'] != '' && $r['authorization'] != ',') {
                $colCount++;
                $snoc = explode(',', $r['authorization']);
                foreach ($snoc as $j) {
                    if ($j != '' && $myArray[$i]['authorization'] != '') {
                        if ($j == rtrim($myArray[$i]['authorization']) && $authorization != true) {
                            $authorization = true;
                            $valCount++;

                            break;
                        }
                    }
                }
            }
            if ($r['previous_years'] != '') {

                $colCount++;
                $current_year=date("Y");
                $previous_years=$r['previous_years'];
                $last_year=(int)$current_year-(int)$previous_years;
                $start_year='';
                $end_year='';
                $start_year=date("Y",strtotime($myArray[$i]['sdate']));
                $end_year=date("Y",strtotime($myArray[$i]['edate']));

                if($start_year>=$last_year && $end_year<=$current_year)
                {
                    $prev = true;
                    $valCount++;
                }

            }



            if ($r['region'] != '' && $r['region'] != ',') {
                $db_region = explode(',', $r['region']);

                $rrr = explode('(', $myArray[$i]['region']);
                $rr = rtrim($rrr[0]);
                $e = 0;
                for ($j = 0; $j < sizeof($myArray); $j++) {
                    foreach ($db_region as $db_reg) {
                        if ($db_reg != '' && $rr != '') {

                            if ($db_reg == $rr) {
                                $e += (float)$myArray[$j]['experience'];
                            }
                        }
                    }
                }
                $exp = $e;
            }
            else  if ($r['province'] != '' && $r['province'] != ',' && !$region) {
                $db_province= explode(',', $r['province']);

                $e = 0;
                for ($j = 0; $j < sizeof($myArray); $j++) {
                    foreach ($db_province as $db_prov) {
                        $db_prov = rtrim(ltrim($db_prov));
                        $myArray[$j]['province'] = ltrim(rtrim($myArray[$j]['province']));

                        if ($db_prov != '' && $myArray[$j]['province'] != '') {
                            if (check_cond($myArray[$j]['province'], $r['province_operator'], $db_prov))
                                $e += (float)$myArray[$j]['experience'];
                        }
                    }
                }



                $exp = $e;
            }
            else  if ($r['country'] != '' &&  !$province && !$region) {

                if ($myArray[$i]['country'] != '' && $myArray[$i]['country'] != ',') {
                    $e = 0;
                    for ($j = 0; $j < sizeof($myArray); $j++) {
                        if (check_cond($myArray[$j]['country'], $r['country_operator'], $r['country']))
                            $e += (float)$myArray[$j]['experience'];
                    }
                    $exp = $e;
                }
            }

            if($colCount==$valCount)
            {
                break;
            }

        }

        if ($r['value'] != '' && $r['same_job'] != '1') {
            $main_colCount++;

            if (check_cond($exp, $r['operator'], $r['value']) && $experience != true) {
                $experience = true;
                $main_valCount++;
            }
        }



        if ($r['same'] == '22' && $job == false) {
            $main_colCount++;
            $snoc = explode(',', $myArray[6]['noc']);
            for ($i = 0; $i < (sizeof($myArray)) - 1; $i++) {
                foreach ($snoc as $j) {
                    if ($j !== '' && $j !== ',') {
                        $j = rtrim(ltrim($j));
                        $nn = explode(',', $myArray[$i]['noc']);
                        $n = array_search($j, $nn);
                        if ($same != true) {
                            if ($n > -1) {
                                $same = true;
                                $main_valCount++;
                                break;
                            }
                        }
                    }
                }
            }
        }

//                  if($score_id==601)
//                                {
//                                    echo '<br>job-'.$job;
//                                    echo '<br>noc-'.$noc;
//                                    echo '<br>skill-'.$skill;
//                                    echo '<br>exp-'.$experience;
//                                    echo '<br>country-'.$country;
//                                    echo '<br>region-'.$region;
//                                    echo '<br>emp-'.$emp;
//                                    echo '<br>Hours-'.$hours;
//                                    echo '<br>Wage-'.$wage;
//                                    echo '<br>Province-'.$province;
//                                    echo '<br>Auth-'.$authorization;
//                                    echo '<br>Previous Years-'.$prev;
//                                    echo '-------<br><br>';
//                                }

        if ($r['conditionn'] == 'or') {
            $condition = '||';
        } else if ($r['conditionn'] == 'and') {
            $condition = "&&";
        } else {
            $condition = '';
        }
        $main_colCount+=$colCount;
        $main_valCount+=$valCount;
        $caseArray[$k] .= $open_bracket;
        $caseArray[$k] .= $main_colCount . '==' . $main_valCount . $close_bracket . ' ' . $condition . ' ';

        $main_colCount=0;
        $main_valCount=0;
        $valCount = 0;
        $colCount = 0;
        if (($r['conditionn'] == 'or' || $r['conditionn'] == 'and') && $rowCount1 != $rowCount2 && ($r['noc_or'] != '1' && $r['noc_or'] != 1)) {
            continue;
        } else if ($r['noc_or'] == '1' || $r['noc_or'] == 1) {

            $s['nc_row'] = $nc_row;

            //if ($r['conditionn'] == 'or')
            {
                $s['or_check2'] = 1;
            }
            if ($rowCount2 == 1 || $rowCount2 == $rowCount1) {

                $s['noc_or'] = $r['noc_or'];
                $s['score'] = $r['score_number'];
                $s['type'] = $type;
                $s['condition'] = $r['conditionn'];
                $s['scoreID'] = $row['scoreID'];
                if ($r['conditionn'] == 'question' || $r['conditionn'] == 'scoring') {
                    $s['move_qtype'] = $r['move_qtype'];
                    $s['move_qid'] = $r['move_qid'];
                    $s['move_scoreType'] = $r['move_scoreType'];
                    if ($r['conditionn'] == 'question') {
                        $s['otherCase'] = 'Move to Question - ' . $r['move_qid'];
                    } else if ($r['conditionn'] == 'scoring') {
                        $ss = mysqli_query($conn, "select * from score where id ='{$r['move_scoreType']}'");
                        $rr = mysqli_fetch_assoc($ss);
                        $s['otherCase'] = 'Move to Score - ' . $rr['scoreID'];
                    }
                }

                $sArray[$k] = $s;
                $rArray[] = $r;
                $k++;
            }
        } else if ($rowCount1 == $rowCount2) {
            $s['nc_row'] = $nc_row;

            if ($r['conditionn'] == 'or') {
                $s['or_check'] = 1;
            }

            $s['score'] = $r['score_number'];
            $s['type'] = $type;
            $s['condition'] = $r['conditionn'];
            $s['scoreID'] = $row['scoreID'];
            if ($r['conditionn'] == 'question' || $r['conditionn'] == 'scoring') {
                $s['move_qtype'] = $r['move_qtype'];
                $s['move_qid'] = $r['move_qid'];
                $s['move_scoreType'] = $r['move_scoreType'];
                if ($r['conditionn'] == 'question') {
                    $s['otherCase'] = 'Move to Question - ' . $r['move_qid'];
                } else if ($r['conditionn'] == 'scoring') {
                    $ss = mysqli_query($conn, "select * from score where id ='{$r['move_scoreType']}'");
                    $rr = mysqli_fetch_assoc($ss);
                    $s['otherCase'] = 'Move to Score - ' . $rr['scoreID'];
                }
            }

            $sArray[$k] = $s;
            $rArray[] = $r;
            $k++;
        }
        else {

            $s['nc_row'] = $nc_row;

            $s['score'] = $r['score_number'];
            $s['type'] = $type;
            $s['condition'] = $r['conditionn'];
            $s['scoreID'] = $row['scoreID'];
            if ($r['conditionn'] == 'question' || $r['conditionn'] == 'scoring') {
                $s['move_qtype'] = $r['move_qtype'];
                $s['move_qid'] = $r['move_qid'];
                $s['move_scoreType'] = $r['move_scoreType'];
                if ($r['conditionn'] == 'question') {
                    $s['otherCase'] = 'Move to Question - ' . $r['move_qid'];
                } else if ($r['conditionn'] == 'scoring') {
                    $ss = mysqli_query($conn, "select * from score where id ='{$r['move_scoreType']}'");
                    $rr = mysqli_fetch_assoc($ss);
                    $s['otherCase'] = 'Move to Score - ' . $rr['scoreID'];
                }
            }

            $sArray[$k] = $s;
            $rArray[] = $r;
            $k++;
        }

        $mCond = $r['conditionn'];
    }
    $ca = false;
    for ($j = 0; $j < sizeof($caseArray); $j++) {
        $d = '';

        if ($brk_op != '') {
            $b = explode($brk_op, $caseArray[$j]);

            foreach ($b as $a) {
                if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                    if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                        $a = substr($a, 0, -3);
                    }
                    $d .= '(' . $a . ') ' . $brk_op . ' ';
                }
            }
        } else {
            $d = $caseArray[$j];
        }


        if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
            $d = substr($d, 0, -3);
        }



        if ($sArray[$j]['or_check2'] == '1' || $sArray[$j]['or_check2'] == 1) {

            if (!$ca) {
                if ($rowCount2 == 1) {
                    $c2 = '((';
                    $b1 = ')';
                    $cond = '|| ';
                    $cond2 = '';
                    $b2 = '';
                    $bCheck = false;
                    for ($i = 0; $i < sizeof($caseArray); $i++) {

                        if ((sizeof($caseArray) > 1)) {
                            $cond2 = $cond;
                        }
                        if ($cond2 == '|| ' && $bCheck == false) {
                            $b2 = '(';
                            $bCheck = true;
                        }
                        $c2 .= $b2 . $caseArray[$i] . $b1 . $cond2;
                        $b1 = '';
                        $b2 = '';
                    }
                    $cc2 = str_replace('|| )', ')', $c2);
                    $cc2 = str_replace('|| ||', '', $cc2);

                    $cc2 .= ')';
                } else {
                    $cc2 = $d;
                }

//                if($score_id==601)
//                {
//                     echo ' NOC-case=+=>' . $cc2 . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score'];
//
//                }


                // echo ' NOC-case=+=>' . $cc2 . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score'];

                array_push($casesArray, ' NOC-case=+=>' . $cc2 . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score']);


                $c = eval('return ' . $cc2 . ';');
                $ca = true;
                $sArray[$j]['noc_case'] = $cc2;

                if ($c == 1) {
                    $sArray[$j]['noc_verify'] = 1;
                    $nocScore[] = $sArray[$j];
                    return true;
                } else {
                    $sArray[$j]['noc_verify'] = 0;
                    $nocScore[] = $sArray[$j];
                    return true;
                }
            }
        } else {

//            if($score_id==601)
//            {
//                echo '<br> NOC-case==>' . $d . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score'];
//            }
            //echo '<br> NOC-case==>' . $d . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score'];

            array_push($casesArray, ' NOC-case==>' . $d . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score']);

            $c = eval('return ' . $d . ';');

            if ($c == 1) {

                if ($sArray[$j]['condition'] == 'question' || $sArray[$j]['condition'] == 'scoring') {
                    $scoreArray2[] = $sArray[$j];
                    return $rArray[$j];
                } else if ($case == 0) {
                    $nocScore[] = $sArray[$j];
                    return true;
                } else {
                    $nocScore[] = $sArray[$j];
                    return true;
                }
                break;
            } else if ($sArray[$j]['or_check'] == 1 || $sArray[$j]['score'] != '') {
                if ($sArray[$j]['scoreID'] !== $sArray[$j + 1]['scoreID']) {
                    return true;
                }
            }
        }
    }
}
//------------------------------------------------------------------


//-----------NOC Array checker for spouse-----------------------------------------
function noc_check2($score_id, $conn, $nocUser_array, $nocSpouse_array, $case, $type)
{

    if (sizeof($nocUser_array) == 0 && sizeof($nocSpouse_array) == 0) {
        return false;
    }

    global $spouseScoreArray2, $spouseNocScore, $casesArray;
    $main_colCount=0;
    $main_valCount=0;

    $colCount = 0;
    $valCount = 0;
    $caseArray = [];
    $or_check = 0;
    $sArray = [];
    $rArray = array();
    $myArray = array();
    $cc = [];
    $k = 0;
    $exp = 0;
    $noc = false;
    $province = false;
    $authorization = false;
    $region = false;
    $country = false;
    $value = false;
    $experience = false;
    $rowCount1 = 0;
    $rowCount2 = 0;


    $high_skill = ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '11', '12', '13', '21', '22', '30', '31', '32', '40', '41', '42', '43', '51', '52', '62', '63', '72', '73', '82', '92'];
    $low_skill = ['14', '15', '34', '44', '64', '65', '66', '67', '74', '75', '76', '84', '86', '94', '95', '96'];


    $select = mysqli_query($conn, "select * from score where id='$score_id'");
    $row = mysqli_fetch_assoc($select);
    $bracket_flag = $row['flags'];
    if ($bracket_flag == 1) {
        $brk_op = '||';
    } else if ($bracket_flag == 0) {

        $brk_op = '&&';
    } else if ($bracket_flag == 2) {

        $brk_op = '';
    }

    $select = mysqli_query($conn, "select * from score_noc where score_id=$score_id");
    $nc_row = false;
    $se = mysqli_query($conn, "select * from score_noc where score_id=$score_id and noc_or!=''");
    if (mysqli_num_rows($se) > 0) {
        $nc_row = true;
    }

    $r = '';
    $mCond = '';
    while ($r = mysqli_fetch_assoc($select)) {
        $rowCount2 = mysqli_num_rows($select);
        $rowCount1++;

        $sel = mysqli_query($conn, "select * from score where id='$score_id'");
        $ro = mysqli_fetch_assoc($sel);
        $sel = mysqli_query($conn, "select * from sub_groups where id='{$ro['sub_group']}'");
        $ro = mysqli_fetch_assoc($sel);
        $s['sub_group'] = $ro['name'];

        $open_bracket = $r['open_bracket'];
        $close_bracket = $r['close_bracket'];
        $noc = false;
        $province = false;
        $authorization = false;
        $region = false;
        $country = false;
        $experience = false;
        $colCheck = false;
        $nocNotEquals = false;
        $nocNotEqualsCount = 0;
        $e = 0;
        $job = false;
        $same = false;
        $skill=false;

        if ($r['noc_type'] == 'spouse') {
            $myArray = $nocUser_array;
            $exp = $GLOBALS['userExperience'];
        } else {
            $myArray = $nocSpouse_array;
            $exp = $GLOBALS['spouseExperience'];
        }

        if ($r['job_offer'] != '') {
            $main_colCount++;
            if ($myArray[6]['job'] == $r['job_offer']) {
                $job = true;
                $job_offer = true;
                if ($r['same'] != '') {
                    $same_noc = true;
                }
                $main_valCount++;
            }
        }




        for ($i = 0; $i < sizeof($myArray); $i++)
        {
            $colCount=0;
            $valCount=0;
            if ($r['noc_number'] != '')
            {
                $colCount++;
                $snoc = explode(',', $r['noc_number']);
                if ($job == true) {
                    $i = 6;
                }

                if ($r['same_job'] != '') {
                    if (!$colCheck) {
                        $colCount++;
                        $colCheck = true;
                    }
                    if (check_cond($myArray[$i]['experience'], $r['operator'], $r['value']) && !$experience) {
                        $experience = true;
                        $valCount++;
                    }
                } else {
                    foreach ($snoc as $j) {
                        $j = ltrim(rtrim($j));
                        $skillNOC = explode(',', $myArray[$i]['noc']);

                        if (preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $j)) {
                            $n = preg_match_all("/[0-9]/", $j);
                            $a = 0;
                            if ($n == 1) {
                                $a = -3;
                            } else {
                                $a = -2;
                            }

                            $j = mb_substr($j, 0, $a);

                            foreach ($skillNOC as $sn) {
                                if (substr($sn, 0, $a) == '' || substr($sn, 0, $a) == null) {
                                    continue;
                                }
                                if ($j == substr($sn, 0, $a)) {
                                    $e += (float)$myArray[$i]['experience'];
                                    break 2;
                                }
                            }
                        } else {
                            foreach ($skillNOC as $sn) {

                                if ($j == $sn) {
                                    $e += (float)$myArray[$i]['experience'];
                                    break 2;
                                }
                            }
                        }
                    }

                    $exp = $e;


                }
                foreach ($snoc as $j) {
                    $j = rtrim(ltrim($j));

                    if ($r['noc_operator'] == '=') {

                        if (preg_match('([a-zA-Z].*[0-9]|[0-9].*[a-zA-Z])', $j)) {
                            $n = preg_match_all("/[0-9]/", $j);
                            $a = 0;
                            if ($n == 1) {
                                $a = -3;
                            } else {
                                $a = -2;
                            }

                            $j = mb_substr($j, 0, $a);

                            $skillNOC = explode(',', $myArray[$i]['noc']);
                            foreach ($skillNOC as $sn) {
                                if (substr($sn, 0, $a) == '' || substr($sn, 0, $a) == null) {
                                    continue;
                                }
                                if ($j == substr($sn, 0, $a) && $noc != true) {
                                    if ($job && $r['same'] != '') {
                                        $job_noc = $j;
                                    }
                                    if ($job == false && $r['same'] != '') {
                                        if ($job_noc !== $j) {
                                            $colCount++;
                                        }
                                    }
                                    $noc = true;
                                    $index_value=$i;
                                    $valCount++;
                                    break;
                                }
                            }
                        } else {
                            $nn = explode(',', $myArray[$i]['noc']);
                            $n = array_search($j, $nn);
                            if ($noc != true) {
                                if ($n > -1) {
                                    if ($job && $r['same'] != '') {
                                        $job_noc = $j;
                                    }
                                    if ($job == false && $r['same'] != '') {
                                        if ($job_noc !== $j) {
                                            $colCount++;
                                        }
                                    }
                                    $noc = true;
                                    $index_value=$i;
                                    $valCount++;
                                    break;
                                }
                            }
                        }
                    } else {
                        $nocNotEquals = true;
                        $ncA = explode(',', $myArray[$i]['noc']);
                        $ncA = array_filter($ncA, 'strlen');
                        if (array_search($j, $ncA) > -1) {
                            $nocNotEqualsCount++;
                            break;
                        }
                    }
                }
                if ($nocNotEquals) {
                    if ($nocNotEqualsCount == 0) {
                        $noc = true;
                        $valCount++;
                        $index_value=$i;
                        break;
                    }
                }
            }
            if ($r['skill'] != '') {
                $colCount++;

                if ($r['skill'] == 'high') {
                    $snoc = $high_skill;
                } else {
                    $snoc = $low_skill;
                }

                $skillNOC = explode(',', $myArray[$i]['noc']);
                $skillNOC=array_filter($skillNOC);
                foreach ($skillNOC as $sn) {
                    if(array_search(substr($sn, 0, 2),$snoc) > -1 && $skill != true)
                    {
                        $skill = true;
                        $valCount++;
                        break;
                    }
                }
                for ($i = 0; $i < sizeof($myArray); $i++) {

                    if ($r['same_job'] != '') {
                        if (!$colCheck) {

                            $colCount++;
                            $colCheck = true;
                        }
                        if (check_cond($myArray[$i]['experience'], $r['operator'], $r['value']) && !$experience) {
                            $experience = true;
                            $valCount++;
                        }
                    } else {
                        // copy above else
                        $skillNOC = explode(',', $myArray[$i]['noc']);
                        $skillNOC=array_filter($skillNOC);
                        foreach ($skillNOC as $sn) {
                            if(array_search(substr($sn, 0, 2),$snoc) > -1)
                            {
                                $e += (float)$myArray[$i]['experience'];
                                break;
                            }
                        }
                        $exp = $e;
                    }
                }
            }
            if ($r['country'] != '') {
                $colCount++;

                if ($myArray[$i]['country'] != '' && $myArray[$i]['country'] != ',') {
                    if (check_cond($myArray[$i]['country'], $r['country_operator'], $r['country']) && $country != true) {
                        $country = true;
                        $valCount++;
                    }
                }
            }
            if ($r['employment'] != '') {
                $colCount++;
                if ($r['employment'] == $myArray[$i]['employment']) {
                    $emp = true;
                    $valCount++;
                }

            }
            if ($r['province'] != '' && $r['province'] != ',') {
                $colCount++;
                $snoc = explode(',', $r['province']);
                if ($job == true) {
                    foreach ($snoc as $j) {
                        $j = rtrim(ltrim($j));
                        $myArray[6]['province'] = ltrim(rtrim($myArray[6]['province']));

                        if ($j != '' && $myArray[6]['province'] != '') {
                            if ($r['province_operator'] == '=') {
                                if ($j == $myArray[6]['province'] && $province != true) {
                                    $valCount++;
                                    $province = true;
                                    break;
                                }
                            } else {
                                if ($j != $myArray[6]['province'] && $province != true) {
                                    $valCount++;
                                    $province = true;
                                    break;
                                }
                            }
                        }
                    }
                } else {

                    foreach ($snoc as $j) {
                        $j = rtrim(ltrim($j));
                        $myArray[$i]['province'] = ltrim(rtrim($myArray[$i]['province']));

                        if ($j != '' && $myArray[$i]['province'] != '') {
                            if ($r['province_operator'] == '=') {

                                if ($j == $myArray[$i]['province'] && $province != true) {
                                    if ($r['employment'] != '') {
                                        if ($myArray[$i]['employment'] == 1) {
                                            $valCount++;
                                            $province = true;

                                            break;
                                        }
                                    } else {
                                        $valCount++;
                                        $province = true;

                                        break;
                                    }
                                }
                            } else {
                                if ($j != $myArray[$i]['province'] && $province != true) {
                                    if ($r['employment'] != '') {
                                        if ($myArray[$i]['employment'] == 1) {
                                            $valCount++;
                                            $province = true;
                                            break;
                                        }
                                    } else {
                                        $valCount++;
                                        $province = true;
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($r['region'] != '' && $r['region'] != ',') {
                $colCount++;
                $snoc = explode(',', $r['region']);
                if (!$region) {
                    $rrr = explode('(', $myArray[$i]['region']);
                    $rr = rtrim($rrr[0]);
                    foreach ($snoc as $j) {

                        if ($j != '' && $rr != '') {

                            if ($j == $rr && $region != true) {

                                $region = true;
                                $valCount++;
                                break;
                            }
                        }
                    }
                }
            }
            if ($r['wage'] != '') {
                $colCount++;
                if (check_cond($myArray[$i]['wage'], $r['wage_operator'], $r['wage'])) {
                    $wage = true;
                    $valCount++;
                }
            }
            if ($r['hours'] != '') {
                $colCount++;

                if (check_cond($myArray[$i]['hours'], $r['hours_operator'], $r['hours'])) {
                    $hours = true;
                    $valCount++;
                }
            }
            if ($r['authorization'] != '' && $r['authorization'] != ',') {
                $colCount++;
                $snoc = explode(',', $r['authorization']);
                foreach ($snoc as $j) {
                    if ($j != '' && $myArray[$i]['authorization'] != '') {
                        if ($j == rtrim($myArray[$i]['authorization']) && $authorization != true) {
                            $authorization = true;
                            $valCount++;

                            break;
                        }
                    }
                }
            }
            if ($r['previous_years'] != '') {

                $colCount++;
                $current_year=date("Y");
                $previous_years=$r['previous_years'];
                $last_year=(int)$current_year-(int)$previous_years;
                $start_year='';
                $end_year='';
                $start_year=date("Y",strtotime($myArray[$i]['sdate']));
                $end_year=date("Y",strtotime($myArray[$i]['edate']));

                if($start_year>=$last_year && $end_year<=$current_year)
                {
                    $prev = true;
                    $valCount++;
                }

            }



            if ($r['region'] != '' && $r['region'] != ',') {
                $db_region = explode(',', $r['region']);

                $rrr = explode('(', $myArray[$i]['region']);
                $rr = rtrim($rrr[0]);
                $e = 0;
                for ($j = 0; $j < sizeof($myArray); $j++) {
                    foreach ($db_region as $db_reg) {
                        if ($db_reg != '' && $rr != '') {

                            if ($db_reg == $rr) {
                                $e += (float)$myArray[$j]['experience'];
                            }
                        }
                    }
                }
                $exp = $e;
            }
            else  if ($r['province'] != '' && $r['province'] != ',' && !$region) {
                $db_province= explode(',', $r['province']);

                $e = 0;
                for ($j = 0; $j < sizeof($myArray); $j++) {
                    foreach ($db_province as $db_prov) {
                        $db_prov = rtrim(ltrim($db_prov));
                        $myArray[$j]['province'] = ltrim(rtrim($myArray[$j]['province']));

                        if ($db_prov != '' && $myArray[$j]['province'] != '') {
                            if (check_cond($myArray[$j]['province'], $r['province_operator'], $db_prov))
                                $e += (float)$myArray[$j]['experience'];
                        }
                    }
                }



                $exp = $e;
            }
            else  if ($r['country'] != '' &&  !$province && !$region) {

                if ($myArray[$i]['country'] != '' && $myArray[$i]['country'] != ',') {
                    $e = 0;
                    for ($j = 0; $j < sizeof($myArray); $j++) {
                        if (check_cond($myArray[$j]['country'], $r['country_operator'], $r['country']))
                            $e += (float)$myArray[$j]['experience'];
                    }
                    $exp = $e;
                }
            }

            if($colCount==$valCount)
            {
                break;
            }

        }

        if ($r['value'] != '' && $r['same_job'] != '1') {
            $main_colCount++;

            if (check_cond($exp, $r['operator'], $r['value']) && $experience != true) {
                $experience = true;
                $main_valCount++;
            }
        }



        if ($r['same'] == '22' && $job == false) {
            $main_colCount++;
            $snoc = explode(',', $myArray[6]['noc']);
            for ($i = 0; $i < (sizeof($myArray)) - 1; $i++) {
                foreach ($snoc as $j) {
                    if ($j !== '' && $j !== ',') {
                        $j = rtrim(ltrim($j));
                        $nn = explode(',', $myArray[$i]['noc']);
                        $n = array_search($j, $nn);
                        if ($same != true) {
                            if ($n > -1) {
                                $same = true;
                                $main_valCount++;
                                break;
                            }
                        }
                    }
                }
            }
        }
        //        if($score_id==1072)
        //        {
        //            echo '<br>j-'.$job;
        //
        //            echo '<br>noc-'.$noc;
        //            echo '<br>prov-'.$province;
        //            echo '<br>v-'.$experience;
        //
        //        }

        if ($r['conditionn'] == 'or') {
            $condition = '||';
        } else if ($r['conditionn'] == 'and') {
            $condition = "&&";
        } else {
            $condition = '';
        }
        $main_colCount+=$colCount;
        $main_valCount+=$valCount;
        $caseArray[$k] .= $open_bracket;
        $caseArray[$k] .= $main_colCount . '==' . $main_valCount . $close_bracket . ' ' . $condition . ' ';
        $main_colCount=0;
        $main_valCount=0;
        $valCount = 0;
        $colCount = 0;
        if (($r['conditionn'] == 'or' || $r['conditionn'] == 'and') && $rowCount1 != $rowCount2 && ($r['noc_or'] != '1' && $r['noc_or'] != 1)) {
            continue;
        } else if ($r['noc_or'] == '1' || $r['noc_or'] == 1) {

            $s['nc_row'] = $nc_row;

            //if ($r['conditionn'] == 'or')
            {
                $s['or_check2'] = 1;
            }

            if ($rowCount2 == 1 || $rowCount2 == $rowCount1) {
                $s['noc_or'] = $r['noc_or'];
                $s['score'] = $r['score_number'];
                $s['type'] = $type;
                $s['condition'] = $r['conditionn'];
                $s['scoreID'] = $row['scoreID'];
                if ($r['conditionn'] == 'question' || $r['conditionn'] == 'scoring') {
                    $s['move_qtype'] = $r['move_qtype'];
                    $s['move_qid'] = $r['move_qid'];
                    $s['move_scoreType'] = $r['move_scoreType'];
                    if ($r['conditionn'] == 'question') {
                        $s['otherCase'] = 'Move to Question - ' . $row['move_qid'];
                    } else if ($r['conditionn'] == 'scoring') {
                        $ss = mysqli_query($conn, "select * from score where id ='{$r['move_scoreType']}'");
                        $rr = mysqli_fetch_assoc($ss);
                        $s['otherCase'] = 'Move to Score - ' . $rr['scoreID'];
                    }
                }

                $sArray[$k] = $s;
                $rArray[] = $r;
                $k++;
            }
        } else if ($rowCount1 == $rowCount2) {
            $s['nc_row'] = $nc_row;

            if ($r['conditionn'] == 'or') {
                $s['or_check'] = 1;
            }

            $s['score'] = $r['score_number'];
            $s['type'] = $type;
            $s['condition'] = $r['conditionn'];
            $s['scoreID'] = $row['scoreID'];
            if ($r['conditionn'] == 'question' || $r['conditionn'] == 'scoring') {
                $s['move_qtype'] = $r['move_qtype'];
                $s['move_qid'] = $r['move_qid'];
                $s['move_scoreType'] = $r['move_scoreType'];
                if ($r['conditionn'] == 'question') {
                    $s['otherCase'] = 'Move to Question - ' . $row['move_qid'];
                } else if ($r['conditionn'] == 'scoring') {
                    $ss = mysqli_query($conn, "select * from score where id ='{$r['move_scoreType']}'");
                    $rr = mysqli_fetch_assoc($ss);
                    $s['otherCase'] = 'Move to Score - ' . $rr['scoreID'];
                }
            }

            $sArray[$k] = $s;
            $rArray[] = $r;
            $k++;
        } else {
            $s['nc_row'] = $nc_row;

            $s['score'] = $r['score_number'];
            $s['type'] = $type;
            $s['condition'] = $r['conditionn'];
            $s['scoreID'] = $row['scoreID'];
            if ($r['conditionn'] == 'question' || $r['conditionn'] == 'scoring') {
                $s['move_qtype'] = $r['move_qtype'];
                $s['move_qid'] = $r['move_qid'];
                $s['move_scoreType'] = $r['move_scoreType'];
                if ($r['conditionn'] == 'question') {
                    $s['otherCase'] = 'Move to Question - ' . $row['move_qid'];
                } else if ($r['conditionn'] == 'scoring') {
                    $ss = mysqli_query($conn, "select * from score where id ='{$r['move_scoreType']}'");
                    $rr = mysqli_fetch_assoc($ss);
                    $s['otherCase'] = 'Move to Score - ' . $rr['scoreID'];
                }
            }

            $sArray[$k] = $s;
            $rArray[] = $r;
            $k++;
        }

        $mCond = $r['conditionn'];
    }
    $ca = false;
    for ($j = 0; $j < sizeof($caseArray); $j++) {
        $d = '';

        if ($brk_op != '') {
            $b = explode($brk_op, $caseArray[$j]);

            foreach ($b as $a) {
                if ($a != '' && $a != ' ' && $a != null && $a != NULL) {
                    if (substr($a, -3) == '&& ' || substr($a, -3) == '|| ') {
                        $a = substr($a, 0, -3);
                    }
                    $d .= '(' . $a . ') ' . $brk_op . ' ';
                }
            }
        } else {
            $d = $caseArray[$j];
        }


        if (substr($d, -3) == '&& ' || substr($d, -3) == '|| ') {
            $d = substr($d, 0, -3);
        }



        if ($sArray[$j]['or_check2'] == '1' || $sArray[$j]['or_check2'] == 1) {

            if (!$ca) {
                if ($rowCount2 == 1) {
                    $c2 = '((';
                    $b1 = ')';
                    $cond = '|| ';
                    $cond2 = '';
                    $b2 = '';
                    $bCheck = false;
                    for ($i = 0; $i < sizeof($caseArray); $i++) {

                        if ((sizeof($caseArray) > 1)) {
                            $cond2 = $cond;
                        }
                        if ($cond2 == '|| ' && $bCheck == false) {
                            $b2 = '(';
                            $bCheck = true;
                        }
                        $c2 .= $b2 . $caseArray[$i] . $b1 . $cond2;
                        $b1 = '';
                        $b2 = '';
                    }
                    $cc2 = str_replace('|| )', ')', $c2);
                    $cc2 = str_replace('|| ||', '', $cc2);

                    $cc2 .= ')';
                } else {
                    $cc2 = $d;
                }
                //     echo '<br> NOC-case (spouse)=+=>' . $cc2 . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score'];

                array_push($casesArray, ' NOC-case (spouse)=+=>' . $cc2 . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score']);


                $c = eval('return ' . $cc2 . ';');
                $ca = true;
                $sArray[$j]['noc_case'] = $cc2;

                if ($c == 1) {
                    $sArray[$j]['noc_verify'] = 1;
                    $spouseNocScore[] = $sArray[$j];
                    return true;
                } else {
                    $sArray[$j]['noc_verify'] = 0;
                    $spouseNocScore[] = $sArray[$j];
                    return true;
                }
            }
        } else {

            //   echo '<br> NOC-case (spouse)==>' . $d . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score'];
            array_push($casesArray, ' NOC-case (spouse)==>' . $d . '--' . $sArray[$j]['scoreID'] . '--' . $sArray[$j]['score']);
            $c = eval('return ' . $d . ';');

            if ($c == 1) {
                if ($sArray[$j]['condition'] == 'question' || $sArray[$j]['condition'] == 'scoring') {
                    $spouseScoreArray2[] = $sArray[$j];

                    return $rArray[$j];
                } else if ($case == 0) {
                    $spouseNocScore[] = $sArray[$j];
                    return true;
                } else {
                    $spouseNocScore[] = $sArray[$j];
                    return true;
                }
                break;
            } else if ($sArray[$j]['or_check'] == 1 || $sArray[$j]['score'] != '') {
                if ($sArray[$j]['scoreID'] !== $sArray[$j + 1]['scoreID']) {
                    return true;
                }
            }
        }
    }
}
//------------------------------------------------------------------


//------------Search function for associative array----------------------------------
function search_assoc($value, $array)
{
    $result = false;
    foreach ($array as $el) {
        if (!is_array($el)) {
            $result = $result || ($el == $value);
        } else if (in_array($value, $el))
            $result = $result || true;
        else $result = $result || false;
    }
    return $result;
}
function searchForId($id, $array) {
    foreach ($array as $key => $val) {
        if ($val['id'] === $id) {
            return true;//$key;
        }
    }
    return false;
}

function searchColumn($value, $array,$column) {
    foreach ($array as $key => $val) {
        if ($val[$column] === $value) {
            return true;//$key;
        }
    }
    return false;
}
//------------------------------------------------------------------


//--------------compare and eliminate subgroups-----------------------------------
function check_subGroups()
{
    global $conn, $scoreArray, $nocScore;
    $p = 0;
    $tArr = [];
    $grpArrr = [];
    $grpArrr2 = [];

    $minArr = [];
    $minArr2 = [];
    $subgroupArr = group_by($scoreArray, 'sub_group');

    // this for score array
    $select = mysqli_query($conn, "select * from sub_groups");
    while ($row = mysqli_fetch_assoc($select)) {
        $type = $row['name'];

        if (array_key_exists($type, $subgroupArr)) {
            $s = array();
            $s['score'] = array_sum($subgroupArr[$type]);
            $s['group'] = $type;
            $s['no'] = substr($type, 1);
            $grpArrr[$p] = $s;
            $p++;
        }
    }
    $n = '';

    for ($i = 1; $i < 11; $i++) {
        $u = 0;
        foreach ($grpArrr as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] > $u) {
                    $u = $k['score'];
                    $tArr[$i] = $k;
                }
            }
        }
        foreach ($grpArrr as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] < $u) {
                    $n .= $k['no'] . ',';
                    $minArr[] = $k;
                }
            }
        }
        foreach ($grpArrr as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] == $u) {
                    $check = search_assoc($k['no'], $minArr);
                    if ($check != '') {
                    } else {
                        $minArr[] = $k;
                    }
                }
            }
        }
    }


    foreach ($minArr as $m) {

        $c = array_count_values(array_column($grpArrr, 'no'))[$m['no']];
        if ($c > 1) {
            foreach ($scoreArray as $k => $v) {
                if ($m['group'] == $v['sub_group']) {
                    unset($scoreArray[$k]);
                }
            }
        }
    }

    //    this is for nocScore Array
    $subgroupArr2 = group_by($nocScore, 'sub_group');

    $select = mysqli_query($conn, "select * from sub_groups");
    while ($row = mysqli_fetch_assoc($select)) {
        $type = $row['name'];

        if (array_key_exists($type, $subgroupArr2)) {
            $ss = array();
            $ss['score'] = array_sum($subgroupArr2[$type]);
            $ss['group'] = $type;
            $ss['no'] = substr($type, 1);
            $grpArrr2[$p] = $ss;
            $p++;
        }
    }
    $n = '';

    for ($i = 1; $i < 11; $i++) {
        $u = 0;
        foreach ($grpArrr2 as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] > $u) {
                    $u = $k['score'];
                    $tArr[$i] = $k;
                }
            }
        }
        foreach ($grpArrr2 as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] < $u) {
                    $n .= $k['no'] . ',';
                    $minArr2[] = $k;
                }
            }
        }
        foreach ($grpArrr2 as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] == $u) {
                    $check = search_assoc($k['no'], $minArr2);
                    if ($check != '') {
                    } else {
                        $minArr2[] = $k;
                    }
                }
            }
        }
    }


    foreach ($minArr2 as $m) {
        $c = array_count_values(array_column($grpArrr2, 'no'))[$m['no']];
        if ($c > 1) {
            foreach ($nocScore as $k => $v) {
                if ($m['group'] == $v['sub_group']) {
                    unset($nocScore[$k]);
                }
            }
        }
    }
}
//------------------------------------------------------------------


//-----------Saving scores for user---------------------------------------
function saveScore($conn, $scoreArr, $nocArr, $id, $scoreArr2, $user_type)
{
    $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation2 where user=$id");
    if(mysqli_num_rows($getQuery)>0)
    {
        $getQuery = mysqli_query($conn, "DELETE FROM score_calculation2 where user=$id");

    }


    for ($p = 0; $p < sizeof($scoreArr); $p++) {
        if ($scoreArr[$p]['scoreID'] >= 1 && $scoreArr[$p]['scoreID'] <= 16) {
            $type = $scoreArr[$p]['type'];
            $user = '';
            if ($scoreArr[$p]['for'] == 'user') {
                $user = 'user';
            } else {
                $user = 'spouse';
            }

            $query = "insert into score_calculation2 (type,scoreID,user,score,user_type) values ('$type','{$scoreArr[$p]['scoreID']}',$id,'{$scoreArr[$p]['score']}','$user')";
            $insert = mysqli_query($conn, $query);
            unset($scoreArr[$p]);
        }
    }



    $fscore = 0;
    $q = 0;



    $maxArray = array();
    $groupedArr1 = group_by($scoreArr, 'scoreID');
    $groupedArr2 = group_by($nocArr, 'scoreID');

    foreach ($scoreArr as $k => $v) {
        if ($v['max_score'] != '') {
            $maxArray[$v['scoreID']] = $v['max_score'];
        }
    }

    $select = mysqli_query($conn, "select * from score where scoreID > 16");
    while ($row = mysqli_fetch_assoc($select)) {
        $type = $row['scoreID'];
        $s = 0;
        $score1 = 0;
        $score2 = 0;
        if (array_key_exists($type, $groupedArr1)) {
            $score1 = array_sum($groupedArr1[$type]);
        }
        if (array_key_exists($type, $groupedArr2)) {
            $score2 = array_sum($groupedArr2[$type]);
        }

        $s = $score1 + $score2;


        if ($maxArray[$type] != '' && $maxArray[$type] != 0 && $s > $maxArray[$type]) {
            $s = $maxArray[$type];
        }


        if (($s == '0s' || $s == '0r' || $s == '0w' || $s == '0l') && ($s != '0')) {
            $query = "insert into score_calculation2 (type,scoreID,user,score,user_type) values ('{$row['type']}','$type',$id,'$s','$user_type')";
            $insert = mysqli_query($conn, $query);
        }
        if ($s != 0 && $s != '0') {
            $query = "insert into score_calculation2 (type,scoreID,user,score,user_type) values ('{$row['type']}','$type',$id,'$s','$user_type')";
            $insert = mysqli_query($conn, $query);
        }
    }

    for ($i = 0; $i < sizeof($scoreArr2); $i++) {
        $query = "insert into score_calculation2 (type,scoreID,user,score,user_type) values ('{$scoreArr2[$i]['type']}','{$scoreArr2[$i]['scoreID']}',$id,'{$scoreArr2[$i]['otherCase']}','$user_type')";
        $insert = mysqli_query($conn, $query);
    }

    $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation2 where user=$id order by id desc");
    $total_score = 0;
    while ($Row = mysqli_fetch_assoc($getQuery)) {
        if (ctype_digit($Row['score']))
            $total_score += $Row['score'];
    }
    return $total_score;
}
//------------------------------------------------------------------


//-----------Saving scores for spouse---------------------------------------
function saveScore2($conn, $scoreArr, $nocArr, $id, $scoreArr2, $user_type)
{
    $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation where user=$id");
    if(mysqli_num_rows($getQuery)>0)
    {
        $getQuery = mysqli_query($conn, "DELETE FROM score_calculation where user=$id");

    }
    //print_r($scoreArr);
    for ($p = 0; $p < sizeof($scoreArr); $p++) {
        if ($scoreArr[$p]['scoreID'] >= 1 && $scoreArr[$p]['scoreID'] <= 16) {
            $type = $scoreArr[$p]['type'];
            $user = '';
            if ($scoreArr[$p]['for'] == 'user') {
                $user = 'user';
            } else {
                $user = 'spouse';
            }

            $query = "insert into score_calculation (type,scoreID,user,score,user_type) values ('$type','{$scoreArr[$p]['scoreID']}',$id,'{$scoreArr[$p]['score']}','$user')";
            $insert = mysqli_query($conn, $query);
            unset($scoreArr[$p]);
        }
    }

    $grpArrr = [];
    $grpArrr2 = [];

    $minArr = [];
    $minArr2 = [];

    $tArr = [];
    $fscore = 0;
    $p = 0;
    $q = 0;
    $subgroupArr = group_by($scoreArr, 'sub_group');


    // this for score array
    $select = mysqli_query($conn, "select * from sub_groups");
    while ($row = mysqli_fetch_assoc($select)) {
        $type = $row['name'];

        if (array_key_exists($type, $subgroupArr)) {
            $s = array();
            $s['score'] = array_sum($subgroupArr[$type]);
            $s['group'] = $type;
            $s['no'] = substr($type, 1);
            $grpArrr[$p] = $s;
            $p++;
        }
    }
    $n = '';

    for ($i = 1; $i < 11; $i++) {
        $u = 0;
        foreach ($grpArrr as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] > $u) {
                    $u = $k['score'];
                    $tArr[$i] = $k;
                }
            }
        }
        foreach ($grpArrr as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] < $u) {
                    $n .= $k['no'] . ',';
                    $minArr[] = $k;
                }
            }
        }
        foreach ($grpArrr as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] == $u) {
                    $check = search_assoc($k['no'], $minArr);
                    if ($check != '') {
                    } else {
                        $minArr[] = $k;
                    }
                }
            }
        }
    }


    foreach ($minArr as $m) {

        $c = array_count_values(array_column($grpArrr, 'no'))[$m['no']];
        if ($c > 1) {
            foreach ($scoreArr as $k => $v) {
                if ($m['group'] == $v['sub_group']) {
                    unset($scoreArr[$k]);
                }
            }
        }
    }

    //    this is for nocScore Array
    $subgroupArr2 = group_by($nocArr, 'sub_group');

    $select = mysqli_query($conn, "select * from sub_groups");
    while ($row = mysqli_fetch_assoc($select)) {
        $type = $row['name'];

        if (array_key_exists($type, $subgroupArr2)) {
            $ss = array();
            $ss['score'] = array_sum($subgroupArr2[$type]);
            $ss['group'] = $type;
            $ss['no'] = substr($type, 1);
            $grpArrr2[$p] = $ss;
            $p++;
        }
    }
    $n = '';

    for ($i = 1; $i < 11; $i++) {
        $u = 0;
        foreach ($grpArrr2 as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] > $u) {
                    $u = $k['score'];
                    $tArr[$i] = $k;
                }
            }
        }
        foreach ($grpArrr2 as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] < $u) {
                    $n .= $k['no'] . ',';
                    $minArr2[] = $k;
                }
            }
        }
        foreach ($grpArrr2 as $k) {
            if ($k['no'] == $i) {
                if ($k['score'] == $u) {
                    $check = search_assoc($k['no'], $minArr2);
                    if ($check != '') {
                    } else {
                        $minArr2[] = $k;
                    }
                }
            }
        }
    }


    foreach ($minArr2 as $m) {
        $c = array_count_values(array_column($grpArrr2, 'no'))[$m['no']];
        if ($c > 1) {
            foreach ($nocArr as $k => $v) {
                if ($m['group'] == $v['sub_group']) {
                    unset($nocArr[$k]);
                }
            }
        }
    }

    $maxArray = array();
    $groupedArr1 = group_by($scoreArr, 'scoreID');
    $groupedArr2 = group_by($nocArr, 'scoreID');

    foreach ($scoreArr as $k => $v) {
        if ($v['max_score'] != '') {
            $maxArray[$v['scoreID']] = $v['max_score'];
        }
    }

    $select = mysqli_query($conn, "select * from score where scoreID > 16");
    while ($row = mysqli_fetch_assoc($select)) {
        $type = $row['scoreID'];
        $s = 0;
        $score1 = 0;
        $score2 = 0;
        if (array_key_exists($type, $groupedArr1)) {
            $score1 = array_sum($groupedArr1[$type]);
        }
        if (array_key_exists($type, $groupedArr2)) {
            $score2 = array_sum($groupedArr2[$type]);
        }

        $s = $score1 + $score2;


        if ($maxArray[$type] != '' && $maxArray[$type] != 0 && $s > $maxArray[$type]) {
            $s = $maxArray[$type];
        }


        if (($s == '0s' || $s == '0r' || $s == '0w' || $s == '0l') && ($s != '0')) {
            $query = "insert into score_calculation (type,scoreID,user,score,user_type) values ('{$row['type']}','$type',$id,'$s','$user_type')";
            $insert = mysqli_query($conn, $query);
        }
        if ($s != 0 && $s != '0') {
            $query = "insert into score_calculation (type,scoreID,user,score,user_type) values ('{$row['type']}','$type',$id,'$s','$user_type')";
            $insert = mysqli_query($conn, $query);
        }
    }

    for ($i = 0; $i < sizeof($scoreArr2); $i++) {
        $query = "insert into score_calculation (type,scoreID,user,score,user_type) values ('{$scoreArr2[$i]['type']}','{$scoreArr2[$i]['scoreID']}',$id,'{$scoreArr2[$i]['otherCase']}','$user_type')";
        $insert = mysqli_query($conn, $query);
    }

    $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation where user=$id order by id desc");
    $total_score = 0;
    while ($Row = mysqli_fetch_assoc($getQuery)) {
        if (ctype_digit($Row['score']))
            $total_score += $Row['score'];
    }
    //    return $total_score;
}
//------------------------------------------------------------------


//--------------To set the max score instead of score------------------------------------
function max_score()
{
    global $conn, $scoreArray, $nocScore, $spouseScoreArray, $spouseNocScore;

    $cnt = 0;
    $t = 0;
    $sID = 0;
    $max_score = 0;
    $done = 1;
    foreach ($scoreArray as $k => $v) {
        if ($v['max_score'] != '' && $v['max_score'] != 0) {
            $sID = $v['scoreID'];

            $cnt = count(array_filter($scoreArray, function ($element) use ($sID) {
                return $element['scoreID'] == $sID;
            }));
        }
    }
    if ($cnt > 1) {
        foreach ($scoreArray as $k => $v) {
            if ($v['scoreID'] == $sID) {
                for ($i = 0; $i < $cnt; $i++) {
                    $t += $v['score'];
                    $max_score = $v['max_score'];
                }
            }
        }
        if ($t > $max_score) {
            foreach ($scoreArray as $k => $v) {
                if ($v['scoreID'] == $sID) {
                    if ($done < $cnt) {
                        unset($scoreArray[$k]);
                        $done++;
                        continue;
                    }
                    $scoreArray[$k]['score'] = $max_score;
                }
            }
        }
    }

    $cnt = 0;
    $t = 0;
    $sID = 0;
    $max_score = 0;
    $done = 1;
    foreach ($spouseScoreArray as $k => $v) {
        if ($v['max_score'] != '' && $v['max_score'] != 0) {
            $sID = $v['scoreID'];

            $cnt = count(array_filter($scoreArray, function ($element) use ($sID) {
                return $element['scoreID'] == $sID;
            }));
        }
    }
    if ($cnt > 1) {
        foreach ($spouseScoreArray as $k => $v) {
            if ($v['scoreID'] == $sID) {
                for ($i = 0; $i < $cnt; $i++) {
                    $t += $v['score'];
                    $max_score = $v['max_score'];
                }
            }
        }
        if ($t > $max_score) {
            foreach ($spouseScoreArray as $k => $v) {
                if ($v['scoreID'] == $sID) {
                    if ($done < $cnt) {
                        unset($spouseScoreArray[$k]);
                        $done++;
                        continue;
                    }
                    $spouseScoreArray[$k]['score'] = $max_score;
                }
            }
        }
    }
}
//------------------------------------------------------------------


//------------Groups the array scoreID wise-------------------------------------
function group_by($array, $key)
{
    $return = array();
    foreach ($array as $k => $val) {
        $return[$val[$key]][] = $val['score'];
    }
    return $return;
}
//------------------------------------------------------------------


//----------if condition checker--------------------------------------
function check_cond($var1, $op, $var2)
{
    if (strpos($var1, '-') !== false) {
        $vv = explode('-', $var1);
        $var1 = $vv[0];
    }
    if (ctype_digit($var1) && ctype_digit($var2)) {
        $var1 = (float)$var1;
        $var2 = (float)$var2;
    }


    switch ($op) {
        case "=":
            return $var1 == $var2;
        case "!=":
            return $var1 != $var2;
        case ">=":
            return $var1 >= $var2;
        case "<=":
            return $var1 <= $var2;
        case ">":
            return $var1 > $var2;
        case "<":
            return $var1 < $var2;
        case "-":
            $v = explode('-', $var2);
            return $var1 >= $v[0] && $var1 <= $v[1];

        default:
            return true;
    }
}
//------------------------------------------------------------------


//----------if condition checker--------------------------------------
function check_cond2($var1, $op, $var2)
{
    if ($op == '==') {
        $op = '=';
    }
    switch ($op) {
        case "=":
            return $var1 == $var2;
        case "!=":
            return $var1 != $var2;
        case ">=":
            return $var1 >= $var2;
        case "<=":
            return $var1 <= $var2;
        case ">":
            return $var1 > $var2;
        case "<":
            return $var1 < $var2;

        default:
            return true;
    }
}
//------------------------------------------------------------------


//---------------Generate PDF file of the questions/answers of the immigration tool to send in EMAIl----------------------------
function pdf_maker($questions, $answers, $assistance, $name, $email, $form_id)
{
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Etecmania');
    $pdf->SetTitle('PDF Development');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);


    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, 10);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


    $pdf->setFontSubsetting(true);
    $pdf->SetFont('dejavusans', '', 14, '', true);
    $pdf->setJPEGQuality(75);


    // Set some content to print
    $form = '';

    for ($i = 0; $i < sizeof($questions); $i++) {
        if ($answers[$i] != '' && $answers[$i] != 'NaN') {
            if ($questions[$i] == $questions[$i + 1] && (strpos($questions[$i], 'Position') !== false || strpos($questions[$i], 'work-experience') !== false || strpos($questions[$i], 'PLease describe time period') !== false || strpos($questions[$i], 'Please select time period') !==false)) {
                if ($answers[$i + 1] == '' || $answers[$i + 1] == null) {
                    continue;
                }
                if (strtotime($answers[$i + 1])) {
                    // it's in date format
                } else {
                    $answers[$i + 1] = 'Present';
                }
                $answers[$i] = 'From: <b>' . $answers[$i] . '</b> To: <b>' . $answers[$i + 1] . '</b>';

                $form .= '<li>' . $questions[$i] . '<br>' . $answers[$i] . '</li>';
                $i++;
                continue;
            }
            if (strpos($questions[$i], 'Date') !== false || strpos($questions[$i], 'date') !== false || (strpos($questions[$i], 'born') == true && strpos($questions[$i], '(') == false)) {
                $questions[$i + 1] = $questions[$i];
                $i++;
                $form .= '<li>' . $questions[$i] . '<br><b>' . $answers[$i] . '</b></li>';
            } else {
                if(strpos($questions[$i],'show')!==false)
                {
                    $form .= '<li><b>' . $answers[$i] . '</b></li>';

                }
                else
                {
                    $form .= '<li>' . $questions[$i] . '<br><b>' . $answers[$i] . '</b></li>';

                }
            }
        }
    }
    $html = <<<EOD
<ul>
	$form

</ul>
EOD;
    $fname = $email . '_' . date("Y-m-d h:i:sa");

    $pdf->AddPage();
    $pdf->writeHTML($html);

    $pdf->Output($_SERVER['DOCUMENT_ROOT'] . "/pdf_files/" . $fname . '.pdf', 'F');

    sendEmail($questions, $answers, $assistance, $name, $email, $fname, $form_id);
}
//------------------------------------------------------------------


//----------------used to send submission email---------------------------------------
function sendEmail($questions, $answers, $assistance, $name, $email, $fname, $form_id)
{
    global $conn,$currentTheme,$cuurentUser;
    // Recipient
    $to = 'fnsheikh29@gmail.com';
    $to1 = 'maryumakhter1@gmail.com';
    $to2 = 'shahmutbahir@gmail.com';
    $to3 = 'bhatimoiz@gmail.com';
    $to4 = 'info@ourcanada.co';
    $to5 = 'shawna@immigrationcanada.app';


    $subject = $email . ' has submitted the form.';
    $language = ucfirst($_GET['Lang']);
    $account_type='Guest';
    $acc_email='';
    $account_email='';
    if(isset($cuurentUser))
    {
        if(!empty($cuurentUser))
        {
            if($cuurentUser['role'] != "1" && $cuurentUser['role'] != 1)
            {
                $account_type='Signed';
            }
            else
            {
                $account_type='Professional';

            }
            $select=mysqli_query($conn,"Select * from users where id={$_SESSION['user_id']}");
            $row=mysqli_fetch_assoc($select);
            $acc_email='<br>Account Email: '.$row['email'];
            $account_email=$row['email'];
        }
    }
    // Email body content

    $htmlContent = "<html>
		<body>
			<table width='100%' cellspacing='50' cellpadding='50' border='0' bgcolor='#E7E7E7' class='wrapper'>
				<tbody>
					<tr>
						<td>
							<table bgcolor='#ffffff' cellpadding='0' cellspacing='0' align='center' style='border:1px solid #acacac; border-radius:4px; padding:20px 50px 100px; width:632px;'>
								<tr>
									<td>
										<table style='width:100%'>
											<tr style='text-align:center'>
												<td><h1 style='font-weight:normal; color:#2e2e2e; font-size:40px; margin:0px; padding-top:30px; '><img style='width: 200px' src='".$currentTheme."img/ourcanada.png'></h1></td>
											</tr>
											<tr style='text-align:left'>
												<td style='text-align:left'><h1 style='font-weight:normal; color:#2e2e2e; font-size:20px; margin:0px; padding-top:30px; '>Dear Admin!</h1></td>
											</tr>
											<tr>
											<p>Following User has submitted the form.</p>
												<td></td>
											</tr>
											<tr style='text-align:left'>
											   <td>
													<p style='font-size:16px; color:#2e2e2e; line-height:25px; margin:0px; padding-top:20px;'>
														Name: $name<br>
														Email Address: $email<br>
														Language: $language<br>
														Account Type: $account_type
														$acc_email
														<br><br>
														<b>{$GLOBALS['ass_label']}</b><br>
														$assistance<br><br>

														Regards,<br>
														Our Canada Team.
													</p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</body>
	</html>";

    // Sender
    $from = 'support@ourcanada.co';
    $fromName = 'OurCanada';


    // Attachment file
    $file = $_SERVER['DOCUMENT_ROOT'] . "/pdf_files/" . $fname . '.pdf';
    $name = $fname . '.pdf';


    // Header for sender info
    $headers = "From: $fromName" . " <" . $from . ">";

    // Boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // Headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // Multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    // Preparing attachment
    if (!empty($file) > 0) {
        if (is_file($file)) {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen($file, "rb");
            $data = @fread($fp, filesize($file));

            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                "Content-Description: " . basename($file) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename($name) . "\"; size=" . filesize($file) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;


    // Send email

//    $output2 = sendGridemail($to4, $subject, $htmlContent, $file, $fname . ".pdf",$account_type,$account_email);

    $a['n']['email_data'] = json_encode($htmlContent);
    $a['n']['pdf_file'] = $fname . '.pdf';
    $a['language'] = $language;
    $J = db_pair_str2($a['n']);

    $update = mysqli_query($conn, "update user_form set $J where id='$form_id'");
}

function sendGridemail($to, $subject, $message, $file, $filename,$account_type,$account_email)
{
    $to1 = 'maryumakhter1@gmail.com';

    global $sendGridAPIKey,$ext;
    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($to);
    if($account_type=='Professional')
    {
        $emailObj->addCc($account_email);
    }

    $emailObj->addBcc($to1);

    $emailObj->addContent(
        "text/html",
        $message # html:body
    );


    $attachment = $file;
    $content    = file_get_contents($attachment);
    $content    = (base64_encode($content));

    $attachment = new \SendGrid\Mail\Attachment();
    $attachment->setContent($content);
    $attachment->setType("application/pdf");
    $attachment->setFilename($filename);
    $attachment->setDisposition("attachment");
    $emailObj->addAttachment($attachment);




    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);


        //  $response->body();
        return array('sg_status' => json_encode($response->statusCode()), 'sg_heasders' => json_encode($response->headers()));
    } catch (Exception $e) {
        return 'Caught exception: ' . $e->getMessage() . "\n";
    }
}
//------------------------------------------------------------------

//----------used to send automated scripts email------------------------------------
function sendEmail3($body, $to, $cc, $subject, $user_info)
{
    global $currentTheme;

    $htmlContent = "<html>
		<body>
			<table width='100%' cellspacing='50' cellpadding='50' border='0' bgcolor='#E7E7E7' class='wrapper'>
				<tbody>
					<tr>
						<td>
							<table bgcolor='#ffffff' cellpadding='0' cellspacing='0' align='center' style='border:1px solid #acacac; border-radius:4px; padding:20px 50px 100px; width:632px;'>
								<tr>
									<td>
										<table style='width:100%'>
											<tr style='text-align:center'>
												<td><h1 style='font-weight:normal; color:#2e2e2e; font-size:40px; margin:0px; padding-top:30px; '><img style='width: 200px' src='".$currentTheme."img/ourcanada.png'></h1></td>
											</tr>
											
											<tr>
											
												<td><p>
											$body
											</p></td>
											</tr>
											<tr style='text-align:left'>
											   <td>
													<p style='font-size:16px; color:#2e2e2e; line-height:25px; margin:0px; padding-top:20px;'>
														$user_info
														<br><br>

														Thank you.<br>
														Our Canada Services.
													</p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</body>
	</html>";
    $output2 = sendGridemail2($to, $cc, $subject, $htmlContent);
//    $output3 = sendGridemail2('maryumakhter1@gmail.com', 'shahmutbahir@gmail.com', $subject, $htmlContent);
}

function sendGridemail2($to, $cc, $subject, $message)
{
    $to1='maryumakhter1@gmail.com';
    global $sendGridAPIKey,$ext;
    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($to);
    $emailObj->addCc($cc);
    $emailObj->addBcc($to1);

    $emailObj->addContent(
        "text/html",
        $message # html:body
    );



    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);


        //  $response->body();
        return array('sg_status' => json_encode($response->statusCode()), 'sg_heasders' => json_encode($response->headers()));
    } catch (Exception $e) {
        return 'Caught exception: ' . $e->getMessage() . "\n";
    }
}
//------------------------------------------------------------------


//--------------Used to send emails via scoring------------------------------
function sendEmail2($email, $subject, $cc, $msg, $usr)
{
    $cc_m = explode(',', $cc);

    global $sendGridAPIKey,$currentTheme,$ext;




    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$currentTheme.'img/ourcanada.png" height="120" alt=""></th>
                     </tr>
                 </thead>

                 <tbody>
                 
                     <tr>
                         <td style="padding:0 24px 15px;color:#000;letter-spacing: 0.03em;line-height: 25px;">
                              <h3 sty;e="margin-top:!5px"></h3>
                               ' . $usr . '<br>' . $msg . '
                             
                         </td>
                     </tr>
                   
                     
                     <tr>
                         <td style="padding:16px 8px; color: #ffffff; background-color: #E50606; text-align: center;">
                             OurCanada © 2021
                         </td>
                     </tr>
                 </tbody></body>
                                 </html>';



    // sendgrid

    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($email);


    foreach ($cc_m as $c) {
        $c = rtrim(ltrim($c));
        // $mail->AddCC($c,'');
        $emailObj->addCc(new \SendGrid\Mail\Cc($c));
    }


    $emailObj->addContent(
        "text/html",
        $emailBody # html:body
    );

    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);
        // print $response->statusCode() . "\n";
        // print_r($response->headers());
        // print $response->body() . "\n";
    } catch (Exception $e) {
        // echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
}
//------------------------------------------------------------------


//--------------Default mail function-----------------------------------

function defaultMail($email, $subject,$from, $body)
{
    global $sendGridAPIKey,$align_class,$currentTheme,$ext;

    $emailBody = '<html>
                                     <body><table style="box-sizing:border-box;width:100%;border-radius:6px;overflow:hidden;background-color:#ffffff;width: 60%;margin: 0 auto;border: 1px solid #ccc;">
                 <thead>
                     <tr style="background-color: #f7f7f7;">
                         <th scope="col"><img src="'.$currentTheme.'img/ourcanada.png" height="120" alt=""></th>
                     </tr>
                 </thead>

                 <tbody>
                 
                     <tr>
                         <td style="padding:0 24px 15px;color:#000;letter-spacing: 0.03em;line-height: 25px;'.$align_class.'" class="">
                              <h3 sty;e="margin-top:!5px"></h3>
                               ' . $body . '
                             
                         </td>
                     </tr>
                   
                    
                     <tr>
                         <td style="padding:16px 8px; color: #ffffff; background-color: #E50606; text-align: center;">
                            OurCanada © 2021
                         </td>
                         
                     </tr>
                     
                 </tbody></body>
                                 </html>';




//    $headers = "MIME-Version: 1.0" . "\r\n";
//    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//    $headers .= 'From: OurCanada <no-reply@ourcanada.co>';
//    $restMail =  mail($email, $subject, $emailBody, $headers);
//
//    if ($restMail) {
//        return true;
//    } else {
//        return false;
//    }
    // sendgrid

    $emailObj = new \SendGrid\Mail\Mail();
    $emailObj->setFrom("no-reply@ourcanada".$ext, "OurCanada");
    $emailObj->setSubject($subject);
    $emailObj->addTo($email);



    $emailObj->addContent(
        "text/html",
        $emailBody # html:body
    );

    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);

    } catch (Exception $e) {
        // echo 'Caught exception: ' . $e->getMessage() . "\n";
    }
}
//------------------------------------------------------------------

function autoSave($sformId)
{
    global $conn;

    $data['ip_address'] = getIPAddress();
    $data['session_id']=session_id();
    $data['user_id']=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $data['form_html']=$_POST['formHtml'];
//    $data['email']=$_POST['email'];
    $data['email']="N/A";
    $data['updated_date']=date('Y-m-d H:i:s');
    $data['form_id']=$sformId;

//    echo $sformId."<br>";
//    echo $data['email']."<br>";

    $T = db_pair_str2($data);

    if(isset($_SESSION['user_id']))
    {

        $user=mysqli_query($conn,"select * from users where id='{$_SESSION['user_id']}'");
        $user_row=mysqli_fetch_assoc($user);
        if($user_row['role']==1 || $user_row['role']=='1')
        {

            $select=mysqli_query($conn,"select * from auto_save_form where user_id='{$_SESSION['user_id']}' and form_id='$sformId'");
            if(mysqli_num_rows($select)>0)
            {
                $row=mysqli_fetch_assoc($select);
                $insert=mysqli_query($conn,"update auto_save_form set $T where id={$row['id']}");
            }
            else
            {
                $insert=mysqli_query($conn,"insert into auto_save_form set $T");
            }
        }
        else
        {
            $select=mysqli_query($conn,"select * from auto_save_form where user_id='{$_SESSION['user_id']}'");
            if(mysqli_num_rows($select)>0)
            {
                $row=mysqli_fetch_assoc($select);
                $insert=mysqli_query($conn,"update auto_save_form set $T where id={$row['id']}");
            }
            else
            {
                $insert=mysqli_query($conn,"insert into auto_save_form set $T");
            }
        }

    }
}

if($_GET['h']=='autoSave')
{
    $data['ip_address'] = getIPAddress();
    $data['session_id']=session_id();
    $data['user_id']=isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $data['form_html']=$_POST['formHtml'];
    $data['email']=$_POST['email'];
    $data['updated_date']=date('Y-m-d H:i:s');

    $T = db_pair_str2($data);

    $select=mysqli_query($conn,"select * from auto_save_form where session_id='{$data['session_id']}' and ip_address='{$data['ip_address']}'");
    if(mysqli_num_rows($select)>0)
    {
        $row=mysqli_fetch_assoc($select);

        if($row['user_id']==0)
        {
            $insert=mysqli_query($conn,"update auto_save_form set $T where id={$row['id']}");
        }

    }
    else
    {
        $insert=mysqli_query($conn,"insert into auto_save_form set $T");
    }




    if($insert)
    {
        die(json_encode(array('Success' => 'true','Msg' => 'Form is saved ')));
    }
    else
    {
        die(json_encode(array('Success' => 'false','Msg' => 'Something went wrong')));

    }
}


