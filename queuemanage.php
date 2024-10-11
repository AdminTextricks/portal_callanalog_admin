<?php
require_once ('header.php');

$query_queuemanage = "select * from cc_queue_table where id='" . $_GET['id'] . "'";
$result_managequeue = mysqli_query($connection, $query_queuemanage);
while ($row_manage = mysqli_fetch_array($result_managequeue)) {
	$queue_id = $row_manage['id'];
	$queue_number = $row_manage['name'];
	$queue_clientid = $row_manage['clientId'];
}

if (isset($_POST['submit'])) {

	if (isset($_POST['extensionSelect'])) {
		$extensionSelect = $_POST['extensionSelect'];

		for ($i = 0; $i < count($extensionSelect); $i++) {

			$interface = 'SIP/' . $extensionSelect[$i];
			$insert = 'insert into cc_queue_member_table (queue_id,membername,queue_name,interface) values ("' . $queue_id . '","' . $extensionSelect[$i] . '","' . $queue_number . '","' . $interface . '")';

			// echo $insert; exit;
			$resultddd = mysqli_query($connection, $insert);
			header('Location: queuemanage.php?id=' . $_GET['id']);
		}
	} else {
		$queue_msg = "Please Select Atleast One Extension";
	}
}

$query_queuemember = "select * from cc_queue_member_table where queue_name='" . $queue_number . "'";
$result_memberqueue = mysqli_query($connection, $query_queuemember);

//$query_queue_buddies = "select * from cc_sip_buddies where id_cc_card='".$_SESSION['login_user_id']."' AND name NOT IN (select membername from cc_queue_member_table where queue_name='".$queue_number."') order by name";
$query_queue_buddies = "select * from cc_sip_buddies where id_cc_card='" . $_GET['uid'] . "' AND name NOT IN (select membername from cc_queue_member_table where queue_name='" . $queue_number . "') order by name";
$result_queuebuddies = mysqli_query($connection, $query_queue_buddies);

?>
<style>
	.mpopup {
		display: none;
		position: fixed;
		z-index: 1;
		padding-top: 100px;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		overflow: auto;
		background-color: rgb(0, 0, 0);
		background-color: rgba(0, 0, 0, 0.4);
	}

	.modal-content {
		position: relative;
		background-color: #fff;
		margin: auto;
		padding: 0;
		width: 450px;
		box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		-webkit-animation-name: animatetop;
		-webkit-animation-duration: 0.4s;
		animation-name: animatetop;
		animation-duration: 0.4s;
		border-radius: 0.3rem;
	}

	.modal-header {
		padding: 2px 12px;
		background-color: #ffffff;
		color: #333;
		border-bottom: 1px solid #e9ecef;
		border-top-left-radius: 0.3rem;
		border-top-right-radius: 0.3rem;
	}

	.modal-header h2 {
		font-size: 1.25rem;
		margin-top: 14px;
		margin-bottom: 14px;
	}

	.modal-body {
		padding: 2px 12px;
	}

	.modal-footer {
		padding: 1rem;
		background-color: #ffffff;
		color: #333;
		border-top: 1px solid #e9ecef;
		border-bottom-left-radius: 0.3rem;
		border-bottom-right-radius: 0.3rem;
		text-align: right;
	}

	.close {
		color: #888;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: #000;
		text-decoration: none;
		cursor: pointer;
	}

	/* add animation effects */
	@-webkit-keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}

		to {
			top: 0;
			opacity: 1
		}
	}

	@keyframes animatetop {
		from {
			top: -300px;
			opacity: 0
		}

		to {
			top: 0;
			opacity: 1
		}
	}

	.modal-backdrop {
		position: relative;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		z-index: 1040;
		background-color: #000;
	}
</style>
<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<?php //if($_SESSION['userroleforpage'] == 1){   ?>
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap table_top_heading">
						<a href="queueadd.php"> <button class="au-btn au-btn-icon au-btn--blue"><i
									class="fa fa-plus-circle"></i>Queue</button></a>
					</div>
				</div>
			</div>
			<?php //}   ?>

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

			<!-- <div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
		<?php //if($_SESSION['userroleforpage'] == 1){   ?>
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap table_top_heading">    
						<a href="queueadd.php">	<button class="au-btn au-btn-icon au-btn--blue"><i class="fa fa-plus-circle"></i>Queue</button></a>
					</div>
				</div>
			</div>
		<?php //}   ?> -->

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
						<h4 class="manage_que_title">Add Agent
							<?php //echo $insert;   ?>
						</h4>
						<span style="color:red;">
							<?php echo $queue_msg ?>
						</span>

						<div class="add_agent_outer">
							<div class="row">

								<div class="col-md-6">
									<div class="col-xs-12">
										<div class="form-group">
											<label for="queueName" class=" form-control-label"
												style="color:black;">Queue Name</label>
											<input type="text" id="queueName" name="queueName" readonly="true"
												placeholder="xyz" value="<?php echo $queue_number; ?>"
												class="form-control">
										</div>
									</div>
									<?php echo '.'; ?>
									<div class="agent_table_outer">
										<table class="table manage_queue_table table-bordered">
											<thead>
												<tr>
													<th>Queue</th>
													<th>Extension No</th>
													<th>Priority</th>
													<th>Action</th>
												</tr>
											</thead>
											<p id="updateQueue" style="color:blue;"></p>
											<tbody id="queueMemberTable">
												<?php
												if (mysqli_num_rows($result_memberqueue) > 0) {
													while ($row_member = mysqli_fetch_array($result_memberqueue)) {
														$extnamequeue = $row_member['membername'];
														$queueamequeue = $row_member['queue_name'];

														?>
														<tr class="tr-shadow" id="<?php echo $row_member['queue_name']; ?>">
															<td class="desc">
																<?php echo $row_member['queue_name']; ?>
															</td>
															<td>
																<?php echo $row_member['membername']; ?>
															</td>
															<td class="numbersOnly" contenteditable="false"
																id="tdpenalty<?php echo $row_member['membername']; ?>">
																<?php echo $row_member['penalty']; ?>
															</td>
															<td>
																<div class="table-data-feature">
																	<!-- <button class="item" data-toggle="tooltip" data-placement="top" title="Edit" id="edit<?php echo $row_member['membername']; ?>" onclick="editQueueMember(<?php echo $row_member['membername']; ?>)"><i class="fa fa-pencil"></i></button> -->
																	<button class="item" style="display:none;"
																		data-toggle="tooltip" data-placement="top" title="Save"
																		id="save<?php echo $row_member['membername']; ?>"
																		onclick="updateQueueMember(<?php echo $row_member['membername']; ?>)">Save</button>

																	<button class="item MybtnModal"
																		onclick="getModel('<?php echo $row_member['uniqueid'] ?>')"
																		id=<?php echo $row_member['uniqueid'] ?>>
																		<i class="fa fa-pencil-square-o"></i>
																	</button>
																	<a
																		href="queuedelete.php?id=<?php echo $row_member['uniqueid']; ?>&queueid=<?php echo $_GET['id']; ?>&uid=<?php echo $_GET['uid']; ?>">
																		<button class="item" data-toggle="tooltip"
																			data-placement="top" title="Delete"><i
																				class="fa fa-trash"></i></button>
																	</a>
																</div>
															</td>
														</tr>

													<?php }

												} ?>
											</tbody>
										</table>
									</div>
								</div>


								<script>
									function getData() {
										var extensions = $("#extensionSelect").val();
										var uid = $("#uid").val();
										var queue_number = $("#queue_number").val();
										var id = $("#id").val();
										$.ajax({
											url: 'queueForm.php',
											type: 'post',
											data: { extensionSelect: extensions, uid: uid, queue_number: queue_number, id: id },
											success: function (response) {
												location.reload(true);
											}
										})
										// $("#ringForm").submit();
									}
								</script>

								<div class="col-md-6">
									<div class="agent_form_outer">
										<form id="queueForm" action="" method="post">
											<div class="form-group">
												<label for="extensionSelect" class=" form-control-label"
													style="color:black;">Assigned Extensions</label>
												<select name="extensionSelect[]" id="extensionSelect"
													class="form-control-sm form-control" multiple="multiple">
													<?php while ($row_buddies = mysqli_fetch_array($result_queuebuddies)) { ?>
														<option ondblclick="getData()"
															value="<?php echo $row_buddies['name']; ?>">
															<?php echo $row_buddies['name']; ?>
														</option>
													<?php } ?>
												</select>
												<input type="hidden" name="" id="queue_number"
													value="<?php echo $queue_number; ?>" />
												<input type="hidden" name="" id="uid"
													value="<?php echo $_GET['uid']; ?>" />
												<input type="hidden" name="" id="id" value="<?php echo $_GET['id']; ?>">
											</div>
											<div class="form-group pull-right">
												<button type="button" onclick="getData()" name="submit" value="submit"
													id="saveQueueMember" class="btn btn-primary btn-sm">Submit</button>
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
									<th>Queue Name</th>
									<th>Queue Number</th>
									<th>Company</th>
									<th>Strategy</th>
									<th>Music Class</th>
									<th>Status</th>
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
									'url': 'ajaxfile.php'
								},
								'columns': [
									{ data: 'queue_name' },
									{ data: 'name' },
									{ data: 'clientName' },
									{ data: 'strategy' },
									{ data: 'musicclass' },
									{ data: 'status' },
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


<div class="modal1 fade" id="Mymodal1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title">Notification</h4>
			</div>
			<div class="modal-body">
				Are you sure you want to continue?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	function getResults() {
		var radios = document.getElementsByName("address");
		for (var i = 0; i < radios.length; i++) {
			if (radios[i].checked) {
				var a = radios[i].value
				alert(a);
				document.yourformname.action = "yourphp.php?a=" + a;
				document.yourformname.submit();
				break;
			}
		}
	}
</script>

<script>
	$(document).ready(function () {
		$('.MybtnModal').click(function () {
			$('#Mymodal1').modal('show')
		});
	});
</script>
<?php require_once ('footer.php'); ?>
