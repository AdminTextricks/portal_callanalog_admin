<?php
include 'connection.php';
//echo '<pre>'; print_r($_POST);
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'cvm.'.$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (cvm.context like '%".$searchValue."%' or 
	cvm.mailbox like '%".$searchValue."%' or 
         cvm.email like '%".$searchValue."%' )";
}

## Total number of records without filtering

if($_SESSION['userroleforpage'] == 1){
	$mailboxnamesid = '';
	$mailboxnamesidss = '';
}else{
	$mailboxnames = "SELECT cvm.mailbox FROM cc_voicemail_users cvm LEFT JOIN users_login ON cvm.customer_id=users_login.id WHERE  cvm.customer_id = '".$_SESSION['login_user_id']."'";
	$resultmailbox = mysqli_query($connection, $mailboxnames);

	$array_result = array();
	//$sizeofvalue = sizeof($resultqueue);
	$resultmailbox->num_rows;
	foreach($resultmailbox as $transfer_record)
	{
		$destination  =  $transfer_record['mailbox'];
		array_push($array_result,$destination); 
	} 
	
	$resultings =  $array_result;
	$mail_id = implode(",",$resultings);
	$mailboxnamesid = 'where mailbox in ('.$mail_id.')';
	$mailboxnamesidss = 'cvm.mailbox in ('.$mail_id.')';
	
}

if($_SESSION['userroleforpage'] == 1){
	$sel1 = "select count(*) as allcount from cc_voicemail_users ".$mailboxnamesid."";
}else{
	$sel1 = "select count(*) as allcount from cc_voicemail_users ".$mailboxnamesid."";
}
$sel = mysqli_query($con,$sel1);

if(mysqli_num_rows($sel) > 0 ){
	$records = mysqli_fetch_assoc($sel);
	$totalRecords = $records['allcount'];
}else{
	$totalRecords = 1;
}


## Total number of records with filtering
if($_SESSION['userroleforpage'] == 1){
	$sel2 = "select count(*) as allcount from cc_voicemail_users cvm WHERE 1 ".$mailboxnamesidss." ".$searchQuery;
}else{
	$sel2 = "select count(*) as allcount from cc_voicemail_users cvm WHERE ".$mailboxnamesidss." ".$searchQuery;
}
$sel2 = mysqli_query($con,$sel2);
if(mysqli_num_rows($sel2) > 0 ){
	$records = mysqli_fetch_assoc($sel2);
	$totalRecordwithFilter = $records['allcount'];
}else{
	$totalRecordwithFilter = 1;
}
## Fetch records
if($_SESSION['userroleforpage'] == 1){
	$empQuery = "select cvm.*, users_login.id as userid, users_login.name, users_login.status, users_login.role,  Client.clientName from cc_voicemail_users cvm left join users_login ON cvm.customer_id=users_login.id left join Client ON cvm.clientid=Client.clientId WHERE 1 ".$mailboxnamesidss." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}else{
	$empQuery = "select cvm.*, users_login.id as userid,  users_login.name, users_login.status, users_login.role, Client.clientName from cc_voicemail_users cvm left join users_login ON cvm.customer_id=users_login.id left join Client ON cvm.clientid=Client.clientId WHERE ".$mailboxnamesidss." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;	
}
//$empQuery;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

	$userType = $user_type_arr[$row['role']];

	/* if (in_array($row['role'], array(3, 4))) {
		$edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-ban" aria-hidden="true"></i></button>';
	} else {
		$edit_link = '<a href="voiceMailEdit.php?id=' . $row['uniqueid'] . '">
			<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-pencil-square-o"></i>
			</button></a>';
	} */

	$edit_link = '<a href="voiceMailEdit.php?id=' . $row['uniqueid'] . '">
			<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
			<i class="fa fa-pencil-square-o"></i>
			</button></a>';

	$action = '<div class="table-data-feature">' . $edit_link . '	
	<a href="javascript:void(0)" onclick="return deleteVoiceMail(' . $row['uniqueid'] . ');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
	</div>';
	
    $data[] = array(
    		"mailbox"	=>$row['mailbox'],
			"UserType" =>$userType,
    		"email"		=>$row['email'],
    		"clientName"=>$row['clientName'],
    		"fullname"	=>$row['fullname'],
    		"context"	=>$row['context'],
			"dialout"=>$row['dialout'], 
    		"action"=>$action


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
