<?php

include_once("admin_inc.php");


?>

<!doctype html>

<html lang="en">



<head>



    <meta charset="utf-8" />



    <?php include_once("includes/style.php"); ?>



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

                            <h4 class="mb-0 font-size-18">Comments</h4>



                            <div class="page-title-right">

                                <ol class="breadcrumb m-0">

                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Stories</a></li>

                                    <li class="breadcrumb-item active">Comments List</li>

                                </ol>

                            </div>



                        </div>

                    </div>

                </div>

                <!-- end page title -->

                <?php

                {



                    $select=mysqli_query($conn,"Select n.title,u.firstname,u.lastname,u.profileimg,u.gender,c.* from awards_comments as c join users as u on c.user_id=u.id join nominated_users_list as n on c.item_id=n.id where c.item_type='story' ORDER BY c.id DESC");

                    ?>



                    <div class="row">



                        <div class="col-lg-12">

                            <div class="card">

                                <div class="card-body">

                                    <!--                                    <a href="add-moderator.php" style="padding: 7px;margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Moderator</a>-->

                                    <br>

                                    <br>

                                    <div class="table-responsive">





                                        <table id="categoryTable" class="table table-centered table-nowrap table-hover">

                                            <thead class="thead-light">



                                            <tr>

                                                <th scope="col" style="width: 100px">#</th>



                                                <th scope="col">Story</th>

                                                <th scope="col">User</th>

                                                <th scope="col">Comment</th>

                                                <th scope="col">Status</th>

                                                <th scope="col">Action</th>

                                            </tr>

                                            </thead>

                                            <tbody>

                                            <?php

                                            $count=1;

                                            while ( $row = mysqli_fetch_array( $select ) ) {

                                                ?>

                                                <tr>

                                                    <td><span><?php echo $count ?></span></td>



                                                    <td><?php echo $row[ "title" ]?></td>

                                                    <td><?php echo $row[ "firstname" ].' '.$row['lastname']?></td>

                                                    <td><?php $com=$row[ "comment" ]; if(strlen($com) > 40) { $com=substr($row[ "comment" ],0,40);  } echo $com;?></td>

                                                    <td>

                                                        <?php  if($row["status"]==1) {  ?>

                                                        <button class="btn btn-success btn-sm" title="Approved"><i class="fa fa-check"></i></button>

                                                        <?php } else { ?>

                                                        <label class="custom-switch">

                                                            <input value="<?php echo $row["status"]; ?>" type="checkbox" name="custom-switch-checkbox" class="get_value custom-switch-input" onChange="changeStatus('<?php echo $row['id']; ?>',this)">

                                                            <span class="custom-switch-indicator"></span>

                                                        </label>

                                                        <?php } ?>



                                                    </td>



                                                    <td>

                                                        <button id="view" class="btn btn-sm btn-icon btn-warning table-button" onclick="showComment('<?php echo $row['comment']; ?>','<?php echo $row['title']; ?>')">

                                                            <i class="fa fa-eye"></i>

                                                        </button>

                                                        <button id="deletebtn" class="btn btn-sm btn-icon btn-danger table-button" onclick="delComment('<?php echo $row['id']; ?>')" data-toggle="modal" data-target="#smallModal">

                                                            <i class="fa fa-trash"></i>

                                                        </button>



                                                    </td>

                                                </tr>



                                                <?php $count++; } ?>







                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

                <!-- end row -->



                <!--    <div class="row">

                        <div class="col-12">

                            <div class="text-center my-3">

                                <a href="javascript:void(0);" class="text-success"><i class="bx bx-loader bx-spin font-size-18 align-middle mr-2"></i> Load more </a>

                            </div>

                        </div>

                    </div>

                     end row -->



            </div> <!-- container-fluid -->

        </div>

        <!-- End Page-content -->





        <?php include_once("includes/footer.php"); ?>

    </div>

    <!-- end main content-->



</div>

<!-- END layout-wrapper -->





<!-- Right bar overlay-->

<div class="rightbar-overlay"></div>

<!-- Delete Modal -->

<div id="smallModal" class="modal fade">

    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Delete Comment</h6>



            </div>

            <div class="modal-body">



                <div class="prompt"></div>

                <p>Are you sure you want to delete this comment?</p>

            </div>

            <!-- MODAL-BODY -->

            <div class="modal-footer">

                <input type="hidden" name="mod_id" id="d_id">

                <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>

                <button id="addLoader" type="button" class="btn btn-danger" onClick="deletemdoerator(document.getElementById('d_id').value)">Delete</button>



            </div>

        </div>

    </div>

    <!-- MODAL-DIALOG -->

</div>

<div id="smallModal2" class="modal fade">

    <div class="modal-dialog modal-md" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold mt-2">Full Comment</h6>



            </div>

            <div class="modal-body" id="commentView">



            </div>

            <!-- MODAL-BODY -->

            <div class="modal-footer">

                <input type="hidden" name="mod_id" id="d_id">

                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>

            </div>

        </div>

    </div>

    <!-- MODAL-DIALOG -->

</div>





<?php include_once("includes/script.php"); ?>

<script>

    $(document).ready( function () {



        $('#categoryTable').dataTable();

    } );



</script>



<script>

    function showComment(com,title) {

        $('#title').html(title)



        $('#commentView').html(com)

        $('#smallModal2').modal()

    }

    function delComment(id)

    {

        $('#d_id').val(id);

    }

    function deletemdoerator(id){

        $( "#addLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $("#addLoader").prop('disabled',true)


        $.ajax( {

            dataType: 'json',

            url: "ajax.php?h=delComment",

            type: 'POST',

            data: {id : id},

            success: function ( data ) {
                $( "#addLoader" ).html('Delete')
                $("#addLoader").prop('disabled',false)

                if ( data.Success == 'true' )

                {

                    $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');

                    setTimeout(function() {location.reload();}, 500);

                } else

                {

                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');

                }

            }

        } );

    }



    function changeStatus(id,e){



        $.ajax({

            dataType: 'json',

            url:"ajax.php?h=approveComment",

            method:"POST",

            data:{id:id},

            success: function ( data ) {

                if ( data.Success === 'true' )

                {

                    $(e).parent().parent().html('<button class="btn btn-success btn-sm" title="Approved"><i class="fa fa-check"></i></button>')

                } else

                {

                    $(".prompt").html('<div class="alert alert-warning"><i class="fa fa-warning></i>"'+data.Msg+'</div>');

                }

            }

        });



    };



</script>









</body>



</html>

