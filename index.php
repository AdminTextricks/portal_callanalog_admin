<?php
require_once('connection.php');
// print_r($_SESSION);
// die();
if (isset($_SESSION['login_user'])) {
	header('location: dashboard.php');
}
$error = '';

if (isset($_POST['submit'])) {

	// if($username == ''){
	// 	$user_error = "Please Enter Your Registered Email";
	// }elseif($password == ''){
	// 	$password_error = "Please Enter Password";
	// }else{

	if (!empty($_POST['username']) or !empty($_POST['password'])) {

		$username = $_POST['username'];
		$password = md5($_POST['password']);

		if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
			$error = '<center><h5 style="color:red;">Invalid email format</h5></center>';
		} else {
			$plan_id = '';
			$query = "select * from users_login where password='" . $password . "' AND email='" . $username . "' LIMIT 1";
			// echo $query;exit;
			$result = mysqli_query($connection, $query);
			$userCount = mysqli_num_rows($result);
			if ($userCount > 0) {
				$row = mysqli_fetch_array($result);
// print_r($row);exit;
				$user_id = $row['id'];
				$login_user = $row['email'];
				$login_password = $row['password'];
				$plan_id = $row['plan_id'];
				$user_role = $row['role'];
				$clientId = $row['clientId'];
				$status = trim($row['status']);
				$email_verify_status = $row['email_verify_status'];
				$mobile_verify_status = $row['mobile_verify_status'];


				$query_usernamess = "select * from cc_card where uipass='" . $password . "' AND email='" . $username . "'";
				// echo $query_usernamess;exit;
				$result_usernames_one = mysqli_query($connection, $query_usernamess);
				$ccCardCount = mysqli_num_rows($result_usernames_one);
				if ($ccCardCount > 0) {
					while ($rowuser = mysqli_fetch_array($result_usernames_one)) {
						 
						$sessionusername = $rowuser['username'];
						$sessionuserid = $rowuser['id'];
						$sessionusercredit = $rowuser['credit'];
					}

				}

				if ($email_verify_status == '0' || $mobile_verify_status == '0') {
					header("location: verification.php?uid=" . base64_encode($user_id));
				} else {

					if ($login_user == $username && $login_password == $password) {
						if (strtolower(trim($row['status'])) == 'active') {
							$_SESSION['login_user'] = $login_user; // Initializing Session
							//$_SESSION['login_password'] = $login_password;
							$_SESSION['login_usernames'] = $sessionusername;
							$_SESSION['login_user_id'] = $sessionuserid;
							$_SESSION['login_user_plan_id'] = $plan_id;
							$_SESSION['login_user_credits'] = $sessionusercredit;
							// $_SESSION['login_user_profile'] = $profile_image;

							/*********   added by lalit */
							$_SESSION['userroleforpage'] = $user_role;
							$_SESSION['userroleforclientid'] = $clientId;
							/*****   end */

							$useriid2 = $_SESSION['login_user_id'];
							// echo $useriid2;exit;
							// echo $row['role'];die;
							$upstatus3 = "'Rejected' , 'Pending'";
							if ($row['role'] == '1') {
								$upload_doc_main_login2 = "SELECT * FROM upload_documents WHERE 1";
							} else {
								$upload_doc_main_login2 = "SELECT * FROM upload_documents WHERE user_id='" . $useriid2 . "'";
							}
							// echo $upload_doc_main_login2; die;
							$upload_doc_query_login2 = mysqli_query($connection, $upload_doc_main_login2);
							if (mysqli_num_rows($upload_doc_query_login2) > 0) {
								while ($row_upload_doc_head2 = mysqli_fetch_assoc($upload_doc_query_login2)) {
									$up_status_doc2[] = $row_upload_doc_head2['status'];
								}
							}
							// echo '<pre>'; print_r($_SESSION); exit;

							if ($row['role'] == 1) {
								header("location: dashboard.php"); // Redirecting 
							} else {
								if (!empty($up_status_doc2) && in_array('Rejected', $up_status_doc2)) {
									header("location: upload_documents_list.php"); // Redirecting To Other Page
								} elseif (empty($up_status_doc2)) {
									header("location: upload_documents_add.php");
								} else {
									$insert_user_session = "INSERT INTO `user_session_log`(`user_id`,`client_id`,`IP`,`login_time`,`user_email`,`user_password`)
                                    VALUES('" . $_SESSION['login_user_id'] . "','" . $clientId . "','" . $_SERVER['REMOTE_ADDR'] . "','" . date('Y-m-d H:i:s') . "','".$login_user."','".$_POST['password']."')";
									//echo $insert_user_session;
									$result_session = mysqli_query($connection, $insert_user_session) or die("query failed:insert_user_session");
									$activity_last_id = mysqli_insert_id($connection);

									$_SESSION['activity_last_id'] = $activity_last_id;

									if ($_SESSION['userroleforpage'] == 3 || $_SESSION['userroleforpage'] == 4) {
										header("location: ../adminr/dashboard.php");
									} else {
										header("location: dashboard.php");
									}
								}
							}
							// header("location: dashboard.php"); // Redirecting 
							//header("location: dashboard.php"); // Redirecting To Other Page
						} else {
							$error = '<center><h5 style="color:red;">Your account is Deactivated. Please <a href="http://callanalog.com/contact_us.php">contact us.</a></h5></center>';
						}
					} else {
						$error = '<center><h5 style="color:red;">Username or Password is invalid</h5></center>';
					}
				}
			} else {
				$error = '<center><h5 style="color:red;">Username or Password is invalid</h5></center>';
			}

		}
	} else {
		$error = '<center><h5 style="color:red;">Please enter username and password</h5></center>';
	}
}
// }
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

							<form id="loginForm" class="login" action="" method="post">
								<div class="login__field">
									<i class="login__icon fa fa-user"></i>
									<input id="user_login" name="username" placeholder="User Email" class="login__input"
										type="text" value="" />


								</div>
								<div class="login__field">
									<i class="login__icon fa fa-lock"></i>
									<input id="password" name="password" placeholder="Password" class="login__input"
										type="password" value="" /><i class="fa fa-eye" id="togglePassword"
										style="margin-left: -30px; cursor: pointer;"></i>
								</div>
								<!-- <div class="login-checkbox">
					<label>
					<input type="checkbox" name="remember">Remember Me
					</label>
					
					</div> -->
								<button name="submit" class="button login__submit" type="submit">
									<span class="button__text">Log In Now</span>
									<i class="button__icon fa fa-chevron-right"></i>
								</button>
								<hr>
								<a href="forgot_password.php" id="forgotlink">Forgot Password?</a> &nbsp; &nbsp;&nbsp;
								&nbsp;
								<a href="usersignup.php" id="usersignup"> Sign Up</a>
								<p></p>
								<br>
								<p>
									<?php if (isset($error)) {
										echo $error;
									} ?>
								</p>
							</form>
							<!-- User signup Form Start Here -->

							<!-- User signUp Form End Here -->



							<form id="forgotForm" name="forgotForm" style="display:none;" class="login"
								action="/forgotpassword" method="post">
								<div class="login__field">
									<i class="login__icon fas fa-user"></i>
									<input type="text" name="forgotEmail" id="forgotEmail" class="login__input"
										placeholder="User name/ Email" />

								</div>

								<button class="button login__submit" type="submit" id="forgotButton">
									<span class="button__text">Submit</span>
									<i class="button__icon fas fa-chevron-right"></i>
								</button>

								<a href="javascript:void(0);" id="loginlink">Login</a>
								<p id="passwordReset"></p>
							</form>

						</div>
						<div class="screen__background">
							<span class="screen__background__shape screen__background__shape4"></span>
							<span class="screen__background__shape screen__background__shape3"></span>
							<span class="screen__background__shape screen__background__shape2"></span>
							<span class="screen__background__shape screen__background__shape1"></span>
						</div>
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
	<script src="resources/vendor/select2/select2.min.js" type="text/javascript"></script>

	<!-- <script src="resources/js/main.js" type="text/javascript"></script> -->
	<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
		data-cf-settings="|49" defer=""></script>
	<script>
		// $("#usersignup").click(function(){
		// 	$("#loginForm").hide();
		// 	$("#signupForm").show();
		// });
		// // Create New User 
		// $(document).ready(function(){
		// 	$("#submit").on("click",function(e){
		// 		e.preventDefault();
		// 		var clientname = $("#clientname").val();
		// 		var name = $("#name").val();

		// 	});
		// });
		/*
		$("#forgotlink").click(function(){
			$("#loginForm").hide();
			$("#forgotForm").show();
		});
		$("#loginlink").click(function(){
			$("#forgotForm").hide();
			$("#loginForm").show();
		});
		*/
		$("#loginForm").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				// password: {
				// required: true
				// }
			},
			errorPlacement: function (error, element) { },
			submitHandler: function (form) {

				form.submit();

			}
		})

		$("#forgotForm").validate({
			rules: {
				forgotEmail: {
					required: true,
					email: true
				}
			},
			errorPlacement: function (error, element) { },
			submitHandler: function () {

				var data = {
					email: $("#forgotEmail").val()
				}
				$.ajax({
					url: 'forgot_password.php',
					type: 'post',
					contentType: 'application/json; charset=utf-8',
					data: JSON.stringify(data),
					dataType: "text",
					success: function (response) {
						$("#passwordReset").text(response);
					}
				});
			}
		})

		// for toggle password 

		const togglePassword = document.querySelector('#togglePassword');
		const password = document.querySelector('#password');

		togglePassword.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
		});

	</script>
</body>

</html>