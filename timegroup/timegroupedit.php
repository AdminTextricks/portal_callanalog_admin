<?php
 require_once('header.php');
 $user_id= $_GET['id'];

 $timegroup_sql = "SELECT * FROM `cc_time_group` WHERE `id` = '".$user_id."'";
 $timegroup_res = mysqli_query($connection, $timegroup_sql) or die("query failed : timegroup_sql");
 if(mysqli_num_rows($timegroup_res) > 0){
	while($row = mysqli_fetch_assoc($timegroup_res)){

		// echo '<pre>'; print_r($row);
		$destination_type = $row['destination_type'];
		$fetch_destination = $row['destination'];
		$fetch_starttime = $row['starttime'];
		$fetch_stoptime = $row['stoptime'];
		$fetch_startday = $row['startday'];
		$fetch_stopday = $row['stopday'];
		$fetch_all__time = $row['all_time'];
		$fetch_message = $row['message'];
		$fetch_ivr_file = $row['ivr_file'];
		$userId = $row['user_id'];
	}
 }

//  echo $user_id;exit;
 $sch_call	= isset($_POST['sch_call']) ? $_POST['sch_call'] : '';
$starttime	= isset($_POST['starttime'])? $_POST['starttime']: '';
$stoptime	= isset($_POST['stoptime']) ? $_POST['stoptime'] : '';
$startday	= isset($_POST['startday']) ? $_POST['startday'] : '';
$stopday	= isset($_POST['stopday'])  ? $_POST['stopday']  : '';
$all_time	= isset($_POST['all_time']) ? $_POST['all_time'] : '';

$dest_startday = "";
$dest_stopday = "";
$dest_all_time = "";
$dest_playback = "";
$message = "";
$destination = "";
$fetch_startday = "";
$fetch_stopday = "";
$fetch_all__time = "";
$fetch_message = "";


if(isset($_POST['update'])){

    $destination_type = $_POST['destination_type'];
    $destination = $_POST['destination_no'];
    $starttime = $_POST['starttime'];
    $stoptime = $_POST['stoptime'];
    $startday = $_POST['startday'];
    $stopday = $_POST['stopday'];
    $all_time = $_POST['all_time'];
	$message = $_POST['messages'];

	$filename = $_FILES["ivr_file"]["name"];
	$tempname  = $_FILES["ivr_file"]["tmp_name"];
	$folder = "timegroup/".$user_id."_".$filename;
	move_uploaded_file($tempname,$folder);
	$FileType =  (pathinfo($filename,PATHINFO_EXTENSION));

	// echo '<pre>'; print_r($_POST);exit;
	$update_time_group = " UPDATE `cc_time_group` SET `destination_type`='".$destination_type."', `destination` = '".$destination."' , `starttime`= '".$starttime."',`stoptime`='".$stoptime."', `startday`='".$startday."', `stopday`='".$stopday."', `all_time`='".$all_time."',`message`='".$message."' WHERE `id`='".$user_id."'";
//  echo $update_time_group; exit;
     $update_result_time = mysqli_query($connection , $update_time_group) or die("query failed : update_time_group");

}


?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
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

           
                
            <div class="big_live_outer">
			<div class="row">
				<div class="col-md-12">
					<div class="queue_info">
						<form id="form" name="form" action="" method="post" enctype="multipart/form-data">
                        <!-- <div class="row form-group">
					<div class="col col-md-3">
						<label for="text-input" class="form-control-label">DID Or TFN *</label>
					</div>
					<div class="col-12 col-md-9">
						<input id="did_or_tfn"  name="did_or_tfn" required class="form-control" type="text" value=""/>
					</div>
				</div> -->
                
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination Type</label>
                </div>
				<?php 
					//$select_destination = "SELECT * FROM `cc_selection_did`";
					//$res_destination = mysqli_query($connection,$select_destination); ?>
					
                <div class="col-12 col-md-9">
                <select id="destination_type" rel="destination_no" name="destination_type" class="form-control">				
				<option value="NONE">------SELECT------</option>
				<?php
                        $select_destination = "SELECT * FROM `cc_selection_did`";
                        $res_destination = mysqli_query($connection,$select_destination);
                        if(mysqli_num_rows($res_destination) > 0){
                            while($rows = mysqli_fetch_assoc($res_destination)){ 
								if($destination_type ==$rows['id']){
									$select = "selected";
								}else{
									$select = "";
								}
								?>
                                <option <?php echo $select; ?> value="<?php echo $rows['id'] ?>"><?php echo $rows['selection_value'] ?></option>
                         <?php   }
                        }
                        ?>
				</select>
                </div>
                </div>
				
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination</label>
                </div>
                <div class="col-12 col-md-9" id="destinationSelect">
					<select name="destination_no" id="destination_no" class="form-control">
					<?php if($destination_type == 1) { 
			    $query_queue = "select * from cc_queue_table where assigned_user='".$userId."'";
				$result_queue = mysqli_query($connection , $query_queue);
				?>
				<!-- <select id="destination" name="destination" class="form-control"> -->
				<?php
				while($row_sip = mysqli_fetch_array($result_queue)){ 
				?>
				<option <?php if(trim($fetch_destination) == trim($row_sip["name"]) ) { echo 'selected="selected"'; } else { echo ''; } ?> value=<?php echo $row_sip["name"]; ?> ><?php echo $row_sip["name"]; ?> </option>
				<?php } ?>
				<!-- </select> -->
			<?php }elseif($destination_type == 2){
				$query_ext = "select * from cc_sip_buddies where id_cc_card='".$userId."'";
						$result_ext = mysqli_query($connection , $query_ext);

						// echo '<select id="destination" name="destination" class="form-control">';
						while($row_ext = mysqli_fetch_array($result_ext)){  ?>
						<option <?php if(trim($fetch_destination) == trim($row_ext["name"]) ) { echo 'selected="selected"'; } else { echo ''; } ?> value=<?php echo $row_ext["name"]; ?> ><?php echo $row_ext["name"]; ?> </option>
						
					<?php	} 
						// echo '</select>';
			}elseif($destination_type == 3){
				$query_vm = "select * from cc_voicemail_users where customer_id='".$userId."'";
						$result_vm = mysqli_query($connection , $query_vm);

						// echo '<select id="destination" name="destination" class="form-control">';
						while($row_vm = mysqli_fetch_array($result_vm)){  ?>
						<option <?php if(trim($fetch_destination) == trim($row_vm["name"]) ) { echo 'selected="selected"'; } else { echo ''; } ?> value=<?php echo $row_vm["mailbox"]; ?>><?php echo $row_vm["mailbox"]; ?></option>';
						<?php }
						// echo '</select>';
			}elseif($destination_type == 5){

				$query_booking = "select * from booking where user_id='".$userId."'";
				$result_booking = mysqli_query($connection , $query_booking);

				// echo '<select id="destination" name="destination" class="form-control">';
				while($row_book = mysqli_fetch_array($result_booking)){ ?>
					<option <?php if(trim($row_book["confno"]) == trim($fetch_destination) ) { echo 'selected="selected"'; } else { echo ''; } ?>  value="<?php echo $row_book["confno"] ?> "><?php echo $row_book["confno"]; ?></option>
				<?php }
				// echo '</select>';
				//echo '<input type="text" id="destination" name="destination" class="form-control" value='.$ordcalldestn.'>';

			}elseif($destination_type == 6){
				
				$query_ring = "select * from cc_ring_group where user_id='".$userId."'";
				$result_ring = mysqli_query($connection , $query_ring); ?>

				<!-- <select id="destination" name="destination" class="form-control"> -->
					<?php
				while($row_ring = mysqli_fetch_array($result_ring)){ ?>
					<option <?php if(trim($row_ring["ringno"]) == trim($fetch_destination) ) { echo 'selected="selected"'; } else { echo ''; } ?>  value="<?php echo $row_ring["ringno"] ?> "><?php echo $row_ring["ringno"]; ?></option>
				<?php } ?>
				<!-- </select> -->
				<?php
			}else{
				echo '<input type="text" id="destination" name="destination" class="form-control" value='.$fetch_destination.'>';
			}
			   
			   ?>
						<!-- <option value="">None</option> -->
					</select>
					</div>
					</div>

                


				<div class="showhideForm" id="dataDiv">
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Start Time</label>
				</div>
				<div class="col-12 col-md-9">
				<input type="time" class="form-control" name="starttime" value="<?php echo $fetch_starttime; ?>" id="starttime" >
				</div>
				</div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Stop Time</label>
				</div>
				<div class="col-12 col-md-9">
				<input type="time" class="form-control" name="stoptime" value="<?php echo $fetch_stoptime; ?>" id="stoptime" >
				</div>
				</div>

				<div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Start Day</label>
				</div>
				<div class="col-12 col-md-9">
				<select id="all_time" name="startday" class="form-control">
					<option <?php if( $fetch_startday =="sunday") { echo 'selected="selected"'; } ?> value="sunday">sunday</option>
					<option <?php if($fetch_startday =="monday") { echo 'selected="selected"'; }?> value="monday">monday</option>
					<option <?php if($fetch_startday == "tuesday") { echo 'selected="selected"'; } ?> value="tuesday">tuesday</option>
					<option <?php if($fetch_startday== "wednesday") { echo 'selected="selected"'; } ?>value="wednesday">wednesday</option>
					<option <?php if($fetch_startday == "thursday") { echo 'selected="selected"'; } ?> value="thursday">thursday</option>
					<option <?php if($fetch_startday == "friday")   { echo 'selected="selected"';}  ?> value="friday">friday</option>
					<option <?php if($fetch_startday== "saturday") { echo 'selected="selected"'; }  ?> value="saturday">saturday</option>
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
				<option <?php if( $fetch_stopday =="sunday") { echo 'selected="selected"'; } ?> value="sunday">sunday</option>
				<option <?php if($fetch_stopday =="monday") { echo 'selected="selected"'; }?> value="monday">monday</option>
				<option <?php if($fetch_stopday == "tuesday") { echo 'selected="selected"'; } ?> value="tuesday">tuesday</option>
				<option <?php if($fetch_stopday== "wednesday") { echo 'selected="selected"'; } ?>value="wednesday">wednesday</option>
				<option <?php if($fetch_stopday == "thursday") { echo 'selected="selected"'; } ?> value="thursday">thursday</option>
				<option <?php if($fetch_stopday == "friday")   { echo 'selected="selected"';}  ?> value="friday">friday</option>
				<option <?php if($fetch_stopday== "saturday") { echo 'selected="selected"'; }  ?> value="saturday">saturday</option>
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
				<option <?php  if ($fetch_all__time == "1") { echo 'selected="selected"'; } ?> value="1">Yes</option>
				<option <?php if ($fetch_all__time == "0") { echo 'selected="selected"'; }?> value="0">No</option>
				</select>
				</div>
                 </div>
                 <div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Off Hours Messages</label>
				</div>
				<div class="col-12 col-md-9">
				<textarea class="form-control" name="messages" id="Test_DatetimeLocal" placeholder="Type Your Off Hours Messages" rowspan="4"><?php echo $fetch_message ?></textarea>

				</div>
				</div>
                <div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">IVR File</label>
				</div>
				<div class="col-12 col-md-9">
				<input class="form-control" name="file" id="file"  type="file" rowspan="4">

				</div>
				</div>
<input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['login_user_id']?>" />
				
			<div class="form-group pull-right">
			 <button type="submit" name="update" value="submit" class="btn btn-primary">UPDATE</button>
			</div>	
</div>
</div>
</div>
</div>
</form>
<script>
	$(document).on('change', '#destination_type', function(){
            // var dyid = $(this).attr('rel');
            var user_id = $("#user_id").val();
            // alert(user_id);
            var id = $(this).val();
			// alert(id);

                $.ajax({
                    url : "ajax_selection_did.php",
                    type : "GET",
                    data : {q : id, user_id : user_id},
                    success : function(data){
                        $("#destination_no").html(data);
                    }
                });
        });
	</script>
<?php require_once('footer.php'); ?> 