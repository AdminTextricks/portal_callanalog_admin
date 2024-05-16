<?php require_once('header.php'); 

$queue = "select * from cc_queue_table";
$result_queue = mysqli_query($connection,$queue);

$extension = "select * from cc_sip_buddies";
$result_extension = mysqli_query($connection,$extension);

$didquery = "select * from cc_did";
$result_did = mysqli_query($connection,$didquery);
/*
$searchQuery = " and (calldate between '".$_POST['fromDate']."' and '".$_POST['toDate']."' or
        disposition like '%".$_POST['disposition']."%' and
        call_type like '%".$_POST['call_type']."%' and 
        src like '%".$_POST['DNID']."%' and 
        did like '%".$_POST['DID']."%' and 
        dest_name like '%".$_POST['queueName']."%' and 
        extension like '%".$_POST['extension']."%' and 
        duration like '%".$_POST['duration']."%' and 
        clid like '%".$_POST['CLID']."%' ) ";
*/
$row = 1;
$rowperpage = 1000;
$empQuery = "SELECT id,calldate,disposition,src,did,dest_name,extension,duration,Recordings FROM `cdr` order by calldate limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($connection , $empQuery);
?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
   
 <h2 class="title-1"> Classic Report </h2>    

</div>
</div>
</div>

<div class="reports_inner_outer">
<div class="row">
    <div class="col-md-12">
        <div class="classic_queue_info">
          <form id="classicReportForm" name="classicreport" action="" method="post">
            <div class="row">

<div class="col-md-4">
  <div class="form-group">
    <label for="text-input" style="color:black;" class="form-control-label">From Date</label>
      <input id="fromDate" name="fromDate" class="form-control" type="text" value="<?php if(isset($_POST['fromDate'])) { echo $_POST['fromDate']; } else { echo date('Y-m-d'); } ?>"/>
   </div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Hours From*</label>
<select id="hoursFrom" name="hoursFrom" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Minutes From*</label>
<select id="minutesFrom" name="minutesFrom" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;"class=" form-control-label">To Date</label>
<input id="toDate" name="toDate" class="form-control" type="text" value="<?php if(isset($_POST['toDate'])) { echo $_POST['toDate']; } else { echo date('Y-m-d'); } ?>"/>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Hours To*</label>
<select id="hoursTo" name="hoursTo" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Minutes To*</label>
<select id="minutesTo" name="minutesTo" class="form-control"><option value="00" selected="selected">00</option><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option></select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Disposition</label>
<select id="disposition" name="disposition" class="form-control">
<option value="All" selected="selected">All</option>
<option value="ANSWERED">ANSWERED</option>
<option value="BUSY">BUSY</option>
<option value="FAILED">FAILED</option>
<option value="NO ANSWER">NO ANSWER</option>
<option value="ABANDON">ABANDON</option>
</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Call Type</label>
<select id="call_type" name="call_type" class="form-control">
<option value="All" selected="selected">All</option>
<option value="1">Inbound</option>
<option value="0">Outbound</option>

</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Queue Name</label>
<select id="queueName" name="queueName" class="form-control">

<option value="All" selected="selected">All</option>
<?php while($queuerow = mysqli_fetch_array($result_queue)) { ?>
<option value="<?php echo $queuerow['name']; ?>"><?php echo $queuerow['name']; ?></option>
<?php } ?>
</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Extension</label>
<select id="extension" name="extension" class="form-control">
<option value="All" selected="selected">All</option>

<?php while($extrow = mysqli_fetch_array($result_extension)) { ?>
<option value="<?php echo $extrow['name']; ?>"><?php echo $extrow['name']; ?></option>
<?php } ?>
</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">TFN</label>
<select id="DID" name="DID" class="form-control">
<option value="All" selected="selected">All</option>
<?php while($didrow = mysqli_fetch_array($result_did)) { ?>
<option value="<?php echo $didrow['did']; ?>"><?php echo $didrow['did']; ?></option>
<?php } ?>
</select>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Caller ID</label>
<input id="CLID" name="CLID" class="form-control" type="text" value=""/>
</div>
</div>

<div class="col-md-4">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">Dialed No.</label>
<input id="DNID" name="DNID" class="form-control" type="text" value=""/>
</div>
</div>
			<input type="hidden" name="submit" value="submitone">
			<div class="col-md-3">
			<div class="form-group">
			 <button type="button" name="submit" value="submit" onclick="sendData()" style="margin-top: 38px;" class="btn btn-primary btn-sm">Submit</button>
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
 
 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
        
            <!-- Table -->
            <table id='employee_data' class='display dataTable table manage_queue_table'>
                <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Date and Time</th>
                    <th>Status</th>
                    <!--<th>CLID</th> -->
                    <th>SRC</th>
                    <th>DID</th>
                    <th>Queue</th>
                    <th>Extension</th>
                    <th>Duration</th>
                    <th>Recording</th>
                </tr>
                </thead> 
				<?php while($rowdatas = mysqli_fetch_array($empRecords)){ ?>
				<tr>
				<td><?php echo $rowdatas['id']; ?></td>
				<td><?php echo $rowdatas['calldate']; ?></td>
				<td><?php echo $rowdatas['disposition']; ?></td>
				<td><?php echo $rowdatas['src']; ?></td>
				<td><?php echo $rowdatas['did']; ?></td>
				<td><?php echo $rowdatas['dest_name']; ?></td>
				<td><?php echo $rowdatas['extension']; ?></td>
				<td><?php echo $rowdatas['duration']; ?></td>
				<td><?php echo $rowdatas['Recordings']; ?></td>
				</tr>
				<?php } ?>
                
            </table>
        </div>
		
        </div>
        
</div>
</div>
</div>
     
		
		<br>


<script>
$(document).ready(function(){
	$('#employee_data').DataTable();
});
</script>

<?php require_once('footer.php'); ?> 
 
