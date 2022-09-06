<?php

require_once 'user_inc.php';

?>
    <script src="https://www.google.com/recaptcha/api.js?hl=<?php echo $language_code ?>" async defer></script>

    <header class="haeder-absolute">
        <div class="container-fluid container-extra">
            <div class="row">
                <div class="col-12">
                    <nav class="nav align-items-center justify-content-between">
                        <div class="logo">
                            <a href="https://ourcanada<?php echo $ext; ?><?php echo $newLangUrl; ?>" class="static_label" data-org="Canadian Immigra<?php echo $newLangUrl; ?>"><img src="<?php echo $baseURL; ?>/assets/img/logo.png" alt="Cantus"></a>
                        </div>
                        <div class="main-mneu">
                            <ul>
                                <?php
                                if(isset($_SESSION['user_id']))
                                {
                                    ?>
                                    <li><a  href="<?php echo 'https://immigration.ourcanada'.$ext; ?>/form<?php echo $newLangUrl; ?>"   class="static_label" data-org="<?php echo $allLabelsEnglishArray[9] ?>"><?php echo $allLabelsArray[9] ?></a></li>
                                    <?php
                                }
                                else {
                                    ?>
                                    <li><a  href="<?php echo 'https://immigration.ourcanada'.$ext; ?>/form<?php echo $newLangUrl; ?>"  data-toggle="modal" data-target="#exampleModal" class="static_label" data-org="<?php echo $allLabelsEnglishArray[9] ?>"><?php echo $allLabelsArray[9] ?></a></li>
                                <?php } ?>
                                <li><a href="https://ecommerce.ourcanada<?php echo $ext; ?><?php echo $newLangUrl; ?>" target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[109] ?>"><?php echo $allLabelsArray[109] ?></a></li>
                                <li><a href="https://ourcanada<?php echo $ext; ?>/community<?php echo $newLangUrl; ?>" target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[650] ?>"><?php echo $allLabelsArray[650] ?></a></li>


                                <li><a href="<?php echo $baseURL; ?>/about-us<?php echo $newLangUrl; ?>" class="static_label" data-org="<?php echo $allLabelsEnglishArray[8] ?>"><?php echo $allLabelsArray[8] ?></a></li>
                                <li><a href="<?php echo $baseURL; ?>/contact-us<?php echo $newLangUrl; ?>" class="static_label" data-org="<?php echo $allLabelsEnglishArray[10] ?>"><?php echo $allLabelsArray[10] ?></a></li>
                                <?php if(!isset($_SESSION['user_id'])) { ?>
                                    <li><a style="cursor: pointer"  data-toggle="modal" data-target="#loginModal" class="static_label" ><?php echo $allLabelsArray[11] ?></a></li>

                                <?php }
                                else {

                                    $userQueryResult = mysqli_query($conn,"SELECT * FROM `users` WHERE `id` = '{$_SESSION['user_id']}'");
                                    $userRow = mysqli_fetch_assoc($userQueryResult);


                                    ?>
                                    <li><a id="logoutLink" class="static_label" href="<?php echo $baseURL; ?>/logout<?php echo $newLangUrl; ?>" data-org="<?php echo $allLabelsEnglishArray[126] ?>"><?php echo $allLabelsArray[126] ?></a></li>

                                <?php } ?>

                                <?php if(isset($_SESSION['user_id'])){?>
                                    <li><a  data-toggle="modal" data-target="#referAfriend" class="banner-btn static_label" style="cursor: pointer;visibility: visible;-webkit-animation-delay: .5s; -moz-animation-delay: .5s; animation-delay: .5s;" data-org="<?php echo $allLabelsEnglishArray[111] ?>"><?php echo $allLabelsArray[111] ?></a></li>
                                <?php } else {
                                    ?>
                                    <li><a  data-toggle="modal" data-target="#loginModal" class="banner-btn static_label" style="cursor: pointer;visibility: visible;-webkit-animation-delay: .5s; -moz-animation-delay: .5s; animation-delay: .5s;" data-org="<?php echo $allLabelsEnglishArray[111] ?>"><?php echo $allLabelsArray[111] ?></a></li>

                                    <?php
                                }?>
                                <li>
                                    <select  name="language-picker-select" id="language-picker-select" class="form-control">

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
                                </li>
                            </ul>
                        </div>


                    </nav>
                </div>
                <div class="col-12">
                    <div class="mobilemenu"></div>
                </div>
            </div>
        </div>
    </header>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title static_label" id="exampleModalLabel" data-org="<?php echo $allLabelsEnglishArray[176] ?>"><?php echo $allLabelsArray[176] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="static_label" data-org="<?php echo $allLabelsEnglishArray[177] ?>"><?php echo $allLabelsArray[177] ?></span>
                </div>
                <div class="modal-footer">
                    <a href="https://immigration.ourcanada<?php echo $ext; ?>/form<?php echo $newLangUrl; ?>" class="btn btn-secondary static_label" data-org="<?php echo $allLabelsEnglishArray[233] ?>"><?php echo $allLabelsArray[233] ?></a>
                    <a  href="https://immigration.ourcanada<?php echo $ext; ?>/login<?php echo $newLangUrl; ?>" class="btn btn-primary static_label" data-org="<?php echo $allLabelsEnglishArray[11] ?>"><?php echo $allLabelsArray[11] ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content rounded shadow border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle2"><?= $allLabelsArray[11] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="login-form mt-2 login" method="post">
                        <div class="prompt"></div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group position-relative">
                                    <label><?= $allLabelsArray[145] ?> <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" placeholder="<?= $allLabelsArray[145] ?>" required="">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group position-relative">
                                    <label><?= $allLabelsArray[146] ?> <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control" placeholder="<?= $allLabelsArray[146] ?>" required="">
                                </div>
                            </div>


                            <div class="col-lg-12 mb-0">
                                <button class="btn btn-primary btn-block" id="sign_in"><?= $allLabelsArray[242] ?></button>
                            </div>

                            <div class="col-12 text-center">
                                <p class="mb-0 mt-3"><small class="text-dark mr-2"><?= $allLabelsArray[231] ?></small> <a style="cursor: pointer;" class="text-dark font-weight-bold" id="signupBtn"><?= $allLabelsArray[135] ?></a></p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content rounded shadow border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle2"><?= $allLabelsArray[161] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="login-form mt-2 signupForm" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="signup_prompt"></div>
                                <div class="form-group position-relative">
                                    <label><?= $allLabelsArray[145] ?> <span class="text-danger">*</span></label>
                                    <input type="email" name="n[email]" class="form-control" placeholder="<?= $allLabelsArray[145] ?>" required="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group position-relative">
                                    <label><?= $allLabelsArray[146] ?> <span class="text-danger">*</span></label>
                                    <input type="password" name="n[password]" id="pass" class="form-control" placeholder="<?= $allLabelsArray[146] ?>" required="">
                                    <label class="error" id="passError4" style="display: none"><span><i class="fa fa-exclamation-triangle"></i></span> <?= $allLabelsArray[743] ?></label>

                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div data-l="<?php echo $language ?>" class="custom-control custom-checkbox mb-1 specifiedUrduElm">
                                    <input type="checkbox" class="custom-control-input" id="check-terms" onchange="$('#rerror').hide()">
                                    <label class="custom-control-label <?php if($language=="urdu") { echo 'urduCheckBoxAlign'; } ?> " for="check-terms"><span class="static_label" data-org="I agree to the"></span> <a href="<?php echo $baseURL; ?>/terms<?php echo $langURL; ?>"  target="_blank" class="static_label" data-org="<?php echo $allLabelsEnglishArray[243] ?>"><?php echo $allLabelsArray[243] ?></a></label>
                                    <p id="rerror" style="color:darkred;display:none" class="static_label" data-org="<?php echo $allLabelsEnglishArray[163] ?>"><?php echo $allLabelsArray[163] ?></p>

                                </div>

                            </div>

                            <div class="col-lg-12 <?php echo $getLangUrl[1]?>">
                                <div class="my-4">
                                    <!--                                        <div class="g-recaptcha"  data-sitekey="6LfqOnsbAAAAANapmlLeGpwUnZYfVMHEUsbRbRIL" ></div>-->
                                    <div class="g-recaptcha" data-sitekey="6LdnEwYaAAAAAI8r7VuqWnhPtTOCZQmw5OIjA6zY"></div>

                                </div>
                            </div>



                            <div class="col-lg-12 mb-0">
                                <button class="btn btn-primary btn-block" type="button" id="sign_up"><?= $allLabelsArray[135] ?></button>
                            </div>

                            <div class="col-12 text-center">
                                <p class="mb-0 mt-3"><small class="text-dark mr-2"><?= $allLabelsArray[172] ?></small> <a style="cursor: pointer" class="text-dark font-weight-bold loginBtn"><?= $allLabelsArray[242] ?></a></p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="referAfriend" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded shadow border-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle1"><?= $allLabelsArray[436] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2><?= $allLabelsArray[111] ?></h2>
                    <p><?= $allLabelsArray[708] ?></p>
                    <form method="post" id="referFriend">
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-10">
                                <div class="alertRefer"></div>
                                <div class="form-group position-relative">
                                    <label><?= $allLabelsArray[290] ?> <span class="text-danger">*</span></label>

                                    <input name="email" id="referEmail" type="email" class="form-control" placeholder="<?= $allLabelsArray[145] ?>" required>
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary" id="referProcess"><?= $allLabelsArray[709] ?> </button>
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
                    <h5 class="modal-title static_label" id="continueLoginModalLabel" data-org="<?php echo $allLabelsEnglishArray[246] ?>"><?php echo $allLabelsArray[264] ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div style="width: 100%;" id="continueAlert">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary static_label" data-dismiss="modal" data-org="<?php echo $allLabelsEnglishArray[103] ?>"><?php echo $allLabelsArray[103] ?></button>
                    <button type="button" id="continueLoginbtn" class="btn btn-success static_label" data-org="<?php echo $allLabelsEnglishArray[28] ?>"><?php echo $allLabelsArray[28] ?></button>
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