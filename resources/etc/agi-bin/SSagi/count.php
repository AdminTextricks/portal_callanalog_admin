#!/usr/bin/php -q

<?php
set_time_limit(0);
require('phpagi.php');
include("getcc.php");
$ip="127.0.0.1";$user="cron";$pass="1234";
show_calls($ip,$user,$pass);

error_reporting(E_ALL);

$db = 'worxdialer';
$dbuser = 'root';
$dbpass = 'tumko34h1se';
$dbhost = 'localhost';
mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db("$db"); //or die("could not open database");

$agi = new AGI();
$agi->answer();
$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);
$exten=$agi->request[agi_extension];
$dnid = $agi->request[agi_dnid];
$agi->verbose("Callerid : $no\n");
$agi->verbose("EXTEN : $exten\n");
$agi->verbose("DNID : $no\n");

function get_callcap($did,$hits)
{
$dt=date("Y-m-d");
$q="select id from callcap where did='$did' and calldate like '$dt%'";
$agi->verbose("query : $q\n");
$row=mysql_query($q);
$numrows=mysql_num_rows($row);
$agi->verbose("NUMROWS : $numrows\n");
if ($numrows>=$hits){
//$agi->verbose("Tried $hits attempt already..\n");
$data =0;
}
else {
$data=1;
}
return $data;
}

function get_callcapm($did,$hits)
{
$dt=date("Y-m");
$q="select id from callcap where did='$did' and calldate like '$dt%'";
$agi->verbose("query : $q\n");
$row=mysql_query($q);
$numrows=mysql_num_rows($row);
//$agi->verbose("NUMROWS : $numrows\n");
if ($numrows>=$hits){
//$agi->verbose("Tried $hits attempt already..\n");
$data =0;
}
else {
$data=1;
}
return $data;
}

//$didlist="18888994944,18125730131,15615089044,18665914944,91919191"; // mention did numbers here for call capping
$q1="select name from followme_numbers where phonenumber='$exten'";
$r1=mysql_query($q1);
$n1=mysql_num_rows($r1);
$agi->verbose("query1 : $q1\n");
$agi->verbose("NUMROWS1 : $n1\n");
if($n1>=1)
{
$d1=mysql_fetch_assoc($r1);
$name=$d1['name'];

$q2="select name from followme_numbers where name='$name'";
$r2=mysql_query($q2);
$n2=mysql_num_rows($r2);
$agi->verbose("query2 : $q2\n");
$agi->verbose("NUMROWS2 : $n2\n");
for ($i=1;$i<=$n2;)
{

$q3="select id,name,ordinal,phonenumber,timeout,concall,id_card,monthly_limit,status,limit_monthly from followme_numbers where name='$name' and ordinal='$i'";
$agi->verbose("query : $q3\n");

$r3=mysql_query($q3);
$d3=mysql_fetch_assoc($r3);
$hits=$d3['timeout']; // number of hits daily
$hits_monthly=$d3['limit_monthly'];
$cc=$d3['concall'];
$status=$d3['status'];
$did=$d3['phonenumber'];

$agi->verbose("Daily limit  : $hits\n");
$agi->verbose("monthly limit : $hits_monthly\n");
$agi->verbose("Did status : $status\n");

//$callcapd=get_callcap($did,$hits);
//$callcapm=get_callcapm($did,$hits_monthly);
//$mycc=get_cc($name,$did);

$agi->verbose("Find USES ......\n");

$dt1=date("Y-m-d");
$q4="select count(*) as count from callcap where did='$did' and calldate like '$dt1%'";
$agi->verbose("query : $q4\n");
$row=mysql_query($q4);
$d4=mysql_fetch_assoc($row);
$n4=$d4['count'];

$agi->verbose("NUMROWS : $n4\n");
if($n4<=$hits)
{
$callcapd=1;
}
else
{
$callcapd=0;
}

$dt2=date("Y-m");
$q5="select count(*) as count from callcap where did='$did' and calldate like '$dt2%'";
$agi->verbose("query : $q5\n");
$row5=mysql_query($q5);
$d5=mysql_fetch_assoc($row5);
$n5=$d5['count'];
$agi->verbose("NUMROWS : $n5\n");
if($n5<=$hits_monthly)
{
$callcapm=1;
}
else
{
$callcapm=0;
}
$mycc=show_calls($ip,$user,$pass);
$agi->verbose("Daily call cap status : $callcapd\n");
$agi->verbose("monthly call cap status : $callcapm\n");
$agi->verbose("Did status : $status\n");
$agi->verbose("cc : $mycc\n");
if($callcapd==0 || $callcapm==0 || $status==0)
{
$agi->verbose("call cap reached DID $did and priority number : $i\n");
$i=$i+1;
}// move to next priority
else
{
$agi->verbose("valid call exit the loop..\n");
$q="insert into callcap values('', now(),'$no','$did')";
$res=mysql_query($q);
$i=$n2+1;
break;
}
}

$agi->exec('Goto','billing-did,'.$did.',2');
//$agi->verbose("valid call..\n");
//$q="insert into callcap values('', now(),'$no','$exten')";
//$res=mysql_query($q);

}// DID found in DB for processing

else
{
$agi->verbose("No need to process this.. \n");
}

?>

