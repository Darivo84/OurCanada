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
                            <h4 class="mb-0 font-size-18">Add Multi Lingual</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Lingual</a></li>
                                    <li class="breadcrumb-item active">Add Multi Lingual</li>
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

                                <h4 class="card-title mb-4">Add Multi Lingual</h4>
                                <form method="POST" id="add_lingual">
                                    <div class="prompt"></div>
                                    <div class="form-group row mb-4">
                                        <label for="Categoryname" class="col-form-label col-lg-2">Language</label>
                                        <div class="col-lg-10">
                                            <input id="lang" name="language" type="text" class="form-control" placeholder="Enter Language" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="Categoryname" class="col-form-label col-lg-2">Display Name</label>
                                        <div class="col-lg-10">
                                            <input id="ntitle" name="display_name" type="text" class="form-control" placeholder="Enter Display Name" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="Categoryname" class="col-form-label col-lg-2">Language Code</label>
                                        <div class="col-lg-10">
                                            <input id="" name="language_code" type="text" class="form-control" placeholder="Enter Language Code" required>
                                        </div>
                                    </div>
                                    <!--                                            <div class="form-group row mb-4">-->
                                    <!--                                                <label for="Categoryname" class="col-form-label col-lg-2">Flag</label>-->
                                    <!--                                                <div class="col-lg-10">-->
                                    <!--                                                    <input id="ntitle" name="flag_image" type="file" class="form-control" accept="image/*" required>-->
                                    <!--                                                </div>-->
                                    <!--                                            </div>-->
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label col-lg-2">File</label>
                                        <div class="col-lg-10">
                                            <div class="dropzone" id="div1"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="Categorydesc" class="col-form-label col-lg-2">Display</label>
                                        <div class="col-lg-10">
                                            <select class="form-control" name="display_type" id='d_type' required>
                                                <option value="">Select Display Type...</option>
                                                <option value="Left to Right">Left to Right</option>
                                                <option value="Right to Left">Right to Left</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-10">
                                            <button id="addLoader" type="submit" class="btn btn-primary">Add Multi Lingual</button>
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
<script>

    Dropzone.autoDiscover = false;
    var imgDropzone = new Dropzone("#div1", {
        addRemoveLinks: true,
        autoProcessQueue: false,
        timeout: 1000000, /*milliseconds*/
        parallelUploads: 50,
        acceptedFiles: '.xls, .xlsx, .csv',
        url: 'ajax.php?h=add_lingual',
        init: function () {
            var myDropzone = this;
            // Update selector to match your button
            $("#addLoader").click(function (e) {
                var language = $('#lang').val();
                var display_type = $('#d_type').val();
                e.preventDefault();
                if( (language.match(/^[a-zA-Z\s]*$/)) && display_type != '' ){
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else{
                        $(window).scrollTop(0);
                        $( "div.prompt" ).show();
                        $( "div.prompt" ).html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Please Upload a excel file</div>');
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 1500 );
                    }
                } else{
                    $(window).scrollTop(0);
                    $( "div.prompt" ).show();
                    $( "div.prompt" ).html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some fields missing</div>');
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 1500 );
                }
            });
            this.on('sending', function(file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                var data = $('#add_lingual').serializeArray();
                $.each(data, function(key, el) {
                    formData.append(el.name, el.value);
                });
                //var files = $('#flag_image')[0].files;

                // Check file selected or not
                // if(files.length > 0 ) {
                //     formData.append('flag_image', files[0]);
                // }
            });
            this.on('complete', function(file) {
                var response = JSON.parse(file.xhr.responseText);
                if(response.Success == 'true'){
                    window.location = "multiLingual.php"
                } else{
                    $( "div.prompt" ).show();
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-warning" style="margin-right:10px;"></i>' + response.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                        myDropzone.removeAllFiles(true);
                        $('#add_lingual').reset();
                    }, 3000 );
                    window.location = "multiLingual.php";
                }
            });
        }
    });

</script>
</body>
</html>


