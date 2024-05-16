#!/usr/bin/php -q

<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

declare(ticks = 1);
if (function_exists('pcntl_signal')) {
    pcntl_signal(SIGHUP, SIG_IGN);
}
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));




require ('/var/www/html/worxpbx/AGI/lib/phpagi/phpagi.php'); // I do not know if it's really necessary, as I said at the beginning, I know very little about PHP and AGI

$agi=new AGI();

$conn_san = mysqli_connect("localhost","root","tumko34h1se","worxdialer");

      $callerid = "SELECT cc_card.username as username FROM `cc_card` left join cc_callerid ON cc_card.id=cc_callerid.id_cc_card where cid='".$_SERVER['argv'][2]."'";
       $result_cid = mysqli_query($conn_san, $callerid);

        while($rows = mysqli_fetch_assoc($result_cid))
                                {
                                $result_cid = $rows["username"];

                                }

        $agi->verbose("Searching for CID ..  $result_cid \n");




        $lock_pin=$_SERVER['argv'][1];
       // $useralias=$_SERVER['argv'][2];
        $useralias=$result_cid;
        $permission=$_SERVER['argv'][3];

	

        $connection = mysql_connect("localhost","root","tumko34h1se");
        mysql_select_db("worxdialer",$connection);
		
	$Query = "select id,useralias,id_group,".$permission." from cc_card where useralias = '".$useralias."'";
        $rsQuery = mysql_query($Query);
        $result = mysql_fetch_array($rsQuery);
		
		$agi -> Noop($Query);
		if ($result['useralias']!="") {
		if ($result['id_group']=="1" and $result[$permission]=="1") {
		 //pinless agi2
		$agi -> set_variable("continue","1");
		

        	}
		elseif ($result['id_group']==="0" and $result[$permission]=="1") {
                        //pinless agi2 
	        $agi -> set_variable("continue","1");
		

                }
		elseif ($result['useralias']!=$useralias and $result['id_group']=="1") {
                        //Pinbase agi3 
                
        $agi -> set_variable("continue","2");
		
                }

                elseif ($result[$permission]=="0") {
				//Pinbase agi3
				
		$agi -> set_variable("continue","2");
		

                }
        }
		
		else{
                //pin incorrect
			$agi->verbose("Searching for CID hr round  ..  $result_cid \n");
                $agi -> set_variable("continue","3");



        }
