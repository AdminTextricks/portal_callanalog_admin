<?php

require('connection.php');

$query_outbound = "SELECT `id`,`upload_music`, `name` FROM `music` WHERE clientId = '" . $_GET['id'] . "%'";
$result_outbound = mysqli_query($connection, $query_outbound);

$json = [];
while ($row = mysqli_fetch_array($result_outbound)) {
   $json[$row['id']] = $row['name'];
}
echo json_encode($json);
?>