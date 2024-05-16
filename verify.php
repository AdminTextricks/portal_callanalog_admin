<?php

include 'connection.php';


$user_mobile = $_POST['user_mobile'];
$mobile_otp = $_POST['mobile_otp'];
$user_id = $_POST['user_id'];
$res = 'false';
$sql = "SELECT * FROM users_login WHERE id='".$user_id."' and mobile_otp ='".$mobile_otp."'";

$result2 = mysqli_query($con,$sql);
if(mysqli_num_rows($result2) > 0 ){
   // echo '<pre>';print_r($row_user);exit;
    $query = "UPDATE `users_login` SET `mobile_verify_status` = '1' WHERE `id` = '".$user_id."'";
    mysqli_query($connection, $query) or die("query failed");
    $res = 'true';
    
}

$res_array = array('response'=>$res);
echo json_encode($res_array);
?>