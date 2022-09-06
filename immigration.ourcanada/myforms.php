<?php
include_once("user_inc.php");





if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header("location: " . $url . "/" . "form".$langURL);
}

if (intval($cuurentUser['role']) != 1) {
    header("location: " . $url . "/" . "form".$langURL);
}


//echo $_SESSION['user_id']."-";
////phpinfo();

$incFolderName = "form_inc";

$allformsArray = array();
$prof_priority=0;

$formLink = "form"; // 1 form for dform and 2 test for devform



$totalFormsQuery = "SELECT user_form.*,accounts_form_drafts.form_id as dformid,accounts_form_drafts.id as fdid FROM user_form left join accounts_form_drafts ON user_form.id = accounts_form_drafts.form_id WHERE user_form.user_id = '$currenTloggedUserId' ORDER BY user_form.id DESC;";
$totalFormsResult = mysqli_query($conn, $totalFormsQuery);
$totalFormsCount = mysqli_num_rows($totalFormsResult);

while ($formRow = mysqli_fetch_assoc($totalFormsResult)) {
    // echo $formRow['id'] . "----" . $formRow['dformid'] . "<br>";
    if (empty($formRow['dformid'])) {
        $formRow['dformid'] = 0;
    }
    if ($formRow['dformid'] == 0) {
        // no drft
        $formRow['rowtype'] = "f";
    } else {
        // drft
        $formRow['rowtype'] = "fd";

    }

    unset($formRow['form_data']);
    array_push($allformsArray, $formRow);
}

$totalDraftsQuery  = "SELECT * FROM accounts_form_drafts WHERE accounts_form_drafts.userId = '$currenTloggedUserId' AND accounts_form_drafts.form_id = 0 ORDER BY id DESC;";


//echo $totalDraftsQuery;
//
//die();

$totalDraftsResult  = mysqli_query($conn, $totalDraftsQuery);
$totalDraftsCount = mysqli_num_rows($totalDraftsResult);
while ($draftRow = mysqli_fetch_assoc($totalDraftsResult)) {
    $draftRow['rowtype'] = "d";
    unset($draftRow['formHtml']);
    array_push($allformsArray, $draftRow);

}



?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?php
    if($environment)
    {
        ?>
        <link rel="canonical" href="https://immigration.ourcanada<?php echo $ext ?>/myforms" />

        <?php
    }
    ?>
    <!--title-->
    <title><?php echo $allLabelsArray[186] ?> | OurCanada</title>

    <?php include_once("style.php"); ?>

    <style>
        .statusBar span
        {
            color: white;
        }
    </style>
</head>

<body>
<?php include_once("header.php"); ?>

<!--body content wrap start-->
<div class="main">
    <?php


    $allForms = mysqli_fetch_all($recordResult, MYSQLI_ASSOC);




    ?>





    <!--header section start-->
    <section class="hero-section ptb-100 gradient-overlay" style="background: url('img/header-bg-5.jpg')no-repeat center center / cover">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="page-header-content text-white text-center pt-sm-5 pt-md-5 pt-lg-0">
                        <h1 class="text-white mb-0 static_label" data-org="<?php echo $allLabelsEnglishArray[9] ?>"><?php echo $allLabelsArray[9] ?></h1>
                        <div class="custom-breadcrumb">
                            <ol class="breadcrumb d-inline-block bg-transparent list-inline py-0">
                                <li class="list-inline-item breadcrumb-item"><a class="static_label" href="<?php echo $currentTheme.$langURL; ?>" data-org="<?php echo $allLabelsEnglishArray[7] ?>" ><?php echo $allLabelsArray[7] ?></a></li>
                                <!-- <li class="list-inline-item breadcrumb-item"><a href="#">Pages</a></li> -->
                                <li class="list-inline-item breadcrumb-item active static_label" data-org="<?php echo $allLabelsEnglishArray[277] ?>"><?php echo $allLabelsArray[277] ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--header section end-->

    <!--promo block with hover effect start-->


    <section class="promo-block ptb-100">
        <div class="container">

            <div class="row">
                <div class="col-sm-3">
<!--                    <h2 class="static_label" data-org="--><?php //echo $allLabelsEnglishArray[168] ?><!--">--><?php //echo $allLabelsArray[168] ?><!--</h2>-->
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <select id="formsFilter" class="form-control formsFilter">
                        <option data-org="All" class="static_label" value="All"><?php echo $allLabelsArray[278] ?></option>
                        <option data-org="Forms" class="static_label" value="forms"><?php echo $allLabelsArray[279] ?></option>
                        <option data-org="Draft" class="static_label" value="drafts"><?php echo $allLabelsArray[280] ?></option>
                        <option data-org="In Process" class="static_label" value="inprocess"><?php echo $allLabelsArray[281] ?></option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <a href="<?php echo $currentTheme.$formLink; ?><?php echo $langURL; ?>" class="secondary-solid-btn fd-links createForm static_label" data-org="<?php echo $allLabelsEnglishArray[255] ?>"><?php echo $allLabelsArray[255] ?></a>
                </div>
            </div>
            <br><br>

            <div class="row">
                <div class="col-sm-12">
                    <div class="alert alert-warning new-form-process-alert static_label" data-org="<?php echo $allLabelsEnglishArray[282] ?>"><?php echo $allLabelsArray[282] ?></div>
                    <br>
                </div>
            </div>
            <div class="row">

                <?php
                if (count($allformsArray) > 0) {
                    $page=1;
                    $page_check=0;
                    $drftNo = $totalDraftsCount;
                    for ($ind = 0; $ind < count($allformsArray); $ind++) {
                        $page_check++;
                        $formArr = $allformsArray[$ind];
                        $isForm = "no";
                        $isDraft = "no";

                        if ($formArr['rowtype'] == "f") {
                            $isForm = "yes";
                        }
                        else if ($formArr['rowtype'] == "fd") {
                            $isForm = "yes";
                            $isDraft = "yes";
                        }
                        else {
                            $isDraft = "yes";
                        }
                        $formId = "";
                        $draftId = "";
                        $lang = "";

                        if ($isForm == "yes") {
                            $lang = $formArr['language'];

                            $formId = $formArr['id'];
                            if ($isDraft == "yes") {
                                $draftId = $formArr['fdid'];
                            }
                        }
                        else {
                            $lang = $formArr['locs_Lang'];
                            $draftId = $formArr['id'];
                        }

                        if ($lang == "english") {
                            $lang = "";
                        }

                        if($page_check>3)
                        {
                            $page++;
                            $page_check=1;
                        }

                        $checkPriority  = mysqli_query($conn,"SELECT * FROM accounts_form_drafts WHERE id = '$draftId' or form_id='$formId'");
                        $getrows=mysqli_fetch_assoc($checkPriority);
                        $prof_priority=$getrows['prof_priority'];
                        ?>
                        <div class="col-md-6 col-lg-4 page-<?php echo $page ?> navcards <?php if($isForm == "yes") { echo "formCard "; } if($isDraft == "yes"){ if($isForm == "yes") { if($prof_priority == 1) { echo "draftCard " ;}} else {echo "draftCard ";}; } ?>" <?php  if($ind>2) { echo 'style="display:none"' ;} ?>>


                            <div class="promo-services-single position-relative rounded-custom p-5 shadow">
                                <!-- $formArr -->
                                <!-- $formId -->
                                <!-- $draftId -->
                                <!-- $lang -->


                                <?php
                                //                                    echo $lang;
                                if($lang == "English")
                                {
                                    $lang = "";
                                }
                                if ($lang == "") {
                                    if ($isForm == "yes") { ?>
                                        <a href="<?php echo $currentTheme.$formLink; ?>/<?php echo $formId; ?>" class="links-icon bg-secondary shadow-sm fd-links"><i class="fas fa-edit"></i></a>
                                        <a href="<?php echo $currentTheme; ?>view_form/<?php echo $formId; ?>" class="activeDraft statusP"><i class="fa fa-eye"></i></a>
                                        <?php

                                    } else {
                                        ?>
                                        <a href="<?php echo $currentTheme.$formLink; ?>/<?php echo $draftId; ?>" class="links-icon bg-secondary shadow-sm activeDraft statusP fd-links"><i class="fa fa-tag"></i></a>
                                        <?php
                                    }

                                    ?>


                                <?php  } else {

                                    if ($isForm == "yes") { ?>
                                        <a href="<?php echo $currentTheme.$formLink; ?>/<?php echo strtolower($lang); ?>/<?php echo $formId; ?>" class="links-icon bg-secondary shadow-sm  fd-links"><i class="fas fa-edit"></i></a>
                                        <a href="<?php echo $currentTheme; ?>view_form/<?php echo $formId; ?>" class="links-icon bg-secondary shadow-sm activeDraft statusP"><i class="fa fa-eye"></i></a>
                                        <?php

                                    } else {
                                        ?>
                                        <a href="<?php echo $currentTheme.$formLink; ?>/<?php echo strtolower($lang); ?>/<?php echo $draftId; ?>" class="links-icon bg-secondary shadow-sm activeDraft statusP fd-links"><i class="fa fa-tag"></i></a>
                                        <?php
                                    }





                                }

                                ?>


                                <span class="icon icon-lg text-primary d-block mb-3">
                                        <span class="ti-vector icon-md color-primary"></span>
                                    </span>
                                <?php

                                if($isForm == "yes")
                                { ?>
                                    <h3 class="h5"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[252] ?>"><?php echo $allLabelsArray[252] ?></span> # <?php echo $formArr['id']; ?></h3>
                                <?php }
                                else
                                { ?>
                                    <h3 class="h5"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[253] ?>"><?php echo $allLabelsArray[253] ?></span> # <?php echo $drftNo; ?></h3>
                                    <?php
                                    $drftNo--;
                                }
                                ?>

                                <div class="myform-questions-answer">
                                <?php
                                $questions = json_decode($formArr['questions']);
                                $answers = json_decode($formArr['answers']);
                                $ques_check = '';
                                // for($i=0;$i<sizeof($questions);$i++)
                                for ($i = 0; $i < 5; $i++) {
                                    if($questions[$i]=='Phone number ')
                                    {
                                        break;
                                    }
                                    if ($answers[$i] != '' && $answers[$i] != 'NaN') {
                                        if (strpos($questions[$i], 'Date') !== false || strpos($questions[$i], 'date') !== false || strpos($questions[$i], 'born') !== false) {
                                            if ($isForm == "yes") {
                                                $questions[$i + 1] = $questions[$i];
                                                $i++;
                                            }
                                        } ?>

                                        <?php
                                        if ($questions[$i] == $questions[$i + 1] && (strpos($questions[$i], 'Position') !== false || strpos($questions[$i], 'work-experience') !== false)) {
                                            if ($answers[$i + 1] == '' || $answers[$i + 1] == null) {
                                                continue;
                                            }
                                            $answers[$i] = 'From: <b>' . $answers[$i] . '</b> To: <b>' . $answers[$i + 1] . '</b>';
                                            ?>
                                            <p>
                                                <b class="pb-1 questionTrans" data-org="<?php echo $questions[$i] ?>"><?php echo $questions[$i] ?></b>
                                                <span><?php echo $answers[$i] ?></span>
                                            </p>

                                            <?php
                                            $i++;
                                        } else {
                                            ?>
                                            <p>
                                                <b class="pb-1 questionTrans" data-org="<?php echo $questions[$i] ?>"><?php echo $questions[$i] ?></b>
                                                <span><?php echo $answers[$i] ?></span>
                                            </p>


                                            <?php
                                        }
                                        ?>



                                        <?php
                                    }
                                    $ques_check = $questions[$i];
                                }
                                ?>
                                </div>
                                <div class="statusBar draftBadgeId_<?php echo $draftId; ?> formbadgeId_<?php echo $formId; ?>">
                                    <?php




                                    if($isForm == 'yes')
                                    {
                                        if($isDraft == 'yes')
                                        {

                                            if($prof_priority==1)
                                            {
                                            if($lang == "")
                                            {



                                                ?>
                                                                                                <a href="<?php echo $currentTheme.$formLink; ?>/<?php echo $formId; ?>/<?php echo $draftId; ?>/" class="badge badge-success badge processIcons static_label " data-org="<?php echo $allLabelsEnglishArray[253] ?>"><?php echo $allLabelsArray[253] ?></a>
                                                <?php
                                            }
                                            else
                                            {

                                                ?>
                                                                                            <a href="<?php echo $currentTheme.$formLink; ?>/<?php echo strtolower($lang); ?>/<?php echo $formId; ?>/<?php echo $draftId; ?>/" class="badge badge-success badge processIcons static_label" data-org="<?php echo $allLabelsEnglishArray[253] ?>"><?php echo $allLabelsArray[253] ?></a>
                                            <?php }
                                        }}
                                        ?>
                                        <span class="badge badge-success badge processIcons static_label" data-org="<?php echo $allLabelsEnglishArray[240] ?>"><?php echo $allLabelsArray[240] ?></span>
                                        <?php
                                    }
                                    else
                                    {
                                        if($lang == "")
                                        {
                                            ?>
                                            <!--                                                <span href="--><?php //echo $currentTheme; ?><!--form/--><?php //echo $draftId; ?><!--/" class="badge badge-warning badge processIcons">Draft</span>-->
                                            <?php
                                        }
                                        else
                                        {

                                            ?>
                                            <!--                                            <span href="--><?php //echo $currentTheme; ?><!--form/--><?php //echo strtolower($lang); ?><!--/--><?php //echo $draftId; ?><!--/" class="badge badge-warning badge processIcons">Draft</span>-->
                                        <?php }


                                        ?>
                                        <span class="badge badge-primary badge processIcons static_label" data-org="<?php echo $allLabelsEnglishArray[254] ?>"><?php echo $allLabelsArray[254] ?></span>
                                        <?php
                                    }
                                    ?>
                                    <span class="badge badge-warning badge processIcons  badge-inprocess static_label" data-org="<?php echo $allLabelsEnglishArray[281] ?>"><?php echo $allLabelsArray[281] ?></span>

                                </div>

                            </div>
                        </div>
                        <?php

                    }
                    ?>

                    <?php
                }
                ?>
                <div class="col-md-12 no-record">
                    <div class="card  promo-services-single position-relative rounded-custom p-5 shadow">
                        <div class="card-body text-center">
                            <h2 class=""><i class="no-record-warn fa fa-exclamation-triangle "></i></h2>
                            <h3 class="static_label" data-org="<?php echo $allLabelsEnglishArray[188] ?>"><?php echo $allLabelsArray[188] ?></h3>
                        </div>
                    </div>
                </div>






            </div>

            <div class="row justify-content-center">
                <nav class="mt-4">
                    <ul class="pagination">

                    </ul>
                </nav>
            </div>
        </div>

    </section>
    <!--promo block with hover effect end-->

</div>
<!--body content wrap end-->

<?php include_once("footer.php"); ?>

<!--bottom to top button start-->
<button class="scroll-top scroll-to-target" data-target="html">
    <span class="ti-angle-up"></span>
</button>
<!--bottom to top button end-->
<?php include_once "script.php"; 
$_GET['Lang'] = trim($langURL,"/");
include_once "lang.php";

?>

<script>
 var   quesArr = <?php echo json_encode($quesArr); ?>;
$(document).ready(function(){
    // getTranslations();
                setTimeout(function () {
                    callTranslations();
                },1000);


});
    $(".no-record").hide();

    var perPageItems = 3;

    if($(".navcards").length < 1)
    {
        $(".no-record").show("slow");
    }
    if($(".navcards").length > 1)
    {
        let total_divs=$(".navcards").length
        let total_pages=total_divs/perPageItems
        let active_class='active'
        for(let i=0;i<total_pages;i++)
        {
            if(i>0)
                if(i>0)
                {
                    active_class=''
                }
            let html=' <li class="page_numbers '+active_class+' page-item" onclick="changePage(this,'+(i+1)+')"><a class="page-link border border-variant-soft rounded" href="javascript:void(0)">'+(i+1)+'</a></li>'
            $('.pagination').append(html)
        }
    }

    checkFormProcess();
    setInterval(() => {
        // localStorage.removeItem('form_2_in_process');
        checkFormProcess();
    }, 1500);

    function checkFormProcess() {
        console.log('yes')
        $(".new-form-process-alert").hide();
        $(".badge-inprocess").hide();

        var formFil = $("#formsFilter").val();


        if (localStorage.getItem("form_in_process") || localStorage.getItem("form_2_in_process")) {
            if (localStorage.getItem("form_in_process") == "yes" || localStorage.getItem("form_2_in_process")) {
                if(localStorage.getItem("process_form_id") || localStorage.getItem("process_draft_id")) {
                if (localStorage.getItem("process_form_id") != "") {
                    $(".formbadgeId_" + localStorage.getItem("process_form_id") + " .badge-inprocess").show();
                } else if(localStorage.getItem("process_draft_id")) {
                    $(".draftBadgeId_" + localStorage.getItem("process_draft_id") + " .badge-inprocess").show();
                } else {

                    if(localStorage.getItem("form_in_process") && localStorage.getItem("form_in_process") == "yes")
                    {
                        $(".new-form-process-alert").show();
                    }


                }
            }
                else
                {
                    if(localStorage.getItem("form_in_process") && localStorage.getItem("form_in_process") == "yes")
                    {
                        $(".new-form-process-alert").show();
                    }
                }



                if(formFil == "inprocess")
                {
                        $(".no-record").hide();
                }
                if(localStorage.getItem("form_in_process") == "yes")
                {
                    return true;
                }
                else
                {
                    return false;
                }

            }
            else
            {
                if(formFil == "inprocess")
                {
                    $(".no-record").show("slow");
                }
                return false;
            }
        }
        else
        {
            if(formFil == "inprocess")
            {
                $(".no-record").show("slow");
            }
            return false;
        }
    }
    var fdclicked = false;
    $(document).on("click",".fd-links",function(e){


        if(fdclicked == false)
        {
            fdclicked = true;
            setTimeout(function(){
                fdclicked = false;
            },500)
        }
        else
        {
            return false
        }

        if(checkFormProcess())
        {
            if(localStorage.getItem('view_form')!='true')
            {
                e.preventDefault();
                $("#formProcessModal").modal("show");

            }
            else
            {

                localStorage.clear();
            }
        }
        else
        {
            if($(this).hasClass("createForm"))
            {
                // clear storage when user click on create form button to show fresh form
                localStorage.clear();
            }


        }


    });


    function changePage(e,pageNo)
    {

        var fvalue = $("#formsFilter").val();
        var cls = "";

        if(fvalue == "All")
        {
            cls  = "navcards";
        }
        else if(fvalue == "forms")
        {
            cls  = "formCard";
        }
        else
        {
            cls  = "draftCard";
        }
        if(cls !== "")
        {
            $('.navcards').hide()

            var skipPages  = (perPageItems) * (pageNo - 1);

            var skipPageCountr = 1;
            var lop = 0;


            var loopSize  = $("."+cls).length;
            for(let o=(skipPages); o < loopSize;o++)
            {
                if(lop < (perPageItems))
                {
                    $("."+cls).eq(o).show('slow')
                }
                lop++;
            }
            $('.page_numbers').removeClass('active')
            $(e).addClass('active')
        }

    }
    function adjustPagination(cls)
    {
        var total_divs = $("."+cls).length;

        $(".navcards").hide();

        if(total_divs > 0)
        {
            var lop = 0;
            $("."+cls).each(function(){
                if(lop < (perPageItems))
                {
                    $(this).show('slow')
                }

                lop++;
            });


            let total_pages=total_divs/perPageItems
            let active_class='active'
            $('.pagination').empty();
            for(let i=0;i<total_pages;i++)
            {
                if(i>0)
                    if(i>0)
                    {
                        active_class=''
                    }
                let html=' <li class="page_numbers '+active_class+' page-item" onclick="changePage(this,'+(i+1)+')"><a class="page-link border border-variant-soft rounded" href="javascript:void(0)">'+(i+1)+'</a></li>'

                $('.pagination').append(html)

            }



            $('.pagination').show()
            $('.page_numbers').removeClass('active')
            $('.page_numbers').eq(0).addClass('active')
        }
    }

    $(document).on("change",".formsFilter",function(){
        $(".no-record").hide();
        $select  = $(this);
        var fvalue =  $select.val();
        $(".navcards").hide();
        if(fvalue == "All")
        {
            if($(".navcards").length < 1)
            {
                $(".no-record").show("slow");
            }
            else
            {
                adjustPagination('navcards');
            }
        }
        else if(fvalue == "forms")
        {
            $(".formCard").show("slow");
            if($(".formCard").length < 1)
            {
                $(".no-record").show("slow");
                $('.pagination').hide()

            }
            else
            {
                adjustPagination('formCard');
            }


        }
        else if(fvalue == "drafts")
        {
            $(".draftCard").show("slow");
            if($(".draftCard").length < 1)
            {
                $(".no-record").show("slow");
                $('.pagination').hide()
            }
            else
            {
                adjustPagination('draftCard');
            }

        }
        else
        {

            $('.pagination').hide();
            if (localStorage.getItem("form_in_process") || localStorage.getItem("form_2_in_process") || localStorage.getItem("process_draft_id")) {
                if (localStorage.getItem("form_in_process") == "yes" || localStorage.getItem("form_2_in_process")) {
                    if(localStorage.getItem("process_form_id") || localStorage.getItem("process_draft_id"))
                    {

                        if(localStorage.getItem("process_form_id") != "")
                        {

                            $(".formbadgeId_" + localStorage.getItem("process_form_id")).parents(".navcards").show();
                        }
                        else if(localStorage.getItem("process_draft_id") != "")
                        {
                            
                            $(".draftBadgeId_" + localStorage.getItem("process_draft_id")).parents(".navcards").show();
                        }
                        else
                        {
                            if(localStorage.getItem("form_in_process") && localStorage.getItem("form_in_process") == "yes")
                            {
                                $(".new-form-process-alert").show();
                            }
                        }
                    }
                    else
                    {
                        // $(".no-record").show("slow");
                        if(localStorage.getItem("form_in_process") && localStorage.getItem("form_in_process") == "yes")
                        {
                            $(".new-form-process-alert").show();
                        }
                    }
                }
                else
                {
                    $(".no-record").show("slow");
                }
            }
            else
            {
                $(".no-record").show("slow");
            }

            $('.pagination').hide()

        }
    });

    // translates the whole form, calls on language change
    function callTranslations() {
        console.log('Translation function called')
        // Change Values of Questions
        var elements = document.getElementsByClassName("questionTrans");
        
        for (var i = 0; i < elements.length; i++) {
            var valueLabel = '';
            var valueLabel2 = '';

            if (elements[i].getAttribute('data-org') == "" || elements[i].getAttribute('data-org') == null) {} else {

                //if (localStorage.getItem('Lang') == 'english')
                <?php if(trim($langURL,"/")=='english' || trim($langURL,"/")==''){  ?>
                {
                    // valueLabel = (elements[i].innerHTML).trim();
                    valueLabel = (elements[i].getAttribute('data-org')).trim();
                    valueLabel2 = (elements[i].getAttribute('data-org'));

                    elements[i].innerHTML = valueLabel
                }
                <?php } else { ?>
                // else if (localStorage.getItem('Lang') !== 'english')
                {
                    // valueLabel = (elements[i].innerHTML).trim();
                    valueLabel = (elements[i].getAttribute('data-org')).trim();
                    valueLabel2 = (elements[i].getAttribute('data-org'));

                    for (var loop = 0; loop < quesArr.length; loop++) {
                        if (quesArr[loop].label == valueLabel || quesArr[loop].label == valueLabel2) {
                            if (quesArr[loop].label_translation !== '') {
                                elements[i].innerHTML = quesArr[loop].label_translation;
                            }
                            break;
                        }

                    }
                }
                <?php } ?>
            }
        }

    }

</script>
</body>

<!-- Mirrored from corporx.themetags.com/services.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 Apr 2020 10:51:13 GMT -->

</html>