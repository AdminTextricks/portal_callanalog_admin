<?php 
require_once('header.php'); 
$message = '';
$select_clientdata = "select * from Client where clientId='".$_GET['id']."'";
	$result_clientdata = mysqli_query($connection,$select_clientdata);
	
$select_menudata = "select menuId from client_menus where clientId='".$_GET['id']."'";
$result_menudata = mysqli_query($connection,$select_menudata);	

if(isset($_POST['submit']))
{	
//print_r($_POST);

$created_at = date('Y-m-d h:i:s');
$update_client = "update Client set modifyDate='".$created_at."',clientName='".$_POST['clientName']."',clientSite='".$_POST['clientSite']."',clientEmail='".$_POST['clientEmail']."',clientEmailPass='".$_POST['clientEmailPass']."',hostName='".$_POST['hostName']."',portNumber='".$_POST['portNumber']."',phone='".$_POST['phone']."',supportEmail='".$_POST['supportEmail']."',loginPass='".$_POST['loginPass']."',clientSubDomain='".$_POST['clientSubDomain']."' where clientId='".$_GET['id']."'"; 
$result_updateclient = mysqli_query($connection,$update_client);

$delete_menudata = "delete from client_menus where clientId='".$_GET['id']."'";
$result_detetemenudata = mysqli_query($connection,$delete_menudata);

if(!empty($_POST['menuList'])) {
				foreach($_POST['menuList'] as $check) {
					
				$insert_menu = "insert into client_menus (clientId,menuId) VALUES ('".$_GET['id']."','".$check."')";	
				$result_menu = mysqli_query($connection,$insert_menu);
				
				}
			}
		
		if($result_updateclient){
			$message = "Client updated Successfully!";
		}

}
	
	/*
if(isset($_POST['submit']))
{
	
	$created_at = date('Y-m-d h:i:s');
	
	$insert_client = "insert into Client (createDate,modifyDate,clientName,clientSite,clientEmail,clientEmailPass,hostName,portNumber,phone,supportEmail,loginPass,clientSubDomain) VALUES ('".$created_at."','".$created_at."','".$_POST['clientName']."','".$_POST['clientSite']."','".$_POST['clientEmail']."','".$_POST['clientEmailPass']."','".$_POST['hostName']."','".$_POST['portNumber']."','".$_POST['phone']."','".$_POST['supportEmail']."','".$_POST['loginPass']."','".$_POST['clientSubDomain']."')";
	$result_client = mysqli_query($connection,$insert_client);
																			
		$lastclientID = mysqli_insert_id($connection);
		
			if(!empty($_POST['menuList'])) {
				foreach($_POST['menuList'] as $check) {
					
				$insert_menu = "insert into client_menus (clientId,menuId) VALUES ('".$lastclientID."','".$check."')";	
				$result_menu = mysqli_query($connection,$insert_menu);
				
				}
			}
		if($result_client){
			$message = "Client added Successfully!";
		}	
	}
	*/
?>


<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Client Information <span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
<div class="table-data__tool-right">
<a href="client.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> Client</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
            <form id="clientForm" name="clientedit" action="" method="post">
                
<?php while($row = mysqli_fetch_array($result_clientdata)) { 
		
		$clientName = $row['clientName'];
		$clientSite = $row['clientSite'];
		$clientEmail = $row['clientEmail'];
		$clientEmailPass = $row['clientEmailPass'];
		$phone = $row['phone'];
		$hostName = $row['hostName'];
		$portNumber = $row['portNumber'];
		$supportEmail = $row['supportEmail'];
		$loginPass = $row['loginPass'];
		$clientSubDomain = $row['clientSubDomain'];

} ?>
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Name*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientName" name="clientName" placeholder="Name" class="form-control" type="text" required value="<?php echo $clientName; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Site*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientSite" name="clientSite" placeholder="https://www.example.com" class="form-control" required type="text" value="<?php echo $clientSite; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Email*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientEmail" name="clientEmail" placeholder="support@example.com" class="form-control" required type="text" value="<?php echo $clientEmail; ?>"/>
</div>
</div>


<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email Password*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientEmailPass" name="clientEmailPass" placeholder="password" class="form-control" required type="text" value="<?php echo $clientEmailPass; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email Host*</label>
</div>
<div class="col-12 col-md-9">
<input id="hostName" name="hostName" placeholder="smtp.gmail.com" class="form-control" required type="text" value="<?php echo $hostName; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email Port*</label>
</div>
<div class="col-12 col-md-9">
<input id="portNumber" name="portNumber" placeholder="465" class="form-control" required type="text" value="<?php echo $portNumber; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Phone*</label>
</div>
<div class="col-12 col-md-9">
<input id="phone" name="phone" placeholder="+1-888888888" class="form-control" required type="text" value="<?php echo $phone; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Support Email*</label>
</div>
<div class="col-12 col-md-9">
<input id="supportEmail" name="supportEmail" placeholder="support@example.com" required class="form-control" type="text" value="<?php echo $supportEmail; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Login Passowrd*</label>
</div>
<div class="col-12 col-md-9">
<input id="loginPass" name="loginPass" placeholder="PBX Login Password" required class="form-control" type="text" value="<?php echo $loginPass; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Sub Domain*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientSubDomain" name="clientSubDomain" placeholder="Sub Domain" required class="form-control" type="text" value="<?php echo $clientSubDomain; ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Logo Url</label>
</div>
<div class="col-12 col-md-9">
<input id="clientLogoUrl" name="clientLogoUrl" placeholder="Logo Url" class="form-control" type="text" value=""/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Favicon Url</label>
</div>
<div class="col-12 col-md-9">
<input id="clientFaviconUrl" name="clientFaviconUrl" placeholder="Favicon Url" class="form-control" type="text" value=""/>
</div>
</div>

<!-- 
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Menu Options*</label>
</div>
<div class="col-12 col-md-9">

<?php 
$stack = array();
while($row_menu = mysqli_fetch_array($result_menudata)){ 
	array_push( $stack, $row_menu ); //$row_menus = $row_menu['menuId'];
}
$theArray = json_encode( $stack );
$theArray1 = json_decode($theArray, true);
 
 $i =0;
 ?>
				
<input id="menuList1" name="menuList[]" <?php //if($theArray1[0][0] == 1) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="1"/><input type="hidden" name="_menuList" value="on"/> Dashboard

<input id="menuList2" name="menuList[]" <?php //if($theArray1[1][0] == 2 OR $theArray1[0][0] == 2) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="2"/><input type="hidden" name="_menuList" value="on"/> Big Live

<input id="menuList3" name="menuList[]" <?php //if($theArray1[1][0] == 3 OR $theArray1[2][0] == 3 OR $theArray1[0][0] == 3) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="3"/><input type="hidden" name="_menuList" value="on"/> Manage Queue

<input id="menuList4" name="menuList[]" <?php //if($theArray1[1][0] == 4 OR $theArray1[2][0] == 4 OR $theArray1[3][0] == 4 OR $theArray1[0][0] == 4) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="4"/><input type="hidden" name="_menuList" value="on"/> Manage Extension

<input id="menuList5" name="menuList[]" <?php //if($theArray1[1][0] == 5 OR $theArray1[2][0] == 5 OR $theArray1[3][0] == 5 OR $theArray1[4][0] == 5 OR $theArray1[0][0] == 5) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="5"/><input type="hidden" name="_menuList" value="on"/> Inbound Route

<input id="menuList6" name="menuList[]" <?php //if($theArray1[1][0] == 6 OR $theArray1[2][0] == 6 OR $theArray1[3][0] == 6 OR $theArray1[4][0] == 6 OR $theArray1[5][0] == 6 OR $theArray1[0][0] == 6) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="6"/><input type="hidden" name="_menuList" value="on"/> Outbound Route

<input id="menuList7" name="menuList[]" <?php //if($theArray1[1][0] == 7 OR $theArray1[2][0] == 7 OR $theArray1[3][0] == 7 OR $theArray1[4][0] == 7 OR $theArray1[5][0] == 7 OR $theArray1[6][0] == 7 OR $theArray1[0][0] == 7) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="7"/><input type="hidden" name="_menuList" value="on"/> Trunk

<input id="menuList8" name="menuList[]" <?php //if($theArray1[1][0] == 8 OR $theArray1[2][0] == 8 OR $theArray1[3][0] == 8 OR $theArray1[4][0] == 8 OR $theArray1[5][0] == 8 OR $theArray1[6][0] == 8 OR $theArray1[7][0] == 8 OR $theArray1[0][0] == 8) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="8"/><input type="hidden" name="_menuList" value="on"/> Users

<input id="menuList9" name="menuList[]" <?php //if($theArray1[1][0] == 9 OR $theArray1[2][0] == 9 OR $theArray1[3][0] == 9 OR $theArray1[4][0] == 9 OR $theArray1[5][0] == 9 OR $theArray1[6][0] == 9 OR $theArray1[7][0] == 9 OR $theArray1[8][0] == 9 OR $theArray1[0][0] == 9) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="9"/><input type="hidden" name="_menuList" value="on"/> BlackList

<input id="menuList10" name="menuList[]" <?php //if($theArray1[1][0] == 10 OR $theArray1[2][0] == 10 OR $theArray1[3][0] == 10 OR $theArray1[4][0] == 10 OR $theArray1[5][0] == 10 OR $theArray1[6][0] == 10 OR $theArray1[7][0] == 10 OR $theArray1[8][0] == 10 OR $theArray1[9][0] == 10 OR $theArray1[0][0] == 10) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="10"/><input type="hidden" name="_menuList" value="on"/> Reports

<input id="menuList11" name="menuList[]" <?php //if($theArray1[1][0] == 11 OR $theArray1[2][0] == 11 OR $theArray1[3][0] == 11 OR $theArray1[4][0] == 11 OR $theArray1[5][0] == 11 OR $theArray1[6][0] == 11 OR $theArray1[7][0] == 11 OR $theArray1[8][0] == 11 OR $theArray1[9][0] == 11 OR $theArray1[10][0] == 11 OR $theArray1[0][0] == 11) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="11"/><input type="hidden" name="_menuList" value="on"/> Messaging

<input id="menuList12" name="menuList[]" <?php //if($theArray1[1][0] == 12 OR $theArray1[2][0] == 12 OR $theArray1[3][0] == 12 OR $theArray1[4][0] == 12 OR $theArray1[5][0] == 12 OR $theArray1[6][0] == 12 OR $theArray1[7][0] == 12 OR $theArray1[8][0] == 12 OR $theArray1[9][0] == 12 OR $theArray1[10][0] == 12 OR $theArray1[11][0] == 12 OR $theArray1[0][0] == 12) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="12"/><input type="hidden" name="_menuList" value="on"/> Phone Numbers

<input id="menuList13" name="menuList[]" <?php //if($theArray1[1][0] == 13 OR $theArray1[2][0] == 13 OR $theArray1[3][0] == 13 OR $theArray1[4][0] == 13 OR $theArray1[5][0] == 13 OR $theArray1[6][0] == 13 OR $theArray1[7][0] == 13 OR $theArray1[8][0] == 13 OR $theArray1[9][0] == 13 OR $theArray1[10][0] == 13 OR $theArray1[11][0] == 13 OR $theArray1[12][0] == 13 OR $theArray1[0][0] == 13) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="13"/><input type="hidden" name="_menuList" value="on"/> Manage Clients

<input id="menuList14" name="menuList[]" <?php //if($theArray1[1][0] == 14 OR $theArray1[2][0] == 14 OR $theArray1[3][0] == 14 OR $theArray1[4][0] == 14 OR $theArray1[5][0] == 14 OR $theArray1[6][0] == 14 OR $theArray1[7][0] == 14 OR $theArray1[8][0] == 14 OR $theArray1[9][0] == 14 OR $theArray1[10][0] == 14 OR $theArray1[11][0] == 14 OR $theArray1[12][0] == 14 OR $theArray1[13][0] == 14 OR $theArray1[0][0] == 14) { echo 'checked="checked"'; } else { echo ''; } ?> type="checkbox" value="14"/><input type="hidden" name="_menuList" value="on"/> Manage IVR

<?php //$i++; ?>
</div>
</div> -->



			
			<div class="form-group pull-right">
			 <button type="submit" name="submit" class="btn btn-primary btn-sm">Submit</button>
			</div>
			<p style="color:blue;"><?php echo $message; ?></p>
</form>
			
        </div>
    </div>
    </div>



</div>
</div>



</div>
</div>
<br>

<?php require_once('footer.php'); ?> 
 
