<?php require_once ('header.php'); ?>
<?php
$error = $message = '';

$query_client = "SELECT Client.clientName,Client.clientId,Client.clientEmail FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);
$id = $_GET['id'];
$query_ring = "SELECT * FROM ivr WHERE id='" . $id . "'";

$result_ring = mysqli_query($connection, $query_ring);
if (mysqli_num_rows($result_ring) > 0) {
	$row_ring = mysqli_fetch_assoc($result_ring);
	$ivr_name = $row_ring['ivr_name'];
	$ivr_desc = $row_ring['ivr_description'];
	$ivr_announcement = $row_ring['ivr_announcement'];
	$ivr_timeout = $row_ring['ivr_timeout'];
	$ivr_status = $row_ring['ivr_status'];
	$user_uid = $row_ring['user_id'];
	$clientId = $row_ring['clientId'];
}
// echo '<pre>';print_r($row_ring);exit;

if (isset ($_POST['submit'])) {
	$message = '';
	$ivrname = $_POST['ivrname'];
	$ivr_desc = $_POST['ivr_desc'];
	$announcement = $_POST['announcement'];
	$timeout = $_POST['timeout'];
	$ivrstatus = $_POST['ivrstatus'];
	$updateat = date("Y-m-d H:i:s");
	if ($_SESSION['userroleforpage'] == '2') {
		$_POST['clientId'] = $_SESSION['userroleforclientid'];
		$_POST['selectedUser'] = $_SESSION['login_user_id'];
	}

	$ivr_update = "UPDATE `ivr` SET `ivr_name` = '" . $ivrname . "',`ivr_description` ='" . $ivr_desc . "',`ivr_announcement` = '" . $announcement . "',`ivr_timeout` = '" . $timeout . "',`updated_at`='" . $updateat . "' WHERE `id`='" . $id . "'";

	$ivr_res = mysqli_query($connection, $ivr_update) or die ("query failed : ivr_res");
	$del_option = "DELETE FROM `ivr_option` WHERE `ivr_id` = '" . $id . "'";
	$res_ivr_opt = mysqli_query($connection, $del_option) or die ("query failed : del_option");
	$createdat = date("Y-m-d H:i:s");
	for ($k = 0; $k < count($_POST['digit']); $k++) {
		// $option_id = $_POST['option_id'][$i];
		$digit = $_POST['digit'][$k];
		$dest_type = $_POST['destination_type'][$k];
		$dest_no = $_POST['destination_no'][$k];

		$insert_option = "INSERT INTO `ivr_option`(`ivr_id`,`input_digit`,`ivr_dest_type`,`ivr_dest_no`,`created_at`) VALUES('" . $id . "','" . $digit . "','" . $dest_type . "','" . $dest_no . "','" . $createdat . "')";

		$res_insert_option = mysqli_query($connection, $insert_option) or die ("query failed : insert_option");
	}
	if ($ivr_res && $res_insert_option) {
		$_SESSION['msg'] = "IVR Information Update Successfully";
		echo '<script>window.location.href="ivr.php"</script>';
	}

}
if ($_SESSION['userroleforpage'] == 2 && $user_uid !== $_SESSION['login_user_id']) { ?>
	<script>
		window.location = 'access_denied.php';    
	</script>
<?php }

$query_user = "select * from users_login where clientId='" . $clientId . "'";
$result_user_login = mysqli_query($connection, $query_user);

?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">IVR Information<span style="margin-left:50px;color:blue;">
								<?php if (isset ($_POST['submit'])) {
									echo $message;
								} ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="ivr.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-tty" aria-hidden="true"></i>IVR</button>
							</a>
						</div>
					</div>
				</div>
			</div>
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
				<div class="big_live_outer">
					<div class="row">
						<div class="col-md-12">
							<div class="queue_info">
								<?php
								if ($_SESSION['userroleforpage'] == '1') { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker" required>
												<option value="0" selected="selected">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($row['clientId'] == $clientId) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row['clientId']; ?>">
														<?php echo $row['clientName'] . '/' . $row['clientEmail']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class="form-control-label">Select User*</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="selectedUser" name="selectedUser" class="form-control" required>
												<option value="0" selected="selected">Select</option>
												<?php
												while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
													<option <?php if ($row_user['id'] == $user_uid) {
														echo 'selected';
													} ?>
														value="<?php echo $row_user['id']; ?>">
														<?php echo $row_user['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php
								} else { ?>
									<input id="clientId" name="clientId"
										value="<?php echo $_SESSION['userroleforclientid']; ?>" type="hidden">
									<input id="selectedUser" name="selectedUser"
										value="<?php echo $_SESSION['login_user_id']; ?>" type="hidden">

								<?php } ?>


								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">IVR Name</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="ivrname" name="ivrname" placeholder="IVR NAME" class="form-control"
											type="text" value="<?php echo $ivr_name; ?>" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">IVR Description</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="ivr_desc" name="ivr_desc" placeholder="IVR Description"
											class="form-control" type="text" value="<?php echo $ivr_desc; ?>" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Announcement</label>
									</div>
									<div class="col-12 col-md-8">
										<?php
										$rec_sql = "SELECT `id`,`upload_music`,`name` FROM `music` WHERE `user_id` ='" . $user_uid . "'";
										$rec_res = mysqli_query($connection, $rec_sql) or die ("query failed"); ?>
										<select name="announcement" id="announcement" class="form-control">
											<option value="">None</option>
											<?php
											if (mysqli_num_rows($rec_res) > 0) {
												while ($rec_row = mysqli_fetch_assoc($rec_res)) {
													if ($ivr_announcement == $rec_row['id']) {
														$select = "selected";
													} else {
														$select = "";
													}
													?>
													<option <?php echo $select; ?> value="<?php echo $rec_row['id']; ?>">
														<?php echo $rec_row['name']; ?>
													</option>
												<?php }
											} ?>
										</select>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Timeout</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="timeout" name="timeout" class="form-control" type="number"
											value="<?php echo $ivr_timeout; ?>" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">IVR Status</label>
									</div>
									<div class="col-12 col-md-8">
										<select name="ivrstatus" id="ivrstatus" class="form-control">
											<option value="">None</option>
											<option value="Enable" <?php if ($ivr_status == "1") {
												echo "selected";
											} ?>>
												Enable</option>
											<option value="Disable" <?php if ($ivr_status == "0") {
												echo "selected";
											} ?>>
												Disable</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<table id="queueTable" class="table manage_queue_table">
					<thead>
						<tr>
							<th>Input Digit</th>
							<th>Choose Destination Type</th>
							<th>Destination</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="dynamicadd">
						<?php
						$query_opt = "SELECT * FROM `ivr_option` WHERE `ivr_id` = '" . $id . "'";
						$result_opt = mysqli_query($connection, $query_opt) or die ("query failed : query_opt");
						if (mysqli_num_rows($result_opt) > 0) {
							$i = 1;
							while ($row_opt = mysqli_fetch_assoc($result_opt)) {

								// $option_id = $row_opt['id'];
								$input_digit = $row_opt['input_digit'];
								$ivr_dest_type = $row_opt['ivr_dest_type'];
								$ivr_dest_no = $row_opt['ivr_dest_no'];
								?>
								<tr id="row<?php echo $i; ?>" class="tr-shadow">
									<td>
										<input id="digit" name="digit[]" placeholder="Input Digit" class="form-control"
											type="number" value="<?php echo $input_digit; ?>" />
									</td>
									<td>
										<?php
										$options = '';
										$options1 = '';
										$select_destination = "SELECT * FROM `cc_selection_did`";
										$res_destination = mysqli_query($connection, $select_destination);
										if (mysqli_num_rows($res_destination) > 0) {
											while ($row = mysqli_fetch_assoc($res_destination)) {

												$options .= '<option ';
												if ($ivr_dest_type == $row['id']) {
													$options .= 'selected';
												}
												$options .= ' value="' . $row['id'] . '">' . $row['selection_value'] . '</option>';

												$options1 .= '<option value="' . $row['id'] . '">' . $row['selection_value'] . '</option>';
											}
										}
										?>
										<select id="destination_typ" rel="destination_no<?php echo $i; ?>"
											name="destination_type[]" class="form-control destination_type">
											<option value="">Select Destination Type</option>
											<?php echo $options; ?>
										</select>
									</td>
									<td>
										<div id="destination_no<?php echo $i; ?>">
											<?php if ($ivr_dest_type == 1) {
												$query_queue = "select * from cc_queue_table where assigned_user='" . $user_uid . "'";
												$result_queue = mysqli_query($connection, $query_queue);
												?>
												<select id="destination_no" name="destination_no[]" class="form-control">
													<?php
													while ($row_sip = mysqli_fetch_array($result_queue)) {
														?>
														<option <?php if (trim($ivr_dest_no) == trim($row_sip["name"])) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value=<?php echo $row_sip["name"]; ?>><?php echo $row_sip["name"]; ?> </option>
													<?php } ?>
												</select>
											<?php } elseif ($ivr_dest_type == 2) {
												$query_ext = "select * from cc_sip_buddies where id_cc_card='" . $user_uid . "'";
												$result_ext = mysqli_query($connection, $query_ext); ?>
												<select id="destination_no" name="destination_no[]" class="form-control">
													<?php while ($row_ext = mysqli_fetch_array($result_ext)) { ?>
														<option <?php if (trim($ivr_dest_no) == trim($row_ext["name"])) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value=<?php echo $row_ext["name"]; ?>><?php echo $row_ext["name"]; ?> </option>

													<?php } ?>
												</select>
											<?php } elseif ($ivr_dest_type == 3) {
												$query_vm = "select * from cc_voicemail_users where customer_id='" . $user_uid . "'";
												$result_vm = mysqli_query($connection, $query_vm);
												?>
												<select id="destination_no" name="destination_no[]" class="form-control">
													<?php while ($row_vm = mysqli_fetch_array($result_vm)) { ?>
														<option <?php if (trim($ivr_dest_no) == trim($row_vm["mailbox"])) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value=<?php echo $row_vm["mailbox"]; ?>><?php echo $row_vm["mailbox"]; ?></option>';
													<?php } ?>
												</select>
											<?php } elseif ($ivr_dest_type == 5) {

												$query_booking = "select * from booking where user_id='" . $user_uid . "'";
												$result_booking = mysqli_query($connection, $query_booking);
												?>
												<select id="destination_no" name="destination_no[]" class="form-control">
													<?php while ($row_book = mysqli_fetch_array($result_booking)) { ?>
														<option <?php if (trim($row_book["confno"]) == trim($ivr_dest_no)) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_book["confno"] ?> ">
															<?php echo $row_book["confno"]; ?>
														</option>
													<?php } ?>
												</select>

												<!-- <input type="text" id="destination" name="destination" class="form-control" value='.$ordcalldestn.'>'; -->

											<?php } elseif ($ivr_dest_type == 6) {

												$query_ring = "select * from cc_ring_group where user_id='" . $user_uid . "'";
												$result_ring = mysqli_query($connection, $query_ring); ?>

												<select id="destination_no" name="destination_no[]" class="form-control">
													<?php
													while ($row_ring = mysqli_fetch_array($result_ring)) { ?>
														<option <?php if (trim($row_ring["ringno"]) == trim($ivr_dest_no)) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_ring["ringno"] ?> ">
															<?php echo $row_ring["ringno"]; ?>
														</option>
													<?php } ?>
												</select>
												<?php
											} elseif ($ivr_dest_type == 8) {
												$query_ivr = "select * from ivr where user_id='" . $user_uid . "'";
												$result_ivr = mysqli_query($connection, $query_ivr) or die ("query failed : query_ivr"); ?>

												<select id="destination_no" name="destination_no[]" class="form-control">
													<?php
													while ($row_ring = mysqli_fetch_array($result_ivr)) { ?>
														<option <?php if (trim($row_ring["id"]) == trim($ivr_dest_no)) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_ring["id"] ?> ">
															<?php echo $row_ring["ivr_name"]; ?>
														</option>
													<?php } ?>
												</select>
												<?php
											} else {
												echo '<input type="text" name="destination_no[]" class="form-control" value=' . $ivr_dest_no . '>';
											}
											?>
										</div>
									</td>
									<?php if ($i == 1) { ?>
										<td><button type="button" id="add" name="add" value="" class="btn btn-primary">+</button>
										</td>
									<?php } else { ?>
										<td><button type="button" id="<?php echo $i; ?>" name="remove"
												class="btn btn-danger remove_row">-</button></td>
									<?php } ?>
								</tr>
								<?php
								$i++;
							}
						}
						?>

					</tbody>
				</table>
				<input type="hidden" name="" id="user_idd" value="<?php echo $user_uid; ?>" />
				<div class="form-group pull-right" style="margin-right:400px; margin-top:30px;">
					<input type="submit" name="submit" value="Submit" class="btn btn-primary">
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		var option = '<?php echo str_replace('selected', '', $options); ?>';
		//alert(option);
		var i = $('#dynamicadd tr').length;
		// alert(i);

		$("#add").on("click", function () {
			i++;
			$("#dynamicadd").append('<tr id ="row' + i + '" class="tr-shadow"><td><input id="digit" name="digit[]" placeholder="Input Digit" class="form-control" type="number" value=""/></td><td> <select id="destination_typ' + i + '"  name="destination_type[]" rel="destination_no' + i + '" class="form-control destination_type"><option value="">Select Destination Type</option>' + option + '</select></td><td><div id="destination_no' + i + '" ><select name="destination_no[]" class="form-control"><option value="">Select Destination</option></select></div></td><td> <button id="' + i + '" name="remove" class="btn btn-danger remove_row">-</button></td></tr>');

			// alert(i);
		});
		$(document).on("click", '.remove_row', function () {
			var row_id = $(this).attr('id');
			//  alert(row_id);
			$('#row' + row_id + '').remove();
			i--;
		});

		$(document).on('change', '.destination_type', function () {
			var dyid = $(this).attr('rel');
			var user_id = $("#user_idd").val();


			// alert(dyid);
			var id = $(this).val();
			$.ajax({
				url: "ajax_selection_did.php",
				type: "GET",
				data: { q: id, user_id: user_id },
				success: function (data) {
					$('#' + dyid).html(data);
				}
			});
		});

	});
	$("select[name='clientId']").change(function () {
		var clientsID = $(this).val();
		if (clientsID) {
			$.ajax({
				url: "ajaxpro.php",
				dataType: 'Json',
				data: { 'id': clientsID },
				success: function (data) {
					$('select[name="selectedUser"]').empty();
					$.each(data, function (key, value) {
						$('select[name="selectedUser"]').append('<option value="' + key + '">' + value + '</option>');
					});
				}
			});
		} else {
			$('select[name="selectedUser"]');
			$.each(data, function (key, value) {
				$('select[name="selectedUser"]').append('<option value="' + key + '">' + value + '</option>');
			});
		}
	});
</script>
<?php require_once ('footer.php'); ?>