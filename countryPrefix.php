<?php
require_once('connection.php');

$country_code = $_POST['country_code'];

$sql = "SELECT `countryprefix` FROM `cc_country` WHERE `countrycode` = '$country_code'";

$result = mysqli_query($connection, $sql) or die("query failed");


if(mysqli_num_rows($result)){
    $row = mysqli_fetch_assoc($result);
    $countryPrefix = '+'.$row['countryprefix'];
    
}
echo $countryPrefix;

?>