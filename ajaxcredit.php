<?php require_once('connection.php'); 

$q = intval($_GET['q']);


$user_login = "select id from users_login where clientId = '".$q."'";
$res_login = mysqli_query($connection, $user_login) or die("query failed");
if(mysqli_num_rows($res_login) > 0){
	$row = mysqli_fetch_assoc($res_login);
	$user_id = $row['id'];
}

$query_user = "select credit from cc_card where id='".$user_id."'";
$result_user = mysqli_query($connection , $query_user);

if(mysqli_num_rows($result_user) > 0)
{
	$rowscredit = mysqli_fetch_assoc($result_user);
	 
	 if($rowscredit['credit'] > 10){
		$credit = $rowscredit['credit'];
	 }else{
		$credit = "Not Enough Credit";
	 }
}else{
	$credit = '0.0';
}
echo $credit;
?>