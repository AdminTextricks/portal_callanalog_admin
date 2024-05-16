<?php

require('connection.php');

$query_did = "select * from cc_did WHERE call_destination = '".$_GET['id']."'"; 
$result_did = mysqli_query($connection , $query_did);

   $json = [];
   while($row = mysqli_fetch_array($result_did)){
	
        $json[$row['did']] = $row['did'];
   }
   echo json_encode($json);
?>