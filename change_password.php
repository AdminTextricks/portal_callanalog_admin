<?php
require_once('connection.php');

$email = base64_decode($_GET['email']);

if(isset($_POST['submit'])){
    $password = md5($_POST['password']);
    $confirm_pass= md5($_POST['confirm_password']);

    if($password == $confirm_pass){
        $sql = "UPDATE `users_login` SET `password` = '$password' WHERE `email` = '$email'";
        mysqli_query($connection, $sql) or die("query failed");

        $query = "UPDATE `cc_card` SET `uipass` = '$password' WHERE `email` = '$email'";
        mysqli_query($connection, $query) or die("query failed");


        echo "<script>alert('Password Changed Successfully')</script>";
		header('location: index.php');
		
    }else{
        echo "<script>alert('Password and Confirm Password not matched.')</script>";
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
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<link href="resources/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

<link href="resources/vendor/select2/select2.min.css" rel="stylesheet" media="all">
<link href="resources/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

<link href="resources/css/theme.css" rel="stylesheet" media="all">
 <link href="resources/css/custom_style.css" rel="stylesheet" media="all"> 
 <link rel="icon" href="resources/images/favicon.png" sizes="32x32"/>
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

                          <!-- Password and Confirm Password Form -->
                          <form id="forgotpassword" class="login" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
                 <div class="login__field">
					<i class="login__icon fa fa-lock"></i>
					<input id="password" name="password" placeholder="Password" class="login__input" type="password" value="" required/><i class="fa fa-eye" id="togglePassword"  style="margin-left: -30px; cursor: pointer;"></i>
					
				</div>
                <div class="login__field">
					<i class="login__icon fa fa-lock"></i>
					<input id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="login__input" type="password" value="" required/><i class="fa fa-eye" id = "ctogglePassword" style="margin-left: -30px; cursor: pointer;"></i>
					
				</div>
			
				<button name="submit" class="button login__submit" type="submit">
					<span class="button__text">Submit</span>
					<i class="button__icon fa fa-chevron"></i>
				</button>
				<hr>
				<p ></p>
				<a href="index.php" id="usersignup"> Login</a>
			</form>

<script src="resources/vendor/jquery-3.2.1.min.js" type="text/javascript"></script>


<script src="resources/vendor/perfect-scrollbar/perfect-scrollbar.js" type="text/javascript"></script>
<script src="resources/vendor/select2/select2.min.js" type="text/javascript"></script>

<script>
// for toggle password 

const togglePassword = document.querySelector('#togglePassword');
		const password = document.querySelector('#password');

		togglePassword.addEventListener('click', function (e) {
			// toggle the type attribute
			const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
			password.setAttribute('type', type);
			// console.log(type);
			// toggle the eye slash icon
			this.classList.toggle('fa-eye-slash');
		});

		const ctogglePassword = document.querySelector('#ctogglePassword');
		const cpassword = document.querySelector('#confirm_password');

		   ctogglePassword.addEventListener('click',function(e){

			const type = cpassword.getAttribute('type') ==='password' ? 'text' : 'password';
		    cpassword.setAttribute('type',type);

		this.classList.toggle('fa-eye-slash');
		});
    </script>

</body>
</html>

