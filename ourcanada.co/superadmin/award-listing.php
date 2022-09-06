<?php
include_once("admin_inc.php");
$adminUrl = 'https://'.$_SERVER['HTTP_HOST'] . '/superadmin/';

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
                            <h4 class="mb-0 font-size-18">Awards & Nominations</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Awards & Nominations</a>
                                    </li>
                                    <li class="breadcrumb-item active">All Listing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <?php
                if (isset($_GET['method']) && ($_GET['method'] == 'update')) {
                    $awardID = $_GET['n_id'];

                    $query = "SELECT * FROM nominations where id=$awardID";
                    $row = mysqli_fetch_array(mysqli_query($conn, $query));
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Update Awards</h4>
                                    <form method="POST" id="edituser">
                                        <div class="prompt"></div>

                                        <div class="form-group row mb-4">
                                            <div class="col-md-6 pl-0">
                                                <label for="fna" class="col-form-label col-lg-12">Title</label>
                                                <div class="col-lg-12">
                                                    <input id="etitle" name="n[title]" type="text" class="form-control"
                                                           value="<?php echo $row["title"] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-0">
                                                <label for="lnamea" class="col-form-label col-lg-12">Last Date</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="date" id="elastDate"
                                                           name="n[lastDate]" value="<?php echo $row["lastDate"] ?>"
                                                           required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row mb-4">
                                            <div class="col-md-6 pl-0">
                                                <label for="lnamea" class="col-form-label col-lg-12">Announcement
                                                    Date</label>
                                                <div class="col-lg-12">
                                                    <input class="form-control" type="date" id="eannouncementDate"
                                                           name="n[announcementDate]"
                                                           value="<?php echo $row["announcementDate"] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-0">
                                                <label for="status" class="col-form-label col-lg-12">Status</label>
                                                <div class="col-lg-12">
                                                    <select id="statu" name="n[status]" class="form-control" required>

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
                                                    <input id="tags" name="n[tags]" type="text" class="form-control tags"
                                                           placeholder="Enter tags" title="Please select tags" required value="<?php echo $row['tags'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-0">
                                                <label for="Categoryname" class="col-form-label col-lg-12">Slug</label>
                                                <div class="col-lg-12">
                                                <input id="slug" name="n[slug]" class="form-control"
                                                       placeholder="Slug will be generated here" readonly value="<?php echo $row["slug"] ?>">
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
                                            <label for="lnamea" class="col-form-label col-lg-12">Description</label>
                                            <div class="col-lg-12">
                                                <textarea class="form-control" id="edescription" name="n[description]"
                                                          rows="3" required><?php echo $row["description"] ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-4">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Quote</label>
                                            <div class="col-lg-12">
                                            <textarea id="quote" name="n[quote]" type="text" rows="3" class="form-control"
                                                      placeholder="Enter Quote"><?php echo $row["quote"] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label for="Categoryname" class="col-form-label col-lg-12">Description 2</label>
                                            <div class="col-lg-12">
                                            <textarea id="desc_2" name="n[desc_2]" type="text" rows="3"
                                                      class="form-control" placeholder="Enter Description"
                                            ><?php echo $row["desc_2"] ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">

                                            <div class="col-md-6">
                                                <?php  if($row['award_image']!='') { ?>
                                                    <div class="card" id="imgDiv">
                                                        <i class="fa fa-times" id="imgClose"></i>
                                                        <img id="storyImage" class="card-img-top img-fluid" src="<?php echo $adminUrl ?>uploads/awardPhoto/<?php echo $row['award_image'] ?>">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <input id="ecreatedDate" name="createdDate"
                                               value="<?php echo $row["createdDate"] ?>" type="hidden">
                                        <input type="hidden" id="eId" name="id" value="<?php echo $row["id"] ?>">
                                        <div class="row justify-content-end">
                                            <div class="col-lg-12">
                                                <button id="updateLoader" type="submit"
                                                        class="btn btn-primary edit-form-button">Update
                                                </button>
                                                <a type="button" href="award-listing.php"
                                                   class="btn btn-light">Cancel</a></div>
                                        </div>
                                        <input type="hidden" id="imgCheck" name="imgCheck">

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } else {

                    $query = "SELECT * FROM nominations ORDER BY id DESC";
                    $result = mysqli_query($conn, $query);
                    ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <a href="add-award.php" style="padding: 7px; margin-bottom: 15px; float: right;"
                                       class="btn btn-primary waves-effect waves-light btn-sm">Add Award &
                                        Nomination</a>
                                    <br>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100px">#</th>

                                                <th scope="col">Title</th>
                                                <th scope="col">Apply Deadline</th>
                                                <th scope="col">Result Announce Date</th>
                                                <th scope="col">Created Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Winner</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $count = 1;
                                            while ($row = mysqli_fetch_array($result)) {
                                                $winner='N/A';
                                                $s=mysqli_query($conn,"select * from award_winner where award_id={$row['id']}");
                                                if(mysqli_num_rows($s) > 0)
                                                {
                                                    $r=mysqli_fetch_assoc($s);
                                                    $winner=$r['winner_name'];
                                                }

                                                ?>
                                                <tr>
                                                    <td><span><?php echo $count ?></span></td>
                                                    <td class="font-weight-bold"><?php echo $row["title"] ?></td>

                                                    <td><?php echo $row["lastDate"] ?></td>
                                                    <td><?php echo $row["announcementDate"] ?></td>

                                                    <td><?php echo $row["createdDate"] ?></td>
                                                    <td><label class="">
                                                            <input value="<?php echo $row["status"]; ?>" type="checkbox"
                                                                   name="custom-switch-checkbox"
                                                                   class="get_value custom-switch-input"
                                                                   onChange="changeStatus('<?php echo $row['id']; ?>')"
                                                                <?php if($row["status"] == 1) { echo 'checked'; } ?>
                                                            >
                                                            <span class="custom-switch-indicator"></span> </label></td>
                                                    <td>
                                                        <?php echo $winner ?>
                                                    </td>
                                                    <td>
                                                        <a href="nomination-listing.php?n_id=<?php echo $row['id']; ?>"
                                                           class="btn btn-sm btn-icon btn-warning table-button"><i
                                                                    class="fas fa-plus"></i> </a>
                                                        <a href="award-listing.php?method=update&n_id=<?php echo $row['id']; ?>"
                                                           id="editbtn" type="button"
                                                           class="btn btn-sm btn-icon btn-success table-button"><i
                                                                    class="fas fa-pencil-alt"></i> </a>
                                                        <button id="deletebtn"
                                                                class="btn btn-sm btn-icon btn-danger table-button"
                                                                onclick="sendid('<?php echo $row['id']; ?>')"
                                                                data-toggle="modal" data-target="#smallModal"><i
                                                                    class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                                <?php $count++;
                                            } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- end row -->


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <?php include_once("includes/footer.php"); ?>
    </div>
    <!-- end main content-->
    <div id="smallModal2" class="modal fade">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Image</h6>
                </div>
                <div class="modal-body">
                    <div class="prompt"></div>
                    <p>Are you sure you want to delete this image?</p>
                </div>
                <!-- MODAL-BODY -->
                <div class="modal-footer">
                    <input type="hidden" name="id" id="d_id">
                    <button type="button" id="cancel" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button id="delBtn" type="button" class="btn btn-danger">Delete
                    </button>
                </div>
            </div>
        </div>
        <!-- MODAL-DIALOG -->
    </div>

</div>
<!-- END layout-wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
<!-- Delete Modal -->
<div id="smallModal" class="modal fade">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Award</h6>
            </div>
            <div class="modal-body">
                <div class="prompt"></div>
                <p>Are you sure you want to delete this award?</p>
            </div>
            <!-- MODAL-BODY -->
            <div class="modal-footer">
                <input type="hidden" name="id" id="d_id">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button id="addLoader" type="button" class="btn btn-danger"
                        onClick="deleteCategory(document.getElementById('d_id').value)">Delete
                </button>
            </div>
        </div>
    </div>
    <!-- MODAL-DIALOG -->
</div>
<?php include_once("includes/script.php"); ?>
<script src="assets/js/bootstrap-tagsinput.js"></script>

<script>
    $(document).ready(function () {
        $("input.tags").tagsinput();
        $('#categoryTable').dataTable();
    });
    $('#imgClose').click(function () {
        $('#smallModal2').modal()
    })
    $('#delBtn').click(function () {
        $('#storyImage').fadeOut()
        $('#imgClose').hide()
        $('#cancel').click()
        $('#imgCheck').val(1)
    })


</script>
<script>
    function sendid(id) {
        $('#d_id').val(id);
    }
</script>
<script>
    function deleteCategory(id) {
        $("#addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
        $("#addLoader").prop('disabled',true)

        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=deleteA",
            type: 'POST',
            data: {id: id},
            success: function (data) {
                if (data.Success == 'true') {
                    $( "#addLoader" ).html('Delete')
                    $("#addLoader").prop('disabled',false)

                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>' + data.Msg + '</div>');
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"' + data.Msg + '</div>');
                }
            }
        });
    }
</script>
<script>
    $("#etitle").change(function () {
        var link = $("#etitle").val();
        link=link.replace(/[^a-zA-Z ]/g, "");
        var sluglink = link.toLowerCase();
        var final = sluglink.replace(/\s+/g, '-')
        $("#slug").val(final);
    });
    $(document).ready(function () {
        $('#edituser').validate({
            submitHandler: function () {
                var title = $('#etitle').val();
                var date = $('#elastDate').val();
                var announcementDate = $('#eannouncementDate').val();
                var desc = $('#edescription').val();
                var form = $('#edituser')[0];
                var fd = new FormData(form);
                var files = $('input[type="file"]')[0].files[0];
                fd.append('image',files);
                if (announcementDate > date) {
                    if ((title.match(/^[a-zA-Z0-9\s]+$/)) && (desc.match(/^(?!\d+$)\w+\S+/))) {
                        $("#updateLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
                        $("#updateLoader").prop('disabled',true)
                        'use strict';
                        $.ajax({
                            dataType: 'json',
                            url: "ajax.php?h=editAN",
                            type: 'POST',
                            data:fd,
                            contentType: false,
                            processData: false,
                            cache: false,
                            mimeType: "multipart/form-data",
                            success: function (data) {
                                $("div.prompt").show();
                                $(window).scrollTop(0);
                                $("#updateLoader").html('Update');
                                $("#updateLoader").prop('disabled',false)

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
            }
        });

    });
</script>

<script>

    function changeStatus(id) {

        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=status_changeN",
            method: "POST",
            data: {id: id},
            success: function (data) {
                if (data.Success === 'true') {
                    //$(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                    //setTimeout(function() {location.reload();}, 300);
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"' + data.Msg + '</div>');
                }
            }
        });

    };
</script>
</body>
</html>
