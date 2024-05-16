<?php
require_once ('header.php');

$query_client = "SELECT Client.clientName,Client.clientId,Client.clientEmail FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=3 and users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);

if (isset($_POST['selectedUser'])) {
	$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "'";
	$result_user_login = mysqli_query($connection, $query_user);
}
//  $user_id= $_SESSION['login_user_id'];
//  $client_id = $_SESSION['userroleforclientid'];

$sch_call = isset($_POST['sch_call']) ? $_POST['sch_call'] : '';
$starttime = isset($_POST['starttime']) ? $_POST['starttime'] : '';
$stoptime = isset($_POST['stoptime']) ? $_POST['stoptime'] : '';
$startday = isset($_POST['startday']) ? $_POST['startday'] : '';
$stopday = isset($_POST['stopday']) ? $_POST['stopday'] : '';
$all_time = isset($_POST['all_time']) ? $_POST['all_time'] : '';
$message = isset($_POST['messages']) ? $_POST['messages'] : '';
$dest_startday = "";
$dest_stopday = "";
$dest_all_time = "";
$dest_playback = "";
$message = "";
$destination = "";
$time_image = "";
$message = "";
$user_uid = "";
$fileErr = '';
$msg = '';
if (isset($_POST['submit'])) {

	// echo"<pre>";print_r($_POST);exit;
	$error = 'false';

	$destination = $_POST['destination_no'];

	$destination_type = $_POST['destination_type'];

	//  $sch_call = $_POST[''];

	$starttime = $_POST['starttime'];
	$t = date(' H:i:s', strtotime($starttime));
	// echo $t;

	$stoptime = $_POST['stoptime'];

	$startday = $_POST['startday'];

	$stopday = $_POST['stopday'];

	$all_time = $_POST['all_time'];

	$message = $_POST['messages'];
	if ($_SESSION['userroleforpage'] == '2') {
		$_POST['clientId'] = $_SESSION['userroleforclientid'];
		$_POST['selectedUser'] = $_SESSION['login_user_id'];
	}
	$user_uid = $_POST['selectedUser'];
	$rarray = array(' ', '(', ')', '$', '&', '@', ':','#','!','^');
	$filename = str_replace($rarray, '_', $_FILES["ivr_file"]["name"]);
	$tempname = $_FILES["ivr_file"]["tmp_name"];

	
	$FileType = pathinfo($filename, PATHINFO_EXTENSION);
	$fileName = pathinfo($filename, PATHINFO_FILENAME);

	$fileName = $fileName.date('YmdHis');
	$filename = $fileName.'.'.$FileType;
	$folder = "timegroup/" . $filename;
	move_uploaded_file($tempname, $folder);	

	// // Allow certain file formats
	if ($FileType !== "mp3") {
		$fileErr = "Sorry, only MP3 Audio files are allowed";
		$error = 'true';
	} else {
		// echo '<pre>'; print_r($_POST);exit;
		
		$insert_time_group = "INSERT INTO `cc_time_group`(`destination_type`,`destination`,`sch_call`,`starttime`,`stoptime`,`startday`,`stopday`,`all_time` , `message`, `ivr_file`, `user_id` , `client_id`)VALUES('" . $destination_type . "','" . $destination . "','1' , '" . $starttime . "' , '" . $stoptime . "','" . $startday . "','" . $stopday . "', '" . $all_time . "' , '" . $message . "','" . $fileName . "', '" . $_POST['selectedUser'] . "' , '" . $_POST['clientId'] . "')";
		$result_time = mysqli_query($connection, $insert_time_group);

		$_SESSION['msg'] = 'Time Group Added Succesfully!';
		echo '<script>window.location.href="timegroup.php"</script>';
	}
}

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">Time Condition<span style="margin-left:50px;color:blue;">
								<?php echo $msg; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="timegroup.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-tty" aria-hidden="true"></i>TimeConditions</button>
							</a>
						</div>
					</div>
				</div>
			</div>



			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="form" name="form" action="" method="post" enctype="multipart/form-data">

								<?php //			echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
								if ($_SESSION['userroleforpage'] == '1') { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class="form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker" required>
												<option value="0" selected="selected">Select</option>
												<?php
												if (mysqli_num_rows($result_client) > 0) {
													while ($row = mysqli_fetch_array($result_client)) { ?>
														<option <?php if ($row['clientId'] == $_POST['clientId']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?> value="<?php echo $row['clientId']; ?>">
															<?php echo $row['clientName'] . '/' . $row['clientEmail']; ?>
														</option>
													<?php }
												} ?>
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
												<?php if (isset($_POST['selectedUser'])) {
													while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
														<option <?php if ($row_user['id'] == $_POST['selectedUser']) {
															echo 'selected';
														} ?> value="<?php echo $row_user['id']; ?>">
															<?php echo $row_user['name']; ?>
														</option>
													<?php }
												} ?>
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
										<label for="text-input" class="form-control-label">Destination Type</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="destination_type" rel="destination_no" name="destination_type"
											class="form-control" required>
											<option value="">Select</option>

											<?php
											$options = '';
											$select_destination = "SELECT * FROM `cc_selection_did`";
											$res_destination = mysqli_query($connection, $select_destination);
											if (mysqli_num_rows($res_destination) > 0) {
												while ($row = mysqli_fetch_assoc($res_destination)) {
													$options .= '<option ';
													if (isset($_POST['destination_type']) && $_POST['destination_type'] == $row['id']) {
														$options .= 'selected';
													}
													$options .= ' value="' . $row['id'] . '">' . $row['selection_value'] . '</option>';
												}
											}
											?>
											<?php echo $options; ?>

										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Destination</label>
									</div>
									<div class="col-12 col-md-8" id="destinationSelect">
										<select name="destination_no" id="destination_no" class="form-control" required>
											<option value="">None</option>
											<?php if ($_POST['destination_type'] == 1) {
												$query_queue = "select * from cc_queue_table where assigned_user='" . $user_uid . "'";
												$result_queue = mysqli_query($connection, $query_queue);
												while ($row_sip = mysqli_fetch_array($result_queue)) {
													?>
													<option <?php if (trim($_POST['destination_no']) == trim($row_sip["name"])) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_sip["name"]; ?>">
														<?php echo $row_sip["name"]; ?>
													</option>
												<?php }
											} elseif ($_POST['destination_type'] == 2) {
												$query_ext = "select * from cc_sip_buddies where id_cc_card='" . $user_uid . "'";
												$result_ext = mysqli_query($connection, $query_ext);
												while ($row_ext = mysqli_fetch_array($result_ext)) { ?>
													<option <?php if (trim($_POST['destination_no']) == trim($row_ext["name"])) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_ext["name"]; ?>">
														<?php echo $row_ext["name"]; ?>
													</option>

												<?php }
											} elseif ($_POST['destination_type'] == 3) {
												$query_vm = "select * from cc_voicemail_users where customer_id='" . $user_uid . "'";
												$result_vm = mysqli_query($connection, $query_vm);

												while ($row_vm = mysqli_fetch_array($result_vm)) { ?>
													<option <?php if (trim($_POST['destination_no']) == trim($row_vm["name"])) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_vm["mailbox"]; ?>">
														<?php echo $row_vm["mailbox"]; ?>
													</option>';
												<?php }
											} elseif ($_POST['destination_type'] == 5) {

												$query_booking = "select * from booking where user_id='" . $user_uid . "'";
												$result_booking = mysqli_query($connection, $query_booking);

												while ($row_book = mysqli_fetch_array($result_booking)) { ?>
													<option <?php if (trim($row_book["confno"]) == trim($_POST['destination_no'])) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_book["confno"] ?> ">
														<?php echo $row_book["confno"]; ?>
													</option>
												<?php }
											} elseif ($_POST['destination_type'] == 6) {

												$query_ring = "select * from cc_ring_group where user_id='" . $user_uid . "'";
												$result_ring = mysqli_query($connection, $query_ring);
												while ($row_ring = mysqli_fetch_array($result_ring)) { ?>
													<option <?php if (trim($row_ring["ringno"]) == trim($_POST['destination_no'])) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?> value="<?php echo $row_ring["ringno"] ?> ">
														<?php echo $row_ring["ringno"]; ?>
													</option>
												<?php }
											} else {
												// echo '<input type="text" id="destination" name="destination_no[]" class="form-control" value='.$_POST['destination_no'].'>';
											}

											?>
										</select>
									</div>
								</div>

								<div class="showhideForm" id="dataDiv">
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Start Time</label>
										</div>
										<div class="col-12 col-md-8">
											<input type="time" class="form-control" name="starttime" value="<?php if (isset($_POST['starttime'])) {
												echo $_POST['starttime'];
											} else {
												echo '';
											} ?>" id="starttime" required>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Stop Time</label>
										</div>
										<div class="col-12 col-md-8">
											<input type="time" class="form-control" name="stoptime" value="<?php if (isset($_POST['stoptime'])) {
												echo $_POST['stoptime'];
											} else {
												echo '';
											} ?>" id="stoptime" required>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Start Day</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="all_time" name="startday" class="form-control" required>
												<option value="">Select</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'sun') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="sun">
													Sunday</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'mon') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="mon">
													Monday</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'tue') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="tue">
													Tuesday</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'wed') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?>value="wed">
													Wednesday</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'thu') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="thu">
													Thursday</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'fri') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="fri">Friday
												</option>
												<option <?php if (isset($_POST['startday']) && $_POST['startday'] == 'sat') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="sat">
													Saturday</option>
											</select>



											<!-- <input type="datetime-local" class="form-control" name="startday" id="Test_DatetimeLocal"> -->
										</div>
									</div>


									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Stop Day</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="all_time" name="stopday" class="form-control" required>
												<option value="">Select</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'sun') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="sun">
													Sunday</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'mon') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="mon">
													Monday</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'tue') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="tue">
													Tuesday</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'wed') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?>value="wed">
													Wednesday</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'thu') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="thu">
													Thursday</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'fri') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="fri">
													Friday
												</option>
												<option <?php if (isset($_POST['stopday']) && $_POST['stopday'] == 'sat') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="sat">
													Saturday
												</option>
											</select>
											<!-- <input type="datetime-local" class="form-control" name="stopday" id="Test_DatetimeLocal"> -->
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">All time</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="all_time" name="all_time" class="form-control">
												<option value="">Select</option>
												<option <?php if (isset($_POST['all_time']) && $_POST['all_time'] == '1') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="1">Yes
												</option>
												<option <?php if (isset($_POST['all_time']) && $_POST['all_time'] == '0') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="0">No
												</option>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">Off Hours Messages</label>
										</div>
										<div class="col-12 col-md-8">
											<input class="form-control" name="messages" type="text" value="<?php if (isset($_POST['messages'])) {
												echo $_POST['messages'];
											} else {
												echo '';
											} ?>">

										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="selectSm" class=" form-control-label">IVR File</label>
										</div>
										<div class="col-12 col-md-8">
											<input class="form-control" name="ivr_file" id="ivr_file" type="file"
												required>
											<!-- <audio  name="ivr_file" id="ivr_file" type="audio/wav"></audio> -->
											<!-- <audio type="audio/wav" src="<?php //echo $folder
											?>" controls="" controlslist="nodownload" > </audio> -->
											<?php
											if (isset($_FILES["ivr_file"]["name"]) && $_FILES["ivr_file"]["name"] != '' && $error == 'true') {

												echo "<span style='color:red;'>" . $fileErr . "</span>";
												?>
											<?php }
											?>
										</div>
									</div>
									<input type="hidden" name="" id="user_id"
										value="<?php echo $_SESSION['login_user_id'] ?>" />

									<div class="form-group pull-right">
										<button type="submit" name="submit" value="submit"
											class="btn btn-primary btn-sm">Submit</button>
									</div>
								</div>
						</div>
					</div>
				</div>
				<p style="color:blue;">
					<?php echo $msg; ?>
				</p>
				</form>
				<script>
					<?php if ($_SESSION['userroleforpage'] == '2') { ?>
						$(document).on('change', '#destination_type', function () {

							var user_id = $("#user_id").val();
							var id = $(this).val();
							$.ajax({
								url: "ajax_selection_did.php",
								type: "GET",
								data: {
									q: id,
									user_id: user_id
								},
								success: function (data) {
									$("#destination_no").html(data);
								}
							});
						});
					<?php } else { ?>
						$(document).on('change', '#destination_type', function () {

							var user_id = $("#selectedUser").val();
							var id = $(this).val();
							$.ajax({
								url: "ajax_selection_did.php",
								type: "GET",
								data: {
									q: id,
									user_id: user_id
								},
								success: function (data) {
									$("#destination_no").html(data);
								}
							});
						});
					<?php } ?>
					$("select[name='clientId']").change(function () {
						var selectedUSERS = $(this).val();
						$('#destination_type').prop('selectedIndex', 0);
						$('#destination_no')
							.find('option')
							.remove()
							.end()
							.append('<option value="">Select</option>');
					});
				</script>
				<script>
					$("select[name='clientId']").change(function () {
						var clientsID = $(this).val();
						if (clientsID) {
							$.ajax({
								url: "ajaxpro.php",
								dataType: 'Json',
								data: {
									'id': clientsID
								},
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