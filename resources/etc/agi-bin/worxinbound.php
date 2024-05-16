#!/usr/bin/php -q
<?php
require_once("phpagi/phpagi.php");
        include("worxdb.php");
        pcntl_signal(SIGHUP, SIG_IGN);

        $agi = new AGI();
        $exten =  $agi->get_variable("EXTEN");
        $exten = $exten["data"];
        $call_ip = $agi->get_variable("CallFromIP");
        $call_ip = $call_ip["data"];
        $callerid = $agi->get_variable("CALLERID(num)");
        $callerid = $callerid["data"];
        $dnid = $agi->get_variable("CALLERID(dnid)");
        $dnid = $dnid["data"];
        $uidfirst=$agi->get_variable("UNIQUEID");
        $uidfirst=$uidfirst["data"];
        $agi->verbose("EXTEN=> $exten, IP =>$call_ip, CLI => $callerid, dnid=> $dnid, , uidfirst=> $uidfirst");
        $query="select id,did,user_id,fixrate,connection_charge,selling_rate,retail_initblock,retail_increment,buying_rate,buyrate_initblock,buyrate_increament
        from test_inbound_did where did='$callerid'";
        $result=mysql_query($query);
        $data=mysql_fetch_assoc($result);
        $card_id=$data['user_id'];
        $did=$data['did'];
        $sellrate=$data['selling_rate'];
        $initblock=$data['retail_initblock'];
        $increment=$data['retail_increment'];
        $buying_rate=$data['buying_rate'];
        $buyrate_initblock=$data['buyrate_initblock'];
        $buyrate_increament=$data['buyrate_increament'];
        $agi->verbose("What is DID: $did");

        $conn_charge=$data['connection_charge'];
        $qc="select credit,username from user_card where id='$card_id'";
        $rc=mysql_query($qc);
        $dc=mysql_fetch_assoc($rc);
        $credit=$dc['credit'];
        $user=$dc['username'];
        if($credit<='0' || $card_id=='' || $card_id < '1')
        {
         if($credit<='0')
                {
                        $agi->verbose("LOW_BALANCE");
                        $agi->hangup;
                }
                else
                {
                        $agi->verbose("INVALID CARD HANGING UP THE CALL ");
                        $agi->hangup;
                }
        }// NO BALANCE OR INVALID CARD
        else
        {
                        $timeout=(($credit-$conn_charge)/$sellrate)*60*1000;
                        if($timeout <= '0')
                        {
                                 $agi->verbose("LOW BALANCESSS");
                                 $agi->hangup;
                        }
                        $answeredtime = 0;
                        $agi->verbose("DID=>$did, user_id=> $card_id, connection_charge =>$conn_charge, sellrate => $sellrate");
                        $agi->verbose("initblock=> $initblock, bill_increment=>$increment, timeout=>$timeout");
                        $agi->verbose("Dialing ....");
                        $dialstr="Local/$did@worxpertise-inbound,60,L($timeout:60000:30000)";
                        $res_dial = $agi->exec("DIAL $dialstr");
                        $answeredtime = $agi->get_variable("ANSWEREDTIME");
                        $real_answeredtime = $answeredtime = $answeredtime['data'];
                        if($answeredtime=='' || is_null($answeredtime))
                        {
                                $answeredtime = 0;
                        }
                        $dialstatus = $agi->get_variable("DIALSTATUS");
                        $dialstatus = $dialstatus['data'];

                        $agi->verbose("Answertime=>$answeredtime, dialstatus=>$dialstatus");
                        if ($dialstatus == "CANCEL" ||  $dialstatus == "BUSY" || $dialstatus == "NOANSWER" || $dialstatus == "CHANUNAVAIL" ||
                        $dialstatus == "CONGESTION")
                        {
                                $answeredtime = 0;
                        }
                        if($answeredtime == '0')
                        {
                                $cost=0;
                        }

                        if($answeredtime > 0)
                        {
                        $callduration=$answeredtime;
                        $cost =0;


                        if ($callduration < $initblock)
                        {
                                $callduration = $initblock;
                        }

                        if (($increment > 0) && ($callduration > $initblock)) {$mod_sec = $callduration % $increment; // 12 = 3                                                                                        0 % 18
                        if ($mod_sec > 0) $callduration += ($increment - $mod_sec); // 30 += 18 - 12
                        }
                        $cost = (($callduration / 60) * $sellrate)+$conn_charge;$buyratecost = (($callduration / 60) * $buying_rate)+$conn_charge;
                        }// if duration > 0
                        $agi->verbose("Answertime=>$answeredtime, dialstatus=>$dialstatus, cost=> $cost");
                        $context =  $agi->get_variable("CONTEXT");
                        $context = $context["data"];
                        $calldate= $agi->get_variable("DATETIME");
                        $calldate= $calldate["data"];
                        $agi->verbose("$calldate");
                        $uid=$agi->get_variable("UNIQUEID");
                        $uid=$uid["data"];
                        $channel=$agi->get_variable("CHANNEL");
                        $channel=$channel["data"];
                        $dst="$exten@worxpertise-inbound";
                        $agi->verbose("buying rate : $buyratecost");
                        $qcdr="insert into custom_cdr (calldate,clid,src,dst,dcontext,duration,billsec,disposition,channel,extension,accountcode,uniqueid,answer,
end,did,cost,buycost,sell_rate,buying_rate,buyrate_initblock,buyrate_increament,sale_initblock,sale_increment) values(SUBDATE(now(), INTERVAL $answeredtime SECOND),
'$uidfirst','$uidfirst','$dst','$context','$answeredtime','$answeredtime','$dialstatus','$channel','$exten','$user','$uid',SUBDATE(now(), INTERVAL $answeredtime SECOND)
,now(),'$did','$cost','$buyratecost','$sellrate','$buying_rate','$buyrate_initblock','$buyrate_increament','$initblock','$increment')";

$rescdr=mysql_query($qcdr);
$agi->verbose("$qcdr");
//$qdisp="update worx_cdr set disposition='$dialstatus' where uniqueid='$uid'";
//$rdisp=mysql_query($qdisp);
$agi->verbose("$qdisp");
// charge the account

$qcost="update user_card set credit=credit-'$cost' where id='$card_id'";
$rescost= ($qcost);
}
?>

