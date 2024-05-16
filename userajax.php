<?php

require('connection.php');
 
// $query_user = "select * from client_menus WHERE clientId LIKE '%".$_GET['id']."%'"; 

// $result_user_login = mysqli_query($connection , $query_user);

   // $json = [];
   // while($row = mysqli_fetch_array($result_user_login)){
        // $json[$row['clientId']] = $row['menuId'];
   // }
   // echo json_encode($json);
   
 $select_menudata = "select menuId from client_menus where clientId='".$_GET['q']."'";
$result_menudata = mysqli_query($connection,$select_menudata);	

$stack = array();
while($row_menu = mysqli_fetch_array($result_menudata)){ 
	array_push( $stack, $row_menu ); //$row_menus = $row_menu['menuId'];
}
$theArray = json_encode( $stack );
$theArray1 = json_decode($theArray, true);
 
 $i =0;
 ?>
				<?php if($theArray1[0][0] == 1) { ?>
<input id="menuList1" name="menuList[]" type="checkbox" value="1"/><input type="hidden" name="_menuList" value="on"/> Dashboard
				<?php } else { echo ''; } ?>

<?php if($theArray1[1][0] == 2 OR $theArray1[0][0] == 2) { ?>
				
<input id="menuList2" name="menuList[]" type="checkbox" value="2"/><input type="hidden" name="_menuList" value="on"/> TextRicks Live
<?php } else { echo ''; } ?> 
<?php if($theArray1[1][0] == 3 OR $theArray1[2][0] == 3 OR $theArray1[0][0] == 3) {?>
<input id="menuList3" name="menuList[]" type="checkbox" value="3"/><input type="hidden" name="_menuList" value="on"/> Manage Queue
<?php } else { echo ''; } ?>
<?php if($theArray1[1][0] == 4 OR $theArray1[2][0] == 4 OR $theArray1[3][0] == 4 OR $theArray1[0][0] == 4) { ?>
<input id="menuList4" name="menuList[]" type="checkbox" value="4"/><input type="hidden" name="_menuList" value="on"/> Manage Extension
<?php } else { echo ''; } ?>
 <?php if($theArray1[1][0] == 5 OR $theArray1[2][0] == 5 OR $theArray1[3][0] == 5 OR $theArray1[4][0] == 5 OR $theArray1[0][0] == 5) { ?>
<input id="menuList5" name="menuList[]" type="checkbox" value="5"/><input type="hidden" name="_menuList" value="on"/> Inbound Destination
<?php } else { echo ''; } ?>
<?php if($theArray1[1][0] == 6 OR $theArray1[2][0] == 6 OR $theArray1[3][0] == 6 OR $theArray1[4][0] == 6 OR $theArray1[5][0] == 6 OR $theArray1[0][0] == 6) { ?>
<input id="menuList6" name="menuList[]" type="checkbox" value="6"/><input type="hidden" name="_menuList" value="on"/> Outbound Route
<?php } else { echo ''; } ?>
<?php /*if($theArray1[1][0] == 7 OR $theArray1[2][0] == 7 OR $theArray1[3][0] == 7 OR $theArray1[4][0] == 7 OR $theArray1[5][0] == 7 OR $theArray1[6][0] == 7 OR $theArray1[0][0] == 7) { ?>
<input id="menuList7" name="menuList[]" type="checkbox" value="7"/><input type="hidden" name="_menuList" value="on"/> Trunk
<?php } else { echo ''; } */?>
<?php if($theArray1[1][0] == 8 OR $theArray1[2][0] == 8 OR $theArray1[3][0] == 8 OR $theArray1[4][0] == 8 OR $theArray1[5][0] == 8 OR $theArray1[6][0] == 8 OR $theArray1[7][0] == 8 OR $theArray1[0][0] == 8) { ?>
<input id="menuList8" name="menuList[]" type="checkbox" value="8"/><input type="hidden" name="_menuList" value="on"/> Users
<?php } else { echo ''; } ?>
<?php if($theArray1[1][0] == 9 OR $theArray1[2][0] == 9 OR $theArray1[3][0] == 9 OR $theArray1[4][0] == 9 OR $theArray1[5][0] == 9 OR $theArray1[6][0] == 9 OR $theArray1[7][0] == 9 OR $theArray1[8][0] == 9 OR $theArray1[0][0] == 9) { ?>
<input id="menuList9" name="menuList[]" type="checkbox" value="9"/><input type="hidden" name="_menuList" value="on"/> BlackList
<?php } else { echo ''; } ?>
<?php if($theArray1[1][0] == 10 OR $theArray1[2][0] == 10 OR $theArray1[3][0] == 10 OR $theArray1[4][0] == 10 OR $theArray1[5][0] == 10 OR $theArray1[6][0] == 10 OR $theArray1[7][0] == 10 OR $theArray1[8][0] == 10 OR $theArray1[9][0] == 10 OR $theArray1[0][0] == 10) { ?>
<input id="menuList10" name="menuList[]" type="checkbox" value="10"/><input type="hidden" name="_menuList" value="on"/> Reports
<?php } else { echo ''; } ?>
<?php /*if($theArray1[1][0] == 11 OR $theArray1[2][0] == 11 OR $theArray1[3][0] == 11 OR $theArray1[4][0] == 11 OR $theArray1[5][0] == 11 OR $theArray1[6][0] == 11 OR $theArray1[7][0] == 11 OR $theArray1[8][0] == 11 OR $theArray1[9][0] == 11 OR $theArray1[10][0] == 11 OR $theArray1[0][0] == 11) { ?>
<input id="menuList11" name="menuList[]" type="checkbox" value="11"/><input type="hidden" name="_menuList" value="on"/> Messaging
<?php } else { echo ''; } */?>
<?php /*if($theArray1[1][0] == 12 OR $theArray1[2][0] == 12 OR $theArray1[3][0] == 12 OR $theArray1[4][0] == 12 OR $theArray1[5][0] == 12 OR $theArray1[6][0] == 12 OR $theArray1[7][0] == 12 OR $theArray1[8][0] == 12 OR $theArray1[9][0] == 12 OR $theArray1[10][0] == 12 OR $theArray1[11][0] == 12 OR $theArray1[0][0] == 12) { ?>
<input id="menuList12" name="menuList[]" type="checkbox" value="12"/><input type="hidden" name="_menuList" value="on"/> Phone Numbers
<?php } else { echo ''; } */?>
<?php if($theArray1[1][0] == 13 OR $theArray1[2][0] == 13 OR $theArray1[3][0] == 13 OR $theArray1[4][0] == 13 OR $theArray1[5][0] == 13 OR $theArray1[6][0] == 13 OR $theArray1[7][0] == 13 OR $theArray1[8][0] == 13 OR $theArray1[9][0] == 13 OR $theArray1[10][0] == 13 OR $theArray1[11][0] == 13 OR $theArray1[12][0] == 13 OR $theArray1[0][0] == 13) { ?>
<input id="menuList13" name="menuList[]" type="checkbox" value="13"/><input type="hidden" name="_menuList" value="on"/> Manage Clients
<?php } else { echo ''; } ?>

<?php if($theArray1[1][0] == 14 OR $theArray1[2][0] == 14 OR $theArray1[3][0] == 14 OR $theArray1[4][0] == 14 OR $theArray1[5][0] == 14 OR $theArray1[6][0] == 14 OR $theArray1[7][0] == 14 OR $theArray1[8][0] == 14 OR $theArray1[9][0] == 14 OR $theArray1[10][0] == 14 OR $theArray1[11][0] == 14 OR $theArray1[12][0] == 14 OR $theArray1[13][0] == 14 OR $theArray1[0][0] == 14) { ?>
<input id="menuList14" name="menuList[]" type="checkbox" value="14"/><input type="hidden" name="_menuList" value="on"/> Manage IVR
<?php } else { echo ''; } ?> 
<?php $i++;

   /*
$q = intval($_GET['q']);

$query_user = "select credit from cc_card where id='".$q."'";
$result_user = mysqli_query($connection , $query_user);

while($rowscredit = mysqli_fetch_array($result_user))
{
	if( count($rowscredit['credit']) > 0) 
	{
	echo $credit = '<strong>Credit Available : </strong>'.$rowscredit['credit'];
	}else {
		echo $credit = '<strong>Credit Available : </strong>';
	}
	}
   */
?>
