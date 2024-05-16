<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'cqt.'.$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (cqt.queue_name like '%".$searchValue."%' or 
        cqt.name like '%".$searchValue."%' or 
        cqt.status like '%".$searchValue."%' or 
        cqt.strategy like '%".$searchValue."%' )";
        // Client.clientName like'%".$searchValue."%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering

if($_SESSION['userroleforpage'] == 1){
	$queuenamesid = '';
	$queuenamesidss = '';
}else{
//	$queuenames = "SELECT cqt.name AS name FROM cc_queue_table cqt LEFT JOIN Client ON cqt.clientid = Client.clientId WHERE Client.clientId = '".$_SESSION['userroleforclientid']."'";

	$queuenames = "SELECT cqt.name AS name FROM cc_queue_table cqt WHERE assigned_user = '".$_SESSION['login_user_id']."'";

	// echo $queuenames; exit;

	$resultqueue = mysqli_query($connection,$queuenames);
	// while($rowsds = mysqli_fetch_array($resultqueue))
	// {
		// $queuenamesid = 'where name ='.$rowsds['name'];
		// $queuenamesidss = 'cqt.name ='.$rowsds['name'];
	// }

		$array_result = array();
    	// $sizeofvalue = sizeof($resultqueue);
		foreach($resultqueue as $transfer_record)
         {
          $destination   =  $transfer_record['name'];
		  array_push($array_result,$destination); 
		  } 
		$resultings =  $array_result;
	$queue_id = implode(",",$resultings);
	// echo $queue_id; exit;
	$queuenamesid = 'where name in ('.$queue_id.')';
	$queuenamesidss = 'cqt.name in ('.$queue_id.')';
	
}
if($_SESSION['userroleforpage'] == 1){
$sel1 = "select count(*) as allcount from cc_queue_table ".$queuenamesid."";
}else{
$sel1 = "select count(*) as allcount from cc_queue_table ".$queuenamesid."";
}

// echo $sel1; exit;
$sel = mysqli_query($con,$sel1);
if(mysqli_num_rows($sel) > 0 ){
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];
}else{
	$totalRecords = 1;
}

## Total number of records with filtering
if($_SESSION['userroleforpage'] == 1){
$sel2 = "select count(*) as allcount from cc_queue_table cqt WHERE 1 ".$queuenamesidss." ".$searchQuery;
}else{
$sel2 = "select count(*) as allcount from cc_queue_table cqt WHERE ".$queuenamesidss." ".$searchQuery;
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
$empQuery = "select cqt.assigned_user,users_login.role, cqt.queue_name as queue_name, cqt.id as id,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId left join users_login on cqt.assigned_user = users_login.id WHERE 1 ".$queuenamesidss." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
}else{
$empQuery = "select cqt.assigned_user, cqt.queue_name as queue_name, cqt.id as id,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId left join users_login on cqt.assigned_user = users_login.id WHERE ".$queuenamesidss." ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;	
}


$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	$userType = $user_type_arr[$row['role']];

	/* if(in_array($row['role'], array(3,4))){
		$edit_link = '<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
				<i class="fa fa-ban"></i>
				</button><button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
				<i class="fa fa-ban"></i>
				</button>';
	}else{
		$edit_link = '<a href="queueedit.php?id='.$row['id'].'">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
		<i class="fa fa-pencil-square-o"></i>
		</button></a>
		<a href="queuemanage.php?id='.$row['id'].'&uid='.$row['assigned_user'].'">
		 <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
		<i class="fa fa-users"></i> 
		</button></a>';
	} */

	$edit_link = '<a href="queueedit.php?id='.$row['id'].'">
		<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
		<i class="fa fa-pencil-square-o"></i>
		</button></a>
		<a href="queuemanage.php?id='.$row['id'].'&uid='.$row['assigned_user'].'">
		 <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
		<i class="fa fa-users"></i> 
		</button></a>';

    $data[] = array(
    		"queue_name"=>$row['queue_name'],
			"userType"=>$userType,
    		"name"=>$row['name'],
    		"clientName"=>$row['clientName'],
    		"strategy"=>$row['strategy'],
    		"musicclass"=>$row['musicclass'],
    		"status"=>$row['status'],   //'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
    		"action"=>'<div class="table-data-feature">'.$edit_link.'<a href="javascript:void(0)" onclick="return deleteContent('.$row['id'].');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>

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
