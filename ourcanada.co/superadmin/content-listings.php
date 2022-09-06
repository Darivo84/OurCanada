<?php

include_once("admin_inc.php");

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


                            <h4 class="mb-0 font-size-18">View Content Listing</h4>


                            <div class="page-title-right">


                                <ol class="breadcrumb m-0">


                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Content Uploading</a>
                                    </li>


                                    <li class="breadcrumb-item active">View Content Listing</li>


                                </ol>


                            </div>


                        </div>


                    </div>


                </div>


                <div class="row">


                    <div class="col-lg-4 mx-auto"></div>


                </div>


                <?php

                $row_count = 1;


                $query = "SELECT * FROM `content-uploads`";


                $result = mysqli_query($conn, $query);


                if (!isset($_GET['method'])) {

                    ?>


                    <div class="row">


                        <div class="col-lg-12">


                            <div class="card">


                                <div class="card-body">


                                    <div class="table-responsive">


                                        <div class="prompt"></div>


                                        <!-- <a href="javascript:void(0);" class="text-white btn btn-primary float-right" onclick="del_all();"><i class="fa fa-trash"></i>&nbsp;Delete All Blogs</a><br><br> -->


                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">


                                            <thead class="thead-light">


                                            <tr>


                                                <th scope="col" style="width: 100px; text-align: center;">#</th>


                                                <th scope="col" style="text-align: center;">Title</th>


                                                <th scope="col" style="text-align: center;">Sub Title</th>


                                                <th scope="col" style="text-align: center;">Content</th>


                                                <th scope="col" style="text-align: center;">Block Quote</th>


                                                <th scope="col" style="text-align: center;">Images</th>


                                                <th scope="col" style="text-align: center;">Local Videos / URLs</th>


                                                <th scope="col" style="text-align: center;">Created Date</th>


                                                <th scope="col" style="text-align: center;">Category</th>


                                                <th scope="col" style="text-align: center;">Status</th>


                                                <th scope="col" style="text-align: center;">Action</th>


                                            </tr>


                                            </thead>


                                            <tbody>


                                            <?php while ($fetch_row = mysqli_fetch_assoc($result)) { ?>


                                                <tr>


                                                    <td style="text-align: center;"><?php echo $row_count; ?></php></td>


                                                    <td style="text-align: center;"><?php echo $fetch_row['title']; ?></td>


                                                    <td style="text-align: center;">


                                                        <p class="text-muted mb-0">


                                                            <?php

                                                            $slen = strlen($fetch_row["sub_title"]);


                                                            if ($slen > 50) {


                                                                echo substr($fetch_row["sub_title"], 0, 40) . "...";

                                                            } else {


                                                                echo $fetch_row["sub_title"];

                                                            }

                                                            ?>


                                                        </p>


                                                    </td>


                                                    <td style="text-align: left;">


                                                        <h5 class="text-truncate font-size-14">


                                                            <a href="#" class="text-dark">


                                                                <?php

                                                                $slen = strlen($fetch_row["content"]);


                                                                if ($slen > 50) {


                                                                    echo substr($fetch_row["content"], 0, 50) . "...";

                                                                } else {


                                                                    echo $fetch_row["content"];

                                                                }

                                                                ?>


                                                            </a>


                                                        </h5>


                                                        <p class="text-muted mb-0">


                                                            <?php

                                                            $slen = strlen($fetch_row["content_two"]);


                                                            if ($slen > 50) {


                                                                echo substr($fetch_row["content_two"], 0, 50) . "...";

                                                            } else {


                                                                echo $fetch_row["content_two"];

                                                            }

                                                            ?>


                                                        </p>


                                                        <p class="text-muted mb-0">


                                                            <?php

                                                            $slen = strlen($fetch_row["content_three"]);


                                                            if ($slen > 50) {


                                                                echo substr($fetch_row["content_three"], 0, 50) . "...";

                                                            } else {


                                                                echo $fetch_row["content_three"];

                                                            }

                                                            ?>


                                                        </p>


                                                        <p class="text-muted mb-0">


                                                            <?php

                                                            $slen = strlen($fetch_row["content_four"]);


                                                            if ($slen > 50) {


                                                                echo substr($fetch_row["content_four"], 0, 50) . "...";

                                                            } else {


                                                                echo $fetch_row["content_four"];

                                                            }

                                                            ?>


                                                        </p>


                                                    </td>


                                                    <td style="text-align: center;">


                                                        <p class="text-muted mb-0">


                                                            <?php

                                                            $slen = strlen($fetch_row["blockquote"]);


                                                            if ($slen > 50) {


                                                                echo substr($fetch_row["blockquote"], 0, 40) . "...";

                                                            } else {


                                                                if ($slen == 0) {


                                                                    echo "N/A";

                                                                } else {


                                                                    echo $fetch_row["blockquote"];

                                                                }

                                                            }

                                                            ?>


                                                        </p>


                                                    </td>


                                                    <td style="text-align: center;"><a href="javascript:void(0);"
                                                                                       onclick="view_images(<?php echo $fetch_row['id']; ?>);"><i
                                                                    class="fa fa-images"></i>&nbsp;<span>Preview Images</span></a>
                                                    </td>


                                                    <td style="text-align: center;"><a href="javascript:void(0);"
                                                                                       onclick="view_videos(<?php echo $fetch_row['id']; ?>);"><i
                                                                    class="fa fa-video"></i>&nbsp;<span>Preview Videos / URLs</span></a>
                                                    </td>


                                                    <td style="text-align: center;"><?php echo $fetch_row['created_date']; ?></td>


                                                    <td style="text-align: center;"><?php echo $fetch_row['category']; ?></td>


                                                    <td style="text-align: center;"><?php

                                                        if ($fetch_row['status'] == 1) {


                                                            echo "<a class='btn btn-success text-white'><i class='fa fa-smile'></i>&nbsp;Approved</a>";

                                                        } else {


                                                            echo "<a class='btn btn-danger text-white'><i class='fa fa-frown'></i>&nbsp;Pending</a>";

                                                        }

                                                        ?></td>


                                                    <td style="text-align: center;"><a
                                                                href="?method=edit&id=<?php echo $fetch_row['id']; ?>"
                                                                class="text-dark"><i class="fa fa-edit"></i>&nbsp;Edit&nbsp;&nbsp;</a><a
                                                                href="javascript:void(0);"
                                                                onclick="del_blog(<?php echo $fetch_row['id']; ?>);"
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


        <div class="modal fade" id="delete_uploaded_content" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitle" aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">Delete BLOG</h5>


                    </div>


                    <div class="modal-body"> Are you sure, you wan't to delete this Post ?


                        <input id="user_id" type="hidden">


                    </div>


                    <div class="modal-footer"><a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a>
                        <a type="button" class="btn btn-success" style="color: white;" id="delBtn">Yes</a></div>


                </div>


            </div>


        </div>


        <div class="modal fade" id="update_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
             aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">Update STATUS</h5>


                    </div>


                    <div class="modal-body"> Are you sure, you wan't to update this status ?


                        <input id="user_id" type="hidden">


                    </div>


                    <div class="modal-footer"><a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a>
                        <a type="button" class="btn btn-success" style="color: white;" id="updateBlog">Yes</a></div>


                </div>


            </div>


        </div>


        <div class="modal fade" id="delete_all_blogs" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitle" aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">Delete BLOGS</h5>


                    </div>


                    <div class="modal-body"> Are you sure, you wan't to delete all blogs ?


                    </div>


                    <div class="modal-footer"><a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a>
                        <a type="button" class="btn btn-success" style="color: white;" id="delAll">Yes</a></div>


                </div>


            </div>


        </div>


        <div class="modal fade" id="del_files_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
             aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">Delete File</h5>


                    </div>


                    <div class="modal-body"> Are you sure, you wan't to delete this file ?


                        <input id="user_id" type="hidden">


                        <input id="filename" type="hidden">


                    </div>


                    <div class="modal-footer"><a type="button" class="btn btn-danger closee" data-dismiss="modal">No</a>
                        <a type="button" class="btn btn-success" style="color: white;" id="del_file">Yes</a></div>


                </div>


            </div>


        </div>


        <div class="modal fade" id="view_images" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
             aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">IMAGES Preview</h5>


                        <button type="button" class="close" data-dismiss="modal">


                            <span aria-hidden="true">×</span>


                        </button>


                    </div>


                    <div class="modal-body"></div>


                </div>


            </div>


        </div>


        <div class="modal fade" id="view_videos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
             aria-hidden="true">


            <div class="modal-dialog" role="document">


                <div class="modal-content">


                    <div class="modal-header">


                        <h5 class="modal-title" id="exampleModalLongTitle">VIDEOS Preview</h5>


                        <button type="button" class="close" data-dismiss="modal">


                            <span aria-hidden="true">×</span>


                        </button>


                    </div>


                    <div class="modal-body"></div>


                </div>


            </div>


        </div>


        <?php include_once("includes/footer.php"); ?>


    </div>
</div>
<div class="rightbar-overlay"></div>
<?php include_once("includes/script.php"); ?><br>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!--Dropzone script -->
<script>

    $(document).ready(function () {

        makeslug();


        $('#title').change(function () {

            makeslug();

        });


        function makeslug() {


            var link = $("#title").val();


            link = link.toLowerCase();


            link = link.replace(/[^a-zA-Z0-9\s+]/g, '');


            var final = link.replace(/\s+/g, '-')


            $("#slug").val(final);


        }


    });


    var imgDropzone;

    var addnews_formData = new FormData();

    var imgfileallowed = new Array('jpg', 'jpeg', 'JPEG', 'png', 'PNG', 'JPG', 'jpeg', 'ICO', 'ico');

    var videofileallowed = new Array('mp4', 'ogg', 'webm');

    var dzimgallowed = ".jpeg,.png,.jpg";

    var dzvidallowed = ".mp4,.ogg,.webm,.mov";

    Dropzone.autoDiscover = false;

    alter_dropzone($("#type").val());

    function mydropzonefunc(dz_acceptedFiles) {


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


                    if (dz_acceptedFiles.indexOf(ext) > -1) {


                        addnews_formData.append("file[]", file);


                    }


                });


                this.on('removedfile', function (file, xhr, formData) {


                    var tmformdata = addnews_formData;


                    addnews_formData = new FormData();


                    for (var pair of tmformdata.entries()) {


                        // console.log(pair[0]+ ', ' + pair[1].name);


                        if (pair[1].name != file.name) {


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


        if (imgDropzone === undefined) {


        } else {


            imgDropzone.destroy();


        }


        //


        $("#div1").empty();


        if (type == 'simpleblog' || type == "") {


            $('.to_be_hidden').hide();


            $('.gallcheckbox').attr('checked', false);


            $('.gallcheckbox').prop('checked', false);


        } else {


            if (type == "image-slider-blog") {


                mydropzonefunc(dzimgallowed);


                $(".videofilecol").hide();


                $(".imagefilecol").show();


            } else if (type == "video-blog") {


                mydropzonefunc(dzvidallowed);


                $(".videofilecol").show();


                $(".imagefilecol").hide();


            } else {


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

    $("#btn_update_blog").click(function (e) {


        e.preventDefault();


        var type = $('#type').val();


        var title = $('#title').val();


        var subtitle = $('#subtitle').val();


        var c = $('#content').val();


        var c2 = $('#content2').val();


        var c3 = $('#content3').val();


        var c4 = $('#content4').val();


        var quote = $('#quote').val();


        var video_url = "";

        if ($('#video_url').length > 0) {

            video_url = $("#video_url").val();

        }


        var category = $('#sel_category').val();


        var error = false;


        var iformdata = 0;


        for (var pair of addnews_formData.entries()) {


            iformdata = 1;

        }


        $(".mediaerrors").hide();


        if (type != "simpleblog") {


            if ($('input.gallcheckbox:checked').length < 1 && iformdata != 1) {

                error = true;


                if (type == "image-slider-news") {


                    $("#image_error").show();


                } else if (type == "video-news") {


                    $("#video_error").show();


                } else {

                    $("#image_video_error").show();

                }


            }


        }


        if (!((title.match(/^[^*|\":<>[\]{}`\\\-()';@&$]+$/)))) {


            error = true;


            $('#title').css("border", "1px solid #ff4200");


            $("#text_error").show();


        } else {


            $("#text_error").hide();


            $('#title').css("border", "1px solid #ccc");


        }


        if (!(subtitle.match(/^[^*|\":<>[\]{}`\\\-()';@&$]+$/))) {


            error = true;


            $("#sub_text_error").show();


            $('#subtitle').css("border", "1px solid #ff4200");


        } else {


            $("#sub_text_error").hide();


            $('#subtitle').css("border", "1px solid #ccc");


        }


        if (!(c.match(/^[^<>]+$/))) {


            error = true;


            $("#content_error").show();


            $('#content').css("border", "1px solid #ff4200");


        } else {


            $('#content').css("border", "1px solid #ccc");


            $("#content_error").hide();


        }


        if (!(c2.match(/^[^<>]+$/)) && c2 != "") {


            error = true;


            $("#content_2_error").show();


            $('#content2').css("border", "1px solid #ff4200");


        } else {


            $('#content2').css("border", "1px solid #ccc");


            $("#content_2_error").hide();


        }


        if (!(c3.match(/^[^<>]+$/)) && c3 != "") {


            error = true;


            $('#content3').css("border", "1px solid #ff4200");


            $("#content_3_error").show();


        } else {


            $('#content3').css("border", "1px solid #ccc");


            $("#content_3_error").hide();


        }


        if (!(c4.match(/^[^<>]+$/)) && c4 != "") {


            error = true;


            $('#content4').css("border", "1px solid #ff4200");


            $("#content_4_error").show();


        } else {


            $('#content4').css("border", "1px solid #ccc");


            $("#content_4_error").hide();


        }


        if (!(quote.match(/^[^<>]+$/))) {


            error = true;


            $('#quote').css("border", "1px solid #ff4200");


            $("#quote_error").show();


        } else {


            $('#quote').css("border", "1px solid #ccc");


            $("#quote_error").hide();


        }


        if (type == "") {


            error = true;


            $("#type_error").show();


            $('#type').css("border", "1px solid #ff4200");


        } else {


            $("#type_error").hide();


            $('#type').css("border", "1px solid #ccc");


        }


        if (category == "" || typeof category == 'undefined') {


            error = true;


            $("#cat_error").show();


            $('#sel_category').css("border", "1px solid #ff4200");


        } else {


            $("#cat_error").hide();


            $('#sel_category').css("border", "1px solid #ccc");


        }


        if (error === false) {


            if ($('input.gallcheckbox:checked').length > 0) {


                $("input.gallcheckbox:checked").each(function () {


                    addnews_formData.append("galleryimgschecks[]", $(this).val());


                });


            }


            addnews_formData.append("type", $('#type').val());


            addnews_formData.append("id", $('#bid').val());

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


            $("#btn_update_blog").html('<span class="spinner-border spinner-border-sm" role="status"></span> Updating Blog');
            $("#btn_update_blog").prop('disabled',true)


            $.ajax({


                type: "POST",


                dataType: 'json',


                url: "ajax.php?h=update_blog",


                data: addnews_formData,


                processData: false,


                contentType: false,


                success: function (data) {
                    $( "#btn_update_blog" ).html('Update Blog')
                    $("#btn_update_blog").prop('disabled',false)


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


<!--End Dropzone script -->


<script>


    function del_blog(id) {


        $('#delete_uploaded_content').modal()


        $('#user_id').val(id)


    }


    function update_status(id) {


        $('#update_status').modal()


        $('#user_id').val(id)


    }


    function del_all() {


        $('#delete_all_blogs').modal()


    }


    function delete_files(id, filename) {


        $('#del_files_modal').modal()


        $('#user_id').val(id)


        $('#filename').val(filename)


    }


    function view_images(id) {


        $('#view_images').modal()


    }


    function view_videos(id) {


        $('#view_videos').modal()


    }


    function view_videos(id) {


        var dataViewVid = '';


        $.ajax({


            dataType: 'json',


            url: "ajax.php?h=previewVid",


            type: 'POST',


            data: {'id': id},


            success: function (data) {


                if (data.Success === 'true') {


                    $("#view_videos .modal-body").empty();


                    for (var i = 0; i < data.data.length; i++) {


                        if (data.data[i] !== '') {


                            dataViewVid += '<div class="box-setup classImg"><span><video width="320" height="240" controls><source src="uploads/videos/' + data.data[i] + '" type="video/mp4"></video><p>' + data.data[i] + '</p></span></div>';


                        }


                    }


                    $("#view_videos .modal-body").append(dataViewVid);


                    $("#view_videos").modal();


                } else {


                }


            }


        });


    }


    function view_images(id) {


        var dataViewImg = '';


        $.ajax({


            dataType: 'json',


            url: "ajax.php?h=previewImg",


            type: 'POST',


            data: {'id': id},


            success: function (data) {


                if (data.Success === 'true') {


                    $("#view_images .modal-body").empty();


                    for (var i = 0; i < data.data.length; i++) {


                        if (data.data[i] !== '') {


                            dataViewImg += '<div class="box-setup classImg"><span><img class="imgsize" src="uploads/images/' + data.data[i] + '" ></a><p>' + data.data[i] + '</p></span></div>';


                        }


                    }


                    $("#view_images .modal-body").append(dataViewImg);


                    $("#view_images").modal();


                } else {


                }


            }


        });


    }


    $(document).ready(function () {


        // setInterval(function () {


        //     var gw = $('.gallery-card').width();


        //     // alert(cw);


        //     $('.gallery-card').css({'height': gw + 'px'});


        // }, 300);


        // var cw = $('.box-setup').width();


        // $('.box-setup').css({'height': cw + 'px'});


        // $(window).resize(function () {


        //     var ccw = $('.box-setup').width();


        //     $('.box-setup').css({'height': ccw + 'px'});


        //     var ggw = $('.gallery-card').width();


        //     $('.gallery-card').css({'height': ggw + 'px'});


        // });


        var type = $('#type').val();


        if (type == 'simpleblog')

            $('.to_be_hidden').hide();


        else

            $('.to_be_hidden').show();


        $('#del_file').click(function () {


            $("#del_file").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
            $("#del_file").prop('disabled',true)



            $.ajax({


                dataType: 'json',


                url: "ajax.php?h=del_file",


                type: 'POST',


                data: {'id': $("#user_id").val(), 'filename': $("#filename").val()},


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


        $("#gal").click(function () {


            $('#galleryModal').modal('show');


        });


        $('#delBtn').click(function () {


            $("#delBtn").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing')
            $("#delBtn").prop('disabled',true)



            $.ajax({


                dataType: 'json',


                url: "ajax.php?h=del_blog",


                type: 'POST',


                data: {'id': $("#user_id").val()},


                success: function (data) {


                    $(".closee").click()


                    if (data.Success === 'true') {


                        $(window).scrollTop(0);


                        $(window).scrollLeft(0);


                        $('.prompt').html('<div class="alert alert-success"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');


                        setTimeout(function () {


                            window.location.reload()


                        }, 1500);


                    } else {


                        $(window).scrollLeft(0);


                        $('.prompt').html('<div class="alert alert-danger"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>');


                        setTimeout(function () {


                            $("div.prompt").hide();


                        }, 1500);


                    }


                }


            });


        });


        $('#updateBlog').click(function () {


            $("#updateBlog").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');


            $.ajax({


                dataType: 'json',


                url: "ajax.php?h=update_status",


                type: 'POST',


                data: {'id': $("#user_id").val()},


                success: function (data) {


                    $(".closee").click()


                    if (data.Success === 'true') {


                        $(window).scrollTop(0);


                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');


                        setTimeout(function () {


                            window.location = "content-listings.php";


                        }, 1500);


                    } else {


                        $(window).scrollTop(0);


                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>');


                        setTimeout(function () {


                            $("div.prompt").hide();


                        }, 5000);


                    }


                }


            });


        });


        $('#delAll').click(function () {


            $("#delAll").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');


            $.ajax({


                dataType: 'json',


                url: "ajax.php?h=delete_all_blogs",


                type: 'POST',

                success: function (data) {


                    $(".closee").click()


                    if (data.Success === 'true') {


                        $(window).scrollTop(0);


                        $('.prompt').html('<div class="alert alert-success" style="text-align:left !important"><i class="fa fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>');


                        setTimeout(function () {


                            window.location.reload()


                        }, 3000);


                    } else {


                        $(window).scrollTop(0);


                        $('.prompt').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + data.Msg + '</div>');


                        setTimeout(function () {


                            $("div.prompt").hide();


                        }, 5000);


                    }


                }


            });


        });


        $('input[type=radio]').click(function () {


            if ($("#url").prop("checked")) {


                // $('.to_be_hidden').hide();


                document.getElementById('dummy').innerHTML = "<input type='text' class='form-control' value='<?php if ($fetched_row['video_url'] != "") {
                    echo $fetched_row['video_url'];
                } ?>'' name='video_url' id='video_url' placeholder='Video URL'>";


            } else if ($("#local").prop("checked")) {


                $('.to_be_hidden').show();


                document.getElementById('dummy').innerHTML = "";


            }


        });


        $('.js-example-basic-multiple').select2();


    });


</script>


</body>


</html>





















