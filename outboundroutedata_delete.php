<?php require_once('connection.php'); 

if(isset($_GET['id']))
{
     $sql = "delete from cc_trunk where id_trunk='".$_GET['id']."'";
     $result_deletering = mysqli_query($connection , $sql);

     if ($result_deletering) {

        $_SESSION['msg'] = 'Outboundroute Data Delete Successfully !!....';
        header('Location: outboundroute.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: outboundroute.php');
    }
}


?> 
 