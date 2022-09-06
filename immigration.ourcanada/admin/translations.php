<?php
include_once( "admin_inc.php" );


?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>



<body data-topbar="dark" data-layout="horizontal">

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

                        </div>
                    </div>
                </div>


                <!-- /.modal -->

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
                                <div class="card-title"><h3>Static Label</h3></div>

                                <table id="datatable4" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                <div class="card-title"><h3>Options</h3></div>

                                <table id="datatable5" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>English</th>
                                        <th>French</th>
                                        <th>Urdu</th>
                                        <th>Spanish</th>
                                        <th>Chinese</th>
                                        <th>Punjabi</th>
                                        <th>Hindi</th>

                                    </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->



        <?php include_once("includes/footer.php"); ?>

    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->



<?php include_once("includes/script.php"); ?>
<link href="assets/css/select2.min.css" rel="stylesheet">
<script src="assets/js/select2.full.min.js"></script>
<script src="assets/js/select2-init.js"></script>

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

                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
        $('#datatable4').DataTable( {
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
                { data: "label_urdu" },
                { data: "label_spanish" },
                { data: "label_chinese" },
                { data: "label_punjabi" },
                { data: "label_hindi" },

                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );
        $('#datatable5').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadOptions',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "label" },
                { data: "label_french" },
                { data: "label_urdu" },
                { data: "label_spanish" },
                { data: "label_chinese" },
                { data: "label_punjabi" },
                { data: "label_hindi" },

                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );

    });

</script>
</body>

</html>