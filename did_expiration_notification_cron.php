<?php
include 'connection.php';
include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function send_mail($DID_number, $startingdate, $expirationdate, $remaining_days, $email)
{
    $subject = "DID Expire Notification";

    $message = "<html>
                <head>
                <title>DID Expiration Date</title>
                </head>
                <body>
                <p>Your DID will be expired in " . $remaining_days . " day</p>
                <table>
                <tr>
                <th>DID Number</th><td>" . $DID_number . "</td>
                </tr>
                <tr>
                <th>DID Starting Date</th><td>" . $startingdate . "</td>
                </tr>
                <tr>
                <th>DID Expiration Date</th><td>" . $expirationdate . "</td>
                </tr>
                </table>
                </body>
                </html>";

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
       wh_log("Email has been sent successfully!");
        // $success_mail = "UPDATE `invoices` SET `email_status`='1', `email_msg`='Invoice Sent Successfully' where id='".$invoice_id."'";
        // mysqli_query($connection, $success_mail) or die("query failed");
    } catch (Exception $e) {
        // $error_mail = "UPDATE `invoices` SET `email_msg`='Invoice Not Sent' where id='".$invoice_id."'";
        // mysqli_query($connection, $error_mail) or die("query failed");
        wh_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

//echo date('Y-m-d H:i:s').'<br>';
//$did_query = "SELECT id_cc_didgroup, activated, iduser, did, creationdate, startingdate, expirationdate, billingtype, status, clientId FROM `cc_did` WHERE status='Active' and  activated = '1' and expirationdate between now() and adddate(now(), INTERVAL 2 DAY) ORDER BY `cc_did`.`expirationdate` DESC";
//-------------- above query calculate on time --------------


$log_start_time = date('Y-m-d H:i:sa');
wh_log('************** Start Log For Day : ' . $log_start_time . '**********');


$did_query = "SELECT id_cc_didgroup, activated, iduser, did, creationdate, startingdate, expirationdate, billingtype, status, clientId FROM `cc_did` WHERE status='Active' and  activated = '1' and DATE(expirationdate) = DATE(NOW() + INTERVAL 1 DAY) ORDER BY `cc_did`.`expirationdate` DESC";
//-------------- remaining 2 day in expiration query calculate on date --------------
$resultDid = mysqli_query($connection, $did_query);
$didRecords = mysqli_fetch_all($resultDid, MYSQLI_ASSOC);
// echo '<pre>';print_r($didRecords);exit;

foreach ($didRecords as $key => $did_details) {
    $user_email = "select `email` from `users_login` where `id` = '" . $did_details['iduser'] . "'";
    $result = mysqli_query($connection, $user_email) or die("query failed : user_email");
    if (mysqli_num_rows($result) > 0) {
        $rows = mysqli_fetch_assoc($result);
        $email = $rows['email'];
    }
    $DID_number = $did_details['did'];
    $startingdate = $did_details['startingdate'];
    $expirationdate = $did_details['expirationdate'];
    $remaining_days = 1;
    $res = send_mail($DID_number, $startingdate, $expirationdate, $remaining_days, $email);
    $did_log = 'DID Expiration Notification:- DID Number:' . $DID_number . ' Startingdate:' . $startingdate . ' expirationdate:' . $expirationdate . ' Remaining Days:' . $remaining_days . ' Mail Status:' . $res;
    wh_log($did_log);
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
    $log_file_data = $log_filename . '/did_expire_log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, PHP_EOL . $log_msg . '\n', FILE_APPEND);
}
mysqli_close($connection);
mysqli_close($con);