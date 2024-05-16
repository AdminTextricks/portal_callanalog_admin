<?php require_once('connection.php'); 

$query_queuedelete = "delete from cc_queue_member_table where uniqueid='".$_GET['id']."'";
$result_deletequeue = mysqli_query($connection , $query_queuedelete);
		
header('Location: queuemanage.php?id='.$_GET['queueid'].'&uid='.$_GET['uid']);

?> 
 