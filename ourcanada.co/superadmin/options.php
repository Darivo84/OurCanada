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
                            <h4 class="mb-0 font-size-18">Static Labels</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Lingual</a></li>
                                    <li class="breadcrumb-item active">Static Labels</li>
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
                                <?php if($_GET['method'] == 'edit'){
                                    $getID = $_GET['id'];
                                    $table = $_GET['table'];

                                    $getLabels = mysqli_query($conn , "SELECT * FROM $table  WHERE id = '$getID'");
                                    $fetchLabels = mysqli_fetch_assoc($getLabels);

                                    ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <!--                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#pagesModal"  style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add Page</a>-->

                                        </div>
                                    </div>
                                    <form method="post" id="EvalidateForm">
                                        <div class="prompt"></div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group" >
                                                    <label for="title">English</label>
                                                    <input type="text" class="form-control ques" name="n[label]" placeholder="English" value="<?php echo $fetchLabels['label']; ?>" required="">


                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Francais/French</label>
                                                    <input type="text" class="form-control ques" name="n[label_french]" placeholder="Francais/French" value="<?php echo $fetchLabels['label_french']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Spanish</label>
                                                    <input type="text" class="form-control ques" name="n[label_spanish]" placeholder="Spanish" value="<?php echo $fetchLabels['label_spanish']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Urdu</label>
                                                    <input type="text" class="form-control ques" name="n[label_urdu]" placeholder="Urdu" value="<?php echo $fetchLabels['label_urdu']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Chinese</label>
                                                    <input type="text" class="form-control ques" name="n[label_chinese]" placeholder="Chinese" value="<?php echo $fetchLabels['label_chinese']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Hindi</label>
                                                    <input type="text" class="form-control ques" name="n[label_hindi]" placeholder="Hindi" value="<?php echo $fetchLabels['label_hindi']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Punjabi</label>
                                                    <input type="text" class="form-control ques" name="n[label_punjabi]" placeholder="Punjabi" value="<?php echo $fetchLabels['label_punjabi']; ?>">

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="title">Arabic</label>
                                                    <input type="text" class="form-control ques" name="n[label_arabic]" placeholder="Arabic" value="<?php echo $fetchLabels['label_arabic']; ?>">

                                                </div>
                                            </div>
                                        </div>



                                        <input type="hidden" name="id" value="<?php echo $getID; ?>">
                                        <input type="hidden" name="table" value="<?php echo $table; ?>">

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update</button>
                                        </div>
                                    </form>

                                <?php }
                                else { ?>
                                    <div class="card">

                                        <div class="card-title">Filter</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="filter">
                                                        <option value="All" selected>All</option>
                                                        <option value="Done" >Done</option>
                                                        <option value="Pending" >Pending</option>
                                                        <option value="Will do later" >Will do later</option>

                                                    </select>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a href="?method=add" style="padding: 7px; margin-bottom: 15px; float: right;" class="btn btn-primary waves-effect waves-light btn-sm">Add New</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="row" style="float: right;margin: 0">

                                        </div>
                                        <table id="datatable" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>English</th>
                                                <th>Francais/French</th>
                                                <th>Spanish</th>
                                                <th>Urdu</th>
                                                <th>Chinese</th>
                                                <th>Hindi</th>
                                                <th>Punjabi</th>
                                                <th>Arabic</th>

                                                <th>Page</th>
                                                <th>Status</th>
                                                <th>Updated By</th>
                                                <th>Updated Date</th>
                                                <th>Created Date</th>
                                                <th>Action</th>

                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>

                                    </div>
                                <?php } ?>
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
    $(document).ready( function () {


        var table= $('#datatable').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadLabels',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "id" },
                { data: "label" },
                { data: "label_french" },
                { data: "label_spanish" },
                { data: "label_urdu" },
                { data: "label_chinese" },
                { data: "label_hindi" },
                { data: "label_punjabi" },
                { data: "label_arabic" },

                { data: "page" },
                { data: "status" },
                { data: "updated_by" },
                { data: "updated_date" },
                { data: "created_date" },
                { data: "action2" },


                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
        $('#filter').on('change', function () {
            if(this.value=='All')
            {
                table.columns(9).search('').draw();

            }
            else
            {
                table.columns(9).search( this.value ).draw();
            }
        } );
        $('#page_filter').on('change', function () {
            if(this.value=='All')
            {
                table.columns(8).search('').draw();

            }
            else
            {
                table.columns(8).search( this.value ).draw();
            }
        } );
    });
    $( '#EvalidateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoaderE').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=updateOptions",
                type: 'POST',
                data: $( "#EvalidateForm" ).serialize(),
                success: function ( data ) {
                    $( "#AddLoaderE" ).html( 'Submit' );
                    $('#AddLoaderE').attr('disabled',false)

                    $( "div.prompt" ).show();
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                           // window.location.assign('/superadmin/static_labels2')
                        }, 1500 );
                    } else {
                        $( window ).scrollTop( 0 );
                        $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                        setTimeout( function () {
                            $( "div.prompt" ).hide();
                        }, 5000 );

                    }

                }
            } );

            return false;
        }
    } );


</script>
</body>
</html>

