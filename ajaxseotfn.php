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
	$searchQuery = " and (tfn.tfn like '%".$searchValue."%' or 
		seomem.member_name like '%".$searchValue."%' or
		seoteam.member_name like '%".$searchValue."%' or
		tfn.queue like '%".$searchValue."%' ) ";
}
// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
$sel = mysqli_query($con,"SELECT count(tfn.id) as allcount FROM seo_tfns tfn LEFT JOIN seo_members seomem ON tfn.member_id = seomem.id LEFT JOIN seo_members seoteam ON tfn.team_id = seoteam.id");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"SELECT count(tfn.id) as allcount FROM seo_tfns tfn LEFT JOIN seo_members seomem ON tfn.member_id = seomem.id LEFT JOIN seo_members seoteam ON tfn.team_id = seoteam.id WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
// $empQuery = "SELECT id,name,email,ext,instantCallMail,queue, IF(status =1, 'Active', 'Deactive' ) AS status from AgentInfo WHERE 1 ".$searchQuery." order by id ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empQuery = "SELECT tfn.id AS id, tfn.queue AS queue, tfn.tfn AS tfn, tfn.status AS status , seomem.member_name AS membername, seoteam.member_name AS teamname FROM seo_tfns tfn LEFT JOIN seo_members seomem ON tfn.member_id = seomem.id LEFT JOIN seo_members seoteam ON tfn.team_id = seoteam.id WHERE 1 ".$searchQuery." order by tfn.id ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
   
   if($row['status'] == 1) { $row['status'] = '<span class="status--process" >Active</span>'; } else { $row['status'] = '<span class="inactive_color">Inactive</span>'; }
   
   $data[] = array(
    		"serial"=>$i,
    		"tfn"=>$row['tfn'],
    		"queue"=>$row['queue'],
    		"membername"=>$row['membername'],
    		"teamname"=>$row['teamname'], 
    		"status"=>$row['status'],
    		
    		   //'<span class="'.if($row['status'] == 'Active' ) { echo "status--process"; } .'">Active</span>',
    		"action"=>'<div class="table-data-feature">
<a href="seotfnedit.php?id='.$row['id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-eye"></i>
</button></a>
<a href="seotfnedit.php?id='.$row['id'].'">
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
