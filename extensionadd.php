<?php
require_once ('header.php');
//echo '<pre>'; print_r($_SESSION); echo '</pre>'; exit;

$message = '';
$query_client = "SELECT Client.clientName,Client.clientEmail, Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);

if (isset($_POST['selectedUser'])) {
	$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "' AND parent = '0'";
	$result_user_details = mysqli_query($connection, $query_user);
	$userDetails = mysqli_fetch_assoc($result_user_details); 
} else {
	$_POST['clientId'] = '';
}
$extension_number = isset($_POST['extension_number']) ? $_POST['extension_number'] : '';
if ($_SESSION['userroleforpage'] == '2') {

	$query_did = "select did from cc_did WHERE clientId = '" . $_SESSION['userroleforclientid'] . "'";
	$result_outbound = mysqli_query($connection, $query_did);
}
if (isset($_POST['submit'])) {

	// echo '<pre>';print_r($_POST);exit;
	if ($_SESSION['userroleforpage'] == '2') {
		if ($_SESSION['login_user_plan_id'] == '1') {
			$_POST['clientId'] = $_SESSION['userroleforclientid'];
			$_POST['selectedUser'] = $_SESSION['login_user_id'];
		} else {
			$_POST['clientId'] = '';
			$_POST['selectedUser'] = '';
		}
	}
	$extension_name_arr = explode(',', $_POST['extension_name']);
	$error = 'false';
	if ($_SESSION['userroleforpage'] == 1) {
		if ($_POST['payment'] == 1) {

			if ($userDetails['role'] == 3) {
				$userId = $userDetails['id'];
			} else {
				$userId = '0';
			}
			$payment_status = "Paid";
			$priceQuery = "select * from cc_did_exten_price WHERE type='extension' and user_id = '" . $userId . "'";
			$priceRecords = mysqli_query($con, $priceQuery);
			$price_row = mysqli_fetch_assoc($priceRecords);
			$ext_price = $price_row['price'] * (count($extension_name_arr));

			$select_cust_credit = "select credit from cc_card where id='" . $userDetails['id'] . "'";
			$result_cust = mysqli_query($connection, $select_cust_credit);

			$rowcredit = mysqli_fetch_assoc($result_cust);
			$current_credit = $rowcredit['credit'];
			// echo $current_credit;exit;

			if ($ext_price > $current_credit) {
				$message = "Not Enough Credit";
				$error = "true";
			} else {
				$updated_credit = $current_credit - $ext_price;
				$update_credit = "update cc_card set credit='" . $updated_credit . "' where id='" . $userDetails['id'] . "'";
				$resultupdate = mysqli_query($connection, $update_credit);
				$error = "false";
			}
		} else {
			$payment_status = "Free";
		}
	}

	if ($error == 'false') {
		$extension_name = "SELECT `name` from `cc_sip_buddies` where `name` IN (" . $_POST['extension_name'] . ")";

		$query_name = mysqli_query($connection, $extension_name) or die("extension get failed");
		if (mysqli_num_rows($query_name) > 0) {
			$message = " Extesions number already exist";
		} else {
			$ssecret = $_POST['secret'];
			$select_card = "select username from cc_card where id='" . $_POST['selectedUser'] . "'";
			$query_card = mysqli_query($con, $select_card);
			$rowcard = mysqli_fetch_array($query_card);
			$carduser = $rowcard['username'];

			/* $select_agentinfo = "insert into AgentInfo (ext,instantCallMail,name,queue,status) VALUES ('".$_POST['name']."','No','".$_POST['agent_name']."','0','1')";
														 $query_agentinfo = mysqli_query($con, $select_agentinfo); */

			if ($_SESSION['login_user_plan_id'] == '1' || $_SESSION['userroleforpage'] == '1') {
				$dynamic = 'dynamic';
				$ext_status = '1';
			} else {
				$dynamic = 'static';
				$ext_status = '0';
			}
			$created_at = date('Y-m-d H:i:s');
			$startingdate = date('Y-m-d H:i:s');
			$expirationdate = date('Y-m-d H:i:s', strtotime('+29 days'));

			// print_r($extension_name_arr); exit;
			$exg_id = $extension_name_arr[0];
			$lead_operator = $_POST['lead_operator'];

			$outbound_cid = isset($_POST['outbound_cid']) ? $_POST['outbound_cid'] : '';
			foreach ($extension_name_arr as $ex_key => $extension_name) {

				$lead_operator = $_POST['lead_operator'] + $ex_key;

				$insert_sip = "insert into cc_sip_buddies (clientId,id_cc_card,exg_id, name,regexten,agent_name, lead_operator, callerid,secret,context,dtmfmode,deny,permit,ipaddr,defaultuser,accountcode,amaflags,canreinvite,fromuser,fromdomain,host,dial_timeout,type,qualify,port,disallow,allow,regseconds,fullcontact,lastms,rtpkeepalive,useragent,user_id,fail_status,fail_dest ,fail_data,nat,sip_type,play_ivr,ext_status,created_at,startingdate,expirationdate,outbound_cid,recording) VALUES('" . $_POST['clientId'] . "','" . $_POST['selectedUser'] . "','" . $exg_id . "','" . trim($extension_name) . "','" . trim($extension_name) . "','" . $_POST['agent_name'] . "','" . $lead_operator . "','" . $outbound_cid . "','" . $_POST['secret'] . "','" . $_POST['context'] . "','" . $_POST['dtmfmode'] . "','" . $_POST['deny'] . "','" . $_POST['permit'] . "', '" . $_POST['ipaddr'] . "','" . $_POST['defaultuser'] . "','" . $carduser . "','billing','" . $_POST['canreinvite'] . "','" . $_POST['fromuser'] . "','" . $_POST['fromdomain'] . "','" . $dynamic . "','" . $_POST['dial_timeout'] . "','" . $_POST['type'] . "','" . $_POST['qualify'] . "','" . $_POST['port'] . "','" . $_POST['disallow'] . "','" . $_POST['allow'] . "','" . $_POST['regseconds'] . "','" . $_POST['fullcontact'] . "','" . $_POST['lastms'] . "','" . $_POST['rtpkeepalive'] . "','" . $_POST['useragent'] . "','" . $_POST['selectedUser'] . "','" . $_POST['fail_status'] . "','" . $_POST['fail_dest'] . "','" . $_POST['fail_data'] . "','" . $_POST['nat'] . "','" . $_POST['sip_type'] . "','1','" . $ext_status . "','" . $created_at . "', '" . $startingdate . "', '" . $expirationdate . "','" . $_POST['outboundcall'] . "','" . $_POST['callRecording'] . "')";

				//echo $insert_sip; exit;
				mysqli_query($con, $insert_sip);

				$ext_query_web_template = "select * from cc_conf_templates";
				$web_res = mysqli_query($con, $ext_query_web_template);
				while ($web_temp_res = mysqli_fetch_array($web_res)) {
					$template_id = $web_temp_res['template_id'];
					$template_name = $web_temp_res['template_name'];
					$template_contents = $web_temp_res['template_contents'];
				}

				$register_string = "\n[$extension_name]\nusername=$extension_name\nsecret=$ssecret\naccountcode=$carduser\n$template_contents\n";
				$webrtc_conf_path = "/var/www/html/callanalog/admin/webrtc_template.conf";

				file_put_contents($webrtc_conf_path, $register_string, FILE_APPEND | LOCK_EX);

				echo "Registration successful. The SIP users have been added to the webrtc_template.conf file.";

				if ($_POST['voicemail'] == 'Yes') {
					$insert_voicemail = "insert into cc_voicemail_users (customer_id,mailbox,fullname,email) VALUES ('" . $_POST['selectedUser'] . "','" . $extension_name . "','" . $_POST['agent_name'] . "','" . $_POST['agentEmail'] . "')";
					$insert_voicemail_query = mysqli_query($con, $insert_voicemail);
				}
			}

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
															 ssh2_disconnect($conn); */
			if (SERVER_FLAG == 1) {
				$result = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');

				sip_reload();
			}

			//$reeee = '1';//;
			//$last_id = mysqli_insert_id($con);
			//echo $_SESSION['login_user_plan_id'].'';
			if ($_SESSION['userroleforpage'] == '1' || $_SESSION['login_user_plan_id'] == '1') {

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
				$priceQuery = "select * from cc_did_exten_price WHERE type='extension' and user_id = '0'";
				$priceRecords = mysqli_query($con, $priceQuery);
				$price_row = mysqli_fetch_assoc($priceRecords);

				$item_number = $_POST['extension_name'];
				$quantity = 1;
				$i = 1;
				$invoice_amount = 0;
				$payment_status = 'Free';
				$item_type = 'Extension';
				$invoice_amount = $price_row['price'] * (count($extension_name_arr));
				$insert_invoice = "insert into 	invoices (user_id, invoice_id, item_type, invoice_currency, invoice_amount, invoice_subtotal_amount,payment_status) VALUES ('" . $user_id . "','" . $invoice_id . "', '" . $item_type . "','" . $invoice_currency . "','" . $invoice_amount . "','" . $invoice_amount . "','" . $payment_status . "')";
				$query_res = mysqli_query($con, $insert_invoice);
				$invo_id = mysqli_insert_id($con);

				$item_price = $price_row['price'];
				foreach ($extension_name_arr as $ex_key => $extension_name) {
					$insert_invoice_item = "insert into invoices_items (invoice_id, item_type, item_number, price) VALUES ('" . $invo_id . "','" . $item_type . "','" . $extension_name . "','" . $item_price . "')";
					$query_res_invo = mysqli_query($con, $insert_invoice_item);
				}
				$gatway_order_id = $invoice_id . '-UID-' . $user_id;
				if ($_SESSION['userroleforpage'] == '2' and $_SESSION['login_user_plan_id'] == '1') {
					$payment_type = 'Free By User';
				} elseif ($_POST['payment'] == 1) {
					$payment_type = 'Wallet';
				} else {
					$payment_type = 'Free By Admin';
				}
				$user_name = $userDetails['name'];
				$email = $userDetails['email'];
				$insert_invoice = "insert into gateways_payments (user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('" . $user_id . "','" . $invo_id . "','" . $invoice_id . "', '" . $gatway_order_id . "','" . $payment_type . "','" . $item_type . "','" . $user_name . "','" . $email . "','Stripe Myphonesystems', '" . $item_number . "','" . $invoice_amount . "','" . $invoice_currency . "','success','" . date('Y-m-d H:i:s') . "')";
				$query_res = mysqli_query($con, $insert_invoice);
				$gateway_id = mysqli_insert_id($con);

				if ($_SESSION['userroleforpage'] == '1') {
                    		$activity_type = 'Extension Assign to User';
                    		$msg = $_POST['extension_number'] . ' ' . 'Extension Assign Succesfully!' . ' ' . $payment_type;
                		} else {
                    		$activity_type = 'Extension Purchase By User';
                    		$msg = $_POST['extension_number'] . ' ' . 'Extension Purchase Succesfully!' . ' ' . $payment_type;
                		}
				user_activity_log($_SESSION['login_user_id'], $_SESSION['userroleforclientid'], $activity_type, $msg);
				$_SESSION['msg'] = 'Extension Added Succesfully!';
				make_pdf($invo_id, $user_id);
				echo '<script>window.location.href="extension.php"</script>';
			} else {
				echo '<script>location.href = "./create_ext_invoice.php?ext=' . base64_encode($exg_id) . '"</script>';
			}
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
						<h2 class="title-1"> Extension Add <span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="extension.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i>Extension</button>
							</a>
						</div>

					</div>
				</div>
			</div>
			<input type="hidden" value="1" id="userrole" />
			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="extensionForm" action="" method="post">
								<?php //			echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
								if ($_SESSION['userroleforpage'] == '1') { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" onchange="showUsercredit(this.value)"
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
											<label for="text-input" class="form-control-label">Select User*</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="selectedUser" name="selectedUser" class="form-control" required>
												<option value="" selected="selected" onchange="plan(this.id)">Select
												</option>
												<?php if (isset($_POST['selectedUser'])) {
													$row_user = $userDetails;
													?>
													<option <?php if ($row_user['id'] == $_POST['selectedUser']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $row_user['id']; ?>">
														<?php echo $row_user['name']; ?>
													</option>
													<?php
												} ?>
											</select>
											<strong>Credit Available : <span id="txtHint">
													<?php if (isset($_POST['credit'])) {
														echo $_POST['credit'];
													} else {
														echo '0.0';
													} ?>
												</span></strong>
											<input type="hidden" name="credit" id="credit" />
										</div>
									</div>
									<?php
								} else { ?>
									<input id="clientId" name="clientId"
										value="<?php echo $_SESSION['userroleforclientid']; ?>" type="hidden">
									<input id="selectedUser" name="selectedUser"
										value="<?php echo $_SESSION['login_user_id']; ?>" type="hidden">

								<?php } ?>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">No of
											Extension*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="extension_number" name="extension_number"
											placeholder="Number of Extension" class="form-control" required
											type="number" value="" />
									</div>
								</div>


								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Extension Number</label>
									</div>
									<div class="col-12 col-md-8">
										<textarea readonly id="extension_name" name="extension_name"
											placeholder="Extension Number" class="form-control" required><?php if (isset($_POST['extension_name'])) {
												echo $_POST['extension_name'];
											} else {
												echo '';
											} ?>  </textarea>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Extension Name*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="agent_name" name="agent_name" placeholder="Extension Name"
											class="form-control" required type="text" value="<?php if (isset($_POST['agent_name'])) {
												echo $_POST['agent_name'];
											} else {
												echo '';
											} ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Intercom*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="lead_operator" name="lead_operator" placeholder="Intercom"
											class="form-control" type="number" value="<?php if (isset($_POST['lead_operator'])) {
												echo $_POST['lead_operator'];
											} else {
												echo '';
											} ?>" required />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Outbound Caller Id*</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="outbound_cid" name="outbound_cid" class="form-control">
											<option value="0">Select</option>
											<?php
											if ($_SESSION['userroleforpage'] == '2') {

												while ($row_outbound = mysqli_fetch_array($result_outbound)) { ?>
													<option <?php if (isset($_POST['outbound_cid']) && $row_outbound['did'] == $_POST['outbound_cid']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $row_outbound['did']; ?>">
														<?php echo $row_outbound['did']; ?>
													</option>
												<?php }
											} ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label"> Extension Password</label>
									</div>
									<div class="col-10 col-md-6">
										<input id="secret" required name="secret"
											placeholder="Generate Extension Password" class="form-control" type="text"
											value="<?php if (isset($_POST['secret'])) {
												echo $_POST['secret'];
											} else {
												echo '';
											} ?>" />
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
												style="margin-right:15px;  color: black;">
												<input id="sip_type1" name="sip_type" name="inline-radios"
													class="form-check-input" type="radio" value="Yes" /> Yes
											</label>
											<label for="sip_type2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="sip_type2" name="sip_type" name="inline-radios"
													checked="true" class="form-check-input" type="radio" value="No" />
												No
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
													class="form-check-input" type="radio" value="Yes" /> Yes
											</label>
											<label for="voicemail2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="voicemail2" name="voicemail" name="voicemail inline-radios"
													checked="true" class="form-check-input" type="radio" value="No" />
												No
											</label>
										</div>
									</div>
								</div>
								<?php
								if (!isset($_POST['voicemail']) || (isset($_POST['voicemail']) && $_POST['voicemail'] == 'No')) {
									$style = "display:none;";
								} else {
									$style = "display:block;";
								}
								?>
								<div class="showhideForm" id="dataDiv1" style="<?php echo $style; ?>">
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">VoiceMail Email</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="agentEmail" name="agentEmail" placeholder="voicemail"
												class="form-control" type="email" value="" />
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
													type="radio" value="1" <?php if (!isset($_POST['outboundcall']) || (isset($_POST['outboundcall']) && $_POST['outboundcall'] == '1')) {
														echo "checked";
													} ?> /> Yes
											</label>
											<label for="outboundcall2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="outboundcall2" name="outboundcall" class="form-check-input"
													type="radio" value="0" <?php if (!isset($_POST['outboundcall']) || (isset($_POST['outboundcall']) && $_POST['outboundcall'] == '0')) {
														echo "checked";
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
													type="radio" value="1" <?php if (!isset($_POST['callRecording']) || (isset($_POST['callRecording']) && $_POST['callRecording'] == '1')) {
														echo "checked";
													} ?> /> Yes
											</label>
											<label for="callRecording2" class="form-check-label "
												style="margin-right:15px;     color: black;">
												<input id="callRecording2" name="callRecording" class="form-check-input"
													type="radio" value="0" <?php if ((isset($_POST['callRecording']) && $_POST['callRecording'] == '0')) {
														echo "checked";
													} ?> /> No
											</label>
										</div>
									</div>
								</div>


								<?php if ($_SESSION['userroleforpage'] == '1' || $_SESSION['login_user_plan_id'] != '1') {
									if (isset($_POST['payment'])) {
										$pay_class = "block";
									} else {
										$pay_class = "none";
									}
									?>

									<div id="payment_type" style="display:<?php echo $pay_class; ?>;">
										<div class="row form-group barge_radio_btn">
											<div class="col col-md-4">
												<label class=" form-control-label"> Payment Type</label>
											</div>
											<div class="col col-md-8">
												<div class="form-check-inline form-check">
													<label for="inline-tariff1" class="form-check-label"
														style="margin-right:15px; color:black;">
														<input id="inline-tariff1" name="payment" class="form-check-input"
															type="radio" value="0" <?php if (!isset($_POST['payment']) || (isset($_POST['payment']) && $_POST['payment'] == '0')) {
																echo "checked";
															} ?> /> Free
													</label>
													<label for="inline-tariff2" class="form-check-label"
														style="color:black;">
														<input id="inline-tariff2" name="payment" class="form-check-input"
															type="radio" value="1" <?php if (isset($_POST['payment']) && $_POST['payment'] == '1') {
																echo "checked";
															} ?> />
														Paid
													</label>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="advance_opt" style="cursor:pointer; display:none;">
									<h4 class="advance_opt_toggle">Advanced Options</h4>
									<div class="advance_opt_form" style="display:none;">

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Context</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="context" name="context" placeholder="Extension Context"
													class="form-control" type="text" value="<?php if (isset($_POST['context'])) {
														echo $_POST['context'];
													} else {
														echo 'textricks-outcall';
													} ?>" />
											</div>
										</div>



										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Dtmfmode</label>
											</div>
											<div class="col-12 col-md-9">
												<select id="dtmfmode" name="dtmfmode" class="form-control">
													<option <?php if (isset($_POST['dtmfmode']) && $_POST['dtmfmode'] == 'rfc2833') {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="rfc2833">rfc2833</option>
													<option <?php if (isset($_POST['dtmfmode']) && $dtmfmode == 'info') {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="info">
														info</option>
													<option <?php if (isset($_POST['dtmfmode']) && $dtmfmode == 'inband') {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="inband">inband</option>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Deny</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="deny" name="deny"
													placeholder="Extension denied IP,accepts comma seperated values"
													class="form-control" type="text" value="<?php if (isset($_POST['deny'])) {
														echo $_POST['deny'];
													} else {
														echo '0.0.0.0/0.0.0.0';
													} ?>" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Permit</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="permit" name="permit"
													placeholder="Extension denied IP,accepts comma seperated values"
													class="form-control" type="text" value="<?php if (isset($_POST['permit'])) {
														echo $_POST['permit'];
													} else {
														echo '0.0.0.0/0.0.0.0';
													} ?>" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">IP Address</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="ipaddr" name="ipaddr"
													placeholder="Dotted Quad IP address of the peer"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Default User</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="defaultuser" name="defaultuser"
													placeholder="defaultuser = The new name for the `username` variable"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Account Code</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="accountcode" name="accountcode"
													placeholder="Account Code=account code will be assigned to a call record "
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Register Exten</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="regexten" name="regexten"
													placeholder="Regexten=Peer name or actual extension to which it is to be registered"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Amaflags</label>
											</div>
											<div class="col-12 col-md-9">
												<select id="amaflags" name="amaflags" class="form-control">
													<option value="0">Select</option>
													<option value="default">default</option>
													<option value="documentation">documentation</option>
													<option value="omit">omit</option>
													<option value="billing">billing</option>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Can-Reinvite</label>
											</div>
											<div class="col-12 col-md-9">
												<select id="canreinvite" name="canreinvite" class="form-control">
													<option value="0">Select</option>
													<option value="no">no</option>
													<option value="nonat">nonat</option>
													<option value="yes">yes</option>
													<option value="update">update</option>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">From-user</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="fromuser" name="fromuser" placeholder="From User"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">From-domain</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="fromdomain" name="fromdomain" placeholder="From Domain"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Host</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="host" name="host" placeholder="Host" class="form-control"
													type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Dial Timeout</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="dial_timeout" name="dial_timeout"
													placeholder="Dial Timeout = number of seconds" value="30"
													class="form-control" type="text" value="0" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Type</label>
											</div>
											<div class="col-12 col-md-9">
												<select id="type" name="type" class="form-control">
													<option value="friend">friend</option>
													<option value="peer">peer</option>
													<option value="user">user</option>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Qualify</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="qualify" name="qualify"
													placeholder="Qualify= yes/no/milliseconds" class="form-control"
													type="text" value="yes" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Port</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="port" name="port" placeholder="SIP signaling port"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Disallow</label>
											</div>
											<div class="col-12 col-md-9">
												<select id="disallow" name="disallow" class="form-control">
													<!-- <option value="0">Select</option> -->
													<option value="all" selected>ALL</option>
												</select>
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Allow</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="allow" name="allow"
													placeholder="Allow=comma seperated codesc like ulaw,alaw,gsm,g729"
													value="ulaw,alaw,gsm,g729" class="form-control" type="text"
													value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">RegSeconds</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="regseconds" name="regseconds"
													placeholder="Regseconds=Number of seconds" value="0"
													class="form-control" type="text" value="0" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Fullcontact</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="fullcontact" name="fullcontact"
													placeholder="Format- [sip:peer@uri_contact]- SIP URI contact for realtime peer"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Lastms</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="lastms" name="lastms"
													placeholder="Lastms= number of milliseconds" class="form-control"
													type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">RTP-Keep-Alive</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="rtpkeepalive" name="rtpkeepalive"
													placeholder="Rtpkeepalive = Number of seconds" class="form-control"
													type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">User-Agent</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="useragent" name="useragent"
													placeholder="Useragent=[string],allow the SIP header `User-Agent` to be customized"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Fail-Status</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="fail_status" name="fail_status"
													placeholder="Fail-Status = N/Y,Handle in case of failure"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm"
													class=" form-control-label">Fail-Destination</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="fail_dest" name="fail_dest"
													placeholder="Fail-Destination=queues/extensions/voicemail/outside/terminate_calls"
													class="form-control" type="text" value="" />
											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">Fail-Data</label>
											</div>
											<div class="col-12 col-md-9">
												<input id="fail_data" name="fail_data"
													placeholder="Fail-Data=value to go to voicemail/outside "
													class="form-control" type="text" value="" />
											</div>
										</div>



										<div class="row form-group">
											<div class="col col-md-3">
												<label for="selectSm" class=" form-control-label">NAT</label>
											</div>
											<div class="col-12 col-md-9">
												<select id="nat" name="nat" class="form-control">
													<option value="force_rport,comedia">force_rport,comedia</option>
													<option value="no">no</option>
													<option value="never">never</option>
												</select>
											</div>
										</div>
										<div class="row form-group barge_radio_btn">
											<div class="col col-md-3">
												<label class=" form-control-label">Web Template</label>
											</div>
											<div class="col col-md-9">
												<div class="form-check-inline form-check">
													<label for="inline-radio1" class="form-check-label "
														style="margin-right:15px; color:black;">
														<input id="ivr" name="ivr" class="showbtn form-check-input"
															type="radio" value="1" <?php if (isset($_POST['ivr']) && $_POST['ivr'] == '1') {
																echo "checked";
															} ?>>Yes
													</label>
													<label for="inline-radio2" class="form-check-label "
														style="color:black;">
														<input id="ivr" name="ivr" class="hidebtn form-check-input"
															type="radio" value="0" <?php if (isset($_POST['ivr']) && $_POST['ivr'] == '0') {
																echo "checked";
															} ?>>No
													</label>
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
	function plan(id) {
		if (id == 'prefix') {
			document.getElementById('prefixhide').style.display = "block";
			document.getElementById('phonehide').style.display = "none";
			document.getElementById('prefix').setAttribute('required', 'true');
			document.getElementById('phonenumber').removeAttribute('required');
		} else {
			document.getElementById('phonehide').style.display = "block";
			document.getElementById('prefixhide').style.display = "none";
			document.getElementById('phonenumber').setAttribute('required', 'true');
			document.getElementById('prefix').removeAttribute('required');
		}
	}
	$("#extension_number").on("keyup", function () {
		var extension_number = $(this).val();
		if (extension_number) {
			if ($.isNumeric(extension_number)) {
				$.ajax({
					url: "ajaxGetExtensions.php",
					data: { 'extension_number': extension_number },
					success: function (data) {
						//console.log(data.trim());   
						$('#extension_name').val(data.trim());
					}
				});
			} else {
				alert("Please Type Only Digits..");
			}
		} else {
			$('#extension_name').val("");
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

	function showUsercredit(str) {
		$.ajax({
			url: 'ajaxcredit.php',
			type: 'GET',
			data: { q: str },
			success: function (response) {
				$("#txtHint").text(response);
				$("#credit").val(response);
			}
		});


		$.ajax({
			url: 'userGetPlan.php',
			type: 'get',
			data: { id: str },
			success: function (response) {
				if (response == 0) {
					$("#payment_type").css('display', 'block');
				} else {
					$("#payment_type").css('display', 'none');
				}
			}
		});
	}

</script>

<?php require_once ('footer.php'); ?>
