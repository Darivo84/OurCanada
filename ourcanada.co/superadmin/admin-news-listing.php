<?php

include_once("admin_inc.php");
$cur_lang = '';
$view_lang = '';
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $cur_lang = "_".$_GET['lang'];
    $view_lang = '/'.$_GET['lang'];
}
?>


<!doctype html>


<html lang="en">


<head>


    <meta charset="utf-8"/>


    <?php include_once("includes/style.php"); ?><br>


    <link href="assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css"/>


    <script src="assets/libs/dropzone/min/dropzone.js"></script>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>


    <style>


        .box-setup {


            border: 1px dotted silver;


            padding: 10px;


            position: relative;


        }


        .cross-button {


            position: absolute;


            display: inline-block;


            top: -10px;


            right: -7px;


            border-radius: 35%;


            overflow: hidden;


        }


    </style>


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


                            <h4 class="mb-0 font-size-18">News Listing</h4>


                            <div class="page-title-right">
                                <select onchange="getContent(this.value);" class="form-control">
                                <option <?php if(str_replace('_', '', $cur_lang) == ""){echo "selected";} ?> value="">English News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "chinese"){echo "selected";} ?> value="chinese">Chinese News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "francais"){echo "selected";} ?> value="francais">Francais News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "hindi"){echo "selected";} ?> value="hindi">Hindi News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "punjabi"){echo "selected";} ?> value="punjabi">Punjabi News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "urdu"){echo "selected";} ?> value="urdu">Urdu News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "spanish"){echo "selected";} ?> value="spanish">Spanish News</option>
                                <option <?php if(str_replace('_', '', $cur_lang) == "arabic"){echo "selected";} ?> value="arabic">Arabic News</option>
                            </select>

                                <!-- <ol class="breadcrumb m-0">


                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Content Uploading</a>
                                    </li>


                                    <li class="breadcrumb-item active">View Content Listing</li>


                                </ol> -->


                            </div>


                        </div>


                    </div>


                </div>


                <div class="row">


                    <div class="col-lg-4 mx-auto"></div>

                </div>


                <?php

                $row_count = 1;


                $query = "SELECT * FROM `news_content".$cur_lang."` WHERE created_by = 1";


                $result = mysqli_query($conn, $query);


                if (!isset($_GET['method'])) {

                    ?>


                    <div class="row">


                        <div class="col-lg-12">


                            <div class="card">


                                <div class="card-body">


                                    <div class="table-responsive">


                                        <div class="prompt"></div>


                                        <!-- <a href="javascript:void(0);" class="text-white btn btn-primary float-right" onclick="del_all();"><i class="fa fa-trash"></i>&nbsp;Delete All News</a><br><br> -->


                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">


                                            <thead class="thead-light">


                                            <tr>


                                                <th scope="col" style="width: 100px; text-align: center;">#</th>


                                                <th scope="col" style="text-align: center;">Title</th>


                                                <th scope="col" style="text-align: center;">Created Date</th>


                                                <th scope="col" style="text-align: center;">Category</th>


                                                <th scope="col" style="text-align: center;">Action</th>


                                            </tr>


                                            </thead>


                                            <tbody>
                                                <?php if(mysqli_num_rows($result) < 1){
                                                    echo "<tr><td colspan='10'><h1 align='center'>No Record found.</h1></td></tr>";
                                                } ?>

                                            <?php while ($fetch_row = mysqli_fetch_assoc($result)) { ?>


                                                <tr>


                                                    <td style="text-align: center;"><?php echo $row_count; ?></php></td>


                                                    <td style="text-align: center;" title="<?= $fetch_row['title'] ?>"><?php echo displayTitle($fetch_row['title'],20,isset($_GET['lang']) ? $_GET['lang'] : ''); ?></td>






                                                    <td style="text-align: center;"><?php echo $fetch_row['created_at']; ?></td>


                                                    <td style="text-align: center;" title="<?=$fetch_row['category']  ?>">
                                                        <?php 
                                                        $cl = mysqli_query($conn,"SELECT * FROM category_blog WHERE id IN (".$fetch_row['category'].")");
                                                        $fetch_row['category'] = '';
                                                        while($cl_row = mysqli_fetch_assoc($cl)){
                                                            $fetch_row['category'] =  $cl_row['title'];
                                                        }
                                                        if(strlen($fetch_row['category']) > 15){
                                                            echo substr($fetch_row['category'], 0,15).'...';
                                                        }else{
                                                            echo $fetch_row['category'];
                                                        } 
                                                        ?>    
                                                    </td>


                                                    <td style="text-align: center;">
                                                        <?php if(empty($view_lang) || $view_lang == 'english'){}else{$fetch_row['slug'] = rand(10,1000000).'-'.$fetch_row['id'];} ?>
                                                                <a class="text-info" target="_new" href="<?= $currentTheme.'community/news/'.$fetch_row['slug'].$view_lang; ?>"><i class="fa fa-info"></i>&nbsp;View&nbsp;&nbsp;</a>
                                                        <a
                                                                href="update-content?id=<?php echo $fetch_row['id']; ?>&type=news<?php if(isset($_GET['lang']) && !empty($_GET['lang']))echo'&lang='.$_GET['lang']; ?>"
                                                                class="text-dark"><i class="fa fa-edit"></i>&nbsp;Edit&nbsp;&nbsp;</a>
                                                                <a
                                                                href="javascript:void(0);"
                                                                onclick="$('#del_files_modal').modal(); $('#del_files_modal').attr('content_id',<?= $fetch_row['id'] ?>);"
                                                                class="text-danger"><i class="fa fa-trash"></i>&nbsp;Delete</a>
                                                    </td>


                                                </tr>


                                                <?php

                                                $row_count++;

                                            }

                                            ?>


                                            </tbody>


                                        </table>


                                    </div>


                                </div>


                            </div>


                        </div>


                    </div>


                    <?php

                } else if ($_GET['method'] == 'edit') {


                    $sql = "SELECT * FROM `content-uploads` WHERE id={$_GET['id']}";


                    $result = mysqli_query($conn, $sql);


                    $fetched_row = mysqli_fetch_assoc($result);

                    ?>


                    <div class="row">


                        <div class="col-lg-12">


                            <div class="card">


                                <div class="card-body">


                                    <h4 class="card-title mb-4">Edit BLOG</h4>


                                    <form method="POST" id="addBlog" enctype="multipart/form-data">


                                        <div class="prompt"></div>


                                        <div class="form-group row mb-4">


                                            <label for="Categoryname" class="col-form-label col-lg-2">Title</label>


                                            <div class="col-lg-10">


                                                <input id="title" name="title" type="text" class="form-control"
                                                       placeholder="Blog Title"
                                                       value="<?php echo $fetched_row['title'] ?>">

                                                <span class="news_error_span" id="text_error">Enter title in valid format</span>


                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categoryname" class="col-form-label col-lg-2">Sub Title</label>


                                            <div class="col-lg-10">


                                                <input id="subtitle" name="sub_title" type="text" class="form-control"
                                                       placeholder="Blog Sub-Title"
                                                       value="<?php echo $fetched_row['sub_title'] ?>">

                                                <span class="news_error_span" id="sub_text_error">Enter title in valid format</span>

                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categoryname" class="col-form-label col-lg-2">Slug</label>


                                            <div class="col-lg-10">


                                                <input id="slug" name="slug" type="text" class="form-control"
                                                       placeholder="Blog Slug" readonly>


                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="type" class="col-form-label col-lg-2">Blog Type</label>


                                            <div class="col-lg-10">


                                                <select id="type" name="type" type="text" class="form-control"
                                                        placeholder="Blog Type" onchange="alter_dropzone(this.value);">


                                                    <option label="Select type"></option>


                                                    <option value="simpleblog" <?php if ($fetched_row['type'] == 'simpleblog') echo "selected"; ?>>
                                                        Simple Blog
                                                    </option>


                                                    <option value="image-slider-blog" <?php if ($fetched_row['type'] == 'image-slider-blog') echo "selected"; ?>>
                                                        Blog With Image Slider
                                                    </option>


                                                    <option value="video-blog" <?php if ($fetched_row['type'] == 'video-blog') echo "selected"; ?>>
                                                        Blog With Video
                                                    </option>


                                                    <option value="video-image-blog" <?php if ($fetched_row['type'] == 'video-image-blog') echo "selected"; ?>>
                                                        Blog With Video/Image
                                                    </option>


                                                </select>


                                                <span class="news_error_span"
                                                      id="type_error">Blog type is required</span>


                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categorydesc" class="col-form-label col-lg-2">Content</label>


                                            <div class="col-lg-10 ">


                                                <textarea class="form-control" id="content" name="content" rows="3"
                                                          placeholder="Blog Content"><?php echo $fetched_row['content'] ?></textarea>

                                                <span class="news_error_span" id="content_error">Enter Content in valid format</span>

                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categorydesc" class="col-form-label col-lg-2">Block
                                                Quote</label>


                                            <div class="col-lg-10 ">


                                                <textarea class="form-control" id="quote" name="blockquote" rows="3"
                                                          placeholder="Blog Quote"><?php echo $fetched_row['blockquote'] ?></textarea>

                                                <span class="news_error_span" id="quote_error">Enter Quote in valid format</span>

                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categorydesc" class="col-form-label col-lg-2">Content
                                                Two</label>


                                            <div class="col-lg-10 ">


                                                <textarea class="form-control" id="content2" name="content_two" rows="3"
                                                          placeholder="Blog Content Two"><?php echo $fetched_row['content_two'] ?></textarea>


                                                <span class="news_error_span" id="content_2_error">Enter Content in valid format</span>


                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categorydesc" class="col-form-label col-lg-2">Content
                                                Three</label>


                                            <div class="col-lg-10 ">


                                                <textarea class="form-control" id="content3" name="content_three"
                                                          rows="3"
                                                          placeholder="Blog Content Three"><?php echo $fetched_row['content_three'] ?></textarea>

                                                <span class="news_error_span" id="content_3_error">Enter Content in valid format</span>

                                            </div>


                                        </div>


                                        <div class="form-group row mb-4">


                                            <label for="Categorydesc" class="col-form-label col-lg-2">Content
                                                Four</label>


                                            <div class="col-lg-10 ">


                                                <textarea class="form-control" id="content4" name="content_four"
                                                          rows="3"
                                                          placeholder="Blog Content Four"><?php echo $fetched_row['content_four'] ?></textarea>

                                                <span class="news_error_span" id="content_4_error">Enter Content in valid format</span>

                                            </div>


                                        </div>


                                        <div class="form-group row mb-4 ">


                                            <label for="Categorydesc" class="col-form-label col-lg-4">Video URL (CSV
                                                format)<br><br>

                                                <span style="float: left; margin-right: 50px;">

    

    <input type="radio" name="rd" id="url" <?php if ($fetched_row['video_url'] != "") {
        echo "checked";
    } ?> autocomplete="off"> URL  &nbsp; &nbsp;  <input type="radio" name="rd" id="local"
                                                        autocomplete="off"> Local </span>


                                            </label>


                                            <div class="col-lg-8" id="dummy"><?php


                                                if ($fetched_row['video_url'] != "") {

                                                    ?>


                                                    <input type='text' class='form-control' name='video_url'
                                                           id='video_url'
                                                           value="<?php echo $fetched_row['video_url']; ?>"
                                                           placeholder='Video URL'>


                                                <?php } ?>

                                            </div>


                                        </div>


                                        <div class="form-group row mb-4 to_be_hidden">


                                            <div class="col-lg-12">

                                                <button id="gal" type="button" class="btn btn-primary">Open Gallery
                                                </button>


                                            </div>

                                        </div>


                                        <?php if ($fetched_row['images'] != '') { ?>


                                            <div class="form-group row mb-4 to_be_hidden">


                                                <label class="col-form-label col-lg-2">Editable Files</label>


                                                <div class="col-lg-10 main-div">


                                                    <div class="col-lg-12" style="">


                                                        <div class="row">


                                                            <?php

                                                            $imageNames = explode(",", $fetched_row['images']);


                                                            $count = 0;


                                                            while ($count != (sizeof($imageNames) - 1)) {

                                                                ?>


                                                                <div class='col-sm-3'>
                                                                    <div style='float: left; margin-bottom: 20px; text-align: center; display: inline-block; width: 100%; height: 100px;'
                                                                         class='box-setup'><span>







                                                                                                                        <!--<i class="fa fa-3x fa-image"></i>-->







                                                                            </span><span class='cross-button'><a
                                                                                    href="javascript:void(0);"
                                                                                    onclick='delete_files("<?php echo $fetched_row['id'] ?>", "<?php echo $imageNames[$count] ?>");'>







                                                                                    <i class="fa fa-2x fa-window-close text-danger"></i>



                                                                                </a>



                                                                            </span>


                                                                        <img style="width:100%;height:100%;"
                                                                             src="uploads/images/<?php echo $imageNames[$count]; ?>">


                                                                        <!--<p><?php echo $imageNames[$count]; ?></p>-->


                                                                    </div>
                                                                </div>


                                                                <style>


                                                                </style>


                                                                <?php

                                                                $count++;

                                                            }


                                                            $videoNames = explode(",", $fetched_row['video_local']);


                                                            $count = 0;


                                                            while ($count != (sizeof($videoNames) - 1)) {

                                                                ?>


                                                                <div class='col-sm-3'>
                                                                    <div style='float: left; margin-bottom: 20px; text-align: center; display: inline-block; width: 100%; '
                                                                         class='box-setup'><span>



                                                                                                                                                <!--<i class="fa fa-3x fa-video"></i>-->







                                                                            </span><span class='cross-button'><a
                                                                                    href="javascript:void(0);"
                                                                                    onclick='delete_files("<?php echo $fetched_row['id'] ?>", "<?php echo $videoNames[$count] ?>");'><i
                                                                                        class="fa fa-2x fa-window-close text-danger"></i></a></span>


                                                                        <video loop
                                                                               style="width:100%;height:100%; object-fit: cover;"
                                                                               muted autoplay>


                                                                            <?php

                                                                            $fileTypee = pathinfo($videoNames[$count], PATHINFO_EXTENSION);

                                                                            ?>


                                                                            <source src="uploads/videos/<?php echo($videoNames[$count]); ?>"
                                                                                    type="video/<?php echo $fileTypee; ?>">


                                                                            Your browser does not support HTML video.


                                                                        </video>


                                                                        <!--<p><?php echo $videoNames[$count]; ?></p>-->


                                                                    </div>
                                                                </div>


                                                                <?php

                                                                $count++;

                                                            }

                                                            ?>


                                                        </div>


                                                    </div>


                                                </div>


                                            </div>


                                        <?php } ?>


                                        <!--Selecting From Gallery -->


                                        <div class="form-group row mb-4 to_be_hidden">


                                            <!-- Gallery Modal -->


                                            <div id="galleryModal" class="modal fade">


                                                <div class="modal-dialog modal-lg" role="document">


                                                    <div class="modal-content">


                                                        <div class="modal-header">


                                                            <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">
                                                                Select Images</h6>


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


                                                                    border: 1px solid rgba(0, 0, 0, .125);


                                                                    border-radius: .25rem;


                                                                    width: 100%;


                                                                    margin-bottom: 14px;


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


                                                                label {


                                                                    margin-bottom: 0 !important;


                                                                }


                                                                /*--checkbox--*/


                                                                .block-check {


                                                                    display: block;


                                                                    position: relative;


                                                                    height: 100%;


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


                                                                <div class="row inner-scroll">


                                                                    <?php

                                                                    $files = scandir('uploads/gallery');


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

                                                                            }
                                                                            echo $fileclasscol;

                                                                            ?> ">


                                                                                <div class="gallery-card"
                                                                                     style="height: 120px;">


                                                                                    <div class="gallery-card-body">


                                                                                        <label class="block-check">


                                                                                            <?php

                                                                                            if ($fileTypeStr == "img") {

                                                                                                ?>


                                                                                                <img style="height:100%;"
                                                                                                     src="uploads/gallery/<?php echo($splFileInfo->getFilename()); ?>"
                                                                                                     class="img-responsive"/>


                                                                                            <?php } else {

                                                                                                ?>


                                                                                                <video loop
                                                                                                       style="width:100%; object-fit: cover;"
                                                                                                       muted autoplay>


                                                                                                    <source src="uploads/gallery/<?php echo($splFileInfo->getFilename()); ?>"
                                                                                                            type="video/<?php echo $fileType; ?>">


                                                                                                    Your browser does
                                                                                                    not support HTML
                                                                                                    video.


                                                                                                </video>


                                                                                            <?php }

                                                                                            ?>


                                                                                            <input class="gallcheckbox"
                                                                                                   type="checkbox"
                                                                                                   value="<?php echo($splFileInfo->getFilename()); ?>"
                                                                                                   name="galleryimgschecks[]">


                                                                                            <span class="checkmark"></span>


                                                                                        </label>


                                                                                    </div>


                                                                                </div>


                                                                            </div>


                                                                            <?php

                                                                            $fileIndex++;


                                                                            //example: get filename

                                                                        }

                                                                    }

                                                                    ?>


                                                                </div>


                                                            </div>


                                                        </div>


                                                    </div>


                                                </div>


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

                                                <?php


                                                $prevcategories = explode(",", $fetched_row['category']);


                                                ?>

                                                <select class="form-control js-example-basic-multiple" name="category[]"
                                                        id="sel_category" multiple="multiple">


                                                    <?php

                                                    $query = "SELECT * FROM `category_blog`";

                                                    $result = mysqli_query($conn, $query);

                                                    while ($row = mysqli_fetch_assoc($result)) {

                                                        ?>

                                                        <option <?php if (in_array($row['title'], $prevcategories)) {
                                                            echo "selected";
                                                        } ?> value="<?= $row['title'] ?>"><?= $row['title'] ?></option>

                                                    <?php } ?>


                                                </select>


                                            </div>


                                        </div>


                                        <input name="id" id="bid" type="text" value="<?php echo $fetched_row['id'] ?>"
                                               hidden>


                                        <div class="row justify-content-end">


                                            <div class="col-lg-10">


                                                <button id="btn_update_blog" type="submit" class="btn btn-primary">
                                                    Update Blog
                                                </button>


                                            </div>


                                        </div>


                                    </form>


                                </div>


                            </div>


                        </div>


                    </div>


                <?php } ?>


            </div>


        </div>


       

        <div class="modal fade" id="del_files_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
             aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">Delete News</h5>


                    </div>


                    <div class="modal-body"> 
                        <div class="error"></div>
                        <input type="checkbox" id="del_form_all">
                        <label>Delete form all languages</label>
                        <p><b>Note: </b>By default blog will delete from current selected language.</p>
                        <br>
                        Are you sure, you wan't to delete this news?

                    </div>


                    <div class="modal-footer"><a type="button" style="color: white;" class="btn btn-success closee" data-dismiss="modal">No</a>
                        <a type="button" class="btn btn-danger" style="color: white;" id="del_file"><i class="fa fa-spin fa-spinner" style="display: none; margin-right: 5px;"></i>Yes</a></div>


                </div>


            </div>


        </div>


        


        <?php include_once("includes/footer.php"); ?>


    </div>
</div>
<div class="rightbar-overlay"></div>
<?php include_once("includes/script.php"); ?><br>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script type="text/javascript">
    function getContent(value){
        if(value != ""){
            window.location.href = "<?php echo $currentTheme ?>superadmin/admin-news-listing?lang="+value;
        }else{
            window.location.href = "<?php echo $currentTheme ?>superadmin/admin-news-listing";
        }
    }
    $(document).ready(function() {
        $('#categoryTable').dataTable(); 
    });
    $("#del_files_modal .btn-danger").click(function(){
        var id = $("#del_files_modal").attr("content_id");
        var sel = $(this);
        var lang = $("#del_files_modal #del_form_all").prop("checked");
        if(lang){
            lang = "delete_all";
        }else{
            lang = "none";
        }
        $.ajax({
            type: "POST",
            url: "ajax.php?h=deleteAdminNews",
            data:{id:id,lang:lang,cur_lang: "<?= $cur_lang ?>"},
            dataType: "json",
            beforeSend: function(){
                sel.children("i").show();
            },
            success: function(res){
                sel.children("i").hide();
                console.log(res);
                if(res.success){
                    window.location.reload();
                }else{
                    $("#del_files_modal .error").attr("class","error alert alert-danger");
                    $("#del_files_modal .error").text("Failed to delete");
                }
            },
            error: function(e){
                sel.children("i").hide();
                console.log(e);
            }
        });
    });
</script>

</body>


</html>





















