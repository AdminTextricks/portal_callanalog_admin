<?php require_once('header.php'); ?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<?php if($_SESSION['userroleforpage'] == 1){ ?>
<div class="row">
<div class="col-md-12">
<div class="overview-wrap table_top_heading">
    
<a href="queueadd.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Campaign</button></a>

</div>
</div>
</div>
<?php } ?>


<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
        
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_queue_table'>
                <thead>
                <tr>
                    <th>Campaign Name</th>
                    <th>Campaign Type</th>
                    <th>Disposition</th>
                    <th>Campaign Date</th>
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
                    'url':'campaignajax.php'
                },
                'columns': [
                    { data: 'camp_name' },
                    { data: 'camp_type' },
                    { data: 'disposition' },
                    { data: 'campdate' },
                    { data: 'action' },
                ]
            });
        });
        </script>
		
		<br>
<br>
<br>
<?php require_once('footer.php'); ?> 
 
