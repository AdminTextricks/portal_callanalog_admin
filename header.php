<?php

//Set the session timeout for 2 seconds
// $timeout = 60 * 20; 
$timeout = 2 * 60 * 60;
//Set the maxlifetime of the session
ini_set("session.gc_maxlifetime", $timeout);
//Set the cookie lifetime of the session
ini_set("session.cookie_lifetime", $timeout);
//Start a new session
session_start();
//Set the default session name
$s_name = session_name();
// echo $s_name;exit;
//Check the session exists or not
if (isset($_COOKIE[$s_name])) {
	setcookie($s_name, $_COOKIE[$s_name], time() + $timeout, '/');
	// echo "Session is created for $s_name.<br/>";
} else {
	header('location: logout.php');
}

require_once ('connection.php');
require_once ('functions.php');

// echo '<pre>';print_r($_SESSION);exit; 
if (!isset($_SESSION['login_user'])) {
	header('location: index.php');
	exit;
}
if (isset($_SESSION['userroleforpage']) && in_array($_SESSION['userroleforpage'], array(3, 4))) {

	header('location: ../adminr/dashboard.php');
}
//$select_clientinfo = "select name,clientId,role,id,profile_image,deleted,status from users_login where email='" . $_SESSION['login_user'] . "'";
$select_clientinfo = "select email, name,clientId,role,id,profile_image,deleted,status from users_login where id='" . $_SESSION['login_user_id'] . "'";
$result_clientinfo = mysqli_query($con, $select_clientinfo);
while ($rowclientinfo = mysqli_fetch_array($result_clientinfo)) {
	$currentlogin_user = $rowclientinfo['name'];
	$currentlogin_useridss = $rowclientinfo['clientId'];
	$currentlogin_userrole = $rowclientinfo['role'];
	$currentlogin_userorgid = $rowclientinfo['id'];
	$currentlogin_user_image = $rowclientinfo['profile_image'];
	$currentlogin_userStatus = $rowclientinfo['status'];
	$currentlogin_userdeleted = $rowclientinfo['deleted'];
	$currentlogin_email = $rowclientinfo['email'];
}
if ($currentlogin_userStatus == 'Inactive' or $currentlogin_userdeleted == '1' or $currentlogin_email != $_SESSION['login_user']) {
	echo "<script>window.location.href='logout.php'</script>";
}
// echo '<pre>';print_r($_SESSION );exit; 

$_SESSION['userroleforpage'] = $currentlogin_userrole;
$_SESSION['userroleforclientid'] = $currentlogin_useridss;

if ($_SESSION['userroleforpage'] == '1') {
	$select_barge = "select name from cc_sip_buddies where sip_type='Yes'";
} else {
	$select_barge = "select name from cc_sip_buddies where id_cc_card='" . $currentlogin_userorgid . "' and sip_type='Yes'";
}


$select_menurs = "select menu_id from user_menu_list where user_id='" . $currentlogin_userorgid . "'";
$result_menurs = mysqli_query($con, $select_menurs);

$stack_menus = array();
while ($rowmenusrs = mysqli_fetch_array($result_menurs)) {

	array_push($stack_menus, $rowmenusrs);
}
$theArraymenuss = json_encode($stack_menus);
$theArray1menus = json_decode($theArraymenuss, true);


$useriid2 = $_SESSION['login_user_id'];
$upstatus2 = 'Rejected, Pending';

if ($_SESSION['userroleforpage'] == 1) {
	$upload_doc2 = "SELECT * FROM upload_documents WHERE 1 ";
} else {
	$upload_doc2 = "SELECT * FROM upload_documents WHERE user_id='" . $useriid2 . "' AND status NOT IN ('" . $upstatus2 . "')";
}

// echo $upload_doc2;
$upload_doc_query2 = mysqli_query($connection, $upload_doc2);

$hasRejectedDocument = false;
$hasPendingDocument = false;
$hasApprovedDocument = false;
$hasUploadedDocument = false;

while ($row_upload_doc_head2 = mysqli_fetch_assoc($upload_doc_query2)) {
	$up_status_doc2 = $row_upload_doc_head2['status'];

	if ($up_status_doc2 === 'Rejected') {
		$hasRejectedDocument = true;
	} elseif ($up_status_doc2 === 'Pending') {
		$hasPendingDocument = true;
	} elseif ($up_status_doc2 === 'Approved') {
		$hasApprovedDocument = true;
	}

	$hasUploadedDocument = true;
}

if ($_SESSION['userroleforpage'] == 1) {
	// For admin users, set all document flags to false
	$hasRejectedDocument = false;
	$hasPendingDocument = false;
	$hasApprovedDocument = false;
}

// Check if there is no user_id and status
if (empty($useriid2) && empty($up_status_doc2)) {
	$hasUploadedDocument = false;
}

?>
<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="au theme template">
	<meta name="author" content="Hau Nguyen">
	<meta name="keywords" content="au theme template">

	<title>Call Analog</title>

	<link href="resources/css/font-face.css" rel="stylesheet" media="all">
	<!-- <link href="assets/css/popcss.css" rel="stylesheet" media="all">  -->

	<link href="resources/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">

	<link href="resources/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
	<link rel="stylesheet" type="text/css"
		href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link href="resources/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">

	<link href="resources/vendor/select2/select2.min.css" rel="stylesheet" media="all">
	<link href="resources/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
	<link href="resources/css/theme.css" rel="stylesheet" media="all">
	<link href="resources/css/custom_style.css" rel="stylesheet" media="all">
	<link rel="icon" href="resources/images/favicon.png" sizes="32x32" />
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

	<!-- Date pickers start -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<!--<link rel="stylesheet" href="/resources/demos/style.css">-->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- Date pickers end -->
	<!-- <script src="http://65.20.69.149/myphonesystems/assets/js/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
	<script src="http://65.20.69.149/myphonesystems/assets/js/balance.js"></script> -->

	<!-- <script src="resources/js/datatables.min.js"></script>
<link href='resources/css/datatables.min.css' rel='stylesheet' type='text/css'>

<script src="jquery-3.3.1.min_test.js"></script> -->
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

	<script src="DataTables/datatables.min.js"></script>
	<link href="DataTables/datatables.min.css" rel='stylesheet' type='text/css'>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link href="resources/css/bootstrap.min.css" rel="stylesheet" media="all">
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  -->
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>


	<script language="javascript" type="text/javascript">
		$(document).ready(function () {
			load_barge_content();
		});
		var autoLoad = setInterval(
			function () {
				$('#sample').load('biglives_content.php');
			}, 1000); // refresh page every 10 seconds

		function load_barge_content() {
			$('#sample_barge').load('barge_content.php');
		}

		var autoLoad = setInterval(load_barge_content, 15000); // refresh page every 10 seconds

		var autoLoad = setInterval(
			function () {
				$('#sample_barge_ring').load('barge_content_ring.php');
			}, 5000);
	</script>
	<style>
		.contents {
			width: 100% !important;
		}

		.contents li {
			display: contents !important;
		}

		.contents li a {
			padding: 10px 10px !important;
		}
	</style>
</head>

<body class="animsition1">


	<div class="page-wrapper">

		<header class="header-mobile d-block d-lg-none">
			<div class="header-mobile__bar">
				<div class="container-fluid">
					<div class="header-mobile-inner">
						<a class="logo" href="/">
							<!-- <img src="resources/images/icon/logo.png" alt="CoolAdmin" /> -->
						</a>
						<button class="hamburger hamburger--slider" type="button">
							<span class="hamburger-box">
								<span class="hamburger-inner"></span>
							</span>
						</button>
					</div>
				</div>
			</div>
			<nav class="navbar-mobile">

				<div class="container-fluid">
					<ul class="navbar-mobile__list list-unstyled">

						<?php if (!$hasUploadedDocument) { ?>
							<li>
								<a class="nav-link" href="upload_documents_add.php">
									<i class="fa fa-circle font-10"></i> Upload Documents
								</a>
							</li>
						<?php } else { ?>
							<?php if ($hasApprovedDocument && !$hasRejectedDocument && !$hasPendingDocument) { ?>
								<li class="">
									<a href="dashboard.php">
										<i class="fa fa-tachometer"></i> <span>Dashboard</span>
									</a>
								</li>
								<li class="has-sub" id="menu4">
									<a href="extension.php">
										<i class="fa fa-etsy"></i> <span>Extension</span></a>
								</li>

								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvldmdmdd1" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-calendar"></i><span class="menu-title">Destination</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvldmdmdd1" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="inbound.php"><i
														class="fa fa-circle font-10"></i> Destination</a></li>
											<li class="nav-item">
												<a class="nav-link" href="blacklist.php"><i class="fa fa-circle  font-10"></i>
													<span>Block Number</span></a>
											</li>
										</ul>
									</div>
								</li>

								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnm1" class="collapsed" aria-expanded="false">
										<i class="fa fa-registered"></i><span class="menu-title">Ring Group</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlRnm1" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="ringadd.php"><i
														class="fa fa-circle font-10"></i>Add Ring Group</a></li>
											<li class="nav-item"><a class="nav-link" href="ring.php"><i
														class="fa fa-circle  font-10"></i> Ring Group List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnm2" class="collapsed" aria-expanded="false">
										<i class="fa fa-superpowers"></i><span class="menu-title">call Queues</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlRnm2" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="queueadd.php"><i
														class="fa fa-circle font-10"></i>Add Queues</a></li>
											<li class="nav-item"><a class="nav-link" href="queue.php"><i
														class="fa fa-circle  font-10"></i> Queues List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnm3" class="collapsed" aria-expanded="false">
										<i class="fa fa-diamond"></i><span class="menu-title">call Conference</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlRnm3" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="conferenceadd.php"><i
														class="fa fa-circle font-10"></i>Add Conference</a></li>
											<li class="nav-item"><a class="nav-link" href="conference.php"><i
														class="fa fa-circle  font-10"></i> Conference List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD33" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-envelope-open-o"></i><span class="menu-title">Voice Mail</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD33" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="voiceMailAdd.php"><i
														class="fa fa-circle font-10"></i>Add Voice Mail</a></li>
											<li class="nav-item"><a class="nav-link" href="voicemail.php"><i
														class="fa fa-circle  font-10"></i> Voice Mail List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD35" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-snowflake-o"></i><span class="menu-title">IVR</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD35" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="ivradd.php"><i
														class="fa fa-circle font-10"></i>Add IVR</a></li>
											<li class="nav-item"><a class="nav-link" href="ivr.php"><i
														class="fa fa-circle  font-10"></i>IVR List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD36" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-user-times"></i><span class="menu-title">Time Condition</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD36" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="timegroupadd.php"><i
														class="fa fa-circle font-10"></i>Add Condition</a></li>
											<li class="nav-item"><a class="nav-link" href="timegroup.php"><i
														class="fa fa-circle  font-10"></i>Condition List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD34" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-microphone"></i><span class="menu-title">Recording</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD34" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="recordingAdd.php"><i
														class="fa fa-circle font-10"></i>Add Recording</a></li>
											<li class="nav-item"><a class="nav-link" href="recording.php"><i
														class="fa fa-circle  font-10"></i> Recording List</a></li>
										</ul>
									</div>
								</li>
								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<li class="dropdown">
										<a data-toggle="collapse" href="#dropdown-lvlRnmD37" class="collapsed"
											aria-expanded="false">
											<i class="fa fa-credit-card"></i><span class="menu-title">Rates</span>
											<span class="caret"></span>
										</a>
										<div id="dropdown-lvlRnmD37" class="panel-collapse collapse" aria-expanded="false"
											style="height: 0px;">
											<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
												<li class="nav-item"><a class="nav-link" href="ratecard.php"><i
															class="fa fa-circle font-10"></i>Plan</a></li>
												<li class="nav-item"><a class="nav-link" href="rate.php"><i
															class="fa fa-circle  font-10"></i>Cost</a></li>
												<li class="nav-item"><a class="nav-link" href="creditsadd.php"><i
															class="fa fa-circle  font-10"></i>Add Balance</a></li>
											</ul>
										</div>
									</li>

									<li class="dropdown">
										<a data-toggle="collapse" href="#dropdown-lvlRnmD40" class="collapsed"
											aria-expanded="false">
											<i class="fa fa-server"></i><span class="menu-title">Server Details</span>
											<span class="caret"></span>
										</a>
										<div id="dropdown-lvlRnmD40" class="panel-collapse collapse" aria-expanded="false"
											style="height: 0px;">
											<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
												<li class="nav-item"><a class="nav-link" href="system_info.php"><i
															class="fa fa-circle font-10"></i>Server Details:1</a></li>
												<li class="nav-item"><a class="nav-link" href="system_info2.php"><i
															class="fa fa-circle  font-10"></i>Server Details:2</a></li>
												<li class="nav-item"><a class="nav-link" href="system_info3.php"><i
															class="fa fa-circle  font-10"></i>Server Details:3</a></li>
											</ul>
										</div>
									</li>

								<?php } ?>
								<?php if ($_SESSION['userroleforpage'] != 1) { ?>
									<li class="nav-item">
										<a data-toggle="collapse" href="#dropdown-lvlmmm3" class="collapsed" aria-expanded="false">
											<i class="fa fa-money"></i><span class="menu-title">Billing</span>
											<span class="caret"></span>
										</a>
										<div id="dropdown-lvlmmm3" class="panel-collapse collapse" aria-expanded="false"
											style="height: 0px;">
											<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
												<!-- <li class="nav-item"><a class="nav-link" href="#">Invoice</a></li> -->
												<li class="nav-item"><a class="nav-link" href="add_balance.php"> <i
															class="fa fa-circle  font-10"></i> Add Balance</a></li>
												<!-- <li class="nav-item"><a class="nav-link" href="h#">All Transaction</a></li> -->
											</ul>
										</div>
									</li>
								<?php } ?>

								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlmsam2" class="collapsed" aria-expanded="false">
										<i class="fa fa-newspaper-o"></i><span class="menu-title">Reports</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlmsam2" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<?php if ($_SESSION['userroleforpage'] == 1) { ?>
												<li class="nav-item"><a class="nav-link" href="recharge_history.php"> <i
															class="fa fa-circle  font-10"></i>Recharge History</a></li>
											<?php } ?>
											<li class="nav-item"><a class="nav-link" href="sipregistration_list.php"> <i
														class="fa fa-circle  font-10"></i>SIP Registration</a></li>
											<li class="nav-item"><a class="nav-link" href="barge.php"> <i
														class="fa fa-circle  font-10"></i>Live Calls</a></li>
											<li class="nav-item"><a class="nav-link" href="inboundRports.php"> <i
														class="fa fa-circle  font-10"></i> Inbound CDR</a></li>
											<li class="nav-item"><a class="nav-link" href="outboundRports.php"> <i
														class="fa fa-circle  font-10"></i> Outbound CDR</a></li>
											<?php //if($_SESSION['userroleforpage'] == 1){   ?>
											<li class="nav-item"><a class="nav-link" href="transactionRports.php"> <i
														class="fa fa-circle  font-10"></i>Transaction Reports</a></li>
											<?php //}   ?>
											<li class="nav-item"><a class="nav-link" href="missed.php"> <i
														class="fa fa-circle  font-10"></i> Missed Call Record</a></li>
											<li class="nav-item"><a class="nav-link" href="invoices.php"> <i
														class="fa fa-circle  font-10"></i> Invoices</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlmsum1" class="collapsed" aria-expanded="false">
										<i class="fa fa-support"></i><span class="menu-title">Support</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlmsum1" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="contact_us.php"> <i
														class="fa fa-circle  font-10"></i> Contact Us</a></li>
										</ul>
									</div>
								</li>

							<?php } else {
								if ($_SESSION['userroleforpage'] == 2) { ?>

									<li>
										<a class="nav-link" href="upload_documents_add.php">
											<i class="fa fa-circle font-10"></i> Upload Documents
										</a>
									</li>
								<?php }
							} ?>

							<?php if ($hasPendingDocument) { ?>
								<script>
									window.onload = function () {
										alert("You have pending documents. Please complete the document upload.");
									};
								</script>
							<?php } ?>

						<?php } ?>

						<?php if ($_SESSION['userroleforpage'] == 1) { ?>
							<li class="">
								<a href="dashboard.php">
									<i class="fa fa-tachometer"></i> <span>Dashboard</span>
								</a>
							</li>

							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlExtensiond1" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-etsy"></i><span class="menu-title">Extension</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlExtensiond1" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="extension.php"><i
													class="fa fa-circle font-10"></i> Extension</a></li>
										<li class="nav-item"><a class="nav-link" href="webrtc_template.php"><i
													class="fa fa-circle font-10"></i> WEB PHONE </a></li>
									</ul>
								</div>
							</li>

							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvldmd1" class="collapsed" aria-expanded="false">
									<i class="fa fa-calendar"></i><span class="menu-title">Destination</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvldmd1" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="inbound.php"><i
													class="fa fa-circle font-10"></i> Destination</a></li>
										<li class="nav-item">
											<a class="nav-link" href="blacklist.php"><i class="fa fa-circle  font-10"></i>
												<span>Block Number</span></a>
										</li>
									</ul>
								</div>
							</li>

							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnm1" class="collapsed" aria-expanded="false">
									<i class="fa fa-registered"></i><span class="menu-title">Ring Group</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlRnm1" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="ringadd.php"><i
													class="fa fa-circle font-10"></i>Add Ring Group</a></li>
										<li class="nav-item"><a class="nav-link" href="ring.php"><i
													class="fa fa-circle  font-10"></i> Ring Group List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnm2" class="collapsed" aria-expanded="false">
									<i class="fa fa-superpowers"></i><span class="menu-title">Call Queues</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnm2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="queueadd.php"><i
													class="fa fa-circle font-10"></i>Add Queues</a></li>
										<li class="nav-item"><a class="nav-link" href="queue.php"><i
													class="fa fa-circle  font-10"></i> Queues List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnm3" class="collapsed" aria-expanded="false">
									<i class="fa fa-diamond"></i><span class="menu-title">Call Conference</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnm3" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="conferenceadd.php"><i
													class="fa fa-circle font-10"></i>Add Conference</a></li>
										<li class="nav-item"><a class="nav-link" href="conference.php"><i
													class="fa fa-circle  font-10"></i> Conference List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDa33" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-envelope-open-o"></i><span class="menu-title">Voice Mail</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDa33" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="voiceMailAdd.php"><i
													class="fa fa-circle font-10"></i>Add Voice Mail</a></li>
										<li class="nav-item"><a class="nav-link" href="voicemail.php"><i
													class="fa fa-circle  font-10"></i> Voice Mail List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDa35" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-snowflake-o"></i><span class="menu-title">IVR</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDa35" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="ivradd.php"><i
													class="fa fa-circle font-10"></i>Add IVR</a></li>
										<li class="nav-item"><a class="nav-link" href="ivr.php"><i
													class="fa fa-circle  font-10"></i>IVR List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDa36" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-user-times"></i><span class="menu-title">Time Condition</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDa36" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="timegroupadd.php"><i
													class="fa fa-circle font-10"></i>Add Condition</a></li>
										<li class="nav-item"><a class="nav-link" href="timegroup.php"><i
													class="fa fa-circle  font-10"></i>Condition List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDa34" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-microphone"></i><span class="menu-title">Recording</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDa34" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="recordingAdd.php"><i
													class="fa fa-circle font-10"></i>Add Recording</a></li>
										<li class="nav-item"><a class="nav-link" href="recording.php"><i
													class="fa fa-circle  font-10"></i> Recording List</a></li>
									</ul>
								</div>
							</li>
							<?php if ($_SESSION['userroleforpage'] == 1) { ?>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD37" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-credit-card"></i><span class="menu-title">Rates</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD37" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="ratecard.php"><i
														class="fa fa-circle font-10"></i>Plan</a></li>
											<li class="nav-item"><a class="nav-link" href="rate.php"><i
														class="fa fa-circle  font-10"></i>Cost</a></li>
											<li class="nav-item"><a class="nav-link" href="creditsadd.php"><i
														class="fa fa-circle  font-10"></i>Add Balance</a></li>
										</ul>
									</div>
								</li>

								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD40" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-server"></i><span class="menu-title">Server Details</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD40" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="system_info.php"><i
														class="fa fa-circle font-10"></i>Server Details:1</a></li>
											<li class="nav-item"><a class="nav-link" href="system_info2.php"><i
														class="fa fa-circle  font-10"></i>Server Details:2</a></li>
											<li class="nav-item"><a class="nav-link" href="system_info3.php"><i
														class="fa fa-circle  font-10"></i>Server Details:3</a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if ($_SESSION['userroleforpage'] != 1) { ?>
								<li class="nav-item">
									<a data-toggle="collapse" href="#dropdown-lvlm3" class="collapsed" aria-expanded="false">
										<i class="fa fa-money"></i><span class="menu-title">Billing</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlm3" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="add_balance.php"> <i
														class="fa fa-circle  font-10"></i> Add Balance</a></li>
										</ul>
									</div>
								</li>
							<?php } ?>

							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlm2" class="collapsed" aria-expanded="false">
									<i class="fa fa-newspaper-o"></i><span class="menu-title">Reports</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlm2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<?php if ($_SESSION['userroleforpage'] == 1) { ?>
											<li class="nav-item"><a class="nav-link" href="recharge_history.php"> <i
														class="fa fa-circle  font-10"></i>Recharge History</a></li>
										<?php } ?>
										<li class="nav-item"><a class="nav-link" href="sipregistration_list.php"> <i
													class="fa fa-circle  font-10"></i>SIP Registration</a></li>

										<li class="nav-item"><a class="nav-link" href="barge.php"> <i
													class="fa fa-circle  font-10"></i>Live Calls</a></li>
										<li class="nav-item"><a class="nav-link" href="inboundRports.php"> <i
													class="fa fa-circle  font-10"></i> Inbound CDR</a></li>
										<li class="nav-item"><a class="nav-link" href="outboundRports.php"> <i
													class="fa fa-circle  font-10"></i> Outbound CDR</a></li>
										<?php //if($_SESSION['userroleforpage'] == 1){   ?>
										<li class="nav-item"><a class="nav-link" href="transactionRports.php"> <i
													class="fa fa-circle  font-10"></i>Transaction Reports</a></li>
										<?php //}   ?>
										<li class="nav-item"><a class="nav-link" href="missed.php"> <i
													class="fa fa-circle  font-10"></i> Missed Call Record</a></li>
										<li class="nav-item"><a class="nav-link" href="invoices.php"> <i
													class="fa fa-circle  font-10"></i> Invoices</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlulm2" class="collapsed" aria-expanded="false">
									<i class="fa fa-user"></i><span class="menu-title">Users </span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlulm2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="users.php"> <i
													class="fa fa-circle  font-10"></i> All Users</a></li>
										<li class="nav-item"><a class="nav-link" href="upload_documents_list.php"> <i
													class="fa fa-circle  font-10"></i> Uploaded Documents</a></li>
									</ul>
								</div>
							</li>

							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlulm2" class="collapsed" aria-expanded="false">
									<i class="fa fa-user"></i><span class="menu-title">DID</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlulm2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="did.php"> <i
													class="fa fa-circle  font-10"></i> Add DID</a></li>
										<li class="nav-item"><a class="nav-link" href="did_purchase_history.php"> <i
													class="fa fa-circle  font-10"></i> DID Purchase History</a></li>
									</ul>
								</div>
							</li>
							<li>
								<a href="outboundroute.php">
									<i class="fa fa-map-marker"></i>Trunk</a>
							</li>
							<li>
								<a href="client.php">
									<i class="fa fa-quora"></i> Client</a>
							</li>
							<li class="has-sub" id="menu6">
								<a href="inboundroute.php">
									<i class="fa fa-street-view"></i> <span>Inbound Route</span></a>


							</li>

						<?php } ?>


					</ul>
				</div>
			</nav>
		</header>

		<aside class="menu-sidebar d-none d-lg-block">
			<div class="logo">
				<!--<span class="mini_logo"><img src="resources/images/mini_logo.png" alt="mini logo" /></span>-->
				<a class="full_logo" href="">
					<img src="resources/images/logo.png" style="/*width: 100px;margin-left:50px;*/" alt="logo" />
				</a>

			</div>
			<div class="menu-sidebar__content js-scrollbar1">
				<nav class="navbar-sidebar">
					<ul class="list-unstyled navbar__list">
						<?php //echo "<pre>"; print_r($theArray1menus); die;   ?>

						<?php

						?>
						<?php if (!$hasUploadedDocument) { ?>
							<li>
								<a class="nav-link" href="upload_documents_add.php">
									<i class="fa fa-circle font-10"></i> Upload Documents
								</a>
							</li>
						<?php } else { ?>
							<?php if ($hasApprovedDocument && !$hasRejectedDocument && !$hasPendingDocument) { ?>
								<li class="">
									<a href="dashboard.php">
										<i class="fa fa-tachometer"></i> <span>Dashboard</span>
									</a>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvldu1" class="collapsed" aria-expanded="false">
										<i class="fa fa-calendar"></i><span class="menu-title">Destination</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvldu1" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="inbound.php"><i
														class="fa fa-circle font-10"></i> Destination</a></li>
											<li class="nav-item">
												<a class="nav-link" href="blacklist.php"><i class="fa fa-circle  font-10"></i>
													<span>Block Number</span></a>
											</li>


										</ul>
									</div>
								</li>
								<li class="has-sub" id="menu4">
									<a href="extension.php">
										<i class="fa fa-etsy"></i> <span>Extension</span></a>
								</li>

								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDu1" class="collapsed" aria-expanded="false">
										<i class="fa fa-registered"></i><span class="menu-title">Ring Group</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlRnDu1" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="ringadd.php"><i
														class="fa fa-circle font-10"></i>Add Ring Group</a></li>
											<li class="nav-item"><a class="nav-link" href="ring.php"><i
														class="fa fa-circle  font-10"></i> Ring Group List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDu2" class="collapsed" aria-expanded="false">
										<i class="fa fa-superpowers"></i><span class="menu-title">Call Queues</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlRnDu2" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="queueadd.php"><i
														class="fa fa-circle font-10"></i>Add Queues</a></li>
											<li class="nav-item"><a class="nav-link" href="queue.php"><i
														class="fa fa-circle  font-10"></i> Queues List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDu3" class="collapsed" aria-expanded="false">
										<i class="fa fa-diamond"></i><span class="menu-title">Call Conference</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlRnDu3" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="conferenceadd.php"><i
														class="fa fa-circle font-10"></i>Add Conference</a></li>
											<li class="nav-item"><a class="nav-link" href="conference.php"><i
														class="fa fa-circle  font-10"></i> Conference List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDmm33" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-envelope-open-o"></i><span class="menu-title">Voice Mail</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnDmm33" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="voiceMailAdd.php"><i
														class="fa fa-circle font-10"></i>Add Voice Mail</a></li>
											<li class="nav-item"><a class="nav-link" href="voicemail.php"><i
														class="fa fa-circle  font-10"></i> Voice Mail List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDmm35" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-snowflake-o"></i><span class="menu-title">IVR</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnDmm35" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="ivradd.php"><i
														class="fa fa-circle font-10"></i>Add IVR</a></li>
											<li class="nav-item"><a class="nav-link" href="ivr.php"><i
														class="fa fa-circle  font-10"></i> IVR List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDmm36" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-user-times"></i><span class="menu-title">Time Condition</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnDmm36" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="timegroupadd.php"><i
														class="fa fa-circle font-10"></i>Add Condition</a></li>
											<li class="nav-item"><a class="nav-link" href="timegroup.php"><i
														class="fa fa-circle  font-10"></i> Condition List</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnDmm34" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-microphone"></i><span class="menu-title">Recording</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnDmm34" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="recordingAdd.php"><i
														class="fa fa-circle font-10"></i>Add Recording</a></li>
											<li class="nav-item"><a class="nav-link" href="recording.php"><i
														class="fa fa-circle  font-10"></i> Recording List</a></li>
										</ul>
									</div>
								</li>
								<?php if ($_SESSION['userroleforpage'] == 1) { ?>
									<li class="dropdown">
										<a data-toggle="collapse" href="#dropdown-lvlRnmD39" class="collapsed"
											aria-expanded="false">
											<i class="fa fa-credit-card"></i><span class="menu-title">Rates</span>
											<span class="caret"></span>
										</a>
										<div id="dropdown-lvlRnmD39" class="panel-collapse collapse" aria-expanded="false"
											style="height: 0px;">
											<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
												<li class="nav-item"><a class="nav-link" href="ratecard.php"><i
															class="fa fa-circle font-10"></i>Plan</a></li>
												<li class="nav-item"><a class="nav-link" href="rate.php"><i
															class="fa fa-circle  font-10"></i>Cost</a></li>
												<li class="nav-item"><a class="nav-link" href="creditsadd.php"><i
															class="fa fa-circle  font-10"></i>Add Balance</a></li>
											</ul>
										</div>
									</li>
									<li class="dropdown">
										<a data-toggle="collapse" href="#dropdown-lvlRnmD41" class="collapsed"
											aria-expanded="false">
											<i class="fa fa-server"></i><span class="menu-title">Server Details</span>
											<span class="caret"></span>
										</a>
										<div id="dropdown-lvlRnmD41" class="panel-collapse collapse" aria-expanded="false"
											style="height: 0px;">
											<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
												<li class="nav-item"><a class="nav-link" href="system_info.php"><i
															class="fa fa-circle font-10"></i>Server Details:1</a></li>
												<li class="nav-item"><a class="nav-link" href="system_info2.php"><i
															class="fa fa-circle  font-10"></i>Server Details:2</a></li>
												<li class="nav-item"><a class="nav-link" href="system_info3.php"><i
															class="fa fa-circle  font-10"></i>Server Details:3</a></li>
											</ul>
										</div>
									</li>

								<?php } ?>
								<?php if ($_SESSION['userroleforpage'] != 1) { ?>
									<li class="nav-item">
										<a data-toggle="collapse" href="#dropdown-lvlu3" class="collapsed" aria-expanded="false">
											<i class="fa fa-money"></i><span class="menu-title">Billing</span>
											<span class="caret"></span> </a>
										</a>
										<div id="dropdown-lvlu3" class="panel-collapse collapse" aria-expanded="false"
											style="height: 0px;">
											<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
												<!-- <li class="nav-item"><a class="nav-link" href="#">Invoice</a></li> -->
												<li class="nav-item"><a class="nav-link" href="add_balance.php"> <i
															class="fa fa-circle  font-10"></i> Add Balance</a></li>
												<!-- <li class="nav-item"><a class="nav-link" href="h#">All Transaction</a></li> -->
											</ul>
										</div>
									</li>
								<?php } ?>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlu2" class="collapsed" aria-expanded="false">
										<i class="fa fa-newspaper-o"></i><span class="menu-title">Reports</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvlu2" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<?php if ($_SESSION['userroleforpage'] == 1) { ?>
												<li class="nav-item"><a class="nav-link" href="recharge_history.php"> <i
															class="fa fa-circle  font-10"></i>Recharge History</a></li>
											<?php } ?>
											<li class="nav-item"><a class="nav-link" href="sipregistration_list.php"> <i
														class="fa fa-circle  font-10"></i>SIP Registration</a></li>

											<li class="nav-item"><a class="nav-link" href="barge.php"> <i
														class="fa fa-circle  font-10"></i>Live Calls</a></li>
											<li class="nav-item"><a class="nav-link" href="inboundRports.php"> <i
														class="fa fa-circle  font-10"></i> Inbound CDR</a></li>
											<li class="nav-item"><a class="nav-link" href="outboundRports.php"> <i
														class="fa fa-circle  font-10"></i> Outbound CDR</a></li>
											<?php //if($_SESSION['userroleforpage'] == 1){   ?>
											<li class="nav-item"><a class="nav-link" href="transactionRports.php"> <i
														class="fa fa-circle  font-10"></i>Transaction Reports</a></li>
											<?php //}   ?>
											<li class="nav-item"><a class="nav-link" href="missed.php"> <i
														class="fa fa-circle  font-10"></i> Missed Call Record</a></li>
											<li class="nav-item"><a class="nav-link" href="invoices.php"> <i
														class="fa fa-circle  font-10"></i> Invoices</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvluu2" class="collapsed" aria-expanded="false">
										<i class="fa fa-user"></i><span class="menu-title">User </span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvluu2" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link"
													href="useredit.php?id=<?php echo ($_SESSION['login_user_id']) ?>"> <i
														class="fa fa-circle  font-10"></i> Edit Profile</a></li>
											<li class="nav-item"><a class="nav-link" href="upload_documents_list.php"> <i
														class="fa fa-circle  font-10"></i> Upload Documents</a></li>
										</ul>
									</div>
								</li>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvls1" class="collapsed" aria-expanded="false">
										<i class="fa fa-support"></i><span class="menu-title">Support</span>
										<span class="caret"></span> </a>
									<div id="dropdown-lvls1" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="contact_us.php"> <i
														class="fa fa-circle  font-10"></i> Contact Us</a></li>
										</ul>
									</div>
								</li>
							<?php } else {
								if ($_SESSION['userroleforpage'] == 2) { ?>

									<li>
										<a class="nav-link" href="upload_documents_add.php">
											<i class="fa fa-circle font-10"></i> Upload Documents
										</a>
									</li>
								<?php }
							} ?>

							<?php if ($hasPendingDocument) { ?>
								<script>
									window.onload = function () {
										alert("You have pending documents. Please complete the document upload.");
									};
								</script>
							<?php } ?>
						<?php } ?>

						<?php if ($_SESSION['userroleforpage'] == 1) { ?>
							<li class="">
								<a href="dashboard.php">
									<i class="fa fa-tachometer"></i> <span>Dashboard</span>
								</a>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvld1" class="collapsed" aria-expanded="false">
									<i class="fa fa-calendar"></i><span class="menu-title">Destination</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvld1" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="inbound.php"><i
													class="fa fa-circle font-10"></i> Destination</a></li>
										<li class="nav-item">
											<a class="nav-link" href="blacklist.php"><i class="fa fa-circle  font-10"></i>
												<span>Block Number</span></a>
										</li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlExtension1" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-etsy"></i><span class="menu-title">Extension</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlExtension1" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="extension.php"><i
													class="fa fa-circle font-10"></i> Extension</a></li>
										<li class="nav-item"><a class="nav-link" href="webrtc_template.php"><i
													class="fa fa-circle font-10"></i> WEB PHONE </a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnD1" class="collapsed" aria-expanded="false">
									<i class="fa fa-registered"></i><span class="menu-title">Ring Group</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlRnD1" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="ringadd.php"><i
													class="fa fa-circle font-10"></i>Add Ring Group</a></li>
										<li class="nav-item"><a class="nav-link" href="ring.php"><i
													class="fa fa-circle  font-10"></i> Ring Group List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnD2" class="collapsed" aria-expanded="false">
									<i class="fa fa-superpowers"></i><span class="menu-title">Call Queues</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlRnD2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="queueadd.php"><i
													class="fa fa-circle font-10"></i>Add Queues</a></li>
										<li class="nav-item"><a class="nav-link" href="queue.php"><i
													class="fa fa-circle  font-10"></i> Queues List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnD3" class="collapsed" aria-expanded="false">
									<i class="fa fa-diamond"></i><span class="menu-title">Call Conference</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlRnD3" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="conferenceadd.php"><i
													class="fa fa-circle font-10"></i>Add Conference</a></li>
										<li class="nav-item"><a class="nav-link" href="conference.php"><i
													class="fa fa-circle  font-10"></i> Conference List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDaa33" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-envelope-open-o"></i><span class="menu-title">Voice Mail</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDaa33" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="voiceMailAdd.php"><i
													class="fa fa-circle font-10"></i>Add Voice Mail</a></li>
										<li class="nav-item"><a class="nav-link" href="voicemail.php"><i
													class="fa fa-circle  font-10"></i> Voice Mail List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDaa35" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-snowflake-o"></i><span class="menu-title">IVR</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDaa35" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="ivradd.php"><i
													class="fa fa-circle font-10"></i>Add IVR</a></li>
										<li class="nav-item"><a class="nav-link" href="ivr.php"><i
													class="fa fa-circle  font-10"></i> IVR List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDaa36" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-user-times"></i><span class="menu-title">Time Condition</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDaa36" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="timegroupadd.php"><i
													class="fa fa-circle font-10"></i>Add Condition</a></li>
										<li class="nav-item"><a class="nav-link" href="timegroup.php"><i
													class="fa fa-circle  font-10"></i> Condition List</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlRnDaa34" class="collapsed"
									aria-expanded="false">
									<i class="fa fa-microphone"></i><span class="menu-title">Recording</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlRnDaa34" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="recordingAdd.php"><i
													class="fa fa-circle font-10"></i>Add Recording</a></li>
										<li class="nav-item"><a class="nav-link" href="recording.php"><i
													class="fa fa-circle  font-10"></i> Recording List</a></li>
									</ul>
								</div>
							</li>
							<?php if ($_SESSION['userroleforpage'] == 1) { ?>
								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD39" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-credit-card"></i><span class="menu-title">Rates</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD39" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="ratecard.php"><i
														class="fa fa-circle font-10"></i>Plan</a></li>
											<li class="nav-item"><a class="nav-link" href="rate.php"><i
														class="fa fa-circle  font-10"></i>Cost</a></li>
											<li class="nav-item"><a class="nav-link" href="creditsadd.php"><i
														class="fa fa-circle  font-10"></i>Add Balance</a></li>
										</ul>
									</div>
								</li>


								<li class="dropdown">
									<a data-toggle="collapse" href="#dropdown-lvlRnmD41" class="collapsed"
										aria-expanded="false">
										<i class="fa fa-server"></i><span class="menu-title">Server Details</span>
										<span class="caret"></span>
									</a>
									<div id="dropdown-lvlRnmD41" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<li class="nav-item"><a class="nav-link" href="system_info.php"><i
														class="fa fa-circle font-10"></i>Server Details:1</a></li>
											<li class="nav-item"><a class="nav-link" href="system_info2.php"><i
														class="fa fa-circle  font-10"></i>Server Details:2</a></li>
											<li class="nav-item"><a class="nav-link" href="system_info3.php"><i
														class="fa fa-circle  font-10"></i>Server Details:3</a></li>
										</ul>
									</div>
								</li>
							<?php } ?>
							<?php if ($_SESSION['userroleforpage'] != 1) { ?>
								<li class="nav-item">
									<a data-toggle="collapse" href="#dropdown-lvl3" class="collapsed" aria-expanded="false">
										<i class="fa fa-money"></i><span class="menu-title">Billing</span>
										<span class="caret"></span> </a>
									</a>
									<div id="dropdown-lvl3" class="panel-collapse collapse" aria-expanded="false"
										style="height: 0px;">
										<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
											<!-- <li class="nav-item"><a class="nav-link" href="#">Invoice</a></li> -->
											<li class="nav-item"><a class="nav-link" href="add_balance.php"> <i
														class="fa fa-circle  font-10"></i> Add Balance</a></li>
											<!-- <li class="nav-item"><a class="nav-link" href="h#">All Transaction</a></li> -->
										</ul>
									</div>
								</li>
							<?php } ?>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvl2" class="collapsed" aria-expanded="false">
									<i class="fa fa-newspaper-o"></i><span class="menu-title">Reports</span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvl2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<?php if ($_SESSION['userroleforpage'] == 1) { ?>
											<li class="nav-item"><a class="nav-link" href="recharge_history.php"> <i
														class="fa fa-circle  font-10"></i>Recharge History</a></li>
										<?php } ?>
										<li class="nav-item"><a class="nav-link" href="sipregistration_list.php"> <i
													class="fa fa-circle  font-10"></i>SIP Registration</a></li>

										<li class="nav-item"><a class="nav-link" href="barge.php"> <i
													class="fa fa-circle  font-10"></i>Live Calls</a></li>
										<li class="nav-item"><a class="nav-link" href="inboundRports.php"> <i
													class="fa fa-circle  font-10"></i> Inbound CDR</a></li>
										<li class="nav-item"><a class="nav-link" href="outboundRports.php"> <i
													class="fa fa-circle  font-10"></i> Outbound CDR</a></li>
										<?php //if($_SESSION['userroleforpage'] == 1){   ?>
										<li class="nav-item"><a class="nav-link" href="transactionRports.php"> <i
													class="fa fa-circle  font-10"></i>Transaction Reports</a></li>
										<?php //}   ?>
										<li class="nav-item"><a class="nav-link" href="missed.php"> <i
													class="fa fa-circle  font-10"></i> Missed Call Record</a></li>
										<li class="nav-item"><a class="nav-link" href="invoices.php"> <i
													class="fa fa-circle  font-10"></i> Invoices</a></li>
									</ul>
								</div>
							</li>
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlul2" class="collapsed" aria-expanded="false">
									<i class="fa fa-user"></i><span class="menu-title">Users </span>
									<span class="caret"></span> </a>
								<div id="dropdown-lvlul2" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="users.php"> <i
													class="fa fa-circle  font-10"></i> All Users</a></li>
										<li class="nav-item"><a class="nav-link" href="upload_documents_list.php"> <i
													class="fa fa-circle  font-10"></i> Upload Documents</a></li>
									</ul>
								</div>
							</li>


							<!--<li class="has-sub" id="menu3">
<a href="did.php">
<i class="fa fa-diamond" aria-hidden="true"></i> DID</a>
</li>-->
							<li class="dropdown">
								<a data-toggle="collapse" href="#dropdown-lvlulm22" class="collapsed" aria-expanded="false">
									<i class="fa fa-diamond"></i><span class="menu-title">DID</span>
									<span class="caret"></span>
								</a>
								<div id="dropdown-lvlulm22" class="panel-collapse collapse" aria-expanded="false"
									style="height: 0px;">
									<ul class="nav flex-column sub-menu" style="list-style-type:disc;">
										<li class="nav-item"><a class="nav-link" href="didadd.php"> <i
													class="fa fa-circle  font-10"></i>Add DID</a></li>
													<li class="nav-item"><a class="nav-link" href="importdid.php"> <i
													class="fa fa-circle  font-10"></i>Import DID</a></li>
										<li class="nav-item"><a class="nav-link" href="did.php"> <i
													class="fa fa-circle  font-10"></i>DID List</a></li>
													<li class="nav-item"><a class="nav-link" href="did_deleted.php"> <i
													class="fa fa-circle  font-10"></i> Deleted DID</a></li>
										<!-- <li class="nav-item"><a class="nav-link" href="did_history.php"> <i
													class="fa fa-circle  font-10"></i> DID History</a></li> -->
									</ul>
								</div>
							</li>
							<li class="has-sub" id="menu6">
								<a href="outboundroute.php">
									<i class="fa fa-opera"></i> <span> Trunk</span></a>
							</li>
							<!-- <li>
<a href="client.php">
<i class="fa fa-quora"></i> Client</a>

</li> -->
							<li class="has-sub" id="menu6">
								<a href="inboundroute.php">
									<i class="fa fa-street-view"></i> <span>Inbound Route</span></a>
							</li>
						<?php } ?>




					</ul>
				</nav>
			</div>
		</aside>
		<div class="page-container">
			<style>
				#queryNumber {
					border: 1px solid gainsboro;
					padding: 6px 0 6px 10px;
				}

				#getQueryBtn {
					float: left;
					margin: 0 20px 0 5px;
					padding: 6px 15px;
					background: #2aa9de;
					color: white;
				}

				@media(max-width:767px) {

					#queryNumber,
					#getQueryBtn {
						display: none
					}
				}

				/* .weburl{
		margin: 25px;
		margin-bottom: 10px;
		margin-top: 5px;
	} */
			</style>


			<header class="header-desktop">
				<div class="section__content section__content--p30">
					<div class="container-fluid">
						<div class="header-wrap row m-bo">
							<div class="left_slide_icon col-sm-1">
								<i class="fa fa-bars zmdi zmdi-menu show_btn_togle" aria-hidden="true"></i>
								<i class="fa fa-bars zmdi zmdi-menu close_btn_togle" aria-hidden="true"></i>
							</div>
							<div class="col-sm-3 text-plan">
								<span style="color:blue;"><b> Server Time:</b></span>
								<span id="clock"></span>
								<script>
									setInterval(showTime, 1000);
									function showTime() {

										let chicago_datetime_str = new Date().toLocaleString("en-US", { timeZone: "America/New_York" });
										let time = new Date(chicago_datetime_str);

										let hour =
											time.getHours();
										let min =
											time.getMinutes();
										let sec =
											time.getSeconds();
										am_pm = "AM";

										if (hour >= 12) {
											if (hour > 12)
												hour -= 12;
											am_pm = "PM";
										} else if (hour == 0) {
											hr = 12;
											am_pm = "AM";
										}

										hour = hour < 10 ? "0" + hour : hour;
										min = min < 10 ? "0" + min : min;
										sec = sec < 10 ? "0" + sec : sec;

										let currentTime = hour + ":" + min + ":" + sec + ' ' + am_pm;

										document.getElementById("clock").innerHTML = currentTime;
									}

									showTime();
								</script>
							</div>
							<?php
							if ($_SESSION['userroleforpage'] == 2) {
								?>
								<div class="col-sm-3 text-plan">
									<span style="color:blue;"><b> Plan Type : </b></span>
									<?php //echo '<pre>'; print_r($_SESSION); echo '</pre>';
										$query = "SELECT * FROM  `master_plans` WHERE `id`='" . $_SESSION['login_user_plan_id'] . "'";
										$result = mysqli_query($connection, $query) or die("query failed");
										if (mysqli_num_rows($result) > 0) {
											while ($rows = mysqli_fetch_assoc($result)) {
												echo $rows['name'];
											}
											?>
									</div>
								<?php } ?>

								<div class="col-sm-3 text-balance">
									<span style="color:blue;"><b> Balance :</b></span> $
									<span id="userBalance"></span>
								</div>
							<?php } else { ?>
								<div class="col-sm-7"></div>
							<?php } ?>

							<div class="col-sm-1 text-bell">
								<a href="notification.php"><i class="fa fa-bell"></i></a>
								<span id="notification" style="color:red;font-size:20px;"></span>
							</div>



							<div class="header-button col-sm-2">

								<div class="account-wrap">
									<div class="account-item clearfix js-item-menu">
										<div class="image">
											<span>
												<?php
												$folder = "profile_image/" . $currentlogin_userorgid . "_" . $currentlogin_user_image;
												if ($currentlogin_user_image != '') {
													echo "<img src ='$folder' height='70px' width='70px'>";
												} else {

													echo substr($currentlogin_user, 0, 1);
												}

												?>
											</span>

										</div>
										<div class="content">
											<a class="js-acc-btn" href="#">
												<?php echo $currentlogin_user; ?>
											</a>
										</div>
										<div class="account-dropdown js-dropdown">
											<div class="info clearfix">
												<div class="image">
													<a href="#">

														<span>
															<?php
															$folder = "profile_image/" . $currentlogin_userorgid . "_" . $currentlogin_user_image;
															if ($currentlogin_user_image != '') {
																echo "<img src ='$folder' height='70px' width='70px'>";
															} else {

																echo substr($currentlogin_user, 0, 1);
															}

															?>
														</span>
													</a>
												</div>
												<div class="content">
													<h5 class="name">
														<a href="#">
															<?php echo $currentlogin_user; ?>
														</a>
													</h5>

												</div>
											</div>


											<div class="account-dropdown__footer">
												<!--<a href="resetpassword.php">-->
												<?php if ($_SESSION['userroleforpage'] == 1) { ?>
													<a
														href="useredit.php?id=<?php echo ($_SESSION['userroleforclientid']) ?>">
														<i class="fa fa-pencil-square-o zmdi zmdi-power"
															aria-hidden="true"></i> Profile</a>
												</div>

											<?php } else { ?>
												<a href="useredit.php?id=<?php echo ($_SESSION['login_user_id']) ?>">
													<i class="fa fa-pencil-square-o zmdi zmdi-power" aria-hidden="true"></i>
													Profile</a>
											<?php } ?>
											<div class="account-dropdown__footer">
												<?php if ($_SESSION['userroleforpage'] == 2) { ?>
													<a
														href="change_pswd.php?user_id=<?php echo $_SESSION['login_user_id']; ?>">
														<i class="fa fa-key" aria-hidden="true"></i>
														Change Password</a>
												<?php } ?>
											</div>
											<div class="account-dropdown__footer">
												<a href="logout.php">
													<i class="fa fa-sign-out zmdi zmdi-power" aria-hidden="true"></i>
													Logout</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>



			<div id="myModal" class="modal modal2" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title"></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<form name="" method="post">
							<!-- Modal body -->
							<div class="modal-body">
								<select name="barge" id="barge" class="form-control">
									<option value="">Please Select </option>
									<?php
									$result_barge = mysqli_query($connection, $select_barge);
									if (mysqli_num_rows($result_barge) > 0) {
										while ($rowbarge = mysqli_fetch_array($result_barge)) { ?>
											<option value="<?php echo $rowbarge['name']; ?>">
												<?php echo $rowbarge['name']; ?>
											</option>
										<?php }
									} ?>
								</select>
							</div>
							<input type="hidden" id="hidden_ext" name="hidden_ext" value="">
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								<input type="button" value="Confirm" onclick="getBargeCall()" class="btn btn-primary">
							</div>
						</form>

					</div>
				</div>
			</div>
			<input type="hidden" name="" id="user_id" value="<?php echo $_SESSION['login_user_id'] ?>" />

			<script>
				function getId(id) {
					$('.modal2').modal('toggle')
					$('.modal-title').html('Call Barge ' + id);
					$("#hidden_ext").val(id);

				}
				function getBargeCall() {
					var barge = $("#barge").val();
					var hidden_ext = $("#hidden_ext").val();

					$.ajax({
						type: "POST",
						url: "bargeAjax.php",
						data: { barge: barge, hidden_ext: hidden_ext },
						success: function (value) {
							$("#data").html(value);
						}
					});
					$("#myModal").modal('hide');
				}
				<?php if ($_SESSION['userroleforpage'] == 2) { ?>
					var user_id = $("#user_id").val();
					// alert(user_id);
					setInterval(function () {
						$.ajax({
							url: "ajaxnotificationCount.php",
							type: "POST",
							dataType: 'json',
							data: {
								user_id: user_id
							},
							success: function (response) {
								const {
									doc_status,
									total_count,
									session
								} = response;
								if (doc_status == false) {
									$("#uploadSuccessModal").modal('hide');
								}
								if (session == "Expired") {
									$("#sessionExpiredModal").modal('show');
									//window.location.href='logout.php';
								}
								$("#notification").text(total_count);
							}
						});
					}, 50000);
				<?php } else { ?>
					$(window).load(function () {
						notificationCount();
					});

					function notificationCount() {
						$.ajax({
							url: "ajaxnotificationCount.php",
							type: "POST",
							dataType: 'json',
							// data : {user_id : user_id},
							success: function (response) {
								const {
									doc_status,
									total_count,
									session
								} = response;
								if (doc_status == true) {
									$("#uploadSuccessModal").modal('show');
								} else {
									$("#uploadSuccessModal").modal('hide');
								}
								if (session == "Expired") {
									$("#sessionExpiredModal").modal('show');
									//window.location.href='logout.php';
								}
								$("#notification").text(total_count);
							}
						});
					}


					setInterval(notificationCount, 30000);
				<?php } ?>



			</script>
			<div class="modal fade" id="uploadSuccessModal" tabindex="-1" role="dialog"
				aria-labelledby="uploadSuccessModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background:black;">
						<div class="modal-body">
							<h2 style="font-size:22px;color: white;font-weight: bold;">Someone has uploaded their
								documents, please approve
								them.</h2>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="btnok" data-dismiss="modal"
								style="color: white; font-size: 18px;">Ok</button>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="sessionExpiredModal" tabindex="-1" role="dialog"
				aria-labelledby="sessionExpiredModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="background:black;">
						<div class="modal-body">
							<h2 style="font-size:22px;color: white;font-weight: bold;">Your Session has been Expired!
							</h2>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" id="sessionBtn" data-dismiss="modal"
								style="color: white; font-size: 18px;">Ok</button>
						</div>
					</div>
				</div>
			</div>

			<script>
				$(document).ready(function () {
					$('#btnok').click(function () {
						$.ajax({
							url: "ajaxnotification_status.php",
							type: "POST",
							success: function (data) {
								if (data) {
									console.log("Upload Document state changed");
								}
							}
						});
					});

					$('#sessionBtn').click(function () {
						window.location.href = 'logout.php';
					});
				});
			</script>
			<!-- Notification Modal End -->
			<!--// modal for ring Barge  -->

			<div id="myModal1" class="modal modal1" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<?php if (isset($_SESSION['id'])) {
								echo $_SESSION['id'];
							} ?>
							<h5 class="modal-title_ring"></h5>
							<h2>check barge</h2>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<form name="" method="post">
							<!-- Modal body -->
							<div class="modal-body">
								<select name="barge" id="bargering" class="form-control">
									<option value="">Please Select </option>
									<?php
									$result_barge_ring = mysqli_query($connection, $select_barge);
									while ($rowbargering = mysqli_fetch_array($result_barge_ring)) { ?>

										<option value="<?php echo $rowbargering['name']; ?>">
											<?php echo $rowbargering['name']; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<input type="hidden" id="hidden_ext_ring" name="hidden_ext" value="">
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								<input type="button" value="Confirm" onclick="getBargeCallRing()"
									class="btn btn-primary">
							</div>
						</form>

					</div>
				</div>
			</div>

			<script>

				function getRingId(id) {
					$('.modal1').modal('toggle')
					$('.modal-title_ring').html('Call Barge Ring ' + id);
					$("#hidden_ext_ring").val(id);

				}
				function getBargeCallRing() {
					var barge = $("#bargering").val();
					var hidden_ext = $("#hidden_ext_ring").val();

					$.ajax({
						type: "POST",
						url: "bargeAjax.php",
						data: { barge: barge, hidden_ext: hidden_ext },

						success: function (value) {
							$("#data").html(value);
						}
					});
					$("#myModal1").modal('hide');
				}
			</script>

			<?php if ($_SESSION['userroleforpage'] != 1) { ?>
				<script>
					function fetchBalance() {
						user_id = <?php echo $_SESSION['login_user_id']; ?>;
						$.ajax({
							url: 'ajaxbal.php',
							type: 'post',
							dataType: 'json',
							data: { user_id: user_id },
							success: function (response) {
								const { status, value, message } = response;
								// alert(value);
								if (status == 'false') {
									window.location.href = 'logout.php';
								} else {
									$('#userBalance').text(value);
								}
							}
						});
					}
					fetchBalance();
					setInterval(fetchBalance, 50 * 1000);
				</script>
			<?php } ?>



			<!--// end modal for ring barge   -->


			<!--// Start modal for queueMemberAjaxupdate   -->

			<div id="myModalQueue" class="modal modal_queue">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title_queuemember text-center"></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<form name="" method="post">

							<div class="modal-body " style="margin:20px 0px;">
								<div class="row form-group">
									<div class="col-md-4">
										<label for="text-input" class=" form-control-label"
											style="color:black;line-height:30px;margin-left: 10px;">Queue</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="queue_name" name="queue_name" value="" class="form-control"
											type="text" readonly>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-4">
										<label for="text-input" class=" form-control-label"
											style="color:black;line-height:30px;margin-left: 10px;">Extension No</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="membername" name="membername" value="" class="form-control"
											type="text" readonly>
									</div>
								</div>
								<div class="row form-group">
									<div class=" col-md-4">
										<label for="text-input" class=" form-control-label"
											style="color:black;line-height:30px;margin-left: 10px;">Penalty</label>
									</div>
									<div class="col-12 col-md-8">
										<input id="penalty" name="penalty" value="" class="form-control" type="text">
									</div>
								</div>

								<input type="hidden" id="hidden_queue_member" name="hidden_queue_member" value="">

							</div>
							<?php // }   ?>
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								<input type="button" value="Confirm" onclick="updateQueueManage()"
									class="btn btn-primary">
							</div>
						</form>


					</div>
				</div>
			</div>

			<script>

				function getModel(id) {
					$('.modal_queue').modal('toggle');
					$('.modal-title_queuemember').html('Queue Member Extension Edit ' + id);
					$("#hidden_queue_member").val(id);
					var uniqueid = id;
					$.ajax({
						type: "POST",
						url: "queueMemberAjaxfetch.php",
						data: { uniqueid: uniqueid },
						dataType: "json",
						success: function (data) {
							// alert(data);
							$('#queue_name').val(data.queue_name);
							$('#membername').val(data.membername);
							$('#penalty').val(data.penalty);

						}
					});
				}
				function updateQueueManage() {
					var queue_name = $("#queue_name").val();
					var membername = $("#membername").val();
					var penalty = $("#penalty").val();
					var uniqueIdD = $("#hidden_queue_member").val();
					console.log(uniqueIdD);
					$.ajax({
						type: "POST",
						url: "queueMemberAjaxupdate.php",
						data: { uniqueid: uniqueIdD, penalty: penalty },

						success: function (value) {
							$("#updateQueue").html(value);
							// $('#queueMemberTable').load('#queueMemberTable');
							$(".agent_table_outer").load(window.location + " .agent_table_outer");
							// alert('Reloaded');
						}
					});
					$("#myModalQueue").modal('hide');
				}
			</script>

			<!--// end modal for queueMemberAjaxupdate   -->