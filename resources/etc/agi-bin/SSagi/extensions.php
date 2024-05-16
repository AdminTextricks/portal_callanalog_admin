#!/usr/bin/php -q
<?php
require'phpagi/phpagi.php';

set_time_limit(30);
declare(ticks = 1);
if (function_exists('pcntl_signal')) {
    pcntl_signal(SIGHUP, SIG_IGN);
}


$agi = new AGI();
$conn = mysql_connect("localhost","root","GFDUedThsS");
mysql_select_db("bigdialer",$conn);

//$caller_no = $argv[1];
$caller_no = preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
$agi->verbose("CALLERNUMBER : $caller_no");
$query = "SELECT userid,lead_operator FROM cc_sip_buddies WHERE name = '".$caller_no."'";
$result = mysql_query($query);
$agi->verbose("QUERY1 : $query");
while ($row = mysql_fetch_assoc($result)) {
        $userid = $row['userid'];  //caller number user id
        $lead_operator = $row['lead_operator'];  //caller number qr_code

}

//$dialed_no = $argv[2];
$dialed_no = $agi->request[agi_extension];
$dialed_phone = ltrim(str_replace('+','',$dialed_no),'+');
$dialed_no = ltrim($dialed_phone,"+");
$dialed_phone = ltrim(str_replace('+','',$dialed_no),'0');
$agi->verbose("ARGV2NUMBER : $dialed_phone");
// dialed number without 0 ex - 7894561237

$query = "SELECT userid,lead_operator FROM cc_sip_buddies WHERE name = '". $dialed_phone ."' AND lead_operator = '".$lead_operator."'";

$result = mysql_query($query);
$agi->verbose("QUERYES : $query");
while($row = mysql_fetch_assoc($result)) {
$receiverid = $row['userid'];  //receiver user id
$receiver_lead_operator = $row['lead_operator'];  //recceiver qr_code
}
$rowcount=mysql_num_rows($result);
mysql_close($conn);
if($rowcount == '0')
{

$agi->exec_goto(3);
exit(0);
}
else {
$agi->verbose("OUTPUT : $output");
$caller_phone = $caller_no;
$agi->verbose("NUMBERRSRRSRSRS : $caller_phone");
if('OK' == 'OK')
{
 if($lead_operator == $receiver_lead_operator AND $userid != $receiverid)
                {
//echo 'Authentication successful and forworing call';
 $agi->set_variable("CALLERID(num)","".$caller_phone."");
 $agi->exec('Dial', "SIP/".$dialed_no.",25,r");
 exit(0);

}
else
{
//echo 'Unavailable'."\n";
$agi->exec_goto(3);
exit(0);
                }

}
else{

//echo 'SIP account is not reachable, forwarding call to PSTN'."\n";

$agi->exec_goto(3);
exit(0);
        }

}
exit(0);
?>


