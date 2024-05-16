<?php
include 'connection.php';

$did = $_POST['did'];

$sql = "SELECT `did_provider` FROM `cc_did` WHERE `id` = '$did'";


$result = mysqli_query($connection, $sql) or die("query failed");

$str = "";
if (mysqli_num_rows($result)) {
    $row = mysqli_fetch_assoc($result);
    $didProvider = $row['did_provider'];

    $str .="<option value='".$didProvider."'>".$didProvider."</option>";
}
echo $str;

?>