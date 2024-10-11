<?php require_once('header.php');

// echo RHOST;exit;
$message = '';
$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);

if (isset($_POST['selectedUser'])) {
	$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "'";
	$result_user_login = mysqli_query($connection, $query_user);
} else {
	$_POST['clientId'] = '';
}
//echo '<pre>'; print_r($_SESSION);exit;
if (isset($_POST['submit'])) {
	$confno = $_POST['confno'];
	$matchconfno = '';
	$select_conf = "select confno from booking where confno='" . $_POST['confno'] . "'";
	$query_conf = mysqli_query($con, $select_conf);
	while ($row_conf_match = mysqli_fetch_array($query_conf)) {
		$matchconfno = $row_conf_match['confno'];
	}
	if ($matchconfno == $confno) {
		$message = 'Please Generate Your Conference Number';
	} else {
		//echo '<pre>';print_r($_POST);exit;
		if ($_SESSION['userroleforpage'] == '2') {
			$_POST['clientId'] = $_SESSION['userroleforclientid'];
			$_POST['selectedUser'] = $_SESSION['login_user_id'];
		}

		$created_at = date('Y-m-d h:i:s');
		$updated_at = date('Y-m-d h:i:s');
		$insert_conf = "INSERT INTO booking(user_id, clientId, confno, pin, adminpin , maxusers, status,confDesc,dateReq,dateMod) VALUES ('" . $_POST['selectedUser'] . "','" . $_POST['clientId'] . "','" . $_POST['confno'] . "','" . $_POST['pin'] . "', '" . $_POST['adminpin'] . "','" . $_POST['maxusers'] . "','" . $_POST['status'] . "','" . $_POST['confDesc'] . "','" . $created_at . "','" . $updated_at . "')";

		//echo $insert_conf; exit;
		$result_queue = mysqli_query($connection, $insert_conf) or die("query failed : insert conference");
		$pin = $_POST['confno'];
		$adminpin = $_POST['adminpin'];


		$register_string = "\n conf => $pin,,$adminpin";
		$conf_path = "/var/www/html/callanalog/admin/meet_rooms.conf";
		file_put_contents($conf_path, $register_string, FILE_APPEND | LOCK_EX);

		$srcFile = '/var/www/html/callanalog/admin/meet_rooms.conf';
		$dstFile = '/var/www/html/meet_rooms.conf';

		// Establish an SSH2 connection to the remote server.
		$conn = ssh2_connect(RHOST, RPORT);

		if (!$conn) {
			die("Unable to connect to the remote server.");
		}
		// Authenticate with the private key.
		if (ssh2_auth_pubkey_file($conn, RUSERNAME, PUBLIC_KEY, PRIVATE_KEY)) {
			// Securely transfer the file to the remote server.
			if (ssh2_scp_send($conn, $srcFile, $dstFile, 0644)) {
				echo "File transferred successfully.";
			} else {
				echo "Failed to transfer the file.";
			}
		} else {
			echo "Authentication failed.";
		}

		/*
						  //START FOR MEETME_ROOMS.CONF FILE ADD DATA ON IT:::
						  $register_string = "\n conf => $pin,,$adminpin";
						  $register_string = str_replace("\r", "", $register_string);
								  
								  // Check if the user is already registered
								  $registered = false;
								  $sip_conf = fopen("/etc/asterisk/meetme_rooms.conf", "r") or die("Unable to open file!");
								  while (!feof($sip_conf)) {
									  $line = fgets($sip_conf);
									  if (strpos($line, "conf=> $pin,,$adminpin") !== false) {
										  $registered = true;
										  break;
									  }
								  }
								  fclose($sip_conf);
						  
								  // Write conference registration parameters to meetme_rooms.conf
								  if (!$registered) {
									  $sip_conf = fopen("/etc/asterisk/meetme_rooms.conf", "a") or die("Unable to open file!");
									  fwrite($sip_conf, $register_string);
									  fclose($sip_conf);
						  
									  echo "Registration successful. The conference user $pin, $adminpin has been added to the meetme_rooms.conf file.";
								  } else {
									  echo "Registration failed. The conference user $pin, $adminpin is already registered in the meetme_rooms.conf file.";
								  }

							   
				  // END FOR MEETME_ROOMS.CONF FILE ADD DATA ON IT:::

				  */

		if ($result_queue) {
			if ($_SESSION['userroleforpage'] == '1') {
				$activity_type = 'Conference Assign to User';
				$msg = 'Conference No: ' . $_POST['confno'] . ' ' . 'Conference Added Succesfully! By Admin';
			} else {
				$activity_type = 'Conference Added';
				$msg = 'Conference No: ' . $_POST['confno'] . ' ' . 'Conference Added Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
			$_SESSION['msg'] = 'Conference Added Succesfully!';
			echo '<script>window.location.href="conference.php"</script>';
		}
	}
}

if (isset($_POST['status'])) {
	$ordstatus = $_POST['status'];
} else {
	$ordstatus = '';
}

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Conference Add<span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span><br></h2>
						<div class="table-data__tool-right">
							<span style="margin-left:50px;color:blue;">
								<?php echo $registration; ?>
							</span>
							<a href="conference.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-tty" aria-hidden="true"></i> Conference</button>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="ringForm" action="" method="post">

								<?php //			echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
								if ($_SESSION['userroleforpage'] == '1') { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker" required>
												<option value="">Select</option>
												<?php
												if (mysqli_num_rows($result_client) > 0) {
													while ($row = mysqli_fetch_array($result_client)) { ?>
														<option <?php if ($row['clientId'] == $_POST['clientId']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row['clientId']; ?>">
															<?php echo $row['clientName'].'/'.$row['clientEmail']; ?>
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
												<option value="">Select</option>
												<?php if (isset($_POST['selectedUser'])) {
													while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
														<option <?php if ($row_user['id'] == $_POST['selectedUser']) {
															echo 'selected="selected"';
														} else {
															echo '';
														} ?>
															value="<?php echo $row_user['id']; ?>">
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
										<label for="text-input" class=" form-control-label">Conference Name*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="confDesc" name="confDesc" placeholder="" class="form-control"
											type="text" value="<?php if (isset($_POST['confDesc'])) {
												echo $_POST['confDesc'];
											} else {
												echo '';
											} ?>" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Conference Number</label>
									</div>
									<div class="col-10 col-md-6">
										<input id="confno" name="confno" placeholder="0000" value="<?php if (isset($_POST['confno'])) {
											echo $_POST['confno'];
										} else {
											echo '';
										} ?>" class="form-control" type="text" required readonly />
									</div>
									<div class="col-2 col-md-2">
										<button type="button" class="btn btn-success btn-sm" id="genrateIntercom"><i
												class="fa fa-refresh" aria-hidden="true"></i> Generate</button>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">PIN Number**</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="pin" name="pin" placeholder="10" value="<?php if (isset($_POST['pin'])) {
											echo $_POST['pin'];
										} else {
											echo '';
										} ?>" class="form-control" type="text" required />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Admin PIN Number</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="adminpin" name="adminpin" placeholder="10" value="<?php if (isset($_POST['adminpin'])) {
											echo $_POST['adminpin'];
										} else {
											echo '';
										} ?>" class="form-control" type="text" required />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Max Users</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="maxusers" name="maxusers" placeholder="10" value="<?php if (isset($_POST['maxusers'])) {
											echo $_POST['maxusers'];
										} else {
											echo '';
										} ?>" class="form-control" type="text" required />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Status</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="status" name="status" class="form-control" required>
											<option <?php if ($ordstatus == 'Active') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Active">Active</option>
											<option <?php if ($ordstatus == 'Inactive') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Inactive">Inactive</option>
											<option <?php if ($ordstatus == 'Suspended') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Suspended">Suspended</option>
										</select>
									</div>
								</div>

								<div class="form-group pull-right">
									<button type="submit" name="submit" value="submit"
										class="btn btn-primary btn-sm">Submit</button>
								</div>
								<p style="color:blue;">
									<?php echo $message; ?>
								</p>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
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

	$("select[name='clientId']").change(function () {
		var selectedUSERS = $(this).val();


		if (selectedUSERS) {


			$.ajax({
				url: "ajaxoutbound.php",
				dataType: 'Json',
				data: { 'id': selectedUSERS },
				success: function (data) {
					$('select[name="outbound_cid"]').empty();
					$.each(data, function (key, value) {
						$('select[name="outbound_cid"]').append('<option value="' + key + '">' + value + '</option>');
					});
				}
			});


		} else {
			$('select[name="outbound_cid"]');
			$.each(data, function (key, value) {
				$('select[name="outbound_cid"]').append('<option value="' + key + '">' + value + '</option>');
			});
		}
	});

	$(document).ready(function () {

		$('#genrateIntercom').click(function () {
			genrateIntercom();
		});
		function genrateIntercom() {
			$.ajax({
				url: "ajaxCreateIntercom.php",
				type: 'post',
				data: { data_type: 'conference' },
				success: function (data) {
					$('#confno').val(data);
				}
			});
		}
	});
</script>

<?php require_once('footer.php'); ?>