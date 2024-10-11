<?php

include 'connection.php';
$ringlist = $_POST['ringlist'];
$ring_array = array();
if (!empty($ringlist)) {
    $ring_array = explode('-', $ringlist);
}
if (isset($_POST['extensionSelect'])) {
    $extensionSelect = $_POST['extensionSelect'];
    $ring_extension = array_merge($ring_array, $extensionSelect);
    //echo '<pre>'; print_r($ring_extension); echo '</pre>';exit;
    $update_ringmanage = "update cc_ring_group set ringlist='" . implode('-', $ring_extension) . "' where id='" . $_POST['id'] . "'";
    $result_managering = mysqli_query($connection, $update_ringmanage);
    $_POST['submit'] = '';
    header('Location: ringmanage.php?id=' . $_POST['id'] . '&uid=' . $_POST['uid']);
    //echo '<script>location.reload();</script>';
} else {
    $ring_msg = "Please Select Atleast One Extension";
}


?>