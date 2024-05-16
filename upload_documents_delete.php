<?php require_once('connection.php'); 

if(isset($_GET['id']))
{
     $sql = "delete from upload_documents where id='".$_GET['id']."'";
     $result_deletering = mysqli_query($connection , $sql);

     if ($result_deletering) {

        $_SESSION['msg'] = 'Upload Document Data Delete Successfully !!....';
        header('Location: upload_documents_list.php');
         // $_SESSION['message'] = count($_GET['id']) . " submission deleted.";
        // header('Location: queue.php?status=success');

    } else {
        header('Location: upload_documents_list.php');
    }
}


?> 
 