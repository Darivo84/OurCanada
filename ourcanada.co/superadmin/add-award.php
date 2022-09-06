<?php
include_once("admin_inc.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <?php include_once("includes/style.php"); ?>
    <link rel="stylesheet" href="assets/css/bootstrap-tagsinput.css">

</head>

<body data-sidebar="dark">

<!-- Begin page -->
<div id="layout-wrapper">
    <?php include_once("includes/header.php"); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Add Award & Nominations</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Award & Nominations</a>
                                    </li>
                                    <li class="breadcrumb-item active">Add New</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-4 mx-auto">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Add Award & Nominations</h4>
                                <div class="prompt"></div>
                                <form method="POST" id="addaward" enctype="multipart/form-data">

                                    <div class="form-group row mb-4">
                                        <div class="col-md-6 pl-0">


                                            <label for="Categoryname" class="col-form-label col-lg-12">Title</label>
                                            <div class="col-lg-12">
                                                <input id="title" name="title" type="text" class="form-control"
                                                       placeholder="Enter Title"
                                                       title="Only letters, chars & whitespaces" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 pl-0">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Last Date</label>
                                            <div class="col-lg-12">
                                                <input id="lastDate" name="lastDate" type="date" class="form-control"
                                                       placeholder="Enter Deadline" title="Please select a date"
                                                       required>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row mb-4">
                                        <div class="col-md-6 pl-0">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Announcement
                                                Date</label>
                                            <div class="col-lg-12">
                                                <input id="announcementDate" name="announcementDate" type="date"
                                                       class="form-control" placeholder="Enter Announcement Date "
                                                       title="Please select a date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            <label for="status" class="col-form-label col-lg-12">Status</label>
                                            <div class="col-lg-12">
                                                <select id="statu" name="status" class="form-control"
                                                        title="Please select a status" required>

                                                    <option value="1"<?= $row["status"] == '1' ? ' selected="selected"' : ''; ?>>
                                                        Enable
                                                    </option>
                                                    <option value="0"<?= $row["status"] == '0' ? ' selected="selected"' : ''; ?>>
                                                        Disable
                                                    </option>

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row mb-4">
                                        <div class="col-md-6 pl-0">
                                            <label for="tags" class="col-form-label col-lg-12">Tags</label>
                                            <div class="col-lg-12">
                                                <input id="tags" name="tags" type="text" class="form-control tags"
                                                       placeholder="Enter tags" title="Please select tags" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Slug</label>

                                            <div class="col-lg-12">
                                                <input id="slug" name="slug" class="form-control"
                                                       placeholder="Slug will be generated here" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-0">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Award Photo</label>
                                            <div class="col-lg-12">
                                                <input type="file" style="color: #fff !important; text-align: left;" name="winner_photo" class="btn btn-success w-100" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="Categoryname" class="col-form-label col-lg-12">Description</label>
                                        <div class="col-lg-12">
                                            <textarea id="description" name="description" type="text" rows="3"
                                                      class="form-control" placeholder="Enter Description"
                                                      title="Only letters, chars & whitespaces" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="Categoryname" class="col-form-label col-lg-12">Quote</label>
                                        <div class="col-lg-12">
                                            <textarea id="quote" name="quote" type="text" rows="3" class="form-control"
                                                      placeholder="Enter Quote" ></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="Categoryname" class="col-form-label col-lg-12">Description 2</label>
                                        <div class="col-lg-12">
                                            <textarea id="desc_2" name="desc_2" type="text" rows="3"
                                                      class="form-control" placeholder="Enter Description"
                                                      ></textarea>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-lg-12">
                                            <button id="addLoader" type="submit" class="btn btn-primary">Add Award &
                                                Nominations
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include_once("includes/footer.php"); ?>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<?php include_once("includes/script.php"); ?>
<script src="assets/js/bootstrap-tagsinput.js"></script>

<script>
    $(document).ready(function (event) {
        $('#addaward').validate({
            submitHandler: function (e) {

                //event.preventDefault();
                var type = $('#type').val();
                var title = $('#title').val();
                var date = $('#lastDate').val();
                var announcementDate = $('#announcementDate').val();
                var desc = $('#description').val();
                var tags = $('#tags').val();
                var form = $('#addaward')[0];
                var fd = new FormData(form);
                var files = $('input[type="file"]')[0].files[0];
                fd.append('image',files);

                if (announcementDate > date) {
                    if ((title.match(/^[a-zA-Z0-9&\s]+$/)) && (desc.match(/^(?!\d+$)\w+\S+/))) {
                        $("#addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
                        $("#addLoader").prop('disabled',true)

                        $.ajax({
                            dataType: 'json',
                            url: "ajax.php?h=addnewA",
                            type: 'POST',
                            data: fd,//$("#addaward").serialize(),
                            contentType: false,
                            processData: false,
                            cache: false,
                            mimeType: "multipart/form-data",

                            success: function (data) {
                                $("div.prompt").show();
                                $(window).scrollTop(0);
                                $("#addLoader").html('Add Award & Nominations');
                                $("#addLoader").prop('disabled',false)

                                if (data.Success == 'true') {
                                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');

                                    setTimeout(function () {
                                        window.location = "award-listing.php";
                                    }, 1000);
                                } else {
                                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning"></i>' + data.Msg + '</div>');
                                }
                            }
                        });
                        return false;
                    } else {
                        $(window).scrollTop(0);
                        $("div.prompt").show();
                        $("div.prompt").html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Invalid Input Formats or some field is missing</div>');
                        setTimeout(function () {
                            $("div.prompt").hide();
                        }, 1500);
                    }
                } else {
                    $(window).scrollTop(0);
                    $("div.prompt").show();
                    $("div.prompt").html('<div class="alert alert-danger" style="text-align:left !important"><i class="fa fa-times" style="margin-right:10px;"></i>Last Date is greater than announcement date</div>');
                    setTimeout(function () {
                        $("div.prompt").hide();
                    }, 1500);
                }
                return false;

            }
        });

    });
</script>
<script>
    $(document).ready(function () {
        $("input.tags").tagsinput();


        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = yyyy + '-' + mm + '-' + dd;
        $("#lastDate").attr("min", today);
        $("#announcementDate").attr("min", today);

        $("#title").change(function () {
            var link = $("#title").val();
            link=link.replace(/[^a-zA-Z ]/g, "");
            var sluglink = link.toLowerCase();
            var final = sluglink.replace(/\s+/g, '-')
            $("#slug").val(final);
        });
        $("#slug").change(function () {
            var link = $("#slug").val();
            link=link.replace(/[^a-zA-Z ]/g, "");
            var sluglink = link.toLowerCase();
            var final = sluglink.replace(/\s+/g, '-')
            $("#slug").val(final);
        });

    });



</script>


</body>
</html>
