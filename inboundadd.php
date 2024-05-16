<?php require_once ('header.php');

$destination_type_arr = array();
$select_destination = "SELECT * FROM `cc_selection_did`";
$res_destination = mysqli_query($connection, $select_destination);
while ($row_desti = mysqli_fetch_array($res_destination)) {
	$destination_type_arr[$row_desti['id']] = $row_desti['selection_value'];
}

// echo '<pre>';print_r($destination_type_arr);exit;

$message = '';
if (isset($_POST['selectedUser'])) {
	$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "'";
	$result_user = mysqli_query($connection, $query_user);
	$userDetails = mysqli_fetch_assoc($result_user);

} else {
	$_POST['clientId'] = '';
}


$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);

$query_sip = "select * from cc_sip_buddies";
$result_sip = mysqli_query($connection, $query_sip);


if (isset($_POST['submit'])) {
	//  echo '<pre>';print_r($_POST);
	$sch_call = isset($_POST['sch_call']) ? $_POST['sch_call'] : "";
	$starttime = $_POST['starttime'];
	$stoptime = $_POST['stoptime'];
	$startday = $_POST['startday'];
	$stopday = $_POST['stopday'];
	$all_time = $_POST['all_time'];
	$ply_back = $_POST['playback'];

	$clientId = $_POST['clientId'];
	$selectedUser = $_POST['selectedUser'];
	$did_or_tfn = $_POST['did_or_tfn'];
	$carieer = $_POST['carieer'];
	$destination_type = $_POST['destination_type'];
	$destination = $_POST['destination'];
	$status = $_POST['status'];
	$callScreenAction = $_POST['callScreenAction'];
	$forwardDestType = $_POST['forwardDestType'];
	$forwardDest = isset($_POST['forwardDest']) ? $_POST['forwardDest'] : "";
	$ivr = isset($_POST['ivr']) ? $_POST['ivr'] : "";
	$playWelcomeMessage = $_POST['playWelcomeMessage'];
	$welcomeMessage = $_POST['welcomeMessage'];
	$payment = $_POST['payment'];
	$error = 'false';

	$did_query = "SELECT `did` FROM `cc_did` WHERE `id` ='" . $did_or_tfn . "'";

	$did_result = mysqli_query($connection, $did_query);
	if (mysqli_num_rows($did_result) > 0) {
		$did_row = mysqli_fetch_assoc($did_result);
		$did_num = $did_row['did'];
	}

	$dest_types = $destination_type_arr[$destination_type];
	$didids = $did_or_tfn;
	$user_plan_id = $userDetails['plan_id'];
	$startingdate = date('Y-m-d H:i:s');
	$expirationdate = date('Y-m-d H:i:s', strtotime('+1 month'));


	if ($payment == '0') {
		$price = 0;
		$payment_status = 'Free';
	} else {
		if($userDetails['role']==3){
			$userId = $_POST['selectedUser'];
		}else{
			$userId = '0';
		}
		$payment_status = "Paid";
		$query_price = "select * from cc_did_exten_price WHERE type='did' and user_id = '".$userId."'";
		$result_price = mysqli_query($connection, $query_price);
		if (mysqli_num_rows($result_price) > 0) {
			$rowPrice = mysqli_fetch_array($result_price);
			$price = $rowPrice['price'];
		}
	}
	$select_cust_credit = "select credit from cc_card where id='" . $_POST['selectedUser'] . "'";
	$result_cust = mysqli_query($connection, $select_cust_credit);

	$rowcredit = mysqli_fetch_assoc($result_cust);
	$current_credit = $rowcredit['credit'];
	// echo $current_credit;exit;

	if ($price > $current_credit) {
		$message = "Not Enough Credit";
		$error = 'true';
	} else {
		$updated_credit = $current_credit - $price;
		$update_credit = "update cc_card set credit='" . $updated_credit . "' where id='" . $_POST['selectedUser'] . "'";
		$resultupdate = mysqli_query($connection, $update_credit);
		$invoice_amount = $price;

	}

	if ($error == 'false') {
		$quantity = 1;
		$item_type = 'DID';
		$update_did = "update cc_did set iduser = '" . $selectedUser . "', billingtype='" . $user_plan_id . "', activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active', call_screening_action='" . $callScreenAction . "', call_destination='" . $destination . "', carieer='" . $carieer . "', didtype='" . $destination_type . "', clientId='" . $clientId . "', screen_status='" . $playWelcomeMessage . "', playback='" . $welcomeMessage . "' where id ='" . $didids . "'";
		$result_didupdate = mysqli_query($connection, $update_did);

		if ($sch_call == 1) {
			$insert_destination = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`, `sch_call`, `starttime`, `stoptime`, `startday`, `stopday`, `all_time`, `playback`) VALUES ( '" . $destination . "', '" . $dest_types . "', '1', '" . $selectedUser . "', '" . $didids . "','1','1', '" . $sch_call . "', '" . $starttime . "','" . $stoptime . "', '" . $startday . "', '" . $stopday . "', '" . $all_time . "', '" . $ply_back . "')";
		} else {
			$insert_destination = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`, `sch_call`, `starttime`, `stoptime`, `startday`, `stopday`, `all_time`, `playback`) VALUES ( '" . $destination . "', '" . $dest_types . "', '1', '" . $selectedUser . "', '" . $didids . "','1','1', '0', '0','0', '0', '0', '1', '0')";
		}
		$result_destination = mysqli_query($connection, $insert_destination);
		if (!empty($forwardDestType) and !empty($forwardDest)) {

			$dest_types = $destination_type_arr[$forwardDestType];

			$insert_destination_pri2 = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`, `sch_call`, `starttime`, `stoptime`, `startday`, `stopday`, `all_time`, `playback`) VALUES ( '" . $forwardDest . "', '" . $forwardDestType . "', '2', '" . $selectedUser . "', '" . $didids . "','1','1', '" . $sch_call . "', '" . $starttime . "','" . $stoptime . "', '" . $startday . "', '" . $stopday . "', '" . $all_time . "', '" . $ply_back . "')";
			$result_destination_pri2 = mysqli_query($connection, $insert_destination_pri2);
		}

		if ($result_destination) {
			/******** Create DID purchase history */

			$insert_did_history = "INSERT INTO `did_buying_history` ( `user_id`, `clientId`, `did_id`, `purchase_date`, `expiry_date`) VALUES ( '" . $selectedUser . "', '" . $clientId . "', '" . $didids . "', '" . $startingdate . "','" . $expirationdate . "')";
			$result_did_history = mysqli_query($connection, $insert_did_history);

			/******** Create invoice when added by admin */
			//echo '<pre>'; print_r($_POST); echo '</pre>';
			$query_inv = "select max(id) as id from invoices";
			$result_inv = mysqli_query($connection, $query_inv);
			if (mysqli_num_rows($result_inv) > 0) {
				$rowid = mysqli_fetch_array($result_inv);
				$nn = $rowid['id'] + 1;
				$invoice_id = "INV/" . date('Y') . "/000" . $nn;
			} else {
				$invoice_id = 'INV/' . date("Y") . '/00001';
			}

			$user_id = $_POST['selectedUser'];
			$user_plan_id = $userDetails['plan_id'];
			$invoice_currency = 'USD';
			$item_number = '';
			$query_did = "select did from cc_did where id='" . $didids . "'";
			$result_did = mysqli_query($connection, $query_did);
			if (mysqli_num_rows($result_did) > 0) {
				$rowDid = mysqli_fetch_array($result_did);
				$item_number = $rowDid['did'];
			}

			$insert_invoice = "insert into 	invoices (user_id, invoice_id, item_type, invoice_currency, invoice_amount, invoice_subtotal_amount,payment_status) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $item_type . "','" . $invoice_currency . "','" . $invoice_amount . "','" . $invoice_amount . "','" . $payment_status . "')";
			$query_res = mysqli_query($con, $insert_invoice);
			$invoice_db_id = mysqli_insert_id($con);

			$item_price = $invoice_amount;

			$insert_invoice_item = "insert into invoices_items (invoice_id, item_type, item_number, price) VALUES ('" . $invoice_db_id . "','" . $item_type . "','" . $item_number . "','" . $item_price . "')";
			$query_res_invo = mysqli_query($con, $insert_invoice_item);

			$gatway_order_id = $invoice_id . '-UID-' . $user_id;
			if ($payment == '1') {
				$payment_type = 'Wallet';
			} else {
				$payment_type = 'Free by Admin';
			}
			$user_name = $userDetails['name'];
			$email = $userDetails['email'];
			$insert_invoice = "insert into gateways_payments (user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('" . $user_id . "','" . $invoice_db_id . "','" . $invoice_id . "', '" . $gatway_order_id . "','" . $payment_type . "','" . $item_type . "','" . $user_name . "','" . $email . "','Stripe Myphonesystems', '" . $item_number . "','" . $invoice_amount . "','" . $invoice_currency . "','success','" . date('Y-m-d H:i:s') . "')";
			$query_res = mysqli_query($con, $insert_invoice);
			$invo_id = mysqli_insert_id($con);

			/******   END   ******* */

			$activity_type = 'DID Assign To user';
			$msg = 'DID No: ' . $did_num . ' ' . 'DID Assign to user Succesfully!' . ' ' . $payment_status . ' ' . 'By Admin';
			user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);

			$_SESSION['msg'] = "Inbound Added Successfully";
			make_pdf($invoice_db_id, $_POST['selectedUser']);
			echo '<script>window.location.href="inbound.php"</script>';
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
						<h2 class="title-1"> Inbound Add <span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="inbound.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i> Inbound</button>
							</a>
							<?php //print_r($_POST);     ?>
						</div>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="inboundForm" name="inboundadd" action="" method="post">
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Client Name</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="clientId" name="clientId" onchange="showUsercredit(this.value)"
											data-show-subtext="false" data-live-search="true"
											class="form-control selectpicker" required>
											<option value="" selected="selected">Select</option>
											<?php while ($row = mysqli_fetch_array($result_client)) { ?>
												<option <?php if ($row['clientId'] == $_POST['clientId']) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?>
													value="<?php echo $row['clientId']; ?>">
													<?php echo $row['clientName'] . '/' . $row['clientEmail']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Select User</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="selectedUser" name="selectedUser" class="form-control" required>
											<option value="0">Select</option>
											<?php if (isset($_POST['selectedUser'])) {
												$row_user = $userDetails;

												if ($row_user['id'] == $_POST['selectedUser']) {
													$select = "selected";
												} else {
													$select = '';
												}
												?>
												<option <?php echo $select; ?> value="<?php echo $row_user['id']; ?>">
													<?php echo $row_user['name']; ?>
												</option>
												<?php
											} ?>
										</select>
										<strong>Credit Available : <span id="txtHint">0.0</span></strong>
									</div>
								</div>


								<div class="row form-group">
									<div class="col col-md-4">
										<label for="selectSm" class=" form-control-label">Starting 3 digits*</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="numberpool" name="numberpool" class="form-control-sm form-control">
											<option value="" selected="selected">Select</option>
											<option value="">All</option>
											<?php
											foreach ($numberpool as $value) { ?>
												<option <?php if (isset($_POST['numberpool']) && $_POST['numberpool'] == $value) {
													echo 'selected="selected"';
												} ?>
													value="<?php echo $value; ?>">
													<?php echo $value; ?>
												</option>
											<?php } ?>

										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">DID Or TFN *</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="did_or_tfn" name="did_or_tfn" class="form-control" required>
											<option value="">Select</option>
											<?php
											if (isset($_POST['did_or_tfn'])) {
												$select_match_tfn = "SELECT id, did FROM `cc_did` where id = '" . $_POST['did_or_tfn'] . "'";
												$result_tfn_match = mysqli_query($connection, $select_match_tfn);
												while ($row_tfn = mysqli_fetch_array($result_tfn_match)) { ?>
													<option <?php if ($row_tfn['id'] == $_POST['did_or_tfn']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $row_tfn['id']; ?>">
														<?php echo $row_tfn['did']; ?>
													</option>
												<?php }
											} ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Carieer</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="carieer" name="carieer" class="form-control" required>
											<option value="">Select</option>
											<?php foreach ($did_provider as $value) { ?>
												<option <?php if (isset($_POST['did_provider']) && $_POST['did_provider'] == $value) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="<?php echo $value; ?>">
													<?php echo $value; ?>
												</option>
											<?php } ?>

										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Destination Action</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="destination_type" name="destination_type" class="form-control"
											onchange="showUser(this.value)" required>
											<option value="NONE">Select</option>
											<?php
											foreach ($destination_type_arr as $key => $row_desti) { ?>
												<option <?php if (isset($_POST['destination_type']) && $key == $_POST['destination_type']) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="<?php echo $key; ?>">
													<?php echo $row_desti; ?>
												</option>
											<?php } ?>

										</select>
									</div>
								</div>
								<script>
									$(document).ready(function () {
										function loadDid_tfn(digits, user_id) {
											$.ajax({
												url: "loadDid_tfn.php",
												type: "POST",
												data: { digit: digits, user_id: user_id },
												success: function (data) {
													$("#did_or_tfn").html(data);
												}
											});
										}

										$("#numberpool").on("change", function () {
											var digit = $("#numberpool").val();
											var user_id = $("#selectedUser").val();
											// alert(user_id);
											loadDid_tfn(digit, user_id);
										});

										function loadCarrier(did) {
											$.ajax({
												url: "loadCarrier.php",
												type: "POST",
												data: { did: did },
												success: function (data) {
													$("#carieer").html(data);
												}
											});
										}

										$("#did_or_tfn").on("change", function () {
											var did = $("#did_or_tfn").val();
											loadCarrier(did);
										});
									});
								</script>


								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Destination</label>
									</div>

									<div class="col-12 col-md-8" id="destinationSelect">
										<select id="destination" name="destination" class="form-control">
										</select>
										<?php if (isset($_POST['destination'])) {

											if ($_POST['destination_type'] == 1) {
												$query_queue = "select * from cc_queue_table where assigned_user='" . $_POST['selectedUser'] . "'";
												$result_queue = mysqli_query($connection, $query_queue); ?>
												<select id="destination" name="destination" class="form-control">
													<?php while ($row_sip = mysqli_fetch_array($result_queue)) { ?>
														<option <?php if (isset($_POST['destination']) && $row_sip["name"] == $_POST['destination']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="<?php echo $row_sip['name']; ?>">
															<?php echo $row_sip['name']; ?>
														</option>
													<?php } ?>
												</select>
											<?php } elseif ($_POST['destination_type'] == 2) {
												$query_ext = "select * from cc_sip_buddies where id_cc_card='" . $_POST['selectedUser'] . "'";
												$result_ext = mysqli_query($connection, $query_ext); ?>
												<select id="destination" name="destination" class="form-control">
													<?php while ($row_ext = mysqli_fetch_array($result_ext)) { ?>
														<option <?php if (isset($_POST['destination']) && $row_ext['name'] == $_POST['destination']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="<?php echo $row_ext['name']; ?>">
															<?php echo $row_ext['name']; ?>
														</option>
													<?php } ?>
												</select>
												<?php
											} elseif ($_POST['destination_type'] == 3) {
												$query_vm = "select * from cc_voicemail_users where customer_id='" . $_POST['selectedUser'] . "'";
												$result_vm = mysqli_query($connection, $query_vm); ?>
												<select id="destination" name="destination" class="form-control">
													<?php while ($row_ext = mysqli_fetch_array($result_vm)) { ?>
														<option <?php if (isset($_POST['destination']) && $row_ext['mailbox'] == $_POST['destination']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_ext['mailbox']; ?>">
															<?php echo $row_ext['mailbox']; ?>
														</option>
													<?php } ?>
												</select>
												<?php
											} elseif ($_POST['destination_type'] == 5) {

												$query_booking = "select * from booking where user_id='" . $_POST['selectedUser'] . "'";
												$result_booking = mysqli_query($connection, $query_booking); ?>

												<select id="destination" name="destination" class="form-control">
													<?php while ($row_book = mysqli_fetch_array($result_booking)) { ?>
														<option <?php if (isset($_POST['destination']) && $row_book['confno'] == $_POST['destination']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_book['confno']; ?>">
															<?php echo $row_book['confno']; ?>
														</option>
													<?php } ?>
												</select>
												<?php
												//echo '<input type="text" id="destination" name="destination" class="form-control" value="'.$_POST['destination'].'" placeholder="Enter IP">';
											} elseif ($_POST['destination_type'] == 6) {

												$query_ring = "select * from cc_ring_group where user_id='" . $_POST['selectedUser'] . "'";
												$result_ring = mysqli_query($connection, $query_ring); ?>
												<select id="destination" name="destination" class="form-control">
													<?php while ($row_ring = mysqli_fetch_array($result_ring)) { ?>
														<option <?php if (isset($_POST['destination']) && $row_ring['ringno'] == $_POST['destination']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_ring['ringno']; ?>">
															<?php echo $row_ring['ringno']; ?>
														</option>
													<?php } ?>
												</select>
												<?php
											} else { ?>
												<input type="text" id="destination" name="destination" class="form-control"
													value="<?php echo isset($_POST['destination']) ? $_POST['destination'] : ''; ?>">
											<?php }

										} ?>
									</div>
								</div>


								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Status</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="status" name="status" class="form-control">
											<option <?php if (isset($_POST['status']) && $_POST['status'] == 'Active') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Active">Active
											</option>
											<option <?php if (isset($_POST['status']) && $_POST['status'] == 'Inactive') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Inactive">
												Inactive</option>
											<option <?php if (isset($_POST['status']) && $_POST['status'] == 'Suspended') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Suspended">
												Suspended</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Call Screen Action</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="callScreenAction" name="callScreenAction" class="form-control">
											<option <?php if (isset($_POST['callScreenAction']) && $_POST['callScreenAction'] == '1') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="1">Ring</option>
											<option <?php if (isset($_POST['callScreenAction']) && $_POST['callScreenAction'] == '9') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="9">Hangup</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Play Welcome Message</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="playWelcomeMessage" name="playWelcomeMessage" class="form-control">
											<option <?php if (isset($_POST['playWelcomeMessage']) && $_POST['playWelcomeMessage'] == '0') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="0">No</option>
											<option <?php if (isset($_POST['playWelcomeMessage']) && $_POST['playWelcomeMessage'] == '1') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="1">Yes</option>
										</select>
									</div>
								</div>
								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label"> Payment Type</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="inline-tariff1" class="form-check-label"
												style="margin-right:15px; color:black;">
												<input id="inline-tariff1" name="payment" class="form-check-input"
													type="radio" value="0" <?php if (isset($_POST['payment']) && $_POST['payment'] == '0') {
														echo "checked";
													} ?> /> Free
											</label>
											<label for="inline-tariff2" class="form-check-label" style="color:black;">
												<input id="inline-tariff2" name="payment" class="form-check-input"
													checked="checked" type="radio" value="1" <?php if (isset($_POST['payment']) && $_POST['payment'] == '1') {
														echo "checked";
													} ?> />
												Paid
											</label>
										</div>
									</div>
								</div>

								<div class="row form-group" id="welcomeMessageInput" <?php if (isset($_POST['playWelcomeMessage']) && $_POST['playWelcomeMessage'] == '1') { ?>
										style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Welcome Message</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="welcomeMessage" name="welcomeMessage"
											placeholder="Type Your Welcome message" class="form-control" type="text"
											value="<?php if (isset($_POST['welcomeMessage'])) {
												echo $_POST['welcomeMessage'];
											} else {
												echo '';
											} ?>" />
									</div>
								</div>

								<div class="advance_opt" style="display:none;">
									<h4 class="advance_opt_toggle">Advance Options</h4>

									<div class="advance_opt_form" style="display:none;">


										<div class="row form-group">
											<div class="col col-md-4">
												<label for="selectSm" class=" form-control-label">Failover Destination
													Type</label>
											</div>
											<div class="col-12 col-md-8">
												<select id="forwardDestType" onchange="showUseradv(this.value)"
													name="forwardDestType" class="form-control">
													<option value="NONE">------SELECT------</option>
													<?php
													foreach ($destination_type_arr as $key => $row_desti) { ?>
														<option <?php if (isset($_POST['forwardDestType']) && $key == $_POST['forwardDestType']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="<?php echo $key; ?>">
															<?php echo $row_desti; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class="form-control-label">Failover
													Destination</label>
											</div>
											<div class="col-12 col-md-8" id="forwarddestSelect">
												<?php if (isset($_POST['forwardDest'])) {

													if ($_POST['forwardDestType'] == 1) {
														$query_queue = "select * from cc_queue_table where assigned_user='" . $_POST['selectedUser'] . "'";
														$result_queue = mysqli_query($connection, $query_queue); ?>

														<select id="forwardDest" name="forwardDest" class="form-control">
															<?php
															while ($row_sip = mysqli_fetch_array($result_queue)) { ?>

																<option <?php if (isset($_POST['forwardDest']) && $row_sip["name"] == $_POST['forwardDest']) {
																	echo 'selected="selected"';
																} else {
																	echo '';
																} ?> value=<?php echo $row_sip["name"]; ?>><?php echo $row_sip["name"]; ?> </option>
																<?php
															} ?>
														</select>
														<?php
													} elseif ($_POST['forwardDestType'] == 2) {
														$query_ext = "select * from cc_sip_buddies where id_cc_card='" . $_POST['selectedUser'] . "'";
														$result_ext = mysqli_query($connection, $query_ext); ?>

														<select id="forwardDest" name="forwardDest" class="form-control">
															<?php
															while ($row_ext = mysqli_fetch_array($result_ext)) { ?>

																<option <?php if ($row_ext["name"] == $_POST['forwardDest']) {
																	echo 'selected="selected"';
																} else {
																	echo '';
																} ?> value=<?php echo $row_ext["name"]; ?>> <?php echo $row_ext["name"]; ?> </option>
																<?php
															} ?>
														</select>
													<?php } elseif ($_POST['forwardDestType'] == 3) {
														$query_vm = "select * from cc_voicemail_users where customer_id='" . $_POST['selectedUser'] . "'";
														$result_vm = mysqli_query($connection, $query_vm); ?>

														<select id="forwardDest" name="forwardDest" class="form-control">
															<?php while ($row_ext = mysqli_fetch_array($result_vm)) { ?>

																<option <?php if ($row_ext["mailbox"] == $_POST['forwardDest']) {
																	echo 'selected="selected"';
																} else {
																	echo '';
																} ?> value=<?php echo $row_ext["mailbox"]; ?>><?php echo $row_ext["mailbox"]; ?>
																</option>
															<?php } ?>
														</select>
														<?php
													} else { ?>
														<input type="text" id="forwardDest" name="forwardDest"
															class="form-control"
															value=" <?php echo isset($_POST['forwardDest']) ? $_POST['forwardDest'] : ''; ?> ">
													<?php }
												} else { ?>
													<select id="forwardDest" name="forwardDest" class="form-control">
													</select>
												<?php } ?>
											</div>
										</div>
										<div class="row form-group barge_radio_btn">
											<div class="col col-md-4">
												<label class=" form-control-label">Time Schedule</label>
											</div>
											<div class="col col-md-8">
												<div class="form-check-inline form-check">
													<label for="inline-radio1" class="form-check-label"
														style="margin-right: 15px; color: black;">
														<input id="sch_call" type="radio"
															class="showbtn form-check-input" name="sch_call" value="1"
															<?php if (isset($_POST['sch_call']) and $_POST['sch_call'] == '1') {
																echo 'checked';
															} ?>> Yes
													</label>
													<label for="inline-radio2" class="form-check-label"
														style="color: black;">
														<input id="sch_call" type="radio"
															class="hidebtn form-check-input" name="sch_call" value="0"
															<?php if (isset($_POST['sch_call']) and $_POST['sch_call'] == '0') {
																echo 'checked';
															} ?>> No
													</label>
												</div>
											</div>
										</div>


										<div class="showhideForm" id="dataDiv" <?php if (isset($_POST['sch_call']) and $_POST['sch_call'] == '1') {
											echo 'style="display: block;"';
										} else {
											echo 'style="display: none;"';
										} ?>>
											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Start Time</label>
												</div>
												<div class="col-12 col-md-8">
													<input type="time" class="form-control" name="starttime"
														value="<?php echo isset($_POST['starttime']) ? $_POST['starttime'] : ''; ?>"
														id="Test_DatetimeLocal1">
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Stop Time</label>
												</div>
												<div class="col-12 col-md-8">
													<input type="time" class="form-control" name="stoptime"
														value="<?php echo isset($_POST['stoptime']) ? $_POST['stoptime'] : ''; ?>"
														id="Test_DatetimeLocal2">
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Start Day</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="all_time" name="startday" class="form-control">
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "sun") {
															echo 'selected="selected"';
														} ?> value="sun">Sunday</option>
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "mon") {
															echo 'selected="selected"';
														} ?> value="mon">Monday</option>
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "tue") {
															echo 'selected="selected"';
														} ?> value="tue">Tuesday</option>
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "wed") {
															echo 'selected="selected"';
														} ?> value="wed">Wednesday</option>
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "thu") {
															echo 'selected="selected"';
														} ?> value="thu">Thursday</option>
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "fri") {
															echo 'selected="selected"';
														} ?> value="fri">Friday</option>
														<option <?php if (isset($_POST['startday']) && $_POST['startday'] == "sat") {
															echo 'selected="selected"';
														} ?> value="sat">Saturday</option>
													</select>
													<!-- <input type="datetime-local" class="form-control" name="startday" id="Test_DatetimeLocal"> -->
												</div>
											</div>


											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Stop Day</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="all_time" name="stopday" class="form-control">
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "sun") {
															echo 'selected="selected"';
														} ?>
															value="sun">Sunday</option>
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "mon") {
															echo 'selected="selected"';
														} ?>
															value="mon">Monday</option>
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "tue") {
															echo 'selected="selected"';
														} ?>
															value="tue">Tuesday</option>
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "wed") {
															echo 'selected="selected"';
														} ?>
															value="wed">Wednesday</option>
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "thu") {
															echo 'selected="selected"';
														} ?>
															value="thu">Thursday</option>
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "fri") {
															echo 'selected="selected"';
														} ?>
															value="fri">Friday</option>
														<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == "sat") {
															echo 'selected="selected"';
														} ?>
															value="sat">Saturday</option>
													</select>
													<!-- <input type="datetime-local" class="form-control" name="stopday" id="Test_DatetimeLocal"> -->
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">All time</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="all_time" name="all_time" class="form-control">
														<option <?php if (isset($_POST['all_time']) && $_POST['all_time'] == "1") {
															echo 'selected="selected"';
														} ?>
															value="1">Yes</option>
														<option <?php if (isset($_POST['all_time']) && $_POST['all_time'] == "0") {
															echo 'selected="selected"';
														} ?>
															value="0">No</option>
													</select>
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Off Hours
														Messages</label>
												</div>
												<div class="col-12 col-md-8">
													<textarea class="form-control" name="playback"
														id="Test_DatetimeLocal"
														placeholder="Type Your Off Hours Messages"
														rowspan="4"><?php echo isset($_POST['playback']) ? $_POST['playback'] : ''; ?></textarea>

												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group pull-right">
									<button type="submit" name="submit" value="submit"
										class="btn btn-primary btn-sm">Submit</button>
								</div>
								<p style="color:blue;">
									<?php echo $message; ?>
								</p>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$("select[name='clientId']").change(function () {
		var clientsID = $(this).val();


		if (clientsID) {


			$.ajax({
				url: "ajaxpro.php",
				dataType: 'Json',
				data: { 'id': clientsID },
				success: function (data) {
					$('select[name="selectedUser"]').empty();
					$.each(data, function (key, value) {
						$('select[name="selectedUser"]').append('<option selected="selected" value="' + key + '">' + value + '</option>');
					});
				}
			});


		} else {
			$('select[name="selectedUser"]');
			$.each(data, function (key, value) {
				$('select[name="selectedUser"]').append('<option selected="selected" value="' + key + '">' + value + '</option>');
			});
		}
	});

	$("select[name='playWelcomeMessage']").change(function () {
		var playWelcomeMessage = $(this).val();
		//alert(playWelcomeMessage);
		if (playWelcomeMessage == '0') {
			$("#welcomeMessageInput").hide();
		} else {
			$("#welcomeMessageInput").show();
		}
	});
	/*		$( "select[name='destination_type']" ).change(function () {			var selectedUSERS = $(this).val();
	
			if(selectedUSERS) {
	
				$.ajax({					url: "ajaxdestination.php",					dataType: 'Json',					data: {'id':selectedUSERS},					success: function(data) {						$('select[name="destination"]').empty();						$.each(data, function(key, value) {							$('select[name="destination"]').append('<option value="'+ key +'">'+ value +'</option>');						});					}				});
	
			}else{				$('select[name="destination"]');				$.each(data, function(key, value) {							$('select[name="destination"]').append('<option value="'+ key +'">'+ value +'</option>');						});			}		});		*/
	$("select[name='clientId']").change(function () {
		var selectedUSERS = $(this).val();
		$('#destination_type').prop('selectedIndex', 0);
		$('#destinationSelect')
			.find('option')
			.remove()
			.end();
		// .append('<option value="">Select</option>');
	});
</script>
<script>
	function showUser(str) {
		if (str == "") {
			document.getElementById("destinationSelect").innerHTML = "";
			return;
		}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("destinationSelect").innerHTML = this.responseText;
			}
		}
		var user_id = $("#selectedUser").val();
		xmlhttp.open("GET", "ajaxdestination.php?q=" + str + '&user_id=' + user_id, true);
		xmlhttp.send();
	}
</script>

<script>
	function showUseradv(str) {
		if (str == "") {
			document.getElementById("forwarddestSelect").innerHTML = "";
			return;
		}
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				document.getElementById("forwarddestSelect").innerHTML = this.responseText;
			}
		}
		var user_id = $("#selectedUser").val();
		xmlhttp.open("GET", "ajaxdestinationadv.php?dest=destination&qv=" + str + '&user_id=' + user_id, true);
		xmlhttp.send();
	}
</script>

<script>
	var radioBtns = document.querySelectorAll('input[name="sch_call"]');
	var dataDiv = document.getElementById('dataDiv');
	if (radioBtns[0].checked) {
		dataDiv.style.display = 'block';  // Show the data div
	}
	radioBtns.forEach(function (radioBtn) {
		radioBtn.addEventListener('change', function () {
			if (this.value === '1' && this.checked) {
				dataDiv.style.display = 'block';  // Show the data div
			} else {
				dataDiv.style.display = 'none';   // Hide the data div
			}
		});
	});
	function showUsercredit(str) {

		$.ajax({
			url: 'ajaxcredit.php',
			type: 'GET',
			data: { q: str },
			success: function (response) {
				$("#txtHint").text(response);
			}
		});

	}

</script>

<?php require_once ('footer.php'); ?>