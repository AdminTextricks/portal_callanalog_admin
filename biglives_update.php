<?php 

require_once('connection.php'); 
// extract($_POST);
// echo '<br>';
// print_r($_POST);
 

if(isset($_POST["agentPause"]))
{
$uniqueid = substr($_POST["agentPause"],1);
$pausedid = substr($_POST["agentPause"],0,1);

// echo $output = substr($input, 0, 1);
// echo '<br>';
// echo $output2 = substr($input,1);

if($pausedid == 0)
{
	$status = 1;
}else{
	$status = 0;
}

$query="update cc_queue_member_table SET paused='".$status."' where uniqueid='".$uniqueid."'";

$result_query = mysqli_query($con,$query);

	// if($result_query)

	// {

	// header('location:biglives.php');

	// }

}

?>