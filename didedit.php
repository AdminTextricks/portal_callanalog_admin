<?php require_once('header.php'); 
$error = '';
$message = '';
//echo '<pre>'; print_r($_SESSION);exit;
if(isset($_POST['submit']))
{	
		//echo '<pre>';print_r($_POST);exit;
		$user_id = $_SESSION['login_user_id'];		
		$selectedRingList ='';
		if(isset($_POST['ringlist'])){
			$selectedRingList = $_POST['ringlist'];		
			$selectedRingList = implode("-",$selectedRingList);		
		}

		$created_at = date('Y-m-d h:i:s');
		$updated_at = date('Y-m-d h:i:s');
		$update_did = "Update cc_did set did='".$_POST['did']."', did_provider='".$_POST['did_provider']."', activated='".$_POST['activated']."' , fixrate='".$_POST['fixrate']."' , connection_charge='".$_POST['connection_charge']."' , selling_rate='".$_POST['selling_rate']."' , aleg_retail_initblock='".$_POST['aleg_retail_initblock']."' , aleg_retail_increment='".$_POST['aleg_retail_increment']."', id_cc_country='".$_POST['id_cc_country']."',id_cc_didgroup='".$_POST['id_cc_didgroup']."' where id ='".$_POST['id']."' and iduser='".$_POST['iduser']."'";

		if(mysqli_query($connection , $update_did)){
			$_SESSION['msg'] = 'DID Updated Succesfully!'; 
			echo '<script>window.location.href="did.php"</script>';
		}
	
}
	
	$$did = $billingtype = $did_provider = $activated = $fixrate = $connection_charge = $selling_rate = $aleg_retail_initblock = $aleg_retail_increment = $id_cc_country = $id_cc_didgroup = '';
	
	if(isset($_GET['id']) && $_GET['id'] !=''){
		$didQuery = "select crg.id, crg.iduser, crg.did, crg.billingtype, crg.did_provider, crg.activated, crg.fixrate, crg.connection_charge, crg.selling_rate, crg.aleg_retail_initblock, crg.aleg_retail_increment, crg.id_cc_country, crg.id_cc_didgroup from cc_did crg 
		left join users_login ON crg.iduser=users_login.id WHERE crg.id='".$_GET['id']."' order by id desc";

		$result_did = mysqli_query($connection , $didQuery);

		while($row_did = mysqli_fetch_assoc($result_did))
		{
			//echo '<pre>'; print_r($row_did);exit; 
			$id 			= $row_did['id'];
			$iduser			= $row_did['iduser'];
			$did 			= $row_did['did'];
			$billingtype 	= $row_did['billingtype'];			
			$did_provider 	= $row_did['did_provider'];
			$activated		= $row_did['activated'];
			$fixrate 		= $row_did['fixrate'];
			$connection_charge 	= $row_did['connection_charge'];
			$selling_rate 	= $row_did['selling_rate'];
			$aleg_retail_initblock = $row_did['aleg_retail_initblock'];
			$aleg_retail_increment = $row_did['aleg_retail_increment'];
			$id_cc_country 	= $row_did['id_cc_country'];
			$id_cc_didgroup = $row_did['id_cc_didgroup'];
		}

	}else{
		$error ='true';
	}

if($error=='true'){
	$_SESSION['msg'] = 'DID Updated Succesfully!';
	echo "<script>window.location.href='did.php'</script>";
	//header("location: did.php");
}


?>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">
						<h2 class="title-1"> DID Information<span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
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
									<input id="id" name="id" value="<?php echo $id; ?>" class="form-control" type="hidden"/>
									<input id="iduser" name="iduser" value="<?php echo $iduser; ?>" class="form-control" type="hidden"/>
									<input id="did" name="did" placeholder="000" value="<?php echo $did; ?>" class="form-control" type="text" required readonly/>
								</div>
							</div>
							<?php /*
							<div class="row form-group">
								<div class="col col-md-3">
									<label for="text-input" class=" form-control-label">Billing*</label>
								</div>
							
								<div class="col-12 col-md-9">
									<select name="billingtype" class="form-control-sm form-control" required>

										<option <?php if($billingtype == '0' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="0"> Fix per month </option>
										<option <?php if($billingtype == '1' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="1"> Pay as you Go</option>

									</select>								
								</div>
							</div>
							*/ ?>
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
													if (($did_provider == $row['carrier_name']) || ($_POST['did_provider'] == $row['carrier_name'])) {
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
									<option <?php if($id_cc_didgroup == $row_didgroup['id'] ) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_didgroup['id']; ?>"><?php echo $row_didgroup['didgroupname']; ?></option>
									<?php } ?>
									</select>									
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class="form-control-label">Country*</label>
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
										<option  <?php if($id_cc_country == $row_didcountry['id']) { echo 'selected="selected"'; } else { echo ''; } ?> value="<?php echo $row_didcountry['id']; ?>"><?php echo $row_didcountry['countryname']; ?></option>
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
										<option <?php if($activated == '0' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="0">No</option>
										<option <?php if($activated == '1' ) { echo 'selected="selected"'; } else { echo ''; } ?> value="1">Yes</option>
									</select>
								</div>
							</div>							
							
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Monthly Rate*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="fixrate" name="fixrate" placeholder="0.00" class="form-control" type="text" value="<?php echo $fixrate; ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Connect Charge*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="connection_charge" name="connection_charge" placeholder="0" class="form-control" type="text" value="<?php echo $connection_charge; ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Selling Rate*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="selling_rate" name="selling_rate" placeholder="0" class="form-control" type="text" value="<?php echo $selling_rate; ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Retail Min Duration*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="aleg_retail_initblock" name="aleg_retail_initblock" placeholder="0" class="form-control" type="text" value="<?php  echo $aleg_retail_initblock; ?>" required/>
								</div>
							</div>
							<div class="row form-group">
								<div class="col col-md-4">
									<label for="text-input" class=" form-control-label">Retail Billing Block*</label>
								</div>
								<div class="col-12 col-md-8">
									<input id="aleg_retail_increment" name="aleg_retail_increment" placeholder="0" class="form-control" type="text" value="<?php echo $aleg_retail_increment; ?>" required/>
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
 
