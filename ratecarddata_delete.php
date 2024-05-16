<?php require_once('connection.php');
require_once('functions.php');

if (isset($_GET['id'])) {
    $select_query = "SELECT `group_name` FROM `ratecard_group` WHERE `id`='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $group_name = $row['group_name'];
    }
    $sql = "delete from ratecard_group where id='" . $_GET['id'] . "'";
    $result_deletequeue = mysqli_query($connection, $sql);

    if ($result_deletequeue) {
        $activity_type = 'Rate Card Group Deleted';
        $message = 'Rate Card Group : ' . $group_name . ' ' . 'Rate Card Group Deleted Succesfully! By Admin';
        user_activity_log($_SESSION['login_user_id'], $_SESSION['userroleforclientid'], $activity_type, $message);

        $_SESSION['msg'] = 'Rate Card Group Data Delete Successfully !!....';
        header('Location: ratecard.php');
    } else {
        header('Location: ratecard.php');
    }
}


?>