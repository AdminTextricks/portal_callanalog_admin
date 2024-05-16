#!/usr/bin/php -q
<?php

require_once("phpagi/phpagi.php");
$agi = new AGI();
//$acc=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
//$acc=$acc["data"];

//$callerid = $acc["data"];

//$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
//$ext=$agi->request[agi_extension];

$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
$ini_array = parse_ini_file("/etc/iglobal.conf");
$connA = mysql_connect($ini_array["hostname"], $ini_array["user"], $ini_array["password"]);
mysql_select_db($ini_array["dbname"], $connA);

$query="select outbound_cid from cc_sip_buddies where name='$no')";

$res=mysql_query($query);
$data=mysql_fetch_assoc($res);
$cid=$data['outbound_cid'];
$agi->verbose("***Preroute-AGI => outbound_cid => ".$cid);
$agi->verbose("***Preroute-AGI => outbound_cid => ".$callerid);

if (empty($cid) or (empty($callerid)))

{$agi->set_variable("mycid", "$callerid");}

else {

$agi->set_variable("mycid", "$cid");

}

mysql_close();

?>

