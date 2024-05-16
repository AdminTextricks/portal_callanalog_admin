<?php require_once('connection.php'); 

if(isset($_GET['id']))
{
     $sql = "delete from server_carriers where id='".$_GET['id']."'";
     $result_deletering = mysqli_query($connection , $sql);

     if ($result_deletering) {

        $_SESSION['msg'] = 'Inboundroute Data Delete Successfully !!....';
        header('Location: inboundroute.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: inboundroute.php');
    }
}


?> 
 