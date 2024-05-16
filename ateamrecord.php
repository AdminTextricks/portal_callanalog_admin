<?php require_once('header_out.php'); 


date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['submit']))
{
	$start = $_POST['fromDate'];
	$end = $_POST['toDate'].' 23:59:59';
	$end_one = $_POST['toDate'];
}
else{
	if(isset($_GET['start']))
	{
		$start = $_GET['start'];
	$end = $_GET['end'];
	$end_one = $_GET['end'];
	}else{
	$start = date('Y-m-d');
	$end = date('Y-m-d').' 23:59:59';
	$end_one = date('Y-m-d');
	}
}

$callinguser = "select * from cc_card where username = '".$_GET['username']."'";
$result_callinguser = mysqli_query($connection,$callinguser);
while($rowcalling = mysqli_fetch_array($result_callinguser))
{
	$username = $rowcalling['username'];
	$firstname = $rowcalling['firstname'];
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
<label for="text-input" class=" form-control-label">From Date</label>
<input id="fromDate" name="fromDate" class="form-control" type="text" value="<?php echo $start; ?>"/>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label">To Date</label>
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
  
  
<center><h1><?php echo $firstname.' Team Call Report '; ?> ( Education Server ) </h1><?php echo '<br> <h3 style="color:green;">'.$start.' TO '. $end; ?></h3></center>
<hr>
&nbsp;&nbsp;
<div class="overview-wrap table_top_heading">

</div>
<div class="row">

<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title"></h4>
<table class="table manage_queue_table">
<thead>
<tr style="text-align: left;">
<th style="text-align: left;">Country Name</th>
<th style="text-align: left;">Cost ( In USD)</th>
<th style="text-align: left;">Avg. Cost ( In USD)</th>
<th style="text-align: left;">Duration ( In Seconds)</th>
<th style="text-align: left;">Avg. Duration ( In Seconds)</th>
<th style="text-align: left;">Total Call</th>
</tr>
</thead>
<tbody >

<?php 

$query_totalall = "SELECT count(cc.calledstation) as totalcountry, sum(cc.sessiontime) as totaltime, sum(cc.sessionbill) as totalcostall FROM `cc_call` cc LEFT JOIN cc_card cd ON cc.card_id = cd.id WHERE starttime BETWEEN '".$start."' AND '".$end."' AND cd.username ='".$_GET['username']."' and terminatecauseid=1 and cc.sessiontime !='0' and cc.sessionbill !='0'";
$result_totalall = mysqli_query($connection,$query_totalall);
$totalrecordss = mysqli_num_rows($result_totalall);

while($totaling = mysqli_fetch_array($result_totalall))
{
	$totalcountry = $totaling['totalcountry'];
	$totaltime = $totaling['totaltime'];
	$totalcostall = $totaling['totalcostall'];
}

$result_country = "SELECT distinct countryname,countrycode,countryprefix FROM cc_country";
 $res_call = mysqli_query($connection,$result_country);
 

while($rowcon = mysqli_fetch_array($res_call)){

$countrypre = $rowcon['countryprefix'];
$countryname = $rowcon['countryname'];

$query_waiting_call = "SELECT sum(cc.sessionbill) as amount, cc.calledstation as calledstation,sum(cc.sessiontime) as totaltime, count(cc.destination) as total FROM `cc_call` cc LEFT JOIN cc_card cd ON cc.card_id = cd.id WHERE starttime BETWEEN '".$start."' AND '".$end."' AND cd.username ='".$_GET['username']."' and terminatecauseid=1 and cc.sessiontime !='0' and cc.sessionbill !='0' and  cc.destination like '".$countrypre."%'";
$result_waiting = mysqli_query($connection , $query_waiting_call);

$totalcallrecord = mysqli_num_rows($result_waiting);
	
	while($row_wait = mysqli_fetch_array($result_waiting)) {
		
		if(count($row_wait['amount']) > 0 AND $countryname != 'Canada' AND $countryname != 'Cocos (Keeling); Islands')
	{
		
	?>
	<tr style="color:white;text-align: left;" >
		<td style="text-align: left;cursor:pointer;"><a href="ateamcountry.php?country=<?php echo $countrypre; ?>&start=<?php echo $start;?>&end=<?php echo $end; ?>&user=<?php echo $_GET['username']; ?>" ><?php echo $countryname.' '.$countrypre; ?></a></td>
		<td style="text-align: left;"><?php echo round($row_wait['amount'],3); ?></td>
		<td style="text-align: left;"><?php echo round(($row_wait['amount']/$row_wait['total']),3); ?></td>
		<td style="text-align: left;"><?php echo $row_wait['totaltime']; ?></td>
		<td style="text-align: left;"><?php echo round(($row_wait['totaltime']/$row_wait['total']),0); ?></td>
		<td style="text-align: left;"><?php echo $row_wait['total']; ?></td>
		</tr>
		<?php }   } }  ?>

</tbody>
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