<?php require_once('connection.php');
require_once('functions.php');

if (isset($_GET['id'])) {
    /* $select_query = "SELECT `group_name` FROM `ratecard_group` WHERE `id`='" . $_GET['id'] . "'";
    $result = mysqli_query($connection, $select_query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $group_name = $row['group_name'];
    } */
    $sql = "delete from add_rate where id='" . $_GET['id'] . "'";
    $result_deletequeue = mysqli_query($connection, $sql);

    if ($result_deletequeue) {
        $activity_type = 'Rate Deleted';
        $message ='Rate Deleted Succesfully! By Admin';
        user_activity_log($_SESSION['login_user_id'], $_SESSION['userroleforclientid'], $activity_type, $message);

        $_SESSION['msg'] = 'Rate Delete Successfully !!....';
        header('Location: rate.php');
    } else {
        header('Location: rate.php');
    }
}


?>