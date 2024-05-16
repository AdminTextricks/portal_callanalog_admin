<?php
include 'connection.php';
// echo '<pre>'; print_r($_POST);exit;
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'crg.' . $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$user_id = $_POST['userid'];
$recharged_by = $_POST['recharged_by'];

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (users_login.name like '%" . $searchValue . "%' or 
         crg.recharged_by like '%" . $searchValue . "%' )";
}

if ($fromDate !== "" && $toDate !== "") {
	$by_date = "and DATE(created_at) between '" . $fromDate . "' and '" . $toDate . "'";
} else {
	$by_date = "";
}

if ($user_id !== "") {
	$user_id = "and crg.user_id='" . $user_id . "'";
} else {
	$user_id = "";
}

if ($recharged_by !== "") {
	$recharged_by = "and crg.recharged_by='" . $recharged_by . "'";
} else {
	$recharged_by = "";
}
## Total number of records without filtering

$sel1 = "select count(id) as allcount from recharge_history";
$sel = mysqli_query($con, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}


## Total number of records with filtering
$sel2 = "select count(crg.id) as allcount from recharge_history crg left join users_login ON crg.user_id=users_login.id WHERE 1 " . $by_date . "  " . $user_id . " " . $recharged_by . " " . $searchQuery;

$sel2 = mysqli_query($con, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records
$empQuery = "select crg.*,users_login.clientId, users_login.name,users_login.email from recharge_history crg left join users_login ON crg.user_id=users_login.id where 1 " . $by_date . " " . $user_id . " " . $recharged_by . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
// echo $empQuery;exit;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
if (mysqli_num_rows($empRecords) > 0) {
	while ($row = mysqli_fetch_assoc($empRecords)) {
		$client_query = "select clientName, clientEmail from Client where clientId = '" . $row['clientId'] . "'";
		$client_res = mysqli_query($connection, $client_query) or die("query failed : client_query");
		$cltrow = mysqli_fetch_assoc($client_res);
		$client_name = $cltrow['clientName'];
		$client_email = $cltrow['clientEmail'];
		/* if ($_SESSION['userroleforpage'] == 2) {
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
			  } */

		$data[] = array(
			"id" => $i,
			"username" => $client_name . '/' . $client_email,
			"old_bal" => $row['current_bal'],
			"add_bal" => $row['add_bal'],
			"total_bal" => $row['total_bal'],
			"currency" => $row['currency'],
			"recharged_by" => $row['recharged_by'],
			"created_at" => $row['created_at'],
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
