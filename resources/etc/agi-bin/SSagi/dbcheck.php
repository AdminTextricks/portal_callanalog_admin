#!/usr/bin/php -q
<?php
$con=mysqli_connect("localhost","root","cce55c5c21","mya2billing");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

else
$query = ("select paused from queue_member_table where membername= 369");
$result = mysqli_query($con,$query);
//print "$result";
//while($row = mysql_fetch_array($result))
while($row = mysqli_fetch_array($result))
$pstatus = "$row[paused]";
{
if ($pstatus == 1 || $pstatus == 0) {
	if ($pstatus == 1) {
		echo "it is 1, turning it to 0 ";
		$query = ("UPDATE `mya2billing`.`queue_member_table` SET `paused` = '0' WHERE `queue_member_table`.`membername` = 369");
		$result = mysqli_query($con,$query);

	} else {
		echo "it is 0, turning it to 1";
		$query = ("UPDATE `mya2billing`.`queue_member_table` SET `paused` = '1' WHERE `queue_member_table`.`membername` = 369");
		$result = mysqli_query($con,$query);
	}
	
} else {
	echo "it is nor 0 niether 1, doing nothing.";
}

}

mysqli_close($con);
?>
