<?php
include_once("admin_inc.php");
$scoreID = mysqli_query($conn, "SELECT * FROM score where scoreID !='' order by id desc limit 1");
$sRow = mysqli_fetch_assoc($scoreID);
$scoreIDD = $sRow['scoreID'] + 1;

$getScores = mysqli_query($conn, "SELECT * FROM score order by id asc");

$country = mysqli_query($conn, "SELECT * FROM countries order by id");


$getAllQuestions = mysqli_query($conn, "SELECT * FROM questions ");
$quesArr = array();
while ($Row = mysqli_fetch_assoc($getAllQuestions)) {
    $quesArr[] = $Row;
}


$getAllSubQuestions = mysqli_query($conn, "SELECT * FROM sub_questions WHERE (casetype = 'subquestion' OR casetype = 'existingcheck' OR casetype = 'multicondition')");

$squesArr = array();
while ($RowS = mysqli_fetch_assoc($getAllSubQuestions)) {
    $squesArr[] = $RowS;
}

$subgroups = mysqli_query($conn, "select * from sub_groups order by id asc");
$scoretype = mysqli_query($conn, "select * from score_type order by id asc");

?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>
    <style>
        .customSelect {
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
            -webkit-transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, -webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out, box-shadow .
        }

        #multiNOCnumber {
            background: #fffdfd;
            padding: 30px 15px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        #multiNOCnumber h3 {
            margin-bottom: 15px;
        }

        .select2-selection__rendered {
            max-width: 355px !important;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
        .select2-container .select2-results__option.optInvisible {
            display: none;
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
                        <div class="page-title-box d-flex align-items-center justify-content-between"
                             style="float: right">


                            <?php if ($_GET['method'] !== 'add' && $_GET['method'] !== 'edit') { ?>
                                <div class="page-title-right">

                                    <a href="?method=add" class="btn btn-primary waves-effect waves-light">Add
                                        Scoring</a>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#groupModal"
                                       class="btn btn-info waves-effect waves-light">Add Sub Group</a>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#scoreModal"
                                       class="btn btn-warning waves-effect waves-light">Add Score Type</a>


                                </div>
                            <?php } else { ?>
                                <a href="javascript:history.go(-1)" class="btn btn-warning waves-effect waves-light">Back
                                    To Listing</a>

                            <?php } ?>
                        </div>
                    </div>
                </div>


                <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Delete Scoring</h5>
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

                                <button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">
                                    Delete
                                </button>
                                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">
                                    Cancel
                                </button>
                            </div>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <div id="scoreModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Score Type</h5>
                            </div>
                            <form id="tvalidateForm">
                                <div class="modal-body">
                                    <div class="prompt"></div>

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" name="n[name]" type="text" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            id="typeLoader">Submit
                                    </button>
                                    <button type="button" class="btn btn-secondary waves-effect closee"
                                            data-dismiss="modal">Cancel
                                    </button>
                                </div>
                            </form>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>


                <div id="groupModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title mt-0" id="myModalLabel">Sub Group</h5>
                            </div>
                            <form id="gvalidateForm">
                                <div class="modal-body">
                                    <div class="prompt"></div>

                                    <div class="form-group">
                                        <label>Name</label>
                                        <input class="form-control" name="n[name]" type="text" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            id="groupLoader">Submit
                                    </button>
                                    <button type="button" class="btn btn-secondary waves-effect closee"
                                            data-dismiss="modal">Cancel
                                    </button>
                                </div>
                            </form>

                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div>

                <!-- /.modal -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <?php

                                if ($_GET['method'] == 'duplicate'){
                                $getID = $_GET['id'];
                                $r = '';
                                $getQuestion = mysqli_query($conn, "SELECT * FROM score WHERE id = '$getID'");
                                $row = mysqli_fetch_assoc($getQuestion);

                                $getType = mysqli_query($conn, "SELECT * FROM score_questions WHERE score_id = '$getID'");
                                $typeRow = mysqli_fetch_assoc($getType);

                                $getConditions = mysqli_query($conn, "SELECT * FROM score_conditions WHERE score_id = {$row['id']}");
                                $getQues = mysqli_query($conn, "SELECT * FROM score_questions WHERE score_id = {$row['id']} and type='or'");
                                $getQues2 = mysqli_query($conn, "SELECT * FROM score_questions WHERE score_id = {$row['id']} and type='and'");
                                $getQues3 = mysqli_query($conn, "SELECT * FROM score_questions WHERE score_id = {$row['id']} and type='grouped'");
                                $getQues4 = mysqli_query($conn, "SELECT * FROM score_questions WHERE score_id = {$row['id']} and type='both' order by id asc");
                                $getQues5 = mysqli_query($conn, "SELECT * FROM score_ontype WHERE score_id = $getID");
                                $row6 = mysqli_fetch_assoc($getQues5);

                                $getQues6 = mysqli_query($conn, "SELECT * FROM score_questions WHERE score_id = {$row['id']} and type='existing'");
                                $row7 = mysqli_fetch_assoc($getQues6);


                                if ($row['noc'] == 1) {
                                    $getNoc = mysqli_query($conn, "SELECT * FROM score_noc WHERE score_id = $getID");
//                                    $nocRow=mysqli_fetch_assoc($getNoc);
                                }

                                if ($row['casetype'] == 'and')
                                {
                                    $rC = mysqli_fetch_assoc($getConditions);
                                }

                                ?>
                                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                                    <script>
                                        function checkAnswer(val, type) {
                                            var existing_qid = $(val).val();
                                            alert(existing_qid)
                                            var trID = $(val).closest('tr').prop('id');
                                            var sCase = $("#" + trID + " .sc").val()
                                            if (sCase == 0) {
                                                if (type == 'm_question' || type == 0) {
                                                    var url = "ajax.php?h=getQuestion";
                                                } else {
                                                    var url = "ajax.php?h=getSubQuestion";
                                                }

                                                $("#" + trID + " #loaderAns").html('<span class="spinner-border spinner-border-sm" role="status"></span>');
                                                $.ajax({
                                                    dataType: 'json',
                                                    url: url,
                                                    type: 'POST',
                                                    data: {
                                                        'id': existing_qid
                                                    },
                                                    success: function (data) {
                                                        $("#" + trID + " #loaderAns").html('');
                                                        var fieldHTML = '';

                                                        $("#" + trID + " #existValue select").empty();
                                                        if (data.data.field == 'radio' && data.data.labeltype == 0) {
                                                            $("#" + trID + " #newValue").hide();
                                                            $("#" + trID + " #newValue").children('input').attr('disabled', true);
                                                            $("#" + trID + " #existValue").children('select').attr('disabled', false);


                                                            fieldHTML += '<option value="Yes">Yes</option><option value="No">No</option><option value="None">None</option>';
                                                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                                                            $("#" + trID + " #existValue").show();

                                                        } else if (data.data.field == 'radio' && data.data.labeltype == 1) {
                                                            $("#" + trID + " #newValue").hide();
                                                            $("#" + trID + " #newValue").children('input').attr('disabled', true);
                                                            $("#" + trID + " #existValue").children('select').attr('disabled', false);

                                                            for (var i = 0; i < data.Options.length; i++) {
                                                                if (data.Options[i].value !== '') {
                                                                    fieldHTML += '<option value="' + data.Options[i].value + '">' + data.Options[i].value + '</option>';
                                                                }
                                                            }
                                                            // fieldHTML += '<option value="None">None</option>';
                                                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                                                            $("#" + trID + " #existValue").show();
                                                        } else {
                                                            fieldHTML += '<option value="#NO#">No Value Assigned</option>';
                                                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                                                            $("#" + trID + " #existValue").hide();
                                                            $("#" + trID + " #existValue").children('select').attr('disabled', true);
                                                            $("#" + trID + " #newValue").children('input').attr('disabled', false);


                                                            $("#" + trID + " #newValue").show();
                                                        }
                                                    }
                                                });
                                            } else {
                                                $.ajax({
                                                    dataType: 'json',
                                                    url: 'ajax.php?h=score_label',
                                                    type: 'POST',
                                                    data: {
                                                        'id': existing_qid
                                                    },
                                                    success: function (data) {
                                                        $("#" + trID + " #loaderAns").html('');
                                                        var fieldHTML = '';

                                                        $("#" + trID + " #existValue select").empty();

                                                        if (data.Options.length > 0) {
                                                            $("#" + trID + " #newValue").hide();
                                                            $("#" + trID + " #newValue").children('input').attr('disabled', true);
                                                            $("#" + trID + " #existValue").children('select').attr('disabled', false);

                                                            for (var i = 0; i < data.Options.length; i++) {
                                                                if (data.Options[i].score_number !== '') {
                                                                    fieldHTML += '<option value="' + data.Options[i].score_number + '">' + data.Options[i].score_number + '</option>';
                                                                }
                                                            }
                                                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                                                            $("#" + trID + " #existValue").show();
                                                        } else {
                                                            $("#" + trID + " #existValue").hide();
                                                            $("#" + trID + " #existValue").children('select').attr('disabled', true);
                                                            $("#" + trID + " #newValue").children('input').attr('disabled', false);
                                                            $("#" + trID + " #newValue").show();
                                                        }
                                                    }
                                                });

                                            }
                                        }

                                    </script>
                                    <form method="post" id="EvalidateForm">
                                        <div class="prompt"></div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="title">Score ID</label>

                                                <div class="input-group mb-3">
                                                    <input type="number" id="scoreID" name="n[scoreID]"
                                                           class="form-control" readonly
                                                           value="<?php echo $row['scoreID'] ?>">
                                                    <div class="input-group-append">
                                                        <span class="btn btn-success" id="basic-addon2"
                                                              onclick="$('#scoreID').removeAttr('readonly')"><i
                                                                    class="fa fa-edit"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Brackets Flag</label>
                                                    <select class="form-control" name="n[flags]">
                                                        <option value="" disabled selected>-- Select --</option>
                                                        <option value="0" <?php if ($row['flags'] == 0) { echo 'selected'; } ?>>OR in brackets</option>
                                                        <option value="1" <?php if ($row['flags'] == 1) { echo 'selected'; } ?>>AND in brackets</option>
                                                        <option value="2" <?php if ($row['flags'] == 2) { echo 'selected'; } ?>>Custom</option>

                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Score Type</label>
                                                    <select class="form-control" name="n[type]" id="">
                                                        <option value="" disabled selected>-- Select --</option>
                                                        <?php
                                                        while ($tr = mysqli_fetch_assoc($scoretype)) {
                                                            ?>
                                                            <option value="<?php echo $tr['name'] ?>" <?php if ($row['type'] == $tr['name']) {
                                                                echo 'selected';
                                                            } ?>><?php echo strtoupper($tr['name']) ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Page Number</label>
                                                    <input type="text" name="n[page]" class="form-control"
                                                           value="<?php echo $row['page'] ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Subgroup</label>
                                                    <select class="form-control" name="n[sub_group]" id="">
                                                        <option value="" disabled selected>-- Select --</option>
                                                        <?php
                                                        while ($gr = mysqli_fetch_assoc($subgroups)) {
                                                            ?>
                                                            <option value="<?php echo $gr['id'] ?>"<?php if ($row['sub_group'] == $gr['id']) {
                                                                echo 'selected';
                                                            } ?> ><?php echo strtoupper($gr['name']) ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Language</label>
                                                    <select class="form-control" name="n[language]">
                                                        <option value="" disabled selected>-- Select --</option>
                                                        <option value="first" <?php if ($row['language'] == 'first') {
                                                            echo 'selected';
                                                        } ?>>First
                                                        </option>
                                                        <option value="second" <?php if ($row['language'] == 'second') {
                                                            echo 'selected';
                                                        } ?>>Second
                                                        </option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Conditions</label>
                                                    <select class="form-control" name="n[casetype]" id="casetype"
                                                            onchange="changeOption()">
                                                        <option value="" disabled selected>-- Select --</option>
                                                        <option value="or" <?php if ($typeRow['type'] == 'or') {
                                                            echo 'selected';
                                                        } ?>>OR Condition
                                                        </option>
                                                        <option value="and" <?php if ($typeRow['type'] == 'and') {
                                                            echo 'selected';
                                                        } ?> >AND Condition
                                                        </option>
                                                        <option value="grouped" <?php if ($typeRow['type'] == 'grouped') {
                                                            echo 'selected';
                                                        } ?> >Group Condition
                                                        </option>
                                                        <option value="both" <?php if ($typeRow['type'] == 'both') {
                                                            echo 'selected';
                                                        } ?> >AND - OR Condition
                                                        </option>
                                                        <option value="scoreType" <?php if ($row['casetype'] == 'scoreType') {
                                                            echo 'selected';
                                                        } ?> >Score Type Condition
                                                        </option>
                                                        <option value="existing" <?php if ($row['casetype'] == 'existing') {
                                                            echo 'selected';
                                                        } ?> >Move to Question
                                                        </option>


                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">NOC/Skill</label>
                                                    <br>

                                                    <div class="custom-control custom-radio" style="display: inline">
                                                        <input type="radio" class="custom-control-input noc" id="noc1"
                                                               name="n[noc]" value="0" <?php if ($row['noc'] == 0) {
                                                            echo 'checked';
                                                        } ?>>
                                                        <label class="custom-control-label" for="noc1">No</label>
                                                    </div>
                                                    <div class="custom-control custom-radio" style="display: inline">
                                                        <input type="radio" class="custom-control-input noc" id="noc2"
                                                               name="n[noc]" value="1" <?php if ($row['noc'] == 1) {
                                                            echo 'checked';
                                                        } ?>>
                                                        <label class="custom-control-label" for="noc2">Yes</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="nocDiv" <?php if ($row['noc'] == 0) { ?> style="display: none;" <?php } ?> >

                                            <div class="table-responsive">
                                                <table class="table table-bordered dt-responsive">
                                                    <thead>
                                                    <tr>

                                                        <th style="min-width: 137px;">NOC Type</th>
                                                        <th>Job Offer</th>
                                                        <th>Current Employment</th>
                                                        <th>Same NOC</th>
                                                        <th style="width: 5%">NOC Operator</th>

                                                        <th style="min-width: 500px;">NOC Number</th>
                                                        <th style="min-width: 137px;">Skill</th>
                                                        <th style="width: 7%;">Operator</th>
                                                        <th style="min-width: 120px;">Value</th>
                                                        <th style="width: 5%">Country Operator</th>
                                                        <th style="min-width: 137px;">Country</th>
                                                        <th style="width: 5%">Province Operator</th>

                                                        <th style="min-width: 137px;">Province</th>
                                                        <th style="min-width: 137px;">Region</th>
                                                        <th>Wage Operator</th>
                                                        <th style="min-width: 120px;">Wage</th>
                                                        <th>Hours Operator</th>
                                                        <th style="min-width: 120px;">Hours</th>
                                                        <th style="min-width: 137px;">Authorization</th>
                                                        <th>Previous Years</th>

                                                        <th style="min-width: 137px;">User Type</th>
                                                        <th style="min-width: 120px;">Score</th>
                                                        <th style="min-width: 137px;">Condition</th>
                                                        <th style="width: 5%;">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="appendNoc">
                                                    <?php
                                                    $i = 0;
                                                    while ($nocRow = mysqli_fetch_assoc($getNoc)) {
                                                        $i++;

                                                        ?>
                                                        <tr id="nocRow<?php echo $i ?>>" class="nocRow">

                                                            <td>
                                                                <select name="noc[noc_type][]" class="form-control"
                                                                        required>
                                                                    <option value='' selected disabled>-- Select --
                                                                    </option>
                                                                    <option value="user" <?php if ($nocRow['noc_type'] == 'user') echo 'selected'; ?>>
                                                                        User
                                                                    </option>
                                                                    <option value="spouse" <?php if ($nocRow['noc_type'] == 'spouse') echo 'selected'; ?>>
                                                                        Spouse
                                                                    </option>
                                                                    <option value="both" <?php if ($nocRow['noc_type'] == 'both') echo 'selected'; ?>>
                                                                        Both
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="jobCheck" name="jobCheck[]" value="<?php echo $nocRow['job_offer'] ?>">
                                                                <input class="" type="checkbox" value="1"
                                                                       name="noc[job_offer][]" <?php if ($nocRow['job_offer'] == '1') echo 'checked'; ?> onchange="other_check(this,'job')">

                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="empCheck" name="empCheck[]" value="<?php echo $nocRow['employment'] ?>">
                                                                <input class="" type="checkbox" value="1"
                                                                       name="noc[employment][]" <?php if ($nocRow['employment'] == '1') echo 'checked'; ?> onchange="other_check(this,'emp')">

                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="sameCheck" name="sameCheck[]" value="<?php echo $nocRow['same'] ?>">
                                                                <input class="" type="checkbox" value="1" onchange="other_check(this,'same')" name="noc[same][]" <?php if ($nocRow['same'] == '1') echo 'checked'; ?>>

                                                            </td>
                                                            <td>
                                                                <select name="noc[noc_operator][]"
                                                                        class="form-control" required>
                                                                    <option value="=" <?php if ($nocRow['noc_operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($nocRow['noc_operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input class="form-control" name="noc[noc_number][]"
                                                                       value="<?php echo $nocRow['noc_number'] ?>">
                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="skillCheck" name="skillCheck[]" value="<?php echo $nocRow['skill'] ?>">

                                                                <select class="form-control " name="noc[skill][]" id="" onchange="other_check(this,'skill')">
                                                                    <option value="" selected disabled>--Select--</option>
                                                                    <option value="low" <?php if ($nocRow['skill'] == 'low') {
                                                                        echo 'selected';
                                                                    } ?>>Low
                                                                    </option>
                                                                    <option value="high" <?php if ($nocRow['skill'] == 'high') {
                                                                        echo 'selected';
                                                                    } ?>>High
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="noc[operator][]" class="form-control"
                                                                        required>
                                                                    <option value="=" <?php if ($nocRow['operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($nocRow['operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                    <option value="<" <?php if ($nocRow['operator'] == '<') echo 'selected'; ?>>
                                                                        &lt;
                                                                    </option>
                                                                    <option value=">" <?php if ($nocRow['operator'] == '>') echo 'selected'; ?>>
                                                                        &gt;
                                                                    </option>
                                                                    <option value="<=" <?php if ($nocRow['operator'] == '<=') echo 'selected'; ?>>
                                                                        &lt;=
                                                                    </option>
                                                                    <option value=">=" <?php if ($nocRow['operator'] == '>=') echo 'selected'; ?>>
                                                                        &gt;=
                                                                    </option>
                                                                    <option value="-" <?php if ($nocRow['operator'] == '-') echo 'selected'; ?>>
                                                                        -
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="noc[value][]"
                                                                       class="form-control"
                                                                       value="<?php echo $nocRow['value'] ?>">
                                                            </td>
                                                            <td>
                                                                <select name="noc[country_operator][]"
                                                                        class="form-control" required>
                                                                    <option value="=" <?php if ($nocRow['country_operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($nocRow['country_operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="hidden" class="countryCheck" name="countryCheck[]" value="<?php echo $nocRow['country'] ?>">
                                                                <select name="noc[country][]" onchange="other_check(this,'country')"
                                                                        class="form-control selectBox">
                                                                    <option value="" selected disabled>--Select--
                                                                    </option>
                                                                    <?php foreach ($country as $kV => $Vv) { ?>
                                                                        <option value="<?php echo $Vv['name'] ?>" <?php if ($nocRow['country'] == $Vv['name']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $Vv['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="noc[province_operator][]"
                                                                        class="form-control" required>
                                                                    <option value="=" <?php if ($nocRow['province_operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($nocRow['province_operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <?php $prov=explode(',',$nocRow['province']) ?>
                                                                <select class="form-control valid mult nocSelect" multiple
                                                                        name="noc[province][<?php echo $i ?>][]">
                                                                    <option value="" selected></option>
                                                                    <option value="Alberta " <?php if (array_search('Alberta ',$prov) > -1)  echo 'selected'; ?>>
                                                                        Alberta
                                                                    </option>
                                                                    <option value="British Columbia " <?php if (array_search('British Columbia ',$prov) > -1) echo 'selected'; ?>>
                                                                        British Columbia
                                                                    </option>
                                                                    <option value="Manitoba " <?php if (array_search('Manitoba ',$prov) > -1) echo 'selected'; ?>>
                                                                        Manitoba
                                                                    </option>
                                                                    <option value="New Brunswick " <?php if (array_search('New Brunswick ',$prov) > -1) echo 'selected'; ?>>
                                                                        New Brunswick
                                                                    </option>
                                                                    <option value="Newfoundland and Labrador " <?php if (array_search('Newfoundland and Labrador ',$prov) > -1) echo 'selected'; ?>>
                                                                        Newfoundland and Labrador
                                                                    </option>
                                                                    <option value="Northwest Territories" <?php if (array_search('Northwest Territories',$prov) > -1) echo 'selected'; ?>>
                                                                        Northwest Territories
                                                                    </option>
                                                                    <option value="Nova Scotia " <?php if (array_search('Nova Scotia ',$prov) > -1) echo 'selected'; ?>>
                                                                        Nova Scotia
                                                                    </option>
                                                                    <option value="Nunavut " <?php if (array_search('Nunavut ',$prov) > -1) echo 'selected'; ?>>
                                                                        Nunavut
                                                                    </option>
                                                                    <option value="Ontario " <?php if (array_search('Ontario ',$prov) > -1) echo 'selected'; ?>>
                                                                        Ontario
                                                                    </option>
                                                                    <option value="Prince Edward Island" <?php if (array_search('Prince Edward Island',$prov) > -1) echo 'selected'; ?>>
                                                                        Prince Edward Island
                                                                    </option>
                                                                    <option value="Quebec " <?php if (array_search('Quebec ',$prov) > -1) echo 'selected'; ?>>
                                                                        Quebec
                                                                    </option>
                                                                    <option value="Saskatchewan " <?php if (array_search('Saskatchewan ',$prov) > -1) echo 'selected'; ?>>
                                                                        Saskatchewan
                                                                    </option>
                                                                    <option value="Yukon " <?php if (array_search('Yukon ',$prov) > -1) echo 'selected'; ?>>
                                                                        Yukon
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <?php $v=explode(',',$nocRow['region']) ?>

                                                                <select class="form-control mult nocSelect" data-live-search="true"  multiple name="noc[region][<?php  echo $i ?>][]">
                                                                    <option value="" selected></option>

                                                                    <option <?php if (array_search('Alberni-Clayoquot',$v) > -1) echo 'selected'; ?> value="Alberni-Clayoquot">
                                                                        Alberni-Clayoquot (on Vancouver Island, includes Hot
                                                                        Springs Cove, Tofino, Ucluelet)
                                                                    </option>
                                                                    <option value="Bulkley-Nechako" <?php if (array_search('Bulkley-Nechak',$v) > -1) echo 'selected'; ?>>
                                                                        Bulkley-Nechako (includes Fort Fraser, Kuldo, Manson
                                                                        Creek, Smithers, Vanderhoof)
                                                                    </option>
                                                                    <option value="Capital" <?php if (array_search('Capital',$v) > -1) echo 'selected'; ?>>
                                                                        Capital (includes Port Renfrew, Saanich, Sidney,
                                                                        Sooke, Victoria)
                                                                    </option>
                                                                    <option value="Cariboo" <?php if (array_search('Cariboo',$v) > -1) echo 'selected'; ?>>
                                                                        Cariboo (includes 100 Mile House, Nazko, Quesnel)
                                                                    </option>
                                                                    <option value="Central Coast" <?php if (array_search('Central Coast',$v) > -1) echo 'selected'; ?>>
                                                                        Central Coast (includes Atnarko, Bella Bella, Bella
                                                                        Coola, Dawson’s Landing, Kimsquit, King Island,
                                                                        Namu)
                                                                    </option>
                                                                    <option value="Central Kootenay" <?php if (array_search('Central Kootenay',$v) > -1) echo 'selected'; ?>>
                                                                        Central Kootenay (includes Castlegar, Creston,
                                                                        Poplar Creek, St Leon, Yahk)
                                                                    </option>
                                                                    <option value="Central Okanagan" <?php if (array_search('Central Okanagan',$v) > -1) echo 'selected'; ?>>
                                                                        Central Okanagan (includes Fintry, Kelowna, Lake
                                                                        Country, Peachland)
                                                                    </option>
                                                                    <option value="Columbia-Shuswap" <?php if (array_search('Columbia-Shuswap',$v) > -1) echo 'selected'; ?>>
                                                                        Columbia-Shuswap (includes Golden, Mica Creek,
                                                                        Parson, Revelstoke, Salmon Arm, Trout Lake)
                                                                    </option>
                                                                    <option value="Comox Valley" <?php if (array_search('Comox Valley',$v) > -1) echo 'selected'; ?>>
                                                                        Comox Valley (includes Black Creek, Fanny Bay,
                                                                        Hornby Island)
                                                                    </option>
                                                                    <option value="Cowichan Valley" <?php if (array_search('Cowichan Valley',$v) > -1) echo 'selected'; ?>>
                                                                        Cowichan Valley (includes Clo-Oose, Duncan,
                                                                        Ladysmith, Mill Bay)
                                                                    </option>
                                                                    <option value="East Kootenay" <?php if (array_search('East Kootenay',$v) > -1) echo 'selected'; ?>>
                                                                        East Kootenay (includes Cranbrook, Kimberley, Radium
                                                                        Hot Springs)
                                                                    </option>
                                                                    <option value="Fraser-Fort George" <?php if (array_search('Fraser-Fort George',$v) > -1) echo 'selected'; ?>>
                                                                        Fraser-Fort George (includes Mackenzie, Prince
                                                                        George, Valemount)
                                                                    </option>
                                                                    <option value="Fraser Valley" <?php if (array_search('Fraser Valley',$v) > -1) echo 'selected'; ?>>
                                                                        Fraser Valley (includes Abbotsford, Boston Bar,
                                                                        Chilliwack, Hope)
                                                                    </option>
                                                                    <option value="Greater Vancouver" <?php if (array_search('Greater Vancouver',$v) > -1) echo 'selected'; ?>>
                                                                        Greater Vancouver (Lower Mainland, including
                                                                        Coquitlam, Langley, Lions Bay, North Vancouver,
                                                                        Surrey, White Rock)
                                                                    </option>
                                                                    <option value="Kitimat-Stikine" <?php if (array_search('Kitimat-Stikine',$v) > -1) echo 'selected'; ?>>
                                                                        Kitimat-Stikine (includes Hazelton, Iskut, Nisga’a,
                                                                        Terrace)
                                                                    </option>
                                                                    <option value="Kootenay-Boundary" <?php if (array_search('Kootenay-Boundary',$v) > -1) echo 'selected'; ?>>
                                                                        Kootenay-Boundary (includes Beaverdell, Big White,
                                                                        Fruitvale, Grand Forks, Rock Creek, Rossland, Trail)
                                                                    </option>
                                                                    <option value="Mount Waddington" <?php if (array_search('Mount Waddington',$v) > -1) echo 'selected'; ?>>
                                                                        Mount Waddington (includes northernmost part of
                                                                        Vancouver Island, Gilford Island, Hopetown, Port
                                                                        Hardy, Thompson Sound, Woss)
                                                                    </option>
                                                                    <option value="Nanaimo" <?php if (array_search('Nanaimo',$v) > -1) echo 'selected'; ?>>Nanaimo</option>
                                                                    <option value="North Okanagan" <?php if (array_search('North Okanagan',$v) > -1) echo 'selected'; ?>>
                                                                        North Okanagan (includes Armstrong, Enderby, Shuswap
                                                                        Falls, Vernon)
                                                                    </option>
                                                                    <option value="Northern Rockies" <?php if (array_search('Northern Rockies',$v) > -1) echo 'selected'; ?>>
                                                                        Northern Rockies (includes Fort Nelson, Kahntah,
                                                                        Liard River, Nelson Forks, Prophet River)
                                                                    </option>
                                                                    <option value="Okanagan-Similkameen" <?php if (array_search('Okanagan-Similkameen',$v) > -1) echo 'selected'; ?>>
                                                                        Okanagan-Similkameen (includes Copper Mountain,
                                                                        Osoyoos, Penticton, Princeton, Summerland)
                                                                    </option>
                                                                    <option value="Peace River" <?php if (array_search('Peace River',$v) > -1) echo 'selected'; ?>>
                                                                        Peace River (includes Buckinghorse River Dawson
                                                                        Creek, Fort St John, Fort Ware)
                                                                    </option>
                                                                    <option value="Powell River" <?php if (array_search('Powell River',$v) > -1) echo 'selected'; ?>>Powell River</option>
                                                                    <option value="Skeena-Queen Charlotte" <?php if (array_search('Skeena-Queen Charlotte',$v) > -1) echo 'selected'; ?>>
                                                                        Skeena-Queen Charlotte (includes Georgetown Mills,
                                                                        Graham Island, Haida Gwaii, Hartley Bay, Moresby
                                                                        Island, Pitt Island, Porcher Island)
                                                                    </option>
                                                                    <option value="Squamish-Lillooet" <?php if (array_search('Squamish-Lillooet',$v) > -1) echo 'selected'; ?>>
                                                                        Squamish-Lillooet (includes Gold Bridge, Pavilion,
                                                                        Pemberton, Whistler)
                                                                    </option>
                                                                    <option value="Stikine" <?php if (array_search('Stikine',$v) > -1) echo 'selected'; ?>>
                                                                        Stikine (northwestern BC, close to Alaska)
                                                                    </option>
                                                                    <option value="Strathcona" <?php if (array_search('Strathcona',$v) > -1) echo 'selected'; ?>>
                                                                        Strathcona (includes Campbell River, Gold River,
                                                                        Nootka Island, Roy, Sayward)
                                                                    </option>
                                                                    <option value="Sunshine Coast" <?php if (array_search('Sunshine Coast',$v) > -1) echo 'selected'; ?>>
                                                                        Sunshine Coast (includes Gambier Island, Nelson
                                                                        Island, Secret Cove)
                                                                    </option>
                                                                    <option value="Thompson-Nicola" <?php if (array_search('Thompson-Nicola',$v) > -1) echo 'selected'; ?>>
                                                                        Thompson-Nicola (includes Blue River, Chase,
                                                                        Clinton, Merritt, Kamloops)
                                                                    </option>
                                                                    <option value="Winnipeg" <?php if (array_search('Winnipeg',$v) > -1) echo 'selected'; ?>>
                                                                        Winnipeg
                                                                    </option>
                                                                    <option value="Other location in Manitoba" <?php if (array_search('Other location in Manitoba',$v) > -1) echo 'selected'; ?>>
                                                                        Other location in Manitoba
                                                                    </option>
                                                                    <option value="Timmins or Vernon" <?php if (array_search('Timmins or Vernon',$v) > -1) echo 'selected'; ?>>
                                                                        Timmins or Vernon
                                                                    </option>
                                                                    <option value="Thunder Bay" <?php if (array_search('Thunder Bay',$v) > -1) echo 'selected'; ?>>
                                                                        Thunder Bay
                                                                    </option>
                                                                    <option value="Sudbury" <?php if (array_search('Sudbury',$v) > -1) echo 'selected'; ?>>
                                                                        Sudbury
                                                                    </option>
                                                                    <option value="Sault Ste Marie" <?php if (array_search('Sault Ste Marie',$v) > -1) echo 'selected'; ?>>
                                                                        Sault Ste Marie
                                                                    </option>
                                                                    <option value="North Bay" <?php if (array_search('North Bay',$v) > -1) echo 'selected'; ?>>
                                                                        North Bay
                                                                    </option>
                                                                    <option value="Moose Jaw" <?php if (array_search('Moose Jaw',$v) > -1) echo 'selected'; ?>>
                                                                        Moose Jaw
                                                                    </option>
                                                                    <option value="Claresholm" <?php if (array_search('Claresholm',$v) > -1) echo 'selected'; ?>>
                                                                        Claresholm
                                                                    </option>

                                                                    <option value="Brandon" <?php if (array_search('Brandon',$v) > -1) echo 'selected'; ?>>
                                                                        Brandon
                                                                    </option>
                                                                    <option value="Altona/Rhineland" <?php if (array_search('Altona/Rhineland',$v) > -1) echo 'selected'; ?>>
                                                                        Altona/Rhineland
                                                                    </option>
                                                                </select>


                                                            </td>
                                                            <td>
                                                                <select name="noc[wage_operator][]"
                                                                        class="form-control">
                                                                    <option value="=" <?php if ($nocRow['wage_operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($nocRow['wage_operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                    <option value="<" <?php if ($nocRow['wage_operator'] == '<') echo 'selected'; ?>>
                                                                        &lt;
                                                                    </option>
                                                                    <option value=">" <?php if ($nocRow['wage_operator'] == '>') echo 'selected'; ?>>
                                                                        &gt;
                                                                    </option>
                                                                    <option value="<=" <?php if ($nocRow['wage_operator'] == '<=') echo 'selected'; ?>>
                                                                        &lt;=
                                                                    </option>
                                                                    <option value=">=" <?php if ($nocRow['wage_operator'] == '>=') echo 'selected'; ?>>
                                                                        &gt;=
                                                                    </option>
                                                                    <option value="-" <?php if ($nocRow['wage_operator'] == '-') echo 'selected'; ?>>
                                                                        -
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="noc[wage][]"
                                                                       class="form-control"
                                                                       value="<?php echo $nocRow['wage'] ?>">
                                                            </td>
                                                            <td>
                                                                <select name="noc[hours_operator][]"
                                                                        class="form-control">
                                                                    <option value="=" <?php if ($nocRow['hours_operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($nocRow['hours_operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                    <option value="<" <?php if ($nocRow['hours_operator'] == '<') echo 'selected'; ?>>
                                                                        &lt;
                                                                    </option>
                                                                    <option value=">" <?php if ($nocRow['hours_operator'] == '>') echo 'selected'; ?>>
                                                                        &gt;
                                                                    </option>
                                                                    <option value="<=" <?php if ($nocRow['hours_operator'] == '<=') echo 'selected'; ?>>
                                                                        &lt;=
                                                                    </option>
                                                                    <option value=">=" <?php if ($nocRow['hours_operator'] == '>=') echo 'selected'; ?>>
                                                                        &gt;=
                                                                    </option>
                                                                    <option value="-" <?php if ($nocRow['hours_operator'] == '-') echo 'selected'; ?>>
                                                                        -
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="noc[hours][]"
                                                                       class="form-control"
                                                                       value="<?php echo $nocRow['hours'] ?>">
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $v = explode(',', $nocRow['authorization']);
                                                                ?>
                                                                <select name="noc[authorization][<?php echo $i ?>][]"
                                                                        multiple class="form-control mult nocSelect" data-live-search="true">
                                                                    <option value="" selected></option>
                                                                    <option value="Open work permit" <?php if (array_search('Open work permit', $v) > -1) echo 'selected'; ?>>
                                                                        Open work permit
                                                                    </option>
                                                                    <option value="LMIA based work permit" <?php if (array_search('LMIA based work permit', $v) > -1) echo 'selected'; ?>>
                                                                        LMIA based work permit
                                                                    </option>
                                                                    <option value="Other employer specific work permit" <?php if (array_search('Other employer specific work permit', $v) > -1) echo 'selected'; ?>>
                                                                        Other employer specific work permit
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="noc[previous_years][]"
                                                                       class="form-control" value="<?php echo $nocRow['previous_years'] ?>">
                                                            </td>
                                                            <td>
                                                                <select name="noc[user_type][]" class="form-control"
                                                                        required>
                                                                    <option value='' selected disabled>-- Select --
                                                                    </option>
                                                                    <option value="user" <?php if ($nocRow['user_type'] == 'user') echo 'selected'; ?>>
                                                                        User
                                                                    </option>
                                                                    <option value="spouse" <?php if ($nocRow['user_type'] == 'spouse') echo 'selected'; ?>>
                                                                        Spouse
                                                                    </option>
                                                                    <option value="both" <?php if ($nocRow['user_type'] == 'both') echo 'selected'; ?>>
                                                                        Both
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="noc[score_number][]"
                                                                       class="form-control"
                                                                       value="<?php echo $nocRow['score_number'] ?>">
                                                            </td>
                                                            <td>
                                                                <select class="form-control abc"
                                                                        name="noc[conditionn][]" id="conditionn"
                                                                        onchange="otherCase2(this)">
                                                                    <option value="" disabled selected>--Select--
                                                                    </option>
                                                                    <option value="or" <?php if ($nocRow['conditionn'] == 'or') echo 'selected' ?>>
                                                                        OR
                                                                    </option>
                                                                    <option value="and" <?php if ($nocRow['conditionn'] == 'and') echo 'selected' ?>>
                                                                        AND
                                                                    </option>
                                                                    <option value="question" <?php if ($nocRow['conditionn'] == 'question') echo 'selected' ?>>
                                                                        Move to Question
                                                                    </option>
                                                                    <option value="scoring" <?php if ($nocRow['conditionn'] == 'scoring') echo 'selected' ?>>
                                                                        Move to Scoring
                                                                    </option>

                                                                </select>
                                                            </td>
                                                            <td><a href="javascript:void(0);"
                                                                   class="remove_button btn btn-danger"><i
                                                                            class="fa fa-trash"></i></a></td>

                                                        </tr>
                                                        <?php
                                                        if ($nocRow['conditionn'] == 'question') {
                                                            $ocase = 1;
                                                            $qtype = $nocRow['move_qtype'];
                                                            $qid = $nocRow['move_qid'];
                                                        } else if ($nocRow['conditionn'] == 'scoring') {
                                                            $ocase = 2;
                                                            $stype = $nocRow['move_scoreType'];
                                                        }

                                                    } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="button"
                                                            class="btn btn-info btn-sm <?php if ($ocase == 1 || $ocase == 2) { ?> adis <?php } ?>"
                                                            id="addNoc">Add More
                                                    </button>
                                                </div>

                                                <div class="col-sm-6 moveQues2" <?php if ($ocase != 1) { ?>  style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="move[type]" class="form-control"
                                                                onchange="getQuestion('mQues1','sQues1',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="m_question" <?php if ($qtype == 'm_question') echo 'selected' ?> >
                                                                Main Question
                                                            </option>
                                                            <option value="s_question" <?php if ($qtype == 's_question') echo 'selected' ?>>
                                                                Sub Question
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 moveQues2" <?php if ($ocase != 1) { ?> style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label class="q_lbl" <?php if ($ocase != 1) { ?> style="display: none" <?php } ?>>Question</label>
                                                        <div id="mQues1" <?php if ($qtype != 'm_question') { ?> style="display: none" <?php } ?>>
                                                            <select name="move[qid]" class="form-control selectBox"
                                                                    required id="">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach ($quesArr as $k => $v) {
                                                                    ?>
                                                                    <option value="<?php echo $v['id'] ?>" <?php if ($qid == $v['id']) echo 'selected' ?>><?php echo $v['id'].' - '.$v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues1" <?php if ($qtype != 's_question') { ?> style="display: none" <?php } ?>>
                                                            <select name="move[sid]" class="form-control selectBox"
                                                                    id="" required>
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach ($squesArr as $kV => $Vv) {
                                                                    ?>
                                                                    <option value="<?php echo $Vv['id'] ?>" <?php if ($qid == $Vv['id']) echo 'selected' ?>><?php echo $Vv['id'].' - '.$Vv['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 moveScore2" <?php if ($ocase != 2) { ?> style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label class="">Score ID</label>
                                                        <select name="move[scoreType]" class="form-control selectBox"
                                                                id="" required>
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            foreach ($getScores as $kV => $Vv) {
                                                                ?>
                                                                <option value="<?php echo $Vv['id'] ?>" <?php if ($stype == $Vv['id']) echo 'selected' ?>><?php echo $Vv['scoreID'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>


                                        <div id="scoreType" class="optionsDiv" style="display: none">
                                            <h3>Score Type Condition</h3>
                                            <div id="">
                                                <table class="table table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Score Type</th>
                                                        <th>Operator</th>
                                                        <th>Value</th>
                                                        <th>Score</th>
                                                        <th>User Type</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="appendQuesType6">
                                                    <tr id="trCountttttt" class="trCountttttt">

                                                        <td>
                                                            <select name="t[score_type]" class="form-control selectBox">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php foreach ($scoretype as $k => $v) { ?>
                                                                    <option value="<?php echo $v['name'] ?>"<?php if ($v['name'] == $row6['score_type']) echo 'selected' ?>><?php echo strtoupper($v['name']) ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="t[operator]" class="form-control" required>
                                                                <option value="=" <?php if ($row6['operator'] == '=') echo 'selected'; ?>>
                                                                    =
                                                                </option>
                                                                <option value="!=" <?php if ($row6['operator'] == '!=') echo 'selected'; ?>>
                                                                    !=
                                                                </option>
                                                                <option value="<" <?php if ($row6['operator'] == '<') echo 'selected'; ?>>
                                                                    &lt;
                                                                </option>
                                                                <option value=">" <?php if ($row6['operator'] == '>') echo 'selected'; ?>>
                                                                    &gt;
                                                                </option>
                                                                <option value="<=" <?php if ($row6['operator'] == '<=') echo 'selected'; ?>>
                                                                    &lt;=
                                                                </option>
                                                                <option value=">=" <?php if ($row6['operator'] == '>=') echo 'selected'; ?>>
                                                                    &gt;=
                                                                </option>
                                                                <option value="-" <?php if ($row6['operator'] == '-') echo 'selected'; ?>>
                                                                    -
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="t[value]" class="form-control"
                                                                   value="<?php echo $row6['value'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" name="t[score_number]"
                                                                   class="form-control"
                                                                   value="<?php echo $row6['score_number'] ?>">
                                                        </td>
                                                        <td>
                                                            <select name="t[user_type][]" class="form-control" required>
                                                                <option value='' selected disabled>-- Select --</option>
                                                                <option value="user" <?php if ($row6['user_type'] == 'user') echo 'selected'; ?>>
                                                                    User
                                                                </option>
                                                                <option value="spouse" <?php if ($row6['user_type'] == 'spouse') echo 'selected'; ?>>
                                                                    Spouse
                                                                </option>
                                                                <option value="both" <?php if ($row6['user_type'] == 'both') echo 'selected'; ?>>
                                                                    Both
                                                                </option>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                <!--                                                <div class="row">-->
                                                <!--                                                    <div class="col-sm-12 text-right">-->
                                                <!--                                                        <button type="button" class="btn btn-info btn-sm" id="addMoreQues3">Add More</button>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                            </div>

                                        </div>
                                        <div id="existing" class="optionsDiv">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="e[move_qtype]" class="form-control"
                                                                onchange="question_type3('mQues4','sQues4',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="m_question" <?php if ($row7['move_qtype'] == 'm_question') echo 'selected' ?>>
                                                                Main Question
                                                            </option>
                                                            <option value="s_question" <?php if ($row7['move_qtype'] == 's_question') echo 'selected' ?>>
                                                                Sub Question
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label id="q_lbl">Question</label>
                                                        <div id="mQues4" <?php if ($row7['move_qtype'] != 'm_question') { ?> style="display: none" <?php } ?> >
                                                            <select name="e[existing_qid]"
                                                                    class="form-control selectBox questionEx"
                                                                    data-val="qid" required id="">
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach ($quesArr as $k => $v) {
                                                                    ?>
                                                                    <option value="<?php echo $v['id'] ?>" <?php if ($row7['move_qid'] == $v['id']) echo 'selected' ?>><?php echo $v['question'].' - '.$v['id'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues4" <?php if ($row7['move_qtype'] != 's_question') { ?> style="display: none" <?php } ?>>
                                                            <select name="e[existing_sid]"
                                                                    class="form-control selectBox questionEx"
                                                                    data-val="sid" id="" required>
                                                                <option value="" selected disabled>-- Select --</option>

                                                                <?php
                                                                foreach ($squesArr as $k => $v) {
                                                                    ?>
                                                                    <option value="<?php echo $v['id'] ?>" <?php if ($row7['move_qid'] == $v['id']) echo 'selected' ?>><?php echo $v['question'].' - '.$v['id'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="or" class="optionsDiv">
                                            <h3>OR Condition</h3>
                                            <table class="table table-bordered dt-responsive nowrap">
                                                <thead>
                                                <tr>
                                                    <th>Question Type</th>
                                                    <th style="width: 30%">Question</th>
                                                    <th>User Type</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="appendQuesType2">
                                                <?php
                                                $i = 0;
                                                while ($row2 = mysqli_fetch_assoc($getQues)) {
                                                    $i++;
                                                    ?>
                                                    <tr id="trCountt<?php echo $i ?>" class="trCountt">
                                                        <td>
                                                            <select name="z[question_type][]" class="form-control"
                                                                    onchange="question_type2('mQues','sQues',this)"
                                                                    required>
                                                                <option value="">-- Select Question Type --</option>
                                                                <option value="m_question" <?php if ($row2['question_type'] == 'm_question') {
                                                                    echo 'selected';
                                                                } ?>>Main Question
                                                                </option>
                                                                <option value="s_question" <?php if ($row2['question_type'] == 's_question') {
                                                                    echo 'selected';
                                                                } ?>>Sub Question
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="mQues" <?php if ($row2['question_type'] != 'm_question') { ?> style="display: none" <?php } ?>>
                                                                <select name="z[question_id][]"
                                                                        class="form-control selectBox mQues <?php if ($row2['question_type'] != 'm_question') { ?> adis <?php } ?>"
                                                                        required <?php if ($row2['question_type'] != 'm_question') { ?> disabled <?php } ?>>
                                                                    <option value="" selected disabled>-- Select --
                                                                    </option>
                                                                    <?php foreach ($quesArr as $k => $v) { ?>
                                                                        <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $row2['question_id']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $v['question'] .' - '.$v['id']?> </option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="sQues" <?php if ($row2['question_type'] != 's_question') { ?> style="display: none" <?php } ?>>

                                                                <select name="z[question_id][]"
                                                                        class="form-control selectBox sQues <?php if ($row2['question_type'] != 's_question') { ?> adis <?php } ?>"
                                                                        required <?php if ($row2['question_type'] != 's_question') { ?> disabled <?php } ?>>
                                                                    <option value="" selected disabled>-- Select --
                                                                    </option>
                                                                    <?php foreach ($squesArr as $kV => $Vv) { ?>
                                                                        <option value="<?php echo $Vv['id'] ?>" <?php if ($Vv['id'] == $row2['question_id']) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $Vv['question'] ?>
                                                                            - <?php echo $Vv['id'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <select name="z[user_type][]" class="form-control" required>
                                                                <option value='' selected disabled>-- Select --</option>
                                                                <option value="user" <?php if ($row2['user_type'] == 'user') echo 'selected'; ?>>
                                                                    User
                                                                </option>
                                                                <option value="spouse" <?php if ($row2['user_type'] == 'spouse') echo 'selected'; ?>>
                                                                    Spouse
                                                                </option>
                                                                <option value="both" <?php if ($row2['user_type'] == 'both') echo 'selected'; ?>>
                                                                    Both
                                                                </option>
                                                            </select>
                                                        </td>
                                                        <td><a href="javascript:void(0);"
                                                               class="remove_button btn btn-danger"><i
                                                                        class="fa fa-trash"></i></a></td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="button" class="btn btn-info btn-sm" id="addMoreQues">
                                                        Add More
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="and" class="optionsDiv">
                                            <h3>AND Condition</h3>
                                            <div id="">
                                                <table class="table table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Case</th>
                                                        <th>Question Type</th>
                                                        <th style="width: 30%">Question</th>
                                                        <th>Operator</th>
                                                        <th>Value</th>
                                                        <th>User Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="appendQuesType3">
                                                    <?php
                                                    $i = 0;
                                                    while ($row3 = mysqli_fetch_assoc($getQues2)) {
                                                        $i++;
                                                        ?>


                                                        <tr id="trCounttt<?php echo $i ?>" class="trCounttt">

                                                            <td>
                                                                <select name="x[score_case][]" class="form-control sc">
                                                                    <option value="">-- Select Case --</option>
                                                                    <option value="1" <?php if ($row3['score_case'] == '1') {
                                                                        echo 'selected';
                                                                    } ?>>Label
                                                                    </option>
                                                                    <option value="0" <?php if ($row3['score_case'] == '0') {
                                                                        echo 'selected';
                                                                    } ?>>Value
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="x[question_type][]" class="form-control"
                                                                        onchange="question_type2('mQues','sQues',this)"
                                                                        required>
                                                                    <option value="">-- Select Question Type --</option>
                                                                    <option value="m_question" <?php if ($row3['question_type'] == 'm_question') {
                                                                        echo 'selected';
                                                                    } ?>>Main Question
                                                                    </option>
                                                                    <option value="s_question" <?php if ($row3['question_type'] == 's_question') {
                                                                        echo 'selected';
                                                                    } ?>>Sub Question
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="mQues" <?php if ($row3['question_type'] != 'm_question') { ?> style="display: none" <?php } ?>
                                                                     onChange="checkAnswer(this,'m_question')">
                                                                    <select name="x[question_id][]"
                                                                            class="form-control selectBox mQues <?php if ($row3['question_type'] != 'm_question') { ?> adis <?php } ?>"
                                                                            required <?php if ($row3['question_type'] != 'm_question') { ?> disabled <?php } ?>>
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($quesArr as $k => $v) { ?>
                                                                            <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $row3['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $v['question'].' - '.$v['id'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="sQues" <?php if ($row3['question_type'] != 's_question') { ?> style="display: none" <?php } ?>>

                                                                    <select name="x[question_id][]"
                                                                            class="form-control selectBox sQues <?php if ($row3['question_type'] != 's_question') { ?> adis <?php } ?>"
                                                                            required <?php if ($row3['question_type'] != 's_question') { ?> disabled <?php } ?>
                                                                            onChange="checkAnswer(this,'s_question')">
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($squesArr as $kV => $Vv) { ?>
                                                                            <option value="<?php echo $Vv['id'] ?>" <?php if ($Vv['id'] == $row3['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $Vv['question'] ?>
                                                                                - <?php echo $Vv['id'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="x[operator][]" class="form-control"
                                                                        required>
                                                                    <option value="=" <?php if ($row3['operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($row3['operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                    <option value="<" <?php if ($row3['operator'] == '<') echo 'selected'; ?>>
                                                                        &lt;
                                                                    </option>
                                                                    <option value=">" <?php if ($row3['operator'] == '>') echo 'selected'; ?>>
                                                                        &gt;
                                                                    </option>
                                                                    <option value="<=" <?php if ($row3['operator'] == '<=') echo 'selected'; ?>>
                                                                        &lt;=
                                                                    </option>
                                                                    <option value=">=" <?php if ($row3['operator'] == '>=') echo 'selected'; ?>>
                                                                        &gt;=
                                                                    </option>
                                                                    <option value="-" <?php if ($row3['operator'] == '-') echo 'selected'; ?>>
                                                                        -
                                                                    </option>
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                if ($row3['score_case'] == 0) {
                                                                    if ($row3['question_type'] == 'm_question') {
                                                                        $s = mysqli_query($conn, "select * from questions where id={$row3['question_id']}");
                                                                        $r = mysqli_fetch_assoc($s);
                                                                        if (($r['fieldtype'] == 7) || ($r['fieldtype'] == 1 && $r['labeltype'] == 1)) {
                                                                            ?>
                                                                            <select name="x[value][]"
                                                                                    class="form-control existingValues">
                                                                                <?php
                                                                                $g = mysqli_query($conn, "select * from question_labels where question_id={$row3['question_id']}");
                                                                                while ($gr = mysqli_fetch_assoc($g)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $gr['value'] ?>"<?php if ($gr['value'] == $row3['value']) echo 'selected'; ?>><?php echo $gr['label'] ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        } else if ($r['fieldtype'] == 1 && $r['labeltype'] == 0) {
                                                                            ?>
                                                                            <select name="x[value][]"
                                                                                    class="form-control existingValues">
                                                                                <option value="No" <?php if ($row3['value'] == 'No') echo 'selected'; ?>>
                                                                                    No
                                                                                </option>
                                                                                <option value="Yes" <?php if ($row3['value'] == 'Yes') echo 'selected'; ?>>
                                                                                    Yes
                                                                                </option>
                                                                            </select>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text" name="x[value][]"
                                                                                   class="form-control existingValues"
                                                                                   value="<?php echo $row3['value'] ?>">

                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        $s = mysqli_query($conn, "select * from sub_questions where id={$row3['question_id']}");
                                                                        $r = mysqli_fetch_assoc($s);
                                                                        if (($r['fieldtype'] == 7) || ($r['fieldtype'] == 1 && $r['labeltype'] == 1)) {
                                                                            ?>
                                                                            <select name="x[value][]"
                                                                                    class="form-control existingValues">
                                                                                <?php
                                                                                $g = mysqli_query($conn, "select * from level1 where question_id={$row3['question_id']}");
                                                                                while ($gr = mysqli_fetch_assoc($g)) {
                                                                                    echo $gr['question_id'];

                                                                                    ?>
                                                                                    <option value="<?php echo $gr['value'] ?>"<?php if ($gr['value'] == $row3['value']) echo 'selected'; ?>><?php echo $gr['label'] ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        } else if ($r['fieldtype'] == 1 && $r['labeltype'] == 0) {
                                                                            ?>
                                                                            <select name="x[value][]"
                                                                                    class="form-control existingValues">
                                                                                <option value="No" <?php if ($row3['value'] == 'No') echo 'selected'; ?>>
                                                                                    No
                                                                                </option>
                                                                                <option value="Yes" <?php if ($row3['value'] == 'Yes') echo 'selected'; ?>>
                                                                                    Yes
                                                                                </option>
                                                                            </select>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text" name="x[value][]"
                                                                                   class="form-control existingValues"
                                                                                   value="<?php echo $row3['value'] ?>">

                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                else
                                                                {

                                                                ?>
                                                                <select name="x[value][]"
                                                                        class="form-control  existingValues">

                                                                    <?php


                                                                    }
                                                                    ?>
                                                                    <div id="newValue" style="display: none">
                                                                        <input type="text" name="x[value][]"
                                                                               class="form-control adis">
                                                                    </div>
                                                                    <div id="rexistValue" class="exValue" style="display: none">

                                                                        <select name="x[value][]"
                                                                                class="form-control adis" disabled>

                                                                        </select>
                                                                    </div>
                                                            </td>
                                                            <td>
                                                                <select name="x[user_type][]" class="form-control"
                                                                        required>
                                                                    <option value='' selected disabled>-- Select --
                                                                    </option>
                                                                    <option value="user" <?php if ($row3['user_type'] == 'user') echo 'selected'; ?>>
                                                                        User
                                                                    </option>
                                                                    <option value="spouse" <?php if ($row3['user_type'] == 'spouse') echo 'selected'; ?>>
                                                                        Spouse
                                                                    </option>
                                                                    <option value="both" <?php if ($row3['user_type'] == 'both') echo 'selected'; ?>>
                                                                        Both
                                                                    </option>
                                                                </select>
                                                            </td>

                                                            <td><a href="javascript:void(0);"
                                                                   class="remove_button btn btn-danger"><i
                                                                            class="fa fa-trash"></i></a></td>
                                                        </tr>

                                                        <?php
                                                    } ?>
                                                    </tbody>
                                                </table>

                                                <div class="row">
                                                    <div class="col-sm-12 text-right">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                                id="addMoreQues3">Add More
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Score</label>
                                                        <input class="form-control" name="c[score_number]"
                                                               value="<?php echo $rC['score_number'] ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="grouped" class="optionsDiv">
                                            <h3>Condition with Questions Group</h3>
                                            <div class="table-responsive">
                                                <table class="table table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Case</th>
                                                        <th>Question Type</th>
                                                        <th style="width: 30%">Question</th>
                                                        <th>Operator</th>
                                                        <th style="min-width: 150px">Value</th>
                                                        <th>User Type</th>
                                                        <th>Option</th>
                                                        <th>Score/Condition</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="appendQuesType4">
                                                    <?php
                                                    $i = 0;
                                                    while ($row4 = mysqli_fetch_assoc($getQues3)) {
                                                        $i++;
                                                        ?>
                                                        <tr id="trCountttt<?php echo $i ?>" class="trCountttt">

                                                            <td>
                                                                <select name="y[score_case][]" class="form-control sc">
                                                                    <option value="">-- Select Case --</option>
                                                                    <option value="1" <?php if ($row4['score_case'] == '1') {
                                                                        echo 'selected';
                                                                    } ?>>Label
                                                                    </option>
                                                                    <option value="0" <?php if ($row4['score_case'] == '0') {
                                                                        echo 'selected';
                                                                    } ?>>Value
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="y[question_type][]" class="form-control ques <?php if ($row4['score_case'] == '1') echo 'adis' ?>"
                                                                        onchange="question_type2('mQues','sQues',this)"

                                                                >
                                                                    <option value="">-- Select Question Type --</option>
                                                                    <option value="m_question" <?php if ($row4['question_type'] == 'm_question') {
                                                                        echo 'selected';
                                                                    } ?>>Main Question
                                                                    </option>
                                                                    <option value="s_question" <?php if ($row4['question_type'] == 's_question') {
                                                                        echo 'selected';
                                                                    } ?>>Sub Question
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="y[tests][]"
                                                                        class="form-control tests <?php if ($row4['score_case'] == 0) { ?> adis <?php } ?>" <?php if ($row4['score_case'] == 0) { ?> style="display: none" <?php } ?>>
                                                                    <option value="">--Select Test--</option>
                                                                    <option value="celpip" <?php if ($row4['tests'] == 'celpip') {
                                                                        echo 'selected';
                                                                    } ?>>CELPIP
                                                                    </option>
                                                                    <option value="ielts" <?php if ($row['tests'] == 'ielts') {
                                                                        echo 'selected';
                                                                    } ?>>IELTS
                                                                    </option>
                                                                    <option value="tcf" <?php if ($row4['tests'] == 'tcf') {
                                                                        echo 'selected';
                                                                    } ?>>TCF
                                                                    </option>
                                                                    <option value="tef" <?php if ($row4['tests'] == 'tef') {
                                                                        echo 'selected';
                                                                    } ?>>TEF
                                                                    </option>

                                                                </select>
                                                                <div class="mQues no_tests" <?php if ($row4['question_type'] != 'm_question') { ?> style="display: none" <?php } ?>>
                                                                    <select name="y[question_id][]"
                                                                            class="form-control selectBox mQues <?php if ($row4['question_type'] != 'm_question') { ?> adis <?php } ?>"
                                                                            onchange="checkAnswer(this,'m_question')"
                                                                            required <?php if ($row4['question_type'] != 'm_question') { ?> disabled <?php } ?>>
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($quesArr as $k => $v) { ?>
                                                                            <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $row4['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $v['question'].' - '.$v['id'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="sQues no_tests" <?php if ($row4['question_type'] != 's_question') { ?> style="display: none" <?php } ?>>

                                                                    <select name="y[question_id][]"
                                                                            class="form-control selectBox sQues <?php if ($row4['question_type'] != 's_question') { ?> adis <?php } ?>"
                                                                            onchange="checkAnswer(this,'s_question')"
                                                                            required <?php if ($row4['question_type'] != 's_question') { ?> disabled <?php } ?>>
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($squesArr as $kV => $Vv) { ?>
                                                                            <option value="<?php echo $Vv['id'] ?>" <?php if ($Vv['id'] == $row4['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $Vv['question'] ?>
                                                                                - <?php echo $Vv['id'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="y[operator][]" class="form-control"
                                                                        required>
                                                                    <option value="=" <?php if ($row4['operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($row4['operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                    <option value="<" <?php if ($row4['operator'] == '<') echo 'selected'; ?>>
                                                                        &lt;
                                                                    </option>
                                                                    <option value=">" <?php if ($row4['operator'] == '>') echo 'selected'; ?>>
                                                                        &gt;
                                                                    </option>
                                                                    <option value="<=" <?php if ($row4['operator'] == '<=') echo 'selected'; ?>>
                                                                        &lt;=
                                                                    </option>
                                                                    <option value=">=" <?php if ($row4['operator'] == '>=') echo 'selected'; ?>>
                                                                        &gt;=
                                                                    </option>
                                                                    <option value="-" <?php if ($row4['operator'] == '-') echo 'selected'; ?>>
                                                                        -
                                                                    </option>
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                if ($row4['score_case'] == 0) {
                                                                    if ($row4['question_type'] == 'm_question') {
                                                                        $s = mysqli_query($conn, "select * from questions where id={$row4['question_id']}");
                                                                        $r = mysqli_fetch_assoc($s);
                                                                        $v = explode('*', $row4['value']);

                                                                        if (($r['fieldtype'] == 7) || ($r['fieldtype'] == 1 && $r['labeltype'] == 1)) {
                                                                            ?>
                                                                            <select name="y[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues mult" multiple>
                                                                                <?php
                                                                                $g = mysqli_query($conn, "select * from question_labels where question_id={$row4['question_id']}");
                                                                                while ($gr = mysqli_fetch_assoc($g)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $gr['value'] ?>"<?php if (array_search($gr['value'], $v) > -1) echo 'selected'; ?>><?php echo $gr['label'] ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        } else if ($r['fieldtype'] == 1 && $r['labeltype'] == 0) {
                                                                            ?>
                                                                            <select name="y[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues">
                                                                                <option value="No" <?php if (substr($row4['value'], 0, -1) == 'No') echo 'selected'; ?>>
                                                                                    No
                                                                                </option>
                                                                                <option value="Yes" <?php if (substr($row4['value'], 0, -1) == 'Yes') echo 'selected'; ?>>
                                                                                    Yes
                                                                                </option>
                                                                            </select>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text" name="y[value][<?php echo $i ?>][]"
                                                                                   class="form-control existingValues"
                                                                                   value="<?php echo  substr($row4['value'], 0, -1) ?>">

                                                                            <?php
                                                                        }
                                                                    }
                                                                    else {
                                                                        $s = mysqli_query($conn, "select * from sub_questions where id={$row4['question_id']}");
                                                                        $r = mysqli_fetch_assoc($s);
                                                                        $v = explode('*', $row4['value']);

                                                                        if (($r['fieldtype'] == 7) || ($r['fieldtype'] == 1 && $r['labeltype'] == 1)) {
                                                                            ?>
                                                                            <select name="y[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues mult" multiple>
                                                                                <?php
                                                                                $g = mysqli_query($conn, "select * from level1 where question_id={$row4['question_id']}");
                                                                                while ($gr = mysqli_fetch_assoc($g)) {
                                                                                    echo $gr['question_id'];

                                                                                    ?>
                                                                                    <option value="<?php echo $gr['value'] ?>"<?php if (array_search($gr['value'], $v) > -1) echo 'selected'; ?>><?php echo $gr['label'] ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        } else if ($r['fieldtype'] == 1 && $r['labeltype'] == 0) {
                                                                            ?>
                                                                            <select name="y[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues">
                                                                                <option value="No" <?php if (substr($row4['value'], 0, -1) == 'No') echo 'selected'; ?>>
                                                                                    No
                                                                                </option>
                                                                                <option value="Yes" <?php if (substr($row4['value'], 0, -1) == 'Yes') echo 'selected'; ?>>
                                                                                    Yes
                                                                                </option>
                                                                            </select>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text" name="y[value][<?php echo $i ?>][]"
                                                                                   class="form-control existingValues"
                                                                                   value="<?php echo substr($row4['value'], 0, -1) ?>">

                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                                else {
                                                                    $v = explode('*', $row4['value'])

                                                                    ?>
                                                                    <select name="y[value][<?php echo $i ?>][]"
                                                                            class="form-control existingValues mult"
                                                                            multiple>
                                                                        <option value="0r" <?php if (array_search('0r', $v) > -1) echo 'selected' ?>>
                                                                            0r
                                                                        </option>
                                                                        <option value="2r" <?php if (array_search('2r', $v) > -1) echo 'selected' ?>>
                                                                            2r
                                                                        </option>
                                                                        <option value="3r" <?php if (array_search('3r', $v) > -1) echo 'selected' ?>>
                                                                            3r
                                                                        </option>
                                                                        <option value="4r" <?php if (array_search('4r', $v) > -1) echo 'selected' ?>>
                                                                            4r
                                                                        </option>
                                                                        <option value="5r" <?php if (array_search('5r', $v) > -1) echo 'selected' ?>>
                                                                            5r
                                                                        </option>
                                                                        <option value="6r" <?php if (array_search('6r', $v) > -1) echo 'selected' ?>>
                                                                            6r
                                                                        </option>
                                                                        <option value="7r" <?php if (array_search('7r', $v) > -1) echo 'selected' ?>>
                                                                            7r
                                                                        </option>
                                                                        <option value="8r" <?php if (array_search('8r', $v) > -1) echo 'selected' ?>>
                                                                            8r
                                                                        </option>
                                                                        <option value="9r" <?php if (array_search('9r', $v) > -1) echo 'selected' ?>>
                                                                            9r
                                                                        </option>
                                                                        <option value="10r" <?php if (array_search('10r', $v) > -1) echo 'selected' ?>>
                                                                            10r
                                                                        </option>

                                                                        <option value="0l" <?php if (array_search('0l', $v) > -1) echo 'selected' ?>>
                                                                            0l
                                                                        </option>
                                                                        <option value="2l" <?php if (array_search('29l', $v) > -1) echo 'selected' ?>>
                                                                            2l
                                                                        </option>
                                                                        <option value="3l"<?php if (array_search('3l', $v) > -1) echo 'selected' ?>>
                                                                            3l
                                                                        </option>
                                                                        <option value="4l"<?php if (array_search('4l', $v) > -1) echo 'selected' ?>>
                                                                            4l
                                                                        </option>
                                                                        <option value="5l"<?php if (array_search('5l', $v) > -1) echo 'selected' ?>>
                                                                            5l
                                                                        </option>
                                                                        <option value="6l"<?php if (array_search('6l', $v) > -1) echo 'selected' ?>>
                                                                            6l
                                                                        </option>
                                                                        <option value="7l"<?php if (array_search('7l', $v) > -1) echo 'selected' ?>>
                                                                            7l
                                                                        </option>
                                                                        <option value="8l"<?php if (array_search('8l', $v) > -1) echo 'selected' ?>>
                                                                            8l
                                                                        </option>
                                                                        <option value="9l"<?php if (array_search('9l', $v) > -1) echo 'selected' ?>>
                                                                            9l
                                                                        </option>
                                                                        <option value="10l"<?php if (array_search('10l', $v) > -1) echo 'selected' ?>>
                                                                            10l
                                                                        </option>

                                                                        <option value="0w"<?php if (array_search('0w', $v) > -1) echo 'selected' ?>>
                                                                            0w
                                                                        </option>
                                                                        <option value="2w"<?php if (array_search('2w', $v) > -1) echo 'selected' ?>>
                                                                            2w
                                                                        </option>
                                                                        <option value="3w"<?php if (array_search('3w', $v) > -1) echo 'selected' ?>>
                                                                            3w
                                                                        </option>
                                                                        <option value="4w"<?php if (array_search('4w', $v) > -1) echo 'selected' ?>>
                                                                            4w
                                                                        </option>
                                                                        <option value="5w"<?php if (array_search('5w', $v) > -1) echo 'selected' ?>>
                                                                            5w
                                                                        </option>
                                                                        <option value="6w"<?php if (array_search('6w', $v) > -1) echo 'selected' ?>>
                                                                            6w
                                                                        </option>
                                                                        <option value="7w"<?php if (array_search('7w', $v) > -1) echo 'selected' ?>>
                                                                            7w
                                                                        </option>
                                                                        <option value="8w"<?php if (array_search('8w', $v) > -1) echo 'selected' ?>>
                                                                            8w
                                                                        </option>
                                                                        <option value="9w"<?php if (array_search('9w', $v) > -1) echo 'selected' ?>>
                                                                            9w
                                                                        </option>
                                                                        <option value="10w"<?php if (array_search('10w', $v) > -1) echo 'selected' ?>>
                                                                            10w
                                                                        </option>


                                                                        <option value="0s"<?php if (array_search('0s', $v) > -1) echo 'selected' ?>>
                                                                            0s
                                                                        </option>
                                                                        <option value="2s"<?php if (array_search('2s', $v) > -1) echo 'selected' ?>>
                                                                            2s
                                                                        </option>
                                                                        <option value="3s"<?php if (array_search('3s', $v) > -1) echo 'selected' ?>>
                                                                            3s
                                                                        </option>
                                                                        <option value="4s"<?php if (array_search('4s', $v) > -1) echo 'selected' ?>>
                                                                            4s
                                                                        </option>
                                                                        <option value="5s"<?php if (array_search('5s', $v) > -1) echo 'selected' ?>>
                                                                            5s
                                                                        </option>
                                                                        <option value="6s"<?php if (array_search('6s', $v) > -1) echo 'selected' ?>>
                                                                            6s
                                                                        </option>
                                                                        <option value="7s"<?php if (array_search('7s', $v) > -1) echo 'selected' ?>>
                                                                            7s
                                                                        </option>
                                                                        <option value="8s"<?php if (array_search('8s', $v) > -1) echo 'selected' ?>>
                                                                            8s
                                                                        </option>
                                                                        <option value="9s"<?php if (array_search('9s', $v) > -1) echo 'selected' ?>>
                                                                            9s
                                                                        </option>
                                                                        <option value="10s"<?php if (array_search('10s', $v) > -1) echo 'selected' ?>>
                                                                            10s
                                                                        </option>
                                                                    </select>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <div id="newValue" style="display: none">
                                                                    <input type="text" name="y[value][<?php echo $i ?>][]"
                                                                           class="form-control adis">
                                                                </div>
                                                                <div id="existValue" class="exValue" style="display: none">

                                                                    <select name="y[value][<?php echo $i ?>][]" class="form-control adis"
                                                                            disabled>

                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>

                                                                <select name="y[user_type][]" class="form-control"
                                                                        required>
                                                                    <option value='' selected disabled>-- Select --
                                                                    </option>
                                                                    <option value="user" <?php if ($row4['user_type'] == 'user') echo 'selected'; ?>>
                                                                        User
                                                                    </option>
                                                                    <option value="spouse" <?php if ($row4['user_type'] == 'spouse') echo 'selected'; ?>>
                                                                        Spouse
                                                                    </option>
                                                                    <option value="both" <?php if ($row4['user_type'] == 'both') echo 'selected'; ?>>
                                                                        Both
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="other[]"
                                                                        onchange="otherCase(this)">
                                                                    <option value="" disabled selected>--Select--
                                                                    </option>
                                                                    <option value="score" <?php if ($row4['score_number'] != '') echo 'selected' ?>>
                                                                        Score
                                                                    </option>
                                                                    <option value="condition" <?php if ($row4['condition2'] != '') echo 'selected' ?>>
                                                                        Condition
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control abc" name="y[score_number][]"
                                                                       value="<?php echo $row4['score_number'] ?>"
                                                                       id="score"
                                                                       required <?php if ($row4['score_number'] == '') { ?> style="display: none"  <?php } ?>>
                                                                <select class="form-control abc" name="y[condition2][]"
                                                                        id="condition" <?php if ($row4['condition2'] == '') { ?> style="display: none" disabled <?php } ?>>
                                                                    <option value="or" <?php if ($row4['condition2'] == 'or') echo 'selected' ?>>
                                                                        OR
                                                                    </option>
                                                                    <option value="and" <?php if ($row4['condition2'] == 'and') echo 'selected' ?>>
                                                                        AND
                                                                    </option>
                                                                </select>

                                                            </td>
                                                            <td><a href="javascript:void(0);"
                                                                   class="remove_button btn btn-danger"><i
                                                                            class="fa fa-trash"></i></a></td>
                                                        </tr>

                                                        <?php
                                                    } ?>
                                                    </tbody>
                                                </table>
                                                <div class="row">
                                                    <div class="col-sm-12 text-right">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                                id="addMoreQues4">Add More
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div id="both" class="optionsDiv">
                                            <h3>AND - OR Condition</h3>
                                            <div class="table-responsive">
                                                <table class="table table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr>
                                                        <th>Label Type</th>
                                                        <th>Case</th>
                                                        <th>Question Type</th>
                                                        <th style="width: 30%">Question</th>
                                                        <th>Operator</th>
                                                        <th style="width: 7%">Value</th>
                                                        <th>User Type</th>
                                                        <th>Option</th>
                                                        <th style="width: 8%">Score/Condition</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="appendQuesType5">
                                                    <?php
                                                    $i = 0;
                                                    while ($row5 = mysqli_fetch_assoc($getQues4)) {
                                                        $i++;
                                                        ?>
                                                        <tr id="trCounttttt<?php echo $i ?>" class="trCounttttt">
                                                            <td>
                                                                <select name="a[label_type][]"
                                                                        class="form-control label_type " required> } ?>>
                                                                    <!--                                                                    <option value='' selected disabled>-- Select --</option>-->
                                                                    <option value="user" <?php if ($row5['label_type'] == 'user') echo 'selected'; ?>>
                                                                        User
                                                                    </option>
                                                                    <option value="spouse" <?php if ($row5['label_type'] == 'spouse') echo 'selected'; ?>>
                                                                        Spouse
                                                                    </option>
                                                                    <option value="both" <?php if ($row5['label_type'] == 'both') echo 'selected'; ?>>
                                                                        Both
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="a[score_case][]" class="form-control sc"
                                                                        onchange="getLabels(this)">
                                                                    <option value="">-- Select Case --</option>
                                                                    <option value="1" <?php if ($row5['score_case'] == '1') {
                                                                        echo 'selected';
                                                                    } ?>>Label
                                                                    </option>
                                                                    <option value="0" <?php if ($row5['score_case'] == '0') {
                                                                        echo 'selected';
                                                                    } ?>>Value
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="a[question_type][]"
                                                                        class="form-control ques <?php if ($row5['score_case'] == '1') echo 'adis' ?>"
                                                                        onchange="question_type('mQues','sQues','sType',this)"
                                                                        required>
                                                                    <option value="">-- Select Question Type --</option>
                                                                    <option value="m_question" <?php if ($row5['question_type'] == 'm_question') {
                                                                        echo 'selected';
                                                                    } ?>>Main Question
                                                                    </option>
                                                                    <option value="s_question" <?php if ($row5['question_type'] == 's_question') {
                                                                        echo 'selected';
                                                                    } ?>>Sub Question
                                                                    </option>
                                                                    <option value="score_type" <?php if ($row5['question_type'] == 'score_type') {
                                                                        echo 'selected';
                                                                    } ?>>Score Type
                                                                    </option>

                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="a[tests][]"
                                                                        class="form-control tests <?php if ($row5['score_case'] == 0) { ?> adis <?php } ?>" <?php if ($row5['score_case'] == 0) { ?> style="display: none" <?php } ?>>
                                                                    <option value="">--Select Test--</option>
                                                                    <option value="celpip" <?php if ($row5['tests'] == 'celpip') {
                                                                        echo 'selected';
                                                                    } ?>>CELPIP
                                                                    </option>
                                                                    <option value="ielts" <?php if ($row5['tests'] == 'ielts') {
                                                                        echo 'selected';
                                                                    } ?>>IELTS
                                                                    </option>
                                                                    <option value="tcf" <?php if ($row5['tests'] == 'tcf') {
                                                                        echo 'selected';
                                                                    } ?>>TCF
                                                                    </option>
                                                                    <option value="tef" <?php if ($row5['tests'] == 'tef') {
                                                                        echo 'selected';
                                                                    } ?>>TEF
                                                                    </option>

                                                                </select>
                                                                <div class="mQues no_tests" <?php if ($row5['question_type'] != 'm_question') { ?> style="display: none" <?php } ?>>
                                                                    <select name="a[question_id][]"
                                                                            class="form-control selectBox mQues ques <?php if ($row5['question_type'] != 'm_question') { ?> adis <?php } ?>"
                                                                            onchange="checkAnswer(this,'m_question')"
                                                                            required>
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($quesArr as $k => $v) { ?>
                                                                            <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $row5['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $v['question'].' - '.$v['id'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="sQues no_tests" <?php if ($row5['question_type'] != 's_question') { ?> style="display: none" <?php } ?>>

                                                                    <select name="a[question_id][]"
                                                                            class="form-control selectBox sQues ques <?php if ($row5['question_type'] != 's_question') { ?> adis <?php } ?>"
                                                                            onchange="checkAnswer(this,'s_question')"
                                                                            required>
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($squesArr as $kV => $Vv) { ?>
                                                                            <option value="<?php echo $Vv['id'] ?>" <?php if ($Vv['id'] == $row5['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo $Vv['question'] ?>
                                                                                - <?php echo $Vv['id'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="sType no_tests" <?php if ($row5['question_type'] != 'score_type') { ?> style="display: none" <?php } ?>>
                                                                    <select name="a[question_id][]"
                                                                            class="form-control selectBox sType ques <?php if ($row5['question_type'] != 'score_type') { ?> adis <?php } ?>"
                                                                            required
                                                                            onchange="checkAnswer(this,'score_type')">
                                                                        <option value="" selected disabled>-- Select
                                                                            --
                                                                        </option>
                                                                        <?php foreach ($scoretype as $kV => $Vv) { ?>
                                                                            <option value="<?php echo $Vv['name'] ?>" <?php if ($Vv['name'] == $row5['question_id']) {
                                                                                echo 'selected';
                                                                            } ?>><?php echo strtoupper($Vv['name']) ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="a[operator][]" class="form-control"
                                                                        required>
                                                                    <option value="=" <?php if ($row5['operator'] == '=') echo 'selected'; ?>>
                                                                        =
                                                                    </option>
                                                                    <option value="!=" <?php if ($row5['operator'] == '!=') echo 'selected'; ?>>
                                                                        !=
                                                                    </option>
                                                                    <option value="<" <?php if ($row5['operator'] == '<') echo 'selected'; ?>>
                                                                        &lt;
                                                                    </option>
                                                                    <option value=">" <?php if ($row5['operator'] == '>') echo 'selected'; ?>>
                                                                        &gt;
                                                                    </option>
                                                                    <option value="<=" <?php if ($row5['operator'] == '<=') echo 'selected'; ?>>
                                                                        &lt;=
                                                                    </option>
                                                                    <option value=">=" <?php if ($row5['operator'] == '>=') echo 'selected'; ?>>
                                                                        &gt;=
                                                                    </option>
                                                                    <option value="-" <?php if ($row5['operator'] == '-') echo 'selected'; ?>>
                                                                        -
                                                                    </option>
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <?php
                                                                if ($row5['score_case'] == 0) {
                                                                    if ($row5['question_type'] == 'm_question') {
                                                                        $s = mysqli_query($conn, "select * from questions where id={$row5['question_id']}");
                                                                        $r = mysqli_fetch_assoc($s);
                                                                        $v = explode('*', $row5['value']);
                                                                        if (($r['fieldtype'] == 7) || ($r['fieldtype'] == 1 && $r['labeltype'] == 1)) {
                                                                            ?>
                                                                            <select name="a[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues mult"
                                                                                    multiple>
                                                                                <?php
                                                                                $g = mysqli_query($conn, "select * from question_labels where question_id={$row5['question_id']}");
                                                                                while ($gr = mysqli_fetch_assoc($g)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $gr['value'] ?>"<?php if (array_search($gr['value'], $v) > -1) echo 'selected'; ?>><?php echo $gr['label'] ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        } else if ($r['fieldtype'] == 1 && $r['labeltype'] == 0) {
                                                                            ?>
                                                                            <select name="a[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues">
                                                                                <option value="No" <?php if (substr($row5['value'], 0, -1) == 'No') echo 'selected'; ?>>
                                                                                    No
                                                                                </option>
                                                                                <option value="Yes" <?php if (substr($row5['value'], 0, -1) == 'Yes') echo 'selected'; ?>>
                                                                                    Yes
                                                                                </option>
                                                                            </select>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text"
                                                                                   name="a[value][<?php echo $i ?>][]"
                                                                                   class="form-control existingValues"
                                                                                   value="<?php echo substr($row5['value'], 0, -1) ?>">

                                                                            <?php
                                                                        }
                                                                    } else {
                                                                        $s = mysqli_query($conn, "select * from sub_questions where id={$row5['question_id']}");
                                                                        $r = mysqli_fetch_assoc($s);
                                                                        $v = explode('*', $row5['value']);

                                                                        if (($r['fieldtype'] == 7) || ($r['fieldtype'] == 1 && $r['labeltype'] == 1)) {
                                                                            ?>
                                                                            <select name="a[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues mult"
                                                                                    multiple>
                                                                                <?php
                                                                                $g = mysqli_query($conn, "select * from level1 where question_id={$row5['question_id']}");
                                                                                while ($gr = mysqli_fetch_assoc($g)) {
                                                                                    echo $gr['question_id'];

                                                                                    ?>
                                                                                    <option value="<?php echo $gr['value'] ?>"<?php if (array_search($gr['value'], $v) > -1) echo 'selected'; ?>><?php echo $gr['label'] ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php
                                                                        } else if ($r['fieldtype'] == 1 && $r['labeltype'] == 0) {
                                                                            ?>
                                                                            <select name="a[value][<?php echo $i ?>][]"
                                                                                    class="form-control existingValues">
                                                                                <option value="No" <?php if (substr($row5['value'], 0, -1) == 'No') echo 'selected'; ?>>
                                                                                    No
                                                                                </option>
                                                                                <option value="Yes" <?php if (substr($row5['value'], 0, -1) == 'Yes') echo 'selected'; ?>>
                                                                                    Yes
                                                                                </option>
                                                                            </select>
                                                                            <?php
                                                                        } else {
                                                                            ?>
                                                                            <input type="text"
                                                                                   name="a[value][<?php echo $i ?>][]"
                                                                                   class="form-control existingValues"
                                                                                   value="<?php echo substr($row5['value'], 0, -1) ?>">

                                                                            <?php
                                                                        }
                                                                    }
                                                                } else {
                                                                    $v = explode('*', $row5['value'])

                                                                    ?>
                                                                    <select name="a[value][<?php echo $i ?>][]"
                                                                            class="form-control existingValues mult"
                                                                            multiple>
                                                                        <option value="0r" <?php if (array_search('0r', $v) > -1) echo 'selected' ?>>
                                                                            0r
                                                                        </option>
                                                                        <option value="2r" <?php if (array_search('2r', $v) > -1) echo 'selected' ?>>
                                                                            2r
                                                                        </option>
                                                                        <option value="3r" <?php if (array_search('3r', $v) > -1) echo 'selected' ?>>
                                                                            3r
                                                                        </option>
                                                                        <option value="4r" <?php if (array_search('4r', $v) > -1) echo 'selected' ?>>
                                                                            4r
                                                                        </option>
                                                                        <option value="5r" <?php if (array_search('5r', $v) > -1) echo 'selected' ?>>
                                                                            5r
                                                                        </option>
                                                                        <option value="6r" <?php if (array_search('6r', $v) > -1) echo 'selected' ?>>
                                                                            6r
                                                                        </option>
                                                                        <option value="7r" <?php if (array_search('7r', $v) > -1) echo 'selected' ?>>
                                                                            7r
                                                                        </option>
                                                                        <option value="8r" <?php if (array_search('8r', $v) > -1) echo 'selected' ?>>
                                                                            8r
                                                                        </option>
                                                                        <option value="9r" <?php if (array_search('9r', $v) > -1) echo 'selected' ?>>
                                                                            9r
                                                                        </option>
                                                                        <option value="10r" <?php if (array_search('10r', $v) > -1) echo 'selected' ?>>
                                                                            10r
                                                                        </option>

                                                                        <option value="0l" <?php if (array_search('0l', $v) > -1) echo 'selected' ?>>
                                                                            0l
                                                                        </option>
                                                                        <option value="2l" <?php if (array_search('29l', $v) > -1) echo 'selected' ?>>
                                                                            2l
                                                                        </option>
                                                                        <option value="3l"<?php if (array_search('3l', $v) > -1) echo 'selected' ?>>
                                                                            3l
                                                                        </option>
                                                                        <option value="4l"<?php if (array_search('4l', $v) > -1) echo 'selected' ?>>
                                                                            4l
                                                                        </option>
                                                                        <option value="5l"<?php if (array_search('5l', $v) > -1) echo 'selected' ?>>
                                                                            5l
                                                                        </option>
                                                                        <option value="6l"<?php if (array_search('6l', $v) > -1) echo 'selected' ?>>
                                                                            6l
                                                                        </option>
                                                                        <option value="7l"<?php if (array_search('7l', $v) > -1) echo 'selected' ?>>
                                                                            7l
                                                                        </option>
                                                                        <option value="8l"<?php if (array_search('8l', $v) > -1) echo 'selected' ?>>
                                                                            8l
                                                                        </option>
                                                                        <option value="9l"<?php if (array_search('9l', $v) > -1) echo 'selected' ?>>
                                                                            9l
                                                                        </option>
                                                                        <option value="10l"<?php if (array_search('10l', $v) > -1) echo 'selected' ?>>
                                                                            10l
                                                                        </option>

                                                                        <option value="0w"<?php if (array_search('0w', $v) > -1) echo 'selected' ?>>
                                                                            0w
                                                                        </option>
                                                                        <option value="2w"<?php if (array_search('2w', $v) > -1) echo 'selected' ?>>
                                                                            2w
                                                                        </option>
                                                                        <option value="3w"<?php if (array_search('3w', $v) > -1) echo 'selected' ?>>
                                                                            3w
                                                                        </option>
                                                                        <option value="4w"<?php if (array_search('4w', $v) > -1) echo 'selected' ?>>
                                                                            4w
                                                                        </option>
                                                                        <option value="5w"<?php if (array_search('5w', $v) > -1) echo 'selected' ?>>
                                                                            5w
                                                                        </option>
                                                                        <option value="6w"<?php if (array_search('6w', $v) > -1) echo 'selected' ?>>
                                                                            6w
                                                                        </option>
                                                                        <option value="7w"<?php if (array_search('7w', $v) > -1) echo 'selected' ?>>
                                                                            7w
                                                                        </option>
                                                                        <option value="8w"<?php if (array_search('8w', $v) > -1) echo 'selected' ?>>
                                                                            8w
                                                                        </option>
                                                                        <option value="9w"<?php if (array_search('9w', $v) > -1) echo 'selected' ?>>
                                                                            9w
                                                                        </option>
                                                                        <option value="10w"<?php if (array_search('10w', $v) > -1) echo 'selected' ?>>
                                                                            10w
                                                                        </option>


                                                                        <option value="0s"<?php if (array_search('0s', $v) > -1) echo 'selected' ?>>
                                                                            0s
                                                                        </option>
                                                                        <option value="2s"<?php if (array_search('2s', $v) > -1) echo 'selected' ?>>
                                                                            2s
                                                                        </option>
                                                                        <option value="3s"<?php if (array_search('3s', $v) > -1) echo 'selected' ?>>
                                                                            3s
                                                                        </option>
                                                                        <option value="4s"<?php if (array_search('4s', $v) > -1) echo 'selected' ?>>
                                                                            4s
                                                                        </option>
                                                                        <option value="5s"<?php if (array_search('5s', $v) > -1) echo 'selected' ?>>
                                                                            5s
                                                                        </option>
                                                                        <option value="6s"<?php if (array_search('6s', $v) > -1) echo 'selected' ?>>
                                                                            6s
                                                                        </option>
                                                                        <option value="7s"<?php if (array_search('7s', $v) > -1) echo 'selected' ?>>
                                                                            7s
                                                                        </option>
                                                                        <option value="8s"<?php if (array_search('8s', $v) > -1) echo 'selected' ?>>
                                                                            8s
                                                                        </option>
                                                                        <option value="9s"<?php if (array_search('9s', $v) > -1) echo 'selected' ?>>
                                                                            9s
                                                                        </option>
                                                                        <option value="10s"<?php if (array_search('10s', $v) > -1) echo 'selected' ?>>
                                                                            10s
                                                                        </option>
                                                                    </select>
                                                                    <?php
                                                                }
                                                                ?>


                                                                <div id="newValue" style="display: none">
                                                                    <input type="text"
                                                                           name="a[value][<?php echo $i ?>][]"
                                                                           class="form-control adis">
                                                                </div>
                                                                <div id="existValue" style="display: none">

                                                                    <select name="a[value][<?php echo $i ?>][]"
                                                                            class="form-control adis">

                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select name="a[user_type][]" class="form-control"
                                                                        required>
                                                                    <option value='' selected disabled>-- Select --
                                                                    </option>
                                                                    <option value="user" <?php if ($row5['user_type'] == 'user') echo 'selected'; ?>>
                                                                        User
                                                                    </option>
                                                                    <option value="spouse" <?php if ($row5['user_type'] == 'spouse') echo 'selected'; ?>>
                                                                        Spouse
                                                                    </option>
                                                                    <option value="both" <?php if ($row5['user_type'] == 'both') echo 'selected'; ?>>
                                                                        Both
                                                                    </option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select class="form-control" name="other[]"
                                                                        onchange="otherCase(this)">
                                                                    <option value="" disabled selected>--Select--
                                                                    </option>
                                                                    <option value="score" <?php if ($row5['score_number'] != '') echo 'selected' ?>>
                                                                        Score
                                                                    </option>
                                                                    <option value="condition" <?php if ($row5['condition2'] != '') echo 'selected' ?>>
                                                                        Condition
                                                                    </option>
                                                                    <option value="question" <?php if ($row5['other_case'] == 'question') echo 'selected' ?>>
                                                                        Move to question
                                                                    </option>
                                                                    <option value="scoring" <?php if ($row5['other_case'] == 'scoring') echo 'selected' ?>>
                                                                        Move to Scoring
                                                                    </option>
                                                                    <option value="comment" <?php if ($row5['other_case'] == 'comment') echo 'selected' ?>>
                                                                        Show Comment
                                                                    </option>

                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control abc" name="a[score_number][]"
                                                                       value="<?php echo $row5['score_number'] ?>"
                                                                       id="score"
                                                                       required <?php if ($row5['score_number'] == '') { ?> style="display: none"  <?php } ?>>
                                                                <select class="form-control abc" name="a[condition2][]"
                                                                        id="condition" <?php if ($row5['condition2'] == '') { ?> style="display: none" disabled <?php } ?>>
                                                                    <option value="or" <?php if ($row5['condition2'] == 'or') echo 'selected' ?>>
                                                                        OR
                                                                    </option>
                                                                    <option value="and" <?php if ($row5['condition2'] == 'and') echo 'selected' ?>>
                                                                        AND
                                                                    </option>
                                                                </select>

                                                            </td>
                                                            <td><a href="javascript:void(0);"
                                                                   class="remove_button btn btn-danger"><i
                                                                            class="fa fa-trash"></i></a></td>
                                                        </tr>
                                                        <?php
                                                        if ($row5['other_case'] == 'question') {
                                                            $ocase = 1;
                                                            $qtype = $row5['move_qtype'];
                                                            $qid = $row5['move_qid'];
                                                        } else if ($row5['other_case'] == 'scoring') {
                                                            $ocase = 2;
                                                            $stype = $row5['move_scoreType'];
                                                        } else if ($row5['other_case'] == 'comment') {
                                                            $ocase = 3;
                                                            $comment = $row5['comments'];
                                                        }
                                                    } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="button"
                                                            class="btn btn-info btn-sm <?php if ($ocase == 1 || $ocase == 2 || $ocase == 3) { ?> adis <?php } ?>"
                                                            id="addMoreQues5">Add More
                                                    </button>
                                                </div>

                                                <div class="col-sm-6 moveQues1" <?php if ($ocase != 1) { ?>  style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="move[type]" class="form-control"
                                                                onchange="getQuestion('mQues2','sQues2',this)">
                                                            <option value="">-- Select Question Type --</option>
                                                            <option value="m_question" <?php if ($qtype == 'm_question') echo 'selected' ?> >
                                                                Main Question
                                                            </option>
                                                            <option value="s_question" <?php if ($qtype == 's_question') echo 'selected' ?>>
                                                                Sub Question
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 moveQues1" <?php if ($ocase != 1) { ?> style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label class="q_lbl" <?php if ($ocase != 1) { ?> style="display: none" <?php } ?>>Question</label>
                                                        <div id="mQues2" <?php if ($qtype != 'm_question') { ?> style="display: none" <?php } ?>>
                                                            <select name="move[qid]" class="form-control selectBox"
                                                                    required id="">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach ($quesArr as $k => $v) {
                                                                    ?>
                                                                    <option value="<?php echo $v['id'] ?>" <?php if ($qid == $v['id']) echo 'selected' ?>><?php echo $v['id'].' - '.$v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues2" <?php if ($qtype != 's_question') { ?> style="display: none" <?php } ?>>
                                                            <select name="move[sid]" class="form-control selectBox"
                                                                    id="" required>
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach ($squesArr as $kV => $Vv) {
                                                                    ?>
                                                                    <option value="<?php echo $Vv['id'] ?>" <?php if ($qid == $Vv['id']) echo 'selected' ?>><?php echo $Vv['id'].' - '.$Vv['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-6 moveScore1" <?php if ($ocase != 2) { ?> style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label class="">Score ID</label>
                                                        <select name="move[scoreType]" class="form-control selectBox"
                                                                id="">
                                                            <option value="" selected disabled>-- Select --</option>
                                                            <?php
                                                            foreach ($getScores as $kV => $Vv) {
                                                                ?>
                                                                <option value="<?php echo $Vv['id'] ?>" <?php if ($stype == $Vv['id']) echo 'selected' ?>><?php echo $Vv['scoreID'] ?></option>
                                                                <?php
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div id="comment"
                                                     class="col-sm-12" <?php if ($ocase != 3) { ?>  style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label>Comments</label>
                                                        <input type="text" class="form-control" name="comments"
                                                               value="<?php echo $comment ?>" required>
                                                    </div>
                                                </div>

                                            </div>


                                        </div>


                                        <div id="multicondition" class="optionsDiv">
                                            <table class="table table-bordered dt-responsive nowrap">
                                                <thead>
                                                <tr>
                                                    <th style="width: 16%">Operator</th>
                                                    <th style="width: 28%">Value</th>
                                                    <th style="width: 28%">Score</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="appendQuesType">
                                                <?php
                                                while ($row1 = mysqli_fetch_assoc($getConditions)) {
                                                    ?>
                                                    <tr id="trCount">
                                                        <td>
                                                            <select name="c[operator][]" class="form-control" required>
                                                                <option value="=" <?php if ($row1['operator'] == '=') echo 'selected'; ?>>
                                                                    =
                                                                </option>
                                                                <option value="!=" <?php if ($row1['operator'] == '!=') echo 'selected'; ?>>
                                                                    !=
                                                                </option>
                                                                <option value="<" <?php if ($row1['operator'] == '<') echo 'selected'; ?>>
                                                                    &lt;
                                                                </option>
                                                                <option value=">" <?php if ($row1['operator'] == '>') echo 'selected'; ?>>
                                                                    &gt;
                                                                </option>
                                                                <option value="<=" <?php if ($row1['operator'] == '<=') echo 'selected'; ?>>
                                                                    &lt;=
                                                                </option>
                                                                <option value=">=" <?php if ($row1['operator'] == '>=') echo 'selected'; ?>>
                                                                    &gt;=
                                                                </option>
                                                                <option value="-" <?php if ($row1['operator'] == '-') echo 'selected'; ?>>
                                                                    -
                                                                </option>
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="text" name="c[value][]"
                                                                   value="<?php echo $row1['value'] ?>"
                                                                   class="form-control" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="c[score_number][]"
                                                                   value="<?php echo $row1['score_number'] ?>"
                                                                   class="form-control" required>
                                                        </td>
                                                        <td><a href="javascript:void(0);"
                                                               class="remove_button btn btn-danger"><i
                                                                        class="fa fa-trash"></i></a></td>
                                                    </tr>

                                                    <?php
                                                }
                                                ?>
                                                </tbody>
                                            </table>

                                            <div class="row">
                                                <div class="col-sm-12 text-right">
                                                    <button type="button" class="btn btn-info btn-sm" id="addMoreMulti">
                                                        Add More
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Max Score</label>
                                                <div class="form-group">
                                                    <input type="text" name="n[max_score]" id="" class="form-control"
                                                           value="<?php echo $row['max_score'] ?>">
                                                </div>
                                            </div>
                                            <!--                                            <div class="col-sm-6">-->
                                            <!--                                                <div class="form-group">-->
                                            <!--                                                    <label for="title">Skill</label>-->
                                            <!--                                                    <select class="form-control" name="n[skill]" id="">-->
                                            <!--                                                        <option value="" disabled selected>-- Select --</option>-->
                                            <!--                                                        <option value="low" -->
                                            <?php //if($row['skill']=='low') { echo 'selected'; } ?><!--Low</option>-->
                                            <!--                                                        <option value="high"-->
                                            <?php //if($row['skill']=='high') { echo 'selected'; } ?><!-- >High</option>-->
                                            <!--                                                    </select>-->
                                            <!---->
                                            <!--                                                </div>-->
                                            <!--                                            </div>-->
                                            <div class="col-sm-12">
                                                <label>Notes</label>
                                                <div class="form-group notes">
                                                    <input type="text" name="n[notes]" id="notes_text"
                                                           class="form-control" value="<?php echo $row['notes'] ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light"
                                                    id="AddLoaderE">Update Score
                                            </button>
                                        </div>
                                    </form>

                                <?php }
                               ?>
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


<?php include_once("includes/script.php"); ?>
<link href="assets/css/select2.min.css" rel="stylesheet">
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/select2-init.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>

</script>


<script>

    $(document).ready(function () {
        changeOption()
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color', 'transparent')
        $('.select2-container .select2-selection--single').css('border', 0)
        $(".nocSelect").each(function () {
            $(this).find('option').eq(0).hide()
        });


        $('.abc:hidden').prop('disabled', true)
        $('.adis').prop('disabled', true)
        $('.mult').attr('multiple', true);

        $('.mult').selectpicker();

        $("input").each(function () {
            $(this).attr('title', $(this).val())
        });

        $("select").each(function () {
            $(this).attr('title', $(this).val())
        });
    })

    function other_check(e,type) {
        if(type=='country')
        {
            $(e).parent().children('.countryCheck').val($(e).val())
        }
        else if(type=='skill')
        {
            $(e).parent().children('.skillCheck').val($(e).val())
        }
        else if(type=='job')
        {
            if($(e).prop('checked')==false)
            {
                $(e).parent().children('.jobCheck').val('')

            }
            else
            {
                $(e).parent().children('.jobCheck').val($(e).val())

            }
        }
        else if(type=='emp')
        {
            if($(e).prop('checked')==false)
            {
                $(e).parent().children('.empCheck').val('')

            }
            else
            {
                $(e).parent().children('.empCheck').val($(e).val())

            }
        }
        else if(type=='same')
        {
            if($(e).prop('checked')==false)
            {
                $(e).parent().children('.sameCheck').val('')

            }
            else
            {
                $(e).parent().children('.sameCheck').val($(e).val())

            }
        }
    }
    function otherCase(e) {

        let a = $(e).val()
        let tr_id = $(e).closest('tr').prop('id');
        let sc = $("#" + tr_id + " #" + a).val()

        if (a == 'question') {
            $('.moveQues1').show()
            $('.moveScore1').hide()
            $('#addMoreQues5').prop('disabled', true)
            $("#" + tr_id + " .abc").hide()
            $("#" + tr_id + " .abc").prop('disabled', true)
            $('#comment').hide()


        } else if (a == 'scoring') {
            $('.moveScore1').show()

            $('.moveQues1').hide()
            $('#addMoreQues5').prop('disabled', true)
            $("#" + tr_id + " .abc").hide()
            $("#" + tr_id + " .abc").prop('disabled', true)
            $('#comment').hide()


        } else if (a == 'comment') {
            $('#comment').show()
            $('.moveScore1').hide()
            $('.moveQues1').hide()
            // $('#addMoreQues5').prop('disabled',true)
            $("#" + tr_id + " .abc").hide()
            $("#" + tr_id + " .abc").prop('disabled', true)

        } else {
            $('.moveQues1').hide()
            $('.moveScore1').hide()
            $('#comment').hide()

            $('#addMoreQues5').prop('disabled', false)
            $("#" + tr_id + " .abc").hide()
            $("#" + tr_id + " .abc").prop('disabled', true)
            $("#" + tr_id + " #" + a).show()
            $("#" + tr_id + " #" + a).prop('disabled', false)
        }
    }

    function otherCase2(e) {

        let a = $(e).val()
        let tr_id = $(e).closest('tr').prop('id');
        let sc = $("#" + tr_id + " #" + a).val()

        if (a == 'question') {
            $('.moveQues2').show()
            $('#addNoc').prop('disabled', true)
            $('.moveScore2').hide()

            // $("#" + tr_id + " .abc").hide()
            // $("#" + tr_id + " .abc").prop('disabled', true)

        } else if (a == 'scoring') {
            $('.moveQues2').hide()
            $('#addNoc').prop('disabled', true)
            $('.moveScore2').show()

            // $("#" + tr_id + " .abc").hide()
            // $("#" + tr_id + " .abc").prop('disabled', true)

        } else {
            $('.moveQues2').hide()
            $('#addNoc').prop('disabled', false)
            $('.moveScore2').hide()

            // $("#" + tr_id + " .abc").hide()
            // $("#" + tr_id + " .abc").prop('disabled', true)
            // $("#" + tr_id + " #" + a).show()
            // $("#" + tr_id + " #" + a).prop('disabled', false)
        }
    }

    function changeOption() {
        let type = $('#casetype').val();


        $('.optionsDiv').hide();

        $('.optionsDiv').find('input, textarea, button, select').attr('disabled', 'disabled');
        $('#' + type).show();
        $('#' + type).find('input, textarea, button, select').attr('disabled', false);

        if (type == 'or') {
            $('#multicondition').show();
            $('#multicondition').find('input, textarea, button, select').attr('disabled', false);
        } else {
            $('#multicondition').hide();
            $('#multicondition').find('input, textarea, button, select').attr('disabled', true);
        }

    }


    function question_type(main, sub, stype, value) {
        if ($(value).val() == 'm_question') {

            $(value).closest('tr').find('.' + main).show()
            $(value).closest('tr').find('.' + sub).hide()
            $(value).closest('tr').find('.' + stype).hide()

            $(value).closest('tr').find('.' + sub).find('select').attr('disabled', true);
            $(value).closest('tr').find('.' + main).find('select').attr('disabled', false);
            $(value).closest('tr').find('.' + stype).find('select').attr('disabled', true);


        } else if ($(value).val() == 's_question') {
            $(value).closest('tr').find('.' + main).hide()
            $(value).closest('tr').find('.' + stype).hide()
            $(value).closest('tr').find('.' + sub).show()

            $(value).closest('tr').find('.' + sub).find('select').attr('disabled', false);
            $(value).closest('tr').find('.' + main).find('select').attr('disabled', true);
            $(value).closest('tr').find('.' + stype).find('select').attr('disabled', true);

        } else {
            $(value).closest('tr').find('.' + main).hide()
            $(value).closest('tr').find('.' + stype).show()
            $(value).closest('tr').find('.' + sub).hide()

            $(value).closest('tr').find('.' + sub).find('select').attr('disabled', true);
            $(value).closest('tr').find('.' + main).find('select').attr('disabled', true);
            $(value).closest('tr').find('.' + stype).find('select').attr('disabled', false);
        }
    }

    function question_type2(main, sub, value) {
        if ($(value).val() == 'm_question') {

            $(value).closest('tr').find('.' + main).show()
            $(value).closest('tr').find('.' + sub).hide()

            $(value).closest('tr').find('.' + sub).find('select').attr('disabled', true);
            $(value).closest('tr').find('.' + main).find('select').attr('disabled', false);


        } else if ($(value).val() == 's_question') {
            $(value).closest('tr').find('.' + main).hide()
            $(value).closest('tr').find('.' + sub).show()

            $(value).closest('tr').find('.' + sub).find('select').attr('disabled', false);
            $(value).closest('tr').find('.' + main).find('select').attr('disabled', true);

        }
    }

    function question_type3(main, sub, value) {
        $('#q_lbl').show()
        if ($(value).val() == 'm_question') {

            $('#' + main).show()
            $('#' + sub).hide()

            $('#' + sub).find('select').attr('disabled', true);
            $('#' + main).find('select').attr('disabled', false);


        } else if ($(value).val() == 's_question') {
            $('#' + main).hide()
            $('#' + sub).show()

            $('#' + sub).find('select').attr('disabled', false);
            $('#' + main).find('select').attr('disabled', true);

        }
    }



    $('#addMoreQues').click(function () {

        let c = $('.trCountt').length;
        let row=$('.trCountt ').last().attr('id');
        let rc = ''
        if(row.length==9) {
            rc = row.charAt(row.length - 1);
        }
        else
        {
            rc = row.slice(-2);

        }
        rc=parseInt(rc)+1
        c++;

        var data = ' <tr id="trCountt' + rc + '" class="trCountt">\n' +
            '                                                    <td>\n' +
            '                                                        <select name="z[question_type][]" class="form-control"onchange="question_type2(\'mQues\',\'sQues\',this)" required>\n' +
            '                                                            <option value="">-- Select Question Type --</option>\n' +
            '                                                            <option value="m_question">Main Question</option>\n' +
            '                                                            <option value="s_question">Sub Question</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>'


        data += '       <td>\n' +
            '                                                                                                                <div class="mQues" style="display: none"><select name="z[question_id][]" class="form-control selectBox mQues" required >\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($quesArr as $k=>$v) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $v['id'])?>"><?php echo str_replace('\'', '', $v['question']) ?> - <?php echo $v['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select>\n' +
            '                                                   </div> \n' +
            '                                                                                                               <div class="sQues" style="display: none"><select name="z[question_id][]" class="form-control selectBox sQues"  required >\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($squesArr as $kV=>$Vv) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $Vv['id'])?>"><?php echo str_replace('\'', '', $Vv['question']) ?> - <?php echo $Vv['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select></div></td>'
        data += '<td><select name="z[user_type][]" class="form-control" required>\n' +
            '                                                            <option value=\'\' selected disabled>-- Select --</option>\n' +
            '                                                            <option value="user">User</option>\n' +
            '                                                            <option value="spouse">Spouse</option>\n' +
            '                                                            <option value="both">Both</option>\n' +
            '                                                        </select></td>'
        data += '<td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td>'
        data += '</tr>'
        $('#appendQuesType2').append(data)
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color', 'transparent')
        $('.select2-container .select2-selection--single').css('border', 0)
    })
    $('#addMoreQues3').click(function () {
        let c = $('.trCounttt').length;
        let row=$('.trCounttt ').last().attr('id');
        let rc = ''
        if(row.length==10) {
            rc = row.charAt(row.length - 1);
        }
        else
        {
            rc = row.slice(-2);

        }
        rc=parseInt(rc)+1
        c++;
        var data = '<tr id="trCounttt' + rc + '" class="trCounttt"><td>\n' +
            '                                                            <select name="x[score_case][]" class="form-control sc" >\n' +
            '                                                                <option value="">-- Select Case --</option>\n' +
            '                                                                <option value="1">Label</option>\n' +
            '                                                                <option value="0">Value</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>'
        data += ' \n' +
            '                                                    <td>\n' +
            '                                                        <select name="x[question_type][]" class="form-control"onchange="question_type2(\'mQues\',\'sQues\',this)">\n' +
            '                                                            <option value="">-- Select Question Type --</option>\n' +
            '                                                            <option value="m_question">Main Question</option>\n' +
            '                                                            <option value="s_question">Sub Question</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>'


        data += '       <td>\n' +
            '                                                                                                                <div class="mQues" style="display: none"><select name="x[question_id][]"  class="form-control selectBox mQues" onchange="checkAnswer(this,\'m_question\')">\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($quesArr as $k=>$v) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $v['id'])?>"><?php echo str_replace('\'', '', $v['question']) ?> - <?php echo $v['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select>\n' +
            '                                                   </div> \n' +
            '                                                                                                               <div class="sQues" style="display: none"><select name="x[question_id][]"  class="form-control selectBox sQues"  onchange="checkAnswer(this,\'s_question\')">\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($squesArr as $kV=>$Vv) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $Vv['id'])?>"><?php echo str_replace('\'', '', $Vv['question']) ?> - <?php echo $Vv['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select></div></td>'
        data += ' <td>\n' +
            '                                                            <select name="x[operator][]" class="form-control" required>\n' +
            '                                                                <option value="=">=</option>\n' +
            '                                                                <option value="!=">!=</option>\n' +
            '                                                                <option value="<">&lt;</option>\n' +
            '                                                                <option value=">">&gt;</option>\n' +
            '                                                                <option value="<=">&lt;=</option>\n' +
            '                                                                <option value=">=">&gt;=</option>\n' +
            '                                                                <option value="-">-</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>\n' +
            '                                                        <td>\n' +
            '                                                            <div id="newValue" style="display: none">\n' +
            '                                                                <input type="text" name="x[value][]" class="form-control">\n' +
            '                                                            </div>\n' +
            '                                                            <div id="existValue" style="display: none">\n' +
            '\n' +
            '                                                                <select name="x[value][]" class="form-control">\n' +
            '\n' +
            '                                                                </select>\n' +
            '                                                            </div>\n' +
            '                                                        </td>'
        data += '<td><select name="x[user_type][]" class="form-control" required>\n' +
            '                                                            <option value=\'\' selected disabled>-- Select --</option>\n' +
            '                                                            <option value="user">User</option>\n' +
            '                                                            <option value="spouse">Spouse</option>\n' +
            '                                                            <option value="both">Both</option>\n' +
            '                                                        </select></td>'

        data += '<td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td>'
        data += '</tr>'
        $('#appendQuesType3').append(data)
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color', 'transparent')
        $('.select2-container .select2-selection--single').css('border', 0)
    })


    $('#addMoreQues4').click(function () {
        let c = $('.trCountttt').length;
        let cname=$('.trCountttt td #existValue select').last().attr('name');
        let row=$('.trCountttt ').last().attr('id');
        let rc = ''
        if(row.length==10) {
            rc = row.charAt(row.length - 1);
        }
        else
        {
            rc = row.slice(-2);

        }
        rc=parseInt(rc)+1
        let cname2='';
        let c2=1;
        if(cname!==undefined) {
            cname2 = cname.split(']')
            c2 = parseInt(cname2[1].substr(1)) + 1
        }
        c++;

        var data = '<tr id="trCountttt' + rc + '" class="trCountttt"><td>\n' +
            '                                                            <select name="y[score_case][]" class="form-control sc" onchange="getLabels(this)" >\n' +
            '                                                                <option value="">-- Select Case --</option>\n' +
            '                                                                <option value="1">Label</option>\n' +
            '                                                                <option value="0">Value</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>'
        data += '<td>\n' +
            '                                                        <select name="y[question_type][]" class="form-control ques"onchange="question_type2(\'mQues\',\'sQues\',this)">\n' +
            '                                                            <option value="">-- Select Question Type --</option>\n' +
            '                                                            <option value="m_question">Main Question</option>\n' +
            '                                                            <option value="s_question">Sub Question</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>'


        data += '       <td><select name="a[tests][]" class="form-control tests" disabled\n' +
            '                                                                    style="display: none;">\n' +
            '                                                                <option value="">--Select Test--</option>\n' +
            '                                                                <option value="celpip">CELPIP</option>\n' +
            '                                                                <option value="ielts">IELTS</option>\n' +
            '                                                                <option value="tcf">TCF</option>\n' +
            '                                                                <option value="tef">TEF</option>\n' +
            '\n' +
            '                                                            </select>\n' +
            '                                                                                                                <div class="mQues" style="display: none"><select name="y[question_id][]"  class="form-control ques selectBox mQues" onchange="checkAnswer(this,\'m_question\')">>\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($quesArr as $k=>$v) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $v['id'])?>"><?php echo str_replace('\'', '', $v['question']) ?> - <?php echo $v['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select>\n' +
            '                                                   </div> \n' +
            '                                                                                                               <div class="sQues" style="display: none"><select name="y[question_id][]"  class="form-control ques selectBox sQues" onchange="checkAnswer(this,\'s_question\')"> >\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($squesArr as $kV=>$Vv) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $Vv['id'])?>"><?php echo str_replace('\'', '', $Vv['question']) ?> - <?php echo $Vv['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select></div></td>'
        data += ' <td>\n' +
            '                                                            <select name="y[operator][]" class="form-control" required>\n' +
            '                                                                <option value="=">=</option>\n' +
            '                                                                <option value="!=">!=</option>\n' +
            '                                                                <option value="<">&lt;</option>\n' +
            '                                                                <option value=">">&gt;</option>\n' +
            '                                                                <option value="<=">&lt;=</option>\n' +
            '                                                                <option value=">=">&gt;=</option>\n' +
            '                                                                <option value="-">-</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>\n' +
            '                                                        <td>\n' +
            '                                                            <div id="newValue" style="display: none">\n' +
            '                                                                <input type="text" name="y[value]['+c2+'][]" class="form-control">\n' +
            '                                                            </div>\n' +
            '                                                            <div id="existValue" style="display: none">\n' +
            '\n' +
            '                                                                <select name="y[value]['+c2+'][]" class="form-control">\n' +
            '\n' +
            '                                                                </select>\n' +
            '                                                            </div>\n' +
            '                                                        </td>'
        data += '<td><select name="y[user_type][]" class="form-control" required>\n' +
            '                                                            <option value=\'\' selected disabled>-- Select --</option>\n' +
            '                                                            <option value="user">User</option>\n' +
            '                                                            <option value="spouse">Spouse</option>\n' +
            '                                                            <option value="both">Both</option>\n' +
            '                                                        </select></td>'
        data += ' <td>\n' +
            '                                                            <select class="form-control" name="other[]" onchange="otherCase(this)">\n' +
            '                                                                <option value="" disabled selected>--Select--</option>\n' +
            '                                                                <option value="score">Score</option>\n' +
            '                                                                <option value="condition">Condition</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>\n' +
            '                                                        <td>\n' +
            '                                                            <input class="form-control abc" name="y[score_number][]" id="score" required style="display: none" disabled>\n' +
            '                                                            <select class="form-control abc" name="y[condition2][]" id="condition" style="display: none" disabled>\n' +
            '                                                                <option value="or">OR</option>\n' +
            '                                                                <option value="and">AND</option>\n' +
            '                                                            </select>\n' +
            '\n' +
            '                                                        </td>'
        data += '<td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td>'
        data += '</tr>'
        $('#appendQuesType4').append(data)
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color', 'transparent')
        $('.select2-container .select2-selection--single').css('border', 0)
    })

    $('#addMoreQues5').click(function () {
        let c = $('.trCounttttt').length;
        let row=$('.trCounttttt ').last().attr('id');
        let rc = ''
        if(row.length==12) {
            rc = row.charAt(row.length - 1);
        }
        else
        {
            rc = row.slice(-2);

        }
        rc=parseInt(rc)+1

        let cname=$('.trCounttttt td #existValue select').last().attr('name');
        let cname2='';
        let c2=1;
        if(cname!==undefined) {
            cname2 = cname.split(']')
            c2 = parseInt(cname2[1].substr(1)) + 1
        }
        c++;

        var data = '<tr id="trCounttttt' + rc + '" class="trCounttttt"><td> <select name="a[label_type][]" class="form-control label_type" required >\\n\' +\n' +
            '        \'                                                            <option value="user">User</option>\\n\' +\n' +
            '        \'                                                            <option value="spouse">Spouse</option>\\n\' +\n' +
            '        \'                                                            <option value="both">Both</option>\\n\' +\n' +
            '        \'                                                        </select></td><td>\n' +
            '                                                            <select name="a[score_case][]" class="form-control sc" onchange=getLabels(this)>\n' +
            '                                                                <option value="">-- Select Case --</option>\n' +
            '                                                                <option value="1">Label</option>\n' +
            '                                                                <option value="0">Value</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>'
        data +=
            '                                                    <td>\n' +
            '                                                       <select name="a[question_type][]" class="form-control ques"onchange="question_type(\'mQues\',\'sQues\',\'sType\',this)">\n' +
            '                                                            <option value="">-- Select Question Type --</option>\n' +
            '                                                            <option value="m_question">Main Question</option>\n' +
            '                                                            <option value="s_question">Sub Question</option>\n' +
            '                                                            <option value="score_type">Score Type</option>\n' +

            '                                                        </select>\n' +
            '                                                    </td>'


        data += '       <td><select name="a[tests][]" class="form-control tests" disabled style="display: none;">\n' +
            '                                                            <option value="">--Select Test--</option>\n' +
            '                                                            <option value="celpip">CELPIP</option>\n' +
            '                                                            <option value="ielts">IELTS</option>\n' +
            '                                                            <option value="tcf">TCF</option>\n' +
            '                                                            <option value="tef">TEF</option>\n' +
            '\n' +
            '                                                        </select>\n' +
            '                                                                                                                <div class="mQues" style="display: none"><select name="a[question_id][]"  class="ques form-control selectBox mQues" onchange="checkAnswer(this,\'m_question\')">>\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($quesArr as $k=>$v) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $v['id'])?>"><?php echo str_replace('\'', '', $v['question']) ?> - <?php echo $v['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select>\n' +
            '                                                   </div> \n' +
            '                                                                                                               <div class="sQues" style="display: none"><select name="a[question_id][]"  class="ques form-control selectBox sQues"  onchange="checkAnswer(this,\'s_question\')">>\n' +
            '                                                            <option value="" selected disabled>-- Select --</option>\n' +
            '                                                            <?php foreach($squesArr as $kV=>$Vv) { ?>\n' +
            '                                                                <option value="<?php echo str_replace('\'', '', $Vv['id'])?>"><?php echo str_replace('\'', '', $Vv['question']) ?> - <?php echo $Vv['id'] ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                        </select></div> <div class="ques sType" style="display: none">\n' +
            '                                                            <select name="a[question_id][]" class="form-control selectBox sType" required onchange="checkAnswer(this,\'score_type\')">\n' +
            '                                                                <option value="" selected disabled>-- Select --</option>\n' +
            '                                                                <?php foreach($scoretype as $kV=>$Vv) { ?>\n' +
            '                                                                    <option value="<?php echo $Vv['name']?>"><?php echo strtoupper($Vv['name']) ?></option>\n' +
            '                                                                <?php } ?>\n' +
            '                                                            </select>\n' +
            '                                                        </div></td>'
        data += ' <td>\n' +
            '                                                            <select name="a[operator][]" class="form-control" required>\n' +
            '                                                                <option value="=">=</option>\n' +
            '                                                                <option value="!=">!=</option>\n' +
            '                                                                <option value="<">&lt;</option>\n' +
            '                                                                <option value=">">&gt;</option>\n' +
            '                                                                <option value="<=">&lt;=</option>\n' +
            '                                                                <option value=">=">&gt;=</option>\n' +
            '                                                                <option value="-">-</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td>\n' +
            '                                                        <td>\n' +
            '                                                            <div id="newValue" style="display: none">\n' +
            '                                                                <input type="text" name="a[value][' + c2 + '][]" class="form-control">\n' +
            '                                                            </div>\n' +
            '                                                            <div id="existValue" style="display: none">\n' +
            '\n' +
            '                                                                <select name="a[value][' + c2 + '][]" class="form-control">\n' +
            '\n' +
            '                                                                </select>\n' +
            '                                                            </div>\n' +
            '                                                        </td>'
        data += '<td><select name="a[user_type][]" class="form-control" required>\n' +
            '                                                            <option value=\'\' selected disabled>-- Select --</option>\n' +
            '                                                            <option value="user">User</option>\n' +
            '                                                            <option value="spouse">Spouse</option>\n' +
            '                                                            <option value="both">Both</option>\n' +
            '                                                        </select></td>'

        data += ' <td>\n' +
            '                                                            <select class="form-control" name="other[]" onchange="otherCase(this)">\n' +
            '                                                                <option value="" disabled selected>--Select--</option>\n' +
            '                                                                <option value="score">Score</option>\n' +
            '                                                                <option value="condition">Condition</option>\n' +
            '                                                                <option value="question">Move to Question</option>\n' +
            '                                                                <option value="scoring">Move to Scoring</option>\n' +


            '                                                            </select>\n' +
            '                                                        </td>\n' +
            '                                                        <td>\n' +
            '                                                            <input class="form-control abc" name="a[score_number][]" id="score" required style="display: none" disabled>\n' +
            '                                                            <select class="form-control abc" name="a[condition2][]" id="condition" style="display: none" disabled>\n' +
            '                                                                <option value="or">OR</option>\n' +
            '                                                                <option value="and">AND</option>\n' +
            '                                                            </select>\n' +
            '\n' +
            '                                                        </td>'

        data += '<td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td>'
        data += '</tr>'
        $('#appendQuesType5').append(data)
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color', 'transparent')
        $('.select2-container .select2-selection--single').css('border', 0)
    })
    $('#addNoc').click(function () {
        let c = $('.nocRow').length;
        let cname=$('.nocRow td .mult').last().attr('name');
        let cname2='';
        let c2=1;
        if(cname!==undefined) {
            cname2 = cname.split(']')
            c2 = parseInt(cname2[1].substr(1)) + 1
        }
        c++;
        var data = '<tr id="nocRow' + c + '" class="nocRow">\n' +
            '\n' +
            '                                                    <td>\n' +
            '                                                        <select name="noc[noc_type][]" class="form-control" required>\n' +
            '                                                            <option value=\'\' selected disabled>-- Select --</option>\n' +
            '                                                            <option value="user">User</option>\n' +
            '                                                            <option value="spouse">Spouse</option>\n' +
            '                                                            <option value="both">Both</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n' +
            '                                                    <td>                                                            <input type="hidden" class="jobCheck" name="jobCheck[]" >\n\n' +
            '                                                        <input class="" type="checkbox" value="1" name="noc[job_offer][]" onchange="other_check(this,\'job\')">\n' +

            '\n' +
            '                                                    </td>\n' +
            '                                                    <td>                                                            <input type="hidden" class="empCheck" name="empCheck[]" >\n\n' +
            '                                                        <input class="" type="checkbox" value="1" name="noc[employment][]" onchange="other_check(this,\'emp\')">\n' +
            '\n' +
            '                                                    </td>  <td>\n' +
            '                                                            <input type="hidden" class="sameCheck" name="sameCheck[]" >\n' +
            '                                                            <input class="" type="checkbox" value="1" onchange="other_check(this,\'same\')"\n' +
            '                                                                   name="noc[same][]">\n' +
            '\n' +
            '                                                        </td> <td>\n' +
            '                                                            <select name="noc[noc_operator][]" class="form-control"\n' +
            '                                                                    required>\n' +
            '                                                                <option value="=">=</option>\n' +
            '                                                                <option value="!=">!=</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td><td>\n' +
            '                                                        <input class="form-control" name="noc[noc_number][]">\n' +
            '                                                    </td>\n' +
            '                                                    <td>                                                            <input type="hidden" class="skillCheck" name="skillCheck[]">\n\n' +
            '                                                        <select class="form-control" name="noc[skill][]" id="" onchange="other_check(this,\'skill\')">\n' +
            '                                                            <option value=""  selected disabled>--Select--</option>\n' +
            '                                                            <option value="low" >Low</option>\n' +
            '                                                            <option value="high" >High</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n' +
            '                                                    <td>\n' +
            '                                                        <select name="noc[operator][]" class="form-control" required>\n' +
            '                                                            <option value="=">=</option>\n' +
            '                                                            <option value="!=">!=</option>\n' +
            '                                                            <option value="<">&lt;</option>\n' +
            '                                                            <option value=">">&gt;</option>\n' +
            '                                                            <option value="<=">&lt;=</option>\n' +
            '                                                            <option value=">=">&gt;=</option>\n' +
            '                                                            <option value="-">-</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n' +
            '                                                    <td>\n' +
            '                                                        <input type="text" name="noc[value][]" class="form-control" >\n' +
            '                                                    </td> <td>\n' +
            '                                                        <select name="noc[country_operator][]" class="form-control" required>\n' +
            '                                                            <option value="=">=</option>\n' +
            '                                                            <option value="!=">!=</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n' +
            '                                                    <td>                                                            <input type="hidden" class="countryCheck" name="countryCheck[]">\n\n' +
            '                                                        <select name="noc[country][]" class="form-control selectBox" onchange="other_check(this,\'country\')">\n' +
            '                                                            <option value="" selected disabled>--Select--</option>\n' +
            '                                                            <?php foreach($country as $kV=>$Vv) { ?>\n' +
            '                                                                <option value="<?php echo $Vv['name']?>"><?php echo $Vv['name'] ?></option>\n' +
            '                                                            <?php } ?>\n' +
            '                                                        </select>\n' +
            '                                                    </td> <td>\n' +
            '                                                            <select name="noc[province_operator][]" class="form-control"\n' +
            '                                                                    required>\n' +
            '                                                                <option value="=">=</option>\n' +
            '                                                                <option value="!=">!=</option>\n' +
            '                                                            </select>\n' +
            '                                                        </td><td>\n' +
            '                                                        <select class="form-control valid mult nocSelect" multiple name="noc[province]['+c2+'][]">\n' +
            '                                                            <option value="" selected></option>\n' +
            '                                                            <option value="Alberta ">Alberta  </option>\n' +
            '                                                            <option value="British Columbia ">British Columbia  </option>\n' +
            '                                                            <option value="Manitoba ">Manitoba  </option>\n' +
            '                                                            <option value="New Brunswick ">New Brunswick  </option>\n' +
            '                                                            <option value="Newfoundland and Labrador ">Newfoundland and Labrador  </option>\n' +
            '                                                            <option value="Northwest Territories">Northwest Territories </option>\n' +
            '                                                            <option value="Nova Scotia ">Nova Scotia  </option>\n' +
            '                                                            <option value="Nunavut ">Nunavut  </option>\n' +
            '                                                            <option value="Ontario ">Ontario  </option>\n' +
            '                                                            <option value="Prince Edward Island">Prince Edward Island </option>\n' +
            '                                                            <option value="Quebec ">Quebec  </option>\n' +
            '                                                            <option value="Saskatchewan ">Saskatchewan  </option>\n' +
            '                                                            <option value="Yukon ">Yukon  </option></select>\n' +
            '                                                    </td>                                                             <td>\n'+
            '                                                                <select class="form-control mult nocSelect" data-live-search="true"  multiple name="noc[region]['+c2+'][]">\n'+
            '                                                            <option value="" selected></option>\n' +

            '                                                                    <option value="Alberni-Clayoquot">\n'+
            '                                                                        Alberni-Clayoquot (on Vancouver Island, includes Hot\n'+
            '                                                                        Springs Cove, Tofino, Ucluelet)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Bulkley-Nechako">\n'+
            '                                                                        Bulkley-Nechako (includes Fort Fraser, Kuldo, Manson\n'+
            '                                                                        Creek, Smithers, Vanderhoof)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Capital">\n'+
            '                                                                        Capital (includes Port Renfrew, Saanich, Sidney,\n'+
            '                                                                        Sooke, Victoria)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Cariboo">\n'+
            '                                                                        Cariboo (includes 100 Mile House, Nazko, Quesnel)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Central Coast">\n'+
            '                                                                        Central Coast (includes Atnarko, Bella Bella, Bella\n'+
            '                                                                        Coola, Dawson’s Landing, Kimsquit, King Island,\n'+
            '                                                                        Namu)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Central Kootenay">\n'+
            '                                                                        Central Kootenay (includes Castlegar, Creston,\n'+
            '                                                                        Poplar Creek, St Leon, Yahk)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Central Okanagan">\n'+
            '                                                                        Central Okanagan (includes Fintry, Kelowna, Lake\n'+
            '                                                                        Country, Peachland)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Columbia-Shuswap">\n'+
            '                                                                        Columbia-Shuswap (includes Golden, Mica Creek,\n'+
            '                                                                        Parson, Revelstoke, Salmon Arm, Trout Lake)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Comox Valley">\n'+
            '                                                                        Comox Valley (includes Black Creek, Fanny Bay,\n'+
            '                                                                        Hornby Island)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Cowichan Valley">\n'+
            '                                                                        Cowichan Valley (includes Clo-Oose, Duncan,\n'+
            '                                                                        Ladysmith, Mill Bay)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="East Kootenay">\n'+
            '                                                                        East Kootenay (includes Cranbrook, Kimberley, Radium\n'+
            '                                                                        Hot Springs)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Fraser-Fort George">\n'+
            '                                                                        Fraser-Fort George (includes Mackenzie, Prince\n'+
            '                                                                        George, Valemount)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Fraser Valley">\n'+
            '                                                                        Fraser Valley (includes Abbotsford, Boston Bar,\n'+
            '                                                                        Chilliwack, Hope)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Greater Vancouver">\n'+
            '                                                                        Greater Vancouver (Lower Mainland, including\n'+
            '                                                                        Coquitlam, Langley, Lions Bay, North Vancouver,\n'+
            '                                                                        Surrey, White Rock)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Kitimat-Stikine">\n'+
            '                                                                        Kitimat-Stikine (includes Hazelton, Iskut, Nisga’a,\n'+
            '                                                                        Terrace)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Kootenay-Boundary">\n'+
            '                                                                        Kootenay-Boundary (includes Beaverdell, Big White,\n'+
            '                                                                        Fruitvale, Grand Forks, Rock Creek, Rossland, Trail)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Mount Waddington">\n'+
            '                                                                        Mount Waddington (includes northernmost part of\n'+
            '                                                                        Vancouver Island, Gilford Island, Hopetown, Port\n'+
            '                                                                        Hardy, Thompson Sound, Woss)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Nanaimo ">Nanaimo</option>\n'+
            '                                                                    <option value="North Okanagan">\n'+
            '                                                                        North Okanagan (includes Armstrong, Enderby, Shuswap\n'+
            '                                                                        Falls, Vernon)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Northern Rockies">\n'+
            '                                                                        Northern Rockies (includes Fort Nelson, Kahntah,\n'+
            '                                                                        Liard River, Nelson Forks, Prophet River)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Okanagan-Similkameen">\n'+
            '                                                                        Okanagan-Similkameen (includes Copper Mountain,\n'+
            '                                                                        Osoyoos, Penticton, Princeton, Summerland)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Peace River">\n'+
            '                                                                        Peace River (includes Buckinghorse River Dawson\n'+
            '                                                                        Creek, Fort St John, Fort Ware)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Powell River">Powell River</option>\n'+
            '                                                                    <option value="Skeena-Queen Charlotte">\n'+
            '                                                                        Skeena-Queen Charlotte (includes Georgetown Mills,\n'+
            '                                                                        Graham Island, Haida Gwaii, Hartley Bay, Moresby\n'+
            '                                                                        Island, Pitt Island, Porcher Island)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Squamish-Lillooet">\n'+
            '                                                                        Squamish-Lillooet (includes Gold Bridge, Pavilion,\n'+
            '                                                                        Pemberton, Whistler)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Stikine">\n'+
            '                                                                        Stikine (northwestern BC, close to Alaska)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Strathcona">\n'+
            '                                                                        Strathcona (includes Campbell River, Gold River,\n'+
            '                                                                        Nootka Island, Roy, Sayward)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Sunshine Coast">\n'+
            '                                                                        Sunshine Coast (includes Gambier Island, Nelson\n'+
            '                                                                        Island, Secret Cove)\n'+
            '                                                                    </option>\n'+
            '                                                                    <option value="Thompson-Nicola">\n'+
            '                                                                        Thompson-Nicola (includes Blue River, Chase,\n'+
            '                                                                        Clinton, Merritt, Kamloops)\n'+
            '                                                                    </option> <option value="Winnipeg">\n' +
            '                                                                    Winnipeg\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Other location in Manitoba">\n' +
            '                                                                    Other location in Manitoba\n' +
            '                                                                </option> <option value="Timmins or Vernon">\n' +
            '                                                                    Timmins or Vernon\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Thunder Bay">\n' +
            '                                                                    Thunder Bay\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Sudbury">\n' +
            '                                                                    Sudbury\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Sault Ste Marie">\n' +
            '                                                                    Sault Ste Marie\n' +
            '                                                                </option>\n' +
            '                                                                <option value="North Bay">\n' +
            '                                                                    North Bay\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Moose Jaw">\n' +
            '                                                                    Moose Jaw\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Claresholm">\n' +
            '                                                                    Claresholm\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Brandon">\n' +
            '                                                                    Brandon\n' +
            '                                                                </option>\n' +
            '                                                                <option value="Altona/Rhineland">\n' +
            '                                                                    Altona/Rhineland\n' +
            '                                                                </option>\n'+
            '                                                                </select>\n'+
            '                                                            </td>\n\n<td>\n' +
            '                                                        <select name="noc[wage_operator][]" class="form-control">\n' +
            '                                                            <option value="=">=</option>\n' +
            '                                                            <option value="!=">!=</option>\n' +
            '                                                            <option value="<">&lt;</option>\n' +
            '                                                            <option value=">">&gt;</option>\n' +
            '                                                            <option value="<=">&lt;=</option>\n' +
            '                                                            <option value=">=">&gt;=</option>\n' +
            '                                                            <option value="-">-</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n' +
            '                                                    <td>\n' +
            '                                                        <input type="text" name="noc[wage][]" class="form-control" >\n' +
            '                                                    </td><td>\n' +
            '                                                        <select name="noc[hours_operator][]" class="form-control">\n' +
            '                                                            <option value="=">=</option>\n' +
            '                                                            <option value="!=">!=</option>\n' +
            '                                                            <option value="<">&lt;</option>\n' +
            '                                                            <option value=">">&gt;</option>\n' +
            '                                                            <option value="<=">&lt;=</option>\n' +
            '                                                            <option value=">=">&gt;=</option>\n' +
            '                                                            <option value="-">-</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n' +
            '                                                    <td>\n' +
            '                                                        <input type="text" name="noc[hours][]" class="form-control" >\n' +
            '                                                    </td>\n' +
            '                                                    <td>\n' +
            '                                                        <select name="noc[authorization][' + c2 + '][]"  multiple data-live-search="true" class="form-control mult nocSelect">\n' +
            '                                                            <option value="" selected ></option>\n' +
            '                                                            <option value="Open work permit">Open work permit</option>\n' +
            '                                                            <option value="LMIA based work permit">LMIA based work permit</option>\n' +
            '                                                            <option value="Other employer specific work permit">Other employer specific work permit</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td> <td>\n' +
            '                                                            <input type="number" name="noc[previous_years][]"\n' +
            '                                                                   class="form-control">\n' +
            '                                                        </td><td>\n' +
            '                                                        <select name="noc[user_type][]" class="form-control" required>\n' +
            '                                                            <option value=\'\' selected disabled>--Select--</option>\n' +
            '                                                            <option value="user">User</option>\n' +
            '                                                            <option value="spouse">Spouse</option>\n' +
            '                                                            <option value="both">Both</option>\n' +
            '                                                        </select>\n' +
            '                                                    </td><td>\n' +
            '                                                        <input type="text" name="noc[score_number][]" class="form-control">\n' +
            '                                                    </td><td>\n' +
            '                                                        <select class="form-control" name="noc[conditionn][]" id="" onchange="otherCase2(this)">\n' +
            '                                                            <option value="" disabled selected>--Select--</option>\n' +
            '                                                            <option value="or" >OR</option>\n' +
            '                                                            <option value="and" >AND</option>\n' +
            '                                                            <option value="question" >Move to Question</option>\n' +
            '\n' +
            '                                                        </select>\n' +
            '                                                    </td>\n'
        data += '<td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td>'
        data += '</tr>'
        $('#appendNoc').append(data)
        $(".nocSelect").each(function () {
            $(this).find('option').eq(0).hide()
        });
        $('.mult').selectpicker()
        $('.selectBox').select2();
        $('.select2-container').addClass('customSelect')
        $('.select2-container .select2-selection--single').css('background-color', 'transparent')
        $('.select2-container .select2-selection--single').css('border', 0)

    })


    $("#addMoreMulti").on('click', function () {
        var totalRowCount = $("#appendQuesType tr").length;

        var QuesHTML = '<tr id="trCount' + totalRowCount + '"><td><select name="c[operator][]" class="form-control valid" required=""><option value="=">=</option><option value="!=">!=</option><option value="<">&lt;</option><option value=">">&gt;</option><option value="<=">&lt;=</option><option value=">=">&gt;=</option><option value="-">-</option> </select></td><td><input type="text" name="c[value][]" class="form-control"></td><td><input type="text" name="c[score_number][]" class="form-control"></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>';
        $("#appendQuesType").append(QuesHTML);
    });

    $('#validateForm').validate({
        submitHandler: function () {
            'use strict';
            $("#AddLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
            $('#AddLoader').attr('disabled', true)

            $.ajax({
                dataType: 'json',
                url: "ajax.php?h=addScore",
                type: 'POST',
                data: $("#validateForm").serialize(),
                success: function (data) {
                    $("#AddLoader").html('Submit');
                    $('#AddLoader').attr('disabled', false)

                    $("div.prompt").show();
                    if (data.Success === 'true') {
                        // window.location.assign("/admin/scoring");
                        console.log(data.data)
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 5000);
                        $("#validateForm").trigger('reset')
                    } else {
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 5000);

                    }

                }
            });

            return false;
        }
    });


    $('#EvalidateForm').validate({
        submitHandler: function () {
            'use strict';
            $("#AddLoaderE").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
            $('#AddLoaderE').attr('disabled', true)

            $.ajax({
                dataType: 'json',
                url: "ajax.php?h=addScore",
                type: 'POST',
                data: $("#EvalidateForm").serialize(),
                success: function (data) {
                    $("#AddLoaderE").html('Update Score');
                    $('#AddLoaderE').attr('disabled', false)

                    $("div.prompt").show();
                    if (data.Success === 'true') {
                        console.log(data.data)
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 5000);
                    } else {
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 5000);

                    }

                }
            });

            return false;
        }
    });

    $('#gvalidateForm').validate({
        submitHandler: function () {
            'use strict';
            $("#groupLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
            $.ajax({
                dataType: 'json',
                url: "ajax.php?h=addSubGroup",
                type: 'POST',
                data: $("#gvalidateForm").serialize(),
                success: function (data) {
                    $("#groupLoader").html('Submit');
                    $("#gvalidateForm").trigger('reset')
                    $("div.prompt").show();
                    if (data.Success === 'true') {
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").html('');
                            $('.closee').click()
                        }, 1000);
                    } else {
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 5000);

                    }

                }
            });

            return false;
        }
    });

    $('#tvalidateForm').validate({
        submitHandler: function () {
            'use strict';
            $("#typeLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
            $.ajax({
                dataType: 'json',
                url: "ajax.php?h=addScoreType",
                type: 'POST',
                data: $("#tvalidateForm").serialize(),
                success: function (data) {
                    $("#typeLoader").html('Submit');
                    $("#tvalidateForm").trigger('reset')
                    $("div.prompt").show();
                    if (data.Success === 'true') {
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $('.closee').click()
                            $("div.prompt").html('');

                        }, 1000);
                    } else {
                        $(window).scrollTop(0);
                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 1000);

                    }

                }
            });

            return false;
        }
    });


    $("#delLoader").on('click', function () {
        var id = $("#did").val();
        $("#delLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=deleteScore",
            type: 'POST',
            data: {'id': id},
            success: function (data) {
                if (data.Success == 'true') {
                    $("#delLoader").html('Delete');
                    window.location.assign("/admin/scoring");
                } else {
                    $("#delLoader").html('Delete Question');
                    $(window).scrollTop(0);
                    $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>');
                    setTimeout(function () {
                        $("div.prompt").hide();
                    }, 5000);
                }
            }
        });
    });

    function DeleteModal(id) {
        $("#did").val(id);
        $("#deleteModal").modal();
    }


    function GenLabel(label) {
        var fieldtype = $("#fieldtype").val();
        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=getFields",
            type: 'POST',
            data: {'id': fieldtype},
            success: function (data) {
                var labelType = $("input.eLabelType:checked").val();
                if (data.data.type == 'radio') {
                    $("#radioFields").show();
                    $("#multiSelectBox").hide();
                    if (label == 'edit' && labelType == 1) {
                        $("#labelTypeBox").show();
                    } else if (label == 'edit' && labelType == 0) {
                        $("#labelDefaultBox").show();
                    }

                } else if (data.data.type == 'multi-select') {
                    $("#multiSelectBox").show();
                    $("#radioFields").hide();
                    if (label == 'edit') {
                        $("#labelTypeBox").show();
                    }

                } else if (data.data.type == 'dropdown') {
                    $("#multiSelectBox").show();
                    $("#radioFields").hide();
                    if (label == 'edit') {
                        $("#labelTypeBox").show();
                    }

                } else if (data.data.type == 'email' || data.data.type == 'phone' || data.data.type == 'text') {
                    $("#multiSelectBox").hide();
                    $("#radioFields").hide();
                    if (label == 'edit') {
                        $("#labelTypeBox").hide();
                    }
                    $("#labelDefaultBox").hide();

                } else {
                    $("#multiSelectBox").hide();
                    $("#radioFields").hide();
                    if (label == 'edit') {
                        $("#labelTypeBox").hide();
                    }
                    $("#labelDefaultBox").hide();

                    $(".EappendLabel").empty();
                }
            }
        });
    }

    $(".labelType").on('click', function () {
        var labelType = $(this).val();
        if (labelType == 1) {
            $("#labelTypeBox").show();
            ("#labelDefaultBox").hide();
        } else {
            $("#labelTypeBox").hide();
            $("#labelDefaultBox").show();
        }
    });

    $(".eLabelType").on('click', function () {
        var labelType = $(this).val();
        if (labelType == 1) {
            $("#labelTypeBox").show();
            $("#labelDefaultBox").hide();
        } else {
            $("#labelTypeBox").hide();
            $("#labelDefaultBox").show();
            $(".EappendLabel").empty();
        }
    });

    var fieldHTML = '<tr><td><input type="text" name="m[label][]" class="form-control"></td><td><input type="text" name="m[value][]" class="form-control"></td><td><select name="m[status][]" class="form-control" required><option value="1">Enable</option><option value="0">DisabBy Default Disablele</option></select></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>'; //New input field html

    $("#addMoreLabel").on('click', function () {
        $("#appendLabel").append(fieldHTML); //Add field html
    });

    $("#addMoreDrop").on('click', function () {
        $("#appendLabelMulti").append(fieldHTML);
    });

    $(document).on('click', '.remove_button', function (e) {
        e.preventDefault();
        $(this).closest("tr").remove();
        //x--; //Decrement field counter
    });
    $('#notes').change(function () {
        if ($(this).is(":checked")) {
            $('#notes_text').show()
        } else {
            $('#notes_text').hide()
            $('#notes_text').val('')
        }
    })

    function checkAnswer(val, type) {
        var existing_qid = $(val).val();
        var trID = $(val).closest('tr').prop('id');
        var sCase = $("#" + trID + " .sc").val()


        if (type == 'score_type') {
            $("#" + trID + " #existValue").hide();
            $("#" + trID + " #existValue").children('select').attr('disabled', true);
            $("#" + trID + " #newValue").children('input').attr('disabled', false);
            $("#" + trID + " .existingValues").remove();
            $("#" + trID + " #newValue").show();
        }
        else {

            if (sCase == 0) {
                if (type == 'm_question' || type == 0) {
                    var url = "ajax.php?h=getQuestion";
                } else {
                    var url = "ajax.php?h=getSubQuestion";
                }

                $("#" + trID + " #loaderAns").html('<span class="spinner-border spinner-border-sm" role="status"></span>');
                $.ajax({
                    dataType: 'json',
                    url: url,
                    type: 'POST',
                    data: {
                        'id': existing_qid
                    },
                    success: function (data) {
                        $("#" + trID + " #loaderAns").html('');
                        var fieldHTML = '';
                        $("#" + trID + " .existingValues").remove();


                        $("#" + trID + " #existValue select").attr('multiple', false)
                        $("#" + trID + " #existValue select").selectpicker('destroy')

                        $("#" + trID + " #existValue select").empty();
                        if (data.data.field == 'radio' && data.data.labeltype == 0) {
                            $("#" + trID + " #newValue").hide();
                            $("#" + trID + " #newValue").children('input').attr('disabled', true);
                            $("#" + trID + " #existValue").children('select').attr('disabled', false);


                            fieldHTML += '<option value="Yes">Yes</option><option value="No">No</option><option value="None">None</option>';
                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                            $("#" + trID + " #existValue").show();

                        } else if ((data.data.field == 'radio' && data.data.labeltype == 1) || data.data.field == 'dropdown' || data.data.field == 'country') {
                            $("#" + trID + " #newValue").hide();
                            $("#" + trID + " #newValue").children('input').attr('disabled', true);
                            $("#" + trID + " #existValue").children('select').attr('disabled', false);

                            if(data.data.field == 'country')
                            {
                                for (var i = 0; i < data.Options.length; i++) {
                                    fieldHTML += '<option value="' + data.Options[i].name + '">' + data.Options[i].name + '</option>';

                                }
                            }
                            else
                            {
                                for (var i = 0; i < data.Options.length; i++) {
                                    if (data.Options[i].value !== '') {
                                        fieldHTML += '<option value="' + data.Options[i].value + '">' + data.Options[i].value + '</option>';
                                    }
                                }
                            }

                            // fieldHTML += '<option value="None">None</option>';
                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                            $("#" + trID + " #existValue").show();


                            $("#" + trID + " #existValue select").attr('multiple', true)
                            // $("#" + trID + " #existValue select").attr('data-container', '#both')
                            $("#" + trID + " #existValue select").selectpicker()
                        } else {
                            fieldHTML += '<option value="#NO#">No Value Assigned</option>';
                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                            $("#" + trID + " #existValue").hide();
                            $("#" + trID + " #existValue").children('select').attr('disabled', true);
                            $("#" + trID + " #newValue").children('input').attr('disabled', false);


                            $("#" + trID + " #newValue").show();
                        }
                    }
                });
            } else {
                $.ajax({
                    dataType: 'json',
                    url: 'ajax.php?h=score_label',
                    type: 'POST',
                    data: {
                        'id': existing_qid
                    },
                    success: function (data) {
                        $("#" + trID + " #loaderAns").html('');
                        var fieldHTML = '';

                        $("#" + trID + " #existValue select").empty();
                        $("#" + trID + " .existingValues").remove();

                        if (data.Options.length > 0) {
                            $("#" + trID + " #newValue").hide();
                            $("#" + trID + " #newValue").children('input').attr('disabled', true);
                            $("#" + trID + " #existValue").children('select').attr('disabled', false);

                            for (var i = 0; i < data.Options.length; i++) {
                                if (data.Options[i].score_number !== '') {
                                    fieldHTML += '<option value="' + data.Options[i].score_number + '">' + data.Options[i].score_number + '</option>';
                                }
                            }
                            $("#" + trID + " #existValue select").append(fieldHTML); //Add field html
                            $("#" + trID + " #existValue").show();
                        } else {
                            $("#" + trID + " #existValue").hide();
                            $("#" + trID + " #existValue").children('select').attr('disabled', true);
                            $("#" + trID + " #newValue").children('input').attr('disabled', false);
                            $("#" + trID + " #newValue").show();
                        }
                    }
                });

            }
        }
    }

    $('.noc').change(function () {
        if ($(this).val() == 1) {
            $('#nocDiv').show()
        } else {
            $('#nocDiv').hide()
        }
    })

    function getLabels(val) {
        var label = $(val).val();
        $(val).closest('tr').find(".existingValues").remove();
        var data = '         <option value="0r">0r</option>\n' +
            '                                                                <option value="2r">2r</option>\n' +
            '                                                                <option value="3r">3r</option>\n' +
            '                                                                <option value="4r">4r</option>\n' +
            '                                                                <option value="5r">5r</option>\n' +
            '                                                                <option value="6r">6r</option>\n' +
            '                                                                <option value="7r">7r</option>\n' +
            '                                                                <option value="8r">8r</option>\n' +
            '                                                                <option value="9r">9r</option>\n' +
            '                                                                <option value="10r">10r</option>\n' +
            '\n' +
            '\n' +
            '                                                                <option value="0l">0l</option>\n' +
            '                                                                <option value="2l">2l</option>\n' +
            '                                                                <option value="3l">3l</option>\n' +
            '                                                                <option value="4l">4l</option>\n' +
            '                                                                <option value="5l">5l</option>\n' +
            '                                                                <option value="6l">6l</option>\n' +
            '                                                                <option value="7l">7l</option>\n' +
            '                                                                <option value="8l">8l</option>\n' +
            '                                                                <option value="9l">9l</option>\n' +
            '                                                                <option value="10l">10l</option>\n' +
            '\n' +
            '                                                                <option value="0w">0w</option>\n' +
            '                                                                <option value="2w">2w</option>\n' +
            '                                                                <option value="3w">3w</option>\n' +
            '                                                                <option value="4w">4w</option>\n' +
            '                                                                <option value="5w">5w</option>\n' +
            '                                                                <option value="6w">6w</option>\n' +
            '                                                                <option value="7w">7w</option>\n' +
            '                                                                <option value="8w">8w</option>\n' +
            '                                                                <option value="9w">9w</option>\n' +
            '                                                                <option value="10w">10w</option>\n' +
            '\n' +
            '\n' +
            '                                                                <option value="0s">0s</option>\n' +
            '                                                                <option value="2s">2s</option>\n' +
            '                                                                <option value="3s">3s</option>\n' +
            '                                                                <option value="4s">4s</option>\n' +
            '                                                                <option value="5s">5s</option>\n' +
            '                                                                <option value="6s">6s</option>\n' +
            '                                                                <option value="7s">7s</option>\n' +
            '                                                                <option value="8s">8s</option>\n' +
            '                                                                <option value="9s">9s</option>\n' +
            '                                                                <option value="10s">10s</option>'
        if (label == 1) {
            $(val).closest('tr').find('td .tests').prop('disabled', false);
            $(val).closest('tr').find('td .tests').show();

            $(val).closest('tr').find('.no_tests').hide();
            // $(val).closest('tr').find('td .ques').hide()
            $(val).closest('tr').find('td .ques').prop('disabled', true);
            $(val).closest('tr').find('#existValue select').prop('disabled', false);
            $(val).closest('tr').find(" #existValue select").append(data); //Add field html
            $(val).closest('tr').find(" #existValue").show();
            $(val).closest('tr').find(" #existValue select").attr('multiple', true)
            // $(val).closest('tr').find(" #existValue select").attr('data-container', '#both')

            $(val).closest('tr').find(" #existValue select").selectpicker()

            $(val).closest('tr').find(" #newValue").children('input').attr('disabled', true);
            $(val).closest('tr').find(" #newValue").hide();
            // $(val).closest('tr').find(" .label_type").show();
            // $(val).closest('tr').find(" .label_type").prop('disabled',false);

        } else {
            // $(val).closest('tr').find(" .label_type").hide();
            // $(val).closest('tr').find(" .label_type").prop('disabled',true);
            //
            // $(val).closest('tr').find('td .ques').show()

            $(val).closest('tr').find('td .tests').prop('disabled', true);
            $(val).closest('tr').find('td .tests').hide();
            $(val).closest('tr').find('td .ques').prop('disabled', false);
            $(val).closest('tr').find(" #existValue select").html(''); //Add field html
            $(val).closest('tr').find(" #existValue").hide();

        }

    }

    function getQuestion(main, sub, value) {
        $('.q_lbl').show()
        if ($(value).val() == 'm_question') {
            $("#" + main).show();
            $("#" + sub).hide();
            $("#" + sub).find('select').attr('disabled', true);
            $("#" + main).find('select').attr('disabled', false);


        } else {
            $("#" + main).hide();
            $("#" + sub).show();
            $("#" + sub).find('select').attr('disabled', false);
            $("#" + main).find('select').attr('disabled', true);
        }
    }
</script>

</body>

</html>