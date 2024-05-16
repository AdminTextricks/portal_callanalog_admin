<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))

{

    $details = "SELECT users_login.id,users_login.name , users_login.email, Client.clientName,Client.clientId  FROM users_login LEFT JOIN Client ON users_login.clientid = Client.clientid  WHERE `id` = '".$_GET['id']."'";
    $result_details = mysqli_query($connection , $details);
    // echo $details;exit;
    if(mysqli_num_rows($result_details)>0){
        $row = mysqli_fetch_assoc($result_details);
        $email = $row['email'];
        $name = $row['name'];
        $user_id = $row['id'];
        $clientName = $row['clientName'];
        $client_id = $row['clientId'];
    }

    //  echo '<pre>';print_r($row);exit;

     $sql = "Update users_login set status = 'Inactive', deleted = '1' where id='".$_GET['id']."'";//exit;
     $result_deletequeue = mysqli_query($connection , $sql);

     $query = "UPDATE `cc_card` SET `status` = '0' WHERE `id` = '".$_GET['id']."'";
     $result_cc = mysqli_query($connection, $query) or die("query failed");

     if ($result_deletequeue && $result_cc) {
        $activity_type = 'User Deleted';
        $message = 'User: '.$name. ' / ' .$email.' Deleted Successfully! By Admin';
        user_activity_log($user_id, $client_id, $activity_type, $message);

        $_SESSION['msg'] = 'User has been Deleted Successfully !!....';
        header('Location: users.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: users.php');
    }
}


?> 
 