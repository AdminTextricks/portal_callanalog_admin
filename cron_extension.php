<?php
$connection = mysqli_connect("localhost", "root", "tumko34h1se", "myphonesystem");

$log_start_time = date('Y-m-d H:i:sa');
wh_log('************** Start Log For Day : ' . $log_start_time . '**********');

//$ext_query = "SELECT  id_cc_card,name, accountcode,host,created_at,startingdate,expirationdate, ext_status, clientId FROM `cc_sip_buddies` LEFT JOIN users_login ON cc_sip_buddies.id_cc_card = users_login.id WHERE ext_status='1' and DATE(expirationdate) <= DATE(NOW() - INTERVAL 1 DAY) ORDER BY `cc_sip_buddies`.`expirationdate` DESC";

$ext_query = "SELECT id_cc_card,cc_sip_buddies.name,cc_sip_buddies.play_ivr, accountcode,host,created_at,startingdate,expirationdate, ext_status, cc_sip_buddies.clientId, users_login.plan_id FROM `cc_sip_buddies`  LEFT JOIN users_login ON cc_sip_buddies.id_cc_card = users_login.id WHERE users_login.plan_id='0' and ext_status='1' and DATE(expirationdate) <= DATE(NOW() - INTERVAL 1 DAY) ORDER BY `cc_sip_buddies`.`expirationdate` DESC";

$resultEXT = mysqli_query($connection, $ext_query);

// echo  '<pre>'; print_r($extRecords); echo '</pre>';exit;
if (mysqli_num_rows($resultEXT) > 0) {
    $extRecords = mysqli_fetch_all($resultEXT, MYSQLI_ASSOC);
    foreach ($extRecords as $key => $ext_details) {
        $extname = $ext_details['name'];
        $ext_update = "UPDATE `cc_sip_buddies` set host='static',context='block',  ext_status='0' WHERE ext_status='1' and  host = 'dynamic' and id_cc_card='" . $ext_details['id_cc_card'] . "' and name='" . $ext_details['name'] . "'";
        $updateEXT = mysqli_query($connection, $ext_update);

        $update_log = 'User Id:' . $ext_details['id_cc_card'] . ' EXTENSION:' . $ext_details['name'] . ' creationdate:' . $ext_details['created_at'] . ' startingdate:' . $ext_details['startingdate'] . ' expirationdate:' . $ext_details['expirationdate'] . ' Query Status:' . $updateDid;
        wh_log($update_log);

        if ($ext_details['play_ivr'] == 1) {
            $sip_additional_path = "/var/www/html/callanalog/admin/webrtc_template.conf";
        } else {
            $sip_additional_path = "/var/www/html/callanalog/admin/sip_additional.conf";
        }

        $lines = file($sip_additional_path);
        $output = '';
        $found = false;
        foreach ($lines as $line) {
            if (strpos($line, "[$extname]") !== false) {
                $found = true;
                continue;
            }
            if ($found && strpos($line, "[") === 0) {
                $found = false;
            }
            if (!$found) {
                $output .= $line;
            }
        }
        file_put_contents($sip_additional_path, $output, LOCK_EX);
    }
    shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
    shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
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
    $log_file_data = $log_filename . '/log_ext' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, PHP_EOL . $log_msg . '\n', FILE_APPEND);
}
mysqli_close($connection);

