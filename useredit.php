<?php
require_once ('header.php');
include 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$user_id = $_GET['id'];

$phoneErr = $did_provider = '';
$select_cc_card = "SELECT lastname, `address`, `state`, tariff, country, phone, email, zipcode, `status` FROM `cc_card` WHERE `id`='" . $user_id . "'";
$result1 = mysqli_query($connection, $select_cc_card);
if (mysqli_num_rows($result1) > 0) {
	$rows = mysqli_fetch_assoc($result1);
	$fetch_name = $rows['lastname'];
	$fetch_address = $rows['address'];
	$fetch_state = $rows['state'];
	$fetch_country = $rows['country'];
	$fetch_outbound = $rows['tariff'];
	$fetch_phone = $rows['phone'];
	$fetch_email = $rows['email'];
	$fetch_zipcode = $rows['zipcode'];
	$fetch_status = $rows['status'];

}

$select_users_login = "SELECT * FROM `users_login` WHERE `id`='" . $user_id . "'";

$result_users_login = mysqli_query($connection, $select_users_login) or die("query failed");
if (mysqli_num_rows($result_users_login) > 0) {
	$rowss = mysqli_fetch_assoc($result_users_login);
	$fetch_plan = $rowss['plan_id'];
	$fetch_role = $rowss['role'];
	$clientId = $rowss['clientId'];
	$status = $rowss['status'];
	$fetch_timezones = $rowss['timezone'];
	$fetch_did_provider = $rowss['did_permission'];
}

$did_provider = $fetch_did_provider;

$client = "SELECT * FROM `Client` WHERE `clientid`= '" . $clientId . "'";
$res = mysqli_query($connection, $client);
if (mysqli_num_rows($res) > 0) {
	$raws = mysqli_fetch_assoc($res);
	$fetch_companyname = $raws['clientName'];
}


if (isset($_POST['update'])) {

	$error = 'false';
	$name = $_POST['name'];
	$address = $_POST['address'];
	$country = $_POST['country'];
	$state = $_POST['state'];
	$timezone = $_POST['timezone'];
	$company_name = $_POST['companyname'];
	$outbound = $_POST['outbound'];
	$phone = $_POST['country_prefix'] . $_POST['phone'];
	$email = $_POST['email'];
	//$to = $_POST['email'];
	$zipcode = $_POST['zipcode'];
	$status = $_POST['status'];

	if (isset($_POST['did_permission'])) {
		$did_provider = implode(",", $_POST['did_permission']);
		$did_permission = $did_provider;
	} else {
		$message = "Please Select atleast one DID permission..!!";
		$error = 'true';
		$did_provider = '';
	}

	if ($_POST['status'] == 'Active') {
		$cc_status = '1';
	} else {
		$cc_status = '0';
	}
	if ($outbound == 1) {
		$tariff = $_POST['trunks'];
	} else {
		$tariff = '0';
	}
	$trunk_id = '';
	//  $image = $_POST['profile_image'];
	$sizeErr = '';
	$fileErr = '';
	$filename = '';
	// $name = '';
	$filename = $_FILES["profile_image"]["name"];

	if ($filename != '') {
		$tempname = $_FILES["profile_image"]["tmp_name"];
		$folder = "profile_image/" . $user_id . "_" . $filename;
		$imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		// echo $imageFileType; exit;
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 300000) {
			$sizeErr = "Sorry, your Image size is too large";
			$error = 'true';
		}
		// // Allow certain file formats
		if ($imageFileType !== "jpg" && $imageFileType !== "png" && $imageFileType !== "jpeg") {
			$fileErr = "Sorry, only JPG, JPEG, PNG  files are allowed";
			$error = 'true';
		}
	}

	if ($_SESSION['userroleforpage'] == 1 && $_POST['email'] != $fetch_email) {
		$email = $_POST['email'];
	} else {
		$email = $fetch_email;
	}

	if ($error == 'false') {

		if ($fetch_role == '3') {

			if ($filename != '') {
				move_uploaded_file($tempname, $folder);
				$query1 = "UPDATE `users_login` SET `email` = '" . $email . "', `name` = '" . $name . "',`timezone` = '" . $timezone . "', `profile_image` = '" . $filename . "',`did_permission`='" . $did_permission . "' WHERE `id`='" . $user_id . "'";
			} else {
				$query1 = "UPDATE `users_login` SET `email` = '" . $email . "',`timezone` = '" . $timezone . "', `name` = '" . $name . "',`did_permission`='" . $did_permission . "'  WHERE `id`='" . $user_id . "'";
			}
			mysqli_query($connection, $query1) or die("query failed");

			$sel_sql = "SELECT `id` FROM `users_login` WHERE `clientId` = '" . $clientId . "' and deleted = '0'";
			$res_sql = mysqli_query($connection, $sel_sql) or die("query failed : sel_sql");
			if (mysqli_num_rows($res_sql) > 0) {
				while ($rowsuser = mysqli_fetch_assoc($res_sql)) {
					$userId[] = $rowsuser['id'];
				}
			}
			$userIds = implode(",", $userId);
			$update_card = "UPDATE `cc_card` SET `status` = '" . $cc_status . "' WHERE `id` IN (" . $userIds . ")";
			$result_card = mysqli_query($connection, $update_card) or die("query failed : update_card");
			$update_users = "UPDATE `users_login` SET `status` = '" . $status . "' WHERE `clientId` = '" . $clientId . "' and deleted = '0'";
			$result_users = mysqli_query($connection, $update_users) or die("query failed : update_users");

			$query2 = "UPDATE `cc_card`  SET `lastname` = '" . $name . "', `firstname`='" . $name . "',`address` = '" . $address . "',`state`='" . $state . "',`country`='" . $country . "',`zipcode`='" . $zipcode . "',`tariff` = '" . $tariff . "',`phone`='" . $phone . "', `email` = '" . $email . "',`trunk_id` = '" . $trunk_id . "' WHERE `id`='" . $user_id . "'";
			mysqli_query($connection, $query2) or die("query failed");

			$query3 = "UPDATE `Client` SET `phone` = '" . $phone . "', `clientEmail` = '" . $email . "', `supportEmail` = '" . $email . "' WHERE `clientid` = '" . $clientId . "'";
			mysqli_query($connection, $query3) or die("query failed");

			if ($_POST['price_change'] == '1') {
				$update_did_price = "update cc_did_exten_price set price='" . $_POST['did_price'] . "' where user_id='" . $user_id . "' and type='did'";
				mysqli_query($connection, $update_did_price) or die("query failed : update_did_price");

				$update_ext_price = "update cc_did_exten_price set price='" . $_POST['ext_price'] . "' where user_id='" . $user_id . "' and type='extension'";
				mysqli_query($connection, $update_ext_price) or die("query failed : update_ext_price");
			}

		} else {

			if ($filename != '') {
				move_uploaded_file($tempname, $folder);
				$query1 = "UPDATE `users_login` SET `email` = '" . $email . "', `name` = '" . $name . "',`timezone` = '" . $timezone . "',`status` = '" . $status . "',`profile_image` = '" . $filename . "',`did_permission`='" . $did_permission . "' WHERE `id`='" . $user_id . "'";
			} else {
				$query1 = "UPDATE `users_login` SET `email` = '" . $email . "', `name` = '" . $name . "',`timezone` = '" . $timezone . "',`status` = '" . $status . "',`did_permission`='" . $did_permission . "'  WHERE `id`='" . $user_id . "'";
			}
			mysqli_query($connection, $query1) or die("query failed");


			$query2 = "UPDATE `cc_card`  SET `lastname` = '" . $name . "', `firstname`='" . $name . "',`status`= '" . $cc_status . "',`address` = '" . $address . "',`state`='" . $state . "',`country`='" . $country . "',`zipcode`='" . $zipcode . "',`tariff` = '" . $tariff . "',`phone`='" . $phone . "', `email` = '" . $email . "',`trunk_id` = '" . $trunk_id . "' WHERE `id`='" . $user_id . "'";
			mysqli_query($connection, $query2) or die("query failed");

			$query3 = "UPDATE `Client` SET `phone` = '" . $phone . "', `clientEmail` = '" . $email . "', `supportEmail` = '" . $email . "' WHERE `clientid` = '" . $clientId . "'";
			mysqli_query($connection, $query3) or die("query failed");

		}
		$_SESSION['msg'] = 'Data updated successfully.';
		echo '<script>window.location.href="users.php"</script>';
	}
}
if ($_SESSION['userroleforpage'] == 1 && isset($_POST['email']) && $_POST['email'] != $fetch_email) {
	$mail = new PHPMailer(true);
	try {
		$mail->isSMTP();
		$mail->Host = HOST;
		$mail->SMTPAuth = true;
		$mail->Username = EMAIL;
		$mail->Password = PASSWORD;
		$mail->SMTPSecure = 'tls';
		$mail->Port = PORT;

		$mail->setFrom(EMAIL, CALLANALOG);
		$mail->addAddress($fetch_email);
		$mail->addAddress($email);

		$mail->isHTML(true);
		$mail->Subject = 'Email Address Changed';
		$mail->Body = 'Dear ' . $name . ',<br><br>' .
			'This is to inform you that your email address has been successfully changed from ' . $fetch_email . ' to ' . $email . ' by the Admin.<br>' .
			'Old Email: ' . $fetch_email . '<br>' .
			'New Email: ' . $email . '<br><br>' .
			'Best regards,<br>' .
			'Team Callanalog';
		$mail->AltBody = 'Body in plain text for non-HTML mail clients';
		$mail->send();
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}



if ($_SESSION['userroleforpage'] == 2 && $rowss['id'] !== $_SESSION['login_user_id']) { ?>
	<script>
		window.location = 'access_denied.php';    
	</script>
<?php } ?>

<head>
	<style>
		label.form-control-label.text-black {
			color: black;
			font-weight: 400;
		}
	</style>
</head>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">Edit User Information<span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<?php if ($_SESSION['userroleforpage'] == 1) { ?>
							<div class="table-data__tool-right">
								<a href="users.php">
									<button class="au-btn au-btn-icon au-btn--green au-btn--small">
										<i class="fa fa-eye" aria-hidden="true"></i> User</button></a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-9">
							<div class="queue_info">
								<form id="userForm" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>"
									method="post" enctype="multipart/form-data">
									<input id="user_id" name="user_id" value="<?php if (isset($_GET['id'])) {
										echo $_GET['id'];
									} else {
										echo '';
									} ?>" class="form-control" type="hidden" />
									<?php if ($_SESSION['userroleforpage'] == 3) { ?>
										<input id="role" name="role" value="3" class="form-control" type="hidden" />
									<?php } ?>
									<?php if ($_SESSION['userroleforpage'] == 2) { ?>
										<input id="role" name="role" value="2" class="form-control" type="hidden" />
									<?php } ?>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<input id="role" name="role" value="1" class="form-control" type="hidden" />
									<?php } ?>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<div class="row form-group barge_radio_btn">
											<div class="col col-md-3">
												<label class=" form-control-label">Reseller </label>
											</div>
											<div class="col col-md-9">
												<div class="form-check-inline form-check">
													<label for="tariff1" class="form-check-label"
														style="margin-right:15px; color:black;">
														<input id="tariff1" name="reseller_role" class="form-check-input"
															type="radio" value="3" <?php if ($fetch_role == 3) {
																echo "checked";
															} ?>>
														Yes
													</label>
													<label for="tariff2" class="form-check-label" style="color:black;">
														<input id="tariff2" name="reseller_role" class="form-check-input"
															type="radio" value="2" <?php if ($fetch_role == 2) {
																echo "checked";
															} ?>>
														No
													</label>
												</div>

											</div>
										</div>
									<?php } ?>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">Name</label>
										</div>
										<div class="col-12 col-md-9">
											<input id="fname" name="name" placeholder="Name" class="form-control"
												type="text" value="<?php echo $fetch_name; ?>" />
											<span style="color:red;">
												<?php //echo $nameErr;      ?>
											</span>
										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">Address*</label>
										</div>
										<div class="col-12 col-md-9">
											<input id="address" name="address" placeholder="address"
												class="form-control" type="text"
												value="<?php echo $fetch_address; ?>" />
											<span style="color:red;">
												<?php //echo $addressErr;      ?>
											</span>
										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">Country</label>
										</div>
										<div class="col-12 col-md-9">
											<?php
											$select_country = "SELECT * FROM `cc_country`";
											$result_country = mysqli_query($connection, $select_country) or die("query failed");
											if (mysqli_num_rows($result_country) > 0) {
												?>
												<select name="country" id="country" class="form-control">
													<option value="">Select</option>
													<?php while ($row = mysqli_fetch_assoc($result_country)) {
														if ($row['countrycode'] == $fetch_country) {
															$countryCode = $row['countrycode'];
															$countryPrefix = $row['countryprefix'];
															$fetch_phone = str_replace('+' . $countryPrefix, '', $fetch_phone);
															$select = "selected";
														} else {
															$select = "";
														}
														?>
														<option <?php echo $select; ?>
															value="<?php echo $row['countrycode'] ?>">
															<?php echo $row['countryname'] ?>
														</option>
													<?php } ?>
												</select>
											<?php } ?>

										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">State</label>
										</div>
										<div class="col-12 col-md-9">
											<select name="state" id="state" class="form-control">
												<option value="">---Select State---</option>
												<?php
												$state_query = "SELECT distinct(`State`) FROM `state_stdcode` WHERE `countryCode` = '$countryCode'";
												$result_state = mysqli_query($connection, $state_query) or die("query failed");
												if (mysqli_num_rows($result_state) > 0) {
													while ($state_row = mysqli_fetch_assoc($result_state)) {
														$states = $state_row['State'];
														if ($state_row['State'] == $fetch_state) {
															$select = "selected";
														} else {
															$select = "";
														}
														?>
														<option value="<?php echo $state_row['State'] ?>" <?php echo $select; ?>>
															<?php echo $state_row['State'] ?>
														</option>
														<?php
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">TimeZone</label>
										</div>
										<div class="col-12 col-md-9">
											<select name="timezone" id="timezone" class="form-control">
												<option value="">---Select Timezone---</option>
												<?php foreach ($timezones as $values) {
													if ($fetch_timezones == $values) {
														$select = "selected";
													} else {
														$select = "";
													}
													?>
													<option <?php echo $select; ?> value="<?php echo $values; ?>">
														<?php echo $values; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">CompanyName</label>
										</div>
										<div class="col-12 col-md-9">
											<input id="companyname" readonly name="companyname"
												placeholder="company name" class="form-control" type="text"
												value="<?php echo $fetch_companyname; ?>" />

										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class=" form-control-label">Plan Type</label>
										</div>
										<div class="col-12 col-md-9">
											<?php
											$plan_sql = "SELECT * FROM `master_plans`";
											$result_sql = mysqli_query($connection, $plan_sql) or die("query failed");
											if (mysqli_num_rows($result_sql) > 0) {
												?>
												<span style="font-size:12px;">You can't Change plan</span>
												<select disabled name="plan" id="plan" class="form-control">
													<option value="">---Select Plan---</option>
													<?php while ($plan_row = mysqli_fetch_assoc($result_sql)) {
														$plan_id = $plan_row['id'];
														if ($fetch_plan == $plan_row['id']) {
															$select = "selected";
														} else {
															$select = "";
														}
														?>
														<option <?php echo $select ?> value="<?php echo $plan_row['id']; ?>">
															<?php echo $plan_row['name']; ?>
														</option>
													<?php } ?>
												</select>
											<?php } ?>
										</div>
									</div>
									<?php if ($_SESSION['userroleforpage'] == 1) { ?>
										<div class="row form-group barge_radio_btn">
											<div class="col col-md-3">
												<label class=" form-control-label">Outbound Call</label>
											</div>
											<div class="col col-md-9">
												<div class="form-check-inline form-check">
													<label for="outbound1" class="form-check-label "
														style="margin-right:15px;color: black;">
														<input id="outbound1" name="outbound" name="inline-radios" <?php if ((isset($_POST['outbound']) && $_POST['outbound'] == '1') || (!isset($_POST['outbound']) && $fetch_outbound != '0')) {
															echo 'checked="true"';
														} else {
															echo '';
														} ?> class="form-check-input" type="radio" value="1" />Yes
													</label>
													<label for="outbound2" class="form-check-label "
														style="margin-right:15px;color: black;">
														<input id="outbound2" name="outbound" name="inline-radios" <?php if ((isset($_POST['outbound']) && $_POST['outbound'] == '0') || (!isset($_POST['outbound']) && $fetch_outbound == '0')) {
															echo 'checked="true"';
														} else {
															echo '';
														} ?> class="form-check-input" type="radio" value="0" />No
													</label>
												</div>
											</div>
										</div>
										<?php

										if ((!isset($_POST['outbound']) && $fetch_outbound != 0) || (isset($_POST['outbound']) && $_POST['outbound'] == 1)) {
											$trunk_class = "block";
										} else {
											$trunk_class = "none";
										}

										?>
										<?php // if (!isset($_POST['outbound']) ||(isset($_POST['outbound']) && $_POST['outbound'] == 1)) {
											?>
										<div class="row form-group trunks" style="display:<?php echo $trunk_class; ?>;">
											<div class="col col-md-3">
												<label for="text-input" class="form-control-label">Tarrif Plans</label>
											</div>
											<div class="col col-md-9">
												<select id="trunks" name="trunks" class="form-control">
													<option value="">---Select---</option>
													<?php $trunk_sql = "select * from ratecard_group";
													$trunk_res = mysqli_query($connection, $trunk_sql) or die("query failed : trunk_sql");
													if (mysqli_num_rows($trunk_res) > 0) {
														while ($trunk_row = mysqli_fetch_assoc($trunk_res)) {
															if (($_POST['trunks'] == $trunk_row['id']) or ($fetch_outbound == $trunk_row['id'])) {
																$select = "selected";
															} else {
																$select = "";
															}
															?>
															<option <?php echo $select; ?> value="<?php echo $trunk_row['id']; ?>">
																<?php echo $trunk_row['group_name']; ?>
															</option>
														<?php }
													}
													?>
												</select>
											</div>
										</div>
										<?php  //}      ?>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="text-input" class=" form-control-label">Status</label>
											</div>
											<div class="col-12 col-md-9">
												<select name="status" class="form-control ">
													<option value="">Select</option>
													<option value="Active" <?php
													if ($status == 'Active') {
														echo "selected";
													}
													?>>Active</option>
													<option value="Inactive" <?php
													if ($status == 'Inactive') {
														echo "selected";
													}
													?>>Inactive</option>
												</select>

											</div>
										</div>

										<div class="row form-group">
											<div class="col col-md-3">
												<label for="text-input" class=" form-control-label">DID Permission</label>
											</div>
											<div class="col-12 col-md-9">
												<?php
												$i = 1;
												$query_did = "select carrier_name from server_carriers";
												$result_did = mysqli_query($connection, $query_did) or die("query failed : query_did");
												if (mysqli_num_rows($result_did) > 0) {
													while ($did_row = mysqli_fetch_assoc($result_did)) {
														$did_carrier_provider[] = $did_row['carrier_name'];
													}
												}
												foreach ($did_carrier_provider as $value) { ?>
													<input type="checkbox" name="did_permission[]" value="<?php echo $value; ?>"
														id="did_permission<?php echo $i; ?>" <?php if ($did_provider != '') {
															   $did_permission = explode(',', $did_provider);
															   if (in_array($value, $did_permission)) {
																   echo 'checked=true';
															   }
														   } ?>>
													<label for="did_permission<?php echo $i; ?>" style="color:black;">
														<?php echo $value; ?>
													</label>
													<?php
													$i++;
												}
												?>
											</div>
										</div>
									<?php } else { ?>
										<input name="status" value="<?php echo $status ?>" type="hidden">
									<?php } ?>
									<div class="row form-group">
										<div class="col col-md-3">
											<style>
												input::-webkit-outer-spin-button,
												input::-webkit-inner-spin-button {
													-webkit-appearance: none;
													margin: 0;
												}
											</style>
											<label for="text-input" class="form-control-label">Phone</label>
										</div>
										<div class="col-12 col-md-9 row">
											<div class="col-sm-3">
												<input id="country_prefix" name="country_prefix" placeholder=""
													class="form-control" type="text"
													value="+<?php echo $countryPrefix; ?>" />
											</div>
											<div class="col-sm-9">
												<input id="phone" name="phone" placeholder="phone" class="form-control"
													type="number" value="<?php echo $fetch_phone; ?>" />
												<span style="color:red;">
													<?php echo $phoneErr; ?>
												</span>
											</div>
										</div>
									</div>

									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input" class="form-control-label">Email</label>
										</div>
										<div class="col-12 col-md-9">
											<?php if ($_SESSION['userroleforpage'] == 1) { ?>
												<input id="email" name="email" placeholder="Email" class="form-control"
													type="text" value="<?php echo $fetch_email ?>" />
												<span style="color:red;">
													<?php //echo $emailErr;      ?>
												</span>
											<?php } else { ?>
												<input id="email" name="email" placeholder="Email" class="form-control"
													type="text" value="<?php echo $fetch_email ?>" readonly />
											<?php } ?>
										</div>

									</div>



									<div class="row form-group">
										<div class="col col-md-3">
											<label for="text-input"
												class="form-control-label text-black">Zipcode</label>
										</div>
										<div class="col-12 col-md-9">
											<input id="ZIP" name="zipcode" placeholder="ZIP CODE" class="form-control"
												type="number" value="<?php echo $fetch_zipcode ?>" />
											<span style="color:red;">

											</span>
										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-3">
											<label class="form-control-label text-black">Profile Image</label>
										</div>
										<div class="col-12 col-md-9">
											<input id="profile_image" name="profile_image"
												placeholder="update your image" class="form-control" type="file" />
											<?php
											if (isset($_FILES["profile_image"]["name"]) && $_FILES["profile_image"]["name"] != '' && $error == 'true') {
												echo "<span style='color:red;'>" . $sizeErr . "</span>";
												echo "<span style='color:red;'>" . $fileErr . "</span>";
												?>
											<?php }
											?>
											<div class="col-12 col-md-9" id="profile_image_div">
												<?php
												//echo '<pre>'; print_r($rowss); echo '</pre>';
												if ($rowss['profile_image'] != '') {
													$folder = "profile_image/" . $user_id . "_" . $rowss['profile_image'];

													echo "<img src ='$folder' height='100px' width='100px'>";
													?>
													<button type="button" class="btn btn-danger btn-sm" id="delete-btn"
														user_id="<?php echo $rowss['id']; ?>">Remove Image </button>
												<?php }
												?>
											</div>
										</div>
									</div>
									<div class="alert alert-danger" id="error-message" style="display:none;"></div>
									<div class="alert alert-success" id="success-message" style="display:none;"></div>

									<?php
									if ($_SESSION['userroleforpage'] == 1 && $fetch_role == 3) {

										?>
										<div class="row form-group">
											<div class="col col-md-3">
												<label for="text-input" class=" form-control-label">Change Price</label>
											</div>
											<div class="col-12 col-md-9">
												<label for="change_yes" class="form-check-label "
													style="margin-right:15px;color: black;">
													<input id="change_yes" name="price_change" name="inline-radios" <?php if ((isset($_POST['price_change']) && $_POST['price_change'] == '1')) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> class="form-check-input" type="radio" value="1" /> Yes
												</label>
												<label for="change_no" class="form-check-label "
													style="margin-right:15px;color: black;">
													<input id="change_no" name="price_change" name="inline-radios" <?php if ((isset($_POST['price_change']) && $_POST['price_change'] == '0') || !isset($_POST['price_change'])) {
														echo 'checked="true"';
													} else {
														echo '';
													} ?> class="form-check-input" type="radio" value="0" /> No
												</label>
											</div>
										</div>
										<?php
										$sql_price = "select `price`,`type` from `cc_did_exten_price` where `user_id`='" . $user_id . "'";
										$res_price = mysqli_query($connection, $sql_price) or die("query failed : sql_price");
										if (mysqli_num_rows($res_price) > 0) {
											while ($price_row = mysqli_fetch_assoc($res_price)) {
												$price[] = $price_row['price'];
												$type[] = $price_row['type'];
											}
										}
										?>
										<div id="price">
											<div class="row form-group">
												<div class="col col-md-3">
													<label for="text-input" class=" form-control-label">Extension
														Price</label>
												</div>
												<div class="col-12 col-md-9">
													<input id="ext_price" name="ext_price" placeholder="Extension Price"
														class="form-control price_change" type="number" value="<?php if ($type[1] == 'extension') {
															echo $price[1];
														} else {
															echo $price[0];
														}
														?>" readonly />
												</div>
											</div>

											<div class="row form-group">
												<div class="col col-md-3">
													<label for="text-input" class=" form-control-label">DID Price</label>
												</div>
												<div class="col-12 col-md-9">
													<input id="did_price" name="did_price" placeholder="DID Price"
														class="form-control price_change" type="number" value="<?php if ($type[0] == 'did') {
															echo $price[0];
														} else {
															echo $price[1];
														}
														?>" readonly />
												</div>
											</div>
										</div>
										<?php
									}
									?>

									<div class="form-group pull-right">
										<button type="submit" name="update"
											class="btn btn-primary btn-sm">Update</button>
									</div>
									<p style="color:blue;"></p>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			function loadState(country_code) {
				$.ajax({
					url: "state-load.php",
					type: "POST",
					data: { country_code: country_code },
					success: function (data) {
						$("#state").html(data);
					}
				});
			}

			function countryPrefix(country_code) {
				$.ajax({
					url: "countryPrefix.php",
					type: "POST",
					data: { country_code: country_code },
					success: function (data) {
						$("#country_prefix").val(data);
					}
				});
			}

			$("#country").on("change", function () {
				var country = $("#country").val();
				loadState(country);
				countryPrefix(country);
			});


			$("input[name='outbound']").change(function () {

				if ($("input[name='outbound']:checked").val() == 1) {
					$('.trunks').css('display', 'block');
				} else {
					$('.trunks').css('display', 'none');
				}
			});


			$("input[name='price_change']").change(function () {
				if ($("input[name='price_change']:checked").val() == 1) {
					$('.price_change').removeAttr('readonly');
				} else {
					$('.price_change').attr('readonly', true);
				}
			});
		});

		$(document).on("click", " #delete-btn", function () {
			if (confirm("Do you really want to delete this image?")) {
				var user_id = $(this).attr("user_id");
				$.ajax({
					url: "pdelete.php",
					type: "POST",
					data: { id: user_id },
					success: function (data) {
						if (data == 1) {
							$('#profile_image_div').fadeOut();
							$("#success-message").html("Image Deleted").slideDown();
							$("#error-message").slideUp();
						} else {
							$("#error-message").html("cant delete image").slideDown();
							$("#success-message").slideUp();
						}
					}
				});
			}
		});	
	</script>
</div>
<br>
<?php require_once ('footer.php'); ?>