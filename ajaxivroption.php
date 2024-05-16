<?php
require_once('connection.php');

$uid = $_POST['id'];

$sql = "SELECT * FROM `ivr_option` INNER JOIN `cc_selection_did` ON ivr_option.ivr_dest_type=cc_selection_did.id WHERE `ivr_id` = '" . $uid . "'";

$result = mysqli_query($connection, $sql) or die("query failed : sql");
$output = '';
if (mysqli_num_rows($result) > 0) {
    $output .= "<table border='1' width='100%' class='display dataTable table manage_queue_table' cellspacing='0' cellpadding='10px'>
    <thead>
        <th>Input Digit</th>
        <th>Destination Type</th>
        <th>Destination Number</th>
    </thead>";
    while ($rows = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
        <td>{$rows["input_digit"]}</td>
        <td>{$rows["selection_value"]}</td>
        <td>{$rows["ivr_dest_no"]}</td>
        </tr>";
    }
    $output .= "</table>";
    echo $output;
}
?>