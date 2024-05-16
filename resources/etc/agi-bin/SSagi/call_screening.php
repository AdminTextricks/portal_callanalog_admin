#!/usr/bin/php
<?php

set_time_limit(30);

require('phpagi/phpagi.php');

error_reporting(E_ALL);

$agi = new AGI();

$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);

$did=$agi->request[agi_extension];

//$Numlist="918869023049,919761818631,91919191"; // mention did numbers here for call capping

mysql_connect('localhost','root','tumko34h1se');
$agi -> verbose('connection set');
mysql_select_db('iglobal');

$sql = "select did,call_screen from cc_did WHERE did='$did';";
$agi -> verbose($sql);
$result = mysql_query($sql);
while($row = mysql_fetch_assoc($result))
{
$did=$row['did'];

$call_screen=$row['call_screen'];
}

if (empty($call_screen))

{$agi->set_variable("lookupcid", "$call_screen");}

else {

$agi->set_variable("lookupcid", "$call_screen");

}

mysql_close();

?>

