<?php
if(!isset($_COOKIE["Lang"]))
{
    setcookie("Lang", "english");
    setcookie("oldLang", "english");
    header('Location: '.$_SERVER['REQUEST_URI']);
}
include_once("global.php");
include_once("function.php");

$getForms = mysqli_query($conn , "SELECT * FROM categories WHERE id = '{$_GET['id']}'");
$frmData = mysqli_fetch_assoc($getForms);

$getFieldTypes = mysqli_query($conn , "SELECT * FROM field_types");
$fldArr = array();
while($fld = mysqli_fetch_assoc($getFieldTypes)){
    $fldArr[$fld['id']] = $fld;
}



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta description -->
    <meta name="description"
          content="BizBite corporate business template or agency and marketing template helps you easily create websites for your business.">
    <meta name="author" content="ThemeTags">


    <meta property="og:type" content="article"/>

    <!--title-->
    <title>Form | Consultation</title>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" />
    <?php include_once("style.php"); ?>
    <link href="css/datepicker.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="css/bootstrap-tagsinput.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
    <style>

    </style>

</head>

<body>
<div id="formLoader">
    <span class="loader"><span class="loader-inner"></span></span>
</div>
<div id="preloader" style="display: none">
    <label class="score_loading"></label>
    <div class="loader1">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>
<?php include_once("header.php"); ?>

<!--body content wrap start-->

<div class="main">

    <!--header section start-->
    <section class="hero-section ptb-100 gradient-overlay"
             style="background: url('img/header-bg-5.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">

                </div>
            </div>
        </div>
    </section>
    <!--header section end-->

    <!--promo block with hover effect start-->
    <section class="promo-block ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 col-md-2 col-lg-3"></div>
                <div class="col-sm-12 col-md-8 col-lg-6">
                    <div class="card login-signup-card shadow-lg mb-0">
                        <div class="card-body px-md-5 py-5">
                            <div class="mb-5">
                                <h5 class="h3"><?php  $frmData['name']; ?></h5>
                                <p class="text-muted mb-0">Let's Start to Join.</p>
                            </div>

                            <!--login form-->
                            <form class="login-signup-form quesCreate myForm" id="validateform" >
                                <div class="prompt">
                                    <?php
                                    if(isset($_SESSION['msg']))
                                    {
                                        ?>
                                        <div class="alert alert-<?php echo $_SESSION['class'] ?>"><?php echo $_SESSION['msg'] ?></div>
                                        <?php

                                        unset($_SESSION['msg']);
                                        unset($_SESSION['class']);

                                    }
                                    ?>
                                </div>
                                <div class="prompt2">
                                </div>
                                <div class="formDiv">
                                    <?php
                                    $i=0;
                                    $getQuestions = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '{$_GET['id']}' AND status = 1 and submission_type='before'");
                                    while($row = mysqli_fetch_assoc($getQuestions)) {
                                        $permission='';
                                        if($row['permission']==1)
                                        {
                                            $permission='permitted';
                                        }
                                        else
                                        {
                                            $permission='forbidden';
                                        }
                                        ?>
                                        <div class="main_parent_<?php echo $row['id'] ?> parent_question">
                                            <div class="form-group main_question_div" id="question_div_<?php echo $row['id'] ?>">
                                                <label class="pb-1"><?php if(translateVal($row['question']) == ''){ echo $row['question']; } else { echo translateVal($row['question']); }?></label>

                                                <?php if ($row['notes']!='' && $fldArr[$row['fieldtype']]['type'] != 'pass') { ?>
                                                    <?php
                                                    $notes=$row['notes'];
                                                    if(notesVal($notes) != '')
                                                    {
                                                        $notes=notesVal($notes);
                                                    }
                                                    ?>
                                                    <p class="notesPara2" ><?php echo $notes ?></p>
                                                <?php } ?>
                                                <div class="input-group input-group-merge <?php echo $permission ?>">

                                                    <?php if($fldArr[$row['fieldtype']]['type'] == 'calender') { ?>
                                                        <input type="text" class="form-control datepicker" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'nocjob') { ?>
                                                        <div class="bs-example">
                                                            <input type="text" value="" class="tagsInp form-control jobs" data-role="tagsinput" data-type="jobs" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?> >
                                                        </div>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'nocduty') { ?>
                                                        <div class="bs-example">
                                                            <input type="text" value="" class="tagsInp form-control duty" data-role="tagsinput" data-type="duty" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?> >
                                                        </div>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'age') { ?>
                                                        <input type="text" class="form-control datepicker age" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                        <input type="text" class="form-control dob" readonly hidden name="dob*<?php echo $row['id']; ?>" >

                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'email') { ?>
                                                        <input type="email" class="form-control" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'radio' && $row['labeltype'] == 0) { ?>
                                                        <input id="Yes_<?php echo $row['id'] ?>" type="radio" class="radioButton" name="n[question_<?php echo $row['id']; ?>]" onClick="getQuestion(this,'<?php echo $row['id']; ?>')" <?php echo $row['validation']; ?> value="Yes"><span class="customLabel" >Yes</span>
                                                        <input id="No_<?php echo $row['id'] ?>" type="radio" class="radioButton" name="n[question_<?php echo $row['id']; ?>]" onClick="getQuestion(this,'<?php echo $row['id']; ?>')" value="No"><span class="customLabel">No</span>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'radio' && $row['labeltype'] == 1) {
                                                        $getLabels=mysqli_query($conn,"select * from question_labels where question_id={$row['id']} ");
                                                        while($row_label = mysqli_fetch_assoc($getLabels)) {
                                                            ?>
                                                            <input type="radio" class="radioButton" name="n[question_<?php echo $row['id']; ?>]" onClick="getQuestion(this,'<?php echo $row['id']; ?>')" value="<?php echo $row_label['value'] ?>" <?php echo $row['validation']; ?>><span class="customLabel" ><?php echo $row_label['label'] ?></span>
                                                        <?php }} else if($fldArr[$row['fieldtype']]['type'] == 'dropdown') { ?>
                                                        <select name="n[question_<?php echo $row['id']; ?>]" class="form-control" onchange="getQuestion(this,'<?php echo $row['id']; ?>')" <?php echo $row['validation']; ?>>
                                                            <option value="" disabled selected>-- Select --</option>
                                                            <?php
                                                            $getLabels=mysqli_query($conn,"select * from question_labels where question_id={$row['id']} and label!='' ");
                                                            while($row_label = mysqli_fetch_assoc($getLabels)) {
                                                                ?>
                                                                <option value="<?php echo $row_label['value'] ?>"><?php echo $row_label['label'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'country') { ?>
                                                        <select name="n[question_<?php echo $row['id']; ?>]" class="form-control countryCheck" onchange="getQuestion(this,'<?php echo $row['id']; ?>')" <?php echo $row['validation']; ?>>
                                                            <option value="" disabled selected>-- Select --</option>
                                                            <?php
                                                            foreach ($countryArray as $c){
                                                                ?>

                                                                <option value="<?php echo $c['value'] ?>"><?php echo $c['name'] ?></option>

                                                            <?php } ?>
                                                        </select>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'education') { ?>
                                                        <select name="n[question_<?php echo $row['id']; ?>]" class="form-control" onchange="getQuestion(this,'<?php echo $row['id']; ?>')" <?php echo $row['validation']; ?>>
                                                            <option value="" disabled selected>-- Select --</option>
                                                            <?php
                                                            foreach ($educationArray as $c){
                                                                ?>

                                                                <option value="<?php echo $c['value'] ?>"><?php echo $c['name'] ?></option>

                                                            <?php } ?>
                                                        </select>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'phone') { ?>
                                                        <input type="tel" onkeyup="validate(this)"  minlength="6" maxlength="15" class="form-control" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'pass') { ?>
                                                        <label class="notesPara2"><?php  echo $row['notes']; ?></label>
                                                    <?php } else if($fldArr[$row['fieldtype']]['type'] == 'currentrange') { ?>
                                                        <label class='pb-date'>From</label><label class='pb-date'>To</label>
                                                        <input type="date" data-id="from" class="form-control"  name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                        <input type="date" data-id="to" class="form-control" onchange="if(checkDate(this)) {getQuestion(this,'<?php echo $row['id']; ?>') }" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                        <div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this,"<?php echo $row['id']; ?>")'><span class='presentCheckbox'>Present</span></div>
                                                    <?php } else { ?>
                                                        <input type="text" class="form-control" onfocusout="getQuestion(this,'<?php echo $row['id']; ?>')" name="n[question_<?php echo $row['id']; ?>]" <?php echo $row['validation']; ?>>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Password -->
                                        <?php $i++; } ?>
                                </div>
                                <!-- Submit -->
                                                                <div class="row btnBox">
                                                                    <div class="col-sm-6 text-left"><button type="button" class="btn btn-sm  prevDiv" style="display: none;"><i class="fa fa-arrow-left"></i> Previous</button></div>
                                                                    <div class="col-sm-6 text-right"> <button type="button" class="btn btn-sm  nextDiv" style="display: inline-block;">Next <i class="fa fa-arrow-right"></i></button></div>
                                                                </div>
                                <div class="row" id="lastBox" style="display: none">

                                    <div class="col-sm-6">
                                        <div class="form-group2">
                                            <div class="custom-control custom-checkbox terms">
                                                <input type="checkbox" class="custom-control-input" id="terms">
                                                <label class="custom-control-label" for="terms">I agree</label>
                                            </div>
                                            <p class="error" id="tError" style="display: none;color: red;">This field is required</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group2">
                                            <a href="terms.php" class="terms">Terms & Conditions</a>
                                        </div>
                                    </div>

                                    <button class="btn btn-block secondary-solid-btn border-radius mt-4 mb-3" id="btnLoader">
                                        <label>Submit</label>
                                    </button>
                                </div>


                            </form>
                            <input type="hidden" id="scoreID">
                            <input type="hidden" id="submitCheck">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--promo block with hover effect end-->


</div>
<!--body content wrap end-->

<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Consultation</h5>
            </div>
            <div class="modal-body">
                Would you like to send this question's answer via email ?
                <input type="hidden" id="ques">
                <input type="hidden" id="ans">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal" id="noBtn" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary btnModal2" id="yesBtn">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="endModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Congratulations</h5>
            </div>
            <div class="modal-body" id="endBody">
                Thank you for the interest in Canada.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal" data-dismiss="modal">Ok</button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
            </div>
            <div class="modal-body">
                There was an error handling your request please try again.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btnModal" data-dismiss="modal">Ok</button>
                <!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<button  hidden type="button" id="btnModal" class="btn btn-primary" data-toggle="modal" data-target="#endModal">
    Launch demo modal
</button>
<button  hidden type="button" id="btnModal2" class="btn btn-primary" data-toggle="modal" data-target="#warningModal">
    Launch demo modal
</button>
<?php include_once("footer.php"); ?>


<?php include_once("script.php"); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.15.0/lodash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>


<script src="js/moment.js" type="text/javascript"></script>
<script src="js/datepicker.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.2.20/angular.min.js"></script>
<script src="js/bootstrap-tagsinput.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
<script src="js/lang.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

<script>

    function validate(phone) {
        var phnVal = $(phone).val();
        // var forName = $(phone).attr('name');
        // console.log(forName);
        // var regex = /^\+(?:[0-9] ?){10,13}[0-9]$/;
        //
        // setTimeout(function(){
        //     if (regex.test(phnVal)) {
        //         $("label[for='"+forName+"']").hide();
        //     } else {
        //         $("label[for='"+forName+"']").show();
        //         $("label[for='"+forName+"']").html('Please enter a valid phone number using this format (+000000000000)');
        //     }
        // },1000);
    }


    var years=0;
    var count = {};
    var countCheck = {};
    var cv,gv,hv,cf,cq,co='';
    var email_ques=[];

    var checkField=new Array();
    var hiddenQues=new Array();
    var checkValue=new Array();
    var checkQues= new Array();
    var checkOp= new Array();
    var bbb=false;

    var scoreArray= new Array()
    var scoreArray2= new Array()

    var nocArray= new Array()
    var rType='';
    var dateArray=new Array();
    var dateCheck=0;
    var dateCheck2=0;

    var nocUser= new Array();
    var nocSpouse= new Array();

    var fromDate;
    var toDate;
    var up1='',up2='',up3='',up4='',up5='',job='',up='';

    var lArray=[];
    var sArr = [];
    var currentRequest='';
    var req_check=false;

    var disCl = '';

    var jobsArr = [] , dutyArr = [];
    var jobLen = 0 , dutyLen = 0;

    var quesArr = [] , notesArr = [] , optionsArr = [] , ArrCountry = [] ;

    $(document).ready(function () {



        $('.prompt').html('')

        if(localStorage.getItem('display') == 'Right to Left'){
            disCl = 'rightToLeft';
        }else{
            disCl = 'leftToRight';
        }

        var newArr = new Array()
        for (var key in localStorage)
        {
            if(key[0]=='n' || key[0]=='f')
            {
                newArr[key]=localStorage.getItem(key)
            }
            if(key[0]=='s')
            {
                sArr.push(localStorage.getItem(key));
            }
            if(key[0]=='m')
            {
                lArray.push(parseInt(localStorage.getItem(key)));
            }
        }
        sArr.forEach(function (i) {

            count[i] = (count[i] || 0) + 1;

        });

        setTimeout( function () {
            $( "div.prompt" ).hide();
        }, 5000 );

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getNocJobs",
            type: 'POST',
            success: function ( data ) {
                jobsArr = data.jobsArr;
                jobLen = data.jobsLength;

                dutyArr = data.dutyArr;
                dutyLen = data.dutyLen;

                // console.log('nocJobs Length:'+jobLen);
                // console.log('nocJobs Array:'+jobsArr);
            }
            ,
            error:function (data) {

            }
        });

        if(localStorage.getItem('oldFlag') !== localStorage.getItem('newFlag') ) {
            $.ajax({
                dataType: 'json',
                url: "lang.php?h=getTranslationArr",
                type: 'POST',
                success: function (data) {
                    quesArr = data.questArr;
                    notesArr = data.notesArr;
                    optionsArr = data.optionsArr;
                    ArrCountry = data.ArrCountry;
                    setTimeout(function () {
                        callTranslations();
                        $('#formLoader').hide();
                    }, 5000);


                }
                ,
                error: function (data) {

                }
            });
        }
    })

    $(document).on('change','#language-picker-select',function () {
        localStorage.setItem('newFlag',1)
    })


    $(document).on('focus', '.datepicker', function(){

        let d= new Date();
        let d1= moment().subtract(10, 'years').calendar();
        d= new Date(d1)
        let month = (d .getMonth() + 1);
        let day = (d .getDate());
        let year = (d .getFullYear());
        let fd=year + "," + month + "," + day;
        $(this).datepicker({
            format: 'yyyy,mm,dd',
            todayHighlight:'TRUE',
            autoclose: true,
            constrainInput: true,
            endDate: new Date()

        });
    });
    $(document).on('change', '.datepicker', function(){

        if($(this).hasClass('age')) {
            let dateVal=$(this).val()
            $(this).next().val(dateVal)

            dateVal=dateVal.split(',')
            let sDate=dateVal[0]+"/"+dateVal[1]+"/"+dateVal[1]
            let enteredDate = sDate
            years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;


            movegroup3(this)
        }
    });
    $(document).on('change', 'input[type="radio"]', function(){
        movegroup2(this)

    });
    $(document).on('change', 'select', function(){
        movegroup4(this)
    });
    $(document).on('keypress','input[type="text"]',function (e) {
        if($(this).hasClass('datepicker'))
        {
            var keyCode = e.keyCode || e.which;
            var regex = /^[0-9,]+$/;
            var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        }
        var keyCode = e.keyCode || e.which;
        var regex = /^[A-Za-z ]+$/;
        let a=$(this).parent().parent().children('label').html();
        if(a!==undefined) {
            if (a.includes('address') || a.includes('Address')) {
                return true;
            } else {
                var isValid = regex.test(String.fromCharCode(keyCode));
                return isValid;

            }
            return false;
        }
    })
    $(document).on('keypress','input[type="tel"]',function (e) {
        var keyCode = e.keyCode || e.which;
        let v=$(this).val();

        var regex = /^[+0-9]$/;
        var isValid = regex.test(String.fromCharCode(keyCode));
        return isValid;

        return false;
    })

    $(document).on('keypress','input[type="number"]',function (e) {
        var keyCode = e.keyCode || e.which;
        let v=$(this).val();
        let a=$(this).attr('data-type')
        if(a=='hour')
        {
            var regex = /^[0-9]$/;
            var isValid = regex.test(String.fromCharCode(keyCode));

            if(isValid && v > 9)
                return false;

            return isValid;
        }
        // else if(a.includes('hours worked'))
        // {
        //     var regex = /^[0-9]$/;
        //     var isValid = regex.test(String.fromCharCode(keyCode));
        //     return isValid;
        // }
        else
        {
            var regex = /^[+0-9]$/;
            var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        }
        return false;
    })
    $(document).on('change','#terms',function () {
        $('#tError').hide()
    })
    var btnCheck=false
    $(document).on('click','#btnLoader',function () {

        if(!btnCheck)
        {
            $('.terms').show()
            btnCheck=true
            return false
        }
        else
        {
            if($('#terms').is(":checked")) {
            }
            else
            {
                $('#tError').show()
                return false

            }
        }

    })
    $(document).on('change', '.countryCheck', function(){
        countryFunc(this)
    })
    $(document).on('change', 'input[type="date"]', function(){
        noc(this,'')
        valSave(this)
    })
    $(document).on('change', 'input[type="radio"]', function(e){

        let noc_flag=$(this).attr('data-noc')
        let noc_pos=$(this).attr('data-position')
        let noc_user=$(this).attr('data-label')
        let noc_type=$(this).attr('data-type')
        let index=parseInt(noc_pos)-1
        let v=$(this).val()

        if(noc_pos=='7' && noc_flag=='1' ) {
            if (noc_user=='spouse') {
                if(nocSpouse[index]!='' && v=='No')
                {
                    nocSpouse[index]='';
                }
                else
                {
                    nocSpouse[index] = {'position': noc_pos, 'job': 1,'country':'Canada'}
                }
            } else {
                if(nocUser[index]!='' && v=='No')
                {
                    nocUser[index]='';
                }
                else
                {
                    nocUser[index] = {'position': noc_pos, 'job': 1,'country':'Canada'}
                }
            }
        }
    })
    $(document).on('change','.present_checkbox',function(e) {

        let dis=$(this).parent().parent().children('input[data-id="to"]')
        var now = new Date();
        var month = (now.getMonth() + 1);
        var day = now.getDate();
        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;

        if(this.checked) {
            $(dis).val(new Date());

            $(dis).css('pointer-events','none')
            $(dis).attr('type','text')
            $(dis).val('Present');
            noc(dis,'')
        }
        else
        {
            $(dis).css('pointer-events','')
            $(dis).attr('type','date')
            $(dis).val('');
            noc(dis,'off')


        }
        valSave(dis)
    });
    $(document).on('keyup','input',function (e) {
        let noc_flag=$(this).attr('data-noc')
        let noc_pos=$(this).attr('data-position')
        let noc_user=$(this).attr('data-label')
        let noc_type=$(this).attr('data-type')
        let date_pos=$(this).attr('data-id')
        let val=$(this).val()
        let index=parseInt(noc_pos)-1

        if(noc_flag=='1')
        {
            if(noc_user=='spouse') {
                if (noc_type == 'hour') {
                    nocSpouse[index].hours=val
                }
                else if (noc_type == 'wage') {
                    nocSpouse[index].wage=val
                }
            }
            else
            {
                if (noc_type == 'hour') {
                    nocUser[index].hours=val
                }
                else if (noc_type == 'wage') {
                    nocUser[index].wage=val
                }
            }
        }

        console.log('user')
        console.log(nocUser)
        console.log('spouse')
        console.log(nocSpouse)
    })
    $(document).on('change','select',function (e) {

        let noc_flag=$(this).attr('data-noc')
        let noc_pos=$(this).attr('data-position')
        let noc_user=$(this).attr('data-label')
        let noc_type=$(this).attr('data-type')
        let date_pos=$(this).attr('data-id')
        let val=$(this).val()
        let index=parseInt(noc_pos)-1

        if(noc_flag=='1')
        {
            if(noc_user=='spouse') {
                if (noc_type == 'country') {
                    nocSpouse[index].country=val
                }
                else if (noc_type == 'province') {
                    nocSpouse[index].province=val
                }
                else if (noc_type == 'region') {
                    nocSpouse[index].region=val
                }
                else if (noc_type == 'authorization') {
                    nocSpouse[index].authorization=val
                }
            }
            else
            {
                if (noc_type == 'country') {
                    nocUser[index].country=val
                }
                else if (noc_type == 'province') {
                    nocUser[index].province=val
                }
                else if (noc_type == 'region') {
                    nocUser[index].region=val
                }
                else if (noc_type == 'authorization') {
                    nocUser[index].authorization=val
                }
            }
        }

        console.log('user')
        console.log(nocUser)
        console.log('spouse')
        console.log(nocSpouse)
    })
    $(document).on('change', '.nocJobs' ,function (ee) {

        var $aRr = $(this).val();
        let val=jobsArr[$aRr];

        var getAttr = $(this).attr('name');
        $("input[name='"+getAttr+"']").val(val);

        let noc_flag=$(this).attr('data-noc')
        let noc_pos=$(this).attr('data-position')
        let noc_user=$(this).attr('data-label')
        let noc_type=$(this).attr('data-type')
        let date_pos=$(this).attr('data-id')

        let index=parseInt(noc_pos)-1
        if(noc_flag=='1')

            if(nocSpouse.length > 0) {
                if (nocSpouse[index].noc != '') {
                    up1 += nocSpouse[index].noc
                }
            }
        if(nocUser.length > 0) {
            if (nocUser[index].noc != '') {
                up2 += nocUser[index].noc
            }
        }

        up='';
        $('input.nocJobs[data-position="'+noc_pos+'"]').each(function () {
            let nocJob=$(this).val()
            up+=nocJob+','
        })
        $('input.nocPos[data-position="'+noc_pos+'"]').each(function () {
            let nocJob=$(this).val()
            up+=nocJob+','
        })


        if (noc_type == 'job' || noc_type == 'duty') {
            if(noc_user=='spouse') {
                nocSpouse[index].noc=up
            }
            else
            {
                nocUser[index].noc=up
            }
        }


        valSave(this)


        console.log('user')
        console.log(nocUser)
        console.log('spouse')
        console.log(nocSpouse)
    });

    $(document).on('change', '.nocPos' ,function (ee) {

        var $aRr = $(this).val();
        let val=dutyArr[$aRr];

        var getAttr = $(this).attr('name');
        // console.log(getAttr);
        $("input[name='"+getAttr+"']").val(val);


        valSave(this)

        let noc_flag=$(this).attr('data-noc')
        let noc_pos=$(this).attr('data-position')
        let noc_user=$(this).attr('data-label')
        let noc_type=$(this).attr('data-type')
        let date_pos=$(this).attr('data-id')
        let index=parseInt(noc_pos)-1
        if(noc_flag=='1')
        {
            up='';
            $('input.nocJobs[data-position="'+noc_pos+'"]').each(function () {
                let nocJob=$(this).val()
                up+=nocJob+','
            })
            $('input.nocPos[data-position="'+noc_pos+'"]').each(function () {
                let nocJob=$(this).val()
                up+=nocJob+','
            })


            if (noc_type == 'job' || noc_type == 'duty') {
                if(noc_user=='spouse') {
                    nocSpouse[index].noc=up
                }
                else
                {
                    nocUser[index].noc=up
                }
            }

        }


        console.log('user')
        console.log(nocUser)
        console.log('spouse')
        console.log(nocSpouse)
    });

    function getQuestion(value,id,pid) {
        afterForm()

        valSave(value)

        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp '+disCl+'" role="status"></span>');

        $(value).parent().children('input').prop('disabled', true)
        $(value).parent().children('select').prop('disabled', true)

        let pos= $(value).parent().children('input').attr('type')


        var val = $(value).val();

        $('.main_parent_' + id)
            .children()             //Select all the children of the parent
            .not(':first-child')    //Unselect the first child
            .remove();

        if(pos==='date')
        {
            if(currentRequest==='')
            {
                req_check=true
            }
            else
            {
                req_check=false
            }
        }
        else
        {
            req_check=true
        }

        if(req_check)
        {

            currentRequest =$.ajax({
                dataType: 'json',
                url: "ajax.php?h=getQuestion",
                type: 'POST',
                data: {
                    'id': id,
                    'value': val,
                    'pid': pid
                },
                success: function (data) {
                    var fieldData = '';

                    let mq = 0;
                    if (lArray.indexOf(parseInt(id)) < 0 && data.MultiCondition.length > 0) {
                        for (var i = 0; i < data.MultiCondition.length; i++) {


                            localStorage.setItem('sid-' + i, data.MultiCondition[i].s_id)
                            localStorage.setItem('qtype-' + i, data.MultiCondition[i].question_type)
                            localStorage.setItem('ex_sid-' + i, data.MultiCondition[i].existing_sid)
                            localStorage.setItem('ex_qid-' + i, data.MultiCondition[i].existing_qid)
                            localStorage.setItem('value-' + i, data.MultiCondition[i].value);
                            localStorage.setItem('op-' + i, data.MultiCondition[i].operator);
                            localStorage.setItem('mainQues-' + i, data.MultiCondition[i].mques)
                            localStorage.setItem('andor-' + i, data.MultiCondition[i].op)


                            if (mq != data.MultiCondition[i].mques) {
                                lArray.push(parseInt(data.MultiCondition[i].mques))
                                mq = data.MultiCondition[i].mques
                            }
                            sArr.push(data.MultiCondition[i].s_id);
                        }
                        count = []
                        sArr.forEach(function (i) {

                            count[i] = (count[i] || 0) + 1;

                        });
                    }

                    for (var i = 0; i < data.data.length; i++) {

                        let noc_attr="data-noc='"+data.data[i].noc_flag+"' data-position='"+data.data[i].position_no+"' data-type='"+data.data[i].noc_type+"' data-label='"+data.data[i].user_type+"'"
                        let permission = '';
                        if(data.data.permission==1)
                        {
                            permission='permitted'
                        }
                        else
                        {
                            permission='forbidden'
                        }

                        if (data.data[i].check == 3) {
                            continue
                        }
                        else if(data.data[i].ques_case=='movescore')
                        {
                            $('#scoreID').val(data.data[i].scoreID)
                            $('#validateform').submit()
                            fieldData=''
                            continue;
                        }
                        else if (data.data[i].casetype == 'existing') {
                            fieldData +=data.data[i].existing_data;
                            continue;
                        }
                        else if (data.data[i].casetype == 'group') {
                            // fieldData='';

                            // let y=(data.data[i].ids).split('_');
                            // let c1=0;
                            // for(let u=0;u<y.length-1;u++)
                            // {
                            //     let len=$('.main_parent_'+y[u]).length;
                            //     if(len > 0)
                            //     {
                            //         continue
                            //     }
                            //     else
                            //     {
                            //         c1++;
                            //     }
                            // }
                            //if(c1==y.length-1)
                            {
                                fieldData += data.data[i].group_data;
                            }
                            continue;
                        }
                        else if (data.data[i].casetype == 'groupques') {
                            fieldData += data.data[i].group_data2;
                            continue;
                        }
                        else if (data.data[i].check == 4) {
                            fieldData += data.data[i].gData;

                            cq = data.data[i].checkQuesID;
                            cv = data.data[i].checkVal;
                            hv = data.data[i].hideQuesID;
                            cf = data.data[i].checkQuestField;
                            co = data.data[i].checkOp;

                            checkField.push(cf)
                            hiddenQues.push(hv)
                            checkQues.push(cq)
                            checkValue.push(cv)
                            checkOp.push(co)


                            continue;
                        } else {
                            fieldData += "<div class='parent_" + data.data[i].id +  "'>"
                        }


                        if (data.data[i].casetype == 'email') {
                            fieldData += "<div style='background: #d1f0d1;display:none' class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1'>Email sent successfully</label>";

                        } else if (data.data[i].casetype == 'exit' || data.data[i].casetype == 'none') {
                            fieldData += "";
                            continue;
                        } else if (data.data[i].casetype == 'end') {
                            $('#btnModal').click()
                        } else {
                            if (data.data[i].check == 1) {
                                fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"

                                if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {
                                    if(localStorage.getItem('Lang') !== 'english'){
                                        notesTrans(data.data[i].notes);
                                    }

                                    if(rTitle=='')
                                    {
                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    else
                                    {
                                        fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                        rTitle='';

                                    }
                                }

                                fieldData += "<label class='pb-1'>" + data.data[i].other + "</label>";
                            } else {
                                fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                if (data.data[i].notes != '' && data.data[i].notes != null) {
                                    if(localStorage.getItem('Lang') !== 'english'){
                                        notesTrans(data.data[i].notes);
                                    }

                                    if(rTitle=='')
                                    {
                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    else
                                    {
                                        fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                        rTitle='';

                                    }
                                }
                                if(localStorage.getItem('Lang') !== 'english'){
                                    translateVal(data.data[i].question);
                                }

                                if(rTitle=='')
                                {
                                    fieldData+="<label class='pb-1'>" + data.data[i].question + "</label>";

                                }
                                else
                                {
                                    fieldData+="<label class='pb-1'>" + rTitle + "</label>";
                                    rTitle='';

                                }
                            }
                            fieldData+="<div class='input-group input-group-merge "+permission+"'>"


                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {
                                let y='Yes'
                                let n='No'
                                if(localStorage.getItem('Lang') !== 'english'){
                                    customLabel(y,'conversion');
                                    if(rTitle!='')
                                    {
                                        y=rTitle;
                                        rTitle='';
                                    }
                                    customLabel(n,'conversion');
                                    if(rTitle!='')
                                    {
                                        n=rTitle;
                                        rTitle='';
                                    }
                                }

                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='Yes' "+noc_attr+"><span class='customLabel'>"+ y +"</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='No' "+noc_attr+"><span class='customLabel' >" +n+ "</span>";

                            }
                            else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                fieldData += data.data[i].radios;
                            } else if (data.data[i].field == 'phone') {
                                fieldData += "<input " + data.data[i].validation + " type='tel' onkeyup='validate(this)'  minlength='6' maxlength='15' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            } else if (data.data[i].field == 'calender') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            } else if (data.data[i].field == 'age') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*"+data.data[i].id +"'>"
                            } else if (data.data[i].field == 'email') {
                                fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            }  else if (data.data[i].field == 'country') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c=data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            }  else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c=data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            }else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                fieldData += data.data[i].dropdown;
                                fieldData += "</select>"
                            }
                            else if (data.data[i].field == 'nocjob') {

                                fieldData += "<input " + data.data[i].validation + " class='form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            } else if (data.data[i].field == 'nocduty') {
                                fieldData += "<input " + data.data[i].validation + " class='form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            }
                            else if (data.data[i].field == 'pass') {
                                fieldData += "<label class='notesPara2'>" + data.data[i].notes + "</label>"
                            }
                            else if (data.data[i].field == 'number') {
                                fieldData += "<input " + data.data[i].validation + " type='number' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";

                            }
                            else if(data.data[i].field=='currentrange')
                            {
                                let current_datetime = new Date()
                                let m=((current_datetime.getMonth()+1)>=10)? (current_datetime.getMonth()+1) : '0' + (current_datetime.getMonth()+1);
                                let d=((current_datetime.getDate())>=10)? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                                let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d

                                fieldData += "<label class='pb-date'>From</label><label class='pb-date'>To</label>"
                                fieldData += "<input " + data.data[i].validation + " data-id='from'  max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<input " + data.data[i].validation + " data-id='to' onchange='if(checkDate(this)){getQuestion3(this,"+data.data[i].id+","+id+")}'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this,"+data.data[i].id+","+id+")'><span class='presentCheckbox'>Present</span></div>"

                            }
                            else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this," + data.data[i].id + "," + id + ")' type='text' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            }
                        }
                        fieldData += "</div>";
                        fieldData += "</div>";
                        fieldData+="</div>";


                    }


                    $('.main_parent_' + id).append(fieldData)
                    movegroup('')
                    if(id!=73)
                    {
                        $(value).parent().find('.temp').remove()
                        $(value).parent().children('input').prop('disabled', false)
                        $(value).parent().children('select').prop('disabled', false)
                    }
                    formFunc(value)
                    tagsInp()
                    currentRequest='';
                    req_check=false

                }
                ,
                error: function (data) {
                    $(value).parent().find('.temp').remove()
                    $(value).parent().children('input[type="radio"]').prop('disabled', false)
                    $(value).parent().children('select').prop('disabled', false)
                    $('#btnModal2').click()
                    currentRequest='';
                    req_check=false
                }


            });

        }
        if (id == 73) {
            setTimeout( function (){
                multi(id)
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input').prop('disabled', false)
                $(value).parent().children('select').prop('disabled', false)
            }, 1000 );
        }
        else
        {
            multi(id)
        }

    }
    function getQuestion2(value,id,qid,pid,v){
        valSave(value)

        if($(value).parent().find('.temp').length==0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp '+disCl+'" role="status"></span>');

        var val = $(value).val();

        if(value==null)
        {
            val=v
        }


        $('.parent_' + id)
            .children()
            .not(':first-child')
            .remove();



        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getQuestion2",
            type: 'POST',
            data: {
                'id': id,
                'value' : val,
                'qid' : qid
            },
            success: function ( data ) {
                $(value).parent().find('.temp').remove()

                var fieldData = '';

                for(var i=0; i<data.data.length; i++) {
                    let noc_attr="data-noc='"+data.data[i].noc_flag+"' data-position='"+data.data[i].position_no+"' data-type='"+data.data[i].noc_type+"' data-label='"+data.data[i].user_type+"'"
                    let permission = '';
                    if(data.data.permission==1)
                    {
                        permission='permitted'
                    }
                    else
                    {
                        permission='forbidden'
                    }
                    var $row = $(value).parent();
                    fieldData+="<div class='parent_"+data.data[i].id+"'>"


                    {
                        {
                            fieldData += "<div class='form-group sub_question_div sques_" + qid + " sques_" + id + " sques_" + pid + "' id='sub_question_div_"+data.data[i].id+"'>"
                            if(data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass')
                            {
                                if(localStorage.getItem('Lang') !== 'english'){
                                    notesTrans(data.data[i].notes);
                                }

                                if(rTitle=='')
                                {
                                    fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                }
                                else
                                {
                                    fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                    rTitle='';

                                }
                            }
                            if(localStorage.getItem('Lang') !== 'english'){
                                translateVal(data.data[i].question);
                            }

                            if(rTitle=='')
                            {
                                fieldData+="<label class='pb-1'>" + data.data[i].question + "</label>";

                            }
                            else
                            {
                                fieldData+="<label class='pb-1'>" + rTitle + "</label>";
                                rTitle='';

                            }


                        }
                        fieldData+="<div class='input-group input-group-merge "+permission+"'>"

                        if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {

                            let y='Yes'
                            let n='No'
                            if(localStorage.getItem('Lang') !== 'english'){
                                customLabel(y,'conversion');
                                if(rTitle!='')
                                {
                                    y=rTitle;
                                    rTitle='';
                                }
                                customLabel(n,'conversion');
                                if(rTitle!='')
                                {
                                    n=rTitle;
                                    rTitle='';
                                }
                            }

                            fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + id + ")' value='Yes' "+noc_attr+"><span class='customLabel'>"+ y +"</span>"
                            fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + id + ")' value='No' "+noc_attr+"><span class='customLabel' >" +n+ "</span>";

                        }
                        else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                            fieldData += data.data[i].radios;
                        } else if (data.data[i].field == 'calender') {
                            fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                        } else if (data.data[i].field == 'age') {
                            fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*"+data.data[i].id +"'>"

                        } else if (data.data[i].field == 'email') {
                            fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_" + data.data[i].id + "]'>";
                        } else if (data.data[i].field == 'country') {
                            fieldData += "<select " + data.data[i].validation + "  class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + " , "+qid+")' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            fieldData += "<option value='' disabled selected>-- Select --</option>";
                            for (var j = 0; j < (data.country).length; j++) {
                                let c=data.country[j].name
                                fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                            }
                            fieldData += "</select>"
                        } else if (data.data[i].field == 'education') {
                            fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + qid + ")' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            fieldData += "<option value='' disabled selected>-- Select --</option>";
                            for (var j = 0; j < (data.education).length; j++) {
                                let c=data.education[j].name
                                fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                            }
                            fieldData += "</select>"
                        }else if (data.data[i].field == 'dropdown') {
                            fieldData += "<select " + data.data[i].validation + " onchange='getQuestion3(this," + data.data[i].id + "," + qid + ")' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            fieldData += "<option value='' disabled selected>-- Select --</option>";
                            fieldData += data.data[i].dropdown;
                            fieldData += "</select>"
                        }
                        else if (data.data[i].field == 'nocjob') {

                            fieldData += "<input " + data.data[i].validation + " class='form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                        } else if (data.data[i].field == 'nocduty') {

                            fieldData += "<input " + data.data[i].validation + " class='form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                        }
                        else if(data.data[i].field=='pass')
                        {
                            fieldData+="<label class='notesPara2'>"+data.data[i].notes+"</label>"
                        }
                        else if(data.data[i].field=='number')
                        {
                            fieldData += "<input " + data.data[i].validation + "  type='number' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";

                        }
                        else if(data.data[i].field=='currentrange')
                        {
                            let current_datetime = new Date()
                            let m=((current_datetime.getMonth()+1)>=10)? (current_datetime.getMonth()+1) : '0' + (current_datetime.getMonth()+1);
                            let d=((current_datetime.getDate())>=10)? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                            let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d

                            fieldData += "<label class='pb-date'>From</label><label class='pb-date'>To</label>"

                            fieldData += "<input " + data.data[i].validation + " data-id='from'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            fieldData += "<input " + data.data[i].validation + " data-id='to' onchange='if(checkDate(this)){getQuestion3(this,"+data.data[i].id+","+qid+")}'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this,"+data.data[i].id+","+id+")'><span class='presentCheckbox'>Present</span></div>"
                            fieldData += "</div>";

                        }
                        else {
                            fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this,"+data.data[i].id+","+qid+")' type='text' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            if(data.data[i].existing_sid==151)
                            {
                                fieldData+="<em style='font-size: 12px;font-style: italic;'>Press tab to continue</em>"

                            }
                        }
                    }

                    fieldData += "</div></div>";
                    fieldData+="</div>";


                }
                $(value).parent().children('input').prop('disabled',false)
                $(value).parent().children('select').prop('disabled',false)
                $('select').prop('disabled',false)
                $('input').prop('disabled',false)

                $('.parent_'+id).append(fieldData)
                tagsInp()
                formFunc(value)


            }
            ,
            error:function (data) {
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input').prop('disabled',false)
                $(value).parent().children('select').prop('disabled',false)
                $('#btnModal2').click()
            }
        });
    }
    function getQuestion3(value,id,qid,pid){
        afterForm()


        valSave(value)

        if($(value).parent().find('.temp').length==0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp '+disCl+'" role="status"></span>');

        $(value).parent().children('input').prop('disabled',true)
        $(value).parent().children('select').prop('disabled',true)


        var val = $(value).val();

        var ab=$('.parent_'+id).children().hasClass('multi')

        $('.parent_' + id)
            .children()
            .not(':first-child')
            .remove();


        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getQuestion3",
            type: 'POST',
            data: {
                'id': id,
                'value' : val,
                'qid' : qid,
                'pid' : 0,

            },
            success: function ( data ) {
                $(value).parent().find('.temp').remove()

                if(data.Success == 'false')
                {
                    if(data.level==2)
                    {
                        let element=document.getElementById(data.val + '_' + data.id)
                        let v='';

                        if(element == null)
                        {
                            v=val;
                        }
                        getQuestion2(element,data.id,data.qid,data.pid,v)
                        getQuestion4(element,data.id,data.qid,data.pid,v)

                    }
                    else
                    {
                        let v='';

                        let element=document.getElementById(data.val + '_' + data.id)
                        if(element == null)
                        {
                            v=val;
                        }
                        getQuestion2(element,data.id,data.qid,data.pid,v)
                    }
                }
                else
                {
                    var fieldData = '';

                    for(var i=0; i<data.data.length; i++) {

                        let noc_attr="data-noc='"+data.data[i].noc_flag+"' data-position='"+data.data[i].position_no+"' data-type='"+data.data[i].noc_type+"' data-label='"+data.data[i].user_type+"'"
                        let permission = '';
                        if(data.data.permission==1)
                        {
                            permission='permitted'
                        }
                        else
                        {
                            permission='forbidden'
                        }
                        if (data.data[i].check == 4) {
                            fieldData +=data.data[i].gData;

                            cq=data.data[i].checkQuesID;
                            cv=data.data[i].checkVal;
                            hv=data.data[i].hideQuesID;
                            cf=data.data[i].checkQuestField;
                            co=data.data[i].checkOp;

                            checkField.push(cf)
                            hiddenQues.push(hv)
                            checkQues.push(cq)
                            checkValue.push(cv)
                            checkOp.push(co)


                            continue;
                        }

                        if (data.data[i].casetype == 'group') {
                            fieldData += data.data[i].group_data;
                            continue;
                        }
                        if (data.data[i].casetype == 'groupques') {
                            fieldData +=data.data[i].group_data2;
                            continue;
                        }
                        if (data.data[i].casetype == 'existing') {
                            fieldData +=data.data[i].existing_data;
                            continue;
                        }
                        if(data.data[i].ques_case=='movescore')
                        {
                            $('#scoreID').val(data.data[i].scoreID)
                            $('#validateform').submit()
                            fieldData=''
                            continue;
                        }
                        if(data.data[i].casetype=='age')
                        {
                            if(ageLimit(data.data[i].group_operator,data.data[i].value))
                            {
                                $('#btnModal').click()
                                fieldData=''
                                break;
                            }
                            else
                                continue;
                        }


                        fieldData+="<div class='parent_"+data.data[i].id+"'>"


                        if(data.data[i].casetype == 'email'){


                            fieldData += "<div style='background: #d1f0d1;display:none' class='form-group email sub_question_div sques_" + id + "' id='sub_question_div_"+data.data[i].id+"'><label class='pb-1'>Email sent successfully</label>";
                            fieldData += "</div>";
                            fieldData+="</div>"
                            $('.parent_'+id).append(fieldData)
                            fieldData='';
                            continue

                        }
                        else  if(data.data[i].casetype == 'exit' || data.data[i].casetype == 'none'){
                            fieldData = "";
                            continue;
                        }
                        else if (data.data[i].casetype == 'end')
                        {
                            fieldData += "";
                            $('#btnModal').click()
                        }
                        else {

                            if (data.data[i].check == 1) {
                                fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques_" + pid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                if(data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass')
                                {
                                    if(localStorage.getItem('Lang') !== 'english'){
                                        notesTrans(data.data[i].notes);
                                    }

                                    if(rTitle=='')
                                    {
                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    else
                                    {
                                        fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                        rTitle='';

                                    }
                                }
                                fieldData+="<label class='pb-1'>" + data.data[i].other + "</label>";
                            }  else {
                                fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                if(data.data[i].notes != '' && data.data[i].notes != null)
                                {
                                    if(localStorage.getItem('Lang') !== 'english'){
                                        notesTrans(data.data[i].notes);
                                    }

                                    if(rTitle=='')
                                    {
                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    else
                                    {
                                        fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                        rTitle='';

                                    }
                                }
                                if(localStorage.getItem('Lang') !== 'english'){
                                    translateVal(data.data[i].question);
                                }

                                if(rTitle=='')
                                {
                                    fieldData+="<label class='pb-1'>" + data.data[i].question + "</label>";

                                }
                                else
                                {
                                    fieldData+="<label class='pb-1'>" + rTitle + "</label>";
                                    rTitle='';

                                }
                            }
                            fieldData+="<div class='input-group input-group-merge "+permission+"'>"

                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {

                                let y='Yes'
                                let n='No'
                                if(localStorage.getItem('Lang') !== 'english'){
                                    customLabel(y,'conversion',data.data[i].field);
                                    if(rTitle!='')
                                    {
                                        y=rTitle;
                                        rTitle='';
                                    }
                                    customLabel(n,'conversion',data.data[i].field);
                                    if(rTitle!='')
                                    {
                                        n=rTitle;
                                        rTitle='';
                                    }
                                }

                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='Yes' "+noc_attr+"><span class='customLabel'>"+ y +"</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='No' "+noc_attr+"><span class='customLabel' >" +n+ "</span>";

                            }
                            else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                fieldData += data.data[i].radios;
                            } else if (data.data[i].field == 'calender') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            } else if (data.data[i].field == 'age') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*"+data.data[i].id +"'>"

                            } else if (data.data[i].field == 'email') {
                                fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            } else if (data.data[i].field == 'phone') {
                                fieldData += "<input " + data.data[i].validation + " type='tel' onkeyup='validate(this)'  minlength='6' maxlength='15' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            }  else if (data.data[i].field == 'country') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c=data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c=data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            }else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' name='n[sub_question_2" + data.data[i].id + "]'"+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                fieldData += data.data[i].dropdown;
                                fieldData += "</select>"
                            }
                            else if (data.data[i].field == 'nocjob') {
                                fieldData += "<input " + data.data[i].validation + " class='form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            } else if (data.data[i].field == 'nocduty') {
                                fieldData += "<input " + data.data[i].validation + " class='form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            }
                            else if(data.data[i].field=='pass')
                            {
                                fieldData+="<label class='notesPara2'>"+data.data[i].notes+"</label>"
                            }
                            else if(data.data[i].field=='number')
                            {
                                fieldData += "<input " + data.data[i].validation + " type='number' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";

                            }
                            else if(data.data[i].field=='currentrange')
                            {

                                let current_datetime = new Date()
                                let m=((current_datetime.getMonth()+1)>=10)? (current_datetime.getMonth()+1) : '0' + (current_datetime.getMonth()+1);
                                let d=((current_datetime.getDate())>=10)? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                                let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d
                                fieldData += "<label class='pb-date'>From</label><label class='pb-date'>To</label>"

                                fieldData += "<input " + data.data[i].validation + " data-id='from'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<input " + data.data[i].validation + " data-id='to' onchange='if(checkDate(this)){getQuestion3(this,"+data.data[i].id+","+id+")}'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this,"+data.data[i].id+","+id+")'><span class='presentCheckbox'>Present</span></div>"

                                fieldData += "</div>";

                            }
                            else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this,"+data.data[i].id+","+id+")' type='text' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            }
                        }

                        fieldData += "</div>";
                        fieldData+="</div>"
                        fieldData+="</div>";

                    }
                    $('.parent_'+id).append(fieldData)

                    if(id!=350) {
                        if($('.parent_' + id).length <= 1) {
                            movegroup('')
                        }
                    }
                    $(value).parent().children('input').prop('disabled',false)
                    $(value).parent().children('select').prop('disabled',false)
                    formFunc(value)
                }




            }
            ,
            error:function (data) {
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input').prop('disabled',false)
                $(value).parent().children('select').prop('disabled',false)
                $('#btnModal2').click()
            }
        });

        multi(id)
        formFunc(value)

    }
    function getQuestion4(value,id,qid,pid,v){
        valSave(value)
        let b=false;

        if($(value).parent().find('.temp').length==0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp '+disCl+'" role="status"></span>');

        var val = $(value).val();
        if(value==null)
        {
            val=v
        }

        $('.parent_'+id)
            .children()             //Select all the children of the parent
            .not(':first-child')    //Unselect the first child
            .remove();
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getQuestion4",
            type: 'POST',
            data: {
                'id': id,
                'value' : val,
                'qid' : qid,
                'pid' : pid,

            },
            success: function ( data ) {
                $(value).parent().find('.temp').remove()

                {
                    var fieldData = '';

                    for(var i=0; i<data.data.length; i++) {
                        let noc_attr="data-noc='"+data.data[i].noc_flag+"' data-position='"+data.data[i].position_no+"' data-type='"+data.data[i].noc_type+"' data-label='"+data.data[i].user_type+"'"
                        let permission = '';
                        if(data.data.permission==1)
                        {
                            permission='permitted'
                        }
                        else
                        {
                            permission='forbidden'
                        }
                        var $row = $(value).parent();

                        if(data.data[i].casetype=='age')
                        {
                            if(ageLimit(data.data[i].group_operator,data.data[i].value))
                            {
                                $('#btnModal').click()
                                fieldData=''
                                $('.parent_'+id)
                                    .children()             //Select all the children of the parent
                                    .not(':first-child')    //Unselect the first child
                                    .remove();
                                break;

                            }
                            else
                                continue;
                        }
                        if (data.data[i].check == 4) {
                            fieldData +=data.data[i].gData;

                            cq=data.data[i].checkQuesID;
                            cv=data.data[i].checkVal;
                            hv=data.data[i].hideQuesID;
                            cf=data.data[i].checkQuestField;
                            co=data.data[i].checkOp;

                            checkField.push(cf)
                            hiddenQues.push(hv)
                            checkQues.push(cq)
                            checkValue.push(cv)
                            checkOp.push(co)


                            continue;
                        }
                        else if (data.data[i].casetype == 'group') {

                            fieldData += data.data[i].group_data;
                            continue;

                        }
                        else if (data.data[i].casetype == 'groupques') {
                            fieldData +=data.data[i].group_data2;
                            continue;
                        }
                        else if (data.data[i].casetype == 'existing') {
                            fieldData +=data.data[i].existing_data;
                            continue;
                        }

                        fieldData+="<div class='parent_"+data.data[i].id+"'>"

                        if(data.data[i].casetype == 'email'){


                            fieldData += "<div style='background: #d1f0d1;display:none' class='form-group email sub_question_div sques_" + id + "' id='sub_question_div_"+data.data[i].id+"'><label class='pb-1'>Email sent successfully</label>";
                            fieldData += "</div>";
                            fieldData+="</div>"
                            continue
                        }
                        else  if(data.data[i].casetype == 'exit' || data.data[i].casetype == 'none'){
                            fieldData += "";
                            continue;
                        }
                        else if (data.data[i].casetype == 'end')
                        {

                            $('#btnModal').click()

                        }
                        else {

                            if (data.data[i].check == 1) {
                                fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques_" + pid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                if(data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass')
                                {
                                    if(localStorage.getItem('Lang') !== 'english'){
                                        notesTrans(data.data[i].notes);
                                    }

                                    if(rTitle=='')
                                    {
                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    else
                                    {
                                        fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                        rTitle='';

                                    }
                                }
                                fieldData+="<label class='pb-1'>" + data.data[i].other + "</label>";
                            }
                            else {
                                fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                if(data.data[i].notes != '' && data.data[i].notes != null)
                                {
                                    if(localStorage.getItem('Lang') !== 'english'){
                                        notesTrans(data.data[i].notes);
                                    }

                                    if(rTitle=='')
                                    {
                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    else
                                    {
                                        fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                        rTitle='';

                                    }
                                }
                                if(localStorage.getItem('Lang') !== 'english'){
                                    translateVal(data.data[i].question);
                                }

                                if(rTitle=='')
                                {
                                    fieldData+="<label class='pb-1'>" + data.data[i].question + "</label>";

                                }
                                else
                                {
                                    fieldData+="<label class='pb-1'>" + rTitle + "</label>";
                                    rTitle='';

                                }
                            }
                            fieldData+="<div class='input-group input-group-merge "+permission+"'>"

                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {
                                let y='Yes'
                                let n='No'
                                if(localStorage.getItem('Lang') !== 'english'){
                                    customLabel(y,'conversion');
                                    if(rTitle!='')
                                    {
                                        y=rTitle;
                                        rTitle='';
                                    }
                                    customLabel(n,'conversion');
                                    if(rTitle!='')
                                    {
                                        n=rTitle;
                                        rTitle='';
                                    }
                                }


                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + '' + ")' value='Yes' "+noc_attr+"><span class='customLabel'>"+ y +"</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + '' + ")' value='No' "+noc_attr+"><span class='customLabel'>" +n+ "</span>";

                            }
                            else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                fieldData += data.data[i].radios;
                            } else if (data.data[i].field == 'calender') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            } else if (data.data[i].field == 'age') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*"+data.data[i].id +"'>"

                            } else if (data.data[i].field == 'email') {
                                fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_2" + data.data[i].id + "]'>";
                            } else if (data.data[i].field == 'phone') {
                                fieldData += "<input " + data.data[i].validation + " type='tel' onkeyup='validate(this)'  minlength='6' maxlength='15' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            }  else if (data.data[i].field == 'country') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id +")' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c=data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id +  ")' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c=data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            }else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this, " +data.data[i].id+")' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">"
                                fieldData += "<option value='' disabled selected>-- Select --</option>";
                                fieldData += data.data[i].dropdown;
                                fieldData += "</select>"
                            }
                            else if (data.data[i].field == 'nocjob') {
                                fieldData += "<input " + data.data[i].validation + " class='form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            } else if (data.data[i].field == 'nocduty') {
                                fieldData += "<input " + data.data[i].validation + " class='form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' " +noc_attr+">"
                            }
                            else if(data.data[i].field=='pass')
                            {
                                fieldData+="<label class='notesPara2'>"+data.data[i].notes+"</label>"
                            }
                            else if(data.data[i].field=='number')
                            {
                                fieldData += "<input " + data.data[i].validation + " type='number' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";

                            }
                            else if(data.data[i].field=='currentrange')
                            {
                                let current_datetime = new Date()
                                let m=((current_datetime.getMonth()+1)>=10)? (current_datetime.getMonth()+1) : '0' + (current_datetime.getMonth()+1);
                                let d=((current_datetime.getDate())>=10)? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                                let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d
                                fieldData += "<label class='pb-date'>From</label><label class='pb-date'>To</label>"

                                fieldData += "<input " + data.data[i].validation + " data-id='from'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "<input " + data.data[i].validation + " data-id='to' onchange='if(checkDate(this)){getQuestion3(this,"+data.data[i].id+","+qid+")}'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                                fieldData += "</div>";

                            }
                            else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this,"+data.data[i].id+","+qid+")' type='text' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' "+noc_attr+">";
                            }
                        }

                    }
                    $('.parent_'+id).append(fieldData)
                    formFunc(value)
                    movegroup('')
                    $(value).parent().children('input').prop('disabled',false)
                    $(value).parent().children('select').prop('disabled',false)
                }


            }
            ,
            error:function (data) {
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input[type="radio"]').prop('disabled',false)
                $(value).parent().children('select').prop('disabled',false)
                $('#btnModal2').click()
            }
        });
    }
    function getQuestion5(value,id,pid,cuuent_id){
        valSave(value)

        if($(value).parent().find('.temp').length==0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp '+disCl+'" role="status"></span>');

        var val = $(value).val();
        var cls=$(value).parent('div').parent('div').attr('class')

        if (cls == 'parent_' + pid || cls == 'multi parent_' + pid) {
            $('.parent_' + pid)
                .children()             //Select all the children of the parent
                .not(':first-child')    //Unselect the first child
                .remove();
        } else if (cls == 'parent_' + cuuent_id || cls == 'multi parent_' + cuuent_id) {

            $('.parent_' + pid)
                .children()             //Select all the children of the parent
                .not(':first-child')    //Unselect the first child
                .remove();
        } else {
            if(pid!=73) {
                $('.main_parent_' + pid)
                    .children()             //Select all the children of the parent
                    .not(':first-child')    //Unselect the first child
                    .remove();
            }
        }

        var qID=0;

        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=getQuestion5",
            type: 'POST',
            data: {
                'id': id,
                'value' : val,
            },
            success: function ( data ) {

                $(value).parent().find('.temp').remove()
                var fieldData = '';

                for(var i=0; i<data.data.length; i++) {
                    let noc_attr="data-noc='"+data.data[i].noc_flag+"' data-position='"+data.data[i].position_no+"' data-type='"+data.data[i].noc_type+"' data-label='"+data.data[i].user_type+"'"
                    let permission = '';
                    if(data.data.permission==1)
                    {
                        permission='permitted'
                    }
                    else
                    {
                        permission='forbidden'
                    }
                    qID=data.data[i].question_id;


                    if (data.data[i].casetype == 'group') {
                        fieldData +=data.data[i].group_data;
                        continue;
                    }
                    if (data.data[i].casetype == 'groupques') {
                        fieldData +=data.data[i].group_data2;
                        continue;
                    }
                    fieldData+="<div class='multi parent_"+data.data[i].id+"'>"

                    if(data.data[i].casetype == 'email'){
                        fieldData += "<div style='background: #d1f0d1;display:none' class='form-group sub_question_div email sques_" + id + "' id='sub_question_div_"+data.data[i].id+"'><label class='pb-1'>Email sent successfully</label>";
                        fieldData += "</div>";
                        fieldData+="</div>"
                        $('.parent_'+id).append(fieldData)
                        fieldData = "";

                    }
                    else  if(data.data[i].casetype == 'exit' || data.data[i].casetype == 'none'){
                        fieldData += "";
                        continue;
                    }
                    else if (data.data[i].casetype == 'end')
                    {
                        $('#btnModal').click()
                    }
                    else
                    {
                        if (data.data[i].check == 1) {
                            fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_"+data.data[i].id+"'>"
                            if(data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass')
                            {
                                if(localStorage.getItem('Lang') !== 'english'){
                                    notesTrans(data.data[i].notes);
                                }

                                if(rTitle=='')
                                {
                                    fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                }
                                else
                                {
                                    fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                    rTitle='';

                                }
                            }
                            fieldData+="<label class='pb-1'>" + data.data[i].other + "</label>";
                        }


                        else if (data.data[i].check == 4) {
                            fieldData='';
                            fieldData +=data.data[i].gData;

                            gv=$('#question_div_'+data.data[i].checkQuesID).children('div').children('input[type="radio"]:checked')
                            cv=data.data[i].checkVal;
                            hv=data.data[i].hideQuesID;
                            continue;
                        }
                        else
                        {
                            fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_"+data.data[i].id+"'>"
                            if(data.data[i].notes != '' && data.data[i].notes != null)
                            {
                                if(localStorage.getItem('Lang') !== 'english'){
                                    notesTrans(data.data[i].notes);
                                }

                                if(rTitle=='')
                                {
                                    fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                }
                                else
                                {
                                    fieldData += "<p class='notesPara'>" + rTitle + " </p>"
                                    rTitle='';

                                }
                            }
                            if(localStorage.getItem('Lang') !== 'english'){
                                translateVal(data.data[i].question);
                            }

                            if(rTitle=='')
                            {
                                fieldData+="<label class='pb-1'>" + data.data[i].question + "</label>";

                            }
                            else
                            {
                                fieldData+="<label class='pb-1'>" + rTitle + "</label>";
                                rTitle='';

                            }

                        }
                        fieldData+="<div class='input-group input-group-merge "+permission+"'>"

                        if(data.data[i].field == 'radio' && data.data[i].labeltype == 0){

                            let y='Yes'
                            let n='No'
                            if(localStorage.getItem('Lang') !== 'english'){
                                customLabel(y,'conversion',data.data[i].field);
                                if(rTitle!='')
                                {
                                    y=rTitle;
                                    rTitle='';
                                }
                                customLabel(n,'conversion',data.data[i].field);
                                if(rTitle!='')
                                {
                                    n=rTitle;
                                    rTitle='';
                                }
                            }

                            fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + "," + '' + ")' value='Yes' "+noc_attr+"><span class='customLabel'>"+ y +"</span>"
                            fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + "," + '' + ")' value='No' "+noc_attr+"><span class='customLabel'>" +n+ "</span>";


                        }

                        else if(data.data[i].field == 'radio' && data.data[i].labeltype == 1){
                            fieldData += data.data[i].radios;
                        }
                        else if(data.data[i].field == 'phone'){
                            fieldData += "<input "+data.data[i].validation+" type='tel' onkeyup='validate(this)'  minlength='6' maxlength='15' class='form-control' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">";
                        }
                        else if(data.data[i].field == 'calender'){
                            fieldData += "<input "+data.data[i].validation+" type='text' class='form-control datepicker' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">";
                        }
                        else if(data.data[i].field == 'age'){
                            fieldData += "<input "+data.data[i].validation+" type='text' class='form-control datepicker age' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">";
                            fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*"+data.data[i].id +"'>"

                        }
                        else if(data.data[i].field == 'email'){
                            fieldData += "<input "+data.data[i].validation+" type='email' class='form-control' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">";
                        }

                        else if(data.data[i].field == 'country'){
                            fieldData+="<select "+data.data[i].validation+" class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + " , "+data.data[i].question_id+")' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">"
                            fieldData+="<option value='' disabled selected>-- Select --</option>";
                            for (var j = 0; j < (data.country).length; j++) {
                                let c=data.country[j].name
                                fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                            }
                            fieldData+="</select>"
                        }else if (data.data[i].field == 'education') {
                            fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + ")' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                            fieldData += "<option value='' disabled selected>-- Select --</option>";
                            for (var j = 0; j < (data.education).length; j++) {
                                let c=data.education[j].name
                                fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                            }
                            fieldData += "</select>"
                        }
                        else if(data.data[i].field == 'dropdown'){
                            fieldData+="<select "+data.data[i].validation+" class='form-control' onchange='getQuestion3(this,"+data.data[i].id+","+data.data[i].question_id+")' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">"
                            fieldData+="<option value='' disabled selected>-- Select --</option>";
                            fieldData += data.data[i].dropdown;
                            fieldData+="</select>"
                        }
                        else if (data.data[i].field == 'nocjob') {
                            fieldData += "<input " + data.data[i].validation + " class='form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                        } else if (data.data[i].field == 'nocduty') {
                            fieldData += "<input " + data.data[i].validation + " class='form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">"
                        }
                        else if(data.data[i].field=='pass')
                        {
                            fieldData+="<label class='notesPara2'>"+data.data[i].notes+"</label>"
                        }
                        else if(data.data[i].field=='number')
                        {
                            fieldData += "<input " + data.data[i].validation + "  type='number' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";

                        }

                        else if(data.data[i].field=='currentrange')
                        {
                            let current_datetime = new Date()
                            let m=((current_datetime.getMonth()+1)>=10)? (current_datetime.getMonth()+1) : '0' + (current_datetime.getMonth()+1);
                            let d=((current_datetime.getDate())>=10)? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                            let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d
                            fieldData += "<label class='pb-date'>From</label><label class='pb-date'>To</label>"

                            fieldData += "<input " + data.data[i].validation + " data-id='from'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            fieldData += "<input " + data.data[i].validation + " data-id='to' onchange='if(checkDate(this)){getQuestion3(this,"+data.data[i].id+","+question_id+")}'   max='"+formatted_date+"'  type='date' class='form-control' name='n[sub_question_" + data.data[i].id + "]' "+noc_attr+">";
                            fieldData += "</div>";

                        }
                        else {
                            fieldData += "<input "+data.data[i].validation+" type='text' onfocusout='getQuestion3(this,"+data.data[i].id+","+data.data[i].question_id+")' class='form-control' name='n[sub_question_"+data.data[i].id+"]' "+noc_attr+">";
                            fieldData+="<em style='font-size: 12px;font-style: italic;'>Press tab to continue</em>"
                        }
                    }

                    fieldData += "</div>";
                    fieldData+="</div>";
                    fieldData+="</div>";



                }
                if(cls=='parent_'+pid || cls=='multi parent_'+pid)
                {

                    $('.parent_'+pid).append(fieldData)

                }
                else if(cls=='parent_'+cuuent_id || cls=='multi parent_'+cuuent_id)
                {
                    $('.parent_'+pid).append(fieldData)
                }
                else
                {


                    if(qID==33)
                    {

                        $('.main_parent_33').children('.multi').remove();
                    }
                    if(qID!=73 && id!=73 && qID!=33 && id!=33 && qID!=84 && id!=84)
                    {
                        $('.main_parent_' + qID)
                            .children()             //Select all the children of the parent
                            .not(':first-child')    //Unselect the first child
                            .remove();
                    }
                    $('.main_parent_'+qID).append(fieldData)
                }
                formFunc(value)


            }
            ,
            error:function (data) {
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input[type="radio"]').prop('disabled',false)
                $(value).parent().children('select').prop('disabled',false)
                $('#btnModal2').click()
            }
        });

    }
    function getQuestion6(id,type,ques_id) {


        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=getQuestion6",
            type: 'POST',
            data: {
                'id': id,
                'questiontype': type,
                'ques_id':ques_id
            },
            success: function (data) {
                // $('.'+data.class).remove()
                $('.formDiv').append(data.data[0].html)
                formFunc()
                tagsInp()
            }
            ,
            error: function (data) {
                $('#btnModal2').click()
            }


        });

    }
    function afterForm(e)
    {
        let a=$(e).parent().parent().parent()
        if(!a.hasClass('afterSub'))
        {
            let v=$('#submitCheck').val()
            if(v==1 || v=='1')
            {
                $('.afterSub').remove()
            }
        }


    }
    function ageLimit(c,age) {

        if(check_cond(years,c,age))
        {
            return true;
        }
        return false
    }
    function  movegroup(e) {

        let bool=false;
        for(let k=0;k<checkField.length;k++)
        {
            $('.displayNone'+hiddenQues[k]).hide();
            $('.main_parent_'+hiddenQues[k]).not(':first').remove()
            if(checkField[k]=='age')
            {

                let c = checkOp[k];
                if(check_cond(years,c,checkValue[k]))
                {
                    $('.main_parent_'+hiddenQues[k]).show()
                }
            }
            else
            {
                let sv=document.getElementsByName('n[sub_question_2'+checkQues[k]+' ')
                let sel=document.getElementsByName('n[question_'+checkQues[k]+']')
                gv=$('#question_div_'+checkQues[k]).children('div').children('input[type="radio"]:checked')

                if($(gv).length > 0 && $(gv).val()==checkValue[k])
                {
                    $('.main_parent_'+hiddenQues[k]).show()
                }
                else if($(sv.item(0)).val()==checkValue[k])
                {
                    $('.main_parent_'+hiddenQues[k]).show()
                }
                else
                {
                    if(sel.length > 0 && hiddenQues[k]==74)
                    {
                        if(bbb==false) {
                            movegroup4(sel)
                        }
                    }
                }
            }
        }

    }
    function movegroup2(e)
    {
        let val=$(e).attr('id')
        let val2=val.split('_')


        for(let k=0;k<checkQues.length;k++)
        {
            if(checkQues[k]==val2[1])
            {
                let c =$('#question_div_'+checkQues[k]).children('div').children('input[type="radio"]:checked')


                if($(c).length > 0 && $(c).val()==checkValue[k])
                {
                    $('.main_parent_'+hiddenQues[k]).show()

                }
                else
                {

                    c =$('#sub_question_div_'+checkQues[k]).children('input[type="radio"]:checked')

                    if($(c).length > 0 && $(c).val()==checkValue[k])
                    {
                        $('.main_parent_'+hiddenQues[k]).show()

                    }
                    else {

                        $('.main_parent_' + hiddenQues[k])
                            .children()
                            .not(':first-child')
                            .remove();
                        $('.main_parent_' + hiddenQues[k]).hide()
                        $('.main_parent_' + hiddenQues[k]).children().children('div').children('input[type="radio"]').prop('checked', false)
                    }
                }
            }
        }

    }
    function  movegroup3(e) {

        let dateVal=$(e).val()
        dateVal=dateVal.split(',')
        let sDate2=dateVal[0]+"/"+dateVal[1]+"/"+dateVal[2]
        let enteredDate2 = sDate2
        let y = new Date(new Date() - new Date(enteredDate2)).getFullYear() - 1970;
        let name=$(e).attr('name')

        name=name.split('_')
        let name2=name[1].slice(0,-1)

        for(let k=0;k<checkField.length;k++) {
            if (name2 == checkQues[k]) {
                $('.main_parent_' + hiddenQues[k])
                    .children()
                    .not(':first-child')
                    .remove();
                $('.main_parent_' + hiddenQues[k]).hide()
                $('.main_parent_' + hiddenQues[k]).children().children('div').children('input[type="radio"]').prop('checked', false)
            }

        }
        for(let k=0;k<checkField.length;k++) {

            if (name2 == checkQues[k]) {
                let c = checkOp[k];

                if(check_cond(y,c,checkValue[k]))
                {
                    $('.main_parent_' + hiddenQues[k]).show()
                }
            }
        }
    }
    function  movegroup4(e) {

        let dateVal=$(e).val()

        let y = dateVal
        let name=$(e).attr('name')
        let name2='';
        if(name!=undefined || name!='') {
            name = name.split('_')
            name2=name[1].slice(0,-1)

        }
        for(let k=0;k<checkField.length;k++) {

            if (name2 == checkQues[k]) {
                console.log(name2+'=='+checkQues[k])
                console.log(e)
                let c = checkOp[k];
                {
                    if (check_cond(y, c, checkValue[k])) {
                        $('.main_parent_' + hiddenQues[k]).show()
                        bbb = true;
                    }
                    else {
                        $('.main_parent_' + hiddenQues[k]).hide()
                        bbb=false;
                    }
                }

            }

        }
    }
    function multi(current_id) {
        var count1 = 0;
        let sid = [];
        var current_id2=0;
        let op='';

        for (let i = 0; i < localStorage.length; i++) {
            if ((current_id == localStorage.getItem('ex_sid-' + i) || current_id == localStorage.getItem('ex_qid-' + i))) {
                if(sid[i-1]==localStorage.getItem('sid-'+i))
                {
                    continue;
                }
                else
                {
                    sid[i] = localStorage.getItem('sid-' + i);
                    op=localStorage.getItem('andor-' + i);

                }

            }
        }

        var sval=0;
        var mQues=0;
        for (let i = 0; i < sid.length; i++)
        {
            for (let j = 0; j < localStorage.length; j++) {
                var d='';
                if(localStorage.getItem('ex_sid-' + j)!=0)
                    d=document.getElementsByName('n[sub_question_'+localStorage.getItem('ex_sid-' + j)+']')
                else
                    d=document.getElementsByName('n[question_'+localStorage.getItem('ex_qid-' + j)+']')
                if($(d).hasClass('countryCheck'))
                {
                    if(localStorage.getItem('op-'+j)=='==' || localStorage.getItem('op-'+j)=='=')
                    {
                        if (($(d).val()==localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                        {

                            count1++;
                            sval=localStorage.getItem('value-' + j)
                            if(localStorage.getItem('ex_sid-' + j)==0)
                            {
                                current_id2 = localStorage.getItem('ex_qid-' + j)
                            }
                            else
                            {
                                current_id2 = localStorage.getItem('ex_sid-' + j)
                            }
                            mQues = localStorage.getItem('mainQues-'+j)

                        }
                    }
                    else if(localStorage.getItem('op-'+j)=='!=' )

                        if (($(d).val()!=localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                        {
                            count1++;
                            sval=localStorage.getItem('value-' + j)
                            if(localStorage.getItem('ex_sid-' + j)==0)
                            {
                                current_id2 = localStorage.getItem('ex_qid-' + j)
                            }
                            else
                            {
                                current_id2 = localStorage.getItem('ex_sid-' + j)
                            }
                            mQues = localStorage.getItem('mainQues-'+j)

                        }
                }
                else if(localStorage.getItem('op-'+j)=='>=' )
                {
                    if (($(d).val()>=localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            current_id2 = localStorage.getItem('ex_sid-' + j)
                        }
                        mQues = localStorage.getItem('mainQues-'+j)

                    }
                }
                else if(localStorage.getItem('op-'+j)=='<=' )
                {
                    if (($(d).val()<=localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            current_id2 = localStorage.getItem('ex_sid-' + j)
                        }
                        mQues = localStorage.getItem('mainQues-'+j)

                    }
                }
                else if(localStorage.getItem('op-'+j)=='>' )
                {
                    if (($(d).val()>localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            current_id2 = localStorage.getItem('ex_sid-' + j)
                        }
                        mQues = localStorage.getItem('mainQues-'+j)

                    }
                }
                else if(localStorage.getItem('op-'+j)=='<' )
                {
                    if (($(d).val()<localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            current_id2 = localStorage.getItem('ex_sid-' + j)
                        }
                        mQues = localStorage.getItem('mainQues-'+j)

                    }
                }
                else if(localStorage.getItem('op-'+j)=='=' && d.length==1)
                {
                    if (($(d).val()==localStorage.getItem('value-' + j) ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            current_id2 = localStorage.getItem('ex_sid-' + j)
                        }
                        mQues = localStorage.getItem('mainQues-'+j)

                    }
                }
                else
                {
                    if (($('#' + localStorage.getItem('value-' + j) + '_' + localStorage.getItem('ex_sid-' + j)).is(":checked") ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            if(localStorage.getItem('ex_sid-' + j)==0)
                            {
                                current_id2 = localStorage.getItem('ex_qid-' + j)
                            }
                            else
                            {
                                current_id2 = localStorage.getItem('ex_sid-' + j)
                            }
                        }
                    }
                    else if (($('#' + localStorage.getItem('value-' + j) + '_' + localStorage.getItem('ex_qid-' + j)).is(":checked") ) && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            if(localStorage.getItem('ex_sid-' + j)==0)
                            {
                                current_id2 = localStorage.getItem('ex_qid-' + j)
                            }
                            else
                            {
                                current_id2 = localStorage.getItem('ex_sid-' + j)
                            }
                        }
                    }
                    else if (($('#Yes_'+ localStorage.getItem('ex_sid-' + j)).is(":checked") || $('#No_'+ localStorage.getItem('ex_sid-' + j)).is(":checked")) && localStorage.getItem('value-' + j)=='None' && localStorage.getItem('sid-' + j) == sid[i])
                    {
                        count1++;
                        sval=localStorage.getItem('value-' + j)
                        if(localStorage.getItem('ex_sid-' + j)==0)
                        {
                            current_id2 = localStorage.getItem('ex_qid-' + j)
                        }
                        else
                        {
                            if(localStorage.getItem('ex_sid-' + j)==0)
                            {
                                current_id2 = localStorage.getItem('ex_qid-' + j)
                            }
                            else
                            {
                                current_id2 = localStorage.getItem('ex_sid-' + j)
                            }
                        }
                    }
                    else
                    {
                        if((current_id==localStorage.getItem('ex_sid-' + j) || current_id==localStorage.getItem('ex_qid-' + j)) && localStorage.getItem('value-' + j)=='None' && localStorage.getItem('sid-' + j) == sid[i])

                        {
                            count1++;
                            sval=localStorage.getItem('value-' + j)
                            if(localStorage.getItem('ex_sid-' + j)==0)
                            {
                                current_id2 = localStorage.getItem('ex_qid-' + j)
                            }
                            else
                            {
                                if(localStorage.getItem('ex_sid-' + j)==0)
                                {
                                    current_id2 = localStorage.getItem('ex_qid-' + j)
                                }
                                else
                                {
                                    current_id2 = localStorage.getItem('ex_sid-' + j)
                                }
                            }
                        }
                    }
                }

            }

            if((op=='or' && count1 > 0) || (op!='or' && count1==count[sid[i]])) {
                let sval2 = document.getElementsByName('n[sub_question_' + current_id + ']')
                getQuestion5(sval2.item(0), sid[i], current_id2,current_id)
            }else{
                $('#Yes_'+sid[i]).prop('checked',false)
                $('#No_'+sid[i]).prop('checked',false)
                $('.parent_'+sid[i]).remove();
                $('.main_parent_'+sid[i]).remove();
            }

            count1=0;
        }


    }

    function countryFunc(e)
    {
        var cval= $(e).val()
        let name= ($(e).attr('name')).split('_')
        let n=''
        if(name.length==2)
        {
            n=name[1].slice(0,name[1].length-1)

        }
        else
        {
            n=name[2].slice(0,name[2].length-1)

        }
        let dClas=$(e).parent().parent().attr('class')

        if(cval != 'Other')
        {
            if(dClas=='parent_'+n || dClas=='main_parent_'+n)
            {
                $(e).parent().find('.newCountry').remove()
            }
            else
            {
                $(e).parent().parent().find('.newCountry').remove()
            }
        }
        else
        {
            if(dClas=='parent_'+n)
            {
                $(e).parent().append('<input type="text" class="form-control newCountry" style="margin-top: 2%;">')

            }
            else
            {
                $(e).parent().parent().append('<input type="text" class="form-control newCountry" style="margin-top: 2%;">')

            }
        }
    }
    function noc(e,s)
    {

        let noc_flag=$(e).attr('data-noc')
        let noc_pos=$(e).attr('data-position')
        let noc_user=$(e).attr('data-label')
        let noc_type=$(e).attr('data-type')
        let date_pos=$(e).attr('data-id')
        let index=parseInt(noc_pos)-1


        if(noc_user=='spouse')
        {
            for(let i=0;i<nocSpouse.length;i++)
            {
                nocSpouse[index]=''
            }
        }
        else {
            for (let i = index; i < nocUser.length; i++) {
                nocUser[i] = ''
            }

        }

        if(s=='off')
        {
            if(noc_user=='spouse')
                nocSpouse[index]=''
            else
                nocUser[index]=''
        }
        else {


            if (noc_flag == '1') {

                if (date_pos == 'from') {
                    fromDate = $(e).val()
                } else {
                    let dd = $(e).val()
                    if (dd == 'Present') {
                        dd = new Date()
                    }

                    toDate = dd
                }

                let exp1 = new Date(new Date(toDate) - new Date(fromDate)).getFullYear() - 1970;
                let exp2 = new Date(new Date(toDate) - new Date(fromDate)).getMonth() / 12;
                let exp = parseFloat(exp1) + parseFloat(exp2.toFixed(1));

                let emp = new Date(new Date() - new Date(toDate)).getFullYear() - 1970;
                let cemp = 0;
                if (emp <= 0) {
                    cemp = 1;
                }


                if (noc_user == 'spouse')
                    nocSpouse[parseInt(noc_pos) - 1] = {
                        'position': noc_pos,
                        'experience': exp,
                        'employment': cemp,
                        'sdate': fromDate,
                        'edate': toDate
                    }
                else
                    nocUser[parseInt(noc_pos) - 1] = {
                        'position': noc_pos,
                        'experience': exp,
                        'employment': cemp,
                        'sdate': fromDate,
                        'edate': toDate
                    }
            }
        }
        console.log('user')
        console.log(nocUser)
        console.log('spouse')
        console.log(nocSpouse)

    }
    function presentBox(e)
    {
        if($(e).prop("checked") == false) {
            $(e).parent().parent().parent().parent().children().not(':first-child')    //Unselect the first child
                .remove();        //Select all the children of the parent

            return false;
        }
    }
    function check_cond (var1, op, var2) {

        switch (op) {
            case "=":  return var1 == var2;
            case "==":  return var1 == var2;
            case "!=": return var1 != var2;
            case ">=": return var1 >= var2;
            case "<=": return var1 <= var2;
            case ">":  return var1 >  var2;
            case "<":  return var1 <  var2;
            default:       return true;
        }
    }
    function tagsInp() {
        console.log('Function Called On Page Load');

        $('.nocJobs').select2({
            data: nocJobs(),
            placeholder: '-Select-',
            multiple: false,
            allowClear: true,
            // creating query with pagination functionality.
            query: function (data) {
                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;
                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },
        });


        $('.nocPos').select2({
            data: nocPos(),
            placeholder: '-Select-',
            multiple: false,
            allowClear: true,
            // creating query with pagination functionality.
            query: function (data) {
                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;
                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },
        });

        $('input.nocJobs').each(function () {
            let val2 =$('div.nocJobs').children().children().html()
            let nocJob=$(this).val()
            let val = $(this).attr('name')
            if(nocJob!='' && nocJob!=null)
            {
                let val1 = val.split('_')
                let id = val1[2].slice(0, -1)
                $("#sub_question_div_" + id +" .select2-chosen").html(nocJob)
            }

        })
        $('input.nocPos').each(function () {
            let val2 =$('div.nocPos').children().children().html()
            let nocJob=$(this).val()
            let val = $(this).attr('name')
            if(nocJob!=='' && nocJob!==null)
            {
                let val1 = val.split('_')
                let id = val1[2].slice(0, -1)
                $("#sub_question_div_" + id +" .select2-chosen").html(nocJob)
            }


        })

    }
    function checkDate(e) {
        let dt=$(e).attr('data-id')
        if(dt=='to')
        {
            let from = new Date($(e).prev('input[type="date"]').val());
            let to = new Date($(e).val());
            if (to.getTime() < from.getTime()) {
                alert("This date is smaller than previous");
                $(e).val('mm/dd/yyyy')
            }
            else
            {
                return true
            }
        }
        else if(dt=='from')
        {
            let from = new Date($(e).val());
            let to = new Date($(e).next('input[type="date"]').val());
            if (from.getTime() > to.getTime()) {
                alert("This date is greater than next");
                $(e).val('mm/dd/yyyy')
            }
            else
            {
                return true
            }
        }
        return false
    }


    $( '#validateform' ).validate( {
        errorPlacement: function(error, element) {
            if (element.attr("type") == "radio"){
                error.appendTo(element.parent('div.input-group'));
            }else{
                error.insertAfter(element);

            }

        },
        submitHandler: function () {
            'use strict';

            $('.score_loading').html('Calculating Scoring ....');
            $('#preloader').css('display','block');

            $( "#btnLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            let email=$('input[type="email"]:first').val()
            let phone=$('input[type="tel"]:first').val()
            let name=$('input[type="text"]').eq(1).val()
            let token='<?php if(isset($_GET['code']))echo $_GET['code']; else echo''; ?>'

            let dob=[];

            var assistance_ids='';
            var assistance='<ul>';
            $('.email').each(function(i, obj) {
                let p=$(this).parent().parent().children('div').children('label').html()
                let id1=$(this).parent().parent().attr('class').split('_')

                assistance +='<li>'+p+'</li>'
                assistance_ids= id1[1]+',';
            });
            $(".age").each(function(){
                let dateVal=$(this).val()
                dateArray[dateCheck]=dateVal
                dateVal=dateVal.split(',')
                let sDate=dateVal[0]+"/"+dateVal[1]+"/"+dateVal[2]
                let enteredDate = sDate
                let y = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
                $(this).val(y)
                dateCheck++;
            });

            let formData=$('.myForm').serializeArray()

            $(".age").each(function(){
                $(this).val(dateArray[dateCheck2])
                dateCheck2++;
            });
            $(".dob").each(function(){
                let name=$(this).attr('name')
                name=name.split('*')
                dob[name[1]]=$(this).val()
            });

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=submitForm",
                type: 'POST',
                async:false,
                data: {
                    'form': formData,
                    'formHtml':$('.myForm').html(),
                    'dob':dob,
                    'email' : email,
                    'assistance':assistance_ids,
                    'phone':phone,
                    'name':name,
                    'nocUser':nocUser,
                    'spouseUser':nocSpouse,
                    'scoreID':$('#scoreID').val(),
                    'scoreArray':scoreArray,
                    'nocArray':nocArray,
                    'scoreArray2':scoreArray2,
                    'rType':rType,
                    'token':token

                },

                success: function ( data ) {
                    $('#preloader').hide()
                    $('.score_loading').html('')

                    if(data.Success=='ques')
                    {
                        $( "#btnLoader" ).html( 'Continue' );

                        getQuestion6(data.question.move_qid,data.question.move_qtype,data.question.q_id)
                        $('#scoreID').val(data.question.scoreID);
                        scoreArray=data.scoreArray;
                        scoreArray2=data.scoreArray2;

                        nocArray=data.nocArray;
                        rType='question';
                    }
                    else if(data.Success=='noc_ques')
                    {
                        $( "#btnLoader" ).html( 'Continue' );

                        getQuestion6(data.question.move_qid,data.question.move_qtype,data.question.q_id)
                        $('#scoreID').val(data.question.scoreID);
                        scoreArray=data.scoreArray;
                        scoreArray2=data.scoreArray2;

                        nocArray=data.nocArray;
                        rType='question';
                    }
                    else  if(data.Success=='scoring')
                    {
                        $( "#btnLoader" ).html( 'Continue' );

                        $('#scoreID').val(data.question.move_scoreType);
                        scoreArray=data.scoreArray;
                        scoreArray2=data.scoreArray2;

                        nocArray=data.nocArray;
                        rType='scoring';
                        $('.myForm').submit();
                    }
                    else  if(data.Success=='comment')
                    {
                        $( "#btnLoader" ).html( 'Continue' );
                        $('#scoreID').val(data.question.scoreID);
                        scoreArray=data.scoreArray;
                        scoreArray2=data.scoreArray2;

                        nocArray=data.nocArray;
                        rType='comment';

                        let ht='<div class="afterSub"><div class="form-group form-group sub_question_div2 ">';
                        ht+= '<label>'+data.question.comments+'</label>';
                        ht+='</div></div>';
                        $('.formDiv').append(ht)
                        $('.myForm').submit();
                    }
                    else if(data.Success=='true')
                    {
                        $( "#btnLoader" ).html( 'Submit' );
                        $('#scoreID').val('')
                        $( window ).scrollTop( 0 );
                        $( '.prompt2' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );

                        $('.forbidden').children('input').css('pointer-events','none')
                        $('.forbidden').attr('title','This question is forbidden')
                        $('.forbidden').children('select').css('pointer-events','none')
                        $('#submitCheck').val(1)

                    }
                    else
                    {
                        $( window ).scrollTop( 0 );
                        $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt2" ).html('');
                        }, 5000 );
                    }

                }
                ,
                error:function (data) {
                    $('#preloader').hide()
                    $('.score_loading').html('')
                    $( "#btnLoader" ).html( 'Submit' );

                    $( window ).scrollTop( 0 );
                    $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt2" ).html('');
                    }, 5000 );
                }


            });


            return false;
        }
    } );


    ///==================local storage work========================

    $(document).ready(function () {

        $('.terms').hide()
        if(!localStorage.getItem('oldFlag')) {
            localStorage.setItem('oldFlag', 0)
            localStorage.setItem('newFlag', 0)
        }

        $('input,textarea').attr('autocomplete', 'off');

        let form_id=<?php echo $_GET['id']; ?>;
        if(localStorage.getItem('form_'+form_id))
        {
            $('.myForm').html('')
            $('.myForm').html(localStorage.getItem('form_'+form_id))
            $('body').css('opacity',0.5)
            $('#formLoader').show()
        }

    })
    $(document).on('change', 'input[type="radio"],select,.datepicker', function(){
        valSave(this)
    });
    $(document).on('keyup', 'input', function(){
        valSave(this)
    });
    $(document).on('change','select[name="is_email"]',function () {
        $('#btnModal').click()
    })


    function valSave(e) {

        let dt=$(e).attr('data-id')
        let ex=''
        if(dt=='from')
        {
            ex=' from'
        }
        let val=$(e).val();
        let id= $(e).attr('name')
        localStorage.setItem(id+ex,val);
        formFunc('')
        if(nocUser.length > 0)
            localStorage.setItem('nocUser',JSON.stringify(nocUser))
        if(nocSpouse.length > 0)
            localStorage.setItem('nocSpouse',JSON.stringify(nocSpouse))


    }
    function formFunc(e)
    {
        let form_id=<?php echo $_GET['id']; ?>;
        let v= $('.myForm').html()

        try {
            localStorage.setItem('form_'+form_id,v);

        } catch (e) {
            Storage.prototype._setItem = Storage.prototype.setItem;
            Storage.prototype.setItem = function() {};
        }

        callLabelDir();

        if(localStorage.getItem('display')=='Right to Left')
        {
            $('.input-group-merge').addClass('urduField')
        }
        else
        {
            $('.input-group-merge').removeClass('urduField')
        }

        onQuesCall();
    }
    setTimeout(function(){
        let q;
        for (var key in localStorage) {
            if(key !== 'newFlag' && key !== 'oldFlag' && key !== 'oldLang' && key !== 'Lang' && key !== 'display' && key !== 'nocSpouse' && key !== 'nocUser') {

                if (key[0] == 'n') {
                    let k = key.split('_')
                    let k2;
                    let value = localStorage[key]
                    let type = jQuery('[name="' + key + '"]').attr('type')

                    if (k.length > 2) {
                        k2 = k[2].slice(0, -1);
                    } else {
                        k2 = k[1].slice(0, -1);
                        q = k2
                    }
                    if (type == 'radio') {
                        // document.getElementById(value + '_' + k2).checked = true;
                        if(value=='Yes')
                        {
                            document.getElementsByName(key)[0].checked = true;

                        }
                        else
                        {
                            document.getElementsByName(key)[1].checked = true;

                        }


                    } else {

                        if(key.includes('from')) {
                            let key2=key.replace(" from", "");
                            let d=document.getElementsByName(key2)
                            document.getElementsByName(key2)[0].value = value;
                            continue
                        }
                        if(value=='Present')
                        {
                            $('input[name="' + key + '"]').parent().children('div').children('input').attr('checked','checked');
                        }
                        if (localStorage.hasOwnProperty(key+" from")) {
                            $('[name="' + key + '"]').eq(1).val(value);
                        }
                        else
                        {
                            $('[name="' + key + '"]').val(value);
                        }
                    }
                }
                $('body').css('opacity', 1)
                if(localStorage.getItem('oldFlag') == localStorage.getItem('newFlag') ) {

                }

            }
        }

    }, 2000);
    setTimeout(function(){

        // if(localStorage.getItem('oldFlag') !== localStorage.getItem('newFlag')){
        //     callTranslations();
        // }


        formFunc('');
        if(localStorage.getItem('nocUser')!='' && localStorage.getItem('nocUser')!=null)
            nocUser= JSON.parse(localStorage.getItem('nocUser'))
        if(localStorage.getItem('nocSpouse')!='' && localStorage.getItem('nocSpouse')!=null)
            nocSpouse= JSON.parse(localStorage.getItem('nocSpouse'))
    }, 4000);

    setTimeout(function(){

        $('div.nocJobs , div.nocPos').select2('destroy');
        $('div.nocJobs ,div.nocPos').remove();
    },2000);

    setTimeout(function(){

        $('body').css('opacity',1)
        $('#validateform').show();

        tagsInp();
        $("div.nocJobs,div.nocPos").css("display",'block');
        $('#formLoader').hide();

    }, 6000);

    setTimeout(function(){
        localStorage.setItem('newFlag' , 0);
    },8000);


    $(".submit").click(function () {
        return false;
    });


    function callTranslations(){
        let form_id=<?php echo $_GET['id']; ?>;
        var localData = localStorage.getItem('form_'+form_id);
        var oldLang = '' , valueLabel = '';



        // Change Values of Questions
        var elements = document.getElementsByTagName("label");
        for (var i = 0; i < elements.length; i++) {
            var valueLabel = '';
            if(elements[i].value == "") {
            }else{
                if(localStorage.getItem('Lang') == 'english'){
                    valueLabel = elements[i].innerHTML;
                    for(var loop = 0; loop < quesArr.length ; loop++){
                        if(quesArr[loop].translation == valueLabel){
                            // console.log(valueLabel);
                            if(quesArr[loop].label !== ''){
                                elements[i].innerHTML = quesArr[loop].label;
                            }
                            break;
                        }
                    }
                }else if(localStorage.getItem('Lang') !== 'english' && localStorage.getItem('oldLang') !== 'english'){
                    valueLabel = elements[i].innerHTML;
                    for(var loop = 0; loop < quesArr.length ; loop++){
                        if(quesArr[loop].translation == valueLabel){
                            // console.log(valueLabel);
                            if(quesArr[loop].otranslation !== ''){
                                elements[i].innerHTML = quesArr[loop].otranslation;
                            }
                            break;
                        }else{
                            valueLabel = elements[i].innerHTML.trim();
                            // console.log(valueLabel);
                            if(quesArr[loop].label == valueLabel || quesArr[loop].labelCon == valueLabel || quesArr[loop].labelrTrim == valueLabel || quesArr[loop].labelTrim == valueLabel || quesArr[loop].translation == valueLabel){
                                if(quesArr[loop].otranslation !== ''){
                                    elements[i].innerHTML = quesArr[loop].otranslation;
                                }

                                break;
                            }
                        }
                    }
                }else{
                    for(var loop = 0; loop < quesArr.length ; loop++){
                        valueLabel = elements[i].innerHTML.toLowerCase().trim();
                        if(quesArr[loop].label == valueLabel || quesArr[loop].labelCon == valueLabel || quesArr[loop].labelrTrim == valueLabel || quesArr[loop].labelTrim == valueLabel){
                            if(quesArr[loop].translation !== ''){
                                elements[i].innerHTML = quesArr[loop].translation;
                            }

                            break;
                        }else{
                            valueLabel = elements[i].innerHTML.trim();
                            if(quesArr[loop].label == valueLabel || quesArr[loop].labelCon == valueLabel || quesArr[loop].labelrTrim == valueLabel || quesArr[loop].labelTrim == valueLabel){
                                if(quesArr[loop].translation !== ''){
                                    elements[i].innerHTML = quesArr[loop].translation;
                                }

                                break;
                            }
                        }
                    }
                }
                rTitle='';
            }
        }

        // Change values of Notes
        $("form#validateform p.notesPara").each(function(){
            var spanLabel = $(this).text();
            if(spanLabel == "") {
            }else{
                if(localStorage.getItem('Lang') == 'english'){
                    for(var loop = 0; loop < notesArr.length ; loop++){
                        if(notesArr[loop].notes_translation == spanLabel){
                            // console.log(spanLabel);
                            if(notesArr[loop].notes !== ''){
                                $(this).html(notesArr[loop].notes);
                            }
                            break;
                        }
                    }
                }else if(localStorage.getItem('Lang') !== 'english' && localStorage.getItem('oldLang') !== 'english'){
                    for(var loop = 0; loop < notesArr.length ; loop++){
                        if(notesArr[loop].notes_translation == spanLabel){
                            // console.log(spanLabel);
                            if(notesArr[loop].notes_otranslation !== ''){
                                $(this).html(notesArr[loop].notes_otranslation);
                            }
                            break;
                        }else{
                            spanLabel = spanLabel.trim();
                            if(notesArr[loop].notes == spanLabel || notesArr[loop].notesCon == spanLabel || notesArr[loop].notesrTrim == spanLabel || notesArr[loop].notesTrim == spanLabel || notesArr[loop].notes_translation == spanLabel){
                                if(notesArr[loop].notes_otranslation !== ''){
                                    elements[i].innerHTML = notesArr[loop].notes_otranslation;
                                }

                                break;
                            }
                        }
                    }
                }else{
                    for(var loop = 0; loop < notesArr.length ; loop++){
                        spanLabel = spanLabel.toLowerCase().trim();
                        if(notesArr[loop].notes == spanLabel || notesArr[loop].notesCon == spanLabel || notesArr[loop].notesrTrim == spanLabel || notesArr[loop].notesTrim == spanLabel){
                            if(notesArr[loop].notes_translation !== ''){
                                $(this).html(notesArr[loop].notes_translation);
                            }
                            break;
                        }else{
                            spanLabel = spanLabel.trim();
                            if(notesArr[loop].notes == spanLabel || notesArr[loop].notesCon == spanLabel || notesArr[loop].notesrTrim == spanLabel || notesArr[loop].notesTrim == spanLabel){
                                if(notesArr[loop].notes_translation !== ''){
                                    $(this).html(notesArr[loop].notes_translation);
                                }
                                break;
                            }
                        }
                    }
                }
            }
        });

        // Custom Labels
        $("form#validateform span.customLabel").each(function(){
            var spanLabel = $(this).text();
            if(spanLabel == "") {
                //alert(spanLabel);
            }else{
                if(localStorage.getItem('Lang') == 'english'){
                    for(var loop = 0; loop < optionsArr.length ; loop++){
                        if(optionsArr[loop].opt_translation == spanLabel){
                            // console.log(spanLabel);
                            if(optionsArr[loop].opt !== ''){
                                $(this).html(optionsArr[loop].opt);
                            }
                            break;
                        }
                    }
                }else if(localStorage.getItem('Lang') !== 'english' && localStorage.getItem('oldLang') !== 'english'){
                    for(var loop = 0; loop < optionsArr.length ; loop++){
                        if(optionsArr[loop].opt_translation == spanLabel){
                            // console.log(spanLabel);
                            if(optionsArr[loop].opt_otranslation !== ''){
                                $(this).html(optionsArr[loop].opt_otranslation);
                            }
                            break;
                        }else{
                            spanLabel = spanLabel.trim();
                            if(optionsArr[loop].opt == spanLabel || optionsArr[loop].optCon == spanLabel || optionsArr[loop].optlTrim == spanLabel || optionsArr[loop].optTrim == spanLabel || optionsArr[loop].opt_translation == spanLabel){
                                if(optionsArr[loop].opt_otranslation !== ''){
                                    $(this).html(optionsArr[loop].opt_otranslation);
                                }

                                break;
                            }
                        }
                    }
                }else{
                    for(var loop = 0; loop < optionsArr.length ; loop++){
                        spanLabel = spanLabel.toLowerCase().trim();
                        if(optionsArr[loop].opt == spanLabel || optionsArr[loop].optCon == spanLabel || optionsArr[loop].optlTrim == spanLabel || optionsArr[loop].optTrim == spanLabel){
                            if(optionsArr[loop].opt_translation !== ''){
                                $(this).html(optionsArr[loop].opt_translation);
                            }
                            break;
                        }else{
                            spanLabel = spanLabel.trim();
                            if(optionsArr[loop].opt == spanLabel || optionsArr[loop].optCon == spanLabel || optionsArr[loop].optlTrim == spanLabel || optionsArr[loop].optTrim == spanLabel){
                                if(optionsArr[loop].opt_translation !== ''){
                                    $(this).html(optionsArr[loop].opt_translation);
                                }

                                break;
                            }
                        }
                    }
                }
            }
        });

        //Change Values of Dropdown Options
        var selectCount = 0;
        $("form#validateform select").each(function(){
            var selectValue = $(this).val();
            $(this).addClass("countryLoop"+selectCount);
            if($(this).hasClass("countryCheck")){
                $(".countryLoop"+selectCount).find('option:not(:first)').remove();
                var country = '';
                // console.log(ArrCountry.length);
                for (var j = 0; j < ArrCountry.length; j++) {
                    country += '<option value="'+ArrCountry[j].value+'">'+ArrCountry[j].name+'</option>';
                }
                $(".countryLoop"+selectCount).append(country);
                $(".countryLoop"+selectCount).val(selectValue);
                selectCount++;
            }else{
                var length = $(this).length;
                if(length > 50){

                }else{
                    $("select option").each(function(){
                        var spanLabel = $(this).text();
                        if(spanLabel == "") {
                        }else{
                            if(localStorage.getItem('Lang') == 'english'){
                                for(var loop = 0; loop < optionsArr.length ; loop++){
                                    if(optionsArr[loop].opt_translation == spanLabel){
                                        // console.log(spanLabel);
                                        if(optionsArr[loop].opt !== ''){
                                            $(this).html(optionsArr[loop].opt);
                                        }
                                        break;
                                    }
                                }
                            }else if(localStorage.getItem('Lang') !== 'english' && localStorage.getItem('oldLang') !== 'english'){
                                for(var loop = 0; loop < optionsArr.length ; loop++){
                                    if(optionsArr[loop].opt_translation == spanLabel){
                                        // console.log(spanLabel);
                                        if(optionsArr[loop].opt_otranslation !== ''){
                                            $(this).html(optionsArr[loop].opt_otranslation);
                                        }

                                        break;
                                    }else{
                                        spanLabel = spanLabel.trim();
                                        if(optionsArr[loop].opt_translation == spanLabel){
                                            // console.log(spanLabel);
                                            if(optionsArr[loop].opt == spanLabel || optionsArr[loop].optCon == spanLabel || optionsArr[loop].optlTrim == spanLabel || optionsArr[loop].optTrim == spanLabel || optionsArr[loop].opt_otranslation !== ''){
                                                $(this).html(optionsArr[loop].opt_otranslation);
                                            }

                                            break;
                                        }
                                    }
                                }
                            }else{
                                for(var loop = 0; loop < optionsArr.length ; loop++){
                                    spanLabel = spanLabel.toLowerCase().trim();
                                    if(optionsArr[loop].opt == spanLabel || optionsArr[loop].optCon == spanLabel || optionsArr[loop].optlTrim == spanLabel || optionsArr[loop].optTrim == spanLabel){
                                        if(optionsArr[loop].opt_translation !== ''){
                                            $(this).html(optionsArr[loop].opt_translation);
                                        }

                                        break;
                                    }else{
                                        spanLabel = spanLabel.trim();
                                        if(optionsArr[loop].opt == spanLabel || optionsArr[loop].optCon == spanLabel || optionsArr[loop].optlTrim == spanLabel || optionsArr[loop].optTrim == spanLabel){
                                            if(optionsArr[loop].opt_translation !== ''){
                                                $(this).html(optionsArr[loop].opt_translation);
                                            }
                                            break;
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            }

        });


        if(localStorage.getItem('display') == 'Right to Left'){
            $("form#validateform input[type='radio']").each(function(){
                $(this).parent().addClass('urduField');
            });
        }else{
            $("form#validateform input[type='radio']").each(function(){
                $(this).parent().removeClass('urduField');
            });
        }
    }

    function callLabelDir(){
        if(localStorage.getItem('display') == 'Right to Left'){
            $("form#validateform select").each(function(){
                $("form#validateform select").attr('dir','rtl');
            });
        }else{
            $("form#validateform select").each(function(){
                $("form#validateform select").removeAttr('dir','rtl');
            });
        }


        if(localStorage.getItem('display') == 'Right to Left'){
            $("form#validateform input[type='radio']").each(function(){
                $(this).parent().addClass('urduField');
            });
        }else{
            $("form#validateform input[type='radio']").each(function(){
                $(this).parent().removeClass('urduField');
            });
        }
    }

    function nocJobs() {
        return _.map(_.range(0, jobLen), function (i) {
            return {
                id: i,
                text: jobsArr[i],
            };
        });
    }

    function nocPos() {
        return _.map(_.range(0, dutyLen), function (i) {
            return {
                id: i,
                text: dutyArr[i],
            };
        });
    }
    $(document).ready(function(){

        $(".prevDiv").css('display','none');

        var divsLength = $("form#validateform .form-group").length;
        console.log(divsLength)
        divsCl = Math.ceil(divsLength/9);
        localStorage.setItem('divsCl',divsCl);

        if(divsCl > 1){
            $(".nextDiv").css('display','inline-block');
        }

        console.log('Total Form Steps: '+divsCl);

        let l = 0;
        $("form#validateform .form-group").each(function(){
            if(l%9 == 1){
                frmGroup++;
                $(this).addClass("formStep"+frmGroup);
            }else{
                $(this).addClass("formStep"+frmGroup);
            }
            l++;
        });

        $(".formStep0").addClass("formStep1");
        $(".formStep1").removeClass("formStep0");
        $(".formStep1").css('display','block');

        var cT = 2;
        for(var c = 1 ; c <= divsCl ; c++){
            $("form#validateform .formStep"+cT).each(function(){
                $(this).css('display','none');
            });

            cT++;
        }
        step = 1;


    });


    var divsCl = 0;
    frmGroup = 0;
    let step = 0 , stepIn = 0;
    let quesCall = 0 , newStep = 0;
    var showStep = 0 ;
    var curStep = 0;

    function onQuesCall(){
        if(quesCall > 0 ){
            var divsLength = $("form#validateform .form-group").length;
            newStep = Math.ceil(divsLength/9);
            console.log('len-'+divsLength)

            // if(newStep > 1){
            // 	$(".nextDiv").css('display','inline-block');
            // }
            console.log('Total Form Steps: '+newStep);
            var c = 1 , lC = 0;

            if(newStep > 1){
                for (c = 1; c <= newStep ; c++){
                    $("form#validateform .formStep"+c).each(function(){
                        if($(this).css('display')=='block')
                        {
                            curStep=c
                        }
                        $(this).removeClass('formStep'+c);
                        console.log('Step--'+c+' Removed');
                    });
                }
            }

            if(newStep > localStorage.getItem('divsCl')){
                localStorage.setItem('divsCl',newStep);
                // step++;
            }

            console.log('Old Step Was : '+step);

            let l = 0 , frmGroup = 0;
            $("form#validateform .form-group").each(function(){
                if(l%9 == 1){
                    frmGroup++;
                    $(this).addClass("formStep"+frmGroup);
                }else{
                    $(this).addClass("formStep"+frmGroup);
                }
                l++;
                //$(".form-group:lt(9)").css("display","block");
            });
            $(".formStep0").addClass("formStep1");
            $(".formStep1").removeClass("formStep0");

            if(newStep > 1){
                // $(".prevDiv").css('display','inline-block');

                var cT = 1;
                console.log('newstep--'+newStep)
                for(var c = 1 ; c <= newStep ; c++){
                    $("form#validateform .formStep"+cT).each(function(){
                        console.log('Step--'+cT+' Hidden')
                        $(this).css('display','none');
                    });
                    cT++;

                }

            }

            if(newStep == localStorage.getItem('divsCl')){
                $(".nextDiv").css('display','inline-block');
                //$("#lastBox").css('display','flex');
                console.log('yess')
            }
            // else{
            // 	$(".nextDiv").css('display','inline-block');
            // 	//$("#lastBox").css('display','none');
            // }

            console.log('stp-'+step)
            console.log('cstp-'+curStep)

            if(newStep < step){
                stepIn = step - 1;
            }else{
                stepIn = step;
            }
            $("form#validateform .formStep"+curStep).each(function(){
                $(this).css('display','block');
            });
            console.log('Step-N:'+newStep+' | Step-O:'+stepIn);
            if(newStep == stepIn){
                $(".nextDiv").css('display','none');
            }else{
                $(".nextDiv").css('display','inline-block');
            }


        }
        quesCall++;

    }

    $(document).on('click','.nextDiv',function(){
        console.log('Step -- '+step);

        if($("#validateform").valid()){

            $("form#validateform .formStep"+step).each(function(){
                $(this).css('display','none');
            });
            step++;

            console.log('Moved To Steps: '+step);
            window.scrollTo(0, 0);
            if(step >= 1){
                $(".prevDiv").css('display','inline-block');
            }
            if(step == localStorage.getItem('divsCl')){
                $(".nextDiv").css('display','none');
                $("#lastBox").css('display','flex');
            }
            else{
                $(".nextDiv").css('display','inline-block');
                $("#lastBox").css('display','none');
            }
            $("form#validateform .formStep"+step).each(function(){
                $(this).css('display','block');
            });

        }


    });

    $(document).on('click','.prevDiv',function(){

        $("#lastBox").css('display','none');

        $("form#validateform .formStep"+step).each(function(){
            $(this).css('display','none');
        });

        console.log('Previous step:'+step);

        window.scrollTo(0, 0);
        if(step > 1){
            $(".nextDiv").css('display','inline-block');
        }

        step--;

        if(step == 1){
            $(".prevDiv").css('display','none');
        }else{
            $(".prevDiv").css('display','inline-block');
        }

        $("form#validateform .formStep"+step).each(function(){
            $(this).css('display','block');
        });


    });

</script>
</body>

</html>