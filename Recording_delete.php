<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{

    $select_query = "SELECT * FROM `music` WHERE id='".$_GET['id']."'";
    $result_query = mysqli_query($connection, $select_query);
    if(mysqli_num_rows($result_query)>0){
        $row = mysqli_fetch_assoc($result_query);
        $upload_music = $row['upload_music'];
        $user_id = $row['user_id'];
        $client_id = $row['clientId'];
    }
     $sql = "delete from music where id='".$_GET['id']."'";
     $result_deletering = mysqli_query($connection , $sql);

     if ($result_deletering) {
        $folder = "./assets/audio/".$_POST['selectedUser']."_".$upload_music;

        unlink( $folder);
            $activity_type = 'Recording Deleted';
            if($_SESSION['userroleforpage']=='1'){
                $activity_type = 'Recording Deleted By Admin';
                $message = 'Recording: '.$upload_music.' '.'Recording Deleted Succesfully! By Admin';
            }else{
                $activity_type = 'Recording Deleted By User';
                $message = 'Recording: '.$upload_music.' '.'Recording Deleted Succesfully! By User';
            }
			user_activity_log($user_id,$client_id,$activity_type, $message);

        $_SESSION['msg'] = 'Recording Data Delete Successfully !!....';
        header('Location: recording.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: recording.php');
    }
}


?> 
 