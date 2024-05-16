#!/usr/bin/php -q
<?php 

set_time_limit(0); 
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ('phpagi/phpagi.php'); // I know very little about PHP and AGI

// Set Variable and initialize new AGI

$agi = new AGI();
$agi->answer();

#$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
//$exten=$agi->request[agi_extension];
$dnid = $agi->request[agi_dnid];
$date = date('Y-m-d H:i:s');

//###############################################
$agi->verbose("Coming CID================:" .$no);

$agi->verbose("Dialed DID================:" .$dnid);


$db = 'bigdialer';
$dbuser = 'root';
$dbpass = 'cce55c5c21';
$dbhost = 'localhost';

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$db);

// $q12="select did from cc_did where did='$exten'";
// $r12=mysqli_query($conn, $q12);
// while($row = mysqli_fetch_array($r12))
// {
// $didlist = $row['did'];
// }
$myquery_mod="select dest_setting from cc_did where did='$dnid'";
$myresult_mod=mysqli_query($conn, $myquery_mod);
$data=mysqi_fetch_assoc($myresult_mod);
$dest_setting=$data['dest_setting'];
$agi->verbose("Destination setting for DID============$dest_setting.query:" .$myquery);
if($dest_setting=='pri')
{
$agi->verbose("Destination setting $dest_setting================:" .$did);
}
if($dest_setting=='rand')
{

$agi->verbose("Destination setting $dest_setting================:" .$did);
}


?>



