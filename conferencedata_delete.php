<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{
    $select_query = "SELECT `user_id`,`clientId`,`confno` FROM `booking` WHERE `id`='".$_GET['id']."'";
    $result = mysqli_query($connection, $select_query);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];
        $clientId = $row['clientId'];
        $confno = $row['confno'];
    }
     $sql = "delete from booking where id='".$_GET['id']."'";
     $result_deletequeue = mysqli_query($connection , $sql);

     if ($result_deletequeue) {
        $activity_type = 'Conference Deleted';
        if($_SESSION['userroleforpage']=='1'){
            $message = 'Conference No: '.$confno.' '.'Conference Deleted Succesfully! By Admin';
        }else{
            $message = 'Conference No: '.$confno.' '.'Conference Deleted Succesfully! By User';
        }
        user_activity_log($user_id,$clientId,$activity_type, $message);

        $_SESSION['msg'] = 'Conference Data Delete Successfully !!....';
        header('Location: conference.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: conference.php');
    }
}


?> 
 