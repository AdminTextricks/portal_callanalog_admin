<?php
include 'connection.php';
include 'functions.php';
$fromDate = $_GET['fromDate'];
$fromTime = $_GET['fromTime'];

$table_name = $_GET['month'];
/* if ($Selectedmonth == 'cc_cdr') {
    $table_name = 'cc_cdr';
} else {
    $table_name = 'cc_cdr_22072024';
} */

$fromdates = $fromDate . ' ' . $fromTime;
$toDate = $_GET['toDate'];
$toTime = $_GET['toTime'];
$todates = $toDate . ' ' . $toTime;

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
    return "$h:$m:$s";
}

if (isset($_GET['disposition']) && strlen($_GET['disposition']) > 0) {
    if ($_GET['disposition'] == 'ANSWER') {
        $disposition = 'AND ' . $table_name . '.answertime != ""';
    } elseif ($_GET['disposition'] == 'MISSED CALL') {
        $disposition = 'AND ' . $table_name . '.answertime = ""';
    } else {
        $disposition = '';
    }
} else {
    $disposition = '';
}

$queueNames = isset($_GET['queueName']) ? $_GET['queueName'] : '';
if (strlen($queueNames) > 0) {
    $queueNames = "AND " . $table_name . ".destination='" . $queueNames . "'";
} else {
    $queueNames = '';
}

$extensions = isset($_GET['extension']) ? $_GET['extension'] : '';
if (strlen($extensions) > 0) {
    $extensions = "AND " . $table_name . ".agent='" . $extensions . "'";
} else {
    $extensions = '';
}

$DIDSS = isset($_GET['DID']) ? $_GET['DID'] : '';
if (strlen($DIDSS) > 0) {
    $DIDSS = "AND " . $table_name . ".DID='" . $DIDSS . "'";
} else {
    $DIDSS = '';
}


$CLID = isset($_GET['CLID']) ? $_GET['CLID'] : '';
if (strlen($CLID) > 0) {
    // Use LIKE operator for partial matching
    $CLID = "AND " . $table_name . ".caller_num LIKE '%" . $CLID . "%'";
} else {
    $CLID = '';
}


if ($_SESSION['userroleforpage'] == 1) {
    $query_cdr = "SELECT * FROM `" . $table_name . "` WHERE " . $table_name . ".calldate BETWEEN '" . $fromdates . "' AND '" . $todates . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . " " . $CLID . " ORDER BY " . $table_name . ".id DESC";
} else {
    $query_cdr = "SELECT * FROM `" . $table_name . "` WHERE " . $table_name . ".calldate BETWEEN '" . $fromdates . "' AND '" . $todates . "' " . $disposition . " " . $queueNames . " " . $extensions . " " . $DIDSS . " " . $CLID . " AND " . $table_name . ".account_code='" . $_SESSION['login_usernames'] . "' ORDER BY " . $table_name . ".id DESC";
}

$result_export = mysqli_query($connection, $query_cdr);

if (mysqli_num_rows($result_export) > 0) {
    $delimiting = ",";
    $filename = 'inbound_report_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    $output = fopen('php://output', 'w');
    if ($_SESSION['userroleforpage'] == 1) {
        $orgination_IP = 'Orgination IP';
    } else {
        $orgination_IP = '';
    }
    $fields = array('Serial No', 'Date', 'Status', 'CID', 'DID/TFN', 'Destination Type', 'Destination', 'Extension', 'Agent', 'Duration', 'Cost', 'Recordings', $orgination_IP);
    fputcsv($output, $fields, $delimiting);
    $i = 1;
    while ($row_cdr = mysqli_fetch_assoc($result_export)) {
        $rec_path = $row_cdr['Recording'];
        if ($row_cdr['disposition'] == "ANSWER") {
            $disposition = 'ANSWER';
            $rec_download = "https://portal-myphonesystems-recordings.s3.ap-south-1.amazonaws.com/" . date('Y-m-d', strtotime($row_cdr['calldate'])) . "/" . $rec_path;
        } elseif ($row_cdr['disposition'] == '') {
            $disposition = 'CANCEL';
            $rec_download = "No Record";
        } else {
            $disposition = $row_cdr['disposition'];
            $rec_download = "No Record";
        }

        if ($_SESSION['userroleforpage'] !== '1') {
            $newDate = timezone($row_cdr['calldate']);
        } else {
            $newDate = $row_cdr['calldate'];
        }

        if ($_SESSION['userroleforpage'] == 1) {
            $orgination_IP = $row_cdr['recvip'];
        } else {
            $orgination_IP = '';
        }

        $recordings_hyperlink = '';
        if ($rec_download !== "No Record") {
            $recordings_hyperlink = '=HYPERLINK("' . $rec_download . '", "Recording Download")';
        } else {
            $recordings_hyperlink = "No Record";
        }

        $lineData = array(
            $i,
            $newDate,
            $disposition,
            $row_cdr['caller_num'],
            $row_cdr['DID'],
            $row_cdr['context'],
            $row_cdr['destination'],
            $row_cdr['agent'],
            $row_cdr['agent_name'],
            seconds2human($row_cdr['billsec']),
            $row_cdr['cost'],
            $recordings_hyperlink,
            $orgination_IP
        );
        fputcsv($output, $lineData, $delimiting);
        $i++;
    }

    fclose($output);
    exit;
} else {
    echo "No data found for export";
    exit;
}
?>
