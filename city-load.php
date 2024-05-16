<?php
require_once('connection.php');
$state = $_POST['state_code'];

    $sql = "SELECT `City` FROM `state_stdcode` WHERE `State` = '$state'";

    $result = mysqli_query($connection, $sql) or die("query failed.");

    $str = "";
    if(mysqli_num_rows($result) > 0){
        while($rows = mysqli_fetch_assoc($result)){
            $str .= "<option value='{$rows['City']}'>{$rows['City']}</option>";
        }
        echo $str;
    }
?>