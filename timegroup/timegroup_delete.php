<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{
     $sql = "delete from cc_time_group where id='".$_GET['id']."'";
     $result_delete = mysqli_query($connection , $sql);

     if ($result_delete) {
   
        $_SESSION['msg'] = 'Time Group Data Delete Successfully !!....';
        header('Location: timegroup.php');
    } else {
        header('Location: timegroup.php');
    }
}
?> 
 