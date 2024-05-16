<?php 
 require_once('connection.php'); 
// connect to DB
$extension_number = $_GET['extension_number'];
// run an endless loop
$number_array = array();

while(1) {

    // generate unique random number
    $randomNumber = rand(0, 999999);
    // pad the number with zeros (if needed)
    $paded = str_pad($randomNumber, 6, '0', STR_PAD_RIGHT);
    // check if it exists in database
    $query = "SELECT id FROM cc_sip_buddies WHERE `name`=$paded";    
    $res = mysqli_query($connection , $query);
    $rowCount = mysqli_num_rows($res);
    if($rowCount < 1 ){
        // if not found in the db (it is unique), break out of the loop
        if($rowCount < 1 && count($number_array) > $extension_number-1) {
            break;
        }else{
            $insert_number = "insert into tbl_rand (the_number) VALUES ('".$paded."')";
            $query_res = mysqli_query($connection, $insert_number); 
            $number_array[] = $paded;
        }    
    }else{
        continue;
    }   
}

// dash delimited string to be displayed
/* $delimited = '';
// add dashes
for($i = 0; $i < 6; $i++) {

    // add a character
    $delimited .= $paded[$i];

    // add dashes wherever appropriate
    if($i == 2 || $i == 5) {

        $delimited .= '-';
    }
} */

echo implode(',',$number_array);
//echo json_encode($number_array); 
?>
