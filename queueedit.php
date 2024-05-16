<?php require_once('header.php'); 

// $query_client = "select * from Client";
// $result_client = mysqli_query($connection , $query_client);

// $query_user = "select * from users_login";
// $result_user_login = mysqli_query($connection , $query_user);

// if(isset($_POST['submit']))
// {
		// if(isset($_POST['selectedUser'])){
		// $selectedUser = $_POST['selectedUser'];
		// $selectedUser = implode(",",$selectedUser);		
// }
$created_at = date('Y-m-d h:i:s');
$updated_at = date('Y-m-d h:i:s');
$message = '';
$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection , $query_client);

$select_queue = "select * from cc_queue_table where id='".$_GET['id']."'";

$result_queue = mysqli_query($connection, $select_queue);
while($row_select = mysqli_fetch_array($result_queue))
{
	$clientIds = $row_select['clientId'];
	$assigned_user = $row_select['assigned_user'];
	$queue_number = $row_select['name'];
	$queue_name = $row_select['queue_name'];
	$description = $row_select['description'];
	$strategy = $row_select['strategy'];
	$status = $row_select['status'];
	$timeout = $row_select['timeout'];	
	$musiconhold = $row_select['musiconhold'];	
	$maxlen = $row_select['maxlen'];
	$queuereportholdtime = $row_select['reportholdtime'];
	$periodic_announce_frequency = $row_select['periodic_announce_frequency'];
	$q_periodic_announce = $row_select['periodic_announce'];
	$q_joinempty = $row_select['joinempty'];
	$q_leavewhenempty = $row_select['leavewhenempty'];
	$q_autopause = $row_select['autopause'];
	$q_announce_round_seconds = $row_select['announce_round_seconds'];
	$q_retry = $row_select['retry'];
	$q_wrapuptime = $row_select['wrapuptime'];
	$q_announce_holdtime = $row_select['announce_holdtime'];
	$q_announce_frequency = $row_select['announce_frequency'];
	$q_context = $row_select['context'];
	$q_musicclass = $row_select['musicclass'];
	$q_autofill = $row_select['autofill'];
	$q_monitor_type = $row_select['monitor_type'];
	$q_ringinuse = $row_select['ringinuse'];
	$q_monitor_format = $row_select['monitor_format'];
	$q_servicelevel = $row_select['servicelevel'];
	$q_queue_thankyou = $row_select['queue_thankyou'];
	$q_queue_youarenext = $row_select['queue_youarenext'];
	$q_queue_thereare = $row_select['queue_thereare'];
	$q_queue_callswaiting = $row_select['queue_callswaiting'];
	$q_queue_holdtime = $row_select['queue_holdtime'];
	$q_queue_minutes = $row_select['queue_minutes'];
	$q_queue_seconds = $row_select['queue_seconds'];
	$q_queue_lessthan = $row_select['queue_lessthan'];
	$q_queue_reporthold = $row_select['queue_reporthold'];
	$queue_timeout = $row_select['queue_timeout'];
	$q_relative_periodic_announce = $row_select['relative_periodic_announce'];
	$ivr = $row_select['play_ivr'];
	
}

if(isset($_POST['submit']))
{

	if(isset($_POST['selectedUser'])){
		$selectedUser = $_POST['selectedUser'];	
	}
	if($assigned_user !== $selectedUser){
		$sql = "delete from cc_queue_member_table where queue_id = '".$_GET['id']."'";
		mysqli_query($connection, $sql); 
	}

	$created_at = date('Y-m-d h:i:s');
	$updated_at = date('Y-m-d h:i:s');

	$query_update = "update cc_queue_table set clientId='".$_POST['clientId']."',assigned_user='".$selectedUser."',queue_name='".$_POST['queueName']."',
	description='".$_POST['description']."',strategy='".$_POST['stratergy']."',status='".$_POST['status']."',
	timeout='".$_POST['ringtimeout']."',musiconhold='".$_POST['queue_musiconhold']."',maxlen='".$_POST['queuemaxlen']."',
	reportholdtime='".$_POST['_queuereportholdtime']."',periodic_announce_frequency='".$_POST['q_periodic_announce_frequency']."',
	periodic_announce='".$_POST['q_periodic_announce']."',joinempty='".$_POST['_q_joinempty']."',
	leavewhenempty='".$_POST['_q_leavewhenempty']."',autopause='".$_POST['_q_autopause']."',announce_round_seconds='".$_POST['q_announce_round_seconds']."',
	retry='".$_POST['q_retry']."',wrapuptime='".$_POST['q_wrapuptime']."',announce_holdtime='".$_POST['_q_announce_holdtime']."',
	announce_frequency='".$_POST['q_announce_frequency']."',context='".$_POST['q_context']."',musicclass='".$_POST['q_musicclass']."',
	autofill='".$_POST['q_autofill']."',ringinuse='".$_POST['_q_ringinuse']."',monitor_type='".$_POST['q_monitor_type']."',servicelevel='".$_POST['q_servicelevel']."',
	queue_thankyou='".$_POST['q_queue_thankyou']."',queue_youarenext='".$_POST['q_queue_youarenext']."',
	queue_thereare='".$_POST['q_queue_thereare']."',queue_callswaiting='".$_POST['q_queue_callswaiting']."',
	queue_holdtime='".$_POST['q_queue_holdtime']."',queue_minutes='".$_POST['q_queue_minutes']."',queue_seconds='".$_POST['q_queue_seconds']."',
	queue_lessthan='".$_POST['q_queue_lessthan']."',queue_reporthold='".$_POST['q_queue_reporthold']."',queue_timeout='".$_POST['queue_timeout']."',
	relative_periodic_announce='".$_POST['q_relative_periodic_announce']."',play_ivr='".$_POST['ivr']."' where name='".$_POST['queueNum']."'";
	
	if(mysqli_query($con , $query_update))
	{
		$activity_type = 'Queue Update';
		if($_SESSION['userroleforpage']=='1'){
			$msg = 'Queue No: '.$_POST['queueNum'].' '.'Queue Update Succesfully! By Admin';
		}else{
			$msg = 'Queue No: '.$_POST['queueNum'].' '.'Queue Update Succesfully! By User';
		}
		user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
		$_SESSION['msg'] = 'Queue has been Updated Succesfully!';
		echo '<script>window.location.href="queue.php"</script>';
	}

}


$query_user = "select * from users_login where clientId='".$clientIds."'";
$result_user_login = mysqli_query($connection , $query_user);

if($_SESSION['userroleforpage'] == 2 && $assigned_user !== $_SESSION['login_user_id']){ ?>
	<script>
    	window.location='access_denied.php';    
	</script>
<?php }

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"><?php //echo $query_client; ?> Queue Information<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
						<div class="table-data__tool-right">
							<a href="queue.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
								<i class="fa fa-eye" aria-hidden="true"></i> Queue</button>
							</a>
						</div>
					</div>
				</div>
			</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="queueForm" action="" method="post">			
				<?php if($_SESSION['userroleforpage'] == 1){ ?>
				<div class="row form-group">
					<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Client Name</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="clientId" data-show-subtext="false" data-live-search="true" name="clientId" class="form-control selectpicker">
							<option value="0">Select</option>
							<?php while($row = mysqli_fetch_array($result_client)){ ?>
								<option <?php if( $clientIds == $row['clientId'] ){ echo 'selected="selected"'; } ?> value="<?php echo $row['clientId']; ?>"><?php echo $row['clientName'].'/'.$row['clientEmail'];; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class="form-control-label">Select User*</label>
					</div>
					<div class="col-12 col-md-8">
						<!--<div>Use Ctrl Key to Select Multiple Users.</div>--> 
						<select id="selectedUser" name="selectedUser"  class="form-control" >
							<?php while($row_user = mysqli_fetch_array($result_user_login)){ ?>
								<option <?php if( $clientIds == $row_user['clientId'] ){ echo 'selected="selected"'; } ?> value="<?php echo $row_user['id']; ?>"><?php echo $row_user['name']; ?></option>
							<?php } ?>
						</select><input type="hidden" name="_selectedUser" value="1"/>
					</div>
				</div>
				<?php } else { ?>
					<input type="hidden"  class="form-control" id="clientId" name="clientId" value="<?php echo $clientIds; ?>"  />
					<input id="selectedUser"  class="form-control" name="selectedUser" value="<?php echo $assigned_user; ?>" type="hidden" />
			<?php } ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Extension</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="queueNum" name="queueNum" placeholder="3330" readonly="readonly" class="form-control" type="text" value="<?php echo $queue_number; ?>"/>
					</div>
				</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Name*</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="queueName" name="queueName" placeholder="way2career sales" class="form-control" type="text" value="<?php echo $queue_name; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Description*</label>
				</div>
					<div class="col-12 col-md-8">
					<input id="description" name="description" placeholder="sales" class="form-control" type="text" value="<?php echo $description; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="selectSm" class=" form-control-label">Strategy</label>
				</div>
				<div class="col-12 col-md-8">
					<select id="stratergy" name="stratergy" class="form-control-sm form-control">
					<option value="0">Select</option>
					<option <?php if($strategy == 'rrmemory') { echo 'selected="selected"'; } ?> value="rrmemory">rrmemory</option>
					<option <?php if($strategy == 'ringall') { echo 'selected="selected"'; } ?> value="ringall">ringall</option>
					<option <?php if($strategy == 'leastrecent') { echo 'selected="selected"'; } ?> value="leastrecent">leastrecent</option>
					<option <?php if($strategy == 'fewestcalls') { echo 'selected="selected"'; } ?> value="fewestcalls">fewestcalls</option>
					<option <?php if($strategy == 'random') { echo 'selected="selected"'; } ?> value="random">random</option>
					<option <?php if($strategy == 'linear') { echo 'selected="selected"'; } ?> value="linear">linear</option>
					<option <?php if($strategy == 'wrandom') { echo 'selected="selected"'; } ?> value="wrandom">wrandom</option>

					</select>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="selectSm" class=" form-control-label">Queue Status*</label>
				</div>
				<div class="col-12 col-md-8">
					<select id="status" name="status" class="form-control-sm form-control">
					<option value="0">Select</option>
					<option <?php if($status == 'Active') { echo 'selected="selected"'; } ?> value="Active">Active</option>
					<option <?php if($status == 'Inactive') { echo 'selected="selected"'; } ?> value="Inactive">Inactive</option>
					</select>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Ring Timeout**</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="ringtimeout" name="ringtimeout" placeholder="10" value="<?php echo $timeout; ?>" class="form-control" type="text" value="0"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Musiconhold</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="queue_musiconhold" name="queue_musiconhold" placeholder="bigpbx" value="<?php echo $musiconhold; ?>" class="form-control" type="text" value=""/>
				</div>
			</div>
            
			
			<div class="advance_opt" style="cursor:pointer; display:none;">
                <h4 class="advance_opt_toggle">Advanced Options</h4>

                <div class="advance_opt_form" style="display:none;">
                    

                <div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Queue Max Length</label>
					</div>
				<div class="col-12 col-md-8">
					<input id="queuemaxlen" name="queuemaxlen" placeholder="3330" value="<?php echo $maxlen; ?>" class="form-control" type="text" value="0"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Report Hold Time</label>
				</div>
				<div class="col-12 col-md-8">

					<label class="switch switch-text switch-primary">
						<input id="queuereportholdtime1" name="queuereportholdtime" class="switch-input" type="checkbox" value="<?php echo $queuereportholdtime; ?>"/>
						<input type="hidden" name="_queuereportholdtime" value="no"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>

				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Periodic Announce Frequency</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_periodic_announce_frequency" name="q_periodic_announce_frequency" placeholder="Periodic Announce Frequency" class="form-control" type="text" value="<?php echo $periodic_announce_frequency; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Periodic Announce</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_periodic_announce" name="q_periodic_announce" placeholder="Periodic Announce" class="form-control" type="text" value="<?php echo $q_periodic_announce; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Join Empty</label>
				</div>
				<div class="col-12 col-md-8">

				<label class="switch switch-text switch-primary">
					<input id="q_joinempty1" name="q_joinempty" class="switch-input" type="checkbox" value="<?php echo $q_joinempty; ?>"/>
					<input type="hidden" name="_q_joinempty" value="no"/>
					<span data-on="On" data-off="Off" class="switch-label"></span>
					<span class="switch-handle"></span>
				</label>

				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Leave When Empty</label>
				</div>
				<div class="col-12 col-md-8">
					<label class="switch switch-text switch-primary">
						<input id="q_leavewhenempty1" name="q_leavewhenempty" class="switch-input" type="checkbox" value="<?php echo $q_leavewhenempty; ?>"/>
						<input type="hidden" name="_q_leavewhenempty" value="no"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Auto Pause</label>
				</div>
				<div class="col-12 col-md-8">
					<label class="switch switch-text switch-primary">
						<input id="q_autopause1" name="q_autopause" class="switch-input" type="checkbox" value="<?php echo $q_autopause; ?>"/>
						<input type="hidden" name="_q_autopause" value="no"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Announce Round Seconds</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_announce_round_seconds" name="q_announce_round_seconds" placeholder="Announce Round Seconds" class="form-control" type="text" value="<?php echo $q_announce_round_seconds; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Retry</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_retry" name="q_retry" placeholder="Retry" class="form-control" type="text" value="<?php echo $q_retry; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Wrapuptime</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_wrapuptime" name="q_wrapuptime" placeholder="Wrapuptime" class="form-control" type="text" value="<?php echo $q_wrapuptime; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Announce Holdtime</label>
				</div>
				<div class="col-12 col-md-8">
					<label class="switch switch-text switch-primary">
						<input id="q_announce_holdtime1" name="q_announce_holdtime" class="switch-input" type="checkbox" value="<?php echo $q_announce_holdtime; ?>"/>
						<input type="hidden" name="_q_announce_holdtime" value="no"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>
				</div>
			</div>


			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Announce Frequency</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_announce_frequency" name="q_announce_frequency" placeholder="Announce Frequency" class="form-control" type="text" value="<?php echo $q_announce_frequency; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Context</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_context" name="q_context" placeholder="Context" class="form-control" type="text" value="<?php echo $q_context; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Music Class</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_musicclass" name="q_musicclass" placeholder="Music Class" value="default" class="form-control" type="text" value="<?php echo $q_musicclass; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Auto fill</label>
				</div>
				<div class="col-12 col-md-8">

					<label class="switch switch-text switch-primary">
						<input id="q_autofill1" name="q_autofill" checked="true" class="switch-input" type="checkbox" value="<?php echo $q_autofill; ?>"/>
						<input type="hidden" name="_q_autofill" value="no"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>

				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Ring in use</label>
				</div>
				<div class="col-12 col-md-8">
					<label class="switch switch-text switch-primary">
						<input id="q_ringinuse1" name="q_ringinuse" class="switch-input" type="checkbox" value="<?php echo $q_ringinuse; ?>"/>
						<input type="hidden" name="_q_ringinuse" value="no"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Monitor Type</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_monitor_type" name="q_monitor_type" placeholder="Monitor Type" class="form-control" type="text" value="<?php echo $q_monitor_type; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Monitor Format</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_monitor_format" name="q_monitor_format" placeholder="Music Class" class="form-control" disabled="disabled" type="text" value="<?php echo $q_monitor_format; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Service Level</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_servicelevel" name="q_servicelevel" placeholder="Music Class" class="form-control" type="text" value="<?php echo $q_servicelevel; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Thankyou</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_thankyou" name="q_queue_thankyou" placeholder="Queue Thankyou" class="form-control" type="text" value="<?php echo $q_queue_thankyou; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Youarenext</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_youarenext" name="q_queue_youarenext" placeholder="Queue Youarenext" class="form-control" type="text" value="<?php echo $q_queue_youarenext; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class="form-control-label">Queue Thereare</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_thereare" name="q_queue_thereare" placeholder="Queue Thereare" class="form-control" type="text" value="<?php echo $q_queue_thereare; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Callswaiting</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_callswaiting" name="q_queue_callswaiting" placeholder="Queue Callswaiting" class="form-control" type="text" value="<?php echo $q_queue_callswaiting; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Holdtime</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_holdtime" name="q_queue_holdtime" placeholder="Queue Holdtime" class="form-control" type="text" value="<?php echo $q_queue_holdtime; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Minutes</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_minutes" name="q_queue_minutes" placeholder="Queue Minutes" class="form-control" type="text" value="<?php echo $q_queue_minutes; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Seconds</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_seconds" name="q_queue_seconds" placeholder="Queue Seconds" class="form-control" type="text" value="<?php echo $q_queue_seconds; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Lessthan</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_lessthan" name="q_queue_lessthan" placeholder="Queue Lessthan" class="form-control" type="text" value="<?php echo $q_queue_lessthan; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue Reporthold</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="q_queue_reporthold" name="q_queue_reporthold" placeholder="Queue Reporthold" class="form-control" type="text" value="<?php echo $q_queue_reporthold; ?>"/>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Queue timeout</label>
				</div>
				<div class="col-12 col-md-8">
					<input id="queue_timeout" name="queue_timeout" placeholder="Queue timeout" value="30" class="form-control" type="text" value="<?php echo $queue_timeout; ?>"/>
				</div>
			</div>


			<div class="row form-group">
				<div class="col col-md-4">
					<label for="text-input" class=" form-control-label">Relative Periodic Announce</label>
				</div>
				<div class="col-12 col-md-8">
					<label class="switch switch-text switch-primary">
						<input id="q_relative_periodic_announce1" name="q_relative_periodic_announce" checked="true" class="switch-input" type="checkbox" value="<?php echo $q_relative_periodic_announce; ?>"/>
						<input type="hidden" name="_q_relative_periodic_announce" value="on"/>
						<span data-on="On" data-off="Off" class="switch-label"></span>
						<span class="switch-handle"></span>
					</label>
				</div>
			</div>

			<div class="row form-group">
				<div class="col col-md-4">
					<label for="selectSm" class=" form-control-label">IVR</label>
				</div>
				<div class="col-12 col-md-8">
					<select id="ivr" name="ivr" class="form-control">
						<option value="0" selected="selected">------SELECT------</option>
					
					
					</select>
				</div>
			</div>
        </div>
        </div>
			
			<div class="form-group pull-right">
				<button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			<p style="color:blue;"><?php echo $message; ?></p>
		</form>
			
        </div>
    </div>
    </div>

</div>
</div>
</div>
</div>

<script>
$( "select[name='clientId']" ).change(function () {
    var clientsID = $(this).val();


    if(clientsID) {


        $.ajax({
            url: "ajaxpro.php",
            dataType: 'Json',
            data: {'id':clientsID},
            success: function(data) {
                $('select[name="selectedUser"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });


    }else{
        $('select[name="selectedUser"]');
		$.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
    }
});
</script>

<?php require_once('footer.php'); ?> 
 
