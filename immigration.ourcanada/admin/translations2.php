<?php
include_once( "admin_inc.php" );

$optionsArray = array();
$get = mysqli_query($conn , "SELECT *  FROM question_labels  WHERE  label_french='' or label_french is null or label_spanish='' or label_spanish is null or label_urdu='' or label_urdu is null or label_chinese='' or label_chinese is null or label_hindi='' or label_hindi is null or label_punjabi='' or label_punjabi is null ");

while($row = mysqli_fetch_assoc($get)){
    if(!in_array($row['label'],$optionsArray))
    {
        $p['english']=$row['label'];
        $p['french']=$row['label_french'];
        $p['urdu']=$row['label_urdu'];
        $p['chinese']=$row['label_chinese'];

        $p['punjabi']=$row['label_punjabi'];
        $p['hindi']=$row['label_hindi'];
        $optionsArray[]=$p;

    }
}

$get = mysqli_query($conn , "SELECT *  FROM level1  WHERE  label_french='' or label_french is null or label_spanish='' or label_spanish is null or label_urdu='' or label_urdu is null or label_chinese='' or label_chinese is null or label_hindi='' or label_hindi is null or label_punjabi='' or label_punjabi is null ");

while($row = mysqli_fetch_assoc($get)){
    if(!in_array($row['label'],$optionsArray))
    {
        $p['english']=$row['label'];
        $p['french']=$row['label_french'];
        $p['urdu']=$row['label_urdu'];
        $p['spanish']=$row['label_urdu'];
        $p['chinese']=$row['label_chinese'];

        $p['punjabi']=$row['label_punjabi'];
        $p['hindi']=$row['label_hindi'];
        $optionsArray[]=$p;

    }
}
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

                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th width="30%">English</th>
                                        <th>French</th>
                                        <th>Urdu</th>
                                        <th>Spanish</th>
                                        <th>Chinese</th>
                                        <th>Punjabi</th>
                                        <th>Hindi</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '10' and (question_french='' or question_french is null or question_spanish='' or question_spanish is null or question_urdu='' or question_urdu is null or question_chinese='' or question_chinese is null or question_hindi='' or question_hindi is null or question_punjabi='' or question_punjabi is null )");

                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        ?>

                                        <tr>
                                            <td><?php echo $Row['id']; ?></td>
                                            <td width="30%"><?php echo '"'.$Row['question'].'"'; ?></td>
                                            <td><?php echo $Row['question_french'] ?></td>
                                            <td><?php echo $Row['question_urdu'] ?></td>
                                            <td><?php echo $Row['question_spanish'] ?></td>
                                            <td><?php echo $Row['question_chinese'] ?></td>
                                            <td><?php echo $Row['question_punjabi'] ?></td>
                                            <td><?php echo $Row['question_hindi'] ?></td>

                                        </tr>
                                    <?php  } ?>
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

                                <table id="datatable1" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th width="30%">English</th>
                                        <th>French</th>
                                        <th>Urdu</th>
                                        <th>Spanish</th>
                                        <th>Chinese</th>
                                        <th>Punjabi</th>
                                        <th>Hindi</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id WHERE q.form_id = '10' and (s.question_french='' or s.question_french is null or s.question_spanish='' or s.question_spanish is null or s.question_urdu='' or s.question_urdu is null or s.question_chinese='' or s.question_chinese is null or s.question_hindi='' or s.question_hindi is null or s.question_punjabi='' or s.question_punjabi is null )");

                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        ?>

                                        <tr>
                                            <td><?php echo $Row['id']; ?></td>
                                            <td width="30%"><?php echo '"'.$Row['question'].'"'; ?></td>
                                            <td><?php echo $Row['question_french'] ?></td>
                                            <td><?php echo $Row['question_urdu'] ?></td>
                                            <td><?php echo $Row['question_spanish'] ?></td>
                                            <td><?php echo $Row['question_chinese'] ?></td>
                                            <td><?php echo $Row['question_punjabi'] ?></td>
                                            <td><?php echo $Row['question_hindi'] ?></td>


                                        </tr>
                                    <?php  } ?>
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

                                <table id="datatable2" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th width="30%">English</th>
                                        <th>French</th>
                                        <th>Urdu</th>
                                        <th>Spanish</th>
                                        <th>Chinese</th>

                                        <th>Punjabi</th>
                                        <th>Hindi</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT *  FROM questions  WHERE form_id = '10' and (notes_french='' or notes_french is null or notes_spanish='' or notes_spanish is null or notes_urdu='' or notes_urdu is null or notes_chinese='' or notes_chinese is null or notes_hindi='' or notes_hindi is null or notes_punjabi='' or notes_punjabi is null )");

                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        if($Row['notes']!=='' & $Row['notes']!==null)
                                        {


                                            ?>

                                            <tr>
                                                <td><?php echo $Row['id']; ?></td>
                                                <td width="30%"><?php echo '"'.$Row['notes'].'"'; ?></td>
                                                <td><?php echo $Row['notes_french'] ?></td>
                                                <td><?php echo $Row['notes_urdu'] ?></td>
                                                <td><?php echo $Row['notes_spanish'] ?></td>
                                                <td><?php echo $Row['notes_chinese'] ?></td>
                                                <td><?php echo $Row['notes_punjabi'] ?></td>
                                                <td><?php echo $Row['notes_hindi'] ?></td>
                                            </tr>
                                        <?php  } } ?>

                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id WHERE q.form_id = '10' and (s.notes_french='' or s.notes_french is null or s.notes_spanish='' or s.notes_spanish is null or s.notes_urdu='' or s.notes_urdu is null or s.notes_chinese='' or s.notes_chinese is null or s.notes_hindi='' or s.notes_hindi is null or s.notes_punjabi='' or s.notes_punjabi is null )");

                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        if($Row['notes']!=='' & $Row['notes']!==null)
                                        {
                                            ?>

                                            <tr>
                                                <td><?php echo $Row['id']; ?></td>
                                                <td width="30%"><?php echo '"'.$Row['notes'].'"'; ?></td>
                                                <td><?php echo $Row['notes_french'] ?></td>
                                                <td><?php echo $Row['notes_urdu'] ?></td>
                                                <td><?php echo $Row['notes_spanish'] ?></td>
                                                <td><?php echo $Row['notes_chinese'] ?></td>
                                                <td><?php echo $Row['notes_punjabi'] ?></td>
                                                <td><?php echo $Row['notes_hindi'] ?></td>
                                            </tr>
                                        <?php  } } ?>

                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT *  FROM score_questions  WHERE comments!='' and comments is not null");

                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                    ?>

                                                                            <tr>
                                                                                <td><?php echo $Row['id'].'-scoring'; ?></td>
                                                                                <td width="30%"><?php echo $Row['comments']; ?></td>
                                                                                <td><?php echo $Row['comments_french'] ?></td>
                                                                                <td><?php echo $Row['comments_urdu'] ?></td>
                                                                                <td><?php echo $Row['comments_spanish'] ?></td>
                                                                                <td><?php echo $Row['comments_chinese'] ?></td>
                                                                                <td><?php echo $Row['comments_hindi'] ?></td>
                                                                                <td><?php echo $Row['comments_punjabi'] ?></td>

                                                                            </tr>
                                    <?php  } ?>

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

                                <table id="datatable3" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th width="30%">English</th>
                                        <th>French</th>
                                        <th>Urdu</th>
                                        <th>Spanish</th>
                                        <th>Chinese</th>
                                        <th>Punjabi</th>
                                        <th>Hindi</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM static_labels where label_french='' or label_french is null or label_spanish='' or label_spanish is null or label_urdu='' or label_urdu is null or label_chinese='' or label_chinese is null or label_hindi='' or label_hindi is null or label_punjabi='' or label_punjabi is null  ");

                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        ?>

                                        <tr>
                                            <td><?php echo $Row['id']; ?></td>
                                            <td width="30%"><?php echo '"'.$Row['label'].'"'; ?></td>
                                            <td><?php echo $Row['label_french'] ?></td>
                                            <td><?php echo $Row['label_urdu'] ?></td>
                                            <td><?php echo $Row['label_spanish'] ?></td>
                                            <td><?php echo $Row['label_chinese'] ?></td>
                                            <td><?php echo $Row['label_punjabi'] ?></td>
                                            <td><?php echo $Row['label_hindi'] ?></td>
                                        </tr>
                                    <?php  } ?>

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

                                <table id="datatable4" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th width="30%">English</th>
                                        <th>French</th>
                                        <th>Urdu</th>
                                        <th>Spanish</th>
                                        <th>Chinese</th>
                                        <th>Punjabi</th>
                                        <th>Hindi</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php

                                    foreach($optionsArray as $o){
                                        if($o['english']!=='' & $o['english']!==null)
                                        {
                                            ?>

                                            <tr>
                                                <td width="30%"><?php echo '"'.$o['english'].'"'; ?></td>
                                                <td><?php echo $o['french'] ?></td>
                                                <td><?php echo $o['urdu'] ?></td>
                                                <td><?php echo $o['spanish'] ?></td>
                                                <td><?php echo $o['chinese'] ?></td>
                                                <td><?php echo $o['punjabi'] ?></td>
                                                <td><?php echo $o['hindi'] ?></td>
                                            </tr>
                                        <?php  }  }?>


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
    $('#datatable1').dataTable()
    $('#datatable2').dataTable()
    $('#datatable3').dataTable()
    $('#datatable4').dataTable()


</script>
</body>

</html>