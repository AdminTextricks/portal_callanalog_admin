<?php
include 'connection.php';

$sql = "SELECT * FROM `cc_did_exten_price` INNER JOIN `cc_country` ON cc_did_exten_price.country_id=cc_country.countryprefix ORDER BY `p_id`";

$result = mysqli_query($connection, $sql) or die("query failed.");
$output = "";
if(mysqli_num_rows($result)>0){
        $output .="<table id='manage_did_price' class='display dataTable table manage_queue_table'>
        <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Country</th>
                    <th>Did_Price</th>
                    <th>Type</th>
                    <th>Tax_Type</th>
                    <th>Tax_Percentage</th>
                    <th>Add_Time</th>
                    <th>Update_Time</th>
                    <th>Action</th>
                </tr>
                </thead> ";
        while($row = mysqli_fetch_assoc($result)){
            $output .="
        <tr>
        <td> {$row['p_id']}</td>
        <td> {$row['countryname']}</td>
        <td> {$row['price']}</td>
        <td> {$row['type']}</td>
        <td> {$row['tax_type']}</td>
        <td> {$row['tax_per']}</td>
        <td>{$row['added_at']}</td>
        <td> {$row['updated_at']}</td>
        <td>
        <button class='item' data-id='{$rows["p_id"]}' data-toggle='tooltip' data-placement='top' title='' data-original-title='Edit'>
        <i class='fa fa-pencil-square-o'></i>
        </button></td>
    </tr>
        ";
    }
    echo $output;
}else{
    echo "<h2>No record found.</h2>";
}
?>