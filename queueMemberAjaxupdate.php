<?php require_once('connection.php'); 


if (isset($_POST["uniqueid"])) {
   
    $query  = "UPDATE `cc_queue_member_table` SET `penalty`='".$_POST['penalty']."' WHERE uniqueid = '".$_POST["uniqueid"]."'";
    $result = mysqli_query($connection, $query);
    if($result){
    echo 'Data Updated'; 
    }else{
        echo 'Failed to  Updated'; 
    }
}
?>