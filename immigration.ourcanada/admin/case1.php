<?php
require "global.php";

$userExperience=0;
$spouseExperience=0;
$userEmployment=0;
$spouseEmployment=0;
$final_score=0;
$scoreArray = array();
$nocScore= array();
$scoreArray2 = array();

$case_array= array();

$o=0;

{

    $nocArray=array();
    $newArray = array();
    $quesArray = array();
    $ansArray = array();
    $scoreArray2 = array();
    $sID = 0;
    $q=0;
    $index=0;
    $labelArray=['0s','4s','5s','6s','7s','8s','9s','10s','0w','4w','5w','6w','7w','8w','9w','10w','0r','2r','3r','4r','5r','6r','7r','8r','9r','10r','0l','4l','5l','6l','7l','8l','9l','10l'];

    $select = mysqli_query($conn, "select * from score order by cast(scoreID as unsigned) asc");

    $ij=0;
    $cc='';

    if (mysqli_num_rows($select) > 0) {
        while($row = mysqli_fetch_assoc($select))
        {

            $sel=mysqli_query($conn,"select * from sub_groups where id={$row['sub_group']}");
            $ro=mysqli_fetch_assoc($sel);
            $row['sub_group']=$ro['name'];
            $row['lang']='';
            $case = $row['casetype'];
            $score_id = $row['id'];
            $lang=$row['language'];
            $flag=$row['flags'];



            if($flag==1)
            {
                $brk_op='||';
            }
            else if($flag==0)
            {

                $brk_op='&&';
            }
            else if($flag==2)
            {

                $brk_op='';
            }


            if ($case == 'grouped') {

                if ($sID != $score_id)
                {
                    $array1 = array();
                    $array2 = array();
                    $array3 = array();

                    $sc=0;

                    $or = $and = $andCheck = $i = $k = 0;
                    $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                    while ($row1 = mysqli_fetch_assoc($select1)) {

                        $qtype=$row1['question_type'];
                        $qid=$row1['question_id'];
                        $ss='';
                        $r='';
                        $value='';
                        if($qtype=='m_question')
                        {
                            $ss=mysqli_query($conn,"select * from questions where id=$qid");
                            $r=mysqli_fetch_assoc($ss);
                            $value=$r['question'];

                        }
                        else if($qtype=='s_question')
                        {
                            $ss=mysqli_query($conn,"select * from sub_questions where id=$qid");
                            $r=mysqli_fetch_assoc($ss);
                            $value=$r['question'];

                        }
                        else if($qtype=='score_type')
                        {
                            $value=$qid;
                        }
                        else if($row1['score_case']==1)
                        {
                            $value='test_score';
                        }

                        $dbValue = explode('*',$row1['value']);
                        $operator = $row1['operator'];
                        $condition = $row1['condition2'];
                        $other_case=$row1['other_case'];

                        $score = $row1['score_number'];
                        $row1['uvalue'] = $value;
                        $row1['questions'].=$row1['id'].',';





                        if ($condition == 'or') {
                            $cond = '||';

                        }
                        else if ($condition == 'and') {
                            $cond = "&&";

                        }
                        $condition=$cond;
                        $other_case2=$other_case;

                        for($d=0;$d<sizeof($dbValue)-1;$d++) {

                            if (sizeof($dbValue)>2) {
                                if($d==(sizeof($dbValue)-2))
                                {
                                    $condition=$cond;
                                    $other_case2=$other_case;

                                }
                                else {
                                    $condition = '||';
                                    $other_case2='condition';

                                }
                            }





                            if($operator=='=')
                            {
                                $operator='==';
                            }

                            if($operator=='-')
                            {
                                $dval=explode('-',$dbValue[$d]);
                                $array2[$k] .= ''.$value.' >= '. $dval[0] .' && '.$value . ' <= '. $dval[1] .''. $condition . ' ';
                            }
                            else {
                                $array2[$k] .= '"' . $value . '"' . $operator . '"' . $dbValue[$d] . '" ' . $condition . ' ';
                            }
                        }

                        if ($other_case2 != 'condition' ) {
                            $row['score'] = $score;
                            $row['other_case']=$row1['other_case'];
                            $row['move_qtype']=$row1['move_qtype'];
                            $row['move_qid']=$row1['move_qid'];
                            $row['move_scoreType']=$row1['move_scoreType'];
                            $row['comments']=$row1['comments'];

                            $array1[$k] = $row;
                            $row['questions'] = '';
                            $k++;
                        }

                    }

                    for($j=0;$j<sizeof($array2);$j++)
                    {

                        $bb=explode($brk_op,$array2[$j]);
                        $d='';

                        foreach ($bb as $a)
                        {
                            if($a!='' && $a!=' ' && $a!=null && $a!=NULL) {
                                if(substr($a, -3)=='&& ' || substr($a, -3)=='|| ')
                                {
                                    $a=substr($a,0,-3);
                                }
                                $d .= '(' . $a . ') '.$brk_op.' ';
                            }
                        }
                        if(substr($d, -3)=='&& ' || substr($d, -3)=='|| ')
                        {
                            $d=substr($d,0,-3);
                        }
                        $sr['case_type']='Group';
                        $sr['case']= $d;
                        $sr['scoreID']=$row['scoreID'];
                        $sr['score_id']=$row['id'];
                        $sr['score']=$array1[$j]['score'];
                        $case_array[$index]=$sr;
                        $index++;
                    }

                }

            }
            else if ($case == 'and') {

                if ($sID != $score_id) {
                    $andCount = 0;
                    $andCheck = 0;
                    $s = mysqli_query($conn, "select * from score_conditions where score_id=$score_id");
                    $r = mysqli_fetch_assoc($s);
                    $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                    while ($row1 = mysqli_fetch_assoc($select1)) {
                        $qtype=$row1['question_type'];
                        $qid=$row1['question_id'];
                        $ss='';
                        if($qtype=='m_question')
                        {
                            $ss=mysqli_query($conn,"select * from questions where id=$qid");
                        }
                        else
                        {
                            $ss=mysqli_query($conn,"select * from sub_questions where id=$qid");
                        }

                        $r=mysqli_fetch_assoc($ss);
                        $value=$r['question'];
                        $andCheck++;
                        $dbValue = $row1['value'];//substr($row1['value'],0,-1);
                        $operator = $row1['operator'];
                        $d=$value.$operator.$dbValue;
                        $sr['case_type']='AND';
                        $sr['case']= $d;
                        $sr['scoreID']=$row['scoreID'];
                        $sr['score_id']=$row['id'];

                        $sr['score']=0;
                        $case_array[$index]=$sr;
                        $index++;
                    }

                }
            }
            else if ($case == 'or') {

                if ($sID != $score_id) {

                    $bool = false;
                    $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                    while ($row1 = mysqli_fetch_assoc($select1)) {
                        if (!$bool) {
                            $qtype=$row1['question_type'];
                            $qid=$row1['question_id'];
                            $ss='';
                            if($qtype=='m_question')
                            {
                                $ss=mysqli_query($conn,"select * from questions where id=$qid");
                            }
                            else
                            {
                                $ss=mysqli_query($conn,"select * from sub_questions where id=$qid");
                            }

                            $r=mysqli_fetch_assoc($ss);
                            $value=$r['question'];

                            $select2 = mysqli_query($conn, "select * from score_conditions where score_id=$score_id");
                            while ($row2 = mysqli_fetch_assoc($select2)) {

                                $dbValue = rtrim($row2['value']);
                                $operator = $row2['operator'];
                                $c=$value.' '.$operator.' '.$dbValue;
                                $s['case_type']='OR';
                                $s['case']=$c;
                                $s['scoreID']=$row['scoreID'];
                                $s['score_id']=$row['id'];

                                $s['score']=$row2['score_number'];
                                $case_array[$index]=$s;
                                $index++;

                            }
                        }
                    }
                }
            }
            else if ($case == 'both') {

                if ($sID != $score_id) {

                    $array1 = array();
                    $array2 = array();
                    $or = $and = $andCheck = $i = $k = 0;
                    $ob='';
                    $cb='';
                    $select1 = mysqli_query($conn, "select * from score_questions where score_id=$score_id");
                    while ($row1 = mysqli_fetch_assoc($select1)) {
                        $qtype=$row1['question_type'];
                        $qid=$row1['question_id'];
                        $ss='';
                        $r='';
                        $value='';
                        if($qtype=='m_question')
                        {
                            $ss=mysqli_query($conn,"select * from questions where id=$qid");
                            $r=mysqli_fetch_assoc($ss);
                            $value=$r['question'];

                        }
                        else if($qtype=='s_question')
                        {
                            $ss=mysqli_query($conn,"select * from sub_questions where id=$qid");
                            $r=mysqli_fetch_assoc($ss);
                            $value=$r['question'];

                        }
                        else if($qtype=='score_type')
                        {
                            $value=$qid;
                        }
                        else if($row1['score_case']==1)
                        {
                            $value='test_score';
                        }



                        $sc=0;
                        $dbValue = explode('*',$row1['value']);
                        $operator = $row1['operator'];
                        $condition = $row1['condition2'];
                        $score = $row1['score_number'];
                        $other_case=$row1['other_case'];
                        $row1['uvalue'] = $value;
                        $row['questions'].=$row1['question_id'].',';
                        $row['q_id'].=$row1['question_id'];
                        $row['question_type'].=$row1['question_type'];
                        $max=$row['max_score'];
                        $test=$row1['tests'];
                        if($brk_op=='')
                        {
                            $ob=$row1['open_bracket'];
                            $cb=$row1['close_bracket'];
                        }

                        if ($condition == 'or') {
                            $cond = '||';

                        } else if ($condition == 'and') {
                            $cond = "&&";

                        }
                        $condition=$cond;
                        $other_case2=$other_case;
                        $ob1=$ob;
                        $cb1=$cb;
                        $check_id='';
                        for($d=0;$d<sizeof($dbValue)-1;$d++) {

                            if (sizeof($dbValue)>2) {
                                if($d==(sizeof($dbValue)-2))
                                {
                                    $condition=$cond;
                                    $other_case2=$other_case;
                                   if($brk_op=='') {
                                       $ob1 = $ob;
                                       $cb1 = $cb;
                                   }

                                }
                                else {
                                    $condition = '||';
                                    $other_case2='condition';
                                    if($brk_op=='') {
                                        $ob1 = '';
                                        $cb1 = $cb;
                                    }

                                }
                            }
                            if($brk_op=='') {
                                if ($d == 0) {
                                    $ob1 = $ob;
                                } else if ($d == sizeof($dbValue) - 2) {
                                    $ob1 = '';
                                    $cb1 = $cb;
                                } else {

                                    $cb1 = '';
                                    $ob1 = '';
                                }

                                if ($d == 0 && sizeof($dbValue) > 2) {
                                    $sb = '(';
                                } else {
                                    $sb = '';
                                }
                                if ($d != 0 && $d == sizeof($dbValue) - 2) {
                                    $eb = ')';
                                } else {
                                    $eb = '';
                                }
                            }
                            if($operator=='=')
                            {
                                $operator='==';
                            }

                            if(ctype_digit($value))
                            {
                                if($operator=='-')
                                {
                                    $dv=explode('-',$dbValue[$d]);
                                    $array2[$k] .= '('.$value .'>='.$dv[0].' && '.$value.'<='.$dv[1].')' .' ' . $condition . ' ';
                                }
                                else
                                {

                                    $array2[$k] .= $ob1.$value .$operator.$dbValue[$d].$cb1. ' ' . $condition . ' ';
                                }
                            }
                            else
                            {

                                $array2[$k].=$ob1;
                                $array2[$k] .=  $sb;
								$array2[$k] .= '"'.$value.'"' .$operator. '"'.$dbValue[$d].'"';
								$array2[$k] .=  $eb;
                                $array2[$k] .= $cb1.' ' . $condition . ' ';


                            }


                            if ($other_case2 != 'condition') {


                                $row['score'] = $score;
                                $row['other_case']=$row1['other_case'];
                                $row['move_qtype']=$row1['move_qtype'];
                                $row['move_qid']=$row1['move_qid'];
                                $row['move_scoreType']=$row1['move_scoreType'];
                                $row['comments']=$row1['comments'];

                                $array1[$k] = $row;
                                $row['questions'] = '';
                                $k++;
                            }

                            $check_id=$d;
                        }
						
						//$array2[$k] = '('.$array2[$k].')';
                    }
                }

                for($j=0;$j<sizeof($array2);$j++)
                {
                    if($brk_op!='') {

                        $b=explode($brk_op,$array2[$j]);
                        $d='';

                        foreach ($b as $a)
                        {
                            if($a!='' && $a!=' ' && $a!=null && $a!=NULL)
                            {
                                if(substr($a, -3)=='&& ' || substr($a, -3)=='|| ')
                                {
                                    $a=substr($a,0,-3);
                                }
                                $d.= '(' . $a . ') '.$brk_op.' ';
                            }
                        }
                    }
                    else
                    {

                        $d=$array2[$j];
                    }
                    if(substr($d, -3)=='&& ' || substr($d, -3)=='|| ')
                    {
                        $d=substr($d,0,-3);
                    }
                    $d='('.$d.')';

                    $sr['case_type']='AND-OR';
                    $sr['case']= $d;
                    $sr['scoreID']=$row['scoreID'];
                    if($array1[$j]['other_case']=='score') {
                        $sr['score'] = $array1[$j]['score'];
                    }
                    else if ($array1[$j]['other_case']=='question')
                    {
                        $sr['score'] ='Move to Question - '. $array1[$j]['move_qid'];
                    }
                    else if ($array1[$j]['other_case']=='scoring')
                    {
                        $sr['score'] ='Move to Score - '. $array1[$j]['score_type'].'(url id)';
                    }
                    $sr['score_id']=$row['id'];
                    $case_array[$index]=$sr;
                    $index++;
                }

            }

        }
        $sID = $score_id;
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




                <!-- /.modal -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="prompt"></div>


                                <table id="datatable2" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Case Type</th>
                                        <th>Score ID</th>
                                        <th>Case</th>
                                        <th>Score</th>
                                        <th>Page No</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $count = 1;
                                    foreach ($case_array as $c){
                                        if($c['case_type']=='AND-OR' || $c['case_type']=='Group') {
                                            $select=mysqli_query($conn,"select * from score where scoreID='{$c['scoreID']}'");
                                            $r=mysqli_fetch_assoc($select);
                                            ?>
                                            <tr class="">
                                                <td><?php echo $count; ?></td>
                                                <td><?php echo $c['case_type'] ?></td>

                                                <td><?php echo $c['scoreID'] ?></td>

                                                <td><?php echo ($c['case']) ?></td>
                                                <td><?php echo $c['score']; ?></td>
                                                <td><?php echo $r['page']; ?></td>
                                                <td>
                                                    <a target="_blank" class="btn btn-sm btn-success" href="scoring?method=edit&id=<?php echo $c['score_id'] ?>"><i class="fa fa-eye"></i></a>

                                                    <?php if($c['case_type']=='AND-OR' || $c['case_type']=='Group') { ?>
                                                        <button class="btn btn-sm btn-primary score_<?php echo $c['score_id'] ?>" onclick="openModal('<?php echo $c['score_id'] ?>')"><i class="fa fa-edit"></i></button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $count++;
                                        }} ?>
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


        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bracket Flag</h5>
                    </div>
                    <div class="modal-body">
                        <label>Set Brackets</label>
                        <div class="form-group">
                            <select id="flag" class="form-control">
                                <option value="0">"OR" in brackets</option>
                                <option value="1">"AND" in brackets</option>
                                <option value="2">Custom</option>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="score_id">
                        <button type="button" class="btn btn-secondary cls" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBtn">Save</button>
                    </div>
                </div>
            </div>
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

    function openModal(id) {
        $('#score_id').val(id)
        $('#exampleModal').modal('show')
    }

    $('#saveBtn').click(function () {

        let id=$('#score_id').val()
        let val=$('#flag').val()

        $('#saveBtn').html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $('#saveBtn').prop('disabled',true)


        $.ajax( {
            dataType: 'json',
            url: 'ajax.php?h=flag_update',
            type: 'POST',
            async: false,
            data:{'id':id,'val':val},
            success: function ( data ) {
                if(data.Success=='true')
                {
                    $('#saveBtn').html('Save')
                    $('#saveBtn').prop('disabled',false)
                    $('.cls').click()
                    $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        window.location.reload()
                    }, 3000 );

                }

            }
        });
    })
</script>
</body>

</html>
