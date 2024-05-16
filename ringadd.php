<?php require_once('header.php'); 

//$query_sip_buddies = "select name,regexten from cc_sip_buddies";
//$result_buddies = mysqli_query($connection , $query_sip_buddies);
//echo '<pre>'; print_r($_SESSION);exit;
$message = '';
$query_client = "SELECT Client.clientName,Client.clientEmail,Client.clientId FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=3 and users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection , $query_client);

if(isset($_POST['selectedUser'])) { 
	$query_user = "select * from users_login where clientId='".$_POST['clientId']."'";
	$result_user_login = mysqli_query($connection , $query_user);
}else{
	$_POST['clientId'] = '';
}
if(isset($_POST['stratergy'])){
	$stratergy = $_POST['stratergy'];
}else{
	$stratergy = '';
}

if(isset($_POST['submit']))
{
	$select_queuematch = "select ringno from cc_ring_group where ringno='".$_POST['ringno']."'";
	$query_card_queuematch = mysqli_query($con, $select_queuematch);
	if(mysqli_num_rows($query_card_queuematch) > 0){
	/* 	$rowqueuematch = mysqli_fetch_assoc($query_card_queuematch);
		$matchnamering = $rowqueuematch['ringno']; */	
	
		$message = 'Duplicate Ring Information,Please Change The Ring Number';
	}else{
		//echo '<pre>';print_r($_POST);exit;
		if($_SESSION['userroleforpage'] == '2'){
			$_POST['clientId'] = $_SESSION['userroleforclientid'];
			$_POST['selectedUser'] = $_SESSION['login_user_id'];
		}
		
		$selectedRingList ='';
		/*if(isset($_POST['ringlist'])){
			$selectedRingList = $_POST['ringlist'];		
			$selectedRingList = implode("-",$selectedRingList);		
		}
		*/
		$created_at = date('Y-m-d h:i:s');
		$updated_at = date('Y-m-d h:i:s');
		$errors = ''; // Initialize an empty array to store validation errors

// Validate form fields
if (empty($_POST['ringno'])) {
    $message="Please Generate Your Ring Extension";
}else{
		$insert_queue = "INSERT INTO cc_ring_group(ringno, strategy, ringtime , description, user_id, clientId) VALUES ('".$_POST['ringno']."','".$_POST['stratergy']."', '".$_POST['ringtime']."','".$_POST['description']."','".$_POST['selectedUser']."','".$_POST['clientId']."')";
		$result_queue = mysqli_query($connection , $insert_queue);
	
		if($result_queue){
			if($_SESSION['userroleforpage']=='1'){
				$activity_type = 'Ring Assign to User';
				$message = 'Ring No: '.$_POST['ringno'].' '.'Ring Added Successfully! By Admin';
			}else{
				$activity_type = 'Ring Added';
				$message = 'Ring No: '.$_POST['ringno'].' '.'Ring Added Succesfully! By User';
			}
			user_activity_log($_POST['selectedUser'], $_POST['clientId'], $activity_type, $message);
			$_SESSION['msg'] = 'Ring Added Succesfully!'; 
			echo '<script>window.location.href="ring.php"</script>';
			}	
		}
	}
}

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> Ring Add<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
						<div class="table-data__tool-right">
							<a href="ring.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
								<i class="fa fa-tty" aria-hidden="true"></i> Ring</button>
							</a>
						</div>
					</div>
				</div>
			</div>

			<div class="big_live_outer">
			<div class="row">
				<div class="col-md-12">
					<div class="queue_info">
						<form id="ringForm" action="" method="post">

						
						<?php //			echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
							if($_SESSION['userroleforpage'] == '1'){  ?>
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Client Name</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="clientId" data-show-subtext="false" data-live-search="true" name="clientId" class="form-control selectpicker" required>
											<option value="" >Select</option>
											<?php while($row = mysqli_fetch_array($result_client)){ ?>
											<option <?php if($row['clientId'] == $_POST['clientId']) { echo 'selected="selected"'; }else { echo ''; } ?> value="<?php echo $row['clientId']; ?>"><?php echo $row['clientName'].'/'.$row['clientEmail']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
							
								<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class="form-control-label">Select User*</label>
									</div>
									<div class="col-12 col-md-8">
										<select id="selectedUser" name="selectedUser" class="form-control" required>
											<option value="">Select</option>
											<?php if(isset($_POST['selectedUser'])) { 
											while($row_user = mysqli_fetch_array($result_user_login)){ ?>
											<option <?php if($row_user['id'] == $_POST['selectedUser']) { echo 'selected'; } ?> 
											value="<?php echo $row_user['id']; ?>"><?php echo $row_user['name']; ?></option>
										<?php }
									 } ?>
										</select>					
									</div>
								</div>
								<?php
							}else{ ?>
								<input id="clientId" name="clientId" value="<?php echo $_SESSION['userroleforclientid']; ?>" type="hidden">
								<input id="selectedUser" name="selectedUser" value="<?php echo $_SESSION['login_user_id']; ?>" type="hidden">				

							<?php }		?>		
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Ring Group Name*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="description" name="description" placeholder="" class="form-control" type="text" value="<?php if(isset($_POST['description'])) { echo $_POST['description']; } else { echo ''; } ?>"required/>
								</div>
							</div>	
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Ring Group Extension</label>
								</div>
								<div class="col-10 col-md-6">
									
									<input id="ringno" name="ringno" placeholder="0000" value="<?php if(isset($_POST['ringno'])) { echo $_POST['ringno']; } else { echo ''; } ?>" class="form-control" type="text"  readonly/>
								</div>
								<div class="col-2 col-md-2">
										<button type="button" class="btn btn-success btn-sm" id="genrateIntercom"><i
												class="fa fa-refresh" aria-hidden="true"></i> Generate</button>
									</div>
							</div>
							
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Ring Timeout**</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="ringtime" name="ringtime" placeholder="10" value="<?php if(isset($_POST['ringtime'])) { echo $_POST['ringtime']; } else { echo '60'; } ?>" class="form-control" type="text" />
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-4">
									<label for="selectSm" class=" form-control-label">Strategy</label>
								</div>
								<div class="col-12 col-md-8">
									<select id="stratergy" name="stratergy" class="form-control-sm form-control" required>
										<option  value="">Select</option>									
										<option <?php if($stratergy == 'ringall' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="ringall">Ringall</option>
										<option <?php if($stratergy == 'simultaneous' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="simultaneous">Simultaneous</option>
										<option <?php if($stratergy == 'rollover' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="rollover">Rollover</option>
										<option <?php if($stratergy == 'random' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="random">Random</option>
										<option <?php if($stratergy == 'sequence' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="sequence">Sequence</option>

									</select>
								</div>
							</div>		
							<?php /*
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Ring List</label>
								</div>
								<div class="col-12 col-md-9">
								
								<div style="color:green;">Use Ctrl Key to Select Multiple Users.</div>
								<select id="ringlist" name="ringlist[]" style="height: 100px !important;" class="form-control" multiple>
									<?php while($row_buddies = mysqli_fetch_array($result_buddies)){ ?>
									<option value="<?php echo $row_buddies['name']; ?>"><?php echo $row_buddies['name']; ?></option>
									<?php } ?>
									</select>
									
								</div>
							</div>
							*/?>



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
            }
        });
    }else{
        $('select[name="selectedUser"]');
		$.each(data, function(key, value) {
            $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
        });
    }
});
$(document).ready(function(){
	$('#genrateIntercom').click(function (){
		genrateIntercom();
	});
	function genrateIntercom(){
		$.ajax({
			url : "ajaxCreateIntercom.php",
			type : 'post',
			data : {data_type : 'ring'},
			success : function(data){
				$('#ringno').val(data);
			}
		});
	}
});
</script>

<?php require_once('footer.php'); ?> 
 
