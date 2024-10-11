<?php
include 'connection.php';

// echo '<pre>';print_r($_SESSION);exit;

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value
$ext_status = $_POST['ext_status'];
$host = $_POST['host'];
$expire_soon = $_POST['expire_days'];

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (sip.agent_name like '%" . $searchValue . "%' or
	 sip.name like '%" . $searchValue . "%' or
	 clnt.clientName like '%" . $searchValue . "%' or
	 sip.lead_operator like '%" . $searchValue . "%' or
	 users_login.email like '%" . $searchValue . "%')";
	// clnt.clientName like '%".$searchValue."%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);
if ($ext_status !== "" && $host !== "") {
	$expired_sql = " and sip.ext_status='0' and sip.host='static'";
} else {
	$expired_sql = "";
}


if ($expire_soon == 3) {
	$expiring_sql = " and (DATE(expirationdate) = DATE(NOW() + INTERVAL 2 DAY) OR DATE(expirationdate) = DATE(NOW() + INTERVAL 1 DAY) OR DATE(expirationdate) = DATE(NOW()))";
} else {
	$expiring_sql = "";
}
$queuenames_one = "SELECT cqt.name AS name FROM cc_queue_table cqt LEFT JOIN Client ON cqt.clientid = Client.clientId WHERE Client.clientId = '" . $_SESSION['userroleforclientid'] . "'";
$resultqueue_one = mysqli_query($connection, $queuenames_one);

$array_result_one = array();
//$sizeofvalue_one = sizeof($resultqueue_one);
foreach ($resultqueue_one as $transfer_record_one) {
	$destination_one = $transfer_record_one['name'];
	array_push($array_result_one, $destination_one);
}
$resultingsone = $array_result_one;
$queue_id = implode(",", $resultingsone);

## Total number of records without filtering
if ($_SESSION['userroleforpage'] == 1) {
	$sel = mysqli_query($con, "select count(*) as allcount from cc_sip_buddies where id_cc_card !=0");
} else {
	//$sel = mysqli_query($con,"select count(*) as allcount from cc_sip_buddies where accountcode =".$_SESSION['login_usernames']."");
	$sel = mysqli_query($con, "select count(*) as allcount from cc_sip_buddies sip LEFT JOIN Client clnt ON sip.clientId = clnt.clientID where sip.accountcode='" . $_SESSION['login_usernames'] . "' " . $expired_sql . "" . $expiring_sql . " ");
}
if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
} else {
	$totalRecords = 1;
}

## Total number of records with filtering
if ($_SESSION['userroleforpage'] == 1) {
	$sel = mysqli_query($con, "select count(*) as allcount from cc_sip_buddies sip LEFT JOIN Client clnt ON sip.clientId = clnt.clientId LEFT JOIN users_login ON sip.user_id = users_login.id WHERE 1 and id_cc_card !=0" . $searchQuery);
} else {
	//$sel = mysqli_query($con,"select count(*) as allcount from cc_sip_buddies sip WHERE sip.accountcode =".$_SESSION['login_usernames']." ".$searchQuery);	
	$sel = mysqli_query($con, "select count(*) as allcount from cc_sip_buddies sip LEFT JOIN Client clnt ON sip.clientId = clnt.clientId LEFT JOIN users_login ON sip.user_id = users_login.id where sip.accountcode='" . $_SESSION['login_usernames'] . "' " . $expired_sql . " " . $expiring_sql . " " . $searchQuery);
}

if (mysqli_num_rows($sel) > 0) {
	$records = mysqli_fetch_assoc($sel);
	$totalRecordwithFilter = $records['allcount'];
} else {
	$totalRecordwithFilter = 1;
}
## Fetch records

if ($_SESSION['userroleforpage'] == 1) {
	$empQuery = "SELECT sip.id as id,users_login.role,sip.play_ivr,users_login.plan_id,users_login.email, sip.agent_name AS agent_name, sip.name AS name, sip.secret AS secret, sip.lead_operator as lead_operator, clnt.clientName AS clientName, sip.host AS host, sip.ext_status, sip.expirationdate FROM `cc_sip_buddies` sip
	LEFT JOIN Client clnt ON sip.clientId = clnt.clientID LEFT JOIN users_login ON sip.id_cc_card = users_login.id WHERE id_cc_card != '0' " . $searchQuery . " order by sip.name " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
} else {

	$empQuery = "SELECT sip.id as id,users_login.role,sip.play_ivr,users_login.plan_id,users_login.email, sip.agent_name AS agent_name, sip.name AS name, sip.secret AS secret, sip.lead_operator as lead_operator, clnt.clientName AS clientName, sip.host AS host, sip.ext_status,sip.expirationdate FROM `cc_sip_buddies` sip
 	LEFT JOIN Client clnt ON sip.clientId = clnt.clientID LEFT JOIN users_login ON sip.user_id = users_login.id WHERE accountcode=" . $_SESSION['login_usernames'] . " " . $expired_sql . " " . $expiring_sql . " " . $searchQuery . " order by sip.name " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
}

// echo $empQuery;exit;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	$queueassign = "select queue_name from cc_queue_member_table where membername = '" . $row['name'] . "' ";
	$queue_res = mysqli_query($con, $queueassign);
	$array_result = array();
	//$sizeofvalue = sizeof($queue_res);
	foreach ($queue_res as $transfer_record) {
		$destination = $transfer_record['queue_name'];
		array_push($array_result, $destination);
	}
	$resultings = $array_result;
	$queue_id = implode(",", $resultings);
	$action = '';
	if ($row['ext_status'] == '0' && $row['host'] == 'static' && ($_SESSION['userroleforpage'] == 1)) {

		$action = '<a href="extedit.php?id=' . $row['id'] . '&ext=payment">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
		<i class="fa fa-repeat"></i>
		</button></a>';
	} elseif ($row['ext_status'] == '0' && $row['host'] == 'static' && $_SESSION['userroleforpage'] == 2) {
		$action = '<a href="create_ext_invoice.php?ext=' . base64_encode($row['id']) . '&ren=1">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
		<i class="fa fa-repeat"></i>
		</button></a>';
	} else {
		$action = '<a href="extedit.php?id=' . $row['id'] . '">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
		<i class="fa fa-pencil-square-o"></i>
		</button></a>';
	}

	$userType = $user_type_arr[$row['role']];

	if ($row['plan_id'] == 0) {
		$today = strtotime(date('Y-m-d H:i:s'));
		$expire = strtotime($row['expirationdate']);
		$timeleft = $expire - $today;
		$daysleft = ceil($timeleft / (60 * 60 * 24));
		$expired = date('d-m-Y', $expire);
		// echo $daysleft;exit;


		if ($daysleft == 1) {
			$msg = 'Expire Today';
		} elseif ($daysleft <= 0) {
			$msg = 'Expired';
		} else {
			$msg = $daysleft . " " . " Days left";
		}
	} else {
		$msg = '';
	}

	if ($row['play_ivr'] == 1) {
		$register_on = "Webphone";
	} else {
		$register_on = "Softphone(micro sip, x-lite etc..)";
	}


	$data[] = array(
		"Select" => '<td><input type="checkbox" class="emp_checkbox" data-emp-id="' . $row["id"] . '" style="float:left; margin-left:10px;"></td>',
		"agent_name" => $row['agent_name'],
		"name" => $row['name'],
		"email" => $row['email'],
		"clientName" => $row['clientName'],
		"userType" => $userType,
		"lead_operator" => $row['lead_operator'],
		"queueassigned" => $queue_id,
		"host" => '<span style="color:green;">' . $row['host'] . '</span><br>
			<span style="color:white;background:#ff0000a3;font-size: 15px;border-radius: 2px;">' . $msg . '</span>',
		"secret" => $row['secret'],
		"register_on" => $register_on,
		// "expire" => $expired,
		//"generate"=>'<button type="button" class="btn btn-primary" ><i class="fa fa-eye" aria-hidden="true"></i></button>',
		//'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
		"action" => '<div class="table-data-feature">
			<button type="button" class="item quickView" ><i class="fa fa-eye" aria-hidden="true"></i></button> ' . $action . '
<!--<a href="extedit.php?id=' . $row['id'] . '">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>-->
<a href="javascript:void(0)" onclick="return ExtensiondeleteContent(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a> 
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
