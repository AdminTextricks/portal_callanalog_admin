<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'crg.' . $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " and (crg.did like '%" . $searchValue . "%' or 
        crg.did_provider like '%" . $searchValue . "%' )";
    // Client.clientName like'%".$searchValue."%' ) ";
}


## Total number of records without filtering
$queuenamesid = '';
$queuenamesidss = '';

$sel1 = "select count(*) as allcount from import_did_details " . $queuenamesid . "";
// echo $sel1;exit;
$sel = mysqli_query($con, $sel1);
if (mysqli_num_rows($sel) > 0) {
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
} else {
    $totalRecords = 1;
}

## Total number of records with filtering

$sel2 = "select count(*) as allcount from import_did_details crg WHERE 1 " . $queuenamesidss . " " . $searchQuery;
$sel2 = mysqli_query($con, $sel2);
if (mysqli_num_rows($sel2) > 0) {
    $records = mysqli_fetch_assoc($sel2);
    $totalRecordwithFilter = $records['allcount'];
} else {
    $totalRecordwithFilter = 1;
}

## Fetch records
$empQuery = "SELECT * FROM import_did_details WHERE 1 " . $queuenamesidss . " " . $searchQuery ."order by id desc";

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
        "id" => $i,
        "file_name" => $row['file_name'],
        "status" => $row['status'],
        "created_at" => $row['created_at'],
        "action" => '<a href="import_did/' . $row['file_name'] . '" download><i class="fa fa-download"></i></a>'
    );
    $i++;
}
## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
