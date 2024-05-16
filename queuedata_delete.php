<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{
    $select_query = "SELECT * FROM `cc_queue_table` WHERE `id`='".$_GET['id']."'";
    $result = mysqli_query($connection, $select_query);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        $queueno = $row['name'];
        $user_id = $row['assigned_user'];
        $clientId = $row['clientId'];
    }
     $sql = "delete from cc_queue_table where id='".$_GET['id']."'";
     $sql2 = "delete from cc_queue_member_table where queue_id='".$_GET['id']."'";
     $result_deletequeue = mysqli_query($connection , $sql);
     $result_deletequeue = mysqli_query($connection , $sql2);

     if ($result_deletequeue) {
        $activity_type = 'Queue Deleted';
        if($_SESSION['userroleforpage']=='1'){
            $message = 'Queue No: '.$queueno.' '.'Queue Deleted Succesfully! By Admin';
        }else{
            $message = 'Queue No: '.$queueno.' '.'Queue Deleted Succesfully! By User';
        }
        user_activity_log($user_id,$clientId,$activity_type, $message);

        $_SESSION['msg'] = 'Queue Data Delete Successfully !!....';
        header('Location: queue.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: queue.php');
    }
}


?> 
 