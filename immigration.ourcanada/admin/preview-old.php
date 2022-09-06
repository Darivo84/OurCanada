<?php
include_once( "admin_inc.php" );

	$getQuestions = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '{$_GET['id']}' ");

	$getForm = mysqli_query($conn , "SELECT * FROM categories WHERE id  = '{$_GET['id']}'");
	$form = mysqli_fetch_assoc($getForm);

	$getFormGroups = mysqli_query($conn , "SELECT * FROM form_group");
	$frmArr = array();
	while($row = mysqli_fetch_assoc($getFormGroups)){
		$frmArr[$row['id']] = $row;
	}
	$getSubQuestions = mysqli_query($conn , "SELECT * FROM sub_questions");
	$squArr = array();
	while($row = mysqli_fetch_assoc($getSubQuestions)){
		$squArr[$row['id']] = $row;
	}

$getSubQuestions2 = mysqli_query($conn , "SELECT * FROM level2_sub_questions");
$squArr2 = array();
while($row = mysqli_fetch_assoc($getSubQuestions2)){
    $squArr2[$row['id']] = $row;
}

	$getFieldType = mysqli_query($conn , "SELECT * FROM field_types");
	$sField = array();
	while($row = mysqli_fetch_assoc($getFieldType)){
		$sField[$row['id']] = $row;
	}
?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

</head>

<body data-topbar="dark" data-layout="horizontal">

	<div id="quesPrev">
		<h3><?php echo $form['name']; ?> Form Preview</h3>
		<ul>
			<?php while($row = mysqli_fetch_assoc($getQuestions)) { ?>
			<li><?php echo $row['question']; ?></li>
				<?php
					$checkCondition = mysqli_query($conn , "SELECT * FROM sub_questions WHERE question_id = '{$row['id']}'");
					if(mysqli_num_rows($checkCondition) > 0){		
						
																   
				?>
					<ul>
						<?php while($row = mysqli_fetch_assoc($checkCondition)) { 
							$getSubLogics = mysqli_query($conn , "SELECT * FROM ques_logics WHERE s_id = '{$row['id']}'");
							$fetchLogic = mysqli_fetch_assoc($getSubLogics);
							$caseType = $row['casetype'];
					
							$labelVal = '';
							if($caseType == 'group'){
								$labelVal = 'then Move To Group <b>'.$frmArr[$row['group_id']]['title'].'</b>';
							}else if($caseType == 'subquestion') {
								$labelVal = 'then ask question <b>'.$row['question'].'</b>';
							}
							if($fetchLogic['value'] !== 'None'){
						?>
							<li>If this is <?php echo $fetchLogic['operator']; ?> <?php echo $fetchLogic['value']; ?> <?php echo $labelVal; ?></li>
							
						
						<?php } else { 
							if($caseType == 'existingcheck'){
						?>
							<ul>
								<?php if($row['value'] !== 'None'){ ?>
								<li>If <?php echo $row['value']; ?> then ask <b><?php echo $row['question']; ?></b></li>
								<?php } ?></li>
							</ul>
						<?php  } else if($caseType == 'subquestion' || $caseType == 'multicondition'){ 
							
						?>
						<ul>
							
							<li><?php echo $row['question']; ?></li>
							
						</ul>
						
						<?php } } }?>
					</ul>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>

	<?php include_once("includes/script.php"); ?>
	
</body>
</html>