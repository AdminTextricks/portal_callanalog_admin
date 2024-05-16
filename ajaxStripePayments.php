<?php
include 'connection.php';
include 'functions.php';

include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// require_once __DIR__ . '/vendor_pdf/autoload.php';
// try {
// 	$mpdf = new \Mpdf\Mpdf([
// 	  'tempDir' => __DIR__ . '/../tmp', // uses the current directory's parent "tmp" subfolder
// 	  'setAutoTopMargin' => 'stretch',
// 	  'setAutoBottomMargin' => 'stretch'
// 	]);
// } catch (\Mpdf\MpdfException $e) {
// 	  print "Creating an mPDF object failed with" . $e->getMessage();
// }
// Include mpdf library fil
$Status = 'Error';
if ($_POST['payment_type'] == 'Stripe') {
	if (!empty($_POST['stripeToken'])) {
		// echo '<pre>'; print_r($_POST); echo '</pre>';exit;
		//get token, card and user info from the form
		$token = $_POST['stripeToken'];
		$amount_cents = $_POST['stripeAmount'];
		$currency_cents = $_POST['stripeCurrency'];
		$invoice_id = $_POST['invoice_id'];
		$gatway_invoice_id = $_POST['gatway_invoice_id'];
		//$gatway_order_id= $_POST['gatway_order_id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$card_num = $_POST['card_num'];
		$card_cvc = $_POST['cvc'];
		$card_exp_month = $_POST['exp_month'];
		$card_exp_year = $_POST['exp_year'];
		$item_name = $_POST['item_name'];
		$item_number = $_POST['item_number'];
		$payment_type = $_POST['payment_type'];
		$item_type = $_POST['item_type'];
		$user_id = $_POST['user_id'];

		// echo '<pre>'; print_r($_POST);exit;

		$user_row = '';
		$user_select = "SELECT id,firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
		$user_details = mysqli_query($connection, $user_select);
		if (mysqli_num_rows($user_details) > 0) {
			$card_row = mysqli_fetch_assoc($user_details);

			$query_inv = "select * from invoices where id='" . $invoice_id . "' and payment_status='Unpaid'";
			$result_inv = mysqli_query($connection, $query_inv);
			if (mysqli_num_rows($result_inv) > 0) {
				$invoice_details = mysqli_fetch_assoc($result_inv);
				if ($amount_cents > 0 && $invoice_details['invoice_amount'] == $amount_cents) {
					

					//include Stripe PHP library
					require_once "third_party/stripe/init.php";
					//set api key
					$stripe = array(
						"secret_key" => SECRET_KEY,
						"publishable_key" => PUBLISHABLE_KEY
					);

					\Stripe\Stripe::setApiKey($stripe['secret_key']);

					//add customer to stripe
					$customer = \Stripe\Customer::create(
						array(
							'email' => $email,
							'source' => $token,
						)
					);

					
					//item information
					$itemName = "Stripe Myphonesystems";
					$itemNumber = $item_number;
					$itemPrice = $amount_cents * 100;
					$currency = $currency_cents;
					$orderID = $gatway_invoice_id . '-UID-' . $user_id;

					//charge a credit or a debit card
					$charge = \Stripe\Charge::create(
						array(
							'customer' => $customer->id,
							'amount' => $itemPrice,
							'currency' => $currency,
							'description' => $itemNumber,
							'metadata' => array(
								'item_id' => $itemNumber,
								'orderID' => $orderID
							)
						)
					);
					// echo'<pre>';print_r($charge); exit;
					//retrieve charge details
					$chargeJson = $charge->jsonSerialize();

					// print_r($chargeJson);
					//  echo '<pre>';print_r($chargeJson);

					//check whether the charge is successful
					if ($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1 && $chargeJson['status'] == 'succeeded') {

						//order details 
						$amount = $chargeJson['amount'];
						$balance_transaction = $chargeJson['balance_transaction'];
						$currency = $chargeJson['currency'];
						$status = $chargeJson['status'];
						$date = date("Y-m-d H:i:s");
						//$userdetailId= $user_id;
						if ($status == 'succeeded') {
							$status_in = 'Paid';
							// header("Location: payment_successfull.php");
						} else {
							$status_in = 'UnPaid';
							// header("Location: payment_error.php");
						}
						$item_price = $itemPrice / 100;
						$paid_amount = $amount / 100;

						$insert_invoice = "insert into	gateways_payments (
								user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, name, email, card_num, card_cvc,card_exp_month,card_exp_year,item_name, item_number,item_price,item_price_currency, paid_amount,paid_amount_currency,transaction_id,payment_status,created,modified,payment_type,item_type) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $gatway_invoice_id . "', '" . $orderID . "','" . $name . "','" . $email . "','" . $card_num . "','" . $card_cvc . "','" . $card_exp_month . "','" . $card_exp_year . "','" . $itemName . "', '" . $itemNumber . "','" . $item_price . "', '" . $currency . "','" . $paid_amount . "','" . $currency . "','" . $balance_transaction . "','" . $status_in . "','" . $date . "','" . $date . "','Pay','" . $item_type . "')";

						$query_res = mysqli_query($con, $insert_invoice);

						$invo_id = mysqli_insert_id($con);
						if ($invo_id > 0) {
							/* $balance = $card_row['credit'] - $paid_amount;
													$_SESSION['login_user_credits'] = $balance;
													$user_select = "update `cc_card` set credit='".$balance."' where id='".$user_id."'";
													$user_details = mysqli_query($connection , $user_select);
													 */
							$update_sql = "update `invoices` set payment_status='Paid' where id='" . $invoice_id . "'";
							$update_res = mysqli_query($connection, $update_sql);
							$itemNumber_array = explode('-', $itemNumber);
							foreach ($itemNumber_array as $itemNo) {
								$startingdate = date('Y-m-d H:i:s');
								$expirationdate = date('Y-m-d H:i:s', strtotime('+1 month'));
								if (strtoupper($item_type) == 'DID') {

									$update_did_sql = "update `cc_did` set iduser='" . $user_id . "',  billingtype='" . $_SESSION['login_user_plan_id'] . "', activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active', clientId='" . $_SESSION['userroleforclientid'] . "' where did = '" . $itemNo . "'";

									// echo $update_did_sql; exit;
									$update_did_res = mysqli_query($connection, $update_did_sql);

									// $activity_type = 'DID Purchase';
									// $message = 'DID No: '.$item_number.' '.'DID Purchase Succesfully! Through Pay';
									// user_activity_log($user_id,$_SESSION['userroleforclientid'], $activity_type, $message);

									$select_did = "SELECT id,iduser,didtype,clientId FROM `cc_did` where did='" . $itemNo . "'";
									$details_did = mysqli_query($connection, $select_did);
									$did_row = mysqli_fetch_assoc($details_did);

									$insert_destination = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`) VALUES ( '0000', 'none', '1', '" . $user_id . "', '" . $did_row['id'] . "','1','1')";
									$result_destination = mysqli_query($connection, $insert_destination);

									/******** Create DID purchase history */
									$insert_did_history = "INSERT INTO `did_buying_history` ( `user_id`, `clientId`, `did_id`, `purchase_date`, `expiry_date`) VALUES ( '" . $user_id . "', '" . $_SESSION['userroleforclientid'] . "', '" . $did_row['id'] . "', '" . $startingdate . "','" . $expirationdate . "')";
									$result_did_history = mysqli_query($connection, $insert_did_history);

								}
								if ($item_type == 'Extension') {
									$update_ext_sql = "update `cc_sip_buddies` set id_cc_card='" . $user_id . "',accountcode='" . $card_row['username'] . "', user_id='" . $user_id . "', startingdate ='" . $startingdate . "',  expirationdate = '" . $expirationdate . "',  ext_status='1', host='dynamic', clientId='" . $_SESSION['userroleforclientid'] . "' where name = '" . $itemNo . "'";
									$update_ext_res = mysqli_query($connection, $update_ext_sql);


									// $activity_type = 'Extension Purchase';
									// $message = 'Extension No: '.$item_number.' '.'Extension Purchase Succesfully! Through Pay';
									// user_activity_log($user_id,$_SESSION['userroleforclientid'], $activity_type, $message);
								}
							}
							$activity_type = $item_type . ' ' . 'Purchase';
							$message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Purchase Succesfully! By User From Pay';
							user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $message);

							make_pdf($invoice_id, $user_id);
							

							$Status = 'Success';
							$message = 'Payment has been done.';
						}
					} else {
						$Status = 'Error';
						$message = "Transaction has been failed";
					}
				} else {
					$Status = 'Error';
					$message = 'Something went wrong. payment amount mismatched.';
				}
			} else {
				$Status = 'Error';
				$message = 'Wrong Invoice details.';
			}
		} else {
			$Status = 'Error';
			$message = 'User Not Valid.';
		}

	} else {
		$Status = 'Error';
		$message = 'Invalid Stripe Token .';
	}

} else {
	$Status = 'Error';
	$message = 'Something went wrong.';
}




## Response
$response = array(
	"Status" => $Status,
	"message" => $message
);

if ($Status != 'Success' || $Status == '') {
	header("Location: payment_error.php");
	//echo "<script>window.location.href='payment_error.php'</script>";
} else {
	header("Location: payment_successfull.php");
	//echo "<script>window.location.href = 'payment_successfull.php?res='".json_encode($response).";</script>";
}
//echo json_encode($response);
// <td rowspan=4 >
// <img alt="" src="http://139.84.172.41/myphonesystems/myphone/admin/resources/images/logo.png" width="100px" height="80px"> 
// </td>