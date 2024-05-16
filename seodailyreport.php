<?php require_once('header.php'); 

if(isset($_POST['submit']))
{
	$start = $_POST['fromDate'];
	$end = $_POST['toDate'].' 23:59:59';
	$end_one = $_POST['toDate'];
}
else{
	$start = date('Y-m-d');
	$end = date('Y-m-d').' 23:59:59';
	$end_one = date('Y-m-d');
}
$select_tl = "SELECT * FROM `seo_members` WHERE tl_id =0 order by member_name";
$result_tl = mysqli_query($con,$select_tl);
?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">

<div class="col-md-12">

<div class="overview-wrap">
<h2 class="title-1"> Report SEO <span style="margin-left:50px;"></span></h2>     

</div>
</div>
</div>


<input type="hidden" value="1" id="userRole" />
<div class="reports_inner_outer">
<div class="row">
    <div class="col-md-12">
        <div class="report_missed">
            <form id="classicReportForm" action="" method="post">
  <div class="row">

<div class="col-md-3">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">From Date</label>
<input id="fromDate" name="fromDate" class="form-control" type="text" value="<?php echo $start; ?>"/>
</div>
</div>

<div class="col-md-3">
<div class="form-group">
<label for="text-input" style="color:black;" class=" form-control-label">To Date</label>
<input id="toDate" name="toDate" class="form-control" data-date-format="yyyy-mm-dd" type="text" value="<?php echo $end_one; ?>"/>
</div>
</div>


				<div class="col-md-3">
				<div class="form-group">
				<label for="text-input" style="color:black;" class=" form-control-label">TL Name</label>
				
				<select id="teamId" name="teamId" class="form-control">
				<option value="null" selected="selected">Please Select</option>
				<?php while($rowtl = mysqli_fetch_array($result_tl)) { ?>
				<option value="<?php echo $rowtl['id']; ?>"><?php echo $rowtl['member_name']; ?></option>
				<?php } ?>
				</select>
			</div>
				</div>
				
				<div class="col-md-3">
				<div class="form-group">
				<label for="text-input" style="color:black;" class="form-control-label">Member Name</label>
				<select id="selectedUser" name="selectedUser" class="form-control">
				<option value="0" selected="selected">Please Select</option>
				</select>
				</div>
				</div>



			<div class="col-md-3">
			<div class="form-group">
			 <button type="submit" style="margin-top: 37px;" class="btn btn-primary btn-sm">Submit</button>
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

 <div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate">
 
 
 

<h4 class="table_title accord_icon queueHeading">Team Wise Call Reports 2021-09-18 08:00:00 To 2021-09-18 07:59:59</h4>
<table class="table manage_queue_table">
<thead>

<tr>
<th>Serial No</th>
<th>Team Lead</th>
<th>Connected</th>
<th>Missed </th>
<th>Not Connected</th>
<th>45 Seconds </th>
<th>60 Seconds </th>
<th>Total </th>
</tr>
</thead>
<tbody>
<?php $select_tl = "SELECT * FROM `seo_members` WHERE tl_id =0 order by member_name";
$result_tl = mysqli_query($con,$select_tl); 
$i=1; 
while($rowteam = mysqli_fetch_array($result_tl)) { ?>
<tr class="tr-shadow">
<td><?php echo $i; ?></td>
<td><?php echo $rowteam['member_name']; ?></td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
<?php $i++; } ?>
</tbody>
</table>

<?php 
$select_member = "SELECT * FROM `seo_members` order by member_name";
$result_member = mysqli_query($con,$select_member);
while($rowmember = mysqli_fetch_array($result_member)) { 

$select_member_tl = "SELECT * FROM `seo_members` where member_name='".$rowmember['member_name']."' order by member_name";
$result_member_tl = mysqli_query($con,$select_member_tl);
$teammember = mysqli_fetch_assoc($result_member_tl);

// while($membersss = mysqli_fetch_array($result_member_tl)){
?>
<!-- <h4 class="table_title accord_icon queueHeading"><?php if($membersss['member_name'] == $rowmember['member_name'] AND $membersss['tl_id'] == $rowmember['tl_id'] ) { echo $rowmember['member_name'].' TL Member '; } else { echo $membersss['member_name'].' TL Member '.$rowmember['member_name']; }?>   Wise Call Reports b/w 2021-09-18 08:00:00 To 2021-09-18 07:59:59</h4> -->
<h4 class="table_title accord_icon queueHeading"><?php echo $rowmember['member_name']; ?> TL Member Wise Call Reports b/w 2021-09-18 08:00:00 To 2021-09-18 07:59:59</h4>
<table class="table manage_queue_table">
<thead>

<tr>
<th>Serial No</th>
<th>TFN</th>
<th>Connected</th>
<th>Missed </th>
<th>Not Connected</th>
<th>45 Seconds </th>
<th>60 Seconds </th>
<th>Total </th>
</tr>
</thead>
<tbody>

<tr class="tr-shadow">
<td>1</td>
<td>8305224231</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>

<tr class="tr-shadow">
<td>Total</td>
<td></td>

<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
<td>0</td>
</tr>
</tbody>
</table>
<?php } //} ?>
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
<script>
$( function() {
    $( "#fromDate" ).datepicker({dateFormat: 'yy-mm-dd ',
  maxDate:'0'});
	$( "#toDate" ).datepicker({dateFormat: 'yy-mm-dd ',
  maxDate:'0'});
  } );
  
$( "select[name='teamId']" ).change(function () {
    var clientsID = $(this).val();


    if(clientsID) {


        $.ajax({
            url: "ajaxproseo.php",
            dataType: 'Json',
            data: {'id':clientsID},
            success: function(data) {
                $('select[name="selectedUser"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
            }
        });


    }
	else{
        $('select[name="selectedUser"]');
		$.each(data, function(key, value) {
                    $('select[name="selectedUser"]').append('<option value="'+ key +'">'+ value +'</option>');
                });
    }
});
  
</script>

<?php require_once('footer.php'); ?> 
 
