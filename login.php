<?php

session_destroy();
die();
session_start(); // Starting Session
//$error=''; // Variable To Store Error Message
if(isset($_POST['submit'])) {

if(!empty($_POST['username']) OR !empty($_POST['password']))
{

// Define $username and $password
$username=$_POST['username'];
$password=$_POST['password'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysqli_connect("localhost", "root", "tumko34h1se",'bigpbx');


 $query = "select * from users_login where password='".$password."' AND email='".$username."'";
 $result = mysqli_query($connection ,$query);
while($row = mysqli_fetch_row($result)) {
	$login_user =  $row['email'];
}

if($login_user == $username) {
$_SESSION['login_user']=$login_user; // Initializing Session
header("location: dashboard.php"); // Redirecting To Other Page
} 
mysqli_close($connection); // Closing Connection
}
else {
echo $error = "Username or Password is invalid";
}
}else{
	echo 'nothing';
}
?>
