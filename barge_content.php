<?php require_once ('connection.php');

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
						<table class="table manage_queue_table" id="datatable">
							<thead>
								<tr>
									<th>Company</th>
									<th>Email</th>
									<th>Destination Type</th>
									<th>Destination</th>
									<th>CallerID</th>
									<th>Duration</th>
									<th>DID</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if (!isset($_SESSION['login_user_id'])) { ?>
									<tr>
										<td colspan="8">
											<span>Your Session has been Expired. Please Login Again.</span>
										</td>
									</tr>
								<?php } else {
									$modified_wait = date("Y-m-d H:i:s");
									if ($_SESSION['userroleforpage'] == 1) {
										$query_waiting_call = "select * from cc_live_calls where status=2";
									} else {
										$query_waiting_call = "select * from cc_live_calls where status=2 and user_id = '" . $_SESSION['login_user_id'] . "'";
									}
									$result_waiting = mysqli_query($connection, $query_waiting_call);
									if (mysqli_num_rows($result_waiting) > 0) {
										while ($row_wait = mysqli_fetch_array($result_waiting)) {
											$destinationNum = $row_wait['queue_name'];
											$is_queue = "select `name` from `cc_queue_table` where `name` = '" . $destinationNum . "'";
											$isQueue_res = mysqli_query($connection, $is_queue);
											if (mysqli_num_rows($isQueue_res) > 0) {
												$destinationType = "Queue";
											}
											$is_ring = "select `ringno` from `cc_ring_group` where `ringno` = '" . $destinationNum . "'";
											$isRingres = mysqli_query($connection, $is_ring);
											if (mysqli_num_rows($isRingres) > 0) {
												$destinationType = "Ring";
											}
											$is_extSql = "select `name` from cc_sip_buddies where `name` = '" . $destinationNum . "'";
											$isExtRes = mysqli_query($connection, $is_extSql) or die("query failed : is_extSql");
											if (mysqli_num_rows($isExtRes) > 0) {
												$destinationType = "Extension";
											}

											$client_sql = "select clientId,email from users_login where id='" . $row_wait['user_id'] . "'";
											$client_res = mysqli_query($connection, $client_sql) or die("query failed : client_sql");
											$client_row = mysqli_fetch_assoc($client_res);
											$clientId = $client_row['clientId'];
											$email = $client_row['email'];

											$client_query = "select clientName from Client where clientId='" . $clientId . "'";
											$client_result = mysqli_query($connection, $client_query) or die("query failed : client_query");
											$clientRow = mysqli_fetch_assoc($client_result);
											$clientName = $clientRow['clientName'];

											$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['created']);
											?>
											<tr style="background-color:rgba(255, 225, 10, 0.3);">
												<td>
													<?php echo $clientName; ?>
												</td>
												<td>
													<?php echo $email; ?>
												</td>
												<td>
													<?php echo $destinationType; ?>
												</td>
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
												<td><a
														href="waithangupcall.php?agent_channel=<?php echo $row_wait['agent_channel']; ?>">Hangup<i
															class="fa fa-close icon-md icon-info animated"></i></a></td>
											</tr>
										<?php }
									}
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
			<div class="row">
				<div class="col-md-12">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
						// $query_groupby = "select user_id from cc_live_calls group by user_id";
						if ($_SESSION['userroleforpage'] == 1) {
							$query_groupby = "select user_id from cc_live_calls group by user_id";
						} else {
							$query_groupby = "select user_id from cc_live_calls where user_id = '" . $_SESSION['login_user_id'] . "'";
						}
						$result_groupby = mysqli_query($connection, $query_groupby);
						while ($row_groupby = mysqli_fetch_array($result_groupby)) {

							$client_sql = "select clientId,email,name from users_login where id='" . $row_groupby['user_id'] . "'";
							$client_res = mysqli_query($connection, $client_sql) or die("query failed : client_sql");
							$client_row = mysqli_fetch_assoc($client_res);
							$clientId = $client_row['clientId'];
							$email = $client_row['email'];
							?>
							<div class="panel panel-default">
								<div class="panel-heading" role="tab">
									<h2 class="panel-title"><b>
											<?php echo $client_row['name'] . ' / ' . $email; ?></b>
									</h2>
								</div>
								<div>
									<div class="panel-body">
										<div
											class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
											<table class="table manage_queue_table" id="searching">
												<thead>
													<tr>
														<th>Sno.</th>
														<th>Company</th>
														<th>Destination Type</th>
														<th>Destination</th>
														<th>Agent's Name</th>
														<th>Agent Ext</th>
														<th>Duration</th>
														<th>DID</th>
														<th>CLID</th>
														<th>Status</th>
														<th>Listen</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php

													if (!isset($_SESSION['login_user_id'])) { ?>
														<tr>
															<td colspan="11">
																<span>Your Session has been Expired. Please Login Again.</span>
															</td>
														</tr>
													<?php } else {
														$modified_wait = date('Y-m-d H:i:s');
														$array_result = array();
														if (is_array($queue_res)) {
															foreach ($queue_res as $transfer_record) {
																$destination = $transfer_record['name'];
																array_push($array_result, $destination);
															}
															$resultings = $array_result;
															$queue_id = implode(",", $resultings);
														}
														if ($_SESSION['userroleforpage'] == 1) {
															$query_waiting_call = "select * from cc_live_calls where status=3 and user_id = '" . $row_groupby['user_id'] . "'";
														} else {
															$query_waiting_call = "select * from cc_live_calls where status=3 and user_id = '" . $_SESSION['login_user_id'] . "'";
														}
														$result_waiting = mysqli_query($connection, $query_waiting_call);
														$i = 1;
														if (mysqli_num_rows($result_waiting) > 0) {
															while ($row_wait = mysqli_fetch_array($result_waiting)) {
																$destinationNum = $row_wait['queue_name'];
																$is_queue = "select `name` from `cc_queue_table` where `name` = '" . $destinationNum . "'";
																$isQueue_res = mysqli_query($connection, $is_queue);
																if (mysqli_num_rows($isQueue_res) > 0) {
																	$destinationType = "Queue";
																}
																$is_ring = "select `ringno` from `cc_ring_group` where `ringno` = '" . $destinationNum . "'";
																$isRingres = mysqli_query($connection, $is_ring);
																if (mysqli_num_rows($isRingres) > 0) {
																	$destinationType = "Ring";
																}
																$is_extSql = "select `name` from cc_sip_buddies where `name` = '" . $destinationNum . "'";
																$isExtRes = mysqli_query($connection, $is_extSql) or die("query failed : is_extSql");
																if (mysqli_num_rows($isExtRes) > 0) {
																	$destinationType = "Extension";
																}


																$client_query = "select clientName from Client where clientId='" . $clientId . "'";
																$client_result = mysqli_query($connection, $client_query) or die("query failed : client_query");
																$clientRow = mysqli_fetch_assoc($client_result);
																$clientName = $clientRow['clientName'];

																$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['created']);
																$timeduration_conn_call = seconds2human($timeduration_wait);
																?>
																<tr style="background-color:rgba(0, 255, 0, 0.3);">
																	<td>
																		<?php echo $i; ?>
																	</td>
																	<td>
																		<?php echo $clientName; ?>
																	</td>
																	<td>
																		<?php echo $destinationType; ?>
																	</td>
																	<td>
																		<?php echo $row_wait['queue_name']; ?>
																	</td>
																	<td>
																		<?php echo $row_wait['agent_name']; ?>
																	</td>
																	<td>
																		<?php echo $row_wait['agent_number']; ?>
																	</td>
																	<?php //if($row_wait['clsqueue_name'] == $row_wait['queuename']){         ?>
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
																	<td class="listen popu_slct" id="listen-0006-618"
																		data-extension="618">
																		<?php if ($row_wait['status'] == '3') {
																			echo '<i id="myBtn" onclick="getId(' . $row_wait['agent_number'] . ')" class="fa fa-headphones" aria-hidden="true"></i>';
																		} else {
																			echo '';
																		} ?>
																	</td>
																	<?php /* }else{ ?><td></td><td></td><td></td><td></td><td></td>  <?php }  */ ?>
																	<td>
																		<?php if ($row_wait['paused'] == 0) { ?>
																			<!-- <div class="table-data-feature">
														<label class="switch switch-text switch-success switch-pill"
															style="margin-left: 0px;padding-right: 0px;">

															<input type="checkbox" class="switch-input"
																value="0<?php echo $row_wait['qid']; ?>" name="agentPause" checked
																data-queuext="">
															<?php //if($row_wait['paused']==0) { echo 'checked=""'; } else { echo ''; }         ?>

															<span data-on="On" data-off="Off" class="switch-label"></span>
															<span class="switch-handle"></span>
														</label>
													</div> -->
																		<?php } else { ?>
																			<!-- <div class="table-data-feature">
														<label class="switch switch-text switch-success switch-pill"
															style="margin-left: 0px;padding-right: 0px;">

															<input type="checkbox" class="switch-input"
																value="1<?php echo $row_wait['qid']; ?>" name="agentPause"
																data-queuext="">
															<?php //if($row_wait['paused']==0) { echo 'checked=""'; } else { echo ''; }         ?>

															<span data-on="On" data-off="Off" class="switch-label"></span>
															<span class="switch-handle"></span>
														</label>
													</div> -->
																		<?php }
																		if ($row_wait['status'] == 3) { ?>
																			<a
																				href="waithangupcall.php?agent_channel=<?php echo $row_wait['agent_channel']; ?>">Hangup<i
																					class="fa fa-close icon-md icon-info animated"></i></a>
																		<?php }
																		?>
																	</td>
																</tr>
																<?php $i++;
															}
														}
													} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			// $("#searching").DataTable({});
			// $("#datatable").DataTable({});

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