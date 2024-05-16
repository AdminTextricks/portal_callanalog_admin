<?php
include 'connection.php';
//echo '<pre>'; print_r($_POST);
## Read value
if (isset($_SESSION['userroleforpage'])) {
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
		$searchQuery = " and (cc_selection_did.selection_value like '%" . $searchValue . "%' or 
         crg.startday like '%" . $searchValue . "%' or 
         crg.stopday like '%" . $searchValue . "%' )";
	}

	## Total number of records without filtering
	if ($_SESSION['userroleforpage'] == 1) {
		$queuenamesid = '';
		$queuenamesidss = '';
	} else {
		$queuenames = "SELECT crg.id AS id FROM cc_time_group crg
	LEFT JOIN users_login ON crg.user_id=users_login.id
	WHERE  crg.user_id = '" . $_SESSION['login_user_id'] . "'";

		$resultqueue = mysqli_query($connection, $queuenames);
		$array_result = array();
		$resultqueue->num_rows;
		foreach ($resultqueue as $transfer_record) {
			$destination = $transfer_record['id'];
			array_push($array_result, $destination);
		}
		$resultings = $array_result;
		$ring_id = implode(",", $resultings);
		$queuenamesid = 'where id in ("' . $ring_id . '")';
		$queuenamesidss = 'crg.id in ("' . $ring_id . '")';
	}
	if ($_SESSION['userroleforpage'] == 1) {
		$sel1 = "select count(*) as allcount from cc_time_group " . $queuenamesid . "";
	} else {
		$sel1 = "select count(*) as allcount from cc_time_group " . $queuenamesid . "";
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
		$sel2 = "select count(*) as allcount from cc_time_group crg WHERE 1 " . $queuenamesidss . " " . $searchQuery;
	} else {
		$sel2 = "select count(*) as allcount from cc_time_group crg WHERE " . $queuenamesidss . " " . $searchQuery;
	}
	// echo"<pre>"; print_r($sel2);

	$sel2 = mysqli_query($con, $sel2);

	if (mysqli_num_rows($sel2) > 0) {
		$records = mysqli_fetch_assoc($sel2);
		$totalRecordwithFilter = $records['allcount'];
	} else {
		$totalRecordwithFilter = 1;
	}
	## Fetch records
	if ($_SESSION['userroleforpage'] == 1) {
		$empQuery = "select crg.*,cc_selection_did.selection_value, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role, Client.clientName from cc_time_group crg 
	left join users_login ON crg.user_id=users_login.id 
	left join Client ON crg.client_id=Client.clientId 
	left join cc_selection_did ON crg.destination_type=cc_selection_did.id 
	WHERE 1 " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	} else {
		$empQuery = "select crg.*,cc_selection_did.selection_value, users_login.id as userid, users_login.email, users_login.name, users_login.status, users_login.role, Client.clientName from cc_time_group crg 
	left join users_login ON crg.user_id=users_login.id 
	left join Client ON crg.client_id=Client.clientId 
	left join cc_selection_did ON crg.destination_type=cc_selection_did.id 
	WHERE " . $queuenamesidss . " " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;
	}
	// echo $empQuery;exit;

	// echo"<pre>"; print_r($empQuery); 

	$empRecords = mysqli_query($con, $empQuery);
	$data = array();
	$i = 1;
	if (mysqli_num_rows($empRecords) > 0) {
		while ($row = mysqli_fetch_assoc($empRecords)) {
			if ($row['all_time'] == '1') {
				$all_time = "Yes";
			} else {
				$all_time = "No";
			}

			$userType = $user_type_arr[$row['role']];

			/* if (in_array($row['role'], array(3, 4))) {
																$edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
															<i class="fa fa-ban"></i>
															</button>';
															} else {
																$edit_link = '<a href="timegroupedit.php?id=' . $row['id'] . '">
														<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
														<i class="fa fa-pencil-square-o"></i>
														</button></a>';
															} */

			$edit_link = '<a href="timegroupedit.php?id=' . $row['id'] . '">
	<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
	<i class="fa fa-pencil-square-o"></i>
	</button></a>';

			$action = '<div class="table-data-feature">' . $edit_link . '<a href="javascript:void(0)" onclick="return deleteContenttimegroup(' . $row['id'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
	</div>';
			$folder = 'timegroup/' . $row['ivr_file'] . ".mp3";

			$audio = "<audio type='audio/wav' src='$folder' controls='' controlslist='nodownload' > </audio>";
			$data[] = array(
				"destination_type" => $row['selection_value'],
				"destination" => $row['destination'],
				"userType" => $userType,
				"sch_call" => $row['sch_call'],
				"starttime" => $row['starttime'],
				"stoptime" => $row['stoptime'],
				"startday" => $row['startday'],
				"stopday" => $row['stopday'],
				"all_time" => $all_time,
				"message" => $row['message'],
				"ivr_file" => $audio,
				"action" => $action
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
} else {
	$response = array(
		"draw" => intval($draw),
		"iTotalRecords" => $totalRecords,
		"iTotalDisplayRecords" => $totalRecordwithFilter,
		"aaData" => $data
	);
}
echo json_encode($response);
