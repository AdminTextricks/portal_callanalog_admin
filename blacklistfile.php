<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (caller_id like '%".$searchValue."%' or 
        message like '%".$searchValue."%' or 
        status like '%".$searchValue."%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
if($_SESSION['userroleforpage'] == '1'){ 
	$sel = mysqli_query($con,"select count(*) as allcount from cc_blacklist");
}else{
	$sel = mysqli_query($con,"select count(*) as allcount from cc_blacklist where user_id= '".$_SESSION['login_user_id']."'");
}
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if($_SESSION['userroleforpage'] == '1'){ 
	$sel = mysqli_query($con,"select count(*) as allcount from cc_blacklist WHERE 1 ".$searchQuery);
}else{
	$sel = mysqli_query($con,"select count(*) as allcount from cc_blacklist WHERE user_id= '".$_SESSION['login_user_id']."' ".$searchQuery);
}

$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
//$empQuery = "select cqt.queue_name as queue_name, cqt.id as id,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
if($_SESSION['userroleforpage'] == '1'){
	$empQuery = "SELECT cc_blacklist.id,digits,transfer_number,cc_blacklist.status,cc_blacklist.subject,cc_blacklist.ruletype,cc_blacklist.blocktype, cc_blacklist.clientId, Client.clientName, users_login.role FROM `cc_blacklist` INNER JOIN Client ON cc_blacklist.clientId = Client.clientId INNER JOIN users_login ON cc_blacklist.user_id = users_login.id WHERE 1 ".$searchQuery." order by id ".$columnSortOrder." limit ".$row.",".$rowperpage;
 }else{
	$empQuery = "SELECT id,digits,transfer_number,cc_blacklist.status,cc_blacklist.subject,cc_blacklist.ruletype,cc_blacklist.blocktype FROM `cc_blacklist` WHERE user_id= '".$_SESSION['login_user_id']."' ".$searchQuery." order by id ".$columnSortOrder." limit ".$row.",".$rowperpage;	
}
// echo $empQuery;exit;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	
   if($row['status'] == 1){
		$status = 'ENABLE'; 
	} else { 
		$status = 'DISABLE'; 
	}

	$userType = $user_type_arr[$row['role']];
		
			if(in_array($row['role'], array(3,4))){
				$edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
				<i class="fa fa-ban"></i>
				</button>';
			}else{
				$edit_link = '<a href="blacklistedit.php?id='.$row['id'].'">
				<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
				<i class="fa fa-pencil-square-o"></i>
				</button></a>';
			}
	
			$action = '<div class="table-data-feature">'.$edit_link.'
				<a href="javascript:void(0)" onclick="return deleteContentBlacklist('.$row['id'].');" type="button" class="">
				<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
				<i class="fa fa-trash"></i>
				</button></a>
				
				</div>';
   $data[] = array(
			
    		"serial"=>$i,
			"company"=>$row['clientName'],
			"userType"=>$userType,
    		"number"=>$row['digits'],
    		"subject"=>$row['subject'],
    		"type"=>$row['ruletype'],
			"transfer_no"=>$row['transfer_number'],
			"block_type"=>$row['blocktype'],
    		"status"=>$status,
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
