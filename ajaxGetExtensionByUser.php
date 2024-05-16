<?php

require('connection.php');

//echo '<pre>'; print_r($_GET); echo '</pre>';//exit;
$query_ex = "SELECT id, `name` FROM `cc_sip_buddies` WHERE clientId = '".$_GET['id']."' and id_cc_card = '".$_GET['selectedUser']."'"; 
$result_extension = mysqli_query($connection , $query_ex);

   $json = [];
   while($row = mysqli_fetch_array($result_extension)){
        $json[$row['name']] = $row['name'];
   }
   echo json_encode($json);
?>