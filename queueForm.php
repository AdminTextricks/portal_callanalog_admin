<?php
include 'connection.php';


$extensionSelect = $_POST['extensionSelect'];
$queue_number = $_POST['queue_number'];
$uid = $_POST['uid'];
$id=$_POST['id'];

for ($i = 0; $i < count($extensionSelect); $i++) {
    $interface = 'SIP/' . $extensionSelect[$i];
    $insert = 'insert into cc_queue_member_table (queue_id,membername,queue_name,interface) values ("' . $id . '","' . $extensionSelect[$i] . '","' . $queue_number . '","' . $interface . '")';
    $resultddd = mysqli_query($connection, $insert);
}   
 header('Location: queuemanage.php?id=' . $id.'&uid='.$uid);




?>
