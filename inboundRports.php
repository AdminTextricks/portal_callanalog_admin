<?php
require_once('header.php');
require_once('functions.php');
$user_query = "select timezone from users_login where id = '" . $_SESSION['login_user_id'] . "'";
$user_res = mysqli_query($connection, $user_query) or die("query failed : user_query");
$rows = mysqli_fetch_assoc($user_res);
$userTimezone = $rows['timezone'];

$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$fromTime = isset($_GET['fromTime']) ? $_GET['fromTime'] : '';

$fromdates = $fromDate . ' ' . $fromTime;
$cfromDate = new DateTime($fromdates, new DateTimeZone($userTimezone));
$cfromDate->setTimezone(new DateTimeZone('America/New_York'));
$fromNewDate = $cfromDate->format('Y-m-d H:i:s');

$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';
$toTime = isset($_GET['toTime']) ? $_GET['toTime'] : '';

$todates = $toDate . ' ' . $toTime;
$cToDate = new DateTime($todates, new DateTimeZone($userTimezone));
$cToDate->setTimezone(new DateTimeZone('America/New_York'));
$toNewDate = $cToDate->format('Y-m-d H:i:s');

//echo '<pre>'; print_r($_GET); 	print_r($_SESSION); echo '</pre>';//exit;

if (isset($_GET['disposition']) && strlen($_GET['disposition']) > 0) {
	//$disposition = 'and cc_cdr.disposition = "'.$_GET['disposition'].'"';
	if ($_GET['disposition'] == 'ANSWER') {
		$disposition = 'and cc_cdr.answertime != ""';
	} elseif ($_GET['disposition'] == 'MISSED CALL') {
		$disposition = 'and cc_cdr.answertime = ""';
	} else {
		$disposition = '';
	}
} else {
	$disposition = '';
}

$queueNames = isset($_GET['queueName']) ? $_GET['queueName'] : '';
if (strlen($queueNames) > 0) {
	$queueNames = "and cc_cdr.destination='" . $queueNames . "'";
} else {
	$queueNames = '';
}

$extensions = isset($_GET['extension']) ? $_GET['extension'] : '';
if (strlen($extensions) > 0) {
	$extensions = "and cc_cdr.agent='" . $extensions . "'";
} else {
	$extensions = '';
}

$DIDSS = isset($_GET['DID']) ? $_GET['DID'] : '';
if (strlen($DIDSS) > 0) {
	$DIDSS = "and cc_cdr.dst='" . $DIDSS . "'";
} else {
	$DIDSS = '';
}

$CLID = isset($_GET['CLID']) ? $_GET['CLID'] : '';


if (!empty($CLID)) {
   
    $CLID = mysqli_real_escape_string($connection, $CLID);
  
    $CLID_condition = " AND cc_cdr.caller_num like '%".trim($CLID)."%'";
} else {
    
    $CLID_condition = '';
}


$extentionnumber = $_SESSION['login_user'];
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

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}
$total_no_of_pages = 1;
if (isset($_GET['submit'])) {


	$total_records_per_page = 25;
	$offset = ($page_no - 1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";
	if ($_SESSION['userroleforpage'] == 1) {
		$query_cdr_pagination = "SELECT COUNT(cc_cdr.id) FROM `cc_cdr` WHERE cc_cdr.calldate BETWEEN '" . $fromNewDate . "' AND '" . $toNewDate . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . $CLID_condition;
	} else {
		$query_cdr_pagination = "SELECT COUNT(cc_cdr.id) FROM `cc_cdr` WHERE cc_cdr.calldate BETWEEN '" . $fromNewDate . "' AND '" . $toNewDate . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . " AND cc_cdr.account_code='" . $_SESSION['login_usernames'] . "' " . $CLID_condition;
	}
	
	$result_queue_cdr_pagination = mysqli_query($connection, $query_cdr_pagination);

	$row_pagins = mysqli_fetch_row($result_queue_cdr_pagination);
	$total_pagins_records = $row_pagins[0];
	$total_no_of_pages = ceil($total_pagins_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;
	if ($_SESSION['userroleforpage'] == 1) {
		$query_cdr = "SELECT cc_cdr.*  FROM `cc_cdr` where cc_cdr.calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . "  ". $CLID_condition."  order by cc_cdr.id DESC limit " . $offset . ", " . $total_records_per_page . "";
	} else {
		$query_cdr = "SELECT cc_cdr.* FROM `cc_cdr` where cc_cdr.calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . "  ". $CLID_condition." and cc_cdr.account_code='" . $_SESSION['login_usernames'] . "' order by cc_cdr.id DESC limit " . $offset . ", " . $total_records_per_page . "";
	}
	// echo $query_cdr;
	$result_queue_cdr = mysqli_query($connection, $query_cdr);

	$urlcode = 'fromDate=' . $fromDate . '&fromTime=' . $fromTime . '&toDate=' . $toDate . '&toTime=' . $toTime . '&submit=' . $_GET['submit'] . '&showRecords=' . $_GET['showRecords'] . '&pageNumber=' . $_GET['pageNumber'] . '&extension=' . $_GET['extension'] . '&queueName=' . $queueNames . '&DID=' . $_GET['DID'] . '&CLID=' . $_GET['CLID'] . '&disposition=' . $disposition . '';
}

//$query_queue = "select * from cc_queue_table ".$queuenamesid."";
if ($_SESSION['userroleforpage'] == 1) {
	$query_queue = "select * from cc_queue_table  WHERE 1";
} else {
	$query_queue = "select * from cc_queue_table  WHERE assigned_user = '" . $_SESSION['login_user_id'] . "'";
}
$result_queue = mysqli_query($connection, $query_queue);

if ($_SESSION['userroleforpage'] == 1) {
	$query_extension = "select * from cc_sip_buddies where agent_name!='' order by agent_name asc";
} else {
	$query_extension = "select * from cc_sip_buddies where accountcode =" . $_SESSION['login_usernames'] . " and agent_name!='' order by agent_name asc";
}
$extenion_result = mysqli_query($connection, $query_extension);

if ($_SESSION['userroleforpage'] == 1) {
	$query_did = "select * from cc_did";
} else {
	$query_did = "select * from cc_did WHERE iduser='" . $_SESSION['login_user_id'] . "'";
}
$did_result = mysqli_query($connection, $query_did);

?>


<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Inbound Reports </h2>
						<?php //echo $query_cdr;  
						?>
					</div>
				</div>
			</div>

			<div class="reports_inner_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="classic_queue_info">
							<form id="classicReportForm" name="cdrreport" action="" method="get">
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
											<input id="fromDate" name="fromDate" class="form-control hasDatepicker" type="date" step="1" value="<?php if (isset($_GET['fromDate'])) {
																																					echo $_GET['fromDate'];
																																				} else {
																																					echo date('Y-m-d');
																																				} ?>">

										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">From Time*</label>
											<input id="fromTime" name="fromTime" class="form-control" type="time" step="1" value="00:00:00">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
											<input id="toDate" name="toDate" class="form-control hasDatepicker" type="date" value="<?php if (isset($_GET['toDate'])) {
																																		echo $_GET['toDate'];
																																	} else {
																																		echo date('Y-m-d');
																																	} ?>">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">To Time*</label>
											<input id="toTime" name="toTime" class="form-control" type="time" step="1" value="23:59:59">

										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Disposition</label>
											<select id="disposition" name="disposition" class="form-control selectpicker" data-live-search="true">
												<option <?php if (isset($_GET['disposition']) && $_GET['disposition'] == '') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="">All</option>
												<option <?php if (isset($_GET['disposition']) && $_GET['disposition'] == 'ANSWER') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="ANSWER">ANSWERED</option>
												<option <?php if (isset($_GET['disposition']) && $_GET['disposition'] == 'MISSED CALL') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="MISSED CALL">MISSED CALL</option>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Destination</label>
											<select id="queueName" name="queueName" class="form-control selectpicker" data-live-search="true">
												<option value="">All</option>
												<?php while ($queuerowid = mysqli_fetch_array($result_queue)) { ?>
													<option <?php if (isset($_GET['queueName']) && $_GET['queueName'] == $queuerowid['name']) {
																echo 'selected="selected"';
															} else {
																echo '';
															} ?> value="<?php echo $queuerowid['name']; ?>">
														<?php echo $queuerowid['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Extension</label>
											<select id="extension" name="extension" class="form-control selectpicker" data-live-search="true">
												<option value="">All</option>
												<?php while ($extrow = mysqli_fetch_array($extenion_result)) { ?>
													<option <?php if (isset($_GET['extension']) && $_GET['extension'] == $extrow['name']) {
																echo 'selected="selected"';
															} else {
																echo '';
															} ?> value="<?php echo $extrow['name']; ?>">
														<?php echo $extrow['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">DID/TFN</label>
											<select id="DID" name="DID" class="form-control selectpicker" data-live-search="true">
												<option value="">All</option>
												<?php while ($rowtfns = mysqli_fetch_array($did_result)) { ?>
													<option <?php if (isset($_GET['DID']) && $_GET['DID'] == $rowtfns['did']) {
																echo 'selected="selected"';
															} else {
																echo '';
															} ?> value="<?php echo $rowtfns['did']; ?>">
														<?php echo $rowtfns['did']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Caller ID</label>
											<input id="CLID" name="CLID" class="form-control" type="text" value="<?php echo isset($_GET['CLID']) ? $_GET['CLID'] : ''; ?>">
										</div>
									</div>


									<div class="col-md-3" style="float:right;">
										<div class="form-group" style="float:right;">
											<button type="submit" style="margin-top: 38px;" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
										</div>
									</div>
									<p></p>
								</div>
								<input id="showRecords" name="showRecords" type="hidden" value="10">
								<input id="pageNumber" name="pageNumber" type="hidden" value="1">
							</form>
							<?php if (isset($_GET['submit']) && mysqli_num_rows($result_queue_cdr) > 0) { ?>
								<hr>
								<div class="form-group row">
									<div class="col-sm-9">
										<h3>To Download the Inbound Report Click The Download CSV Button</h3>
									</div>
									<div class="col-sm-3"><button type="submit" id="export" name="export" value="submit" class="btn btn-primary btn-sm" style="font-size:22px;line-height: 32px;margin-top: 12px;">Download CSV</button>
									</div>
								</div>
							<?php } else {
								echo ''; ?>

							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap custom_show">
						&nbsp;
					</div>
					<div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate report_claasic_tble">
						<table id="queueTable" class="table manage_queue_table">
							<thead>

								<tr>
									<th>Serial No</th>
									<th>Date</th>
									<th>Status</th>
									<th>CID</th>
									<th>DID / TFN</th>
									<th>Destination</th>
									<th>Extension</th>
									<th>Agent</th>
									<th>Duration</th>
									<th>Cost</th>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<th>Origination IP</th>
									<?php } ?>
									<th>Recordings</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if (isset($_GET['submit'])) {
									if (mysqli_num_rows($result_queue_cdr) > 0) { ?>
										<tr class="tr-shadow">
											<?php
											$i = 1;
											while ($row_cdr = mysqli_fetch_array($result_queue_cdr)) {
												/* if (($row_cdr['context'] == 'Queue' || $row_cdr['context'] == 'IVR') && $row_cdr['channel'] != '') {
																						$disposition = 'ANSWER';
																					} elseif ($row_cdr['disposition'] == '') {
																						$disposition = 'CANCEL';
																					} else {
																						$disposition = $row_cdr['disposition'];
																					} */


												if ($_SESSION['userroleforpage'] !== '1') {
													$newDate = timezone($row_cdr['calldate']);
												} else {
													$newDate = $row_cdr['calldate'];
												}

											?>
												<td>
													<?php echo $i; ?>
												</td>
												<td>
													<?php echo $newDate; ?>
												</td>
												<td>
													<?php echo $row_cdr['disposition']; ?>
												</td>
												<td>
													<?php echo $res = midStr('<', '>', $row_cdr['caller_num']); ?>
												</td>
												<td>
													<?php echo $row_cdr['DID']; ?>
												</td>
												<td>
													<?php echo $row_cdr['context'] . '<br><' . $row_cdr['destination'] . '>'; ?>
												</td>
												<td>
													<?php echo $row_cdr['agent']; ?>
												</td>
												<td>
													<?php echo $row_cdr['agent_name']; ?>
												</td>
												<td>
													<?php echo seconds2human($row_cdr['billsec']); ?>
												</td>
												<td>
													<?php echo $row_cdr['cost']; ?>
												</td>
												<?php if ($_SESSION['userroleforpage'] == 1) { ?>
													<td>
														<?php echo $row_cdr['recvip']; ?>
													</td>
												<?php } ?>
												<td ><audio controls="controls" class="play-btn">
														<source type="audio/x-wav" src="<?php echo RECORDINGS . date('Y-m-d', strtotime($row_cdr['calldate'])); ?>/<?php if ($row_cdr['disposition'] == 'ANSWER') {
																																										echo $row_cdr['Recording'];
																																									} else {
																																										echo '';
																																									} ?>" />
													</audio></td>

										</tr>
								<?php $i++;
											}
										}
									} else { ?>

								<tr>
									<td colspan="11" style="color:red;font-size:20px;">No data found </td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>

					<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
						<strong>Showing
							<?php echo $page_no . " of " . $total_no_of_pages; ?>
						</strong>
					</div>

					<ul class="pagination">
						<?php if ($page_no > 1) {
							echo "<li><a href='?$urlcode&page_no=1'>First Page</a></li>";
						} ?>

						<li <?php if ($page_no <= 1) {
								echo "class='disabled'";
							} ?>>
							<a <?php if ($page_no > 1) {
									echo "href='?$urlcode&page_no=$previous_page'";
								} ?>>Previous</a>
						</li>

						<?php
						if ($total_no_of_pages <= 10) {
							for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
								if ($counter == $page_no) {
									echo "<li class='active'><a>$counter</a></li>";
								} else {
									echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
								}
							}
						} elseif ($total_no_of_pages > 10) {

							if ($page_no <= 4) {
								for ($counter = 1; $counter < 8; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
								echo "<li><a>...</a></li>";
								echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
								echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
								echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
								echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
								echo "<li><a>...</a></li>";
								for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
								echo "<li><a>...</a></li>";
								echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
								echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							} else {
								echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
								echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
								echo "<li><a>...</a></li>";

								for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
							}
						}
						?>

						<li <?php if ($page_no >= $total_no_of_pages) {
								echo "class='disabled'";
							} ?>>
							<a <?php if ($page_no < $total_no_of_pages) {
									echo "href='?$urlcode&page_no=$next_page'";
								} ?>>Next</a>
						</li>
						<?php if ($page_no < $total_no_of_pages) {
							echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
						} ?>
					</ul>

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#export').click(function(event) {
			event.preventDefault();
			var formData = $('#classicReportForm').serialize();
			$.ajax({
				url: 'inboundReportdownload.php',
				method: 'GET',
				data: formData,
				success: function(response) {
					var downloadLink = document.createElement('a');
					downloadLink.href = 'inboundReportdownload.php?' + formData;
					downloadLink.download = 'inbound_report.csv';
					downloadLink.click();
				}
			});
		});
	});
</script>



<?php require_once('footer.php'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('td audio').on('play', function() {
			console.log("play Now");
            var audioElement = this;
            $('td audio').not(audioElement).each(function() {
                if (!this.paused) {
                    this.pause();
                    this.currentTime = 0;
                }
            });
        });
        $('td audio').on('ended', function() {
            this.pause();
            this.currentTime = 0;
        });
    });
</script>
