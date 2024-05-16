#!/usr/bin/php -q

<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

declare(ticks = 1);
if (function_exists('pcntl_signal')) {
    pcntl_signal(SIGHUP, SIG_IGN);
}
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ('/var/www/html/worxpbx/AGI/lib/phpagi/phpagi.php'); // I do not know if it's really necessarry, I know very little about PHP and AGI


      $agi=new AGI();
      $cid = $agi->parse_callerid();
      $agi->verbose($cid);
      //$agi->verbose("Fetch_all_callerid info ================:" .$cid);

        $id=$_SERVER['argv'][1];
        $username=$_SERVER['argv'][2];
        $selection=$_SERVER['argv'][3];


 $myconnection = mysql_connect("localhost","root","tumko34h1se");
 mysql_select_db("worxdialer",$myconnection);

        $Query = "select id, username,id_group,".$selection." from cc_card where username = '".$username."'";
        $rsQuery = mysql_query($Query);
        $result = mysql_fetch_array($rsQuery);

         $agi->Noop($Query);

         if ($result['id']!="")
                {
                if ($result['id_group']=="1" and $result[$selection]=="1") {
                 //Authorised go to ok
                $agi->set_variable("continue","1");
        }
               elseif ($result['username']!=$username and $result['id_group']=="1") {
                        //Not Authorised go to off
                        $agi->set_variable("continue","2");
                }

                elseif ($result[$selection]=="0") {
                                //Not Authorised go to off

                                $agi->set_variable("continue","2");
                }
}
