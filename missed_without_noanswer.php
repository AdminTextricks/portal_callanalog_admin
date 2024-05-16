<?php require_once('header.php');


$fromdate = $_POST['fromDate'];
$todate = $_POST['toDate'];

if(isset($_POST['submit']))
{
	$select_did = "select distinct did from cdr where calldate between '".$fromdate."' and '".$todate." 23:59:59' and did != ''";
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
<label for="text-input" class=" form-control-label">From Date</label>
<input id="fromDate" name="fromDate" autocomplete="off" class="form-control" type="text" value="<?php echo date('Y-m-d'); ?>"/>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label">Hours From*</label>
<select id="hoursFrom" name="hoursFrom" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label">Minutes From*</label>
<select id="minutesFrom" name="minutesFrom" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label">To Date</label>
<input id="toDate" name="toDate" class="form-control" type="text" value="<?php echo date('Y-m-d'); ?>"/>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label">Hours To*</label>
<select id="hoursTo" name="hoursTo" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" class=" form-control-label">Minutes To*</label>
<select id="minutesTo" name="minutesTo" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
</div>
</div>


			<div class="col-md-3">
			<div class="form-group">
			 <button type="submit" name="submit" value="submit" style="margin-top: 37px;" class="btn btn-primary btn-sm">Submit</button>
			</div>
    </div>
			<p></p>
    </div>
</form>
			
        </div>
    </div>
    </div>
  </div>
	
	
<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate" style="overflow: scroll;">
<table id="queueTable" class="table manage_queue_table">
<thead>

<tr style="background-color:gray;color:white;">
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
while($rowdid = mysqli_fetch_array($resultdid))
	{
		
		$didno = $rowdid['did'];
$fromtime = array("09:30","10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30","18:30","19:30","20:30","21:30","22:30","23:30","00:30","01:30","02:30","03:30","04:30","05:30","06:30","07:30","08:30");
$totime = array("10:30","11:30","12:30","13:30","14:30","15:30","16:30","17:30","18:30","19:30","20:30","21:30","22:30","23:30","00:30","01:30","02:30","03:30","04:30","05:30","06:30","07:30","08:30","09:30");	
	
$querytotaldid =  "select count(did) as totalnumber from cdr where did='".$didno."' and calldate between '".$fromdate."' and '".$todate." 23:59:59'";
$resultdidcount = mysqli_query($connection,$querytotaldid);
$totaldidnumbercount = mysqli_fetch_assoc($resultdidcount);	

?>
<tr>
<td style="background-color:gray;color:white;text-align:left;"><?php echo $j; ?></td>
<td style="background-color:gray;color:white;text-align:left;" ><?php echo $didno; ?></td>
<?php for($i=0;$i<count($fromtime);$i++)
{
	$querydata =  "select count(did) as totalcount from cdr where did='".$didno."' and calldate between '".$fromdate.' '.$fromtime[$i]."' and '".$todate.' '.$totime[$i]."'";
	$resultcount = mysqli_query($connection,$querydata);
	
	while($rowcount = mysqli_fetch_array($resultcount))
	{ ?>
<td><?php echo $rowcount['totalcount']; ?></td>
 <?php
}
} 
?>
<td style="background-color:gray;color:white;"><?php echo $totaldidnumbercount['totalnumber']; ?></td>
</tr>
 <?php
//}
// }
$j++;
}
?>


</tbody>
</table>
</div>

 
</div>
</div>
	


</div>
</div>

<!-- footer section start here -->
<div class="copyright">
<p>Copyright Â© 2020 PBX. All rights reserved.</p>
</div>
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

