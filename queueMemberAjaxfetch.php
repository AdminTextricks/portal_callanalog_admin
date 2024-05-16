<?php require_once('connection.php'); 

if (isset($_POST["uniqueid"])) {
    $query  = "SELECT * FROM cc_queue_member_table WHERE uniqueid = '" . $_POST["uniqueid"] . "'";
    $result = mysqli_query($connection, $query);
    $row    = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>