<?php 
include 'connection.php';
$sql = "select price,type from cc_did_exten_price where user_id = '0'";
$res = mysqli_query($connection, $sql) or die("query failed : sql");
$price = array();
while($row = mysqli_fetch_assoc($res)){
    $price[$row['type']] = $row['price'];
}

echo json_encode($price);
?>