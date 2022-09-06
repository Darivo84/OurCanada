<?php
require_once 'cms_error.php';

echo "string";
exit();
include_once( $basePath."admin_inc.php" );
$page = 'inner';



$request = explode("/", $_SERVER['REQUEST_URI']);

$news_slug = $request[2];

$news_select = mysqli_query($conn, "SELECT * FROM `news` WHERE slug='$news_slug'");

$row = mysqli_fetch_assoc($news_select);

?>

<!DOCTYPE html>



<html lang="en-US">



    <!-- Mirrored from jellywp.com/disto-preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2020 07:26:51 GMT -->

    <head>

        <meta charset="UTF-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="author" content="">

        <meta name="description" content="">

        <meta name="keywords" content="">

        <!-- Title-->

        <title>Edit News</title>

        <?php

        $cmsBaseURL = $_SERVER['SERVER_NAME'];

        ?>

        <!-- Favicon-->

        <?php include($basePath."includes/style.php"); ?>

        <link href=<?php echo $basePath ?>"assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo $basePath ?>assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />



        <!-- end head -->

        <style>

            .box-setup{

                border: 1px dotted silver;

                padding: 10px;

                position: relative;

            }

            .cross-button{

                position: absolute;

                display: inline-block;

                top: -10px;

                right: -7px;

                border-radius: 35%;

                overflow: hidden;

            }

        </style>

    </head>



    <body class="mobile_nav_class jl-has-sidebar">

        <div class="options_layout_wrapper jl_radius jl_none_box_styles jl_border_radiuss">

            <div class="options_layout_container full_layout_enable_front"> 

                <!-- Start header -->

<?php include($basePath."includes/header.php"); ?>

                <!-- end header -->

                <div class="jl_home_section">

                    <div class="container">

                        <div class="row login-form">

                            <div class="col-md-3 col-lg-3 col-xl-4"></div>

                            <div class="col-12">

                                <form method="post" id="edit_news_form" enctype="multipart/form-data">

                                    <div class="panel">

                                        <div class="panel-heading">

                                            <div class="prompt"></div>

                                            <div class="panel-title">

                                                <h2 class="text-center">Edit News</h2>

                                            </div>

                                        </div>

                                        <!-- panel-header -->

                                        <div class="panel-body">

                                            <div class="form-group col-md-6">

                                                <label for="title">News Title</label>

                                                <input type="text" name="title" id="title" placeholder="Enter news title" minlength="15" maxlength="100" placeholder="Enter news title" required class="form-control" value="<?php echo $row["title"]; ?>">

                                                <input type="hidden" name="slug" id="slug" value="<?php echo $row["slug"]; ?>">

                                                <input type="hidden" name="id" id="id" value="<?php echo $row["id"]; ?>">

                                            </div>

                                            <div class="form-group col-md-6">

                                                <label for="type">News Type</label>



                                                <select id="type" name="type" type="text" class="form-control" placeholder="News Type" value="<?php echo $row["type"]; ?>"required onchange="change_dropzone(this.value);" title="Please Select one option">

                                                    <option label="Select type"></option>

                                                    <option value="simplenews"<?= $row['type'] == 'simplenews' ? ' selected="selected"' : ''; ?>>Simple News</option>

                                                    <option value="image-slider-news"<?= $row['type'] == 'image-slider-news' ? ' selected="selected"' : ''; ?>>News With Image Slider</option>

                                                    <option value="video-news"<?= $row['type'] == 'video-news' ? ' selected="selected"' : ''; ?>>News With Video</option>

                                                    <option value="video-image-news"<?= $row['type'] == 'video-image-news' ? ' selected="selected"' : ''; ?>>News With Video/Image</option>

                                                </select>



                                            </div>

                                            <!-- form-group -->

                                            <div class="form-group col-md-12">

                                                <label for="password">News Description</label>

                                                <textarea name="description" id="description" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news description" class="form-control" rows="3"><?php echo $row["description"]; ?></textarea>

                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">

                                                <label for="password">News Content 2</label>

                                                <textarea name="content_two" id="content_two" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news content 2" class="form-control" rows="3" ><?php echo $row["content_two"]; ?></textarea>

                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">

                                                <label for="password">News Quote</label>

                                                <textarea name="quote" id="quote" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news quote" class="form-control" rows="3"><?php echo $row["quote"]; ?></textarea>

                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">

                                                <label for="password">News Content 3</label>

                                                <textarea name="content_three" id="content_three" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news content 3" class="form-control" rows="3"><?php echo $row["content_three"]; ?></textarea>

                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">

                                                <label for="password">News Content 4</label>

                                                <textarea name="content_four" id="content_four" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news content 4" class="form-control" rows="3"><?php echo $row["content_four"]; ?></textarea>

                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">

                                                <label for="password">News Content 5</label>

                                                <textarea name="content_five" id="content_five" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news content 5" class="form-control" rows="3"><?php echo $row["content_five"]; ?></textarea>

                                            </div>

                                            <div class="form-group col-lg-6 col-sm-12">

                                                <label for="password">News Content 6</label>

                                                <textarea name="content_six" id="content_six" title="Only Letters, Numbers & Whitespaces" placeholder="Enter news content 6" class="form-control" rows="3"><?php echo $row["content_six"]; ?></textarea>

                                            </div>

<?php if ($row['images'] != "") { ?>

                                                <label class="col-form-label col-lg-2 to_be_hidden">Editable Files</label>

                                                <div class="form-group row mb-4 to_be_hidden">



                                                    <div class="col-lg-10 main-div">

                                                        <div class="col-lg-12" style="">

                                                            <div class="row">

    <?php

    $imageNames = explode(",", $row['images']);

    $count = 0;

    while ($count != (sizeof($imageNames) - 1)) {

        ?>

                                                                    <div class='col-sm-3'><div style='float: left; margin-bottom: 20px; text-align: center; display: inline-block; width: 100%; height: 150px;' class='box-setup'><span>



        <!--<i class="fa fa-3x fa-image"></i>-->



                                                                            </span><span class='cross-button'><a href="javascript:void(0);" onclick='delete_files("<?php echo $row['id'] ?>", "<?php echo $imageNames[$count] ?>");'>



                                                                                    <i class="fa fa-2x fa-times text-danger"></i></a>



                                                                            </span>

                                                                            <img style="width:100%;height:100%;" src=<?php echo $img_url ?>"uploads/images/<?php echo $imageNames[$count]; ?>">

                                                                           <!--<p><?php echo $imageNames[$count]; ?></p>-->



                                                                        </div></div>

                                                                    <?php

                                                                    $count++;

                                                                }

                                                                $videoNames = explode(",", $row['videos']);

                                                                $count = 0;

                                                                while ($count != (sizeof($videoNames) - 1)) {

                                                                    ?>

                                                                    <div class='col-sm-3'><div style='float: left; margin-bottom: 20px; text-align: center; display: inline-block; width: 100%; height: 150px;' class='box-setup'><span>

                                                                        <!--<i class="fa fa-3x fa-video-camera"></i>-->



                                                                            </span><span class='cross-button'><a href="javascript:void(0);" onclick='delete_files("<?php echo $row['id'] ?>", "<?php echo $videoNames[$count] ?>");'><i class="fa fa-2x fa-times text-danger"></i></a></span>



                                                                            <video loop   style="width:100%;height:100%; object-fit: cover;" muted autoplay>

                                                                                <?php

                                                                                $fileTypee = pathinfo($videoNames[$count], PATHINFO_EXTENSION);

                                                                                ?>           

                                                                                <source src=<?php echo $img_url ?>"uploads/videos/<?php echo ($videoNames[$count]); ?>" type="video/<?php echo $fileTypee; ?>">



                                                                                Your browser does not support HTML video.

                                                                            </video>    





        <!--<p><?php echo $videoNames[$count]; ?></p>-->



                                                                        </div></div>

                                                                    <?php

                                                                    $count++;

                                                                }

                                                                ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div> 

                                            <?php } ?>









                                            <div class="col-lg-12 to_be_hidden">

                                                <button class="btn btn-primary" type="button" id="opengal">Open Gallery</button>

                                            </div>

                                            <!-- Gallery Modal -->

                                            <div id="galleryModal" class="modal fade">

                                                <div class="modal-dialog modal-lg" role="document">

                                                    <div class="modal-content">

                                                        <div class="modal-header">

                                                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Select Images</h6>

                                                        </div>

                                                        <div class="modal-body">



                                                            <style>



                                                                .mycard-footer {



                                                                    height: 25px;



                                                                    background: #333333;



                                                                    font-size: 15px;



                                                                    text-indent: 10px;



                                                                    /* border-radius: 0 0px 4px 4px;*/



                                                                }







                                                                .gallery-card {



                                                                    position: relative;



                                                                    display: -webkit-box;



                                                                    display: -ms-flexbox;



                                                                    display: flex;



                                                                    -webkit-box-orient: vertical;



                                                                    -webkit-box-direction: normal;



                                                                    -ms-flex-direction: column;



                                                                    flex-direction: column;



                                                                    min-width: 0;



                                                                    word-wrap: break-word;



                                                                    background-color: #fff;



                                                                    background-clip: border-box;



                                                                    border: 1px solid rgba(0,0,0,.125);



                                                                    border-radius: .25rem;



                                                                    width:100%;



                                                                    margin-bottom:14px;



                                                                }



                                                                .gallery-card-body {



                                                                    -webkit-box-flex: 1;



                                                                    -ms-flex: 1 1 auto;



                                                                    flex: 1 1 auto;



                                                                    /*padding: 1.25rem;*/



                                                                }



                                                                .gallery-card img {



                                                                    height: 100px;



                                                                    width: 100%;



                                                                }



                                                                label{



                                                                    margin-bottom: 0 !important;



                                                                }



                                                                /*--checkbox--*/







                                                                .block-check {



                                                                    display: block;



                                                                    position: relative;



                                                                    height:100%;







                                                                    cursor: pointer;



                                                                    font-size: 22px;



                                                                    -webkit-user-select: none;



                                                                    -moz-user-select: none;



                                                                    -ms-user-select: none;



                                                                    user-select: none;



                                                                }







                                                                /* Hide the browser's default checkbox */



                                                                .block-check input {



                                                                    position: absolute;



                                                                    opacity: 0;



                                                                    cursor: pointer;



                                                                }







                                                                /* Create a custom checkbox */



                                                                .checkmark {



                                                                    position: absolute;



                                                                    top: 0;



                                                                    left: 0;



                                                                    height: 25px;



                                                                    width: 25px;



                                                                    background-color: #eee;



                                                                    cursor: pointer;



                                                                }







                                                                /* On mouse-over, add a grey background color */



                                                                .block-check:hover input ~ .checkmark {



                                                                    background-color: #ccc;



                                                                }







                                                                /* When the checkbox is checked, add a blue background */



                                                                .block-check input:checked ~ .checkmark {



                                                                    background-color: #2196F3;



                                                                }







                                                                /* Create the checkmark/indicator (hidden when not checked) */



                                                                .checkmark:after {



                                                                    content: "";



                                                                    position: absolute;



                                                                    display: none;



                                                                }







                                                                /* Show the checkmark when checked */



                                                                .block-check input:checked ~ .checkmark:after {



                                                                    display: block;



                                                                }







                                                                /* Style the checkmark/indicator */



                                                                .block-check .checkmark:after {



                                                                    left: 9px;



                                                                    top: 5px;



                                                                    width: 5px;



                                                                    height: 10px;



                                                                    border: solid white;



                                                                    border-width: 0 3px 3px 0;



                                                                    -webkit-transform: rotate(45deg);



                                                                    -ms-transform: rotate(45deg);



                                                                    transform: rotate(45deg);



                                                                }











                                                                /*--checkbox css end--*/



                                                            </style>     







                                                            <div class="container-fluid">



                                                                <div class="row inner-scroll" >







                                                                    <?php

                                                                    $dirname = getcwd();







                                                                    $splDirectoryIterator = new RecursiveDirectoryIterator("uploads/gallery");







                                                                    $splIterator = new RecursiveIteratorIterator(

                                                                            $splDirectoryIterator, RecursiveIteratorIterator::SELF_FIRST

                                                                    );



                                                                    $fileIndex = 0;

                                                                    $allowTypesIMG = array('jpg', 'png', 'PNG', 'JPG', 'jpeg', 'gif', 'jpe', 'bmp', 'ico', 'svg', 'svgz', 'tif', 'tiff', 'ai', 'drw', 'pct', 'psp', 'xcf', 'psd', 'raw', 'webp');

                                                                    $allowTypesVID = array('ogm', 'wmv', 'mpg', 'webm', 'ogv', 'mov', 'asx', 'mpeg', 'mp4', 'm4v', 'avi');

                                                                    foreach ($splIterator as $path => $splFileInfo) {



                                                                        if ($splFileInfo->isDir())

                                                                            continue;







                                                                        // do what you have to do with your files







                                                                        if ($fileIndex > 17) {



                                                                            break;

                                                                        }





                                                                        $filebasename = $splFileInfo->getFilename();

                                                                        $fileType = pathinfo($filebasename, PATHINFO_EXTENSION);

                                                                        $fileTypeStr = "vid";

                                                                        if (in_array($fileType, $allowTypesIMG) || in_array($fileType, $allowTypesVID)) {

                                                                            $fileclasscol = "";

                                                                            $fileclasscheck = "";



                                                                            if (in_array($fileType, $allowTypesIMG)) {

                                                                                $fileTypeStr = "img";

                                                                                $fileclasscol = "imagefilecol";

                                                                                $fileclasscheck = "filecheck";

                                                                            } else {

                                                                                $fileclasscol = "videofilecol";

                                                                                $fileclasscheck = "filecheck";

                                                                            }

                                                                            ?>



                                                                            <div class=" <?php if ($fileTypeStr == "vid") {

                                                                        echo "col-md-3 ";

                                                                    } else {

                                                                        echo "col-md-2 ";

                                                                    } echo $fileclasscol; ?> ">



                                                                                <div class="gallery-card" style="height: 120px;">



                                                                                    <div class="gallery-card-body">



                                                                                        <label class="block-check">



                                                                            <?php

                                                                            if ($fileTypeStr == "img") {

                                                                                ?>

                                                                                                <img style="height:100%;" src="/uploads/gallery/<?php echo ($splFileInfo->getFilename()); ?>" class="img-responsive" />



        <?php } else {

            ?>

                                                                                                <video loop   style="width:100%; object-fit: cover;" muted autoplay>

                                                                                                    <source src="/uploads/gallery/<?php echo ($splFileInfo->getFilename()); ?>" type="video/<?php echo $fileType; ?>">



                                                                                                    Your browser does not support HTML video.

                                                                                                </video>

            <?php }

        ?>



                                                                                            <input class="gallcheckbox"   type="checkbox" value="<?php echo ($splFileInfo->getFilename()); ?>" name="galleryimgschecks[]" >



                                                                                            <span class="checkmark"></span>



                                                                                        </label>





                                                                                    </div>



                                                                                </div>



                                                                            </div>



                                                                                            <?php

                                                                                            $fileIndex++;

                                                                                        }



                                                                                        //example: get filename

                                                                                    }

                                                                                    ?>











                                                                </div>







                                                            </div>

                                                        </div>

                                                        <!-- MODAL-BODY -->

                                                        <div class="modal-footer">



                                                            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>



                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- MODAL-DIALOG --> 

                                            </div>







                                            <div class="form-group to_be_hidden">

                                                <label class="col-form-label col-lg-2">Images/Videos</label><br>

                                                <div class="col-lg-12">

                                                    <div class="dropzone" id="div1"></div>

                                                </div>

                                            </div>

                                            <!-- form-group -->

                                            <div class="col-lg-4">

                                            </div>

                                            <div class="col-lg-4 mt-15">

                                                <button type="submit" id="edit_news_btn" class="btn btn-login btn-block mt-15">Update</button></div>

                                            <div class="col-lg-4">

                                            </div>

                                        </div>

                                        <!-- panel-body --> 

                                    </div>

                                    <!-- panel -->

                                </form>

                                <!-- form --> 

                            </div>

                            <!-- col -->

                            <div class="col-md-3 col-lg-3 col-xl-4"></div>

                        </div>

                        <!-- row --> 

                    </div>

                    <!-- container --> 

                    <!-- end content --> 

                    <!-- Start footer -->



<?php include($basePath."includes/footer.php"); ?>

                    <!-- End footer --> 

                </div>

            </div>

            <div id="go-top"><a href="#go-top"><i class="fa fa-angle-up"></i></a> </div>

            <div class="modal fade" id="del_files_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">

                <div class="modal-dialog" role="document">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title" id="exampleModalLongTitle">Delete File</h5>

                        </div>

                        <div class="modal-body"> Are you sure, you wan't to delete this file ?

                            <input id="user_id" type="hidden">

                            <input id="filename" type="hidden">

                        </div>

                        <div class="modal-footer"> <a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a> <a type="button" class="btn btn-success" style="color: white;" id="del_file">Yes</a> </div>

                    </div>

                </div>

            </div>

<?php include($basePath."includes/script.php"); ?>

            <script>

                $(document).ready(function () {

                    $("#title").change(function () {

                        var link = $("#title").val();

                        link = link.toLowerCase();

                        link = link.replace(/[^a-zA-Z0-9\s+]/g, '');

                        var final = link.replace(/\s+/g, '-')

                        $("#newslug").val(final);

                    });



                });

            </script>

            <script src=<?php echo $basePath ?>"assets/libs/dropzone/min/dropzone.js"></script>



            <script>



                           var imgDropzone;

                           var addnews_formData = new FormData();

                           var imgfileallowed = new Array('jpg', 'jpeg', 'JPEG', 'png', 'PNG', 'JPG', 'jpeg', 'ICO', 'ico');

                           var videofileallowed = new Array('mp4', 'ogg', 'webm');



                           var dzimgallowed = ".jpeg,.png,.jpg";

                           var dzvidallowed = ".mp4,.ogg,.webm";



                           Dropzone.autoDiscover = false;

                           change_dropzone($("#type").val());

                           function mydropzonefunc(dz_acceptedFiles)

                           {

                               imgDropzone = new Dropzone("#div1", {

                                   addRemoveLinks: true,

                                   autoProcessQueue: false,

                                   timeout: 1000000, /*milliseconds*/

                                   parallelUploads: 50,

                                   acceptedFiles: dz_acceptedFiles,

                                   maxFilesize: 100,

                                   uploadMultiple: true,

                                   url: 'ajax.php?h=add_news',

                                   init: function () {

                                       var myDropzone = this;



                                       this.on('addedfile', function (file, xhr, formData) {

                                           fileName = (file.name);

                                           fileextention = (fileName.split('.').pop());

                                           ext = fileextention.toLowerCase();



                                           if (dz_acceptedFiles.indexOf(ext) > -1)

                                           {

                                               addnews_formData.append("file[]", file);

                                           }

                                       });

                                       this.on('removedfile', function (file, xhr, formData)

                                       {



                                           var tmformdata = addnews_formData;

                                           addnews_formData = new FormData();

                                           for (var pair of tmformdata.entries()) {

                                               // console.log(pair[0]+ ', ' + pair[1].name); 

                                               if (pair[1].name != file.name)

                                               {

                                                   addnews_formData.append("file[]", pair[1])

                                               }

                                           }



                                       });

                                       this.on('complete', function (file) {



                                       });

                                   }

                               });

                           }

                           function change_dropzone(val) {

                               var type = val;

                               addnews_formData = new FormData();



                               $(".filecheck").prop("checked", false);

                               $(".filecheck").attr("checked", false);



                               if (imgDropzone === undefined)

                               {

                               } else

                               {

                                   imgDropzone.destroy();

                               }

                               //  

                               $("#div1").empty();

                               if (type == 'simplenews' || type == "") {

                                   $('.to_be_hidden').hide();







                                   $('.gallcheckbox').attr('checked', false);



                                   $('.gallcheckbox').prop('checked', false);







                               } else {





                                   if (type == "image-slider-news")

                                   {





                                       mydropzonefunc(dzimgallowed);

                                       $(".videofilecol").hide();

                                       $(".imagefilecol").show();

                                   } else if (type == "video-news")

                                   {

                                       mydropzonefunc(dzvidallowed);

                                       $(".videofilecol").show();

                                       $(".imagefilecol").hide();

                                   } else

                                   {

                                       mydropzonefunc(dzvidallowed + "," + dzimgallowed);

                                       $(".videofilecol").show();

                                       $(".imagefilecol").show();

                                   }

                                   $('.to_be_hidden').show();

                               }

                           }









                           $(".form-control").change(function () {



                               $(this).css("border", "1px solid #ccc");



                           });



                           $("#edit_news_btn").click(function (e) {

                               e.preventDefault();

                               var type = $('#type').val();

                               var title = $('#title').val();

                               var desc = $('#description').val();

                               var c2 = $('#content_two').val();

                               var c3 = $('#content_three').val();

                               var c4 = $('#content_four').val();

                               var c5 = $('#content_five').val();

                               var c6 = $('#content_six').val();

                               var quote = $('#quote').val();

                               var error = false;



                               if (!((title.match(/^[^*|\":<>[\]{}`\\\-()';@&$]+$/))))

                    {

                        error = true;

                        $('#title').css("border", "1px solid #ff4200");

                        $("#text_error").show();

                    } else

                    {

                        $("#text_error").hide();

                        $('#title').css("border", "1px solid #ccc");

                    }

                    if (!(desc.match(/^[^<>]+$/))) {

                        error = true;

                        $("#news_description_error").show();

                        $('#description').css("border", "1px solid #ff4200");

                    } else

                    {

                        $("#news_description_error").hide();

                        $('#description').css("border", "1px solid #ccc");

                    }

                    if (!(c2.match(/^[^<>]+$/)))

                    {

                        error = true;

                        $("#content_2_error").show();

                        $('#content_two').css("border", "1px solid #ff4200");

                    } else

                    {

                        $('#content_two').css("border", "1px solid #ccc");

                        $("#content_2_error").hide();

                    }

                    if (!(c3.match(/^[^<>]+$/)) && c3 != "")

                    {

                        error = true;

                        $('#content_three').css("border", "1px solid #ff4200");

                        $("#content_3_error").show();

                    } else

                    {

                        $('#content_three').css("border", "1px solid #ccc");

                        $("#content_3_error").hide();

                    }

                    if (!(c4.match(/^[^<>]+$/)) && c4 != "")

                    {

                        error = true;

                        $('#content_four').css("border", "1px solid #ff4200");

                        $("#content_4_error").show();

                    } else

                    {

                        $('#content_four').css("border", "1px solid #ccc");

                        $("#content_4_error").hide();

                    }

                    if (!(c5.match(/^[^<>]+$/)) && c5!= "")

                    {

                        error = true;

                        $('#content_five').css("border", "1px solid #ff4200");

                        $("#content_5_error").show();

                    } else

                    {

                        $('#content_five').css("border", "1px solid #ccc");

                        $("#content_5_error").hide();

                    }

                    if (!(c6.match(/^[^<>]+$/)) && c6 != "")

                    {

                        error = true;

                        $('#content_six').css("border", "1px solid #ff4200");

                        $("#content_6_error").show();

                    } else

                    {

                        $('#content_six').css("border", "1px solid #ccc");

                        $("#content_6_error").hide();

                    }

                    if (!(quote.match(/^[^<>]+$/)))

                    {

                        error = true;

                        $('#quote').css("border", "1px solid #ff4200");

                        $("#quote_error").show();

                    } else

                    {

                        $('#quote').css("border", "1px solid #ccc");

                        $("#quote_error").hide();

                    }

                    if (type == "")

                    {

                        error = true;

                        $("#type_error").show();

                        $('#type').css("border", "1px solid #ff4200");

                    } else

                    {

                        $("#type_error").hide();

                        $('#type').css("border", "1px solid #ccc");

                    }


                               if (error)

                               {

                                   $('html, body').animate({scrollTop: 0}, 'slow');

                                   $("div.prompt").html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some fields missing</div>');

                               } else

                               {

                                   if ($('input.gallcheckbox:checked').length > 0)

                                   {

                                       $("input.gallcheckbox:checked").each(function () {

                                           addnews_formData.append("galleryimgschecks[]", $(this).val());

                                       });

                                   }





                                   addnews_formData.append("type", $('#type').val());

                                   addnews_formData.append("id", $('#id').val());

                                   addnews_formData.append("title", $('#title').val());

                                   addnews_formData.append("description", $('#description').val());

                                   addnews_formData.append("content_two", $('#content_two').val());

                                   addnews_formData.append("content_three", $('#content_three').val());

                                   addnews_formData.append("content_four", $('#content_four').val());

                                   addnews_formData.append("content_five", $('#content_five').val());

                                   addnews_formData.append("content_six", $('#content_six').val());

                                   addnews_formData.append("quote", $('#quote').val());

                                   addnews_formData.append("slug", $('#slug').val());

                                   $("div.prompt").empty();

                                   $.ajax({

                                       type: "POST",

                                       dataType: 'json',

                                       url: "../ajax.php?h=edit_news",

                                       data: addnews_formData,

                                       processData: false,

                                       contentType: false,

                                       success: function (data) {

                                           if (data.Success == 'true') {

                                               $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');

                                               setTimeout(function () {

                                                   window.location = "../my-news";

                                               }, 500);

                                           } else {

                                               $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-times></i>"' + data.Msg + '</div>');

                                           }

                                       }

                                   });

                               }

                           });



            </script>









            <script>

                function delete_files(id, filename) {

                    $('#del_files_modal').modal()

                    $('#user_id').val(id)

                    $('#filename').val(filename)

                }



                $(document).ready(function() {







                //   Gallery coding

                $("#opengal").click(function(){

                $('#galleryModal').modal('show');

                });

                        var cw = $('.box-setup').width();

                        $('.box-setup').css({'height':cw + 'px'});

                        $(window).resize(function() {



                var ccw = $('.box-setup').width();

                        $('.box-setup').css({'height':ccw + 'px'});

                        var ggw = $('.gallery-card').width();

                        $('.gallery-card').css({'height':ggw + 'px'});

                });

                        var type = $('#type').val();

                        if (type == 'simplenews'){

                $('.to_be_hidden').hide();

                } else{

                $('.to_be_hidden').show();

                }



                $('#del_file').click(function () {

                $("#del_file").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');

                        $.ajax({

                        dataType: 'json',

                                url: "../ajax.php?h=del_file",

                                type: 'POST',

                                data: {'id':$("#user_id").val(), 'filename':$("#filename").val()},

                                success: function (data) {

                                $(".closee").click()

                                        if (data.Success === 'true') {

                                $(window).scrollTop(0);

                                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');

                                        setTimeout(function () {

                                        window.location.reload()

                                        }, 1000);

                                } else {

                                $(window).scrollTop(0);

                                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>');

                                        setTimeout(function () {

                                        $("div.prompt").hide();

                                        }, 1000);

                                }

                                }

                        });

                });





});





            </script>

    </body>



    <!-- Mirrored from jellywp.com/disto-preview/ by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 17 Aug 2020 07:28:44 GMT -->

</html>

