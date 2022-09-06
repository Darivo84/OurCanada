<?php

$ip_blockedd = checkIPAddress();

if (isset($_SESSION['user_id'])) {
    $ip_blockedd = true;
}


$defaultHTML = '<div class="prompt"></div><div class="prompt2"></div><div class="formDiv">';








$i = 0;
$getQuestions = mysqli_query($conn, "SELECT * FROM questions WHERE form_id = '{$formID}' AND status = 1 and submission_type='before'");
while ($row = mysqli_fetch_assoc($getQuestions)) {
    $permission = '';
    if ($row['permission'] == 1) {
        $permission = 'permitted';
    } else {
        $permission = 'forbidden';
    }
    $row['org_question'] = $row['question'];
    $row['org_notes'] = $row['notes'];
    // Translation Check

    if ($trans !== '') {
        if ($row['question_' . $trans] !== '' && $row['question_' . $trans] !== null) {
            $row['question'] = $row['question_' . $trans];
        }
        if ($row['notes_' . $trans] !== '' && $row['notes_' . $trans] !== null) {
            $row['notes'] = $row['notes_' . $trans];
        }
    }
    $defaultHTML .= '<div class="main_parent_' . $row['id'] . ' parent_question">';
    $defaultHTML .= '<div class="form-group main_question_div" id="question_div_' . $row['id'] . '">';
    $defaultHTML .= '<label class="pb-1" data-org="' . $row['org_question'] . '">' . $row['question'] . '</label>';
    if ($row['notes'] != '' && $fldArr[$row['fieldtype']]['type'] != 'pass') {
        $notes = $row['notes'];
        $defaultHTML .= '<p class="notesPara2" data-org="' . $row['org_notes'] . '">' . $notes . '</p>';
    }
    $defaultHTML .= '<div class="input-group input-group-merge ' . $permission . '">';
    if ($fldArr[$row['fieldtype']]['type'] == 'calender') {
        $defaultHTML .= '<input type="text" class="form-control datepicker" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . '>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'nocjob') {
        $defaultHTML .= '<div class="bs-example"><input type="text" value="" class="' . $row['validation'] . ' tagsInp form-control jobs" data-role="tagsinput" data-type="jobs" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . '></div>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'nocduty') {


        $defaultHTML .= '<div class="bs-example">';
        $defaultHTML .= '<input type="text" value="" class="' . $row['validation'] . ' tagsInp form-control duty" data-role="tagsinput" data-type="duty" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . '>';
        $defaultHTML .= '</div>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'age') {
        $defaultHTML .= '<input type="text" class="form-control datepicker age" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . '>';
        $defaultHTML .= '<input type="text" class="form-control dob" readonly hidden name="dob*' . $row['id'] . '">';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'email') {
        $defaultHTML .= '<input type="email" class="form-control" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . '>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'radio' && $row['labeltype'] == 0) {
        $defaultHTML .= '<input id="Yes_' . $row['id'] . '" type="radio" class="radioButton" name="n[question_' . $row['id'] . ']" bglove onClick="getQuestion(this,\'' . $row['id'] . '\')" ' . $row['validation'] . ' value="Yes"><span class="customLabel">Yes</span>';
        $defaultHTML .= '<input id="No_' . $row['id'] . '" type="radio" class="radioButton" name="n[question_' . $row['id'] . ']" bglove onClick="getQuestion(this,\'' . $row['id'] . '\')" value="No"><span class="customLabel">No</span>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'radio' && $row['labeltype'] == 1) {
        $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row['id']} ");
        while ($row_label = mysqli_fetch_assoc($getLabels)) {
            $defaultHTML .= '<input type="radio" class="radioButton" name="n[question_' . $row['id'] . ']" onClick="getQuestion(this,\'' . $row['id'] . '\')" value="' . $row_label['value'] . '" ' . $row['validation'] . ' >';
            $defaultHTML .= '<span class="customLabel">' . $row_label['label'] . '</span>';
        }
    } else if ($fldArr[$row['fieldtype']]['type'] == 'dropdown') {
        $defaultHTML .= '<select name="n[question_' . $row['id'] . ']" class="form-control" onchange="getQuestion(this,\'' . $row['id'] . '\')" ' . $row['validation'] . '>';
        $defaultHTML .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
        $getLabels = mysqli_query($conn, "select * from question_labels where question_id={$row['id']} and label!='' ");
        while ($row_label = mysqli_fetch_assoc($getLabels)) {
            $defaultHTML .= '<option data-id="' . $row_label['label'] . '" value="' . $row_label['value'] . '">' . $row_label['label'] . '</option>';
        }
        $defaultHTML .= '</select>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'country') {
        $defaultHTML .= '<select name="n[question_' . $row['id'] . ']" class="form-control countryCheck" onchange="getQuestion(this,\'' . $row['id'] . '\')" ' . $row['validation'] . ' >';
        $defaultHTML .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
        $col = '_' . $trans;
        if ($trans == '') {
            $col = '';
        }
        $order='name'.$col;

        $getCountires = mysqli_query($conn, "select * from countries order by $order asc");

        while ($row_label = mysqli_fetch_assoc($getCountires)) {
            $defaultHTML .= '<option data-id="' . 'col-' . $col . '" value="' . $row_label['name'] . '">' . $row_label['name' . $col] . '</option>';
        }
        $defaultHTML .= '</select>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'education') {
        $defaultHTML .= '<select name="n[question_' . $row['id'] . ']" class="education form-control" onchange="getQuestion(this,\'' . $row['id'] . '\')" ' . $row['validation'] . ' >';
        $defaultHTML .= '<option value="" disabled selected class="static_label" data-org="--Select--">--Select--</option>';
        $getCountires = mysqli_query($conn, "select * from education ");
        $col = '_' . $trans;
        if ($trans == 'english') {
            $col = '';
        }
        while ($row_label = mysqli_fetch_assoc($getCountires)) {
            $defaultHTML .= '<option value="' . $row_label['name'] . '">' . $row_label['name' . $col] . '</option>';
        }
        $defaultHTML .= '</select>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'phone') {
        $defaultHTML .= '<input type="tel" minlength="6" maxlength="15" class="form-control" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . ' >';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'pass') {
        $defaultHTML .= '<label class="notesPara2">' . $row['notes'] . '</label>';
    } else if ($fldArr[$row['fieldtype']]['type'] == 'currentrange') {

        $defaultHTML .= '<label class="pb-date static_label" data-org="From">From</label><label class="pb-date static_label" data-org="To">To</label>';
        $defaultHTML .= '<input type="text" data-id="from" class="nocPicker form-control datepicker" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . ' >';
        $defaultHTML .= '<input type="text" data-date="YYYY-MM-DD" data-id="to" class="nocPicker form-control datepicker" onchange="if(checkDate(this)) {getQuestion(this,\'' . $row['id'] . '\') }" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . ' >';
        $defaultHTML .= '<div class="presCheck"><input type="checkbox" class="present_checkbox" onchange=\'if(presentBox(this)==false){return false;}getQuestion3(this,"' . $row['id'] . '")\'><span class="presentCheckbox static_label" data-org="Present">Present</span>';
        $defaultHTML .= '</div>';
    } else {
        $defaultHTML .= '<input type="text" class="form-control" onfocusout="getQuestion(this,\'' . $row['id'] . '\')" name="n[question_' . $row['id'] . ']" ' . $row['validation'] . ' >';
    }
    $defaultHTML .= '</div></div></div>';



    


?>




    <!-- Password -->
<?php $i++;
}

if($btnLoaderShow !== false && $btnLoaderShow !== 'false')
{
 
    $defaultHTML .= '</div><div class="row" id="iAgree"><div class="col-sm-12"><div class="form-group"><a href="'.$currentTheme.'terms'.$langURL.'" target="_blank" class="static_label" data-org="'.$allLabelsEnglishArray[2].'">'.$allLabelsArray[2].'</a><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input custom-checkbox" id="terms"><label class="custom-control-label static_label" for="terms" data-org="'.$allLabelsEnglishArray[3].'">'.$allLabelsArray[3].'</label></div></div></div></div><div class="row terms" id="lastBox"><button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3 terms1 static_label" id="btnLoader" data-org="'.$allLabelsEnglishArray[22].'" >'.$allLabelsArray[22].'</button></div>';
}
else
{
  
    $defaultHTML .= '</div><div class="row" id="iAgree"><div class="col-sm-12"><div class="form-group"><a href="'.$currentTheme.'terms'.$langURL.'" target="_blank" class="static_label" data-org="'.$allLabelsEnglishArray[2].'">'.$allLabelsArray[2].'</a><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input custom-checkbox" id="terms"><label class="custom-control-label static_label" for="terms" data-org="'.$allLabelsEnglishArray[3].'">'.$allLabelsArray[3].'</label></div></div></div></div><div class="row terms" id="lastBox"><button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3 terms1 static_label" id="btnLoader" data-org="'.$allLabelsEnglishArray[22].'" style="display: none">'.$allLabelsArray[22].'</button></div>';
}




?><section class="promo-block ptb-100">

<!--    // this input  is used to detect weather form is loaded from Browser-navigation button (back/forward) or loaded regularly-->
    <input type="text" class="d-none" id="hiddenInputToDetectBackButton" value="0" >


    <div class="container">
        <div class="row">
            <div class="col-sm-3 col-md-2 col-lg-3"></div>
            <div class="col-sm-12 col-md-8 col-lg-6">
                <div class="card login-signup-card shadow-lg mb-0 <?php if ($ip_blockedd == true) { ?>  d-none <?php } ?> ipblockContainer">
                    <div class="card-body px-md-5 py-5">
                        <div class="mb-5">
                            <h5 class="h3"><?php $frmData['name']; ?></h5>
                            <p class="text-muted mb-0 boxError"><i class="fa fa-exclamation-triangle"></i> You don't have access to the system. Please contact us at info@ourcanada.co</p>
                        </div>
                    </div>
                </div>
                <div class="card login-signup-card shadow-lg mb-0 <?php if ($ip_blockedd == false) { ?>  d-none <?php } ?> formContainer">
                    <div class="card-body px-md-5 py-5">
                        <?php



                        if (!isset($_SESSION['user_id'])) {
                        ?>
<!--                            <div class="alert alert-info static_label">You are using the system as a guest user. Your data will be lost if the page reloads. Please login to prevent loss of your data.</div>-->
                        <?php

                        } ?>
                        <div class="mb-5">
                            <h5 class="h3"><?php $frmData['name']; ?></h5>
                            <p class="text-muted mb-0 static_label formHeading formInProcessAlert" data-org="<?php echo '.$allLabelsArray[2].'[17] ?>"><?php echo $allLabelsArray[17] ?></p>
                        </div>
                        <?php
                        // echo $is_sform;
                        if ($is_sform == 'yes' || $is_draft == 'yes') {


                        ?>
                            <form class="login-signup-form quesCreate myForm" autocomplete="off" id="validateform">

                                <?php echo $formHtml; ?>
                            </form>
                        <?php

                        } else {
                        ?>


                            <!--login form-->
                            <form class="login-signup-form quesCreate myForm" autocomplete="off" id="validateform">
                            <?php echo $defaultHTML; ?>
                            </form>

                        <?php } ?>

                        <div id="progressBar" class="meter" style="display: none">
                            <div class="progress">
                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                            </div>
                            <div class="progress_bar_label">
                                <p>Processing</p>
                            </div>

                        </div>

                        <input type="hidden" id="scoreID">
                        <input type="hidden" id="submitCheck">
                        <button class="scroll-edit open static_label" data-toggle="modal" onclick="check_endCase()" data-target="#editModal" style="display: none" data-orgg="<?php echo $allLabelsEnglishArray[35] ?>" title="<?php echo $allLabelsArray[35] ?>"><i class="ti-pencil-alt"></i></button>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<?php if (isset($_SESSION['user_id'])) {  ?>


    <div class="float-div">

        <div class="">

            <div class="row">
                <div class="col-sm-12 text-center">
                    <a class="btn btn-danger saveAsDraftBtn" style="" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1" id="minimize_button"><i class="fa fa-window-maximize" style="margin-right: 7px"></i> <?php echo $allLabelsArray[187] ?> </a>
                </div>
                <div class="col-sm-12 text-center">
                    <div class="collapse multi-collapse" id="multiCollapseExample1">
                        <div class="card card-body">
                            <span class="miniIcon" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1"><i class="fa fa-window-minimize"></i></span>
                            <p class="static_label"><?php echo $allLabelsArray[179] ?></p>
                            <button id="saveAsDraft" type="button" class=" btn btn-sm btn-danger saveAsDraftBtn static_label" style="margin-top: 10px;"><?php echo $allLabelsArray[187] ?></button>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>

    <div class="float-div" id="mDraft">

        <div class="alert alert-warning text-center">

            <div class="row">
                <div class="col-sm-12 text-center">

                    <button id="saveAsDraft" type="button" class=" btn btn-sm btn-danger static_label" style="margin-top: 10px;"><i class="fa fa-save"></i> </button>

                </div>
            </div>

        </div>
    </div>

<?php } ?>