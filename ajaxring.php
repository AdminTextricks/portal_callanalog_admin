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
	$searchQuery = " and (crg.ringing like '%" . $searchValue . "%' or 
         crg.description like '%" . $searchValue . "%' or 
         crg.ringno like '%" . $searchValue . "%' or 
		 crg.strategy like '%" . $searchValue . "%' or
		 Client.clientName like '%" . $searchValue . "%' or
		 users_login.email like '%".$searchValue."%')";
}

## Total number of records without filtering

if ($_SESSION['userroleforpage'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.ringno AS ringno FROM cc_ring_group crg
	LEFT JOIN users_login ON crg.user_id=users_login.id
	WHERE  users_login.id = '" . $_SESSION['login_user_id'] . "'";
	$resultqueue = mysqli_query($connection, $queuenames);

	$array_result = array();
	// $sizeofvalue = sizeof($resultqueue);
	$resultqueue->num_rows;
	foreach ($resultqueue as $transfer_record) {
		$destination = $transfer_record['ringno'];
		array_push($array_result, $destination);
	}
	$resultings = $array_result;
	$ring_id = implode(",", $resultings);
	$queuenamesid = 'where ringno in (' . $ring_id . ')';
	$queuenamesidss = 'crg.ringno in (' . $ring_id . ')';

	// echo $ring_id; exit;

}

if ($_SESSION['userroleforpage'] == 1) {
	$sel1 = "select count(*) as allcount from cc_ring_group " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from cc_ring_group " . $queuenamesid . "";
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
	$sel2 = "select count(*) as allcount from cc_ring_group crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from cc_ring_group crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId WHERE " . $queuenamesidss . " " . $searchQuery;
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
	$empQuery = "select crg.*, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role,  Client.clientName from cc_ring_group crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role, Client.clientName from cc_ring_group crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId WHERE " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
}
//$empQuery;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
if (mysqli_num_rows($empRecords) > 0) {
	while ($row = mysqli_fetch_assoc($empRecords)) {

		$userType = $user_type_arr[$row['role']];

		$edit_link = '<a href="ringedit.php?id=' . $row['id'] . '">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
		<i class="fa fa-pencil-square-o"></i>
		</button></a>
		<a href="ringmanage.php?id=' . $row['id'] . '&uid=' . $row['userid'] . '">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
		<i class="fa fa-users"></i> 
		</button></a>';

		/* if(in_array($row['role'], array(3,4))){
						$edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
						<i class="fa fa-ban"></i>
						</button>
						<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
						<i class="fa fa-ban"></i> 
						</button>';
					}else{
						$edit_link = '<a href="ringedit.php?id='.$row['id'].'">
						<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
						<i class="fa fa-pencil-square-o"></i>
						</button></a>
						<a href="ringmanage.php?id='.$row['id'].'&uid='.$row['userid'].'">
						<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
						<i class="fa fa-users"></i> 
						</button></a>';
					} */

		$data[] = array(
			"description" => $row['description'],
			"ringno" => $row['ringno'],
			"ringpre" => $row['ringpre'],
			"strategy" => $row['strategy'],
			"ringtime" => $row['ringtime'],
			"ringlist" => $row['ringlist'],
			"ringing" => $row['ringing'],
			"progress" => $row['progress'],
			"clientName" => $row['clientName'],
			"userType" => $userType,
			"elsewhere" => $row['elsewhere'],
			"action" => '<div class="table-data-feature">' . $edit_link . '<a href="javascript:void(0)" onclick="return deleteContentRing(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a></div>'
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
