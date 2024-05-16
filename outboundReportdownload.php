<?php
include 'connection.php';
include 'functions.php';


$TCarray = array('1' => 'ANSWERED', '2' => 'BUSY', '3' => 'NO ANSWER', '4' => 'CANCEL', '5' => 'CONGESTION', '6' => 'CHANUNAVAIL');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$fromDate = $_GET['fromDate'];
$fromTime = $_GET['fromTime'];
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
    return "$h$m:$s";
}

if (isset ($_GET['disposition']) && strlen($_GET['disposition']) > 0) {
    $disposition = 'and disposition = "' . $_GET['disposition'] . '"';
} else {
    $disposition = '';
}

if (isset ($_GET['destination']) && strlen($_GET['destination']) > 0) {
    $destination = "and destination='" . $destination . "'";
} else {
    $destination = '';
}

$user = '';
if (isset ($_GET['user']) && strlen($_GET['user']) > 0) {
    $user = "and accountcode='" . $user . "'";
}

if (isset ($_GET['phno']) && strlen($_GET['phno']) > 0) {
    $phno = "and dst='" . $phno . "'";
} else {
    $phno = '';
}
if ($_SESSION['userroleforpage'] == 1) {
    $query_user = "SELECT * FROM `users_login` where 1 order by name asc";
    $user_result = mysqli_query($connection, $query_user);
    while ($user_row = mysqli_fetch_array($user_result)) {
        $user_array[$user_row['id']] = $user_row['name'];
    }
}

$query_destination = "SELECT * FROM `cc_country`";
$result_destination = mysqli_query($connection, $query_destination);
while ($country = mysqli_fetch_array($result_destination)) {
    if ($country['countryprefix'] > 0) {
        $destination_arr[$country['countryprefix']] = $country['countryname'];
    }
}

if ($_SESSION['userroleforpage'] == 1) {
    $query_cdr = "SELECT * FROM `CDR` where calldate between '" . $fromdates . "' and '" . $todates . "' " . $disposition . " " . $destination . " " . $user . " " . $phno . "  order by calldate DESC";
} else {
    $query_cdr = "SELECT * FROM `CDR` where calldate between '" . $fromdates . "' and '" . $todates . "' " . $disposition . " " . $destination . " " . $user . " " . $phno . " and accountcode='" . $_SESSION['login_user_id'] . "' order by calldate DESC";
}

$result_queue_cdr = mysqli_query($connection, $query_cdr);

if (mysqli_num_rows($result_queue_cdr) > 0) {
    $delimiting = ",";
    $filename = 'outbound_report' . '_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    $output = fopen('php://output', 'w');
    if ($_SESSION['userroleforpage'] == 1) {
        // $account = 'Account';
        $trunk = 'Trunk';
        $agent = 'Agent';
    } else {
        // $account = '';
        $trunk = '';
        $agent = '';
    }
    $fields = array('Serial No', 'Date', 'Caller ID', 'Phone No.', 'Country', 'Disposition', 'Duration', 'Cost', 'Codec', 'Recording', $trunk, $agent);
    fputcsv($output, $fields, $delimiting);
    $i = 1;
    while ($row_cdr = mysqli_fetch_assoc($result_queue_cdr)) {
        $disposition = $row_cdr['disposition'];
        $agent = isset ($user_array[$row_cdr['accountcode']]) ? $user_array[$row_cdr['accountcode']] : '';
        $newDate = timezone($row_cdr['calldate']);
        if ($row_cdr['disposition'] == 'ANSWERED') {
            $recording_file = "https://portal-myphonesystems-recordings.s3.ap-south-1.amazonaws.com/" . date('Y-m-d', strtotime($row_cdr['calldate'])) . '/' . $row_cdr['recordingfile'];
            $recordings_hyperlink = '=HYPERLINK("' . $recording_file . '","Recording Download")';
        } else {
            $recordings_hyperlink = "No Record";
        }
        if ($_SESSION['userroleforpage'] == 1) {
            $user_name = isset ($user_array[$row_cdr['accountcode']]) ? $user_array[$row_cdr['accountcode']] : '';
            /* $query_trunk = "SELECT trunkcode FROM `cc_trunk` where id_trunk='" . $row_cdr['id_trunk'] . "'";
            $result_trunk = mysqli_query($connection, $query_trunk);
            $trunk_row = mysqli_fetch_array($result_trunk);
            $trunk = $trunk_row['trunkcode']; */
            $trunk = $row_cdr['trunkip'];
        } else {
            $user_name = '';
            $trunk = '';
        }

        $dest_src = isset ($row_cdr['destination']) ? $row_cdr['destination'] : '0';

        if ($row_cdr['BILLING'] > 0) {
            $cost = $row_cdr['BILLING'];
        } else {
            $cost = '0.00';
        }

        $lineData = array(
            $i,
            $newDate,
            $row_cdr['clid'],
            $row_cdr['dst'],
            $row_cdr['userfield'],
            $disposition,
            seconds2human($row_cdr['billsec']),
            $cost,
            $row_cdr['codec'],
            $recordings_hyperlink,
            $trunk,
            $agent
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