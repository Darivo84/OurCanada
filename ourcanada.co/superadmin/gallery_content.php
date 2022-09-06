<?php
include_once( "admin_inc.php" );
if ( $_SESSION[ 'role' ] == 'admin' ) {

} else {
    header( "location:login.php" );
}
if(isset($_POST['img_id'])){
    $s = mysqli_query($conn,"SELECT * FROM gallery_images WHERE id = ".$_POST['img_id']);
    $r = mysqli_fetch_assoc($s);
    unlink('../community/uploads/gallery/'.$r['image']);
    $c = mysqli_query($conn,"DELETE FROM gallery_images WHERE id = ".$_POST['img_id']);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <?php include_once("includes/style.php"); ?>
    <link href="assets/libs/dropzone/min/dropzone.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/dropzone/min/dropzone.js"></script>
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

<body data-sidebar="dark">
<div id="layout-wrapper">
    <?php include_once("includes/header.php"); ?>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-size-18">Gallery</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Gallery</a></li>
                                    <li class="breadcrumb-item active">Images Listing</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(isset($c)){ ?>
                                <p class="alert alert-success">Image delete successfully.</p>
                            <?php } ?>
                            <div class="card">
                                <div class="card-body">
                                    <a onclick="file_modal();" href="javascript:void(0)" style="padding: 7px; margin-bottom: 15px;margin-right:7px; float: right" class="btn btn-success waves-effect waves-light btn-sm">Add Image</a>
                                    <br><br>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table table-centered table-nowrap table-hover" style="width: 100%;">
                                            <thead class="thead-light">
                                            <tr>
                                                <th scope="col" style="width: 100px">#</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $query = "SELECT * FROM `gallery_images` ORDER BY id DESC";
                                            $result = mysqli_query($conn, $query);
                                            $count = 1;

                                            while($row = mysqli_fetch_assoc($result)){ ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td align="center">
                                                        <img src="https://ourcanada<?php echo $ext ?>/community/uploads/gallery/<?= $row['image'] ?>" style="width: 150px;">
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="del_ling(<?php echo $row['id']; ?>);" class="text-danger">
                                                            <i class="fa fa-trash"></i>&nbsp;Delete
                                                        </a>
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

            </div>
        </div>
        <?php include_once("includes/footer.php"); ?>
    </div>
</div>
<div class="rightbar-overlay"></div>
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <form class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Image</h5>
            </div>
            <div class="modal-body"> 
                <input type="file" name="file" id="gallery_img" required>
                <p class="img_error text-danger"></p>
                <p class="img_success text-success"></p>
            </div>
            <div class="modal-footer"> 
                <a type="button" class="btn btn-danger closee text-white" data-dismiss="modal">Close</a> 
                <button type="submit" class="btn btn-success" style="color: white;" id="upload_img">Upload</button> 
            </div>
        </div>
    </form>
</div>
<div class="modal fade" id="delete_lingual_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="POST" action="gallery_content.php">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Delete Image</h5>
            </div>
            <div class="modal-body"> Are you sure, you want to delete image?
                <input id="img_id" name="img_id" type="hidden">
            </div>
            <div class="modal-footer"> <a type="button" class="btn btn-danger text-white closee" data-dismiss="modal">No</a> <button type="submit" class="btn btn-success" style="color: white;" id="delBtn">Yes</button> </div>
        </form>
    </div>
</div>

<?php include_once("includes/script.php"); ?>
<script>
    setTimeout(function(){
        $(".alert").remove();
    },3000);
    $("#delete_lingual_modal form").submit(function(){
        $(this).find(".btn-success").text("Please wait...");
        $(this).find(".btn-success").prop("disabled",true);
    });

    function del_ling(id){
        $("#delete_lingual_modal").modal();
        $("#delete_lingual_modal #img_id").val(id);
    }

    function file_modal(){
        $("#upload_modal").modal();
    }
    $("#upload_modal form").submit(function(e){
        e.preventDefault();
        var from = $(this);
        if($("#gallery_img").val() != ""){
            $.ajax({
                type: "POST",
                url: "ajax.php?h=gallery_image",
                data: new FormData(from[0]),
                enctype: 'multipart/form-data',
                dataType: "json",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(res){
                    from.find('.btn-success').html("Please wait...");
                    from.find('.btn-success').prop("disabled",true);
                    $(".img_error").text("");
                },
                success: function(res){
                    console.log(res);
                    if(res.Msg){
                        from.find('.btn-success').html("Upload");
                        from.find('.btn-success').prop("disabled",false);
                        $(".img_error").text(res.Msg);
                    }else{
                        $(".img_error").text("");
                    }
                    if(res.path){
                        $(".img_success").text("Image uploaded successfully");
                        setTimeout(function(){
                            window.location.reload();
                        },3000);
                    }
                }
            });
        }
    });
    $(document).ready( function () {


        var table= $('#datatable').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadGalleryContent',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "count" },
                { data: "image" },
                { data: "action" },


                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );

    });

</script>

</body>
</html>
