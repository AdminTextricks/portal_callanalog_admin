<?php

include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (email like '%" . $searchValue . "%' or 
        name like '%" . $searchValue . "%' or
		cl.clientName like '%" . $searchValue . "%' ) ";
}

if ($_SESSION['userroleforpage'] == 1) {
	$clientidsssd = 'where 1';
	$clientidsssd1 = 'where 1 ';
}
// elseif($_SESSION['userroleforpage'] == 2){
// $clientidsssd1 = 'where clientId=""';
// }
else {

	$clientidsssd = 'where cl.clientId="' . $_SESSION['userroleforclientid'] . '" and deleted ="0"';
	$clientidsssd1 = 'where cl.clientId="' . $_SESSION['userroleforclientid'] . '" and deleted ="0"';
}

if ($_POST['role'] !== "") {
	$resellers = " and role='" . $_POST['role'] . "'";
} else {
	$resellers = "";
}

## Total number of records without filtering
$sel = "SELECT  count(*) as allcount FROM `users_login` ul left join Client cl ON ul.clientId=cl.clientId " . $clientidsssd . " " . $resellers . "";
$sel = mysqli_query($con, $sel);

$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = "SELECT  count(*) as allcount FROM `users_login` ul left join Client cl ON ul.clientId=cl.clientId " . $clientidsssd1 . " " . $resellers . " " . $searchQuery;
$sel = mysqli_query($con, $sel);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records

$empQuery = "SELECT  ul.id as id, ul.email as email, ul.name as name, ul.clientId as clientId, ul.role as role, ul.createDate as createDate, cl.clientName as clientName , ul.status as status, ul.deleted as deleted, ul.password, ul.plan_id as user_plan_id FROM `users_login` ul left join Client cl ON ul.clientId=cl.clientId " . $clientidsssd1 . " " . $resellers . " " . $searchQuery . " order by createDate " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	if ($row['role'] == 1) {
		$role = 'Admin';
	} elseif ($row['role'] == 2) {
		$role = 'User';
	} elseif ($row['role'] == 3) {
		$role = 'Reseller';
	} else {
		$role = 'Reseller-user';
	}

	if ($row['deleted'] == '1' and $row['status'] == 'Inactive') {
		$status = '<div class="deleted">Deleted</div>';
	} elseif ($row['status'] == 'Inactive') {
		$status = 'Inactive';
	} else {
		$status = 'Active';
	}


	$card_query = "SELECT id, credit, uipass  FROM `cc_card` where id='" . $row['id'] . "'";
	$card_res = mysqli_query($con, $card_query);
	$card_records = mysqli_fetch_assoc($card_res);
	$credit = $card_records['credit'];

	if ($row['role'] == 1) {
		$plan_name = '';
	} else {
		$plan_sql = "SELECT * FROM `master_plans` where id = '" . $row['user_plan_id'] . "'";
		$plan_result = mysqli_query($con, $plan_sql) or die("query failed");
		$plan_details = mysqli_fetch_assoc($plan_result);
		$plan_name = $plan_details['name'];
	}

	$extension_arr = array();
	$sipQuery = "SELECT id, agent_name,  `name`,  `secret` FROM `cc_sip_buddies` WHERE id_cc_card = '" . $row['id'] . "' and ext_status='1'";
	$sip_result = mysqli_query($con, $sipQuery) or die("query failed");
	while ($sip_details = mysqli_fetch_assoc($sip_result)) {
		$extension_arr[$sip_details['id']] = array($sip_details['name'], $sip_details['secret']);
	}
	$did_arr = array();
	$didQuery = "SELECT id, `did` FROM `cc_did` WHERE iduser = '" . $row['id'] . "'";
	$did_result = mysqli_query($con, $didQuery) or die("query failed");
	while ($did_details = mysqli_fetch_assoc($did_result)) {
		$did_arr[$did_details['id']] = $did_details['did'];
	}

	$combined_arr = array("username" => trim($row['email']), "ext_details" => $extension_arr, "did_details" => $did_arr);
	// echo '<pre>';print_r($extension_arr);
	//echo json_encode($extension_arr);
	$data[] = array(

		"Select" => '<td><span data-extension-details=' . json_encode($combined_arr, true) . '></span><input type="checkbox" class="emp_checkbox" data-emp-id="' . $row['id'] . '" style="float:left; margin-left:10px;"></td>',
		"email" => $row['email'],
		"name" => $row['name'],
		"clientId" => $row['clientName'],
		"role" => $role,
		"credit" => $credit,
		"plan_name" => $plan_name,
		"status" => $status,
		"createDate" => $row['createDate'],
		"action" => '<div class="table-data-feature">
			<a href="javascript:void(0)" onclick="return resetPassword(' . $row['id'] . ');" type="button" class=""><button type="button" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="change_pass"><i class="fa fa-key" aria-hidden="true"></i></button></a>
<!--<a href="useredit.php?id=' . $row['id'] . '">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-eye"></i>
</button></a>-->
<a href="useredit.php?id=' . $row['id'] . '">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button>
<a href="javascript:void(0)" onclick="return UserdeleteContent(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a> 
</a>
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
