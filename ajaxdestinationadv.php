<?php require_once('connection.php'); 
	
$qt = intval($_GET['qv']);
$dest = intval($_GET['dest']);
$user_id = intval($_GET['user_id']);
$forwardDest = isset($_POST['forwardDest']) ? $_POST['forwardDest'] : '';
if($qt == 1 && $dest == 'destination')
{
	$query_queue = "select * from cc_queue_table where assigned_user='".$user_id."'";
	$result_queue = mysqli_query($connection , $query_queue);

	echo '<select id="forwardDest" name="forwardDest" class="form-control">';
	while($row_sip = mysqli_fetch_array($result_queue)){ 
		if($row_sip["name"] == $forwardDest  ) {
			echo '<option selected="selected" value='.$row_sip["name"].'>'.$row_sip["name"].'</option>';
		}else{
			echo '<option value='.$row_sip["name"].'>'.$row_sip["name"].'</option>';	
		}
	}
	echo '</select>';
}elseif($qt == 2 && $dest == 'destination'){
	$query_ext = "select * from cc_sip_buddies where id_cc_card='".$user_id ."'";
	$result_ext = mysqli_query($connection , $query_ext);
	echo '<select id="forwardDest" name="forwardDest" class="form-control">';
	while($row_ext = mysqli_fetch_array($result_ext)){ 
		if($row_ext["name"] == $forwardDest ) {
			echo '<option selected="selected" value='.$row_ext["name"].'>'.$row_ext["name"].'</option>';
		}else{
			echo '<option value='.$row_ext["name"].'>'.$row_ext["name"].'</option>';
		}
	}
	echo '</select>';
	}elseif($qt == 3 && $dest == 'destination'){
		$query_vm = "select * from cc_voicemail_users where customer_id='".$user_id."'";
		$result_vm = mysqli_query($connection , $query_vm);

		echo '<select id="forwardDest" name="forwardDest" class="form-control">';
		while($row_ext = mysqli_fetch_array($result_vm)){ 
			if($row_ext["mailbox"] == $forwardDest ) {
				echo '<option selected="selected" value='.$row_ext["mailbox"].'>'.$row_ext["mailbox"].'</option>';
			}else{
				echo '<option value='.$row_ext["mailbox"].'>'.$row_ext["mailbox"].'</option>';
			}
		}
		echo '</select>';
	}elseif($qt == 5 && $dest == 'destination'){
		$query_booking = "select * from booking where user_id='".$user_id."'";
		$result_booking = mysqli_query($connection , $query_booking);

		echo '<select id="forwardDest" name="forwardDest" class="form-control">';
		while($row_book = mysqli_fetch_array($result_booking)){ 
			if($row_book["confno"] == $forwardDest ) {
				echo '<option selected="selected" value='.$row_book["confno"].'>'.$row_book["confno"].'</option>';
			}else{
				echo '<option value='.$row_book["confno"].'>'.$row_book["confno"].'</option>';
			}
		}
		echo '</select>';
	}elseif($qt == 6 && $dest == 'destination'){
		$query_ring = "select * from cc_ring_group where user_id='".$user_id."'";
		$result_ring = mysqli_query($connection , $query_ring);

		echo '<select id="forwardDest" name="forwardDest" class="form-control">';
		while($row_ring = mysqli_fetch_array($result_ring)){ 
			if($row_ring["ringno"] == $forwardDest ) {
				echo '<option selected="selected" value='.$row_ring["ringno"].'>'.$row_ring["ringno"].'</option>';
			}else{
				echo '<option value='.$row_ring["ringno"].'>'.$row_ring["ringno"].'</option>';
			}
		}
		echo '</select>';
	}elseif($qt == 8 && $dest == 'destination'){
		$query_ring = "select * from ivr where user_id='".$user_id."'";
		$result_ring = mysqli_query($connection , $query_ring);

		echo '<select id="forwardDest" name="forwardDest" class="form-control">';
		while($row_ring = mysqli_fetch_array($result_ring)){ 
			if($row_ring["id"] == $forwardDest ) {
				echo '<option selected="selected" value='.$row_ring["id"].'>'.$row_ring["ivr_name"].'</option>';
			}else{
				echo '<option value='.$row_ring["id"].'>'.$row_ring["ivr_name"].'</option>';
			}
		}
		echo '</select>';
	}else{
		echo '<input type="text" id="forwardDest" name="forwardDest" class="form-control" value="'.$forwardDest.'">';
	}				
?>