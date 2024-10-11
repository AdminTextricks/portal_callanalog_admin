<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{

    $select_query = "SELECT `did`,`iduser`,`clientId`,`did_provider`,`startingdate`,`expirationdate` FROM `cc_did` WHERE id='".$_GET['id']."'";
    $result_query = mysqli_query($connection, $select_query);
    if(mysqli_num_rows($result_query)>0){
        $row = mysqli_fetch_assoc($result_query);
        $did_number = $row['did'];
        $user_id = $row['iduser'];
        $client_id = $row['clientId'];
        $did_provider = $row['did_provider'];
        $startingdate = $row['startingdate'];
        $expirationdate = $row['expirationdate'];

    }
     $sql = "delete from `cc_did` where id='".$_GET['id']."'";
     $result_deletering = mysqli_query($connection , $sql);

     if ($result_deletering) {
        $deleted_date = date("Y-m-d h:i:s");
        $deleted_did = "INSERT INTO `cc_did_use`(`id_cc_card`,`did`,`did_provider`,`reservationdate`,`expirationdate`,`deleted_date`)VALUES('".$user_id."','".$did."','".$did_provider."','".$startingdate."','".$expirationdate."','".$deleted_date."')";
        $result_delete = mysqli_query($connection , $deleted_did) or die("deleted_did query failed");
            $activity_type = 'DID Delete';
            if($_SESSION['userroleforpage']=='1'){
                $message = ' TFN No: '.$did_number.' '.' Delete From List By Admin';
            }
            
			user_activity_log($user_id,$client_id,$activity_type, $message);

        $_SESSION['msg'] = 'TFN Number Delete Successfully !!....';
        header('Location: did.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: did.php');
    }
}


?> 
 