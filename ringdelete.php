<?php require_once('connection.php'); 

$extension_no= $_POST['extension_no'];
$ringid= $_POST['ringid'];
if(isset($_POST['extension_no']) && $_POST['extension_no'] !='' && isset($_POST['ringid']) && $_POST['ringid'] !=''){
    $query_ringmanage = "select * from cc_ring_group where id='".$_POST['ringid']."'";
    $result_managering = mysqli_query($connection , $query_ringmanage);
    $row_manage = mysqli_fetch_array($result_managering);

    $ringlist = $row_manage['ringlist'];

    $ring_array =  array();
    $ring_array = explode('-',$ringlist);
    $pos = array_search($extension_no, $ring_array);
    if ($pos !== false) {
        unset($ring_array[$pos]);
    }
    $ringlist_new = implode('-',$ring_array);
    $query_ringdelete = "update cc_ring_group set ringlist='".$ringlist_new."'  where id='".$_POST['ringid']."'";
    $result_deletering = mysqli_query($connection , $query_ringdelete);

    echo true;
}
?>