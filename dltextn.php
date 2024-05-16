<?php
/*
 * This class can be used to retrieve messages from an IMAP, POP3 and NNTP server
 * @author Mohd Maroof Ali
 Email->'maroofali551@gmail.com'
 
 */
  ?>
  <?php

include '../common/admincon.php';

if (isset($_GET['exdlt'])) {
$exdel_id=$_GET['exdlt'];
	$query = "delete from extension WHERE id='$exdel_id'";
	
	$run_query=mysqli_query($adb,$query);

	if ($run_query) {
		
		echo "<script>alert('Extension Has Been deleted!')</script>";
		//exit();
		echo "<script>window.open('index.php?exten','_self')</script>";

			}

 }


?>