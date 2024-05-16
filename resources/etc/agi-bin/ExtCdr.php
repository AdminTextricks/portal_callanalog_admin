#!/usr/bin/php
<?php
$uniqueid=$argv[1];
$userid=$argv[2];
$tonum=$argv[3];
$fromnum = $argv[4];
$callstart = $argv[5];
$callans = $argv[6];
$callend = $argv[7];
$tot_dur = $argv[8];
$talk_dur = $argv[9];
$dialstatus = $argv[10];
$recname = $argv[11];
$agentid = $argv[12];
//$caller = '9990917183';
date_default_timezone_set("Asia/Kolkata");

 $link = mysqli_connect("localhost", "root", "tumko34h1se");
    if (!$link) {
        die('Could not connect: ' . mysqli_error());
    }
    mysqli_select_db($link, 'asterisk');

//echo $compid;
//echo $compnum;

//$agentqry = "SELECT OPID,Name FROM Operators WHERE SIP = 11$fromnum AND current_status = 1 LIMIT 1";
//echo $agentqry;
//$agentAval = mysqli_query($link, $agentqry);
//$row = mysqli_fetch_array($agentAval,MYSQLI_NUM);
//$agentid =  trim($row[0]);
//$agentname =  trim($row[1]);

//$agentupdateqry = "UPDATE Operators SET ONCALL=0 WHERE  OPID=$agentid LIMIT 1";
//echo $agentupdateqry;
//$agentupdateqry_status = mysqli_query($link,$agentupdateqry);

//$recpath = "http://192.168.0.252/SNVAREC/$uniqueid.wav";
$recpath = "http://10.130.8.101/WORX/$recname.wav";
$comp_ins_qry = "INSERT INTO ob_cdr (SUniqueID,UserID,DID,AgentNumber,CallerNumber,CallType,CallStartTime,CallAnswerTime,CallEndTime,CallDuration,CallTalkTime,RecPath,CallStatus,CallTypeID,AgentStatus,CustomerStatus,AgentID,AgentName) VALUES ('$uniqueid','$userid','$fromnum','$fromnum','$tonum','OUTGOING','$callstart','$callans','$callend','$tot_dur','$talk_dur','$recpath','$dialstatus',0,'ANSWER','$dialstatus','$agentid','$agentname')";
$comp_ins = mysqli_query($link,$comp_ins_qry);

echo $comp_ins_qry;

mysqli_close($link);




