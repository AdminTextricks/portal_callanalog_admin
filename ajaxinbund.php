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

// echo "<pre>";
// print_r($_POST);
// die();

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (cdid.did like '%" . $searchValue . "%' or 
	    ul.email like '%" . $searchValue . "%' or
		ul.name like '%" . $searchValue . "%' or
        cdid.carieer like '%" . $searchValue . "%' or 
        cdid.didtype like '%" . $searchValue . "%' or 
        cdid.call_destination like '%" . $searchValue . "%' or 
        clnt.clientName like '%" . $searchValue . "%' or 
		clnt.clientEmail like '%" . $searchValue . "%' or 
        cdid.status like'%" . $searchValue . "%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
if ($_SESSION['userroleforpage'] == 1) {
	$sel = mysqli_query($con, "select count(*) as allcount from cc_did cdid LEFT JOIN Client clnt ON cdid.clientId = clnt.clientId WHERE cdid.clientId = clnt.clientId");
} else {
	$sel = mysqli_query($con, "select count(*) as allcount from cc_did cdid LEFT JOIN Client clnt ON cdid.clientId = clnt.clientId where cdid.clientId = clnt.clientId and iduser=" . $_SESSION['login_user_id'] . "");
}
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if ($_SESSION['userroleforpage'] == 1) {
	$sel1 = "SELECT count(*) as allcount FROM cc_did cdid LEFT JOIN Client clnt ON cdid.clientId = clnt.clientId WHERE cdid.clientId = clnt.clientId  " . $searchQuery;
} else {
	$sel1 = "SELECT count(*) as allcount FROM cc_did cdid LEFT JOIN Client clnt ON cdid.clientId = clnt.clientId WHERE iduser=" . $_SESSION['login_user_id'] . " " . $searchQuery;
}
$selll = mysqli_query($con, $sel1);
$recordss = mysqli_fetch_assoc($selll);
$totalRecordwithFilter = $recordss['allcount'];

## Fetch records
//$empQuery = "select cdid.did as did, cdid.carieer as carieer, cdid.didtype as didtype, cdid.call_destination as call_destination,cdid.status as status,cdid.call_screening_action as call_screening_action from cc_did cdid WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
if ($_SESSION['userroleforpage'] == 1) {
	$empQuery = "SELECT cdid.id as id,cdid.did_provider, users_login.role,users_login.plan_id, cdid.did AS did,ul.name AS uname, clnt.clientEmail AS clientEmail,ul.email AS email, clnt.clientName AS clientName, cdid.carieer AS carieer, cdid.didtype AS didtype, cdid.call_destination AS call_destination,cdid.expirationdate, cdid.status AS status , cdid.call_screening_action AS call_screening_action
FROM cc_did cdid
RIGHT JOIN users_login ul ON cdid.iduser = ul.id 
LEFT JOIN Client clnt ON cdid.clientId = clnt.clientId LEFT JOIN users_login ON cdid.iduser = users_login.id WHERE cdid.clientId = clnt.clientId " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "SELECT cdid.id as id,cdid.did_provider, cdid.did AS did, clnt.clientEmail AS clientEmail, clnt.clientName AS clientName, cdid.carieer AS carieer, cdid.didtype AS didtype, cdid.call_destination AS call_destination,cdid.expirationdate, cdid.status AS status , cdid.call_screening_action AS call_screening_action
FROM cc_did cdid
RIGHT JOIN Client clnt ON cdid.clientId = clnt.clientId WHERE iduser=" . $_SESSION['login_user_id'] . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($con, $empQuery);


$selection_Query = "SELECT * FROM `cc_selection_did`";
$selection_Records = mysqli_query($con, $selection_Query);
$selection_array = array();
while ($sec_row = mysqli_fetch_assoc($selection_Records)) {
	$selection_array[$sec_row['id']] = $sec_row['selection_value'];
}

$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	$dial_type = '';
	if ($row['call_screening_action'] == 1) {
		$dial_type = 'Ring';
	} elseif ($row['call_screening_action'] == 9) {
		$dial_type = 'Hangup';
	}
	$action = '';
	$userType = $user_type_arr[$row['role']];

	if ($row['status'] == 'Suspended' && $_SESSION['userroleforpage'] == 2) {
		$action = '<div class="table-data-feature">
	<a href="create_invoice.php?item_name=' . $row['did'] . '">
	<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Renew">
	<i class="fa fa-repeat"></i>
	</button></a>
	</div>';
	} elseif ($row['status'] == 'Suspended' && $_SESSION['userroleforpage'] == 1 && in_array($row['role'], array(2, 3, 4))) {
		$action = '<div class="table-data-feature">
	<a href="inboundedit.php?id=' . $row['id'] . '&ren=yes">
	<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Renew">
	<i class="fa fa-repeat"></i>
	</button></a>
	</div>';
	} else {

		$edit_link = '<a href="inboundedit.php?id=' . $row['id'] . '">
	<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
	<i class="fa fa-pencil-square-o"></i>
	</button></a>';

		/* if(in_array($row['role'], array(3,4))){
					 $edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
				 <i class="fa fa-ban"></i>
				 </button>';
				 }else{
					 $edit_link = '<a href="inboundedit.php?id='.$row['id'].'">
				 <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
				 <i class="fa fa-pencil-square-o"></i>
				 </button></a>';
				 } */

		$action = '<div class="table-data-feature">' . $edit_link . '<a href="javascript:void(0)" onclick="return InbounddeleteContent(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
	</div>';
	}
	if ($row['user_id'] == $_SESSION['login_user_id']) {
		$user_name = '';
	} else {
		$user_name = $row['uname'] . '<br>' . $row['email'];
	}
	$today = strtotime(date('Y-m-d'));
	$expire = strtotime($row['expirationdate']);
	$timeleft = $expire - $today;
	$daysleft = round((($timeleft / 24) / 60) / 60);
	$expired = date('d-m-Y', $expire);

	// if($_SESSION['login_user_plan_id'] == 0 || ($_SESSION['userroleforpage'] == 1 && $row['plan_id'] == 0)){
	if ($daysleft == 1) {
		$msg = 'Expire Today';
	} elseif ($daysleft <= 0) {
		$msg = 'Expired';
	} elseif ($today < $expire && $daysleft <= 3) {
		$msg = 'Expire in ' . $daysleft . ' Days';
	} else {
		$msg = '';
	}
	// }

	$data[] = array(
		"did" => $row['did'],
		"userType" => $userType,
		"username" => $user_name,
		"email" => $row['clientEmail'],
		"carieer" => $row['did_provider'],
		"clientName" => $row['clientName'],
		"didtype" => $selection_array[$row['didtype']],
		"call_destination" => $row['call_destination'],
		"status" => $row['status'] . '<br>
			<span style="color:white;background:#ff0000a3;font-size: 15px;border-radius: 2px;">' . $msg . '</span>',
		"call_screening_action" => $dial_type,
		"expire" => $expired,
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
