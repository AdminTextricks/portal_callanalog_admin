<?php
require_once('connection.php');
$country_code = $_POST['country_code'];

echo $country_code;
    $sql = "SELECT distinct `State` FROM `state_stdcode` WHERE `countryCode` = '$country_code'";

    $result = mysqli_query($connection, $sql) or die("query failed.");

    $str = "";
        if(mysqli_num_rows($result) > 0){
            $str .= "<option value=''>Select</option>";
            while($rows = mysqli_fetch_assoc($result)){
                $str .= "<option value='{$rows['State']}'>{$rows['State']}</option>";
            }
            echo $str;
        }
    ?>