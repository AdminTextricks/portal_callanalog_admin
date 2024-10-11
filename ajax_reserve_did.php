<?php
include_once ("connection.php");

$did = $_POST['productName'];
$sql = "select reserved from cc_did where did='" . $did . "'";
$result = mysqli_query($connection, $sql) or die("query failed : sql");
if (mysqli_num_rows($result) > 0) {
    $array = array();
    $row = mysqli_fetch_assoc($result);
    $reserved = $row['reserved'];
    if ($reserved == 1) {
        $status = 1;
        // $array = array('status' => false, 'message' => 'This DID already reserved for another user');
    } else {
        $query = "update cc_did set reserved='1' where did='" . $did . "'";
       $response = mysqli_query($connection, $query) or die("query failed : query");
        $status = 0;
    }
}
echo $status;


?>