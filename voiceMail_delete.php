<?php require_once('connection.php');
require_once('functions.php');

if(isset($_GET['id']))
{
      $select_query = "SELECT `customer_id`,`clientId`,`mailbox` FROM `cc_voicemail_users` WHERE `uniqueid`='".$_GET['id']."'";
      // echo $select_query; exit;
      $result = mysqli_query($connection, $select_query);
      if(mysqli_num_rows($result)>0){
         $row = mysqli_fetch_assoc($result);
        
         $user_id = $row['customer_id'];
         $clientId = $row['clientId'];
         $mailbox = $row['mailbox'];
      }
      // echo '<pre>'; print_r($row); exit;
     $sql = "delete from cc_voicemail_users where uniqueid='".$_GET['id']."'";
     $result_deletevoicemail = mysqli_query($connection , $sql);

     if ($result_deletevoicemail) {
      $activity_type = 'Voice Mail Deleted';
        if($_SESSION['userroleforpage']=='1'){
            $message = 'Mail Box No: '.$mailbox.' '.'Voice Mail Deleted Succesfully! By Admin';
        }else{
            $message = 'Mail Box No: '.$mailbox.' '.'Voice Mail Deleted Succesfully! By User';
        }
        user_activity_log($user_id,$clientId,$activity_type, $message);

        $_SESSION['msg'] = 'Voice Mail Data Delete Successfully !!....';
        header('Location: voicemail.php');
    } else {
       header('Location: voicemail.php');
    }
}

?> 
 