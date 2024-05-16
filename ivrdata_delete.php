<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{
    // $select_query = "SELECT `name`,`user_id`,`clientId` FROM `cc_sip_buddies` WHERE `id`='".$_GET['id']."'";
    // $result = mysqli_query($connection, $select_query);
    // if(mysqli_num_rows($result)>0){
    //     $row = mysqli_fetch_assoc($result);
    //     $extname = $row['name'];
    //     $user_id = $row['user_id'];
    //     $clientId = $row['clientId'];
    // }
     $sql = "delete from ivr where id='".$_GET['id']."'";
     $result_deletequeue = mysqli_query($connection , $sql);
    $query = "delete from ivr_option where ivr_id='".$_GET['id']."'";
    $result_del_option = mysqli_query($connection, $query);
     if ($result_deletequeue && $result_del_option) {
        // $activity_type = 'Extension Deleted';
        // if($_SESSION['userroleforpage']=='1'){
        //     $message = 'Extension No: '. $extname.'Extension Deleted Succesfully! By Admin';
        // }else{
        //     $message = 'Extension No: '. $extname.'Extension Deleted Succesfully! By User';
        // }
        // user_activity_log($user_id,$clientId,$activity_type, $message);

        $_SESSION['msg'] = 'IVR Data Delete Successfully !!....';
        header('Location: ivr.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: ivr.php');
    }
}


?> 
 