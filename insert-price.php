<?php
include 'connection.php';

$country_id = $_POST['country_id'];
$price = $_POST['price'];
$type = $_POST['type'];
$tax_type = $_POST['tax_type'];
$tax_per = $_POST['tax_per'];

$sql = "INSERT INTO `cc_did_exten_price` (`country_id`, `price`,`type`,`tax_type`,`tax_per`) VALUES ('$country_id','$price','$type','$tax_type','$tax_per')";

if(mysqli_query($connection, $sql)){
    echo 1;
}else{
    echo 0;
}
?>