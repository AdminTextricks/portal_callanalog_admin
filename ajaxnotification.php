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
$clientId = $_POST['clientId'];
$item_type = $_POST['item_type'];
$notification_type = $_POST['notification_type'];

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (crg.activity_type like '%" . $searchValue . "%' or 
         crg.IP_address like '%" . $searchValue . "%' or 
         crg.message like '%" . $searchValue . "%' )";
}
if ($clientId !== "") {
	$clientId = "and crg.client_id='" . $clientId . "'";
} else {
	$clientId = "";
}

if ($item_type !== "" or $notification_type !== "") {
	$activity_type = "and crg.activity_type like '%" . $item_type . " " . $notification_type . "%'";
} else {
	$activity_type = "";
}
## Total number of records without filtering

if ($_SESSION['userroleforpage'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM user_activity_log crg
	LEFT JOIN users_login ON crg.user_id=users_login.id
	WHERE  users_login.id = '" . $_SESSION['login_user_id'] . "'";
	$resultqueue = mysqli_query($connection, $queuenames);

	$array_result = array();
	// $sizeofvalue = sizeof($resultqueue);
	$resultqueue->num_rows;
	foreach ($resultqueue as $transfer_record) {
		$destination = $transfer_record['id'];
		array_push($array_result, $destination);
	}
	$resultings = $array_result;
	$ring_id = implode(",", $resultings);
	$queuenamesid = 'where id in (' . $ring_id . ')';
	$queuenamesidss = 'crg.id in (' . $ring_id . ')';

}

if ($_SESSION['userroleforpage'] == 1) {
	$sel1 = "select count(id) as allcount from user_activity_log " . $queuenamesid . "";
} else {
	$sel1 = "select count(id) as allcount from user_activity_log " . $queuenamesid . "";
}
$sel = mysqli_query($con, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}


## Total number of records with filtering
if ($_SESSION['userroleforpage'] == 1) {
	$sel2 = "select count(id) as allcount from user_activity_log crg WHERE 1 " . $clientId . " " . $activity_type . " " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(id) as allcount from user_activity_log crg WHERE " . $queuenamesidss . " " . $clientId . " " . $activity_type . " " . $searchQuery;
}

$sel2 = mysqli_query($con, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
if ($_SESSION['userroleforpage'] == 1) {
	$empQuery = "select crg.*, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role,  Client.clientName from user_activity_log crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.client_id=Client.clientId WHERE 1 " . $clientId . " " . $activity_type . " " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role, Client.clientName from user_activity_log crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.client_id=Client.clientId WHERE " . $queuenamesidss . " " . $clientId . " " . $activity_type . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
if (mysqli_num_rows($empRecords) > 0) {
	while ($row = mysqli_fetch_assoc($empRecords)) {
		if ($_SESSION['userroleforpage'] == 2) {
			$noti_status = $row['user_status'];
		} elseif ($_SESSION['userroleforpage'] == 1) {
			$noti_status = $row['admin_status'];
		}
		$arry_msg = explode(" ", $row['message']);
		$activity_msg = explode(" ", $row['activity_type']);
		if (!in_array("Admin", $arry_msg) && !in_array('Admin', $activity_msg)) {
			$IP_address = $row['IP_address'];
		} else {
			$IP_address = 'Admin';
		}

		$data[] = array(
			"id" => $i,
			// "id"=>$row['id'],
			"userid" => $row['userid'],
			"name" => $row['name'],
			"clientName" => $row['clientName'],
			"activity_date" => $row['activity_date'],
			"IP_address" => $IP_address,
			"activity_time" => $row['activity_time'],
			"activity_type" => $row['activity_type'],
			// if($_SESSION['userroleforpage'] == 1){
			"message" => $row['message'],
			"noti_status" => $noti_status,
		);
		$i++;
	}
}
## Response
$response = array(
	"draw" => intval($draw),
	"iTotalRecords" => $totalRecords,
	"iTotalDisplayRecords" => $totalRecordwithFilter,
	"aaData" => $data
);

echo json_encode($response);
