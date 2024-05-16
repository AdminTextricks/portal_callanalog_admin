<?php require_once('header.php'); 

$select_tfn = "select * from cc_did where call_destination='".$_GET['destid']."'";
$result_tfn = mysqli_query($con,$select_tfn);

$select_tfn_single = "select * from cc_did where call_destination='".$_GET['destid']."'";
$result_tfn_single = mysqli_query($con,$select_tfn_single);
while($rowdiddest = mysqli_fetch_array($result_tfn_single))
	{
		$didmatch = $rowdiddest['did'];
		$didid = $rowdiddest['id'];
		$diddidtype = $rowdiddest['didtype'];
		$didcall_destination = $rowdiddest['call_destination'];
	}
	
if($diddidtype == 1){
		$destinationtype = 'Queues';
	}else{
		$destinationtype = 'Extensions';
	}
	
if(isset($_POST['submit']))
{
	
    
    // [destination_type] => Queues
    // [destination] => 6501
    // [forwardDestType] => 1
    // [forwardDest] => 6501
    // [dialTimeOut] => 0
    // [submit] => submit
	
	$selectdidtfn = "select id,did,call_destination from cc_did where call_destination='".$_POST['destination']."'";
	$resultselect = mysqli_query($connection,$selectdidtfn);
	while($rowdid = mysqli_fetch_array($resultselect))
	{
		$didmatch = $rowdid['did'];
		$didid = $rowdid['id'];
		$diddestintionmatch = $rowdid['call_destination'];
		
	}
	
	if($diddestintionmatch == $_POST['destination']){
		
	$queryupdate = "update cc_did set didtype='".$_POST['forwardDestType']."',call_destination='".$_POST['forwardDest']."' where call_destination='".$_POST['destination']."'";
	$resultupdate = mysqli_query($connection,$queryupdate);
	
	if($_POST['forwardDestType'] == 1){
		$destinationname = 'Queues';
	}else{
		$destinationname = 'Extensions';
	}

	$querydestinationupdate = "update cc_did_destination set destination='".$_POST['forwardDest']."',destination_name='".$destinationname."' where destination='".$_POST['destination']."' and priority=1";
	$resultdestinations = mysqli_query($connection,$querydestinationupdate);

	$querydestinationdelete = "delete from cc_did_destination where destination='".$_POST['destination']."' and priority=2";	
	$resultdelete = mysqli_query($connection,$querydestinationdelete);
	
	$message = "Inbound Group Updated Successfully.";
	
	}else{
			$message = "Inbound Group does not match in Records.";
	}
	
}

?>
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Phone Numbers <span style="margin-left:50px;color:blue;"><?php echo $message; ?></span></h2>
<div class="table-data__tool-right">
<a href="inboundgroup.php">
<button class="au-btn au-btn-icon au-btn--green au-btn--small">
<i class="fa fa-eye" aria-hidden="true"></i> Inbound Group</button></a>
</div>

</div>
</div>
</div>

<div class="big_live_outer">

<div class="assign_tnf_list_box">
    <h4 class="tfn_heading">List Of Assigned TFNs <i data-toggle="tooltip" data-placement="top" title="Assigned TFNs" class="fa fa-info-circle" aria-hidden="true"></i></h4>
    
	<ul class="tfn_list">
	<?php if(mysqli_num_rows($result_tfn)>0){?>
	<?php while($rowtfn = mysqli_fetch_array($result_tfn)) {?>
        <li class="assignedTfns" title="<?php echo $rowtfn['call_destination']; ?>" data-id="<?php echo $rowtfn['id']; ?>" data-destinationtype="<?php echo $rowtfn['did_type']; ?>" data-destination="<?php echo $rowtfn['call_destination']; ?>" data-tfn="<?php echo $rowtfn['did']; ?>"><p><?php echo $rowtfn['did']; ?> <span><i class="fa fa-times" aria-hidden="true"></i></span></p></li>
	<?php } ?>
	<?php }else { echo '<br><center><p style="color:red;">No Records Found</p></center><br>'; } ?>
    </ul>

    <h4 class="tfn_heading">List Of Unassigned TFNs <i data-toggle="tooltip" data-placement="top" title="Unassigned TFNs" class="fa fa-info-circle" aria-hidden="true"></i></h4>
    <ul class="tfn_list">
	   
    </ul>

 </div>
 
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">

            <form id="inboundForm" action="" name="update" method="post" novalidate="novalidate">
                
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination Type</label>
                </div>
                
				<div class="col-12 col-md-9">
				<input id="destination_type" name="destination_type" readonly class="form-control" type="text" value="<?php echo $destinationtype; ?>">
				</div>
                </div>
				

				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination</label>
                </div>
                <div class="col-12 col-md-9">
				<input id="destination" name="destination" class="form-control" readonly type="text" value="<?php echo $didcall_destination; ?>">
                </div>
                </div>
				
				
				
			<div class="advance_opt" style="cursor:pointer;">
                <h4 class="advance_opt_toggle">Forward to another queue or extension</h4>

                <div class="advance_opt_form">
                    

                <div class="row form-group">
				<div class="col col-md-3">
				<label for="selectSm" class=" form-control-label">Destination Type</label>
				</div>
				<div class="col-12 col-md-9">
				<select required id="forwardDestType" onchange="showUseradv(this.value)" name="forwardDestType" class="form-control valid" aria-invalid="false">
				<option value="">------SELECT------</option>
				<option value="1">Queues</option>
				<option value="2">Extensions</option>
				</select>
				</div>
				</div>
				
				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination</label>
                </div>
                <div class="col-12 col-md-9" id="forwarddestSelect">
                <select required id="forwardDest" name="forwardDest" class="form-control"></select>
                </div>
                </div>
				
				<div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">Dial Timeout</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="dialTimeOut" name="dialTimeOut" class="form-control" type="text" value="0">
				</div>
				</div>


                </div>

            </div>
			
						
			<div class="form-group pull-right">
			 <button type="submit" name="submit" value="submit" class="btn btn-primary btn-sm">Update</button>
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

<script>
function showUseradv(str) {
  if (str=="") {
    document.getElementById("forwarddestSelect").innerHTML="";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("forwarddestSelect").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","ajaxdestinationadv.php?dest=destination&qv="+str,true);
  xmlhttp.send();
}
</script>

<?php require_once('footer.php'); ?> 
 
