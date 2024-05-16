<?php require_once('connection.php'); 


//date_default_timezone_set('Asia/Kolkata');

if($_SESSION['userroleforpage'] == 1){
$query_client = "select `id`,`name`, `queue_name`, `description`, `maxlen`, `reportholdtime`, `periodic_announce_frequency`, `periodic_announce`, `strategy`, `joinempty`, `leavewhenempty`, `autopause`, `announce_round_seconds`, `retry`, `wrapuptime`, `announce_holdtime`, `announce_position`, `announce_frequency`, `timeout`, `context`, `musicclass`, `autofill`, `ringinuse`, `musiconhold`, `monitor_type`, `monitor_format`, `servicelevel`, `queue_thankyou`, `queue_youarenext`, `queue_thereare`, `queue_callswaiting`, `queue_holdtime`, `queue_minutes`, `queue_seconds`, `queue_lessthan`, `queue_reporthold`, `relative_periodic_announce`, `queue_timeout`, `fail_status`, `fail_dest`, `fail_data`, `status`, `user_id`, `email`, `created_at`, `updated_at`, `domain`, `assigned_user`, `announce`, `eventmemberstatus`, `eventwhencallled`, `memberdelay`, `setinterfacevar`, `timeoutrestart`, `weight`, `clientId`, `play_ivr` from cc_queue_table";
}else{
$query_client = "select `id`,`name`, `queue_name`, `description`, `maxlen`, `reportholdtime`, `periodic_announce_frequency`, `periodic_announce`, `strategy`, `joinempty`, `leavewhenempty`, `autopause`, `announce_round_seconds`, `retry`, `wrapuptime`, `announce_holdtime`, `announce_position`, `announce_frequency`, `timeout`, `context`, `musicclass`, `autofill`, `ringinuse`, `musiconhold`, `monitor_type`, `monitor_format`, `servicelevel`, `queue_thankyou`, `queue_youarenext`, `queue_thereare`, `queue_callswaiting`, `queue_holdtime`, `queue_minutes`, `queue_seconds`, `queue_lessthan`, `queue_reporthold`, `relative_periodic_announce`, `queue_timeout`, `fail_status`, `fail_dest`, `fail_data`, `status`, `user_id`, `email`, `created_at`, `updated_at`, `domain`, `assigned_user`, `announce`, `eventmemberstatus`, `eventwhencallled`, `memberdelay`, `setinterfacevar`, `timeoutrestart`, `weight`, `clientId`, `play_ivr` from cc_queue_table where FIND_IN_SET( '".$_SESSION['login_user_id']."', assigned_user )";	
}

$result = mysqli_query($connection , $query_client);





function seconds2human($ss) {
$s = $ss%60;
$m = floor(($ss%3600)/60);
$h = floor(($ss%86400)/3600);
$d = floor(($ss%2592000)/86400);
$M = floor($ss/2592000);
if($h == 0)
{ $h = ''; }else{ $h = $h.':'; }
return "$h$m:$s";
}

function seconds2human_rohit($ss) {
$s = $ss%60;
$m = floor(($ss%3600)/60);
$h = floor(($ss%86400)/3600);
$d = floor(($ss%2592000)/86400);
$M = floor($ss/2592000);
return "$h$m:$s";
}

?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<!-- 
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1">Queue Summary</h2><?php //print_r($_SESSION); ?>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
<table class="table manage_queue_table">
<thead>
<tr>
<th>Queue</th>
<th>Queue Name</th>
<th>Customer Name</th>
<th>Inbound/Outbound</th>
<th>Paused/Total</th>
<th>Calls Waiting</th>
<th>Total Calls</th>
<th>Abandoned Calls</th>
<th>Last Update Time</th>
</tr>
</thead>
<tbody>
<?php 

while($row = mysqli_fetch_row($result)) {
													
		$query_waiting = "SELECT count(*) as totalwaiting  FROM `cc_live_calls` WHERE `status` = 2 AND `queue_name`=".$row[1]."";
		$result_lives = mysqli_query($connection , $query_waiting);
		while($row_lives = mysqli_fetch_row($result_lives)) {
			$totalwaiting =  $row_lives[0];
		}
		
		$query_inoutbound = "SELECT count(*) as totalinoutbound  FROM `cc_live_calls` WHERE `status` = 3 AND call_status='Outbound(connected)' AND `queue_name`= ".$row[1]."";
		$result_inoutbound = mysqli_query($connection , $query_inoutbound);
		while($row_inoutbound = mysqli_fetch_row($result_inoutbound)) {
			$totalinoutbound =  $row_inoutbound[0];
		}
		
		$query_outinbound = "SELECT count(*) as totalinoutbound  FROM `cc_live_calls` WHERE `status` = 3 AND call_status!='Outbound(connected)' AND `queue_name`= ".$row[1]."";
		$result_outinbound = mysqli_query($connection , $query_outinbound);
		while($row_outinbound = mysqli_fetch_row($result_outinbound)) {
			$totaloutinbound =  $row_outinbound[0];
		}
		
		
		$query_paused = "SELECT count(*) as totalpaused  FROM `cc_queue_member_table` WHERE paused=1 AND `queue_name`= ".$row[1]."";
		$result_paused = mysqli_query($connection , $query_paused);
		while($row_paused = mysqli_fetch_row($result_paused)) {
			$totalpaused =  $row_paused[0];
		}
		
		$query_total = "SELECT count(*) as totalpaused  FROM `cc_queue_member_table` WHERE `queue_name`= ".$row[1]."";
		$result_total_member = mysqli_query($connection , $query_total);
		while($row_mem = mysqli_fetch_row($result_total_member)) {
			$totalmem =  $row_mem[0];
		}
		
		/* For answered and abondon call
		*/
		$startmonth = date('Y-m-01');
		$endmonth = date('Y-m-t h:i:s'); 
		
		//$total_anscall = "select count(id) as totalanscall FROM `cdr` WHERE lastapp='Queue' and dest_name='".$row[1]."' and calldate BETWEEN '".$startmonth."' AND '".$endmonth."'";
		// $total_anscall = "select count(id) as totalanscall FROM `cdr` WHERE lastapp='Queue' and dest_name='".$row[1]."'";
		// $result_total_anscall = mysqli_query($connection , $total_anscall);
		// while($row_totalanscall = mysqli_fetch_row($result_total_anscall)) {
			// $totalans =  $row_totalanscall[0];
		// }
		// $totalans = mysqli_num_rows($result_total_anscall);

		
		//$total_abandoned = "select count(id) as totalanscall FROM `cdr` WHERE lastapp='Queue' and disposition != 'ANSWERED' and dest_name='".$row[1]."' and calldate BETWEEN '".$startmonth."' AND '".$endmonth."'";
		// $total_abandoned = "select count(id) as totalanscall FROM `cdr` WHERE lastapp='Queue' and disposition != 'ANSWERED' and dest_name='".$row[1]."'";
		// $result_total_abandoned = mysqli_query($connection , $total_abandoned);
		// while($row_totalabandoned = mysqli_fetch_row($result_total_abandoned)) {
			// $totalabandoned =  $row_totalabandoned[0];
		// }
		 // $totalabandoned = mysqli_num_rows($result_total_abandoned);
		
?> 

<tr class="spacer"></tr>
<tr class="tr-shadow">

												<tr>
                                                    <td><?php echo $row[1]; ?></td>
                                                    <td><?php echo $row[2]; ?></td>
                                                    <td>Admin</td>
                                                    <td><?php echo $totaloutinbound.'/'.$totalinoutbound; ?></td>
                                                    <td><?php echo $totalpaused.'/'.$totalmem; ?></td>
                                                    <td><?php echo $totalwaiting; ?></td>
                                                    <td><?php echo '--'; ?></td>
                                                    <td><?php echo '--'; ?></td>
                                                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                                </tr>
												<?php } ?>
                                            </tbody>
                                        </table>

</div>
</div>
</div> -->

<div class="row">
<div class="col-md-12">

<div class="overview-wrap">
<h2 class="title-1">Waiting Status</h2>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title"></h4>
<table class="table manage_queue_table">
<thead>
<tr>
<th>CLID</th>
<th>Destination</th>
<th>Duration</th>
<th>TFN</th>
<th>Customer</th>
<th>Action</th>
</tr>
</thead>
<tbody >

<?php 

	
	$modified_wait     =  date('Y-m-d H:i:s');
	
	
		$queue_res = mysqli_query($connection , $query_client);
		$array_result = array();
    	$sizeofvalue = sizeof($queue_res);
		foreach($queue_res as $transfer_record)
         {
          $destination   =  $transfer_record['name'];
		  array_push($array_result,$destination); 
		  } 
		$resultings =  $array_result;
	$queue_id = implode(",",$resultings);
	
	if($_SESSION['userroleforpage'] == 1){	
	$query_waiting_call = "select * from cc_live_calls where status=2";
	}else{
	$query_waiting_call = "select * from cc_live_calls where status=2 and queue_name in (".$queue_id.")";	
	}
	$result_waiting = mysqli_query($connection , $query_waiting_call);
	while($row_wait = mysqli_fetch_array($result_waiting)) {
		
		$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['created']);
	
	$custnames = "select firstname from cc_card where id='".$row_wait['user_id']."'";
	$resultnamess = mysqli_query($connection,$custnames);
	while($row_name = mysqli_fetch_array($resultnamess)) {
		
		$firstnamec = $row_name['firstname'];
	}
	
	?>
	<tr style="background-color:rgba(255, 225, 10, 0.3);" >
		<td><?php echo $row_wait['caller_number']; ?></td>
		<td><?php echo $row_wait['queue_name']; ?></td>
		<td><?php echo seconds2human($timeduration_wait); ?></td>
		<td><?php echo $row_wait['source_number']; ?></td>
		<td><?php echo $firstnamec; ?></td>
<td><a href="waithangupcall.php?channelid=<?php echo $row_wait['call_id']; ?>">Hangup<i class="fa fa-close icon-md icon-info animated"></i></a></td>
	</tr>
	<?php }  ?>

</tbody>
</table>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">

<div class="overview-wrap">
<h2 class="title-1">Agent Status</h2>
</div>
<?php 
if($_SESSION['userroleforpage'] == 1){							
$query_client = "select `id`,`name`, `queue_name`, `description`, `maxlen`, `reportholdtime`, `periodic_announce_frequency`, `periodic_announce`, `strategy`, `joinempty`, `leavewhenempty`, `autopause`, `announce_round_seconds`, `retry`, `wrapuptime`, `announce_holdtime`, `announce_position`, `announce_frequency`, `timeout`, `context`, `musicclass`, `autofill`, `ringinuse`, `musiconhold`, `monitor_type`, `monitor_format`, `servicelevel`, `queue_thankyou`, `queue_youarenext`, `queue_thereare`, `queue_callswaiting`, `queue_holdtime`, `queue_minutes`, `queue_seconds`, `queue_lessthan`, `queue_reporthold`, `relative_periodic_announce`, `queue_timeout`, `fail_status`, `fail_dest`, `fail_data`, `status`, `user_id`, `email`, `created_at`, `updated_at`, `domain`, `assigned_user`, `announce`, `eventmemberstatus`, `eventwhencallled`, `memberdelay`, `setinterfacevar`, `timeoutrestart`, `weight`, `clientId`, `play_ivr` from cc_queue_table";
}else{
$query_client = "select `id`,`name`, `queue_name`, `description`, `maxlen`, `reportholdtime`, `periodic_announce_frequency`, `periodic_announce`, `strategy`, `joinempty`, `leavewhenempty`, `autopause`, `announce_round_seconds`, `retry`, `wrapuptime`, `announce_holdtime`, `announce_position`, `announce_frequency`, `timeout`, `context`, `musicclass`, `autofill`, `ringinuse`, `musiconhold`, `monitor_type`, `monitor_format`, `servicelevel`, `queue_thankyou`, `queue_youarenext`, `queue_thereare`, `queue_callswaiting`, `queue_holdtime`, `queue_minutes`, `queue_seconds`, `queue_lessthan`, `queue_reporthold`, `relative_periodic_announce`, `queue_timeout`, `fail_status`, `fail_dest`, `fail_data`, `status`, `user_id`, `email`, `created_at`, `updated_at`, `domain`, `assigned_user`, `announce`, `eventmemberstatus`, `eventwhencallled`, `memberdelay`, `setinterfacevar`, `timeoutrestart`, `weight`, `clientId`, `play_ivr` from cc_queue_table where FIND_IN_SET( '".$_SESSION['login_user_id']."', assigned_user )";	
}
$result = mysqli_query($connection , $query_client);
while($row_connected = mysqli_fetch_array($result)) {
?>


<div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">

<div class="row">
<div class="col-md-12">
<div class="">   
   <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> <?php echo $row_connected['queue_name']; ?></h4>
</div>
</div>
</div>

<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>
<?php 
$query_client_one = "SELECT qm.uniqueid as qid, qt.queue_name AS queuename, qt.name AS queue, qm.membername AS ext, csb.agent_name AS agentname, cls.modified AS modified, cls.created AS created, cls.caller_number AS callernumber, cls.source_number AS source_number, cls.call_status AS callstatus, cls.status AS
status , qm.paused AS paused
FROM cc_queue_table qt
LEFT JOIN cc_queue_member_table qm ON qt.name = qm.queue_name
LEFT JOIN cc_sip_buddies csb ON csb.name = qm.membername
LEFT JOIN cc_live_calls cls ON cls.agent_number = csb.name
WHERE qt.name='".$row_connected['name']."' AND qm.membername !=''";
												$result_one = mysqli_query($connection , $query_client_one);
												
												
												while($row_wait = mysqli_fetch_array($result_one)) {
												$timeduration_conn_call = strtotime($row_wait['modified']) - strtotime($row_wait['created']);	
												// if($timeduration_conn_call >0){
													// $timeduration_conn_call = seconds2human($timeduration_conn_call);
												// }else{
													// $timeduration_conn_call = '';
												// }
												
												if($row_wait['modified'] >0){
												$modified_wait     =  date('Y-m-d H:i:s');
													$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['modified']);
													$timeduration_conn_call = seconds2human($timeduration_wait);
												}else{
													
													$timeduration_conn_call = '';
												}
												
												?>
												<tr <?php if($row_wait['status'] == '3') { echo 'style="background-color:rgba(0, 255, 0, 0.3);"'; }else { echo ''; } ?>>
                                                    <td><?php echo $row_wait['queue'] .' / '. $row_wait['queuename']; ?></td>
                                                    <td><?php echo $row_wait['agentname']; ?></td>
                                                    <td><?php echo $row_wait['ext']; ?></td>
													<td><?php echo $timeduration_conn_call; ?></td>
													<td><?php echo $row_wait['source_number']; ?></td>
													<td><?php echo $row_wait['callernumber']; ?></td>
													<td><?php echo $row_wait['callstatus']; ?></td>
													
										<td>
<?php if($row_wait['paused']==0) { ?>
<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill" style="margin-left: 0px;padding-right: 0px;">

<input type="checkbox" class="switch-input" value="0<?php echo $row_wait['qid']; ?>" name="agentPause" checked data-queuext="">
<?php //if($row_wait['paused']==0) { echo 'checked=""'; } else { echo ''; } ?>

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
<?php } else { ?>
<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill"style="margin-left: 0px;padding-right: 0px;">

<input type="checkbox" class="switch-input" value="1<?php echo $row_wait['qid']; ?>" name="agentPause" data-queuext="">
<?php //if($row_wait['paused']==0) { echo 'checked=""'; } else { echo ''; } ?>

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>

<?php } ?>
</td>

</tr>
<?php } ?>

</tbody>

</table>
</div>
</div></div>
<?php } ?>


</div>
</div>
</div>




<script>  
 $(document).ready(function(){  
      $('input[type="checkbox"]').click(function(){  
           var agentPause = $(this).val();
		   
           $.ajax({  
                url:"biglives_update.php",  
                method:"POST",  
                data:{agentPause:agentPause},  
                success:function(data){  
                     $('#result').html(data);  
					 //alert("Hey, " + agentPause + "");
                }  
           });  
      });  
 });  
 </script>  
