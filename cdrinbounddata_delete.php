<?php require_once('connection.php'); 

if(isset($_GET['id']))
{
     $sql = "delete from cc_inbound_call where id='".$_GET['id']."'";
     $result_deletequeue = mysqli_query($connection , $sql);

     if ($result_deletequeue) {

        $_SESSION['msg'] = 'Inbound Call Data Delete Successfully !!....';
        header('Location: cdrlist.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: cdrlist.php');
    }
}


?> 
 