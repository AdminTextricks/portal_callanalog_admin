<?php require_once('connection.php');

$q = intval($_GET['q']);
$user_id = intval($_GET['user_id']);
if ($q == 1) {
	$query_queue = "select * from cc_queue_table where assigned_user='" . $user_id . "'";
	$result_queue = mysqli_query($connection, $query_queue);
	echo '<select name="destination_no[]" class="form-control destination_no" required>';
	echo '<option value="">Select</option>';
	while ($row_sip = mysqli_fetch_array($result_queue)) {
		echo '<option value=' . $row_sip["name"] . '>' . $row_sip["name"] . '</option>';
	}
	echo '</select>';

} elseif ($q == 2) {
	$query_ext = "select * from cc_sip_buddies where id_cc_card='" . $user_id . "'";
	$result_ext = mysqli_query($connection, $query_ext);
	echo '<select name="destination_no[]" class="form-control destination_no" required>';
	echo '<option value="">Select</option>';
	while ($row_ext = mysqli_fetch_array($result_ext)) {
		echo '<option value=' . $row_ext["name"] . '>' . $row_ext["name"] . '</option>';
	}
	echo '</select>';

} elseif ($q == 3) {
	$query_vm = "select * from cc_voicemail_users where customer_id='" . $user_id . "'";
	$result_vm = mysqli_query($connection, $query_vm);
	echo '<select name="destination_no[]" class="form-control destination_no" required>';
	echo '<option value="">Select</option>';
	while ($row_ext = mysqli_fetch_array($result_vm)) {
		echo '<option value=' . $row_ext["mailbox"] . '>' . $row_ext["mailbox"] . '</option>';
	}
	echo '</select>';

} elseif ($q == 5) {
	$query_booking = "select * from booking where user_id='" . $user_id . "'";
	$result_booking = mysqli_query($connection, $query_booking);
	echo '<select name="destination_no[]" class="form-control destination_no" required>';
	echo '<option value="">Select</option>';
	while ($row_book = mysqli_fetch_array($result_booking)) {
		echo '<option value=' . $row_book["confno"] . '>' . $row_book["confno"] . '</option>';
	}
	echo '</select>';

} elseif ($q == 6) {
	$query_ring = "select * from cc_ring_group where user_id='" . $user_id . "'";
	$result_ring = mysqli_query($connection, $query_ring);
	echo '<select name="destination_no[]" class="form-control destination_no" required>';
	echo '<option value="">Select</option>';
	while ($row_ring = mysqli_fetch_array($result_ring)) {
		echo '<option value=' . $row_ring["ringno"] . '>' . $row_ring["ringno"] . '</option>';
	}
	echo '</select>';
} elseif ($q == 8) {
	$query_ivr = "select * from ivr where user_id='" . $user_id . "'";
	$result_ivr = mysqli_query($connection, $query_ivr);
	echo '<select name="destination_no[]" class="form-control destination_no" required>';
	echo '<option value="">Select</option>';
	while ($row_ring = mysqli_fetch_array($result_ivr)) {
		echo '<option value=' . $row_ring["id"] . '>' . $row_ring["ivr_name"] . '</option>';
	}
	echo '</select>';
} else {
	echo '<input type="text" name="destination_no[]" class="form-control" value="">';
}
?>