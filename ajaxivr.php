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
	$searchQuery = " and (crg.ivr_name like '%" . $searchValue . "%' or 
         crg.ivr_timeout like '%" . $searchValue . "%' or 
         crg.ivr_status like '%" . $searchValue . "%' )";
	// Client.clientName like'%".$searchValue."%' ) ";
	// crg.ringlist like '%".$searchValue."%' or 
// crg.ringtime like '%".$searchValue."%' or
// crg.description like '%".$searchValue."%' or
}
// $query_queue = "select crg.ringing as ringing,crg.name as name,Client.clientName as clientName, crg.strategy as strategy, crg.musicclass as musicclass , crg.status as status from cc_ring_group crg left join Client ON crg.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering

if ($_SESSION['userroleforpage'] == 1) {
	$queuenamesid = '';
	$queuenamesidss = '';
} else {
	$queuenames = "SELECT crg.id AS id FROM ivr crg
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
	$ring_id = "'" . implode("', '", $resultings) . "'";
	$queuenamesid = 'where id in ("' . $ring_id . '")';
	$queuenamesidss = 'crg.id in ("' . $ring_id . '")';

}

if ($_SESSION['userroleforpage'] == 1) {
	$sel1 = "select count(*) as allcount from ivr " . $queuenamesid . "";
} else {
	$sel1 = "select count(*) as allcount from ivr " . $queuenamesid . "";
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
	$sel2 = "select count(*) as allcount from ivr crg WHERE 1 " . $queuenamesidss . " " . $searchQuery;
} else {
	$sel2 = "select count(*) as allcount from ivr crg WHERE " . $queuenamesidss . " " . $searchQuery;
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
	$empQuery = "select crg.*, music.upload_music,music.file_ext, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role,  Client.clientName from ivr crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId left join  music ON crg.ivr_announcement=music.id WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
} else {
	$empQuery = "select crg.*,music.upload_music,music.file_ext, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role, Client.clientName from ivr crg left join users_login ON crg.user_id=users_login.id left join Client ON crg.clientid=Client.clientId left join music ON crg.ivr_announcement=music.id WHERE " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
}
// echo $empQuery;exit;
$empRecords = mysqli_query($con, $empQuery);
// echo mysqli_num_rows($empRecords);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	$userType = $user_type_arr[$row['role']];

	/* if(in_array($row['role'], array(3,4))){
			  $edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			  <i class="fa fa-ban" aria-hidden="true"></i></button>';
		  }else{
			  $edit_link = '<a href="ivredit.php?id='.$row['id'].'">
			  <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			  <i class="fa fa-pencil-square-o"></i>
			  </button></a>';
		  } */
	$edit_link = '<a href="ivredit.php?id=' . $row['id'] . '">
			<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-pencil-square-o"></i>
			</button></a>';

	$action = '<div class="table-data-feature">' . $edit_link . '	
	<a href="javascript:void(0)" onclick="return deleteContentIvr(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
	</div>';

	if ($row['ivr_status'] == '1') {
		$status = "Enable";
	} else {
		$status = "Disable";
	}
	if ($row['file_ext'] == "mp3") {
		$folder = "assets/audio/" . $row['upload_music'] . ".mp3";
	} else {
		$folder = "assets/audio/" . $row['upload_music'] . ".wav";
	}



	$audio = "<audio type='audio/wav' src='$folder' controls='' controlslist='nodownload' > </audio>";
	$data[] = array(
		"clientName" => $row['clientName'],
		"ivr_name" => $row['ivr_name'],
		"ivr_description" => $row['ivr_description'],
		"UserType" => $userType,
		"ivr_announcement" => $audio,
		"ivr_timeout" => $row['ivr_timeout'],
		"ivr_status" => $status,
		"created_at" => $row['created_at'],
		//'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
		// if($_SESSION['userroleforpage'] == 1){
		"view_dtmf" => '<a href="javascript:void(0)" onclick="return OptionContentIvr(' . $row['id'] . ');" type="button" class=""><button type="button" id="ivr_btn" class="btn btn-primary">DTMF</button></a>',
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
