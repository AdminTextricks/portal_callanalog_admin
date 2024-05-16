<?php

//require_once 'config.php'; 
include 'connection.php';
include 'functions.php';

// Include the configuration file 

// Include the database connection file 

// Include the Stripe PHP library 
require_once 'stripe-php/init.php';

// Set API key 
\Stripe\Stripe::setApiKey(STRIPE_API_KEY);

// Retrieve JSON from POST body 
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);

// echo"<pre>";print_r($jsonObj);   
// echo"<pre> >>>>>>>>>>>";print_r($jsonObj->request_type);die;
if ($jsonObj->request_type == 'create_payment_intent') {


    // Define item price and convert to cents 
    $currency = $jsonObj->stripeCurrency;
    $itemName = $jsonObj->item_name;
    $itemPrice = $jsonObj->stripeAmount;
    $itemPriceCents = round($itemPrice * 100);


    // Set content type to JSON 
    header('Content-Type: application/json');

    try {
        // Create PaymentIntent with amount and currency 
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $itemPriceCents,
            'currency' => $currency,
            'description' => $itemName,
            'payment_method_types' => [
                'card'
            ]
        ]);

        $output = [
            'id' => $paymentIntent->id,
            'clientSecret' => $paymentIntent->client_secret
        ];

        echo json_encode($output);
    } catch (Error $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($jsonObj->request_type == 'create_customer') {
     
    $payment_intent_id = !empty($jsonObj->payment_intent_id) ? $jsonObj->payment_intent_id : '';
    $name = !empty($jsonObj->name) ? $jsonObj->name : '';
    $email = !empty($jsonObj->email) ? $jsonObj->email : '';

    // Add customer to stripe 
    try {
        $customer = \Stripe\Customer::create(array(
            'name' => $name,
            'email' => $email
        ));
    } catch (Exception $e) {
        $api_error = $e->getMessage();
    }

    if (empty($api_error) && $customer) {
        try {
            // Update PaymentIntent with the customer ID 
            $paymentIntent = \Stripe\PaymentIntent::update($payment_intent_id, [
                'customer' => $customer->id
            ]);
        } catch (Exception $e) {
            // log or do what you want 
        }

        $output = [
            'id' => $payment_intent_id,
            'customer_id' => $customer->id
        ];
        echo json_encode($output);
    } else {
        http_response_code(500);
        echo json_encode(['error' => $api_error]);
    }
} elseif ($jsonObj->request_type == 'payment_insert') {
    // echo"<pre>";print_r($jsonObj); 

    $payment_intent = !empty($jsonObj->payment_intent) ? $jsonObj->payment_intent : '';
    $customer_id = !empty($jsonObj->customer_id) ? $jsonObj->customer_id : '';

    // Retrieve customer info 
    try {
        $customer = \Stripe\Customer::retrieve($customer_id);
    } catch (Exception $e) {
        $api_error = $e->getMessage();
    }
    // echo"<pre>";print_r($jsonObj); 

    // Check whether the charge was successful 
    if (!empty($payment_intent) && $payment_intent->status == 'succeeded') {

        // echo"<pre>";print_r($jsonObj);die;
        // Transaction details  
        $transaction_id = $payment_intent->id;
        $paid_amount = $payment_intent->amount;
        $paid_amount = ($paid_amount / 100);
        $paid_currency = $payment_intent->currency;
        $payment_status = $payment_intent->status; 

        $user_id        = $jsonObj->user_id;
        $gatway_invoice_id = $jsonObj->gatway_invoice_id;
        $invoice_id     = $jsonObj->invoice_id;
        $payment_type   = $jsonObj->payment_type;
        $item_name      = "Stripe Wallet Pay";
        $item_number    = $jsonObj->item_number;
        $item_type      = $jsonObj->item_type;
        $stripeAmount   = $jsonObj->stripeAmount;
        $stripeCurrency = $jsonObj->stripeCurrency;
        $orderID = $gatway_invoice_id . '-UID-' . $user_id;
        $date = date("Y-m-d H:i:s");


        $customer_name = $customer_email = '';
        if (!empty($customer)) {
            $customer_name = !empty($customer->name) ? $customer->name : '';
            $customer_email = !empty($customer->email) ? $customer->email : '';
        } else {
            $customer_name = !empty($jsonObj->customer_name) ? $jsonObj->customer_name : '';
            $customer_email = !empty($jsonObj->customer_email) ? $jsonObj->customer_email : '';
        }

        $trans_id = "SELECT id,transaction_id FROM `gateways_payments` where transaction_id='" . $transaction_id . "'";
        $trans_details = mysqli_query($connection, $trans_id);
        $trans_row = mysqli_fetch_assoc($trans_details);

        $payment_id = 0;
        if (!empty($row_id)) {
            $payment_id = $trans_row['id'];
        } else {

            $user_select = "SELECT id,firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
            $user_details = mysqli_query($con, $user_select);
            if (mysqli_num_rows($user_details) > 0) {
                $card_row = mysqli_fetch_assoc($user_details);
                $old_balance =$card_row['credit'];
                $insert_invoice = "insert into	gateways_payments ( user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, name, email, item_name, item_number,item_price,item_price_currency, paid_amount,paid_amount_currency,transaction_id,payment_status,created,modified,payment_type,item_type) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $gatway_invoice_id . "', '" . $orderID . "','" . $customer_name . "','" . $customer_email . "','" . $item_name . "', '" . $item_number . "','" . $stripeAmount . "', '" . $stripeCurrency . "','" . $paid_amount . "','" . $paid_currency . "','" . $transaction_id . "','" . $payment_status . "','" . $date . "','" . $date . "','Pay','" . $item_type . "')";

                $query_res = mysqli_query($con, $insert_invoice);

                // $invo_id = mysqli_insert_id($con);
                // $payment_id = $invo_id;
                if ($query_res) { 

                    // echo"<pre>";print_r(">>>NOT INSERTED");die;
                    $update_sql = "update `invoices` set payment_status='Paid' where id='".$invoice_id."'";
                    
                    $update_res = mysqli_query($con , $update_sql);

                    $balance = $old_balance + $paid_amount;
                    $_SESSION['login_user_credits'] = $balance;
                    $user_select = "update `cc_card` set credit='" . $balance . "' where id='" . $user_id . "'";
                    $user_details = mysqli_query($con, $user_select);


                    $total_bal = $old_balance + $paid_amount;
                    $created_at = date('Y-m-d h:i:s');

                    $ins_recharge = "INSERT INTO `recharge_history`(`user_id`,`current_bal`,`add_bal`,`total_bal`,`currency`,`recharged_by`,`created_at`) VALUES ('" . $user_id . "','" . $old_balance . "','" . $paid_amount . "','" . $total_bal . "','USD','Self','" . $created_at . "')";

                    $res_recharge = mysqli_query($connection, $ins_recharge);


                    $activity_type = 'Amount Credit in Wallet';
                    $msg = 'Invoice ID: ' . $invoice_id . ' ' . 'Amount Credit Succesfully!';
                    user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $msg);


                    make_pdf($invoice_id, $user_id);


                    $Status = 'Success';
                    $message = 'Payment has been done and credit hass been added in your Wallet.';
                }
            }
        }
        /*   // Check if any transaction data is exists already with the same TXN ID 
                $sqlQ = "SELECT id FROM transactions WHERE txn_id = ?"; 
                $stmt = $db->prepare($sqlQ);  
                $stmt->bind_param("s", $transaction_id); 
                $stmt->execute(); 
                $stmt->bind_result($row_id); 
                $stmt->fetch(); 
                
                $payment_id = 0; 
                if(!empty($row_id)){ 
                    $payment_id = $row_id; 
                }else{ 
                    // Insert transaction data into the database 
                    $sqlQ = "INSERT INTO transactions (customer_name,customer_email,item_name,item_price,item_price_currency,paid_amount,paid_amount_currency,txn_id,payment_status,created,modified) VALUES (?,?,?,?,?,?,?,?,?,NOW(),NOW())"; 
                    $stmt = $db->prepare($sqlQ); 
                    $stmt->bind_param("sssdsdsss", $customer_name, $customer_email, $itemName, $itemPrice, $currency, $paid_amount, $paid_currency, $transaction_id, $payment_status); 
                    $insert = $stmt->execute(); 
                    
                    if($insert){ 
                        $payment_id = $stmt->insert_id; 
                    }
                } 

             */

        $output = [
            'payment_txn_id' => base64_encode($transaction_id)
        ];
        echo json_encode($output);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Transaction has been failed!']);
    }
}
