<?php require_once('header.php'); 

// if(isset($_GET['destid'])){
// $select_tfn = "select * from cc_did where call_destination='".$_GET['destid']."'";
// $result_tfn = mysqli_query($con,$select_tfn);
// }else{
$select_tfn = "select * from cc_did";
$result_tfn = mysqli_query($con,$select_tfn);
//}
if(isset($_POST['submit']))
{
	
    // [id] => 0
    // [did_or_tfn] => 18726645554
    // [destination_type] => 2
    // [destination] => 001
    // [submit] => submit
	$selectdidtfn = "select id,did from cc_did where did='".$_POST['did_or_tfn']."'";
	$resultselect = mysqli_query($connection,$selectdidtfn);
	while($rowdid = mysqli_fetch_array($resultselect))
	{
		$didmatch = $rowdid['did'];
		$didid = $rowdid['id'];
	}
	
	if($didmatch == $_POST['did_or_tfn']){
		
	$queryupdate = "update cc_did set didtype='".$_POST['destination_type']."',call_destination='".$_POST['destination']."' where did='".$_POST['did_or_tfn']."'";
	$resultupdate = mysqli_query($connection,$queryupdate);
	
	if($_POST['destination_type'] == 1){
		$destinationname = 'Queues';
	}else{
		$destinationname = 'Extensions';
	}
	$querydestinationupdate = "update cc_did_destination set destination='".$_POST['destination']."',destination_name='".$destinationname."' where id_cc_did='".$didid."' and priority=1";
	$resultdestinations = mysqli_query($connection,$querydestinationupdate);
	
	$message = "DID updated successfully.";
	
	}else{
			$message = "DID does not match in Records.";
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
	<?php while($rowtfn = mysqli_fetch_array($result_tfn)) {?>
        <li class="assignedTfns" title="<?php echo $rowtfn['call_destination']; ?>" data-id="<?php echo $rowtfn['id']; ?>" data-destinationtype="<?php echo $rowtfn['did_type']; ?>" data-destination="<?php echo $rowtfn['call_destination']; ?>" data-tfn="<?php echo $rowtfn['did']; ?>"><p><?php echo $rowtfn['did']; ?> <span><i class="fa fa-times" aria-hidden="true"></i></span></p></li>
	<?php } ?>
    </ul>

    <h4 class="tfn_heading">List Of Unassigned TFNs <i data-toggle="tooltip" data-placement="top" title="Unassigned TFNs" class="fa fa-info-circle" aria-hidden="true"></i></h4>
    <ul class="tfn_list">
	   
    </ul>

 </div>
 
<div class="row">
    <div class="col-md-12">
        <div class="queue_info">
		    <form id="inboundForm" name="update" action="" method="post">
               
				 <div class="row form-group">
				<div class="col col-md-3">
				<label for="text-input" class="form-control-label">DID Or TFN *</label>
				</div>
				<div class="col-12 col-md-9">
				<input id="did_or_tfn" name="did_or_tfn" class="form-control" required type="text" value=""/>
				</div>
				</div> 

				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination Type</label>
                </div>
                <div class="col-12 col-md-9">
                <select required id="destination_type" onchange="showUser(this.value)" name="destination_type" class="form-control">
				<option value="NONE">------SELECT------</option>
				<option value="1">Queues</option>
				<option value="2">Extensions</option>
				</select>
                </div>
                </div>
				

				<div class="row form-group">
                <div class="col col-md-3">
                <label for="text-input" class="form-control-label">Destination</label>
                </div>
                <div class="col-12 col-md-9" id="destinationSelect">
                <select id="destination" name="destination" class="form-control">
				
				</select>
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
function showUser(str) {
  if (str=="") {
    document.getElementById("destinationSelect").innerHTML="";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("destinationSelect").innerHTML=this.responseText;
    }
  }
  xmlhttp.open("GET","ajaxdestination.php?q="+str,true);
  xmlhttp.send();
}
</script>

<?php require_once('footer.php'); ?> 
 
