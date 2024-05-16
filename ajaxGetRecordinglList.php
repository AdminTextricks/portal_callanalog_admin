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
	$searchQuery = " and (cvm.name like '%".$searchValue."%' or 
	cvm.music_text like '%".$searchValue."%' or 
         cvm.upload_music like '%".$searchValue."%' )";
}

## Total number of records without filtering

if($_SESSION['userroleforpage'] == 1){
	$mailboxnamesid = '';
	$mailboxnamesidss = '';
}else{
	$mailboxnames = "SELECT cvm.id FROM music cvm LEFT JOIN users_login ON cvm.user_id=users_login.id WHERE  cvm.user_id = '".$_SESSION['login_user_id']."'";
	$resultmailbox = mysqli_query($connection, $mailboxnames);

	$array_result = array();
	//$sizeofvalue = sizeof($resultqueue);
	$resultmailbox->num_rows;
	foreach($resultmailbox as $transfer_record)
	{
		$destination  =  $transfer_record['id'];
		array_push($array_result,$destination); 
	} 
	
	$resultings =  $array_result;
	$mail_id = implode(",",$resultings);
	$mailboxnamesid = 'where id in ('.$mail_id.')';
	$mailboxnamesidss = 'cvm.id in ('.$mail_id.')';
	
}

if($_SESSION['userroleforpage'] == 1){
	$sel1 = "select count(*) as allcount from music ".$mailboxnamesid."";
}else{
	$sel1 = "select count(*) as allcount from music ".$mailboxnamesid."";
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
	$sel2 = "select count(*) as allcount from music cvm WHERE 1 ".$mailboxnamesidss." ".$searchQuery;
}else{
	$sel2 = "select count(*) as allcount from music cvm WHERE ".$mailboxnamesidss." ".$searchQuery;
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
	$empQuery = "select cvm.*, users_login.id as userid, users_login.name as userName, users_login.status, users_login.role,  Client.clientName from music cvm left join users_login ON cvm.user_id=users_login.id left join Client ON cvm.clientid=Client.clientId WHERE 1 ".$mailboxnamesidss." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}else{
	$empQuery = "select cvm.*, users_login.id as userid,  users_login.name as userName, users_login.status, users_login.role, Client.clientName from music cvm left join users_login ON cvm.user_id=users_login.id left join Client ON cvm.clientid=Client.clientId WHERE ".$mailboxnamesidss." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;	
}
//echo $empQuery;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	
    $data[] = array(
    		"id"	=>$row['id'],
    		"name"		=>$row['name'],
			"clientName"=>$row['clientName'],
    		"music_text"=>$row['music_text'],
    		"upload_music"	=>'<audio class="audio" controls="" controlslist="download"> <source src="assets/audio/'.$row['upload_music'].'.mp3" width="400" height="100" quality="best"></audio>',
    		"action"=>'<div class="table-data-feature">


<a href="javascript:void(0)" onclick="return deleteRecording('.$row['id'].');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>


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
