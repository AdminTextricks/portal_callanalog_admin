<?php
include 'connection.php';
include 'functions.php';


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
//echo '<pre>'; print_r($_POST); echo '</pre>';exit;
	if($_POST['payment_type'] == 'Wallet'){
		$user_id    		= $_POST['user_id'];
		$invoice_id 		= $_POST['invoice_id'];
		$gatway_invoice_id 	= $_POST['gatway_invoice_id'];
		$item_type  		= $_POST['item_type'];
		$user_name  		= $_POST['user_name'];
		$email      		= $_POST['email'];
		$paid_amount 		= $_POST['paid_amount'];
		$currency   		= $_POST['currency'];
		$item_name  		= $_POST['item_name'];
		$item_number  		= $_POST['item_number'];
		$payment_type 		= $_POST['payment_type'];

		//echo "<pre>"; print_r($_POST); die();
	
		
//echo '<pre>'; print_r($item_number); exit;
		$gatway_order_id = $gatway_invoice_id.'-UID-'.$user_id;

		$user_row = '';
		$user_select = "SELECT firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='".$user_id."'";
		$user_details = mysqli_query($connection , $user_select);
		if(mysqli_num_rows($user_details) > 0 ){
			$card_row = mysqli_fetch_assoc($user_details);

			if($paid_amount > 0){
				$insert_invoice = "insert into gateways_payments (user_id, invoice_db_id,gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('".$user_id."','".$invoice_id."','".$gatway_invoice_id."', '".$gatway_order_id."','".$payment_type."','".$item_type."','".$user_name."','".$email."','".$item_name."', '".$item_number."','".$paid_amount."','".$currency."','success','".date('Y-m-d H:i:s')."')";
				$query_res = mysqli_query($con, $insert_invoice);
				$invo_id = mysqli_insert_id($con);
				
				if($invo_id > 0){
					$update_sql = "update `invoices` set payment_status='Paid' where id='".$invoice_id."'";
					$update_res = mysqli_query($connection , $update_sql);

					$balance = $card_row['credit'] - $paid_amount;
					$_SESSION['login_user_credits'] = $balance;
					$user_select = "update `cc_card` set credit='".$balance."' where id='".$user_id."'";
					$user_details = mysqli_query($connection , $user_select);

					$itemNumber_array = explode('-',$item_number);
					// echo '<pre>'; print_r($itemNumber_array); echo '</pre>';exit;
					foreach($itemNumber_array as $itemNo){					
						$startingdate = date('Y-m-d H:i:s');
						$expirationdate = date('Y-m-d H:i:s', strtotime('+30 days'));
						if(strtoupper($item_type) == 'DID'){

							$update_did_sql = "update `cc_did` set iduser='".$user_id."', billingtype='".$_SESSION['login_user_plan_id']."', activated ='1', startingdate ='".$startingdate."', expirationdate = '".$expirationdate."', status='Active', clientId='".$_SESSION['userroleforclientid']."' where did = '".$itemNo."'";
							$update_did_res = mysqli_query($connection , $update_did_sql);
							
							// $activity_type = 'DID Purchase';
							// $message = 'DID No: '.$item_number.' '.'DID Purchase Succesfully! By User From Wallet';
							// user_activity_log($user_id,$_SESSION['userroleforclientid'], $activity_type, $message);

							$select_did= "SELECT id,iduser,didtype,clientId FROM `cc_did` where did='".$itemNo."'";							
							$details_did = mysqli_query($connection , $select_did);		
							$did_row = mysqli_fetch_assoc($details_did);

							$insert_destination = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`) VALUES ( '0000', 'none', '1', '".$user_id."', '".$did_row['id']."','1','1')";
							$result_destination = mysqli_query($connection , $insert_destination);

							/******** Create DID purchase history */
							$insert_did_history = "INSERT INTO `did_buying_history` ( `user_id`, `clientId`, `did_id`, `purchase_date`, `expiry_date`) VALUES ( '".$user_id."', '".$_SESSION['userroleforclientid']."', '".$did_row['id']."', '".$startingdate."','".$expirationdate."')";
							$result_did_history = mysqli_query($connection , $insert_did_history);
						}
						if($item_type == 'Extension'){	
							$update_ext_sql = "update `cc_sip_buddies` set id_cc_card='".$user_id."',accountcode='".$card_row['username']."', user_id='".$user_id."', clientId='".$_SESSION['userroleforclientid']."', startingdate ='".$startingdate."', expirationdate = '".$expirationdate."', ext_status='1', host='dynamic' where name = '".$itemNo."'";
							$update_ext_res = mysqli_query($connection , $update_ext_sql);

							$message = 'Extension Purchase Succesfully!';
							// $activity_type = 'Extension Purchase ';
							// $msg = 'Extension No: '.$item_number.' '.'Extension Purchase Succesfully! By User From Wallet';
							// user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $msg);
						}
						//exit;
					}
					$activity_type = $item_type.' '.'Purchase';
					$message = $item_type.' '.'No: '.$item_number.' '.$item_type.' '.'Purchase Succesfully! By User From Wallet';
					user_activity_log($user_id,$_SESSION['userroleforclientid'], $activity_type, $message);
					
					make_pdf($invoice_id,$user_id);
					
					$Status = 'Success';
					$message = 'Payment has been done from Wallet.';
				}
			}else{
				$Status = 'Error';
				$message = 'Something went wrong. payment amount mismatched.';
			}

		}else{
			$Status = 'Error';
			$message = 'Something went wrong. Details mismatched with card.';
		}

	}else{
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
