<?php
include 'connection.php';

$log_start_time = date('Y-m-d H:i:sa');
wh_log('************** Start Log For Day : ' . $log_start_time . '**********');


$did_select = "SELECT `did` FROM `cc_did` WHERE `reserved`='1' AND `iduser`='0'";
$did_select_result = mysqli_query($connection, $did_select) or die("queryfailed");
if (mysqli_num_rows($did_select_result) > 0) {
    while ($rows = mysqli_fetch_assoc($did_select_result)) {
        $did = $rows['did'];
        $did_query = "SELECT * FROM `invoices_items` WHERE `item_number`='" . $did . "' ORDER BY `id` DESC LIMIT 1";
        $resultDid = mysqli_query($connection, $did_query);
        if (mysqli_num_rows($resultDid) > 0) {
            $rows = mysqli_fetch_assoc($resultDid);
            $did_reserve_date = $rows['created_on'];
            $current_time = date('Y-m-d h:i:s');
            $reserve_date = new DateTime($did_reserve_date);
            $current_date = new DateTime($current_time);
            $interval = $current_date->diff($reserve_date);

            $hours_difference = ($interval->days * 24) + $interval->h + ($interval->i / 60) + ($interval->s / 3600);

            if ($hours_difference >= 24) {
                $did_free_update = "UPDATE `cc_did` SET `reserved`='0' WHERE `did`= '" . $did . "'";
                $did_free_result = mysqli_query($connection, $did_free_update);
                $string = "DID/TFN: " . $did . ", Invoice Creation Date: " . $did_reserve_date . ", Free: " . $current_time;
                wh_log($string);
            }

        }
    }

}
$log_end_time = date('Y-m-d H:i:sa');
wh_log('************** END Log For Day : ' . $log_end_time . '**********');
function wh_log($log_msg)
{
    $log_filename = 'logs';
    if (!file_exists($log_filename)) {
        mkdir($log_filename, 0777, true);  // create directory/folder uploads.
    }
    $log_file_data = $log_filename . '/log_did_free' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, PHP_EOL . $log_msg . '\n', FILE_APPEND);
}
mysqli_close($connection);
mysqli_close($con);
?>