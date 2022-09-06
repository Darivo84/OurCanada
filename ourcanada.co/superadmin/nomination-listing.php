<?php
include_once("admin_inc.php");
$awardsUrl = 'https://awards.' . $_SERVER['HTTP_HOST'] . '/';
$adminUrl = 'https://'.$_SERVER['HTTP_HOST'] . '/superadmin/';

$users=array();
$winner=false;
$set_winner = mysqli_query($conn,"SELECT * FROM award_winner WHERE award_id = ".$_GET['n_id']);
if(mysqli_num_rows($set_winner) > 0)
{
    $winner=true;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <!-- Bootstrap Rating css -->
    <?php include_once("includes/style.php"); ?>
    <style>
        .badge-info{
            display: none;
        }
    </style>
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
                            <h4 class="mb-0 font-size-18">Nominations</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Nominations</a></li>
                                    <li class="breadcrumb-item active">All Listing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                if(!$winner)
                                {
                                    ?>
                                    <a href="javascript:void(0)" style="padding: 7px; margin-bottom: 15px; float: right;" data-toggle="modal" data-target="#winnerModal" class="btn btn-primary waves-effect waves-light btn-sm">Declare Winner</a>

                                    <?php
                                }
                                else
                                {
                                    ?>
                                    <a href="javascript:void(0)" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-dark waves-effect waves-light btn-sm">Winner for this award is already declared !</a>

                                    <?php
                                }
                                ?>
                                <br>
                                <br>
                                <div class="table-responsive">
                                    <table id="categoryTable" class="table table-centered table-nowrap table-hover">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col" style="width: 100px">#</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Posted By</th>
                                            <th scope="col">Assign Token</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $list = mysqli_query($conn, "SELECT nominated_users_list.*,nominated_users_list.user_id as u_id,users.firstname,users.lastname,users.email as uemail,nominated_users_list.email FROM nominated_users_list LEFT JOIN users ON nominated_users_list.user_id = users.id WHERE award_id = '{$_GET['n_id']}' ");
                                        $count_row = 0;
                                        while ($rowList = mysqli_fetch_assoc($list)) {
                                            $count_row++;
                                            $s=[];
                                            if($rowList['uemail']!='')
                                            {
                                                $s['name']=$rowList['firstname'] . ' ' . $rowList['lastname'];
                                                if($rowList['firstname'] == ''){
                                                    $s['name'] = $rowList['email'];
                                                }
                                                $s['email']=$rowList['uemail'];
                                            }
                                            else
                                            {
                                                $s['name']=$rowList['fname'] . ' ' . $rowList['lname'];
                                                if($rowList['fname'] == ''){
                                                    $s['name'] = $rowList['email'];
                                                }
                                                $s['email']=$rowList['email'];
                                            }
                                            $s['id']=$rowList['id'];
                                            if($rowList['status'] == 1){
                                                $users[]=$s;
                                            }



                                            ?>
                                            <tr>
                                                <td><?= $count_row ?></td>
                                                <td><?php

                                                    if (strlen($rowList['title']) > 30) {
                                                        echo substr($rowList['title'], 0, 30) . "....";
                                                    } else {
                                                        echo $rowList['title'];
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    if (strlen($rowList['description']) > 45) {
                                                        echo substr($rowList['description'], 0, 45) . "....";
                                                    } else {
                                                        echo $rowList['description'];
                                                    }
                                                    ?></td>
                                                <td><?php if($rowList['firstname']!=''){ echo $rowList['firstname'] . ' ' . $rowList['lastname']; } else {echo $rowList['fname'] . ' ' . $rowList['lname'];}  ?></td>
                                                <td class="text-center">
                                                    <?php if($rowList['token'] > 0) { ?>
                                                        <button type="button" class="btn btn-sm btn-success"><?php echo $rowList['token']; ?></button>
                                                   <?php } else { ?>
                                                        <a href="javascript:void(0)" title="Assign Token"
                                                           onClick="AssignToken('<?php echo $rowList['id'] ?>')"
                                                           class="btn btn-sm btn-icon btn-secondary table-button"><i
                                                                    class="fas fa-award"></i> </a>
                                                    <?php } ?>

                                                </td>
                                                <td><label class="">
                                                        <input value="<?php echo $rowList["status"]; ?>" type="checkbox"
                                                               name="custom-switch-checkbox"
                                                               class="get_value custom-switch-input"
                                                               onChange="changeStatus('<?php echo $rowList['id']; ?>')">
                                                        <span class="custom-switch-indicator"></span> </label></td>
                                                <td>

                                                    <button class="btn btn-sm <?php if($rowList['liked']==1) { echo 'btn-success';}else{echo 'btn-light';} ?>"
                                                            onclick="likeStory(<?php echo $rowList['id'] ?>,this);">
                                                        <i class="fa <?php if($rowList['liked']==1) { echo 'fa-thumbs-up';}else{echo 'fa-thumbs-up';} ?>"></i>
                                                    </button>
                                                    <a href="<?= $awardsUrl ?>story-detail/<?php echo $rowList['id']; ?>"
                                                       target="_blank"
                                                       class="btn btn-sm btn-icon btn-info table-button"><i
                                                                class="fas fa-eye"></i> </a>
                                                    <a href="<?= $adminUrl ?>edit-story.php?s_id=<?php echo $rowList['id']; ?>&p_id=<?php echo $_GET['n_id']; ?>"
                                                       target="_blank"
                                                       class="btn btn-sm btn-icon btn-warning table-button"><i
                                                                class="fas fa-edit"></i> </a>
                                                    <button class="btn btn-sm btn-danger"
                                                            onclick="showConfDialog(<?= $rowList['id'] ?>);"><i
                                                                class="fa fa-trash"></i></button>

                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
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
<div id="winnerModal" class="modal fade">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Declare Winner</h6>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label>Winner</label>
                        <select name="winner" id="winner" class="form-control" required>
                            <option value="" selected disabled>-- Select --</option>
                            <?php
                            foreach ($users as $u)
                            {
                                ?>
                            <option data-id="<?php echo $u['id'] ?>" value="<?php echo $u['email'] ?>"><?php echo $u['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <!-- MODAL-BODY -->
            <div class="modal-footer">
                <input type="hidden" name="id" id="d_id">
                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                <button id="addLoader" type="button" class="btn btn-danger" onclick="declareWinner()">Save Winner</button>
            </div>
        </div>
    </div>
    <!-- MODAL-DIALOG -->
</div>

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

<div id="NominationModal" class="modal fade">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Nomination</h6>
            </div>
            <div class="modal-body">
                <div class="prompt"></div>
                <p>Are you sure you want to delete this nomination?</p>
            </div>
            <!-- MODAL-BODY -->
            <div class="modal-footer">
                <input type="hidden" name="id" id="n_id">
                <button type="button" class="btn btn-light" data-dismiss="modal"
                        onclick="$('#NominationModal').hide(); $('#n_id').val('');">Cancel
                </button>
                <button id="addLoader" type="button" class="btn btn-danger" onClick="delNomiation()">Delete</button>
            </div>
        </div>
    </div>
    <!-- MODAL-DIALOG -->
</div>

<div id="AssignToken" class="modal fade">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Assign Token</h6>
            </div>
            <div class="modal-body">
                <div class="prompt"></div>
                <p>Please give points according to the story posted by the user. If you don't like the story please leave the checkboxes uncheck.</p>

                <select class="form-control" name="rating" id="rating">
                    <option value="-">-- Select Token --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="2">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <!-- MODAL-BODY -->
            <div class="modal-footer">
                <input type="hidden" name="id" id="s_id">
                <button type="button" class="btn btn-light" data-dismiss="modal" onclick="$('#AssignToken').hide(); $('#s_id').val(''); $('#rating').val(''); ">Cancel</button>
                <button id="addLoader" type="button" class="btn btn-danger"
                        onClick="assignStoryToken(document.getElementById('s_id').value)">Assign Token
                </button>
            </div>
        </div>
    </div>
    <!-- MODAL-DIALOG -->
</div>

<?php include_once("includes/script.php"); ?>


<script>
    $(document).ready(function () {

        $('#categoryTable').dataTable();
    });

    function AssignToken(id){
        $("#AssignToken").modal();
        $("#s_id").val(id);
    }
    function showConfDialog(id) {
        $("#NominationModal").show();
        $("#n_id").val(id);
    }

    function assignStoryToken(id){
        var token = $("#rating").val();
        $.ajax({
            type: "POST",
            url: "ajax.php?h=assignToken",
            data: {id: id , token : token},
            dataType: 'json',
            beforeSend: function () {
                $("#AssignToken #addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
                $("#AssignToken #addLoader").prop('disabled',true)

            },
            success: function (data) {
                $( "#AssignToken #addLoader" ).html('Assign Token')
                $("#AssignToken #addLoader").prop('disabled',false)

                if ( data.Success == 'true' ) {
                    window.location.reload();
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning pr-2"> </i>"' + res.error + '</div>');
                }
            }, error: function (e) {
                console.log(e);
            }
        });
    }
    function delNomiation() {
        $.ajax({
            type: "POST",
            url: "http://ourcanadadev.site/superadmin/ajax.php?h=deleteNomination",
            data: {id: $("#n_id").val()},
            dataType: 'json',
            beforeSend: function () {
                $("#NominationModal #addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
            },
            success: function (res) {
                console.log(res)
                if (res.success) {
                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check pr-2"> </i>' + res.success + '</div>');
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning pr-2"> </i>"' + res.error + '</div>');
                }
            }, error: function (e) {
                console.log(e);
            }
        });
    }
    function likeStory(id,e) {

        $(e).html('<i class="fa fa-spinner fa-spin"></i>');
        $(e).prop('disabled',true)
        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=likeStory",
            method: "POST",
            data: {id: id},
            success: function (data) {
                $('.prompt').show()
                $(window).scrollTop(0)
                $(e).prop('disabled',false)
                if (data.Success === 'true') {
                    $(e).html('<i class="fa fa-thumbs-up"></i>')
                    $(e).removeAttr('class')
                    let newClass='btn btn-sm btn-light'
                    if(data.s==1)
                    {
                        newClass='btn btn-sm btn-success'
                    }
                    else
                    {
                        newClass='btn btn-sm btn-light'
                    }
                    $(e).addClass(newClass)
                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check>"</i>' + data.Msg + '</div>');
                } else {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning"></i>' + data.Msg + '</div>');
                }
                setTimeout(function() { $(".prompt").html('')}, 2000);

            }
        });

    };
    function changeStatus(id) {

        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=storyStatus",
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
    function declareWinner() {

        $("#addLoader").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
        $("#addLoader").prop('disabled',true)

            var winner=$('#winner').val()
        var award='<?php echo $_GET['n_id']; ?>';
        var name=$( "#winner option:selected" ).text();
        var url_id = $('#winner option:selected').attr('data-id');

        $.ajax({
            dataType: 'json',
            url: 'ajax.php?h=addWinner',
            type: 'POST',
            data: {'winner':winner,'award':award,'name':name,'url_id':url_id},
            success: function (data) {
                $("#addLoader").html('Submit');
                $("#addLoader").prop('disabled',false)

                if (data.Success == 'true') {
                        window.location.assign("winner-listing.php");
                }
                else
                {
                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning>"</i>' + data.Msg + '</div>');
                }
            }
        });


    };

    $(document).ready(function () {


        $('.get_value').each(function () {
            if ($(this).val() == 1) {
                $(this).attr('checked', 'checked');
            } else {
                $(this).removeAttr('checked');
            }
        });

    });

</script>
</body>
</html>
