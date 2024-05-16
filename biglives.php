<?php require_once('header.php'); 

$query_queue = "select count(*) as totalqueue from cc_queue_table";
$result_queue = mysqli_query($connection , $query_queue);
while($row_que = mysqli_fetch_row($result_queue)) {
	$totalqueue =  $row_que[0];
}

$query_ext = "select count(*) as totalext from cc_sip_buddies";
$result_ext = mysqli_query($connection , $query_ext);
while($row_ext = mysqli_fetch_row($result_ext)) {
	$totalext =  $row_ext[0];
}

$query_inbound = "select count(*) as totalinbound from cc_did";
$result_inbound = mysqli_query($connection , $query_inbound);
while($row_inbound = mysqli_fetch_row($result_inbound)) {
	$totalinbound =  $row_inbound[0];
}
 
$query_outbound = "select count(*) as totaloutbound from cc_trunk";
$result_outbound = mysqli_query($connection , $query_outbound);
while($row_outbound = mysqli_fetch_row($result_outbound)) {
	$totaloutbound =  $row_outbound[0];
}

$query_blacklist = "select count(*) as totalblacklist from cc_blacklist";
$result_blacklist = mysqli_query($connection , $query_blacklist);
while($row_blacklist = mysqli_fetch_row($result_blacklist)) {
	$totalblacklist =  $row_blacklist[0];
}
?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <div id="sample">
			</div>
			
				
<?php require_once('footer.php'); ?>