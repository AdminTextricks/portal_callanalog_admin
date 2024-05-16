<?php require_once('header.php'); 

$query_queue = "select count(*) as totalqueue from cc_queue_table";
$result_queue = mysqli_query($connection , $query_queue);
while($row_que = mysqli_fetch_row($result_queue)) {
	$totalqueue =  $row_que[0];
}

$query_ext = "select count(*) as totalext from cc_sip_buddies";
$result_ext = mysqli_query($connection , $query_ext);
while($row_ext = mysqli_fetch_row($result_ext)) {
	$totalext =  $row_ext[0];
}

$query_inbound = "select count(*) as totalinbound from cc_did";
$result_inbound = mysqli_query($connection , $query_inbound);
while($row_inbound = mysqli_fetch_row($result_inbound)) {
	$totalinbound =  $row_inbound[0];
}

$query_outbound = "select count(*) as totaloutbound from cc_trunk";
$result_outbound = mysqli_query($connection , $query_outbound);
while($row_outbound = mysqli_fetch_row($result_outbound)) {
	$totaloutbound =  $row_outbound[0];
}

$query_blacklist = "select count(*) as totalblacklist from cc_blacklist";
$result_blacklist = mysqli_query($connection , $query_blacklist);
while($row_blacklist = mysqli_fetch_row($result_blacklist)) {
	$totalblacklist =  $row_blacklist[0];
}
?>
           <div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"><i class="fa fa-podcast" aria-hidden="true"></i> TextRicks Live</h2>
</div>
</div>
</div>


<div class="big_live_outer big_live_sec">
<div class="row">
    <div class="col-md-12">
	<ul class="big_live report_list">
    <li class="report_bg_blue_dark">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="biglives.php" target="_blank">
            <div class="repost_ico">
                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">TextRicks Live</h3>
				<p>Show agent/queue monitoring. &nbsp;&nbsp;&nbsp;     </p><p>
            </p></div>
            </a>
        </div>
    </li>

    <li class="report_bg_green">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="barge.php">
            <div class="repost_ico">
                <i class="fa fa-headphones" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Call Barging</h3>
				<p>Admin can listen to the live calls</p>
            </div>
            </a>
        </div>
    </li>
	</ul>
	
      
    </div>
    </div>
</div>
</div>
</div>
				
<?php require_once('footer.php'); ?>
