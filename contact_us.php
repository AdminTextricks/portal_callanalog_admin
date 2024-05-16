<?php 
require_once('header.php');
include 'vendor/autoload.php';
include 'vendor_mobile/autoload.php';
use Twilio\Rest\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
	
	
if(isset($_POST['submit'])){
	
	$name = $_POST['name'];
	$email = $_POST['email'];
    $phone = $_POST['phone'];
	$message = $_POST['message'];
    

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
		$mail->addAddress(EMAIL);
		  
		$mail->isHTML(true);                                 
		$mail->Subject = 'Query';
		//$mail->Name    = ".$name.";
		$mail->email   = ".$email.";
		//$mail->phone   = ".$phone.";
		$mail->Body    = "NAME-->$name<br>
		Email-->$email<br>
		Phone number-->$phone<br>
		Query-->$message";
		$mail->AltBody = 'Body in plain text for non-HTML mail clients';
		$mail->send();
		echo "<script>alert('Your Response Has Been Recorded.')</script>";
		echo "Mail has been sent successfully!";
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1">Fell Free to Contact US <span style="margin-left:50px;color:blue;"></span></h2>
<div class="table-data__tool-right">

<button class="au-btn au-btn-icon au-btn--green au-btn--small">
</div>
</div>
</div>
</div>
<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
<form id="userForm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">             
<input id="role" name="role" value="2" class="form-control" type="hidden" value="1"/>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Name</label>
</div>
<div class="col-12 col-md-9">
<input id="name" name="name" placeholder="Name" class="form-control" type="text" value="" required />
</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email</label>
</div>
<div class="col-12 col-md-9">
<input id="email" name="email" placeholder="Enter your email" class="form-control" type="email" required />
</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Phone</label>
</div>
<div class="col-12 col-md-9">
<input id="phone" name="phone" placeholder="Enter your phone number" class="form-control" type="number" required />
</div>
</div>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Message</label>
</div>
<div class="col-12 col-md-9">
<textarea id="messageee" name="message"  placeholder="Write Your Query Here" class="form-control" ></textarea><br><br>

<div class="form-group pull-right">
			<button type="submit" name="submit" class="btn btn-primary btn-sm">submit</button>
			</div>
			<p style="color:blue;"></p>
</div>
</div>
<hr style="width:168%;">
<center><div style="font-size:18px; margin-left:75px;"><b>Get Support With Us</b></div><br></center>
<div class="col-sm-12 row form-group">
	<div class="col-md-3" style="margin-left:163px;"><a href="tel: +1 (888) 673 3023"><button type="button" class="btn btn-primary btn-md">Call Us Now</button></a></div>
	
	<div class="col-md-5" style="text-align:right;"><a href="javascript:;" onclick="javascript:void(Tawk_API.toggle())"><button type="button" class="btn btn-primary btn-md">Chat with Us</button></a></div>
</div>
</div>
</div>
</div>
</div>

<?php
// header("location: http://139.84.172.41/dashboard.php");
?>
</form>	
        </div>
    </div>
	
    </div>
</div>
</div>
</div>
</div>
</div>
<br>
<?php require_once('footer.php'); ?> 
 
