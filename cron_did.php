<?php
include 'connection.php';

$log_start_time = date('Y-m-d H:i:sa');
wh_log('************** Start Log For Day : ' . $log_start_time . '**********');

$did_query = "SELECT id_cc_didgroup, activated, iduser, did, creationdate, startingdate, expirationdate, billingtype, status, clientId FROM `cc_did` WHERE status='Active' and  activated = '1' and DATE(expirationdate) <= DATE(NOW() - INTERVAL 1 DAY) ORDER BY `cc_did`.`expirationdate` DESC";


$resultDid = mysqli_query($connection, $did_query);

if (mysqli_num_rows($resultDid) > 0) {
    $didRecords = mysqli_fetch_all($resultDid, MYSQLI_ASSOC);
    foreach ($didRecords as $key => $did_details) {

        $did_update = "UPDATE `cc_did` set activated='0', status='Suspended' WHERE status='Active' and  activated = '1' and iduser='" . $did_details['iduser'] . "' and did='" . $did_details['did'] . "'";

        $updateDid = mysqli_query($connection, $did_update);

        $update_log = 'User Id:' . $did_details['iduser'] . ' DID:' . $did_details['did'] . ' creationdate:' . $did_details['creationdate'] . ' startingdate:' . $did_details['startingdate'] . ' expirationdate:' . $did_details['expirationdate'] . ' Status:' . $updateDid;

        wh_log($update_log);

    }

} else {
    $update_log = "No Record Found";
    wh_log($update_log);
}

$log_end_time = date('Y-m-d H:i:sa');
wh_log('************** END Log For Day : ' . $log_end_time . '**********');
function wh_log($log_msg)
{
    $log_filename = '/var/www/html/callanalog/admin/logs';
    if (!file_exists($log_filename)) {
        // create directory/folder uploads.
        mkdir($log_filename, 0777, true);
    }
    $log_file_data = $log_filename . '/log_did' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, PHP_EOL . $log_msg . '\n', FILE_APPEND);
}
