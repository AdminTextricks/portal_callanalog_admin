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
	$searchQuery = " and (trunkcode like '%".$searchValue."%' or 
        removeprefix like '%".$searchValue."%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from cc_trunk");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from cc_trunk WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
//$empQuery = "select cqt.queue_name as queue_name, cqt.id as id,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empQuery = "SELECT id_trunk,trunkcode,trunkprefix,removeprefix FROM `cc_trunk` WHERE 1 ".$searchQuery." order by trunkcode ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	
   $data[] = array(
			
    		"serial"=>$i,
    		"trunkcode"=>$row['trunkcode'],
    		"trunkprefix"=>$row['trunkprefix'],
    		"removeprefix"=>$row['removeprefix'],
    		"action"=>'<div class="table-data-feature">

<a href="outboundedit.php?id='.$row['id_trunk'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="javascript:void(0)" onclick="return OutboundroutedeleteContent('.$row['id_trunk'].');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
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
