<?php require_once('header.php'); ?>

<?php
if ($_SESSION['userroleforpage'] == 1) {
	$query_client = "select * from Client";
} else {
	$query_client = "select * from Client where clientId='" . $_SESSION['userroleforclientid'] . "'";
}
$result_client = mysqli_query($connection, $query_client);
$message = $msg = $msg_pass = '';

if (isset($_POST['submit'])) {
	$company_name = $_POST['companyname'];
	$billing_address = $_POST['billing_address'];
	$plan_id = $_POST['plan_id'];
	$name = $_POST['name'];
	$state = $_POST['state'];
	$country_code = $_POST['country'];
	$zip = $_POST['zipcode'];
	$phone = $_POST['phone'];
	$reseller_role = $_POST['reseller_role'];
	$email = $_POST['email'];
	$didPrice = $_POST['didPrice'];
	$extensionPrice = $_POST['extensionPrice'];
	$error = 'false';
	$exist_company_sql = "SELECT `clientName` FROM `Client` WHERE `clientName` = '" . $company_name . "'";
	$exist_company_result = mysqli_query($connection, $exist_company_sql) or die("query failed : exist_company_sql");
	if (mysqli_num_rows($exist_company_result) > 0) {
		$msg = "Company Name Already Exist";
	} else {
		if ($reseller_role == 3) {
			$countryQry = "select `id` from `cc_country` where countrycode = '" . $country_code . "'";
			$resCountry = mysqli_query($connection, $countryQry) or die("query failed : countryQry");
			if (mysqli_num_rows($resCountry) > 0) {
				$crow = mysqli_fetch_assoc($resCountry);
				$countryId = $crow['id'];
			}

			$fileExtArr = array('jpg', 'jpeg', 'png', 'webp', 'pdf');
			// Process file_one
			$file_one1 = $_FILES["file_one"]["name"];
			$fileExt1 = strtolower(pathinfo($file_one1, PATHINFO_EXTENSION));
			$file_one = "one" . $accountcode.date('Ymdhis') . $file_one1;
			$tempname_one = $_FILES["file_one"]["tmp_name"];
			$folder_one = "upload/" . $file_one;

			// Process file_two
			$file_two2 = $_FILES["file_two"]["name"];
			$fileExt2 = strtolower(pathinfo($file_two2, PATHINFO_EXTENSION));
			$file_two = "two" . $accountcode.date('Ymdhis') . $file_two2;
			$tempname_two = $_FILES["file_two"]["tmp_name"];
			$folder_two = "upload/" . $file_two;

			// Process file_three
			$file_three3 = $_FILES["file_three"]["name"];
			$fileExt3 = strtolower(pathinfo($file_three3, PATHINFO_EXTENSION));
			$file_three = "three" . $accountcode.date('Ymdhis') . $file_three3;
			$tempname_three = $_FILES["file_three"]["tmp_name"];
			$folder_three = "upload/" . $file_three;
			if (!in_array($fileExt1, $fileExtArr) or !in_array($fileExt2, $fileExtArr) or !in_array($fileExt3, $fileExtArr)) {
				$error = 'true';
				$message = "Please Upload only JPG, JPEG, PNG, WEBP, PDF format only..!!";
			}
		}
		if ($error == 'false') {
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$message = "Invalid email format";
			} else {
				$created_at = date('Y-m-d h:i:s');
				$username = getAccountcode();
				
				if ($_POST['password'] == $_POST['confirmPassword']) {
					$password = md5($_POST['password']);
					if ($_POST['outbound_call'] == 1) {
						$tariff = $_POST['trunks'];
					} else {
						$tariff = '';
					}
					$trunk_id = '';
					$select_email = "select email from users_login where email = '" . $_POST['email'] . "'";
					$result_email = mysqli_query($connection, $select_email) or die("query failed : select_email");
					$email_num = mysqli_num_rows($result_email);
					if ($email_num <= 0) {

						$insert_company = "INSERT INTO `Client` (`clientEmail`,`clientEmailPass`,`createDate`,`clientName`,`loginPass`,`phone`,`supportEmail`) VALUES ('" . $email . "','" . $password . "','" . $created_at . "','" . $company_name . "','" . $password . "','" . $phone . "','" . $email . "')";

						$result_company = mysqli_query($connection, $insert_company) or die("query failed : insert_company");
						$clientId = mysqli_insert_id($connection);

						$insert_users = "INSERT INTO `cc_card` (`firstusedate`,`expirationdate`,`username`,`useralias`,`uipass`,`tariff`,`lastname`,`firstname`,`address`,`state`,`country`,`zipcode`,`phone`,`email`,`simultaccess`,`restriction`,`trunk_id`) VALUES ('" . $created_at . "','" . $created_at . "','" . $username . "','" . $username . "','" . $password . "','" . $tariff . "','" . $name . "','" . $name . "','" . $billing_address . "','" . $state . "','" . $country_code . "','" . $zip . "','" . $phone . "','" . $email . "','1','0','" . $trunk_id . "')";
						// echo $insert_users;
						// exit;
						$result_users = mysqli_query($connection, $insert_users) or die("query failed : result_users");

						$lastuserID = mysqli_insert_id($connection);

						$insert_loginuser = "insert into users_login (createDate,modifyDate,email,name,password,role,status,clientId,plan_id,mobile_verify_status,email_verify_status) values ('" . $created_at . "', '" . $created_at . "', '" . $email . "','" . $_POST['name'] . "','" . $password . "','" . $reseller_role . "','Active','" . $clientId . "','" . $plan_id . "', '1', '1')";
						$result_loginuser = mysqli_query($connection, $insert_loginuser) or die("query failed : insert_loginuser");

						// echo"<pre>";print_r($insert_loginuser);die;

						$lastuserID = mysqli_insert_id($connection);

						/********* Proxy server insert Start */

						if ($lastuserID % 2 == 0) {
							$server_id = '1';
							$server_name = 'Callanalog_Server1';
							$server_ip = '37.61.219.110';
							$sip_port = '50070';
							$asterisk_version = '18.20.0';
						} else {
							$server_id = '2';
							$server_name = 'CallAnalog_server2';
							$server_ip = '85.195.76.161';
							$sip_port = '50070';
							$asterisk_version = '18.20.0';
						}
						$ddate = date('Y-m-d H:i:s');
						$max_calls = '1000';
						$query4 = "INSERT INTO `cc_servers`(`server_id`,`user_id`,`server_name`,`server_ip`,`sip_port`,`asterisk_version`,`max_calls`,`active`,`created_at`, `updated_at`) VALUES ('" . $server_id . "','" . $lastuserID . "','" . $server_name . "','" . $server_ip . "','" . $sip_port . "','" . $asterisk_version . "','" . $max_calls . "','Y','$ddate','$ddate')";

						$result4 = mysqli_query($connection, $query4) or die("query failed.111");

						/********* Proxy server insert end */



						if ($reseller_role == 3) {
							$insert_price = "insert into cc_did_exten_price (user_id,country_id, price, type) VALUES ('" . $lastuserID . "','" . $countryId . "','" . $didPrice . "','did'),('" . $lastuserID . "','" . $countryId . "','" . $extensionPrice . "','extension')";
							$result_price = mysqli_query($connection, $insert_price) or die("query failed : insert_price");

							$accountcode = $username;

							$sql_one = "INSERT INTO `upload_documents` (`user_id`, `accountcode`, `file_one`, `status`) VALUES ('$lastuserID', '$accountcode', '$file_one', 'Approved')";
							$query_one = mysqli_query($con, $sql_one) or die("query failed : sql_one");

							$sql_two = "INSERT INTO `upload_documents` (`user_id`, `accountcode`, `file_one`, `status`) VALUES ('$lastuserID', '$accountcode', '$file_two', 'Approved')";
							$query_two = mysqli_query($con, $sql_two) or die("query failed: sql_two");

							$sql_three = "INSERT INTO `upload_documents` (`user_id`, `accountcode`, `file_one`, `status`) VALUES ('$lastuserID', '$accountcode', '$file_three', 'Approved')";
							$query_three = mysqli_query($con, $sql_three) or die("query failed : sql_three");

							if (move_uploaded_file($tempname_one, $folder_one) && move_uploaded_file($tempname_two, $folder_two) && move_uploaded_file($tempname_three, $folder_three)) {
								$message = "<h3>Files uploaded successfully!</h3>";
							} else {
								$message = "<h3>Failed to upload files!</h3>";
							}
						}
						
						if ($reseller_role == 3) {
							$_SESSION['msg'] = "Reseller Add Sucessfully..!!";
						} else {
							$_SESSION['msg'] = "User Add Sucessfully..!!";
						}
						if ($reseller_role == 3) {
							$activity_type = "Reseller Add ";
							$msg = 'Reseller: ' . $name . ' ' . 'Added Succesfully!' .  'By Admin';
							
						}else{
							$activity_type = 'User Add ';
							$msg = 'User: ' . $name . ' ' . 'Added Succesfully!' . 'By Admin';
							
						}
			            user_activity_log($clientId, $clientId, $activity_type, $msg);	
						echo '<script>window.location.href="users.php"</script>';
					} else {
						$email_err = "User Email already exist!";
					}
				} else {
					$msg_pass = 'Mismatch password';
				}
			}
		}
	}
}
function endsWith($string, $suffix)
{
	return substr($string, -strlen($suffix)) === $suffix;
}
?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> ADD USER <span style="margin-left:50px;color:blue;">
								<?php echo $message; ?>
							</span></h2>
						<div class="table-data__tool-right">
							<a href="users.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
									<i class="fa fa-eye" aria-hidden="true"></i>User</button>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="big_live_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="queue_info">
							<form id="userForm" action="" name="useradd" method="post" enctype="multipart/form-data">
								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label"> Choose One</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="inline-tariff1" class="form-check-label"
												style="margin-right:15px; color:black;">
												<input id="inline-tariff1" name="reseller_role" class="form-check-input"
													type="radio" value="3" <?php if (isset($_POST['reseller_role']) && $_POST['reseller_role'] == '3') {
														echo "checked";
													} ?> /> Reseller
											</label>
											<label for="inline-tariff2" class="form-check-label" style="color:black;">
												<input id="inline-tariff2" name="reseller_role" class="form-check-input"
													type="radio" value="2" <?php if (!isset($_POST['reseller_role']) || isset($_POST['reseller_role']) && $_POST['reseller_role'] == '2') {
														echo "checked";
													} ?> />
												User
											</label>
										</div>
									</div>
								</div>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Company</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="" name="companyname" placeholder="Company Name" class="form-control"
											type="text" value="<?php if (isset($_POST['companyname'])) {
												echo $_POST['companyname'];
											} else {
												echo '';
											} ?>" required />
										<span style="color:red;"><b>
												<?php echo $msg; ?>
											</b></span>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Name</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="name" name="name" placeholder="Name" class="form-control" type="text"
											value="<?php if (isset($_POST['name'])) {
												echo $_POST['name'];
											} else {
												echo "";
											} ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Billing Address</label>
									</div>
									<div class="col-12 col-md-8">
										<input name="billing_address" placeholder="Billing Address" class="form-control"
											type="text" value="<?php if (isset($_POST['billing_address'])) {
												echo $_POST['billing_address'];
											} else {
												echo "";
											} ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Plan Type</label>
									</div>
									<div class="col col-md-8">

										<?php
										$planId = isset($_POST['plan_id']) ? $_POST['plan_id'] : '';
										$plan_sql = "SELECT * FROM `master_plans`";
										$result_sql = mysqli_query($connection, $plan_sql);
										if (mysqli_num_rows($result_sql)) {
											?>
											<select id="plan_id" name="plan_id" class="form-control">
												<option value="">---Select Plan---</option>
												<?php while ($row = mysqli_fetch_assoc($result_sql)) { ?>
													<?php
													if ($planId == $row['id']) {
														$select = 'Selected';
													} else {
														$select = '';
													}
													?>
													<option <?php echo $select; ?> value="<?php echo $row['id']; ?>">
														<?php echo $row['name']; ?>
													</option>
												<?php } ?>
											</select>
											<?php
										}
										?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Country</label>
									</div>
									<div class="col col-md-8">
										<?php
										$select_country = "SELECT * FROM `cc_country`";
										$result_country = mysqli_query($connection, $select_country) or die("query failed");
										if (mysqli_num_rows($result_country) > 0) {
											?>
											<select id="country" name="country" class="form-control">
												<option value="">---Select Country---</option>
												<?php while ($c_row = mysqli_fetch_assoc($result_country)) { ?>
													<option value="<?php echo $c_row['countrycode']; ?>" <?php if (isset($_POST['country']) && $_POST['country'] == $c_row['countrycode']) {
														   echo "selected";
													   } else {
														   echo '';
													   } ?>> <?php echo $c_row['countryname']; ?>
													</option>
												<?php } ?>
											</select>
										<?php } ?>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">State</label>
									</div>
									<div class="col col-md-8">
										<?php
										$state_sql = "SELECT distinct(`State`) FROM `state_stdcode` WHERE `countryCode` = '" . $_POST['country'] . "'";
										$state_res = mysqli_query($connection, $state_sql) or die("query failed : state_sql");
										?>
										<select id="state" name="state" class="form-control">
											<option value="">---Select State---</option>
											<?php
											if (mysqli_num_rows($state_res) > 0) {
												while ($state_row = mysqli_fetch_assoc($state_res)) {
													if (isset($_POST['state']) && $_POST['state'] == $state_row['State']) {
														$select = "selected";
													} else {
														$select = "";
													}
													?>
													<option <?php echo $select; ?> value="<?php echo $state_row['State']; ?>">
														<?php echo $state_row['State']; ?>
													</option>
												<?php }
											} ?>
										</select>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">ZIP CODE</label>
									</div>
									<div class="col-12 col-md-8">
										<input type="text" name="zipcode" placeholder="zipcode" class="form-control"
											value="<?php if (isset($_POST['zipcode'])) {
												echo $_POST['zipcode'];
											} else {
												echo "";
											} ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Phone No.</label>
									</div>
									<div class="col-12 col-md-8">
										<input type="number" name="phone" placeholder="Phone No." class="form-control"
											value="<?php if (isset($_POST['phone'])) {
												echo $_POST['phone'];
											} else {
												echo "";
											} ?>" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Email*</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="email" name="email" placeholder="Email" class="form-control"
											type="text" value="<?php if (isset($_POST['email'])) {
												echo $_POST['email'];
											} else {
												echo "";
											} ?>" />
										<span style="color:red;"><b>
												<?php echo $email_err; ?>
											</b></span>
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Password</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="password" name="password" placeholder="password" class="form-control"
											required type="password" value="" />
									</div>
								</div>

								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Confirm Password</label>
									</div>
									<div class="col-12 col-md-8">
										<input type="password" name="confirmPassword" placeholder="Confirm Password"
											required class="form-control" />
										<span style="color:red;"><b>
												<?php echo isset($msg_pass) ? $msg_pass : ''; ?>
											</b></span>
									</div>
								</div>

								<div class="row form-group barge_radio_btn">
									<div class="col col-md-4">
										<label class=" form-control-label">Outbound Call</label>
									</div>
									<div class="col col-md-8">
										<div class="form-check-inline form-check">
											<label for="tariff1-radio1" class="form-check-label "
												style="margin-right:15px; color:black;">
												<input id="tariff1-radio1" name="outbound_call" class="form-check-input"
													type="radio" value="1" <?php
													if (isset($_POST['outbound_call']) && $_POST['outbound_call'] == 1) {
														echo 'checked';
													} else {
														echo '';
													}
													?> /> Yes
											</label>
											<label for="tariff1-radio2" class="form-check-label " style="color:black;">
												<input id="tariff1-radio2" name="outbound_call" class="form-check-input"
													type="radio" value="0" <?php
													if (!isset($_POST['outbound_call']) || isset($_POST['outbound_call']) && $_POST['outbound_call'] == 0) {
														echo 'checked';
													} else {
														echo '';
													}
													?> />
												No
											</label>
										</div>
									</div>
								</div>
								<?php
								if (isset($_POST['outbound_call']) && $_POST['outbound_call'] == 1) {
									$trunk_class = "block";
								} else {
									$trunk_class = "none";
								}
								?>
								<?php if (!isset($_POST['outbound_call']) || (isset($_POST['outbound_call']) && $_POST['outbound_call'] == 1)) {
									?>
									<div class="row form-group trunks" style="display:<?php echo $trunk_class; ?>;">
										<div class="col col-md-4">
											<label for="text-input" class="form-control-label">Tarrif Plans</label>
										</div>
										<div class="col col-md-8">
											<select id="trunks" name="trunks" class="form-control">
												<option value="">---Select---</option>
												<?php $trunk_sql = "select * from ratecard_group";
												$trunk_res = mysqli_query($connection, $trunk_sql) or die("query failed : trunk_sql");
												if (mysqli_num_rows($trunk_res) > 0) {
													while ($trunk_row = mysqli_fetch_assoc($trunk_res)) {
														if ($_POST['trunks'] == $trunk_row['id']) {
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
								<?php } ?>

								<?php
								if (isset($_POST['reseller_role']) && $_POST['reseller_role'] == 3) {
									$reseller_css = "block";
								} else {
									$reseller_css = "none";
								}
								?>

								<?php if (!isset($_POST['reseller_role']) || (isset($_POST['reseller_role']) && $_POST['reseller_role'] == '3')) { ?>
									<div class="resellerprice" id="ress" style="display:<?php echo $reseller_css; ?>">
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class=" form-control-label">DID Price</label>
											</div>
											<div class="col-12 col-md-8">
												<input id="didPrice" name="didPrice" placeholder="DID Price"
													class="form-control" type="number" value="<?php if (isset($_POST['didPrice'])) {
														echo $_POST['didPrice'];
													} else {
														echo "";
													} ?>" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class=" form-control-label">Extension Price</label>
											</div>
											<div class="col-12 col-md-8">
												<input id="extensionPrice" name="extensionPrice"
													placeholder="Extension Price" class="form-control" type="number" value="<?php if (isset($_POST['extensionPrice'])) {
														echo $_POST['extensionPrice'];
													} else {
														echo "";
													} ?>" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class=" form-control-label">Front of User Govt.
													ID*</label>
											</div>
											<div class="col-12 col-md-8 row">
												<div class="col-sm-6">
													<input class="form-control" type="file" name="file_one" value="" />
												</div>
												<div class="col-sm-6">
													<?php if (isset($_FILES["file_one"]) && $_FILES["file_one"]["tmp_name"]) {
														if (endsWith($folder_one, ".pdf")) {
															echo '<embed src="' . $folder_one . '" width="50%">';
														} else {
															echo '<img src="' . $folder_one . '" width="50%">';
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class=" form-control-label">Back of User Govt.
													ID*</label>
											</div>
											<div class="col-12 col-md-8 row">
												<div class="col-sm-6">
													<input class="form-control" type="file" name="file_two" value="" />
												</div>
												<div class="col-sm-6">
													<?php if (isset($_FILES["file_two"]) && $_FILES["file_two"]["tmp_name"]) {
														if (endsWith($folder_two, ".pdf")) {
															echo '<embed src="' . $folder_two . '" width="50%">';
														} else {
															echo '<img src="' . $folder_two . '" width="50%">';
														}
													}
													?>
												</div>
											</div>
										</div>
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class=" form-control-label">Selfie with Govt.
													ID*</label>
											</div>
											<div class="col-12 col-md-8 row">
												<div class="col-sm-6">
													<input class="form-control" type="file" name="file_three" value="" />
												</div>
												<div class="col-sm-6">
													<?php if (isset($_FILES["file_three"]) && $_FILES["file_three"]["tmp_name"]) {
														if (endsWith($folder_three, ".pdf")) {
															echo '<embed src="' . $folder_three . '" width="50%">';
														} else {
															echo '<img src="' . $folder_three . '" width="50%">';
														}
													}
													?>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
								<div class="form-group pull-right">
									<button name="submit" value="submit" type="submit"
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
	$(document).ready(function () {
		function loadState(country_code) {
			$.ajax({
				url: "state-load.php",
				type: "POST",
				data: {
					country_code: country_code
				},
				success: function (data) {
					$("#state").html(data);
				}
			});
		}

		$("#country").on("change", function () {
			var country = $("#country").val();
			loadState(country);
		});

		$("input[name='reseller_role']").on("change", function () {
			if ($("input[name='reseller_role']:checked").val() == 3) {
				$('#plan_id').html("<option value='0'>Fix per month</option>");
				$('.resellerprice').css('display', 'block');

			} else {
				$('#plan_id').html("<option value=''>---Select Plan---</option><option value='0'>Fix per month</option><option value='1'>Pay as you Go</option>");
				$('.resellerprice').css('display', 'none');

			}
		});

		$("input[name='outbound_call']").change(function () {
			if ($("input[name='outbound_call']:checked").val() == 1) {
				$('.trunks').css('display', 'block');
				$("#trunks").attr("required", "true");
			} else {
				$('.trunks').css('display', 'none');
				$("#trunks").removeAttr("required");
			}
		});
	});
</script>

<?php require_once('footer.php'); ?>