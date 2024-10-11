<?php
include 'connection.php';

$sql = "SELECT e.name as ext_name,e.host,DATE(e.expirationdate),u.name as username,u.email,c.clientName FROM cc_sip_buddies e LEFT JOIN  users_login u ON e.user_id=u.id LEFT JOIN  Client c ON e.id_cc_card=c.clientId";
$query = mysqli_query($connection, $sql) or die("queryfailed");

if (mysqli_num_rows($query) > 0) {
    $delimiting = ",";
    $filename = 'extension_csv' . '_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    $output = fopen('php://output', 'w');

    $fields = array('Serial No', 'Extension', 'User','Email', 'Company', 'Expiration Date', 'Status');
    fputcsv($output, $fields, $delimiting);
    $i = 1;

    while($row = mysqli_fetch_assoc($query)) {
        $ext = $row['ext_name'];
        $user = $row['username'];
        $email = $row['email'];
        $client = $row['clientName'];
        $date = $row['DATE(e.expirationdate)'];
        $status = ($row['host'] === 'static') ? 'Inactive' : 'Active';

        $lineData = array(
            $i,
            $ext,
            $user,
            $email,
            $client,
            $date,
            $status
           
        );
        fputcsv($output, $lineData, $delimiting);
        $i++;
    }
    fclose($output);
    exit;
} else {
    echo "No data found ";
    exit;
}