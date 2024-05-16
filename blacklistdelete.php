<?php require_once('connection.php'); 
 require_once('functions.php');
if(isset($_GET['id']))
{
	$select_query = "SELECT * FROM `cc_blacklist` WHERE id='".$_GET['id']."'";
    $result_query = mysqli_query($connection, $select_query);
    if(mysqli_num_rows($result_query)>0){
        $row = mysqli_fetch_assoc($result_query);
        $callerId = $row['caller_id'];
        $user_id = $row['user_id'];
        $client_id = $row['clientId'];
    }
$delete_blacklist = "delete from cc_blacklist where id='".$_GET['id']."'";	
$result_blacklist = mysqli_query($con,$delete_blacklist);
if($result_blacklist){
	$activity_type = 'Caller ID Deleted';
    if($_SESSION['userroleforpage']=='1'){
        $message = 'Caller ID: '.$callerId.' '.'Caller ID Deleted Succesfully! By Admin';
    }else{
		$message = 'Caller ID: '.$callerId.' '.'Caller ID Deleted Succesfully! By User';
    }
    
	user_activity_log($user_id,$client_id,$activity_type, $message);
    if($result_blacklist){
        $_SESSION['msg'] = "Block Number Deleted Successfully";
        header('Location: blacklist.php');
    }else{
        header('Location: blacklist.php');
    }

	
}			
}

?>