<?php require_once('connection.php'); 
require_once('functions.php');

if(isset($_GET['id']))
{

    $query = "SELECT `ivr_file` FROM `cc_time_group` WHERE id = '".$_GET['id']."'";
    $result = mysqli_query($connection, $query) or die("query failed : query");
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $ivr_file = $row['ivr_file'];
    }

     $sql = "delete from cc_time_group where id='".$_GET['id']."'";
     $result_delete = mysqli_query($connection , $sql);

     unlink("timegroup/".$ivr_file);

     if ($result_delete) {
   
        $_SESSION['msg'] = 'Time Group Data Delete Successfully !!....';
        header('Location: timegroup.php');
    } else {
        header('Location: timegroup.php');
    }
}
?> 
 