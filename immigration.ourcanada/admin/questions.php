<?php
include_once( "admin_inc.php" );

if($_GET['method']=='edit')
{
    $fid=$_GET['fid'];
}
else
{
    $fid=$_GET['id'];
}

$formCategories = mysqli_query($conn , "SELECT * FROM categories order by name");
$fcArr = array();
while($FCRow = mysqli_fetch_assoc($formCategories)){
	$fcArr[$FCRow['id']] = $FCRow;
}

$formFields = mysqli_query($conn , "SELECT * FROM field_types WHERE status = '1' order by label");
$fArr = array();
while($FRow = mysqli_fetch_assoc($formFields)){
	$fArr[$FRow['id']] = $FRow;
}


$formGroups = mysqli_query($conn , "SELECT * FROM form_group WHERE status = '1' and form_id={$fid} order by title");
$gArr = array();
while($gRow = mysqli_fetch_assoc($formGroups)){
	$gArr[$gRow['id']] = $gRow;
}

$getAllQuestions=mysqli_query($conn,"select * from questions where form_id=$fid");


$getAllQuestionss = mysqli_query($conn, "SELECT * FROM questions where form_id=$fid ");
$quesArr = array();
while ($Row = mysqli_fetch_assoc($getAllQuestionss)) {
    $quesArr[] = $Row;
}


$getAllSubQuestions = mysqli_query($conn, "SELECT * FROM sub_questions WHERE (casetype = 'subquestion' OR casetype = 'existingcheck' OR casetype = 'multicondition')");

$squesArr = array();
while ($RowS = mysqli_fetch_assoc($getAllSubQuestions)) {
    $squesArr[] = $RowS;
}
?>
<!doctype html>
<html lang="en">

<?php include_once("includes/style.php"); ?>

<head>
    <style>
        .customSelect
        {
            display: block;
            width: 100%;
            height: calc(1.5em + .94rem + 2px);
            /*padding: .47rem .75rem;*/
            padding: 3px 0px;
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
            transition: border-color .15s ease-in-out,box-shadow .
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
					<div class="row">
						<div class="col-12">
							<div class="page-title-box d-flex align-items-center justify-content-between">
								
								<?php if($_GET['method'] !== 'group'){ ?>
								<h4 class="mb-0 font-size-18">Questions</h4>
								<?php } else { ?>
								<h4 class="mb-0 font-size-18">Questions Group</h4>
								<?php } ?>

								<?php if($_GET['method'] !== 'add' && $_GET['method'] !== 'edit' && $_GET['method'] !== 'group'){ ?>
								<div class="page-title-right">
                                    <div class="form-group" style="float: left;    padding-right: 5px;">
                                        <select class="form-control selectBox getPage" name="pageNo" id="pageNo">
                                            <option value="">-- Select Page No--</option>
                                            <?php for($i = 1 ; $i <= 700 ; $i++){ ?>
                                                <option value="<?php echo $i; ?>" <?php if(isset($_GET['page']) && $_GET['page']==$i) { echo 'selected'; } ?>><?php echo $i; ?></option>
                                            <?php }?>
                                        </select>
                                    </div>

                                    <a href="?id=<?php echo $_GET['id'];?>&method=group" class="btn btn-info waves-effect waves-light" >Add Group</a>
									<a href="?id=<?php echo $_GET['id'];?>&method=add" class="btn btn-primary waves-effect waves-light" >Add Question</a>
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#duplicateModal" class="btn btn-secondary waves-effect waves-light" >Duplicate Question</a>

                                    <a href="preview?id=<?php echo $_GET['id'];?>" class="btn btn-warning waves-effect waves-light"  target="_blank">Preview Form</a>
                                    <a href="subques_list?id=<?php echo $_GET['id'];?>" class="btn btn-danger waves-effect waves-light"  target="_blank">All Sub Questions</a>

                                </div>
								<?php } else { ?>
									<a href="javascript:history.go(-1)" class="btn btn-warning waves-effect waves-light">Back To Listing</a>
								
								<?php } ?>
							</div>
						</div>
					</div>
					
					
					<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title mt-0" id="myModalLabel">Delete Question</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body text-center">
										<div class="prompt"></div>
										<div id="deleteBox">
											<i class="mdi mdi-alert-outline mr-2"></i>
											<h3>Are you sure?</h3>
											<p>You won't be able to revert this!</p>
										</div>
										<input type="hidden" name="id" id="did">
										
										<button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Delete Question</button>
										<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
									</div>
									
								</div><!-- /.modal-content -->
							</div><!-- /.modal-dialog -->
						</div>
                    <div id="duplicateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0" id="myModalLabel">Duplicate Question</h5>
                                </div>
                                <div class="modal-body ">
                                    <div class="form-group">
                                        <select class="form-control selectBox" id="duplicateQues">
                                            <option value="" disabled selected>-- Select --</option>
                                            <?php
                                            while($questionsRow=mysqli_fetch_assoc($getAllQuestions))
                                            {
                                                ?>
                                            <option value="<?php echo $questionsRow['id'] ?>"><?php echo $questionsRow['question'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="duplicate">Proceed</button>
                                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancel</button>
                                </div>

                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                    <!-- /.modal -->

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									
									<?php if($_GET['method'] == 'group'){ ?>
										<form method="post" id="gvalidateForm">
											<div class="prompt"></div>
											<div class="form-group">
												<label for="title">Group Name</label>
												<input type="text" class="form-control" name="n[title]" placeholder="Title" required="">

											</div>
											<div class="row">
												<div class="col-sm-6">
													<?php if(isset($_GET['id']) && !empty($_GET['id'])){ ?>
														<div class="form-group">
															<label for="title">Form</label>
															<input type="text" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $fcArr[$_GET['id']]['name']; ?>" readonly>
															<input type="hidden" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $_GET['id']; ?>" readonly>

														</div>
													
													<?php } else { ?>
														<div class="form-group">
															<label for="title">Form</label>
															<select class="form-control" name="n[form_id]">
																<?php foreach($FCRow as $k=>$V){ ?>
																	<option value="<?php echo $V['id']; ?>"><?php echo $V['title']; ?></option>

																<?php } ?>
															</select>

														</div>
														
													<?php } ?>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Status</label>
														<select name="n[status]" class="form-control" required>
															<option value="1">Enable</option>
															<option value="0">By Default Disable</option>

														</select>
													</div>
												</div>
											</div>
											
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Add Group</button>
											</div>
										</form>
										
									<?php }
									else if($_GET['method'] == 'add'){ ?>
										<form method="post" id="validateForm">
											<div class="prompt"></div>
											
											<div class="row">
												<div class="col-sm-6">
													<?php if(isset($_GET['id']) && !empty($_GET['id'])){ ?>
														<div class="form-group">
															<label for="title">Form</label>
															<input type="text" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $fcArr[$_GET['id']]['name']; ?>" readonly>
															<input type="hidden" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $_GET['id']; ?>" readonly>

														</div>
													
													<?php } else { ?>
														<div class="form-group">
															<label for="title">Form</label>
															<select class="form-control" name="n[form_id]">
																<?php foreach($FCRow as $k=>$V){ ?>
																	<option value="<?php echo $V['id']; ?>"><?php echo $V['title']; ?></option>

																<?php } ?>
															</select>

														</div>
														
													<?php } ?>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Group</label>
														<select class="form-control" name="n[group_id]">
															<option value="0">-- No Group --</option>
															<?php foreach($gArr as $k=>$V){ ?>
																<option value="<?php echo $V['id']; ?>"><?php echo $V['title']; ?></option>

															<?php } ?>
														</select>

													</div>
												</div>
											</div>
											
											

											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Question</label>
														<input type="text" class="form-control ques" name="n[question]" placeholder="Title" required="">

													</div>
												</div>
                                                <div class="col-sm-6">
                                                    <label>Submission Type</label>
                                                    <div class="form-group">
                                                        <select name="n[submission_type]" class="form-control" required>
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="after">After</option>
                                                            <option value="before">Before</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Edit Permission</label>
                                                    <div class="form-group">
                                                        <select name="n[permission]" class="form-control" required>
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="1">Permitted</option>
                                                            <option value="0">Forbidden</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Question Type</label>
                                                    <div class="form-group">
                                                        <select name="n[noc_flag]" id="noc_flag" class="form-control" required>
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="0">Normal</option>
                                                            <option value="1">NOC</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 noc_divs">
                                                    <label>Position</label>
                                                    <div class="form-group">
                                                        <select name="n[position_no]" class="form-control" >
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="1">Position 1</option>
                                                            <option value="2">Position 2</option>
                                                            <option value="3">Position 3</option>
                                                            <option value="4">Position 4</option>
                                                            <option value="5">Position 5</option>
                                                            <option value="6">Position 6</option>
                                                            <option value="7">Full Time Job Offer</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 noc_divs">
                                                    <label>NOC Type</label>
                                                    <div class="form-group">
                                                        <select name="n[noc_type]" class="form-control" >
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="date">Dates</option>
                                                            <option value="job">Jobs</option>
                                                            <option value="duty">Duties</option>
                                                            <option value="country">Country</option>
                                                            <option value="hour">Hours</option>
                                                            <option value="wage">Wages</option>
                                                            <option value="province">Province</option>
                                                            <option value="region">Region</option>
                                                            <option value="authorization">Authorization</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 noc_divs">
                                                    <label>NOC User</label>
                                                    <div class="form-group">
                                                        <select name="n[user_type]"  class="form-control">
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="user">User</option>
                                                            <option value="spouse">Spouse</option>
                                                        </select>
                                                    </div>
                                                </div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Field Type</label>
														<select class="form-control" name="n[fieldtype]" id="fieldtype" onChange="GenLabel('add')">
															<?php foreach($fArr as $k=>$V){ ?>
																<option value="<?php echo $V['id']; ?>"><?php echo $V['label']; ?></option>

															<?php } ?>
														</select>

													</div>
												</div>
											</div>
											
											
											
											
											<div id="radioFields" style="display: none">
												<div class="form-group">
													<label for="title">Select Label Type</label><br>
													<input type="radio" name="n[labeltype]" class="labelType" value="0"><span class="radioLabels">Use Default Labels</span>
													<input type="radio" name="n[labeltype]" class="labelType" value="1"><span class="radioLabels">Create Custom Labels</span>
												</div>
													
												
											
											</div>
											
											<div id="labelDefaultBox" style="display: none">
												<table class="table table-bordered dt-responsive nowrap">
													<thead>
														<tr>
															<th>Label</th>
															<th>Value</th>
															<th>Status</th>
															
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<input type="text" value="Yes" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="Yes" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="Enable" class="form-control" readonly>
															</td>
															
														</tr>
														<tr>
															<td>
																<input type="text" value="No" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="No" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="Enable" class="form-control" readonly>
															</td>
															
														</tr>
														
													</tbody>
												</table>
											</div>
											
											<div id="labelTypeBox" style="display: none"  class="genLabels">
												<table class="table table-bordered dt-responsive nowrap">
													<thead>
														<tr>
															<th>Label</th>
															<th>Value</th>
															<th>Status</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id="appendLabel">
														<tr>
															<td>
																<input type="text" name="m[label][]" class="form-control">
															</td>
															<td>
																<input type="text" name="m[value][]" class="form-control">
															</td>
															<td>
																<select name="m[status][]" class="form-control" required>
																	<option value="1">Enable</option>
																	<option value="0">By Default Disable</option>

																</select>
															</td>
															
														</tr>
													</tbody>
												</table>
												
												<div class="row">
													<div class="col-sm-12 text-right">
														<button type="button" class="btn btn-info btn-sm" id="addMoreLabel">Add More</button>
													</div>
												</div>
											</div>
											
											
											<div id="multiSelectBox" style="display: none" class="genLabels">
												<h3>Create Multi Dropdown</h3>
												<table class="table table-bordered dt-responsive nowrap">
													<thead>
														<tr>
															<th>Label</th>
															<th>Value</th>
															<th>Status</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id="appendLabelMulti">
														<tr>
															<td>
																<input type="text" name="m[label][]" class="form-control">
															</td>
															<td>
																<input type="text" name="m[value][]" class="form-control">
															</td>
															<td>
																<select name="m[status][]" class="form-control" required>
																	<option value="1">Enable</option>
																	<option value="0">By Default Disable</option>

																</select>
															</td>
															
														</tr>
													</tbody>
												</table>
												
												<div class="row">
													<div class="col-sm-12 text-right">
														<button type="button" class="btn btn-info btn-sm" id="addMoreDrop">Add More</button>
													</div>
												</div>
											</div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group notes">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="notes">
                                                            <label class="custom-control-label" for="notes">Notes</label>
                                                        </div>
                                                        <input type="text" name="n[notes]" id="notes_text" class="form-control" style="display: none">
                                                    </div>
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select class="form-control" name="n[status]">
                                                            <option value="1">Enable</option>
                                                            <option value="0">By Default Disable</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Page No</label>
                                                       <input type="number" class="form-control" name="n[page]">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Validation Checks</label>
                                                        <select name="n[validation]" class="form-control" required>
                                                            <option value="required">Required</option>
                                                            <option value="optional">Optional</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
											<div class="form-group">
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoader">Add Question</button>
											</div>
										</form>
									
									
									
									<?php } else if($_GET['method'] == 'edit'){ 
										$getID = $_GET['id'];
										$getQuestion = mysqli_query($conn , "SELECT * FROM questions WHERE id = '$getID'");
										$fetchUser = mysqli_fetch_assoc($getQuestion);
									
									?>
										<form method="post" id="EvalidateForm">
											<div class="prompt"></div>
											
											<div class="form-group" <?php if($fetchUser['fieldtype']==18) { ?> style="display: none" <?php } ?>>
												<label for="title">Question</label>
												<input type="text" class="form-control ques" name="n[question]" value="<?php echo $fetchUser['question']; ?>" placeholder="Title" required="">

											</div>
											
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Group</label>
														<select class="form-control" name="n[group_id]">
															<option value="0" <?php if($fetchUser['group_id'] == 0 ) { echo 'selected'; } ?>>-- No Group --</option>
															<?php foreach($gArr as $k=>$V){ ?>
																<option value="<?php echo $V['id']; ?>" <?php if($fetchUser['group_id'] == $V['id']) { echo 'selected'; } ?>><?php echo $V['title']; ?></option>

															<?php } ?>
														</select>

													</div>
												</div>
                                                <div class="col-sm-6">
                                                    <label>Submission Type</label>
                                                    <div class="form-group">
                                                        <select name="n[submission_type]" class="form-control" required>
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="after" <?php if($fetchUser['submission_type']=='after') echo 'selected';?>>After</option>
                                                            <option value="before" <?php if($fetchUser['submission_type']=='before') echo 'selected';?>>Before</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Edit Permission</label>
                                                    <div class="form-group">
                                                        <select name="n[permission]" class="form-control" required>
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="1" <?php if($fetchUser['permission']==1) echo 'selected';?>>Permitted</option>
                                                            <option value="0" <?php if($fetchUser['permission']==0) echo 'selected';?>>Forbidden</option>
                                                        </select>
                                                    </div>
                                                </div>
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Form</label>
														<input type="text" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $fcArr[$fetchUser['form_id']]['name']; ?>" readonly>
														<input type="hidden" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $fetchUser['form_id']; ?>" readonly>
													</div>
												</div>
                                                <div class="col-sm-6">
                                                    <label>Question Type</label>
                                                    <div class="form-group">
                                                        <select name="n[noc_flag]" id="noc_flag" class="form-control" required>
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="0" <?php if($fetchUser['noc_flag']==0) echo 'selected';?>>Normal</option>
                                                            <option value="1" <?php if($fetchUser['noc_flag']==1) echo 'selected';?>>NOC</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 noc_divs <?php if($fetchUser['noc_flag']==1) { ?> showNoc <?php } ?>" >
                                                    <label>Position</label>
                                                    <div class="form-group">
                                                        <select name="n[position_no]" class="form-control" >
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="1" <?php if($fetchUser['position_no']=='1') echo 'selected';?>>Position 1</option>
                                                            <option value="2" <?php if($fetchUser['position_no']=='2') echo 'selected';?>>Position 2</option>
                                                            <option value="3" <?php if($fetchUser['position_no']=='3') echo 'selected';?>>Position 3</option>
                                                            <option value="4" <?php if($fetchUser['position_no']=='4') echo 'selected';?>>Position 4</option>
                                                            <option value="5" <?php if($fetchUser['position_no']=='5') echo 'selected';?>>Position 5</option>
                                                            <option value="6" <?php if($fetchUser['position_no']=='6') echo 'selected';?>>Position 6</option>
                                                            <option value="7" <?php if($fetchUser['position_no']=='7') echo 'selected';?>>Full Time Job Offer</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 noc_divs <?php if($fetchUser['noc_flag']==1) { ?> showNoc <?php } ?>">
                                                    <label>NOC Type</label>
                                                    <div class="form-group">
                                                        <select name="n[noc_type]" class="form-control" >
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="date" <?php if($fetchUser['noc_type']=='date') echo 'selected';?>>Dates</option>
                                                            <option value="job" <?php if($fetchUser['noc_type']=='job') echo 'selected';?>>Jobs</option>
                                                            <option value="duty" <?php if($fetchUser['noc_type']=='duty') echo 'selected';?>>Duties</option>
                                                            <option value="country" <?php if($fetchUser['noc_type']=='country') echo 'selected';?>>Country</option>
                                                            <option value="hour" <?php if($fetchUser['noc_type']=='hour') echo 'selected';?>>Hours</option>
                                                            <option value="wage" <?php if($fetchUser['noc_type']=='wage') echo 'selected';?>>Wages</option>
                                                            <option value="province" <?php if($fetchUser['noc_type']=='province') echo 'selected';?>>Province</option>
                                                            <option value="region" <?php if($fetchUser['noc_type']=='region') echo 'selected';?>>Region</option>
                                                            <option value="authorization" <?php if($fetchUser['noc_type']=='authorization') echo 'selected';?>>Authorization</option>


                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 noc_divs <?php if($fetchUser['noc_flag']==1) { ?> showNoc <?php } ?>" >
                                                    <label>NOC User</label>
                                                    <div class="form-group">
                                                        <select name="n[user_type]"  class="form-control">
                                                            <option value='' selected disabled>-- Select --</option>
                                                            <option value="user"  <?php if($fetchUser['user_type']=='user') echo 'selected';?>>User</option>
                                                            <option value="spouse" <?php if($fetchUser['user_type']=='spouse') echo 'selected';?>>Spouse</option>
                                                        </select>
                                                    </div>
                                                </div>
											</div>
											
											
											<div class="row">
												
												
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Field Type</label>
														<select class="form-control" name="n[fieldtype]" id="fieldtype" onChange="GenLabel('edit')">
															<?php foreach($fArr as $k=>$V){ ?>
																<option value="<?php echo $V['id']; ?>" <?php if($fetchUser['fieldtype'] == $V['id']) { echo 'selected'; } ?>><?php echo $V['label']; ?></option>

															<?php } ?>
														</select>

													</div>
												</div>
												
											</div>
											
											<?php
												$getFieldType = mysqli_query($conn , "SELECT * FROM field_types WHERE id = '{$fetchUser['fieldtype']}'");
												$fetchField = mysqli_fetch_assoc($getFieldType);
	
											?>
											
											<div id="radioFields" <?php if($fetchField['type'] == 'radio') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
												<div class="form-group">
													<label for="title">Select Label Type</label><br>
													<input type="radio" name="n[labeltype]" class="eLabelType" value="0" <?php if($fetchUser['labeltype'] == 0) { echo 'checked'; } ?>><span class="radioLabels">Use Default Labels</span>
													<input type="radio" name="n[labeltype]" class="eLabelType" value="1" <?php if($fetchUser['labeltype'] == 1) { echo 'checked'; } ?>><span class="radioLabels" >Create Custom Labels</span>
												</div>
											</div>
											
											<div id="labelDefaultBox" <?php if($fetchField['type'] == 'radio' && $fetchUser['labeltype'] == 0) { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>>
												<table class="table table-bordered dt-responsive nowrap">
													<thead>
														<tr>
															<th>Label</th>
															<th>Value</th>
															<th>Status</th>
															
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<input type="text" value="Yes" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="Yes" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="Enable" class="form-control" readonly>
															</td>
															
														</tr>
														<tr>
															<td>
																<input type="text" value="No" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="No" class="form-control" readonly>
															</td>
															<td>
																<input type="text" value="Enable" class="form-control" readonly>
															</td>
															
														</tr>
														
													</tbody>
												</table>
											</div>
											
											
											<div id="labelTypeBox" <?php if($fetchField['type'] == 'radio' && $fetchUser['labeltype'] == 1 || $fetchField['type'] == 'multi-select' || $fetchField['type'] == 'dropdown') { ?> style="display: block" <?php } else { ?> style="display: none" <?php } ?>  class="egenLabels">
												<table class="table table-bordered dt-responsive nowrap">
													<thead>
														<tr>
															<th>Label</th>
															<th>Value</th>
															<th>Status</th>
															<th>Action</th>
														</tr>
													</thead>
													<tbody id="appendLabel" class="EappendLabel">
														<?php 
															$getLabels = mysqli_query($conn , "SELECT * FROM question_labels WHERE question_id = '{$getID}'");
															while($fLabel = mysqli_fetch_assoc($getLabels)){
														?>
														<tr>
															<td>
																<input type="text" name="m[label][]" value="<?php echo $fLabel['label']; ?>" class="form-control">
															</td>
															<td>
																<input type="text" name="m[value][]" value="<?php echo $fLabel['value']; ?>" class="form-control">
															</td>
															<td>
																<select name="m[status][]" class="form-control" required>
																	<option value="1" <?php if($fetchUser['status'] == 1) { echo 'selected'; } ?>>Enable</option>
																	<option value="0" <?php if($fetchUser['labeltype'] == 0) { echo 'selected'; } ?>>By Default Disable</option>

																</select>
															</td>
															<td>
																<a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a>
																
															</td>
														</tr>
														<?php } ?>
													</tbody>
												</table>
												
												<div class="row">
													<div class="col-sm-12 text-right">
														<button type="button" class="btn btn-info btn-sm" id="addMoreLabel">Add More</button>
													</div>
												</div>
											</div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group notes">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="notes" <?php if($fetchUser['notes']!='') { echo 'checked'; } ?>>
                                                            <label class="custom-control-label" for="notes">Notes</label>
                                                        </div>

                                                        <input type="text" name="n[notes]" id="notes_text" class="form-control" value="<?php echo $fetchUser['notes']; ?>" <?php if($fetchUser['notes']=='') { ?> style="display: none" <?php } ?>>
                                                    </div>
                                                </div>
                                            </div>
											
											<div class="row">
												<div class="col-sm-6">
													<div class="form-group">
														<label for="title">Status</label>
														<select name="n[status]" class="form-control" required>
															<option value="1" <?php if($fetchUser['status']=='1') echo 'selected'; ?>>Enable</option>
															<option value="0" <?php if($fetchUser['status']=='0') echo 'selected'; ?>>By Default Disable</option>

														</select>
													</div>
                                                </div>
                                                <div class="col-sm-6">

                                                <div class="form-group">
                                                        <label>Page No</label>
                                                        <input type="number" class="form-control" name="n[page]" value="<?php echo (int)$fetchUser['page'] ?>">
                                                    </div>
												</div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Validation Checks</label>
                                                        <select name="n[validation]" class="form-control" required>
                                                            <option value="required" <?php if($fetchUser['validation']=='required') echo 'selected'; ?>>Required</option>
                                                            <option value="optional" <?php if($fetchUser['validation']=='optional') echo 'selected'; ?>>Optional</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="title">Relate Question</label>
                                                        <br>

                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input relate" id="rel1"
                                                                   name="n[relate]" value="0" <?php if ($fetchUser['relate'] == 0) {
                                                                echo 'checked';
                                                            } ?>>
                                                            <label class="custom-control-label" for="rel1">No</label>
                                                        </div>
                                                        <div class="custom-control custom-radio" style="display: inline">
                                                            <input type="radio" class="custom-control-input relate" id="rel2"
                                                                   name="n[relate]" value="1" <?php if ($fetchUser['relate'] == 1) {
                                                                echo 'checked';
                                                            } ?>>
                                                            <label class="custom-control-label" for="rel2">Yes</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 relQues" <?php if ($fetchUser['relate'] != 1) { ?> style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label>Question Type</label>
                                                        <select name="n[rel_qtype]" class="form-control"
                                                                onchange="getQuestion('mQues1','sQues1',this)">
                                                            <option value="" disabled selected>-- Select Question Type --</option>
                                                            <option value="m_question" <?php if ($fetchUser['rel_qtype'] == 'm_question') echo 'selected' ?>>Main Question</option>
                                                            <option value="s_question" <?php if ($fetchUser['rel_qtype'] == 's_question') echo 'selected' ?>>Sub Question</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 relQues2" <?php if ($fetchUser['relate'] != 1) { ?> style="display: none;" <?php } ?>>
                                                    <div class="form-group">
                                                        <label class="q_lbl" <?php if ($fetchUser['relate'] != 1) { ?> style="display: none;" <?php } ?>>Question</label>
                                                        <div id="mQues1" <?php if ($fetchUser['relate'] == 1 && $fetchUser['rel_qtype']=='s_question') { ?> style="display: none;" <?php } ?>>
                                                            <select name="qid" class="form-control selectBox"
                                                                    required id="">
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach ($quesArr as $k => $v) {
                                                                    ?>
                                                                    <option value="<?php echo $v['id'] ?>" <?php if ($fetchUser['rel_qid'] == $v['id']) echo 'selected' ?>><?php echo $v['id'].' - '.$v['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div id="sQues1" <?php if ($fetchUser['relate'] == 1 && $fetchUser['rel_qtype']=='m_question') { ?> style="display: none;" <?php } ?>>
                                                            <select name="sid" class="form-control selectBox"
                                                                    id="" required>
                                                                <option value="" selected disabled>-- Select --</option>
                                                                <?php
                                                                foreach ($squesArr as $kV => $Vv) {
                                                                    ?>
                                                                    <option value="<?php echo $Vv['id'] ?>" <?php if ($fetchUser['rel_qid'] == $Vv['id']) echo 'selected' ?>><?php echo $Vv['id'].' - '.$Vv['question'] ?></option>
                                                                    <?php
                                                                }

                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
											
											<input type="hidden" name="id" value="<?php echo $getID; ?>">
											
											<div class="form-group">
												<button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Update Question</button>
											</div>
										</form>
									
									<?php }
									else { ?>
									<table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
										<thead>
											<tr>
												<th>#</th>
												<th width="30%">Question</th>
												<th>Type</th>
                                                <?php  if(!isset($_GET['group_id']))
                                                { ?>
												<th>Group</th>
                                                <?php } ?>
												<th>Validation Checks</th>
                                                <th>Page No</th>
												<th>Created Date</th>
												<th>Status</th>
												<th>Action</th>
												
											</tr>
										</thead>
										<tbody>
											<?php
                                            $getQuery;
                                            if(isset($_GET['group_id']))
                                            {
                                                $group_id=$_GET['group_id'];
                                                $getQuery = mysqli_query($conn , "SELECT * FROM questions WHERE group_id = '{$_GET['group_id']}'");
                                            }
                                            else
                                            {
                                                if(isset($_GET['page']))
                                                {
                                                    $getQuery = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '{$_GET['id']}' and page={$_GET['page']}");

                                                }
                                                else
                                                {
                                                    $getQuery = mysqli_query($conn , "SELECT * FROM questions WHERE form_id = '{$_GET['id']}'");

                                                }
                                            }

												$count = 1;
												while($Row = mysqli_fetch_assoc($getQuery)){
											?>
											
											<tr>
												<td><?php echo $count; ?></td>
												<td width="30%"><?php echo $Row['question']; ?></td>
												<td><?php echo $fArr[$Row['fieldtype']]['label']; ?></td>
                                                <?php
                                                if(!isset($_GET['group_id']))
                                                { ?>
												<td><?php echo $gArr[$Row['group_id']]['title']; ?></td>
                                                <?php } ?>
												<td><?php echo $Row['validation'] ?></td>
                                                <td><?php echo $Row['page'] ?></td>
												<td><?php echo $Row['created_date']; ?></td>
												<td><?php if($Row['status'] == 1) { echo '<span class="badge badge-warning">Enable</span>'; } else { echo '<span class="badge badge-danger">By Default Disable</span>'; } ?></td>
												<td>
													<?php if($Row['fieldtype']!=18) { ?>
													<a href="/admin/subques?id=<?php echo $Row['id']; ?>" class="btn btn-sm btn-info waves-effect waves-light" title="Add Logical Condition"><i class="fas fa-plus"></i></a>
													<?php } ?>
                                                    <a href="?method=edit&id=<?php echo $Row['id']; ?>&fid=<?php echo $_GET['id'] ?>"  class="btn btn-sm btn-primary waves-effect waves-light"><i class="far fa-edit"></i></a>
													
													<a href="javascript:void(0)" onClick="DeleteModal(<?php echo $Row['id']; ?>)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-trash"></i></a>
                                                </td>
											</tr>
											<?php $count++; } ?>
										</tbody>
									</table>
									<?php } ?>
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
        $('.relate').change(function () {
            if ($(this).val() == 1) {
                $('.relQues').show()

            } else {
                $('.relQues').hide()
                $('.relQues2').hide()

            }
        })
        function getQuestion(main, sub, value) {
            $('.q_lbl').show()
            $('.relQues2').show()

            if ($(value).val() == 'm_question') {
                $("#" + main).show();
                $("#" + sub).hide();
                $("#" + sub).find('select').attr('disabled', true);
                $("#" + main).find('select').attr('disabled', false);


            } else {
                $("#" + main).hide();
                $("#" + sub).show();
                $("#" + sub).find('select').attr('disabled', false);
                $("#" + main).find('select').attr('disabled', true);
            }
        }
        $(document).on('change','#fieldtype',function () {
            let f=$(this).val()
            if(f==18)
            {
                // $('.ques').prop('required',false)
                $('.ques').parent().hide()
                $('.ques').val('')

                $('#notes').click()
                $('#notes').prop('disabled',true)
            }
            else
            {
                // $('.ques').prop('required',true)
                $('.ques').parent().show()

                $('#notes').prop('checked',false)
                $('#notes').prop('disabled',false)
                $('#notes_text').hide()
            }
        })
        $('#pageNo').change(function () {
            window.location.assign("?id=<?php echo $_GET['id'] ?>&page="+$(this).val())
        })

		$('#duplicate').click(function () {
            let q=$('#duplicateQues').val()
            window.location.assign('/admin/duplicate-question?id='+q)
        })

        $(document).on('change','#noc_flag',function () {
            let v=$(this).val()
            if(v==1)
            {
                $('.noc_divs').show()
                $('.noc_divs').children().children('select').prop('required',true)
            }
            else
            {
                $('.noc_divs').hide()
                $('.noc_divs').children().children('select').prop('required',false)
            }

        })

        $(document).ready(function() {

            $('.noc_divs').hide();
            $('.showNoc').show()
            $('.selectBox').select2();
            $('.select2-container').addClass('customSelect')
            $('.select2-container .select2-selection--single').css('background-color','transparent')
            $('.select2-container .select2-selection--single').css('border',0)
        });
		
		$( '#EvalidateForm' ).validate( {
			submitHandler: function () {
				'use strict';
				$( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                $('#AddLoaderE').attr('disabled',true)

                $.ajax( {
					dataType: 'json',
					url: "ajax.php?h=updateQuestion",
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
		
		$( '#validateForm' ).validate( {
			submitHandler: function () {
				'use strict';
				$( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
                $('#AddLoader').attr('disabled',true)

                $.ajax( {
					dataType: 'json',
					url: "ajax.php?h=addQuestion",
					type: 'POST',
					data: $( "#validateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoader" ).html( 'Submit' );
                        $('#AddLoader').attr('disabled',false)

                        $( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/questions?id=<?php echo $_GET['id']; ?>" );
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
		
		
		$( '#gvalidateForm' ).validate( {
			submitHandler: function () {
				'use strict';
				$( "#AddLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
				$.ajax( {
					dataType: 'json',
					url: "ajax.php?h=addGroup",
					type: 'POST',
					data: $( "#gvalidateForm" ).serialize(),
					success: function ( data ) {
						$( "#AddLoader" ).html( 'Submit' );
						$( "div.prompt" ).show();
						if ( data.Success === 'true' ) {
							window.location.assign( "/admin/questions?id=<?php echo $_GET['id']; ?>" );
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
		
		$("#delLoader").on('click',function(){
			var id = $("#did").val();
			$( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
			$.ajax( {
				dataType: 'json',
				url: "ajax.php?h=deleteQuestion",
				type: 'POST',
				data: {'id' : id},
				success: function ( data ) {
					if(data.Success == 'true'){
						$( "#delLoader" ).html( 'Delete Question' );
						window.location.assign( "/admin/questions?id=<?php echo $_GET['id']; ?>" );
					}else{
						$( "#delLoader" ).html( 'Delete Question' );
						$( window ).scrollTop( 0 );
						$( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
						setTimeout( function () {
							$( "div.prompt" ).hide();
						}, 5000 );
					}
				}
			} );
		});
		
		function DeleteModal(id){
			$("#did").val(id);
			$("#deleteModal").modal();
		}
		
		
		function GenLabel(label){
			var fieldtype = $("#fieldtype").val();

			$.ajax( {
				dataType: 'json',
				url: "ajax.php?h=getFields",
				type: 'POST',
				data: {'id' : fieldtype},
				success: function ( data ) {
					var labelType = $("input.eLabelType:checked").val();
					if(data.data.type == 'radio'){
						$("#radioFields").show();
						$("#multiSelectBox").hide();
						if(label == 'edit' && labelType == 1){
							$("#labelTypeBox").show();
						}else if(label == 'edit' && labelType == 0){
							$("#labelDefaultBox").show();
						}
						
					}else if(data.data.type == 'multi-select'){
						$("#multiSelectBox").show();
						$("#radioFields").hide();
						if(label == 'edit'){
							$("#labelTypeBox").show();
						}
						
					}else if(data.data.type == 'dropdown'){
						$("#multiSelectBox").show();
						$("#radioFields").hide();
						if(label == 'edit'){
							$("#labelTypeBox").show();
						}
						
					}else if(data.data.type == 'email' || data.data.type == 'phone' || data.data.type == 'text'){
						$("#multiSelectBox").hide();
						$("#radioFields").hide();
						if(label == 'edit'){
							$("#labelTypeBox").hide();
						}
						$("#labelDefaultBox").hide();
						
					}else{
						$("#multiSelectBox").hide();
						$("#radioFields").hide();
						if(label == 'edit'){
							$("#labelTypeBox").hide();
						}
						$("#labelDefaultBox").hide();
						
						$(".EappendLabel").empty();
					}
				}
			} );



		}
		
		$(".labelType").on('click',function(){
			var labelType = $(this).val();
			if(labelType == 1){
				$("#labelTypeBox").show();
				("#labelDefaultBox").hide();
			}else{
				$("#labelTypeBox").hide();
				$("#labelDefaultBox").show();
			}
		});
		
		$(".eLabelType").on('click',function(){
			var labelType = $(this).val();
			if(labelType == 1){
				$("#labelTypeBox").show();
				$("#labelDefaultBox").hide();
			}else{
				$("#labelTypeBox").hide();
				$("#labelDefaultBox").show();
				$(".EappendLabel").empty();
			}
		});
		
		var fieldHTML = '<tr><td><input type="text" name="m[label][]" class="form-control"></td><td><input type="text" name="m[value][]" class="form-control"></td><td><select name="m[status][]" class="form-control" required><option value="1">Enable</option><option value="0">DisabBy Default Disablele</option></select></td><td><a href="javascript:void(0);" class="remove_button btn btn-danger"><i class="fa fa-trash"></i></a></td></tr>'; //New input field html 
		
		$("#addMoreLabel").on('click',function(){
			$("#appendLabel").append(fieldHTML); //Add field html
		});
		
		$("#addMoreDrop").on('click',function(){
			$("#appendLabelMulti").append(fieldHTML);
		});
		
		$(document).on('click', '.remove_button', function(e){
			e.preventDefault();
			$(this).closest("tr").remove();
			//x--; //Decrement field counter
		});
        $('#notes').change(function () {
            if($(this).is(":checked"))
            {
                $('#notes_text').show()
            }
            else
            {
                $('#notes_text').hide()
                $('#notes_text').val('')
            }
        })
	</script>
		
</body>

</html>