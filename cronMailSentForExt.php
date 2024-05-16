<?php
include 'connection.php';

include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$interval_arr = array('1');

$log_start_time = date('Y-m-d H:i:sa');
wh_log('************** Start Log For Day : ' . $log_start_time . '**********');

//$ext_query = "SELECT id_cc_card,cc_sip_buddies.name, accountcode,host,created_at,startingdate,expirationdate, ext_status, cc_sip_buddies.clientId FROM `cc_sip_buddies` LEFT JOIN users_login ON cc_sip_buddies.id_cc_card = users_login.id WHERE ext_status='1' and DATE(expirationdate) <= DATE(NOW() + INTERVAL 3 DAY) ORDER BY `cc_sip_buddies`.`expirationdate` DESC";

foreach ($interval_arr as $key => $interval) {

    $ext_query = "SELECT id_cc_card,cc_sip_buddies.name,users_login.email,accountcode,host,created_at,startingdate,expirationdate, ext_status, cc_sip_buddies.clientId FROM `cc_sip_buddies` LEFT JOIN users_login ON cc_sip_buddies.id_cc_card = users_login.id WHERE users_login.plan_id='0' and ext_status='1' and DATE(expirationdate) = DATE(NOW() + INTERVAL " . $interval . " DAY) ORDER BY `cc_sip_buddies`.`expirationdate` DESC";
// echo $ext_query;exit;
    $resultEXT = mysqli_query($connection, $ext_query);
    if(mysqli_num_rows( $resultEXT) > 0){
        while ($extRecords = mysqli_fetch_assoc($resultEXT)) {
            $email[] = $extRecords['email'];
            $accountcode[] = $extRecords['accountcode']; 
        }

        $email = array_unique($email);
        $accountcode = array_unique($accountcode);
        // echo '<pre>';print_r($email);exit;
        // echo '<pre>';print_r($accountcode);exit;
        
        foreach($accountcode as $key => $value){
          
            $sql = "SELECT `name`,`startingdate`,`expirationdate` FROM `cc_sip_buddies` WHERE `accountcode` = '$value' and ext_status='1' and DATE(expirationdate) = DATE(NOW() + INTERVAL " . $interval . " DAY)";
          
            $result_sql = mysqli_query($connection, $sql) or die("query failed : sql");
            $ext = array();
            $startingdate = array();
            $expirationdate = array();
            if(mysqli_num_rows($result_sql) > 0){
                while ($row = mysqli_fetch_assoc($result_sql)) {
                    $ext[] = $row['name'];
                    $startingdate[] = $row['startingdate'];
                    $expirationdate[] = $row['expirationdate'];
                }
                $remaining_days = 1;
              $res = send_mail($ext, $startingdate, $expirationdate, $remaining_days, $email[$key]);   
            }
// echo '<pre>';print_r($row);exit;
        }
        $update_log = 'User Id:' . $ext_details['id_cc_card'] . ' EXTENSION:' . $ext_details['name'] . ' creationdate:' . $ext_details['created_at'] . ' startingdate:' . $ext_details['startingdate'] . ' expirationdate:' . $ext_details['expirationdate'] . ' Query Status:' . $updateDid;
      wh_log($update_log); 
    }else{
        wh_log('no record found');
    }       
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
    $log_file_data = $log_filename . '/log_mail_ext' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, PHP_EOL . $log_msg . '\n', FILE_APPEND);
}

function send_mail($ext, $startingdate, $expirationdate, $remaining_days, $email)
{
    $subject = "Extension Expire";
// echo $email;
    $message = "<html><head><title>Extension Expiration Notification</title><style>table, th, tr, td{border:2px solid black;border-collapse:collapse;}th, td{padding: 10px;}</style></head><body><p>Your Extensions will be expired in".$remaining_days."day</p><table><thead><th>S.No.</th><th>Extensions</th><th>Starting Date</th><th>Expiration Date</th></thead><tbody>";
    $i = 0;
    $j = 1;
    while ($i < count($ext)) {
        $message .="<tr><td>{$j}</td><td>{$ext[$i]}</td><td>{$startingdate[$i]}</td><td>{$expirationdate[$i]}</td></tr>";
        $i++;
        $j++;
    }
    $message .="<tr></tr></tbody></table></body></html>";

// echo $message;
  $mail = new PHPMailer(true);
    try {
        // $mail->SMTPDebug = 2;                                      
        $mail->isSMTP();
        $mail->Host = HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = PORT;
        $mail->setFrom(EMAIL, CALLANALOG);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        // echo "Email has been sent successfully!";
        // $success_mail = "UPDATE `invoices` SET `email_status`='1', `email_msg`='Invoice Sent Successfully' where id='".$invoice_id."'";
        // mysqli_query($connection, $success_mail) or die("query failed");
    } catch (Exception $e) {
        // $error_mail = "UPDATE `invoices` SET `email_msg`='Invoice Not Sent' where id='".$invoice_id."'";
        // mysqli_query($connection, $error_mail) or die("query failed");
        wh_log($mail->ErrorInfo);
    } 
}
mysqli_close($connection);
mysqli_close($con);