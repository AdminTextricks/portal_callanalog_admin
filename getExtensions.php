<?php
include 'connection.php';
$query_ringmanage = "select * from cc_ring_group where id='" . $_POST['id'] . "'";
$result_managering = mysqli_query($connection, $query_ringmanage);
$row_manage = mysqli_fetch_array($result_managering);
$ring_number = $row_manage['ringno'];
$ringlist = $row_manage['ringlist'];

$ring_array = array();
if (!empty($ringlist)) {
    $ring_array = explode('-', $ringlist);
}


$ring_uid = "";
if (isset($_POST['uid']) && $_POST['uid'] != '') {
    $ring_uid = "id_cc_card='" . $_POST['uid'] . "' AND";
}
if ($_SESSION['userroleforpage'] == 1) {
    $query_ring_buddies = "select id, id_cc_card, name from cc_sip_buddies where " . $ring_uid . " name NOT IN ( '" . implode("', '", $ring_array) . "' ) order by name";
} else {
    $query_ring_buddies = "select id, id_cc_card, name from cc_sip_buddies where id_cc_card='" . $_SESSION['login_user_id'] . "' AND name NOT IN ( '" . implode("', '", $ring_array) . "' ) order by name";
}
$result_ringbuddies = mysqli_query($connection, $query_ring_buddies);

while ($row_buddies = mysqli_fetch_array($result_ringbuddies)) {
    $response = '<option ondblclick="getData(' . $row_buddies['name'] . ')"
        value="' . $row_buddies['name'] . '">' .
        $row_buddies['name'] . '</option>';
    echo $response;
}



?>