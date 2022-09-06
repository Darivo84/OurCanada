<?php

require_once 'cms_error.php';

$page = 'inner';

include_once( "community/user_inc.php" );
include("community/admin_inc.php");

$userData = mysqli_query($conn,"SELECT * FROM users WHERE id = ".$_SESSION['user_id']);
$user = mysqli_fetch_assoc($userData);
$old_img = $user['profileimg'];

if(isset($_GET['page'])) {
    $getAwards = mysqli_query($conn, "SELECT * FROM referral WHERE refered_by = '{$user['email']}' ORDER by id DESC  LIMIT 9 OFFSET ".(($_GET['page'] - 1) * 9));
}else{
    $getAwards = mysqli_query($conn, "SELECT * FROM referral WHERE refered_by = '{$user['email']}' ORDER by id DESC  LIMIT 9");
}
function generateRandomString($length = 10) {
    $characters = '0123456789abchijklmn0123456789opqrxyzA0123456789BCDEHIJKLM0123456789NOPQ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
<!DOCTYPE html>

<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <?php
    if($environment)
    {
        ?>
        <link rel="canonical" href="https://ourcanada<?php echo $ext ?>/community/profile" />

        <?php
    }
    ?>
    <!-- Title-->
    <title><?= $allLabelsArray[418] ?></title>
    <!-- Favicon-->
    <?php include("community/includes/style.php"); ?>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <!-- end head -->
    <style type="text/css">
        .error{
            color: red;
        }
        #profile_pic{
            width: 80px;
            height: 80px;
            border-radius: 100%;
        }
        form.profile input,form.profile textarea{
            padding-left: 40px;
        }
        form.profile .form-group{
            position: relative;
        }
        form.profile .form-group svg{
            position: absolute;
            left: 10px;
            top: 40px;
        }
        .btn-login:hover{
            color: #fff !important;
        }
        .del_btn{
            background: #fff !important;
            color: red !important;
            border: 1px solid red !important;
        }
        .del_btn:hover{
            background: red !important;
            color: #fff !important;
        }
    </style>
</head>

<body class="mobile_nav_class jl-has-sidebar">
<div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">
    <div class="options_layout_container full_layout_enable_front">
        <!-- Start header -->
        <?php include("community/includes/header.php"); ?>
        <!-- end header -->
        <ul class="nav nav-tabs col-lg-6 col-lg-offset-3" style="margin-top: 50px;">
            <li onclick="$('#profile-tab').slideDown(); $('#refer-tab').slideUp();"><a href="javascript:void(0)"><?= $allLabelsArray[418] ?></a></li>
            <li onclick="$('#refer-tab').slideDown(); $('#profile-tab').slideUp();"><a href="javascript:void(0)"><?= $allLabelsArray[443] ?></a></li>
        </ul>
        <div id="profile-tab" class="col-lg-12" style="margin-bottom: 50px; margin-top: 30px; padding-left: 0; padding-right: 0;">
            <form class="col-lg-6 col-lg-offset-3" id="profile_pic_form" style="padding-left: 0; padding-right: 0;">
                <label><?= $allLabelsArray[444] ?> :</label><br>

                <img id="profile_pic" src="<?php if(!empty($user['profileimg'])){ echo $cms_url.'profiles/'.$user['profileimg'];}else{echo $default_profile;} ?>">
                <input type="file" style="display: none;" name="user_profile_pic" accept="image/*">

                <button onclick="showForm();" type="button" class="btn btn-login btn-lg" style="margin-left: 25px; background: red !important;"><?= $allLabelsArray[445] ?></button>
                <?php if(!empty($user['profileimg'])){ ?>
                    <button onclick="deletePhoto();" type="button" class="btn btn-login btn-lg del_btn" style="margin-left: 15px;"><?= $allLabelsArray[446] ?></button>
                <?php } ?>
            </form>
            <form method="post" id="validateForm" class="profile col-lg-6 col-lg-offset-3" novalidate="novalidate" style="margin-top: 30px;padding-left: 0; padding-right: 0;">
                <div class="pf prompt"></div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[213] ?></label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <input name="username" id="username" type="text" class="form-control pl-5" required placeholder="<?= $allLabelsArray[213] ?>:" value="<?= $user['username'] ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[447] ?></label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user fea icon-sm icons"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <input name="firstname" id="first" type="text" class="form-control pl-5" placeholder="<?= $allLabelsArray[447] ?> :" value="<?= $user['firstname'] ?>">
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[448] ?></label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check fea icon-sm icons"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                            <input name="lastname" id="last" type="text" class="form-control pl-5" placeholder="<?= $allLabelsArray[448] ?> :" value="<?= $user['lastname'] ?>">
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-12"></div>
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[117] ?></label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail fea icon-sm icons"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <input id="email" type="email" class="form-control pl-5" placeholder="<?= $allLabelsArray[117] ?> :" value="<?= $user['email'] ?>" readonly="">
                        </div>
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[449] ?> :</label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone fea icon-sm icons"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <input name="phone" id="number" type="number" class="form-control pl-5" placeholder="<?= $allLabelsArray[449] ?> :" value="<?= $user['phone'] ?>">
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-12"></div>
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[722] ?></label>
                            <select class="form-control custom-select valid" name="gender">
                                <option selected="" value="">--<?= $allLabelsArray[723] ?>--</option>
                                <option value="male" <?php if(isset($user['gender']) && strtolower($user['gender']) == 'male'){echo "selected";} ?>><?= $allLabelsArray[724] ?></option>
                                <option value="female" <?php if(isset($user['gender']) && strtolower($user['gender']) == 'female'){echo "selected";} ?>><?= $allLabelsArray[725] ?></option>
                                <option value="other" <?php if(isset($user['gender']) && strtolower($user['gender']) == 'other'){echo "selected";} ?>><?= $allLabelsArray[458] ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[451] ?></label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle fea icon-sm icons"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <textarea name="description" id="description" rows="4" class="form-control pl-5" placeholder="<?= $allLabelsArray[451] ?> :"><?= $user['description'] ?></textarea>
                        </div>
                    </div>
                </div><!--end row-->
                <div class="row">
                    <div class="col-sm-12">
                        <button type="submit" id="addLoader" name="send" class="btn btn-primary" style="background: red; border: 0;"><?= $allLabelsArray[452] ?></button>
                    </div><!--end col-->
                </div><!--end row-->
            </form>
            <form method="post" id="updatePassword" autocomplete="off" style="padding-left: 0; padding-right: 0;" class="col-lg-6 col-lg-offset-3 profile">
                <label><?= $allLabelsArray[246] ?></label>
                <div class="pf prompt"></div>
                <input type="hidden" name="old" value="<?= generateRandomString(6).$_SESSION['user_id'].generateRandomString(8); ?>">
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[307] ?> :</label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key fea icon-sm icons"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                            <input type="password" class="form-control pl-5" placeholder="<?= $allLabelsArray[307] ?>" name="old_password" required="">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[247] ?> :</label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key fea icon-sm icons"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                            <input type="password" id="password" class="form-control pl-5" placeholder="<?= $allLabelsArray[248] ?>" name="password" required="">
                            <label class="error" id="passError4" style="display: none"><span><i class="fa fa-exclamation-triangle"></i></span> <span class='p_error'><?= $allLabelsArray[743] ?></span></label>

                        </div>
                    </div><!--end col-->

                    <div class="clearfix"></div>

                    <div class="col-md-6">
                        <div class="form-group position-relative">
                            <label><?= $allLabelsArray[453] ?> :</label>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-key fea icon-sm icons"><path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4"></path></svg>
                            <input type="password" id="cpassword" class="form-control pl-5" placeholder="<?= $allLabelsArray[453] ?>" name="password_confirm" required="" autocomplete="off">

                        </div>
                    </div><!--end col-->


                    <div class="col-sm-12">
                        <button type="submit" id="addLoader" name="send" class="btn btn-primary" style="background: red; border: 0;"><?= $allLabelsArray[454] ?></button>
                    </div><!--end col-->

                </div><!--end row-->
            </form>
        </div>

        <div id="refer-tab" class="col-lg-12" style="display:none; margin-bottom: 50px; margin-top: 30px;">
            <div class="container" style="overflow: auto;">
                <style type="text/css">
                    #refer_table tr td{
                        line-height: 40px;
                    }
                    #refer_table_paginate span{
                        display: none !important;
                        color: #fff !important;
                    }
                    #refer_table_next:hover{
                        background: #845a31 !important;
                        color: #fff !important;
                    }
                    #refer_table_previous:hover{
                        background: #845a31 !important;
                        color: #fff !important;
                    }
                    .paginate_button.next{
                        border-radius: 5px !important;
                        line-height: 20px !important;
                        color: #fff !important;
                    }
                    .paginate_button.previous{
                        border-radius: 5px !important;
                        line-height: 20px !important;
                        color: #fff !important;
                    }
                    .paginate_button.disabled{
                        color: #fff !important;
                    }
                </style>
                <div class="row">
                    <table id="refer_table" class="table table-center table-padding mb-0 mt-4">
                        <thead>
                        <tr>
                            <th class="py-3" style="min-width:20px "></th>
                            <th class="py-3" style="min-width: 200px;"><?= $allLabelsArray[467] ?></th>
                            <th class="text-center py-3" style="min-width: 120px;"><?= $allLabelsArray[468] ?></th>
                            <th class="text-center py-3" style="min-width: 120px;"><?= $allLabelsArray[469] ?></th>
                            <th class="text-center py-3" style="min-width: 120px;"><?= $allLabelsArray[470] ?></th>
                            <th class="text-center py-3" style="min-width: 120px;"><?= $allLabelsArray[474] ?></th>
                            <th class="text-center py-3" style="min-width: 120px;"><?= $allLabelsArray[475] ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $count = 1;
                        while($rows = mysqli_fetch_assoc($getAwards)) {
                            $list++;
                            ?>
                            <tr class="list_<?= $list ?> <?php if($rows['status'] == 0) { echo 'pending'; } else { echo 'approved'; } ?>">
                                <td class="h6"><a href="javascript:void(0)" class="text-danger"><?= $count; ?></a></td>
                                <td>
                                    <?= $rows['refered_to']; ?>
                                </td>
                                <td class="text-center"><?= $rows['refered_code']; ?></td>
                                <td class="text-center">
                                    <?php
                                    $date = date_create($rows['refered_date']);
                                    echo date_format($date,"Y/m/d");
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php
                                    $date = date_create($rows['refered_date']);
                                    echo date_format($date,"h:i A");
                                    ?>
                                </td>
                                <td class="text-center font-weight-bold"><?php if($rows['token'] > 0){echo $rows['token'];}else {echo "...";} ?></td>
                                <td class="text-center font-weight-bold">
                                    <?php if($rows['status'] == 0) { echo '<a class="text-danger">'.$allLabelsArray[660].'</a>'; } else {
                                        echo '<a class="text-success">'.$allLabelsArray[662].'</a>';
                                    } ?>
                                </td>
                            </tr>
                            <?php
                            $count++;
                        } ?>
                        </tbody>
                    </table>

                    <!-- PAGINATION START -->
                    <!-- <ul class="pagination">
                        <li>
                            <a class="page-link" href="https://awards.ourcanadadev.site/profile/tokens?page=-1">Prev</a>
                        </li>
                        <li>
                            <a class="page-link" href="https://awards.ourcanadadev.site/profile/tokens?page=1">Next</a>
                        </li>
                    </ul> -->
                    <!--end col-->
                    <!-- PAGINATION END -->
                </div><!--end row-->

            </div>
        </div>

        <div class="modal" id="error_model" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $allLabelsArray[563] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= $allLabelsArray[174] ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="image_form" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #93693f;">
                        <h5 class="modal-title" align="center" style="color: #fff;"><?= $allLabelsArray[598] ?></h5>
                        <button type="button" class="close"  data-dismiss="modal" aria-label="Close" onclick="resetData();">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <p id="noImage"><?= $allLabelsArray[742] ?></p>
                        <p class="text-danger img_errors" style="margin: 15px 0;"></p>
                        <img src="" id="preview_pic" style="display: none; margin-bottom: 15px; width: 200px; height: 200px; border-radius: 100%;"><br>
                        <button class="btn btn-login" onclick="$('input[name=user_profile_pic]').click();"><?= $allLabelsArray[663] ?></button>
                    </div>
                    <div class="modal-footer" style="border: 0; text-align: center; display: none;">
                        <button type="button" class="btn btn-danger"><i style="display: none;" class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[599] ?></button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= $allLabelsArray[103] ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="conf_box" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background: #93693f;">
                        <h5 class="modal-title" align="center" style="color: #fff;"><?= $allLabelsArray[176] ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align: center;">
                        <div></div>
                    </div>
                    <div class="modal-footer" style="border: 0; text-align: center;">
                        <button type="button" class="btn btn-danger"><i style="display: none;" class="fa fa-spin fa-spinner"></i> <?= $allLabelsArray[40] ?></button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal"><?= $allLabelsArray[41] ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal com_not" tabindex="-1" role="dialog" style="background: rgba(0,0,0,.3);">
            <div role="document" class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center" style="background: #92683e;">
                        <i aria-hidden="true" style="font-size: 128px;color: #fff;" class="fa fa-smile-o"></i>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="$('.com_not').slideUp();">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div></div></div>
                    <div class="modal-body">
                        <p style="text-align: center;font-size: 36px;color: red;"></p>
                    </div>
                    <div class="modal-footer" style="/*! border-top: 0; */border: 0;text-align: center;">
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="$('.com_not').slideUp();" style="width: 150px;background: #92683e;color: #fff;"><?= $allLabelsArray[5] ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start footer -->
        <?php include("community/includes/footer.php"); ?>
        <!-- End footer -->
    </div>
</div>
<div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>
<?php include("community/includes/script.php"); ?>
<script type="text/javascript" src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $('#password').on('keyup',function () {
        let pass=$('#password').val()

        if(pass.length < 4)
        {
            $('#passError4').prev('label.error').remove()
            $('#passError4').show()
            return false;
        }
        else
        {
            $('#passError4').hide()

        }


    })
    $('#password').on('focusout keypress keydown keyup',function () {
        let pass=$('#password').val()

        if(pass=='' || pass==null)
        {
            $('#passError4').hide()

            $('#passError4').prev('label.error').remove()
        }

    })
    function showForm(){
        $("#image_form").modal();
    }

    function deletePhoto(){
        $("#conf_box .modal-body div").text("<?= $allLabelsArray[600] ?>");
        $("#conf_box").modal();
        $("#conf_box .btn-danger").click(function(){
            var sel = $(this);
            $.ajax({
                type: "POST",
                url: "<?= $cms_url ?>ajax.php?h=deletePhoto&lang=<?= getCurLang($langURL,true) ?>",
                dataType: "json",
                beforeSend: function(){
                    sel.children("i").show();
                },success: function(res){
                    if(res.success){
                        $("#profile_pic").attr("src","<?= $default_profile ?>");
                        $("#conf_box .close").click();
                        $('.del_btn').hide()
                    }
                    sel.children("i").hide();
                    console.log(res)
                },error: function(e){
                    sel.children("i").hide();
                    console.log(e)
                }
            });
        });
    }

    $(document).ready( function () {
        $('#refer_table').DataTable({
            "pageLength": 10,
            "bInfo" : false,
            "info": false,
            "language": {
                "search": "",
                "emptyTable": "<?= $allLabelsArray[512] ?>",
                "sSearch": "<?= $allLabelsArray[512] ?>",
                "zeroRecords": "<?= $allLabelsArray[512] ?>"
            },
            <?php if(mysqli_num_rows($getAwards) < 10){echo '"bPaginate": false';} ?>
        });
    } );

    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview_pic').attr('src', e.target.result);
                $("#preview_pic").show();
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetData(){
        $("#profile_pic_form")[0].reset();
        $("#preview_pic").hide();
        $("#image_form .modal-footer").hide();
        $(".img_errors").text("");
    }


    $(document).ready(function() {
        $("input[name=user_profile_pic").change(function(){
            if(this.files[0].size > 2000000){
                $("#profile_pic_form")[0].reset();
                $(".img_errors").text("<?= $allLabelsArray[601] ?>");
            }else{
                readURL(this);
                $('#noImage').hide();
                $(".img_errors").text("");
                $("#image_form .modal-footer").show();
                $("#image_form .btn-danger").click(function(){
                    var sel_btn = $(this);
                    $.ajax({
                        type: "POST",
                        url: "<?= $cms_url ?>ajax.php?h=update_profile_pic&lang=<?= getCurLang($langURL,true) ?>",
                        data: new FormData($("#profile_pic_form")[0]),
                        enctype: 'multipart/form-data',
                        dataType: "json",
                        contentType: false,
                        cache: false,
                        processData:false,
                        beforeSend: function(){
                            $("#profile_pic_form button i").show();
                            $("#profile_pic_form button").prop('disabled', true);
                            sel_btn.children("i").show();
                        },
                        success: function(res){
                            sel_btn.children("i").hide();
                            if(res.Success){
                                window.location.reload();
                            }
                            if(res.Msg){
                                $(".com_not .modal-body p").css("color","green");
                                $(".com_not .modal-body p").text(res.Msg);
                                $(".com_not").slideDown();
                                setTimeout(function(){
                                    $(".com_not").slideUp();
                                },3000);
                                <?php
                                if(!empty($old_img)){ ?>
                                $("#profile_pic").attr('src','<?= $old_img ?>');
                                <?php }else{ ?>
                                $("#profile_pic").attr('src','<?= $default_profile ?>');
                                <?php } ?>

                            }
                            console.log(res)
                        },error: function(e){
                            sel_btn.children("i").hide();
                            resetData();
                            console.log(e)
                        }
                    });
                });
                $("#image_form .btn-primary").click(function(){
                    $("#profile_pic_form")[0].reset();
                    $("#preview_pic").hide();
                    $("#image_form .modal-footer").hide();
                    $(".img_errors").text("");
                });
            }
        });

        $("#validateForm,#updatePassword").submit(function(e) {
            e.preventDefault();
        });

        $("#number").keypress(function (e) {
            if(e.which == 43){
                return true;
            }else if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $( '#validateForm' ).validate( {
            messages: {
                username: {
                    required: '<?= $allLabelsArray[48] ?>',
                },
            },
            submitHandler: function () {
                'use strict';


                $("#number").siblings(".error").remove();
                if($("#first").val() !="" && !/^[a-zA-Z ]*$/.test($("#first").val())) {
                    $("#first").siblings(".error").remove();
                    $("#first").after('<span class="error error-keyup-4"><?= $allLabelsArray[602] ?></span>');
                    return false;
                }else{
                    $("#first").siblings(".error").remove();
                }
                if($("#last").val() != "" && !/^[a-zA-Z ]*$/.test($("#last").val())) {
                    $("#last").siblings(".error").remove();
                    $("#last").after('<span class="error error-keyup-4"><?= $allLabelsArray[603] ?></span>');
                    return false;
                }else{
                    $("#last").siblings(".error").remove();
                }
                var len = $("#number").val().replace("+","");
                len = len.replace(/\s+/g, '').length;
                console.log(len);
                if(len < 1 || $("#number").val() < 1){
                    $("#number").siblings(".error").remove();
                    // $("#number").after('<label for="number" class="error"><?= $allLabelsArray[459] ?></label>');
                    // return false;
                }else if(len < 6) {
                    $("#number").siblings(".error").remove();
                    $("#number").after('<label for="number" class="error"><?= $allLabelsArray[34] ?></label>');
                    return false;
                }else if(len > 16){
                    $("#number").siblings(".error").remove();
                    $("#number").after('<label for="number" class="error"><?= $allLabelsArray[604] ?></label>');
                    return false;
                }
                // else if($("#number").val().include('-')){
                //     $("#number").siblings(".error").remove();
                //     $("#number").after('<label for="number" class="error">Invalid number.</label>');
                //     return false;
                // }
                // else if(/^[0-9]*$/.test($("#number").val())){
                //  $("#number").siblings(".error").remove();
                //     $("#number").after('<span class="error error-keyup-4">Invalid number</span>');
                //     return false;
                // }
                else{
                    $("#number").siblings(".error").remove();
                }


                $( ".profile:first #addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>' );
                $.ajax( {
                    dataType: 'json',
                    url: "<?php echo $cms_url; ?>ajax.php?h=updateProfile&lang=<?= getCurLang($langURL,true) ?>",
                    type: 'POST',
                    data: $("#validateForm").serialize(),
                    success: function ( data ) {
                        console.log(data);
                        if ( data.Success ) {
                            $( ".profile:first #addLoader" ).html( '<?= $allLabelsArray[452] ?>' );
                            $(".profile:first .prompt").html('<div class="alert alert-success"><i class="fa fa-check" style="margin-right: 10px;"></i>'+data.Success+'</div>');
                            setTimeout(function(){
                                $(".prompt").html('');
                            },2000);
                        }
                        else {
                            $( ".profile:first #addLoader" ).html( '<?= $allLabelsArray[452] ?>' );
                            $(".profile:first .prompt").html('<div class="alert alert-warning"><i class="fa fa-warning" style="margin-right: 10px;"></i>'+data.Msg+'</div>');
                        }
                        var body = $("html, body");
                        body.stop().animate({scrollTop:0}, 500, 'swing', function() {
                        });
                    },error: function(e){
                        console.log(e)
                    }
                } );
                return false;
            }
        } );



        $( '#updatePassword' ).validate( {
            // rules: {
            //     password_confirm: "required",
            // },
            messages: {
                old_password:"<?php echo $allLabelsArray[48] ?>",
                password:"<?php echo $allLabelsArray[48] ?>",
                password_confirm:"<?php echo $allLabelsArray[48] ?>"
            },
            invalidHandler: function(event, validator) {
                // 'this' refers to the form

                var errors = validator.numberOfInvalids();
                console.log('er-'+errors)
                if (errors) {

                    setTimeout(function() {
                        $("label.error").each(function() {

                            let target = $(this)
                            let v = target[0].innerHTML
                            v = static_label_changer(v)
                            target[0].innerHTML = v
                        });
                    }, 500)
                }

            },
            submitHandler: function () {
                'use strict';
                let pass=$('#password').val()

                if(pass.length < 4)
                {
                    $('#passError4').prev('label.error').remove()
                    $('#passError4').show()
                    return false;
                }
                else
                {
                    $('#passError4').hide()

                }

                if($("#password").val() != $("#cpassword").val()){
                    $("#passError4").show();
                    $("#passError4 .p_error").text("<?= $allLabelsArray[523] ?>");
                    console.log("<?= $allLabelsArray[523] ?>")
                    return false;
                }else{
                    $("#passError4").hide();
                }

                if($("input[name=old_password]").val() == $("#password").val()){
                    $(".profile:last .prompt").html('<div class="alert alert-danger"><i class="class="fa fa-exclamation-triangle" style="margin-right: 10px;"></i> <?= $allLabelsArray[605] ?></div>');
                    setTimeout(function(){
                        $(".profile:last .prompt").html("");
                    },3000);
                }else{
                    $( ".profile:last #addLoader" ).html( '  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>' );
                    $(".profile:last .prompt").html('');
                    $.ajax( {
                        dataType: 'json',
                        // crossDomain: true,
                        url: "<?= $cms_url ?>ajax.php?h=changePassword&lang=<?= getCurLang($langURL,true) ?>",
                        type: 'POST',
                        // crossDomain:true,
                        // headers: {  'Access-Control-Allow-Origin': 'https://immigration.ourcanada.app' },
                        data: $("#updatePassword").serialize(),
                        success: function ( data ) {
                            console.log(data);
                            if ( data.Success ) {
                                $( ".profile:last #addLoader" ).html( '<?= $allLabelsArray[452] ?>' );
                                $(".profile:last .prompt").html('<div class="alert alert-success"><i class="fa fa-check" style="margin-right: 10px;"></i>'+data.Success+'</div>');
                                setTimeout(function(){
                                    $(".prompt").html('');
                                    $("#updatePassword")[0].reset();
                                },2000);
                            }
                            else {
                                $( ".profile:last #addLoader" ).html( '<?= $allLabelsArray[452] ?>' );
                                $(".profile:last .prompt").html('<div class="alert alert-warning"><i class="fa fa-warning" style="margin-right: 10px;"></i>'+data.Msg+'</div>');
                            }
                        },error: function(e){
                            console.log(e)
                        }
                    } );
                    return false;
                }

            }
        } );


    } );
    $(document).on('keypress', 'input[type="text"]', function(e) {

        var keyCode = e.keyCode || e.which;
        var regex = /^[A-Za-z  '\-]+$/;
        var isValid = regex.test(String.fromCharCode(keyCode));
        return isValid;

        return false;
    })

</script>
</body>
</html>