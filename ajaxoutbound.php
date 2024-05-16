<?php

require('connection.php');

$query_outbound = "select did from cc_did WHERE clientId = '".$_GET['id']."%'"; 
$result_outbound = mysqli_query($connection , $query_outbound);

   $json = [];
   while($row = mysqli_fetch_array($result_outbound)){
        $json[$row['did']] = $row['did'];
   } 
   echo json_encode($json);
?>