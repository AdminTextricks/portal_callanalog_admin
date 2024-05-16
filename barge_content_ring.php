<?php
require_once('connection.php');
//date_default_timezone_set('Asia/Kolkata');
if ($_SESSION['userroleforpage'] == 1) {
	$query_ring = "SELECT `id`, `ringno`, `strategy`, `ringtime`, `ringpre`, `ringlist`, `description`, `ringing`, `progress`, `elsewhere`, `user_id`, `clientId` FROM `cc_ring_group`";
} else {
	$query_ring = "SELECT `id`, `ringno`, `strategy`, `ringtime`, `ringpre`, `ringlist`, `description`, `ringing`, `progress`, `elsewhere`, `user_id`, `clientId` FROM `cc_ring_group` WHERE `user_id`= '" . $_SESSION['login_user_id'] . "'";
}

// $result = mysqli_query($connection, $query_ring);

function seconds2human($ss)
{
	$s = $ss % 60;
	$m = floor(($ss % 3600) / 60);
	$h = floor(($ss % 86400) / 3600);
	$d = floor(($ss % 2592000) / 86400);
	$M = floor($ss / 2592000);
	if ($h == 0) {
		$h = '';
	} else {
		$h = $h . ':';
	}
	return "$h$m:$s";
}

function seconds2human_rohit($ss)
{
	$s = $ss % 60;
	$m = floor(($ss % 3600) / 60);
	$h = floor(($ss % 86400) / 3600);
	$d = floor(($ss % 2592000) / 86400);
	$M = floor($ss / 2592000);
	return "$h$m:$s";
}

?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<input type="hidden"
				value="80001,5515,5517,5519,5503,5516,5518,0099,5551,5513,5544,5505,5520,4551,5540,5502,5530,6609,5559,"
				id="queueNumbers" />
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">Waiting Status</h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
						<h4 class="table_title"></h4>
						<table class="table manage_queue_table">
							<thead>
								<tr>
									<th>Destination</th>
									<th>CallerID</th>
									<th>Duration</th>
									<th>DID</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$modified_wait = date('Y-m-d H:i:s');

								$queue_res = mysqli_query($connection, $query_ring);
								$array_result = array();
								// $sizeofvalue = sizeof($queue_res);
								foreach ($queue_res as $transfer_record) {
									$destination = $transfer_record['ringno'];
									array_push($array_result, $destination);
								}
								$resultings = $array_result;
								$queue_id = implode(",", $resultings);

								// echo "<pre>";print_r($queue_id);exit;
								if ($_SESSION['userroleforpage'] == 1) {
									$query_waiting_call = "select * from cc_live_calls where status=2";
								} else {
									$query_waiting_call = "select * from cc_live_calls where status=2 and queue_name in (" . $queue_id . ")";
								}
								$result_waiting = mysqli_query($connection, $query_waiting_call);

								while ($row_wait = mysqli_fetch_array($result_waiting)) {

									$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['created']); ?>
									<tr style="background-color:rgba(255, 225, 10, 0.3);">
										<td>
											<?php echo $row_wait['queue_name']; ?>
										</td>
										<td>
											<?php echo $row_wait['caller_number']; ?>
										</td>
										<td>
											<?php echo seconds2human($timeduration_wait); ?>
										</td>
										<td>
											<?php echo $row_wait['source_number']; ?>
										</td>
										<td><a href="waithangupcall.php?channelid=<?php echo $row_wait['call_id']; ?>"
												target="_blank">Hangup<i
													class="fa fa-close icon-md icon-info animated"></i></a></td>
									</tr>
									<?php
								} ?>
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
				</div>
			</div>

			<?php
			if ($_SESSION['userroleforpage'] == 1) {
				$query_client = "SELECT `ringno`, `strategy`, `ringtime`, `ringpre`, `ringlist`, `description`, `ringing`, `progress`, `elsewhere`, `user_id`, `clientId` FROM `cc_ring_group`";
			} else {
				$query_client = "SELECT `ringno`, `strategy`, `ringtime`, `ringpre`, `ringlist`, `description`, `ringing`, `progress`, `elsewhere`, `user_id`, `clientId` FROM `cc_ring_group` WHERE `user_id`= '" . $_SESSION['login_user_id'] . "'";
			}
			$result = mysqli_query($connection, $query_client);
			while ($row_connected = mysqli_fetch_array($result)) { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
							<div class="row">
								<div class="col-md-12">
									<h4 class="table_title accord_icon queueHeading"> <i class="fa fa-chevron-down"
											aria-hidden="true"></i> &nbsp;&nbsp;&nbsp;&nbsp;
										<?php echo $row_connected['ringno']; ?>
									</h4>
								</div>
							</div>

							<table class="table manage_queue_table queue_agents">
								<thead>
									<tr>
										<th>Destination</th>
										<th>Agent's Name</th>
										<th>Agent Ext</th>
										<th>Duration</th>
										<th>DID</th>
										<th>CLID</th>
										<th>Status</th>
										<th>Listen</th>
										<th>Unpause</th>
									</tr>
								</thead>
								<tbody>
									<?php
									//echo $row_connected['ringlist'];
									$ringlist = str_replace("-", "','", $row_connected['ringlist']);

									$query_client_one = "SELECT cc_ring_group.*, cc_sip_buddies.*, cc_live_calls.created, cc_live_calls.modified, cc_live_calls.queue_name, cc_live_calls.source_number, cc_live_calls.user_id, cc_live_calls.call_id, cc_live_calls.caller_number, cc_live_calls.agent_number, cc_live_calls.status,cc_live_calls.call_status FROM `cc_ring_group`	LEFT JOIN `cc_did_destination` on `cc_did_destination`.destination = cc_ring_group.`ringno`
						LEFT JOIN `cc_sip_buddies` ON cc_sip_buddies.`user_id` = cc_ring_group.`user_id`
						LEFT JOIN `cc_live_calls` ON cc_live_calls.`user_id` = cc_sip_buddies.`user_id`
						WHERE cc_ring_group.`ringno` = '" . $row_connected['ringno'] . "' and cc_sip_buddies.name IN('" . $ringlist . "') and `cc_did_destination`. destination = '" . $row_connected['ringno'] . "'";

									$result_one = mysqli_query($connection, $query_client_one);

									while ($row_wait = mysqli_fetch_array($result_one)) {

										if ($row_wait['modified'] > 0) {
											$modified_wait = date('Y-m-d H:i:s');
											$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['modified']);
											$timeduration_conn_call = seconds2human($timeduration_wait);
										} else {
											$timeduration_conn_call = '';
										}
										?>
										<tr <?php if ($row_wait['status'] == '3' && $row_wait['name'] == $row_wait['agent_number'] /*&& $row_wait['ringno'] == $row_wait['queue_name'] */) {
											echo 'style="background-color:rgba(0, 255, 0, 0.3);"';
										} else {
											echo '';
										} ?>>
											<td>
												<?php echo $row_wait['ringno'] . ' / ' . $row_wait['description']; ?>
											</td>
											<td>
												<?php echo $row_wait['agent_name']; ?>
											</td>
											<td>
												<?php echo $row_wait['name']; ?>
											</td>
											<?php if ($row_wait['name'] == $row_wait['agent_number'] /* && $row_wait['ringno'] == $row_wait['queue_name'] */) { ?>
												<td>
													<?php echo $timeduration_conn_call; ?>
												</td>
												<td>
													<?php echo $row_wait['source_number']; ?>
												</td>
												<td>
													<?php echo $row_wait['caller_number']; ?>
												</td>
												<td>
													<?php echo $row_wait['call_status']; ?>
												</td>
												<td class="listen popu_slct" id="listen-0006-618" data-extension="618">
													<?php if ($row_wait['status'] == '3') {
														echo '<i id="myBtn" onclick="getRingId(' . $row_wait['caller_number'] . ')" class="fa fa-headphones" aria-hidden="true"></i>';
													} else {
														echo '';
													} ?>
												</td>

											<?php } else { ?>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<td></td>
												<?php
											} ?>

											<td>
												<?php if ($row_wait['paused'] == 0) { ?>
													<div class="table-data-feature">
														<label class="switch switch-text switch-success switch-pill"
															style="margin-left: 0px;padding-right: 0px;">
															<input type="checkbox" class="switch-input"
																value="0<?php echo $row_wait['qid']; ?>" name="agentPause" checked
																data-queuext="">
															<?php //if($row_wait['paused']==0) { echo 'checked=""'; } else { echo ''; } ?>
															<span data-on="On" data-off="Off" class="switch-label"></span>
															<span class="switch-handle"></span>
														</label>
													</div>
												<?php } else { ?>
													<div class="table-data-feature">
														<label class="switch switch-text switch-success switch-pill"
															style="margin-left: 0px;padding-right: 0px;">
															<input type="checkbox" class="switch-input"
																value="1<?php echo $row_wait['qid']; ?>" name="agentPause"
																data-queuext="">
															<?php //if($row_wait['paused']==0) { echo 'checked=""'; } else { echo ''; } ?>
															<span data-on="On" data-off="Off" class="switch-label"></span>
															<span class="switch-handle"></span>
														</label>
													</div>
												<?php } //}
														?>
											</td>
										</tr>
									<?php //} } 
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

</div>
<script>
	$(document).ready(function () {
		$('input[type="checkbox"]').click(function () {
			var agentPause = $(this).val();

			$.ajax({
				url: "biglives_update.php",
				method: "POST",
				data: { agentPause: agentPause },
				success: function (data) {
					$('#result').html(data);
					//alert("Hey, " + agentPause + "");
				}
			});
		});
	});  
</script>
<script>
	/*
	$(document).ready(function(){  
		 $('input[type="radio"]').click(function(){  
			  var gender = $(this).val();  
			  $.ajax({  
				   url:"biglives_update.php",  
				   method:"POST",  
				   data:{gender:gender},  
				   success:function(data){  
						$('#result').html(data);  
				   }  
			  });  
		 });  
	});  
	*/
</script>

<script>

	/*
	// Get the modal
	var modal = document.getElementById("myModal");
	
	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");
	
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	
	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	}
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}
	
	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}
	*/
</script>