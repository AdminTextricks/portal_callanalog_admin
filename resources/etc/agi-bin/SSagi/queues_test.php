#!/usr/bin/php -q
<?php

require_once "phpagi/phpagi.php";
            //$ini_array = parse_ini_file("/etc/iglobal.conf");
           // $connA = mysql_connect($ini_array["hostname"], $ini_array["user"], $ini_array["password"]);
           // mysql_select_db($ini_array["dbname"], $connA);

//require_once ("mysql_connection.php");
pcntl_signal(SIGHUP, SIG_IGN);
set_time_limit(30);
error_reporting(E_ALL);
$agi = new AGI();
$did=$agi->request['agi_extension'];
$agi->verbose("DID: $did");


$con=mysqli_connect("localhost","root","GFDUedThsS","bigdialer");



$q4="select iduser,destination_name,destination from cc_did where did='$did'";
// and iduser in(select id from cc_card where username='$acc'";
$agi->verbose($q4);
$r4=mysql_query($con,$q4);
$d4=mysql_fetch_assoc($r4);
$iduser=$d4['iduser'];
$destination_type=$d4['destination_name'];
$destination=$d4['destination'];
$agi->verbose("In FUNCTION:IDUSER: $iduser, Destination_type=$destination_type, destination : $destination");

//$exten=$agi->request['agi_exten'];
if($destination_type='queues')
{
$agi->exec("Goto","bigpbx-queues,$exten,1");
}
if($destination_type=='extensions')
{
$agi->exec("Goto","bigpbx-extension,$exten,1");
}
{
}

