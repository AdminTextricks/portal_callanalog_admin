<?php 
require_once('header.php'); 
$query_client = "SELECT Client.clientName,Client.clientId,Client.clientEmail FROM `Client` LEFT JOIN `users_login` ON Client.clientId = users_login.clientId WHERE users_login.role !=3 and users_login.role !=4 and users_login.status = 'Active' and users_login.deleted = '0'";
$result_client = mysqli_query($connection , $query_client);
if(isset($_POST['selectedUser'])) { 
	$query_user = "select * from users_login where clientId='".$_POST['clientId']."'";
	$result_user_login = mysqli_query($connection , $query_user);
}else{
	$_POST['clientId'] = '';
}
$user_uid = '';
if(isset($_POST['submit'])){
	$message = '';
	$ivrname = $_POST['ivrname'];
	$ivr_desc = $_POST['ivr_desc'];
	$announcement = $_POST['announcement'];
	$timeout = $_POST['timeout'];
	$ivrstatus = $_POST['ivrstatus'];
	$createdat = date("Y-m-d H:i:s");
	if($_SESSION['userroleforpage'] == '2'){
		$_POST['clientId'] = $_SESSION['userroleforclientid'];
		$_POST['selectedUser'] = $_SESSION['login_user_id'];
	}

	$user_uid = $_POST['selectedUser'];

	$ivr_sql = "INSERT INTO `ivr`(`user_id`,`clientId`,`ivr_name`,`ivr_description`,`ivr_announcement`,`ivr_timeout`,`created_at`,`ivr_status`) VALUES ('".$_POST['selectedUser']."','".$_POST['clientId']."','".$ivrname."','".$ivr_desc."','".$announcement."','".$timeout."','".$createdat."','".$ivrstatus."')";

	$ivr_res = mysqli_query($connection, $ivr_sql) or die("query failed : ivr_res");
	
	$ivr_last_id = mysqli_insert_id($connection);

	for($i=0;$i<count($_POST['digit']); $i++){
		$digit = $_POST['digit'][$i];
		$dest_type = $_POST['destination_type'][$i];
		$dest_no = $_POST['destination_no'][$i];


		$ivr_otp_sql = "INSERT INTO `ivr_option`(`ivr_id`,`input_digit`,`ivr_dest_type`,`ivr_dest_no`,`created_at`) VALUES('".$ivr_last_id."','".$digit."','".$dest_type."','".$dest_no."','".$createdat."')";

		$res_ivr_opt = mysqli_query($connection, $ivr_otp_sql) or die("query failed : ivr_otp_sql");
	} 
	if($ivr_res and $res_ivr_opt){
		$_SESSION['msg'] = "IVR Information Add Successfully";
		echo '<script>window.location.href="ivr.php"</script>';
	}
}
?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">IVR Add<span style="margin-left:50px;color:blue;"><?php if(isset($_POST['submit'])){echo $message;} ?></span></h2>
						<div class="table-data__tool-right">
							<a href="ivr.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
								<i class="fa fa-tty" aria-hidden="true"></i>IVR</button>
							</a>
						</div>
					</div>
				</div>
			</div>
			<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" >	
				<div class="big_live_outer">
					<div class="row">
						<div class="col-md-12">
							<div class="queue_info">
								<?php 
									if($_SESSION['userroleforpage'] == '1'){  ?>
										<div class="row form-group">
											<div class="col col-md-4">
												<label for="text-input" class=" form-control-label">Client Name</label>
											</div>
											<div class="col-12 col-md-8">
												<select id="clientId" data-show-subtext="false" data-live-search="true" name="clientId" class="form-control selectpicker " required>
													<option value="0" selected="selected">Select</option>
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
													<option value="0" selected="selected">Select</option>
													<?php if(isset($_POST['selectedUser'])) { 
													while($row_user = mysqli_fetch_array($result_user_login)){ ?>
													<option <?php if($row_user['id'] == $_POST['selectedUser']) { echo 'selected'; } ?> 
													value="<?php echo $row_user['id']; ?>"><?php echo $row_user['name']; ?></option>
												<?php } } ?>
												</select>					
											</div>
										</div>
									<?php
										}else{ ?>
											<input id="clientId" name="clientId" value="<?php echo $_SESSION['userroleforclientid']; ?>" type="hidden">
											<input id="selectedUser" name="selectedUser" value="<?php echo $_SESSION['login_user_id']; ?>" type="hidden">				
									<?php } ?>	
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">IVR Name</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="ivrname" name="ivrname" placeholder="IVR NAME" class="form-control" type="text" value="<?php if(isset($_POST['ivrname'])){echo $_POST['ivrname'];}else{echo '';} ?>" required/>
										</div>								
									</div>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">IVR Description</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="ivr_desc" name="ivr_desc" placeholder="IVR Description" class="form-control" type="text" value="<?php if(isset($_POST['ivr_desc'])){echo $_POST['ivr_desc'];}else{echo '';} ?>" required/>
										</div>								
									</div>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Announcement</label>
										</div>
										<div class="col-12 col-md-8">
											<select name="announcement" id="announcement" class="form-control" required>
												<option value="">None</option>
											<?php 
											if($_SESSION['userroleforpage'] == '2'){
												$rec_sql = "SELECT `id`,`upload_music`,`name` FROM `music` WHERE `user_id` ='".$_SESSION['login_user_id']."'";
												$rec_res = mysqli_query($connection, $rec_sql) or die("query failed"); ?>
												<?php 
												if(mysqli_num_rows($rec_res)>0){
													while($rec_row = mysqli_fetch_assoc($rec_res)){ 
														if(isset($_POST['announcement']) && $_POST['announcement'] ==$rec_row['id']){
															$select = "selected";
														}else{
															$select = "";
														}
														?>
														<option <?php echo $select; ?> value="<?php echo $rec_row['id']; ?>"><?php echo $rec_row['name']; ?></option>
												<?php }  }  }?>
											</select>
										</div>
									</div>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">Timeout</label>
										</div>
										<div class="col-12 col-md-8">
											<input id="timeout" name="timeout" max="60" class="form-control" type="number" value="<?php if(isset($_POST['timeout'])){echo $_POST['timeout'];}else{echo '';} ?>" required/>
										</div>								
									</div>
									<div class="row form-group">
										<div class="col col-md-4">
											<label for="text-input" class=" form-control-label">IVR Status</label>
										</div>
										<div class="col-12 col-md-8">
											<select name="ivrstatus" id="ivrstatus" class="form-control" required>
												<option value="">None</option>
												<option 
												<?php 
												if(isset($_POST['ivrstatus']) && $_POST['ivrstatus']=="1"){
													echo "selected";
												}
												?>
												value="1">Enable</option>
												<option
												<?php 
												if(isset($_POST['ivrstatus']) && $_POST['ivrstatus']=="0"){
													echo "selected";
												}
												?>
												value="0">Disable</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<table id="queueTable" class="table manage_queue_table">
						<thead>
							<tr>
								<th>Input Digit</th>
								<th>Choose Destination Type</th>
								<th>Destination</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="dynamicadd">
							<?php
							
							if(isset($_POST['digit'])){
		
								foreach($_POST['digit'] as $key => $des_type ){
									
								?>
							<tr class="tr-shadow">
								<td> <input id="digit" name="digit[]" placeholder="Input Digit" class="form-control" type="number" max="9" value="<?php echo $_POST['digit'][$key]; ?>" required/></td>
								<td>
									<?php 
									$options = '';
									$select_destination = "SELECT * FROM `cc_selection_did`";
									$res_destination = mysqli_query($connection,$select_destination); 
									if(mysqli_num_rows($res_destination) > 0){
										while($row = mysqli_fetch_assoc($res_destination)){
											$options .= '<option ';
											if(isset($_POST['destination_type'][$key]) && $_POST['destination_type'][$key]== $row['id']){
												$options .="selected";
											}
											$options .= ' value="'.$row['id'].'">'.$row['selection_value'].'</option>';
										}
									}
									?>
									<select id="destination_typ" rel="destination_no<?php echo $key; ?>" name="destination_type[]" class="form-control destination_type" required>	
									<option value="">Select Destination Type</option>
									<?php echo $options;?>
									</select>
								</td>
								<td> 	
								<select id="destination_no<?php echo $key; ?>" name="destination_no[]" class="form-control" required>				
									<option value="">Select Destination</option>
									<?php if($_POST['destination_type'][$key] == 1) { 
											$query_queue = "select * from cc_queue_table where assigned_user='". $user_uid."'";
											$result_queue = mysqli_query($connection , $query_queue);
											while($row_sip = mysqli_fetch_array($result_queue)){ 
											?>
											<option <?php if(trim($_POST['destination_no'][$key]) == trim($row_sip["name"]) ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_sip["name"]; ?>" ><?php echo $row_sip["name"]; ?> </option>
										<?php } 
										
										}elseif($_POST['destination_type'][$key] == 2){
											$query_ext = "select * from cc_sip_buddies where id_cc_card='". $user_uid."'";
											$result_ext = mysqli_query($connection , $query_ext);
											while($row_ext = mysqli_fetch_array($result_ext)){  ?>
												<option <?php if(trim($_POST['destination_no'][$key]) == trim($row_ext["name"]) ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_ext["name"]; ?>" ><?php echo $row_ext["name"]; ?> </option>
												
											<?php	} 
												
										}elseif($_POST['destination_type'][$key] == 3){
											$query_vm = "select * from cc_voicemail_users where customer_id='". $user_uid."'";
											$result_vm = mysqli_query($connection , $query_vm);

											while($row_vm = mysqli_fetch_array($result_vm)){  ?>
												<option <?php if(trim($_POST['destination_no'][$key]) == trim($row_vm["name"]) ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_vm["mailbox"]; ?>"><?php echo $row_vm["mailbox"]; ?></option>';
											<?php }
												
										}elseif($_POST['destination_type'][$key] == 5){

											$query_booking = "select * from booking where user_id='". $user_uid."'";
											$result_booking = mysqli_query($connection , $query_booking);

											while($row_book = mysqli_fetch_array($result_booking)){ ?>
												<option <?php if(trim($row_book["confno"]) == trim($_POST['destination_no'][$key]) ) { echo 'selected="selected"'; } else { echo ''; } ?>  value="<?php echo $row_book["confno"] ?> "><?php echo $row_book["confno"]; ?></option>
											<?php }
										}elseif($_POST['destination_type'][$key] == 6){
										
											$query_ring = "select * from cc_ring_group where user_id='". $user_uid."'";
											$result_ring = mysqli_query($connection , $query_ring); 
											while($row_ring = mysqli_fetch_array($result_ring)){ ?>
												<option <?php if(trim($row_ring["ringno"]) == trim($_POST['destination_no'][$key] ) ) { echo 'selected="selected"'; } else { echo ''; } ?>  value="<?php echo $row_ring["ringno"] ?> "><?php echo $row_ring["ringno"]; ?></option>
											<?php } 
										}else{
											echo '<input type="text" id="destination" name="destination_no[]" class="form-control" value='.$_POST['destination_no'][$key].'>';
										}
			   
			  					?>	
								</select></td>
								<td>
								<?php if($key == 0){ ?>	
								<button type="button" id="add" name="add" value="" class="btn btn-primary">+</button>
							<?php }else{ ?>
								<button id="<?php echo $key; ?>" name="remove" class="btn btn-danger remove_row">-</button>
								<?php } ?>
							</td>
							</tr>
							<?php } }else{?>
								<tr class="tr-shadow">
								<td> <input id="digit" name="digit[]" placeholder="Input Digit" class="form-control" type="number" value="<?php if(isset($_POST['digit'])){echo $_POST['digit'];}else{echo '';} ?>" required/></td>
								<td>
									<?php 
									$options = '';
									$select_destination = "SELECT * FROM `cc_selection_did`";
									$res_destination = mysqli_query($connection,$select_destination); 
									if(mysqli_num_rows($res_destination) > 0){
										while($row = mysqli_fetch_assoc($res_destination)){
											$options .= '<option value="'.$row['id'].'">'.$row['selection_value'].'</option>';
										}
									}
									?>
									<select id="destination_typ" rel="destination_no" name="destination_type[]" class="form-control destination_type" required>	
									<option value="">Select Destination Type</option>
									<?php echo $options;?>
									</select>
								</td>
								<td> 	
								<div id="destination_no">
								<select name="destination_no[]" class="form-control destination_no" required>				
									<option value="">Select Destination</option>

								</select>
								</div>
							</td>
								<td><button type="button" id="add" name="add" value="" class="btn btn-primary">+</button></td>
							</tr>
								<?php }?>
						</tbody>
					</table>
					<div class="form-group pull-right" style="margin-right:400px;">
						<input type="submit" name="submit" value="Submit" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
<script>
   $(document).ready(function(){
	var option = '<?php echo $options ?>';
		var i=1;
		$("#add").on("click",function(e){	
			e.preventDefault();		
			$("#dynamicadd").append('<tr id = "row'+i+'" class="tr-shadow"><td><input id="digit" max="9" name="digit[]" placeholder="Input Digit" class="form-control" type="number" value="" required/></td><td> <select id="destination_typ'+i+'"  name="destination_type[]" rel="destination_no'+i+'" class="form-control destination_type" required><option value="">Select Destination Type</option>'+option+'</select></td><td> <div id="destination_no'+i+'"><select name="destination_no[]" class="form-control destination_no" required><option value="">Select Destination</option></select></div></td><td> <button id="'+i+'" name="remove" class="btn btn-danger remove_row">-</button></td></tr>');
			i++;
		});
		$(document).on("click",".remove_row",function(){
				var row_id = $(this).attr('id');
				$('#row'+row_id+'').remove();
				i--;	
		});
		
		$(document).on('change', '.destination_type', function(){
			var dyid = $(this).attr('rel');
			var user_id = $("#selectedUser").val();
			// alert(user_id);
			var id = $(this).val();
				$.ajax({
					url : "ajax_selection_did.php",
					type : "GET",
					data : {q : id, user_id : user_id},
					success : function(data){
						$('#'+dyid).html(data);
					}
				});
		});

		// $("select[name='selectedUser']").change(function () {
		// 	var selectedUSERS = $(this).val();
		// 	// alert(selectedUSERS);
			
		// });
		
   });
   $( "select[name='clientId']" ).change(function () {
    var clientsID = $(this).val();
	$('.destination_type').prop('selectedIndex', 0);
	$('.destination_no')
		.find('option')
		.remove()
		.end()
		.append('<option value="">Select</option>');


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

$( "select[name='clientId']" ).change(function () {
    var selectedUSERS = $(this).val();
    if(selectedUSERS) {
        $.ajax({
            url: "ajaxannouncement.php",
            dataType: 'Json',
            data: {'id':selectedUSERS},
            success: function(data) {
                $('select[name="announcement"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="announcement"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });
    }else{
        $('select[name="announcement"]');
		$.each(data, function(key, value) {
			$('select[name="announcement"]').append('<option value="'+ key +'">'+ value +'</option>');
		});
    }
});
</script>
 <?php require_once('footer.php'); ?>