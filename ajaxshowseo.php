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
	$searchQuery = " and (A.member_name like '%".$searchValue."%'  OR
	B.member_name like '%".$searchValue."%'
	) ";
}

## Total number of records without filtering
$selq = "select count(*) as allcount FROM seo_members A, seo_members B WHERE A.id = B.team_id";
$sel = mysqli_query($con,$selq);
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount FROM seo_members A, seo_members B WHERE A.id = B.team_id ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

$empQuery = "SELECT A.id AS id,B.id as ids, A.member_name AS name, B.member_name AS team FROM seo_members A, seo_members B WHERE A.id = B.team_id ".$searchQuery." order by A.id ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
   
   $data[] = array(
    		"serial"=>$i,
			"team"=>$row['team'],
    		"name"=>$row['name'],
    		  "action"=>'<div class="table-data-feature">
<a href="showseoedit.php?id='.$row['ids'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-eye"></i>
</button></a>
<a href="showseoedit.php?id='.$row['ids'].'">
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
