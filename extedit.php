<?php
require_once ('header.php');

// echo '<pre>';print_r($_SESSION);
// echo RHOST.'<br>'.RPORT;exit;

$ext_query_web_template = "select * from cc_conf_templates";
$web_res = mysqli_query($con, $ext_query_web_template);
while ($web_temp_res = mysqli_fetch_array($web_res)) {
	$template_id = $web_temp_res['template_id'];
	$template_name = $web_temp_res['template_name'];
	$template_contents = $web_temp_res['template_contents'];
}

$message = '';
if (isset($_POST['submit'])) {

	// echo '<pre>';print_r($_POST);exit;
	$accountcode_select = "select username from cc_card where id='" . $_POST['selectedUser'] . "'";
	$accountcode_select_query = mysqli_query($con, $accountcode_select);
	while ($rowaccountcode = mysqli_fetch_array($accountcode_select_query)) {
		$selectedaccountcode = $rowaccountcode['username'];
	}

	$nname = $_POST['name'];
	$ssecret = $_POST['secret'];

	$error = 'false';
	/* Renew Ext Code start here */

	if (isset($_POST['renew']) && $_POST['renew'] == '1') {

		$user_sql = "select id,role from users_login where clientId='" . $_POST['clientId'] . "' and parent='0'";
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
			$payment_type = "Renew by Admin(Paid)";
			$query_price = "select * from cc_did_exten_price WHERE type='extension' and user_id = '" . $userId . "'";
			$result_price = mysqli_query($connection, $query_price);
			if (mysqli_num_rows($result_price) > 0) {
				$rowPrice = mysqli_fetch_array($result_price);
				$price = $rowPrice['price'];
			}
		} else {
			$price = 0;
			$payment_type = 'Renew by Admin(Free)';
		}
		$select_cust_credit = "select credit from cc_card where id='" . $user_details['id'] . "'";
		$result_cust = mysqli_query($connection, $select_cust_credit);
		$rowcredit = mysqli_fetch_assoc($result_cust);
		$current_credit = $rowcredit['credit'];
		if ($price > $current_credit) {
			$message = "Not Enough Credit";
			$error = 'true';
		} else {
			$updated_credit = $current_credit - $price;
			$update_credit = "update cc_card set credit='" . $updated_credit . "' where id='" . $user_details['id'] . "'";
			$resultupdate = mysqli_query($connection, $update_credit);
			$invoice_amount = $price;

		}
		if ($error == 'false') {
			$startingDate = date('Y-m-d H:i:s');
			$expirationDate = date('Y-m-d H:i:s', strtotime('+29 days'));
			$renew_ext = "UPDATE `cc_sip_buddies` SET `host` = 'dynamic' ,`context`='textricks-outcall', `ext_status` = '1', `startingdate` = '" . $startingDate . "', `expirationdate` = '" . $expirationDate . "' WHERE `id`='" . $_GET['id'] . "'";
			$res_renew = mysqli_query($connection, $renew_ext) or die("query failed : renew_ext");
			$invoice_amount = 0;
			$payment_status = 'Paid';
			$item_type = 'Extension';
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
			// $priceQuery = "select * from cc_did_exten_price WHERE type='extension' and user_id = '0'";
			// $priceRecords = mysqli_query($con, $priceQuery);
			// $price_row = mysqli_fetch_assoc($priceRecords);
			$invoice_amount = $price;

			$insert_invoice = "insert into 	invoices (user_id, invoice_id, item_type, invoice_currency, invoice_amount, invoice_subtotal_amount,payment_status) VALUES ('" . $_POST['selectedUser'] . "','" . $invoice_id . "', '" . $item_type . "','" . $invoice_currency . "','" . $invoice_amount . "','" . $invoice_amount . "','" . $payment_status . "')";
			$query_res = mysqli_query($con, $insert_invoice);
			$invo_id = mysqli_insert_id($con);

			$item_price = $price;

			$insert_invoice_item = "insert into invoices_items (invoice_id, item_type, item_number, price) VALUES ('" . $invo_id . "','" . $item_type . "','" . $_POST['name'] . "','" . $item_price . "')";
			$query_res_invo = mysqli_query($con, $insert_invoice_item) or die("query failed : insert_invoice_item");

			$gatway_order_id = $invoice_id . '-UID-' . $_POST['selectedUser'];

			$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "'";
			$result_user_details = mysqli_query($connection, $query_user);
			$userDetails = mysqli_fetch_assoc($result_user_details);
			$user_name = $userDetails['name'];
			$email = $userDetails['email'];

			$insert_gateway_invoice = "insert into gateways_payments (user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('" . $_POST['selectedUser'] . "','" . $invo_id . "','" . $invoice_id . "', '" . $gatway_order_id . "','" . $payment_type . "','" . $item_type . "','" . $user_name . "','" . $email . "','Stripe Myphonesystems', '" . $_POST['name'] . "','" . $invoice_amount . "','" . $invoice_currency . "','success','" . date('Y-m-d H:i:s') . "')";
			$query_res = mysqli_query($con, $insert_gateway_invoice) or die("query failed : insert_gateway_invoice");
			$gateway_id = mysqli_insert_id($con);

			make_pdf($invo_id, $_POST['selectedUser']);
		}
	}
	/* Renew Ext Code end here */




	if ($error == 'false') {
		if ($_POST['ivr'] == '1') {
			// Add new user section
			$register_string = "\n[$nname]\nusername=$nname\nsecret=$ssecret\naccountcode=$selectedaccountcode\n$template_contents\n";
			$webrtc_conf_path = "/var/www/html/callanalog/admin/webrtc_template.conf";
			file_put_contents($webrtc_conf_path, $register_string, FILE_APPEND | LOCK_EX);
			//echo "Registration successful. The SIP user $nname has been added to the webrtc_template.conf file.";


			$sip_additional_path = "/var/www/html/callanalog/admin/sip_additional.conf";
			$lines = file($sip_additional_path);
			$output = '';
			$found = false;
			foreach ($lines as $line) {
				if (strpos($line, "[$nname]") !== false) {
					$found = true;
					continue;
				}
				if ($found && strpos($line, "[") === 0) {
					$found = false;
				}
				if (!$found) {
					$output .= $line;
				}
			}
			file_put_contents($sip_additional_path, $output, LOCK_EX);
		} else {
			// Remove user section
			$webrtc_conf_path = "webrtc_template.conf";
			$lines = file($webrtc_conf_path);
			$output = '';
			$found = false;
			foreach ($lines as $line) {
				if (strpos($line, "[$nname]") !== false) {
					$found = true;
					continue;
				}
				if ($found && strpos($line, "[") === 0) {
					$found = false;
				}
				if (!$found) {
					$output .= $line;
				}
			}
			file_put_contents($webrtc_conf_path, $output, LOCK_EX);
			//echo "Registration removed. The SIP user $nname has been removed from the webrtc_template.conf file.";


			/* Entry Another file code Start here */
			$sip_additional_path = "/var/www/html/callanalog/admin/sip_additional.conf";

			$sip_register_string = "\n[$nname]\nusername=$nname\nsecret=$ssecret\naccountcode=$selectedaccountcode\n" . SIP_TEMPLATE_CONTENT . "\n";
			file_put_contents($sip_additional_path, $sip_register_string, FILE_APPEND | LOCK_EX);
			/* Entry Another file code END here */
		}
		if ($_POST['ivr'] == '1' || $_POST['ivr'] == '0') {

			if (SERVER_FLAG == 1) {
				$result = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
				$result1 = shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
				sip_reload();
			}
			// if ($result1) {
			// 	echo "File Transfer Successfully..";
			// } else {
			// 	echo "File Transfer Failed..";
			// }
			// exit;
			/* $srcFile = '/var/www/html/callanalog/admin/webrtc_template.conf';
															$dstFile = '/var/www/html/webrtc_template.conf';

															// Establish an SSH2 connection to the remote server.
															$conn = ssh2_connect(RHOST, RPORT);

															if (!$conn) {
																die("Unable to connect to the remote server.");
															}
															// Authenticate with the private key.

															if (ssh2_auth_pubkey_file($conn, RUSERNAME, PUBLIC_KEY, PRIVATE_KEY)) {
																// Securely transfer the file to the remote server.
																if (ssh2_scp_send($conn, $srcFile, $dstFile, 0644)) {
																	echo "File transferred successfully.";
																} else {
																	echo "Failed to transfer the file.";
																}
															} else {
																echo "Authentication failed.";
															}

															// Close the SSH2 connection.
															ssh2_disconnect($conn); */


		}

		// END FOR MEETME_ROOMS.CONF FILE ADD DATA ON IT:::	
		$update_ext = "update cc_sip_buddies set accountcode='" . $selectedaccountcode . "', clientId='" . $_POST['clientId'] . "',agent_name='" . $_POST['agent_name'] . "', lead_operator='" . $_POST['lead_operator'] . "', callerid='" . $_POST['outbound_cid'] . "',secret='" . $_POST['secret'] . "',context='" . $_POST['context'] . "',	dtmfmode='" . $_POST['dtmfmode'] . "',deny='" . $_POST['deny'] . "',permit='" . $_POST['permit'] . "',ipaddr='" . $_POST['ipaddr'] . "',defaultuser='" . $_POST['defaultuser'] . "',canreinvite='" . $_POST['canreinvite'] . "',fromuser='" . $_POST['fromuser'] . "',fromdomain='" . $_POST['fromdomain'] . "',dial_timeout='" . $_POST['dial_timeout'] . "',type='" . $_POST['type'] . "',qualify='" . $_POST['qualify'] . "',port='" . $_POST['port'] . "',disallow='" . $_POST['disallow'] . "',allow='" . $_POST['allow'] . "', regseconds='" . $_POST['regseconds'] . "',fullcontact='" . $_POST['fullcontact'] . "',lastms='" . $_POST['lastms'] . "',rtpkeepalive='" . $_POST['rtpkeepalive'] . "',useragent='" . $_POST['useragent'] . "',fail_status='" . $_POST['fail_status'] . "',fail_dest='" . $_POST['fail_dest'] . "',fail_data='" . $_POST['fail_data'] . "',	nat='" . $_POST['nat'] . "',sip_type='" . $_POST['sip_type'] . "',play_ivr='" . $_POST['ivr'] . "',user_id='" . $_POST['selectedUser'] . "' , outbound_cid='" . $_POST['outboundcall'] . "',recording='" . $_POST['callRecording'] . "'  where name='" . $_POST['name'] . "'";

		// echo $update_ext;exit;

		$result_updatext = mysqli_query($con, $update_ext);

		if ($_POST['voicemail'] == 'Yes') {

			$delete_voicemail = "delete from cc_voicemail_users where mailbox='" . $_POST['name'] . "'";
			$delete_voicemail_query = mysqli_query($con, $delete_voicemail);


			$insert_voicemail = "insert into cc_voicemail_users (customer_id,mailbox,fullname,email) VALUES ('" . $_POST['selectedUser'] . "','" . $_POST['name'] . "','" . $_POST['agent_name'] . "','" . $_POST['agentEmail'] . "')";
			$insert_voicemail_query = mysqli_query($con, $insert_voicemail);
		}

		if ($_POST['voicemail'] == 'No') {
			$delete_voicemail = "delete from cc_voicemail_users where mailbox='" . $_POST['name'] . "'";
			$delete_voicemail_query = mysqli_query($con, $delete_voicemail);
		}

		if ($result_updatext) {
			if ($_SESSION['login_user_plan_id'] == '1' || $_SESSION['userroleforpage'] == '1') {

				$activity_type = 'Extension Update';
				if ($_SESSION['userroleforpage'] == '1') {
					$msg = 'Extension No: ' . $_POST['name'] . 'Extension Update Succesfully! By Admin';
				} else {
					$msg = 'Extension No: ' . $_POST['name'] . 'Extension Update Succesfully! By User';

				}
				user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);

				$_SESSION['msg'] = "Extension updated successfully!";

			} elseif ($_SESSION['login_user_plan_id'] == '0' && isset($_GET['ext']) && $_GET['ext'] == 'payment') {

				echo '<script>location.href = "./create_ext_invoice.php?ext=' . base64_encode($_GET['id']) . '&ren=1"</script>';
				//header("Location: /create_ext_invoice.php?ext=".base64_encode($last_id));
			} else {
				$activity_type = 'Extension Update';
				if ($_SESSION['userroleforpage'] == '1') {
					$msg = 'Extension No: ' . $_POST['name'] . 'Extension Update Succesfully! By Admin';
				} else {
					$msg = 'Extension No: ' . $_POST['name'] . 'Extension Update Succesfully! By User';

				}
				user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);

				$_SESSION['msg'] = "Extension updated successfully!";
			}

			echo '<script>window.location.href="extension.php"</script>';
		}
	}
}

$select_queuename = "SELECT  GROUP_CONCAT( cc_queue_member_table.queue_name ) as queuemember,cc_sip_buddies.clientId AS clientid,cc_sip_buddies.name as name,cc_sip_buddies.agent_name as agent_name, cc_sip_buddies.lead_operator as lead_operator, cc_sip_buddies.secret as secret,cc_sip_buddies.context as context, cc_sip_buddies.dtmfmode as dtmfmode,cc_sip_buddies.deny as deny, cc_sip_buddies.permit as permit,cc_sip_buddies.ipaddr as ipaddr,cc_sip_buddies.defaultuser as defaultuser, cc_sip_buddies.regexten as regexten,cc_sip_buddies.amaflags as amaflags,cc_sip_buddies.canreinvite as canreinvite,cc_sip_buddies.fromuser as fromuser,cc_sip_buddies.fromdomain as fromdomain,cc_sip_buddies.host as host,      cc_sip_buddies.dial_timeout as dial_timeout,cc_sip_buddies.type as type,cc_sip_buddies.qualify as qualify, cc_sip_buddies.port as port,cc_sip_buddies.disallow as disallow,cc_sip_buddies.allow as allow,cc_sip_buddies.regseconds as regseconds,cc_sip_buddies.fullcontact as fullcontact, cc_sip_buddies.lastms as lastms,cc_sip_buddies.rtpkeepalive as rtpkeepalive,cc_sip_buddies.useragent as useragent,cc_sip_buddies.fail_status as fail_status,cc_sip_buddies.fail_dest as fail_dest,      cc_sip_buddies.fail_data as fail_data,cc_sip_buddies.nat as nat,cc_sip_buddies.sip_type as sip_type,cc_sip_buddies.play_ivr as play_ivr ,cc_sip_buddies.accountcode as accountcode,cc_sip_buddies.callerid as calleriddd, cc_sip_buddies.context as context,cc_sip_buddies.id_cc_card as id_cc_card, cc_sip_buddies.user_id as user_id,  outbound_cid,recording FROM `cc_queue_member_table` right join cc_sip_buddies ON cc_queue_member_table.membername=cc_sip_buddies.name WHERE cc_sip_buddies.id='" . $_GET['id'] . "'";
$result_queuename = mysqli_query($connection, $select_queuename);
$rowque = mysqli_fetch_assoc($result_queuename);
//echo '<pre>'; print_r($rowque);exit;
$user_id_match = $rowque['user_id'];
$id_cc_card = $rowque['id_cc_card'];
$queuename = $rowque['queuemember'];
$clientids = $rowque['clientid'];
$extension = $rowque['name'];
$agent_name = $rowque['agent_name'];
$lead_operator = $rowque['lead_operator'];
$secret = $rowque['secret'];
$dtmfmode = $rowque['dtmfmode'];
$deny = $rowque['deny'];
$permit = $rowque['permit'];
$ipaddr = $rowque['ipaddr'];
$defaultuser = $rowque['defaultuser'];
$accountcode = $rowque['accountcode'];
$regexten = $rowque['regexten'];
$amaflags = $rowque['amaflags'];
$canreinvite = $rowque['canreinvite'];
$fromuser = $rowque['fromuser'];
$fromdomain = $rowque['fromdomain'];
$host = $rowque['host'];
$dial_timeout = $rowque['dial_timeout'];
$type = $rowque['type'];
$qualify = $rowque['qualify'];
$port = $rowque['port'];
$disallow = $rowque['disallow'];
$allow = $rowque['allow'];
$regseconds = $rowque['regseconds'];
$fullcontact = $rowque['fullcontact'];
$lastms = $rowque['lastms'];
$rtpkeepalive = $rowque['rtpkeepalive'];
$useragent = $rowque['useragent'];
$fail_status = $rowque['fail_status'];
$fail_dest = $rowque['fail_dest'];
$fail_data = $rowque['fail_data'];
$nat = $rowque['nat'];
$sip_type = $rowque['sip_type'];
$ivr = $rowque['play_ivr'];
$context = $rowque['context'];
$calleriddd = $rowque['calleriddd'];
$outbound_cid = $rowque['outbound_cid'];
$recording = $rowque['recording'];

if ($_SESSION['userroleforpage'] == 1) {
	$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
} else {
	$query_client = "select * from Client where clientId='" . $_SESSION['userroleforclientid'] . "'";
}
$result_client = mysqli_query($connection, $query_client);

if ($_SESSION['userroleforpage'] == 1) {
	$query_user = "select * from users_login where clientid='" . $clientids . "'";
} else {
	$query_user = "SELECT `name` , id , clientId FROM users_login WHERE clientid='" . $clientids . "'";
}
$result_user_login = mysqli_query($connection, $query_user);

if ($_SESSION['userroleforpage'] == 1) {
	$query_did = "select * from cc_did where iduser='" . $id_cc_card . "'";
} else {
	$query_did = "select * from cc_did where iduser='" . $_SESSION['login_user_id'] . "'";
}

$result_outbound = mysqli_query($connection, $query_did);
$vmemail = '';
$selectvoicemail = "select * from cc_voicemail_users where mailbox='" . $extension . "'";
$result_voicemail = mysqli_query($con, $selectvoicemail);
$totalext = mysqli_num_rows($result_voicemail);
while ($rowvoicemails = mysqli_fetch_array($result_voicemail)) {
	$vmemail = $rowvoicemails['email'];
}


if ($_SESSION['userroleforpage'] == 2 && $id_cc_card != $_SESSION['login_user_id']) { ?>
	<script>
		window.location = 'access_denied.php';
	</script>
<?php }
?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Extension Information <span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="extension.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i> Extension</button>
							</a>
							<?php //print_r($_SESSION);   ?>
							<?php //echo '<br>'; echo $update_ext;   ?>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" value="1" id="userrole" />
			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="extensionForm" action="" method="post" enctype='multipart/form-data'>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Assigned Queue</label>
									</div>
									<div class="col-12 col-md-8">
										<input type="text" class="form-control" value="<?php echo $queuename; ?>"
											readonly="true">
									</div>
								</div>
								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker" required>
												<option value="0">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($clientids == $row['clientId']) {
														echo 'selected="selected"';
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
											<label for="text-input" class="form-control-label">Select User*</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="selectedUser" name="selectedUser" class="form-control" required>

												<option value="0">Select</option>

												<?php while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
													<option <?php if ($id_cc_card == $row_user['id']) {
														echo 'selected="selected"';
													} ?> value="<?php echo $row_user['id']; ?>">
														<?php echo $row_user['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
								<?php } else { ?>
									<input id="clientId" name="clientId" value="<?php echo $clientids; ?>" type="hidden">
									<input id="selectedUser" name="selectedUser" value="<?php echo $id_cc_card; ?>"
										type="hidden">

								<?php } ?>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Extension Number</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="name" name="name" placeholder="Extension Number" class="form-control"
											<?php if ($_SESSION['userroleforpage'] == 1) {
												echo 'readonly="readonly"';
											} else {
												echo 'readonly="readonly"';
											} ?> type="text" required
											value="<?php echo $extension; ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Extension Name*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="agent_name" name="agent_name" placeholder="Extension Name"
											class="form-control" required type="text"
											value="<?php echo $agent_name; ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Intercom*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="lead_operator" name="lead_operator" placeholder="Intercom"
											class="form-control" required type="text"
											value="<?php echo $lead_operator; ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Outbound Caller Id*</label>
									</div>
									<div class="col-12 col-md-8">

										<select id="outbound_cid" name="outbound_cid" class="form-control">
											<option value="0">Select</option>
											<?php while ($row_outbound = mysqli_fetch_array($result_outbound)) { ?>
												<option <?php if ($calleriddd == $row_outbound['did']) {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?>
													value="<?php echo $row_outbound['did']; ?>">
													<?php echo $row_outbound['did']; ?>
												</option>
											<?php } ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Secret</label>
									</div>
									<div class="col-12 col-md-6">
										<input id="secret" required name="secret" placeholder=" Extension Secret"
											class="form-control" type="text" value="<?php echo $secret; ?>" />
									</div>
									<div class="col-2 col-md-2">
										<button type="button" class="btn btn-success btn-sm" id="genratePassword"><i
												class="fa fa-refresh" aria-hidden="true"></i> Generate</button>
									</div>
								</div>

								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label">Barge Extension</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="sip_type1" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="sip_type1" name="sip_type" name="inline-radios" <?php if ($sip_type == 'Yes') {
													echo 'checked="true"';
												} else {
													echo '';
												} ?>
													class="form-check-input" type="radio" value="Yes" /> Yes
											</label>
											<label for="sip_type2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="sip_type2" name="sip_type" name="inline-radios" <?php if ($sip_type == 'No') {
													echo 'checked="true"';
												} else {
													echo '';
												} ?>
													class="form-check-input" type="radio" value="No" /> No
											</label>
										</div>
									</div>
								</div>

								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label">VoiceMail</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="voicemail1" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="voicemail1" name="voicemail" name="voicemail inline-radios"
													<?php if ($totalext == 1) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> class="form-check-input" type="radio" value="Yes" /> Yes
											</label>
											<label for="voicemail2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="voicemail2" name="voicemail" name="voicemail inline-radios"
													<?php if ($totalext == 0) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> class="form-check-input" type="radio" value="No" /> No
											</label>
										</div>
									</div>
								</div>
								<div class="showhideForm1" id="dataDiv1" <?php if ($totalext == '1') {
									echo 'style="display: block;"';
								} else {
									echo 'style="display: none;"';
								} ?>>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">VoiceMail Email</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="agentEmail" name="agentEmail" placeholder="voicemail"
												class="form-control" type="email" value="<?php echo $vmemail; ?>" />
										</div>
									</div>
								</div>
								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label">OutBound Call</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="outboundcall" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="outboundcall" name="outboundcall" class="form-check-input"
													type="radio" value="1" <?php if ($outbound_cid == 1) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> /> Yes
											</label>
											<label for="outboundcall2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="outboundcall2" name="outboundcall" class="form-check-input"
													type="radio" value="0" <?php if ($outbound_cid == 0) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> /> No
											</label>
										</div>
									</div>
								</div>

								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label">Call Recording</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="callRecording" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="callRecording" name="callRecording" class="form-check-input"
													type="radio" value="1" <?php if ($recording == 1) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> /> Yes
											</label>
											<label for="callRecording2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="callRecording2" name="callRecording" class="form-check-input"
													type="radio" value="0" <?php if ($recording == 0) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> /> No
											</label>
										</div>
									</div>
								</div>



								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label">Web Template</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="ivr1" class="form-check-label "
												style="margin-right:15px; color:black;">
												<input id="ivr1" name="ivr" class="showbtn form-check-input"
													type="radio" value="1" <?php if ($ivr == '1' or (isset($_POST['ivr']) and $_POST['ivr'] == '1')) {
														echo "checked";
													} ?> /> Webphone
											</label>
											<label for="ivr2" class="form-check-label " style="color:black;">
												<input id="ivr2" name="ivr" class="hidebtn form-check-input"
													type="radio" value="0" <?php if ($ivr == '0' or (isset($_POST['ivr']) and $_POST['ivr'] == '0')) {
														echo "checked";
													} ?> /> Other (mico sip ,
												x-lite etc..)
											</label>
										</div>
									</div>
								</div>

								<?php if ($_SESSION['userroleforpage'] == 1 && (isset($_GET['ext']) && $_GET['ext'] == 'payment')) { ?>
									<div class="row form-group barge_radio_btn">
										<div class="col col-md-4">
											<label class=" form-control-label">Renew Extension</label>
										</div>
										<div class="col col-md-8">
											<div class="form-check-inline form-check">
												<label for="inline-radio1" class="form-check-label "
													style="margin-right:15px; color:black;">
													<input id="inline-radio1" name="renew" class="showbtn form-check-input"
														type="radio" value="1" <?php if (isset($_POST['renew']) && $_POST['renew'] == '1') {
															echo "checked";
														} ?>>Yes
												</label>
												<label for="inline-radio2" class="form-check-label " style="color:black;">
													<input id="inline-radio2" name="renew" class="hidebtn form-check-input"
														type="radio" value="0" <?php if (isset($_POST['renew']) && $_POST['renew'] == '0') {
															echo "checked";
														} ?>>No
												</label>
											</div>
										</div>
									</div>
									<div class="row form-group barge_radio_btn" id="payment_type" style="<?php
									if (isset($_POST['renew']) && $_POST['renew'] == 1) {
										echo "display:block;";
									} else {
										echo "display:none;";
									}
									?>">
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

								<div class="showhideForm" id="dataDiv" <?php if ($ivr == '1') {
									echo 'style="display: block;"';
								} else {
									echo 'style="display: none;"';
								} ?>>
									<div class="row form-group" style="display: none;">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Template Id</label>
										</div>
										<div class="col-12 col-md-8">
											<input type="text" class="form-control" name="template_id"
												value="<?php echo $template_id; ?>" id="Test_DatetimeLocal1" readonly>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Template Name</label>
										</div>
										<div class="col-12 col-md-8">
											<input type="text" class="form-control" name="template_name"
												value="<?php echo $template_name; ?>" id="Test_DatetimeLocal2" readonly>
										</div>
									</div>

									<div class="row form-group" style="display: none;">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Template Contents</label>
										</div>
										<div class="col-12 col-md-8">
											<textarea class="form-control" name="template_contents"
												id="Test_DatetimeLocal" placeholder="Type Your Off Hours Messages"
												rowspan="8" style="height:500px;"
												readonly><?php echo $template_contents ?></textarea>
										</div>
									</div>
								</div>
								<div class="advance_opt" style="cursor:pointer; display:none;">
									<h4 class="advance_opt_toggle">Advanced Options</h4>
									<div class="advance_opt_form" style="display:none;">
										<?php if ($_SESSION['userroleforpage'] == 1) { ?>
											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Context</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="context" name="context" placeholder="Extension Context"
														class="form-control" type="text" value="<?php echo $context; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Dtmfmode</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="dtmfmode" name="dtmfmode" class="form-control">
														<option <?php if ($dtmfmode == 'rfc2833') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="rfc2833">
															rfc2833</option>
														<option <?php if ($dtmfmode == 'info') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="info">info</option>
														<option <?php if ($dtmfmode == 'inband') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="inband">inband</option>
													</select>
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Deny</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="deny" name="deny"
														placeholder="Extension denied IP,accepts comma seperated values"
														value="<?php echo $deny; ?>" class="form-control" type="text"
														value="" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Permit</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="permit" name="permit"
														placeholder="Extension denied IP,accepts comma seperated values"
														value="<?php echo $permit; ?>" class="form-control" type="text"
														value="" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">IP Address</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="ipaddr" name="ipaddr"
														placeholder="Dotted Quad IP address of the peer"
														class="form-control" type="text" value="<?php echo $ipaddr; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Default User</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="defaultuser" name="defaultuser"
														placeholder="defaultuser = The new name for the `username` variable"
														class="form-control" type="text"
														value="<?php echo $defaultuser; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Account Code</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="accountcode" name="accountcode"
														placeholder="Account Code=account code will be assigned to a call record "
														class="form-control" type="text"
														value="<?php echo $accountcode; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Register Exten</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="regexten" name="regexten"
														placeholder="Regexten=Peer name or actual extension to which it is to be registered"
														class="form-control" type="text" value="<?php echo $regexten; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Amaflags</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="amaflags" name="amaflags" class="form-control">
														<option <?php if ($amaflags == '0') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="0">Select</option>
														<option <?php if ($amaflags == 'default') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="default">
															default</option>
														<option <?php if ($amaflags == 'documentation') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>value="documentation">documentation</option>
														<option <?php if ($amaflags == 'omit') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="omit">omit</option>
														<option <?php if ($amaflags == 'billing') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="billing">
															billing</option>
													</select>
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Can-Reinvite</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="canreinvite" name="canreinvite" class="form-control">
														<option <?php if ($canreinvite == '0') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="0">Select</option>
														<option <?php if ($canreinvite == 'no') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="no">no</option>
														<option <?php if ($canreinvite == 'nonot') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="nonat">
															nonat
														</option>
														<option <?php if ($canreinvite == 'yes') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="yes">yes</option>
														<option <?php if ($canreinvite == 'update') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="update">
															update</option>
													</select>
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">From-user</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="fromuser" name="fromuser" placeholder="From User"
														class="form-control" type="text" value="<?php echo $fromuser; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">From-domain</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="fromdomain" name="fromdomain" placeholder="From Domain"
														class="form-control" type="text"
														value="<?php echo $fromdomain; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Host</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="host" name="host" placeholder="Host" class="form-control"
														type="text" value="<?php echo $host; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Dial Timeout</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="dial_timeout" name="dial_timeout"
														placeholder="Dial Timeout = number of seconds"
														value="<?php echo $dial_timeout; ?>" class="form-control"
														type="text" value="0" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Type</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="type" name="type" class="form-control">
														<option <?php if ($type == 'peer') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="peer">peer</option>
														<option <?php if ($type == 'friend') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="friend">friend</option>
														<option <?php if ($type == 'user') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="user">user</option>
													</select>
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Qualify</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="qualify" name="qualify"
														placeholder="Qualify= yes/no/milliseconds" class="form-control"
														type="text" value="<?php echo $qualify; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Port</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="port" name="port" placeholder="SIP signaling port"
														class="form-control" type="text" value="<?php echo $port; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Disallow</label>
												</div>
												<div class="col-12 col-md-8">
													<select id="disallow" name="disallow" class="form-control">
														<option value="0">Select</option>
														<option <?php if ($disallow == 'all') {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="all">all</option>
													</select>
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Allow</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="allow" name="allow"
														placeholder="Allow=comma seperated codesc like ulaw,alaw,gsm,g729"
														class="form-control" type="text" value="<?php echo $allow; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">RegSeconds</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="regseconds" name="regseconds"
														placeholder="Regseconds=Number of seconds" class="form-control"
														type="text" value="<?php echo $regseconds; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Fullcontact</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="fullcontact" name="fullcontact"
														placeholder="Format- [sip:peer@uri_contact]- SIP URI contact for realtime peer"
														class="form-control" type="text"
														value="<?php echo $fullcontact; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Lastms</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="lastms" name="lastms"
														placeholder="Lastms= number of milliseconds" class="form-control"
														type="text" value="<?php echo $lastms; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">RTP-Keep-Alive</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="rtpkeepalive" name="rtpkeepalive"
														placeholder="Rtpkeepalive = Number of seconds" class="form-control"
														type="text" value="<?php echo $rtpkeepalive; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">User-Agent</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="useragent" name="useragent"
														placeholder="Useragent=[string],allow the SIP header `User-Agent` to be customized"
														class="form-control" type="text"
														value="<?php echo $useragent; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Fail-Status</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="fail_status" name="fail_status"
														placeholder="Fail-Status = N/Y,Handle in case of failure"
														class="form-control" type="text"
														value="<?php echo $fail_status; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm"
														class=" form-control-label">Fail-Destination</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="fail_dest" name="fail_dest"
														placeholder="Fail-Destination=queues/extensions/voicemail/outside/terminate_calls"
														class="form-control" type="text"
														value="<?php echo $fail_dest; ?>" />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-4">
													<label for="selectSm" class=" form-control-label">Fail-Data</label>
												</div>
												<div class="col-12 col-md-8">
													<input id="fail_data" name="fail_data"
														placeholder="Fail-Data=value to go to voicemail/outside "
														class="form-control" type="text"
														value="<?php echo $fail_data; ?>" />
												</div>
											</div>
										<?php } else { ?>

											<input id="context" name="context" class="form-control" type="hidden"
												value="<?php echo $context; ?>">
											<input id="defaultuser" name="defaultuser" class="form-control" type="hidden"
												value="<?php echo $defaultuser; ?>">
											<input id="ipaddr" name="ipaddr" class="form-control" type="hidden"
												value="<?php echo $ipaddr; ?>">
											<input id="dtmfmode" name="dtmfmode" class="form-control" type="hidden"
												value="<?php echo $dtmfmode; ?>">
											<input id="deny" name="deny" class="form-control" type="hidden"
												value="<?php echo $deny; ?>">
											<input id="permit" name="permit" class="form-control" type="hidden"
												value="<?php echo $permit; ?>">
											<input id="accountcode" name="accountcode" class="form-control" type="hidden"
												value="<?php echo $accountcode; ?>">
											<input id="regexten" name="regexten" class="form-control" type="hidden"
												value="<?php echo $regexten; ?>">
											<input id="fromuser" name="fromuser" class="form-control" type="hidden"
												value="<?php echo $fromuser; ?>">
											<input id="fromdomain" name="fromdomain" class="form-control" type="hidden"
												value="<?php echo $fromdomain; ?>">
											<input id="host" name="host" class="form-control" type="hidden"
												value="<?php echo $host; ?>">
											<input id="dial_timeout" name="dial_timeout" class="form-control" type="hidden"
												value="<?php echo $dial_timeout; ?>">
											<input id="qualify" name="qualify" class="form-control" type="hidden"
												value="<?php echo $qualify; ?>">
											<input id="port" name="port" class="form-control" type="hidden"
												value="<?php echo $port; ?>">
											<input id="allow" name="allow" class="form-control" type="hidden"
												value="<?php echo $allow; ?>">
											<input id="regseconds" name="regseconds" class="form-control" type="hidden"
												value="<?php echo $regseconds; ?>">
											<input id="fullcontact" name="fullcontact" class="form-control" type="hidden"
												value="<?php echo $fullcontact; ?>">
											<input id="rtpkeepalive" name="rtpkeepalive" class="form-control" type="hidden"
												value="<?php echo $rtpkeepalive; ?>">
											<input id="useragent" name="useragent" class="form-control" type="hidden"
												value="<?php echo $useragent; ?>">
											<input id="fail_status" name="fail_status" class="form-control" type="hidden"
												value="<?php echo $fail_status; ?>">
											<input id="fail_dest" name="fail_dest" class="form-control" type="hidden"
												value="<?php echo $fail_dest; ?>">
											<input id="fail_data" name="fail_data" class="form-control" type="hidden"
												value="<?php echo $fail_data; ?>">
											<input id="disallow" name="disallow" class="form-control" type="hidden"
												value="<?php echo $disallow; ?>">
											<input id="type" name="type" class="form-control" type="hidden"
												value="<?php echo $type; ?>">
											<input id="canreinvite" name="canreinvite" class="form-control" type="hidden"
												value="<?php echo $canreinvite; ?>">
											<input id="amaflags" name="amaflags" class="form-control" type="hidden"
												value="<?php echo $amaflags; ?>">

										<?php } ?>
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="selectSm" class=" form-control-label">NAT</label>
											</div>
											<div class="col-12 col-md-8">
												<select id="nat" name="nat" class="form-control">
													<option <?php if ($nat == 'force_rport,comedia') {
														echo 'selected="selected"';
													} ?> value="force_rport,comedia">
														force_rport,comedia</option>
													<option <?php if ($nat == 'yes') {
														echo 'selected="selected"';
													} ?>
														value="yes">yes</option>
													<option <?php if ($nat == 'no') {
														echo 'selected="selected"';
													} ?>
														value="no">no</option>
													<option <?php if ($nat == 'never') {
														echo 'selected="selected"';
													} ?>
														value="never">never</option>
												</select>
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
	<script>
		$("input[name='renew']").on("change", function () {
			var input = $(this).val();
			if (input == 1) {
				$("#payment_type").css('display', 'block');
			} else {
				$("#payment_type").css('display', 'none');
			}

		});

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

		$("select[name='clientId']").change(function () {
			var selectedUSERS = $(this).val();
			if (selectedUSERS) {
				$.ajax({
					url: "ajaxoutbound.php",
					dataType: 'Json',
					data: { 'id': selectedUSERS },
					success: function (data) {
						$('select[name="outbound_cid"]').empty();
						$.each(data, function (key, value) {
							$('select[name="outbound_cid"]').append('<option value="' + key + '">' + value + '</option>');
						});
					}
				});
			} else {
				$('select[name="outbound_cid"]');
				$.each(data, function (key, value) {
					$('select[name="outbound_cid"]').append('<option value="' + key + '">' + value + '</option>');
				});
			}
		});


		$(document).ready(function () {
			//	genratePassword();	
			$('#genratePassword').click(function () {
				genratePassword();
			});
			function genratePassword() {
				$.ajax({
					url: "ajaxCreatePasswords.php",
					dataType: 'Json',
					data: '',
					success: function (data) {
						$('#secret').val(data.password);
					}
				});
			}
		});

		var radioBtns1 = document.querySelectorAll('input[name="voicemail"]');
		var dataDiv1 = document.getElementById('dataDiv1');
		if (radioBtns1[0].checked) {
			dataDiv1.style.display = 'block';
		}
		radioBtns1.forEach(function (radioBtn) {
			radioBtn.addEventListener('change', function () {
				if (this.value === 'Yes' && this.checked) {
					dataDiv1.style.display = 'block';
					$("#agentEmail").attr("required", "true");
				} else {
					dataDiv1.style.display = 'none';
					$("#agentEmail").removeAttr("required");
				}
			});
		});
	</script>


	<script>
		var radioBtns = document.querySelectorAll('input[name="ivr"]');
		var dataDiv = document.getElementById('dataDiv');
		if (radioBtns[0].checked) {
			dataDiv.style.display = 'block';
		}
		radioBtns.forEach(function (radioBtn) {
			radioBtn.addEventListener('change', function () {
				if (this.value === '1' && this.checked) {
					dataDiv.style.display = 'block';
				} else {
					dataDiv.style.display = 'none';
				}
			});
		});
	</script>

	<?php require_once ('footer.php'); ?>