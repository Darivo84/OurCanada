<?php
include_once("global.php");

if ($_GET['h'] == 'submittedforms3') {

    $fstatus = '0'; // 1 fro client 0 for devs

    $draw = $_POST['draw'];
    $roww = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
    $searchValue = mysqli_real_escape_string($conn, $_POST['search']['value']);

    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " and (user_name like '%" . $searchValue . "%' or 
    user_email like '%" . $searchValue . "%'  ) ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn, "select count(*) as allcount from user_form WHERE `status`='$fstatus' ");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of record with filtering
    $sel = mysqli_query($conn, "select count(*) as allcount from user_form WHERE `status`='$fstatus' " . $searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    if($columnName == "id")
    {
        $columnName = "user_form.id";
    }
    $empQuery = "select user_form.*,sum(score_calculation2.score) as scoree FROM user_form join score_calculation2 ON user_form.id = score_calculation2.user  WHERE user_form.`status`='$fstatus'  " . $searchQuery . " group by score_calculation2.user order by " . $columnName . "   " .$columnSortOrder . "  limit " . $roww . "," . $rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    $rcId = $roww + 1;
    while ($row = mysqli_fetch_assoc($empRecords)) {
        $data[] = array(
            "id" => $rcId,
            "user_name" => $row['user_name'],
            "user_email" => $row['user_email'],
            "scoree" => $row['scoree'],
            "created_date" => $row['created_date'],
            "action" => '<a href="view_form?id='.$row['id'].'" class="btn btn-sm btn-info waves-effect waves-light" title="View Form"><i class="fas fa-eye"></i></a>
            <a href="scores?id='.$row['id'].'"  class="btn btn-sm btn-primary waves-effect waves-light" title="Check Score"><i class="fa fa-calculator"></i></a>

            <a target="_blank" href="<?php echo $currentTheme ?>view_form?id='.$row['id'].'" class="btn btn-sm btn-success waves-effect waves-light" title="View Form from user side"><i class="fas fa-list"></i></a>

            <a href="javascript:void(0)" data-form-id="'.$row['id'].'"  class="btn btn-sm btn-warning mailsend-btn waves-effect waves-light" title="Resend Email"><i class="fas fa-envelope"></i></a>'
        );
        $rcId++;
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data,
        'op' => $empQuery
    );

    echo json_encode($response);
}

function getFromScroeByFormId($id)
{
    global $conn;
    $getQuery2 = mysqli_query($conn, "SELECT * FROM score_calculation2 where user='$id' order by id desc");
    $total_score = 0;
    while ($srow = mysqli_fetch_assoc($getQuery2)) {
        if (ctype_digit($srow['score']))
            $total_score += $srow['score'];
    }
    return $total_score;
}
