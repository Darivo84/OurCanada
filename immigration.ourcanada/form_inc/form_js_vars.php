var guestLocalStorage = false; // true to enable local storage for guest. false for to disable local storage for guest
var labelsArray = new Array();
labelsArray = <?php echo json_encode($labelArray); ?>;
var labelsTransArray = new Array();
labelsTransArray = <?php echo json_encode($labelTransArray); ?>;
var is_pro = '<?php echo $is_pro; ?>';
var is_sform = '<?php echo $is_sform; ?>';
var is_draft = '<?php echo $is_draft; ?>';
var sformId = "<?php echo $sformId; ?>";
var time=60;
var question_changed=0;
var user_noc=new Array();
var spouse_noc=new Array();
var complete_request=true


<?php

if(empty($sdraftId))
{
    ?>
    var sdraftId = "";
    <?php
}
else
{
    ?>
    var sdraftId = "<?php echo trim($sdraftId); ?>";
    <?php
}
?>


if(sdraftId === "" && is_pro == "yes")
{

if(localStorage.getItem('process_draft_id'))
{


sdraftId = localStorage.getItem('process_draft_id');

}
}

var drafted = true;
var drafted_on_load = true;

if(localStorage.getItem('drafted')===null || localStorage.getItem('drafted')===undefined)
{
console.log('setting draft true')
localStorage.setItem('drafted','true')

}


var is_already = false;
var modal_is_open=false;

var lastParamIsString = "yes";

var eca_user_array = [849, 569, 563, 559, 575, 582, 592, 587, 595]
var eca_spouse_array = [108, 112, 120, 173, 183, 187, 192, 178]
var job_user_array = [624, 647, 667, 689, 712]
var job_spouse_array = [277, 297, 316, 336, 372]

var comment_box = false
var years = 0;
var count = {};
var countCheck = {};
var cv, gv, hv, cf, cq, co = '';
var email_ques = [];

var checkField = new Array();
var hiddenQues = new Array();
var checkValue = new Array();
var checkQues = new Array();
var checkOp = new Array();
var bbb = false;
var userGrades = [];
var spouseGrades = [];


var scoreArray = new Array()
var scoreArray2 = new Array()
var spouseScoreArray = new Array()
var spouseScoreArray2 = new Array()
var spouseNocScore = new Array()

var nocArray = new Array()

var casesArray = new Array()


var rType = '';
var dateArray = new Array();
var dateCheck = 0;
var dateCheck2 = 0;

var nocUser = new Array();
var nocSpouse = new Array();

var fromDate;
var toDate;
var up1 = '',
up2 = '',
up3 = '',
up4 = '',
up5 = '',
job = '',
up = '';

var lArray = [];
var sArr = [];
var currentRequest = '';
var req_check = false;

var disCl = '';

var jobsArr = [],
dutyArr = [],
jobsArrOrg = [],
dutyArrOrg = [];

var jobLen = 0,
dutyLen = 0;

var quesArr = [],
notesArr = [],
optionsArr = [],
oldValues = [],
valuesArr = [],
ArrCountry = [],
ArrEducation = [],
extraArr = [];
var removeIdentical = [];
var emailCount = false


var submission = false;
var pending_submission = false;
var endCase = false;
var endCase_message = '';
var comment_button = false
var isShown = false;
var local_storage_form = false
var loaded = false
var confirmChanged = false
var url = window.location.href
var local_url = localStorage.getItem('url')
var local_old_url = localStorage.getItem('old_url');
var sess_id = "<?php if (isset($_SESSION['user_id'])) {
    echo $_SESSION['user_id'];
} ?>";
var guestLog = 'no';
let form_id = <?php echo $formID ?>;
let check_lang = '<?php echo $langType; ?>'
let lng = '<?php echo $trans ?>'
let cookie_lang = ''
var temp_val, temp_id, temp_pid
var change1 = false
var change2 = false
var no_change = false
var clicked = false
var previous_country = ''
var changed_element = ''
var btnCheck = false
var final_submit = false
var guestProcs = "no";