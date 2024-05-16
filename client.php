<?php require_once('header.php'); ?>

<div class="main-content">
<div class="section__content section__content--p30 page_mid">
<div class="container-fluid">

<div class="row">
<div class="col-md-12">
<div class="overview-wrap">
<h2 class="title-1"> Client Information <span style="margin-left:50px;"></span></h2>

<div class="table-data__tool-right">    
<a href="clientadd.php">
<button class="au-btn au-btn-icon au-btn--blue">
<i class="fa fa-plus-circle"></i>Client Add</button></a>
</div>

</div>
</div>
</div>

<?php
if(isset($_SESSION['msg']) && $_SESSION['msg'] != ''){
    echo "<div class='text-center bg-light' style='background:lightblue; padding:5px;'><h3 class='text-white'>".$_SESSION['msg']."</h3></div>";
    unset($_SESSION['msg']);
}
?>
<div class="row">
<div class="col-md-12">

 <div class="table-responsive table-responsive-data2 big_live_dtl manage_queue_table_outer">
        
            <!-- Table -->
            <table id='empTable' class='display dataTable table manage_queue_table style="width: 0px;"'>
                <thead>
                <tr>
                    
                    <th>Name</th>
                    <th>Email</th>
                    <th>Email Password</th>
                    <th>Host</th>
                    <th>Port</th>
                    <th>Date</th>
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
                    'url':'ajaxclient.php'
                },
                'columns': [
					{ data: 'clientName' },
                    { data: 'clientEmail' },
                    { data: 'clientEmailPass' },
                    { data: 'hostName' },
                    { data: 'portNumber' },
                    { data: 'modifyDate' },
                    { data: 'action' },
                ]
            });
        });
        </script>
		
		<br>
<br>
<br>
</div>
    </div>
    </div>
    </div>
	  </div>


      <script>
    function ClientdatadeleteContent(clientId) {
        if(confirm('Are you sure you want to delete this ?')) {
        window.location='clientdata_delete.php?id='+clientId;
        }
    return false;
    }
</script>    
<?php require_once('footer.php'); ?> 
 
