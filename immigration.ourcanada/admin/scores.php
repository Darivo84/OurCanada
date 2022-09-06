<?php
include_once( "admin_inc.php" );
$getQuery = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$_GET['id']} order by id desc");
$total_score=0;
while($Row = mysqli_fetch_assoc($getQuery)) {
    if(ctype_digit($Row['score']))
        $total_score += $Row['score'];
}


$getQuery = mysqli_query($conn , "SELECT * FROM score_calculation where user={$_GET['id']} order by id desc");
$total_score_spouse=0;
while($Row = mysqli_fetch_assoc($getQuery)) {
    if(ctype_digit($Row['score']))
        $total_score_spouse += $Row['score'];
}
function searchColumn($value, $array,$column) {
    foreach ($array as $key => $val) {
        if ($val[$column] === $value) {
            return true;//$key;
        }
    }
    return false;
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


                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>User Total Score: </label>
                                            <input readonly class="form-control" value="<?php echo $total_score ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Spouse Total Score: </label>
                                            <input readonly class="form-control" value="<?php echo $total_score_spouse ?>">
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
                            <div class="card-header">
                                <h2 class="card-title">User group wise scores</h2>
                            </div>
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
                                    $score='';
                                    $score1='';
                                    $score2='';
                                    $score3='';
                                    $score4='';
                                    $labelScoreUser='';
                                    $labelScoreSpouse='';
                                    $count = 1;

                                    $labelArray = ['0s','1s','2s','3s', '4s', '5s', '6s', '7s', '8s', '9s', '10s', '0w','1w','2w','3w', '4w', '5w', '6w', '7w', '8w', '9w', '10w', '0r','1r', '2r', '3r', '4r', '5r', '6r', '7r', '8r', '9r', '10r', '0l','1l','2l','3l', '4l', '5l', '6l', '7l', '8l', '9l', '10l'];

                                    $s=mysqli_query($conn,"select * from score_type");
                                    while($r=mysqli_fetch_assoc($s)) {
                                        $type = $r['name'];

                                        if($type=='clb') {
                                            $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation2 where user={$_GET['id']} and type='{$r['name']}' order by id desc");
                                            $s1 = 0;
                                            $s2 = 0;
                                            $s3 = 0;
                                            $s4 = 0;

                                            if(mysqli_num_rows($getQuery) > 0)
                                            {
                                                while ($Row = mysqli_fetch_assoc($getQuery)) {
//                                            if(array_search($Row['score'], $labelArray) > -1)
                                                    /*                                            if($type=='clb')*/
                                                    {
                                                        if ($Row['user_type'] == 'user') {
                                                            $lang1 = $lang2 = '';

                                                            if ($Row['scoreID'] >= 1 && $Row['scoreID'] <= 8) {
                                                                $s1 += $Row['score'];
                                                                $score1 .= $Row['score'] . ',';

                                                            } else if ($Row['scoreID'] >= 9 && $Row['scoreID'] <= 16) {
                                                                $s2 += $Row['score'];
                                                                $score2 .= $Row['score'] . ',';
                                                            }

                                                            $labelScoreUser .= $Row['score'] . ',';
                                                        } else {
                                                            $lang3 = $lang4 = '';

                                                            if ($Row['scoreID'] >= 1 && $Row['scoreID'] <= 8) {
                                                                $s3 += $Row['score'];
                                                                $score3 .= $Row['score'] . ',';

                                                            } else if ($Row['scoreID'] >= 9 && $Row['scoreID'] <= 16) {
                                                                $s4 += $Row['score'];
                                                                $score4 .= $Row['score'] . ',';
                                                            }

                                                            $labelScoreSpouse .= $Row['score'] . ',';
                                                        }
                                                    }
                                                }
                                                if($labelScoreUser!='') {
                                                    if($s1>$s2 || $s1==$s2)
                                                    {
                                                        $lang1='First';
                                                        $lang2='Second';
                                                    }
                                                    else
                                                    {
                                                        $lang2='First';
                                                        $lang1='Second';
                                                    }

                                                    if($score1!='')
                                                        $score1 = $lang1.'('.substr($score1, 0, -1).')';
                                                    if($score2!='')
                                                        $score2 = $lang2.'('.substr($score2, 0, -1).')';
                                                    $labelScoreUser=$score1.$score2;

                                                }
                                                if($labelScoreSpouse!='') {
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
                                                    $labelScoreSpouse=$score3.$score4;

                                                }

                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo strtoupper($type) ?></td>
                                                    <?php
                                                    if($labelScoreUser!='') {

                                                        $score.='<strong>User</strong><br>' . $labelScoreUser;
                                                    }
                                                    if($labelScoreSpouse!='') {
                                                        $score.='<br><strong>Spouse</strong><br>' . $labelScoreSpouse;
                                                    }
                                                    ?>
                                                    <td><?php echo $score; ?></td>
                                                </tr>

                                                <?php $score='';$labelScoreUser='';$labelScoreSpouse=''; $count++;
                                            }}
                                        else
                                        {
                                            $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation2 where user={$_GET['id']} and type='{$r['name']}' order by id desc");
                                            $type = $r['name'];
                                            $s1 = 0;
                                            $s2 = 0;
                                            $s3 = 0;
                                            $s4 = 0;

                                            while ($Row = mysqli_fetch_assoc($getQuery)) {
                                                $score+=$Row['score'];
                                            }

                                            ?>
                                            <?php
                                            if($score=='aa')
                                            {
                                                continue;
                                            }
                                            if($score!=0 && $score!='0' && $score!='')
                                            {

                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo strtoupper($type) ?></td>
                                                    <td><?php echo $score; ?></td>
                                                </tr>

                                                <?php $score=0;$count++;
                                            } }}?>
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
                                <h2 class="card-title">User score summary</h2>
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
                                    $getQuery = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$_GET['id']} order by cast(scoreID as DECIMAL(8,2)) asc");

                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){
//                                        if($Row['user_type']=='spouse')
//                                        {
//                                            continue;
//                                        }
                                        if($Row['scoreID']!='')
                                        {
                                            $select=mysqli_query($conn,"select * from score where scoreID='{$Row['scoreID']}'");
                                            $r=mysqli_fetch_assoc($select);
                                            $select2=mysqli_query($conn,"select * from score_questions where score_id='{$r['id']}' and move_qtype!=''");
                                            $r2=mysqli_fetch_assoc($select2);

                                            if(strpos($Row['score'],'Question') !==false)
                                            {
                                                $Row['score']=$Row['score'].'<button class="btn btn-sm btn-warning" onclick="getQuesView(\''.$r2['move_qid'].'\',\''.$r2['move_qtype'].'\')">View</button>';
                                            }
                                            $click=' style="cursor: pointer" onclick="window.open(\''.$currentTheme.'admin/scoring?method=edit&id='.$r['id'].'\',\'_blank\')"'

                                            ?>

                                            <tr>
                                                <td><?php echo $count; ?></td>
                                                <td <?php echo $click; ?>><?php echo strtoupper($Row['type']) ?></td>

                                                <td <?php echo $click; ?>><?php echo ($Row['scoreID']) ?></td>
                                                <td><?php echo $Row['score']; ?></td>
                                                <td <?php echo $click; ?>><?php echo $r['page']; ?></td>
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
                                <h2 class="card-title">Spouse group wise scores</h2>
                            </div>
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
                                    $score='';
                                    $score1='';
                                    $score2='';
                                    $score3='';
                                    $score4='';
                                    $labelScoreUser='';
                                    $labelScoreSpouse='';
                                    $count = 1;

                                    $labelArray = ['0s','1s','2s','3s', '4s', '5s', '6s', '7s', '8s', '9s', '10s', '0w','1w','2w','3w', '4w', '5w', '6w', '7w', '8w', '9w', '10w', '0r','1r', '2r', '3r', '4r', '5r', '6r', '7r', '8r', '9r', '10r', '0l','1l','2l','3l', '4l', '5l', '6l', '7l', '8l', '9l', '10l'];

                                    $s=mysqli_query($conn,"select * from score_type");
                                    while($r=mysqli_fetch_assoc($s)) {
                                        $type = $r['name'];

                                        if($type=='clb') {
                                            $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation where user={$_GET['id']} and type='{$r['name']}' order by id desc");
                                            $s1 = 0;
                                            $s2 = 0;
                                            $s3 = 0;
                                            $s4 = 0;

                                            if(mysqli_num_rows($getQuery) > 0)
                                            {
                                                while ($Row = mysqli_fetch_assoc($getQuery)) {
//                                            if(array_search($Row['score'], $labelArray) > -1)
                                                    /*                                            if($type=='clb')*/
                                                    {
                                                        if ($Row['user_type'] == 'user') {
                                                            $lang1 = $lang2 = '';

                                                            if ($Row['scoreID'] >= 1 && $Row['scoreID'] <= 8) {
                                                                $s1 += $Row['score'];
                                                                $score1 .= $Row['score'] . ',';

                                                            } else if ($Row['scoreID'] >= 9 && $Row['scoreID'] <= 16) {
                                                                $s2 += $Row['score'];
                                                                $score2 .= $Row['score'] . ',';
                                                            }

                                                            $labelScoreUser .= $Row['score'] . ',';
                                                        } else {
                                                            $lang3 = $lang4 = '';

                                                            if ($Row['scoreID'] >= 1 && $Row['scoreID'] <= 8) {
                                                                $s3 += $Row['score'];
                                                                $score3 .= $Row['score'] . ',';

                                                            } else if ($Row['scoreID'] >= 9 && $Row['scoreID'] <= 16) {
                                                                $s4 += $Row['score'];
                                                                $score4 .= $Row['score'] . ',';
                                                            }

                                                            $labelScoreSpouse .= $Row['score'] . ',';
                                                        }
                                                    }
                                                }
                                                if($labelScoreUser!='') {
                                                    if($s1>$s2 || $s1==$s2)
                                                    {
                                                        $lang1='First';
                                                        $lang2='Second';
                                                    }
                                                    else
                                                    {
                                                        $lang2='First';
                                                        $lang1='Second';
                                                    }

                                                    if($score1!='')
                                                        $score1 = $lang1.'('.substr($score1, 0, -1).')';
                                                    if($score2!='')
                                                        $score2 = $lang2.'('.substr($score2, 0, -1).')';
                                                    $labelScoreUser=$score1.$score2;

                                                }
                                                if($labelScoreSpouse!='') {
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
                                                    $labelScoreSpouse=$score3.$score4;

                                                }

                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo strtoupper($type) ?></td>
                                                    <?php
                                                    if($labelScoreUser!='') {

                                                        $score.='<strong>User</strong><br>' . $labelScoreUser;
                                                    }
                                                    if($labelScoreSpouse!='') {
                                                        $score.='<br><strong>Spouse</strong><br>' . $labelScoreSpouse;
                                                    }
                                                    ?>
                                                    <td><?php echo $score; ?></td>
                                                </tr>

                                                <?php $score='';$labelScoreUser='';$labelScoreSpouse=''; $count++;
                                            }}
                                        else
                                        {
                                            $getQuery = mysqli_query($conn, "SELECT * FROM score_calculation where user={$_GET['id']} and type='{$r['name']}' order by id desc");
                                            $type = $r['name'];
                                            $s1 = 0;
                                            $s2 = 0;
                                            $s3 = 0;
                                            $s4 = 0;

                                            while ($Row = mysqli_fetch_assoc($getQuery)) {
                                                $score+=$Row['score'];
                                            }

                                            ?>
                                            <?php
                                            if($score=='aa')
                                            {
                                                continue;
                                            }
                                            if($score!=0 && $score!='0' && $score!='')
                                            {
                                                ?>
                                                <tr>
                                                    <td><?php echo $count; ?></td>
                                                    <td><?php echo strtoupper($type) ?></td>
                                                    <td><?php echo $score; ?></td>
                                                </tr>

                                                <?php $score=0;$count++;
                                            } }}?>
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
                                <h2 class="card-title">Spouse score summary</h2>
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
                                    $getQuery = mysqli_query($conn , "SELECT * FROM score_calculation where user={$_GET['id']} order by cast(scoreID as DECIMAL(8,2)) asc");
                                    $checkArray=Array();
                                    $count = 1;
                                    while($Row = mysqli_fetch_assoc($getQuery)){
//                                        if($Row['user_type']=='spouse')
//                                        {
//                                            continue;
//                                        }

                                        if($Row['scoreID']!='')
                                        {
                                            if(strpos($Row['score'],'Move to Question') !== false)
                                            {
                                                if(searchColumn($Row['scoreID'],$checkArray,'scoreID'))
                                                {
                                                    continue;
                                                }
                                            }

                                            $select=mysqli_query($conn,"select * from score where scoreID='{$Row['scoreID']}'");
                                            $r=mysqli_fetch_assoc($select);
                                            $select2=mysqli_query($conn,"select * from score_questions2 where score_id='{$r['id']}' and move_qtype!=''");
                                            $r2=mysqli_fetch_assoc($select2);
                                            if(strpos($Row['score'],'Question') !==false)
                                            {
                                                $Row['score']=$Row['score'].'<button class="btn btn-sm btn-warning" onclick="getQuesView(\''.$r2['move_qid'].'\',\''.$r2['move_qtype'].'\')">View</button>';
                                            }
                                            $click=' style="cursor: pointer" onclick="window.open(\''.$currentTheme.'admin/spouse_scoring?method=edit&id='.$r['id'].'\',\'_blank\')"'

                                            ?>

                                            <tr >
                                                <td><?php echo $count; ?></td>
                                                <td <?php echo $click; ?>><?php echo strtoupper($Row['type']) ?></td>

                                                <td <?php echo $click; ?>><?php echo ($Row['scoreID']) ?></td>
                                                <td><?php echo $Row['score']; ?></td>
                                                <td <?php echo $click; ?>><?php echo $r['page']; ?></td>
                                            </tr>
                                            <?php
                                            $c['scoreID']=$Row['scoreID'];
                                            $c['type']=$Row['score'];
                                            $checkArray[]=$c;
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

        <div id="quesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel">Question View</h5>
                    </div>
                    <div class="modal-body" id="quesBody">

                    </div>
                    <div class="modal-footer" >
                        <button class="btn btn-sm btn-primary" data-dismiss="modal">Ok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

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
    function getQuesView(id,type)
    {
        $(".viewButton").html('<span class="spinner-border spinner-border-sm" role="status"></span> Processing');
        $('.viewButton').attr('disabled', true)

        $.ajax({
            dataType: 'json',
            url: "ajax.php?h=getViewQuestion",
            type: 'POST',
            data: {id:id,type:type},
            success: function (data) {
                $(".viewButton").html('Submit');
                $('.viewButton').attr('disabled', false)
                $('#quesModal').modal('show')
                if (data.Success === 'true') {
                    // console.log(data.data)
                    let html=''
                    html+='<h4>Notes:</h4>'
                    html+='<p>'+data.data.notes+'</p>'
                    html+='<br><br>'
                    html+='<h4>Question:</h4>'
                    html+='<p>'+data.data.question+'</p>'
                    $('#quesBody').html(html)

                } else {
                    $('#quesBody').html('<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>');

                }

            }
        });

        return false;
    }

</script>
</body>

</html>