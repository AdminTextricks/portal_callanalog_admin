<?php
require_once('connection.php');
include 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = base64_decode($_GET['email']);
// echo $email;exit;

if (isset($_POST['verifyOTP'])) {

	$user_otp = $_POST['user_otp'];

	$select_users_login = "SELECT * FROM `users_login` WHERE `email` = '" . $email . "'";
	$result_users_login = mysqli_query($connection, $select_users_login) or die("query failed");
	if (mysqli_num_rows($result_users_login) > 0) {
		while ($rows = mysqli_fetch_assoc($result_users_login)) {
			$fetch_otp = $rows['email_otp'];
		}
	}

	if ($user_otp == $fetch_otp) {
		header("location: change_password.php?email=" . base64_encode($email));
	} else {
		echo "<script>alert('OTP not verified.')</script>";
	}

}

if (isset($_POST['resend_otp'])) {

	$email_otp = rand(100000, 999999);
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
		$mail->addAddress($email);

		$mail->isHTML(true);
		$mail->Subject = 'RESEND OTP';
		$mail->Body = "Your resend otp verification code for Call Analog is .$email_otp.";
		$mail->AltBody = 'Body in plain text for non-HTML mail clients';
		$mail->send();
		$message = "<script>alert('OTP RESEND SUCCESSFULLY')</script>";
		$update_otp = "UPDATE `users_login` SET `email_otp` = '" . $email_otp . "' WHERE `email` = '" . $email . "'";
		mysqli_query($connection, $update_otp) or die("query Failed");
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

}
?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="au theme template">
	<meta name="author" content="Hau Nguyen">
	<meta name="keywords" content="au theme template">

	<title>Login</title>

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
<?php
if (isset($_SESSION['login_user'])) {
	header('location: dashboard.php');
}
?>

<body class="animsition">

	<div class="page-wrapper">
		<div class="page-content--bge5">
			<div class="container">
				<div class="login-wrap2">

					<div class="screen">
						<div class="screen__content">
							<div class="login_logo">
								<img src="resources/images/logo.png">
							</div>

							<!-- OTP Verify Form -->
							<?php if (isset($message)) {
								echo $message;
							} ?>
							<form id="VerifyOTP" class="login" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
								<div class="login__field">
									<i class="login__icon fa fa-user"></i>
									<input id="user_otp" name="user_otp" placeholder="Enter OTP" class="login__input"
										type="number" value="" />
								</div>

								<button name="verifyOTP" class="button login__submit" type="submit">
									<span class="button__text">Verify OTP</span>
									<i class="button__icon fa fa-chevron"></i>
								</button>
								<hr>
								<p></p>
								<a href="index.php" id="usersignup">Login</a>
								<button type="submit" class="btn btn-primary btn-sm float-right"
									name="resend_otp">Resend OTP</button>
							</form>
							<script src="resources/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>
							<script src="resources/vendor/perfect-scrollbar/perfect-scrollbar.js"
								type="text/javascript"></script>
							<script src="resources/vendor/select2/select2.min.js" type="text/javascript">
							</script>

</body>

</html>