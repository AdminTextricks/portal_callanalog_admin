<?php require_once ('header.php');
$ring_uid = "";
if (isset($_GET['uid']) && $_GET['uid'] != '') {
	$ring_uid = "id_cc_card='" . $_GET['uid'] . "' AND";
}

$ring_id = $ring_number = $ringlist = $ring_user_id = $ring_clientid = '';
$query_ringmanage = "select * from cc_ring_group where id='" . $_GET['id'] . "'";
$result_managering = mysqli_query($connection, $query_ringmanage);
$row_manage = mysqli_fetch_array($result_managering);

$ring_id = $row_manage['id'];
$ring_number = $row_manage['ringno'];
$ringlist = $row_manage['ringlist'];
$ring_user_id = $row_manage['user_id'];
$ring_clientid = $row_manage['clientId'];

$ring_array = array();
if (!empty($ringlist)) {
	$ring_array = explode('-', $ringlist);
}

$ring_id = $ring_number = $ringlist = $ring_user_id = $ring_clientid = '';
$query_ringmanage = "select * from cc_ring_group where id='" . $_GET['id'] . "'";
$result_managering = mysqli_query($connection, $query_ringmanage);
$row_manage = mysqli_fetch_array($result_managering);

$ring_id = $row_manage['id'];
$ring_number = $row_manage['ringno'];
$ringlist = $row_manage['ringlist'];
$ring_user_id = $row_manage['user_id'];
$ring_clientid = $row_manage['clientId'];

$ring_array = array();
if (!empty($ringlist)) {
	$ring_array = explode('-', $ringlist);
}

//echo '<pre>'; print_r($ring_array); echo '</pre>';
if ($_SESSION['userroleforpage'] == 1) {
	$query_ring_buddies = "select id, id_cc_card, name from cc_sip_buddies where " . $ring_uid . " name NOT IN ( '" . implode("', '", $ring_array) . "' ) order by name";
} else {
	$query_ring_buddies = "select id, id_cc_card, name from cc_sip_buddies where id_cc_card='" . $_SESSION['login_user_id'] . "' AND name NOT IN ( '" . implode("', '", $ring_array) . "' ) order by name";
}
$result_ringbuddies = mysqli_query($connection, $query_ring_buddies);

?>


<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<?php //if($_SESSION['userroleforpage'] == 1){      ?>
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap table_top_heading">

						<a href="ring.php">
							<button class="au-btn au-btn-icon au-btn--blue">
								<i class="fa fa-plus-circle"></i>Ring</button></a>
					</div>
				</div>
			</div>
			<?php //}      ?>

			<style type="text/css">
				.manage_que_mid {
					width: 100%;
					background: #ffffff;
					padding: 20px 15px 20px;
				}

				.manage_que_mid .manage_que_title {
					font-weight: normal;
					margin: 0 0 15px;
				}

				.agent_table_outer {
					overflow: auto;
					max-height: 278px;
				}

				.agent_table_outer th {
					padding: 7px 10px;
				}

				.agent_table_outer td {
					padding: 7px 10px;
				}

				.agent_table_outer .item i {
					font-size: 14px !important;
				}

				.add_agent_outer {
					padding: 15px;
					border: 1px solid #ddd;
				}

				.add_agent_outer .manage_queue_table thead tr>th {
					background: #29a9de;
					color: #fff;
					font-family: sans-serif;
				}

				.agent_form_outer select[multiple=multiple] {
					height: 325px
				}
			</style>

			<div class="row" id="queueMemberDiv" style="">
				<div class="col-md-12">
					<div class="manage_que_mid">
						<h4 class="manage_que_title">Add Agent</h4>
						<span style="color:red;">
							<?php echo $ring_msg ?>
						</span>
						<div class="add_agent_outer">

							<div class="row">

								<div class="col-md-6">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="ringName" class=" form-control-label" style="color:black;">Ring
												Name</label>
											<input type="text" id="ringName" name="ringName" readonly="true"
												placeholder="xyz" value="<?php echo $ring_number; ?>"
												class="form-control">
										</div>
									</div>
									<?php echo '.'; ?>
									<div id="div1" class="agent_table_outer">

									</div>
								</div>

								<div class="col-md-6">
									<div class="agent_form_outer">
										<form id="ringForm" name="ringForm" action="ringFrom.php" method="post">
											<div class="form-group">
												<label for="extensionSelect" class=" form-control-label"
													style="color:black;">Assigned Extensions</label>
												<select name="extensionSelect[]" id="extensionSelect"
													class="form-control-sm form-control" multiple="multiple">

												</select>
											</div>
											<input type="hidden" name="uid" id="uid"
												value="<?php echo $_GET['uid']; ?>">
											<input type="hidden" name="ringlist" id="ringlist"
												value="<?php echo $ringlist; ?>">
											<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
											<div class="form-group pull-right">
												<button type="button" onclick="getData()" id="saveQueueMember"
													class="btn btn-primary btn-sm">Submit</button>
											</div>
											<p id="saveQueueMemMsg" style="display:none;"></p>
										</form>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>



			<div class="row">
				<div class="col-md-12">

					<div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">

						<!-- Table -->
						<table id='empTable' class='display dataTable table manage_queue_table'>
							<thead>
								<tr>
									<th>Ring Number</th>
									<th>Strategy</th>
									<th>Ring Time</th>
									<th>Ring List</th>
									<th>Description</th>
									<!-- <th>Ringing</th>
					<th>Progress</th>-->
									<th>Action</th>
								</tr>
							</thead>

						</table>
					</div>

					<!-- Script -->
					<script>
						$(document).ready(function () {
							$('#empTable').DataTable({
								'processing': true,
								'serverSide': true,
								'serverMethod': 'post',
								'ajax': {
									'url': 'ajaxring.php'
								},
								'columns': [
									{ data: 'ringno' },
									{ data: 'strategy' },
									{ data: 'ringtime' },
									{ data: 'ringlist' },
									{ data: 'description' },
									{ data: 'action' },
								]
							});
						});
					</script>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		var ring_number = '<?php echo $ring_number; ?>';
		var ringlist = $("#ringlist").val();
		var uid = $("#uid").val();
		var id = $("#id").val();
		var extensions = $("#extensionSelect").val();
		getTable();
		getExtensions();
	});


	function getTable() {
		var ring_number = '<?php echo $ring_number; ?>';
		var ringlist = $("#ringlist").val();
		var uid = $("#uid").val();
		var id = $("#id").val();
		$.ajax({
			url: 'loadRingTable.php',
			type: 'post',
			data: { ringlist: ringlist, uid: uid, id: id, ring_number: ring_number },
			success: function (response) {
				$("#div1").html(response);
			}
		});
	}


	function ringdelete(extension_no, ringid, uid) {
		$.ajax({
			url: 'ringdelete.php',
			type: 'post',
			data: { extension_no: extension_no, ringid: ringid, uid: uid },
			success: function (response) {
				getTable();
				getExtensions();
			}
		});
	}


	function getExtensions() {
		var uid = $("#uid").val();
		var id = $("#id").val();
		$.ajax({
			url: 'getExtensions.php',
			type: 'post',
			data: { uid: uid, id: id },
			success: function (response) {
				$("#extensionSelect").html(response);
			}
		});

	}

	function getData() {
		var extensions = $("#extensionSelect").val();
		var uid = $("#uid").val();
		var ringlist = $("#ringlist").val();
		var id = $("#id").val();
		$.ajax({
			url: 'ringForm.php',
			type: 'post',
			data: { extensionSelect: extensions, uid: uid, ringlist: ringlist, id: id },
			success: function (response) {
				getTable();
				getExtensions();
			}
		});
	}
</script>

<?php require_once ('footer.php'); ?>