<?php
require_once ('connection.php');
include 'vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
// $mail->SMTPDebug = 2;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($message1, $to)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = PORT;
        $mail->setFrom(EMAIL, CALLANALOG);
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Document Verification Summary';
        $mail->Body = $message1;
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();

        echo "Mail has been sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$current_url = "https://portal.callanalog.com/callanalog/admin/";

$doc_id = explode(",", $_GET['id']);

if (isset($_GET['id'])) {
    if (count($doc_id) == 1) {
        $sql = "UPDATE `upload_documents` SET `status`='" . $_GET['Status'] . "' WHERE id='" . $_GET['id'] . "'";
    } else {
        $sql = "UPDATE `upload_documents` SET `status`= '" . $_GET['status'] . "' WHERE id IN (" . $_GET['id'] . ")";
    }
    // echo $sql;exit;

    $query = mysqli_query($con, $sql);

    if ($query) {
        $message = "<h3>Document Data updated successfully!</h3>";
    } else {
        $message = "<h3>Failed to update!</h3>";
    }
    for ($i = 0; $i < count($doc_id); $i++) {
       $docSql = "SELECT `user_id` FROM `upload_documents` WHERE `id` = '" . $doc_id[$i] . "'";
        $docRes = mysqli_query($con, $docSql) or die("query failed: docSql");
        if (mysqli_num_rows($docRes) > 0) {
            $row = mysqli_fetch_assoc($docRes);
            $user_id = $row['user_id'];
        }
        $query = "SELECT `status` FROM `upload_documents` WHERE `user_id` = '" . $user_id . "'";
        $result = mysqli_query($con, $query) or die("query failed : query");
        if (mysqli_num_rows($result) > 0) {
            while ($rows = mysqli_fetch_assoc($result)) {
                $status[] = $rows['status'];
            }
        }
        // Fetch user email
        $users_id = "SELECT `email` FROM `users_login` WHERE `id`='" . $user_id . "'";
        $users_result = mysqli_query($con, $users_id) or die("user get query failed");

        if (mysqli_num_rows($users_result) > 0) {
            $fetch = mysqli_fetch_assoc($users_result);
            $to = $fetch['email'];
        }

        if (!in_array("Pending", $status)) {
            // Get the count of approved and rejected documents
            $approvedCount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `upload_documents` WHERE `user_id` = '".$user_id."' AND `status` = 'Approved'"));
            $rejectedCount = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `upload_documents` WHERE `user_id` = '".$user_id."' AND `status` = 'Rejected'"));

            // Send email
            if ($approvedCount == 3) {
                $message1 = "Dear User, <br><br>Your Documents has been approved please login to " . $current_url . "<br><br>Thank You!!";
            } else {
                $message1 = "Dear User, <br><br>Your Documents summary:<br>Approved: " . $approvedCount . "<br>Rejected: " . $rejectedCount . "<br> Please check your documents and Upload again <br> Thank You!!";
            }
            
        }
        if (!in_array("Pending", $status) and !in_array("Rejected", $status)) {
            // Update user status if necessary
            $statusUpdateQuery = "UPDATE `users_login` SET `status` = 'Active' WHERE `id` = '" . $user_id . "'";
            $up_res = mysqli_query($con, $statusUpdateQuery) or die("query failed : update");
            send_mail($message1, $to);
        }
    }
    echo true;
    $_SESSION['msg'] = $message;
    header('Location: upload_documents_list.php');
}
?>