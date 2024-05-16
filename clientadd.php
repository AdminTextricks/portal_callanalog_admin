<?php 
require_once('header.php'); 
$message = '';
if(isset($_POST['submit']))
{
	 // [clientName] => MD LUQMAN
    // [clientSite] => http://www.bigpbx.com
    // [clientEmail] => sanjeet@bigpbx.com
    // [clientEmailPass] => 12345
    // [hostName] => mail.snva.com
    // [portNumber] => 465
    // [phone] => 0965 439 8789
    // [supportEmail] => luqman.ahsen77@gmail.com
    // [loginPass] => 123456
    // [clientSubDomain] => trave.bigpbx.com 
    // [clientLogoUrl] => 
    // [clientFaviconUrl] => 
    // [menuList] => Array
	$selectclientmatch = "select clientName from Client where clientName ='".$_POST['clientName']."'";
	$result_matchclient = mysqli_query($connection,$selectclientmatch); 
	while($rowmatchclient = mysqli_fetch_array($result_matchclient))
	{
		$currentclient = $rowmatchclient['clientName'];
		$currentEmail = $rowmatchclient['clientEmail'];
	}
	if($currentclient == $_POST['clientName'])
	{
	$message = "Client Already Exist With Same Name";
	}elseif($currentEmail == $_POST['clientEmail']){
		$message = "Client Already Exist With Same Email";
	}else{
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
}
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
            <form id="clientForm" action="" method="post">
                

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Name*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientName" name="clientName" placeholder="Name" class="form-control" type="text" required value="<?php if(isset($_POST['clientName'])) { echo $_POST['clientName']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Site*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientSite" name="clientSite" placeholder="https://www.example.com" class="form-control" required type="text" value="<?php if(isset($_POST['clientSite'])) { echo $_POST['clientSite']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Client Email*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientEmail" name="clientEmail" placeholder="support@example.com" class="form-control" required type="text" value="<?php if(isset($_POST['clientEmail'])) { echo $_POST['clientEmail']; } else { echo ''; } ?>"/>
</div>
</div>


<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email Password*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientEmailPass" name="clientEmailPass" placeholder="password" class="form-control" required type="password" value=""/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email Host*</label>
</div>
<div class="col-12 col-md-9">
<input id="hostName" name="hostName" placeholder="smtp.gmail.com" class="form-control" required type="text" value="<?php if(isset($_POST['hostName'])) { echo $_POST['hostName']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Email Port*</label>
</div>
<div class="col-12 col-md-9">
<input id="portNumber" name="portNumber" placeholder="465" class="form-control" required type="text" value="<?php if(isset($_POST['portNumber'])) { echo $_POST['portNumber']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Phone*</label>
</div>
<div class="col-12 col-md-9">
<input id="phone" name="phone" placeholder="+1-888888888" class="form-control" required type="text" value="<?php if(isset($_POST['phone'])) { echo $_POST['phone']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Support Email*</label>
</div>
<div class="col-12 col-md-9">
<input id="supportEmail" name="supportEmail" placeholder="support@example.com" required class="form-control" type="text" value="<?php if(isset($_POST['supportEmail'])) { echo $_POST['supportEmail']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Login Passowrd*</label>
</div>
<div class="col-12 col-md-9">
<input id="loginPass" name="loginPass" placeholder="PBX Login Password" required class="form-control" type="password" value=""/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Sub Domain*</label>
</div>
<div class="col-12 col-md-9">
<input id="clientSubDomain" name="clientSubDomain" placeholder="Sub Domain" required class="form-control" type="text" value="<?php if(isset($_POST['clientSubDomain'])) { echo $_POST['clientSubDomain']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Logo Url</label>
</div>
<div class="col-12 col-md-9">
<input id="clientLogoUrl" name="clientLogoUrl" placeholder="Logo Url" class="form-control" type="text" value="<?php if(isset($_POST['clientLogoUrl'])) { echo $_POST['clientLogoUrl']; } else { echo ''; } ?>"/>
</div>
</div>

<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Favicon Url</label>
</div>
<div class="col-12 col-md-9">
<input id="clientFaviconUrl" name="clientFaviconUrl" placeholder="Favicon Url" class="form-control" type="text" value="<?php if(isset($_POST['clientFaviconUrl'])) { echo $_POST['clientFaviconUrl']; } else { echo ''; } ?>"/>
</div>
</div>

<!--
<div class="row form-group">
<div class="col col-md-3">
<label for="text-input" class=" form-control-label">Menu Options*</label>
</div>
<div class="col-12 col-md-9">

<input id="menuList1" name="menuList[]" type="checkbox" value="1"/><input type="hidden" name="_menuList" value="on"/> Dashboard

<input id="menuList2" name="menuList[]" type="checkbox" value="2"/><input type="hidden" name="_menuList" value="on"/> Big Live

<input id="menuList3" name="menuList[]" type="checkbox" value="3"/><input type="hidden" name="_menuList" value="on"/> Manage Queue

<input id="menuList4" name="menuList[]" type="checkbox" value="4"/><input type="hidden" name="_menuList" value="on"/> Manage Extension

<input id="menuList5" name="menuList[]" type="checkbox" value="5"/><input type="hidden" name="_menuList" value="on"/> Inbound Route

<input id="menuList6" name="menuList[]" type="checkbox" value="6"/><input type="hidden" name="_menuList" value="on"/> Outbound Route

<input id="menuList7" name="menuList[]" type="checkbox" value="7"/><input type="hidden" name="_menuList" value="on"/> Trunk

<input id="menuList8" name="menuList[]" type="checkbox" value="8"/><input type="hidden" name="_menuList" value="on"/> Users

<input id="menuList9" name="menuList[]" type="checkbox" value="9"/><input type="hidden" name="_menuList" value="on"/> BlackList

<input id="menuList10" name="menuList[]" type="checkbox" value="10"/><input type="hidden" name="_menuList" value="on"/> Reports

<input id="menuList11" name="menuList[]" type="checkbox" value="11"/><input type="hidden" name="_menuList" value="on"/> Messaging

<input id="menuList12" name="menuList[]" type="checkbox" value="12"/><input type="hidden" name="_menuList" value="on"/> Phone Numbers

<input id="menuList13" name="menuList[]" type="checkbox" value="13"/><input type="hidden" name="_menuList" value="on"/> Manage Clients

<input id="menuList14" name="menuList[]" type="checkbox" value="14"/><input type="hidden" name="_menuList" value="on"/> Manage IVR

</div>
</div>

-->
			
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
 
