<?php require_once('header.php'); 
$message = '';
//echo '<pre>'; print_r($_SESSION);exit;
if(isset($_POST['submit']))
{
	
	$select_didmatch = "select did from cc_did where did='".trim($_POST['did'])."'";
	$query_card_didmatch = mysqli_query($con, $select_didmatch);
	$matchdid = '';
	while($rowdidmatch = mysqli_fetch_array($query_card_didmatch))
	{
		$matchdid = $rowdidmatch['did'];
	}
	if($matchdid == $_POST['did']){
		$message = 'Duplicate DID Information,Please Change The DID Number';
	}else{
		//echo '<pre>';print_r($_POST);exit;
		//$user_id = $_SESSION['login_user_id'];
		
		$created_at = date('Y-m-d h:i:s');
		$updated_at = date('Y-m-d h:i:s');

		$insert_did = "INSERT INTO cc_did(did, did_provider , id_cc_didgroup, id_cc_country, activated, fixrate, connection_charge, selling_rate, aleg_retail_initblock, aleg_retail_increment) VALUES ('".trim($_POST['did'])."', '".$_POST['did_provider']."','".$_POST['id_cc_didgroup']."','".$_POST['id_cc_country']."','".$_POST['activated']."','".$_POST['fixrate']."','".$_POST['connection_charge']."','".$_POST['selling_rate']."','".$_POST['aleg_retail_initblock']."','".$_POST['aleg_retail_increment']."')";
		$result_did = mysqli_query($connection , $insert_did);
		if($result_did){
			$activity_type = 'DID Generate';
			$message = 'DID No: '.$_POST['did'].' '.'DID Generate Succesfully! By Admin';
			user_activity_log($_SESSION['login_user_id'],$_SESSION['userroleforclientid'], $activity_type, $message);
			
			$_SESSION['msg'] = 'DID Added Succesfully!'; 
			echo '<script>window.location.href="did.php"</script>';
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
						<h2 class="title-1"> DID Add<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
						<div class="table-data__tool-right">
							<a href="did.php">
								<button class="au-btn au-btn-icon au-btn--green au-btn--small">
								<i class="fa fa-diamond" aria-hidden="true"></i> DID</button>
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
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">DID Number*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="did" name="did" placeholder="000" value="<?php if(isset($_POST['did'])) { echo $_POST['did']; } else { echo ''; } ?>" class="form-control" type="text" required/>
								</div>
							</div>
							<?php /*
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Billing*</label>
								</div>
							
								<div class="col-12 col-md-9">
									<select name="billingtype" class="form-control-sm form-control" required>
										
										<option <?php if(isset($_POST['billingtype']) && $_POST['billingtype'] == '0' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="0"> Fix per month </option>
										<option <?php if(isset($_POST['billingtype'])  && $_POST['billingtype'] == '1' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="1">Pay as you Go</option>	
										
									</select>								
								</div>
							</div> */ ?>
							<div class="row form-group">
									<div class="col col-md-4">
										<label for="text-input" class=" form-control-label">Inbound*</label>
									</div>
									<div class="col-12 col-md-8">
										<select name="did_provider" id="did_provider"
											class="form-control-sm form-control" required>
											<option value="">Select</option>
											<?php
											$inbound = "SELECT `carrier_name` FROM `server_carriers`";
											$inbound_query = mysqli_query($connection, $inbound) or die("select query failed");
											if (mysqli_num_rows($inbound_query) > 0) {
												while ($row = mysqli_fetch_assoc($inbound_query)) {
													if (isset($_POST['did_provider']) && $_POST['did_provider'] == $row['carrier_name']) {
														$select = "selected";
													} else {
														$select = "";
													}
													?>
													<option <?php echo $select; ?> value="<?php echo $row['carrier_name']; ?>">
														<?php echo $row['carrier_name']; ?>
													</option>
												<?php }
											} ?>
										</select>
									</div>
								</div>

							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">DID Group*</label>
								</div>
								<div class="col-12 col-md-8">
								<?php
								$query_didgroup = "select * from cc_didgroup";
								$result_didgroup = mysqli_query($connection , $query_didgroup);
								//echo '<pre>'; print_r($_SESSION);exit;
								?>
								<select name="id_cc_didgroup" id="id_cc_didgroup" class="form-control-sm form-control" required>
									<option value="">Select</option>
									<?php while($row_didgroup = mysqli_fetch_array($result_didgroup)){ ?>
									<option <?php if(isset($_POST['id_cc_didgroup']) && $_POST['id_cc_didgroup']== $row_didgroup['id'] ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_didgroup['id']; ?>"><?php echo $row_didgroup['didgroupname']; ?></option>
									<?php } ?>
									</select>									
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Country*</label>
								</div>
								<div class="col-12 col-md-8">
								<?php
								$query_didcountry = "select * from cc_country";
								$result_didcountry = mysqli_query($connection , $query_didcountry);
								//echo '<pre>'; print_r($_SESSION);exit;
								?>
								<select name="id_cc_country" id="id_cc_country" class="form-control-sm form-control" required>
									<option value="">Select</option>
									<?php while($row_didcountry = mysqli_fetch_array($result_didcountry)){ ?>									
										<option  <?php if(isset($_POST['id_cc_country']) && $_POST['id_cc_country'] == $row_didcountry['id'] ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_didcountry['id']; ?>"><?php echo $row_didcountry['countryname']; ?></option>
									<?php } ?>
									</select>									
								</div>
							</div>

							<div class="row form-group">
								<div class="col col-md-4">
									<label for="selectSm" class=" form-control-label">Activated*</label>
								</div>
								<div class="col-12 col-md-8">
									<select id="activated" name="activated" class="form-control-sm form-control" required>
										<option <?php if(isset($_POST['activated']) && $_POST['activated'] == '0' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="0">No</option>
										<option <?php if(isset($_POST['activated']) && $_POST['activated'] == '1' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="1">Yes</option>
									</select>
								</div>
							</div>							
							
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Monthly Rate*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="fixrate" name="fixrate" placeholder="0.00" class="form-control" type="text" value="<?php if(isset($_POST['fixrate'])) { echo $_POST['fixrate']; } else { echo ''; } ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Connect Charge*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="connection_charge" name="connection_charge" placeholder="0" class="form-control" type="text" value="<?php if(isset($_POST['connection_charge'])) { echo $_POST['connection_charge']; } else { echo ''; } ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Selling Rate*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="selling_rate" name="selling_rate" placeholder="0" class="form-control" type="text" value="<?php if(isset($_POST['selling_rate'])) { echo $_POST['selling_rate']; } else { echo ''; } ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Retail Min Duration*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="aleg_retail_initblock" name="aleg_retail_initblock" placeholder="0" class="form-control" type="text" value="<?php if(isset($_POST['aleg_retail_initblock'])) { echo $_POST['aleg_retail_initblock']; } else { echo ''; } ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Retail Billing Block*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="aleg_retail_increment" name="aleg_retail_increment" placeholder="0" class="form-control" type="text" value="<?php if(isset($_POST['aleg_retail_increment'])) { echo $_POST['aleg_retail_increment']; } else { echo ''; } ?>" required/>
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
	<!-- footer section start here -->
	<!-- <div class="copyright">
		<p>Copyright Â© 2020 PBX. All rights reserved.</p>
	</div> -->
	<!-- footer section end here -->
</div>

<script>
	/*
$( "select[name='clientId']" ).change(function () {
    var clientsID = $(this).val();


    if(clientsID) {


        $.ajax({
            url: "ajaxpro.php",
            dataType: 'Json',
            data: {'id':clientsID},
            success: function(data) {
                $('select[name="selectedUser[]"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="selectedUser[]"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });


    }else{
        $('select[name="selectedUser[]"]');
		$.each(data, function(key, value) {
                    $('select[name="selectedUser[]"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
    }
});*/
</script>

<?php require_once('footer.php'); ?> 
 
