<?php

include_once( "admin_inc.php" );

?>



<!doctype html>



<html lang="en">



    <head>



        <meta charset="utf-8" />



        <?php include_once("includes/style.php"); ?>



        <link href="assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />



        <script src="assets/libs/dropzone/min/dropzone.js"></script>



        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



    </head>



    <body data-sidebar="dark">



        <div id="layout-wrapper">



            <?php include_once("includes/header.php"); ?>



            <div class="main-content">



                <div class="page-content">



                    <div class="container-fluid"> 



                        <div class="row">



                            <div class="col-12">



                                <div class="page-title-box d-flex align-items-center justify-content-between">



                                    <h4 class="mb-0 font-size-18">Make New Blog Post</h4>



                                    <div class="page-title-right">



                                        <ol class="breadcrumb m-0">



                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Content Uploading</a></li>



                                            <li class="breadcrumb-item active">Upload Form</li>



                                        </ol>



                                    </div>



                                </div>



                            </div>



                        </div>



                        <div class="row">



                            <div class="col-lg-4 mx-auto"></div>



                        </div>



                        <div class="row">



                            <div class="col-lg-12">



                                <div class="card">



                                    <div class="card-body">



                                        <h4 class="card-title mb-4">Create New Blog</h4>



                                        <form method="POST" id="addBlog" enctype="multipart/form-data">



                                            <div class="prompt"></div>



                                            <div class="form-group row mb-4">



                                                <label for="title" class="col-form-label col-lg-2">Title</label>



                                                <div class="col-lg-10">



                                                    <input id="title" name="title" type="text" class="form-control" placeholder="Blog Title">



                                                    <span class="news_error_span" id="text_error">Enter title in valid format</span>





                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categoryname" class="col-form-label col-lg-2">Sub Title</label>



                                                <div class="col-lg-10">



                                                    <input id="subtitle" name="sub_title" type="text" class="form-control" placeholder="Blog Sub-Title">





                                                    <span class="news_error_span" id="sub_text_error">Enter title in valid format</span>





                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="type" class="col-form-label col-lg-2">Blog Type</label>



                                                <div class="col-lg-10">



                                                    <select id="type" name="type" type="text" class="form-control" placeholder="Blog Type" onchange="alter_dropzone(this.value);">



                                                        <option label="Select type"></option>



                                                        <option value="simpleblog">Simple Blog</option>



                                                        <option value="image-slider-blog">Blog With Image Slider</option>



                                                        <option value="video-blog">Blog With Video</option>



                                                        <option value="video-image-blog">Blog With Video/Image</option>



                                                    </select>

                                                    <span class="news_error_span" id="type_error">Blog type is required</span>



                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categoryname" class="col-form-label col-lg-2">Slug</label>



                                                <div class="col-lg-10">



                                                    <input id="slug" name="slug" type="text" class="form-control" placeholder="Blog Slug" readonly>



                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categorydesc" class="col-form-label col-lg-2">Content</label>



                                                <div class="col-lg-10 ">



                                                    <textarea class="form-control" id="content" name="content" rows="3" placeholder="Blog Content"></textarea>



                                                    <span class="news_error_span" id="content_error">Enter Content in valid format</span>









                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categorydesc" class="col-form-label col-lg-2">Block Quote</label>



                                                <div class="col-lg-10 ">



                                                    <textarea class="form-control" id="quote" name="blockquote" rows="3" placeholder="Blog Quote"></textarea>



                                                    <span class="news_error_span" id="quote_error">Enter Quote in valid format</span>







                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categorydesc" class="col-form-label col-lg-2">Content Two</label>



                                                <div class="col-lg-10 ">



                                                    <textarea class="form-control" id="content2" name="content_two" rows="3" placeholder="Blog Content Two"></textarea>

                                                    <span class="news_error_span" id="content_2_error">Enter Content in valid format</span>

                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categorydesc" class="col-form-label col-lg-2">Content Three</label>



                                                <div class="col-lg-10 ">



                                                    <textarea class="form-control" id="content3" name="content_three" rows="3" placeholder="Blog Content Three"></textarea>



                                                    <span class="news_error_span" id="content_3_error">Enter Content in valid format</span>

                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categorydesc" class="col-form-label col-lg-2">Content Four</label>



                                                <div class="col-lg-10 ">



                                                    <textarea class="form-control" id="content4" name="content_four" rows="3" placeholder="Blog Content Four"></textarea>



                                                    <span class="news_error_span" id="content_4_error">Enter Content in valid format</span>







                                                </div>



                                            </div>



                                            <div class="form-group row mb-4 to_be_hidden">



                                                <label for="Categorydesc" class="col-form-label col-lg-4">Video URL (CSV format)<br><br> <span style="float: left; margin-right: 50px;"><input type="radio" name="rd" id="url" autocomplete="off"> URL  &nbsp; &nbsp;  <input type="radio" name="rd" id="local" autocomplete="off"> Local </span>

                                                    &nbsp; &nbsp;  



                                                </label>



                                                <div class="col-lg-8" id="dummy">



                                                </div>



                                            </div>











                                            <!--Selecting From Gallery -->







                                            <div class="form-group row mb-4 to_be_hidden">
<div class="col-lg-12">
    <button id ="gal" type="button" class="btn btn-primary">Open Gallery</button>
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



                                                                                <div class=" <?php

                                                                                if ($fileTypeStr == "vid") {

                                                                                    echo "col-md-3 ";

                                                                                } else {

                                                                                    echo "col-md-2 ";

                                                                                } echo $fileclasscol;

                                                                                ?> ">



                                                                                    <div class="gallery-card" style="height: 120px;"> 



                                                                                        <div class="gallery-card-body">



                                                                                            <label class="block-check">

                                                                                                <?php

                                                                                                if ($fileTypeStr == "img") {

                                                                                                    ?>

                                                                                                    <img style="height:100%;" src="uploads/gallery/<?php echo ($splFileInfo->getFilename()); ?>" class="img-responsive" />



        <?php } else {

            ?>

                                                                                                    <video loop   style="width:100%; object-fit: cover;" muted autoplay>

                                                                                                        <source src="uploads/gallery/<?php echo ($splFileInfo->getFilename()); ?>" type="video/<?php echo $fileType; ?>">



                                                                                                        Your browser does not support HTML video.

                                                                                                    </video>

        <?php }

        ?>



                                                                                                <input class="gallcheckbox <?php echo $fileclasscheck; ?> "   type="checkbox" value="<?php echo ($splFileInfo->getFilename()); ?>" name="galleryimgschecks[]" >



                                                                                                <span class="checkmark"></span>



                                                                                            </label>





                                                                                        </div>



                                                                                    </div>



                                                                                </div>



                                                                                <?php

                                                                                $fileIndex++;

                                                                            }

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







                                            </div>



                                            <!--End Selecting From Gallery -->







                                            <div class="form-group row mb-4 to_be_hidden">



                                                <label class="col-form-label col-lg-2">Images / Videos</label>



                                                <div class="col-lg-10">



                                                    <div class="dropzone" id="div1"></div>



                                                </div>





                                                <div class="col-lg-12">



                                                    <span class="news_error_span mediaerrors" id="image_error">Select At least one image</span>











                                                    <span class="news_error_span mediaerrors" id="video_error">Select At least one video</span>







                                                    <span class="news_error_span mediaerrors" id="image_video_error">Select At least one image or video</span>







                                                </div>



                                            </div>



                                            <div class="form-group row mb-4">



                                                <label for="Categorydesc" class="col-form-label col-lg-2">Category</label>



                                                <div class="col-lg-10">



                                                    <select class="form-control mult2" name="category[]" id="sel_category" multiple="multiple">


                                                        <?php 
                                                            $query = "SELECT * FROM `category_blog` ORDER BY id DESC";
                                                            $result = mysqli_query($conn, $query);
                                                            while($row = mysqli_fetch_assoc($result)){
                                                        ?>
                                                        <option value="<?= $row['title'] ?>"><?= $row['title'] ?></option>
                                                        <?php } ?>


                                                    </select>

                                                    <span class="news_error_span" id="cat_error">Blog type is required</span>

                                                </div>



                                            </div>



                                            <div class="row justify-content-end">



                                                <div class="col-lg-10">



                                                    <button id="addLoader" type="submit" class="btn btn-primary">Upload Blog</button>



                                                </div>



                                            </div>



                                        </form>



                                    </div>



                                </div>



                            </div>



                        </div>



                    </div>



                </div>



<?php include_once("includes/footer.php"); ?>



            </div>



        </div>



        <div class="rightbar-overlay"></div>







<?php include_once("includes/script.php"); ?><br>







        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>



        <script>



                                                        $(document).ready(function () {



                                                            $("#title").change(
                                                                
                                                                
                                                            function(){
                                                                
                                                                makeslug();
                                                                
                                                            }
                                                            );

function makeslug() {



                                                                var link = $("#title").val();


                                                                link = link.toLowerCase();


                                                                link = link.replace(/[^a-zA-Z0-9\s+]/g, '');


                                                                var final = link.replace(/\s+/g, '-')


                                                                $("#slug").val(final);


                                                            }





                                                        });

        </script>









        <!--Dropzone script -->





        <script>
            var imgDropzone;
            var addnews_formData = new FormData();
            var imgfileallowed = new Array('jpg', 'jpeg', 'JPEG', 'png', 'PNG', 'JPG', 'jpeg', 'ICO', 'ico');
            var videofileallowed = new Array('mp4', 'ogg', 'webm');
            var dzimgallowed = ".jpeg,.png,.jpg";
            var dzvidallowed = ".mp4,.ogg,.webm,.mov";
            Dropzone.autoDiscover = false;
            alter_dropzone($("#type").val());
            function mydropzonefunc(dz_acceptedFiles)
            {

                imgDropzone = new Dropzone("#div1", {



                    addRemoveLinks: true,



                    autoProcessQueue: false,



                    uploadMultiple: true,



                    timeout: 1000000, /*milliseconds*/



                    parallelUploads: 50,



                    acceptedFiles: dz_acceptedFiles,



                    url: 'ajax.php?h=addBlog',



                    init: function () {



                        var myDropzone = this;



                        // Update selector to match your button

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

                       



                    }



                });

            }
            function alter_dropzone(val) {

                addnews_formData = new FormData();

                var type = val;

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





                if (type == 'simpleblog' || type == "") {



                    $('.to_be_hidden').hide();







                    $('.gallcheckbox').attr('checked', false);



                    $('.gallcheckbox').prop('checked', false);



                } else {

                    if (type == "image-slider-blog")

                    {

                        mydropzonefunc(dzimgallowed);

                        $(".videofilecol").hide();

                        $(".imagefilecol").show();





                    } else if (type == "video-blog")

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
            $("#addLoader").click(function (e) {

e.preventDefault();

                var type = $('#type').val();



                var title = $('#title').val();



                var subtitle = $('#subtitle').val();



                var c = $('#content').val();



                var c2 = $('#content2').val();



                var c3 = $('#content3').val();



                var c4 = $('#content4').val();



                var quote = $('#quote').val();



                var category = $('#sel_category').val();

                var error = false;



                var iformdata = 0;

                
                                                                                    var video_url = "";
                                                                                    if($('#url').length > 0)
                                                                                    {
                                                                                        video_url = $("#video_url").val();
                                                                                    }

                for (var pair of addnews_formData.entries()) {



                    iformdata = 1;

                }







                $(".mediaerrors").hide();





                if (type != "simpleblog")



                {















                    if ($('input.gallcheckbox:checked').length < 1 && iformdata != 1 )



                    {



                        error = true;











                        if(type == "image-slider-news")



                        {



                            $("#image_error").show();



                        }



                        else if(type == "video-news")



                        {







                            $("#video_error").show();



                        }



                        else



                        {







                            $("#image_video_error").show();



                        }







                    }



                }







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



                if (!(subtitle.match(/^[^*|\":<>[\]{}`\\\-()';@&$]+$/))) {



                    error = true;
                    $("#sub_text_error").show();
                    $('#subtitle').css("border", "1px solid #ff4200");
                } else
                {

                    $("#sub_text_error").hide();
                    $('#subtitle').css("border", "1px solid #ccc");
                }
                if (!(c.match(/^[^<>]+$/)))
                {
                    error = true;
                    $("#content_error").show();
                    $('#content').css("border", "1px solid #ff4200");

                } else
                {
                    $('#content').css("border", "1px solid #ccc");
                    $("#content_error").hide();

                }
                if (!(c2.match(/^[^<>]+$/)) && c2 != "")
                {
                    error = true;
                    $("#content_2_error").show();
                    $('#content2').css("border", "1px solid #ff4200");
                } else
                {
                    $('#content2').css("border", "1px solid #ccc");
                    $("#content_2_error").hide();
                }
                if (!(c3.match(/^[^<>]+$/)) && c3 != "")
                {
                    error = true;
                    $('#content3').css("border", "1px solid #ff4200");
                    $("#content_3_error").show();
                } else
                {
                    $('#content3').css("border", "1px solid #ccc");
                    $("#content_3_error").hide();
                }
                if (!(c4.match(/^[^<>]+$/)) && c4 != "")
                {
                    error = true;
                    $('#content4').css("border", "1px solid #ff4200");
                    $("#content_4_error").show();
                } else
                {
                    $('#content4').css("border", "1px solid #ccc");
                    $("#content_4_error").hide();
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
                if (category == "" || typeof category == 'undefined')
                {
                    error = true;
                    $("#cat_error").show();
                    $('#sel_category').css("border", "1px solid #ff4200");
                } else

                {

                    $("#cat_error").hide();

                    $('#sel_category').css("border", "1px solid #ccc");

                }
                










        









                if (error === false) {



                    if ($('input.gallcheckbox:checked').length > 0)



                    {



                        $("input.gallcheckbox:checked").each(function () {



                            addnews_formData.append("galleryimgschecks[]", $(this).val());



                        });



                    }







                    addnews_formData.append("type", $('#type').val());



                    addnews_formData.append("title", $('#title').val());



                    addnews_formData.append("sub_title", $('#subtitle').val());



                    addnews_formData.append("content", $('#content').val());



                    addnews_formData.append("content_two", $('#content2').val());



                    addnews_formData.append("content_three", $('#content3').val());



                    addnews_formData.append("content_four", $('#content4').val());
                    
                    
addnews_formData.append("video_url", video_url);







                    addnews_formData.append("blockquote", $('#quote').val());



                    addnews_formData.append("slug", $('#slug').val());







                    addnews_formData.append("category", $("#sel_category").val())







                    $("#addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Adding');
                    $("#addLoader").prop('disabled',true)





                    $.ajax({



                        type: "POST",



                        dataType: 'json',



                        url: "ajax.php?h=addBlog",



                        data: addnews_formData,



                        processData: false,



                        contentType: false,



                        success: function (data) {


                            $( "#addLoader" ).html('Add Blog')
                            $("#addLoader").prop('disabled',false)



                            if (data.Success == 'true') {



                                $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');



                                setTimeout(function () {



                                    window.location = "content-listings.php";



                                }, 500);



                            } else {



                                $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-times></i>"' + data.Msg + '</div>');



                            }



                        }



                    });







                } else {









                    // ^[^<>]+$   remove <>







                    $(window).scrollTop(0);



                    $("div.prompt").show();



                    $("div.prompt").html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some fields missing</div>');



                    setTimeout(function () {



                        $("div.prompt").hide();



                    }, 2500);







                }



            });
        </script>





        <!--End Dropzone script-->













        <script>



            $(document).ready(function () {





                $("#gal").click(function () {

                    $('#galleryModal').modal('show');

                });

















//                 setInterval(function(){ 



//                     var cw = $('.gallery-card').width();

//                 // alert(cw);

// $('.gallery-card').css({'height':cw+'px'});





//                 }, 300);





//  $(window).resize(function() {



//                            var ccw = $('.gallery-card').width();

// $('.gallery-card').css({'height':ccw+'px'});



//                         });



















                $('input[type=radio]').click(function () {



                    if ($("#url").prop("checked")) {



                        //$('.to_be_hidden').hide();



                        document.getElementById('dummy').innerHTML = "<input type='text' class='form-control' name='video_url' id='video_url' placeholder='Video URL'>";



                    } else if ($("#local").prop("checked")) {



                        $('.to_be_hidden').show();



                        //$('.to_be_hidden_2').hide();



                        document.getElementById('dummy').innerHTML = "";



                    }

                });







                $("#images").val(null);



                $('.mult2').select2();



            });



        </script>



    </body>



</html>



