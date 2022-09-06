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
                            <h4 class="mb-0 font-size-18">Questions/Notes</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Multi Lingual</a></li>
                                    <li class="breadcrumb-item active">Questions/Notes</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mx-auto"></div>
                </div>
                <?php if($_GET['method'] == 'edit'){
                    $getID = $_GET['id'];
                    $getType= $_GET['type'];
                    $getLabels='';
                    $column_name='';
                    $table='';
                    if($getType=='ques')
                    {
                        $getLabels = mysqli_query($conn , "SELECT * FROM questions WHERE id = '$getID'");
                        $column_name='question';
                        $table='questions';
                    }
                    else if($getType=='subques')
                    {
                        $getLabels = mysqli_query($conn , "SELECT * FROM sub_questions WHERE id = '$getID'");
                        $column_name='question';
                        $table='sub_questions';

                    }
                    else if($getType=='notes')
                    {
                        $getLabels = mysqli_query($conn , "SELECT * FROM questions WHERE id = '$getID'");
                        $column_name='notes';
                        $table='questions';

                    }
                    else if($getType=='subnotes')
                    {
                        $getLabels = mysqli_query($conn , "SELECT * FROM sub_questions WHERE id = '$getID'");
                        $column_name='notes';
                        $table='sub_questions';
                    }
                    $fetchLabels = mysqli_fetch_assoc($getLabels);

                    ?>
                    <form method="post" id="EvalidateForm">
                        <div class="prompt"></div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">English</label>
                                    <textarea  readonly class="form-control ques" rows="4" value=""><?php echo $fetchLabels[$column_name]; ?></textarea>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Francais/French</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_french]" rows="4" placeholder="Francais/French" value=""><?php echo $fetchLabels[$column_name.'_french']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Spanish</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_spanish]" rows="4" placeholder="Spanish" value=""><?php echo $fetchLabels[$column_name.'_spanish']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Urdu</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_urdu]" rows="4" placeholder="Urdu" value=""><?php echo $fetchLabels[$column_name.'_urdu']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Chinese</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_chinese]" rows="4" placeholder="Chinese" value=""><?php echo $fetchLabels[$column_name.'_chinese']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Hindi</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_hindi]" rows="4" placeholder="Hindi" value=""><?php echo $fetchLabels[$column_name.'_hindi']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Punjabi</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_punjabi]"  rows="4" placeholder="Punjabi" value=""><?php echo $fetchLabels[$column_name.'_punjabi']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Arabic</label>
                                    <textarea type="text" class="form-control ques" name="n[<?php echo $column_name ?>_arabic]"  rows="4" placeholder="Arabic" value=""><?php echo $fetchLabels[$column_name.'_arabic']; ?></textarea>
                                </div>
                            </div>
                        </div>



                        <input type="hidden" name="id" value="<?php echo $getID; ?>">
                        <input type="hidden" name="type" value="<?php echo $getType; ?>">
                        <input type="hidden" name="table" value="<?php echo $table; ?>">

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update</button>
                        </div>
                    </form>

                <?php } else { ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title"><h3>Questions</h3></div>

                                    <table id="datatable1" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>English</th>
                                            <th>French</th>
                                            <th>Urdu</th>
                                            <th>Spanish</th>
                                            <th>Chinese</th>
                                            <th>Punjabi</th>
                                            <th>Hindi</th>
                                            <th>Arabic</th>

                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card-title"><h3>Sub Questions</h3></div>

                                    <table id="datatable2" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>English</th>
                                            <th>French</th>
                                            <th>Urdu</th>
                                            <th>Spanish</th>
                                            <th>Chinese</th>
                                            <th>Punjabi</th>

                                            <th>Hindi</th>
                                            <th>Arabic</th>
                                            <th>Action</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="card-title"><h3>Notes</h3></div>

                                    <table id="datatable3" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>English</th>
                                            <th>French</th>
                                            <th>Urdu</th>
                                            <th>Spanish</th>
                                            <th>Chinese</th>
                                            <th>Punjabi</th>
                                            <th>Hindi</th>
                                            <th>Arabic</th>

                                            <th>Action</th>


                                        </tr>
                                        </thead>
                                        <tbody>


                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php include_once("includes/footer.php"); ?>
    </div>
</div>

<div class="rightbar-overlay"></div>
<?php include_once("includes/script.php"); ?><br>
<script>
    $(document).ready( function () {


        $('#datatable1').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadQuestions',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "id" },
                { data: "question" },
                { data: "question_french" },
                { data: "question_urdu" },
                { data: "question_spanish" },
                { data: "question_chinese" },
                { data: "question_punjabi" },
                { data: "question_hindi" },
                { data: "question_arabic" },

                { data: "action" },

                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
        $('#datatable2').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadSubQuestions',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "id" },
                { data: "question" },
                { data: "question_french" },
                { data: "question_urdu" },
                { data: "question_spanish" },
                { data: "question_chinese" },
                { data: "question_punjabi" },
                { data: "question_hindi" },
                { data: "question_arabic" },

                { data: "action" },

                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
        $('#datatable3').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadNotes',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "id" },
                { data: "notes" },
                { data: "notes_french" },
                { data: "notes_urdu" },
                { data: "notes_spanish" },
                { data: "notes_chinese" },
                { data: "notes_punjabi" },
                { data: "notes_hindi" },
                { data: "notes_arabic" },

                { data: "action" },

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
                url: "ajax.php?h=updateQues_Notes",
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
                            $( "div.prompt" ).hide();
                        }, 5000 );
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


