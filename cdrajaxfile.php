<?php
include 'connection.php';
// echo '<pre>'; print_r($_POST);
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = 'crg.'.$_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Search 
$searchQuery = " ";
if($searchValue != ''){
	$searchQuery = " and (crg.clid like '%".$searchValue."%' or 
        crg.duration like '%".$searchValue."%' or 
        crg.disposition like '%".$searchValue."%' or 
		crg.accountcode like '%".$searchValue."%' or 
		crg.DID like '%".$searchValue."%' or
        crg.cost like '%".$searchValue."%' )";
        // Client.clientName like'%".$searchValue."%' ) ";
}
// $query_queue = "select crg.ringing as ringing,crg.name as name,Client.clientName as clientName, crg.strategy as strategy, crg.musicclass as musicclass , crg.status as status from cc_ring_group crg left join Client ON crg.clientid=Client.clientId";
// $result = mysqli_query($connection,$query_queue);

## Total number of records without filtering

if($_SESSION['userroleforpage'] == 1){
	$queuenamesid = '';
	$queuenamesidss = '';
}else{
	$queuenames = "SELECT crg.accountcode AS accountcode FROM cc_inbound_call crg
	LEFT JOIN cc_card ON crg.accountcode=cc_card.username
	WHERE cc_card.username = '".$_SESSION['login_usernames']."'";
	$resultqueue = mysqli_query($connection,$queuenames);

	// while($rowsds = mysqli_fetch_array($resultqueue))
	// {
		// $queuenamesid = 'where name ='.$rowsds['name'];
		// $queuenamesidss = 'crg.name ='.$rowsds['name'];
	// }

		$array_result = array();
    	$sizeofvalue = sizeof($resultqueue);
		$resultqueue->num_rows;
		foreach($resultqueue as $transfer_record)
        {
          $destination  =  $transfer_record['accountcode'];
		  array_push($array_result,$destination); 
		} 
		$resultings =  $array_result;
	$queue_id = implode(",",$resultings);
	$queuenamesid = 'where accountcode in ('.$queue_id.')';
	$queuenamesidss = 'crg.accountcode in ('.$queue_id.')';
    
	
}

if($_SESSION['userroleforpage'] == 1){
$sel1 = "select count(*) as allcount from cc_inbound_call ".$queuenamesid."";
}else{
$sel1 = "select count(*) as allcount from cc_inbound_call ".$queuenamesid."";
}
$sel = mysqli_query($con,$sel1);

if(mysqli_num_rows($sel) > 0 ){
	$records = mysqli_fetch_assoc($sel);
    // echo "<pre>"; print_r($records);die;
	$totalRecords = $records['allcount'];
}else{
	$totalRecords = 1;
}

## Total number of records with filtering
if($_SESSION['userroleforpage'] == 1){
    $sel2 = "select count(*) as allcount from cc_inbound_call crg WHERE 1 ".$queuenamesidss." ".$searchQuery;
    }else{
    $sel2 = "select count(*) as allcount from cc_inbound_call crg WHERE ".$queuenamesidss." ".$searchQuery;
    }
    $sel2 = mysqli_query($con,$sel2);
    if(mysqli_num_rows($sel2) > 0 ){
    $records = mysqli_fetch_assoc($sel2);
    $totalRecordwithFilter = $records['allcount'];
    }else{
        $totalRecordwithFilter = 1;
    }
    if($_SESSION['userroleforpage'] == 1){
        $empQuery = "select crg.*, cc_card.username as username, cc_card.uipass, cc_card.email from cc_inbound_call crg left join cc_card ON crg.accountcode=cc_card.username WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;	
        }else{
        $empQuery = "select crg.*, cc_card.username as username from cc_inbound_call crg inner join cc_card ON crg.accountcode=cc_card.username WHERE cc_card.username='".$_SESSION['login_usernames']."' ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;	
        }
        $empRecords = mysqli_query($con, $empQuery);
        $data = array();
        $i = 1;
        while ($row = mysqli_fetch_assoc($empRecords)) {
            $data[] = array(
                    "clid"=>$row['clid'],
                    "duration"=>$row['duration'],
                    "disposition"=>$row['disposition'],
                    "accountcode"=>$row['accountcode'],
                    "DID"=>$row['DID'],
                    "cost"=>$row['cost'],
                    "action"=>'<div class="table-data-feature">
        
        
        <a href="javascript:void(0)" onclick="return CdrInbounddeleteContent('.$row['id'].');" type="button" class=""><button class="item" data-toggle="tooltip" type="button" data-placement="top" title="" data-original-title="delete"><i class="fa fa-trash-o"></i></button></a>
        </div>'
    );
    $i++;	
}
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
