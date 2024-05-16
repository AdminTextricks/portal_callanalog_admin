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
	$searchQuery = " and (did like '%".$searchValue."%' or 
        didtype like '%".$searchValue."%' or 
        call_destination like '%".$searchValue."%'
		) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
$sel = mysqli_query($con,"select count(distinct call_destination) as allcount from cc_did");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel1 = "SELECT count(distinct call_destination) as allcount
FROM cc_did WHERE 1 ".$searchQuery;
$selll = mysqli_query($con,$sel1);
$recordss = mysqli_fetch_assoc($selll);
$totalRecordwithFilter = $recordss['allcount'];

## Fetch records
//$empQuery = "select cdid.did as did, cdid.carieer as carieer, cdid.didtype as didtype, cdid.call_destination as call_destination,cdid.status as status,cdid.call_screening_action as call_screening_action from cc_did cdid WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empQuery = "SELECT distinct call_destination,didtype FROM cc_did WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	
	
			$queueassign = "select did from cc_did where call_destination = '".$row['call_destination']."' ";
   $queue_res = mysqli_query($con , $queueassign);
   $array_result = array();
    	$sizeofvalue = sizeof($queue_res);
		foreach($queue_res as $transfer_record)
         {
          $destination   =  $transfer_record['did'];
          array_push($array_result,$destination); 
		  } 
		$resultings =  $array_result;
	$queue_id = implode("<br>",$resultings);
	
    $data[] = array(
			"id"=>$i,
			"did"=>$queue_id,
    		"didtype"=>$row['didtype'],
    		"call_destination"=>$row['call_destination'],
    		"action"=>'<div class="table-data-feature">
<a href="inboundgroup_edit.php?destid='.$row['call_destination'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
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
