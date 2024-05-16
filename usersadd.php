<?php require_once('header.php'); 

if($_SESSION['userroleforpage'] == 1){ 
$query_client = "select * from Client";
}else{
$query_client = "select * from Client where clientId='".$_SESSION['userroleforclientid']."'";
}
$result_client = mysqli_query($connection , $query_client);

if(isset($_POST['submit']))
{
	$email = $_POST['email'];
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  		$message = "Invalid email format";
	}else{
		$created_at = date('Y-m-d h:i:s');
		$username = rand(11111,99999);
		if($_POST['email'] == $_POST['confirmEmail']){
			$email = $_POST['email'];
		}else{
			$msg = 'Mismatch email';
		}
		if($_POST['password'] == $_POST['confirmPassword']){
			$password = $_POST['password'];
		}else{
			$msg_pass = 'Mismatch password';
		}
	
		// $email = $_POST['email'];
		// $password = $_POST['password'];
	
		if($_POST['tariff'] == 1)
		{
			$tariff = 1;
		}else {
			$tariff = 0;
		}

		$select_email = "select email from users_login where email = '".$_POST['email']."'";	
		$result_email = mysqli_query($connection,$select_email);
		$email_num = mysqli_num_rows($result_email);
		if($email_num <= 0 ){
			
			$insert_users = "insert into cc_card (firstusedate,expirationdate,username,useralias,uipass,tariff,lastname,firstname,email,simultaccess,restriction) VALUES ('".$created_at."','".$created_at."','".$username."','".$username."','".$password."','".$tariff."','".$_POST['name']."','".$_POST['name']."','".$email."','1','1')";
			$result_users = mysqli_query($connection,$insert_users);
			
			$lastuserID = mysqli_insert_id($connection);
			
			$insert_loginuser = "insert into users_login (createDate,modifyDate,email,name,password,role,status,clientId) VALUES 
												('".$created_at."', '".$created_at."', '".$email."','".$_POST['name']."','".$password."','2','Active','".$_POST['clientId']."')";
			$result_loginuser = mysqli_query($connection,$insert_loginuser);
			
				
				$lastuserID = mysqli_insert_id($connection);
				
					if(!empty($_POST['menuList'])) {
						foreach($_POST['menuList'] as $check) {
							
						$insert_menu = "insert into user_menu_list (user_id,menu_id) VALUES ('".$lastuserID."','".$check."')";	
						$result_menu = mysqli_query($connection,$insert_menu);
						
						}
					}
				if($result_users){
					$message = "User added Successfully!";
				}	
		}else{
			$message = "User Email already exist!";
		}
		
	}
	
}

/*
$query_user = "select * from users_login";
$result_user_login = mysqli_query($connection , $query_user);

if(isset($_POST['submit']))
{
		if(isset($_POST['selectedUser'])){
		$selectedUser = $_POST['selectedUser'];
		
		$selectedUser = implode(",",$selectedUser);
		
		}

$created_at = date('Y-m-d h:i:s');
$updated_at = date('Y-m-d h:i:s');
$insert_queue = "INSERT INTO cc_queue_table(name, queue_name, description, maxlen, reportholdtime, periodic_announce_frequency, periodic_announce, strategy, joinempty, 
											leavewhenempty, autopause, announce_round_seconds, retry, wrapuptime, 
											announce_holdtime, announce_position, announce_frequency, timeout, context, 
										 	musicclass, autofill, ringinuse, musiconhold, monitor_type, 
											monitor_format, servicelevel, queue_thankyou, queue_youarenext, queue_thereare, 
											queue_callswaiting, queue_holdtime, queue_minutes, queue_seconds, queue_lessthan, 
											queue_reporthold, relative_periodic_announce, queue_timeout, fail_status, fail_dest, 
											fail_data, status, user_id, email, created_at, 
											updated_at, domain, assigned_user, announce, eventmemberstatus, 
											eventwhencallled, memberdelay, setinterfacevar, timeoutrestart, weight, 
											clientId, play_ivr) VALUES 
										   ('".$_POST['queueNum']."','".$_POST['queueName']."','".$_POST['description']."','".$_POST['queuemaxlen']."','".$_POST['_queuereportholdtime']."','".$_POST['q_periodic_announce_frequency']."',
											'".$_POST['q_periodic_announce']."','".$_POST['stratergy']."','".$_POST['_q_joinempty']."','".$_POST['_q_leavewhenempty']."','".$_POST['_q_autopause']."','".$_POST['q_announce_round_seconds']."','".$_POST['q_retry']."','".$_POST['q_wrapuptime']."',
											'".$_POST['_q_announce_holdtime']."','','".$_POST['q_announce_frequency']."','".$_POST['queue_timeout']."','".$_POST['q_context']."',
											'".$_POST['q_musicclass']."','".$_POST['q_autofill']."','".$_POST['_q_ringinuse']."','".$_POST['queue_musiconhold']."','".$_POST['q_monitor_type']."',
											'".$_POST['q_monitor_format']."','".$_POST['q_servicelevel']."','".$_POST['q_queue_thankyou']."','".$_POST['q_queue_youarenext']."','".$_POST['q_queue_thereare']."',
											'".$_POST['q_queue_callswaiting']."','".$_POST['q_queue_holdtime']."','".$_POST['q_queue_minutes']."','".$_POST['q_queue_seconds']."','".$_POST['q_queue_lessthan']."',
											'".$_POST['q_queue_reporthold']."','".$_POST['q_relative_periodic_announce']."','".$_POST['queue_timeout']."','','',
											'','".$_POST['status']."','2','','".$created_at."','".$updated_at."','','".$selectedUser."','','0',
											'0','0','','0','0','".$_POST['clientId']."','".$_POST['ivr']."')";
$result_queue = mysqli_query($connection , $insert_queue);
if($result_queue){
	$message = 'Queue Added Succesfully!';
}

}
*/

?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> User Information <span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
<div class="table-data__tool-right">
<a href="users.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> User</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="userForm" action="" name="useradd" method="post">
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Name</label>
</div>
<div class="col-12 col-md-9">
<select id="clientId" name="clientId" onchange="showUser(this.value)" class="form-control">
<option value="0">Select</option>
<?php while($row = mysqli_fetch_array($result_client) ) { ?>
<option value="<?php echo $row['clientId']; ?>"><?php echo $row['clientName']; ?></option>

<?php }?>

</select>
</div>
</div>


<input id="role" name="role" value="2" class="form-control" type="hidden" value="0"/>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Name</label>
</div>
<div class="col-12 col-md-9">
<input id="name" name="name" placeholder="Name" class="form-control" type="text" value="<?php if(isset($_POST['name'])){ echo $_POST['name'];}else{echo "";} ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email*</label>
</div>
<div class="col-12 col-md-9">
<input id="email" name="email" placeholder="Email" class="form-control" type="text" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];}else{echo "";} ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Confirm Email*</label>
</div>
<div class="col-12 col-md-9">
<input type="text" name="confirmEmail" placeholder="Confirm Email" class="form-control"/>
</div>
</div>

<?php echo $msg; ?>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Password</label>
</div>
<div class="col-12 col-md-9">
<input id="password" name="password" placeholder="password" class="form-control" type="password" value=""/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Confirm Password</label>
</div>
<div class="col-12 col-md-9">
<input type="password" name="confirmPassword" placeholder="Confirm Password"  class="form-control" />
</div>
</div>
<?php echo $msg_pass; ?>
<!-- 
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Menu Options*</label>
</div>
<div class="col-12 col-md-9" id="userMenus">

<input id="menuList1" name="menuList[]" type="checkbox" value="1" <?php //if(isset($_POST['menuList'])){if(in_array("1",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Dashboard

<input id="menuList2" name="menuList[]" type="checkbox" value="2" <?php //if(isset($_POST['menuList'])){if(in_array("2",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Big Live

<input id="menuList3" name="menuList[]" type="checkbox" value="3" <?php //if(isset($_POST['menuList'])){if(in_array("3",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Manage Queue

<input id="menuList4" name="menuList[]" type="checkbox" value="4" <?php //if(isset($_POST['menuList'])){if(in_array("4",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Manage Extension

<input id="menuList5" name="menuList[]" type="checkbox" value="5" <?php //if(isset($_POST['menuList'])){if(in_array("5",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Inbound Route

<input id="menuList6" name="menuList[]" type="checkbox" value="6" <?php //if(isset($_POST['menuList'])){if(in_array("6",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Outbound Route

<input id="menuList7" name="menuList[]" type="checkbox" value="7" <?php //if(isset($_POST['menuList'])){if(in_array("7",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Trunk

<input id="menuList8" name="menuList[]" type="checkbox" value="8" <?php //if(isset($_POST['menuList'])){if(in_array("8",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Users

<input id="menuList9" name="menuList[]" type="checkbox" value="9" <?php //if(isset($_POST['menuList'])){if(in_array("9",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> BlackList

<input id="menuList10" name="menuList[]" type="checkbox" value="10" <?php //if(isset($_POST['menuList'])){if(in_array("10",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Reports

<input id="menuList11" name="menuList[]" type="checkbox" value="11" <?php //if(isset($_POST['menuList'])){if(in_array("11",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Messaging

<input id="menuList12" name="menuList[]" type="checkbox" value="12" <?php //if(isset($_POST['menuList'])){if(in_array("12",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Phone Numbers

<input id="menuList13" name="menuList[]" type="checkbox" value="13" <?php //if(isset($_POST['menuList'])){if(in_array("13",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Manage Clients

<input id="menuList14" name="menuList[]" type="checkbox" value="14" <?php //if(isset($_POST['menuList'])){if(in_array("14",$_POST['menuList'])){echo "checked";}} ?>/><input type="hidden" name="_menuList" value="on"/> Manage IVR

</div>
</div> -->

				<div class="row form-group barge_radio_btn">
				<div class="col col-md-3">
				<label class=" form-control-label">Outbound Call</label>
				</div>
				<div class="col col-md-9">
				<div class="form-check-inline form-check" >
				<label for="inline-radio1" class="form-check-label " style="margin-right:15px; color:black;">
				<input id="tariff1" name="tariff" name="inline-radios" class="form-check-input" type="radio" value="1"/>Yes
				</label>
				<label for="inline-radio2" class="form-check-label " style="color:black;">
				<input id="tariff2" name="tariff" name="inline-radios" checked="true" class="form-check-input" type="radio" value="0" checked="checked"/>No
				</label>
				</div>
				</div>
				</div>



			
			<div class="form-group pull-right">
			 <button name="submit" value="submit" type="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			<p style="color:blue;"><?php echo $message; ?></p>
</form>
			
        </div>
    </div>
    </div>



</div>
</div>



</div>


</div>
<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("userMenus").innerHTML="";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("userMenus").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","userajax.php?q="+str,true);
  xmlhttp.send();
}
</script>

<?php require_once('footer.php'); ?> 
 
