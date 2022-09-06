<?php
$hostURL = $_SERVER['HTTP_HOST'];
$getURL = str_replace(array("/", "form?"), array("", ""), $_SERVER['REQUEST_URI']);
$chckPar = explode("/", $_SERVER['REQUEST_URI']);
//$completeURL =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$completeURL =  "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$lastCharURL =  substr($completeURL, -1);
$lastParam = $chckPar[count($chckPar) - 1];
if ($lastCharURL == "/") {
    header("location: " . trim($completeURL, "/"));
}
if($lastParam=='english')
{
    header("location: " . trim($completeURL, "english"));

}


$ajaxFileToCall = "devajax.php";
$incFolderName = "devform_inc";



setcookie('AgreeCheck', '', 1, '/');
setcookie('AgreeCheck', '', 1, '/form');

require_once("user_inc.php");
require_once $incFolderName.'/cookies.php';
require_once $incFolderName.'/getLabels2.php';

$webConversion = false;

$getForms = mysqli_query($conn, "SELECT * FROM categories WHERE id = '{$formID}'");
$frmData = mysqli_fetch_assoc($getForms);

$getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
$fldArr = array();
while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
    $fldArr[$fld['id']] = $fld;
}
$page = 'multilingual';



require_once $incFolderName."/check_form.php";
// For header.php url $langURL is re initialize
$langURL = '/'.$langType;
$baseURL = 'https://'.$_SERVER['HTTP_HOST'];
$callFormUseModal = false;

if(isset($_SESSION['user_id']))
{


    $loggedSessionId = $cuurentUser['form_session_id'];
    if(!empty($loggedSessionId) && $loggedSessionId != session_id() &&  ($cuurentUser['role'] == "0" || $cuurentUser['role'] = 0 ) )
    {

        $callFormUseModal = true;
    }
    else
    {

        $updateQuery = "UPDATE `users` SET `form_session_id` = '".session_id()."' WHERE id = '".$_SESSION['user_id']."'";

        mysqli_query($conn,$updateQuery);

    }


}

?>
<!doctype html>
<html lang="en">

<head>
    <?php include_once($incFolderName."/metatags.php"); ?>




    <?php include_once("style.php"); ?>


</head>

<body onload="$(window).scrollTop(0)">

<?php include_once("header.php"); ?>





<!--body content wrap start-->

<div class="main">

    <!--header section start-->
    <section class="hero-section ptb-100 gradient-overlay" style="background: url('img/header-bg-5.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-7">

                </div>
            </div>
        </div>
    </section>
    <!--header section end-->
    <!--header section end-->

    <?php include_once($incFolderName."/baseform.php"); ?>
    <!-- Continue Login Modal -->
    <!-- Modal -->
    <div class="modal fade" id="continueLoginModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="continueLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title static_label" id="continueLoginModalLabel" data-org="<?php echo $allLabelsEnglishArray[176] ?>"><?php echo $allLabelsArray[176] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="width: 100%;" id="continueAlert">
                        <p class="static_label" data-org="<?php echo $allLabelsEnglishArray[800] ?>"><?php echo $allLabelsArray[800]; ?></p>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary static_label" data-dismiss="modal" data-org="<?php echo $allLabelsEnglishArray[103] ?>"><?php echo $allLabelsArray[103] ?></button>
                    <button type="button" id="continueFormBtn" class="btn btn-success static_label" data-org="<?php echo $allLabelsEnglishArray[28] ?>"><?php echo $allLabelsArray[28] ?></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Continue Login Modal -->

</div>
<!--body content wrap end-->

<?php include_once($incFolderName."/modals.php"); ?>

<?php include_once("footer.php"); ?>


<?php include_once("script.php");


?>
<script src="<?php echo $currentTheme; ?>js/crash.js"></script>
<script src="<?php echo $currentTheme; ?>js/script.js?Lang=<?php echo $langType.'_'.$allLabelsArray[86]; ?>"></script>

<script>
    <?php



    require_once $incFolderName."/form_js_vars.php";


    if(isset($_SESSION['user_id']))
    {
    ?>

    $.ajaxSetup({
        data: {
            prev_userId: "<?php echo $cuurentUser['id']; ?>",
            prev_userSes: "<?php echo $cuurentUser['session_id']; ?>"
        },

    });


    <?php
    }

    ?>





    localStorage.removeItem('unload_called');
    localStorage.form_2_in_process = "yes";
    $(function() {

        // this block of code is to detect weather form is loaded from Browser-navigation button (back/forward) or loaded regularly

        if($("#hiddenInputToDetectBackButton").val() == 1 || $("#hiddenInputToDetectBackButton").val() == "1")
        {
            // form loaded from browser-navigations buttons
            window.location.reload();
        }
        else
        {
            // form is regularly
            $("#hiddenInputToDetectBackButton").val("1");
        }

// this function is to  pause the execution of program until language change modal return response
        function modal_is_open_func(){


            if (modal_is_open){
                trampoline(pauseExe());
            }
        }

        const trampoline = fn => (...args) => {
            let result = fn(...args)
            while (typeof result === 'function') {
                result = result()
            }
            return result
        }
        const pauseExe = () => (
            modal_is_open === true
                ? 1
                : () => pauseExe()
        );




        var allowForm = false;

        if((is_pro == 'yes' && (localStorage.getItem('form_in_process') == null || (localStorage.getItem('form_in_process') && localStorage.getItem('form_in_process') == "no"))) || is_pro == 'no')
        {
            allowForm = true;
        }

        if (allowForm) {



            var process_form_id =     (localStorage.getItem("process_form_id"));

            var process_draft_id =     (localStorage.getItem("process_draft_id"));
            if(process_form_id !== "" || process_draft_id !== ""){
                if(process_form_id !== "" && process_draft_id !== "")
                {
                    if ((is_sform == "yes" || is_draft == "yes") && is_pro == "yes" && (localStorage.getItem("process_draft_id") != sdraftId || localStorage.getItem("process_form_id") != sformId)) {
                        // when pro user open other form to edit this will clear localStorage before loading Storage from DB
                        // And will also clear storage if user was editing a form and now want to new submission with new empty form

                        console.log("1st cond")

                        localStorage.clear();
                    }
                }
                else if(process_form_id !== "")
                {
                    if ((is_sform == "yes" || is_draft == "yes") && is_pro == "yes" && ( localStorage.getItem("process_form_id") != sformId)) {
                        // when pro user open other form to edit this will clear localStorage before loading Storage from DB
                        // And will also clear storage if user was editing a form and now want to new submission with new empty form

                        console.log("2nd cond")

                        localStorage.clear();
                    }
                }
                else {
                    if ((is_sform == "yes" || is_draft == "yes") && is_pro == "yes" && (localStorage.getItem("process_draft_id") != sdraftId)) {
                        // when pro user open other form to edit this will clear localStorage before loading Storage from DB
                        // And will also clear storage if user was editing a form and now want to new submission with new empty form

                        console.log("3rd cond")

                        localStorage.clear();
                    }
                }

            }
            else
            {

                // if new form is submitted and page reloads then pro user should get new empty form
                // if(is_pro == "yes")
                // {
                //     if((is_sform != "yes" && is_draft != "yes") && (localStorage.getItem('Submission') == 'true' || localStorage.getItem('Submission') == true))
                //     {
                //
                //         localStorage.clear();
                //     }
                // }
            }



            <?php
            if (is_numeric($lastParam)) {
            ?>
            lastParamIsString = "no";
            <?php

            }

            ?>

            console.log(url)
            console.log(local_url)
            console.log(local_old_url)


            if (check_lang == '') {
                cookie_lang = 'english'
            } else {
                cookie_lang = check_lang
            }

            if (local_url == null) {
                local_url = url
                localStorage.setItem('url', url)
            }
            if (local_old_url == null) {
                local_old_url = local_url
                localStorage.setItem('old_url', local_url)
            }

            // if guest user then clear form  localstorage
            if (sess_id == "" || sess_id === "") {
                if(guestLocalStorage){
                    if (localStorage.getItem("guest_logged") != "yes") {
                        for (var key in localStorage) {
                            if (key == 'guest_in_process' || key == 'drafted' || key == 'guest_logged' || key == 'process_draft_id' || key == 'process_form_id' || key == 'form_2_in_process' || key == 'form_in_process' || key == 'Lang' || key == 'url' || key == 'old_url' || key == 'AgreeCheck' ) {

                                continue
                            } else {
                                // localStorage.removeItem(key)
                            }
                        }
                    }
                }

                localStorage.setItem("guest_in_process", "yes");

                localStorage.setItem("guest_logged", "yes");


            } else {

                if (localStorage.getItem("guest_in_process")) {

                    if (localStorage.getItem("guest_in_process") != "yes") {

                        if ((is_pro == "yes" && false)) // remove this condition if you also want to allow pro user to priorities localstorage
                        {
                            for (var key in localStorage) {
                                if (key == 'process_form_id' || key =='process_draft_id' || key == 'drafted' || key == 'form_in_process' || key == 'form_2_in_process' || key == 'Lang' || key == 'url' || key == 'old_url' || key == 'AgreeCheck' ) {

                                    continue
                                } else {
                                    localStorage.removeItem(key)
                                }
                            }
                        }


                    }
                    else{

                        if(localStorage.getItem("Submission") == 'true')
                        {

                            if(is_pro != "yes")
                            {
                                if(is_sform != "yes") {
                                    if(localStorage.getItem('process_form_id')){
                                        if(localStorage.getItem('process_form_id') !== "")
                                        {
                                            // this block of ajax is use to assigned guest user submitted form to signed user which not have any submitted form
                                            // you can find all related code by searching  #code_123

                                            sformId = localStorage.getItem('process_form_id')
                                            $.ajax({
                                                dataType: 'json',
                                                url: "<?php echo $currentTheme . $ajaxFileToCall; ?>?h=assignFormToSigned<?php echo $langParam; ?>",
                                                type: 'POST',
                                                async: false,
                                                data: {sformId: sformId, userId: "<?php echo $_SESSION['user_id']; ?>"}
                                            })
                                        }
                                    }

                                }
                                else
                                {
                                    for (var key in localStorage) {
                                        if (key == 'process_form_id' || key =='process_draft_id' ||  key == 'drafted' ||  key == 'form_2_in_process'  || key == 'form_in_process' || key == 'Lang' || key == 'url' || key == 'old_url' || key == 'AgreeCheck' ) {

                                            continue
                                        } else {
                                            localStorage.removeItem(key)
                                        }
                                    }
                                }
                            }
                            else
                            {
                                for (var key in localStorage) {
                                    if (key == 'process_form_id' || key =='process_draft_id' ||  key == 'drafted' ||  key == 'form_2_in_process'  || key == 'form_in_process' || key == 'Lang' || key == 'url' || key == 'old_url' || key == 'AgreeCheck' ) {

                                        continue
                                    } else {
                                        localStorage.removeItem(key)
                                    }
                                }
                            }




                            localStorage.setItem('drafted','true')
                            console.log("drafted called => 1")
                        }

                    }
                }

            }

            if (localStorage.getItem('AgreeCheck') == '1' || localStorage.getItem('AgreeCheck') == 1) {
                if (document.getElementById('terms') != undefined) {
                    if (sess_id !== "" && sess_id !== null) {
                        document.getElementById('terms').checked = true;
                    }
                }

            }

            var loadFromDB = false; //for pro user  handling localstorage maint

            if (localStorage.getItem('AgreeCheck') == '1' || localStorage.getItem('AgreeCheck') == 1)
            {


                // lastParamIsString
                if ((url !== local_url && local_url !== '' && local_url !== undefined && local_url !== null)) {


                    if(guestLog != "yes")
                    {

                        langChangeYes()


                        // getTranslations();
                        // console.log('setting url 0')
                        // localStorage.setItem('url', url)
                        // localStorage.setItem('old_url', local_url)
                        // $('body').css('cursor', ' not-allowed')
                        // $('form').css('pointer-events', 'none')
                    }
                }
                else {


                    checkDraftButton()


                    // same code written under else of condition (localStorage.getItem('AgreeCheck') == '1' || localStorage.getItem('AgreeCheck') == 1) # to handle localstorage of pro user
                    if(is_pro == "yes"  && false) // remove false if you want to stop local-storage for pro user
                    {
                        langChangeYes()
                        localStorage.setItem('drafted','true');
                        console.log("drafted called => 2")
                    }
                    else
                    {

                        checkDraftButton()





                        if ((is_sform == "yes" || is_draft == "yes") && is_pro == "yes" && (localStorage.getItem("process_draft_id") != sdraftId || localStorage.getItem("process_form_id") != sformId)) {
                            // when pro user open other form to edit this will clear localStorage before loading Storage from DB
                            // And will also clear storage if user was editing a form and now want to new submission with new empty form

                            console.log("1st cond")
                            loadFromDB = true;
                        }

                        if(is_pro == "yes") {


                            if (loadFromDB == false) {
                                if (localStorage.getItem("process_draft_id") != "" && localStorage.getItem("process_draft_id") != sdraftId) {
                                    // clear local storage for default form
                                    // resting form for professional user
                                    langChangeYes()

                                    localStorage.setItem('drafted', 'true');
                                    console.log("drafted called => 3")
                                } else if (localStorage.getItem("process_form_id") != "" && localStorage.getItem("process_form_id") != sformId) {
                                    langChangeYes()

                                    localStorage.setItem('drafted', 'true');
                                    console.log("drafted called => 4")
                                }
                            }
                        }



                    }

                }


            }
            else
            {

                // same code written under condition (localStorage.getItem('AgreeCheck') == '1' || localStorage.getItem('AgreeCheck') == 1) # to handle localstorage of pro user
                if(is_pro == "yes"  && false) // remove false if you want to stop local-storage for pro user
                {

                    // resting form for professional user
                    langChangeYes()



                    localStorage.setItem('drafted','true');
                    console.log("drafted called => 5")
                }
                else
                {
                    // manage localstorage for pro user





                    if ((is_sform == "yes" || is_draft == "yes") && is_pro == "yes" && (localStorage.getItem("process_draft_id") != sdraftId || localStorage.getItem("process_form_id") != sformId)) {
                        // when pro user open other form to edit this will clear localStorage before loading Storage from DB
                        // And will also clear storage if user was editing a form and now want to new submission with new empty form

                        console.log("1st cond")
                        loadFromDB = true;
                    }

                    if(is_pro == "yes") {


                        if (loadFromDB == false) {
                            if (localStorage.getItem("process_draft_id") != "" && localStorage.getItem("process_draft_id") != sdraftId) {
                                // clear local storage for default form
                                // resting form for professional user
                                langChangeYes()

                                localStorage.setItem('drafted', 'true');
                                console.log("drafted called => 6")
                            } else if (localStorage.getItem("process_form_id") != "" && localStorage.getItem("process_form_id") != sformId) {
                                langChangeYes()

                                localStorage.setItem('drafted', 'true');
                                console.log("drafted called => 7")
                            }
                        }
                    }



                }





                loaded = true
                console.log('setting url2')

                if (url !== local_old_url) {



                    if (loaded == true) {

                        for (var key in localStorage) {
                            if (key == 'guest_in_process' || key == 'drafted' || key == 'guest_logged' ||  key =='form_2_in_process' || key == 'process_draft_id' || key == 'process_form_id' || key == 'form_in_process' || key == 'Lang' || key == 'url' || key == 'old_url') {
                                continue
                            } else {
                                localStorage.removeItem(key)
                            }
                        }
                    }

                }


                localStorage.setItem("url", url);

                localStorage.setItem("local_old_url", url);

                localStorage.setItem("old_url", url);
                // localStorage.setItem("old_url", local_url);

            }



            if (check_lang == '') {
                localStorage.setItem('display', '')
            }

            if (url !== local_old_url ||  localStorage.getItem('AgreeCheck') == null || localStorage.getItem('AgreeCheck') == undefined) {
                if (loaded == true) {
                    console.log(2)
                    // localStorage.removeItem('form_' + form_id)
                }
            }

            if (lng == 'urdu' || lng == 'arabic') {
                localStorage.setItem('display', 'Right to Left')
            } else {
                localStorage.setItem('display', 'Left to Right')

            }
            localStorage.setItem("form_in_process", "yes");


            <?php
            if (isset($_SESSION['user_id'])) {
            if (!empty($localStorage)) {
            ?>

            {
                // this block of should out from loop. because loop is setting localstorage, if you set localstorage then these condition will be go wrong
                // BaliG Bali G
                if (localStorage.getItem("guest_in_process")) {
                    if (localStorage.getItem("guest_in_process") == "yes" && sess_id != "") {

                        guestProcs = "yes";
                    }
                }


                var locAgreecheck = false;
                if ((localStorage.getItem("AgreeCheck") == "" || localStorage.getItem("AgreeCheck") == null)) {
                    locAgreecheck = true;
                }
            }

            <?php

            $localStorageArr = array();
            // echo ($localStorage['form_10']);
            foreach ($localStorage as $key => $value) {
            foreach ($value as $key2 => $value2) {
            if (  $key2 != 'url' && $key2 != 'old_url') {

            ?>




            if ((!confirmChanged  && (locAgreecheck  && is_pro == "no"))  || guestProcs == "yes" || (is_pro == "yes" && loadFromDB)) {



                var key2 = "<?php echo $key2; ?>";

                if(guestProcs === "yes" &&  key2 === "form_10")
                {
                    console.log('form saved1')



                    localStorage.setItem('<?php echo $key2; ?>', '<?php  if ($key2 == "form_10") {
                        $value2 = trim(preg_replace('/\s+/', ' ', $value2));
                        echo str_replace("'", "\'", trim($value2));
                    } ?>');

                }
                else
                {
                    console.log('form saved2')

                    localStorage.setItem('<?php echo $key2; ?>', '<?php if ($key2 == "form_10") {
                        $value2 = trim(preg_replace('/\s+/', ' ', $value2));

//                        echo   str_replace("'", "\'", trim($value2));
                        echo str_replace("'", "\'", $value2);
                    } else {
//                        echo   str_replace("'", "\'", trim($value2));
                        echo str_replace("'", "\'", $value2);

                    } ?>');

                }

            }
            else
            {
                console.log("form else")
            }


            <?php
            }
            // die();
            }
            }
            }
            }
            ?>





            if(localStorage.getItem("subBtnTxt") != null)
            {

                $("#btnLoader").attr("data-org",localStorage.getItem("subBtnTxt"))
                $("#btnLoader").text(static_label_changer(localStorage.getItem("subBtnTxt")))
            }
            if (is_pro == 'yes') {
                localStorage.setItem('process_form_id', sformId);
                localStorage.setItem('process_draft_id', sdraftId);
            }

            // console.log(localStorage)
            $('.prompt').html('')

            if (localStorage.getItem('display') == 'Right to Left') {
                disCl = 'rightToLeft';
            } else {
                disCl = 'leftToRight';
            }

            var newArr = new Array()
            for (var key in localStorage) {
                if (key[0] == 'n' || key[0] == 'f') {
                    newArr[key] = localStorage.getItem(key)
                }
                if (key[0] == 's') {
                    sArr.push(localStorage.getItem(key));
                }
                if (key[0] == 'm') {
                    lArray.push(parseInt(localStorage.getItem(key)));
                }
            }
            sArr.forEach(function(i) {

                count[i] = (count[i] || 0) + 1;

            });

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });


            setTimeout(function() {
                console.log('agree check=='+localStorage.getItem('AgreeCheck'))

                if (localStorage.getItem('AgreeCheck') == 1) {
                    getNoc()
                }
            }, 500)

            if ($('#terms').length > 0) {
                if (document.getElementById('terms').checked == false) {
                    let check = localStorage.getItem('AgreeCheck')
                    if (check === null || check === '' || check === undefined) {
                        check = 0
                    }
                    document.cookie = 'AgreeCheck=' + check;
                }
            }
            $.validator.messages.required = '<?= $allLabelsArray[48] ?>';

            $('#validateform').validate({

                errorPlacement: function(error, element) {
                    if (element.attr("type") == "radio") {
                        error.appendTo(element.parent('div.input-group'));
                    } else if (element.attr("data-type") == "date" || element.hasClass("nocPicker")) {
                        error.appendTo(element.parent('div.input-group'));
                    } else {
                        error.insertAfter(element);

                    }
                    let v = error[0].innerHTML

                    if (localStorage.getItem('Lang') !== 'english') {
                        v = static_label_changer(v)
                    }
                    error[0].innerHTML = v
                    unsetInput()

                },
                invalidHandler: function(event, validator) {
                    // 'this' refers to the form

                    var errors = validator.numberOfInvalids();

                    if (errors) {
                        unsetInput()
                        error_check()
                        setTimeout(function() {
                            $("label.error").each(function() {
                                let target = $(this)
                                if ($(this).css('display') == 'block') {

                                    target = $(this)
                                    let v = target[0].innerHTML

                                    if (localStorage.getItem('Lang') !== 'english') {
                                        v = static_label_changer(v)
                                    }
                                    target[0].innerHTML = v
                                }
                            });
                        }, 500)
                    }

                },


                submitHandler: function() {

                    'use strict';
                    $('label.errorReq').remove();
                    $('label.error').remove();
                    $("#btnLoader").hide();
                    let date_error = false
                    let position_error = false
                    $(".age").each(function() {
                        if (date_check($(this), 0) == false) {
                            date_error = true
                            $('html, body').animate({
                                scrollTop: $(this).offset().top - 200
                            }, 2000);
                            $(this).css('pointer-events', 'all')

                            let error_msg = 'You have entered an invalid date. Please update and submit again.'
                            let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                            if (localStorage.getItem('Lang') !== 'english') {
                                error_msg = static_label_changer(error_msg)
                                error_title = static_label_changer(error_title)

                            }
                            make_toast('danger', error_title, error_msg)
                        }
                    });

                    let namechecker = ''
                    $(".nocPicker").each(function() {
                        if ($(this).attr('name') !== namechecker) {
                            let d = document.getElementsByName($(this).attr('name'))
                            let v = '<?php echo $allLabelsArray[48] ?>'//'This field is required.'
                            var attr = $(this).attr('required');

                            if (typeof attr !== typeof undefined && attr !== false) {

                                // if (localStorage.getItem('Lang') !== 'english') {
                                //     v = static_label_changer(v)
                                //
                                // }
                                if ($(d).eq(0).val() !== '' && $(d).eq(1).val() == '') {
                                    unsetInput()
                                    $(d).eq(1).after('<label class="errorReq error">' + v + '</label>');
                                    position_error = true
                                }
                            }
                            namechecker = $(this).attr('name')
                        }

                    });
                    let select_msg = '--Select--'
                    let select_msg2 = '-Select-'

                    if (localStorage.getItem('Lang') !== 'english') {
                        select_msg = static_label_changer(select_msg)
                    }
                    $(".select2-container").each(function() {

                        if ($(this).next('input').hasClass('required') || $(this).next('select').attr('required')) {
                            if ($(this).children().children('.select2-chosen').html() == select_msg2 || $(this).children().children('.select2-chosen').html() == select_msg || $(this).children().children('.select2-chosen').html() == 'null') {
                                let v = '<?php echo $allLabelsArray[48] ?>'//'This field is required.'
                                // if (localStorage.getItem('Lang') !== 'english') {
                                //     v = static_label_changer(v)
                                // }
                                unsetInput()
                                $(this).after('<label class="errorReq error">' + v + '</label>');
                            } else {
                                $(this).next('label.errorReq').remove();
                            }
                        } else {

                        }

                    });
                    if (date_error == true || position_error == true) {
                        if (position_error) {
                            var $target = $(".errorReq:first");
                            $('html, body').animate({
                                scrollTop: $target.offset().top - 200
                            }, 2000);

                        }

                        let error_msg = '<?php echo $allLabelsArray[64] ?>'//'Something important is missing, please fill all the fields and submit again.'
                        let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                        // if (localStorage.getItem('Lang') !== 'english') {
                        //     error_msg = static_label_changer(error_msg)
                        //     error_title = static_label_changer(error_title)
                        //
                        // }
                        make_toast('danger', error_title, error_msg)
                        unsetInput()
                        return false
                    } else if ($(".errorReq").length > 0) {
                        $("#btnLoader").show();
                        console.log("show 1")
                        var $target = $(".errorReq:first");
                        $('html, body').animate({
                            scrollTop: $target.offset().top - 200
                        }, 2000);

                        let error_msg = '<?php echo $allLabelsArray[64] ?>'//'Something important is missing, please fill all the fields and submit again.'
                        let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'

                        // if (localStorage.getItem('Lang') !== 'english') {
                        //     error_msg = static_label_changer(error_msg)
                        //     error_title = static_label_changer(error_title)
                        //
                        // }
                        unsetInput()
                        make_toast('danger', error_title, error_msg)
                    } else {

                        $("#btnLoader").hide();
                        $('.float-div').hide()
                        if (localStorage.getItem('EndCase') == 'matched') {
                            endCase = true;
                        }
                        if (comment_button) {
                            progressBar(2)
                        }
                        else if (endCase == false) {
                            progressBar(1)
                        } else  {
                            progressBar(2)
                        }

                        $('.forbidden').children('input').css('pointer-events', 'none')
                        $('.forbidden').children('select').css('pointer-events', 'none')
                        $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                        $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                        $('.permitted').children('input').css('pointer-events', 'none')
                        $('.permitted').children('select').css('pointer-events', 'none')

                        let email = $('input[type="email"]:first').val()
                        let phone = $('input[type="tel"]:first').val()
                        let name = $('input[type="text"]').eq(1).val()
                        let token = ''

                        let dob = [];

                        var assistance_ids = '';
                        var assistance = '<ul>';
                        $('.email').each(function(i, obj) {
                            let p = $(this).parent().parent().children('div').children('label').html()
                            let level = ''
                            if ($(this).hasClass('level2')) {
                                level = 2
                            } else {
                                level = 1
                            }
                            let cls = $(this).parent().parent().attr('class').split(' ')
                            let id1 = cls[0].split('_')
                            assistance += '<li>' + p + '</li>'
                            if (id1[1] == 'parent') {
                                assistance_ids += id1[2] + '-' + level + ',';

                            } else {
                                assistance_ids += id1[1] + '-' + level + ',';

                            }
                        });

                        $(".age").each(function() {
                            let dateVal = $(this).val()
                            dateArray[dateCheck] = dateVal
                            dateVal = dateVal.split('-')
                            let sDate = dateVal[0] + "/" + dateVal[1] + "/" + dateVal[2]
                            let enteredDate = sDate
                            let y = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
                            $(this).val(y)
                            dateCheck++;
                        });

                        let formData = $('.myForm').serializeArray()

                        $(".age").each(function() {
                            $(this).val(dateArray[dateCheck2])
                            dateCheck2++;
                        });
                        $(".dob").each(function() {
                            let name = $(this).attr('name')
                            name = name.split('*')
                            dob[name[1]] = $(this).val()
                        });


                        $("input,select,textarea").each(function() {

                            if ($(this).is("[type='checkbox']") || $(this).is("[type='radio']")) {
                                $(this).attr("checked", $(this).is(":checked"));
                            } else if ($(this).prop("tagName") == "SELECT") {
                                $(this).find('option[value="' + $(this).val() + '"]').attr('selected', true);
                            } else {
                                $(this).attr("value", $(this).val());
                            }
                        });
                        pending_submission = true;
                        localStorage.setItem('Submission', 'true');
                        localStorage.setItem('subBtnTxt',$("#btnLoader").attr("data-org"));
                        submission = true;

                        setTimeout(function() {
                            $.ajax({
                                dataType: 'json',
                                url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=submitForm<?php echo $langParam; ?>",
                                type: 'POST',
                                async: false,

                                data: {
                                    'form': formData,
                                    'formHtml': $('.myForm').html(),
                                    'dob': dob,
                                    'email': email,
                                    'assistance': assistance_ids,
                                    'phone': phone,
                                    'name': name,
                                    'nocUser': nocUser,
                                    'spouseUser': nocSpouse,
                                    'scoreID': $('#scoreID').val(),
                                    'scoreArray': scoreArray,
                                    'nocArray': nocArray,
                                    'scoreArray2': scoreArray2,
                                    'spouseScoreArray': spouseScoreArray,
                                    'spouseScoreArray2': spouseScoreArray2,
                                    'spouseNocScore': spouseNocScore,
                                    'rType': rType,
                                    'userGrades': userGrades,
                                    'spouseGrades': spouseGrades,
                                    'casesArray': casesArray,
                                    'token': token,
                                    'endCase': endCase,
                                    'removeIdentical': removeIdentical,
                                    'comment': $('#com').val(),
                                    'localStorage': JSON.stringify(allStorage()),
                                    'sformId': sformId,
                                    'sdraftId':sdraftId

                                },

                                success: function(data) {

                                    is_session(data) //checks if session is expired

                                    pending_submission = false;
                                    userGrades = data.userGrades;
                                    spouseGrades = data.spouseGrades
                                    spouseNocScore = data.spouseNocScore
                                    casesArray = data.casesArray
                                    removeIdentical = data.removeIdentical



                                    $('#btnLoader').hide()



                                    if (data.Success == 'ques') {

                                        getQuestion6(data.question.move_qid, data.question.move_qtype, data.question.q_id)
                                        $('#scoreID').val(data.question.scoreID);
                                        scoreArray = data.scoreArray;
                                        scoreArray2 = data.scoreArray2;
                                        spouseScoreArray = data.spouseScoreArray;
                                        spouseScoreArray2 = data.spouseScoreArray2;
                                        nocArray = data.nocArray;
                                        rType = 'question';
                                    } else if (data.Success == 'noc_ques') {


                                        if (data.question.conditionn == "scoring") {
                                            $('#scoreID').val(data.question.move_scoreType);
                                            rType = 'scoring';
                                            scoreArray = data.scoreArray;
                                            scoreArray2 = data.scoreArray2;
                                            spouseScoreArray = data.spouseScoreArray;
                                            spouseScoreArray2 = data.spouseScoreArray2;
                                            nocArray = data.nocArray;
                                            $('.myForm').submit();

                                        } else {
                                            getQuestion6(data.question.move_qid, data.question.move_qtype, data.question.q_id)
                                            $('#scoreID').val(data.question.scoreID);
                                            rType = 'question';
                                            scoreArray = data.scoreArray;
                                            scoreArray2 = data.scoreArray2;
                                            spouseScoreArray = data.spouseScoreArray;
                                            spouseScoreArray2 = data.spouseScoreArray2;
                                            nocArray = data.nocArray;
                                        }
                                    } else if (data.Success == 'scoring') {

                                        $('#scoreID').val(data.question.move_scoreType);
                                        scoreArray = data.scoreArray;
                                        scoreArray2 = data.scoreArray2;
                                        spouseScoreArray = data.spouseScoreArray;
                                        spouseScoreArray2 = data.spouseScoreArray2;
                                        nocArray = data.nocArray;
                                        rType = 'scoring';
                                        $('.myForm').submit();
                                    } else if (data.Success == 'comment') {
                                        $('#scoreID').val(data.question.scoreID);
                                        scoreArray = data.scoreArray;
                                        scoreArray2 = data.scoreArray2;
                                        spouseScoreArray = data.spouseScoreArray;
                                        spouseScoreArray2 = data.spouseScoreArray2;
                                        nocArray = data.nocArray;
                                        rType = 'comment';

                                        let ht = '<div class="afterSub"><div class="form-group form-group sub_question_div2 ">';
                                        let com = ''
                                        let lang = '<?php echo $langType ?>'

                                        if (lang !== 'english' && lang !== '') {
                                            com = data.question.comments_<?php echo $langType ?>


                                        } else {

                                            com = data.question.comments
                                        }
                                        ht += '<label>' + com + '</label>';
                                        ht += '<input value="' + data.question.comments + '" name="show_comment_' + data.question.id + '" hidden>'
                                        ht += '</div></div>';
                                        $('.formDiv').append(ht)
                                        $('.myForm').submit();
                                    } else if (data.Success == 'true') {
                                        progressBar(0)
                                        $('.scroll-edit').show()
                                        console.log('showing edit button 2')


                                        $('.forbidden').children('input').css('pointer-events', 'none')
                                        $('.forbidden').children('select').css('pointer-events', 'none')
                                        $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                                        $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                                        $('.permitted').children('input').css('pointer-events', 'none')
                                        $('.permitted').children('select').css('pointer-events', 'none')

                                        userGrades = []
                                        spouseGrades = []

                                        $('.score_loading').html('')
                                        $('#scoreID').val('')
                                        $('#sform_id').val(data.sfrom_id)
                                        localStorage.setItem("process_form_id",data.sfrom_id)
                                        sformId = data.sfrom_id;
                                        sdraftId =   data.s_draft_id
                                        $('#com').val('')
                                        if (endCase) {
                                            // if (localStorage.getItem('Lang') !== 'english') {
                                            //     endCase_message = static_label_changer(endCase_message)
                                            // }

                                            $('#subModalBody').html(endCase_message)
                                        } else {

                                            let m = '<?php echo $allLabelsArray[4] ?>'//'Thank you for using our immigration tool and for your interest in Canada!'
                                            // if (localStorage.getItem('Lang') !== 'english') {
                                            //     m = static_label_changer(m)
                                            // }
                                            $('#subModalBody').html(m)

                                        }
                                        let error_msg = '<?php echo $allLabelsArray[214] ?>'//'Thank you for using our immigration tool and for your interest in Canada!'
                                        let error_title = ''
                                        // if (localStorage.getItem('Lang') !== 'english') {
                                        //     error_msg = static_label_changer(error_msg)
                                        //     error_title = static_label_changer(error_title)
                                        //
                                        // }
                                        if ($('#toaster').children().length > 0) {
                                            $('#toaster').children().remove()
                                        }
                                        $.toaster({
                                            priority: "success",
                                            title: error_title,
                                            message: error_msg,
                                            settings: {
                                                timeout: 6000
                                            },
                                        });
                                        //make_toast('success', error_title, error_msg)
                                        progressBar(0)
                                        comment_button = false

                                    } else {
                                        $('.forbidden').children('input').css('pointer-events', 'none')
                                        $('.forbidden').children('select').css('pointer-events', 'none')
                                        $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                                        $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                                        $('.permitted').children('input').css('pointer-events', 'none')
                                        $('.permitted').children('select').css('pointer-events', 'none')
                                        $(window).scrollTop(0);
                                        let error_msg = '<?php echo $allLabelsArray[53] ?>'//'There was a problem. Try to submit again'
                                        let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'

                                        // if (localStorage.getItem('Lang') !== 'english') {
                                        //     error_msg = static_label_changer(error_msg)
                                        //     error_title = static_label_changer(error_title)
                                        //
                                        // }
                                        make_toast('danger', error_title, error_msg)
                                    }
                                    isShown = false

                                },


                                error: function(data) {
                                    localStorage.setItem('Submission', 'false');
                                    localStorage.setItem('subBtnTxt',$("#btnLoader").attr("data-org"));
                                    submission = false;
                                    $('.score_loading').html('')

                                    $(window).scrollTop(0);
                                    let error_msg = '<?php echo $allLabelsArray[53] ?>'//'There was a problem. Try to submit again'
                                    let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                                    // if (localStorage.getItem('Lang') !== 'english') {
                                    //     error_msg = static_label_changer(error_msg)
                                    //     error_title = static_label_changer(error_title)
                                    //
                                    // }
                                    make_toast('danger', error_title, error_msg)
                                }
                            });
                            return false;
                        }, 1000)
                    }
                }
            });

            ///==================local storage work========================



            $('label.errorReq').remove();
            if (localStorage.getItem('AgreeCheck') == 1 && sess_id !== '') {
                $(".unChecked").each(function() {
                    $(this).show()
                    $(this).removeClass('unChecked');
                })
                setTimeout(function() {
                    $("#iAgree").remove();

                }, 1000)
            }
            <?php
            if($btnLoaderShow !== false && $btnLoaderShow !== 'false')
            {

            ?>
// $('#btnLoader').true()
            <?php
            }
            else
            {

            ?>
            $('#btnLoader').hide()
            <?php
            }

            ?>


            $('input,textarea,select').attr('autocomplete', 'anyrandomstring');


            if (localStorage.getItem('form_' + form_id)) {
                if(!modal_is_open)
                {
                    console.log('Loaded from local storage')

                    $('.myForm').html('')
                    $('.myForm').html(localStorage.getItem('form_' + form_id))


                    local_storage_form = true
                }

            }
            changeStaticLabels()
            if ($("#iAgree").length > 0) {
                let check = document.getElementById('terms').checked
                if (!check) {
                    document.cookie = 'AgreeCheck=0'
                    localStorage.setItem('AgreeCheck', '0')
                    console.log("agree check 4")
                }
            } else {
                document.cookie = 'AgreeCheck=1'
                localStorage.setItem('AgreeCheck', '1')
            }
            $('.errorReq').remove();
            $('label.error').remove()
            $('span.temp').remove()
            $('input').prop('disabled', false)
            $('select').prop('disabled', false)



            if(localStorage.getItem("subBtnTxt") != null)
            {


                $("#btnLoader").attr("data-org",localStorage.getItem("subBtnTxt"))

                $("#btnLoader").text(static_label_changer(localStorage.getItem("subBtnTxt")))
            }

            if (is_draft == "yes") {

                <?php



                if ($btnLoaderShow ===  'true' || $btnLoaderShow === true) {
                ?>

                isShown = true;


                $("#btnLoader").show();
                console.log("show 3")
                <?php
                }

                ?>
                drafted = true;
                if(localStorage.getItem('drafted')===null || localStorage.getItem('drafted')===undefined)
                {
                    console.log('setting draft true2')
                    localStorage.setItem('drafted','true')
                    console.log("drafted called => 8")

                }

            }

            setTimeout(function() {
                $("div").each(function() {
                    if ($(this).hasClass('afterSub')) {
                        // $('.scroll-edit').show()
                        // console.log('showing edit button 3')


                        $('.afterSub').remove();
                    }
                })
                let q;
                if(!modal_is_open)
                {
                    for (var key in localStorage) {
                        if (key !== 'Lang' && key !== 'display' && key !== 'nocSpouse' && key !== 'nocUser' && key !== 'userGrades' && key !== 'spouseGrades' && key !== 'AgreeCheck' && key !== 'EndCase'  && key !== 'Submission') {
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

                                    if (document.getElementsByName(key).length > 0) {
                                        if (value == 'Yes') {
                                            document.getElementsByName(key)[0].checked = true;

                                        } else {
                                            document.getElementsByName(key)[1].checked = true;

                                        }
                                    }
                                } else {

                                    if (key.includes('from')) {
                                        let key2 = key.replace(" from", "");
                                        let d = document.getElementsByName(key2)
                                        if (document.getElementsByName(key2).length > 0) {
                                            document.getElementsByName(key2)[0].value = value;

                                        }
                                        continue
                                    }
                                    if (value == 'Present' || ($('input[name="' + key + '"]').eq(1)).attr('data-def') == "Present") {
                                        $('input[name="' + key + '"]').parent().children('div').children('input').attr('checked', 'checked');
                                    }

                                    if (localStorage.hasOwnProperty(key + " from")) {
                                        $('[name="' + key + '"]').eq(1).val(value);
                                    } else {
                                        $('[name="' + key + '"]').val(value);
                                    }
                                }
                            } else if (key[0] == 'd') {
                                let value = localStorage[key]
                                $('[name="' + key + '"]').val(value);
                            }
                            $('[name="dob*30"]').val($('[name="n[question_30]"]').val());
                            $('[name="dob*61"]').val($('[name="n[question_61]"]').val());

                            $('body').css('opacity', 1)
                            if (localStorage.getItem('oldFlag') == localStorage.getItem('newFlag')) {

                            }

                        }
                    }

                }
                var nameCheck = ''
                $('.nocPicker').each(function() {
                    if ($(this).attr('name') !== nameCheck) {
                        let d = document.getElementsByName($(this).attr('name'))

                        if ($(d).eq(1).attr('data-def') !== 'Present') {
                            $(d).eq(1).next('div').children('input').prop('checked', false)
                        }
                        nameCheck = $(this).attr('name')
                    }

                })
            }, 2000);
            setTimeout(function() {


                if (loaded == false) {
                    if(!modal_is_open)
                    {
                        formFunc('');

                    }
                }
                if (localStorage.getItem('nocUser') != '' && localStorage.getItem('nocUser') != null)
                    nocUser = JSON.parse(localStorage.getItem('nocUser'))
                if (localStorage.getItem('nocSpouse') != '' && localStorage.getItem('nocSpouse') != null)
                    nocSpouse = JSON.parse(localStorage.getItem('nocSpouse'))

            }, 4000);
            setTimeout(function() {
                try {
                    $('div.nocJobs , div.nocPos').select2('destroy');
                    $('div.nocJobs ,div.nocPos').remove();


                } catch (e) {
                    //console.log(e)
                }

            }, 2000);
            setTimeout(function() {

                $('body').css('opacity', 1)
                $('#validateform').show();
                tagsInp();

                $("div.nocJobs,div.nocPos").css("display", 'block');
                //CHanging the values of static labels
                changeStaticLabels()

            }, 4000);
            showButton('')
            console.log("show 7")
            $(".submit").click(function() {
                return false;
            });
            if (localStorage.getItem('Submission') == 'true') {
                console.log('showing edit button 4')


                $('.scroll-edit').show();
            } else {
                console.log('hiding edit button')
                $('.scroll-edit').hide();
                //editFormFunction()
                $('.permitted').children('input').css('pointer-events', 'auto')
                $('.permitted').attr('title', 'This question is permitted')
                $('.permitted').children('select').css('pointer-events', 'auto')
                $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'auto')
            }
            if($('.scroll-edit').is(":visible"))
            {
                $('.forbidden').children('input').css('pointer-events', 'none')
                $('.forbidden').children('select').css('pointer-events', 'none')
                $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                $('.permitted').children('input').css('pointer-events', 'none')
                $('.permitted').children('select').css('pointer-events', 'none')
            }



            <?php if (!isset($_SESSION['user_id'])) {
            ?>
            // jQuery(window).bind('beforeunload', function() {
            //     console.log(language_change)
            //
            //     if (language_change == false) {
            //         alert('Are you sure you want to leave?')
            //         return 'my text';
            //     }
            // });

            <?php  } ?>






        }
        else {
            // localStorage.setItem('drafted','true')
            let error_msg='<?php echo $allLabelsArray[273] ?>'//"You are already using a form in other tab/window, please close that tab then reload this page."
            is_already = true;
            $(".formInProcessAlert").text(error_msg);
            $("#validateform").remove();
            $(".float-div").hide('slow');
            console.log("already")
        }


        window.addEventListener("beforeunload", function(e) {
            //
            localStorage.setItem('unload_called', "yes");

            localStorage.setItem("guest_logged", "no");
            if(is_sform != "yes")
            {
                // this block of if is use to assigned guest user submitted form to signed user which not have any submitted form
                // you can find all related code by searching  #code_123
                if(localStorage.getItem("guest_in_process") == "no")
                {
                    localStorage.setItem("process_form_id", "");
                }

            }
            if(is_draft != "yes" && is_pro == "no")
            {
                localStorage.setItem("process_draft_id", "");
            }

            if(sess_id != "" )
            {
                localStorage.guest_in_process = "no";
            }
            // localStorage.setItem("form_in_process", "no");
            // // *********** perform database operation here
            // // before closing the browser ************** //

            if ( is_already == false) {

                localStorage.setItem('form_in_process', "no");
            }
            // // added the delay otherwise database operation will not work
            for (var i = 0; i < 500000000; i++) {}
            return undefined;

        });

        if($(".scroll-edit").is(":visible"))
        {
            $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
            $('.permitted').children('input').css('pointer-events', 'none')
            $('.permitted').children('select').css('pointer-events', 'none')
            localStorage.setItem('drafted','true');
            console.log("drafted called => 9")
        }
        // drafted_on_load=false
        console.log("3rd call py check")
        console.log(drafted_on_load)
        checkDraftButton();
        if(checkMainEmptyFields())
        {
            localStorage.setItem('drafted','true');
            onDraftStatusChanged();
        }
        if($('.scroll-edit').is(":visible") || $('#btnLoader').is(":visible"))
        {
            localStorage.setItem('drafted','true');
            onDraftStatusChanged();
        }
        setTimeout(function(){
            if($('.scroll-edit').is(":visible") || $('#btnLoader').is(":visible"))
            {
                localStorage.setItem('drafted','true');
                onDraftStatusChanged();
            }
        },500)

    });
</script>

<?php

require_once $incFolderName."/form_js_events.php";

require_once $incFolderName."/form_js_functions.php";

?>

<script>

    $(document).ready(function () {

        <?php

        if($callFormUseModal)
        {
        ?>
        $("#continueLoginModal").modal('show');
        <?php
        }


        ?>


        if(localStorage.getItem('Submission')=='false' && localStorage.getItem('drafted') == 'true')
        {
            $(".float-div").hide()
            console.log('hiding draft button 2')
        }
    })
</script>
</body>
</html>