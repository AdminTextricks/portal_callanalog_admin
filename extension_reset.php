<?php
include_once('connection.php');
$sql = "UPDATE `cc_sip_buddies` SET `in_use` = '0'";
$result = mysqli_query($connection,$sql);
if($result){
    echo "Extensions reset successfully";
}else{
    echo "Error updating record: " . mysqli_error($connection);
}
mysqli_close($connection);