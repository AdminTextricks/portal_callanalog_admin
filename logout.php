<?php
session_start();
require_once('connection.php');

$update_session_log = "UPDATE `user_session_log` SET `logout_time` = '".date('Y-m-d H:i:s')."' WHERE `id`='".$_SESSION['activity_last_id']."'";
mysqli_query($connection,$update_session_log);

if(session_destroy()) // Destroying All Sessions
{
header("Location: index.php"); // Redirecting To Home Page
}
?>