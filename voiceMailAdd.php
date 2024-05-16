<?php 
require_once('header.php'); 

$query_client = "SELECT Client.clientName,Client.clientId,Client.clientEmail FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=3 and users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection , $query_client);

if(isset($_POST['selectedUser'])) { 
	$query_user = "select * from users_login where clientId='".$_POST['clientId']."'";
	$result_user_login = mysqli_query($connection , $query_user);
}
$message = '';
if($_SESSION['userroleforpage'] == '2'){
	$_POST['clientId'] = $_SESSION['userroleforclientid'];
	$_POST['selectedUser'] = $_SESSION['login_user_id'];
}
if(isset($_POST['submit']))
{	
	// echo '<pre>'; print_r($_POST); echo '</pre>';exit;
	$select_voiceMail = "select mailbox from cc_voicemail_users where mailbox='".$_POST['mailbox']."'";
	$query_voiceMail = mysqli_query($con, $select_voiceMail);
	if(mysqli_num_rows($query_voiceMail) > 0 ){
		$message = 'Voice Mail Information Already added';
	}else{
		
		$created_at = date('Y-m-d h:i:s');
		$updated_at = date('Y-m-d h:i:s');

		$pager='default'; 		$tz='central'; 		$attach='yes'; 		$saycid='yes';		$callback='001'; 	$review='no'; 	$operator='no';
		$envelope='no'; 		$sayduration='no'; 	$saydurationm='1';  $sendvoicemail='no';  $nextaftercmd='yes';  $forcename='no'; 		$forcegreetings='no'; 	$hidefromdir='yes'; 

		$insert_voiceMail = "INSERT INTO cc_voicemail_users(clientId, customer_id, context, mailbox, `password`, fullname, email, dialout, pager, tz, `attach`, saycid,  callback, review, operator, envelope, sayduration, saydurationm, sendvoicemail, nextaftercmd, forcename, forcegreetings, hidefromdir) VALUES ('".$_POST['clientId']."','".$_POST['selectedUser']."', '".$_POST['context']."','".$_POST['mailbox']."','".$_POST['password']."','".$_POST['fullname']."', '".$_POST['mailTo']."', '".$_POST['dialout']."', '".$pager."', '".$tz."', '".$attach."', '".$saycid."', '".$callback."', '".$review."', '".$operator."', '".$envelope."', '".$sayduration."', '".$saydurationm."', '".$sendvoicemail."', '".$nextaftercmd."', '".$forcename."', '".$forcegreetings."', '".$hidefromdir."')";

		$result_voiceMail = mysqli_query($connection , $insert_voiceMail);
		if($result_voiceMail){
			if($_SESSION['userroleforpage']=='1'){
				$activity_type = 'Voice Mail Assign to User';
				$msg = 'Mail Box No.: '.$_POST['mailbox'].' '.'Voice Mail Added Succesfully! By Admin';
			}else{
				$activity_type = 'Voice Mail Added By User';
				$msg = 'Mail Box No.: '.$_POST['mailbox'].' '.'Voice Mail Added Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'],$_POST['clientId'], $activity_type, $msg);
			$_SESSION['msg'] = 'Voice Mail Information Added Succesfully!';
			echo '<script>window.location.href="voicemail.php"</script>';
		}	
	}
}

if(isset($_POST['mailbox']) || $_SESSION['userroleforpage'] == '2') { 
	$query_ex = "SELECT id, `name` FROM `cc_sip_buddies` WHERE clientId = '".$_POST['clientId']."' and id_cc_card = '".$_POST['selectedUser']."'"; 
	$result_extension = mysqli_query($connection , $query_ex);	
} ?>

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
							<?php if($row['clientId'] == $_POST['clientId']){ echo 'selected';} ?>
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
							if(isset($_POST['selectedUser'])) {
								while($row_user = mysqli_fetch_array($result_user_login)){ ?>
								<option value="<?php echo $row_user['id']; ?>"
								<?php if($row_user['id'] == $_POST['selectedUser']){ echo 'selected'; } ?>
								><?php echo $row_user['name']; ?></option>
								<?php }
						 	} ?>
						</select><input type="hidden" name="_selectedUser" value="1"/>
					</div>
				</div>
				<?php }else{ ?>	
					<input id="clientId" name="clientId" value="<?php echo $_SESSION['userroleforclientid']; ?>" type="hidden">
					<input id="selectedUser" name="selectedUser" value="<?php echo $_SESSION['login_user_id']; ?>" type="hidden">

				<?php } ?>
				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Voice Mail ID</label>
					</div>
					<div class="col-12 col-md-8">
						<select id="mailbox" name="mailbox" class="form-control-sm form-control" required>
						<?php if(isset($_POST['mailbox']) || $_SESSION['userroleforpage'] == '2') { 
						     while($row_ex = mysqli_fetch_array($result_extension)){ ?>
							<option <?php if(isset($_POST['mailbox']) && $row_ex['name'] == $_POST['mailbox']) { echo 'selected="selected"'; }else { echo ''; } ?> value="<?php echo $row_ex['name']; ?>"><?php echo $row_ex['name']; ?></option>
						<?php } } ?>
						</select>						
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Context*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="context" name="context" placeholder="context" class="form-control" type="text" value="<?php if(isset($_POST['context'])) { echo $_POST['context']; } else { echo 'default'; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Password*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="password" name="password" placeholder="password" class="form-control" type="text" value="<?php if(isset($_POST['password'])) { echo $_POST['password']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Fullname</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="fullname" name="fullname" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['fullname'])) { echo $_POST['fullname']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="selectSm" class=" form-control-label">Mail To*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="mailTo" name="mailTo" placeholder="" class="form-control" type="email" value="<?php if(isset($_POST['mailTo'])) { echo $_POST['mailTo']; } else { echo ''; } ?>"/>
					</div>
				</div>

				<div class="row form-group">
					<div class="col col-md-4">
						<label for="text-input" class=" form-control-label">Dialout*</label>
					</div>
					<div class="col-12 col-md-8">
						<input required id="dialout" name="dialout" placeholder="10" value="<?php if(isset($_POST['dialout'])) { echo $_POST['dialout']; } else { echo '60'; } ?>" class="form-control" type="text" />
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
