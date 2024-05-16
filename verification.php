<?php 
   require_once('connection.php');
   require_once('functions.php');
   include 'vendor/autoload.php';
   include 'vendor_mobile/autoload.php';
   use Twilio\Rest\Client;
   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   // print_r($_SESSION['login_user']);
   // die();
   $message = $user_id =  '';
   if(isset($_GET['uid'])){
       $user_id = base64_decode($_GET['uid']);
   }
   
   // echo $user_id; exit;
   
   $sql_before_update = "SELECT * FROM `users_login` WHERE `id` = '".$user_id."'";
   
   $result = mysqli_query($connection, $sql_before_update) or die("query failed : users_login");
   $email_otp = $mobile_otp = $fetch_phone = "";
   if(mysqli_num_rows($result) > 0){
       while($rows = mysqli_fetch_assoc($result)){
           $fetch_email = $rows['email'];
           $status = $rows['status'];
           $mobile_otp = $rows['mobile_otp'];
           $email_otp = $rows['email_otp'];
           $before_email_verify_status = $rows['email_verify_status'];
           $before_mobile_verify_status = $rows['mobile_verify_status'];
   
       }
   }
   $row_Client = '';
   $Client_query = "SELECT * FROM `Client` WHERE `clientEmail` = '".$fetch_email."'";
   $result_Client = mysqli_query($connection, $Client_query) or die("query failed : Client");
   if(mysqli_num_rows($result_Client) > 0){
       while($row_Client = mysqli_fetch_assoc($result_Client)){
           $fetch_phone = $row_Client['phone'];
       } 
   }
   
   
   $emsg = $msg ='';
   if(isset($_POST['submitMobile'])){
       $user_mobile = $_POST['user_mobile'];
       $user_mobile_otp = $_POST['mobile_otp'];
       if($user_mobile_otp == ''){
         $msg = "Please Enter OTP";
       }else{
         if($mobile_otp == $user_mobile_otp){
                  $sql = "UPDATE `users_login` SET `mobile_verify_status` = '1' WHERE `id` = '".$user_id."'";
                  mysqli_query($connection, $sql) or die("query failed");
            }else{
               $msg = "Mobile OTP is Incorrect";
            }
       }
      
   }
   
   if(isset($_POST['submitEmail'])){
       $email = $_POST['userEmail'];
       $user_email_otp = $_POST['email_otp'];
       if($user_email_otp == ''){
            $emsg = "Please Enter OTP";
       }else{
            if($email_otp == $user_email_otp){
                $sql = "UPDATE `users_login` SET `email_verify_status` = '1' WHERE `id` = '".$user_id."'";
                mysqli_query($connection, $sql) or die("query failed");
            
            }else{
            $emsg = "Email OTP is Incorrect";
            }
       }
   }
   
   // if(isset($_POST['submitMobile'])){
   //     $mobile = $_POST['user_mobile'];
   //     $user_mobile_otp = $_POST['mobile_otp'];
   //     if($mobile_otp == $user_mobile_otp){
   //         $query = "UPDATE `users_login` SET `mobile_verify_status` = '1' WHERE `id` = '".$user_id."'";
   //         mysqli_query($connection, $query) or die("query failed");
   //         // echo "<script>openPop_up()</script>";
   //     }else{
   //         echo "<script></script>";
   //     }
   // }
   
   if(isset($_POST['resendOTPMobile'])){
       $phone = $_POST['user_mobile'];

       $mobile_otp = rand(100000,999999);
       $accountSid = ACCOUNTSID;
        $authToken = AUTHTOKEN;
        $twilioNumber = TWILLONUMBER;
   	
   	// Recipient's phone number
   	$recipientNumber = $phone; // Replace with the recipient's phone number
   	// echo"<pre>";print_r($recipientNumber);die;
   	// Message content
   	$message = 'Your Mobile Number otp verification code for myphonesystems is '.$mobile_otp;
   
   	// Initialize the Twilio client
   	$client = new Client($accountSid, $authToken);
   	$twilioMessage=$client->messages->create(
   		// Where to send a text message (your cell phone?)
   		$recipientNumber,
   		[
   			'from' => $twilioNumber,
   			'body' => $message
   		]
   	);
   	
      $update_phone_client = "UPDATE `Client` SET `phone` = '".$phone."' WHERE `clientId` = '".$user_id."'";
      mysqli_query($connection, $update_phone_client) or die("query failed : update_phone_client");

      $update_phone_card = "UPDATE `cc_card` SET `phone` = '".$phone."' WHERE `id` = '".$user_id."'";
      mysqli_query($connection, $update_phone_card) or die("query failed : update_phone");
       $update_sms_otp = "UPDATE `users_login` SET `mobile_otp` ='".$mobile_otp."' WHERE `id` = '".$user_id."'";
       mysqli_query($connection, $update_sms_otp) or die("query failed : update_sms_otp");
   }
   
   $sql_after_update = "SELECT * FROM `users_login` WHERE `id` = '".$user_id."'";
   
   $result_after = mysqli_query($connection, $sql_after_update) or die("query failed");
   
   if(mysqli_num_rows($result_after) > 0){
       while($rows_after = mysqli_fetch_assoc($result_after)){
         $uname_active= $rows_after['name'];
         $uclioentid_active = $rows_after['clientId'];
          $after_mobile_verify_status = $rows_after['mobile_verify_status'];
          $after_email_verify_status = $rows_after['email_verify_status'];
   
       }
   }
   
   if($after_mobile_verify_status == '1' && $after_email_verify_status == '1' ){
       $update_login_status = "UPDATE `users_login` SET `status` = 'Active' WHERE `id` = '".$user_id."'";
       mysqli_query($connection, $update_login_status) or die("query failed.");
       // header("location: index.php");
       $update_cc_status = "UPDATE `cc_card` SET `status` = '1' WHERE `id` = '".$user_id."'";
       mysqli_query($connection, $update_cc_status) or die("query failed");
       $result_queue = mysqli_query($connection, $update_login_status);
       if($result_queue){
         if($_SESSION['userroleforpage']=='1'){
             $activity_type = 'User Registered';
             $msg = 'User Name: '.$uname_active.' '.'Registered Succesfully! ';
         }
         else{
            $activity_type = 'User Registered';
            $msg = 'User Name: '.$uname_active.' '.'Registered Succesfully! ';
         }
          user_activity_log($user_id, $uclioentid_active, $activity_type, $msg);
          $message = 'User Registered Succesfully!';
       }	
   }
   
   
   
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Call Analog </title>
      <!-- plugins:css -->
      <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
         <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   </head>
   <!-- popUp CSS -->
   <style>
      body{
      background: #F0F0F0;
      }
      .alert {
      padding: 3px;
      background-color: #2196F3;
      color: white;
      width: 100%;
      display: none;
      }
      .success {
      padding: 3px;
      background-color: limegreen;
      color: white;
      width: 100%;
      display: none;
      }
      .closebtn {
      margin-left: 15px;
      color: white;
      font-weight: bold;
      float: right;
      font-size: 22px;
      line-height: 20px;
      cursor: pointer;
      transition: 0.3s;
      }
      .form-group{
      width:100%;
      }
      .closebtn:hover {
      color: black;
      }
      .pop_up{
      width: 400px;
      background: #fff;
      border-radius: 6px;
      position: absolute;
      top: 0;
      left: 50%;
      transform: translate(-50%, -50%)scale(0.1);
      text-align: center;
      padding: 0 30px 30px;
      color: #333;
      visibility: hidden;
      transition:  top 0.4s;
      }
      .open-pop_up{
      visibility: visible;
      top: 50%;
      transform: translate(-50%, -50%)scale(1);
      }
      .pop_up img{
      width: 100px;
      margin-top: -50px;
      border-radius: 50%;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      }
      .pop_up h2{
      font-size: 38px;
      font-weight: 500;
      margin: 30px 0 10px;
      }
      .pop_up button{
      width: 100%;
      margin-top: 50px;
      padding: 10px 0;
      background: #6fd649;
      color: #fff;
      border: 0;
      outline: none;
      font-size: 18px;
      border-radius: 4px;
      cursor: pointer;
      box-shadow: 0 5px 5px rgba(0,0,0,0.2);
      }
   </style>
   <body>
      <div class="container p-2">
         <div class="row">
            <div class="col-sm-12 row text-left" >
               <div class="col-sm-2" >
                  <a class="navbar-brand brand-logo" href="">
                     <!-- <img src="" class="headerlogo" alt="logo"  style="width: 50%;"/> -->
                  </a>
               </div>
               <div class="col-sm-8 row text-left" > </div>
               <div class="col-sm-2" > </div>
            </div>
         </div>
      </div>
      <div class="container">
      <div class="row">
      <div class="col-sm-12 row text-left p-4" >
         <div class="col-sm-1"></div>
         <div class="col-sm-9 row text-left" >
            <h2 class="welcome-text">Hi, <span class="text-blue fw-bold text-upper"><?php echo $fetch_email; ?></span> Please Verify your account details.</h2>
         </div>
         <div class="col-sm-2" >
            <input type="button" class="btn btn-primary me-2" name="Login" value="Login" id="loginButton" onClick="redirectLogin();" style="display:none;">
         </div>
      </div>
      <div class="container page-body-wrapper p-5">
      <div class="row">
         <!-- <div class="col-md-6 grid-margin stretch-card" >
            <div class="col-sm-12 row" >
                <div class="col-sm-1"></div>
                   <div class="card col-sm-10">
                     <div class="card-body">
                        <div id="EmailVerifiedBox">
                            <div class="wrapper">
                                <h4 style="color: #00bb00">Email Verified Successfully !!</h4>
                                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                                </svg>
                            </div>
                        </div>
                     </div>
                   </div>
              <div class="col-sm-1"></div>
             </div>
            </div> -->
         <div class="col-md-6 grid-margin stretch-card row" >
            <div class="col-lg-12 row" >
               <div class="col-sm-1"></div>
               <div class="card col-sm-10">
                  <div class="card-body">
                     <div id="EmailVerifiedBox" style="display: none">
                        <div class="wrapper">
                           <h4 style="color: #00bb00">Email Verified Successfully !!</h4>
                           <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                           </svg>
                        </div>
                     </div>
                     <div id="EmailVerificationBox" style="display: block">
                        <div class="alert p-2 font-16" id="Emailotpsentalert">
                           <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                           OTP has been sent on Email !!!
                        </div>
                        <?php if(!empty($after_email_verify_status)) {
                           echo "<center><img src='resources/images/tick.jpg' width='200px' height='200px'/></center>";
                           echo"<h2 style='text-align:center; margin-top:30px; color:green;'>Email verified Successfully</h2>";?>
                        <?php  } else{?>
                        <div class col-sm-12 >
                           <?php
                              if(isset($_POST['resendOTPEmail'])){
                              
                                  $email_otp = rand(100000,999999);
                                  $to= $_POST['userEmail'];
                              	$mail = new PHPMailer(true);
                              	try {
                              		// $mail->SMTPDebug = 2;                                      
                              		$mail->isSMTP();                                           
                              		$mail->Host       = HOST;                   
                              		$mail->SMTPAuth   = true;                            
                              		$mail->Username   = EMAIL;                
                              		$mail->Password   = PASSWORD;                       
                              		$mail->SMTPSecure = 'tls';                             
                              		$mail->Port       = PORT; 
                              	
                              		$mail->setFrom(EMAIL, CALLANALOG);         
                              		$mail->addAddress($to);
                              		  
                              		$mail->isHTML(true);                                 
                              		$mail->Subject = 'Otp Verification';
                              		$mail->Body    = "Your Email otp verification code for Call Analog is .$email_otp.";
                              		$mail->AltBody = 'Body in plain text for non-HTML mail clients';
                              		$mail->send();
                              		echo "<span style='color:green; font-size:22px;'><strong>OTP has been sent successfully!</strong></span>";
                              	} catch (Exception $e) {
                              		echo "<span style='color:red; font-size:17px;'><strong>Message could not be sent. Mailer Error:</strong> </span> {$mail->ErrorInfo}";
                              	}
                              
                                 $update_email_Client = "UPDATE `Client` SET `clientEmail` = '".$to."', `supportEmail` = '".$to."' WHERE `clientId` = '".$user_id."'";
                                 mysqli_query($connection, $update_email_Client) or die("query failed : update_email_card");

                                 $update_email_card = "UPDATE `cc_card` SET `email` = '".$to."' WHERE `id` = '".$user_id."'";
                                 mysqli_query($connection, $update_email_card) or die("query failed : update_email_card");

                                  $update_email_otp = "UPDATE `users_login` SET `email` = '".$to."', `email_otp` ='".$email_otp."' WHERE `id` = '".$user_id."'";
                                  mysqli_query($connection, $update_email_otp) or die("query failed");
                              }
                                ?>
                        </div>
                        <h4 class="card-title">Verify Your Email</h4>
                        <form id="emailVerification" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
                           <div class="form-group">
                              <label for="email">Email</label>
                              <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Email" value="<?php echo $fetch_email; ?>">
                              <div id="error_wrong_email" class="helptext" style="color: red;display: none">
                                 Entered Email is Incorrect
                              </div>
                           </div>
                           <div class="form-group" id="emailotpfield" style="display: block">
                              <label for="otp_email">Enter OTP</label>
                              <input type="number" class="form-control" id="email_otp" name="email_otp" placeholder="Enter OTP">
                              <div id="error_empty_otp_email" class="helptext" style="color: red;display: none">
                                 Please enter OTP
                              </div>
                              <span style="color:red; font-size:15px;"><?php echo $emsg; ?></span>
                              <div id="error_wrong_otp_email" class="helptext" style="color:red;display: none">
                                 Email OTP is not correct
                              </div>
                           </div>
                           <br>
                           <div class="row">
                              <div class="col-md-6">
                                 <button type="submit" class="btn btn-primary me-2" name="resendOTPEmail" value="resendOTPEmail" id="resendOTPEmail" style="display: block">Resend OTP</button>
                              </div>
                              <div class="col-sm-6 text-right">
                                 <button type="submit" class="btn btn-primary me-2 text-right" name="submitEmail" value="submitEmail" id="submitEmail"  style="display: block; float: right;">Verify Email</button>
                                 <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Email Verify</button> -->
                              </div>
                           </div>
                        </form>
                        <?php }?>
                     </div>
                  </div>
               </div>
               <div class="col-sm-1"></div>
            </div>
         </div>
         <div class="col-md-6 grid-margin stretch-card">
            <div class="col-sm-12 row">
               <div class="col-sm-1"></div>
               <div class="card col-sm-10">
                  <div class="card-body">
                     <div id="MobileVerifiedBox" style="display: none">
                        <div class="wrapper">
                           <h4 style="color: #00bb00">Phone Number Verified Successfully !!</h4>
                           <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                              <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                              <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                           </svg>
                        </div>
                     </div>
                     <div id="MobileVerificationBox" style="display: block">
                        <div class="alert" id="Mobileotpsentalert">
                           <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                           OTP has been sent on Your Number !!!
                        </div>
                        <?php if(!empty($after_mobile_verify_status)) {
                           echo "<center><img src='resources/images/tick.jpg' width='200px' height='200px'/></center>";
                           echo "<h2 style='text-align:center; margin-top:30px; color:green;'>Mobile Number Verified Successfully</h2>"?>
                        <?php  } else{?>
                        <div class="col-sm-12 mb-2 ">
                           <?php
                              //$twilioMessage='';
                               if ($twilioMessage->sid) {
                                  echo "<span style='color:green; font-size:21px;'> <strong>SMS sent successfully</strong></span>";
                                } else {
                                      echo '';
                                       }
                               ?>
                        </div>
                        <h4 class="card-title">Verify Your Mobile Number</h4>
                        <form id="mobileVerification" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" autocomplete="off">
                           <div class="form-group">
                              <label for="mobile">Mobile Number</label>
                              <input type="text" class="form-control" id="user_mobile" name="user_mobile" placeholder="Mobile Number" value="<?php echo $fetch_phone ?>">
                              <div id="error_wrong_phone" class="helptext" style="color: red;display: none">
                                 Entered Phone Number is Incorrect
                              </div>
                           </div>
                           <div class="form-group" id="mobileotpfield" style="display: block" required>
                              <label for="otp_mobile">Enter OTP</label>
                              <input type="number" class="form-control" id="mobile_otp" name="mobile_otp" placeholder="Enter OTP">
                              <div id="error_empty_otp_mobile" class="helptext" style="color: red;display: none" >
                                 Please enter OTP
                              </div>
                              <span style="color:red; font-size:15px;"><?php echo $msg; ?></span>
                              <div id="error_wrong_otp_mobile" class="helptext" style="color: red;display: none">
                                 Mobile OTP is incorrect
                              </div>
                           </div>
                           <br>
                           <!--<input type="hidden" id="id" name="userid" value="--><?//= !empty($userDetails['id']) ? $userDetails['id'] : '';?><!--">-->
                           <div class="row">
                              <div class="col-md-6">
                                 <button type="submit" class="btn btn-primary me-2" name="resendOTPMobile" value="resendOTPMobile" id="resendOTPMobile" style="display: block">Resend OTP</button>
                              </div>
                              <div class="col-md-6 text-right">
                                 <!-- <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#myModal" name="submitMobile" value="submitMobile" id="submitMobile" style="display: block; float: right;">Verify Phone</button> -->
                                 <button type="submit" class="btn btn-primary" name="submitMobile" id="submitMobile" >Mobile Verify</button>
                              </div>
                           </div>
                        </form>
                        <?php }?>
                     </div>
                  </div>
               </div>
               <div class="col-sm-1"></div>
            </div>
         </div>
      </div>
      <!-- Pop Box -->
      <div class="pop_up" id="pop_up"  style="display:none;">
         <img src="tick.jpg" width="70px" height="70px"/>
         <h2>Thank You!</h2>
         <p>Your details has been Successfully submitted. Thank you!</p>
      </div>
      <?php 
         if($after_mobile_verify_status == '1' && $after_email_verify_status == '1' ){
         ?>
      <div class="col-md-6 text-right">
         <a href="index.php"><button type="submit" class="btn btn-primary me-2" name="login" value="Login" id="login" style="display: block; float: right;">Login Now</button></a>
      </div>
      <?php } ?>
      <!-- partial:../../partials/_footer.html -->
      <!-- partial -->
      <!-- PopUp Function -->
      <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
      <!-- 
         <script>
             $(document).ready(function(){
                 $("#submitMobile").on("click", function(e){
                     e.preventDefault();
                     var user_mobile = $("#user_mobile").val();
                     var mobile_otp = $("#mobile_otp").val();
                     var user_id = '<?php // echo base64_decode($_GET['uid']); ?>';
                     
                     $.ajax({
                         url : "verify.php",
                         type : "POST",
                         dataType: "json",
                         data : {user_mobile:user_mobile, mobile_otp: mobile_otp, user_id:user_id},
                         success : function(data){
                             if(data.response == 'true'){
                                 $('#myModal1').modal('show');
                                 
                             }    
                         }
                     });
                 });
             });
         </script> -->
      <!-- <script>
         $(document).ready(function(){
             $("#submitMobile").on("click", function(e){
                 e.preventDefault();
                 var user_email = $("#userEmail").val();
                 var email_otp = $("#email_otp").val();
                 var user_id = '<?php // echo base64_decode($_GET['uid']); ?>';
                 
                 $.ajax({
                     url : "verifymail.php",
                     type : "POST",
                     dataType: "json",
                     data : {user_mobile:user_mobile, email_otp: email_otp, user_id:user_id},
                     success : function(data){
                         if(data.response == 'true'){
                             $('#myModal1').show();
                             
                         }    
                     }
                 });
             });
         });
         </script> -->
   </body>
</html>