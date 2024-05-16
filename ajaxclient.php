<?php
include 'connection.php';

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con, $_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if ($searchValue != '') {
	$searchQuery = " and (clientName like '%" . $searchValue . "%' or 
        clientEmail like '%" . $searchValue . "%' or 
        clientEmailPass like '%" . $searchValue . "%' or 
        hostName like '%" . $searchValue . "%' or 
        portNumber like '%" . $searchValue . "%' or 
        modifyDate like'%" . $searchValue . "%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
$sel = mysqli_query($con, "select count(*) as allcount from Client");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel1 = "SELECT count(*) as allcount FROM Client WHERE 1 " . $searchQuery;
$selll = mysqli_query($con, $sel1);
$recordss = mysqli_fetch_assoc($selll);
$totalRecordwithFilter = $recordss['allcount'];

## Fetch records
//$empQuery = "select cdid.did as did, cdid.carieer as carieer, cdid.didtype as didtype, cdid.call_destination as call_destination,cdid.status as status,cdid.call_screening_action as call_screening_action from cc_did cdid WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empQuery = "SELECT clientId, clientName,clientEmail,clientEmailPass,hostName,portNumber,modifyDate FROM Client WHERE 1 " . $searchQuery . " order by " . $columnName . " " . $columnSortOrder . " limit " . $row . "," . $rowperpage;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	$data[] = array(
		//"serial"=>$i,
		"clientName" => $row['clientName'],
		"clientEmail" => $row['clientEmail'],
		"clientEmailPass" => $row['clientEmailPass'],
		"hostName" => $row['hostName'],
		"portNumber" => $row['portNumber'],
		"modifyDate" => $row['modifyDate'],
		"action" => '<div class="table-data-feature">
<!--<a href="clientedit.php?id=' . $row['clientId'] . '">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-eye"></i>
</button></a> -->
<a href="clientedit.php?id=' . $row['clientId'] . '">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="javascript:void(0)" onclick="return ClientdatadeleteContent(' . $row['clientId'] . ');" type="button" >
<button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete">
<i class="fa fa-trash-o"></i></button></a>
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