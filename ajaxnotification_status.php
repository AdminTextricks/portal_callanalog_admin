<?php
include 'connection.php';
 $user_id = isset($_POST['user_id']) ?$_POST['user_id'] : '';
 $sql = "UPDATE `user_activity_log` SET `admin_status` = '1' WHERE `activity_type`='Document Uploaded' && `admin_status`= '0'";
// echo $sql; exit;
$result =  mysqli_query($connection, $sql) or die("query failed");
if($result){
    echo 1;
}else{
    echo 0;
}
?>