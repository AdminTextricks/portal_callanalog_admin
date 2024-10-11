<?php
include 'connection.php';
include 'functions.php';


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	//echo '<pre>'; print_r($_POST); echo '</pre>';exit;
	if ($_POST['payment_type'] == 'Wallet') {
		$user_id = $_POST['user_id'];
		$invoice_id = $_POST['invoice_id'];
		$gatway_invoice_id = $_POST['gatway_invoice_id'];
		$item_type = $_POST['item_type'];
		$user_name = $_POST['user_name'];
		$email = $_POST['email'];
		$paid_amount = $_POST['paid_amount'];
		$currency = $_POST['currency'];
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_type = $_POST['payment_type'];
		$renew_item = $_POST['renew'];
		//echo "<pre>"; print_r($_POST); die();


		//echo '<pre>'; print_r($item_number); exit;
		$gatway_order_id = $gatway_invoice_id . '-UID-' . $user_id;

		$user_row = '';
		$user_select = "SELECT firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
		$user_details = mysqli_query($connection, $user_select);
		if (mysqli_num_rows($user_details) > 0) {
			$card_row = mysqli_fetch_assoc($user_details);

			if ($paid_amount > 0) {
				$insert_invoice = "insert into gateways_payments (user_id, invoice_db_id,gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $gatway_invoice_id . "', '" . $gatway_order_id . "','" . $payment_type . "','" . $item_type . "','" . $user_name . "','" . $email . "','" . $item_name . "', '" . $item_number . "','" . $paid_amount . "','" . $currency . "','success','" . date('Y-m-d H:i:s') . "')";
				$query_res = mysqli_query($con, $insert_invoice);
				$invo_id = mysqli_insert_id($con);

				if ($invo_id > 0) {
					$update_sql = "update `invoices` set payment_status='Paid' where id='" . $invoice_id . "'";
					$update_res = mysqli_query($connection, $update_sql);

					$balance = $card_row['credit'] - $paid_amount;
					$_SESSION['login_user_credits'] = $balance;
					$user_select = "update `cc_card` set credit='" . $balance . "' where id='" . $user_id . "'";
					$user_details = mysqli_query($connection, $user_select);

					$itemNumber_array = explode('-', $item_number);
					// echo '<pre>'; print_r($itemNumber_array); echo '</pre>';exit;
					foreach ($itemNumber_array as $itemNo) {
						$startingdate = date('Y-m-d H:i:s');
						$expirationdate = date('Y-m-d H:i:s', strtotime('+29 days'));
						if (strtoupper($item_type) == 'DID') {

							if ($renew_item == 1) {
								$select_did_sql = "select expirationdate from cc_did where did='" . $itemNo . "'";
								$select_did_res = mysqli_query($connection, $select_did_sql) or die("query failed : select_did_sql");
								if (mysqli_num_rows($select_did_res) > 0) {
									$rows = mysqli_fetch_assoc($select_did_res);
								}
								$today = strtotime(date('Y-m-d H:i:s'));
								$expire = strtotime($rows['expirationdate']);

								$timeleft = $expire - $today;
								$daysleft = round((($timeleft / 24) / 60) / 60);
								if ($daysleft <= 3 && $daysleft >= 0) {
									$expirationdate = date('Y-m-d H:i:s', strtotime('+29 days', strtotime($rows['expirationdate'])));
								}
								$update_did_sql = "update `cc_did` set  activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active' where did = '" . $itemNo . "'";
								$update_did_res = mysqli_query($connection, $update_did_sql);
							} else {
								$update_did_sql = "update `cc_did` set iduser='" . $user_id . "', billingtype='" . $_SESSION['login_user_plan_id'] . "', activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active', clientId='" . $_SESSION['userroleforclientid'] . "' where did = '" . $itemNo . "'";
								$update_did_res = mysqli_query($connection, $update_did_sql);

								$select_did = "SELECT id,iduser,didtype,clientId FROM `cc_did` where did='" . $itemNo . "'";
								$details_did = mysqli_query($connection, $select_did);
								$did_row = mysqli_fetch_assoc($details_did);

								$insert_destination = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`) VALUES ( '0000', 'none', '1', '" . $user_id . "', '" . $did_row['id'] . "','1','1')";
								$result_destination = mysqli_query($connection, $insert_destination);

								/******** Create DID purchase history */
								$insert_did_history = "INSERT INTO `did_buying_history` ( `user_id`, `clientId`, `did_id`, `purchase_date`, `expiry_date`) VALUES ( '" . $user_id . "', '" . $_SESSION['userroleforclientid'] . "', '" . $did_row['id'] . "', '" . $startingdate . "','" . $expirationdate . "')";
								$result_did_history = mysqli_query($connection, $insert_did_history);
							}
						}
						if ($item_type == 'Extension') {
							if ($renew_item == 1) {
								$select_sql = "select play_ivr,secret,accountcode,expirationdate from cc_sip_buddies where name='" . $itemNo . "'";
								$select_res = mysqli_query($connection, $select_sql) or die("query failed : select_sql");
								if (mysqli_num_rows($select_res) > 0) {
									$row = mysqli_fetch_assoc($select_res);
									$play_ivr = $row['play_ivr'];
									$ssecret = $row['secret'];
									$carduser = $row['accountcode'];
									if ($play_ivr == 1) {
										$ext_query_web_template = "select * from cc_conf_templates";
										$web_res = mysqli_query($con, $ext_query_web_template);
										while ($web_temp_res = mysqli_fetch_array($web_res)) {
											$template_id = $web_temp_res['template_id'];
											$template_name = $web_temp_res['template_name'];
											$template_contents = $web_temp_res['template_contents'];
										}

										$webrtc_conf_path = "/var/www/html/callanalog/admin/webrtc_template.conf";
										$register_string = "\n[$itemNo]\nusername=$itemNo\nsecret=$ssecret\naccountcode=$carduser\n$template_contents\n";
										file_put_contents($webrtc_conf_path, $register_string, FILE_APPEND | LOCK_EX);

									} else {
										$webrtc_conf_path = "/var/www/html/callanalog/admin/sip_additional.conf";// Update here live path 
										$register_string = "\n[$itemNo]\nusername=$itemNo\nsecret=$ssecret\naccountcode=$carduser\n" . SIP_TEMPLATE_CONTENT . "\n";
										file_put_contents($webrtc_conf_path, $register_string, FILE_APPEND | LOCK_EX);

									}
									$today = strtotime(date('Y-m-d H:i:s'));
									$expire = strtotime($row['expirationdate']);
									$timeleft = $expire - $today;
									$daysleft = round((($timeleft / 24) / 60) / 60);
									if ($daysleft <= 3 && $daysleft >= 0) {
										$expirationdate = date('Y-m-d H:i:s', strtotime('+29 days', strtotime($row['expirationdate'])));
									}

								}
								$update_ext_sql = "update `cc_sip_buddies` set startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', ext_status='1', host='dynamic' where name = '" . $itemNo . "'";
							} else {
								$update_ext_sql = "update `cc_sip_buddies` set id_cc_card='" . $user_id . "',accountcode='" . $card_row['username'] . "', user_id='" . $user_id . "', clientId='" . $_SESSION['userroleforclientid'] . "', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', ext_status='1', host='dynamic' where name = '" . $itemNo . "'";
							}
							$update_ext_res = mysqli_query($connection, $update_ext_sql);

							$message = 'Extension Purchase Succesfully!';
							// $activity_type = 'Extension Purchase ';
							// $msg = 'Extension No: '.$item_number.' '.'Extension Purchase Succesfully! By User From Wallet';
							// user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $msg);
						}
						//exit;
					}
					if ($renew_item == 1) {
						if ($item_type == 'Extension' && SERVER_FLAG == 1) {
							$result = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
							$result = shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
							sip_reload();
						}
						$activity_type = $item_type . ' ' . 'Renew';
						$message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Renewed Succesfully! By User From Wallet';
					} else {
						$activity_type = $item_type . ' ' . 'Purchase';
						$message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Purchase Succesfully! By User From Wallet';
					}
					user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $message);

					make_pdf($invoice_id, $user_id);

					$Status = 'Success';
					$message = 'Payment has been done from Wallet.';
				}
			} else {
				$Status = 'Error';
				$message = 'Something went wrong. payment amount mismatched.';
			}

		} else {
			$Status = 'Error';
			$message = 'Something went wrong. Details mismatched with card.';
		}

	} else {
		$Status = 'Error';
		$message = 'Something went wrong.';
	}
}

## Response
$response = array(
	"Status" => $Status,
	"message" => $message
);

echo json_encode($response);
