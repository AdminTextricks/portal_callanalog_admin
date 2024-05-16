<?php require_once('header.php');

if (isset($_POST['submit'])) {
	$fromdate = $_POST['fromDate'];
	$agent_name = $_POST['agent_name'];
	$queue = $_POST['queue'];
	$calltype = $_POST['callType'];

	if ($calltype == '') {
		if ($queue == '') {
			if ($agent_name == '') {
				$querystring = '';
			} else {
				$querystring = ' and extension=' . $agent_name;
			}
		} else {
			if ($agent_name == '') {
				$querystring = ' and dest_name=' . $queue;
			} else {
				$querystring = ' and dest_name=' . $queue . ' and extension=' . $agent_name;
			}
		}
	} elseif ($queue == '') {
		if ($agent_name == '') {
			$querystring = 'and call_type="' . $calltype . '"';
		} else {
			$querystring = ' and extension=' . $agent_name . ' and call_type="' . $calltype . '"';
		}
	} else {
		// if($agent_name == ''){
		// $querystring = 'and dest_name='.$queue.' and call_type='.$calltype;
		// }else{
		// $querystring = 'and dest_name='.$queue.' and extension='.$agent_name.' and call_type='.$calltype;
		// }
		if ($queue == '') {
			if ($agent_name == '') {
				$querystring = 'and call_type="' . $calltype . '"';
			} else {
				$querystring = ' and extension=' . $agent_name . ' and call_type="' . $calltype . '"';
			}
		} else {
			if ($agent_name == '') {
				$querystring = ' and dest_name=' . $queue . ' and call_type="' . $calltype . '"';
			} else {
				$querystring = 'and dest_name=' . $queue . ' and extension=' . $agent_name . ' and call_type="' . $calltype . '"';
			}
		}

	}




	/*
	   if($queue == '')
	   {
		   if($agent_name == ''){
		   $querystring = '';
		   }else{
			   $querystring = ' and extension='.$agent_name;
		   }
	   }else{
		   if($tnf == ''){
		   $querystring = ' and dest_name='.$queue;
		   }else{
			   $querystring = ' and dest_name='.$queue.' and did='.$tnf;
		   }
	   }
	   */
	$select_did = "select DISTINCT extension from cdr where calldate between '" . $fromdate . "' and '" . $fromdate . " 23:59:59' and extension != '' and disposition='ANSWERED' " . $querystring . "";
	$resultdid = mysqli_query($connection, $select_did);

}

if ($_SESSION['userroleforpage'] == 1) {
	$queuenamesid = '';
} else {
	// $queuenames = "SELECT cqt.name AS name FROM cc_queue_table cqt
// LEFT JOIN Client ON cqt.clientid = Client.clientId
// WHERE Client.clientId = '".$_SESSION['userroleforclientid']."'";
// $resultqueuef = mysqli_query($connection,$queuenames);
// while($rowsds = mysqli_fetch_array($resultqueuef))
// {
	// $queuenamesid = 'where name ='.$rowsds['name'];
// }
	$queuenames = "SELECT cqt.name AS name FROM cc_queue_table cqt
LEFT JOIN Client ON cqt.clientid = Client.clientId
WHERE Client.clientId = '" . $_SESSION['userroleforclientid'] . "'";
	$resultqueue_one = mysqli_query($connection, $queuenames);

	$array_result_one = array();
	$sizeofvalue_one = sizeof($resultqueue_one);
	foreach ($resultqueue_one as $transfer_record_one) {
		$destination_one = $transfer_record_one['name'];
		array_push($array_result_one, $destination_one);
	}
	$resultingsone = $array_result_one;
	$queuenamesid = 'where name in (' . implode(",", $resultingsone) . ')';
}

$select_queue = "select name,queue_name from cc_queue_table " . $queuenamesid . " order by name";
$resultqueue = mysqli_query($connection, $select_queue);

$select_tfn = "select did from cc_did order by creationdate ASC";
$resulttfn = mysqli_query($connection, $select_tfn);

if ($_SESSION['userroleforpage'] == 1) {
	$select_agent = "select * from cc_sip_buddies where agent_name!='' order by agent_name ASC";
} else {
	$select_agent = "select * from cc_sip_buddies where agent_name!='' and accountcode='" . $_SESSION['login_usernames'] . "' order by agent_name ASC";
}
$resultagent = mysqli_query($connection, $select_agent);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"
	integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css"
	integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap table_top_heading">


					</div>
				</div>
			</div>

			<div class="reports_inner_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="report_missed">
							<form id="classicReportForm" action="" method="post">
								<div class="row">

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Select
												Date</label>
											<input id="fromDate" name="fromDate" autocomplete="off" class="form-control"
												type="text"
												value="<?php if (isset($_POST['fromDate'])) {
													echo $_POST['fromDate'];
												} else {
													echo date('Y-m-d');
												} ?>" />
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Call Type</label>
											<select id="callType" name="callType" class="form-control">
												<option selected="selected" value="">All</option>
												<option <?php if ($_POST['callType'] == '0') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="0">Outbound</option>
												<option <?php if ($_POST['callType'] == '1') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="1">Inbound</option>
											</select>
										</div>
									</div>


									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Queue Name</label>
											<select id="queue" name="queue" class="form-control">
												<?php if ($_SESSION['userroleforpage'] == 1) { ?>
													<option value="" selected="selected">All</option>
												<?php } ?>
												<?php while ($queuerow = mysqli_fetch_array($resultqueue)) { ?>
													<option <?php if ($queue == $queuerow['name']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $queuerow['name']; ?>">
														<?php echo $queuerow['queue_name'] . ' (' . $queuerow['name'] . ')'; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Agent Name</label>
											<select id="agent_name" name="agent_name" class="form-control">
												<option value="" selected="selected">All</option>
												<?php while ($agentrow = mysqli_fetch_array($resultagent)) { ?>
													<option <?php if ($agent_name == $agentrow['name']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $agentrow['name']; ?>">
														<?php echo $agentrow['agent_name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>



									<div class="col-md-3">
										<div class="form-group">
											<button type="submit" name="submit" value="submit" style="margin-top: 25px;"
												class="btn btn-primary btn-sm">Submit</button>
										</div>
									</div>
									<p></p>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>

			<?php if (isset($_POST['fromDate'])) { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="table_title">
							<h4>Agent Report From
								<?php echo $fromdate . ' 00:00:00 TO ' . $fromdate . ' 23:59:59'; ?>
							</h4>
						</div>
					</div>
				</div>
				<br>
			<?php } ?>


			<div class="row">
				<div class="col-md-12">

					<div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate"
						style="overflow: scroll;">
						<table id="queueTable" class="table manage_queue_table">
							<thead>

								<tr style="background-color:#2aa9de;color:white;">
									<th style="color:white;">Serial No</th>
									<th style="color:white;">Agent Name</th>

									<th style="color:white;">09:30-10:30</th>
									<th style="color:white;">10:30-11:30</th>
									<th style="color:white;">11:30-12:30</th>
									<th style="color:white;">12:30-13:30</th>
									<th style="color:white;">13:30-14:30</th>
									<th style="color:white;">14:30-15:30</th>
									<th style="color:white;">15:30-16:30</th>
									<th style="color:white;">16:30-17:30</th>
									<th style="color:white;">17:30-18:30</th>
									<th style="color:white;">18:30-19:30</th>
									<th style="color:white;">19:30-20:30</th>
									<th style="color:white;">20:30-21:30</th>
									<th style="color:white;">21:30-22:30</th>
									<th style="color:white;">22:30-23:30</th>
									<th style="color:white;">23:30-00:30</th>
									<th style="color:white;">00:30-01:30</th>
									<th style="color:white;">01:30-02:30</th>
									<th style="color:white;">02:30-03:30</th>
									<th style="color:white;">03:30-04:30</th>
									<th style="color:white;">04:30-05:30</th>
									<th style="color:white;">05:30-06:30</th>
									<th style="color:white;">06:30-07:30</th>
									<th style="color:white;">07:30-08:30</th>
									<th style="color:white;">08:30-09:30</th>
									<th style="color:white;">Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$j = 1;
								while ($rowdid = mysqli_fetch_array($resultdid)) {

									$extensions = $rowdid['extension'];

									$querytotalexten = "select agent_name from cc_sip_buddies where name='" . $extensions . "' order by agent_name DESC";
									$resultdidexten = mysqli_query($connection, $querytotalexten);
									$namextnsn = mysqli_fetch_assoc($resultdidexten);

									$fromtime = array("09:30", "10:30", "11:30", "12:30", "13:30", "14:30", "15:30", "16:30", "17:30", "18:30", "19:30", "20:30", "21:30", "22:30", "23:30", "00:30", "01:30", "02:30", "03:30", "04:30", "05:30", "06:30", "07:30", "08:30");
									$totime = array("10:30", "11:30", "12:30", "13:30", "14:30", "15:30", "16:30", "17:30", "18:30", "19:30", "20:30", "21:30", "22:30", "23:30", "00:30", "01:30", "02:30", "03:30", "04:30", "05:30", "06:30", "07:30", "08:30", "09:30");

									$querytotaldid = "select count(extension) as totalnumber from cdr where extension='" . $extensions . "' and calldate between '" . $fromdate . "' and '" . $fromdate . " 23:59:59' and disposition='ANSWERED' and extension!=''" . $querystring . "";
									$resultdidcount = mysqli_query($connection, $querytotaldid);
									$totaldidnumbercount = mysqli_fetch_assoc($resultdidcount);

									?>
									<tr>
										<td style="background-color:#2aa9de;color:white;text-align:left;">
											<?php echo $j; ?>
										</td>
										<td style="background-color:#2aa9de;color:white;text-align:left;">
											<?php echo $namextnsn['agent_name']; ?>
										</td>
										<?php for ($i = 0; $i < count($fromtime); $i++) {
											$querydata = "select count(extension) as totalcount from cdr where extension='" . $extensions . "' and calldate between '" . $fromdate . ' ' . $fromtime[$i] . "' and '" . $fromdate . ' ' . $totime[$i] . "' and disposition='ANSWERED' and extension!=''" . $querystring . "";
											$resultcount = mysqli_query($connection, $querydata);

											while ($rowcount = mysqli_fetch_array($resultcount)) { ?>
												<td>
													<?php echo $rowcount['totalcount']; ?>
												</td>
												<?php
											}
										}
										?>
										<td style="background-color:#2aa9de;color:white;">
											<?php echo $totaldidnumbercount['totalnumber']; ?>
										</td>
									</tr>

									<?php
									//}
// }
									$j++;
								}
								?>
								<tr>
									<td style="background-color:#2aa9de;color:white;"></td>
									<td style="background-color:#2aa9de;color:white;">Total</td>
									<?php

									$fromtime = array("09:30", "10:30", "11:30", "12:30", "13:30", "14:30", "15:30", "16:30", "17:30", "18:30", "19:30", "20:30", "21:30", "22:30", "23:30", "00:30", "01:30", "02:30", "03:30", "04:30", "05:30", "06:30", "07:30", "08:30");
									$totime = array("10:30", "11:30", "12:30", "13:30", "14:30", "15:30", "16:30", "17:30", "18:30", "19:30", "20:30", "21:30", "22:30", "23:30", "00:30", "01:30", "02:30", "03:30", "04:30", "05:30", "06:30", "07:30", "08:30", "09:30");


									for ($k = 0; $k < count($fromtime); $k++) {

										$querydatatotal = "select count(extension) as totcount from cdr where calldate between '" . $fromdate . ' ' . $fromtime[$k] . "' and '" . $fromdate . ' ' . $totime[$k] . "' and disposition='ANSWERED' and extension!=''" . $querystring . "";
										$resultdiddidcount = mysqli_query($connection, $querydatatotal);

										while ($rowcountrow = mysqli_fetch_array($resultdiddidcount)) { ?>
											<td style="background-color:#2aa9de;color:white;">
												<?php echo $rowcountrow['totcount']; ?>
											</td>
											<?php
										}
									}
									?>
								</tr>


							</tbody>
						</table>
					</div>


				</div>
			</div>



		</div>
	</div>

	<!-- footer section start here -->
	<div class="copyright">
		<p>Copyright Â© 2020 PBX. All rights reserved.</p>
	</div>
	<!-- footer section end here -->

</div>


</div>
</div>

<script>
	$("select[name='queue']").change(function () {
		var queueID = $(this).val();


		if (queueID) {


			$.ajax({
				url: "tfnreportajax.php",
				dataType: 'Json',
				data: { 'id': queueID },
				success: function (data) {
					$('select[name="tnf"]').empty();
					$('select[name="tnf"]').append('<option value="">All</option>');

					$.each(data, function (key, value) {

						$('select[name="tnf"]').append('<option value="' + key + '">' + value + '</option>');
					});
				}
			});


		} else {
			$('select[name="tnf"]');
			$.each(data, function (key, value) {
				$('select[name="tnf"]').append('<option value="' + key + '">' + value + '</option>');
			});
		}
	});
</script>

<script>
	$(function () {
		$("#fromDate").datepicker({
			dateFormat: 'yy-mm-dd ',
			maxDate: '0'
		});
		$("#toDate").datepicker({
			dateFormat: 'yy-mm-dd ',
			maxDate: '0'
		});
	});

</script>

<script>
	$(document).ready(function () {
		$('select').selectize({
			sortField: 'text'
		});
	});
</script>

<?php require_once('footer.php'); ?>