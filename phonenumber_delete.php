<?php require_once('connection.php');

$query_phonedelete = "delete from cc_did where id='".$_GET['id']."'";
$result_phonequeue = mysqli_query($connection , $query_phonedelete);
		
if($result_phonequeue){		
header('Location: phonenumbers.php');
}
?> 
 
