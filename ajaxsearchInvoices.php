<?php 
require_once('connection.php');

//echo '<pre>'; print_r($_POST); echo '</pre>';

if(!empty($_POST['fromDate'])){
    $fromDate = 'DATE(createdDate) between"'.$_POST['fromDate'].'"';
}else{
    $fromDate = 'DATE(createdDate)= "'.date("Y-m-d").'"';
}

if(!empty($_POST['toDate'])){
    $toDate = 'and"'.$_POST['toDate'].'"';
}else{
    $toDate = 'and "'.date("Y-m-d").'"';
}



if(isset($_POST['itemType']) && strlen($_POST['itemType'])>0){
    $itemType = 'and invoices.item_type="'.$_POST['itemType'].'"';
}else{
    $itemType = '';
}


if(isset($_POST['paymentType']) && strlen($_POST['paymentType']) > 0){
    $paymentType = 'and payment_type="'.$_POST['paymentType'].'"';   
}else{
    $paymentType = '';
}


if($_SESSION['userroleforpage'] == 1){
    $sql = "SELECT * FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE ".$fromDate." ".$toDate." ".$itemType." ".$paymentType."";
}else{
    $user_id = 'and invoices.user_id="'.$_SESSION['login_user_id'].'"';
    $sql = "SELECT * FROM `invoices` INNER JOIN `users_login` ON invoices.user_id = users_login.id INNER JOIN `gateways_payments` ON invoices.id=gateways_payments.invoice_db_id WHERE ".$fromDate." ".$toDate." ".$itemType." ".$paymentType." ".$user_id."";
}

// echo $sql; exit;
    $result = mysqli_query($connection, $sql) or die("query failed : ajaxsearchInvoice");

    $output = '';
    if(mysqli_num_rows($result) > 0){
        $output .="<table width='100%'>
                <thead>
                    <th>Serial No</th>
                    <th>Invoice ID</th>
                    <th>Name</th>
                    <th>Item Type</th>
                    <th>Payment Type</th>
                    <th>Date</th>
                    <th>Action</th>
                </thead>";
                $i=1;
        while($row = mysqli_fetch_assoc($result)){
                $output .="
                    <tr class='tr-shadow'>
                        <td>{$i}</td>
                        <td>{$row['invoice_id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['item_type']}</td>
                        <td>{$row['payment_type']}</td>
                        <td>{$row['createdDate']}</td>
                        <td><a href='invoice_pdf/{$row['invoice_file']}' download><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-download' viewBox='0 0 16 16'>
                        <path d='M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z'/>
                        <path d='M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z'/>
                      </svg></a></td>
                    </tr>";
                    $i++;
        }
                    $output .= "</table>";
        echo $output;
    }else{
        echo "<span colspan='11' style='color:red;font-size:20px;'>No data found </span>";
    }
?>