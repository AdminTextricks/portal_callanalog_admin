<?php 
require_once('header.php'); 

	$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';    
	$fromdates = $fromDate;
    $toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';	
	$todates = $toDate;
	//echo '<pre>'; print_r($_GET); 	print_r($_SESSION); echo '</pre>';//exit;

	if(isset($_GET['itemType']) && strlen($_GET['itemType']) > 0) {
		$itemType = 'and invoices.item_type = "'.$_GET['itemType'].'"';
	}else{
		$itemType = '';
	}    
	
	$paymentType = isset($_GET['paymentType']) ? $_GET['paymentType'] : '';
	if(strlen($paymentType) > 0 )	{
		$paymentType = "and gateways_payments.payment_type='".$paymentType."'";
	}else{
		$paymentType = '';
	}

	$extentionnumber = $_SESSION['login_user'];

	if (isset($_GET['page_no']) && $_GET['page_no']!="") {
		$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
	}
	$total_no_of_pages = 1;

if(isset($_GET['submit'])){ 	

	$total_records_per_page = 25;
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";
	if($_SESSION['userroleforpage'] == 1){ 
		//$query_cdr_pagination = "SELECT count(id) FROM `cc_inbound_call` where calldate between '".$fromdates."' and '".$todates."' ".$disposition." ".$queueNames." ".$extensions." ".$DIDSS." ".$CLID."";

		$query_invo_pagination = "SELECT count(invoices.id) FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE DATE(createdDate) between '".$fromdates."' and  '".$todates."' ".$itemType." ".$paymentType."";

	}else{
		//$query_cdr_pagination = "SELECT count(id) FROM `cc_inbound_call` where calldate between '".$fromdates."' and '".$todates."' ".$disposition." ".$queueNames." ".$extensions." ".$DIDSS." ".$CLID." and accountcode='".$_SESSION['login_usernames']."' ";

		$query_invo_pagination = "SELECT count(invoices.id) FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE DATE(createdDate) between '".$fromdates."' and  '".$todates."' ".$itemType." ".$paymentType." and invoices.user_id='".$_SESSION['login_user_id']."'";
	}

	$result_queue_cdr_pagination = mysqli_query($connection , $query_invo_pagination);

	$row_pagins = mysqli_fetch_row($result_queue_cdr_pagination);  
	$total_pagins_records = $row_pagins[0];  
	$total_no_of_pages = ceil($total_pagins_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;
	if($_SESSION['userroleforpage'] == 1){ 
		//$query_cdr = "SELECT * FROM `cc_inbound_call` where calldate between '".$fromdates."' and '".$todates."' ".$disposition." ".$queueNames." ".$extensions." ".$DIDSS." ".$CLID." order by id DESC limit ".$offset.", ".$total_records_per_page."";

		$sql = "SELECT invoices.*, gateways_payments.payment_type, users_login.name FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE DATE(createdDate) between '".$fromdates."' and  '".$todates."' ".$itemType." ".$paymentType." order by id DESC limit ".$offset.", ".$total_records_per_page."";

	}else{
		//$query_cdr = "SELECT * FROM `cc_inbound_call` where calldate between '".$fromdates."' and '".$todates."' ".$disposition." ".$queueNames." ".$extensions." ".$DIDSS." ".$CLID." and accountcode='".$_SESSION['login_usernames']."' order by id DESC limit ".$offset.", ".$total_records_per_page."";

		$sql = "SELECT invoices.*, gateways_payments.payment_type, users_login.name FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE DATE(createdDate) between '".$fromdates."' and  '".$todates."' ".$itemType." ".$paymentType." and invoices.user_id='".$_SESSION['login_user_id']."' order by id DESC limit ".$offset.", ".$total_records_per_page."";
	}
	$result_queue_cdr = mysqli_query($connection , $sql);

	$urlcode = 'fromDate='.$fromDate.'&toDate='.$toDate.'&submit='.$_GET['submit'].'&showRecords='.$_GET['showRecords'].'&pageNumber='.$_GET['pageNumber'].'&itemType='.$_GET['itemType'].'&paymentType='.$_GET['paymentType'].'';

}

?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
	<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="overview-wrap">	
				<h2 class="title-1"> Invoice Reports </h2>
			</div>
		</div>
	</div>

<div class="reports_inner_outer">
<div class="row">
    <div class="col-md-12">
        <div class="classic_queue_info">
            <form id="classicReportForm" name="cdrreport" action="" method="get">
            <div class="row">
				<div class="col-md-3">
				<div class="form-group">
					<label for="text-input" class=" form-control-label"style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
					<input id="fromDate" name="fromDate" class="form-control hasDatepicker" type="date" step="1" value="<?php if(count($fromDate)>0) { echo $fromDate; } else { echo date('Y-m-d'); }?>" required>

				</div>
				</div>

			

				<div class="col-md-3">
					<div class="form-group">
						<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
						<input id="toDate" name="toDate" class="form-control hasDatepicker" type="date" value="<?php if(count($toDate)>0) { echo $toDate; } else { echo date('Y-m-d'); } ?>" required>
					</div>
				</div>

			
				<div class="col-md-2">
					<div class="form-group">
						<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Item Type</label>
						<select id="itemType" name="itemType" class="form-control">
						<option value="">All</option>
						<option value="DID" <?php if(isset($_GET['itemType']) && $_GET['itemType'] == 'DID'){echo 'selected' ;}else{echo '';} ?>>DID</option>
						<option value="Extension" <?php if(isset($_GET['itemType']) && $_GET['itemType'] == 'Extension'){echo 'selected' ;}else{echo '';} ?>>Extension</option>
						<option value="Wallet Credit" <?php if(isset($_GET['itemType']) && $_GET['itemType'] == 'Wallet Credit'){echo 'selected' ;}else{echo '';} ?>>Wallet Credit</option>
						</select>
					</div>
				</div>
			
				<div class="col-md-2">
					<div class="form-group">
						<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Payment Type</label>
						<select id="paymentType" name="paymentType" class="form-control">
						<option value="">All</option>
						<option value="Wallet" <?php if(isset($_GET['paymentType']) && $_GET['paymentType'] == 'Wallet'){echo 'selected' ;}else{echo '';} ?>>Wallet</option>
						<option value="Pay" <?php if(isset($_GET['paymentType']) && $_GET['paymentType'] == 'Pay'){echo 'selected' ;}else{echo '';} ?>>Pay</option>
						<option value="Free By Admin" <?php if(isset($_GET['paymentType']) && $_GET['paymentType'] == 'Free By Admin'){echo 'selected' ;}else{echo '';} ?>>Free By Admin</option>
						<option value="Free By User" <?php if(isset($_GET['paymentType']) && $_GET['paymentType'] == 'Free By User'){echo 'selected' ;}else{echo '';} ?>>Free By User</option>
						</select>
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
					<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">&nbsp;</label>
						<button type="submit"  name="submit" value="submit" class="btn btn-primary btn-sm form-control">Submit</button>
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
		<div class="overview-wrap custom_show">
		&nbsp;
		</div>
 		<div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate report_claasic_tble">
		<table id="queueTable" class="table manage_queue_table">
			<thead>
				<th>Serial No</th>
				<th>Invoice ID</th>
				<th>Name</th>
				<th>Item Type</th>
				<th>Payment Type</th>
				<th>Date</th>
				<th>Action</th>
			</thead>

			<tbody>
				<?php 
				if(isset($_GET['submit'])){
				if(mysqli_num_rows($result_queue_cdr) > 0 ) { ?>
				<tr class="tr-shadow">
				<?php 
				$i = 1;
				while($row_cdr = mysqli_fetch_array($result_queue_cdr)) { ?>
				<td><?php echo $i; ?></td>
				<td><?php echo $row_cdr['invoice_id']; ?></td>
				<td><?php echo $row_cdr['name']; ?></td>
				<td><?php echo $row_cdr['item_type']; ?></td>
				<td><?php echo $row_cdr['payment_type']; ?></td>
				<td><?php echo $row_cdr['createdDate']; ?></td>
				<td><a href='invoice_pdf/<?php echo $row_cdr['invoice_file']?>' download><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-download' viewBox='0 0 16 16'>
                        <path d='M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z'/>
                        <path d='M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z'/>
                    </svg></a></td>
				</tr>
				<?php $i++; } } } else { ?>

				<tr><td colspan="11" style="color:red;font-size:20px;">No data found </td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>

	<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
		<strong>Showing <?php echo $page_no." of ".$total_no_of_pages; ?></strong>
	</div>

	<ul class="pagination">
		<?php  if($page_no > 1){ echo "<li><a href='?$urlcode&page_no=1'>First Page</a></li>"; } ?>
		
		<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
		<a <?php if($page_no > 1){ echo "href='?$urlcode&page_no=$previous_page'"; } ?>>Previous</a>
		</li>
		
		<?php 
		if ($total_no_of_pages <= 10){  	 
			for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
				if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
					}else{
			echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
					}
			}
		}
		elseif($total_no_of_pages > 10){
			
		if($page_no <= 4) {			
		for ($counter = 1; $counter < 8; $counter++){		 
				if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
					}else{
			echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
					}
			}
			echo "<li><a>...</a></li>";
			echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
			echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
			}

		elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
			echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
			echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
			echo "<li><a>...</a></li>";
			for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {			
			if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
					}else{
			echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
					}                  
		}
		echo "<li><a>...</a></li>";
		echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
		echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";      
				}
			
			else {
			echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
			echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
			echo "<li><a>...</a></li>";

			for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
			if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
					}else{
			echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
					}                   
					}
				}
		}
	?>
		
		<li <?php if($page_no >= $total_no_of_pages){ echo "class='disabled'"; } ?>>
		<a <?php if($page_no < $total_no_of_pages) { echo "href='?$urlcode&page_no=$next_page'"; } ?>>Next</a>
		</li>
		<?php if($page_no < $total_no_of_pages){
			echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
			} ?>
	</ul>
 
</div>
</div>

<!-- code will write here start-->
<!-- code will write here end -->

</div>
</div>
</div>   				
<?php require_once('footer.php'); ?>