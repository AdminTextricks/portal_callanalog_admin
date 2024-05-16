#!/usr/bin/php -q
<?php
set_time_limit(30);
require('phpagi.php');
error_reporting(E_ALL);

$con=mysqli_connect("localhost","root","cce55c5c21","bigdialer");

if (mysqli_connect_errno())
  {

  $agi->verbose("Connection Failed!!");

 }
 else
 {
        $agi = new AGI();
        $id = $argv[1];
        $agi->verbose("CLID is : $id");
        if(isset($id) && trim($id) != '')
        {
                        $id = substr($id,2);
                        $query = ("select blackListnum from rejectListnum where visiter_id like '%$id'");
                        $result = mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result))
                        {
                                $blID = "$row[blackListnum]";
                                if($blID > 0)
                                {
                                        $agi->set_variable("WhiteList", "false");
                                }

                        }
                        $rowcount=mysqli_num_rows($result);
                        if($rowcount == 0)
                        {
                                $agi->set_variable("WhiteList", "true");
                        }
                        $agi->verbose("rowcount is : $rowcount");
        }
 }
 ?>

