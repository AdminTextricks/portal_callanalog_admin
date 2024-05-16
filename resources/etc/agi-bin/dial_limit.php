#!/usr/bin/php -q

<?php
set_time_limit(0);
require('phpagi/phpagi.php');
error_reporting(E_ALL);
$agi = new AGI();

$db = 'asterisk';
$dbuser = 'root';
$dbpass = 'tumko34h1se';
$dbhost = 'localhost';
$connection = mysqli_connect($dbhost,$dbuser,$dbpass,$db);

$today = date("Y-m-d");
$today_last = date('Y-m-d 23:59:59');
$call_date = date('Y-m-d h:i:s');
$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
$exten=$agi->request[agi_extension];

$agi->verbose("Callerid : $no\n");
$agi->verbose("EXTEN : $exten\n");



$q1="insert into vicidail_nmtwice (calldate,callnum,phone) values ('".$call_date."','".$no."','".$exten."')";
$result = mysqli_query($connection,$q1);


$counting_clid = "select count(callnum) as total from vicidail_nmtwice where calldate > '$today' and calldate <= '$today_last' and callnum=$no";
$agi->verbose("query1ttttt : $counting_clid\n");
$counting_result = mysqli_query($connection,$counting_clid);

$whitelist_callerid = "select callnum from vicidial_whitelist_number where callnum=$no";
$agi->verbose("whitelist callerid query : $whitelist_callerid\n");
$vicidial_whitelist_number = mysqli_query($connection,$whitelist_callerid);

while($row_wtlc = mysqli_fetch_assoc($vicidial_whitelist_number)) {
    $whitelist = $row_wtlc['callnum'];
  }


  // output data of each row
  while($row = mysqli_fetch_assoc($counting_result)) {
    $totalclidd = $row['total'];
  }
  if ($totalclidd > 2 AND $whitelist != $no) {
  $agi->verbose("No need to process this.. $totalclidd \n");
} else {
 $agi->verbose("No need to process this.. 1  $no 2  $totalclidd 3  $whitelist \n");
        $agi->exec('Goto','DID-CALLING,'.$did.',1');

}

?>

