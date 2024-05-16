<?php require_once('header.php');
// echo "<pre>";print_r( $_SESSION);exit;
$messages = '';
$select_blacklist = "select * from cc_blacklist where id='" . $_GET['id'] . "'";
$result_edit_blacklist = mysqli_query($con, $select_blacklist);
if (mysqli_num_rows($result_edit_blacklist) > 0) {
	$row = mysqli_fetch_array($result_edit_blacklist);
	$userid = $row['user_id'];
	$clientId = $row['clientId'];
	// $user_id = $row['user_id'];
	$digits = $row['digits'];
	$transfer_number = $row['transfer_number'];
	$subject = $row['subject'];
	$ruletype = $row['ruletype'];
	$blocktype = $row['blocktype'];
	$status = $row['status'];
}

if ($_SESSION['userroleforpage'] == 1) {
	$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=3 and users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
	$result_client = mysqli_query($connection, $query_client);
	// while($resultclientrows =mysqli_fetch_assoc($result_client)){
	//  $clientId=$resultclientrows['clientId'];
	// }
	$query_user = "select * from users_login where role !=3 and role !=4";
	$result_user_login = mysqli_query($connection, $query_user);
}

if (isset($_POST['submit'])) {
	$create = date('Y-m-d h:i:s');
	if ($_POST['subject'] == 'prefix') {
		$digits = $_POST['prefix'];
	} else {
		$digits = $_POST['phonenumber'];
	}
	if ($_POST['ruletype'] == 'block') {
		$_POST['transfer'] = '';
	} else {
		$_POST['block'] = '';
	}


	$update_blacklist = "update cc_blacklist set `user_id`='" . $_POST['selectedUser'] . "', `clientId`='" . $_POST['clientId'] . "',`subject`='" . $_POST['subject'] . "', `digits`='" . $digits . "',`transfer_number`='" . $_POST['transfer'] . "',`ruletype` = '" . $_POST['ruletype'] . "',`blocktype`='" . $_POST['block'] . "',status='" . $_POST['status'] . "' where id='" . $_GET['id'] . "'";
	$result_blacklist = mysqli_query($con, $update_blacklist);

	if ($result_blacklist) {

		if ($_POST['status'] == '1') {
			$status = 'Enable';
		} else {
			$status = 'Disable';
		}
		$activity_type = 'Caller ID Updated';
		if ($_SESSION['userroleforpage'] == '1') {
			$msg = 'Caller ID: ' . $_POST['caller_id'] . ' ' . 'Caller ID ' . $status . ' Succesfully! By Admin';
		} else {
			$msg = 'Caller ID: ' . $_POST['caller_id'] . ' ' . 'Caller ID ' . $status . ' Succesfully! By User';
		}
		user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
		$_SESSION['msg'] = 'Block Update Succesfully!'; 
			echo '<script>window.location.href="blacklist.php"</script>'; }
}


if ($_SESSION['userroleforpage'] == 2 && $userid !== $_SESSION['login_user_id']) { ?>
	<script>
		window.location = 'access_denied.php';    
	</script>
<?php } ?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Blacklist Information <span style="margin-left:50px;color:blue;">
								<?php echo $messages; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="blacklist.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i> Blacklist
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="blacklistForm" name="blacklist" action="" method="post">
								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-9">
											<select id="clientId" name="clientId" class="form-control selectpicker" data-live-search="true"data-show-subtext="false"  required>
												<option value="0" selected="selected">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($row['clientId'] == $clientId) {
														echo 'selected="selected"';
													} else {
														'';
													} ?> value="<?php echo $row['clientId']; ?>">
														<?php echo $row['clientName'].'/'.$row['clientEmail']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Select User</label>
										</div>
										<div class="col-12 col-md-9">
											<select id="selectedUser" name="selectedUser" class="form-control" required>
												<?php while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
													<option <?php if ($row_user['id'] == $userid) {
														echo 'selected="selected"';
													} else {
														'';
													} ?> value="<?php echo $row_user['id']; ?>">
														<?php echo $row_user['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
								<?php } else { ?>
									<input id="clientId" name="clientId" type="hidden" class="form-control numbersOnly"
										type="text" value="<?php echo $clientId ?>" />
									<input id="selectedUser" name="selectedUser" type="hidden"
										class="form-control numbersOnly" type="text" value="<?php echo $userid ?>" />
								<?php } ?>
								<div class="row form-group">
									<div class="col col-md-3">
										<label for="text-input" class="form-control-label">Subject</label>
									</div>
									<div class="col-12 col-md-9">
										<select id="subject" name="subject" onchange="phone(this.value)"
											class="form-control" required>
											<option value="">Select</option>
											<option <?php if (($subject == 'prefix') || (isset($_POST['subject']) && $_POST['subject'] == "prefix")) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="prefix">Prefix
											</option>
											<option <?php if (($subject == 'phonenumber') || (isset($_POST['subject']) && $_POST['subject'] == "phonenumber")) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="phonenumber">Phone number</option>
										</select>
									</div>
								</div>
								<?php if ($subject == 'prefix') {
									$prefix_class = 'block';
								} else {
									$prefix_class = 'none';
								} ?>
								<div id="prefixhide" style="display:<?php echo $prefix_class; ?>">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Prefix</label>
										</div>
										<div class="col-12 col-md-9">
											<input name="prefix" id="prefix" placeholder="Enter prefix number"
												class="form-control digits" type="text" value="<?php echo $digits ?>" />
										</div>
									</div>
								</div>

								<?php
								if ($subject == 'phonenumber') {
									$phone_class = 'block';
								} else {
									$phone_class = 'none';
								}
								?>
								<div id="phonehide" style="display:<?php echo $phone_class; ?>">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Phonenumber</label>
										</div>
										<div class="col-12 col-md-9">
											<input name="phonenumber" id="phonenumber"
												placeholder="Enter 10 digit phone no." class="form-control digits"
												type="number" value="<?php echo $digits ?>" />
										</div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-3">
										<label for="text-input" class="form-control-label">Rule Type</label>
									</div>
									<div class="col-12 col-md-9">
										<select id="ruletype" name="ruletype" class="form-control" required>
											<option value="">Select</option>
											<option <?php if (($ruletype == "transfer") || (isset($_POST['ruletype']) && $_POST['ruletype'] == 'transfer')) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="transfer">Transfer</option>
											<option <?php if (($ruletype == "block") || (isset($_POST['ruletype']) && $_POST['ruletype'] == 'block')) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="block">Block</option>
										</select>
									</div>
								</div>
								<?php
								if ($ruletype == "transfer") {
									$transfer_class = 'block';
								} else {
									$transfer_class = 'none';
								}
								?>
								<div id="transferhide" style="display:<?php echo $transfer_class; ?>">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">TransferNumber</label>
										</div>
										<div class="col-11 col-md-9">
											<input id="transfer" name="transfer" placeholder="Transfer Number"
												class="form-control" type="text"
												value="<?php echo $transfer_number; ?>" />
										</div>
									</div>
								</div>

								<?php
								if ($ruletype == "block") {
									$block_class = 'block';
								} else {
									$block_class = 'none';
								}
								?>
								<div id="blockhide" style="display:<?php echo $block_class; ?>">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Block</label>
										</div>
										<div class="col-12 col-md-9">
											<select id="block" name="block" class="form-control">
												<option value="">Select</option>
												<option <?php if ($blocktype == "busy") {
													echo "selected='selected'";
												} else {
													echo '';
												} ?> value="busy">Busy</option>
												<option <?php if ($blocktype == "congestion") {
													echo "selected='selected'";
												} else {
													echo '';
												} ?>value="congestion">
													Congestion</option>
												<option <?php if ($blocktype == "hangup") {
													echo "selected='selected'";
												} else {
													echo '';
												} ?> value="hangup">Hangup</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-3">
										<label for="text-input" class="form-control-label">Status*</label>
									</div>
									<div class="col-12 col-md-9">
										<select id="status" name="status" class="form-control" required>
											<option value="1" <?php if ($status == 1) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?>>Enable</option>
											<option value="0" <?php if ($status == 0) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?>>Disable</option>
										</select>
									</div>
								</div>
								<div class="form-group pull-right">
									<button type="submit" name="submit" value="submit"
										class="btn btn-primary btn-sm">Submit</button>
								</div>
								<p style="color:blue;">
									<?php echo $messages; ?>
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
	function phone(field_value) {
		document.getElementsByClassName('digits').value = '';
		if (field_value == 'prefix') {
			document.getElementById('prefixhide').style.display = "block";
			document.getElementById('phonehide').style.display = "none";
			document.getElementById('prefix').setAttribute('required', 'true');
			document.getElementById('phonenumber').removeAttribute('required');
		} else {
			document.getElementById('phonehide').style.display = "block";
			document.getElementById('prefixhide').style.display = "none";
			document.getElementById('phonenumber').setAttribute('required', 'true');
			document.getElementById('prefix').removeAttribute('required');
		}
	}

	$("#ruletype").on("change", function () {
		var block_type = $(this).val();
		ruletype(block_type);
	});
	function ruletype(value) {
		if (value == 'transfer') {
			document.getElementById('transferhide').style.display = "block";
			document.getElementById('blockhide').style.display = "none";
			document.getElementById('transfer').setAttribute('required', 'true');
			document.getElementById('block').removeAttribute('required');
		} else {
			document.getElementById('blockhide').style.display = "block";
			document.getElementById('transferhide').style.display = "none";
			document.getElementById('block').setAttribute('required', 'true');
			document.getElementById('transfer').removeAttribute('required');
		}
	}

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
						$('select[name="selectedUser"]').append('<option selected="selected" value="' + key + '">' + value + '</option>');
					});
				}
			});


		} else {
			$('select[name="selectedUser"]');
			$.each(data, function (key, value) {
				$('select[name="selectedUser"]').append('<option selected="selected" value="' + key + '">' + value + '</option>');
			});
		}
	});
</script>
<?php require_once('footer.php'); ?>