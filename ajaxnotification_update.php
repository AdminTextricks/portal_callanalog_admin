<?php
include 'connection.php';
 $user_id = isset($_POST['user_id']) ?$_POST['user_id'] : ''; 
if($user_id != ''){
    $sql = "UPDATE `user_activity_log` SET `user_status` = '1' WHERE `user_id` = '$user_id' AND `user_status`='0'";
}else{
    $sql = "UPDATE `user_activity_log` SET `admin_status` = '1' WHERE `admin_status`= '0'";
}
// echo $sql; exit;
$result =  mysqli_query($connection, $sql) or die("query failed");
if($result){
    echo 1;
}else{
    echo 0;
}

?>

