#!/usr/bin/php -q
<?php
set_time_limit(30);
require('phpagi/phpagi.php');
error_reporting(E_ALL);
$agi = new AGI();

$con=mysqli_connect("localhost","root","GFDUedThsS","bigdialer");

if (mysqli_connect_errno())
  {
  $agi->verbose("Connection Failed!!");
 }
else{

 $agi->verbose("Hurray Connection Successful!!");


}
