<?php
include_once("admin_inc.php");

$mainQues=mysqli_query($conn,"SELECT * FROM questions WHERE form_id = '10' and question !='' and submission_type = 'after'");
$count = mysqli_num_rows($mainQues);
$quesArr = array();
$quesArr2 = array();
$quesArr3 = array();
$qTotal=0;
$sTotal=0;
$qsCount = 0;


$id = 1;

if(mysqli_num_rows($mainQues) > 0)
{

    while($row = mysqli_fetch_array($mainQues))
    {

//        if(!in_array($row['question'], $quesArr2))
        {

            $p['question']=ltrim(rtrim($row['question']));
            $p['type']='main';
            $quesArr3[] =ltrim(rtrim($row['question'])) . ' ** ' . ltrim(rtrim($row['notes']));
			
			$quesArr2[$id]['quest'] = ltrim(rtrim($row['question']));
			$quesArr2[$id]['notes'] = ltrim(rtrim($row['notes']));
            $quesArr2[$id]['quest/notes'] =ltrim(rtrim($row['question'])) . ' ** ' . ltrim(rtrim($row['notes']));
			$quesArr2[$id]['page/qid/sid'] = '{'.$row['page'] . ' , ' . $row['id'] . ' , 0 }';
			
			$id++;

        }

    }
}
$subQues = mysqli_query($conn , "SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id where q.form_id='10' AND s.question != '' and s.grade=0 and s.submission_type = 'after'");

if(mysqli_num_rows($subQues) > 0)
{
    while($row = mysqli_fetch_array($subQues))
    {

//        if(!in_array($row['question'], $quesArr2))
        {

            $p['question']=ltrim(rtrim($row['question']));
            $p['type']='sub';
			$quesArr2[$id]['quest'] = ltrim(rtrim($row['question']));
			$quesArr2[$id]['notes'] = ltrim(rtrim($row['notes']));
            $quesArr3[] =ltrim(rtrim($row['question'])) . ' ** ' . ltrim(rtrim($row['notes']));
            $quesArr2[$id]['quest/notes'] =ltrim(rtrim($row['question'])) . ' ** ' . ltrim(rtrim($row['notes']));
			$quesArr2[$id]['page/qid/sid'] = '{'.$row['page'] . ' , ' . $row['question_id'] . ' , '. $row['id'] . '}';
			
			$id++;

        }



    }
}
$vals = array_count_values($quesArr3);
$countr=3;
$c = 3;

$inD = 0;

$idenArr = array();
foreach ($vals as $k=>$v)
{
 
	$arrQuest = '';

	if($v > 1){
		
		foreach($quesArr2 as $kQ => $kV){
			if($k == $kV['quest/notes']){
				$arrQuest .= $kV['page/qid/sid'].' ';
				
				$idenArr[$inD]['quest'] = $kV['quest'];
				$idenArr[$inD]['notes'] = $kV['notes'];
				
			}
		}
		
		$idenArr[$inD]['count'] = $arrQuest;
		
		$c++;
		$countr++;
		$qsCount++;
		$sTotal+=$v;
		
		$inD++;
		
	}
    
}


?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>
   
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


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                    <table id="datatable" class="table table-bordered dt-responsive"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <!--                                            <th>#</th>-->
                                            <th>#</th>
											<th>Question</th>
											<th>Notes</th>
                                            <th>PageNo/QuesId/SubId</th>
                                            <th>Score Grouping</th>
                                           

                                        </tr>
                                        </thead>
                                        <tbody>
											<?php
												$c = 1;
												foreach($idenArr as $k => $v){
													$strRep = '';
													$strRep = str_replace(array("{","}") , array("","| "),$v['count']);
													$getIndex = explode("|",$strRep);
													
													$iden = '{';
													$scoreID = '';
													foreach($getIndex as $qK => $qV){
														if($qV !== ''){
															$q = explode(",",$qV);
															$quesID = $q[1];
															$subID = $q[2];

															if($subID == 0){
																$getQuesScore = mysqli_query($conn , "SELECT * FROM score_questions WHERE move_qid = '{$quesID}' ");
															}else{
																$getQuesScore = mysqli_query($conn , "SELECT * FROM score_questions WHERE move_qid = '{$subID}' ");
															}

															
															while($row = mysqli_fetch_assoc($getQuesScore)){
																$getQ = mysqli_query($conn , "SELECT * FROM score WHERE id = '{$row['score_id']}'");
																$fScore = mysqli_fetch_assoc($getQ);
																$scoreID .= $fScore['scoreID'].' , ';
															}

															

														}

													}
													
													$iden .= $scoreID.' }';
													
													if($scoreID !== '') { 
													
											?>
                                        	<tr>
												<td><?php echo $c; ?></td>
												<td><?php echo $v['quest']; ?></td>
												<td><?php echo $v['notes']; ?></td>
												<td><?php echo $v['count']; ?></td>
												<td><?php echo $iden; ?></td>
											</tr>
											<?php $c++; } } ?>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css"/>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>

</script>

</body>

</html>