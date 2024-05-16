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

// ## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (carrier_id like '%".$searchValue."%' or 
    carrier_name like '%".$searchValue."%' or 
    carrier_description like '%".$searchValue."%' or 
    registration_string like '%".$searchValue."%' or 
    account_entry like '%".$searchValue."%' or
    protocall like '%".$searchValue."%' or
    server_ip like '%".$searchValue."%' or
    active like '%".$searchValue."%') ";
}


## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from server_carriers");
// echo"<pre>";print_r($sel);exit;
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from server_carriers WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

$empQuery = "SELECT * FROM `server_carriers` WHERE 1 ".$searchQuery." order by carrier_id ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {

   $data[] = array(
			
    		"serial"=>$i,
    		"carrier_id"=>$row['carrier_id'],
    		"carrier_name"=>$row['carrier_name'],
    		"registration_string"=>$row['registration_string'],
    		"protocall"=>$row['protocall'],
    		"server_ip"=>$row['server_ip'],
    		"action"=>'<div class="table-data-feature">

<a href="inboundrouteedit.php?id='.$row['id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="javascript:void(0)" onclick="return InboundroutedeleteContent('.$row['id'].');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
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
