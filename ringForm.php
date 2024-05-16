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
if (isset($_POST['extensionSelect'])) {
    $extensionSelect = $_POST['extensionSelect'];
    if ($extensionSelect !== "") {
        $ring_extension = array_merge($ring_array, $extensionSelect);
        //echo '<pre>'; print_r($ring_extension); echo '</pre>';exit;
        $update_ringmanage = "update cc_ring_group set ringlist='" . implode('-', $ring_extension) . "' where id='" . $_POST['id'] . "'";
        // echo $update_ringmanage;exit;
        $result_managering = mysqli_query($connection, $update_ringmanage);
        //echo '<script>location.reload();</script>';
    }

} else {
    $ring_msg = "Please Select Atleast One Extension";
}

?>