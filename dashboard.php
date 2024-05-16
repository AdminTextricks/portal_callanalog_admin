<?php
require_once ('header.php');
// echo '<pre>';print_r($_SESSION);exit;
// echo session_name();
if ($currentlogin_userrole == 1) {
	$clientidsss = '';
} elseif ($currentlogin_userrole == 2) {
	$clientidsss = 'where clientId=""';
} else {
	$clientidsss = 'where clientId="' . $currentlogin_useridss . '"';
}

$query_client = "select count(*) as totalclient from Client";
$result = mysqli_query($connection, $query_client);
while ($row = mysqli_fetch_row($result)) {
	$totalclient = $row[0];
}

$query_user = "select count(*) as totaluser from users_login " . $clientidsss . "";
$result_user = mysqli_query($connection, $query_user);
while ($row_user = mysqli_fetch_row($result_user)) {
	$totaluser = $row_user[0];
}

// if($currentlogin_userrole == 1){
// $queuenamesid = '';
// }else{
// $queuenames = "SELECT cqt.name AS name FROM cc_queue_table cqt
// LEFT JOIN Client ON cqt.clientid = Client.clientId
// WHERE Client.clientId = '".$currentlogin_useridss."'";
// $resultqueue = mysqli_query($connection,$queuenames);
// while($row = mysqli_fetch_array($resultqueue))
// {
// $queuenamesid ='where name ='.$row['name'];
// }
// }

if ($currentlogin_userrole == 1) {
	$query_queue = "select count(*) as totalqueue from cc_queue_table";
	$result_queue = mysqli_query($connection, $query_queue);
	while ($row_que = mysqli_fetch_row($result_queue)) {
		$totalqueue = $row_que[0];
	}
} else {
	$queuenames = "SELECT count(*) AS totalqueue FROM cc_queue_table cqt
	LEFT JOIN Client ON cqt.clientid = Client.clientId
	WHERE Client.clientId = '" . $currentlogin_useridss . "'";
	$resultqueue = mysqli_query($connection, $queuenames);
	while ($row = mysqli_fetch_row($resultqueue)) {
		$totalqueue = $row[0];
	}
}

$queuenames_one = "SELECT cqt.name AS name FROM cc_queue_table cqt
LEFT JOIN Client ON cqt.clientid = Client.clientId
WHERE Client.clientId = '" . $_SESSION['userroleforclientid'] . "'";
$resultqueue_one = mysqli_query($connection, $queuenames_one);

$array_result_one = array();
//$sizeofvalue_one = sizeof($resultqueue_one);
foreach ($resultqueue_one as $transfer_record_one) {
	$destination_one = $transfer_record_one['name'];
	array_push($array_result_one, $destination_one);
}
$resultingsone = $array_result_one;
$queue_id = implode(",", $resultingsone);



// $query_queue = "select count(*) as totalqueue from cc_queue_table ".$queuenamesid."";
// $result_queue = mysqli_query($connection , $query_queue);
// while($row_que = mysqli_fetch_row($result_queue)) {
// $totalqueue =  $row_que[0];
// } 
if ($currentlogin_userrole == 1) {
	$query_biglives = "select count(*) as totallives from cc_live_calls";

	$query_ext = "select count(*) as totalext from cc_sip_buddies";

	$query_inbound = "select count(*) as totalinbound from cc_did";

} else {
	$query_biglives = "select count(*) as totallives from cc_live_calls where agent_number in (select name from cc_sip_buddies where accountcode = '" . $_SESSION['login_usernames'] . "')";

	$query_ext = "select count(*) as totalext from cc_sip_buddies where id_cc_card='" . $_SESSION['login_user_id'] . "'";

	//$query_ext = "select count(*) as totalext from cc_sip_buddies where accountcode=".$_SESSION['login_usernames']."";

	$query_inbound = "select count(*) as totalinbound from cc_did where iduser=" . $_SESSION['login_user_id'] . "";
}
$result_biglives = mysqli_query($connection, $query_biglives);
while ($row_live = mysqli_fetch_row($result_biglives)) {
	$totalbiglives = $row_live[0];
}



$result_ext = mysqli_query($connection, $query_ext);
while ($row_ext = mysqli_fetch_row($result_ext)) {
	$totalext = $row_ext[0];
}

// echo $query_inbound;
$result_inbound = mysqli_query($connection, $query_inbound);
while ($row_inbound = mysqli_fetch_row($result_inbound)) {
	$totalinbound = $row_inbound[0];
}


$query_outbound = "select count(*) as totaloutbound from cc_trunk";
$result_outbound = mysqli_query($connection, $query_outbound);

while ($row_outbound = mysqli_fetch_row($result_outbound)) {
	$totaloutbound = $row_outbound[0];
}
if ($_SESSION['userroleforpage'] == 1) {
	$query_blacklist = "select count(*) as totalblacklist FROM cc_blacklist";
} else {
	$query_blacklist = "select count(*) as totalblacklist FROM cc_blacklist where `user_id`= '" . $_SESSION['login_user_id'] . "'";
}
$result_blacklist = mysqli_query($connection, $query_blacklist);
while ($row_blacklist = mysqli_fetch_row($result_blacklist)) {
	$totalblacklist = $row_blacklist[0];
}

if ($_SESSION['userroleforpage'] == 1) {
	$sql_chart = "SELECT COUNT(*) AS count, disposition, calldate FROM cc_cdr GROUP BY disposition";
} else {
	$sql_chart = "SELECT COUNT(*) AS count, disposition, calldate FROM cc_cdr where `user_id`=  '" . $_SESSION['login_user_id'] . "' GROUP BY disposition";
}
$result_chart = mysqli_query($connection, $sql_chart);
// echo "<pre>";print_r( $result_chart );die;
$chartData = array(
	array('Disposition', 'Count')
);
while ($row = mysqli_fetch_assoc($result_chart)) {
	if ($row['disposition'] === 'ANSWER') {
		$chartData[] = array('Answer', (int) $row['count']);
	} elseif ($row['disposition'] === 'NOANSWER') {
		$chartData[] = array('No Answer', (int) $row['count']);
	} elseif ($row['disposition'] === 'failed') {
		$chartData[] = array('Abandend', (int) $row['count']);
	}
}

$userRole = isset($_SESSION['userroleforpage']) ? $_SESSION['userroleforpage'] : null;




?>

<div class="main-content">

	<div class="section__content section__content--p30">
		<div class="container-fluid">
			<div class="home_all_tab">
				<div class="row">
					<div class="col-sm-12 ">
						<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
						<?php if ($userRole == 1) { ?>
							<canvas id="answerCallChart" width="100%" height="400" style="background:white;"></canvas>
						<?php } else { ?>
							<?php // if(mysqli_num_rows($result_chart) > 0) {  ?>
							<canvas id="answerCallChart" width="100%" height="400" style="background:white;"></canvas>
						<?php //} 
						} ?>
						<script src="script.js"></script>
					</div>
					<div class="col-sm-12 ">
						<?php if ($userRole == 1): ?>
							<h3>Call Details Admin</h3>
							<div id="piechart" class="pt-5 pb-5" style="width: 500px; height: 300px;margin:20px 0px;"></div>
						<?php elseif ($userRole == 2): ?>
							<!-- <h1>User View</h1> -->
							<?php //if(mysqli_num_rows($result_chart) > 0) {  ?>
							<div id="piechart" style="width: 500px; height: 300px;margin:20px 0px;"></div>
							<?php // }else{	}  ?>
						<?php else: ?>
							<p>User role not defined. Please login with appropriate user role.</p>
						<?php endif; ?>
					</div>
					<?php
					if ($_SESSION['userroleforpage'] == 1) { ?>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
							<!-- <a class="home_tab_ancher" href="client.php">
						<div class="university-tiles clr_yellow">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-users" aria-hidden="true"></i>
							</div>
							<p>Clients</p>
							<h2><?php echo $totalclient; ?></h2>
							
						</div>
					</a> -->
						</div>

						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
							<!-- University tile start -->
							<!-- <a class="home_tab_ancher" href="users.php">
						<div class="university-tiles clr_green">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-users" aria-hidden="true"></i>
							</div>
							<p>Users</p>
							<h2><?php echo $totaluser; ?></h2>
							
						</div>
					</a> -->
						</div>
						<?php
					}
					?>

					<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<!-- University tile start -->
						<!-- <a class="home_tab_ancher" href="biglives.php"> -->
						<!-- <a class="home_tab_ancher" href="barge.php">
						<div class="university-tiles clr_red">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-podcast" aria-hidden="true"></i>
							</div>								
						<p>Live Calls</p>
						<h2><?php echo $totalbiglives; ?></h2>
						</div>
					</a> -->
						<!-- University tile end -->
					</div>
					<?php //echo $query_queue_buddies; //print_r($_SESSION); ?>


					<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<!-- University tile start -->
						<!-- <a class="home_tab_ancher" href="queue.php">
						<div class="university-tiles clr_yellow">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-quora" aria-hidden="true"></i>
							</div>
							<p>Queues</p>
							<h2><?php echo $totalqueue; ?></h2>									
						</div>
					</a> -->
						<!-- University tile end -->
					</div>
					<?php //echo $query_ext; //print_r($_SESSION); ?>


					<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<!-- University tile start -->
						<!-- <a class="home_tab_ancher" href="extension.php">
						<div class="university-tiles">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-etsy" aria-hidden="true"></i>
							</div>									
							<p>Extensions</p>
							<h2><?php if (strlen($totalext) > 0) {
								echo $totalext;
							} else {
								echo 0;
							} ?></h2>
						</div>
						</a> -->
						<!-- University tile end -->
					</div>


					<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<!-- University tile start -->
						<!-- <a class="home_tab_ancher" href="inbound.php">
						<div class="university-tiles">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fas fa-map-marker-alt"></i>
							</div>							
							<p>Inbound Destination</p>
							<h2><?php if (strlen($totalinbound) > 0) {
								echo $totalinbound;
							} else {
								echo 0;
							} ?></h2>
						</div>
					</a> -->
						<!-- University tile end -->
					</div>


					<?php
					if ($_SESSION['userroleforpage'] == 1) { ?>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
							<!-- University tile start -->
							<!-- <a class="home_tab_ancher" href="outboundroute.php">
						<div class="university-tiles">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-opera" aria-hidden="true"></i>
							</div>
							<p>Gateway</p>
							<h2><?php echo $totaloutbound; ?></h2>
						</div>
					</a> -->
							<!-- University tile end -->
						</div>
					<?php }
					?>


					<!--
					<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">						
						<a class="home_tab_ancher" href="#">
						<div class="university-tiles">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-podcast" aria-hidden="true"></i>								
							</div>
							<h2><?php //echo $totaloutbound; ?></h2>
							<p>Trunk</p>
						</div>
					</a>						
					</div>
					-->


					<!-- <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<a class="home_tab_ancher" href="blacklist.php">
						<div class="university-tiles clr_blue">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-lock" aria-hidden="true"></i>								
							</div>
							<p>BlackList</p>
							<h2><?php echo $totalblacklist; ?></h2>							
						</div>
					</a>
					</div>					 -->

					<?php /*  ?>	
																<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
																	<a class="home_tab_ancher" href="">
																	<div class="university-tiles clr_red">
																		<div class="icon">
																			<span class="dots">
																				<i class="dot dot-blue"></i>
																				<i class="dot dot-yellow"></i>
																				<i class="dot dot-red"></i>
																			</span>
																			<i class="fa fa-microphone" aria-hidden="true"></i>
																		</div>
																		<p>IVR</p>
																		<h2>0</h2>
																		</div>
																</a>
																</div>
															<?php  */ ?>


					<!-- <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">
						<a class="home_tab_ancher" href="reports.php">
						<div class="university-tiles clr_green">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-flag" aria-hidden="true"></i>
								
							</div>
							<p>Reports</p>
							<h2><?php echo '--'; ?></h2>
						</div>
						</a>
					</div> -->


					<?php if ($currentlogin_userrole > 1) { ?>
						<div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12">

							<!-- University tile start -->
							<!-- <a class="home_tab_ancher" href="outboundroute.php">
						<div class="university-tiles">
							<div class="icon">
								<span class="dots">
									<i class="dot dot-blue"></i>
									<i class="dot dot-yellow"></i>
									<i class="dot dot-red"></i>
								</span>
								<i class="fa fa-doller" aria-hidden="true"></i>
							</div>
							<p>Credit</p>
							<h2><?php if (strlen($_SESSION['login_user_credits']) > 0) {
								echo $_SESSION['login_user_credits'];
							} else {
								echo 0.00;
							} ?></h2>
						</div>
					</a> -->
							<!-- University tile end -->
						</div>
					<?php } ?>

				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once ('footer.php'); ?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
	google.charts.load('current', { 'packages': ['corechart'] });
	google.charts.setOnLoadCallback(drawChart);

	function drawChart() {
		var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);

		var options = {
			title: 'Call Dispositions',
			pieHole: 0.4,
		};

		var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		chart.draw(data, options);
	}


</script>
</body>

</html>