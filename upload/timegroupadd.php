<?php
 require_once('header.php');

 $query_client = "select * from Client";
 $result_client = mysqli_query($connection , $query_client);
 if(isset($_POST['selectedUser'])) { 
	$query_user = "select * from users_login where clientId='".$_POST['clientId']."'";
	$result_user_login = mysqli_query($connection , $query_user);
}else{
	$_POST['clientId'] = '';
}
//  $user_id= $_SESSION['login_user_id'];
//  $client_id = $_SESSION['userroleforclientid'];

 $sch_call	= isset($_POST['sch_call']) ? $_POST['sch_call'] : '';
$starttime	= isset($_POST['starttime'])? $_POST['starttime']: '';
$stoptime	= isset($_POST['stoptime']) ? $_POST['stoptime'] : '';
$startday	= isset($_POST['startday']) ? $_POST['startday'] : '';
$stopday	= isset($_POST['stopday'])  ? $_POST['stopday']  : '';
$all_time	= isset($_POST['all_time']) ? $_POST['all_time'] : '';
$message    = isset($_POST['message'])? $_POST['message']: '';
$dest_startday = "";
$dest_stopday = "";
$dest_all_time = "";
$dest_playback = "";
$message = "";
$destination = "";
$time_image = "";
$message = "";

if(isset($_POST['submit'])){
    
	// echo"<pre>";print_r($_POST);exit;

    $destination = $_POST['destination_no'];

	$destination_type = $_POST['destination_type'];

    //  $sch_call = $_POST[''];

    $starttime = $_POST['starttime'];

    $stoptime = $_POST['stoptime'];

    $startday = $_POST['startday'];

    $stopday = $_POST['stopday'];

    $all_time = $_POST['all_time'];

	$message = $_POST['messages'];
	if($_SESSION['userroleforpage'] == '2'){
		$_POST['clientId'] = $_SESSION['userroleforclientid'];
		$_POST['selectedUser'] = $_SESSION['login_user_id'];
	}

	
	    $filename = $_FILES["ivr_file"]["name"];
	     $tempname  = $_FILES["ivr_file"]["tmp_name"];
		 $folder = "timegroup/".$user_id."_".$filename;
		 move_uploaded_file($tempname,$folder);
		 $FileType = (pathinfo($filename,PATHINFO_EXTENSION));

	// echo '<pre>'; print_r($_POST);exit;
	$insert_time_group = "INSERT INTO `cc_time_group`(`destination_type`,`destination`,`sch_call`,`starttime`,`stoptime`,`startday`,`stopday`,`all_time` , `message`, `ivr_file`, `user_id` , `client_id`)VALUES('".$destination_type."','".$destination."','1' , '".$starttime."' , '".$stoptime."','".$startday."','".$stopday."', '".$all_time."' , '".$message."','".$filename."', '".$_POST['selectedUser']."' , '".$_POST['clientId']."')";
	$result_time = mysqli_query($connection , $insert_time_group);

	$message = 'Time Group Added Succesfully!';
}

?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
	<input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['login_user_id']?>">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1">Time Groups<span style="margin-left:50px;color:blue;"></span></h2>
						<div class="table-data__tool-right">
						<a href="timegroup.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
								<i class="fa fa-tty" aria-hidden="true"></i>Timegroup</button>
							</a>
						</div>
					</div>
				</div>
			</div>
			<p style="color:blue;"><?php echo $message; ?></p>
           
                
            <div class="big_live_outer">
			<div class="row">
				<div class="col-md-12">
					<div class="queue_info">
			           <form id="form" name="form" action="" method="post" enctype="multipart/form-data">
					   <?php //			echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
							if($_SESSION['userroleforpage'] == '1'){  ?>
								<div class="row form-group">
									<div class="col col-md-3">
										<label for="text-input" class="form-control-label">Client Name</label>
									</div>
									<div class="col-12 col-md-9">
										<select id="clientId" name="clientId" class="form-control" required>
											<option value="0" selected="selected">Select</option>
											<?php 
											if(mysqli_num_rows($result_client) >0){
											while($row = mysqli_fetch_array($result_client)){ ?>
											<option <?php if($row['clientId'] == $_POST['clientId']) { echo 'selected="selected"'; }else { echo ''; } ?> value="<?php echo $row['clientId']; ?>"><?php echo $row['clientName']; ?></option>
											<?php } } ?>
										</select>
									</div>
								</div>
							
								<div class="row form-group">
									<div class="col col-md-3">
										<label for="text-input" class="form-control-label">Select User*</label>
									</div>
									<div class="col-12 col-md-9">
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

							<?php }		?>	
                
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination Type</label>
                </div>
				<?php 
					//$select_destination = "SELECT * FROM `cc_selection_did`";
					//$res_destination = mysqli_query($connection,$select_destination); ?>
					
                <div class="col-12 col-md-9">
                <select id="destination_type" rel="destination_no" name="destination_type" class="form-control">				
				<option value="">------SELECT------</option>
				
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
						<?php echo $options;?>

				</select>
                </div>
                </div>
				
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination</label>
                </div>
                <div class="col-12 col-md-9" id="destinationSelect">
					<select name="destination_no" id="destination_no" class="form-control">
						<option value="">None</option>
					</select>
					</div>
					</div>

                


				<div class="showhideForm" id="dataDiv">
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Start Time</label>
				</div>
				<div class="col-12 col-md-9">
				<input type="time" class="form-control" name="starttime" value="<?php if(isset($_POST['starttime'])) { echo $_POST['starttime'];} else { echo'';}?>" id="starttime"  >
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Stop Time</label>
				</div>
				<div class="col-12 col-md-9">
				<input type="time" class="form-control" name="stoptime" value="<?php if(isset($_POST['stoptime'])) { echo $_POST['stoptime']; } else { echo ''; } ?>" id="stoptime">
				</div>
				</div>

				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Start Day</label>
				</div> 
				<div class="col-12 col-md-9">
				<select id="all_time" name="startday" class="form-control">
				<option <?php if(isset($_POST['startday']) && $_POST['startday'] == 'sunday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="sunday">sunday</option>
				<option <?php if(isset($_POST['startday'])&& $_POST['startday'] == 'monday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="monday">monday</option>
				<option <?php if(isset($_POST['startday'])&& $_POST['startday'] == 'tuesday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="tuesday">tuesday</option>
				<option <?php if(isset($_POST['startday']) && $_POST['startday']== 'wednesday' ) { echo 'selected="selected"'; } else { echo ''; } ?>value="wednesday">wednesday</option>
				<option <?php if(isset($_POST['startday'])&& $_POST['startday'] == 'thursday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="thursday">thursday</option>
				<option <?php if(isset($_POST['startday'])&& $_POST['startday'] == 'friday')   { echo 'selected="selected"';} else  { echo'';} ?> value="friday">friday</option>
				<option <?php if(isset($_POST['startday'])&& $_POST['startday']== 'saturday') { echo 'selected="selected"'; } else{echo''; } ?> value="saturday">saturday</option>
				</select>
			

				
				<!-- <input type="datetime-local" class="form-control" name="startday" id="Test_DatetimeLocal"> -->
				</div>
				</div>				


				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Stop Day</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="all_time" name="stopday" class="form-control">
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday'] == 'sunday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="sunday">sunday</option>
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday'] == 'monday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="monday">monday</option>
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday'] == 'tuesday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="tuesday">tuesday</option>
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday']== 'wednesday' ) { echo 'selected="selected"'; } else { echo ''; } ?>value="wednesday">wednesday</option>
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday'] == 'thursday' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="thursday">thursday</option>
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday'] == 'friday')   { echo 'selected="selected"';} else  { echo'';} ?> value="friday">friday</option>
				<option <?php if(isset($_POST['stopday']) && $_POST['stopday']== 'saturday') { echo 'selected="selected"'; } else{echo''; } ?> value="saturday">saturday</option>
				</select>
				<!-- <input type="datetime-local" class="form-control" name="stopday" id="Test_DatetimeLocal"> -->
				</div>
				</div>				

				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">All time</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="all_time" name="all_time" class="form-control">
				<option <?php if(isset($_POST['all_time']) && $_POST['all_time'] == '1') { echo 'selected="selected"'; } else{echo'';} ?> value="1">Yes</option>
				<option <?php if (isset($_POST['all_time']) && $_POST['all_time'] == '0') { echo 'selected="selected"'; } else{echo'';} ?> value="0">No</option>
				</select>
				</div>
                 </div>
                 <div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Off Hours Messages</label>
				</div>
				<div class="col-12 col-md-9">
				<textarea class="form-control" name="messages" id="Test_DatetimeLocal" placeholder="Type Your Off Hours Messages" ><?php if(isset($_POST['messages'])) { echo $_POST['messages']; } else { echo ''; }?></textarea>

				</div>
				</div>
                <div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">IVR File</label>
				</div>
				<div class="col-12 col-md-9">
				<input class="form-control" name="ivr_file" id="ivr_file" type="file">
				<!-- <audio  name="ivr_file" id="ivr_file" type="audio/wav"></audio> -->
				<!-- <audio type="audio/wav" src="<?php //echo $folder?>" controls="" controlslist="nodownload" > </audio> -->
				
				</div>
				</div>
                 <input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['login_user_id']?>" />
				
			<div class="form-group pull-right">
			 <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>	
</div>
</div>
</div>
</div>

</form>
<script>
	<?php if($_SESSION['userroleforpage'] == '2'){ ?>
	$(document).on('change', '#destination_type', function(){
            
            var user_id = $("#user_id").val();
            var id = $(this).val();
                $.ajax({
                    url : "ajax_selection_did.php",
                    type : "GET",
                    data : {q : id, user_id : user_id},
                    success : function(data){
                        $("#destination_no").html(data);
                    }
                });
        });
		<?php }else{ ?>
			$(document).on('change', '#destination_type', function(){
            
            var user_id = $("#selectedUser").val();
            var id = $(this).val();
                $.ajax({
                    url : "ajax_selection_did.php",
                    type : "GET",
                    data : {q : id, user_id : user_id},
                    success : function(data){
                        $("#destination_no").html(data);
                    }
                });
        });
			<?php } ?>
	</script>
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
</script>
<?php require_once('footer.php'); ?> 