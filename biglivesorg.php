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

<input type="hidden" id="userId" value="2">			
<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">

<h2 class="title-1">Queue Summary</h2>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
   <!-- <h4 class="table_title">Careerera PPC</h4> -->
<table class="table manage_queue_table">
<thead>
<tr>
<th>Queue</th>
<th>Queue Name</th>
<th>Customer Name</th>
<th>Inbound/Outbound</th>
<th>Paused/Total</th>
<th>Calls Waiting</th>
<th>Total Calls</th>
<th>Abandoned Calls</th>
<th>Last Update Time</th>
</tr>
</thead>
<tbody>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>80001</td>
<td>IT_TESTQUEUE</td>
<td>Admin </td>
<td class="desc" id="outin-80001">0/0</td>
<td>0/0</td>
<td id="waiting-80001">0</td>
<td id="80001-totalCalls">0</td>
<td id="80001-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5515</td>
<td>Travel US Sales</td>
<td>Admin </td>
<td class="desc" id="outin-5515">0/0</td>
<td>39/58</td>
<td id="waiting-5515">0</td>
<td id="5515-totalCalls">0</td>
<td id="5515-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5517</td>
<td>Travel Ticketing US</td>
<td>Admin </td>
<td class="desc" id="outin-5517">0/0</td>
<td>2/10</td>
<td id="waiting-5517">0</td>
<td id="5517-totalCalls">0</td>
<td id="5517-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5519</td>
<td>Travomint</td>
<td>Admin </td>
<td class="desc" id="outin-5519">0/0</td>
<td>0/17</td>
<td id="waiting-5519">0</td>
<td id="5519-totalCalls">0</td>
<td id="5519-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5503</td>
<td>Metropolitanu</td>
<td>Admin </td>
<td class="desc" id="outin-5503">0/0</td>
<td>0/1</td>
<td id="waiting-5503">0</td>
<td id="5503-totalCalls">0</td>
<td id="5503-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5516</td>
<td>Travel USA Sales</td>
<td>Admin </td>
<td class="desc" id="outin-5516">0/0</td>
<td>0/0</td>
<td id="waiting-5516">0</td>
<td id="5516-totalCalls">0</td>
<td id="5516-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5518</td>
<td>Travel Ticketing UK</td>
<td>Admin </td>
<td class="desc" id="outin-5518">0/0</td>
<td>0/0</td>
<td id="waiting-5518">0</td>
<td id="5518-totalCalls">0</td>
<td id="5518-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>0099</td>
<td>SNVA US Gov</td>
<td>Admin </td>
<td class="desc" id="outin-0099">0/0</td>
<td>0/5</td>
<td id="waiting-0099">0</td>
<td id="0099-totalCalls">0</td>
<td id="0099-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5551</td>
<td>5551</td>
<td>Admin </td>
<td class="desc" id="outin-5551">0/0</td>
<td>5/5</td>
<td id="waiting-5551">0</td>
<td id="5551-totalCalls">0</td>
<td id="5551-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5513</td>
<td>Travel Spanish 2nd Floor</td>
<td>Admin </td>
<td class="desc" id="outin-5513">0/0</td>
<td>0/1</td>
<td id="waiting-5513">0</td>
<td id="5513-totalCalls">0</td>
<td id="5513-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5544</td>
<td>ReservationsDeal CustomerCare</td>
<td>Admin </td>
<td class="desc" id="outin-5544">0/0</td>
<td>0/4</td>
<td id="waiting-5544">0</td>
<td id="5544-totalCalls">0</td>
<td id="5544-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5505</td>
<td>Travel Spanish</td>
<td>Admin </td>
<td class="desc" id="outin-5505">0/0</td>
<td>0/6</td>
<td id="waiting-5505">0</td>
<td id="5505-totalCalls">0</td>
<td id="5505-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5520</td>
<td>BookSavvy</td>
<td>Admin </td>
<td class="desc" id="outin-5520">0/0</td>
<td>0/1</td>
<td id="waiting-5520">0</td>
<td id="5520-totalCalls">0</td>
<td id="5520-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>4551</td>
<td>Airlines</td>
<td>Admin </td>
<td class="desc" id="outin-4551">0/0</td>
<td>0/10</td>
<td id="waiting-4551">0</td>
<td id="4551-totalCalls">0</td>
<td id="4551-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5540</td>
<td>Cyber Zoom Lab</td>
<td>Admin </td>
<td class="desc" id="outin-5540">0/0</td>
<td>0/0</td>
<td id="waiting-5540">0</td>
<td id="5540-totalCalls">0</td>
<td id="5540-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5502</td>
<td>Learningua</td>
<td>Admin </td>
<td class="desc" id="outin-5502">0/0</td>
<td>0/0</td>
<td id="waiting-5502">0</td>
<td id="5502-totalCalls">0</td>
<td id="5502-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5530</td>
<td>Hiremavens and J&B</td>
<td>Admin </td>
<td class="desc" id="outin-5530">0/0</td>
<td>0/0</td>
<td id="waiting-5530">0</td>
<td id="5530-totalCalls">0</td>
<td id="5530-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>6609</td>
<td>6609</td>
<td>Admin </td>
<td class="desc" id="outin-6609">0/0</td>
<td>0/7</td>
<td id="waiting-6609">0</td>
<td id="6609-totalCalls">0</td>
<td id="6609-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


<tr class="spacer"></tr>
<tr class="tr-shadow">

<td>5559</td>
<td>SingleIVR</td>
<td>Admin </td>
<td class="desc" id="outin-5559">0/0</td>
<td>0/1</td>
<td id="waiting-5559">0</td>
<td id="5559-totalCalls">0</td>
<td id="5559-abandonCall">0</td>
<td class="lastTime">--</td>
</tr>


</tbody>
</table>
</div>
</div>
</div>
<input type="hidden" value="80001,5515,5517,5519,5503,5516,5518,0099,5551,5513,5544,5505,5520,4551,5540,5502,5530,6609,5559," id="queueNumbers" />
<div class="row">
<div class="col-md-12">
<div class="overview-wrap">


<h2 class="title-1">Waiting Status</h2>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title"></h4>
<table class="table manage_queue_table">
<thead>
<tr>
<th>Queue Name</th>
<th>TFN</th>
<th>Duration</th>
<th>CLID</th>
<th>Action</th>
</tr>
</thead>
<tbody id="callWaiting">



</tbody>
</table>
</div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">


<h2 class="title-1">Agent Status</h2>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> IT_TESTQUEUE</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travel US Sales</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-510">Sherry </td>
<td class="desc">510</td>
<td class="duration" id="duration-5515-510">--</td>
<td class="did" id="did-5515-510">--</td>
<td class="clid" id="clid-5515-510">--</td>
<td class="status" id="status-5515-510">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-510">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-523">Kevin </td>
<td class="desc">523</td>
<td class="duration" id="duration-5515-523">--</td>
<td class="did" id="did-5515-523">--</td>
<td class="clid" id="clid-5515-523">--</td>
<td class="status" id="status-5515-523">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-523">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-541">Abdiel </td>
<td class="desc">541</td>
<td class="duration" id="duration-5515-541">--</td>
<td class="did" id="did-5515-541">--</td>
<td class="clid" id="clid-5515-541">--</td>
<td class="status" id="status-5515-541">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-541">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-525">Jonathan </td>
<td class="desc">525</td>
<td class="duration" id="duration-5515-525">--</td>
<td class="did" id="did-5515-525">--</td>
<td class="clid" id="clid-5515-525">--</td>
<td class="status" id="status-5515-525">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-525">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-526">Harold </td>
<td class="desc">526</td>
<td class="duration" id="duration-5515-526">--</td>
<td class="did" id="did-5515-526">--</td>
<td class="clid" id="clid-5515-526">--</td>
<td class="status" id="status-5515-526">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-526">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-527">Grey </td>
<td class="desc">527</td>
<td class="duration" id="duration-5515-527">--</td>
<td class="did" id="did-5515-527">--</td>
<td class="clid" id="clid-5515-527">--</td>
<td class="status" id="status-5515-527">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-527">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-528">Emmanuel </td>
<td class="desc">528</td>
<td class="duration" id="duration-5515-528">--</td>
<td class="did" id="did-5515-528">--</td>
<td class="clid" id="clid-5515-528">--</td>
<td class="status" id="status-5515-528">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-528">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-540">Dwayne </td>
<td class="desc">540</td>
<td class="duration" id="duration-5515-540">--</td>
<td class="did" id="did-5515-540">--</td>
<td class="clid" id="clid-5515-540">--</td>
<td class="status" id="status-5515-540">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-540">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-531">Mary </td>
<td class="desc">531</td>
<td class="duration" id="duration-5515-531">--</td>
<td class="did" id="did-5515-531">--</td>
<td class="clid" id="clid-5515-531">--</td>
<td class="status" id="status-5515-531">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-531">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-539">Jaydon </td>
<td class="desc">539</td>
<td class="duration" id="duration-5515-539">--</td>
<td class="did" id="did-5515-539">--</td>
<td class="clid" id="clid-5515-539">--</td>
<td class="status" id="status-5515-539">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-539">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-522">Michelle </td>
<td class="desc">522</td>
<td class="duration" id="duration-5515-522">--</td>
<td class="did" id="did-5515-522">--</td>
<td class="clid" id="clid-5515-522">--</td>
<td class="status" id="status-5515-522">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-522">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-521">Micheal </td>
<td class="desc">521</td>
<td class="duration" id="duration-5515-521">--</td>
<td class="did" id="did-5515-521">--</td>
<td class="clid" id="clid-5515-521">--</td>
<td class="status" id="status-5515-521">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-521">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-520">Essence  </td>
<td class="desc">520</td>
<td class="duration" id="duration-5515-520">--</td>
<td class="did" id="did-5515-520">--</td>
<td class="clid" id="clid-5515-520">--</td>
<td class="status" id="status-5515-520">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-520">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-518">Fred </td>
<td class="desc">518</td>
<td class="duration" id="duration-5515-518">--</td>
<td class="did" id="did-5515-518">--</td>
<td class="clid" id="clid-5515-518">--</td>
<td class="status" id="status-5515-518">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-518">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-517">Noah </td>
<td class="desc">517</td>
<td class="duration" id="duration-5515-517">--</td>
<td class="did" id="did-5515-517">--</td>
<td class="clid" id="clid-5515-517">--</td>
<td class="status" id="status-5515-517">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-517">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-544">Shane </td>
<td class="desc">544</td>
<td class="duration" id="duration-5515-544">--</td>
<td class="did" id="did-5515-544">--</td>
<td class="clid" id="clid-5515-544">--</td>
<td class="status" id="status-5515-544">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-544">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-545">Gauge </td>
<td class="desc">545</td>
<td class="duration" id="duration-5515-545">--</td>
<td class="did" id="did-5515-545">--</td>
<td class="clid" id="clid-5515-545">--</td>
<td class="status" id="status-5515-545">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-545">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-511">Davin </td>
<td class="desc">511</td>
<td class="duration" id="duration-5515-511">--</td>
<td class="did" id="did-5515-511">--</td>
<td class="clid" id="clid-5515-511">--</td>
<td class="status" id="status-5515-511">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-511">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-512">Austin </td>
<td class="desc">512</td>
<td class="duration" id="duration-5515-512">--</td>
<td class="did" id="did-5515-512">--</td>
<td class="clid" id="clid-5515-512">--</td>
<td class="status" id="status-5515-512">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5515-512">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-718">Fred_2ndline </td>
<td class="desc">718</td>
<td class="duration" id="duration-5515-718">--</td>
<td class="did" id="did-5515-718">--</td>
<td class="clid" id="clid-5515-718">--</td>
<td class="status" id="status-5515-718">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-718">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-717">Noah_2ndline </td>
<td class="desc">717</td>
<td class="duration" id="duration-5515-717">--</td>
<td class="did" id="did-5515-717">--</td>
<td class="clid" id="clid-5515-717">--</td>
<td class="status" id="status-5515-717">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-717">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-716">Sabestian_2ndline </td>
<td class="desc">716</td>
<td class="duration" id="duration-5515-716">--</td>
<td class="did" id="did-5515-716">--</td>
<td class="clid" id="clid-5515-716">--</td>
<td class="status" id="status-5515-716">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-716">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-713">Grace_2ndline </td>
<td class="desc">713</td>
<td class="duration" id="duration-5515-713">--</td>
<td class="did" id="did-5515-713">--</td>
<td class="clid" id="clid-5515-713">--</td>
<td class="status" id="status-5515-713">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-713">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-714">Hudson_2ndline </td>
<td class="desc">714</td>
<td class="duration" id="duration-5515-714">--</td>
<td class="did" id="did-5515-714">--</td>
<td class="clid" id="clid-5515-714">--</td>
<td class="status" id="status-5515-714">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-714">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-715">TRENTON_2ndline </td>
<td class="desc">715</td>
<td class="duration" id="duration-5515-715">--</td>
<td class="did" id="did-5515-715">--</td>
<td class="clid" id="clid-5515-715">--</td>
<td class="status" id="status-5515-715">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-715">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-722">Michelle_2ndline </td>
<td class="desc">722</td>
<td class="duration" id="duration-5515-722">--</td>
<td class="did" id="did-5515-722">--</td>
<td class="clid" id="clid-5515-722">--</td>
<td class="status" id="status-5515-722">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-722">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-723">Kevin_2ndline </td>
<td class="desc">723</td>
<td class="duration" id="duration-5515-723">--</td>
<td class="did" id="did-5515-723">--</td>
<td class="clid" id="clid-5515-723">--</td>
<td class="status" id="status-5515-723">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-723">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-745">Gauge_2ndline </td>
<td class="desc">745</td>
<td class="duration" id="duration-5515-745">--</td>
<td class="did" id="did-5515-745">--</td>
<td class="clid" id="clid-5515-745">--</td>
<td class="status" id="status-5515-745">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-745">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-743">Nick_2ndline </td>
<td class="desc">743</td>
<td class="duration" id="duration-5515-743">--</td>
<td class="did" id="did-5515-743">--</td>
<td class="clid" id="clid-5515-743">--</td>
<td class="status" id="status-5515-743">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-743">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-740">Dwayne_2ndline </td>
<td class="desc">740</td>
<td class="duration" id="duration-5515-740">--</td>
<td class="did" id="did-5515-740">--</td>
<td class="clid" id="clid-5515-740">--</td>
<td class="status" id="status-5515-740">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-740">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-739">Jaydon_2ndline </td>
<td class="desc">739</td>
<td class="duration" id="duration-5515-739">--</td>
<td class="did" id="did-5515-739">--</td>
<td class="clid" id="clid-5515-739">--</td>
<td class="status" id="status-5515-739">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-739">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-730">Joseph_2ndline </td>
<td class="desc">730</td>
<td class="duration" id="duration-5515-730">--</td>
<td class="did" id="did-5515-730">--</td>
<td class="clid" id="clid-5515-730">--</td>
<td class="status" id="status-5515-730">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-730">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-728">Emmanuel_2ndline </td>
<td class="desc">728</td>
<td class="duration" id="duration-5515-728">--</td>
<td class="did" id="did-5515-728">--</td>
<td class="clid" id="clid-5515-728">--</td>
<td class="status" id="status-5515-728">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-728">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-727">Grey_2ndline </td>
<td class="desc">727</td>
<td class="duration" id="duration-5515-727">--</td>
<td class="did" id="did-5515-727">--</td>
<td class="clid" id="clid-5515-727">--</td>
<td class="status" id="status-5515-727">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-727">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-726">Harold_2ndline </td>
<td class="desc">726</td>
<td class="duration" id="duration-5515-726">--</td>
<td class="did" id="did-5515-726">--</td>
<td class="clid" id="clid-5515-726">--</td>
<td class="status" id="status-5515-726">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-726">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-725">Jonathan_2ndline </td>
<td class="desc">725</td>
<td class="duration" id="duration-5515-725">--</td>
<td class="did" id="did-5515-725">--</td>
<td class="clid" id="clid-5515-725">--</td>
<td class="status" id="status-5515-725">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-725">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-724">Micheal_2ndline </td>
<td class="desc">724</td>
<td class="duration" id="duration-5515-724">--</td>
<td class="did" id="did-5515-724">--</td>
<td class="clid" id="clid-5515-724">--</td>
<td class="status" id="status-5515-724">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-724">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-712">Austin_2ndline </td>
<td class="desc">712</td>
<td class="duration" id="duration-5515-712">--</td>
<td class="did" id="did-5515-712">--</td>
<td class="clid" id="clid-5515-712">--</td>
<td class="status" id="status-5515-712">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-712">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-711">Davin_2ndline </td>
<td class="desc">711</td>
<td class="duration" id="duration-5515-711">--</td>
<td class="did" id="did-5515-711">--</td>
<td class="clid" id="clid-5515-711">--</td>
<td class="status" id="status-5515-711">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-711">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-710">Sherry_2ndline </td>
<td class="desc">710</td>
<td class="duration" id="duration-5515-710">--</td>
<td class="did" id="did-5515-710">--</td>
<td class="clid" id="clid-5515-710">--</td>
<td class="status" id="status-5515-710">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-710">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-514">Hudson </td>
<td class="desc">514</td>
<td class="duration" id="duration-5515-514">--</td>
<td class="did" id="did-5515-514">--</td>
<td class="clid" id="clid-5515-514">--</td>
<td class="status" id="status-5515-514">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-514">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-515">TRENTON </td>
<td class="desc">515</td>
<td class="duration" id="duration-5515-515">--</td>
<td class="did" id="did-5515-515">--</td>
<td class="clid" id="clid-5515-515">--</td>
<td class="status" id="status-5515-515">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-515">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-516">Sabestian </td>
<td class="desc">516</td>
<td class="duration" id="duration-5515-516">--</td>
<td class="did" id="did-5515-516">--</td>
<td class="clid" id="clid-5515-516">--</td>
<td class="status" id="status-5515-516">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-516">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-519">empty </td>
<td class="desc">519</td>
<td class="duration" id="duration-5515-519">--</td>
<td class="did" id="did-5515-519">--</td>
<td class="clid" id="clid-5515-519">--</td>
<td class="status" id="status-5515-519">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-519">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-524">Empty </td>
<td class="desc">524</td>
<td class="duration" id="duration-5515-524">--</td>
<td class="did" id="did-5515-524">--</td>
<td class="clid" id="clid-5515-524">--</td>
<td class="status" id="status-5515-524">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-524">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-529">Empty </td>
<td class="desc">529</td>
<td class="duration" id="duration-5515-529">--</td>
<td class="did" id="did-5515-529">--</td>
<td class="clid" id="clid-5515-529">--</td>
<td class="status" id="status-5515-529">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-529">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-530">Joseph </td>
<td class="desc">530</td>
<td class="duration" id="duration-5515-530">--</td>
<td class="did" id="did-5515-530">--</td>
<td class="clid" id="clid-5515-530">--</td>
<td class="status" id="status-5515-530">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-530">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-533">empty </td>
<td class="desc">533</td>
<td class="duration" id="duration-5515-533">--</td>
<td class="did" id="did-5515-533">--</td>
<td class="clid" id="clid-5515-533">--</td>
<td class="status" id="status-5515-533">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-533">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-534">empty </td>
<td class="desc">534</td>
<td class="duration" id="duration-5515-534">--</td>
<td class="did" id="did-5515-534">--</td>
<td class="clid" id="clid-5515-534">--</td>
<td class="status" id="status-5515-534">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-534">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-535">empty </td>
<td class="desc">535</td>
<td class="duration" id="duration-5515-535">--</td>
<td class="did" id="did-5515-535">--</td>
<td class="clid" id="clid-5515-535">--</td>
<td class="status" id="status-5515-535">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-535">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-536">empty </td>
<td class="desc">536</td>
<td class="duration" id="duration-5515-536">--</td>
<td class="did" id="did-5515-536">--</td>
<td class="clid" id="clid-5515-536">--</td>
<td class="status" id="status-5515-536">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-536">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-537">empty </td>
<td class="desc">537</td>
<td class="duration" id="duration-5515-537">--</td>
<td class="did" id="did-5515-537">--</td>
<td class="clid" id="clid-5515-537">--</td>
<td class="status" id="status-5515-537">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-537">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-538">Arden </td>
<td class="desc">538</td>
<td class="duration" id="duration-5515-538">--</td>
<td class="did" id="did-5515-538">--</td>
<td class="clid" id="clid-5515-538">--</td>
<td class="status" id="status-5515-538">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-538">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-532">Cedric </td>
<td class="desc">532</td>
<td class="duration" id="duration-5515-532">--</td>
<td class="did" id="did-5515-532">--</td>
<td class="clid" id="clid-5515-532">--</td>
<td class="status" id="status-5515-532">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-532">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-542">Sandeep  </td>
<td class="desc">542</td>
<td class="duration" id="duration-5515-542">--</td>
<td class="did" id="did-5515-542">--</td>
<td class="clid" id="clid-5515-542">--</td>
<td class="status" id="status-5515-542">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-542">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-543">Nick </td>
<td class="desc">543</td>
<td class="duration" id="duration-5515-543">--</td>
<td class="did" id="did-5515-543">--</td>
<td class="clid" id="clid-5515-543">--</td>
<td class="status" id="status-5515-543">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-543">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-552">Salva </td>
<td class="desc">552</td>
<td class="duration" id="duration-5515-552">--</td>
<td class="did" id="did-5515-552">--</td>
<td class="clid" id="clid-5515-552">--</td>
<td class="status" id="status-5515-552">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-552">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5515 / Travel US Sales</td>
<td class="name" id="name-5515-513">Grace/Karl </td>
<td class="desc">513</td>
<td class="duration" id="duration-5515-513">--</td>
<td class="did" id="did-5515-513">--</td>
<td class="clid" id="clid-5515-513">--</td>
<td class="status" id="status-5515-513">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5515-513">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travel Ticketing US</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-555">Tripoversity </td>
<td class="desc">555</td>
<td class="duration" id="duration-5517-555">--</td>
<td class="did" id="did-5517-555">--</td>
<td class="clid" id="clid-5517-555">--</td>
<td class="status" id="status-5517-555">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-555">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-553">Cedric </td>
<td class="desc">553</td>
<td class="duration" id="duration-5517-553">--</td>
<td class="did" id="did-5517-553">--</td>
<td class="clid" id="clid-5517-553">--</td>
<td class="status" id="status-5517-553">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-553">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-552">Salva </td>
<td class="desc">552</td>
<td class="duration" id="duration-5517-552">--</td>
<td class="did" id="did-5517-552">--</td>
<td class="clid" id="clid-5517-552">--</td>
<td class="status" id="status-5517-552">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-552">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-551">Max </td>
<td class="desc">551</td>
<td class="duration" id="duration-5517-551">--</td>
<td class="did" id="did-5517-551">--</td>
<td class="clid" id="clid-5517-551">--</td>
<td class="status" id="status-5517-551">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-551">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-550">Max_UK </td>
<td class="desc">550</td>
<td class="duration" id="duration-5517-550">--</td>
<td class="did" id="did-5517-550">--</td>
<td class="clid" id="clid-5517-550">--</td>
<td class="status" id="status-5517-550">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-550">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-549">Vincent </td>
<td class="desc">549</td>
<td class="duration" id="duration-5517-549">--</td>
<td class="did" id="did-5517-549">--</td>
<td class="clid" id="clid-5517-549">--</td>
<td class="status" id="status-5517-549">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-549">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-548">Samual </td>
<td class="desc">548</td>
<td class="duration" id="duration-5517-548">--</td>
<td class="did" id="did-5517-548">--</td>
<td class="clid" id="clid-5517-548">--</td>
<td class="status" id="status-5517-548">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-548">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-547">Essence </td>
<td class="desc">547</td>
<td class="duration" id="duration-5517-547">--</td>
<td class="did" id="did-5517-547">--</td>
<td class="clid" id="clid-5517-547">--</td>
<td class="status" id="status-5517-547">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5517-547">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-554">empty </td>
<td class="desc">554</td>
<td class="duration" id="duration-5517-554">--</td>
<td class="did" id="did-5517-554">--</td>
<td class="clid" id="clid-5517-554">--</td>
<td class="status" id="status-5517-554">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5517-554">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5517 / Travel Ticketing US</td>
<td class="name" id="name-5517-546">empty </td>
<td class="desc">546</td>
<td class="duration" id="duration-5517-546">--</td>
<td class="did" id="did-5517-546">--</td>
<td class="clid" id="clid-5517-546">--</td>
<td class="status" id="status-5517-546">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5517-546">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travomint</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-556">empty </td>
<td class="desc">556</td>
<td class="duration" id="duration-5519-556">--</td>
<td class="did" id="did-5519-556">--</td>
<td class="clid" id="clid-5519-556">--</td>
<td class="status" id="status-5519-556">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-556">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-571">Empty </td>
<td class="desc">571</td>
<td class="duration" id="duration-5519-571">--</td>
<td class="did" id="did-5519-571">--</td>
<td class="clid" id="clid-5519-571">--</td>
<td class="status" id="status-5519-571">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-571">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-570">empty </td>
<td class="desc">570</td>
<td class="duration" id="duration-5519-570">--</td>
<td class="did" id="did-5519-570">--</td>
<td class="clid" id="clid-5519-570">--</td>
<td class="status" id="status-5519-570">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-570">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-569">Empty </td>
<td class="desc">569</td>
<td class="duration" id="duration-5519-569">--</td>
<td class="did" id="did-5519-569">--</td>
<td class="clid" id="clid-5519-569">--</td>
<td class="status" id="status-5519-569">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-569">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-568">Empty </td>
<td class="desc">568</td>
<td class="duration" id="duration-5519-568">--</td>
<td class="did" id="did-5519-568">--</td>
<td class="clid" id="clid-5519-568">--</td>
<td class="status" id="status-5519-568">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-568">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-567">TWM </td>
<td class="desc">567</td>
<td class="duration" id="duration-5519-567">--</td>
<td class="did" id="did-5519-567">--</td>
<td class="clid" id="clid-5519-567">--</td>
<td class="status" id="status-5519-567">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-567">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-566">Empty </td>
<td class="desc">566</td>
<td class="duration" id="duration-5519-566">--</td>
<td class="did" id="did-5519-566">--</td>
<td class="clid" id="clid-5519-566">--</td>
<td class="status" id="status-5519-566">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-566">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-565">TWM </td>
<td class="desc">565</td>
<td class="duration" id="duration-5519-565">--</td>
<td class="did" id="did-5519-565">--</td>
<td class="clid" id="clid-5519-565">--</td>
<td class="status" id="status-5519-565">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-565">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-564">Empty </td>
<td class="desc">564</td>
<td class="duration" id="duration-5519-564">--</td>
<td class="did" id="did-5519-564">--</td>
<td class="clid" id="clid-5519-564">--</td>
<td class="status" id="status-5519-564">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-564">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-563">Empty </td>
<td class="desc">563</td>
<td class="duration" id="duration-5519-563">--</td>
<td class="did" id="did-5519-563">--</td>
<td class="clid" id="clid-5519-563">--</td>
<td class="status" id="status-5519-563">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-563">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-562">empty </td>
<td class="desc">562</td>
<td class="duration" id="duration-5519-562">--</td>
<td class="did" id="did-5519-562">--</td>
<td class="clid" id="clid-5519-562">--</td>
<td class="status" id="status-5519-562">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-562">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-561">empty </td>
<td class="desc">561</td>
<td class="duration" id="duration-5519-561">--</td>
<td class="did" id="did-5519-561">--</td>
<td class="clid" id="clid-5519-561">--</td>
<td class="status" id="status-5519-561">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-561">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-560">empty </td>
<td class="desc">560</td>
<td class="duration" id="duration-5519-560">--</td>
<td class="did" id="did-5519-560">--</td>
<td class="clid" id="clid-5519-560">--</td>
<td class="status" id="status-5519-560">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-560">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-559">Empty </td>
<td class="desc">559</td>
<td class="duration" id="duration-5519-559">--</td>
<td class="did" id="did-5519-559">--</td>
<td class="clid" id="clid-5519-559">--</td>
<td class="status" id="status-5519-559">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-559">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-558">empty </td>
<td class="desc">558</td>
<td class="duration" id="duration-5519-558">--</td>
<td class="did" id="did-5519-558">--</td>
<td class="clid" id="clid-5519-558">--</td>
<td class="status" id="status-5519-558">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-558">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-557">empty </td>
<td class="desc">557</td>
<td class="duration" id="duration-5519-557">--</td>
<td class="did" id="did-5519-557">--</td>
<td class="clid" id="clid-5519-557">--</td>
<td class="status" id="status-5519-557">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-557">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5519 / Travomint</td>
<td class="name" id="name-5519-572">empty </td>
<td class="desc">572</td>
<td class="duration" id="duration-5519-572">--</td>
<td class="did" id="did-5519-572">--</td>
<td class="clid" id="clid-5519-572">--</td>
<td class="status" id="status-5519-572">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5519-572">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Metropolitanu</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5503 / Metropolitanu</td>
<td class="name" id="name-5503-595">Karan </td>
<td class="desc">595</td>
<td class="duration" id="duration-5503-595">--</td>
<td class="did" id="did-5503-595">--</td>
<td class="clid" id="clid-5503-595">--</td>
<td class="status" id="status-5503-595">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5503-595">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travel USA Sales</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travel Ticketing UK</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> SNVA US Gov</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0099 / SNVA US Gov</td>
<td class="name" id="name-0099-001">Vivek Singh </td>
<td class="desc">001</td>
<td class="duration" id="duration-0099-001">--</td>
<td class="did" id="did-0099-001">--</td>
<td class="clid" id="clid-0099-001">--</td>
<td class="status" id="status-0099-001">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0099-001">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0099 / SNVA US Gov</td>
<td class="name" id="name-0099-005">Shakti Gantayat </td>
<td class="desc">005</td>
<td class="duration" id="duration-0099-005">--</td>
<td class="did" id="did-0099-005">--</td>
<td class="clid" id="clid-0099-005">--</td>
<td class="status" id="status-0099-005">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0099-005">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0099 / SNVA US Gov</td>
<td class="name" id="name-0099-006">Priyamvada </td>
<td class="desc">006</td>
<td class="duration" id="duration-0099-006">--</td>
<td class="did" id="did-0099-006">--</td>
<td class="clid" id="clid-0099-006">--</td>
<td class="status" id="status-0099-006">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0099-006">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0099 / SNVA US Gov</td>
<td class="name" id="name-0099-007">Rohit kaul </td>
<td class="desc">007</td>
<td class="duration" id="duration-0099-007">--</td>
<td class="did" id="did-0099-007">--</td>
<td class="clid" id="clid-0099-007">--</td>
<td class="status" id="status-0099-007">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0099-007">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>0099 / SNVA US Gov</td>
<td class="name" id="name-0099-008">Aditya </td>
<td class="desc">008</td>
<td class="duration" id="duration-0099-008">--</td>
<td class="did" id="did-0099-008">--</td>
<td class="clid" id="clid-0099-008">--</td>
<td class="status" id="status-0099-008">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="0099-008">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> 5551</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5551 / 5551</td>
<td class="name" id="name-5551-578">Rick </td>
<td class="desc">578</td>
<td class="duration" id="duration-5551-578">--</td>
<td class="did" id="did-5551-578">--</td>
<td class="clid" id="clid-5551-578">--</td>
<td class="status" id="status-5551-578">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5551-578">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5551 / 5551</td>
<td class="name" id="name-5551-579">Harold </td>
<td class="desc">579</td>
<td class="duration" id="duration-5551-579">--</td>
<td class="did" id="did-5551-579">--</td>
<td class="clid" id="clid-5551-579">--</td>
<td class="status" id="status-5551-579">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5551-579">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5551 / 5551</td>
<td class="name" id="name-5551-580">Josh </td>
<td class="desc">580</td>
<td class="duration" id="duration-5551-580">--</td>
<td class="did" id="did-5551-580">--</td>
<td class="clid" id="clid-5551-580">--</td>
<td class="status" id="status-5551-580">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5551-580">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5551 / 5551</td>
<td class="name" id="name-5551-581">Harsh </td>
<td class="desc">581</td>
<td class="duration" id="duration-5551-581">--</td>
<td class="did" id="did-5551-581">--</td>
<td class="clid" id="clid-5551-581">--</td>
<td class="status" id="status-5551-581">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5551-581">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5551 / 5551</td>
<td class="name" id="name-5551-582">Empty </td>
<td class="desc">582</td>
<td class="duration" id="duration-5551-582">--</td>
<td class="did" id="did-5551-582">--</td>
<td class="clid" id="clid-5551-582">--</td>
<td class="status" id="status-5551-582">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">


<input type="checkbox" class="switch-input" name="agentPause" data-queuext="5551-582">

<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travel Spanish 2nd Floor</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5513 / Travel Spanish 2nd Floor</td>
<td class="name" id="name-5513-594">Hotel </td>
<td class="desc">594</td>
<td class="duration" id="duration-5513-594">--</td>
<td class="did" id="did-5513-594">--</td>
<td class="clid" id="clid-5513-594">--</td>
<td class="status" id="status-5513-594">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5513-594">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> ReservationsDeal CustomerCare</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5544 / ReservationsDeal CustomerCare</td>
<td class="name" id="name-5544-583">Empty </td>
<td class="desc">583</td>
<td class="duration" id="duration-5544-583">--</td>
<td class="did" id="did-5544-583">--</td>
<td class="clid" id="clid-5544-583">--</td>
<td class="status" id="status-5544-583">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5544-583">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5544 / ReservationsDeal CustomerCare</td>
<td class="name" id="name-5544-584">Empty </td>
<td class="desc">584</td>
<td class="duration" id="duration-5544-584">--</td>
<td class="did" id="did-5544-584">--</td>
<td class="clid" id="clid-5544-584">--</td>
<td class="status" id="status-5544-584">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5544-584">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5544 / ReservationsDeal CustomerCare</td>
<td class="name" id="name-5544-585">Empty </td>
<td class="desc">585</td>
<td class="duration" id="duration-5544-585">--</td>
<td class="did" id="did-5544-585">--</td>
<td class="clid" id="clid-5544-585">--</td>
<td class="status" id="status-5544-585">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5544-585">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5544 / ReservationsDeal CustomerCare</td>
<td class="name" id="name-5544-586">Empty </td>
<td class="desc">586</td>
<td class="duration" id="duration-5544-586">--</td>
<td class="did" id="did-5544-586">--</td>
<td class="clid" id="clid-5544-586">--</td>
<td class="status" id="status-5544-586">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5544-586">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Travel Spanish</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5505 / Travel Spanish</td>
<td class="name" id="name-5505-587">Empty </td>
<td class="desc">587</td>
<td class="duration" id="duration-5505-587">--</td>
<td class="did" id="did-5505-587">--</td>
<td class="clid" id="clid-5505-587">--</td>
<td class="status" id="status-5505-587">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5505-587">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5505 / Travel Spanish</td>
<td class="name" id="name-5505-588">Empty </td>
<td class="desc">588</td>
<td class="duration" id="duration-5505-588">--</td>
<td class="did" id="did-5505-588">--</td>
<td class="clid" id="clid-5505-588">--</td>
<td class="status" id="status-5505-588">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5505-588">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5505 / Travel Spanish</td>
<td class="name" id="name-5505-589">Empty </td>
<td class="desc">589</td>
<td class="duration" id="duration-5505-589">--</td>
<td class="did" id="did-5505-589">--</td>
<td class="clid" id="clid-5505-589">--</td>
<td class="status" id="status-5505-589">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5505-589">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5505 / Travel Spanish</td>
<td class="name" id="name-5505-590">Empty </td>
<td class="desc">590</td>
<td class="duration" id="duration-5505-590">--</td>
<td class="did" id="did-5505-590">--</td>
<td class="clid" id="clid-5505-590">--</td>
<td class="status" id="status-5505-590">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5505-590">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5505 / Travel Spanish</td>
<td class="name" id="name-5505-591">Empty </td>
<td class="desc">591</td>
<td class="duration" id="duration-5505-591">--</td>
<td class="did" id="did-5505-591">--</td>
<td class="clid" id="clid-5505-591">--</td>
<td class="status" id="status-5505-591">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5505-591">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5505 / Travel Spanish</td>
<td class="name" id="name-5505-592">Empty </td>
<td class="desc">592</td>
<td class="duration" id="duration-5505-592">--</td>
<td class="did" id="did-5505-592">--</td>
<td class="clid" id="clid-5505-592">--</td>
<td class="status" id="status-5505-592">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5505-592">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> BookSavvy</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5520 / BookSavvy</td>
<td class="name" id="name-5520-593">Empty </td>
<td class="desc">593</td>
<td class="duration" id="duration-5520-593">--</td>
<td class="did" id="did-5520-593">--</td>
<td class="clid" id="clid-5520-593">--</td>
<td class="status" id="status-5520-593">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5520-593">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Airlines</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-573">AirLine_1 </td>
<td class="desc">573</td>
<td class="duration" id="duration-4551-573">--</td>
<td class="did" id="did-4551-573">--</td>
<td class="clid" id="clid-4551-573">--</td>
<td class="status" id="status-4551-573">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-573">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-604">Empty </td>
<td class="desc">604</td>
<td class="duration" id="duration-4551-604">--</td>
<td class="did" id="did-4551-604">--</td>
<td class="clid" id="clid-4551-604">--</td>
<td class="status" id="status-4551-604">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-604">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-603">Empty </td>
<td class="desc">603</td>
<td class="duration" id="duration-4551-603">--</td>
<td class="did" id="did-4551-603">--</td>
<td class="clid" id="clid-4551-603">--</td>
<td class="status" id="status-4551-603">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-603">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-602">Empty </td>
<td class="desc">602</td>
<td class="duration" id="duration-4551-602">--</td>
<td class="did" id="did-4551-602">--</td>
<td class="clid" id="clid-4551-602">--</td>
<td class="status" id="status-4551-602">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-602">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-601">Empty </td>
<td class="desc">601</td>
<td class="duration" id="duration-4551-601">--</td>
<td class="did" id="did-4551-601">--</td>
<td class="clid" id="clid-4551-601">--</td>
<td class="status" id="status-4551-601">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-601">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-577">AirLine_5 </td>
<td class="desc">577</td>
<td class="duration" id="duration-4551-577">--</td>
<td class="did" id="did-4551-577">--</td>
<td class="clid" id="clid-4551-577">--</td>
<td class="status" id="status-4551-577">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-577">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-576">AirLine_4 </td>
<td class="desc">576</td>
<td class="duration" id="duration-4551-576">--</td>
<td class="did" id="did-4551-576">--</td>
<td class="clid" id="clid-4551-576">--</td>
<td class="status" id="status-4551-576">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-576">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-575">AirLine_3 </td>
<td class="desc">575</td>
<td class="duration" id="duration-4551-575">--</td>
<td class="did" id="did-4551-575">--</td>
<td class="clid" id="clid-4551-575">--</td>
<td class="status" id="status-4551-575">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-575">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-574">AirLine_2 </td>
<td class="desc">574</td>
<td class="duration" id="duration-4551-574">--</td>
<td class="did" id="did-4551-574">--</td>
<td class="clid" id="clid-4551-574">--</td>
<td class="status" id="status-4551-574">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-574">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>4551 / Airlines</td>
<td class="name" id="name-4551-605">Empty </td>
<td class="desc">605</td>
<td class="duration" id="duration-4551-605">--</td>
<td class="did" id="did-4551-605">--</td>
<td class="clid" id="clid-4551-605">--</td>
<td class="status" id="status-4551-605">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="4551-605">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Cyber Zoom Lab</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Learningua</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> Hiremavens and J&B</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> 6609</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6691">Empty </td>
<td class="desc">6691</td>
<td class="duration" id="duration-6609-6691">--</td>
<td class="did" id="did-6609-6691">--</td>
<td class="clid" id="clid-6609-6691">--</td>
<td class="status" id="status-6609-6691">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6691">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6692">Empty </td>
<td class="desc">6692</td>
<td class="duration" id="duration-6609-6692">--</td>
<td class="did" id="did-6609-6692">--</td>
<td class="clid" id="clid-6609-6692">--</td>
<td class="status" id="status-6609-6692">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6692">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6693">Empty </td>
<td class="desc">6693</td>
<td class="duration" id="duration-6609-6693">--</td>
<td class="did" id="did-6609-6693">--</td>
<td class="clid" id="clid-6609-6693">--</td>
<td class="status" id="status-6609-6693">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6693">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6694">Empty </td>
<td class="desc">6694</td>
<td class="duration" id="duration-6609-6694">--</td>
<td class="did" id="did-6609-6694">--</td>
<td class="clid" id="clid-6609-6694">--</td>
<td class="status" id="status-6609-6694">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6694">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6695">Empty </td>
<td class="desc">6695</td>
<td class="duration" id="duration-6609-6695">--</td>
<td class="did" id="did-6609-6695">--</td>
<td class="clid" id="clid-6609-6695">--</td>
<td class="status" id="status-6609-6695">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6695">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6696">Empty </td>
<td class="desc">6696</td>
<td class="duration" id="duration-6609-6696">--</td>
<td class="did" id="did-6609-6696">--</td>
<td class="clid" id="clid-6609-6696">--</td>
<td class="status" id="status-6609-6696">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6696">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>6609 / 6609</td>
<td class="name" id="name-6609-6697">Empty </td>
<td class="desc">6697</td>
<td class="duration" id="duration-6609-6697">--</td>
<td class="did" id="did-6609-6697">--</td>
<td class="clid" id="clid-6609-6697">--</td>
<td class="status" id="status-6609-6697">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="6609-6697">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
    <h4 class="table_title accord_icon queueHeading"><i class="fa fa-chevron-down" aria-hidden="true"></i> SingleIVR</h4>
<table class="table manage_queue_table queue_agents">
<thead>
<tr>
<th>Queue Name</th>
<th>Agent's Name</th>
<th>Agent Ext</th>
<th>Duration</th>
<th>DID</th>
<th>CLID</th>
<th>Status</th>
<th>Unpause</th>
</tr>
</thead>
<tbody>

<tr class="spacer"></tr>
<tr class="tr-shadow">
<td>5559 / SingleIVR</td>
<td class="name" id="name-5559-002">Sanjeet </td>
<td class="desc">002</td>
<td class="duration" id="duration-5559-002">--</td>
<td class="did" id="did-5559-002">--</td>
<td class="clid" id="clid-5559-002">--</td>
<td class="status" id="status-5559-002">--</td>

<td>

<div class="table-data-feature">
<label class="switch switch-text switch-success switch-pill">

<input type="checkbox" class="switch-input" name="agentPause" checked="true" data-queuext="5559-002">


<span data-on="On" data-off="Off" class="switch-label"></span>
<span class="switch-handle"></span>
</label>
</div>
</td>
</tr>



</tbody>
</table>
</div>

 
</div>
</div>



</div>
</div>
<?php require_once('footer.php'); ?>
