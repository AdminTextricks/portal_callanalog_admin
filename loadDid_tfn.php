<?php
include 'connection.php';

$digit = $_POST['digit'];
$user_id = $_POST['user_id'];

$user_sql = "select did_permission from users_login where id='" . $user_id . "'";
$user_res = mysqli_query($connection, $user_sql) or die("query failed : user_sql");
if (mysqli_num_rows($user_res) > 0) {
    $row = mysqli_fetch_assoc($user_res);
    $did_permission = str_replace(",", "','", $row['did_permission']);
}


$sql = "SELECT id, did FROM `cc_did` where did like '%$digit%' and iduser='0' and activated='1' and reserved='0' and clientid='0' and did_provider IN ('" . $did_permission . "') and id NOT IN(select id_cc_did from cc_did_destination)";

$result = mysqli_query($connection, $sql) or die("query failed");

$str = '';
if(mysqli_num_rows($result)){
    $str .= "<option value=''>Select</option>";
    while($row = mysqli_fetch_assoc($result)){
        $str .= "<option value='{$row['id']}'>{$row['did']}</option>";
    }
    echo $str;
}else{
echo "<option>No number found</option>";
}

?>
