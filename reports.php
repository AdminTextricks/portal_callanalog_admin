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
<div class="overview-wrap table_top_heading">
    

</div>
</div>
</div>


<div class="big_live_outer big_live_sec">
<div class="row">
    <div class="col-sm-12">
        <ul class="report_list">
    <li class="report_bg_blue">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="classicreport.php">
            <div class="repost_ico">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Classic Report</h3>
            </div>
            </a>
        </div>
    </li>
     
    <li class="report_bg_red">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="missed.php">
            <div class="repost_ico">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Missed Report</h3>
            </div>
            </a>
        </div>
    </li>

   <!-- <li class="report_bg_green">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="tfnreport.php">
            <div class="repost_ico">
                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">TFN Report</h3>
            </div>
            </a>
        </div>
    </li>

    <li class="report_bg_blue_dark">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="agentsreport.php">
            <div class="repost_ico">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Agent Report</h3>
            </div>
            </a>
        </div>
    </li>

    <li class="report_bg_yellow">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="callcountreport.php">
            <div class="repost_ico">
                <i class="fa fa-hourglass-half" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Call Count Report</h3>
            </div>
            </a>
        </div>
    </li>

    <li class="report_bg_yellow">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="agentprodreport.php">
            <div class="repost_ico">
                <i class="fa fa-hourglass-half" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Agent Productivity Report</h3>
            </div>
            </a>
        </div>
    </li>
    
    
  <?php if($currentlogin_userrole == 1 AND $currentlogin_useridss == 1){ ?>
	  
	
	<li class="report_bg_blue_dark">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="showagent.php">
            <div class="repost_ico">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Show Agents</h3>
            </div>
            </a>
        </div>
    </li>
	
	<li class="report_bg_red">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="showseomembers.php">
            <div class="repost_ico">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">SEO Members</h3>
            </div>
            </a>
        </div>
    </li>

    <li class="report_bg_green">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="seotfn.php">
            <div class="repost_ico">
                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">SEO TFNs</h3>
            </div>
            </a>
        </div>
    </li>
	
	<li class="report_bg_blue">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="seodailyreport.php">
            <div class="repost_ico">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">SEO Report</h3>
            </div>
            </a>
        </div>
    </li>
	<?php } ?>
		
	<li class="report_bg_yellow">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="#">
            <div class="repost_ico">
                <i class="fa fa-hourglass-half" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">History Report</h3>
            </div>
            </a>
        </div>
    </li>

    <li class="report_bg_green">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="callbackreport.php">
            <div class="repost_ico">
                <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Callback Report</h3>
            </div>
            </a>
        </div>
    </li>

    <li class="report_bg_red">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="sitetfn.php">
            <div class="repost_ico">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Site TFNs</h3>
            </div>
            </a>
        </div>
    </li>
 
	<li class="report_bg_blue_dark">
        <div class="report_widget">
            <div class="border_div">
                <span class="border_line_1"></span>
            </div>
            <a href="masteragentsrecord.php">
            <div class="repost_ico">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <div class="report_widget_content">
                <h3 class="c_title">Agents Wise Report</h3>
            </div>
            </a>
        </div>
    </li>
   -->
    
    
</ul>
</div>
    </div>


</div>
	




</div>
</div>


</div>


</div>
</div>
			
				
<?php require_once('footer.php'); ?>