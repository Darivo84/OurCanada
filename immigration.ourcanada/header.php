<?php
require_once 'user_inc.php';

ini_set('display_errors',0);
ini_set('max_execution_time', 500000);
ini_set('memory_limit', '3200M');




?>

<!--loader start-->


<!--loader end-->

<!--header section start-->
<header class="header">
    <!--start navbar-->
    <nav class="navbar navbar-expand-lg fixed-top bg-transparent">
        <div class="container">
            <?php
            if(isset($_GET['mode']) && $_GET['mode']=='mobile')
            {
               ?>
                <a class="navbar-brand" href="<?php echo $domain; ?><?php echo $langURL; ?>" style="color: white;font-size: 27px">
                    <img src="<?php echo $currentTheme; ?>img/ourcanada.png" alt="logo" class="img-fluid"/>
                </a>
            <?php
            }
            else
            {

                ?>
                <a class="navbar-brand" href="<?php echo $domain; ?><?php echo $langURL; ?>" style="color: white;font-size: 27px">
                    <img src="<?php echo $currentTheme; ?>img/ourcanada.png" alt="logo" class="img-fluid"/>
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="ti-menu"></span>
                </button>
                <div class="collapse navbar-collapse h-auto" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto menu">
                        <li><a href="<?php echo $baseURL; ?><?php echo $langURL; ?>" class="static_label" data-org="<?php echo $allLabelsEnglishArray[7] ?>"><?php echo $allLabelsArray[7] ?></a>

                        </li>
                        <li><a  href="https://ourcanada<?php echo $ext; ?>/about-us<?php echo $langURL; ?>" target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[8] ?>"><?php echo $allLabelsArray[8] ?></a></li>

                        <?php
                        if(isset($_SESSION['user_id']))
                        {
                            ?>
                            <li><a  href="<?php echo $baseURL; ?>/form<?php echo $langURL; ?>"   class="static_label" data-org="<?php echo $allLabelsEnglishArray[9] ?>"><?php echo $allLabelsArray[9] ?></a></li>
                            <?php
                        }
                        else {
                            ?>
                            <li><a  href="<?php echo $baseURL; ?>/form<?php echo $langURL; ?>"  data-toggle="modal" data-target="#exampleModal" class="static_label" data-org="<?php echo $allLabelsEnglishArray[9] ?>"><?php echo $allLabelsArray[9] ?></a></li>
                        <?php } ?>
                        <li><a  href="https://ourcanada<?php echo $ext; ?>/contact-us<?php echo $langURL; ?>" target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[10] ?>"><?php echo $allLabelsArray[10] ?></a></li>
                        <?php if(!isset($_SESSION['user_id'])) { ?>
                            <li><a href="<?php echo $baseURL ?>/login<?php echo $langURL; ?>" class="static_label" data-org="<?php echo $allLabelsEnglishArray[136] ?>"><?php echo $allLabelsArray[136] ?></a></li>

                        <?php }
                        else {

                            $userQueryResult = mysqli_query($conn,"SELECT * FROM `users` WHERE `id` = '{$_SESSION['user_id']}'");
                            $userRow = mysqli_fetch_assoc($userQueryResult);


                            ?>
                            <li>
                                <a  style="cursor: pointer" onclick="return false;"><span class="static_label" data-org="<?php echo $allLabelsEnglishArray[125] ?>"><?php echo $allLabelsArray[125] ?></span> </a>
                                <ul class="navbar-nav ml-auto menu childUL" id="accountUl">
                                    <?php
                                    if($userRow['role'] == '1' || $userRow['role'] == 1)
                                    {
                                        ?>
                                        <li><a href="<?php echo $baseURL; ?>/myforms<?php echo $langURL; ?>" class="static_label" data-org="<?php echo $allLabelsEnglishArray[186] ?>"><?php echo $allLabelsArray[186] ?></a> </li>
                                        <?php
                                    }

                                    ?>
                                    <li><a href="javascript:void(0)"><?php echo $_SESSION['email'] ?></a> </li>
                                    <li><a href="<?php echo $baseURL; ?>/settings<?php echo $langURL; ?>" class="static_label" data-org="<?php echo $allLabelsEnglishArray[308] ?>"><?php echo $allLabelsArray[308] ?></a> </li>

                                    <li><a id="logoutLink" class="static_label" href="<?php echo $currentTheme; ?>logout<?php echo $langURL; ?>" data-org="<?php echo $allLabelsEnglishArray[126] ?>"><?php echo $allLabelsArray[126] ?></a></li>

                                </ul>
                            </li>
                        <?php } ?>
                        <li>
                            <?php if($page == 'multilingual') { ?>
                                <div class="language-picker js-language-picker">
                                        <select  name="language-picker-select" id="languagePickerSelect" class="form-control <?php if(!empty($dbLang)){ echo "disable_field"; } ?>">

                                            <option  data-imagecss="flag it" data-image="<?php echo $domain.'/superadmin/uploads/flags/english.jpg'; ?>" lang="en" value="english"  selected>English</option>
                                            <?php
                                            $query = "SELECT * FROM `multi-lingual`  WHERE status = 1 order by language ASC";
                                            $result = mysqli_query($conn, $query);
                                            while($row = mysqli_fetch_assoc($result)){
                                                $langPar = $row['lang_slug'];
                                                if($row['lang_slug'] == 'french'){
                                                    $row['lang_slug'] = 'francais';
                                                }
                                                $index = array_search(ucfirst($row['language']), $allLabelsEnglishArray);

                                                ?>
                                                <option data-imagecss="flag it" data-image="<?php echo $domain.'/superadmin/uploads/flags/'.$row['flag_image']; ?>"  <?php if(strtolower($langPar) == $language) echo 'selected'; ?> data-id="<?php echo $row['display_type'] ?>" value="<?php echo $row['lang_slug'] ?>" ><?php echo $row['display_name'] ?></option>
                                            <?php } ?>

                                        </select>
                                </div>
                            <?php } ?>

                            <?php if($webConversion == true) { ?>
                                <div class="language-picker js-language-picker">

                                        <select  name="language-picker-select" id="languagePickerSelect" class="form-control <?php if(!empty($dbLang)){ echo "disable_field"; } ?>">

                                            <option  data-imagecss="flag it" data-image="<?php echo $domain.'/superadmin/uploads/flags/english.jpg' ?>" lang="en" value="english"  selected>English</option>
                                            <?php

                                            $query = "SELECT * FROM `multi-lingual`  WHERE status = 1 order by language ASC";
                                            $result = mysqli_query($conn, $query);

                                            while($row = mysqli_fetch_assoc($result)){
                                                $langPar = $row['lang_slug'];
                                                if($row['lang_slug'] == 'french'){

                                                    $row['lang_slug'] = 'francais';
                                                }
                                                $index = array_search(ucfirst($row['language']), $allLabelsEnglishArray);

                                                ?>
                                                <option data-imagecss="flag it" data-image="<?php echo $domain.'/superadmin/uploads/flags/'.$row['flag_image']; ?>"  <?php if(strtolower($langPar) == $language) echo 'selected'; ?> data-id="<?php echo $row['display_type'] ?>" value="<?php echo $row['lang_slug'] ?>" ><?php echo $row['display_name'] ?></option>
                                            <?php } ?>

                                        </select>

                                </div>

<!--                                <select  name="language-picker-select" id="languagePickerSelect" class="form-control --><?php ////if(!empty($dbLang)){ echo "disable_field"; } ?><!--">-->
<!---->
<!--                                    <option lang="en" value="english" class="static_label" data-org="--><?php //echo $allLabelsEnglishArray[12] ?><!--" selected>--><?php //echo $allLabelsArray[12] ?><!--</option>-->
<!--                                    --><?php
//
//                                    $query = "SELECT * FROM `multi-lingual`  WHERE status = 1 order by language ASC";
//                                    $result = mysqli_query($conn, $query);
//
//                                    while($row = mysqli_fetch_assoc($result)){
//                                        $langPar = $row['lang_slug'];
//                                        if($row['lang_slug'] == 'french'){
//
//                                            $row['lang_slug'] = 'francais';
//                                        }
//                                        $index = array_search(ucfirst($row['language']), $allLabelsEnglishArray);
//
//                                        ?>
<!--                                        <option  --><?php //if(strtolower($langPar) == $language) echo 'selected'; ?><!-- data-id="--><?php //echo $row['display_type'] ?><!--" value="--><?php //echo $row['lang_slug'] ?><!--" class="static_label" data-org="--><?php //echo $allLabelsEnglishArray[$index] ?><!--">--><?php //echo $allLabelsArray[$index] ?><!--</option>-->
<!--                                    --><?php //} ?>
<!---->
<!--                                </select>-->

                            <?php } ?>
                        </li>
                    </ul>

                </div>

            <?php
            }
            ?>

        </div>
    </nav>
</header>
<!--header section end-->


<!-- Modal -->
<div class="modal fade" id="formProcessModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo $allLabelsArray[272] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo $allLabelsArray[273] ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="secondary-solid-btn" data-dismiss="modal"><?php echo $allLabelsArray[5] ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label"  data-org="<?php echo $allLabelsEnglishArray[176] ?>" ><?php echo $allLabelsArray[176] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[177] ?>"><?php echo $allLabelsArray[177] ?></span>
            </div>
            <div class="modal-footer">
                <a  href="<?php echo $baseURL; ?>/form<?php echo $langURL; ?>" class="btn btn-secondary static_label" data-org="<?php echo $allLabelsEnglishArray[233] ?>"><?php echo $allLabelsArray[233] ?></a>
                <a href="<?php echo $baseURL; ?>/login<?php echo $langURL; ?>" class="btn btn-primary static_label" data-org="<?php echo $allLabelsEnglishArray[11] ?>"><?php echo $allLabelsArray[11] ?></a>
            </div>
        </div>
    </div>
</div>

<?php
if($checkError)
{
    exit(include '404.php');
}
?>