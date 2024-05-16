<?php require_once('connection.php'); 

$q = intval($_GET['q']);
$user_id = intval($_GET['user_id']);
$user_name_query = "select * from users_login where id='".$user_id."'";
$res_name_qry1 = mysqli_query($connection, $user_name_query);
$res_name_qry= mysqli_fetch_assoc($res_name_qry1);
$res_get_name_qry= $res_name_qry['name'];
if($q == 1)
{
	$query_queue = "select * from cc_queue_table where assigned_user='".$user_id."'";
	$result_queue = mysqli_query($connection , $query_queue);

	echo '<select id="destination" name="destination" class="form-control">';
	while($row_sip = mysqli_fetch_array($result_queue)){ 
		echo '<option value='.$row_sip["name"].'>&nbsp;&nbsp;Queue Name: '.$row_sip["queue_name"].'  &nbsp;&nbsp;Queue Number: '.$row_sip["name"].' </option>';
	}
	echo '</select>';
	}elseif($q == 2){
		$query_ext = "select * from cc_sip_buddies where id_cc_card='".$user_id ."'";
				$result_ext = mysqli_query($connection , $query_ext);
                // $select_intercom = "select * from "
				echo '<select id="destination" name="destination" class="form-control">';
				while($row_ext = mysqli_fetch_array($result_ext)){ 
				echo '<option value='.$row_ext["name"].'>&nbsp;&nbsp;Agent Name: '.$row_ext["agent_name"].' &nbsp;&nbsp;Extension No: '.$row_ext["name"].'  &nbsp;&nbsp;Intercom No: '.$row_ext["lead_operator"].'</option>';
				}
				echo '</select>';
	}elseif($q == 3){
		$query_vm = "select * from cc_voicemail_users where customer_id='".$user_id."'";
				$result_vm = mysqli_query($connection , $query_vm);

				echo '<select id="destination" name="destination" class="form-control">';
				while($row_ext = mysqli_fetch_array($result_vm)){ 
				echo '<option value='.$row_ext["mailbox"].'>&nbsp;&nbsp;Voicemail Fullname: '.$row_ext["fullname"].' &nbsp;&nbsp;Voicemail Fullname: '.$row_ext["mailbox"].'</option>';
				}
				echo '</select>';
	}elseif($q == 5 ){
		$query_booking = "select * from booking where user_id='".$user_id."'";
		$result_booking = mysqli_query($connection , $query_booking);

		echo '<select id="destination" name="destination" class="form-control">';
		while($row_book = mysqli_fetch_array($result_booking)){ 			
			echo '<option value='.$row_book["confno"].'> &nbsp;&nbsp;Conference Name: '.$row_book["confDesc"].' &nbsp;&nbsp;Conference Number: '.$row_book["confno"].' </option>';			
		}
		echo '</select>';
	}elseif($q == 6 ){
		$query_ring = "select * from cc_ring_group where user_id='".$user_id."'";
		$result_ring = mysqli_query($connection , $query_ring);

		echo '<select id="destination" name="destination" class="form-control">';
		while($row_ring = mysqli_fetch_array($result_ring)){ 			
			echo '<option value='.$row_ring["ringno"].'>&nbsp;&nbsp;Ring Group Name: '.$row_ring["description"].'&nbsp;&nbsp;Ring Group Number: '.$row_ring["ringno"].' </option>';			
		}
		echo '</select>';
	}elseif($q == 8){
		$query_ivr = "select * from ivr where user_id='".$user_id."'";
		$result_ivr = mysqli_query($connection , $query_ivr);

		echo '<select id="destination" name="destination" class="form-control">';
		while($row_ring = mysqli_fetch_array($result_ivr)){ 			
			echo '<option value='.$row_ring["id"].'>&nbsp;&nbsp;IVR Name: '.$row_ring["ivr_name"].' </option>';			
		}
		echo '</select>';
	}elseif($q == 7){
		echo '<input type="text" id="destination" placeholder="10.10.10.1:5060" name="destination" class="form-control" value="">';
	}else{
		echo '<input type="text" id="destination" placeholder="Enter 10 Digit Number with country code eg:-[+1 (234) ***-****]" name="destination" class="form-control" value="">';
	}				
?>