<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName =  $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchValue = strtoupper($searchValue); // Convert search value to lowercase
    $searchQuery = " and (UPPER(cc_did_use.did) like '%" . $searchValue . "%' or 
    UPPER(cc_did_use.did_provider) like '%" . $searchValue . "%' or
    UPPER(users_login.email) like '%" . $searchValue . "%' )";
}



## Total number of records without filtering
$queuenamesid = '';
$queuenamesidss = '';

$sel1 = "select count(*) as allcount from cc_did_use " . $queuenamesid . "";
// echo $sel1;exit;
$sel = mysqli_query($con, $sel1);
if (mysqli_num_rows($sel) > 0) {
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
} else {
    $totalRecords = 1;
}

## Total number of records with filtering

$sel2 = "select count(*) as allcount from cc_did_use LEFT JOIN users_login on cc_did_use.id_cc_card=users_login.id   WHERE 1 " . $queuenamesidss . " " . $searchQuery;
// echo $sel2;exit;
$sel2 = mysqli_query($con, $sel2);
if (mysqli_num_rows($sel2) > 0) {
    $records = mysqli_fetch_assoc($sel2);
    $totalRecordwithFilter = $records['allcount'];
} else {
    $totalRecordwithFilter = 1;
}
 
## Fetch records
$empQuery = "SELECT cc_did_use.reservationdate,cc_did_use.did,cc_did_use.did_provider,cc_did_use.expirationdate,cc_did_use.deleted_date,users_login.name,users_login.email FROM cc_did_use LEFT JOIN users_login ON cc_did_use.id_cc_card=users_login.id WHERE 1 " . $queuenamesidss . " " . $searchQuery ."order by cc_did_use.id desc";
// echo $empQuery;exit;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($empRecords)) {
    $user_name = $row['name'] . '<br>' . $row['email'];
    $data[] = array(
        "id" => $i,
        "username" => $user_name,
        "did" => $row['did'],
        "provider"=>$row['did_provider'],
        "start" => $row['reservationdate'],
        "expire"=>$row['expirationdate'],
        "delete"=>$row['deleted_date']
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
