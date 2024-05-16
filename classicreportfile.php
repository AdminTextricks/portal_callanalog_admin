<?php
include 'connection.php';
//print_r($_POST);exit;

if(!isset($_POST['submit'])){
	
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
	$searchQuery = " and (calldate like '%".$searchValue."%' or
        disposition like '%".$searchValue."%' or 
        src like '%".$searchValue."%' or 
        did like '%".$searchValue."%' or 
        dest_name like '%".$searchValue."%' or 
        extension like '%".$searchValue."%' or 
        duration like '%".$searchValue."%' or 
        clid like '%".$searchValue."%' ) ";
}


//$empQuery = "SELECT calldate,disposition,src,did,dest_name,extension,duration,Recordings FROM `cdr` WHERE 1 ".$searchQuery." order by calldate ".$columnSortOrder." limit ".$row.",".$rowperpage;	



// $query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from cdr");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from cdr WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

## Fetch records
//$empQuery = "select cqt.queue_name as queue_name, cqt.id as id,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empQuery = "SELECT calldate,disposition,src,did,dest_name,extension,duration,Recordings FROM `cdr` WHERE 1 ".$searchQuery." order by calldate ".$columnSortOrder." limit ".$row.",".$rowperpage;
//$empQuery = "SELECT * FROM `cdr` WHERE 1 ".$searchQuery." order by calldate ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($connection , $empQuery);

// $empQuery = "SELECT id,caller_id,message,status FROM `cc_blacklist` WHERE 1 ".$searchQuery." order by caller_id ".$columnSortOrder." limit ".$row.",".$rowperpage;
// $empRecords = mysqli_query($con, $empQuery);
$data = array();
$i = 1;
while ($row = mysqli_fetch_assoc($empRecords)) {
	
   $data[] = array(
			
    		"serial"=>$i,
    		"calldate"=>$row['calldate'],
    		"disposition"=>$row['disposition'],
    		//"clid"=>$row['clid'],
    		"src"=>$row['src'],
    		"did"=>$row['did'],
    		"queue"=>$row['dest_name'],
    		"extension"=>$row['extension'],
    		"duration"=>$row['duration'],
    		"Recordings"=>$row['Recordings'],
    		/*"action"=>'<div class="table-data-feature">
<a href="blacklistedit.php?id='.$row['id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<a href="blacklistdelete.php?id='.$row['id'].'">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-trash"></i>
</button></a>
</div>' */

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


}else{
	
	## Read value
$draw = 1;
$row = 1;
$rowperpage = 100; // Rows display per page
// $columnIndex = $_POST['order'][0]['column']; // Column index
// $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = 'DESC'; // asc or desc

	$searchQuery = " and (calldate between '".$_POST['fromDate']."' and '".$_POST['toDate']."' or
        disposition like '%".$_POST['disposition']."%' and
        call_type like '%".$_POST['call_type']."%' and 
        src like '%".$_POST['DNID']."%' and 
        did like '%".$_POST['DID']."%' and 
        dest_name like '%".$_POST['queueName']."%' and 
        extension like '%".$_POST['extension']."%' and 
        duration like '%".$_POST['duration']."%' and 
        clid like '%".$_POST['CLID']."%' ) ";
		
		
		$sel = mysqli_query($con,"select count(*) as allcount from cdr");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel = mysqli_query($con,"select count(*) as allcount from cdr WHERE 1 ".$searchQuery);
$records = mysqli_fetch_assoc($sel);
$totalRecordwithFilter = $records['allcount'];

$empQuery = "SELECT calldate,disposition,src,did,dest_name,extension,duration,Recordings FROM `cdr` WHERE 1 ".$searchQuery." order by calldate ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($connection , $empQuery);

		$data = array();
		$i = 1;
		while ($row = mysqli_fetch_assoc($empRecords)) {
			
		   $data[] = array(
					
					"serial"=>$i,
					"calldate"=>$row['calldate'],
					"disposition"=>'YY'.$row['disposition'],
					//"clid"=>$row['clid'],
					"src"=>$row['src'],
					"did"=>$row['did'],
					"queue"=>$row['dest_name'],
					"extension"=>$row['extension'],
					"duration"=>$row['duration'],
					"Recordings"=>$row['Recordings'],
					
				);
			$i++;	
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordwithFilter,
			"aaData" => $data
		);
		

}

echo json_encode($response);
