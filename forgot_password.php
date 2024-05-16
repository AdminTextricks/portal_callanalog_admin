<?php
require_once('connection.php');

include 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// print_r($_SESSION);
// die();
if (isset($_SESSION['login_user'])) {
	header('location: dashboard.php');
}

if (isset($_POST['sendOTP'])) {
	$email = $_POST['email'];

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$sql = "SELECT `email` FROM `users_login` where email = '" . $email . "'";
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result) > 0) {
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
				$mail->Subject = 'Forgot Password OTP';
				$mail->Body = "Your Forgot Password  otp verification code for Call Analog is .$email_otp.";
				$mail->AltBody = 'Body in plain text for non-HTML mail clients';
				$mail->send();
				echo "Mail has been sent successfully!";
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
			$update_otp = "UPDATE `users_login` SET `email_otp` = '" . $email_otp . "' WHERE `email` = '" . $email . "'";
			mysqli_query($connection, $update_otp) or die("query Failed");

			header("location: verify_otp.php?email=" . base64_encode($email));

		} else {
			echo "<script>alert('Email ID not Exist.')</script>";
		}
	} else {
		echo "<script>alert('Email format is not valid.')</script>";
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
							<!-- Email Form  -->
							<form id="resetpassword" class="login" action="<?php $_SERVER['PHP_SELF']; ?>"
								method="post">
								<div class="login__field">
									<i class="login__icon fa fa-user"></i>
									<input id="user_email" name="email" placeholder="Enter Email" class="login__input"
										type="text" value="" />
								</div>

								<button name="sendOTP" class="button login__submit" type="submit">
									<span class="button__text">Send OTP</span>
									<i class="button__icon fa fa-chevron"></i>
								</button>
								<hr>
								<p></p>
								<a href="index.php" id="usersignup"> Login</a>
								<br>
								<p>
									<?php if (isset($_POST['sendOTP'])) {
										echo $error;
									} ?>
								</p>
							</form>

							<script src="resources/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>


							<script src="resources/vendor/perfect-scrollbar/perfect-scrollbar.js"
								type="text/javascript"></script>
							<script src="resources/vendor/select2/select2.min.js" type="text/javascript">
							</script>

</body>

</html>