<?php
include 'connection.php';

$sql = "SELECT d.did,d.did_provider,d.status,DATE(d.expirationdate),u.name,u.email,c.clientName FROM cc_did d INNER JOIN users_login u ON d.iduser=u.id INNER JOIN Client c ON d.clientId=c.clientId";
$query = mysqli_query($connection, $sql) or die("queryfailed");
if (mysqli_num_rows($query) > 0) {
    $delimiting = ",";
    $filename = 'did_csv' . '_' . date('Y-m-d') . '.csv';
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    $output = fopen('php://output', 'w');

    $fields = array('Serial No', 'TFN', 'User Name','Email', 'Company', 'Carrier', 'Status','Expiration Date');
    fputcsv($output, $fields, $delimiting);
    $i = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $tfn = $row['did'];
        $provider = $row['did_provider'];
        $user = $row['name'];
        $email = $row['email'];
        $client = $row['clientName'];
        $status = $row['status'];
        $date = $row['DATE(d.expirationdate)'];

        $lineData = array(
            $i,
            $tfn,
            $user,
            $email,
            $client,
            $provider,
            $status,
            $date
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