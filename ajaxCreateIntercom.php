<?php
require_once('connection.php');
// connect to DB
// $extension_number = $_GET['extension_number'];
// run an endless loop

// generate unique random number
$randomNumber = rand(0, 9999);
// pad the number with zeros (if needed)
$paded = str_pad($randomNumber, 4, '0', STR_PAD_RIGHT);
// check if it exists in database
if($_POST['data_type'] == 'ring'){
    $query = "SELECT `ringno` FROM cc_ring_group WHERE `ringno`='" . $paded . "'";
}elseif($_POST['data_type'] == 'queue'){
    $query = "SELECT `name` FROM cc_queue_table WHERE `name`='" . $paded . "'";
}else{
    $query = "SELECT `confno` FROM booking WHERE `confno`='" . $paded . "'";
}

$res = mysqli_query($connection, $query);
$rowCount = mysqli_num_rows($res);
if ($rowCount < 1) {
    echo $paded;
}
 
?>