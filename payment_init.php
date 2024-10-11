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
        $customer = \Stripe\Customer::create(
            array(
                'name' => $name,
                'email' => $email
            )
        );
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

    $payment_intent = !empty($jsonObj->payment_intent) ? $jsonObj->payment_intent : '';
    $customer_id = !empty($jsonObj->customer_id) ? $jsonObj->customer_id : '';

    // Retrieve customer info 
    try {
        $customer = \Stripe\Customer::retrieve($customer_id);
    } catch (Exception $e) {
        $api_error = $e->getMessage();
    }

    // Check whether the charge was successful 
    if (!empty($payment_intent) && $payment_intent->status == 'succeeded') {
        // Transaction details  
        $transaction_id = $payment_intent->id;
        $paid_amount = $payment_intent->amount;
        $paid_amount = ($paid_amount / 100);
        $paid_currency = $payment_intent->currency;
        $payment_status = $payment_intent->status;

        $user_id = $jsonObj->user_id;
        $gatway_invoice_id = $jsonObj->gatway_invoice_id;
        $invoice_id = $jsonObj->invoice_id;
        $payment_type = $jsonObj->payment_type;
        $item_name = $jsonObj->item_name;
        $item_number = $jsonObj->item_number;
        $item_type = $jsonObj->item_type;
        $stripeAmount = $jsonObj->stripeAmount;
        $stripeCurrency = $jsonObj->stripeCurrency;
        $orderID = $gatway_invoice_id . '-UID-' . $user_id;
        $renew_item = $jsonObj->renew_item;
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
            $user_details = mysqli_query($connection, $user_select);
            if (mysqli_num_rows($user_details) > 0) {
                $card_row = mysqli_fetch_assoc($user_details);

                $insert_invoice = "insert into	gateways_payments ( user_id, invoice_db_id, gatway_invoice_id, gatway_order_id, name, email, item_name, item_number,item_price,item_price_currency, paid_amount,paid_amount_currency,transaction_id,payment_status,created,modified,payment_type,item_type) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $gatway_invoice_id . "', '" . $orderID . "','" . $customer_name . "','" . $customer_email . "','" . $item_name . "', '" . $item_number . "','" . $stripeAmount . "', '" . $stripeCurrency . "','" . $paid_amount . "','" . $paid_currency . "','" . $transaction_id . "','" . $payment_status . "','" . $date . "','" . $date . "','Pay','" . $item_type . "')";

                $query_res = mysqli_query($con, $insert_invoice);

                $invo_id = mysqli_insert_id($con);
                $payment_id = $invo_id;
                if ($invo_id > 0) {

                    $update_sql = "update `invoices` set payment_status='Paid' where id='" . $invoice_id . "'";
                    $update_res = mysqli_query($connection, $update_sql);
                    $itemNumber_array = explode('-', $item_number);
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
                                $update_did_sql = "update `cc_did` set activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active' where did = '" . $itemNo . "'";
                                $update_did_res = mysqli_query($connection, $update_did_sql);
                            } else {
                                $update_did_sql = "update `cc_did` set iduser='" . $user_id . "',  billingtype='" . $_SESSION['login_user_plan_id'] . "', activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active', clientId='" . $_SESSION['userroleforclientid'] . "' where did = '" . $itemNo . "'";

                                // echo $update_did_sql; exit;
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
                                        $webrtc_conf_path = "/var/www/html/callanalog/admin/sip_additional.conf";
                                        $register_string = "\n[$itemNo]\nusername=$itemNo\nsecret=$ssecret\naccountcode=$carduser\n" . SIP_TEMPLATE_CONTENT . "\n";
                                        file_put_contents($webrtc_conf_path, $register_string, FILE_APPEND | LOCK_EX);

                                    }
                                }
                                $today = strtotime(date('Y-m-d H:i:s'));
                                $expire = strtotime($row['expirationdate']);

                                $timeleft = $expire - $today;
                                $daysleft = round((($timeleft / 24) / 60) / 60);

                                if ($daysleft <= 3 && $daysleft >= 0) {
                                    $expirationdate = date('Y-m-d H:i:s', strtotime('+29 days', strtotime($row['expirationdate'])));
                                }
                                $update_ext_sql = "update `cc_sip_buddies` set startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', ext_status='1', host='dynamic' where name = '" . $itemNo . "'";
                            } else {
                                $update_ext_sql = "update `cc_sip_buddies` set id_cc_card='" . $user_id . "',accountcode='" . $card_row['username'] . "', user_id='" . $user_id . "', clientId='" . $_SESSION['userroleforclientid'] . "', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', ext_status='1', host='dynamic' where name = '" . $itemNo . "'";
                            }
                            $update_ext_res = mysqli_query($connection, $update_ext_sql);

                        }
                    }
                    if ($renew_item == 1) {
                        if ($item_type == 'Extension' && SERVER_FLAG == 1) {
                            $result = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
                            $result1 = shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
                            sip_reload();
                        }
                        $activity_type = $item_type . ' ' . 'Renew';
                        $message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Renewed Succesfully! By User From Card';
                    } else {
                        $activity_type = $item_type . ' ' . 'Purchase';
                        $message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Purchase Succesfully! By User From Card';
                    }
                    user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $message);
                    make_pdf($invoice_id, $user_id);

                    $Status = 'Success';
                    $message = 'Payment has been done.';
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

?>