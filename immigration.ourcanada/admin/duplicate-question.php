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




$getCurrentQuestion=mysqli_query($conn,"select * from questions where id={$_GET['id']}");
$curentQuesRow=mysqli_fetch_assoc($getCurrentQuestion);
$currentFormID=$curentQuesRow['form_id'];


$formGroups = mysqli_query($conn , "SELECT * FROM form_group WHERE status = '1' and form_id={$currentFormID} order by title");
$gArr = array();
while($gRow = mysqli_fetch_assoc($formGroups)){
    $gArr[$gRow['id']] = $gRow;
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

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between" style="float: right">


                                <a href="javascript:history.go(-1)" class="btn btn-warning waves-effect waves-light">Back To Listing</a>

                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">

                                <?php if(isset($_GET['id'])){
                                    $getID = $_GET['id'];
                                    $getQuestion = mysqli_query($conn , "SELECT * FROM questions WHERE id = '$getID'");
                                    $fetchUser = mysqli_fetch_assoc($getQuestion);

                                    ?>
                                    <form method="post" id="EvalidateForm">
                                        <div class="prompt"></div>

                                        <div class="form-group">
                                            <label for="title">Question</label>
                                            <input type="text" class="form-control" name="n[question]" value="<?php echo $fetchUser['question']; ?>" placeholder="Title" required="">

                                        </div>

                                        <div class="row">
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
                                                <div class="form-group">
                                                    <label for="title">Form</label>
                                                    <input type="text" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $fcArr[$fetchUser['form_id']]['name']; ?>" readonly>
                                                    <input type="hidden" class="form-control" name="n[form_id]" placeholder="Title" value="<?php echo $fetchUser['form_id']; ?>" readonly>
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
                                        </div>

                                        <input type="hidden" name="id" value="<?php echo $getID; ?>">

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="AddLoaderE">Duplicate Question</button>
                                        </div>
                                    </form>

                                <?php }
                              ?>
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
<script>




    $( '#EvalidateForm' ).validate( {
        submitHandler: function () {
            'use strict';
            $( "#AddLoaderE" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
            $('#AddLoaderE').attr('disabled',true)

            $.ajax( {
                dataType: 'json',
                url: "ajax.php?h=duplicateQuestion",
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
                            window.location.assign('/admin/subquestions-duplicate?id='+<?php echo $_GET['id'] ?>+'&nqid='+data.qid)

                        }, 500 );
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