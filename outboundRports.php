<?php
require_once ('header.php');

$TCarray = array('1' => 'ANSWERED', '2' => 'BUSY', '3' => 'NO ANSWER', '4' => 'CANCEL', '5' => 'CONGESTION', '6' => 'CHANUNAVAIL');
$prevMonth = strtotime("-1 month");


$user_query = "select timezone from users_login where id = '" . $_SESSION['login_user_id'] . "'";
$user_res = mysqli_query($connection, $user_query) or die ("query failed : user_query");
$rows = mysqli_fetch_assoc($user_res);
$userTimezone = $rows['timezone'];

$fromDate = isset ($_GET['fromDate']) ? $_GET['fromDate'] : '';
$fromTime = isset ($_GET['fromTime']) ? $_GET['fromTime'] : '';

$fromdates = $fromDate . ' ' . $fromTime;
$cfromDate = new DateTime($fromdates, new DateTimeZone($userTimezone));
$cfromDate->setTimezone(new DateTimeZone('America/New_York'));
$fromNewDate = $cfromDate->format('Y-m-d H:i:s');

$toDate = isset ($_GET['toDate']) ? $_GET['toDate'] : '';
$toTime = isset ($_GET['toTime']) ? $_GET['toTime'] : '';

$todates = $toDate . ' ' . $toTime;
$cToDate = new DateTime($todates, new DateTimeZone($userTimezone));
$cToDate->setTimezone(new DateTimeZone('America/New_York'));
$toNewDate = $cToDate->format('Y-m-d H:i:s');

//echo '<pre>'; print_r($_GET); 	print_r($_SESSION); echo '</pre>';//exit;

if (isset ($_GET['disposition']) && strlen($_GET['disposition']) > 0) {
	$disposition = 'and terminatecauseid = "' . $_GET['disposition'] . '"';
} else {
	$disposition = '';
}

//$destination = $_GET['destination'];
if (isset ($_GET['destination']) && strlen($_GET['destination']) > 0) {
	$destination = "and destination='" . $destination . "'";
} else {
	$destination = '';
}

$user = '';
if (isset ($_GET['user']) && strlen($_GET['user']) > 0) {
	$user = "and card_id='" . $user . "'";
}

//$phno = $_GET['phno'];
if (isset ($_GET['phno']) && strlen($_GET['phno']) > 0) {
	$phno = "and calledstation='" . $phno . "'";
} else {
	$phno = '';
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

if (isset ($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}

$urlcode = '';
$total_no_of_pages = 1;

if (isset ($_GET['submit'])) {

	$total_records_per_page = 25;
	$offset = ($page_no - 1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";
	if ($_SESSION['userroleforpage'] == 1) {
		$query_cdr_pagination = "SELECT count(`calldate`) FROM `CDR` where calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $destination . " " . $user . " " . $phno . " ";
	} else {
		$query_cdr_pagination = "SELECT count(`calldate`) FROM `CDR` where calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $destination . " " . $user . " " . $phno . "   and accountcode ='" . $_SESSION['login_user_id'] . "' ";
	}
	$result_queue_cdr_pagination = mysqli_query($connection, $query_cdr_pagination);

	$row_pagins = mysqli_fetch_row($result_queue_cdr_pagination);
	$total_pagins_records = $row_pagins[0];
	$total_no_of_pages = ceil($total_pagins_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;
	if ($_SESSION['userroleforpage'] == 1) {
		$query_cdr = "SELECT * FROM `CDR` where calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $destination . " " . $user . " " . $phno . "  order by `calldate` DESC limit " . $offset . ", " . $total_records_per_page . "";
	} else {
		$query_cdr = "SELECT * FROM `CDR` where calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $destination . " " . $user . " " . $phno . " and accountcode ='" . $_SESSION['login_user_id'] . "' order by `calldate` DESC limit " . $offset . ", " . $total_records_per_page . "";
	}
	// echo $query_cdr;exit;
	$result_queue_cdr = mysqli_query($connection, $query_cdr);

	$urlcode = 'fromDate=' . $_GET['fromDate'] . '&fromTime=' . $_GET['fromTime'] . '&toDate=' . $_GET['toDate'] . '&toTime=' . $_GET['toTime'] . '&submit=' . $_GET['submit'] . '&showRecords=' . $_GET['showRecords'] . '&pageNumber=' . $_GET['pageNumber'] . '&destination=' . $_GET['destination'] . '&disposition=' . $_GET['disposition'] . '';

}

//$query_queue = "select * from cc_queue_table ".$queuenamesid."";

$query_destination = "SELECT * FROM `cc_country`";

$result_destination = mysqli_query($connection, $query_destination);

if ($_SESSION['userroleforpage'] == 1) {
	$query_user = "SELECT * FROM `users_login` where 1 and status='Active' and deleted='0' order by name asc";
	$user_result = mysqli_query($connection, $query_user);
}


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
						<h2 class="title-1"> Outbound Reports </h2>
						<?php //echo $query_cdr;        ?>
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
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
											<input id="fromDate" name="fromDate" class="form-control hasDatepicker"
												type="date" step="1" value="<?php if (isset ($_GET['fromDate'])) {
													echo $_GET['fromDate'];
												} else {
													echo $prevMonth = date("Y-m-d", $prevMonth);
												}
												?>">

										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">From Time*</label>
											<input id="fromTime" name="fromTime" class="form-control" type="time"
												step="1" value="00:00:00">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
											<input id="toDate" name="toDate" class="form-control hasDatepicker"
												type="date" value="<?php if (isset ($_GET['toDate'])) {
													echo $_GET['toDate'];
												} else {
													echo date('Y-m-d');
												} ?>">
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">To Time*</label>
											<input id="toTime" name="toTime" class="form-control" type="time" step="1"
												value="23:59:59">

										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Disposition</label>
											<select id="disposition" name="disposition" class="form-control">
												<option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == '') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="">All</option>
												<option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'ANSWERED') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="ANSWERED">ANSWERED</option>
												<option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'BUSY') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="BUSY">BUSY</option>
												<!--<option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'FAILED') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="FAILED">FAILED</option>-->
												<option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'NOANSWER') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="NOANSWER">NOANSWER</option>
												<!-- <option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'ABANDON') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="ABANDON">ABANDON</option> -->
												<option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'CHANUNAVAIL') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="CHANUNAVAIL">CHANUNAVAIL</option>
												<!-- <option <?php if (isset ($_GET['disposition']) && $_GET['disposition'] == 'TIMEOUT') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="TIMEOUT">TIMEOUT</option> -->
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Destination</label>
											<select id="destination" name="destination" class="form-control">
												<option value="">All</option>
												<?php while ($country = mysqli_fetch_array($result_destination)) {
													if ($country['countryprefix'] > 0) {
														$destination_arr[$country['countryprefix']] = $country['countryname'];
													}

													?>
													<option <?php if (isset ($_GET['destination']) && $_GET['destination'] == $country['countryprefix']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $country['countryprefix']; ?>">
														<?php echo $country['countryname']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<div class="col-md-3">
											<div class="form-group">
												<label for="text-input" class=" form-control-label"
													style="color:black;margin-left:0px;font-weight:bold;">User</label>
												<select id="user" name="user" class="form-control">
													<option value="">All</option>
													<?php while ($user_row = mysqli_fetch_array($user_result)) {
														$user_array[$user_row['id']] = $user_row['name'];
														?>
														<option <?php if (isset ($_GET['user']) && $_GET['user'] == $user_row['name']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="<?php echo $user_row['name']; ?>">
															<?php echo $user_row['name']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php } ?>
									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Phone No.</label>
											<input id="phno" name="phno" class="form-control" type="text"
												value="<?php echo isset ($_GET['phno']) ? $_GET['phno'] : ''; ?>">
										</div>
									</div>

									<div class="col-md-3" style="float:right;">
										<div class="form-group" style="float:right;">
											<button type="submit" style="margin-top: 38px;" name="submit" value="submit"
												class="btn btn-primary btn-sm">Submit</button>
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
										<h3>To Download the Outbound Report Click The Download CSV Button</h3>
									</div>
									<div class="col-sm-3"><button type="submit" id="export" name="export" value="submit"
											class="btn btn-primary btn-sm"
											style="font-size:22px;line-height: 32px;margin-top: 12px;">Download CSV</button>
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
					<div
						class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate report_claasic_tble">
						<table id="queueTable" class="table manage_queue_table">
							<thead>

								<tr>
									<th>Serial No</th>
									<th>Date</th>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<th>Agent Name</th>
									<?php } ?>
									<th>Caller ID</th>
									<th>Phone No</th>
									<th>Country</th>
									<th>Disposition</th>
									<th>Duration</th>
									<th>Cost</th>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<th>Trunk IP</th>
									<?php } ?>
									<th>Codec</th>
									<!-- <th>Cost</th> -->
									<th>Recordings</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if (isset ($_GET['submit'])) {
									if (mysqli_num_rows($result_queue_cdr) > 0) {

										?>
										<tr class="tr-shadow">
											<?php
											$i = 1;
											while ($row_cdr = mysqli_fetch_array($result_queue_cdr)) {
												if ($_SESSION['userroleforpage'] !== '1') {
													$newDate = timezone($row_cdr['calldate']);
												} else {
													$newDate = $row_cdr['calldate'];
												}
												if ($_SESSION['userroleforpage'] == 1) {
													$query_trunk = "SELECT trunkcode FROM `cc_trunk` where id_trunk='" . $row_cdr['id_trunk'] . "'";
													$result_trunk = mysqli_query($connection, $query_trunk);
													$trunk_row = mysqli_fetch_array($result_trunk);
												}
												?>
												<td>
													<?php echo $i; ?>
												</td>
												<td>
													<?php echo $newDate; ?>
												</td>
												<?php if ($_SESSION['userroleforpage'] == 1) { ?>
													<td>
														<?php echo isset ($user_array[$row_cdr['accountcode']]) ? $user_array[$row_cdr['accountcode']] : ''; ?>
													</td>
												<?php } ?>
												<td>
													<?php echo $row_cdr['clid']; ?>
												</td>

												<td>
													<?php echo $row_cdr['dst']; ?>
												</td>
												<td>
													<?php echo $row_cdr['userfield']; ?>
												</td>
												<td>
													<?php echo $row_cdr['disposition']; ?>
												</td>
												<td>
													<?php echo seconds2human($row_cdr['billsec']); ?>
												</td>
												<td>
													<?php echo $row_cdr['BILLING']; ?>
												</td>
												<?php if ($_SESSION['userroleforpage'] == 1) { ?>

													<td>
														<?php echo $row_cdr['trunkip']; ?>
													</td>
												<?php } ?>

												<td>
													<?php echo $row_cdr['codec']; ?>
												</td>

												<td><audio type="audio/wav" src="https://portal-myphonesystems-recordings.s3.ap-south-1.amazonaws.com/<?php echo date('Y-m-d', strtotime($row_cdr['calldate'])); ?>/<?php
													if ($row_cdr['disposition'] == 'ANSWERED') {
														echo $row_cdr['recordingfile'];
													} else {
														echo '';
													}
													?>" controls="" controlslist="nodownload"> </audio></td>
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

			<!-- code will write here start-->
			<!-- code will write here end -->

		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#export').click(function (event) {
			event.preventDefault();
			var formData = $('#classicReportForm').serialize();
			// console.log(formData);
			$.ajax({
				url: 'outboundReportdownload.php',
				method: 'GET',
				data: formData,
				success: function (response) {
					var downloadLink = document.createElement('a');
					downloadLink.href = 'outboundReportdownload.php?' + formData;
					downloadLink.download = 'outbound_report.csv';
					downloadLink.click();
				}
			});
		});
	});
</script>
<?php require_once ('footer.php'); ?>