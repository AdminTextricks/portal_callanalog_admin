<?php require_once('header.php');
$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=3 and users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);
$messages = '';
$clientId = isset($_POST['clientId']) ? $_POST['clientId'] : '';
if (isset($_POST['selectedUser'])) {
	$query_user = "select * from users_login where clientId='" . $_POST['clientId'] . "'";
	$result_user_login = mysqli_query($connection, $query_user);
	$result_user = mysqli_query($connection, $query_user);
	$userDetails = mysqli_fetch_assoc($result_user);
}


if (isset($_POST['submit'])) {
	if ($_POST['subject'] == 'prefix') {
		$digits = $_POST['prefix'];
	} else {
		$digits = $_POST['phonenumber'];
	}
	// echo $digits;
	// echo '<pre>';print_r($_POST);exit;
	if ($_SESSION['userroleforpage'] == '2') {

		$clientId = $_SESSION['userroleforclientid'];
		$user_id = $_SESSION['login_user_id'];

	}
	if ($_SESSION['userroleforpage'] == '1') {
		$clientId = $_POST['clientId'];
		$user_id = $_POST['selectedUser'];

	}
	$create = date('Y-m-d h:i:s');
	$insert_blacklist = "insert into cc_blacklist (user_id, clientId, subject,digits,transfer_number,ruletype,blocktype,status,created_at) value ('" . $user_id . "','" . $clientId . "','" . $_POST['subject'] . "','" . $digits . "','" . $_POST['transfer'] . "','" . $_POST['ruletype'] . "','" . $_POST['block'] . "','" . $_POST['status'] . "','" . $create . "')";
	//  echo $insert_blacklist;exit;
	$result_blacklist = mysqli_query($con, $insert_blacklist);


	$lastid = mysqli_insert_id($con);

	if ($result_blacklist) {
		if ($_SESSION['userroleforpage'] == '1') {
			$activity_type = 'Caller Id Blocked';
			$msg = 'Caller ID: ' . $_POST['caller_id'] . ' ' . 'Caller ID Blocked Succesfully! By Admin';
		} else {
			$activity_type = 'Caller Id Blocked';
			$msg = 'Caller ID: ' . $_POST['caller_id'] . ' ' . 'Caller ID Blocked Succesfully! By User';
		}
		user_activity_log($user_id, $clientId, $activity_type, $msg);
		$_SESSION['msg'] = 'Block Succesfully!'; 
			echo '<script>window.location.href="blacklist.php"</script>';
	  }
}

?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Block Numbers Information <span style="margin-left:50px;color:blue;">
								<?php echo $messages; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="blacklist.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i> Block Numbers</button></a>
						</div>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="blacklistForm" name="blacklist" action="" method="post">
								<?php

								if ($_SESSION['userroleforpage'] == '1') { ?>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-9">
											<select id="clientId" name="clientId" class="form-control selectpicker" data-show-subtext="false" data-live-search="true" required>
												<option value="" selected="selected">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($row['clientId'] == $clientId) {
														echo 'selected="selected"';
													} else {
														echo '';
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
												<option value="" selected="selected">Select</option>
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

								<?php } ?>
								<div class="row form-group">
									<div class="col col-md-3">
										<label for="text-input" class="form-control-label">Subject</label>
									</div>
									<div class="col-12 col-md-9">
										<select id="subject" name="subject" onchange="phone(this.value)"
											class="form-control" required>
											<option value="">Select</option>
											<option <?php if (isset($_POST['subject']) && $_POST['subject'] == "prefix") {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="prefix">Prefix
											</option>
											<option <?php if (isset($_POST['subject']) && $_POST['subject'] == "phonenumber") {
												echo "selected='selected'";
											} else {
												echo '';
											} ?>value="phonenumber">Phone number</option>
										</select>
									</div>
								</div>
								<div id="prefixhide" style="display:none">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Prefix</label>
										</div>
										<div class="col-12 col-md-9">
											<input name="prefix" id="prefix" placeholder="Enter prefix number"
												class="form-control" type="text" value="" />
										</div>
									</div>
								</div>

								<div id="phonehide" style="display:none">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Phonenumber</label>
										</div>
										<div class="col-12 col-md-9">
											<input name="phonenumber" id="phonenumber"
												placeholder="Enter 10 digit phone no." class="form-control"
												type="number" value="" />
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
											<option <?php if ($ruletype == "transfer") {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="transfer">Transfer</option>
											<option <?php if ($ruletype == "block") {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="block">Block</option>
										</select>
									</div>
								</div>
								<div id="transferhide" style="display:none">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">TransferNumber</label>
										</div>
										<div class="col-11 col-md-9">
											<input id="transfer" name="transfer" placeholder="Transfer Number"
												class="form-control" type="text" value="" />
										</div>
									</div>
								</div>
								<div id="blockhide" style="display:none">
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Block</label>
										</div>
										<div class="col-12 col-md-9">
											<select id="block" name="block" class="form-control">
												<option value="" selected="selected">Select</option>
												<option <?php if ($block == "busy") {
													echo "selected='selected'";
												} else {
													echo '';
												} ?> value="busy">Busy</option>
												<option <?php if ($block == "congestion") {
													echo "selected='selected'";
												} else {
													echo '';
												} ?>value="congestion">Congestion</option>
												<option <?php if ($block == "hangup") {
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
											<option <?php if (!isset($_POST['status']) || (isset($_POST['status']) && $_POST['status'] == 1)) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?> value="1">Enable</option>
											<option <?php if (isset($_POST['status']) && $_POST['status'] == 0) {
												echo "selected='selected'";
											} else {
												echo '';
											} ?>value="0">Disable</option>
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

	function phone(value) {
		if (value == 'prefix') {
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