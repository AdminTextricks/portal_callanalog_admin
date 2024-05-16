<?php 
require_once('connection.php'); 

$id = intval($_GET['id']);

$user_login = "select `plan_id` from users_login where `clientId`= '".$id."'";
$res_login = mysqli_query($connection, $user_login) or die("query failed");
if(mysqli_num_rows($res_login) > 0){
	$row = mysqli_fetch_assoc($res_login);
    $plan_id = $row['plan_id'];
    echo $plan_id;
}
?>