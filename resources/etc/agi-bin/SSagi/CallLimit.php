#!/usr/bin/php -q
<?php
set_time_limit(30);
require('phpagi.php');
error_reporting(E_ALL);

$agi = new AGI();

$extension = $agi->get_variable("EXTEN");
$agi->verbose("extension number is $extension[data]");

$family = "checkLimit";
$key = "$extension[data]";
$value =  $agi->database_get($family, $key);
$agi->verbose("value is $value");






















	
//mysqli_close($con);

?>
 
