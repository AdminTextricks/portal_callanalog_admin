<?php

include 'connection.php';

$user_id = $_POST['user_id'];

$extData = "";
$sipQuery = "SELECT `name`,  `secret` FROM `cc_sip_buddies` WHERE id_cc_card = '" . $user_id . "' and ext_status='1'";
$sip_result = mysqli_query($con, $sipQuery) or die("query failed");
$i = 1;
if (mysqli_num_rows($sip_result) > 0) {
    $extData .= '<h3 style="font-weight:bold;">Extension Details</h3>';
    while ($sip_details = mysqli_fetch_assoc($sip_result)) {
        $extData .= '<div><h6>' . $i . '. Extension Number: ' . $sip_details['name'] . '</h6>';
        $extData .= '<h6 style="margin-top: 0px;  display: inline; border-bottom: 1px dashed; padding-bottom: 5px;">Extension Password: ' . $sip_details['secret'] . '</h6></div>';
        $i++;
    }
}


$didQuery = "SELECT did FROM cc_did WHERE iduser='" . $user_id . "' and activated='1' and status='Active'";
$didRes = mysqli_query($connection, $didQuery) or die("query failed : didQuery");
if (mysqli_num_rows($didRes) > 0) {
    $i = 1;
    $extData .= '<h3 style="font-weight:bold;">DID Details</h3>';
    while ($did_row = mysqli_fetch_assoc($didRes)) {
        $extData .= '<div><h5>' . $i . '. DID Number: ' . $did_row['did'] . '</h5></div>';
        $i++;
    }
}

echo $extData;

?>