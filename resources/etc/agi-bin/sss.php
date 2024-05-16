#!/usr/bin/php -q
<?php
require_once("phpagi/phpagi.php");
        include("worxdb.php");
        pcntl_signal(SIGHUP, SIG_IGN);

        $agi = new AGI();
        $exten =  $agi->get_variable("EXTEN");
        $exten = $exten["data"];
        $callerid = $agi->get_variable("CALLERID(num)");
        $callerid = $callerid["data"];
        $dnid = $agi->get_variable("CALLERID(dnid)");
        $dnid = $dnid["data"];
        $uidfirst=$agi->get_variable("UNIQUEID");
        $uidfirst=$uidfirst["data"];
        $query="select campaign_name, did_pattern,campaign_id from vicidial_campaigns LEFT JOIN from vicidial_inbound_dids ON vicidial_campaigns.campaign_id=
        vicidial_inbound_dids.filter_campaign_id where did_pattern='$exten'";
        $result=mysql_query($query);
        $data=mysql_fetch_assoc($result);
        $campaign_name=$data['campaign_name'];
        $did=$data['did_pattern'];
        $campaign_id=$data['campaign_id'];
        $qc="select campaign_name,username from vicidial_campaigns where campaign_id='$campaign_id'";
        $rc=mysql_query($qc);
        $dc=mysql_fetch_assoc($rc);

                        $agi->verbose($campaign_id);
                        $agi->verbose($data);
                        $agi->verbose($dc);






?>						

