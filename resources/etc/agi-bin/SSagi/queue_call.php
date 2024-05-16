#!/usr/bin/php -q
<?php

require'phpagi/phpagi.php';


$agi = new AGI();
$queue = $argv[1];
//db connection here
$dbhost="localhost";
$dbuser="root";
$dbpass="GFDUedThsS";
$dbname="bigdialer";
//

$conn = mysqli_connect("$dbhost","$dbuser","$dbpass","$dbname");
if ($queue == "queue_number"){
//$query = ("SELECT queue_name from queue_table WHERE QueueID='1';");
$query = ("SELECT name from queue_table");

if($result = mysqli_query($conn,$query)){
while($row = mysqli_fetch_row($result)){
$qname[] = $row[0];
  }

  }
$agi->verbose($qname[0]);

$agi->set_variable('queue_num', $qname[0]);

}

