<?php 
include 'connection.php';
include 'functions.php';

$response = array();

$password = $_POST['password'];
$cpassword = $_POST['cPassword'];
if($password == $cpassword){
    $user_id = $_POST['userId'];
    $select_users_login = "SELECT `clientId`,`name` FROM `users_login` WHERE `id`='" . $user_id . "'";
    $result_users_login = mysqli_query($connection, $select_users_login) or die("query failed");
    if (mysqli_num_rows($result_users_login) > 0) {
        $rowss = mysqli_fetch_assoc($result_users_login);
        $clientId = $rowss['clientId'];
        $clientName = $rowss['name'];
    }
    $password = md5($password);
    $query1 = "UPDATE `users_login` SET `password` = '" . $password . "'  WHERE `id`='" . $user_id . "'";
    mysqli_query($connection, $query1) or die("query failed");
    $query2 = "UPDATE `cc_card`  SET `uipass` = '" . $password . "' WHERE `id`='" . $user_id . "'";
    mysqli_query($connection, $query2) or die("query failed");
    $query3 = "UPDATE `Client` SET `clientEmailPass` = '" . $password . "' ,`loginPass` ='" . $password . "' WHERE `clientid` = '" . $clientId . "'";
    mysqli_query($connection, $query3) or die("query failed");
    $response['error'] = false;
    $response['message'] = "Password Changed Successfully for User ".$clientName;
}else{
    $response['error'] = true;
    $response['message'] = "Password and Confirm Password Not matched..!!";
}

echo json_encode($response);
?>