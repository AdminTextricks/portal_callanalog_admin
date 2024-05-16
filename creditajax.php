<?php require_once('connection.php'); 

$q = intval($_GET['q']);

$query_user = "select credit from cc_card where id='".$q."'";
$result_user = mysqli_query($connection , $query_user);

if(mysqli_num_rows($result_user))
{
	while($rowscredit = mysqli_fetch_array($result_user))
	{
	
	echo $credit = '<strong>Credit Available : </strong>'.$rowscredit['credit'];
	
	}
}else{
	echo $credit = '<strong>Credit Available : </strong>0.0';
}
?>