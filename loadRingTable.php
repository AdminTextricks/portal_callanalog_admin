<?php
include 'connection.php';

$query_ringmanage = "select * from cc_ring_group where id='" . $_POST['id'] . "'";
$result_managering = mysqli_query($connection, $query_ringmanage);
$row_manage = mysqli_fetch_array($result_managering);
$ring_number = $row_manage['ringno'];
$ringlist = $row_manage['ringlist'];

$ring_array = array();
if (!empty($ringlist)) {
	$ring_array = explode('-', $ringlist);
}

$response = '';

$response .= '<table class="table manage_queue_table table-bordered"><thead><tr><th>Ring</th><th>Extension No</th><th>Priority</th><th>Action</th></tr></thead><tbody id="queueMemberTable">';
if (count($ring_array) > 0) {
    foreach ($ring_array as $key => $row_member) {
        $response .= '<tr class="tr-shadow" id="' . $ring_number.'"';
        $response .= '> <td class="desc">' . $ring_number;
        $response .= '</td><td>' . $row_member;
        $response .= '</td><td class="numbersOnly" contenteditable="false" id="tdpenalty' . $row_member.'"';
        $response .= '>0</td><td><div class="table-data-feature"><button onclick="return ringdelete('.$row_member.','.$_POST['id'].','.$_POST['uid'].')" class="item" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></div></td></tr>';
    }
}
$response .= '</tbody></table>';

echo $response;
?>