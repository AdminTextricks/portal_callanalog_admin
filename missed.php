<?php require_once('header.php');


$fromdate = $_POST['fromDate'];

if(isset($_POST['submit']))
{	
	if($_SESSION['userroleforpage'] == 1){
	$select_did = "select distinct did from cdr where calldate between '".$fromdate."' and '".$fromdate." 23:59:59' and did != '' and disposition='NO ANSWER'";
	}else{
	$select_did = "select distinct did from cdr where calldate between '".$fromdate."' and '".$fromdate." 23:59:59' and did != '' and disposition='NO ANSWER' and accountcode='".$_SESSION['login_usernames']."'";
	}
	$resultdid = mysqli_query($connection,$select_did);
	
}

?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap table_top_heading">
    

</div>
</div>
</div>

<div class="reports_inner_outer">
<div class="row">
    <div class="col-md-12">
        <div class="report_missed">
            <form id="classicReportForm" action="" method="post">
  <div class="row">

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label" style="color:black;margin-left:0px;font-weight:bold;">Select Date</label>
<input id="fromDate" name="fromDate" autocomplete="off" class="form-control" type="text" value="<?php if(isset($_POST['fromDate'])){ echo $_POST['fromDate']; } else { echo date('Y-m-d'); } ?>"/>
</div>
</div>

			<div class="col-md-3">
			<div class="form-group">
			 <button type="submit" name="submit" value="submit" style="margin-top: 25px;" class="btn btn-primary btn-sm">Submit</button>
			</div>
    </div>
			<p></p>
    </div>
</form>
			
        </div>
    </div>
    </div>
  </div>

<?php if(isset($_POST['fromDate'])) { ?>
	<div class="row">
  	 <div class="col-lg-12">
  	 	<div class="table_title">
  	 	   <h4>Missed Call Report From <?php echo $fromdate.' 00:00:00 TO '.$fromdate.' 23:59:59';  ?></h4>
  	 	</div>
  	 </div>
	</div>	
	<br>
<?php } ?>
<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate" style="overflow: scroll;">
<table id="queueTable" class="table manage_queue_table">
<thead>

<tr style="border:1px solid white; background-color:#2aa9de;color:white;">
<th style="color:white;">Serial No</th>
<th style="color:white;">TFN</th>

<th style="color:white;">09:30-10:30</th>
<th style="color:white;">10:30-11:30</th>
<th style="color:white;">11:30-12:30</th>
<th style="color:white;">12:30-13:30</th>
<th style="color:white;">13:30-14:30</th>
<th style="color:white;">14:30-15:30</th>
<th style="color:white;">15:30-16:30</th>
<th style="color:white;">16:30-17:30</th>
<th style="color:white;">17:30-18:30</th>
<th style="color:white;">18:30-19:30</th>
<th style="color:white;">19:30-20:30</th>
<th style="color:white;">20:30-21:30</th>
<th style="color:white;">21:30-22:30</th>
<th style="color:white;">22:30-23:30</th>
<th style="color:white;">23:30-00:30</th>
<th style="color:white;">00:30-01:30</th>
<th style="color:white;">01:30-02:30</th>
<th style="color:white;">02:30-03:30</th>
<th style="color:white;">03:30-04:30</th>
<th style="color:white;">04:30-05:30</th>
<th style="color:white;">05:30-06:30</th>
<th style="color:white;">06:30-07:30</th>
<th style="color:white;">07:30-08:30</th>
<th style="color:white;">08:30-09:30</th>
<th style="color:white;">Total</th>
</tr>
</thead>
<tbody>
<?php 
$j =1;
if(isset($_POST['submit']))
{
while($rowdid = mysqli_fetch_array($resultdid))
	{
		
		$didno = $rowdid['did'];
$fromtime = array("09:30","10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30","18:30","19:30","20:30","21:30","22:30","23:30","00:30","01:30","02:30","03:30","04:30","05:30","06:30","07:30","08:30");
$totime = array("10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30","18:30","19:30","20:30","21:30","22:30","23:30","00:30","01:30","02:30","03:30","04:30","05:30","06:30","07:30","08:30","09:30");	

if($_SESSION['userroleforpage'] == 1){	
$querytotaldid =  "select count(did) as totalnumber from cdr where did='".$didno."' and calldate between '".$fromdate."' and '".$fromdate." 23:59:59' and disposition='NO ANSWER' and did!=''";
}else{
$querytotaldid =  "select count(did) as totalnumber from cdr where did='".$didno."' and calldate between '".$fromdate."' and '".$fromdate." 23:59:59' and disposition='NO ANSWER' and did!='' and accountcode='".$_SESSION['login_usernames']."'";
}
$resultdidcount = mysqli_query($connection,$querytotaldid);
$totaldidnumbercount = mysqli_fetch_assoc($resultdidcount);	

?>
<tr style="border:1px solid white;">
<td style="background-color:#2aa9de;color:white;text-align:left;"><?php echo $j; ?></td>
<td style="background-color:#2aa9de;color:white;text-align:left;" ><?php echo $didno; ?></td>
<?php for($i=0;$i<count($fromtime);$i++)
{
	if($_SESSION['userroleforpage'] == 1){	
	$querydata =  "select count(did) as totalcount from cdr where did='".$didno."' and calldate between '".$fromdate.' '.$fromtime[$i]."' and '".$fromdate.' '.$totime[$i]."' and disposition='NO ANSWER' and did!=''";
	}else{
	$querydata =  "select count(did) as totalcount from cdr where did='".$didno."' and calldate between '".$fromdate.' '.$fromtime[$i]."' and '".$fromdate.' '.$totime[$i]."' and disposition='NO ANSWER' and did!='' and accountcode='".$_SESSION['login_usernames']."'";
	}
	$resultcount = mysqli_query($connection,$querydata);
	
	while($rowcount = mysqli_fetch_array($resultcount))
	{ ?>
<td><?php echo $rowcount['totalcount']; ?></td>
 <?php
}
} 
?>
<td style="background-color:#2aa9de;color:white;"><?php echo $totaldidnumbercount['totalnumber']; ?></td>
</tr>

 <?php
//}
// }
$j++;
} }
?>
<tr>
<td colspan="2" style="border:1px solid white; background-color:#2aa9de;color:white;">Total</td>
<?php 

$fromtime = array("09:30","10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30","18:30","19:30","20:30","21:30","22:30","23:30","00:30","01:30","02:30","03:30","04:30","05:30","06:30","07:30","08:30");
$totime = array("10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30","18:30","19:30","20:30","21:30","22:30","23:30","00:30","01:30","02:30","03:30","04:30","05:30","06:30","07:30","08:30","09:30");	


for($k=0;$k<count($fromtime);$k++)
{
	if($_SESSION['userroleforpage'] == 1){	
	$querydatatotal =  "select count(did) as totcount from cdr where calldate between '".$fromdate.' '.$fromtime[$k]."' and '".$fromdate.' '.$totime[$k]."' and disposition='NO ANSWER' and did!=''";
	}else{
	$querydatatotal =  "select count(did) as totcount from cdr where calldate between '".$fromdate.' '.$fromtime[$k]."' and '".$fromdate.' '.$totime[$k]."' and disposition='NO ANSWER' and did!='' and accountcode='".$_SESSION['login_usernames']."'";
	}
	$resultdiddidcount = mysqli_query($connection,$querydatatotal);
	
	while($rowcountrow = mysqli_fetch_array($resultdiddidcount))
	{ ?>
<td style="background-color:#2aa9de;color:white;"><?php echo $rowcountrow['totcount']; ?></td>
 <?php
}
} 
?>
</tr>


</tbody>
</table>
</div>

 
</div>
</div>
	


</div>
</div>

<!-- footer section start here -->
<!-- <div class="copyright">
<p>Copyright Â© 2020 PBX. All rights reserved.</p>
</div> -->
<!-- footer section end here -->

</div>


</div>
</div>

<script>
$( function() {
    $( "#fromDate" ).datepicker({dateFormat: 'yy-mm-dd ',
  maxDate:'0'});
	$( "#toDate" ).datepicker({dateFormat: 'yy-mm-dd ',
  maxDate:'0'});
  } );

</script>

   <?php require_once('footer.php');?> 

