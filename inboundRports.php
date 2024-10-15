<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    /* Style for the dropdown container */
    .custom-dropdown {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    /* Dropdown content (hidden by default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 100%;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Individual options in the dropdown */
    .dropdown-content div {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        display: block;
        cursor: pointer;
    }

    /* Hover effect */
    .dropdown-content div:hover {
        background-color: #f1f1f1;
    }

    .extension-content  {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 100%;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Individual options in the dropdown */
    .extension-content div {
        color: black;
        padding: 8px 16px;
        text-decoration: none;
        display: block;
        cursor: pointer;
    }

    /* Hover effect */
    .extension-content div:hover {
        background-color: #f1f1f1;
    }

    /* Show the dropdown when clicked */
    .show {
        display: block;
    }

	.custom-dropdown {
    position: relative;
}

.destination-content {
	display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 100%;
        max-height: 200px;
        overflow-y: auto;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
}

.destination-content div {
	color: black;
        padding: 8px 16px;
        text-decoration: none;
        display: block;
        cursor: pointer;
}

.destination-content div:hover {
    background-color: #f1f1f1;
}

.show {
    display: block;
}


    </style>
</head>

<body>
</body>

</html>


<?php
require_once('header.php');
$user_query = "select timezone from users_login where id = '" . $_SESSION['login_user_id'] . "'";
$user_res = mysqli_query($connection, $user_query) or die("query failed : user_query");
$rows = mysqli_fetch_assoc($user_res);
$userTimezone = $rows['timezone'];

$selectedMonth = isset($_GET['month']) ? $_GET['month'] : '';

$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$fromTime = isset($_GET['fromTime']) ? $_GET['fromTime'] : '';

$fromdates = $fromDate . ' ' . $fromTime;
$cfromDate = new DateTime($fromdates, new DateTimeZone($userTimezone));
$cfromDate->setTimezone(new DateTimeZone('America/New_York'));
$fromNewDate = $cfromDate->format('Y-m-d H:i:s');

$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';
$toTime = isset($_GET['toTime']) ? $_GET['toTime'] : '';

$todates = $toDate . ' ' . $toTime;
$cToDate = new DateTime($todates, new DateTimeZone($userTimezone));
$cToDate->setTimezone(new DateTimeZone('America/New_York'));
$toNewDate = $cToDate->format('Y-m-d H:i:s');

if(isset($_GET['month']) && $_GET['month']!=''){
$tableName = $_GET['month'];
}else{
	$tableName = 'cc_cdr';
}

if (isset($_GET['disposition']) && strlen($_GET['disposition']) > 0) {
	if ($_GET['disposition'] == 'ANSWER') {
		$disposition = 'and cc_cdr.answertime != ""';
	} elseif ($_GET['disposition'] == 'MISSED CALL') {
		$disposition = 'and cc_cdr.answertime = ""';
	} else {
		$disposition = '';
	}
} else {
	$disposition = '';
}

$queueNames = isset($_GET['queueName']) ? $_GET['queueName'] : '';
if (strlen($queueNames) > 0) {
	$queueNames = "and cc_cdr.destination='" . $queueNames . "'";
} else {
	$queueNames = '';
}

$extensions = isset($_GET['extension']) ? $_GET['extension'] : '';
if (strlen($extensions) > 0) {
	$extensions = "and cc_cdr.agent='" . $extensions . "'";
} else {
	$extensions = '';
}

$DIDSS = isset($_GET['DID']) ? $_GET['DID'] : '';
if (strlen($DIDSS) > 0) {
	$DIDSS = "and cc_cdr.dst='" . $DIDSS . "'";
} else {
	$DIDSS = '';
}

$CLID = isset($_GET['CLID']) ? $_GET['CLID'] : '';

if (strlen($CLID) > 0) {

	$CLID = "and cc_cdr.caller_num LIKE '%" . $CLID . "%'";
} else {
	$CLID = '';
}

$extentionnumber = $_SESSION['login_user'];
function seconds2human($ss)
{
	$s = $ss % 60;
	$m = floor(($ss % 3600) / 60);
	$h = floor(($ss % 86400) / 3600);
	$d = floor(($ss % 2592000) / 86400);
	$M = floor($ss / 2592000);
	if ($h == 0) {
		$h = '';
	} else {
		$h = $h . ':';
	}
	return "$h$m:$s";
}

if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
	$page_no = $_GET['page_no'];
} else {
	$page_no = 1;
}
$total_no_of_pages = 1;
if (isset($_GET['submit'])) {


	$total_records_per_page = 50;
	$offset = ($page_no - 1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";
	if ($_SESSION['userroleforpage'] == 1) {
		$query_cdr_pagination = "SELECT count(cc_cdr.id) FROM $tableName as cc_cdr where cc_cdr.calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . " " . $CLID . "";
	} else {
		$query_cdr_pagination = "SELECT count(cc_cdr.id) FROM $tableName as cc_cdr where cc_cdr.calldate between '" . $fromNewDate . "' and '" . $toNewDate . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . " " . $CLID . " and cc_cdr.account_code='" . $_SESSION['login_usernames'] . "' ";
	}
	//echo $query_cdr_pagination;
	$result_queue_cdr_pagination = mysqli_query($connection, $query_cdr_pagination);

	$row_pagins = mysqli_fetch_row($result_queue_cdr_pagination);
	$total_pagins_records = $row_pagins[0];
	$total_no_of_pages = ceil($total_pagins_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;
	if ($_SESSION['userroleforpage'] == 1) {

		$query_cdr = "SELECT cc_cdr.* FROM $tableName as cc_cdr WHERE cc_cdr.calldate BETWEEN '$fromNewDate' AND '$toNewDate' $disposition $queueNames $extensions $DIDSS $CLID ORDER BY cc_cdr.id DESC LIMIT $offset, $total_records_per_page";

	} else {

		$query_cdr = "SELECT cc_cdr.* FROM $tableName as cc_cdr WHERE cc_cdr.calldate BETWEEN '$fromNewDate' AND '$toNewDate' $disposition $queueNames $extensions $DIDSS $CLID AND cc_cdr.account_code='" . $_SESSION['login_usernames'] . "' ORDER BY cc_cdr.id DESC LIMIT $offset, $total_records_per_page";

	}
	
	$result_queue_cdr = mysqli_query($connection, $query_cdr);

	$urlcode = 'month=' . $selectedMonth . '&fromDate=' . $fromDate . '&fromTime=' . $fromTime . '&toDate=' . $toDate . '&toTime=' . $toTime . '&submit=' . $_GET['submit'] . '&showRecords=' . $_GET['showRecords'] . '&pageNumber=' . $_GET['pageNumber'] . '&extension=' . $_GET['extension'] . '&queueName=' . $_GET['queueName'] . '&DID=' . $_GET['DID'] . '&CLID=' . $_GET['CLID'] . '&disposition=' . $_GET['disposition'];

}
//  echo $tableName;die('jhg');
if ($_SESSION['userroleforpage'] == 1) {
	$query_queue = "select distinct(destination) from ". $tableName." WHERE destination!=''";	
} else {
	$query_queue = "select distinct(destination) from  ".$tableName." WHERE user_id = '" . $_SESSION['login_user_id'] . "' and destination!=''";
}
$result_queue = mysqli_query($connection, $query_queue);

if ($_SESSION['userroleforpage'] == 1) {
	$query_extension = "select * from cc_sip_buddies where agent_name!='' order by agent_name asc";
} else {
	$query_extension = "select * from cc_sip_buddies where accountcode =" . $_SESSION['login_usernames'] . " and agent_name!='' order by agent_name asc";
}
$extenion_result = mysqli_query($connection, $query_extension);

if ($_SESSION['userroleforpage'] == 1) {
	$query_did = "select * from cc_did";
} else {
	$query_did = "select * from cc_did WHERE iduser='" . $_SESSION['login_user_id'] . "'";
}
$did_result = mysqli_query($connection, $query_did);

?>


<div class="main-content">
    <div class="section__content section__content--p30 page_mid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap">
                        <h2 class="title-1"> Inbound Reports </h2>
                        <?php 
						?>
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
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Month</label>
                                            <select id="month" name="month" class="form-control">
                                                <option value="cc_cdr" <?php if (!isset($_GET['month']) || $_GET['month'] == 'cc_cdr')
													echo 'selected'; ?>>Aug -
                                                    <?php echo date('M'); ?>
                                                </option>
                                                <option value="cc_cdr_22072024" <?php if (isset($_GET['month']) && $_GET['month'] == 'cc_cdr_22072024')
													echo 'selected'; ?>>
                                                    Feb - Jul
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
                                            <input id="fromDate" name="fromDate" class="form-control hasDatepicker"
                                                type="date" step="1" value="<?php if (isset($_GET['fromDate'])) {
													echo $_GET['fromDate'];
												} else {
													echo date('Y-m-d');
												} ?>">

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">From Time*</label>
                                            <input id="fromTime" name="fromTime" class="form-control" type="time"
                                                step="1" value="00:00:00">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
                                            <input id="toDate" name="toDate" class="form-control hasDatepicker"
                                                type="date" value="<?php if (isset($_GET['toDate'])) {
													echo $_GET['toDate'];
												} else {
													echo date('Y-m-d');
												} ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">To Time*</label>
                                            <input id="toTime" name="toTime" class="form-control" type="time" step="1"
                                                value="23:59:59">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Disposition</label>
                                            <select id="disposition" name="disposition"
                                                class="form-control selectpicker" data-live-search="true">
                                                <option <?php if (isset($_GET['disposition']) && $_GET['disposition'] == '') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="">All</option>
                                                <option <?php if (isset($_GET['disposition']) && $_GET['disposition'] == 'ANSWER') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="ANSWER">ANSWERED</option>
                                                <option <?php if (isset($_GET['disposition']) && $_GET['disposition'] == 'MISSED CALL') {
													echo 'selected="selected"';
												} else {
													echo '';
												} ?> value="MISSED CALL">MISSED CALL</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="searchDestination" class="form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Destination</label>

												<div class="custom-dropdown">
                                                <!-- Search Input inside Dropdown -->
                                                <input type="text" id="searchDestination"
                                                    onkeyup="filterDestinationDropdown()" placeholder="Search..."
                                                    class="form-control mb-2 search-input"
                                                    onclick="toggleDestinationDropdown()">

                                                <!-- Custom Dropdown Options -->
                                                <div id="dropdownDestinationOptions" class="destination-content">
                                                    <div onclick="selectDestinationOption(this)" data-value="">All</div>
                                                    <?php while ($queuerowid = mysqli_fetch_array($result_queue)) { ?>
                                                    <div onclick="selectDestinationOption(this)"
                                                        data-value="<?php echo trim($queuerowid['destination']); ?>">
                                                        <?php echo trim($queuerowid['destination']); ?>
                                                    </div>
													
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <!-- Hidden input to hold selected value -->
                                            <input type="hidden" id="selectedDestination" name="queueName">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="searchExtension" class="form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Extension</label>
                                            <div class="custom-dropdown">
                                                <!-- Search Input inside Dropdown -->
                                                <input type="text" id="searchExtension"
                                                    onkeyup="filterExtensionDropdown()" placeholder="Search..."
                                                    class="form-control mb-2 search-input"
                                                    onclick="toggleExtensionDropdown()">

                                                <!-- Custom Dropdown Options -->
                                                <div id="dropdownExtensionOptions" class="extension-content">
                                                    <div onclick="selectExtensionOption(this)" data-value="">All</div>
                                                    <?php while ($extrow = mysqli_fetch_array($extenion_result)) { ?>
                                                    <div onclick="selectExtensionOption(this)"
                                                        data-value="<?php echo $extrow['name']; ?>">
                                                        <?php echo $extrow['name']; ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <!-- Hidden input to hold selected value -->
                                            <input type="hidden" id="selectedExtension" name="extension">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class="form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">DID/TFN</label>
                                            <div class="custom-dropdown">
                                                <!-- Search Input inside Dropdown -->
                                                <input type="text" id="searchDID" onkeyup="filterDropdown()"
                                                    placeholder="Search..." class="form-control mb-2 search-input"
                                                    onclick="toggleDropdown()">

                                                <!-- Custom Dropdown Options -->
                                                <div id="dropdownOptions" class="dropdown-content">
                                                    <div onclick="selectOption(this)" data-value="">All</div>
                                                    <?php while ($rowtfns = mysqli_fetch_array($did_result)) { ?>
                                                    <div onclick="selectOption(this)"
                                                        data-value="<?php echo $rowtfns['did']; ?>">
                                                        <?php echo $rowtfns['did']; ?>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>

                                            <!-- Hidden input to hold selected value -->
                                            <input type="hidden" id="DID" name="DID">
                                        </div>
                                    </div>


                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" class=" form-control-label"
                                                style="color:black;margin-left:0px;font-weight:bold;">Caller ID</label>
                                            <input id="CLID" name="CLID" class="form-control" type="text"
                                                value="<?php echo isset($_GET['CLID']) ? $_GET['CLID'] : ''; ?>">
                                        </div>
                                    </div>




                                    <div class="col-md-3" style="float:right;">
                                        <div class="form-group" style="float:right;">
                                            <button type="submit" style="margin-top: 38px;" name="submit" value="submit"
                                                class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </div>
                                    <p></p>
                                </div>
                                <input id="showRecords" name="showRecords" type="hidden" value="10">
                                <input id="pageNumber" name="pageNumber" type="hidden" value="1">
                            </form>
                            <?php if (isset($_GET['submit']) && mysqli_num_rows($result_queue_cdr) > 0) { ?>
                            <hr>
                            <div class="form-group row">
                                <div class="col-sm-9">
                                    <h3>To Download the Inbound Report Click The Download CSV Button</h3>
                                </div>
                                <div class="col-sm-3"><button type="submit" id="export" name="export" value="submit"
                                        class="btn btn-primary btn-sm"
                                        style="font-size:22px;line-height: 32px;margin-top: 12px;">Download CSV</button>
                                </div>
                            </div>
                            <?php } else {
								echo ''; ?>

                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="overview-wrap custom_show">
                        &nbsp;
                    </div>
                    <div
                        class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate report_claasic_tble">
                        <table id="queueTable" class="table manage_queue_table">
                            <thead>

                                <tr>
                                    <th>Serial No</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>CID</th>
                                    <th>DID / TFN</th>
                                    <th>Destination</th>
                                    <th>Extension</th>
                                    <th>Agent</th>
                                    <th>Total Duration</th>
                                    <th>Ring Duration</th>
                                    <th>Talk Duration</th>
                                    <th>Cost</th>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                    <th>Origination IP</th>
                                    <?php } ?>
                                    <th>Recordings</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
								if (isset($_GET['submit'])) {
									if (mysqli_num_rows($result_queue_cdr) > 0) {
										$i = 1;
										while ($row_cdr = mysqli_fetch_array($result_queue_cdr)) {
											if ($_SESSION['userroleforpage'] !== '1') {
												$newDate = timezone($row_cdr['calldate']);
											} else {
												$newDate = $row_cdr['calldate'];
											}

											?>
                                <tr class="tr-shadow">
                                    <td>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php echo $newDate; ?>
                                    </td>
                                    <td>
                                        <?php
													if (strtoupper($row_cdr['disposition']) == 'CHANUNAVAIL') {
														echo 'UNAVAILABLE';
													} else {
														echo $row_cdr['disposition'];
													}
													?>
                                    </td>
                                    <td>
                                        <?php echo $row_cdr['caller_num']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_cdr['DID']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_cdr['context'] . '<br><' . $row_cdr['destination'] . '>'; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_cdr['agent']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row_cdr['agent_name']; ?>
                                    </td>
                                    <td>
                                        <?php

													if (strtoupper($row_cdr['disposition']) == 'ANSWER') {
														$rr = strtotime($row_cdr['answertime']) - strtotime($row_cdr['ccallstarttime']);
														$ringTime = $rr;
													} else {
														$ringTime = $row_cdr['duration'];
													}

													if (strtoupper($row_cdr['disposition']) != 'ANSWER' || $ringTime > $row_cdr['billsec']) {
														$totalTime = $row_cdr['billsec'] + $ringTime;
													} else {
														$totalTime = $row_cdr['billsec'];
													}
													echo seconds2human($totalTime);
													?>
                                    </td>
                                    <td>
                                        <?php
													echo seconds2human($ringTime);
													?>
                                    </td>
                                    <td>
                                        <?php
													if (strtoupper($row_cdr['disposition']) == 'ANSWER' && $ringTime < $row_cdr['billsec']) {
														$talktime = $row_cdr['billsec'] - $ringTime;
													} else {
														$talktime = $row_cdr['billsec'];
													}
													echo seconds2human($talktime); ?>
                                    </td>

                                    <td>
                                        <?php echo $row_cdr['cost']; ?>
                                    </td>
                                    <?php if ($_SESSION['userroleforpage'] == 1) { ?>
                                    <td>
                                        <?php echo $row_cdr['recvip']; ?>
                                    </td>
                                    <?php } ?>
                                    <td><audio controls="controls" class="play-btn">
                                            <source type="audio/x-wav" src="<?php echo RECORDINGS . date('Y-m-d', strtotime($row_cdr['calldate'])); ?>/<?php if ($row_cdr['disposition'] == 'ANSWER') {
																  echo $row_cdr['Recording'];
															  } else {
																  echo '';
															  } ?>" />
                                        </audio></td>
                                    <td>
                                        <!-- New Action Column -->
                                        <a href="<?php echo RECORDINGS . date('Y-m-d', strtotime($row_cdr['calldate'])); ?>/<?php if ($row_cdr['disposition'] == 'ANSWER') {
															  echo $row_cdr['Recording'];
														  } else {
															  echo '';
														  } ?>" download="true" target="_blank">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    </td>

                                </tr>
                                <?php $i++;
										}
									}
								} else { ?>

                                <tr>
                                    <td colspan="11" style="color:red;font-size:20px;">No data found </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
                        <strong>Showing
                            <?php echo $page_no . " of " . $total_no_of_pages; ?>
                        </strong>
                    </div>

                    <ul class="pagination">
                        <?php if ($page_no > 1) {
							echo "<li><a href='?$urlcode&page_no=1'>First Page</a></li>";
						} ?>

                        <li <?php if ($page_no <= 1) {
							echo "class='disabled'";
						} ?>>
                            <a <?php if ($page_no > 1) {
								echo "href='?$urlcode&page_no=$previous_page'";
							} ?>>Previous</a>
                        </li>

                        <?php
						if ($total_no_of_pages <= 10) {
							for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
								if ($counter == $page_no) {
									echo "<li class='active'><a>$counter</a></li>";
								} else {
									echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
								}
							}
						} elseif ($total_no_of_pages > 10) {

							if ($page_no <= 4) {
								for ($counter = 1; $counter < 8; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
								echo "<li><a>...</a></li>";
								echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
								echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
								echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
								echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
								echo "<li><a>...</a></li>";
								for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
								echo "<li><a>...</a></li>";
								echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
								echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							} else {
								echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
								echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
								echo "<li><a>...</a></li>";

								for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
							}
						}
						?>

                        <li <?php if ($page_no >= $total_no_of_pages) {
							echo "class='disabled'";
						} ?>>
                            <a <?php if ($page_no < $total_no_of_pages) {
								echo "href='?$urlcode&page_no=$next_page'";
							} ?>>Next</a>
                        </li>
                        <?php if ($page_no < $total_no_of_pages) {
							echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
						} ?>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#export').click(function(event) {
        event.preventDefault();
        var formData = $('#classicReportForm').serialize();
        $.ajax({
            url: 'inboundReportdownload.php',
            method: 'GET',
            data: formData,
            success: function(response) {
                var downloadLink = document.createElement('a');
                downloadLink.href = 'inboundReportdownload.php?' + formData;
                downloadLink.download = 'inbound_report.csv';
                downloadLink.click();
            }
        });
    });
});
</script>



<?php require_once('footer.php'); ?>
<script>
// Toggle dropdown visibility
function toggleDropdown() {
    document.getElementById("dropdownOptions").classList.toggle("show");
}

// Filter dropdown options based on input
function filterDropdown() {
    var input = document.getElementById("searchDID");
    var filter = input.value.toUpperCase();
    var div = document.getElementById("dropdownOptions").getElementsByTagName("div");

    for (var i = 0; i < div.length; i++) {
        var txtValue = div[i].textContent || div[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            div[i].style.display = "";
        } else {
            div[i].style.display = "none";
        }
    }
}

// Select an option and set the value
function selectOption(element) {
    var value = element.getAttribute("data-value");
    var searchDID = document.getElementById("searchDID");
    var didHiddenInput = document.getElementById("DID");

    // Set the selected value and the display text
    searchDID.value = element.innerText;
    didHiddenInput.value = value;

    // Close dropdown after selecting
    document.getElementById("dropdownOptions").classList.remove("show");
}
// Clear the input and reset the value
document.getElementById("searchDID").addEventListener('input', function() {
    if (this.value === "") {
        // If input is cleared, make sure the hidden input is cleared as well
        document.getElementById("DID").value = "";
    }
});
// Set initial value from PHP if it exists
var dd = <?php echo json_encode($_GET['DID'] ?? ''); ?>;

document.getElementById("searchDID").value = dd;
document.getElementById("DID").value = dd; // Update the hidden input

// Close dropdown if clicked outside
window.onclick = function(event) {
    if (!event.target.matches('#searchDID')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
//extensiosn

// Toggle dropdown visibility for Extension
function toggleExtensionDropdown() {
    document.getElementById("dropdownExtensionOptions").classList.toggle("show");
}

// Filter dropdown options based on input for Extension
function filterExtensionDropdown() {
    var input = document.getElementById("searchExtension");
    var filter = input.value.toUpperCase();
    var div = document.getElementById("dropdownExtensionOptions").getElementsByTagName("div");

    for (var i = 0; i < div.length; i++) {
        var txtValue = div[i].textContent || div[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            div[i].style.display = "";
        } else {
            div[i].style.display = "none";
        }
    }
}

// Select an option and set the value for Extension
function selectExtensionOption(element) {
    var value = element.getAttribute("data-value");
    var searchExtension = document.getElementById("searchExtension");
    var extensionHiddenInput = document.getElementById("selectedExtension");

    // Set the selected value and the display text
    searchExtension.value = element.innerText;
    extensionHiddenInput.value = value;

    // Close dropdown after selecting
    document.getElementById("dropdownExtensionOptions").classList.remove("show");
}

// Clear the input and reset the value for Extension
document.getElementById("searchExtension").addEventListener('input', function() {
    if (this.value === "") {
        // If input is cleared, make sure the hidden input is cleared as well
        document.getElementById("selectedExtension").value = "";
    }
});

// Set initial value from PHP if it exists for Extension
var selectedExtension = <?php echo json_encode($_GET['extension'] ?? ''); ?>;
document.getElementById("searchExtension").value = selectedExtension;
document.getElementById("selectedExtension").value = selectedExtension; // Update the hidden input

// Close dropdown if clicked outside for Extension
window.onclick = function(event) {
    if (!event.target.matches('#searchExtension')) {
        var dropdowns = document.getElementsByClassName("extension-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

function toggleDestinationDropdown() {
    document.getElementById("dropdownDestinationOptions").classList.toggle("show");
}

function filterDestinationDropdown() {
    var input, filter, div, option, i;
    input = document.getElementById("searchDestination");
    filter = input.value.toUpperCase();
    div = document.getElementById("dropdownDestinationOptions");
    option = div.getElementsByTagName("div");
    for (i = 0; i < option.length; i++) {
        if (option[i].innerText.toUpperCase().indexOf(filter) > -1) {
            option[i].style.display = "";
        } else {
            option[i].style.display = "none";
        }
    }
}
var selectedDestination = <?php echo json_encode($_GET['queueName'] ?? ''); ?>;
document.getElementById("searchDestination").value = selectedDestination;
document.getElementById("selectedDestination").value = selectedDestination;

document.getElementById("searchDestination").addEventListener('input', function() {
    if (this.value === "") {
        document.getElementById("selectedDestination").value = "";
    }
});

function selectDestinationOption(element) {
    var value = element.getAttribute("data-value");
    document.getElementById("selectedDestination").value = value;
    document.getElementById("searchDestination").value = element.innerText;
    document.getElementById("dropdownDestinationOptions").classList.remove("show");
}

</script>