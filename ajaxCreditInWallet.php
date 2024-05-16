<?php
include 'connection.php';
include 'functions.php';

	//echo '<pre>'; print_r($_POST); echo '</pre>';exit;
	
	if($_POST['payment_type'] == 'Stripe'){
		
		if(!empty($_POST['stripeToken']))
		{
			
			//get token, card and user info from the form
			$token  		= $_POST['stripeToken'];
            $amount_cents 	= $_POST['stripeAmount'];
            $currency_cents = $_POST['stripeCurrency'];
			$name 			= $_POST['name'];
			$email 			= $_POST['email'];
			$card_num 		= $_POST['card_num'];
			$card_cvc 		= $_POST['cvc'];
			$card_exp_month = $_POST['exp_month'];
			$card_exp_year 	= $_POST['exp_year'];
			$user_id    	= $_POST['user_id'];
			$item_name  	= $_POST['item_name'];
			$item_type  	= $_POST['item_type'];			
			$payment_type 	= 'Pay';	
			
			// echo "<pre>"; print_r($_POST); exit;
			
			
			$user_row = '';
			$user_select = "SELECT `firstname`,`username`,`phone`,`credit` FROM `cc_card` where id='".$user_id."'";
			// echo $user_select; exit;
			$user_details = mysqli_query($connection , $user_select) or die("query failed : user_select");
			if(mysqli_num_rows($user_details) > 0 ){
				$card_row = mysqli_fetch_assoc($user_details);
				// echo "<pre>"; print_r($card_row); exit;
				$old_balance =$card_row['credit'];

				$query_inv = "select max(id) as id from invoices";
				$result_inv = mysqli_query($connection , $query_inv);
				if(mysqli_num_rows($result_inv) > 0 ){
					$rowid = mysqli_fetch_array($result_inv);
					// echo "<pre>"; print_r($rowid); exit;
					$nn =  $rowid['id']+1;
					$invoice_id = "INV/".date('Y')."/000".$nn;            
				}else{
					$invoice_id = 'INV/'.date("Y").'/00001'; 
				}
				$payment_status = 'Unpaid';

				$item_number = 'UID-'.$user_id.'/ Amount-'.$amount_cents;
				// echo $item_number; exit;

				$invoice_sql = "INSERT INTO `invoices`(`user_id`, `invoice_id`, `item_type`,`invoice_currency`, `invoice_amount`, `payment_status`) VALUES('".$user_id."','".$invoice_id."','".$item_type."','".$currency_cents."','".$amount_cents."','".$payment_status."')";

				// echo $invoice_sql; exit;
				$inv_res = mysqli_query($connection , $invoice_sql) or die("query failed : invoice_sql");

				$invo_db_id = mysqli_insert_id($connection);

				$insert_invoice_item = "INSERT INTO `invoices_items`(`invoice_id`, `item_type`, `item_number`, `price`) VALUES ('".$invo_db_id."','".$item_type."','".$item_number."','".$amount_cents."')";
				$query_res_invo = mysqli_query($connection, $insert_invoice_item);

				if($amount_cents > 0){
						//include Stripe PHP library
						require_once "third_party/stripe/init.php";
						//set api key
						$stripe = array(
							"secret_key"      => SECRET_KEY,
							"publishable_key" => PUBLISHABLE_KEY
							);
						
						\Stripe\Stripe::setApiKey($stripe['secret_key']);
						
						//add customer to stripe
						$customer = \Stripe\Customer::create(array(
							'email' => $email,
							'source'  => $token
						));


						//item information
						$itemName = "Stripe Myphonesystems";
						$itemNumber = $item_number;
						$itemPrice = $amount_cents*100;
						$currency = $currency_cents;
						$orderID = $invoice_id.'-UID-'.$user_id;
						
						//charge a credit or a debit card
						$charge = \Stripe\Charge::create(array(
							'customer' => $customer->id,
							'amount'   => $itemPrice,
							'currency' => $currency,
							'description' => $itemNumber,
							'metadata' => array(
								'item_id' => $itemNumber,
								'orderID' =>$orderID
							)
						));
						
						//retrieve charge details
						$chargeJson = $charge->jsonSerialize();

						//echo '<pre>'; print_r($chargeJson); echo '</pre>';

						//check whether the charge is successful
						if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
						{

							//order details 
							$amount = $chargeJson['amount'];
							$balance_transaction = $chargeJson['balance_transaction'];
							$currency = $chargeJson['currency'];
							$status = $chargeJson['status'];
							$date = date("Y-m-d H:i:s");
							// $userdetailId= $user_detail['id'];
							if($status =='succeeded'){
								$status='Paid';   
							}else{
								$status='UnPaid';
							}
							$item_price = $itemPrice/100;
							$paid_amount = $amount/100;

							$insert_invoice = "insert into 	gateways_payments (
								user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, name, email, card_num, card_cvc,card_exp_month,card_exp_year,item_name, item_number,item_price,item_price_currency, paid_amount,paid_amount_currency,transaction_id,payment_status,created,modified,payment_type,item_type) VALUES ('".$user_id."','".$invo_db_id."','".$invoice_id."', '".$orderID."','".$name."','".$email."','".$card_num."','".$card_cvc."','".$card_exp_month."','".$card_exp_year."','".$itemName."', '".$itemNumber."','".$item_price."', '".$currency."','".$paid_amount."','".$currency."','". $balance_transaction."','".$status."','".$date."','".$date."','Pay','".$item_type."')";


							$query_res = mysqli_query($connection, $insert_invoice);
							$invo_id = mysqli_insert_id($connection);
							if($invo_id > 0){

								$balance = $old_balance + $paid_amount;
								$_SESSION['login_user_credits'] = $balance;
								$user_select = "update `cc_card` set credit='".$balance."' where id='".$user_id."'";
								$user_details = mysqli_query($connection , $user_select);
 								
								$update_sql = "update `invoices` set payment_status='Paid' where id='".$invo_db_id."'";
								$update_res = mysqli_query($connection , $update_sql);
																
								$activity_type = 'Amount Credit in Wallet';
								$msg = 'Invoice ID: '.$invoice_id.' '.'Amount Credit Succesfully!';
								user_activity_log($user_id,$_SESSION['userroleforclientid'], $activity_type, $msg);


								make_pdf($invo_db_id,$user_id);
								
																
								$Status = 'Success';
								$message = 'Payment has been done and credit hass been added in your Wallet.';

							}
						}else{
							$Status = 'Error';
							$message = 	 "Transaction has been failed";
						}
					}else{
						$Status = 'Error';
						$message = 'Something went wrong. payment amount mismatched.';					
					}
				
			}else{
				$Status = 'Error';
				$message = 'User Not Valid.';
			}
		}else{
			$Status = 'Error';
			$message = 'Invalid Stripe Token .';
		}	
	}else{
		$Status = 'Error';
		$message = 'Something went wrong.';	
	}


## Response
$response = array(
   "Status" => $Status,
   "message" => $message
);
//echo json_encode($response);exit;
if($Status == 'Error'){
	header("Location: payment_error.php");
	//echo "<script>window.location.href = 'payment_error.php?res='".json_encode($response).";</script>";
}else{
	header("Location: payment_successfull.php");
	//echo "<script>window.location.href = 'payment_successfull.php?res='".json_encode($response).";</script>";
}

?>