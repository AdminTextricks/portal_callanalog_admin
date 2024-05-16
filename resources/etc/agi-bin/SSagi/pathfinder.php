#!/usr/bin/php -q

<?php

/*vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
declare(ticks = 1);
if (function_exists('pcntl_signal')) {
    pcntl_signal(SIGHUP, SIG_IGN);
}
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ('phpagi/phpagi.php'); // I do not know if it's really necessary, as I said at the beginning, I know very little about PHP and AGI


        $agi=new AGI();
        $did=$_SERVER['argv'][1];
        $mydid=$_SERVER['argv'][2];
        $permission=$_SERVER['argv'][3];


        $connection = mysql_connect("localhost","root","tumko34h1se");
        mysql_select_db("worxdialer",$connection);

        $Query = "select id,did,activated,didtype,cc_did_mod,".$permission.",call_screening_action from cc_did where did='".$mydid."'";
        $rsQuery = mysql_query($Query);
                $agi -> verbose($Query);
        $result = mysql_fetch_array($rsQuery);

                $agi -> Noop($Query);

                if ($result['did']!="") {
                if ($result['activated']=="1" and $result[$permission]=="1") {
                 //callforwarding
                $agi -> set_variable("continue","1");
                }
                elseif ($result['activated']=="0" and $result[$permission]=="1") {
                        //callingforwarding
                        $agi -> set_variable("continue","1");
                }
                $actions_setting= $result['call_screening_action'];
                if( $actions_setting=='9')
                {
                        $agi -> set_variable("continue","9");
                }

                   

                 elseif ($result['did']==$mydid and $result['didtype']=="2") {
                        //Auto Attendant
                        $agi -> set_variable("continue","2");
                }
                elseif ($result['did']==$mydid and $result['didtype']=="3") {
                        //Conference
                        $agi -> set_variable("continue","3");
                }
               
                $actions_setting= $result['call_screening_action'];
                if( $actions_setting=='9')
                {
                        $agi -> set_variable("continue","9");
                }

                elseif ($result['did']==$mydid and $result['didtype']=="4") {
                        //Voicemail
                $agi -> set_variable("continue","4");
                }
                  elseif ($result['did']==$mydid and $result['didtype']=="7") {
                        //Voicemail
                $actions_setting= $result['call_screening_action'];
                if( $actions_setting=='9')
                {
                        $agi -> set_variable("continue","9");
                }
                else
                {
                $agi -> set_variable("continue","8");
                }
                 }
                        //      elseif ($result['did']==$mydid and $result['didtype']=="5") {
                else {
                        //Calling Card
                $agi -> set_variable("continue","5");
                }

                // else ($result[$permission]=="0") {
                             //   Pinbase agi3

                // $agi -> set_variable("continue","2");
                // }
                 }

                else{
                //pin incorrect

              $agi -> set_variable("continue","6");
        }


