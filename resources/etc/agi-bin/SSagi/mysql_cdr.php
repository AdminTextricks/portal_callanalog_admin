#!/usr/bin/php -q
<?php
include ("/var/www/html/a2billing/bigpbx/common/lib/admin.defines.php");
include ("/var/www/html/a2billing/bigpbx/common/lib/admin.module.access.php");
include("/var/www/html/a2billing/bigpbx/common/lib/phpagi/phpagi.php");
include("/var/www/html/a2billing/bigpbx/commom/lib/phpagi/phpagi-asmanager.php");
$agi = new AGI();
$clid = ($argv[1] != NULL ||  $argv[1] != "") ? $argv[1]: "1111";
$src = ($argv[2] != NULL ||  $argv[2] != "") ? $argv[2]: "1111";
$dst = ($argv[3] != NULL ||  $argv[3] != "") ? $argv[3]: "1111";
$dcontext = ($argv[4] != NULL ||  $argv[4] != "") ? $argv[4]: "XXXXXXX";
$channel = ($argv[5] != NULL ||  $argv[5] != "") ? $argv[5]: "XXXXX";
$dstchannel = ($argv[6] != NULL ||  $argv[6] != "") ? $argv[6]: "XXXXX";
$lastapp = ($argv[7] != NULL ||  $argv[7] != "") ? $argv[7]: "XXXXXX";
$lastdata = ($argv[8] != NULL ||  $argv[8] != "") ? $argv[8]: "XXXXXX";
$start = ($argv[9] != NULL ||  $argv[9] != "") ? $argv[9]: date("Y-m-d H:i:s");;
$answer = ($argv[10] != NULL ||  $argv[10] != "") ? $argv[10]: "0";
$end = ($argv[11] != NULL ||  $argv[11] != "") ? $argv[11]: "2";
$duration = ($argv[12] != NULL ||  $argv[12] != "") ? $argv[12]: "23";
$billsec = ($argv[13] != NULL ||  $argv[13] != "") ? $argv[13]: "1321";
$disposition = ($argv[14] != NULL ||  $argv[14] != "") ? $argv[14]: "1";
$amaflags = ($argv[15] != NULL ||  $argv[15] != "") ? $argv[15]: "1";
$accountcode  = ($argv[16] != NULL ||  $argv[16] != "") ? $argv[16]: "5555";
$uniqueid  = ($argv[17] != NULL ||  $argv[17] != "") ? $argv[17]: time();
$userfield = ($argv[18] != NULL ||  $argv[18] != "") ? $argv[18]: "1";
$DBHandle  = DbConnect();
$IKC = new (Iglobal);
echo $QUERY = "INSERT INTO cdr(calldate, clid, src, dst, dcontext, channel, dstchannel, lastapp, lastdata, duration, billsec, disposition, amaflags, accountcode, uniqueid, userfield)  VALUES ('".$start."','".$clid."', '".$src."', '".$dst."','".$dcontext."','".$channel."','".$dstchannel."','".$lastapp."','".$lastdata."','".$duration."','".$billsec."','".$disposition."','".$amaflags."','".$accountcode."','".$uniqueid."','".$userfield."')";
//'".$start."','".$answer."','".$end."',
$IKC->debug(INFO, $agi, __FILE__, __LINE__, '[SIP QUERY : ' . $QUERY);
$IKC->debug(DEBUG, $agi, __FILE__, __LINE__, "[SIP QUERY] : " . $QUERY);
$instance_table = new Table();
$IKC->set_instance_table($instance_table);
$result = $IKC->instance_table->SQLExec($DBHandle, $QUERY);
?>

