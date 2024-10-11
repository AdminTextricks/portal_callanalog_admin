<?php require_once('header.php'); 

$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection , $query_client);
if(isset($_POST['selectedUser'])) { 
	$query_user = "select * from users_login where clientId='".$_POST['clientId']."'";
	$result_user_login = mysqli_query($connection , $query_user);
}else{
	$_POST['clientId'] = '';
}
$message = '';
if(isset($_POST['submit']))
{
	if($_SESSION['userroleforpage'] == '2'){
		$_POST['clientId'] = $_SESSION['userroleforclientid'];
		$_POST['selectedUser'] = $_SESSION['login_user_id'];
	}
	$select_queuematch = "select name from cc_queue_table where name='".$_POST['queueNum']."'";
	$query_card_queuematch = mysqli_query($con, $select_queuematch);
	if(mysqli_num_rows($query_card_queuematch)>0){
		$message = 'Duplicate Queue Extension,Please Generate Again!';
	// if($matchnamequeue == $_POST['queueNum'] OR $matchqueuenamequeue == $_POST['queueName']){
		// $message = 'Duplicate Queue Information,Please Change The Queue and Queue Name';
	}else{
		$selectedUser = '';
		if(isset($_POST['selectedUser'])){
		$selectedUser = $_POST['selectedUser'];		
		//$selectedUser = implode(",",$selectedUser);		
		}

$created_at = date('Y-m-d h:i:s');
$updated_at = date('Y-m-d h:i:s');
if (empty($_POST['queueNum'])) {
    $message="Please Generate Your Queue Extension";
}else{
$q_monitor_format = isset($_POST['q_monitor_format'])?$_POST['q_monitor_format']:"";
$insert_queue = "INSERT INTO cc_queue_table(name, queue_name, description, maxlen, reportholdtime, periodic_announce_frequency, periodic_announce, strategy, joinempty, leavewhenempty, autopause, announce_round_seconds, retry, wrapuptime, announce_holdtime, announce_position, announce_frequency, timeout, context, musicclass, autofill, ringinuse, musiconhold, monitor_type, monitor_format, servicelevel, queue_thankyou, queue_youarenext, queue_thereare, queue_callswaiting, queue_holdtime, queue_minutes, queue_seconds, queue_lessthan, queue_reporthold, relative_periodic_announce, queue_timeout, fail_status, fail_dest, fail_data, status, user_id, email, created_at, updated_at, domain, assigned_user, announce, eventmemberstatus, eventwhencallled, memberdelay, setinterfacevar, timeoutrestart, weight, clientId, play_ivr) VALUES ('".$_POST['queueNum']."','".$_POST['queueName']."','".$_POST['description']."','".$_POST['queuemaxlen']."','".$_POST['_queuereportholdtime']."','".$_POST['q_periodic_announce_frequency']."', '".$_POST['q_periodic_announce']."','".$_POST['stratergy']."','".$_POST['_q_joinempty']."','".$_POST['_q_leavewhenempty']."','".$_POST['_q_autopause']."','".$_POST['q_announce_round_seconds']."','".$_POST['q_retry']."','".$_POST['q_wrapuptime']."', '".$_POST['_q_announce_holdtime']."','','".$_POST['q_announce_frequency']."','".$_POST['ringtimeout']."','".$_POST['q_context']."', '".$_POST['q_musicclass']."','".$_POST['q_autofill']."','".$_POST['_q_ringinuse']."','".$_POST['queue_musiconhold']."','".$_POST['q_monitor_type']."', '".$q_monitor_format."','".$_POST['q_servicelevel']."','".$_POST['q_queue_thankyou']."','".$_POST['q_queue_youarenext']."','".$_POST['q_queue_thereare']."', '".$_POST['q_queue_callswaiting']."','".$_POST['q_queue_holdtime']."','".$_POST['q_queue_minutes']."','".$_POST['q_queue_seconds']."','".$_POST['q_queue_lessthan']."', '".$_POST['q_queue_reporthold']."','".$_POST['q_relative_periodic_announce']."','".$_POST['queue_timeout']."','','', '','".$_POST['status']."','2','','".$created_at."','".$updated_at."','','".$selectedUser."','','0', '0','0','','0','0','".$_POST['clientId']."','".$_POST['ivr']."')";

$result_queue = mysqli_query($connection , $insert_queue);
		if($result_queue){
			if($_SESSION['userroleforpage']=='1'){
				$activity_type = 'Queue Assign to User';
				$msg = 'Queue No: '.$_POST['queueNum'].' '.'Queue Added Succesfully! By Admin';
			}else{
				$activity_type = 'Queue Added';
				$msg = 'Queue No: '.$_POST['queueNum'].' '.'Queue Added Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
			$_SESSION['msg'] = 'Queue Added Succesfully!';
			echo '<script>window.location.href="queue.php"</script>';
			}
		}	
	}
}

?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="overview-wrap">
				<h2 class="title-1"> Queue Add<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
				<div class="table-data__tool-right">
					<a href="queue.php">
						<button class="au-btn au-btn-icon au-btn--green au-btn--small">
					<i class="fa fa-eye" aria-hidden="true"></i> Queue</button></a>
				</div>

			</div>
		</div>
	</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="queueForm" action="" method="post">
			<?php //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
			if($_SESSION['userroleforpage'] == '1'){  ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Client Name</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="clientId" data-show-subtext="false" data-live-search="true" name="clientId" class="form-control selectpicker" required>
							<option value="">Select</option>
							<?php while($row = mysqli_fetch_array($result_client)){ ?>
							<option value="<?php echo $row['clientId']; ?>"
							<?php if($row['clientId'] == $_POST['clientId']){ echo 'selected';} ?>
							><?php echo $row['clientName'].'/'.$row['clientEmail'];; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>			
				
				
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class="form-control-label">Select User*</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="selectedUser" name="selectedUser"  class="form-control" required>
						<option value="">Select</option>
							<?php 
							if(isset($_POST['selectedUser'])) { 
							while($row_user = mysqli_fetch_array($result_user_login)){ ?>
							<option value="<?php echo $row_user['id']; ?>"
							<?php if($row_user['id'] == $_POST['selectedUser']){ echo 'selected'; } ?>
							><?php echo $row_user['name']; ?></option>
							<?php } } ?>
						</select><input type="hidden" name="_selectedUser" value="1"/>
					</div>
				<!--<div style="position:absolute; right:0; left:50%;">Use Ctrl Key to Select Multiple Users.</div>-->
                </div>
				<?php } ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Extension</label>
					</div>
					<div class="col-10 col-md-6">
						<input id="queueNum" name="queueNum" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['queueNum'])) { echo $_POST['queueNum']; } else { echo ''; } ?>"  readonly />
					</div>
					<div class="col-2 col-md-2">
										<button type="button" class="btn btn-success btn-sm" id="genrateIntercom"><i
												class="fa fa-refresh" aria-hidden="true"></i> Generate</button>
									</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Name*</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="queueName" name="queueName" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['queueName'])) { echo $_POST['queueName']; } else { echo ''; } ?>" required/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Description*</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="description" name="description" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['description'])) { echo $_POST['description']; } else { echo ''; } ?>" required/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Strategy</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="stratergy" name="stratergy" class="form-control-sm form-control" required>
							<option value="">Select</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy'] == 'rrmemory' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="rrmemory">rrmemory</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy'] == 'ringall' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="ringall">Ring All</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy'] == 'leastrecent' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="leastrecent">Least Recent</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy'] == 'fewestcalls' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="fewestcalls">Fewest Calls</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy']== 'random' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="random">Random</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy']== 'linear' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="linear">Linear</option>
							<option <?php if(isset($_POST['stratergy']) && $_POST['stratergy'] == 'wrandom' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="wrandom">W Random</option>
						</select>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Queue Status*</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="status" name="status" class="form-control-sm form-control" required>
						<option value="">Select</option>
						<option <?php if(isset($_POST['status']) && $_POST['status'] == 'Active' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="Active">Active</option>
						<option <?php if(isset($_POST['status']) && $_POST['status'] == 'Inactive' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="Inactive">Inactive</option>
						</select>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Ring Timeout**</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="ringtimeout" name="ringtimeout" placeholder="10" value="<?php if(isset($_POST['ringtimeout'])) { echo $_POST['ringtimeout']; } else { echo '60'; } ?>" class="form-control" type="text" required/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Musiconhold</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="queue_musiconhold" name="queue_musiconhold" placeholder="bigpbx" value="<?php if(isset($_POST['queue_musiconhold'])) { echo $_POST['queue_musiconhold']; } else { echo 'default'; } ?>" class="form-control" type="text" />
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
						<input id="queuemaxlen" name="queuemaxlen" placeholder="3330" value="<?php if(isset($_POST['queuemaxlen'])) { echo $_POST['queuemaxlen']; } else { echo '0'; } ?>" class="form-control" type="text" />
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Report Hold Time</label>
					</div>
					<div class="col-12 col-md-8">

					<label class="switch switch-text switch-primary">
						<input id="queuereportholdtime1" name="queuereportholdtime" class="switch-input" type="checkbox" value="true"/><input type="hidden" name="_queuereportholdtime" value="<?php if(isset($_POST['_queuereportholdtime'])) { echo $_POST['_queuereportholdtime']; } else { echo 'no'; } ?>"/>
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
						<input id="q_periodic_announce_frequency" name="q_periodic_announce_frequency" placeholder="Periodic Announce Frequency" value="<?php if(isset($_POST['q_periodic_announce_frequency'])) { echo $_POST['q_periodic_announce_frequency']; } else { echo '0'; } ?>" class="form-control" type="text" />
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Periodic Announce</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_periodic_announce" name="q_periodic_announce" placeholder="Periodic Announce" class="form-control" type="text" value="<?php if(isset($_POST['q_periodic_announce'])) { echo $_POST['q_periodic_announce']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Join Empty</label>
					</div>
					<div class="col-12 col-md-8">
						<label class="switch switch-text switch-primary">
							<input id="q_joinempty1" name="q_joinempty" class="switch-input" type="checkbox" value="true"/><input type="hidden" name="_q_joinempty" value="<?php if(isset($_POST['_q_joinempty'])) { echo $_POST['_q_joinempty']; } else { echo 'no'; } ?>"/>
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
							<input id="q_leavewhenempty1" name="q_leavewhenempty" class="switch-input" type="checkbox" value="true"/><input type="hidden" name="_q_leavewhenempty" value="<?php if(isset($_POST['_q_leavewhenempty'])) { echo $_POST['_q_leavewhenempty']; } else { echo 'no'; } ?>"/>
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
							<input id="q_autopause1" name="q_autopause" class="switch-input" type="checkbox" value="true"/><input type="hidden" name="_q_autopause" value="<?php if(isset($_POST['_q_autopause'])) { echo $_POST['_q_autopause']; } else { echo 'no'; } ?>"/>
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
						<input id="q_announce_round_seconds" name="q_announce_round_seconds" placeholder="Announce Round Seconds" class="form-control" type="text" value="<?php if(isset($_POST['q_announce_round_seconds'])) { echo $_POST['q_announce_round_seconds']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Retry</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_retry" name="q_retry" placeholder="Retry" class="form-control" type="text" value="<?php if(isset($_POST['q_retry'])) { echo $_POST['q_retry']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Wrapuptime</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_wrapuptime" name="q_wrapuptime" placeholder="Wrapuptime" class="form-control" type="text" value="<?php if(isset($_POST['q_wrapuptime'])) { echo $_POST['q_wrapuptime']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Announce Holdtime</label>
					</div>
					<div class="col-12 col-md-8">

						<label class="switch switch-text switch-primary">
							<input id="q_announce_holdtime1" name="q_announce_holdtime" class="switch-input" type="checkbox" value="true"/><input type="hidden" name="_q_announce_holdtime" value="<?php if(isset($_POST['_q_announce_holdtime'])) { echo $_POST['_q_announce_holdtime']; } else { echo 'no'; } ?>"/>
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
						<input id="q_announce_frequency" name="q_announce_frequency" placeholder="Announce Frequency" class="form-control" type="text" value="<?php if(isset($_POST['q_announce_frequency'])) { echo $_POST['q_announce_frequency']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Context</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_context" name="q_context" placeholder="Context" class="form-control" type="text" value="<?php if(isset($_POST['q_context'])) { echo $_POST['q_context']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Music Class</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_musicclass" name="q_musicclass" placeholder="Music Class" value="default" class="form-control" type="text" value="<?php if(isset($_POST['q_musicclass'])) { echo $_POST['q_musicclass']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Auto fill</label>
					</div>
					<div class="col-12 col-md-8">

					<label class="switch switch-text switch-primary">
						<input id="q_autofill1" name="q_autofill" checked="true" class="switch-input" type="checkbox" value="<?php if(isset($_POST['q_autofill'])) { echo $_POST['q_autofill']; } else { echo 'yes'; } ?>"/><input type="hidden" name="_q_autofill" value="no"/>
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
							<input id="q_ringinuse1" name="q_ringinuse" class="switch-input" type="checkbox" value="no"/><input type="hidden" name="_q_ringinuse" value="<?php if(isset($_POST['q_ringinuse'])) { echo $_POST['q_ringinuse']; } else { echo 'no'; } ?>"/>
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
						<input id="q_monitor_type" name="q_monitor_type" placeholder="Monitor Type" value="MixMonitor" class="form-control" type="text" value="<?php if(isset($_POST['q_monitor_type'])) { echo $_POST['q_monitor_type']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Monitor Format</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_monitor_format" name="q_monitor_format" placeholder="Music Class" value="wav" class="form-control" disabled="disabled" type="text" value="<?php if(isset($_POST['q_monitor_format'])) { echo $_POST['q_monitor_format']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Service Level</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_servicelevel" name="q_servicelevel" placeholder="Music Class" value="60" class="form-control" type="text" value="<?php if(isset($_POST['q_servicelevel'])) { echo $_POST['q_servicelevel']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Thankyou</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_thankyou" name="q_queue_thankyou" placeholder="Queue Thankyou" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_thankyou'])) { echo $_POST['q_queue_thankyou']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Youarenext</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_youarenext" name="q_queue_youarenext" placeholder="Queue Youarenext" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_youarenext'])) { echo $_POST['q_queue_youarenext']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Thereare</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_thereare" name="q_queue_thereare" placeholder="Queue Thereare" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_thereare'])) { echo $_POST['q_queue_thereare']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Callswaiting</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_callswaiting" name="q_queue_callswaiting" placeholder="Queue Callswaiting" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_callswaiting'])) { echo $_POST['q_queue_callswaiting']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Holdtime</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_holdtime" name="q_queue_holdtime" placeholder="Queue Holdtime" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_holdtime'])) { echo $_POST['q_queue_holdtime']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Minutes</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_minutes" name="q_queue_minutes" placeholder="Queue Minutes" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_minutes'])) { echo $_POST['q_queue_minutes']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Seconds</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_seconds" name="q_queue_seconds" placeholder="Queue Seconds" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_seconds'])) { echo $_POST['q_queue_seconds']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Lessthan</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_lessthan" name="q_queue_lessthan" placeholder="Queue Lessthan" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_lessthan'])) { echo $_POST['q_queue_lessthan']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue Reporthold</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="q_queue_reporthold" name="q_queue_reporthold" placeholder="Queue Reporthold" class="form-control" type="text" value="<?php if(isset($_POST['q_queue_reporthold'])) { echo $_POST['q_queue_reporthold']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Queue timeout</label>
					</div>
					<div class="col-12 col-md-8">
						<input id="queue_timeout" name="queue_timeout" placeholder="Queue timeout" value="30" class="form-control" type="text" value="<?php if(isset($_POST['queue_timeout'])) { echo $_POST['queue_timeout']; } else { echo ''; } ?>"/>
					</div>
				</div>


				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Relative Periodic Announce</label>
					</div>
					<div class="col-12 col-md-8">

						<label class="switch switch-text switch-primary">
							<input id="q_relative_periodic_announce1" name="q_relative_periodic_announce" checked="true" class="switch-input" type="checkbox" value="<?php if(isset($_POST['q_relative_periodic_announce1'])) { echo $_POST['q_relative_periodic_announce1']; } else { echo 'yes'; } ?>"/><input type="hidden" name="_q_relative_periodic_announce" value="no"/>
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
function relist(){
	 window.location.href="queue.php";	
}
	$(document).ready(function() {
		$('#genrateIntercom').click(function () {
			genrateIntercom();
		});
	function genrateIntercom(){
		$.ajax({
			url : "ajaxCreateIntercom.php",
			type : 'post',
			data : {data_type : 'queue'},
			success: function(data){
				$('#queueNum').val(data);
			}
		});
	}
});
	/*
$( "select[name='clientId']" ).change(function () {
    var clientsID = $(this).val();


    if(clientsID) {


        $.ajax({
            url: "ajaxpro.php",
            dataType: 'Json',
            data: {'id':clientsID},
            success: function(data) {
                $('select[name="selectedUser[]"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="selectedUser[]"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });


    }else{
        $('select[name="selectedUser[]"]');
		$.each(data, function(key, value) {
                    $('select[name="selectedUser[]"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
    }
});
*/

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
 
