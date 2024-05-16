<?php 
include 'connection.php';

$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (template_id like '%".$searchValue."%' or 
        template_name like '%".$searchValue."%' or 
        template_contents like '%".$searchValue."%' ) ";
}

$queuenamesidss = '';
## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from cc_conf_templates ");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel1 = "SELECT count(*) as allcount FROM cc_conf_templates WHERE 1".$searchQuery." AND template_id='WEBRTC'";
$selll = mysqli_query($con,$sel1);
$recordss = mysqli_fetch_assoc($selll);
$totalRecordwithFilter = $recordss['allcount'];

## Fetch records
//$empQuery = "select cdid.did as did, cdid.carieer as carieer, cdid.didtype as didtype, cdid.call_destination as call_destination,cdid.status as status,cdid.call_screening_action as call_screening_action from cc_did cdid WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empQuery = "SELECT template_id, template_name,template_contents FROM cc_conf_templates WHERE 1".$searchQuery." AND template_id='WEBRTC' order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

$empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
    		//"serial"=>$i,
    		"template_id"=>$row['template_id'],
    		"template_name"=>$row['template_name'],
    		"template_contents"=>$row['template_contents'],
    		"action"=>'<div class="table-data-feature">
<a href="webrtc_template_edit.php?id='.$row['template_id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="javascript:void(0)" onclick="return ClientdatadeleteContent('.$row['template_id'].');" type="button" >
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

?>