<?php require_once ('connection.php');
require_once ('functions.php');

if (isset($_GET['id'])) {
    $select_query = "SELECT `name`,`user_id`,`clientId`,`play_ivr` FROM `cc_sip_buddies` WHERE `id`='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $extname = $row['name'];
        $user_id = $row['user_id'];
        $clientId = $row['clientId'];
        $play_ivr = $row['play_ivr'];
    }
    $sql = "delete from cc_sip_buddies where id='" . $_GET['id'] . "'";
    $result_deletequeue = mysqli_query($connection, $sql);

    if ($result_deletequeue) {
        if ($play_ivr == '1') {
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
        shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
        shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');

        $activity_type = 'Extension Deleted';
        if ($_SESSION['userroleforpage'] == '1') {
            $message = 'Extension No: ' . $extname . 'Extension Deleted Succesfully! By Admin';
        } else {
            $message = 'Extension No: ' . $extname . 'Extension Deleted Succesfully! By User';
        }
        user_activity_log($user_id, $clientId, $activity_type, $message);

        $_SESSION['msg'] = 'Extension Data Delete Successfully !!....';
        header('Location: extension.php');
        // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: extension.php');
    }
} elseif (isset($_POST['id'])) {
    $id = trim($_POST['id']);

    $ext_id = explode(",", $id);
    foreach ($ext_id as $extension_id) {
        $ext_query = "SELECT `name`,`play_ivr` FROM `cc_sip_buddies` WHERE `id`='" . $extension_id . "'";
        $result = mysqli_query($connection, $ext_query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $extname = $row['name'];
            $play_ivr = $row['play_ivr'];
        }
        if ($play_ivr == '1') {
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
    $sql = "DELETE FROM cc_sip_buddies where id in ($id)";
    //$sql = "DELETE FROM crud WHERE id in ($id)";
    if (mysqli_query($connection, $sql)) {
        echo $id;
        $activity_type = 'Multiple Extension Deleted';
        if ($_SESSION['userroleforpage'] == 1) {
            $message = 'Multiple Extension Deleted Succesfully! By Admin';
        } else {
            $message = 'Multiple Extension Deleted Succesfully! By User';
        }
        $clientId = $_SESSION['userroleforclientid'];
        $user_id = $_SESSION['login_user_id'];
        user_activity_log($user_id, $clientId, $activity_type, $message);

    }
}


?>