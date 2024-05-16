<?php require_once('header.php'); 

require_once('connection.php');



// print_r($_POST);
// echo '<br>';
// print_r($_SESSION);
// die();
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['submit']))
{
	$start = $_POST['fromDate'];
	$end = $_POST['toDate'].' 23:59:59';
	$end_one = $_POST['toDate'];
}
else{
	if(isset($_POST['start']))
	{
		$start = $_POST['start'];
	$end = $_POST['end'];
	$end_one = $_POST['end'];
	}else{
	$start = date('Y-m-d');
	$end = date('Y-m-d').' 23:59:59';
	$end_one = date('Y-m-d');
	}
}

?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
  
<div class="reports_inner_outer"  style="background-color:gray">
<div class="row">
    <div class="col-md-12">
        <div class="report_missed">
            <form id="classicReportForm" name="reports" action="" method="post">
  <div class="row" style="padding-left:400px;">

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label" style="color:white;">From Date</label>
<input id="fromDate" name="fromDate" class="form-control" type="text" value="<?php echo $start; ?>"/>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label" style="color:white;">To Date</label>
<input id="toDate" name="toDate" class="form-control" data-date-format="yyyy-mm-dd" type="text" value="<?php echo $end_one; ?>"/>
</div>
</div>
			<div class="col-md-3">
			<div class="form-group">
			 <button type="submit" name="submit" value="submit" style="margin-top: 47px;" class="btn btn-primary btn-sm">Submit</button>
			</div>
    </div>
			<p></p>
    </div>
</form>
			
        </div>
    </div>
    </div>
  </div>
  
  
<center><h1><?php echo ' Call Report '; ?> ( Dialer Server ) </h1><?php echo '<br> <h3 style="color:green;">'.$start.' TO '. $end; ?></h3></center>
<hr>
<!--
&nbsp;&nbsp;
<div class="overview-wrap table_top_heading">
<a href="http://edu.bigpbx.com/bigpbxnew/bigpbx/acallreport.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-phone"></i>Back</button></a>
</div>
<div class="overview-wrap table_top_heading">
<a href="http://edu.bigpbx.com/bigpbxnew/bigpbx/agentwisecallreport.php?username=<?php echo $_SESSION['login_user']; ?>&start=<?php echo $_POST['start']; ?>&end=<?php echo $_POST['end']; ?>">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-phone"></i>Agent wise Report</button></a>
</div>
-->
<div class="row">

<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title"></h4>
<table class="table manage_queue_table">
<thead>
<tr style="text-align: left;">
<th style="text-align: left;">Serial No.</th>
<th style="text-align: left;">Agent Name</th>
<th style="text-align: left;">Extension</th>
<th style="text-align: left;">Caller ID</th>
<th style="text-align: left;">Duration</th>
<th style="text-align: left;">Total Call</th>
</tr>
</thead>
<tbody >

<?php 
$i = 1;
$query_totalall = "SELECT COUNT( id ) AS totalcall, SUM( billsec ) AS totalduration, extension
FROM `cdr`
WHERE calldate
BETWEEN '".$start."'
AND '".$end."'
AND disposition = 'ANSWERED'
AND call_type = '0'
AND duration != '0'
GROUP BY extension";
$result_totalall = mysqli_query($connection,$query_totalall);
$totalrecordss = mysqli_num_rows($result_totalall);

while($totaling = mysqli_fetch_array($result_totalall))
{
	$totalcall = $totaling['totalcall'];
	$totalduration = $totaling['totalduration'];
	$extension = $totaling['extension'];


$callingagent = "select * from cc_sip_buddies where name='".$extension."'";
$result_callingagent = mysqli_query($connection,$callingagent);
while($rownameagent = mysqli_fetch_array($result_callingagent))
{
	$agent_name = $rownameagent['agent_name'];
	$callerids = $rownameagent['callerid'];
	
	
}
		
	?>
	<tr style="color:white;text-align: left;" >
		<td style="text-align: left;"><?php echo $i; ?></td>
		<td style="text-align: left;cursor:pointer;"><a href="masteragentscallsrecord.php?start=<?php echo $start;?>&end=<?php echo $end; ?>&user=<?php echo $extension; ?>" ><?php echo $agent_name; ?></a></td>
		<td style="text-align: left;"><?php echo $extension; ?></td>
		<td style="text-align: left;"><?php echo $callerids; ?></td>
		<td style="text-align: left;"><?php echo floor(($totalduration / 60)).':'.$totalduration % 60; ?></td>
		<td style="text-align: left;"><?php echo $totalcall; ?></td>
		</tr>
		<?php  $i++;  }  ?>

</tbody>
<!--
<thead>
<tr style="text-align: left;background-color:yellow;">
<th style="text-align: left;">Country </th>
<th style="text-align: left;">Total Cost ( In USD ) = <?php echo round($totalcostall,3); ?></th>
<th style="text-align: left;">Total Avg. Cost ( In USD ) = <?php echo round($totalcostall,3); ?></th>
<th style="text-align: left;">Total Duration ( In Seconds )= <?php echo $totaltime; ?></th>
<th style="text-align: left;">Total Avg. Duration ( In Seconds )= <?php echo round(($totaltime/$totalcountry),0); ?></th>
<th style="text-align: left;">Total Call = <?php echo $totalcountry; ?></th>
</tr>
</thead>
-->
</table>
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