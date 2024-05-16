<?php
include 'connection.php';
include "/var/www/html/callanalog/common/lib/phpagi/phpagi-asmanager.php";
$channel = $_GET['agent_channel'];

// echo $channel;exit;
$get_user = "select user_id from cc_live_calls where agent_channel = '".$channel."'";
$result = mysqli_query($connection, $get_user) or die("query failed : get_user");
if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
}

$get_server = "select `server_ip` from `cc_servers` where user_id = '".$user_id."'";
$response = mysqli_query($connection, $get_server) or die("query failed : get_server");
if(mysqli_num_rows($response) > 0){
    $rows = mysqli_fetch_assoc($response);
    $server_ip = $rows['server_ip'];
}

// AMI connection parameters
$host = '37.61.219.110';
$port = '4783';
$username = 'NikasqkR';
$password = '}Sv*54#Gu(o]g83';
// Channel to hang up (replace this with the actual channel ID)

// AMI command to hang up the channel
$command = "Action: Logoff\r\n\r\n";
// Open a socket to the Asterisk Manager Interface
$socket = fsockopen($host, $port, $errno, $errstr, 10);
if (!$socket) {
    echo "Error connecting to Asterisk Manager Interface: $errstr ($errno)\n";
    exit (1);
}
// Login to the AMI
fwrite($socket, "Action: Login\r\n");
fwrite($socket, "Username: $username\r\n");
fwrite($socket, "Secret: $password\r\n\r\n");
// Send the hangup command for the specified channel
fwrite($socket, "Action: Hangup\r\n");
fwrite($socket, "Channel: $channel\r\n\r\n");
// Logoff from the AMI
fwrite($socket, $command);
// Close the socket
fclose($socket);
$del = "delete from cc_live_calls where agent_channel='" . $channel . "'";
$res_del = mysqli_query($connection, $del);
header("Location: barge.php");
// echo "Channel $channel hung up successfully.\n";











/* 
$channelss = $_GET['channelid'];
ini_set('allow_url_include', 1);
set_error_handler("customError", E_USER_WARNING);

$asm = new AGI_AsteriskManager();
if ($asm->connect('37.61.219.110', 'NikasqkR', '}Sv*54#Gu(o]g83')) {
    $result = $asm->Command("channel request hangup " . $channelss . "");
    $del = "delete from cc_live_calls where call_id='" . $channelss . "'";
    $res_del = mysqli_query($connection, $del);
    header("Location: barge.php");
}
$asm->disconnect(); */


?>