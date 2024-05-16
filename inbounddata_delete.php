<?php require_once('connection.php'); 
require_once('functions.php');
if(isset($_GET['id']))
{
    $query = "SELECT `iduser`,`clientId`,`did`,`did_provider`,`startingdate`,`expirationdate` FROM `cc_did` WHERE `id` ='".$_GET['id']."'";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['iduser'];
        $client_id = $row['clientId'];
        $did = $row['did'];
        $did_provider = $row['did_provider'];
        $startingdate = $row['startingdate'];
        $expirationdate = $row['expirationdate'];
    }
    $deleted_date = date("Y-m-d h:i:s");
    $activity_type = 'DID Delete';
    if($_SESSION['userroleforpage']=='1'){
        $msg = 'DID No: '.$did.' '.'DID Deleted Succesfully! By Admin';
    }else{
        $msg = 'DID No: '.$did.' '.'DID Deleted Succesfully! By User';
    }
	user_activity_log($user_id,$client_id, $activity_type, $msg);
			

     $sql = "delete from cc_did where id='".$_GET['id']."'";
    //  echo "<pre>";print_r($sql);die;
     $result_cc_did_destination = mysqli_query($connection , $sql);
     if ($result_cc_did_destination) {

        $deleted_did = "INSERT INTO `cc_did_use`(`id_cc_card`,`did`,`did_provider`,`reservationdate`,`expirationdate`,`deleted_date`)VALUES('".$user_id."','".$did."','".$did_provider."','".$startingdate."','".$expirationdate."','".$deleted_date."')";
        $result_delete = mysqli_query($connection , $deleted_did) or die("deleted_did query failed");

        $_SESSION['msg'] = 'Inbound destination Data Delete Successfully !!....';
        header('Location: inbound.php');
         

    } else {
        header('Location: inbound.php');
    }
}


?> 
 