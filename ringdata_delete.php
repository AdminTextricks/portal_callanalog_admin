<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{

    $select_query = "SELECT * FROM `cc_ring_group` WHERE id='".$_GET['id']."'";
    $result_query = mysqli_query($connection, $select_query);
    if(mysqli_num_rows($result_query)>0){
        $row = mysqli_fetch_assoc($result_query);
        $ringno = $row['ringno'];
        $user_id = $row['user_id'];
        $client_id = $row['clientId'];
    }
     $sql = "delete from cc_ring_group where id='".$_GET['id']."'";
     $result_deletering = mysqli_query($connection , $sql);

     if ($result_deletering) {
            $activity_type = 'Ring Deleted';
            if($_SESSION['userroleforpage']=='1'){
                $message = 'Ring No: '.$ringno.' '.'Ring Deleted Succesfully! By Admin';
            }else{
                $message = 'Ring No: '.$ringno.' '.'Ring Deleted Succesfully! By User';
            }
			user_activity_log($user_id,$client_id,$activity_type, $message);

        $_SESSION['msg'] = 'Ring Group Data Delete Successfully !!....';
        header('Location: ring.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: ring.php');
    }
}


?> 
 