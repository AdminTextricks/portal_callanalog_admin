#!/usr/bin/php -q
<?php

require'phpagi/phpagi.php';


$agi = new AGI();
$agentno = $argv[1];
//db connection here
$dbhost="localhost";
$dbuser="root";
$dbpass="GFDUedThsS";
$dbname="bigdialer";
//

$conn = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname");
if ($agentno == "agent_number"){
//$query = ("SELECT queue_name from queue_table WHERE QueueID='1';");
$query = ("SELECT ext_name from queue_member_table");

if($result = mysqli_query($conn,$query)){
while($row = mysqli_fetch_row($result)){
$qnumber[] = $row[0];
  }

  }
$agi->verbose($qnumber[0]);

$agi->set_variable('agent_num', $qnumber[0]);

}

