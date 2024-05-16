<?php 
require_once('header.php'); 

$query_client = "SELECT Client.clientName,Client.clientId,Client.clientEmail FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection , $query_client);

$message = $error = '';
if(isset($_POST['submit']))
{
	if($_SESSION['userroleforpage'] == '2'){
		$_POST['clientId'] = $_SESSION['userroleforclientid'];
		$_POST['selectedUser'] = $_SESSION['login_user_id'];
	}
			
	$created_at = date('Y-m-d h:i:s');
	$updated_at = date('Y-m-d h:i:s');

	//$pager='default'; 		$tz='central'; 		$attach='yes'; 		$saycid='yes';		$callback='001'; 	$review='no'; 	$operator='no';
	//$envelope='no'; 		$sayduration='no'; 	$saydurationm='1';  $sendvoicemail='no';  $nextaftercmd='yes';  $forcename='no'; 		$forcegreetings='no'; 	$hidefromdir='yes'; 

	$insert_voiceMail = "UPDATE cc_voicemail_users set clientId='".$_POST['clientId']."', customer_id='".$_POST['selectedUser']."', context='".$_POST['context']."', mailbox='".$_POST['mailbox']."', `password`='".$_POST['password']."', fullname='".$_POST['fullname']."', email='".$_POST['mailTo']."', dialout='".$_POST['dialout']."' WHERE uniqueid = '".$_GET['id']."'";

	$result_voiceMail = mysqli_query($connection , $insert_voiceMail);
	if($result_voiceMail){
		$activity_type = 'Voice Mail Update';
			if($_SESSION['userroleforpage']=='1'){
				$msg = 'Mail Box No: '.$_POST['mailbox'].' '.'Voice Mail Update Succesfully! By Admin';
			}else{
				$msg = 'Mail Box No: '.$_POST['mailbox'].' '.'Voice Mail Update Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $msg);
		$_SESSION['msg'] = 'Voice Mail Information Updated Succesfully!';
		echo '<script>window.location.href="voicemail.php"</script>';
	}	
	
}


if(isset($_GET['id']) && $_GET['id'] !=''){
	$query_voice = "SELECT * FROM `cc_voicemail_users` WHERE uniqueid = '".$_GET['id']."'"; 
	$result_voice = mysqli_query($connection , $query_voice);	
	$row_voice = mysqli_fetch_assoc($result_voice);
	// echo '<pre>';print_r($row_voice);exit;
	$clientId 	= $row_voice['clientId'];
	$user_id 	= $row_voice['customer_id'];
	$context 	= $row_voice['context'];
	$mailbox 	= $row_voice['mailbox'];
	$password	= $row_voice['password'];
	$fullname	= $row_voice['fullname'];
	$email 		= $row_voice['email'];
	$dialout 	= $row_voice['dialout'];
	$query_user = "select * from users_login where clientId='".$clientId."'";
	$result_user_login = mysqli_query($connection , $query_user);

}else{
	$error ='true';
}
if($error=='true'){
	$message = 'Voice Mail Updated Succesfully!';
	header("Location: voicemail.php");
}

if($_SESSION['userroleforpage'] == 2 && $user_id !== $_SESSION['login_user_id']){ ?>
	<script>
    	window.location='access_denied.php';    
	</script>
<?php } 

$query_ex = "SELECT id, `name` FROM `cc_sip_buddies` WHERE clientId = '".$clientId."' and id_cc_card = '".$user_id."'"; 
$result_extension = mysqli_query($connection , $query_ex);

?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="overview-wrap">
				<h2 class="title-1">Voice Mail<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
				<div class="table-data__tool-right">
					<a href="voicemail.php">
						<button class="au-btn au-btn-icon au-btn--green au-btn--small">
					<i class="fa fa-eye" aria-hidden="true"></i> Voice Mail</button></a>
				</div>
			</div>
		</div>
	</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="voiceMailForm" action="" method="post">
			<?php //echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
			if($_SESSION['userroleforpage'] == '1'){  ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Client Name</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="clientId" data-show-subtext="false" data-live-search="true" name="clientId" class="form-control selectpicker" required>
							<option value="">Select</option>
							<?php while($row = mysqli_fetch_array($result_client)){ ?>
							<option value="<?php echo $row['clientId']; ?>"
							<?php if($row['clientId'] == $clientId){ echo 'selected';} ?>
							><?php echo $row['clientName'].'/'.$row['clientEmail']; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>			
				
				
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class="form-control-label">Select User*</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="selectedUser" name="selectedUser"  class="form-control" required >
							<?php 							
								while($row_user = mysqli_fetch_array($result_user_login)){ ?>
									<option value="<?php echo $row_user['id']; ?>"
									<?php if($row_user['id'] == $user_id){ echo 'selected'; } ?>
									><?php echo $row_user['name']; ?></option>
								<?php }
						 	 ?>
						</select><input type="hidden" name="_selectedUser" value="1"/>
					</div>
				</div>
				<?php }else{ ?>	
					<input id="clientId" name="clientId" value="<?php echo $clientId; ?>" type="hidden">
					<input id="selectedUser" name="selectedUser" value="<?php echo $user_id; ?>" type="hidden">

				<?php } ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Voice Mail ID</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="mailbox" name="mailbox" class="form-control-sm form-control" required>
						<?php
						     while($row_ex = mysqli_fetch_array($result_extension)){ ?>
							<option <?php if($row_ex['name'] == $mailbox) { echo 'selected="selected"'; }else { echo ''; } ?> value="<?php echo $row_ex['name']; ?>"><?php echo $row_ex['name']; ?></option>
						<?php } ?>
						</select>						
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Context*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="context" name="context" placeholder="context" class="form-control" type="text" value="<?php if(isset($_POST['context'])) { echo $_POST['context']; } else { echo $context; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Password*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="password" name="password" placeholder="password" class="form-control" type="text" value="<?php if(isset($_POST['password'])) { echo $_POST['password']; } else { echo $password; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Fullname</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="fullname" name="fullname" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['fullname'])) { echo $_POST['fullname']; } else { echo $fullname; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Mail To*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="mailTo" name="mailTo" placeholder="" class="form-control" type="email" value="<?php if(isset($_POST['mailTo'])) { echo $_POST['mailTo']; } else { echo $email; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Dialout*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="dialout" name="dialout" placeholder="10" value="<?php if(isset($_POST['dialout'])) { echo $_POST['dialout']; } else { echo $dialout; } ?>" class="form-control" type="text" />
					</div>
				</div>
		
				<div class="form-group pull-right">
					<button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
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
$( "select[name='clientId']" ).change(function () {
    var clientsID = $(this).val();
    if(clientsID) {
        $.ajax({
            url: "ajaxpro.php",
            dataType: 'Json',
            data: {'id':clientsID},
            success: function(data) {
                $('select[name="selectedUser"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });

				var selectedUser = $('#selectedUser').val();
				//alert(selectedUser);
				$.ajax({
					url: "ajaxGetExtensionByUser.php",
					dataType: 'Json',
					data: {'id':clientsID, 'selectedUser': selectedUser},
					success: function(data) {
						$('select[name="mailbox"]').empty();
						$.each(data, function(key, value) {
							$('select[name="mailbox"]').append('<option value="'+ key +'">'+ value +'</option>');
						});
					}
				});


            }
        });
    }else{
        $('select[name="selectedUser"]');
		$.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
    }
});
</script>

<?php require_once('footer.php'); ?> 
