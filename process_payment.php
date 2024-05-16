<?php
include_once 'connection.php';
include_once 'functions.php';

// $apiKey = 'AKRKV3J-4NS43NN-H0ZF427-P81JZDK';
// echo '<pre>';print_r($_POST);exit;
$currency = $_POST['stripeCurrency'];
$email = $_POST['email'];
$invoice_id = $_POST['invoice_id'];
$gatway_invoice_id = $_POST['gatway_invoice_id'];
$user_name = $_POST['name'];
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_type = $_POST['payment_type'];
$item_type = $_POST['item_type'];
$user_id = $_POST['user_id'];
$amount_cents = $_POST['stripeAmount'];
$btn_type = $_POST['btn_type'];

if ($btn_type == 'Pay with BTC') {
    $pay_currency = 'BTC';
    $apiKey = 'BE5A9TP-666MRMH-NKSJZH0-E8XTN4B';
} elseif ($btn_type == 'Pay with USD') {
    $pay_currency = 'USD';
} else {
    $pay_currency = 'ETH';
    $apiKey = "T5VPSVB-7ZBMZA5-J0ZEYVM-94PT7BD";
}


$user_row = '';
$user_select = "SELECT id,firstname,username,phone,credit,address,state,country,zipcode FROM `cc_card` where id='" . $user_id . "'";
$user_details = mysqli_query($connection, $user_select);
if (mysqli_num_rows($user_details) > 0) {
    $card_row = mysqli_fetch_assoc($user_details);
    $accountcode = $card_row['username'];

    $query_inv = "select * from invoices where id='" . $invoice_id . "' and payment_status='Unpaid'";
    $result_inv = mysqli_query($connection, $query_inv);
    if (mysqli_num_rows($result_inv) > 0) {
        $invoice_details = mysqli_fetch_assoc($result_inv);

        //item information
        $itemName = "Stripe Myphonesystems";
        $itemNumber = $item_number;
        $itemPrice = $amount_cents * 100;
        $gatway_order_id = $gatway_invoice_id . '-UID-' . $user_id;

        if ($status == 'succeeded') {
            $status = 'Paid';
        } else {
            $status = 'UnPaid';
        }
        $item_price = $itemPrice / 100;
        $paid_amount = $amount / 100;

        $insert_invoice = "insert into gateways_payments (user_id, invoice_db_id,gatway_invoice_id, gatway_order_id, payment_type, item_type, name, email, item_name, item_number, paid_amount, paid_amount_currency, payment_status,created) VALUES ('" . $user_id . "','" . $invoice_id . "','" . $gatway_invoice_id . "', '" . $gatway_order_id . "','" . $payment_type . "','" . $item_type . "','" . $user_name . "','" . $email . "','" . $item_name . "', '" . $item_number . "','" . $paid_amount . "','" . $pay_currency . "','waiting','" . date('Y-m-d H:i:s') . "')";

        $query_res = mysqli_query($con, $insert_invoice);
        $gateway_invo_id = mysqli_insert_id($con);

    }
}


if ($amount_cents > 0 && $invoice_details['invoice_amount'] == $amount_cents) {

    if (empty ($amount_cents) || !is_numeric($amount_cents)) {
        echo "<script>alert('Invalid amount')</script>";
    } elseif (empty ($currency)) {
        echo "<script>alert('Currency is required')</script>";
    } elseif (empty ($gatway_invoice_id)) {
        echo "<script>alert('Order ID is required')</script>";
    } else {
        // Sanitize user input
        $amount_cents = htmlspecialchars($amount_cents);
        $currency = htmlspecialchars($currency);
        $gatway_invoice_id = htmlspecialchars($gatway_invoice_id);
        $email = htmlspecialchars($email);


        $data = array(
            'price_amount' => $amount_cents,
            'price_currency' => $currency,
            'pay_currency' => $pay_currency,
            'order_id' => $gatway_invoice_id,
            'order_description' => 'Apple',
            'ipn_callback_url' => 'https://callanalog.com',
        );
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.nowpayments.io/v1/payment',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'x-api-key: ' . $apiKey,
                    'Content-Type: application/json',
                ),
                CURLOPT_VERBOSE => true,
                CURLOPT_STDERR => $verbose = fopen('php://temp', 'w+'),
            )
        );

        $response = curl_exec($curl);

        if ($response === false) {
            echo 'Error: ' . curl_error($curl);
        } else {
            // echo '<script>console.log("' . $response . '")</script>';
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if ($httpCode >= 200 && $httpCode < 300) {
                // Decode the JSON response
                $responseData = json_decode($response, true);

                // Check if payment_id is present in the response
                if (isset ($responseData['payment_id'])) {

                    $insert_btc = "INSERT INTO `btc_gateways`(`pay_address`,`pay_amount`,`pay_currency`,`order_id`,`invoice_id`,`gateway_invo_id`,`user_id`,`clientId`,`email`,`username`,`item_type`,`item_number`,`accountcode`,`payment_status`,`payment_id`,`created_at`) VALUES ('" . $responseData['pay_address'] . "','" . $responseData['pay_amount'] . "','" . $responseData['pay_currency'] . "','" . $responseData['order_id'] . "','" . $invoice_id . "','" . $gateway_invo_id . "','" . $user_id . "','" . $_SESSION['userroleforclientid'] . "','" . $email . "','" . $user_name . "','" . $item_type . "','" . $item_number . "','" . $accountcode . "','waiting','" . $responseData['payment_id'] . "','" . date('Y-m-d H:i:s') . "')";
                    $result_btc = mysqli_query($connection, $insert_btc) or die("query failed : insert_btc");

                    // Generate payment link
                    $paymentLink = 'payment_confirmation.php?pay_address=' . $responseData['pay_address'] . '&payment_id=' . $responseData['payment_id'] . '&price_amount=' . $responseData['price_amount'] . '&pay_currency=' . $responseData['pay_currency'] . '&order_id=' . $responseData['order_id'] . '&pay_amount=' . $responseData['pay_amount'] . '&amount_received=' . $responseData['amount_received'] . '&invoice_id=' . $invoice_id . '&gateway_invo_id=' . $gateway_invo_id;

                    $userDetails = '&user_id=' . $user_id . '&email=' . $email . '&username=' . $user_name . '&item_name=' . $item_name . '&item_number=' . $item_number . '&payment_type=' . $payment_type . '&item_type=' . $item_type . '&accountcode=' . $accountcode;


                    // Print the payment link
                    // echo 'Payment Link: <a href="' . $paymentLink . '" target="_blank">Pay Now</a>';
                    header("Location: " . $paymentLink . $userDetails);
                } else {
                    echo '<script>alert("Error: Payment ID not found in the response")</script>';
                }
            } else {
                echo 'HTTP Error: ' . $httpCode;
                // Print detailed cURL request/response information
                rewind($verbose);
                $verboseLog = stream_get_contents($verbose);
                echo "\nVerbose cURL:\n$verboseLog\n";
            }
        }

        curl_close($curl);
    }

} else {
    $Status = 'Error';
    $message = "Transaction has been failed";
}
/* } else {
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
} */
?>