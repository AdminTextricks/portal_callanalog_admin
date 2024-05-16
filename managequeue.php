<?php require_once('header.php');?>
	
  <body >

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
            <table id='empTable' class='display dataTable'>
                <thead>
                <tr>
					<th>Queue ID</th>
                    <th>Queue Name</th>
                    <th>Queue Number</th>
                    <th>Strategy</th>
                    <th>Music Class</th>
                    <th>Status</th>
                </tr>
                </thead>
                
            </table>
        </div>
        </div>
        </div>
        </div>
        
        <!-- Script -->
        <script>
        $(document).ready(function(){
            $('#empTable').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':'managequeajax.php'
                },
                'columns': [
					{ data: 'id'},                   
                    { data: 'queue_name' },
					{ data: 'name' },
                    { data: 'strategy' },
                    { data: 'musicclass' },
                    { data: 'status' },
                ]
            });
        });
        </script>
        </body>
<?php require_once('footer.php');?> 

