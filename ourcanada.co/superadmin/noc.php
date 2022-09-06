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
                            <h4 class="mb-0 font-size-18">NOCs</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Lingual</a></li>
                                    <li class="breadcrumb-item active">NOC</li>
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

                                    <div class="table-responsive">
                                        <div class="row" >
                                            <h3 class="col-sm-12">Positions</h3>
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
                                            </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="table-responsive">
                                        <div class="row" >
                                            <h3 class="col-sm-12">Duties</h3>
                                        </div>
                                        <table id="datatable2" class="table table-bordered " style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                url: 'ajax.php?h=getPos',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "id" },
                { data: "job_position" },
                { data: "job_position_french" },
                { data: "job_position_spanish" },
                { data: "job_position_urdu" },
                { data: "job_position_chinese" },
                { data: "job_position_hindi" },
                { data: "job_position_punjabi" },
                { data: "job_position_arabic" },
                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
        var table2= $('#datatable2').DataTable( {
            ajax: {
                url: 'ajax.php?h=getPos',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "id" },
                { data: "job_duty" },
                { data: "job_duty_french" },
                { data: "job_duty_spanish" },
                { data: "job_duty_urdu" },
                { data: "job_duty_chinese" },
                { data: "job_duty_hindi" },
                { data: "job_duty_punjabi" },
                { data: "job_duty_arabic" },
                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );


    });
    $( '#EvalidateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoaderE').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=updateNoc",
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


