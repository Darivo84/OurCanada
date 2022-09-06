<?php
include_once( "admin_inc.php" );
$getQuery = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$_GET['id']} order by id desc");
$total_score=0;
while($Row = mysqli_fetch_assoc($getQuery)) {
    if(ctype_digit($Row['score']))
        $total_score += $Row['score'];
}
?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>
    <style>
        .form-control
        {
            border: none;
        }
    </style>
</head>
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
                <?php
                $getQuery = mysqli_query($conn , "SELECT * FROM user_form where id={$_GET['id']}");
                $r=mysqli_fetch_assoc($getQuery);
                ?>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Name: </label>
                                            <input readonly class="form-control" value="<?php echo $r['user_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone: </label>
                                            <input readonly class="form-control" value="<?php echo $r['user_phone'] ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email: </label>
                                            <input readonly class="form-control" value="<?php echo $r['user_email'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Total Score: </label>
                                            <input readonly class="form-control" value="<?php echo $total_score ?>">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>


                <!-- /.modal -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">


                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Score Type</th>
                                        <th>Score</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $type='';
                                    $score=0;
                                    $score1='';
                                    $score2='';
                                    $count = 1;

                                    $s=mysqli_query($conn,"select * from score_type");
                                    while($r=mysqli_fetch_assoc($s)) {
                                        $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation2 where user={$_GET['id']} and type='{$r['name']}' order by id desc");
                                        $type=$r['name'];
                                        $s1=0;
                                        $s2=0;
                                        $s3=0;
                                        $s4=0;
                                        while ($Row = mysqli_fetch_assoc($getQuery)) {

                                            if(ctype_digit($Row['score']))
                                                $score+=($Row['score']);
                                            else if(strpos($Row['score'],'Move') !==false)
                                            {
                                                $score='aa';
                                            }
                                            else {
                                                if ($Row['user_type'] == 'user') {
                                                    $lang1 = $lang2 = '';

                                                    if ($Row['scoreID'] >= 1 && $Row['scoreID'] <= 8) {
                                                        $s1 += $Row['score'];
                                                        $score1 .= $Row['score'] . ',';

                                                    } else if ($Row['scoreID'] >= 9 && $Row['scoreID'] <= 16) {
                                                        $s2 += $Row['score'];
                                                        $score2 .= $Row['score'] . ',';
                                                    }

                                                    $score .= $Row['score'] . ',';


                                                }
                                                else
                                                {
                                                    $lang3 = $lang4 = '';

                                                    if ($Row['scoreID'] >= 1 && $Row['scoreID'] <= 8) {
                                                        $s3 += $Row['score'];
                                                        $score3 .= $Row['score'] . ',';

                                                    } else if ($Row['scoreID'] >= 9 && $Row['scoreID'] <= 16) {
                                                        $s4 += $Row['score'];
                                                        $score4 .= $Row['score'] . ',';
                                                    }

                                                    $score .= $Row['score'] . ',';
                                                }
                                            }
                                        }
                                        if($score!=0 || $score!='0')
                                        {
                                            if($count==1 && ($score1!='' || $score2!='')) {
                                                if($s1>$s2 || $s1==$s2)
                                                {
                                                    $lang1='First';
                                                    $lang2='Second';
                                                }
//                                                else if($s1==0 || $s2==0){
//                                                    $lang='First';
//                                                }
                                                else
                                                {
                                                    $lang2='First';
                                                    $lang1='Second';
                                                }

                                                if($score1!='')
                                                    $score1 = $lang1.'('.substr($score1, 0, -1).')';
                                                if($score2!='')
                                                    $score2 = $lang2.'('.substr($score2, 0, -1).')';
                                                $score=$score1.$score2;

                                            }
                                            if($count==1 && ($score3!='' || $score4!='')) {
                                                if($s3>$s4 || $s3==$s4)
                                                {
                                                    $lang3='First';
                                                    $lang4='Second';
                                                }
                                                else
                                                {
                                                    $lang3='First';
                                                    $lang4='Second';
                                                }

                                                if($score3!='')
                                                    $score3 = $lang3.'('.substr($score3, 0, -1).')';
                                                if($score4!='')
                                                    $score4 = $lang4.'('.substr($score4, 0, -1).')';
                                                $scoree=$score3.$score4;

                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo strtoupper($type) ?></td>
                                                <td><?php if( $count==1 && (($score1!='' && $score2!='') || ($score3!='' && $score4!=''))) {
                                                        if( $score!='' && ($score1!='' && $score2!='')) {
                                                            echo '<strong>User</strong><br>' . $score;
                                                        }
                                                        if( $scoree!='')
                                                        {
                                                            echo '<br><strong>Spouse</strong><br>'.$scoree;
                                                        }
                                                    } else {
                                                        echo $score=='aa'? 0:$score ;
                                                    }
                                                    ?>
                                                </td>
                                            </tr>

                                            <?php $score=0; $count++;
                                        } }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">User</h2>
                            </div>
                            <div class="card-body">

                                <table id="datatable2" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Score Type</th>
                                        <th>ScoreID</th>
                                        <th>Score</th>
                                        <th>Page No</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$_GET['id']} order by cast(scoreID as unsigned) asc");

                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        if($Row['scoreID']!='')
                                        {
                                            $select=mysqli_query($conn,"select * from score where scoreID='{$Row['scoreID']}'");
                                            $r=mysqli_fetch_assoc($select);
                                            ?>

                                            <tr style="cursor: pointer" onclick="window.open('http://scoring.ourcanadadev.site/admin/scoring?method=edit&id=<?php echo $r['id'] ?>','_blank')">
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo strtoupper($Row['type']) ?></td>

                                                <td><?php echo ($Row['scoreID']) ?></td>
                                                <td><?php echo $Row['score']; ?></td>
                                                <td><?php echo $r['page']; ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        } }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Spouse</h2>
                            </div>
                            <div class="card-body">


                                <table id="datatable3" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Score Type</th>
                                        <th>ScoreID</th>
                                        <th>Score</th>
                                        <th>Page No</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $getQuery = mysqli_query($conn , "SELECT * FROM score_calculation where user={$_GET['id']} order by cast(scoreID as unsigned) asc");

                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){
                                        if($Row['scoreID']!='')
                                        {
                                            $select=mysqli_query($conn,"select * from score where scoreID='{$Row['scoreID']}'");
                                            $r=mysqli_fetch_assoc($select);
                                            ?>

                                            <tr style="cursor: pointer" onclick="window.open('http://scoring.ourcanadadev.site/admin/spouse_scoring?method=edit&id=<?php echo $r['id'] ?>','_blank')">
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo strtoupper($Row['type']) ?></td>

                                                <td><?php echo ($Row['scoreID']) ?></td>
                                                <td><?php echo $Row['score']; ?></td>
                                                <td><?php echo $r['page']; ?></td>
                                            </tr>
                                            <?php
                                            $count++;
                                        } }?>
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
    $('#datatable2').dataTable()
    $('#datatable3').dataTable()

</script>
</body>

</html>