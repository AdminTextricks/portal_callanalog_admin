<?php
require_once ('header.php');

$urlcode = '';
$page_no = 1;
$total_no_of_pages = 1;
if (isset($_GET['submit'])) {
	$fromDate = $_GET['fromDate'];
	$fromTime = $_GET['fromTime'];

	$fromdates = $fromDate . ' ' . $fromTime;

	$toDate = $_GET['toDate'];
	$toTime = $_GET['toTime'];

	$todates = $toDate . ' ' . $toTime;

	// echo '<pre>'; print_r($_GET); 	print_r($_SESSION); die;//exit;

	if (strlen($_GET['invoice_id']) > 0) {
		$invoice_id = 'and gpay.gatway_invoice_id = "' . $_GET['invoice_id'] . '"';
	} else {
		$invoice_id = '';
	}

	$item_type = $_GET['item_type'];
	if (strlen($_GET['item_type']) > 0) {
		$item_type = "and gpay.item_type='" . $item_type . "'";
	} else {
		$item_type = '';
	}

	$payment_status = $_GET['payment_status'];
	if (strlen($_GET['payment_status']) > 0) {
		$payment_status = "and invo.payment_status='" . $payment_status . "'";
	} else {
		$payment_status = '';
	}

	$payment_type = $_GET['payment_type'];
	if (strlen($_GET['payment_type']) > 0) {
		$payment_type = "and gpay.payment_type='" . $payment_type . "'";
	} else {
		$payment_type = '';
	}

	//$user_id = $_GET['user_id'];	
	if (isset($_GET['user_id']) && strlen($_GET['user_id']) > 0) {
		$user_id = "and gpay.user_id='" . $_GET['user_id'] . "'";
	} else {
		$user_id = '';
	}


	$_SESSION['login_user'];
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

	$total_records_per_page = 25;
	$offset = ($page_no - 1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";
	if ($_SESSION['userroleforpage'] == 1) {
		$query_tra_pagination = "SELECT count(gpay.id) FROM `gateways_payments` as gpay LEFT JOIN invoices as invo ON gpay.invoice_db_id = invo.id where created between '" . $fromdates . "' and '" . $todates . "' " . $invoice_id . " " . $item_type . " " . $payment_status . " " . $payment_type . " " . $user_id . "";
	} else {
		$query_tra_pagination = "SELECT count(gpay.id) FROM `gateways_payments` as gpay LEFT JOIN invoices as invo ON gpay.invoice_db_id = invo.id where created between '" . $fromdates . "' and '" . $todates . "' " . $invoice_id . " " . $item_type . " " . $payment_status . " " . $payment_type . "  AND gpay.user_id='" . $_SESSION['login_user_id'] . "'";
	}
	$result_queue_tra_pagination = mysqli_query($connection, $query_tra_pagination);
	if (mysqli_num_rows($result_queue_tra_pagination) > 0) {
		$row_pagins = mysqli_fetch_row($result_queue_tra_pagination);
		$total_pagins_records = $row_pagins[0];
	} else {
		$total_pagins_records = 0;
	}
	$total_no_of_pages = ceil($total_pagins_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;

	if ($_SESSION['userroleforpage'] == 1) {
		$query_tra = "SELECT gpay.user_id, gpay.invoice_db_id,gpay.gatway_invoice_id, gpay.gatway_order_id, gpay.payment_type, gpay.item_type, gpay.name, gpay.email, gpay.paid_amount, invo.payment_status, gpay.created  FROM `gateways_payments` as gpay LEFT JOIN invoices as invo ON gpay.invoice_db_id = invo.id where gpay.created between '" . $fromdates . "' and '" . $todates . "' " . $invoice_id . " " . $item_type . " " . $payment_status . " " . $payment_type . " " . $user_id . "  order by gpay.id DESC limit " . $offset . ", " . $total_records_per_page . "";
	} else {
		$query_tra = "SELECT gpay.user_id, gpay.invoice_db_id,gpay.gatway_invoice_id, gpay.gatway_order_id, gpay.payment_type, gpay.item_type, gpay.name, gpay.email, gpay.paid_amount, invo.payment_status, gpay.created  FROM `gateways_payments` as gpay LEFT JOIN invoices as invo ON gpay.invoice_db_id = invo.id where gpay.created between '" . $fromdates . "' and '" . $todates . "' " . $invoice_id . " " . $item_type . " " . $payment_status . " " . $payment_type . " AND gpay.user_id='" . $_SESSION['login_user_id'] . "'  order by gpay.id DESC limit " . $offset . ", " . $total_records_per_page . "";
	}

	// echo $query_tra; exit;
	$result_queue_tra = mysqli_query($connection, $query_tra);

	$urlcode = 'fromDate=' . $_GET['fromDate'] . '&fromTime=' . $_GET['fromTime'] . '&toDate=' . $_GET['toDate'] . '&toTime=' . $_GET['toTime'] . '&submit=' . $_GET['submit'] . '&showRecords=' . $_GET['showRecords'] . '&pageNumber=' . $_GET['pageNumber'] . '&payment_type=' . $_GET['payment_type'] . '&payment_status=' . $_GET['payment_status'] . '&item_type=' . $_GET['item_type'] . '&invoice_id=' . $_GET['invoice_id'] . '';

}

if ($_SESSION['userroleforpage'] == 1) {
	$query_user = "select * from users_login where role='2' or role='3'";
	$result_user = mysqli_query($connection, $query_user);
}
?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Transaction Reports </h2><?php //echo $query_cdr; ?>
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
												type="date" step="1"
												value="<?php if(isset($_GET['fromDate'])) { echo $_GET['fromDate']; } else { echo date('Y-m-d'); }?>">

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
												type="date"
												value="<?php if(isset($_GET['toDate'])) { echo $_GET['toDate']; } else { echo date('Y-m-d'); }?>">
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
												style="color:black;margin-left:0px;font-weight:bold;">Payment
												Type</label>
											<select id="payment_type" name="payment_type" class="form-control">
												<option <?php if (isset($_GET['payment_type']) && $_GET['payment_type'] == '') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="">All</option>
												<option <?php if (isset($_GET['payment_type']) && $_GET['payment_type'] == 'Wallet') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Wallet">Wallet</option>
												<option <?php if (isset($_GET['payment_type']) && $_GET['payment_type'] == 'Pay') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Pay">Card</option>
												<option <?php if (isset($_GET['payment_type']) && $_GET['payment_type'] == 'Free By Admin') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Free By Admin">
													Free By Admin</option>
												<option <?php if (isset($_GET['payment_type']) && $_GET['payment_type'] == 'Free By User') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Free By User">Free By User</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Payment
												Status</label>
											<select id="payment_status" name="payment_status" class="form-control">
												<option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == '') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="">All</option>
												<option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'Unpaid') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Unpaid">Unpaid</option>
												<option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'Paid') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Paid">Paid</option>
												<option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'Free') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="Free">Free</option>
											</select>
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Item Type</label>
											<select id="item_type" name="item_type" class="form-control">
												<option value="">All</option>
												<option <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'DID') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?>
													value="<?php echo 'DID' ?>"><?php echo 'DID'; ?></option>
												<option <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'Extension') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="<?php echo 'Extension' ?>">
													<?php echo 'Extension'; ?></option>
												<option <?php if (isset($_GET['item_type']) && $_GET['item_type'] == 'Wallet Credit') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="<?php echo 'Wallet Credit' ?>">
													<?php echo 'Wallet Credit'; ?></option>
											</select>
										</div>
									</div>
									<?php /*
									  <div class="col-md-3">
										  <div class="form-group">
											  <label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Extension</label>
											  <select id="extension" name="extension" class="form-control">
											  <option value="">All</option>
											  <?php while($extrow = mysqli_fetch_array($extenion_result)) { ?>
											  <option <?php if($_GET['extension']==$extrow['name'] ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $extrow['name']; ?>"><?php echo $extrow['name']; ?></option>
											  <?php } ?>
											  </select>
										  </div>
									  </div>

									  <div class="col-md-3">
										  <div class="form-group">
											  <label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">DID/TFN</label>
											  <select id="DID" name="DID" class="form-control">
											  <option value="">All</option>
											  <?php while($rowtfns = mysqli_fetch_array($did_result)) { ?>
											  <option <?php if($_GET['DID']==$rowtfns['did'] ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $rowtfns['did']; ?>"><?php echo $rowtfns['did']; ?></option>
											  <?php } ?>
											  </select>
										  </div>
									  </div>
					  */
									if ($_SESSION['userroleforpage'] == 1) { ?>
										<div class="col-md-3">
											<div class="form-group">
												<label for="text-input" class=" form-control-label"
													style="color:black;margin-left:0px;font-weight:bold;">User</label>
												<select id="user_id" name="user_id" class="form-control selectpicker"
													data-show-subtext="false" data-live-search="true">
													<option value="">All</option>
													<?php while ($row_user = mysqli_fetch_array($result_user)) { ?>
														<option <?php if (isset($_GET['user_id']) && $_GET['user_id'] == $row_user['id']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="<?php echo $row_user['id']; ?>">
															<?php echo $row_user['name'].'/'.$row_user['email']; ?></option>
													<?php } ?>
												</select>
											</div>
										</div>
									<?php } ?>
									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Invoice ID</label>
											<input id="invoice_id" name="invoice_id" class="form-control" type="text"
												value="<?php echo isset($_GET['invoice_id']) ? $_GET['invoice_id'] : ''; ?>">
										</div>
									</div>


									<div class="col-md-3" style="float:right;">
										<div class="form-group" style="float:right;">
											<button type="submit" style="margin-top: 38px;" name="submit" value="submit"
												class="btn btn-primary btn-sm">Submit</button>

											<!-- <input type="submit" value="Download CSV" name="export" id="export"  class="button"> -->
										</div>
									</div>
									<p></p>
								</div>
								<input id="showRecords" name="showRecords" type="hidden" value="10">
								<input id="pageNumber" name="pageNumber" type="hidden" value="1">



								<div class="col-md-12">
									<?php if (mysqli_num_rows($result_queue_tra) > 0) { ?>
										<hr>
										<div class="form-group row">
											<div class="col-sm-9">
												<h3>To Download the Transaction Report Click The Download CSV Button</h3>
											</div>
											<div class="col-sm-3"><button type="submit" id="export" name="export"
													value="submit" class="btn btn-primary btn-sm"
													style="font-size:22px;line-height: 32px;margin-top: 12px;">Download
													CSV</button></div>
										</div>
									<?php } else {
										echo ''; ?>

									<?php } ?>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
			<script>


				$(document).ready(function () {
					$('#export').click(function (event) {
						event.preventDefault();
						var formData = $('#classicReportForm').serialize();

						$.ajax({
							url: 'transactionReportdownload.php',
							method: 'GET',
							data: formData,
							success: function (response) {
								var downloadLink = document.createElement('a');
								downloadLink.href = 'transactionReportdownload.php?' + formData;
								downloadLink.download = 'transaction_report.csv';
								downloadLink.click();
							}
						});
					});
				});


			</script>


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
									<th>Invoice Id</th>
									<th>Payment Type</th>
									<th>Item Type</th>
									<th>User Name</th>
									<th>User Email</th>
									<th>Paid Amount</th>
									<th>Status</th>
								</tr>
							</thead>

							<tbody>
								<?php
								if (isset($_GET['submit'])) {
									if (mysqli_num_rows($result_queue_tra) > 0) { ?>
										<tr class="tr-shadow">
											<?php
											$i = 1;
											while ($row_tra = mysqli_fetch_assoc($result_queue_tra)) {
												//echo '<pre>'; print_r($row_tra);exit;
									
												?>
												<td><?php echo $i; ?></td>
												<td><?php echo $row_tra['created']; ?></td>
												<td><?php echo $row_tra['gatway_invoice_id']; ?></td>
												<td><?php echo $row_tra['payment_type']; ?></td>
												<td><?php echo $row_tra['item_type']; ?></td>
												<td><?php echo $row_tra['name']; ?></td>
												<td><?php echo $row_tra['email']; ?></td>
												<td><?php echo $row_tra['paid_amount']; ?></td>
												<td><?php if ($row_tra['payment_status'] == 'success') {
													echo 'Paid';
												} else {
													echo $row_tra['payment_status'];
												} ?>
												</td>
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
						<strong>Showing <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
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
<?php require_once ('footer.php'); ?>