

<!-- header start -->
<header style="background-color: white;" class="header-tools marketplace">
    <div class="mobile-fix-option"></div>
    <div class="top-header" style="padding-top:5px;padding-bottom:6px;height: 70px">
        <div class="container">
            <div class="row">
                <div class="col-6">
                    <div class="header-contact">
                        <ul>
                            <li data-org="<?php echo $allLabelsEnglishArray[192] ?>" class="static_label"><?php echo $allLabelsArray[192] ?></li>
                        </ul>
                    </div>
                </div>
                <div class="col-6 text-right">
                    <ul class="header-dropdown">

                        <li>
                            <select  name="language-picker-select" id="language-picker-select" class="form-control">

                                <option lang="en" value="english"  selected  data-imagecss="flag it" data-image="<?php echo $main_domain.'/superadmin/uploads/flags/english.jpg'; ?>">English</option>
                                <?php
                                $query = "SELECT * FROM `multi-lingual`  WHERE status = 1 order by language ASC";
                                $mresult = mysqli_query($conn, $query);
                                while($row = mysqli_fetch_assoc($mresult)){
                                    $langPar = $row['lang_slug'];
                                    if($row['lang_slug'] == 'french'){

                                        $row['lang_slug'] = 'francais';
                                    }
                                    $index = array_search(ucfirst($row['language']), $allLabelsEnglishArray);

                                    ?>
                                    <option  data-imagecss="flag it" data-image="<?php echo $main_domain.'/superadmin/uploads/flags/'.$row['flag_image']; ?>"  data-id="<?php echo $row['display_type'] ?>" value="<?php echo $row['lang_slug'] ?>"  <?php if($langPar == $language) echo 'selected'; ?> ><?php echo $row['display_name'] ?></option>
                                <?php } ?>

                            </select>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="main-menu">
                    <div class="menu-left">
                        <div class="brand-logo"> <a href="https://ourcanada<?php echo $ext.$langURL; ?>"><img src="<?php echo $baseURL; ?>assets/img/ourcanada.png"  class="img-fluid blur-up lazyload" alt="" width="0" height="0"></a> </div>
                    </div>
                    <div class="menu-right pull-right">
                        <div>
                            <nav id="main-nav">
                                <div class="toggle-nav"><i class="fa fa-bars sidebar-bar"></i></div>
                                <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                                    <li>
                                        <div class="mobile-back text-right"><span class="static_label" data-org="Back"></span><i class="fa fa-angle-right pl-2" aria-hidden="true"></i></div>
                                    </li>
                                    <li> <a href="https://ourcanada<?php echo $ext.$langURL; ?>" data-org="<?php echo $allLabelsEnglishArray[7] ?>" class="static_label"><?php echo $allLabelsArray[7] ?></a> </li>
                                    <li> <a href="<?php echo $baseURL; ?><?php echo $langURL; ?>" data-org="<?php echo $allLabelsEnglishArray[109] ?>" class="static_label <?php  if($pageSlug == "products") { echo "active_link"; } ?>"><?php echo $allLabelsArray[109] ?></a> </li>
                                    <li> <a href="<?php echo $baseURL; ?>/travel<?php echo $langURL; ?>" data-org="<?php echo $allLabelsEnglishArray[202] ?>" class="static_label <?php  if($pageSlug == "travel") { echo "active_link"; } ?>"><?php echo $allLabelsArray[202] ?></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</header>

<!-- header end -->
<?php
if($checkError)
{
    exit(include '404.php');
}
?>