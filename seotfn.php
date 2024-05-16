<?php require_once('header.php'); ?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> SEO TFN Information <span style="margin-left:50px;"></span></h2>

<div class="table-data__tool-right">    
<a href="seotfnadd.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Add TFN</button></a>
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
                    <th>TFN</th>
                    <th>Queue</th>
                    <th>Team Name</th>
                    <th>Member Name</th>
                    <th>Status</th>
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
                    'url':'ajaxseotfn.php'
                },
                'columns': [
                    { data: 'serial' },
                    { data: 'tfn' },
                    { data: 'queue' },
                    { data: 'teamname' },
                    { data: 'membername' },
                    { data: 'status' },
                    { data: 'action' },
                ]
            });
        });
        </script>
		
		<br>
<br>
<br>
<?php require_once('footer.php'); ?> 
 
