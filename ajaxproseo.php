<?php

require('connection.php');

$query_user = "select * from seo_members WHERE tl_id LIKE '".$_GET['id']."%'"; 
$result_user_login = mysqli_query($connection , $query_user);

   $json = [];
   while($row = mysqli_fetch_array($result_user_login)){
        $json[$row['id']] = $row['member_name'];
   }
   echo json_encode($json);
?>