<?php require_once('connection.php');
$res = array();
if(!isset($_SESSION['login_user_id'])){
	$res = array('status'=>'false', 'message'=> 'Session has been expird!');
}
$user_id = $_POST['user_id'];

$sql = "SELECT credit FROM cc_card WHERE id = '".$user_id."'";
$result = mysqli_query($connection,$sql);
if(mysqli_num_rows($result)){
	$row = mysqli_fetch_assoc($result);
	$credit = $row['credit'];
	//echo $credit;
	$res = array('status'=>'true', 'value'=>$credit, 'message'=> 'Current Balance');
}
echo json_encode($res);
?>