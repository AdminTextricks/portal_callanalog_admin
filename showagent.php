<?php require_once('header.php'); ?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Agent Information <span style="margin-left:50px;"></span></h2>

<div class="table-data__tool-right">    
<a href="addagent.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Add Agent</button></a>
</div>

</div>
</div>
</div>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
        
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_queue_table'>
                <thead>
                <tr>
                    <th>Serial No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Queue</th>
                    <th>Extension</th>
                    <th>Status</th>
                    <th>Instant Call Report</th>
                    <th>Action</th>
                </tr>
                </thead> 
                
            </table>
        </div>
        
        <!-- Script -->
        <script>
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'ajaxshowagent.php'
                },
                'columns': [
                    { data: 'serial' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'queue' },
                    { data: 'ext' },
                    { data: 'status' },
                    { data: 'instantCallMail' },
                    { data: 'action' },
                ]
            });
        });
        </script>
		
		<br>
<br>
<br>
<?php require_once('footer.php'); ?> 
 
