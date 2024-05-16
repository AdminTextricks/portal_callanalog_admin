<?php require_once('header.php');
$error = $message = '';

$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);

$ringno = '';
$ringtime = '';
$stratergy = '';
$ringlist = '';
$description = '';
$ringid = '';
$user_id = '';

if (isset($_GET['id']) && $_GET['id'] != '') {
	$query_ring = "select * from cc_ring_group where id='" . $_GET['id'] . "'";
	$result_ring = mysqli_query($connection, $query_ring);

	while ($row_ring = mysqli_fetch_assoc($result_ring)) {
		//print_r($row_ring);
		$ringno = $row_ring['ringno'];
		$ringtime = $row_ring['ringtime'];
		$stratergy = $row_ring['strategy'];
		$ringListArray = explode('-', $row_ring['ringlist']);

		$ringlist = $row_ring['ringlist'];
		$description = $row_ring['description'];
		$ringid = $row_ring['id'];
		$user_id = $row_ring['user_id'];
		$clientId = $row_ring['clientId'];
	}

} else {
	$error = 'true';
}

//echo '<pre>'; print_r($_SESSION);exit;
if (isset($_POST['submit'])) {
	//echo '<pre>';print_r($_POST);exit;
	//$user_id = $_SESSION['login_user_id'];		
	$selectedRingList = '';
	$created_at = date('Y-m-d h:i:s');
	$updated_at = date('Y-m-d h:i:s');

	if (isset($_POST['selectedUser'])) {
		$selectedUser = $_POST['selectedUser'];
	}
	if ($user_id !== $_POST['selectedUser']) {
		$update_ring_manage = "UPDATE cc_ring_group SET ringlist = '' where id = '" . $_POST['id'] . "'";
		mysqli_query($connection, $update_ring_manage);
	}

	$update_ring = "Update cc_ring_group set clientId='" . $_POST['clientId'] . "', user_id='" . $selectedUser . "', strategy='" . $_POST['stratergy'] . "', ringtime='" . $_POST['ringtime'] . "' , description='" . $_POST['description'] . "' where id ='" . $_POST['id'] . "'";

	if (mysqli_query($connection, $update_ring)) {
		$activity_type = 'Ring Update';
		if ($_SESSION['userroleforpage'] == '1') {
			$msg = 'Ring No: ' . $_POST['ringno'] . ' ' . 'Ring Update Succesfully! By Admin';
		} else {
			$msg = 'Ring No: ' . $_POST['ringno'] . ' ' . 'Ring Update Succesfully! By User';
		}
		user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
		$_SESSION['msg'] = 'Ring Updated Succesfully!';
		echo '<script>window.location.href="ring.php"</script>';
	}

}

if ($error == 'true') {
	$message = 'Ring Updated Succesfully!';
	header("Location: ringedit.php?id='" . $_GET['id'] . "'");
}


if ($_SESSION['userroleforpage'] == 2 && $user_id !== $_SESSION['login_user_id']) { ?>
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
						<h2 class="title-1"> Ring Information<span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="ring.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-tty" aria-hidden="true"></i> Ring</button>
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

								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker">
												<option value="0">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($clientId == $row['clientId']) {
														echo 'selected="selected"';
													} ?> value="<?php echo $row['clientId']; ?>">
														<?php echo $row['clientName'].'/'.$row['clientEmail'];; ?>
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
											<!--<div>Use Ctrl Key to Select Multiple Users.</div>-->
											<select id="selectedUser" name="selectedUser" class="form-control">
												<?php while ($row_user = mysqli_fetch_array($result_user_login)) { ?>
													<option <?php if ($user_id == $row_user['id']) {
														echo 'selected="selected"';
													} ?> value="<?php echo $row_user['id']; ?>">
														<?php echo $row_user['name']; ?>
													</option>
												<?php } ?>
											</select><input type="hidden" name="_selectedUser" value="1" />
										</div>
									</div>
								<?php } else { ?>
									<input type="hidden" class="form-control" id="clientId" name="clientId"
										value="<?php echo $clientId; ?>" />
									<input id="selectedUser" class="form-control" name="selectedUser"
										value="<?php echo $user_id; ?>" type="hidden" />
								<?php } ?>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Ring Group Name*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="description" name="description" placeholder="" class="form-control"
											type="text" value="<?php echo $description; ?>" />

										<input id="id" name="id" placeholder="" class="form-control" type="hidden"
											value="<?php echo $ringid; ?>" />
										<input id="user_id" name="user_id" placeholder="" class="form-control"
											type="hidden" value="<?php echo $user_id; ?>" />

									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Ring Group Extension</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="ringno" name="ringno" placeholder="000"
											value="<?php echo $ringno; ?>" class="form-control" type="text" readonly />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Ring Timeout**</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="ringtime" name="ringtime" placeholder="10"
											value="<?php echo $ringtime; ?>" class="form-control" type="text" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="selectSm" class=" form-control-label">Strategy</label>
									</div>

									<div class="col-12 col-md-8">
										<select id="stratergy" name="stratergy" class="form-control-sm form-control" required>
											<option <?php if ($stratergy == '0') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="0">Select</option>
											<option <?php if ($stratergy == 'ringall') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="ringall">Ringall</option>
											<option <?php if ($stratergy == 'simultaneous') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="simultaneous">Simultaneous</option>
											<option <?php if ($stratergy == 'rollover') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="rollover">Rollover</option>
											<option <?php if ($stratergy == 'random') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="random">Random</option>
											<option <?php if ($stratergy == 'sequence') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="sequence">Sequence</option>
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
</script>

<?php require_once('footer.php'); ?>