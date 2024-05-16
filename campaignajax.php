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
	$searchQuery = " and (cqt.CampName like '%".$searchValue."%' or 
        cqt.CampType like '%".$searchValue."%' or
        disposition.Disposition like '%".$searchValue."%' 
	)";
        // Client.clientName like'%".$searchValue."%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
/*
if($_SESSION['userroleforpage'] == 1){
	$queuenamesid = '';
	$queuenamesidss = '';
}else{
	$queuenames = "SELECT cqt.name AS name FROM cc_queue_table cqt
LEFT JOIN Client ON cqt.clientid = Client.clientId
WHERE Client.clientId = '".$_SESSION['userroleforclientid']."'";
$resultqueue = mysqli_query($connection,$queuenames);
// while($rowsds = mysqli_fetch_array($resultqueue))
// {
	// $queuenamesid = 'where name ='.$rowsds['name'];
	// $queuenamesidss = 'cqt.name ='.$rowsds['name'];
// }

		$array_result = array();
    	$sizeofvalue = sizeof($resultqueue);
		foreach($resultqueue as $transfer_record)
         {
          $destination   =  $transfer_record['name'];
		  array_push($array_result,$destination); 
		  } 
		$resultings =  $array_result;
	$queue_id = implode(",",$resultings);
	$queuenamesid = 'where name in ('.$queue_id.')';
	$queuenamesidss = 'cqt.name in ('.$queue_id.')';
	
}
*/
if($_SESSION['userroleforpage'] == 1){
$sel1 = "select count(*) as allcount from incamp";
}else{
$sel1 = "select count(*) as allcount from incamp";
}
$sel = mysqli_query($con,$sel1);
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
if($_SESSION['userroleforpage'] == 1){
$sel2 = "select count(*) as allcount from incamp cqt WHERE 1 ".$searchQuery;
}else{
$sel2 = "select count(*) as allcount from incamp cqt WHERE ".$searchQuery;
}
$sel2 = mysqli_query($con,$sel2);
$records = mysqli_fetch_assoc($sel2);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
if($_SESSION['userroleforpage'] == 1){
$empQuery = "select cqt.CampName as camp_name, cqt.InCampID as id, cqt.CampType as camp_type,cqt.CampStartDate as campdate,disposition.Disposition as disposition from incamp cqt left join disposition ON cqt.DisPlanID=disposition.Code WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

}else{
$empQuery = "select cqt.CampName as camp_name, cqt.InCampID as id, cqt.CampType as camp_type,cqt.CampStartDate as campdate,disposition.Disposition as disposition from incamp cqt left join disposition ON cqt.DisPlanID=disposition.Code WHERE ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;	

}
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) { 
    $data[] = array(
    		"camp_name"=>$row['camp_name'],
    		"camp_type"=>$row['camp_type'],
    		"campdate"=>$row['campdate'],
    		"disposition"=>$row['disposition'],
    		"action"=>'<div class="table-data-feature">
<a href="queueedit.php?id='.$row['id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-eye"></i>
</button></a>
<a href="queueedit.php?id='.$row['id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="queuemanage.php?id='.$row['id'].'">
 <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
<i class="fa fa-users"></i> 
</button></a>
<a href="queuemanage.php?id='.$row['id'].'">
 <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
<i class="fa fa-trash"></i> 
</button></a>
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
