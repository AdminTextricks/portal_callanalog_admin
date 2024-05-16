<?php
require_once('connection.php');
require_once('functions.php');
include 'vendor/autoload.php';
include 'vendor_mobile/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['login_user'])) {
	header('location: dashboard.php');
}
$emailErr = $smsmsg = $mailmsg = $planId = $clientErr = '';

if (isset($_POST['submit'])) {
	$role = 2;
	$username_alias = getAccountcode();
	
	$company_name = $_POST['companyname'];
	$name = $_POST['username'];
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$billing_address = $_POST['billing_address'];
	$country_code = $_POST['country'];
	$state = $_POST['state'];
	// $city = $_POST['city'];
	$status = "Inactive";
	$mobile_otp = rand(100000, 999999);
	$email_otp = rand(100000, 999999);
	$to = $_POST['email'];
	$zip = $_POST['zip'];
	$plan_id = $_POST['plan_id'];
	$verify_status = 0;
	$prefix = $_POST['country_prefix'];
	$phone = $_POST['country_prefix'] . $_POST['phone'];
	$date = date("Y-m-d h:i:s");

	// echo $phone;exit;
// echo '<pre>'; print_r($_POST); exit;
	$exist_company_sql = "SELECT `clientName` FROM `Client` WHERE `clientName` = '" . $company_name . "'";
	$exist_company_result = mysqli_query($connection, $exist_company_sql) or die("query failed");
	if (mysqli_num_rows($exist_company_result) != 0) {
		$clientErr = "Company Name Already Exist";
	} else {

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$emailErr = "Invalid email format";
		} else {
			$exist_email_sql = "SELECT `clientEmail` FROM `Client` WHERE `clientEmail` = '" . $email . "'";
			$email_sql_result = mysqli_query($connection, $exist_email_sql) or die("query failed");
			if (mysqli_num_rows($email_sql_result) != 0) {
				$emailErr = 'Email Id Already Exist.';
			} else {
				$query1 = "INSERT INTO `Client` (`clientEmail`,`clientEmailPass`,`createDate`,`clientName`,`loginPass`,`phone`,`supportEmail`) VALUES ('$email','$password','$date','$company_name','$password','$phone','$email')";
				$result1 = mysqli_query($connection, $query1) or die("query failed");

				$sql = "SELECT `clientId` FROM `Client` WHERE `clientEmail` = '" . $email . "'";
				$result = mysqli_query($connection, $sql) or die("query failed");
				if (mysqli_num_rows($result)) {
					while ($rows = mysqli_fetch_assoc($result)) {
						$id = $rows['clientId'];
					}
				}
				$query2 = "INSERT INTO `users_login` (`createDate`,`email`,`modifyDate`,`name`,`password`,`role`,`status`,`clientId`,`plan_id`,`mobile_otp`,`email_otp`,`mobile_verify_status`,`email_verify_status`) VALUES('$date','$email','$date','$name','$password','$role','$status','$id','$plan_id','$mobile_otp','$email_otp','$verify_status','$verify_status')";
				$result2 = mysqli_query($connection, $query2) or die("query failed");
				$user_id = mysqli_insert_id($connection);

				$query3 = "INSERT INTO `cc_card`(`creationdate`,`firstusedate`,`expirationdate`,`enableexpire`,`expiredays`,`username`,`useralias`,`uipass`,`credit`,`tariff`,`id_didgroup`,`activated`,`status`,`lastname`,`firstname`,`address`,`state`,`country`,`zipcode`,`phone`,`email`,`currency`) 
				VALUES ('$date','$date','$date','0','0','$username_alias','$username_alias','$password','000','1','0','f','0','$name','$name','$billing_address','$state','$country_code','$zip','$phone','$email','USD')";

				$result3 = mysqli_query($connection, $query3) or die("query failed.");

				/********* Proxy server insert Start */		
				
				if ($user_id % 2 == 0) {
					$server_id = '1';
					$server_name = 'Callanalog_Server1';
					$server_ip = '37.61.219.110';
					$sip_port = '50070';
					$asterisk_version = '18.20.0';
				}else{
					$server_id = '2';
					$server_name = 'CallAnalog_server2';
					$server_ip = '85.195.76.161';
					$sip_port = '50070';
					$asterisk_version = '18.20.0';
				}
				$ddate = date('Y-m-d H:i:s');
				$max_calls = '1000';
				$query4 = "INSERT INTO `cc_servers`(`server_id`,`user_id`,`server_name`,`server_ip`,`sip_port`,`asterisk_version`,`max_calls`,`active`,`created_at`, `updated_at`) VALUES ('".$server_id."','".$user_id."','".$server_name."','".$server_ip."','".$sip_port."','".$asterisk_version."','".$max_calls."','Y','$ddate','$ddate')";

				$result4 = mysqli_query($connection, $query4) or die("query failed.111");

				/********* Proxy server insert end */

				$mail = new PHPMailer(true);
				try {
					// $mail->SMTPDebug = 2;                                      
					$mail->isSMTP();
					$mail->Host = HOST;
					$mail->SMTPAuth = true;
					$mail->Username = EMAIL;
					$mail->Password = PASSWORD;
					$mail->SMTPSecure = 'tls';
					$mail->Port = PORT;

					$mail->setFrom(EMAIL, CALLANALOG);
					$mail->addAddress($to);

					$mail->isHTML(true);
					$mail->Subject = 'Otp Verification';
					$mail->Body = "Your Email otp verification code for Call Analog is .$email_otp.";
					$mail->AltBody = 'Body in plain text for non-HTML mail clients';
					$mail->send();
					//  echo "Mail has been sent successfully!";
				} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
				}

				$accountSid = ACCOUNTSID;
				$authToken = AUTHTOKEN;
				$twilioNumber = TWILLONUMBER;

				// Recipient's phone number
				$recipientNumber = $phone; // Replace with the recipient's phone number
				// echo"<pre>";print_r($recipientNumber);die;
				// Message content
				$message = 'Your Mobile Number otp verification code for Call Analog is ' . $mobile_otp;

				// Initialize the Twilio client
				$client = new Client($accountSid, $authToken);
				$twilioMessage = $client->messages->create(
					// Where to send a text message (your cell phone?)
					$recipientNumber,
					[
						'from' => $twilioNumber,
						'body' => $message
					]
				);
				if ($twilioMessage->sid) {
					echo 'SMS sent successfully.';
				} else {
					echo 'Failed to send SMS.';
				}

				header("Location: verification.php?uid=" . base64_encode($user_id), true);
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}
	</style>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="au theme template">
	<meta name="author" content="Hau Nguyen">
	<meta name="keywords" content="au theme template">

	<title>SignUp</title>

	<link href="resources/css/font-face.css" rel="stylesheet" media="all">
	<link href="resources/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">


	<link href="resources/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
	<link rel="stylesheet" type="text/css"
		href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link href="resources/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

	<link href="resources/vendor/select2/select2.min.css" rel="stylesheet" media="all">
	<link href="resources/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

	<link href="resources/css/theme.css" rel="stylesheet" media="all">
	<link href="resources/css/custom_style.css" rel="stylesheet" media="all">
	<link rel="icon" href="resources/images/favicon.png" sizes="32x32" />
</head>

<body class="animsition">

	<div class="page-wrapper">
		<div class="page-content--bge5">
			<div class="container">
				<div class="login-wrap2">
					<div class="screen" style="width:650px;">
						<div class="screen__content">
							<div class="login_logo">
								<img src="resources/images/logo.png">
							</div>
							<span>
								<?php //echo $mailmsg; ?>
							</span>
							<span>
								<?php //echo $smsmsg; ?>
							</span>
							<form id="" class="login" action="" method="post">
								<div class="container">
									<div class="row">
										<div class="col-6">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="" name="companyname" placeholder="Company Name"
													class="login__input" type="text"
													value="<?php if (isset($_POST['companyname'])) {
														echo $_POST['companyname'];
													} else {
														echo '';
													} ?>"
													required />
												<span style="color:red;"><b>
														<?php echo $clientErr; ?>
													</b></span>
											</div>
										</div>
										<div class="col-6">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="" name="username" placeholder="Name" class="login__input"
													type="text"
													value="<?php if (isset($_POST['username'])) {
														echo $_POST['username'];
													} else {
														echo '';
													} ?>"
													required />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-6">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="" name="email" placeholder="Email/Username"
													class="login__input" type="text"
													value="<?php if (isset($_POST['email'])) {
														echo $_POST['email'];
													} else {
														echo '';
													} ?>"
													required />
												<span style="color:red;">
													<?php echo $emailErr; ?>
												</span>
											</div>
										</div>
										<div class="col-6">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="password" name="password" placeholder="Password"
													class="login__input" type="password"
													value="<?php if (isset($_POST['password'])) {
														echo $_POST['password'];
													} else {
														echo '';
													} ?>"
													required /><i class="fa fa-eye" id="togglePassword"
													style="margin-left: -30px; cursor: pointer;"></i>

											</div>
										</div>
									</div>
									<div class="row">
										<div class="col">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="" name="billing_address" placeholder="Billing Address"
													class="login__input" type="text"
													value="<?php if (isset($_POST['billing_address'])) {
														echo $_POST['billing_address'];
													} else {
														echo '';
													} ?>"
													required />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="login__field">
												<i class="login__icon "></i>
												<?php
												$planId = base64_decode($_GET['plan']);
												$plan_sql = "SELECT * FROM `master_plans`";
												$result_sql = mysqli_query($connection, $plan_sql);
												if (mysqli_num_rows($result_sql)) {
													?>
													<select id="plan_id" name="plan_id" class="form-control">
														<option value="">---Select Plan---</option>
														<?php while ($row = mysqli_fetch_assoc($result_sql)) { ?>
															<?php
															if ($planId == $row['id'] || $_POST['plan_id'] == $row['id']) {
																$select = 'selected';
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
										<!--</div>
				<div class="row">-->
										<div class="col-md-6">
											<div class="login__field">
												<i class="login__icon "></i>
												<?php
												$select_country = "SELECT * FROM `cc_country`";
												$result_country = mysqli_query($connection, $select_country) or die("query failed");
												if (mysqli_num_rows($result_country) > 0) {
													?>
													<select id="country" name="country" class="form-control">
														<option value="">---Select Country---</option>
														<?php while ($c_row = mysqli_fetch_assoc($result_country)) { ?>
															<option value="<?php echo $c_row['countrycode']; ?>" <?php
															   if (isset($_POST['country']) && $_POST['country'] == $c_row['countrycode']) {
																   echo "selected";
															   } else {
																   echo '';
															   } ?>>
																<?php echo $c_row['countryname']; ?>
															</option>
														<?php } ?>
													</select>
												<?php } ?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="login__field">
												<i class="login__icon "></i>
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
															<option <?php echo $select; ?>
																value="<?php echo $state_row['State']; ?>">
																<?php echo $state_row['State']; ?>
															</option>
														<?php }
													} ?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-5">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="" name="zip" placeholder="ZIP Code" class="login__input"
													type="number"
													value="<?php if (isset($_POST['zip'])) {
														echo $_POST['zip'];
													} else {
														echo '';
													} ?>"
													required />
											</div>
										</div>
										<div class="col-3">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="country_prefix" name="country_prefix" placeholder=""
													class="login__input" type="text"
													value="<?php if (isset($_POST['country_prefix'])) {
														echo $_POST['country_prefix'];
													} else {
														echo '';
													} ?>"
													required />
											</div>
										</div>
										<div class="col-4">
											<div class="login__field">
												<i class="login__icon "></i>
												<input id="phone" name="phone" placeholder="Phone No."
													class="login__input" type="number"
													value="<?php if (isset($_POST['phone'])) {
														echo $_POST['phone'];
													} else {
														echo '';
													} ?>"
													required />
											</div>
										</div>
									</div>
									<div class="tacbox">
										<input id="cond_checkbox " type="checkbox" required />
										<label for="checkbox" class="term_checkbox" style="color:black;"> I agree to <a
												href="http://callanalog.com/privacy-policy.php">Privacy Policy</a> and
											<a href="http://callanalog.com/terms-and-condition.php">Terms &
												Conditions</a>.</label>
									</div>
									<div class="row">
										<div class="col-md-6">
											<button name="submit" class="button login__submit" type="submit">
												<span class="button__text">Create Account</span>
												<i class="button__icon fa fa-chevron-right"></i>
											</button>
										</div>
										<div class="col-md-6">
											<div class="login__field">
												<p>If you are already user? Please click on <a href="index.php"
														id="usersignup">Login</a></p>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
						<!-- <div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div> -->
					</div>

				</div>
			</div>
		</div>
	</div>

	<script src="resources/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script src="resources/vendor/jquery-1.19.2-validation.js" type="text/javascript"></script>

	<script src="resources/vendor/bootstrap-4.1/popper.min.js" type="text/javascript"></script>
	<script src="resources/vendor/bootstrap-4.1/bootstrap.min.js" type="text/javascript"></script>
	<script src="resources/vendor/animsition/animsition.min.js" type="text/javascript"></script>

	<script src="resources/vendor/perfect-scrollbar/perfect-scrollbar.js" type="text/javascript"></script>
	<!-- <script src="resources/vendor/select2/select2.min.js" type="text/javascript"></script> -->

	<!-- <script src="resources/js/main.js" type="text/javascript"></script> -->
	<!-- <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="|49" defer=""></script> -->
	<script>
		const togglePassword = document.querySelector('#togglePassword');
		const password = document.querySelector('#password');

		togglePassword.addEventListener('click', function (e) {

			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);

			this.classList.toggle('fa-eye-slash');
		});
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
		});
	</script>
</body>

</html>