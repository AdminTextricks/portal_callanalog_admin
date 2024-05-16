<?php
include 'connection.php';
include '/var/www/html/callanalog/common/lib/phpagi/phpagi-asmanager.php';
$extension = $_GET['ext'];
$sql = "select `user_id` from `cc_sip_buddies` where name = '" . $extension . "'";
$result = mysqli_query($connection, $sql) or die("query failed : sql");
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];
}

$server_sql = "select server_ip from cc_servers where user_id = '" . $user_id . "'";
$server_res = mysqli_query($connection, $server_sql) or die("query failed : server_sql");
if (mysqli_num_rows($server_res) > 0) {
    $rows = mysqli_fetch_assoc($server_res);
    $server_ip = $rows['server_ip'];
}
// echo $server_ip;exit;37.61.219.110:50070
ini_set('allow_url_include', 1);
set_error_handler("customError", E_USER_WARNING);

$asm = new AGI_AsteriskManager();
if ($asm->connect('37.61.219.110', 'NikasqkR', '}Sv*54#Gu(o]g83')) {
    $result = $asm->Command("sip unregister " . $extension);
}else{
    echo 'not connect';
}
$query = "update cc_sip_buddies set webphone_status='0' where name = '" . $extension . "'";
$response = mysqli_query($connection, $query) or die("query failed : query");
if ($result['Response'] == 'Success') {
    $asm->disconnect();
    echo true;
} else {
    $asm->disconnect();
    echo false;
}

?>