<?php require_once('header.php'); ?>

<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">	
                        <h2 class="title-1"> Invoice Reports </h2><?php //echo $query_cdr; ?>
                    </div>
                </div>
            </div>
            <div class="reports_inner_outer">
<div class="row">
    <div class="col-md-12">
        <div class="classic_queue_info">
            <form id="classicReportForm" name="cdrreport" action="" method="post">
            <div class="row">
				<div class="col-md-3">
				<div class="form-group">
					<label for="text-input" class=" form-control-label"style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
					<input id="fromDate" name="fromDate" class="form-control hasDatepicker" type="date" step="1"  value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate'];} else{ echo "" ;}?>">

				</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
						<input id="toDate" name="toDate" class="form-control hasDatepicker" type="date" value="<?php if(isset($_POST['toDate'])){ echo $_POST['toDate']; }else{ echo '';} ?>">
					</div>
				</div>
			
			
				<div class="col-md-3">
					<div class="form-group">
						<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Item Type</label>
						<select id="itemType" name="itemType" class="form-control">
						<option value="">All</option>
						<option value="DID" <?php if(isset($_POST['itemType']) && $_POST['itemType'] == 'DID'){echo 'selected' ;}else{echo '';} ?>>DID</option>
						<option value="Extension" <?php if(isset($_POST['itemType']) && $_POST['itemType'] == 'Extension'){echo 'selected' ;}else{echo '';} ?>>Extension</option>
						<option value="Wallet Credit" <?php if(isset($_POST['itemType']) && $_POST['itemType'] == 'Wallet Credit'){echo 'selected' ;}else{echo '';} ?>>Wallet Credit</option>
						</select>
					</div>
				</div>
 
				<div class="col-md-3">
					<div class="form-group">
						<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Payment Type</label>
						<select id="paymentType" name="paymentType" class="form-control">
						<option value="">All</option>
						<option value="Wallet" <?php if(isset($_POST['paymentType']) && $_POST['paymentType'] == 'Wallet'){echo 'selected' ;}else{echo '';} ?>>Wallet</option>
						<option value="Pay" <?php if(isset($_POST['paymentType']) && $_POST['paymentType'] == 'Pay'){echo 'selected' ;}else{echo '';} ?>>Pay</option>
						<option value="Free By Admin" <?php if(isset($_POST['paymentType']) && $_POST['paymentType'] == 'Free By Admin'){echo 'selected' ;}else{echo '';} ?>>Free By Admin</option>
						<option value="Free By User" <?php if(isset($_POST['paymentType']) && $_POST['paymentType'] == 'Free By User'){echo 'selected' ;}else{echo '';} ?>>Free By User</option>
						</select>
					</div>
				</div>

			<div class="col-md-3" style="float:right;">
				<div class="form-group" style="float:right;">
					<button type="submit" style="margin-top: 38px;" name="submit" id="submit" value="submit" class="btn btn-primary btn-sm">Submit</button>
				</div> 
       		</div>
			<p></p>
        </div>
			<input id="showRecords" name="showRecords" type="hidden" value="10">
			<input id="pageNumber" name="pageNumber" type="hidden" value="1">		
		</form>
			
        </div>
    </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<!-- <div class="overview-wrap custom_show">
		&nbsp;
		</div> -->
 		<div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate report_claasic_tble">
        </div>
		<?php 
		if(isset($_POST['submit'])){
			//echo '<pre>'; print_r($_POST); echo '<pre>';
			if(!empty($_POST['fromDate'])){
				$fromDate = 'DATE(createdDate) between"'.$_POST['fromDate'].'"';
			}else{
				$fromDate = 'DATE(createdDate)= "'.date("Y-m-d").'"';
			}
			
			if(!empty($_POST['toDate'])){
				$toDate = 'and"'.$_POST['toDate'].'"';
			}else{
				$toDate = 'and "'.date("Y-m-d").'"';
			}
			
			
			if(isset($_POST['itemType']) && strlen($_POST['itemType'])>0){
				$itemType = 'and invoices.item_type="'.$_POST['itemType'].'"';
			}else{
				$itemType = '';
			}
			
			
			if(isset($_POST['paymentType']) && strlen($_POST['paymentType']) > 0){
				$paymentType = 'and payment_type="'.$_POST['paymentType'].'"';   
			}else{
				$paymentType = '';
			}

			if($_SESSION['userroleforpage'] == 1){
				$sql = "SELECT * FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE ".$fromDate." ".$toDate." ".$itemType." ".$paymentType."";
			}else{
				$user_id = 'and invoices.user_id="'.$_SESSION['login_user_id'].'"';
				$sql = "SELECT * FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE ".$fromDate." ".$toDate." ".$itemType." ".$paymentType." ".$user_id."";
			}
		}else{
			if($_SESSION['userroleforpage'] == 1){
				$sql = "SELECT invoices.invoice_id, invoices.item_type, invoices.createdDate, users_login.name, gateways_payments.payment_type FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id LEFT JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id";
			}else{
				$sql = "SELECT `invoices`.`invoice_id`, invoices.item_type, invoices.createdDate, users_login.name, gateways_payments.payment_type FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id LEFT JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE invoices.user_id = ".$_SESSION['login_user_id']."";
			}
		}

		
//echo $sql; exit;
		$result = mysqli_query($connection, $sql ) or die("query failed: Invoices");
		$output = '';
		if(mysqli_num_rows($result) > 0){
		?>

			<div class="row">
            <div class="col-md-12">

                <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
                <table id="table-data" class='display dataTable table manage_queue_table'>
				<thead>
                    <th>Serial No</th>
                    <th>Invoice ID</th>
                    <th>Name</th>
                    <th>Item Type</th>
                    <th>Payment Type</th>
                    <th>Date</th>
                    <th>Action</th>
                </thead>
				<?php 
				$i=1;
       			 while($row = mysqli_fetch_assoc($result)){ 
					// echo "<pre>"; print_r($row); exit;
					?>
                <tr class='tr-shadow'>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['invoice_id'] ?></td>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['item_type'] ?></td>
                        <td><?php echo $row['payment_type'] ?></td>
                        <td><?php echo $row['createdDate'] ?></td>
                        <td><a href='invoice_pdf/<?php echo $row['invoice_file']?>' download><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-download' viewBox='0 0 16 16'>
                        <path d='M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z'/>
                        <path d='M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z'/>
                    </svg></a></td>
                    </tr>
					<?php
                    $i++;
           			 } ?>
			</table>
			</div>
                    </div>
                    </div>
			<?php }else{
				echo "<span style='font-size:25px;color:red;'>No Record Found</span>";
			} ?>
</div>
    </div>
</div>
<script>
	
	$(document).ready(function(){
		// Use filters
	/*	$("#submit").on("click", function(e){
			e.preventDefault();
			var fromDate = $("#fromDate").val();
			var toDate = $("#toDate").val();
			var itemType = $("#itemType").val();
			var paymentType = $("#paymentType").val();
		
			$.ajax({
				url : "ajaxsearchInvoices.php",
				type : "post",
				data : {fromDate : fromDate, toDate : toDate, itemType : itemType, paymentType : paymentType,},
				success : function(data){
					$("#table-data").html(data);
					// $('#table-data').DataTable(data);
				}
			});
		});*/
		$('#table-data').DataTable(); 
	});
	
</script>

<?php require_once('footer.php'); ?> 
<!-- 'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'ajaxinvoice.php'
            },
			'columns': [
                    { data: 'serial_no' },
                    { data: 'invoice_id' },
                    { data: 'name' },
                    { data: 'item_type' },
                    { data: 'payment_type' },
                    { data: 'createdDate' },
                ] -->