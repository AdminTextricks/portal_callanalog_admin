<?php require_once('connection.php'); 

date_default_timezone_set('Asia/Kolkata');
$query_client = "select `id`,`name`, `queue_name`, `description`, `maxlen`, `reportholdtime`, `periodic_announce_frequency`, `periodic_announce`, `strategy`, `joinempty`, `leavewhenempty`, `autopause`, `announce_round_seconds`, `retry`, `wrapuptime`, `announce_holdtime`, `announce_position`, `announce_frequency`, `timeout`, `context`, `musicclass`, `autofill`, `ringinuse`, `musiconhold`, `monitor_type`, `monitor_format`, `servicelevel`, `queue_thankyou`, `queue_youarenext`, `queue_thereare`, `queue_callswaiting`, `queue_holdtime`, `queue_minutes`, `queue_seconds`, `queue_lessthan`, `queue_reporthold`, `relative_periodic_announce`, `queue_timeout`, `fail_status`, `fail_dest`, `fail_data`, `status`, `user_id`, `email`, `created_at`, `updated_at`, `domain`, `assigned_user`, `announce`, `eventmemberstatus`, `eventwhencallled`, `memberdelay`, `setinterfacevar`, `timeoutrestart`, `weight`, `clientId`, `play_ivr` from cc_queue_table";
$result = mysqli_query($connection , $query_client);


$query_waiting_call = "select * from cc_live_calls where status=2";
$result_waiting = mysqli_query($connection , $query_waiting_call);

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
?>
<section id="main-content" class=" ">
                <section class="wrapper main-wrapper" style=''>
		                       <div class="col-xl-12" id="sample">
                        <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left">Queue Summary</h2>
                                <div class="actions panel_actions float-right">
                                    <i class="box_toggle fa fa-chevron-down"></i>
                      
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12 padding-0">

                                        <table id="example-2" class="table table-striped dt-responsive row-border hover order-column" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Queue</th>
                                                    <th>Queue Name</th>
                                                    <th>Customer Name</th>
                                                    <th>Inbound/Outbound</th>
                                                    <th>Paused/Total</th>
                                                    <th>Call Waiting</th>
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
												?>
                                                <tr>
                                                    <td><?php echo $row[1]; ?></td>
                                                    <td><?php echo $row[2]; ?></td>
                                                    <td>Admin</td>
                                                    <td><?php echo $totaloutinbound.'/'.$totalinoutbound; ?></td>
                                                    <td><?php echo $totalpaused.'/'.$totalmem; ?></td>
                                                    <td><?php echo $totalwaiting; ?></td>
                                                    <td>800</td>
                                                    <td>400</td>
                                                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                                </tr>
												<?php } ?>
                                            </tbody>
                                        </table>

										
										
                                    </div>
                                </div>
                            </div>
                        </section>
						
						<!-- waiting call details-->
						
						 <section class="box ">
                            <header class="panel_header">
                                <h2 class="title float-left" >Waiting Status</h2>
                                <div class="actions panel_actions float-right">
                                    <i class="box_toggle fa fa-chevron-down"></i>
                      
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12 padding-0">

                                        <table id="example-2" class="table table-striped dt-responsive row-border hover order-column" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Queue Name</th>
                                                    <th>TFN</th>
                                                    <th>Duration</th>
                                                    <th>CLID</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php 
												$modified_wait     =  date('Y-m-d H:i:s');
												while($row_wait = mysqli_fetch_array($result_waiting)) {
													
													$timeduration_wait = strtotime($modified_wait) - strtotime($row_wait['created']);
												?>
                                                <tr>
                                                    <td><?php echo $row_wait['queue_name']; ?></td>
                                                    <td><?php echo $row_wait['caller_number']; ?></td>
                                                    <td><?php echo seconds2human($timeduration_wait); ?></td>
                                                    <td><?php echo $row_wait['source_number']; ?></td>
                                                    <td><?php echo date('Y-m-d H:i:s'); ?></td>
                                                </tr>
												<?php } ?>
                                            </tbody>
                                        </table>										
                                    </div>
                                </div>
                            </div>
                        </section>
						
						<!-- Start Agent status and live call status -->
						<h2 class="title float-center" style="background-color:#1fb5ac;color:white;"><center>Agent Status (<?php echo mysqli_num_rows($result); ?>)</center></h2>
						
						
						<?php //for($i=0;$i<mysqli_num_rows($result);$i++){ 
							
								$query_client = "select `id`,`name`, `queue_name`, `description`, `maxlen`, `reportholdtime`, `periodic_announce_frequency`, `periodic_announce`, `strategy`, `joinempty`, `leavewhenempty`, `autopause`, `announce_round_seconds`, `retry`, `wrapuptime`, `announce_holdtime`, `announce_position`, `announce_frequency`, `timeout`, `context`, `musicclass`, `autofill`, `ringinuse`, `musiconhold`, `monitor_type`, `monitor_format`, `servicelevel`, `queue_thankyou`, `queue_youarenext`, `queue_thereare`, `queue_callswaiting`, `queue_holdtime`, `queue_minutes`, `queue_seconds`, `queue_lessthan`, `queue_reporthold`, `relative_periodic_announce`, `queue_timeout`, `fail_status`, `fail_dest`, `fail_data`, `status`, `user_id`, `email`, `created_at`, `updated_at`, `domain`, `assigned_user`, `announce`, `eventmemberstatus`, `eventwhencallled`, `memberdelay`, `setinterfacevar`, `timeoutrestart`, `weight`, `clientId`, `play_ivr` from cc_queue_table";
								$result = mysqli_query($connection , $query_client);
								while($row_connected = mysqli_fetch_array($result)) {
							 ?>
						 <section class="box ">
                            <header class="panel_header" style="background-color:#1fb5ac;">
                                <h2 class="title float-left" style="color:white;"><?php echo $row_connected['queue_name']; ?></h2>
                                <div class="actions panel_actions float-right">
                                    <i class="box_toggle fa fa-chevron-down"></i>
                                </div>
                            </header>
                            <div class="content-body">    <div class="row">
                                    <div class="col-lg-12 col-md-12 col-12 padding-0">

                                        <table id="example-2" class="table table-striped dt-responsive row-border hover order-column" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Queue Name</th>
                                                    <th>Agent's Name</th>
                                                    <th>Agent Ext</th>
                                                    <th>Duration</th>
                                                    <th>DID</th>
                                                    <th>CLID</th>
                                                    <th>status</th>
                                                    <th>Unpause</th>
                                                </tr>
                                            </thead>
                                            <tbody>
											<?php 
												$query_client_one = "SELECT qt.queue_name as queuename,qt.name as queue,qm.membername as ext,qm.paused as paused FROM cc_queue_table qt left join cc_queue_member_table qm ON qt.name=qm.queue_name where qt.name='".$row_connected['name']."'";
												$result_one = mysqli_query($connection , $query_client_one);
												
												
												while($row_wait = mysqli_fetch_array($result_one)) {
													
													$paused = $row_wait['paused'];
													
													$query_agent_name = "SELECT agent_name FROM cc_sip_buddies where name='".$row_wait['ext']."'";
												$result_agentname = mysqli_query($connection , $query_agent_name);
												while($row_agentname = mysqli_fetch_array($result_agentname)) {
														$agentname = $row_agentname['agent_name'];
												}
												?>
												<tr>
                                                    <td><?php echo $row_wait['queue'] .' / '. $row_wait['queuename']; ?></td>
                                                    <td><?php echo $agentname; ?></td>
                                                    <td><?php echo $row_wait['ext']; ?></td>
													
												<?php	
												$query_lives_calls = "SELECT * FROM cc_live_calls where status='3' AND agent_number='".$row_wait['ext']."' AND queue_name='".$row_wait['queue']."'";
												$result_livescall = mysqli_query($connection , $query_lives_calls);
												while($row_lives_call = mysqli_fetch_array($result_livescall)) {
														$timeduration_conn_call = strtotime($row_lives_call['modified']) - strtotime($row_lives_call['created']);
														$timeduration_conn_call_one = $row_lives_call['modified'] .' '. $row_lives_call['created'];
														$clid = $row_lives_call['caller_number'];
														$did_tfn = $row_lives_call['source_number'];
														$callstatus = $row_lives_call['call_status'];
												
												$calling_time_min = seconds2human($timeduration_conn_call);
												if($calling_time_min > 0){
													$calling_time_min = $calling_time_min;
												}else{
													$calling_time_min = '';
												}
													 }
												if(mysqli_num_rows($result_livescall) > 0){
												?>
                                                    <td><?php echo $calling_time_min; ?></td>
                                                    <td><?php echo $did_tfn; ?></td>
                                                    <td><?php echo $clid; ?></td>
                                                    <td><?php echo $callstatus; ?></td>
                                                    <?php  } else{ ?>
													
													<td></td>
													<td></td>
													<td></td>
													<td></td>
													<?php }
													
													 ?>
													 <td>
													<div class="form-block">
                                                       <input type="checkbox" <?php if($paused==0) { echo 'checked'; } else { echo ''; } ?> class="iswitch iswitch-sm iswitch-success">
                                                    </div>
													</td>
												</tr>
			
											<?php }  ?>
												
                                            </tbody>
                                        </table>										
                                    </div>
                                </div>
                            </div>
                        </section>
						<?php } //}  ?>
						<!-- End Agent status and live call status -->
						
						</div>
						
						</section>
						</section>