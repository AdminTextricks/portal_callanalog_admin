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
	$searchQuery = " and (crg.confno like '%" . $searchValue . "%' or 
        crg.maxusers like '%" . $searchValue . "%' or 
        crg.pin like '%" . $searchValue . "%' or 
		crg.adminpin like '%" . $searchValue . "%' or 
		crg.confDesc like '%" . $searchValue . "%' )";
	// Client.clientName like'%".$searchValue."%' ) ";
}
// $query_queue = "select crg.ringing as ringing,crg.name as name,Client.clientName as clientName, crg.strategy as strategy, crg.musicclass as musicclass , crg.status as status from cc_ring_group crg left join Client ON crg.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering

if ($_SESSION['userroleforpage'] == 1) {
	$confnoid = 'where ';
	$confnoidss = '';
} else {
	$queuenames = "SELECT crg.confno AS confno FROM booking crg
	LEFT JOIN users_login ON crg.user_id=users_login.id
	WHERE users_login.id = '" . $_SESSION['login_user_id'] . "'";

	$resultqueue = mysqli_query($connection, $queuenames);

	// while($rowsds = mysqli_fetch_array($resultqueue))
	// {
	// $confnoid = 'where name ='.$rowsds['name'];
	// $confnoidss = 'crg.name ='.$rowsds['name'];
	// }

	$array_result = array();
	//$sizeofvalue = sizeof($resultqueue);
	$resultqueue->num_rows;
	foreach ($resultqueue as $transfer_record) {
		$destination = $transfer_record['confno'];
		array_push($array_result, $destination);
	}
	$resultings = $array_result;
	$conf_id = implode("','", $resultings);
	$confnoid = "where confno in ('" . $conf_id . "')";
	$confnoidss = "crg.confno in ('" . $conf_id . "')";

}


if ($_SESSION['userroleforpage'] == 1) {
	$sel1 = "select count(*) as allcount from booking ";
} else {
	$sel1 = "select count(*) as allcount from booking " . $confnoid;
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
	$sel2 = "select count(*) as allcount from booking crg WHERE 1 " . $confnoidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from booking crg WHERE " . $confnoidss . " " . $searchQuery;
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
	$empQuery = "select crg.*, users_login.id as userid, users_login.email, users_login.name, users_login.status as ustatus, users_login.role, Client.clientName from booking crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId WHERE 1 " . $confnoidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*, users_login.id as userid, users_login.email, users_login.name, users_login.status as ustatus, users_login.role,  Client.clientName from booking crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId WHERE " . $confnoidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
}
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	$userType = $user_type_arr[$row['role']];

	/* if (in_array($row['role'], array(3, 4))) {
		$edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-ban" aria-hidden="true"></i></button>';
	} else {
		$edit_link = '<a href="conferenceedit.php?id=' . $row['Id'] . '">
			<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-pencil-square-o"></i>
			</button></a>';
	} */
	$edit_link = '<a href="conferenceedit.php?id=' . $row['Id'] . '">
			<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-pencil-square-o"></i>
			</button></a>';

	$action = '<div class="table-data-feature">' . $edit_link . '	
	<a href="javascript:void(0)" onclick="return ConferencedeleteContent(' . $row['Id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
	</div>';


	$data[] = array(
		"confDesc" => $row['confDesc'],
		"user_id" => $row['user_id'],
		"userType" => $userType,
		"clientId" => $row['clientId'],
		"confno" => $row['confno'],
		"pin" => $row['pin'],
		"adminpin" => $row['adminpin'],
		"maxusers" => $row['maxusers'],
		"status" => $row['status'],
		"clientName" => $row['clientName'],
		//'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
		"action" => $action
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