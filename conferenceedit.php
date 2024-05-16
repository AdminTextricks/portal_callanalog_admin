<?php require_once('header.php');

$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection, $query_client);
$message = '';
if (isset($_POST['submit'])) {

	// echo '<pre>';print_r($_POST);exit;
	$user_id = $_POST['selectedUser'];
	$clientId = $_POST['clientId'];

	$created_at = date('Y-m-d h:i:s');
	$updated_at = date('Y-m-d h:i:s');
	$update_conf = "Update booking set user_id='" . $user_id . "', clientId='" . $clientId . "', confno='" . $_POST['confno'] . "', pin='" . $_POST['pin'] . "', adminpin='" . $_POST['adminpin'] . "' , maxusers='" . $_POST['maxusers'] . "', status='" . $_POST['status'] . "',confDesc='" . $_POST['confDesc'] . "',dateReq='" . $created_at . "',dateMod='" . $updated_at . "' where Id='" . $_POST['id'] . "'";

	// echo $update_conf; exit;
	$result_conf = mysqli_query($connection, $update_conf);
	if ($result_conf) {
		$activity_type = 'Conference Update';
		if ($_SESSION['userroleforpage'] == '1') {
			$msg = 'Conference No: ' . $_POST['confno'] . ' ' . 'Conference Update Succesfully! By Admin';
		} else {
			$msg = 'Conference No: ' . $_POST['confno'] . ' ' . 'Conference Update Succesfully! By User';
		}
		user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
		$_SESSION['msg'] = 'Conference Updated Succesfully!';
		echo '<script>window.location.href="conference.php"</script>';
	}

}

$user_id = '';
$clientId = '';
$confno = '';
$pin = '';
$adminpin = '';
$maxusers = '';
$status = '';
$confDesc = '';
if (isset($_GET['id']) && $_GET['id'] != '') {

	$select_conf = "select user_id,clientId,confno,pin,adminpin,maxusers, status, confDesc from booking where Id='" . $_GET['id'] . "'";
	$query_conf = mysqli_query($con, $select_conf);
	$rowcount = mysqli_num_rows($query_conf);
	if ($rowcount > 0) {
		while ($row_conf_match = mysqli_fetch_array($query_conf)) {

			// echo '<pre>';print_r($row_conf_match); exit;
			$user_id = $row_conf_match['user_id'];
			$clientId = $row_conf_match['clientId'];
			$confno = $row_conf_match['confno'];
			$pin = $row_conf_match['pin'];
			$adminpin = $row_conf_match['adminpin'];
			$maxusers = $row_conf_match['maxusers'];
			$status = $row_conf_match['status'];
			$confDesc = $row_conf_match['confDesc'];

		}

	} else { ?>
		<script>
			setInterval(() => {

				window.location.href = "conference.php";

			}, 2000);</script>
	<? }
} else { ?>
	<script>
		setInterval(() => {

			window.location.href = "conference.php";

		}, 2000);</script>
<? }


$query_user = "select * from users_login where clientId='" . $clientId . "'";
$result_user_login = mysqli_query($connection, $query_user);


if ($_SESSION['userroleforpage'] == 2 && $user_id !== $_SESSION['login_user_id']) { ?>
	<script>
		window.location = 'access_denied.php';    
	</script>
<?php }

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Conference Information<span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
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
								
								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Client Name</label>
										</div>
										<div class="col-12 col-md-8">
											<select id="clientId" data-show-subtext="false" data-live-search="true"
												name="clientId" class="form-control selectpicker ">
												<option value="0">Select</option>
												<?php while ($row = mysqli_fetch_array($result_client)) { ?>
													<option <?php if ($clientId == $row['clientId']) {
														echo 'selected="selected"';
													} ?> value="<?php echo $row['clientId']; ?>">
														<?php echo $row['clientName'].'/'.$row['clientEmail']; ?>
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
									<input id="user_id" class="form-control" name="selectedUser"
										value="<?php echo $user_id; ?>" type="hidden" />
								<?php } ?>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Conf Description*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="confDesc" name="confDesc" placeholder="" class="form-control"
											type="text" value="<?php echo $confDesc; ?>" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Conference Number</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="id" name="id" value="<?php echo $_GET['id']; ?>"
											class="form-control" type="hidden" readonly />
										<input id="confno" name="confno" placeholder="000"
											value="<?php echo $confno; ?>" class="form-control" type="text"
											readonly />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">PIN Number**</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="pin" name="pin" placeholder="10" value="<?php echo $pin; ?>"
											class="form-control" type="text" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Admin PIN Number</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="adminpin" name="adminpin" placeholder="10"
											value="<?php echo $adminpin; ?>" class="form-control" type="text" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Max Users</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="maxusers" name="maxusers" placeholder="10"
											value="<?php echo $maxusers; ?>" class="form-control" type="text" />
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Status</label>
									</div>

									<div class="col-12 col-md-8">
										<select id="status" name="status" class="form-control">
											<option <?php if ($status == 'Active') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Active">Active</option>
											<option <?php if ($status == 'Inactive') {
												echo 'selected="selected"';
											} else {
												echo '';
											} ?> value="Inactive">Inactive</option>
											<option <?php if ($status == 'Suspended') {
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
</script>
<?php require_once('footer.php'); ?>