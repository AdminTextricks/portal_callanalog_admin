<?php require_once('header_out.php');


date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['submit'])) {
	$start = $_POST['fromDate'];
	$end = $_POST['toDate'] . ' 23:59:59';
	$end_one = $_POST['toDate'];
} else {
	$start = date('Y-m-d');
	$end = date('Y-m-d') . ' 23:59:59';
	$end_one = date('Y-m-d');
}

?>

<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">

			<div class="reports_inner_outer" style="background-color:gray">
				<div class="row">
					<div class="col-md-12">
						<div class="report_missed">
							<form id="classicReportForm" name="reports" action="" method="post">
								<div class="row" style="padding-left:400px;">

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label">From Date</label>
											<input id="fromDate" name="fromDate" class="form-control" type="text"
												value="<?php echo $start; ?>" />
										</div>
									</div>

									<div class="col-md-3">
										<div class="form-group">
											<label for="text-input" class=" form-control-label">To Date</label>
											<input id="toDate" name="toDate" class="form-control"
												data-date-format="yyyy-mm-dd" type="text"
												value="<?php echo $end_one; ?>" />
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<button type="submit" name="submit" value="submit" style="margin-top: 47px;"
												class="btn btn-primary btn-sm">Submit</button>
										</div>
									</div>
									<p></p>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>

			<center>
				<h1>Team Wise Call Reports ( Education Server ) </h1>
				<?php if (isset($_POST['submit'])) {
					echo '<br> <h3>' . $start . ' TO ' . $end;
				} else {
					echo '<br> <h3>' . $start . ' TO ' . $end;
					;
				} ?>
				</h3>
			</center>
			<hr>
			<div class="overview-wrap table_top_heading">
				<a href="http://edu.bigpbx.com/biglivescall/callblast.php">
					<button class="au-btn au-btn-icon au-btn--blue">
						<i class="fa fa-phone"></i>Schedule Call</button></a>
				&nbsp;&nbsp;
				<a href="http://travel.bigpbx.com/biglivescall/biglives_que.php">
					<button class="au-btn au-btn-icon au-btn--blue">
						<i class="fa fa-phone"></i>Queue Lives</button></a>
				&nbsp;&nbsp;
				<a href="http://travel.bigpbx.com/biglivescall/biglives_que.php">
					<button class="au-btn au-btn-icon au-btn--blue">
						<i class="fa fa-phone"></i>Big Lives</button></a>
			</div>

			<div class="row">

				<div class="col-md-12">

					<div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
						<h4 class="table_title"></h4>
						<table class="table manage_queue_table">
							<thead>
								<tr style="text-align: left;">
									<th style="text-align: left;">Serial</th>
									<th style="text-align: left;">Team Name</th>
									<th style="text-align: left;">Duration ( In Seconds)</th>
									<th style="text-align: left;">Duration ( In minute)</th>
									<th style="text-align: left;">Total Cost (In USD)</th>
									<th style="text-align: left;">Total Call </th>
								</tr>
							</thead>
							<tbody>

								<?php
								$select_query = "select username,credit from cc_card where username in (25513,16257,15653,20621,14144,28928,10936,29938,45868,11227,26079,28547,11042,15140,13819,20884,17228,14144,56961,15123,28871)";
								$result_cccard = mysqli_query($connection, $select_query);
								$i = 1;
								$totalseries = mysqli_num_rows($result_cccard);

								while ($rowcard = mysqli_fetch_array($result_cccard)) {

									$query_waiting_totalcall = "SELECT SUM( cc.sessiontime ) AS totalsecond, SUM( cc.sessionbill ) AS totalamount, cd.firstname AS firstname, count(cc.sessiontime) as totalnofcall FROM `cc_call` cc LEFT JOIN cc_card cd ON cc.card_id = cd.id WHERE starttime BETWEEN '" . $start . "' AND '" . $end . "'";
									$result_totalcall = mysqli_query($connection, $query_waiting_totalcall);
									$totalresult = mysqli_fetch_assoc($result_totalcall);

									$query_waiting_call = "SELECT SUM( cc.sessiontime ) AS totalsecond, SUM( cc.sessionbill ) AS totalamount, cd.firstname AS firstname, count(cc.sessiontime) as totalnofcall FROM `cc_call` cc LEFT JOIN cc_card cd ON cc.card_id = cd.id WHERE starttime BETWEEN '" . $start . "' AND '" . $end . "' AND cd.username ='" . $rowcard['username'] . "'";
									$result_waiting = mysqli_query($connection, $query_waiting_call);

									while ($row_wait = mysqli_fetch_array($result_waiting)) {

										?>
										<tr style="color:white;text-align: left;">
											<td style="text-align: left;">
												<?php echo $i; ?>
											</td>
											<td style="text-align: left;cursor:pointer;"
												title="<?php echo $rowcard['credit'] . ' USD'; ?>"><a
													href="acallrecord.php?username=<?php echo $rowcard['username']; ?>&start=<?php echo $start; ?>&end=<?php echo $end; ?>">
													<?php echo $row_wait['firstname'] . ' Team'; ?>
												</a></td>
											<td style="text-align: left;">
												<?php if (count($row_wait['totalsecond']) > 0) {
													echo $row_wait['totalsecond'];
												} else {
													echo '0';
												} ?>
											</td>
											<td style="text-align: left;">
												<?php echo floor(($row_wait['totalsecond'] / 60)) . ':' . $row_wait['totalsecond'] % 60; ?>
											</td>
											<td style="text-align: left;">
												<?php echo round($row_wait['totalamount'], 2); ?>
											</td>
											<td style="text-align: left;">
												<?php echo round($row_wait['totalnofcall'], 2); ?>
											</td>
										</tr>
									<?php }
									$i++;
								} ?>

							</tbody>
							<thead>
								<tr style="text-align: left;background-color:yellow;">
									<th style="text-align: left;">Total =
										<?php echo $totalseries; ?>
									</th>
									<th style="text-align: left;">Total Team =
										<?php echo $totalseries; ?>
									</th>
									<th style="text-align: left;">Total Duration ( In Seconds )=
										<?php echo $totalresult['totalsecond']; ?>
									</th>
									<th style="text-align: left;">Total Duration ( In Minutes )=
										<?php echo floor(($totalresult['totalsecond'] / 60)) . ':' . $totalresult['totalsecond'] % 60; ?>
									</th>
									<th style="text-align: left;">Total Cost ( In USD ) =
										<?php echo round($totalresult['totalamount'], 3); ?>
									</th>
									<th style="text-align: left;">Total Call =
										<?php echo $totalresult['totalnofcall']; ?>
									</th>
								</tr>
							</thead>
						</table>
						<p><br></p>
						<h4 class="table_title">Saparate Team URL Link</h4>
						<table class="table manage_queue_table">
							<thead>
								<tr style="text-align: left;">
									<th style="text-align: left;">Serial</th>
									<th style="text-align: left;">Team Name</th>
									<th style="text-align: left;"> URL Link </th>
								</tr>
							</thead>
							<tbody>
								<?php
								$select_query_link = "select username,credit,firstname from cc_card where username in (25513,16257,15653,20621,14144,28928,10936,29938,45868,11227,26079,28547,11042,15140,13819,20884,17228,14144,56961,15123,28871)";
								$result_cccard_link = mysqli_query($connection, $select_query_link);

								$j = 1;
								while ($row_link = mysqli_fetch_array($result_cccard_link)) {
									?>
									<tr style="color:white;text-align: left;">
										<td style="text-align: left;">
											<?php echo $j; ?>
										</td>
										<td style="text-align: left;cursor:pointer;"
											title="<?php echo $row_link['firstname']; ?>">
											<?php echo $row_link['firstname'] . ' Team'; ?>
										</td>
										<td style="text-align:left;">
											<?php echo 'http://edu.bigpbx.com/bigpbxnew/bigpbx/ateamrecord.php?username=' . $row_link['username']; ?>
										</td>
									</tr>
									<?php $j++;
								} ?>
							</tbody>
						</table>

					</div>
				</div>
			</div>

			<script>
				$(function () {
					$("#fromDate").datepicker({
						dateFormat: 'yy-mm-dd ',
						maxDate: '0'
					});
					$("#toDate").datepicker({
						dateFormat: 'yy-mm-dd ',
						maxDate: '0'
					});
				});
			</script>