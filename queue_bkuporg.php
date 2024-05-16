<?php require_once('header.php');  

$query_queue = "select cqt.queue_name as queue_name,cqt.name as name,Client.clientName as clientName, cqt.strategy as strategy, cqt.musicclass as musicclass , cqt.status as status from cc_queue_table cqt left join Client ON cqt.clientid=Client.clientId";
$result = mysqli_query($connection,$query_queue);

?>
<style>
.search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
    }
    .result p:hover{
        background: #f2f2f2;
    }
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function(){
    $('.search-box input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){
            $.get("queue.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();
        }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="overview-wrap table_top_heading">
    
<a href="/addqueue">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Queue</button></a>

</div>
</div>
</div>


<style type="text/css">
.manage_que_mid{width: 100%;background: #ffffff;padding: 20px 15px 20px;}
.manage_que_mid .manage_que_title{font-weight: normal;margin:0 0 15px;}
.agent_table_outer{overflow: auto; max-height:278px; }
.agent_table_outer th { padding:7px 10px; }
.agent_table_outer td { padding:7px 10px; }
.agent_table_outer .item i{font-size:14px !important;}
.add_agent_outer{padding:15px;border:1px solid #ddd;}
.add_agent_outer .manage_queue_table thead tr> th{background: #29a9de;color: #fff;font-family: sans-serif;}
.agent_form_outer select[multiple=multiple] { height:325px }
</style>

<div class="row" id="queueMemberDiv" style="display:none;">
<div class="col-md-12">
	<div class="manage_que_mid">
		<h4 class="manage_que_title">Add Agent</h4>
	
	<div class="add_agent_outer">
	<div class="row">
		
<div class="col-md-6">
<div class="col-xs-12">
	<div class="form-group">
			<label for="queueName" class=" form-control-label">Queue Name</label>
			<input type="text" id="queueName" name="queueName" readonly="true" placeholder="xyz" class="form-control">
			</div>
</div>
 <div class="agent_table_outer">
   <table class="table manage_queue_table table-bordered">
	<thead>
	<tr>
	<th>Queue</th> 
	<th>Extension No</th>
	<th>Priority</th>
	<th>Action</th>
	</tr>
	</thead>
	<tbody id="queueMemberTable">

	</tbody>
	</table>
 </div>
</div>
		
<div class="col-md-6">
	<div class="agent_form_outer">
				<form>
			<div class="form-group">
				<label for="extensionSelect" class=" form-control-label">Assigned Extensions</label>
			<select name="extensionSelect" id="extensionSelect" class="form-control-sm form-control" multiple="multiple">
			
			<option value="202">202</option>
			
			<option value="001">001</option>
			
			<option value="201">201</option>
			
			<option value="304">304</option>
			
			<option value="302">302</option>
			
			<option value="32474">32474</option>
			
			<option value="05484">05484</option>
			
			<option value="301">301</option>
			
			<option value="303">303</option>
			
			<option value="305">305</option>
			
			<option value="306">306</option>
			
			<option value="203">203</option>
			
			<option value="204">204</option>
			
			<option value="205">205</option>
			
			<option value="206">206</option>
			
			<option value="207">207</option>
			
			<option value="69369">69369</option>
			
			<option value="208">208</option>
			
			<option value="209">209</option>
			
			<option value="002">002</option>
			
			<option value="619">619</option>
			
			<option value="003">003</option>
			
			<option value="401">401</option>
			
			<option value="213">213</option>
			
			<option value="601">601</option>
			
			<option value="602">602</option>
			
			<option value="604">604</option>
			
			<option value="605">605</option>
			
			<option value="612">612</option>
			
			<option value="607">607</option>
			
			<option value="609">609</option>
			
			<option value="300">300</option>
			
			<option value="200">200</option>
			
			<option value="211">211</option>
			
			<option value="101">101</option>
			
			<option value="102">102</option>
			
			<option value="103">103</option>
			
			<option value="104">104</option>
			
			<option value="105">105</option>
			
			<option value="623">623</option>
			
			<option value="106">106</option>
			
			<option value="108">108</option>
			
			<option value="882">882</option>
			
			<option value="5002">5002</option>
			
			<option value="5003">5003</option>
			
			<option value="709">709</option>
			
			<option value="004">004</option>
			
			<option value="402">402</option>
			
			<option value="6758587574123131">6758587574123131</option>
			
			<option value="617">617</option>
			
			<option value="212">212</option>
			
			<option value="214">214</option>
			
			<option value="215">215</option>
			
			<option value="221">221</option>
			
			<option value="222">222</option>
			
			<option value="503">503</option>
			
			<option value="109">109</option>
			
			<option value="710">710</option>
			
			<option value="703">703</option>
			
			<option value="705">705</option>
			
			<option value="801">801</option>
			
			<option value="802">802</option>
			
			<option value="803">803</option>
			
			<option value="804">804</option>
			
			<option value="805">805</option>
			
			<option value="806">806</option>
			
			<option value="807">807</option>
			
			<option value="700">700</option>
			
			<option value="800">800</option>
			
			<option value="809">809</option>
			
			<option value="100">100</option>
			
			<option value="707">707</option>
			
			<option value="712">712</option>
			
			<option value="403">403</option>
			
			<option value="404">404</option>
			
			<option value="620">620</option>
			
			<option value="405">405</option>
			
			<option value="406">406</option>
			
			<option value="407">407</option>
			
			<option value="408">408</option>
			
			<option value="409">409</option>
			
			<option value="902">902</option>
			
			<option value="901">901</option>
			
			<option value="900">900</option>
			
			<option value="1101">1101</option>
			
			<option value="502">502</option>
			
			<option value="600">600</option>
			
			<option value="400">400</option>
			
			<option value="500">500</option>
			
			<option value="110">110</option>
			
			<option value="613">613</option>
			
			<option value="616">616</option>
			
			<option value="307">307</option>
			
			<option value="309">309</option>
			
			<option value="308">308</option>
			
			<option value="310">310</option>
			
			<option value="311">311</option>
			
			<option value="501">501</option>
			
			<option value="610">610</option>
			
			<option value="9903">9903</option>
			
			<option value="9904">9904</option>
			
			<option value="9901">9901</option>
			
			<option value="708">708</option>
			
			<option value="614">614</option>
			
			<option value="808">808</option>
			
			<option value="711">711</option>
			
			<option value="508">508</option>
			
			<option value="507">507</option>
			
			<option value="9902">9902</option>
			
			<option value="506">506</option>
			
			<option value="628">628</option>
			
			<option value="622">622</option>
			
			<option value="999991">999991</option>
			
			<option value="615">615</option>
			
			<option value="504">504</option>
			
			<option value="505">505</option>
			
			<option value="45868">45868</option>
			
			<option value="625">625</option>
			
			<option value="666">666</option>
			
			<option value="509">509</option>
			
			<option value="315">315</option>
			
			<option value="316">316</option>
			
			<option value="317">317</option>
			
			<option value="318">318</option>
			
			<option value="319">319</option>
			
			<option value="618">618</option>
			
			<option value="55102">55102</option>
			
			<option value="55101">55101</option>
			
			<option value="883">883</option>
			
			<option value="624">624</option>
			
			<option value="216">216</option>
			
			<option value="814">814</option>
			
			<option value="006">006</option>
			
			<option value="8812">8812</option>
			
			<option value="220">220</option>
			
			<option value="888">888</option>
			
			<option value="621">621</option>
			
			<option value="626">626</option>
			
			<option value="811">811</option>
			
			<option value="217">217</option>
			
			<option value="636">636</option>
			
			<option value="887">887</option>
			
			<option value="813">813</option>
			
			<option value="812">812</option>
			
			<option value="884">884</option>
			
			<option value="22515">22515</option>
			
			<option value="005">005</option>
			
			<option value="111">111</option>
			
			<option value="816">816</option>
			
			<option value="627">627</option>
			
			<option value="815">815</option>
			
			<option value="634">634</option>
			
			<option value="886">886</option>
			
			<option value="113">113</option>
			
			<option value="23160">23160</option>
			
			<option value="632">632</option>
			
			<option value="629">629</option>
			
			<option value="630">630</option>
			
			<option value="112">112</option>
			
			<option value="30864">30864</option>
			
			<option value="881">881</option>
			
			<option value="885">885</option>
			
			<option value="8811">8811</option>
			
			<option value="635">635</option>
			
			<option value="8813">8813</option>
			
			<option value="889">889</option>
			
			<option value="8814">8814</option>
			
			<option value="631">631</option>
			
			<option value="633">633</option>
			
			<option value="218">218</option>
			
			<option value="637">637</option>
			
			</select>
			</div>
			<!-- 
			<div class="form-group">
				<label for="unextensionSelect" class=" form-control-label">UnAssigned Extensions</label>
			<select name="unextensionSelect" id="unextensionSelect" class="form-control-sm form-control" multiple="multiple">
			
			</select>
			</div>
			 -->
			<div class="form-group pull-right">
				 <button type="button" id="saveQueueMember" class="btn btn-primary btn-sm">Submit</button>
				</div>
				<p id="saveQueueMemMsg" style="display:none;"></p>
		</form>
	</div>
</div>
		
	</div>
</div>
	</div>

</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 manage_queue_table_outer custom_table_pagenate">
<div id="queueTable_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="queueTable_length"><label>Show <select name="queueTable_length" aria-controls="queueTable" class=""><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div><div id="queueTable_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="queueTable"></label></div><table id="queueTable" class="table manage_queue_table dataTable no-footer" role="grid" aria-describedby="queueTable_info">
<thead>

<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Serial No: activate to sort column descending" style="width: 79.075px;">Serial No</th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Queue Name: activate to sort column ascending" style="width: 229.4px;">Queue Name</th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Queue Number: activate to sort column ascending" style="width: 128.55px;">Queue Number</th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Company : activate to sort column ascending" style="width: 162.512px;">Company </th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Strategy: activate to sort column ascending" style="width: 85.738px;">Strategy</th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Music Class: activate to sort column ascending" style="width: 103.15px;">Music Class</th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 68.85px;">Status</th><th class="sorting" tabindex="0" aria-controls="queueTable" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 109.925px;">Action</th></tr>
</thead>
<tbody>
<?php $i = 1;

while($row = mysqli_fetch_array($result))
{
	
?>
<tr class="tr-shadow odd" role="row">
<td class="sorting_1"><?php echo $i; ?></td>
<td><?php echo $row['queue_name']; ?></td>
<td> <?php echo $row['name']; ?></td>
<td> <?php echo $row['clientName']; ?></td>
<td class="desc"><?php echo $row['strategy']; ?></td>
<td><?php echo $row['musicclass']; ?></td>
<td>
<span class="<?php if($row['status'] == 'Active') { echo 'status--process'; } else { echo 'inactive_color'; }?>"><?php echo $row['status']; ?></span>
</td>
<td>
<div class="table-data-feature">
<a href="/editqueue/3">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="View">
<i class="fa fa-eye"></i>
</button></a>
<a href="/editqueue/3">
<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
<i class="fa fa-pencil-square-o"></i>
</button></a>
<button onclick="queueMemberShow(' 0001');" class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Manage">
<i class="fa fa-users"></i> 
</button>
</div>
</td>
</tr>
<?php  $i++; } 
    
?>
</tbody>
</table><div class="dataTables_info" id="queueTable_info" role="status" aria-live="polite">Showing 1 to 25 of 25 entries</div><div class="dataTables_paginate paging_simple_numbers" id="queueTable_paginate"><a class="paginate_button previous disabled" aria-controls="queueTable" data-dt-idx="0" tabindex="-1" id="queueTable_previous">Previous</a><span><a class="paginate_button current" aria-controls="queueTable" data-dt-idx="1" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="queueTable" data-dt-idx="2" tabindex="-1" id="queueTable_next">Next</a></div></div>
</div>
</div>
</div>



</div>
</div>
</div>

<?php require_once('footer.php'); ?>