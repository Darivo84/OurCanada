<?php

include( 'global.php' );
require $_SERVER[ 'DOCUMENT_ROOT' ].'/send-grid-email/vendor/autoload.php';
$sendGridAPIKey = "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"; #account:ocsadmin@ourcanada.co #pass:123456789ourcanada
//$sendGridAPIKey="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";



$date =  date("Y-m-d h:i:s A");

$getFieldTypes = mysqli_query($conn , "SELECT * FROM field_types");
$fieldArr = array();
while($f = mysqli_fetch_assoc($getFieldTypes)){
    $fieldArr[$f['id']] = $f;
}

if ( $_GET[ 'h' ] == 'AdminLogin' ) {

    $T = db_pair_str2( $_POST[ 'n' ] );
    $select = mysqli_query( $conn, "SELECT * FROM admin where email = '{$_POST['n']['email']}' AND password = '{$_POST['n']['password']}' AND status = '1'" );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        $_SESSION[ 'adminid' ] = $row[ 'id' ];
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'logged in successfully. Redirecting...', 'adminID' => $row[ 'id' ] ) ) );
    } else {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Invalid Email Address/Password' ) ) );
    }

}


// Add Form Fields
if ( $_GET[ 'h' ] == 'addFields' ) {

    $T = db_pair_str2( $_POST[ 'n' ] );
    $select = mysqli_query( $conn, "SELECT * FROM field_types where type = '{$_POST['n']['type']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Field with this type is already added. Please try a new one.') ) );
    } else {
        //echo "INSERT into field_types SET $T";
        $insert = mysqli_query($conn , "INSERT into field_types SET $T");
        if($insert){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Field Created Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding field.' ) ) );
        }

    }

}

// Add Form Fields
if ( $_GET[ 'h' ] == 'getFields' ) {
    $select = mysqli_query( $conn, "SELECT * FROM field_types where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        die( json_encode( array( 'Success' => 'true', 'data' => $row) ) );
    }
}


// Add Form Fields
if ( $_GET[ 'h' ] == 'updateFields' ) {

    $T = db_pair_str2( $_POST[ 'n' ] );
    $select = mysqli_query( $conn, "SELECT * FROM field_types where type = '{$_POST['n']['type']}' AND id != '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Field with this type is already added. Please try a new one.') ) );
    } else {
        $insert = mysqli_query($conn , "UPDATE field_types SET $T WHERE id = '{$_POST['id']}'");
        if($insert){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Field Updated Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while updating field.' ) ) );
        }

    }

}

// Add Form Fields
if ( $_GET[ 'h' ] == 'deleteField' ) {

    $select = mysqli_query( $conn, "SELECT * FROM field_types where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $del = mysqli_query($conn , "DELETE FROM field_types where id = '{$_POST['id']}'");
        if($del){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Field Deleted Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting field.' ) ) );
        }

    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting field.' ) ) );
    }
}



// Add Form Fields
if ( $_GET[ 'h' ] == 'addForms' ) {
    $_POST['n']['created_date'] = $date;
    $T = db_pair_str2( $_POST[ 'n' ] );
    $select = mysqli_query( $conn, "SELECT * FROM categories where type = '{$_POST['n']['name']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Form with this name is already added. Please try a new one.') ) );
    } else {
        $insert = mysqli_query($conn , "INSERT into categories SET $T");

        $last_id=mysqli_insert_id($conn);
        $_POST['k']['note']='Form has been created';
        $_POST['k']['form_id']=$last_id;
        $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
        $S = db_pair_str2( $_POST[ 'k' ] );
        $activity = mysqli_query($conn , "INSERT into activities SET $S");


        if($insert){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Field Created Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding field.' ) ) );
        }

    }

}



// Add Form Fields
if ( $_GET[ 'h' ] == 'getForms' ) {

    $select = mysqli_query( $conn, "SELECT * FROM categories where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        die( json_encode( array( 'Success' => 'true', 'data' => $row) ) );
    }
}


// Add Form Fields
if ( $_GET[ 'h' ] == 'updateForms' ) {

    $T = db_pair_str2( $_POST[ 'n' ] );
    $select = mysqli_query( $conn, "SELECT * FROM categories where type = '{$_POST['n']['type']}' AND id != '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Form with this type is already added. Please try a new one.') ) );
    } else {
        $insert = mysqli_query($conn , "UPDATE categories SET $T WHERE id = '{$_POST['id']}'");
        $last_id=mysqli_insert_id($conn);
        $_POST['k']['note']='Form has been created';
        $_POST['k']['form_id']=$_POST['id'];
        $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
        $S = db_pair_str2( $_POST[ 'k' ] );
        $activity = mysqli_query($conn , "INSERT into activities SET $S");
        if($insert){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Form Updated Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while updating form.' ) ) );
        }

    }

}

if ( $_GET[ 'h' ] == 'deleteForm' ) {

    $select = mysqli_query( $conn, "SELECT * FROM categories where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $del = mysqli_query($conn , "DELETE FROM categories where id = '{$_POST['id']}'");
        $last_id=mysqli_insert_id($conn);
        $_POST['k']['note']='Form has been created';
        $_POST['k']['form_id']=$_POST['id'];
        $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
        $S = db_pair_str2( $_POST[ 'k' ] );
        $activity = mysqli_query($conn , "INSERT into activities SET $S");
        if($del){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Form Deleted Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting field.' ) ) );
        }

    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting field.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'addQuestion' ) {
    $_POST['n']['created_date'] = $date;
    $T = db_pair_str2( $_POST[ 'n' ] );

    //echo "INSERT into questions SET $T";
    $insert = mysqli_query($conn , "INSERT into questions SET $T");
    $last_id=mysqli_insert_id($conn);
    $_POST['k']['note']='Question has been added';
    $_POST['k']['question_id']=$last_id;
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    if($insert){
        $question_id = mysqli_insert_id($conn);
        foreach($_POST['m']['label'] as $k => $v){
            if(!empty($_POST['m']['label'])){
                $V['question_id'] = $question_id;
                $V['label'] = $_POST['m']['label'][$k];
                $V['status'] = $_POST['m']['status'][$k];
                $V['value'] = $_POST['m']['value'][$k];
                $T = db_pair_str2( $V );
                $insert = mysqli_query($conn , "INSERT into question_labels SET $T");
            }
        }
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Created Successfully.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.' ) ) );
    }

}

if ( $_GET[ 'h' ] == 'duplicateQuestion' ) {
    $_POST['n']['created_date'] = $date;
    $T = db_pair_str2( $_POST[ 'n' ] );

    //echo "INSERT into questions SET $T";
    $insert = mysqli_query($conn , "INSERT into questions SET $T");
    if($insert){
        $question_id = mysqli_insert_id($conn);
        foreach($_POST['m']['label'] as $k => $v){
            if(!empty($_POST['m']['label'])){
                $V['question_id'] = $question_id;
                $V['label'] = $_POST['m']['label'][$k];
                $V['status'] = $_POST['m']['status'][$k];
                $V['value'] = $_POST['m']['value'][$k];
                $T = db_pair_str2( $V );
                $insert = mysqli_query($conn , "INSERT into question_labels SET $T");
            }
        }
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question duplicated Successfully.','qid'=>$question_id ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.' ) ) );
    }

}


if ( $_GET[ 'h' ] == 'getQuestion' ) {


    $select = mysqli_query( $conn, "SELECT * FROM questions where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );
        $row['field'] = $fieldArr[$row['fieldtype']]['type'];
        $arrLabels = array();
        $getLabels='';
        if($row['field']=='country')
        {
            $getLabels = mysqli_query($conn, "SELECT * FROM countries");

        }
        else if($row['field']=='education')
        {
            $getLabels = mysqli_query($conn, "SELECT * FROM education");

        }
        else
        {
            $getLabels = mysqli_query($conn, "SELECT * FROM question_labels WHERE question_id = '{$_POST['id']}' AND value != ''");
        }

        while($label = mysqli_fetch_assoc($getLabels)){
            $arrLabels[] = $label;
        }
        die( json_encode( array( 'Success' => 'true', 'data' => $row , 'Options' => $arrLabels) ) );
    }
}


if ( $_GET[ 'h' ] == 'updateQuestion' ) {

    if($_POST['n']['rel_qtype']=='m_question')
    {
        $_POST['n']['rel_qid']=$_POST['qid'];
    }
    else
    {
        $_POST['n']['rel_qid']=$_POST['sid'];

    }
    $T = db_pair_str2( $_POST[ 'n' ] );

    $insert = mysqli_query($conn , "UPDATE questions SET $T WHERE id = '{$_POST['id']}'");
    $_POST['k']['note']='Question has been updated';
    $_POST['k']['question_id']=$_POST['id'];
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    if($insert){

        mysqli_query($conn , "DELETE FROM question_labels WHERE question_id = '{$_POST['id']}'");

        foreach($_POST['m']['label'] as $k => $v){
            //echo $k;
            if(!empty($_POST['m']['label'][$k])){
                $V['question_id'] = $_POST['id'];
                $V['label'] = $_POST['m']['label'][$k];
                $V['status'] = $_POST['m']['status'][$k];
                $V['value'] = $_POST['m']['value'][$k];

                $T = db_pair_str2( $V );

                $insert = mysqli_query($conn , "INSERT into question_labels SET $T");
            }
        }



        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Updated Successfully.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while updating question.' ) ) );
    }



}


if ( $_GET[ 'h' ] == 'deleteQuestion' ) {

    $select = mysqli_query( $conn, "SELECT * FROM questions where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $del = mysqli_query($conn , "DELETE FROM questions where id = '{$_POST['id']}'");
        $del2 = mysqli_query($conn , "DELETE FROM sub_questions where question_id = '{$_POST['id']}'");
        $del3 = mysqli_query($conn , "DELETE FROM question_labels where question_id = '{$_POST['id']}'");
        $_POST['k']['note']='Question has been deleted';
        $_POST['k']['question_id']=$_POST['id'];
        $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
        $S = db_pair_str2( $_POST[ 'k' ] );
        $activity = mysqli_query($conn , "INSERT into activities SET $S");
        if($del){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Deleted Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting question.' ) ) );
        }

    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting question.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'duplicateSubQuestion' ) {

    $_POST['n']['created_date'] = $date;
    $_POST['s']['created_date'] = $date;
    $case_type=$_POST['s']['casetype'];;
    $_POST['n']['casetype'] =  $case_type;
    $M;
    $N;


    $T = db_pair_str2( $_POST[ 'n' ] );
    $insert1 = mysqli_query($conn , "INSERT into sub_questions SET $T");
    $_POST['s']['s_id'] = mysqli_insert_id($conn);
    $question_id=$_POST['s']['s_id'];

    $P = db_pair_str2( $_POST[ 's' ] );

    $insert2 = mysqli_query($conn , "INSERT into ques_logics SET $P");

    if($insert1){
        if ($case_type=='subquestion' || $case_type=='multicondition' || $case_type=='existingcheck') {

            if (!empty($_POST['m']['label'])) {
                foreach ($_POST['m']['label'] as $k => $v) {
                    $L['question_id'] = $question_id;
                    $L['label'] = $_POST['m']['label'][$k];
                    $L['status'] = $_POST['m']['status'][$k];
                    $L['value'] = $_POST['m']['value'][$k];
                    $M = db_pair_str2($L);

                    $insert = mysqli_query($conn, "INSERT into level1 SET $M");
                }
            }
        }


        if ($case_type=='multicondition') {
            $result=array_merge($_POST['c']['existing_sid'], $_POST['d']['existing_qid']);

            if (!empty($_POST['c']['question_type'])) {
                foreach ($_POST['c']['question_type'] as $k => $v) {
                    $V['s_id'] = $question_id;
                    $V['question_type'] = $_POST['c']['question_type'][$k];
                    if($_POST['c']['question_type'][$k] == 's_question'){
                        $V['existing_qid'] = 0;
                        $V['existing_sid'] = $_POST['c']['existing_sid'][$k];
                    }else{
                        $V['existing_sid'] = 0;
                        $V['existing_qid'] =  $_POST['d']['existing_qid'][$k];
                    }

                    if(!empty($_POST['c']['value'][$k])){
                        $V['value'] = $_POST['c']['value'][$k];
                    }else{
                        $V['value'] = $_POST['d']['value'][$k];
                    }
                    $V['operator'] = $_POST['c']['operator'][$k];
                    $N = db_pair_str2($V);

                    $insert = mysqli_query($conn, "INSERT into multi_conditions SET $N");
                }

            }


        }

        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Created Successfully.','a'=>$insert ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.') ) );
    }

}

if ( $_GET[ 'h' ] == 'addSubQuestion' ) {

    $_POST['n']['created_date'] = $date;
    $_POST['s']['created_date'] = $date;
    $case_type=$_POST['s']['casetype'];;
    $_POST['n']['casetype'] =  $case_type;
    $M;
    $N;


    $T = db_pair_str2( $_POST[ 'n' ] );
    $insert1 = mysqli_query($conn , "INSERT into sub_questions SET $T");
    $last_id=mysqli_insert_id($conn);
    $_POST['k']['note']='Sub Question has been added';
    $_POST['k']['sub_question_id']=$last_id;
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    $question_id=$last_id;


    $_POST['s']['s_id'] = $last_id;
    $P = db_pair_str2( $_POST[ 's' ] );

    $insertttt = mysqli_query($conn , "INSERT into ques_logics SET $P");



    if($insert1){

        if ($case_type=='subquestion' || $case_type=='multicondition' || $case_type=='existingcheck') {

            if (!empty($_POST['m']['label'])) {
                foreach ($_POST['m']['label'] as $k => $v) {
                    $L['question_id'] = $question_id;
                    $L['label'] = $_POST['m']['label'][$k];
                    $L['status'] = $_POST['m']['status'][$k];
                    $L['value'] = $_POST['m']['value'][$k];
                    $M = db_pair_str2($L);

                    $insert = mysqli_query($conn, "INSERT into level1 SET $M");
                }
            }
        }

        if ($case_type=='multicondition') {
            $result=array_merge($_POST['c']['existing_sid'], $_POST['d']['existing_qid']);

            if (!empty($_POST['c']['question_type'])) {
                foreach ($_POST['c']['question_type'] as $k => $v) {
                    $V['s_id'] = $question_id;
                    $V['op']=$_POST['cc']['op'];
                    $V['question_type'] = $_POST['c']['question_type'][$k];
                    if($_POST['c']['question_type'][$k] == 's_question'){
                        $V['existing_qid'] = 0;
                        $V['existing_sid'] = $_POST['c']['existing_sid'][$k];
                    }else{
                        $V['existing_sid'] = 0;
                        $V['existing_qid'] =  $_POST['d']['existing_qid'][$k];
                    }

                    if(!empty($_POST['c']['value'][$k])){
                        $V['value'] = $_POST['c']['value'][$k];
                    }else{
                        $V['value'] = $_POST['d']['value'][$k];
                    }
                    $V['operator'] = $_POST['c']['operator'][$k];
                    $N = db_pair_str2($V);

                    $insert = mysqli_query($conn, "INSERT into multi_conditions SET $N");
                }

            }


        }

        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Created Successfully.','a'=>$insert ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.') ) );
    }

}

if ( $_GET[ 'h' ] == 'editSubQuestion' ) {

//    print_r($_POST);die();

    $case_type=$_POST['s']['casetype'];;
    $_POST['n']['casetype'] =  $case_type;
    $M;
    $id=$_POST['id'];
    $qid=$_POST['qid'];
    if($_POST['n']['rel_qtype']=='m_question')
    {
        $_POST['n']['rel_qid']=$_POST['qqid'];
    }
    else
    {
        $_POST['n']['rel_qid']=$_POST['ssid'];

    }
    $T = db_pair_str2( $_POST[ 'n' ] );
    $P = db_pair_str2( $_POST[ 's' ] );


    $insert = mysqli_query($conn , "UPDATE sub_questions SET 	questiontype=NULL,existing_qid=NULL,existing_sid=NULL,value=NULL,group_id=NULL,email=NULL,content=NULL,fieldtype=NULL,labeltype=0,question=NULL,notes=NULL,validation=NULL,group_ques_id=NULL,group_operator=NULL,status=1 where id=$id");

    $insert1 = mysqli_query($conn , "UPDATE sub_questions SET $T where id=$id");

    $_POST['k']['note']='Sub Question has been updated';
    $_POST['k']['sub_question_id']=$id;
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");

    $insert2 = mysqli_query($conn , "UPDATE ques_logics SET $P where s_id=$id");
    if($insert2)
    {
        $_POST['s']['s_id']=$id;
        $_POST['s']['created_date']=$date;
        $P = db_pair_str2( $_POST[ 's' ] );

        $insert2 = mysqli_query($conn , "insert into ques_logics SET $P");
    }
    $delete1 = mysqli_query($conn , "DELETE from level1  where question_id=$id");
    $delete1 = mysqli_query($conn , "DELETE from multi_conditions  where s_id=$id");

    if($insert2){
        if ($case_type=='subquestion' || $case_type=='multicondition' || $case_type=='existingcheck') {


            if (!empty($_POST['m']['label'])) {
                foreach ($_POST['m']['label'] as $k => $v) {
                    $L['question_id'] = $id;
                    $L['label'] = $_POST['m']['label'][$k];
                    $L['status'] = $_POST['m']['status'][$k];
                    $L['value'] = $_POST['m']['value'][$k];
                    $M = db_pair_str2($L);
                    $insert = mysqli_query($conn, "INSERT into level1 SET $M");
                }
            }

        }
        if ($case_type=='multicondition') {
            $result=array_merge($_POST['c']['existing_sid'], $_POST['d']['existing_qid']);


            if (!empty($_POST['c']['question_type'])) {
                foreach ($_POST['c']['question_type'] as $k => $v) {
                    $V['s_id'] = $id;
                    $V['op']=$_POST['cc']['op'];

                    $V['question_type'] = $_POST['c']['question_type'][$k];
                    if($_POST['c']['question_type'][$k] == 's_question'){
                        $V['existing_qid'] = 0;
                        $V['existing_sid'] = $_POST['c']['existing_sid'][$k]==''?$_POST['c']['existing_sid'][$k-1]:$_POST['c']['existing_sid'][$k];
                    }else{
                        $V['existing_sid'] = 0;
                        $V['existing_qid'] =  $_POST['c']['existing_qid'][$k]==''? $_POST['c']['existing_qid'][$k-1]: $_POST['c']['existing_qid'][$k];
                    }

//                    if(!empty($_POST['c']['value'][$k])){
//                        $V['value'] = $_POST['c']['value'][$k];
//                    }else{
//                        $V['value'] = $_POST['d']['value'][$k];
//                    }
                    $V['value'] = $_POST['c']['value'][$k]==''?$_POST['c']['value'][$k+1]:$_POST['c']['value'][$k];
                    $V['operator'] = $_POST['c']['operator'][$k];

                    $N = db_pair_str2($V);

                    $insert = mysqli_query($conn, "INSERT into multi_conditions SET $N");
                }

            }


        }



        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question updated Successfully.','a'=>$T,'b'=>$S,'m'=>$M ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.' ,'a'=>$T,'b'=>$S,'m'=>$M) ) );
    }

}
if ( $_GET[ 'h' ] == 'deleteSubques' ) {
    $act['k']['note']='Sub Question has been deleted';
    $act['k']['sub_question_id']=$_POST['id'];
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );

    $activity = mysqli_query($conn , "INSERT into activities set $S");

    $select = mysqli_query( $conn, "SELECT * FROM sub_questions where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $del = mysqli_query($conn , "DELETE FROM sub_questions where id = '{$_POST['id']}'");
        $del2 = mysqli_query($conn , "DELETE FROM ques_logics where s_id = '{$_POST['id']}'");
        $del3 = mysqli_query($conn , "DELETE FROM level1 where question_id = '{$_POST['id']}'");


        if($del){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Deleted Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting question.' ) ) );
        }

    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting field.' ) ) );
    }
}



if ( $_GET[ 'h' ] == 'addSubQuestion2' ) {

    $_POST['n']['created_date'] = $date;
    $_POST['s']['created_date'] = $date;
    $case_type=$_POST['s']['casetype'];;
    $_POST['n']['casetype'] =  $case_type;
    $M;
    $N;


    $T = db_pair_str2( $_POST[ 'n' ] );
    $insert1 = mysqli_query($conn , "INSERT into level2_sub_questions SET $T");

    $last_id=mysqli_insert_id($conn);
    $_POST['k']['note']='Level 2 Sub Question has been added';
    $_POST['k']['sub_question_id_2']=$last_id;
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");

    $_POST['s']['s_id'] = $last_id;
    $question_id=$_POST['s']['s_id'];

    $P = db_pair_str2( $_POST[ 's' ] );

    $insert2 = mysqli_query($conn , "INSERT into level2_ques_logics SET $P");


    if($insert2){
        if ($case_type=='subquestion' || $case_type=='multicondition' || $case_type=='existingcheck') {

            if (!empty($_POST['m']['label'])) {
                foreach ($_POST['m']['label'] as $k => $v) {
                    $L['question_id'] = $question_id;
                    $L['label'] = $_POST['m']['label'][$k];
                    $L['status'] = $_POST['m']['status'][$k];
                    $L['value'] = $_POST['m']['value'][$k];
                    $M = db_pair_str2($L);

                    $insert = mysqli_query($conn, "INSERT into level2 SET $M");
                }
            }
        }


        if ($case_type=='multicondition') {
            $result=array_merge($_POST['c']['existing_sid'], $_POST['d']['existing_qid']);

            if (!empty($_POST['c']['question_type'])) {
                foreach ($_POST['c']['question_type'] as $k => $v) {
                    $V['s_id'] = $question_id;
                    $V['question_type'] = $_POST['c']['question_type'][$k];
                    if($_POST['c']['question_type'][$k] == 's_question'){
                        $V['existing_qid'] = 0;
                        $V['existing_sid'] = $_POST['c']['existing_sid'][$k];
                    }else{
                        $V['existing_sid'] = 0;
                        $V['existing_qid'] =  $_POST['d']['existing_qid'][$k];
                    }

                    if(!empty($_POST['c']['value'][$k])){
                        $V['value'] = $_POST['c']['value'][$k];
                    }else{
                        $V['value'] = $_POST['d']['value'][$k];
                    }
                    $V['operator'] = $_POST['c']['operator'][$k];
                    $N = db_pair_str2($V);

                    $insert = mysqli_query($conn, "INSERT into level2_multi_conditions SET $N");
                }

            }


        }

        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Created Successfully.','a'=>$insert ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.') ) );
    }

}

if ( $_GET[ 'h' ] == 'editSubQuestion2' ) {
//    $_POST['n']['created_date'] = $date;
//    $_POST['s']['created_date'] = $date;
    $case_type=$_POST['s']['casetype'];;
    $_POST['n']['casetype'] =  $case_type;
    $M;
    $id=$_POST['id'];
    $qid=$_POST['qid'];

    $T = db_pair_str2( $_POST[ 'n' ] );
    $P = db_pair_str2( $_POST[ 's' ] );


//
//    $insert = mysqli_query($conn , "UPDATE sub_questions SET email=NULL where id='$id'");
//if($insert)
//    die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question updated Successfully.') ) );
//}else{
//    die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.') ) );
//}
    $insert = mysqli_query($conn , "UPDATE level2_sub_questions SET email=NULL where id=$id");

    $insert1 = mysqli_query($conn , "UPDATE level2_sub_questions SET $T where id=$id");

    $_POST['k']['note']='Level 2 Sub Question has been updated';
    $_POST['k']['sub_question_id_2']=$id;
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");

    $insert2 = mysqli_query($conn , "UPDATE level2_ques_logics SET $P where s_id=$id");
    if($insert2)
    {
        $_POST['s']['s_id']=$id;
        $_POST['s']['created_date']=$date;
        $P = db_pair_str2( $_POST[ 's' ] );

        $insert2 = mysqli_query($conn , "insert into level2_ques_logics SET $P");
    }
    $delete1 = mysqli_query($conn , "DELETE from level2  where question_id=$id");
    $delete1 = mysqli_query($conn , "DELETE from level2_multi_conditions  where s_id=$id");



    if($insert2){
        if ($case_type=='subquestion' || $case_type=='multicondition' || $case_type=='existingcheck') {


            if (!empty($_POST['m']['label'])) {
                foreach ($_POST['m']['label'] as $k => $v) {
                    $L['question_id'] = $id;
                    $L['label'] = $_POST['m']['label'][$k];
                    $L['status'] = $_POST['m']['status'][$k];
                    $L['value'] = $_POST['m']['value'][$k];
                    $M = db_pair_str2($L);
                    $insert = mysqli_query($conn, "INSERT into level2 SET $M");
                }
            }

        }
        if ($case_type=='multicondition') {
            $result=array_merge($_POST['c']['existing_sid'], $_POST['d']['existing_qid']);

            if (!empty($_POST['c']['question_type'])) {
                foreach ($_POST['c']['question_type'] as $k => $v) {
                    $V['s_id'] = $id;
                    $V['question_type'] = $_POST['c']['question_type'][$k];
                    if($_POST['c']['question_type'][$k] == 's_question'){
                        $V['existing_qid'] = 0;
                        $V['existing_sid'] = $_POST['c']['existing_sid'][$k];
                    }else{
                        $V['existing_sid'] = 0;
                        $V['existing_qid'] =  $_POST['d']['existing_qid'][$k];
                    }

                    if(!empty($_POST['c']['value'][$k])){
                        $V['value'] = $_POST['c']['value'][$k];
                    }else{
                        $V['value'] = $_POST['d']['value'][$k];
                    }
                    $V['operator'] = $_POST['c']['operator'][$k];

                    $N = db_pair_str2($V);

                    $insert = mysqli_query($conn, "INSERT into level2_multi_conditions SET $N");
                }

            }


        }



        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question updated Successfully.','a'=>$T,'b'=>$S,'m'=>$M ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.' ,'a'=>$T,'b'=>$S,'m'=>$M) ) );
    }

}
if ( $_GET[ 'h' ] == 'deleteSubques2' ) {

    $select = mysqli_query( $conn, "SELECT * FROM level2_sub_questions where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {
        $del = mysqli_query($conn , "DELETE FROM level2_sub_questions where id = '{$_POST['id']}'");
        $del2 = mysqli_query($conn , "DELETE FROM level2_ques_logics where s_id = '{$_POST['id']}'");
        $del3 = mysqli_query($conn , "DELETE FROM level2 where question_id = '{$_POST['id']}'");

        $_POST['k']['note']='Level 2 Sub Question has been deleted';
        $_POST['k']['sub_question_id_2']=$_POST['id'];
        $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
        $S = db_pair_str2( $_POST[ 'k' ] );
        $activity = mysqli_query($conn , "INSERT into activities SET $S");

        if($del){
            die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Deleted Successfully.' ) ) );
        }else{
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting question.' ) ) );
        }

    } else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while deleting field.' ) ) );
    }
}

if ( $_GET[ 'h' ] == 'addLogics' ) {

    $insert = mysqli_query($conn , "DELETE FROM ques_logics WHERE s_id = '{$_POST['s_id']}'");

    foreach($_POST['m']['title'] as $k => $v){
        //echo $k;
        if(!empty($_POST['m']['title'][$k])){
            $V['s_id'] = $_POST['s_id'];
            $V['operator'] = $_POST['m']['operator'][$k];
            $V['value'] = $_POST['m']['value'][$k];
            $V['title'] = $_POST['m']['title'][$k];
            $V['fieldtype'] = $_POST['m']['fieldtype'][$k];
            $V['status'] = $_POST['m']['status'][$k];

            $T = db_pair_str2( $V );
            //echo "INSERT into ques_logics SET $T";
            $insert = mysqli_query($conn , "INSERT into ques_logics SET $T");
        }
    }
    die( json_encode( array( 'Success' => 'true', 'Msg' => 'Question Created Successfully.' ) ) );

}

if($_GET['h'] == 'getSubQuestion'){
    $select = mysqli_query( $conn, "SELECT * FROM sub_questions where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {

        $row = mysqli_fetch_assoc($select);
        $row['field'] = $fieldArr[$row['fieldtype']]['type'];
        $arrLabels = array();
        $bool=false;
        if($row['field']=='country')
        {
            $getLabels = mysqli_query($conn, "SELECT * FROM countries");
            $bool=true;

        }
        else if($row['field']=='education')
        {
            $getLabels = mysqli_query($conn, "SELECT * FROM education");
            $bool=true;
        }
        else {
            $getLabels = mysqli_query($conn, "SELECT * FROM level1 WHERE question_id = '{$_POST['id']}'");
            $bool=false;
        }
        while($label = mysqli_fetch_assoc($getLabels)){
            if($bool)
            {
                $label['value']=$label['name'];
            }
            $arrLabels[] = $label;
        }
        die( json_encode( array( 'Success' => 'true', 'data' => $row , 'Options' => $arrLabels) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Options' => $arrLabels,'data' => $row) ) );
    }
}
if($_GET['h'] == 'getSubQuestion2'){
    $select = mysqli_query( $conn, "SELECT * FROM level2_sub_questions where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {

        $row = mysqli_fetch_assoc($select);
        $row['field'] = $fieldArr[$row['fieldtype']]['type'];
        $arrLabels = array();
        $getLabels = mysqli_query($conn , "SELECT * FROM level2 WHERE question_id = '{$_POST['id']}'");
        while($label = mysqli_fetch_assoc($getLabels)){
            $arrLabels[] = $label;
        }
        die( json_encode( array( 'Success' => 'true', 'data' => $row , 'Options' => $arrLabels) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Options' => $arrLabels,'data' => $row) ) );
    }
}



if ( $_GET[ 'h' ] == 'addGroup' ) {
    $_POST['n']['created_date'] = $date;
    $T = db_pair_str2( $_POST[ 'n' ] );

    //echo "INSERT into questions SET $T";
    $insert = mysqli_query($conn , "INSERT into form_group SET $T");
    if($insert){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Group Created Successfully.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.' ) ) );
    }

}
if ( $_GET[ 'h' ] == 'addSubGroup' ) {
    $score_type=strtolower($_POST['n']['name']);
    $_POST['n']['name']=$score_type;
    $T = db_pair_str2( $_POST[ 'n' ] );

    $select=mysqli_query($conn,"select * from sub_groups where name='$score_type'");
    if(mysqli_num_rows($select) > 0)
    {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Sub Group already exists' ) ) );
    }
    $insert = mysqli_query($conn , "INSERT into sub_groups SET $T");
    if($insert){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Sub Group Created Successfully.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding sub group.' ) ) );
    }

}
if ( $_GET[ 'h' ] == 'addScoreType' ) {

    $score_type=strtolower($_POST['n']['name']);
    $_POST['n']['name']=$score_type;
    $T = db_pair_str2( $_POST[ 'n' ] );

    $select=mysqli_query($conn,"select * from score_type where name='$score_type'");
    if(mysqli_num_rows($select) > 0)
    {
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Score type already exists' ) ) );
    }

    $insert = mysqli_query($conn , "INSERT into score_type SET $T");
    if($insert){
        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Score Type Created Successfully.' ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding score group.' ) ) );
    }

}
if ( $_GET[ 'h' ] == 'getGroupQuest' ) {

    $question=[];
    $insert = mysqli_query($conn , "select * from questions where group_id={$_POST['id']}");
    if(mysqli_num_rows($insert) > 0)
    {
        while($row=mysqli_fetch_assoc($insert))

            $question[]=$row;

        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Group Created Successfully.','questions'=>$question ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.','questions'=>$question  ) ) );
    }

}
if ( $_GET[ 'h' ] == 'getGroupQuest' ) {

    $question=[];
    $insert = mysqli_query($conn , "select * from questions where group_id={$_POST['id']}");
    if(mysqli_num_rows($insert) > 0)
    {
        while($row=mysqli_fetch_assoc($insert))

            $question[]=$row;

        die( json_encode( array( 'Success' => 'true', 'Msg' => 'Group Created Successfully.','questions'=>$question ) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.','questions'=>$question  ) ) );
    }

}
if ( $_GET[ 'h' ] == 'getGroupQuestLabel' ) {

    $question = [];
    $html = '';
    if($_POST['type']=='qid')
        $select = mysqli_query($conn, "select * from questions where id={$_POST['id']}");
    else
        $select = mysqli_query($conn, "select * from sub_questions where id={$_POST['id']}");

    $r = mysqli_fetch_assoc($select);
    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
    $fldArr = array();
    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
        $fldArr[$fld['id']] = $fld;
    }
    if ($fldArr[$r['fieldtype']]['type'] == 'radio' && $r['labeltype'] == 0) {
        $html .='<select class="form-control selectBox groupInputs" name="n[value]" required>';
        $html .= '<option value="Yes">Yes</option>';
        $html .= '<option value="No">No</option>';
        $html .='</select>';

    } else if ($fldArr[$r['fieldtype']]['type'] == 'radio' && $r['labeltype'] == 1) {
        if($_POST['type']=='qid')
            $insert = mysqli_query($conn, "select * from question_labels where question_id={$_POST['id']} and value!=''");
        else
            $insert = mysqli_query($conn, "select * from level1 where question_id={$_POST['id']} and value!=''");


        $html .='<select class="form-control selectBox groupInputs" name="n[value]" required>';

        while ($row = mysqli_fetch_assoc($insert)) {
            $html .= '<option value="'.$row['value'].'">'.$row['label'].'</option>';
        }
        $html .='</select>';

    }
    else if ($fldArr[$r['fieldtype']]['type'] == 'dropdown') {

        if($_POST['type']=='qid')
            $insert = mysqli_query($conn, "select * from question_labels where question_id={$_POST['id']} and value!=''");
        else
            $insert = mysqli_query($conn, "select * from level1 where question_id={$_POST['id']} and value!=''");
        $html .='<select class="form-control selectBox groupInputs" name="n[value]" required>';

        while ($row = mysqli_fetch_assoc($insert)) {
            $html .= '<option value="'.$row['value'].'">'.$row['label'].'</option>';
        }
        $html .='</select>';
    }
    else
    {
        $html.='<input required type="text" name="n[value]" class="form-control groupInputs">';
    }

    if ($select){
        die(json_encode(array('Success' => 'true', 'Msg' => 'Group Created Successfully.', 'questions' => $html)));
    }

    else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.','questions'=>$html  ) ) );
    }

}
if ( $_GET[ 'h' ] == 'getGroupQuestLabel2' ) {

    $question = [];
    $html = '';
    if($_POST['type']=='qid')
        $select = mysqli_query($conn, "select * from sub_questions where id={$_POST['id']}");
    else
        $select = mysqli_query($conn, "select * from level2_sub_questions where id={$_POST['id']}");

    $r = mysqli_fetch_assoc($select);
    $getFieldTypes = mysqli_query($conn, "SELECT * FROM field_types");
    $fldArr = array();
    while ($fld = mysqli_fetch_assoc($getFieldTypes)) {
        $fldArr[$fld['id']] = $fld;
    }
    if ($fldArr[$r['fieldtype']]['type'] == 'radio' && $r['labeltype'] == 0) {
        $html .='<select class="form-control selectBox groupInputs" name="n[value]" required>';
        $html .= '<option value="Yes">Yes</option>';
        $html .= '<option value="No">No</option>';
        $html .='</select>';

    } else if ($fldArr[$r['fieldtype']]['type'] == 'radio' && $r['labeltype'] == 1) {
        if($_POST['type']=='qid')
            $insert = mysqli_query($conn, "select * from question_labels where question_id={$_POST['id']} and value!=''");
        else
            $insert = mysqli_query($conn, "select * from level1 where question_id={$_POST['id']} and value!=''");


        $html .='<select class="form-control selectBox groupInputs" name="n[value]" required>';

        while ($row = mysqli_fetch_assoc($insert)) {
            $html .= '<option value="'.$row['value'].'">'.$row['label'].'</option>';
        }
        $html .='</select>';

    }
    else if ($fldArr[$r['fieldtype']]['type'] == 'dropdown') {

        if($_POST['type']=='qid')
            $insert = mysqli_query($conn, "select * from question_labels where question_id={$_POST['id']} and value!=''");
        else
            $insert = mysqli_query($conn, "select * from level1 where question_id={$_POST['id']} and value!=''");
        $html .='<select class="form-control selectBox groupInputs" name="n[value]" required>';

        while ($row = mysqli_fetch_assoc($insert)) {
            $html .= '<option value="'.$row['value'].'">'.$row['label'].'</option>';
        }
        $html .='</select>';
    }
    else
    {
        $html.='<input required type="text" name="n[value]" class="form-control groupInputs">';
    }

    if ($select){
        die(json_encode(array('Success' => 'true', 'Msg' => 'Group Created Successfully.', 'questions' => $html)));
    }

    else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong while adding question.','questions'=>$html  ) ) );
    }

}


if ( $_GET[ 'h' ] == 'addScore' ) {

//    print_r($_POST);
//  die();
    $M;
    $N;
    $G;
    $type1='or';
    $type2='and';
    $type3='grouped';
    $type4='both';
    $b=false;
    $i=$j=$n=$ni=$p=$l=$job=$emp=0;


    $case=$_POST['n']['casetype'];
    $noc=$_POST['n']['noc'];
    $T = db_pair_str2($_POST['n']);
    $insert1 = mysqli_query($conn, "INSERT into score SET $T");
    $score_id = mysqli_insert_id($conn);

    $act['k']['note']='Score has been added';
    $act['k']['score_id']=$score_id;
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");

    if($case=='scoreType')
    {
        $_POST['t']['score_id']=$score_id;
        $P = db_pair_str2($_POST['t']);
        $insert5 = mysqli_query($conn, "INSERT into score_ontype SET $P");

    }
    else if($case=='existing')
    {
        if($_POST['e']['move_qtype']=='s_question')
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_sid'];
        }
        else
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_qid'];

        }
        $_POST['ex']['move_qtype']=$_POST['e']['move_qtype'];
        $_POST['ex']['type']=$case;

        $_POST['ex']['score_id']=$score_id;
        $P = db_pair_str2($_POST['ex']);
        $insert5 = mysqli_query($conn, "INSERT into score_questions SET $P");


    }
    if($noc==1)
    {
        $auth=0;
        foreach ($_POST['noc']['user_type'] as $k => $v) {
            $nm['score_id'] = $score_id;
            $nm['noc_type'] = $_POST['noc']['noc_type'][$k];
            $nm['user_type'] = $_POST['noc']['user_type'][$k];
            $nm['operator'] = $_POST['noc']['operator'][$k];
            $nm['value'] = $_POST['noc']['value'][$k];
            $nm['country'] = $_POST['noc']['country'][$k];
            $nm['noc_number'] = $_POST['noc']['noc_number'][$k];
            $nm['country_operator'] = $_POST['noc']['country_operator'][$k];
            $nm['conditionn'] = $_POST['noc']['conditionn'][$k];
            $nm['score_number'] = $_POST['noc']['score_number'][$k];
            $nm['wage'] = $_POST['noc']['wage'][$k];
            $nm['hours'] = $_POST['noc']['hours'][$k];
            $nm['wage_operator'] = $_POST['noc']['wage_operator'][$k];
            $nm['hours_operator'] = $_POST['noc']['hours_operator'][$k];
            $nm['province_operator'] = $_POST['noc']['province_operator'][$k];
            $nm['noc_operator'] = $_POST['noc']['noc_operator'][$k];
            $nm['previous_years'] = $_POST['noc']['previous_years'][$k];
            $nm['job_offer'] = $_POST['jobCheck'][$k];
            $nm['employment'] = $_POST['empCheck'][$k];
            $nm['same'] = $_POST['sameCheck'][$k];
            $nm['same_job'] = $_POST['sameJobCheck'][$k];
            $nm['open_bracket'] = $_POST['noc']['open_bracket'][$k];
            $nm['close_bracket'] = $_POST['noc']['close_bracket'][$k];
            $nm['noc_or'] = $_POST['ques_or'][$k];


            $nm['region']='';
            $nm['province']='';
            $nm['authorization']='';

            $authR=array_keys($_POST['noc']['province']);
            foreach ($_POST['noc']['province'][$authR[$auth]] as $val) {
                $nm['province'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['authorization']);
            foreach ($_POST['noc']['authorization'][$authR[$auth]] as $val) {
                $nm['authorization'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['region']);
            foreach ($_POST['noc']['region'][$authR[$auth]] as $val) {
                $nm['region'] .= $val . ',';
            }
            $auth++;

//            foreach ($_POST['noc']['province'][$k+1] as $val)
//            {
//                $nm['province'] .= $val.',';
//            }
//            foreach ($_POST['noc']['authorization'][$k+1] as $val)
//            {
//                $nm['authorization'] .= $val.',';
//            }
//            foreach ($_POST['noc']['region'][$k+1] as $val)
//            {
//                $nm['region'] .= $val.',';
//            }
//            foreach ($_POST['noc']['job_offer'][$k+1] as $val)
//            {
//                $nm['job_offer'] = $val;
//            }
//            foreach ($_POST['noc']['employment'][$k+1] as $val)
//            {
//                $nm['employment'] = $val;
//            }

            if($nm['noc_number']=='' || $nm['noc_number']!='') {
                $nm['skill'] = $_POST['noc']['skill'][$p];
                $p++;
            }

            if($nm['conditionn']=='question')
            {
                $nm['move_qtype']=$_POST['move']['type'];
                if($_POST['move']['type']=='s_question')
                {
                    $nm['move_qid']=$_POST['move']['sid'];
                }
                else
                {
                    $nm['move_qid']=$_POST['move']['qid'];
                }

            }
            else if($nm['conditionn']=='scoring')
            {
                $nm['move_scoreType']=$_POST['move']['scoreType'];
            }

            $Q = db_pair_str2($nm);

            $insert6 = mysqli_query($conn, "INSERT into score_noc SET $Q");
        }

    }


    if ($insert1)
    {
        foreach ($_POST['c']['operator'] as $k => $v) {
            $L['score_id'] = $score_id;
            $L['operator'] = $_POST['c']['operator'][$k];
            $L['value'] = $_POST['c']['value'][$k];
            $L['score_number'] = $_POST['c']['score_number'][$k];
            $M = db_pair_str2($L);
            $insert = mysqli_query($conn, "INSERT into score_conditions SET $M");
            $b=true;
        }
        if($b==false && isset($_POST['c']['score_number']))
        {
            $score_number= $_POST['c']['score_number'];

            $insert = mysqli_query($conn, "INSERT into score_conditions (score_id,score_number) values ($score_id,'$score_number')");

        }

        foreach ($_POST['z']['question_type'] as $k => $v) {
            $a['score_id'] = $score_id;
            $a['question_type'] = $_POST['z']['question_type'][$k];
            $a['question_id'] = $_POST['z']['question_id'][$k];
            $a['user_type'] = $_POST['z']['user_type'][$k];
            $a['type']=$type1;

            $N = db_pair_str2($a);

            $insert = mysqli_query($conn, "INSERT into score_questions SET $N");

        }
        foreach ($_POST['x']['question_type'] as $k => $v) {
            $b['score_id'] = $score_id;
            $b['question_type'] = $_POST['x']['question_type'][$k];
            $b['question_id'] = $_POST['x']['question_id'][$k];
            $b['user_type'] = $_POST['x']['user_type'][$k];
            $b['operator'] = $_POST['x']['operator'][$k];
            $b['value'] = $_POST['x']['value'][$k];
            $b['score_case'] = $_POST['x']['score_case'][$k];


            $b['type']=$type2;

            $G = db_pair_str2($b);

            $insert = mysqli_query($conn, "INSERT into score_questions SET $G");

        }
        $av1=0;
        foreach ($_POST['y']['score_case'] as $k => $v) {
            $c['score_id'] = $score_id;
            $c['question_id'] = $_POST['y']['question_id'][$k];
            $c['user_type'] = $_POST['y']['user_type'][$k];
            $c['operator'] = $_POST['y']['operator'][$k];
            $c['score_case'] = $_POST['y']['score_case'][$k];
            $c['other_case'] = $_POST['other'][$k];

            $c['type']=$type3;

            $c['value']='';
            $av=array_keys($_POST['y']['value']);
            foreach ($_POST['y']['value'][$av[$av1]] as $val) {
                $c['value'] .= $val . '*';
            }
            $av1++;

            if($c['score_case']=='1')
            {
                $c['question_type'] = '';
                $dc['question_id'] = '';
                $dc['tests'] = $_POST['y']['tests'][$ni];
                $ni++;
            }
            else
            {
                $c['question_type'] = $_POST['y']['question_type'][$n];
                $c['question_id'] = $_POST['y']['question_id'][$n];
                $n++;
            }


            if($_POST['other'][$k]=='condition')
            {
                $c['condition2'] = $_POST['y']['condition2'][$j];
                $c['score_number']='';
                $j++;
            }
            else
            {
                $c['score_number'] = $_POST['y']['score_number'][$i];
                $c['condition2']='';
                $i++;
            }

            $G = db_pair_str2($c);

            $insert = mysqli_query($conn, "INSERT into score_questions SET $G");

            $c['value'] ='';
        }
        $av2=0;

        foreach ($_POST['a']['score_case'] as $k => $v) {
            $d['score_id'] = $score_id;
            $d['score_case'] = $_POST['a']['score_case'][$k];
            $d['label_type'] = $_POST['a']['label_type'][$k];
            $d['open_bracket'] = $_POST['a']['open_bracket'][$k];
            $d['close_bracket'] = $_POST['a']['close_bracket'][$k];
            $d['start_bracket'] = $_POST['a']['start_bracket'][$k];
            $d['end_bracket'] = $_POST['a']['end_bracket'][$k];
            $d['noc_or'] = $_POST['noc_or'][$k];
            $d['skip_question'] = $_POST['skip_question'][$k];

            $d['value']='';
            $av=array_keys($_POST['a']['value']);
            foreach ($_POST['a']['value'][$av[$av2]] as $val) {
                $d['value'] .= $val . '*';
            }
            $av2++;
            if($d['score_case']=='1')
            {
                $d['question_type'] = '';
                $d['question_id'] = '';
                $d['tests'] = $_POST['a']['tests'][$ni];
                $ni++;
            }
            else
            {
                $d['question_type'] = $_POST['a']['question_type'][$n];
                $d['question_id'] = $_POST['a']['question_id'][$n];
                $n++;
            }
            $d['user_type'] = $_POST['a']['user_type'][$k];
            $d['operator'] = $_POST['a']['operator'][$k];
//                $d['value'] = $_POST['a']['value'][$k];
            $d['type']=$type4;
            $d['other_case']=$_POST['other'][$k];
            if($_POST['other'][$k]=='question')
            {
                $d['move_qtype']=$_POST['move']['type'];
                if($_POST['move']['type']=='s_question')
                {
                    $d['move_qid']=$_POST['move']['sid'];

                }
                else
                {
                    $d['move_qid']=$_POST['move']['qid'];

                }
                $d['score_number']='';
                $d['condition2']='';
            }
            if($_POST['other'][$k]=='email')
            {
                $d['email']=$_POST['t']['email'];
                $d['subject']=$_POST['t']['subject'];
                $d['message']=$_POST['t']['message'];
                $d['cc']=$_POST['t']['cc'];

                $d['score_number']='';
                $d['condition2']='';
            }
            else if($_POST['other'][$k]=='scoring')
            {

                $d['move_scoreType']=$_POST['move']['scoreType'];

                $d['score_number']='';
                $d['condition2']='';

            }
            else if($_POST['other'][$k]=='comment')
            {

                $d['comments']=$_POST['comments'];

                $d['score_number']='';
                $d['condition2']='';

            }
            else if($_POST['other'][$k]=='condition')
            {
                $d['condition2'] = $_POST['a']['condition2'][$j];
                $d['score_number']='';
                $j++;
            }
            else
            {
                $d['score_number'] = $_POST['a']['score_number'][$i];
                $d['condition2']='';
                $i++;
            }


            $F = db_pair_str2($d);
            $insert = mysqli_query($conn, "INSERT into score_questions SET $F");

            $d['value']='';
        }


        spouseScoring($conn,$score_id);


        die(json_encode(array('Success' => 'true', 'Msg' => 'Score added Successfully.', 'a' => $insert ,'data'=>$_POST)));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding score.')));
    }
}
function spouseScoring($conn,$score_id)
{
    $qselect = mysqli_query($conn , "SELECT * FROM score_questions where score_id=$score_id");
    while($qrow=mysqli_fetch_assoc($qselect))
    {
        if($qrow['score_case']==0)
        {
            if($qrow['question_type']=='m_question')
            {
                $q = mysqli_query($conn , "SELECT * FROM questions where id={$qrow['question_id']}");
                $r=mysqli_fetch_assoc($q);

                if($r['relate']==1)
                {
                    $qrow['question_type']=$r['rel_qtype'];
                    $qrow['question_id']=$r['rel_qid'];
                }

            }
            else if($qrow['question_type']=='s_question')
            {
                $q = mysqli_query($conn , "SELECT * FROM sub_questions where id={$qrow['question_id']}");
                $r=mysqli_fetch_assoc($q);

                if($r['relate']==1)
                {
                    $qrow['question_type']=$r['rel_qtype'];
                    $qrow['question_id']=$r['rel_qid'];
                }

            }
        }
        $OP = db_pair_str2( $qrow );
        $insert1 = mysqli_query($conn , "INSERT into score_questions2 SET $OP");
    }
}

if ( $_GET[ 'h' ] == 'updateScore' ) {
//print_r($_POST);
//exit();

    $M;
    $N;
    $type1='or';
    $type2='and';
    $type3='grouped';
    $type4='both';
    $id=$_POST['id'];
    $i=$j=$n=$ni=$p=0;
    $delete1 = mysqli_query($conn, "DELETE FROM score_conditions where score_id=$id");
    $delete2 = mysqli_query($conn, "DELETE FROM score_questions where score_id=$id");
    $delete3 = mysqli_query($conn, "DELETE FROM score_questions2 where score_id=$id");

    $case=$_POST['n']['casetype'];
    $noc=$_POST['n']['noc'];


    $T = db_pair_str2($_POST['n']);
    $insert1 = mysqli_query($conn, "UPDATE score SET $T where id=$id");
    $score_id = $id;
    $act['k']['note']='Score has been updated';
    $act['k']['score_id']=$score_id;
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    $b=false;
    if($case=='scoreType')
    {
        $_POST['t']['score_id']=$score_id;
        $P = db_pair_str2($_POST['t']);
        $insert5 = mysqli_query($conn, "UPDATE score_ontype SET $P where score_id=$id");

    }
    else if($case=='existing')
    {
        if($_POST['e']['move_qtype']=='s_question')
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_sid'];
        }
        else
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_qid'];

        }
        $_POST['ex']['move_qtype']=$_POST['e']['move_qtype'];
        $_POST['ex']['type']=$case;

        $_POST['ex']['score_id']=$score_id;
        $P = db_pair_str2($_POST['ex']);
        $insert5 = mysqli_query($conn, "INSERT into score_questions SET $P");


    }
    if($noc==1)
    {
        $delete2 = mysqli_query($conn, "DELETE FROM score_noc where score_id=$id");

        $auth=0;
        foreach ($_POST['noc']['user_type'] as $k => $v) {
            $nm['score_id'] = $score_id;
            $nm['noc_type'] = $_POST['noc']['noc_type'][$k];
            $nm['user_type'] = $_POST['noc']['user_type'][$k];
            $nm['operator'] = $_POST['noc']['operator'][$k];
            $nm['value'] = $_POST['noc']['value'][$k];
            $nm['noc_number'] = $_POST['noc']['noc_number'][$k];
            $nm['country_operator'] = $_POST['noc']['country_operator'][$k];
            $nm['conditionn'] = $_POST['noc']['conditionn'][$k];
            $nm['score_number'] = $_POST['noc']['score_number'][$k];
            $nm['wage'] = $_POST['noc']['wage'][$k];
            $nm['hours'] = $_POST['noc']['hours'][$k];
            $nm['wage_operator'] = $_POST['noc']['wage_operator'][$k];
            $nm['hours_operator'] = $_POST['noc']['hours_operator'][$k];
            $nm['province_operator'] = $_POST['noc']['province_operator'][$k];
            $nm['noc_operator'] = $_POST['noc']['noc_operator'][$k];
            $nm['previous_years'] = $_POST['noc']['previous_years'][$k];
            $nm['skill'] = $_POST['skillCheck'][$k];
            $nm['country'] = $_POST['countryCheck'][$k];
            $nm['job_offer'] = $_POST['jobCheck'][$k];
            $nm['employment'] = $_POST['empCheck'][$k];
            $nm['same'] = $_POST['sameCheck'][$k];
            $nm['same_job'] = $_POST['sameJobCheck'][$k];
            $nm['noc_or'] = $_POST['ques_or'][$k];

            $nm['open_bracket'] = $_POST['noc']['open_bracket'][$k];
            $nm['close_bracket'] = $_POST['noc']['close_bracket'][$k];
            $nm['region']='';
            $nm['province']='';
            $nm['authorization']='';
            $pro=array_keys($_POST['noc']['province']);
            foreach ($_POST['noc']['province'][$pro[$auth]] as $val) {
                if(($_POST['noc']['province'][$k+1] ))
                    $nm['province'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['authorization']);
            foreach ($_POST['noc']['authorization'][$authR[$auth]] as $val) {
                $nm['authorization'] .= $val . ',';
            }
            $reg=array_keys($_POST['noc']['region']);
            foreach ($_POST['noc']['region'][$reg[$auth]] as $val) {
                $nm['region'] .= $val . ',';
            }
            $auth++;

//            foreach ($_POST['noc']['province'][$k+1] as $val)
//            {
//                $nm['province'] .= $val.',';
//            }
//            foreach ($_POST['noc']['authorization'][$k+1] as $val)
//            {
//                $nm['authorization'] .= $val.',';
//            }
//            foreach ($_POST['noc']['region'][$k+1] as $val)
//            {
//                $nm['region'] .= $val.',';
//            }
//            foreach ($_POST['noc']['job_offer'][$k+1] as $val)
//            {
//                $nm['job_offer'] = $val;
//            }
//            foreach ($_POST['noc']['employment'][$k+1] as $val)
//            {
//                $nm['employment'] = $val;
//            }




            if($nm['conditionn']=='question')
            {
                $nm['move_qtype']=$_POST['move']['type'];
                if($_POST['move']['type']=='s_question')
                {
                    $nm['move_qid']=$_POST['move']['sid'];
                }
                else
                {
                    $nm['move_qid']=$_POST['move']['qid'];
                }

            }
            else if($nm['conditionn']=='scoring')
            {
                $nm['move_scoreType']=$_POST['move']['scoreType'];
            }

            $Q = db_pair_str2($nm);

            $insert6 = mysqli_query($conn, "INSERT into score_noc SET $Q");
        }    }


    if ($insert1) {

        foreach ($_POST['c']['operator'] as $k => $v) {
            $L['score_id'] = $score_id;
            $L['operator'] = $_POST['c']['operator'][$k];
            $L['value'] = $_POST['c']['value'][$k];
            $L['score_number'] = $_POST['c']['score_number'][$k];
            $M = db_pair_str2($L);
            $insert = mysqli_query($conn, "INSERT into score_conditions SET $M");
            $b=true;
        }
        if($b==false && isset($_POST['c']['score_number']))
        {
            $score_number= $_POST['c']['score_number'];

            $insert = mysqli_query($conn, "INSERT into score_conditions (score_id,score_number) values ($score_id,'$score_number')");

        }

        foreach ($_POST['z']['question_type'] as $k => $v) {
            $a['score_id'] = $score_id;
            $a['question_type'] = $_POST['z']['question_type'][$k];
            $a['question_id'] = $_POST['z']['question_id'][$k];
            $a['user_type'] = $_POST['z']['user_type'][$k];
            $a['type']=$type1;

            $N = db_pair_str2($a);

            $insert = mysqli_query($conn, "INSERT into score_questions SET $N");
            if($insert)
            {
                spouseScoring($conn,$score_id);
            }


        }

        foreach ($_POST['x']['question_type'] as $k => $v) {
            $b['score_id'] = $score_id;
            $b['question_type'] = $_POST['x']['question_type'][$k];
            $b['question_id'] = $_POST['x']['question_id'][$k];
            $b['user_type'] = $_POST['x']['user_type'][$k];
            $b['operator'] = $_POST['x']['operator'][$k];
            $b['value'] = $_POST['x']['value'][$k];
            $b['score_case'] = $_POST['x']['score_case'][$k];



            $b['type']=$type2;

            $G = db_pair_str2($b);

            $insert = mysqli_query($conn, "INSERT into score_questions SET $G");

        }
        $av1=0;
        foreach ($_POST['y']['score_case'] as $k => $v) {
            $c['score_id'] = $score_id;
            $c['question_id'] = $_POST['y']['question_id'][$k];
            $c['user_type'] = $_POST['y']['user_type'][$k];
            $c['operator'] = $_POST['y']['operator'][$k];
            $c['score_case'] = $_POST['y']['score_case'][$k];
            $c['other_case'] = $_POST['other'][$k];

            $c['type']=$type3;

            $c['value']='';
            $av=array_keys($_POST['y']['value']);
            foreach ($_POST['y']['value'][$av[$av1]] as $val) {
                $c['value'] .= $val . '*';
            }
            $av1++;
            if($c['score_case']=='1')
            {
                $c['question_type'] = '';
                $dc['question_id'] = '';
                $dc['tests'] = $_POST['y']['tests'][$ni];
                $ni++;
            }
            else
            {
                $c['question_type'] = $_POST['y']['question_type'][$n];
                $c['question_id'] = $_POST['y']['question_id'][$n];
                $n++;
            }
            if($_POST['other'][$k]=='condition')
            {
                $c['condition2'] = $_POST['y']['condition2'][$j];
                $c['score_number']='';
                $j++;
            }
            else
            {
                $c['score_number'] = $_POST['y']['score_number'][$i];
                $c['condition2']='';
                $i++;
            }

            $G = db_pair_str2($c);

            $insert = mysqli_query($conn, "INSERT into score_questions SET $G");

        }
        $av2=0;

        foreach ($_POST['a']['score_case'] as $k => $v) {
            $d['value']='';
            $av=array_keys($_POST['a']['value']);
            foreach ($_POST['a']['value'][$av[$av2]] as $val) {
                $d['value'] .= $val . '*';
            }
            $av2++;

            $d['score_id'] = $score_id;

            $d['score_case'] = $_POST['a']['score_case'][$k];
            $d['label_type'] = $_POST['a']['label_type'][$k];
            $d['open_bracket'] = $_POST['a']['open_bracket'][$k];
            $d['close_bracket'] = $_POST['a']['close_bracket'][$k];
            $d['start_bracket'] = $_POST['a']['start_bracket'][$k];
            $d['end_bracket'] = $_POST['a']['end_bracket'][$k];
            $d['noc_or'] = $_POST['noc_or'][$k];
            $d['skip_question'] = $_POST['skip_question'][$k];
            if($d['score_case']==1)
            {
                $d['question_type'] = '';
                $d['question_id'] = '';
                $d['tests'] = $_POST['a']['tests'][$ni];
                $ni++;
            }
            else
            {
                $d['question_type'] = $_POST['a']['question_type'][$n];
                $d['question_id'] = $_POST['a']['question_id'][$n];
                $n++;
            }

            $d['user_type'] = $_POST['a']['user_type'][$k];
            $d['operator'] = $_POST['a']['operator'][$k];
            $d['type']=$type4;
            $d['other_case']=$_POST['other'][$k];
            if($_POST['other'][$k]=='question')
            {
                $d['move_qtype']=$_POST['move']['type'];
                if($_POST['move']['type']=='s_question')
                {
                    $d['move_qid']=$_POST['move']['sid'];

                }
                else
                {
                    $d['move_qid']=$_POST['move']['qid'];

                }
                $d['score_number']='';
                $d['condition2']='';

            }
            if($_POST['other'][$k]=='email')
            {
                $d['email']=$_POST['t']['email'];
                $d['subject']=$_POST['t']['subject'];
                $d['message']=$_POST['t']['message'];
                $d['cc']=$_POST['t']['cc'];

                $d['score_number']='';
                $d['condition2']='';
            }
            else if($_POST['other'][$k]=='scoring')
            {

                $d['move_scoreType']=$_POST['move']['scoreType'];

                $d['score_number']='';
                $d['condition2']='';

            }
            else if($_POST['other'][$k]=='comment')
            {

                $d['comments']=$_POST['comments'];

                $d['score_number']='';
                $d['condition2']='';

            }
            else if($_POST['other'][$k]=='condition')
            {
                $d['condition2'] = $_POST['a']['condition2'][$j];
                $d['score_number']='';
                $j++;
            }
            else
            {
                $d['score_number'] = $_POST['a']['score_number'][$i];
                $d['condition2']='';
                $i++;
            }

            $F = db_pair_str2($d);
            $insert = mysqli_query($conn, "INSERT into score_questions SET $F");

            $d['value']='';
        }

        spouseScoring($conn,$score_id);

        die(json_encode(array('Success' => 'true', 'Msg' => 'Score updated Successfully.','data'=>$_POST)));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while updating score.')));
    }
}


if ( $_GET[ 'h' ] == 'deleteScore' ) {

    $id=$_POST['id'];
    $insert1 = mysqli_query($conn, "DELETE FROM score where id=$id");

    $act['k']['note']='Score has been deleted';
    $act['k']['score_id']=$id;
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    if ($insert1) {

        die(json_encode(array('Success' => 'true', 'Msg' => 'Score deleted Successfully.')));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while deleting score.')));
    }
}

if ( $_GET[ 'h' ] == 'duplicateScore' ) {
    $M;
    $N;
    $G;

    $T = db_pair_str2($_POST['n']);
    $insert1 = mysqli_query($conn, "INSERT into score SET $T");
    $score_id = mysqli_insert_id($conn);
    $type1='or';
    $type2='and';
    $type3='grouped';

    $_POST['k']['note']='Score has been duplicated';
    $_POST['k']['score_id']=$score_id;
    $_POST['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $_POST[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    if ($insert1) {

        if (!empty($_POST['c']['operator'])) {
            foreach ($_POST['c']['operator'] as $k => $v) {
                $L['score_id'] = $score_id;
                $L['operator'] = $_POST['c']['operator'][$k];
                $L['value'] = $_POST['c']['value'][$k];
                $L['score_number'] = $_POST['c']['score_number'][$k];
                $M = db_pair_str2($L);

                $insert = mysqli_query($conn, "INSERT into score_conditions SET $M");
            }

            foreach ($_POST['z']['question_type'] as $k => $v) {
                $a['score_id'] = $score_id;
                $a['question_type'] = $_POST['z']['question_type'][$k];
                $a['question_id'] = $_POST['z']['question_id'][$k];
                $a['user_type'] = $_POST['z']['user_type'][$k];
                $a['type']=$type1;

                $N = db_pair_str2($a);

                $insert = mysqli_query($conn, "INSERT into score_questions SET $N");
            }

            foreach ($_POST['x']['question_type'] as $k => $v) {
                $b['score_id'] = $score_id;
                $b['question_type'] = $_POST['x']['question_type'][$k];
                $b['question_id'] = $_POST['x']['question_id'][$k];
                $b['user_type'] = $_POST['x']['user_type'][$k];
                $b['type']=$type2;

                $G = db_pair_str2($b);

                $insert = mysqli_query($conn, "INSERT into score_questions SET $G");
            }
            foreach ($_POST['y']['question_type'] as $k => $v) {
                $c['score_id'] = $score_id;
                $c['question_type'] = $_POST['y']['question_type'][$k];
                $c['question_id'] = $_POST['y']['question_id'][$k];
                $c['user_type'] = $_POST['y']['user_type'][$k];
                $c['type']=$type3;

                $G = db_pair_str2($c);

                $insert = mysqli_query($conn, "INSERT into score_questions SET $G");
            }
        }
        die(json_encode(array('Success' => 'true', 'Msg' => 'Score duplicated Successfully.')));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding score.')));
    }
}

if ( $_GET[ 'h' ] == 'addRule' ) {

//    print_r($_POST);
//  die();
    $M;
    $N;
    $G;

    $b=false;
    $i=$j=$n=$ni=$p=$l=$job=$emp=0;


    $case=$_POST['n']['casetype'];
    $noc=$_POST['n']['noc'];
    $T = db_pair_str2($_POST['n']);
    $insert1 = mysqli_query($conn, "INSERT into global_rule SET $T");
    $score_id = mysqli_insert_id($conn);

    $act['k']['note']='Global Rule has been added';
    $act['k']['score_id']=$score_id;
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");


    if($case=='existing')
    {
        if($_POST['e']['move_qtype']=='s_question')
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_sid'];
        }
        else
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_qid'];

        }
        $_POST['ex']['move_qtype']=$_POST['e']['move_qtype'];
        $_POST['ex']['type']=$case;

        $_POST['ex']['score_id']=$score_id;
        $P = db_pair_str2($_POST['ex']);
        $insert5 = mysqli_query($conn, "INSERT into score_questions SET $P");


    }
    if($noc==1)
    {
        $auth=0;
        foreach ($_POST['noc']['user_type'] as $k => $v) {
            $nm['score_id'] = $score_id;
            $nm['noc_type'] = $_POST['noc']['noc_type'][$k];
            $nm['user_type'] = $_POST['noc']['user_type'][$k];
            $nm['operator'] = $_POST['noc']['operator'][$k];
            $nm['value'] = $_POST['noc']['value'][$k];
            $nm['country'] = $_POST['noc']['country'][$k];
            $nm['noc_number'] = $_POST['noc']['noc_number'][$k];
            $nm['country_operator'] = $_POST['noc']['country_operator'][$k];
            $nm['conditionn'] = $_POST['noc']['conditionn'][$k];
            $nm['score_number'] = $_POST['noc']['score_number'][$k];
            $nm['wage'] = $_POST['noc']['wage'][$k];
            $nm['hours'] = $_POST['noc']['hours'][$k];
            $nm['wage_operator'] = $_POST['noc']['wage_operator'][$k];
            $nm['hours_operator'] = $_POST['noc']['hours_operator'][$k];
            $nm['province_operator'] = $_POST['noc']['province_operator'][$k];
            $nm['noc_operator'] = $_POST['noc']['noc_operator'][$k];
            $nm['previous_years'] = $_POST['noc']['previous_years'][$k];
            $nm['job_offer'] = $_POST['jobCheck'][$k];
            $nm['employment'] = $_POST['empCheck'][$k];
            $nm['same'] = $_POST['sameCheck'][$k];
            $nm['same_job'] = $_POST['sameJobCheck'][$k];
            $nm['open_bracket'] = $_POST['noc']['open_bracket'][$k];
            $nm['close_bracket'] = $_POST['noc']['close_bracket'][$k];
            $nm['noc_or'] = $_POST['ques_or'][$k];


            $nm['region']='';
            $nm['province']='';
            $nm['authorization']='';

            $authR=array_keys($_POST['noc']['province']);
            foreach ($_POST['noc']['province'][$authR[$auth]] as $val) {
                $nm['province'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['authorization']);
            foreach ($_POST['noc']['authorization'][$authR[$auth]] as $val) {
                $nm['authorization'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['region']);
            foreach ($_POST['noc']['region'][$authR[$auth]] as $val) {
                $nm['region'] .= $val . ',';
            }
            $auth++;

//            foreach ($_POST['noc']['province'][$k+1] as $val)
//            {
//                $nm['province'] .= $val.',';
//            }
//            foreach ($_POST['noc']['authorization'][$k+1] as $val)
//            {
//                $nm['authorization'] .= $val.',';
//            }
//            foreach ($_POST['noc']['region'][$k+1] as $val)
//            {
//                $nm['region'] .= $val.',';
//            }
//            foreach ($_POST['noc']['job_offer'][$k+1] as $val)
//            {
//                $nm['job_offer'] = $val;
//            }
//            foreach ($_POST['noc']['employment'][$k+1] as $val)
//            {
//                $nm['employment'] = $val;
//            }

            if($nm['noc_number']=='' || $nm['noc_number']!='') {
                $nm['skill'] = $_POST['noc']['skill'][$p];
                $p++;
            }

            if($nm['conditionn']=='question')
            {
                $nm['move_qtype']=$_POST['move']['type'];
                if($_POST['move']['type']=='s_question')
                {
                    $nm['move_qid']=$_POST['move']['sid'];
                }
                else
                {
                    $nm['move_qid']=$_POST['move']['qid'];
                }

            }
            else if($nm['conditionn']=='scoring')
            {
                $nm['move_scoreType']=$_POST['move']['scoreType'];
            }

            $Q = db_pair_str2($nm);

            $insert6 = mysqli_query($conn, "INSERT into score_noc SET $Q");
        }

    }


    if ($insert1)
    {
        foreach ($_POST['c']['operator'] as $k => $v) {
            $L['rule_id'] = $score_id;
            $L['operator'] = $_POST['c']['operator'][$k];
            $L['value'] = $_POST['c']['value'][$k];
            $M = db_pair_str2($L);
            $insert = mysqli_query($conn, "INSERT into global_rule_conditions SET $M");
            $b=true;
        }
        $av1=0;
        $av2=0;

        foreach ($_POST['a']['score_case'] as $k => $v) {
            $d['rule_id'] = $score_id;
            $d['score_case'] = $_POST['a']['score_case'][$k];
            $d['label_type'] = $_POST['a']['label_type'][$k];
            $d['open_bracket'] = $_POST['a']['open_bracket'][$k];
            $d['close_bracket'] = $_POST['a']['close_bracket'][$k];
            $d['start_bracket'] = $_POST['a']['start_bracket'][$k];
            $d['end_bracket'] = $_POST['a']['end_bracket'][$k];
            $d['noc_or'] = $_POST['noc_or'][$k];
            $d['value']='';
            $av=array_keys($_POST['a']['value']);
            foreach ($_POST['a']['value'][$av[$av2]] as $val) {
                $d['value'] .= $val . '*';
            }
            $av2++;
            if($d['score_case']=='1')
            {
                $d['question_type'] = '';
                $d['question_id'] = '';
                $d['tests'] = $_POST['a']['tests'][$ni];
                $ni++;
            }
            else
            {
                $d['question_type'] = $_POST['a']['question_type'][$n];
                $d['question_id'] = $_POST['a']['question_id'][$n];
                $n++;
            }
            $d['user_type'] = $_POST['a']['user_type'][$k];
            $d['operator'] = $_POST['a']['operator'][$k];
            $d['other_case']=$_POST['other'][$k];

            if($_POST['other'][$k]=='condition')
            {
                $d['condition2'] = $_POST['a']['condition2'][$j];
                $d['score_number']='';
                $j++;
            }
            else
            {
                $d['score_number'] = '';
                $d['condition2']='';
                $i++;
            }


            $F = db_pair_str2($d);
            $insert = mysqli_query($conn, "INSERT into global_rule_questions SET $F");

            $d['value']='';
        }


        die(json_encode(array('Success' => 'true', 'Msg' => 'Rule added Successfully.', 'a' => $insert ,'data'=>$_POST)));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding score.')));
    }
}


if ( $_GET[ 'h' ] == 'updateRule' ) {

//    print_r($_POST);
//  die();
    $M;
    $N;
    $G;

    $b=false;
    $id=$_POST['id'];

    $i=$j=$n=$ni=$p=$l=$job=$emp=0;
    $delete1 = mysqli_query($conn, "DELETE FROM global_rule_conditions where rule_id=$id");
    $delete2 = mysqli_query($conn, "DELETE FROM global_rule_questions where rule_id=$id");

    $case=$_POST['n']['casetype'];
    $noc=$_POST['n']['noc'];
    $T = db_pair_str2($_POST['n']);
    $insert1 = mysqli_query($conn, "UPDATE global_rule SET $T where id=$id");
    $score_id = $id;

    $act['k']['note']='Global Rule has been added';
    $act['k']['score_id']=$score_id;
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");


    if($case=='existing')
    {
        if($_POST['e']['move_qtype']=='s_question')
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_sid'];
        }
        else
        {
            $_POST['ex']['move_qid']=$_POST['e']['existing_qid'];

        }
        $_POST['ex']['move_qtype']=$_POST['e']['move_qtype'];
        $_POST['ex']['type']=$case;

        $_POST['ex']['score_id']=$score_id;
        $P = db_pair_str2($_POST['ex']);
        $insert5 = mysqli_query($conn, "INSERT into score_questions SET $P");


    }
    if($noc==1)
    {
        $auth=0;
        foreach ($_POST['noc']['user_type'] as $k => $v) {
            $nm['score_id'] = $score_id;
            $nm['noc_type'] = $_POST['noc']['noc_type'][$k];
            $nm['user_type'] = $_POST['noc']['user_type'][$k];
            $nm['operator'] = $_POST['noc']['operator'][$k];
            $nm['value'] = $_POST['noc']['value'][$k];
            $nm['country'] = $_POST['noc']['country'][$k];
            $nm['noc_number'] = $_POST['noc']['noc_number'][$k];
            $nm['country_operator'] = $_POST['noc']['country_operator'][$k];
            $nm['conditionn'] = $_POST['noc']['conditionn'][$k];
            $nm['score_number'] = $_POST['noc']['score_number'][$k];
            $nm['wage'] = $_POST['noc']['wage'][$k];
            $nm['hours'] = $_POST['noc']['hours'][$k];
            $nm['wage_operator'] = $_POST['noc']['wage_operator'][$k];
            $nm['hours_operator'] = $_POST['noc']['hours_operator'][$k];
            $nm['province_operator'] = $_POST['noc']['province_operator'][$k];
            $nm['noc_operator'] = $_POST['noc']['noc_operator'][$k];
            $nm['previous_years'] = $_POST['noc']['previous_years'][$k];
            $nm['job_offer'] = $_POST['jobCheck'][$k];
            $nm['employment'] = $_POST['empCheck'][$k];
            $nm['same'] = $_POST['sameCheck'][$k];
            $nm['same_job'] = $_POST['sameJobCheck'][$k];
            $nm['open_bracket'] = $_POST['noc']['open_bracket'][$k];
            $nm['close_bracket'] = $_POST['noc']['close_bracket'][$k];
            $nm['noc_or'] = $_POST['ques_or'][$k];


            $nm['region']='';
            $nm['province']='';
            $nm['authorization']='';

            $authR=array_keys($_POST['noc']['province']);
            foreach ($_POST['noc']['province'][$authR[$auth]] as $val) {
                $nm['province'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['authorization']);
            foreach ($_POST['noc']['authorization'][$authR[$auth]] as $val) {
                $nm['authorization'] .= $val . ',';
            }
            $authR=array_keys($_POST['noc']['region']);
            foreach ($_POST['noc']['region'][$authR[$auth]] as $val) {
                $nm['region'] .= $val . ',';
            }
            $auth++;

//            foreach ($_POST['noc']['province'][$k+1] as $val)
//            {
//                $nm['province'] .= $val.',';
//            }
//            foreach ($_POST['noc']['authorization'][$k+1] as $val)
//            {
//                $nm['authorization'] .= $val.',';
//            }
//            foreach ($_POST['noc']['region'][$k+1] as $val)
//            {
//                $nm['region'] .= $val.',';
//            }
//            foreach ($_POST['noc']['job_offer'][$k+1] as $val)
//            {
//                $nm['job_offer'] = $val;
//            }
//            foreach ($_POST['noc']['employment'][$k+1] as $val)
//            {
//                $nm['employment'] = $val;
//            }

            if($nm['noc_number']=='' || $nm['noc_number']!='') {
                $nm['skill'] = $_POST['noc']['skill'][$p];
                $p++;
            }

            if($nm['conditionn']=='question')
            {
                $nm['move_qtype']=$_POST['move']['type'];
                if($_POST['move']['type']=='s_question')
                {
                    $nm['move_qid']=$_POST['move']['sid'];
                }
                else
                {
                    $nm['move_qid']=$_POST['move']['qid'];
                }

            }
            else if($nm['conditionn']=='scoring')
            {
                $nm['move_scoreType']=$_POST['move']['scoreType'];
            }

            $Q = db_pair_str2($nm);

            $insert6 = mysqli_query($conn, "INSERT into score_noc SET $Q");
        }

    }


    if ($insert1)
    {
        foreach ($_POST['c']['operator'] as $k => $v) {
            $L['rule_id'] = $score_id;
            $L['operator'] = $_POST['c']['operator'][$k];
            $L['value'] = $_POST['c']['value'][$k];
            $M = db_pair_str2($L);
            $insert = mysqli_query($conn, "INSERT into global_rule_conditions SET $M");
            $b=true;
        }
        $av1=0;
        $av2=0;

        foreach ($_POST['a']['score_case'] as $k => $v) {
            $d['rule_id'] = $score_id;
            $d['score_case'] = $_POST['a']['score_case'][$k];
            $d['label_type'] = $_POST['a']['label_type'][$k];
            $d['open_bracket'] = $_POST['a']['open_bracket'][$k];
            $d['close_bracket'] = $_POST['a']['close_bracket'][$k];
            $d['start_bracket'] = $_POST['a']['start_bracket'][$k];
            $d['end_bracket'] = $_POST['a']['end_bracket'][$k];
            $d['noc_or'] = $_POST['noc_or'][$k];
            $d['value']='';
            $av=array_keys($_POST['a']['value']);
            foreach ($_POST['a']['value'][$av[$av2]] as $val) {
                $d['value'] .= $val . '*';
            }
            $av2++;
            if($d['score_case']=='1')
            {
                $d['question_type'] = '';
                $d['question_id'] = '';
                $d['tests'] = $_POST['a']['tests'][$ni];
                $ni++;
            }
            else
            {
                $d['question_type'] = $_POST['a']['question_type'][$n];
                $d['question_id'] = $_POST['a']['question_id'][$n];
                $n++;
            }
            $d['user_type'] = $_POST['a']['user_type'][$k];
            $d['operator'] = $_POST['a']['operator'][$k];
            $d['other_case']=$_POST['other'][$k];

            if($_POST['other'][$k]=='condition')
            {
                $d['condition2'] = $_POST['a']['condition2'][$j];
                $d['score_number']='';
                $j++;
            }
            else
            {
                $d['score_number'] = '';
                $d['condition2']='';
                $i++;
            }


            $F = db_pair_str2($d);
            $insert = mysqli_query($conn, "INSERT into global_rule_questions SET $F");

            $d['value']='';
        }


        die(json_encode(array('Success' => 'true', 'Msg' => 'Rule added Successfully.', 'a' => $insert ,'data'=>$_POST)));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while adding score.')));
    }
}


if ( $_GET[ 'h' ] == 'deleteRule' ) {

    $id=$_POST['id'];
    $insert1 = mysqli_query($conn, "DELETE FROM global_rule where id=$id");

    $act['k']['note']='Score has been deleted';
    $act['k']['score_id']=$id;
    $act['k']['admin_id']=$_SESSION[ 'adminid' ];
    $S = db_pair_str2( $act[ 'k' ] );
    $activity = mysqli_query($conn , "INSERT into activities SET $S");
    if ($insert1) {

        die(json_encode(array('Success' => 'true', 'Msg' => 'Rule deleted Successfully.')));
    } else {
        die(json_encode(array('Success' => 'false', 'Msg' => 'Something went wrong while deleting score.')));
    }
}

if($_GET['h'] == 'score_label'){
    $arrLabels=Array();
    $select = mysqli_query( $conn, "SELECT * FROM score_questions where question_id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {

        while($row = mysqli_fetch_assoc($select))
        {
            $sID =$row['score_id'];
            $getLabels = mysqli_query($conn , "SELECT * FROM score_conditions WHERE score_id = $sID");
            while($label = mysqli_fetch_assoc($getLabels)){
                $arrLabels[] = $label;
            }
        }
        die( json_encode( array( 'Success' => 'true', 'data' => $row , 'Options' => $arrLabels) ) );
    }else{
        die( json_encode( array( 'Success' => 'true', 'Options' => $arrLabels) ) );
    }
}

if($_GET['h'] == 'flag_update'){
    $arrLabels=Array();
    $val=$_POST['val'];
    $select = mysqli_query( $conn, "SELECT * FROM score where id = '{$_POST['id']}' " );
    if ( mysqli_num_rows( $select ) > 0 ) {

        $update=mysqli_query($conn,"update score set flags=$val where id={$_POST['id']}");
        if($update)
        {
            die( json_encode( array( 'Success' => 'true', 'Msg'=>'Updated') ) );
        }
        else
        {
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong ') ) );

        }
    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Not Found') ) );
    }
}

if($_GET['h'] == 'resend_email'){
    $val=$_POST['id'];
    $select = mysqli_query( $conn, "SELECT * FROM user_form where id = $val " );
    if ( mysqli_num_rows( $select ) > 0 ) {

        $row=mysqli_fetch_assoc($select);
        if($row['email_data']!=='' && $row['email_data']!==null)
        {
            sendMail($row['user_email'].' has submitted the form',json_decode($row['email_data']),$row['pdf_file']);
            $update=mysqli_query($conn,"update user_form set resend_mail=1 where id=$val");
            if($update)
            {
                die( json_encode( array( 'Success' => 'true', 'Msg'=>'Email has been sent') ) );
            }
            else
            {
                die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong ') ) );

            }

        }
        else
        {
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'Email data is empty') ) );

        }

    }else{
        die( json_encode( array( 'Success' => 'false', 'Msg' => 'Not Found') ) );
    }
}
if ( $_GET[ 'h' ] == 'blockIP' ) {
    $ban=$_POST['ban'];
    $select = mysqli_query( $conn, "SELECT * FROM blocked_ip where ip_address = '{$_POST['ip']}'" );
    if ( mysqli_num_rows( $select ) > 0 ) {
        if($ban==1)
        {
            $delete=mysqli_query($conn,"delete from blocked_ip where ip_address='{$_POST['ip']}'");
            if($delete)
            {
                die( json_encode( array( 'Success' => 'true', 'Msg'=>'Ip unblocked') ) );
            }
            else
            {
                die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong ') ) );
            }
        }
        else
        {
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'This IP address is already blocked' ) ) );
        }

    } else {
        if($ban==1)
        {
            die( json_encode( array( 'Success' => 'false', 'Msg' => 'This IP address is already unblocked' ) ) );

        }
        else
        {
            $insert=mysqli_query($conn,"insert into blocked_ip (ip_address,user_id) values ('{$_POST['ip']}',0)");
            if($insert)
            {
                die( json_encode( array( 'Success' => 'true', 'Msg'=>'Ip blocked') ) );
            }
            else
            {
                die( json_encode( array( 'Success' => 'false', 'Msg' => 'Something went wrong ') ) );
            }
        }

    }

}

if($_GET['h'] == 'loadLabels'){
    $data=array();
    $select = mysqli_query($conn,"select * from static_labels");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadQuestions'){
    $data=array();
    $select = mysqli_query($conn,"SELECT * FROM questions WHERE form_id = '10' and question!='' and question is not null");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadSubQuestions'){
    $data=array();
    $select = mysqli_query($conn,"SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id WHERE q.form_id = '10' and s.question!='' and s.question is not null");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadNotes'){
    $data=array();
    $select = mysqli_query($conn,"SELECT *  FROM questions  WHERE form_id = '10' and notes!='' and notes is not null");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $data[]=$row;
        $count++;
    }
    $select = mysqli_query($conn,"SELECT s.* FROM sub_questions as s join questions as q on s.question_id=q.id WHERE q.form_id = '10' and s.notes!='' and s.notes is not null");
    while($row=mysqli_fetch_assoc($select))
    {
        $data[]=$row;
        $count++;
    }
    $select = mysqli_query($conn , "SELECT *  FROM score_questions  WHERE comments!='' and comments is not null");
    while($row=mysqli_fetch_assoc($select))
    {
        $row['id']=$row['id'].'-scoring' ;
        $row['notes']=$row['comments'] ;
        $row['notes_french']=$row['comments_french'] ;
        $row['notes_urdu']=$row['comments_urdu'] ;
        $row['notes_spanish']=$row['comments_spanish'] ;
        $row['notes_chinese']=$row['comments_chinese'];
        $row['notes_hindi']=$row['comments_hindi'] ;
        $row['notes_punjabi']=$row['comments_punjabi'] ;
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadOptions'){

    $optionsArray = array();
    $get = mysqli_query($conn , "SELECT *  FROM question_labels  WHERE  label!='' and label is not null");

    while($row = mysqli_fetch_assoc($get)){
        if(!in_array($row['label'],$optionsArray))
        {
            $p['label']=$row['label'];
            $p['label_french']=$row['label_french'];
            $p['label_urdu']=$row['label_urdu'];
            $p['label_spanish']=$row['label_spanish'];
            $p['label_chinese']=$row['label_chinese'];

            $p['label_punjabi']=$row['label_punjabi'];
            $p['label_hindi']=$row['label_hindi'];

            $optionsArray[]=$p;

        }
    }

    $get = mysqli_query($conn , "SELECT *  FROM level1  WHERE  label!='' and label is not null");

    while($row = mysqli_fetch_assoc($get)){
        if(!in_array($row['label'],$optionsArray))
        {
            $p['label']=$row['label'];
            $p['label_french']=$row['label_french'];
            $p['label_urdu']=$row['label_urdu'];
            $p['label_spanish']=$row['label_spanish'];
            $p['label_chinese']=$row['label_chinese'];

            $p['label_punjabi']=$row['label_punjabi'];
            $p['label_hindi']=$row['label_hindi'];

            $optionsArray[]=$p;

        }
    }

    if(!empty($optionsArray)){
        die( json_encode( array( 'Success' => 'true', 'data' => $optionsArray) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
if($_GET['h'] == 'loadSubmittedForm'){
    $data=array();
    $select = mysqli_query($conn,"SELECT * from user_form order by id desc");
    $count=1;
    while($row=mysqli_fetch_assoc($select))
    {
        $getQuery2 = mysqli_query($conn , "SELECT * FROM score_calculation2 where user={$row['id']} order by id desc");
        $total_score=0;
        while($srow = mysqli_fetch_assoc($getQuery2)) {
            if(ctype_digit($srow['score']))
                $total_score += $srow['score'];
        }

        $blocked='';

        $getQuery3 = mysqli_query($conn , "SELECT * FROM blocked_ip where `ip_address`='{$row['ip_address']}'");
        if(mysqli_num_rows($getQuery3)>0)
        {
            $row3=mysqli_fetch_assoc($getQuery3);
            $blocked='Blocked';
            $block=true;

        }

        if($row['user_id']!==0 && $row['user_id']!=='0')
        {
            $select2 = mysqli_query($conn,"SELECT * from users where id={$row['user_id']}");
            $userInfo=mysqli_fetch_assoc($select2);

            if($userInfo['role'] == "1" || $userInfo['role'] == 1) {
                $row['account_type']= "Professional"; }
            else { $row['account_type']= "Signed"; }
            $row['account_email']=$userInfo['email'];
        }
        else {
            $row['account_type']= "Guest";
        }
        $row['total_score']=$total_score;
        $row['blocked']=$blocked;

        $row['action'].='<a href="view_form?id='.$row['id'].'" class="btn btn-sm btn-info waves-effect waves-light" title="View Form"><i class="fas fa-eye"></i></a>';
        $row['action'].='<a href="scores?id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light" title="Check Score"><i class="fa fa-calculator"></i></a>';
        $row['action'].='<a target="_blank" href="<?php echo $currentTheme ?>/view_form2?id='.$row['id'].'" class="btn btn-sm btn-success waves-effect waves-light" title="View Form from user side"><i class="fas fa-list"></i></a>';
        $row['action'].='<a href="javascript:void(0)" onClick="resendMail(\''.$row['id'].'\')" class="btn btn-sm btn-warning waves-effect waves-light" title="Resend Email"><i class="fas fa-envelope"></i></a>';
        if($blocked=='' && ($row['user_id']===0 || $row['user_id']==='0'))
        {
            $row['action'].='<a href="javascript:void(0)" onClick="DeleteModal(\''.$row['ip_address'].'\',1)" class="btn btn-sm btn-success waves-effect waves-light"><i class="fas fa-unlock"></i></a>';

        }
        else
        {
            $row['action'].='<a href="javascript:void(0)" onClick="DeleteModal(\''.$row['ip_address'].'\',0)" class="btn btn-sm btn-danger waves-effect waves-light"><i class="fas fa-ban"></i></a>';

        }
        $row['count']=$count;
        $data[]=$row;
        $count++;
    }

    if(!empty($data)){
        die( json_encode( array( 'Success' => 'true', 'data' => $data) ) );
    }else{
        die( json_encode( array( 'Success' => 'false', 'data' => 'No record found' ) ) );
    }
}
function sendMail($subject,$body,$pdf)
{
    $to = 'fnsheikh29@gmail.com';
    $to1 = 'maryumakhter1@gmail.com';
    $to2 = 'shahmutbahir@gmail.com';
    $to3 = 'bhatimoiz@gmail.com';
    $to4 = 'info@ourcanada.co';
    $to5 = 'shawna@immigrationcanada.app';

    global $sendGridAPIKey;





    $htmlContent=$body;
    // Sender
    $from = 'support@ourcanada.co';
    $fromName = 'OurCanada';


    // Attachment file
    $file = $_SERVER[ 'DOCUMENT_ROOT' ] . "/pdf_files/" . $pdf;
    $name = $pdf;

    // Header for sender info
    $headers = "From: $fromName" . " <" . $from . ">";

    // Boundary
    $semi_rand = md5( time() );
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    // Headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    // Multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";

    // Preparing attachment
    if ( !empty( $file ) > 0 ) {
        if ( is_file( $file ) ) {
            $message .= "--{$mime_boundary}\n";
            $fp = @fopen( $file, "rb" );
            $data = @fread( $fp, filesize( $file ) );

            @fclose( $fp );
            $data = chunk_split( base64_encode( $data ) );
            $message .= "Content-Type: application/octet-stream; name=\"" . basename( $file ) . "\"\n" .
                "Content-Description: " . basename( $file ) . "\n" .
                "Content-Disposition: attachment;\n" . " filename=\"" . basename( $pdf ) . "\"; size=" . filesize( $file ) . ";\n" .
                "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;





    $emailObj = new\ SendGrid\ Mail\ Mail();
    $emailObj->setFrom( "no-reply@ourcanada.co", "OurCanada" );
    $emailObj->setSubject( $subject );
    $emailObj->addTo( $to );
//        $emailObj->addBcc($to2);

    $emailObj->addContent(
        "text/html",
        $message # html:body
    );


    $attachment = $file;
    $content = file_get_contents( $attachment );
    $content = ( base64_encode( $content ) );

    $attachment = new\ SendGrid\ Mail\ Attachment();
    $attachment->setContent( $content );
    $attachment->setType( "application/pdf" );
    $attachment->setFilename( $pdf );
    $attachment->setDisposition( "attachment" );
    $emailObj->addAttachment( $attachment );



    $sendgrid = new \SendGrid($sendGridAPIKey);
    try {
        $response = $sendgrid->send($emailObj);
        //  $response->body();
        //return array('sg_status' => json_encode($response->statusCode()), 'sg_heasders' => json_encode($response->headers()));
    } catch (Exception $e) {
        //return 'Caught exception: ' . $e->getMessage() . "\n";
    }
}
if ( $_GET[ 'h' ] == 'getViewQuestion' ) {

    $type=$_POST['type'];
    $id=$_POST['id'];
    $select='';
    if($type=='m_question')
    {
        $select = mysqli_query( $conn, "SELECT * FROM questions where id = '$id' " );

    }
    else
    {
        $select = mysqli_query( $conn, "SELECT * FROM sub_questions where id = '$id' " );

    }
    if ( mysqli_num_rows( $select ) > 0 ) {
        $row = mysqli_fetch_assoc( $select );

        die( json_encode( array( 'Success' => 'true', 'data' => $row ) ) );
    }
}

if ( $_GET[ 'h' ] == 'autoFormStatus' ) {

    $status=$_POST['status'];
    $id=$_POST['id'];
    $select='';
    $update=mysqli_query($conn,"update auto_save_form set status='$status' where id=$id");
    if ( $update ) {
        die( json_encode( array( 'Success' => 'true') ) );
    }
    else
    {
        die( json_encode( array( 'Success' => 'false') ) );

    }
}
