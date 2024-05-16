<?php
include 'connection.php';
$did_price = $_POST['did_price'];
$ext_price = $_POST['ext_price'];

$response = array();
$sql1 = "update cc_did_exten_price set price='" . $did_price . "' where type='did' and user_id='0'";
$res1 = mysqli_query($connection, $sql1);
$sql2 = "update cc_did_exten_price set price='" . $ext_price . "' where type='extension' and user_id='0'";
$res2 = mysqli_query($connection, $sql2);

if ($res1 && $res2) {
    $response['error'] = false;
    $response['message'] = "Price Changed Successfully..";
} else {
    $response['error'] = true;
    $response['message'] = "Something went wrong..";
}

echo json_encode($response);

?>