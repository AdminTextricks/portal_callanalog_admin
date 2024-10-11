<?php
require_once ('header.php');
$sch_call = isset($_POST['sch_call']) ? $_POST['sch_call'] : '';
$starttime = isset($_POST['starttime']) ? $_POST['starttime'] : '';
$stoptime = isset($_POST['stoptime']) ? $_POST['stoptime'] : '';
$startday = isset($_POST['startday']) ? $_POST['startday'] : '';
$stopday = isset($_POST['stopday']) ? $_POST['stopday'] : '';
$all_time = isset($_POST['all_time']) ? $_POST['all_time'] : '';
$ply_back = isset($_POST['playback']) ? $_POST['playback'] : '';
$destination_type_arr = array();
$select_destination = "SELECT * FROM `cc_selection_did`";
$res_destination = mysqli_query($connection, $select_destination);
while ($row_desti = mysqli_fetch_array($res_destination)) {
	$destination_type_arr[$row_desti['id']] = $row_desti['selection_value'];
}
$message = '';
if ($_POST['submit']) {
	
	$error = 'false';
	$clientId = $_POST['clientId'];
	$selectedUser = $_POST['selectedUser'];
	$did_or_tfn = $_POST['did_or_tfn'];
	$carieer = $_POST['carieer'];
	$destination_type = $_POST['destination_type'];
	$destination = $_POST['destination'];
	$status = $_POST['status'];
	$callScreenAction = $_POST['callScreenAction'];
	$forwardDestType = isset($_POST['forwardDestType']) ? $_POST['forwardDestType'] : "";
	$forwardDest = isset($_POST['forwardDest']) ? $_POST['forwardDest'] : "";
	if ($destination_type == '8') {
		$ivr = $destination;
	} else {
		$ivr = '';
	}
	$playWelcomeMessage = isset($_POST['playWelcomeMessage']) ? $_POST['playWelcomeMessage'] : "";
	$welcomeMessage = isset($_POST['welcomeMessage']) ? $_POST['welcomeMessage'] : "";

	$updatedid = "update cc_did set id_cc_didgroup='1',iduser='" . $selectedUser . "',did='" . $did_or_tfn . "',didtype='" . $destination_type . "',did_provider='" . $carieer . "',call_screening_action='" . $callScreenAction . "',id_ivr='" . $ivr . "',call_destination='" . $destination . "',did_provider='" . $carieer . "',status='" . $status . "',clientId='" . $clientId . "', screen_status='" . $playWelcomeMessage . "', playback='" . $welcomeMessage . "' where id='" . $_GET['id'] . "'";
	$result_didupdate = mysqli_query($connection, $updatedid);

	$dest_types = $destination_type_arr[$destination_type];

	$selectdid = "select id from cc_did where did='" . $did_or_tfn . "'";
	$resultdid = mysqli_query($connection, $selectdid);
	while ($rowdids = mysqli_fetch_array($resultdid)) {
		$didids = $rowdids['id'];
	}

	/* Renew DID Code Start Here */
	if (isset($_POST['rdid']) && $_POST['rdid'] == '1') {
		$user_sql = "select id,role from users_login where clientId='" . $clientId . "' and parent='0'";
		$user_res = mysqli_query($connection, $user_sql) or die("query failed : user_sql");
		if (mysqli_num_rows($user_res) > 0) {
			$user_details = mysqli_fetch_assoc($user_res);
		}

		if ($_POST['payment'] == 1) {

			if ($user_details['role'] == 3) {
				$userId = $user_details['id'];
			} else {
				$userId = '0';
			}
			$payment_type = "Renew by admin(Paid)";
			$query_price = "select * from cc_did_exten_price WHERE type='did' and user_id = '" . $userId . "'";
			$result_price = mysqli_query($connection, $query_price);
			if (mysqli_num_rows($result_price) > 0) {
				$rowPrice = mysqli_fetch_array($result_price);
				$price = $rowPrice['price'];
			}
		} else {
			$price = 0;
			$payment_type = 'Renew by admin(Free)';
		}

		$select_cust_credit = "select credit from cc_card where id='" . $user_details['id'] . "'";
		// echo $select_cust_credit;exit;
		$result_cust = mysqli_query($connection, $select_cust_credit);

		$rowcredit = mysqli_fetch_assoc($result_cust);
		$current_credit = $rowcredit['credit'];
		// echo $current_credit;exit;

		if ($price > $current_credit) {
			$message = "Not Enough Credit";
			$error = 'true';
		} else {
			$updated_credit = $current_credit - $price;
			$update_credit = "update cc_card set credit='" . $updated_credit . "' where id='" . $user_details['id'] . "'";
			$resultupdate = mysqli_query($connection, $update_credit);
			$invoice_amount = $price;

		}

		// exit;

		if ($error == 'false') {

			$startingDate = date('Y-m-d H:i:s');
			$expirationDate = date('Y-m-d H:i:s', strtotime('+1 month'));
			$renew_did = "UPDATE `cc_did` set `activated`='1', `status`='Active' , `startingDate` = '" . $startingDate . "',`expirationDate` = '" . $expirationDate . "' WHERE status='Suspended' and  activated = '0' and id='" . $_GET['id'] . "'";
			$renew_query = mysqli_query($connection, $renew_did) or die('failed:renew_did');
			// echo $renew_did;

			$invoice_amount = 0;
			$payment_status = 'Paid';
			$item_type = 'DID';
			$query_inv = "select max(id) as id from invoices";
			$result_inv = mysqli_query($connection, $query_inv);
			if (mysqli_num_rows($result_inv) > 0) {
				$rowid = mysqli_fetch_array($result_inv);
				$nn = $rowid['id'] + 1;
				$invoice_id = "INV/" . date('Y') . "/000" . $nn;
			} else {
				$invoice_id = 'INV/' . date("Y") . '/00001';
			}
			$invoice_currency = 'USD';
			$priceQuery = "select * from cc_did_exten_price WHERE type='did' and user_id = '0'";
			$priceRecords = mysqli_query($con, $priceQuery);
			$price_row = mysqli_fetch_assoc($priceRecords);
			$invoice_amount = $price_row['price'];
			$insert_invoice = "insert into  invoices (user_id, invoice_id, item_type, invoice_currency, invoice_amount, invoice_subtotal_amount,payment_status) VALUES ('" . $selectedUser . "','" . $invoice_id . "', '" . $item_type . "','" . $invoice_currency . "','" . $invoice_amount . "','" . $invoice_amount . "','" . $payment_status . "')";
			$query_res = mysqli_query($con, $insert_invoice);
			$invo_id = mysqli_insert_id($con);
			$item_price = $price_row['price'];
			$insert_invoice_item = "insert into invoices_items (invoice_id, item_type, item_number, price) VALUES ('" . $invo_id . "','" . $item_type . "','" . $did_or_tfn . "','" . $item_price . "')";
			$query_res_invo = mysqli_query($con, $insert_invoice_item) or die("query failed : insert_invoice_item");
			$gatway_order_id = $invoice_id . '-UID-' . $selectedUser;
			$payment_type = 'Renew By Admin';
			$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "'";
			$result_user_details = mysqli_query($connection, $query_user);
			$userDetails = mysqli_fetch_assoc($result_user_details);
			$user_name = $userDetails['name'];
			$email = $userDetails['email'];
			$insert_gateway_invoice = "insert into gateways_payments (user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('" . $selectedUser . "','" . $invo_id . "','" . $invoice_id . "', '" . $gatway_order_id . "','" . $payment_type . "','" . $item_type . "','" . $user_name . "','" . $email . "','Stripe Myphonesystems', '" . $did_or_tfn . "','" . $invoice_amount . "','" . $invoice_currency . "','success','" . date('Y-m-d H:i:s') . "')";
			$query_res = mysqli_query($con, $insert_gateway_invoice) or die("query failed : insert_gateway_invoice");
			$gateway_id = mysqli_insert_id($con);
			make_pdf($invo_id, $selectedUser);
		}
	}
	/* Renew DID Code End Here */

	if ($error == 'false') {
		if ($sch_call == 1) {
			$update_destination = "update cc_did_destination set destination='" . $destination . "',destination_name='" . $dest_types . "',id_cc_card='" . $selectedUser . "', sch_call='" . $sch_call . "', starttime='" . $starttime . "', stoptime='" . $stoptime . "', startday='" . $startday . "', stopday='" . $stopday . "', all_time='" . $all_time . "', playback='" . $ply_back . "' where id_cc_did='" . $didids . "' and priority='1'";
		} else {
			$update_destination = "update cc_did_destination set destination='" . $destination . "',destination_name='" . $dest_types . "',id_cc_card='" . $selectedUser . "', sch_call='0', starttime='0', stoptime='0', startday='0', stopday='0', all_time='1', playback='0' where id_cc_did='" . $didids . "' and priority='1'";
		}
		// echo "<pre>";print_r($update_destination);die;
		$resultupdatedestination = mysqli_query($connection, $update_destination);

		if (!empty($forwardDestType) and !empty($forwardDest)) {

			$forwardDestType = $destination_type_arr[$forwardDestType];

			$selectdestination = "select * from cc_did_destination where id_cc_did='" . $_GET['id'] . "' and priority='2'";
			$result_destinationselect = mysqli_query($connection, $selectdestination);

			if (mysqli_num_rows($result_destinationselect) > 0) {
				$update_destination_pri2 = "update cc_did_destination set destination='" . $forwardDest . "',destination_name='" . $forwardDestType . "',id_cc_card='" . $selectedUser . "', sch_call='" . $sch_call . "', starttime='" . $starttime . "', stoptime='" . $stoptime . "', startday='" . $startday . "', stopday='" . $stopday . "', all_time='" . $all_time . "', playback='" . $ply_back . "' where id_cc_did='" . $didids . "' and priority='2'";
				$result_destination_updatepri2 = mysqli_query($connection, $update_destination_pri2);
			} else {
				$insert_destination_pri2 = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`, `sch_call`, `starttime`, `stoptime`, `startday`, `stopday`, `all_time`, `playback`) VALUES ( '" . $forwardDest . "', '" . $forwardDestType . "', '2', '" . $selectedUser . "', '" . $didids . "','1','1', '" . $sch_call . "', '" . $starttime . "','" . $stoptime . "', '" . $startday . "', '" . $stopday . "', '" . $all_time . "', '" . $ply_back . "')";
				$result_destination_pri2 = mysqli_query($connection, $insert_destination_pri2);
			}
		} else {
			$deletedid = "delete from cc_did_destination where id_cc_did='" . $_GET['id'] . "' and priority='2'";
			$resultdelete = mysqli_query($connection, $deletedid);
		}

		if ($resultupdatedestination) {
			$activity_type = 'DID Update';
			if ($_SESSION['userroleforpage'] == '1') {
				$msg = 'DID No: ' . $did_or_tfn . ' ' . 'DID Update Succesfully! By Admin';
			} else {
				$msg = 'DID No: ' . $did_or_tfn . ' ' . 'DID Update Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
			$_SESSION['msg'] = "Inbound updated Successfully";
			echo '<script>window.location.href="inbound.php"</script>';
		}
	}
}


if ($_SESSION['userroleforpage'] == 1) {
	$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE  users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
} else {
	$query_client = "select * from Client where clientId='" . $_SESSION['userroleforclientid'] . "'";
}
$result_client = mysqli_query($connection, $query_client);


//$query_sip = "select * from cc_sip_buddies";
//$result_sip = mysqli_query($connection , $query_sip);

$query_diddetails = "select * from cc_did where id='" . $_GET['id'] . "'";

$result_didres = mysqli_query($connection, $query_diddetails);
while ($rowdiddetails = mysqli_fetch_array($result_didres)) {
	$curruserid = $rowdiddetails['iduser'];
	$orddid = $rowdiddetails['did'];
	$ordcarieer = $rowdiddetails['did_provider'];
	$orddidtype = $rowdiddetails['didtype'];
	$ordcalldestn = $rowdiddetails['call_destination'];
	$ordstatus = $rowdiddetails['status'];
	$ordscreening = $rowdiddetails['call_screening_action'];
	$clientidgg = $rowdiddetails['clientId'];

	$playWelcomeMessage = $rowdiddetails['screen_status'];
	$welcomeMessage = $rowdiddetails['playback'];
}
$destinationname = '';
$query_user = "select * from users_login where clientId='" . $clientidgg . "'";

$result_user_login = mysqli_query($connection, $query_user);


$query_diddestin = "select * from cc_did_destination where id_cc_did='" . $_GET['id'] . "' and priority=2";
$result_destin = mysqli_query($connection, $query_diddestin);
while ($rowdiddest = mysqli_fetch_array($result_destin)) {
	$destinationname = $rowdiddest['destination_name'];
	$destinationcalldestn = $rowdiddest['destination'];
}
$user_name_query = "select * from users_login where id='" . $curruserid . "'";
$res_name_qry1 = mysqli_query($connection, $user_name_query);
$res_name_qry = mysqli_fetch_assoc($res_name_qry1);
$res_get_name_qry = $res_name_qry['name'];

if ($_SESSION['userroleforpage'] == 2 && $curruserid !== $_SESSION['login_user_id']) { ?>
	<script>
		window.location = 'access_denied.php';
	</script>
<?php } ?>


<style>

.bootstrap-select.btn-group .dropdown-menu {
    min-width: 100%;
    z-index: 1035;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    width: 100%;
}
/*
@media only screen and (max-width: 362px) {
.bootstrap-select.btn-group .dropdown-menu {
    margin-top: 273px!important;
	margin-left: 80px;
}
}

@media only screen and (max-width: 756px) {
.bootstrap-select.btn-group .dropdown-menu {
    margin-top: 272px!important;
}
}
@media only screen and (max-width: 992px) {
.bootstrap-select.btn-group .dropdown-menu {
    margin-top: 250px!important;
}
}*/
</style>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Inbound Information <span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="inbound.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i> Inbound</button></a>
						</div>

					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="inboundForm" name="inboundedit" action="" method="post">

								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker" required>
												<option value="0" selected="selected">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($row['clientId'] == $clientidgg) {
														echo 'selected="selected"';
													} else {
														'';
													} ?> value="<?php echo $row['clientId']; ?>">
														<?php echo $row['clientName'] . '/' . $row['clientEmail'];
														; ?>
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
												<!--<option value="0" selected="selected">Select</option>-->
												<?php while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
													<option <?php if ($row_user['id'] == $curruserid) {
														echo 'selected="selected"';
													} else {
														'';
													} ?> value="<?php echo $row_user['id']; ?>">
														<?php echo $row_user['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
								<?php } else { ?>
									<input id="clientId" name="clientId" value="<?php echo $clientidgg; ?>" type="hidden">
									<input id="selectedUser" name="selectedUser" value="<?php echo $curruserid; ?>"
										type="hidden">
								<?php } ?>
								<input id="carieer" name="carieer" value="<?php echo $ordcarieer; ?>" type="hidden">
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">DID Or TFN *</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="did_or_tfn" readonly name="did_or_tfn" required class="form-control"
											type="text" value="<?php echo $orddid; ?>" />
									</div>
								</div>

								<!-- <?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class="form-control-label">Carieer</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="did_provider" name="did_provider" class="form-control">
												<option value="">------SELECT------</option>
												<?php foreach ($did_provider as $value) { ?>
													<option <?php if ($ordcarieer == $value) {
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
								<?php } ?> -->

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Destination Type</label>
									</div>


									<div class="col-12 col-md-8">
										<select id="destination_type" onchange="showUser(this.value)"
											name="destination_type" class="form-control">
											<option value="NONE">------SELECT------</option>
											<?php

											foreach ($destination_type_arr as $key => $row_desti) { ?>
												<option <?php if ($key == $orddidtype) {
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
										<label for="text-input" class="form-control-label">Destination</label>
									</div>
									<div class="col-12 col-md-8" id="destinationSelect">
										<?php if ($orddidtype == 1) {
											$query_queue = "select * from cc_queue_table where assigned_user='" . $curruserid . "'";
											$result_queue = mysqli_query($connection, $query_queue);
											?>
											<select id="destination" name="destination" class="form-control">
												<?php
												while ($row_sip = mysqli_fetch_array($result_queue)) {

													?>
													<option <?php if (trim($ordcalldestn) == trim($row_sip["name"])) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value=<?php echo $row_sip["name"]; ?>><?php echo $row_sip["name"]; ?>
														&nbsp;&nbsp;Username: <?php echo $res_get_name_qry; ?></option>
												<?php } ?>
											</select>
										<?php } elseif ($orddidtype == 2) {
											$query_ext = "select * from cc_sip_buddies where id_cc_card='" . $curruserid . "'";
											$result_ext = mysqli_query($connection, $query_ext);

											echo '<select id="destination" name="destination" class="form-control">';
											while ($row_ext = mysqli_fetch_array($result_ext)) { ?>
												<option <?php if (trim($ordcalldestn) == trim($row_ext["name"])) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value=<?php echo $row_ext["name"]; ?>> &nbsp;&nbsp;Agent Name: <?php echo $row_ext["name"]; ?> &nbsp;&nbsp;Extension No: <?php echo $row_ext["name"]; ?>
													&nbsp;&nbsp;Intercom No: <?php echo $row_ext["lead_operator"]; ?></option>

											<?php }
											echo '</select>';
										} elseif ($orddidtype == 3) {
											$query_vm = "select * from cc_voicemail_users where customer_id='" . $curruserid . "'";
											$result_vm = mysqli_query($connection, $query_vm);

											echo '<select id="destination" name="destination" class="form-control">';
											while ($row_vm = mysqli_fetch_array($result_vm)) { ?>
												<option <?php if (trim($ordcalldestn) == trim($row_vm["name"])) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value=<?php echo $row_vm["mailbox"]; ?>> &nbsp;&nbsp;Voicemail Name: <?php echo $row_vm["fullname"]; ?> &nbsp;&nbsp;Voicemail Number: <?php echo $row_vm["mailbox"]; ?></option>';
											<?php }
											echo '</select>';
										} elseif ($orddidtype == 5) {

											$query_booking = "select * from booking where user_id='" . $curruserid . "'";
											$result_booking = mysqli_query($connection, $query_booking);

											echo '<select id="destination" name="destination" class="form-control">';
											while ($row_book = mysqli_fetch_array($result_booking)) { ?>
												<option <?php if (trim($row_book["confno"]) == trim($ordcalldestn)) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="<?php echo $row_book["confno"] ?> ">&nbsp;&nbsp;Conference Name:
													<?php echo $row_book["confDesc"]; ?> &nbsp;&nbsp;Conference Number:
													<?php echo $row_book["confno"]; ?>
												</option>
											<?php }
											echo '</select>';
											//echo '<input type="text" id="destination" name="destination" class="form-control" value='.$ordcalldestn.'>';
										
										} elseif ($orddidtype == 6) {

											$query_ring = "select * from cc_ring_group where user_id='" . $curruserid . "'";
											$result_ring = mysqli_query($connection, $query_ring); ?>

											<select id="destination" name="destination" class="form-control">
												<?php
												while ($row_ring = mysqli_fetch_array($result_ring)) { ?>
													<option <?php if (trim($row_ring["ringno"]) == trim($ordcalldestn)) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_ring["ringno"] ?> ">&nbsp;&nbsp;Ring Name :
														<?php echo $row_ring["description"]; ?> &nbsp;&nbsp;Ring Number :
														<?php echo $row_ring["ringno"]; ?>
													</option>
												<?php } ?>
											</select>
											<?php
										} elseif ($orddidtype == 8) {

											$query_ring = "select * from ivr where user_id='" . $curruserid . "'";
											$result_ring = mysqli_query($connection, $query_ring); ?>

											<select id="destination" name="destination" class="form-control">
												<?php
												while ($row_ring = mysqli_fetch_array($result_ring)) { ?>
													<option <?php if (trim($row_ring["id"]) == trim($ordcalldestn)) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_ring["id"] ?> ">&nbsp;&nbsp;IVR Name:
														<?php echo $row_ring["ivr_name"]; ?>
													</option>
												<?php } ?>
											</select>
											<?php
										} else {
											echo '<input type="text" id="destination" name="destination" class="form-control" value=' . $ordcalldestn . '>';
										}

										?>


									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Status</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="status" name="status" class="form-control">
											<option <?php if ($ordstatus == 'Active') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Active">Active</option>
											<option <?php if ($ordstatus == 'Inactive') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Inactive">Inactive</option>
											<option <?php if ($ordstatus == 'Suspended') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Suspended">Suspended</option>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Dial Status</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="callScreenAction" name="callScreenAction" class="form-control">
											<option <?php if ($ordscreening == 1) {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="1">Ring</option>
											<option <?php if ($ordscreening == 9) {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="9">Hangup</option>
										</select>
									</div>
								</div>
								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class="form-control-label">Play Welcome Message</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="playWelcomeMessage" name="playWelcomeMessage" class="form-control">
												<option <?php if ($playWelcomeMessage == '0') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="0">No</option>
												<option <?php if ($playWelcomeMessage == '1') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="1">Yes</option>
											</select>
										</div>
									</div>

									<div class="row form-group" id="welcomeMessageInput" <?php if ($playWelcomeMessage == '1') { ?> style="display:block;" <?php } else { ?> style="display:none;" <?php } ?>>
										<div class="col col-md-4">
											<label for="text-input" class="form-control-label">Welcome Message</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="welcomeMessage" name="welcomeMessage"
												placeholder="Type Your Welcome message" class="form-control" type="text"
												value="<?php echo $welcomeMessage; ?>" />
										</div>
									</div>
								<?php } ?>

								<?php if ($_SESSION['userroleforpage'] == 1 && (isset($_GET['ren']) && $_GET['ren'] == 'yes')) { ?>
									<div class="row form-group barge_radio_btn">
										<div class="col col-md-4">
											<label class=" form-control-label">Renew DID</label>
										</div>
										<div class="col col-md-8">
											<div class="form-check-inline form-check">
												<label for="inline-radio1" class="form-check-label "
													style="margin-right:15px; color:black;">
													<input id="inline-radio1" name="rdid" type="radio" value="1" <?php if (isset($_POST['rdid']) && $_POST['rdid'] == '1') {
														echo "checked";
													} ?>> Yes
												</label>
												<label for="inline-radio2" class="form-check-label " style="color:black;">
													<input id="inline-radio2" name="rdid" type="radio" value="0" <?php if (!isset($_POST['rdid']) || isset($_POST['rdid']) && $_POST['rdid'] == '0') {
														echo "checked";
													} ?>> No
												</label>
											</div>
										</div>
									</div>
									<div class="row form-group barge_radio_btn" id="payment_type" style="<?php if (isset($_POST['rdid']) && $_POST['rdid'] == 1) {
										echo "display:block;";
									} else {
										echo "display:none;";
									} ?>">
										<div class="col col-md-4">
											<label class=" form-control-label">Payment Type</label>
										</div>
										<div class="col col-md-8">
											<div class="form-check-inline form-check">
												<label for="inline-tariff-free" class="form-check-label"
													style="margin-right:15px; color:black;">
													<input id="inline-tariff-free" name="payment" class="form-check-input"
														type="radio" value="0" <?php if (isset($_POST['payment']) && $_POST['payment'] == '0') {
															echo "checked";
														} ?> /> Free
												</label>
												<label for="inline-tariff-paid" class="form-check-label"
													style="color:black;">
													<input id="inline-tariff-paid" name="payment" class="form-check-input"
														checked="checked" type="radio" value="1" <?php if (isset($_POST['payment']) && $_POST['payment'] == '1') {
															echo "checked";
														} ?> />
													Paid
												</label>
											</div>
										</div>
									</div>
								<?php } ?>
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
	$(document).ready(function () {
		$('.showbtn').click(function () {
			$('#showhideForm').show(500);
		});
		$('.hidebtn').click(function () {
			$('#showhideForm').hide(500);
		});
	});
</script>



<script>

	$("input[name='rdid']").on("change", function () {

		var input = $(this).val();
		if (input == 1) {
			$("#payment_type").css('display', 'block');
		} else {
			$("#payment_type").css('display', 'none');
		}
		// alert();
	});


	$("select[name='clientId']").change(function () {
		var clientsID = $(this).val();
		if (clientsID) {
			$.ajax({
				url: "ajaxpro.php",
				dataType: 'Json',
				data: {
					'id': clientsID
				},
				success: function (data) {
					$('select[name="selectedUser"]').empty();
					$.each(data, function (key, value) {
						$('select[name="selectedUser"]').append('<option value="' + key + '">' + value + '</option>');

					});
				}
			});
		} else {
			$('select[name="selectedUser"]');
			$.each(data, function (key, value) {
				$('select[name="selectedUser"]').append('<option value="' + key + '">' + value + '</option>');
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
	$("select[name='clientId']").change(function () {
		var client = $(this).val();
		$('#destination_type').prop('selectedIndex', 0);
		$('#destination')
			.find('option')
			.remove()
			.end()
			.append('<option value="">Select</option>');
	});
        $("select[name='selectedUser']").change(function () {
		var sltt = $(this).val();
		$('#destination_type').prop('selectedIndex', 0);
		$('#destination')
			.find('option')
			.remove()
			.end()
			.append('<option value="">Select</option>');
	});
	/*
	$( "select[name='destination_type']" ).change(function () {
		var selectedUSERS = $(this).val();


		if(selectedUSERS) {


			$.ajax({
				url: "ajaxdestination.php",
				dataType: 'Json',
				data: {'id':selectedUSERS},
				success: function(data) {
					$('select[name="destination"]').empty();
					$.each(data, function(key, value) {
						$('select[name="destination"]').append('<option value="'+ key +'">'+ value +'</option>');
					});
				}
			});


		}else{
			$('select[name="destination"]');
			$.each(data, function(key, value) {
						$('select[name="destination"]').append('<option value="'+ key +'">'+ value +'</option>');
					});
		}
	});
	*/
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
		dataDiv.style.display = 'block'; // Show the data div
	}
	radioBtns.forEach(function (radioBtn) {
		radioBtn.addEventListener('change', function () {
			if (this.value === '1' && this.checked) {
				dataDiv.style.display = 'block'; // Show the data div
			} else {
				dataDiv.style.display = 'none'; // Hide the data div
			}
		});
	});
</script>
<?php require_once ('footer.php'); ?>
