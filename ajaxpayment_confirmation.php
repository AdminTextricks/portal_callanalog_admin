<?php
include_once 'functions.php';
include_once 'connection.php';
$payment_id = $_POST['payment_id'];
$invoice_id = $_POST['invoice_id'];
$user_id = $_POST['user_id'];
$gateway_invo_id = $_POST['gateway_invo_id'];
$email = $_POST['email'];
$username = $_POST['username'];
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_type = $_POST['payment_type'];
$item_type = $_POST['item_type'];
$accountcode = $_POST['accountcode'];
$renew_item = $_POST['renew_item'];
$itemNumber = $item_number;
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
if ($response === false) {
    echo 'Error: ' . curl_error($curl);
} else {
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode >= 200 && $httpCode < 300) {
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
if ($responseData['payment_status'] == "finished" || $responseData['payment_status'] == "partially_paid") {
    if ($responseData['actually_paid'] == $responseData['pay_amount']) {
        if ($gateway_invo_id > 0) {
            $update_sql = "update `invoices` set payment_status='Paid' where id='" . $invoice_id . "'";
            $update_res = mysqli_query($connection, $update_sql);
            $itemNumber_array = explode('-', $itemNumber);
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
                            $carduser = $row['accountcode'];
                            $ssecret = $row['secret'];
                            $ext_expirationdate = $row['expirationdate'];
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
                        $update_ext_sql = "update `cc_sip_buddies` set id_cc_card='" . $user_id . "',accountcode='" . $accountcode . "', user_id='" . $user_id . "', startingdate ='" . $startingdate . "',  expirationdate = '" . $expirationdate . "',  ext_status='1', host='dynamic', clientId='" . $_SESSION['userroleforclientid'] . "' where name = '" . $itemNo . "'";
                    }
                    $update_ext_res = mysqli_query($connection, $update_ext_sql);
                }
            }
            if ($renew_item == 1) {
                if ($item_type == "Extension" && SERVER_FLAG == 1) {
                    $result = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
                    $result = shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
                    sip_reload();
                }
                $activity_type = $item_type . ' ' . 'Renew';
                $message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Renewed Succesfully! By User From Crypto';
            } else {
                $activity_type = $item_type . ' ' . 'Purchase';
                $message = $item_type . ' ' . 'No: ' . $item_number . ' ' . $item_type . ' ' . 'Purchase Succesfully! By User From Crypto';
            }
            user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $message);
            $Status = 'Success';
            $message = 'Payment has been done.';
        }
        make_pdf($invoice_id, $user_id);
        $gatway_up = "UPDATE `gateways_payments` SET `payment_status` = 'Paid' WHERE `id` = '" . $gateway_invo_id . "'";
        mysqli_query($connection, $gatway_up) or die("Query failed : gatway_up");
        $btc_upSql = "UPDATE `btc_gateways` SET `payment_status`='" . $responseData['payment_status'] . "',`actually_paid`='" . $responseData['actually_paid'] . "' WHERE `payment_id` = '" . $payment_id . "'";
        mysqli_query($connection, $btc_upSql) or die("query failed : btc_upSql");
    } else {
        $btc_upSql = "UPDATE `btc_gateways` SET `payment_status`='" . $responseData['payment_status'] . "',`actually_paid`='" . $responseData['actually_paid'] . "' WHERE `payment_id` = '" . $payment_id . "'";
        mysqli_query($connection, $btc_upSql) or die("query failed : btc_upSql");
        echo "failed";
        exit;
    }
}

echo $responseData['payment_status'];