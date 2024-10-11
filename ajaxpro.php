<?php

require('connection.php');

$query_user = "select * from users_login WHERE clientId = '".$_GET['id']."'  and status = 'Active' and deleted = '0'"; 
$result_user_login = mysqli_query($connection , $query_user);

   $json = [];
   while($row = mysqli_fetch_array($result_user_login)){
        $json[$row['id']] = $row['name'].' / '.$row['email'];
   }
   echo json_encode($json);
?>