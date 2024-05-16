<?php
include 'connection.php';

if(isset($_SESSION['login_user_id'])){
if ($_SESSION['userroleforpage'] == 2 || $_SESSION['userroleforpage'] == 3) {
    $sql_credit = "SELECT credit FROM `cc_card` where id = '" . $_SESSION['login_user_id'] . "'";
    $result_credit = mysqli_query($connection, $sql_credit) or die("query failed : sql_credit ");
    $result_credit_arr = mysqli_fetch_assoc($result_credit);
    $_SESSION['login_user_credits'] = $result_credit_arr['credit'];
}
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
$response = array();

if ($user_id != '') {
    $sql = "SELECT count(id) as total_num FROM `user_activity_log` WHERE `user_id` = '" . $user_id . "' AND `user_status` = '0'";
} else {
    $sql = "SELECT count(id) as total_num FROM `user_activity_log` WHERE `admin_status` = '0'";
}


// echo $sql; exit;

$result = mysqli_query($connection, $sql) or die("query failed : Notification Count");

$count = mysqli_fetch_assoc($result);

$total_count = $count['total_num'];

if ($total_count > 0) {
    if ($_SESSION['userroleforpage'] == 1) {
        $query = "select count(`activity_type`) as `doc_count` from `user_activity_log` where `activity_type`='Document Uploaded' && `admin_status` = '0'";
        $result1 = mysqli_query($connection, $query) or die("query failed : query");
        $num = mysqli_fetch_assoc($result1);
        $total_pending_doc = $num['doc_count'];
        if ($total_pending_doc > 0) {
            $response = array("doc_status" => true, "total_count" => $total_count, 'session'=>'true');
        } else {
            $response = array("doc_status" => false, "total_count" => $total_count, 'session'=>'true');
        }
    } else {
        $response = array("doc_status" => false, "total_count" => $total_count, 'session'=>'true');
    }
} else {
    $response = array("doc_status" => false, "total_count" => "", 'session'=>'true');
}
}else{
    $response = array("doc_status" => false, "total_count" => "", 'session'=>'Expired');
}
echo json_encode($response);
