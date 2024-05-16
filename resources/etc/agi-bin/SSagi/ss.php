#!/usr/bin/php
<?php
set_time_limit(30);
require('phpagi/phpagi.php');

error_reporting(E_ALL);

$agi = new AGI();

$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);

$dnid = $agi->request[agi_dnid];

$exten = $agi->request[agi_exten];

$agi->verbose($exten);

$agi->verbose($no);

mysql_connect('localhost','root','cce55c5c21');
$agi-> verbose('connection set');
mysql_select_db('bigdialer');

$sql = "select phone, msg from vici_tts WHERE phone='$no';";
$agi -> verbose($sql);
$result = mysql_query($sql);

while($row = mysql_fetch_assoc($result))

{
$no=$row['phone'];
$msg=$row['msg'];
$agi->verbose($no);
}
if($no==0)
 {
    $agi->set_variable("PHONESTATUS",0);
    $agi->set_variable("MESSAGE",$msg);

}

else{
 $agi->set_variable("PHONESTATUS",1);
 $agi->set_variable("MESSAGE",$msg);
}
mysql_close();
?>
