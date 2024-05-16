<?php


$connection = mysqli_connect("localhost", "root", "tumko34h1se", "myphonesystem");

$sql = "SELECT * FROM btc_gateways WHERE `payment_status`='waiting' and id=51";
$result = mysqli_query($connection, $sql) or die("query failed");
if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {

        // echo $row['invoice_id'] . '<br><br>';
        // make_pdf($row['invoice_id'], $row['user_id']);
        // echo '<pre>';print_r($row);exit;

        $id = $row['id'];
        $pay_address = $row['pay_address'];
        $pay_amount = $row['pay_amount'];
        $pay_currency = $row['pay_currency'];
        $order_id = $row['order_id'];
        $invoice_id = $row['invoice_id'];
        $gateway_invo_id = $row['gateway_invo_id'];
        $user_id = $row['user_id'];
        $client_id = $row['clientId'];
        $email = $row['email'];
        $username = $row['username'];
        $item_type = $row['item_type'];
        $item_number = $row['item_number'];
        $accountcode = $row['accountcode'];
        $payment_status = $row['payment_status'];
        $payment_id = $row['payment_id'];
        $itemNumber = $item_number;
        $responseData = array();
        if ($payment_status == 'waiting') {
            $apiKey = 'BE5A9TP-666MRMH-NKSJZH0-E8XTN4B';
            $paymentStatusUrl = 'https://api.nowpayments.io/v1/payment/' . $payment_id;
            $curl = curl_init();
            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $paymentStatusUrl,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'x-api-key: ' . $apiKey,
                    ),
                )
            );
            $response = curl_exec($curl);
            //print_r($response);
            if ($response === false) {
                wh_log(curl_error($curl));
            } else {
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                if ($httpCode >= 200 && $httpCode < 500) {
                    // Decode the JSON response
                    $responseData = json_decode($response, true);
                    // Output the payment status
                    // echo 'Payment Status: ' . $responseData['payment_status'];
                    // Add more handling of payment status as needed
                } /* else {
                   echo 'HTTP Error: ' . $httpCode;
                   // Print detailed cURL request/response information
                   echo "\nResponse:\n$response\n";
               } */
            }
            curl_close($curl);
// echo '<pre>';print_r($responseData);exit;
            if ((isset($responseData['payment_status']) && $responseData['payment_status'] == "finished") || (isset($responseData['payment_status']) && $responseData['payment_status'] == "partially_paid")) {

                if ($gateway_invo_id > 0) {

                    $update_sql = "update `invoices` set payment_status='Paid' where id='" . $invoice_id . "'";
                    $update_res = mysqli_query($connection, $update_sql);

                    /* Wallet Credit Start */
                    if ($item_type == "Wallet Credit") {
                        $paid_amount = $item_type;
                        $user_select = "SELECT id,firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
                        $user_details = mysqli_query($connection, $user_select);
                        if (mysqli_num_rows($user_details) > 0) {
                            $card_row = mysqli_fetch_assoc($user_details);
                            $old_balance = $card_row['credit'];
                            $balance_total = $paid_amount * 0.05;
                            $balance = $old_balance + $paid_amount + $balance_total;
                            // echo"<pre>";print_r($balance_total);die;
                            $_SESSION['login_user_credits'] = $balance;
                            $created_at = date('Y-m-d h:i:s');
                            $insert_cerdit = "insert into recharge_history (`user_id`,`current_bal`,`add_bal`,`total_bal`,`currency`,`recharged_by`,`created_at`) values ('" . $user_id . "','" . $old_balance . "','" . $paid_amount . "','" . $balance . "','BTC','Self','" . $created_at . "')";
                            $resultinsert = mysqli_query($connection, $insert_cerdit);
                            $user_select = "update `cc_card` set credit='" . $balance . "' where id='" . $user_id . "'";
                            $user_details = mysqli_query($connection, $user_select);
                        }
                    }
                    /* Wallet Credit End */


                    $itemNumber_array = explode('-', $itemNumber);
                    foreach ($itemNumber_array as $itemNo) {
                        $startingdate = date('Y-m-d H:i:s');
                        $expirationdate = date('Y-m-d H:i:s', strtotime('+30 days'));
                        if (strtoupper($item_type) == 'DID') {
                            $plansql = "SELECT `plan_id` FROM users_login WHERE `id`= '" . $user_id . "'";
                            $planquery = mysqli_query($connection, $plansql);
                            if (mysqli_num_rows($planquery) > 0) {
                                $plantype = mysqli_fetch_assoc($planquery);
                                $plan_id = $plantype['plan_id'];
                            }
                            $update_did_sql = "update `cc_did` set iduser='" . $user_id . "',  billingtype='" . $plan_id . "', activated ='1', startingdate ='" . $startingdate . "', expirationdate = '" . $expirationdate . "', status='Active', clientId='" . $client_id . "' where did = '" . $itemNo . "'";
                            $update_did_res = mysqli_query($connection, $update_did_sql);
                            $select_did = "SELECT id,iduser,didtype,clientId FROM `cc_did` where did='" . $itemNo . "'";
                            $details_did = mysqli_query($connection, $select_did);
                            $did_row = mysqli_fetch_assoc($details_did);
                            $insert_destination = "INSERT INTO `cc_did_destination` ( `destination`, `destination_name`, `priority`, `id_cc_card`, `id_cc_did`, `voip_call`, `validated`) VALUES ( '0000', 'none', '1', '" . $user_id . "', '" . $did_row['id'] . "','1','1')";
                            $result_destination = mysqli_query($connection, $insert_destination);
                            /******** Create DID purchase history */
                            $insert_did_history = "INSERT INTO `did_buying_history` ( `user_id`, `clientId`, `did_id`, `purchase_date`, `expiry_date`) VALUES ( '" . $user_id . "', '" . $client_id . "', '" . $did_row['id'] . "', '" . $startingdate . "','" . $expirationdate . "')";
                            $result_did_history = mysqli_query($connection, $insert_did_history);
                        }
                        if ($item_type == 'Extension') {
                            $update_ext_sql = "update `cc_sip_buddies` set id_cc_card='" . $user_id . "',accountcode='" . $accountcode . "', user_id='" . $user_id . "', startingdate ='" . $startingdate . "',  expirationdate = '" . $expirationdate . "',  ext_status='1', host='dynamic', clientId='" . $client_id . "' where name = '" . $itemNo . "'";
                            $update_ext_res = mysqli_query($connection, $update_ext_sql);
                        }
                    }

                    if ($item_type == "Wallet Credit") {
                        $activity_type = 'Amount Credit in Wallet';
                        $message = 'Invoice ID: ' . $invoice_id . ' ' . 'Amount Credit Succesfully! By Crypto';
                    } else {
                        $activity_type = $item_type . ' ' . 'Purchase';
                        $message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Purchase Succesfully!!! By User From Crypto';
                    }
                   // user_activity_log($user_id, $client_id, $activity_type, $message);
                    $Status = 'Success';
                    $message = 'Payment has been done.';
                }
                //make_pdf($invoice_id, $user_id);
                $gatway_up = "UPDATE `gateways_payments` SET `payment_status` = 'Paid' WHERE `id` = '" . $gateway_invo_id . "'";
                
                //$result_gateway = mysqli_query($connection, $gatway_up) or die("Query failed : gatway_up");
                $btc_upSql = "UPDATE `btc_gateways` SET `payment_status`='" . $responseData['payment_status'] . "' WHERE `payment_id` = '" . $payment_id . "'";
                
               // $result_btc = mysqli_query($connection, $btc_upSql) or die("query failed : btc_upSql");

                $payment_log = 'BTC Payment Successful Notification--- Payment ID --> ' . $payment_id . ', Item Type -> ' . $item_type . ', Item --> ' . $item_number . ', Payment Status --> ' . $responseData['payment_status'];
                echo $payment_log;
               // wh_log($payment_log);
            } else {
                echo 'not entered';exit;
                $payment_log = 'BTC Payment Notification--- Payment ID --> ' . $payment_id . ', Item Type -> ' . $item_type . ', Item --> ' . $item_number . ', Payment Status --> ' . $responseData['payment_status'];
               // wh_log($payment_log);
            }
        }
    }
}

// $startingdate = date('Y-m-d H:i:s');
// $expirationdate = date('Y-m-d H:i:s', strtotime('+30 days'));
/* $startingdate = '2024-05-07 13:35:16';
// $expirationdate = '2024-06-07 13:35:16';
$expirationdate = date($startingdate, strtotime('+30 days'));
echo $startingdate . '<br><br>';
echo $expirationdate . '<br><br>';
$today = strtotime($startingdate);
$expire = strtotime($expirationdate);
$timeleft = $expire - $today;
$daysleft = round((($timeleft / 24) / 60) / 60);
echo $daysleft;
exit; */
/* include 'connection.php';
$query = "select template_contents from cc_conf_templates where template_id='WEBRTC'";
$response = mysqli_query($connection, $query) or die("query failed : query");
$rows = mysqli_fetch_assoc($response);
$template_contents = $rows['template_contents'];

$sql = "select name,secret,accountcode from cc_sip_buddies where play_ivr = '1' and ext_status=1 and host='dynamic'";
$result = mysqli_query($connection, $sql) or die("query failed : sql");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $nname = $row['name'];
        $ssecret = $row['secret'];
        $selectedaccountcode = $row['accountcode'];

        $sip_additional_path = "/var/www/html/callanalog/admin/webrtc_template.conf";

        $sip_register_string = "\n[$nname]\nusername=$nname\nsecret=$ssecret\naccountcode=$selectedaccountcode\n$template_contents\n";
        // echo $sip_register_string;exit;
        file_put_contents($sip_additional_path, $sip_register_string, FILE_APPEND | LOCK_EX);
    }
}

exit; */

// $response = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
// echo $response;


/* $sql = "select name,secret,accountcode from cc_sip_buddies where play_ivr = '0' and ext_status=1 and host='dynamic'";
$result = mysqli_query($connection, $sql) or die("query failed : sql");
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        $nname = $row['name'];
        $ssecret = $row['secret'];
        $selectedaccountcode = $row['accountcode'];

        $sip_additional_path = "/var/www/html/callanalog/admin/sip_additional.conf";

        $sip_register_string = "\n[$nname]\nusername=$nname\nsecret=$ssecret\naccountcode=$selectedaccountcode\n" . SIP_TEMPLATE_CONTENT . "\n";
        // echo $sip_register_string;exit;
        file_put_contents($sip_additional_path, $sip_register_string, FILE_APPEND | LOCK_EX);
    }
}

exit; */

// $response = shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
// echo $response;

?>