<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'crg.'.$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (crg.did like '%".$searchValue."%' or 
        Client.clientName like'%".$searchValue."%' ) ";
}

## Total number of records without filtering

if($_SESSION['userroleforpage'] == 1){
	$queuenamesid = '';
	$queuenamesidss = '';
}else{
	$queuenames = "SELECT crg.did_id FROM did_buying_history crg
	LEFT JOIN users_login ON crg.iduser=users_login.id
	WHERE users_login.id = '".$_SESSION['login_user_id']."'";
	$resultqueue = mysqli_query($connection,$queuenames);

	$array_result = array();
	//$sizeofvalue = sizeof($resultqueue);
	foreach($resultqueue as $transfer_record)
	{
		$destination  =  $transfer_record['did_id'];
		array_push($array_result,$destination); 
	} 
	$resultings =  $array_result;
	$queue_id = implode(",",$resultings);
	$queuenamesid = 'where did_id in ('.$queue_id.')';
	$queuenamesidss = 'crg.did_id in ('.$queue_id.')';
	
}

if($_SESSION['userroleforpage'] == 1){
$sel1 = "select count(*) as allcount from did_buying_history ".$queuenamesid."";
}else{
$sel1 = "select count(*) as allcount from did_buying_history ".$queuenamesid."";
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
$sel2 = "select count(*) as allcount from did_buying_history crg WHERE 1 ".$queuenamesidss." ".$searchQuery;
}else{
$sel2 = "select count(*) as allcount from did_buying_history crg WHERE ".$queuenamesidss." ".$searchQuery;
}

$sel2 = mysqli_query($con,$sel2);
if(mysqli_num_rows($sel2) > 0 ){
$records = mysqli_fetch_assoc($sel2);
$totalRecordwithFilter = $records['allcount'];
}else{
	$totalRecordwithFilter = 1;	
}

## Fetch records
$empQuery = "select crg.*, cc_did.did, Client.clientName from did_buying_history crg 
left join cc_did on crg.did_id= cc_did.id 
left join Client on crg.clientId = Client.clientId 
WHERE 1".$queuenamesidss." ".$searchQuery." order by id desc limit ".$row.",".$rowperpage;

//echo '<pre>'; print_r($empQuery);exit;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;

while ($row = mysqli_fetch_assoc($empRecords)) {
	
	$data[] = array(
    		"clientName"	=>$row['clientName'],
    		"did"			=>$row['did'],
			"purchase_date"	=>$row['purchase_date'],
    		"expiry_date"	=>$row['expiry_date'],
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
