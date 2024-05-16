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
$value = $_POST['value'];

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (crg.did like '%" . $searchValue . "%' or 
        crg.did_provider like '%" . $searchValue . "%' )";
	// Client.clientName like'%".$searchValue."%' ) ";
}

if ($value == '0') {
	$searchType = " and crg.iduser='0' and crg.clientId='0'";
} elseif ($value == '1') {
	$searchType = " and crg.iduser!='0' and crg.clientId!='0'";
} else {
	$searchType = "";
}

## Total number of records without filtering

if ($_SESSION['userroleforpage'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.did FROM cc_did crg
	LEFT JOIN users_login ON crg.iduser=users_login.id
	WHERE users_login.id = '" . $_SESSION['login_user_id'] . "'";
	$resultqueue = mysqli_query($connection, $queuenames);

	$array_result = array();
	//$sizeofvalue = sizeof($resultqueue);
	foreach ($resultqueue as $transfer_record) {
		$destination = $transfer_record['did'];
		array_push($array_result, $destination);
	}
	$resultings = $array_result;
	$queue_id = implode(",", $resultings);
	$queuenamesid = 'where did in ("' . $queue_id . '")';
	$queuenamesidss = 'crg.did in ("' . $queue_id . '")';

}

if ($_SESSION['userroleforpage'] == 1) {
	$sel1 = "select count(*) as allcount from cc_did crg where 1" . $queuenamesid . " " . $searchType . "";
} else {
	$sel1 = "select count(*) as allcount from cc_did " . $queuenamesid . "";
}

// echo $sel1;exit;
$sel = mysqli_query($con, $sel1);
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}

## Total number of records with filtering
if ($_SESSION['userroleforpage'] == 1) {
	$sel2 = "select count(*) as allcount from cc_did crg WHERE 1 " . $queuenamesidss . " " . $searchType . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from cc_did crg WHERE " . $queuenamesidss . " " . $searchQuery;
}

$sel2 = mysqli_query($con, $sel2);
if (mysqli_num_rows($sel2) > 0) {
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
$plan_array = array();
$plan_query = "SELECT * FROM `master_plans`";
$plan_res = mysqli_query($con, $plan_query);
while ($plan_record = mysqli_fetch_assoc($plan_res)) {
	$plan_array[$plan_record['id']] = $plan_record['name'];
}

## Fetch records
if ($_SESSION['userroleforpage'] == 1) {
	//echo $empQuery = "select crg.id, crg.did, crg.billingtype, crg.did_provider, crg.activated, crg.fixrate, crg.connection_charge, crg.selling_rate, crg.aleg_retail_initblock, crg.aleg_retail_increment, crg.id_cc_country, cc_didgroup.didgroupname from cc_did crg left join users_login ON crg.iduser=users_login.id left join cc_didgroup ON crg.id_cc_didgroup 	WHERE 1 ".$queuenamesidss." ".$searchQuery." order by id desc limit ".$row.",".$rowperpage;

	$empQuery = "select crg.id, crg.did, crg.billingtype, crg.did_provider, crg.activated, crg.fixrate, crg.connection_charge, crg.selling_rate, crg.aleg_retail_initblock, crg.aleg_retail_increment, crg.id_cc_country, crg.clientId, id_cc_didgroup, cc_didgroup.didgroupname, Client.clientName from cc_did crg left join cc_didgroup on crg.id_cc_didgroup = cc_didgroup.id left join Client on crg.clientId = Client.clientId WHERE 1" . $queuenamesidss . " " . $searchType . " " . $searchQuery . " order by id desc limit " . $row . "," . $rowperpage;

} else {
	$empQuery = "SELECT crg.id, crg.did, crg.billingtype, crg.did_provider, crg.activated, crg.fixrate, crg.connection_charge, crg.selling_rate, crg.aleg_retail_initblock, crg.aleg_retail_increment, crg.id_cc_country, crg.clientId, cc_didgroup.didgroupname, Client.clientName
	FROM cc_did crg
	LEFT JOIN users_login ON crg.iduser = users_login.id
	LEFT JOIN cc_didgroup ON crg.id_cc_didgroup = cc_didgroup.id
	LEFT JOIN Client ON crg.clientId = Client.clientId
	WHERE " . $queuenamesidss . " " . $searchQuery . " order by id desc limit " . $row . "," . $rowperpage;
}
//echo '<pre>'; print_r($empQuery);exit;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($empRecords)) {

	$query_country = "select countryname from cc_country WHERE id='" . $row['id_cc_country'] . "' LIMIT 1";
	$result_country = mysqli_query($connection, $query_country);
	$row_country = mysqli_fetch_assoc($result_country);

	$countryname = $row_country['countryname'];
	if ($row['activated'] == '1') {
		$status = 'Active';
	} else {
		$status = 'Inactive';
	}
	$data[] = array(
		"did" => $row['did'],
		"billingtype" => isset($plan_array[$row['billingtype']]) ? $plan_array[$row['billingtype']] : '',
		"did_provider" => $row['did_provider'],
		"didgroupname" => $row['didgroupname'],
		"fixrate" => $row['fixrate'],
		"connection_charge" => $row['clientName'],
		"selling_rate" => $row['selling_rate'],
		"aleg_retail_initblock" => $row['aleg_retail_initblock'],
		"aleg_retail_increment" => $row['aleg_retail_increment'],
		"countryname" => $countryname,
		"activated" => $status,
		"action" => '<div class="table-data-feature">
<a href="didedit.php?id=' . $row['id'] . '">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<!--<a href="queuemanage.php?id=' . $row['id'] . '">
 <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
<i class="fa fa-users"></i> 
</button></a>-->
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
