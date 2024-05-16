<?php require_once ('connection.php');
require_once ('functions.php');


if (isset($_POST['jsondataUpdated'])) {
    $jsondataUpdated = json_decode($_POST['jsondataUpdated'], true);
    //echo '<pre>';print_r($jsondataUpdated);//exit;


    foreach ($jsondataUpdated as $key => $extension) {

        $accountcode_select = "select accountcode, secret,play_ivr from cc_sip_buddies where name='" . $extension['name'] . "' LIMIT 1";
        $accountcode_select_query = mysqli_query($con, $accountcode_select);
        $rowaccountcode = mysqli_fetch_array($accountcode_select_query);

        $selectedaccountcode = $rowaccountcode['accountcode'];
        $ssecret = $rowaccountcode['secret'];
        $play_ivr = $rowaccountcode['play_ivr'];

        $update_ext = "update cc_sip_buddies set sip_type='" . $extension['sip_type'] . "',play_ivr='" . $extension['play_ivr'] . "', outbound_cid='" . $extension['outbound_cid'] . "', recording='" . $extension['recording'] . "' where name='" . $extension['name'] . "'";

        $result_updatext = mysqli_query($con, $update_ext);

        if ($extension['VoiceMail'] == 'Yes' && $extension['name'] != '') {

            $delete_voicemail = "delete from cc_voicemail_users where mailbox='" . $extension['name'] . "'";
            $delete_voicemail_query = mysqli_query($con, $delete_voicemail);

            $insert_voicemail = "insert into cc_voicemail_users (clientId,customer_id,mailbox,fullname,email) VALUES ('" . $extension['clientId'] . "','" . $extension['user_id'] . "','" . $extension['name'] . "','" . $extension['agent_name'] . "','" . $extension['email'] . "')";

            // echo $insert_voicemail;exit;

            $insert_voicemail_query = mysqli_query($con, $insert_voicemail);
        }
        if ($extension['VoiceMail'] == 'No') {

            $delete_voicemail = "delete from cc_voicemail_users where mailbox='" . $extension['name'] . "'";
            $delete_voicemail_query = mysqli_query($con, $delete_voicemail);
        }
        if ($extension['play_ivr'] != $play_ivr) {
            $nname = $extension['name'];
            if ($extension['play_ivr'] == '1') {
                $ext_query_web_template = "select * from cc_conf_templates where template_id='WEBRTC' LIMIT 1";
                $web_res = mysqli_query($con, $ext_query_web_template);
                $web_temp_res = mysqli_fetch_array($web_res);
                $template_id = $web_temp_res['template_id'];
                $template_name = $web_temp_res['template_name'];
                $template_contents = $web_temp_res['template_contents'];

                // Add new user section
                $register_string = "\n[$nname]\nusername=$nname\nsecret=$ssecret\naccountcode=$selectedaccountcode\n$template_contents\n";
                $webrtc_conf_path = "/var/www/html/callanalog/admin/webrtc_template.conf";
                file_put_contents($webrtc_conf_path, $register_string, FILE_APPEND | LOCK_EX);
                //echo "Registration successful. The SIP user $nname has been added to the webrtc_template.conf file.";

                $sip_additional_path = "/var/www/html/callanalog/admin/sip_additional.conf";
                $lines = file($sip_additional_path);
                $output = '';
                $found = false;
                foreach ($lines as $line) {
                    if (strpos($line, "[$nname]") !== false) {
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
            } else {
                // Remove user section
                $webrtc_conf_path = "/var/www/html/callanalog/admin/webrtc_template.conf";
                $lines = file($webrtc_conf_path);
                $output = '';
                $found = false;
                foreach ($lines as $line) {
                    if (strpos($line, "[$nname]") !== false) {
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
                file_put_contents($webrtc_conf_path, $output, LOCK_EX);
                //echo "Registration removed. The SIP user $nname has been removed from the webrtc_template.conf file.";

                /* Entry Another file code Start here */
                $sip_additional_path = "/var/www/html/callanalog/admin/sip_additional.conf";

                $sip_register_string = "\n[$nname]\nusername=$nname\nsecret=$ssecret\naccountcode=$selectedaccountcode\n" . SIP_TEMPLATE_CONTENT . "\n";
                file_put_contents($sip_additional_path, $sip_register_string, FILE_APPEND | LOCK_EX);
                /* Entry Another file code END here */
            }
        }
    }
    $res = array();
    $result = shell_exec('sudo /var/www/html/callanalog/admin/transfer.sh');
    $result1 = shell_exec('sudo /var/www/html/callanalog/admin/transfer_2.sh');
    if ($result) {
        //echo "File Transfer Successfully..";
        $res = array('status' => 'Ture', 'message' => 'File Transfer Successfully.');
    } else {
        //echo "File Transfer Failed..";
        $res = array('status' => 'Error', 'message' => 'File Transfer Failed.');
    }
    sip_reload();

    echo json_encode($res);
}

?>