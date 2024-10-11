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
$paid_amount = $_POST['paid_amount'];
$order_id = $_POST['order_id'];
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
    }
}
curl_close($curl);

if ($responseData['payment_status'] == "finished" || $responseData['payment_status'] == "partially_paid") {
    if (isset($responseData['actually_paid']) && $responseData['actually_paid'] !== $responseData['pay_amount']) {
        $paid_amount = $responseData['actually_paid'];
    }
    if ($gateway_invo_id > 0) {
        $update_sql = "update `invoices` set payment_status='Paid' where id='" . $invoice_id . "'";
        $update_res = mysqli_query($connection, $update_sql);

        $user_select = "SELECT id,firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
        $user_details = mysqli_query($con, $user_select);
        if (mysqli_num_rows($user_details) > 0) {
            $card_row = mysqli_fetch_assoc($user_details);
            $old_balance = $card_row['credit'];
            $balance_total = $paid_amount * 0.05;
            $balance = $old_balance + $paid_amount + $balance_total;
            $_SESSION['login_user_credits'] = $balance;
            // echo"<pre>";print_r($order_id);die;
            $created_at = date('Y-m-d h:i:s');
            $insert_cerdit = "insert into recharge_history (`user_id`,`current_bal`,`add_bal`,`total_bal`,`currency`,`recharged_by`,`created_at`) values ('" . $user_id . "','" . $old_balance . "','" . $paid_amount . "','" . $balance . "','USDT','Self','" . $created_at . "')";
            $resultinsert = mysqli_query($connection, $insert_cerdit);

            $user_select = "update `cc_card` set credit='" . $balance . "' where id='" . $user_id . "'";
            $user_details = mysqli_query($con, $user_select);
        }

        $activity_type = 'Amount Credit in Wallet';
        $message = 'Amount: ' . $balance . ' Amount Credit Succesfully!';
        user_activity_log($user_id, $_SESSION['userroleforclientid'], $activity_type, $message);
    }
    make_pdf($invoice_id, $user_id);
    $gatway_up = "UPDATE `gateways_payments` SET `payment_status` = 'Paid' WHERE `id` = '" . $gateway_invo_id . "'";
    mysqli_query($connection, $gatway_up) or die("Query failed : gatway_up");

    $Status = 'Success';
    $message = 'Payment has been done and credit hass been added in your Wallet.';
} elseif ($responseData['payment_status'] == "failed") {
    $btc_up = "UPDATE `btc_gateways` SET `payment_status`='" . $responseData['payment_status'] . "' WHERE `payment_id`='" . $payment_id . "'";
    mysqli_query($connection, $btc_up) or die("query failed : btc_up");
}

echo $responseData['payment_status'];

