<?php require_once('connection.php'); 

if(isset($_GET['id']))
{
    // echo "<pre>";print_r($_GET['id']);die;

     $sql = "delete from Client where clientId='".$_GET['id']."'";
     $result_deletequeue = mysqli_query($connection , $sql);

     if ($result_deletequeue) {

        $_SESSION['msg'] = 'Client Data Delete Successfully !!....';
        header('Location: client.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: client.php');
    }
}


?> 
 