<?php
require_once('header.php');

if (isset($_GET['submit'])) {
	$fromDate = $_GET['fromDate'];
	$hoursFrom = $_GET['hoursFrom'];
	$minutesFrom = $_GET['minutesFrom'];
	$fromdates = $fromDate . ' ' . $hoursFrom . ':' . $minutesFrom . ':00';

	$toDate = $_GET['toDate'];
	$hoursTo = $_GET['hoursTo'];
	$minutesTo = $_GET['minutesTo'];

	if ($hoursTo == '00') {
		$hoursTo = '23';
	} else {
		$hoursTo = $hoursTo;
	}
	if ($minutesTo == '00') {
		$minutesTo = '59';
	} else {
		$minutesTo = $minutesTo;
	}

	$todates = $toDate . ' ' . $hoursTo . ':' . $minutesTo . ':59';

	$extensions = 'and extension=' . $_GET['extension'];

	$CALLTYPE = "and call_type='0'";

	$disposition = "and disposition ='ANSWERED'";

	$extentionnumber = $_SESSION['login_user'];
	function seconds2human($ss)
	{
		$s = $ss % 60;
		$m = floor(($ss % 3600) / 60);
		$h = floor(($ss % 86400) / 3600);
		$d = floor(($ss % 2592000) / 86400);
		$M = floor($ss / 2592000);
		if ($h == 0) {
			$h = '';
		} else {
			$h = $h . ':';
		}
		return "$h$m:$s";
	}

	if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
		$page_no = $_GET['page_no'];
	} else {
		$page_no = 1;
	}

	$total_records_per_page = 25;
	$offset = ($page_no - 1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";

	$query_cdr_pagination = "SELECT count(id) FROM `cdr` where calldate between '" . $fromdates . "' and '" . $todates . "' " . $disposition . " " . $CALLTYPE . " " . $extensions . "";
	$result_queue_cdr_pagination = mysqli_query($connection, $query_cdr_pagination);

	$row_pagins = mysqli_fetch_row($result_queue_cdr_pagination);
	$total_pagins_records = $row_pagins[0];
	$total_no_of_pages = ceil($total_pagins_records / $total_records_per_page);
	$second_last = $total_no_of_pages - 1;

	$query_cdr = "SELECT * FROM `cdr` where calldate between '" . $fromdates . "' and '" . $todates . "' " . $disposition . " " . $CALLTYPE . " " . $extensions . " limit " . $offset . ", " . $total_records_per_page . "";
	$result_queue_cdr = mysqli_query($connection, $query_cdr);

}

$query_queue = "select * from cc_queue_table";
$result_queue = mysqli_query($connection, $query_queue);
if ($_SESSION['userroleforpage'] == 1) {
	$query_extension = "select * from cc_sip_buddies where agent_name!='' order by agent_name asc";
} else {
	$query_extension = "select * from cc_sip_buddies where accountcode='" . $_SESSION['login_usernames'] . "' and agent_name!='' order by agent_name asc";
}
$extenion_result = mysqli_query($connection, $query_extension);

$query_did = "select * from cc_did";
$did_result = mysqli_query($connection, $query_did);

$query_ext = "select count(*) as totalext from cc_sip_buddies";
$result_ext = mysqli_query($connection, $query_ext);
while ($row_ext = mysqli_fetch_row($result_ext)) {
	$totalext = $row_ext[0];
}

$query_inbound = "select count(*) as totalinbound from cc_did";
$result_inbound = mysqli_query($connection, $query_inbound);
while ($row_inbound = mysqli_fetch_row($result_inbound)) {
	$totalinbound = $row_inbound[0];
}

$query_outbound = "select count(*) as totaloutbound from cc_trunk";
$result_outbound = mysqli_query($connection, $query_outbound);
while ($row_outbound = mysqli_fetch_row($result_outbound)) {
	$totaloutbound = $row_outbound[0];
}

$query_blacklist = "select count(*) as totalblacklist from cc_blacklist";
$result_blacklist = mysqli_query($connection, $query_blacklist);
while ($row_blacklist = mysqli_fetch_row($result_blacklist)) {
	$totalblacklist = $row_blacklist[0];
}

$urlcode = 'fromDate=' . $_GET['fromDate'] . '&hoursFrom=' . $_GET['hoursFrom'] . '&minutesFrom=' . $_GET['minutesFrom'] . '&toDate=' . $_GET['toDate'] . '&hoursTo=' . $_GET['hoursTo'] . '&minutesTo=' . $_GET['minutesTo'] . '&call_type=0&submit=' . $_GET['submit'] . '&showRecords=' . $_GET['showRecords'] . '&pageNumber=' . $_GET['pageNumber'] . '&extension=' . $_GET['extension'] . '';

?>


<div class="main-content">
	<div class="section__content section__content--p30 page_mid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap">

						<h2 class="title-1"> Agent Productivity Reports </h2>
					</div>
				</div>
			</div>

			<div class="reports_inner_outer">
				<div class="row">
					<div class="col-md-12">
						<div class="classic_queue_info">
							<form id="classicReportForm" name="cdrreport" action="" method="get">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">From Date</label>
											<input id="fromDate" name="fromDate" class="form-control hasDatepicker"
												type="text"
												value="<?php if (count($fromDate) > 0) {
													echo $fromDate;
												} else {
													echo date('Y-m-d');
												} ?>">
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Hours
												From*</label>
											<select id="hoursFrom" name="hoursFrom" class="form-control">
												<option
													value="<?php if (count($hoursFrom) > 0) {
														echo $hoursFrom;
													} else {
														echo '00';
													} ?>">
													<?php if (count($hoursFrom) > 0) {
														echo $hoursFrom;
													} else {
														echo '00';
													} ?>
												</option>
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
												<option value="17">17</option>
												<option value="18">18</option>
												<option value="19">19</option>
												<option value="20">20</option>
												<option value="21">21</option>
												<option value="22">22</option>
												<option value="23">23</option>
											</select>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Minutes
												From*</label>
											<select id="minutesFrom" name="minutesFrom" class="form-control">
												<option
													value="<?php if (count($minutesFrom) > 0) {
														echo $minutesFrom;
													} else {
														echo '00';
													} ?>">
													<?php if (count($minutesFrom) > 0) {
														echo $minutesFrom;
													} else {
														echo '00';
													} ?>
												</option>
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
												<option value="17">17</option>
												<option value="18">18</option>
												<option value="19">19</option>
												<option value="20">20</option>
												<option value="21">21</option>
												<option value="22">22</option>
												<option value="23">23</option>
												<option value="24">24</option>
												<option value="25">25</option>
												<option value="26">26</option>
												<option value="27">27</option>
												<option value="28">28</option>
												<option value="29">29</option>
												<option value="30">30</option>
												<option value="31">31</option>
												<option value="32">32</option>
												<option value="33">33</option>
												<option value="34">34</option>
												<option value="35">35</option>
												<option value="36">36</option>
												<option value="37">37</option>
												<option value="38">38</option>
												<option value="39">39</option>
												<option value="40">40</option>
												<option value="41">41</option>
												<option value="42">42</option>
												<option value="43">43</option>
												<option value="44">44</option>
												<option value="45">45</option>
												<option value="46">46</option>
												<option value="47">47</option>
												<option value="48">48</option>
												<option value="49">49</option>
												<option value="50">50</option>
												<option value="51">51</option>
												<option value="52">52</option>
												<option value="53">53</option>
												<option value="54">54</option>
												<option value="55">55</option>
												<option value="56">56</option>
												<option value="57">57</option>
												<option value="58">58</option>
												<option value="59">59</option>
											</select>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">To Date</label>
											<input id="toDate" name="toDate" class="form-control hasDatepicker"
												type="text"
												value="<?php if (count($toDate) > 0) {
													echo $toDate;
												} else {
													echo date('Y-m-d');
												} ?>">
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Hours To*</label>
											<select id="hoursTo" name="hoursTo" class="form-control">
												<option
													value="<?php if (count($hoursTo) > 0) {
														echo $hoursTo;
													} else {
														echo '00';
													} ?>">
													<?php if (count($hoursTo) > 0) {
														echo $hoursTo;
													} else {
														echo '00';
													} ?>
												</option>
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
												<option value="17">17</option>
												<option value="18">18</option>
												<option value="19">19</option>
												<option value="20">20</option>
												<option value="21">21</option>
												<option value="22">22</option>
												<option value="23">23</option>
											</select>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Minutes
												To*</label>
											<select id="minutesTo" name="minutesTo" class="form-control">
												<option
													value="<?php if (count($minutesTo) > 0) {
														echo $minutesTo;
													} else {
														echo '00';
													} ?>">
													<?php if (count($minutesTo) > 0) {
														echo $minutesTo;
													} else {
														echo '00';
													} ?>
												</option>
												<option value="01">01</option>
												<option value="02">02</option>
												<option value="03">03</option>
												<option value="04">04</option>
												<option value="05">05</option>
												<option value="06">06</option>
												<option value="07">07</option>
												<option value="08">08</option>
												<option value="09">09</option>
												<option value="10">10</option>
												<option value="11">11</option>
												<option value="12">12</option>
												<option value="13">13</option>
												<option value="14">14</option>
												<option value="15">15</option>
												<option value="16">16</option>
												<option value="17">17</option>
												<option value="18">18</option>
												<option value="19">19</option>
												<option value="20">20</option>
												<option value="21">21</option>
												<option value="22">22</option>
												<option value="23">23</option>
												<option value="24">24</option>
												<option value="25">25</option>
												<option value="26">26</option>
												<option value="27">27</option>
												<option value="28">28</option>
												<option value="29">29</option>
												<option value="30">30</option>
												<option value="31">31</option>
												<option value="32">32</option>
												<option value="33">33</option>
												<option value="34">34</option>
												<option value="35">35</option>
												<option value="36">36</option>
												<option value="37">37</option>
												<option value="38">38</option>
												<option value="39">39</option>
												<option value="40">40</option>
												<option value="41">41</option>
												<option value="42">42</option>
												<option value="43">43</option>
												<option value="44">44</option>
												<option value="45">45</option>
												<option value="46">46</option>
												<option value="47">47</option>
												<option value="48">48</option>
												<option value="49">49</option>
												<option value="50">50</option>
												<option value="51">51</option>
												<option value="52">52</option>
												<option value="53">53</option>
												<option value="54">54</option>
												<option value="55">55</option>
												<option value="56">56</option>
												<option value="57">57</option>
												<option value="58">58</option>
												<option value="59">59</option>
											</select>
										</div>
									</div>


									<div class="col-md-4">
										<div class="form-group">
											<label for="text-input" class=" form-control-label"
												style="color:black;margin-left:0px;font-weight:bold;">Extension</label>
											<select id="extension" name="extension" class="form-control">
												<?php while ($extrow = mysqli_fetch_array($extenion_result)) { ?>
													<option <?php if ($_GET['extension'] == $extrow['name']) {
														echo 'selected="selected"';
													} else {
														echo '';
													} ?>
														value="<?php echo $extrow['name']; ?>">
														<?php echo '(' . $extrow['agent_name'] . ') ' . $extrow['name']; ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>


									<div class="col-md-3">
										<div class="form-group">
											<button type="submit" style="margin-top: 38px;" name="submit" value="submit"
												class="btn btn-primary btn-sm">Submit</button>
										</div>
									</div>
									<p></p>

								</div>
								<input id="showRecords" name="showRecords" type="hidden" value="10">
								<input id="pageNumber" name="pageNumber" type="hidden" value="1">
							</form>

						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-md-12">
					<div class="overview-wrap custom_show">
						&nbsp;
					</div>


					<div
						class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate report_claasic_tble">
						<table id="queueTable" class="table manage_queue_table">
							<thead>

								<tr>
									<th>Serial No</th>
									<th>Date and Time</th>
									<th>Extension</th>
									<th>Type</th>
									<th>DNID</th>
									<th>Caller Id</th>
									<th>Duration</th>
									<th>Call Gap( seconds)</th>
								</tr>
							</thead>

							<tbody>
								<?php if (mysqli_num_rows($result_queue_cdr) > 0) { ?>
									<tr class="tr-shadow">
										<?php
										$i = 1;
										while ($row_cdr = mysqli_fetch_array($result_queue_cdr)) {

											?>
											<td>
												<?php echo $i; ?>
											</td>
											<td>
												<?php echo $row_cdr['calldate']; ?>
											</td>
											<td>
												<?php echo $row_cdr['extension']; ?>
											</td>
											<td>
												<?php if ($row_cdr['call_type'] == '0') {
													echo 'Outbound';
												} else {
													echo 'Inbound';
												} ?>
											</td>
											<td>
												<?php echo '******' . substr($row_cdr['dst'], -4); ?>
											</td>
											<td>
												<?php echo $row_cdr['src']; ?>
											</td>
											<td>
												<?php echo seconds2human($row_cdr['duration']); ?>
											</td>
											<td>
												<?php echo $row_cdr['hour']; ?>
											</td>
										</tr>
										<?php $i++;
										}
								} else { ?>

									<tr>
										<td> </td>
										<td> </td>
										<td> </td>
										<td style="color:red;font-size:20px;">No data found </td>
										<td> </td>
										<td> </td>
										<td> </td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

					<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
						<strong>Showing
							<?php echo $page_no . " of " . $total_no_of_pages; ?>
						</strong>
					</div>

					<ul class="pagination">
						<?php if ($page_no > 1) {
							echo "<li><a href='?$urlcode&page_no=1'>First Page</a></li>";
						} ?>

						<li <?php if ($page_no <= 1) {
							echo "class='disabled'";
						} ?>>
							<a <?php if ($page_no > 1) {
								echo "href='?$urlcode&page_no=$previous_page'";
							} ?>>Previous</a>
						</li>

						<?php
						if ($total_no_of_pages <= 10) {
							for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
								if ($counter == $page_no) {
									echo "<li class='active'><a>$counter</a></li>";
								} else {
									echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
								}
							}
						} elseif ($total_no_of_pages > 10) {

							if ($page_no <= 4) {
								for ($counter = 1; $counter < 8; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
								echo "<li><a>...</a></li>";
								echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
								echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
								echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
								echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
								echo "<li><a>...</a></li>";
								for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
								echo "<li><a>...</a></li>";
								echo "<li><a href='?$urlcode&page_no=$second_last'>$second_last</a></li>";
								echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
							} else {
								echo "<li><a href='?$urlcode&page_no=1'>1</a></li>";
								echo "<li><a href='?$urlcode&page_no=2'>2</a></li>";
								echo "<li><a>...</a></li>";

								for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
									if ($counter == $page_no) {
										echo "<li class='active'><a>$counter</a></li>";
									} else {
										echo "<li><a href='?$urlcode&page_no=$counter'>$counter</a></li>";
									}
								}
							}
						}
						?>

						<li <?php if ($page_no >= $total_no_of_pages) {
							echo "class='disabled'";
						} ?>>
							<a <?php if ($page_no < $total_no_of_pages) {
								echo "href='?$urlcode&page_no=$next_page'";
							} ?>>Next</a>
						</li>
						<?php if ($page_no < $total_no_of_pages) {
							echo "<li><a href='?$urlcode&page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
						} ?>
					</ul>

				</div>
			</div>

			<!-- code will write here start-->


			<!-- code will write here end -->

		</div>
	</div>
</div>
<?php require_once('footer.php'); ?>