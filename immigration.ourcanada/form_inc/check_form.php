<?php
// this files contains accounts conditions 

$is_pro  = 'no';
$is_sform = 'no';
$is_draft = 'no';

$sformId = "";
$sdraftId = "";
$localStorage = "";

$btnLoaderShow = 'false';

// echo $currenTloggedUserId;

$formHtml = "";

function checkUserFormByid($formId)
{
    global $currenTloggedUserId, $conn;
    if (!empty($currenTloggedUserId)) {
        $checkResult = mysqli_query($conn, "SELECT * FROM `user_form` WHERE `id` = '$formId' AND `user_id` = '$currenTloggedUserId' ");
        if (mysqli_num_rows($checkResult) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
function checkUserDraftId($draftId, $formId = "")
{
    global $currenTloggedUserId, $conn;
    if (!empty($currenTloggedUserId)) {
        if (!empty($formId)) {
            $cCheckQuery = "SELECT * FROM `accounts_form_drafts` WHERE `id` = '$draftId' AND `userId` = '$currenTloggedUserId' AND form_id = '$formId' ";

            $checkResult = mysqli_query($conn, $cCheckQuery);
            if (mysqli_num_rows($checkResult) > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            $checkResult = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE `id` = '$draftId' AND `userId` = '$currenTloggedUserId' ");
            if (mysqli_num_rows($checkResult) > 0) {
                return true;
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

if (isset($cuurentUser)) {
    if ($cuurentUser['role'] == "1" || $cuurentUser['role'] == 1) {
        $is_pro = "yes";
    }

    $dbLang = "";
    if ($is_pro == "no") {
        // check for submitted forms for singed

        $checkResult = mysqli_query($conn, "SELECT * FROM `user_form` WHERE  `user_id` = '$currenTloggedUserId' ORDER BY `id` DESC");
        if (mysqli_num_rows($checkResult) > 0) {
            $dataRow = mysqli_fetch_assoc($checkResult);
            $is_sform  = "yes";
            $sformId = $dataRow['id'];

            $formHtml = $dataRow['form_data'];
            $localStorage = json_decode($dataRow['localStorage'], true);
            $dbLang = $dataRow['language'];
            // echo "coming form<br>";
            // echo $is_sform;
        } else {
            // echo "not coming form";
        }


        // check for draft if form no
        $checkDraftQuery = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE  `userId` = '$currenTloggedUserId' ORDER BY `id` DESC");
        if (mysqli_num_rows($checkDraftQuery) > 0) {
            $dataRow = mysqli_fetch_assoc($checkDraftQuery);
            // $formHtml
            // $sdraftId

            if($dataRow['priority'] == "1")
            {
                $sdraftId = $dataRow['id'];
                $formHtml = $dataRow['formHtml'];

                $is_draft = "yes";



                $btnLoaderShow = $dataRow['submitBtnVis'];
                $dbLang = $dataRow['locs_Lang'];


                $localStorage = json_decode($dataRow['localStorage'], true);
            }


            // echo "coming draft";
        } else {
            // echo "not coming draft";
        }
        if(strtolower($dbLang) == "french")
        {
            $dbLang = "francais";
        }

        //        $langType  #empty means Engish

        //            echo "--".$langType."--";
        if (empty($langType)) {
            //  english
            if ((ucfirst($dbLang)) != "English" && (!empty($dbLang))) {
                //                    echo ":::";
                header("Location: " . $currentTheme . "form/" . strtolower($dbLang));
            } else {
                //                    echo ";;;";
            }
        } else {

            if (ucfirst($dbLang) != ucfirst($langType) && (!empty($dbLang))) {
                //                    echo "::";
               if(strtolower($dbLang) == "english")
               {
                   header("Location: " . $currentTheme . "form");
               }
               else
               {
                   header("Location: " . $currentTheme . "form/" . strtolower($dbLang));
               }

            } else {
                //                    echo ";;";
            }
        }

    } else {
        // check for submitted forms for pro
//        echo "--".$langType."--";


        if (isset($chckPar[2])) {

            if (is_numeric($chckPar[2])) {
                $langType = "";
                if (count($chckPar) > 3) {

                    //                    $chckPar[2] for  fromId $chckPar[3] draft id
                    if (checkUserFormByid($chckPar[2])) {

                        $is_sform = 'yes';
                        $sformId = $chckPar[2];
                        if (checkUserDraftId($chckPar[3], $chckPar[2])) {
                            $is_draft = 'yes';
                            $sdraftId = $chckPar[3];




//                            $checkDrftforForm = mysqli_query($conn,"SELECT * FROM `accounts_form_drafts` WHERE id = '$sdraftId' AND ");



                        } else {
                            header("Location: " . $currentTheme . "form");
                        }
                    } else {
                        header("Location: " . $currentTheme . "form");
                    }
                } else {

                    // only $chckPar[2]
                    // may be draft may be form  but priorty is form first check for if form then ok otherwise  check for draft
                    if (checkUserFormByid($chckPar[2])) {

                        $is_sform = 'yes';
                        $sformId = $chckPar[2];
                    } else {
                        //                        check for draft if not form
                        if (checkUserDraftId($chckPar[2])) {

                            $is_draft = 'yes';
                            $sdraftId = $chckPar[2];
                        } else {
                            header("Location: " . $currentTheme . "form");
                        }
                    }
                }
            } else {

                if (count($chckPar) > 4) {
                    //                    $chckPar[3]   form from and $chckPar[4] for draft
                    $is_sform = 'yes';
                    $is_draft = 'yes';

                    $sformId = $chckPar[3];
                    $sdraftId = $chckPar[4];
                    if (checkUserFormByid($chckPar[3])) {
                        if (checkUserDraftId($chckPar[4], $chckPar[3])) {
                        } else {
                            header("Location: " . $currentTheme . "form");
                        }
                    } else {
                        header("Location: " . $currentTheme . "form");
                    }
                } else {
                    // only    $chckPar[3]
                    // may be draft may be form  but priorty is form first check for if form then ok otherwise  check for draft
                    if (checkUserFormByid($chckPar[3])) {

                        $is_sform = 'yes';
                        $sformId = $chckPar[3];
                    } else {
                        //                        check for draft if not form
                        if (checkUserDraftId($chckPar[3])) {

                            $is_draft = 'yes';
                            $sdraftId = $chckPar[3];
                        }
                    }
                }
            }
        }


        if ($is_sform == "yes" && $is_draft == "yes") {

            // from draft
            $checkDraftQuery = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE  `id` = '$sdraftId' ORDER BY `id` DESC");
            $dataRow = mysqli_fetch_assoc($checkDraftQuery);
            $formHtml = $dataRow['formHtml'];
            $btnLoaderShow = $dataRow['submitBtnVis'];
            $dbLang = $dataRow['locs_Lang'];


            $localStorage = json_decode($dataRow['localStorage'], true);
        } else if ($is_sform == "yes" && $is_draft == "no") {
            // load from form
            $checkResult = mysqli_query($conn, "SELECT * FROM `user_form` WHERE  `id` = '$sformId' ORDER BY `id` DESC");
            $dataRow = mysqli_fetch_assoc($checkResult);
            $dbLang = $dataRow['language'];


            $formHtml = $dataRow['form_data'];
            $localStorage = json_decode($dataRow['localStorage'], true);
        } else {
            if ($is_draft == "yes") {
                // load from draft
                $checkDraftQuery = mysqli_query($conn, "SELECT * FROM `accounts_form_drafts` WHERE  `id` = '$sdraftId' ORDER BY `id` DESC");
                $dataRow = mysqli_fetch_assoc($checkDraftQuery);
                $formHtml = $dataRow['formHtml'];
                $btnLoaderShow = $dataRow['submitBtnVis'];
                $dbLang = $dataRow['locs_Lang'];

                $localStorage = json_decode($dataRow['localStorage'], true);
            }
        }

        if(strtolower($dbLang) == "french")
        {
            $dbLang = "francais";
        }

        $proRedFormDrftURL = "";

        if(isset($chckPar[2])){


        if (is_numeric($chckPar[2])) {

            if (count($chckPar) > 3) {
                // 2 form id  && 3 draft id
                if ((!empty($dbLang))) {

                    if(ucfirst($dbLang) != "English")
                    {
                        $proRedFormDrftURL = $currentTheme . "form/".strtolower($dbLang)."/" . $sformId . "/" . $sdraftId;
                    }

                }
            } else {
                if ((!empty($dbLang))) {

                    if(ucfirst($dbLang) != "English")
                    {
                        $proRedFormDrftURL = $currentTheme . "form/".strtolower($dbLang)."/" . $sformId;
                    }


                }
            }
        } else {
            if (count($chckPar) > 4) {
//                2 lang 3 form 4 drfat
                if (ucfirst($dbLang) != ucfirst($langType) && (!empty($dbLang))) {
                    $proRedFormDrftURL =  $currentTheme . "form/".strtolower($dbLang)."/" . $sformId . "/" . $sdraftId;
                }
            } else {
//                2 lang 3 form
                if (ucfirst($dbLang) != ucfirst($langType) && (!empty($dbLang))) {
                    $proRedFormDrftURL = $currentTheme . "form/".strtolower($dbLang)."/" . $sformId ;
                }
            }
        }


    }


        if(!empty($proRedFormDrftURL))
        {
            header("Location: ".$proRedFormDrftURL);
        }
//        die();



    }
}
else
{
    if(is_numeric($langType))
    {
        header("Location: " . $currentTheme . "form");
    }

}



//



?>