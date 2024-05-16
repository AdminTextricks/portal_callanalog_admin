<?php
include 'connection.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$fromDate = $_GET['fromDate'];
$fromTime = $_GET['fromTime'];
$fromdates = $fromDate . ' ' . $fromTime;
$toDate = $_GET['toDate'];
$toTime = $_GET['toTime'];
$todates = $toDate . ' ' . $toTime;

if (strlen($_GET['invoice_id']) > 0) {
    $invoice_id = 'AND gpay.gatway_invoice_id = "' . $_GET['invoice_id'] . '"';
} else {
    $invoice_id = '';
}

$item_type = $_GET['item_type'];
if (strlen($_GET['item_type']) > 0) {
    $item_type = "AND gpay.item_type='" . $item_type . "'";
} else {
    $item_type = '';
}

$payment_status = $_GET['payment_status'];
if (strlen($_GET['payment_status']) > 0) {
    $payment_status = "AND invo.payment_status='" . $payment_status . "'";
} else {
    $payment_status = '';
}

$payment_type = $_GET['payment_type'];
if (strlen($_GET['payment_type']) > 0) {
    $payment_type = "AND gpay.payment_type='" . $payment_type . "'";
} else {
    $payment_type = '';
}

if (isset($_GET['user_id']) && strlen($_GET['user_id']) > 0) {
    $user_id = "AND gpay.user_id='" . $_GET['user_id'] . "'";
} else {
    $user_id = '';
}

if($_SESSION['userroleforpage'] == 1){
    $query_tra = "SELECT gpay.user_id, gpay.invoice_db_id,gpay.gatway_invoice_id, gpay.gatway_order_id, gpay.payment_type, gpay.item_type, gpay.name, gpay.email, gpay.paid_amount, invo.payment_status, gpay.created  
    FROM `gateways_payments` as gpay 
    LEFT JOIN invoices as invo ON gpay.invoice_db_id = invo.id 
    WHERE gpay.created between '" . $fromdates . "' and '" . $todates . "' " . $invoice_id . " " . $item_type . " " . $payment_status . " " . $payment_type . " ".$user_id." order by gpay.id DESC";

}else{
    $query_tra = "SELECT gpay.user_id, gpay.invoice_db_id,gpay.gatway_invoice_id, gpay.gatway_order_id, gpay.payment_type, gpay.item_type, gpay.name, gpay.email, gpay.paid_amount, invo.payment_status, gpay.created  
              FROM `gateways_payments` as gpay 
              LEFT JOIN invoices as invo ON gpay.invoice_db_id = invo.id 
              WHERE gpay.user_id='".$_SESSION['login_user_id']."' AND gpay.created between '" . $fromdates . "' and '" . $todates . "' " . $invoice_id . " " . $item_type . " " . $payment_status . " " . $payment_type . " order by gpay.id DESC";
}

$result_export = mysqli_query($connection, $query_tra);

if (mysqli_num_rows($result_export) > 0) {
    $delimiting = ",";
    $filename = 'transaction_report' . '_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    $output = fopen('php://output', 'w');

    $fields = array('Serial No', 'Username', 'Usermail', 'Invoice Id', 'Payment Type', 'Item Type', 'Created Date', 'Paid Amount', 'Status');

    fputcsv($output, $fields, $delimiting);

    $i = 1;
    while ($row_tra = mysqli_fetch_assoc($result_export)) {
        $lineData = array(
            $i,
            $row_tra['name'],
            $row_tra['email'],
            $row_tra['gatway_invoice_id'],
            $row_tra['payment_type'],
            $row_tra['item_type'],
            $row_tra['created'],
            $row_tra['paid_amount'],
            $row_tra['payment_status']
        );
        fputcsv($output, $lineData, $delimiting);

        $i++;
    }

    fclose($output);
    exit;
} else {
    echo "No data found for export";
    exit;
}
?>