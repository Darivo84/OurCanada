<?php
require_once 'user_inc.php';

$link = $_SERVER['PHP_SELF'];
$link_array = explode('/',$link);
$page = end($link_array);
// echo $page;

$get_color = [
    'podcasts' => 'red',
    'awardsandcontests' => '#0015ff',
    'communityresources' => '#d1783c',
    'settlingandlivingsuccessfullyincanada' => '#6b34ba',
    'canadianimmigrationnews' => '#7fbc1e',
    'videos' => '#d66300'
];
$url = 'https://ourcanada.app/community/';

$user_query = "SELECT * FROM users WHERE id = '{$_SESSION[ 'user_id' ]}'";
$user_result = mysqli_query( $conn, $user_query );
$user_row = mysqli_fetch_array( $user_result );
$user_row['username'] = $user_row['username'];
?>
<?php
function getTokens($user_id) // available tokens
{
    global $conn;
    $tokens = 0;
    $TokenResult = mysqli_query($conn, "SELECT * FROM `users` WHERE `id` = '$user_id'");
    $tokenData = mysqli_fetch_assoc($TokenResult);
    $tokens = $tokenData['points'];
    return (int)$tokens;
}
function totalReferedTo($user_id){
    global $conn,$user_row;
    $getData = mysqli_query($conn, "SELECT * FROM `referral` WHERE `refered_by` = '".$user_row['email']."'");
    return mysqli_num_rows($getData);
}
function usedTokens($user_id)
{
    global $conn;
    $querGetused = mysqli_query($conn,"SELECT  SUM(`points`) as used_points  FROM `wallethist` WHERE `user_id` = '$user_id' AND `isdebit` = '1'");
    $usedRow = @mysqli_fetch_assoc($querGetused);
    $usedPoints = (int) $usedRow['used_points'];
    return $usedPoints;

}
function totalTokens($user_id)
{
    return (usedTokens($user_id) + getTokens($user_id));
}
//echo '/'.getCurLang($langURL);
//$checkLang = mysqli_query($conn , "SELECT * FROM `multi-lingual` where lang_slug = '{'/'.getCurLang($langURL)}'");
//if(mysqli_num_rows($checkLang) > 0){
//
//}
//else
//{
//    '/'.getCurLang($langURL)='';
//}
?>
<style>
    .news_error_span
    {
        color:red;
        display:none;
    }
    .token:hover *:not(.badge){
        color: #000 !important;
    }
    .token:hover,.token:active{
        color: #000 !important;
        text-decoration: none !important;
    }
    .w-100{
        width: 100%;
    }
    @media only screen and (max-width: 685px) {
        .header_lang{
            display: none !important;
        }
    }
    .image-post-title a span{
        min-width: 100% !important;
    }
    .error
    {
        color: red;
    }
    .comment_del_modal
    {
        padding: 5px 15px;color: #bd0303;font-size: 20px;font-weight:bold !important;
    }
    .editCommentBtn
    {
        position: absolute;
        top: 86px;
    }
</style>
<style type="text/css">
    .com_del, .com-edit{
        position: absolute; background: transparent; border: 0;
    }
    .com_del:hover{
        color: red;
    }
    .com_edit{
        position: absolute; background: transparent; border: 0;
    }
    .com_edit:hover{
        color: green;
    }
    .snackbar{
        display: none;
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        z-index: 1111;
    }
    .snackbar .box{
        width: 350px;
        position: absolute;
        top: 10px;
        left: -webkit-calc(50% - 175px);
        left: -moz-calc(50% - 175px);
        left: -o-calc(50% - 175px);
        left: calc(50% - 175px);
    }
</style>
<style type="text/css">
    .tag{
        background: red !important;
        margin-right: 5px;
        color: #fff !important;
    }
    .comment_info{
        /*padding-bottom: 42px !important;*/
    }
    .comment-respond p{
        word-wrap: anywhere !important;
    }

    video {
        width: 100%;
        max-height: 350px;
        object-fit: revert;
        background-color: black;
    }
    #snackbarMSG{
        display: none;
        position: fixed;
        top: 15px;
        right: 15px;
        z-index: 1111;
        background: #90663c;
        box-shadow: 0px 0px 20px rgba(0,0,0,.6);
    }
    #snackbarMSG p{
        color: #fff;
        padding-top: 12px;
    }
</style>
<style type="text/css">
    .full_img{
        position: fixed;
        display: none;
        z-index: 9999;
        text-align: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0,0,0,.5);
    }
    .img{
        max-width: 80%;
        max-height: 80%;
    }

</style>

<style>

    <?php if($displayType == 'Right to Left'){ ?>
    body{
        text-align: right;
        direction: rtl;
    }
    a[type="button"] {
        margin: 0px 2px;
    }
    .modal-header .close {
        padding: 1rem 1rem;
        margin: -1rem -1rem -1rem 0;
    }
    .prompt,.prompt1,#display_error, .modal-header, label, .login_prompt, #content p, .comment_del_modal, .copyright-text,
    .enable_footer_columns_dark .widget .widget-title h2, .refTable th, .jelly_homepage_builder .post-entry-content,
    .jelly_homepage_builder .homepage_builder_title,
    .jl_single_style2 .single_post_entry_content .meta-category-small, .jl_single_style2 .single_post_entry_content .single_post_title_main, .jl_single_style2 .single_bellow_left_align .single-post-meta-wrapper{
        text-align: right;
    }
    .modal-title, .single-post-meta-wrapper .post-author img, .jl_single_style2 .single-post-meta-wrapper span.post-author a,
    .profile .col-md-6,  .nav-tabs > li, .jl_post_meta .jl_author_img_w, .jl_post_meta .post-date,
    .footer-columns .col-md-4, .widget_categories ul li a, footer .widget ul, .feature-post-list .item-details .meta-category-small a,
    .pagination > li > a, .pagination > li > span, .jelly_homepage_builder .homepage_builder_title h2,
    .jl_main_with_right_post .jl_main_post_style_padding, .jelly_homepage_builder.homepage_builder_3grid_post .row .blog_grid_post_style

    {
        float: right;
    }
    button.close
    {
        float: left;
    }

    .jl_post_meta .jl_author_img_w img
    {
        float: none;
    }
    .inputIcon
    {
        color: #8d633a; position: absolute; right: 12px; top: 41px;
    }
    .eyeIcon
    {
        color: #8d633a; position: absolute; left: 12px; top: 41px;
    }
    .loginInput
    {
        padding-right: 35px;
    }
    .bottom_footer_menu_text .col-md-5
    {
        float: right;
        text-align: right;

    }
    .bottom_footer_menu_text .col-md-7
    {
        float: left;
        text-align: left;
    }
    .com_del
    {
        left:50px
    }
    .com_edit
    {
        left: 75px;
    }
    .comment_content {
        padding-right: 20px;
    }
    .pendingComment
    {
        position: absolute; left: 60px; margin-top: -7px;
    }
    .auto_image_with_date .post-date
    {
        float: none;
    }
    .sidebarUsername
    {
        margin-left: -9px; float: right; widows: 100%;
    }
    .editSpan
    {
        clear: both;
        float: left;
    }
    .editCommentBtn
    {
        left: 4px;
    }
    .refTable td{
        text-align: left;
    }
    .modal-footer > :not(:first-child) {
        margin-right: .25rem;
    }
    .modal-footer > :not(:last-child) {
        margin-left: .25rem;
    }
    <?php } else {
        ?>
    .refTable td{
        text-align: right;
    }
    .editCommentBtn
    {
        right: 4px;
    }
    .modal-title, #exampleModalCenterTitle
    {
        float: left;
    }
    .inputIcon
    {
        color: #8d633a; position: absolute; left: 12px; top: 41px;
    }
    .eyeIcon
    {
        color: #8d633a; position: absolute; right: 12px; top: 41px;
    }
    .loginInput
    {
        padding-left: 35px;
    }
    .com_del
    {
        right:50px
    }
    .com_edit
    {
        right: 75px;
    }
    .comment_content {
        padding-left: 20px;
    }
    .pendingComment
    {
        position: absolute; right: 60px; margin-top: -7px;
    }
    .sidebarUsername
    {
        margin-left: -9px; float: left; widows: 100%;
    }
    .editSpan
    {
        /*clear: both;*/

        /*float: right;*/
    }
    <?php
    } ?>
</style>

<script src="https://kit.fontawesome.com/8fa0fd38df.js" crossorigin="anonymous"></script>
<div id="global-loader"> <img src="<?php echo $cms_url; ?>assets/img/loader.svg" class="loader-img" alt="Loader"> </div>
<header class="header-wraper jl_header_magazine_style two_header_top_style header_layout_style3_custom jl_cusdate_head">
    <div class="header_top_bar_wrapper ">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php date_default_timezone_set('Canada/Pacific'); ?>
                    <div class="jl_top_bar_right"> <span class="jl_current_title"><?= $allLabelsArray[720] ?>:</span> <span class="user_cur_date"><?php// echo date("d M, Y"); ?></span>
                        &nbsp;&nbsp;
                        <?php if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) && ($_SESSION['role'] == 'user')){ ?>
                            <?= $allLabelsArray[31] ?>&nbsp;<b style="margin-right: 10px;"><?php echo $user_row['username']; ?></b>&nbsp;&nbsp;<span class="jl_current_title"><a href="<?php echo $cms_url; ?>admin_inc.php?method=logout&lang=<?= getCUrLang($langURL,true) ?>" class="text-white"><?= $allLabelsArray[126] ?></a></span>
                            <a class="jl_current_title text-white" href="<?= $cms_url ?>profile<?= getCurLang($langURL) ?>" style="padding: 0 15px;"><?= $allLabelsArray[418] ?></a>
                        <?php }else{ ?>
                            <span class="jl_current_title"><a href="<?php echo $cms_url; ?>login<?= getCurLang($langURL) ?>" class="text-white"><?= $allLabelsArray[11] ?></a></span>
                            <span class="jl_current_title"><a href="<?php echo $cms_url; ?>register<?= getCurLang($langURL) ?>" class="text-white"><?= $allLabelsArray[165] ?></a></span>
                        <?php } ?>
                        <select name="language-picker-select" id="language-picker-select" class="form-control header_lang">
                            <option data-imagecss="flag it" data-image="<?php echo $baseURL.'/superadmin/uploads/flags/english.jpg'; ?>" lang="en" value="english"  selected>English</option>
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

                                <option data-imagecss="flag it" data-image="<?php echo $baseURL.'/superadmin/uploads/flags/'.$row['flag_image']; ?>"  data-id="<?php echo $row['display_type'] ?>" value="<?php echo $row['lang_slug'] ?>"  <?php if($langPar == $language) echo 'selected'; ?>><?php echo $row['display_name'] ?> </option>
                            <?php } ?>
                        </select>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="jl_blank_nav"></div>
    <div id="menu_wrapper" class="menu_wrapper jl_menu_sticky jl_stick ">
        <div class="container">
            <div class="row">
                <div class="main_menu col-md-12">
                    <div class="logo_small_wrapper_table">

                        <div class="logo_small_wrapper"> <a class="logo_link" href="<?= 'https://ourcanada'.$ext.getCurLang($langURL) ?>"> <img  src="<?= $cms_url ?>assets/img/logo.png" width="" height="" alt="Logo" /> </a> </div>
                    </div>
                    <!-- main menu -->
                    <div class="menu-primary-container navigation_wrapper">
                        <ul id="mainmenu" class="jl_main_menu">
                            <li class="menu-item "> <a href="<?php echo $cms_url; ?><?= getCurLang($langURL,true) ?>"><?= $allLabelsArray[7] ?><span class="border-menu"></span></a>
                                <!--<ul class="sub-menu">
                                                    <li class="menu-item"><a href="index-2.html">Home Demo 1<span class="border-menu"></span></a>
                                                    </li>
                                                 </ul>-->
                            </li>
                            <li class="menu-item <?php if(isset($_SESSION['user_id'])){echo "menu-item-has-children";}?>"> <a href="<?php echo $cms_url ?>blogs<?= getCurLang($langURL) ?>"><?= $allLabelsArray[590] ?><?php if(isset($_SESSION[ 'user_id' ])){ ?><span class="border-menu"></span><?php } ?></a>

                                <?php if(isset($_SESSION[ 'user_id' ])){?>
                                    <ul class="sub-menu">
                                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>my-blog<?= getCurLang($langURL) ?>"><?= $allLabelsArray[481] ?><?php if(isset($_SESSION[ 'user_id' ])){ ?><span class="border-menu"></span><?php } ?></a>

                                        </li>
                                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>blogs<?= getCurLang($langURL) ?>"><?= $allLabelsArray[482] ?><span class="border-menu"></span></a>

                                        </li>
                                    </ul> <?php }?>
                            </li>

                            <li class="menu-item <?php if(isset($_SESSION['user_id'])){echo "menu-item-has-children";}?>"> <a href="<?php echo $cms_url ?>news<?= getCurLang($langURL)?>"><?= $allLabelsArray[416] ?><?php if(isset($_SESSION[ 'user_id' ])){ ?><span class="border-menu"></span><?php } ?></a>

                                <?php if(isset($_SESSION[ 'user_id' ])){?>
                                    <ul class="sub-menu">
                                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>my-news<?= getCurLang($langURL) ?>"><?= $allLabelsArray[502] ?><?php if(isset($_SESSION[ 'user_id' ])){ ?><span class="border-menu"></span><?php } ?></a>

                                        </li>
                                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>news<?= getCurLang($langURL) ?>"><?= $allLabelsArray[503] ?><span class="border-menu"></span></a>

                                        </li>
                                    </ul> <?php }?>
                            </li>
                        </ul>
                    </div>
                    <div class="search_header_menu">
                        <div class="menu_mobile_icons d-none"><i class="fa fa-bars"></i>
                        </div>

                        <div class="menu_mobile_share_wrapper">
                            <ul class="social_icon_header_top">
                                <div class="buy-button">
                                    <?php if(isset($_SESSION['user_id'])){ ?>
                                        <a onclick="$('#tokenModal').modal();"  data-toggle="modal" style="cursor: pointer;margin-right: 15px;" class="token">
                                            <!-- <span style="color: red;">Token</span> -->
                                            <svg style="font-style: 18px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M20 2H10a3 3 0 0 0-3 3v7a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V5a3 3 0 0 0-3-3zm1 10a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1zm-3.5-4a1.49 1.49 0 0 0-1 .39a1.5 1.5 0 1 0 0 2.22a1.5 1.5 0 1 0 1-2.61zM16 17a1 1 0 0 0-1 1v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4h1a1 1 0 0 0 0-2H3v-1a1 1 0 0 1 1-1a1 1 0 0 0 0-2a3 3 0 0 0-3 3v7a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1a1 1 0 0 0-1-1zM6 18h1a1 1 0 0 0 0-2H6a1 1 0 0 0 0 2z" fill="#626262"/></svg>
                                            <!-- <i class="iconify" data-icon="uil-transaction" data-inline="false" style="color: red; font-size: 18px; display: none;"> -->
                                            <?php //if(getTokens($_SESSION['user_id']) == 'sss'){ ?>
                                            <!-- <span class="badge badge-default" style="background: red; margin-top: -15px; margin-left: -5px;"> -->
                                            <?php //echo getTokens($_SESSION['user_id']); ?></span>
                                            <?php //} ?>
                                            <!-- </i> -->
                                        </a>
                                    <?php } ?>
                                    <a onclick="<?php if(isset($_SESSION['user_id'])){?> $('#referAfriend').modal(); $('.alertRefer').html(''); <?php }else{ ?> $('#loginModel1').modal(); <?php } ?>" data-toggle="modal" class="btn btn-danger" style="cursor: pointer;background: red;"><?= $allLabelsArray[111] ?></a>
                                </div>
                                <!-- <li><a class="facebook" href="#" target="_blank"><i class="fa fa-facebook"></i></a> </li> -->
                                <!-- <li><a class="twitter" href="#" target="_blank"><i class="fa fa-twitter"></i></a> </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div id="content_nav" class="jl_mobile_nav_wrapper">
    <div id="nav" class="jl_mobile_nav_inner">
        <div class="menu_mobile_icons mobile_close_icons closed_menu"><span class="jl_close_wapper"><span class="jl_close_1"></span><span class="jl_close_2"></span></span>
        </div>
        <ul id="mobile_menu_slide" class="menu_moble_slide">

            <div style="width: 100%; margin: 15px auto; margin-top: 50px; padding-left: 30px;">
                <select  name="language-picker-select" id="language-picker-select" class="form-control" style="width: 250px; position: static;">
                    <option data-imagecss="flag it" data-image="<?php echo $baseURL.'/superadmin/uploads/flags/english.jpg'; ?>" lang="en" value="english"  selected>English</option>
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

                        <option data-imagecss="flag it" data-image="<?php echo $baseURL.'/superadmin/uploads/flags/'.$row['flag_image']; ?>"  data-id="<?php echo $row['display_type'] ?>" value="<?php echo $row['lang_slug'] ?>"  <?php if($langPar == $language) echo 'selected'; ?>><?php echo $row['display_name'] ?> </option>
                    <?php } ?>
                </select>
            </div>
            <li class="menu-item "> <a href="<?php echo $cms_url; ?><?= getCurLang($langURL) ?>"><?= $allLabelsArray[7] ?><span class="border-menu"></span></a>

            </li>
            <li class="menu-item <?php if(isset($_SESSION['user_id'])){echo "menu-item-has-children";}?>"> <a href="<?php echo $cms_url ?>blogs<?= getCurLang($langURL) ?>"><?= $allLabelsArray[590] ?><span class="border-menu"></span></a>
                <?php if($user_row['username']!=null){?>
                    <ul class="sub-menu">
                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>my-blog<?= getCurLang($langURL) ?>"><?= $allLabelsArray[481] ?><span class="border-menu"></span></a>

                        </li>
                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>blog<?= getCurLang($langURL) ?>"><?= $allLabelsArray[482] ?><span class="border-menu"></span></a>

                        </li>



                    </ul> <?php }?>
            </li>

            </li>
            <li class="menu-item <?php if(isset($_SESSION['user_id'])){echo "menu-item-has-children";}?>"><a href="<?php echo $cms_url ?>news<?= getCurLang($langURL) ?>"><?= $allLabelsArray[416] ?><span class="border-menu"></span></a>
                <?php if($user_row['username']!=null){?>
                    <ul class="sub-menu">
                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>my-news<?= getCurLang($langURL) ?>"><?= $allLabelsArray[502] ?><span class="border-menu"></span></a>

                        </li>
                        <li class="menu-item "> <a href="<?php echo $cms_url; ?>news<?= getCurLang($langURL) ?>"><?= $allLabelsArray[503] ?><span class="border-menu"></span></a>

                        </li>
                    </ul> <?php }?>
            </li>
            <?php if(isset($_SESSION['user_id'])){ ?>
                <li class="menu-item"><a href="<?php echo $cms_url; ?>admin_inc.php?method=logout&lang=<?= getCUrLang($langURL,true) ?>"><?= $allLabelsArray[126] ?></a></li>
            <?php } ?>
        </ul>
        <span class="jl_none_space"></span>
        <div id="disto_about_us_widget-2" class="widget jellywp_about_us_widget">
            <div class="widget_jl_wrapper about_widget_content">
                <div class="jellywp_about_us_widget_wrapper">
                    <div class="social_icons_widget">
                        <ul class="social-icons-list-widget icons_about_widget_display">


                            <?php if(isset($_SESSION['user_id'])){ ?>
                                <a onclick="$('.closed_menu').click(); $('#tokenModal').modal();" href="javascript:void(0)" data-toggle="modal" style="margin-right: 15px;" class="token">
                                    <!-- <span style="color: red;">Token</span> -->
                                    <svg style="font-style: 18px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M20 2H10a3 3 0 0 0-3 3v7a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V5a3 3 0 0 0-3-3zm1 10a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1zm-3.5-4a1.49 1.49 0 0 0-1 .39a1.5 1.5 0 1 0 0 2.22a1.5 1.5 0 1 0 1-2.61zM16 17a1 1 0 0 0-1 1v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4h1a1 1 0 0 0 0-2H3v-1a1 1 0 0 1 1-1a1 1 0 0 0 0-2a3 3 0 0 0-3 3v7a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1a1 1 0 0 0-1-1zM6 18h1a1 1 0 0 0 0-2H6a1 1 0 0 0 0 2z" fill="#626262"/></svg>
                                    <!-- <i class="uil uil-transaction" style="color: red; font-size: 18px;"> -->
                                    <?php //if(getTokens($_SESSION['user_id']) == 'sss'){ ?>
                                    <!-- <span class="badge badge-default" style="background: red; margin-top: -15px; margin-left: -5px;"> -->
                                    <?php //echo getTokens($_SESSION['user_id']); ?>

                                    <!-- </span> -->
                                    <?php// } ?>
                                    <!-- </i> -->
                                </a>
                            <?php } ?>
                            <a onclick="$('.closed_menu').click(); <?php if(isset($_SESSION['user_id'])){?> $('#referAfriend').modal(); $('.alertRefer').html(''); <?php }else{ ?> $('#loginModel1').modal(); <?php } ?>" href="javascript:void(0)" data-toggle="modal" class="btn btn-danger" style="background: red;"><?= $allLabelsArray[111] ?></a>
                            <br><br>

                        </ul>
                    </div>
                </div> <span class="jl_none_space"></span>
            </div>
        </div>
    </div>
</div>
<div class="mobile_menu_overlay"></div>

<div class="modal fade" style="background: rgba(0,0,0,.5);" id="loginModel1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content">
            <div class="modal-header" style="background: #8d633a;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff; text-align: center;"><?= $allLabelsArray[11] ?></h5>

                <button style="position: absolute; top: 20px; right: 15px; color: #fff;" type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('#loginModel form')[0].reset(); $('#loginModel').attr('class','modal fade'); $('#loginModel .log_err i').hide(); $('#loginModel .log_err span').text(''); $('#loginModel .modal-dialog').css('animation','shakes 0.5s');">
                    <span aria-hidden="true" style="color: #fff;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-10 col-lg-offset-1">
                    <div class="text-danger log_err" style="color: red; width: 100%; text-align: center;">
                        <i class="fa fa-frown-o" style="display:none; font-size: 36px;"></i><br>
                        <span style="font-weight: bold;"></span>
                    </div>
                    <input type="hidden" name="comment" hidden>
                    <input type="hidden" name="content_id" hidden value="<?= $id ?>">
                    <div class="form-group" style="position: relative;">
                        <label><?= $allLabelsArray[145] ?></label>
                        <i class="fa fa-envelope inputIcon" ></i>
                        <input type="email" placeholder="abc@gmail.com" name="email" class="form-control loginInput" required >
                    </div>
                    <div class="form-group" style="position: relative;">
                        <label><?= $allLabelsArray[146] ?></label>
                        <i class="fa fa-key inputIcon"></i>
                        <i class="fa fa-eye-slash eyeIcon" onclick="show_hide($(this));" ></i>
                        <input type="password" placeholder="<?= $allLabelsArray[146] ?>" name="password" class="form-control loginInput" required >
                    </div>
                    <div style="position: relative;" class="form-group text-right">
                        <a href="<?= $cms_url ?>forgot-password<?= getCurLang($langURL) ?>" style="font-weight: bold;color: #8d633a;"><?= $allLabelsArray[147] ?></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center; border: 0;">
                <button type="submit" class="btn btn-primary" style="width: 200px; background: #8d633a; border: 0; margin-bottom: 5px;"><?= $allLabelsArray[11] ?></button>
                <br>
                <?= $allLabelsArray[675] ?><a href="<?= $cms_url ?>register<?= getCurLang($langURL) ?>"><b style="color: #8d633a; margin-left: 10px;"><?= $allLabelsArray[165] ?></b></a>

            </div>
        </form>
    </div>
</div>

</div>

<div class="modal fade" id="tokenModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header" style="background: #8e643a;">
                <h5 class="modal-title" id="exampleModalCenterTitle" align="center" style="color: #fff;"><?= $allLabelsArray[465] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p><?php //$allLabelsArray[314] ?></p>
                        <table class="table table-center table-padding mb-0 refTable">
                            <tr>
                                <th><?= $allLabelsArray[467] ?></th>
                                <td id="totalReferal"><?php echo totalReferedTo($_SESSION['user_id']) ?></td>
                            </tr>
                            <tr>
                                <th><?= $allLabelsArray[464] ?></th>
                                <td><?php echo usedTokens($_SESSION['user_id']) ?></td>
                            </tr>
                            <tr>
                                <th><?= $allLabelsArray[465] ?></th>
                                <td><?php echo getTokens($_SESSION['user_id']) ?></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer pl-0">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
            </div>
        </div>
    </div>
</div>

<?php ob_start(); ?>
$("#loginModel1 form").validate({
errorClass: 'text-danger',
messages: {
email: {
required: '<?= $allLabelsArray[48] ?>',
email: '<?= $allLabelsArray[32] ?>',
},
password: {
required: '<?= $allLabelsArray[48] ?>',
}},
submitHandler: function(form){
$.ajax({
type: "POST",
url: "<?= $cms_url ?>ajax.php?h=login&lang=<?= getCurLang($langURL,true) ?>",
data: $("#loginModel1 form").serialize(),
dataType: "json",
beforeSend: function(){
$("#loginModel1 form .fa-spin").show();
$("#loginModel1 .btn-primary").prop("disabled",true)
},
success: function(res){
$("#loginModel1 .btn-primary").prop("disabled",false)
$("#loginModel1 form .fa-spin").hide();
if(res.Success == 'false' && res.status == 1){
$("#continueAlert").html('<div class="alert alert-info" style=""><i class="fa fa-exclamation-triangle" style="margin-right:10px;"></i>' + static_label_changer(res.Msg) + '</div>');
$("#continueLoginModal").modal();
}else{
if(res.Success == 'false'){
$("#loginModel1 .log_err").text(res.Msg)
}else{
$("#loginModel1 .log_err").after('<div class="alert alert-success">'+res.Msg+'</div>');
setTimeout(function(){
window.open('<?= $cms_url.getCurLang($langURL,true) ?>','_self');

},2000);
}
}
},error: function(e){
$("#loginModel1 .btn-primary").prop("disabled",false)
$("#loginModel1 form .fa-spin").hide();
console.log(e)
}
});
return false;
}
});
<?php $login_popup = ob_get_clean(); ?>

<div class="modal fade" id="referAfriend" tabindex="-1" role="dialog" style="padding-right: 17px;" aria-modal="true">
    <div class="modal-dialog modal-md" role="document" style="text-align: center;">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header" style="background: #9a7045;">
                <h5 class="modal-title referAfriend_title" id="exampleModalCenterTitle" style="color: #fff;"><?= $allLabelsArray[436] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: #fff !important;">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h2><?= $allLabelsArray[111] ?></h2>
                <p><?= $allLabelsArray[708] ?></p>
                <form method="post" id="referFriend" novalidate="novalidate">
                    <div class="row">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-10">
                            <div class="alertRefer"></div>
                            <div class="form-group position-relative">
                                <label><?= $allLabelsArray[290] ?> <span class="text-danger">*</span></label>
                                <input name="email" id="referEmail" type="email" class="form-control pl-5" placeholder="name@gmail.com" required>
                            </div>
                            <button type="submit" class="btn btn-primary" id="referProcess" style="background: #9a7045; border: 0;"><?= $allLabelsArray[709] ?> </button>
                        </div><!--end col-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="continueLoginModal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="continueLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title static_label" id="continueLoginModalLabel" data-org="<?php // echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[264] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="width: 100%;" id="continueAlert">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close_continueLoginmodal" class="btn btn-secondary static_label" data-dismiss="modal" data-org="<?php //echo $allLabelsEnglishArray[103] ?>"><?php echo $allLabelsArray[103] ?></button>
                <button type="button" id="continueLoginbtn" class="btn btn-success static_label" data-org="<?php //echo $allLabelsEnglishArray[28] ?>"><?php echo $allLabelsArray[28] ?></button>
            </div>
        </div>
    </div>
</div>