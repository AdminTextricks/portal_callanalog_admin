<?php
include 'connection.php';
//echo '<pre>'; print_r($_POST);
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
    $searchQuery = " and (crg.group_name like '%" . $searchValue . "%')";
    // Client.clientName like'%".$searchValue."%' ) ";
}
## Total number of records without filtering
$sel1 = "select count(*) as allcount from ratecard_group";
$sel = mysqli_query($con, $sel1);

if (mysqli_num_rows($sel) > 0) {
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];
} else {
    $totalRecords = 1;
}

## Total number of records with filtering

$sel2 = "select count(*) as allcount from ratecard_group crg WHERE 1 " . $searchQuery;
// echo $sel2;exit;
$sel2 = mysqli_query($con, $sel2);
if (mysqli_num_rows($sel2) > 0) {
    $records = mysqli_fetch_assoc($sel2);
    $totalRecordwithFilter = $records['allcount'];
} else {
    $totalRecordwithFilter = 1;
}
## Fetch records

$empQuery = "select crg.* from ratecard_group crg WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
// echo $empQuery;exit;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

    if ($row['status'] == 1) {
        $status = "Active";
    } else {
        $status = "Inactive";
    }

    $data[] = array(
        "id" => $i,
        "group_name" => $row['group_name'],
        "status" => $status,
        "action" => '
        <div class="table-data-feature"><a href="ratecardedit.php?id=' . $row['id'] . '">
        <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
        <i class="fa fa-pencil-square-o"></i>
        </button></a>	
        <a href="javascript:void(0)" onclick="return ratecardedeleteContent(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
        </div>'
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